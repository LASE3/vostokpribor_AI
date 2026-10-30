<?php

namespace App\Repositories;

use App\Core\Database;

class SubmissionRepository
{
    public function listForUser(int $userId, string $role, ?string $status = null): array
    {
        $params = [];
        if ($role === 'ADMIN') {
            $sql = "SELECT s.*, t.ticket_code, t.title as ticket_title,
                           u.full_name as student_name, u.identifier as student_identifier, u.cohort,
                           reviewer.full_name as reviewer_name
                    FROM submissions s
                    JOIN tickets t ON s.ticket_id = t.id
                    JOIN users u ON s.student_id = u.id
                    LEFT JOIN users reviewer ON s.reviewed_by = reviewer.id
                    WHERE 1=1";
        } else {
            $sql = "SELECT s.*, t.ticket_code, t.title as ticket_title,
                           u.full_name as student_name, u.identifier as student_identifier, u.cohort,
                           reviewer.full_name as reviewer_name
                    FROM submissions s
                    JOIN tickets t ON s.ticket_id = t.id
                    JOIN users u ON s.student_id = u.id
                    LEFT JOIN users reviewer ON s.reviewed_by = reviewer.id
                    WHERE s.student_id = :s_id";
            $params['s_id'] = $userId;
        }

        if ($status) {
            $sql .= " AND s.status = :status";
            $params['status'] = $status;
        }

        $sql .= " ORDER BY s.created_at DESC";
        return Database::query($sql, $params);
    }

    public function findById(int $id): ?array
    {
        return Database::queryOne(
            "SELECT s.*, t.ticket_code, t.title as ticket_title,
                    u.full_name as student_name, u.identifier as student_identifier, u.cohort,
                    reviewer.full_name as reviewer_name,
                    m.model_code, m.name as model_name,
                    n.code as notebook_code, n.title as notebook_title
             FROM submissions s
             JOIN tickets t ON s.ticket_id = t.id
             JOIN users u ON s.student_id = u.id
             LEFT JOIN users reviewer ON s.reviewed_by = reviewer.id
             LEFT JOIN models m ON s.model_id = m.id
             LEFT JOIN notebooks n ON s.notebook_id = n.id
             WHERE s.id = :id LIMIT 1",
            ['id' => $id]
        );
    }

    public function getNextIteration(int $ticketId, int $studentId): int
    {
        $res = Database::queryOne(
            "SELECT MAX(iteration) as max_iter FROM submissions WHERE ticket_id = :t_id AND student_id = :s_id",
            ['t_id' => $ticketId, 's_id' => $studentId]
        );
        return ((int)($res['max_iter'] ?? 0)) + 1;
    }

    public function create(array $data): int
    {
        Database::execute(
            "INSERT INTO submissions (submission_code, ticket_id, student_id, iteration, notes, model_id, notebook_id, request_key, status, created_at)
             VALUES (:code, :t_id, :s_id, :iter, :notes, :m_id, :n_id, :request_key, 'SUBMITTED', NOW())",
            [
                'code'  => $data['submission_code'],
                't_id'  => $data['ticket_id'],
                's_id'  => $data['student_id'],
                'iter'  => $data['iteration'],
                'notes' => $data['notes'] ?? null,
                'm_id'  => $data['model_id'] ?? null,
                'n_id'  => $data['notebook_id'] ?? null,
                'request_key' => $data['request_key'] ?? null
            ]
        );

        return (int)Database::lastInsertId();
    }

    public function review(int $id, array $data): void
    {
        Database::execute(
            "UPDATE submissions 
             SET status = :status, rubric_scores = :scores, total_score = :total, 
                 feedback = :feedback, reviewed_by = :reviewer, reviewed_at = NOW(), updated_at = NOW()
             WHERE id = :id",
            [
                'status'   => $data['status'],
                'scores'   => !empty($data['rubric_scores']) ? json_encode($data['rubric_scores']) : null,
                'total'    => $data['total_score'] ?? null,
                'feedback' => $data['feedback'] ?? null,
                'reviewer' => $data['reviewed_by'],
                'id'       => $id
            ]
        );
    }
}
