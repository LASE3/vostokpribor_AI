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
                <div class="hidden 2xl:flex flex-col text-left"><span class="font-label-md text-label-md font-semibold text-on-surface leading-none">Cadet E. Vance</span><span class="font-code-sm text-code-sm text-on-surface-variant leading-none mt-0.5">VP-8820</span></div>
            </div>
        </div>
    </header>
    <aside class="fixed left-0 top-16 bottom-0 w-72 bg-surface-container-low/95 backdrop-blur-md z-40 flex flex-col justify-between shadow-[1px_0_12px_rgba(76,29,149,0.04)]">
        <div class="flex flex-col">
            <div class="px-space-lg py-space-md flex items-center justify-between">
                <div class="flex items-center gap-space-sm"><span class="material-symbols-outlined text-primary text-[20px]">deployed_code</span><span class="font-headline-sm text-headline-sm text-primary tracking-tight">MLOps Hub</span></div><span class="font-code-sm text-code-sm px-1.5 py-0.5 bg-surface-container-high rounded text-on-surface-variant">REV 4.2</span>
            </div>
            <nav class="flex flex-col gap-1 px-space-md py-space-sm" data-active-classes="bg-primary-container text-on-primary font-bold rounded-lg shadow-sm"><a class="flex items-center gap-space-md px-space-md py-2.5 rounded-lg text-on-surface-variant font-label-md text-label-md hover:bg-surface-container-high hover:text-on-surface transition-colors" data-path="dashboard" href="dashboard.php"><span class="material-symbols-outlined text-[20px]">dashboard</span><span>Dashboard</span></a><a aria-current="page" class="flex items-center gap-space-md px-space-md py-2.5 transition-colors bg-primary-container text-on-primary font-bold rounded-lg shadow-sm" data-path="model-registry" href="ModelRegistry.php"><span class="material-symbols-outlined text-[20px]">inventory_2</span><span>Model Registry</span></a><a class="flex items-center gap-space-md px-space-md py-2.5 rounded-lg text-on-surface-variant font-label-md text-label-md hover:bg-surface-container-high hover:text-on-surface transition-colors" data-path="automated-validation-pipeline" href="ValidationPipeline.php"><span class="material-symbols-outlined text-[20px]">fact_check</span><span>Validation Pipeline</span></a><a class="flex items-center gap-space-md px-space-md py-2.5 rounded-lg text-on-surface-variant font-label-md text-label-md hover:bg-surface-container-high hover:text-on-surface transition-colors" data-path="deployment-configuration" href="DeploymentConfig.php"><span class="material-symbols-outlined text-[20px]">settings_input_component</span><span>Deployment Config</span></a><a class="flex items-center gap-space-md px-space-md py-2.5 rounded-lg text-on-surface-variant font-label-md text-label-md hover:bg-surface-container-high hover:text-on-surface transition-colors" data-path="deployed-endpoints" href="DeployedEndpoints.php"><span class="material-symbols-outlined text-[20px]">cell_tower</span><span>Deployed Endpoints</span></a><a class="flex items-center gap-space-md px-space-md py-2.5 rounded-lg text-on-surface-variant font-label-md text-label-md hover:bg-surface-container-high hover:text-on-surface transition-colors" data-path="validation-reports" href="ValidationReports.php"><span class="material-symbols-outlined text-[20px]">description</span><span>Validation Reports</span></a></nav>
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
                <!-- Top Command and Metadata Strip -->
                <div class="flex flex-col gap-space-sm mb-space-md">
                    <div class="flex flex-wrap items-center justify-between gap-space-sm bg-surface-container-lowest/90 backdrop-blur-sm p-space-md rounded-xl shadow-sm">
                        <div class="flex flex-col">
                            <div class="flex items-center gap-space-sm">
                                <span class="font-label-sm text-label-sm uppercase tracking-wider text-primary font-bold">Catalog Index SYS-AI-04</span>
                                <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
                                <span class="font-code-sm text-code-sm text-on-surface-variant">NODE CLUSTER: ORBIT-EU-CENTRAL-01</span>
                                <span class="px-1.5 py-0.5 rounded bg-tertiary-fixed text-on-tertiary-fixed font-code-sm text-code-sm">SYNCHRONIZED</span>
                            </div>
                            <h1 class="font-headline-lg text-headline-lg text-primary tracking-tight mt-0.5">Model Registry Catalog</h1>
                            <p class="font-body-sm text-body-sm text-on-surface-variant">Searchable repository of trained machine learning models, weights, schemas, and verification artifacts.</p>
                        </div>
                        <div class="flex items-center gap-space-sm">
                            <button class="flex items-center gap-1.5 px-space-md py-1.5 rounded-lg bg-surface-container-low text-primary hover:bg-secondary-fixed/50 font-label-md text-label-md transition-colors shadow-sm" id="toggleDiffDrawerBtn">
                                <span class="material-symbols-outlined text-[18px]">compare_arrows</span>
                                <span>Compare Versions (2)</span>
                                <span class="ml-1 px-1 rounded bg-primary-container text-on-primary font-code-sm text-code-sm">v2.4.1 vs v2.4.0</span>
                            </button>
                            <button class="flex items-center gap-1 px-space-md py-1.5 rounded-lg bg-primary-container text-on-primary font-label-md text-label-md hover:bg-primary transition-colors shadow-sm">
                                <span class="material-symbols-outlined text-[18px]">cloud_upload</span>
                                <span>Register Candidate</span>
                            </button>
                        </div>
                    </div>
                    <!-- Global Query & Multi-axis Filters -->
                    <div class="flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-space-sm bg-surface-container-lowest/80 p-space-sm rounded-xl shadow-sm">
                        <div class="flex flex-1 items-center gap-space-sm bg-surface-container-low px-space-sm py-1.5 rounded-lg">
                            <span class="material-symbols-outlined text-outline text-[18px]">search</span>
                            <input class="w-full bg-transparent text-on-surface placeholder:text-outline font-body-sm text-body-sm focus:outline-none" placeholder="Filter by model name, student ID, hash (e.g. SHA256:7c9e12)..." type="text" value="vp-mod-churn-xgb" />
                            <span class="font-code-sm text-code-sm text-on-surface-variant px-1 rounded bg-surface-container-high">ESC to reset</span>
                        </div>
                        <div class="flex flex-wrap items-center gap-space-xs">
                            <div class="flex items-center gap-1 bg-surface-container-low px-space-sm py-1 rounded-lg">
                                <span class="font-label-sm text-label-sm text-on-surface-variant">BLUEPRINT:</span>
                                <select class="bg-transparent font-label-md text-label-md text-primary font-medium focus:outline-none cursor-pointer">
                                    <option>Customer Churn Prediction (14)</option>
                                    <option>Telemetry Anomaly Detection (8)</option>
                                    <option>Thruster Degradation Prognostics (12)</option>
                                    <option>All 7 Blueprints (48)</option>
                                </select>
                            </div>
                            <div class="flex items-center gap-1 bg-surface-container-low px-space-sm py-1 rounded-lg">
                                <span class="font-label-sm text-label-sm text-on-surface-variant">FRAMEWORK:</span>
                                <select class="bg-transparent font-label-md text-label-md text-primary font-medium focus:outline-none cursor-pointer">
                                    <option>All Frameworks</option>
                                    <option selected="">XGBoost (21)</option>
                                    <option>PyTorch (14)</option>
                                    <option>Scikit-Learn (9)</option>
                                    <option>HuggingFace (4)</option>
                                </select>
                            </div>
                            <div class="flex items-center gap-1 bg-surface-container-high/60 p-0.5 rounded-lg">
                                <button class="px-2 py-1 rounded font-label-sm text-label-sm bg-surface-container-lowest text-primary shadow-xs font-semibold">ALL (48)</button>
                                <button class="px-2 py-1 rounded font-label-sm text-label-sm text-on-surface-variant hover:text-primary transition-colors">PASSED (29)</button>
                                <button class="px-2 py-1 rounded font-label-sm text-label-sm text-on-surface-variant hover:text-primary transition-colors">WARNINGS (7)</button>
                                <button class="px-2 py-1 rounded font-label-sm text-label-sm text-on-surface-variant hover:text-primary transition-colors">FAILED (12)</button>
                            </div>
                        </div>
                    </div>
                    <!-- Active Facets Ribbon -->
                    <div class="flex flex-wrap items-center justify-between gap-space-sm px-space-sm py-1 bg-surface-container/60 rounded-lg">
                        <div class="flex flex-wrap items-center gap-space-xs">
                            <span class="font-label-sm text-label-sm text-on-surface-variant uppercase font-bold">Applied Constraints:</span>
                            <div class="flex items-center gap-1 bg-primary-fixed text-on-primary-fixed-variant px-2 py-0.5 rounded-full font-code-sm text-code-sm font-medium">
                                <span>Scenario: Churn Prediction</span>
                                <span class="material-symbols-outlined text-[14px] cursor-pointer">close</span>
                            </div>
                            <div class="flex items-center gap-1 bg-secondary-fixed text-on-secondary-fixed-variant px-2 py-0.5 rounded-full font-code-sm text-code-sm font-medium">
                                <span>Cadet: E. Vance (VP-8820)</span>
                                <span class="material-symbols-outlined text-[14px] cursor-pointer">close</span>
                            </div>
                            <div class="flex items-center gap-1 bg-tertiary-fixed text-on-tertiary-fixed-variant px-2 py-0.5 rounded-full font-code-sm text-code-sm font-medium">
                                <span>Ticket: VP-TKT-1082</span>
                                <span class="material-symbols-outlined text-[14px] cursor-pointer">close</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-space-sm">
                            <span class="font-label-sm text-label-sm text-on-surface-variant uppercase">Sorting:</span>
                            <button class="flex items-center gap-1 font-label-md text-label-md text-primary font-semibold hover:underline">
                                <span>Last Evaluated (Desc)</span>
                                <span class="material-symbols-outlined text-[16px]">arrow_downward</span>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Main Technical Data Grid -->
                <div class="w-full bg-surface-container-lowest rounded-xl shadow-sm overflow-hidden flex flex-col mb-space-lg">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-surface-container-high/60 text-on-surface-variant font-label-sm text-label-sm uppercase tracking-wider">
                                    <th class="py-2.5 px-3">
                                        <input checked="" class="rounded accent-primary" type="checkbox" />
                                    </th>
                                    <th class="py-2.5 px-3">Model Alias &amp; Hash</th>
                                    <th class="py-2.5 px-3">SemVer &amp; Tag</th>
                                    <th class="py-2.5 px-3">Owner / Student</th>
                                    <th class="py-2.5 px-3">Ticket / Run Link</th>
                                    <th class="py-2.5 px-3">Training Parquet</th>
                                    <th class="py-2.5 px-3">Framework Runtime</th>
                                    <th class="py-2.5 px-3 text-right">Key Metrics</th>
                                    <th class="py-2.5 px-3 text-center">Gates</th>
                                    <th class="py-2.5 px-3">Approval Gate</th>
                                    <th class="py-2.5 px-3">Deployment</th>
                                    <th class="py-2.5 px-3 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y-0 text-on-surface font-body-sm text-body-sm">
                                <!-- Row 1: v2.4.1 (Latest / Passing / Production Candidate) -->
                                <tr class="bg-secondary-fixed/20 hover:bg-secondary-fixed/40 transition-colors">
                                    <td class="py-2.5 px-3 align-top">
                                        <input checked="" class="rounded accent-primary" type="checkbox" />
                                    </td>
                                    <td class="py-2.5 px-3 align-top">
                                        <div class="flex flex-col">
                                            <span class="font-headline-sm text-headline-sm text-primary leading-tight font-semibold">vp-mod-churn-xgb</span>
                                            <div class="flex items-center gap-1 text-on-surface-variant font-code-sm text-code-sm mt-0.5">
                                                <span class="material-symbols-outlined text-[12px] text-secondary">fingerprint</span>
                                                <span>SHA:a8f3b29c...</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-2.5 px-3 align-top">
                                        <div class="flex flex-col items-start gap-1">
                                            <span class="font-code-sm text-code-sm font-bold text-primary bg-primary-fixed px-1.5 py-0.5 rounded">v2.4.1</span>
                                            <span class="font-label-sm text-label-sm px-1.5 py-0.5 rounded bg-tertiary-fixed text-on-tertiary-fixed font-bold">LATEST</span>
                                        </div>
                                    </td>
                                    <td class="py-2.5 px-3 align-top">
                                        <div class="flex flex-col">
                                            <span class="font-label-md text-label-md font-semibold text-on-surface">Cadet E. Vance</span>
                                            <span class="font-code-sm text-code-sm text-on-surface-variant">VP-8820 (Flight D)</span>
                                        </div>
                                    </td>
                                    <td class="py-2.5 px-3 align-top">
                                        <div class="flex flex-col gap-0.5">
                                            <a class="font-code-sm text-code-sm text-primary font-semibold hover:underline flex items-center gap-0.5" href="#">
                                                <span class="material-symbols-outlined text-[12px]">link</span>VP-TKT-1082
                                            </a>
                                            <a class="font-code-sm text-code-sm text-secondary hover:underline flex items-center gap-0.5" href="#">
                                                <span class="material-symbols-outlined text-[12px]">code</span>EXP-884-R3
                                            </a>
                                        </div>
                                    </td>
                                    <td class="py-2.5 px-3 align-top">
                                        <div class="flex flex-col">
                                            <span class="font-code-sm text-code-sm text-on-surface truncate max-w-[130px]">churn_train_v2.parquet</span>
                                            <span class="font-code-sm text-code-sm text-on-surface-variant">Rows: 1.2M • 7c9e12</span>
                                        </div>
                                    </td>
                                    <td class="py-2.5 px-3 align-top">
                                        <div class="flex flex-col">
                                            <span class="font-code-sm text-code-sm font-medium text-on-surface">XGBoost 1.7.5</span>
                                            <span class="font-code-sm text-code-sm text-on-surface-variant">Py3.10 • CUDA 12.1</span>
                                        </div>
                                    </td>
                                    <td class="py-2.5 px-3 align-top text-right">
                                        <div class="flex flex-col items-end gap-0.5">
                                            <div class="flex items-center gap-1 font-code-sm text-code-sm">
                                                <span class="text-on-surface-variant">ROC-AUC:</span>
                                                <span class="font-bold text-primary">0.884</span>
                                            </div>
                                            <div class="flex items-center gap-1 font-code-sm text-code-sm text-on-surface-variant">
                                                <span>F1:</span>
                                                <span class="font-medium text-on-surface">0.821</span>
                                                <span>• P95:</span>
                                                <span class="font-medium text-on-surface">22ms</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-2.5 px-3 align-top text-center">
                                        <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded bg-surface-container-high text-primary font-code-sm text-code-sm font-semibold">
                                            <span class="material-symbols-outlined text-[14px] text-primary">verified</span>
                                            <span>10/10 PASS</span>
                                        </span>
                                    </td>
                                    <td class="py-2.5 px-3 align-top">
                                        <div class="flex flex-col">
                                            <span class="font-label-sm text-label-sm px-1.5 py-0.5 rounded bg-tertiary-fixed text-on-tertiary-fixed-variant font-semibold inline-block text-center">INSTRUCTOR APPROVED</span>
                                            <span class="font-code-sm text-code-sm text-on-surface-variant mt-0.5">Dr. K. Petrov (09:14Z)</span>
                                        </div>
                                    </td>
                                    <td class="py-2.5 px-3 align-top">
                                        <div class="flex items-center gap-1.5">
                                            <span class="w-2 h-2 rounded-full bg-secondary animate-pulse"></span>
                                            <span class="font-label-md text-label-md font-semibold text-primary">Staging Sandbox</span>
                                        </div>
                                    </td>
                                    <td class="py-2.5 px-3 align-top text-right">
                                        <div class="flex items-center justify-end gap-1">
                                            <button class="p-1 rounded hover:bg-surface-container text-primary" title="Inspect Details">
                                                <span class="material-symbols-outlined text-[18px]">visibility</span>
                                            </button>
                                            <button class="p-1 rounded hover:bg-surface-container text-secondary" title="Launch Validation Pipeline">
                                                <span class="material-symbols-outlined text-[18px]">play_circle</span>
                                            </button>
                                            <button class="px-2 py-0.5 rounded bg-primary-container text-on-primary font-label-sm text-label-sm font-bold shadow-xs" title="Promote to Production">
                                                PROMOTE
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Row 2: v2.4.0 (Staging Baseline / Archived) -->
                                <tr class="bg-surface-container-lowest hover:bg-surface-container-low transition-colors">
                                    <td class="py-2.5 px-3 align-top">
                                        <input checked="" class="rounded accent-primary" type="checkbox" />
                                    </td>
                                    <td class="py-2.5 px-3 align-top">
                                        <div class="flex flex-col">
                                            <span class="font-headline-sm text-headline-sm text-on-surface leading-tight font-semibold">vp-mod-churn-xgb</span>
                                            <div class="flex items-center gap-1 text-on-surface-variant font-code-sm text-code-sm mt-0.5">
                                                <span class="material-symbols-outlined text-[12px] text-outline">fingerprint</span>
                                                <span>SHA:9b11e74a...</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-2.5 px-3 align-top">
                                        <div class="flex flex-col items-start gap-1">
                                            <span class="font-code-sm text-code-sm font-bold text-on-surface bg-surface-container px-1.5 py-0.5 rounded">v2.4.0</span>
                                            <span class="font-label-sm text-label-sm px-1.5 py-0.5 rounded bg-surface-container-highest text-on-surface-variant font-bold">ARCHIVED</span>
                                        </div>
                                    </td>
                                    <td class="py-2.5 px-3 align-top">
                                        <div class="flex flex-col">
                                            <span class="font-label-md text-label-md font-semibold text-on-surface">Cadet E. Vance</span>
                                            <span class="font-code-sm text-code-sm text-on-surface-variant">VP-8820 (Flight D)</span>
                                        </div>
                                    </td>
                                    <td class="py-2.5 px-3 align-top">
                                        <div class="flex flex-col gap-0.5">
                                            <a class="font-code-sm text-code-sm text-primary font-semibold hover:underline flex items-center gap-0.5" href="#">
                                                <span class="material-symbols-outlined text-[12px]">link</span>VP-TKT-1082
                                            </a>
                                            <a class="font-code-sm text-code-sm text-secondary hover:underline flex items-center gap-0.5" href="#">
                                                <span class="material-symbols-outlined text-[12px]">code</span>EXP-884-R1
                                            </a>
                                        </div>
                                    </td>
                                    <td class="py-2.5 px-3 align-top">
                                        <div class="flex flex-col">
                                            <span class="font-code-sm text-code-sm text-on-surface truncate max-w-[130px]">churn_train_v1.parquet</span>
                                            <span class="font-code-sm text-code-sm text-on-surface-variant">Rows: 980K • 31e84a</span>
                                        </div>
                                    </td>
                                    <td class="py-2.5 px-3 align-top">
                                        <div class="flex flex-col">
                                            <span class="font-code-sm text-code-sm font-medium text-on-surface">XGBoost 1.7.4</span>
                                            <span class="font-code-sm text-code-sm text-on-surface-variant">Py3.10 • CUDA 12.1</span>
                                        </div>
                                    </td>
                                    <td class="py-2.5 px-3 align-top text-right">
                                        <div class="flex flex-col items-end gap-0.5">
                                            <div class="flex items-center gap-1 font-code-sm text-code-sm">
                                                <span class="text-on-surface-variant">ROC-AUC:</span>
                                                <span class="font-bold text-on-surface">0.852</span>
                                            </div>
                                            <div class="flex items-center gap-1 font-code-sm text-code-sm text-on-surface-variant">
                                                <span>F1:</span>
                                                <span class="font-medium text-on-surface">0.798</span>
                                                <span>• P95:</span>
                                                <span class="font-medium text-on-surface">26ms</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-2.5 px-3 align-top text-center">
                                        <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded bg-surface-container-high text-on-surface font-code-sm text-code-sm">
                                            <span class="material-symbols-outlined text-[14px] text-on-surface-variant">done</span>
                                            <span>9/10 PASS</span>
                                        </span>
                                    </td>
                                    <td class="py-2.5 px-3 align-top">
                                        <div class="flex flex-col">
                                            <span class="font-label-sm text-label-sm px-1.5 py-0.5 rounded bg-surface-container text-on-surface-variant font-semibold inline-block text-center">HISTORIC OK</span>
                                            <span class="font-code-sm text-code-sm text-on-surface-variant mt-0.5">Dr. K. Petrov</span>
                                        </div>
                                    </td>
                                    <td class="py-2.5 px-3 align-top">
                                        <div class="flex items-center gap-1.5">
                                            <span class="w-2 h-2 rounded-full bg-outline"></span>
                                            <span class="font-label-md text-label-md text-on-surface-variant">Retired (Staging)</span>
                                        </div>
                                    </td>
                                    <td class="py-2.5 px-3 align-top text-right">
                                        <div class="flex items-center justify-end gap-1">
                                            <button class="p-1 rounded hover:bg-surface-container text-primary" title="Inspect Details">
                                                <span class="material-symbols-outlined text-[18px]">visibility</span>
                                            </button>
                                            <button class="p-1 rounded hover:bg-surface-container text-secondary" title="Diff vs Current">
                                                <span class="material-symbols-outlined text-[18px]">difference</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Row 3: v2.3.9 (Failed Tests) -->
                                <tr class="bg-surface-container-high/20 hover:bg-surface-container-high/40 transition-colors">
                                    <td class="py-2.5 px-3 align-top">
                                        <input class="rounded accent-primary" type="checkbox" />
                                    </td>
                                    <td class="py-2.5 px-3 align-top">
                                        <div class="flex flex-col">
                                            <span class="font-headline-sm text-headline-sm text-on-surface leading-tight font-semibold">vp-mod-churn-xgb</span>
                                            <div class="flex items-center gap-1 text-on-surface-variant font-code-sm text-code-sm mt-0.5">
                                                <span class="material-symbols-outlined text-[12px] text-error">fingerprint</span>
                                                <span>SHA:44ad19e...</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-2.5 px-3 align-top">
                                        <div class="flex flex-col items-start gap-1">
                                            <span class="font-code-sm text-code-sm font-bold text-on-error-container bg-error-container px-1.5 py-0.5 rounded">v2.3.9</span>
                                            <span class="font-label-sm text-label-sm px-1.5 py-0.5 rounded bg-error-container text-on-error-container font-bold">FAILED</span>
                                        </div>
                                    </td>
                                    <td class="py-2.5 px-3 align-top">
                                        <div class="flex flex-col">
                                            <span class="font-label-md text-label-md font-semibold text-on-surface">Cadet S. Miller</span>
                                            <span class="font-code-sm text-code-sm text-on-surface-variant">VP-8824 (Flight B)</span>
                                        </div>
                                    </td>
                                    <td class="py-2.5 px-3 align-top">
                                        <div class="flex flex-col gap-0.5">
                                            <a class="font-code-sm text-code-sm text-primary font-semibold hover:underline flex items-center gap-0.5" href="#">
                                                <span class="material-symbols-outlined text-[12px]">link</span>VP-TKT-1082
                                            </a>
                                            <a class="font-code-sm text-code-sm text-secondary hover:underline flex items-center gap-0.5" href="#">
                                                <span class="material-symbols-outlined text-[12px]">code</span>EXP-879-R4
                                            </a>
                                        </div>
                                    </td>
                                    <td class="py-2.5 px-3 align-top">
                                        <div class="flex flex-col">
                                            <span class="font-code-sm text-code-sm text-on-surface truncate max-w-[130px]">churn_raw_sync.parquet</span>
                                            <span class="font-code-sm text-code-sm text-on-surface-variant">Rows: 740K • 0a149c</span>
                                        </div>
                                    </td>
                                    <td class="py-2.5 px-3 align-top">
                                        <div class="flex flex-col">
                                            <span class="font-code-sm text-code-sm font-medium text-on-surface">XGBoost 1.7.4</span>
                                            <span class="font-code-sm text-code-sm text-on-surface-variant">Py3.10 • CUDA 11.8</span>
                                        </div>
                                    </td>
                                    <td class="py-2.5 px-3 align-top text-right">
                                        <div class="flex flex-col items-end gap-0.5">
                                            <div class="flex items-center gap-1 font-code-sm text-code-sm">
                                                <span class="text-on-surface-variant">ROC-AUC:</span>
                                                <span class="font-bold text-error">0.712</span>
                                            </div>
                                            <div class="flex items-center gap-1 font-code-sm text-code-sm text-on-surface-variant">
                                                <span>F1:</span>
                                                <span class="font-medium text-error">0.640</span>
                                                <span>• P95:</span>
                                                <span class="font-medium text-on-surface">48ms</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-2.5 px-3 align-top text-center">
                                        <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded bg-error-container text-on-error-container font-code-sm text-code-sm font-bold">
                                            <span class="material-symbols-outlined text-[14px]">cancel</span>
                                            <span>5/10 FAIL</span>
                                        </span>
                                    </td>
                                    <td class="py-2.5 px-3 align-top">
                                        <div class="flex flex-col">
                                            <span class="font-label-sm text-label-sm px-1.5 py-0.5 rounded bg-error-container text-on-error-container font-semibold inline-block text-center">REJECTED</span>
                                            <span class="font-code-sm text-code-sm text-error mt-0.5">Drift Threshold &gt; 18%</span>
                                        </div>
                                    </td>
                                    <td class="py-2.5 px-3 align-top">
                                        <div class="flex items-center gap-1.5">
                                            <span class="w-2 h-2 rounded-full bg-error"></span>
                                            <span class="font-label-md text-label-md text-error">Blocked</span>
                                        </div>
                                    </td>
                                    <td class="py-2.5 px-3 align-top text-right">
                                        <div class="flex items-center justify-end gap-1">
                                            <button class="p-1 rounded hover:bg-surface-container text-error" title="Inspect Failure Report">
                                                <span class="material-symbols-outlined text-[18px]">report_problem</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Row 4: v1.0.0 (Instructor Certified Gold Baseline) -->
                                <tr class="bg-surface-container-lowest hover:bg-surface-container-low transition-colors">
                                    <td class="py-2.5 px-3 align-top">
                                        <input class="rounded accent-primary" type="checkbox" />
                                    </td>
                                    <td class="py-2.5 px-3 align-top">
                                        <div class="flex flex-col">
                                            <span class="font-headline-sm text-headline-sm text-on-surface leading-tight font-semibold">vp-mod-churn-baseline</span>
                                            <div class="flex items-center gap-1 text-on-surface-variant font-code-sm text-code-sm mt-0.5">
                                                <span class="material-symbols-outlined text-[12px] text-tertiary">lock</span>
                                                <span>SHA:ff0220a1...</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-2.5 px-3 align-top">
                                        <div class="flex flex-col items-start gap-1">
                                            <span class="font-code-sm text-code-sm font-bold text-on-tertiary-container bg-tertiary-fixed px-1.5 py-0.5 rounded">v1.0.0</span>
                                            <span class="font-label-sm text-label-sm px-1.5 py-0.5 rounded bg-tertiary-fixed text-on-tertiary-fixed font-bold">CANONICAL</span>
                                        </div>
                                    </td>
                                    <td class="py-2.5 px-3 align-top">
                                        <div class="flex flex-col">
                                            <span class="font-label-md text-label-md font-semibold text-primary">Instructor Baseline</span>
                                            <span class="font-code-sm text-code-sm text-on-surface-variant">SYS-FACULTY-CORE</span>
                                        </div>
                                    </td>
                                    <td class="py-2.5 px-3 align-top">
                                        <div class="flex flex-col gap-0.5">
                                            <a class="font-code-sm text-code-sm text-primary font-semibold hover:underline flex items-center gap-0.5" href="#">
                                                <span class="material-symbols-outlined text-[12px]">link</span>VP-TKT-0900
                                            </a>
                                            <a class="font-code-sm text-code-sm text-secondary hover:underline flex items-center gap-0.5" href="#">
                                                <span class="material-symbols-outlined text-[12px]">code</span>EXP-FACULTY-01
                                            </a>
                                        </div>
                                    </td>
                                    <td class="py-2.5 px-3 align-top">
                                        <div class="flex flex-col">
                                            <span class="font-code-sm text-code-sm text-on-surface truncate max-w-[130px]">churn_ground_truth.parquet</span>
                                            <span class="font-code-sm text-code-sm text-on-surface-variant">Rows: 2.0M • 11a9f0</span>
                                        </div>
                                    </td>
                                    <td class="py-2.5 px-3 align-top">
                                        <div class="flex flex-col">
                                            <span class="font-code-sm text-code-sm font-medium text-on-surface">Scikit-Learn 1.2.2</span>
                                            <span class="font-code-sm text-code-sm text-on-surface-variant">Py3.9 • CPU Host</span>
                                        </div>
                                    </td>
                                    <td class="py-2.5 px-3 align-top text-right">
                                        <div class="flex flex-col items-end gap-0.5">
                                            <div class="flex items-center gap-1 font-code-sm text-code-sm">
                                                <span class="text-on-surface-variant">ROC-AUC:</span>
                                                <span class="font-bold text-on-surface">0.820</span>
                                            </div>
                                            <div class="flex items-center gap-1 font-code-sm text-code-sm text-on-surface-variant">
                                                <span>F1:</span>
                                                <span class="font-medium text-on-surface">0.765</span>
                                                <span>• P95:</span>
                                                <span class="font-medium text-on-surface">18ms</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-2.5 px-3 align-top text-center">
                                        <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded bg-surface-container-high text-primary font-code-sm text-code-sm font-semibold">
                                            <span class="material-symbols-outlined text-[14px]">verified</span>
                                            <span>10/10 PASS</span>
                                        </span>
                                    </td>
                                    <td class="py-2.5 px-3 align-top">
                                        <div class="flex flex-col">
                                            <span class="font-label-sm text-label-sm px-1.5 py-0.5 rounded bg-tertiary-fixed text-on-tertiary-fixed font-semibold inline-block text-center">GOLD STANDARD</span>
                                            <span class="font-code-sm text-code-sm text-on-surface-variant mt-0.5">Curriculum Office</span>
                                        </div>
                                    </td>
                                    <td class="py-2.5 px-3 align-top">
                                        <div class="flex items-center gap-1.5">
                                            <span class="w-2 h-2 rounded-full bg-outline"></span>
                                            <span class="font-label-md text-label-md text-on-surface-variant">Undeployed (Ref)</span>
                                        </div>
                                    </td>
                                    <td class="py-2.5 px-3 align-top text-right">
                                        <div class="flex items-center justify-end gap-1">
                                            <button class="p-1 rounded hover:bg-surface-container text-primary" title="Clone Blueprint">
                                                <span class="material-symbols-outlined text-[18px]">content_copy</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- Table Footer / Telemetry Pagination -->
                    <div class="flex flex-wrap items-center justify-between gap-space-sm px-space-md py-2.5 bg-surface-container-high/40 text-on-surface-variant font-label-sm text-label-sm">
                        <div class="flex items-center gap-space-md">
                            <span>SHOWING 4 OF 14 MODELS FOR CURRENT BLUEPRINT</span>
                            <span class="font-code-sm text-code-sm text-primary font-bold">TOTAL REGISTRY WEIGHTS: 4.82 GB</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <button class="px-2 py-1 rounded bg-surface-container-low text-on-surface-variant disabled:opacity-50">PREV</button>
                            <span class="px-2 py-1 rounded bg-primary-container text-on-primary font-bold">1</span>
                            <button class="px-2 py-1 rounded bg-surface-container-low text-on-surface hover:text-primary">2</button>
                            <button class="px-2 py-1 rounded bg-surface-container-low text-on-surface hover:text-primary">3</button>
                            <button class="px-2 py-1 rounded bg-surface-container-low text-on-surface hover:text-primary">NEXT</button>
                        </div>
                    </div>
                </div>
                <!-- Deep Version Comparison Panel / Drawer (Interactive Explorer) -->
                <div class="w-full bg-surface-container-lowest rounded-xl shadow-md p-space-md flex flex-col gap-space-md relative overflow-hidden transition-all duration-300" id="diffDrawer">
                    <!-- Panel Header -->
                    <div class="flex flex-wrap items-center justify-between gap-space-sm pb-space-sm border-b-0 bg-surface-container-low/60 -mx-space-md -mt-space-md px-space-md py-space-sm">
                        <div class="flex items-center gap-space-sm">
                            <div class="w-8 h-8 rounded-lg bg-primary-container text-on-primary flex items-center justify-center shadow-xs">
                                <span class="material-symbols-outlined text-[20px]">difference</span>
                            </div>
                            <div class="flex flex-col">
                                <div class="flex items-center gap-space-sm">
                                    <span class="font-headline-sm text-headline-sm text-primary font-semibold">Active Lineage Differential:</span>
                                    <span class="font-code-sm text-code-sm px-2 py-0.5 rounded bg-primary-fixed text-on-primary-fixed-variant font-bold">Candidate: v2.4.1</span>
                                    <span class="font-body-sm text-body-sm text-on-surface-variant">vs</span>
                                    <span class="font-code-sm text-code-sm px-2 py-0.5 rounded bg-surface-container text-on-surface-variant font-bold">Staging: v2.4.0</span>
                                </div>
                                <span class="font-body-sm text-body-sm text-on-surface-variant">Automated delta analysis of hyperparameter vectors, evaluation curves, latency envelopes, and feature ranking shift.</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-space-sm">
                            <span class="font-label-sm text-label-sm px-2 py-1 rounded bg-tertiary-fixed text-on-tertiary-fixed font-bold uppercase">Ready For Cluster Deploy</span>
                            <button class="p-1 rounded text-on-surface-variant hover:text-primary hover:bg-surface-container-high transition-colors" id="minimizeDiffBtn">
                                <span class="material-symbols-outlined text-[20px]">expand_less</span>
                            </button>
                        </div>
                    </div>
                    <!-- Comparative Grid Metrics -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-space-md">
                        <!-- Metric Deltas Card -->
                        <div class="bg-surface-container-low p-space-md rounded-xl flex flex-col justify-between shadow-xs">
                            <div class="flex items-center justify-between mb-space-sm">
                                <span class="font-label-sm text-label-sm uppercase font-bold text-primary">Inference &amp; Metric Deltas</span>
                                <span class="font-code-sm text-code-sm text-on-surface-variant">VALIDATION SET #04</span>
                            </div>
                            <div class="flex flex-col gap-space-sm">
                                <div class="flex items-center justify-between p-2 rounded bg-surface-container-lowest">
                                    <div class="flex flex-col">
                                        <span class="font-label-md text-label-md font-semibold text-on-surface">ROC-AUC Score</span>
                                        <span class="font-code-sm text-code-sm text-on-surface-variant">0.852 → 0.884</span>
                                    </div>
                                    <div class="flex items-center gap-0.5 text-primary font-bold font-code-sm text-code-sm bg-primary-fixed px-1.5 py-0.5 rounded">
                                        <span class="material-symbols-outlined text-[16px]">trending_up</span>
                                        <span>+0.032 (+3.7%)</span>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between p-2 rounded bg-surface-container-lowest">
                                    <div class="flex flex-col">
                                        <span class="font-label-md text-label-md font-semibold text-on-surface">P95 Inference Latency</span>
                                        <span class="font-code-sm text-code-sm text-on-surface-variant">26ms → 22ms</span>
                                    </div>
                                    <div class="flex items-center gap-0.5 text-primary font-bold font-code-sm text-code-sm bg-primary-fixed px-1.5 py-0.5 rounded">
                                        <span class="material-symbols-outlined text-[16px]">speed</span>
                                        <span>-4.0ms (-15.3%)</span>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between p-2 rounded bg-surface-container-lowest">
                                    <div class="flex flex-col">
                                        <span class="font-label-md text-label-md font-semibold text-on-surface">RAM Working Footprint</span>
                                        <span class="font-code-sm text-code-sm text-on-surface-variant">168MB → 142MB</span>
                                    </div>
                                    <div class="flex items-center gap-0.5 text-secondary font-bold font-code-sm text-code-sm bg-secondary-fixed px-1.5 py-0.5 rounded">
                                        <span class="material-symbols-outlined text-[16px]">memory</span>
                                        <span>-26MB</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Hyperparameter Differential Card -->
                        <div class="bg-surface-container-low p-space-md rounded-xl flex flex-col justify-between shadow-xs">
                            <div class="flex items-center justify-between mb-space-sm">
                                <span class="font-label-sm text-label-sm uppercase font-bold text-primary">Hyperparameter Diffs</span>
                                <span class="font-code-sm text-code-sm text-on-surface-variant">xgboost.params</span>
                            </div>
                            <div class="flex flex-col gap-2 font-code-sm text-code-sm">
                                <div class="flex items-center justify-between p-2 rounded bg-surface-container-lowest">
                                    <span class="text-on-surface font-semibold">max_depth</span>
                                    <div class="flex items-center gap-2">
                                        <span class="text-on-surface-variant line-through">6</span>
                                        <span class="material-symbols-outlined text-[14px] text-primary">arrow_forward</span>
                                        <span class="text-primary font-bold bg-primary-fixed px-1 rounded">5</span>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between p-2 rounded bg-surface-container-lowest">
                                    <span class="text-on-surface font-semibold">learning_rate</span>
                                    <div class="flex items-center gap-2">
                                        <span class="text-on-surface-variant line-through">0.050</span>
                                        <span class="material-symbols-outlined text-[14px] text-primary">arrow_forward</span>
                                        <span class="text-primary font-bold bg-primary-fixed px-1 rounded">0.030</span>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between p-2 rounded bg-surface-container-lowest">
                                    <span class="text-on-surface font-semibold">n_estimators</span>
                                    <div class="flex items-center gap-2">
                                        <span class="text-on-surface-variant line-through">300</span>
                                        <span class="material-symbols-outlined text-[14px] text-primary">arrow_forward</span>
                                        <span class="text-primary font-bold bg-primary-fixed px-1 rounded">350</span>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between p-2 rounded bg-surface-container-lowest">
                                    <span class="text-on-surface font-semibold">subsample</span>
                                    <div class="flex items-center gap-2">
                                        <span class="text-on-surface-variant">0.850</span>
                                        <span class="material-symbols-outlined text-[14px] text-outline">sync_alt</span>
                                        <span class="text-on-surface font-medium">0.850 (unchanged)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Feature Importance Shifts Card -->
                        <div class="bg-surface-container-low p-space-md rounded-xl flex flex-col justify-between shadow-xs">
                            <div class="flex items-center justify-between mb-space-sm">
                                <span class="font-label-sm text-label-sm uppercase font-bold text-primary">Feature Weight Shifts (SHAP)</span>
                                <span class="font-code-sm text-code-sm text-on-surface-variant">TOP 4 DRIVERS</span>
                            </div>
                            <div class="flex flex-col gap-2.5">
                                <!-- Feature 1 -->
                                <div class="flex flex-col gap-1">
                                    <div class="flex items-center justify-between font-label-md text-label-md">
                                        <span class="text-on-surface font-medium truncate">telemetry_disconnect_rate</span>
                                        <span class="font-code-sm text-code-sm text-primary font-bold">0.342 → 0.398</span>
                                    </div>
                                    <div class="w-full bg-surface-container h-2 rounded-full overflow-hidden flex">
                                        <div class="bg-secondary h-full" style="width: 72%;"></div>
                                        <div class="bg-primary-container h-full" style="width: 14%;"></div>
                                    </div>
                                </div>
                                <!-- Feature 2 -->
                                <div class="flex flex-col gap-1">
                                    <div class="flex items-center justify-between font-label-md text-label-md">
                                        <span class="text-on-surface font-medium truncate">billing_cycle_delay_days</span>
                                        <span class="font-code-sm text-code-sm text-primary font-bold">0.245 → 0.220</span>
                                    </div>
                                    <div class="w-full bg-surface-container h-2 rounded-full overflow-hidden flex">
                                        <div class="bg-secondary h-full" style="width: 55%;"></div>
                                    </div>
                                </div>
                                <!-- Feature 3 -->
                                <div class="flex flex-col gap-1">
                                    <div class="flex items-center justify-between font-label-md text-label-md">
                                        <span class="text-on-surface font-medium truncate">api_error_spike_count_7d</span>
                                        <span class="font-code-sm text-code-sm text-primary font-bold">0.182 → 0.215</span>
                                    </div>
                                    <div class="w-full bg-surface-container h-2 rounded-full overflow-hidden flex">
                                        <div class="bg-secondary h-full" style="width: 48%;"></div>
                                        <div class="bg-primary-container h-full" style="width: 8%;"></div>
                                    </div>
                                </div>
                                <!-- Feature 4 -->
                                <div class="flex flex-col gap-1">
                                    <div class="flex items-center justify-between font-label-md text-label-md">
                                        <span class="text-on-surface font-medium truncate">contract_tenure_months</span>
                                        <span class="font-code-sm text-code-sm text-outline font-bold">0.110 → 0.089</span>
                                    </div>
                                    <div class="w-full bg-surface-container h-2 rounded-full overflow-hidden flex">
                                        <div class="bg-outline h-full" style="width: 25%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Quick Deployment Action Row -->
                    <div class="flex flex-wrap items-center justify-between gap-space-sm pt-space-xs">
                        <div class="flex items-center gap-space-sm">
                            <span class="material-symbols-outlined text-primary text-[20px]">shield</span>
                            <span class="font-body-sm text-body-sm text-on-surface">Candidate <strong class="font-semibold text-primary">v2.4.1</strong> satisfies all 10 governance policies (bias, latency P95 &lt; 30ms, calibration error &lt; 0.10).</span>
                        </div>
                        <div class="flex items-center gap-space-sm">
                            <button class="px-space-md py-1.5 rounded-lg bg-surface-container-high text-on-surface hover:bg-surface-container-highest font-label-md text-label-md transition-colors">
                                Export Diff PDF
                            </button>
                            <button class="px-space-md py-1.5 rounded-lg bg-tertiary-fixed text-on-tertiary-fixed font-label-md text-label-md font-bold hover:bg-tertiary-fixed-dim transition-colors shadow-xs">
                                Promote Candidate to Production Endpoint
                            </button>
                        </div>
                    </div>
                </div>
        </main>
    </div>
    <script src="js/main.js"></script>
</body>

</html>