<?php

namespace App\Services;

use App\Repositories\TicketRepository;
use App\Repositories\UserRepository;
use App\Core\Logger;
use App\Core\Validator;
use InvalidArgumentException;
use RuntimeException;

class TicketService
{
    private TicketRepository $ticketRepo;
    private UserRepository $userRepo;

    public function __construct()
    {
        $this->ticketRepo = new TicketRepository();
        $this->userRepo = new UserRepository();
    }

    public function listTicketsForUser(int $userId, string $role, array $filters = []): array
    {
        return $this->ticketRepo->listForUser($userId, $role, $filters);
    }

    public function getTicket(int $id, int $userId, string $role): array
    {
        $ticket = $this->ticketRepo->findById($id);
        if (!$ticket) {
            throw new RuntimeException('Ticket work order not found.');
        }

        // Student authorization check: student can only view their own ticket
        if ($role !== 'ADMIN' && (int)$ticket['student_id'] !== $userId) {
            throw new RuntimeException('Access denied. You are not assigned to this work order.');
        }

        $comments = $this->ticketRepo->getComments($id);
        $ticket['comments'] = $comments;

        return $ticket;
    }

    public function createTicket(array $data, int $actorId): array
    {
        $validator = new Validator();
        $valid = $validator->validate($data, [
            'ticket_code' => 'required|string|min:3|max:64',
            'title'       => 'required|string|min:3|max:255',
            'priority'    => 'in:CRITICAL,HIGH,MEDIUM,LOW',
            'status'      => 'in:DRAFT,ASSIGNED,IN_PROGRESS,SUBMITTED,UNDER_REVIEW,APPROVED,CHANGES_REQUESTED,CANCELLED'
        ]);

        if (!$valid) {
            throw new InvalidArgumentException($validator->getFirstError() ?? 'Validation failed');
        }

        if ($this->ticketRepo->findByCode($data['ticket_code'])) {
            throw new InvalidArgumentException('Ticket code already exists.');
        }

        $createData = [
            'ticket_code'         => strtoupper(trim($data['ticket_code'])),
            'scenario_id'         => !empty($data['scenario_id']) ? (int)$data['scenario_id'] : null,
            'title'               => trim($data['title']),
            'description'         => trim($data['description'] ?? ''),
            'priority'            => $data['priority'] ?? 'MEDIUM',
            'status'              => !empty($data['student_id']) ? 'ASSIGNED' : ($data['status'] ?? 'DRAFT'),
            'deadline'            => !empty($data['deadline']) ? $data['deadline'] : null,
            'requirements'        => $data['requirements'] ?? null,
            'acceptance_criteria' => $data['acceptance_criteria'] ?? null,
            'created_by'          => $actorId
        ];

        $ticketId = $this->ticketRepo->create($createData);

        // If student assigned at creation
        if (!empty($data['student_id'])) {
            $this->ticketRepo->assignStudent($ticketId, (int)$data['student_id'], $actorId, $data['assignment_notes'] ?? null);
            $this->ticketRepo->recordStatusHistory($ticketId, null, 'ASSIGNED', $actorId, 'Initial assignment');
        } else {
            $this->ticketRepo->recordStatusHistory($ticketId, null, 'DRAFT', $actorId, 'Work order created');
        }

        Logger::audit('TICKET_CREATED', 'tickets', (string)$ticketId, 'SUCCESS', [
            'code'  => $createData['ticket_code'],
            'title' => $createData['title']
        ], $actorId);

        return $this->ticketRepo->findById($ticketId);
    }

    public function updateTicket(int $id, array $data, int $actorId, string $actorRole): array
    {
        $ticket = $this->ticketRepo->findById($id);
        if (!$ticket) {
            throw new RuntimeException('Ticket not found.');
        }

        // Authorization checks
        if ($actorRole !== 'ADMIN' && (int)$ticket['student_id'] !== $actorId) {
            throw new RuntimeException('Access denied. Not your assigned ticket.');
        }

        $updateData = [];

        // Students can only update status to IN_PROGRESS
        if ($actorRole === 'STUDENT') {
            if (isset($data['status'])) {
                if ($ticket['status'] === 'ASSIGNED' && $data['status'] === 'IN_PROGRESS') {
                    $updateData['status'] = 'IN_PROGRESS';
                } else {
                    throw new InvalidArgumentException('Students can only transition tickets from ASSIGNED to IN_PROGRESS.');
                }
            }
        } else {
            // Admin can update metadata and status
            foreach (['title', 'description', 'priority', 'status', 'deadline', 'requirements', 'acceptance_criteria', 'scenario_id'] as $f) {
                if (array_key_exists($f, $data)) {
                    $updateData[$f] = $data[$f];
                }
            }
        }

        if (isset($updateData['status']) && $updateData['status'] !== $ticket['status']) {
            $this->ticketRepo->recordStatusHistory($id, $ticket['status'], $updateData['status'], $actorId);
        }

        $this->ticketRepo->update($id, $updateData);

        Logger::audit('TICKET_UPDATED', 'tickets', (string)$id, 'SUCCESS', array_keys($updateData), $actorId);

        return $this->ticketRepo->findById($id);
    }

    public function assignTicket(int $ticketId, int $studentId, int $actorId, ?string $notes = null): void
    {
        $ticket = $this->ticketRepo->findById($ticketId);
        if (!$ticket) {
            throw new RuntimeException('Ticket not found.');
        }

        $student = $this->userRepo->findById($studentId);
        if (!$student || $student['role'] !== 'STUDENT') {
            throw new RuntimeException('Invalid student account for assignment.');
        }

        $this->ticketRepo->assignStudent($ticketId, $studentId, $actorId, $notes);

        if ($ticket['status'] === 'DRAFT') {
            $this->ticketRepo->update($ticketId, ['status' => 'ASSIGNED']);
            $this->ticketRepo->recordStatusHistory($ticketId, 'DRAFT', 'ASSIGNED', $actorId, "Assigned to {$student['full_name']} ({$student['identifier']})");
        } else {
            $this->ticketRepo->recordStatusHistory($ticketId, $ticket['status'], $ticket['status'], $actorId, "Reassigned to {$student['full_name']}");
        }

        Logger::audit('TICKET_ASSIGNED', 'tickets', (string)$ticketId, 'SUCCESS', [
            'student_id'   => $studentId,
            'student_name' => $student['full_name']
        ], $actorId);
    }

    public function addComment(int $ticketId, int $userId, string $comment): array
    {
        $ticket = $this->ticketRepo->findById($ticketId);
        if (!$ticket) {
            throw new RuntimeException('Ticket not found.');
        }

        $cleanComment = trim($comment);
        if ($cleanComment === '') {
            throw new InvalidArgumentException('Comment text cannot be empty.');
        }

        $commentId = $this->ticketRepo->addComment($ticketId, $userId, $cleanComment);

        Logger::audit('TICKET_COMMENT_ADDED', 'tickets', (string)$ticketId, 'SUCCESS', ['comment_id' => $commentId], $userId);

        return [
            'id'         => $commentId,
            'ticket_id'  => $ticketId,
            'user_id'    => $userId,
            'comment'    => $cleanComment,
            'created_at' => date('Y-m-d H:i:s')
        ];
    }
}
