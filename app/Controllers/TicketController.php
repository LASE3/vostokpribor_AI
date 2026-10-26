<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Request;
use App\Core\Response;
use App\Middleware\AuthenticationMiddleware;
use App\Middleware\AuthorizationMiddleware;
use App\Services\TicketService;

class TicketController
{
    private TicketService $ticketService;

    public function __construct()
    {
        $this->ticketService = new TicketService();
    }

    public function index(Request $request): void
    {
        $user = AuthenticationMiddleware::handle(true);
        $filters = [
            'status'      => $request->query('status'),
            'priority'    => $request->query('priority'),
            'scenario_id' => $request->query('scenario_id'),
            'search'      => $request->query('search')
        ];

        $tickets = $this->ticketService->listTicketsForUser((int)$user['id'], $user['role'], $filters);
        Response::success($tickets);
    }

    public function show(Request $request, array $params): void
    {
        $user = AuthenticationMiddleware::handle(true);
        $id = (int)($params['id'] ?? 0);

        try {
            $ticket = $this->ticketService->getTicket($id, (int)$user['id'], $user['role']);
            Response::success($ticket);
        } catch (\Throwable $e) {
            Response::error($e->getMessage(), 'NOT_FOUND', 404);
        }
    }

    public function store(Request $request): void
    {
        AuthorizationMiddleware::requireAdmin(true);

        try {
            $ticket = $this->ticketService->createTicket($request->body(), Auth::id());
            Response::success($ticket, 'Ticket work order created successfully', 201);
        } catch (\App\Core\AccessDeniedException $e) {
            Response::error($e->getMessage(), 'ACCESS_DENIED', 403);
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

        try {
            $ticket = $this->ticketService->updateTicket($id, $request->body(), (int)$user['id'], $user['role']);
            Response::success($ticket, 'Ticket updated successfully');
        } catch (\App\Core\AccessDeniedException $e) {
            Response::error($e->getMessage(), 'ACCESS_DENIED', 403);
        } catch (\InvalidArgumentException $e) {
            Response::error($e->getMessage(), 'VALIDATION_ERROR', 422);
        } catch (\Throwable $e) {
            Response::error($e->getMessage(), 'SERVER_ERROR', 500);
        }
    }

    public function assign(Request $request, array $params): void
    {
        AuthorizationMiddleware::requireAdmin(true);
        $id = (int)($params['id'] ?? 0);
        $studentId = (int)$request->body('student_id', 0);
        $notes = $request->body('notes');

        if ($studentId <= 0) {
            Response::error('A valid student_id is required.', 'VALIDATION_ERROR', 422);
        }

        try {
            $this->ticketService->assignTicket($id, $studentId, Auth::id(), $notes);
            Response::success(null, 'Ticket assigned to cadet successfully');
        } catch (\Throwable $e) {
            Response::error($e->getMessage(), 'SERVER_ERROR', 500);
        }
    }

    public function addComment(Request $request, array $params): void
    {
        $user = AuthenticationMiddleware::handle(true);
        $id = (int)($params['id'] ?? 0);
        $comment = (string)$request->body('comment', '');

        try {
            $newComment = $this->ticketService->addComment($id, (int)$user['id'], $comment);
            Response::success($newComment, 'Comment posted successfully', 201);
        } catch (\App\Core\AccessDeniedException $e) {
            Response::error($e->getMessage(), 'ACCESS_DENIED', 403);
        } catch (\InvalidArgumentException $e) {
            Response::error($e->getMessage(), 'VALIDATION_ERROR', 422);
        } catch (\Throwable $e) {
            Response::error($e->getMessage(), 'SERVER_ERROR', 500);
        }
    }
}
