<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Request;
use App\Core\Response;
use App\Middleware\AuthenticationMiddleware;
use App\Services\ModelService;

class ModelController
{
    private ModelService $modelService;

    public function __construct()
    {
        $this->modelService = new ModelService();
    }

    public function index(Request $request): void
    {
        $user = AuthenticationMiddleware::handle(true);
        $status = $request->query('status');
        $models = $this->modelService->listModels((int)$user['id'], $user['role'], $status);
        Response::success($models);
    }

    public function show(Request $request, array $params): void
    {
        $user = AuthenticationMiddleware::handle(true);
        $id = (int)($params['id'] ?? 0);

        try {
            $model = $this->modelService->getModel($id, (int)$user['id'], $user['role']);
            Response::success($model);
        } catch (\Throwable $e) {
            Response::error($e->getMessage(), 'NOT_FOUND', 404);
        }
    }

    public function versions(Request $request, array $params): void
    {
        $user = AuthenticationMiddleware::handle(true);
        try { Response::success($this->modelService->getModel((int)($params['id'] ?? 0), (int)$user['id'], $user['role'])['versions']); }
        catch (\App\Core\AccessDeniedException $e) { Response::error($e->getMessage(), 'NOT_FOUND', 404); }
    }

    public function artifacts(Request $request): void
    {
        $user = AuthenticationMiddleware::handle(true);
        Response::success($this->modelService->listArtifacts((int)$user['id'], $user['role']));
    }

    public function store(Request $request): void
    {
        $user = AuthenticationMiddleware::handle(true);

        try {
            $model = $this->modelService->registerModel($request->body(), (int)$user['id']);
            Response::success($model, 'Model registered successfully', 201);
        } catch (\App\Core\AccessDeniedException $e) {
            Response::error($e->getMessage(), 'ACCESS_DENIED', 403);
        } catch (\InvalidArgumentException $e) {
            Response::error($e->getMessage(), 'VALIDATION_ERROR', 422);
        } catch (\Throwable $e) {
            Response::error($e->getMessage(), 'SERVER_ERROR', 500);
        }
    }

    public function addVersion(Request $request, array $params): void
    {
        $user = AuthenticationMiddleware::handle(true);
        $id = (int)($params['id'] ?? 0);
        $file = $request->file('artifact_file');

        if (!$file) {
            Response::error('Model artifact file is required.', 'VALIDATION_ERROR', 422);
        }

        try {
            $version = $this->modelService->addVersion($id, $file, $request->body(), (int)$user['id'], $user['role']);
            Response::success($version, 'Model version uploaded and committed', 201);
        } catch (\App\Core\AccessDeniedException $e) {
            Response::error($e->getMessage(), 'ACCESS_DENIED', 403);
        } catch (\InvalidArgumentException $e) {
            Response::error($e->getMessage(), 'VALIDATION_ERROR', 422);
        } catch (\Throwable $e) {
            Response::error($e->getMessage(), 'SERVER_ERROR', 500);
        }
    }
}
