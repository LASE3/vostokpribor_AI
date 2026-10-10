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
            <nav class="flex flex-col gap-1 px-space-md py-space-sm" data-active-classes="bg-primary-container text-on-primary font-bold rounded-lg shadow-sm"><a class="flex items-center gap-space-md px-space-md py-2.5 rounded-lg text-on-surface-variant font-label-md text-label-md hover:bg-surface-container-high hover:text-on-surface transition-colors" data-path="dashboard" href="dashboard.php"><span class="material-symbols-outlined text-[20px]">dashboard</span><span>Dashboard</span></a><a class="flex items-center gap-space-md px-space-md py-2.5 rounded-lg text-on-surface-variant font-label-md text-label-md hover:bg-surface-container-high hover:text-on-surface transition-colors" data-path="model-registry" href="ModelRegistry.php"><span class="material-symbols-outlined text-[20px]">inventory_2</span><span>Model Registry</span></a><a class="flex items-center gap-space-md px-space-md py-2.5 rounded-lg text-on-surface-variant font-label-md text-label-md hover:bg-surface-container-high hover:text-on-surface transition-colors" data-path="automated-validation-pipeline" href="ValidationPipeline.php"><span class="material-symbols-outlined text-[20px]">fact_check</span><span>Validation Pipeline</span></a><a class="flex items-center gap-space-md px-space-md py-2.5 rounded-lg text-on-surface-variant font-label-md text-label-md hover:bg-surface-container-high hover:text-on-surface transition-colors" data-path="deployment-configuration" href="DeploymentConfig.php"><span class="material-symbols-outlined text-[20px]">settings_input_component</span><span>Deployment Config</span></a><a aria-current="page" class="flex items-center gap-space-md px-space-md py-2.5 transition-colors bg-primary-container text-on-primary font-bold rounded-lg shadow-sm" data-path="deployed-endpoints" href="DeployedEndpoints.php"><span class="material-symbols-outlined text-[20px]">cell_tower</span><span>Deployed Endpoints</span></a><a class="flex items-center gap-space-md px-space-md py-2.5 rounded-lg text-on-surface-variant font-label-md text-label-md hover:bg-surface-container-high hover:text-on-surface transition-colors" data-path="validation-reports" href="ValidationReports.php"><span class="material-symbols-outlined text-[20px]">description</span><span>Validation Reports</span></a></nav>
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
                <!-- Sub-Header / Breadcrumb & Control Deck -->
                <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-space-md mb-space-lg">
                    <div class="flex flex-col">
                        <div class="flex items-center gap-space-xs font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant">
                            <span class="text-primary font-bold">SYS-AI-04</span>
                            <span>/</span>
                            <span>DEPLOYED ENDPOINTS</span>
                            <span>//</span>
                            <span class="bg-surface-container-high px-1.5 py-0.5 rounded text-primary font-semibold">CLUSTER: ORBIT-EU-CENTRAL-01</span>
                            <span class="inline-flex items-center gap-1 text-on-tertiary-container ml-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
                                ENVOY MESH V1.28
                            </span>
                        </div>
                        <h1 class="font-headline-lg text-headline-lg text-primary tracking-tight mt-1">
                            Live Serving Endpoints &amp; Cluster Telemetry
                        </h1>
                        <p class="font-body-sm text-body-sm text-on-surface-variant max-w-3xl">
                            Real-time inference gateway routing, ingress traffic splits, runtime health probes, and automated circuit rollbacks for certified models.
                        </p>
                    </div>
                    <!-- Quick Action Tool Tray -->
                    <div class="flex flex-wrap items-center gap-space-sm">
                        <button class="h-8 px-space-md bg-surface-container-low text-primary hover:bg-surface-container-highest transition-colors rounded font-label-md text-label-md flex items-center gap-1.5 shadow-sm" onclick="purgeCacheNotification()">
                            <span class="material-symbols-outlined text-[16px]">cached</span>
                            <span>Purge Ingress Cache</span>
                        </button>
                        <button class="h-8 px-space-md bg-secondary-fixed text-on-secondary-fixed hover:bg-secondary-fixed-dim transition-colors rounded font-label-md text-label-md flex items-center gap-1.5 shadow-sm" onclick="openCanaryShiftModal()">
                            <span class="material-symbols-outlined text-[16px]">alt_route</span>
                            <span>Shift Canary Traffic</span>
                        </button>
                        <button class="h-8 px-space-md bg-primary-container text-on-primary hover:bg-primary transition-colors rounded font-label-md text-label-md font-semibold flex items-center gap-1.5 shadow-sm">
                            <span class="material-symbols-outlined text-[16px]">add_circle</span>
                            <span>Deploy New Endpoint</span>
                        </button>
                    </div>
                </div>
                <!-- Lifecycle Tier Guide Bar (Model Lifecycle Precision) -->
                <div class="bg-surface-container-lowest p-space-sm rounded-lg shadow-sm mb-space-lg flex flex-wrap items-center justify-between gap-space-md">
                    <div class="flex items-center gap-space-md text-on-surface-variant font-code-sm text-code-sm">
                        <span class="font-bold text-primary uppercase font-label-sm text-label-sm">Lifecycle Hierarchy:</span>
                        <div class="flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-outline-variant"></span>
                            <span>1. Registered Artifact</span>
                        </div>
                        <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                        <div class="flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-secondary-container"></span>
                            <span>2. Quality Approved</span>
                        </div>
                        <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                        <div class="flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-tertiary-fixed-dim"></span>
                            <span>3. Deployment Ready</span>
                        </div>
                        <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                        <div class="flex items-center gap-1.5 px-2 py-0.5 rounded bg-primary-container text-on-primary font-bold">
                            <span class="w-2 h-2 rounded-full bg-on-primary-container animate-pulse"></span>
                            <span>4. Running Active Endpoint</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-space-sm font-label-sm text-label-sm text-on-surface-variant">
                        <span>Auto-drain Grace Period:</span>
                        <span class="font-code-sm text-code-sm font-semibold text-primary">120s TCP SYN/FIN</span>
                    </div>
                </div>
                <!-- Operational Summary KPI Metric Deck -->
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-space-md mb-space-lg">
                    <!-- Card 1 -->
                    <div class="bg-surface-container-lowest p-space-md rounded-lg shadow-sm flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <span class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant">Total Active Endpoints</span>
                            <span class="material-symbols-outlined text-primary text-[18px]">dns</span>
                        </div>
                        <div class="my-space-xs flex items-baseline gap-space-sm">
                            <span class="font-headline-xl text-headline-xl text-primary font-bold leading-none">9</span>
                            <span class="font-code-sm text-code-sm text-on-surface-variant">online nodes</span>
                        </div>
                        <div class="flex items-center justify-between font-code-sm text-code-sm text-on-surface-variant pt-space-xs">
                            <span class="text-primary font-semibold">2 Production</span>
                            <span>•</span>
                            <span class="text-secondary font-semibold">7 Staging / Canary</span>
                        </div>
                    </div>
                    <!-- Card 2 -->
                    <div class="bg-surface-container-lowest p-space-md rounded-lg shadow-sm flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <span class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant">Aggregate RPS Throughput</span>
                            <span class="material-symbols-outlined text-secondary text-[18px]">speed</span>
                        </div>
                        <div class="my-space-xs flex items-baseline gap-space-sm">
                            <span class="font-headline-xl text-headline-xl text-primary font-bold leading-none">1,420</span>
                            <span class="font-label-md text-label-md text-on-surface-variant">req/s</span>
                        </div>
                        <div class="flex items-center gap-1 font-code-sm text-code-sm text-on-tertiary-container">
                            <span class="material-symbols-outlined text-[14px]">trending_up</span>
                            <span>+8.4% vs 1h sliding window</span>
                        </div>
                    </div>
                    <!-- Card 3 -->
                    <div class="bg-surface-container-lowest p-space-md rounded-lg shadow-sm flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <span class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant">Fleet P95 Latency</span>
                            <span class="material-symbols-outlined text-on-tertiary-container text-[18px]">timer</span>
                        </div>
                        <div class="my-space-xs flex items-baseline gap-space-sm">
                            <span class="font-headline-xl text-headline-xl text-primary font-bold leading-none">18.2</span>
                            <span class="font-label-md text-label-md text-on-surface-variant">ms</span>
                        </div>
                        <div class="flex items-center justify-between font-code-sm text-code-sm">
                            <span class="text-on-surface-variant">Target: ≤ 45.0ms</span>
                            <span class="px-1.5 py-0.2 rounded bg-surface-container-high text-primary font-bold">COMPLIANT</span>
                        </div>
                    </div>
                    <!-- Card 4 -->
                    <div class="bg-surface-container-lowest p-space-md rounded-lg shadow-sm flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <span class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant">Global Ingress Error Rate</span>
                            <span class="material-symbols-outlined text-primary text-[18px]">verified</span>
                        </div>
                        <div class="my-space-xs flex items-baseline gap-space-sm">
                            <span class="font-headline-xl text-headline-xl text-primary font-bold leading-none">0.012%</span>
                            <span class="font-label-md text-label-md text-on-surface-variant">5xx err</span>
                        </div>
                        <div class="flex items-center justify-between font-code-sm text-code-sm text-on-surface-variant">
                            <span>HTTP 200: 99.988%</span>
                            <span class="text-primary font-semibold">MTTR &lt; 3.2s</span>
                        </div>
                    </div>
                </div>
                <!-- Main Layout Grid: Master Endpoints Table (Left 9 cols) + Detail Panel (Right 7 cols) -->
                <div class="grid grid-cols-1 2xl:grid-cols-16 gap-space-lg mb-space-lg">
                    <!-- Master Endpoints List (9 cols on 2xl) -->
                    <div class="2xl:col-span-9 flex flex-col gap-space-md">
                        <div class="bg-surface-container-lowest rounded-lg shadow-sm overflow-hidden flex flex-col">
                            <!-- Table Control Toolbar -->
                            <div class="p-space-md bg-surface-container-low flex flex-wrap items-center justify-between gap-space-sm">
                                <div class="flex items-center gap-space-sm">
                                    <span class="material-symbols-outlined text-primary text-[18px]">table_rows</span>
                                    <span class="font-headline-sm text-headline-sm text-primary">Live Endpoints Registry</span>
                                    <span class="font-code-sm text-code-sm px-1.5 py-0.5 rounded bg-surface-container-highest text-on-surface-variant">4 Active Routings</span>
                                </div>
                                <div class="flex items-center gap-space-sm">
                                    <div class="relative">
                                        <input class="h-8 pl-8 pr-3 text-body-sm bg-surface-container-lowest rounded text-on-surface outline-none w-48 focus:w-60 transition-all shadow-inner" placeholder="Filter route or pod ID..." type="text" />
                                        <span class="material-symbols-outlined absolute left-2 top-2 text-[16px] text-on-surface-variant">search</span>
                                    </div>
                                    <button class="h-8 px-2 bg-surface-container-lowest text-on-surface-variant hover:text-primary rounded shadow-sm">
                                        <span class="material-symbols-outlined text-[18px]">tune</span>
                                    </button>
                                </div>
                            </div>
                            <!-- Table Stream -->
                            <div class="overflow-x-auto">
                                <table class="w-full text-left font-body-sm text-body-sm">
                                    <thead>
                                        <tr class="bg-surface-container-high text-on-surface-variant font-label-sm text-label-sm uppercase tracking-wider">
                                            <th class="py-2.5 px-space-md">Endpoint ID / Route</th>
                                            <th class="py-2.5 px-space-md">Target Model &amp; Split</th>
                                            <th class="py-2.5 px-space-md">Replicas &amp; HW</th>
                                            <th class="py-2.5 px-space-md text-right">P95 Latency</th>
                                            <th class="py-2.5 px-space-md text-right">RPS</th>
                                            <th class="py-2.5 px-space-md text-center">Status</th>
                                            <th class="py-2.5 px-space-md text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-surface-container">
                                        <!-- Item 1: Focused Churn XGBoost with Canary Split -->
                                        <tr class="bg-secondary-fixed/30 hover:bg-secondary-fixed/50 transition-colors cursor-pointer">
                                            <td class="py-space-md px-space-md">
                                                <div class="flex flex-col">
                                                    <div class="flex items-center gap-1.5">
                                                        <span class="w-2 h-2 rounded-full bg-primary"></span>
                                                        <span class="font-code-md text-code-md font-semibold text-primary">vp-mod-churn-xgb-prod</span>
                                                    </div>
                                                    <span class="font-code-sm text-code-sm text-on-surface-variant truncate max-w-xs mt-0.5">/v1/predict/churn</span>
                                                </div>
                                            </td>
                                            <td class="py-space-md px-space-md">
                                                <div class="flex flex-col">
                                                    <span class="font-label-md text-label-md font-semibold text-on-surface">Customer Churn Prediction</span>
                                                    <div class="flex items-center gap-1 font-code-sm text-code-sm mt-0.5">
                                                        <span class="px-1 py-0.2 rounded bg-surface-container-highest text-primary font-bold">v2.4.0 (90%)</span>
                                                        <span class="text-on-surface-variant">•</span>
                                                        <span class="px-1 py-0.2 rounded bg-secondary-container text-on-secondary-container font-bold">v2.4.1 (10%)</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-space-md px-space-md font-code-sm text-code-sm">
                                                <div class="text-on-surface font-medium">6/6 Pods (AMD Milan)</div>
                                                <div class="text-on-surface-variant text-[10px]">4.0 GiB Mem • Autoscale 2-10</div>
                                            </td>
                                            <td class="py-space-md px-space-md text-right font-code-md text-code-md font-semibold text-primary">
                                                18.4 ms
                                            </td>
                                            <td class="py-space-md px-space-md text-right font-code-md text-code-md text-on-surface">
                                                482
                                            </td>
                                            <td class="py-space-md px-space-md text-center">
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded font-label-sm text-label-sm bg-primary-container text-on-primary">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-secondary-container animate-pulse"></span>
                                                    ACTIVE CANARY
                                                </span>
                                            </td>
                                            <td class="py-space-md px-space-md text-center">
                                                <button class="px-2 py-1 bg-primary text-on-primary rounded font-label-sm text-label-sm hover:bg-primary-container transition-colors shadow-sm" onclick="selectEndpoint('churn')">
                                                    Inspect
                                                </button>
                                            </td>
                                        </tr>
                                        <!-- Item 2: Defect YOLO -->
                                        <tr class="hover:bg-surface-container-low transition-colors">
                                            <td class="py-space-md px-space-md">
                                                <div class="flex flex-col">
                                                    <div class="flex items-center gap-1.5">
                                                        <span class="w-2 h-2 rounded-full bg-outline-variant"></span>
                                                        <span class="font-code-md text-code-md font-semibold text-on-surface">defect-yolo-seg-prod</span>
                                                    </div>
                                                    <span class="font-code-sm text-code-sm text-on-surface-variant truncate max-w-xs mt-0.5">/v1/cv/defect-segmentation</span>
                                                </div>
                                            </td>
                                            <td class="py-space-md px-space-md">
                                                <div class="flex flex-col">
                                                    <span class="font-label-md text-label-md font-semibold text-on-surface">Manufacturing Defect CV</span>
                                                    <span class="font-code-sm text-code-sm text-on-surface-variant mt-0.5">v1.8.0 (100% Production)</span>
                                                </div>
                                            </td>
                                            <td class="py-space-md px-space-md font-code-sm text-code-sm">
                                                <div class="text-on-surface font-medium">3/3 Pods (NVIDIA L4)</div>
                                                <div class="text-on-surface-variant text-[10px]">24.0 GiB VRAM • Fixed Replicas</div>
                                            </td>
                                            <td class="py-space-md px-space-md text-right font-code-md text-code-md text-on-surface">
                                                24.0 ms
                                            </td>
                                            <td class="py-space-md px-space-md text-right font-code-md text-code-md text-on-surface">
                                                310
                                            </td>
                                            <td class="py-space-md px-space-md text-center">
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded font-label-sm text-label-sm bg-surface-container-high text-primary font-bold">
                                                    HEALTHY
                                                </span>
                                            </td>
                                            <td class="py-space-md px-space-md text-center">
                                                <button class="px-2 py-1 bg-surface-container-high text-on-surface-variant hover:text-primary rounded font-label-sm text-label-sm transition-colors">
                                                    View
                                                </button>
                                            </td>
                                        </tr>
                                        <!-- Item 3: HR RAG Embeddings Staging -->
                                        <tr class="hover:bg-surface-container-low transition-colors">
                                            <td class="py-space-md px-space-md">
                                                <div class="flex flex-col">
                                                    <div class="flex items-center gap-1.5">
                                                        <span class="w-2 h-2 rounded-full bg-secondary-container"></span>
                                                        <span class="font-code-md text-code-md font-semibold text-on-surface">hr-rag-embed-staging</span>
                                                    </div>
                                                    <span class="font-code-sm text-code-sm text-on-surface-variant truncate max-w-xs mt-0.5">/v1/genai/rag/embeddings</span>
                                                </div>
                                            </td>
                                            <td class="py-space-md px-space-md">
                                                <div class="flex flex-col">
                                                    <span class="font-label-md text-label-md font-semibold text-on-surface">HR Knowledge Assistant</span>
                                                    <span class="font-code-sm text-code-sm text-secondary font-semibold mt-0.5">v2.1.0-rc2 (Staging Node)</span>
                                                </div>
                                            </td>
                                            <td class="py-space-md px-space-md font-code-sm text-code-sm">
                                                <div class="text-on-surface font-medium">1/1 Pod (CPU Standard)</div>
                                                <div class="text-on-surface-variant text-[10px]">8.0 GiB DDR4 • Dev Sandboxed</div>
                                            </td>
                                            <td class="py-space-md px-space-md text-right font-code-md text-code-md text-on-surface">
                                                42.1 ms
                                            </td>
                                            <td class="py-space-md px-space-md text-right font-code-md text-code-md text-on-surface">
                                                45
                                            </td>
                                            <td class="py-space-md px-space-md text-center">
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded font-label-sm text-label-sm bg-tertiary-fixed text-on-tertiary-fixed font-bold">
                                                    SANDBOX
                                                </span>
                                            </td>
                                            <td class="py-space-md px-space-md text-center">
                                                <button class="px-2 py-1 bg-surface-container-high text-on-surface-variant hover:text-primary rounded font-label-sm text-label-sm transition-colors">
                                                    View
                                                </button>
                                            </td>
                                        </tr>
                                        <!-- Item 4: Fraud IsoForest -->
                                        <tr class="hover:bg-surface-container-low transition-colors">
                                            <td class="py-space-md px-space-md">
                                                <div class="flex flex-col">
                                                    <div class="flex items-center gap-1.5">
                                                        <span class="w-2 h-2 rounded-full bg-outline-variant"></span>
                                                        <span class="font-code-md text-code-md font-semibold text-on-surface">fraud-isofor-prod</span>
                                                    </div>
                                                    <span class="font-code-sm text-code-sm text-on-surface-variant truncate max-w-xs mt-0.5">/v1/stream/fraud-score</span>
                                                </div>
                                            </td>
                                            <td class="py-space-md px-space-md">
                                                <div class="flex flex-col">
                                                    <span class="font-label-md text-label-md font-semibold text-on-surface">Realtime Fraud Detector</span>
                                                    <span class="font-code-sm text-code-sm text-on-surface-variant mt-0.5">v1.2.0 (100% Production)</span>
                                                </div>
                                            </td>
                                            <td class="py-space-md px-space-md font-code-sm text-code-sm">
                                                <div class="text-on-surface font-medium">4/4 Pods (AMD Milan)</div>
                                                <div class="text-on-surface-variant text-[10px]">2.0 GiB • Low-latency Tuned</div>
                                            </td>
                                            <td class="py-space-md px-space-md text-right font-code-md text-code-md text-on-surface">
                                                12.0 ms
                                            </td>
                                            <td class="py-space-md px-space-md text-right font-code-md text-code-md text-on-surface">
                                                580
                                            </td>
                                            <td class="py-space-md px-space-md text-center">
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded font-label-sm text-label-sm bg-surface-container-high text-primary font-bold">
                                                    HEALTHY
                                                </span>
                                            </td>
                                            <td class="py-space-md px-space-md text-center">
                                                <button class="px-2 py-1 bg-surface-container-high text-on-surface-variant hover:text-primary rounded font-label-sm text-label-sm transition-colors">
                                                    View
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- Node Fleet Map Visualization -->
                            <div class="p-space-md bg-surface-container-low flex flex-col gap-space-sm">
                                <div class="flex items-center justify-between">
                                    <span class="font-label-sm text-label-sm text-primary font-bold uppercase tracking-wider">Cluster Ingress Topology &amp; Envoy Routing Nodes</span>
                                    <span class="font-code-sm text-code-sm text-on-surface-variant">K8s v1.29 • Calico CNI OK</span>
                                </div>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-space-sm pt-1">
                                    <div class="p-2.5 rounded bg-surface-container-lowest shadow-sm flex flex-col gap-1">
                                        <div class="flex items-center justify-between">
                                            <span class="font-code-sm text-code-sm font-semibold text-primary">INGRESS-POD-01</span>
                                            <span class="w-2 h-2 rounded-full bg-secondary"></span>
                                        </div>
                                        <span class="font-code-sm text-code-sm text-on-surface-variant">IP: 10.244.1.84</span>
                                        <div class="w-full bg-surface-container-high h-1.5 rounded-full overflow-hidden mt-1">
                                            <div class="bg-primary h-full w-[42%]"></div>
                                        </div>
                                        <span class="font-label-sm text-label-sm text-on-surface-variant text-right">42% Load</span>
                                    </div>
                                    <div class="p-2.5 rounded bg-surface-container-lowest shadow-sm flex flex-col gap-1">
                                        <div class="flex items-center justify-between">
                                            <span class="font-code-sm text-code-sm font-semibold text-primary">INGRESS-POD-02</span>
                                            <span class="w-2 h-2 rounded-full bg-secondary"></span>
                                        </div>
                                        <span class="font-code-sm text-code-sm text-on-surface-variant">IP: 10.244.2.19</span>
                                        <div class="w-full bg-surface-container-high h-1.5 rounded-full overflow-hidden mt-1">
                                            <div class="bg-primary h-full w-[38%]"></div>
                                        </div>
                                        <span class="font-label-sm text-label-sm text-on-surface-variant text-right">38% Load</span>
                                    </div>
                                    <div class="p-2.5 rounded bg-surface-container-lowest shadow-sm flex flex-col gap-1">
                                        <div class="flex items-center justify-between">
                                            <span class="font-code-sm text-code-sm font-semibold text-primary">INGRESS-POD-03</span>
                                            <span class="w-2 h-2 rounded-full bg-secondary"></span>
                                        </div>
                                        <span class="font-code-sm text-code-sm text-on-surface-variant">IP: 10.244.3.44</span>
                                        <div class="w-full bg-surface-container-high h-1.5 rounded-full overflow-hidden mt-1">
                                            <div class="bg-primary h-full w-[49%]"></div>
                                        </div>
                                        <span class="font-label-sm text-label-sm text-on-surface-variant text-right">49% Load</span>
                                    </div>
                                    <div class="p-2.5 rounded bg-surface-container-lowest shadow-sm flex flex-col gap-1">
                                        <div class="flex items-center justify-between">
                                            <span class="font-code-sm text-code-sm font-semibold text-primary">ENVOY-EDGE-GW</span>
                                            <span class="w-2 h-2 rounded-full bg-on-tertiary-container"></span>
                                        </div>
                                        <span class="font-code-sm text-code-sm text-on-surface-variant">mTLS cert valid: 88d</span>
                                        <div class="w-full bg-surface-container-high h-1.5 rounded-full overflow-hidden mt-1">
                                            <div class="bg-on-tertiary-container h-full w-[22%]"></div>
                                        </div>
                                        <span class="font-label-sm text-label-sm text-on-surface-variant text-right">22% Buffer</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Cross-Link Telemetry Forwarding Banner (SYS-AI-05 Integration) -->
                        <div class="p-space-md rounded-lg bg-surface-container-lowest shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-space-md">
                            <div class="flex items-center gap-space-md">
                                <div class="w-10 h-10 rounded-full bg-secondary-fixed flex items-center justify-center shrink-0">
                                    <span class="material-symbols-outlined text-primary text-[22px]">radar</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-headline-sm text-headline-sm text-primary">Autonomous Telemetry Pipeline → SYS-AI-05</span>
                                    <span class="font-body-sm text-body-sm text-on-surface-variant">
                                        Forwarding real-time distribution drift, inference feature bounds, and P99 latency alerts to AI SOC &amp; Monitoring Suite.
                                    </span>
                                </div>
                            </div>
                            <a class="h-8 px-space-md bg-secondary-fixed text-on-secondary-fixed hover:bg-secondary-fixed-dim rounded font-label-md text-label-md flex items-center gap-1.5 transition-colors self-start sm:self-auto shrink-0 shadow-sm" href="#">
                                <span>Open AI SOC Stream</span>
                                <span class="material-symbols-outlined text-[16px]">open_in_new</span>
                            </a>
                        </div>
                    </div>
                    <!-- Right Detailed Endpoint Inspection Panel (7 cols on 2xl) -->
                    <div class="2xl:col-span-7 flex flex-col gap-space-md">
                        <div class="bg-surface-container-lowest rounded-lg shadow-sm overflow-hidden flex flex-col">
                            <!-- Inspection Header -->
                            <div class="p-space-md bg-surface-container-high flex flex-wrap items-center justify-between gap-space-sm">
                                <div class="flex items-center gap-space-sm">
                                    <span class="material-symbols-outlined text-primary text-[22px]">cell_tower</span>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <h2 class="font-headline-sm text-headline-sm text-primary">vp-mod-churn-xgb-prod</h2>
                                            <span class="font-code-sm text-code-sm px-1.5 py-0.2 rounded bg-surface-container-lowest text-primary font-bold">POD #04</span>
                                        </div>
                                        <span class="font-code-sm text-code-sm text-on-surface-variant">https://gateway.vostokpribor.internal/v1/predict/churn</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-1">
                                    <button class="p-1.5 bg-surface-container-lowest rounded text-on-surface-variant hover:text-primary transition-colors shadow-sm" onclick="copyRouteUrl()" title="Copy Gateway URL">
                                        <span class="material-symbols-outlined text-[16px]">content_copy</span>
                                    </button>
                                    <button class="p-1.5 bg-surface-container-lowest text-error rounded hover:bg-error-container transition-colors shadow-sm" onclick="triggerEmergencyDrain()" title="Circuit Breaker / Emergency Stop">
                                        <span class="material-symbols-outlined text-[16px]">power_settings_new</span>
                                    </button>
                                </div>
                            </div>
                            <div class="p-space-lg flex flex-col gap-space-lg">
                                <!-- Real-Time Traffic Split Visualization & Slider -->
                                <div class="bg-surface-container-low p-space-md rounded-lg flex flex-col gap-space-sm">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <span class="material-symbols-outlined text-primary text-[18px]">call_split</span>
                                            <span class="font-headline-sm text-headline-sm text-primary">Canary Traffic Weighting</span>
                                        </div>
                                        <span class="font-code-sm text-code-sm px-2 py-0.5 rounded bg-primary-container text-on-primary font-bold">STATE: 90 / 10 CANARY</span>
                                    </div>
                                    <!-- Dual Bar Progress Indicator -->
                                    <div class="w-full flex h-6 rounded-md overflow-hidden font-code-sm text-code-sm font-bold text-center">
                                        <div class="bg-primary text-on-primary flex items-center justify-center transition-all duration-300" id="primarySplitBar" style="width: 90%;">
                                            90% Stable (v2.4.0)
                                        </div>
                                        <div class="bg-secondary-container text-on-secondary-container flex items-center justify-center transition-all duration-300" id="canarySplitBar" style="width: 10%;">
                                            10% Canary (v2.4.1)
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-space-md pt-1">
                                        <div class="flex flex-col">
                                            <span class="font-label-sm text-label-sm text-on-surface-variant uppercase">Base Model Deployment</span>
                                            <span class="font-code-sm text-code-sm font-semibold text-primary">vp-mod-churn-xgb:v2.4.0</span>
                                            <span class="font-body-sm text-body-sm text-on-surface-variant text-[11px]">Deployed: 12 days ago • SHA: 8a7f1e9</span>
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="font-label-sm text-label-sm text-secondary font-bold uppercase">Canary Candidate (Ticket VP-TKT-1082)</span>
                                            <span class="font-code-sm text-code-sm font-semibold text-primary">vp-mod-churn-xgb:v2.4.1</span>
                                            <span class="font-body-sm text-body-sm text-on-surface-variant text-[11px]">Evaluated: Today 08:14 UTC • AUC 0.941</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between pt-2">
                                        <div class="flex items-center gap-2">
                                            <input class="w-44 accent-primary" id="trafficSlider" max="50" min="0" oninput="updateTrafficPreview(this.value)" step="5" type="range" value="10" />
                                            <span class="font-code-sm text-code-sm text-primary font-bold" id="sliderValueLabel">10% Candidate</span>
                                        </div>
                                        <button class="h-7 px-space-md bg-primary text-on-primary rounded font-label-sm text-label-sm hover:bg-primary-container transition-colors shadow-sm" onclick="commitTrafficShift()">
                                            Apply Traffic Change
                                        </button>
                                    </div>
                                </div>
                                <!-- Latency Distribution & Health Probes -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-space-md">
                                    <!-- Percentile Latency Metrics -->
                                    <div class="bg-surface-container-low p-space-md rounded-lg flex flex-col justify-between">
                                        <div class="flex items-center justify-between mb-space-xs">
                                            <span class="font-label-sm text-label-sm text-primary uppercase font-bold">Latency Percentiles</span>
                                            <span class="font-code-sm text-code-sm text-on-surface-variant">Last 15m</span>
                                        </div>
                                        <div class="space-y-1 font-code-sm text-code-sm">
                                            <div class="flex justify-between items-center py-0.5">
                                                <span class="text-on-surface-variant">P50 (Median):</span>
                                                <span class="font-bold text-on-surface">12.1 ms</span>
                                            </div>
                                            <div class="flex justify-between items-center py-0.5">
                                                <span class="text-on-surface-variant">P90 Percentile:</span>
                                                <span class="font-bold text-on-surface">16.5 ms</span>
                                            </div>
                                            <div class="flex justify-between items-center py-0.5">
                                                <span class="text-on-surface-variant">P95 SLA Bound:</span>
                                                <span class="font-bold text-primary">18.4 ms</span>
                                            </div>
                                            <div class="flex justify-between items-center py-0.5">
                                                <span class="text-on-surface-variant">P99 Tail:</span>
                                                <span class="font-bold text-secondary">28.1 ms</span>
                                            </div>
                                        </div>
                                        <!-- Inline SVG Latency Sparkline -->
                                        <div class="mt-2 pt-2">
                                            <div class="text-[10px] font-label-sm text-on-surface-variant mb-1">Inference Latency Trace (ms)</div>
                                            <svg class="w-full h-9 text-primary overflow-visible" fill="none" viewbox="0 0 200 36">
                                                <path d="M 0,28 L 20,24 L 40,29 L 60,18 L 80,22 L 100,14 L 120,20 L 140,17 L 160,11 L 180,18 L 200,15" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                                <path d="M 0,28 L 20,24 L 40,29 L 60,18 L 80,22 L 100,14 L 120,20 L 140,17 L 160,11 L 180,18 L 200,15 L 200,36 L 0,36 Z" fill="currentColor" fill-opacity="0.08"></path>
                                                <circle cx="160" cy="11" fill="currentColor" r="2.5"></circle>
                                            </svg>
                                        </div>
                                    </div>
                                    <!-- Health Probes & Security Guard -->
                                    <div class="bg-surface-container-low p-space-md rounded-lg flex flex-col justify-between">
                                        <div class="flex items-center justify-between mb-space-xs">
                                            <span class="font-label-sm text-label-sm text-primary uppercase font-bold">K8s Runtime Probes</span>
                                            <span class="w-2 h-2 rounded-full bg-secondary"></span>
                                        </div>
                                        <div class="space-y-2 font-code-sm text-code-sm">
                                            <div class="flex items-center justify-between">
                                                <span class="text-on-surface-variant">Liveness Probe:</span>
                                                <span class="px-1.5 py-0.2 rounded bg-surface-container-highest text-primary font-semibold">GET /healthz 200 OK</span>
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <span class="text-on-surface-variant">Readiness Probe:</span>
                                                <span class="px-1.5 py-0.2 rounded bg-surface-container-highest text-primary font-semibold">GET /readyz 200 OK</span>
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <span class="text-on-surface-variant">Payload Schema:</span>
                                                <span class="px-1.5 py-0.2 rounded bg-secondary-fixed text-on-secondary-fixed font-semibold">JSONSchema v7 Guard</span>
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <span class="text-on-surface-variant">Auth Gateway:</span>
                                                <span class="px-1.5 py-0.2 rounded bg-tertiary-fixed text-on-tertiary-fixed font-semibold">OIDC SPIFFE / Spire</span>
                                            </div>
                                        </div>
                                        <div class="mt-2 text-right">
                                            <span class="font-code-sm text-code-sm text-on-surface-variant">Uptime: 99.982% (30d)</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- Recent Live Test Requests Stream -->
                                <div class="flex flex-col gap-space-xs">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-1.5">
                                            <span class="material-symbols-outlined text-primary text-[18px]">terminal</span>
                                            <span class="font-headline-sm text-headline-sm text-primary">Inference Telemetry Stream (Last 5 Requests)</span>
                                        </div>
                                        <button class="text-primary hover:text-on-primary-container font-label-sm text-label-sm flex items-center gap-1" onclick="refreshInferenceLog()">
                                            <span class="material-symbols-outlined text-[14px]">refresh</span>
                                            <span>Poll Live</span>
                                        </button>
                                    </div>
                                    <div class="bg-surface-container-low rounded-lg overflow-hidden">
                                        <div class="overflow-x-auto">
                                            <table class="w-full text-left font-code-sm text-code-sm">
                                                <thead class="bg-surface-container-high text-on-surface-variant font-label-sm text-label-sm uppercase">
                                                    <tr>
                                                        <th class="py-1.5 px-3">Req ID</th>
                                                        <th class="py-1.5 px-3">Timestamp</th>
                                                        <th class="py-1.5 px-3">Target Node</th>
                                                        <th class="py-1.5 px-3">Latency</th>
                                                        <th class="py-1.5 px-3">Prediction</th>
                                                        <th class="py-1.5 px-3 text-right">HTTP</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y divide-surface-container" id="inferenceStreamRows">
                                                    <tr class="hover:bg-surface-container-highest/60 transition-colors">
                                                        <td class="py-2 px-3 font-semibold text-primary">req_8019a1</td>
                                                        <td class="py-2 px-3 text-on-surface-variant">14:22:08.412</td>
                                                        <td class="py-2 px-3 text-on-surface"><span class="px-1 rounded bg-secondary-container text-on-secondary-container font-bold text-[10px]">v2.4.1</span></td>
                                                        <td class="py-2 px-3 text-primary font-bold">14.2 ms</td>
                                                        <td class="py-2 px-3 text-on-surface">churn=0 (0.892 conf)</td>
                                                        <td class="py-2 px-3 text-right text-primary font-bold">200 OK</td>
                                                    </tr>
                                                    <tr class="hover:bg-surface-container-highest/60 transition-colors">
                                                        <td class="py-2 px-3 font-semibold text-primary">req_8019a0</td>
                                                        <td class="py-2 px-3 text-on-surface-variant">14:22:07.981</td>
                                                        <td class="py-2 px-3 text-on-surface"><span class="px-1 rounded bg-surface-container-highest text-primary font-bold text-[10px]">v2.4.0</span></td>
                                                        <td class="py-2 px-3 text-primary font-bold">17.8 ms</td>
                                                        <td class="py-2 px-3 text-on-surface">churn=1 (0.641 conf)</td>
                                                        <td class="py-2 px-3 text-right text-primary font-bold">200 OK</td>
                                                    </tr>
                                                    <tr class="hover:bg-surface-container-highest/60 transition-colors">
                                                        <td class="py-2 px-3 font-semibold text-primary">req_80199f</td>
                                                        <td class="py-2 px-3 text-on-surface-variant">14:22:07.129</td>
                                                        <td class="py-2 px-3 text-on-surface"><span class="px-1 rounded bg-surface-container-highest text-primary font-bold text-[10px]">v2.4.0</span></td>
                                                        <td class="py-2 px-3 text-primary font-bold">16.1 ms</td>
                                                        <td class="py-2 px-3 text-on-surface">churn=0 (0.912 conf)</td>
                                                        <td class="py-2 px-3 text-right text-primary font-bold">200 OK</td>
                                                    </tr>
                                                    <tr class="hover:bg-surface-container-highest/60 transition-colors">
                                                        <td class="py-2 px-3 font-semibold text-primary">req_80199e</td>
                                                        <td class="py-2 px-3 text-on-surface-variant">14:22:06.840</td>
                                                        <td class="py-2 px-3 text-on-surface"><span class="px-1 rounded bg-secondary-container text-on-secondary-container font-bold text-[10px]">v2.4.1</span></td>
                                                        <td class="py-2 px-3 text-primary font-bold">15.0 ms</td>
                                                        <td class="py-2 px-3 text-on-surface">churn=0 (0.781 conf)</td>
                                                        <td class="py-2 px-3 text-right text-primary font-bold">200 OK</td>
                                                    </tr>
                                                    <tr class="hover:bg-surface-container-highest/60 transition-colors">
                                                        <td class="py-2 px-3 font-semibold text-primary">req_80199d</td>
                                                        <td class="py-2 px-3 text-on-surface-variant">14:22:06.012</td>
                                                        <td class="py-2 px-3 text-on-surface"><span class="px-1 rounded bg-surface-container-highest text-primary font-bold text-[10px]">v2.4.0</span></td>
                                                        <td class="py-2 px-3 text-primary font-bold">19.2 ms</td>
                                                        <td class="py-2 px-3 text-on-surface">churn=1 (0.830 conf)</td>
                                                        <td class="py-2 px-3 text-right text-primary font-bold">200 OK</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- Controlled Rollback Safety Trigger Section -->
                                <div class="p-space-md rounded-lg bg-surface-container-low flex flex-col sm:flex-row sm:items-center justify-between gap-space-md">
                                    <div class="flex items-start gap-space-sm">
                                        <span class="material-symbols-outlined text-secondary text-[22px] shrink-0">history_toggle_off</span>
                                        <div class="flex flex-col">
                                            <span class="font-headline-sm text-headline-sm text-primary">Automated Circuit Rollback</span>
                                            <span class="font-body-sm text-body-sm text-on-surface-variant">
                                                Target reversion: <strong class="text-on-surface">vp-mod-churn-xgb:v2.4.0</strong> (Canary drain instant cutback &lt; 800ms)
                                            </span>
                                        </div>
                                    </div>
                                    <button class="h-8 px-space-lg bg-primary-container text-on-primary hover:bg-primary transition-colors rounded font-label-md text-label-md font-semibold flex items-center gap-1.5 shadow-sm shrink-0" onclick="promptRollbackConfirmation()">
                                        <span class="material-symbols-outlined text-[16px]">undo</span>
                                        <span>Rollback to v2.4.0</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Safety Rollback Confirmation Modal (Hidden by Default) -->
                <div class="fixed inset-0 z-50 bg-inverse-surface/40 backdrop-blur-sm hidden items-center justify-center p-space-md" id="rollbackModal">
                    <div class="bg-surface-container-lowest max-w-lg w-full rounded-xl shadow-xl overflow-hidden flex flex-col animate-in fade-in zoom-in duration-150">
                        <div class="p-space-md bg-surface-container-high flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary text-[20px]">warning</span>
                                <span class="font-headline-sm text-headline-sm text-primary">Confirm Safe Rollback Execution</span>
                            </div>
                            <button class="text-on-surface-variant hover:text-on-surface" onclick="closeRollbackModal()">
                                <span class="material-symbols-outlined text-[20px]">close</span>
                            </button>
                        </div>
                        <div class="p-space-lg flex flex-col gap-space-md">
                            <p class="font-body-md text-body-md text-on-surface">
                                You are triggering an immediate canary revocation for <code class="font-code-sm text-code-sm bg-surface-container-high px-1.5 py-0.5 rounded text-primary">vp-mod-churn-xgb-prod</code>.
                            </p>
                            <div class="p-space-md rounded bg-surface-container-low font-code-sm text-code-sm space-y-1">
                                <div class="flex justify-between">
                                    <span class="text-on-surface-variant">Active Canary Candidate:</span>
                                    <span class="text-secondary font-bold">v2.4.1 (10% Traffic)</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-on-surface-variant">Rollback Action:</span>
                                    <span class="text-primary font-bold">Drain candidate → 100% v2.4.0</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-on-surface-variant">Ingress Cutover Latency:</span>
                                    <span>&lt; 650 ms (Zero request drop)</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <input class="rounded accent-primary" id="drainDrainCheck" type="checkbox" />
                                <label class="font-body-sm text-body-sm text-on-surface-variant select-none" for="drainDrainCheck">
                                    Notify ticket <strong class="text-on-surface">VP-TKT-1082</strong> and tag deployment as superseded
                                </label>
                            </div>
                            <div class="flex items-center justify-end gap-space-sm pt-space-xs">
                                <button class="h-8 px-space-md bg-surface-container-high text-on-surface hover:bg-surface-container-highest rounded font-label-md text-label-md" onclick="closeRollbackModal()">
                                    Cancel
                                </button>
                                <button class="h-8 px-space-lg bg-primary text-on-primary hover:bg-primary-container rounded font-label-md text-label-md font-semibold flex items-center gap-1.5 shadow-sm" onclick="executeRollback()">
                                    <span class="material-symbols-outlined text-[16px]">check_circle</span>
                                    <span>Execute Immediate Cutback</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Notification Toast Container -->
                <div class="fixed bottom-6 right-6 z-50 transform translate-y-24 opacity-0 transition-all duration-200 pointer-events-none" id="toastNotification">
                    <div class="bg-primary text-on-primary px-space-md py-space-sm rounded-lg shadow-lg flex items-center gap-2 font-label-md text-label-md">
                        <span class="material-symbols-outlined text-[18px]">verified</span>
                        <span id="toastMessage">Traffic shift applied successfully.</span>
                    </div>
                </div>
        </main>
    </div>
    <script src="js/main.js"></script>
</body>

</html>