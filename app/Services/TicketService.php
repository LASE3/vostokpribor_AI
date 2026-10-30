<?php
namespace App\Services;
use App\Core\Database;
use App\Core\Logger;
use App\Core\Validator;
use App\Core\AccessDeniedException;
use App\Repositories\TicketRepository;
use App\Repositories\UserRepository;
use InvalidArgumentException;
use RuntimeException;

class TicketService {
    private TicketRepository $ticketRepo;
    private UserRepository $userRepo;
    public function __construct(){$this->ticketRepo=new TicketRepository();$this->userRepo=new UserRepository();}
    private function actor(int $id):array{return Database::queryOne("SELECT id,role FROM users WHERE id=:id AND status='ACTIVE'",['id'=>$id])??throw new AccessDeniedException('Active account required.');}
    private function requireAdministrator(int $id):void{if($this->actor($id)['role']!=='ADMIN')throw new AccessDeniedException('Administrator access required.');}
    public function listTicketsForUser(int $userId,string $role,array $filters=[]):array{return $this->ticketRepo->listForUser($userId,$role,$filters);}
    public function getTicket(int $id,int $userId,string $role):array {
        $actor=$this->actor($userId);$t=$this->ticketRepo->findById($id);if(!$t)throw new \App\Core\NotFoundException('Ticket not found.');
        if($actor['role']!=='ADMIN'&&!Database::queryOne('SELECT id FROM ticket_assignments WHERE ticket_id=:tid AND student_id=:sid AND revoked_at IS NULL',['tid'=>$id,'sid'=>$userId]))throw new AccessDeniedException('Ticket is not assigned to you.');
        $t['comments']=$this->ticketRepo->getComments($id);return $t;
    }
    private function metadata(array $d,bool $create=false):array{
        $v=new Validator();$rules=['title'=>($create?'required|':'').'string|min:3|max:255','description'=>'string|max:60000','requirements'=>'string|max:60000','acceptance_criteria'=>'string|max:60000','priority'=>'in:CRITICAL,HIGH,MEDIUM,LOW'];
        if($create)$rules['ticket_code']='required|string|min:3|max:64';
        if(!$v->validate($d,$rules))throw new InvalidArgumentException($v->getFirstError()??'Invalid ticket.');
        $fields=[];
        foreach(['title','description','requirements','acceptance_criteria','priority'] as $f)if(array_key_exists($f,$d))$fields[$f]=trim((string)$d[$f]);
        if(array_key_exists('scenario_id',$d)){
            $raw=$d['scenario_id'];$fields['scenario_id']=null;
            if($raw!==null&&$raw!==''&&$raw!==0&&$raw!=='0'){if((!is_int($raw)&&!is_string($raw))||!filter_var($raw,FILTER_VALIDATE_INT,['options'=>['min_range'=>1]]))throw new InvalidArgumentException('Valid scenario_id required.');$fields['scenario_id']=(int)$raw;}
            if($fields['scenario_id']&&!Database::queryOne('SELECT id FROM scenarios WHERE id=:id',['id'=>$fields['scenario_id']]))throw new InvalidArgumentException('Scenario not found.');
        }
        if(array_key_exists('deadline',$d)){
            if($d['deadline']!==null&&!is_string($d['deadline']))throw new InvalidArgumentException('Deadline must be a date string.');
            $raw=trim((string)($d['deadline']??''));$fields['deadline']=null;
            if($raw!==''){$raw=str_replace('T',' ',$raw);if(strlen($raw)===16)$raw.=':00';$parsed=\DateTimeImmutable::createFromFormat('!Y-m-d H:i:s',$raw);if(!$parsed||$parsed->format('Y-m-d H:i:s')!==$raw)throw new InvalidArgumentException('Deadline must be a valid YYYY-MM-DD HH:MM:SS date.');$fields['deadline']=$raw;}
        }
        return $fields;
    }
    private function student(int $id):array{$u=$this->userRepo->findById($id);if(!$u||$u['role']!=='STUDENT'||$u['status']!=='ACTIVE')throw new InvalidArgumentException('Select an active student.');return $u;}
    private function notify(int $student,string $title,string $message,int $ticket):void{
        Database::getInstance()->insert('notifications',['user_id'=>$student,'title'=>$title,'message'=>$message,'type'=>'INFO','link'=>\App\Core\AppUrl::to('AI Project Management/TicketDetails.php?id='.$ticket)]);
    }
    public function createTicket(array $d,int $actorId):array{
        $this->requireAdministrator($actorId);$fields=$this->metadata($d,true);
        $code=strtoupper(trim($d['ticket_code']));if(!preg_match('/^[A-Z0-9][A-Z0-9_.-]{2,63}$/D',$code))throw new InvalidArgumentException('Invalid ticket code.');
        if(isset($d['status'])&&$d['status']!=='DRAFT')throw new InvalidArgumentException('New tickets must start in DRAFT.');
        $student=null;if(!empty($d['student_id'])){if((!is_int($d['student_id'])&&!is_string($d['student_id']))||!filter_var($d['student_id'],FILTER_VALIDATE_INT,['options'=>['min_range'=>1]]))throw new InvalidArgumentException('Valid student_id required.');$student=(int)$d['student_id'];$this->student($student);}
        return Database::transaction(function()use($d,$fields,$code,$student,$actorId){
            if($this->ticketRepo->findByCode($code))throw new InvalidArgumentException('Ticket code already exists.');
            $id=$this->ticketRepo->create($fields+['ticket_code'=>$code,'created_by'=>$actorId,'status'=>$student?'ASSIGNED':'DRAFT']);
            if($student){$this->ticketRepo->assignStudent($id,$student,$actorId,$d['assignment_notes']??null);$this->notify($student,'Ticket assigned',$code.' has been assigned to you.',$id);}
            $this->ticketRepo->recordStatusHistory($id,null,$student?'ASSIGNED':'DRAFT',$actorId,'Ticket created');
            Logger::audit('TICKET_CREATED','tickets',(string)$id,'SUCCESS',['code'=>$code,'student_id'=>$student],$actorId);
            return $this->ticketRepo->findById($id);
        });
    }
    public function updateTicket(int $id,array $d,int $actorId,string $actorRole):array{
        $actor=$this->actor($actorId);$role=$actor['role'];
        if($role==='STUDENT'&&array_diff(array_keys($d),['status','csrf_token']))throw new AccessDeniedException('Students can update permitted progress only.');
        $fields=$role==='ADMIN'?$this->metadata($d):[];
        return Database::transaction(function()use($id,$d,$fields,$actorId,$role){
            Database::queryOne('SELECT id FROM tickets WHERE id=:id FOR UPDATE',['id'=>$id]);$old=$this->getTicket($id,$actorId,$role);$changes=$fields;
            if(isset($d['status'])){
                if(!is_string($d['status']))throw new InvalidArgumentException('Status must be a supported string.');
                $next=$d['status'];
                if($next!==$old['status']){
                    $allowed=$role==='STUDENT'?['ASSIGNED'=>['IN_PROGRESS'],'CHANGES_REQUESTED'=>['IN_PROGRESS']]:['DRAFT'=>['CANCELLED'],'ASSIGNED'=>['IN_PROGRESS','CANCELLED'],'IN_PROGRESS'=>['CANCELLED'],'SUBMITTED'=>['UNDER_REVIEW','CANCELLED'],'UNDER_REVIEW'=>['CANCELLED'],'CHANGES_REQUESTED'=>['IN_PROGRESS','CANCELLED']];
                    if(!in_array($next,$allowed[$old['status']]??[],true))throw new InvalidArgumentException('Invalid ticket transition; submission/review decisions use their dedicated operations.');
                    $changes['status']=$next;
                }
            }
            foreach($changes as $key=>$value)if($value===($old[$key]??null))unset($changes[$key]);
            if(!$changes)return $this->ticketRepo->findById($id);
            if(in_array($old['status'],['APPROVED','CANCELLED'],true))throw new InvalidArgumentException('Terminal tickets are immutable.');
            $this->ticketRepo->update($id,$changes);
            if(isset($changes['status']))$this->ticketRepo->recordStatusHistory($id,$old['status'],$changes['status'],$actorId);
            if(($changes['status']??'')==='CANCELLED'){
                Database::execute('UPDATE dataset_assignments SET revoked_at=NOW(),revoked_by=:actor WHERE ticket_id=:tid AND revoked_at IS NULL',['actor'=>$actorId,'tid'=>$id]);
                foreach(Database::query('SELECT student_id FROM ticket_assignments WHERE ticket_id=:tid AND revoked_at IS NULL',['tid'=>$id]) as $a)$this->notify((int)$a['student_id'],'Ticket cancelled',$old['ticket_code'].' was cancelled by the administrator.',$id);
            }
            Logger::audit('TICKET_UPDATED','tickets',(string)$id,'SUCCESS',['changed_fields'=>array_keys($changes)],$actorId);
            return $this->ticketRepo->findById($id);
        });
    }
    public function assignTicket(int $ticketId,int $studentId,int $actorId,?string $notes=null):void{
        $this->requireAdministrator($actorId);$this->student($studentId);
        Database::transaction(function()use($ticketId,$studentId,$actorId,$notes){
            $t=Database::queryOne('SELECT * FROM tickets WHERE id=:id FOR UPDATE',['id'=>$ticketId]);if(!$t)throw new \App\Core\NotFoundException('Ticket not found.');
            if(Database::queryOne('SELECT id FROM ticket_assignments WHERE ticket_id=:tid AND student_id=:sid AND revoked_at IS NULL',['tid'=>$ticketId,'sid'=>$studentId]))return;
            if(!in_array($t['status'],['DRAFT','ASSIGNED','IN_PROGRESS','CHANGES_REQUESTED'],true))throw new InvalidArgumentException('Ticket state does not permit assignment.');
            $this->ticketRepo->assignStudent($ticketId,$studentId,$actorId,$notes);
            if($t['status']==='DRAFT'){$this->ticketRepo->update($ticketId,['status'=>'ASSIGNED']);$this->ticketRepo->recordStatusHistory($ticketId,'DRAFT','ASSIGNED',$actorId,'Student assigned');}
            $this->notify($studentId,'Ticket assigned',$t['ticket_code'].' has been assigned to you.',$ticketId);
            Logger::audit('TICKET_ASSIGNED','tickets',(string)$ticketId,'SUCCESS',['student_id'=>$studentId],$actorId);
        });
    }
    public function reassignTicket(int $ticketId,int $studentId,int $actorId,?string $notes=null):array{
        $this->requireAdministrator($actorId);$this->student($studentId);
        return Database::transaction(function()use($ticketId,$studentId,$actorId,$notes){
            $t=Database::queryOne('SELECT * FROM tickets WHERE id=:id FOR UPDATE',['id'=>$ticketId]);if(!$t)throw new \App\Core\NotFoundException('Ticket not found.');
            $previous=Database::query('SELECT student_id FROM ticket_assignments WHERE ticket_id=:tid AND revoked_at IS NULL ORDER BY student_id',['tid'=>$ticketId]);
            $ids=array_map(fn($a)=>(int)$a['student_id'],$previous);
            if($ids===[$studentId])return $this->ticketRepo->findById($ticketId);
            if(!in_array($t['status'],['DRAFT','ASSIGNED','IN_PROGRESS','CHANGES_REQUESTED'],true))throw new InvalidArgumentException('Only open tickets may be reassigned; reviewed work is never transferred.');
            foreach($ids as $oldStudent)if($oldStudent!==$studentId){
                Database::execute('UPDATE ticket_assignments SET revoked_at=NOW(),revoked_by=:actor WHERE ticket_id=:tid AND student_id=:sid AND revoked_at IS NULL',['actor'=>$actorId,'tid'=>$ticketId,'sid'=>$oldStudent]);
                Database::execute('UPDATE dataset_assignments SET revoked_at=NOW(),revoked_by=:actor WHERE ticket_id=:tid AND student_id=:sid AND revoked_at IS NULL',['actor'=>$actorId,'tid'=>$ticketId,'sid'=>$oldStudent]);
                $this->notify($oldStudent,'Ticket reassigned',$t['ticket_code'].' is no longer assigned to you. Your notebooks, models and submissions remain owned by you.',$ticketId);
            }
            if(!in_array($studentId,$ids,true)){$this->ticketRepo->assignStudent($ticketId,$studentId,$actorId,$notes);$this->notify($studentId,'Ticket assigned',$t['ticket_code'].' has been assigned to you. Dataset access requires a separate assignment.',$ticketId);}
            $this->ticketRepo->update($ticketId,['status'=>'ASSIGNED']);$this->ticketRepo->recordStatusHistory($ticketId,$t['status'],'ASSIGNED',$actorId,'Administrator reassignment: '.$notes);
            Logger::audit('TICKET_REASSIGNED','tickets',(string)$ticketId,'SUCCESS',['previous_students'=>$ids,'student_id'=>$studentId,'artifacts_transferred'=>false,'dataset_access_revoked'=>true],$actorId);
            return $this->ticketRepo->findById($ticketId);
        });
    }
    public function addComment(int $ticketId,int $userId,string $comment):array{
        $actor=$this->actor($userId);$this->getTicket($ticketId,$userId,$actor['role']);$comment=trim($comment);
        if($comment===''||strlen($comment)>10000)throw new InvalidArgumentException('Comment must contain 1 to 10000 bytes.');
        return Database::transaction(function()use($ticketId,$userId,$comment){
            $id=$this->ticketRepo->addComment($ticketId,$userId,$comment);
            Logger::audit('TICKET_COMMENT_ADDED','tickets',(string)$ticketId,'SUCCESS',['comment_id'=>$id],$userId);
            return Database::queryOne('SELECT * FROM ticket_comments WHERE id=:id',['id'=>$id]);
        });
    }
}
