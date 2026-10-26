<?php
// VOSTOKPRIBOR AI • SYS-AI-05: AI Operations Center (AI SOC) - Operations Triage
require_once __DIR__ . '/../app/bootstrap.php';

use App\Middleware\AuthorizationMiddleware;
use App\Core\Auth;

AuthorizationMiddleware::requireAdmin();
$currentUser = Auth::user();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="web_dashboard" name="shell-type" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=JetBrains+Mono:wght@100..900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="css/style.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="js/tailwind.config.js"></script>
</head>

<body class="fiberglass-bg font-body-md text-on-surface min-h-screen">
    <header class="fixed top-0 left-0 right-0 h-16 bg-surface-container-lowest/90 backdrop-blur-md shadow-[0_1px_8px_rgba(76,29,149,0.06)] z-50 flex items-center justify-between px-margin-desktop">
        <div class="flex items-center gap-space-lg">
            <div class="flex items-center gap-space-sm"><img alt="VOSTOKPRIBOR Logo" class="h-8 w-auto object-contain" src="https://lh3.googleusercontent.com/aida/AEtjO1WFY3uXJ_9VBQSYhio3LVjLuY04weLyokzp987wSe7sNmLm6J_v-iBWBRUy3suJiuOvORdi5ycPrycJRlBFblqocpH7MR32xcHH09--U1FZEYb_N7dqQPHlWW5BW_vPyKR6necxQ856c6yxbD1S94T0POQSl-8SC_gqw2chw0ZgIDADFAOBMGy7ZpT4PuJKdlN_YkmHcsGM8Ou4GukoU-klYJiuzJdHRIk4WL9qKtKyBqjVPsyWFLOElrc" />
                <div class="flex flex-col"><span class="font-headline-sm text-headline-sm text-primary tracking-tight">VOSTOKPRIBOR</span><span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Range AI Control</span></div>
            </div>
            <div class="h-6 w-px bg-surface-container-highest"></div>
            <nav class="hidden xl:flex items-center gap-space-xs p-1 bg-surface-container-low rounded-lg" data-active-classes="bg-secondary-container text-primary font-bold"><a class="px-space-sm py-1 rounded text-on-surface-variant hover:text-primary font-label-md text-label-md transition-colors" data-path="subsystem-tickets" href="../AI Project Management/Dashboard.php">SYS-AI-01</a><a class="px-space-sm py-1 rounded text-on-surface-variant hover:text-primary font-label-md text-label-md transition-colors" data-path="subsystem-data" href="../Data Center/dashboard.php">SYS-AI-02</a><a class="px-space-sm py-1 rounded text-on-surface-variant hover:text-primary font-label-md text-label-md transition-colors" data-path="subsystem-workbench" href="../ML Workbench/NotebookWorkbench.php">SYS-AI-03</a><a class="px-space-sm py-1 rounded text-on-surface-variant hover:text-primary font-label-md text-label-md transition-colors" data-path="subsystem-models" href="../Model Registry & Deployment/dashboard.php">SYS-AI-04</a><a class="px-space-sm py-1 rounded bg-primary-container text-white font-bold font-label-md text-label-md shadow-sm" data-path="dashboard" href="TicketsAndScenarios.php">SYS-AI-05 [ACTIVE]</a></nav>
        </div>
        <div class="flex items-center gap-space-md">
            <div class="hidden md:flex items-center gap-space-xs bg-surface-container px-space-md py-1.5 rounded-lg w-64 text-on-surface-variant"><span class="material-symbols-outlined text-[18px]">search</span><span class="font-body-sm text-body-sm text-on-surface-variant">Search telemetry, models...</span></div>
            <div class="hidden lg:flex items-center gap-space-xs bg-tertiary-fixed text-on-tertiary-fixed px-space-sm py-1 rounded-full font-label-sm text-label-sm"><span class="w-2 h-2 rounded-full bg-error animate-pulse"></span><span>SCN-904-ALPHA (LIVE)</span></div><button class="relative p-2 rounded-lg text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors"><span class="material-symbols-outlined text-[20px]">notifications</span><span class="absolute top-1.5 right-1.5 w-2 h-2 bg-error rounded-full"></span></button>
            <div class="flex items-center gap-space-sm pl-space-xs">
                <div class="flex flex-col text-right hidden sm:flex"><span class="font-label-md text-label-md text-on-surface leading-tight">K. VORONIN</span><span class="font-label-sm text-label-sm text-on-surface-variant uppercase">Chief Instructor</span></div>
                <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center"><span class="material-symbols-outlined text-on-primary text-[18px]">person</span></div>
            </div>
        </div>
    </header>
    <aside class="fixed left-0 top-16 bottom-0 w-72 bg-surface-container-lowest shadow-[0_1px_8px_rgba(76,29,149,0.04)] z-40 overflow-y-auto">
        <div class="p-space-md flex flex-col gap-space-lg">
            <nav class="flex flex-col gap-space-xs" data-active-classes="bg-primary-container text-on-primary font-semibold shadow-sm">
                <div class="px-space-sm py-1 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-widest">Overview</div><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="main-dashboard" href="Dashboard.php"><span class="material-symbols-outlined text-[18px]">space_dashboard</span><span class="font-body-md text-body-md">Main Dashboard</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="training-analytics" href="OperationsDashboard.php"><span class="material-symbols-outlined text-[18px]">query_stats</span><span class="font-body-md text-body-md">Training Analytics</span></a>
            </nav>
            <nav class="flex flex-col gap-space-xs" data-active-classes="bg-primary-container text-on-primary font-semibold shadow-sm">
                <div class="px-space-sm py-1 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-widest">Training Management</div><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="tickets-and-scenarios" href="TicketsAndScenarios.php"><span class="material-symbols-outlined text-[18px]">tune</span><span class="font-body-md text-body-md">Tickets & Scenarios</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="dataset-management" href="DatasetManagement.php"><span class="material-symbols-outlined text-[18px]">database</span><span class="font-body-md text-body-md">Dataset Management</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="students-and-cohorts" href="TicketsAndScenarios.php"><span class="material-symbols-outlined text-[18px]">group</span><span class="font-body-md text-body-md">Students & Cohorts</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="submission-reviews" href="TicketsAndScenarios.php"><span class="material-symbols-outlined text-[18px]">fact_check</span><span class="font-body-md text-body-md">Submission Reviews</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="grading-and-feedback" href="TicketsAndScenarios.php"><span class="material-symbols-outlined text-[18px]">rate_review</span><span class="font-body-md text-body-md">Grading & Feedback</span></a>
            </nav>
            <nav class="flex flex-col gap-space-xs" data-active-classes="bg-primary-container text-on-primary font-semibold shadow-sm">
                <div class="px-space-sm py-1 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-widest">Platform Administration</div><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="subsystem-control" href="WorkspaceConfiguration.php"><span class="material-symbols-outlined text-[18px]">memory</span><span class="font-body-md text-body-md">Subsystem Control</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="workspace-configuration" href="WorkspaceConfiguration.php"><span class="material-symbols-outlined text-[18px]">settings_input_component</span><span class="font-body-md text-body-md">Workspace Configuration</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="users-and-permissions" href="WorkspaceConfiguration.php"><span class="material-symbols-outlined text-[18px]">admin_panel_settings</span><span class="font-body-md text-body-md">Users & Permissions</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="audit-logs" href="OperationsDashboard.php"><span class="material-symbols-outlined text-[18px]">receipt_long</span><span class="font-body-md text-body-md">Audit Logs</span></a>
            </nav>
            <nav class="flex flex-col gap-space-xs" data-active-classes="bg-primary-container text-on-primary font-semibold shadow-sm">
                <div class="px-space-sm py-1 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-widest">AI Operations</div><a aria-current="page" class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg transition-colors bg-primary-container text-on-primary font-semibold shadow-sm" data-path="operations-dashboard" href="OperationsDashboard.php"><span class="material-symbols-outlined text-[18px]">hub</span><span class="font-body-md text-body-md">Operations Dashboard</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="model-monitoring" href="OperationsDashboard.php"><span class="material-symbols-outlined text-[18px]">monitoring</span><span class="font-body-md text-body-md">Model Monitoring</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="alerts-and-incidents" href="OperationsDashboard.php"><span class="material-symbols-outlined text-[18px]">warning</span><span class="font-body-md text-body-md">Alerts & Incidents</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="deployment-history" href="OperationsDashboard.php"><span class="material-symbols-outlined text-[18px]">history</span><span class="font-body-md text-body-md">Deployment History</span></a>
            </nav>
        </div>
    </aside>
    <div class="pl-72">
        <main class="relative pt-16 min-h-screen px-margin-desktop py-margin">
            <div class="w-full">
                <div class="flex flex-col w-full gap-space-lg">
                    <!-- Operational Telemetry Header & Subsystem Synchronizer -->
                    <section class="flex flex-col gap-space-md">
                        <!-- Top-level Status & Synchronizer Bar -->
                        <div class="flex flex-wrap items-center justify-between gap-space-md bg-surface-container-lowest p-space-md rounded-xl shadow-sm">
                            <div class="flex items-center gap-space-md">
                                <div class="flex items-center gap-space-xs px-space-sm py-1 rounded bg-secondary-container text-primary font-label-md text-label-md">
                                    <span class="w-2 h-2 rounded-full bg-primary animate-ping"></span>
                                    <span>SYS-AI-05 :: AI SOC REALTIME DISPATCH</span>
                                </div>
                                <div class="h-4 w-px bg-surface-container-highest hidden md:block"></div>
                                <div class="flex items-center gap-space-xs font-label-sm text-label-sm text-on-surface-variant">
                                    <span class="material-symbols-outlined text-[16px]">satellite_alt</span>
                                    <span>UPTIME MATRIX: 99.982%</span>
                                </div>
                                <div class="hidden lg:flex items-center gap-space-xs font-label-sm text-label-sm text-tertiary">
                                    <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
                                    <span>SYNC CYCLE: 1200ms JITTER BUFFER</span>
                                </div>
                            </div>
                            <!-- Cross-Subsystem Status Indicators (SYS-AI-01 to 05) -->
                            <div class="flex items-center gap-space-xs flex-wrap">
                                <div class="flex items-center gap-space-xs px-space-sm py-1 rounded bg-surface-container-low text-primary font-label-sm text-label-sm">
                                    <span class="w-2 h-2 rounded-full bg-secondary-container"></span>
                                    <span>SYS-AI-01: OK</span>
                                </div>
                                <div class="flex items-center gap-space-xs px-space-sm py-1 rounded bg-surface-container-low text-primary font-label-sm text-label-sm">
                                    <span class="w-2 h-2 rounded-full bg-secondary-container"></span>
                                    <span>SYS-AI-02: OK</span>
                                </div>
                                <div class="flex items-center gap-space-xs px-space-sm py-1 rounded bg-tertiary-fixed text-on-tertiary-fixed font-label-sm text-label-sm">
                                    <span class="w-2 h-2 rounded-full bg-tertiary animate-pulse"></span>
                                    <span>SYS-AI-03: WARN</span>
                                </div>
                                <div class="flex items-center gap-space-xs px-space-sm py-1 rounded bg-error-container text-error font-label-sm text-label-sm">
                                    <span class="w-2 h-2 rounded-full bg-error animate-ping"></span>
                                    <span>SYS-AI-04: DRIFT</span>
                                </div>
                                <div class="flex items-center gap-space-xs px-space-sm py-1 rounded bg-primary-container text-on-primary font-label-sm text-label-sm">
                                    <span class="w-2 h-2 rounded-full bg-primary-fixed-dim"></span>
                                    <span>SYS-AI-05: ACTIVE NOC</span>
                                </div>
                            </div>
                        </div>
                        <!-- KPI Matrix Bento -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-space-md">
                            <!-- KPI 1 -->
                            <div class="bg-surface-container-lowest p-space-md rounded-xl shadow-sm flex flex-col justify-between">
                                <div class="flex items-center justify-between">
                                    <span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Active Endpoints</span>
                                    <span class="material-symbols-outlined text-primary text-[20px]">hub</span>
                                </div>
                                <div class="flex items-baseline gap-space-xs mt-space-sm">
                                    <span class="font-headline-xl text-headline-xl text-primary leading-none">18</span>
                                    <span class="font-label-md text-label-md text-on-surface-variant">/ 18 online</span>
                                </div>
                                <div class="flex items-center gap-space-xs mt-space-md pt-space-xs bg-surface-container-low px-space-sm py-1 rounded font-label-sm text-label-sm">
                                    <span class="text-secondary font-bold">15 Healthy</span>
                                    <span class="text-on-surface-variant">|</span>
                                    <span class="text-tertiary-container font-semibold">2 Degraded</span>
                                    <span class="text-on-surface-variant">|</span>
                                    <span class="text-error font-semibold">1 Critical</span>
                                </div>
                            </div>
                            <!-- KPI 2 -->
                            <div class="bg-surface-container-lowest p-space-md rounded-xl shadow-sm flex flex-col justify-between">
                                <div class="flex items-center justify-between">
                                    <span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">24h Inferences</span>
                                    <span class="material-symbols-outlined text-secondary text-[20px]">dataset</span>
                                </div>
                                <div class="flex items-baseline gap-space-xs mt-space-sm">
                                    <span class="font-headline-xl text-headline-xl text-on-surface leading-none">3.84M</span>
                                    <span class="font-label-md text-label-md text-primary font-medium">+14.2%</span>
                                </div>
                                <div class="flex items-center justify-between mt-space-md font-label-sm text-label-sm text-on-surface-variant">
                                    <span>Peak: 142 req/s</span>
                                    <span class="text-primary font-medium">Cap: 450 req/s</span>
                                </div>
                            </div>
                            <!-- KPI 3 -->
                            <div class="bg-surface-container-lowest p-space-md rounded-xl shadow-sm flex flex-col justify-between">
                                <div class="flex items-center justify-between">
                                    <span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Mean Latency</span>
                                    <span class="material-symbols-outlined text-primary text-[20px]">speed</span>
                                </div>
                                <div class="flex items-baseline gap-space-xs mt-space-sm">
                                    <span class="font-headline-xl text-headline-xl text-primary leading-none">42.6</span>
                                    <span class="font-body-md text-body-md text-on-surface-variant">ms</span>
                                </div>
                                <div class="flex items-center justify-between mt-space-md font-label-sm text-label-sm text-on-surface-variant">
                                    <span>p50: 28.1ms</span>
                                    <span class="text-tertiary-container font-semibold">p99: 118ms</span>
                                </div>
                            </div>
                            <!-- KPI 4 -->
                            <div class="bg-surface-container-lowest p-space-md rounded-xl shadow-sm flex flex-col justify-between">
                                <div class="flex items-center justify-between">
                                    <span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Global Error Rate</span>
                                    <span class="material-symbols-outlined text-secondary text-[20px]">verified</span>
                                </div>
                                <div class="flex items-baseline gap-space-xs mt-space-sm">
                                    <span class="font-headline-xl text-headline-xl text-primary leading-none">0.04%</span>
                                    <span class="font-label-md text-label-md text-on-surface-variant">SLO < 0.10%</span>
                                </div>
                                <div class="flex items-center gap-space-xs mt-space-md font-label-sm text-label-sm text-on-surface-variant">
                                    <span class="w-2 h-2 rounded-full bg-secondary"></span>
                                    <span>4xx: 0.038%</span>
                                    <span class="w-2 h-2 rounded-full bg-error ml-space-sm"></span>
                                    <span>5xx: 0.002%</span>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- Split Tactical Console Layout (Alert Triage vs Detailed Investigation Panel) -->
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-lg items-start">
                        <!-- Left Rail: Critical Incidents & Alert Triage Feed (Columns 1-5) -->
                        <section class="lg:col-span-5 flex flex-col gap-space-md">
                            <!-- Alert Feed Header -->
                            <div class="flex items-center justify-between bg-surface-container-lowest p-space-md rounded-xl shadow-sm">
                                <div class="flex items-center gap-space-sm">
                                    <span class="material-symbols-outlined text-primary text-[20px]">notifications_active</span>
                                    <div class="flex flex-col">
                                        <h2 class="font-headline-sm text-headline-sm text-primary">Incident Triage Matrix</h2>
                                        <span class="font-label-sm text-label-sm text-on-surface-variant">3 ACTIVE ALERTS DETECTED</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-space-xs">
                                    <button class="px-space-sm py-1 rounded bg-surface-container font-label-sm text-label-sm text-on-surface-variant hover:text-primary transition-colors">Filter</button>
                                    <button class="px-space-sm py-1 rounded bg-secondary-fixed text-on-secondary-fixed font-label-sm text-label-sm hover:bg-secondary-container transition-colors">Export Log</button>
                                </div>
                            </div>
                            <!-- Incident Card 1 (Active Focused: High Severity) -->
                            <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-md flex flex-col gap-space-sm cursor-pointer transition-all hover:bg-surface-container-low" id="incident-card-8921">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-space-xs">
                                        <span class="px-space-sm py-0.5 rounded-full bg-error text-on-error font-label-sm text-label-sm font-bold animate-pulse">CRITICAL DRIFT</span>
                                        <span class="font-label-md text-label-md text-primary font-bold">#INC-8921</span>
                                    </div>
                                    <span class="font-label-sm text-label-sm text-tertiary-container bg-tertiary-fixed px-space-xs py-0.5 rounded">14m ago</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-label-md text-label-md text-on-surface font-semibold truncate">fraud-detection-ensemble-v3.0</span>
                                    <span class="font-body-sm text-body-sm text-on-surface-variant">SYS-AI-04 / Production Tier-1</span>
                                </div>
                                <div class="bg-surface-container p-space-sm rounded font-label-sm text-label-sm flex flex-col gap-space-xs">
                                    <div class="flex justify-between items-center text-error font-semibold">
                                        <span>Metric: PSI (Population Stability Index)</span>
                                        <span>0.28 [Threshold: 0.20]</span>
                                    </div>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant leading-snug">
                                        Data drift on <span class="font-label-sm text-primary font-bold">`transaction_amount`</span> & <span class="font-label-sm text-primary font-bold">`velocity_window_3m`</span>. Significant divergence from baseline.
                                    </p>
                                </div>
                                <div class="flex items-center justify-between pt-space-xs text-on-surface-variant font-label-sm text-label-sm">
                                    <div class="flex items-center gap-space-xs">
                                        <span class="material-symbols-outlined text-[16px] text-primary">person</span>
                                        <span>M. Petrov (Lead Instructor)</span>
                                    </div>
                                    <span class="px-space-sm py-0.5 rounded bg-primary-fixed text-on-primary-fixed font-semibold">UNDER INVESTIGATION</span>
                                </div>
                            </div>
                            <!-- Incident Card 2 (Medium Severity) -->
                            <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm flex flex-col gap-space-sm cursor-pointer transition-all hover:bg-surface-container-low" id="incident-card-8919">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-space-xs">
                                        <span class="px-space-sm py-0.5 rounded-full bg-tertiary-fixed text-on-tertiary-fixed font-label-sm text-label-sm font-bold">WARNING</span>
                                        <span class="font-label-md text-label-md text-primary font-bold">#INC-8919</span>
                                    </div>
                                    <span class="font-label-sm text-label-sm text-tertiary-container bg-tertiary-fixed px-space-xs py-0.5 rounded">1h 04m ago</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-label-md text-label-md text-on-surface font-semibold truncate">churn-xgboost-v2.1</span>
                                    <span class="font-body-sm text-body-sm text-on-surface-variant">SYS-AI-04 / Staging Environment</span>
                                </div>
                                <div class="bg-surface-container-low p-space-sm rounded font-label-sm text-label-sm flex flex-col gap-space-xs">
                                    <div class="flex justify-between items-center text-on-tertiary-container font-semibold">
                                        <span>Metric: p99 Latency</span>
                                        <span>245 ms [Threshold: 150 ms]</span>
                                    </div>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant leading-snug">
                                        Latency spike observed during concurrent cohort test execution. Pod scaling delayed by memory lock.
                                    </p>
                                </div>
                                <div class="flex items-center justify-between pt-space-xs text-on-surface-variant font-label-sm text-label-sm">
                                    <div class="flex items-center gap-space-xs">
                                        <span class="material-symbols-outlined text-[16px] text-secondary">shield_person</span>
                                        <span>Platform Admin</span>
                                    </div>
                                    <span class="px-space-sm py-0.5 rounded bg-secondary-fixed text-on-secondary-fixed font-semibold">ACKNOWLEDGED</span>
                                </div>
                            </div>
                            <!-- Incident Card 3 (Low Severity / Resource Pressure) -->
                            <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm flex flex-col gap-space-sm cursor-pointer transition-all hover:bg-surface-container-low" id="incident-card-8910">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-space-xs">
                                        <span class="px-space-sm py-0.5 rounded-full bg-surface-container-highest text-on-surface-variant font-label-sm text-label-sm font-bold">RESOURCE</span>
                                        <span class="font-label-md text-label-md text-primary font-bold">#INC-8910</span>
                                    </div>
                                    <span class="font-label-sm text-label-sm text-on-surface-variant bg-surface-container px-space-xs py-0.5 rounded">3h 22m ago</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-label-md text-label-md text-on-surface font-semibold truncate">cv-defect-yolo-v1.4</span>
                                    <span class="font-body-sm text-body-sm text-on-surface-variant">SYS-AI-03 / GPU Cluster [gpu-04]</span>
                                </div>
                                <div class="bg-surface-container-low p-space-sm rounded font-label-sm text-label-sm flex flex-col gap-space-xs">
                                    <div class="flex justify-between items-center text-on-surface-variant font-semibold">
                                        <span>Metric: VRAM Saturation</span>
                                        <span>94.1% [Threshold: 90%]</span>
                                    </div>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant leading-snug">
                                        Worker node near OOM. Batch sizing parameter requires instructor intervention.
                                    </p>
                                </div>
                                <div class="flex items-center justify-between pt-space-xs text-on-surface-variant font-label-sm text-label-sm">
                                    <div class="flex items-center gap-space-xs">
                                        <span class="material-symbols-outlined text-[16px] text-outline">memory</span>
                                        <span>Cluster Autoscaler</span>
                                    </div>
                                    <span class="px-space-sm py-0.5 rounded bg-surface-container-highest text-on-surface-variant font-semibold">MONITORING</span>
                                </div>
                            </div>
                            <!-- Historical Incident Activity Mini-Table -->
                            <div class="bg-surface-container-lowest p-space-md rounded-xl shadow-sm flex flex-col gap-space-sm">
                                <span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Resolved in Last 24 Hours</span>
                                <div class="flex flex-col gap-space-xs">
                                    <div class="flex items-center justify-between p-space-xs rounded bg-surface-container-low font-label-sm text-label-sm">
                                        <span class="text-primary font-medium">#INC-8898 (SYS-AI-02)</span>
                                        <span class="text-on-surface-variant">Kafka Queue Desync</span>
                                        <span class="text-primary font-semibold">RESOLVED</span>
                                    </div>
                                    <div class="flex items-center justify-between p-space-xs rounded bg-surface-container-low font-label-sm text-label-sm">
                                        <span class="text-primary font-medium">#INC-8895 (SYS-AI-01)</span>
                                        <span class="text-on-surface-variant">Telemetry Auth Key Roll</span>
                                        <span class="text-primary font-semibold">RESOLVED</span>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <!-- Right Zone: Detailed Incident Investigation Panel (#INC-8921) (Columns 6-12) -->
                        <main class="lg:col-span-7 flex flex-col gap-space-md">
                            <!-- Active Incident Header Console -->
                            <div class="bg-surface-container-lowest p-space-md rounded-xl shadow-md flex flex-col gap-space-md">
                                <div class="flex flex-wrap items-center justify-between gap-space-sm">
                                    <div class="flex items-center gap-space-sm">
                                        <div class="w-10 h-10 rounded-xl bg-error-container text-error flex items-center justify-center font-bold">
                                            <span class="material-symbols-outlined text-[24px]">troubleshoot</span>
                                        </div>
                                        <div class="flex flex-col">
                                            <div class="flex items-center gap-space-xs">
                                                <span class="font-headline-md text-headline-md text-primary font-bold">INVESTIGATION #INC-8921</span>
                                                <span class="px-space-xs py-0.5 rounded bg-secondary-fixed text-primary font-label-sm text-label-sm font-semibold">P1-CRITICAL</span>
                                            </div>
                                            <span class="font-label-sm text-label-sm text-on-surface-variant">TARGET: fraud-detection-ensemble-v3.0 (Canary Rollout)</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-space-xs">
                                        <span class="font-label-sm text-label-sm text-tertiary-container bg-tertiary-fixed px-space-sm py-1 rounded">EST. DRIFT DRIFT START: 04:12 UTC</span>
                                    </div>
                                </div>
                                <!-- Target Endpoint Identity Pill -->
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between bg-surface-container p-space-sm rounded gap-space-xs">
                                    <div class="flex items-center gap-space-xs overflow-hidden">
                                        <span class="material-symbols-outlined text-[16px] text-primary">link</span>
                                        <span class="font-label-sm text-label-sm text-primary font-mono truncate">
                                            https://api.vostokpribor.ai/v1/models/fraud-ensemble/predict
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-space-xs shrink-0 font-label-sm text-label-sm">
                                        <span class="text-on-surface-variant">Worker Tier:</span>
                                        <span class="font-bold text-primary">k8s-gpu-pool-v3 (3 Pods)</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Feature Distribution Drift Comparison (SVG Visualization) -->
                            <div class="bg-surface-container-lowest p-space-md rounded-xl shadow-sm flex flex-col gap-space-md">
                                <div class="flex flex-wrap items-center justify-between gap-space-sm">
                                    <div>
                                        <h3 class="font-headline-sm text-headline-sm text-primary">Population Stability & Feature Drift Density</h3>
                                        <p class="font-body-sm text-body-sm text-on-surface-variant">Comparing Model Training Baseline vs Live Ingestion Streaming Window (24h)</p>
                                    </div>
                                    <div class="flex items-center gap-space-md font-label-sm text-label-sm">
                                        <div class="flex items-center gap-space-xs">
                                            <span class="w-3 h-3 rounded bg-secondary-fixed-dim"></span>
                                            <span>Training Baseline</span>
                                        </div>
                                        <div class="flex items-center gap-space-xs">
                                            <span class="w-3 h-3 rounded bg-primary"></span>
                                            <span>Live Streaming</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- Density Drift Curve Chart (Inline SVG) -->
                                <div class="w-full bg-surface-container-low rounded-lg p-space-md flex flex-col gap-space-sm">
                                    <div class="relative w-full h-48">
                                        <svg class="w-full h-full overflow-visible" preserveaspectratio="none" viewbox="0 0 600 180">
                                            <defs>
                                                <lineargradient id="gradBaseline" x1="0%" x2="0%" y1="0%" y2="100%">
                                                    <stop offset="0%" stop-color="#dbb8ff" stop-opacity="0.5"></stop>
                                                    <stop offset="100%" stop-color="#dbb8ff" stop-opacity="0.0"></stop>
                                                </lineargradient>
                                                <lineargradient id="gradLive" x1="0%" x2="0%" y1="0%" y2="100%">
                                                    <stop offset="0%" stop-color="#4c1d95" stop-opacity="0.6"></stop>
                                                    <stop offset="100%" stop-color="#4c1d95" stop-opacity="0.05"></stop>
                                                </lineargradient>
                                            </defs>
                                            <!-- Grid horizontal ticks -->
                                            <line stroke="#ccc3d4" stroke-dasharray="4 4" stroke-opacity="0.4" x1="0" x2="600" y1="30" y2="30"></line>
                                            <line stroke="#ccc3d4" stroke-dasharray="4 4" stroke-opacity="0.4" x1="0" x2="600" y1="80" y2="80"></line>
                                            <line stroke="#ccc3d4" stroke-dasharray="4 4" stroke-opacity="0.4" x1="0" x2="600" y1="130" y2="130"></line>
                                            <line stroke="#7b7483" stroke-width="1" x1="0" x2="600" y1="170" y2="170"></line>
                                            <!-- Baseline Distribution Area (Normal Bell-Curve) -->
                                            <path d="M 0,170 C 120,170 180,35 300,35 C 420,35 480,170 600,170 Z" fill="url(#gradBaseline)"></path>
                                            <path d="M 0,170 C 120,170 180,35 300,35 C 420,35 480,170 600,170" fill="none" stroke="#6f5092" stroke-dasharray="3 3" stroke-width="2"></path>
                                            <!-- Live Streaming Distribution Area (Shifted / Heavy Right-Tail Drift) -->
                                            <path d="M 0,170 C 100,170 190,120 300,110 C 400,95 460,20 540,20 C 580,20 590,140 600,170 Z" fill="url(#gradLive)"></path>
                                            <path d="M 0,170 C 100,170 190,120 300,110 C 400,95 460,20 540,20 C 580,20 590,140 600,170" fill="none" stroke="#4c1d95" stroke-width="2.5"></path>
                                            <!-- Drift Annotation Marker at anomaly peak -->
                                            <circle cx="540" cy="20" fill="#ba1a1a" r="5"></circle>
                                            <line stroke="#ba1a1a" stroke-dasharray="2 2" stroke-width="1.5" x1="540" x2="540" y1="20" y2="170"></line>
                                        </svg>
                                    </div>
                                    <!-- Bottom Axis Metrics -->
                                    <div class="flex justify-between items-center font-label-sm text-label-sm text-on-surface-variant pt-space-xs">
                                        <span>$0.00 (Min)</span>
                                        <span>$250.00</span>
                                        <span>$500.00 (Expected Baseline Mean)</span>
                                        <span>$1,200.00</span>
                                        <span class="text-error font-bold">$2,500.00+ (Drift Cluster)</span>
                                    </div>
                                </div>
                                <!-- Drift Breakdown Matrix by Feature -->
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-space-sm font-label-sm text-label-sm">
                                    <div class="bg-surface-container p-space-sm rounded flex flex-col gap-space-xs">
                                        <span class="text-on-surface-variant">Feature: `transaction_amount`</span>
                                        <span class="font-headline-sm text-headline-sm text-error">PSI: 0.28</span>
                                        <span class="text-error font-medium">Critical Drift (>0.20)</span>
                                    </div>
                                    <div class="bg-surface-container p-space-sm rounded flex flex-col gap-space-xs">
                                        <span class="text-on-surface-variant">Feature: `geo_ip_distance_km`</span>
                                        <span class="font-headline-sm text-headline-sm text-tertiary-container">PSI: 0.14</span>
                                        <span class="text-tertiary-container font-medium">Moderate Shift (0.10 - 0.20)</span>
                                    </div>
                                    <div class="bg-surface-container p-space-sm rounded flex flex-col gap-space-xs">
                                        <span class="text-on-surface-variant">Feature: `device_risk_score`</span>
                                        <span class="font-headline-sm text-headline-sm text-primary">PSI: 0.03</span>
                                        <span class="text-secondary font-medium">In Stable Bounds (<0.10)< /span>
                                    </div>
                                </div>
                            </div>
                            <!-- Canary Audit Trail & Recent Deployment Changes -->
                            <div class="bg-surface-container-lowest p-space-md rounded-xl shadow-sm flex flex-col gap-space-md">
                                <div class="flex items-center justify-between">
                                    <h3 class="font-headline-sm text-headline-sm text-primary">Deployment Lineage & Audit Trail</h3>
                                    <span class="font-label-sm text-label-sm text-on-surface-variant">CANARY RELEASE: 10% TRAFFIC SPLIT</span>
                                </div>
                                <div class="flex flex-col gap-space-sm">
                                    <!-- Event 1: Recent Rollout -->
                                    <div class="flex items-start gap-space-sm p-space-sm rounded bg-surface-container-low">
                                        <div class="w-8 h-8 rounded-full bg-secondary-fixed text-primary flex items-center justify-center shrink-0">
                                            <span class="material-symbols-outlined text-[18px]">publish</span>
                                        </div>
                                        <div class="flex flex-col flex-1">
                                            <div class="flex items-center justify-between">
                                                <span class="font-label-md text-label-md text-primary font-bold">Canary Model v3.0 Rolled Out</span>
                                                <span class="font-label-sm text-label-sm text-on-surface-variant">6 hours ago</span>
                                            </div>
                                            <span class="font-body-sm text-body-sm text-on-surface-variant">
                                                Candidate model committed by <span class="font-bold text-on-surface">Student Cohort 2025-A (Team Cyber-Defense)</span> via SYS-AI-04 Pipeline #981.
                                            </span>
                                        </div>
                                    </div>
                                    <!-- Event 2: Safe Fallback Point -->
                                    <div class="flex items-start gap-space-sm p-space-sm rounded bg-surface-container-low">
                                        <div class="w-8 h-8 rounded-full bg-primary-fixed text-on-primary-fixed flex items-center justify-center shrink-0">
                                            <span class="material-symbols-outlined text-[18px]">history</span>
                                        </div>
                                        <div class="flex flex-col flex-1">
                                            <div class="flex items-center justify-between">
                                                <span class="font-label-md text-label-md text-primary font-bold">Last Certified Stable Checkpoint: v2.9</span>
                                                <span class="font-label-sm text-label-sm text-secondary font-semibold">VALIDATED GOLDEN BUILD</span>
                                            </div>
                                            <span class="font-body-sm text-body-sm text-on-surface-variant">
                                                Passing all stress tests: AUC 0.984, F1 0.961, Inference latency 28ms under 250 rps. Rollback ready.
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Tactical Action Bar (Interactive Workflow) -->
                            <div class="bg-surface-container-lowest p-space-md rounded-xl shadow-md flex flex-col gap-space-md">
                                <div class="flex items-center justify-between">
                                    <h3 class="font-headline-sm text-headline-sm text-primary">Operational Incident Actions</h3>
                                    <span class="font-label-sm text-label-sm text-error font-mono">ACTION REQUIRES INSTRUCTOR AUTHORIZATION</span>
                                </div>
                                <div class="flex flex-wrap gap-space-sm items-center">
                                    <button class="px-space-md py-2 rounded bg-secondary-fixed text-primary font-label-md text-label-md font-semibold hover:bg-secondary-fixed-dim transition-colors flex items-center gap-space-xs" id="btn-ack">
                                        <span class="material-symbols-outlined text-[16px]">done_all</span>
                                        <span>Acknowledge Alert</span>
                                    </button>
                                    <button class="px-space-md py-2 rounded bg-surface-container-low text-primary font-label-md text-label-md font-semibold hover:bg-surface-container transition-colors flex items-center gap-space-xs" id="btn-assign">
                                        <span class="material-symbols-outlined text-[16px]">person_add</span>
                                        <span>Assign Responder</span>
                                    </button>
                                    <button class="px-space-md py-2 rounded bg-tertiary-fixed text-on-tertiary-fixed font-label-md text-label-md font-semibold hover:bg-tertiary-fixed-dim transition-colors flex items-center gap-space-xs" id="btn-retrain">
                                        <span class="material-symbols-outlined text-[16px]">model_training</span>
                                        <span>Trigger Retraining Simulation</span>
                                    </button>
                                    <!-- Safe Rollback Action (High Visibility) -->
                                    <button class="px-space-md py-2 rounded bg-error text-on-error font-label-md text-label-md font-bold hover:bg-error-container hover:text-on-error-container transition-colors flex items-center gap-space-xs ml-auto shadow-sm" id="btn-rollback">
                                        <span class="material-symbols-outlined text-[16px]">restore</span>
                                        <span>Rollback to v2.9 (Confirm Required)</span>
                                    </button>
                                </div>
                                <!-- Inline Rollback Modal/Confirmation Banner (Hidden by default, triggered via JS) -->
                                <div class="hidden flex-col gap-space-sm p-space-md rounded-lg bg-error-container text-on-error-container" id="rollback-confirm-panel">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-space-xs font-headline-sm text-headline-sm">
                                            <span class="material-symbols-outlined">warning</span>
                                            <span>Confirm Rollback to v2.9?</span>
                                        </div>
                                        <span class="font-label-sm text-label-sm font-mono">TRAFFIC REDIRECTION: IMMEDIATE</span>
                                    </div>
                                    <p class="font-body-sm text-body-sm">
                                        This will drain live canary traffic from <code class="font-mono font-bold">fraud-detection-ensemble-v3.0</code> and revert 100% of prediction traffic to golden container <code class="font-mono font-bold">v2.9</code>. Active user sessions will not be interrupted.
                                    </p>
                                    <div class="flex items-center gap-space-sm pt-space-xs">
                                        <button class="px-space-md py-1.5 rounded bg-error text-on-error font-label-md text-label-md font-bold hover:opacity-90" id="confirm-execute-rollback">
                                            Confirm & Execute Reversion
                                        </button>
                                        <button class="px-space-md py-1.5 rounded bg-surface-container text-on-surface font-label-md text-label-md hover:bg-surface-container-highest" id="cancel-rollback">
                                            Abort
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- Investigation Log & Root-Cause Notes Editor -->
                            <div class="bg-surface-container-lowest p-space-md rounded-xl shadow-sm flex flex-col gap-space-md">
                                <div class="flex items-center justify-between">
                                    <h3 class="font-headline-sm text-headline-sm text-primary">Live Investigation Log & Root-Cause Analysis</h3>
                                    <span class="font-label-sm text-label-sm text-on-surface-variant">AUTO-SAVING AUDIT SESSION</span>
                                </div>
                                <div class="flex flex-col gap-space-sm">
                                    <!-- Log Entries -->
                                    <div class="flex flex-col gap-space-xs font-label-sm text-label-sm bg-surface-container-low p-space-sm rounded">
                                        <div class="flex items-center justify-between text-on-surface-variant">
                                            <span>[14:48:12 UTC] Lead Instructor M. Petrov:</span>
                                            <span class="text-tertiary-container font-mono">ENTRY #1</span>
                                        </div>
                                        <p class="font-body-sm text-body-sm text-on-surface">
                                            Observed heavy transaction volume anomaly originating from synthetic payment test harness in cohort partition. Feature distribution shift confirms synthetic amounts exceed $2,500 threshold with 4.8x normal frequency.
                                        </p>
                                    </div>
                                    <div class="flex flex-col gap-space-xs font-label-sm text-label-sm bg-surface-container-low p-space-sm rounded">
                                        <div class="flex items-center justify-between text-on-surface-variant">
                                            <span>[14:52:40 UTC] Automated Anomaly Engine:</span>
                                            <span class="text-tertiary-container font-mono">SYS-NOTE</span>
                                        </div>
                                        <p class="font-body-sm text-body-sm text-on-surface">
                                            Canary confidence score degraded by 11.4%. False positive rate elevated from baseline 0.8% to 3.2%. Recommendation: Revert canary or isolate cohort test stream.
                                        </p>
                                    </div>
                                    <!-- Add Note Input Area -->
                                    <div class="flex flex-col gap-space-xs mt-space-xs">
                                        <label class="font-label-sm text-label-sm text-on-surface-variant" for="investigation-notes">Append Operator Investigation Note</label>
                                        <textarea class="w-full bg-surface-container-low p-space-sm rounded font-body-sm text-body-sm text-primary focus:outline-none focus:ring-2 focus:ring-primary" id="investigation-notes" placeholder="Enter findings, root-cause notes, or mitigation steps for the audit record..." rows="3"></textarea>
                                        <div class="flex justify-end gap-space-sm mt-space-xs">
                                            <button class="px-space-md py-1.5 rounded bg-primary text-on-primary font-label-md text-label-md font-semibold hover:bg-on-primary-fixed-variant transition-colors flex items-center gap-space-xs" id="post-note-btn">
                                                <span class="material-symbols-outlined text-[16px]">edit_note</span>
                                                <span>Commit Audit Note</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </main>
                    </div>
                </div>
                <script src="js/main.js"></script>
            </div>
        </main>
    </div>
</body>

</html>