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
            <nav class="flex flex-col px-space-xs py-space-sm gap-space-xs" data-active-classes="bg-primary-container text-on-surface border-l-2 border-tertiary"><a class="flex items-center justify-between px-space-md py-space-sm rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="project-hub" href="../AI Project Management/Dashboard.php"><span class="font-label-technical text-label-technical">SYS-AI-01: Objectives Hub</span><span class="font-label-code text-label-code text-outline">v1.2</span></a><a class="flex items-center justify-between px-space-md py-space-sm rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="data-lake" href="../Data Center/DatasetCatalog.php"><span class="font-label-technical text-label-technical">SYS-AI-02: Data Lake Lakeflow</span><span class="font-label-code text-label-code text-outline">4.8TB</span></a><a class="flex items-center justify-between px-space-md py-space-sm rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="model-workbench" href="../AI/ML Workbench/WorkbenchHome.php"><span class="font-label-technical text-label-technical">SYS-AI-03: Model Workbench</span><span class="font-label-code text-label-code text-outline">READY</span></a><a class="flex items-center justify-between px-space-md py-space-sm rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="model-registry" href="../Model Registry & Deployment/ModelRegistry.php"><span class="font-label-technical text-label-technical">SYS-AI-04: Registry &amp; CI/CD</span><span class="font-label-code text-label-code text-outline">PROD</span></a><a class="flex items-center justify-between px-space-md py-space-sm rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="soc-overview" href="FleetTelemetry.php">
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
                    <div class="hidden xl:flex items-center gap-space-xs bg-error-container/30 px-space-sm py-space-xs rounded"><span class="w-2 h-2 rounded-full bg-error animate-ping"></span><span class="font-label-code text-label-code text-error tracking-tight font-semibold">CRITICAL ALERT ACTIVE (churn_rf_v2: F1 0.87 -&gt; 0.61)</span></div>
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
                <nav class="flex items-center gap-space-md shrink-0 h-full" data-active-classes="text-tertiary border-b-2 border-tertiary font-semibold"><a class="text-on-surface-variant hover:text-on-surface h-full flex items-center font-label-code text-label-code transition-colors" data-path="soc-overview" href="FleetTelemetry.php">Overview</a><a class="text-on-surface-variant hover:text-on-surface h-full flex items-center font-label-code text-label-code transition-colors" data-path="alerts-center" href="IncidentTriage.php">Alerts (3)</a><a class="text-on-surface-variant hover:text-on-surface h-full flex items-center font-label-code text-label-code transition-colors" data-path="model-monitoring" href="ModelMonitoringDetail.php">Monitoring</a><a class="text-on-surface-variant hover:text-on-surface h-full flex items-center font-label-code text-label-code transition-colors" data-path="drift-workspace" href="DriftInvestigationWorkspace.php">Drift</a><a class="text-on-surface-variant hover:text-on-surface h-full flex items-center font-label-code text-label-code transition-colors" data-path="active-incident" href="IncidentWarRoom.php">Incident INC-4092</a><a class="text-on-surface-variant hover:text-on-surface h-full flex items-center font-label-code text-label-code transition-colors" data-path="incident-report" href="IncidentPostMortem.php">Post-Mortem</a><a class="text-on-surface-variant hover:text-on-surface h-full flex items-center font-label-code text-label-code transition-colors" data-path="alert-rules-config" href="AlertRulesAndDriftConfiguration.php">Config</a><a class="text-on-surface-variant hover:text-on-surface h-full flex items-center font-label-code text-label-code transition-colors" data-path="wall-display" href="FleetTelemetry.php">Wall Display</a></nav>
            </div>
        </header>
        <main class="relative pt-28 w-full p-gutter-desktop bg-transparent">
            <div class="flex flex-col w-full">
                <!-- Top Context Ribbon & Rule Execution Meta -->
                <div class="flex flex-col gap-space-sm mb-space-lg">
                    <div class="flex flex-wrap items-center justify-between gap-space-md">
                        <div class="flex flex-col">
                            <div class="flex items-center gap-space-xs text-outline">
                                <span class="material-symbols-outlined text-[16px]">tune</span>
                                <span class="font-label-technical text-label-technical tracking-widest uppercase">SYS-AI-05: AI SOC // CONFIGURATION // GUARDRAILS &amp; DRIFT RULES</span>
                            </div>
                            <h1 class="font-headline-lg text-headline-lg text-primary font-bold tracking-tight">Alert Rules &amp; Drift Guardrail Settings</h1>
                        </div>
                        <!-- Action Cluster -->
                        <div class="flex items-center gap-space-sm">
                            <button class="px-space-md py-space-sm rounded bg-surface-container-high hover:bg-surface-variant text-on-surface font-label-code text-label-code flex items-center gap-space-xs transition-colors shadow-sm">
                                <span class="material-symbols-outlined text-[16px] text-secondary">file_download</span>
                                <span>EXPORT CONFIG.YAML</span>
                            </button>
                            <button class="px-space-md py-space-sm rounded bg-surface-container-high hover:bg-surface-variant text-secondary font-label-code text-label-code flex items-center gap-space-xs transition-colors shadow-sm">
                                <span class="material-symbols-outlined text-[16px]">science</span>
                                <span>TEST RULES SIMULATION</span>
                            </button>
                            <button class="px-space-lg py-space-sm rounded bg-tertiary hover:bg-tertiary-fixed text-on-tertiary font-label-code text-label-code font-bold flex items-center gap-space-xs transition-all shadow-md">
                                <span class="material-symbols-outlined text-[18px]">verified</span>
                                <span>SAVE &amp; DEPLOY POLICIES</span>
                            </button>
                        </div>
                    </div>
                    <!-- Active Scope Indicator Bar -->
                    <div class="flex flex-wrap items-center justify-between bg-surface-container-low px-space-md py-space-xs rounded gap-space-sm shadow-sm">
                        <div class="flex items-center gap-space-sm">
                            <span class="w-2 h-2 rounded-full bg-tertiary animate-pulse"></span>
                            <span class="font-label-technical text-label-technical text-on-surface-variant uppercase">Policy Scope:</span>
                            <span class="font-label-code text-label-code text-on-surface">Fleet-wide Base Defaults + Custom Overrides</span>
                            <span class="px-2 py-0.5 rounded bg-tertiary-container text-tertiary font-label-code text-label-code font-semibold tracking-tight">churn_rf_v2 v2.4.1 (TARGET ACTIVE)</span>
                        </div>
                        <div class="flex items-center gap-space-md font-label-code text-label-code text-outline">
                            <span>LAST AUDITED: <strong class="text-on-surface">2025-04-18 04:42 UTC</strong></span>
                            <span>CHECKSUM: <strong class="text-secondary">0x8F94...B12</strong></span>
                            <span class="text-secondary flex items-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>SYNCHRONIZED (PROD-EU-WEST-1)</span>
                        </div>
                    </div>
                </div>
                <!-- Operational Counter Strip -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-space-md mb-space-lg">
                    <div class="bg-surface-container-low p-space-md rounded shadow-sm flex flex-col justify-between">
                        <div class="flex items-center justify-between text-outline mb-space-xs">
                            <span class="font-label-technical text-label-technical uppercase">Total Active Rules</span>
                            <span class="material-symbols-outlined text-[18px]">verified_user</span>
                        </div>
                        <div class="flex items-baseline gap-space-sm">
                            <span class="font-metric-display text-metric-display text-on-surface">24</span>
                            <span class="font-label-code text-label-code text-secondary">100% ONLINE</span>
                        </div>
                        <div class="w-full bg-surface-container-high h-1 rounded mt-space-sm overflow-hidden">
                            <div class="bg-secondary h-full w-full"></div>
                        </div>
                    </div>
                    <div class="bg-surface-container-low p-space-md rounded shadow-sm flex flex-col justify-between">
                        <div class="flex items-center justify-between text-outline mb-space-xs">
                            <span class="font-label-technical text-label-technical uppercase">Statistical Drift Tests</span>
                            <span class="material-symbols-outlined text-[18px] text-tertiary">query_stats</span>
                        </div>
                        <div class="flex items-baseline gap-space-sm">
                            <span class="font-metric-display text-metric-display text-tertiary">08</span>
                            <span class="font-label-code text-label-code text-outline">KS / PSI / CHI²</span>
                        </div>
                        <div class="w-full bg-surface-container-high h-1 rounded mt-space-sm overflow-hidden">
                            <div class="bg-tertiary h-full w-3/4"></div>
                        </div>
                    </div>
                    <div class="bg-surface-container-low p-space-md rounded shadow-sm flex flex-col justify-between">
                        <div class="flex items-center justify-between text-outline mb-space-xs">
                            <span class="font-label-technical text-label-technical uppercase">SLA Performance Gates</span>
                            <span class="material-symbols-outlined text-[18px] text-error">speed</span>
                        </div>
                        <div class="flex items-baseline gap-space-sm">
                            <span class="font-metric-display text-metric-display text-error">06</span>
                            <span class="font-label-code text-label-code text-error tracking-tight font-semibold">1 FIRING (INC-4092)</span>
                        </div>
                        <div class="w-full bg-surface-container-high h-1 rounded mt-space-sm overflow-hidden">
                            <div class="bg-error h-full w-2/3"></div>
                        </div>
                    </div>
                    <div class="bg-surface-container-low p-space-md rounded shadow-sm flex flex-col justify-between">
                        <div class="flex items-center justify-between text-outline mb-space-xs">
                            <span class="font-label-technical text-label-technical uppercase">Data Quality Contracts</span>
                            <span class="material-symbols-outlined text-[18px] text-primary">rule_folder</span>
                        </div>
                        <div class="flex items-baseline gap-space-sm">
                            <span class="font-metric-display text-metric-display text-primary">10</span>
                            <span class="font-label-code text-label-code text-outline">STRICT SCHEMA</span>
                        </div>
                        <div class="w-full bg-surface-container-high h-1 rounded mt-space-sm overflow-hidden">
                            <div class="bg-primary h-full w-full"></div>
                        </div>
                    </div>
                </div>
                <!-- Filter & Sub-Nav Control Hub -->
                <div class="bg-surface-container-low p-space-sm rounded mb-space-lg flex flex-wrap items-center justify-between gap-space-md shadow-sm">
                    <div class="flex items-center flex-wrap gap-space-xs">
                        <button class="px-space-md py-space-xs rounded bg-primary-container text-on-surface font-label-code text-label-code font-bold shadow-sm">
                            All Rules (24)
                        </button>
                        <button class="px-space-md py-space-xs rounded hover:bg-surface-container-high text-on-surface-variant font-label-code text-label-code transition-colors">
                            Model SLAs (6)
                        </button>
                        <button class="px-space-md py-space-xs rounded hover:bg-surface-container-high text-on-surface-variant font-label-code text-label-code transition-colors">
                            Statistical Drift (8)
                        </button>
                        <button class="px-space-md py-space-xs rounded hover:bg-surface-container-high text-on-surface-variant font-label-code text-label-code transition-colors">
                            Schema Contracts (10)
                        </button>
                        <button class="px-space-md py-space-xs rounded hover:bg-surface-container-high text-on-surface-variant font-label-code text-label-code transition-colors">
                            Routing &amp; Pager (4)
                        </button>
                    </div>
                    <div class="flex items-center gap-space-sm flex-1 sm:flex-initial justify-end">
                        <!-- Fast Filter Input -->
                        <div class="relative flex items-center">
                            <span class="material-symbols-outlined text-outline absolute left-2 text-[16px]">filter_list</span>
                            <input class="bg-surface-container-lowest text-on-surface font-label-code text-label-code pl-8 pr-3 py-1 rounded outline-none focus:bg-surface-container-high w-48 sm:w-60 shadow-inner" placeholder="FILTER RULE / PARAMS..." type="text" />
                        </div>
                        <!-- Scope Filter Select -->
                        <select class="bg-surface-container-lowest text-on-surface font-label-code text-label-code px-space-sm py-1 rounded outline-none">
                            <option selected="" value="churn_rf_v2">MODEL: churn_rf_v2</option>
                            <option value="fraud_detector_nn">MODEL: fraud_detector_nn</option>
                            <option value="lead_scoring_xgb">MODEL: lead_scoring_xgb</option>
                            <option value="all">FLEET-WIDE (ALL)</option>
                        </select>
                        <select class="bg-surface-container-lowest text-on-surface font-label-code text-label-code px-space-sm py-1 rounded outline-none">
                            <option value="all">SEVERITY: ALL</option>
                            <option value="p1">P1 CRITICAL ONLY</option>
                            <option value="p2">P2 HIGH</option>
                            <option value="p3">P3 ADVISORY</option>
                        </select>
                    </div>
                </div>
                <!-- Primary 2-Column Workstation Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-lg items-start">
                    <!-- Left Column (65% width): Core Guardrails & Interactive Parameter Gates -->
                    <div class="lg:col-span-8 flex flex-col gap-space-lg">
                        <!-- SECTION A: MODEL SLA DEGRADATION THRESHOLDS -->
                        <div class="bg-surface-container-low rounded p-space-lg shadow-md flex flex-col gap-space-md">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-space-sm">
                                    <span class="material-symbols-outlined text-error text-[22px]">crisis_alert</span>
                                    <div>
                                        <span class="font-label-technical text-label-technical text-outline uppercase">Section A // Ground Truth &amp; Proxy Performance</span>
                                        <h2 class="font-headline-md text-headline-md text-on-surface">Model Performance SLA Degradation Thresholds</h2>
                                    </div>
                                </div>
                                <span class="px-space-sm py-0.5 rounded bg-error-container text-on-error-container font-label-code text-label-code font-bold">CRITICAL GATES ACTIVE</span>
                            </div>
                            <!-- Rule Item 1: F1 Contractual Breach -->
                            <div class="bg-surface-container-lowest p-space-md rounded flex flex-col gap-space-sm shadow-inner">
                                <div class="flex flex-wrap items-center justify-between gap-space-xs">
                                    <div class="flex items-center gap-space-sm">
                                        <span class="px-2 py-0.5 rounded bg-error-container text-on-error-container font-label-code text-label-code font-bold">P1 CRIT</span>
                                        <span class="font-label-code text-label-code text-primary font-bold">RULE_ID: SLA-F1-BREACH-001</span>
                                        <span class="font-body-sm text-body-sm text-on-surface">Rolling F1-Score Contractual Floor</span>
                                    </div>
                                    <div class="flex items-center gap-space-xs">
                                        <span class="font-label-technical text-label-technical text-outline uppercase">Evaluation Cadence:</span>
                                        <span class="font-label-code text-label-code text-secondary font-semibold">Every 5m (Rolling 1h Window)</span>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-space-md py-space-sm">
                                    <!-- Numeric Control 1 -->
                                    <div class="bg-surface-container p-space-sm rounded flex flex-col justify-between">
                                        <div class="flex items-center justify-between text-outline">
                                            <span class="font-label-technical text-label-technical uppercase">Target Baseline F1</span>
                                            <span class="font-label-code text-label-code text-secondary">GOLDEN</span>
                                        </div>
                                        <div class="flex items-baseline justify-between mt-space-xs">
                                            <span class="font-metric-sm text-metric-sm text-on-surface font-bold">0.8700</span>
                                            <span class="font-label-code text-label-code text-outline">v2.4 Prod Bench</span>
                                        </div>
                                    </div>
                                    <!-- Numeric Control 2 -->
                                    <div class="bg-surface-container p-space-sm rounded flex flex-col justify-between">
                                        <div class="flex items-center justify-between text-tertiary">
                                            <span class="font-label-technical text-label-technical uppercase">Warning Threshold</span>
                                            <span class="material-symbols-outlined text-[14px]">warning</span>
                                        </div>
                                        <div class="flex items-baseline justify-between mt-space-xs">
                                            <input class="bg-surface-container-high text-tertiary font-metric-sm text-metric-sm font-bold w-24 px-2 py-0.5 rounded outline-none" type="text" value="0.8200" />
                                            <span class="font-label-code text-label-code text-outline">Delta: -5.7%</span>
                                        </div>
                                    </div>
                                    <!-- Numeric Control 3 -->
                                    <div class="bg-surface-container p-space-sm rounded flex flex-col justify-between">
                                        <div class="flex items-center justify-between text-error">
                                            <span class="font-label-technical text-label-technical uppercase">Critical P1 Breach</span>
                                            <span class="material-symbols-outlined text-[14px]">error</span>
                                        </div>
                                        <div class="flex items-baseline justify-between mt-space-xs">
                                            <input class="bg-surface-container-high text-error font-metric-sm text-metric-sm font-bold w-24 px-2 py-0.5 rounded outline-none" type="text" value="0.8000" />
                                            <span class="font-label-code text-label-code text-error tracking-tight font-semibold">Current: 0.6120</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- Threshold Slider Visual Gauge -->
                                <div class="flex flex-col gap-1 bg-surface-container px-space-md py-space-sm rounded">
                                    <div class="flex justify-between font-label-code text-[11px] text-outline">
                                        <span>0.5000 (Catastrophic)</span>
                                        <span class="text-error font-bold">CRIT FLOOR: 0.8000</span>
                                        <span class="text-tertiary font-bold">WARN: 0.8200</span>
                                        <span class="text-secondary font-bold">TARGET: 0.8700</span>
                                        <span>1.0000 (Ideal)</span>
                                    </div>
                                    <div class="relative w-full h-3 bg-surface-container-highest rounded-full overflow-hidden">
                                        <div class="absolute left-0 top-0 bottom-0 bg-error/30 w-3/5"></div>
                                        <div class="absolute left-[60%] top-0 bottom-0 bg-tertiary/30 w-[10%]"></div>
                                        <div class="absolute left-[70%] top-0 bottom-0 bg-secondary/30 w-[30%]"></div>
                                        <!-- Current Live Breach Pointer at 0.612 -->
                                        <div class="absolute left-[22.4%] top-0 bottom-0 w-2 bg-error rounded shadow-md animate-pulse"></div>
                                    </div>
                                    <div class="flex items-center justify-between font-label-code text-[11px] pt-1">
                                        <span class="text-error flex items-center gap-1 font-semibold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-error animate-ping"></span>
                                            ACTIVE TRIGGER: Current value 0.6120 breached floor (4 consecutive windows)
                                        </span>
                                        <span class="text-outline">Persist breach count: 2 windows required</span>
                                    </div>
                                </div>
                                <!-- Rule Actions & Automation Hook -->
                                <div class="flex flex-wrap items-center justify-between bg-surface-container/60 p-space-sm rounded gap-space-sm text-on-surface-variant font-label-code text-label-code">
                                    <div class="flex items-center gap-space-sm">
                                        <span class="material-symbols-outlined text-tertiary text-[18px]">bolt</span>
                                        <span>Auto-Actions: <strong>Page On-Duty Primary</strong> • <strong>Auto-spin Incident War Room</strong> • <strong>Tag #INC-4092</strong></span>
                                    </div>
                                    <div class="flex items-center gap-space-xs">
                                        <input checked="" class="w-3.5 h-3.5 bg-surface-container-lowest rounded border-outline" type="checkbox" />
                                        <span>Allow Fallback Shadow Route</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Rule Item 2: Precision & Recall Floors -->
                            <div class="bg-surface-container-lowest p-space-md rounded flex flex-col gap-space-sm shadow-inner">
                                <div class="flex flex-wrap items-center justify-between gap-space-xs">
                                    <div class="flex items-center gap-space-sm">
                                        <span class="px-2 py-0.5 rounded bg-secondary-container text-on-secondary-container font-label-code text-label-code font-bold">P2 HIGH</span>
                                        <span class="font-label-code text-label-code text-primary font-bold">RULE_ID: SLA-METRIC-FLOOR-002</span>
                                        <span class="font-body-sm text-body-sm text-on-surface">Precision / Recall Guardrail Dual Floor</span>
                                    </div>
                                    <div class="flex items-center gap-space-xs font-label-code text-label-code text-outline">
                                        <span>Status: <strong class="text-error">DEGRADED</strong></span>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-space-md">
                                    <div class="flex items-center justify-between bg-surface-container p-space-sm rounded">
                                        <div>
                                            <div class="font-label-technical text-label-technical text-outline uppercase">Minimum Precision Floor</div>
                                            <div class="font-label-code text-label-code text-on-surface">Target &gt;= 0.7800 (Nominal: 0.8410)</div>
                                        </div>
                                        <input class="bg-surface-container-high text-on-surface font-metric-sm text-metric-sm w-20 px-2 py-1 rounded text-right outline-none font-bold" step="0.01" type="number" value="0.78" />
                                    </div>
                                    <div class="flex items-center justify-between bg-surface-container p-space-sm rounded">
                                        <div>
                                            <div class="font-label-technical text-label-technical text-outline uppercase">Minimum Recall Floor</div>
                                            <div class="font-label-code text-label-code text-on-surface">Target &gt;= 0.8200 (Nominal: 0.8930)</div>
                                        </div>
                                        <input class="bg-surface-container-high text-on-surface font-metric-sm text-metric-sm w-20 px-2 py-1 rounded text-right outline-none font-bold" step="0.01" type="number" value="0.82" />
                                    </div>
                                </div>
                            </div>
                            <!-- Rule Item 3: Inference Latency p95 -->
                            <div class="bg-surface-container-lowest p-space-md rounded flex items-center justify-between flex-wrap gap-space-sm shadow-inner">
                                <div class="flex items-center gap-space-sm">
                                    <span class="px-2 py-0.5 rounded bg-surface-container-high text-on-surface-variant font-label-code text-label-code font-bold">P3 INFO</span>
                                    <div>
                                        <div class="font-label-code text-label-code text-primary font-bold">RULE_ID: SLA-LATENCY-P95</div>
                                        <div class="font-body-sm text-body-sm text-on-surface">Edge Triton Inference p95 Latency Cap</div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-space-md">
                                    <div class="text-right">
                                        <div class="font-label-technical text-label-technical text-outline uppercase">Current p95 Telemetry</div>
                                        <div class="font-label-code text-label-code text-secondary font-bold">48ms / 80ms Max</div>
                                    </div>
                                    <input class="bg-surface-container-high text-on-surface font-metric-sm text-metric-sm w-20 px-2 py-1 rounded text-center outline-none font-bold" type="text" value="80ms" />
                                </div>
                            </div>
                        </div>
                        <!-- SECTION B: STATISTICAL DRIFT & HYPOTHESIS TESTING -->
                        <div class="bg-surface-container-low rounded p-space-lg shadow-md flex flex-col gap-space-md">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-space-sm">
                                    <span class="material-symbols-outlined text-tertiary text-[22px]">analytics</span>
                                    <div>
                                        <span class="font-label-technical text-label-technical text-outline uppercase">Section B // Statistical Inference Engine</span>
                                        <h2 class="font-headline-md text-headline-md text-on-surface">Statistical Drift Detection &amp; Hypothesis Testing</h2>
                                    </div>
                                </div>
                                <span class="font-label-code text-label-code text-secondary">ENGINE: EVIDENTLY // SCIPY</span>
                            </div>
                            <!-- Drift Test 1: KS Test on Continuous Features -->
                            <div class="bg-surface-container-lowest p-space-md rounded flex flex-col gap-space-sm shadow-inner">
                                <div class="flex flex-wrap items-center justify-between gap-space-xs">
                                    <div class="flex items-center gap-space-sm">
                                        <span class="px-2 py-0.5 rounded bg-error-container text-on-error-container font-label-code text-label-code font-bold">P1 CRIT</span>
                                        <span class="font-label-code text-label-code text-primary font-bold">STAT_TEST: KOLMOGOROV-SMIRNOV</span>
                                        <span class="font-body-sm text-body-sm text-on-surface">Continuous Covariate Distribution Shift</span>
                                    </div>
                                    <span class="font-label-code text-label-code text-tertiary font-bold">TARGET: account_age_months • monthly_charges</span>
                                </div>
                                <p class="font-body-sm text-body-sm text-on-surface-variant">
                                    Non-parametric 2-sample Kolmogorov-Smirnov test evaluating inference batch distribution against reference dataset
                                    <span class="font-label-code text-label-code text-primary">train_v2.4_golden_reference (N=120,000)</span>.
                                </p>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-space-sm py-space-xs">
                                    <div class="bg-surface-container p-space-sm rounded">
                                        <div class="font-label-technical text-label-technical text-outline uppercase">Significance Level (α)</div>
                                        <div class="flex items-center justify-between mt-1">
                                            <span class="font-metric-sm text-metric-sm text-on-surface font-bold">0.05</span>
                                            <span class="font-label-code text-[11px] text-outline">95% Conf</span>
                                        </div>
                                    </div>
                                    <div class="bg-surface-container p-space-sm rounded">
                                        <div class="font-label-technical text-label-technical text-tertiary uppercase">Warning KS-Stat (D-Score)</div>
                                        <div class="flex items-center justify-between mt-1">
                                            <input class="bg-surface-container-high text-tertiary font-metric-sm text-metric-sm font-bold w-20 px-2 py-0.5 rounded outline-none" type="text" value="0.1500" />
                                            <span class="font-label-code text-[11px] text-outline">Mild Drift</span>
                                        </div>
                                    </div>
                                    <div class="bg-surface-container p-space-sm rounded">
                                        <div class="font-label-technical text-label-technical text-error uppercase">Critical Incident (D-Score)</div>
                                        <div class="flex items-center justify-between mt-1">
                                            <input class="bg-surface-container-high text-error font-metric-sm text-metric-sm font-bold w-20 px-2 py-0.5 rounded outline-none" type="text" value="0.3500" />
                                            <span class="font-label-code text-[11px] text-error font-bold">INC-4092: 0.4218</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- KS Curve Visualization Mini Component -->
                                <div class="bg-surface-container p-space-sm rounded flex flex-col gap-1">
                                    <div class="flex justify-between items-center font-label-code text-[11px]">
                                        <span class="text-on-surface">CDF Cumulative Empirical Discrepancy (D_max)</span>
                                        <span class="text-error font-bold">BREACH DETECTED // D = 0.4218 &gt; 0.3500</span>
                                    </div>
                                    <!-- Scaled KS Sparkline / CDF divergence SVG -->
                                    <svg class="w-full h-12 text-primary" fill="none" viewbox="0 0 500 48">
                                        <!-- Golden Baseline CDF (smooth sigmoid) -->
                                        <path class="text-outline" d="M 0,44 C 150,44 180,4 500,4" opacity="0.6" stroke="currentColor" stroke-dasharray="2 2" stroke-width="2"></path>
                                        <!-- Perturbed Drifted CDF (shifted steep left due to null-coercion spike) -->
                                        <path class="text-error" d="M 0,44 C 60,44 70,8 500,8" stroke="currentColor" stroke-width="2"></path>
                                        <!-- D_max Vertical Delta Line -->
                                        <line class="text-tertiary" stroke="currentColor" stroke-width="2" x1="120" x2="120" y1="8" y2="40"></line>
                                        <circle class="text-tertiary" cx="120" cy="8" fill="currentColor" r="3"></circle>
                                        <circle class="text-tertiary" cx="120" cy="40" fill="currentColor" r="3"></circle>
                                    </svg>
                                    <div class="flex justify-between text-outline font-label-code text-[10px]">
                                        <span>Reference Baseline Distribution CDF</span>
                                        <span class="text-tertiary">Δ D_max at x=12.0m (Distance 0.4218)</span>
                                        <span class="text-error">Live Ingestion Cohort CDF</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Drift Test 2: PSI & Chi-Square Tests -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-space-md">
                                <!-- Categorical Chi-Square -->
                                <div class="bg-surface-container-lowest p-space-md rounded flex flex-col justify-between shadow-inner">
                                    <div>
                                        <div class="flex items-center justify-between mb-space-xs">
                                            <span class="px-1.5 py-0.5 rounded bg-surface-container-high text-on-surface-variant font-label-code text-[11px] font-bold">CHI-SQUARE</span>
                                            <span class="font-label-code text-label-code text-secondary">p-val &lt; 0.01</span>
                                        </div>
                                        <div class="font-label-technical text-label-technical text-outline uppercase">Categorical Covariates</div>
                                        <div class="font-label-code text-label-code text-on-surface font-semibold mt-1">contract_type • payment_method</div>
                                        <p class="font-body-sm text-body-sm text-on-surface-variant mt-2">
                                            Flags categorical cardinality shifts or sudden frequency distribution skew across upstream payment channels.
                                        </p>
                                    </div>
                                    <div class="flex items-center justify-between pt-space-md mt-space-md bg-surface-container/30 px-space-xs rounded">
                                        <span class="font-label-code text-label-code text-outline">Action: Alert P2</span>
                                        <span class="font-label-code text-label-code text-secondary">Status: NOMINAL</span>
                                    </div>
                                </div>
                                <!-- Population Stability Index (PSI) -->
                                <div class="bg-surface-container-lowest p-space-md rounded flex flex-col justify-between shadow-inner">
                                    <div>
                                        <div class="flex items-center justify-between mb-space-xs">
                                            <span class="px-1.5 py-0.5 rounded bg-tertiary-container text-tertiary font-label-code text-[11px] font-bold">PSI SCORE</span>
                                            <span class="font-label-code text-label-code text-tertiary font-bold">THRESHOLD &gt; 0.25</span>
                                        </div>
                                        <div class="font-label-technical text-label-technical text-outline uppercase">Output Concept Drift</div>
                                        <div class="font-label-code text-label-code text-on-surface font-semibold mt-1">Predicted Churn Probability [0, 1]</div>
                                        <p class="font-body-sm text-body-sm text-on-surface-variant mt-2">
                                            Measures change in probability bin distributions between benchmark scoring and actual live predictions.
                                        </p>
                                    </div>
                                    <div class="flex items-center justify-between pt-space-md mt-space-md bg-surface-container/30 px-space-xs rounded">
                                        <span class="font-label-code text-label-code text-outline">Action: Trigger Retrain Eval</span>
                                        <span class="font-label-code text-label-code text-tertiary font-bold">Current PSI: 0.312 (DRIFT)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- SECTION C: INGESTION SCHEMA & DATA QUALITY (INC-4092 ROOT CAUSE FIX) -->
                        <div class="bg-surface-container-low rounded p-space-lg shadow-md flex flex-col gap-space-md">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-space-sm">
                                    <span class="material-symbols-outlined text-secondary text-[22px]">security</span>
                                    <div>
                                        <span class="font-label-technical text-label-technical text-outline uppercase">Section C // Data Contract Enforcement</span>
                                        <h2 class="font-headline-md text-headline-md text-on-surface">Ingestion Schema &amp; Data Integrity Guardrails</h2>
                                    </div>
                                </div>
                                <span class="px-space-sm py-0.5 rounded bg-secondary-container text-on-secondary-container font-label-code text-label-code font-bold">POST-MORTEM FIX</span>
                            </div>
                            <div class="bg-surface-container-lowest p-space-md rounded flex flex-col gap-space-md shadow-inner">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-space-sm">
                                        <span class="px-2 py-0.5 rounded bg-error-container text-on-error-container font-label-code text-label-code font-bold">CRITICAL GUARD</span>
                                        <span class="font-label-code text-label-code text-primary font-bold">RULE_ID: CONTRACT-NULL-QUARANTINE</span>
                                    </div>
                                    <span class="font-label-code text-label-code text-tertiary">PREVENTS SILENT FILLNA(0)</span>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-space-md">
                                    <div class="bg-surface-container p-space-sm rounded">
                                        <div class="font-label-technical text-label-technical text-outline uppercase">Max Missingness Floor</div>
                                        <div class="flex items-baseline justify-between mt-space-xs">
                                            <input class="bg-surface-container-high text-on-surface font-metric-sm text-metric-sm font-bold w-20 px-2 py-0.5 rounded outline-none" type="text" value="0.05%" />
                                            <span class="font-label-code text-[11px] text-outline">Tolerance</span>
                                        </div>
                                    </div>
                                    <div class="bg-surface-container p-space-sm rounded">
                                        <div class="font-label-technical text-label-technical text-outline uppercase">Schema Contract Mode</div>
                                        <div class="flex items-baseline justify-between mt-space-xs">
                                            <span class="font-label-code text-label-code text-secondary font-bold">STRICT_VALIDATION</span>
                                            <span class="font-label-code text-[11px] text-secondary">REJECT EXTRA</span>
                                        </div>
                                    </div>
                                    <div class="bg-surface-container p-space-sm rounded">
                                        <div class="font-label-technical text-label-technical text-outline uppercase">Upstream Coercion Spike</div>
                                        <div class="flex items-baseline justify-between mt-space-xs">
                                            <span class="font-metric-sm text-metric-sm text-error font-bold">&gt; 2.0x Baseline</span>
                                            <span class="font-label-code text-[11px] text-error font-semibold">Immediate Halt</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-error-container/20 p-space-sm rounded flex items-center justify-between text-on-error-container font-label-code text-label-code">
                                    <div class="flex items-center gap-space-sm">
                                        <span class="material-symbols-outlined text-error text-[18px]">gpp_maybe</span>
                                        <span><strong>Circuit Breaker Action:</strong> Automatically quarantine micro-batch &amp; route inference requests to Shadow Stub if schema contracts are violated.</span>
                                    </div>
                                    <span class="px-2 py-0.5 rounded bg-error text-on-error font-bold text-[10px]">ENFORCED</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Right Column (35% width): Escalation Matrix, Simulation Engine & Muting Schedule -->
                    <div class="lg:col-span-4 flex flex-col gap-space-lg">
                        <!-- INC-4092 Post-Mortem Guardrail Simulation Test Sandbox -->
                        <div class="bg-surface-container-low rounded p-space-lg shadow-md flex flex-col gap-space-md">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-space-xs">
                                    <span class="material-symbols-outlined text-tertiary text-[20px]">history_toggle_off</span>
                                    <span class="font-label-technical text-label-technical text-outline uppercase">Backtest Engine</span>
                                </div>
                                <span class="px-2 py-0.5 rounded bg-tertiary-container text-tertiary font-label-code text-[10px] font-bold">INC-4092 VALIDATION</span>
                            </div>
                            <h3 class="font-headline-md text-headline-md text-on-surface">Incident Payload Replay</h3>
                            <p class="font-body-sm text-body-sm text-on-surface-variant">
                                Simulate proposed ruleset against telemetry records captured during the CRM-FEED-05 upstream schema collapse (03:45 - 04:18 UTC).
                            </p>
                            <!-- Simulation Result Card -->
                            <div class="bg-surface-container-lowest p-space-md rounded flex flex-col gap-space-sm shadow-inner">
                                <div class="flex items-center justify-between">
                                    <span class="font-label-technical text-label-technical text-secondary uppercase font-bold">Simulation Output</span>
                                    <span class="px-2 py-0.5 rounded bg-secondary-container text-on-secondary-container font-label-code text-label-code font-bold">PASSED VERIFICATION</span>
                                </div>
                                <div class="flex flex-col gap-space-xs py-space-xs font-label-code text-label-code">
                                    <div class="flex items-start gap-space-xs text-on-surface">
                                        <span class="material-symbols-outlined text-secondary text-[16px] mt-0.5">check_circle</span>
                                        <div>
                                            <strong>33m Faster Detection:</strong> Ruleset would have intercepted payload at <strong>03:46 UTC</strong>.
                                        </div>
                                    </div>
                                    <div class="flex items-start gap-space-xs text-on-surface-variant text-[11px] pl-5">
                                        • Strict Schema Contract blocked unhandled NULLs in account_age_months.
                                    </div>
                                    <div class="flex items-start gap-space-xs text-on-surface-variant text-[11px] pl-5">
                                        • KS-statistic alarm D=0.4218 fired on first 50 inference frames.
                                    </div>
                                </div>
                                <div class="bg-surface-container p-space-sm rounded flex items-center justify-between text-[11px] font-label-code">
                                    <span class="text-outline">Downstream F1 Breach Avoided:</span>
                                    <span class="text-secondary font-bold">100% PREVENTED</span>
                                </div>
                                <button class="w-full py-space-sm rounded bg-surface-container-high hover:bg-surface-variant text-on-surface font-label-code text-label-code flex items-center justify-center gap-space-xs transition-colors mt-space-xs">
                                    <span class="material-symbols-outlined text-[16px]">play_arrow</span>
                                    <span>RE-RUN TELEMETRY SIMULATION</span>
                                </button>
                            </div>
                        </div>
                        <!-- Alert Routing & Escalation Matrix -->
                        <div class="bg-surface-container-low rounded p-space-lg shadow-md flex flex-col gap-space-md">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-space-xs">
                                    <span class="material-symbols-outlined text-primary text-[20px]">hub</span>
                                    <span class="font-label-technical text-label-technical text-outline uppercase">Dispatch Matrix</span>
                                </div>
                                <span class="font-label-code text-label-code text-secondary flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>4 CHANNELS
                                </span>
                            </div>
                            <h3 class="font-headline-md text-headline-md text-on-surface">Notification &amp; Pager Channels</h3>
                            <!-- Escalation Channel Table / List -->
                            <div class="flex flex-col gap-space-sm">
                                <!-- P1 Level -->
                                <div class="bg-surface-container-lowest p-space-sm rounded flex flex-col gap-1 shadow-inner">
                                    <div class="flex items-center justify-between">
                                        <span class="px-1.5 py-0.5 rounded bg-error-container text-on-error-container font-label-code text-[10px] font-bold">P1 CRITICAL</span>
                                        <span class="font-label-code text-[11px] text-error font-bold">IMMEDIATE (0m)</span>
                                    </div>
                                    <div class="font-label-code text-label-code text-on-surface font-semibold">PagerDuty Tier-1 • Auto War Room</div>
                                    <div class="font-body-sm text-body-sm text-on-surface-variant">Slack: <code class="text-secondary">#ops-ai-critical</code> • SMS to Alexei V.</div>
                                </div>
                                <!-- P2 Level -->
                                <div class="bg-surface-container-lowest p-space-sm rounded flex flex-col gap-1 shadow-inner">
                                    <div class="flex items-center justify-between">
                                        <span class="px-1.5 py-0.5 rounded bg-secondary-container text-on-secondary-container font-label-code text-[10px] font-bold">P2 WARNING</span>
                                        <span class="font-label-code text-[11px] text-outline">AFTER 5 MINS</span>
                                    </div>
                                    <div class="font-label-code text-label-code text-on-surface font-semibold">Slack #ml-telemetry-feed</div>
                                    <div class="font-body-sm text-body-sm text-on-surface-variant">Automated Jira Ticket Dispatch → SYS-AI-03 Board</div>
                                </div>
                                <!-- P3 Level -->
                                <div class="bg-surface-container-lowest p-space-sm rounded flex flex-col gap-1 shadow-inner">
                                    <div class="flex items-center justify-between">
                                        <span class="px-1.5 py-0.5 rounded bg-surface-container-high text-on-surface-variant font-label-code text-[10px] font-bold">P3 ADVISORY</span>
                                        <span class="font-label-code text-[11px] text-outline">HOURLY DIGEST</span>
                                    </div>
                                    <div class="font-label-code text-label-code text-on-surface font-semibold">SOC Event Logbook • Daily Summary</div>
                                </div>
                            </div>
                            <!-- Webhook Endpoint Health Indicator -->
                            <div class="bg-surface-container p-space-sm rounded flex flex-col gap-1">
                                <div class="flex items-center justify-between font-label-technical text-label-technical text-outline uppercase">
                                    <span>Primary Dispatch Webhook</span>
                                    <span class="text-secondary font-bold">HTTP 200 OK (8ms)</span>
                                </div>
                                <div class="font-label-code text-[11px] text-on-surface truncate">
                                    https://soc-webhooks.vostokpribor.internal/v1/telemetry-events
                                </div>
                            </div>
                        </div>
                        <!-- Maintenance Windows & Alert Muting -->
                        <div class="bg-surface-container-low rounded p-space-lg shadow-md flex flex-col gap-space-md">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-space-xs">
                                    <span class="material-symbols-outlined text-outline text-[20px]">notifications_paused</span>
                                    <span class="font-label-technical text-label-technical text-outline uppercase">Scheduled Muting</span>
                                </div>
                                <span class="font-label-code text-label-code text-outline">ACTIVE RULES: 1</span>
                            </div>
                            <h3 class="font-headline-md text-headline-md text-on-surface">Maintenance Windows</h3>
                            <div class="bg-surface-container-lowest p-space-md rounded flex flex-col gap-space-xs shadow-inner">
                                <div class="flex items-center justify-between">
                                    <span class="font-label-code text-label-code text-primary font-bold">KAFKA_CLUSTER_REBALANCE</span>
                                    <span class="px-2 py-0.5 rounded bg-surface-container-high text-on-surface-variant font-label-code text-[10px]">SCHEDULED</span>
                                </div>
                                <p class="font-body-sm text-body-sm text-on-surface-variant">
                                    Temporarily mutes p95 latency alerts during rolling broker updates. Maximum silence duration: 30 minutes.
                                </p>
                                <div class="flex items-center justify-between text-outline font-label-code text-[11px] pt-space-xs">
                                    <span>Window: Sun 02:00 - 02:30 UTC</span>
                                    <span class="text-secondary">Auto-expires</span>
                                </div>
                            </div>
                            <button class="w-full py-space-sm rounded bg-surface-container-high hover:bg-surface-variant text-on-surface font-label-code text-label-code flex items-center justify-center gap-space-xs transition-colors">
                                <span class="material-symbols-outlined text-[16px]">add_circle</span>
                                <span>SCHEDULE NEW SILENCE WINDOW</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="../assets/js/app.js"></script>
    <script src="js/main.js"></script>
</body>

</html>