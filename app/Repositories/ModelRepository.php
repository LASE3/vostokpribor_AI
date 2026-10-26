<?php

namespace App\Repositories;

use App\Core\Database;

class ModelRepository
{
    public function listForUser(int $userId, string $role, ?string $status = null): array
    {
        $params = [];
        if ($role === 'ADMIN') {
            $sql = "SELECT m.*, u.full_name as student_name, u.identifier as student_identifier,
                           s.title as scenario_title, t.ticket_code,
                           (SELECT COUNT(*) FROM model_versions mv WHERE mv.model_id = m.id) as versions_count
                    FROM models m
                    JOIN users u ON m.student_id = u.id
                    LEFT JOIN scenarios s ON m.scenario_id = s.id
                    LEFT JOIN tickets t ON m.ticket_id = t.id
                    WHERE 1=1";
        } else {
            $sql = "SELECT m.*, u.full_name as student_name, u.identifier as student_identifier,
                           s.title as scenario_title, t.ticket_code,
                           (SELECT COUNT(*) FROM model_versions mv WHERE mv.model_id = m.id) as versions_count
                    FROM models m
                    JOIN users u ON m.student_id = u.id
                    LEFT JOIN scenarios s ON m.scenario_id = s.id
                    LEFT JOIN tickets t ON m.ticket_id = t.id
                    WHERE m.student_id = :s_id";
            $params['s_id'] = $userId;
        }

        if ($status) {
            $sql .= " AND m.status = :status";
            $params['status'] = $status;
        }

        $sql .= " ORDER BY m.updated_at DESC";
        return Database::query($sql, $params);
    }

    public function findById(int $id): ?array
    {
        $model = Database::queryOne(
            "SELECT m.*, u.full_name as student_name, u.identifier as student_identifier,
                    s.title as scenario_title, t.ticket_code
             FROM models m
             JOIN users u ON m.student_id = u.id
             LEFT JOIN scenarios s ON m.scenario_id = s.id
             LEFT JOIN tickets t ON m.ticket_id = t.id
             WHERE m.id = :id LIMIT 1",
            ['id' => $id]
        );

        if (!$model) {
            return null;
        }

        $versions = Database::query(
            "SELECT * FROM model_versions WHERE model_id = :m_id ORDER BY created_at DESC",
            ['m_id' => $id]
        );
        $model['versions'] = $versions;

        return $model;
    }

    public function findByCode(string $code): ?array
    {
        return Database::queryOne("SELECT * FROM models WHERE model_code = :code LIMIT 1", ['code' => $code]);
    }

    public function create(array $data): int
    {
        Database::execute(
            "INSERT INTO models (model_code, name, framework, student_id, ticket_id, scenario_id, experiment_run_id, current_version, status, description, metadata_json, created_at)
             VALUES (:code, :name, :framework, :s_id, :t_id, :scen_id, :run_id, :ver, :status, :desc, :meta, NOW())",
            [
                'code'       => $data['model_code'],
                'name'       => $data['name'],
                'framework'  => $data['framework'] ?? 'XGBoost 1.7.5',
                's_id'       => $data['student_id'],
                't_id'       => $data['ticket_id'] ?? null,
                'scen_id'    => $data['scenario_id'] ?? null,
                'run_id'     => $data['experiment_run_id'] ?? null,
                'ver'        => $data['current_version'] ?? 'v1.0.0',
                'status'     => $data['status'] ?? 'REGISTERED',
                'desc'       => $data['description'] ?? null,
                'meta'       => !empty($data['metadata_json']) ? json_encode($data['metadata_json']) : null
            ]
        );

        return (int)Database::lastInsertId();
    }

    public function updateStatus(int $id, string $status): void
    {
        Database::execute(
            "UPDATE models SET status = :status, updated_at = NOW() WHERE id = :id",
            ['status' => $status, 'id' => $id]
        );
    }

    public function addVersion(int $modelId, array $data): int
    {
        Database::execute(
            "INSERT INTO model_versions (model_id, version, artifact_path, artifact_format, checksum_sha256, file_size, metrics, status, created_at)
             VALUES (:m_id, :ver, :path, :fmt, :sha, :size, :metrics, :status, NOW())
             ON DUPLICATE KEY UPDATE artifact_path = :path2, metrics = :metrics2, status = :status2",
            [
                'm_id'     => $modelId,
                'ver'      => $data['version'],
                'path'     => $data['artifact_path'],
                'fmt'      => $data['artifact_format'],
                'sha'      => $data['checksum_sha256'],
                'size'     => $data['file_size'],
                'metrics'  => !empty($data['metrics']) ? json_encode($data['metrics']) : null,
                'status'   => $data['status'] ?? 'REGISTERED',
                'path2'    => $data['artifact_path'],
                'metrics2' => !empty($data['metrics']) ? json_encode($data['metrics']) : null,
                'status2'  => $data['status'] ?? 'REGISTERED'
            ]
        );

        $versionId = (int)Database::lastInsertId();
        if ($versionId === 0) {
            $existing = Database::queryOne("SELECT id FROM model_versions WHERE model_id = :mid AND version = :ver LIMIT 1", ['mid' => $modelId, 'ver' => $data['version']]);
            if ($existing) $versionId = (int)$existing['id'];
        }

        Database::execute(
            "UPDATE models SET current_version = :ver, updated_at = NOW() WHERE id = :id",
            ['ver' => $data['version'], 'id' => $modelId]
        );

        return $versionId;
    }

    public function findVersionById(int $versionId): ?array
    {
        return Database::queryOne("SELECT * FROM model_versions WHERE id = :id LIMIT 1", ['id' => $versionId]);
    }
}
