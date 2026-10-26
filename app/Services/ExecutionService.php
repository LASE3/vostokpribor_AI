<?php

namespace App\Services;

use App\Repositories\ExecutionRepository;
use App\Repositories\NotebookRepository;
use App\Core\Auth;
use App\Core\Logger;
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
            throw new RuntimeException('Access denied. You can only execute code in your own notebooks.');
        }

        $jobUuid = $this->execRepo->createJob([
            'notebook_id'     => (int)$data['notebook_id'],
            'cell_id'         => !empty($data['cell_id']) ? (int)$data['cell_id'] : null,
            'student_id'      => $studentId,
            'code_to_execute' => $data['code_to_execute']
        ]);

        Logger::audit('EXECUTION_JOB_QUEUED', 'execution_jobs', $jobUuid, 'SUCCESS', [
            'notebook_id' => $data['notebook_id']
        ], $studentId);

        // Trigger worker runner non-blockingly or via single job execution so tests and users receive fast results
        $this->triggerWorkerAsync($jobUuid);

        return $this->execRepo->findByUuid($jobUuid);
    }

    private function triggerWorkerAsync(string $jobUuid): void
    {
        $workerScript = dirname(__DIR__, 2) . '/workers/python_worker.py';
        $python = 'python';

        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            pclose(popen("start /B $python \"$workerScript\" --job \"$jobUuid\" > NUL 2>&1", "r"));
        } else {
            exec("$python \"$workerScript\" --job \"$jobUuid\" > /dev/null 2>&1 &");
        }
    }

    public function getJob(string $uuid, int $userId, string $role): array
    {
        $job = $this->execRepo->findByUuid($uuid);
        if (!$job) {
            throw new RuntimeException('Execution job not found.');
        }

        if ($role !== 'ADMIN' && (int)$job['student_id'] !== $userId) {
            throw new RuntimeException('Access denied. You do not own this execution job.');
        }

        return $job;
    }

    public function cancelJob(string $uuid, int $userId): void
    {
        $success = $this->execRepo->cancelJob($uuid, $userId);
        if (!$success) {
            throw new RuntimeException('Could not cancel execution job. It may have already completed or you are not authorized.');
        }

        Logger::audit('EXECUTION_JOB_CANCELLED', 'execution_jobs', $uuid, 'SUCCESS', [], $userId);
    }
}
