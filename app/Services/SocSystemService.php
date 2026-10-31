<?php
namespace App\Services;
use App\Core\{Database,Logger,AccessDeniedException};

final class SocSystemService
{
    private function admin(int $actor): void
    {
        if (!Database::queryOne("SELECT id FROM users WHERE id=:id AND role='ADMIN' AND status='ACTIVE'", ['id'=>$actor])) throw new AccessDeniedException('Active administrator required.');
    }
    public function overview(int $actor): array
    {
        $this->admin($actor);
        // Each table is aggregated once in one round trip; totals never depend on
        // the size of a recent-activity page or a deployment-request decision.
        $c=Database::queryOne("SELECT u.total AS students_total,u.active AS students_active,
            s.total AS scenarios_total,t.total AS tickets_total,t.assigned,t.in_progress,t.approved AS tickets_approved,t.cancelled,
            a.total AS assignments_total,a.active AS assignments_active,
            sub.total AS submissions_total,sub.pending AS reviews_pending,sub.approved AS submissions_approved,sub.changes_requested,
            d.total AS datasets_total,d.archived AS datasets_archived,p.total AS processed_total,
            n.total AS notebooks_total,e.total AS experiments_total,er.total AS runs_total,m.total AS models_total,
            vr.pending AS validations_pending,dr.total AS requests_total,dr.pending AS requests_pending,dr.approved AS requests_approved,
            j.queued,j.running,j.completed,j.failed,au.total AS audit_total
            FROM (SELECT COUNT(*) total,COALESCE(SUM(status='ACTIVE'),0) active FROM users WHERE role='STUDENT') u
            CROSS JOIN (SELECT COUNT(*) total FROM scenarios) s
            CROSS JOIN (SELECT COUNT(*) total,COALESCE(SUM(status='ASSIGNED'),0) assigned,COALESCE(SUM(status='IN_PROGRESS'),0) in_progress,COALESCE(SUM(status='APPROVED'),0) approved,COALESCE(SUM(status='CANCELLED'),0) cancelled FROM tickets) t
            CROSS JOIN (SELECT COUNT(*) total,COALESCE(SUM(ta.revoked_at IS NULL AND t.status<>'CANCELLED' AND u.status='ACTIVE'),0) active FROM ticket_assignments ta JOIN tickets t ON t.id=ta.ticket_id JOIN users u ON u.id=ta.student_id AND u.role='STUDENT') a
            CROSS JOIN (SELECT COUNT(*) total,COALESCE(SUM(status IN ('SUBMITTED','UNDER_REVIEW')),0) pending,COALESCE(SUM(status='APPROVED'),0) approved,COALESCE(SUM(status='CHANGES_REQUESTED'),0) changes_requested FROM submissions) sub
            CROSS JOIN (SELECT COUNT(*) total,COALESCE(SUM(archived_at IS NOT NULL),0) archived FROM datasets) d
            CROSS JOIN (SELECT COUNT(*) total FROM processed_datasets) p
            CROSS JOIN (SELECT COUNT(*) total FROM notebooks) n
            CROSS JOIN (SELECT COUNT(*) total FROM experiments) e
            CROSS JOIN (SELECT COUNT(*) total FROM experiment_runs) er
            CROSS JOIN (SELECT COUNT(*) total FROM models) m
            CROSS JOIN (SELECT COALESCE(SUM(status='PENDING'),0) pending FROM validation_runs) vr
            CROSS JOIN (SELECT COUNT(*) total,COALESCE(SUM(status='PENDING'),0) pending,COALESCE(SUM(status='APPROVED'),0) approved FROM deployment_requests) dr
            CROSS JOIN (SELECT COALESCE(SUM(status='QUEUED'),0) queued,COALESCE(SUM(status='RUNNING'),0) running,COALESCE(SUM(status='COMPLETED'),0) completed,COALESCE(SUM(status='FAILED'),0) failed FROM execution_jobs) j
            CROSS JOIN (SELECT COUNT(*) total FROM audit_logs) au");
        $c=array_map('intval',$c);
        return ['timestamp'=>gmdate('c'),
            'students'=>['total'=>$c['students_total'],'active'=>$c['students_active']],
            'scenarios'=>['total'=>$c['scenarios_total']],
            'tickets'=>['total'=>$c['tickets_total'],'assigned'=>$c['assigned'],'in_progress'=>$c['in_progress'],'approved'=>$c['tickets_approved'],'cancelled'=>$c['cancelled']],
            'assignments'=>['total'=>$c['assignments_total'],'active'=>$c['assignments_active']],
            'submissions'=>['total'=>$c['submissions_total'],'pending'=>$c['reviews_pending'],'approved'=>$c['submissions_approved'],'changes_requested'=>$c['changes_requested']],
            'datasets'=>['master'=>$c['datasets_total'],'processed'=>$c['processed_total'],'archived'=>$c['datasets_archived']],
            'ml_workbench'=>['notebooks'=>$c['notebooks_total'],'experiments'=>$c['experiments_total'],'experiment_runs'=>$c['runs_total']],
            'models'=>['registered'=>$c['models_total'],'deployed'=>0,'deployment_availability'=>'NOT_CONFIGURED','pending_validations'=>$c['validations_pending'],'pending_deployments'=>$c['requests_pending']],
            'deployment_requests'=>['total'=>$c['requests_total'],'pending'=>$c['requests_pending'],'approved'=>$c['requests_approved']],
            'execution_cluster'=>['status'=>'NOT_CONFIGURED','queued'=>$c['queued'],'running'=>$c['running'],'completed'=>$c['completed'],'failed'=>$c['failed']],
            'audit'=>['total'=>$c['audit_total']],
            'recent_audit_actions'=>Database::query('SELECT a.*,u.full_name AS actor_name,u.identifier AS actor_identifier FROM audit_logs a LEFT JOIN users u ON u.id=a.actor_id ORDER BY a.id DESC LIMIT 20')];
    }
    public function dashboard(int $actor): array
    {
        $overview=$this->overview($actor);
        $students=Database::query("SELECT u.id,u.full_name,u.identifier,u.status,
            (SELECT COUNT(*) FROM ticket_assignments ta JOIN tickets t ON t.id=ta.ticket_id WHERE ta.student_id=u.id AND ta.revoked_at IS NULL AND t.status<>'CANCELLED') AS tickets_count,
            (SELECT COUNT(*) FROM submissions sub WHERE sub.student_id=u.id) AS submissions_count
            FROM users u WHERE u.role='STUDENT' ORDER BY u.created_at DESC,u.id DESC LIMIT 10");
        $scenarios=Database::query("SELECT s.id,s.code,s.title,s.version,s.status,
            (SELECT COUNT(*) FROM tickets t WHERE t.scenario_id=s.id) AS tickets_count,
            (SELECT COUNT(*) FROM datasets d WHERE d.scenario_id=s.id) AS datasets_count
            FROM scenarios s ORDER BY s.created_at DESC,s.id DESC LIMIT 20");
        return ['overview'=>$overview,'students'=>$students,'scenarios'=>$scenarios,'health'=>$this->health($actor)];
    }
    public function health(int $actor): array
    {
        $this->admin($actor);$start=hrtime(true);
        $available=(int)Database::queryOne('SELECT 1 AS measured')['measured']===1;
        return ['checked_at'=>gmdate('c'),'application'=>['status'=>'AVAILABLE','evidence'=>'This authenticated application request completed.'],
            'database'=>['status'=>$available?'AVAILABLE':'FAILED','round_trip_ms'=>round((hrtime(true)-$start)/1000000,3),'evidence'=>'Live PDO SELECT 1'],
            'python_worker'=>['status'=>'NOT_CONFIGURED','execution_enabled'=>false,'reason'=>'No verified isolated runner deployed.'],
            'validation_provider'=>['status'=>'NOT_CONFIGURED','quality_evaluation_enabled'=>false,'reason'=>'Only artifact file integrity is available.'],
            'inference_provider'=>['status'=>'NOT_CONFIGURED','deployment_enabled'=>false,'reason'=>'Administrative approval does not create an endpoint.']];
    }
    public function summary(int $actor,string $type): array
    {
        $this->admin($actor);
        $sql=match($type){
            'tickets'=>"SELECT COUNT(*) total,COALESCE(SUM(status='ASSIGNED'),0) assigned,COALESCE(SUM(status='IN_PROGRESS'),0) in_progress,COALESCE(SUM(status='APPROVED'),0) approved,COALESCE(SUM(status='CANCELLED'),0) cancelled FROM tickets",
            'datasets'=>"SELECT COUNT(*) master,(SELECT COUNT(*) FROM processed_datasets) processed,COALESCE(SUM(archived_at IS NOT NULL),0) archived FROM datasets",
            'models'=>"SELECT COUNT(*) registered,0 deployed,(SELECT COUNT(*) FROM validation_runs WHERE status='PENDING') pending_validations,(SELECT COUNT(*) FROM deployment_requests WHERE status='PENDING') pending_deployments FROM models",
            default=>throw new \InvalidArgumentException('Invalid summary type.')
        };
        $summary=array_map('intval',Database::queryOne($sql));
        if($type==='models')$summary['deployment_availability']='NOT_CONFIGURED';
        return $summary;
    }
    public function activity(int $actor,array $filters=[],int $defaultLimit=50): array
    {
        $this->admin($actor);$params=[];$where='1=1';
        foreach(['actor_id','action','resource_type','resource_id','outcome','limit','offset'] as $field)if(isset($filters[$field])&&!is_scalar($filters[$field]))throw new \InvalidArgumentException('Invalid activity filter.');
        foreach(['actor_id','action','resource_type','resource_id','outcome'] as $field)if(isset($filters[$field])&&$filters[$field]!==''){$where.=' AND a.'.$field.'=:'.$field;$params[$field]=$filters[$field];}
        $limit=max(1,min(100,(int)($filters['limit']??$defaultLimit)));$offset=max(0,(int)($filters['offset']??0));
        $items=Database::query('SELECT a.*,u.full_name AS actor_name,u.identifier AS actor_identifier FROM audit_logs a LEFT JOIN users u ON u.id=a.actor_id WHERE '.$where.' ORDER BY a.id DESC LIMIT '.$limit.' OFFSET '.$offset,$params);
        $total=(int)Database::queryOne('SELECT COUNT(*) AS c FROM audit_logs a WHERE '.$where,$params)['c'];
        return ['items'=>$items,'total'=>$total,'limit'=>$limit,'offset'=>$offset];
    }
    public function settings(int $actor): array { $this->admin($actor);return Database::query('SELECT * FROM system_settings ORDER BY setting_key'); }
    public function saveSetting(int $actor,array $data): array
    {
        $this->admin($actor);$key=$data['key']??'';$value=$data['value']??'';
        if(!in_array($key,['student_help_text','platform_announcement'],true)||!is_string($value)||strlen($value)>4000)throw new \InvalidArgumentException('Supported settings: student_help_text and platform_announcement; maximum 4000 characters.');
        return Database::transaction(function()use($actor,$key,$value){
            $old=Database::queryOne('SELECT * FROM system_settings WHERE setting_key=:key FOR UPDATE',['key'=>$key]);
            if($old&&$old['setting_value']===$value)return $old;
            Database::execute('INSERT INTO system_settings (setting_key,setting_value,description,updated_by) VALUES (:key,:value,:description,:actor) ON DUPLICATE KEY UPDATE setting_value=:value2,updated_by=:actor2,updated_at=NOW()',
                ['key'=>$key,'value'=>$value,'description'=>'Administrator-authored student guidance','actor'=>$actor,'value2'=>$value,'actor2'=>$actor]);
            Logger::audit('SETTING_UPDATED','system_settings',$key,'SUCCESS',['setting_key'=>$key],$actor);
            return Database::queryOne('SELECT * FROM system_settings WHERE setting_key=:key',['key'=>$key]);
        });
    }
    public function studentGuidance(): array
    {
        return Database::query("SELECT setting_key,setting_value FROM system_settings WHERE setting_key IN ('student_help_text','platform_announcement') ORDER BY setting_key");
    }
}
