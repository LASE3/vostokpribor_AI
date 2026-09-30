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
                <nav class="flex items-center gap-space-md shrink-0 h-full" data-active-classes="text-tertiary border-b-2 border-tertiary font-semibold"><a class="text-on-surface-variant hover:text-on-surface h-full flex items-center font-label-code text-label-code transition-colors" data-path="soc-overview-fleet-telemetry" href="FleetTelemetry.php">Fleet Overview</a><a class="text-on-surface-variant hover:text-on-surface h-full flex items-center font-label-code text-label-code transition-colors" data-path="alerts-center-incident-triage" href="IncidentTriage.php">Alerts Center (3)</a><a class="text-on-surface-variant hover:text-on-surface h-full flex items-center font-label-code text-label-code transition-colors" data-path="model-monitoring-detail" href="ModelMonitoringDetail.php">Model Monitoring</a><a aria-current="page" class="h-full flex items-center transition-colors text-tertiary border-b-2 border-tertiary font-semibold" data-path="drift-investigation-workspace" href="DriftInvestigationWorkspace.php">Drift Investigation</a><a class="text-on-surface-variant hover:text-on-surface h-full flex items-center font-label-code text-label-code transition-colors" data-path="active-incident" href="IncidentWarRoom.php">INC-4092 War Room</a><a class="text-on-surface-variant hover:text-on-surface h-full flex items-center font-label-code text-label-code transition-colors" data-path="alert-rules-config" href="AlertRulesAndDriftConfiguration.php">Config</a></nav>
            </div>
        </header>
        <main class="relative pt-28 w-full p-gutter-desktop bg-transparent">
            <div class="flex flex-col w-full">
                <!-- TOP SUBMISSION & METRIC HUD BAR -->
                <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-space-md p-space-lg bg-surface-container rounded-xl shadow-lg mb-space-lg">
                    <div class="flex flex-col gap-1 min-w-0">
                        <div class="flex flex-wrap items-center gap-space-sm">
                            <span class="px-2 py-0.5 rounded bg-error-container text-on-error-container font-label-code text-[11px] font-bold tracking-wider uppercase">DRILL INCIDENT #INC-4092</span>
                            <span class="px-2 py-0.5 rounded bg-secondary-container text-on-secondary-container font-label-technical text-label-technical">L3 CERT TRACK</span>
                            <span class="px-2 py-0.5 rounded bg-surface-container-high text-tertiary font-label-code text-[11px] flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-tertiary"></span>7/7 SECTIONS CERTIFIED
                            </span>
                        </div>
                        <h1 class="font-headline-lg text-headline-lg text-primary tracking-tight mt-1">POST-MORTEM &amp; ROOT CAUSE ANALYSIS</h1>
                        <div class="flex flex-wrap items-center gap-space-md text-on-surface-variant font-body-sm text-body-sm mt-0.5">
                            <span class="flex items-center gap-1"><span class="material-symbols-outlined text-[16px] text-outline">school</span> Drill 07: Production Model Failure</span>
                            <span class="text-outline">/</span>
                            <span class="flex items-center gap-1 font-label-code text-label-code text-on-surface"><span class="text-outline">MODEL:</span> churn_rf_v2 (v2.4.1)</span>
                            <span class="text-outline">/</span>
                            <span class="flex items-center gap-1"><span class="text-outline">ENGINEER:</span> Alexei V. <span class="text-tertiary font-label-code text-[11px]">(Intern AI Eng · L3)</span></span>
                        </div>
                    </div>
                    <!-- Action Group & Primary CTA -->
                    <div class="flex flex-wrap items-center gap-space-sm w-full lg:w-auto shrink-0">
                        <button class="px-space-md py-space-sm bg-surface-container-high hover:bg-surface-bright text-on-surface rounded font-label-technical text-label-technical flex items-center gap-1.5 transition-colors">
                            <span class="material-symbols-outlined text-[16px]">save</span>
                            <span>SAVE DRAFT</span>
                        </button>
                        <button class="px-space-md py-space-sm bg-surface-container-high hover:bg-surface-bright text-on-surface rounded font-label-technical text-label-technical flex items-center gap-1.5 transition-colors">
                            <span class="material-symbols-outlined text-[16px]">description</span>
                            <span>PREVIEW PDF</span>
                        </button>
                        <button class="px-space-md py-space-sm bg-surface-container-high hover:bg-surface-bright text-on-surface rounded font-label-technical text-label-technical flex items-center gap-1.5 transition-colors">
                            <span class="material-symbols-outlined text-[16px]">inventory_2</span>
                            <span>BUNDLE</span>
                        </button>
                        <button class="px-space-lg py-space-sm bg-tertiary hover:bg-on-tertiary-container text-on-tertiary font-label-technical text-label-technical font-bold rounded flex items-center gap-2 shadow-lg transition-all transform active:scale-95" id="submitDrillBtn">
                            <span class="material-symbols-outlined text-[18px]">verified</span>
                            <span>SUBMIT TO SYS-AI-01 ★</span>
                        </button>
                    </div>
                </div>
                <!-- MAIN DUAL-PANEL GRID -->
                <div class="grid grid-cols-1 xl:grid-cols-12 gap-space-lg">
                    <!-- LEFT PANEL: 7-SECTION STRUCTURED POST-MORTEM REPORT (8 Cols) -->
                    <div class="xl:col-span-8 flex flex-col gap-space-lg">
                        <!-- SECTION 1: EXECUTIVE SUMMARY -->
                        <section class="bg-surface-container rounded-xl p-space-lg shadow-md flex flex-col gap-space-md">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-space-sm">
                                    <span class="w-6 h-6 rounded bg-primary-container text-primary font-label-code text-label-code flex items-center justify-center font-bold">01</span>
                                    <h2 class="font-headline-md text-headline-md text-primary">Executive Summary &amp; Severity Assessment</h2>
                                </div>
                                <span class="font-label-code text-label-code text-error bg-error-container/40 px-2 py-0.5 rounded font-semibold uppercase">P1 - CRITICAL</span>
                            </div>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-space-sm">
                                <div class="bg-surface-container-lowest p-space-sm rounded flex flex-col">
                                    <span class="font-label-technical text-[10px] text-outline uppercase tracking-wider">Incident ID</span>
                                    <span class="font-metric-sm text-metric-sm text-on-surface">#INC-4092</span>
                                </div>
                                <div class="bg-surface-container-lowest p-space-sm rounded flex flex-col">
                                    <span class="font-label-technical text-[10px] text-outline uppercase tracking-wider">Detection Time</span>
                                    <span class="font-metric-sm text-metric-sm text-error">04:18 UTC</span>
                                </div>
                                <div class="bg-surface-container-lowest p-space-sm rounded flex flex-col">
                                    <span class="font-label-technical text-[10px] text-outline uppercase tracking-wider">Resolution Time</span>
                                    <span class="font-metric-sm text-metric-sm text-secondary-fixed">04:52 UTC</span>
                                </div>
                                <div class="bg-surface-container-lowest p-space-sm rounded flex flex-col">
                                    <span class="font-label-technical text-[10px] text-outline uppercase tracking-wider">Total Duration</span>
                                    <span class="font-metric-sm text-metric-sm text-tertiary">34m (MTTD 3.2m)</span>
                                </div>
                            </div>
                            <div class="flex flex-col gap-1">
                                <label class="font-label-technical text-label-technical text-outline uppercase">Executive Synthesis (Auto-Validated)</label>
                                <div class="p-space-md bg-surface-container-low text-on-surface rounded font-body-md text-body-md leading-relaxed shadow-sm">
                                    At 04:18 UTC, production model <span class="font-label-code text-label-code text-secondary font-bold">churn_rf_v2</span> experienced a catastrophic F1 performance degradation from baseline <span class="font-metric-sm text-label-code text-secondary">0.87</span> to <span class="font-metric-sm text-label-code text-error">0.61</span> (-29.8%), directly breaching contractual SLA minimum (<span class="font-label-code text-label-code text-outline">0.80</span>). The automated triage pipeline isolated the root cause to severe feature corruption in upstream <span class="font-label-code text-label-code text-tertiary">account_age_months</span> following schema update v1.8. Rapid containment via canary pod rollback to v2.4.0 restored telemetry SLA within 34 minutes.
                                </div>
                            </div>
                        </section>
                        <!-- SECTION 2: BLAST RADIUS & IMPACT -->
                        <section class="bg-surface-container rounded-xl p-space-lg shadow-md flex flex-col gap-space-md">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-space-sm">
                                    <span class="w-6 h-6 rounded bg-primary-container text-primary font-label-code text-label-code flex items-center justify-center font-bold">02</span>
                                    <h2 class="font-headline-md text-headline-md text-primary">Blast Radius &amp; Production Impact</h2>
                                </div>
                                <span class="font-label-technical text-label-technical text-outline uppercase">CRM GATEWAY CLUSTER 04</span>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-space-md">
                                <div class="bg-surface-container-lowest p-space-md rounded flex flex-col gap-1">
                                    <div class="flex items-center justify-between">
                                        <span class="font-label-technical text-[10px] text-outline uppercase">Inference Requests Breached</span>
                                        <span class="material-symbols-outlined text-outline text-[16px]">sensors</span>
                                    </div>
                                    <span class="font-metric-display text-metric-display text-primary">8,520</span>
                                    <span class="font-body-sm text-body-sm text-on-surface-variant">Inference window: 34 mins</span>
                                </div>
                                <div class="bg-surface-container-lowest p-space-md rounded flex flex-col gap-1">
                                    <div class="flex items-center justify-between">
                                        <span class="font-label-technical text-[10px] text-outline uppercase">False Positive Rate Distortion</span>
                                        <span class="material-symbols-outlined text-error text-[16px]">trending_up</span>
                                    </div>
                                    <div class="flex items-baseline gap-2">
                                        <span class="font-metric-display text-metric-display text-error">48.9%</span>
                                        <span class="font-label-code text-label-code text-outline line-through">14.2%</span>
                                    </div>
                                    <span class="font-body-sm text-body-sm text-error font-medium">+244% over-prediction spike</span>
                                </div>
                                <div class="bg-surface-container-lowest p-space-md rounded flex flex-col gap-1">
                                    <div class="flex items-center justify-between">
                                        <span class="font-label-technical text-[10px] text-outline uppercase">Financial Impact Assessment</span>
                                        <span class="material-symbols-outlined text-tertiary text-[16px]">payments</span>
                                    </div>
                                    <span class="font-metric-display text-metric-display text-tertiary">~$18,400</span>
                                    <span class="font-body-sm text-body-sm text-on-surface-variant">Unearned promotional credits granted</span>
                                </div>
                            </div>
                            <div class="p-space-sm bg-surface-container-low rounded flex items-center justify-between text-on-surface-variant font-label-code text-label-code">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-secondary text-[18px]">hub</span>
                                    <span>Affected Downstream Node: CRM Enterprise Retention Engine (Node-RE-09)</span>
                                </div>
                                <span class="text-tertiary font-bold">RECOVERED</span>
                            </div>
                        </section>
                        <!-- SECTION 3: VERIFIED TIMELINE -->
                        <section class="bg-surface-container rounded-xl p-space-lg shadow-md flex flex-col gap-space-md">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-space-sm">
                                    <span class="w-6 h-6 rounded bg-primary-container text-primary font-label-code text-label-code flex items-center justify-center font-bold">03</span>
                                    <h2 class="font-headline-md text-headline-md text-primary">Verified Incident Chronology</h2>
                                </div>
                                <span class="font-label-code text-label-code text-secondary bg-surface-container-high px-2 py-0.5 rounded">5 AUDIT ENTRIES</span>
                            </div>
                            <div class="flex flex-col gap-2">
                                <!-- Timeline row 1 -->
                                <div class="flex items-start gap-space-md p-space-sm rounded bg-surface-container-lowest hover:bg-surface-container-low transition-colors">
                                    <span class="font-metric-sm text-label-code text-outline shrink-0 w-20 pt-0.5">03:45 UTC</span>
                                    <div class="flex flex-col flex-1 min-w-0">
                                        <div class="flex items-center gap-2">
                                            <span class="font-label-technical text-label-technical font-bold text-on-surface">CRM-FEED-05 Schema Release v1.8 Deployed</span>
                                            <span class="px-1.5 py-0.2 rounded bg-surface-container-high text-[10px] font-label-code text-outline">ORIGIN</span>
                                        </div>
                                        <p class="font-body-sm text-body-sm text-on-surface-variant">Upstream pipeline dropped integer column <code class="text-secondary font-label-code">account_age_months</code> and introduced ISO timestamp <code class="text-secondary font-label-code">creation_timestamp</code>.</p>
                                    </div>
                                    <button class="text-outline hover:text-primary transition-colors"><span class="material-symbols-outlined text-[16px]">edit</span></button>
                                </div>
                                <!-- Timeline row 2 -->
                                <div class="flex items-start gap-space-md p-space-sm rounded bg-surface-container-lowest hover:bg-surface-container-low transition-colors">
                                    <span class="font-metric-sm text-label-code text-error shrink-0 w-20 pt-0.5">04:18 UTC</span>
                                    <div class="flex flex-col flex-1 min-w-0">
                                        <div class="flex items-center gap-2">
                                            <span class="font-label-technical text-label-technical font-bold text-error">Automated Alert ALT-8812 Triggered</span>
                                            <span class="px-1.5 py-0.2 rounded bg-error-container text-on-error-container text-[10px] font-label-code">SLA BREACH</span>
                                        </div>
                                        <p class="font-body-sm text-body-sm text-on-surface-variant">Rolling window F1 score collapsed below threshold (0.61 &lt; 0.80). Alexei V. acknowledged P1 alert in 3.2 minutes.</p>
                                    </div>
                                    <button class="text-outline hover:text-primary transition-colors"><span class="material-symbols-outlined text-[16px]">edit</span></button>
                                </div>
                                <!-- Timeline row 3 -->
                                <div class="flex items-start gap-space-md p-space-sm rounded bg-surface-container-lowest hover:bg-surface-container-low transition-colors">
                                    <span class="font-metric-sm text-label-code text-tertiary shrink-0 w-20 pt-0.5">04:32 UTC</span>
                                    <div class="flex flex-col flex-1 min-w-0">
                                        <div class="flex items-center gap-2">
                                            <span class="font-label-technical text-label-technical font-bold text-on-surface">Telemetry Diagnostic &amp; KS-Test Confirmation</span>
                                            <span class="px-1.5 py-0.2 rounded bg-tertiary-container text-tertiary text-[10px] font-label-code">DIAGNOSIS</span>
                                        </div>
                                        <p class="font-body-sm text-body-sm text-on-surface-variant">Automated Kolmogorov-Smirnov test confirmed 78.4% zero-imputation drift in feature <code class="text-secondary font-label-code">account_age_months</code> (p-val &lt; 0.0001).</p>
                                    </div>
                                    <button class="text-outline hover:text-primary transition-colors"><span class="material-symbols-outlined text-[16px]">edit</span></button>
                                </div>
                                <!-- Timeline row 4 -->
                                <div class="flex items-start gap-space-md p-space-sm rounded bg-surface-container-lowest hover:bg-surface-container-low transition-colors">
                                    <span class="font-metric-sm text-label-code text-secondary shrink-0 w-20 pt-0.5">04:48 UTC</span>
                                    <div class="flex flex-col flex-1 min-w-0">
                                        <div class="flex items-center gap-2">
                                            <span class="font-label-technical text-label-technical font-bold text-on-surface">Canary Rollback Executed via SYS-AI-04</span>
                                            <span class="px-1.5 py-0.2 rounded bg-surface-container-high text-[10px] font-label-code text-secondary">CONTAINMENT</span>
                                        </div>
                                        <p class="font-body-sm text-body-sm text-on-surface-variant">Inference gateway pods routed 100% traffic to stable fallback deployment v2.4.0 with feature guard fallback.</p>
                                    </div>
                                    <button class="text-outline hover:text-primary transition-colors"><span class="material-symbols-outlined text-[16px]">edit</span></button>
                                </div>
                                <!-- Timeline row 5 -->
                                <div class="flex items-start gap-space-md p-space-sm rounded bg-surface-container-lowest hover:bg-surface-container-low transition-colors">
                                    <span class="font-metric-sm text-label-code text-secondary-fixed shrink-0 w-20 pt-0.5">04:52 UTC</span>
                                    <div class="flex flex-col flex-1 min-w-0">
                                        <div class="flex items-center gap-2">
                                            <span class="font-label-technical text-label-technical font-bold text-on-surface">Telemetry Stabilized &amp; Incident Cleared</span>
                                            <span class="px-1.5 py-0.2 rounded bg-surface-container-high text-[10px] font-label-code text-on-surface">RESTORATION</span>
                                        </div>
                                        <p class="font-body-sm text-body-sm text-on-surface-variant">F1 restored to 0.865 (within SLA). False positive churn prediction rate normalized to 14.1%.</p>
                                    </div>
                                    <button class="text-outline hover:text-primary transition-colors"><span class="material-symbols-outlined text-[16px]">edit</span></button>
                                </div>
                            </div>
                        </section>
                        <!-- SECTION 4: 5-WHYS ROOT CAUSE METHODOLOGY -->
                        <section class="bg-surface-container rounded-xl p-space-lg shadow-md flex flex-col gap-space-md">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-space-sm">
                                    <span class="w-6 h-6 rounded bg-primary-container text-primary font-label-code text-label-code flex items-center justify-center font-bold">04</span>
                                    <h2 class="font-headline-md text-headline-md text-primary">5-Whys Root Cause Methodology</h2>
                                </div>
                                <span class="font-label-code text-label-code text-tertiary bg-tertiary-container px-2 py-0.5 rounded font-bold">STUDENT LOG // RUBRIC CRITICAL</span>
                            </div>
                            <div class="flex flex-col gap-space-sm">
                                <!-- Why 1 -->
                                <div class="p-space-sm bg-surface-container-lowest rounded flex flex-col gap-1">
                                    <div class="flex items-center justify-between">
                                        <span class="font-label-technical text-[10px] text-secondary uppercase font-bold">Why 1: Why did the model predict 48.9% churn rate instead of 14.2%?</span>
                                        <span class="material-symbols-outlined text-secondary text-[16px]">check_circle</span>
                                    </div>
                                    <p class="font-body-md text-body-md text-on-surface font-label-code bg-surface-container-low p-2 rounded">
                                        Feature <span class="text-secondary font-bold">account_age_months</span> defaulted to zero for 78.4% of users. The tree splits heavily penalize low age, categorizing all newer or zero-age profiles as high attrition risks.
                                    </p>
                                </div>
                                <!-- Why 2 -->
                                <div class="p-space-sm bg-surface-container-lowest rounded flex flex-col gap-1">
                                    <div class="flex items-center justify-between">
                                        <span class="font-label-technical text-[10px] text-secondary uppercase font-bold">Why 2: Why was account_age_months populated as 0.0?</span>
                                        <span class="material-symbols-outlined text-secondary text-[16px]">check_circle</span>
                                    </div>
                                    <p class="font-body-md text-body-md text-on-surface font-label-code bg-surface-container-low p-2 rounded">
                                        The serving gateway default fallback imputer (<span class="text-tertiary">SimpleImputer(strategy='constant', fill_value=0)</span>) silently filled null entries with zero instead of throwing a missing-feature exception.
                                    </p>
                                </div>
                                <!-- Why 3 -->
                                <div class="p-space-sm bg-surface-container-lowest rounded flex flex-col gap-1">
                                    <div class="flex items-center justify-between">
                                        <span class="font-label-technical text-[10px] text-secondary uppercase font-bold">Why 3: Why was account_age_months missing from the ingestion payload?</span>
                                        <span class="material-symbols-outlined text-secondary text-[16px]">check_circle</span>
                                    </div>
                                    <p class="font-body-md text-body-md text-on-surface font-label-code bg-surface-container-low p-2 rounded">
                                        Upstream CRM Team deployed schema v1.8, deprecating the derived integer column in favor of an ISO-8601 string <span class="text-secondary font-bold">creation_timestamp</span> without coordinating downstream ML inference contracts.
                                    </p>
                                </div>
                                <!-- Why 4 -->
                                <div class="p-space-sm bg-surface-container-lowest rounded flex flex-col gap-1">
                                    <div class="flex items-center justify-between">
                                        <span class="font-label-technical text-[10px] text-secondary uppercase font-bold">Why 4: Why did schema validation fail to halt corrupted payloads at the gateway?</span>
                                        <span class="material-symbols-outlined text-secondary text-[16px]">check_circle</span>
                                    </div>
                                    <p class="font-body-md text-body-md text-on-surface font-label-code bg-surface-container-low p-2 rounded">
                                        The feature store ingestion validator was configured with <span class="text-error font-bold">STRICT_VALIDATION=FALSE</span> (coercion mode) in the staging-to-prod environment sync to avoid dropping HTTP 500s.
                                    </p>
                                </div>
                                <!-- Why 5 - Root Cause -->
                                <div class="p-space-sm bg-surface-container-lowest rounded flex flex-col gap-1">
                                    <div class="flex items-center justify-between">
                                        <span class="font-label-technical text-[10px] text-tertiary uppercase font-bold">Why 5 (Root Cause): Fundamental architectural breakdown?</span>
                                        <span class="material-symbols-outlined text-tertiary text-[16px]">verified</span>
                                    </div>
                                    <div class="font-body-md text-body-md text-on-surface font-label-code bg-surface-container-high/60 p-space-sm rounded">
                                        <span class="text-tertiary font-bold">ROOT CAUSE STATEMENT:</span> Absence of pre-inference protobuf schema validation and missing dynamic feature engineering step for ISO timestamps allowed breaking data contracts to silently degrade feature distributions into default zero-imputation without triggerable pre-execution assertions.
                                    </div>
                                </div>
                            </div>
                        </section>
                        <!-- SECTION 5: REMEDIATION & EXECUTION -->
                        <section class="bg-surface-container rounded-xl p-space-lg shadow-md flex flex-col gap-space-md">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-space-sm">
                                    <span class="w-6 h-6 rounded bg-primary-container text-primary font-label-code text-label-code flex items-center justify-center font-bold">05</span>
                                    <h2 class="font-headline-md text-headline-md text-primary">Remediation &amp; Fix Executed</h2>
                                </div>
                                <span class="font-label-technical text-label-technical text-secondary uppercase">2-TIER HOTFIX COMPLETE</span>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-space-md">
                                <div class="p-space-md bg-surface-container-lowest rounded flex flex-col gap-space-sm">
                                    <div class="flex items-center justify-between">
                                        <span class="font-label-technical text-label-technical text-primary font-bold uppercase">Immediate Triage Fix</span>
                                        <span class="px-1.5 py-0.5 rounded bg-surface-container-high text-secondary font-label-code text-[10px]">APPLIED (04:48 UTC)</span>
                                    </div>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant">
                                        Rolled back inference pods to image <span class="font-label-code text-label-code text-on-surface font-semibold">churn_rf_v2:2.4.0</span>. Injected runtime assertion script rejecting payloads lacking non-null integer accounts.
                                    </p>
                                    <div class="bg-surface-container-low p-2 rounded text-[11px] font-label-code text-on-surface-variant">
                                        <code>git checkout tags/v2.4.0 &amp;&amp; kubectl rollout restart deployment/model-churn-rf-gateway</code>
                                    </div>
                                </div>
                                <div class="p-space-md bg-surface-container-lowest rounded flex flex-col gap-space-sm">
                                    <div class="flex items-center justify-between">
                                        <span class="font-label-technical text-label-technical text-primary font-bold uppercase">Permanent Architecture PR</span>
                                        <span class="px-1.5 py-0.5 rounded bg-tertiary-container text-tertiary font-label-code text-[10px]">PR #892 MERGED</span>
                                    </div>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant">
                                        Merged PR #892 in SYS-AI-03 adding dynamic transformer: derives <span class="font-label-code text-label-code text-secondary">account_age_months</span> from either ISO-8601 <span class="font-label-code text-label-code text-secondary">creation_timestamp</span> or legacy integer.
                                    </p>
                                    <div class="bg-surface-container-low p-2 rounded text-[11px] font-label-code text-on-surface-variant">
                                        <code>PR #892: feat(pipeline): add backward-compat timestamp derivation engine</code>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <!-- SECTION 6 & 7: PREVENTATIVE GUARDRAILS & RECOMMENDATIONS -->
                        <section class="bg-surface-container rounded-xl p-space-lg shadow-md flex flex-col gap-space-md">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-space-sm">
                                    <span class="w-6 h-6 rounded bg-primary-container text-primary font-label-code text-label-code flex items-center justify-center font-bold">06</span>
                                    <h2 class="font-headline-md text-headline-md text-primary">Preventative Engineering &amp; Strategic Recommendations</h2>
                                </div>
                                <span class="font-label-technical text-label-technical text-outline uppercase">SYS-AI-04 &amp; CRM COLLAB</span>
                            </div>
                            <div class="flex flex-col gap-space-sm">
                                <div class="p-space-md bg-surface-container-lowest rounded flex items-start gap-space-sm">
                                    <span class="material-symbols-outlined text-secondary text-[20px] shrink-0 mt-0.5">verified_user</span>
                                    <div class="flex flex-col">
                                        <span class="font-label-technical text-label-technical text-on-surface font-bold">Automated Statistical Drift Gates in CI/CD (SYS-AI-04)</span>
                                        <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">
                                            Integrated continuous Evidently &amp; Kolmogorov-Smirnov (KS &gt; 0.15 threshold) automated checks. If feature missingness exceeds 0.05% over a 500-sample window, traffic automatically diverts to shadow mode.
                                        </p>
                                    </div>
                                </div>
                                <div class="p-space-md bg-surface-container-lowest rounded flex items-start gap-space-sm">
                                    <span class="material-symbols-outlined text-tertiary text-[20px] shrink-0 mt-0.5">schema</span>
                                    <div class="flex flex-col">
                                        <span class="font-label-technical text-label-technical text-on-surface font-bold">Mandatory Breaking Schema Change RFC Policy (CRM Team SLA)</span>
                                        <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">
                                            Recommendation: Enforce Protobuf contract checking at the API gateway. Upstream CRM changes to upstream topic payloads must have at least 14 days deprecation overlap before key omission.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    <!-- RIGHT PANEL: RUBRIC EVALUATION & ATTACHED TELEMETRY EVIDENCE (4 Cols) -->
                    <div class="xl:col-span-4 flex flex-col gap-space-lg">
                        <!-- EVALUATION RUBRIC WIDGET -->
                        <div class="bg-surface-container rounded-xl p-space-lg shadow-md flex flex-col gap-space-md">
                            <div class="flex items-center justify-between">
                                <span class="font-label-technical text-label-technical text-outline uppercase tracking-wider">CERTIFICATION EVALUATION</span>
                                <span class="px-2 py-0.5 rounded bg-tertiary text-on-tertiary font-label-code text-[11px] font-bold">L3 HONORS READY</span>
                            </div>
                            <!-- Grade Ring & Score Overview -->
                            <div class="flex items-center gap-space-lg bg-surface-container-lowest p-space-md rounded">
                                <div class="relative w-20 h-20 shrink-0 flex items-center justify-center">
                                    <!-- Inline SVG Progress Ring -->
                                    <svg class="w-full h-full transform -rotate-90" viewbox="0 0 36 36">
                                        <path class="text-surface-container-high" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="3.5"></path>
                                        <path class="text-tertiary" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-dasharray="100, 100" stroke-linecap="round" stroke-width="3.5"></path>
                                    </svg>
                                    <div class="absolute flex flex-col items-center justify-center text-center">
                                        <span class="font-metric-display text-[22px] leading-tight text-tertiary font-bold">100</span>
                                        <span class="font-label-technical text-[9px] text-outline">PTS</span>
                                    </div>
                                </div>
                                <div class="flex flex-col min-w-0">
                                    <span class="font-headline-md text-headline-md text-on-surface font-bold leading-tight">100 / 100</span>
                                    <span class="font-body-sm text-body-sm text-secondary-fixed">Target: ≥85 pts required</span>
                                    <span class="font-label-technical text-[10px] text-tertiary uppercase mt-1">Rubric Criteria: 5/5 PASSED</span>
                                </div>
                            </div>
                            <!-- Rubric Line Items -->
                            <div class="flex flex-col gap-2 font-label-technical text-[11px]">
                                <div class="flex items-center justify-between p-2 rounded bg-surface-container-lowest">
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-secondary text-[16px]">check_circle</span>
                                        <span class="text-on-surface">Detection &amp; MTTD (&lt; 5m)</span>
                                    </div>
                                    <span class="font-label-code text-on-surface font-bold">15 / 15</span>
                                </div>
                                <div class="flex items-center justify-between p-2 rounded bg-surface-container-lowest">
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-secondary text-[16px]">check_circle</span>
                                        <span class="text-on-surface">Evidence &amp; Telemetry Isolation</span>
                                    </div>
                                    <span class="font-label-code text-on-surface font-bold">20 / 20</span>
                                </div>
                                <div class="flex items-center justify-between p-2 rounded bg-surface-container-lowest">
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-secondary text-[16px]">check_circle</span>
                                        <span class="text-on-surface">Root Cause Precision (5-Whys)</span>
                                    </div>
                                    <span class="font-label-code text-on-surface font-bold">25 / 25</span>
                                </div>
                                <div class="flex items-center justify-between p-2 rounded bg-surface-container-lowest">
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-secondary text-[16px]">check_circle</span>
                                        <span class="text-on-surface">Remediation Canary Rollback</span>
                                    </div>
                                    <span class="font-label-code text-on-surface font-bold">20 / 20</span>
                                </div>
                                <div class="flex items-center justify-between p-2 rounded bg-surface-container-lowest">
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-secondary text-[16px]">check_circle</span>
                                        <span class="text-on-surface">Preventative Guardrails (CI/CD)</span>
                                    </div>
                                    <span class="font-label-code text-on-surface font-bold">20 / 20</span>
                                </div>
                            </div>
                            <!-- Instructor Feedback Preview Card -->
                            <div class="bg-surface-container-lowest p-space-md rounded flex flex-col gap-space-sm mt-1">
                                <div class="flex items-center gap-space-sm">
                                    <div class="w-7 h-7 rounded-full bg-secondary text-on-secondary flex items-center justify-center font-bold text-xs">
                                        ER
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-label-technical text-label-technical text-on-surface font-bold">Dr. Elena Romanova</span>
                                        <span class="font-label-code text-[10px] text-tertiary">SENIOR ML ARCHITECT &amp; EVALUATOR</span>
                                    </div>
                                </div>
                                <p class="font-body-sm text-body-sm text-on-surface-variant italic bg-surface-container-low p-space-sm rounded">
                                    "Alexei - exceptionally rigorous isolation of the upstream schema anomaly. The KS-test verification card and Canary Rollback hash are verified against SYS-AI-04 logs. Ensure permanent contract testing is committed to SYS-AI-01 before final certification submission."
                                </p>
                            </div>
                        </div>
                        <!-- AUTO-ATTACHED TELEMETRY EVIDENCE CARDS -->
                        <div class="bg-surface-container rounded-xl p-space-lg shadow-md flex flex-col gap-space-md">
                            <div class="flex items-center justify-between">
                                <span class="font-label-technical text-label-technical text-outline uppercase tracking-wider">PINNED EVIDENCE BUNDLE</span>
                                <span class="font-label-code text-label-code text-secondary">3 ARTIFACTS</span>
                            </div>
                            <!-- Mini Card A: F1 Breach Graph -->
                            <div class="p-space-sm bg-surface-container-lowest rounded flex flex-col gap-2">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-1.5">
                                        <span class="w-2 h-2 rounded-full bg-error"></span>
                                        <span class="font-label-technical text-label-technical font-semibold text-on-surface">Telemetry Breach Snapshot</span>
                                    </div>
                                    <span class="font-label-code text-[10px] text-outline">#INC-4092-F1</span>
                                </div>
                                <!-- Sparkline SVG -->
                                <div class="h-20 w-full bg-surface-container-low rounded p-2 flex flex-col justify-between">
                                    <div class="flex justify-between items-center text-[10px] font-label-code text-outline">
                                        <span>SLA SLA 0.80</span>
                                        <span class="text-error font-bold">0.61 (Collapse)</span>
                                    </div>
                                    <svg class="w-full h-8 overflow-visible" preserveaspectratio="none" viewbox="0 0 100 24">
                                        <!-- Threshold Line -->
                                        <line class="text-outline/40" stroke="currentColor" stroke-dasharray="2,2" stroke-width="0.8" x1="0" x2="100" y1="8" y2="8"></line>
                                        <!-- Breach Line Graph -->
                                        <polyline class="text-error" fill="none" points="0,6 20,6 40,7 50,22 65,22 80,7 100,6" stroke="currentColor" stroke-width="1.8"></polyline>
                                    </svg>
                                    <div class="flex justify-between items-center text-[9px] font-label-code text-outline">
                                        <span>04:00</span>
                                        <span>04:18 (Breach)</span>
                                        <span>04:52 (Resolved)</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Mini Card B: Feature Drift Matrix -->
                            <div class="p-space-sm bg-surface-container-lowest rounded flex flex-col gap-2">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-1.5">
                                        <span class="w-2 h-2 rounded-full bg-tertiary"></span>
                                        <span class="font-label-technical text-label-technical font-semibold text-on-surface">Evidently Drift Analysis</span>
                                    </div>
                                    <span class="font-label-code text-[10px] text-tertiary">KS = 0.4218</span>
                                </div>
                                <div class="bg-surface-container-low p-2 rounded flex flex-col gap-1 font-label-code text-[11px]">
                                    <div class="flex justify-between text-on-surface-variant">
                                        <span>account_age_months:</span>
                                        <span class="text-error font-bold">78.4% Zeroes</span>
                                    </div>
                                    <div class="w-full bg-surface-container-high h-1.5 rounded overflow-hidden">
                                        <div class="bg-error h-full" style="width: 78.4%;"></div>
                                    </div>
                                    <span class="text-[10px] text-outline">Baseline missingness: 0.02% | Drift: CRITICAL</span>
                                </div>
                            </div>
                            <!-- Mini Card C: Canary Rollback Log -->
                            <div class="p-space-sm bg-surface-container-lowest rounded flex flex-col gap-2">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-1.5">
                                        <span class="w-2 h-2 rounded-full bg-secondary-fixed"></span>
                                        <span class="font-label-technical text-label-technical font-semibold text-on-surface">CI/CD Canary Rollback Log</span>
                                    </div>
                                    <span class="font-label-code text-[10px] text-secondary">SYS-AI-04</span>
                                </div>
                                <div class="bg-surface-container-low p-2 rounded font-label-code text-[10px] text-on-surface-variant flex flex-col gap-0.5">
                                    <span class="text-secondary-fixed font-bold">&gt; DEPLOY: canary_switch(v2.4.1 -&gt; v2.4.0)</span>
                                    <span>&gt; PODS_HEALTHY: 16/16 replicas ready</span>
                                    <span class="text-tertiary">&gt; STATUS: CONTRACT RESTORED IN 240s</span>
                                </div>
                            </div>
                        </div>
                        <!-- VISUAL POST-MORTEM VERIFICATION BADGE -->
                        <div class="bg-gradient-to-br from-surface-container via-surface-container-low to-surface-container-lowest p-space-md rounded-xl flex items-center gap-space-md shadow-md">
                            <div class="w-12 h-12 rounded bg-tertiary-container flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-tertiary text-[28px]">military_tech</span>
                            </div>
                            <div class="flex flex-col min-w-0">
                                <span class="font-label-technical text-label-technical text-tertiary font-bold tracking-wider">LEVEL 3 CERTIFICATION READY</span>
                                <span class="font-body-sm text-body-sm text-on-surface-variant">Submission will finalize Alexei V.'s certification record in SYS-AI-01 Objectives Hub.</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- CLIENT-SIDE NOTIFICATION MODAL & INTERACTION HANDLER -->
                <div class="fixed inset-0 z-50 flex items-center justify-center bg-surface-container-lowest/80 backdrop-blur-md hidden opacity-0 transition-opacity duration-300" id="submissionDialog">
                    <div class="bg-surface-container-high p-space-xl rounded-xl max-w-md w-full shadow-2xl flex flex-col gap-space-md mx-4">
                        <div class="flex items-center gap-space-sm text-tertiary">
                            <span class="material-symbols-outlined text-[32px]">verified</span>
                            <h3 class="font-headline-md text-headline-md text-primary">Report Submitted</h3>
                        </div>
                        <p class="font-body-md text-body-md text-on-surface leading-relaxed">
                            Incident Report <span class="font-label-code text-label-code text-secondary">#INC-4092</span> and evidence bundle have been transmitted to the instructor pipeline. Evaluation score <span class="font-label-code text-tertiary font-bold">100/100</span> recorded in SYS-AI-01 Objectives Hub.
                        </p>
                        <div class="bg-surface-container-lowest p-space-sm rounded font-label-code text-[11px] text-on-surface-variant flex flex-col gap-1">
                            <span>TX_HASH: 0x8892f_vostok_l3_certified</span>
                            <span class="text-secondary-fixed">STATUS: SUBMITTED FOR FINAL BADGE DISPATCH</span>
                        </div>
                        <div class="flex justify-end pt-space-xs">
                            <button class="px-space-lg py-space-sm bg-tertiary text-on-tertiary font-label-technical text-label-technical font-bold rounded hover:bg-on-tertiary-container transition-colors" id="closeModalBtn">
                                RETURN TO DRILL HUB
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