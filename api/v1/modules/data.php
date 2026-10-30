<?php
/** SYS-AI-02 routes. Shared session, router, controllers, services and PDO. */
use App\Controllers\DatasetController;
$router->get('data/datasets',[DatasetController::class,'index']);
$router->get('data/datasets/{id}',[DatasetController::class,'show']);
$router->get('data/datasets/{id}/preview',[DatasetController::class,'preview']);
$router->get('data/datasets/{id}/download',[DatasetController::class,'download']);
$router->get('data/datasets/{id}/versions',[DatasetController::class,'versions']);
$router->get('data/processed',[DatasetController::class,'processedIndex']);
$router->post('data/processed',[DatasetController::class,'storeProcessed']);
$router->get('data/processed/{id}',[DatasetController::class,'processedShow']);
$router->get('data/processed/{id}/download',[DatasetController::class,'processedDownload']);
$router->get('data/activity',[DatasetController::class,'activityIndex']);
// Compatibility routes use exactly the same operations.
$router->get('datasets',[DatasetController::class,'index']);
$router->post('datasets',[DatasetController::class,'store']);
$router->post('datasets/processed',[DatasetController::class,'storeProcessed']);
$router->get('datasets/{id}',[DatasetController::class,'show']);
$router->get('datasets/{id}/preview',[DatasetController::class,'preview']);
$router->get('datasets/{id}/download',[DatasetController::class,'download']);
$router->get('datasets/{id}/versions',[DatasetController::class,'versions']);
$router->post('datasets/{id}/assignments',[DatasetController::class,'assign']);
