<?php

declare(strict_types=1);

require_once __DIR__ . '/../app/bootstrap.php';

use App\Core\Database;

header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');

$dbConnected = false;
$activeScenario = null;
$counts = ['students' => 0, 'tickets' => 0, 'datasets' => 0, 'models' => 0];

try {
    $db = Database::getConnection();
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
}

$response = [
    'status'          => $dbConnected ? 'ONLINE' : 'DEGRADED',
    'timestamp'       => date('c'),
    'mission'         => 'VOSTOKPRIBOR AI Engineering Range',
    'version'         => 'v4.8.2',
    'active_node'     => 'ORB-NODE-09',
    'database'        => [
        'status'    => $dbConnected ? 'CONNECTED' : 'DISCONNECTED',
        'engine'    => 'MariaDB / MySQL',
        'database'  => 'vostokpribor_ai'
    ],
    'active_scenario' => $activeScenario,
    'metrics'         => $counts,
    'subsystems'      => [
        'SYS-AI-01' => ['name' => 'AI Project Management', 'status' => 'OPERATIONAL', 'endpoint' => 'AI Project Management/Dashboard.php'],
        'SYS-AI-02' => ['name' => 'Data Center & Feature Store', 'status' => 'OPERATIONAL', 'endpoint' => 'Data Center/dashboard.php'],
        'SYS-AI-03' => ['name' => 'ML Workbench & Notebook', 'status' => 'OPERATIONAL', 'endpoint' => 'ML Workbench/NotebookWorkbench.php'],
        'SYS-AI-04' => ['name' => 'Model Registry & Deployment', 'status' => 'OPERATIONAL', 'endpoint' => 'Model Registry & Deployment/dashboard.php'],
        'SYS-AI-05' => ['name' => 'AI SOC & Admin Flight Deck', 'status' => 'OPERATIONAL', 'endpoint' => 'AI Operations Center (AI SOC)/TicketsAndScenarios.php']
    ]
];

echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
