<?php
declare(strict_types=1);
require_once __DIR__.'/../../app/bootstrap.php';
use App\Core\{Request,Router,ApiRoutes,Auth,RateLimiter};
use App\Middleware\CsrfMiddleware;
$router=new Router();
$request=new Request();
CsrfMiddleware::handle($request);
$isLogout=$request->getMethod()==='POST'&&rawurldecode($request->getUri())===rawurldecode(\App\Core\AppUrl::to('api/v1/auth/logout'));
if (!$isLogout && !in_array($request->getMethod(), ['GET','HEAD','OPTIONS'], true) && ($actor=Auth::user())) {
    RateLimiter::authenticatedMutation((int)$actor['id']);
}
ApiRoutes::register($router);
$router->dispatch($request);
