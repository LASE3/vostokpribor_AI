<?php

declare(strict_types=1);

require_once __DIR__ . '/../../app/bootstrap.php';

use App\Core\Request;
use App\Core\Router;
use App\Controllers\AuthController;
use App\Controllers\UserController;
use App\Controllers\TicketController;
use App\Controllers\ScenarioController;
use App\Controllers\DatasetController;
use App\Controllers\NotebookController;
use App\Controllers\ExecutionController;
use App\Controllers\ExperimentController;
use App\Controllers\ModelController;
use App\Controllers\ValidationController;
use App\Controllers\DeploymentController;
use App\Controllers\SubmissionController;
use App\Controllers\AdminController;
use App\Middleware\CsrfMiddleware;

$router = new Router();
$request = new Request();

// Session-bound tokens are required even for login (login CSRF protection).
// A client first GETs auth/csrf and retains that response's session cookie.
CsrfMiddleware::handle($request);

// 1. Authentication
$router->post('auth/login', [AuthController::class, 'login']);
$router->get('auth/csrf', [AuthController::class, 'csrf']);
$router->post('auth/change-password', [AuthController::class, 'changePassword']);
$router->post('auth/logout', [AuthController::class, 'logout']);
$router->get('auth/me', [AuthController::class, 'me']);

// 2. Users / Student Management
$router->get('users', [UserController::class, 'index']);
$router->post('users', [UserController::class, 'store']);
$router->get('users/{id}', [UserController::class, 'show']);
$router->patch('users/{id}', [UserController::class, 'update']);

// 3. Tickets
$router->get('tickets', [TicketController::class, 'index']);
$router->post('tickets', [TicketController::class, 'store']);
$router->get('tickets/{id}', [TicketController::class, 'show']);
$router->patch('tickets/{id}', [TicketController::class, 'update']);
$router->post('tickets/{id}/assignments', [TicketController::class, 'assign']);
$router->post('tickets/{id}/comments', [TicketController::class, 'addComment']);

// 4. Scenarios
$router->get('scenarios', [ScenarioController::class, 'index']);
$router->post('scenarios', [ScenarioController::class, 'store']);
$router->get('scenarios/{id}', [ScenarioController::class, 'show']);
$router->patch('scenarios/{id}', [ScenarioController::class, 'update']);

// 5. Datasets
$router->get('datasets', [DatasetController::class, 'index']);
$router->post('datasets', [DatasetController::class, 'store']);
$router->get('datasets/{id}', [DatasetController::class, 'show']);
$router->get('datasets/{id}/preview', [DatasetController::class, 'preview']);
$router->get('datasets/{id}/download', [DatasetController::class, 'download']);
$router->post('datasets/{id}/assignments', [DatasetController::class, 'assign']);
$router->post('datasets/processed', [DatasetController::class, 'storeProcessed']);

// 6. Notebooks
$router->get('notebooks', [NotebookController::class, 'index']);
$router->post('notebooks', [NotebookController::class, 'store']);
$router->get('notebooks/{id}', [NotebookController::class, 'show']);
$router->patch('notebooks/{id}', [NotebookController::class, 'update']);

// 7. Execution Jobs
$router->post('execution-jobs', [ExecutionController::class, 'store']);
$router->get('execution-jobs/{id}', [ExecutionController::class, 'show']);
$router->post('execution-jobs/{id}/cancel', [ExecutionController::class, 'cancel']);

// 8. Experiments & Telemetry Runs
$router->get('experiments', [ExperimentController::class, 'index']);
$router->post('experiments', [ExperimentController::class, 'store']);
$router->get('experiment-runs', [ExperimentController::class, 'listRuns']);
$router->post('experiment-runs', [ExperimentController::class, 'storeRun']);

// 9. Models
$router->get('models', [ModelController::class, 'index']);
$router->post('models', [ModelController::class, 'store']);
$router->get('models/{id}', [ModelController::class, 'show']);
$router->post('models/{id}/versions', [ModelController::class, 'addVersion']);

// 10. Validation Runs
$router->post('validation-runs', [ValidationController::class, 'store']);
$router->get('validation-runs/{id}', [ValidationController::class, 'show']);

// 11. Deployments
$router->get('deployments', [DeploymentController::class, 'index']);
$router->post('deployment-requests', [DeploymentController::class, 'store']);
$router->patch('deployments/{id}', [DeploymentController::class, 'update']);

// 12. Submissions
$router->get('submissions', [SubmissionController::class, 'index']);
$router->post('submissions', [SubmissionController::class, 'store']);
$router->get('submissions/{id}', [SubmissionController::class, 'show']);
$router->post('submissions/{id}/review', [SubmissionController::class, 'review']);

// 13. Admin Telemetry & Operations
$router->get('admin/overview', [AdminController::class, 'overview']);
$router->get('admin/audit-logs', [AdminController::class, 'auditLogs']);
$router->get('admin/settings', [AdminController::class, 'getSettings']);
$router->patch('admin/settings', [AdminController::class, 'updateSettings']);

// Dispatch
$router->dispatch($request);
