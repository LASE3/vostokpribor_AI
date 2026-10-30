<?php
namespace App\Services;
use App\Core\Database;
use App\Core\Logger;
use App\Core\AccessDeniedException;
use App\Repositories\SocWorkspaceRepository;
use InvalidArgumentException;

final class SocWorkspaceService
{
    public function requireAdmin(int $actorId): void
    {
        if (!Database::queryOne("SELECT id FROM users WHERE id=:id AND role='ADMIN' AND status='ACTIVE'",['id'=>$actorId])) throw new AccessDeniedException('Active administrator required.');
    }
    public function listResources(string $resource,array $filters,int $actorId):array
    {
        $this->requireAdmin($actorId);
        foreach(['student_id','ticket_id'] as $key) if(isset($filters[$key])&&$filters[$key]!==''&&((!is_string($filters[$key])&&!is_int($filters[$key]))||!ctype_digit((string)$filters[$key])||(int)$filters[$key]<1))throw new InvalidArgumentException('Invalid '.$key.'.');
        if(isset($filters['status'])&&(!is_string($filters['status'])||strlen($filters['status'])>64))throw new InvalidArgumentException('Invalid status filter.');
        foreach(['limit','offset'] as $key)if(isset($filters[$key])&&(!is_scalar($filters[$key])||!ctype_digit((string)$filters[$key])))throw new InvalidArgumentException('Invalid pagination.');
        if(!empty($filters['student_id'])&&!Database::queryOne("SELECT id FROM users WHERE id=:id AND role='STUDENT'",['id'=>(int)$filters['student_id']]))throw new InvalidArgumentException('Student not found.');
        return (new SocWorkspaceRepository())->list($resource,$filters);
    }
    public function notebook(int $id,int $actorId):array {$this->requireAdmin($actorId);return(new NotebookService())->getNotebook($id,$actorId,'ADMIN');}
    public function experiment(int $id,int $actorId):array {$this->requireAdmin($actorId);return(new ExperimentService())->getExperiment($id,$actorId,'ADMIN');}
    public function model(int $id,int $actorId):array {$this->requireAdmin($actorId);return(new ModelService())->getModel($id,$actorId,'ADMIN');}
    public function validation(int $id,int $actorId):array {$this->requireAdmin($actorId);return(new ValidationService())->getRun($id,$actorId,'ADMIN');}
    public function job(string $id,int $actorId):array
    {
        $this->requireAdmin($actorId);
        if(ctype_digit($id)){$row=Database::queryOne('SELECT job_uuid FROM execution_jobs WHERE id=:id',['id'=>(int)$id]);if(!$row)throw new InvalidArgumentException('Execution job not found.');$id=$row['job_uuid'];}
        return(new ExecutionService())->getJob($id,$actorId,'ADMIN');
    }
    public function cancelJob(string $id,int $actorId):array
    {
        $job=$this->job($id,$actorId);
        (new ExecutionService())->cancelJob($job['job_uuid'],$actorId,'ADMIN');
        return $this->job($job['job_uuid'],$actorId);
    }
    public function updateModel(int $id,array $data,int $actorId):array
    {
        $this->requireAdmin($actorId);
        $allowed=['admin_label','admin_notes','status'];
        foreach(array_keys($data) as $key)if(!in_array($key,$allowed,true))throw new InvalidArgumentException('Only administrative annotations or archive state may be changed through SOC.');
        foreach(['admin_label'=>255,'admin_notes'=>10000] as $key=>$limit)if(isset($data[$key])&&(!is_string($data[$key])||strlen($data[$key])>$limit))throw new InvalidArgumentException('Invalid '.$key.'.');
        return Database::transaction(function()use($id,$data,$actorId){
            $old=Database::queryOne('SELECT * FROM models WHERE id=:id FOR UPDATE',['id'=>$id]);
            if(!$old)throw new InvalidArgumentException('Model not found.');
            $meta=json_decode($old['admin_metadata_json']??'{}',true)?:[];$changed=false;
            foreach(['admin_label','admin_notes'] as $key)if(array_key_exists($key,$data)&&($meta[$key]??'')!==trim($data[$key])){$meta[$key]=trim($data[$key]);$changed=true;}
            $status=$old['status'];
            if(isset($data['status'])&&$data['status']!==$old['status']){
                if($data['status']==='ARCHIVED'){
                    if($old['status']==='DEPLOYED')throw new InvalidArgumentException('A deployed record cannot be archived without a verified provider decommission operation.');
                    $meta['pre_archive_status']=$old['status'];$status='ARCHIVED';
                }elseif($data['status']==='REGISTERED'&&$old['status']==='ARCHIVED'){$status='REGISTERED';}
                else throw new InvalidArgumentException('SOC metadata editing supports ARCHIVED or restoring an archived record to REGISTERED only.');
                $changed=true;
            }
            if($changed){
                Database::execute('UPDATE models SET admin_metadata_json=:metadata,status=:status,admin_updated_by=:actor,admin_updated_at=NOW(),updated_at=NOW() WHERE id=:id',['metadata'=>json_encode($meta,JSON_THROW_ON_ERROR),'status'=>$status,'actor'=>$actorId,'id'=>$id]);
                Logger::audit('ADMIN_MODEL_UPDATED','models',(string)$id,'SUCCESS',['student_id'=>(int)$old['student_id'],'fields'=>array_keys($data),'old_status'=>$old['status'],'new_status'=>$status],$actorId);
                Database::execute("INSERT INTO notifications(user_id,title,message,type,link) VALUES(:sid,'Model administration update',:message,'INFO',:link)",['sid'=>$old['student_id'],'message'=>'An administrator updated the administrative annotations or archive state of model '.$old['model_code'].'. Original model metadata and artifacts were preserved.','link'=>\App\Core\AppUrl::to('Model Registry & Deployment/ModelRegistry.php?id='.$id)]);
            }
            return $this->model($id,$actorId);
        });
    }
}
