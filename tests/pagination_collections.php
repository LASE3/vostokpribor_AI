<?php
declare(strict_types=1);
/** Rollback-only collection contract checks; never create files or execute student code. */
if (PHP_SAPI !== 'cli') { http_response_code(403); exit; }
require_once __DIR__.'/../app/bootstrap.php';
use App\Core\Database;
use App\Core\Env;
use App\Core\Pagination;
use App\Services\ModelService;
use App\Services\NotebookService;
use App\Services\ExperimentService;
use App\Services\DeploymentService;
use App\Services\ValidationService;
use App\Services\TicketService;
use App\Services\DatasetService;
use App\Services\SubmissionService;
use App\Services\ScenarioService;
use App\Core\AccessDeniedException;
if (Env::get('APP_ENV')!=='testing' || !str_ends_with((string)Env::get('DB_NAME'),'_test') || !in_array(Env::get('DB_HOST'),['127.0.0.1','localhost','::1'],true)) {
    fwrite(STDERR,"REFUSED: dedicated loopback testing _test database required.\n"); exit(1);
}
$checks=0;
$check=static function(bool $ok,string $label)use(&$checks):void { if(!$ok)throw new RuntimeException('FAIL '.$label);++$checks;echo 'PASS '.$label.PHP_EOL; };
$reject=static function(callable $operation,string $type,string $label)use($check):void {
    try{$operation();}catch(Throwable $e){if(!$e instanceof $type)throw $e;$check(true,$label);return;}
    throw new RuntimeException('FAIL accepted '.$label);
};
$pdo=Database::getConnection();$db=Database::getInstance();
$counts=static function()use($pdo):array{$out=[];foreach($pdo->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN)as$table){if(!preg_match('/^[a-z_]+$/D',$table))throw new RuntimeException('Unexpected table.');$out[$table]=(int)$pdo->query('SELECT COUNT(*) FROM `'.$table.'`')->fetchColumn();}return$out;};
$before=$counts();$tag='PAGE-'.strtoupper(bin2hex(random_bytes(5)));
try {
    foreach ([['limit'=>0],['offset'=>-1],['limit'=>[]],['offset'=>'1.2'],['limit'=>true],['offset'=>'2147483648'],['limit'=>'1 OR 1=1']] as $bad) $reject(fn()=>Pagination::from($bad),InvalidArgumentException::class,'Malformed paging rejected '.json_encode($bad));
    $check(Pagination::from(['limit'=>'9999','offset'=>'7'])===['limit'=>200,'offset'=>7],'Maximum limit clamped and string integers accepted');
    $pdo->beginTransaction();
    $admin=(int)Database::queryOne("SELECT id FROM users WHERE role='ADMIN' ORDER BY id LIMIT 1")['id'];
    $hash=password_hash(bin2hex(random_bytes(24)),PASSWORD_DEFAULT);$students=[];
    for($n=0;$n<2;$n++)$students[]=$db->insert('users',['role'=>'STUDENT','email'=>$tag.$n.'@example.invalid','identifier'=>$tag.$n,'full_name'=>'Pagination contract fixture','password_hash'=>$hash,'status'=>'ACTIVE']);
    [$student,$foreign]=$students;
    $ticket=$db->insert('tickets',['ticket_code'=>$tag,'title'=>'Pagination contract ticket','created_by'=>$admin,'status'=>'ASSIGNED']);
    $db->insert('ticket_assignments',['ticket_id'=>$ticket,'student_id'=>$student,'assigned_by'=>$admin]);
    $json=json_encode(['original'=>str_repeat('saved metadata ',600)],JSON_THROW_ON_ERROR);$firstModel=0;$firstExperiment=0;
    for($n=0;$n<208;$n++) {
        $owner=$n<205?$student:$foreign;
        $workTicket=$n===0?$ticket:$db->insert('tickets',['ticket_code'=>$tag.'-T'.$n,'title'=>'Saved ticket '.$n,'created_by'=>$admin,'status'=>'ASSIGNED']);
        if($n!==0)$db->insert('ticket_assignments',['ticket_id'=>$workTicket,'student_id'=>$owner,'assigned_by'=>$admin]);
        $db->insert('scenarios',['code'=>$tag.'-S'.$n,'title'=>'Saved scenario '.$n,'author_id'=>$admin,'status'=>'DRAFT']);
        $dataset=$db->insert('datasets',['code'=>$tag.'-D'.$n,'name'=>'Saved dataset '.$n,'format'=>'csv','file_path'=>'UNAVAILABLE-PAGINATION-FIXTURE.csv','file_size'=>0,'checksum_sha256'=>str_repeat('0',64),'row_count'=>0,'column_count'=>0,'uploaded_by'=>$admin]);
        $datasetVersion=$db->insert('dataset_versions',['dataset_id'=>$dataset,'version'=>'fixture','format'=>'csv','file_path'=>'UNAVAILABLE-PAGINATION-FIXTURE.csv','file_size'=>0,'checksum_sha256'=>str_repeat('0',64),'row_count'=>0,'column_count'=>0,'uploaded_by'=>$admin]);
        Database::execute('UPDATE datasets SET current_version_id=:vid WHERE id=:did',['vid'=>$datasetVersion,'did'=>$dataset]);
        $db->insert('dataset_assignments',['dataset_id'=>$dataset,'dataset_version_id'=>$datasetVersion,'ticket_id'=>$workTicket,'student_id'=>$owner,'assigned_by'=>$admin]);
        $db->insert('processed_datasets',['source_dataset_id'=>$dataset,'source_dataset_version_id'=>$datasetVersion,'ticket_id'=>$workTicket,'student_id'=>$owner,'name'=>'Saved processed metadata '.$n,'format'=>'csv','file_path'=>'UNAVAILABLE-PAGINATION-FIXTURE-PROCESSED.csv','file_size'=>0,'checksum_sha256'=>str_repeat('0',64),'row_count'=>0]);
        $notebook=$db->insert('notebooks',['code'=>$tag.'-N'.$n,'title'=>'Saved notebook '.$n,'student_id'=>$owner,'ticket_id'=>$workTicket,'status'=>'SAVED']);
        $experiment=$db->insert('experiments',['code'=>$tag.'-E'.$n,'name'=>'Saved experiment '.$n,'student_id'=>$owner,'ticket_id'=>$workTicket]);
        if(!$firstExperiment)$firstExperiment=$experiment;
        $db->insert('experiment_runs',['run_uuid'=>$tag.'-R'.$n,'experiment_id'=>$experiment,'student_id'=>$owner,'notebook_id'=>$notebook,'run_name'=>'Saved run '.$n,'status'=>'RECORDED','parameters'=>'{"alpha":1}','metrics'=>'{"quality":0.9}']);
        $model=$db->insert('models',['model_code'=>$tag.'-M'.$n,'name'=>'Saved model '.$n,'framework'=>'metadata-only','student_id'=>$owner,'ticket_id'=>$workTicket,'metadata_json'=>$json,'status'=>$n===0?'ARCHIVED':'REGISTERED']);
        if(!$firstModel)$firstModel=$model;
        $version=$db->insert('model_versions',['model_id'=>$model,'version'=>'fixture','artifact_path'=>'UNAVAILABLE-PAGINATION-FIXTURE.json','artifact_format'=>'json','checksum_sha256'=>str_repeat('0',64),'file_size'=>0]);
        $db->insert('submissions',['submission_code'=>$tag.'-SUB'.$n,'ticket_id'=>$workTicket,'student_id'=>$owner,'model_id'=>$model,'status'=>'SUBMITTED']);
        $db->insert('validation_runs',['model_id'=>$model,'model_version_id'=>$version,'requested_by'=>$owner,'status'=>'NOT_EVALUATED']);
        $db->insert('deployment_requests',['model_id'=>$model,'model_version_id'=>$version,'requested_by'=>$owner,'status'=>'PENDING','provider_state'=>'NOT_CONFIGURED']);
    }
    $models=new ModelService();$notebooks=new NotebookService();$experiments=new ExperimentService();$validations=new ValidationService();$deployments=new DeploymentService();
    $collections=[
        'tickets'=>fn($paging)=>(new TicketService())->pageForUser($student,'STUDENT',[],$paging),
        'datasets'=>fn($paging)=>(new DatasetService())->pageForUser($student,'STUDENT',null,$paging),
        'processed'=>fn($paging)=>(new DatasetService())->pageProcessed($student,'STUDENT',$paging),
        'submissions'=>fn($paging)=>(new SubmissionService())->pageForUser($student,'STUDENT',null,$paging),
        'models'=>fn($paging)=>$models->pageModels($student,'STUDENT',null,$paging),
        'notebooks'=>fn($paging)=>$notebooks->pageForStudent($student,$paging),
        'experiments'=>fn($paging)=>$experiments->pageExperiments($student,$paging),
        'runs'=>fn($paging)=>$experiments->pageRuns($student,null,$paging),
        'artifacts'=>fn($paging)=>$models->pageArtifacts($student,'STUDENT',$paging),
        'validations'=>fn($paging)=>$validations->pageRuns($student,'STUDENT',null,$paging),
        'deployments'=>fn($paging)=>$deployments->pageDeployments(['id'=>$student,'role'=>'STUDENT'],$paging),
    ];
    foreach($collections as $label=>$load) {
        $default=$load([]);$first=$load(['limit'=>100]);$second=$load(['limit'=>100,'offset'=>100]);$last=$load(['limit'=>100,'offset'=>200]);$empty=$load(['offset'=>999]);
        $check($default['total']===205 && count($default['items'])===100 && $default['has_more'],$label.' bounded default retains exact authorized total');
        $check(!array_intersect(array_column($first['items'],'id'),array_column($second['items'],'id')) && count($last['items'])===5 && !$last['has_more'],$label.' non-overlapping stable windows reach every record');
        $check($empty['items']===[] && $empty['total']===205 && $empty['previous_offset']!==null,$label.' out-of-range page preserves real total');
        $check(Pagination::metadata($first)['next_offset']===100 && !array_key_exists('items',Pagination::metadata($first)),$label.' metadata has navigation without duplicating payload');
        $check(count($load(['limit'=>9999])['items'])===200,$label.' maximum bound enforced');
    }
    $scenarios=(new ScenarioService())->pageAll('DRAFT',['limit'=>100,'offset'=>200],['search'=>$tag]);
    $check($scenarios['total']===208 && count($scenarios['items'])===8,'Scenario status totals survive last window');
    $db->insert('ticket_assignments',['ticket_id'=>$ticket,'student_id'=>$foreign,'assigned_by'=>$admin]);
    $shared=(new TicketService())->pageForUser($admin,'ADMIN',['search'=>$tag],['limit'=>200]);
    $check($shared['total']===208 && count(array_unique(array_column($shared['items'],'id')))===200,'Two active students on one ticket do not duplicate administrator rows or totals');
    $check((new TicketService())->pageForUser($student,'STUDENT')['total']===205 && (new TicketService())->pageForUser($foreign,'STUDENT')['total']===4,'Shared ticket remains visible to each authorized student');
    $check((int)(new TicketService())->getTicket($ticket,$foreign,'STUDENT')['student_id']===$foreign,'Shared ticket detail identifies the authenticated assignee rather than another student');
    $check((new DatasetService())->pageForUser($foreign,'STUDENT')['total']===3,'Ticket sharing does not grant another student dataset automatically');
    $status=$models->pageModels($student,'STUDENT','ARCHIVED',['limit'=>1]);
    $check($status['total']===1 && count($status['items'])===1 && $status['items'][0]['status']==='ARCHIVED','Model status filter applied before count and limit');
    $summary=$models->pageModels($student,'STUDENT',null,[],true);
    $check(!array_key_exists('metadata_json',$summary['items'][0]),'Explicit UI summary omits unused large JSON');
    $check($models->getModel($firstModel,$student,'STUDENT')['metadata_json']===$json,'Detail preserves full metadata exactly');
    $check($models->pageModels($foreign,'STUDENT')['total']===3,'Foreign student receives only their own total and records');
    $reject(fn()=>$models->getModel($firstModel,$foreign,'STUDENT'),AccessDeniedException::class,'Foreign model detail denied');
    $reject(fn()=>$experiments->pageRuns($foreign,$firstExperiment,[]),AccessDeniedException::class,'Foreign experiment filter denied before paging');
    $recorded=$experiments->recordRun(['experiment_id'=>$firstExperiment,'run_name'=>'Manual measurement','status'=>'COMPLETED','measurement_source'=>'TRUSTED_RUNNER','trusted_measurement'=>true,'metrics'=>['quality'=>1]],$student);
    $check($recorded['status']==='RECORDED' && $recorded['measurement_source']==='USER_REPORTED' && $recorded['trusted_measurement']===false,'Server rejects forged trusted provenance for manual metrics');
    $saved=Database::queryOne('SELECT status,duration_seconds FROM experiment_runs WHERE run_uuid=:uuid',['uuid'=>$recorded['run_uuid']]);
    $check($saved['status']==='RECORDED' && $saved['duration_seconds']===null,'Manual record cannot fabricate execution status or duration');
    $run=$experiments->pageRuns($student,$firstExperiment,['limit'=>1])['items'][0];
    $check($run['measurement_source']==='USER_REPORTED' && $run['trusted_measurement']===false,'Reloaded recorded metrics retain explicit user-reported provenance');
    $ownVersion=(int)Database::queryOne('SELECT dataset_version_id FROM dataset_assignments WHERE ticket_id=:tid AND student_id=:uid LIMIT 1',['tid'=>$ticket,'uid'=>$student])['dataset_version_id'];
    $otherTicketVersion=(int)Database::queryOne('SELECT dataset_version_id FROM dataset_assignments WHERE ticket_id<>:tid AND student_id=:uid LIMIT 1',['tid'=>$ticket,'uid'=>$student])['dataset_version_id'];
    $reject(fn()=>$experiments->recordRun(['experiment_id'=>$firstExperiment,'run_name'=>'Unauthorized dataset version','dataset_version_id'=>$datasetVersion],$student),AccessDeniedException::class,'Foreign student dataset version cannot be attached to owned experiment');
    $reject(fn()=>$experiments->recordRun(['experiment_id'=>$firstExperiment,'run_name'=>'Wrong ticket version','dataset_version_id'=>$otherTicketVersion],$student),AccessDeniedException::class,'Owned dataset from another ticket cannot be attached to experiment');
    $linked=$experiments->recordRun(['experiment_id'=>$firstExperiment,'run_name'=>'Authorized pinned source','dataset_version_id'=>$ownVersion],$student);
    $persisted=Database::queryOne('SELECT dataset_version_id,measurement_source FROM experiment_runs WHERE run_uuid=:id',['id'=>$linked['run_uuid']]);
    $check((int)$persisted['dataset_version_id']===$ownVersion && $persisted['measurement_source']==='USER_REPORTED','Authorized immutable source version and untrusted provenance persist in actual schema008');
    $dossier=(new \App\Repositories\UserRepository())->getStudentDossier($student,['tickets_offset'=>200,'datasets_offset'=>200]);
    $check($dossier['pagination']['tickets']['total']===205 && count($dossier['tickets'])===5,'Dossier ticket window retains exact205 total and last5 records');
    $check($dossier['pagination']['datasets']['total']===205 && count($dossier['datasets'])===5,'Dossier dataset window uses authorized grants and independent offset');
    $progress=(new \App\Services\SocTrainingService())->studentResource($student,'progress',$admin);
    $check($progress['tickets_total']===205 && $progress['models']===205 && $progress['submissions']===205,'SOC progress aggregates full collections beyond default page');
    $pdo->rollBack();
    $check($before===$counts(),'Rollback preserved every original table count');
    echo 'PASS '.$checks.' pagination and provenance checks'.PHP_EOL;
} catch(Throwable $e) { if($pdo->inTransaction())$pdo->rollBack();fwrite(STDERR,$e->getMessage().PHP_EOL);exit(1); }
