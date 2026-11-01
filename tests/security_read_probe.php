<?php
/** Restricted own-user read-admission probe. CLI + loopback APP_ENV=testing only. */
declare(strict_types=1);
if(PHP_SAPI!=='cli'){http_response_code(403);exit;}
require_once __DIR__.'/../app/bootstrap.php';
use App\Core\{Database,Env};
if(Env::get('APP_ENV')!=='testing'||!str_ends_with((string)Env::get('DB_NAME'),'_test')||!in_array(Env::get('DB_HOST'),['127.0.0.1','localhost','::1'],true))throw new RuntimeException('REFUSED: isolated loopback _test required.');
$mode=$argv[1]??'environment';
if($mode==='environment'){echo json_encode(['environment'=>Env::get('APP_ENV'),'database'=>Env::get('DB_NAME'),'host'=>Env::get('DB_HOST'),'base_url'=>Env::get('APP_URL')]);exit;}
$uid=filter_var($argv[2]??null,FILTER_VALIDATE_INT);
$user=Database::queryOne('SELECT id,identifier,role FROM users WHERE id=:id',['id'=>$uid]);
if(!$user||$user['role']!=='STUDENT'||!str_starts_with($user['identifier'],'V7-READ-'))throw new RuntimeException('Only an explicit V7-READ test student may be inspected or rate-primed.');
$key='expensive_read_user_'.$uid;$limit=(int)Env::get('API_EXPENSIVE_READ_LIMIT',60);
if($mode==='prime')Database::execute('INSERT INTO rate_limits(rate_key,hits,reset_at) VALUES(:key,:hits,:reset) ON DUPLICATE KEY UPDATE hits=:next_hits,reset_at=:next_reset',['key'=>$key,'hits'=>$limit-1,'reset'=>time()+60,'next_hits'=>$limit-1,'next_reset'=>time()+60]);
elseif($mode==='expire')Database::execute('UPDATE rate_limits SET reset_at=:reset WHERE rate_key=:key',['key'=>$key,'reset'=>time()-1]);
elseif($mode!=='state')throw new InvalidArgumentException('Unsupported test probe operation.');
$counts=[];foreach(['notebooks','models','processed_datasets','experiment_runs','submissions'] as $table)$counts[$table]=(int)Database::queryOne('SELECT COUNT(*) AS n FROM '.$table.' WHERE student_id=:id',['id'=>$uid])['n'];
$counts['notifications']=(int)Database::queryOne('SELECT COUNT(*) AS n FROM notifications WHERE user_id=:id',['id'=>$uid])['n'];
$counts['audit_logs']=(int)Database::queryOne('SELECT COUNT(*) AS n FROM audit_logs WHERE actor_id=:id',['id'=>$uid])['n'];
echo json_encode(['student_id'=>$uid,'bucket'=>Database::queryOne('SELECT hits,reset_at FROM rate_limits WHERE rate_key=:key',['key'=>$key]),'limit'=>$limit,'work_counts'=>$counts]);
