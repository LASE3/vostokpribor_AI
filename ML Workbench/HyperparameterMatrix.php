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
        <nav class="flex-1 flex flex-col gap-1 overflow-y-auto" data-active-classes="bg-primary-container text-on-primary font-bold rounded-lg shadow-sm"><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="notebook-workbench" href="NotebookWorkbench.php"><span class="material-symbols-outlined text-[18px]">code</span><span class="font-body-md text-body-md">Notebook Workbench</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="experiment-runs" href="ExperimentRuns.php"><span class="material-symbols-outlined text-[18px]">query_stats</span><span class="font-body-md text-body-md">Experiment Runs</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="metric-telemetry" href="MetricTelemetry.php"><span class="material-symbols-outlined text-[18px]">insights</span><span class="font-body-md text-body-md">Metric Telemetry</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="tensor-inspector" href="TensorInspector.php"><span class="material-symbols-outlined text-[18px]">grid_view</span><span class="font-body-md text-body-md">Tensor Inspector</span></a><a aria-current="page" class="flex items-center gap-space-sm px-space-sm py-2 transition-all bg-primary-container text-on-primary font-bold rounded-lg shadow-sm" data-path="hyperparameter-matrix" href="HyperparameterMatrix.php"><span class="material-symbols-outlined text-[18px]">tune</span><span class="font-body-md text-body-md">Hyperparameter Matrix</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="model-artifacts" href="ModelArtifacts.php"><span class="material-symbols-outlined text-[18px]">inventory_2</span><span class="font-body-md text-body-md">Model Artifacts</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="range-evaluation" href="RangeEvaluation.php"><span class="material-symbols-outlined text-[18px]">verified</span><span class="font-body-md text-body-md">Range Evaluation</span></a></nav>
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
                <!-- Subtle Composite Fiberglass Ambient Mesh -->
                <div class="relative w-full px-space-md py-space-md space-y-space-md bg-surface">
                    <!-- TOP TELEMETRY STATUS & TRIAL CONTROLLER BAR -->
                    <section class="bg-surface-container-low rounded-xl p-space-md shadow-sm">
                        <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-space-md">
                            <!-- Left: Sweep Identity & Objectives -->
                            <div class="flex flex-wrap items-center gap-space-md">
                                <div class="w-10 h-10 rounded-lg bg-primary-container flex items-center justify-center shrink-0 shadow-sm">
                                    <span class="material-symbols-outlined text-secondary-container text-[20px]">tune</span>
                                </div>
                                <div class="flex flex-col min-w-0">
                                    <div class="flex items-center gap-space-xs">
                                        <span class="font-headline-md text-headline-md text-on-surface tracking-tight">sweep-churn-optuna-v2</span>
                                        <span class="px-space-xs py-0.5 rounded bg-secondary-fixed text-on-secondary-fixed font-label-sm text-label-sm uppercase">TPE Sampler</span>
                                        <span class="px-space-xs py-0.5 rounded bg-surface-container-high text-on-surface-variant font-label-sm text-label-sm uppercase">MedianPruner</span>
                                    </div>
                                    <div class="flex flex-wrap items-center gap-space-sm mt-1 text-on-surface-variant font-code-sm text-code-sm">
                                        <span class="text-primary font-semibold">TKT-AI-01-CHURN-409</span>
                                        <span class="text-outline-variant">•</span>
                                        <span>Objective: <strong class="text-on-surface font-semibold">Maximize Val F1-Score</strong></span>
                                        <span class="text-outline-variant">•</span>
                                        <span class="text-tertiary font-medium">Constraints: F1 ≥ 0.80 | ROC-AUC ≥ 0.85 | Latency &lt; 50ms</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Center: Trial Tally Instrumentation -->
                            <div class="flex items-center gap-space-md bg-surface-container rounded-lg px-space-md py-space-xs shrink-0">
                                <div class="flex flex-col">
                                    <span class="font-label-sm text-label-sm text-on-surface-variant uppercase">Completed Trials</span>
                                    <div class="flex items-baseline gap-1">
                                        <span class="font-headline-sm text-headline-sm text-on-surface font-bold">48</span>
                                        <span class="font-code-sm text-code-sm text-outline">/ 60</span>
                                    </div>
                                </div>
                                <div class="h-6 w-px bg-surface-container-high"></div>
                                <div class="flex flex-col">
                                    <span class="font-label-sm text-label-sm text-on-surface-variant uppercase">Pruned</span>
                                    <span class="font-headline-sm text-headline-sm text-tertiary font-semibold">2</span>
                                </div>
                                <div class="h-6 w-px bg-surface-container-high"></div>
                                <div class="flex flex-col">
                                    <span class="font-label-sm text-label-sm text-on-surface-variant uppercase">Failed</span>
                                    <span class="font-headline-sm text-headline-sm text-error font-semibold">1</span>
                                </div>
                                <div class="h-6 w-px bg-surface-container-high"></div>
                                <div class="flex flex-col">
                                    <span class="font-label-sm text-label-sm text-primary font-semibold uppercase">Queued/Run</span>
                                    <div class="flex items-center gap-1">
                                        <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                                        <span class="font-headline-sm text-headline-sm text-primary font-bold">9</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Right: Best Trial KPI Capsule & Fast Executables -->
                            <div class="flex items-center gap-space-sm shrink-0">
                                <div class="flex items-center gap-space-sm bg-surface-container-lowest px-space-md py-1.5 rounded-lg shadow-sm">
                                    <div class="flex flex-col">
                                        <div class="flex items-center gap-1">
                                            <span class="material-symbols-outlined text-tertiary text-[14px]">stars</span>
                                            <span class="font-label-sm text-label-sm text-on-surface font-bold uppercase">Best: Trial #42</span>
                                            <span class="px-1 rounded bg-secondary-fixed text-on-secondary-fixed font-code-sm text-code-sm">XGBoost</span>
                                        </div>
                                        <div class="flex items-center gap-space-sm font-code-sm text-code-sm mt-0.5">
                                            <span class="text-primary font-bold">F1: 0.825</span>
                                            <span class="text-on-surface-variant">AUC: 0.864</span>
                                            <span class="text-on-surface-variant">18.2ms</span>
                                        </div>
                                    </div>
                                </div>
                                <button class="h-9 px-space-sm rounded-lg bg-surface-container-high hover:bg-surface-container-highest text-on-surface font-label-md text-label-md flex items-center gap-1 transition-colors" title="Export Study JSON" type="button">
                                    <span class="material-symbols-outlined text-[16px]">file_download</span>
                                    <span class="hidden sm:inline">Export JSON</span>
                                </button>
                                <button class="h-9 px-space-md rounded-lg bg-primary text-on-primary font-label-md text-label-md flex items-center gap-1.5 shadow-sm hover:bg-primary-container transition-all" type="button">
                                    <span class="material-symbols-outlined text-[16px]">add_circle</span>
                                    <span>New Search Run</span>
                                </button>
                            </div>
                        </div>
                    </section>
                    <!-- SECTION 2: BENTO VISUALIZATION COCKPIT (PARALLEL COORDINATES, IMPORTANCE, 2D SLICE) -->
                    <section class="grid grid-cols-1 lg:grid-cols-12 gap-space-md">
                        <!-- Parallel Coordinates Multi-Dimensional Trajectory Plot (7 Cols) -->
                        <div class="lg:col-span-8 bg-surface-container-lowest rounded-xl p-space-md shadow-sm flex flex-col justify-between">
                            <div class="flex items-center justify-between mb-space-xs">
                                <div class="flex items-center gap-space-xs">
                                    <span class="material-symbols-outlined text-primary text-[18px]">alt_route</span>
                                    <h2 class="font-headline-sm text-headline-sm text-on-surface">Parallel Hyperparameter Coordinates</h2>
                                    <span class="font-code-sm text-code-sm text-on-surface-variant ml-1">(48 Evaluated Paths)</span>
                                </div>
                                <div class="flex items-center gap-space-sm text-label-sm font-label-sm">
                                    <div class="flex items-center gap-1">
                                        <span class="w-3 h-1 bg-primary rounded"></span>
                                        <span class="text-on-surface">Best (#42)</span>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <span class="w-3 h-1 bg-secondary rounded"></span>
                                        <span class="text-on-surface-variant">F1 ≥ 0.80</span>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <span class="w-3 h-1 bg-outline-variant rounded"></span>
                                        <span class="text-on-surface-variant">Sub-optimal</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Monospace Dimension Coordinates Axis Header -->
                            <div class="w-full grid grid-cols-7 text-center font-code-sm text-code-sm text-on-surface-variant py-1 bg-surface-container-low rounded">
                                <div>lr<br /><span class="text-outline text-[10px]">[0.01 - 0.30]</span></div>
                                <div>depth<br /><span class="text-outline text-[10px]">[3 - 12]</span></div>
                                <div>n_est<br /><span class="text-outline text-[10px]">[100 - 800]</span></div>
                                <div>subsample<br /><span class="text-outline text-[10px]">[0.5 - 1.0]</span></div>
                                <div>colsample<br /><span class="text-outline text-[10px]">[0.5 - 1.0]</span></div>
                                <div>reg_lambda<br /><span class="text-outline text-[10px]">[0.01 - 10]</span></div>
                                <div class="text-primary font-bold">Val F1<br /><span class="text-primary text-[10px]">Target ≥ 0.80</span></div>
                            </div>
                            <!-- Inline High-Precision Parallel Coordinates SVG Canvas -->
                            <div class="relative w-full h-56 my-space-xs">
                                <svg class="w-full h-full" preserveaspectratio="none" viewbox="0 0 700 200">
                                    <!-- Background Guideline Grid for the 7 Axes -->
                                    <line class="text-surface-container-high" stroke="currentColor" stroke-dasharray="2 2" stroke-width="1.5" x1="50" x2="50" y1="20" y2="180"></line>
                                    <line class="text-surface-container-high" stroke="currentColor" stroke-dasharray="2 2" stroke-width="1.5" x1="150" x2="150" y1="20" y2="180"></line>
                                    <line class="text-surface-container-high" stroke="currentColor" stroke-dasharray="2 2" stroke-width="1.5" x1="250" x2="250" y1="20" y2="180"></line>
                                    <line class="text-surface-container-high" stroke="currentColor" stroke-dasharray="2 2" stroke-width="1.5" x1="350" x2="350" y1="20" y2="180"></line>
                                    <line class="text-surface-container-high" stroke="currentColor" stroke-dasharray="2 2" stroke-width="1.5" x1="450" x2="450" y1="20" y2="180"></line>
                                    <line class="text-surface-container-high" stroke="currentColor" stroke-dasharray="2 2" stroke-width="1.5" x1="550" x2="550" y1="20" y2="180"></line>
                                    <line class="text-secondary-fixed-dim" stroke="currentColor" stroke-width="2" x1="650" x2="650" y1="20" y2="180"></line>
                                    <!-- Failing / Sub-optimal Trials (Muted Gray / Low Opacity) -->
                                    <path d="M 50 160 Q 100 140, 150 150 T 250 170 T 350 120 T 450 140 T 550 160 T 650 170" fill="none" opacity="0.45" stroke="#ccc3d4" stroke-width="1.2"></path>
                                    <path d="M 50 30 Q 100 170, 150 165 T 250 130 T 350 150 T 450 160 T 550 80 T 650 160" fill="none" opacity="0.45" stroke="#ccc3d4" stroke-width="1.2"></path>
                                    <path d="M 50 70 Q 100 80, 150 110 T 250 60 T 350 90 T 450 130 T 550 120 T 650 140" fill="none" opacity="0.4" stroke="#ccc3d4" stroke-width="1.2"></path>
                                    <path d="M 50 140 Q 100 50, 150 80 T 250 150 T 350 70 T 450 110 T 550 50 T 650 135" fill="none" opacity="0.4" stroke="#ccc3d4" stroke-width="1.2"></path>
                                    <path d="M 50 110 Q 100 130, 150 140 T 250 160 T 350 140 T 450 90 T 550 170 T 650 155" fill="none" opacity="0.4" stroke="#ccc3d4" stroke-width="1.2"></path>
                                    <path d="M 50 175 Q 100 120, 150 130 T 250 90 T 350 110 T 450 150 T 550 140 T 650 150" fill="none" opacity="0.45" stroke="#ccc3d4" stroke-width="1.2"></path>
                                    <!-- Passing Trials (Secondary Lilac / Deep Violet, F1 ≥ 0.80) -->
                                    <path d="M 50 120 Q 100 90, 150 95 T 250 80 T 350 70 T 450 65 T 550 75 T 650 60" fill="none" opacity="0.65" stroke="#6f5092" stroke-width="1.6"></path>
                                    <path d="M 50 95 Q 100 70, 150 75 T 250 55 T 350 65 T 450 80 T 550 90 T 650 52" fill="none" opacity="0.75" stroke="#6f5092" stroke-width="1.6"></path>
                                    <path d="M 50 80 Q 100 110, 150 60 T 250 70 T 350 50 T 450 60 T 550 70 T 650 48" fill="none" opacity="0.8" stroke="#6f5092" stroke-width="1.8"></path>
                                    <path d="M 50 105 Q 100 85, 150 80 T 250 65 T 350 55 T 450 50 T 550 85 T 650 42" fill="none" opacity="0.85" stroke="#6f5092" stroke-width="1.8"></path>
                                    <!-- Optimal Highlight: Best Trial #42 (Bold #340075 / #4c1d95) -->
                                    <path d="M 50 90 Q 100 75, 150 70 T 250 48 T 350 45 T 450 55 T 550 65 T 650 32" fill="none" stroke="#340075" stroke-linecap="round" stroke-width="3.5"></path>
                                    <!-- Nodes for Trial #42 -->
                                    <circle cx="50" cy="90" fill="#340075" r="4.5" stroke="#ffffff" stroke-width="2"></circle>
                                    <circle cx="150" cy="70" fill="#340075" r="4.5" stroke="#ffffff" stroke-width="2"></circle>
                                    <circle cx="250" cy="48" fill="#340075" r="4.5" stroke="#ffffff" stroke-width="2"></circle>
                                    <circle cx="350" cy="45" fill="#340075" r="4.5" stroke="#ffffff" stroke-width="2"></circle>
                                    <circle cx="450" cy="55" fill="#340075" r="4.5" stroke="#ffffff" stroke-width="2"></circle>
                                    <circle cx="550" cy="65" fill="#340075" r="4.5" stroke="#ffffff" stroke-width="2"></circle>
                                    <circle cx="650" cy="32" fill="#4c1d95" r="5.5" stroke="#fedeb3" stroke-width="2.5"></circle>
                                    <!-- Cut-off threshold indicator on F1 axis (F1 = 0.80 line) -->
                                    <line stroke="#ba1a1a" stroke-width="2" x1="640" x2="660" y1="70" y2="70"></line>
                                    <text fill="#ba1a1a" font-family="JetBrains Mono" font-size="9" font-weight="600" x="663" y="73">0.80</text>
                                </svg>
                            </div>
                            <!-- Coordinates Footer Metadata -->
                            <div class="flex items-center justify-between pt-space-xs text-on-surface-variant font-code-sm text-code-sm">
                                <span class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-tertiary text-[14px]">info</span>
                                    Best coordinate tuple: [0.082, 6, 420, 0.85, 0.80, 1.45] → F1: 0.8251
                                </span>
                                <span class="text-secondary font-semibold">TPE Density Estimator: Converged</span>
                            </div>
                        </div>
                        <!-- Hyperparameter Importance Matrix / Sensitivity Analysis (4 Cols) -->
                        <div class="lg:col-span-4 bg-surface-container-lowest rounded-xl p-space-md shadow-sm flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between mb-space-sm">
                                    <div class="flex items-center gap-space-xs">
                                        <span class="material-symbols-outlined text-primary text-[18px]">bar_chart</span>
                                        <h2 class="font-headline-sm text-headline-sm text-on-surface">Parameter Importance</h2>
                                    </div>
                                    <span class="px-space-xs py-0.5 rounded bg-surface-container font-label-sm text-label-sm text-on-surface-variant">fANOVA</span>
                                </div>
                                <p class="font-body-sm text-body-sm text-on-surface-variant mb-space-md">Variance contribution to customer churn F1-Score variance.</p>
                                <!-- Ranked Importance Progress Bars -->
                                <div class="space-y-space-sm">
                                    <div class="space-y-1">
                                        <div class="flex justify-between font-code-sm text-code-sm">
                                            <span class="text-on-surface font-semibold">learning_rate</span>
                                            <span class="text-primary font-bold">34.2%</span>
                                        </div>
                                        <div class="w-full h-2 rounded bg-surface-container overflow-hidden">
                                            <div class="h-full bg-primary-container rounded" style="width: 34.2%;"></div>
                                        </div>
                                    </div>
                                    <div class="space-y-1">
                                        <div class="flex justify-between font-code-sm text-code-sm">
                                            <span class="text-on-surface font-semibold">max_depth</span>
                                            <span class="text-primary font-bold">28.5%</span>
                                        </div>
                                        <div class="w-full h-2 rounded bg-surface-container overflow-hidden">
                                            <div class="h-full bg-primary rounded" style="width: 28.5%;"></div>
                                        </div>
                                    </div>
                                    <div class="space-y-1">
                                        <div class="flex justify-between font-code-sm text-code-sm">
                                            <span class="text-on-surface font-semibold">subsample</span>
                                            <span class="text-secondary font-bold">16.4%</span>
                                        </div>
                                        <div class="w-full h-2 rounded bg-surface-container overflow-hidden">
                                            <div class="h-full bg-secondary rounded" style="width: 16.4%;"></div>
                                        </div>
                                    </div>
                                    <div class="space-y-1">
                                        <div class="flex justify-between font-code-sm text-code-sm">
                                            <span class="text-on-surface font-semibold">colsample_bytree</span>
                                            <span class="text-secondary font-bold">11.2%</span>
                                        </div>
                                        <div class="w-full h-2 rounded bg-surface-container overflow-hidden">
                                            <div class="h-full bg-secondary-container rounded" style="width: 11.2%;"></div>
                                        </div>
                                    </div>
                                    <div class="space-y-1">
                                        <div class="flex justify-between font-code-sm text-code-sm">
                                            <span class="text-on-surface font-semibold">reg_lambda</span>
                                            <span class="text-on-surface-variant font-bold">9.7%</span>
                                        </div>
                                        <div class="w-full h-2 rounded bg-surface-container overflow-hidden">
                                            <div class="h-full bg-surface-container-high rounded" style="width: 9.7%;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Analytical Diagnostic Note -->
                            <div class="mt-space-md p-space-xs rounded bg-surface-container-low text-on-surface font-code-sm text-code-sm">
                                <div class="flex items-center gap-1 text-tertiary">
                                    <span class="material-symbols-outlined text-[14px]">lightbulb</span>
                                    <span class="font-bold">Optimization Guidance:</span>
                                </div>
                                <p class="mt-0.5 text-on-surface-variant text-[11px] leading-tight">
                                    Strong joint interaction detected between <code>learning_rate</code> (&lt;0.10) and <code>max_depth</code> (5-7). Restricting bounds increases search efficiency by 24%.
                                </p>
                            </div>
                        </div>
                    </section>
                    <!-- SECTION 3: 2D ISO-CONTOUR SLICE & EXPLORATION DENSITY -->
                    <section class="grid grid-cols-1 md:grid-cols-3 gap-space-md">
                        <!-- Mini Contour Slice: LR vs Max Depth -->
                        <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm">
                            <div class="flex items-center justify-between mb-space-xs">
                                <span class="font-headline-sm text-headline-sm text-on-surface">LR × Depth Iso-Contours</span>
                                <span class="font-code-sm text-code-sm text-primary font-semibold">Slice: F1 Surface</span>
                            </div>
                            <p class="font-body-sm text-body-sm text-on-surface-variant mb-space-sm">Evaluated trial scatter against estimated performance response.</p>
                            <div class="relative w-full h-32 bg-surface-container-low rounded-lg p-2 overflow-hidden flex items-center justify-center">
                                <svg class="w-full h-full" viewbox="0 0 200 90">
                                    <!-- Contour lines -->
                                    <ellipse cx="100" cy="45" fill="none" rx="80" ry="36" stroke="#ccc3d4" stroke-dasharray="2 2" stroke-width="1"></ellipse>
                                    <ellipse cx="95" cy="45" fill="none" rx="55" ry="26" stroke="#dbb8ff" stroke-width="1.2"></ellipse>
                                    <ellipse cx="90" cy="45" fill="#ebdcff" fill-opacity="0.45" rx="30" ry="15" stroke="#6f5092" stroke-width="1.5"></ellipse>
                                    <ellipse cx="85" cy="44" fill="#d9b5ff" fill-opacity="0.75" rx="14" ry="7" stroke="#340075" stroke-width="1.5"></ellipse>
                                    <!-- Scatter trials -->
                                    <circle cx="45" cy="70" fill="#4a4452" r="2"></circle>
                                    <circle cx="160" cy="20" fill="#4a4452" r="2"></circle>
                                    <circle cx="130" cy="65" fill="#6f5092" r="2.5"></circle>
                                    <circle cx="70" cy="30" fill="#6f5092" r="2.5"></circle>
                                    <circle cx="110" cy="40" fill="#340075" r="3"></circle>
                                    <circle cx="85" cy="44" fill="#340075" r="4" stroke="#ffffff" stroke-width="1.5"></circle>
                                    <text fill="#340075" font-family="JetBrains Mono" font-size="8" font-weight="700" x="94" y="47">#42</text>
                                </svg>
                            </div>
                            <div class="flex justify-between items-center mt-2 font-code-sm text-code-sm text-on-surface-variant">
                                <span>lr: 0.01 → 0.30</span>
                                <span>depth: 3 → 12</span>
                            </div>
                        </div>
                        <!-- Algorithmic Split: XGB vs LightGBM vs CatBoost -->
                        <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between mb-space-xs">
                                    <span class="font-headline-sm text-headline-sm text-on-surface">Algorithm Distribution</span>
                                    <span class="font-code-sm text-code-sm text-on-surface-variant">3 Backends</span>
                                </div>
                                <p class="font-body-sm text-body-sm text-on-surface-variant mb-space-sm">Trial density across candidate boosting architectures.</p>
                                <div class="space-y-space-xs">
                                    <div class="flex items-center justify-between text-on-surface font-code-sm text-code-sm">
                                        <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded bg-primary"></span>XGBoost (24 trials)</span>
                                        <span class="font-bold text-primary">Best: 0.825 F1</span>
                                    </div>
                                    <div class="w-full h-1.5 rounded bg-surface-container overflow-hidden">
                                        <div class="h-full bg-primary rounded" style="width: 50%;"></div>
                                    </div>
                                    <div class="flex items-center justify-between text-on-surface font-code-sm text-code-sm pt-1">
                                        <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded bg-secondary"></span>LightGBM (16 trials)</span>
                                        <span class="font-bold text-secondary">Best: 0.812 F1</span>
                                    </div>
                                    <div class="w-full h-1.5 rounded bg-surface-container overflow-hidden">
                                        <div class="h-full bg-secondary rounded" style="width: 33.3%;"></div>
                                    </div>
                                    <div class="flex items-center justify-between text-on-surface font-code-sm text-code-sm pt-1">
                                        <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded bg-tertiary"></span>CatBoost (8 trials)</span>
                                        <span class="font-bold text-tertiary">Best: 0.796 F1</span>
                                    </div>
                                    <div class="w-full h-1.5 rounded bg-surface-container overflow-hidden">
                                        <div class="h-full bg-tertiary rounded" style="width: 16.7%;"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-2 font-code-sm text-code-sm text-on-surface-variant">
                                <span>Winner: <strong>XGBoost</strong> exhibits +1.6% superior validation stability.</span>
                            </div>
                        </div>
                        <!-- Latency Envelope & SLA Guardrail -->
                        <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between mb-space-xs">
                                    <span class="font-headline-sm text-headline-sm text-on-surface">Latency Budget Envelope</span>
                                    <span class="px-space-xs py-0.5 rounded bg-tertiary-fixed text-on-tertiary-fixed font-label-sm text-label-sm">SLA &lt; 50ms</span>
                                </div>
                                <p class="font-body-sm text-body-sm text-on-surface-variant mb-space-sm">Inference time on benchmark CPU worker vs tree complexity.</p>
                                <div class="flex items-end justify-between h-20 pt-2 px-2 bg-surface-container-low rounded-lg gap-2">
                                    <div class="flex-1 flex flex-col items-center gap-1">
                                        <span class="text-[9px] font-code-sm text-on-surface-variant">#08</span>
                                        <div class="w-full bg-secondary rounded-t h-8"></div>
                                        <span class="text-[9px] font-code-sm text-on-surface">12ms</span>
                                    </div>
                                    <div class="flex-1 flex flex-col items-center gap-1">
                                        <span class="text-[9px] font-code-sm text-primary font-bold">#42</span>
                                        <div class="w-full bg-primary-container rounded-t h-12"></div>
                                        <span class="text-[9px] font-code-sm text-primary font-bold">18ms</span>
                                    </div>
                                    <div class="flex-1 flex flex-col items-center gap-1">
                                        <span class="text-[9px] font-code-sm text-on-surface-variant">#27</span>
                                        <div class="w-full bg-secondary rounded-t h-16"></div>
                                        <span class="text-[9px] font-code-sm text-on-surface">26ms</span>
                                    </div>
                                    <div class="flex-1 flex flex-col items-center gap-1">
                                        <span class="text-[9px] font-code-sm text-on-surface-variant">#38</span>
                                        <div class="w-full bg-secondary rounded-t h-20"></div>
                                        <span class="text-[9px] font-code-sm text-on-surface">34ms</span>
                                    </div>
                                    <div class="flex-1 flex flex-col items-center gap-1">
                                        <span class="text-[9px] font-code-sm text-error">#14</span>
                                        <div class="w-full bg-error rounded-t h-28"></div>
                                        <span class="text-[9px] font-code-sm text-error">52ms</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-between items-center mt-2 font-code-sm text-code-sm">
                                <span class="text-on-surface-variant">P95 Fleet Latency:</span>
                                <span class="text-on-surface font-semibold">28.4ms (Passed)</span>
                            </div>
                        </div>
                    </section>
                    <!-- SECTION 4: INTERACTIVE MULTI-TRIAL HYPERPARAMETER MATRIX GRID -->
                    <section class="bg-surface-container-lowest rounded-xl shadow-sm overflow-hidden">
                        <!-- Table Header & Multi-Filter Controls -->
                        <div class="p-space-md bg-surface-container-low flex flex-col lg:flex-row lg:items-center justify-between gap-space-sm">
                            <div class="flex flex-wrap items-center gap-space-sm">
                                <span class="font-headline-sm text-headline-sm text-on-surface">Trial Hyperparameter Matrix</span>
                                <span class="px-space-xs py-0.5 rounded bg-surface-container-highest text-on-surface-variant font-code-sm text-code-sm">48 Rows</span>
                                <!-- Quick Filters -->
                                <div class="flex items-center gap-1 ml-2">
                                    <button class="px-2 py-1 rounded bg-primary text-on-primary font-label-sm text-label-sm">All (48)</button>
                                    <button class="px-2 py-1 rounded bg-surface-container-high hover:bg-surface-container-highest text-on-surface font-label-sm text-label-sm">Passing (≥ 0.80)</button>
                                    <button class="px-2 py-1 rounded bg-surface-container-high hover:bg-surface-container-highest text-on-surface font-label-sm text-label-sm">XGBoost Only</button>
                                    <button class="px-2 py-1 rounded bg-surface-container-high hover:bg-surface-container-highest text-on-surface font-label-sm text-label-sm">LightGBM</button>
                                </div>
                            </div>
                            <div class="flex items-center gap-space-sm">
                                <div class="relative flex items-center">
                                    <span class="material-symbols-outlined text-outline absolute left-2 text-[16px]">search</span>
                                    <input class="pl-7 pr-3 py-1 bg-surface-container-lowest rounded text-on-surface font-code-sm text-code-sm placeholder:text-outline focus:outline-none focus:ring-1 focus:ring-primary shadow-sm" placeholder="Filter trial, param, metric..." type="text" />
                                </div>
                                <button class="h-8 px-space-xs rounded bg-surface-container-high hover:bg-surface-container-highest text-on-surface font-label-sm text-label-sm flex items-center gap-1" title="Column Visibility" type="button">
                                    <span class="material-symbols-outlined text-[15px]">view_column</span>
                                    <span>Columns</span>
                                </button>
                            </div>
                        </div>
                        <!-- High-Density Analytical Table Viewport -->
                        <div class="overflow-x-auto">
                            <table class="w-full text-left font-code-sm text-code-sm border-collapse">
                                <thead>
                                    <tr class="bg-surface-container text-on-surface-variant uppercase font-label-sm text-label-sm">
                                        <th class="py-2.5 px-3 w-8 text-center"><input class="rounded accent-primary" type="checkbox" /></th>
                                        <th class="py-2.5 px-3">Trial ID</th>
                                        <th class="py-2.5 px-3">Framework</th>
                                        <th class="py-2.5 px-3 bg-secondary-fixed/30 text-on-secondary-fixed">learning_rate</th>
                                        <th class="py-2.5 px-3">max_depth</th>
                                        <th class="py-2.5 px-3">n_estimators</th>
                                        <th class="py-2.5 px-3">subsample</th>
                                        <th class="py-2.5 px-3">colsample</th>
                                        <th class="py-2.5 px-3">reg_lambda</th>
                                        <th class="py-2.5 px-3 bg-primary-fixed/40 text-primary font-bold">Val F1 Δ</th>
                                        <th class="py-2.5 px-3">ROC-AUC</th>
                                        <th class="py-2.5 px-3">Latency</th>
                                        <th class="py-2.5 px-3">Epochs</th>
                                        <th class="py-2.5 px-3 text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-surface-container-low">
                                    <!-- ROW 1: Trial #42 (BEST TRIAL - HIGHLIGHTED) -->
                                    <tr class="bg-primary-fixed/20 hover:bg-primary-fixed/30 transition-colors">
                                        <td class="py-2.5 px-3 text-center"><input checked="" class="rounded accent-primary" type="checkbox" /></td>
                                        <td class="py-2.5 px-3 font-bold text-primary flex items-center gap-1">
                                            <span class="material-symbols-outlined text-tertiary text-[14px]">stars</span>
                                            <span>#42</span>
                                            <span class="px-1 py-0.2 rounded bg-tertiary-fixed text-on-tertiary-fixed font-label-sm text-[9px]">BEST</span>
                                        </td>
                                        <td class="py-2.5 px-3"><span class="px-1.5 py-0.5 rounded bg-surface-container text-on-surface font-semibold">XGBoost 1.7.5</span></td>
                                        <td class="py-2.5 px-3 font-semibold text-primary bg-secondary-fixed/20">0.0820</td>
                                        <td class="py-2.5 px-3">6</td>
                                        <td class="py-2.5 px-3">420</td>
                                        <td class="py-2.5 px-3">0.850</td>
                                        <td class="py-2.5 px-3">0.800</td>
                                        <td class="py-2.5 px-3">1.450</td>
                                        <td class="py-2.5 px-3 bg-primary-fixed/50 font-bold text-primary">
                                            <div class="flex items-center gap-1">
                                                <span>0.8251</span>
                                                <span class="text-[10px] text-tertiary font-bold">(+0.025)</span>
                                            </div>
                                        </td>
                                        <td class="py-2.5 px-3 text-on-surface font-semibold">0.8642</td>
                                        <td class="py-2.5 px-3 text-on-surface">18.2ms</td>
                                        <td class="py-2.5 px-3 text-on-surface-variant">318 / 3m 42s</td>
                                        <td class="py-2.5 px-3 text-right">
                                            <div class="flex items-center justify-end gap-1">
                                                <button class="p-1 rounded hover:bg-primary-fixed text-primary" title="Inspect Parameters"><span class="material-symbols-outlined text-[16px]">visibility</span></button>
                                                <button class="p-1 rounded hover:bg-primary-fixed text-primary" title="Export to Notebook"><span class="material-symbols-outlined text-[16px]">code</span></button>
                                                <button class="p-1 rounded hover:bg-primary-fixed text-tertiary" title="Promote to Registry"><span class="material-symbols-outlined text-[16px]">verified</span></button>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- ROW 2: Trial #38 -->
                                    <tr class="hover:bg-surface-container-low transition-colors">
                                        <td class="py-2 px-3 text-center"><input class="rounded accent-primary" type="checkbox" /></td>
                                        <td class="py-2 px-3 font-semibold text-on-surface">#38</td>
                                        <td class="py-2 px-3"><span class="px-1.5 py-0.5 rounded bg-surface-container-low text-on-surface-variant">LightGBM 3.3.5</span></td>
                                        <td class="py-2 px-3 bg-secondary-fixed/10">0.0540</td>
                                        <td class="py-2 px-3">7</td>
                                        <td class="py-2 px-3">550</td>
                                        <td class="py-2 px-3">0.800</td>
                                        <td class="py-2 px-3">0.750</td>
                                        <td class="py-2 px-3">2.100</td>
                                        <td class="py-2 px-3 bg-primary-fixed/10 font-bold text-secondary">
                                            <div class="flex items-center gap-1">
                                                <span>0.8124</span>
                                                <span class="text-[10px] text-tertiary font-bold">(+0.012)</span>
                                            </div>
                                        </td>
                                        <td class="py-2 px-3 text-on-surface">0.8510</td>
                                        <td class="py-2 px-3 text-on-surface">34.1ms</td>
                                        <td class="py-2 px-3 text-on-surface-variant">412 / 4m 05s</td>
                                        <td class="py-2 px-3 text-right">
                                            <div class="flex items-center justify-end gap-1">
                                                <button class="p-1 rounded hover:bg-surface-container text-on-surface-variant" title="Inspect Parameters"><span class="material-symbols-outlined text-[16px]">visibility</span></button>
                                                <button class="p-1 rounded hover:bg-surface-container text-on-surface-variant" title="Export to Notebook"><span class="material-symbols-outlined text-[16px]">code</span></button>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- ROW 3: Trial #27 -->
                                    <tr class="hover:bg-surface-container-low transition-colors">
                                        <td class="py-2 px-3 text-center"><input class="rounded accent-primary" type="checkbox" /></td>
                                        <td class="py-2 px-3 font-semibold text-on-surface">#27</td>
                                        <td class="py-2 px-3"><span class="px-1.5 py-0.5 rounded bg-surface-container-low text-on-surface-variant">XGBoost 1.7.5</span></td>
                                        <td class="py-2 px-3 bg-secondary-fixed/10">0.1100</td>
                                        <td class="py-2 px-3">5</td>
                                        <td class="py-2 px-3">380</td>
                                        <td class="py-2 px-3">0.900</td>
                                        <td class="py-2 px-3">0.850</td>
                                        <td class="py-2 px-3">0.850</td>
                                        <td class="py-2 px-3 bg-primary-fixed/10 font-bold text-secondary">
                                            <div class="flex items-center gap-1">
                                                <span>0.8045</span>
                                                <span class="text-[10px] text-tertiary font-bold">(+0.005)</span>
                                            </div>
                                        </td>
                                        <td class="py-2 px-3 text-on-surface">0.8490</td>
                                        <td class="py-2 px-3 text-on-surface">26.4ms</td>
                                        <td class="py-2 px-3 text-on-surface-variant">290 / 2m 58s</td>
                                        <td class="py-2 px-3 text-right">
                                            <div class="flex items-center justify-end gap-1">
                                                <button class="p-1 rounded hover:bg-surface-container text-on-surface-variant" title="Inspect"><span class="material-symbols-outlined text-[16px]">visibility</span></button>
                                                <button class="p-1 rounded hover:bg-surface-container text-on-surface-variant" title="Export"><span class="material-symbols-outlined text-[16px]">code</span></button>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- ROW 4: Trial #19 (SUB-OPTIMAL) -->
                                    <tr class="hover:bg-surface-container-low transition-colors">
                                        <td class="py-2 px-3 text-center"><input class="rounded accent-primary" type="checkbox" /></td>
                                        <td class="py-2 px-3 font-semibold text-on-surface">#19</td>
                                        <td class="py-2 px-3"><span class="px-1.5 py-0.5 rounded bg-surface-container-low text-on-surface-variant">CatBoost 1.2.0</span></td>
                                        <td class="py-2 px-3 bg-secondary-fixed/10">0.0350</td>
                                        <td class="py-2 px-3">8</td>
                                        <td class="py-2 px-3">600</td>
                                        <td class="py-2 px-3">0.700</td>
                                        <td class="py-2 px-3">0.800</td>
                                        <td class="py-2 px-3">3.500</td>
                                        <td class="py-2 px-3 text-outline">
                                            <div class="flex items-center gap-1">
                                                <span>0.7960</span>
                                                <span class="text-[10px] text-error font-medium">(-0.004)</span>
                                            </div>
                                        </td>
                                        <td class="py-2 px-3 text-on-surface-variant">0.8320</td>
                                        <td class="py-2 px-3 text-on-surface">41.8ms</td>
                                        <td class="py-2 px-3 text-on-surface-variant">510 / 5m 12s</td>
                                        <td class="py-2 px-3 text-right">
                                            <div class="flex items-center justify-end gap-1">
                                                <button class="p-1 rounded hover:bg-surface-container text-on-surface-variant" title="Inspect"><span class="material-symbols-outlined text-[16px]">visibility</span></button>
                                                <button class="p-1 rounded hover:bg-surface-container text-on-surface-variant" title="Export"><span class="material-symbols-outlined text-[16px]">code</span></button>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- ROW 5: Trial #14 (FAILED SLA) -->
                                    <tr class="hover:bg-surface-container-low transition-colors">
                                        <td class="py-2 px-3 text-center"><input class="rounded accent-primary" type="checkbox" /></td>
                                        <td class="py-2 px-3 font-semibold text-on-surface">#14</td>
                                        <td class="py-2 px-3"><span class="px-1.5 py-0.5 rounded bg-surface-container-low text-on-surface-variant">XGBoost 1.7.5</span></td>
                                        <td class="py-2 px-3 bg-secondary-fixed/10">0.0200</td>
                                        <td class="py-2 px-3">11</td>
                                        <td class="py-2 px-3">800</td>
                                        <td class="py-2 px-3">0.950</td>
                                        <td class="py-2 px-3">0.900</td>
                                        <td class="py-2 px-3">0.050</td>
                                        <td class="py-2 px-3 text-secondary">
                                            <div class="flex items-center gap-1">
                                                <span>0.8020</span>
                                                <span class="text-[10px] text-tertiary">(+0.002)</span>
                                            </div>
                                        </td>
                                        <td class="py-2 px-3 text-on-surface">0.8410</td>
                                        <td class="py-2 px-3 text-error font-bold">52.4ms (SLA Viol)</td>
                                        <td class="py-2 px-3 text-on-surface-variant">740 / 7m 30s</td>
                                        <td class="py-2 px-3 text-right">
                                            <div class="flex items-center justify-end gap-1">
                                                <button class="p-1 rounded hover:bg-surface-container text-on-surface-variant" title="Inspect"><span class="material-symbols-outlined text-[16px]">visibility</span></button>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- ROW 6: Trial #08 (FAST / LIGHTWEIGHT) -->
                                    <tr class="hover:bg-surface-container-low transition-colors">
                                        <td class="py-2 px-3 text-center"><input class="rounded accent-primary" type="checkbox" /></td>
                                        <td class="py-2 px-3 font-semibold text-on-surface">#08</td>
                                        <td class="py-2 px-3"><span class="px-1.5 py-0.5 rounded bg-surface-container-low text-on-surface-variant">LightGBM 3.3.5</span></td>
                                        <td class="py-2 px-3 bg-secondary-fixed/10">0.2400</td>
                                        <td class="py-2 px-3">4</td>
                                        <td class="py-2 px-3">150</td>
                                        <td class="py-2 px-3">0.600</td>
                                        <td class="py-2 px-3">0.600</td>
                                        <td class="py-2 px-3">5.000</td>
                                        <td class="py-2 px-3 text-outline">
                                            <div class="flex items-center gap-1">
                                                <span>0.7610</span>
                                                <span class="text-[10px] text-error">(-0.039)</span>
                                            </div>
                                        </td>
                                        <td class="py-2 px-3 text-on-surface-variant">0.8050</td>
                                        <td class="py-2 px-3 text-on-surface font-semibold">12.1ms</td>
                                        <td class="py-2 px-3 text-on-surface-variant">112 / 1m 02s</td>
                                        <td class="py-2 px-3 text-right">
                                            <div class="flex items-center justify-end gap-1">
                                                <button class="p-1 rounded hover:bg-surface-container text-on-surface-variant" title="Inspect"><span class="material-symbols-outlined text-[16px]">visibility</span></button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- Pagination & Row Summary -->
                        <div class="p-space-xs px-space-md bg-surface-container flex items-center justify-between font-code-sm text-code-sm text-on-surface-variant">
                            <span>Displaying 1–6 of 48 trials</span>
                            <div class="flex items-center gap-space-xs">
                                <button class="px-2 py-0.5 rounded bg-surface-container-high text-on-surface hover:bg-surface-container-highest">← Previous</button>
                                <span class="px-2 py-0.5 rounded bg-primary text-on-primary">1</span>
                                <button class="px-2 py-0.5 rounded bg-surface-container-high text-on-surface hover:bg-surface-container-highest">2</button>
                                <button class="px-2 py-0.5 rounded bg-surface-container-high text-on-surface hover:bg-surface-container-highest">3</button>
                                <button class="px-2 py-0.5 rounded bg-surface-container-high text-on-surface hover:bg-surface-container-highest">Next →</button>
                            </div>
                        </div>
                    </section>
                    <!-- SECTION 5: DEEP DIVE TRIAL INSPECTOR & INJECTION DRAWER (TRIAL #42 FOCUS) -->
                    <section class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm">
                        <div class="flex flex-col lg:flex-row gap-space-lg">
                            <!-- Code / Dictionary Export Panel (7 Cols) -->
                            <div class="flex-1 space-y-space-sm">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-space-xs">
                                        <span class="material-symbols-outlined text-primary text-[18px]">terminal</span>
                                        <h3 class="font-headline-sm text-headline-sm text-on-surface">Trial #42 Artifact Config (XGBoost)</h3>
                                    </div>
                                    <button class="px-space-xs py-1 rounded bg-secondary-fixed hover:bg-secondary-fixed-dim text-on-secondary-fixed font-label-sm text-label-sm flex items-center gap-1 transition-colors" onclick="navigator.clipboard.writeText(`best_params = {'learning_rate': 0.082, 'max_depth': 6, 'n_estimators': 420, 'subsample': 0.85, 'colsample_bytree': 0.80, 'reg_lambda': 1.45}`)" title="Copy Dict" type="button">
                                        <span class="material-symbols-outlined text-[14px]">content_copy</span>
                                        <span>Copy Python Dict</span>
                                    </button>
                                </div>
                                <!-- Monospace Code Box -->
                                <div class="p-space-md bg-surface-container-low rounded-lg font-code-sm text-code-sm text-on-surface space-y-1 overflow-x-auto shadow-inner">
                                    <div class="text-outline font-semibold"># Auto-generated by SYS-AI-03 Optuna TPESampler for Ticket TKT-AI-01-CHURN-409</div>
                                    <div><span class="text-primary font-bold">import</span> xgboost <span class="text-primary font-bold">as</span> xgb</div>
                                    <div class="pt-1"><span class="text-secondary font-bold">best_xgb_params</span> = {</div>
                                    <div class="pl-4"><span class="text-tertiary font-medium">'objective'</span>: <span class="text-on-surface">'binary:logistic'</span>,</div>
                                    <div class="pl-4"><span class="text-tertiary font-medium">'eval_metric'</span>: <span class="text-on-surface">'logloss'</span>,</div>
                                    <div class="pl-4"><span class="text-tertiary font-medium">'learning_rate'</span>: <span class="text-primary font-bold">0.082</span>,</div>
                                    <div class="pl-4"><span class="text-tertiary font-medium">'max_depth'</span>: <span class="text-primary font-bold">6</span>,</div>
                                    <div class="pl-4"><span class="text-tertiary font-medium">'n_estimators'</span>: <span class="text-primary font-bold">420</span>,</div>
                                    <div class="pl-4"><span class="text-tertiary font-medium">'subsample'</span>: <span class="text-primary font-bold">0.85</span>,</div>
                                    <div class="pl-4"><span class="text-tertiary font-medium">'colsample_bytree'</span>: <span class="text-primary font-bold">0.80</span>,</div>
                                    <div class="pl-4"><span class="text-tertiary font-medium">'reg_lambda'</span>: <span class="text-primary font-bold">1.45</span>,</div>
                                    <div class="pl-4"><span class="text-tertiary font-medium">'random_state'</span>: <span class="text-primary font-bold">42</span>,</div>
                                    <div class="pl-4"><span class="text-tertiary font-medium">'tree_method'</span>: <span class="text-on-surface">'gpu_hist'</span></div>
                                    <div>}</div>
                                    <div class="pt-1"><span class="text-outline"># F1-Score: 0.8251 | ROC-AUC: 0.8642 | Latency: 18.2ms (Passed all range guardrails)</span></div>
                                </div>
                            </div>
                            <!-- Hardware & Deployment Diagnostics (5 Cols) -->
                            <div class="w-full lg:w-96 flex flex-col justify-between bg-surface-container rounded-lg p-space-md">
                                <div>
                                    <div class="flex items-center justify-between mb-space-xs">
                                        <span class="font-headline-sm text-headline-sm text-on-surface">Execution Profiler</span>
                                        <span class="px-space-xs py-0.5 rounded bg-tertiary-fixed text-on-tertiary-fixed font-label-sm text-label-sm">NODE-GPU-04</span>
                                    </div>
                                    <div class="space-y-space-xs mt-space-sm font-code-sm text-code-sm text-on-surface-variant">
                                        <div class="flex justify-between items-center py-1">
                                            <span>Peak VRAM Allocated:</span>
                                            <span class="text-on-surface font-semibold">3.2 GB / 40 GB (8.0%)</span>
                                        </div>
                                        <div class="flex justify-between items-center py-1">
                                            <span>GPU Compute Utilization:</span>
                                            <span class="text-primary font-bold">84%</span>
                                        </div>
                                        <div class="flex justify-between items-center py-1">
                                            <span>Training Wall Time:</span>
                                            <span class="text-on-surface font-semibold">3 min 42 sec</span>
                                        </div>
                                        <div class="flex justify-between items-center py-1">
                                            <span>Early Stopping Trigger:</span>
                                            <span class="text-on-surface font-semibold">Epoch 318 (patience 25)</span>
                                        </div>
                                        <div class="flex justify-between items-center py-1">
                                            <span>Artifact Footprint:</span>
                                            <span class="text-on-surface font-semibold">14.8 MB (Serialized JSON)</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- Bottom Action Buttons for Promotion and Notebook Integration -->
                                <div class="mt-space-md pt-space-sm space-y-space-xs">
                                    <button class="w-full h-9 rounded bg-surface-container-high hover:bg-surface-container-highest text-on-surface font-label-md text-label-md flex items-center justify-center gap-1.5 transition-colors shadow-sm" type="button">
                                        <span class="material-symbols-outlined text-[16px]">integration_instructions</span>
                                        <span>Export Parameters to Notebook (`churn_eda.ipynb`)</span>
                                    </button>
                                    <button class="w-full h-9 rounded bg-primary text-on-primary font-label-md text-label-md flex items-center justify-center gap-1.5 hover:bg-primary-container transition-all shadow-sm" type="button">
                                        <span class="material-symbols-outlined text-tertiary-fixed text-[16px]">verified</span>
                                        <span>Promote Model to SYS-AI-04 Validation Registry</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </main>
    </div>
    <script src="js/main.js"></script>
</body>

</html>