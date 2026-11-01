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

        $limit = filter_var($request->query('limit',50),FILTER_VALIDATE_INT);
        $offset = filter_var($request->query('offset',0),FILTER_VALIDATE_INT);
        if($limit===false||$limit<1||$offset===false||$offset<0)throw new \InvalidArgumentException('Invalid pagination.');

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

        $dossier = $this->userService->getStudentDossier($id,$request->query());
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
        } catch (\App\Core\NotFoundException $e) {
            Response::error($e->getMessage(), 'NOT_FOUND', 404);
        } catch (\InvalidArgumentException $e) {
            Response::error($e->getMessage(), 'VALIDATION_ERROR', 422);
        } catch (\Throwable $e) {
            \App\Core\Diagnostic::exception($e);
            Response::error('The operation could not be completed.', 'SERVER_ERROR', 500);
        }
    }
}
