<?php

declare(strict_types=1);

/**
 * VOSTOKPRIBOR AI Engineering Range
 * Unified Navigation Configuration for all Five Systems
 */

return [
    'project' => [
        'name' => 'AI Project Management',
        'code' => 'SYS-AI-01',
        'folder' => 'AI Project Management',
        'items' => [
            [
                'id' => 'dashboard',
                'label' => 'Dashboard',
                'icon' => 'space_dashboard',
                'file' => 'Dashboard.php',
            ],
            [
                'id' => 'my-tickets',
                'label' => 'My Tickets',
                'icon' => 'assignment',
                'file' => 'Tickets.php',
            ],
            [
                'id' => 'ticket-details',
                'label' => 'Ticket Details',
                'icon' => 'description',
                'file' => 'TicketDetails.php',
            ],
            [
                'id' => 'my-submissions',
                'label' => 'My Submissions',
                'icon' => 'inventory_2',
                'file' => 'Submissions.php',
            ],
            [
                'id' => 'student-profile',
                'label' => 'Student Profile',
                'icon' => 'badge',
                'file' => 'StudentProfile.php',
            ],
        ],
    ],

    'data' => [
        'name' => 'Data Center',
        'code' => 'SYS-AI-02',
        'folder' => 'Data Center',
        'items' => [
            [
                'id' => 'dashboard',
                'label' => 'Dashboard',
                'icon' => 'space_dashboard',
                'file' => 'dashboard.php',
            ],
            [
                'id' => 'dataset-catalog',
                'label' => 'Dataset Catalog',
                'icon' => 'dataset',
                'file' => 'DatasetCatalog.php',
            ],
            [
                'id' => 'my-datasets',
                'label' => 'My Datasets',
                'icon' => 'folder_shared',
                'file' => 'MyDataSet.php',
            ],
            [
                'id' => 'data-profiling-quality',
                'label' => 'Data Profiling & Quality',
                'icon' => 'troubleshoot',
                'file' => 'DataProfilingAndQuality.php',
            ],
            [
                'id' => 'query-workspace',
                'label' => 'Query Workspace',
                'icon' => 'terminal',
                'file' => 'QueryWorkspace.php',
            ],
            [
                'id' => 'upload-processed-data',
                'label' => 'Upload Processed Data',
                'icon' => 'cloud_upload',
                'file' => 'UploadProcessedData.php',
            ],
            [
                'id' => 'recent-activity-audit',
                'label' => 'Recent Activity & Audit',
                'icon' => 'history_toggle_off',
                'file' => 'RecentActivityAndAudit.php',
            ],
        ],
    ],

    'workbench' => [
        'name' => 'ML Workbench',
        'code' => 'SYS-AI-03',
        'folder' => 'ML Workbench',
        'items' => [
            [
                'id' => 'notebook-workbench',
                'label' => 'Notebook Workbench',
                'icon' => 'code',
                'file' => 'NotebookWorkbench.php',
            ],
            [
                'id' => 'experiment-runs',
                'label' => 'Experiment Runs',
                'icon' => 'query_stats',
                'file' => 'ExperimentRuns.php',
            ],
            [
                'id' => 'metric-telemetry',
                'label' => 'Metric Telemetry',
                'icon' => 'insights',
                'file' => 'MetricTelemetry.php',
            ],
            [
                'id' => 'tensor-inspector',
                'label' => 'Tensor Inspector',
                'icon' => 'grid_view',
                'file' => 'TensorInspector.php',
            ],
            [
                'id' => 'hyperparameter-matrix',
                'label' => 'Hyperparameter Matrix',
                'icon' => 'tune',
                'file' => 'HyperparameterMatrix.php',
            ],
            [
                'id' => 'model-artifacts',
                'label' => 'Model Artifacts',
                'icon' => 'inventory_2',
                'file' => 'ModelArtifacts.php',
            ],
            [
                'id' => 'range-evaluation',
                'label' => 'Range Evaluation',
                'icon' => 'verified',
                'file' => 'RangeEvaluation.php',
            ],
        ],
    ],

    'registry' => [
        'name' => 'Model Registry & Deployment',
        'code' => 'SYS-AI-04',
        'folder' => 'Model Registry & Deployment',
        'items' => [
            [
                'id' => 'dashboard',
                'label' => 'Dashboard',
                'icon' => 'space_dashboard',
                'file' => 'dashboard.php',
            ],
            [
                'id' => 'model-registry',
                'label' => 'Model Registry',
                'icon' => 'inventory_2',
                'file' => 'ModelRegistry.php',
            ],
            [
                'id' => 'validation-pipeline',
                'label' => 'Validation Pipeline',
                'icon' => 'fact_check',
                'file' => 'ValidationPipeline.php',
            ],
            [
                'id' => 'deployment-config',
                'label' => 'Deployment Config',
                'icon' => 'settings_input_component',
                'file' => 'DeploymentConfig.php',
            ],
            [
                'id' => 'deployed-endpoints',
                'label' => 'Deployed Endpoints',
                'icon' => 'cell_tower',
                'file' => 'DeployedEndpoints.php',
            ],
            [
                'id' => 'validation-reports',
                'label' => 'Validation Reports',
                'icon' => 'description',
                'file' => 'ValidationReports.php',
            ],
        ],
    ],

    'soc' => [
        'name' => 'AI Operations Center (AI SOC)',
        'code' => 'SYS-AI-05',
        'folder' => 'AI Operations Center (AI SOC)',
        'items' => [
            [
                'section' => 'OVERVIEW',
                'id' => 'dashboard',
                'label' => 'SOC Dashboard',
                'icon' => 'space_dashboard',
                'file' => 'Dashboard.php',
            ],
            [
                'section' => 'OVERVIEW',
                'id' => 'operations',
                'label' => 'Operations Telemetry',
                'icon' => 'hub',
                'file' => 'OperationsDashboard.php',
            ],
            [
                'section' => 'TRAINING MANAGEMENT',
                'id' => 'scenarios-tickets',
                'label' => 'Scenarios & Tickets',
                'icon' => 'tune',
                'file' => 'TicketsAndScenarios.php',
            ],
            [
                'section' => 'TRAINING MANAGEMENT',
                'id' => 'dataset-management',
                'label' => 'Dataset Management',
                'icon' => 'database',
                'file' => 'DatasetManagement.php',
            ],
            [
                'section' => 'TRAINING MANAGEMENT',
                'id' => 'students-cohorts',
                'label' => 'Students & Cohorts',
                'icon' => 'group',
                'file' => 'StudentManagement.php',
            ],
            [
                'section' => 'TRAINING MANAGEMENT',
                'id' => 'submission-reviews',
                'label' => 'Submission Reviews',
                'icon' => 'fact_check',
                'file' => 'WorkspaceConfiguration.php',
            ],
            ['section'=>'STUDENT WORKSPACE MONITORING','id'=>'student-workspaces','label'=>'Student Notebooks & Experiments','icon'=>'code','file'=>'StudentWorkspaces.php'],
            ['section'=>'MODEL OPERATIONS','id'=>'model-management','label'=>'Model Management','icon'=>'inventory_2','file'=>'ModelManagement.php'],
            ['section'=>'MODEL OPERATIONS','id'=>'validation-reports','label'=>'Validation Reports','icon'=>'description','file'=>'ValidationReports.php'],
            ['section'=>'MODEL OPERATIONS','id'=>'deployment-requests','label'=>'Deployment Requests','icon'=>'cell_tower','file'=>'DeploymentRequests.php'],
            ['section'=>'PLATFORM ADMINISTRATION','id'=>'workspace-settings','label'=>'Workspace Configuration','icon'=>'settings','file'=>'PlatformSettings.php'],
            ['section'=>'PLATFORM ADMINISTRATION','id'=>'audit-logs','label'=>'Audit Logs','icon'=>'history','file'=>'AuditLogs.php'],

        ],
    ],
];
