<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Request;
use App\Core\Response;
use App\Middleware\AuthenticationMiddleware;
use App\Middleware\AuthorizationMiddleware;
use App\Services\SubmissionService;

class SubmissionController
{
    private SubmissionService $subService;

    public function __construct()
    {
        $this->subService = new SubmissionService();
    }

    public function index(Request $request): void
    {
        $user = AuthenticationMiddleware::handle(true);
        $status = $request->query('status');
        $subs = $this->subService->listSubmissions((int)$user['id'], $user['role'], $status);
        Response::success($subs);
    }

    public function show(Request $request, array $params): void
    {
        $user = AuthenticationMiddleware::handle(true);
        $id = (int)($params['id'] ?? 0);

        try {
            $sub = $this->subService->getSubmission($id, (int)$user['id'], $user['role']);
            Response::success($sub);
        } catch (\Throwable $e) {
            Response::error($e->getMessage(), 'NOT_FOUND', 404);
        }
    }

    public function store(Request $request): void
    {
        $user = AuthenticationMiddleware::handle(true);

        try {
            $sub = $this->subService->createSubmission($request->body(), (int)$user['id']);
            Response::success($sub, 'Deliverable work order submitted for instructor review', 201);
        } catch (\InvalidArgumentException $e) {
            Response::error($e->getMessage(), 'VALIDATION_ERROR', 422);
        } catch (\Throwable $e) {
            Response::error($e->getMessage(), 'SERVER_ERROR', 500);
        }
    }

    public function review(Request $request, array $params): void
    {
        AuthorizationMiddleware::requireAdmin(true);
        $id = (int)($params['id'] ?? 0);

        try {
            $reviewed = $this->subService->reviewSubmission($id, $request->body(), Auth::id());
            Response::success($reviewed, 'Submission evaluated and graded successfully');
        } catch (\InvalidArgumentException $e) {
            Response::error($e->getMessage(), 'VALIDATION_ERROR', 422);
        } catch (\Throwable $e) {
            Response::error($e->getMessage(), 'SERVER_ERROR', 500);
        }
    }
}
