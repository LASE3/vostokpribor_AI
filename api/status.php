<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

$response = [
    'status' => 'ONLINE',
    'timestamp' => date('c'),
    'mission' => 'VOSTOKPRIBOR AI Engineering Range',
    'version' => 'v4.8.2',
    'active_node' => 'ORB-NODE-09',
    'cluster' => [
        'compute_tflops' => 88.4,
        'vram_used_gb' => 78.4,
        'vram_total_gb' => 80.0,
        'mesh_latency_ms' => 12,
        'gateway' => 'NOMINAL'
    ],
    'active_scenario' => [
        'id' => 'SCN-CHURN-101',
        'title' => 'Customer Churn Prediction',
        'version' => 'v2.4',
        'difficulty' => 'Intermediate (Level 1)',
        'department' => 'Flight Operations Data Core',
        'status' => 'Published'
    ],
    'subsystems' => [
        'SYS-AI-01' => ['name' => 'AI Project Management', 'status' => 'OPERATIONAL', 'endpoint' => 'AI Project Management/Dashboard.php'],
        'SYS-AI-02' => ['name' => 'Data Center & Feature Store', 'status' => 'SYNCED', 'endpoint' => 'Data Center/dashboard.php'],
        'SYS-AI-03' => ['name' => 'ML Workbench & Notebook', 'status' => 'ENGAGED', 'endpoint' => 'ML Workbench/NotebookWorkbench.php'],
        'SYS-AI-04' => ['name' => 'Model Registry & Deployment', 'status' => 'CANARY_GATE', 'endpoint' => 'Model Registry & Deployment/dashboard.php'],
        'SYS-AI-05' => ['name' => 'AI SOC & Scenario Builder', 'status' => 'ACTIVE', 'endpoint' => 'AI Operations Center (AI SOC)/TicketsAndScenarios.php']
    ]
];

echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
