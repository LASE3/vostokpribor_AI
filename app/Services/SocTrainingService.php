<?php
namespace App\Services;
use App\Core\Database;
use App\Core\AccessDeniedException;
use App\Repositories\TrainingReadRepository;
use RuntimeException;
class SocTrainingService {
    private TrainingReadRepository $read;
    public function __construct(){$this->read=new TrainingReadRepository();}
    private function admin(int $id):void{if(!Database::queryOne("SELECT id FROM users WHERE id=:id AND role='ADMIN' AND status='ACTIVE'",['id'=>$id]))throw new AccessDeniedException('Active administrator required.');}
    public function studentResource(int $id,string $resource,int $actor):array{
        if($resource!=='progress')return $this->studentPage($id,$resource,$actor)['items'];
        $this->admin($actor);$users=new UserService();$users->requireStudent($id);
        $tickets=(new TicketService())->countsForUser($id,'STUDENT');$submissions=(new SubmissionService())->countsForUser($id,'STUDENT');
        $counts=[];foreach(['notebooks','experiment_runs','models'] as $table)$counts[$table]=(int)Database::queryOne('SELECT COUNT(*) AS c FROM '.$table.' WHERE student_id=:id',['id'=>$id])['c'];
        return ['student'=>(new \App\Repositories\UserRepository())->findById($id),'tickets_total'=>array_sum($tickets),'tickets_by_status'=>$tickets,'notebooks'=>$counts['notebooks'],'experiments'=>$counts['experiment_runs'],'models'=>$counts['models'],'submissions'=>array_sum($submissions),'submissions_by_status'=>$submissions];
    }
    public function studentPage(int $id,string $resource,int $actor,array $paging=[]):array{
        $this->admin($actor);(new UserService())->requireStudent($id);
        return match($resource){
            'activity'=>$this->read->page('studentActivity',$id,$paging),
            'tickets'=>(new TicketService())->pageForUser($id,'STUDENT',[],$paging),
            'datasets'=>(new DatasetService())->pageForUser($id,'STUDENT',null,$paging),
            'submissions'=>(new SubmissionService())->pageForUser($id,'STUDENT',null,$paging),
            'notebooks'=>\App\Core\Pagination::query('SELECT id,code,title,version,status,kernel_state,updated_at FROM notebooks WHERE student_id=:id ORDER BY id DESC',['id'=>$id],$paging),
            'models'=>\App\Core\Pagination::query('SELECT id,model_code,name,framework,current_version,status,updated_at FROM models WHERE student_id=:id ORDER BY id DESC',['id'=>$id],$paging),
            'experiments'=>\App\Core\Pagination::query('SELECT * FROM experiments WHERE student_id=:id ORDER BY id DESC',['id'=>$id],$paging),
            default=>throw new \InvalidArgumentException('Unknown student resource.')
        };
    }
    public function ticketResource(int $id,string $resource,int $actor):array{
        return $this->ticketPage($id,$resource,$actor)['items'];
    }
    public function ticketPage(int $id,string $resource,int $actor,array $paging=[]):array{
        $this->admin($actor);(new TicketService())->getTicket($id,$actor,'ADMIN');
        return match($resource){'students'=>$this->read->page('ticketStudents',$id,$paging),'datasets'=>$this->read->page('ticketDatasets',$id,$paging),'submissions'=>$this->read->page('ticketSubmissions',$id,$paging),default=>throw new \InvalidArgumentException('Unknown ticket resource.')};
    }
    public function scenarioResource(int $id,string $resource,int $actor):array{
        return $this->scenarioPage($id,$resource,$actor)['items'];
    }
    public function scenarioPage(int $id,string $resource,int $actor,array $paging=[]):array{
        $this->admin($actor);(new ScenarioService())->getScenario($id);
        return match($resource){'students'=>$this->read->page('scenarioStudents',$id,$paging),'datasets'=>$this->read->page('scenarioDatasets',$id,$paging),'tickets'=>$this->read->page('scenarioTickets',$id,$paging),default=>throw new \InvalidArgumentException('Unknown scenario resource.')};
    }
    public function scenarioAction(int $id,string $action,int $actor,?string $expectedRevision=null):array{
        $this->admin($actor);$s=new ScenarioService();
        return Database::transaction(function()use($id,$action,$actor,$s,$expectedRevision){
            Database::queryOne('SELECT id FROM scenarios WHERE id=:id FOR UPDATE',['id'=>$id]);$old=$s->getScenario($id);$target=$action==='publish'?'PUBLISHED':'ARCHIVED';
            if($expectedRevision!==null&&(!preg_match('/^[a-f0-9]{64}$/D',$expectedRevision)||!hash_equals($old['revision'],$expectedRevision)))throw new RuntimeException('This scenario changed in another editor. Reload before changing its lifecycle.',409);
            if($old['status']===$target)return $old;
            if($action==='publish'&&$old['status']==='DRAFT')$old=$s->updateScenario($id,['status'=>'READY_FOR_REVIEW','changelog'=>'Administrator publish: review stage'],$actor);
            return $s->updateScenario($id,['status'=>$target,'changelog'=>'Administrator '.$action],$actor);
        });
    }
}
