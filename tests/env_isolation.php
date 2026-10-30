<?php
declare(strict_types=1);
/** Pure Env regression: no application bootstrap, sessions, database or real .env. */
if(PHP_SAPI!=='cli'){http_response_code(403);exit;}
require_once __DIR__.'/../app/Core/Env.php';
use App\Core\Env;
$checks=[];$check=function(bool $value,string $label)use(&$checks):void{if(!$value)throw new RuntimeException('FAIL '.$label);$checks[]=$label;};
$suffix=strtoupper(bin2hex(random_bytes(8)));
$fileKey='VOSTOK_REGRESSION_FILE_'.$suffix;
$overrideKey='VOSTOK_REGRESSION_OVERRIDE_'.$suffix;
$booleanKey='VOSTOK_REGRESSION_BOOLEAN_'.$suffix;
$absentKey='VOSTOK_REGRESSION_ABSENT_'.$suffix;
$target=tempnam(sys_get_temp_dir(),'vostok_env_regression_');
if($target===false)throw new RuntimeException('Could not create own temporary Env test file.');
$resolvedTemp=realpath(sys_get_temp_dir());$resolvedTarget=realpath($target);
if(!$resolvedTemp||!$resolvedTarget||!str_starts_with(strtolower(str_replace('\\','/',$resolvedTarget)),rtrim(strtolower(str_replace('\\','/',$resolvedTemp)),'/').'/'))throw new RuntimeException('Unexpected temporary file location.');
try{
 $check(getenv($fileKey)===false&&getenv($overrideKey)===false&&getenv($booleanKey)===false,'unique regression keys begin absent from process environment');
 putenv($overrideKey.'=explicit-process-value');
 file_put_contents($target,$fileKey."=request-local-file-value\n".$overrideKey."=file-value-must-not-replace-process\n".$booleanKey."=true\n");
 Env::load($target);
 $check(Env::get($fileKey)==='request-local-file-value','Env::get reads request-local file key');
 $check(getenv($fileKey)===false,'Env::load does not publish file key through getenv/process state');
 $check(Env::get($overrideKey)==='explicit-process-value','explicit process override remains authoritative over file');
 $check(getenv($overrideKey)==='explicit-process-value','file loading does not alter existing process override');
 $check(Env::get($booleanKey)===true,'request-local boolean normalization still works');
 $check(getenv($booleanKey)===false,'normalized file-only boolean is not process-published');
 $check(Env::get($absentKey,'fallback-value')==='fallback-value','missing request-local/process key preserves default');
 foreach($checks as $label)echo 'PASS '.$label.PHP_EOL;
 echo count($checks).' Env isolation checks passed; no real environment file, session or database accessed.'.PHP_EOL;
}catch(Throwable $e){fwrite(STDERR,$e->getMessage().PHP_EOL);exit(1);}
finally{
 putenv($overrideKey);
 // Remove only the exact own file returned by tempnam and verified inside OS temp.
 if(is_file($target))unlink($target);
}
