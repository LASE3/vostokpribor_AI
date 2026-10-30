<?php
use App\Controllers\ModelController;
use App\Controllers\ValidationController;
use App\Controllers\DeploymentController;

foreach (['registry/models','models'] as $base) {
    $router->get($base, [ModelController::class, 'index']);
    $router->post($base, [ModelController::class, 'store']);
    $router->get($base.'/{id}', [ModelController::class, 'show']);
    $router->get($base.'/{id}/versions', [ModelController::class, 'versions']);
    $router->post($base.'/{id}/versions', [ModelController::class, 'addVersion']);
}
foreach (['registry/validations','validation-runs'] as $base) {
    $router->get($base, [ValidationController::class, 'index']);
    $router->post($base, [ValidationController::class, 'store']);
    $router->get($base.'/{id}', [ValidationController::class, 'show']);
}
foreach (['registry/deployments','deployments'] as $base) $router->get($base, [DeploymentController::class, 'index']);
foreach (['registry/deployment-requests','deployment-requests'] as $base) {
    $router->get($base, [DeploymentController::class, 'index']);
    $router->post($base, [DeploymentController::class, 'store']);
}
$router->patch('deployments/{id}', [DeploymentController::class, 'update']);
