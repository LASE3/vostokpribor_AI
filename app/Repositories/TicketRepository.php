<?php

namespace App\Repositories;

use App\Core\Database;

class TicketRepository
{
    public function listForUser(int $userId, string $role, array $filters = []): array
    {
        $params = [];
        if ($role === 'ADMIN') {
            $sql = "SELECT t.*, s.title as scenario_title, s.code as scenario_code,
                           u.full_name as student_name, u.identifier as student_identifier, u.id as student_id,
                           creator.full_name as creator_name
                    FROM tickets t
                    LEFT JOIN scenarios s ON t.scenario_id = s.id
                    LEFT JOIN ticket_assignments ta ON t.id = ta.ticket_id AND ta.revoked_at IS NULL
                    LEFT JOIN users u ON ta.student_id = u.id
                    LEFT JOIN users creator ON t.created_by = creator.id
                    WHERE 1=1";
        } else {
            // Student: STRICTLY ONLY assigned tickets
            $sql = "SELECT t.*, s.title as scenario_title, s.code as scenario_code,
                           u.full_name as student_name, u.identifier as student_identifier, u.id as student_id,
                           creator.full_name as creator_name
                    FROM tickets t
                    JOIN ticket_assignments ta ON t.id = ta.ticket_id AND ta.revoked_at IS NULL
                    JOIN users u ON ta.student_id = u.id
                    LEFT JOIN scenarios s ON t.scenario_id = s.id
                    LEFT JOIN users creator ON t.created_by = creator.id
                    WHERE ta.student_id = :student_id";
            $params['student_id'] = $userId;
        }

        if (!empty($filters['status'])) {
            $sql .= " AND t.status = :status";
            $params['status'] = $filters['status'];
        }

        if (!empty($filters['priority'])) {
            $sql .= " AND t.priority = :priority";
            $params['priority'] = $filters['priority'];
        }

        if (!empty($filters['scenario_id'])) {
            $sql .= " AND t.scenario_id = :scenario_id";
            $params['scenario_id'] = $filters['scenario_id'];
        }

        if (!empty($filters['search'])) {
            $sql .= " AND (t.ticket_code LIKE :search OR t.title LIKE :search)";
            $params['search'] = '%' . $filters['search'] . '%';
        }

        $sql .= " ORDER BY t.created_at DESC";
        return Database::query($sql, $params);
    }

    public function findById(int $id): ?array
    {
        return Database::queryOne(
            "SELECT t.*, s.title as scenario_title, s.code as scenario_code,
                    u.full_name as student_name, u.identifier as student_identifier, u.id as student_id,
                    creator.full_name as creator_name
             FROM tickets t
             LEFT JOIN scenarios s ON t.scenario_id = s.id
             LEFT JOIN ticket_assignments ta ON t.id = ta.ticket_id AND ta.revoked_at IS NULL
             LEFT JOIN users u ON ta.student_id = u.id
             LEFT JOIN users creator ON t.created_by = creator.id
             WHERE t.id = :id LIMIT 1",
            ['id' => $id]
        );
    }

    public function findByCode(string $code): ?array
    {
        return Database::queryOne("SELECT * FROM tickets WHERE ticket_code = :code LIMIT 1", ['code' => $code]);
    }

    public function create(array $data): int
    {
        Database::execute(
            "INSERT INTO tickets (ticket_code, scenario_id, title, description, priority, status, deadline, requirements, acceptance_criteria, created_by, created_at)
             VALUES (:code, :scenario_id, :title, :desc, :priority, :status, :deadline, :reqs, :crit, :created_by, NOW())",
            [
                'code'        => $data['ticket_code'],
                'scenario_id' => $data['scenario_id'] ?? null,
                'title'       => $data['title'],
                'desc'        => $data['description'] ?? null,
                'priority'    => $data['priority'] ?? 'MEDIUM',
                'status'      => $data['status'] ?? 'DRAFT',
                'deadline'    => $data['deadline'] ?? null,
                'reqs'        => $data['requirements'] ?? null,
                'crit'        => $data['acceptance_criteria'] ?? null,
                'created_by'  => $data['created_by']
            ]
        );

        return (int)Database::lastInsertId();
    }

    public function update(int $id, array $data): void
    {
        $fields = [];
        $params = ['id' => $id];

        foreach (['title', 'description', 'priority', 'status', 'deadline', 'requirements', 'acceptance_criteria', 'scenario_id'] as $col) {
            if (array_key_exists($col, $data)) {
                $fields[] = "$col = :$col";
                $params[$col] = $data[$col];
            }
        }

        if (!empty($fields)) {
            $sql = "UPDATE tickets SET " . implode(', ', $fields) . ", updated_at = NOW() WHERE id = :id";
            Database::execute($sql, $params);
        }
    }

    public function assignStudent(int $ticketId, int $studentId, int $assignedBy, ?string $notes = null): void
    {
        Database::execute("INSERT INTO ticket_assignments (ticket_id,student_id,assigned_by,notes) VALUES (:tid,:sid,:actor,:notes)
            ON DUPLICATE KEY UPDATE assigned_by=VALUES(assigned_by),assigned_at=NOW(),notes=VALUES(notes),revoked_at=NULL,revoked_by=NULL",
            ['tid'=>$ticketId,'sid'=>$studentId,'actor'=>$assignedBy,'notes'=>$notes]);
    }

    public function getComments(int $ticketId): array
    {
        return Database::query(
            "SELECT tc.*, u.full_name as author_name, u.role as author_role, u.identifier as author_identifier
             FROM ticket_comments tc
             JOIN users u ON tc.user_id = u.id
             WHERE tc.ticket_id = :t_id
             ORDER BY tc.created_at ASC",
            ['t_id' => $ticketId]
        );
    }

    public function addComment(int $ticketId, int $userId, string $comment): int
    {
        Database::execute(
            "INSERT INTO ticket_comments (ticket_id, user_id, comment, created_at)
             VALUES (:t_id, :u_id, :comment, NOW())",
            ['t_id' => $ticketId, 'u_id' => $userId, 'comment' => $comment]
        );
        return (int)Database::lastInsertId();
    }

    public function recordStatusHistory(int $ticketId, ?string $oldStatus, string $newStatus, int $changedBy, ?string $notes = null): void
    {
        Database::execute(
            "INSERT INTO ticket_status_history (ticket_id, old_status, new_status, changed_by, notes, created_at)
             VALUES (:t_id, :old, :new, :by, :notes, NOW())",
            [
                't_id'  => $ticketId,
                'old'   => $oldStatus,
                'new'   => $newStatus,
                'by'    => $changedBy,
                'notes' => $notes
            ]
        );
    }
}
