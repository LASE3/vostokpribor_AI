<?php
namespace App\Repositories;
use App\Core\Database;
use App\Core\Pagination;
use InvalidArgumentException;

/** Bounded administrative reads of the same student-owned records; no copies/sync tables. */
final class SocWorkspaceRepository
{
    public function list(string $resource, array $filters = []): array { return $this->page($resource,$filters)['items']; }
    public function page(string $resource, array $filters = []): array
    {
        [$sql,$owner,$ticket,$status]=match($resource) {
            'notebooks'=>['SELECT n.*,u.full_name AS student_name,u.identifier AS student_identifier,t.ticket_code,(SELECT COUNT(*) FROM notebook_cells c WHERE c.notebook_id=n.id) AS cells_count FROM notebooks n JOIN users u ON u.id=n.student_id LEFT JOIN tickets t ON t.id=n.ticket_id','n.student_id','n.ticket_id','n.status'],
            'experiments'=>['SELECT e.*,u.full_name AS student_name,u.identifier AS student_identifier,t.ticket_code,(SELECT COUNT(*) FROM experiment_runs er WHERE er.experiment_id=e.id) AS runs_count FROM experiments e JOIN users u ON u.id=e.student_id LEFT JOIN tickets t ON t.id=e.ticket_id','e.student_id','e.ticket_id',null],
            'runs'=>['SELECT er.*,e.code AS experiment_code,e.name AS experiment_name,e.ticket_id,u.full_name AS student_name,u.identifier AS student_identifier,t.ticket_code FROM experiment_runs er JOIN experiments e ON e.id=er.experiment_id JOIN users u ON u.id=er.student_id LEFT JOIN tickets t ON t.id=e.ticket_id','er.student_id','e.ticket_id','er.status'],
            // Full code/logs and model authoring metadata belong to the existing detail endpoints.
            'jobs'=>['SELECT j.id,j.job_uuid,j.notebook_id,j.cell_id,j.student_id,j.status,j.exit_code,j.execution_time_ms,j.memory_peak_mb,j.started_at,j.completed_at,j.created_at,u.full_name AS student_name,u.identifier AS student_identifier,n.title AS notebook_title,n.ticket_id,t.ticket_code FROM execution_jobs j JOIN users u ON u.id=j.student_id JOIN notebooks n ON n.id=j.notebook_id LEFT JOIN tickets t ON t.id=n.ticket_id','j.student_id','n.ticket_id','j.status'],
            'models'=>['SELECT m.id,m.model_code,m.name,m.framework,m.student_id,m.ticket_id,m.scenario_id,m.experiment_run_id,m.current_version,m.status,m.created_at,m.updated_at,m.admin_updated_by,m.admin_updated_at,u.full_name AS student_name,u.identifier AS student_identifier,t.ticket_code,(SELECT COUNT(*) FROM model_versions mv WHERE mv.model_id=m.id) AS versions_count FROM models m JOIN users u ON u.id=m.student_id LEFT JOIN tickets t ON t.id=m.ticket_id','m.student_id','m.ticket_id','m.status'],
            'validations'=>['SELECT vr.*,m.model_code,m.name AS model_name,m.student_id,m.ticket_id,u.full_name AS student_name,u.identifier AS student_identifier,mv.version AS model_version FROM validation_runs vr JOIN models m ON m.id=vr.model_id JOIN users u ON u.id=m.student_id JOIN model_versions mv ON mv.id=vr.model_version_id','m.student_id','m.ticket_id','vr.status'],
            'requests'=>['SELECT dr.*,m.model_code,m.name AS model_name,m.student_id,m.ticket_id,u.full_name AS student_name,u.identifier AS student_identifier,mv.version AS model_version FROM deployment_requests dr JOIN models m ON m.id=dr.model_id JOIN users u ON u.id=m.student_id JOIN model_versions mv ON mv.id=dr.model_version_id','m.student_id','m.ticket_id','dr.status'],
            default=>throw new InvalidArgumentException('Unsupported workspace resource.')
        };
        $alias=match($resource){'notebooks'=>'n','experiments'=>'e','runs'=>'er','jobs'=>'j','models'=>'m','validations'=>'vr','requests'=>'dr'};
        $table=match($resource){'notebooks'=>'notebooks','experiments'=>'experiments','runs'=>'experiment_runs','jobs'=>'execution_jobs','models'=>'models','validations'=>'validation_runs','requests'=>'deployment_requests'};
        $paging=Pagination::from($filters);$limit=$paging['limit'];$offset=$paging['offset'];
        $params=[];$where=' WHERE 1=1';
        foreach (['student_id'=>$owner,'ticket_id'=>$ticket] as $key=>$column) {
            if (empty($filters[$key])) continue;
            $params[$key]=(int)$filters[$key];
            if (str_starts_with($column,$alias.'.')) {
                $where.=' AND '.$column.'=:'.$key;
            } else {
                // Linked-owner/ticket filters run before pagination, preserving exact matching pages.
                $where.=' AND '.match($resource) {
                    'runs'=>'EXISTS (SELECT 1 FROM experiments linked WHERE linked.id=er.experiment_id AND linked.ticket_id=:ticket_id)',
                    'jobs'=>'EXISTS (SELECT 1 FROM notebooks linked WHERE linked.id=j.notebook_id AND linked.ticket_id=:ticket_id)',
                    'validations','requests'=>'EXISTS (SELECT 1 FROM models linked WHERE linked.id='.$alias.'.model_id AND linked.'.$key.'=:'.$key.')',
                };
            }
        }
        if ($status && !empty($filters['status'])) {$where.=' AND '.$status.'=:status';$params['status']=(string)$filters['status'];}
        // Materialize only the requested primary rows before owner joins/counts. This avoids
        // sorting all student work (and long JSON) when the administrator requests 100 rows.
        $primaryColumns=match($resource) {
            'jobs'=>'j.id,j.job_uuid,j.notebook_id,j.cell_id,j.student_id,j.status,j.exit_code,j.execution_time_ms,j.memory_peak_mb,j.started_at,j.completed_at,j.created_at',
            'models'=>'m.id,m.model_code,m.name,m.framework,m.student_id,m.ticket_id,m.scenario_id,m.experiment_run_id,m.current_version,m.status,m.created_at,m.updated_at,m.admin_updated_by,m.admin_updated_at',
            default=>$alias.'.*',
        };
        $slice='(SELECT '.$primaryColumns.' FROM '.$table.' '.$alias.$where.' ORDER BY '.$alias.'.id DESC LIMIT '.$limit.' OFFSET '.$offset.') '.$alias;
        $sql=str_replace('FROM '.$table.' '.$alias.' JOIN users','FROM '.$slice.' JOIN users',$sql);
        // Runs join experiments before users; jobs join users directly like the other resources.
        if($resource==='runs')$sql=str_replace('FROM experiment_runs er JOIN experiments','FROM '.$slice.' JOIN experiments',$sql);
        if(in_array($resource,['validations','requests'],true))$sql=str_replace('FROM '.$table.' '.$alias.' JOIN models','FROM '.$slice.' JOIN models',$sql);
        $total=(int)(Database::queryOne('SELECT COUNT(*) AS total FROM '.$table.' '.$alias.$where,$params)['total']??0);
        return Pagination::result(Database::query($sql.' ORDER BY '.$alias.'.id DESC',$params),$total,$paging);
    }
}
