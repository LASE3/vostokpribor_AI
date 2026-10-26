<?php
// VOSTOKPRIBOR AI • SYS-AI-05: AI Operations Center (AI SOC) - Fleet Wall Dashboard
require_once __DIR__ . '/../app/bootstrap.php';

use App\Middleware\AuthorizationMiddleware;
use App\Core\Database;
use App\Core\Auth;

AuthorizationMiddleware::requireAdmin();
$currentUser = Auth::user();
$db = Database::getInstance();

$auditLogs = $db->fetchAll("SELECT * FROM audit_logs ORDER BY created_at DESC LIMIT 20");
$activeJobs = $db->fetchAll("SELECT * FROM execution_jobs WHERE status IN ('QUEUED', 'RUNNING') ORDER BY created_at ASC");
$totalCadets = (int)$db->fetchValue("SELECT COUNT(*) FROM users WHERE role = 'STUDENT'");
$activeCadets = (int)$db->fetchValue("SELECT COUNT(*) FROM users WHERE role = 'STUDENT' AND status = 'ACTIVE'");
$totalScenarios = (int)$db->fetchValue("SELECT COUNT(*) FROM scenarios");
$totalTickets = (int)$db->fetchValue("SELECT COUNT(*) FROM tickets");
$pendingReviews = (int)$db->fetchValue("SELECT COUNT(*) FROM submissions WHERE status IN ('SUBMITTED', 'UNDER_REVIEW')");
$totalModels = (int)$db->fetchValue("SELECT COUNT(*) FROM models");
$deployedModels = (int)$db->fetchValue("SELECT COUNT(*) FROM model_deployments WHERE status = 'DEPLOYED'");
$openIncidents = (int)$db->fetchValue("SELECT COUNT(*) FROM execution_jobs WHERE status = 'FAILED'");
$totalDatasets = (int)$db->fetchValue("SELECT COUNT(*) FROM datasets");

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
                <div class="px-space-sm py-1 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-widest">Overview</div><a aria-current="page" class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg transition-colors bg-primary-container text-on-primary font-semibold shadow-sm" data-path="main-dashboard" href="Dashboard.php"><span class="material-symbols-outlined text-[18px]">space_dashboard</span><span class="font-body-md text-body-md">Main Dashboard</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="training-analytics" href="OperationsDashboard.php"><span class="material-symbols-outlined text-[18px]">query_stats</span><span class="font-body-md text-body-md">Training Analytics</span></a>
            </nav>
            <nav class="flex flex-col gap-space-xs" data-active-classes="bg-primary-container text-on-primary font-semibold shadow-sm">
                <div class="px-space-sm py-1 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-widest">Training Management</div><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="tickets-and-scenarios" href="TicketsAndScenarios.php"><span class="material-symbols-outlined text-[18px]">tune</span><span class="font-body-md text-body-md">Tickets & Scenarios</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="dataset-management" href="DatasetManagement.php"><span class="material-symbols-outlined text-[18px]">database</span><span class="font-body-md text-body-md">Dataset Management</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="students-and-cohorts" href="TicketsAndScenarios.php"><span class="material-symbols-outlined text-[18px]">group</span><span class="font-body-md text-body-md">Students & Cohorts</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="submission-reviews" href="TicketsAndScenarios.php"><span class="material-symbols-outlined text-[18px]">fact_check</span><span class="font-body-md text-body-md">Submission Reviews</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="grading-and-feedback" href="TicketsAndScenarios.php"><span class="material-symbols-outlined text-[18px]">rate_review</span><span class="font-body-md text-body-md">Grading & Feedback</span></a>
            </nav>
            <nav class="flex flex-col gap-space-xs" data-active-classes="bg-primary-container text-on-primary font-semibold shadow-sm">
                <div class="px-space-sm py-1 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-widest">Platform Administration</div><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="subsystem-control" href="WorkspaceConfiguration.php"><span class="material-symbols-outlined text-[18px]">memory</span><span class="font-body-md text-body-md">Subsystem Control</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="workspace-configuration" href="WorkspaceConfiguration.php"><span class="material-symbols-outlined text-[18px]">settings_input_component</span><span class="font-body-md text-body-md">Workspace Configuration</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="users-and-permissions" href="WorkspaceConfiguration.php"><span class="material-symbols-outlined text-[18px]">admin_panel_settings</span><span class="font-body-md text-body-md">Users & Permissions</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="audit-logs" href="OperationsDashboard.php"><span class="material-symbols-outlined text-[18px]">receipt_long</span><span class="font-body-md text-body-md">Audit Logs</span></a>
            </nav>
            <nav class="flex flex-col gap-space-xs" data-active-classes="bg-primary-container text-on-primary font-semibold shadow-sm">
                <div class="px-space-sm py-1 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-widest">AI Operations</div><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="operations-dashboard" href="OperationsDashboard.php"><span class="material-symbols-outlined text-[18px]">hub</span><span class="font-body-md text-body-md">Operations Dashboard</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="model-monitoring" href="OperationsDashboard.php"><span class="material-symbols-outlined text-[18px]">monitoring</span><span class="font-body-md text-body-md">Model Monitoring</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="alerts-and-incidents" href="OperationsDashboard.php"><span class="material-symbols-outlined text-[18px]">warning</span><span class="font-body-md text-body-md">Alerts & Incidents</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="deployment-history" href="OperationsDashboard.php"><span class="material-symbols-outlined text-[18px]">history</span><span class="font-body-md text-body-md">Deployment History</span></a>
            </nav>
        </div>
    </aside>
    <div class="pl-72">
        <main class="relative pt-16 min-h-screen px-margin-desktop py-margin">
            <div class="w-full">
                <div class="flex flex-col w-full gap-space-lg">
                    <!-- TOP TACTICAL STRIP: Live System Status & Action Commands -->
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-space-md p-space-md bg-surface-container-lowest shadow-sm rounded-xl">
                        <div class="flex flex-wrap items-center gap-space-md">
                            <div class="flex items-center gap-space-xs bg-primary text-on-primary px-space-sm py-1 rounded">
                                <span class="w-2 h-2 rounded-full bg-tertiary-fixed animate-ping"></span>
                                <span class="font-label-sm text-label-sm uppercase tracking-wider">RANGE OPERATIONAL</span>
                            </div>
                            <div class="flex items-center gap-space-xs text-on-surface-variant font-label-md text-label-md">
                                <span class="text-primary font-bold">NODE:</span>
                                <span>VP-CLUSTER-ALPHA-05</span>
                                <span class="text-outline-variant">/</span>
                                <span class="text-primary font-bold">TELEMETRY CYCLE:</span>
                                <span class="font-label-lg text-primary" id="cycle-timer">10s</span>
                            </div>
                            <div class="hidden sm:flex items-center gap-space-xs bg-surface-container-low px-space-sm py-1 rounded text-on-surface-variant font-label-sm text-label-sm">
                                <span class="material-symbols-outlined text-[14px] text-tertiary">verified_user</span>
                                <span>DEFENSE INDUSTRIAL SPEC 880-B</span>
                            </div>
                        </div>
                        <!-- Quick Action Toolbar -->
                        <div class="flex flex-wrap items-center gap-space-sm">
                            <button class="flex items-center gap-space-xs px-space-md py-1.5 bg-primary text-on-primary font-label-md text-label-md rounded shadow-sm hover:opacity-95 transition-all" onclick="toggleModal('modal-ticket')">
                                <span class="material-symbols-outlined text-[16px]">add_circle</span>
                                <span>+ Create Ticket / Scenario</span>
                            </button>
                            <button class="flex items-center gap-space-xs px-space-sm py-1.5 bg-secondary-container text-primary font-label-md text-label-md rounded hover:bg-secondary-fixed transition-colors">
                                <span class="material-symbols-outlined text-[16px]">upload_file</span>
                                <span>Publish Dataset</span>
                            </button>
                            <button class="flex items-center gap-space-xs px-space-sm py-1.5 bg-surface-container-low text-primary font-label-md text-label-md rounded hover:bg-surface-container transition-colors">
                                <span class="material-symbols-outlined text-[16px]">group_add</span>
                                <span>Assign Cohort</span>
                            </button>
                            <button class="relative flex items-center gap-space-xs px-space-sm py-1.5 bg-tertiary-fixed text-on-tertiary-fixed font-label-md text-label-md rounded hover:opacity-90 transition-opacity" onclick="switchTab('reviews')">
                                <span class="material-symbols-outlined text-[16px]">assignment_turned_in</span>
                                <span>Review Submissions</span>
                                <span class="px-1.5 py-0.2 bg-primary text-on-primary rounded-full font-label-sm text-label-sm"><?= $pendingReviews ?></span>
                            </button>
                            <a class="flex items-center gap-space-xs px-space-sm py-1.5 bg-primary-container text-on-primary font-label-md text-label-md rounded hover:opacity-90 transition-opacity" href="#soc-anchor">
                                <span class="material-symbols-outlined text-[16px]">security</span>
                                <span>Open AI SOC</span>
                            </a>
                        </div>
                    </div>
                    <!-- SECTION 1: EXECUTIVE METRIC SUMMARY BENTO GRID -->
                    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-space-md">
                        <!-- Metric 1: Students -->
                        <div class="flex flex-col justify-between p-space-md bg-surface-container-lowest rounded-xl shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
                            <div class="flex items-center justify-between text-on-surface-variant">
                                <span class="font-label-sm text-label-sm uppercase tracking-wider">Total Cadets</span>
                                <span class="material-symbols-outlined text-[20px] text-primary">groups</span>
                            </div>
                            <div class="my-space-sm">
                                <div class="font-headline-xl text-headline-xl text-primary leading-none"><?= $totalCadets ?></div>
                                <div class="font-label-sm text-label-sm text-on-surface-variant mt-1">4 Active Cohorts</div>
                            </div>
                            <div class="flex items-center gap-1 font-label-sm text-label-sm text-secondary">
                                <span class="material-symbols-outlined text-[14px]">trending_up</span>
                                <span>+12 this quarter</span>
                            </div>
                            <div class="absolute -right-2 -bottom-2 w-12 h-12 bg-secondary-fixed/30 rounded-full blur-sm group-hover:scale-125 transition-transform"></div>
                        </div>
                        <!-- Metric 2: Active Scenarios -->
                        <div class="flex flex-col justify-between p-space-md bg-surface-container-lowest rounded-xl shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
                            <div class="flex items-center justify-between text-on-surface-variant">
                                <span class="font-label-sm text-label-sm uppercase tracking-wider">Blueprints</span>
                                <span class="material-symbols-outlined text-[20px] text-tertiary">account_tree</span>
                            </div>
                            <div class="my-space-sm">
                                <div class="font-headline-xl text-headline-xl text-primary leading-none"><?= $totalScenarios ?></div>
                                <div class="font-label-sm text-label-sm text-on-surface-variant mt-1">Official Scenarios</div>
                            </div>
                            <div class="flex items-center gap-1 font-label-sm text-label-sm text-on-surface-variant">
                                <span class="inline-block w-2 h-2 rounded-full bg-secondary-container"></span>
                                <span>100% Validated</span>
                            </div>
                        </div>
                        <!-- Metric 3: Published Tickets -->
                        <div class="flex flex-col justify-between p-space-md bg-surface-container-lowest rounded-xl shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
                            <div class="flex items-center justify-between text-on-surface-variant">
                                <span class="font-label-sm text-label-sm uppercase tracking-wider">Live Tickets</span>
                                <span class="material-symbols-outlined text-[20px] text-primary">confirmation_number</span>
                            </div>
                            <div class="my-space-sm">
                                <div class="font-headline-xl text-headline-xl text-primary leading-none"><?= $totalTickets ?></div>
                                <div class="font-label-sm text-label-sm text-on-surface-variant mt-1">Engineering Tasks</div>
                            </div>
                            <div class="flex items-center gap-1 font-label-sm text-label-sm text-on-surface-variant">
                                <span>6 Milestone tasks</span>
                            </div>
                        </div>
                        <!-- Metric 4: Pending Reviews -->
                        <div class="flex flex-col justify-between p-space-md bg-secondary-container/40 rounded-xl shadow-sm hover:shadow-md transition-shadow relative overflow-hidden">
                            <div class="flex items-center justify-between text-primary">
                                <span class="font-label-sm text-label-sm uppercase tracking-wider font-bold">Pending Reviews</span>
                                <span class="material-symbols-outlined text-[20px]">pending_actions</span>
                            </div>
                            <div class="my-space-sm">
                                <div class="font-headline-xl text-headline-xl text-primary leading-none"><?= $pendingReviews ?></div>
                                <div class="font-label-sm text-label-sm text-on-surface-variant mt-1">Awaiting Rubric</div>
                            </div>
                            <div class="flex items-center gap-1 font-label-sm text-label-sm text-error">
                                <span class="material-symbols-outlined text-[14px]">schedule</span>
                                <span>4 exceed 24h SLA</span>
                            </div>
                        </div>
                        <!-- Metric 5: Active Models -->
                        <div class="flex flex-col justify-between p-space-md bg-surface-container-lowest rounded-xl shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
                            <div class="flex items-center justify-between text-on-surface-variant">
                                <span class="font-label-sm text-label-sm uppercase tracking-wider">Endpoints</span>
                                <span class="material-symbols-outlined text-[20px] text-primary">memory</span>
                            </div>
                            <div class="my-space-sm">
                                <div class="font-headline-xl text-headline-xl text-primary leading-none"><?= $deployedModels ?></div>
                                <div class="font-label-sm text-label-sm text-on-surface-variant mt-1">Deployed Models</div>
                            </div>
                            <div class="flex items-center gap-1 font-label-sm text-label-sm text-secondary">
                                <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
                                <span>2 Canary routing</span>
                            </div>
                        </div>
                        <!-- Metric 6: Open Incidents -->
                        <div class="flex flex-col justify-between p-space-md bg-surface-container-lowest rounded-xl shadow-sm hover:shadow-md transition-shadow relative overflow-hidden">
                            <div class="flex items-center justify-between text-error">
                                <span class="font-label-sm text-label-sm uppercase tracking-wider font-bold">Open Incidents</span>
                                <span class="material-symbols-outlined text-[20px] text-error animate-pulse">crisis_alert</span>
                            </div>
                            <div class="my-space-sm">
                                <div class="font-headline-xl text-headline-xl text-error leading-none"><?= $openIncidents ?></div>
                                <div class="font-label-sm text-label-sm text-on-surface-variant mt-1">1 Critical Drift, 1 Latency</div>
                            </div>
                            <div class="flex items-center gap-1 font-label-sm text-label-sm text-on-surface-variant">
                                <span>SOC auto-contain active</span>
                            </div>
                            <div class="absolute top-0 right-0 w-1.5 h-full bg-error"></div>
                        </div>
                    </div>
                    <!-- SECTION 2: SUBSYSTEM HEALTH MATRIX (SYS-AI-01 through SYS-AI-05) -->
                    <div class="flex flex-col p-space-md bg-surface-container-lowest rounded-xl shadow-sm gap-space-md">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-space-xs">
                            <div class="flex items-center gap-space-sm">
                                <span class="material-symbols-outlined text-primary text-[22px]">developer_board</span>
                                <div>
                                    <h2 class="font-headline-sm text-headline-sm text-primary uppercase tracking-tight">Integrated Subsystem Fabric (5/5)</h2>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant">Real-time status across orchestration, storage, compute, registry, and threat analytics.</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-space-sm font-label-sm text-label-sm">
                                <span class="flex items-center gap-1 text-primary"><span class="w-2 h-2 rounded-full bg-primary-container"></span> All Systems Nominal</span>
                                <span class="text-outline-variant">|</span>
                                <span class="text-on-surface-variant">Total Clusters: 6 Nodes</span>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-5 gap-space-sm">
                            <!-- Subsystem 1 -->
                            <div class="flex flex-col p-space-sm bg-surface-container-low rounded-lg gap-space-xs hover:bg-secondary-fixed/20 transition-colors">
                                <div class="flex items-center justify-between">
                                    <span class="font-label-sm text-label-sm px-1.5 py-0.5 bg-secondary-container text-primary rounded font-bold">SYS-AI-01</span>
                                    <span class="w-2 h-2 rounded-full bg-secondary-container"></span>
                                </div>
                                <div class="font-headline-sm text-[13px] leading-tight text-primary font-bold">Tickets & Scenarios</div>
                                <div class="font-body-sm text-body-sm text-on-surface-variant">Orchestrator v3.4</div>
                                <div class="mt-auto pt-2 flex flex-col gap-0.5 font-label-sm text-label-sm text-on-surface-variant">
                                    <div class="flex justify-between"><span>Uptime</span><span class="text-primary font-semibold">HOST ONLINE</span></div>
                                    <div class="flex justify-between"><span>Latency</span><span>42 ms</span></div>
                                </div>
                            </div>
                            <!-- Subsystem 2 -->
                            <div class="flex flex-col p-space-sm bg-surface-container-low rounded-lg gap-space-xs hover:bg-secondary-fixed/20 transition-colors">
                                <div class="flex items-center justify-between">
                                    <span class="font-label-sm text-label-sm px-1.5 py-0.5 bg-secondary-container text-primary rounded font-bold">SYS-AI-02</span>
                                    <span class="w-2 h-2 rounded-full bg-secondary-container"></span>
                                </div>
                                <div class="font-headline-sm text-[13px] leading-tight text-primary font-bold">Dataset Portal</div>
                                <div class="font-body-sm text-body-sm text-on-surface-variant">Lakehouse S3-Compat</div>
                                <div class="mt-auto pt-2 flex flex-col gap-0.5 font-label-sm text-label-sm text-on-surface-variant">
                                    <div class="flex justify-between"><span>Capacity</span><span class="text-primary font-semibold">14.2 / 50 TB</span></div>
                                    <div class="flex justify-between"><span>Ingest Rate</span><span>142 MB/s</span></div>
                                </div>
                            </div>
                            <!-- Subsystem 3 -->
                            <div class="flex flex-col p-space-sm bg-surface-container-low rounded-lg gap-space-xs hover:bg-secondary-fixed/20 transition-colors">
                                <div class="flex items-center justify-between">
                                    <span class="font-label-sm text-label-sm px-1.5 py-0.5 bg-secondary-container text-primary rounded font-bold">SYS-AI-03</span>
                                    <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                                </div>
                                <div class="font-headline-sm text-[13px] leading-tight text-primary font-bold">AI/ML Workbench</div>
                                <div class="font-body-sm text-body-sm text-on-surface-variant">GPU Compute Fabric</div>
                                <div class="mt-auto pt-2 flex flex-col gap-0.5 font-label-sm text-label-sm text-on-surface-variant">
                                    <div class="flex justify-between"><span>Sessions</span><span class="text-primary font-semibold">32 Active</span></div>
                                    <div class="flex justify-between"><span>A100 Load</span><span class="text-primary font-semibold">78%</span></div>
                                </div>
                            </div>
                            <!-- Subsystem 4 -->
                            <div class="flex flex-col p-space-sm bg-surface-container-low rounded-lg gap-space-xs hover:bg-secondary-fixed/20 transition-colors">
                                <div class="flex items-center justify-between">
                                    <span class="font-label-sm text-label-sm px-1.5 py-0.5 bg-secondary-container text-primary rounded font-bold">SYS-AI-04</span>
                                    <span class="w-2 h-2 rounded-full bg-secondary-container"></span>
                                </div>
                                <div class="font-headline-sm text-[13px] leading-tight text-primary font-bold">Model Registry</div>
                                <div class="font-body-sm text-body-sm text-on-surface-variant">Triton / TorchServe</div>
                                <div class="mt-auto pt-2 flex flex-col gap-0.5 font-label-sm text-label-sm text-on-surface-variant">
                                    <div class="flex justify-between"><span>Active Serves</span><span class="text-primary font-semibold">18 Models</span></div>
                                    <div class="flex justify-between"><span>Canaries</span><span>2 Testing</span></div>
                                </div>
                            </div>
                            <!-- Subsystem 5 -->
                            <div class="flex flex-col p-space-sm bg-secondary-container/30 rounded-lg gap-space-xs shadow-sm">
                                <div class="flex items-center justify-between">
                                    <span class="font-label-sm text-label-sm px-1.5 py-0.5 bg-primary text-on-primary rounded font-bold">SYS-AI-05</span>
                                    <span class="w-2 h-2 rounded-full bg-error animate-ping"></span>
                                </div>
                                <div class="font-headline-sm text-[13px] leading-tight text-primary font-bold">AI Ops & SOC</div>
                                <div class="font-body-sm text-body-sm text-on-surface-variant">Real-time Watch</div>
                                <div class="mt-auto pt-2 flex flex-col gap-0.5 font-label-sm text-label-sm text-on-surface-variant">
                                    <div class="flex justify-between"><span>Polling Rate</span><span class="text-primary font-semibold">10s Pulse</span></div>
                                    <div class="flex justify-between text-error font-semibold"><span>Active Alerts</span><span>2 Issues</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- SECTION 3: SPLIT PRIORITY QUEUES -->
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-lg">
                        <!-- LEFT: Instructor Action Queue (Submissions, Approvals) -->
                        <div class="lg:col-span-7 flex flex-col gap-space-md p-space-md bg-surface-container-lowest rounded-xl shadow-sm">
                            <div class="flex items-center justify-between pb-space-xs">
                                <div class="flex items-center gap-space-sm">
                                    <span class="material-symbols-outlined text-primary text-[22px]">assignment_late</span>
                                    <div>
                                        <h3 class="font-headline-sm text-headline-sm text-primary uppercase">Instructor Action Queue</h3>
                                        <span class="font-body-sm text-body-sm text-on-surface-variant">14 cadet deliverables demanding grading or verification</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-1 bg-surface-container-low p-1 rounded">
                                    <button class="px-space-sm py-0.5 font-label-sm text-label-sm bg-primary text-on-primary rounded">Urgent (4)</button>
                                    <button class="px-space-sm py-0.5 font-label-sm text-label-sm text-on-surface-variant hover:text-primary">All (14)</button>
                                </div>
                            </div>
                            <!-- Queue List -->
                            <div class="flex flex-col gap-space-xs">
                                <!-- Item 1 -->
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between p-space-sm bg-surface-container-low hover:bg-secondary-fixed/20 rounded-lg gap-space-sm transition-colors">
                                    <div class="flex items-start gap-space-sm min-w-0">
                                        <div class="w-8 h-8 rounded-full bg-secondary-container flex items-center justify-center shrink-0 text-primary font-label-sm font-bold">
                                            AK
                                        </div>
                                        <div class="flex flex-col min-w-0">
                                            <div class="flex items-center gap-space-xs flex-wrap">
                                                <span class="font-headline-sm text-[14px] text-primary font-bold">A. Korolyov</span>
                                                <span class="font-label-sm text-label-sm text-on-surface-variant font-mono">ID: CDT-2025-081</span>
                                                <span class="font-label-sm text-label-sm px-1.5 py-0.2 bg-tertiary-fixed text-on-tertiary-fixed rounded font-semibold">Cohort 2025-A</span>
                                            </div>
                                            <div class="font-body-sm text-body-sm text-on-surface truncate">
                                                Scenario 05: GenAI RAG Pipeline Optimization — Quantized Llama-3 Vector DB Benchmark
                                            </div>
                                            <div class="font-label-sm text-label-sm text-on-surface-variant flex items-center gap-2 mt-0.5">
                                                <span>Submitted 3h ago</span>
                                                <span>•</span>
                                                <span class="text-primary font-medium">Notebook + Weights Artifact (1.4 GB)</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-space-xs shrink-0 self-end sm:self-center">
                                        <button class="px-space-sm py-1 bg-primary text-on-primary font-label-sm text-label-sm rounded hover:opacity-90 transition-opacity">
                                            Review Rubric
                                        </button>
                                        <button class="p-1 text-on-surface-variant hover:text-primary rounded">
                                            <span class="material-symbols-outlined text-[18px]">more_vert</span>
                                        </button>
                                    </div>
                                </div>
                                <!-- Item 2 -->
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between p-space-sm bg-surface-container-low hover:bg-secondary-fixed/20 rounded-lg gap-space-sm transition-colors">
                                    <div class="flex items-start gap-space-sm min-w-0">
                                        <div class="w-8 h-8 rounded-full bg-tertiary-fixed flex items-center justify-center shrink-0 text-on-tertiary-fixed font-label-sm font-bold">
                                            EV
                                        </div>
                                        <div class="flex flex-col min-w-0">
                                            <div class="flex items-center gap-space-xs flex-wrap">
                                                <span class="font-headline-sm text-[14px] text-primary font-bold">E. Vasilyeva</span>
                                                <span class="font-label-sm text-label-sm text-on-surface-variant font-mono">ID: CDT-2025-044</span>
                                                <span class="font-label-sm text-label-sm px-1.5 py-0.2 bg-secondary-fixed text-primary rounded font-semibold">Cohort 2025-B</span>
                                            </div>
                                            <div class="font-body-sm text-body-sm text-on-surface truncate">
                                                Scenario 02: Fraud Detection Neural Guard — Edge TPU Export Resubmission
                                            </div>
                                            <div class="font-label-sm text-label-sm text-on-surface-variant flex items-center gap-2 mt-0.5">
                                                <span class="text-error font-semibold">Overdue (28h)</span>
                                                <span>•</span>
                                                <span>Instructor feedback addressed</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-space-xs shrink-0 self-end sm:self-center">
                                        <button class="px-space-sm py-1 bg-primary text-on-primary font-label-sm text-label-sm rounded hover:opacity-90 transition-opacity">
                                            Grade Final
                                        </button>
                                        <button class="p-1 text-on-surface-variant hover:text-primary rounded">
                                            <span class="material-symbols-outlined text-[18px]">more_vert</span>
                                        </button>
                                    </div>
                                </div>
                                <!-- Item 3 -->
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between p-space-sm bg-surface-container-low hover:bg-secondary-fixed/20 rounded-lg gap-space-sm transition-colors">
                                    <div class="flex items-start gap-space-sm min-w-0">
                                        <div class="w-8 h-8 rounded-full bg-secondary-container flex items-center justify-center shrink-0 text-primary font-label-sm font-bold">
                                            DM
                                        </div>
                                        <div class="flex flex-col min-w-0">
                                            <div class="flex items-center gap-space-xs flex-wrap">
                                                <span class="font-headline-sm text-[14px] text-primary font-bold">D. Morozov</span>
                                                <span class="font-label-sm text-label-sm text-on-surface-variant font-mono">ID: CDT-2025-102</span>
                                                <span class="font-label-sm text-label-sm px-1.5 py-0.2 bg-tertiary-fixed text-on-tertiary-fixed rounded font-semibold">Cohort 2025-A</span>
                                            </div>
                                            <div class="font-body-sm text-body-sm text-on-surface truncate">
                                                Scenario 07: Autonomous AI SOC Defender — Mitigating Data Inversion Adversary
                                            </div>
                                            <div class="font-label-sm text-label-sm text-on-surface-variant flex items-center gap-2 mt-0.5">
                                                <span>Submitted 5h ago</span>
                                                <span>•</span>
                                                <span class="text-tertiary font-medium">Milestone Capstone</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-space-xs shrink-0 self-end sm:self-center">
                                        <button class="px-space-sm py-1 bg-primary text-on-primary font-label-sm text-label-sm rounded hover:opacity-90 transition-opacity">
                                            Review Rubric
                                        </button>
                                        <button class="p-1 text-on-surface-variant hover:text-primary rounded">
                                            <span class="material-symbols-outlined text-[18px]">more_vert</span>
                                        </button>
                                    </div>
                                </div>
                                <!-- Item 4 -->
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between p-space-sm bg-surface-container-low hover:bg-secondary-fixed/20 rounded-lg gap-space-sm transition-colors">
                                    <div class="flex items-start gap-space-sm min-w-0">
                                        <div class="w-8 h-8 rounded-full bg-surface-container-highest flex items-center justify-center shrink-0 text-primary font-label-sm font-bold">
                                            ST
                                        </div>
                                        <div class="flex flex-col min-w-0">
                                            <div class="flex items-center gap-space-xs flex-wrap">
                                                <span class="font-headline-sm text-[14px] text-primary font-bold">S. Tarasov</span>
                                                <span class="font-label-sm text-label-sm text-on-surface-variant font-mono">ID: CDT-2025-019</span>
                                                <span class="font-label-sm text-label-sm px-1.5 py-0.2 bg-secondary-fixed text-primary rounded font-semibold">Cohort 2025-B</span>
                                            </div>
                                            <div class="font-body-sm text-body-sm text-on-surface truncate">
                                                Scenario 03: CV Surface Defect Detection — YOLOv11 Multi-Spectral Loss Curves
                                            </div>
                                            <div class="font-label-sm text-label-sm text-on-surface-variant flex items-center gap-2 mt-0.5">
                                                <span>Submitted 9h ago</span>
                                                <span>•</span>
                                                <span>Automated PyTest passed (98/100)</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-space-xs shrink-0 self-end sm:self-center">
                                        <button class="px-space-sm py-1 bg-primary text-on-primary font-label-sm text-label-sm rounded hover:opacity-90 transition-opacity">
                                            Quick Verify
                                        </button>
                                        <button class="p-1 text-on-surface-variant hover:text-primary rounded">
                                            <span class="material-symbols-outlined text-[18px]">more_vert</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between pt-space-xs font-label-sm text-label-sm text-on-surface-variant">
                                <span>Showing 4 of 14 queue items</span>
                                <button class="text-primary hover:underline font-bold flex items-center gap-0.5">
                                    <span>View Complete Assessment Ledger</span>
                                    <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                                </button>
                            </div>
                        </div>
                        <!-- RIGHT: AI SOC Live Watch & Security Incident Feed -->
                        <div class="lg:col-span-5 flex flex-col gap-space-md p-space-md bg-surface-container-lowest rounded-xl shadow-sm" id="soc-anchor">
                            <div class="flex items-center justify-between pb-space-xs">
                                <div class="flex items-center gap-space-sm">
                                    <span class="material-symbols-outlined text-error text-[22px]">shield_with_heart</span>
                                    <div>
                                        <h3 class="font-headline-sm text-headline-sm text-primary uppercase">Live AI SOC Watch</h3>
                                        <span class="font-body-sm text-body-sm text-on-surface-variant">Autonomous range guard & drift monitor</span>
                                    </div>
                                </div>
                                <span class="px-2 py-0.5 bg-error text-on-error font-label-sm text-label-sm rounded uppercase font-bold">2 Incidents</span>
                            </div>
                            <!-- Incident Alerts -->
                            <div class="flex flex-col gap-space-sm">
                                <!-- High Alert -->
                                <div class="p-space-sm bg-error-container/40 rounded-lg flex flex-col gap-space-xs shadow-sm">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-1.5 text-error font-bold font-label-sm text-label-sm">
                                            <span class="w-2.5 h-2.5 rounded-full bg-error"></span>
                                            <span>ALERT HIGH: SCN-02 FRAUD DRIFT</span>
                                        </div>
                                        <span class="font-label-sm text-label-sm text-on-surface-variant">08:42:11 UTC</span>
                                    </div>
                                    <p class="font-body-sm text-body-sm text-on-surface">
                                        KS-statistic drift threshold violated (<span class="font-mono font-bold text-error">0.42 > 0.15</span>) on feature <code class="font-mono bg-surface-container px-1 rounded text-primary">tx_velocity_1h</code> across student inference sandbox <span class="font-mono font-semibold">Node-11</span>.
                                    </p>
                                    <div class="flex items-center justify-between pt-1 font-label-sm text-label-sm">
                                        <span class="text-on-surface-variant">Action: Synthetic test set re-seeded</span>
                                        <button class="px-space-sm py-1 bg-error text-on-error font-label-sm rounded hover:opacity-90">Quarantine Model</button>
                                    </div>
                                </div>
                                <!-- Medium Alert -->
                                <div class="p-space-sm bg-secondary-fixed/40 rounded-lg flex flex-col gap-space-xs shadow-sm">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-1.5 text-primary font-bold font-label-sm text-label-sm">
                                            <span class="w-2.5 h-2.5 rounded-full bg-secondary"></span>
                                            <span>ALERT MED: API LATENCY SPIKE</span>
                                        </div>
                                        <span class="font-label-sm text-label-sm text-on-surface-variant">09:04:19 UTC</span>
                                    </div>
                                    <p class="font-body-sm text-body-sm text-on-surface">
                                        SYS-AI-04 Triton inference endpoint p99 latency exceeded budget: <span class="font-mono font-bold text-primary">312ms</span> (SLA max: 150ms).
                                    </p>
                                    <div class="flex items-center justify-between pt-1 font-label-sm text-label-sm">
                                        <span class="text-on-surface-variant">Autoscale trigger dispatched</span>
                                        <button class="px-space-sm py-1 bg-primary text-on-primary font-label-sm rounded hover:opacity-90">Scale Workers (+2)</button>
                                    </div>
                                </div>
                                <!-- Live SOC Stream Log Box -->
                                <div class="flex flex-col bg-surface-container-low p-space-sm rounded-lg font-mono text-[11px] leading-relaxed text-on-surface-variant">
                                    <div class="flex items-center justify-between pb-1 border-b border-surface-container-highest text-primary font-bold">
                                        <span>LIVE OPERATIONAL LOG STREAM</span>
                                        <span class="text-on-surface-variant font-normal">STREAM: ACTIVE</span>
                                    </div>
                                    <div class="pt-1.5 flex flex-col gap-0.5 overflow-hidden">
                                        <div><span class="text-outline">[09:12:02]</span> <span class="text-primary font-bold">SYS-03</span>: Notebook kernel alloc 2x T4 to CDT-2025-081</div>
                                        <div><span class="text-outline">[09:11:45]</span> <span class="text-primary font-bold">SYS-02</span>: Ingest verified: synthetic_radar_echoes_v2.parquet (4.1GB)</div>
                                        <div><span class="text-outline">[09:10:18]</span> <span class="text-secondary font-bold">SYS-04</span>: Canary route shifted 10% traffic to candidate_pt_v3</div>
                                        <div><span class="text-outline">[09:08:55]</span> <span class="text-outline">SYS-01</span>: Auto-evaluated ticket TK-402 tests pass (14/14 checks)</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- SECTION 4: TRAINING BLUEPRINTS & COHORT PROGRESS (Bento Matrix) -->
                    <div class="flex flex-col p-space-md bg-surface-container-lowest rounded-xl shadow-sm gap-space-md">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-space-sm">
                            <div class="flex items-center gap-space-sm">
                                <span class="material-symbols-outlined text-primary text-[24px]">model_training</span>
                                <div>
                                    <h3 class="font-headline-sm text-headline-sm text-primary uppercase">Official Blueprint Scenario Matrix & Cohort Progression</h3>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant">Cadet completion telemetry across the 7 mandatory industrial scenarios</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-space-md">
                                <div class="flex items-center gap-space-xs font-label-sm text-label-sm">
                                    <span class="inline-block w-3 h-3 bg-primary rounded-sm"></span>
                                    <span>Cohort 2025-A (Senior, 64 Cadets)</span>
                                </div>
                                <div class="flex items-center gap-space-xs font-label-sm text-label-sm">
                                    <span class="inline-block w-3 h-3 bg-secondary-container rounded-sm"></span>
                                    <span>Cohort 2025-B (Junior, 64 Cadets)</span>
                                </div>
                                <div class="px-space-sm py-1 bg-tertiary-fixed text-on-tertiary-fixed font-label-sm text-label-sm rounded font-bold">
                                    Avg Rubric: 88.4 / 100
                                </div>
                            </div>
                        </div>
                        <!-- Scenarios Table / Progression Grid -->
                        <div class="overflow-x-auto">
                            <table class="w-full text-left font-body-sm text-body-sm">
                                <thead>
                                    <tr class="bg-surface-container-low text-primary font-label-md text-label-md">
                                        <th class="py-2.5 px-space-md rounded-l">Scenario Blueprint</th>
                                        <th class="py-2.5 px-space-md">Core Competency Domain</th>
                                        <th class="py-2.5 px-space-md">Cohort 2025-A Completion</th>
                                        <th class="py-2.5 px-space-md">Cohort 2025-B Completion</th>
                                        <th class="py-2.5 px-space-md">Avg Accuracy / F1</th>
                                        <th class="py-2.5 px-space-md rounded-r text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-surface-container-highest">
                                    <!-- Scenario 1 -->
                                    <tr class="hover:bg-surface-container-low/60 transition-colors">
                                        <td class="py-space-sm px-space-md">
                                            <div class="flex items-center gap-space-sm">
                                                <span class="font-label-sm text-label-sm px-1.5 py-0.5 bg-secondary-fixed text-primary rounded font-mono font-bold">SCN-01</span>
                                                <div>
                                                    <div class="font-headline-sm text-[14px] text-primary font-bold">Predictive Churn Engine</div>
                                                    <div class="font-label-sm text-label-sm text-on-surface-variant">Tabular Gradient Boosting & SHAP</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-space-sm px-space-md text-on-surface">Tabular / Interpretability</td>
                                        <td class="py-space-sm px-space-md">
                                            <div class="flex items-center gap-space-sm">
                                                <div class="w-24 bg-surface-container-highest h-2 rounded-full overflow-hidden">
                                                    <div class="bg-primary h-full rounded-full" style="width: 100%;"></div>
                                                </div>
                                                <span class="font-label-sm text-label-sm font-bold text-primary">100%</span>
                                            </div>
                                        </td>
                                        <td class="py-space-sm px-space-md">
                                            <div class="flex items-center gap-space-sm">
                                                <div class="w-24 bg-surface-container-highest h-2 rounded-full overflow-hidden">
                                                    <div class="bg-secondary h-full rounded-full" style="width: 92%;"></div>
                                                </div>
                                                <span class="font-label-sm text-label-sm font-bold text-primary">92%</span>
                                            </div>
                                        </td>
                                        <td class="py-space-sm px-space-md font-mono font-semibold text-primary">AUC 0.941</td>
                                        <td class="py-space-sm px-space-md text-right">
                                            <button class="px-space-sm py-1 font-label-sm text-label-sm text-primary hover:bg-secondary-fixed rounded transition-colors">
                                                Telemetry
                                            </button>
                                        </td>
                                    </tr>
                                    <!-- Scenario 2 -->
                                    <tr class="hover:bg-surface-container-low/60 transition-colors">
                                        <td class="py-space-sm px-space-md">
                                            <div class="flex items-center gap-space-sm">
                                                <span class="font-label-sm text-label-sm px-1.5 py-0.5 bg-secondary-fixed text-primary rounded font-mono font-bold">SCN-02</span>
                                                <div>
                                                    <div class="font-headline-sm text-[14px] text-primary font-bold">Fraud Detection Neural Guard</div>
                                                    <div class="font-label-sm text-label-sm text-on-surface-variant">Unbalanced Streaming Graph Embeddings</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-space-sm px-space-md text-on-surface">Streaming Anomaly / GNN</td>
                                        <td class="py-space-sm px-space-md">
                                            <div class="flex items-center gap-space-sm">
                                                <div class="w-24 bg-surface-container-highest h-2 rounded-full overflow-hidden">
                                                    <div class="bg-primary h-full rounded-full" style="width: 96%;"></div>
                                                </div>
                                                <span class="font-label-sm text-label-sm font-bold text-primary">96%</span>
                                            </div>
                                        </td>
                                        <td class="py-space-sm px-space-md">
                                            <div class="flex items-center gap-space-sm">
                                                <div class="w-24 bg-surface-container-highest h-2 rounded-full overflow-hidden">
                                                    <div class="bg-secondary h-full rounded-full" style="width: 81%;"></div>
                                                </div>
                                                <span class="font-label-sm text-label-sm font-bold text-primary">81%</span>
                                            </div>
                                        </td>
                                        <td class="py-space-sm px-space-md font-mono font-semibold text-primary">F1 0.912</td>
                                        <td class="py-space-sm px-space-md text-right">
                                            <button class="px-space-sm py-1 font-label-sm text-label-sm text-primary hover:bg-secondary-fixed rounded transition-colors">
                                                Telemetry
                                            </button>
                                        </td>
                                    </tr>
                                    <!-- Scenario 3 -->
                                    <tr class="hover:bg-surface-container-low/60 transition-colors">
                                        <td class="py-space-sm px-space-md">
                                            <div class="flex items-center gap-space-sm">
                                                <span class="font-label-sm text-label-sm px-1.5 py-0.5 bg-secondary-fixed text-primary rounded font-mono font-bold">SCN-03</span>
                                                <div>
                                                    <div class="font-headline-sm text-[14px] text-primary font-bold">Computer Vision Defect Isolation</div>
                                                    <div class="font-label-sm text-label-sm text-on-surface-variant">Micro-fracture Detection via Transformer</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-space-sm px-space-md text-on-surface">Vision / Segmentation</td>
                                        <td class="py-space-sm px-space-md">
                                            <div class="flex items-center gap-space-sm">
                                                <div class="w-24 bg-surface-container-highest h-2 rounded-full overflow-hidden">
                                                    <div class="bg-primary h-full rounded-full" style="width: 94%;"></div>
                                                </div>
                                                <span class="font-label-sm text-label-sm font-bold text-primary">94%</span>
                                            </div>
                                        </td>
                                        <td class="py-space-sm px-space-md">
                                            <div class="flex items-center gap-space-sm">
                                                <div class="w-24 bg-surface-container-highest h-2 rounded-full overflow-hidden">
                                                    <div class="bg-secondary h-full rounded-full" style="width: 70%;"></div>
                                                </div>
                                                <span class="font-label-sm text-label-sm font-bold text-primary">70%</span>
                                            </div>
                                        </td>
                                        <td class="py-space-sm px-space-md font-mono font-semibold text-primary">mAP@50 0.887</td>
                                        <td class="py-space-sm px-space-md text-right">
                                            <button class="px-space-sm py-1 font-label-sm text-label-sm text-primary hover:bg-secondary-fixed rounded transition-colors">
                                                Telemetry
                                            </button>
                                        </td>
                                    </tr>
                                    <!-- Scenario 4 -->
                                    <tr class="hover:bg-surface-container-low/60 transition-colors">
                                        <td class="py-space-sm px-space-md">
                                            <div class="flex items-center gap-space-sm">
                                                <span class="font-label-sm text-label-sm px-1.5 py-0.5 bg-secondary-fixed text-primary rounded font-mono font-bold">SCN-04</span>
                                                <div>
                                                    <div class="font-headline-sm text-[14px] text-primary font-bold">Industrial Signal NLP Classifier</div>
                                                    <div class="font-label-sm text-label-sm text-on-surface-variant">Telemetry Log Parsing & Incident Routing</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-space-sm px-space-md text-on-surface">Sequence Modeling / BERT</td>
                                        <td class="py-space-sm px-space-md">
                                            <div class="flex items-center gap-space-sm">
                                                <div class="w-24 bg-surface-container-highest h-2 rounded-full overflow-hidden">
                                                    <div class="bg-primary h-full rounded-full" style="width: 88%;"></div>
                                                </div>
                                                <span class="font-label-sm text-label-sm font-bold text-primary">88%</span>
                                            </div>
                                        </td>
                                        <td class="py-space-sm px-space-md">
                                            <div class="flex items-center gap-space-sm">
                                                <div class="w-24 bg-surface-container-highest h-2 rounded-full overflow-hidden">
                                                    <div class="bg-secondary h-full rounded-full" style="width: 58%;"></div>
                                                </div>
                                                <span class="font-label-sm text-label-sm font-bold text-primary">58%</span>
                                            </div>
                                        </td>
                                        <td class="py-space-sm px-space-md font-mono font-semibold text-primary">Acc 93.4%</td>
                                        <td class="py-space-sm px-space-md text-right">
                                            <button class="px-space-sm py-1 font-label-sm text-label-sm text-primary hover:bg-secondary-fixed rounded transition-colors">
                                                Telemetry
                                            </button>
                                        </td>
                                    </tr>
                                    <!-- Scenario 5 -->
                                    <tr class="hover:bg-surface-container-low/60 transition-colors">
                                        <td class="py-space-sm px-space-md">
                                            <div class="flex items-center gap-space-sm">
                                                <span class="font-label-sm text-label-sm px-1.5 py-0.5 bg-secondary-fixed text-primary rounded font-mono font-bold">SCN-05</span>
                                                <div>
                                                    <div class="font-headline-sm text-[14px] text-primary font-bold">GenAI RAG Mission Assistant</div>
                                                    <div class="font-label-sm text-label-sm text-on-surface-variant">Hybrid Vector Search + Quantized SLM</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-space-sm px-space-md text-on-surface">LLM / Vector Lake</td>
                                        <td class="py-space-sm px-space-md">
                                            <div class="flex items-center gap-space-sm">
                                                <div class="w-24 bg-surface-container-highest h-2 rounded-full overflow-hidden">
                                                    <div class="bg-primary h-full rounded-full" style="width: 79%;"></div>
                                                </div>
                                                <span class="font-label-sm text-label-sm font-bold text-primary">79%</span>
                                            </div>
                                        </td>
                                        <td class="py-space-sm px-space-md">
                                            <div class="flex items-center gap-space-sm">
                                                <div class="w-24 bg-surface-container-highest h-2 rounded-full overflow-hidden">
                                                    <div class="bg-secondary h-full rounded-full" style="width: 32%;"></div>
                                                </div>
                                                <span class="font-label-sm text-label-sm font-bold text-primary">32%</span>
                                            </div>
                                        </td>
                                        <td class="py-space-sm px-space-md font-mono font-semibold text-primary">Recall@5 0.94</td>
                                        <td class="py-space-sm px-space-md text-right">
                                            <button class="px-space-sm py-1 font-label-sm text-label-sm text-primary hover:bg-secondary-fixed rounded transition-colors">
                                                Telemetry
                                            </button>
                                        </td>
                                    </tr>
                                    <!-- Scenario 6 -->
                                    <tr class="hover:bg-surface-container-low/60 transition-colors">
                                        <td class="py-space-sm px-space-md">
                                            <div class="flex items-center gap-space-sm">
                                                <span class="font-label-sm text-label-sm px-1.5 py-0.5 bg-secondary-fixed text-primary rounded font-mono font-bold">SCN-06</span>
                                                <div>
                                                    <div class="font-headline-sm text-[14px] text-primary font-bold">Autonomous Control AI Agent</div>
                                                    <div class="font-label-sm text-label-sm text-on-surface-variant">Reinforcement Learning in Flight Simulator</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-space-sm px-space-md text-on-surface">RL / Policy Optimization</td>
                                        <td class="py-space-sm px-space-md">
                                            <div class="flex items-center gap-space-sm">
                                                <div class="w-24 bg-surface-container-highest h-2 rounded-full overflow-hidden">
                                                    <div class="bg-primary h-full rounded-full" style="width: 62%;"></div>
                                                </div>
                                                <span class="font-label-sm text-label-sm font-bold text-primary">62%</span>
                                            </div>
                                        </td>
                                        <td class="py-space-sm px-space-md">
                                            <div class="flex items-center gap-space-sm">
                                                <div class="w-24 bg-surface-container-highest h-2 rounded-full overflow-hidden">
                                                    <div class="bg-secondary h-full rounded-full" style="width: 14%;"></div>
                                                </div>
                                                <span class="font-label-sm text-label-sm font-bold text-primary">14%</span>
                                            </div>
                                        </td>
                                        <td class="py-space-sm px-space-md font-mono font-semibold text-primary">Reward +842</td>
                                        <td class="py-space-sm px-space-md text-right">
                                            <button class="px-space-sm py-1 font-label-sm text-label-sm text-primary hover:bg-secondary-fixed rounded transition-colors">
                                                Telemetry
                                            </button>
                                        </td>
                                    </tr>
                                    <!-- Scenario 7 -->
                                    <tr class="hover:bg-surface-container-low/60 transition-colors">
                                        <td class="py-space-sm px-space-md">
                                            <div class="flex items-center gap-space-sm">
                                                <span class="font-label-sm text-label-sm px-1.5 py-0.5 bg-tertiary-fixed text-on-tertiary-fixed rounded font-mono font-bold">SCN-07</span>
                                                <div>
                                                    <div class="font-headline-sm text-[14px] text-primary font-bold">Autonomous AI SOC Defender</div>
                                                    <div class="font-label-sm text-label-sm text-on-surface-variant">Adversarial Robustness & Automated Patching</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-space-sm px-space-md text-on-surface">AI Red Teaming / SOC Guard</td>
                                        <td class="py-space-sm px-space-md">
                                            <div class="flex items-center gap-space-sm">
                                                <div class="w-24 bg-surface-container-highest h-2 rounded-full overflow-hidden">
                                                    <div class="bg-primary h-full rounded-full" style="width: 48%;"></div>
                                                </div>
                                                <span class="font-label-sm text-label-sm font-bold text-primary">48%</span>
                                            </div>
                                        </td>
                                        <td class="py-space-sm px-space-md">
                                            <div class="flex items-center gap-space-sm">
                                                <div class="w-24 bg-surface-container-highest h-2 rounded-full overflow-hidden">
                                                    <div class="bg-secondary h-full rounded-full" style="width: 5%;"></div>
                                                </div>
                                                <span class="font-label-sm text-label-sm font-bold text-primary">5%</span>
                                            </div>
                                        </td>
                                        <td class="py-space-sm px-space-md font-mono font-semibold text-primary">Def. Ratio 91%</td>
                                        <td class="py-space-sm px-space-md text-right">
                                            <button class="px-space-sm py-1 font-label-sm text-label-sm text-primary hover:bg-secondary-fixed rounded transition-colors">
                                                Telemetry
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- SECTION 5: TACTICAL TELEMETRY & PHYSICAL TESTBED IMAGES -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-space-md">
                        <!-- Visual 1: Industrial Range Hardware -->
                        <div class="flex flex-col p-space-md bg-surface-container-lowest rounded-xl shadow-sm gap-space-sm">
                            <div class="flex items-center justify-between">
                                <span class="font-headline-sm text-[14px] text-primary font-bold">Range Testbed Enclosure</span>
                                <span class="font-label-sm text-label-sm px-1.5 py-0.5 bg-surface-container text-on-surface-variant rounded">BAY-04</span>
                            </div>
                            <img class="w-full h-36 object-cover rounded-lg" data-alt="Aerospace server rack and telemetry interface inside high security AI engineering laboratory with soft purple ambient LED accents and fiber optic patch cabling." src="https://lh3.googleusercontent.com/aida-public/AB6AXuBqnGr9KTdbmWwrRD3eXw9VHPFOC6MwsIxGRj6yMyNyX1BKv8jev2VFoWAiz12UNMq1UORILok2yo3I9goHM1f-FpvtLZYvjwsNFuJYfMeAvZGOS3kxVmngd4DgOx3Nw8aqZiRFVoC2b00E7rk7rK_11WxqULkoxTG82jodUckiC7PT_MN2zsXzPyhxtUWFOfKM0-fes19hNgTL0Uelx8rvnRhiijQrzWBtWOQ0dRXHpdphjXLqxDv_" />
                            <div class="font-body-sm text-body-sm text-on-surface-variant">
                                Subsystem edge deployment nodes running live verification for CADET-2025-A hardware benchmarks.
                            </div>
                        </div>
                        <!-- Visual 2: GPU Cluster Thermal Profile -->
                        <div class="flex flex-col p-space-md bg-surface-container-lowest rounded-xl shadow-sm gap-space-sm">
                            <div class="flex items-center justify-between">
                                <span class="font-headline-sm text-[14px] text-primary font-bold">NVIDIA A100 Compute Mesh</span>
                                <span class="font-label-sm text-label-sm px-1.5 py-0.5 bg-tertiary-fixed text-on-tertiary-fixed rounded font-bold">32 NODES</span>
                            </div>
                            <img class="w-full h-36 object-cover rounded-lg" data-alt="High performance computing data center with liquid cooling pipelines and deep purple illuminated cleanroom enclosures with technician monitor." src="https://lh3.googleusercontent.com/aida-public/AB6AXuByPKb6smJeN8ruJX6IJp6vLktfzQ3ymgxeGwWWcFVssHuqcuNWlxf6tDr8lg5xWB2FodqZtkzj6Ufnj1I8-kA7098vis6SYLI18woHPY8GXBdBJ0mBuabltH6byqsoQxOn4MKqTvHo7pBV9aGjj5t6LuEDwhHtlXWFdKsJMlwILRhHBlru7cT3KHovuq6-BvHHw7glhfayBFCezz1dTWFzY02cM8Bfh5Te6dJeogKOUo7RJIa4djSY" />
                            <div class="font-body-sm text-body-sm text-on-surface-variant">
                                Thermal delta nominal at 54°C under 78% continuous synthetic payload training load.
                            </div>
                        </div>
                        <!-- Visual 3: Range Control Telemetry -->
                        <div class="flex flex-col p-space-md bg-surface-container-lowest rounded-xl shadow-sm gap-space-sm">
                            <div class="flex items-center justify-between">
                                <span class="font-headline-sm text-[14px] text-primary font-bold">Chief Console Diagnostics</span>
                                <span class="font-label-sm text-label-sm px-1.5 py-0.5 bg-secondary-fixed text-primary rounded font-bold">SYNC OK</span>
                            </div>
                            <img class="w-full h-36 object-cover rounded-lg" data-alt="Tactical operations command center with dual high density monitors displaying neural network graph topologies and telemetry curves in purple and amber hues." src="https://lh3.googleusercontent.com/aida-public/AB6AXuAETBeHSH1WTA_5OMNbZCFa5vGUG07ceCwQFI57Ekew_qVP2BsnlK9PHnkI17Pjv5kFL_PvzSBoHBUevbEIX1xz-UmvSl8iaxLFnosJSC2MDutSVv-IqbRF9Ns0xGBbH3wX-dwqtxvBYHP-LJ-qRwFPiS8JZKYPSqX0uSlfli3lI3gVft9vWAXzbwVcRVBSoyvR6xHyaF8vtLeUo4qolTrzplD86-XWpSD2oRqWKDZOC7RNkbrn433u" />
                            <div class="font-body-sm text-body-sm text-on-surface-variant">
                                Instructor terminal linked directly into range supervisor bus with instantaneous rollback authority.
                            </div>
                        </div>
                    </div>
                    <!-- INTERACTIVE MODAL: Create Ticket / Blueprint Scenario (Hidden by default) -->
                    <div class="fixed inset-0 bg-primary/40 backdrop-blur-sm z-50 hidden flex items-center justify-center p-space-md" id="modal-ticket">
                        <div class="bg-surface-container-lowest rounded-xl max-w-xl w-full p-space-lg shadow-xl flex flex-col gap-space-md relative">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-space-xs">
                                    <span class="material-symbols-outlined text-primary text-[24px]">post_add</span>
                                    <h3 class="font-headline-sm text-headline-sm text-primary uppercase">Provision Scenario Blueprint</h3>
                                </div>
                                <button class="text-on-surface-variant hover:text-primary" onclick="toggleModal('modal-ticket')">
                                    <span class="material-symbols-outlined text-[20px]">close</span>
                                </button>
                            </div>
                            <div class="flex flex-col gap-space-sm">
                                <label class="flex flex-col gap-1">
                                    <span class="font-label-sm text-label-sm text-on-surface-variant uppercase font-bold">Scenario Title</span>
                                    <input class="px-space-sm py-1.5 bg-surface-container-low text-primary rounded text-body-sm focus:outline-none" placeholder="e.g. SCN-08: Autonomous Sensor Fusion Kalmann Neural Filter" type="text" />
                                </label>
                                <div class="grid grid-cols-2 gap-space-sm">
                                    <label class="flex flex-col gap-1">
                                        <span class="font-label-sm text-label-sm text-on-surface-variant uppercase font-bold">Subsystem Target</span>
                                        <select class="px-space-sm py-1.5 bg-surface-container-low text-primary rounded text-body-sm">
                                            <option>SYS-AI-01: Orchestration</option>
                                            <option>SYS-AI-03: GPU Workbench</option>
                                            <option>SYS-AI-04: Model Registry</option>
                                            <option>SYS-AI-05: AI SOC Watch</option>
                                        </select>
                                    </label>
                                    <label class="flex flex-col gap-1">
                                        <span class="font-label-sm text-label-sm text-on-surface-variant uppercase font-bold">Target Cohort</span>
                                        <select class="px-space-sm py-1.5 bg-surface-container-low text-primary rounded text-body-sm">
                                            <option>Cohort 2025-A (Senior)</option>
                                            <option>Cohort 2025-B (Junior)</option>
                                            <option>All Enrolled Cadets</option>
                                        </select>
                                    </label>
                                </div>
                                <label class="flex flex-col gap-1">
                                    <span class="font-label-sm text-label-sm text-on-surface-variant uppercase font-bold">Auto-Grading PyTest Artifact URL</span>
                                    <input class="px-space-sm py-1.5 bg-surface-container-low text-primary font-mono text-[12px] rounded" placeholder="s3://vostok-testbed/eval/scn-08-autocheck.py" type="text" />
                                </label>
                            </div>
                            <div class="flex items-center justify-end gap-space-sm pt-space-xs">
                                <button class="px-space-md py-1.5 bg-surface-container-low text-on-surface-variant font-label-md text-label-md rounded hover:bg-surface-container" onclick="toggleModal('modal-ticket')">Cancel</button>
                                <button class="px-space-md py-1.5 bg-primary text-on-primary font-label-md text-label-md rounded hover:opacity-95" onclick="publishTicketAlert()">Deploy to Range</button>
                            </div>
                        </div>
                    </div>
                </div>
                <script src="js/main.js"></script>
            </div>
        </main>
    </div>
</body>

</html>