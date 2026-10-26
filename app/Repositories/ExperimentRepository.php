<?php

namespace App\Repositories;

use App\Core\Database;

class ExperimentRepository
{
    public function listForStudent(int $studentId): array
    {
        return Database::query(
            "SELECT e.*, t.ticket_code, s.title as scenario_title,
                    (SELECT COUNT(*) FROM experiment_runs er WHERE er.experiment_id = e.id) as runs_count
             FROM experiments e
             LEFT JOIN tickets t ON e.ticket_id = t.id
             LEFT JOIN scenarios s ON e.scenario_id = s.id
             WHERE e.student_id = :s_id
             ORDER BY e.created_at DESC",
            ['s_id' => $studentId]
        );
    }

    public function listRuns(int $studentId, ?int $experimentId = null): array
    {
        $sql = "SELECT er.*, e.name as experiment_name, e.code as experiment_code, t.ticket_code
                FROM experiment_runs er
                JOIN experiments e ON er.experiment_id = e.id
                LEFT JOIN tickets t ON e.ticket_id = t.id
                WHERE er.student_id = :s_id";
        $params = ['s_id' => $studentId];

        if ($experimentId) {
            $sql .= " AND er.experiment_id = :exp_id";
            $params['exp_id'] = $experimentId;
        }

        $sql .= " ORDER BY er.created_at DESC";
        return Database::query($sql, $params);
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
            "INSERT INTO experiment_runs (run_uuid, experiment_id, student_id, notebook_id, run_name, status, parameters, metrics, artifacts, duration_seconds, created_at)
             VALUES (:uuid, :exp_id, :s_id, :nb_id, :name, :status, :params, :metrics, :artifacts, :duration, NOW())",
            [
                'uuid'      => $runUuid,
                'exp_id'    => $data['experiment_id'],
                's_id'      => $data['student_id'],
                'nb_id'     => $data['notebook_id'] ?? null,
                'name'      => $data['run_name'],
                'status'    => $data['status'] ?? 'COMPLETED',
                'params'    => !empty($data['parameters']) ? json_encode($data['parameters']) : null,
                'metrics'   => !empty($data['metrics']) ? json_encode($data['metrics']) : null,
                'artifacts' => !empty($data['artifacts']) ? json_encode($data['artifacts']) : null,
                'duration'  => $data['duration_seconds'] ?? null
            ]
        );

        return $runUuid;
    }
}
