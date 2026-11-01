<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Request;
use App\Core\Response;
use App\Middleware\AuthenticationMiddleware;
use App\Middleware\AuthorizationMiddleware;
use App\Services\ScenarioService;

class ScenarioController
{
    private ScenarioService $scenarioService;

    public function __construct()
    {
        $this->scenarioService = new ScenarioService();
    }

    public function index(Request $request): void
    {
        AuthorizationMiddleware::requireAdmin(true);
        $status = $request->query('status');
        if($status!==null&&!is_string($status))throw new \InvalidArgumentException('Invalid scenario status filter.');
        $scenarios = $this->scenarioService->listAll($status);
        Response::success($scenarios);
    }

    public function show(Request $request, array $params): void
    {
        AuthorizationMiddleware::requireAdmin(true);
        $id = (int)($params['id'] ?? 0);
        try {
            $scenario = $this->scenarioService->getScenario($id);
            Response::success($scenario);
        } catch (\App\Core\AccessDeniedException $e) {
            Response::error($e->getMessage(), 'FORBIDDEN', 403);
        } catch (\App\Core\NotFoundException $e) {
            Response::error($e->getMessage(), 'NOT_FOUND', 404);
        } catch (\Throwable $e) {
            \App\Core\Diagnostic::exception($e); Response::error('The resource could not be loaded.', 'SERVER_ERROR', 500);
        }
    }

    public function store(Request $request): void
    {
        AuthorizationMiddleware::requireAdmin(true);
        try {
            $scenario = $this->scenarioService->createScenario($request->body(), Auth::id());
            Response::success($scenario, 'Scenario created successfully', 201);
        } catch (\App\Core\NotFoundException $e) {
            Response::error($e->getMessage(), 'NOT_FOUND', 404);
        } catch (\InvalidArgumentException $e) {
            Response::error($e->getMessage(), 'VALIDATION_ERROR', 422);
        } catch (\Throwable $e) {
            \App\Core\Diagnostic::exception($e);
            Response::error('The operation could not be completed.', 'SERVER_ERROR', 500);
        }
    }

    public function update(Request $request, array $params): void
    {
        AuthorizationMiddleware::requireAdmin(true);
        $id = (int)($params['id'] ?? 0);
        try {
            $scenario = $this->scenarioService->updateScenario($id, $request->body(), Auth::id());
            Response::success($scenario, 'Scenario updated successfully');
        } catch (\App\Core\NotFoundException $e) {
            Response::error($e->getMessage(), 'NOT_FOUND', 404);
        } catch (\InvalidArgumentException $e) {
            Response::error($e->getMessage(), 'VALIDATION_ERROR', 422);
        } catch (\Throwable $e) {
            if($e instanceof \RuntimeException&&$e->getCode()===409)Response::error($e->getMessage(),'CONFLICT',409);
            \App\Core\Diagnostic::exception($e);
            Response::error('The operation could not be completed.', 'SERVER_ERROR', 500);
        }
    }
}
