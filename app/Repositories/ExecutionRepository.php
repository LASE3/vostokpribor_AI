<?php

namespace App\Repositories;

use App\Core\Database;
use App\Core\Auth;

class ExecutionRepository
{
    public function createJob(array $data): string
    {
        $jobUuid = 'JOB-' . strtoupper(bin2hex(random_bytes(6)));

        Database::execute(
            "INSERT INTO execution_jobs (job_uuid, notebook_id, cell_id, student_id, status, code_to_execute, created_at)
             VALUES (:uuid, :n_id, :c_id, :s_id, 'QUEUED', :code, NOW())",
            [
                'uuid' => $jobUuid,
                'n_id' => $data['notebook_id'],
                'c_id' => $data['cell_id'] ?? null,
                's_id' => $data['student_id'],
                'code' => $data['code_to_execute']
            ]
        );

        return $jobUuid;
    }

    public function findByUuid(string $uuid): ?array
    {
        return Database::queryOne(
            "SELECT ej.*, n.title as notebook_title, u.full_name as student_name
             FROM execution_jobs ej
             JOIN notebooks n ON ej.notebook_id = n.id
             JOIN users u ON ej.student_id = u.id
             WHERE ej.job_uuid = :uuid LIMIT 1",
            ['uuid' => $uuid]
        );
    }

    public function cancelJob(string $uuid, int $userId): bool
    {
        $job = $this->findByUuid($uuid);
        if (!$job || ($job['student_id'] != $userId && Auth::role() !== 'ADMIN')) {
            return false;
        }

        if (in_array($job['status'], ['COMPLETED', 'FAILED', 'CANCELLED'])) {
            return false;
        }

        $changed = Database::execute(
            "UPDATE execution_jobs SET status = 'CANCELLED', completed_at = NOW() WHERE job_uuid = :uuid AND status IN ('QUEUED', 'RUNNING')",
            ['uuid' => $uuid]
        );
        return $changed === 1;
    }

    public function listRecentForStudent(int $studentId, int $limit = 20): array
    {
        return Database::query(
            "SELECT ej.*, n.title as notebook_title
             FROM execution_jobs ej
             JOIN notebooks n ON ej.notebook_id = n.id
             WHERE ej.student_id = :s_id
             ORDER BY ej.created_at DESC LIMIT " . (int)$limit,
            ['s_id' => $studentId]
        );
    }
}
