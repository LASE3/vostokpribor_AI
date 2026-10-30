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
        $this->admin($actor);$users=new UserService();$users->requireStudent($id);
        if($resource==='activity')return $this->read->studentActivity($id);
        $d=$users->getStudentDossier($id);
        if($resource==='progress')return ['student'=>$d['profile'],'tickets_total'=>count($d['tickets']),'tickets_by_status'=>array_count_values(array_column($d['tickets'],'status')),'notebooks'=>count($d['notebooks']),'experiments'=>count($d['experiments']),'models'=>count($d['models']),'submissions'=>count($d['submissions']),'submissions_by_status'=>array_count_values(array_column($d['submissions'],'status'))];
        if($resource==='experiments')return Database::query('SELECT * FROM experiments WHERE student_id=:id ORDER BY id DESC',['id'=>$id]);
        if(!in_array($resource,['tickets','datasets','notebooks','models','submissions'],true))throw new RuntimeException('Unknown student resource.');
        return $d[$resource];
    }
    public function ticketResource(int $id,string $resource,int $actor):array{
        $this->admin($actor);(new TicketService())->getTicket($id,$actor,'ADMIN');
        return match($resource){'students'=>$this->read->ticketStudents($id),'datasets'=>$this->read->ticketDatasets($id),'submissions'=>$this->read->ticketSubmissions($id),default=>throw new RuntimeException('Unknown ticket resource.')};
    }
    public function scenarioResource(int $id,string $resource,int $actor):array{
        $this->admin($actor);(new ScenarioService())->getScenario($id);
        return match($resource){'students'=>$this->read->scenarioStudents($id),'datasets'=>$this->read->scenarioDatasets($id),'tickets'=>$this->read->scenarioTickets($id),default=>throw new RuntimeException('Unknown scenario resource.')};
    }
    public function scenarioAction(int $id,string $action,int $actor):array{
        $this->admin($actor);$s=new ScenarioService();
        return Database::transaction(function()use($id,$action,$actor,$s){
            Database::queryOne('SELECT id FROM scenarios WHERE id=:id FOR UPDATE',['id'=>$id]);$old=$s->getScenario($id);$target=$action==='publish'?'PUBLISHED':'ARCHIVED';
            if($old['status']===$target)return $old;
            if($action==='publish'&&$old['status']==='DRAFT')$old=$s->updateScenario($id,['status'=>'READY_FOR_REVIEW','changelog'=>'Administrator publish: review stage'],$actor);
            return $s->updateScenario($id,['status'=>$target,'changelog'=>'Administrator '.$action],$actor);
        });
    }
}
