<?php
/** Encrypted operator backup. Pass secrets in stdin JSON, never arguments. */
declare(strict_types=1);
if(PHP_SAPI!=='cli'){http_response_code(403);exit;}
require __DIR__.'/../app/bootstrap.php';require __DIR__.'/lib/recovery.php';
use App\Core\{Database,Env};
try {
    $options=getopt('',['output:']);$input=json_decode(stream_get_contents(STDIN),true,16,JSON_THROW_ON_ERROR);
    $configuration=[];$keys=['APP_ENV','APP_URL','APP_DEBUG','DB_HOST','DB_PORT','DB_NAME','DB_USER','DB_PASS','DB_CHARSET','SESSION_COOKIE_NAME','SESSION_SECURE','SESSION_LIFETIME','MAX_UPLOAD_SIZE_MB','API_MUTATION_LIMIT','API_UPLOAD_LIMIT','API_EXPENSIVE_READ_LIMIT','API_RATE_WINDOW_SECONDS'];
    foreach(file(dirname(__DIR__).'/.env',FILE_IGNORE_NEW_LINES)?:[] as $line)if(preg_match('/^([A-Z][A-Z0-9_]*)=/',$line,$match))$keys[]=$match[1];
    foreach(array_unique($keys) as $key)$configuration[$key]=Env::get($key);
    $configuration['DB_PORT']??='3306';$configuration['DB_PASS']??='';
    $proof=recoveryBackup(Database::getConnection(),dirname(__DIR__),(string)($options['output']??''),(string)($input['backup_password']??''),$configuration);
    echo json_encode($proof,JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_THROW_ON_ERROR).PHP_EOL;
}catch(Throwable $error){fwrite(STDERR,'Recovery backup refused/failed ['.get_class($error).']. No credential or SQL details printed; original records/files preserved.'.PHP_EOL);exit(1);}
