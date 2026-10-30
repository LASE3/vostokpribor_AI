<?php

namespace App\Services;

use App\Repositories\ExecutionRepository;
use App\Repositories\NotebookRepository;
use App\Core\Auth;
use App\Core\Logger;
use App\Core\Database;
use App\Core\Validator;
use InvalidArgumentException;
use RuntimeException;

class ExecutionService
{
    private ExecutionRepository $execRepo;
    private NotebookRepository $notebookRepo;

    public function __construct()
    {
        $this->execRepo = new ExecutionRepository();
        $this->notebookRepo = new NotebookRepository();
    }

    public function submitJob(array $data, int $studentId): array
    {
        $validator = new Validator();
        $valid = $validator->validate($data, [
            'notebook_id'     => 'required|integer',
            'code_to_execute' => 'required|string'
        ]);

        if (!$valid) {
            throw new InvalidArgumentException($validator->getFirstError() ?? 'Validation failed.');
        }

        $notebook = $this->notebookRepo->findById((int)$data['notebook_id']);
        if (!$notebook) {
            throw new RuntimeException('Notebook not found.');
        }

        if ((int)$notebook['student_id'] !== $studentId && Auth::role() !== 'ADMIN') {
            throw new \App\Core\AccessDeniedException('Access denied. You can only execute code in your own notebooks.');
        }

        // A host subprocess is not isolation. No feature flag can enable this
        // path until a separate runner with independent credentials, filesystem,
        // network policy and resource limits has been implemented and verified.
        throw new \DomainException('Execution unavailable: an isolated runner has not been deployed and verified. Notebook code is saved but is not executed.');
    }

    public function getJob(string $uuid, int $userId, string $role): array
    {
        $job = $this->execRepo->findByUuid($uuid);
        if (!$job) {
            throw new RuntimeException('Execution job not found.');
        }

        if ($role !== 'ADMIN' && (int)$job['student_id'] !== $userId) {
            throw new \App\Core\AccessDeniedException('Access denied. You do not own this execution job.');
        }

        return $job;
    }

    public function cancelJob(string $uuid, int $userId, ?string $actorRole = null): void
    {
        $actor = Database::queryOne("SELECT role FROM users WHERE id=:id AND status='ACTIVE'", ['id'=>$userId]);
        if (!$actor || ($actorRole !== null && $actorRole !== $actor['role'])) throw new \App\Core\AccessDeniedException('Active authorized actor required.');
        Database::transaction(function () use ($uuid,$userId,$actor) {
            $job = $this->getJob($uuid,$userId,$actor['role']);
            if ($job['status'] === 'CANCELLED') return;
            if (!in_array($job['status'],['QUEUED','RUNNING'],true)) throw new InvalidArgumentException('Only queued or running jobs may be cancelled.');
            if (!$this->execRepo->cancelJob($uuid,$userId,$actor['role'])) throw new InvalidArgumentException('Job state changed before cancellation.');
            Logger::audit('EXECUTION_JOB_CANCELLED','execution_jobs',$uuid,'SUCCESS',['student_id'=>(int)$job['student_id'],'previous_status'=>$job['status'],'runtime_termination'=>'UNAVAILABLE_NO_VERIFIED_RUNNER'],$userId);
        });
    }
}

