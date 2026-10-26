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
            <nav class="flex flex-col gap-1 px-space-md py-space-sm" data-active-classes="bg-primary-container text-on-primary font-bold rounded-lg shadow-sm"><a class="flex items-center gap-space-md px-space-md py-2.5 rounded-lg text-on-surface-variant font-label-md text-label-md hover:bg-surface-container-high hover:text-on-surface transition-colors" data-path="dashboard" href="dashboard.php"><span class="material-symbols-outlined text-[20px]">dashboard</span><span>Dashboard</span></a><a class="flex items-center gap-space-md px-space-md py-2.5 rounded-lg text-on-surface-variant font-label-md text-label-md hover:bg-surface-container-high hover:text-on-surface transition-colors" data-path="model-registry" href="ModelRegistry.php"><span class="material-symbols-outlined text-[20px]">inventory_2</span><span>Model Registry</span></a><a aria-current="page" class="flex items-center gap-space-md px-space-md py-2.5 transition-colors bg-primary-container text-on-primary font-bold rounded-lg shadow-sm" data-path="automated-validation-pipeline" href="ValidationPipeline.php"><span class="material-symbols-outlined text-[20px]">fact_check</span><span>Validation Pipeline</span></a><a class="flex items-center gap-space-md px-space-md py-2.5 rounded-lg text-on-surface-variant font-label-md text-label-md hover:bg-surface-container-high hover:text-on-surface transition-colors" data-path="deployment-configuration" href="DeploymentConfig.php"><span class="material-symbols-outlined text-[20px]">settings_input_component</span><span>Deployment Config</span></a><a class="flex items-center gap-space-md px-space-md py-2.5 rounded-lg text-on-surface-variant font-label-md text-label-md hover:bg-surface-container-high hover:text-on-surface transition-colors" data-path="deployed-endpoints" href="DeployedEndpoints.php"><span class="material-symbols-outlined text-[20px]">cell_tower</span><span>Deployed Endpoints</span></a><a class="flex items-center gap-space-md px-space-md py-2.5 rounded-lg text-on-surface-variant font-label-md text-label-md hover:bg-surface-container-high hover:text-on-surface transition-colors" data-path="validation-reports" href="ValidationReports.php"><span class="material-symbols-outlined text-[20px]">description</span><span>Validation Reports</span></a></nav>
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
            <div class="flex flex-col w-full">
                <!-- Top Command & Status Bar -->
                <div class="flex flex-col gap-space-md mb-space-lg">
                    <!-- Breadcrumb & Pipeline ID Sub-Header -->
                    <div class="flex flex-wrap items-center justify-between gap-space-md">
                        <div class="flex items-center gap-space-sm">
                            <span class="font-code-sm text-code-sm text-on-surface-variant uppercase tracking-wider">PIPELINE RUN #VAL-2024-884-A</span>
                            <span class="text-outline-variant font-code-sm text-code-sm">/</span>
                            <span class="font-code-sm text-code-sm text-primary font-semibold">STAGE 04_AUTOMATED_HARNESS</span>
                            <span class="text-outline-variant font-code-sm text-code-sm">/</span>
                            <span class="font-label-sm text-label-sm px-space-xs py-0.5 rounded bg-surface-container-high text-on-surface">CLUSTER POD #04</span>
                        </div>
                        <div class="flex items-center gap-space-sm">
                            <span class="inline-flex items-center gap-1.5 px-space-md py-1 rounded-full bg-surface-container-lowest shadow-sm">
                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-600 animate-pulse"></span>
                                <span class="font-label-sm text-label-sm text-primary font-bold">10 / 10 CHECKS VERIFIED (100%)</span>
                            </span>
                            <span class="font-code-sm text-code-sm px-space-sm py-1 rounded bg-secondary-fixed text-on-secondary-fixed font-medium">TOTAL RUNTIME: 4m 18s</span>
                        </div>
                    </div>
                    <!-- Main Header Card -->
                    <div class="p-space-lg rounded-xl bg-surface-container-lowest shadow-sm flex flex-col xl:flex-row xl:items-center justify-between gap-space-lg">
                        <div class="flex flex-col gap-space-xs">
                            <div class="flex flex-wrap items-center gap-space-md">
                                <h1 class="font-headline-lg text-headline-lg text-primary tracking-tight">Automated Validation Pipeline Harness</h1>
                                <span class="inline-flex items-center gap-1 px-space-sm py-0.5 rounded bg-tertiary-fixed text-on-tertiary-fixed font-label-sm text-label-sm font-semibold uppercase">
                                    <span class="material-symbols-outlined text-[14px]">verified</span>
                                    Staging Clearance
                                </span>
                            </div>
                            <p class="font-body-md text-body-md text-on-surface-variant">
                                Complete deterministic verification suite for candidate models prior to production deployment gate approval.
                            </p>
                            <!-- Model Context Sub-Bar -->
                            <div class="flex flex-wrap items-center gap-x-space-lg gap-y-1 pt-space-xs text-on-surface-variant font-body-sm text-body-sm">
                                <div class="flex items-center gap-1.5">
                                    <span class="font-label-sm text-label-sm uppercase text-outline">Candidate Model:</span>
                                    <span class="font-code-sm text-code-sm text-primary font-bold bg-surface-container-low px-1.5 py-0.5 rounded">vp-mod-churn-xgb (v2.4.1)</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="font-label-sm text-label-sm uppercase text-outline">Author:</span>
                                    <span class="font-label-md text-label-md text-on-surface font-medium">Cadet E. Vance (VP-8820)</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="font-label-sm text-label-sm uppercase text-outline">Scenario:</span>
                                    <span class="font-label-md text-label-md text-on-surface">Predictive AI — Customer Churn (VP-TKT-1082)</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="font-label-sm text-label-sm uppercase text-outline">Target Tier:</span>
                                    <span class="font-code-sm text-code-sm text-on-primary-fixed-variant font-semibold">Enterprise Staging</span>
                                </div>
                            </div>
                        </div>
                        <!-- Header Actions -->
                        <div class="flex flex-wrap items-center gap-space-sm shrink-0">
                            <button class="h-8 px-space-md rounded bg-surface-container-high hover:bg-surface-container-highest text-primary font-label-md text-label-md font-semibold transition-colors flex items-center gap-1.5" id="btn-rerun">
                                <span class="material-symbols-outlined text-[16px]">refresh</span>
                                <span>Re-run Full Pipeline</span>
                            </button>
                            <button class="h-8 px-space-md rounded bg-surface-container-low hover:bg-surface-container text-on-secondary-container font-label-md text-label-md font-semibold transition-colors flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-[16px]">download</span>
                                <span>Audit Certificate</span>
                            </button>
                            <button class="h-8 px-space-md rounded bg-surface-container-low hover:bg-surface-container text-on-secondary-container font-label-md text-label-md font-semibold transition-colors flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-[16px]">data_object</span>
                                <span>Export Bundle (.json)</span>
                            </button>
                            <button class="h-8 px-space-lg rounded bg-primary-container hover:bg-primary text-on-primary font-label-md text-label-md font-bold transition-colors flex items-center gap-1.5 shadow-sm">
                                <span class="material-symbols-outlined text-[16px]">approval_delegation</span>
                                <span>Submit for Instructor Sign-Off</span>
                            </button>
                        </div>
                    </div>
                    <!-- Eligibility Banner -->
                    <div class="p-space-md rounded-xl bg-gradient-to-r from-emerald-50 via-surface-container-lowest to-surface-container-low shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-space-md">
                        <div class="flex items-center gap-space-md">
                            <div class="w-10 h-10 rounded-lg bg-emerald-600 flex items-center justify-center shrink-0 shadow-sm">
                                <span class="material-symbols-outlined text-white text-[24px]">verified</span>
                            </div>
                            <div class="flex flex-col">
                                <div class="flex items-center gap-space-sm">
                                    <span class="font-headline-sm text-headline-sm text-emerald-950 font-bold">ELIGIBLE FOR INSTRUCTOR REVIEW</span>
                                    <span class="font-label-sm text-label-sm px-2 py-0.5 rounded bg-emerald-200 text-emerald-900 font-bold uppercase">10 / 10 CHECKS PASSED</span>
                                </div>
                                <span class="font-body-sm text-body-sm text-emerald-800">
                                    All deterministic safety barriers, cryptographic integrity tests, schema checks, and baseline SLA metrics are compliant.
                                </span>
                            </div>
                        </div>
                        <div class="flex items-center gap-space-md shrink-0">
                            <div class="flex flex-col text-right">
                                <span class="font-label-sm text-label-sm text-outline uppercase font-semibold">Consensus Hash</span>
                                <span class="font-code-sm text-code-sm text-primary font-bold">SHA256: 7d2e8b...f91a</span>
                            </div>
                            <div class="w-9 h-9 rounded bg-surface-container-high flex items-center justify-center text-primary">
                                <span class="material-symbols-outlined text-[20px]">lock</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Metric Telemetry Grid -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-space-md mb-space-lg">
                    <!-- Telemetry Card 1 -->
                    <div class="p-space-md rounded-xl bg-surface-container-lowest shadow-sm flex flex-col justify-between">
                        <div class="flex items-center justify-between text-on-surface-variant mb-space-xs">
                            <span class="font-label-sm text-label-sm uppercase font-semibold">ROC-AUC Target</span>
                            <span class="material-symbols-outlined text-primary text-[18px]">query_stats</span>
                        </div>
                        <div class="flex items-baseline gap-space-sm">
                            <span class="font-headline-xl text-headline-xl text-primary font-bold">0.884</span>
                            <span class="font-code-sm text-code-sm text-emerald-700 font-semibold">&gt;= 0.840 (Req)</span>
                        </div>
                        <div class="w-full bg-surface-container-high h-1.5 rounded-full mt-2 overflow-hidden">
                            <div class="bg-primary-container h-full rounded-full" style="width: 88.4%;"></div>
                        </div>
                        <span class="font-body-sm text-body-sm text-on-surface-variant mt-1.5">+0.044 above acceptance delta</span>
                    </div>
                    <!-- Telemetry Card 2 -->
                    <div class="p-space-md rounded-xl bg-surface-container-lowest shadow-sm flex flex-col justify-between">
                        <div class="flex items-center justify-between text-on-surface-variant mb-space-xs">
                            <span class="font-label-sm text-label-sm uppercase font-semibold">Macro F1-Score</span>
                            <span class="material-symbols-outlined text-primary text-[18px]">balance</span>
                        </div>
                        <div class="flex items-baseline gap-space-sm">
                            <span class="font-headline-xl text-headline-xl text-primary font-bold">0.821</span>
                            <span class="font-code-sm text-code-sm text-emerald-700 font-semibold">&gt;= 0.800 (Req)</span>
                        </div>
                        <div class="w-full bg-surface-container-high h-1.5 rounded-full mt-2 overflow-hidden">
                            <div class="bg-primary-container h-full rounded-full" style="width: 82.1%;"></div>
                        </div>
                        <span class="font-body-sm text-body-sm text-on-surface-variant mt-1.5">Class 1 precision 0.835 / recall 0.808</span>
                    </div>
                    <!-- Telemetry Card 3 -->
                    <div class="p-space-md rounded-xl bg-surface-container-lowest shadow-sm flex flex-col justify-between">
                        <div class="flex items-center justify-between text-on-surface-variant mb-space-xs">
                            <span class="font-label-sm text-label-sm uppercase font-semibold">P95 Inference Latency</span>
                            <span class="material-symbols-outlined text-primary text-[18px]">speed</span>
                        </div>
                        <div class="flex items-baseline gap-space-sm">
                            <span class="font-headline-xl text-headline-xl text-primary font-bold">18.4ms</span>
                            <span class="font-code-sm text-code-sm text-emerald-700 font-semibold">&lt;= 45.0ms (Req)</span>
                        </div>
                        <div class="w-full bg-surface-container-high h-1.5 rounded-full mt-2 overflow-hidden">
                            <div class="bg-emerald-600 h-full rounded-full" style="width: 41%;"></div>
                        </div>
                        <span class="font-body-sm text-body-sm text-on-surface-variant mt-1.5">Warm cache latency: 12.1ms (P50)</span>
                    </div>
                    <!-- Telemetry Card 4 -->
                    <div class="p-space-md rounded-xl bg-surface-container-lowest shadow-sm flex flex-col justify-between">
                        <div class="flex items-center justify-between text-on-surface-variant mb-space-xs">
                            <span class="font-label-sm text-label-sm uppercase font-semibold">Robustness Coverage</span>
                            <span class="material-symbols-outlined text-primary text-[18px]">shield</span>
                        </div>
                        <div class="flex items-baseline gap-space-sm">
                            <span class="font-headline-xl text-headline-xl text-primary font-bold">100%</span>
                            <span class="font-code-sm text-code-sm text-emerald-700 font-semibold">250/250 Cases</span>
                        </div>
                        <div class="w-full bg-surface-container-high h-1.5 rounded-full mt-2 overflow-hidden">
                            <div class="bg-primary-container h-full rounded-full" style="width: 100%;"></div>
                        </div>
                        <span class="font-body-sm text-body-sm text-on-surface-variant mt-1.5">0 crashes / zero silent NAN propagates</span>
                    </div>
                </div>
                <!-- Primary Workspace: 10-Step Interactive Pipeline Stepper & Inspector Layout -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-lg items-start">
                    <!-- Left Column: The 10-Step Pipeline Visual Stepper (5 Cols) -->
                    <div class="lg:col-span-5 flex flex-col gap-space-sm">
                        <div class="flex items-center justify-between px-space-xs mb-space-xs">
                            <div class="flex items-center gap-space-sm">
                                <span class="material-symbols-outlined text-primary text-[20px]">checklist</span>
                                <span class="font-headline-sm text-headline-sm text-primary">Validation Harness Matrix</span>
                            </div>
                            <span class="font-code-sm text-code-sm text-on-surface-variant">AUTO-SEQUENCED</span>
                        </div>
                        <!-- Step Cards Container -->
                        <div class="flex flex-col gap-2" id="steps-container">
                            <!-- Step 1 -->
                            <div class="step-card active-step cursor-pointer p-space-md rounded-xl bg-surface-container-lowest shadow-sm hover:shadow-md transition-all flex items-start gap-space-md relative overflow-hidden" data-step="1">
                                <div class="w-1.5 absolute left-0 top-0 bottom-0 bg-primary-container indicator-strip"></div>
                                <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-800 flex items-center justify-center shrink-0 mt-0.5">
                                    <span class="material-symbols-outlined text-[18px]">fact_check</span>
                                </div>
                                <div class="flex flex-col flex-1 min-w-0">
                                    <div class="flex items-center justify-between gap-space-xs">
                                        <span class="font-label-md text-label-md font-bold text-primary truncate">Step 1: Artifact Integrity</span>
                                        <span class="font-label-sm text-label-sm px-2 py-0.5 rounded bg-emerald-50 text-emerald-800 border-none font-bold">PASSED</span>
                                    </div>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant line-clamp-1 mt-0.5">
                                        Verified `model.xgb` (14.2 MB), SHA256 checksum matched, deserialization ok.
                                    </p>
                                    <div class="flex items-center gap-space-md mt-2 font-code-sm text-code-sm text-outline">
                                        <span>SHA256: 3f9a88...c142</span>
                                        <span>•</span>
                                        <span>240ms</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Step 2 -->
                            <div class="step-card cursor-pointer p-space-md rounded-xl bg-surface-container-lowest shadow-sm hover:shadow-md transition-all flex items-start gap-space-md relative overflow-hidden" data-step="2">
                                <div class="w-1.5 absolute left-0 top-0 bottom-0 bg-transparent indicator-strip"></div>
                                <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-800 flex items-center justify-center shrink-0 mt-0.5">
                                    <span class="material-symbols-outlined text-[18px]">badge</span>
                                </div>
                                <div class="flex flex-col flex-1 min-w-0">
                                    <div class="flex items-center justify-between gap-space-xs">
                                        <span class="font-label-md text-label-md font-bold text-on-surface truncate">Step 2: Metadata Validation</span>
                                        <span class="font-label-sm text-label-sm px-2 py-0.5 rounded bg-emerald-50 text-emerald-800 border-none font-bold">PASSED</span>
                                    </div>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant line-clamp-1 mt-0.5">
                                        Model card fields, authors, Apache-2.0 license, hyperparameters &amp; scenario tags.
                                    </p>
                                    <div class="flex items-center gap-space-md mt-2 font-code-sm text-code-sm text-outline">
                                        <span>12 mandatory tags valid</span>
                                        <span>•</span>
                                        <span>42ms</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Step 3 -->
                            <div class="step-card cursor-pointer p-space-md rounded-xl bg-surface-container-lowest shadow-sm hover:shadow-md transition-all flex items-start gap-space-md relative overflow-hidden" data-step="3">
                                <div class="w-1.5 absolute left-0 top-0 bottom-0 bg-transparent indicator-strip"></div>
                                <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-800 flex items-center justify-center shrink-0 mt-0.5">
                                    <span class="material-symbols-outlined text-[18px]">schema</span>
                                </div>
                                <div class="flex flex-col flex-1 min-w-0">
                                    <div class="flex items-center justify-between gap-space-xs">
                                        <span class="font-label-md text-label-md font-bold text-on-surface truncate">Step 3: Schema Validation</span>
                                        <span class="font-label-sm text-label-sm px-2 py-0.5 rounded bg-emerald-50 text-emerald-800 border-none font-bold">PASSED</span>
                                    </div>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant line-clamp-1 mt-0.5">
                                        24 input features (Float32/Int64/One-Hot), zero unknown columns allowed.
                                    </p>
                                    <div class="flex items-center gap-space-md mt-2 font-code-sm text-code-sm text-outline">
                                        <span>24/24 columns mapped</span>
                                        <span>•</span>
                                        <span>68ms</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Step 4 -->
                            <div class="step-card cursor-pointer p-space-md rounded-xl bg-surface-container-lowest shadow-sm hover:shadow-md transition-all flex items-start gap-space-md relative overflow-hidden" data-step="4">
                                <div class="w-1.5 absolute left-0 top-0 bottom-0 bg-transparent indicator-strip"></div>
                                <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-800 flex items-center justify-center shrink-0 mt-0.5">
                                    <span class="material-symbols-outlined text-[18px]">hub</span>
                                </div>
                                <div class="flex flex-col flex-1 min-w-0">
                                    <div class="flex items-center justify-between gap-space-xs">
                                        <span class="font-label-md text-label-md font-bold text-on-surface truncate">Step 4: Dependency Compatibility</span>
                                        <span class="font-label-sm text-label-sm px-2 py-0.5 rounded bg-emerald-50 text-emerald-800 border-none font-bold">PASSED</span>
                                    </div>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant line-clamp-1 mt-0.5">
                                        Py3.10, XGBoost 1.7.5, scikit-learn 1.3.0, NumPy 1.24.3, OpenBLAS dynamic link.
                                    </p>
                                    <div class="flex items-center gap-space-md mt-2 font-code-sm text-code-sm text-outline">
                                        <span>0 binary collisions</span>
                                        <span>•</span>
                                        <span>1.2s</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Step 5 -->
                            <div class="step-card cursor-pointer p-space-md rounded-xl bg-surface-container-lowest shadow-sm hover:shadow-md transition-all flex items-start gap-space-md relative overflow-hidden" data-step="5">
                                <div class="w-1.5 absolute left-0 top-0 bottom-0 bg-transparent indicator-strip"></div>
                                <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-800 flex items-center justify-center shrink-0 mt-0.5">
                                    <span class="material-symbols-outlined text-[18px]">repeat</span>
                                </div>
                                <div class="flex flex-col flex-1 min-w-0">
                                    <div class="flex items-center justify-between gap-space-xs">
                                        <span class="font-label-md text-label-md font-bold text-on-surface truncate">Step 5: Reproducibility Checks</span>
                                        <span class="font-label-sm text-label-sm px-2 py-0.5 rounded bg-emerald-50 text-emerald-800 border-none font-bold">PASSED</span>
                                    </div>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant line-clamp-1 mt-0.5">
                                        Seed 42 replication matched training metrics within 0.001 delta against EXP-884.
                                    </p>
                                    <div class="flex items-center gap-space-md mt-2 font-code-sm text-code-sm text-outline">
                                        <span>Delta &lt; 0.0003</span>
                                        <span>•</span>
                                        <span>18.6s</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Step 6 -->
                            <div class="step-card cursor-pointer p-space-md rounded-xl bg-surface-container-lowest shadow-sm hover:shadow-md transition-all flex items-start gap-space-md relative overflow-hidden" data-step="6">
                                <div class="w-1.5 absolute left-0 top-0 bottom-0 bg-transparent indicator-strip"></div>
                                <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-800 flex items-center justify-center shrink-0 mt-0.5">
                                    <span class="material-symbols-outlined text-[18px]">science</span>
                                </div>
                                <div class="flex flex-col flex-1 min-w-0">
                                    <div class="flex items-center justify-between gap-space-xs">
                                        <span class="font-label-md text-label-md font-bold text-on-surface truncate">Step 6: Prediction Smoke Tests</span>
                                        <span class="font-label-sm text-label-sm px-2 py-0.5 rounded bg-emerald-50 text-emerald-800 border-none font-bold">PASSED</span>
                                    </div>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant line-clamp-1 mt-0.5">
                                        1,000 synthetic baseline test payloads; zero exceptions; P95 response 18.4ms.
                                    </p>
                                    <div class="flex items-center gap-space-md mt-2 font-code-sm text-code-sm text-outline">
                                        <span>1,000/1,000 ok</span>
                                        <span>•</span>
                                        <span>2.4s</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Step 7 -->
                            <div class="step-card cursor-pointer p-space-md rounded-xl bg-surface-container-lowest shadow-sm hover:shadow-md transition-all flex items-start gap-space-md relative overflow-hidden" data-step="7">
                                <div class="w-1.5 absolute left-0 top-0 bottom-0 bg-transparent indicator-strip"></div>
                                <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-800 flex items-center justify-center shrink-0 mt-0.5">
                                    <span class="material-symbols-outlined text-[18px]">bug_report</span>
                                </div>
                                <div class="flex flex-col flex-1 min-w-0">
                                    <div class="flex items-center justify-between gap-space-xs">
                                        <span class="font-label-md text-label-md font-bold text-on-surface truncate">Step 7: Input Edge-Case Tests</span>
                                        <span class="font-label-sm text-label-sm px-2 py-0.5 rounded bg-emerald-50 text-emerald-800 border-none font-bold">PASSED</span>
                                    </div>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant line-clamp-1 mt-0.5">
                                        Injected 250 boundary payloads: extreme outliers, null imputes, unknown categories.
                                    </p>
                                    <div class="flex items-center gap-space-md mt-2 font-code-sm text-code-sm text-outline">
                                        <span>250/250 graceful handling</span>
                                        <span>•</span>
                                        <span>3.1s</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Step 8 -->
                            <div class="step-card cursor-pointer p-space-md rounded-xl bg-surface-container-lowest shadow-sm hover:shadow-md transition-all flex items-start gap-space-md relative overflow-hidden" data-step="8">
                                <div class="w-1.5 absolute left-0 top-0 bottom-0 bg-transparent indicator-strip"></div>
                                <div class="w-8 h-8 rounded-lg bg-tertiary-fixed text-on-tertiary-fixed flex items-center justify-center shrink-0 mt-0.5">
                                    <span class="material-symbols-outlined text-[18px]">military_tech</span>
                                </div>
                                <div class="flex flex-col flex-1 min-w-0">
                                    <div class="flex items-center justify-between gap-space-xs">
                                        <span class="font-label-md text-label-md font-bold text-on-surface truncate">Step 8: Performance Requirement</span>
                                        <span class="font-label-sm text-label-sm px-2 py-0.5 rounded bg-tertiary-fixed text-on-tertiary-fixed border-none font-bold">CRITERIA MET</span>
                                    </div>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant line-clamp-1 mt-0.5">
                                        Ticket VP-TKT-1082: ROC-AUC &gt;= 0.840 (0.884), F1 &gt;= 0.800 (0.821), Latency &lt;= 45ms (22ms).
                                    </p>
                                    <div class="flex items-center gap-space-md mt-2 font-code-sm text-code-sm text-on-tertiary-container font-semibold">
                                        <span>All 3 gates cleared</span>
                                        <span>•</span>
                                        <span>1m 12s</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Step 9 -->
                            <div class="step-card cursor-pointer p-space-md rounded-xl bg-surface-container-lowest shadow-sm hover:shadow-md transition-all flex items-start gap-space-md relative overflow-hidden" data-step="9">
                                <div class="w-1.5 absolute left-0 top-0 bottom-0 bg-transparent indicator-strip"></div>
                                <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-800 flex items-center justify-center shrink-0 mt-0.5">
                                    <span class="material-symbols-outlined text-[18px]">api</span>
                                </div>
                                <div class="flex flex-col flex-1 min-w-0">
                                    <div class="flex items-center justify-between gap-space-xs">
                                        <span class="font-label-md text-label-md font-bold text-on-surface truncate">Step 9: API Contract Tests</span>
                                        <span class="font-label-sm text-label-sm px-2 py-0.5 rounded bg-emerald-50 text-emerald-800 border-none font-bold">PASSED</span>
                                    </div>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant line-clamp-1 mt-0.5">
                                        Endpoint `/v1/predict` + gRPC proto contract validated; 200 OK + ChurnPredictionResponse.
                                    </p>
                                    <div class="flex items-center gap-space-md mt-2 font-code-sm text-code-sm text-outline">
                                        <span>HTTP/2 + REST verified</span>
                                        <span>•</span>
                                        <span>540ms</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Step 10 -->
                            <div class="step-card cursor-pointer p-space-md rounded-xl bg-surface-container-lowest shadow-sm hover:shadow-md transition-all flex items-start gap-space-md relative overflow-hidden" data-step="10">
                                <div class="w-1.5 absolute left-0 top-0 bottom-0 bg-transparent indicator-strip"></div>
                                <div class="w-8 h-8 rounded-lg bg-primary text-on-primary flex items-center justify-center shrink-0 mt-0.5">
                                    <span class="material-symbols-outlined text-[18px]">gavel</span>
                                </div>
                                <div class="flex flex-col flex-1 min-w-0">
                                    <div class="flex items-center justify-between gap-space-xs">
                                        <span class="font-label-md text-label-md font-bold text-on-surface truncate">Step 10: Final Eligibility Decision</span>
                                        <span class="font-label-sm text-label-sm px-2 py-0.5 rounded bg-primary-fixed text-on-primary-fixed border-none font-bold">ELIGIBLE</span>
                                    </div>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant line-clamp-1 mt-0.5">
                                        Synthesized audit manifest generated. Forwarded for instructor sign-off review.
                                    </p>
                                    <div class="flex items-center gap-space-md mt-2 font-code-sm text-code-sm text-primary font-semibold">
                                        <span>Manifest ID: MAN-VP-8820-04</span>
                                        <span>•</span>
                                        <span>120ms</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Right Column: Interactive Test Inspector & Live Terminal Evidence Log (7 Cols) -->
                    <div class="lg:col-span-7 flex flex-col gap-space-md">
                        <!-- Test Inspector Shell -->
                        <div class="p-space-lg rounded-xl bg-surface-container-lowest shadow-sm flex flex-col gap-space-md">
                            <!-- Inspector Header & Navigation Tabs -->
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-space-sm border-b-0 pb-space-xs">
                                <div class="flex items-center gap-space-sm">
                                    <span class="material-symbols-outlined text-primary text-[22px]">terminal</span>
                                    <div class="flex flex-col">
                                        <span class="font-headline-sm text-headline-sm text-primary" id="inspector-step-title">Test Output &amp; Assertion Log</span>
                                        <span class="font-code-sm text-code-sm text-on-surface-variant" id="inspector-step-subtitle">Step 1 Evidence: Artifact Integrity &amp; Checksum</span>
                                    </div>
                                </div>
                                <!-- Inspector Action Icons -->
                                <div class="flex items-center gap-1">
                                    <button class="p-1.5 rounded hover:bg-surface-container text-on-surface-variant hover:text-primary transition-colors" title="Copy Log to Clipboard">
                                        <span class="material-symbols-outlined text-[18px]">content_copy</span>
                                    </button>
                                    <button class="p-1.5 rounded hover:bg-surface-container text-on-surface-variant hover:text-primary transition-colors" title="Expand to Fullscreen">
                                        <span class="material-symbols-outlined text-[18px]">open_in_full</span>
                                    </button>
                                    <span class="px-2 py-0.5 rounded bg-surface-container text-primary font-label-sm text-label-sm font-semibold">VERIFIED PASS</span>
                                </div>
                            </div>
                            <!-- Filter Sub-Tabs -->
                            <div class="flex items-center gap-2 overflow-x-auto pb-1">
                                <button class="tab-btn px-space-md py-1.5 rounded-lg bg-primary-container text-on-primary font-label-md text-label-md font-semibold transition-colors" data-tab="stdout">
                                    Test Output &amp; Assertion Log
                                </button>
                                <button class="tab-btn px-space-md py-1.5 rounded-lg bg-surface-container-low hover:bg-surface-container text-on-surface font-label-md text-label-md transition-colors" data-tab="metrics">
                                    Metric Threshold Proofs
                                </button>
                                <button class="tab-btn px-space-md py-1.5 rounded-lg bg-surface-container-low hover:bg-surface-container text-on-surface font-label-md text-label-md transition-colors" data-tab="payloads">
                                    Input/Output Payloads
                                </button>
                                <button class="tab-btn px-space-md py-1.5 rounded-lg bg-surface-container-low hover:bg-surface-container text-on-surface font-label-md text-label-md transition-colors" data-tab="security">
                                    Security &amp; Container Scan
                                </button>
                            </div>
                            <!-- Terminal / Log Canvas -->
                            <div class="tab-view flex flex-col rounded-xl bg-inverse-surface text-inverse-on-surface p-space-md shadow-inner overflow-hidden font-code-sm text-code-sm" id="tab-content-stdout">
                                <div class="flex items-center justify-between pb-2 mb-2 bg-inverse-surface/80">
                                    <div class="flex items-center gap-2">
                                        <span class="w-3 h-3 rounded-full bg-rose-500/80 inline-block"></span>
                                        <span class="w-3 h-3 rounded-full bg-amber-500/80 inline-block"></span>
                                        <span class="w-3 h-3 rounded-full bg-emerald-500/80 inline-block"></span>
                                        <span class="ml-2 font-code-sm text-code-sm text-slate-400">pytest-runner-harness // node-worker-04b</span>
                                    </div>
                                    <div class="flex items-center gap-space-sm text-slate-400">
                                        <span>UTF-8</span>
                                        <span>POSIX</span>
                                    </div>
                                </div>
                                <!-- Log Content Area -->
                                <div class="flex flex-col gap-1.5 overflow-y-auto max-h-[380px] pr-2 select-text" id="log-body">
                                    <div class="text-slate-400 font-label-sm text-label-sm">[2024-10-24 14:02:11.102] INITIALIZING SUITE: sys_ai_04.validation.pipeline</div>
                                    <div class="text-slate-300">==&gt; Loading target model artifact: /opt/vostok/registry/vp-mod-churn-xgb/v2.4.1/model.xgb</div>
                                    <div class="text-emerald-400 font-semibold">[PASS] Step 1.1: File existence and non-zero byte stream confirmed (14,249,112 bytes).</div>
                                    <div class="text-slate-300">==&gt; Computing Cryptographic Hash (SHA-256 algorithm)...</div>
                                    <div class="text-slate-200 bg-black/30 p-2 rounded">
                                        EXPECTED: 3f9a88c142b67d19e018a3819e992b4512e0947ba941c9a63b0188ef684a0d81<br />
                                        COMPUTED: 3f9a88c142b67d19e018a3819e992b4512e0947ba941c9a63b0188ef684a0d81<br />
                                        STATUS: MATCH_EXACT (Bit-level verification complete)
                                    </div>
                                    <div class="text-emerald-400 font-semibold">[PASS] Step 1.2: Checksum verification succeeded in 184ms.</div>
                                    <div class="text-slate-300">==&gt; Testing xgboost.Booster deserialization in sandbox memory container...</div>
                                    <div class="text-emerald-400 font-semibold">[PASS] Step 1.3: xgboost::Learner successfully initialized in memory. Zero corrupted trees detected (n_estimators=350, max_depth=6).</div>
                                    <div class="text-emerald-400 font-semibold">[PASS] Step 1.4: Deserialization elapsed time 56ms (Budget: &lt; 500ms).</div>
                                    <div class="text-slate-400 font-label-sm text-label-sm pt-2">[2024-10-24 14:02:11.342] STEP 1 ASSERTION COMPLETE: 4 of 4 tests passed without warning.</div>
                                </div>
                            </div>
                            <!-- Metric Proofs Tab (Hidden by default) -->
                            <div class="tab-view hidden flex flex-col gap-space-md" id="tab-content-metrics">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-space-md">
                                    <div class="p-space-md rounded-lg bg-surface-container-low flex flex-col gap-1">
                                        <span class="font-label-sm text-label-sm uppercase text-outline">ROC-AUC Proof</span>
                                        <span class="font-headline-md text-headline-md text-primary font-bold">0.8841</span>
                                        <span class="font-body-sm text-body-sm text-emerald-700">Threshold: &gt;= 0.8400 (Passed +4.41%)</span>
                                    </div>
                                    <div class="p-space-md rounded-lg bg-surface-container-low flex flex-col gap-1">
                                        <span class="font-label-sm text-label-sm uppercase text-outline">Macro F1 Score</span>
                                        <span class="font-headline-md text-headline-md text-primary font-bold">0.8210</span>
                                        <span class="font-body-sm text-body-sm text-emerald-700">Threshold: &gt;= 0.8000 (Passed +2.10%)</span>
                                    </div>
                                    <div class="p-space-md rounded-lg bg-surface-container-low flex flex-col gap-1">
                                        <span class="font-label-sm text-label-sm uppercase text-outline">Inference Latency P95</span>
                                        <span class="font-headline-md text-headline-md text-primary font-bold">18.42 ms</span>
                                        <span class="font-body-sm text-body-sm text-emerald-700">Budget: &lt;= 45.00 ms (Under budget by 26.58ms)</span>
                                    </div>
                                </div>
                                <!-- Synthetic Confusion Matrix Display -->
                                <div class="p-space-md rounded-lg bg-surface-container-low flex flex-col gap-space-sm">
                                    <span class="font-label-md text-label-md font-bold text-primary">Holdout Validation Confusion Matrix (N = 10,000 samples)</span>
                                    <div class="grid grid-cols-2 gap-2 text-center max-w-md">
                                        <div class="p-3 bg-surface-container-lowest rounded shadow-sm">
                                            <span class="font-label-sm text-label-sm text-outline">True Negatives</span>
                                            <p class="font-headline-md text-headline-md text-primary font-bold">7,842</p>
                                            <span class="font-code-sm text-code-sm text-emerald-700">Specificity: 94.1%</span>
                                        </div>
                                        <div class="p-3 bg-surface-container-lowest rounded shadow-sm">
                                            <span class="font-label-sm text-label-sm text-outline">False Positives</span>
                                            <p class="font-headline-md text-headline-md text-on-surface font-bold">491</p>
                                            <span class="font-code-sm text-code-sm text-on-surface-variant">Type I Error: 5.9%</span>
                                        </div>
                                        <div class="p-3 bg-surface-container-lowest rounded shadow-sm">
                                            <span class="font-label-sm text-label-sm text-outline">False Negatives</span>
                                            <p class="font-headline-md text-headline-md text-on-surface font-bold">318</p>
                                            <span class="font-code-sm text-code-sm text-on-surface-variant">Type II Error: 19.1%</span>
                                        </div>
                                        <div class="p-3 bg-surface-container-lowest rounded shadow-sm">
                                            <span class="font-label-sm text-label-sm text-outline">True Positives</span>
                                            <p class="font-headline-md text-headline-md text-primary font-bold">1,349</p>
                                            <span class="font-code-sm text-code-sm text-emerald-700">Sensitivity: 80.9%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Payloads Tab (Hidden by default) -->
                            <div class="tab-view hidden flex flex-col gap-space-md" id="tab-content-payloads">
                                <div class="p-space-md rounded-lg bg-surface-container-low flex flex-col gap-2">
                                    <span class="font-label-md text-label-md font-bold text-primary">Test Payload Sample [Payload ID: #SYNTH-0492]</span>
                                    <pre class="bg-surface-container-lowest p-space-md rounded text-on-surface font-code-sm text-code-sm overflow-x-auto"><code>{
  "features": {
    "account_tenure_months": 38,
    "contract_type": "month-to-month",
    "monthly_charges": 89.45,
    "total_charges": 3399.10,
    "payment_method": "electronic_check",
    "paperless_billing": 1,
    "tech_support_tickets_30d": 4,
    "network_quality_score": 0.62
  },
  "inference_options": {
    "include_feature_attribution": true,
    "attribution_engine": "treeshap_v2"
  }
}</code></pre>
                                    <span class="font-label-md text-label-md font-bold text-primary mt-2">Predicted Response [HTTP 200 OK — 16.2ms]</span>
                                    <pre class="bg-surface-container-lowest p-space-md rounded text-on-surface font-code-sm text-code-sm overflow-x-auto"><code>{
  "prediction": {
    "churn_probability": 0.7842,
    "classification": "CHURN_RISK_HIGH",
    "decision_threshold": 0.5000
  },
  "top_drivers": [
    {"feature": "tech_support_tickets_30d", "shap_value": 0.312},
    {"feature": "contract_type_month_to_month", "shap_value": 0.248}
  ],
  "model_version": "v2.4.1",
  "audit_ticket": "VP-TKT-1082"
}</code></pre>
                                </div>
                            </div>
                            <!-- Security Tab (Hidden by default) -->
                            <div class="tab-view hidden flex flex-col gap-space-md" id="tab-content-security">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-space-md">
                                    <div class="p-space-md rounded-lg bg-surface-container-low flex flex-col gap-2">
                                        <div class="flex items-center justify-between">
                                            <span class="font-label-md text-label-md font-bold text-primary">Container Dependency Scan</span>
                                            <span class="font-label-sm text-label-sm px-2 py-0.5 rounded bg-emerald-100 text-emerald-800 font-bold">0 CVEs</span>
                                        </div>
                                        <p class="font-body-sm text-body-sm text-on-surface-variant">Trivy vulnerability inspection of Python 3.10-slim runtime base image.</p>
                                        <div class="flex flex-col gap-1 text-on-surface font-code-sm text-code-sm pt-2">
                                            <div class="flex justify-between py-1 bg-surface-container-lowest px-2 rounded"><span>Critical Severity:</span><span class="font-bold text-emerald-700">0</span></div>
                                            <div class="flex justify-between py-1 bg-surface-container-lowest px-2 rounded"><span>High Severity:</span><span class="font-bold text-emerald-700">0</span></div>
                                            <div class="flex justify-between py-1 bg-surface-container-lowest px-2 rounded"><span>Medium Severity:</span><span class="font-bold text-emerald-700">0</span></div>
                                        </div>
                                    </div>
                                    <div class="p-space-md rounded-lg bg-surface-container-low flex flex-col gap-2">
                                        <div class="flex items-center justify-between">
                                            <span class="font-label-md text-label-md font-bold text-primary">Pickle / Bytecode Safety</span>
                                            <span class="font-label-sm text-label-sm px-2 py-0.5 rounded bg-emerald-100 text-emerald-800 font-bold">PASSED</span>
                                        </div>
                                        <p class="font-body-sm text-body-sm text-on-surface-variant">Fickling AST inspection checked for arbitrary code execution in weights.</p>
                                        <div class="p-3 bg-surface-container-lowest rounded text-on-surface font-code-sm text-code-sm">
                                            No `os.system`, `subprocess`, `__reduce__` or socket hooks detected inside candidate model binary.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Failure Handling Notice Callout -->
                            <div class="p-space-md rounded-xl bg-amber-50 shadow-sm flex items-start gap-space-md">
                                <div class="w-8 h-8 rounded-lg bg-amber-600 text-white flex items-center justify-center shrink-0 mt-0.5">
                                    <span class="material-symbols-outlined text-[18px]">info</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-label-md text-label-md font-bold text-amber-950">Pedagogical Guardrail Policy</span>
                                    <p class="font-body-sm text-body-sm text-amber-900 mt-0.5">
                                        Automated checks provide mathematical verification and crash resilience, but <strong>do not substitute for instructor pedagogical approval</strong>. Once all 10 checks pass, submit the generated evidence manifest for Cadet E. Vance's supervisory instructor to sign the cryptographic deployment token.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Evidence Artifacts & Audit Proof Summary Footer -->
                <div class="mt-space-lg p-space-lg rounded-xl bg-surface-container-lowest shadow-sm flex flex-col gap-space-md">
                    <div class="flex flex-wrap items-center justify-between gap-space-md">
                        <div class="flex items-center gap-space-sm">
                            <span class="material-symbols-outlined text-primary text-[20px]">assignment_turned_in</span>
                            <span class="font-headline-sm text-headline-sm text-primary">Synthesized Evidence Bundle Manifest</span>
                        </div>
                        <span class="font-code-sm text-code-sm text-on-surface-variant">BUNDLE ID: VP-EVD-1082-20241024-V241</span>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-space-md pt-space-xs">
                        <div class="p-space-md rounded-lg bg-surface-container-low flex flex-col justify-between">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary text-[18px]">verified_user</span>
                                <span class="font-label-md text-label-md font-bold text-on-surface">SHA256 Signed</span>
                            </div>
                            <span class="font-code-sm text-code-sm text-on-surface-variant mt-2 truncate">3f9a88c142b67d...</span>
                        </div>
                        <div class="p-space-md rounded-lg bg-surface-container-low flex flex-col justify-between">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary text-[18px]">developer_board</span>
                                <span class="font-label-md text-label-md font-bold text-on-surface">OpenBLAS Linking</span>
                            </div>
                            <span class="font-code-sm text-code-sm text-emerald-700 mt-2">Zero Symbol Mismatches</span>
                        </div>
                        <div class="p-space-md rounded-lg bg-surface-container-low flex flex-col justify-between">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary text-[18px]">terminal</span>
                                <span class="font-label-md text-label-md font-bold text-on-surface">Test Assertions</span>
                            </div>
                            <span class="font-code-sm text-code-sm text-emerald-700 mt-2">1,250 / 1,250 Invocations OK</span>
                        </div>
                        <div class="p-space-md rounded-lg bg-surface-container-low flex flex-col justify-between">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary text-[18px]">history_edu</span>
                                <span class="font-label-md text-label-md font-bold text-on-surface">Instructor Gate</span>
                            </div>
                            <span class="font-code-sm text-code-sm text-primary font-bold mt-2">AWAITING FACULTY TOKEN</span>
                        </div>
                    </div>
                </div>
        </main>
    </div>
    <script src="js/main.js"></script>
</body>

</html>