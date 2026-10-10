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
                <div class="hidden 2xl:flex flex-col text-left"><span class="font-label-md text-label-md font-semibold text-on-surface leading-none">Cadet E. Vance</span><span class="font-code-sm text-code-sm text-on-surface-variant leading-none mt-0.5">VP-8820</span></div>
            </div>
        </div>
    </header>
    <aside class="fixed left-0 top-16 bottom-0 w-72 bg-surface-container-low/95 backdrop-blur-md z-40 flex flex-col justify-between shadow-[1px_0_12px_rgba(76,29,149,0.04)]">
        <div class="flex flex-col">
            <div class="px-space-lg py-space-md flex items-center justify-between">
                <div class="flex items-center gap-space-sm"><span class="material-symbols-outlined text-primary text-[20px]">deployed_code</span><span class="font-headline-sm text-headline-sm text-primary tracking-tight">MLOps Hub</span></div><span class="font-code-sm text-code-sm px-1.5 py-0.5 bg-surface-container-high rounded text-on-surface-variant">REV 4.2</span>
            </div>
            <nav class="flex flex-col gap-1 px-space-md py-space-sm" data-active-classes="bg-primary-container text-on-primary font-bold rounded-lg shadow-sm"><a class="flex items-center gap-space-md px-space-md py-2.5 rounded-lg text-on-surface-variant font-label-md text-label-md hover:bg-surface-container-high hover:text-on-surface transition-colors" data-path="dashboard" href="dashboard.php"><span class="material-symbols-outlined text-[20px]">dashboard</span><span>Dashboard</span></a><a class="flex items-center gap-space-md px-space-md py-2.5 rounded-lg text-on-surface-variant font-label-md text-label-md hover:bg-surface-container-high hover:text-on-surface transition-colors" data-path="model-registry" href="ModelRegistry.php"><span class="material-symbols-outlined text-[20px]">inventory_2</span><span>Model Registry</span></a><a class="flex items-center gap-space-md px-space-md py-2.5 rounded-lg text-on-surface-variant font-label-md text-label-md hover:bg-surface-container-high hover:text-on-surface transition-colors" data-path="automated-validation-pipeline" href="ValidationPipeline.php"><span class="material-symbols-outlined text-[20px]">fact_check</span><span>Validation Pipeline</span></a><a aria-current="page" class="flex items-center gap-space-md px-space-md py-2.5 transition-colors bg-primary-container text-on-primary font-bold rounded-lg shadow-sm" data-path="deployment-configuration" href="DeploymentConfig.php"><span class="material-symbols-outlined text-[20px]">settings_input_component</span><span>Deployment Config</span></a><a class="flex items-center gap-space-md px-space-md py-2.5 rounded-lg text-on-surface-variant font-label-md text-label-md hover:bg-surface-container-high hover:text-on-surface transition-colors" data-path="deployed-endpoints" href="DeployedEndpoints.php"><span class="material-symbols-outlined text-[20px]">cell_tower</span><span>Deployed Endpoints</span></a><a class="flex items-center gap-space-md px-space-md py-2.5 rounded-lg text-on-surface-variant font-label-md text-label-md hover:bg-surface-container-high hover:text-on-surface transition-colors" data-path="validation-reports" href="ValidationReports.php"><span class="material-symbols-outlined text-[20px]">description</span><span>Validation Reports</span></a></nav>
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
                <!-- Top Breadcrumb & Metadata Strip -->
                <div class="flex flex-wrap items-center justify-between gap-space-sm pb-space-md">
                    <div class="flex items-center gap-space-xs font-label-sm text-label-sm tracking-wider uppercase text-on-surface-variant">
                        <span class="hover:text-primary cursor-pointer transition-colors">SYS-AI-04</span>
                        <span>/</span>
                        <span class="hover:text-primary cursor-pointer transition-colors">DEPLOYMENT PIPELINE</span>
                        <span>/</span>
                        <span class="text-primary font-bold">CONFIGURATION &amp; STAGING HARNESS</span>
                    </div>
                    <div class="flex items-center gap-space-sm">
                        <span class="px-2 py-0.5 rounded bg-surface-container-high font-code-sm text-code-sm text-primary font-semibold">TKT: VP-TKT-1082</span>
                        <span class="px-2 py-0.5 rounded bg-secondary-container/40 font-code-sm text-code-sm text-on-secondary-container font-semibold">PILOT: CADET E. VANCE (VP-8820)</span>
                        <div class="flex items-center gap-1.5 px-2 py-0.5 rounded bg-surface-container font-label-sm text-label-sm text-on-surface-variant">
                            <span class="w-1.5 h-1.5 rounded-full bg-on-tertiary-container animate-pulse"></span>
                            <span>CLUSTER: ORBIT-EU-CENTRAL-01</span>
                        </div>
                    </div>
                </div>
                <!-- Header Area with Primary Action Toolbar -->
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-space-md pb-space-lg">
                    <div class="flex flex-col max-w-3xl">
                        <div class="flex items-center gap-space-sm">
                            <h1 class="font-headline-lg text-headline-lg text-primary tracking-tight">Deployment Configuration &amp; Staging Gate</h1>
                            <span class="px-2 py-0.5 rounded font-code-sm text-code-sm bg-primary-fixed text-primary font-semibold">vp-mod-churn-xgb:v2.4.1</span>
                        </div>
                        <p class="font-body-md text-body-md text-on-surface-variant mt-1">
                            Prepare runtime parameters, hardware allocation, container environment variables, and pre-deployment safety gates for model artifact <span class="font-code-sm text-code-sm font-semibold text-primary">vp-mod-churn-xgb (v2.4.1)</span>.
                        </p>
                    </div>
                    <!-- Action Toolbar -->
                    <div class="flex flex-wrap items-center gap-space-sm">
                        <button class="flex items-center gap-1.5 px-space-md py-1.5 rounded bg-surface-container-lowest text-primary hover:bg-surface-container shadow-sm transition-all text-label-md font-label-md" id="btn-validate">
                            <span class="material-symbols-outlined text-[18px]">verified</span>
                            <span>Validate Configuration</span>
                        </button>
                        <button class="flex items-center gap-1.5 px-space-md py-1.5 rounded bg-secondary-fixed text-primary hover:bg-secondary-container shadow-sm transition-all text-label-md font-label-md font-semibold" id="btn-predeploy">
                            <span class="material-symbols-outlined text-[18px]">science</span>
                            <span>Run Pre-deployment Tests</span>
                        </button>
                        <button class="flex items-center gap-1.5 px-space-md py-1.5 rounded bg-tertiary-fixed text-on-tertiary-fixed hover:bg-tertiary-fixed-dim shadow-sm transition-all text-label-md font-label-md font-semibold" id="btn-instructor-approval">
                            <span class="material-symbols-outlined text-[18px]">gavel</span>
                            <span>Request Instructor Approval</span>
                        </button>
                        <button class="flex items-center gap-1.5 px-space-lg py-1.5 rounded bg-primary-container text-on-primary hover:bg-primary shadow-md transition-all text-label-md font-label-md font-bold" id="btn-deploy">
                            <span class="material-symbols-outlined text-[18px]">rocket_launch</span>
                            <span>Deploy to Staging Cluster</span>
                        </button>
                    </div>
                </div>
                <!-- Main Technical Workstation Grid -->
                <div class="grid grid-cols-1 xl:grid-cols-12 gap-space-lg items-start">
                    <!-- LEFT COLUMN (8 Cols): Configuration Specifications -->
                    <div class="xl:col-span-8 flex flex-col gap-space-lg">
                        <!-- Section A: Model Artifact & Target Environment Selection -->
                        <section class="bg-surface-container-lowest rounded-xl p-space-lg shadow-sm flex flex-col gap-space-md">
                            <div class="flex flex-wrap items-center justify-between gap-space-sm pb-space-xs">
                                <div class="flex items-center gap-space-sm">
                                    <span class="p-1 rounded bg-surface-container text-primary material-symbols-outlined text-[20px]">inventory_2</span>
                                    <div>
                                        <h2 class="font-headline-sm text-headline-sm text-primary">Model Artifact &amp; Target Environment</h2>
                                        <p class="font-body-sm text-body-sm text-on-surface-variant">Validated immutable image digest and execution domain destination</p>
                                    </div>
                                </div>
                                <span class="px-2 py-0.5 rounded bg-surface-container font-code-sm text-code-sm text-on-surface-variant">POD-ALLOC // #04</span>
                            </div>
                            <!-- Target Environment Selector Tabs -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-space-sm pt-space-xs">
                                <!-- Staging / Eval (Active) -->
                                <div class="relative p-space-md rounded-lg bg-surface-container-low cursor-pointer transition-all shadow-sm">
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="font-label-md text-label-md text-primary font-bold">Staging / Eval</span>
                                        <span class="w-2 h-2 rounded-full bg-primary-container"></span>
                                    </div>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant">Isolated validation sandbox</p>
                                    <div class="mt-2 flex items-center gap-1">
                                        <span class="px-1.5 py-0.5 rounded bg-primary-container text-on-primary font-label-sm text-label-sm uppercase font-semibold">Active Target</span>
                                    </div>
                                </div>
                                <!-- Canary -->
                                <div class="p-space-md rounded-lg bg-surface-container hover:bg-surface-container-high cursor-pointer transition-all">
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="font-label-md text-label-md text-on-surface font-semibold">Canary (10% Traffic)</span>
                                        <span class="w-2 h-2 rounded-full bg-outline-variant"></span>
                                    </div>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant">Progressive live user shift</p>
                                    <div class="mt-2 flex items-center gap-1">
                                        <span class="font-code-sm text-code-sm text-on-surface-variant">Gate: 0/2 Ready</span>
                                    </div>
                                </div>
                                <!-- Production (Locked) -->
                                <div class="p-space-md rounded-lg bg-surface-container/60 opacity-80 cursor-not-allowed">
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="font-label-md text-label-md text-on-surface-variant font-medium">Production Tier</span>
                                        <span class="material-symbols-outlined text-[16px] text-tertiary">lock</span>
                                    </div>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant">Full enterprise inference array</p>
                                    <div class="mt-2 flex items-center gap-1">
                                        <span class="px-1.5 py-0.5 rounded bg-tertiary-fixed text-on-tertiary-fixed font-label-sm text-label-sm uppercase">Faculty Locked</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Model Digest & Rollback Grid -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-space-md bg-surface-container-low p-space-md rounded-lg mt-space-xs">
                                <div class="flex flex-col gap-1">
                                    <span class="font-label-sm text-label-sm uppercase text-on-surface-variant font-semibold">Candidate Model Artifact</span>
                                    <div class="flex items-center gap-2">
                                        <span class="font-code-md text-code-md text-primary font-bold">vp-mod-churn-xgb:v2.4.1</span>
                                        <span class="px-1.5 py-0.5 rounded bg-surface-container text-primary font-code-sm text-code-sm">XGBoost 1.7.5</span>
                                    </div>
                                    <div class="flex items-center gap-1 text-on-surface-variant font-code-sm text-code-sm mt-0.5">
                                        <span class="material-symbols-outlined text-[14px] text-primary">fingerprint</span>
                                        <span class="truncate">SHA256: 88ef4a7b9d10e527c91fa8b88a914ec7a</span>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-1">
                                    <span class="font-label-sm text-label-sm uppercase text-on-surface-variant font-semibold">Rollback Version Anchor</span>
                                    <div class="relative">
                                        <select class="w-full bg-surface-container-lowest text-on-surface font-code-sm text-code-sm px-space-md py-1.5 rounded appearance-none shadow-sm cursor-pointer pr-8 focus:outline-none focus:ring-2 focus:ring-primary-container">
                                            <option selected="" value="v240">vp-mod-churn-xgb:v2.4.0 (Healthy — Latency 22ms)</option>
                                            <option value="v239">vp-mod-churn-xgb:v2.3.9 (Cold Archive — Latency 26ms)</option>
                                            <option value="v230">vp-mod-churn-xgb:v2.3.0 (Golden Baseline)</option>
                                        </select>
                                        <span class="material-symbols-outlined pointer-events-none absolute right-2.5 top-2 text-on-surface-variant text-[18px]">expand_more</span>
                                    </div>
                                    <span class="font-body-sm text-body-sm text-on-surface-variant mt-0.5">Automated fallback trigger on 3x consecutive health probe timeouts.</span>
                                </div>
                            </div>
                        </section>
                        <!-- Section B: Container & Runtime Hardware Allocation -->
                        <section class="bg-surface-container-lowest rounded-xl p-space-lg shadow-sm flex flex-col gap-space-md">
                            <div class="flex items-center justify-between pb-space-xs">
                                <div class="flex items-center gap-space-sm">
                                    <span class="p-1 rounded bg-surface-container text-primary material-symbols-outlined text-[20px]">memory</span>
                                    <div>
                                        <h2 class="font-headline-sm text-headline-sm text-primary">Container &amp; Runtime Hardware Allocation</h2>
                                        <p class="font-body-sm text-body-sm text-on-surface-variant">Autoscaling thresholds, thread parallelism, and memory limits</p>
                                    </div>
                                </div>
                                <span class="px-2 py-0.5 rounded bg-surface-container font-code-sm text-code-sm text-primary font-semibold">CPU-OPT / OPENBLAS</span>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-space-md">
                                <!-- Replicas & Scaling -->
                                <div class="p-space-md rounded-lg bg-surface-container-low flex flex-col gap-2">
                                    <span class="font-label-sm text-label-sm uppercase text-on-surface-variant font-semibold">Horizontal Autoscaling</span>
                                    <div class="flex items-baseline justify-between">
                                        <span class="font-code-md text-code-md text-on-surface">Min: <strong class="text-primary">2 pods</strong></span>
                                        <span class="font-code-md text-code-md text-on-surface">Max: <strong class="text-primary">6 pods</strong></span>
                                    </div>
                                    <div class="flex flex-col gap-1 mt-1">
                                        <div class="flex justify-between font-label-sm text-label-sm text-on-surface-variant">
                                            <span>Target CPU Saturation</span>
                                            <span class="font-code-sm text-code-sm font-semibold text-primary">70%</span>
                                        </div>
                                        <div class="w-full h-1.5 bg-surface-container-highest rounded-full overflow-hidden">
                                            <div class="h-full bg-primary-container rounded-full" style="width: 70%"></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Compute Profile -->
                                <div class="p-space-md rounded-lg bg-surface-container-low flex flex-col gap-2">
                                    <span class="font-label-sm text-label-sm uppercase text-on-surface-variant font-semibold">Compute Architecture</span>
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-primary text-[20px]">developer_board</span>
                                        <span class="font-code-sm text-code-sm text-on-surface font-semibold">2x vCPU (AMD EPYC Milan)</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-primary text-[20px]">storage</span>
                                        <span class="font-code-sm text-code-sm text-on-surface font-semibold">4.0 GiB Memory (DDR4)</span>
                                    </div>
                                    <span class="font-code-sm text-code-sm text-on-surface-variant">GPU: None (Optimized Matrix Engine)</span>
                                </div>
                                <!-- Concurrency & Timeouts -->
                                <div class="p-space-md rounded-lg bg-surface-container-low flex flex-col gap-2">
                                    <span class="font-label-sm text-label-sm uppercase text-on-surface-variant font-semibold">Concurrency &amp; Networking</span>
                                    <div class="flex justify-between items-center text-body-sm font-body-sm">
                                        <span class="text-on-surface-variant">Worker Threads</span>
                                        <span class="font-code-sm text-code-sm font-semibold text-primary">4 threads/worker</span>
                                    </div>
                                    <div class="flex justify-between items-center text-body-sm font-body-sm">
                                        <span class="text-on-surface-variant">Request Timeout</span>
                                        <span class="font-code-sm text-code-sm font-semibold text-primary">1500 ms</span>
                                    </div>
                                    <div class="flex justify-between items-center text-body-sm font-body-sm">
                                        <span class="text-on-surface-variant">Keep-Alive Session</span>
                                        <span class="font-code-sm text-code-sm font-semibold text-primary">60 sec</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Inline Visual Resource Utilization Preview -->
                            <div class="p-space-md rounded-lg bg-surface-container flex flex-col gap-2">
                                <div class="flex items-center justify-between">
                                    <span class="font-label-sm text-label-sm uppercase text-on-surface-variant font-semibold">Estimated P99 Latency vs Batch Size Envelope</span>
                                    <span class="font-code-sm text-code-sm text-primary font-medium">Model Inference Benchmark (Synthetic)</span>
                                </div>
                                <!-- Compact SVG Sparkline Matrix -->
                                <div class="w-full h-14 flex items-center">
                                    <svg class="w-full h-full" fill="none" preserveaspectratio="none" viewbox="0 0 600 56">
                                        <line class="text-surface-container-highest" stroke="currentColor" stroke-width="1" x1="0" x2="600" y1="50" y2="50"></line>
                                        <line class="text-surface-container-highest" stroke="currentColor" stroke-dasharray="2 4" stroke-width="1" x1="0" x2="600" y1="28" y2="28"></line>
                                        <!-- Safe envelope band -->
                                        <rect class="text-secondary-fixed/40" fill="currentColor" height="30" width="600" x="0" y="20"></rect>
                                        <!-- Latency curve -->
                                        <path class="text-primary-container" d="M 0 45 C 100 44, 200 42, 300 36 C 400 30, 500 24, 600 16" fill="none" stroke="currentColor" stroke-width="2.5"></path>
                                        <!-- P95 markers -->
                                        <circle class="text-primary-container" cx="300" cy="36" fill="currentColor" r="4"></circle>
                                        <circle class="text-on-tertiary-container" cx="450" cy="27" fill="currentColor" r="4"></circle>
                                    </svg>
                                </div>
                                <div class="flex items-center justify-between text-on-surface-variant font-code-sm text-code-sm">
                                    <span>Batch 1 (14.2ms)</span>
                                    <span>Batch 16 (18.4ms - Target Baseline)</span>
                                    <span>Batch 32 (23.1ms)</span>
                                    <span>Batch 64 (34.8ms / Max Safe)</span>
                                </div>
                            </div>
                        </section>
                        <!-- Section C: Environment Variables & Security Status -->
                        <section class="bg-surface-container-lowest rounded-xl p-space-lg shadow-sm flex flex-col gap-space-md">
                            <div class="flex items-center justify-between pb-space-xs">
                                <div class="flex items-center gap-space-sm">
                                    <span class="p-1 rounded bg-surface-container text-primary material-symbols-outlined text-[20px]">security</span>
                                    <div>
                                        <h2 class="font-headline-sm text-headline-sm text-primary">Environment Variables &amp; Vault Injection</h2>
                                        <p class="font-body-sm text-body-sm text-on-surface-variant">Containerized runtime keys and secure OIDC integration parameters</p>
                                    </div>
                                </div>
                                <span class="px-2 py-0.5 rounded bg-tertiary-fixed text-on-tertiary-fixed font-label-sm text-label-sm uppercase font-semibold">OIDC ENFORCED</span>
                            </div>
                            <!-- Key-Value Configuration Table -->
                            <div class="overflow-x-auto rounded-lg bg-surface-container-low">
                                <table class="w-full text-left font-body-sm text-body-sm">
                                    <thead class="bg-surface-container-high text-on-surface-variant font-label-sm text-label-sm uppercase">
                                        <tr>
                                            <th class="py-2 px-space-md font-semibold">Configuration Variable</th>
                                            <th class="py-2 px-space-md font-semibold">Active Value</th>
                                            <th class="py-2 px-space-md font-semibold">Source / Route</th>
                                            <th class="py-2 px-space-md text-right font-semibold">State</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-surface-container-highest font-code-sm text-code-sm text-on-surface">
                                        <tr class="hover:bg-surface-container transition-colors">
                                            <td class="py-2.5 px-space-md font-bold text-primary">LOG_LEVEL</td>
                                            <td class="py-2.5 px-space-md font-mono">INFO</td>
                                            <td class="py-2.5 px-space-md text-on-surface-variant">Default Staging ConfigMap</td>
                                            <td class="py-2.5 px-space-md text-right"><span class="px-1.5 py-0.5 rounded bg-surface-container text-primary font-semibold">LOCKED</span></td>
                                        </tr>
                                        <tr class="hover:bg-surface-container transition-colors">
                                            <td class="py-2.5 px-space-md font-bold text-primary">ENABLE_DRIFT_TELEMETRY</td>
                                            <td class="py-2.5 px-space-md font-mono text-primary font-bold">true</td>
                                            <td class="py-2.5 px-space-md text-on-surface-variant">SYS-AI-05 SOC Range Collector</td>
                                            <td class="py-2.5 px-space-md text-right"><span class="px-1.5 py-0.5 rounded bg-secondary-fixed text-on-secondary-fixed font-semibold">STREAMING</span></td>
                                        </tr>
                                        <tr class="hover:bg-surface-container transition-colors">
                                            <td class="py-2.5 px-space-md font-bold text-primary">MAX_BATCH_SIZE</td>
                                            <td class="py-2.5 px-space-md font-mono">64</td>
                                            <td class="py-2.5 px-space-md text-on-surface-variant">Worker Thread Constraint</td>
                                            <td class="py-2.5 px-space-md text-right"><span class="px-1.5 py-0.5 rounded bg-surface-container text-primary font-semibold">STATIC</span></td>
                                        </tr>
                                        <tr class="hover:bg-surface-container transition-colors">
                                            <td class="py-2.5 px-space-md font-bold text-primary">MODEL_REGISTRY_URI</td>
                                            <td class="py-2.5 px-space-md font-mono text-on-surface truncate max-w-xs">s3://vostok-models/sys-ai-04/vp-mod-churn-xgb/v2.4.1</td>
                                            <td class="py-2.5 px-space-md text-on-surface-variant">Internal MinIO / Object Store</td>
                                            <td class="py-2.5 px-space-md text-right"><span class="px-1.5 py-0.5 rounded bg-surface-container text-primary font-semibold">VERIFIED</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- Security Callout Notice -->
                            <div class="flex items-start gap-space-sm p-space-md rounded-lg bg-surface-container">
                                <span class="material-symbols-outlined text-primary text-[20px] mt-0.5">enhanced_encryption</span>
                                <div class="flex flex-col gap-0.5">
                                    <span class="font-label-md text-label-md font-bold text-primary">Secrets Masked via HashiCorp Vault</span>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant">
                                        2 Vault secrets injected directly via Kubernetes ServiceAccount (OIDC integration): <code class="font-code-sm text-code-sm bg-surface-container-high px-1 py-0.5 rounded">TELEMETRY_INGESTION_TOKEN</code> and <code class="font-code-sm text-code-sm bg-surface-container-high px-1 py-0.5 rounded">INFERENCE_SIGNING_KEY</code>. Raw cryptographic credentials are never exposed in the interface or client response envelopes.
                                    </p>
                                </div>
                            </div>
                        </section>
                        <!-- Section D: Health Checks & Traffic Routing -->
                        <section class="bg-surface-container-lowest rounded-xl p-space-lg shadow-sm flex flex-col gap-space-md">
                            <div class="flex items-center justify-between pb-space-xs">
                                <div class="flex items-center gap-space-sm">
                                    <span class="p-1 rounded bg-surface-container text-primary material-symbols-outlined text-[20px]">network_check</span>
                                    <div>
                                        <h2 class="font-headline-sm text-headline-sm text-primary">Health Probes &amp; Ingress Gateway Routing</h2>
                                        <p class="font-body-sm text-body-sm text-on-surface-variant">Kubernetes kubelet readiness guarantees and Envoy proxy endpoints</p>
                                    </div>
                                </div>
                                <span class="px-2 py-0.5 rounded bg-surface-container-low font-code-sm text-code-sm text-primary font-bold">PORT 8080 // HTTP</span>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-space-md">
                                <!-- Liveness Probe -->
                                <div class="p-space-md rounded-lg bg-surface-container-low flex flex-col gap-1.5">
                                    <div class="flex items-center justify-between">
                                        <span class="font-label-md text-label-md font-bold text-primary flex items-center gap-1.5">
                                            <span class="w-2 h-2 rounded-full bg-primary-container"></span>
                                            Liveness Probe
                                        </span>
                                        <span class="font-code-sm text-code-sm text-on-surface-variant">HTTP GET</span>
                                    </div>
                                    <div class="font-code-sm text-code-sm bg-surface-container px-2 py-1 rounded text-primary font-semibold">
                                        /healthz (Port 8080)
                                    </div>
                                    <div class="grid grid-cols-3 gap-1 pt-1 text-on-surface-variant font-code-sm text-code-sm">
                                        <div>Interval: <strong class="text-on-surface">10s</strong></div>
                                        <div>Timeout: <strong class="text-on-surface">2s</strong></div>
                                        <div>Failure: <strong class="text-on-surface">3</strong></div>
                                    </div>
                                </div>
                                <!-- Readiness Probe -->
                                <div class="p-space-md rounded-lg bg-surface-container-low flex flex-col gap-1.5">
                                    <div class="flex items-center justify-between">
                                        <span class="font-label-md text-label-md font-bold text-primary flex items-center gap-1.5">
                                            <span class="w-2 h-2 rounded-full bg-primary-container"></span>
                                            Readiness Probe
                                        </span>
                                        <span class="font-code-sm text-code-sm text-on-surface-variant">HTTP GET</span>
                                    </div>
                                    <div class="font-code-sm text-code-sm bg-surface-container px-2 py-1 rounded text-primary font-semibold">
                                        /ready (Port 8080)
                                    </div>
                                    <div class="grid grid-cols-3 gap-1 pt-1 text-on-surface-variant font-code-sm text-code-sm">
                                        <div>Delay: <strong class="text-on-surface">5s</strong></div>
                                        <div>Interval: <strong class="text-on-surface">5s</strong></div>
                                        <div>Failure: <strong class="text-on-surface">2</strong></div>
                                    </div>
                                </div>
                            </div>
                            <!-- Ingress Gateway Endpoint -->
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 p-space-md rounded-lg bg-surface-container">
                                <div class="flex items-center gap-space-sm min-w-0">
                                    <span class="material-symbols-outlined text-primary text-[20px]">router</span>
                                    <div class="flex flex-col min-w-0">
                                        <span class="font-label-sm text-label-sm uppercase text-on-surface-variant font-semibold">Envoy Ingress Gateway Route</span>
                                        <span class="font-code-sm text-code-sm text-primary font-bold truncate">https://gateway.vostokpribor.internal/v1/predict/churn</span>
                                    </div>
                                </div>
                                <button class="shrink-0 flex items-center gap-1 px-space-md py-1 rounded bg-surface-container-lowest text-primary hover:bg-surface-container-high transition-colors font-label-sm text-label-sm font-semibold shadow-sm" id="btn-copy-ingress">
                                    <span class="material-symbols-outlined text-[16px]">content_copy</span>
                                    <span>Copy Route</span>
                                </button>
                            </div>
                        </section>
                    </div>
                    <!-- RIGHT COLUMN (4 Cols): Schemas, Testing & Instructor Sign-Off -->
                    <div class="xl:col-span-4 flex flex-col gap-space-lg">
                        <!-- Panel 1: API Request & Response Schema Preview -->
                        <section class="bg-surface-container-lowest rounded-xl p-space-lg shadow-sm flex flex-col gap-space-md">
                            <div class="flex items-center justify-between pb-space-xs">
                                <div class="flex items-center gap-space-sm">
                                    <span class="p-1 rounded bg-surface-container text-primary material-symbols-outlined text-[20px]">code</span>
                                    <div>
                                        <h2 class="font-headline-sm text-headline-sm text-primary">Inference Schema</h2>
                                        <p class="font-body-sm text-body-sm text-on-surface-variant">Validated input/output contract</p>
                                    </div>
                                </div>
                                <button class="p-1 text-on-surface-variant hover:text-primary transition-colors" id="btn-copy-code" title="Copy Content">
                                    <span class="material-symbols-outlined text-[18px]">copy_all</span>
                                </button>
                            </div>
                            <!-- Interactive Tabs -->
                            <div class="flex items-center gap-1 bg-surface-container-low p-1 rounded-lg">
                                <button class="flex-1 py-1 text-center font-label-sm text-label-sm rounded bg-surface-container-lowest text-primary font-bold shadow-sm transition-all" id="tab-json">JSON Schema</button>
                                <button class="flex-1 py-1 text-center font-label-sm text-label-sm rounded text-on-surface-variant hover:text-primary transition-all" id="tab-curl">cURL Sample</button>
                                <button class="flex-1 py-1 text-center font-label-sm text-label-sm rounded text-on-surface-variant hover:text-primary transition-all" id="tab-resp">Response Payload</button>
                            </div>
                            <!-- Code Viewer Box -->
                            <div class="relative bg-inverse-surface rounded-lg p-space-md text-inverse-on-surface font-code-sm text-code-sm overflow-x-auto shadow-inner min-h-[260px]">
                                <!-- JSON View (Default) -->
                                <div class="flex flex-col gap-1 leading-relaxed" id="view-json">
                                    <span class="text-secondary-fixed font-bold">{</span>
                                    <span class="pl-3 text-secondary-fixed">"contract_tenure_months"<span class="text-inverse-on-surface">: </span><span class="text-tertiary-fixed">18</span>,</span>
                                    <span class="pl-3 text-secondary-fixed">"billing_cycle_delay_days"<span class="text-inverse-on-surface">: </span><span class="text-tertiary-fixed">2</span>,</span>
                                    <span class="pl-3 text-secondary-fixed">"telemetry_disconnect_rate"<span class="text-inverse-on-surface">: </span><span class="text-tertiary-fixed">0.342</span>,</span>
                                    <span class="pl-3 text-secondary-fixed">"api_error_spike_count_7d"<span class="text-inverse-on-surface">: </span><span class="text-tertiary-fixed">3</span>,</span>
                                    <span class="pl-3 text-secondary-fixed">"account_seat_count"<span class="text-inverse-on-surface">: </span><span class="text-tertiary-fixed">45</span>,</span>
                                    <span class="pl-3 text-secondary-fixed">"sla_severity_tickets_open"<span class="text-inverse-on-surface">: </span><span class="text-tertiary-fixed">0</span></span>
                                    <span class="text-secondary-fixed font-bold">}</span>
                                </div>
                                <!-- cURL View (Hidden initially) -->
                                <div class="hidden flex-col gap-1 leading-relaxed text-surface-container-low" id="view-curl">
                                    <span class="text-tertiary-fixed">curl</span> -X POST \
                                    <span class="pl-2">https://gateway.vostokpribor.internal/v1/predict/churn \</span>
                                    <span class="pl-2">-H <span class="text-secondary-fixed">"Content-Type: application/json"</span> \</span>
                                    <span class="pl-2">-H <span class="text-secondary-fixed">"X-Vault-Client: VP-8820"</span> \</span>
                                    <span class="pl-2">-d <span class="text-tertiary-fixed">'{"contract_tenure_months": 18, "billing_cycle_delay_days": 2}'</span></span>
                                </div>
                                <!-- Response View (Hidden initially) -->
                                <div class="hidden flex-col gap-1 leading-relaxed" id="view-resp">
                                    <span class="text-secondary-fixed font-bold">{</span>
                                    <span class="pl-3 text-secondary-fixed">"churn_probability"<span class="text-inverse-on-surface">: </span><span class="text-tertiary-fixed">0.142</span>,</span>
                                    <span class="pl-3 text-secondary-fixed">"prediction_tier"<span class="text-inverse-on-surface">: </span><span class="text-secondary-fixed">"LOW_RISK"</span>,</span>
                                    <span class="pl-3 text-secondary-fixed">"model_version"<span class="text-inverse-on-surface">: </span><span class="text-secondary-fixed">"v2.4.1"</span>,</span>
                                    <span class="pl-3 text-secondary-fixed">"latency_ms"<span class="text-inverse-on-surface">: </span><span class="text-tertiary-fixed">16.8</span>,</span>
                                    <span class="pl-3 text-secondary-fixed">"evaluation_status"<span class="text-inverse-on-surface">: </span><span class="text-secondary-fixed">"PASS_SLA"</span></span>
                                    <span class="text-secondary-fixed font-bold">}</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between text-on-surface-variant font-body-sm text-body-sm">
                                <span>Target Response Payload: <strong>214 bytes</strong></span>
                                <span class="font-code-sm text-code-sm text-primary font-semibold">STATUS: 200 OK</span>
                            </div>
                        </section>
                        <!-- Panel 2: Pre-deployment Gate Status & Instructor Sign-Off Checklist -->
                        <section class="bg-surface-container-lowest rounded-xl p-space-lg shadow-sm flex flex-col gap-space-md">
                            <div class="flex items-center justify-between pb-space-xs">
                                <div class="flex items-center gap-space-sm">
                                    <span class="p-1 rounded bg-surface-container text-primary material-symbols-outlined text-[20px]">fact_check</span>
                                    <div>
                                        <h2 class="font-headline-sm text-headline-sm text-primary">Pre-deployment Gates</h2>
                                        <p class="font-body-sm text-body-sm text-on-surface-variant">Automated validation compliance &amp; sign-off</p>
                                    </div>
                                </div>
                                <span class="px-2 py-0.5 rounded bg-surface-container text-primary font-label-sm text-label-sm font-bold uppercase">4/5 READY</span>
                            </div>
                            <!-- Compliance List -->
                            <div class="flex flex-col gap-2">
                                <!-- Gate 1: Deterministic Validation Matrix -->
                                <div class="p-space-sm rounded-lg bg-surface-container-low flex items-start justify-between gap-space-sm">
                                    <div class="flex items-start gap-2">
                                        <span class="material-symbols-outlined text-primary text-[18px] mt-0.5">check_circle</span>
                                        <div class="flex flex-col">
                                            <span class="font-label-md text-label-md font-semibold text-on-surface">1. Deterministic Validation Matrix</span>
                                            <span class="font-body-sm text-body-sm text-on-surface-variant">10/10 automated tests passed</span>
                                        </div>
                                    </div>
                                    <span class="px-2 py-0.5 rounded font-label-sm text-label-sm bg-surface-container text-primary font-bold uppercase">PASSED</span>
                                </div>
                                <!-- Gate 2: Container Image Vulnerability Scan -->
                                <div class="p-space-sm rounded-lg bg-surface-container-low flex items-start justify-between gap-space-sm">
                                    <div class="flex items-start gap-2">
                                        <span class="material-symbols-outlined text-primary text-[18px] mt-0.5">verified_user</span>
                                        <div class="flex flex-col">
                                            <span class="font-label-md text-label-md font-semibold text-on-surface">2. Container Security Scan (Trivy)</span>
                                            <span class="font-body-sm text-body-sm text-on-surface-variant">0 Critical / 0 High vulnerabilities</span>
                                        </div>
                                    </div>
                                    <span class="px-2 py-0.5 rounded font-label-sm text-label-sm bg-surface-container text-primary font-bold uppercase">CLEAN</span>
                                </div>
                                <!-- Gate 3: Schema Contract Validation -->
                                <div class="p-space-sm rounded-lg bg-surface-container-low flex items-start justify-between gap-space-sm">
                                    <div class="flex items-start gap-2">
                                        <span class="material-symbols-outlined text-primary text-[18px] mt-0.5">sync_alt</span>
                                        <div class="flex flex-col">
                                            <span class="font-label-md text-label-md font-semibold text-on-surface">3. Schema Contract Validation</span>
                                            <span class="font-body-sm text-body-sm text-on-surface-variant">24/24 input features bound cleanly</span>
                                        </div>
                                    </div>
                                    <span class="px-2 py-0.5 rounded font-label-sm text-label-sm bg-surface-container text-primary font-bold uppercase">BOUND</span>
                                </div>
                                <!-- Gate 4: SLA Latency Envelope Check -->
                                <div class="p-space-sm rounded-lg bg-surface-container-low flex items-start justify-between gap-space-sm">
                                    <div class="flex items-start gap-2">
                                        <span class="material-symbols-outlined text-primary text-[18px] mt-0.5">timer</span>
                                        <div class="flex flex-col">
                                            <span class="font-label-md text-label-md font-semibold text-on-surface">4. SLA Latency Envelope Check</span>
                                            <span class="font-body-sm text-body-sm text-on-surface-variant">P95 18.4ms &lt;= 45.0ms threshold</span>
                                        </div>
                                    </div>
                                    <span class="px-2 py-0.5 rounded font-label-sm text-label-sm bg-surface-container text-primary font-bold uppercase">COMPLIANT</span>
                                </div>
                                <!-- Gate 5: Instructor Faculty Token Gate (Pending) -->
                                <div class="p-space-md rounded-lg bg-tertiary-fixed/30 flex flex-col gap-space-xs mt-1">
                                    <div class="flex items-start justify-between gap-space-sm">
                                        <div class="flex items-start gap-2">
                                            <span class="material-symbols-outlined text-on-tertiary-container text-[18px] mt-0.5">hourglass_top</span>
                                            <div class="flex flex-col">
                                                <span class="font-label-md text-label-md font-bold text-on-surface">5. Instructor Faculty Token Gate</span>
                                                <span class="font-body-sm text-body-sm text-on-surface-variant">Supervisory validation required</span>
                                            </div>
                                        </div>
                                        <span class="px-2 py-0.5 rounded font-label-sm text-label-sm bg-tertiary-fixed text-on-tertiary-fixed font-bold uppercase">PENDING</span>
                                    </div>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant pt-1">
                                        Cadet E. Vance has submitted evidence bundle: <code class="font-code-sm text-code-sm text-primary font-semibold">#VP-EVD-1082-20241024-V241</code>
                                    </p>
                                    <!-- Signature Input & Action -->
                                    <div class="flex items-center gap-space-xs pt-1">
                                        <input class="w-full bg-surface-container-lowest text-on-surface font-code-sm text-code-sm px-space-md py-1.5 rounded focus:outline-none focus:ring-1 focus:ring-primary shadow-inner" id="input-token" placeholder="Enter Faculty Security Token..." type="text" />
                                        <button class="shrink-0 px-space-md py-1.5 rounded bg-tertiary-fixed text-on-tertiary-fixed hover:bg-tertiary-fixed-dim transition-colors font-label-sm text-label-sm font-bold shadow-sm" id="btn-verify-token">
                                            Sign Gate
                                        </button>
                                    </div>
                                    <span class="font-body-sm text-body-sm text-on-surface-variant italic" id="token-status-msg">Waiting for supervisory cryptographic signature...</span>
                                </div>
                            </div>
                        </section>
                        <!-- Pedagogical Range Quick Tip -->
                        <div class="p-space-md rounded-xl bg-surface-container flex items-center gap-space-md">
                            <span class="p-2 rounded-full bg-surface-container-highest text-primary material-symbols-outlined text-[20px]">school</span>
                            <div class="flex flex-col">
                                <span class="font-label-md text-label-md font-bold text-primary">Lab Instruction Note</span>
                                <span class="font-body-sm text-body-sm text-on-surface-variant">Staging deployments can be rolled back anytime via the left telemetry console or via automated threshold breaches.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="js/main.js"></script>
</body>

</html>