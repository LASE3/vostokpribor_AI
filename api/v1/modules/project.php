<?php
use App\Controllers\TicketController;
use App\Controllers\SubmissionController;
foreach(['project/tickets','tickets'] as $prefix){
    $router->get($prefix,[TicketController::class,'index']);
    $router->get($prefix.'/{id}',[TicketController::class,'show']);
    $router->get($prefix.'/{id}/comments',[TicketController::class,'comments']);
    $router->post($prefix.'/{id}/comments',[TicketController::class,'addComment']);
}
$router->post('project/tickets/{id}/progress',[TicketController::class,'progress']);
$router->get('project/dashboard',[TicketController::class,'dashboard']);
$router->get('project/notifications',[TicketController::class,'notifications']);
$router->post('tickets',[TicketController::class,'store']);
$router->patch('tickets/{id}',[TicketController::class,'update']);
$router->post('tickets/{id}/assignments',[TicketController::class,'assign']);
foreach(['project/submissions','submissions'] as $prefix){
    $router->get($prefix,[SubmissionController::class,'index']);
    $router->post($prefix,[SubmissionController::class,'store']);
    $router->get($prefix.'/{id}',[SubmissionController::class,'show']);
}
$router->post('submissions/{id}/review',[SubmissionController::class,'review']);
