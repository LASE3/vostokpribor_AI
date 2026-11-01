<?php
namespace App\Controllers;
use App\Core\Auth;
use App\Core\Request;
use App\Core\Response;
use App\Core\AccessDeniedException;
use App\Middleware\AuthorizationMiddleware;
use App\Services\SocWorkspaceService;
use App\Services\DeploymentService;

final class SocWorkspaceController
{
    private function respond(callable $operation):void
    {
        AuthorizationMiddleware::requireAdmin(true);
        try{Response::success($operation((int)Auth::id()));}
        catch(AccessDeniedException $e){Response::error($e->getMessage(),'ACCESS_DENIED',403);}
        catch(\InvalidArgumentException $e){Response::error($e->getMessage(),'VALIDATION_ERROR',422);}
        catch(\DomainException $e){Response::error($e->getMessage(),'UNAVAILABLE',503);}
    }
    private function list(Request $request,string $resource):void
    {
        AuthorizationMiddleware::requireAdmin(true);
        Response::paginated((new SocWorkspaceService())->pageResources($resource,$request->query(),(int)Auth::id()));
    }
    public function notebooks(Request $r):void{$this->list($r,'notebooks');}
    public function experiments(Request $r):void{$this->list($r,'experiments');}
    public function runs(Request $r):void{$this->list($r,'runs');}
    public function jobs(Request $r):void{$this->list($r,'jobs');}
    public function models(Request $r):void{$this->list($r,'models');}
    public function validations(Request $r):void{$this->list($r,'validations');}
    public function deploymentRequests(Request $r):void{$this->list($r,'requests');}
    public function deployments(Request $r):void
    {
        AuthorizationMiddleware::requireAdmin(true);
        Response::json(['success'=>true,'data'=>(new DeploymentService())->verifiedDeployments(Auth::user()),
            'message'=>'No verified runtime deployments; inference provider is not configured.',
            'availability'=>['status'=>'NOT_CONFIGURED','runtime_enabled'=>false]]);
    }
    public function notebook(Request $r,array $p):void{$this->respond(fn($a)=>(new SocWorkspaceService())->notebook((int)$p['id'],$a));}
    public function experiment(Request $r,array $p):void{$this->respond(fn($a)=>(new SocWorkspaceService())->experiment((int)$p['id'],$a,$r->query()));}
    public function model(Request $r,array $p):void{$this->respond(fn($a)=>(new SocWorkspaceService())->model((int)$p['id'],$a,$r->query()));}
    public function versions(Request $r,array $p):void{AuthorizationMiddleware::requireAdmin(true);Response::paginated((new \App\Services\ModelService())->pageVersions((int)$p['id'],(int)Auth::id(),'ADMIN',$r->query()));}
    public function validation(Request $r,array $p):void{$this->respond(fn($a)=>(new SocWorkspaceService())->validation((int)$p['id'],$a));}
    public function job(Request $r,array $p):void{$this->respond(fn($a)=>(new SocWorkspaceService())->job((string)$p['id'],$a));}
    public function cancelJob(Request $r,array $p):void{$this->respond(fn($a)=>(new SocWorkspaceService())->cancelJob((string)$p['id'],$a));}
    public function updateModel(Request $r,array $p):void{$this->respond(fn($a)=>(new SocWorkspaceService())->updateModel((int)$p['id'],$r->body(),$a));}
    public function approveDeployment(Request $r,array $p):void{$this->respond(fn($a)=>(new DeploymentService())->reviewDeployment((int)$p['id'],'APPROVED',$a,$r->body('notes')));}
    public function rejectDeployment(Request $r,array $p):void{$this->respond(fn($a)=>(new DeploymentService())->reviewDeployment((int)$p['id'],'REJECTED',$a,$r->body('notes')));}
    public function reviewDeployment(Request $r,array $p):void{$this->respond(fn($a)=>(new DeploymentService())->reviewDeployment((int)$p['id'],(string)$r->body('status',''),$a,$r->body('notes')));}
}
