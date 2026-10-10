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
                <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center shrink-0"><span class="material-symbols-outlined text-on-primary text-[18px]">person</span></div>
            </div>
        </div>
    </header>
    <aside class="fixed left-0 top-16 bottom-0 w-64 bg-surface-container-low z-40 flex flex-col p-space-sm">
        <div class="flex items-center justify-between px-space-xs py-space-xs mb-space-sm"><span class="font-label-sm text-label-sm uppercase text-on-surface-variant font-semibold tracking-wider">Telemetry Workbench</span><span class="material-symbols-outlined text-on-surface-variant text-[16px]">tune</span></div>
        <nav class="flex-1 flex flex-col gap-1 overflow-y-auto" data-active-classes="bg-primary-container text-on-primary font-bold rounded-lg shadow-sm"><a aria-current="page" class="flex items-center gap-space-sm px-space-sm py-2 transition-all bg-primary-container text-on-primary font-bold rounded-lg shadow-sm" data-path="notebook-workbench" href="NotebookWorkbench.php"><span class="material-symbols-outlined text-[18px]">code</span><span class="font-body-md text-body-md">Notebook Workbench</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="experiment-runs" href="ExperimentRuns.php"><span class="material-symbols-outlined text-[18px]">query_stats</span><span class="font-body-md text-body-md">Experiment Runs</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="metric-telemetry" href="MetricTelemetry.php"><span class="material-symbols-outlined text-[18px]">insights</span><span class="font-body-md text-body-md">Metric Telemetry</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="tensor-inspector" href="TensorInspector.php"><span class="material-symbols-outlined text-[18px]">grid_view</span><span class="font-body-md text-body-md">Tensor Inspector</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="hyperparameter-matrix" href="HyperparameterMatrix.php"><span class="material-symbols-outlined text-[18px]">tune</span><span class="font-body-md text-body-md">Hyperparameter Matrix</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="model-artifacts" href="ModelArtifacts.php"><span class="material-symbols-outlined text-[18px]">inventory_2</span><span class="font-body-md text-body-md">Model Artifacts</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="range-evaluation" href="RangeEvaluation.php"><span class="material-symbols-outlined text-[18px]">verified</span><span class="font-body-md text-body-md">Range Evaluation</span></a></nav>
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
                        <div class="flex items-center gap-1.5 px-space-xs py-0.5 rounded bg-surface-container text-on-surface-variant font-code-sm text-code-sm">
                            <span class="material-symbols-outlined text-secondary text-[14px]">terminal</span>
                            <span>ENV: py310-cuda12.1-mlflow</span>
                        </div>
                        <span class="text-outline-variant font-code-sm text-code-sm">/</span>
                        <div class="flex items-center gap-1 font-label-md text-label-md text-primary font-bold truncate">
                            <span class="material-symbols-outlined text-primary text-[15px]">description</span>
                            <span>churn_eda.ipynb</span>
                        </div>
                        <span class="inline-flex items-center px-1.5 py-0.2 rounded bg-secondary-fixed text-on-secondary-fixed font-label-sm text-label-sm">
                            DIRTY • AUTO-SAVED 2m ago
                        </span>
                    </div>
                    <div class="flex items-center gap-space-md">
                        <div class="flex items-center gap-space-xs font-code-sm text-code-sm text-on-surface-variant">
                            <span class="material-symbols-outlined text-primary text-[14px]">timer</span>
                            <span>Session: <strong class="text-on-surface">03m 42s</strong></span>
                        </div>
                        <div class="flex items-center gap-space-xs font-code-sm text-code-sm text-on-surface-variant">
                            <span class="w-2 h-2 rounded-full bg-secondary-container"></span>
                            <span>Kernel: <strong class="text-on-surface">Idle (PID 4092)</strong></span>
                        </div>
                        <button class="px-space-sm py-1 rounded bg-surface-container-high hover:bg-surface-container-highest text-on-surface font-label-sm text-label-sm flex items-center gap-1" type="button">
                            <span class="material-symbols-outlined text-[13px]">tune</span>
                            <span>Session Config</span>
                        </button>
                    </div>
                </div>
                <!-- Tri-Panel Workbench Layout -->
                <div class="w-full flex items-stretch min-h-[calc(100vh-6.5rem)]">
                    <!-- LEFT PANEL: Collapsible Tool Dock (260px) -->
                    <aside class="w-64 bg-surface-container-low shrink-0 flex flex-col p-space-xs transition-all duration-200" id="left-dock">
                        <!-- Dock Tab Bar -->
                        <div class="flex items-center justify-between px-space-xs py-1 mb-space-xs bg-surface-container rounded">
                            <span class="font-label-sm text-label-sm uppercase tracking-wider text-primary font-bold flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">account_tree</span> Workspace Tree
                            </span>
                            <div class="flex items-center gap-0.5">
                                <button class="p-0.5 rounded text-on-surface-variant hover:text-on-surface hover:bg-surface-container-high" title="Collapse Explorer" type="button">
                                    <span class="material-symbols-outlined text-[14px]">first_page</span>
                                </button>
                            </div>
                        </div>
                        <!-- Scrollable Explorer Modules -->
                        <div class="flex-1 flex flex-col gap-space-xs overflow-y-auto pr-0.5">
                            <!-- Section 1: Project Files -->
                            <div class="bg-surface-container-lowest rounded-lg p-space-xs shadow-sm">
                                <div class="flex items-center justify-between px-1 py-0.5 text-on-surface font-label-sm text-label-sm uppercase font-semibold">
                                    <span class="flex items-center gap-1"><span class="material-symbols-outlined text-[14px] text-secondary">folder_open</span> Project Files</span>
                                    <span class="text-outline-variant font-code-sm text-code-sm">5</span>
                                </div>
                                <div class="mt-1 flex flex-col gap-0.5 font-code-sm text-code-sm">
                                    <a class="flex items-center justify-between px-2 py-1 rounded bg-secondary-fixed text-on-secondary-fixed font-semibold" href="#">
                                        <span class="flex items-center gap-1.5 truncate">
                                            <span class="material-symbols-outlined text-[15px] text-primary">code</span> churn_eda.ipynb
                                        </span>
                                        <span class="w-1.5 h-1.5 rounded-full bg-primary"></span>
                                    </a>
                                    <a class="flex items-center px-2 py-1 rounded hover:bg-surface-container text-on-surface-variant hover:text-on-surface transition-colors" href="#">
                                        <span class="flex items-center gap-1.5 truncate">
                                            <span class="material-symbols-outlined text-[15px] text-outline">description</span> feature_engineering.py
                                        </span>
                                    </a>
                                    <a class="flex items-center px-2 py-1 rounded hover:bg-surface-container text-on-surface-variant hover:text-on-surface transition-colors" href="#">
                                        <span class="flex items-center gap-1.5 truncate">
                                            <span class="material-symbols-outlined text-[15px] text-outline">tune</span> train_pipeline.py
                                        </span>
                                    </a>
                                    <a class="flex items-center px-2 py-1 rounded hover:bg-surface-container text-on-surface-variant hover:text-on-surface transition-colors" href="#">
                                        <span class="flex items-center gap-1.5 truncate">
                                            <span class="material-symbols-outlined text-[15px] text-outline">assignment</span> requirements.txt
                                        </span>
                                    </a>
                                    <div class="flex items-center justify-between px-2 py-1 text-on-surface-variant font-code-sm text-code-sm">
                                        <span class="flex items-center gap-1.5">
                                            <span class="material-symbols-outlined text-[15px] text-outline">folder</span> models/
                                        </span>
                                        <span class="text-[10px] text-outline-variant">3 artifacts</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Section 2: Permitted Datasets (Data Lake SYS-AI-02) -->
                            <div class="bg-surface-container-lowest rounded-lg p-space-xs shadow-sm">
                                <div class="flex items-center justify-between px-1 py-0.5 text-on-surface font-label-sm text-label-sm uppercase font-semibold">
                                    <span class="flex items-center gap-1"><span class="material-symbols-outlined text-[14px] text-tertiary">database</span> Data Lake Lakehouse</span>
                                    <span class="px-1 rounded bg-tertiary-fixed text-on-tertiary-fixed font-label-sm text-label-sm">RO</span>
                                </div>
                                <div class="mt-1 flex flex-col gap-1.5 font-code-sm text-code-sm">
                                    <div class="p-1.5 rounded bg-surface-container-low">
                                        <div class="flex items-center justify-between font-semibold text-primary truncate">
                                            <span class="truncate">telco_churn_v2_clean.parquet</span>
                                        </div>
                                        <div class="flex items-center justify-between text-outline text-[10px] mt-0.5">
                                            <span>7,043 rows × 21 cols</span>
                                            <span>SHA256: 4b9f..</span>
                                        </div>
                                        <div class="mt-1 flex items-center justify-between">
                                            <span class="inline-flex items-center px-1 py-0.2 rounded bg-tertiary-fixed-dim text-on-tertiary-fixed font-label-sm text-label-sm">Golden Set</span>
                                            <span class="text-on-surface-variant text-[10px]">1.42 MB</span>
                                        </div>
                                    </div>
                                    <div class="p-1.5 rounded bg-surface-container-low opacity-80">
                                        <div class="flex items-center justify-between font-medium text-on-surface truncate">
                                            <span class="truncate">customer_telemetry_stream.csv</span>
                                        </div>
                                        <div class="text-[10px] text-outline mt-0.5">50,000 events • Realtime sink</div>
                                    </div>
                                </div>
                            </div>
                            <!-- Section 3: AST Notebook Outline (TOC) -->
                            <div class="bg-surface-container-lowest rounded-lg p-space-xs shadow-sm">
                                <div class="flex items-center justify-between px-1 py-0.5 text-on-surface font-label-sm text-label-sm uppercase font-semibold">
                                    <span class="flex items-center gap-1"><span class="material-symbols-outlined text-[14px] text-secondary">list_alt</span> AST Outline</span>
                                </div>
                                <nav class="mt-1 flex flex-col gap-0.5 font-code-sm text-code-sm text-on-surface-variant">
                                    <a class="px-1.5 py-0.5 rounded hover:bg-surface-container hover:text-on-surface truncate flex items-center gap-1" href="#cell-1">
                                        <span class="text-primary font-bold">#1</span> 1. Imports &amp; Config
                                    </a>
                                    <a class="px-1.5 py-0.5 rounded hover:bg-surface-container hover:text-on-surface truncate flex items-center gap-1" href="#cell-2">
                                        <span class="text-primary font-bold">#2</span> 2. Dataset Ingestion
                                    </a>
                                    <a class="px-1.5 py-0.5 rounded hover:bg-surface-container hover:text-on-surface truncate flex items-center gap-1" href="#cell-3">
                                        <span class="text-primary font-bold">#3</span> 3. Feature Pipeline
                                    </a>
                                    <a class="px-1.5 py-0.5 rounded hover:bg-surface-container hover:text-on-surface truncate flex items-center gap-1" href="#cell-4">
                                        <span class="text-primary font-bold">#4</span> 4. Baseline XGBoost &amp; Loss
                                    </a>
                                    <a class="px-1.5 py-0.5 rounded hover:bg-surface-container hover:text-on-surface truncate flex items-center gap-1 bg-surface-container text-on-surface" href="#cell-5">
                                        <span class="text-primary font-bold">#5</span> 5. Metric Evaluation
                                    </a>
                                    <a class="px-1.5 py-0.5 rounded hover:bg-surface-container hover:text-on-surface truncate flex items-center gap-1" href="#cell-6">
                                        <span class="text-primary font-bold">#6</span> 6. MLflow Log &amp; Artifact
                                    </a>
                                </nav>
                            </div>
                            <!-- Section 4: Variables & Memory Inspector -->
                            <div class="bg-surface-container-lowest rounded-lg p-space-xs shadow-sm">
                                <div class="flex items-center justify-between px-1 py-0.5 text-on-surface font-label-sm text-label-sm uppercase font-semibold">
                                    <span class="flex items-center gap-1"><span class="material-symbols-outlined text-[14px] text-primary">data_object</span> Memory Tensors</span>
                                    <span class="font-code-sm text-code-sm text-secondary font-semibold">4.8 GB</span>
                                </div>
                                <div class="mt-1 flex flex-col gap-1 font-code-sm text-code-sm">
                                    <div class="flex items-center justify-between px-1 py-0.5 bg-surface-container-low rounded">
                                        <span class="text-primary font-semibold">df_train</span>
                                        <span class="text-outline-variant font-code-sm text-code-sm">(5634, 20)</span>
                                    </div>
                                    <div class="flex items-center justify-between px-1 py-0.5 bg-surface-container-low rounded">
                                        <span class="text-primary font-semibold">X_test</span>
                                        <span class="text-outline-variant font-code-sm text-code-sm">(1409, 20)</span>
                                    </div>
                                    <div class="flex items-center justify-between px-1 py-0.5 bg-surface-container-low rounded">
                                        <span class="text-primary font-semibold">y_pred</span>
                                        <span class="text-outline-variant font-code-sm text-code-sm">int64 [1409]</span>
                                    </div>
                                    <div class="flex items-center justify-between px-1 py-0.5 bg-surface-container-low rounded">
                                        <span class="text-primary font-semibold">xgb_best_model</span>
                                        <span class="text-outline-variant font-code-sm text-code-sm">&lt;XGBClf&gt;</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Section 5: Target Registry Pointer -->
                            <div class="mt-auto p-space-xs bg-surface-container rounded-lg">
                                <div class="flex items-center gap-1 font-label-sm text-label-sm text-primary uppercase font-bold">
                                    <span class="material-symbols-outlined text-[14px]">outbox</span> Registry Target
                                </div>
                                <p class="font-code-sm text-code-sm text-on-surface font-semibold mt-1">churn-classifier:v1.4</p>
                                <div class="flex items-center justify-between mt-1 text-[10px] text-on-surface-variant">
                                    <span>Staging Candidate</span>
                                    <span class="text-primary font-bold">SYS-AI-04 →</span>
                                </div>
                            </div>
                        </div>
                    </aside>
                    <!-- Splitter Separator -->
                    <div class="w-1 bg-surface-container-high hover:bg-primary-container cursor-col-resize shrink-0 transition-colors"></div>
                    <!-- CENTER PANEL: Primary Notebook Editor (~65%) -->
                    <section class="flex-1 min-w-0 bg-surface flex flex-col p-space-md overflow-y-auto">
                        <!-- Interactive Notebook Toolbar -->
                        <div class="sticky top-0 z-30 bg-surface-container-lowest/95 backdrop-blur-md rounded-xl p-space-xs shadow-md mb-space-md flex flex-wrap items-center justify-between gap-gutter">
                            <div class="flex items-center flex-wrap gap-1">
                                <!-- Add Code/Markdown -->
                                <button class="h-7 px-space-xs rounded bg-surface-container hover:bg-surface-container-high text-primary font-label-sm text-label-sm flex items-center gap-1" type="button">
                                    <span class="material-symbols-outlined text-[14px]">add</span><span>Code</span>
                                </button>
                                <button class="h-7 px-space-xs rounded bg-surface-container hover:bg-surface-container-high text-on-surface font-label-sm text-label-sm flex items-center gap-1" type="button">
                                    <span class="material-symbols-outlined text-[14px]">add</span><span>Markdown</span>
                                </button>
                                <div class="h-4 w-px bg-surface-container-high mx-1"></div>
                                <!-- Execution Controls -->
                                <button class="h-7 px-space-xs rounded bg-primary-container text-on-primary font-label-sm text-label-sm flex items-center gap-1 shadow-sm hover:bg-primary transition-all" title="Run Selected Cell (Ctrl+Enter)" type="button">
                                    <span class="material-symbols-outlined text-[15px]">play_arrow</span><span>Run</span>
                                </button>
                                <button class="h-7 px-space-xs rounded bg-surface-container hover:bg-surface-container-high text-error font-label-sm text-label-sm flex items-center gap-1" title="Interrupt Kernel" type="button">
                                    <span class="material-symbols-outlined text-[15px]">stop</span><span>Interrupt</span>
                                </button>
                                <button class="h-7 px-space-xs rounded bg-surface-container hover:bg-surface-container-high text-on-surface font-label-sm text-label-sm flex items-center gap-1" title="Restart &amp; Run All" type="button">
                                    <span class="material-symbols-outlined text-[15px]">restart_alt</span><span>Restart &amp; Clear</span>
                                </button>
                                <div class="h-4 w-px bg-surface-container-high mx-1"></div>
                                <!-- Cell Type Selector Dropdown -->
                                <div class="relative inline-flex items-center bg-surface-container rounded px-2 py-1">
                                    <span class="font-code-sm text-code-sm text-on-surface font-semibold mr-1">Code</span>
                                    <span class="material-symbols-outlined text-[14px] text-outline">expand_more</span>
                                </div>
                                <!-- Move Cells -->
                                <button class="p-1 rounded hover:bg-surface-container text-on-surface-variant" title="Move Up" type="button">
                                    <span class="material-symbols-outlined text-[16px]">arrow_upward</span>
                                </button>
                                <button class="p-1 rounded hover:bg-surface-container text-on-surface-variant" title="Move Down" type="button">
                                    <span class="material-symbols-outlined text-[16px]">arrow_downward</span>
                                </button>
                            </div>
                            <div class="flex items-center gap-space-sm font-code-sm text-code-sm text-on-surface-variant">
                                <span class="flex items-center gap-1"><span class="material-symbols-outlined text-secondary text-[14px]">save</span> Auto-checkpoint: 14:22:08</span>
                                <span class="inline-flex items-center px-1.5 py-0.5 rounded bg-tertiary-fixed text-on-tertiary-fixed font-label-sm text-label-sm font-bold">
                                    RANGE TARGET: F1 ≥ 0.80
                                </span>
                            </div>
                        </div>
                        <!-- Cell Stack -->
                        <div class="flex flex-col gap-space-md">
                            <!-- CELL [1]: Markdown Technical Spec -->
                            <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm" id="cell-1">
                                <div class="flex items-center justify-between mb-space-xs">
                                    <div class="flex items-center gap-space-xs">
                                        <span class="font-code-sm text-code-sm text-outline-variant font-bold">[md]</span>
                                        <span class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant">Notebook Header • Ticket Spec</span>
                                    </div>
                                    <div class="flex items-center gap-1 text-on-surface-variant">
                                        <button class="p-1 hover:text-primary" type="button"><span class="material-symbols-outlined text-[15px]">edit</span></button>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-space-xs">
                                    <div class="flex items-center justify-between flex-wrap gap-2">
                                        <h1 class="font-headline-lg text-headline-lg text-on-surface font-bold">Customer Churn Prediction — XGBoost + LightGBM Benchmark</h1>
                                        <div class="flex items-center gap-space-xs">
                                            <span class="inline-flex items-center px-space-xs py-1 rounded bg-secondary-fixed text-on-secondary-fixed font-label-sm text-label-sm font-bold">
                                                TICKET: TKT-AI-01-CHURN-409
                                            </span>
                                            <span class="inline-flex items-center px-space-xs py-1 rounded bg-tertiary-fixed text-on-tertiary-fixed font-label-sm text-label-sm font-bold">
                                                <span class="material-symbols-outlined text-[13px] mr-1">military_tech</span>TARGET: F1 ≥ 0.80 • ROC-AUC ≥ 0.85
                                            </span>
                                        </div>
                                    </div>
                                    <p class="font-body-md text-body-md text-on-surface-variant">
                                        Production retention engine pipeline. Ingests cleaned subscriber features, encodes multi-categorical telemetry columns, balances target class via SMOTE (Synthetic Minority Over-sampling Technique), executes cross-validated XGBoost grid search, and outputs formal verification metrics for promotion to <strong class="text-primary">SYS-AI-04 Validation Registry</strong>.
                                    </p>
                                </div>
                            </div>
                            <!-- CELL [2]: Dataset Ingestion (Executed [1]) -->
                            <div class="bg-surface-container-lowest rounded-xl overflow-hidden shadow-sm" id="cell-2">
                                <!-- Code Cell Header -->
                                <div class="flex items-center justify-between px-space-md py-1 bg-surface-container-low text-on-surface-variant">
                                    <div class="flex items-center gap-space-xs">
                                        <span class="font-code-sm text-code-sm text-primary font-bold">In [1]:</span>
                                        <span class="font-label-sm text-label-sm text-on-surface-variant">Data Ingestion &amp; Dependencies</span>
                                    </div>
                                    <div class="flex items-center gap-space-sm font-code-sm text-code-sm">
                                        <span class="text-on-surface-variant flex items-center gap-0.5"><span class="material-symbols-outlined text-[13px]">check_circle</span> 1.2s</span>
                                        <button class="p-1 hover:text-primary" type="button"><span class="material-symbols-outlined text-[14px]">play_arrow</span></button>
                                    </div>
                                </div>
                                <!-- Code Body with Syntax Coloring -->
                                <div class="p-space-md font-code-md text-code-md bg-surface-container-lowest text-on-surface overflow-x-auto">
                                    <div class="grid grid-cols-[30px_1fr] gap-space-sm">
                                        <div class="text-right text-outline-variant select-none font-code-sm text-code-sm leading-[18px]">
                                            1<br />2<br />3<br />4<br />5<br />6<br />7<br />8
                                        </div>
                                        <div class="leading-[18px]">
                                            <span class="text-primary font-bold">import</span> pandas <span class="text-primary font-bold">as</span> pd<br />
                                            <span class="text-primary font-bold">import</span> numpy <span class="text-primary font-bold">as</span> np<br />
                                            <span class="text-primary font-bold">from</span> sklearn.model_selection <span class="text-primary font-bold">import</span> StratifiedKFold<br />
                                            <span class="text-primary font-bold">from</span> sklearn.metrics <span class="text-primary font-bold">import</span> classification_report, roc_auc_score, f1_score<br />
                                            <span class="text-primary font-bold">import</span> xgboost <span class="text-primary font-bold">as</span> xgb<br />
                                            <span class="text-primary font-bold">import</span> mlflow<br /><br />
                                            df = pd.read_parquet(<span class="text-secondary font-medium">'/datasets/telco_churn_v2_clean.parquet'</span>)<br />
                                            <span class="text-primary font-bold">print</span>(f<span class="text-secondary">"Loaded {df.shape[0]} records across {df.shape[1]} features. Memory: {df.memory_usage().sum() / 1e6:.2f} MB"</span>)
                                        </div>
                                    </div>
                                </div>
                                <!-- Execution Output Terminal Container -->
                                <div class="bg-inverse-surface text-inverse-on-surface p-space-sm font-code-sm text-code-sm">
                                    <div class="flex items-center gap-1 text-outline-variant font-label-sm text-label-sm uppercase mb-1">
                                        <span class="material-symbols-outlined text-[13px] text-secondary">terminal</span> Out [1]: stdout
                                    </div>
                                    <p class="font-code-sm text-code-sm text-surface-container-low">Loaded 7043 records across 21 features. Memory: 1.42 MB</p>
                                </div>
                            </div>
                            <!-- CELL [3]: Interactive Pandas DataFrame Preview (Executed [2]) -->
                            <div class="bg-surface-container-lowest rounded-xl overflow-hidden shadow-sm" id="cell-3">
                                <div class="flex items-center justify-between px-space-md py-1 bg-surface-container-low text-on-surface-variant">
                                    <div class="flex items-center gap-space-xs">
                                        <span class="font-code-sm text-code-sm text-primary font-bold">In [2]:</span>
                                        <span class="font-label-sm text-label-sm">df.head(5) &amp; Feature Schema Inspector</span>
                                    </div>
                                    <div class="flex items-center gap-space-sm font-code-sm text-code-sm">
                                        <span class="text-on-surface-variant flex items-center gap-0.5"><span class="material-symbols-outlined text-[13px]">check_circle</span> 3.8s</span>
                                        <button class="p-1 hover:text-primary" type="button"><span class="material-symbols-outlined text-[14px]">play_arrow</span></button>
                                    </div>
                                </div>
                                <div class="p-space-md font-code-md text-code-md bg-surface-container-lowest text-on-surface overflow-x-auto">
                                    <div class="grid grid-cols-[30px_1fr] gap-space-sm">
                                        <div class="text-right text-outline-variant select-none font-code-sm text-code-sm leading-[18px]">1</div>
                                        <div class="leading-[18px]">
                                            df[[<span class="text-secondary">'customer_id'</span>, <span class="text-secondary">'tenure_months'</span>, <span class="text-secondary">'monthly_charges'</span>, <span class="text-secondary">'contract_type'</span>, <span class="text-secondary">'churn_label'</span>]].head(<span class="text-primary font-semibold">5</span>)
                                        </div>
                                    </div>
                                </div>
                                <!-- Out [2]: Rendered High-Density Tabular Frame -->
                                <div class="p-space-sm bg-surface-container-lowest overflow-x-auto">
                                    <div class="flex items-center justify-between mb-space-xs px-1">
                                        <span class="font-label-sm text-label-sm text-primary uppercase font-bold">Out [2]: Pandas Rendered (5 of 7,043 rows • 0 missing values)</span>
                                        <div class="flex items-center gap-1 font-label-sm text-label-sm">
                                            <span class="px-1.5 py-0.5 rounded bg-surface-container text-on-surface">Page 1 / 1409</span>
                                        </div>
                                    </div>
                                    <div class="w-full overflow-hidden rounded-lg bg-surface-container-lowest shadow-sm">
                                        <table class="w-full text-left font-code-sm text-code-sm">
                                            <thead class="bg-surface-container text-primary font-label-sm text-label-sm">
                                                <tr>
                                                    <th class="py-2 px-3 font-bold"># Index</th>
                                                    <th class="py-2 px-3">
                                                        <div>customer_id</div>
                                                        <div class="font-code-sm text-code-sm text-outline font-normal">object</div>
                                                    </th>
                                                    <th class="py-2 px-3">
                                                        <div>tenure_months</div>
                                                        <div class="font-code-sm text-code-sm text-outline font-normal">int64</div>
                                                    </th>
                                                    <th class="py-2 px-3">
                                                        <div>monthly_charges</div>
                                                        <div class="font-code-sm text-code-sm text-outline font-normal">float64</div>
                                                    </th>
                                                    <th class="py-2 px-3">
                                                        <div>contract_type</div>
                                                        <div class="font-code-sm text-code-sm text-outline font-normal">category</div>
                                                    </th>
                                                    <th class="py-2 px-3">
                                                        <div>churn_label</div>
                                                        <div class="font-code-sm text-code-sm text-primary font-normal">int64 [target]</div>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y-0 text-on-surface">
                                                <tr class="bg-surface-container-lowest hover:bg-surface-container-low transition-colors">
                                                    <td class="py-1.5 px-3 font-semibold text-outline">0</td>
                                                    <td class="py-1.5 px-3">7590-VHVEG</td>
                                                    <td class="py-1.5 px-3">1</td>
                                                    <td class="py-1.5 px-3 font-semibold">$29.85</td>
                                                    <td class="py-1.5 px-3"><span class="px-1.5 py-0.2 rounded bg-surface-container-high text-on-surface">Month-to-month</span></td>
                                                    <td class="py-1.5 px-3"><span class="px-1.5 py-0.2 rounded bg-surface-container text-on-surface-variant font-bold">0</span></td>
                                                </tr>
                                                <tr class="bg-surface-container-low hover:bg-surface-container transition-colors">
                                                    <td class="py-1.5 px-3 font-semibold text-outline">1</td>
                                                    <td class="py-1.5 px-3">5575-GNVDE</td>
                                                    <td class="py-1.5 px-3">34</td>
                                                    <td class="py-1.5 px-3 font-semibold">$56.95</td>
                                                    <td class="py-1.5 px-3"><span class="px-1.5 py-0.2 rounded bg-surface-container-high text-on-surface">One year</span></td>
                                                    <td class="py-1.5 px-3"><span class="px-1.5 py-0.2 rounded bg-surface-container text-on-surface-variant font-bold">0</span></td>
                                                </tr>
                                                <tr class="bg-surface-container-lowest hover:bg-surface-container-low transition-colors">
                                                    <td class="py-1.5 px-3 font-semibold text-outline">2</td>
                                                    <td class="py-1.5 px-3">3668-QPYBK</td>
                                                    <td class="py-1.5 px-3">2</td>
                                                    <td class="py-1.5 px-3 font-semibold">$53.85</td>
                                                    <td class="py-1.5 px-3"><span class="px-1.5 py-0.2 rounded bg-surface-container-high text-on-surface">Month-to-month</span></td>
                                                    <td class="py-1.5 px-3"><span class="px-1.5 py-0.2 rounded bg-error-container text-on-error-container font-bold">1</span></td>
                                                </tr>
                                                <tr class="bg-surface-container-low hover:bg-surface-container transition-colors">
                                                    <td class="py-1.5 px-3 font-semibold text-outline">3</td>
                                                    <td class="py-1.5 px-3">7795-CFOCW</td>
                                                    <td class="py-1.5 px-3">45</td>
                                                    <td class="py-1.5 px-3 font-semibold">$42.30</td>
                                                    <td class="py-1.5 px-3"><span class="px-1.5 py-0.2 rounded bg-surface-container-high text-on-surface">One year</span></td>
                                                    <td class="py-1.5 px-3"><span class="px-1.5 py-0.2 rounded bg-surface-container text-on-surface-variant font-bold">0</span></td>
                                                </tr>
                                                <tr class="bg-surface-container-lowest hover:bg-surface-container-low transition-colors">
                                                    <td class="py-1.5 px-3 font-semibold text-outline">4</td>
                                                    <td class="py-1.5 px-3">9237-HQITU</td>
                                                    <td class="py-1.5 px-3">2</td>
                                                    <td class="py-1.5 px-3 font-semibold">$70.70</td>
                                                    <td class="py-1.5 px-3"><span class="px-1.5 py-0.2 rounded bg-surface-container-high text-on-surface">Month-to-month</span></td>
                                                    <td class="py-1.5 px-3"><span class="px-1.5 py-0.2 rounded bg-error-container text-on-error-container font-bold">1</span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- CELL [4]: Model Training & Interactive SVG Curves (Executed [3]) -->
                            <div class="bg-surface-container-lowest rounded-xl overflow-hidden shadow-sm" id="cell-4">
                                <div class="flex items-center justify-between px-space-md py-1 bg-surface-container-low text-on-surface-variant">
                                    <div class="flex items-center gap-space-xs">
                                        <span class="font-code-sm text-code-sm text-primary font-bold">In [3]:</span>
                                        <span class="font-label-sm text-label-sm">XGBoost Optimization &amp; Loss Telemetry</span>
                                    </div>
                                    <div class="flex items-center gap-space-sm font-code-sm text-code-sm">
                                        <span class="text-on-surface-variant flex items-center gap-0.5"><span class="material-symbols-outlined text-[13px]">check_circle</span> 14.5s</span>
                                        <button class="p-1 hover:text-primary" type="button"><span class="material-symbols-outlined text-[14px]">play_arrow</span></button>
                                    </div>
                                </div>
                                <div class="p-space-md font-code-md text-code-md bg-surface-container-lowest text-on-surface overflow-x-auto">
                                    <div class="grid grid-cols-[30px_1fr] gap-space-sm">
                                        <div class="text-right text-outline-variant select-none font-code-sm text-code-sm leading-[18px]">
                                            1<br />2<br />3<br />4<br />5
                                        </div>
                                        <div class="leading-[18px]">
                                            <span class="text-primary font-bold">with</span> mlflow.start_run(run_name=<span class="text-secondary font-medium">"xgboost_tuned_trial_04"</span>):<br />
                                                params = {<span class="text-secondary">'max_depth'</span>: 6, <span class="text-secondary">'learning_rate'</span>: 0.03, <span class="text-secondary">'n_estimators'</span>: 350, <span class="text-secondary">'subsample'</span>: 0.85}<br />
                                                xgb_best = xgb.XGBClassifier(**params, eval_metric=<span class="text-secondary">'logloss'</span>)<br />
                                                xgb_best.fit(X_train_res, y_train_res, eval_set=[(X_val, y_val)], verbose=<span class="text-primary font-bold">False</span>)<br />
                                                y_pred = xgb_best.predict(X_val)
                                        </div>
                                    </div>
                                </div>
                                <!-- Out [3]: Visual Interactive Training Metrics -->
                                <div class="p-space-md bg-surface-container-low">
                                    <div class="flex items-center justify-between mb-space-sm">
                                        <span class="font-label-sm text-label-sm text-primary uppercase font-bold flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[15px]">insights</span>
                                            Out [3]: Interactive Epoch Loss &amp; ROC Curve (Validation Split)
                                        </span>
                                        <span class="font-code-sm text-code-sm text-on-surface-variant">Early stopping at epoch 318 • Best LogLoss: 0.384</span>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-space-md">
                                        <!-- Plot 1: Train vs Validation Loss Curve -->
                                        <div class="bg-surface-container-lowest rounded-lg p-space-sm shadow-sm flex flex-col">
                                            <div class="flex items-center justify-between mb-1">
                                                <span class="font-label-sm text-label-sm font-semibold text-on-surface">Epoch LogLoss Convergence</span>
                                                <div class="flex items-center gap-2 font-code-sm text-code-sm">
                                                    <span class="flex items-center gap-1 text-primary"><span class="w-2.5 h-0.5 bg-primary"></span> Train</span>
                                                    <span class="flex items-center gap-1 text-secondary"><span class="w-2.5 h-0.5 bg-secondary"></span> Val</span>
                                                </div>
                                            </div>
                                            <div class="h-36 w-full flex items-center justify-center">
                                                <svg class="w-full h-full text-primary" fill="none" viewbox="0 0 320 120">
                                                    <!-- Gridlines -->
                                                    <line stroke="currentColor" stroke-dasharray="2 2" stroke-opacity="0.08" x1="20" x2="310" y1="20" y2="20"></line>
                                                    <line stroke="currentColor" stroke-dasharray="2 2" stroke-opacity="0.08" x1="20" x2="310" y1="60" y2="60"></line>
                                                    <line stroke="currentColor" stroke-dasharray="2 2" stroke-opacity="0.08" x1="20" x2="310" y1="100" y2="100"></line>
                                                    <!-- Train Loss Curve -->
                                                    <path d="M 25 105 Q 80 45, 160 30 T 305 22" stroke="currentColor" stroke-linecap="round" stroke-width="2"></path>
                                                    <!-- Val Loss Curve -->
                                                    <path d="M 25 108 Q 80 58, 160 46 T 305 40" stroke="#6F5092" stroke-dasharray="4 2" stroke-linecap="round" stroke-width="2"></path>
                                                    <!-- Target line -->
                                                    <circle cx="305" cy="40" fill="#6F5092" r="3"></circle>
                                                    <!-- Annotations -->
                                                    <text fill="#7B7483" font-family="JetBrains Mono" font-size="9" x="25" y="116">Ep 0</text>
                                                    <text fill="#7B7483" font-family="JetBrains Mono" font-size="9" x="160" y="116">Ep 175</text>
                                                    <text fill="#7B7483" font-family="JetBrains Mono" font-size="9" x="280" y="116">Ep 350</text>
                                                </svg>
                                            </div>
                                        </div>
                                        <!-- Plot 2: ROC-AUC Interactive Visual Preview -->
                                        <div class="bg-surface-container-lowest rounded-lg p-space-sm shadow-sm flex flex-col">
                                            <div class="flex items-center justify-between mb-1">
                                                <span class="font-label-sm text-label-sm font-semibold text-on-surface">ROC Curve (AUC = 0.864)</span>
                                                <span class="inline-flex items-center px-1.5 py-0.2 rounded bg-tertiary-fixed text-on-tertiary-fixed font-label-sm text-label-sm font-bold">
                                                    ≥ 0.850 PASSED
                                                </span>
                                            </div>
                                            <div class="h-36 w-full flex items-center justify-center">
                                                <svg class="w-full h-full text-primary" fill="none" viewbox="0 0 320 120">
                                                    <!-- Diagonal Baseline -->
                                                    <line stroke="#CCC3D4" stroke-dasharray="3 3" stroke-width="1.5" x1="30" x2="290" y1="105" y2="15"></line>
                                                    <!-- ROC Curve -->
                                                    <path d="M 30 105 C 45 40, 95 18, 290 15" stroke="currentColor" stroke-linecap="round" stroke-width="2.5"></path>
                                                    <!-- Area under curve fill -->
                                                    <path d="M 30 105 C 45 40, 95 18, 290 15 L 290 105 Z" fill="currentColor" fill-opacity="0.08"></path>
                                                    <circle cx="110" cy="27" fill="#340075" r="3.5"></circle>
                                                    <text fill="#340075" font-family="JetBrains Mono" font-size="9" font-weight="600" x="120" y="30">Optimal Operating Threshold (0.42)</text>
                                                    <text fill="#7B7483" font-family="JetBrains Mono" font-size="9" x="30" y="116">FPR 0.0</text>
                                                    <text fill="#7B7483" font-family="JetBrains Mono" font-size="9" x="260" y="116">FPR 1.0</text>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- CELL [5]: Classification Report & Confusion Matrix (Executed [4]) -->
                            <div class="bg-surface-container-lowest rounded-xl overflow-hidden shadow-sm" id="cell-5">
                                <div class="flex items-center justify-between px-space-md py-1 bg-surface-container-low text-on-surface-variant">
                                    <div class="flex items-center gap-space-xs">
                                        <span class="font-code-sm text-code-sm text-primary font-bold">In [4]:</span>
                                        <span class="font-label-sm text-label-sm">Evaluation: Classification Report &amp; Confusion Heatmap</span>
                                    </div>
                                    <div class="flex items-center gap-space-sm font-code-sm text-code-sm">
                                        <span class="text-on-surface-variant flex items-center gap-0.5"><span class="material-symbols-outlined text-[13px]">check_circle</span> 2.1s</span>
                                        <button class="p-1 hover:text-primary" type="button"><span class="material-symbols-outlined text-[14px]">play_arrow</span></button>
                                    </div>
                                </div>
                                <div class="p-space-md font-code-md text-code-md bg-surface-container-lowest text-on-surface overflow-x-auto">
                                    <div class="grid grid-cols-[30px_1fr] gap-space-sm">
                                        <div class="text-right text-outline-variant select-none font-code-sm text-code-sm leading-[18px]">1<br />2</div>
                                        <div class="leading-[18px]">
                                            print(classification_report(y_val, y_pred, digits=3))<br />
                                            plot_confusion_matrix(y_val, y_pred)
                                        </div>
                                    </div>
                                </div>
                                <!-- Out [4]: Detailed Evaluation View -->
                                <div class="p-space-md bg-surface-container-lowest">
                                    <div class="flex items-center justify-between mb-space-sm">
                                        <span class="font-label-sm text-label-sm text-primary uppercase font-bold">
                                            Out [4]: Scikit-Learn Metric Artifact • Validation Cohort
                                        </span>
                                        <span class="inline-flex items-center px-space-xs py-0.5 rounded bg-tertiary-fixed text-on-tertiary-fixed font-label-sm text-label-sm font-bold">
                                            <span class="material-symbols-outlined text-[13px] mr-1">verified</span> F1-SCORE = 0.825 ≥ 0.800
                                        </span>
                                    </div>
                                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-md">
                                        <!-- Classification Report Table (7 Cols) -->
                                        <div class="lg:col-span-7 overflow-x-auto">
                                            <table class="w-full text-left font-code-sm text-code-sm">
                                                <thead class="bg-surface-container text-on-surface-variant font-label-sm text-label-sm">
                                                    <tr>
                                                        <th class="py-1.5 px-2.5">Class / Target</th>
                                                        <th class="py-1.5 px-2.5">Precision</th>
                                                        <th class="py-1.5 px-2.5">Recall</th>
                                                        <th class="py-1.5 px-2.5">F1-Score</th>
                                                        <th class="py-1.5 px-2.5">Support</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-on-surface">
                                                    <tr class="bg-surface-container-lowest">
                                                        <td class="py-1.5 px-2.5 font-semibold">0 (Retained)</td>
                                                        <td class="py-1.5 px-2.5">0.882</td>
                                                        <td class="py-1.5 px-2.5">0.902</td>
                                                        <td class="py-1.5 px-2.5">0.892</td>
                                                        <td class="py-1.5 px-2.5 text-outline">1430</td>
                                                    </tr>
                                                    <tr class="bg-secondary-fixed/30 font-semibold">
                                                        <td class="py-1.5 px-2.5 text-primary">1 (Churned) *</td>
                                                        <td class="py-1.5 px-2.5">0.840</td>
                                                        <td class="py-1.5 px-2.5">0.810</td>
                                                        <td class="py-1.5 px-2.5 text-primary">0.825</td>
                                                        <td class="py-1.5 px-2.5 text-outline">560</td>
                                                    </tr>
                                                    <tr class="bg-surface-container-low font-bold">
                                                        <td class="py-1.5 px-2.5">Macro Avg</td>
                                                        <td class="py-1.5 px-2.5">0.861</td>
                                                        <td class="py-1.5 px-2.5">0.856</td>
                                                        <td class="py-1.5 px-2.5">0.858</td>
                                                        <td class="py-1.5 px-2.5 text-outline">1990</td>
                                                    </tr>
                                                    <tr class="bg-surface-container-low font-bold">
                                                        <td class="py-1.5 px-2.5">Weighted Avg</td>
                                                        <td class="py-1.5 px-2.5">0.870</td>
                                                        <td class="py-1.5 px-2.5">0.876</td>
                                                        <td class="py-1.5 px-2.5">0.873</td>
                                                        <td class="py-1.5 px-2.5 text-outline">1990</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- Confusion Matrix Heatmap (5 Cols) -->
                                        <div class="lg:col-span-5 bg-surface-container rounded-lg p-space-sm flex flex-col justify-between">
                                            <div class="flex items-center justify-between mb-2">
                                                <span class="font-label-sm text-label-sm uppercase font-bold text-on-surface">Confusion Matrix</span>
                                                <span class="font-code-sm text-code-sm text-on-surface-variant">N = 1,990</span>
                                            </div>
                                            <div class="grid grid-cols-2 gap-2 text-center">
                                                <!-- TN -->
                                                <div class="p-2.5 rounded bg-surface-container-lowest shadow-sm flex flex-col">
                                                    <span class="font-label-sm text-label-sm text-outline uppercase">True Negative (0)</span>
                                                    <span class="font-headline-md text-headline-md font-bold text-primary mt-1">1,290</span>
                                                    <span class="text-[10px] text-on-surface-variant">Acc: 90.2%</span>
                                                </div>
                                                <!-- FP -->
                                                <div class="p-2.5 rounded bg-surface-container-high flex flex-col">
                                                    <span class="font-label-sm text-label-sm text-error uppercase">False Positive</span>
                                                    <span class="font-headline-md text-headline-md font-bold text-on-surface mt-1">140</span>
                                                    <span class="text-[10px] text-outline">Error Type I</span>
                                                </div>
                                                <!-- FN -->
                                                <div class="p-2.5 rounded bg-surface-container-high flex flex-col">
                                                    <span class="font-label-sm text-label-sm text-error uppercase">False Negative</span>
                                                    <span class="font-headline-md text-headline-md font-bold text-on-surface mt-1">172</span>
                                                    <span class="text-[10px] text-outline">Error Type II</span>
                                                </div>
                                                <!-- TP -->
                                                <div class="p-2.5 rounded bg-primary-container text-on-primary shadow-sm flex flex-col">
                                                    <span class="font-label-sm text-label-sm text-on-primary-container uppercase">True Positive (1)</span>
                                                    <span class="font-headline-md text-headline-md font-bold text-on-primary mt-1">388</span>
                                                    <span class="text-[10px] text-on-primary-container">Sens: 81.0%</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- CELL [6]: ACTIVE Interactive Code Cell -->
                            <div class="bg-surface-container-lowest rounded-xl overflow-hidden shadow-md" id="cell-6">
                                <div class="flex items-center justify-between px-space-md py-1.5 bg-primary text-on-primary">
                                    <div class="flex items-center gap-space-xs">
                                        <span class="font-code-sm text-code-sm font-bold text-secondary-fixed">In [*]:</span>
                                        <span class="font-label-sm text-label-sm text-on-primary">Active Cell • Ready for Execution</span>
                                    </div>
                                    <!-- Quick Cell Action Bar -->
                                    <div class="flex items-center gap-1">
                                        <button class="h-6 px-2 rounded bg-secondary text-on-secondary font-label-sm text-label-sm flex items-center gap-1 hover:bg-surface-tint transition-colors" type="button">
                                            <span class="material-symbols-outlined text-[13px]">play_arrow</span> Run (Ctrl+Enter)
                                        </button>
                                        <button class="p-1 rounded hover:bg-primary-container text-on-primary" title="Delete Cell" type="button">
                                            <span class="material-symbols-outlined text-[14px]">delete</span>
                                        </button>
                                        <button class="p-1 rounded hover:bg-primary-container text-on-primary" title="Move Up" type="button">
                                            <span class="material-symbols-outlined text-[14px]">arrow_upward</span>
                                        </button>
                                        <button class="p-1 rounded hover:bg-primary-container text-on-primary" title="Move Down" type="button">
                                            <span class="material-symbols-outlined text-[14px]">arrow_downward</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="p-space-md font-code-md text-code-md bg-surface-container-lowest text-on-surface">
                                    <div class="grid grid-cols-[30px_1fr] gap-space-sm items-start">
                                        <div class="text-right text-outline select-none font-code-sm text-code-sm leading-[22px]">
                                            1<br />2<br />3<br />4
                                        </div>
                                        <div class="leading-[22px]">
                                            <span class="text-outline-variant font-code-sm text-code-sm"># Final artifact packaging and MLflow schema export</span><br />
                                            mlflow.sklearn.log_model(<br />
                                                sk_model=xgb_best,<br />
                                                artifact_path=<span class="text-secondary font-medium">"model_artifacts"</span>,<br />
                                                registered_model_name=<span class="text-secondary font-medium">"churn-classifier"</span><br />
                                            )<br />
                                            <div class="inline-block w-2 h-4 bg-primary align-middle animate-pulse"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- Splitter Separator -->
                    <div class="w-1 bg-surface-container-high hover:bg-primary-container cursor-col-resize shrink-0 transition-colors"></div>
                    <!-- RIGHT PANEL: Insights & Experiment Tracking (340px) -->
                    <aside class="w-80 bg-surface-container-low shrink-0 flex flex-col p-space-sm overflow-y-auto" id="right-panel">
                        <!-- Panel Header & Tab Switcher -->
                        <div class="flex items-center justify-between pb-space-xs mb-space-xs">
                            <span class="font-label-sm text-label-sm uppercase font-bold text-primary flex items-center gap-1">
                                <span class="material-symbols-outlined text-[15px]">troubleshoot</span> Telemetry Drawer
                            </span>
                            <button class="p-0.5 rounded text-on-surface-variant hover:text-on-surface" title="Collapse Drawer" type="button">
                                <span class="material-symbols-outlined text-[15px]">last_page</span>
                            </button>
                        </div>
                        <!-- Tab Switcher -->
                        <div class="grid grid-cols-2 gap-1 bg-surface-container rounded-lg p-0.5 mb-space-sm text-center">
                            <button class="py-1 px-1 rounded bg-primary text-on-primary font-label-sm text-label-sm font-semibold shadow-sm" type="button">
                                Metrics &amp; Ticket
                            </button>
                            <button class="py-1 px-1 rounded text-on-surface-variant hover:text-on-surface font-label-sm text-label-sm" type="button">
                                Kernel Hardware
                            </button>
                        </div>
                        <!-- Tab Content Area -->
                        <div class="flex-1 flex flex-col gap-space-md">
                            <!-- 1. Active Assignment Card: Ticket TKT-AI-01-CHURN-409 -->
                            <div class="bg-surface-container-lowest rounded-xl p-space-sm shadow-sm flex flex-col gap-space-xs">
                                <div class="flex items-center justify-between">
                                    <span class="font-label-sm text-label-sm uppercase font-bold text-secondary">Assignment Spec</span>
                                    <span class="inline-flex items-center px-1.5 py-0.2 rounded bg-tertiary-fixed text-on-tertiary-fixed font-label-sm text-label-sm">HIGH PRIO</span>
                                </div>
                                <div>
                                    <div class="font-headline-sm text-headline-sm font-bold text-on-surface">TKT-AI-01-CHURN-409</div>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant mt-0.5">Customer Churn Prediction Model (v1.4 Golden Split Benchmark)</p>
                                </div>
                                <!-- Success Threshold Checklist -->
                                <div class="mt-space-xs flex flex-col gap-1.5">
                                    <!-- Metric 1: F1-Score -->
                                    <div class="p-2 rounded bg-surface-container-low flex flex-col gap-1">
                                        <div class="flex items-center justify-between font-label-sm text-label-sm">
                                            <span class="text-on-surface-variant font-bold">F1-Score (Validation)</span>
                                            <span class="text-primary font-bold">0.825 / 0.800 ✓</span>
                                        </div>
                                        <div class="w-full bg-surface-container-high rounded-full h-1.5 overflow-hidden">
                                            <div class="bg-primary h-full w-[100%]"></div>
                                        </div>
                                        <span class="text-[10px] text-tertiary font-medium">Passed: +0.025 above threshold</span>
                                    </div>
                                    <!-- Metric 2: ROC-AUC -->
                                    <div class="p-2 rounded bg-surface-container-low flex flex-col gap-1">
                                        <div class="flex items-center justify-between font-label-sm text-label-sm">
                                            <span class="text-on-surface-variant font-bold">ROC-AUC Target</span>
                                            <span class="text-primary font-bold">0.864 / 0.850 ✓</span>
                                        </div>
                                        <div class="w-full bg-surface-container-high rounded-full h-1.5 overflow-hidden">
                                            <div class="bg-primary h-full w-[100%]"></div>
                                        </div>
                                        <span class="text-[10px] text-tertiary font-medium">Passed: +0.014 above threshold</span>
                                    </div>
                                    <!-- Metric 3: Latency -->
                                    <div class="p-2 rounded bg-surface-container-low flex flex-col gap-1">
                                        <div class="flex items-center justify-between font-label-sm text-label-sm">
                                            <span class="text-on-surface-variant font-bold">Latency p95 (Inference)</span>
                                            <span class="text-primary font-bold">18ms / &lt;50ms ✓</span>
                                        </div>
                                        <div class="w-full bg-surface-container-high rounded-full h-1.5 overflow-hidden">
                                            <div class="bg-secondary-container h-full w-[36%]"></div>
                                        </div>
                                        <span class="text-[10px] text-outline font-medium">Target Met (&lt;50ms strict bound)</span>
                                    </div>
                                </div>
                            </div>
                            <!-- 2. Experiment Runs Comparison Mini-Matrix (MLflow Tracking) -->
                            <div class="bg-surface-container-lowest rounded-xl p-space-sm shadow-sm flex flex-col">
                                <div class="flex items-center justify-between mb-space-xs">
                                    <span class="font-label-sm text-label-sm uppercase font-bold text-primary flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[14px]">table_chart</span> MLflow Experiments
                                    </span>
                                    <span class="text-outline-variant font-code-sm text-code-sm">Exp ID: 42</span>
                                </div>
                                <div class="flex flex-col gap-1 font-code-sm text-code-sm">
                                    <!-- Run #04 Current Best -->
                                    <div class="p-2 rounded bg-secondary-fixed/50 flex flex-col gap-0.5">
                                        <div class="flex items-center justify-between font-bold">
                                            <span class="flex items-center gap-1 text-primary">
                                                <span class="w-2 h-2 rounded-full bg-primary"></span> Run #04 (Current)
                                            </span>
                                            <span class="px-1 rounded bg-tertiary-fixed text-on-tertiary-fixed font-label-sm text-label-sm">BEST</span>
                                        </div>
                                        <div class="text-[11px] text-on-surface">XGBoost Tuned (lr=0.03, d=6)</div>
                                        <div class="flex items-center justify-between mt-1 text-[11px] text-primary font-semibold">
                                            <span>F1: <strong>0.825</strong></span>
                                            <span>AUC: <strong>0.864</strong></span>
                                            <span>Loss: 0.384</span>
                                        </div>
                                    </div>
                                    <!-- Run #03 Baseline -->
                                    <div class="p-2 rounded bg-surface-container-low hover:bg-surface-container transition-colors flex flex-col gap-0.5">
                                        <div class="flex items-center justify-between">
                                            <span class="font-semibold text-on-surface">Run #03</span>
                                            <span class="text-outline text-[10px]">12m ago</span>
                                        </div>
                                        <div class="text-[11px] text-on-surface-variant">LightGBM Baseline</div>
                                        <div class="flex items-center justify-between mt-1 text-[11px] text-outline">
                                            <span>F1: 0.791</span>
                                            <span>AUC: 0.832</span>
                                            <span>Loss: 0.412</span>
                                        </div>
                                    </div>
                                    <!-- Run #02 Initial -->
                                    <div class="p-2 rounded bg-surface-container-low hover:bg-surface-container transition-colors flex flex-col gap-0.5">
                                        <div class="flex items-center justify-between">
                                            <span class="font-semibold text-on-surface">Run #02</span>
                                            <span class="text-outline text-[10px]">44m ago</span>
                                        </div>
                                        <div class="text-[11px] text-on-surface-variant">Random Forest v1</div>
                                        <div class="flex items-center justify-between mt-1 text-[11px] text-outline">
                                            <span>F1: 0.742</span>
                                            <span>AUC: 0.789</span>
                                            <span>Loss: 0.485</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- Promotion CTA -->
                                <div class="mt-space-sm pt-space-xs">
                                    <button class="w-full py-2 px-space-sm rounded bg-primary-container text-on-primary font-label-md text-label-md font-bold flex items-center justify-center gap-1.5 shadow-sm hover:bg-primary transition-colors" type="button">
                                        <span class="material-symbols-outlined text-[16px] text-tertiary-fixed">verified</span>
                                        <span>Promote Run #04 to Registry</span>
                                    </button>
                                    <p class="text-center text-[10px] text-outline mt-1 font-label-sm text-label-sm">
                                        Routes model to SYS-AI-04 Range Validation Gate
                                    </p>
                                </div>
                            </div>
                            <!-- 3. Real-Time Hardware Telemetry Gauges -->
                            <div class="bg-surface-container-lowest rounded-xl p-space-sm shadow-sm flex flex-col gap-space-xs">
                                <div class="flex items-center justify-between">
                                    <span class="font-label-sm text-label-sm uppercase font-bold text-on-surface">Node Hardware Telemetry</span>
                                    <span class="font-code-sm text-code-sm text-secondary font-semibold">A100-SXM4</span>
                                </div>
                                <div class="grid grid-cols-3 gap-space-xs text-center font-code-sm text-code-sm">
                                    <div class="p-2 rounded bg-surface-container-low flex flex-col">
                                        <span class="text-[10px] text-outline">GPU TEMP</span>
                                        <span class="font-bold text-on-surface text-[13px] mt-0.5">42°C</span>
                                        <span class="text-[9px] text-primary">Normal</span>
                                    </div>
                                    <div class="p-2 rounded bg-surface-container-low flex flex-col">
                                        <span class="text-[10px] text-outline">VRAM ALLOC</span>
                                        <span class="font-bold text-on-surface text-[13px] mt-0.5">3.2 GB</span>
                                        <span class="text-[9px] text-outline-variant">/ 40 GB</span>
                                    </div>
                                    <div class="p-2 rounded bg-surface-container-low flex flex-col">
                                        <span class="text-[10px] text-outline">CPU LOAD</span>
                                        <span class="font-bold text-on-surface text-[13px] mt-0.5">8.4%</span>
                                        <span class="text-[9px] text-primary">16 Threads</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </main>
    <script src="js/main.js"></script>
</body>

</html>