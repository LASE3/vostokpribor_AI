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
        Response::paginated($this->notebookService->pageForStudent((int)$user['id'], $request->query()));
    }

    public function export(Request $request, array $params): void
    {
        $user = AuthenticationMiddleware::handle(true);
        try {
            $document = $this->notebookService->exportDocument((int)($params['id'] ?? 0),(int)$user['id'],$user['role']);
            header('Content-Type: application/x-ipynb+json; charset=utf-8');
            header('Content-Disposition: attachment; filename="'.$document['filename'].'"');
            header('Cache-Control: no-store');
            header('X-Content-Type-Options: nosniff');
            echo $document['content']; exit;
        } catch (\App\Core\AccessDeniedException|\App\Core\NotFoundException $e) { Response::error('Notebook not found.','NOT_FOUND',404); }
        catch (\InvalidArgumentException $e) { Response::error($e->getMessage(),'VALIDATION_ERROR',422); }
    }

    public function import(Request $request): void
    {
        $user = AuthenticationMiddleware::handle(true);
        try {
            $created = $this->notebookService->importDocument($_FILES['notebook_file'] ?? [],$request->body(),(int)$user['id']);
            Response::success($created,'Notebook code imported into a new notebook. Outputs discarded; no execution or quality is verified.',201);
        } catch (\App\Core\AccessDeniedException $e) { Response::error($e->getMessage(),'ACCESS_DENIED',403); }
        catch (\InvalidArgumentException $e) { Response::error($e->getMessage(),'VALIDATION_ERROR',422); }
    }

    public function show(Request $request, array $params): void
    {
        $user = AuthenticationMiddleware::handle(true);
        $id = (int)($params['id'] ?? 0);

        try {
            $notebook = $this->notebookService->getNotebook($id, (int)$user['id'], $user['role']);
            Response::success($notebook);
        } catch (\App\Core\AccessDeniedException|\App\Core\NotFoundException $e) {
            Response::error($e->getMessage(), 'NOT_FOUND', 404);
        } catch (\Throwable $e) {
            Response::error('Notebook storage is unavailable.','SERVER_ERROR',500);
        }
    }

    public function store(Request $request): void
    {
        $user = AuthenticationMiddleware::handle(true);

        try {
            $notebook = $this->notebookService->createNotebook($request->body(), (int)$user['id']);
            Response::success($notebook, 'Notebook created successfully', 201);
        } catch (\App\Core\AccessDeniedException $e) {
            Response::error($e->getMessage(), 'ACCESS_DENIED', 403);
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
        } catch (\App\Core\NotFoundException $e) {
            Response::error($e->getMessage(),'NOT_FOUND',404);
        } catch (\App\Core\AccessDeniedException $e) {
            Response::error($e->getMessage(), 'ACCESS_DENIED', 403);
        } catch (\InvalidArgumentException $e) {
            Response::error($e->getMessage(), 'VALIDATION_ERROR', 422);
        } catch (\Throwable $e) {
            if($e instanceof \RuntimeException&&$e->getCode()===409)Response::error($e->getMessage(),'CONFLICT',409);
            Response::error($e->getMessage(), 'SERVER_ERROR', 500);
        }
    }
}
