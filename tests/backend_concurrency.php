<?php
declare(strict_types=1);
if(PHP_SAPI!=='cli'){http_response_code(403);exit;}
require_once __DIR__.'/../app/bootstrap.php';
use App\Core\{Database,Env,Auth,RateLimiter};
use App\Services\{UserService,ScenarioService,TicketService,NotebookService,ModelService,SocWorkspaceService,ValidationService,ExecutionService};
if(Env::get('APP_ENV')!=='testing'||!str_ends_with((string)Env::get('DB_NAME'),'_test')||!in_array(Env::get('DB_HOST'),['127.0.0.1','localhost','::1'],true))throw new RuntimeException('REFUSED: isolated loopback _test database required.');
Database::getConnection()->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
Database::execute('SET SESSION innodb_lock_wait_timeout=10');
if(($argv[1]??'')==='worker'){
    $p=json_decode(stream_get_contents(STDIN),true,32,JSON_THROW_ON_ERROR);
    if($p['operation']==='password'){
        $_SESSION['user_id']=$p['student'];$_SESSION['session_version']=$p['generation'];$_SESSION['last_activity']=time();Auth::user();
    }
    echo json_encode(['ready'=>true,'connection'=>(int)Database::queryOne('SELECT CONNECTION_ID() AS id')['id']])."\n";flush();
    try{
        $result=match($p['operation']){
            'rate'=>array_map(fn()=>RateLimiter::hit($p['key'],60),range(1,$p['count'])),
            'admission'=>RateLimiter::consume($p['key'],7,60),
            'scenario'=>(new ScenarioService())->updateScenario($p['id'],['title'=>'Concurrent title'],$p['admin']),
            'scenario-stale'=>(new ScenarioService())->updateScenario($p['id'],['title'=>'Stale editor must not win','expected_revision'=>$p['revision']],$p['admin']),
            'notebook-stale'=>(new NotebookService())->saveNotebook($p['id'],['cells'=>[['cell_type'=>'code','source'=>'stale source must not win']],'expected_version'=>$p['version']],$p['student'],'STUDENT'),
            'comment'=>(new TicketService())->addComment($p['id'],$p['student'],'Must be denied after reassignment'),
            'password'=>Auth::changePassword($p['old_password'],$p['new_password']),
            'validation'=>(new ValidationService())->runValidation($p['id'],$p['version'],$p['student']),
            'cancel'=>(new ExecutionService())->cancelJob($p['uuid'],$p['admin'],'ADMIN'),
            default=>throw new RuntimeException('Unknown operation')
        };
        echo json_encode(['success'=>true,'result'=>$result])."\n";
    }catch(Throwable $e){echo json_encode(['success'=>false,'exception'=>get_class($e),'code'=>$e->getCode(),'message'=>$e->getMessage(),'source'=>basename($e->getFile()).':'.$e->getLine()])."\n";}
    exit;
}
$passed=0;
$check=function(bool $ok,string $label)use(&$passed){if(!$ok)throw new RuntimeException('FAIL '.$label);echo "PASS $label\n";$passed++;};
$start=function(array $payload):array{
    $process=proc_open([PHP_BINARY,__FILE__,'worker'],[['pipe','r'],['pipe','w'],['pipe','w']],$pipes,__DIR__);
    if(!is_resource($process))throw new RuntimeException('Cannot start test worker');
    fwrite($pipes[0],json_encode($payload,JSON_THROW_ON_ERROR));fclose($pipes[0]);
    // Windows anonymous pipes do not support reliable nonblocking reads.
    // Workers emit one readiness line before any operation that can wait on a lock.
    $line=fgets($pipes[1]);$ready=json_decode($line?:'',true);
    if(!($ready['ready']??false))throw new RuntimeException('Worker did not initialize: '.stream_get_contents($pipes[2]));
    return ['process'=>$process,'pipes'=>$pipes,'connection'=>$ready['connection']];
};
$finish=function(array $worker):array{
    $line=fgets($worker['pipes'][1]);$errors=stream_get_contents($worker['pipes'][2]);fclose($worker['pipes'][1]);fclose($worker['pipes'][2]);proc_close($worker['process']);
    $result=json_decode($line?:'',true);
    if(!is_array($result))throw new RuntimeException('Invalid worker result '.$errors);
    return $result;
};
$observer=new PDO('mysql:host='.Env::get('DB_HOST').';port='.Env::get('DB_PORT',3306).';dbname='.Env::get('DB_NAME'),(string)Env::get('DB_USER'),(string)Env::get('DB_PASS'),[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
$waitLocked=function(array $worker)use($finish,$observer):void{
    $deadline=microtime(true)+10;
    do{
        $statement=$observer->prepare('SELECT COUNT(*) AS n FROM information_schema.INNODB_TRX WHERE trx_mysql_thread_id=:id AND trx_state=\'LOCK WAIT\'');$statement->execute(['id'=>$worker['connection']]);if((int)$statement->fetchColumn()>0)return;
        // MariaDB may expose a native prepared locking SELECT as Statistics before
        // registering its waiting transaction in INNODB_TRX. The parent owns the
        // exact target row throughout this observation and releases it afterward.
        $statement=$observer->prepare('SELECT STATE,INFO FROM information_schema.PROCESSLIST WHERE ID=:id');$statement->execute(['id'=>$worker['connection']]);$state=$statement->fetch(PDO::FETCH_ASSOC);
        if(($state['STATE']??'')==='Statistics'&&str_contains(strtoupper($state['INFO']??''),'FOR UPDATE'))return;
        usleep(50000);
    }while(microtime(true)<$deadline);
    $statement=$observer->prepare('SELECT ID,STATE FROM information_schema.PROCESSLIST WHERE ID=:id');$statement->execute(['id'=>$worker['connection']]);
    throw new RuntimeException('Worker did not reach expected MySQL row-lock wait; connection '.$worker['connection'].' state '.json_encode($statement->fetch(PDO::FETCH_ASSOC)).'; result '.json_encode($finish($worker)));
};
$pdo=Database::getConnection();$tag='V6-CONCURRENT-'.strtoupper(bin2hex(random_bytes(5)));
$admin=(int)(Database::queryOne("SELECT id FROM users WHERE role='ADMIN' AND status='ACTIVE' ORDER BY id LIMIT 1")['id']??0);if(!$admin)throw new RuntimeException('Existing test administrator required.');
$users=new UserService();$tickets=new TicketService();$scenarios=new ScenarioService();$oldPassword=bin2hex(random_bytes(20));
$a=$users->createStudent(['full_name'=>'V6 concurrency A','identifier'=>$tag.'A','email'=>strtolower($tag).'a@example.invalid','password'=>$oldPassword],$admin);
$b=$users->createStudent(['full_name'=>'V6 concurrency B','identifier'=>$tag.'B','email'=>strtolower($tag).'b@example.invalid','password'=>bin2hex(random_bytes(20))],$admin);
$sid=(int)$a['id'];$other=(int)$b['id'];$scenario=$scenarios->createScenario(['code'=>$tag,'title'=>'Concurrent baseline'],$admin);$scenarioId=(int)$scenario['id'];
$ticket=$tickets->createTicket(['ticket_code'=>$tag,'title'=>'Concurrency ticket','scenario_id'=>$scenarioId,'student_id'=>$sid],$admin);$tid=(int)$ticket['id'];
$notebook=(new NotebookService())->createNotebook(['title'=>'Concurrency cancellation notebook','ticket_id'=>$tid],$sid);
try{
    $key=$tag.'-HITS';$pdo->beginTransaction();Database::execute('INSERT INTO rate_limits(rate_key,hits,reset_at) VALUES(:key,0,:reset)',['key'=>$key,'reset'=>time()+60]);
    $workers=[];for($i=0;$i<8;$i++)$workers[]=$start(['operation'=>'rate','key'=>$key,'count'=>20]);$waitLocked($workers[0]);$pdo->commit();
    foreach($workers as $worker)$check($finish($worker)['success'],'Concurrent first-hit worker completes without duplicate-key error');
    $check((int)Database::queryOne('SELECT hits FROM rate_limits WHERE rate_key=:key',['key'=>$key])['hits']===160,'160 parallel rate hits are retained without lost updates');
    $key=$tag.'-ADMIT';$workers=[];for($i=0;$i<16;$i++)$workers[]=$start(['operation'=>'admission','key'=>$key]);$allowed=0;
    foreach($workers as $worker){$result=$finish($worker);if(!$result['success'])throw new RuntimeException('Admission worker failed');$allowed+=(int)$result['result']['allowed'];}
    $check($allowed===7,'Exactly seven concurrent admissions succeed at limit seven');
    Database::execute('UPDATE rate_limits SET reset_at=:now WHERE rate_key=:key',['now'=>time(),'key'=>$key]);$renew=RateLimiter::consume($key,7,60);
    $check($renew['allowed']&&$renew['hits']===1,'Bucket expires at the exact reset timestamp');
    RateLimiter::hit($key,60);RateLimiter::refund($key,$renew['reset_at']);
    $check((int)Database::queryOne('SELECT hits FROM rate_limits WHERE rate_key=:key',['key'=>$key])['hits']===1,'Successful reservation refund preserves concurrent failure');

    $pdo->beginTransaction();Database::queryOne('SELECT id FROM scenarios WHERE id=:id FOR UPDATE',['id'=>$scenarioId]);$worker=$start(['operation'=>'scenario','id'=>$scenarioId,'admin'=>$admin]);$waitLocked($worker);
    $scenarios->updateScenario($scenarioId,['description'=>'Committed while second editor waits'],$admin);$pdo->commit();$result=$finish($worker);$saved=$scenarios->getScenario($scenarioId);
    $check($result['success']&&$saved['title']==='Concurrent title'&&$saved['description']==='Committed while second editor waits','Concurrent partial scenario edits preserve both committed fields');
    $check(count($saved['builder_metadata']['history'])===3,'Concurrent scenario edits preserve both actual history events');

    $revision=$saved['revision'];$pdo->beginTransaction();Database::queryOne('SELECT id FROM scenarios WHERE id=:id FOR UPDATE',['id'=>$scenarioId]);$worker=$start(['operation'=>'scenario-stale','id'=>$scenarioId,'revision'=>$revision,'admin'=>$admin]);$waitLocked($worker);
    $scenarios->updateScenario($scenarioId,['description'=>'Version-protected first editor','expected_revision'=>$revision],$admin);$pdo->commit();$result=$finish($worker);$saved=$scenarios->getScenario($scenarioId);
    $check(!$result['success']&&$result['exception']===RuntimeException::class&&$result['code']===409,'Concurrent stale scenario editor receives conflict');
    $check($saved['title']==='Concurrent title'&&$saved['description']==='Version-protected first editor'&&count($saved['builder_metadata']['history'])===4,'Stale scenario payload cannot overwrite fields or append history');
    $listed=array_values(array_filter($scenarios->listAll(),fn($row)=>(int)$row['id']===$scenarioId))[0];$check($listed['revision']===$saved['revision']&&$saved['revision']!==$revision,'Scenario list/detail share stable persisted-field revision');

    $nid=(int)$notebook['id'];$version=(int)$notebook['version'];$pdo->beginTransaction();Database::queryOne('SELECT id FROM notebooks WHERE id=:id FOR UPDATE',['id'=>$nid]);$worker=$start(['operation'=>'notebook-stale','id'=>$nid,'version'=>$version,'student'=>$sid]);$waitLocked($worker);
    (new NotebookService())->saveNotebook($nid,['cells'=>[['cell_type'=>'code','source'=>'first editor source retained']],'expected_version'=>(string)$version],$sid,'STUDENT');$pdo->commit();$result=$finish($worker);$saved=(new NotebookService())->getNotebook($nid,$sid,'STUDENT');
    $check(!$result['success']&&$result['exception']===RuntimeException::class&&$result['code']===409,'Concurrent stale notebook editor receives conflict');
    $check($saved['cells'][0]['source']==='first editor source retained'&&(int)$saved['version']===$version+1,'Stale notebook payload cannot overwrite committed cells or increment version');
    $check((int)Database::queryOne("SELECT COUNT(*) AS n FROM audit_logs WHERE action='NOTEBOOK_SAVED' AND resource_id=:id",['id'=>$nid])['n']===1,'Rejected stale notebook creates no success audit');

    $pdo->beginTransaction();Database::queryOne('SELECT id FROM users WHERE id=:id FOR UPDATE',['id'=>$sid]);$worker=$start(['operation'=>'password','student'=>$sid,'generation'=>(int)$a['session_version'],'old_password'=>$oldPassword,'new_password'=>bin2hex(random_bytes(20))]);$waitLocked($worker);
    $resetPassword=bin2hex(random_bytes(20));$users->resetPassword($sid,$resetPassword,$admin);$pdo->commit();$result=$finish($worker);$stored=Database::queryOne('SELECT password_hash,session_version,must_change_password FROM users WHERE id=:id',['id'=>$sid]);
    $check(!$result['success']&&$result['exception']===App\Core\AccessDeniedException::class,'Stale concurrent password rotation is denied after administrator reset');
    $check(password_verify($resetPassword,$stored['password_hash'])&&(int)$stored['must_change_password']===1&&(int)$stored['session_version']===(int)$a['session_version']+1,'Administrator reset hash and generation cannot be overwritten by stale password');

    $model=(new ModelService())->registerModel(['model_code'=>$tag,'name'=>'Concurrency artifact model','framework'=>'JSON','ticket_id'=>$tid],$sid);$mid=(int)$model['id'];
    $artifactName='v6_test_'.bin2hex(random_bytes(16)).'.json';$artifactPath=dirname(__DIR__).'/storage/private/models/'.$artifactName;file_put_contents($artifactPath,'{"test_contract":true}');
    $vid=Database::getInstance()->insert('model_versions',['model_id'=>$mid,'version'=>'v6-test','artifact_path'=>$artifactName,'artifact_format'=>'json','file_size'=>filesize($artifactPath),'checksum_sha256'=>hash_file('sha256',$artifactPath),'status'=>'REGISTERED']);
    $pdo->beginTransaction();Database::queryOne('SELECT id FROM models WHERE id=:id FOR UPDATE',['id'=>$mid]);$worker=$start(['operation'=>'validation','id'=>$mid,'version'=>$vid,'student'=>$sid]);$waitLocked($worker);
    (new SocWorkspaceService())->updateModel($mid,['status'=>'ARCHIVED'],$admin);$pdo->commit();$result=$finish($worker);
    $check(!$result['success']&&$result['exception']===InvalidArgumentException::class,'Concurrent archive prevents validation request after lock wait');
    $check(Database::queryOne('SELECT status FROM models WHERE id=:id',['id'=>$mid])['status']==='ARCHIVED'&&(int)Database::queryOne('SELECT COUNT(*) AS n FROM validation_runs WHERE model_id=:id',['id'=>$mid])['n']===0,'Archived model remains archived with zero new validation reports');

    $pdo->beginTransaction();Database::queryOne('SELECT id FROM tickets WHERE id=:id FOR UPDATE',['id'=>$tid]);$worker=$start(['operation'=>'comment','id'=>$tid,'student'=>$sid]);$waitLocked($worker);
    $tickets->reassignTicket($tid,$other,$admin);$pdo->commit();$result=$finish($worker);
    $check(!$result['success']&&$result['exception']===App\Core\AccessDeniedException::class,'Comment denied when ticket is reassigned during lock wait');
    $check((int)Database::queryOne('SELECT COUNT(*) AS n FROM ticket_comments WHERE ticket_id=:id',['id'=>$tid])['n']===0,'Revoked comment creates no row');

    $uuid='JOB-V6-'.strtoupper(bin2hex(random_bytes(6)));$job=Database::getInstance()->insert('execution_jobs',['job_uuid'=>$uuid,'notebook_id'=>$notebook['id'],'student_id'=>$sid,'status'=>'QUEUED','code_to_execute'=>'# inert test history; execution unavailable']);
    $pdo->beginTransaction();Database::queryOne('SELECT id FROM execution_jobs WHERE id=:id FOR UPDATE',['id'=>$job]);$workers=[];for($i=0;$i<2;$i++)$workers[]=$start(['operation'=>'cancel','uuid'=>$uuid,'admin'=>$admin]);$waitLocked($workers[0]);$pdo->commit();
    foreach($workers as $worker)$check($finish($worker)['success'],'Simultaneous identical cancellation succeeds idempotently');
    $check(Database::queryOne('SELECT status FROM execution_jobs WHERE id=:id',['id'=>$job])['status']==='CANCELLED'&&(int)Database::queryOne("SELECT COUNT(*) AS n FROM audit_logs WHERE action='EXECUTION_JOB_CANCELLED' AND resource_id=:uuid",['uuid'=>$uuid])['n']===1,'Concurrent cancellation persists one actual audit and one cancelled state');
    echo "$passed backend concurrency checks passed on ".Env::get('DB_NAME')."; only uniquely tagged test work created, no existing records reset.\n";
}finally{if($pdo->inTransaction())$pdo->rollBack();}
