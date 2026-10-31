<?php

declare(strict_types=1);

require_once __DIR__ . '/../app/bootstrap.php';
require_once __DIR__ . '/../app/Views/Layout/AppLayout.php';

use App\Middleware\AuthorizationMiddleware;
use App\Core\Auth;
use App\Views\Layout\AppLayout;

AuthorizationMiddleware::requireAdmin();
$currentUser = Auth::user();
$dashboard = (new App\Services\SocSystemService())->dashboard((int)$currentUser['id']);
$overview = $dashboard['overview'];
$counts = [
    'students'=>$overview['students']['total'], 'scenarios'=>$overview['scenarios']['total'],
    'tickets'=>$overview['tickets']['total'], 'reviews'=>$overview['submissions']['pending'],
    'models'=>$overview['models']['registered'], 'datasets'=>$overview['datasets']['master'],
    'notebooks'=>$overview['ml_workbench']['notebooks'], 'submissions'=>$overview['submissions']['total'],
    'failed'=>$overview['execution_cluster']['failed'],
];
$auditLogs = $overview['recent_audit_actions'];
$students = $dashboard['students'];
$scenarios = $dashboard['scenarios'];
$health = $dashboard['health'];
$databaseHealth = $health['database']['status'] . ' · ' . $health['database']['round_trip_ms'] . ' ms';
$pageType = 'dashboard';

AppLayout::start([
    'pageTitle' => 'VOSTOKPRIBOR AI · SOC Mission Control Dashboard',
    'systemKey' => 'soc',
    'activePage' => 'Dashboard.php',
    'currentUser' => $currentUser,
]);

require __DIR__ . '/_dashboard_panels.php';

AppLayout::end([
    'extraScriptsHtml' => '<script src="../assets/js/range-client.js"></script>',
]);
