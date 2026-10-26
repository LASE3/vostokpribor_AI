<?php

namespace App\Repositories;

use App\Core\Database;

class ScenarioRepository
{
    public function listAll(?string $status = null): array
    {
        $sql = "SELECT s.*, u.full_name as author_name,
                       (SELECT COUNT(*) FROM tickets t WHERE t.scenario_id = s.id) as tickets_count,
                       (SELECT COUNT(*) FROM datasets d WHERE d.scenario_id = s.id) as datasets_count
                FROM scenarios s
                LEFT JOIN users u ON s.author_id = u.id";
        $params = [];

        if ($status) {
            $sql .= " WHERE s.status = :status";
            $params['status'] = $status;
        }

        $sql .= " ORDER BY s.created_at DESC";
        return Database::query($sql, $params);
    }

    public function findById(int $id): ?array
    {
        return Database::queryOne(
            "SELECT s.*, u.full_name as author_name
             FROM scenarios s
             LEFT JOIN users u ON s.author_id = u.id
             WHERE s.id = :id LIMIT 1",
            ['id' => $id]
        );
    }

    public function findByCode(string $code): ?array
    {
        return Database::queryOne("SELECT * FROM scenarios WHERE code = :code LIMIT 1", ['code' => $code]);
    }

    public function create(array $data): int
    {
        Database::execute(
            "INSERT INTO scenarios (code, title, description, difficulty, department, status, version, objectives, acceptance_criteria, author_id, created_at)
             VALUES (:code, :title, :desc, :diff, :dept, :status, :ver, :obj, :crit, :author, NOW())",
            [
                'code'    => $data['code'],
                'title'   => $data['title'],
                'desc'    => $data['description'] ?? null,
                'diff'    => $data['difficulty'] ?? 'Level 1',
                'dept'    => $data['department'] ?? 'Flight Operations Data Core',
                'status'  => $data['status'] ?? 'DRAFT',
                'ver'     => $data['version'] ?? 'v1.0',
                'obj'     => $data['objectives'] ?? null,
                'crit'    => $data['acceptance_criteria'] ?? null,
                'author'  => $data['author_id']
            ]
        );

        return (int)Database::lastInsertId();
    }

    public function update(int $id, array $data): void
    {
        $fields = [];
        $params = ['id' => $id];

        foreach (['title', 'description', 'difficulty', 'department', 'status', 'version', 'objectives', 'acceptance_criteria'] as $col) {
            if (array_key_exists($col, $data)) {
                $fields[] = "$col = :$col";
                $params[$col] = $data[$col];
            }
        }

        if (!empty($fields)) {
            $sql = "UPDATE scenarios SET " . implode(', ', $fields) . ", updated_at = NOW() WHERE id = :id";
            Database::execute($sql, $params);
        }
    }
}
