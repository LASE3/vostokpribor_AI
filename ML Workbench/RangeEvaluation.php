<?php
require_once __DIR__ . '/../app/bootstrap.php';

use App\Middleware\AuthenticationMiddleware;
use App\Core\Database;
use App\Core\Auth;

$currentUser = AuthenticationMiddleware::handle();
$db = Database::getInstance();

$isStudent = ($currentUser['role'] === 'STUDENT');

// Fetch or create initial notebook for student if in NotebookWorkbench
$notebook = null;
$notebookCells = [];
if ($isStudent) {
    $notebook = $db->fetchOne("SELECT * FROM notebooks WHERE student_id = :sid ORDER BY updated_at DESC LIMIT 1", ['sid' => $currentUser['id']]);
} else {
    $notebook = $db->fetchOne("SELECT * FROM notebooks ORDER BY updated_at DESC LIMIT 1");
}

if ($notebook) {
    $notebookCells = $db->fetchAll("SELECT * FROM notebook_cells WHERE notebook_id = :nid ORDER BY cell_order ASC", ['nid' => $notebook['id']]);
}

// Experiment runs
if ($isStudent) {
    $experimentRuns = $db->fetchAll("SELECT * FROM experiment_runs WHERE student_id = :sid ORDER BY created_at DESC", ['sid' => $currentUser['id']]);
    $modelArtifacts = $db->fetchAll("SELECT m.*, mv.version, mv.artifact_path, mv.file_size FROM models m LEFT JOIN model_versions mv ON m.id = mv.model_id WHERE m.student_id = :sid ORDER BY m.created_at DESC", ['sid' => $currentUser['id']]);
} else {
    $experimentRuns = $db->fetchAll("SELECT er.*, u.full_name AS student_name FROM experiment_runs er LEFT JOIN users u ON er.student_id = u.id ORDER BY er.created_at DESC");
    $modelArtifacts = $db->fetchAll("SELECT m.*, mv.version, mv.artifact_path, mv.file_size, u.full_name AS student_name FROM models m LEFT JOIN model_versions mv ON m.id = mv.model_id LEFT JOIN users u ON m.student_id = u.id ORDER BY m.created_at DESC");
}
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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=JetBrains+Mono:wght@400;500;600;700&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="css/style.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="js/tailwind.config.js"></script>
</head>

