<?php
declare(strict_types=1);
if(PHP_SAPI!=='cli'){http_response_code(403);exit;}
require_once __DIR__.'/../app/bootstrap.php';
use App\Core\{Database,Env};
if(Env::get('APP_ENV')!=='testing'||!str_ends_with((string)Env::get('DB_NAME'),'_test')||!in_array(Env::get('DB_HOST'),['localhost','127.0.0.1','::1'],true))throw new RuntimeException('Dedicated local testing database required.');
$mode=$argv[1]??'state';$id=(int)($argv[2]??0);
if($mode==='queue'){
 $nb=Database::queryOne("SELECT n.* FROM notebooks n JOIN users u ON u.id=n.student_id WHERE n.id=:id AND u.identifier LIKE 'IT-%'",['id'=>$id]);if(!$nb)throw new RuntimeException('Owned integration notebook required.');
 $uuid=(new \App\Repositories\ExecutionRepository())->createJob(['notebook_id'=>$id,'student_id'=>(int)$nb['student_id'],'code_to_execute'=>'# test-only queued state; never executed']);echo json_encode(['uuid'=>$uuid]);exit;
}
if($mode==='audit-fail-on'||$mode==='audit-fail-off'){
 // Only this CLI helper can install the temporary, resource-scoped failure trigger.
 if($mode==='audit-fail-off'){Database::execute('DROP TRIGGER IF EXISTS integration_scoped_audit_failure');echo '{}';exit;}
 if($id<1||!Database::queryOne("SELECT id FROM datasets WHERE id=:id AND code LIKE 'IT-%'",['id'=>$id]))throw new RuntimeException('Integration dataset required.');
 Database::execute("CREATE TRIGGER integration_scoped_audit_failure BEFORE INSERT ON audit_logs FOR EACH ROW BEGIN IF NEW.action='DATASET_ASSIGNED' AND NEW.resource_id='".$id."' THEN SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT='Expected integration audit failure'; END IF; END");echo '{}';exit;
}
if($mode==='expire'){
 $sid=$argv[2]??'';if(!preg_match('/^[A-Za-z0-9,-]{16,128}$/D',$sid))throw new RuntimeException('Invalid test session.');session_write_close();session_id($sid);session_start();
 $user=Database::queryOne("SELECT id FROM users WHERE id=:id AND identifier LIKE 'IT-%'",['id'=>$_SESSION['user_id']??0]);if(!$user)throw new RuntimeException('Integration student session required.');$_SESSION['last_activity']=time()-100000;session_write_close();echo '{}';exit;
}
$counts=[];foreach(Database::query('SHOW TABLES') as $r){$t=reset($r);if(!preg_match('/^[a-z_]+$/D',$t))throw new RuntimeException('Invalid table.');$counts[$t]=(int)Database::queryOne('SELECT COUNT(*) AS c FROM '.$t)['c'];}
echo json_encode(['database'=>Env::get('DB_NAME'),'environment'=>Env::get('APP_ENV'),'app_url'=>Env::get('APP_URL'),'cookie'=>Env::get('SESSION_COOKIE_NAME'),'counts'=>$counts,
 'assignments'=>Database::query('SELECT ticket_id,student_id,revoked_at FROM ticket_assignments'),
 'dataset_assignments'=>Database::query('SELECT dataset_id,student_id,ticket_id,dataset_version_id,revoked_at FROM dataset_assignments'),
 'notebooks'=>Database::query('SELECT id,student_id,ticket_id,status FROM notebooks'),
 'submissions'=>Database::query('SELECT id,ticket_id,student_id,status,total_score,feedback FROM submissions'),
 'audit_actions'=>Database::query('SELECT action,actor_id,resource_type,resource_id FROM audit_logs ORDER BY id')],JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
