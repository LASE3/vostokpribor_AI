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
        } catch (\App\Core\AccessDeniedException $e) {
            Response::error($e->getMessage(), 'FORBIDDEN', 403);
        } catch (\App\Core\NotFoundException $e) {
            Response::error($e->getMessage(), 'NOT_FOUND', 404);
        } catch (\Throwable $e) {
            error_log($e->getMessage()); Response::error('The resource could not be loaded.', 'SERVER_ERROR', 500);
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
        } catch (\App\Core\NotFoundException $e) {
            Response::error($e->getMessage(), 'NOT_FOUND', 404);
        } catch (\InvalidArgumentException $e) {
            Response::error($e->getMessage(), 'VALIDATION_ERROR', 422);
        } catch (\Throwable $e) {
            error_log($e->getMessage());
            Response::error('The operation could not be completed.', 'SERVER_ERROR', 500);
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
        } catch (\App\Core\NotFoundException $e) {
            Response::error($e->getMessage(), 'NOT_FOUND', 404);
        } catch (\InvalidArgumentException $e) {
            Response::error($e->getMessage(), 'VALIDATION_ERROR', 422);
        } catch (\Throwable $e) {
            error_log($e->getMessage());
            Response::error('The operation could not be completed.', 'SERVER_ERROR', 500);
        }
    }

    public function assign(Request $request, array $params): void
    {
        AuthorizationMiddleware::requireAdmin(true);
        $id = (int)($params['id'] ?? 0);
        $studentId = filter_var($request->body('student_id'), FILTER_VALIDATE_INT);
        $notes = $request->body('notes');
        if ($notes !== null && (!is_string($notes) || strlen($notes)>10000)) Response::error('Invalid assignment notes.','VALIDATION_ERROR',422);

        if ($studentId === false || $studentId <= 0) {
            Response::error('A valid student_id is required.', 'VALIDATION_ERROR', 422);
        }

        try {
            $this->ticketService->assignTicket($id, $studentId, Auth::id(), $notes);
            Response::success(null, 'Ticket assigned to cadet successfully');
        } catch (\App\Core\AccessDeniedException $e) {Response::error($e->getMessage(),'FORBIDDEN',403);
        } catch (\App\Core\NotFoundException $e) {Response::error($e->getMessage(),'NOT_FOUND',404);
        } catch (\InvalidArgumentException $e) {Response::error($e->getMessage(),'VALIDATION_ERROR',422);
        } catch (\Throwable $e) {
            error_log($e->getMessage());
            Response::error('The operation could not be completed.', 'SERVER_ERROR', 500);
        }
    }

    public function addComment(Request $request, array $params): void
    {
        $user = AuthenticationMiddleware::handle(true);
        $id = (int)($params['id'] ?? 0);
        $comment = $request->body('comment', '');
        if(!is_string($comment))Response::error('Comment must be text.','VALIDATION_ERROR',422);

        try {
            $newComment = $this->ticketService->addComment($id, (int)$user['id'], $comment);
            Response::success($newComment, 'Comment posted successfully', 201);
        } catch (\App\Core\AccessDeniedException $e) {
            Response::error($e->getMessage(), 'ACCESS_DENIED', 403);
        } catch (\App\Core\NotFoundException $e) {
            Response::error($e->getMessage(), 'NOT_FOUND', 404);
        } catch (\InvalidArgumentException $e) {
            Response::error($e->getMessage(), 'VALIDATION_ERROR', 422);
        } catch (\Throwable $e) {
            error_log($e->getMessage());
            Response::error('The operation could not be completed.', 'SERVER_ERROR', 500);
        }
    }

    public function comments(Request $request,array $params):void {
        $user=AuthenticationMiddleware::handle(true);
        try {$ticket=$this->ticketService->getTicket((int)$params['id'],(int)$user['id'],$user['role']);Response::success($ticket['comments']);}
        catch (\App\Core\AccessDeniedException $e){Response::error($e->getMessage(),'FORBIDDEN',403);}
        catch (\App\Core\NotFoundException $e){Response::error($e->getMessage(),'NOT_FOUND',404);}
        catch (\Throwable $e){error_log($e->getMessage());Response::error('Operation failed.','SERVER_ERROR',500);}
    }
    public function progress(Request $request,array $params):void {
        $user=AuthenticationMiddleware::handle(true);
        $body=$request->body();
        if(array_diff(array_keys($body),['status','csrf_token']))Response::error('Only status progress is accepted.','VALIDATION_ERROR',422);
        try {Response::success($this->ticketService->updateTicket((int)$params['id'],['status'=>$body['status']??'IN_PROGRESS'],(int)$user['id'],$user['role']));}
        catch (\App\Core\AccessDeniedException $e){Response::error($e->getMessage(),'FORBIDDEN',403);}
        catch (\InvalidArgumentException $e){Response::error($e->getMessage(),'VALIDATION_ERROR',422);}
        catch (\App\Core\NotFoundException $e){Response::error($e->getMessage(),'NOT_FOUND',404);}
        catch (\Throwable $e){error_log($e->getMessage());Response::error('Operation failed.','SERVER_ERROR',500);}
    }
    public function dashboard(Request $request):void {
        $user=AuthenticationMiddleware::handle(true);
        $tickets=$this->ticketService->listTicketsForUser((int)$user['id'],$user['role']);
        $subs=(new \App\Services\SubmissionService())->listSubmissions((int)$user['id'],$user['role']);
        Response::success(['tickets_total'=>count($tickets),'tickets_by_status'=>array_count_values(array_column($tickets,'status')),'submissions_total'=>count($subs),'submissions_by_status'=>array_count_values(array_column($subs,'status')),'guidance'=>(new \App\Services\SocSystemService())->studentGuidance()]);
    }
    public function notifications(Request $request):void {
        $user=AuthenticationMiddleware::handle(true);
        Response::success((new \App\Repositories\TrainingReadRepository())->notifications((int)$user['id']));
    }
}
