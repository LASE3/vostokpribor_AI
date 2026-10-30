<?php
namespace App\Controllers;
use App\Core\Auth;
use App\Core\Request;
use App\Core\Response;
use App\Middleware\AuthorizationMiddleware;
use App\Services\UserService;
use App\Services\TicketService;
use App\Services\SubmissionService;
use App\Services\SocTrainingService;

class SocTrainingController {
    private function respond(callable $action):void{
        AuthorizationMiddleware::requireAdmin(true);
        try{Response::success($action());}
        catch(\App\Core\AccessDeniedException $e){Response::error($e->getMessage(),'FORBIDDEN',403);}
        catch(\InvalidArgumentException $e){Response::error($e->getMessage(),'VALIDATION_ERROR',422);}
        catch(\PDOException $e){error_log($e->getMessage());Response::error('Database operation failed.','SERVER_ERROR',500);}
        catch(\App\Core\NotFoundException $e){Response::error($e->getMessage(),'NOT_FOUND',404);}
        catch(\Throwable $e){error_log($e->getMessage());Response::error('Operation failed.','SERVER_ERROR',500);}
    }
    private function studentId(Request $request):int{
        $value=$request->body('student_id');
        if((!is_int($value)&&!is_string($value))||!filter_var($value,FILTER_VALIDATE_INT,['options'=>['min_range'=>1]]))throw new \InvalidArgumentException('Valid student_id required.');
        return (int)$value;
    }
    private function notes(Request $request):?string{
        $value=$request->body('notes');if($value!==null&&(!is_string($value)||strlen($value)>10000))throw new \InvalidArgumentException('Assignment notes must be text of at most 10000 bytes.');return $value;
    }
    public function activate(Request $r,array $p):void{$this->respond(fn()=>(new UserService())->setStatus((int)$p['id'],'ACTIVE',Auth::id()));}
    public function deactivate(Request $r,array $p):void{$this->respond(fn()=>(new UserService())->setStatus((int)$p['id'],'INACTIVE',Auth::id()));}
    public function resetPassword(Request $r,array $p):void{$this->respond(function()use($r,$p){$s=new UserService();$password=$r->body('new_password','');if(!is_string($password))throw new \InvalidArgumentException('Password must be text.');$s->resetPassword((int)$p['id'],$password,Auth::id());return ['id'=>(int)$p['id'],'must_change_password'=>true,'sessions_revoked'=>true];});}
    private function student(Request $r,array $p,string $resource):void{$this->respond(fn()=>(new SocTrainingService())->studentResource((int)$p['id'],$resource,Auth::id()));}
    public function studentProgress(Request $r,array $p):void{$this->student($r,$p,'progress');}
    public function studentActivity(Request $r,array $p):void{$this->student($r,$p,'activity');}
    public function studentTickets(Request $r,array $p):void{$this->student($r,$p,'tickets');}
    public function studentDatasets(Request $r,array $p):void{$this->student($r,$p,'datasets');}
    public function studentNotebooks(Request $r,array $p):void{$this->student($r,$p,'notebooks');}
    public function studentExperiments(Request $r,array $p):void{$this->student($r,$p,'experiments');}
    public function studentModels(Request $r,array $p):void{$this->student($r,$p,'models');}
    public function studentSubmissions(Request $r,array $p):void{$this->student($r,$p,'submissions');}
    public function reassignTicket(Request $r,array $p):void{$this->respond(fn()=>(new TicketService())->reassignTicket((int)$p['id'],$this->studentId($r),Auth::id(),$this->notes($r)));}
    public function cancelTicket(Request $r,array $p):void{$this->respond(fn()=>(new TicketService())->updateTicket((int)$p['id'],['status'=>'CANCELLED'],Auth::id(),'ADMIN'));}
    private function ticket(Request $r,array $p,string $resource):void{$this->respond(fn()=>(new SocTrainingService())->ticketResource((int)$p['id'],$resource,Auth::id()));}
    public function ticketStudents(Request $r,array $p):void{$this->ticket($r,$p,'students');}
    public function ticketDatasets(Request $r,array $p):void{$this->ticket($r,$p,'datasets');}
    public function ticketSubmissions(Request $r,array $p):void{$this->ticket($r,$p,'submissions');}
    public function publishScenario(Request $r,array $p):void{$this->respond(fn()=>(new SocTrainingService())->scenarioAction((int)$p['id'],'publish',Auth::id()));}
    public function archiveScenario(Request $r,array $p):void{$this->respond(fn()=>(new SocTrainingService())->scenarioAction((int)$p['id'],'archive',Auth::id()));}
    private function scenario(Request $r,array $p,string $resource):void{$this->respond(fn()=>(new SocTrainingService())->scenarioResource((int)$p['id'],$resource,Auth::id()));}
    public function scenarioTickets(Request $r,array $p):void{$this->scenario($r,$p,'tickets');}
    public function scenarioDatasets(Request $r,array $p):void{$this->scenario($r,$p,'datasets');}
    public function scenarioStudents(Request $r,array $p):void{$this->scenario($r,$p,'students');}
    private function review(Request $r,array $p,string $decision):void{$this->respond(fn()=>(new SubmissionService())->reviewSubmission((int)$p['id'],array_merge($r->body(),['status'=>$decision]),Auth::id()));}
    public function approveSubmission(Request $r,array $p):void{$this->review($r,$p,'APPROVED');}
    public function rejectSubmission(Request $r,array $p):void{$this->review($r,$p,'REJECTED');}
    public function requestChanges(Request $r,array $p):void{$this->review($r,$p,'CHANGES_REQUESTED');}
}
