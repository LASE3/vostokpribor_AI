<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Request;
use App\Core\Response;
use App\Middleware\AuthenticationMiddleware;
use App\Services\NotebookService;

class NotebookController
{
    private NotebookService $notebookService;

    public function __construct()
    {
        $this->notebookService = new NotebookService();
    }

    public function index(Request $request): void
    {
        $user = AuthenticationMiddleware::handle(true);
        $notebooks = $this->notebookService->listForStudent((int)$user['id']);
        Response::success($notebooks);
    }

    public function show(Request $request, array $params): void
    {
        $user = AuthenticationMiddleware::handle(true);
        $id = (int)($params['id'] ?? 0);

        try {
            $notebook = $this->notebookService->getNotebook($id, (int)$user['id'], $user['role']);
            Response::success($notebook);
        } catch (\Throwable $e) {
            Response::error($e->getMessage(), 'NOT_FOUND', 404);
        }
    }

    public function store(Request $request): void
    {
        $user = AuthenticationMiddleware::handle(true);

        try {
            $notebook = $this->notebookService->createNotebook($request->body(), (int)$user['id']);
            Response::success($notebook, 'Notebook created successfully', 201);
        } catch (\InvalidArgumentException $e) {
            Response::error($e->getMessage(), 'VALIDATION_ERROR', 422);
        } catch (\Throwable $e) {
            Response::error($e->getMessage(), 'SERVER_ERROR', 500);
        }
    }

    public function update(Request $request, array $params): void
    {
        $user = AuthenticationMiddleware::handle(true);
        $id = (int)($params['id'] ?? 0);

        try {
            $notebook = $this->notebookService->saveNotebook($id, $request->body(), (int)$user['id'], $user['role']);
            Response::success($notebook, 'Notebook cells persisted successfully');
        } catch (\Throwable $e) {
            Response::error($e->getMessage(), 'SERVER_ERROR', 500);
        }
    }
}
