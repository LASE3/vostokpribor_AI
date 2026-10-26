<?php

namespace App\Services;

use App\Repositories\ExperimentRepository;
use App\Core\Logger;
use App\Core\Validator;
use InvalidArgumentException;
use RuntimeException;

class ExperimentService
{
    private ExperimentRepository $expRepo;

    public function __construct()
    {
        $this->expRepo = new ExperimentRepository();
    }

    public function listExperiments(int $studentId): array
    {
        return $this->expRepo->listForStudent($studentId);
    }

    public function listRuns(int $studentId, ?int $experimentId = null): array
    {
        return $this->expRepo->listRuns($studentId, $experimentId);
    }

    public function createExperiment(array $data, int $studentId): array
    {
        $validator = new Validator();
        $valid = $validator->validate($data, [
            'name' => 'required|string|min:2|max:255'
        ]);

        if (!$valid) {
            throw new InvalidArgumentException($validator->getFirstError() ?? 'Validation failed.');
        }

        $code = strtoupper(trim($data['code'] ?? 'EXP-' . uniqid()));

        $ticketId = !empty($data['ticket_id']) ? (int)$data['ticket_id'] : null;
        $scenarioId = WorkOwnership::ticket($ticketId, $studentId, !empty($data['scenario_id']) ? (int)$data['scenario_id'] : null);
        $id = $this->expRepo->createExperiment([
            'code'        => $code,
            'name'        => trim($data['name']),
            'student_id'  => $studentId,
            'ticket_id'   => $ticketId,
            'scenario_id' => $scenarioId
        ]);

        Logger::audit('EXPERIMENT_CREATED', 'experiments', (string)$id, 'SUCCESS', ['code' => $code], $studentId);

        return [
            'id'   => $id,
            'code' => $code,
            'name' => $data['name']
        ];
    }

    public function recordRun(array $data, int $studentId): array
    {
        $validator = new Validator();
        $valid = $validator->validate($data, [
            'experiment_id' => 'required|integer',
            'run_name'      => 'required|string|min:2|max:120'
        ]);

        if (!$valid) {
            throw new InvalidArgumentException($validator->getFirstError() ?? 'Validation failed.');
        }

        WorkOwnership::owned('experiments', (int)$data['experiment_id'], $studentId);
        if (!empty($data['notebook_id'])) { WorkOwnership::owned('notebooks', (int)$data['notebook_id'], $studentId); }
        $runUuid = $this->expRepo->recordRun([
            'experiment_id'    => (int)$data['experiment_id'],
            'student_id'       => $studentId,
            'notebook_id'      => !empty($data['notebook_id']) ? (int)$data['notebook_id'] : null,
            'run_name'         => trim($data['run_name']),
            'status'           => 'RECORDED',
            'parameters'       => $data['parameters'] ?? [],
            'metrics'          => $data['metrics'] ?? [],
            'artifacts'        => [],
            'duration_seconds' => null
        ]);

        Logger::audit('EXPERIMENT_RUN_RECORDED', 'experiment_runs', $runUuid, 'SUCCESS', [
            'experiment_id' => $data['experiment_id']
        ], $studentId);

        return [
            'run_uuid' => $runUuid,
            'status'   => 'RECORDED'
        ];
    }
}
