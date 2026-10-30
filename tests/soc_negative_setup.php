<?php
declare(strict_types=1);
if(PHP_SAPI!=='cli'){http_response_code(403);exit;}
require_once __DIR__.'/../app/bootstrap.php';
use App\Core\Env;
use App\Core\Database;
use App\Services\UserService;
if(Env::get('APP_ENV')!=='testing'||!str_ends_with((string)Env::get('DB_NAME'),'_test')||!in_array(Env::get('DB_HOST'),['127.0.0.1','localhost','::1'],true)){fwrite(STDERR,"REFUSED: dedicated local _test environment required.\n");exit(1);}
$admin=Database::queryOne("SELECT id FROM users WHERE role='ADMIN' AND status='ACTIVE' ORDER BY id LIMIT 1");
if(!$admin)throw new RuntimeException('Test administrator required.');
$identifier='SOC-NEG-'.strtoupper(bin2hex(random_bytes(6)));$password=bin2hex(random_bytes(24));
$user=(new UserService())->createStudent(['full_name'=>'SOC negative HTTP verification','email'=>strtolower($identifier).'@example.invalid','identifier'=>$identifier,'password'=>$password],(int)$admin['id']);
$router=new class{
 public array $routes=[];
 public function __call(string $method,array $args):void{$this->routes[]=['method'=>strtoupper($method),'path'=>$args[0]];}
};
require __DIR__.'/../api/v1/modules/soc.php';
$routes=array_values(array_filter($router->routes,fn($r)=>str_starts_with($r['path'],'soc/')));
echo json_encode(['base_url'=>Env::get('APP_URL'),'database'=>Env::get('DB_NAME'),'identifier'=>$identifier,'password'=>$password,'user_id'=>(int)$user['id'],'routes'=>$routes],JSON_THROW_ON_ERROR);
