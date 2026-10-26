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
        <nav class="flex-1 flex flex-col gap-1 overflow-y-auto" data-active-classes="bg-primary-container text-on-primary font-bold rounded-lg shadow-sm"><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="notebook-workbench" href="NotebookWorkbench.php"><span class="material-symbols-outlined text-[18px]">code</span><span class="font-body-md text-body-md">Notebook Workbench</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="experiment-runs" href="ExperimentRuns.php"><span class="material-symbols-outlined text-[18px]">query_stats</span><span class="font-body-md text-body-md">Experiment Runs</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="metric-telemetry" href="MetricTelemetry.php"><span class="material-symbols-outlined text-[18px]">insights</span><span class="font-body-md text-body-md">Metric Telemetry</span></a><a aria-current="page" class="flex items-center gap-space-sm px-space-sm py-2 transition-all bg-primary-container text-on-primary font-bold rounded-lg shadow-sm" data-path="tensor-inspector" href="TensorInspector.php"><span class="material-symbols-outlined text-[18px]">grid_view</span><span class="font-body-md text-body-md">Tensor Inspector</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="hyperparameter-matrix" href="HyperparameterMatrix.php"><span class="material-symbols-outlined text-[18px]">tune</span><span class="font-body-md text-body-md">Hyperparameter Matrix</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="model-artifacts" href="ModelArtifacts.php"><span class="material-symbols-outlined text-[18px]">inventory_2</span><span class="font-body-md text-body-md">Model Artifacts</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="range-evaluation" href="RangeEvaluation.php"><span class="material-symbols-outlined text-[18px]">verified</span><span class="font-body-md text-body-md">Range Evaluation</span></a></nav>
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
                <!-- Subtle Composite Fiberglass Backdrop Mesh Layer -->
                <div class="relative w-full p-space-md flex flex-col gap-space-md">
                    <!-- TOP WORKSPACE CONTEXT BAR -->
                    <div class="w-full bg-surface-container-lowest rounded-lg p-space-md shadow-sm flex flex-col xl:flex-row xl:items-center justify-between gap-space-md">
                        <!-- Breadcrumbs & Runtime Diagnostics -->
                        <div class="flex flex-wrap items-center gap-space-sm min-w-0">
                            <div class="flex items-center gap-1.5 px-space-xs py-1 rounded bg-secondary-fixed text-on-secondary-fixed">
                                <span class="material-symbols-outlined text-[14px]">token</span>
                                <span class="font-label-md text-label-md uppercase tracking-wider">TKT-AI-01-CHURN-409</span>
                            </div>
                            <span class="text-outline-variant font-code-sm text-code-sm">/</span>
                            <div class="flex items-center gap-1.5 px-space-xs py-1 rounded bg-surface-container-high text-on-surface">
                                <span class="material-symbols-outlined text-primary text-[15px]">terminal</span>
                                <span class="font-code-sm text-code-sm font-semibold">Python 3.10 (NVIDIA A100-SXM4-40GB)</span>
                            </div>
                            <div class="flex items-center gap-3 px-space-sm py-1 rounded bg-surface-container text-on-surface-variant font-code-sm text-code-sm">
                                <div class="flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                                    <span>VRAM: <span class="font-semibold text-primary">3.2 GB</span> / 40.0 GB <span class="text-on-secondary-container font-label-sm text-label-sm">(8.0%)</span></span>
                                </div>
                                <span class="text-outline-variant">|</span>
                                <div>
                                    <span>Host RAM: <span class="font-semibold text-on-surface">6.8 GB</span> / 64.0 GB</span>
                                </div>
                            </div>
                        </div>
                        <!-- Quick Instrumentation Actions -->
                        <div class="flex items-center flex-wrap gap-space-xs shrink-0">
                            <button class="px-space-sm py-1.5 rounded bg-surface-container-high hover:bg-surface-container-highest text-on-surface font-label-md text-label-md flex items-center gap-1.5 shadow-sm transition-all" id="btn-snapshot" type="button">
                                <span class="material-symbols-outlined text-[15px] text-secondary">camera</span>
                                <span>Snapshot Tensors</span>
                            </button>
                            <button class="px-space-sm py-1.5 rounded bg-secondary-fixed hover:bg-secondary-fixed-dim text-on-secondary-fixed font-label-md text-label-md flex items-center gap-1.5 shadow-sm transition-all" id="btn-gc" type="button">
                                <span class="material-symbols-outlined text-[15px] text-primary">recycling</span>
                                <span>gc.collect()</span>
                            </button>
                            <button class="px-space-sm py-1.5 rounded bg-surface-container-high hover:bg-surface-container-highest text-on-surface font-label-md text-label-md flex items-center gap-1.5 shadow-sm transition-all" type="button">
                                <span class="material-symbols-outlined text-[15px] text-secondary">account_tree</span>
                                <span>Export Graph</span>
                            </button>
                            <button class="px-space-md py-1.5 rounded bg-primary-container hover:bg-primary text-on-primary font-label-md text-label-md flex items-center gap-1.5 shadow-sm transition-all" type="button">
                                <span class="material-symbols-outlined text-tertiary-fixed text-[15px]">tune</span>
                                <span>Filter Objects</span>
                            </button>
                        </div>
                    </div>
                    <!-- MAIN 2-COLUMN TECHNICAL WORKSPACE -->
                    <div class="grid grid-cols-1 xl:grid-cols-12 gap-space-md items-start">
                        <!-- LEFT COLUMN: MEMORY REGISTRY & ALLOCATIONS (5 Cols) -->
                        <div class="xl:col-span-5 flex flex-col gap-space-md">
                            <!-- Registry Filter & Query Strip -->
                            <div class="bg-surface-container-lowest rounded-lg p-space-sm shadow-sm flex flex-col gap-space-xs">
                                <div class="flex items-center justify-between pb-1">
                                    <div class="flex items-center gap-1.5">
                                        <span class="material-symbols-outlined text-primary text-[16px]">memory_alt</span>
                                        <span class="font-headline-sm text-headline-sm uppercase text-on-surface tracking-tight">Active In-Memory Objects</span>
                                    </div>
                                    <span class="font-label-sm text-label-sm px-1.5 py-0.5 rounded bg-tertiary-fixed text-on-tertiary-fixed font-semibold">9 ALLOCATED</span>
                                </div>
                                <!-- Type filter pills -->
                                <div class="flex flex-wrap items-center gap-1 pt-1">
                                    <button class="px-2 py-0.5 rounded font-label-sm text-label-sm bg-primary-container text-on-primary font-bold shadow-sm" type="button">ALL (9)</button>
                                    <button class="px-2 py-0.5 rounded font-label-sm text-label-sm bg-surface-container text-on-surface-variant hover:text-on-surface" type="button">np.ndarray (4)</button>
                                    <button class="px-2 py-0.5 rounded font-label-sm text-label-sm bg-surface-container text-on-surface-variant hover:text-on-surface" type="button">torch.Tensor (1)</button>
                                    <button class="px-2 py-0.5 rounded font-label-sm text-label-sm bg-surface-container text-on-surface-variant hover:text-on-surface" type="button">xgb.DMatrix (2)</button>
                                    <button class="px-2 py-0.5 rounded font-label-sm text-label-sm bg-surface-container text-on-surface-variant hover:text-on-surface" type="button">pd.DataFrame (1)</button>
                                </div>
                                <!-- Quick criteria checks -->
                                <div class="flex items-center justify-between pt-1 font-label-sm text-label-sm text-on-surface-variant">
                                    <label class="flex items-center gap-1 cursor-pointer select-none">
                                        <input checked="" class="accent-primary rounded-sm w-3.5 h-3.5" type="checkbox" />
                                        <span>Only &gt; 10 KB</span>
                                    </label>
                                    <label class="flex items-center gap-1 cursor-pointer select-none">
                                        <input class="accent-primary rounded-sm w-3.5 h-3.5" type="checkbox" />
                                        <span>Pinned Host RAM</span>
                                    </label>
                                    <span class="text-outline-variant font-code-sm text-code-sm">Sort: Size ↓</span>
                                </div>
                            </div>
                            <!-- In-Memory Objects High-Density Table Card -->
                            <div class="bg-surface-container-lowest rounded-lg shadow-sm overflow-hidden flex flex-col">
                                <div class="overflow-x-auto">
                                    <table class="w-full text-left font-body-sm text-body-sm">
                                        <thead class="bg-surface-container-low text-on-surface-variant font-label-sm text-label-sm uppercase tracking-wider">
                                            <tr>
                                                <th class="py-2 px-space-sm">Object Identifier</th>
                                                <th class="py-2 px-space-xs">Type / Device</th>
                                                <th class="py-2 px-space-xs">Shape / Dtype</th>
                                                <th class="py-2 px-space-sm text-right">Footprint</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y-0">
                                            <!-- df_train -->
                                            <tr class="hover:bg-surface-container-low transition-colors cursor-pointer group">
                                                <td class="py-2 px-space-sm font-code-sm text-code-sm font-semibold text-primary flex items-center gap-1">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
                                                    <span>df_train</span>
                                                </td>
                                                <td class="py-2 px-space-xs">
                                                    <span class="font-code-sm text-code-sm px-1 py-0.5 rounded bg-surface-container text-on-surface-variant">pd.DataFrame</span>
                                                    <span class="font-label-sm text-label-sm ml-1 text-on-surface-variant">CPU</span>
                                                </td>
                                                <td class="py-2 px-space-xs font-code-sm text-code-sm text-on-surface">
                                                    (5634, 20) <span class="text-outline-variant">mixed</span>
                                                </td>
                                                <td class="py-2 px-space-sm text-right font-code-sm text-code-sm font-semibold text-on-surface">
                                                    880.3 KB
                                                </td>
                                            </tr>
                                            <!-- X_train_res (SELECTED ROW) -->
                                            <tr class="bg-secondary-fixed/40 hover:bg-secondary-fixed/60 transition-colors cursor-pointer ring-1 ring-primary/20">
                                                <td class="py-2 px-space-sm font-code-sm text-code-sm font-bold text-primary flex items-center gap-1">
                                                    <span class="material-symbols-outlined text-[14px] text-primary">arrow_right</span>
                                                    <span>X_train_res</span>
                                                    <span class="px-1 py-0.2 rounded bg-primary-container text-on-primary font-label-sm text-label-sm scale-90 origin-left">ACTIVE</span>
                                                </td>
                                                <td class="py-2 px-space-xs">
                                                    <span class="font-code-sm text-code-sm px-1 py-0.5 rounded bg-secondary-fixed text-on-secondary-fixed font-semibold">np.ndarray</span>
                                                    <span class="font-label-sm text-label-sm ml-1 text-on-surface-variant">CPU</span>
                                                </td>
                                                <td class="py-2 px-space-xs font-code-sm text-code-sm text-on-surface font-semibold">
                                                    (9024, 19) <span class="text-secondary font-semibold">float32</span>
                                                </td>
                                                <td class="py-2 px-space-sm text-right font-code-sm text-code-sm font-bold text-primary">
                                                    685.8 KB
                                                </td>
                                            </tr>
                                            <!-- y_train_res -->
                                            <tr class="hover:bg-surface-container-low transition-colors cursor-pointer">
                                                <td class="py-2 px-space-sm font-code-sm text-code-sm font-semibold text-on-surface flex items-center gap-1">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-outline-variant"></span>
                                                    <span>y_train_res</span>
                                                </td>
                                                <td class="py-2 px-space-xs">
                                                    <span class="font-code-sm text-code-sm px-1 py-0.5 rounded bg-surface-container text-on-surface-variant">np.ndarray</span>
                                                    <span class="font-label-sm text-label-sm ml-1 text-on-surface-variant">CPU</span>
                                                </td>
                                                <td class="py-2 px-space-xs font-code-sm text-code-sm text-on-surface">
                                                    (9024,) <span class="text-outline-variant">int64</span>
                                                </td>
                                                <td class="py-2 px-space-sm text-right font-code-sm text-code-sm text-on-surface">
                                                    72.2 KB
                                                </td>
                                            </tr>
                                            <!-- X_test -->
                                            <tr class="hover:bg-surface-container-low transition-colors cursor-pointer">
                                                <td class="py-2 px-space-sm font-code-sm text-code-sm font-semibold text-on-surface flex items-center gap-1">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-outline-variant"></span>
                                                    <span>X_test</span>
                                                </td>
                                                <td class="py-2 px-space-xs">
                                                    <span class="font-code-sm text-code-sm px-1 py-0.5 rounded bg-surface-container text-on-surface-variant">np.ndarray</span>
                                                    <span class="font-label-sm text-label-sm ml-1 text-on-surface-variant">CPU</span>
                                                </td>
                                                <td class="py-2 px-space-xs font-code-sm text-code-sm text-on-surface">
                                                    (1409, 19) <span class="text-secondary">float32</span>
                                                </td>
                                                <td class="py-2 px-space-sm text-right font-code-sm text-code-sm text-on-surface">
                                                    107.1 KB
                                                </td>
                                            </tr>
                                            <!-- y_test -->
                                            <tr class="hover:bg-surface-container-low transition-colors cursor-pointer">
                                                <td class="py-2 px-space-sm font-code-sm text-code-sm font-semibold text-on-surface flex items-center gap-1">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-outline-variant"></span>
                                                    <span>y_test</span>
                                                </td>
                                                <td class="py-2 px-space-xs">
                                                    <span class="font-code-sm text-code-sm px-1 py-0.5 rounded bg-surface-container text-on-surface-variant">np.ndarray</span>
                                                    <span class="font-label-sm text-label-sm ml-1 text-on-surface-variant">CPU</span>
                                                </td>
                                                <td class="py-2 px-space-xs font-code-sm text-code-sm text-on-surface">
                                                    (1409,) <span class="text-outline-variant">int64</span>
                                                </td>
                                                <td class="py-2 px-space-sm text-right font-code-sm text-code-sm text-on-surface">
                                                    11.3 KB
                                                </td>
                                            </tr>
                                            <!-- dtrain_matrix -->
                                            <tr class="hover:bg-surface-container-low transition-colors cursor-pointer">
                                                <td class="py-2 px-space-sm font-code-sm text-code-sm font-semibold text-on-surface flex items-center gap-1">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-tertiary-fixed-dim"></span>
                                                    <span>dtrain_matrix</span>
                                                </td>
                                                <td class="py-2 px-space-xs">
                                                    <span class="font-code-sm text-code-sm px-1 py-0.5 rounded bg-surface-container text-on-surface-variant">xgb.DMatrix</span>
                                                    <span class="font-label-sm text-label-sm ml-1 px-1 py-0.2 bg-tertiary-fixed text-on-tertiary-fixed rounded font-semibold">cuda:0</span>
                                                </td>
                                                <td class="py-2 px-space-xs font-code-sm text-code-sm text-on-surface">
                                                    9024 × 19
                                                </td>
                                                <td class="py-2 px-space-sm text-right font-code-sm text-code-sm font-semibold text-on-surface">
                                                    1.4 MB
                                                </td>
                                            </tr>
                                            <!-- dval_matrix -->
                                            <tr class="hover:bg-surface-container-low transition-colors cursor-pointer">
                                                <td class="py-2 px-space-sm font-code-sm text-code-sm font-semibold text-on-surface flex items-center gap-1">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-tertiary-fixed-dim"></span>
                                                    <span>dval_matrix</span>
                                                </td>
                                                <td class="py-2 px-space-xs">
                                                    <span class="font-code-sm text-code-sm px-1 py-0.5 rounded bg-surface-container text-on-surface-variant">xgb.DMatrix</span>
                                                    <span class="font-label-sm text-label-sm ml-1 px-1 py-0.2 bg-tertiary-fixed text-on-tertiary-fixed rounded font-semibold">cuda:0</span>
                                                </td>
                                                <td class="py-2 px-space-xs font-code-sm text-code-sm text-on-surface">
                                                    1409 × 19
                                                </td>
                                                <td class="py-2 px-space-sm text-right font-code-sm text-code-sm text-on-surface">
                                                    214 KB
                                                </td>
                                            </tr>
                                            <!-- xgb_best_model -->
                                            <tr class="hover:bg-surface-container-low transition-colors cursor-pointer">
                                                <td class="py-2 px-space-sm font-code-sm text-code-sm font-semibold text-on-surface flex items-center gap-1">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-primary"></span>
                                                    <span>xgb_best_model</span>
                                                </td>
                                                <td class="py-2 px-space-xs">
                                                    <span class="font-code-sm text-code-sm px-1 py-0.5 rounded bg-surface-container text-on-surface-variant">Booster</span>
                                                    <span class="font-label-sm text-label-sm ml-1 px-1 py-0.2 bg-tertiary-fixed text-on-tertiary-fixed rounded font-semibold">cuda:0</span>
                                                </td>
                                                <td class="py-2 px-space-xs font-code-sm text-code-sm text-on-surface">
                                                    350 Trees
                                                </td>
                                                <td class="py-2 px-space-sm text-right font-code-sm text-code-sm font-semibold text-primary">
                                                    3.8 MB
                                                </td>
                                            </tr>
                                            <!-- weights_layer_embed -->
                                            <tr class="hover:bg-surface-container-low transition-colors cursor-pointer">
                                                <td class="py-2 px-space-sm font-code-sm text-code-sm font-semibold text-on-surface flex items-center gap-1">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
                                                    <span>weights_layer_embed</span>
                                                </td>
                                                <td class="py-2 px-space-xs">
                                                    <span class="font-code-sm text-code-sm px-1 py-0.5 rounded bg-surface-container text-on-surface-variant">torch.Tensor</span>
                                                    <span class="font-label-sm text-label-sm ml-1 text-on-surface-variant">CPU</span>
                                                </td>
                                                <td class="py-2 px-space-xs font-code-sm text-code-sm text-on-surface">
                                                    (32, 128) <span class="text-secondary">float32</span>
                                                </td>
                                                <td class="py-2 px-space-sm text-right font-code-sm text-code-sm text-on-surface">
                                                    16.0 KB
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- Summary Memory Distribution Breakdown Card -->
                            <div class="bg-surface-container-lowest rounded-lg p-space-md shadow-sm flex flex-col gap-space-sm">
                                <div class="flex items-center justify-between">
                                    <span class="font-headline-sm text-headline-sm text-on-surface uppercase tracking-tight">Memory Footprint Share</span>
                                    <span class="font-label-sm text-label-sm text-on-surface-variant">Total: ~7.1 MB</span>
                                </div>
                                <!-- Composite Progress Bar -->
                                <div class="w-full h-3 rounded-full overflow-hidden flex bg-surface-container">
                                    <div class="bg-primary-container h-full transition-all" style="width: 42%;" title="DataFrames (42%)"></div>
                                    <div class="bg-secondary h-full transition-all" style="width: 35%;" title="Tensors &amp; Arrays (35%)"></div>
                                    <div class="bg-tertiary-fixed-dim h-full transition-all" style="width: 23%;" title="Model Buffers (23%)"></div>
                                </div>
                                <div class="grid grid-cols-3 gap-2 pt-1 font-label-sm text-label-sm">
                                    <div class="flex flex-col p-1.5 rounded bg-surface-container-low">
                                        <span class="text-on-surface-variant flex items-center gap-1">
                                            <span class="w-2 h-2 rounded-full bg-primary-container"></span>
                                            <span>DataFrames</span>
                                        </span>
                                        <span class="font-headline-sm text-headline-sm font-bold text-on-surface mt-0.5">42%</span>
                                        <span class="font-code-sm text-code-sm text-on-surface-variant">2.98 MB</span>
                                    </div>
                                    <div class="flex flex-col p-1.5 rounded bg-surface-container-low">
                                        <span class="text-on-surface-variant flex items-center gap-1">
                                            <span class="w-2 h-2 rounded-full bg-secondary"></span>
                                            <span>Tensors/Arrays</span>
                                        </span>
                                        <span class="font-headline-sm text-headline-sm font-bold text-on-surface mt-0.5">35%</span>
                                        <span class="font-code-sm text-code-sm text-on-surface-variant">2.48 MB</span>
                                    </div>
                                    <div class="flex flex-col p-1.5 rounded bg-surface-container-low">
                                        <span class="text-on-surface-variant flex items-center gap-1">
                                            <span class="w-2 h-2 rounded-full bg-tertiary-fixed-dim"></span>
                                            <span>Booster Buffer</span>
                                        </span>
                                        <span class="font-headline-sm text-headline-sm font-bold text-on-surface mt-0.5">23%</span>
                                        <span class="font-code-sm text-code-sm text-on-surface-variant">1.63 MB</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Mini Visual Diagnostic: VRAM Allocation Gauge -->
                            <div class="bg-surface-container-lowest rounded-lg p-space-md shadow-sm flex items-center justify-between gap-space-md">
                                <div class="flex flex-col">
                                    <span class="font-label-sm text-label-sm uppercase text-on-surface-variant font-semibold">Active Allocator Pool</span>
                                    <span class="font-headline-sm text-headline-sm text-on-surface font-bold mt-0.5">PyTorch Caching Allocator</span>
                                    <span class="font-body-sm text-body-sm text-on-surface-variant mt-1">Fragmentation low (1.2%). Host pinned zero-copy buffer available.</span>
                                </div>
                                <!-- Inline Radial Sparkline Gauge -->
                                <div class="relative w-16 h-16 shrink-0 flex items-center justify-center">
                                    <svg class="w-full h-full -rotate-90" viewbox="0 0 36 36">
                                        <path class="text-surface-container" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="3.5"></path>
                                        <path class="text-primary-container" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-dasharray="8, 100" stroke-linecap="round" stroke-width="3.5"></path>
                                    </svg>
                                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                                        <span class="font-code-sm text-code-sm font-bold text-primary">8.0%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- RIGHT COLUMN: DEEP-DIVE INSPECTOR & MULTI-DIMENSIONAL SLICER (7 Cols) -->
                        <div class="xl:col-span-7 flex flex-col gap-space-md">
                            <!-- Active Target Header Bar -->
                            <div class="bg-surface-container-lowest rounded-lg p-space-md shadow-sm flex flex-col gap-space-sm">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                                    <div class="flex items-center gap-space-sm">
                                        <div class="w-9 h-9 rounded bg-primary-container text-on-primary flex items-center justify-center shrink-0">
                                            <span class="material-symbols-outlined text-[20px]">grid_view</span>
                                        </div>
                                        <div class="flex flex-col">
                                            <div class="flex items-center gap-2">
                                                <span class="font-headline-md text-headline-md font-bold text-primary">X_train_res</span>
                                                <span class="px-2 py-0.5 rounded bg-tertiary-fixed text-on-tertiary-fixed font-label-sm text-label-sm font-semibold">SMOTE SYNTHETIC RESAMPLED</span>
                                            </div>
                                            <span class="font-code-sm text-code-sm text-on-surface-variant">Shape: [9024, 19] | dtype: float32 | contiguous: C-order | strides: (76, 4)</span>
                                        </div>
                                    </div>
                                    <!-- Precision Controls -->
                                    <div class="flex items-center gap-1.5 self-start sm:self-center">
                                        <button class="px-space-xs py-1 rounded bg-surface-container hover:bg-surface-container-high text-on-surface font-label-sm text-label-sm flex items-center gap-1" title="Download Slice as CSV">
                                            <span class="material-symbols-outlined text-[14px]">download</span>
                                            <span>Export Slice</span>
                                        </button>
                                        <button class="px-space-xs py-1 rounded bg-surface-container hover:bg-surface-container-high text-on-surface font-label-sm text-label-sm flex items-center gap-1" title="Pin Inspector">
                                            <span class="material-symbols-outlined text-[14px]">push_pin</span>
                                        </button>
                                    </div>
                                </div>
                                <!-- Dimension Slicer Controller Strip -->
                                <div class="bg-surface-container-low rounded-lg p-space-sm flex flex-wrap items-center justify-between gap-space-sm">
                                    <div class="flex items-center gap-space-md flex-wrap">
                                        <!-- Axis 0 Slice -->
                                        <div class="flex items-center gap-1.5 font-code-sm text-code-sm">
                                            <span class="font-label-sm text-label-sm uppercase font-bold text-primary">Axis 0 (Rows):</span>
                                            <div class="flex items-center bg-surface-container-lowest rounded px-2 py-1 shadow-sm">
                                                <span class="text-on-surface-variant mr-1">[</span>
                                                <input class="w-12 text-center font-code-sm text-code-sm font-semibold text-primary bg-transparent focus:outline-none" type="text" value="0:10" />
                                                <span class="text-on-surface-variant ml-1">/ 9024]</span>
                                            </div>
                                        </div>
                                        <!-- Axis 1 Slice -->
                                        <div class="flex items-center gap-1.5 font-code-sm text-code-sm">
                                            <span class="font-label-sm text-label-sm uppercase font-bold text-primary">Axis 1 (Cols):</span>
                                            <div class="flex items-center bg-surface-container-lowest rounded px-2 py-1 shadow-sm">
                                                <span class="text-on-surface-variant mr-1">[</span>
                                                <input class="w-10 text-center font-code-sm text-code-sm font-semibold text-primary bg-transparent focus:outline-none" type="text" value="0:6" />
                                                <span class="text-on-surface-variant ml-1">/ 19]</span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Code slice preview chip -->
                                    <div class="flex items-center gap-1.5 font-code-sm text-code-sm px-2 py-1 rounded bg-secondary-fixed text-on-secondary-fixed">
                                        <span>X_train_res[0:10, 0:6]</span>
                                        <button class="hover:text-primary transition-colors" id="btn-copy-slice" title="Copy Slice syntax">
                                            <span class="material-symbols-outlined text-[14px]">content_copy</span>
                                        </button>
                                    </div>
                                </div>
                                <!-- Value Statistics Metric Badge Strip -->
                                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-1.5 pt-1">
                                    <div class="p-1.5 rounded bg-surface-container-high text-center">
                                        <span class="font-label-sm text-label-sm text-on-surface-variant uppercase block">Mean</span>
                                        <span class="font-code-md text-code-md font-bold text-on-surface">0.482</span>
                                    </div>
                                    <div class="p-1.5 rounded bg-surface-container-high text-center">
                                        <span class="font-label-sm text-label-sm text-on-surface-variant uppercase block">Std Dev</span>
                                        <span class="font-code-md text-code-md font-bold text-on-surface">0.291</span>
                                    </div>
                                    <div class="p-1.5 rounded bg-surface-container-high text-center">
                                        <span class="font-label-sm text-label-sm text-on-surface-variant uppercase block">Min</span>
                                        <span class="font-code-md text-code-md font-bold text-on-surface">0.000</span>
                                    </div>
                                    <div class="p-1.5 rounded bg-surface-container-high text-center">
                                        <span class="font-label-sm text-label-sm text-on-surface-variant uppercase block">Max</span>
                                        <span class="font-code-md text-code-md font-bold text-on-surface">1.000</span>
                                    </div>
                                    <div class="p-1.5 rounded bg-surface-container-high text-center">
                                        <span class="font-label-sm text-label-sm text-on-surface-variant uppercase block">Sparsity</span>
                                        <span class="font-code-md text-code-md font-bold text-secondary">4.2%</span>
                                    </div>
                                    <div class="p-1.5 rounded bg-surface-container-high text-center">
                                        <span class="font-label-sm text-label-sm text-on-surface-variant uppercase block">NaN / Inf</span>
                                        <span class="font-code-md text-code-md font-bold text-on-surface">0 (Clean)</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Numerical Matrix Heatmap Grid View -->
                            <div class="bg-surface-container-lowest rounded-lg p-space-md shadow-sm flex flex-col gap-space-sm">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <span class="font-headline-sm text-headline-sm font-bold text-on-surface uppercase tracking-tight">Multi-Dimensional Slice Matrix</span>
                                        <span class="font-label-sm text-label-sm px-1.5 py-0.5 rounded bg-surface-container-high text-on-surface-variant">10 × 6 Window</span>
                                    </div>
                                    <!-- Dynamic Cell Probe Readout -->
                                    <div class="font-code-sm text-code-sm px-2 py-1 rounded bg-secondary-fixed text-on-secondary-fixed flex items-center gap-1.5 transition-all" id="cell-probe">
                                        <span class="material-symbols-outlined text-[14px]">pin_drop</span>
                                        <span>Hover cell: <strong class="text-primary font-bold">[row: 0, col: 0] = 0.8240</strong></span>
                                    </div>
                                </div>
                                <!-- High-Precision Numerical Heatmap Matrix -->
                                <div class="overflow-x-auto">
                                    <div class="min-w-[560px] flex flex-col border border-transparent">
                                        <!-- Matrix Column Headers (Feature Names) -->
                                        <div class="grid grid-cols-7 gap-1 font-label-sm text-label-sm pb-1 text-on-surface-variant">
                                            <div class="text-center font-bold text-outline">idx</div>
                                            <div class="truncate text-center font-semibold" title="f00: tenure_scaled">f00: tenure</div>
                                            <div class="truncate text-center font-semibold" title="f01: monthly_charges">f01: m_chg</div>
                                            <div class="truncate text-center font-semibold" title="f02: total_charges">f02: tot_chg</div>
                                            <div class="truncate text-center font-semibold" title="f03: tech_support">f03: tech_sup</div>
                                            <div class="truncate text-center font-semibold" title="f04: contract_mo">f04: cntr_mo</div>
                                            <div class="truncate text-center font-semibold" title="f05: fiber_optic">f05: fiber</div>
                                        </div>
                                        <!-- Matrix Row Cells (10 Rows) -->
                                        <!-- Row 0 -->
                                        <div class="grid grid-cols-7 gap-1 py-0.5">
                                            <div class="flex items-center justify-center font-code-sm text-code-sm text-outline font-bold">0</div>
                                            <div class="p-1 rounded text-center font-code-sm text-code-sm bg-secondary-fixed/90 text-primary font-bold hover:ring-2 hover:ring-primary cursor-pointer transition-all" data-feature="f00: tenure" data-val="0.8240">0.8240</div>
                                            <div class="p-1 rounded text-center font-code-sm text-code-sm bg-secondary-fixed/20 text-on-surface hover:ring-2 hover:ring-primary cursor-pointer transition-all" data-feature="f01: m_chg" data-val="0.1190">0.1190</div>
                                            <div class="p-1 rounded text-center font-code-sm text-code-sm bg-secondary-fixed/60 text-primary hover:ring-2 hover:ring-primary cursor-pointer transition-all" data-feature="f02: tot_chg" data-val="0.5401">0.5401</div>
                                            <div class="p-1 rounded text-center font-code-sm text-code-sm bg-surface-container-high text-on-surface-variant hover:ring-2 hover:ring-primary cursor-pointer transition-all" data-feature="f03: tech_sup" data-val="0.0000">0.0000</div>
                                            <div class="p-1 rounded text-center font-code-sm text-code-sm bg-secondary-fixed text-primary font-bold hover:ring-2 hover:ring-primary cursor-pointer transition-all" data-feature="f04: cntr_mo" data-val="1.0000">1.0000</div>
                                            <div class="p-1 rounded text-center font-code-sm text-code-sm bg-secondary-fixed/80 text-primary hover:ring-2 hover:ring-primary cursor-pointer transition-all" data-feature="f05: fiber" data-val="0.7500">0.7500</div>
                                        </div>
                                        <!-- Row 1 -->
                                        <div class="grid grid-cols-7 gap-1 py-0.5">
                                            <div class="flex items-center justify-center font-code-sm text-code-sm text-outline font-bold">1</div>
                                            <div class="p-1 rounded text-center font-code-sm text-code-sm bg-secondary-fixed/40 text-on-surface hover:ring-2 hover:ring-primary cursor-pointer transition-all" data-feature="f00: tenure" data-val="0.3421">0.3421</div>
                                            <div class="p-1 rounded text-center font-code-sm text-code-sm bg-secondary-fixed/85 text-primary font-bold hover:ring-2 hover:ring-primary cursor-pointer transition-all" data-feature="f01: m_chg" data-val="0.7420">0.7420</div>
                                            <div class="p-1 rounded text-center font-code-sm text-code-sm bg-secondary-fixed/50 text-on-surface hover:ring-2 hover:ring-primary cursor-pointer transition-all" data-feature="f02: tot_chg" data-val="0.4819">0.4819</div>
                                            <div class="p-1 rounded text-center font-code-sm text-code-sm bg-secondary-fixed text-primary font-bold hover:ring-2 hover:ring-primary cursor-pointer transition-all" data-feature="f03: tech_sup" data-val="1.0000">1.0000</div>
                                            <div class="p-1 rounded text-center font-code-sm text-code-sm bg-surface-container-high text-on-surface-variant hover:ring-2 hover:ring-primary cursor-pointer transition-all" data-feature="f04: cntr_mo" data-val="0.0000">0.0000</div>
                                            <div class="p-1 rounded text-center font-code-sm text-code-sm bg-secondary-fixed/30 text-on-surface hover:ring-2 hover:ring-primary cursor-pointer transition-all" data-feature="f05: fiber" data-val="0.2500">0.2500</div>
                                        </div>
                                        <!-- Row 2 -->
                                        <div class="grid grid-cols-7 gap-1 py-0.5">
                                            <div class="flex items-center justify-center font-code-sm text-code-sm text-outline font-bold">2</div>
                                            <div class="p-1 rounded text-center font-code-sm text-code-sm bg-secondary-fixed/15 text-on-surface hover:ring-2 hover:ring-primary cursor-pointer transition-all" data-feature="f00: tenure" data-val="0.0833">0.0833</div>
                                            <div class="p-1 rounded text-center font-code-sm text-code-sm bg-secondary-fixed/70 text-primary hover:ring-2 hover:ring-primary cursor-pointer transition-all" data-feature="f01: m_chg" data-val="0.6391">0.6391</div>
                                            <div class="p-1 rounded text-center font-code-sm text-code-sm bg-secondary-fixed/25 text-on-surface hover:ring-2 hover:ring-primary cursor-pointer transition-all" data-feature="f02: tot_chg" data-val="0.1982">0.1982</div>
                                            <div class="p-1 rounded text-center font-code-sm text-code-sm bg-surface-container-high text-on-surface-variant hover:ring-2 hover:ring-primary cursor-pointer transition-all" data-feature="f03: tech_sup" data-val="0.0000">0.0000</div>
                                            <div class="p-1 rounded text-center font-code-sm text-code-sm bg-secondary-fixed text-primary font-bold hover:ring-2 hover:ring-primary cursor-pointer transition-all" data-feature="f04: cntr_mo" data-val="1.0000">1.0000</div>
                                            <div class="p-1 rounded text-center font-code-sm text-code-sm bg-secondary-fixed text-primary font-bold hover:ring-2 hover:ring-primary cursor-pointer transition-all" data-feature="f05: fiber" data-val="1.0000">1.0000</div>
                                        </div>
                                        <!-- Row 3 -->
                                        <div class="grid grid-cols-7 gap-1 py-0.5">
                                            <div class="flex items-center justify-center font-code-sm text-code-sm text-outline font-bold">3</div>
                                            <div class="p-1 rounded text-center font-code-sm text-code-sm bg-secondary-fixed text-primary font-bold hover:ring-2 hover:ring-primary cursor-pointer transition-all" data-feature="f00: tenure" data-val="0.9722">0.9722</div>
                                            <div class="p-1 rounded text-center font-code-sm text-code-sm bg-secondary-fixed/95 text-primary font-bold hover:ring-2 hover:ring-primary cursor-pointer transition-all" data-feature="f01: m_chg" data-val="0.8845">0.8845</div>
                                            <div class="p-1 rounded text-center font-code-sm text-code-sm bg-secondary-fixed/90 text-primary font-bold hover:ring-2 hover:ring-primary cursor-pointer transition-all" data-feature="f02: tot_chg" data-val="0.8410">0.8410</div>
                                            <div class="p-1 rounded text-center font-code-sm text-code-sm bg-secondary-fixed text-primary font-bold hover:ring-2 hover:ring-primary cursor-pointer transition-all" data-feature="f03: tech_sup" data-val="1.0000">1.0000</div>
                                            <div class="p-1 rounded text-center font-code-sm text-code-sm bg-surface-container-high text-on-surface-variant hover:ring-2 hover:ring-primary cursor-pointer transition-all" data-feature="f04: cntr_mo" data-val="0.0000">0.0000</div>
                                            <div class="p-1 rounded text-center font-code-sm text-code-sm bg-surface-container-high text-on-surface-variant hover:ring-2 hover:ring-primary cursor-pointer transition-all" data-feature="f05: fiber" data-val="0.0000">0.0000</div>
                                        </div>
                                        <!-- Row 4 -->
                                        <div class="grid grid-cols-7 gap-1 py-0.5">
                                            <div class="flex items-center justify-center font-code-sm text-code-sm text-outline font-bold">4</div>
                                            <div class="p-1 rounded text-center font-code-sm text-code-sm bg-secondary-fixed/50 text-on-surface hover:ring-2 hover:ring-primary cursor-pointer transition-all" data-feature="f00: tenure" data-val="0.4444">0.4444</div>
                                            <div class="p-1 rounded text-center font-code-sm text-code-sm bg-secondary-fixed/40 text-on-surface hover:ring-2 hover:ring-primary cursor-pointer transition-all" data-feature="f01: m_chg" data-val="0.3650">0.3650</div>
                                            <div class="p-1 rounded text-center font-code-sm text-code-sm bg-secondary-fixed/35 text-on-surface hover:ring-2 hover:ring-primary cursor-pointer transition-all" data-feature="f02: tot_chg" data-val="0.2974">0.2974</div>
                                            <div class="p-1 rounded text-center font-code-sm text-code-sm bg-surface-container-high text-on-surface-variant hover:ring-2 hover:ring-primary cursor-pointer transition-all" data-feature="f03: tech_sup" data-val="0.0000">0.0000</div>
                                            <div class="p-1 rounded text-center font-code-sm text-code-sm bg-surface-container-high text-on-surface-variant hover:ring-2 hover:ring-primary cursor-pointer transition-all" data-feature="f04: cntr_mo" data-val="0.0000">0.0000</div>
                                            <div class="p-1 rounded text-center font-code-sm text-code-sm bg-secondary-fixed/60 text-primary hover:ring-2 hover:ring-primary cursor-pointer transition-all" data-feature="f05: fiber" data-val="0.5000">0.5000</div>
                                        </div>
                                        <!-- Row 5 -->
                                        <div class="grid grid-cols-7 gap-1 py-0.5">
                                            <div class="flex items-center justify-center font-code-sm text-code-sm text-outline font-bold">5</div>
                                            <div class="p-1 rounded text-center font-code-sm text-code-sm bg-secondary-fixed/70 text-primary hover:ring-2 hover:ring-primary cursor-pointer transition-all" data-feature="f00: tenure" data-val="0.6111">0.6111</div>
                                            <div class="p-1 rounded text-center font-code-sm text-code-sm bg-secondary-fixed/60 text-primary hover:ring-2 hover:ring-primary cursor-pointer transition-all" data-feature="f01: m_chg" data-val="0.5120">0.5120</div>
                                            <div class="p-1 rounded text-center font-code-sm text-code-sm bg-secondary-fixed/60 text-primary hover:ring-2 hover:ring-primary cursor-pointer transition-all" data-feature="f02: tot_chg" data-val="0.5280">0.5280</div>
                                            <div class="p-1 rounded text-center font-code-sm text-code-sm bg-secondary-fixed text-primary font-bold hover:ring-2 hover:ring-primary cursor-pointer transition-all" data-feature="f03: tech_sup" data-val="1.0000">1.0000</div>
                                            <div class="p-1 rounded text-center font-code-sm text-code-sm bg-secondary-fixed/50 text-on-surface hover:ring-2 hover:ring-primary cursor-pointer transition-all" data-feature="f04: cntr_mo" data-val="0.5000">0.5000</div>
                                            <div class="p-1 rounded text-center font-code-sm text-code-sm bg-surface-container-high text-on-surface-variant hover:ring-2 hover:ring-primary cursor-pointer transition-all" data-feature="f05: fiber" data-val="0.0000">0.0000</div>
                                        </div>
                                        <!-- Row 6 -->
                                        <div class="grid grid-cols-7 gap-1 py-0.5">
                                            <div class="flex items-center justify-center font-code-sm text-code-sm text-outline font-bold">6</div>
                                            <div class="p-1 rounded text-center font-code-sm text-code-sm bg-secondary-fixed/25 text-on-surface hover:ring-2 hover:ring-primary cursor-pointer transition-all" data-feature="f00: tenure" data-val="0.1944">0.1944</div>
                                            <div class="p-1 rounded text-center font-code-sm text-code-sm bg-secondary-fixed/90 text-primary font-bold hover:ring-2 hover:ring-primary cursor-pointer transition-all" data-feature="f01: m_chg" data-val="0.8015">0.8015</div>
                                            <div class="p-1 rounded text-center font-code-sm text-code-sm bg-secondary-fixed/30 text-on-surface hover:ring-2 hover:ring-primary cursor-pointer transition-all" data-feature="f02: tot_chg" data-val="0.2241">0.2241</div>
                                            <div class="p-1 rounded text-center font-code-sm text-code-sm bg-surface-container-high text-on-surface-variant hover:ring-2 hover:ring-primary cursor-pointer transition-all" data-feature="f03: tech_sup" data-val="0.0000">0.0000</div>
                                            <div class="p-1 rounded text-center font-code-sm text-code-sm bg-secondary-fixed text-primary font-bold hover:ring-2 hover:ring-primary cursor-pointer transition-all" data-feature="f04: cntr_mo" data-val="1.0000">1.0000</div>
                                            <div class="p-1 rounded text-center font-code-sm text-code-sm bg-secondary-fixed text-primary font-bold hover:ring-2 hover:ring-primary cursor-pointer transition-all" data-feature="f05: fiber" data-val="1.0000">1.0000</div>
                                        </div>
                                        <!-- Row 7 -->
                                        <div class="grid grid-cols-7 gap-1 py-0.5">
                                            <div class="flex items-center justify-center font-code-sm text-code-sm text-outline font-bold">7</div>
                                            <div class="p-1 rounded text-center font-code-sm text-code-sm bg-secondary-fixed/75 text-primary hover:ring-2 hover:ring-primary cursor-pointer transition-all" data-feature="f00: tenure" data-val="0.7222">0.7222</div>
                                            <div class="p-1 rounded text-center font-code-sm text-code-sm bg-secondary-fixed/30 text-on-surface hover:ring-2 hover:ring-primary cursor-pointer transition-all" data-feature="f01: m_chg" data-val="0.2104">0.2104</div>
                                            <div class="p-1 rounded text-center font-code-sm text-code-sm bg-secondary-fixed/45 text-on-surface hover:ring-2 hover:ring-primary cursor-pointer transition-all" data-feature="f02: tot_chg" data-val="0.3980">0.3980</div>
                                            <div class="p-1 rounded text-center font-code-sm text-code-sm bg-secondary-fixed text-primary font-bold hover:ring-2 hover:ring-primary cursor-pointer transition-all" data-feature="f03: tech_sup" data-val="1.0000">1.0000</div>
                                            <div class="p-1 rounded text-center font-code-sm text-code-sm bg-surface-container-high text-on-surface-variant hover:ring-2 hover:ring-primary cursor-pointer transition-all" data-feature="f04: cntr_mo" data-val="0.0000">0.0000</div>
                                            <div class="p-1 rounded text-center font-code-sm text-code-sm bg-surface-container-high text-on-surface-variant hover:ring-2 hover:ring-primary cursor-pointer transition-all" data-feature="f05: fiber" data-val="0.0000">0.0000</div>
                                        </div>
                                        <!-- Row 8 -->
                                        <div class="grid grid-cols-7 gap-1 py-0.5">
                                            <div class="flex items-center justify-center font-code-sm text-code-sm text-outline font-bold">8</div>
                                            <div class="p-1 rounded text-center font-code-sm text-code-sm bg-secondary-fixed/90 text-primary font-bold hover:ring-2 hover:ring-primary cursor-pointer transition-all" data-feature="f00: tenure" data-val="0.8611">0.8611</div>
                                            <div class="p-1 rounded text-center font-code-sm text-code-sm bg-secondary-fixed/85 text-primary font-bold hover:ring-2 hover:ring-primary cursor-pointer transition-all" data-feature="f01: m_chg" data-val="0.7932">0.7932</div>
                                            <div class="p-1 rounded text-center font-code-sm text-code-sm bg-secondary-fixed/80 text-primary hover:ring-2 hover:ring-primary cursor-pointer transition-all" data-feature="f02: tot_chg" data-val="0.7610">0.7610</div>
                                            <div class="p-1 rounded text-center font-code-sm text-code-sm bg-surface-container-high text-on-surface-variant hover:ring-2 hover:ring-primary cursor-pointer transition-all" data-feature="f03: tech_sup" data-val="0.0000">0.0000</div>
                                            <div class="p-1 rounded text-center font-code-sm text-code-sm bg-secondary-fixed/50 text-on-surface hover:ring-2 hover:ring-primary cursor-pointer transition-all" data-feature="f04: cntr_mo" data-val="0.5000">0.5000</div>
                                            <div class="p-1 rounded text-center font-code-sm text-code-sm bg-secondary-fixed text-primary font-bold hover:ring-2 hover:ring-primary cursor-pointer transition-all" data-feature="f05: fiber" data-val="1.0000">1.0000</div>
                                        </div>
                                        <!-- Row 9 -->
                                        <div class="grid grid-cols-7 gap-1 py-0.5">
                                            <div class="flex items-center justify-center font-code-sm text-code-sm text-outline font-bold">9</div>
                                            <div class="p-1 rounded text-center font-code-sm text-code-sm bg-secondary-fixed/30 text-on-surface hover:ring-2 hover:ring-primary cursor-pointer transition-all" data-feature="f00: tenure" data-val="0.2500">0.2500</div>
                                            <div class="p-1 rounded text-center font-code-sm text-code-sm bg-secondary-fixed/55 text-on-surface hover:ring-2 hover:ring-primary cursor-pointer transition-all" data-feature="f01: m_chg" data-val="0.4502">0.4502</div>
                                            <div class="p-1 rounded text-center font-code-sm text-code-sm bg-secondary-fixed/25 text-on-surface hover:ring-2 hover:ring-primary cursor-pointer transition-all" data-feature="f02: tot_chg" data-val="0.1829">0.1829</div>
                                            <div class="p-1 rounded text-center font-code-sm text-code-sm bg-surface-container-high text-on-surface-variant hover:ring-2 hover:ring-primary cursor-pointer transition-all" data-feature="f03: tech_sup" data-val="0.0000">0.0000</div>
                                            <div class="p-1 rounded text-center font-code-sm text-code-sm bg-secondary-fixed text-primary font-bold hover:ring-2 hover:ring-primary cursor-pointer transition-all" data-feature="f04: cntr_mo" data-val="1.0000">1.0000</div>
                                            <div class="p-1 rounded text-center font-code-sm text-code-sm bg-surface-container-high text-on-surface-variant hover:ring-2 hover:ring-primary cursor-pointer transition-all" data-feature="f05: fiber" data-val="0.0000">0.0000</div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Color Magnitude Legend -->
                                <div class="flex items-center justify-between pt-1 font-label-sm text-label-sm text-on-surface-variant">
                                    <span>Normalized Shading Scale:</span>
                                    <div class="flex items-center gap-1.5">
                                        <span>0.00 (Sparse)</span>
                                        <div class="w-32 h-2.5 rounded flex overflow-hidden">
                                            <div class="h-full w-1/4 bg-surface-container-high"></div>
                                            <div class="h-full w-1/4 bg-secondary-fixed/30"></div>
                                            <div class="h-full w-1/4 bg-secondary-fixed/70"></div>
                                            <div class="h-full w-1/4 bg-primary-container"></div>
                                        </div>
                                        <span>1.00 (Peak)</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Value Distribution Histogram & Quantile Strip -->
                            <div class="bg-surface-container-lowest rounded-lg p-space-md shadow-sm flex flex-col gap-space-sm">
                                <div class="flex items-center justify-between">
                                    <span class="font-headline-sm text-headline-sm uppercase text-on-surface tracking-tight">Distribution &amp; Quantile Dispersion</span>
                                    <span class="font-code-sm text-code-sm text-secondary font-semibold">N = 171,456 Elements</span>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-12 gap-space-md items-center">
                                    <!-- Inline SVG Frequency Histogram -->
                                    <div class="md:col-span-7 flex flex-col">
                                        <div class="h-24 w-full flex items-end gap-1 px-1">
                                            <div class="flex-1 bg-secondary-fixed/50 rounded-t h-[20%]" title="[0.0 - 0.1]: 8,240"></div>
                                            <div class="flex-1 bg-secondary-fixed/70 rounded-t h-[35%]" title="[0.1 - 0.2]: 14,200"></div>
                                            <div class="flex-1 bg-secondary-fixed rounded-t h-[55%]" title="[0.2 - 0.3]: 22,100"></div>
                                            <div class="flex-1 bg-primary/70 rounded-t h-[75%]" title="[0.3 - 0.4]: 30,500"></div>
                                            <div class="flex-1 bg-primary-container rounded-t h-[100%]" title="[0.4 - 0.5]: 41,200 (Mode)"></div>
                                            <div class="flex-1 bg-primary/80 rounded-t h-[80%]" title="[0.5 - 0.6]: 32,800"></div>
                                            <div class="flex-1 bg-secondary rounded-t h-[60%]" title="[0.6 - 0.7]: 24,100"></div>
                                            <div class="flex-1 bg-secondary-fixed rounded-t h-[40%]" title="[0.7 - 0.8]: 16,300"></div>
                                            <div class="flex-1 bg-secondary-fixed/70 rounded-t h-[25%]" title="[0.8 - 0.9]: 10,200"></div>
                                            <div class="flex-1 bg-tertiary-fixed-dim rounded-t h-[30%]" title="[0.9 - 1.0]: 12,100 (Max-peak)"></div>
                                        </div>
                                        <div class="flex justify-between font-label-sm text-label-sm text-on-surface-variant pt-1 px-1">
                                            <span>0.00</span>
                                            <span>0.25</span>
                                            <span>0.50 (Mean: 0.482)</span>
                                            <span>0.75</span>
                                            <span>1.00</span>
                                        </div>
                                    </div>
                                    <!-- Quantile Breakdown Metric Strip -->
                                    <div class="md:col-span-5 grid grid-cols-2 gap-2 font-code-sm text-code-sm">
                                        <div class="p-2 rounded bg-surface-container flex flex-col">
                                            <span class="font-label-sm text-label-sm text-on-surface-variant">p25 (1st Quartile)</span>
                                            <span class="font-bold text-on-surface text-headline-sm mt-0.5">0.2410</span>
                                        </div>
                                        <div class="p-2 rounded bg-surface-container flex flex-col">
                                            <span class="font-label-sm text-label-sm text-on-surface-variant">p50 (Median)</span>
                                            <span class="font-bold text-primary text-headline-sm mt-0.5">0.4795</span>
                                        </div>
                                        <div class="p-2 rounded bg-surface-container flex flex-col">
                                            <span class="font-label-sm text-label-sm text-on-surface-variant">p75 (3rd Quartile)</span>
                                            <span class="font-bold text-on-surface text-headline-sm mt-0.5">0.7180</span>
                                        </div>
                                        <div class="p-2 rounded bg-tertiary-fixed/60 flex flex-col">
                                            <span class="font-label-sm text-label-sm text-on-tertiary-fixed">p99.9 (Outlier)</span>
                                            <span class="font-bold text-on-tertiary-fixed text-headline-sm mt-0.5">0.9984</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Computational Lineage & Downstream Nodes Flow Panel -->
                            <div class="bg-surface-container-lowest rounded-lg p-space-md shadow-sm flex flex-col gap-space-sm">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-1.5">
                                        <span class="material-symbols-outlined text-secondary text-[16px]">account_tree</span>
                                        <span class="font-headline-sm text-headline-sm uppercase text-on-surface tracking-tight">Computational Lineage &amp; Consumer Graph</span>
                                    </div>
                                    <span class="font-label-sm text-label-sm text-on-surface-variant">Autograd: requires_grad=False</span>
                                </div>
                                <!-- Horizontal Node Pipeline -->
                                <div class="flex flex-col md:flex-row items-stretch md:items-center gap-2 pt-1">
                                    <!-- Node: Origin -->
                                    <div class="flex-1 p-2.5 rounded bg-surface-container flex flex-col gap-1">
                                        <div class="flex items-center justify-between">
                                            <span class="font-label-sm text-label-sm text-on-surface-variant uppercase">1. Upstream Generator</span>
                                            <span class="material-symbols-outlined text-[14px] text-primary">auto_fix_high</span>
                                        </div>
                                        <span class="font-code-sm text-code-sm font-semibold text-primary">imblearn.SMOTE</span>
                                        <span class="font-label-sm text-label-sm text-on-surface-variant">sampling_strategy=0.85</span>
                                    </div>
                                    <div class="hidden md:flex text-outline-variant">
                                        <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                                    </div>
                                    <!-- Node: Active -->
                                    <div class="flex-1 p-2.5 rounded bg-secondary-fixed text-on-secondary-fixed flex flex-col gap-1 ring-1 ring-primary/40 shadow-sm">
                                        <div class="flex items-center justify-between">
                                            <span class="font-label-sm text-label-sm uppercase font-bold text-primary">Target: X_train_res</span>
                                            <span class="material-symbols-outlined text-[14px] text-primary">lens</span>
                                        </div>
                                        <span class="font-code-sm text-code-sm font-bold text-primary">StandardScaler.transform</span>
                                        <span class="font-label-sm text-label-sm text-on-secondary-container">zero_mean, unit_variance</span>
                                    </div>
                                    <div class="hidden md:flex text-outline-variant">
                                        <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                                    </div>
                                    <!-- Node: Downstream Consumers -->
                                    <div class="flex-1 p-2.5 rounded bg-surface-container flex flex-col gap-1">
                                        <div class="flex items-center justify-between">
                                            <span class="font-label-sm text-label-sm text-on-surface-variant uppercase">3. Downstream Nodes</span>
                                            <span class="material-symbols-outlined text-[14px] text-secondary">model_training</span>
                                        </div>
                                        <span class="font-code-sm text-code-sm font-semibold text-on-surface">dtrain_matrix (xgb)</span>
                                        <span class="font-label-sm text-label-sm text-on-surface-variant">xgb_best_model.fit()</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- BOTTOM TELEMETRY STRIP (FOOTER INSTRUMENTATION) -->
                    <div class="w-full bg-surface-container-lowest rounded-lg p-space-sm shadow-sm flex flex-col md:flex-row items-center justify-between gap-space-sm font-code-sm text-code-sm">
                        <div class="flex flex-wrap items-center gap-space-md">
                            <div class="flex items-center gap-1.5 text-on-surface">
                                <span class="material-symbols-outlined text-[15px] text-primary">speed</span>
                                <span>GPU Peak: <strong class="text-primary font-bold">3.82 GB</strong> / 40.0 GB</span>
                            </div>
                            <span class="text-outline-variant">|</span>
                            <div class="flex items-center gap-1.5 text-on-surface">
                                <span class="material-symbols-outlined text-[15px] text-secondary">donut_large</span>
                                <span>Memory Fragmentation: <strong class="text-on-surface font-semibold">1.2%</strong></span>
                            </div>
                            <span class="text-outline-variant">|</span>
                            <div class="flex items-center gap-1.5 text-on-surface">
                                <span class="material-symbols-outlined text-[15px] text-on-tertiary-fixed-variant">memory</span>
                                <span>PyTorch Allocator: <span class="px-1 py-0.5 rounded bg-secondary-fixed text-on-secondary-fixed font-bold font-label-sm text-label-sm">Active (cudaMallocAsync)</span></span>
                            </div>
                        </div>
                        <div class="flex items-center gap-space-md shrink-0">
                            <div class="flex items-center gap-1.5 px-2 py-0.5 rounded bg-tertiary-fixed text-on-tertiary-fixed font-semibold font-label-sm text-label-sm">
                                <span class="w-2 h-2 rounded-full bg-tertiary animate-pulse"></span>
                                <span>Leak Detector: 0 Anomalies</span>
                            </div>
                            <span class="text-on-surface-variant font-label-sm text-label-sm">Sample Rate: 500ms</span>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="js/main.js"></script>
</body>

</html>