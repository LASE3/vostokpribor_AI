<?php
require_once __DIR__ . '/../config/config.php';
apply_perf_headers();
?>
<!DOCTYPE html>

<html class="dark" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="web_dashboard" name="shell-type" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&amp;family=Inter:wght@400;500;600;700&amp;family=Space+Mono:wght@400;700&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/css/global.css" />
    <link rel="stylesheet" href="css/style.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="js/tailwind.config.js"></script>
</head>

<body class="bg-background font-body-md text-body-md text-on-surface grid-matrix min-h-screen">
    <aside class="fixed left-0 top-0 h-full w-72 bg-surface-container-lowest z-50 flex flex-col justify-between shadow-[0_1px_8px_rgba(0,0,0,0.4)]">
        <div class="flex flex-col">
            <div class="h-16 px-space-md flex items-center justify-between bg-surface-container-low">
                <div class="flex items-center gap-space-sm"><img alt="VOSTOKPRIBOR AI SOC Logo" class="h-8 w-auto object-contain" src="https://lh3.googleusercontent.com/aida/AEtjO1W44MsHok8wFPOND_GUndULDEb9Wlf7x1VGBOEHm0xm1lbWb8oILr8x1T0OdWrOIdez65-cNTVESF7hxNycCR7uZXrC0rS38wfBjIQXlirTeA_MPjISLjdhKsmkws1_2pP40drLel5PEenk17276tjZx9wXrjxZpqgvl46nr2waCD3OgD38I_Y4q0WtMQIoITZ9yiEzvmB3XHJyzKp-2d2yaoZIxjkzYqtwUyys6MluIuULxUsSqrrQHmk" />
                    <div class="flex flex-col"><span class="font-headline-md text-headline-md tracking-tight text-primary leading-none">VOSTOKPRIBOR</span><span class="font-label-technical text-label-technical text-tertiary tracking-widest mt-space-xs uppercase">AI Mission Control</span></div>
                </div>
            </div>
            <div class="px-space-md py-space-sm bg-surface-container-high/40 flex items-center justify-between"><span class="font-label-technical text-label-technical text-on-surface-variant uppercase tracking-wider">System Pipelines</span><span class="font-label-code text-label-code text-secondary">NODE // 05</span></div>
            <nav class="flex flex-col px-space-xs py-space-sm gap-space-xs" data-active-classes="bg-primary-container text-on-surface border-l-2 border-tertiary"><a class="flex items-center justify-between px-space-md py-space-sm rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="project-hub" href="../AI Project Management/Dashboard.php"><span class="font-label-technical text-label-technical">SYS-AI-01: Objectives Hub</span><span class="font-label-code text-label-code text-outline">v1.2</span></a><a class="flex items-center justify-between px-space-md py-space-sm rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="data-lake" href="../Data Center/DatasetCatalog.php"><span class="font-label-technical text-label-technical">SYS-AI-02: Data Lake Lakeflow</span><span class="font-label-code text-label-code text-outline">4.8TB</span></a><a class="flex items-center justify-between px-space-md py-space-sm rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="model-workbench" href="../AI/ML Workbench/WorkbenchHome.php"><span class="font-label-technical text-label-technical">SYS-AI-03: Model Workbench</span><span class="font-label-code text-label-code text-outline">READY</span></a><a class="flex items-center justify-between px-space-md py-space-sm rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="model-registry" href="../Model Registry & Deployment/ModelRegistry.php"><span class="font-label-technical text-label-technical">SYS-AI-04: Registry &amp; CI/CD</span><span class="font-label-code text-label-code text-outline">PROD</span></a><a class="flex items-center justify-between px-space-md py-space-sm rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="soc-overview-fleet-telemetry" href="FleetTelemetry.php">
                    <div class="flex items-center gap-space-sm"><span class="w-2 h-2 rounded-full bg-tertiary animate-pulse"></span><span class="font-label-technical text-label-technical font-semibold text-primary">SYS-AI-05: AI SOC</span></div><span class="px-space-xs py-0.5 rounded text-[10px] font-metric-sm font-bold bg-error-container text-on-error-container uppercase tracking-wider">CRIT</span>
                </a></nav>
        </div>
        <div class="flex flex-col bg-surface-container-low p-space-md gap-space-sm">
            <div class="flex items-center justify-between bg-surface-container-lowest px-space-sm py-space-xs rounded">
                <div class="flex items-center gap-space-xs"><span class="w-1.5 h-1.5 rounded-full bg-secondary-fixed"></span><span class="font-label-code text-label-code text-on-surface-variant">UPLINK NOMINAL</span></div><span class="font-label-code text-label-code text-tertiary">12ms</span>
            </div>
            <div class="flex items-center justify-between font-label-code text-label-code text-on-surface-variant pt-space-xs"><a class="hover:text-primary transition-colors" data-path="system-docs" href="#">SYSTEM_DOCS.MD</a><a class="hover:text-primary transition-colors" data-path="api-terminal" href="#">API_TERM://05</a></div>
        </div>
    </aside>
    <div class="pl-72">
        <header class="fixed top-0 left-72 right-0 h-28 bg-surface-container-lowest/90 backdrop-blur-xl z-40 flex flex-col justify-between shadow-[0_1px_8px_rgba(0,0,0,0.5)]">
            <div class="h-14 px-gutter-desktop flex items-center justify-between gap-space-md">
                <div class="flex items-center gap-space-md flex-1">
                    <div class="relative flex items-center max-w-md w-full"><span class="material-symbols-outlined text-outline absolute left-space-sm text-[18px]">filter_center_focus</span><input class="w-full bg-surface-container-low text-on-surface font-label-code text-label-code pl-9 pr-14 py-space-xs rounded outline-none focus:ring-1 focus:ring-secondary text-ellipsis" placeholder="Filter models, incident IDs, or drift metrics... /" type="text" /><span class="absolute right-space-sm font-label-code text-[10px] text-outline bg-surface-container-high px-1 rounded">CTRL+K</span></div>
                    <div class="hidden xl:flex items-center gap-space-xs bg-error-container/30 px-space-sm py-space-xs rounded"><span class="w-2 h-2 rounded-full bg-error animate-ping"></span><span class="font-label-code text-label-code text-error tracking-tight font-semibold">INC-4092 CRITICAL: churn_rf_v2 (F1 0.87 -&gt; 0.61 &lt; 0.80 SLA)</span></div>
                </div>
                <div class="flex items-center gap-space-md">
                    <div class="hidden md:flex items-center bg-surface-container-low px-space-sm py-1 rounded text-on-surface-variant gap-space-xs"><span class="font-label-technical text-label-technical text-outline uppercase">Role:</span><span class="font-label-code text-label-code text-primary font-bold">Intern AI Eng · L3</span></div><button class="font-label-code text-label-code px-space-sm py-1 bg-surface-container-high text-on-surface-variant rounded hover:text-on-surface">EN / AR</button>
                    <div class="relative flex items-center justify-center p-1.5 rounded bg-surface-container-low text-on-surface-variant hover:text-on-surface"><span class="material-symbols-outlined text-[20px]">notifications</span><span class="absolute -top-1 -right-1 font-label-code text-[10px] w-4 h-4 bg-tertiary text-on-tertiary font-bold rounded-full flex items-center justify-center">3</span></div>
                    <div class="flex items-center gap-space-sm pl-space-xs">
                        <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center"><span class="material-symbols-outlined text-on-primary text-[18px]">person</span></div>
                        <div class="hidden lg:flex flex-col"><span class="font-label-code text-label-code text-on-surface leading-tight">Alexei V.</span><span class="font-label-technical text-[10px] text-tertiary leading-none uppercase">ON-DUTY</span></div>
                    </div>
                </div>
            </div>
            <div class="h-14 px-gutter-desktop bg-surface-container flex items-center justify-between overflow-x-auto gap-space-sm">
                <div class="flex items-center gap-1.5 shrink-0"><span class="font-label-technical text-[10px] text-outline uppercase tracking-widest mr-1">ML Ops Loop:</span>
                    <div class="flex items-center gap-1 text-[10px] font-label-code text-outline"><span class="px-1.5 py-0.5 rounded bg-surface-container-low text-outline">01.PRB</span><span class="px-1.5 py-0.5 rounded bg-surface-container-low text-outline">02.DAT</span><span class="px-1.5 py-0.5 rounded bg-surface-container-low text-outline">03.ING</span><span class="px-1.5 py-0.5 rounded bg-surface-container-low text-outline">04.EDA</span><span class="px-1.5 py-0.5 rounded bg-surface-container-low text-outline">05.FTR</span><span class="px-1.5 py-0.5 rounded bg-surface-container-low text-outline">06.TRN</span><span class="px-1.5 py-0.5 rounded bg-surface-container-low text-outline">07.TUN</span><span class="px-1.5 py-0.5 rounded bg-surface-container-low text-outline">08.VAL</span><span class="px-1.5 py-0.5 rounded bg-surface-container-low text-outline">09.REG</span><span class="px-1.5 py-0.5 rounded bg-surface-container-low text-outline">10.PKG</span><span class="px-1.5 py-0.5 rounded bg-surface-container-low text-outline">11.DEP</span></div><span class="material-symbols-outlined text-outline text-[14px] mx-1">arrow_forward</span>
                    <div class="flex items-center gap-1.5 text-[10px] font-label-code"><span class="px-2 py-0.5 rounded bg-surface-container-highest text-secondary font-bold flex items-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>12.TELEMETRY</span><span class="px-2 py-0.5 rounded bg-tertiary-container text-tertiary font-bold flex items-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-tertiary animate-pulse"></span>13.DRIFT &amp; INCIDENT</span><span class="px-2 py-0.5 rounded bg-surface-container-highest text-primary font-bold">14.RETRAIN LOOP</span></div>
                </div>
                <nav class="flex items-center gap-space-md shrink-0 h-full" data-active-classes="text-tertiary border-b-2 border-tertiary font-semibold"><a class="text-on-surface-variant hover:text-on-surface h-full flex items-center font-label-code text-label-code transition-colors" data-path="soc-overview-fleet-telemetry" href="FleetTelemetry.php">Fleet Overview</a><a class="text-on-surface-variant hover:text-on-surface h-full flex items-center font-label-code text-label-code transition-colors" data-path="alerts-center-incident-triage" href="IncidentTriage.php">Alerts Center (3)</a><a aria-current="page" class="h-full flex items-center transition-colors text-tertiary border-b-2 border-tertiary font-semibold" data-path="model-monitoring-detail" href="ModelMonitoringDetail.php">Model Monitoring</a><a class="text-on-surface-variant hover:text-on-surface h-full flex items-center font-label-code text-label-code transition-colors" data-path="drift-investigation-workspace" href="DriftInvestigationWorkspace.php">Drift Investigation</a><a class="text-on-surface-variant hover:text-on-surface h-full flex items-center font-label-code text-label-code transition-colors" data-path="active-incident" href="IncidentWarRoom.php">INC-4092 War Room</a><a class="text-on-surface-variant hover:text-on-surface h-full flex items-center font-label-code text-label-code transition-colors" data-path="alert-rules-config" href="AlertRulesAndDriftConfiguration.php">Config</a></nav>
            </div>
        </header>
        <main class="relative pt-28 w-full p-gutter-desktop bg-transparent">
            <div class="flex flex-col w-full gap-space-lg">
                <!-- TOP CONTEXT BAR: Model identity, status, metadata & actions -->
                <div class="bg-surface-container-low rounded-xl p-space-md shadow-md flex flex-col gap-space-md">
                    <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-space-md">
                        <!-- Model Title + Badges -->
                        <div class="flex flex-wrap items-center gap-space-sm">
                            <div class="flex items-center gap-space-xs">
                                <span class="w-3 h-3 rounded-full bg-error animate-ping"></span>
                                <h1 class="font-headline-lg text-headline-lg text-primary tracking-tight">churn_rf_v2</h1>
                                <span class="font-label-code text-label-code px-2 py-0.5 rounded bg-surface-container-high text-secondary font-bold">v2.4.1</span>
                            </div>
                            <div class="flex items-center gap-1.5 px-2.5 py-1 rounded bg-error-container text-on-error-container">
                                <span class="material-symbols-outlined text-[16px] text-error">warning</span>
                                <span class="font-label-technical text-label-technical uppercase tracking-wider text-error font-bold">CRITICAL BREACH // INC-4092</span>
                            </div>
                            <div class="flex items-center gap-1.5 px-2 py-1 rounded bg-surface-container-high text-on-surface-variant">
                                <span class="w-2 h-2 rounded-full bg-tertiary"></span>
                                <span class="font-label-technical text-label-technical uppercase tracking-wider">DRILL SCENARIO 07 · L3 CERT</span>
                            </div>
                        </div>
                        <!-- Quick Action Controls -->
                        <div class="flex flex-wrap items-center gap-space-xs">
                            <button class="flex items-center gap-1.5 px-space-sm py-1.5 rounded bg-error-container hover:bg-error/30 text-on-error-container transition-all">
                                <span class="material-symbols-outlined text-[16px] text-error">campaign</span>
                                <span class="font-label-technical text-label-technical uppercase font-bold">Declare War Room</span>
                            </button>
                            <button class="flex items-center gap-1.5 px-space-sm py-1.5 rounded bg-secondary-container text-on-secondary-container hover:bg-secondary-container/80 transition-all">
                                <span class="material-symbols-outlined text-[16px]">history</span>
                                <span class="font-label-technical text-label-technical uppercase">Rollback Canary [v2.4.0]</span>
                            </button>
                            <button class="flex items-center gap-1.5 px-space-sm py-1.5 rounded bg-surface-container-high text-on-surface-variant hover:text-on-surface transition-all">
                                <span class="material-symbols-outlined text-[16px]">push_pin</span>
                                <span class="font-label-technical text-label-technical uppercase">Pin Snapshot</span>
                            </button>
                            <button class="flex items-center gap-1.5 px-space-sm py-1.5 rounded bg-surface-container-high text-on-surface-variant hover:text-on-surface transition-all">
                                <span class="material-symbols-outlined text-[16px]">download</span>
                                <span class="font-label-technical text-label-technical uppercase">CSV Export</span>
                            </button>
                        </div>
                    </div>
                    <!-- Telemetry Architecture Specs Strip -->
                    <div class="grid grid-cols-2 md:grid-cols-4 xl:grid-cols-6 gap-space-sm pt-space-xs">
                        <div class="flex flex-col bg-surface-container-lowest/80 px-space-sm py-1.5 rounded">
                            <span class="font-label-technical text-[10px] text-outline uppercase tracking-wider">Engine &amp; Framework</span>
                            <span class="font-label-code text-label-code text-on-surface truncate">RandomForest · Sklearn 1.4</span>
                        </div>
                        <div class="flex flex-col bg-surface-container-lowest/80 px-space-sm py-1.5 rounded">
                            <span class="font-label-technical text-[10px] text-outline uppercase tracking-wider">Serving Pod</span>
                            <span class="font-label-code text-label-code text-secondary truncate">prod-ml-c02 (EUS-PROD-01)</span>
                        </div>
                        <div class="flex flex-col bg-surface-container-lowest/80 px-space-sm py-1.5 rounded">
                            <span class="font-label-technical text-[10px] text-outline uppercase tracking-wider">Inference Endpoint</span>
                            <span class="font-label-code text-label-code text-on-surface truncate">POST /v2/predict/churn</span>
                        </div>
                        <div class="flex flex-col bg-surface-container-lowest/80 px-space-sm py-1.5 rounded">
                            <span class="font-label-technical text-[10px] text-outline uppercase tracking-wider">Upstream Feed Pipe</span>
                            <span class="font-label-code text-label-code text-tertiary truncate">CRM-FEED-05 (Kafka topic)</span>
                        </div>
                        <div class="flex flex-col bg-surface-container-lowest/80 px-space-sm py-1.5 rounded">
                            <span class="font-label-technical text-[10px] text-outline uppercase tracking-wider">Ground Truth Delay</span>
                            <span class="font-label-code text-label-code text-on-surface truncate">~10 min stream-join lag</span>
                        </div>
                        <div class="flex flex-col bg-surface-container-lowest/80 px-space-sm py-1.5 rounded">
                            <span class="font-label-technical text-[10px] text-outline uppercase tracking-wider">Active Baseline Run</span>
                            <span class="font-label-code text-label-code text-on-surface-variant truncate">RUN-2024-Q1-BL-09</span>
                        </div>
                    </div>
                    <!-- Time Window Selector & Granularity Bar -->
                    <div class="flex flex-wrap items-center justify-between gap-space-sm pt-space-xs">
                        <div class="flex items-center gap-space-xs bg-surface-container-lowest p-1 rounded">
                            <button class="px-space-sm py-1 rounded bg-surface-container-high text-primary font-label-code text-label-code font-bold">Last 24 Hours</button>
                            <button class="px-space-sm py-1 rounded text-on-surface-variant hover:text-on-surface font-label-code text-label-code transition-colors">Last 6 Hours</button>
                            <button class="px-space-sm py-1 rounded text-on-surface-variant hover:text-on-surface font-label-code text-label-code transition-colors">Last 7 Days</button>
                            <button class="px-space-sm py-1 rounded text-on-surface-variant hover:text-on-surface font-label-code text-label-code transition-colors">Custom Range...</button>
                        </div>
                        <div class="flex items-center gap-space-md">
                            <div class="flex items-center gap-space-xs">
                                <span class="font-label-technical text-label-technical text-outline uppercase">Granularity:</span>
                                <span class="font-label-code text-label-code text-secondary px-2 py-0.5 rounded bg-surface-container-lowest">5m intervals</span>
                            </div>
                            <div class="flex items-center gap-space-xs bg-surface-container-lowest px- space-sm px-2 py-1 rounded">
                                <span class="w-2 h-2 rounded-full bg-secondary-fixed animate-pulse"></span>
                                <span class="font-label-code text-[11px] text-on-surface-variant">Live Poll (5s)</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- KEY PERFORMANCE METRICS: 6 Bento Tiles -->
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-space-md">
                    <!-- KPI 1: F1 Score (CRITICAL) -->
                    <div class="bg-error-container/20 p-space-md rounded-xl shadow-sm flex flex-col justify-between relative overflow-hidden">
                        <div class="absolute -top-6 -right-6 w-20 h-20 rounded-full bg-error/10 blur-xl pointer-events-none"></div>
                        <div class="flex items-center justify-between">
                            <span class="font-label-technical text-label-technical text-error uppercase font-bold tracking-wider">Current F1 Score</span>
                            <span class="font-label-code text-[10px] text-error font-bold px-1 rounded bg-error-container/60">SLA 0.80</span>
                        </div>
                        <div class="my-space-sm">
                            <div class="font-metric-display text-metric-display text-error leading-none">0.61</div>
                            <div class="font-label-code text-[11px] text-error flex items-center gap-1 mt-1">
                                <span class="material-symbols-outlined text-[14px]">trending_down</span>
                                <span>-29.8% (BL 0.87)</span>
                            </div>
                        </div>
                        <div class="w-full bg-surface-container-lowest h-1.5 rounded-full overflow-hidden">
                            <div class="bg-error h-full rounded-full" style="width: 61%;"></div>
                        </div>
                    </div>
                    <!-- KPI 2: Precision -->
                    <div class="bg-surface-container-low p-space-md rounded-xl shadow-sm flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <span class="font-label-technical text-label-technical text-outline uppercase tracking-wider">Precision</span>
                            <span class="font-label-code text-[10px] text-outline">Target ≥0.78</span>
                        </div>
                        <div class="my-space-sm">
                            <div class="font-metric-display text-metric-display text-tertiary leading-none">0.58</div>
                            <div class="font-label-code text-[11px] text-tertiary flex items-center gap-1 mt-1">
                                <span class="material-symbols-outlined text-[14px]">trending_down</span>
                                <span>-25.6% vs Base</span>
                            </div>
                        </div>
                        <div class="w-full bg-surface-container-lowest h-1.5 rounded-full overflow-hidden">
                            <div class="bg-tertiary h-full rounded-full" style="width: 58%;"></div>
                        </div>
                    </div>
                    <!-- KPI 3: Recall -->
                    <div class="bg-surface-container-low p-space-md rounded-xl shadow-sm flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <span class="font-label-technical text-label-technical text-outline uppercase tracking-wider">Recall</span>
                            <span class="font-label-code text-[10px] text-outline">Target ≥0.82</span>
                        </div>
                        <div class="my-space-sm">
                            <div class="font-metric-display text-metric-display text-tertiary leading-none">0.64</div>
                            <div class="font-label-code text-[11px] text-tertiary flex items-center gap-1 mt-1">
                                <span class="material-symbols-outlined text-[14px]">trending_down</span>
                                <span>-21.9% vs Base</span>
                            </div>
                        </div>
                        <div class="w-full bg-surface-container-lowest h-1.5 rounded-full overflow-hidden">
                            <div class="bg-tertiary h-full rounded-full" style="width: 64%;"></div>
                        </div>
                    </div>
                    <!-- KPI 4: Throughput -->
                    <div class="bg-surface-container-low p-space-md rounded-xl shadow-sm flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <span class="font-label-technical text-label-technical text-outline uppercase tracking-wider">Throughput</span>
                            <span class="font-label-code text-[10px] text-secondary">Nominal</span>
                        </div>
                        <div class="my-space-sm">
                            <div class="font-metric-display text-metric-display text-primary leading-none">1,420</div>
                            <div class="font-label-code text-[11px] text-secondary flex items-center gap-1 mt-1">
                                <span class="material-symbols-outlined text-[14px]">check</span>
                                <span>rpm (BL 1,400)</span>
                            </div>
                        </div>
                        <div class="w-full bg-surface-container-lowest h-1.5 rounded-full overflow-hidden">
                            <div class="bg-secondary h-full rounded-full" style="width: 71%;"></div>
                        </div>
                    </div>
                    <!-- KPI 5: p95 Latency -->
                    <div class="bg-surface-container-low p-space-md rounded-xl shadow-sm flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <span class="font-label-technical text-label-technical text-outline uppercase tracking-wider">p95 Latency</span>
                            <span class="font-label-code text-[10px] text-outline">SLA ≤80ms</span>
                        </div>
                        <div class="my-space-sm">
                            <div class="font-metric-display text-metric-display text-secondary leading-none">48<span class="font-metric-sm text-metric-sm text-outline">ms</span></div>
                            <div class="font-label-code text-[11px] text-secondary flex items-center gap-1 mt-1">
                                <span class="material-symbols-outlined text-[14px]">speed</span>
                                <span>Optimal speed</span>
                            </div>
                        </div>
                        <div class="w-full bg-surface-container-lowest h-1.5 rounded-full overflow-hidden">
                            <div class="bg-secondary-fixed h-full rounded-full" style="width: 60%;"></div>
                        </div>
                    </div>
                    <!-- KPI 6: Error Rate -->
                    <div class="bg-surface-container-low p-space-md rounded-xl shadow-sm flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <span class="font-label-technical text-label-technical text-outline uppercase tracking-wider">Error Rate (5xx)</span>
                            <span class="font-label-code text-[10px] text-secondary">Healthy</span>
                        </div>
                        <div class="my-space-sm">
                            <div class="font-metric-display text-metric-display text-primary leading-none">0.02<span class="font-metric-sm text-metric-sm text-outline">%</span></div>
                            <div class="font-label-code text-[11px] text-secondary flex items-center gap-1 mt-1">
                                <span class="material-symbols-outlined text-[14px]">done_all</span>
                                <span>Infra stable</span>
                            </div>
                        </div>
                        <div class="w-full bg-surface-container-lowest h-1.5 rounded-full overflow-hidden">
                            <div class="bg-secondary-fixed-dim h-full rounded-full" style="width: 2%;"></div>
                        </div>
                    </div>
                </div>
                <!-- GROUND TRUTH DELAY BANNER -->
                <div class="bg-surface-container-high/60 rounded-lg p-space-sm px-space-md flex flex-wrap items-center justify-between gap-space-sm">
                    <div class="flex items-center gap-space-sm">
                        <span class="material-symbols-outlined text-tertiary text-[18px]">sync_problem</span>
                        <span class="font-label-code text-label-code text-on-surface">Labels verified via 10-minute delayed stream from Lakeflow SYS-AI-02 (CRM event resolution stream). Real-time accuracy metrics reflected through <span class="text-tertiary font-bold">04:40 UTC</span>.</span>
                    </div>
                    <span class="font-label-technical text-[10px] text-outline uppercase">STREAM STATUS: SYNCED · 99.8% JOIN RATE</span>
                </div>
                <!-- MAIN TIME-SERIES TELEMETRY CHARTS SECTION -->
                <div class="grid grid-cols-1 xl:grid-cols-12 gap-space-md">
                    <!-- HERO CHART: F1 Score Timeline (Col 8) -->
                    <div class="xl:col-span-8 bg-surface-container-low rounded-xl p-space-md shadow-md flex flex-col gap-space-sm">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-space-xs">
                            <div>
                                <h2 class="font-headline-md text-headline-md text-primary">F1 Score &amp; Precision/Recall Timeline</h2>
                                <span class="font-label-technical text-label-technical text-outline uppercase">Rolling 24-Hour Continuous Telemetry · Resolution: 5 Min</span>
                            </div>
                            <div class="flex items-center gap-space-sm text-[11px] font-label-code">
                                <div class="flex items-center gap-1.5">
                                    <span class="w-3 h-0.5 bg-error"></span>
                                    <span class="text-on-surface-variant">F1 Score</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="w-3 h-0.5 bg-tertiary"></span>
                                    <span class="text-on-surface-variant">Precision</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="w-3 h-0.5 bg-secondary"></span>
                                    <span class="text-on-surface-variant">Recall</span>
                                </div>
                            </div>
                        </div>
                        <!-- SVG Chart Canvas Area -->
                        <div class="relative w-full h-72 bg-surface-container-lowest rounded-lg p-space-sm flex flex-col justify-between overflow-hidden">
                            <!-- Chart Incident Annotation Layer -->
                            <div class="absolute left-[62%] top-2 bottom-6 w-px bg-error flex flex-col justify-start items-center z-10">
                                <div class="bg-error text-on-error px-2 py-0.5 rounded text-[10px] font-label-code font-bold whitespace-nowrap shadow-lg -translate-x-1/2">
                                    04:18 UTC: INC-4092 Triggered
                                </div>
                                <div class="bg-error-container/80 text-error px-2 py-0.5 rounded text-[9px] font-label-code whitespace-nowrap mt-1 -translate-x-1/2">
                                    Ingestion Pipeline Schema Anomaly suspected
                                </div>
                            </div>
                            <svg class="w-full h-full overflow-visible" preserveaspectratio="none" viewbox="0 0 1000 240">
                                <defs>
                                    <lineargradient id="f1Grad" x1="0%" x2="0%" y1="0%" y2="100%">
                                        <stop offset="0%" stop-color="#ffb4ab" stop-opacity="0.25"></stop>
                                        <stop offset="100%" stop-color="#ffb4ab" stop-opacity="0.0"></stop>
                                    </lineargradient>
                                </defs>
                                <!-- Horizontal Grid Lines & Y-Axis Labels -->
                                <line stroke="#43474c" stroke-dasharray="2,4" stroke-opacity="0.3" x1="40" x2="980" y1="20" y2="20"></line>
                                <text fill="#8e9197" font-family="Space Mono" font-size="10" x="5" y="24">1.00</text>
                                <!-- Historical Baseline line (0.87) -->
                                <line stroke="#b4c8e3" stroke-dasharray="3,3" stroke-opacity="0.6" stroke-width="1.5" x1="40" x2="980" y1="46" y2="46"></line>
                                <text fill="#b4c8e3" font-family="Space Mono" font-size="9" x="45" y="42">HISTORICAL BASELINE (0.87)</text>
                                <!-- SLA Critical Threshold (0.80) -->
                                <line stroke="#ffb4ab" stroke-dasharray="5,5" stroke-opacity="0.9" stroke-width="1.5" x1="40" x2="980" y1="62" y2="62"></line>
                                <text fill="#ffb4ab" font-family="Space Mono" font-size="9" font-weight="700" x="45" y="58">SLA BREACH THRESHOLD (0.80)</text>
                                <line stroke="#43474c" stroke-dasharray="2,4" stroke-opacity="0.3" x1="40" x2="980" y1="104" y2="104"></line>
                                <text fill="#8e9197" font-family="Space Mono" font-size="10" x="5" y="108">0.60</text>
                                <line stroke="#43474c" stroke-dasharray="2,4" stroke-opacity="0.3" x1="40" x2="980" y1="146" y2="146"></line>
                                <text fill="#8e9197" font-family="Space Mono" font-size="10" x="5" y="150">0.40</text>
                                <line stroke="#43474c" stroke-dasharray="2,4" stroke-opacity="0.3" x1="40" x2="980" y1="188" y2="188"></line>
                                <text fill="#8e9197" font-family="Space Mono" font-size="10" x="5" y="192">0.20</text>
                                <!-- Precision Line (Yellow/Tertiary) -->
                                <path d="M 40 46 Q 200 48 350 45 T 550 47 L 570 70 L 620 98 L 700 108 L 850 110 L 980 112" fill="none" stroke="#ffb956" stroke-opacity="0.8" stroke-width="1.5"></path>
                                <!-- Recall Line (Secondary Blue) -->
                                <path d="M 40 45 Q 220 44 380 46 T 550 48 L 570 65 L 620 88 L 700 95 L 850 96 L 980 97" fill="none" stroke="#abc9f2" stroke-opacity="0.8" stroke-width="1.5"></path>
                                <!-- F1 Score Main Area Fill -->
                                <polygon fill="url(#f1Grad)" points="40,46 200,45 350,47 500,46 550,48 580,78 620,102 700,103 850,103 980,103 980,210 40,210"></polygon>
                                <!-- F1 Score Main Curve (Red Alert) -->
                                <path d="M 40 46 Q 200 45 350 47 T 500 46 T 550 48 L 580 78 L 620 102 L 700 103 L 850 103 L 980 103" fill="none" stroke="#ffb4ab" stroke-width="2.5"></path>
                                <!-- Data Points -->
                                <circle cx="550" cy="48" fill="#ffb4ab" r="3"></circle>
                                <circle cx="580" cy="78" fill="#ffb4ab" r="3"></circle>
                                <circle cx="620" cy="102" fill="#ffb4ab" r="5" stroke="#93000a" stroke-width="2"></circle>
                                <circle cx="980" cy="103" fill="#ffb4ab" r="4"></circle>
                                <!-- Time Labels on X-Axis -->
                                <text fill="#8e9197" font-family="Space Mono" font-size="10" x="40" y="228">05:00</text>
                                <text fill="#8e9197" font-family="Space Mono" font-size="10" x="200" y="228">11:00</text>
                                <text fill="#8e9197" font-family="Space Mono" font-size="10" x="380" y="228">17:00</text>
                                <text fill="#8e9197" font-family="Space Mono" font-size="10" x="550" y="228">03:45 (Drift begins)</text>
                                <text fill="#ffb4ab" font-family="Space Mono" font-size="10" font-weight="700" x="620" y="228">04:18 (Trigger)</text>
                                <text fill="#8e9197" font-family="Space Mono" font-size="10" x="800" y="228">04:45</text>
                                <text fill="#8e9197" font-family="Space Mono" font-size="10" x="950" y="228">NOW</text>
                            </svg>
                        </div>
                        <!-- Quick Timeline Context Details -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-space-sm pt-space-xs text-on-surface-variant font-label-code text-[11px]">
                            <div class="flex items-center gap-space-xs">
                                <span class="w-1.5 h-1.5 rounded-full bg-secondary-fixed"></span>
                                <span>Pre-incident Stability: <strong>14.2h @ F1=0.871</strong></span>
                            </div>
                            <div class="flex items-center gap-space-xs text-error">
                                <span class="w-1.5 h-1.5 rounded-full bg-error"></span>
                                <span>Max Drift Velocity: <strong>-0.12 F1 / hour</strong></span>
                            </div>
                            <div class="flex items-center gap-space-xs">
                                <span class="w-1.5 h-1.5 rounded-full bg-tertiary"></span>
                                <span>Confidence Drop: <strong>92.4% → 64.1%</strong></span>
                            </div>
                        </div>
                    </div>
                    <!-- SIDE PANEL: Prediction Class Distribution Shift (Col 4) -->
                    <div class="xl:col-span-4 bg-surface-container-low rounded-xl p-space-md shadow-md flex flex-col justify-between gap-space-sm">
                        <div>
                            <div class="flex items-center justify-between">
                                <h2 class="font-headline-md text-headline-md text-primary">Class Distribution</h2>
                                <span class="font-label-technical text-label-technical text-error font-bold uppercase">Severe Skew</span>
                            </div>
                            <p class="font-label-technical text-label-technical text-outline uppercase mt-0.5">Historical (14.2% Churn) vs Current (48.9% Churn)</p>
                        </div>
                        <!-- Donut / Distribution Comparison Visual -->
                        <div class="bg-surface-container-lowest rounded-lg p-space-md flex flex-col gap-space-md">
                            <!-- Baseline Reference -->
                            <div>
                                <div class="flex justify-between font-label-code text-label-code mb-1">
                                    <span class="text-on-surface-variant">Baseline (Last 30 Days)</span>
                                    <span class="text-secondary">14.2% True / 85.8% False</span>
                                </div>
                                <div class="h-3 w-full bg-surface-container rounded-full flex overflow-hidden">
                                    <div class="bg-tertiary h-full" style="width: 14.2%;"></div>
                                    <div class="bg-secondary-container h-full" style="width: 85.8%;"></div>
                                </div>
                            </div>
                            <!-- Post-03:45 UTC Inverted Skew -->
                            <div>
                                <div class="flex justify-between font-label-code text-label-code mb-1">
                                    <span class="text-error font-bold">Post-03:45 UTC (Current)</span>
                                    <span class="text-error font-bold">48.9% True / 51.1% False</span>
                                </div>
                                <div class="h-3 w-full bg-surface-container rounded-full flex overflow-hidden">
                                    <div class="bg-error h-full" style="width: 48.9%;"></div>
                                    <div class="bg-secondary-container h-full" style="width: 51.1%;"></div>
                                </div>
                            </div>
                            <div class="p-space-sm bg-error-container/30 rounded text-error text-[11px] font-label-code flex items-start gap-space-xs">
                                <span class="material-symbols-outlined text-[16px] shrink-0 mt-0.5">crisis_alert</span>
                                <span>Model is drastically over-predicting Churn=True by +244% over baseline, indicative of unhandled categorical NULL encoding or corrupted account tenure column.</span>
                            </div>
                        </div>
                        <!-- Quick Feature Drift Ranking Snapshot -->
                        <div class="flex flex-col gap-1.5 pt-space-xs">
                            <span class="font-label-technical text-label-technical text-outline uppercase tracking-wider">Top Drifted Features (PSI score)</span>
                            <div class="flex items-center justify-between text-[11px] font-label-code bg-surface-container-lowest px-2 py-1 rounded">
                                <span class="text-error">contract_tenure_months</span>
                                <span class="text-error font-bold">PSI: 0.482 (High Drift)</span>
                            </div>
                            <div class="flex items-center justify-between text-[11px] font-label-code bg-surface-container-lowest px-2 py-1 rounded">
                                <span class="text-tertiary">monthly_billing_usd</span>
                                <span class="text-tertiary font-bold">PSI: 0.219 (Moderate)</span>
                            </div>
                            <div class="flex items-center justify-between text-[11px] font-label-code bg-surface-container-lowest px-2 py-1 rounded">
                                <span class="text-secondary">active_service_tickets</span>
                                <span class="text-secondary">PSI: 0.041 (Normal)</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- SECONDARY ROW: Latency/Throughput Stability & Segment Breakdown -->
                <div class="grid grid-cols-1 xl:grid-cols-12 gap-space-md">
                    <!-- THIRD CHART: Inference Latency Bands vs Throughput (Col 5) -->
                    <div class="xl:col-span-5 bg-surface-container-low rounded-xl p-space-md shadow-md flex flex-col justify-between gap-space-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="font-headline-md text-headline-md text-primary">Inference Latency &amp; Infra</h2>
                                <span class="font-label-technical text-label-technical text-outline uppercase">p50 / p90 / p95 / p99 Percentiles</span>
                            </div>
                            <span class="px-2 py-0.5 rounded bg-surface-container-high text-secondary text-[10px] font-label-code">INFRA STABLE</span>
                        </div>
                        <!-- SVG Latency Trend Chart -->
                        <div class="relative w-full h-44 bg-surface-container-lowest rounded-lg p-space-sm overflow-hidden flex flex-col justify-between">
                            <svg class="w-full h-full" preserveaspectratio="none" viewbox="0 0 500 140">
                                <!-- Latency Grid -->
                                <line stroke="#43474c" stroke-dasharray="2,4" stroke-opacity="0.3" x1="30" x2="480" y1="20" y2="20"></line>
                                <text fill="#8e9197" font-family="Space Mono" font-size="9" x="5" y="23">80ms</text>
                                <line stroke="#43474c" stroke-dasharray="2,4" stroke-opacity="0.3" x1="30" x2="480" y1="60" y2="60"></line>
                                <text fill="#8e9197" font-family="Space Mono" font-size="9" x="5" y="63">50ms</text>
                                <line stroke="#43474c" stroke-dasharray="2,4" stroke-opacity="0.3" x1="30" x2="480" y1="100" y2="100"></line>
                                <text fill="#8e9197" font-family="Space Mono" font-size="9" x="5" y="103">20ms</text>
                                <!-- SLA 80ms Red Dotted -->
                                <line stroke="#ffb4ab" stroke-dasharray="3,3" stroke-opacity="0.5" stroke-width="1" x1="30" x2="480" y1="20" y2="20"></line>
                                <!-- Latency Bands (Flat/Optimal throughout the incident period) -->
                                <!-- p99 (64ms) -->
                                <path d="M 30 42 Q 150 44 250 41 T 480 43" fill="none" stroke="#abc9f2" stroke-opacity="0.4" stroke-width="1.5"></path>
                                <!-- p95 (48ms) -->
                                <path d="M 30 62 Q 150 63 250 61 T 480 62" fill="none" stroke="#abc9f2" stroke-width="2"></path>
                                <!-- p50 (22ms) -->
                                <path d="M 30 96 Q 150 97 250 95 T 480 96" fill="none" stroke="#b4c8e3" stroke-dasharray="2,2" stroke-width="1"></path>
                            </svg>
                        </div>
                        <div class="flex items-center justify-between font-label-code text-[11px] bg-surface-container-lowest p-space-sm rounded text-on-surface-variant">
                            <div>p50: <span class="text-primary font-bold">22ms</span></div>
                            <div>p90: <span class="text-primary font-bold">41ms</span></div>
                            <div>p95: <span class="text-secondary font-bold">48ms</span></div>
                            <div>p99: <span class="text-secondary font-bold">64ms</span></div>
                            <div class="text-secondary">Throughput: <span class="text-primary font-bold">1,420 rpm</span></div>
                        </div>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">
                            Latency and resource metrics are entirely decoupled from the F1 collapse. This confirms a mathematical/drift anomaly inside the model feature distribution, rather than server throttling or hardware fault.
                        </p>
                    </div>
                    <!-- SLICE-BASED EVALUATION BREAKDOWN TABLE (Col 7) -->
                    <div class="xl:col-span-7 bg-surface-container-low rounded-xl p-space-md shadow-md flex flex-col justify-between gap-space-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="font-headline-md text-headline-md text-primary">Slice-Based Evaluation &amp; Cohort Breakdown</h2>
                                <span class="font-label-technical text-label-technical text-outline uppercase">Segmentation Isolation (Current Incident Window)</span>
                            </div>
                            <span class="font-label-code text-[11px] text-tertiary px-2 py-0.5 rounded bg-surface-container-high">3 SEVERE DEGRADATIONS</span>
                        </div>
                        <!-- Segment Table -->
                        <div class="overflow-x-auto">
                            <table class="w-full text-left font-label-code text-label-code border-collapse">
                                <thead>
                                    <tr class="bg-surface-container-lowest text-outline text-[11px] uppercase tracking-wider">
                                        <th class="p-space-sm rounded-l">Segment Slice</th>
                                        <th class="p-space-sm">Traffic Share</th>
                                        <th class="p-space-sm">Current F1</th>
                                        <th class="p-space-sm">Baseline F1</th>
                                        <th class="p-space-sm">Delta</th>
                                        <th class="p-space-sm rounded-r">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y-0 text-[12px]">
                                    <!-- Row 1: Account Age < 6mo (EPICENTER) -->
                                    <tr class="bg-error-container/20 text-on-surface hover:bg-error-container/30 transition-colors">
                                        <td class="p-space-sm font-bold text-error flex items-center gap-1.5">
                                            <span class="material-symbols-outlined text-[14px]">crisis_alert</span>
                                            Account Age &lt; 6 mo
                                        </td>
                                        <td class="p-space-sm text-on-surface-variant">34.8%</td>
                                        <td class="p-space-sm font-bold text-error">0.31</td>
                                        <td class="p-space-sm text-outline">0.86</td>
                                        <td class="p-space-sm text-error font-bold">-63.9%</td>
                                        <td class="p-space-sm">
                                            <span class="px-1.5 py-0.5 rounded text-[10px] font-bold bg-error text-on-error uppercase">EPICENTER</span>
                                        </td>
                                    </tr>
                                    <!-- Row 2: Month-to-month Contract -->
                                    <tr class="bg-surface-container hover:bg-surface-container-high transition-colors">
                                        <td class="p-space-sm font-medium text-tertiary">Contract: Month-to-Month</td>
                                        <td class="p-space-sm text-on-surface-variant">52.1%</td>
                                        <td class="p-space-sm font-bold text-tertiary">0.52</td>
                                        <td class="p-space-sm text-outline">0.84</td>
                                        <td class="p-space-sm text-tertiary">-38.1%</td>
                                        <td class="p-space-sm">
                                            <span class="px-1.5 py-0.5 rounded text-[10px] font-bold bg-tertiary-container text-tertiary uppercase">DEGRADED</span>
                                        </td>
                                    </tr>
                                    <!-- Row 3: Account Age 6-24mo -->
                                    <tr class="bg-surface-container-lowest/50 hover:bg-surface-container-high transition-colors">
                                        <td class="p-space-sm text-on-surface">Account Age 6-24 mo</td>
                                        <td class="p-space-sm text-on-surface-variant">41.2%</td>
                                        <td class="p-space-sm text-on-surface">0.76</td>
                                        <td class="p-space-sm text-outline">0.88</td>
                                        <td class="p-space-sm text-outline">-13.6%</td>
                                        <td class="p-space-sm">
                                            <span class="px-1.5 py-0.5 rounded text-[10px] font-bold bg-surface-container text-outline uppercase">MODERATE</span>
                                        </td>
                                    </tr>
                                    <!-- Row 4: Enterprise Accounts -->
                                    <tr class="bg-surface-container hover:bg-surface-container-high transition-colors">
                                        <td class="p-space-sm text-on-surface">Tier: Enterprise / SLA</td>
                                        <td class="p-space-sm text-on-surface-variant">18.4%</td>
                                        <td class="p-space-sm text-secondary font-bold">0.84</td>
                                        <td class="p-space-sm text-outline">0.89</td>
                                        <td class="p-space-sm text-secondary">-5.6%</td>
                                        <td class="p-space-sm">
                                            <span class="px-1.5 py-0.5 rounded text-[10px] font-bold bg-secondary-container text-secondary uppercase">NOMINAL</span>
                                        </td>
                                    </tr>
                                    <!-- Row 5: Account Age > 24mo -->
                                    <tr class="bg-surface-container-lowest/50 hover:bg-surface-container-high transition-colors">
                                        <td class="p-space-sm text-on-surface">Account Age &gt; 24 mo</td>
                                        <td class="p-space-sm text-on-surface-variant">24.0%</td>
                                        <td class="p-space-sm text-secondary font-bold">0.88</td>
                                        <td class="p-space-sm text-outline">0.90</td>
                                        <td class="p-space-sm text-secondary">-2.2%</td>
                                        <td class="p-space-sm">
                                            <span class="px-1.5 py-0.5 rounded text-[10px] font-bold bg-secondary-container text-secondary uppercase">NOMINAL</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="p-space-xs px-space-sm bg-surface-container-lowest rounded flex items-center justify-between text-[11px] font-label-code text-on-surface-variant">
                            <span>Insight: Anomaly is overwhelmingly concentrated in new cohort (&lt; 6 months) under monthly billing agreements.</span>
                            <button class="text-secondary hover:text-primary transition-colors flex items-center gap-1 font-bold">
                                Filter Telemetry to Slice <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- ACTION & INVESTIGATION FOOTER STRIP -->
                <div class="bg-surface-container rounded-xl p-space-md shadow-md flex flex-col md:flex-row items-center justify-between gap-space-md">
                    <div class="flex items-center gap-space-md">
                        <div class="w-10 h-10 rounded-lg bg-tertiary-container flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-tertiary text-[24px]">troubleshoot</span>
                        </div>
                        <div>
                            <div class="font-headline-md text-headline-md text-on-surface leading-tight">Next Step: Root-Cause Investigation</div>
                            <p class="font-body-sm text-body-sm text-on-surface-variant">
                                Isolate the exact drift vector in Evidently Studio workspace or review triage timeline with on-call architects.
                            </p>
                        </div>
                    </div>
                    <div class="flex flex-wrap items-center gap-space-sm shrink-0">
                        <a class="flex items-center gap-2 px-space-md py-2.5 rounded-lg bg-surface-container-highest hover:bg-surface-bright text-on-surface transition-all font-label-code text-label-code" data-path="drift-investigation-workspace" href="DriftInvestigationWorkspace.php">
                            <span class="material-symbols-outlined text-[18px] text-tertiary">analytics</span>
                            <span>Open Drift Investigation (Evidently)</span>
                        </a>
                        <a class="flex items-center gap-2 px-space-md py-2.5 rounded-lg bg-error hover:bg-error/90 text-on-error transition-all font-label-code text-label-code font-bold shadow-lg" data-path="active-incident" href="IncidentWarRoom.php">
                            <span class="material-symbols-outlined text-[18px]">group_work</span>
                            <span>Enter INC-4092 War Room</span>
                        </a>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="../assets/js/app.js"></script>
    <script src="js/main.js"></script>
</body>

</html>