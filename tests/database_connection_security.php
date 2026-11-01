<?php
/** Real failed loopback PDO handshake verifies credentials/DSNs never enter application diagnostics. */
declare(strict_types=1);
if(PHP_SAPI!=='cli'){http_response_code(403);exit;}
$checks=0;$check=function(bool $ok,string $label)use(&$checks){if(!$ok)throw new RuntimeException('FAIL '.$label);echo 'PASS '.$label.PHP_EOL;$checks++;};
$sentinel='TEST_ONLY_DB_SECRET_'.bin2hex(random_bytes(12));$username='v7_absent_'.bin2hex(random_bytes(6));
$file=tempnam(sys_get_temp_dir(),'v7-db-log-');
if($file===false)throw new RuntimeException('Cannot create own child script.');
file_put_contents($file,'<?php require $argv[1]."/app/Core/Env.php"; require $argv[1]."/app/Core/Database.php"; try { App\\Core\\Database::getConnection(); exit(99); } catch (RuntimeException $error) { echo $error->getMessage(); exit(17); }');
$environment=getenv();foreach(['APP_ENV'=>'testing','DB_NAME'=>'vostok_v7_nonexistent_test','DB_HOST'=>'127.0.0.1','DB_PORT'=>'3306','DB_USER'=>$username,'DB_PASS'=>$sentinel,'DB_CHARSET'=>'utf8mb4'] as $k=>$v)$environment[$k]=$v;
try{
 $process=proc_open([PHP_BINARY,'-d','error_log=php://stderr',$file,dirname(__DIR__)],[0=>['pipe','r'],1=>['pipe','w'],2=>['pipe','w']],$pipes,null,$environment);
 if(!is_resource($process))throw new RuntimeException('Cannot launch own child process.');
 fclose($pipes[0]);$out=stream_get_contents($pipes[1]);fclose($pipes[1]);$err=stream_get_contents($pipes[2]);fclose($pipes[2]);$exit=proc_close($process);
 $check($exit===17,'Real rejected loopback authentication is wrapped in a generic runtime exception');
 $check($out==='Database unavailable. Check the server configuration.','Caller receives generic failure without PDO server details');
 $check(!str_contains($out.$err,$sentinel)&&!str_contains($out.$err,$username),'Rejected database username and password sentinels are absent from output and logs');
 $check((bool)preg_match('/Database connection failure \[PDOException\] SQLSTATE=[A-Z0-9]{5}/',$err),'Protected diagnostics retain bounded SQLSTATE and exception type');
 $check(!str_contains($err,'mysql:')&&!str_contains($err,'Access denied')&&!str_contains($err,'Stack trace'),'Logs omit DSN, raw server message and stack trace');
 echo 'PASS ALL '.$checks.' real failed-connection security checks; no schema or data changes.'.PHP_EOL;
}finally{if(is_file($file))unlink($file);unset($environment['DB_PASS']);}
