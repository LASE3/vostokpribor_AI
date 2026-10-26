<?php
require_once __DIR__ . '/../app/bootstrap.php';

use App\Middleware\AuthenticationMiddleware;
use App\Core\Database;
use App\Core\Auth;

$currentUser = AuthenticationMiddleware::handle();
$db = Database::getInstance();

$isStudent = ($currentUser['role'] === 'STUDENT');

if ($isStudent) {
    $models = $db->fetchAll("
        SELECT m.*, mv.version AS version_name, mv.file_size, mv.checksum_sha256, mv.metrics 
        FROM models m 
        LEFT JOIN model_versions mv ON m.id = mv.model_id 
        WHERE m.student_id = :sid 
        ORDER BY m.created_at DESC
    ", ['sid' => $currentUser['id']]);

    $validations = $db->fetchAll("
        SELECT vr.*, m.name AS model_name, m.model_code 
        FROM validation_runs vr 
        JOIN models m ON vr.model_id = m.id 
        WHERE vr.requested_by = :sid 
        ORDER BY vr.created_at DESC
    ", ['sid' => $currentUser['id']]);

    $deployments = $db->fetchAll("
        SELECT d.*, m.name AS model_name, m.model_code, mv.version AS model_version 
        FROM deployments d 
        JOIN model_versions mv ON d.model_version_id = mv.id 
        JOIN models m ON mv.model_id = m.id 
        WHERE m.student_id = :sid 
        ORDER BY d.deployed_at DESC
    ", ['sid' => $currentUser['id']]);
} else {
    $models = $db->fetchAll("
        SELECT m.*, mv.version AS version_name, mv.file_size, mv.checksum_sha256, mv.metrics, u.full_name AS student_name 
        FROM models m 
        LEFT JOIN model_versions mv ON m.id = mv.model_id 
        LEFT JOIN users u ON m.student_id = u.id 
        ORDER BY m.created_at DESC
    ");

    $validations = $db->fetchAll("
        SELECT vr.*, m.name AS model_name, m.model_code, u.full_name AS student_name 
        FROM validation_runs vr 
        JOIN models m ON vr.model_id = m.id 
        LEFT JOIN users u ON vr.requested_by = u.id 
        ORDER BY vr.created_at DESC
    ");

    $deployments = $db->fetchAll("
        SELECT d.*, m.name AS model_name, m.model_code, mv.version AS model_version, u.full_name AS student_name 
        FROM deployments d 
        JOIN model_versions mv ON d.model_version_id = mv.id 
        JOIN models m ON mv.model_id = m.id 
        LEFT JOIN users u ON m.student_id = u.id 
        ORDER BY d.deployed_at DESC
    ");
}

$modelCount = count($models);
$validatedCount = count(array_filter($models, fn($m) => in_array($m['status'], ['VALIDATION_PASSED', 'APPROVED', 'DEPLOYED'])));
$deploymentCount = count($deployments);
?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="web_dashboard" name="shell-type" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=JetBrains+Mono:wght@400;500;600&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="css/style.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="js/tailwind.config.js"></script>
</head>

<body class="fiberglass-bg font-body-md text-body-md text-on-surface antialiased">
    <header class="fixed top-0 left-0 right-0 h-16 z-50 bg-surface-container-lowest/90 backdrop-blur-md shadow-[0_1px_8px_rgba(76,29,149,0.06)] flex items-center justify-between px-gutter-desktop">
        <div class="flex items-center gap-space-lg">
            <div class="flex items-center gap-space-sm"><img alt="VOSTOKPRIBOR Model Registry Logo" class="h-8 w-auto object-contain" src="https://lh3.googleusercontent.com/aida/AEtjO1UhoYwq5t9HPgpRtyxHGI2UdzYhNlqNU-hWgKRHJ5VkcmrTXgqnvyF-4wgo07xhFFoT_uTTiDefF-oSiel5IThQoE_Wk8viHY2y7rix0nI-aR-LbgUIltwiRNU8FVZvTCa7xMRX2dQkah-15862CmyhJCTxFXVOU0fzW6NRiClygS6ANBGLBni5DBV9iPW9wtfSc5J5udbwkh9vseFiCr-AgtKeZ9HkPabZ9I_iVI-0c7Veg7CjBzq0DA" />
                <div class="flex flex-col"><span class="font-headline-sm text-headline-sm text-primary tracking-tight">VOSTOKPRIBOR</span><span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-widest">SYS-AI-04 // ORBIT-ML</span></div>
            </div>
            <div class="h-6 w-px bg-surface-container-highest"></div>
            <nav class="hidden xl:flex items-center gap-1 bg-surface-container-low p-1 rounded-xl"><a class="px-space-sm py-1 font-label-sm text-label-sm rounded text-on-surface-variant hover:text-primary transition-colors" href="../AI Project Management/Dashboard.php">SYS-AI-01</a><a class="px-space-sm py-1 font-label-sm text-label-sm rounded text-on-surface-variant hover:text-primary transition-colors" href="../Data Center/dashboard.php">SYS-AI-02</a><a class="px-space-sm py-1 font-label-sm text-label-sm rounded text-on-surface-variant hover:text-primary transition-colors" href="../ML Workbench/NotebookWorkbench.php">SYS-AI-03</a><span class="px-space-sm py-1 font-label-sm text-label-sm rounded bg-primary-container text-on-primary font-bold shadow-sm">SYS-AI-04 REGISTRY</span><a class="px-space-sm py-1 font-label-sm text-label-sm rounded text-on-surface-variant hover:text-primary transition-colors" href="../AI Operations Center (AI SOC)/TicketsAndScenarios.php">SYS-AI-05</a></nav>
        </div>
        <div class="hidden lg:flex items-center">
            <div class="flex items-center gap-space-sm bg-surface-container px-space-md py-1.5 rounded-full shadow-inner"><span class="w-2 h-2 rounded-full bg-secondary-container animate-pulse"></span><span class="font-label-sm text-label-sm text-on-surface-variant uppercase">Active Scenario:</span><span class="font-label-md text-label-md text-primary font-semibold">Customer Churn Prediction (v2.4)</span><span class="material-symbols-outlined text-primary text-[18px]">expand_more</span></div>
        </div>
        <div class="flex items-center gap-space-md">
            <div class="hidden md:flex items-center gap-space-sm bg-surface-container-low px-space-sm py-1 rounded"><span class="w-2 h-2 rounded-full bg-on-tertiary-container"></span><span class="font-code-sm text-code-sm text-on-surface-variant">GATEWAY: OK (14ms)</span></div>
            <div class="hidden sm:flex items-center gap-1 bg-surface-container-high px-space-sm py-1 rounded text-primary font-label-sm text-label-sm"><span class="material-symbols-outlined text-[16px]">tune</span><span>Staging / Eval</span></div><button class="relative p-1.5 rounded-lg text-on-surface-variant hover:text-primary hover:bg-surface-container transition-colors"><span class="material-symbols-outlined text-[20px]">notifications</span><span class="absolute top-1 right-1 w-2 h-2 bg-error rounded-full"></span></button>
            <div class="flex items-center gap-space-sm pl-space-xs">
                <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center"><span class="material-symbols-outlined text-on-primary text-[18px]">person</span></div>
                <div class="hidden 2xl:flex flex-col text-left"><span class="font-label-md text-label-md font-semibold text-on-surface leading-none"><?= htmlspecialchars($currentUser['full_name']) ?></span><span class="font-code-sm text-code-sm text-on-surface-variant leading-none mt-0.5"><?= htmlspecialchars($currentUser['identifier'] ?? $currentUser['email']) ?></span></div>
            </div>
        </div>
    </header>
    <aside class="fixed left-0 top-16 bottom-0 w-72 bg-surface-container-low/95 backdrop-blur-md z-40 flex flex-col justify-between shadow-[1px_0_12px_rgba(76,29,149,0.04)]">
        <div class="flex flex-col">
            <div class="px-space-lg py-space-md flex items-center justify-between">
                <div class="flex items-center gap-space-sm"><span class="material-symbols-outlined text-primary text-[20px]">deployed_code</span><span class="font-headline-sm text-headline-sm text-primary tracking-tight">MLOps Hub</span></div><span class="font-code-sm text-code-sm px-1.5 py-0.5 bg-surface-container-high rounded text-on-surface-variant">REV 4.2</span>
            </div>
            <nav class="flex flex-col gap-1 px-space-md py-space-sm" data-active-classes="bg-primary-container text-on-primary font-bold rounded-lg shadow-sm"><a aria-current="page" class="flex items-center gap-space-md px-space-md py-2.5 transition-colors bg-primary-container text-on-primary font-bold rounded-lg shadow-sm" data-path="dashboard" href="dashboard.php"><span class="material-symbols-outlined text-[20px]">dashboard</span><span>Dashboard</span></a><a class="flex items-center gap-space-md px-space-md py-2.5 rounded-lg text-on-surface-variant font-label-md text-label-md hover:bg-surface-container-high hover:text-on-surface transition-colors" data-path="model-registry" href="ModelRegistry.php"><span class="material-symbols-outlined text-[20px]">inventory_2</span><span>Model Registry</span></a><a class="flex items-center gap-space-md px-space-md py-2.5 rounded-lg text-on-surface-variant font-label-md text-label-md hover:bg-surface-container-high hover:text-on-surface transition-colors" data-path="automated-validation-pipeline" href="ValidationPipeline.php"><span class="material-symbols-outlined text-[20px]">fact_check</span><span>Validation Pipeline</span></a><a class="flex items-center gap-space-md px-space-md py-2.5 rounded-lg text-on-surface-variant font-label-md text-label-md hover:bg-surface-container-high hover:text-on-surface transition-colors" data-path="deployment-configuration" href="DeploymentConfig.php"><span class="material-symbols-outlined text-[20px]">settings_input_component</span><span>Deployment Config</span></a><a class="flex items-center gap-space-md px-space-md py-2.5 rounded-lg text-on-surface-variant font-label-md text-label-md hover:bg-surface-container-high hover:text-on-surface transition-colors" data-path="deployed-endpoints" href="DeployedEndpoints.php"><span class="material-symbols-outlined text-[20px]">cell_tower</span><span>Deployed Endpoints</span></a><a class="flex items-center gap-space-md px-space-md py-2.5 rounded-lg text-on-surface-variant font-label-md text-label-md hover:bg-surface-container-high hover:text-on-surface transition-colors" data-path="validation-reports" href="ValidationReports.php"><span class="material-symbols-outlined text-[20px]">description</span><span>Validation Reports</span></a></nav>
        </div>
        <div class="p-space-md m-space-md rounded-xl bg-surface-container-lowest/80 backdrop-blur-sm shadow-sm flex flex-col gap-space-xs">
            <div class="flex items-center justify-between"><span class="font-label-sm text-label-sm text-primary uppercase font-bold tracking-wider">Active Context</span><span class="font-code-sm text-code-sm px-1 rounded bg-secondary-container/40 text-on-secondary-container">POD #04</span></div>
            <div class="flex flex-col gap-1 pt-1">
                <div class="flex items-center gap-1.5"><span class="material-symbols-outlined text-[14px] text-on-tertiary-container">confirmation_number</span><span class="font-code-sm text-code-sm text-on-surface truncate">VP-TKT-1082: Churn Baseline v2</span></div>
                <div class="flex items-center gap-1.5"><span class="material-symbols-outlined text-[14px] text-secondary">terminal</span><span class="font-code-sm text-code-sm text-on-surface truncate">EXP-884_xgboost_churn.ipynb</span></div>
                <div class="flex items-center gap-1.5"><span class="material-symbols-outlined text-[14px] text-on-surface-variant">radar</span><span class="font-label-sm text-label-sm text-on-surface-variant">Telemetry Range Pod #04</span></div>
            </div>
        </div>
    </aside>
    <div class="pl-72">
        <main class="relative pt-16 w-full min-h-screen px-gutter-desktop py-gutter-desktop">
            <div class="flex flex-col w-full gap-space-lg">
                <!-- Top Action Bar & Page Identity -->
                <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-space-md bg-surface-container-lowest p-space-lg rounded-xl shadow-sm">
                    <div class="flex flex-col gap-space-xs">
                        <div class="flex items-center gap-space-xs text-on-surface-variant font-label-sm text-label-sm">
                            <span class="hover:text-primary transition-colors cursor-pointer">SYS-AI-04</span>
                            <span>/</span>
                            <span class="text-primary font-bold">DEPLOYMENT DASHBOARD</span>
                            <span class="px-1.5 py-0.5 rounded bg-secondary-container/30 text-on-secondary-container font-code-sm text-code-sm ml-2">STATION: ORBIT-ML</span>
                        </div>
                        <h1 class="font-headline-lg text-headline-lg text-primary tracking-tight">Model Registry &amp; Deployment Operations</h1>
                        <p class="font-body-md text-body-md text-on-surface-variant max-w-4xl">
                            Centralized model intake, automated gate validations, and stage-gate deployment orchestration for active telemetry scenarios.
                        </p>
                    </div>
                    <!-- Quick Actions -->
                    <div class="flex flex-wrap items-center gap-space-sm pt-2 xl:pt-0">
                        <button class="h-8 px-space-md bg-primary-container text-on-primary rounded font-label-md text-label-md font-semibold hover:bg-primary transition-all flex items-center gap-1.5 shadow-sm active:scale-95">
                            <span class="material-symbols-outlined text-[16px]">add_circle</span>
                            <span>Register New Artifact</span>
                        </button>
                        <button class="h-8 px-space-md bg-surface-container-low text-primary-container rounded font-label-md text-label-md font-semibold hover:bg-surface-container transition-all flex items-center gap-1.5 active:scale-95">
                            <span class="material-symbols-outlined text-[16px]">play_arrow</span>
                            <span>Trigger Batch Validation</span>
                        </button>
                        <button class="h-8 px-space-md bg-tertiary-fixed text-on-tertiary-fixed rounded font-label-md text-label-md font-semibold hover:bg-tertiary-fixed-dim transition-all flex items-center gap-1.5 active:scale-95">
                            <span class="material-symbols-outlined text-[16px]">rule</span>
                            <span>Evaluation Criteria</span>
                        </button>
                    </div>
                </div>
                <!-- KPI Metric Summary Grid (7 Cards strictly matching aerospace laboratory tokens) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 2xl:grid-cols-7 gap-space-md">
                    <!-- Card 1: Total Registered Models -->
                    <div class="bg-surface-container-lowest p-space-md rounded-xl shadow-sm flex flex-col justify-between min-h-[128px]">
                        <div class="flex items-center justify-between">
                            <span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Total Models</span>
                            <span class="p-1 rounded bg-secondary-fixed text-primary"><span class="material-symbols-outlined text-[16px]">layers</span></span>
                        </div>
                        <div>
                            <div class="flex items-baseline gap-space-xs">
                                <span class="font-headline-xl text-headline-xl text-primary font-bold leading-none">48</span>
                                <span class="font-label-sm text-label-sm text-on-secondary-fixed-variant font-semibold">+4 wk</span>
                            </div>
                            <p class="font-body-sm text-body-sm text-on-surface-variant mt-1 truncate">12 scenario versions</p>
                        </div>
                    </div>
                    <!-- Card 2: Awaiting Validation -->
                    <div class="bg-surface-container-lowest p-space-md rounded-xl shadow-sm flex flex-col justify-between min-h-[128px]">
                        <div class="flex items-center justify-between">
                            <span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">In Queue</span>
                            <span class="p-1 rounded bg-surface-container-high text-primary"><span class="material-symbols-outlined text-[16px]">hourglass_top</span></span>
                        </div>
                        <div>
                            <div class="flex items-baseline gap-space-xs">
                                <span class="font-headline-xl text-headline-xl text-primary font-bold leading-none">7</span>
                                <span class="font-code-sm text-code-sm text-on-surface-variant">Schema Gate</span>
                            </div>
                            <p class="font-body-sm text-body-sm text-on-surface-variant mt-1 truncate">Integrity check pending</p>
                        </div>
                    </div>
                    <!-- Card 3: Validation Passed -->
                    <div class="bg-surface-container-lowest p-space-md rounded-xl shadow-sm flex flex-col justify-between min-h-[128px]">
                        <div class="flex items-center justify-between">
                            <span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Passed</span>
                            <span class="p-1 rounded bg-surface-container text-primary-container"><span class="material-symbols-outlined text-[16px]">verified</span></span>
                        </div>
                        <div>
                            <div class="flex items-baseline gap-space-xs">
                                <span class="font-headline-xl text-headline-xl text-primary-container font-bold leading-none">29</span>
                                <span class="font-label-sm text-label-sm text-primary font-semibold">60.4%</span>
                            </div>
                            <p class="font-body-sm text-body-sm text-on-surface-variant mt-1 truncate">Total compliance rate</p>
                        </div>
                    </div>
                    <!-- Card 4: Validation Failed -->
                    <div class="bg-surface-container-lowest p-space-md rounded-xl shadow-sm flex flex-col justify-between min-h-[128px]">
                        <div class="flex items-center justify-between">
                            <span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Failed Gate</span>
                            <span class="p-1 rounded bg-error-container text-on-error-container"><span class="material-symbols-outlined text-[16px]">block</span></span>
                        </div>
                        <div>
                            <div class="flex items-baseline gap-space-xs">
                                <span class="font-headline-xl text-headline-xl text-error font-bold leading-none">12</span>
                                <span class="font-label-sm text-label-sm text-error">Contract fail</span>
                            </div>
                            <p class="font-body-sm text-body-sm text-on-surface-variant mt-1 truncate">Blocked at edge check</p>
                        </div>
                    </div>
                    <!-- Card 5: Eligible for Deployment -->
                    <div class="bg-surface-container-lowest p-space-md rounded-xl shadow-sm flex flex-col justify-between min-h-[128px]">
                        <div class="flex items-center justify-between">
                            <span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Eligible</span>
                            <span class="p-1 rounded bg-tertiary-fixed text-on-tertiary-fixed"><span class="material-symbols-outlined text-[16px]">check_circle</span></span>
                        </div>
                        <div>
                            <div class="flex items-baseline gap-space-xs">
                                <span class="font-headline-xl text-headline-xl text-on-tertiary-container font-bold leading-none">18</span>
                                <span class="font-code-sm text-code-sm text-on-surface-variant">10/10 tests</span>
                            </div>
                            <p class="font-body-sm text-body-sm text-on-surface-variant mt-1 truncate">Deployment certified</p>
                        </div>
                    </div>
                    <!-- Card 6: Currently Deployed -->
                    <div class="bg-surface-container-lowest p-space-md rounded-xl shadow-sm flex flex-col justify-between min-h-[128px]">
                        <div class="flex items-center justify-between">
                            <span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Active Endpoints</span>
                            <span class="p-1 rounded bg-secondary-fixed text-primary"><span class="material-symbols-outlined text-[16px]">hub</span></span>
                        </div>
                        <div>
                            <div class="flex items-baseline gap-space-xs">
                                <span class="font-headline-xl text-headline-xl text-primary font-bold leading-none">9</span>
                                <span class="font-label-sm text-label-sm text-on-surface-variant font-medium">2 Prod</span>
                            </div>
                            <p class="font-body-sm text-body-sm text-on-surface-variant mt-1 truncate">7 Staging / Canary</p>
                        </div>
                    </div>
                    <!-- Card 7: Models Requiring Attention -->
                    <div class="bg-surface-container-lowest p-space-md rounded-xl shadow-sm flex flex-col justify-between min-h-[128px]">
                        <div class="flex items-center justify-between">
                            <span class="font-label-sm text-label-sm text-on-tertiary-container uppercase tracking-wider font-bold">Needs Review</span>
                            <span class="p-1 rounded bg-tertiary-fixed text-tertiary-container"><span class="material-symbols-outlined text-[16px]">notification_important</span></span>
                        </div>
                        <div>
                            <div class="flex items-baseline gap-space-xs">
                                <span class="font-headline-xl text-headline-xl text-tertiary font-bold leading-none">5</span>
                                <span class="font-code-sm text-code-sm text-error font-semibold">&gt;120ms</span>
                            </div>
                            <p class="font-body-sm text-body-sm text-on-surface-variant mt-1 truncate">Drift &amp; stale sign-off</p>
                        </div>
                    </div>
                </div>
                <!-- Operational Lifecycle & Distribution Split -->
                <div class="grid grid-cols-1 xl:grid-cols-12 gap-space-lg items-start">
                    <!-- Left Panel (60%): Recent Validation & Deployment Runs Interactive Table -->
                    <div class="xl:col-span-7 bg-surface-container-lowest rounded-xl shadow-sm flex flex-col overflow-hidden">
                        <!-- Section Header -->
                        <div class="p-space-lg bg-surface-container-low/60 flex flex-col sm:flex-row sm:items-center justify-between gap-space-sm">
                            <div class="flex items-center gap-space-sm">
                                <div class="w-2.5 h-2.5 rounded-full bg-primary-container"></div>
                                <div>
                                    <h2 class="font-headline-sm text-headline-sm text-primary tracking-tight">Recent Validation &amp; Deployment Runs</h2>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant">Live telemetry stream across active student ticket pipelines</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-space-xs">
                                <div class="relative">
                                    <input class="h-8 pl-8 pr-3 text-body-sm font-body-sm bg-surface-container-lowest rounded text-on-surface placeholder:text-outline focus:outline-none focus:ring-1 focus:ring-primary-container w-44" placeholder="Filter runs or tickets..." type="text" />
                                    <span class="material-symbols-outlined absolute left-2 top-2 text-[16px] text-outline">search</span>
                                </div>
                                <button class="h-8 px-2.5 bg-surface-container text-on-surface font-label-sm text-label-sm rounded hover:bg-surface-container-high transition-colors flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px]">tune</span>
                                    <span>Filters</span>
                                </button>
                            </div>
                        </div>
                        <!-- Table Container -->
                        <div class="w-full overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-surface-container text-on-surface-variant font-label-sm text-label-sm uppercase">
                                        <th class="py-2.5 px-3">Model / Version</th>
                                        <th class="py-2.5 px-3">Scenario / Ticket</th>
                                        <th class="py-2.5 px-3">Framework</th>
                                        <th class="py-2.5 px-3">Automated Check</th>
                                        <th class="py-2.5 px-3">Instructor Sign-Off</th>
                                        <th class="py-2.5 px-3">Stage</th>
                                        <th class="py-2.5 px-3 text-right">Time &amp; Operator</th>
                                        <th class="py-2.5 px-3 text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-surface-container-highest font-body-sm text-body-sm">
                                    <!-- Row 1 -->
                                    <tr class="hover:bg-surface-container-low transition-colors group">
                                        <td class="py-3 px-3">
                                            <div class="flex flex-col">
                                                <span class="font-headline-sm text-body-md text-primary font-semibold">churn-xgb-classifier</span>
                                                <span class="font-code-sm text-code-sm text-on-surface-variant">v2.4.1 (SHA-88ef4a)</span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-3">
                                            <div class="flex flex-col">
                                                <span class="text-on-surface font-medium">Predictive AI - Churn</span>
                                                <span class="font-code-sm text-code-sm text-secondary font-semibold">VP-TKT-1082</span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-3">
                                            <span class="px-2 py-0.5 rounded bg-surface-container font-code-sm text-code-sm text-on-surface-variant">XGBoost 1.7.5</span>
                                        </td>
                                        <td class="py-3 px-3">
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-surface-container text-primary font-code-sm text-code-sm font-semibold">
                                                <span class="material-symbols-outlined text-[14px] text-primary">check_circle</span>
                                                10/10 Passed
                                            </span>
                                        </td>
                                        <td class="py-3 px-3">
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-tertiary-fixed text-on-tertiary-fixed font-label-sm text-label-sm font-semibold">
                                                <span class="material-symbols-outlined text-[12px]">verified_user</span>
                                                Approved (Petrov)
                                            </span>
                                        </td>
                                        <td class="py-3 px-3">
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-primary-fixed text-on-primary-fixed-variant font-code-sm text-code-sm font-semibold">
                                                <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse"></span>
                                                Staging v1.4
                                            </span>
                                        </td>
                                        <td class="py-3 px-3 text-right font-code-sm text-code-sm">
                                            <div class="text-on-surface">12m ago</div>
                                            <div class="text-outline">Cadet Vance</div>
                                        </td>
                                        <td class="py-3 px-3 text-right">
                                            <button class="h-7 px-2 bg-surface-container text-primary rounded font-label-sm text-label-sm hover:bg-primary hover:text-on-primary transition-colors">
                                                Inspect
                                            </button>
                                        </td>
                                    </tr>
                                    <!-- Row 2 -->
                                    <tr class="hover:bg-surface-container-low transition-colors group">
                                        <td class="py-3 px-3">
                                            <div class="flex flex-col">
                                                <span class="font-headline-sm text-body-md text-primary font-semibold">defect-yolo-seg</span>
                                                <span class="font-code-sm text-code-sm text-on-surface-variant">v1.8.0 (SHA-d401ac)</span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-3">
                                            <div class="flex flex-col">
                                                <span class="text-on-surface font-medium">CV Manufacturing</span>
                                                <span class="font-code-sm text-code-sm text-secondary font-semibold">VP-TKT-1090</span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-3">
                                            <span class="px-2 py-0.5 rounded bg-surface-container font-code-sm text-code-sm text-on-surface-variant">PyTorch 2.1.2</span>
                                        </td>
                                        <td class="py-3 px-3">
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-tertiary-fixed text-on-tertiary-fixed-variant font-code-sm text-code-sm font-semibold">
                                                <span class="material-symbols-outlined text-[14px]">warning</span>
                                                9/10 Warning
                                            </span>
                                        </td>
                                        <td class="py-3 px-3">
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-surface-container text-on-surface-variant font-label-sm text-label-sm font-medium">
                                                <span class="material-symbols-outlined text-[12px]">schedule</span>
                                                Pending Review
                                            </span>
                                        </td>
                                        <td class="py-3 px-3">
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-surface-container font-code-sm text-code-sm text-on-surface-variant font-medium">
                                                Staging Ready
                                            </span>
                                        </td>
                                        <td class="py-3 px-3 text-right font-code-sm text-code-sm">
                                            <div class="text-on-surface">1h ago</div>
                                            <div class="text-outline">Cadet Miller</div>
                                        </td>
                                        <td class="py-3 px-3 text-right">
                                            <button class="h-7 px-2 bg-surface-container text-primary rounded font-label-sm text-label-sm hover:bg-primary hover:text-on-primary transition-colors">
                                                Inspect
                                            </button>
                                        </td>
                                    </tr>
                                    <!-- Row 3 -->
                                    <tr class="hover:bg-surface-container-low transition-colors group">
                                        <td class="py-3 px-3">
                                            <div class="flex flex-col">
                                                <span class="font-headline-sm text-body-md text-primary font-semibold">complaint-bert-nlp</span>
                                                <span class="font-code-sm text-code-sm text-on-surface-variant">v3.0.2 (SHA-43c98b)</span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-3">
                                            <div class="flex flex-col">
                                                <span class="text-on-surface font-medium">NLP Complaint Class.</span>
                                                <span class="font-code-sm text-code-sm text-secondary font-semibold">VP-TKT-1079</span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-3">
                                            <span class="px-2 py-0.5 rounded bg-surface-container font-code-sm text-code-sm text-on-surface-variant">HF Transf. 4.35</span>
                                        </td>
                                        <td class="py-3 px-3">
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-error-container text-on-error-container font-code-sm text-code-sm font-semibold">
                                                <span class="material-symbols-outlined text-[14px]">error</span>
                                                7/10 Schema Fail
                                            </span>
                                        </td>
                                        <td class="py-3 px-3">
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-error-container text-on-error-container font-label-sm text-label-sm font-semibold">
                                                <span class="material-symbols-outlined text-[12px]">cancel</span>
                                                Changes Req.
                                            </span>
                                        </td>
                                        <td class="py-3 px-3">
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-error-container text-error font-code-sm text-code-sm font-bold">
                                                Gate Blocked
                                            </span>
                                        </td>
                                        <td class="py-3 px-3 text-right font-code-sm text-code-sm">
                                            <div class="text-on-surface">3h ago</div>
                                            <div class="text-outline">Cadet Thorne</div>
                                        </td>
                                        <td class="py-3 px-3 text-right">
                                            <button class="h-7 px-2 bg-error-container text-on-error-container rounded font-label-sm text-label-sm hover:bg-error hover:text-on-error transition-colors">
                                                Review Logs
                                            </button>
                                        </td>
                                    </tr>
                                    <!-- Row 4 -->
                                    <tr class="hover:bg-surface-container-low transition-colors group">
                                        <td class="py-3 px-3">
                                            <div class="flex flex-col">
                                                <span class="font-headline-sm text-body-md text-primary font-semibold">fraud-isoforest-detector</span>
                                                <span class="font-code-sm text-code-sm text-on-surface-variant">v1.2.0 (SHA-78a34d)</span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-3">
                                            <div class="flex flex-col">
                                                <span class="text-on-surface font-medium">Fraud Detection Net</span>
                                                <span class="font-code-sm text-code-sm text-secondary font-semibold">VP-TKT-1084</span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-3">
                                            <span class="px-2 py-0.5 rounded bg-surface-container font-code-sm text-code-sm text-on-surface-variant">Scikit-learn 1.3</span>
                                        </td>
                                        <td class="py-3 px-3">
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-surface-container text-primary font-code-sm text-code-sm font-semibold">
                                                <span class="material-symbols-outlined text-[14px]">check_circle</span>
                                                10/10 Passed
                                            </span>
                                        </td>
                                        <td class="py-3 px-3">
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-tertiary-fixed text-on-tertiary-fixed font-label-sm text-label-sm font-semibold">
                                                <span class="material-symbols-outlined text-[12px]">verified_user</span>
                                                Approved
                                            </span>
                                        </td>
                                        <td class="py-3 px-3">
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-secondary-fixed text-on-secondary-fixed font-code-sm text-code-sm font-bold">
                                                Canary 20%
                                            </span>
                                        </td>
                                        <td class="py-3 px-3 text-right font-code-sm text-code-sm">
                                            <div class="text-on-surface">5h ago</div>
                                            <div class="text-outline">Cadet Vance</div>
                                        </td>
                                        <td class="py-3 px-3 text-right">
                                            <button class="h-7 px-2 bg-surface-container text-primary rounded font-label-sm text-label-sm hover:bg-primary hover:text-on-primary transition-colors">
                                                Inspect
                                            </button>
                                        </td>
                                    </tr>
                                    <!-- Row 5 -->
                                    <tr class="hover:bg-surface-container-low transition-colors group">
                                        <td class="py-3 px-3">
                                            <div class="flex flex-col">
                                                <span class="font-headline-sm text-body-md text-primary font-semibold">hr-rag-embedding-rerank</span>
                                                <span class="font-code-sm text-code-sm text-on-surface-variant">v2.1.0 (SHA-1a559e)</span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-3">
                                            <div class="flex flex-col">
                                                <span class="text-on-surface font-medium">GenAI HR Assistant</span>
                                                <span class="font-code-sm text-code-sm text-secondary font-semibold">VP-TKT-1087</span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-3">
                                            <span class="px-2 py-0.5 rounded bg-surface-container font-code-sm text-code-sm text-on-surface-variant">LangChain / FAISS</span>
                                        </td>
                                        <td class="py-3 px-3">
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-surface-container text-primary font-code-sm text-code-sm font-semibold">
                                                <span class="material-symbols-outlined text-[14px]">check_circle</span>
                                                10/10 Passed
                                            </span>
                                        </td>
                                        <td class="py-3 px-3">
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-surface-container text-on-surface-variant font-label-sm text-label-sm font-medium">
                                                <span class="material-symbols-outlined text-[12px]">pending</span>
                                                Pending Sign-off
                                            </span>
                                        </td>
                                        <td class="py-3 px-3">
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-surface-container font-code-sm text-code-sm text-on-surface font-medium">
                                                Eligible
                                            </span>
                                        </td>
                                        <td class="py-3 px-3 text-right font-code-sm text-code-sm">
                                            <div class="text-on-surface">1d ago</div>
                                            <div class="text-outline">Cadet Zhang</div>
                                        </td>
                                        <td class="py-3 px-3 text-right">
                                            <button class="h-7 px-2 bg-surface-container text-primary rounded font-label-sm text-label-sm hover:bg-primary hover:text-on-primary transition-colors">
                                                Inspect
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- Pagination / Footer Bar -->
                        <div class="p-space-md bg-surface-container-low/40 flex items-center justify-between text-body-sm font-body-sm text-on-surface-variant">
                            <span>Showing 5 of 48 registered model pipelines</span>
                            <div class="flex items-center gap-1">
                                <button class="w-7 h-7 flex items-center justify-center rounded bg-surface-container text-on-surface hover:bg-surface-container-high transition-colors" disabled=""><span class="material-symbols-outlined text-[16px]">chevron_left</span></button>
                                <span class="px-2 font-code-sm text-code-sm font-semibold text-primary">1 / 10</span>
                                <button class="w-7 h-7 flex items-center justify-center rounded bg-surface-container text-on-surface hover:bg-surface-container-high transition-colors"><span class="material-symbols-outlined text-[16px]">chevron_right</span></button>
                            </div>
                        </div>
                    </div>
                    <!-- Right Panel (40%): Validation Gate Velocity & Diagnostics -->
                    <div class="xl:col-span-5 flex flex-col gap-space-lg">
                        <!-- Bottleneck Diagnostic Card -->
                        <div class="bg-surface-container-lowest p-space-lg rounded-xl shadow-sm flex flex-col gap-space-md">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-primary-container text-[20px]">troubleshoot</span>
                                    <h3 class="font-headline-sm text-headline-sm text-primary">Validation Gate Failure Diagnostics</h3>
                                </div>
                                <span class="font-code-sm text-code-sm px-1.5 py-0.5 rounded bg-surface-container text-on-surface-variant">12 REJECTIONS</span>
                            </div>
                            <p class="font-body-sm text-body-sm text-on-surface-variant">
                                Automated failure causes logged during gate execution across active scenarios over the last 72 hours.
                            </p>
                            <!-- Failure Breakdown Visual Bar -->
                            <div class="flex flex-col gap-space-xs pt-1">
                                <div class="h-3 w-full bg-surface-container-high rounded-full overflow-hidden flex shadow-inner">
                                    <div class="bg-primary-container h-full" style="width: 35%" title="Schema Validation (35%)"></div>
                                    <div class="bg-secondary h-full" style="width: 25%" title="Smoke Test (25%)"></div>
                                    <div class="bg-on-tertiary-container h-full" style="width: 20%" title="Business Threshold (20%)"></div>
                                    <div class="bg-outline h-full" style="width: 20%" title="Dependency Conflicts (20%)"></div>
                                </div>
                                <div class="grid grid-cols-2 gap-y-2 gap-x-4 pt-2">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2.5 h-2.5 rounded-full bg-primary-container"></span>
                                        <div class="flex flex-col">
                                            <span class="font-label-sm text-label-sm text-on-surface">Schema Mismatch</span>
                                            <span class="font-code-sm text-code-sm text-on-surface-variant">35% (7 runs)</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="w-2.5 h-2.5 rounded-full bg-secondary"></span>
                                        <div class="flex flex-col">
                                            <span class="font-label-sm text-label-sm text-on-surface">Prediction Smoke Fail</span>
                                            <span class="font-code-sm text-code-sm text-on-surface-variant">25% (5 runs)</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="w-2.5 h-2.5 rounded-full bg-on-tertiary-container"></span>
                                        <div class="flex flex-col">
                                            <span class="font-label-sm text-label-sm text-on-surface">Metric Threshold</span>
                                            <span class="font-code-sm text-code-sm text-on-surface-variant">20% (4 runs)</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="w-2.5 h-2.5 rounded-full bg-outline"></span>
                                        <div class="flex flex-col">
                                            <span class="font-label-sm text-label-sm text-on-surface">Dependency Conflict</span>
                                            <span class="font-code-sm text-code-sm text-on-surface-variant">20% (4 runs)</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Inline SVG Sparkline: Velocity Trend -->
                            <div class="p-space-sm bg-surface-container-low rounded-lg flex flex-col gap-1 mt-2">
                                <div class="flex items-center justify-between font-label-sm text-label-sm text-on-surface-variant">
                                    <span>Pass/Fail Ratio Trend (Last 7 Days)</span>
                                    <span class="font-code-sm text-code-sm text-primary font-bold">Avg 2.4m gate runtime</span>
                                </div>
                                <svg class="w-full h-12 text-primary-container" fill="none" preserveaspectratio="none" viewbox="0 0 300 40">
                                    <path d="M0,32 Q30,10 60,20 T120,15 T180,28 T240,8 T300,12" fill="none" stroke="currentColor" stroke-width="2.5"></path>
                                    <path d="M0,32 Q30,10 60,20 T120,15 T180,28 T240,8 T300,12 L300,40 L0,40 Z" fill="currentColor" fill-opacity="0.08"></path>
                                </svg>
                            </div>
                        </div>
                        <!-- Linked Tickets Drawer: Scenario Criteria from SYS-AI-01 -->
                        <div class="bg-surface-container-lowest p-space-lg rounded-xl shadow-sm flex flex-col gap-space-md">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-secondary text-[20px]">assignment_turned_in</span>
                                    <h3 class="font-headline-sm text-headline-sm text-primary">Scenario Criteria &amp; Targets</h3>
                                </div>
                                <a class="font-label-sm text-label-sm text-primary hover:underline font-semibold" href="#">SYS-AI-01 Specs →</a>
                            </div>
                            <div class="flex flex-col gap-space-sm">
                                <!-- Item 1: Churn Ticket -->
                                <div class="p-space-md bg-surface-container-low rounded-lg flex flex-col gap-1 hover:bg-surface-container transition-colors">
                                    <div class="flex items-center justify-between">
                                        <span class="font-code-sm text-code-sm font-bold text-primary">VP-TKT-1082: Churn Baseline v2</span>
                                        <span class="font-label-sm text-label-sm px-1.5 py-0.5 rounded bg-tertiary-fixed text-on-tertiary-fixed font-semibold">Active Canary</span>
                                    </div>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant">Thresholds: ROC-AUC ≥ 0.840 • P95 Latency ≤ 45ms • Zero NaN Drift</p>
                                    <div class="flex items-center gap-4 text-code-sm font-code-sm text-primary-container pt-1">
                                        <span>Achieved: 0.862</span>
                                        <span>Latency: 38ms</span>
                                        <span class="font-bold text-on-surface">Target Met ✓</span>
                                    </div>
                                </div>
                                <!-- Item 2: Defect YOLO Ticket -->
                                <div class="p-space-md bg-surface-container-low rounded-lg flex flex-col gap-1 hover:bg-surface-container transition-colors">
                                    <div class="flex items-center justify-between">
                                        <span class="font-code-sm text-code-sm font-bold text-primary">VP-TKT-1090: CV Defect Segmentation</span>
                                        <span class="font-label-sm text-label-sm px-1.5 py-0.5 rounded bg-surface-container-high text-on-surface-variant font-semibold">Under Gate</span>
                                    </div>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant">Thresholds: mAP@50 ≥ 0.780 • Edge Inference ≤ 80ms • CUDA FP16</p>
                                    <div class="flex items-center gap-4 text-code-sm font-code-sm text-primary-container pt-1">
                                        <span>Achieved: 0.791</span>
                                        <span>Latency: 74ms</span>
                                        <span class="text-tertiary-container font-medium">Pending Sign-off</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Recent Model Commit Diff Stream -->
                            <div class="pt-2 flex flex-col gap-space-xs">
                                <span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Recent Artifact Hashes</span>
                                <div class="flex flex-col gap-1.5 font-code-sm text-code-sm">
                                    <div class="flex items-center justify-between p-1.5 bg-surface-container-low/60 rounded">
                                        <span class="text-primary font-semibold truncate">churn-xgb-v2.4.1.onnx</span>
                                        <span class="text-outline">sha256:88ef4a...</span>
                                    </div>
                                    <div class="flex items-center justify-between p-1.5 bg-surface-container-low/60 rounded">
                                        <span class="text-primary font-semibold truncate">yolo-seg-best.pt</span>
                                        <span class="text-outline">sha256:d401ac...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Telemetry Laboratory Footer Status Banner -->
                <div class="p-space-md bg-surface-container-lowest rounded-xl shadow-sm flex flex-col sm:flex-row items-center justify-between gap-space-sm font-code-sm text-code-sm text-on-surface-variant">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-primary animate-ping"></span>
                        <span class="font-semibold text-primary">VOSTOKPRIBOR ORBIT-ML ENGINE:</span>
                        <span>Automated Validation Dispatcher operational on Cluster Pod #04</span>
                    </div>
                    <div class="flex items-center gap-4">
                        <span>Worker Threads: 16/16</span>
                        <span>Queue Backlog: 7 Jobs</span>
                        <span class="text-primary font-semibold">LATENCY: 14ms (P99)</span>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="js/main.js"></script>
</body>

</html>