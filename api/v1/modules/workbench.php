<?php
use App\Controllers\NotebookController;
use App\Controllers\ExperimentController;
use App\Controllers\ExecutionController;
use App\Controllers\ModelController;

foreach (['workbench/notebooks','notebooks'] as $base) {
    $router->get($base, [NotebookController::class, 'index']);
    $router->post($base, [NotebookController::class, 'store']);
    $router->get($base.'/{id}', [NotebookController::class, 'show']);
    $router->patch($base.'/{id}', [NotebookController::class, 'update']);
}
foreach (['workbench/experiments','experiments'] as $base) {
    $router->get($base, [ExperimentController::class, 'index']);
    $router->post($base, [ExperimentController::class, 'store']);
    $router->get($base.'/{id}', [ExperimentController::class, 'show']);
}
foreach (['workbench/runs','experiment-runs'] as $base) {
    $router->get($base, [ExperimentController::class, 'listRuns']);
    $router->post($base, [ExperimentController::class, 'storeRun']);
}
$router->get('workbench/artifacts', [ModelController::class, 'artifacts']);
$router->get('workbench/execution-status', [ExecutionController::class, 'status']);
$router->post('execution-jobs', [ExecutionController::class, 'store']);
$router->get('execution-jobs/{id}', [ExecutionController::class, 'show']);
$router->post('execution-jobs/{id}/cancel', [ExecutionController::class, 'cancel']);
