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
        <nav class="flex-1 flex flex-col gap-1 overflow-y-auto" data-active-classes="bg-primary-container text-on-primary font-bold rounded-lg shadow-sm"><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="notebook-workbench" href="NotebookWorkbench.php"><span class="material-symbols-outlined text-[18px]">code</span><span class="font-body-md text-body-md">Notebook Workbench</span></a><a aria-current="page" class="flex items-center gap-space-sm px-space-sm py-2 transition-all bg-primary-container text-on-primary font-bold rounded-lg shadow-sm" data-path="experiment-runs" href="ExperimentRuns.php"><span class="material-symbols-outlined text-[18px]">query_stats</span><span class="font-body-md text-body-md">Experiment Runs</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="metric-telemetry" href="MetricTelemetry.php"><span class="material-symbols-outlined text-[18px]">insights</span><span class="font-body-md text-body-md">Metric Telemetry</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="tensor-inspector" href="TensorInspector.php"><span class="material-symbols-outlined text-[18px]">grid_view</span><span class="font-body-md text-body-md">Tensor Inspector</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="hyperparameter-matrix" href="HyperparameterMatrix.php"><span class="material-symbols-outlined text-[18px]">tune</span><span class="font-body-md text-body-md">Hyperparameter Matrix</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="model-artifacts" href="ModelArtifacts.php"><span class="material-symbols-outlined text-[18px]">inventory_2</span><span class="font-body-md text-body-md">Model Artifacts</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="range-evaluation" href="RangeEvaluation.php"><span class="material-symbols-outlined text-[18px]">verified</span><span class="font-body-md text-body-md">Range Evaluation</span></a></nav>
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
                <!-- Top Workspace Contextual Ribbon -->
                <div class="w-full bg-surface-container-low px-space-md py-space-xs flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-space-sm min-w-0">
                        <div class="flex items-center gap-1.5 px-space-xs py-0.5 rounded bg-surface-container text-on-surface-variant font-code-sm text-code-sm"><span class="material-symbols-outlined text-secondary text-[14px]">folder_special</span><span>EXPERIMENT: exp-churn-retention-v1</span></div><span class="text-outline-variant font-code-sm text-code-sm">/</span>
                        <div class="flex items-center gap-1 font-label-md text-label-md text-primary font-bold truncate"><span class="material-symbols-outlined text-primary text-[15px]">query_stats</span><span>TKT-AI-01-CHURN-409 (Runs Matrix)</span></div><span class="inline-flex items-center px-1.5 py-0.2 rounded bg-tertiary-fixed text-on-tertiary-fixed font-label-sm text-label-sm font-bold"><span class="material-symbols-outlined text-[12px] mr-1">verified</span>GOLDEN SPLIT VERIFIED</span>
                    </div>
                    <div class="flex items-center gap-space-md">
                        <div class="flex items-center gap-space-xs font-code-sm text-code-sm text-on-surface-variant"><span class="material-symbols-outlined text-primary text-[14px]">database</span><span>Tracking URI: <strong class="text-on-surface">mlflow://sys-ai-03.internal:5000</strong></span></div>
                        <div class="flex items-center gap-space-xs font-code-sm text-code-sm text-on-surface-variant"><span class="w-2 h-2 rounded-full bg-secondary-container"></span><span>Autolog: <strong class="text-on-surface">Active (6 Total Runs)</strong></span></div><button class="px-space-sm py-1 rounded bg-surface-container-high hover:bg-surface-container-highest text-on-surface font-label-sm text-label-sm flex items-center gap-1" type="button"><span class="material-symbols-outlined text-[13px]">tune</span><span>Experiment Config</span></button>
                    </div>
                </div>
                <!-- Tri-Panel Workbench Layout -->
                <div class="w-full flex items-stretch min-h-[calc(100vh-6.5rem)]"><!-- CENTER STAGE: Experiment Runs Comparison & Visual Analytics (Flex 1) -->
                    <section class="flex-1 min-w-0 bg-surface flex flex-col p-space-md overflow-y-auto"><!-- Action & Multi-filter Bar -->
                        <div class="sticky top-0 z-30 bg-surface-container-lowest/95 backdrop-blur-md rounded-xl p-space-xs shadow-md mb-space-md flex flex-wrap items-center justify-between gap-gutter">
                            <div class="flex items-center flex-wrap gap-1">
                                <div class="relative flex items-center bg-surface-container rounded px-2 py-1"><span class="material-symbols-outlined text-[16px] text-outline mr-1">search</span><input class="bg-transparent border-0 font-code-sm text-code-sm text-on-surface placeholder:text-outline focus:outline-none w-44" placeholder="Filter tags or params..." type="text" value="tag:retention-v1" /></div>
                                <div class="h-4 w-px bg-surface-container-high mx-1"></div>
                                <div class="relative inline-flex items-center bg-surface-container rounded px-2 py-1 text-on-surface font-label-sm text-label-sm"><span class="text-on-surface-variant mr-1">Status:</span><span class="font-bold text-primary mr-1">Finished (5)</span><span class="material-symbols-outlined text-[14px] text-outline">expand_more</span></div>
                                <div class="relative inline-flex items-center bg-surface-container rounded px-2 py-1 text-on-surface font-label-sm text-label-sm"><span class="text-on-surface-variant mr-1">Metric Filter:</span><span class="font-bold text-primary mr-1">F1 ≥ 0.80</span><span class="material-symbols-outlined text-[14px] text-outline">expand_more</span></div>
                                <div class="relative inline-flex items-center bg-surface-container rounded px-2 py-1 text-on-surface font-label-sm text-label-sm"><span class="text-on-surface-variant mr-1">Window:</span><span class="font-semibold text-on-surface mr-1">Last 7 Days</span><span class="material-symbols-outlined text-[14px] text-outline">expand_more</span></div>
                                <div class="h-4 w-px bg-surface-container-high mx-1"></div><button class="h-7 px-space-xs rounded bg-primary-container text-on-primary font-label-sm text-label-sm flex items-center gap-1 shadow-sm hover:bg-primary transition-all" title="Compare Selected Runs" type="button"><span class="material-symbols-outlined text-[15px]">compare_arrows</span><span>Compare Runs (Selected: 3)</span></button><button class="h-7 px-space-xs rounded bg-surface-container hover:bg-surface-container-high text-primary font-label-sm text-label-sm flex items-center gap-1" type="button"><span class="material-symbols-outlined text-[14px]">add</span><span>New Run</span></button>
                            </div>
                            <div class="flex items-center gap-space-xs font-code-sm text-code-sm text-on-surface-variant"><button class="h-7 px-space-xs rounded bg-surface-container hover:bg-surface-container-high text-on-surface font-label-sm text-label-sm flex items-center gap-1" title="Export Experiments" type="button"><span class="material-symbols-outlined text-[14px]">download</span><span>Export CSV/JSON</span></button><button class="h-7 px-space-xs rounded bg-surface-container hover:bg-surface-container-high text-on-surface font-label-sm text-label-sm flex items-center gap-1" title="Toggle Layout" type="button"><span class="material-symbols-outlined text-[14px]">dashboard_customize</span><span>Chart Layout</span></button></div>
                        </div><!-- Visual Comparison Panel: Parallel Coordinates & Multi-chart Grid -->
                        <div class="flex flex-col gap-space-md mb-space-md">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-space-md"><!-- Plot 1: Parallel Coordinates / Param to Target Metric -->
                                <div class="bg-surface-container-lowest rounded-xl p-space-sm shadow-sm flex flex-col md:col-span-2">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center gap-space-xs"><span class="material-symbols-outlined text-primary text-[16px]">multiline_chart</span><span class="font-label-sm text-label-sm uppercase font-bold text-on-surface">Parallel Coordinates: Hyperparameters → Metrics</span></div><span class="inline-flex items-center px-1.5 py-0.2 rounded bg-secondary-fixed text-on-secondary-fixed font-label-sm text-label-sm font-bold">Run #04 Selected</span>
                                    </div>
                                    <div class="h-44 w-full flex items-center justify-center"><svg class="w-full h-full text-on-surface" fill="none" viewbox="0 0 540 140"><!-- Axis lines -->
                                            <line stroke="#ccc3d4" stroke-width="1.5" x1="40" x2="40" y1="20" y2="115"></line>
                                            <line stroke="#ccc3d4" stroke-width="1.5" x1="140" x2="140" y1="20" y2="115"></line>
                                            <line stroke="#ccc3d4" stroke-width="1.5" x1="240" x2="240" y1="20" y2="115"></line>
                                            <line stroke="#ccc3d4" stroke-width="1.5" x1="340" x2="340" y1="20" y2="115"></line>
                                            <line stroke="#ccc3d4" stroke-width="1.5" x1="440" x2="440" y1="20" y2="115"></line>
                                            <line stroke="#ccc3d4" stroke-width="1.5" x1="510" x2="510" y1="20" y2="115"></line><!-- Axis Labels Top --><text fill="#4a4452" font-family="JetBrains Mono" font-size="9" font-weight="600" text-anchor="middle" x="40" y="14">learning_rate</text><text fill="#4a4452" font-family="JetBrains Mono" font-size="9" font-weight="600" text-anchor="middle" x="140" y="14">max_depth</text><text fill="#4a4452" font-family="JetBrains Mono" font-size="9" font-weight="600" text-anchor="middle" x="240" y="14">n_estimators</text><text fill="#4a4452" font-family="JetBrains Mono" font-size="9" font-weight="600" text-anchor="middle" x="340" y="14">F1-Score</text><text fill="#4a4452" font-family="JetBrains Mono" font-size="9" font-weight="600" text-anchor="middle" x="440" y="14">ROC-AUC</text><text fill="#4a4452" font-family="JetBrains Mono" font-size="9" font-weight="600" text-anchor="middle" x="510" y="14">Latency(ms)</text><!-- Threshold Band for F1 and ROC-AUC -->
                                            <rect fill="#fedeb3" fill-opacity="0.35" height="35" width="12" x="334" y="20"></rect>
                                            <rect fill="#fedeb3" fill-opacity="0.35" height="30" width="12" x="434" y="20"></rect><!-- Run #02 (Random Forest) Line (Gray) -->
                                            <path d="M 40 85 L 140 70 L 240 90 L 340 95 L 440 90 L 510 50" opacity="0.5" stroke="#7b7483" stroke-width="1.5"></path><!-- Run #03 (LightGBM) Line (Purple 6f5092) -->
                                            <path d="M 40 55 L 140 50 L 240 60 L 340 65 L 440 60 L 510 38" opacity="0.75" stroke="#6f5092" stroke-dasharray="3 2" stroke-width="2"></path><!-- Run #04 (XGBoost Tuned - Golden Best) Line -->
                                            <path d="M 40 35 L 140 32 L 240 30 L 340 28 L 440 24 L 510 28" stroke="#340075" stroke-width="3"></path><!-- Dots on Run #04 -->
                                            <circle cx="40" cy="35" fill="#340075" r="3.5"></circle>
                                            <circle cx="140" cy="32" fill="#340075" r="3.5"></circle>
                                            <circle cx="240" cy="30" fill="#340075" r="3.5"></circle>
                                            <circle cx="340" cy="28" fill="#340075" r="4"></circle>
                                            <circle cx="440" cy="24" fill="#340075" r="4"></circle>
                                            <circle cx="510" cy="28" fill="#340075" r="3.5"></circle><!-- Axis Values Bottom --><text fill="#7b7483" font-family="JetBrains Mono" font-size="8" text-anchor="middle" x="40" y="128">0.01 - 0.20</text><text fill="#7b7483" font-family="JetBrains Mono" font-size="8" text-anchor="middle" x="140" y="128">3 - 12</text><text fill="#7b7483" font-family="JetBrains Mono" font-size="8" text-anchor="middle" x="240" y="128">100 - 500</text><text fill="#340075" font-family="JetBrains Mono" font-size="8" font-weight="700" text-anchor="middle" x="340" y="128">≥0.80 PASS</text><text fill="#340075" font-family="JetBrains Mono" font-size="8" font-weight="700" text-anchor="middle" x="440" y="128">≥0.85 PASS</text><text fill="#7b7483" font-family="JetBrains Mono" font-size="8" text-anchor="middle" x="510" y="128">&lt;50ms</text>
                                        </svg></div>
                                </div><!-- Plot 2: Pareto Frontier: ROC-AUC vs Latency -->
                                <div class="bg-surface-container-lowest rounded-xl p-space-sm shadow-sm flex flex-col">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center gap-space-xs"><span class="material-symbols-outlined text-secondary text-[16px]">scatter_plot</span><span class="font-label-sm text-label-sm uppercase font-bold text-on-surface">Pareto: ROC-AUC vs Latency</span></div><span class="text-[10px] text-outline font-code-sm">Lower left optimal</span>
                                    </div>
                                    <div class="h-44 w-full flex items-center justify-center"><svg class="w-full h-full" fill="none" viewbox="0 0 250 140"><!-- Axis lines -->
                                            <line stroke="#ccc3d4" stroke-width="1.5" x1="30" x2="230" y1="115" y2="115"></line>
                                            <line stroke="#ccc3d4" stroke-width="1.5" x1="30" x2="30" y1="20" y2="115"></line><!-- Axis Labels --><text fill="#7b7483" font-family="JetBrains Mono" font-size="8" text-anchor="middle" x="130" y="132">Inference Latency p95 (ms) →</text><text fill="#7b7483" font-family="JetBrains Mono" font-size="8" text-anchor="middle" transform="rotate(-90 12 65)" x="12" y="65">ROC-AUC ↑</text><!-- Target boundary lines -->
                                            <line stroke="#baa07a" stroke-dasharray="2 2" stroke-width="1" x1="30" x2="230" y1="45" y2="45"></line>
                                            <line stroke="#baa07a" stroke-dasharray="2 2" stroke-width="1" x1="180" x2="180" y1="20" y2="115"></line><text fill="#352407" font-family="JetBrains Mono" font-size="7.5" font-weight="600" x="35" y="41">Target AUC ≥ 0.850</text><!-- Points --><!-- Run #02 -->
                                            <circle cx="145" cy="90" fill="#7b7483" r="5"></circle><text fill="#4a4452" font-family="JetBrains Mono" font-size="7.5" x="155" y="92">#02 (0.789, 32ms)</text><!-- Run #03 -->
                                            <circle cx="95" cy="56" fill="#6f5092" r="5"></circle><text fill="#4a4452" font-family="JetBrains Mono" font-size="7.5" x="105" y="58">#03 (0.832, 22ms)</text><!-- Run #04 Winning Point (Highlighted) -->
                                            <circle cx="75" cy="34" fill="#d9b5ff" r="9"></circle>
                                            <circle cx="75" cy="34" fill="#340075" r="5"></circle><text fill="#340075" font-family="JetBrains Mono" font-size="8" font-weight="700" x="88" y="32">#04 Golden (0.864, 18ms)</text>
                                        </svg></div>
                                </div>
                            </div><!-- Multi-run Loss Convergence Curves -->
                            <div class="bg-surface-container-lowest rounded-xl p-space-sm shadow-sm flex flex-col">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center gap-space-xs"><span class="material-symbols-outlined text-primary text-[16px]">show_chart</span><span class="font-label-sm text-label-sm uppercase font-bold text-on-surface">Validation Loss Convergence across Multi-Trial Runs</span></div>
                                    <div class="flex items-center gap-3 font-code-sm text-code-sm"><span class="flex items-center gap-1 text-primary font-bold"><span class="w-3 h-0.5 bg-primary"></span> Run #04: XGBoost Tuned (Best: 0.384)</span><span class="flex items-center gap-1 text-secondary"><span class="w-3 h-0.5 bg-secondary"></span> Run #03: LightGBM Baseline (0.412)</span><span class="flex items-center gap-1 text-outline"><span class="w-3 h-0.5 bg-outline"></span> Run #02: Random Forest (0.485)</span></div>
                                </div>
                                <div class="h-32 w-full flex items-center justify-center"><svg class="w-full h-full text-primary" fill="none" viewbox="0 0 600 110">
                                        <line stroke="currentColor" stroke-dasharray="2 2" stroke-opacity="0.08" x1="30" x2="580" y1="20" y2="20"></line>
                                        <line stroke="currentColor" stroke-dasharray="2 2" stroke-opacity="0.08" x1="30" x2="580" y1="55" y2="55"></line>
                                        <line stroke="currentColor" stroke-dasharray="2 2" stroke-opacity="0.08" x1="30" x2="580" y1="90" y2="90"></line><!-- Curve Run #02 -->
                                        <path d="M 35 95 Q 160 88, 300 78 T 575 70" stroke="#7b7483" stroke-linecap="round" stroke-width="1.5"></path><!-- Curve Run #03 -->
                                        <path d="M 35 90 Q 160 68, 300 56 T 575 52" stroke="#6f5092" stroke-dasharray="4 2" stroke-linecap="round" stroke-width="2"></path><!-- Curve Run #04 -->
                                        <path d="M 35 92 Q 140 45, 290 32 T 575 24" stroke="#340075" stroke-linecap="round" stroke-width="2.5"></path>
                                        <circle cx="575" cy="24" fill="#340075" r="4"></circle><text fill="#7B7483" font-family="JetBrains Mono" font-size="9" x="35" y="104">Epoch 0</text><text fill="#7B7483" font-family="JetBrains Mono" font-size="9" x="290" y="104">Epoch 175</text><text fill="#7B7483" font-family="JetBrains Mono" font-size="9" x="535" y="104">Epoch 350</text>
                                    </svg></div>
                            </div>
                        </div><!-- Comprehensive Experiment Runs Comparison Table -->
                        <div class="bg-surface-container-lowest rounded-xl shadow-sm overflow-hidden flex flex-col">
                            <div class="flex items-center justify-between px-space-md py-space-xs bg-surface-container-low">
                                <div class="flex items-center gap-space-xs"><span class="material-symbols-outlined text-primary text-[16px]">table_view</span><span class="font-label-sm text-label-sm text-on-surface uppercase font-bold">Experiment Runs Matrix • Exp ID: 42 (TKT-AI-01-CHURN-409)</span><span class="px-1.5 py-0.2 rounded bg-surface-container text-on-surface-variant font-code-sm text-code-sm font-semibold">5 Total Runs</span></div>
                                <div class="flex items-center gap-space-xs"><span class="font-code-sm text-code-sm text-outline">Showing: All active candidates</span></div>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="w-full text-left font-code-sm text-code-sm">
                                    <thead class="bg-surface-container text-primary font-label-sm text-label-sm">
                                        <tr>
                                            <th class="py-2 px-3 w-8"><input checked="" class="rounded" type="checkbox" /></th>
                                            <th class="py-2 px-3">Run ID &amp; Name</th>
                                            <th class="py-2 px-3">Status</th>
                                            <th class="py-2 px-3">Framework</th>
                                            <th class="py-2 px-3">Hyperparameters</th>
                                            <th class="py-2 px-3 text-right">Val F1-Score</th>
                                            <th class="py-2 px-3 text-right">ROC-AUC</th>
                                            <th class="py-2 px-3 text-right">Log Loss</th>
                                            <th class="py-2 px-3 text-right">Latency p95</th>
                                            <th class="py-2 px-3">Artifacts</th>
                                            <th class="py-2 px-3 text-right">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-on-surface"><!-- Run #04: Winning Row -->
                                        <tr class="bg-secondary-fixed/30 hover:bg-secondary-fixed/50 transition-colors border-l-4 border-l-primary">
                                            <td class="py-2.5 px-3"><input checked="" class="rounded text-primary" type="checkbox" /></td>
                                            <td class="py-2.5 px-3">
                                                <div class="flex items-center gap-1 font-bold text-primary"><span class="material-symbols-outlined text-[15px]">star</span><span>Run #04 (xgboost_tuned_trial_04)</span></div>
                                                <div class="text-[10px] text-outline mt-0.5">run-409-a1b7e • Commit #9a20fd</div>
                                            </td>
                                            <td class="py-2.5 px-3"><span class="inline-flex items-center px-1.5 py-0.5 rounded bg-tertiary-fixed text-on-tertiary-fixed font-label-sm text-label-sm font-bold"><span class="material-symbols-outlined text-[12px] mr-0.5">military_tech</span>GOLDEN BEST</span></td>
                                            <td class="py-2.5 px-3"><span class="px-1.5 py-0.5 rounded bg-surface-container font-semibold">XGBoost 1.7.5</span></td>
                                            <td class="py-2.5 px-3 text-[11px] text-on-surface-variant">lr=0.03, depth=6, n_est=350, sub=0.85</td>
                                            <td class="py-2.5 px-3 text-right font-bold text-primary"><span class="inline-flex items-center gap-0.5">0.825 <span class="text-[10px] text-tertiary">[+0.025 ✓]</span></span></td>
                                            <td class="py-2.5 px-3 text-right font-bold text-primary"><span class="inline-flex items-center gap-0.5">0.864 <span class="text-[10px] text-tertiary">[+0.014 ✓]</span></span></td>
                                            <td class="py-2.5 px-3 text-right font-bold text-on-surface">0.384</td>
                                            <td class="py-2.5 px-3 text-right font-bold text-primary">18ms</td>
                                            <td class="py-2.5 px-3"><span class="px-1.5 py-0.5 rounded bg-surface-container text-on-surface text-[10px]">4 files (4.2MB)</span></td>
                                            <td class="py-2.5 px-3 text-right">
                                                <div class="flex items-center justify-end gap-1"><button class="px-2 py-1 rounded bg-primary-container text-on-primary font-label-sm text-label-sm font-bold shadow-sm hover:bg-primary transition-colors" title="Promote to Registry" type="button">Promote</button><button class="p-1 rounded hover:bg-surface-container-high text-on-surface-variant" title="View Artifacts" type="button"><span class="material-symbols-outlined text-[15px]">inventory_2</span></button></div>
                                            </td>
                                        </tr><!-- Run #03: Baseline LightGBM -->
                                        <tr class="bg-surface-container-lowest hover:bg-surface-container-low transition-colors">
                                            <td class="py-2 px-3"><input checked="" class="rounded" type="checkbox" /></td>
                                            <td class="py-2 px-3">
                                                <div class="font-medium text-on-surface">Run #03 (lightgbm_baseline_trial)</div>
                                                <div class="text-[10px] text-outline mt-0.5">run-409-e4d29 • Commit #8c109a</div>
                                            </td>
                                            <td class="py-2 px-3"><span class="inline-flex items-center px-1.5 py-0.5 rounded bg-surface-container text-on-surface-variant font-label-sm text-label-sm font-semibold">Finished</span></td>
                                            <td class="py-2 px-3"><span class="px-1.5 py-0.5 rounded bg-surface-container">LightGBM 3.3.5</span></td>
                                            <td class="py-2.5 px-3 text-[11px] text-outline">lr=0.05, num_leaves=31, n_est=200</td>
                                            <td class="py-2.5 px-3 text-right text-error font-medium">0.791 <span class="text-[10px]">[-0.009 ✗]</span></td>
                                            <td class="py-2.5 px-3 text-right text-error font-medium">0.832 <span class="text-[10px]">[-0.018 ✗]</span></td>
                                            <td class="py-2.5 px-3 text-right text-outline">0.412</td>
                                            <td class="py-2.5 px-3 text-right text-on-surface">22ms</td>
                                            <td class="py-2.5 px-3"><span class="text-outline text-[10px]">3 files (2.8MB)</span></td>
                                            <td class="py-2.5 px-3 text-right">
                                                <div class="flex items-center justify-end gap-1"><button class="px-2 py-1 rounded bg-surface-container hover:bg-surface-container-high text-on-surface font-label-sm text-label-sm" type="button">Inspect</button><button class="p-1 rounded hover:bg-surface-container-high text-on-surface-variant" title="Logs" type="button"><span class="material-symbols-outlined text-[15px]">article</span></button></div>
                                            </td>
                                        </tr><!-- Run #02: Random Forest -->
                                        <tr class="bg-surface-container-low hover:bg-surface-container transition-colors">
                                            <td class="py-2 px-3"><input checked="" class="rounded" type="checkbox" /></td>
                                            <td class="py-2 px-3">
                                                <div class="font-medium text-on-surface">Run #02 (rf_ensemble_init)</div>
                                                <div class="text-[10px] text-outline mt-0.5">run-409-b7891 • Commit #7b43a2</div>
                                            </td>
                                            <td class="py-2 px-3"><span class="inline-flex items-center px-1.5 py-0.5 rounded bg-surface-container text-on-surface-variant font-label-sm text-label-sm font-semibold">Finished</span></td>
                                            <td class="py-2 px-3"><span class="px-1.5 py-0.5 rounded bg-surface-container">scikit-learn 1.2</span></td>
                                            <td class="py-2.5 px-3 text-[11px] text-outline">n_est=250, max_features=sqrt, d=10</td>
                                            <td class="py-2.5 px-3 text-right text-error font-medium">0.742 <span class="text-[10px]">[-0.058 ✗]</span></td>
                                            <td class="py-2.5 px-3 text-right text-error font-medium">0.789 <span class="text-[10px]">[-0.061 ✗]</span></td>
                                            <td class="py-2.5 px-3 text-right text-outline">0.485</td>
                                            <td class="py-2.5 px-3 text-right text-outline">32ms</td>
                                            <td class="py-2.5 px-3"><span class="text-outline text-[10px]">3 files (18.1MB)</span></td>
                                            <td class="py-2.5 px-3 text-right">
                                                <div class="flex items-center justify-end gap-1"><button class="px-2 py-1 rounded bg-surface-container hover:bg-surface-container-high text-on-surface font-label-sm text-label-sm" type="button">Inspect</button><button class="p-1 rounded hover:bg-surface-container-high text-on-surface-variant" title="Logs" type="button"><span class="material-symbols-outlined text-[15px]">article</span></button></div>
                                            </td>
                                        </tr><!-- Run #01: Logistic Baseline -->
                                        <tr class="bg-surface-container-lowest hover:bg-surface-container-low transition-colors">
                                            <td class="py-2 px-3"><input class="rounded" type="checkbox" /></td>
                                            <td class="py-2 px-3">
                                                <div class="font-medium text-on-surface">Run #01 (logistic_regression_l2)</div>
                                                <div class="text-[10px] text-outline mt-0.5">run-409-f0183 • Commit #5d2210</div>
                                            </td>
                                            <td class="py-2 px-3"><span class="inline-flex items-center px-1.5 py-0.5 rounded bg-surface-container text-on-surface-variant font-label-sm text-label-sm font-semibold">Finished</span></td>
                                            <td class="py-2 px-3"><span class="px-1.5 py-0.5 rounded bg-surface-container">scikit-learn 1.2</span></td>
                                            <td class="py-2.5 px-3 text-[11px] text-outline">C=0.1, penalty=l2, solver=lbfgs</td>
                                            <td class="py-2.5 px-3 text-right text-error font-medium">0.684 <span class="text-[10px]">[-0.116 ✗]</span></td>
                                            <td class="py-2.5 px-3 text-right text-error font-medium">0.715 <span class="text-[10px]">[-0.135 ✗]</span></td>
                                            <td class="py-2.5 px-3 text-right text-outline">0.540</td>
                                            <td class="py-2.5 px-3 text-right text-on-surface">4ms</td>
                                            <td class="py-2.5 px-3"><span class="text-outline text-[10px]">2 files (0.4MB)</span></td>
                                            <td class="py-2.5 px-3 text-right">
                                                <div class="flex items-center justify-end gap-1"><button class="px-2 py-1 rounded bg-surface-container hover:bg-surface-container-high text-on-surface font-label-sm text-label-sm" type="button">Inspect</button><button class="p-1 rounded hover:bg-surface-container-high text-on-surface-variant" title="Logs" type="button"><span class="material-symbols-outlined text-[15px]">article</span></button></div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section><!-- Splitter Separator -->
                    <div class="w-1 bg-surface-container-high hover:bg-primary-container cursor-col-resize shrink-0 transition-colors"></div><!-- RIGHT PANEL: Selected Run Deep Dive & Promotion Drawer (340px) -->
                    <aside class="w-80 bg-surface-container-low shrink-0 flex flex-col p-space-sm overflow-y-auto" id="right-panel"><!-- Drawer Header -->
                        <div class="flex items-center justify-between pb-space-xs mb-space-xs"><span class="font-label-sm text-label-sm uppercase font-bold text-primary flex items-center gap-1"><span class="material-symbols-outlined text-[15px]">biotech</span> Run #04 Deep Dive</span><button class="p-0.5 rounded text-on-surface-variant hover:text-on-surface" title="Collapse Drawer" type="button"><span class="material-symbols-outlined text-[15px]">last_page</span></button></div><!-- Selected Run ID Summary Card -->
                        <div class="bg-surface-container-lowest rounded-xl p-space-sm shadow-sm flex flex-col gap-space-xs mb-space-md">
                            <div class="flex items-center justify-between"><span class="font-label-sm text-label-sm uppercase font-bold text-secondary">Active Run Focus</span><span class="inline-flex items-center px-1.5 py-0.2 rounded bg-tertiary-fixed text-on-tertiary-fixed font-label-sm text-label-sm font-bold">BENCHMARK LEADER</span></div>
                            <div>
                                <div class="font-headline-sm text-headline-sm font-bold text-on-surface">xgboost_tuned_trial_04</div>
                                <p class="font-body-sm text-body-sm text-on-surface-variant mt-0.5">Run ID: <strong>run-409-a1b7e</strong> • Golden Split</p>
                            </div><!-- Target Compliance Spec Matrix -->
                            <div class="mt-space-xs flex flex-col gap-1.5">
                                <div class="p-2 rounded bg-surface-container-low flex flex-col gap-1">
                                    <div class="flex items-center justify-between font-label-sm text-label-sm"><span class="text-on-surface-variant font-bold">Validation F1-Score</span><span class="text-primary font-bold">0.825 / 0.800 ✓</span></div>
                                    <div class="w-full bg-surface-container-high rounded-full h-1.5 overflow-hidden">
                                        <div class="bg-primary h-full w-[100%]"></div>
                                    </div><span class="text-[10px] text-tertiary font-medium">Ticket Goal Met (+0.025 margin)</span>
                                </div>
                                <div class="p-2 rounded bg-surface-container-low flex flex-col gap-1">
                                    <div class="flex items-center justify-between font-label-sm text-label-sm"><span class="text-on-surface-variant font-bold">ROC-AUC Requirement</span><span class="text-primary font-bold">0.864 / 0.850 ✓</span></div>
                                    <div class="w-full bg-surface-container-high rounded-full h-1.5 overflow-hidden">
                                        <div class="bg-primary h-full w-[100%]"></div>
                                    </div><span class="text-[10px] text-tertiary font-medium">Ticket Goal Met (+0.014 margin)</span>
                                </div>
                                <div class="p-2 rounded bg-surface-container-low flex flex-col gap-1">
                                    <div class="flex items-center justify-between font-label-sm text-label-sm"><span class="text-on-surface-variant font-bold">Latency p95 bound</span><span class="text-primary font-bold">18ms / &lt;50ms ✓</span></div>
                                    <div class="w-full bg-surface-container-high rounded-full h-1.5 overflow-hidden">
                                        <div class="bg-secondary-container h-full w-[36%]"></div>
                                    </div><span class="text-[10px] text-outline font-medium">Strict inference bound satisfied</span>
                                </div>
                            </div>
                        </div><!-- Hyperparameter Breakdown Table -->
                        <div class="bg-surface-container-lowest rounded-xl p-space-sm shadow-sm flex flex-col gap-space-xs mb-space-md"><span class="font-label-sm text-label-sm uppercase font-bold text-on-surface flex items-center gap-1"><span class="material-symbols-outlined text-[14px] text-secondary">tune</span> Hyperparameters</span>
                            <div class="grid grid-cols-2 gap-1 text-[11px] font-code-sm text-code-sm">
                                <div class="p-1.5 rounded bg-surface-container-low flex flex-col"><span class="text-outline text-[10px]">learning_rate</span><span class="font-bold text-on-surface">0.03</span></div>
                                <div class="p-1.5 rounded bg-surface-container-low flex flex-col"><span class="text-outline text-[10px]">max_depth</span><span class="font-bold text-on-surface">6</span></div>
                                <div class="p-1.5 rounded bg-surface-container-low flex flex-col"><span class="text-outline text-[10px]">n_estimators</span><span class="font-bold text-on-surface">350</span></div>
                                <div class="p-1.5 rounded bg-surface-container-low flex flex-col"><span class="text-outline text-[10px]">subsample</span><span class="font-bold text-on-surface">0.85</span></div>
                                <div class="p-1.5 rounded bg-surface-container-low flex flex-col"><span class="text-outline text-[10px]">colsample_bytree</span><span class="font-bold text-on-surface">0.80</span></div>
                                <div class="p-1.5 rounded bg-surface-container-low flex flex-col"><span class="text-outline text-[10px]">eval_metric</span><span class="font-bold text-on-surface">logloss</span></div>
                            </div>
                        </div><!-- Feature Importance Breakdown (SHAP / Gain) -->
                        <div class="bg-surface-container-lowest rounded-xl p-space-sm shadow-sm flex flex-col gap-space-xs mb-space-md">
                            <div class="flex items-center justify-between"><span class="font-label-sm text-label-sm uppercase font-bold text-on-surface flex items-center gap-1"><span class="material-symbols-outlined text-[14px] text-primary">bar_chart</span> Feature Importance</span><span class="text-[10px] text-outline font-code-sm">Gain (MDI)</span></div>
                            <div class="flex flex-col gap-1.5 font-code-sm text-code-sm mt-1">
                                <div class="flex flex-col gap-0.5">
                                    <div class="flex items-center justify-between text-[11px]"><span class="text-on-surface font-medium truncate">monthly_charges</span><span class="text-primary font-bold">0.342</span></div>
                                    <div class="w-full bg-surface-container-high rounded-full h-1 overflow-hidden">
                                        <div class="bg-primary h-full w-[85%]"></div>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-0.5">
                                    <div class="flex items-center justify-between text-[11px]"><span class="text-on-surface font-medium truncate">tenure_months</span><span class="text-primary font-bold">0.268</span></div>
                                    <div class="w-full bg-surface-container-high rounded-full h-1 overflow-hidden">
                                        <div class="bg-primary h-full w-[67%]"></div>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-0.5">
                                    <div class="flex items-center justify-between text-[11px]"><span class="text-on-surface font-medium truncate">contract_type</span><span class="text-secondary font-bold">0.185</span></div>
                                    <div class="w-full bg-surface-container-high rounded-full h-1 overflow-hidden">
                                        <div class="bg-secondary h-full w-[46%]"></div>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-0.5">
                                    <div class="flex items-center justify-between text-[11px]"><span class="text-on-surface font-medium truncate">tech_support</span><span class="text-secondary font-bold">0.114</span></div>
                                    <div class="w-full bg-surface-container-high rounded-full h-1 overflow-hidden">
                                        <div class="bg-secondary h-full w-[28%]"></div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- Registered Artifacts Preview -->
                        <div class="bg-surface-container-lowest rounded-xl p-space-sm shadow-sm flex flex-col gap-space-xs mb-space-md"><span class="font-label-sm text-label-sm uppercase font-bold text-on-surface flex items-center gap-1"><span class="material-symbols-outlined text-[14px] text-secondary">folder_zip</span> Model Artifacts</span>
                            <div class="flex flex-col gap-1 font-code-sm text-code-sm">
                                <div class="flex items-center justify-between p-1.5 bg-surface-container-low rounded"><span class="flex items-center gap-1 truncate"><span class="material-symbols-outlined text-[13px] text-primary">description</span> model.xgb</span><span class="text-[10px] text-outline">3.8 MB</span></div>
                                <div class="flex items-center justify-between p-1.5 bg-surface-container-low rounded"><span class="flex items-center gap-1 truncate"><span class="material-symbols-outlined text-[13px] text-primary">settings</span> MLmodel</span><span class="text-[10px] text-outline">1.2 KB</span></div>
                                <div class="flex items-center justify-between p-1.5 bg-surface-container-low rounded"><span class="flex items-center gap-1 truncate"><span class="material-symbols-outlined text-[13px] text-outline">image</span> confusion_matrix.png</span><span class="text-[10px] text-outline">142 KB</span></div>
                            </div>
                        </div><!-- Promotion CTA & Validation Gate -->
                        <div class="mt-auto pt-space-xs"><button class="w-full py-2.5 px-space-sm rounded bg-primary-container text-on-primary font-label-md text-label-md font-bold flex items-center justify-center gap-1.5 shadow-md hover:bg-primary transition-colors ring-1 ring-tertiary-fixed" type="button"><span class="material-symbols-outlined text-[16px] text-tertiary-fixed">rocket_launch</span><span>Promote Run #04 to Registry</span></button>
                            <p class="text-center text-[10px] text-outline mt-1 font-label-sm text-label-sm">Routes benchmark model candidate to SYS-AI-04 Range Validation Gate</p>
                        </div>
                    </aside>
                </div>
            </div>
        </main>
    </div>
    <script src="js/main.js"></script>
</body>

</html>