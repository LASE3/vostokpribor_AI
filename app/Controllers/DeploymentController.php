<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Request;
use App\Core\Response;
use App\Middleware\AuthenticationMiddleware;
use App\Middleware\AuthorizationMiddleware;
use App\Services\DeploymentService;

class DeploymentController
{
    private DeploymentService $deployService;

    public function __construct()
    {
        $this->deployService = new DeploymentService();
    }

    public function index(Request $request): void
    {
        $user = AuthenticationMiddleware::handle(true);
        $deployments = $this->deployService->listDeployments($user);
        Response::success($deployments);
    }

    public function store(Request $request): void
    {
        $user = AuthenticationMiddleware::handle(true);

        try {
            $deployment = $this->deployService->requestDeployment($request->body(), (int)$user['id']);
            Response::success($deployment, 'Deployment request queued for flight control review', 201);
        } catch (\InvalidArgumentException $e) {
            Response::error($e->getMessage(), 'VALIDATION_ERROR', 422);
        } catch (\Throwable $e) {
            Response::error($e->getMessage(), 'SERVER_ERROR', 500);
        }
    }

    public function update(Request $request, array $params): void
    {
        AuthorizationMiddleware::requireAdmin(true);
        $id = (int)($params['id'] ?? 0);
        $decision = (string)$request->body('status', 'APPROVED');
        $notes = $request->body('notes');
        $traffic = $request->body('canary_percentage') !== null ? (int)$request->body('canary_percentage') : null;

        try {
            $updated = $this->deployService->reviewDeployment($id, $decision, Auth::id(), $notes, $traffic);
            Response::success($updated, 'Deployment decision applied');
        } catch (\InvalidArgumentException $e) {
            Response::error($e->getMessage(), 'VALIDATION_ERROR', 422);
        } catch (\Throwable $e) {
            Response::error($e->getMessage(), 'SERVER_ERROR', 500);
        }
    }
}
