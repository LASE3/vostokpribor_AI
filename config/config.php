<?php
/**
 * VOSTOKPRIBOR AI • Core Configuration & System Registry
 * Unified settings for all 5 subsystems, database exchange, and performance headers.
 */

if (!defined('VOSTOK_CONFIG_LOADED')) {
    define('VOSTOK_CONFIG_LOADED', true);

    // App Information
    define('APP_NAME', 'VOSTOKPRIBOR AI');
    define('APP_CODENAME', 'AVIONICS DISPATCH');
    define('APP_VERSION', 'v4.8.2-rt');

    // Database Connection Parameters
    define('DB_HOST', '127.0.0.1');
    define('DB_PORT', '3306');
    define('DB_NAME', 'vostokpribor_ai');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_CHARSET', 'utf8mb4');

    // System Registry
    $GLOBALS['VOSTOK_SYSTEMS'] = [
        'projects' => [
            'id' => 1,
            'code' => 'SYS-AI-01',
            'name' => 'AI Project Management',
            'dir' => 'AI Project Management',
            'entry' => 'Dashboard.php',
            'icon' => 'folder_special',
            'badge' => 'OPERATIONAL',
            'status_color' => 'emerald',
            'description' => 'Project tracking, deliverable audits, gradebooks, ticket kanbans, and cadet team workflows.',
            'metrics' => [
                'tasks' => '24 Active Tasks',
                'sprint' => 'Sprint 4 (94.2%)',
                'deliverables' => '18 Submissions'
            ],
            'pages' => [
                ['name' => 'Dashboard', 'file' => 'Dashboard.php'],
                ['name' => 'Deliverables & Submissions', 'file' => 'DeliverablesAndSubmissionPanel.php'],
                ['name' => 'Evaluation Rubric', 'file' => 'EvaluationView.php'],
                ['name' => 'Instructor Command', 'file' => 'InstructorDashboard.php'],
                ['name' => 'Kanban Ticket Board', 'file' => 'TicketBoard.php'],
                ['name' => 'Ticket Detail', 'file' => 'TicketDetail.php']
            ]
        ],
        'data_center' => [
            'id' => 2,
            'code' => 'SYS-AI-02',
            'name' => 'Data Center',
            'dir' => 'Data Center',
            'entry' => 'DatasetCatalog.php',
            'icon' => 'dataset',
            'badge' => 'SYNCHRONIZED',
            'status_color' => 'emerald',
            'description' => 'High-throughput feature store, data lineage graphs, SQL studio query engine, and telemetry ingest.',
            'metrics' => [
                'storage' => '1.4 TB Ingested',
                'features' => '24 Feature Tables',
                'lineage' => '100% Verified DAG'
            ],
            'pages' => [
                ['name' => 'Dataset Catalog', 'file' => 'DatasetCatalog.php'],
                ['name' => 'Dataset Detail', 'file' => 'DatasetDetail.php'],
                ['name' => 'Data Lineage & Audit', 'file' => 'DataLineageAndAuditHistory.php'],
                ['name' => 'Query Workspace', 'file' => 'QueryWorkspace.php'],
                ['name' => 'Upload Processed Data', 'file' => 'UploadProcessedData.php'],
                ['name' => 'Export & Download', 'file' => 'DownloadAndExportDialog.php']
            ]
        ],
        'workbench' => [
            'id' => 3,
            'code' => 'SYS-AI-03',
            'name' => 'AI/ML Workbench',
            'dir' => 'AI/ML Workbench',
            'entry' => 'WorkbenchHome.php',
            'icon' => 'precision_manufacturing',
            'badge' => 'ENGAGED',
            'status_color' => 'tertiary',
            'description' => 'Exploratory modeling, hyperparameter optimization, run comparisons, and LLM agent chains.',
            'metrics' => [
                'experiments' => '18 Active Runs',
                'champion_f1' => 'F1: 0.884 Champion',
                'compute' => '88.4 TFLOPS (8 GPUs)'
            ],
            'pages' => [
                ['name' => 'Workbench Home', 'file' => 'WorkbenchHome.php'],
                ['name' => 'Experiment Builder', 'file' => 'ExperimentBuilder.php'],
                ['name' => 'Run Results & Curves', 'file' => 'RunResults.php'],
                ['name' => 'Compare Runs', 'file' => 'CompareRuns.php'],
                ['name' => 'GenAI & Agent Workbench', 'file' => 'GenAI_AndAgentWorkbench.php'],
                ['name' => 'Model Lineage Graph', 'file' => 'ModelLineageGraph.php'],
                ['name' => 'Register Model Dialog', 'file' => 'RegisterModelDialog.php']
            ]
        ],
        'registry' => [
            'id' => 4,
            'code' => 'SYS-AI-04',
            'name' => 'Model Registry & Deployment',
            'dir' => 'Model Registry & Deployment',
            'entry' => 'ModelRegistry.php',
            'icon' => 'rocket_launch',
            'badge' => 'CANARY GATE',
            'status_color' => 'emerald',
            'description' => 'Production gates, canary deployments, Triton/K8s cluster endpoints, and model cards.',
            'metrics' => [
                'endpoints' => '12 Production Pods',
                'traffic' => '10% Canary (churn_rf_v2)',
                'latency' => '11.4 ms P99'
            ],
            'pages' => [
                ['name' => 'Model Registry', 'file' => 'ModelRegistry.php'],
                ['name' => 'Model Card (churn_rf_v2)', 'file' => 'ModelCard.php'],
                ['name' => 'Deployment Wizard', 'file' => 'DeploymentWizard.php'],
                ['name' => 'Endpoint Console (Swagger)', 'file' => 'EndpointConsole.php'],
                ['name' => 'Enterprise Integrations', 'file' => 'EnterpriseIntegrations.php'],
                ['name' => 'Releases & Rollback', 'file' => 'DeploymentHistoryRollback.php']
            ]
        ],
        'soc' => [
            'id' => 5,
            'code' => 'SYS-AI-05',
            'name' => 'AI Operations Center (AI SOC)',
            'dir' => 'AI Operations Center (AI SOC)',
            'entry' => 'FleetTelemetry.php',
            'icon' => 'shield_with_heart',
            'badge' => 'ALERT ACTIVE',
            'status_color' => 'error',
            'description' => 'Live fleet telemetry, real-time drift anomaly detection, war room triage, and post-mortems.',
            'metrics' => [
                'incident' => 'INC-4092 Investigating',
                'mesh' => '12ms Uplink Latency',
                'drift' => 'Δ -29.8% F1 Drift Alert'
            ],
            'pages' => [
                ['name' => 'Fleet Telemetry (Wall Display)', 'file' => 'FleetTelemetry.php'],
                ['name' => 'Incident Triage (Alerts)', 'file' => 'IncidentTriage.php'],
                ['name' => 'Model Monitoring Detail', 'file' => 'ModelMonitoringDetail.php'],
                ['name' => 'Drift Investigation', 'file' => 'DriftInvestigationWorkspace.php'],
                ['name' => 'Incident War Room', 'file' => 'IncidentWarRoom.php'],
                ['name' => 'Post-Mortem Drill', 'file' => 'IncidentPostMortem.php'],
                ['name' => 'Alert Rules & Config', 'file' => 'AlertRulesAndDriftConfiguration.php']
            ]
        ]
    ];

    /**
     * Performance optimization headers
     */
    function apply_perf_headers() {
        if (!headers_sent()) {
            header('X-Content-Type-Options: nosniff');
            header('X-Frame-Options: SAMEORIGIN');
            header('X-XSS-Protection: 1; mode=block');
            header('Referrer-Policy: strict-origin-when-cross-origin');
            
            // Enable gzip compression if not already active
            if (!ob_get_level() && extension_loaded('zlib') && !ini_get('zlib.output_compression')) {
                ob_start('ob_gzhandler');
            }
        }
    }
}
