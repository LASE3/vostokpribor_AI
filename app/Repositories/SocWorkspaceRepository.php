<?php
namespace App\Repositories;
use App\Core\Database;
use InvalidArgumentException;

/** Bounded administrative reads of the same student-owned records; no copies/sync tables. */
final class SocWorkspaceRepository
{
    public function list(string $resource, array $filters = []): array
    {
        [$sql,$owner,$ticket,$status]=match($resource) {
            'notebooks'=>['SELECT n.*,u.full_name AS student_name,u.identifier AS student_identifier,t.ticket_code,(SELECT COUNT(*) FROM notebook_cells c WHERE c.notebook_id=n.id) AS cells_count FROM notebooks n JOIN users u ON u.id=n.student_id LEFT JOIN tickets t ON t.id=n.ticket_id','n.student_id','n.ticket_id','n.status'],
            'experiments'=>['SELECT e.*,u.full_name AS student_name,u.identifier AS student_identifier,t.ticket_code,(SELECT COUNT(*) FROM experiment_runs er WHERE er.experiment_id=e.id) AS runs_count FROM experiments e JOIN users u ON u.id=e.student_id LEFT JOIN tickets t ON t.id=e.ticket_id','e.student_id','e.ticket_id',null],
            'runs'=>['SELECT er.*,e.code AS experiment_code,e.name AS experiment_name,e.ticket_id,u.full_name AS student_name,u.identifier AS student_identifier,t.ticket_code FROM experiment_runs er JOIN experiments e ON e.id=er.experiment_id JOIN users u ON u.id=er.student_id LEFT JOIN tickets t ON t.id=e.ticket_id','er.student_id','e.ticket_id','er.status'],
            'jobs'=>['SELECT j.*,u.full_name AS student_name,u.identifier AS student_identifier,n.title AS notebook_title,n.ticket_id,t.ticket_code FROM execution_jobs j JOIN users u ON u.id=j.student_id JOIN notebooks n ON n.id=j.notebook_id LEFT JOIN tickets t ON t.id=n.ticket_id','j.student_id','n.ticket_id','j.status'],
            'models'=>['SELECT m.*,u.full_name AS student_name,u.identifier AS student_identifier,t.ticket_code,(SELECT COUNT(*) FROM model_versions mv WHERE mv.model_id=m.id) AS versions_count FROM models m JOIN users u ON u.id=m.student_id LEFT JOIN tickets t ON t.id=m.ticket_id','m.student_id','m.ticket_id','m.status'],
            'validations'=>['SELECT vr.*,m.model_code,m.name AS model_name,m.student_id,m.ticket_id,u.full_name AS student_name,u.identifier AS student_identifier,mv.version AS model_version FROM validation_runs vr JOIN models m ON m.id=vr.model_id JOIN users u ON u.id=m.student_id JOIN model_versions mv ON mv.id=vr.model_version_id','m.student_id','m.ticket_id','vr.status'],
            'requests'=>['SELECT dr.*,m.model_code,m.name AS model_name,m.student_id,m.ticket_id,u.full_name AS student_name,u.identifier AS student_identifier,mv.version AS model_version FROM deployment_requests dr JOIN models m ON m.id=dr.model_id JOIN users u ON u.id=m.student_id JOIN model_versions mv ON mv.id=dr.model_version_id','m.student_id','m.ticket_id','dr.status'],
            default=>throw new InvalidArgumentException('Unsupported workspace resource.')
        };
        $params=[];$sql.=' WHERE 1=1';
        foreach (['student_id'=>$owner,'ticket_id'=>$ticket] as $key=>$column) if (!empty($filters[$key])) {$sql.=' AND '.$column.'=:'.$key;$params[$key]=(int)$filters[$key];}
        if ($status && !empty($filters['status'])) {$sql.=' AND '.$status.'=:status';$params['status']=(string)$filters['status'];}
        $alias=match($resource){'notebooks'=>'n','experiments'=>'e','runs'=>'er','jobs'=>'j','models'=>'m','validations'=>'vr','requests'=>'dr'};
        $limit=min(200,max(1,(int)($filters['limit']??100)));$offset=max(0,(int)($filters['offset']??0));
        return Database::query($sql.' ORDER BY '.$alias.'.id DESC LIMIT '.$limit.' OFFSET '.$offset,$params);
    }
}
