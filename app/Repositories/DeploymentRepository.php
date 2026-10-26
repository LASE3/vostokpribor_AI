<?php

namespace App\Repositories;

use App\Core\Database;

class DeploymentRepository
{
    public function createRequest(array $data): int
    {
        Database::execute(
            "INSERT INTO deployment_requests (model_id, model_version_id, requested_by, environment, canary_percentage, replicas, status, endpoint_url, created_at)
             VALUES (:m_id, :mv_id, :req_by, :env, :canary, :replicas, 'PENDING', :endpoint, NOW())",
            [
                'm_id'     => $data['model_id'],
                'mv_id'    => $data['model_version_id'],
                'req_by'   => $data['requested_by'],
                'env'      => $data['environment'] ?? 'canary',
                'canary'   => $data['canary_percentage'] ?? 10,
                'replicas' => $data['replicas'] ?? 1,
                'endpoint' => $data['endpoint_url'] ?? null
            ]
        );

        return (int)Database::lastInsertId();
    }

    public function listAll(): array
    {
        return Database::query(
            "SELECT dr.*, m.name as model_name, m.model_code, m.framework, mv.version as model_version,
                    u.full_name as requester_name, admin.full_name as admin_name
             FROM deployment_requests dr
             JOIN models m ON dr.model_id = m.id
             JOIN model_versions mv ON dr.model_version_id = mv.id
             JOIN users u ON dr.requested_by = u.id
             LEFT JOIN users admin ON dr.admin_id = admin.id
             ORDER BY dr.created_at DESC"
        );
    }

    public function listForStudent(int $studentId): array
    {
        return Database::query(
            "SELECT dr.*, m.name as model_name, m.model_code, m.framework, mv.version as model_version,
                    u.full_name as requester_name, admin.full_name as admin_name
             FROM deployment_requests dr
             JOIN models m ON dr.model_id = m.id
             JOIN model_versions mv ON dr.model_version_id = mv.id
             JOIN users u ON dr.requested_by = u.id
             LEFT JOIN users admin ON dr.admin_id = admin.id
             WHERE dr.requested_by = :sid
             ORDER BY dr.created_at DESC",
            ['sid' => $studentId]
        );
    }

    public function findById(int $id): ?array
    {
        return Database::queryOne(
            "SELECT dr.*, m.name as model_name, m.model_code, mv.version as model_version
             FROM deployment_requests dr
             JOIN models m ON dr.model_id = m.id
             JOIN model_versions mv ON dr.model_version_id = mv.id
             WHERE dr.id = :id LIMIT 1",
            ['id' => $id]
        );
    }

    public function updateStatus(int $id, string $status, int $adminId, ?string $notes = null, ?int $canaryPercent = null): void
    {
        $fields = ["status = :status", "admin_id = :admin_id", "decision_notes = :notes", "updated_at = NOW()"];
        $params = [
            'status'   => $status,
            'admin_id' => $adminId,
            'notes'    => $notes,
            'id'       => $id
        ];

        if ($canaryPercent !== null) {
            $fields[] = "canary_percentage = :canary";
            $params['canary'] = $canaryPercent;
        }

        $sql = "UPDATE deployment_requests SET " . implode(', ', $fields) . " WHERE id = :id";
        Database::execute($sql, $params);
    }
}
