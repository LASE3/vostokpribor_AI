<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Request;
use App\Core\Response;
use App\Middleware\AuthenticationMiddleware;
use App\Services\ExperimentService;

class ExperimentController
{
    private ExperimentService $expService;

    public function __construct()
    {
        $this->expService = new ExperimentService();
    }

    public function index(Request $request): void
    {
        $user = AuthenticationMiddleware::handle(true);
        $experiments = $this->expService->listExperiments((int)$user['id']);
        Response::success($experiments);
    }

    public function store(Request $request): void
    {
        $user = AuthenticationMiddleware::handle(true);

        try {
            $exp = $this->expService->createExperiment($request->body(), (int)$user['id']);
            Response::success($exp, 'Experiment container created', 201);
        } catch (\App\Core\AccessDeniedException $e) {
            Response::error($e->getMessage(), 'ACCESS_DENIED', 403);
        } catch (\InvalidArgumentException $e) {
            Response::error($e->getMessage(), 'VALIDATION_ERROR', 422);
        } catch (\Throwable $e) {
            Response::error($e->getMessage(), 'SERVER_ERROR', 500);
        }
    }

    public function listRuns(Request $request): void
    {
        $user = AuthenticationMiddleware::handle(true);
        $expId = $request->query('experiment_id') ? (int)$request->query('experiment_id') : null;
        $runs = $this->expService->listRuns((int)$user['id'], $expId);
        Response::success($runs);
    }

    public function storeRun(Request $request): void
    {
        $user = AuthenticationMiddleware::handle(true);

        try {
            $run = $this->expService->recordRun($request->body(), (int)$user['id']);
            Response::success($run, 'Experiment run recorded successfully', 201);
        } catch (\App\Core\AccessDeniedException $e) {
            Response::error($e->getMessage(), 'ACCESS_DENIED', 403);
        } catch (\InvalidArgumentException $e) {
            Response::error($e->getMessage(), 'VALIDATION_ERROR', 422);
        } catch (\Throwable $e) {
            Response::error($e->getMessage(), 'SERVER_ERROR', 500);
        }
    }
}
