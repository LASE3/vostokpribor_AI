<?php
declare(strict_types=1);
if(PHP_SAPI!=='cli'){http_response_code(403);exit;}
require_once __DIR__.'/../app/bootstrap.php';
use App\Core\Database;
use App\Core\Env;
if(Env::get('APP_ENV')!=='testing'||!str_ends_with((string)Env::get('DB_NAME'),'_test')||!in_array(Env::get('DB_HOST'),['127.0.0.1','localhost','::1'],true)){fwrite(STDERR,"REFUSED: dedicated local _test database required.\n");exit(1);}
try {
    $mode=$argv[1]??'';
    $id=filter_var($argv[2]??'',FILTER_VALIDATE_INT);
    if(!$id||$id<1)throw new InvalidArgumentException('Exact security-test student ID required.');
    $student=Database::queryOne("SELECT id,identifier,last_login_at,session_version FROM users WHERE id=:id AND role='STUDENT' AND identifier LIKE 'CORESEC-%'",['id'=>$id]);
    if(!$student)throw new RuntimeException('Refused: target is not this test suite security student.');
    if($mode==='state'){
        $lastDenied=Database::queryOne("SELECT resource_id,metadata_json FROM audit_logs WHERE actor_id=:id AND action='ACCESS_DENIED' AND resource_type='route' ORDER BY id DESC LIMIT 1",['id'=>$id]);
        if($lastDenied)$lastDenied['metadata']=json_decode($lastDenied['metadata_json']??'{}',true);
        echo json_encode(['database'=>Env::get('DB_NAME'),'student'=>$student,'last_denied'=>$lastDenied,'login_audits'=>(int)Database::queryOne("SELECT COUNT(*) AS c FROM audit_logs WHERE actor_id=:id AND action='LOGIN_SUCCESS'",['id'=>$id])['c'],'logout_audits'=>(int)Database::queryOne("SELECT COUNT(*) AS c FROM audit_logs WHERE actor_id=:id AND action='LOGOUT'",['id'=>$id])['c']],JSON_THROW_ON_ERROR);
        exit;
    }
    $action=$argv[3]??'';
    if(!in_array($action,['LOGIN_SUCCESS','LOGOUT'],true))throw new InvalidArgumentException('Only exact login/logout audit action allowed.');
    $name='coresec_audit_'.$id.'_'.($action==='LOGIN_SUCCESS'?'login':'logout');
    if($mode==='trigger-off'){
        Database::execute('DROP TRIGGER IF EXISTS '.$name);
        echo json_encode(['removed'=>$name,'database'=>Env::get('DB_NAME')]);exit;
    }
    if($mode!=='trigger-on')throw new InvalidArgumentException('Unsupported security test action.');
    // Identifier is generated from validated integers and an allowlisted action only.
    // This exact resource/actor filter cannot affect any other account or audit action.
    Database::execute("CREATE TRIGGER ".$name." BEFORE INSERT ON audit_logs FOR EACH ROW BEGIN IF NEW.actor_id=".$id." AND NEW.resource_id='".$id."' AND NEW.action='".$action."' THEN SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT='Expected resource-scoped core-security audit failure'; END IF; END");
    echo json_encode(['installed'=>$name,'actor_id'=>$id,'resource_id'=>(string)$id,'action'=>$action,'database'=>Env::get('DB_NAME')]);
}catch(Throwable $e){fwrite(STDERR,$e->getMessage()."\n");exit(1);}
