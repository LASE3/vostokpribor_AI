<?php

namespace App\Repositories;

use App\Core\Database;

class NotebookRepository
{
    public function listForStudent(int $studentId): array
    {
        return Database::query(
            "SELECT n.*, t.ticket_code, t.title as ticket_title, s.title as scenario_title,
                    (SELECT COUNT(*) FROM notebook_cells nc WHERE nc.notebook_id = n.id) as cells_count
             FROM notebooks n
             LEFT JOIN tickets t ON n.ticket_id = t.id
             LEFT JOIN scenarios s ON n.scenario_id = s.id
             WHERE n.student_id = :s_id
             ORDER BY n.updated_at DESC",
            ['s_id' => $studentId]
        );
    }

    public function findById(int $id): ?array
    {
        $notebook = Database::queryOne(
            "SELECT n.*, t.ticket_code, t.title as ticket_title, s.title as scenario_title, u.full_name as student_name
             FROM notebooks n
             LEFT JOIN tickets t ON n.ticket_id = t.id
             LEFT JOIN scenarios s ON n.scenario_id = s.id
             LEFT JOIN users u ON n.student_id = u.id
             WHERE n.id = :id LIMIT 1",
            ['id' => $id]
        );

        if (!$notebook) {
            return null;
        }

        $cells = Database::query(
            "SELECT * FROM notebook_cells WHERE notebook_id = :n_id ORDER BY cell_order ASC",
            ['n_id' => $id]
        );
        $notebook['cells'] = $cells;

        return $notebook;
    }

    public function findByCode(string $code): ?array
    {
        return Database::queryOne("SELECT * FROM notebooks WHERE code = :code LIMIT 1", ['code' => $code]);
    }

    public function create(array $data): int
    {
        return Database::transaction(function () use ($data) {
            Database::execute(
                "INSERT INTO notebooks (code, title, student_id, ticket_id, scenario_id, version, status, kernel_state, created_at)
                 VALUES (:code, :title, :s_id, :t_id, :scen_id, 1, 'ACTIVE', 'IDLE', NOW())",
                [
                    'code'    => $data['code'],
                    'title'   => $data['title'],
                    's_id'    => $data['student_id'],
                    't_id'    => $data['ticket_id'] ?? null,
                    'scen_id' => $data['scenario_id'] ?? null
                ]
            );

            $notebookId = (int)Database::lastInsertId();

            // Insert initial default cells if provided
            $cells = $data['cells'] ?? [
                [
                    'cell_order' => 0,
                    'cell_type'  => 'markdown',
                    'source'     => "# " . $data['title'] . "\nTelemetry-driven EDA & machine learning model development workspace."
                ],
                [
                    'cell_order' => 1,
                    'cell_type'  => 'code',
                    'source'     => "import sys\nprint(f'VOSTOKPRIBOR ML Kernel initialized on Python {sys.version}')"
                ]
            ];

            foreach ($cells as $idx => $cell) {
                Database::execute(
                    "INSERT INTO notebook_cells (notebook_id, cell_order, cell_type, source, output_text, updated_at)
                     VALUES (:n_id, :order, :type, :src, :out, NOW())",
                    [
                        'n_id'  => $notebookId,
                        'order' => $cell['cell_order'] ?? $idx,
                        'type'  => $cell['cell_type'] ?? 'code',
                        'src'   => $cell['source'] ?? '',
                        'out'   => $cell['output_text'] ?? null
                    ]
                );
            }

            return $notebookId;
        });
    }

    public function saveCells(int $notebookId, array $cells): void
    {
        Database::transaction(function () use ($notebookId, $cells) {
            // Delete existing cells and re-insert in exact order to maintain integrity
            Database::execute("DELETE FROM notebook_cells WHERE notebook_id = :n_id", ['n_id' => $notebookId]);

            foreach ($cells as $idx => $cell) {
                Database::execute(
                    "INSERT INTO notebook_cells (notebook_id, cell_order, cell_type, source, execution_count, output_text, output_error, output_image_path, last_executed_at, updated_at)
                     VALUES (:n_id, :order, :type, :source, :exec_cnt, :out_txt, :out_err, :img, :last_exec, NOW())",
                    [
                        'n_id'      => $notebookId,
                        'order'     => $idx,
                        'type'      => $cell['cell_type'] ?? 'code',
                        'source'    => $cell['source'] ?? '',
                        'exec_cnt'  => $cell['execution_count'] ?? null,
                        'out_txt'   => $cell['output_text'] ?? null,
                        'out_err'   => $cell['output_error'] ?? null,
                        'img'       => $cell['output_image_path'] ?? null,
                        'last_exec' => !empty($cell['last_executed_at']) ? $cell['last_executed_at'] : null
                    ]
                );
            }

            Database::execute(
                "UPDATE notebooks SET version = version + 1, updated_at = NOW() WHERE id = :id",
                ['id' => $notebookId]
            );
        });
    }
}
