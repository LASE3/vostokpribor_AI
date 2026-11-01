<?php

namespace App\Repositories;

use App\Core\Database;
use App\Core\Pagination;

class ExperimentRepository
{
    public function listForStudent(int $studentId, array $paging = []): array { return $this->pageForStudent($studentId, $paging)['items']; }
    public function pageForStudent(int $studentId, array $paging = []): array
    {
        return Pagination::query('SELECT e.*,t.ticket_code,s.title AS scenario_title,(SELECT COUNT(*) FROM experiment_runs er WHERE er.experiment_id=e.id) AS runs_count FROM experiments e LEFT JOIN tickets t ON e.ticket_id=t.id LEFT JOIN scenarios s ON e.scenario_id=s.id WHERE e.student_id=:sid ORDER BY e.created_at DESC,e.id DESC', ['sid'=>$studentId], $paging, 'SELECT COUNT(*) AS total FROM experiments WHERE student_id=:sid');
    }
    public function listRuns(int $studentId, ?int $experimentId = null, array $paging = []): array { return $this->pageRuns($studentId, $experimentId, $paging)['items']; }
    public function pageRuns(int $studentId, ?int $experimentId = null, array $paging = []): array
    {
        $where=' WHERE er.student_id=:sid'; $params=['sid'=>$studentId];
        if ($experimentId !== null) { $where.=' AND er.experiment_id=:eid'; $params['eid']=$experimentId; }
        $page=Pagination::query('SELECT er.*,e.name AS experiment_name,e.code AS experiment_code,t.ticket_code FROM experiment_runs er JOIN experiments e ON er.experiment_id=e.id LEFT JOIN tickets t ON e.ticket_id=t.id'.$where.' ORDER BY er.created_at DESC,er.id DESC',$params,$paging,'SELECT COUNT(*) AS total FROM experiment_runs er'.$where);
        $page['items']=array_map([self::class,'withProvenance'],$page['items']);
        return $page;
    }
    public static function withProvenance(array $run): array
    {
        // API callers cannot turn manually recorded metrics into trusted execution evidence.
        $run['measurement_source'] = $run['measurement_source'] ?? 'UNKNOWN';
        $run['trusted_measurement'] = false;
        return $run;
    }

    public function createExperiment(array $data): int
    {
        Database::execute(
            "INSERT INTO experiments (code, name, student_id, ticket_id, scenario_id, created_at)
             VALUES (:code, :name, :s_id, :t_id, :scen_id, NOW())",
            [
                'code'    => $data['code'],
                'name'    => $data['name'],
                's_id'    => $data['student_id'],
                't_id'    => $data['ticket_id'] ?? null,
                'scen_id' => $data['scenario_id'] ?? null
            ]
        );

        return (int)Database::lastInsertId();
    }

    public function recordRun(array $data): string
    {
        $runUuid = 'RUN-' . strtoupper(bin2hex(random_bytes(6)));

        Database::execute(
            "INSERT INTO experiment_runs (run_uuid, experiment_id, student_id, notebook_id, dataset_version_id, run_name, status, parameters, metrics, measurement_source, artifacts, duration_seconds, created_at)
             VALUES (:uuid, :exp_id, :s_id, :nb_id, :dataset_version_id, :name, :status, :params, :metrics, 'USER_REPORTED', :artifacts, :duration, NOW())",
            [
                'uuid'      => $runUuid,
                'exp_id'    => $data['experiment_id'],
                's_id'      => $data['student_id'],
                'nb_id'     => $data['notebook_id'] ?? null,
                'dataset_version_id' => $data['dataset_version_id'] ?? null,
                'name'      => $data['run_name'],
                'status'    => 'RECORDED',
                'params'    => !empty($data['parameters']) ? json_encode($data['parameters']) : null,
                'metrics'   => !empty($data['metrics']) ? json_encode($data['metrics']) : null,
                'artifacts' => !empty($data['artifacts']) ? json_encode($data['artifacts']) : null,
                'duration'  => $data['duration_seconds'] ?? null
            ]
        );

        return $runUuid;
    }
}
