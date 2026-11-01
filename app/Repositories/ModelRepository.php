<?php

namespace App\Repositories;

use App\Core\Database;
use App\Core\Pagination;

class ModelRepository
{
    public function listForUser(int $userId, string $role, ?string $status = null, array $paging = []): array
    {
        return $this->pageForUser($userId, $role, $status, $paging)['items'];
    }

    public function pageForUser(int $userId, string $role, ?string $status = null, array $paging = [], bool $summary = false): array
    {
        $params = [];
        $where = $role === 'ADMIN' ? ' WHERE 1=1' : ' WHERE m.student_id = :sid';
        if ($role !== 'ADMIN') $params['sid'] = $userId;
        if ($status !== null && $status !== '') { $where .= ' AND m.status = :status'; $params['status'] = $status; }
        $columns = $summary ? 'm.id,m.model_code,m.name,m.framework,m.student_id,m.ticket_id,m.scenario_id,m.status,m.current_version,m.created_at,m.updated_at' : 'm.*';
        $sql = 'SELECT '.$columns.',u.full_name AS student_name,u.identifier AS student_identifier,s.title AS scenario_title,t.ticket_code,
            (SELECT COUNT(*) FROM model_versions mv WHERE mv.model_id=m.id) AS versions_count
            FROM models m JOIN users u ON u.id=m.student_id LEFT JOIN scenarios s ON s.id=m.scenario_id LEFT JOIN tickets t ON t.id=m.ticket_id';
        $paging=Pagination::from($paging);
        $total=(int)(Database::queryOne('SELECT COUNT(*) AS total FROM models m'.$where,$params)['total']??0);
        // Page narrow primary keys before joining metadata. Sorting a wide JSON collection
        // before LIMIT made the old registry response grow with the entire institution.
        $window='(SELECT m.id FROM models m'.$where.' ORDER BY m.updated_at DESC,m.id DESC LIMIT '.$paging['limit'].' OFFSET '.$paging['offset'].') selected JOIN models m ON m.id=selected.id';
        $sql=str_replace('FROM models m JOIN users','FROM '.$window.' JOIN users',$sql);
        return Pagination::result(Database::query($sql.' ORDER BY m.updated_at DESC,m.id DESC',$params),$total,$paging);
    }

    public function findById(int $id, array $versionPaging = []): ?array
    {
        $model = Database::queryOne(
            "SELECT m.*, u.full_name as student_name, u.identifier as student_identifier,
                    s.title as scenario_title, t.ticket_code
             FROM models m
             JOIN users u ON m.student_id = u.id
             LEFT JOIN scenarios s ON m.scenario_id = s.id
             LEFT JOIN tickets t ON m.ticket_id = t.id
             WHERE m.id = :id LIMIT 1",
            ['id' => $id]
        );

        if (!$model) {
            return null;
        }

        $versions = Pagination::query('SELECT * FROM model_versions WHERE model_id=:mid ORDER BY created_at DESC,id DESC',['mid'=>$id],$versionPaging,'SELECT COUNT(*) AS total FROM model_versions WHERE model_id=:mid');
        $model['versions'] = $versions['items'];
        $model['versions_pagination'] = Pagination::metadata($versions);

        return $model;
    }

    public function findByCode(string $code): ?array
    {
        return Database::queryOne("SELECT * FROM models WHERE model_code = :code LIMIT 1", ['code' => $code]);
    }

    public function create(array $data): int
    {
        Database::execute(
            "INSERT INTO models (model_code, name, framework, student_id, ticket_id, scenario_id, experiment_run_id, current_version, status, description, metadata_json, created_at)
             VALUES (:code, :name, :framework, :s_id, :t_id, :scen_id, :run_id, :ver, :status, :desc, :meta, NOW())",
            [
                'code'       => $data['model_code'],
                'name'       => $data['name'],
                'framework'  => $data['framework'] ?? '',
                's_id'       => $data['student_id'],
                't_id'       => $data['ticket_id'] ?? null,
                'scen_id'    => $data['scenario_id'] ?? null,
                'run_id'     => $data['experiment_run_id'] ?? null,
                'ver'        => $data['current_version'] ?? 'v1.0.0',
                'status'     => $data['status'] ?? 'REGISTERED',
                'desc'       => $data['description'] ?? null,
                'meta'       => !empty($data['metadata_json']) ? json_encode($data['metadata_json']) : null
            ]
        );

        return (int)Database::lastInsertId();
    }

    public function updateStatus(int $id, string $status): void
    {
        Database::execute(
            "UPDATE models SET status = :status, updated_at = NOW() WHERE id = :id",
            ['status' => $status, 'id' => $id]
        );
    }

    public function addVersion(int $modelId, array $data): int
    {
        Database::execute(
            "INSERT INTO model_versions (model_id, version, artifact_path, artifact_format, checksum_sha256, file_size, metrics, status) VALUES (:mid,:ver,:path,:fmt,:sha,:size,:metrics,'REGISTERED')",
            ['mid' => $modelId, 'ver' => $data['version'], 'path' => $data['artifact_path'], 'fmt' => $data['artifact_format'], 'sha' => $data['checksum_sha256'], 'size' => $data['file_size'], 'metrics' => isset($data['metrics']) ? json_encode($data['metrics'], JSON_THROW_ON_ERROR) : null]
        );
        $id = (int)Database::lastInsertId();
        Database::execute('UPDATE models SET current_version = :ver, updated_at = NOW() WHERE id = :id', ['ver' => $data['version'], 'id' => $modelId]);
        return $id;
    }

    public function findVersionById(int $versionId): ?array
    {
        return Database::queryOne("SELECT * FROM model_versions WHERE id = :id LIMIT 1", ['id' => $versionId]);
    }
}
