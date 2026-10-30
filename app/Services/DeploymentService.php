<?php
namespace App\Services;
use App\Repositories\DeploymentRepository;
use App\Core\Database;
use App\Core\Logger;
use App\Core\AccessDeniedException;
use InvalidArgumentException;

/** Administrative request/decision persistence never asserts provider execution. */
class DeploymentService
{
    private DeploymentRepository $deployRepo;
    public function __construct(){$this->deployRepo=new DeploymentRepository();}
    public function listDeployments(?array $user=null):array
    {
        if(!$user)throw new AccessDeniedException('Authentication required.');
        return $user['role']==='ADMIN'?$this->deployRepo->listAll():$this->deployRepo->listForStudent((int)$user['id']);
    }
    public function requestDeployment(array $data,int $actorId):array
    {
        WorkOwnership::student($actorId);
        $user=Database::queryOne("SELECT role FROM users WHERE id=:id AND status='ACTIVE'",['id'=>$actorId]);
        if(!$user)throw new AccessDeniedException('Authentication required.');
        $model=(new ModelService())->getModel((int)($data['model_id']??0),$actorId,$user['role']);
        if($model['status']==='ARCHIVED')throw new InvalidArgumentException('Archived models cannot request deployment.');
        $version=Database::queryOne('SELECT * FROM model_versions WHERE id=:id AND model_id=:mid',['id'=>(int)($data['model_version_id']??0),'mid'=>$model['id']]);
        if(!$version)throw new InvalidArgumentException('An uploaded artifact version belonging to this model is required.');
        $path=dirname(__DIR__,2).'/storage/private/models/'.basename($version['artifact_path']);
        if(!is_file($path)||filesize($path)<1||!hash_equals($version['checksum_sha256'],hash_file('sha256',$path)))throw new InvalidArgumentException('Artifact is absent or its checksum does not match. No request was created.');
        $environment=(string)($data['environment']??'canary');
        if(!in_array($environment,['canary','staging','production'],true))throw new InvalidArgumentException('Invalid requested environment.');
        $canary=filter_var($data['canary_percentage']??10,FILTER_VALIDATE_INT);$replicas=filter_var($data['replicas']??1,FILTER_VALIDATE_INT);
        if($canary===false||$canary<0||$canary>100||$replicas===false||$replicas<1||$replicas>20)throw new InvalidArgumentException('Invalid replica or canary setting.');
        $inputKey=$data['idempotency_key']??null;
        if($inputKey!==null&&(!is_string($inputKey)||!preg_match('/^[A-Za-z0-9_.-]{8,128}$/D',$inputKey)))throw new InvalidArgumentException('Invalid idempotency key.');
        $canonical=json_encode([$actorId,(int)$model['id'],(int)$version['id'],$environment,$canary,$replicas],JSON_THROW_ON_ERROR);
        $key=hash('sha256',$actorId.':'.($inputKey??$canonical));
        return Database::transaction(function()use($model,$version,$environment,$canary,$replicas,$actorId,$key,$canonical){
            $locked=Database::queryOne('SELECT id,status,student_id FROM models WHERE id=:id FOR UPDATE',['id'=>$model['id']]);
            if(!$locked||(int)$locked['student_id']!==$actorId||$locked['status']==='ARCHIVED')throw new InvalidArgumentException('Model became unavailable or archived before this request was committed.');
            $old=Database::queryOne('SELECT * FROM deployment_requests WHERE request_key=:key',['key'=>$key]);
            if($old){
                $previous=json_encode([(int)$old['requested_by'],(int)$old['model_id'],(int)$old['model_version_id'],$old['environment'],(int)$old['canary_percentage'],(int)$old['replicas']],JSON_THROW_ON_ERROR);
                if($previous!==$canonical)throw new InvalidArgumentException('Idempotency key was already used with different request parameters.');
                return $this->describe($old);
            }
            $id=Database::getInstance()->insert('deployment_requests',['model_id'=>$model['id'],'model_version_id'=>$version['id'],'requested_by'=>$actorId,'environment'=>$environment,'canary_percentage'=>$canary,'replicas'=>$replicas,'status'=>'PENDING','request_key'=>$key,'provider_state'=>'NOT_CONFIGURED','endpoint_url'=>null]);
            Logger::audit('DEPLOYMENT_REQUEST_CREATED','deployment_requests',(string)$id,'SUCCESS',['model_id'=>(int)$model['id'],'student_id'=>(int)$model['student_id'],'provider_state'=>'NOT_CONFIGURED','quality_status'=>'NOT_EVALUATED'],$actorId);
            Database::execute("INSERT INTO notifications(user_id,title,message,type,link) SELECT id,'Deployment request awaits review',:message,'INFO',:link FROM users WHERE role='ADMIN' AND status='ACTIVE'",['message'=>'Request #'.$id.' records desired configuration only. No inference provider has deployed this model.','link'=>\App\Core\AppUrl::to('AI Operations Center (AI SOC)/DeploymentRequests.php?id='.$id)]);
            return $this->describe($this->deployRepo->findById($id));
        });
    }
    private function describe(array $request):array
    {
        $request['runtime_status']='UNAVAILABLE';$request['deployed']=false;
        $request['quality_evidence_status']='NOT_EVALUATED';
        $request['availability_reason']='Request/approval is administrative only; no verified inference provider is configured.';
        return $request;
    }
    public function reviewDeployment(int $id,string $decision,int $adminId,?string $notes=null,?int $trafficPercent=null):array
    {
        if(!Database::queryOne("SELECT id FROM users WHERE id=:id AND role='ADMIN' AND status='ACTIVE'",['id'=>$adminId]))throw new AccessDeniedException('Administrator access required.');
        if(!in_array($decision,['APPROVED','REJECTED'],true))throw new InvalidArgumentException('Only administrative APPROVED or REJECTED decisions are permitted. A database change cannot deploy a model.');
        if($notes!==null&&strlen($notes)>10000)throw new InvalidArgumentException('Decision notes are too long.');
        if($trafficPercent!==null&&($trafficPercent<0||$trafficPercent>100))throw new InvalidArgumentException('Invalid traffic percentage.');
        return Database::transaction(function()use($id,$decision,$adminId,$notes,$trafficPercent){
            $old=Database::queryOne('SELECT * FROM deployment_requests WHERE id=:id FOR UPDATE',['id'=>$id]);
            if(!$old)throw new InvalidArgumentException('Deployment request not found.');
            if($old['status']===$decision)return $this->describe($this->deployRepo->findById($id));
            if($old['status']!=='PENDING')throw new InvalidArgumentException('Only a pending request can be reviewed.');
            $this->deployRepo->updateStatus($id,$decision,$adminId,$notes,$trafficPercent);
            Logger::audit('DEPLOYMENT_REQUEST_REVIEWED','deployment_requests',(string)$id,'SUCCESS',['decision'=>$decision,'requested_by'=>(int)$old['requested_by'],'model_id'=>(int)$old['model_id'],'provider_state'=>'NOT_CONFIGURED'],$adminId);
            Database::execute("INSERT INTO notifications(user_id,title,message,type,link) VALUES(:uid,'Deployment request reviewed',:message,'INFO',:link)",['uid'=>$old['requested_by'],'message'=>'Deployment request #'.$id.' was '.$decision.'. No runtime deployment occurred; provider is not configured.','link'=>\App\Core\AppUrl::to('Model Registry & Deployment/DeploymentConfig.php')]);
            return $this->describe($this->deployRepo->findById($id));
        });
    }
}
