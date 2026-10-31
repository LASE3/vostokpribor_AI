<?php
declare(strict_types=1);
if(PHP_SAPI!=='cli'){http_response_code(403);exit;}
require_once __DIR__.'/../app/bootstrap.php';
use App\Core\{Database,Env,AccessDeniedException};
use App\Services\{SocSystemService,DeploymentService};
if(Env::get('APP_ENV')!=='testing'||!str_ends_with((string)Env::get('DB_NAME'),'_metrics_test')||!in_array(Env::get('DB_HOST'),['localhost','127.0.0.1','::1'],true))throw new RuntimeException('Use a NEW empty loopback APP_ENV=testing *_metrics_test database. No reset is performed.');
$pdo=Database::getConnection();$db=Database::getInstance();$svc=new SocSystemService();$passed=0;
$check=function(bool $ok,string $label)use(&$passed):void{if(!$ok)throw new RuntimeException('FAIL '.$label);$passed++;echo 'PASS '.$label.PHP_EOL;};
$admin=(int)Database::queryOne("SELECT id FROM users WHERE role='ADMIN' AND status='ACTIVE' ORDER BY id LIMIT 1")['id'];
$before=Database::query('SHOW TABLES');$initial=[];foreach($before as $row){$t=reset($row);if(!preg_match('/^[a-z_]+$/D',$t))throw new RuntimeException('Invalid table');$initial[$t]=(int)Database::queryOne('SELECT COUNT(*) n FROM `'.$t.'`')['n'];}
foreach(['scenarios','tickets','users','models','notebooks','submissions','deployment_requests','execution_jobs'] as $t)if($initial[$t]!==($t==='users'?1:0))throw new RuntimeException('REFUSED: metric cases require a newly initialized empty testing schema.');
$render=function(array $d):string{
 $overview=$d['overview'];$students=$d['students'];$scenarios=$d['scenarios'];$auditLogs=$overview['recent_audit_actions'];$health=$d['health'];$databaseHealth=$health['database']['status'].' ms';$pageType='dashboard';
 $counts=['students'=>$overview['students']['total'],'scenarios'=>$overview['scenarios']['total'],'tickets'=>$overview['tickets']['total'],'reviews'=>$overview['submissions']['pending'],'models'=>$overview['models']['registered'],'datasets'=>$overview['datasets']['master'],'notebooks'=>$overview['ml_workbench']['notebooks'],'submissions'=>$overview['submissions']['total'],'failed'=>$overview['execution_cluster']['failed']];
 ob_start();require __DIR__.'/../AI Operations Center (AI SOC)/_dashboard_panels.php';return ob_get_clean();
};
try{
 $pdo->beginTransaction();$tag='V6MET-'.strtoupper(bin2hex(random_bytes(4)));
 $zero=$svc->dashboard($admin);$o=$zero['overview'];
 $check($o['students']===['total'=>0,'active'=>0]&&$o['tickets']['total']===0&&$o['assignments']['active']===0,'Empty database aggregates are zero');
 $check($o['submissions']['pending']===0&&$o['submissions']['approved']===0&&$o['models']['deployed']===0,'Empty reviews and verified deployment count are zero');
 $html=$render($zero);$check(str_contains($html,'No students')&&str_contains($html,'No scenarios created')&&str_contains($html,'NOT_CONFIGURED'),'Empty canonical dashboard renders useful truthful states');
 $ids=[];for($i=0;$i<13;$i++){
  $ids[]=$db->insert('users',['role'=>'STUDENT','identifier'=>$tag.'-'.$i,'email'=>strtolower($tag).$i.'@example.invalid','full_name'=>'Metric test <img src=x onerror=bad()> '.$i,'password_hash'=>password_hash(bin2hex(random_bytes(12)),PASSWORD_DEFAULT),'status'=>$i===1?'INACTIVE':'ACTIVE']);
  if($i===0)$check($svc->overview($admin)['students']===['total'=>1,'active'=>1],'One active student count');
  if($i===1)$check($svc->overview($admin)['students']===['total'=>2,'active'=>1],'Inactive account counted only in total');
 }
 $scenario=$db->insert('scenarios',['code'=>$tag,'title'=>'Metric scenario','author_id'=>$admin,'status'=>'DRAFT']);
 $tickets=[];foreach(['ASSIGNED','IN_PROGRESS','CANCELLED'] as $i=>$status){$tickets[]=$db->insert('tickets',['ticket_code'=>$tag.'-'.$i,'title'=>'Metric ticket','created_by'=>$admin,'scenario_id'=>$scenario,'status'=>$status]);}
 $db->insert('ticket_assignments',['ticket_id'=>$tickets[0],'student_id'=>$ids[0],'assigned_by'=>$admin]);
 $db->insert('ticket_assignments',['ticket_id'=>$tickets[0],'student_id'=>$ids[1],'assigned_by'=>$admin]);
 $db->insert('ticket_assignments',['ticket_id'=>$tickets[1],'student_id'=>$ids[0],'assigned_by'=>$admin]);
 $db->insert('ticket_assignments',['ticket_id'=>$tickets[1],'student_id'=>$ids[2],'assigned_by'=>$admin,'revoked_at'=>date('Y-m-d H:i:s'),'revoked_by'=>$admin]);
 $db->insert('ticket_assignments',['ticket_id'=>$tickets[2],'student_id'=>$ids[0],'assigned_by'=>$admin]);
 foreach(['APPROVED','SUBMITTED'] as $status)$db->insert('submissions',['submission_code'=>$tag.'-'.$status,'ticket_id'=>$tickets[0],'student_id'=>$ids[0],'status'=>$status]);
 $nb=$db->insert('notebooks',['code'=>$tag,'title'=>'Metric notebook','student_id'=>$ids[0],'ticket_id'=>$tickets[0]]);
 $db->insert('experiments',['code'=>$tag,'name'=>'Metric experiment','student_id'=>$ids[0],'ticket_id'=>$tickets[0]]);
 $db->insert('execution_jobs',['job_uuid'=>$tag,'notebook_id'=>$nb,'student_id'=>$ids[0],'code_to_execute'=>'# never executed','status'=>'FAILED']);
 $m=$db->insert('models',['model_code'=>$tag,'name'=>'Metric model','framework'=>'JSON','student_id'=>$ids[0],'ticket_id'=>$tickets[0]]);
 // Deliberately untrusted old request labels are test metadata only; no fake file is written.
 $mv=$db->insert('model_versions',['model_id'=>$m,'version'=>'test-only','artifact_path'=>'nonexistent-test-metadata.json','artifact_format'=>'json','checksum_sha256'=>str_repeat('0',64),'file_size'=>0]);
 foreach(['PENDING','APPROVED','DEPLOYED'] as $status)$db->insert('deployment_requests',['model_id'=>$m,'model_version_id'=>$mv,'requested_by'=>$ids[0],'status'=>$status]);
 $d=$svc->dashboard($admin);$o=$d['overview'];
 $check($o['students']===['total'=>13,'active'=>12]&&count($d['students'])===10,'Total and active aggregates do not use limited recent list');
 $check($o['tickets']['total']===3&&$o['tickets']['assigned']===1&&$o['tickets']['in_progress']===1&&$o['tickets']['cancelled']===1,'Ticket status aggregates match exact rows');
 $check($o['assignments']===['total'=>5,'active'=>2],'Active assignments exclude revoked, cancelled and inactive-account grants');
 $check($o['submissions']['total']===2&&$o['submissions']['pending']===1&&$o['submissions']['approved']===1,'Approved submission and pending review are distinct');
 $check($o['execution_cluster']['failed']===1&&$o['execution_cluster']['status']==='NOT_CONFIGURED','Failed job counts do not certify worker availability');
 $check($o['ml_workbench']['notebooks']===1&&$o['ml_workbench']['experiments']===1,'Notebook and experiment aggregates included');
 $check($o['deployment_requests']===['total'=>3,'pending'=>1,'approved'=>1]&&$o['models']['deployed']===0,'Pending, approved and old DEPLOYED request labels never count as verified deployments');
 $dep=new DeploymentService();$check($dep->verifiedDeployments(['id'=>$admin,'role'=>'ADMIN'])===[]&&$dep->verifiedDeployments(['id'=>$ids[0],'role'=>'STUDENT'])===[],'Runtime deployment list is empty with no provider while request history remains');
 $check(count($dep->listDeployments(['id'=>$admin,'role'=>'ADMIN']))===3,'Explicit deployment request history preserved');
 $check($svc->summary($admin,'tickets')==$o['tickets']&&$svc->summary($admin,'datasets')==$o['datasets']&&$svc->summary($admin,'models')==$o['models'],'Scoped summaries agree with canonical overview');
 $html=$render($d);$check(str_contains($html,'10 recent / 13 total')&&str_contains($html,'12 active')&&!str_contains($html,'10 active cadets'),'Recent student list is labelled accurately');
 $check(!str_contains($html,'<img src=x')&&str_contains($html,'&lt;img src=x'),'User-looking HTML is escaped without corrupting stored data');
 $check(str_contains($html,'Validation provider NOT_CONFIGURED')&&str_contains($html,'Inference provider NOT_CONFIGURED')&&str_contains($html,'1 experiments'),'All monitoring providers and experiment statistics remain on canonical dashboard');
 try{$svc->overview($ids[0]);throw new RuntimeException('Accepted student overview');}catch(AccessDeniedException){$check(true,'SOC aggregates deny student actor');}
 $_SERVER['SCRIPT_FILENAME']=dirname(__DIR__).'/AI Operations Center (AI SOC)/Dashboard.php';
 ob_start();\App\Views\Layout\AppLayout::start(['systemKey'=>'soc','activePage'=>'Dashboard.php','currentUser'=>['id'=>$admin,'role'=>'ADMIN','full_name'=>'Metric test']]);\App\Views\Layout\AppLayout::end(['extraScriptsHtml'=>'<script src="../assets/js/range-client.js?existing=kept"></script>']);$shell=ob_get_clean();
 $check(substr_count($shell,'?v=')>=7&&str_contains($shell,'existing=kept&amp;v='),'Shared CSS/core/extra JS receive cache revision URLs without discarding query fields');
 $check(str_contains($shell,'https://cdn.tailwindcss.com')&&str_contains($shell,'assets/branding/logo.svg"'),'External dependency and official logo URL remain unchanged');
 $pdo->rollBack();
 foreach($initial as $table=>$n)$check((int)Database::queryOne('SELECT COUNT(*) n FROM `'.$table.'`')['n']===$n,'Rollback preserves initial '.$table.' rows');
 echo 'PASS ALL '.$passed.' dashboard metrics/semantics/render checks; no original rows/files altered.'.PHP_EOL;
}catch(Throwable $e){if($pdo->inTransaction())$pdo->rollBack();throw $e;}
