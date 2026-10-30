<?php
namespace App\Core;
use App\Controllers\AuthController;
final class ApiRoutes
{
    public static function register(Router $router): void
    {
        $router->get('auth/csrf',[AuthController::class,'csrf']);
        $router->post('auth/login',[AuthController::class,'login']);
        $router->get('auth/me',[AuthController::class,'me']);
        $router->post('auth/change-password',[AuthController::class,'changePassword']);
        $router->post('auth/logout',[AuthController::class,'logout']);
        foreach(['project','data','workbench','registry','soc'] as $module) require dirname(__DIR__,2).'/api/v1/modules/'.$module.'.php';
    }
}
