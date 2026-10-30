<?php

declare(strict_types=1);

require_once __DIR__ . '/../app/bootstrap.php';
require_once __DIR__ . '/../app/Views/Layout/AppLayout.php';

use App\Middleware\AuthorizationMiddleware;
use App\Core\Database;
use App\Core\Auth;
use App\Views\Layout\AppLayout;

AuthorizationMiddleware::requireAdmin();
$currentUser = Auth::user();
$db = Database::getInstance();

$counts = [];
foreach (
    [
        'students' => "SELECT COUNT(*) FROM users WHERE role='STUDENT'",
        'scenarios' => 'SELECT COUNT(*) FROM scenarios',
        'tickets' => 'SELECT COUNT(*) FROM tickets',
        'reviews' => "SELECT COUNT(*) FROM submissions WHERE status IN ('SUBMITTED','UNDER_REVIEW')",
        'models' => 'SELECT COUNT(*) FROM models',
        'datasets' => 'SELECT COUNT(*) FROM datasets',
        'notebooks' => 'SELECT COUNT(*) FROM notebooks',
        'submissions' => 'SELECT COUNT(*) FROM submissions',
        'failed' => "SELECT COUNT(*) FROM execution_jobs WHERE status='FAILED'"
    ] as $key => $sql
) {
    $counts[$key] = (int)$db->fetchValue($sql);
}

$auditLogs = $db->fetchAll('SELECT * FROM audit_logs ORDER BY id DESC LIMIT 20');
$students = $db->fetchAll("SELECT u.id, u.full_name, u.identifier, (SELECT COUNT(*) FROM ticket_assignments ta WHERE ta.student_id=u.id AND ta.revoked_at IS NULL) AS tickets_count, (SELECT COUNT(*) FROM submissions sub WHERE sub.student_id=u.id) AS submissions_count FROM users u WHERE role='STUDENT' ORDER BY created_at DESC LIMIT 10");
$scenarios = (new App\Services\ScenarioService())->listAll();
$started = hrtime(true);
$connected = (int)$db->fetchValue('SELECT 1');
$databaseHealth = $connected === 1 ? 'AVAILABLE · ' . round((hrtime(true) - $started) / 1000000, 2) . ' ms' : 'NOT AVAILABLE';
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
