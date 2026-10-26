<?php
namespace App\Repositories;

use App\Core\Database;

class NotebookRepository
{
    public function listForStudent(int $studentId): array
    {
        return Database::query('SELECT n.*, t.ticket_code, t.title AS ticket_title, s.title AS scenario_title, (SELECT COUNT(*) FROM notebook_cells nc WHERE nc.notebook_id = n.id) AS cells_count FROM notebooks n LEFT JOIN tickets t ON n.ticket_id = t.id LEFT JOIN scenarios s ON n.scenario_id = s.id WHERE n.student_id = :sid ORDER BY n.updated_at DESC', ['sid' => $studentId]);
    }
    public function findById(int $id): ?array
    {
        $notebook = Database::queryOne('SELECT n.*, t.ticket_code, t.title AS ticket_title, s.title AS scenario_title, u.full_name AS student_name FROM notebooks n LEFT JOIN tickets t ON n.ticket_id = t.id LEFT JOIN scenarios s ON n.scenario_id = s.id JOIN users u ON n.student_id = u.id WHERE n.id = :id', ['id' => $id]);
        if ($notebook) { $notebook['cells'] = Database::query('SELECT * FROM notebook_cells WHERE notebook_id = :id ORDER BY cell_order ASC', ['id' => $id]); }
        return $notebook;
    }
    public function findByCode(string $code): ?array { return Database::queryOne('SELECT * FROM notebooks WHERE code = :code', ['code' => $code]); }
    public function create(array $data): int
    {
        return Database::transaction(function () use ($data) {
            Database::execute("INSERT INTO notebooks (code,title,student_id,ticket_id,scenario_id,status,kernel_state) VALUES (:code,:title,:sid,:tid,:scid,'ACTIVE','UNAVAILABLE')", ['code' => $data['code'], 'title' => $data['title'], 'sid' => $data['student_id'], 'tid' => $data['ticket_id'] ?? null, 'scid' => $data['scenario_id'] ?? null]);
            $id = (int)Database::lastInsertId();
            foreach (($data['cells'] ?? []) as $order => $cell) {
                Database::execute('INSERT INTO notebook_cells (notebook_id,cell_order,cell_type,source) VALUES (:id,:ord,:type,:src)', ['id' => $id, 'ord' => $order, 'type' => $cell['cell_type'], 'src' => $cell['source']]);
            }
            return $id;
        });
    }
    public function saveCells(int $notebookId, array $cells): void
    {
        Database::transaction(function () use ($notebookId, $cells) {
            $notebook = Database::queryOne('SELECT id FROM notebooks WHERE id = :id FOR UPDATE', ['id' => $notebookId]);
            if (!$notebook) { throw new \RuntimeException('Notebook not found.'); }
            $active = Database::queryOne("SELECT id FROM execution_jobs WHERE notebook_id = :id AND status IN ('QUEUED','RUNNING') LIMIT 1", ['id' => $notebookId]);
            if ($active) { throw new \RuntimeException('Cancel the active job before editing cells.'); }
            Database::execute('DELETE FROM notebook_cells WHERE notebook_id = :id', ['id' => $notebookId]);
            foreach ($cells as $order => $cell) {
                Database::execute('INSERT INTO notebook_cells (notebook_id,cell_order,cell_type,source) VALUES (:id,:ord,:type,:src)', ['id' => $notebookId, 'ord' => $order, 'type' => $cell['cell_type'], 'src' => $cell['source']]);
            }
            Database::execute("UPDATE notebooks SET version = version + 1, status = 'SAVED', kernel_state = 'UNAVAILABLE', updated_at = NOW() WHERE id = :id", ['id' => $notebookId]);
        });
    }
}
