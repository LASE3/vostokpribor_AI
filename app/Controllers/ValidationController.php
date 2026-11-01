<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Request;
use App\Core\Response;
use App\Middleware\AuthenticationMiddleware;
use App\Services\ValidationService;

class ValidationController
{
    private ValidationService $valService;

    public function __construct()
    {
        $this->valService = new ValidationService();
    }

    public function index(Request $request): void
    {
        $user = AuthenticationMiddleware::handle(true);
        $raw=$request->query('model_id');
        if($raw!==null && ((!is_string($raw)&&!is_int($raw)) || !preg_match('/^[1-9][0-9]*$/D',(string)$raw))) throw new \InvalidArgumentException('Invalid model_id.');
        Response::paginated($this->valService->pageRuns((int)$user['id'], $user['role'], $raw===null?null:(int)$raw, $request->query()));
    }

    public function store(Request $request): void
    {
        $user = AuthenticationMiddleware::handle(true);
        $modelId = filter_var($request->body('model_id'),FILTER_VALIDATE_INT);
        $modelVersionId = filter_var($request->body('model_version_id'),FILTER_VALIDATE_INT);

        if ($modelId <= 0 || $modelVersionId <= 0) {
            Response::error('model_id and model_version_id are required.', 'VALIDATION_ERROR', 422);
        }

        try {
            $run = $this->valService->runValidation($modelId, $modelVersionId, (int)$user['id']);
            Response::success($run, 'Artifact integrity checked; quality NOT_EVALUATED without a trusted evaluator', 201);
        } catch (\App\Core\NotFoundException $e) {
            Response::error($e->getMessage(),'NOT_FOUND',404);
        } catch (\App\Core\AccessDeniedException $e) {
            Response::error($e->getMessage(), 'ACCESS_DENIED', 403);
        } catch (\InvalidArgumentException $e) {
            Response::error($e->getMessage(), 'VALIDATION_ERROR', 422);
        } catch (\Throwable $e) {
            Response::error($e->getMessage(), 'SERVER_ERROR', 500);
        }
    }

    public function show(Request $request, array $params): void
    {
        $user = AuthenticationMiddleware::handle(true);
        $id = (int)($params['id'] ?? 0);

        try {
            $run = $this->valService->getRun($id, (int)$user['id'], $user['role']);
            Response::success($run);
        } catch (\App\Core\AccessDeniedException $e) {
            Response::error($e->getMessage(),'ACCESS_DENIED',403);
        } catch (\App\Core\NotFoundException $e) {
            Response::error($e->getMessage(),'NOT_FOUND',404);
        } catch (\Throwable $e) {
            Response::error('Validation report storage is unavailable.','SERVER_ERROR',500);
        }
    }
}
