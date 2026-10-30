<?php
declare(strict_types=1);
require_once __DIR__.'/../../app/bootstrap.php';
use App\Core\{Request,Router,ApiRoutes};
use App\Middleware\CsrfMiddleware;
$router=new Router();
$request=new Request();
CsrfMiddleware::handle($request);
ApiRoutes::register($router);
$router->dispatch($request);
