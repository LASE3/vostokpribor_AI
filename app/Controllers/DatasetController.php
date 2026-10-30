<?php
namespace App\Controllers;

use App\Core\AccessDeniedException;
use App\Core\Auth;
use App\Core\Request;
use App\Core\Response;
use App\Middleware\AuthenticationMiddleware;
use App\Middleware\AuthorizationMiddleware;
use App\Services\DatasetService;

class DatasetController
{
    private DatasetService $service;
    public function __construct(){ $this->service=new DatasetService(); }

    private function identifier(mixed $value,bool $optional=false):?int
    {
        if($optional&&($value===null||$value===''))return null;
        $id=filter_var($value,FILTER_VALIDATE_INT);
        if($id===false||$id<=0)throw new \InvalidArgumentException('A positive resource identifier is required.');
        return $id;
    }

    private function respond(callable $operation,string $message='Operation completed successfully',int $status=200):void
    {
        try{Response::success($operation(),$message,$status);}
        catch(AccessDeniedException $e){Response::error($e->getMessage(),'ACCESS_DENIED',403);}
        catch(\InvalidArgumentException|\JsonException $e){Response::error($e->getMessage(),'VALIDATION_ERROR',422);}
        catch(\Throwable $e){error_log('Dataset operation failed: '.$e->getMessage());Response::error('Dataset operation failed. Check storage and database configuration.','SERVER_ERROR',500);}
    }

    public function index(Request $request):void
    {
        $user=AuthenticationMiddleware::handle(true);
        $this->respond(function()use($request,$user){
            $format=$request->query('format');
            if($format!==null&&!is_string($format))throw new \InvalidArgumentException('Format filter must be a string.');
            return $this->service->listForUser((int)$user['id'],$user['role'],$format);
        });
    }

    public function show(Request $request,array $params):void
    {
        $user=AuthenticationMiddleware::handle(true);
        $this->respond(fn()=>$this->service->getDataset($this->identifier($params['id']??null),(int)$user['id'],$user['role'],$this->identifier($request->query('version_id'),true)));
    }

    public function preview(Request $request,array $params):void
    {
        $user=AuthenticationMiddleware::handle(true);
        $this->respond(function()use($request,$params,$user){
            $limit=filter_var($request->query('limit',20),FILTER_VALIDATE_INT);
            if($limit===false||$limit<1||$limit>50)throw new \InvalidArgumentException('Preview limit must be an integer from 1 to 50.');
            return $this->service->getPreview($this->identifier($params['id']??null),(int)$user['id'],$user['role'],$limit,$this->identifier($request->query('version_id'),true));
        });
    }

    public function versions(Request $request,array $params):void
    {
        $user=AuthenticationMiddleware::handle(true);
        $this->respond(fn()=>$this->service->versions($this->identifier($params['id']??null),(int)$user['id'],$user['role']));
    }

    private function sendFile(string $path,string $name,string $extension):void
    {
        $name=preg_replace('/[^A-Za-z0-9_.-]/','_',basename($name));
        header('Content-Type: application/octet-stream');
        header('X-Content-Type-Options: nosniff');
        header('Cache-Control: private, no-store');
        header('Content-Disposition: attachment; filename="'.$name.'.'.$extension.'"');
        header('Content-Length: '.filesize($path));
        readfile($path);exit;
    }

    public function download(Request $request,array $params):void
    {
        $user=AuthenticationMiddleware::handle(true);
        $this->respond(function()use($request,$params,$user){
            $id=$this->identifier($params['id']??null);$version=$this->identifier($request->query('version_id'),true);
            $d=$this->service->getDataset($id,(int)$user['id'],$user['role'],$version);
            $path=$this->service->getDownloadPath($id,(int)$user['id'],$user['role'],$version);
            $this->sendFile($path,$d['name'].'-'.$d['version'],$d['format']);
        });
    }

