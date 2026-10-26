<?php

namespace App\Services;

use App\Repositories\NotebookRepository;
use App\Core\Logger;
use App\Core\Validator;
use InvalidArgumentException;
use RuntimeException;

class NotebookService
{
    private NotebookRepository $notebookRepo;

    public function __construct()
    {
        $this->notebookRepo = new NotebookRepository();
    }

    public function listForStudent(int $studentId): array
    {
        return $this->notebookRepo->listForStudent($studentId);
    }

    public function getNotebook(int $id, int $userId, string $role): array
    {
        $notebook = $this->notebookRepo->findById($id);
        if (!$notebook) {
            throw new RuntimeException('Notebook not found.');
        }

        if ($role !== 'ADMIN' && (int)$notebook['student_id'] !== $userId) {
            throw new RuntimeException('Access denied. You do not own this notebook.');
        }

        return $notebook;
    }

    public function createNotebook(array $data, int $studentId): array
    {
        $validator = new Validator();
        $valid = $validator->validate($data, [
            'title' => 'required|string|min:2|max:255'
        ]);

        if (!$valid) {
            throw new InvalidArgumentException($validator->getFirstError() ?? 'Validation failed.');
        }

        $code = strtoupper(trim($data['code'] ?? 'NB-' . uniqid()));
        if ($this->notebookRepo->findByCode($code)) {
            $code .= '-' . rand(10, 99);
        }

        $createData = [
            'code'        => $code,
            'title'       => trim($data['title']),
            'student_id'  => $studentId,
            'ticket_id'   => !empty($data['ticket_id']) ? (int)$data['ticket_id'] : null,
            'scenario_id' => !empty($data['scenario_id']) ? (int)$data['scenario_id'] : null,
            'cells'       => $data['cells'] ?? null
        ];

        $notebookId = $this->notebookRepo->create($createData);

        Logger::audit('NOTEBOOK_CREATED', 'notebooks', (string)$notebookId, 'SUCCESS', [
            'code'  => $code,
            'title' => $createData['title']
        ], $studentId);

        return $this->notebookRepo->findById($notebookId);
    }

    public function saveNotebook(int $id, array $data, int $userId, string $role): array
    {
        $notebook = $this->getNotebook($id, $userId, $role);

        if (!empty($data['cells']) && is_array($data['cells'])) {
            $this->notebookRepo->saveCells($id, $data['cells']);
        }

        Logger::audit('NOTEBOOK_SAVED', 'notebooks', (string)$id, 'SUCCESS', [
            'cell_count' => count($data['cells'] ?? [])
        ], $userId);

        return $this->notebookRepo->findById($id);
    }
}
