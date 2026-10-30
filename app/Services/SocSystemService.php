<?php
namespace App\Services;
use App\Core\{Database,Logger,AccessDeniedException};

final class SocSystemService
{
    private function admin(int $actor): void
    {
        if (!Database::queryOne("SELECT id FROM users WHERE id=:id AND role='ADMIN' AND status='ACTIVE'", ['id'=>$actor])) throw new AccessDeniedException('Active administrator required.');
    }
    private function count(string $table, string $where='1=1'): int { return (int)Database::queryOne('SELECT COUNT(*) AS c FROM '.$table.' WHERE '.$where)['c']; }
    public function overview(int $actor): array
    {
        $this->admin($actor);
        return ['timestamp'=>gmdate('c'),
            'students'=>['total'=>$this->count('users',"role='STUDENT'"),'active'=>$this->count('users',"role='STUDENT' AND status='ACTIVE'")],
            'scenarios'=>['total'=>$this->count('scenarios')],
            'tickets'=>['total'=>$this->count('tickets'),'assigned'=>$this->count('tickets',"status='ASSIGNED'"),'in_progress'=>$this->count('tickets',"status='IN_PROGRESS'"),'approved'=>$this->count('tickets',"status='APPROVED'"),'cancelled'=>$this->count('tickets',"status='CANCELLED'")],
            'submissions'=>['total'=>$this->count('submissions'),'pending'=>$this->count('submissions',"status IN ('SUBMITTED','UNDER_REVIEW')"),'approved'=>$this->count('submissions',"status='APPROVED'"),'changes_requested'=>$this->count('submissions',"status='CHANGES_REQUESTED'")],
            'datasets'=>['master'=>$this->count('datasets'),'processed'=>$this->count('processed_datasets'),'archived'=>$this->count('datasets','archived_at IS NOT NULL')],
            'ml_workbench'=>['notebooks'=>$this->count('notebooks'),'experiments'=>$this->count('experiments'),'experiment_runs'=>$this->count('experiment_runs')],
            'models'=>['registered'=>$this->count('models'),'deployed'=>$this->count('deployment_requests',"status='DEPLOYED'"),'pending_validations'=>$this->count('validation_runs',"status='PENDING'"),'pending_deployments'=>$this->count('deployment_requests',"status='PENDING'")],
            'execution_cluster'=>['status'=>'NOT_CONFIGURED','queued'=>$this->count('execution_jobs',"status='QUEUED'"),'running'=>$this->count('execution_jobs',"status='RUNNING'"),'completed'=>$this->count('execution_jobs',"status='COMPLETED'"),'failed'=>$this->count('execution_jobs',"status='FAILED'")],
            'recent_audit_actions'=>$this->activity($actor,[],15)['items']];
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
        $o=$this->overview($actor);if(!isset($o[$type])||!is_array($o[$type]))throw new \InvalidArgumentException('Invalid summary type.');return $o[$type];
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
