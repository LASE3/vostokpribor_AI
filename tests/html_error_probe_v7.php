<?php
declare(strict_types=1);
if(PHP_SAPI!=='cli'){http_response_code(403);exit;}
require __DIR__.'/../app/bootstrap.php';
use App\Core\{Database,Env};
if(Env::get('APP_ENV')!=='testing'||!str_ends_with((string)Env::get('DB_NAME'),'_test')||!in_array(Env::get('DB_HOST'),['127.0.0.1','localhost','::1'],true))throw new RuntimeException('Isolated loopback testing schema required.');
$mode=$argv[1]??'environment';
if($mode==='environment'){echo json_encode(['database'=>Env::get('DB_NAME'),'base_url'=>Env::get('APP_URL')]);exit;}
$tag=$argv[2]??'';if(!preg_match('/^[a-f0-9]{16}$/D',$tag))throw new InvalidArgumentException('Random test tag required.');
$trigger='v7_html_failure_'.$tag;$title='IT-V7-ERROR-'.$tag;
if($mode==='on')Database::execute("CREATE TRIGGER `$trigger` BEFORE INSERT ON notebooks FOR EACH ROW BEGIN IF NEW.title='$title' THEN SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT='TEST_ONLY_SQL_PASSWORD_SENTINEL'; END IF; END");
elseif($mode==='off')Database::execute("DROP TRIGGER IF EXISTS `$trigger`");
elseif($mode==='state'){echo json_encode(['matching_notebooks'=>(int)Database::queryOne('SELECT COUNT(*) AS n FROM notebooks WHERE title=:title',['title'=>$title])['n']]);exit;}
else throw new InvalidArgumentException('Known test mode required.');
echo '{}';
