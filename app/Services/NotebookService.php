<?php
namespace App\Services;

use App\Repositories\NotebookRepository;
use App\Core\Database;
use App\Core\Logger;
use InvalidArgumentException;
use RuntimeException;

class NotebookService
{
    private NotebookRepository $notebookRepo;
    public function __construct() { $this->notebookRepo = new NotebookRepository(); }
    public function listForStudent(int $studentId): array { return $this->notebookRepo->listForStudent($studentId); }

    public function getNotebook(int $id, int $userId, string $role): array
    {
        $notebook = $this->notebookRepo->findById($id);
        if (!$notebook) throw new \App\Core\NotFoundException('Notebook not found.');
        if ($role !== 'ADMIN' && (int)$notebook['student_id'] !== $userId) {
            throw new \App\Core\AccessDeniedException('Notebook not found or access denied.');
        }
        return $notebook;
    }

    private function cells(mixed $cells): array
    {
        if (!is_array($cells) || !array_is_list($cells) || count($cells) > 200) {
            throw new InvalidArgumentException('Cells must be a list of at most 200 cells.');
        }
        $result = [];
        foreach ($cells as $cell) {
            if (!is_array($cell) || !in_array($cell['cell_type'] ?? 'code', ['code', 'markdown'], true) || !is_string($cell['source'] ?? '') || strlen($cell['source'] ?? '') > 262144) {
                throw new InvalidArgumentException('Each cell requires code or markdown type and source of at most 256 KB.');
            }
            // Output and execution metadata are owned by the trusted runner, never the editor.
            $result[] = ['cell_type' => $cell['cell_type'] ?? 'code', 'source' => $cell['source'] ?? ''];
        }
        return $result;
    }

    public function createNotebook(array $data, int $studentId): array
    {
        WorkOwnership::student($studentId);
        if(!is_string($data['title']??''))throw new InvalidArgumentException('Notebook title must be text.');
        $title = trim($data['title'] ?? '');
        if (strlen($title) < 2 || strlen($title) > 255) { throw new InvalidArgumentException('Title must contain 2 to 255 characters.'); }
        $ticketId = WorkOwnership::reference($data['ticket_id']??null,'ticket_id');
        $scenarioId = WorkOwnership::ticket($ticketId, $studentId, WorkOwnership::reference($data['scenario_id']??null,'scenario_id'));
        $code = 'NB-' . strtoupper(bin2hex(random_bytes(8)));
        $cells = $this->cells($data['cells'] ?? []);
        return Database::transaction(function () use ($title, $ticketId, $scenarioId, $studentId, $code, $cells) {
            $scenarioId = WorkOwnership::ticket($ticketId,$studentId,$scenarioId);
            $id = $this->notebookRepo->create(['code' => $code, 'title' => $title, 'student_id' => $studentId, 'ticket_id' => $ticketId, 'scenario_id' => $scenarioId, 'cells' => $cells]);
            Logger::audit('NOTEBOOK_CREATED', 'notebooks', (string)$id, 'SUCCESS', ['code' => $code, 'cell_count' => count($cells)], $studentId);
            return $this->notebookRepo->findById($id);
        });
    }

    public function saveNotebook(int $id, array $data, int $userId, string $role): array
    {
        WorkOwnership::student($userId);
        $this->getNotebook($id, $userId, $role);
        if (!array_key_exists('cells', $data)) { throw new InvalidArgumentException('Cells are required when saving.'); }
        $cells = $this->cells($data['cells']);
        $expectedVersion=array_key_exists('expected_version',$data)?WorkOwnership::reference($data['expected_version'],'expected_version'):null;
        if(array_key_exists('expected_version',$data)&&$expectedVersion===null)throw new InvalidArgumentException('A positive expected_version is required when supplied.');
        return Database::transaction(function () use ($id, $cells, $userId, $expectedVersion) {
            $this->notebookRepo->saveCells($id, $cells, $expectedVersion);
            Logger::audit('NOTEBOOK_SAVED', 'notebooks', (string)$id, 'SUCCESS', ['cell_count' => count($cells)], $userId);
            return $this->notebookRepo->findById($id);
        });
    }
}
