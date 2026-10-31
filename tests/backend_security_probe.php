<?php
declare(strict_types=1);
if(PHP_SAPI!=='cli'){http_response_code(403);exit;}
require_once __DIR__.'/../app/bootstrap.php';
use App\Core\{Database,Env};
if(Env::get('APP_ENV')!=='testing'||!str_ends_with((string)Env::get('DB_NAME'),'_test')||!in_array(Env::get('DB_HOST'),['127.0.0.1','localhost','::1'],true))throw new RuntimeException('REFUSED: isolated loopback _test required.');
$mode=$argv[1]??'environment';
if($mode==='environment'){echo json_encode(['environment'=>Env::get('APP_ENV'),'database'=>Env::get('DB_NAME'),'host'=>Env::get('DB_HOST'),'base_url'=>Env::get('APP_URL')]);exit;}
$uid=filter_var($argv[2]??null,FILTER_VALIDATE_INT);
$user=Database::queryOne("SELECT id,identifier,role FROM users WHERE id=:id",['id'=>$uid]);
if(!$user||$user['role']!=='STUDENT'||!str_starts_with($user['identifier'],'V6-HTTP-'))throw new RuntimeException('Only explicitly created V6 HTTP test student buckets may be changed.');
$kind=$argv[3]??'';$key=match($kind){'mutation'=>'api_mutation_user_'.$uid,'upload'=>'api_upload_user_'.$uid,default=>null};
if(in_array($mode,['prime','expire'],true)){
    if($key===null)throw new RuntimeException('Invalid bucket');
    $limit=max(1,(int)Env::get($kind==='mutation'?'API_MUTATION_LIMIT':'API_UPLOAD_LIMIT',$kind==='mutation'?120:20));
    if($mode==='prime')Database::execute('INSERT INTO rate_limits(rate_key,hits,reset_at) VALUES(:key,:hits,:reset) ON DUPLICATE KEY UPDATE hits=:next_hits,reset_at=:next_reset',['key'=>$key,'hits'=>$limit,'reset'=>time()+30,'next_hits'=>$limit,'next_reset'=>time()+30]);
    else Database::execute('UPDATE rate_limits SET reset_at=:reset WHERE rate_key=:key',['reset'=>time(),'key'=>$key]);
}
echo json_encode(['student'=>$user,'buckets'=>Database::query('SELECT rate_key,hits,reset_at FROM rate_limits WHERE rate_key IN (:mutation,:upload)',['mutation'=>'api_mutation_user_'.$uid,'upload'=>'api_upload_user_'.$uid]),'notebooks'=>(int)Database::queryOne('SELECT COUNT(*) AS n FROM notebooks WHERE student_id=:id',['id'=>$uid])['n'],'processed'=>(int)Database::queryOne('SELECT COUNT(*) AS n FROM processed_datasets WHERE student_id=:id',['id'=>$uid])['n']]);
