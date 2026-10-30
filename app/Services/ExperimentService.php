<?php

namespace App\Services;

use App\Repositories\ExperimentRepository;
use App\Core\Logger;
use App\Core\Database;
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
        if ($experimentId) $this->getExperiment($experimentId,$studentId,'STUDENT');
        return $this->expRepo->listRuns($studentId, $experimentId);
    }

    public function getExperiment(int $id, int $actorId, string $role): array
    {
        $record = Database::queryOne('SELECT e.*, u.full_name AS student_name, u.identifier AS student_identifier, t.ticket_code FROM experiments e JOIN users u ON u.id=e.student_id LEFT JOIN tickets t ON t.id=e.ticket_id WHERE e.id=:id', ['id'=>$id]);
        if (!$record || ($role !== 'ADMIN' && (int)$record['student_id'] !== $actorId)) throw new \App\Core\AccessDeniedException('Experiment not found or access denied.');
        $record['runs'] = Database::query('SELECT * FROM experiment_runs WHERE experiment_id=:id ORDER BY id DESC', ['id'=>$id]);
        return $record;
    }

    public function createExperiment(array $data, int $studentId): array
    {
        WorkOwnership::student($studentId);
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
        return Database::transaction(function () use ($code,$data,$studentId,$ticketId,$scenarioId) {
        $scenarioId = WorkOwnership::ticket($ticketId,$studentId,$scenarioId);
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
        });
    }

    public function recordRun(array $data, int $studentId): array
    {
        WorkOwnership::student($studentId);
        $validator = new Validator();
        $valid = $validator->validate($data, [
            'experiment_id' => 'required|integer',
            'run_name'      => 'required|string|min:2|max:120'
        ]);

        if (!$valid) {
            throw new InvalidArgumentException($validator->getFirstError() ?? 'Validation failed.');
        }

        $experiment = WorkOwnership::owned('experiments', (int)$data['experiment_id'], $studentId);
        if (!empty($data['notebook_id'])) {
            $notebook = WorkOwnership::owned('notebooks', (int)$data['notebook_id'], $studentId);
            if (($notebook['ticket_id'] ?? null) != ($experiment['ticket_id'] ?? null)) throw new \App\Core\AccessDeniedException('Notebook and experiment must belong to the same ticket.');
        }
        foreach (['parameters','metrics'] as $key) {
            if (isset($data[$key]) && (!is_array($data[$key]) || strlen(json_encode($data[$key], JSON_THROW_ON_ERROR)) > 200000)) throw new InvalidArgumentException('Parameters and user-reported metrics must be JSON objects of at most 200KB.');
        }
        return Database::transaction(function () use ($data, $studentId) {
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
        });
    }
}
