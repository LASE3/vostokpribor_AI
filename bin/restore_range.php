<?php
/** Safe staging restore only: new _test DB, code-only target, separate runtime identity. */
declare(strict_types=1);
if(PHP_SAPI!=='cli'){http_response_code(403);exit;}
require __DIR__.'/../app/bootstrap.php';require __DIR__.'/lib/recovery.php';
use App\Core\{Database,Env};
try {
    $options=getopt('',['archive:','target-root:','database:']);$input=json_decode(stream_get_contents(STDIN),true,16,JSON_THROW_ON_ERROR);
    $host=(string)Env::get('DB_HOST');if(!in_array($host,['localhost','127.0.0.1','::1'],true))throw new RuntimeException('Automatic staging restore requires loopback database host.');
    $configuration=['DB_HOST'=>$host,'DB_PORT'=>(string)Env::get('DB_PORT','3306'),'DB_USER'=>(string)Env::get('DB_USER'),'DB_PASS'=>(string)Env::get('DB_PASS','')];
    $proof=recoveryRestore(Database::getConnection(),(string)($options['archive']??''),(string)($options['target-root']??''),(string)($options['database']??''),(string)($input['backup_password']??''),$input,$configuration);
    echo json_encode($proof,JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_THROW_ON_ERROR).PHP_EOL;
}catch(Throwable $error){fwrite(STDERR,'Recovery restore refused/failed ['.get_class($error).']. No credentials or SQL details printed. Original data was not reset; any newly created target is retained for investigation.'.PHP_EOL);exit(1);}
