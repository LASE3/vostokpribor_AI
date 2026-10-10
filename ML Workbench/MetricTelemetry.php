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
                    <div class="flex flex-col"><span class="font-headline-sm text-headline-sm text-on-surface tracking-tight uppercase leading-none">VOSTOKPRIBOR</span><span class="font-label-sm text-label-sm text-primary font-semibold tracking-wider uppercase mt-0.5">SYS-AI-03: EXPERIMENT RUNS &amp; BENCHMARKS</span></div>
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
                <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center shrink-0"><span class="material-symbols-outlined text-on-primary text-[18px]">person</span></div>
            </div>
        </div>
    </header>
    <aside class="fixed left-0 top-16 bottom-0 w-64 bg-surface-container-low z-40 flex flex-col p-space-sm">
        <div class="flex items-center justify-between px-space-xs py-space-xs mb-space-sm"><span class="font-label-sm text-label-sm uppercase text-on-surface-variant font-semibold tracking-wider">Telemetry Workbench</span><span class="material-symbols-outlined text-on-surface-variant text-[16px]">tune</span></div>
        <nav class="flex-1 flex flex-col gap-1 overflow-y-auto" data-active-classes="bg-primary-container text-on-primary font-bold rounded-lg shadow-sm"><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="notebook-workbench" href="NotebookWorkbench.php"><span class="material-symbols-outlined text-[18px]">code</span><span class="font-body-md text-body-md">Notebook Workbench</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="experiment-runs" href="ExperimentRuns.php"><span class="material-symbols-outlined text-[18px]">query_stats</span><span class="font-body-md text-body-md">Experiment Runs</span></a><a aria-current="page" class="flex items-center gap-space-sm px-space-sm py-2 transition-all bg-primary-container text-on-primary font-bold rounded-lg shadow-sm" data-path="metric-telemetry" href="MetricTelemetry.php"><span class="material-symbols-outlined text-[18px]">insights</span><span class="font-body-md text-body-md">Metric Telemetry</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="tensor-inspector" href="TensorInspector.php"><span class="material-symbols-outlined text-[18px]">grid_view</span><span class="font-body-md text-body-md">Tensor Inspector</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="hyperparameter-matrix" href="HyperparameterMatrix.php"><span class="material-symbols-outlined text-[18px]">tune</span><span class="font-body-md text-body-md">Hyperparameter Matrix</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="model-artifacts" href="ModelArtifacts.php"><span class="material-symbols-outlined text-[18px]">inventory_2</span><span class="font-body-md text-body-md">Model Artifacts</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="range-evaluation" href="RangeEvaluation.php"><span class="material-symbols-outlined text-[18px]">verified</span><span class="font-body-md text-body-md">Range Evaluation</span></a></nav>
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
                <!-- Top Command & Run Context Ribbon -->
                <section class="bg-surface-container-low px-space-md py-space-sm shadow-sm flex flex-col gap-space-xs">
                    <div class="flex flex-wrap items-center justify-between gap-space-sm">
                        <div class="flex items-center gap-space-sm flex-wrap min-w-0">
                            <div class="flex items-center gap-1.5 px-space-xs py-0.5 bg-surface-container-highest rounded text-on-surface">
                                <span class="material-symbols-outlined text-[16px] text-primary">analytics</span>
                                <span class="font-label-sm text-label-sm tracking-wider uppercase">TKT-AI-01-CHURN-409</span>
                            </div>
                            <!-- Run Selector Dropdown Style -->
                            <div class="flex items-center gap-1 bg-surface-container-lowest px-space-sm py-1 rounded shadow-sm">
                                <span class="w-2 h-2 rounded-full bg-primary-container animate-pulse"></span>
                                <span class="font-headline-sm text-headline-sm text-on-surface tracking-tight">Run #04</span>
                                <span class="font-code-sm text-code-sm text-primary font-medium">(xgboost_tuned_trial_04)</span>
                                <span class="px-1.5 py-0.5 rounded bg-tertiary-fixed text-on-tertiary-fixed font-label-sm text-label-sm uppercase font-semibold">GOLDEN BENCHMARK</span>
                                <button class="text-on-surface-variant hover:text-on-surface ml-1" title="Switch Run" type="button">
                                    <span class="material-symbols-outlined text-[16px]">arrow_drop_down</span>
                                </button>
                            </div>
                            <div class="hidden sm:flex items-center gap-1 bg-surface-container px-space-xs py-1 rounded">
                                <span class="font-label-sm text-label-sm text-on-surface-variant uppercase">VS</span>
                                <span class="font-code-sm text-code-sm text-on-surface">Run #03 (lightgbm_base)</span>
                                <span class="material-symbols-outlined text-[14px] text-on-surface-variant">sync_alt</span>
                            </div>
                        </div>
                        <!-- Action Utilities -->
                        <div class="flex items-center gap-space-xs flex-wrap">
                            <button class="h-7 px-space-xs rounded bg-surface-container hover:bg-surface-container-high text-on-surface font-label-sm text-label-sm flex items-center gap-1 shadow-sm transition-colors" type="button">
                                <span class="material-symbols-outlined text-[14px] text-primary">download</span>
                                <span>Metric Tensor (Parquet)</span>
                            </button>
                            <button class="h-7 px-space-xs rounded bg-surface-container hover:bg-surface-container-high text-on-surface font-label-sm text-label-sm flex items-center gap-1 shadow-sm transition-colors" type="button">
                                <span class="material-symbols-outlined text-[14px] text-secondary">sensors</span>
                                <span>100Hz Sync: Active</span>
                            </button>
                            <button class="h-7 px-space-sm rounded bg-primary-container hover:bg-primary text-on-primary font-label-sm text-label-sm flex items-center gap-1 shadow-sm transition-colors" type="button">
                                <span class="material-symbols-outlined text-[14px]">bookmark_add</span>
                                <span>Log Artifact</span>
                            </button>
                        </div>
                    </div>
                    <!-- Metadata Attributes Bar -->
                    <div class="flex items-center justify-between text-on-surface-variant flex-wrap gap-y-1 pt-1 bg-surface-container-lowest/50 px-space-xs rounded">
                        <div class="flex items-center gap-space-md flex-wrap font-code-sm text-code-sm">
                            <span class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-[13px] text-secondary">commit</span>
                                <span class="text-on-surface font-semibold">sha:9a20fd4</span>
                            </span>
                            <span class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-[13px] text-secondary">memory</span>
                                <span>XGBoost 1.7.5</span>
                            </span>
                            <span class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-[13px] text-secondary">developer_board</span>
                                <span>NVIDIA A100-SXM4-40GB</span>
                            </span>
                            <span class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-[13px] text-secondary">timer</span>
                                <span>Wall Time: 14.52s</span>
                            </span>
                            <span class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-[13px] text-secondary">park</span>
                                <span>350 Estimators</span>
                            </span>
                        </div>
                        <div class="flex items-center gap-1 font-label-sm text-label-sm text-on-tertiary-fixed-variant">
                            <span class="w-1.5 h-1.5 rounded-full bg-tertiary"></span>
                            <span>SLO Gates: 3 Passed / 0 Breaches</span>
                        </div>
                    </div>
                </section>
                <!-- Row 1: Target vs Observed KPI Cards -->
                <section class="p-space-md grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-gutter">
                    <!-- KPI 1: F1-Score -->
                    <div class="bg-surface-container-lowest p-space-md rounded-xl shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
                        <div>
                            <div class="flex items-center justify-between">
                                <span class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant">Validation F1-Score</span>
                                <span class="px-1.5 py-0.5 rounded bg-tertiary-fixed text-on-tertiary-fixed font-label-sm text-label-sm font-semibold flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[12px]">check_circle</span> PASSED
                                </span>
                            </div>
                            <div class="flex items-baseline gap-space-xs mt-1">
                                <span class="font-headline-xl text-headline-xl text-on-surface font-bold tracking-tight">0.825</span>
                                <span class="font-code-sm text-code-sm text-on-surface-variant">/ target ≥ 0.800</span>
                            </div>
                        </div>
                        <div class="mt-space-sm pt-space-xs bg-surface-container-low p-space-xs rounded flex items-center justify-between">
                            <div class="flex flex-col font-code-sm text-code-sm">
                                <span class="text-primary font-semibold">+0.025 safety margin</span>
                                <span class="text-on-surface-variant">Run #03 delta: +0.038</span>
                            </div>
                            <!-- Sparkline SVG -->
                            <svg class="w-20 h-7 text-primary-container" fill="none" viewbox="0 0 100 30">
                                <path d="M0,24 Q15,22 30,17 T60,11 T85,6 L100,5" stroke="currentColor" stroke-linecap="round" stroke-width="2"></path>
                                <circle cx="100" cy="5" fill="currentColor" r="2.5"></circle>
                            </svg>
                        </div>
                    </div>
                    <!-- KPI 2: ROC-AUC -->
                    <div class="bg-surface-container-lowest p-space-md rounded-xl shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
                        <div>
                            <div class="flex items-center justify-between">
                                <span class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant">Val ROC-AUC</span>
                                <span class="px-1.5 py-0.5 rounded bg-tertiary-fixed text-on-tertiary-fixed font-label-sm text-label-sm font-semibold flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[12px]">check_circle</span> PASSED
                                </span>
                            </div>
                            <div class="flex items-baseline gap-space-xs mt-1">
                                <span class="font-headline-xl text-headline-xl text-on-surface font-bold tracking-tight">0.864</span>
                                <span class="font-code-sm text-code-sm text-on-surface-variant">/ target ≥ 0.850</span>
                            </div>
                        </div>
                        <div class="mt-space-sm pt-space-xs bg-surface-container-low p-space-xs rounded flex items-center justify-between">
                            <div class="flex flex-col font-code-sm text-code-sm">
                                <span class="text-primary font-semibold">+0.014 threshold headroom</span>
                                <span class="text-on-surface-variant">Gini Coeff: 0.728</span>
                            </div>
                            <!-- Sparkline SVG -->
                            <svg class="w-20 h-7 text-secondary" fill="none" viewbox="0 0 100 30">
                                <path d="M0,28 Q20,24 40,15 T75,9 T90,7 L100,6" stroke="currentColor" stroke-linecap="round" stroke-width="2"></path>
                                <circle cx="100" cy="6" fill="currentColor" r="2.5"></circle>
                            </svg>
                        </div>
                    </div>
                    <!-- KPI 3: Precision / Recall Balance -->
                    <div class="bg-surface-container-lowest p-space-md rounded-xl shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
                        <div>
                            <div class="flex items-center justify-between">
                                <span class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant">Precision / Recall</span>
                                <span class="px-1.5 py-0.5 rounded bg-surface-container-highest text-on-surface-variant font-label-sm text-label-sm font-semibold">
                                    BALANCED
                                </span>
                            </div>
                            <div class="flex items-baseline justify-between mt-1">
                                <div class="flex items-baseline gap-1">
                                    <span class="font-headline-md text-headline-md font-bold text-on-surface">P: 0.840</span>
                                </div>
                                <div class="flex items-baseline gap-1">
                                    <span class="font-headline-md text-headline-md font-bold text-on-surface">R: 0.810</span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-space-sm pt-space-xs bg-surface-container-low p-space-xs rounded flex flex-col gap-1">
                            <div class="flex justify-between font-code-sm text-code-sm">
                                <span class="text-on-surface-variant">Macro Avg</span>
                                <span class="text-on-surface font-semibold">0.856</span>
                            </div>
                            <div class="w-full bg-surface-container-high h-1.5 rounded-full overflow-hidden flex">
                                <div class="bg-primary-container h-full w-[51%]"></div>
                                <div class="bg-secondary h-full w-[49%]"></div>
                            </div>
                        </div>
                    </div>
                    <!-- KPI 4: Inference Latency p95 -->
                    <div class="bg-surface-container-lowest p-space-md rounded-xl shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
                        <div>
                            <div class="flex items-center justify-between">
                                <span class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant">Inference Latency (p95)</span>
                                <span class="px-1.5 py-0.5 rounded bg-tertiary-fixed text-on-tertiary-fixed font-label-sm text-label-sm font-semibold flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[12px]">bolt</span> PASSED
                                </span>
                            </div>
                            <div class="flex items-baseline gap-space-xs mt-1">
                                <span class="font-headline-xl text-headline-xl text-on-surface font-bold tracking-tight">18.2<span class="font-body-md text-body-md font-normal text-on-surface-variant ml-1">ms</span></span>
                                <span class="font-code-sm text-code-sm text-on-surface-variant">/ bound &lt; 50ms</span>
                            </div>
                        </div>
                        <div class="mt-space-sm pt-space-xs bg-surface-container-low p-space-xs rounded flex items-center justify-between">
                            <div class="flex flex-col font-code-sm text-code-sm">
                                <span class="text-primary font-semibold">31.8ms SLA safety buffer</span>
                                <span class="text-on-surface-variant">Batch size: 128 items</span>
                            </div>
                            <div class="flex items-center gap-1 font-label-sm text-label-sm text-secondary">
                                <span class="material-symbols-outlined text-[16px]">speed</span>
                                <span>54.9 req/s</span>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Row 2: Deep-Dive Interactive Telemetry Charts (2-Column Grid) -->
                <section class="px-space-md pb-space-md grid grid-cols-1 lg:grid-cols-2 gap-gutter">
                    <!-- Chart Left: Loss & Convergence Curve -->
                    <div class="bg-surface-container-lowest p-space-md rounded-xl shadow-sm flex flex-col">
                        <div class="flex items-center justify-between mb-space-sm pb-space-xs bg-surface-container-low -mx-space-md -mt-space-md px-space-md pt-space-sm rounded-t-xl">
                            <div class="flex items-center gap-space-xs">
                                <span class="material-symbols-outlined text-primary text-[18px]">show_chart</span>
                                <div class="flex flex-col">
                                    <span class="font-headline-sm text-headline-sm text-on-surface font-semibold">LogLoss Convergence Trajectory</span>
                                    <span class="font-code-sm text-code-sm text-on-surface-variant">350 Trees • Early Stopping at Iteration 318</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-1">
                                <button class="px-2 py-0.5 rounded text-on-primary bg-primary font-label-sm text-label-sm shadow-sm" type="button">Run #04</button>
                                <button class="px-2 py-0.5 rounded text-on-surface-variant hover:bg-surface-container font-label-sm text-label-sm" type="button">+ Run #03 (LGBM)</button>
                                <button class="px-2 py-0.5 rounded text-on-surface-variant hover:bg-surface-container font-label-sm text-label-sm" type="button">+ Baseline</button>
                            </div>
                        </div>
                        <!-- Main Loss SVG Graphic -->
                        <div class="relative w-full h-64 bg-surface-container-low rounded-lg p-2 overflow-hidden flex flex-col justify-between">
                            <!-- SVG Grid & Data Paths -->
                            <svg class="w-full h-full" preserveaspectratio="none" viewbox="0 0 500 200">
                                <defs>
                                    <lineargradient id="trainLossGrad" x1="0" x2="0" y1="0" y2="1">
                                        <stop offset="0%" stop-color="#340075" stop-opacity="0.18"></stop>
                                        <stop offset="100%" stop-color="#340075" stop-opacity="0.0"></stop>
                                    </lineargradient>
                                    <lineargradient id="valLossGrad" x1="0" x2="0" y1="0" y2="1">
                                        <stop offset="0%" stop-color="#6f5092" stop-opacity="0.15"></stop>
                                        <stop offset="100%" stop-color="#6f5092" stop-opacity="0.0"></stop>
                                    </lineargradient>
                                </defs>
                                <!-- Horizontal Grid Lines -->
                                <line stroke="#f3ede7" stroke-dasharray="3,3" stroke-width="1" x1="40" x2="490" y1="30" y2="30"></line>
                                <line stroke="#f3ede7" stroke-dasharray="3,3" stroke-width="1" x1="40" x2="490" y1="80" y2="80"></line>
                                <line stroke="#f3ede7" stroke-dasharray="3,3" stroke-width="1" x1="40" x2="490" y1="130" y2="130"></line>
                                <line stroke="#eee7e1" stroke-width="1" x1="40" x2="490" y1="180" y2="180"></line>
                                <!-- Early Stopping Vertical Line at X=420 (Tree 318) -->
                                <line stroke="#ba1a1a" stroke-dasharray="4,2" stroke-width="1.5" x1="420" x2="420" y1="10" y2="180"></line>
                                <rect fill="#ffdad6" height="18" rx="2" width="115" x="360" y="8"></rect>
                                <text fill="#93000a" font-family="JetBrains Mono" font-size="9" x="366" y="21">STOP: 318 (loss=0.384)</text>
                                <!-- Training Loss Area & Curve -->
                                <path d="M 40,175 Q 80,120 160,85 T 300,52 T 420,40 L 485,38 L 485,180 L 40,180 Z" fill="url(#trainLossGrad)"></path>
                                <path d="M 40,175 Q 80,120 160,85 T 300,52 T 420,40 L 485,38" fill="none" stroke="#340075" stroke-width="2"></path>
                                <!-- Validation Loss Area & Curve -->
                                <path d="M 40,165 Q 80,135 160,105 T 300,75 T 420,68 T 485,72" fill="none" stroke="#6f5092" stroke-dasharray="2,0" stroke-width="2"></path>
                                <!-- Best Checkpoint Point -->
                                <circle cx="420" cy="68" fill="#340075" r="4" stroke="#ffffff" stroke-width="2"></circle>
                            </svg>
                            <!-- Dynamic Axis Metadata -->
                            <div class="flex justify-between font-label-sm text-label-sm text-on-surface-variant px-2">
                                <span>Iter: 0 (Loss: 0.693)</span>
                                <span>100</span>
                                <span>200</span>
                                <span class="text-primary font-semibold">318* [Best Checkpoint]</span>
                                <span>350</span>
                            </div>
                        </div>
                        <!-- Loss Delta telemetry strip -->
                        <div class="mt-space-sm grid grid-cols-3 gap-space-xs font-code-sm text-code-sm">
                            <div class="bg-surface-container p-space-xs rounded flex flex-col">
                                <span class="text-on-surface-variant font-label-sm text-label-sm uppercase">Train Logloss</span>
                                <span class="font-bold text-primary">0.241 <span class="text-on-surface-variant font-normal">(-65.2%)</span></span>
                            </div>
                            <div class="bg-surface-container p-space-xs rounded flex flex-col">
                                <span class="text-on-surface-variant font-label-sm text-label-sm uppercase">Val Logloss (Best)</span>
                                <span class="font-bold text-secondary">0.384 <span class="text-on-surface-variant font-normal">(@318)</span></span>
                            </div>
                            <div class="bg-surface-container p-space-xs rounded flex flex-col">
                                <span class="text-on-surface-variant font-label-sm text-label-sm uppercase">Overfitting Gap</span>
                                <span class="font-bold text-on-surface">0.143 <span class="text-primary font-semibold">(Tolerable)</span></span>
                            </div>
                        </div>
                    </div>
                    <!-- Chart Right: ROC & Precision-Recall Dual Visualizer -->
                    <div class="bg-surface-container-lowest p-space-md rounded-xl shadow-sm flex flex-col">
                        <div class="flex items-center justify-between mb-space-sm pb-space-xs bg-surface-container-low -mx-space-md -mt-space-md px-space-md pt-space-sm rounded-t-xl">
                            <div class="flex items-center gap-space-xs">
                                <span class="material-symbols-outlined text-primary text-[18px]">query_stats</span>
                                <div class="flex flex-col">
                                    <span class="font-headline-sm text-headline-sm text-on-surface font-semibold">Discriminator Geometry (ROC &amp; PR)</span>
                                    <span class="font-code-sm text-code-sm text-on-surface-variant">AUC = 0.864 • Optimal Threshold Selected: 0.420</span>
                                </div>
                            </div>
                            <div class="flex items-center bg-surface-container rounded p-0.5">
                                <button class="px-2 py-0.5 rounded bg-primary text-on-primary font-label-sm text-label-sm shadow-sm" type="button">ROC Curve</button>
                                <button class="px-2 py-0.5 rounded text-on-surface-variant hover:text-on-surface font-label-sm text-label-sm" type="button">PR Curve</button>
                            </div>
                        </div>
                        <!-- Main ROC SVG Graphic -->
                        <div class="relative w-full h-64 bg-surface-container-low rounded-lg p-2 overflow-hidden flex flex-col justify-between">
                            <svg class="w-full h-full" preserveaspectratio="none" viewbox="0 0 500 200">
                                <defs>
                                    <lineargradient id="rocAreaGrad" x1="0" x2="0" y1="0" y2="1">
                                        <stop offset="0%" stop-color="#4c1d95" stop-opacity="0.25"></stop>
                                        <stop offset="100%" stop-color="#4c1d95" stop-opacity="0.02"></stop>
                                    </lineargradient>
                                </defs>
                                <!-- Grid Lines -->
                                <line stroke="#f3ede7" stroke-width="1" x1="40" x2="480" y1="20" y2="20"></line>
                                <line stroke="#f3ede7" stroke-width="1" x1="40" x2="480" y1="70" y2="70"></line>
                                <line stroke="#f3ede7" stroke-width="1" x1="40" x2="480" y1="120" y2="120"></line>
                                <line stroke="#eee7e1" stroke-width="1" x1="40" x2="480" y1="170" y2="170"></line>
                                <line stroke="#eee7e1" stroke-width="1" x1="40" x2="40" y1="20" y2="170"></line>
                                <!-- Random Guess Diagonal Line (FPR = TPR) -->
                                <line stroke="#ccc3d4" stroke-dasharray="4,4" stroke-width="1.5" x1="40" x2="480" y1="170" y2="20"></line>
                                <!-- ROC Curve Path -->
                                <path d="M 40,170 Q 50,45 140,36 T 300,26 L 480,20 L 480,170 Z" fill="url(#rocAreaGrad)"></path>
                                <path d="M 40,170 Q 50,45 140,36 T 300,26 L 480,20" fill="none" stroke="#340075" stroke-width="2.5"></path>
                                <!-- Optimal Threshold Circle & Marker: FPR=0.098, TPR=0.810 -->
                                <line stroke="#fedeb3" stroke-dasharray="2,2" stroke-width="1.5" x1="120" x2="120" y1="20" y2="170"></line>
                                <circle cx="120" cy="46" fill="#352407" r="5" stroke="#ffffff" stroke-width="2"></circle>
                                <rect fill="#fedeb3" height="24" rx="3" width="135" x="135" y="40"></rect>
                                <text fill="#281801" font-family="JetBrains Mono" font-size="9.5" font-weight="600" x="141" y="56">Thresh: 0.42 (Sens 81%)</text>
                            </svg>
                            <!-- ROC Axis Labels -->
                            <div class="flex justify-between font-label-sm text-label-sm text-on-surface-variant px-2">
                                <span>FPR 0.0</span>
                                <span>0.25</span>
                                <span>0.50</span>
                                <span>0.75</span>
                                <span>FPR 1.0</span>
                            </div>
                        </div>
                        <!-- Operating Parameters Strip -->
                        <div class="mt-space-sm grid grid-cols-3 gap-space-xs font-code-sm text-code-sm">
                            <div class="bg-surface-container p-space-xs rounded flex flex-col">
                                <span class="text-on-surface-variant font-label-sm text-label-sm uppercase">Opt Cutoff</span>
                                <span class="font-bold text-on-surface">τ = 0.420</span>
                            </div>
                            <div class="bg-surface-container p-space-xs rounded flex flex-col">
                                <span class="text-on-surface-variant font-label-sm text-label-sm uppercase">Sensitivity (TPR)</span>
                                <span class="font-bold text-primary">81.0% (388/479)</span>
                            </div>
                            <div class="bg-surface-container p-space-xs rounded flex flex-col">
                                <span class="text-on-surface-variant font-label-sm text-label-sm uppercase">Specificity (TNR)</span>
                                <span class="font-bold text-secondary">90.2% (1290/1430)</span>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Row 3: Classification Diagnostics & Tensor Telemetry (3-Column Grid) -->
                <section class="px-space-md pb-space-md grid grid-cols-1 lg:grid-cols-3 gap-gutter">
                    <!-- Col 1: Normalized Confusion Matrix Heatmap -->
                    <div class="bg-surface-container-lowest p-space-md rounded-xl shadow-sm flex flex-col">
                        <div class="flex items-center justify-between mb-space-sm pb-space-xs bg-surface-container-low -mx-space-md -mt-space-md px-space-md pt-space-sm rounded-t-xl">
                            <div class="flex items-center gap-space-xs">
                                <span class="material-symbols-outlined text-primary text-[18px]">grid_4x4</span>
                                <span class="font-headline-sm text-headline-sm text-on-surface font-semibold">Confusion Matrix</span>
                            </div>
                            <span class="font-label-sm text-label-sm px-1.5 py-0.5 rounded bg-surface-container-high text-on-surface-variant">N = 1,909 Eval Samples</span>
                        </div>
                        <!-- 2x2 Interactive Heatmap -->
                        <div class="flex flex-col gap-2 my-auto">
                            <div class="flex items-center justify-end font-label-sm text-label-sm text-on-surface-variant">
                                <span class="w-1/2 text-center">Pred Retained (0)</span>
                                <span class="w-1/2 text-center">Pred Churn (1)</span>
                            </div>
                            <!-- Row 1: Actual Retained (0) -->
                            <div class="flex items-center gap-2">
                                <span class="w-16 font-label-sm text-label-sm text-on-surface-variant text-right leading-none">Actual Retain</span>
                                <!-- TN Cell -->
                                <div class="w-1/2 bg-primary-container text-on-primary p-space-sm rounded-lg flex flex-col justify-center items-center shadow-sm">
                                    <span class="font-headline-md text-headline-md font-bold">1,290</span>
                                    <span class="font-code-sm text-code-sm opacity-90">TN: 90.2%</span>
                                </div>
                                <!-- FP Cell -->
                                <div class="w-1/2 bg-surface-container-high text-on-surface p-space-sm rounded-lg flex flex-col justify-center items-center">
                                    <span class="font-headline-md text-headline-md font-bold">140</span>
                                    <span class="font-code-sm text-code-sm text-on-surface-variant">FP: 9.8%</span>
                                </div>
                            </div>
                            <!-- Row 2: Actual Churn (1) -->
                            <div class="flex items-center gap-2">
                                <span class="w-16 font-label-sm text-label-sm text-on-surface-variant text-right leading-none">Actual Churn</span>
                                <!-- FN Cell -->
                                <div class="w-1/2 bg-surface-container text-on-surface p-space-sm rounded-lg flex flex-col justify-center items-center">
                                    <span class="font-headline-md text-headline-md font-bold">91</span>
                                    <span class="font-code-sm text-code-sm text-error">FN: 19.0%</span>
                                </div>
                                <!-- TP Cell -->
                                <div class="w-1/2 bg-secondary text-on-secondary p-space-sm rounded-lg flex flex-col justify-center items-center shadow-sm">
                                    <span class="font-headline-md text-headline-md font-bold">388</span>
                                    <span class="font-code-sm text-code-sm opacity-90">TP: 81.0%</span>
                                </div>
                            </div>
                        </div>
                        <!-- Cost Matrix Penalty Calculator -->
                        <div class="mt-space-md pt-space-xs bg-surface-container-low p-space-xs rounded flex flex-col gap-1">
                            <div class="flex justify-between items-center font-label-sm text-label-sm">
                                <span class="text-on-surface-variant">False Negative Penalty: 5x</span>
                                <span class="text-primary font-semibold">Total Cost: $11,350</span>
                            </div>
                            <div class="font-code-sm text-code-sm text-on-surface-variant">
                                Optimized operating threshold τ=0.42 minimizes retention churn loss.
                            </div>
                        </div>
                    </div>
                    <!-- Col 2: Class-Level Metrics & Calibration Curve -->
                    <div class="bg-surface-container-lowest p-space-md rounded-xl shadow-sm flex flex-col">
                        <div class="flex items-center justify-between mb-space-sm pb-space-xs bg-surface-container-low -mx-space-md -mt-space-md px-space-md pt-space-sm rounded-t-xl">
                            <div class="flex items-center gap-space-xs">
                                <span class="material-symbols-outlined text-primary text-[18px]">table_chart</span>
                                <span class="font-headline-sm text-headline-sm text-on-surface font-semibold">Per-Class Diagnostics</span>
                            </div>
                            <span class="font-label-sm text-label-sm text-secondary font-semibold">Brier Score: 0.118</span>
                        </div>
                        <!-- Tabular per-class breakdown -->
                        <div class="overflow-x-auto">
                            <table class="w-full text-left font-code-sm text-code-sm">
                                <thead>
                                    <tr class="bg-surface-container font-label-sm text-label-sm text-on-surface-variant">
                                        <th class="py-1 px-2 rounded-l">Class</th>
                                        <th class="py-1 px-2">Prec</th>
                                        <th class="py-1 px-2">Rec</th>
                                        <th class="py-1 px-2">F1</th>
                                        <th class="py-1 px-2 rounded-r">Support</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-surface-container-high">
                                    <tr class="hover:bg-surface-container-low">
                                        <td class="py-1.5 px-2 font-semibold text-on-surface">0: Retained</td>
                                        <td class="py-1.5 px-2">0.934</td>
                                        <td class="py-1.5 px-2">0.902</td>
                                        <td class="py-1.5 px-2 font-bold text-primary">0.918</td>
                                        <td class="py-1.5 px-2 text-on-surface-variant">1,430</td>
                                    </tr>
                                    <tr class="hover:bg-surface-container-low">
                                        <td class="py-1.5 px-2 font-semibold text-on-surface">1: Churned</td>
                                        <td class="py-1.5 px-2">0.735</td>
                                        <td class="py-1.5 px-2">0.810</td>
                                        <td class="py-1.5 px-2 font-bold text-primary">0.771</td>
                                        <td class="py-1.5 px-2 text-on-surface-variant">479</td>
                                    </tr>
                                    <tr class="bg-surface-container font-semibold">
                                        <td class="py-1.5 px-2 text-on-surface">Macro Avg</td>
                                        <td class="py-1.5 px-2">0.835</td>
                                        <td class="py-1.5 px-2">0.856</td>
                                        <td class="py-1.5 px-2 text-primary">0.845</td>
                                        <td class="py-1.5 px-2 text-on-surface-variant">1,909</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- Probability Reliability Mini Plot -->
                        <div class="mt-space-md pt-space-xs flex flex-col gap-1">
                            <div class="flex justify-between items-center font-label-sm text-label-sm text-on-surface-variant">
                                <span>Reliability Calibration (10 Bins)</span>
                                <span class="text-primary font-semibold">Calibrated: Platt Scale</span>
                            </div>
                            <div class="h-16 bg-surface-container-low rounded p-1 flex items-end gap-1">
                                <div class="h-[12%] flex-1 bg-surface-container-high rounded-t" title="Bin 1: 0.10"></div>
                                <div class="h-[22%] flex-1 bg-surface-container-high rounded-t" title="Bin 2: 0.20"></div>
                                <div class="h-[31%] flex-1 bg-surface-container-high rounded-t" title="Bin 3: 0.30"></div>
                                <div class="h-[42%] flex-1 bg-secondary rounded-t" title="Bin 4: 0.40"></div>
                                <div class="h-[52%] flex-1 bg-secondary rounded-t" title="Bin 5: 0.50"></div>
                                <div class="h-[61%] flex-1 bg-primary-container rounded-t" title="Bin 6: 0.60"></div>
                                <div class="h-[73%] flex-1 bg-primary-container rounded-t" title="Bin 7: 0.70"></div>
                                <div class="h-[82%] flex-1 bg-primary-container rounded-t" title="Bin 8: 0.80"></div>
                                <div class="h-[91%] flex-1 bg-primary rounded-t" title="Bin 9: 0.90"></div>
                                <div class="h-[99%] flex-1 bg-primary rounded-t" title="Bin 10: 1.00"></div>
                            </div>
                        </div>
                    </div>
                    <!-- Col 3: Feature Importance (MDI & Permutation) -->
                    <div class="bg-surface-container-lowest p-space-md rounded-xl shadow-sm flex flex-col">
                        <div class="flex items-center justify-between mb-space-sm pb-space-xs bg-surface-container-low -mx-space-md -mt-space-md px-space-md pt-space-sm rounded-t-xl">
                            <div class="flex items-center gap-space-xs">
                                <span class="material-symbols-outlined text-primary text-[18px]">bar_chart</span>
                                <span class="font-headline-sm text-headline-sm text-on-surface font-semibold">Feature Gain (MDI)</span>
                            </div>
                            <button class="font-label-sm text-label-sm text-primary hover:underline" type="button">SHAP Summary</button>
                        </div>
                        <!-- Feature Bars List -->
                        <div class="flex flex-col gap-space-sm flex-1 justify-around">
                            <!-- Feature 1 -->
                            <div class="flex flex-col gap-0.5">
                                <div class="flex justify-between font-code-sm text-code-sm">
                                    <span class="font-semibold text-on-surface">monthly_charges</span>
                                    <span class="text-primary font-bold">0.342 ± 0.012</span>
                                </div>
                                <div class="w-full bg-surface-container-high h-2.5 rounded-full overflow-hidden">
                                    <div class="bg-primary-container h-full rounded-full" style="width: 88%;"></div>
                                </div>
                            </div>
                            <!-- Feature 2 -->
                            <div class="flex flex-col gap-0.5">
                                <div class="flex justify-between font-code-sm text-code-sm">
                                    <span class="font-semibold text-on-surface">tenure_months</span>
                                    <span class="text-primary font-bold">0.268 ± 0.009</span>
                                </div>
                                <div class="w-full bg-surface-container-high h-2.5 rounded-full overflow-hidden">
                                    <div class="bg-primary-container h-full rounded-full" style="width: 70%;"></div>
                                </div>
                            </div>
                            <!-- Feature 3 -->
                            <div class="flex flex-col gap-0.5">
                                <div class="flex justify-between font-code-sm text-code-sm">
                                    <span class="font-semibold text-on-surface">contract_type</span>
                                    <span class="text-secondary font-bold">0.185 ± 0.015</span>
                                </div>
                                <div class="w-full bg-surface-container-high h-2.5 rounded-full overflow-hidden">
                                    <div class="bg-secondary h-full rounded-full" style="width: 48%;"></div>
                                </div>
                            </div>
                            <!-- Feature 4 -->
                            <div class="flex flex-col gap-0.5">
                                <div class="flex justify-between font-code-sm text-code-sm">
                                    <span class="font-semibold text-on-surface">tech_support</span>
                                    <span class="text-secondary font-bold">0.114 ± 0.007</span>
                                </div>
                                <div class="w-full bg-surface-container-high h-2.5 rounded-full overflow-hidden">
                                    <div class="bg-secondary-container h-full rounded-full" style="width: 30%;"></div>
                                </div>
                            </div>
                            <!-- Feature 5 -->
                            <div class="flex flex-col gap-0.5">
                                <div class="flex justify-between font-code-sm text-code-sm">
                                    <span class="font-semibold text-on-surface">online_security</span>
                                    <span class="text-on-surface-variant font-bold">0.091 ± 0.005</span>
                                </div>
                                <div class="w-full bg-surface-container-high h-2.5 rounded-full overflow-hidden">
                                    <div class="bg-surface-variant h-full rounded-full" style="width: 24%;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-space-xs pt-space-xs font-label-sm text-label-sm text-on-surface-variant flex items-center justify-between">
                            <span>Cumulative Variance Explained: 89.2%</span>
                            <span class="text-primary font-semibold">14 Features pruned</span>
                        </div>
                    </div>
                </section>
                <!-- Row 4: Hardware Telemetry Strip & Promotion Ribbon -->
                <section class="bg-surface-container-high px-space-md py-space-sm flex flex-col md:flex-row items-center justify-between gap-space-md shadow-inner">
                    <!-- GPU VRAM & Hardware Strip -->
                    <div class="flex items-center gap-space-lg flex-wrap">
                        <div class="flex items-center gap-space-xs">
                            <span class="material-symbols-outlined text-primary text-[20px]">memory_alt</span>
                            <div class="flex flex-col font-code-sm text-code-sm">
                                <span class="text-on-surface font-semibold">GPU VRAM Peak: 3.82 GB / 40.0 GB</span>
                                <span class="text-on-surface-variant">Allocation Footprint: 9.5% SXM4 Dedicated</span>
                            </div>
                        </div>
                        <div class="hidden xl:flex items-center gap-space-xs">
                            <span class="material-symbols-outlined text-secondary text-[20px]">speed</span>
                            <div class="flex flex-col font-code-sm text-code-sm">
                                <span class="text-on-surface font-semibold">PCIe Gen4: 24.8 GB/s</span>
                                <span class="text-on-surface-variant">Throughput: 142.4 TFLOPS (FP16)</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-1.5 px-space-xs py-1 bg-surface-container rounded font-label-sm text-label-sm text-on-surface">
                            <span class="w-2 h-2 rounded-full bg-tertiary"></span>
                            <span>Validation Hash: 8b0f-21aa-4c</span>
                        </div>
                    </div>
                    <!-- Promotion Action Buttons -->
                    <div class="flex items-center gap-space-sm w-full md:w-auto justify-end">
                        <button class="h-9 px-space-md rounded bg-surface-container-lowest hover:bg-surface-container text-on-surface font-label-md text-label-md flex items-center gap-1.5 shadow-sm transition-colors" type="button">
                            <span class="material-symbols-outlined text-[16px]">history_toggle_off</span>
                            <span>Compare All 12 Trials</span>
                        </button>
                        <button class="h-9 px-space-lg rounded bg-primary-container hover:bg-primary text-on-primary font-label-md text-label-md flex items-center gap-2 shadow-md transition-all active:scale-95" type="button">
                            <span class="material-symbols-outlined text-tertiary-fixed text-[18px]">verified</span>
                            <span>Promote Run #04 to SYS-AI-04 Registry</span>
                        </button>
                    </div>
                </section>
            </div>
        </main>
    </div>
    <script src="js/main.js"></script>
</body>

</html>