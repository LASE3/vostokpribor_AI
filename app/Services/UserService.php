<?php
namespace App\Services;
use App\Core\Database;
use App\Core\Logger;
use App\Core\Validator;
use App\Core\AccessDeniedException;
use App\Repositories\UserRepository;
use InvalidArgumentException;
use RuntimeException;

class UserService {
    private UserRepository $userRepo;
    public function __construct(){ $this->userRepo=new UserRepository(); }
    private function admin(int $id):void {
        if(!Database::queryOne("SELECT id FROM users WHERE id=:id AND role='ADMIN' AND status='ACTIVE'",['id'=>$id])) throw new AccessDeniedException('Active administrator required.');
    }
    public function listStudents(array $filters=[],int $limit=50,int $offset=0):array {
        return ['items'=>$this->userRepo->listStudents($filters,min(100,max(1,$limit)),max(0,$offset)),'total'=>$this->userRepo->countStudents($filters),'limit'=>$limit,'offset'=>$offset];
    }
    public function getStudentDossier(int $id):?array {return $this->userRepo->getStudentDossier($id);}
    public function requireStudent(int $id):array {
        $u=$this->userRepo->findById($id);
        if(!$u||$u['role']!=='STUDENT')throw new \App\Core\NotFoundException('Student not found.');
        return $u;
    }
    private function password(string $p):void {if(strlen($p)<12||strlen($p)>72)throw new InvalidArgumentException('Password must contain 12 to 72 bytes.');}
    public function createStudent(array $d,int $actor):array {
        $this->admin($actor);
        if(isset($d['role'])&&$d['role']!=='STUDENT')throw new InvalidArgumentException('This operation creates students only.');
        $v=new Validator();
        if(!$v->validate($d,['full_name'=>'required|string|min:2|max:120','email'=>'required|email|max:191','identifier'=>'required|string|min:3|max:64','cohort'=>'string|max:64','department'=>'string|max:120','password'=>'required|string|min:12|max:72','status'=>'in:ACTIVE,INACTIVE,SUSPENDED']))throw new InvalidArgumentException($v->getFirstError()??'Invalid student.');
        $this->password((string)$d['password']);
        $email=strtolower(trim($d['email']));$ident=strtoupper(trim($d['identifier']));
        if($this->userRepo->findByEmailOrIdentifier($email)||$this->userRepo->findByEmailOrIdentifier($ident))throw new InvalidArgumentException('Email or identifier already exists.');
        return Database::transaction(function()use($d,$actor,$email,$ident){
            $id=$this->userRepo->createStudent(['email'=>$email,'identifier'=>$ident,'full_name'=>trim($d['full_name']),'password_hash'=>password_hash($d['password'],PASSWORD_DEFAULT),'cohort'=>trim($d['cohort']??''),'department'=>trim($d['department']??''),'status'=>$d['status']??'ACTIVE','must_change_password'=>1]);
            Logger::audit('STUDENT_CREATED','users',(string)$id,'SUCCESS',['identifier'=>$ident],$actor);
            return $this->requireStudent($id);
        });
    }
    public function updateStudent(int $id,array $d,int $actor):array {
        $this->admin($actor);
        if(isset($d['role'])&&$d['role']!=='STUDENT')throw new InvalidArgumentException('Student roles cannot be promoted.');
        $v=new Validator();
        if(!$v->validate($d,['full_name'=>'string|min:2|max:120','email'=>'email|max:191','cohort'=>'string|max:64','department'=>'string|max:120','status'=>'in:ACTIVE,INACTIVE,SUSPENDED']))throw new InvalidArgumentException($v->getFirstError()??'Invalid student data.');
        if(isset($d['password']))$this->password((string)$d['password']);
        return Database::transaction(function()use($id,$d,$actor){
            Database::queryOne('SELECT id FROM users WHERE id=:id FOR UPDATE',['id'=>$id]);$old=$this->requireStudent($id);$fields=[];
            foreach(['full_name','email','cohort','department','status'] as $key)if(array_key_exists($key,$d)){$value=trim((string)$d[$key]);if($key==='email')$value=strtolower($value);if($value!==($old[$key]??''))$fields[$key]=$value;}
            if(isset($fields['email'])){$existing=$this->userRepo->findByEmailOrIdentifier($fields['email']);if($existing&&(int)$existing['id']!==$id)throw new InvalidArgumentException('Email address already in use.');}
            if(isset($d['password'])){
                $hash=Database::queryOne('SELECT password_hash FROM users WHERE id=:id',['id'=>$id])['password_hash'];
                if(!(int)$old['must_change_password']||!password_verify($d['password'],$hash)){$fields['password_hash']=password_hash($d['password'],PASSWORD_DEFAULT);$fields['must_change_password']=1;}
            }
            if(!$fields)return $old;
            $this->userRepo->updateStudent($id,$fields);
            if(isset($fields['password_hash'])||isset($fields['status']))Database::execute('UPDATE users SET session_version=session_version+1 WHERE id=:id',['id'=>$id]);
            Logger::audit(isset($fields['password_hash'])?'STUDENT_PASSWORD_RESET':'STUDENT_UPDATED','users',(string)$id,'SUCCESS',['changed_fields'=>array_values(array_diff(array_keys($fields),['password_hash']))],$actor);
            if(isset($fields['password_hash']))Database::getInstance()->insert('notifications',['user_id'=>$id,'title'=>'Password reset by administrator','message'=>'Your administrator reset your password. Sign in with the new initial password and change it before continuing.','type'=>'WARNING']);
            return $this->requireStudent($id);
        });
    }
    public function resetPassword(int $id,string $newPassword,int $actorId):void {$this->updateStudent($id,['password'=>$newPassword],$actorId);}
    public function setStatus(int $id,string $status,int $actorId):array{return $this->updateStudent($id,['status'=>$status],$actorId);}
}
