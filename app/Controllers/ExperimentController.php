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
        Response::paginated($this->expService->pageExperiments((int)$user['id'], $request->query()));
    }

    public function show(Request $request, array $params): void
    {
        $user = AuthenticationMiddleware::handle(true);
        try {
            Response::success($this->expService->getExperiment((int)($params['id'] ?? 0), (int)$user['id'], $user['role'], $request->query()));
        } catch (\App\Core\AccessDeniedException $e) {
            Response::error($e->getMessage(), 'NOT_FOUND', 404);
        }
    }

    public function store(Request $request): void
    {
        $user = AuthenticationMiddleware::handle(true);

        try {
            $exp = $this->expService->createExperiment($request->body(), (int)$user['id']);
            Response::success($exp, 'Experiment metadata saved; no code was executed', 201);
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
        $raw=$request->query('experiment_id');
        if($raw!==null && ((!is_string($raw)&&!is_int($raw)) || !preg_match('/^[1-9][0-9]*$/D',(string)$raw))) throw new \InvalidArgumentException('Invalid experiment_id.');
        $expId=$raw===null?null:(int)$raw;
        try { Response::paginated($this->expService->pageRuns((int)$user['id'], $expId, $request->query())); }
        catch (\App\Core\AccessDeniedException $e) { Response::error($e->getMessage(),'NOT_FOUND',404); }
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
