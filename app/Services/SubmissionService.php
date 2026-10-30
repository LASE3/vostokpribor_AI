<?php
namespace App\Services;
use App\Core\Database;
use App\Core\Logger;
use App\Core\AccessDeniedException;
use App\Repositories\SubmissionRepository;
use App\Repositories\TicketRepository;
use InvalidArgumentException;
use RuntimeException;

class SubmissionService {
    private SubmissionRepository $subRepo;
    private TicketRepository $ticketRepo;
    public function __construct(){$this->subRepo=new SubmissionRepository();$this->ticketRepo=new TicketRepository();}
    public function listSubmissions(int $userId,string $role,?string $status=null):array{return $this->subRepo->listForUser($userId,$role,$status);}
    public function getSubmission(int $id,int $userId,string $role):array{
        $s=$this->subRepo->findById($id);if(!$s)throw new \App\Core\NotFoundException('Submission not found.');
        if($role!=='ADMIN'&&(int)$s['student_id']!==$userId)throw new AccessDeniedException('You do not own this submission.');
        return $s;
    }
    public function createSubmission(array $d,int $student):array{
        if(!Database::queryOne("SELECT id FROM users WHERE id=:id AND role='STUDENT' AND status='ACTIVE'",['id'=>$student]))throw new AccessDeniedException('Active student required.');
        $tid=filter_var($d['ticket_id']??null,FILTER_VALIDATE_INT);if(!$tid||$tid<1)throw new InvalidArgumentException('Valid ticket_id required.');
        if(isset($d['notes'])&&!is_string($d['notes']))throw new InvalidArgumentException('Submission notes must be text.');
        $notes=trim((string)($d['notes']??''));if(strlen($notes)>60000)throw new InvalidArgumentException('Submission notes too long.');
        $key=$d['request_key']??null;if($key!==null&&(!is_string($key)||!preg_match('/^[A-Za-z0-9_.:-]{1,128}$/D',$key)))throw new InvalidArgumentException('Invalid idempotency key.');
        foreach(['model_id','notebook_id'] as $field)if(!empty($d[$field])&&((!is_int($d[$field])&&!is_string($d[$field]))||!filter_var($d[$field],FILTER_VALIDATE_INT,['options'=>['min_range'=>1]])))throw new InvalidArgumentException('Valid '.$field.' required.');
        $mid=!empty($d['model_id'])?(int)$d['model_id']:null;$nid=!empty($d['notebook_id'])?(int)$d['notebook_id']:null;
        return Database::transaction(function()use($tid,$student,$notes,$key,$mid,$nid){
            $t=Database::queryOne('SELECT * FROM tickets WHERE id=:id FOR UPDATE',['id'=>$tid]);if(!$t)throw new \App\Core\NotFoundException('Ticket not found.');
            if(!Database::queryOne('SELECT id FROM ticket_assignments WHERE ticket_id=:tid AND student_id=:sid AND revoked_at IS NULL',['tid'=>$tid,'sid'=>$student]))throw new AccessDeniedException('Only active ticket assignments may submit.');
            if($key!==null){$existing=Database::queryOne('SELECT id,ticket_id,notes,model_id,notebook_id FROM submissions WHERE student_id=:sid AND request_key=:key',['sid'=>$student,'key'=>$key]);if($existing){if((int)$existing['ticket_id']!==$tid||($existing['notes']??'')!==$notes||($existing['model_id']?(int)$existing['model_id']:null)!==$mid||($existing['notebook_id']?(int)$existing['notebook_id']:null)!==$nid)throw new InvalidArgumentException('Idempotency key was already used with a different submission.');return $this->subRepo->findById((int)$existing['id']);}}
            $latest=Database::queryOne('SELECT * FROM submissions WHERE ticket_id=:tid AND student_id=:sid ORDER BY iteration DESC,id DESC LIMIT 1',['tid'=>$tid,'sid'=>$student]);
            if($latest&&in_array($latest['status'],['SUBMITTED','UNDER_REVIEW'],true)){
                if(($latest['notes']??'')===$notes&&($latest['model_id']?(int)$latest['model_id']:null)===$mid&&($latest['notebook_id']?(int)$latest['notebook_id']:null)===$nid)return $this->subRepo->findById((int)$latest['id']);
                throw new InvalidArgumentException('A pending submission already exists. Wait for its review before submitting a revision.');
            }
            if(!in_array($t['status'],['ASSIGNED','IN_PROGRESS','CHANGES_REQUESTED'],true))throw new InvalidArgumentException('Ticket is not open for submission.');
            foreach(['models'=>$mid,'notebooks'=>$nid] as $table=>$id)if($id&&!Database::queryOne("SELECT id FROM $table WHERE id=:id AND student_id=:sid AND ticket_id=:tid",['id'=>$id,'sid'=>$student,'tid'=>$tid]))throw new InvalidArgumentException('Attachment must belong to you and the assigned ticket.');
            $iteration=$this->subRepo->getNextIteration($tid,$student);
            $id=$this->subRepo->create(['submission_code'=>'SUB-'.strtoupper(substr(hash('sha256',$tid.':'.$student.':'.$iteration),0,24)),'ticket_id'=>$tid,'student_id'=>$student,'iteration'=>$iteration,'notes'=>$notes,'model_id'=>$mid,'notebook_id'=>$nid,'request_key'=>$key]);
            $this->ticketRepo->update($tid,['status'=>'SUBMITTED']);$this->ticketRepo->recordStatusHistory($tid,$t['status'],'SUBMITTED',$student,'Deliverable iteration '.$iteration);
            Logger::audit('SUBMISSION_CREATED','submissions',(string)$id,'SUCCESS',['ticket_id'=>$tid,'student_id'=>$student,'iteration'=>$iteration],$student);
            foreach(Database::query("SELECT id FROM users WHERE role='ADMIN' AND status='ACTIVE'") as $admin)Database::getInstance()->insert('notifications',['user_id'=>$admin['id'],'title'=>'Student work submitted','message'=>$t['ticket_code'].' has a new student submission.','type'=>'INFO','link'=>\App\Core\AppUrl::to('AI Operations Center (AI SOC)/WorkspaceConfiguration.php?id='.$id)]);
            return $this->subRepo->findById($id);
        });
    }
    public function reviewSubmission(int $id,array $d,int $admin):array{
        if(!Database::queryOne("SELECT id FROM users WHERE id=:id AND role='ADMIN' AND status='ACTIVE'",['id'=>$admin]))throw new AccessDeniedException('Active administrator required.');
        if(isset($d['status'])&&!is_string($d['status']))throw new InvalidArgumentException('Invalid review decision.');
        $decision=strtoupper((string)($d['status']??''));if(!in_array($decision,['APPROVED','CHANGES_REQUESTED','REJECTED'],true))throw new InvalidArgumentException('Invalid review decision.');
        if(isset($d['feedback'])&&!is_string($d['feedback']))throw new InvalidArgumentException('Feedback must be text.');
        $feedback=trim((string)($d['feedback']??''));if(strlen($feedback)>60000)throw new InvalidArgumentException('Feedback too long.');
        $score=$d['total_score']??null;if($score!==null&&(!is_numeric($score)||(float)$score<0||(float)$score>100))throw new InvalidArgumentException('Score must be between 0 and 100.');
        $score=$score!==null?(float)$score:null;
        if(isset($d['rubric_scores'])&&!is_array($d['rubric_scores']))throw new InvalidArgumentException('Rubric scores must be an object.');
        return Database::transaction(function()use($id,$decision,$feedback,$score,$d,$admin){
            $reference=Database::queryOne('SELECT ticket_id FROM submissions WHERE id=:id',['id'=>$id]);if(!$reference)throw new \App\Core\NotFoundException('Submission not found.');
            Database::queryOne('SELECT id FROM tickets WHERE id=:id FOR UPDATE',['id'=>$reference['ticket_id']]);
            $raw=Database::queryOne('SELECT * FROM submissions WHERE id=:id FOR UPDATE',['id'=>$id]);if(!$raw)throw new \App\Core\NotFoundException('Submission not found.');
            $oldScore=$raw['total_score']!==null?(float)$raw['total_score']:null;
            if(!in_array($raw['status'],['SUBMITTED','UNDER_REVIEW'],true)){
                if($raw['status']===$decision&&($raw['feedback']??'')===$feedback&&$oldScore===$score)return $this->subRepo->findById($id);
                throw new InvalidArgumentException('Submission already reviewed. A different decision requires a new student revision.');
            }
            $latest=Database::queryOne('SELECT id FROM submissions WHERE ticket_id=:tid AND student_id=:sid ORDER BY iteration DESC,id DESC LIMIT 1',['tid'=>$raw['ticket_id'],'sid'=>$raw['student_id']]);if((int)$latest['id']!==$id)throw new InvalidArgumentException('Review the latest iteration.');
            $ticket=Database::queryOne('SELECT status FROM tickets WHERE id=:id',['id'=>$raw['ticket_id']]);if($ticket['status']==='CANCELLED')throw new InvalidArgumentException('Cancelled tickets cannot be approved.');
            $this->subRepo->review($id,['status'=>$decision,'feedback'=>$feedback,'total_score'=>$score,'rubric_scores'=>$d['rubric_scores']??null,'reviewed_by'=>$admin]);
            $ticketStatus=$decision==='APPROVED'?'APPROVED':'CHANGES_REQUESTED';
            $this->ticketRepo->update((int)$raw['ticket_id'],['status'=>$ticketStatus]);$this->ticketRepo->recordStatusHistory((int)$raw['ticket_id'],$ticket['status'],$ticketStatus,$admin,'Submission reviewed: '.$decision);
            Database::getInstance()->insert('notifications',['user_id'=>$raw['student_id'],'title'=>'Submission reviewed','message'=>'Your submission was reviewed: '.$decision.'. '.$feedback,'type'=>$decision==='APPROVED'?'SUCCESS':'WARNING','link'=>\App\Core\AppUrl::to('AI Project Management/Submissions.php')]);
            Logger::audit('SUBMISSION_REVIEWED','submissions',(string)$id,'SUCCESS',['student_id'=>$raw['student_id'],'ticket_id'=>$raw['ticket_id'],'decision'=>$decision,'score'=>$score],$admin);
            return $this->subRepo->findById($id);
        });
    }
}