    public function store(Request $request):void
    {
        AuthorizationMiddleware::requireAdmin(true);
        $this->respond(fn()=>$this->service->uploadDataset($request->file('dataset_file')??[],$request->body(),Auth::id()),'Dataset uploaded and saved',201);
    }

    public function update(Request $request,array $params):void
    {
        AuthorizationMiddleware::requireAdmin(true);
        $this->respond(fn()=>$this->service->updateMetadata($this->identifier($params['id']??null),$request->body(),Auth::id()),'Dataset metadata saved');
    }

    public function addVersion(Request $request,array $params):void
    {
        AuthorizationMiddleware::requireAdmin(true);
        $this->respond(fn()=>$this->service->addVersion($this->identifier($params['id']??null),$request->file('dataset_file')??[],$request->body(),Auth::id()),'Immutable dataset version saved',201);
    }

    public function assign(Request $request,array $params):void
    {
        AuthorizationMiddleware::requireAdmin(true);
        $this->respond(function()use($request,$params){
            $this->service->assignDataset($this->identifier($params['id']??null),$this->identifier($request->body('student_id')),Auth::id(),$this->identifier($request->body('ticket_id')),$this->identifier($request->body('dataset_version_id'),true));
            return ['persisted'=>true];
        },'Dataset assignment saved');
    }

    public function revoke(Request $request,array $params):void
    {
        AuthorizationMiddleware::requireAdmin(true);
        $this->respond(function()use($request,$params){
            $this->service->revokeDataset($this->identifier($params['id']??null),$this->identifier($request->body('student_id')),Auth::id(),$this->identifier($request->body('ticket_id'),true));
            return ['persisted'=>true];
        },'Dataset access revoked; historical files and processed work retained');
    }

    public function archive(Request $request,array $params):void
    {
        AuthorizationMiddleware::requireAdmin(true);
        $this->respond(fn()=>$this->service->archiveDataset($this->identifier($params['id']??null),Auth::id()),'Dataset archived; files and history retained');
    }

    public function assignments(Request $request,array $params):void
    {
        AuthorizationMiddleware::requireAdmin(true);
        $this->respond(fn()=>$this->service->assignments($this->identifier($params['id']??null),Auth::id()));
    }

    public function activity(Request $request,array $params):void
    {
        AuthorizationMiddleware::requireAdmin(true);
        $this->respond(fn()=>$this->service->activity($this->identifier($params['id']??null),Auth::id()));
    }

    public function activityIndex(Request $request):void
    {
        $user=AuthenticationMiddleware::handle(true);
        $this->respond(fn()=>$this->service->activityForUser((int)$user['id'],$user['role']));
    }

    public function processedIndex(Request $request):void
    {
        $user=AuthenticationMiddleware::handle(true);
        $this->respond(fn()=>$this->service->listProcessed((int)$user['id'],$user['role']));
    }

    public function processedShow(Request $request,array $params):void
    {
        $user=AuthenticationMiddleware::handle(true);
        $this->respond(fn()=>$this->service->getProcessed($this->identifier($params['id']??null),(int)$user['id'],$user['role']));
    }

    public function processedDownload(Request $request,array $params):void
    {
        $user=AuthenticationMiddleware::handle(true);
        $this->respond(function()use($params,$user){
            $id=$this->identifier($params['id']??null);$d=$this->service->getProcessed($id,(int)$user['id'],$user['role']);
            $this->sendFile($this->service->processedDownload($id,(int)$user['id'],$user['role']),$d['name'],$d['format']);
        });
    }

    public function storeProcessed(Request $request):void
    {
        $user=AuthenticationMiddleware::handle(true);
        $this->respond(fn()=>$this->service->uploadProcessedDataset($this->identifier($request->body('source_dataset_id')),(int)$user['id'],$this->identifier($request->body('ticket_id')),$request->file('processed_file')??[],$request->body()),'Processed data saved as a separate artifact',201);
    }
}
