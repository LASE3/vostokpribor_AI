<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Request;
use App\Core\Response;
use App\Middleware\AuthenticationMiddleware;
use App\Services\ExecutionService;

class ExecutionController
{
    private ExecutionService $execService;

    public function __construct()
    {
        $this->execService = new ExecutionService();
    }

    public function store(Request $request): void
    {
        $user = AuthenticationMiddleware::handle(true);

        try {
            $job = $this->execService->submitJob($request->body(), (int)$user['id']);
            Response::success($job, 'Execution job queued for isolated sandbox runner', 202);
        } catch (\App\Core\AccessDeniedException $e) {
            Response::error($e->getMessage(), 'ACCESS_DENIED', 403);
        } catch (\InvalidArgumentException $e) {
            Response::error($e->getMessage(), 'VALIDATION_ERROR', 422);
        } catch (\DomainException $e) {
            Response::error($e->getMessage(), 'EXECUTION_UNAVAILABLE', 503);
        } catch (\Throwable $e) {
            Response::error($e->getMessage(), 'SERVER_ERROR', 500);
        }
    }

    public function show(Request $request, array $params): void
    {
        $user = AuthenticationMiddleware::handle(true);
        $uuid = (string)($params['id'] ?? '');

        try {
            $job = $this->execService->getJob($uuid, (int)$user['id'], $user['role']);
            Response::success($job);
        } catch (\Throwable $e) {
            Response::error($e->getMessage(), 'NOT_FOUND', 404);
        }
    }

    public function cancel(Request $request, array $params): void
    {
        $user = AuthenticationMiddleware::handle(true);
        $uuid = (string)($params['id'] ?? '');

        try {
            $this->execService->cancelJob($uuid, (int)$user['id']);
            Response::success(null, 'Execution job cancelled');
        } catch (\App\Core\AccessDeniedException $e) {
            Response::error($e->getMessage(), 'ACCESS_DENIED', 403);
        } catch (\Throwable $e) {
            Response::error($e->getMessage(), 'SERVER_ERROR', 500);
        }
    }
}
