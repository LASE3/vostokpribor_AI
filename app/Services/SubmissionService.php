<?php

namespace App\Services;

use App\Repositories\SubmissionRepository;
use App\Repositories\TicketRepository;
use App\Core\Logger;
use App\Core\Database;
use App\Core\Validator;
use InvalidArgumentException;
use RuntimeException;

class SubmissionService
{
    private SubmissionRepository $subRepo;
    private TicketRepository $ticketRepo;

    public function __construct()
    {
        $this->subRepo = new SubmissionRepository();
        $this->ticketRepo = new TicketRepository();
    }

    public function listSubmissions(int $userId, string $role, ?string $status = null): array
    {
        return $this->subRepo->listForUser($userId, $role, $status);
    }

    public function getSubmission(int $id, int $userId, string $role): array
    {
        $sub = $this->subRepo->findById($id);
        if (!$sub) {
            throw new RuntimeException('Deliverable submission not found.');
        }

        if ($role !== 'ADMIN' && (int)$sub['student_id'] !== $userId) {
            throw new RuntimeException('Access denied. You do not own this submission.');
        }

        return $sub;
    }

    public function createSubmission(array $data, int $studentId): array
    {
        $validator = new Validator();
        $valid = $validator->validate($data, [
            'ticket_id' => 'required|integer'
        ]);

        if (!$valid) {
            throw new InvalidArgumentException($validator->getFirstError() ?? 'Validation failed.');
        }

        $ticketId = (int)$data['ticket_id'];
        $ticket = $this->ticketRepo->findById($ticketId);
        if (!$ticket) {
            throw new RuntimeException('Ticket work order not found.');
        }

        if ((int)$ticket['student_id'] !== $studentId) {
            throw new RuntimeException('Access denied. You can only submit deliverables for your assigned ticket.');
        }

        $iteration = $this->subRepo->getNextIteration($ticketId, $studentId);
        $subCode = 'SUB-' . $ticket['ticket_code'] . '-v' . $iteration;

        $subId = Database::transaction(function () use ($subCode, $ticketId, $studentId, $iteration, $data, $ticket) {
            $id = $this->subRepo->create([
                'submission_code' => $subCode,
                'ticket_id'       => $ticketId,
                'student_id'      => $studentId,
                'iteration'       => $iteration,
                'notes'           => trim($data['notes'] ?? ''),
                'model_id'        => !empty($data['model_id']) ? (int)$data['model_id'] : null,
                'notebook_id'     => !empty($data['notebook_id']) ? (int)$data['notebook_id'] : null
            ]);

            // Update ticket status to SUBMITTED
            $this->ticketRepo->update($ticketId, ['status' => 'SUBMITTED']);
            $this->ticketRepo->recordStatusHistory($ticketId, $ticket['status'], 'SUBMITTED', $studentId, "Deliverable submitted (Iteration #{$iteration})");

            return $id;
        });

        Logger::audit('SUBMISSION_CREATED', 'submissions', (string)$subId, 'SUCCESS', [
            'code'      => $subCode,
            'ticket_id' => $ticketId,
            'iteration' => $iteration
        ], $studentId);

        return $this->subRepo->findById($subId);
    }

    public function reviewSubmission(int $id, array $data, int $adminId): array
    {
        $sub = $this->subRepo->findById($id);
        if (!$sub) {
            throw new RuntimeException('Submission not found.');
        }

        $decision = strtoupper(trim($data['status'] ?? ''));
        if (!in_array($decision, ['APPROVED', 'CHANGES_REQUESTED', 'REJECTED'])) {
            throw new InvalidArgumentException('Invalid review decision. Permitted: APPROVED, CHANGES_REQUESTED, REJECTED.');
        }

        $totalScore = isset($data['total_score']) ? (int)$data['total_score'] : null;

        Database::transaction(function () use ($id, $decision, $data, $totalScore, $adminId, $sub) {
            $this->subRepo->review($id, [
                'status'        => $decision,
                'rubric_scores' => $data['rubric_scores'] ?? null,
                'total_score'   => $totalScore,
                'feedback'      => trim($data['feedback'] ?? ''),
                'reviewed_by'   => $adminId
            ]);

            // Update associated ticket status
            $ticketStatus = ($decision === 'APPROVED') ? 'APPROVED' : 'CHANGES_REQUESTED';
            $this->ticketRepo->update((int)$sub['ticket_id'], ['status' => $ticketStatus]);
            $this->ticketRepo->recordStatusHistory(
                (int)$sub['ticket_id'],
                'SUBMITTED',
                $ticketStatus,
                $adminId,
                "Submission #{$sub['submission_code']} reviewed: {$decision}" . ($totalScore !== null ? " (Score: {$totalScore}/100)" : '')
            );

            // Send notification to cadet
            Database::execute(
                "INSERT INTO notifications (user_id, title, message, type, link, created_at)
                 VALUES (:u_id, :title, :msg, :type, :link, NOW())",
                [
                    'u_id'  => $sub['student_id'],
                    'title' => "Work Order Review: {$sub['ticket_code']}",
                    'msg'   => "Your submission #{$sub['submission_code']} was evaluated: {$decision}." . ($totalScore !== null ? " Final Score: {$totalScore}/100." : ''),
                    'type'  => $decision === 'APPROVED' ? 'SUCCESS' : 'WARNING',
                    'link'  => "/vostokpribor_AI/AI Project Management/Submissions.php"
                ]
            );
        });

        Logger::audit('SUBMISSION_REVIEWED', 'submissions', (string)$id, 'SUCCESS', [
            'decision' => $decision,
            'score'    => $totalScore
        ], $adminId);

        return $this->subRepo->findById($id);
    }
}
