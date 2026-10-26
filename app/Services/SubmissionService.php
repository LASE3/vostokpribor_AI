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
            throw new \App\Core\AccessDeniedException('Access denied. You do not own this submission.');
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

        if (!Database::queryOne("SELECT id FROM users WHERE id=:id AND role='STUDENT' AND status='ACTIVE'", ['id'=>$studentId])) throw new RuntimeException('Active student access required.');
        $ticketId = (int)$data['ticket_id'];
        $ticket = $this->ticketRepo->findById($ticketId);
        if (!$ticket) {
            throw new RuntimeException('Ticket work order not found.');
        }

        if (!Database::queryOne('SELECT id FROM ticket_assignments WHERE ticket_id=:tid AND student_id=:sid', ['tid'=>$ticketId,'sid'=>$studentId])) {
            throw new \App\Core\AccessDeniedException('Access denied. You can only submit deliverables for your assigned ticket.');
        }

        if (!in_array($ticket['status'], ['ASSIGNED','IN_PROGRESS','CHANGES_REQUESTED'], true)) throw new InvalidArgumentException('Ticket is not open for submission.');
        foreach (['model_id'=>'models', 'notebook_id'=>'notebooks'] as $field=>$table) {
            if (!empty($data[$field]) && !Database::queryOne("SELECT id FROM $table WHERE id=:id AND student_id=:sid AND ticket_id=:tid", ['id'=>(int)$data[$field],'sid'=>$studentId,'tid'=>$ticketId])) throw new InvalidArgumentException('Attachment must belong to you and the assigned ticket.');
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
        if (!Database::queryOne("SELECT id FROM users WHERE id=:id AND role='ADMIN' AND status='ACTIVE'", ['id'=>$adminId])) throw new \App\Core\AccessDeniedException('Administrator access required.');
        $sub = $this->subRepo->findById($id);
        if (!$sub) {
            throw new RuntimeException('Submission not found.');
        }

        $decision = strtoupper(trim($data['status'] ?? ''));
        if (!in_array($decision, ['APPROVED', 'CHANGES_REQUESTED', 'REJECTED'])) {
            throw new InvalidArgumentException('Invalid review decision. Permitted: APPROVED, CHANGES_REQUESTED, REJECTED.');
        }

        if (isset($data['total_score']) && (!is_numeric($data['total_score']) || (float)$data['total_score'] < 0 || (float)$data['total_score'] > 100)) throw new InvalidArgumentException('Score must be between 0 and 100.');
        if (!in_array($sub['status'], ['SUBMITTED','UNDER_REVIEW'], true)) throw new InvalidArgumentException('Submission has already been reviewed.');
        $latest = Database::queryOne('SELECT id FROM submissions WHERE ticket_id=:tid AND student_id=:sid ORDER BY iteration DESC LIMIT 1', ['tid'=>$sub['ticket_id'],'sid'=>$sub['student_id']]);
        if ((int)($latest['id'] ?? 0) !== $id) throw new InvalidArgumentException('Review the latest submission iteration.');
        $totalScore = isset($data['total_score']) ? (float)$data['total_score'] : null;

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
