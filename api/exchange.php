<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

$exchange = [
    'protocol' => 'VOSTOKPRIBOR-CROSS-SYSTEM-SYNC-v1',
    'timestamp' => date('c'),
    'active_scenario_id' => 'SCN-CHURN-101',
    'sync_nodes' => 5,
    'scenarios_count' => 7,
    'scenarios' => [
        [
            'id' => 'SCN-CHURN-101',
            'title' => 'Customer Churn Prediction',
            'difficulty' => 'Level 1',
            'assigned_department' => 'Flight Operations Data Core',
            'tickets_count' => 8,
            'students_count' => 24,
            'status' => 'Published',
            'version' => 'v2.4'
        ],
        [
            'id' => 'SCN-FRAUD-102',
            'title' => 'Fraud Detection',
            'difficulty' => 'Level 2',
            'assigned_department' => 'Security & Compliance Wing',
            'tickets_count' => 12,
            'students_count' => 18,
            'status' => 'Published',
            'version' => 'v2.1'
        ],
        [
            'id' => 'SCN-DEFECT-103',
            'title' => 'Manufacturing Defect Inspection',
            'difficulty' => 'Level 2',
            'assigned_department' => 'Propulsion & Hardware Reliability',
            'tickets_count' => 10,
            'students_count' => 15,
            'status' => 'Published',
            'version' => 'v1.9'
        ],
        [
            'id' => 'SCN-COMPLAINT-104',
            'title' => 'Customer Complaint Classification',
            'difficulty' => 'Level 1',
            'assigned_department' => 'Mission Communications & Support',
            'tickets_count' => 6,
            'students_count' => 28,
            'status' => 'Published',
            'version' => 'v2.0'
        ],
        [
            'id' => 'SCN-HR-105',
            'title' => 'HR Knowledge Assistant (RAG)',
            'difficulty' => 'Level 3',
            'assigned_department' => 'Astronaut Cadre Personnel Division',
            'tickets_count' => 14,
            'students_count' => 12,
            'status' => 'Published',
            'version' => 'v1.4'
        ],
        [
            'id' => 'SCN-SUPPORT-106',
            'title' => 'Customer Support AI Agent',
            'difficulty' => 'Level 3',
            'assigned_department' => 'Flight Dispatch & Ground Operations',
            'tickets_count' => 16,
            'students_count' => 10,
            'status' => 'Ready for Review',
            'version' => 'v1.2'
        ],
        [
            'id' => 'SCN-FAIL-107',
            'title' => 'Model Failure & AI SOC',
            'difficulty' => 'Level 3',
            'assigned_department' => 'AI Safety & Mission Assurance Bureau',
            'tickets_count' => 15,
            'students_count' => 16,
            'status' => 'Active',
            'version' => 'v3.0'
        ]
    ]
];

echo json_encode($exchange, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
