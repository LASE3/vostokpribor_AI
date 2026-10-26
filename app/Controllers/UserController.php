<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Request;
use App\Core\Response;
use App\Middleware\AuthenticationMiddleware;
use App\Middleware\AuthorizationMiddleware;
use App\Services\UserService;

class UserController
{
    private UserService $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function index(Request $request): void
    {
        AuthorizationMiddleware::requireAdmin(true);

        $filters = [
            'search' => $request->query('search'),
            'status' => $request->query('status'),
            'cohort' => $request->query('cohort')
        ];

        $limit = min(100, max(1, (int)$request->query('limit', 50)));
        $offset = max(0, (int)$request->query('offset', 0));

        $result = $this->userService->listStudents($filters, $limit, $offset);
        Response::success($result);
    }

    public function show(Request $request, array $params): void
    {
        $user = AuthenticationMiddleware::handle(true);
        $id = (int)($params['id'] ?? 0);

        // Student can only see their own dossier; Admin can see any
        if ($user['role'] !== 'ADMIN' && (int)$user['id'] !== $id) {
            AuthorizationMiddleware::assertOwnership($id, true);
        }

        $dossier = $this->userService->getStudentDossier($id);
        if (!$dossier) {
            Response::error('User or cadet record not found.', 'NOT_FOUND', 404);
        }

        Response::success($dossier);
    }

    public function store(Request $request): void
    {
        AuthorizationMiddleware::requireAdmin(true);
        $actorId = Auth::id();

        try {
            $student = $this->userService->createStudent($request->body(), $actorId);
            Response::success($student, 'Student account provisioned successfully', 201);
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

        // Only Admin or user themselves can update (and students cannot change their role/status)
        if ($user['role'] !== 'ADMIN' && (int)$user['id'] !== $id) {
            AuthorizationMiddleware::assertOwnership($id, true);
        }

        $body = $request->body();

        // If non-admin, prevent changing status, cohort, or department
        if ($user['role'] !== 'ADMIN') {
            unset($body['status'], $body['cohort'], $body['department'], $body['role']);
        }

        try {
            $updated = $this->userService->updateStudent($id, $body, Auth::id());
            Response::success($updated, 'Cadet account updated successfully');
        } catch (\InvalidArgumentException $e) {
            Response::error($e->getMessage(), 'VALIDATION_ERROR', 422);
        } catch (\Throwable $e) {
            Response::error($e->getMessage(), 'SERVER_ERROR', 500);
        }
    }
}
