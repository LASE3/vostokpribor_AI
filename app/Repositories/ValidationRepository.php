<?php

namespace App\Repositories;

use App\Core\Database;

class ValidationRepository
{
    public function createRun(array $data): int
    {
        Database::execute(
            "INSERT INTO validation_runs (model_id, model_version_id, requested_by, status, score, checks_passed, checks_total, report_json, created_at, completed_at)
             VALUES (:m_id, :mv_id, :req_by, :status, :score, :passed, :total, :report, NOW(), :comp_at)",
            [
                'm_id'    => $data['model_id'],
                'mv_id'   => $data['model_version_id'],
                'req_by'  => $data['requested_by'],
                'status'  => $data['status'] ?? 'PENDING',
                'score'   => $data['score'] ?? null,
                'passed'  => $data['checks_passed'] ?? 0,
                'total'   => $data['checks_total'] ?? 0,
                'report'  => !empty($data['report_json']) ? json_encode($data['report_json']) : null,
                'comp_at' => !empty($data['completed_at']) ? $data['completed_at'] : null
            ]
        );

        return (int)Database::lastInsertId();
    }

    public function findById(int $id): ?array
    {
        return Database::queryOne(
            "SELECT vr.*, m.name as model_name, m.model_code, m.student_id as model_owner_id, mv.version as model_version, u.full_name as requester_name
             FROM validation_runs vr
             JOIN models m ON vr.model_id = m.id
             JOIN model_versions mv ON vr.model_version_id = mv.id
             JOIN users u ON vr.requested_by = u.id
             WHERE vr.id = :id LIMIT 1",
            ['id' => $id]
        );
    }

    public function listForModel(int $modelId): array
    {
        return Database::query(
            "SELECT vr.*, mv.version as model_version, u.full_name as requester_name
             FROM validation_runs vr
             JOIN model_versions mv ON vr.model_version_id = mv.id
             JOIN users u ON vr.requested_by = u.id
             WHERE vr.model_id = :m_id
             ORDER BY vr.created_at DESC",
            ['m_id' => $modelId]
        );
    }
}

