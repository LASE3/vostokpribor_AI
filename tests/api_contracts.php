<?php
declare(strict_types=1);
if(PHP_SAPI!=='cli'){http_response_code(403);exit;}
require_once __DIR__.'/../app/bootstrap.php';
$router=new \App\Core\Router();\App\Core\ApiRoutes::register($router);$routes=$router->definitions();$map=[];
foreach($routes as $route){$key=$route['method'].' '.$route['path'];if(isset($map[$key]))throw new RuntimeException('Duplicate route: '.$key);$map[$key]=$route;
 [$class,$method]=explode('::',$route['handler']);if(!method_exists($class,$method)||!(new ReflectionMethod($class,$method))->isPublic())throw new RuntimeException('Missing public handler '.$route['handler']);
 if(str_starts_with($route['path'],'soc/')&&$route['middleware_count']<1)throw new RuntimeException('SOC route lacks central role gate: '.$key);
}
$required=json_decode(file_get_contents(__DIR__.'/contracts/api-required.json'),true,512,JSON_THROW_ON_ERROR);
foreach($required as $route){$key=$route['method'].' '.$route['path'];if(!isset($map[$key]))throw new RuntimeException('Required route missing: '.$key);echo 'PASS '.$key.PHP_EOL;}
$outputDirectory=__DIR__.'/../verification/integration-20261030';
if(!is_dir($outputDirectory)&&!mkdir($outputDirectory,0700,true))throw new RuntimeException('Cannot create test evidence directory.');
file_put_contents($outputDirectory.'/api-route-inventory.json',json_encode($routes,JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES));
echo 'PASS '.count($required).' required contracts; '.count($routes).' total routes; all handlers real, no duplicates, SOC gates present.'.PHP_EOL;
