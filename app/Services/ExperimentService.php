<?php

namespace App\Services;

use App\Repositories\ExperimentRepository;
use App\Core\Logger;
use App\Core\Database;
use App\Core\Pagination;
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

    public function listExperiments(int $studentId, array $paging = []): array { return $this->expRepo->listForStudent($studentId,$paging); }
    public function pageExperiments(int $studentId, array $paging = []): array { return $this->expRepo->pageForStudent($studentId,$paging); }
    public function listRuns(int $studentId, ?int $experimentId = null, array $paging = []): array { return $this->pageRuns($studentId,$experimentId,$paging)['items']; }
    public function pageRuns(int $studentId, ?int $experimentId = null, array $paging = []): array
    {
        if ($experimentId !== null) WorkOwnership::owned('experiments',$experimentId,$studentId);
        return $this->expRepo->pageRuns($studentId,$experimentId,$paging);
    }

    public function getExperiment(int $id, int $actorId, string $role, array $runPaging = []): array
    {
        $record = Database::queryOne('SELECT e.*, u.full_name AS student_name, u.identifier AS student_identifier, t.ticket_code FROM experiments e JOIN users u ON u.id=e.student_id LEFT JOIN tickets t ON t.id=e.ticket_id WHERE e.id=:id', ['id'=>$id]);
        if (!$record || ($role !== 'ADMIN' && (int)$record['student_id'] !== $actorId)) throw new \App\Core\AccessDeniedException('Experiment not found or access denied.');
        $page=Pagination::query('SELECT * FROM experiment_runs WHERE experiment_id=:id ORDER BY id DESC',['id'=>$id],$runPaging, 'SELECT COUNT(*) AS total FROM experiment_runs WHERE experiment_id=:id');
        $record['runs'] = array_map([ExperimentRepository::class,'withProvenance'],$page['items']);
        $record['runs_pagination'] = Pagination::metadata($page);
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

        if(isset($data['code'])&&!is_string($data['code']))throw new InvalidArgumentException('Experiment code must be text.');
        $code = strtoupper(trim($data['code'] ?? 'EXP-' . uniqid()));
        if(!preg_match('/^[A-Z0-9][A-Z0-9_.-]{2,63}$/D',$code))throw new InvalidArgumentException('Invalid experiment code.');

        $ticketId = WorkOwnership::reference($data['ticket_id']??null,'ticket_id');
        $scenarioId = WorkOwnership::ticket($ticketId, $studentId, WorkOwnership::reference($data['scenario_id']??null,'scenario_id'));
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

        $experimentId=WorkOwnership::reference($data['experiment_id'],'experiment_id');
        $notebookId=WorkOwnership::reference($data['notebook_id']??null,'notebook_id');
        $experiment = WorkOwnership::owned('experiments', $experimentId, $studentId);
        if ($notebookId) {
            $notebook = WorkOwnership::owned('notebooks', $notebookId, $studentId);
            if (($notebook['ticket_id'] ?? null) != ($experiment['ticket_id'] ?? null)) throw new \App\Core\AccessDeniedException('Notebook and experiment must belong to the same ticket.');
        }
        $datasetVersionId=WorkOwnership::reference($data['dataset_version_id']??null,'dataset_version_id');
        $authorizeDataset=function()use($datasetVersionId,$studentId,$experiment):void {
            if($datasetVersionId===null)return;
            $version=Database::queryOne('SELECT id,dataset_id FROM dataset_versions WHERE id=:id',['id'=>$datasetVersionId]);
            if(!$version || empty($experiment['ticket_id']) || !(new \App\Repositories\DatasetRepository())->authorizedVersion((int)$version['dataset_id'],$studentId,$datasetVersionId,(int)$experiment['ticket_id'])) {
                throw new \App\Core\AccessDeniedException('Dataset version must be actively assigned to this student and experiment ticket.');
            }
        };
        $authorizeDataset();
        foreach (['parameters','metrics'] as $key) {
            if (isset($data[$key]) && (!is_array($data[$key]) || strlen(json_encode($data[$key], JSON_THROW_ON_ERROR)) > 200000)) throw new InvalidArgumentException('Parameters and user-reported metrics must be JSON objects of at most 200KB.');
        }
        return Database::transaction(function () use ($data, $studentId, $datasetVersionId, $authorizeDataset) {
        $authorizeDataset();
        $runUuid = $this->expRepo->recordRun([
            'experiment_id'    => (int)$data['experiment_id'],
            'student_id'       => $studentId,
            'notebook_id'      => !empty($data['notebook_id']) ? (int)$data['notebook_id'] : null,
            'dataset_version_id' => $datasetVersionId,
            'run_name'         => trim($data['run_name']),
            'status'           => 'RECORDED',
            'parameters'       => $data['parameters'] ?? [],
            'metrics'          => $data['metrics'] ?? [],
            'artifacts'        => [],
            'duration_seconds' => null
        ]);

        Logger::audit('EXPERIMENT_RUN_RECORDED', 'experiment_runs', $runUuid, 'SUCCESS', [
            'experiment_id' => $data['experiment_id'],
            'dataset_version_id' => $datasetVersionId,
            'measurement_source' => 'USER_REPORTED'
        ], $studentId);

        return [
            'run_uuid' => $runUuid,
            'status'   => 'RECORDED',
            'measurement_source' => 'USER_REPORTED',
            'dataset_version_id' => $datasetVersionId,
            'trusted_measurement' => false
        ];
        });
    }
}
