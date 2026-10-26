<?php

declare(strict_types=1);

require_once __DIR__ . '/../app/bootstrap.php';

use App\Core\Database;
use App\Middleware\AuthorizationMiddleware;

AuthorizationMiddleware::requireAdmin(true);

header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');

$dbConnected = false;
$activeScenario = null;
$counts = ['students' => 0, 'tickets' => 0, 'datasets' => 0, 'models' => 0];

try {
    $db = Database::getConnection();
    $db->query('SELECT 1')->fetchColumn();
    $dbConnected = true;

    // Fetch active scenario if one exists
    $scenarioRow = Database::queryOne("SELECT * FROM scenarios WHERE status = 'PUBLISHED' ORDER BY id ASC LIMIT 1");
    if ($scenarioRow) {
        $activeScenario = [
            'id'         => $scenarioRow['code'],
            'title'      => $scenarioRow['title'],
            'version'    => $scenarioRow['version'],
            'difficulty' => $scenarioRow['difficulty'],
            'department' => $scenarioRow['department'],
            'status'     => $scenarioRow['status']
        ];
    }

    $counts['students'] = (int)Database::queryOne("SELECT COUNT(*) as c FROM users WHERE role = 'STUDENT' AND status = 'ACTIVE'")['c'];
    $counts['tickets']  = (int)Database::queryOne("SELECT COUNT(*) as c FROM tickets WHERE status NOT IN ('DRAFT', 'APPROVED', 'CANCELLED')")['c'];
    $counts['datasets'] = (int)Database::queryOne("SELECT COUNT(*) as c FROM datasets")['c'];
    $counts['models']   = (int)Database::queryOne("SELECT COUNT(*) as c FROM models")['c'];
} catch (\Throwable $e) {
    $dbConnected = false;
    $activeScenario = null;
    $counts = ['students' => null, 'tickets' => null, 'datasets' => null, 'models' => null];
}

$response = [
    'status'          => $dbConnected ? 'ONLINE' : 'DEGRADED',
    'timestamp'       => date('c'),
    'mission'         => 'VOSTOKPRIBOR AI Engineering Range',
    'database'        => [
        'status'    => $dbConnected ? 'CONNECTED' : 'DISCONNECTED',
        'engine'    => 'MariaDB / MySQL'
    ],
    'active_scenario' => $activeScenario,
    'metrics'         => $counts,
    'subsystems'      => [
        'SYS-AI-01' => ['name' => 'AI Project Management', 'status' => 'NOT_AVAILABLE'],
        'SYS-AI-02' => ['name' => 'Data Center & Feature Store', 'status' => 'NOT_AVAILABLE'],
        'SYS-AI-03' => ['name' => 'ML Workbench & Notebook', 'status' => 'NOT_AVAILABLE', 'execution' => 'DISABLED_NO_ISOLATED_RUNNER'],
        'SYS-AI-04' => ['name' => 'Model Registry & Deployment', 'status' => 'NOT_AVAILABLE'],
        'SYS-AI-05' => ['name' => 'AI SOC & Admin Flight Deck', 'status' => 'NOT_AVAILABLE']
    ]
];

echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
