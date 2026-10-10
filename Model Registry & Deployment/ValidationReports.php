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
            <nav class="flex flex-col gap-1 px-space-md py-space-sm" data-active-classes="bg-primary-container text-on-primary font-bold shadow-sm"><a class="flex items-center gap-space-md px-space-md py-2.5 rounded-lg text-on-surface-variant font-label-md text-label-md hover:bg-surface-container-high hover:text-on-surface transition-colors" data-path="dashboard" href="dashboard.php">Dashboard</a><a class="flex items-center gap-space-md px-space-md py-2.5 rounded-lg text-on-surface-variant font-label-md text-label-md hover:bg-surface-container-high hover:text-on-surface transition-colors" data-path="model-registry" href="ModelRegistry.php">Model Registry</a><a class="flex items-center gap-space-md px-space-md py-2.5 rounded-lg text-on-surface-variant font-label-md text-label-md hover:bg-surface-container-high hover:text-on-surface transition-colors" data-path="automated-validation-pipeline" href="ValidationPipeline.php">Validation Pipeline</a><a class="flex items-center gap-space-md px-space-md py-2.5 rounded-lg text-on-surface-variant font-label-md text-label-md hover:bg-surface-container-high hover:text-on-surface transition-colors" data-path="deployment-configuration" href="DeploymentConfig.php">Deployment Config</a><a class="flex items-center gap-space-md px-space-md py-2.5 rounded-lg text-on-surface-variant font-label-md text-label-md hover:bg-surface-container-high hover:text-on-surface transition-colors" data-path="deployed-endpoints" href="DeployedEndpoints.php">Deployed Endpoints</a><a aria-current="page" class="flex items-center gap-space-md px-space-md py-2.5 rounded-lg transition-colors bg-primary-container text-on-primary font-bold shadow-sm" data-path="validation-reports" href="ValidationReports.php">Validation Reports</a></nav>
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
            <div class="flex flex-col w-full gap-space-lg">
                <!-- Top Telemetry Context Banner & Breadcrumbs -->
                <div class="flex flex-col gap-space-sm bg-surface-container-lowest p-space-lg rounded-xl shadow-sm">
                    <div class="flex flex-wrap items-center justify-between gap-space-md">
                        <div class="flex items-center gap-space-md">
                            <span class="px-2 py-0.5 rounded bg-primary-container text-on-primary font-label-sm text-label-sm tracking-wider uppercase">VALIDATION AUDIT</span>
                            <div class="flex items-center gap-1.5 font-code-sm text-code-sm text-on-surface-variant">
                                <span>SYS-AI-04</span>
                                <span class="text-outline">/</span>
                                <span>REPORTS</span>
                                <span class="text-outline">/</span>
                                <span class="text-primary font-semibold">VP-TKT-1082-AUDIT-v2.4.1</span>
                            </div>
                            <div class="hidden md:flex items-center gap-1.5 px-2 py-0.5 rounded bg-surface-container text-on-surface-variant font-code-sm text-code-sm">
                                <span class="material-symbols-outlined text-[14px] text-primary">dns</span>
                                <span>CLUSTER: ORBIT-EU-CENTRAL-01</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-secondary-fixed text-on-secondary-fixed font-code-sm text-code-sm font-semibold">
                                <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                                <span>HASH CONSENSUS VERIFIED</span>
                            </div>
                            <span class="font-code-sm text-code-sm text-on-surface-variant px-2 py-1 rounded bg-surface-container-high">2024-10-24 14:02:11 UTC</span>
                        </div>
                    </div>
                    <!-- Candidate Main Header Row -->
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-space-md pt-space-xs">
                        <div class="flex flex-col">
                            <div class="flex flex-wrap items-baseline gap-space-md">
                                <h1 class="font-headline-xl text-headline-xl text-primary tracking-tight">vp-mod-churn-xgb:v2.4.1</h1>
                                <span class="px-2.5 py-1 rounded font-label-sm text-label-sm bg-tertiary-fixed text-on-tertiary-fixed font-bold">FLIGHT D // CADET E. VANCE</span>
                            </div>
                            <div class="flex flex-wrap items-center gap-x-space-md gap-y-1 font-body-sm text-body-sm text-on-surface-variant mt-1">
                                <span class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[15px] text-tertiary">assignment_turned_in</span>
                                    Active Objective: <strong>Customer Churn Prediction (Ticket: VP-TKT-1082)</strong>
                                </span>
                                <span>•</span>
                                <span class="font-code-sm text-code-sm">SHA256: 88ef4a7b9d10e527c91fa8b88a92e10a2839d919c0b11...</span>
                                <span>•</span>
                                <span class="font-code-sm text-code-sm text-primary font-semibold">ROOT-MANIFEST: #MAN-VP-8820-04</span>
                            </div>
                        </div>
                        <!-- Action Button Array -->
                        <div class="flex flex-wrap items-center gap-2">
                            <button class="flex items-center gap-1.5 px-3 py-1.5 bg-surface-container text-primary font-label-md text-label-md rounded shadow-sm hover:bg-surface-container-high transition-colors">
                                <span class="material-symbols-outlined text-[16px]">compare_arrows</span>
                                <span>Compare vs v2.4.0</span>
                            </button>
                            <button class="flex items-center gap-1.5 px-3 py-1.5 bg-surface-container text-primary font-label-md text-label-md rounded shadow-sm hover:bg-surface-container-high transition-colors">
                                <span class="material-symbols-outlined text-[16px]">verified_user</span>
                                <span>Cryptographic Cert (.pdf)</span>
                            </button>
                            <button class="flex items-center gap-1.5 px-3.5 py-1.5 bg-primary-container text-on-primary font-label-md text-label-md rounded shadow-sm hover:opacity-95 transition-opacity">
                                <span class="material-symbols-outlined text-[16px]">download</span>
                                <span>Export Audit Bundle (.tar)</span>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Executive Summary & Scorecards Grid (4 Metrics) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-space-md">
                    <!-- Card 1: Check Verdict -->
                    <div class="flex flex-col justify-between p-space-md rounded-xl bg-surface-container-lowest shadow-sm relative overflow-hidden">
                        <div class="absolute -right-6 -bottom-6 w-24 h-24 rounded-full bg-secondary-fixed/30 pointer-events-none"></div>
                        <div class="flex items-center justify-between">
                            <span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Gate Verdict</span>
                            <span class="px-2 py-0.5 rounded font-label-sm text-label-sm bg-secondary-fixed text-on-secondary-fixed font-bold">VP-TKT-1082 PASS</span>
                        </div>
                        <div class="my-space-sm flex items-baseline gap-space-sm">
                            <span class="font-headline-xl text-headline-xl text-primary font-bold">10 / 10</span>
                            <span class="font-label-md text-label-md text-on-surface-variant">Checks Passed</span>
                        </div>
                        <div class="flex items-center gap-1.5 font-code-sm text-code-sm text-secondary">
                            <span class="material-symbols-outlined text-[16px]">verified</span>
                            <span>Deterministic proof valid</span>
                        </div>
                    </div>
                    <!-- Card 2: Model Evaluation Delta -->
                    <div class="flex flex-col justify-between p-space-md rounded-xl bg-surface-container-lowest shadow-sm">
                        <div class="flex items-center justify-between">
                            <span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Evaluation Delta</span>
                            <span class="font-code-sm text-code-sm text-primary font-semibold">ROC-AUC &amp; F1</span>
                        </div>
                        <div class="my-space-sm flex items-baseline gap-space-sm">
                            <span class="font-headline-xl text-headline-xl text-primary font-bold">0.884</span>
                            <span class="font-code-sm text-code-sm px-1.5 py-0.5 rounded bg-tertiary-fixed text-on-tertiary-fixed font-semibold">+0.044 DELTA</span>
                        </div>
                        <div class="flex items-center justify-between font-body-sm text-body-sm text-on-surface-variant">
                            <span>F1-Score: <strong class="text-on-surface">0.821</strong> (Req ≥ 0.800)</span>
                            <span class="text-primary font-semibold">Passed</span>
                        </div>
                    </div>
                    <!-- Card 3: Runtime SLA & Latency -->
                    <div class="flex flex-col justify-between p-space-md rounded-xl bg-surface-container-lowest shadow-sm">
                        <div class="flex items-center justify-between">
                            <span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Inference SLA (P95)</span>
                            <span class="px-2 py-0.5 rounded font-label-sm text-label-sm bg-surface-container-high text-primary font-semibold">≤ 45.0ms REQ</span>
                        </div>
                        <div class="my-space-sm flex items-baseline gap-space-sm">
                            <span class="font-headline-xl text-headline-xl text-primary font-bold">18.4<span class="font-headline-md text-headline-md text-on-surface-variant font-normal">ms</span></span>
                            <span class="font-body-sm text-body-sm text-on-surface-variant">(P50: 12.1ms)</span>
                        </div>
                        <div class="flex items-center gap-1.5 font-body-sm text-body-sm text-on-surface-variant">
                            <div class="w-full bg-surface-container rounded-full h-1.5">
                                <div class="bg-primary-container h-1.5 rounded-full" style="width: 41%;"></div>
                            </div>
                            <span class="font-code-sm text-code-sm text-primary font-bold shrink-0">41% SLA Cap</span>
                        </div>
                    </div>
                    <!-- Card 4: Robustness & Boundary Resilience -->
                    <div class="flex flex-col justify-between p-space-md rounded-xl bg-surface-container-lowest shadow-sm">
                        <div class="flex items-center justify-between">
                            <span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Edge Invariance</span>
                            <span class="px-2 py-0.5 rounded font-label-sm text-label-sm bg-secondary-fixed text-on-secondary-fixed font-bold">250/250 PASS</span>
                        </div>
                        <div class="my-space-sm flex items-baseline gap-space-sm">
                            <span class="font-headline-xl text-headline-xl text-primary font-bold">0.00%</span>
                            <span class="font-label-md text-label-md text-on-surface-variant">NaN / Collision Rate</span>
                        </div>
                        <div class="flex items-center gap-1 font-body-sm text-body-sm text-on-surface-variant">
                            <span class="material-symbols-outlined text-[15px] text-primary">shield_with_heart</span>
                            <span>Zero silent arithmetic leaks</span>
                        </div>
                    </div>
                </div>
                <!-- Visual Telemetry & Architecture Inset Row -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-space-md">
                    <!-- Visual Latency Envelope Mini-Chart -->
                    <div class="flex flex-col justify-between p-space-md rounded-xl bg-surface-container-lowest shadow-sm">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-[18px] text-primary">speed</span>
                                <span class="font-headline-sm text-headline-sm text-primary">Latency Envelope Dist.</span>
                            </div>
                            <span class="font-code-sm text-code-sm text-on-surface-variant">1,000 PAYLOADS</span>
                        </div>
                        <div class="w-full h-24 flex items-end gap-1.5 pt-2 pb-1 px-1 bg-surface-container-low rounded-lg">
                            <div class="flex-1 bg-secondary-container rounded-t h-4 flex items-center justify-center text-[9px] font-label-sm text-on-secondary-container">8ms</div>
                            <div class="flex-1 bg-secondary-container rounded-t h-10 flex items-center justify-center text-[9px] font-label-sm text-on-secondary-container">11ms</div>
                            <div class="flex-1 bg-primary-container rounded-t h-20 flex items-center justify-center text-[9px] font-label-sm text-on-primary">12.1ms</div>
                            <div class="flex-1 bg-secondary-container rounded-t h-14 flex items-center justify-center text-[9px] font-label-sm text-on-secondary-container">15ms</div>
                            <div class="flex-1 bg-secondary-fixed rounded-t h-8 flex items-center justify-center text-[9px] font-label-sm text-on-secondary-fixed">18.4ms</div>
                            <div class="flex-1 bg-surface-container-high rounded-t h-3 flex items-center justify-center text-[9px] font-label-sm text-on-surface-variant">24ms</div>
                            <div class="flex-1 bg-surface-container-high rounded-t h-1.5 flex items-center justify-center text-[9px] font-label-sm text-on-surface-variant">32ms</div>
                        </div>
                        <div class="flex items-center justify-between text-on-surface-variant font-code-sm text-code-sm pt-2">
                            <span>Min: 8.2ms</span>
                            <span class="text-primary font-bold">P50: 12.1ms</span>
                            <span class="text-primary font-bold">P95: 18.4ms</span>
                            <span>Max: 34.2ms</span>
                        </div>
                    </div>
                    <!-- Candidate Environment & Model Spec Snapshot -->
                    <div class="flex flex-col justify-between p-space-md rounded-xl bg-surface-container-lowest shadow-sm">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-[18px] text-primary">memory</span>
                                <span class="font-headline-sm text-headline-sm text-primary">Runtime Framework Spec</span>
                            </div>
                            <span class="font-code-sm text-code-sm px-1.5 py-0.5 rounded bg-surface-container text-on-surface-variant">POD #04</span>
                        </div>
                        <div class="grid grid-cols-2 gap-2 text-on-surface font-body-sm text-body-sm">
                            <div class="p-2 rounded bg-surface-container-low flex flex-col">
                                <span class="font-label-sm text-label-sm text-on-surface-variant uppercase">Runtime Kernel</span>
                                <span class="font-code-sm text-code-sm font-semibold text-primary">Python 3.10.12 LTS</span>
                            </div>
                            <div class="p-2 rounded bg-surface-container-low flex flex-col">
                                <span class="font-label-sm text-label-sm text-on-surface-variant uppercase">Estimator Engine</span>
                                <span class="font-code-sm text-code-sm font-semibold text-primary">XGBoost 1.7.5-cu11</span>
                            </div>
                            <div class="p-2 rounded bg-surface-container-low flex flex-col">
                                <span class="font-label-sm text-label-sm text-on-surface-variant uppercase">Input Dimension</span>
                                <span class="font-code-sm text-code-sm font-semibold text-primary">24 Features (Dense)</span>
                            </div>
                            <div class="p-2 rounded bg-surface-container-low flex flex-col">
                                <span class="font-label-sm text-label-sm text-on-surface-variant uppercase">Container Footprint</span>
                                <span class="font-code-sm text-code-sm font-semibold text-primary">142 MB (Stripped)</span>
                            </div>
                        </div>
                        <div class="pt-2 flex items-center justify-between font-label-sm text-label-sm text-on-surface-variant">
                            <span>Deterministic Seed: <code class="text-primary font-bold">SEED_INT=42</code></span>
                            <span>CUDA Stream: Direct-Mapped</span>
                        </div>
                    </div>
                    <!-- Validation Laboratory Context & Provenance -->
                    <div class="flex flex-col justify-between p-space-md rounded-xl bg-surface-container-lowest shadow-sm">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-[18px] text-tertiary">hub</span>
                                <span class="font-headline-sm text-headline-sm text-primary">Laboratory Chain-of-Custody</span>
                            </div>
                            <span class="font-label-sm text-label-sm px-1.5 py-0.5 rounded bg-tertiary-fixed text-on-tertiary-fixed font-bold">ROSE-GOLD SEC</span>
                        </div>
                        <div class="flex flex-col gap-1.5 font-code-sm text-code-sm text-on-surface">
                            <div class="flex items-center justify-between p-1.5 rounded bg-surface-container-low">
                                <span class="text-on-surface-variant">Training Notebook</span>
                                <span class="font-semibold text-primary truncate max-w-[160px]">EXP-884_xgboost_churn.ipynb</span>
                            </div>
                            <div class="flex items-center justify-between p-1.5 rounded bg-surface-container-low">
                                <span class="text-on-surface-variant">Evaluation Dataset</span>
                                <span class="font-semibold text-primary truncate max-w-[160px]">telemetry_churn_holdout_q3</span>
                            </div>
                            <div class="flex items-center justify-between p-1.5 rounded bg-surface-container-low">
                                <span class="text-on-surface-variant">Orchestrator Node</span>
                                <span class="font-semibold text-primary truncate max-w-[160px]">orbit-runner-eu-c01-worker8</span>
                            </div>
                        </div>
                        <div class="pt-2 flex items-center justify-between font-label-sm text-label-sm text-secondary">
                            <span class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">lock</span>
                                <span>Manifest Seal Immutability Verified</span>
                            </span>
                            <span class="font-code-sm text-code-sm">2048-BIT ED25519</span>
                        </div>
                    </div>
                </div>
                <!-- Multi-Tab Navigation & Detailed Check Results Section -->
                <div class="flex flex-col bg-surface-container-lowest rounded-xl shadow-sm overflow-hidden">
                    <!-- Tabs Header Bar -->
                    <div class="flex items-center justify-between border-b border-surface-container-highest px-space-md pt-space-xs bg-surface-container-low overflow-x-auto">
                        <div class="flex items-center gap-1">
                            <button class="px-space-md py-2.5 rounded-t-lg bg-surface-container-lowest font-headline-sm text-headline-sm text-primary border-t-2 border-primary-container flex items-center gap-2">
                                <span class="material-symbols-outlined text-[18px]">fact_check</span>
                                <span>Summary &amp; Check Results</span>
                                <span class="font-label-sm text-label-sm px-1.5 py-0.2 rounded-full bg-secondary-fixed text-on-secondary-fixed">10</span>
                            </button>
                            <button class="px-space-md py-2.5 text-on-surface-variant hover:text-primary font-headline-sm text-headline-sm flex items-center gap-2 transition-colors">
                                <span class="material-symbols-outlined text-[18px]">query_stats</span>
                                <span>Metric Threshold Proofs</span>
                            </button>
                            <button class="px-space-md py-2.5 text-on-surface-variant hover:text-primary font-headline-sm text-headline-sm flex items-center gap-2 transition-colors">
                                <span class="material-symbols-outlined text-[18px]">error_outline</span>
                                <span>Failed Tests &amp; Warnings</span>
                                <span class="font-label-sm text-label-sm px-1.5 py-0.2 rounded-full bg-surface-container-high text-on-surface-variant">0 / 0</span>
                            </button>
                            <button class="px-space-md py-2.5 text-on-surface-variant hover:text-primary font-headline-sm text-headline-sm flex items-center gap-2 transition-colors">
                                <span class="material-symbols-outlined text-[18px]">terminal</span>
                                <span>Assertion Logs &amp; Evidence</span>
                            </button>
                            <button class="px-space-md py-2.5 text-on-surface-variant hover:text-primary font-headline-sm text-headline-sm flex items-center gap-2 transition-colors">
                                <span class="material-symbols-outlined text-[18px]">explore</span>
                                <span>Investigation Matrix</span>
                            </button>
                        </div>
                        <div class="hidden sm:flex items-center gap-2 text-on-surface-variant font-code-sm text-code-sm">
                            <span>EXECUTION WALL-TIME: <strong>1m 38.2s</strong></span>
                        </div>
                    </div>
                    <!-- Active Tab Content: 10 Check Steps Table / List -->
                    <div class="p-space-lg flex flex-col gap-space-sm">
                        <div class="flex items-center justify-between pb-space-xs">
                            <div class="flex items-center gap-2">
                                <span class="font-headline-sm text-headline-sm text-primary">Deterministic Pipeline Verification Sequence</span>
                                <span class="font-body-sm text-body-sm text-on-surface-variant">(Automated Suite SYS-AI-04-VAL-SUITE-V4)</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="font-label-sm text-label-sm text-secondary font-bold uppercase">All 10 Invariants Satisfied</span>
                            </div>
                        </div>
                        <!-- Step Row 1 -->
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between p-space-sm rounded-lg bg-surface-container-low hover:bg-surface-container transition-colors gap-space-sm">
                            <div class="flex items-center gap-space-md">
                                <div class="w-7 h-7 rounded-full bg-secondary-fixed text-on-secondary-fixed flex items-center justify-center font-code-sm text-code-sm font-bold shrink-0">
                                    01
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-headline-sm text-headline-sm text-on-surface">Step 1: Artifact Integrity &amp; Cryptographic Checksum</span>
                                    <span class="font-body-sm text-body-sm text-on-surface-variant">SHA256 digest matched bit-exact against registry training run receipt; binary stream valid.</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between sm:justify-end gap-space-md pl-10 sm:pl-0">
                                <span class="font-code-sm text-code-sm text-on-surface-variant">240ms</span>
                                <span class="font-label-sm text-label-sm px-2.5 py-1 rounded bg-secondary-fixed text-on-secondary-fixed font-bold uppercase">PASSED</span>
                            </div>
                        </div>
                        <!-- Step Row 2 -->
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between p-space-sm rounded-lg bg-surface-container-lowest hover:bg-surface-container transition-colors gap-space-sm">
                            <div class="flex items-center gap-space-md">
                                <div class="w-7 h-7 rounded-full bg-secondary-fixed text-on-secondary-fixed flex items-center justify-center font-code-sm text-code-sm font-bold shrink-0">
                                    02
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-headline-sm text-headline-sm text-on-surface">Step 2: Metadata &amp; Provenance Linkage Validation</span>
                                    <span class="font-body-sm text-body-sm text-on-surface-variant">Model card present; 12/12 mandatory tags defined; Apache-2.0 license verified; ticket VP-TKT-1082 linked.</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between sm:justify-end gap-space-md pl-10 sm:pl-0">
                                <span class="font-code-sm text-code-sm text-on-surface-variant">42ms</span>
                                <span class="font-label-sm text-label-sm px-2.5 py-1 rounded bg-secondary-fixed text-on-secondary-fixed font-bold uppercase">PASSED</span>
                            </div>
                        </div>
                        <!-- Step Row 3 -->
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between p-space-sm rounded-lg bg-surface-container-low hover:bg-surface-container transition-colors gap-space-sm">
                            <div class="flex items-center gap-space-md">
                                <div class="w-7 h-7 rounded-full bg-secondary-fixed text-on-secondary-fixed flex items-center justify-center font-code-sm text-code-sm font-bold shrink-0">
                                    03
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-headline-sm text-headline-sm text-on-surface">Step 3: Schema Contract &amp; Feature Shape Integrity</span>
                                    <span class="font-body-sm text-body-sm text-on-surface-variant">24 input features verified; exact Float32/Int64/One-Hot type contracts enforced with 0 mutations.</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between sm:justify-end gap-space-md pl-10 sm:pl-0">
                                <span class="font-code-sm text-code-sm text-on-surface-variant">68ms</span>
                                <span class="font-label-sm text-label-sm px-2.5 py-1 rounded bg-secondary-fixed text-on-secondary-fixed font-bold uppercase">PASSED</span>
                            </div>
                        </div>
                        <!-- Step Row 4 -->
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between p-space-sm rounded-lg bg-surface-container-lowest hover:bg-surface-container transition-colors gap-space-sm">
                            <div class="flex items-center gap-space-md">
                                <div class="w-7 h-7 rounded-full bg-secondary-fixed text-on-secondary-fixed flex items-center justify-center font-code-sm text-code-sm font-bold shrink-0">
                                    04
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-headline-sm text-headline-sm text-on-surface">Step 4: Runtime Dependency &amp; Shared Library Compatibility</span>
                                    <span class="font-body-sm text-body-sm text-on-surface-variant">Python 3.10 sandbox, XGBoost 1.7.5, scikit-learn 1.3.0, libgomp1 binary zero ABI collision.</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between sm:justify-end gap-space-md pl-10 sm:pl-0">
                                <span class="font-code-sm text-code-sm text-on-surface-variant">1.2s</span>
                                <span class="font-label-sm text-label-sm px-2.5 py-1 rounded bg-secondary-fixed text-on-secondary-fixed font-bold uppercase">PASSED</span>
                            </div>
                        </div>
                        <!-- Step Row 5 -->
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between p-space-sm rounded-lg bg-surface-container-low hover:bg-surface-container transition-colors gap-space-sm">
                            <div class="flex items-center gap-space-md">
                                <div class="w-7 h-7 rounded-full bg-secondary-fixed text-on-secondary-fixed flex items-center justify-center font-code-sm text-code-sm font-bold shrink-0">
                                    05
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-headline-sm text-headline-sm text-on-surface">Step 5: Reproducibility &amp; Stochastic Determinism Sweep</span>
                                    <span class="font-body-sm text-body-sm text-on-surface-variant">Dual-run seeded evaluation (Seed 42); exact prediction vector match with epsilon Δ &lt; 0.0003.</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between sm:justify-end gap-space-md pl-10 sm:pl-0">
                                <span class="font-code-sm text-code-sm text-on-surface-variant">18.6s</span>
                                <span class="font-label-sm text-label-sm px-2.5 py-1 rounded bg-secondary-fixed text-on-secondary-fixed font-bold uppercase">PASSED</span>
                            </div>
                        </div>
                        <!-- Step Row 6 -->
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between p-space-sm rounded-lg bg-surface-container-lowest hover:bg-surface-container transition-colors gap-space-sm">
                            <div class="flex items-center gap-space-md">
                                <div class="w-7 h-7 rounded-full bg-secondary-fixed text-on-secondary-fixed flex items-center justify-center font-code-sm text-code-sm font-bold shrink-0">
                                    06
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-headline-sm text-headline-sm text-on-surface">Step 6: Synthetic Payload Smoke Test &amp; Deserialization</span>
                                    <span class="font-body-sm text-body-sm text-on-surface-variant">1,000 synthetic test samples dispatched in batch &amp; stream modes; 100% 200 OK responses.</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between sm:justify-end gap-space-md pl-10 sm:pl-0">
                                <span class="font-code-sm text-code-sm text-on-surface-variant">2.4s</span>
                                <span class="font-label-sm text-label-sm px-2.5 py-1 rounded bg-secondary-fixed text-on-secondary-fixed font-bold uppercase">PASSED</span>
                            </div>
                        </div>
                        <!-- Step Row 7 -->
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between p-space-sm rounded-lg bg-surface-container-low hover:bg-surface-container transition-colors gap-space-sm">
                            <div class="flex items-center gap-space-md">
                                <div class="w-7 h-7 rounded-full bg-secondary-fixed text-on-secondary-fixed flex items-center justify-center font-code-sm text-code-sm font-bold shrink-0">
                                    07
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-headline-sm text-headline-sm text-on-surface">Step 7: Input Edge-Case Adversarial &amp; Boundary Stress</span>
                                    <span class="font-body-sm text-body-sm text-on-surface-variant">Extreme float limits, total null-feature imputation, and zero-variance scenarios gracefully absorbed.</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between sm:justify-end gap-space-md pl-10 sm:pl-0">
                                <span class="font-code-sm text-code-sm text-on-surface-variant">3.1s</span>
                                <span class="font-label-sm text-label-sm px-2.5 py-1 rounded bg-secondary-fixed text-on-secondary-fixed font-bold uppercase">PASSED</span>
                            </div>
                        </div>
                        <!-- Step Row 8 -->
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between p-space-sm rounded-lg bg-surface-container-lowest hover:bg-surface-container transition-colors gap-space-sm">
                            <div class="flex items-center gap-space-md">
                                <div class="w-7 h-7 rounded-full bg-secondary-fixed text-on-secondary-fixed flex items-center justify-center font-code-sm text-code-sm font-bold shrink-0">
                                    08
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-headline-sm text-headline-sm text-on-surface">Step 8: Business Metric Acceptance Gate (VP-TKT-1082)</span>
                                    <span class="font-body-sm text-body-sm text-on-surface-variant">Holdout Set Evaluation: ROC-AUC 0.884 ≥ 0.840; F1 0.821 ≥ 0.800. Threshold proofs certified.</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between sm:justify-end gap-space-md pl-10 sm:pl-0">
                                <span class="font-code-sm text-code-sm text-on-surface-variant">1m 12s</span>
                                <span class="font-label-sm text-label-sm px-2.5 py-1 rounded bg-secondary-fixed text-on-secondary-fixed font-bold uppercase">PASSED</span>
                            </div>
                        </div>
                        <!-- Step Row 9 -->
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between p-space-sm rounded-lg bg-surface-container-low hover:bg-surface-container transition-colors gap-space-sm">
                            <div class="flex items-center gap-space-md">
                                <div class="w-7 h-7 rounded-full bg-secondary-fixed text-on-secondary-fixed flex items-center justify-center font-code-sm text-code-sm font-bold shrink-0">
                                    09
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-headline-sm text-headline-sm text-on-surface">Step 9: API Contract &amp; Protocol Wire Conformance</span>
                                    <span class="font-body-sm text-body-sm text-on-surface-variant">HTTP/2 JSON-REST endpoints and gRPC protobuf schema validation; strict error codes returned.</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between sm:justify-end gap-space-md pl-10 sm:pl-0">
                                <span class="font-code-sm text-code-sm text-on-surface-variant">540ms</span>
                                <span class="font-label-sm text-label-sm px-2.5 py-1 rounded bg-secondary-fixed text-on-secondary-fixed font-bold uppercase">PASSED</span>
                            </div>
                        </div>
                        <!-- Step Row 10 -->
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between p-space-sm rounded-lg bg-surface-container-lowest hover:bg-surface-container transition-colors gap-space-sm">
                            <div class="flex items-center gap-space-md">
                                <div class="w-7 h-7 rounded-full bg-secondary-fixed text-on-secondary-fixed flex items-center justify-center font-code-sm text-code-sm font-bold shrink-0">
                                    10
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-headline-sm text-headline-sm text-on-surface">Step 10: Final Audit Synthesis &amp; Manifest Generation</span>
                                    <span class="font-body-sm text-body-sm text-on-surface-variant">Cryptographic consensus hash sealed: MAN-VP-8820-04. Ready for supervisory sign-off.</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between sm:justify-end gap-space-md pl-10 sm:pl-0">
                                <span class="font-code-sm text-code-sm text-on-surface-variant">120ms</span>
                                <span class="font-label-sm text-label-sm px-2.5 py-1 rounded bg-secondary-fixed text-on-secondary-fixed font-bold uppercase">PASSED</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Deep Investigation & Pedagogical Sign-Off Dual Column Layout -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-md">
                    <!-- Left Column: Business Criteria Acceptance & Drift Analysis (7 Cols) -->
                    <div class="lg:col-span-7 flex flex-col gap-space-md">
                        <div class="p-space-lg rounded-xl bg-surface-container-lowest shadow-sm flex flex-col gap-space-md">
                            <div class="flex items-center justify-between border-b border-surface-container-highest pb-space-sm">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-[20px] text-primary">analytics</span>
                                    <h2 class="font-headline-md text-headline-md text-primary">Business Criteria &amp; Metric Drift Proofs</h2>
                                </div>
                                <span class="font-code-sm text-code-sm px-2 py-0.5 rounded bg-tertiary-fixed text-on-tertiary-fixed font-bold">VP-TKT-1082 SPEC</span>
                            </div>
                            <!-- Metric Table -->
                            <div class="overflow-x-auto">
                                <table class="w-full text-left font-body-sm text-body-sm">
                                    <thead>
                                        <tr class="text-on-surface-variant font-label-sm text-label-sm border-b border-surface-container-high">
                                            <th class="py-2 pr-4 uppercase">Target Metric</th>
                                            <th class="py-2 px-3 uppercase">Ticket Requirement</th>
                                            <th class="py-2 px-3 uppercase">Baseline v2.4.0</th>
                                            <th class="py-2 px-3 uppercase text-primary font-bold">Candidate v2.4.1</th>
                                            <th class="py-2 pl-3 uppercase text-right">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-surface-container-high">
                                        <tr>
                                            <td class="py-2.5 pr-4 font-semibold text-on-surface">ROC-AUC (Test Holdout)</td>
                                            <td class="py-2.5 px-3 font-code-sm text-code-sm">≥ 0.840</td>
                                            <td class="py-2.5 px-3 font-code-sm text-code-sm text-on-surface-variant">0.840</td>
                                            <td class="py-2.5 px-3 font-code-sm text-code-sm text-primary font-bold">0.884 (+0.044)</td>
                                            <td class="py-2.5 pl-3 text-right">
                                                <span class="font-label-sm text-label-sm px-2 py-0.5 rounded bg-secondary-fixed text-on-secondary-fixed font-bold">SUPERIOR</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="py-2.5 pr-4 font-semibold text-on-surface">F1-Score (Macro)</td>
                                            <td class="py-2.5 px-3 font-code-sm text-code-sm">≥ 0.800</td>
                                            <td class="py-2.5 px-3 font-code-sm text-code-sm text-on-surface-variant">0.802</td>
                                            <td class="py-2.5 px-3 font-code-sm text-code-sm text-primary font-bold">0.821 (+0.019)</td>
                                            <td class="py-2.5 pl-3 text-right">
                                                <span class="font-label-sm text-label-sm px-2 py-0.5 rounded bg-secondary-fixed text-on-secondary-fixed font-bold">SUPERIOR</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="py-2.5 pr-4 font-semibold text-on-surface">Inference Latency (P95)</td>
                                            <td class="py-2.5 px-3 font-code-sm text-code-sm">≤ 45.0 ms</td>
                                            <td class="py-2.5 px-3 font-code-sm text-code-sm text-on-surface-variant">22.8 ms</td>
                                            <td class="py-2.5 px-3 font-code-sm text-code-sm text-primary font-bold">18.4 ms (-4.4ms)</td>
                                            <td class="py-2.5 pl-3 text-right">
                                                <span class="font-label-sm text-label-sm px-2 py-0.5 rounded bg-secondary-fixed text-on-secondary-fixed font-bold">COMPLIANT</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="py-2.5 pr-4 font-semibold text-on-surface">False Negative Ratio</td>
                                            <td class="py-2.5 px-3 font-code-sm text-code-sm">≤ 12.0%</td>
                                            <td class="py-2.5 px-3 font-code-sm text-code-sm text-on-surface-variant">11.4%</td>
                                            <td class="py-2.5 px-3 font-code-sm text-code-sm text-primary font-bold">8.7% (-2.7%)</td>
                                            <td class="py-2.5 pl-3 text-right">
                                                <span class="font-label-sm text-label-sm px-2 py-0.5 rounded bg-secondary-fixed text-on-secondary-fixed font-bold">COMPLIANT</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- Calibration & Feature Shift Proof Details -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-space-sm pt-space-xs">
                                <div class="p-space-sm rounded-lg bg-surface-container-low flex flex-col gap-1">
                                    <span class="font-headline-sm text-headline-sm text-primary">Top Feature Weight Stability</span>
                                    <div class="flex flex-col gap-1.5 pt-1 text-on-surface font-body-sm text-body-sm">
                                        <div class="flex items-center justify-between">
                                            <span class="font-code-sm text-code-sm">contract_length_months</span>
                                            <span class="font-code-sm text-code-sm text-primary font-semibold">28.4% (Shift: +0.2%)</span>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <span class="font-code-sm text-code-sm">monthly_network_variance</span>
                                            <span class="font-code-sm text-code-sm text-primary font-semibold">19.1% (Shift: -0.8%)</span>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <span class="font-code-sm text-code-sm">support_ticket_density_30d</span>
                                            <span class="font-code-sm text-code-sm text-primary font-semibold">14.6% (Shift: +1.1%)</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-space-sm rounded-lg bg-surface-container-low flex flex-col gap-1">
                                    <span class="font-headline-sm text-headline-sm text-primary">Probability Calibration Curve</span>
                                    <div class="flex items-center justify-between pt-1 font-body-sm text-body-sm text-on-surface">
                                        <span>Brier Score Loss:</span>
                                        <span class="font-code-sm text-code-sm text-primary font-semibold">0.089 (Ideal ≤ 0.12)</span>
                                    </div>
                                    <div class="flex items-center justify-between font-body-sm text-body-sm text-on-surface">
                                        <span>Expected Calibration Error (ECE):</span>
                                        <span class="font-code-sm text-code-sm text-primary font-semibold">2.1% (Ideal ≤ 5.0%)</span>
                                    </div>
                                    <div class="flex items-center justify-between font-body-sm text-body-sm text-on-surface">
                                        <span>Reliability Index:</span>
                                        <span class="font-code-sm text-code-sm text-primary font-semibold">0.961 / 1.000</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Right Column: Pedagogical Policy & Supervisory Instructor Sign-Off (5 Cols) -->
                    <div class="lg:col-span-5 flex flex-col gap-space-md">
                        <!-- Pedagogical Warning Note Card -->
                        <div class="p-space-lg rounded-xl bg-tertiary-fixed/20 shadow-sm flex flex-col gap-space-sm">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-tertiary text-[20px]">policy</span>
                                <span class="font-headline-sm text-headline-sm text-tertiary font-bold">Pedagogical Guardrail Policy</span>
                            </div>
                            <p class="font-body-sm text-body-sm text-on-tertiary-fixed leading-relaxed">
                                Automated validation proves technical compliance, runtime stability, and boundary invariance under sandbox conditions, but <strong>DOES NOT substitute for Instructor Pedagogical Approval</strong>. All model artifacts promoting to production staging require manual authorization from Flight Instructors or Chief Evaluators.
                            </p>
                        </div>
                        <!-- Instructor Sign-Off Box -->
                        <div class="p-space-lg rounded-xl bg-surface-container-lowest shadow-sm flex flex-col justify-between flex-1 gap-space-md">
                            <div class="flex flex-col gap-space-xs">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-[20px] text-primary">key</span>
                                        <h2 class="font-headline-md text-headline-md text-primary">Supervisory Authorization</h2>
                                    </div>
                                    <span class="font-label-sm text-label-sm px-2 py-0.5 rounded bg-tertiary-fixed text-on-tertiary-fixed font-bold">AWAITING KEY</span>
                                </div>
                                <span class="font-body-sm text-body-sm text-on-surface-variant">Designated Evaluator: <strong>Senior Instructor Petrov (Faculty Chair)</strong></span>
                            </div>
                            <div class="flex flex-col gap-space-sm p-space-md rounded-lg bg-surface-container-low">
                                <label class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant flex items-center justify-between">
                                    <span>Instructor Cryptographic Token / YubiKey Proof</span>
                                    <span class="text-primary font-code-sm text-code-sm">SYS-AUTH-G9</span>
                                </label>
                                <div class="flex items-center gap-2">
                                    <div class="relative flex-1">
                                        <span class="material-symbols-outlined absolute left-2.5 top-2 text-on-surface-variant text-[18px]">vpn_key</span>
                                        <input class="w-full pl-9 pr-3 py-1.5 rounded bg-surface-container-lowest text-on-surface font-code-sm text-code-sm outline-none focus:ring-2 focus:ring-primary shadow-sm" placeholder="Enter OTP or Cryptographic Auth Token..." readonly="" type="password" value="••••••••••••••••" />
                                    </div>
                                    <button class="px-3 py-1.5 rounded bg-primary text-on-primary font-label-md text-label-md shadow-sm hover:opacity-90 transition-opacity whitespace-nowrap">
                                        Verify Seal
                                    </button>
                                </div>
                                <div class="flex items-center justify-between font-label-sm text-label-sm text-on-surface-variant pt-1">
                                    <span>Instructor Role: Evaluator Alpha</span>
                                    <span>Security Ring: L3</span>
                                </div>
                            </div>
                            <!-- Supervisory Action CTA -->
                            <div class="flex flex-col gap-2 pt-space-xs">
                                <button class="w-full py-2 px-4 rounded bg-primary-container text-on-primary font-label-md text-label-md font-bold flex items-center justify-center gap-2 shadow-sm hover:opacity-95 transition-opacity">
                                    <span class="material-symbols-outlined text-[18px]">draw</span>
                                    <span>Grant Instructor Pedagogical Sign-Off</span>
                                </button>
                                <button class="w-full py-1.5 px-4 rounded bg-surface-container text-on-surface-variant hover:text-error hover:bg-surface-container-high font-label-md text-label-md flex items-center justify-center gap-1.5 transition-colors">
                                    <span class="material-symbols-outlined text-[16px]">cancel</span>
                                    <span>Reject Candidate &amp; Reopen Ticket</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Recommended Next Actions & Downstream Integration Trays -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-space-md">
                    <!-- Action Card 1: Canary Deployment Hand-off -->
                    <div class="p-space-lg rounded-xl bg-surface-container-lowest shadow-sm flex flex-col justify-between gap-space-md">
                        <div class="flex flex-col gap-space-xs">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-[20px] text-primary">rocket_launch</span>
                                    <span class="font-headline-sm text-headline-sm text-primary">Staging Route: Canary Deployment</span>
                                </div>
                                <span class="font-label-sm text-label-sm px-2 py-0.5 rounded bg-secondary-fixed text-on-secondary-fixed font-bold">READY (GATE 01)</span>
                            </div>
                            <p class="font-body-sm text-body-sm text-on-surface-variant">
                                Model candidate passed all 10 deterministic gates. Staging orchestrator has pre-provisioned cold pods for a <strong>10% traffic split gate</strong> in <em>SYS-AI-04 / Deployment Configuration</em>.
                            </p>
                        </div>
                        <div class="flex items-center justify-between pt-space-xs border-t border-surface-container-highest">
                            <span class="font-code-sm text-code-sm text-on-surface-variant">TARGET: /v2/predict/churn</span>
                            <button class="flex items-center gap-1.5 px-3 py-1.5 rounded bg-surface-container text-primary font-label-md text-label-md hover:bg-surface-container-high transition-colors">
                                <span>Configure 10% Canary</span>
                                <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                            </button>
                        </div>
                    </div>
                    <!-- Action Card 2: AI SOC & Governance Registry Hand-off -->
                    <div class="p-space-lg rounded-xl bg-surface-container-lowest shadow-sm flex flex-col justify-between gap-space-md">
                        <div class="flex flex-col gap-space-xs">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-[20px] text-primary">security</span>
                                    <span class="font-headline-sm text-headline-sm text-primary">Governance &amp; SYS-AI-05 Synch</span>
                                </div>
                                <span class="font-label-sm text-label-sm px-2 py-0.5 rounded bg-secondary-fixed text-on-secondary-fixed font-bold">READY TO ARCHIVE</span>
                            </div>
                            <p class="font-body-sm text-body-sm text-on-surface-variant">
                                Audit proof package is packaged with immutable SHA-256 manifest and signed seed runs. Prepared for continuous monitoring telemetry broadcast in <em>SYS-AI-05 AI SOC</em>.
                            </p>
                        </div>
                        <div class="flex items-center justify-between pt-space-xs border-t border-surface-container-highest">
                            <span class="font-code-sm text-code-sm text-on-surface-variant">LEDGER-TX: #TX-VP-48209-C</span>
                            <button class="flex items-center gap-1.5 px-3 py-1.5 rounded bg-surface-container text-primary font-label-md text-label-md hover:bg-surface-container-high transition-colors">
                                <span>Submit to SYS-AI-05 SOC</span>
                                <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Inline Telemetry Verification Footer Excerpt -->
                <div class="flex flex-wrap items-center justify-between p-space-md rounded-xl bg-surface-container text-on-surface-variant font-code-sm text-code-sm">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-primary"></span>
                        <span>VOSTOKPRIBOR HIGH-PRECISION RUNTIME // PROTOCOL: VP-ML-RFC-410</span>
                    </div>
                    <div class="flex items-center gap-4">
                        <span>CONSENSUS NODE: <strong>ORBIT-ML-NODE-4</strong></span>
                        <span>LATENCY GATEWAY: <strong>14ms</strong></span>
                        <span>VALIDATION REVISION: <strong>REV 4.2.1</strong></span>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="js/main.js"></script>
</body>

</html>