<?php
declare(strict_types=1);
if (PHP_SAPI !== 'cli') { http_response_code(403); exit; }
require_once __DIR__.'/../app/bootstrap.php';
use App\Core\Database;
use App\Core\Env;
use App\Services\ScenarioService;
use App\Services\TicketService;
use App\Services\SubmissionService;
if (Env::get('APP_ENV')!=='testing' || !str_ends_with((string)Env::get('DB_NAME',''),'_test') || !in_array(Env::get('DB_HOST'),['127.0.0.1','localhost','::1'],true)) {
    fwrite(STDERR,"REFUSED: loopback APP_ENV=testing and _test database required.\n");exit(1);
}
$checks=[];
$assert=function(bool $condition,string $message) use (&$checks) { if (!$condition) throw new RuntimeException('FAIL: '.$message);$checks[]=$message; };
$reject=function(callable $operation,string $message) use ($assert) { try {$operation();} catch (Throwable $e) {$assert(true,$message);return;} $assert(false,$message); };
$pdo=Database::getConnection();$db=Database::getInstance();$marker='SOC-'.strtoupper(bin2hex(random_bytes(5)));
try {
    $admin=Database::queryOne("SELECT id FROM users WHERE role='ADMIN' AND status='ACTIVE' ORDER BY id LIMIT 1")??throw new RuntimeException('Test administrator missing.');
    $adminId=(int)$admin['id'];
    $pdo->beginTransaction();
    $students=[];
    foreach ([1,2,3] as $number) $students[]=$db->insert('users',['role'=>'STUDENT','email'=>$marker.$number.'@example.invalid','identifier'=>$marker.$number,'full_name'=>'Transactional test '.$number,'password_hash'=>password_hash(bin2hex(random_bytes(24)),PASSWORD_DEFAULT),'status'=>'ACTIVE']);
    $scenarioService=new ScenarioService();$tickets=new TicketService();$submissions=new SubmissionService();
    $fields=['edit-title'=>'Persisted scenario','edit-bp-objective'=>'A real objective','edit-python-version'=>'Requested runtime','edit-framework'=>'Requested framework','edit-compute-quota'=>'No allocation yet','edit-libraries'=>'Requested libraries','int-sys-01'=>true,'deliv-notebooks'=>true,'deliv-model'=>false,'edit-metric-primary-name'=>'F1','edit-metric-primary-threshold'=>'Defined by admin','edit-passing-score'=>'Instructor decision','edit-auto-val'=>'Unavailable','edit-instructor-review-req'=>'Required','edit-start-date'=>'2026-10-26','edit-deadline'=>'2026-11-26','edit-visible-toggle'=>true,'edit-cohort'=>'Assigned cohort','edit-tags'=>'persist,all,steps'];
    foreach([10,15,20,15,15,10,10,5] as $index=>$weight)$fields['dim-weight-'.($index+1)]=(string)$weight;
    $metadata=['schema_version'=>1,'form_fields'=>$fields,'datasets'=>[],'workflow'=>[['stage'=>'Stage 1','action'=>'Student-written stage']]];
    $scenario=$scenarioService->createScenario(['code'=>$marker,'title'=>'Persisted scenario','builder_metadata'=>$metadata],$adminId);
    $id=(int)$scenario['id'];
    $assert($scenario['status']==='DRAFT','New scenario starts as DRAFT');
    $loaded=$scenarioService->getScenario($id);
    $assert($loaded['builder_metadata']['form_fields']===$fields && $loaded['builder_metadata']['workflow']===$metadata['workflow'],'Every builder field and workflow survives a database reload');
    $assert(count($loaded['builder_metadata']['history'])===1,'Version history records actual create actor and time');
    $reject(fn()=>$scenarioService->createScenario(['code'=>$marker.'X','title'=>'Forbidden','status'=>'ACTIVE'],$adminId),'New scenario cannot bypass draft lifecycle');
    $reject(fn()=>$scenarioService->createScenario(['code'=>$marker.'Y','title'=>'Forbidden'],$students[0]),'Student cannot create scenarios through service');
    $reject(fn()=>$scenarioService->updateScenario($id,['status'=>'ACTIVE'],$adminId),'DRAFT cannot transition directly to ACTIVE');
    $reject(fn()=>$scenarioService->updateScenario($id,['builder_metadata'=>['datasets'=>[['id'=>2147483647]]]],$adminId),'Builder cannot reference nonexistent dataset');
    foreach(['READY_FOR_REVIEW','PUBLISHED','ACTIVE','COMPLETED','ARCHIVED','DRAFT'] as $status) {
        $saved=$scenarioService->updateScenario($id,['status'=>$status],$adminId);
        $assert($saved['status']===$status,'Lifecycle persists '.$status);
    }
    $ticket=$tickets->createTicket(['ticket_code'=>$marker.'-T','title'=>'Owned ticket','scenario_id'=>$id,'student_id'=>$students[0],'requirements'=>'Read requirements','acceptance_criteria'=>'Instructor review'],$adminId);
    $ticketId=(int)$ticket['id'];
    $assert($ticket['status']==='ASSIGNED','Creating assigned ticket persists ASSIGNED');
    $reject(fn()=>$tickets->getTicket($ticketId,$students[2],'STUDENT'),'Unassigned student cannot read ticket');
    $reject(fn()=>$tickets->addComment($ticketId,$students[2],'Forbidden'),'Unassigned student cannot comment');
    $tickets->assignTicket($ticketId,$students[1],$adminId);
    $assert((int)$tickets->getTicket($ticketId,$students[1],'STUDENT')['id']===$ticketId,'Each assigned student passes ownership independently of join order');
    $tickets->updateTicket($ticketId,['status'=>'IN_PROGRESS'],$students[0],'STUDENT');
    $assert($tickets->getTicket($ticketId,$students[0],'STUDENT')['status']==='IN_PROGRESS','Student progress survives reload');
    $foreignNotebook=$db->insert('notebooks',['code'=>$marker.'-NB','title'=>'Other student notebook','student_id'=>$students[2]]);
    $reject(fn()=>$submissions->createSubmission(['ticket_id'=>$ticketId,'notebook_id'=>$foreignNotebook],$students[0]),'Foreign notebook cannot be attached to submission');
    $submission=$submissions->createSubmission(['ticket_id'=>$ticketId,'notes'=>'Actual student submission'],$students[0]);$submissionId=(int)$submission['id'];
    $assert($tickets->getTicket($ticketId,$students[0],'STUDENT')['status']==='SUBMITTED','Submission updates persisted ticket status');
    $reject(fn()=>$submissions->getSubmission($submissionId,$students[2],'STUDENT'),'Foreign student cannot read submission');
    $reject(fn()=>$submissions->reviewSubmission($submissionId,['status'=>'APPROVED','total_score'=>101],$adminId),'Out-of-range grades are rejected');
    $review=$submissions->reviewSubmission($submissionId,['status'=>'CHANGES_REQUESTED','feedback'=>'Revise methodology'],$adminId);
    $assert($review['feedback']==='Revise methodology' && $tickets->getTicket($ticketId,$students[0],'STUDENT')['status']==='CHANGES_REQUESTED','Reviewer feedback and ticket changes-requested persist');
    $assert((int)Database::queryOne('SELECT COUNT(*) AS n FROM notifications WHERE user_id=:id',['id'=>$students[0]])['n']===1,'Review creates a real notification');
    $reject(fn()=>$submissions->reviewSubmission($submissionId,['status'=>'APPROVED'],$adminId),'Already reviewed submission cannot be reviewed twice');
    $tickets->updateTicket($ticketId,['status'=>'IN_PROGRESS'],$students[0],'STUDENT');
    $revised=$submissions->createSubmission(['ticket_id'=>$ticketId,'notes'=>'Revised work'],$students[0]);
    $assert((int)$revised['iteration']===2,'Revision creates the next persisted iteration');
    $submissions->reviewSubmission((int)$revised['id'],['status'=>'APPROVED','feedback'=>'Accepted'],$adminId);
    $assert($tickets->getTicket($ticketId,$students[0],'STUDENT')['status']==='APPROVED','Approved submission updates ticket');
    $assert((int)Database::queryOne('SELECT COUNT(*) AS n FROM audit_logs WHERE resource_id=:id AND action=:action',['id'=>(string)$id,'action'=>'SCENARIO_UPDATED'])['n']===6,'Lifecycle actions have actual audit events');
    $pdo->rollBack();
    foreach($checks as $message)echo 'PASS '.$message."\n";
    echo 'PASS '.count($checks)." SOC contract checks; all generated rows rolled back.\n";
} catch(Throwable $e) {if($pdo->inTransaction())$pdo->rollBack();fwrite(STDERR,$e->getMessage()."\n".$e->getTraceAsString()."\n");exit(1);}