<body class="bg-background font-body-md text-on-surface antialiased">
    <header class="fixed top-0 left-0 right-0 z-50 bg-surface/90 backdrop-blur-xl shadow-[0_1px_8px_rgba(0,0,0,0.04)]">
        <div class="h-16 w-full px-margin flex items-center justify-between gap-gutter">
            <div class="flex items-center gap-space-md shrink-0">
                <div class="flex items-center gap-space-xs">
                    <div class="w-7 h-7 bg-primary-container rounded flex items-center justify-center"><span class="material-symbols-outlined text-on-primary text-[16px]">terminal</span></div>
                    <div class="flex flex-col"><span class="font-headline-sm text-headline-sm text-on-surface tracking-tight uppercase leading-none">VOSTOKPRIBOR</span><span class="font-label-sm text-label-sm text-primary font-semibold tracking-wider uppercase mt-0.5">SYS-AI-03: WORKBENCH &amp; NOTEBOOK</span></div>
                </div>
                <div class="hidden xl:flex items-center gap-space-xs pl-space-md">
                    <div class="flex items-center bg-surface-container-high rounded p-0.5"><a href="../AI Project Management/Dashboard.php" class="px-space-xs py-0.5 rounded text-on-surface-variant font-label-sm text-label-sm hover:text-on-surface transition-colors">SYS-AI-01: Tickets</a><a href="../Data Center/dashboard.php" class="px-space-xs py-0.5 rounded text-on-surface-variant font-label-sm text-label-sm hover:text-on-surface transition-colors">SYS-AI-02: Data Lake</a><a href="NotebookWorkbench.php" class="px-space-xs py-0.5 rounded bg-primary text-on-primary font-label-sm text-label-sm shadow-sm font-bold">SYS-AI-03: ML Workbench</a><a href="../Model Registry & Deployment/dashboard.php" class="px-space-xs py-0.5 rounded text-on-surface-variant font-label-sm text-label-sm hover:text-on-surface transition-colors">SYS-AI-04: Validation &amp; Registry</a><a href="../AI Operations Center (AI SOC)/TicketsAndScenarios.php" class="px-space-xs py-0.5 rounded text-on-surface-variant font-label-sm text-label-sm hover:text-on-surface transition-colors">SYS-AI-05: AI SOC &amp; Admin</a></div>
                </div>
            </div>
            <div class="hidden lg:flex items-center gap-space-md px-space-md py-space-xs bg-surface-container-low rounded-lg shrink-0">
                <div class="flex items-center gap-space-xs"><span class="material-symbols-outlined text-secondary text-[16px]">folder_open</span>
                    <div class="flex flex-col"><span class="font-label-md text-label-md text-on-surface uppercase">SCENARIO-01: Churn Prediction (P-AI-204)</span>
                        <div class="flex items-center gap-space-xs mt-0.5"><span class="inline-flex items-center px-space-xs py-0.5 rounded bg-secondary-fixed text-on-secondary-fixed font-label-sm text-label-sm"><span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse mr-1"></span>TRAINING IN PROGRESS</span><span class="inline-flex items-center px-space-xs py-0.5 rounded bg-tertiary-fixed text-on-tertiary-fixed font-label-sm text-label-sm"><span class="material-symbols-outlined text-[12px] mr-1">verified</span>F1 ≥ 0.80</span></div>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-space-sm shrink-0">
                <div class="hidden 2xl:flex flex-col items-end pr-space-xs text-right">
                    <div class="flex items-center gap-space-xs font-code-sm text-code-sm text-on-surface-variant"><span class="material-symbols-outlined text-secondary text-[14px]">memory</span><span>Python 3.10.12 (GPU A100-SXM4-40GB: Idle 14% RAM)</span></div>
                    <div class="font-code-sm text-code-sm text-on-surface-variant"><span class="text-on-surface font-semibold">RAM: 4.8 / 32 GB</span><span class="mx-1 text-outline-variant">|</span><span class="text-on-surface font-semibold">Disk: 18.2 / 100 GB</span></div>
                </div>
                <div class="flex items-center gap-1 px-space-xs py-1 bg-surface-container rounded"><span class="w-2 h-2 rounded-full bg-secondary-container ring-2 ring-primary"></span><span class="font-label-sm text-label-sm text-on-surface-variant uppercase">Kernel Connected</span></div>
                <div class="flex items-center gap-space-xs"><button class="h-8 px-space-xs rounded bg-surface-container-high hover:bg-surface-container-highest text-on-surface font-label-sm text-label-sm flex items-center gap-1 transition-colors" title="Run All" type="button"><span class="material-symbols-outlined text-[15px]">play_arrow</span><span class="hidden sm:inline">Run All</span></button><button class="h-8 px-space-xs rounded bg-surface-container-high hover:bg-surface-container-highest text-on-surface font-label-sm text-label-sm flex items-center gap-1 transition-colors" title="Stop Execution" type="button"><span class="material-symbols-outlined text-[15px]">stop</span><span class="hidden sm:inline">Stop</span></button><button class="h-8 px-space-xs rounded bg-surface-container-high hover:bg-surface-container-highest text-on-surface font-label-sm text-label-sm flex items-center gap-1 transition-colors" title="Restart Kernel" type="button"><span class="material-symbols-outlined text-[15px]">refresh</span><span class="hidden sm:inline">Restart</span></button><button class="h-8 px-space-md rounded bg-primary-container text-on-primary font-label-md text-label-md flex items-center gap-1.5 shadow-sm hover:bg-primary transition-colors ring-1 ring-tertiary-fixed" type="button"><span class="material-symbols-outlined text-tertiary-fixed text-[15px]">rocket_launch</span><span>Submit for Evaluation</span></button></div>
                <div class="flex items-center gap-2"><span class="text-xs font-mono text-on-surface-variant hidden md:inline"><?= htmlspecialchars($currentUser['full_name']) ?> (<?= htmlspecialchars($currentUser['identifier'] ?? $currentUser['role']) ?>)</span><div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center shrink-0"><span class="material-symbols-outlined text-on-primary text-[18px]">person</span></div></div>
            </div>
        </div>
    </header>
    <aside class="fixed left-0 top-16 bottom-0 w-64 bg-surface-container-low z-40 flex flex-col p-space-sm">
        <div class="flex items-center justify-between px-space-xs py-space-xs mb-space-sm"><span class="font-label-sm text-label-sm uppercase text-on-surface-variant font-semibold tracking-wider">Telemetry Workbench</span><span class="material-symbols-outlined text-on-surface-variant text-[16px]">tune</span></div>
        <nav class="flex-1 flex flex-col gap-1 overflow-y-auto" data-active-classes="bg-primary-container text-on-primary font-bold rounded-lg shadow-sm"><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="notebook-workbench" href="NotebookWorkbench.php"><span class="material-symbols-outlined text-[18px]">code</span><span class="font-body-md text-body-md">Notebook Workbench</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="experiment-runs" href="ExperimentRuns.php"><span class="material-symbols-outlined text-[18px]">query_stats</span><span class="font-body-md text-body-md">Experiment Runs</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="metric-telemetry" href="MetricTelemetry.php"><span class="material-symbols-outlined text-[18px]">insights</span><span class="font-body-md text-body-md">Metric Telemetry</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="tensor-inspector" href="TensorInspector.php"><span class="material-symbols-outlined text-[18px]">grid_view</span><span class="font-body-md text-body-md">Tensor Inspector</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="hyperparameter-matrix" href="HyperparameterMatrix.php"><span class="material-symbols-outlined text-[18px]">tune</span><span class="font-body-md text-body-md">Hyperparameter Matrix</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="model-artifacts" href="ModelArtifacts.php"><span class="material-symbols-outlined text-[18px]">inventory_2</span><span class="font-body-md text-body-md">Model Artifacts</span></a><a aria-current="page" class="flex items-center gap-space-sm px-space-sm py-2 transition-all bg-primary-container text-on-primary font-bold rounded-lg shadow-sm" data-path="range-evaluation" href="RangeEvaluation.php"><span class="material-symbols-outlined text-[18px]">verified</span><span class="font-body-md text-body-md">Range Evaluation</span></a></nav>
        <div class="pt-space-xs mt-space-sm bg-surface-container rounded-lg p-space-xs">
            <div class="flex items-center justify-between font-label-sm text-label-sm text-on-surface-variant mb-1"><span>GPU CLUSTER UTIL</span><span>86%</span></div>
            <div class="w-full bg-surface-container-high rounded-full h-1.5 overflow-hidden">
                <div class="bg-primary-container h-full w-[86%]"></div>
            </div>
        </div>
    </aside>
    <div class="pl-64">
        <main class="relative pt-16 w-full min-h-screen bg-surface">
            <div class="flex flex-col w-full">
                <!-- Subtle Composite Fiberglass Grid Backing (Texture overlay) -->
                <div class="relative w-full px-margin py-space-md space-y-space-md">
                    <!-- Top Context & Command Header Bar -->
                    <section class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm flex flex-col xl:flex-row items-start xl:items-center justify-between gap-space-md">
                        <div class="flex flex-col gap-1 min-w-0">
                            <!-- Breadcrumb & Tag Row -->
                            <div class="flex flex-wrap items-center gap-space-xs font-label-sm text-label-sm">
                                <span class="text-on-surface-variant">TKT-AI-01-CHURN-409</span>
                                <span class="text-secondary">/</span>
                                <span class="text-on-surface-variant">Range Evaluation</span>
                                <span class="text-secondary">/</span>
                                <span class="text-primary font-bold uppercase tracking-wider">Benchmark Verification &amp; Gate Audit</span>
                                <span class="px-space-xs py-0.5 rounded bg-tertiary-fixed text-on-tertiary-fixed font-label-sm text-label-sm flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[13px]">military_tech</span>
                                    GOLDEN BENCHMARK CANDIDATE
                                </span>
                            </div>
                            <!-- Title & Active Candidate Specs -->
                            <div class="flex flex-wrap items-baseline gap-space-sm mt-0.5">
                                <h1 class="font-headline-lg text-headline-lg text-on-surface tracking-tight">Scenario-01: Customer Churn Prediction</h1>
                                <span class="font-code-md text-code-md text-primary font-semibold bg-secondary-fixed px-space-xs py-0.5 rounded">
                                    Run #04 (xgboost_tuned_trial_04)
                                </span>
                                <span class="font-code-sm text-code-sm text-on-surface-variant flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px] text-secondary">commit</span>
                                    chkpt_a91f82c • seed=42
                                </span>
                            </div>
                        </div>
                        <!-- Action Cluster -->
                        <div class="flex flex-wrap items-center gap-space-xs w-full xl:w-auto shrink-0">
                            <button class="h-9 px-space-sm rounded bg-surface-container-low hover:bg-surface-container-high text-on-surface font-label-md text-label-md flex items-center gap-1.5 transition-colors" type="button">
                                <span class="material-symbols-outlined text-[16px] text-secondary">refresh</span>
                                <span>Re-run Suite</span>
                            </button>
                            <button class="h-9 px-space-sm rounded bg-surface-container-low hover:bg-surface-container-high text-on-surface font-label-md text-label-md flex items-center gap-1.5 transition-colors" type="button">
                                <span class="material-symbols-outlined text-[16px] text-secondary">ios_share</span>
                                <span>Export Dossier (.pdf / .json)</span>
                            </button>
                            <button class="h-9 px-space-md rounded bg-primary text-on-primary font-label-md text-label-md flex items-center gap-2 shadow-sm hover:bg-primary-container transition-all" id="promote-btn" type="button">
                                <span class="material-symbols-outlined text-tertiary-fixed text-[18px]">verified_user</span>
                                <span class="font-bold">Proceed to SYS-AI-04 Registry</span>
                                <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                            </button>
                        </div>
                    </section>
                    <!-- Master Gate Status & Top Metric KPI Ribbon -->
                    <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-space-sm">
                        <!-- KPI 1: Primary Business Objective F1 -->
                        <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm relative overflow-hidden flex flex-col justify-between">
                            <div class="flex items-center justify-between font-label-sm text-label-sm text-on-surface-variant">
                                <span class="uppercase">Validation F1-Score</span>
                                <span class="px-space-xs py-0.5 rounded bg-tertiary-fixed text-on-tertiary-fixed font-bold">REQ ≥ 0.800</span>
                            </div>
                            <div class="my-space-xs flex items-baseline justify-between">
                                <div class="font-headline-xl text-headline-xl text-on-surface tracking-tight font-bold">0.825</div>
                                <span class="font-label-md text-label-md px-1.5 py-0.5 rounded bg-secondary-fixed text-on-secondary-fixed flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px]">arrow_upward</span>+0.025 margin
                                </span>
                            </div>
                            <div class="space-y-1">
                                <div class="w-full bg-surface-container rounded-full h-1.5 overflow-hidden">
                                    <div class="bg-primary h-full w-[82.5%] transition-all duration-700"></div>
                                </div>
                                <div class="flex justify-between font-code-sm text-code-sm text-on-surface-variant">
                                    <span>Baseline: 0.761</span>
                                    <span class="text-primary font-semibold">Status: PASSED</span>
                                </div>
                            </div>
                        </div>
                        <!-- KPI 2: Discrimination ROC-AUC -->
                        <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm flex flex-col justify-between">
                            <div class="flex items-center justify-between font-label-sm text-label-sm text-on-surface-variant">
                                <span class="uppercase">Area Under ROC (AUC)</span>
                                <span class="px-space-xs py-0.5 rounded bg-surface-container-high text-on-surface-variant">REQ ≥ 0.850</span>
                            </div>
                            <div class="my-space-xs flex items-baseline justify-between">
                                <div class="font-headline-xl text-headline-xl text-on-surface tracking-tight font-bold">0.864</div>
                                <span class="font-label-md text-label-md px-1.5 py-0.5 rounded bg-secondary-fixed text-on-secondary-fixed flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px]">check</span>+0.014 headroom
                                </span>
                            </div>
                            <div class="space-y-1">
                                <div class="w-full bg-surface-container rounded-full h-1.5 overflow-hidden">
                                    <div class="bg-secondary h-full w-[86.4%] transition-all duration-700"></div>
                                </div>
                                <div class="flex justify-between font-code-sm text-code-sm text-on-surface-variant">
                                    <span>PR-AUC: 0.792</span>
                                    <span class="text-primary font-semibold">Status: PASSED</span>
                                </div>
                            </div>
                        </div>
                        <!-- KPI 3: Latency Bound SLA -->
                        <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm flex flex-col justify-between">
                            <div class="flex items-center justify-between font-label-sm text-label-sm text-on-surface-variant">
                                <span class="uppercase">P95 Inference Latency</span>
                                <span class="px-space-xs py-0.5 rounded bg-surface-container-high text-on-surface-variant">BOUND &lt; 50.0ms</span>
                            </div>
                            <div class="my-space-xs flex items-baseline justify-between">
                                <div class="font-headline-xl text-headline-xl text-on-surface tracking-tight font-bold">18.2<span class="text-body-md font-normal text-on-surface-variant ml-0.5">ms</span></div>
                                <span class="font-label-md text-label-md px-1.5 py-0.5 rounded bg-secondary-fixed text-on-secondary-fixed flex items-center gap-1">
                                    31.8ms buffer
                                </span>
                            </div>
                            <div class="space-y-1">
                                <div class="w-full bg-surface-container rounded-full h-1.5 overflow-hidden">
                                    <div class="bg-primary-container h-full w-[36.4%]"></div>
                                </div>
                                <div class="flex justify-between font-code-sm text-code-sm text-on-surface-variant">
                                    <span>P99: 24.1ms</span>
                                    <span class="text-primary font-semibold">Status: SLA MET</span>
                                </div>
                            </div>
                        </div>
                        <!-- KPI 4: Economic Impact Score -->
                        <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm flex flex-col justify-between">
                            <div class="flex items-center justify-between font-label-sm text-label-sm text-on-surface-variant">
                                <span class="uppercase">Economic Value Gain</span>
                                <span class="text-primary font-bold">/10k USERS</span>
                            </div>
                            <div class="my-space-xs flex items-baseline justify-between">
                                <div class="font-headline-xl text-headline-xl text-on-surface tracking-tight font-bold">+$11,350</div>
                                <span class="font-label-md text-label-md px-1.5 py-0.5 rounded bg-tertiary-fixed text-on-tertiary-fixed font-bold">
                                    +18.4% Net ROI
                                </span>
                            </div>
                            <div class="space-y-1">
                                <div class="w-full bg-surface-container rounded-full h-1.5 overflow-hidden">
                                    <div class="bg-tertiary h-full w-[78%]"></div>
                                </div>
                                <div class="flex justify-between font-code-sm text-code-sm text-on-surface-variant">
                                    <span>Intervention: $15/user</span>
                                    <span class="text-tertiary font-semibold">Cost Salvaged</span>
                                </div>
                            </div>
                        </div>
                        <!-- KPI 5: Gate Compliance Summary Card -->
                        <div class="bg-primary text-on-primary rounded-xl p-space-md shadow-sm flex flex-col justify-between relative overflow-hidden">
                            <div class="flex items-center justify-between font-label-sm text-label-sm text-primary-fixed-dim">
                                <span class="uppercase font-bold tracking-wider">Gate Certification</span>
                                <span class="material-symbols-outlined text-[18px] text-tertiary-fixed">verified</span>
                            </div>
                            <div class="my-space-xs">
                                <div class="font-headline-lg text-headline-lg font-bold text-on-primary">4 / 4 Verified</div>
                                <div class="font-label-sm text-label-sm text-secondary-fixed mt-0.5">100% REGISTRY COMPLIANT</div>
                            </div>
                            <div class="flex items-center gap-1 font-code-sm text-code-sm bg-primary-container px-2 py-1 rounded text-primary-fixed">
                                <span class="w-2 h-2 rounded-full bg-tertiary-fixed animate-ping mr-1"></span>
                                Ready for promotion
                            </div>
                        </div>
                    </section>
                    <!-- Main Dual-Grid Workbench Deep Dive -->
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-md">
                        <!-- LEFT COLUMN: Detailed Metrics, Fair Disparity Slices & Financial Matrix (7 Cols) -->
                        <div class="lg:col-span-7 space-y-space-md">
                            <!-- Classification Metrics Detailed Table Card -->
                            <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm">
                                <div class="flex items-center justify-between pb-space-xs border-b border-surface-container-high">
                                    <div class="flex items-center gap-space-xs">
                                        <span class="material-symbols-outlined text-primary text-[18px]">table_rows</span>
                                        <h2 class="font-headline-sm text-headline-sm text-on-surface">Classification Performance Breakdown</h2>
                                    </div>
                                    <div class="font-code-sm text-code-sm text-on-surface-variant">Test Split (N=2,480 samples)</div>
                                </div>
                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-space-xs pt-space-md">
                                    <div class="bg-surface-container-low rounded-lg p-space-xs flex flex-col">
                                        <span class="font-label-sm text-label-sm text-on-surface-variant uppercase">Accuracy</span>
                                        <span class="font-headline-md text-headline-md text-on-surface font-bold">91.4%</span>
                                        <span class="font-code-sm text-code-sm text-primary">Baseline: 88.2%</span>
                                    </div>
                                    <div class="bg-surface-container-low rounded-lg p-space-xs flex flex-col">
                                        <span class="font-label-sm text-label-sm text-on-surface-variant uppercase">Precision</span>
                                        <span class="font-headline-md text-headline-md text-on-surface font-bold">0.840</span>
                                        <span class="font-code-sm text-code-sm text-primary">Target: ≥ 0.800</span>
                                    </div>
                                    <div class="bg-surface-container-low rounded-lg p-space-xs flex flex-col">
                                        <span class="font-label-sm text-label-sm text-on-surface-variant uppercase">Recall (Sensitivity)</span>
                                        <span class="font-headline-md text-headline-md text-on-surface font-bold">0.810</span>
                                        <span class="font-code-sm text-code-sm text-primary">Target: ≥ 0.780</span>
                                    </div>
                                    <div class="bg-surface-container-low rounded-lg p-space-xs flex flex-col">
                                        <span class="font-label-sm text-label-sm text-on-surface-variant uppercase">Specificity</span>
                                        <span class="font-headline-md text-headline-md text-on-surface font-bold">90.2%</span>
                                        <span class="font-code-sm text-code-sm text-on-surface-variant">TN / (TN + FP)</span>
                                    </div>
                                    <div class="bg-surface-container-low rounded-lg p-space-xs flex flex-col">
                                        <span class="font-label-sm text-label-sm text-on-surface-variant uppercase">LogLoss (Cross-Entropy)</span>
                                        <span class="font-headline-md text-headline-md text-on-surface font-bold">0.384</span>
                                        <span class="font-code-sm text-code-sm text-primary">Top 5% Model Tier</span>
                                    </div>
                                    <div class="bg-surface-container-low rounded-lg p-space-xs flex flex-col">
                                        <span class="font-label-sm text-label-sm text-on-surface-variant uppercase">Brier Score</span>
                                        <span class="font-headline-md text-headline-md text-on-surface font-bold">0.118</span>
                                        <span class="font-code-sm text-code-sm text-on-surface-variant">Calibrated Mean Sq</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Slice Disparity & Fairness Evaluation Matrix -->
                            <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm">
                                <div class="flex items-center justify-between pb-space-xs border-b border-surface-container-high">
                                    <div class="flex items-center gap-space-xs">
                                        <span class="material-symbols-outlined text-primary text-[18px]">group_work</span>
                                        <div>
                                            <h2 class="font-headline-sm text-headline-sm text-on-surface">Subgroup Fairness &amp; Cohort Slice Evaluation</h2>
                                            <p class="font-body-sm text-body-sm text-on-surface-variant">Checking max performance drift (|Δ F1| &lt; 0.060 tolerance) across operational segments.</p>
                                        </div>
                                    </div>
                                    <span class="px-space-xs py-0.5 rounded bg-secondary-fixed text-on-secondary-fixed font-label-sm text-label-sm font-semibold">
                                        0 SUBPOPULATION FAILS
                                    </span>
                                </div>
                                <div class="mt-space-sm overflow-x-auto">
                                    <table class="w-full text-left font-body-sm text-body-sm">
                                        <thead class="bg-surface-container-low font-label-sm text-label-sm text-primary uppercase">
                                            <tr>
                                                <th class="py-2 px-space-xs">Cohort Slice Dimension</th>
                                                <th class="py-2 px-space-xs">Sample Vol</th>
                                                <th class="py-2 px-space-xs">Slice F1</th>
                                                <th class="py-2 px-space-xs">Δ Baseline</th>
                                                <th class="py-2 px-space-xs">Parity Ratio</th>
                                                <th class="py-2 px-space-xs text-right">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-surface-container-high font-code-sm text-code-sm">
                                            <!-- Row 1 -->
                                            <tr class="hover:bg-surface-container-low/50">
                                                <td class="py-2 px-space-xs font-semibold text-on-surface">Contract: Month-to-Month</td>
                                                <td class="py-2 px-space-xs text-on-surface-variant">1,214 (49%)</td>
                                                <td class="py-2 px-space-xs font-bold text-on-surface">0.834</td>
                                                <td class="py-2 px-space-xs text-secondary">+0.009</td>
                                                <td class="py-2 px-space-xs">1.01</td>
                                                <td class="py-2 px-space-xs text-right">
                                                    <span class="px-1.5 py-0.5 rounded bg-secondary-fixed text-on-secondary-fixed font-label-sm text-label-sm">PASS</span>
                                                </td>
                                            </tr>
                                            <!-- Row 2 -->
                                            <tr class="hover:bg-surface-container-low/50">
                                                <td class="py-2 px-space-xs font-semibold text-on-surface">Contract: One Year Term</td>
                                                <td class="py-2 px-space-xs text-on-surface-variant">682 (27%)</td>
                                                <td class="py-2 px-space-xs font-bold text-on-surface">0.819</td>
                                                <td class="py-2 px-space-xs text-on-surface-variant">-0.006</td>
                                                <td class="py-2 px-space-xs">0.99</td>
                                                <td class="py-2 px-space-xs text-right">
                                                    <span class="px-1.5 py-0.5 rounded bg-secondary-fixed text-on-secondary-fixed font-label-sm text-label-sm">PASS</span>
                                                </td>
                                            </tr>
                                            <!-- Row 3 -->
                                            <tr class="hover:bg-surface-container-low/50">
                                                <td class="py-2 px-space-xs font-semibold text-on-surface">Contract: Two Year Term</td>
                                                <td class="py-2 px-space-xs text-on-surface-variant">584 (24%)</td>
                                                <td class="py-2 px-space-xs font-bold text-on-surface">0.808</td>
                                                <td class="py-2 px-space-xs text-on-surface-variant">-0.017</td>
                                                <td class="py-2 px-space-xs">0.97</td>
                                                <td class="py-2 px-space-xs text-right">
                                                    <span class="px-1.5 py-0.5 rounded bg-secondary-fixed text-on-secondary-fixed font-label-sm text-label-sm">PASS</span>
                                                </td>
                                            </tr>
                                            <!-- Row 4 -->
                                            <tr class="hover:bg-surface-container-low/50">
                                                <td class="py-2 px-space-xs font-semibold text-on-surface">Payment: Electronic Check</td>
                                                <td class="py-2 px-space-xs text-on-surface-variant">892 (36%)</td>
                                                <td class="py-2 px-space-xs font-bold text-on-surface">0.829</td>
                                                <td class="py-2 px-space-xs text-secondary">+0.004</td>
                                                <td class="py-2 px-space-xs">1.00</td>
                                                <td class="py-2 px-space-xs text-right">
                                                    <span class="px-1.5 py-0.5 rounded bg-secondary-fixed text-on-secondary-fixed font-label-sm text-label-sm">PASS</span>
                                                </td>
                                            </tr>
                                            <!-- Row 5 -->
                                            <tr class="hover:bg-surface-container-low/50">
                                                <td class="py-2 px-space-xs font-semibold text-on-surface">Payment: Credit / Bank Auto</td>
                                                <td class="py-2 px-space-xs text-on-surface-variant">1,588 (64%)</td>
                                                <td class="py-2 px-space-xs font-bold text-on-surface">0.822</td>
                                                <td class="py-2 px-space-xs text-on-surface-variant">-0.003</td>
                                                <td class="py-2 px-space-xs">0.99</td>
                                                <td class="py-2 px-space-xs text-right">
                                                    <span class="px-1.5 py-0.5 rounded bg-secondary-fixed text-on-secondary-fixed font-label-sm text-label-sm">PASS</span>
                                                </td>
                                            </tr>
                                            <!-- Row 6 -->
                                            <tr class="hover:bg-surface-container-low/50">
                                                <td class="py-2 px-space-xs font-semibold text-on-surface">Tenure Quintile: Q1 (0-12 Mo)</td>
                                                <td class="py-2 px-space-xs text-on-surface-variant">744 (30%)</td>
                                                <td class="py-2 px-space-xs font-bold text-on-surface">0.838</td>
                                                <td class="py-2 px-space-xs text-secondary">+0.013</td>
                                                <td class="py-2 px-space-xs">1.01</td>
                                                <td class="py-2 px-space-xs text-right">
                                                    <span class="px-1.5 py-0.5 rounded bg-secondary-fixed text-on-secondary-fixed font-label-sm text-label-sm">PASS</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- Confusion Matrix with Dollarized Unit Economics -->
                            <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm">
                                <div class="flex items-center justify-between pb-space-xs border-b border-surface-container-high">
                                    <div class="flex items-center gap-space-xs">
                                        <span class="material-symbols-outlined text-primary text-[18px]">currency_exchange</span>
                                        <div>
                                            <h2 class="font-headline-sm text-headline-sm text-on-surface">Confusion Matrix &amp; Monetary Impact Weighting</h2>
                                            <p class="font-body-sm text-body-sm text-on-surface-variant">Cost: False Negatives ($120 churn loss) vs False Positives ($15 retention voucher offer)</p>
                                        </div>
                                    </div>
                                    <div class="font-label-sm text-label-sm bg-tertiary-fixed text-on-tertiary-fixed px-space-xs py-0.5 rounded font-bold">
                                        OPTIMIZED ON EXPECTED UTILITY
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-space-md pt-space-md">
                                    <!-- 2x2 Matrix Graphic -->
                                    <div class="bg-surface-container-low rounded-lg p-space-sm flex flex-col gap-2">
                                        <div class="flex justify-between font-label-sm text-label-sm text-on-surface-variant">
                                            <span>PREDICTED NEGATIVE</span>
                                            <span>PREDICTED POSITIVE</span>
                                        </div>
                                        <!-- Actual Retained -->
                                        <div class="grid grid-cols-2 gap-2">
                                            <div class="bg-surface-container-lowest p-space-sm rounded border-l-4 border-secondary flex flex-col">
                                                <span class="font-label-sm text-label-sm text-on-surface-variant">TRUE NEGATIVE (TN)</span>
                                                <span class="font-headline-md text-headline-md font-bold text-on-surface">1,682</span>
                                                <span class="font-code-sm text-code-sm text-on-surface-variant">No Action Cost: $0</span>
                                            </div>
                                            <div class="bg-surface-container-lowest p-space-sm rounded border-l-4 border-tertiary flex flex-col">
                                                <span class="font-label-sm text-label-sm text-on-surface-variant">FALSE POSITIVE (FP)</span>
                                                <span class="font-headline-md text-headline-md font-bold text-tertiary">142</span>
                                                <span class="font-code-sm text-code-sm text-tertiary">Voucher Waste: -$2,130</span>
                                            </div>
                                        </div>
                                        <!-- Actual Churned -->
                                        <div class="grid grid-cols-2 gap-2">
                                            <div class="bg-surface-container-lowest p-space-sm rounded border-l-4 border-error flex flex-col">
                                                <span class="font-label-sm text-label-sm text-error">FALSE NEGATIVE (FN)</span>
                                                <span class="font-headline-md text-headline-md font-bold text-error">124</span>
                                                <span class="font-code-sm text-code-sm text-error">Unmitigated Loss: -$14,880</span>
                                            </div>
                                            <div class="bg-surface-container-lowest p-space-sm rounded border-l-4 border-primary flex flex-col">
                                                <span class="font-label-sm text-label-sm text-primary">TRUE POSITIVE (TP)</span>
                                                <span class="font-headline-md text-headline-md font-bold text-primary">532</span>
                                                <span class="font-code-sm text-code-sm text-primary font-bold">Salvaged MRR: +$53,200</span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Unit Economy Visual Summary & Calibration Graph SVG -->
                                    <div class="flex flex-col justify-between space-y-space-xs">
                                        <div class="bg-surface-container-high/60 rounded-lg p-space-sm">
                                            <span class="font-label-sm text-label-sm uppercase text-on-surface-variant">Net Salvaged Utility</span>
                                            <div class="font-headline-lg text-headline-lg font-bold text-primary">+$36,190</div>
                                            <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">
                                                Threshold setting at <span class="font-code-sm text-code-sm font-bold text-on-surface">p* = 0.42</span> maximizes net retention margin over standard default 0.50 threshold by +14.2%.
                                            </p>
                                        </div>
                                        <!-- SVG Calibration Curve (Inline) -->
                                        <div class="bg-surface-container-low rounded-lg p-space-xs flex flex-col">
                                            <div class="flex justify-between items-center font-label-sm text-label-sm text-on-surface-variant px-1 mb-1">
                                                <span>RELIABILITY DIAGRAM (CALIBRATION)</span>
                                                <span class="text-primary font-bold">ECE: 0.018 (PERFECT ≤ 0.02)</span>
                                            </div>
                                            <div class="w-full h-24 relative flex items-center justify-center">
                                                <svg class="w-full h-full text-secondary" preserveaspectratio="none" viewbox="0 0 240 80">
                                                    <!-- Ideal diagonal line -->
                                                    <line class="text-outline-variant" stroke="currentColor" stroke-dasharray="2,2" stroke-width="1" x1="20" x2="220" y1="70" y2="10"></line>
                                                    <!-- Actual calibration stepped curve -->
                                                    <polyline class="text-primary" fill="none" points="20,70 45,62 70,54 95,47 120,40 145,31 170,23 195,16 220,11" stroke="currentColor" stroke-width="2.5"></polyline>
                                                    <!-- Confidence points -->
                                                    <circle class="fill-primary-container" cx="45" cy="62" r="2.5"></circle>
                                                    <circle class="fill-primary-container" cx="95" cy="47" r="2.5"></circle>
                                                    <circle class="fill-primary-container" cx="145" cy="31" r="2.5"></circle>
                                                    <circle class="fill-primary-container" cx="195" cy="16" r="2.5"></circle>
                                                </svg>
                                            </div>
                                            <div class="flex justify-between font-code-sm text-code-sm text-on-surface-variant px-1">
                                                <span>0.0 Pred. Prob</span>
                                                <span>1.0 Pred. Prob</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- RIGHT COLUMN: Range Benchmarks, Stress Testing & Integrity Audits (5 Cols) -->
                        <div class="lg:col-span-5 space-y-space-md">
                            <!-- Perturbation & Stress Testing Card -->
                            <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm">
                                <div class="flex items-center justify-between pb-space-xs border-b border-surface-container-high">
                                    <div class="flex items-center gap-space-xs">
                                        <span class="material-symbols-outlined text-primary text-[18px]">bolt</span>
                                        <h2 class="font-headline-sm text-headline-sm text-on-surface">Stress &amp; Perturbation Resilience</h2>
                                    </div>
                                    <span class="font-label-sm text-label-sm bg-secondary-fixed text-on-secondary-fixed px-space-xs py-0.5 rounded font-semibold">
                                        ROBUST
                                    </span>
                                </div>
                                <div class="space-y-space-sm pt-space-sm">
                                    <!-- Stress Test 1: Gaussian Noise -->
                                    <div class="space-y-1">
                                        <div class="flex justify-between font-body-sm text-body-sm">
                                            <span class="text-on-surface font-medium">Gaussian Feature Noise (+/- 5%)</span>
                                            <span class="font-code-sm text-code-sm text-primary font-bold">F1 0.821 (-0.5%)</span>
                                        </div>
                                        <div class="w-full bg-surface-container rounded-full h-1.5 overflow-hidden">
                                            <div class="bg-primary h-full w-[99.5%]"></div>
                                        </div>
                                        <span class="font-code-sm text-code-sm text-on-surface-variant">Pass criterion: Max drop &lt; 3.0%</span>
                                    </div>
                                    <!-- Stress Test 2: Missing Value Injection -->
                                    <div class="space-y-1">
                                        <div class="flex justify-between font-body-sm text-body-sm">
                                            <span class="text-on-surface font-medium">Missing Value Injection (10% Dropped)</span>
                                            <span class="font-code-sm text-code-sm text-primary font-bold">F1 0.809 (-1.9%)</span>
                                        </div>
                                        <div class="w-full bg-surface-container rounded-full h-1.5 overflow-hidden">
                                            <div class="bg-primary h-full w-[98.1%]"></div>
                                        </div>
                                        <span class="font-code-sm text-code-sm text-on-surface-variant">Native XGBoost NaN split path functioning properly</span>
                                    </div>
                                    <!-- Stress Test 3: Concurrency Spike -->
                                    <div class="space-y-1">
                                        <div class="flex justify-between font-body-sm text-body-sm">
                                            <span class="text-on-surface font-medium">Load Burst (100 QPS → 1,000 QPS)</span>
                                            <span class="font-code-sm text-code-sm text-primary font-bold">Latency P99: 28.4ms</span>
                                        </div>
                                        <div class="w-full bg-surface-container rounded-full h-1.5 overflow-hidden">
                                            <div class="bg-secondary h-full w-[56.8%]"></div>
                                        </div>
                                        <span class="font-code-sm text-code-sm text-on-surface-variant">Zero dropped requests / Zero heap memory saturation</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Automated Integrity & Security Audit Checklist -->
                            <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm">
                                <div class="flex items-center justify-between pb-space-xs border-b border-surface-container-high">
                                    <div class="flex items-center gap-space-xs">
                                        <span class="material-symbols-outlined text-primary text-[18px]">gavel</span>
                                        <h2 class="font-headline-sm text-headline-sm text-on-surface">Automated Range Audit Checklist</h2>
                                    </div>
                                    <span class="font-code-sm text-code-sm text-on-surface-variant">ISO-AI-42001</span>
                                </div>
                                <div class="space-y-space-xs pt-space-sm">
                                    <!-- Audit Item 1 -->
                                    <div class="flex items-start gap-space-xs p-space-xs rounded bg-surface-container-low">
                                        <span class="material-symbols-outlined text-[18px] text-primary shrink-0 mt-0.5">check_circle</span>
                                        <div class="flex flex-col flex-1">
                                            <div class="flex items-center justify-between">
                                                <span class="font-body-sm text-body-sm font-semibold text-on-surface">Data Leakage Analysis</span>
                                                <span class="font-label-sm text-label-sm px-1.5 py-0.5 rounded bg-secondary-fixed text-on-secondary-fixed">PASSED</span>
                                            </div>
                                            <p class="font-code-sm text-code-sm text-on-surface-variant mt-0.5">
                                                Temporal cutoff verified. Zero future timestamps detected in train/val sets. Mutual Information max: 0.28.
                                            </p>
                                        </div>
                                    </div>
                                    <!-- Audit Item 2 -->
                                    <div class="flex items-start gap-space-xs p-space-xs rounded bg-surface-container-low">
                                        <span class="material-symbols-outlined text-[18px] text-primary shrink-0 mt-0.5">check_circle</span>
                                        <div class="flex flex-col flex-1">
                                            <div class="flex items-center justify-between">
                                                <span class="font-body-sm text-body-sm font-semibold text-on-surface">Overfitting Variance Bound</span>
                                                <span class="font-label-sm text-label-sm px-1.5 py-0.5 rounded bg-secondary-fixed text-on-secondary-fixed">PASSED</span>
                                            </div>
                                            <p class="font-code-sm text-code-sm text-on-surface-variant mt-0.5">
                                                Train F1 (0.868) vs Val F1 (0.825). Generalization gap 0.043 well below 0.080 overfitting tripwire.
                                            </p>
                                        </div>
                                    </div>
                                    <!-- Audit Item 3 -->
                                    <div class="flex items-start gap-space-xs p-space-xs rounded bg-surface-container-low">
                                        <span class="material-symbols-outlined text-[18px] text-primary shrink-0 mt-0.5">check_circle</span>
                                        <div class="flex flex-col flex-1">
                                            <div class="flex items-center justify-between">
                                                <span class="font-body-sm text-body-sm font-semibold text-on-surface">Adversarial &amp; Outlier Sensitivity</span>
                                                <span class="font-label-sm text-label-sm px-1.5 py-0.5 rounded bg-secondary-fixed text-on-secondary-fixed">PASSED</span>
                                            </div>
                                            <p class="font-code-sm text-code-sm text-on-surface-variant mt-0.5">
                                                Synthesized extreme charge amounts &amp; tenure extremes handled via tree leaf clipping. No gradient explosion.
                                            </p>
                                        </div>
                                    </div>
                                    <!-- Audit Item 4 -->
                                    <div class="flex items-start gap-space-xs p-space-xs rounded bg-surface-container-low">
                                        <span class="material-symbols-outlined text-[18px] text-primary shrink-0 mt-0.5">check_circle</span>
                                        <div class="flex flex-col flex-1">
                                            <div class="flex items-center justify-between">
                                                <span class="font-body-sm text-body-sm font-semibold text-on-surface">Deterministic Seed Reproducibility</span>
                                                <span class="font-label-sm text-label-sm px-1.5 py-0.5 rounded bg-secondary-fixed text-on-secondary-fixed">PASSED</span>
                                            </div>
                                            <p class="font-code-sm text-code-sm text-on-surface-variant mt-0.5">
                                                Multi-run weight diff: 0.000000000 across 3 consecutive container restarts. Hash verified.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Telemetry & Training Artifact Metadata Quickview -->
                            <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm">
                                <div class="flex items-center justify-between pb-space-xs border-b border-surface-container-high">
                                    <span class="font-label-sm text-label-sm text-on-surface-variant uppercase font-semibold">Trained Artifact Dossier</span>
                                    <span class="font-code-sm text-code-sm text-primary font-bold">14.2 MB (.ubj)</span>
                                </div>
                                <div class="mt-space-xs grid grid-cols-2 gap-space-xs font-code-sm text-code-sm">
                                    <div class="bg-surface-container-low p-2 rounded">
                                        <span class="text-on-surface-variant block font-label-sm text-label-sm">MAX DEPTH</span>
                                        <span class="font-bold text-on-surface">6</span>
                                    </div>
                                    <div class="bg-surface-container-low p-2 rounded">
                                        <span class="text-on-surface-variant block font-label-sm text-label-sm">ESTIMATORS</span>
                                        <span class="font-bold text-on-surface">320 trees</span>
                                    </div>
                                    <div class="bg-surface-container-low p-2 rounded">
                                        <span class="text-on-surface-variant block font-label-sm text-label-sm">LEARNING RATE</span>
                                        <span class="font-bold text-on-surface">0.038</span>
                                    </div>
                                    <div class="bg-surface-container-low p-2 rounded">
                                        <span class="text-on-surface-variant block font-label-sm text-label-sm">COL_SAMPLE</span>
                                        <span class="font-bold text-on-surface">0.78</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Bottom Cryptographic Sign-Off & Navigation Deck -->
                    <footer class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm flex flex-col md:flex-row items-center justify-between gap-space-md">
                        <!-- Cryptographic Proof Signature -->
                        <div class="flex items-center gap-space-sm">
                            <div class="w-10 h-10 rounded-lg bg-surface-container-high flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-primary text-[22px]">fingerprint</span>
                            </div>
                            <div class="flex flex-col">
                                <div class="flex items-center gap-space-xs">
                                    <span class="font-body-sm text-body-sm font-semibold text-on-surface">Automated Evaluator Digital Signature:</span>
                                    <span class="font-code-sm text-code-sm px-1.5 py-0.5 rounded bg-tertiary-fixed text-on-tertiary-fixed font-bold">SYS-RANGE-EVAL-V2.4</span>
                                </div>
                                <span class="font-code-sm text-code-sm text-on-surface-variant mt-0.5 truncate max-w-md">
                                    SHA-256: 4fa8912e70bc551d02a8e7e1f481c01b9bb781e9fa49320e890c2a210fec5c1a
                                </span>
                            </div>
                        </div>
                        <!-- Pathways & Primary Progression Trigger -->
                        <div class="flex flex-wrap items-center gap-space-xs">
                            <button class="h-9 px-space-sm rounded bg-surface-container-low hover:bg-surface-container-high text-on-surface font-label-md text-label-md flex items-center gap-1 transition-colors" type="button">
                                <span class="material-symbols-outlined text-[16px]">terminal</span>
                                <span>Return to Notebook</span>
                            </button>
                            <button class="h-9 px-space-sm rounded bg-surface-container-low hover:bg-surface-container-high text-on-surface font-label-md text-label-md flex items-center gap-1 transition-colors" type="button">
                                <span class="material-symbols-outlined text-[16px]">tune</span>
                                <span>Review Hyperparameters</span>
                            </button>
                            <button class="h-9 px-space-md rounded bg-primary text-on-primary font-label-md text-label-md flex items-center gap-2 shadow-md hover:bg-primary-container transition-all" id="submit-registry-btn" type="button">
                                <span class="material-symbols-outlined text-tertiary-fixed text-[18px]">verified</span>
                                <span class="font-bold">Submit to SYS-AI-04 Validation &amp; Registry</span>
                            </button>
                        </div>
                    </footer>
                </div>
        </main>
    </div>
    <script src="js/main.js"></script>
</body>

</html>