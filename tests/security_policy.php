<?php
/** Pure security/configuration regression: no .env, sessions or database. */
declare(strict_types=1);
if (PHP_SAPI !== 'cli') { http_response_code(403); exit; }
require_once __DIR__.'/../app/Core/Env.php';
require_once __DIR__.'/../app/Core/SecurityPolicy.php';
require_once __DIR__.'/../app/Core/AppUrl.php';
require_once __DIR__.'/../app/Core/RateLimiter.php';
use App\Core\{Env,SecurityPolicy,RateLimiter};
$count=0;
function check(bool $ok,string $label):void { global $count;if(!$ok)throw new RuntimeException('FAIL '.$label);$count++;echo 'PASS '.$label.PHP_EOL; }
$values=['APP_ENV'=>'testing','APP_DEBUG'=>'false','APP_URL'=>'http://localhost/test','DB_HOST'=>'127.0.0.1','DB_PORT'=>'3306','DB_NAME'=>'security_policy_test','DB_USER'=>'test_runtime','DB_PASS'=>'','DB_CHARSET'=>'utf8mb4','SESSION_SECURE'=>'false','SESSION_COOKIE_NAME'=>'test_security_policy','SESSION_LIFETIME'=>'7200','MAX_UPLOAD_SIZE_MB'=>'50','API_MUTATION_LIMIT'=>'120','API_UPLOAD_LIMIT'=>'20','API_EXPENSIVE_READ_LIMIT'=>'60','API_RATE_WINDOW_SECONDS'=>'60'];
foreach($values as $key=>$value)putenv($key.'='.$value);
check(Env::configurationErrors()===[],'valid local/testing settings accepted without database connection');
foreach(['APP_ENV'=>'unknown','APP_DEBUG'=>'perhaps','SESSION_SECURE'=>'falsex','DB_PORT'=>'3306suffix','SESSION_LIFETIME'=>'0','MAX_UPLOAD_SIZE_MB'=>'-1','API_MUTATION_LIMIT'=>'1.5','API_UPLOAD_LIMIT'=>'0','API_EXPENSIVE_READ_LIMIT'=>'-2','API_RATE_WINDOW_SECONDS'=>'90000','DB_NAME'=>'bad;name','DB_CHARSET'=>'latin1','SESSION_COOKIE_NAME'=>'bad cookie','APP_URL'=>'https://user:secret@example.invalid/test'] as $key=>$value){
 putenv($key.'='.$value);$errors=Env::configurationErrors();check((bool)array_filter($errors,fn($error)=>str_starts_with($error,$key)),'invalid '.$key.' rejected with key-only reason');check(!str_contains(implode(' ',$errors),$value),'invalid '.$key.' value is not echoed');putenv($key.'='.$values[$key]);
}
putenv('APP_ENV=production');putenv('APP_DEBUG=true');
check(!Env::debugEnabled(),'production debug stays disabled even when flag wrongly enabled');
$errors=Env::configurationErrors();
foreach(['APP_DEBUG','SESSION_SECURE','APP_URL','DB_PASS'] as $key)check((bool)array_filter($errors,fn($error)=>str_starts_with($error,$key)),'production fails closed on unsafe '.$key);
putenv('DB_USER=root');check((bool)array_filter(Env::configurationErrors(),fn($error)=>str_starts_with($error,'DB_USER')),'production rejects root runtime account');
foreach(['APP_DEBUG'=>'false','SESSION_SECURE'=>'true','APP_URL'=>'https://range.example.invalid/test','DB_USER'=>'restricted_runtime','DB_PASS'=>'TEST_ONLY_NONSECRET_SENTINEL'] as $key=>$value)putenv($key.'='.$value);
check(Env::configurationErrors()===[],'production configuration accepted only with explicit safe settings');
$_SERVER=['HTTPS'=>'off','HTTP_X_FORWARDED_PROTO'=>'https'];
check(!SecurityPolicy::isHttps(),'untrusted forwarded HTTPS header cannot authorize HTTPS mode');
check(!isset(SecurityPolicy::headers()['Strict-Transport-Security']),'HSTS absent on production plaintext HTTP');
$_SERVER['HTTPS']='on';$headers=SecurityPolicy::headers();
check(($headers['Strict-Transport-Security']??'')==='max-age=31536000','HSTS present only for production actual HTTPS');
putenv('APP_ENV=local');check(!isset(SecurityPolicy::headers()['Strict-Transport-Security']),'local HTTPS does not accidentally enable HSTS');
$headers=SecurityPolicy::headers();$csp=$headers['Content-Security-Policy'];
check(str_contains($csp,"script-src 'self' 'unsafe-inline'")&&!str_contains($csp,'unsafe-eval')&&!str_contains($csp,'cdn.tailwindcss.com'),'CSP disallows eval and external executable CDN scripts');
check(str_contains($csp,'https://fonts.googleapis.com')&&str_contains($csp,'https://fonts.gstatic.com'),'CSP retains approved external fonts');
check(str_contains($csp,"object-src 'none'")&&str_contains($csp,"connect-src 'self'")&&str_contains($csp,"frame-ancestors 'self'")&&str_contains($csp,"form-action 'self'"),'CSP restricts plugins, API connections, frames and form destinations');
check($headers['Cache-Control']==='private, no-store, max-age=0','HTML and API shared policy prohibits authenticated caching');
check(!array_filter(array_keys($headers),fn($key)=>str_starts_with($key,'Access-Control-')),'same-origin policy grants no CORS credentials or wildcard access');
check($headers['X-Content-Type-Options']==='nosniff'&&$headers['X-Frame-Options']==='SAMEORIGIN','nosniff and frame defense applied consistently');
check($headers['Referrer-Policy']==='strict-origin-when-cross-origin'&&str_contains($headers['Permissions-Policy'],'microphone=()'),'referrer and feature policies are explicit');
$_SERVER=['REQUEST_METHOD'=>'POST','HTTP_HOST'=>'localhost:80','HTTP_ORIGIN'=>'http://localhost'];check(SecurityPolicy::sameOriginWrite(),'same-origin browser write normalizes default HTTP port');
$_SERVER['HTTPS']='on';$_SERVER['HTTP_HOST']='LOCALHOST:443';$_SERVER['HTTP_ORIGIN']='https://localhost';check(SecurityPolicy::sameOriginWrite(),'same-origin HTTPS write normalizes hostname and default port');
foreach(['https://untrusted.invalid','http://localhost','https://localhost:444','null','https://user:password@localhost','https://localhost/path','https://localhost#fragment','https://localhost, https://untrusted.invalid'] as $origin){$_SERVER['HTTP_ORIGIN']=$origin;check(!SecurityPolicy::sameOriginWrite(),'foreign/malformed browser origin denied: '.(str_contains($origin,'password')?'userinfo':$origin));}
unset($_SERVER['HTTP_ORIGIN']);check(SecurityPolicy::sameOriginWrite(),'CLI/non-browser writes without Origin still require existing CSRF elsewhere');
$_SERVER['HTTP_ORIGIN']='https://untrusted.invalid';foreach(['GET','HEAD','OPTIONS'] as $method){$_SERVER['REQUEST_METHOD']=$method;check(SecurityPolicy::sameOriginWrite(),$method.' remains a read with no cross-origin CORS grant');}
putenv('APP_URL=http://localhost/nested/test');
foreach(['api/v1/datasets/1/preview','api/v1/data/datasets/1/download','api/v1/soc/datasets/1/preview','api/v1/data/processed/1/download','api/v1/models','api/v1/registry/models','api/models.php','api/v1/soc/models/summary','api/v1/admin/overview','api/v1/soc/overview','api/v1/soc/students/1/progress','Model%20Registry%20%26%20Deployment/ModelRegistry.php','Data%20Center/DataProfilingAndQuality.php'] as $path)check(RateLimiter::isExpensiveRead('GET','/nested/test/'.$path.'?ignored=auth/me'),'known expensive read classified across alias: '.$path);
foreach(['api/v1/auth/csrf','api/v1/auth/me','api/v1/project/notifications','api/v1/models/1','login.php'] as $path)check(!RateLimiter::isExpensiveRead('GET','/nested/test/'.$path),'ordinary/recovery read has no quota-row side effect: '.$path);
foreach(['API/models.php','api//models.php','api/v1//registry/models','api/../api/models.php','./api/models.php'] as $path)check(RateLimiter::isExpensiveRead('GET','/NESTED/TEST/'.$path),'Apache normalization cannot bypass read admission: '.$path);
foreach(['POST','PATCH','HEAD','OPTIONS'] as $method)check(!RateLimiter::isExpensiveRead($method,'/nested/test/api/v1/models'),$method.' is not charged as an expensive GET');
check(!RateLimiter::isExpensiveRead('GET','/different-install/api/v1/models'),'another installation prefix is not accidentally classified');
echo $count.' security policy checks passed; no real environment, session or database accessed.'.PHP_EOL;
