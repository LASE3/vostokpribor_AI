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
        <nav class="flex-1 flex flex-col gap-1 overflow-y-auto" data-active-classes="bg-primary-container text-on-primary font-bold rounded-lg shadow-sm"><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="notebook-workbench" href="NotebookWorkbench.php"><span class="material-symbols-outlined text-[18px]">code</span><span class="font-body-md text-body-md">Notebook Workbench</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="experiment-runs" href="ExperimentRuns.php"><span class="material-symbols-outlined text-[18px]">query_stats</span><span class="font-body-md text-body-md">Experiment Runs</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="metric-telemetry" href="MetricTelemetry.php"><span class="material-symbols-outlined text-[18px]">insights</span><span class="font-body-md text-body-md">Metric Telemetry</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="tensor-inspector" href="TensorInspector.php"><span class="material-symbols-outlined text-[18px]">grid_view</span><span class="font-body-md text-body-md">Tensor Inspector</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="hyperparameter-matrix" href="HyperparameterMatrix.php"><span class="material-symbols-outlined text-[18px]">tune</span><span class="font-body-md text-body-md">Hyperparameter Matrix</span></a><a aria-current="page" class="flex items-center gap-space-sm px-space-sm py-2 transition-all bg-primary-container text-on-primary font-bold rounded-lg shadow-sm" data-path="model-artifacts" href="ModelArtifacts.php"><span class="material-symbols-outlined text-[18px]">inventory_2</span><span class="font-body-md text-body-md">Model Artifacts</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="range-evaluation" href="RangeEvaluation.php"><span class="material-symbols-outlined text-[18px]">verified</span><span class="font-body-md text-body-md">Range Evaluation</span></a></nav>
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
                <!-- Sub-Header / Breadcrumb & Action Toolbar -->
                <div class="w-full bg-surface-container-low px-space-md py-space-sm shadow-[0_1px_3px_rgba(76,29,149,0.05)]">
                    <div class="flex flex-col 2xl:flex-row 2xl:items-center justify-between gap-space-sm">
                        <!-- Left: Breadcrumb & Context Chips -->
                        <div class="flex flex-wrap items-center gap-space-xs">
                            <div class="flex items-center gap-1.5 font-label-md text-label-md text-on-surface-variant">
                                <span class="material-symbols-outlined text-[15px] text-primary">lan</span>
                                <span class="px-space-xs py-0.5 rounded bg-surface-container font-code-sm text-code-sm text-on-surface font-semibold">TKT-AI-01-CHURN-409</span>
                                <span class="text-outline">/</span>
                                <span class="text-on-surface-variant">artifacts</span>
                                <span class="text-outline">/</span>
                                <span class="px-space-xs py-0.5 rounded bg-secondary-fixed text-on-secondary-fixed font-code-sm text-code-sm font-semibold flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse"></span>
                                    run-409-a1b7e
                                </span>
                                <span class="text-outline-variant font-code-sm text-code-sm">(XGBoost Tuned Benchmark #04)</span>
                            </div>
                            <div class="h-3.5 w-px bg-outline-variant mx-1 hidden sm:block"></div>
                            <span class="inline-flex items-center gap-1 px-space-xs py-0.5 rounded bg-surface-container-highest text-primary font-label-sm text-label-sm uppercase">
                                <span class="material-symbols-outlined text-[12px] text-primary" style="font-variation-settings: 'FILL' 1;">stars</span>
                                Golden Candidate
                            </span>
                        </div>
                        <!-- Right: Action Buttons Group -->
                        <div class="flex flex-wrap items-center gap-space-xs">
                            <button class="h-7 px-space-sm rounded bg-surface-container hover:bg-surface-container-high text-on-surface font-label-sm text-label-sm flex items-center gap-1 shadow-sm transition-transform active:scale-95" title="SHA-256 Digest Validation" type="button">
                                <span class="material-symbols-outlined text-[14px] text-secondary">verified_user</span>
                                <span>Verify Checksums</span>
                            </button>
                            <button class="h-7 px-space-sm rounded bg-surface-container hover:bg-surface-container-high text-on-surface font-label-sm text-label-sm flex items-center gap-1 shadow-sm transition-transform active:scale-95" type="button">
                                <span class="material-symbols-outlined text-[14px] text-secondary">schema</span>
                                <span>Inspect Graph</span>
                            </button>
                            <button class="h-7 px-space-sm rounded bg-secondary-fixed hover:bg-secondary-fixed-dim text-on-secondary-fixed font-label-sm text-label-sm flex items-center gap-1 shadow-sm transition-transform active:scale-95" type="button">
                                <span class="material-symbols-outlined text-[14px]">download</span>
                                <span>Bundle (.tar.gz)</span>
                            </button>
                            <button class="h-7 px-space-md rounded bg-primary-container hover:bg-primary text-on-primary font-label-md text-label-md flex items-center gap-1.5 shadow-md transition-all active:scale-95" type="button">
                                <span class="material-symbols-outlined text-[14px] text-tertiary-fixed">arrow_circle_up</span>
                                <span>Promote to SYS-AI-04 Validation</span>
                            </button>
                        </div>
                    </div>
                    <!-- Storage Telemetry Banner -->
                    <div class="mt-space-xs pt-space-xs flex flex-wrap items-center justify-between gap-y-1 gap-x-space-md text-on-surface-variant font-code-sm text-code-sm bg-surface-container-highest/60 rounded px-space-sm py-1">
                        <div class="flex flex-wrap items-center gap-space-md">
                            <div class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-[13px] text-primary">data_object</span>
                                <span class="text-on-surface-variant">Bundle:</span>
                                <span class="text-on-surface font-semibold">18.7 MB (9 Files, 4 Dirs)</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-[13px] text-secondary">cloud_done</span>
                                <span class="text-on-surface-variant">URI:</span>
                                <span class="text-on-surface font-semibold truncate max-w-xs md:max-w-none">s3://vostok-artifacts/tkt-409/run-04/</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-[13px] text-tertiary-container">speed</span>
                                <span class="text-on-surface-variant">Storage Tier:</span>
                                <span class="text-on-surface font-semibold">Standard NVMe-Tier Hot Pool</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-space-xs">
                            <span class="w-1.5 h-1.5 rounded-full bg-primary"></span>
                            <span class="text-on-surface font-semibold">sha256:4b9f2d1e089c7a2e88a0</span>
                            <span class="text-primary font-label-sm text-label-sm uppercase font-semibold">(Verified Valid)</span>
                        </div>
                    </div>
                </div>
                <!-- Main Multi-Panel Workspace: Explorer + Deep Inspector -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-sm p-space-sm">
                    <!-- Left Explorer: Artifact Directory Tree -->
                    <div class="lg:col-span-4 xl:col-span-3 flex flex-col gap-space-sm">
                        <!-- Directory Tree Card -->
                        <div class="bg-surface-container-lowest rounded-lg shadow-sm flex flex-col overflow-hidden">
                            <!-- Tree Header -->
                            <div class="bg-surface-container-low px-space-sm py-2 flex items-center justify-between">
                                <div class="flex items-center gap-1.5 font-label-md text-label-md text-on-surface uppercase">
                                    <span class="material-symbols-outlined text-[16px] text-primary">folder_supervised</span>
                                    <span>Artifact Hierarchy</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <button class="w-5 h-5 rounded hover:bg-surface-container flex items-center justify-center text-on-surface-variant" title="Collapse All" type="button">
                                        <span class="material-symbols-outlined text-[14px]">unfold_less</span>
                                    </button>
                                    <button class="w-5 h-5 rounded hover:bg-surface-container flex items-center justify-center text-on-surface-variant" title="Refresh Hash Tree" type="button">
                                        <span class="material-symbols-outlined text-[14px]">sync</span>
                                    </button>
                                </div>
                            </div>
                            <!-- Search Filter inside Tree -->
                            <div class="p-space-xs bg-surface-container-lowest">
                                <div class="flex items-center gap-1 px-space-xs py-1 rounded bg-surface-container-low">
                                    <span class="material-symbols-outlined text-[14px] text-outline">filter_alt</span>
                                    <input class="bg-transparent text-on-surface font-code-sm text-code-sm w-full outline-none placeholder:text-outline" placeholder="Filter files (e.g. .xgb, .json)..." type="text" />
                                </div>
                            </div>
                            <!-- Tree Nodes List -->
                            <div class="p-space-xs flex flex-col gap-0.5 text-on-surface font-code-sm text-code-sm select-none max-h-[580px] overflow-y-auto">
                                <!-- Root Folder -->
                                <div class="flex items-center gap-1 py-1 px-space-xs text-on-surface-variant font-semibold">
                                    <span class="material-symbols-outlined text-[15px] text-secondary">folder_open</span>
                                    <span class="text-on-surface">run-409-a1b7e/</span>
                                    <span class="ml-auto font-label-sm text-label-sm text-outline-variant">18.7 MB</span>
                                </div>
                                <!-- Group: model/ -->
                                <div class="pl-space-sm flex flex-col gap-0.5">
                                    <div class="flex items-center gap-1 py-0.5 px-space-xs text-on-surface font-medium hover:bg-surface-container-low rounded cursor-pointer">
                                        <span class="material-symbols-outlined text-[14px] text-primary">folder_open</span>
                                        <span class="font-semibold text-primary">model/</span>
                                        <span class="ml-auto font-label-sm text-label-sm text-outline">3 items</span>
                                    </div>
                                    <!-- Item: model.xgb (ACTIVE) -->
                                    <div class="ml-space-sm flex items-center justify-between py-1.5 px-space-xs rounded bg-primary-container text-on-primary shadow-sm cursor-pointer group">
                                        <div class="flex items-center gap-1.5 min-w-0">
                                            <span class="material-symbols-outlined text-[15px] text-tertiary-fixed shrink-0">view_in_ar</span>
                                            <span class="font-code-sm text-code-sm font-bold truncate">model.xgb</span>
                                        </div>
                                        <div class="flex items-center gap-1 shrink-0 pl-1">
                                            <span class="font-label-sm text-label-sm bg-primary/80 px-1 py-0.2 rounded text-on-primary">3.8 MB</span>
                                            <span class="w-1.5 h-1.5 rounded-full bg-tertiary-fixed"></span>
                                        </div>
                                    </div>
                                    <!-- Item: MLmodel -->
                                    <div class="ml-space-sm flex items-center justify-between py-1 px-space-xs rounded hover:bg-surface-container-low text-on-surface-variant hover:text-on-surface cursor-pointer group">
                                        <div class="flex items-center gap-1.5 min-w-0">
                                            <span class="material-symbols-outlined text-[14px] text-secondary shrink-0">description</span>
                                            <span class="font-code-sm text-code-sm truncate">MLmodel</span>
                                        </div>
                                        <span class="font-label-sm text-label-sm text-outline">1.2 KB</span>
                                    </div>
                                    <!-- Item: conda.yaml -->
                                    <div class="ml-space-sm flex items-center justify-between py-1 px-space-xs rounded hover:bg-surface-container-low text-on-surface-variant hover:text-on-surface cursor-pointer group">
                                        <div class="flex items-center gap-1.5 min-w-0">
                                            <span class="material-symbols-outlined text-[14px] text-outline shrink-0">terminal</span>
                                            <span class="font-code-sm text-code-sm truncate">conda.yaml</span>
                                        </div>
                                        <span class="font-label-sm text-label-sm text-outline">840 B</span>
                                    </div>
                                </div>
                                <!-- Group: pipeline/ -->
                                <div class="pl-space-sm flex flex-col gap-0.5 mt-1">
                                    <div class="flex items-center gap-1 py-0.5 px-space-xs text-on-surface font-medium hover:bg-surface-container-low rounded cursor-pointer">
                                        <span class="material-symbols-outlined text-[14px] text-secondary">folder_open</span>
                                        <span class="font-semibold">pipeline/</span>
                                        <span class="ml-auto font-label-sm text-label-sm text-outline">2 items</span>
                                    </div>
                                    <div class="ml-space-sm flex items-center justify-between py-1 px-space-xs rounded hover:bg-surface-container-low text-on-surface-variant hover:text-on-surface cursor-pointer">
                                        <div class="flex items-center gap-1.5 min-w-0">
                                            <span class="material-symbols-outlined text-[14px] text-secondary shrink-0">conversion_path</span>
                                            <span class="font-code-sm text-code-sm truncate">preprocessor.joblib</span>
                                        </div>
                                        <span class="font-label-sm text-label-sm text-outline">1.1 MB</span>
                                    </div>
                                    <div class="ml-space-sm flex items-center justify-between py-1 px-space-xs rounded hover:bg-surface-container-low text-on-surface-variant hover:text-on-surface cursor-pointer">
                                        <div class="flex items-center gap-1.5 min-w-0">
                                            <span class="material-symbols-outlined text-[14px] text-secondary shrink-0">data_array</span>
                                            <span class="font-code-sm text-code-sm truncate">feature_schema.json</span>
                                        </div>
                                        <span class="font-label-sm text-label-sm text-outline">4.2 KB</span>
                                    </div>
                                </div>
                                <!-- Group: metrics_eval/ -->
                                <div class="pl-space-sm flex flex-col gap-0.5 mt-1">
                                    <div class="flex items-center gap-1 py-0.5 px-space-xs text-on-surface font-medium hover:bg-surface-container-low rounded cursor-pointer">
                                        <span class="material-symbols-outlined text-[14px] text-secondary">folder_open</span>
                                        <span class="font-semibold">metrics_eval/</span>
                                        <span class="ml-auto font-label-sm text-label-sm text-outline">3 items</span>
                                    </div>
                                    <div class="ml-space-sm flex items-center justify-between py-1 px-space-xs rounded hover:bg-surface-container-low text-on-surface-variant hover:text-on-surface cursor-pointer">
                                        <div class="flex items-center gap-1.5 min-w-0">
                                            <span class="material-symbols-outlined text-[14px] text-outline shrink-0">image</span>
                                            <span class="font-code-sm text-code-sm truncate">confusion_matrix.png</span>
                                        </div>
                                        <span class="font-label-sm text-label-sm text-outline">142 KB</span>
                                    </div>
                                    <div class="ml-space-sm flex items-center justify-between py-1 px-space-xs rounded hover:bg-surface-container-low text-on-surface-variant hover:text-on-surface cursor-pointer">
                                        <div class="flex items-center gap-1.5 min-w-0">
                                            <span class="material-symbols-outlined text-[14px] text-outline shrink-0">show_chart</span>
                                            <span class="font-code-sm text-code-sm truncate">roc_pr_curves.parquet</span>
                                        </div>
                                        <span class="font-label-sm text-label-sm text-outline">880 KB</span>
                                    </div>
                                    <div class="ml-space-sm flex items-center justify-between py-1 px-space-xs rounded hover:bg-surface-container-low text-on-surface-variant hover:text-on-surface cursor-pointer">
                                        <div class="flex items-center gap-1.5 min-w-0">
                                            <span class="material-symbols-outlined text-[14px] text-outline shrink-0">assignment</span>
                                            <span class="font-code-sm text-code-sm truncate">classification_report.json</span>
                                        </div>
                                        <span class="font-label-sm text-label-sm text-outline">2.8 KB</span>
                                    </div>
                                </div>
                                <!-- Group: notebook_snapshot/ -->
                                <div class="pl-space-sm flex flex-col gap-0.5 mt-1">
                                    <div class="flex items-center gap-1 py-0.5 px-space-xs text-on-surface font-medium hover:bg-surface-container-low rounded cursor-pointer">
                                        <span class="material-symbols-outlined text-[14px] text-secondary">folder_open</span>
                                        <span class="font-semibold">notebook_snapshot/</span>
                                        <span class="ml-auto font-label-sm text-label-sm text-outline">2 items</span>
                                    </div>
                                    <div class="ml-space-sm flex items-center justify-between py-1 px-space-xs rounded hover:bg-surface-container-low text-on-surface-variant hover:text-on-surface cursor-pointer">
                                        <div class="flex items-center gap-1.5 min-w-0">
                                            <span class="material-symbols-outlined text-[14px] text-outline shrink-0">code_blocks</span>
                                            <span class="font-code-sm text-code-sm truncate">churn_eda_checkpoint.ipynb</span>
                                        </div>
                                        <span class="font-label-sm text-label-sm text-outline">12.4 MB</span>
                                    </div>
                                    <div class="ml-space-sm flex items-center justify-between py-1 px-space-xs rounded hover:bg-surface-container-low text-on-surface-variant hover:text-on-surface cursor-pointer">
                                        <div class="flex items-center gap-1.5 min-w-0">
                                            <span class="material-symbols-outlined text-[14px] text-outline shrink-0">lock</span>
                                            <span class="font-code-sm text-code-sm truncate">runtime_requirements.lock</span>
                                        </div>
                                        <span class="font-label-sm text-label-sm text-outline">1.8 KB</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Quick Lineage & Provenance Metadata Card -->
                        <div class="bg-surface-container-lowest rounded-lg p-space-sm shadow-sm flex flex-col gap-space-xs">
                            <div class="flex items-center justify-between">
                                <span class="font-label-md text-label-md text-primary uppercase font-bold flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px]">account_tree</span>
                                    Lineage Fingerprint
                                </span>
                                <span class="font-code-sm text-code-sm px-1.5 py-0.5 rounded bg-surface-container text-on-surface">P-AI-204</span>
                            </div>
                            <div class="space-y-1 font-body-sm text-body-sm text-on-surface-variant">
                                <div class="flex justify-between items-center py-0.5">
                                    <span class="text-outline">Git Commit:</span>
                                    <span class="font-code-sm text-code-sm text-on-surface font-semibold bg-surface-container px-1 rounded">f9c08e1a (main)</span>
                                </div>
                                <div class="flex justify-between items-center py-0.5">
                                    <span class="text-outline">Training Epoch:</span>
                                    <span class="text-on-surface font-medium">Trial #04 (Final Iter)</span>
                                </div>
                                <div class="flex justify-between items-center py-0.5">
                                    <span class="text-outline">Host Environment:</span>
                                    <span class="text-on-surface font-medium">Docker // cu118-py310</span>
                                </div>
                                <div class="flex justify-between items-center py-0.5">
                                    <span class="text-outline">Compute Node:</span>
                                    <span class="text-on-surface font-medium">a100-sxm4-node-02</span>
                                </div>
                            </div>
                            <div class="mt-space-xs p-space-xs rounded bg-surface-container-low flex items-center gap-space-xs">
                                <span class="material-symbols-outlined text-primary text-[18px]">verified</span>
                                <div class="flex flex-col">
                                    <span class="font-label-sm text-label-sm text-on-surface uppercase font-semibold">Immutable Seal</span>
                                    <span class="font-code-sm text-code-sm text-on-surface-variant">Cryptographically signed by KMS-KEY-AI-90</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Right / Center Panel: Deep File Inspector -->
                    <div class="lg:col-span-8 xl:col-span-9 flex flex-col gap-space-sm">
                        <!-- Selected File Header & Tab Bar -->
                        <div class="bg-surface-container-lowest rounded-lg shadow-sm overflow-hidden">
                            <!-- Header Strip -->
                            <div class="p-space-md bg-surface-container-low flex flex-col md:flex-row md:items-center justify-between gap-space-sm">
                                <div class="flex items-center gap-space-sm">
                                    <div class="w-10 h-10 rounded-lg bg-primary-container flex items-center justify-center shrink-0 shadow-sm">
                                        <span class="material-symbols-outlined text-on-primary text-[22px]">view_in_ar</span>
                                    </div>
                                    <div class="flex flex-col">
                                        <div class="flex items-center gap-space-xs flex-wrap">
                                            <span class="font-headline-sm text-headline-sm text-on-surface font-bold">model.xgb</span>
                                            <span class="font-label-sm text-label-sm px-space-xs py-0.5 rounded bg-secondary-fixed text-on-secondary-fixed font-semibold">XGBoost 1.7.5 Binary Booster</span>
                                            <span class="font-label-sm text-label-sm px-space-xs py-0.5 rounded bg-surface-container-high text-on-surface-variant">3.8 MB</span>
                                        </div>
                                        <div class="flex items-center gap-space-sm mt-0.5 text-on-surface-variant font-code-sm text-code-sm">
                                            <span>Created: 2024-04-12 14:12:08 UTC</span>
                                            <span>•</span>
                                            <span>SHA-256 Verified Digest</span>
                                            <span>•</span>
                                            <span class="text-primary font-semibold">Native Tree Booster</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-space-xs shrink-0">
                                    <button class="h-7 px-space-sm rounded bg-surface-container hover:bg-surface-container-high text-on-surface font-label-sm text-label-sm flex items-center gap-1 shadow-sm" type="button">
                                        <span class="material-symbols-outlined text-[14px]">content_copy</span>
                                        <span>Copy S3 Path</span>
                                    </button>
                                    <button class="h-7 px-space-sm rounded bg-primary-container text-on-primary font-label-sm text-label-sm flex items-center gap-1 shadow-sm hover:bg-primary" type="button">
                                        <span class="material-symbols-outlined text-[14px]">file_download</span>
                                        <span>Download Raw</span>
                                    </button>
                                </div>
                            </div>
                            <!-- Inspector Navigation Tabs -->
                            <div class="px-space-md bg-surface-container-lowest flex items-center gap-space-md overflow-x-auto">
                                <button class="py-2.5 font-label-md text-label-md font-bold text-primary shadow-[inset_0_-2px_0_0] shadow-primary flex items-center gap-1 shrink-0" type="button">
                                    <span class="material-symbols-outlined text-[16px]">overview</span>
                                    <span>Overview &amp; Model Signature</span>
                                </button>
                                <button class="py-2.5 font-label-md text-label-md text-on-surface-variant hover:text-on-surface flex items-center gap-1 shrink-0 transition-colors" type="button">
                                    <span class="material-symbols-outlined text-[16px]">tune</span>
                                    <span>Hyperparameters Snapshot</span>
                                </button>
                                <button class="py-2.5 font-label-md text-label-md text-on-surface-variant hover:text-on-surface flex items-center gap-1 shrink-0 transition-colors" type="button">
                                    <span class="material-symbols-outlined text-[16px]">bar_chart</span>
                                    <span>Feature Importance Gain</span>
                                </button>
                                <button class="py-2.5 font-label-md text-label-md text-on-surface-variant hover:text-on-surface flex items-center gap-1 shrink-0 transition-colors" type="button">
                                    <span class="material-symbols-outlined text-[16px]">data_object</span>
                                    <span>Hex / Header Preview</span>
                                </button>
                            </div>
                        </div>
                        <!-- Bento Grid: Signature + Gates + Hyperparameters + Visual Feature Importance -->
                        <div class="grid grid-cols-1 xl:grid-cols-3 gap-space-sm">
                            <!-- Column 1 & 2: Model Signature & Architecture (Span 2) -->
                            <div class="xl:col-span-2 flex flex-col gap-space-sm">
                                <!-- Signature Details Card -->
                                <div class="bg-surface-container-lowest rounded-lg p-space-md shadow-sm flex flex-col gap-space-sm">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-space-xs">
                                            <span class="material-symbols-outlined text-primary text-[18px]">fingerprint</span>
                                            <span class="font-headline-sm text-headline-sm text-on-surface font-bold">Input/Output Contract (MLmodel Signature)</span>
                                        </div>
                                        <span class="font-label-sm text-label-sm px-space-xs py-0.5 rounded bg-tertiary-fixed text-on-tertiary-fixed font-semibold uppercase">Enforced Strict</span>
                                    </div>
                                    <!-- Two Sub-Panels: Inputs vs Output -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-space-sm">
                                        <!-- Inputs Panel -->
                                        <div class="bg-surface-container-low rounded-lg p-space-sm flex flex-col gap-1.5">
                                            <div class="flex items-center justify-between">
                                                <span class="font-label-sm text-label-sm text-primary font-bold uppercase">Inputs (19 Feature Tensors)</span>
                                                <span class="font-code-sm text-code-sm text-outline">shape: (-1, 19)</span>
                                            </div>
                                            <div class="bg-surface-container-lowest rounded p-space-xs space-y-1 font-code-sm text-code-sm max-h-44 overflow-y-auto">
                                                <div class="flex justify-between items-center py-0.5 px-1 rounded hover:bg-surface-container-low">
                                                    <span class="text-on-surface font-semibold">monthly_charges</span>
                                                    <span class="text-secondary font-label-sm text-label-sm">Tensor[float32]</span>
                                                </div>
                                                <div class="flex justify-between items-center py-0.5 px-1 rounded hover:bg-surface-container-low">
                                                    <span class="text-on-surface font-semibold">tenure_months</span>
                                                    <span class="text-secondary font-label-sm text-label-sm">Tensor[int64]</span>
                                                </div>
                                                <div class="flex justify-between items-center py-0.5 px-1 rounded hover:bg-surface-container-low">
                                                    <span class="text-on-surface font-semibold">contract_type</span>
                                                    <span class="text-secondary font-label-sm text-label-sm">Category[string]</span>
                                                </div>
                                                <div class="flex justify-between items-center py-0.5 px-1 rounded hover:bg-surface-container-low">
                                                    <span class="text-on-surface font-semibold">total_bandwidth_gb</span>
                                                    <span class="text-secondary font-label-sm text-label-sm">Tensor[float32]</span>
                                                </div>
                                                <div class="flex justify-between items-center py-0.5 px-1 rounded hover:bg-surface-container-low">
                                                    <span class="text-on-surface font-semibold">payment_method_code</span>
                                                    <span class="text-secondary font-label-sm text-label-sm">Tensor[int32]</span>
                                                </div>
                                                <div class="flex justify-between items-center py-0.5 px-1 rounded hover:bg-surface-container-low">
                                                    <span class="text-on-surface font-semibold">support_tickets_30d</span>
                                                    <span class="text-secondary font-label-sm text-label-sm">Tensor[int32]</span>
                                                </div>
                                                <div class="flex justify-between items-center py-0.5 px-1 rounded hover:bg-surface-container-low">
                                                    <span class="text-on-surface font-semibold">late_payment_count</span>
                                                    <span class="text-secondary font-label-sm text-label-sm">Tensor[int32]</span>
                                                </div>
                                                <div class="flex justify-between items-center py-0.5 px-1 rounded hover:bg-surface-container-low">
                                                    <span class="text-outline italic">+12 additional features...</span>
                                                    <span class="text-outline font-label-sm text-label-sm">schema verified</span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Output & Flavor Panel -->
                                        <div class="flex flex-col gap-space-sm">
                                            <div class="bg-surface-container-low rounded-lg p-space-sm flex flex-col gap-1.5">
                                                <div class="flex items-center justify-between">
                                                    <span class="font-label-sm text-label-sm text-primary font-bold uppercase">Output Tensor Contract</span>
                                                    <span class="font-code-sm text-code-sm text-outline">shape: (-1, 1)</span>
                                                </div>
                                                <div class="bg-surface-container-lowest rounded p-space-xs font-code-sm text-code-sm">
                                                    <div class="flex justify-between items-center py-0.5">
                                                        <span class="text-on-surface font-semibold">churn_probability</span>
                                                        <span class="text-secondary font-label-sm text-label-sm">Tensor[float32]</span>
                                                    </div>
                                                    <div class="text-outline text-body-sm font-body-sm mt-1">
                                                        Target domain: [0.000, 1.000] (Binary Logistic Sigmoid output)
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="bg-surface-container-low rounded-lg p-space-sm flex flex-col gap-1">
                                                <span class="font-label-sm text-label-sm text-primary font-bold uppercase">Runtime Compatibility Flavor</span>
                                                <div class="flex flex-wrap gap-1 mt-0.5 font-label-sm text-label-sm">
                                                    <span class="px-1.5 py-0.5 rounded bg-surface-container text-on-surface font-semibold">Python: xgboost.core.Booster</span>
                                                    <span class="px-1.5 py-0.5 rounded bg-surface-container text-on-surface font-semibold">ONNX: v1.14</span>
                                                    <span class="px-1.5 py-0.5 rounded bg-surface-container text-on-surface font-semibold">Triton Fil Backend</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Hyperparameter Matrix Banner -->
                                    <div class="mt-space-xs bg-surface-container rounded p-space-sm">
                                        <span class="font-label-sm text-label-sm uppercase text-primary font-bold tracking-wider">Hyperparameter Configuration Snapshot</span>
                                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-space-xs mt-space-xs font-code-sm text-code-sm">
                                            <div class="bg-surface-container-lowest rounded p-space-xs flex flex-col">
                                                <span class="text-outline font-label-sm text-label-sm">objective</span>
                                                <span class="text-on-surface font-bold truncate">binary:logistic</span>
                                            </div>
                                            <div class="bg-surface-container-lowest rounded p-space-xs flex flex-col">
                                                <span class="text-outline font-label-sm text-label-sm">learning_rate</span>
                                                <span class="text-on-surface font-bold">0.0820</span>
                                            </div>
                                            <div class="bg-surface-container-lowest rounded p-space-xs flex flex-col">
                                                <span class="text-outline font-label-sm text-label-sm">max_depth</span>
                                                <span class="text-on-surface font-bold">6</span>
                                            </div>
                                            <div class="bg-surface-container-lowest rounded p-space-xs flex flex-col">
                                                <span class="text-outline font-label-sm text-label-sm">n_estimators</span>
                                                <span class="text-on-surface font-bold">420</span>
                                            </div>
                                            <div class="bg-surface-container-lowest rounded p-space-xs flex flex-col">
                                                <span class="text-outline font-label-sm text-label-sm">subsample</span>
                                                <span class="text-on-surface font-bold">0.850</span>
                                            </div>
                                            <div class="bg-surface-container-lowest rounded p-space-xs flex flex-col">
                                                <span class="text-outline font-label-sm text-label-sm">reg_lambda</span>
                                                <span class="text-on-surface font-bold">1.450</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Feature Importance Breakdown Visual Card -->
                                <div class="bg-surface-container-lowest rounded-lg p-space-md shadow-sm flex flex-col gap-space-sm">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-space-xs">
                                            <span class="material-symbols-outlined text-primary text-[18px]">query_stats</span>
                                            <span class="font-headline-sm text-headline-sm text-on-surface font-bold">Top Feature Importance (Gain Metric)</span>
                                        </div>
                                        <span class="font-code-sm text-code-sm text-outline">Normalized Gain %</span>
                                    </div>
                                    <!-- Visual Bar Metrics Chart -->
                                    <div class="space-y-2.5 font-code-sm text-code-sm">
                                        <!-- Feature 1 -->
                                        <div class="space-y-1">
                                            <div class="flex justify-between items-center">
                                                <span class="text-on-surface font-semibold">contract_type (Month-to-Month)</span>
                                                <span class="text-primary font-bold">34.8%</span>
                                            </div>
                                            <div class="w-full bg-surface-container rounded-full h-2 overflow-hidden">
                                                <div class="bg-primary-container h-full rounded-full transition-all" style="width: 34.8%"></div>
                                            </div>
                                        </div>
                                        <!-- Feature 2 -->
                                        <div class="space-y-1">
                                            <div class="flex justify-between items-center">
                                                <span class="text-on-surface font-semibold">tenure_months</span>
                                                <span class="text-primary font-bold">22.4%</span>
                                            </div>
                                            <div class="w-full bg-surface-container rounded-full h-2 overflow-hidden">
                                                <div class="bg-primary-container h-full rounded-full transition-all" style="width: 22.4%"></div>
                                            </div>
                                        </div>
                                        <!-- Feature 3 -->
                                        <div class="space-y-1">
                                            <div class="flex justify-between items-center">
                                                <span class="text-on-surface font-semibold">monthly_charges</span>
                                                <span class="text-primary font-bold">16.7%</span>
                                            </div>
                                            <div class="w-full bg-surface-container rounded-full h-2 overflow-hidden">
                                                <div class="bg-primary h-full rounded-full transition-all" style="width: 16.7%"></div>
                                            </div>
                                        </div>
                                        <!-- Feature 4 -->
                                        <div class="space-y-1">
                                            <div class="flex justify-between items-center">
                                                <span class="text-on-surface font-semibold">support_tickets_30d</span>
                                                <span class="text-primary font-bold">11.9%</span>
                                            </div>
                                            <div class="w-full bg-surface-container rounded-full h-2 overflow-hidden">
                                                <div class="bg-secondary h-full rounded-full transition-all" style="width: 11.9%"></div>
                                            </div>
                                        </div>
                                        <!-- Feature 5 -->
                                        <div class="space-y-1">
                                            <div class="flex justify-between items-center">
                                                <span class="text-on-surface font-semibold">total_bandwidth_gb</span>
                                                <span class="text-primary font-bold">8.1%</span>
                                            </div>
                                            <div class="w-full bg-surface-container rounded-full h-2 overflow-hidden">
                                                <div class="bg-secondary-container h-full rounded-full transition-all" style="width: 8.1%"></div>
                                            </div>
                                        </div>
                                        <!-- Feature 6 (Others) -->
                                        <div class="space-y-1">
                                            <div class="flex justify-between items-center">
                                                <span class="text-outline">Remaining 14 features aggregated</span>
                                                <span class="text-outline font-semibold">6.1%</span>
                                            </div>
                                            <div class="w-full bg-surface-container rounded-full h-2 overflow-hidden">
                                                <div class="bg-outline-variant h-full rounded-full transition-all" style="width: 6.1%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Column 3: Validation Gate Status Checklist & Serialized Hex Tray -->
                            <div class="xl:col-span-1 flex flex-col gap-space-sm">
                                <!-- Quality Gate Status Card -->
                                <div class="bg-surface-container-lowest rounded-lg p-space-md shadow-sm flex flex-col gap-space-sm">
                                    <div class="flex items-center justify-between">
                                        <span class="font-headline-sm text-headline-sm text-on-surface font-bold flex items-center gap-1">
                                            <span class="material-symbols-outlined text-primary text-[18px]">rule</span>
                                            Quality &amp; Gate Status
                                        </span>
                                        <span class="px-space-xs py-0.5 rounded bg-surface-container text-on-surface font-label-sm text-label-sm font-semibold">4 / 4 PASSED</span>
                                    </div>
                                    <!-- Checklist items -->
                                    <div class="flex flex-col gap-space-xs">
                                        <!-- Gate 1 -->
                                        <div class="p-space-xs rounded bg-surface-container-low flex items-start gap-space-xs">
                                            <span class="material-symbols-outlined text-primary text-[18px] mt-0.5" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                                            <div class="flex flex-col min-w-0">
                                                <span class="font-label-md text-label-md text-on-surface font-bold">Artifact Integrity</span>
                                                <span class="font-body-sm text-body-sm text-on-surface-variant">No NaN weights. Deterministic seed 42. Non-zero gradient checks.</span>
                                                <span class="font-code-sm text-code-sm text-primary mt-0.5">STATUS: PASSED</span>
                                            </div>
                                        </div>
                                        <!-- Gate 2 -->
                                        <div class="p-space-xs rounded bg-surface-container-low flex items-start gap-space-xs">
                                            <span class="material-symbols-outlined text-primary text-[18px] mt-0.5" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                                            <div class="flex flex-col min-w-0">
                                                <span class="font-label-md text-label-md text-on-surface font-bold">Security Scan</span>
                                                <span class="font-body-sm text-body-sm text-on-surface-variant">Pickle Bandit CVE Scan: 0 issues. Safe tensor schema.</span>
                                                <span class="font-code-sm text-code-sm text-primary mt-0.5">STATUS: PASSED (Zero High/Med)</span>
                                            </div>
                                        </div>
                                        <!-- Gate 3 -->
                                        <div class="p-space-xs rounded bg-surface-container-low flex items-start gap-space-xs">
                                            <span class="material-symbols-outlined text-primary text-[18px] mt-0.5" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                                            <div class="flex flex-col min-w-0">
                                                <span class="font-label-md text-label-md text-on-surface font-bold">Latency Envelope</span>
                                                <span class="font-body-sm text-body-sm text-on-surface-variant">18.2ms p95 on target CPU benchmark (Budget &lt; 25.0ms).</span>
                                                <span class="font-code-sm text-code-sm text-primary mt-0.5">STATUS: PASSED (Under threshold)</span>
                                            </div>
                                        </div>
                                        <!-- Gate 4 -->
                                        <div class="p-space-xs rounded bg-surface-container-low flex items-start gap-space-xs">
                                            <span class="material-symbols-outlined text-primary text-[18px] mt-0.5" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                                            <div class="flex flex-col min-w-0">
                                                <span class="font-label-md text-label-md text-on-surface font-bold">Target Objective Goal</span>
                                                <span class="font-body-sm text-body-sm text-on-surface-variant">F1-Score: 0.825 &gt;= 0.800 requirement for ticket TKT-409.</span>
                                                <span class="font-code-sm text-code-sm text-primary mt-0.5">STATUS: PASSED (+0.025 delta)</span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Promotion Readiness Indicator -->
                                    <div class="mt-space-xs p-space-sm rounded-lg bg-surface-container flex flex-col gap-space-xs">
                                        <div class="flex items-center gap-1.5">
                                            <span class="material-symbols-outlined text-secondary text-[16px]">verified</span>
                                            <span class="font-label-md text-label-md text-on-surface font-bold uppercase">Registry Approval Ready</span>
                                        </div>
                                        <p class="font-body-sm text-body-sm text-on-surface-variant">
                                            Artifact package meets automated gate standards for SYS-AI-04 Validation Registry and Canary Rollout stage.
                                        </p>
                                        <button class="mt-1 w-full h-8 rounded bg-primary-container text-on-primary font-label-md text-label-md flex items-center justify-center gap-1.5 shadow-sm hover:bg-primary transition-all" type="button">
                                            <span class="material-symbols-outlined text-[15px] text-tertiary-fixed">publish</span>
                                            <span>Send to SYS-AI-04 Registry</span>
                                        </button>
                                    </div>
                                </div>
                                <!-- Serialized Hex / Magic Byte Preview Card -->
                                <div class="bg-surface-container-lowest rounded-lg p-space-md shadow-sm flex flex-col gap-space-xs">
                                    <div class="flex items-center justify-between">
                                        <span class="font-label-md text-label-md text-primary font-bold uppercase flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[15px]">terminal</span>
                                            Byte Header / Magic Bits
                                        </span>
                                        <span class="font-code-sm text-code-sm text-outline">Offset 0x00</span>
                                    </div>
                                    <div class="bg-surface-container-low rounded p-space-xs font-code-sm text-code-sm text-on-surface overflow-x-auto leading-relaxed select-all">
                                        <span class="text-primary font-bold">78 67 62 6F 6F 73 74 00</span> <span class="text-outline">|</span> <span class="text-secondary font-bold">xgboost.</span><br />
                                        <span class="text-on-surface-variant">01 07 05 00 00 00 00 2A</span> <span class="text-outline">|</span> <span class="text-outline">.......*</span><br />
                                        <span class="text-on-surface-variant">62 69 6E 61 72 79 3A 6C</span> <span class="text-outline">|</span> <span class="text-secondary font-bold">binary:l</span><br />
                                        <span class="text-on-surface-variant">6F 67 69 73 74 69 63 00</span> <span class="text-outline">|</span> <span class="text-secondary font-bold">ogistic.</span><br />
                                        <span class="text-outline">4C 6F 61 64 65 64 20 62</span> <span class="text-outline">|</span> <span class="text-outline">Loaded b</span>
                                    </div>
                                    <span class="font-label-sm text-label-sm text-outline-variant mt-1 text-right">
                                        Signature Validated by libxgboost v1.7.5
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Telemetry Footnote / Status Bar -->
                <div class="w-full bg-surface-container-high px-space-md py-1 flex flex-wrap items-center justify-between gap-space-sm text-on-surface-variant font-code-sm text-code-sm">
                    <div class="flex items-center gap-space-md">
                        <div class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px] text-primary">lan</span>
                            <span>Registry Node: eu-central-registry-01.vostok.internal</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px] text-secondary">cloud_sync</span>
                            <span>Artifact Sync: 100% Replicated (3 AZs)</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-space-sm font-label-sm text-label-sm">
                        <span class="uppercase text-outline font-semibold">TKT-AI-01-CHURN-409</span>
                        <span class="text-outline">/</span>
                        <span class="uppercase text-primary font-bold">SYS-AI-03 ML WORKBENCH</span>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="js/main.js"></script>
</body>

</html>