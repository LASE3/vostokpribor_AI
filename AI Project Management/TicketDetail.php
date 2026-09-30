<?php
require_once __DIR__ . '/../config/config.php';
apply_perf_headers();
?>
<!DOCTYPE html>
<html class="dark" lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="web_dashboard" name="shell-type">
    <title>Ticket Detail #AI-024 · SYS-AI Projects · VOSTOKPRIBOR</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@100..900&amp;family=Inter:wght@100..900&amp;family=Space+Mono:wght@100..900&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/global.css" />
    <link rel="stylesheet" href="css/style.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="js/tailwind.config.js"></script>
</head>

<body class="bg-surface font-body-md text-on-surface">
    <!-- Left Hover Telemetry Rail -->
    <aside class="group/rail fixed left-0 top-0 h-full w-16 hover:w-64 bg-surface-container-low z-50 flex flex-col justify-between shadow-md transition-all duration-300 ease-in-out overflow-hidden whitespace-nowrap">
        <div class="flex flex-col">
            <div class="h-16 px-4 flex items-center gap-space-sm bg-surface-container-lowest shrink-0 overflow-hidden">
                <a href="../index.php" title="Return to Core 5-System Portal" class="flex items-center gap-space-sm shrink-0">
                    <img alt="VOSTOKPRIBOR Industrial AI Logo" class="h-8 w-8 object-contain shrink-0" src="https://lh3.googleusercontent.com/aida/AEtjO1W0pnhS8IEaoTn70IOGIuwcWNpNgh10xzjUL5_oCtxmTZj8xgF1DI7e0F5iyT9zuQXrKTSp8fVISDLajw0cOVTlsEJPJrw3qV9YjP2k2JzO1v07n2BIvWyOQ5iikdzARo6tUdO70wQtL3rfgjs-8WdFHO9vFslvSDw0chLlp2BAZ27-Xf1xpu_2HcIYL1r5bO9UnamptMdIQ9n5jEdsmz-3oTg0r8nFbGeBPfgRIO6XOLSGrkRx6lGMUYj8">
                    <div class="flex flex-col opacity-0 group-hover/rail:opacity-100 transition-opacity duration-300">
                        <span class="font-label-caps text-label-caps text-on-surface tracking-wider uppercase whitespace-nowrap">VOSTOKPRIBOR</span>
                        <span class="font-label-mono-sm text-label-mono-sm text-primary whitespace-nowrap">SYS-AI CORE ENGINE</span>
                    </div>
                </a>
            </div>
            <div class="px-2 py-space-sm overflow-hidden">
                <div class="font-label-mono-sm text-label-mono-sm text-outline uppercase tracking-wider mb-space-xs px-2 opacity-0 group-hover/rail:opacity-100 transition-opacity whitespace-nowrap">Telemetry Rail</div>
                <nav class="flex flex-col gap-space-xs" data-active-classes="bg-surface-container-high text-primary font-headline-sm">
                    <a class="group flex items-center justify-between px-3 py-space-sm rounded bg-surface-container-high text-primary hover:bg-surface-container hover:text-on-surface transition-colors" data-path="projects" href="Dashboard.php" title="SYS-AI-01 Projects">
                        <div class="flex items-center gap-space-sm min-w-0">
                            <span class="w-2 h-2 shrink-0 rounded-full bg-primary animate-pulse"></span>
                            <span class="font-label-caps text-label-caps opacity-0 group-hover/rail:opacity-100 transition-opacity whitespace-nowrap">SYS-AI-01 Projects</span>
                        </div>
                        <span class="font-label-mono-sm text-label-mono-sm text-primary opacity-0 group-hover/rail:opacity-100 transition-opacity whitespace-nowrap">ACT</span>
                    </a>
                    <a class="group flex items-center justify-between px-3 py-space-sm rounded text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="data-center" href="../Data Center/DatasetCatalog.php" title="SYS-AI-02 Data Center">
                        <div class="flex items-center gap-space-sm min-w-0">
                            <span class="w-2 h-2 shrink-0 rounded-full bg-outline-variant"></span>
                            <span class="font-label-caps text-label-caps opacity-0 group-hover/rail:opacity-100 transition-opacity whitespace-nowrap">SYS-AI-02 Data Center</span>
                        </div>
                        <span class="font-label-mono-sm text-label-mono-sm text-on-surface-variant opacity-0 group-hover/rail:opacity-100 transition-opacity whitespace-nowrap">SYNC</span>
                    </a>
                    <a class="group flex items-center justify-between px-3 py-space-sm rounded text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="workbench" href="../AI/ML Workbench/WorkbenchHome.php" title="SYS-AI-03 Workbench">
                        <div class="flex items-center gap-space-sm min-w-0">
                            <span class="w-2 h-2 shrink-0 rounded-full bg-outline-variant"></span>
                            <span class="font-label-caps text-label-caps opacity-0 group-hover/rail:opacity-100 transition-opacity whitespace-nowrap">SYS-AI-03 Workbench</span>
                        </div>
                        <span class="font-label-mono-sm text-label-mono-sm text-on-surface-variant opacity-0 group-hover/rail:opacity-100 transition-opacity whitespace-nowrap">RDY</span>
                    </a>
                    <a class="group flex items-center justify-between px-3 py-space-sm rounded text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="registry-deployment" href="../Model Registry & Deployment/ModelRegistry.php" title="SYS-AI-04 Registry & Deploy">
                        <div class="flex items-center gap-space-sm min-w-0">
                            <span class="w-2 h-2 shrink-0 rounded-full bg-outline-variant"></span>
                            <span class="font-label-caps text-label-caps opacity-0 group-hover/rail:opacity-100 transition-opacity whitespace-nowrap">SYS-AI-04 Registry &amp; Deploy</span>
                        </div>
                        <span class="font-label-mono-sm text-label-mono-sm text-on-surface-variant opacity-0 group-hover/rail:opacity-100 transition-opacity whitespace-nowrap">v2.4</span>
                    </a>
                    <a class="group flex items-center justify-between px-3 py-space-sm rounded text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="ai-soc" href="../AI Operations Center (AI SOC)/FleetTelemetry.php" title="SYS-AI-05 AI SOC">
                        <div class="flex items-center gap-space-sm min-w-0">
                            <span class="w-2 h-2 shrink-0 rounded-full bg-tertiary"></span>
                            <span class="font-label-caps text-label-caps opacity-0 group-hover/rail:opacity-100 transition-opacity whitespace-nowrap">SYS-AI-05 AI SOC</span>
                        </div>
                        <span class="font-label-mono-sm text-label-mono-sm text-tertiary opacity-0 group-hover/rail:opacity-100 transition-opacity whitespace-nowrap">SEC</span>
                    </a>
                </nav>
            </div>
        </div>
        <div class="p-space-md bg-surface-container-lowest flex flex-col gap-space-xs overflow-hidden shrink-0">
            <div class="flex items-center gap-space-xs min-w-0">
                <span class="inline-block w-2 h-2 rounded-full bg-tertiary shrink-0"></span>
                <span class="font-label-mono-sm text-label-mono-sm text-tertiary opacity-0 group-hover/rail:opacity-100 transition-opacity whitespace-nowrap">SYS-AI ONLINE</span>
            </div>
            <div class="font-label-mono-sm text-label-mono-sm text-on-surface-variant opacity-0 group-hover/rail:opacity-100 transition-opacity whitespace-nowrap">LATENCY 14ms · ALMATY DC-01</div>
            <div class="font-label-mono-sm text-label-mono-sm text-outline opacity-0 group-hover/rail:opacity-100 transition-opacity whitespace-nowrap">UPTIME 99.98% · NODE_ID: 884-A</div>
        </div>
    </aside>

    <!-- Main Container -->
    <div class="pl-16 transition-all duration-300">
        <!-- Top App Bar & Stage Rail -->
        <header class="fixed top-0 left-16 right-0 z-40 bg-surface/90 backdrop-blur-xl shadow-[0_1px_8px_rgba(0,0,0,0.04)] transition-all">
            <div class="h-16 px-space-lg flex items-center justify-between gap-space-md">
                <div class="flex items-center gap-space-md">
                    <span class="font-headline-sm text-headline-sm text-on-surface tracking-tight whitespace-nowrap">VOSTOKPRIBOR · SYS-AI INDUSTRIAL PORTAL</span>
                    <div class="relative flex items-center bg-surface-container px-space-sm py-space-xs rounded w-64">
                        <span class="material-symbols-outlined text-outline text-[18px] mr-space-xs">search</span>
                        <input class="bg-transparent w-full text-on-surface placeholder:text-outline font-body-sm text-body-sm focus:outline-none" placeholder="Search telemetry, jobs..." type="text">
                        <span class="font-label-mono-sm text-label-mono-sm bg-surface-container-high text-on-surface-variant px-1 rounded">⌘K</span>
                    </div>
                </div>
                <div class="flex items-center gap-space-md">
                    <div class="flex items-center bg-surface-container rounded p-0.5">
                        <button class="px-space-sm py-space-xs font-label-caps text-label-caps rounded bg-primary-container text-on-primary-container">Student</button>
                        <a href="InstructorDashboard.php" class="px-space-sm py-space-xs font-label-caps text-label-caps rounded text-on-surface-variant hover:text-on-surface">Instructor</a>
                    </div>
                    <div class="flex items-center bg-surface-container rounded px-space-xs py-space-xs font-label-mono-sm text-label-mono-sm">
                        <span class="px-1.5 py-0.5 rounded bg-surface-bright text-on-surface">EN</span>
                        <span class="px-1.5 py-0.5 text-on-surface-variant">AR</span>
                    </div>
                    <div class="relative flex items-center justify-center p-space-xs rounded bg-surface-container text-on-surface-variant hover:text-on-surface">
                        <span class="material-symbols-outlined text-[20px]">notifications</span>
                        <span class="absolute -top-1 -right-1 w-4 h-4 rounded-full bg-error text-on-error font-label-mono-sm text-label-mono-sm flex items-center justify-center">3</span>
                    </div>
                    <div class="flex items-center gap-space-sm pl-space-sm bg-surface-container rounded-lg p-space-xs">
                        <div class="flex flex-col text-right">
                            <span class="font-label-caps text-label-caps text-on-surface">Gulkaba T.</span>
                            <span class="font-label-mono-sm text-label-mono-sm text-primary">Intern AI Engineer · L2</span>
                        </div>
                        <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center">
                            <span class="material-symbols-outlined text-on-primary text-[18px]">person</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Sub-Navigation Navigation Strip -->
            <div class="h-10 px-space-lg flex items-center justify-between bg-surface-container-low">
                <nav class="flex items-center gap-space-xs" data-active-classes="bg-primary text-on-primary font-bold rounded-full">
                    <a class="px-space-sm py-0.5 rounded-full font-label-caps text-label-caps text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="dashboard" href="Dashboard.php">Dashboard</a>
                    <a class="px-space-sm py-0.5 rounded-full font-label-caps text-label-caps text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="ticket-board" href="TicketBoard.php">Ticket Board</a>
                    <a aria-current="page" class="px-space-sm py-0.5 transition-colors bg-primary text-on-primary font-bold rounded-full shadow-sm" data-path="ticket-detail-ai-024" href="TicketDetail.php">Ticket Detail #AI-024</a>
                    <a class="px-space-sm py-0.5 rounded-full font-label-caps text-label-caps text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="submissions" href="DeliverablesAndSubmissionPanel.php">Submissions</a>
                    <a class="px-space-sm py-0.5 rounded-full font-label-caps text-label-caps text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="evaluation" href="EvaluationView.php">Evaluation</a>
                    <a class="px-space-sm py-0.5 rounded-full font-label-caps text-label-caps text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="instructor-portal" href="InstructorDashboard.php">Instructor Portal</a>
                </nav>
                <div class="flex items-center gap-space-xs font-label-mono-sm text-label-mono-sm text-outline">
                    <span class="material-symbols-outlined text-[14px] text-tertiary">sync</span>
                    <span>BUFFER 100% NOMINAL</span>
                </div>
            </div>
            <!-- 14-Stage Industrial Workflow Progress Strip -->
            <div class="h-10 px-space-lg bg-surface-container-lowest flex items-center overflow-x-auto gap-space-xs">
                <div class="flex items-center gap-1 shrink-0"><span class="w-4 h-4 rounded-full bg-tertiary text-on-tertiary font-label-mono-sm text-label-mono-sm flex items-center justify-center">✓</span><span class="font-label-mono-sm text-label-mono-sm text-on-surface">1 Request</span></div><span class="text-outline text-label-mono-sm">—</span>
                <div class="flex items-center gap-1 shrink-0"><span class="w-4 h-4 rounded-full bg-tertiary text-on-tertiary font-label-mono-sm text-label-mono-sm flex items-center justify-center">✓</span><span class="font-label-mono-sm text-label-mono-sm text-on-surface">2 Problem</span></div><span class="text-outline text-label-mono-sm">—</span>
                <div class="flex items-center gap-1 shrink-0"><span class="w-4 h-4 rounded-full bg-tertiary text-on-tertiary font-label-mono-sm text-label-mono-sm flex items-center justify-center">✓</span><span class="font-label-mono-sm text-label-mono-sm text-on-surface">3 Collection</span></div><span class="text-outline text-label-mono-sm">—</span>
                <div class="flex items-center gap-1 shrink-0"><span class="w-4 h-4 rounded-full bg-tertiary text-on-tertiary font-label-mono-sm text-label-mono-sm flex items-center justify-center">✓</span><span class="font-label-mono-sm text-label-mono-sm text-on-surface">4 EDA</span></div><span class="text-outline text-label-mono-sm">—</span>
                <div class="flex items-center gap-1 shrink-0"><span class="w-4 h-4 rounded-full bg-tertiary text-on-tertiary font-label-mono-sm text-label-mono-sm flex items-center justify-center">✓</span><span class="font-label-mono-sm text-label-mono-sm text-on-surface">5 Clean</span></div><span class="text-outline text-label-mono-sm">—</span>
                <div class="flex items-center gap-1 shrink-0"><span class="w-4 h-4 rounded-full bg-tertiary text-on-tertiary font-label-mono-sm text-label-mono-sm flex items-center justify-center">✓</span><span class="font-label-mono-sm text-label-mono-sm text-on-surface">6 Features</span></div><span class="text-outline text-label-mono-sm">—</span>
                <div class="flex items-center gap-1 shrink-0"><span class="w-4 h-4 rounded-full bg-tertiary text-on-tertiary font-label-mono-sm text-label-mono-sm flex items-center justify-center">✓</span><span class="font-label-mono-sm text-label-mono-sm text-on-surface">7 Build</span></div><span class="text-outline text-label-mono-sm">—</span>
                <div class="flex items-center gap-1 shrink-0 bg-primary-container px-space-xs py-0.5 rounded shadow-sm"><span class="w-4 h-4 rounded-full bg-on-primary-container text-primary-container font-label-mono-sm text-label-mono-sm flex items-center justify-center animate-pulse font-bold">8</span><span class="font-label-mono-sm text-label-mono-sm text-on-primary-container font-bold">8 Eval</span></div><span class="text-outline text-label-mono-sm">—</span>
                <div class="flex items-center gap-1 shrink-0 opacity-60"><span class="w-4 h-4 rounded-full bg-surface-container-high text-on-surface font-label-mono-sm text-label-mono-sm flex items-center justify-center">9</span><span class="font-label-mono-sm text-label-mono-sm text-on-surface-variant">9 Improve</span></div><span class="text-outline text-label-mono-sm">—</span>
                <div class="flex items-center gap-1 shrink-0 opacity-60"><span class="w-4 h-4 rounded-full bg-surface-container-high text-on-surface font-label-mono-sm text-label-mono-sm flex items-center justify-center">10</span><span class="font-label-mono-sm text-label-mono-sm text-on-surface-variant">10 Deploy</span></div><span class="text-outline text-label-mono-sm">—</span>
                <div class="flex items-center gap-1 shrink-0 opacity-60"><span class="w-4 h-4 rounded-full bg-surface-container-high text-on-surface font-label-mono-sm text-label-mono-sm flex items-center justify-center">11</span><span class="font-label-mono-sm text-label-mono-sm text-on-surface-variant">11 Integrate</span></div><span class="text-outline text-label-mono-sm">—</span>
                <div class="flex items-center gap-1 shrink-0 opacity-60"><span class="w-4 h-4 rounded-full bg-surface-container-high text-on-surface font-label-mono-sm text-label-mono-sm flex items-center justify-center">12</span><span class="font-label-mono-sm text-label-mono-sm text-on-surface-variant">12 Monitor</span></div><span class="text-outline text-label-mono-sm">—</span>
                <div class="flex items-center gap-1 shrink-0 opacity-60"><span class="w-4 h-4 rounded-full bg-surface-container-high text-on-surface font-label-mono-sm text-label-mono-sm flex items-center justify-center">13</span><span class="font-label-mono-sm text-label-mono-sm text-on-surface-variant">13 Drift</span></div><span class="text-outline text-label-mono-sm">—</span>
                <div class="flex items-center gap-1 shrink-0 opacity-60"><span class="w-4 h-4 rounded-full bg-surface-container-high text-on-surface font-label-mono-sm text-label-mono-sm flex items-center justify-center">14</span><span class="font-label-mono-sm text-label-mono-sm text-on-surface-variant">14 Report</span></div>
            </div>
        </header>

        <!-- Main Body -->
        <main class="relative pt-36 bg-surface min-h-screen">
            <div class="flex flex-col w-full">
                <div class="p-space-lg lg:p-space-xl flex flex-col gap-space-lg max-w-[1720px] mx-auto w-full">
                    
                    <!-- BREADCRUMBS & ACTION STRIP -->
                    <div class="flex flex-wrap items-center justify-between gap-space-md bg-surface-container-low p-space-md rounded-xl shadow-sm">
                        <div class="flex items-center gap-2 font-label-mono-sm text-label-mono-sm text-outline uppercase tracking-wider flex-wrap">
                            <a href="Dashboard.php" class="hover:text-primary transition-colors">SYS-AI-01 PROJECTS</a>
                            <span>/</span>
                            <a href="TicketBoard.php" class="hover:text-primary transition-colors">TICKET BOARD</a>
                            <span>/</span>
                            <span class="text-primary font-bold">#AI-024</span>
                            <span>/</span>
                            <span class="text-on-surface font-semibold">TICKET SPECIFICATION &amp; PRODUCTION GATE</span>
                        </div>
                        <div class="flex items-center gap-space-xs flex-wrap">
                            <a href="../AI/ML Workbench/WorkbenchHome.php" class="px-space-md py-1.5 rounded-lg bg-surface-container-high hover:bg-surface-bright text-on-surface font-label-mono-sm text-label-mono-sm flex items-center gap-1.5 shadow-sm transition-all">
                                <span class="material-symbols-outlined text-[15px] text-primary">science</span>
                                Open in ML Workbench
                            </a>
                            <a href="DeliverablesAndSubmissionPanel.php" class="px-space-md py-1.5 rounded-lg bg-secondary-container hover:bg-secondary text-on-secondary font-label-caps text-label-caps font-bold flex items-center gap-1.5 shadow-sm transition-all">
                                <span class="material-symbols-outlined text-[16px]">publish</span>
                                Verify Deliverables Gate
                            </a>
                            <a href="EvaluationView.php" class="px-space-md py-1.5 rounded-lg bg-primary hover:bg-primary-fixed-dim text-on-primary font-label-caps text-label-caps font-bold flex items-center gap-1.5 shadow-md transition-all">
                                <span class="material-symbols-outlined text-[16px]">grade</span>
                                Rubric Evaluation
                            </a>
                        </div>
                    </div>

                    <!-- HERO TICKET BANNER CARD -->
                    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-surface-container via-surface-container-low to-surface-container-lowest p-space-lg lg:p-space-xl border border-primary/20 shadow-xl">
                        <div class="absolute -right-16 -top-16 w-80 h-80 rounded-full bg-primary/10 blur-3xl pointer-events-none"></div>
                        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-space-lg relative z-10">
                            <div class="flex flex-col gap-space-sm max-w-4xl">
                                <div class="flex items-center gap-space-sm flex-wrap">
                                    <span class="px-3 py-1 rounded font-label-mono-md text-label-mono-md bg-primary text-on-primary font-bold tracking-tight shadow">
                                        TICKET #AI-024
                                    </span>
                                    <span class="px-2.5 py-1 rounded font-label-caps text-label-caps bg-error-container text-on-error-container font-bold shadow-sm flex items-center gap-1.5">
                                        <span class="w-2 h-2 rounded-full bg-error animate-ping"></span>
                                        HIGH PRIORITY // GATE REVIEW
                                    </span>
                                    <span class="px-2.5 py-1 rounded font-label-mono-sm text-label-mono-sm bg-surface-container-high text-secondary border border-secondary/20">
                                        PHASE III: MODEL &amp; EVAL (STAGES 07–09)
                                    </span>
                                    <span class="px-2 py-0.5 rounded font-label-mono-sm text-label-mono-sm bg-surface-container text-outline">
                                        SPRINT 24-B ALPHA
                                    </span>
                                </div>
                                <h1 class="font-headline-lg text-headline-lg text-on-surface tracking-tight mt-1">
                                    Industrial Customer Churn MVP — Predictive Telemetry Classifier
                                </h1>
                                <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">
                                    High-frequency optical sensor telemetry and customer engagement degradation pipeline for client <span class="text-secondary font-mono font-bold">CUS-1001 (Aral Geomatics Group)</span>. Primary task is to classify contract churn risk 30 days prior to contract renewal with sub-25ms inference latency.
                                </p>
                            </div>
                            <!-- Telemetry Gate Status Block -->
                            <div class="flex flex-col sm:flex-row lg:flex-col gap-space-sm shrink-0 bg-surface-container-lowest/80 backdrop-blur-md p-space-md rounded-xl border border-outline-variant/30 min-w-[280px]">
                                <div class="flex items-center justify-between">
                                    <span class="font-label-mono-sm text-label-mono-sm text-outline">PRIMARY THRESHOLD:</span>
                                    <span class="font-label-mono-sm text-label-mono-sm text-on-surface font-bold">TARGET F1 &ge; 0.80</span>
                                </div>
                                <div class="flex items-baseline justify-between">
                                    <span class="font-headline-lg text-headline-lg font-mono text-primary font-bold">0.781</span>
                                    <span class="px-2 py-0.5 rounded font-label-mono-sm text-label-mono-sm bg-error-container/30 text-error font-bold flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[13px]">warning</span>
                                        -0.019 GAP
                                    </span>
                                </div>
                                <div class="w-full bg-surface-container-high h-2 rounded-full overflow-hidden">
                                    <div class="bg-primary h-full rounded-full transition-all" style="width: 78.1%;"></div>
                                </div>
                                <div class="flex items-center justify-between pt-1 border-t border-surface-container font-label-mono-sm text-label-mono-sm text-outline">
                                    <span class="flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[14px] text-primary animate-pulse">timer</span>
                                        REMAINING SLA:
                                    </span>
                                    <span class="text-primary font-bold font-mono">18h 42m 14s</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 12-COLUMN MAIN DETAIL GRID -->
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-lg items-start">
                        
                        <!-- LEFT COLUMN: CORE SPECIFICATION & WORKFLOW (8 cols) -->
                        <div class="lg:col-span-8 flex flex-col gap-space-lg">
                            
                            <!-- 1. OPERATIONAL SCENARIO & BUSINESS CONTEXT -->
                            <div class="bg-surface-container rounded-xl p-space-lg shadow-md flex flex-col gap-space-md">
                                <div class="flex items-center justify-between border-b border-surface-container-high pb-space-sm">
                                    <div class="flex items-center gap-space-sm">
                                        <span class="material-symbols-outlined text-primary text-[22px]">domain_verification</span>
                                        <h2 class="font-headline-md text-headline-md text-on-surface font-semibold tracking-tight">
                                            Operational Scenario &amp; Business Specifications
                                        </h2>
                                    </div>
                                    <span class="font-label-mono-sm text-label-mono-sm text-outline uppercase">SPEC_ID: IND-SCN-01</span>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-space-sm">
                                    <div class="p-space-sm rounded-lg bg-surface-container-low flex flex-col">
                                        <span class="font-label-mono-sm text-label-mono-sm text-outline">CLIENT ENTITY</span>
                                        <span class="font-label-caps text-label-caps text-secondary font-bold mt-1">Aral Geomatics Group</span>
                                        <span class="font-label-mono-sm text-label-mono-sm text-on-surface-variant">CUS-1001 · Enterprise</span>
                                    </div>
                                    <div class="p-space-sm rounded-lg bg-surface-container-low flex flex-col">
                                        <span class="font-label-mono-sm text-label-mono-sm text-outline">OPERATIONAL DOMAIN</span>
                                        <span class="font-label-caps text-label-caps text-on-surface font-bold mt-1">Optical Telemetry QC</span>
                                        <span class="font-label-mono-sm text-label-mono-sm text-on-surface-variant">Subsea / Terrestrial Sensors</span>
                                    </div>
                                    <div class="p-space-sm rounded-lg bg-surface-container-low flex flex-col">
                                        <span class="font-label-mono-sm text-label-mono-sm text-outline">TARGET HORIZON</span>
                                        <span class="font-label-caps text-label-caps text-tertiary font-bold mt-1">30-Day Churn Event</span>
                                        <span class="font-label-mono-sm text-label-mono-sm text-on-surface-variant">Daily Batch &amp; Realtime Stream</span>
                                    </div>
                                </div>
                                <div class="font-body-md text-body-md text-on-surface-variant space-y-2">
                                    <p>
                                        Aral Geomatics deploys 140+ high-precision optical surveying devices across harsh mining environments. When calibration errors occur, telemetry signals exhibit frequency attenuation and thermal variance anomalies. Undetected hardware degradation leads directly to contractual cancellations.
                                    </p>
                                    <p>
                                        This model acts as an automated early warning sentinel, triggering proactive service visits and hardware recalibration 30 days prior to contract renegotiation.
                                    </p>
                                </div>
                            </div>

                            <!-- 2. ACCEPTANCE CRITERIA & PRODUCTION GATES -->
                            <div class="bg-surface-container rounded-xl p-space-lg shadow-md flex flex-col gap-space-md">
                                <div class="flex items-center justify-between border-b border-surface-container-high pb-space-sm">
                                    <div class="flex items-center gap-space-sm">
                                        <span class="material-symbols-outlined text-secondary text-[22px]">checklist_rtl</span>
                                        <h2 class="font-headline-md text-headline-md text-on-surface font-semibold tracking-tight">
                                            Acceptance Criteria &amp; Validation Checklist
                                        </h2>
                                    </div>
                                    <span class="font-label-mono-sm text-label-mono-sm text-primary font-bold">5 / 7 COMPLETED (71%)</span>
                                </div>
                                <div class="flex flex-col gap-space-xs">
                                    <!-- Item 1 -->
                                    <label class="flex items-start gap-space-sm p-space-sm rounded-lg bg-surface-container-low hover:bg-surface-container-high transition-colors cursor-pointer">
                                        <input type="checkbox" checked class="mt-1 w-4 h-4 rounded text-primary bg-surface-container-high border-outline focus:ring-0">
                                        <div class="flex flex-col flex-1">
                                            <div class="flex items-center justify-between">
                                                <span class="font-headline-sm text-headline-sm text-on-surface line-through text-outline">AC-01: Ingest &amp; Partition Telemetry Dataset</span>
                                                <span class="px-2 py-0.5 rounded font-label-mono-sm text-label-mono-sm bg-tertiary/20 text-tertiary font-bold">VERIFIED</span>
                                            </div>
                                            <span class="font-body-sm text-body-sm text-outline">Ingested 14.2M records across 12 calendar months from SYS-AI-02 Data Center (DATA-TEL-9014).</span>
                                        </div>
                                    </label>
                                    <!-- Item 2 -->
                                    <label class="flex items-start gap-space-sm p-space-sm rounded-lg bg-surface-container-low hover:bg-surface-container-high transition-colors cursor-pointer">
                                        <input type="checkbox" checked class="mt-1 w-4 h-4 rounded text-primary bg-surface-container-high border-outline focus:ring-0">
                                        <div class="flex flex-col flex-1">
                                            <div class="flex items-center justify-between">
                                                <span class="font-headline-sm text-headline-sm text-on-surface line-through text-outline">AC-02: Sensor Deadband &amp; Noise Imputation</span>
                                                <span class="px-2 py-0.5 rounded font-label-mono-sm text-label-mono-sm bg-tertiary/20 text-tertiary font-bold">VERIFIED</span>
                                            </div>
                                            <span class="font-body-sm text-body-sm text-outline">Outlier filtering and forward-fill imputation on cold-start telemetry streams.</span>
                                        </div>
                                    </label>
                                    <!-- Item 3 -->
                                    <label class="flex items-start gap-space-sm p-space-sm rounded-lg bg-surface-container-low hover:bg-surface-container-high transition-colors cursor-pointer">
                                        <input type="checkbox" checked class="mt-1 w-4 h-4 rounded text-primary bg-surface-container-high border-outline focus:ring-0">
                                        <div class="flex flex-col flex-1">
                                            <div class="flex items-center justify-between">
                                                <span class="font-headline-sm text-headline-sm text-on-surface line-through text-outline">AC-03: Temporal Feature Extraction</span>
                                                <span class="px-2 py-0.5 rounded font-label-mono-sm text-label-mono-sm bg-tertiary/20 text-tertiary font-bold">VERIFIED</span>
                                            </div>
                                            <span class="font-body-sm text-body-sm text-outline">Generated 42 features including 7-day thermal decay, duty-cycle variance, and calibration jitter.</span>
                                        </div>
                                    </label>
                                    <!-- Item 4 -->
                                    <label class="flex items-start gap-space-sm p-space-sm rounded-lg bg-surface-container-low hover:bg-surface-container-high transition-colors cursor-pointer">
                                        <input type="checkbox" checked class="mt-1 w-4 h-4 rounded text-primary bg-surface-container-high border-outline focus:ring-0">
                                        <div class="flex flex-col flex-1">
                                            <div class="flex items-center justify-between">
                                                <span class="font-headline-sm text-headline-sm text-on-surface line-through text-outline">AC-04: Baseline Benchmark Comparison</span>
                                                <span class="px-2 py-0.5 rounded font-label-mono-sm text-label-mono-sm bg-tertiary/20 text-tertiary font-bold">VERIFIED</span>
                                            </div>
                                            <span class="font-body-sm text-body-sm text-outline">Trained Logistic Regression (F1: 0.64) vs Random Forest (F1: 0.72) vs XGBoost (F1: 0.781).</span>
                                        </div>
                                    </label>
                                    <!-- Item 5 - PENDING / ACTION NEEDED -->
                                    <label class="flex items-start gap-space-sm p-space-sm rounded-lg bg-error-container/15 border border-error/30 transition-colors cursor-pointer">
                                        <input type="checkbox" class="mt-1 w-4 h-4 rounded text-primary bg-surface-container-high border-outline focus:ring-0">
                                        <div class="flex flex-col flex-1">
                                            <div class="flex items-center justify-between">
                                                <span class="font-headline-sm text-headline-sm text-error font-bold">AC-05: F1 Performance Metric Gate (&ge; 0.800)</span>
                                                <span class="px-2 py-0.5 rounded font-label-mono-sm text-label-mono-sm bg-error-container text-on-error-container font-bold animate-pulse">GATE BREACH (0.781)</span>
                                            </div>
                                            <span class="font-body-sm text-body-sm text-on-surface-variant">Candidate model scores 0.781 F1. Gap of 0.019 must be closed via regularization or ensemble tuning.</span>
                                        </div>
                                    </label>
                                    <!-- Item 6 -->
                                    <label class="flex items-start gap-space-sm p-space-sm rounded-lg bg-surface-container-low hover:bg-surface-container-high transition-colors cursor-pointer">
                                        <input type="checkbox" checked class="mt-1 w-4 h-4 rounded text-primary bg-surface-container-high border-outline focus:ring-0">
                                        <div class="flex flex-col flex-1">
                                            <div class="flex items-center justify-between">
                                                <span class="font-headline-sm text-headline-sm text-on-surface line-through text-outline">AC-06: Sub-25ms Inference Latency Verification</span>
                                                <span class="px-2 py-0.5 rounded font-label-mono-sm text-label-mono-sm bg-tertiary/20 text-tertiary font-bold">18ms PASSED</span>
                                            </div>
                                            <span class="font-body-sm text-body-sm text-outline">ONNX runtime benchmark achieves 18.2ms p95 latency on edge gateway hardware.</span>
                                        </div>
                                    </label>
                                    <!-- Item 7 -->
                                    <label class="flex items-start gap-space-sm p-space-sm rounded-lg bg-surface-container-low hover:bg-surface-container-high transition-colors cursor-pointer">
                                        <input type="checkbox" class="mt-1 w-4 h-4 rounded text-primary bg-surface-container-high border-outline focus:ring-0">
                                        <div class="flex flex-col flex-1">
                                            <div class="flex items-center justify-between">
                                                <span class="font-headline-sm text-headline-sm text-on-surface">AC-07: ISO/VP-9812-AI Model Card Registration</span>
                                                <span class="px-2 py-0.5 rounded font-label-mono-sm text-label-mono-sm bg-surface-container-high text-outline">AWAITING PASS</span>
                                            </div>
                                            <span class="font-body-sm text-body-sm text-on-surface-variant">Signed model card export into SYS-AI-04 Model Registry upon passing F1 threshold.</span>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- 3. SPRINT SUBTASKS & TIME TRACKING -->
                            <div class="bg-surface-container rounded-xl p-space-lg shadow-md flex flex-col gap-space-md">
                                <div class="flex items-center justify-between border-b border-surface-container-high pb-space-sm">
                                    <div class="flex items-center gap-space-sm">
                                        <span class="material-symbols-outlined text-tertiary text-[22px]">assignment</span>
                                        <h2 class="font-headline-md text-headline-md text-on-surface font-semibold tracking-tight">
                                            Sprint Execution Breakdown
                                        </h2>
                                    </div>
                                    <button onclick="if(window.showToast) window.showToast('Adding new subtask to Sprint 24-B...', 'info', 'SPRINT DISPATCH')" class="px-2.5 py-1 rounded bg-surface-container-high hover:bg-surface-bright text-on-surface font-label-caps text-label-caps transition-colors flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[14px]">add</span>
                                        Add Subtask
                                    </button>
                                </div>
                                <div class="overflow-x-auto">
                                    <table class="w-full text-left font-body-sm text-body-sm">
                                        <thead class="bg-surface-container-low font-label-caps text-label-caps text-outline uppercase tracking-wider">
                                            <tr>
                                                <th class="py-2.5 px-3">Task Key</th>
                                                <th class="py-2.5 px-3">Description</th>
                                                <th class="py-2.5 px-3">Status</th>
                                                <th class="py-2.5 px-3">Assignee</th>
                                                <th class="py-2.5 px-3 text-right">Logged Time</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-surface-container-high/40">
                                            <tr class="hover:bg-surface-container-low transition-colors">
                                                <td class="py-2.5 px-3 font-label-mono-sm text-label-mono-sm text-primary font-bold">#AI-024.1</td>
                                                <td class="py-2.5 px-3 text-on-surface">Data extraction from S3 cold storage &amp; parquet conversion</td>
                                                <td class="py-2.5 px-3"><span class="px-2 py-0.5 rounded font-label-mono-sm text-label-mono-sm bg-tertiary/20 text-tertiary font-bold">DONE</span></td>
                                                <td class="py-2.5 px-3 font-label-mono-sm text-label-mono-sm text-on-surface-variant">K. Saparov</td>
                                                <td class="py-2.5 px-3 text-right font-mono text-outline">6h 15m</td>
                                            </tr>
                                            <tr class="hover:bg-surface-container-low transition-colors">
                                                <td class="py-2.5 px-3 font-label-mono-sm text-label-mono-sm text-primary font-bold">#AI-024.2</td>
                                                <td class="py-2.5 px-3 text-on-surface">Feature correlation matrix &amp; collinearity filtering</td>
                                                <td class="py-2.5 px-3"><span class="px-2 py-0.5 rounded font-label-mono-sm text-label-mono-sm bg-tertiary/20 text-tertiary font-bold">DONE</span></td>
                                                <td class="py-2.5 px-3 font-label-mono-sm text-label-mono-sm text-primary">Gulkaba T.</td>
                                                <td class="py-2.5 px-3 text-right font-mono text-outline">12h 40m</td>
                                            </tr>
                                            <tr class="hover:bg-surface-container-low transition-colors bg-primary-container/10">
                                                <td class="py-2.5 px-3 font-label-mono-sm text-label-mono-sm text-primary font-bold">#AI-024.3</td>
                                                <td class="py-2.5 px-3 text-on-surface font-medium">Hyperparameter optimization &amp; L2 tuning for XGBoost</td>
                                                <td class="py-2.5 px-3"><span class="px-2 py-0.5 rounded font-label-mono-sm text-label-mono-sm bg-primary text-on-primary font-bold animate-pulse">IN PROGRESS</span></td>
                                                <td class="py-2.5 px-3 font-label-mono-sm text-label-mono-sm text-primary">Gulkaba T.</td>
                                                <td class="py-2.5 px-3 text-right font-mono text-primary font-bold">14h 20m</td>
                                            </tr>
                                            <tr class="hover:bg-surface-container-low transition-colors">
                                                <td class="py-2.5 px-3 font-label-mono-sm text-label-mono-sm text-primary font-bold">#AI-024.4</td>
                                                <td class="py-2.5 px-3 text-on-surface">SOC monitoring hooks &amp; drift threshold setup</td>
                                                <td class="py-2.5 px-3"><span class="px-2 py-0.5 rounded font-label-mono-sm text-label-mono-sm bg-surface-container-high text-outline">BLOCKED</span></td>
                                                <td class="py-2.5 px-3 font-label-mono-sm text-label-mono-sm text-secondary">N. Aliyev</td>
                                                <td class="py-2.5 px-3 text-right font-mono text-outline">0h 00m</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- 4. ATTACHED DELIVERABLES & ARTIFACTS -->
                            <div class="bg-surface-container rounded-xl p-space-lg shadow-md flex flex-col gap-space-md">
                                <div class="flex items-center justify-between border-b border-surface-container-high pb-space-sm">
                                    <div class="flex items-center gap-space-sm">
                                        <span class="material-symbols-outlined text-primary text-[22px]">folder_zip</span>
                                        <h2 class="font-headline-md text-headline-md text-on-surface font-semibold tracking-tight">
                                            Candidate Artifacts Attached
                                        </h2>
                                    </div>
                                    <span class="font-label-mono-sm text-label-mono-sm text-outline">4 ARTIFACTS // RUN #04</span>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-space-sm">
                                    <div class="p-space-md rounded-lg bg-surface-container-low flex flex-col justify-between gap-space-sm border border-outline-variant/30">
                                        <div class="flex items-start justify-between">
                                            <div class="flex items-center gap-2">
                                                <span class="material-symbols-outlined text-primary text-[24px]">model_training</span>
                                                <div class="flex flex-col">
                                                    <span class="font-headline-sm text-headline-sm text-on-surface font-semibold">churn_xgb_v2.bin</span>
                                                    <span class="font-label-mono-sm text-label-mono-sm text-outline">48.2 MB · XGBoost v1.7.6</span>
                                                </div>
                                            </div>
                                            <span class="px-1.5 py-0.5 rounded bg-surface-container-high text-outline font-label-mono-sm text-label-mono-sm">SHA256: 7f8a9...</span>
                                        </div>
                                        <div class="flex items-center justify-between pt-space-xs border-t border-surface-container">
                                            <span class="font-label-mono-sm text-label-mono-sm text-primary">F1: 0.781</span>
                                            <button onclick="if(window.showToast) window.showToast('Inspecting model weights tensor shape: (42, 100)...', 'info', 'MODEL INSPECTION')" class="font-label-caps text-label-caps text-secondary hover:underline">Inspect Weights</button>
                                        </div>
                                    </div>
                                    <div class="p-space-md rounded-lg bg-surface-container-low flex flex-col justify-between gap-space-sm border border-outline-variant/30">
                                        <div class="flex items-start justify-between">
                                            <div class="flex items-center gap-2">
                                                <span class="material-symbols-outlined text-secondary text-[24px]">data_object</span>
                                                <div class="flex flex-col">
                                                    <span class="font-headline-sm text-headline-sm text-on-surface font-semibold">features_manifest.json</span>
                                                    <span class="font-label-mono-sm text-label-mono-sm text-outline">128 KB · 42 Feature Columns</span>
                                                </div>
                                            </div>
                                            <span class="px-1.5 py-0.5 rounded bg-tertiary/20 text-tertiary font-label-mono-sm text-label-mono-sm">VALID</span>
                                        </div>
                                        <div class="flex items-center justify-between pt-space-xs border-t border-surface-container">
                                            <span class="font-label-mono-sm text-label-mono-sm text-outline">SCHEMA v2.1</span>
                                            <button onclick="if(window.showToast) window.showToast('Manifest validated: 42 features with 0 null distributions.', 'success', 'SCHEMA CHECK')" class="font-label-caps text-label-caps text-secondary hover:underline">View Schema</button>
                                        </div>
                                    </div>
                                    <div class="p-space-md rounded-lg bg-surface-container-low flex flex-col justify-between gap-space-sm border border-outline-variant/30">
                                        <div class="flex items-start justify-between">
                                            <div class="flex items-center gap-2">
                                                <span class="material-symbols-outlined text-tertiary text-[24px]">analytics</span>
                                                <div class="flex flex-col">
                                                    <span class="font-headline-sm text-headline-sm text-on-surface font-semibold">eda_telemetry_report.html</span>
                                                    <span class="font-label-mono-sm text-label-mono-sm text-outline">3.4 MB · Profiling Summary</span>
                                                </div>
                                            </div>
                                            <span class="px-1.5 py-0.5 rounded bg-tertiary/20 text-tertiary font-label-mono-sm text-label-mono-sm">PASSED</span>
                                        </div>
                                        <div class="flex items-center justify-between pt-space-xs border-t border-surface-container">
                                            <span class="font-label-mono-sm text-label-mono-sm text-outline">14.2M Rows</span>
                                            <a href="DeliverablesAndSubmissionPanel.php" class="font-label-caps text-label-caps text-tertiary hover:underline">Open Report</a>
                                        </div>
                                    </div>
                                    <div class="p-space-md rounded-lg bg-surface-container-low flex flex-col justify-between gap-space-sm border border-outline-variant/30">
                                        <div class="flex items-start justify-between">
                                            <div class="flex items-center gap-2">
                                                <span class="material-symbols-outlined text-primary text-[24px]">description</span>
                                                <div class="flex flex-col">
                                                    <span class="font-headline-sm text-headline-sm text-on-surface font-semibold">ModelCard_AI024.md</span>
                                                    <span class="font-label-mono-sm text-label-mono-sm text-outline">ISO/VP-9812-AI Draft</span>
                                                </div>
                                            </div>
                                            <span class="px-1.5 py-0.5 rounded bg-error-container/30 text-error font-label-mono-sm text-label-mono-sm">NEEDS UPDATE</span>
                                        </div>
                                        <div class="flex items-center justify-between pt-space-xs border-t border-surface-container">
                                            <span class="font-label-mono-sm text-label-mono-sm text-outline">Version 0.9b</span>
                                            <a href="../Model Registry & Deployment/ModelCard.php" class="font-label-caps text-label-caps text-primary hover:underline">Edit Card</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 5. ACTIVITY FEED & COLLABORATIVE AUDIT -->
                            <div class="bg-surface-container rounded-xl p-space-lg shadow-md flex flex-col gap-space-md">
                                <div class="flex items-center justify-between border-b border-surface-container-high pb-space-sm">
                                    <div class="flex items-center gap-space-sm">
                                        <span class="material-symbols-outlined text-secondary text-[22px]">forum</span>
                                        <h2 class="font-headline-md text-headline-md text-on-surface font-semibold tracking-tight">
                                            Activity Feed &amp; Audit Trail
                                        </h2>
                                    </div>
                                    <span class="font-label-mono-sm text-label-mono-sm text-outline">SYNCED REALTIME</span>
                                </div>
                                <div class="flex flex-col gap-space-md">
                                    <!-- Comment 1: Automated Daemon -->
                                    <div class="flex gap-space-sm items-start">
                                        <div class="w-8 h-8 rounded-full bg-error-container text-on-error-container flex items-center justify-center font-bold text-label-caps shrink-0">
                                            SYS
                                        </div>
                                        <div class="flex flex-col flex-1 bg-surface-container-low p-space-sm rounded-lg border border-error/20">
                                            <div class="flex items-center justify-between mb-1">
                                                <span class="font-label-caps text-label-caps text-error font-bold">SYS-AI Auto-Validation Gateway</span>
                                                <span class="font-label-mono-sm text-label-mono-sm text-outline">4 hours ago</span>
                                            </div>
                                            <p class="font-body-sm text-body-sm text-on-surface-variant">
                                                Verification Run #04 executed. Evaluation metric result: <code class="text-primary bg-surface-container px-1 py-0.5 rounded font-mono">F1 = 0.781</code>. Gate requires <code class="text-on-surface font-mono">&ge; 0.800</code>. Candidate bundle rejected. Resubmission countdown timer started (18h window).
                                            </p>
                                        </div>
                                    </div>
                                    <!-- Comment 2: Instructor -->
                                    <div class="flex gap-space-sm items-start">
                                        <div class="w-8 h-8 rounded-full bg-secondary-container text-on-secondary-container flex items-center justify-center font-bold text-label-caps shrink-0">
                                            AK
                                        </div>
                                        <div class="flex flex-col flex-1 bg-surface-container-low p-space-sm rounded-lg border border-outline-variant/30">
                                            <div class="flex items-center justify-between mb-1">
                                                <span class="font-label-caps text-label-caps text-secondary font-bold">Dr. A. Kasymov (Lead AI Mentor)</span>
                                                <span class="font-label-mono-sm text-label-mono-sm text-outline">2 hours ago</span>
                                            </div>
                                            <p class="font-body-sm text-body-sm text-on-surface-variant">
                                                Eng. Gulkaba: I examined your feature importance log. Features <code class="text-on-surface font-mono">sensor_temp_drift_7d</code> and <code class="text-on-surface font-mono">vibration_rms_peak</code> exhibit high multicollinearity (r &gt; 0.88). Increase XGBoost L2 penalty (<code class="text-primary font-mono">reg_lambda=2.0</code>) and resubmit your bundle. You are within 0.02 of target.
                                            </p>
                                        </div>
                                    </div>
                                    <!-- Comment 3: Intern Engineer -->
                                    <div class="flex gap-space-sm items-start">
                                        <div class="w-8 h-8 rounded-full bg-primary text-on-primary flex items-center justify-center font-bold text-label-caps shrink-0">
                                            GT
                                        </div>
                                        <div class="flex flex-col flex-1 bg-surface-container-low p-space-sm rounded-lg border border-outline-variant/30">
                                            <div class="flex items-center justify-between mb-1">
                                                <span class="font-label-caps text-label-caps text-primary font-bold">Eng. Gulkaba T. (Assigned Engineer)</span>
                                                <span class="font-label-mono-sm text-label-mono-sm text-outline">45 minutes ago</span>
                                            </div>
                                            <p class="font-body-sm text-body-sm text-on-surface-variant">
                                                Acknowledged Dr. Kasymov. Setting up grid search across <code class="text-on-surface font-mono">reg_lambda=[1.5, 2.0, 2.5]</code> in ML Workbench right now. Will trigger Run #05 verification before 14:00 shift change.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Interactive Comment Form -->
                                <div class="flex flex-col gap-space-sm pt-space-xs border-t border-surface-container-high">
                                    <textarea id="ticketCommentInput" class="w-full bg-surface-container-lowest text-on-surface placeholder:text-outline font-body-sm text-body-sm p-space-sm rounded-lg focus:outline-none border border-outline-variant/40" rows="3" placeholder="Post engineering update, diagnostic note, or review request..."></textarea>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-space-xs font-label-mono-sm text-label-mono-sm text-outline">
                                            <span class="material-symbols-outlined text-[15px]">attach_file</span>
                                            <span>Attach Log / Metric Diff</span>
                                        </div>
                                        <button onclick="
                                            const val = document.getElementById('ticketCommentInput').value.trim();
                                            if (val) {
                                                if(window.showToast) window.showToast('Note posted to ticket audit log.', 'success', 'NOTE RECORDED');
                                                document.getElementById('ticketCommentInput').value = '';
                                            } else {
                                                if(window.showToast) window.showToast('Please enter an update message before posting.', 'warning', 'INPUT EMPTY');
                                            }
                                        " class="px-space-md py-1.5 rounded-lg bg-primary hover:bg-primary-fixed-dim text-on-primary font-label-caps text-label-caps font-bold transition-all shadow-md">
                                            Post Note
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- RIGHT COLUMN: METADATA & CONTROL INSTRUMENTATION (4 cols) -->
                        <div class="lg:col-span-4 flex flex-col gap-space-lg">
                            
                            <!-- 1. TICKET METADATA CARD -->
                            <div class="bg-surface-container rounded-xl p-space-lg shadow-md flex flex-col gap-space-md">
                                <div class="flex items-center justify-between border-b border-surface-container-high pb-space-sm">
                                    <span class="font-label-mono-sm text-label-mono-sm text-outline uppercase tracking-wider">Ticket Properties</span>
                                    <span class="font-label-mono-sm text-label-mono-sm text-tertiary">NODE: ALM-LAB-04</span>
                                </div>
                                <div class="flex flex-col gap-space-sm font-body-sm text-body-sm">
                                    <div class="flex items-center justify-between">
                                        <span class="text-outline">Assigned Engineer:</span>
                                        <div class="flex items-center gap-1.5 font-bold text-on-surface">
                                            <div class="w-5 h-5 rounded-full bg-primary text-on-primary flex items-center justify-center font-label-caps text-[9px]">GT</div>
                                            <span>Gulkaba T. [L2]</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-outline">Senior Evaluator:</span>
                                        <div class="flex items-center gap-1.5 text-on-surface">
                                            <div class="w-5 h-5 rounded-full bg-secondary-container text-on-secondary-container flex items-center justify-center font-label-caps text-[9px]">AK</div>
                                            <span>Dr. A. Kasymov</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-outline">Current Phase:</span>
                                        <span class="font-label-mono-sm text-label-mono-sm text-primary font-bold">Phase III: St. 08</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-outline">Department:</span>
                                        <span class="text-on-surface font-medium">Sales &amp; Tech Operations</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-outline">Target Registry Node:</span>
                                        <span class="font-mono text-secondary text-label-mono-sm">REG-CHURN-PROD</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-outline">Creation Timestamp:</span>
                                        <span class="font-mono text-outline text-label-mono-sm">2026-09-12 08:30:00</span>
                                    </div>
                                </div>
                            </div>

                            <!-- 2. PRODUCTION THRESHOLD RADAR -->
                            <div class="bg-surface-container rounded-xl p-space-lg shadow-md flex flex-col gap-space-md">
                                <div class="flex items-center justify-between border-b border-surface-container-high pb-space-sm">
                                    <span class="font-label-mono-sm text-label-mono-sm text-outline uppercase tracking-wider">Metric Quality Gates</span>
                                    <span class="font-label-mono-sm text-label-mono-sm text-primary">RUN #04</span>
                                </div>
                                <div class="flex flex-col gap-space-sm">
                                    <div class="flex flex-col gap-1">
                                        <div class="flex justify-between font-label-mono-sm text-label-mono-sm">
                                            <span class="text-outline">F1 Score (Target &ge; 0.80):</span>
                                            <span class="text-error font-bold font-mono">0.781 (BREACH)</span>
                                        </div>
                                        <div class="w-full bg-surface-container-lowest h-2 rounded-full overflow-hidden">
                                            <div class="bg-primary h-full rounded-full" style="width: 78.1%;"></div>
                                        </div>
                                    </div>
                                    <div class="flex flex-col gap-1">
                                        <div class="flex justify-between font-label-mono-sm text-label-mono-sm">
                                            <span class="text-outline">ROC-AUC (Target &ge; 0.82):</span>
                                            <span class="text-tertiary font-bold font-mono">0.842 (PASSED)</span>
                                        </div>
                                        <div class="w-full bg-surface-container-lowest h-2 rounded-full overflow-hidden">
                                            <div class="bg-tertiary h-full rounded-full" style="width: 84.2%;"></div>
                                        </div>
                                    </div>
                                    <div class="flex flex-col gap-1">
                                        <div class="flex justify-between font-label-mono-sm text-label-mono-sm">
                                            <span class="text-outline">Precision (Target &ge; 0.75):</span>
                                            <span class="text-tertiary font-bold font-mono">0.792 (PASSED)</span>
                                        </div>
                                        <div class="w-full bg-surface-container-lowest h-2 rounded-full overflow-hidden">
                                            <div class="bg-tertiary h-full rounded-full" style="width: 79.2%;"></div>
                                        </div>
                                    </div>
                                    <div class="flex flex-col gap-1">
                                        <div class="flex justify-between font-label-mono-sm text-label-mono-sm">
                                            <span class="text-outline">Latency p95 (Target &le; 25ms):</span>
                                            <span class="text-tertiary font-bold font-mono">18.2ms (PASSED)</span>
                                        </div>
                                        <div class="w-full bg-surface-container-lowest h-2 rounded-full overflow-hidden">
                                            <div class="bg-tertiary h-full rounded-full" style="width: 72.8%;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 3. WORKFLOW ACTION HUB -->
                            <div class="bg-surface-container rounded-xl p-space-lg shadow-md flex flex-col gap-space-md">
                                <div class="flex items-center justify-between border-b border-surface-container-high pb-space-sm">
                                    <span class="font-label-mono-sm text-label-mono-sm text-outline uppercase tracking-wider">Fast Action Triggers</span>
                                    <span class="material-symbols-outlined text-outline text-[18px]">bolt</span>
                                </div>
                                <div class="flex flex-col gap-space-xs">
                                    <button onclick="
                                        this.disabled = true;
                                        this.innerHTML = '<span class=\'material-symbols-outlined text-sm animate-spin\'>refresh</span> Triggering Gate Check...';
                                        setTimeout(() => {
                                            this.disabled = false;
                                            this.innerHTML = '<span class=\'material-symbols-outlined text-sm\'>done_all</span> Validation Triggered';
                                            if(window.showToast) window.showToast('Run #05 initiated in background. Training pipeline dispatched to GPU node #2.', 'info', 'JOB DISPATCHED');
                                        }, 1000);
                                    " class="w-full py-2 px-space-md rounded-lg bg-primary hover:bg-primary-fixed-dim text-on-primary font-label-caps text-label-caps font-bold transition-all shadow-md flex items-center justify-center gap-2">
                                        <span class="material-symbols-outlined text-[16px]">play_circle</span>
                                        Run Automated Gate Validation
                                    </button>
                                    <a href="DeliverablesAndSubmissionPanel.php" class="w-full py-2 px-space-md rounded-lg bg-surface-container-high hover:bg-surface-bright text-on-surface font-label-caps text-label-caps transition-colors flex items-center justify-center gap-2 shadow-sm">
                                        <span class="material-symbols-outlined text-[16px] text-secondary">cloud_upload</span>
                                        Upload Resubmission Bundle
                                    </a>
                                    <a href="EvaluationView.php" class="w-full py-2 px-space-md rounded-lg bg-surface-container-low hover:bg-surface-container-high text-on-surface font-label-caps text-label-caps transition-colors flex items-center justify-center gap-2 shadow-sm">
                                        <span class="material-symbols-outlined text-[16px] text-tertiary">rate_review</span>
                                        View Instructor Rubric Score
                                    </a>
                                    <button onclick="if(window.showToast) window.showToast('Mentor alert sent to Dr. Kasymov with current run diagnostics.', 'success', 'MENTOR ALERTED')" class="w-full py-2 px-space-md rounded-lg bg-surface-container-lowest hover:bg-surface-container text-outline hover:text-on-surface font-label-mono-sm text-label-mono-sm transition-colors flex items-center justify-center gap-2">
                                        <span class="material-symbols-outlined text-[15px]">priority_high</span>
                                        Escalate to Instructor
                                    </button>
                                </div>
                            </div>

                            <!-- 4. CROSS-SYSTEM LINKAGES (FUTURE DB / INTERCONNECT) -->
                            <div class="bg-surface-container rounded-xl p-space-lg shadow-md flex flex-col gap-space-md">
                                <div class="flex items-center justify-between border-b border-surface-container-high pb-space-sm">
                                    <span class="font-label-mono-sm text-label-mono-sm text-outline uppercase tracking-wider">Cross-System Interconnects</span>
                                    <span class="w-2 h-2 rounded-full bg-tertiary animate-pulse"></span>
                                </div>
                                <div class="flex flex-col gap-space-xs font-body-sm text-body-sm">
                                    <a href="../Data Center/DatasetCatalog.php" class="p-space-sm rounded-lg bg-surface-container-low hover:bg-surface-container-high transition-colors flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <span class="material-symbols-outlined text-secondary text-[18px]">storage</span>
                                            <div class="flex flex-col">
                                                <span class="font-headline-sm text-headline-sm text-on-surface">SYS-02 Data Center</span>
                                                <span class="font-label-mono-sm text-label-mono-sm text-outline">DATA-TEL-9014 · 14.2M rows</span>
                                            </div>
                                        </div>
                                        <span class="material-symbols-outlined text-outline text-[16px]">arrow_forward</span>
                                    </a>
                                    <a href="../AI/ML Workbench/WorkbenchHome.php" class="p-space-sm rounded-lg bg-surface-container-low hover:bg-surface-container-high transition-colors flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <span class="material-symbols-outlined text-primary text-[18px]">terminal</span>
                                            <div class="flex flex-col">
                                                <span class="font-headline-sm text-headline-sm text-on-surface">SYS-03 ML Workbench</span>
                                                <span class="font-label-mono-sm text-label-mono-sm text-outline">EXP-CHURN-092 · Jupyter</span>
                                            </div>
                                        </div>
                                        <span class="material-symbols-outlined text-outline text-[16px]">arrow_forward</span>
                                    </a>
                                    <a href="../Model Registry & Deployment/ModelRegistry.php" class="p-space-sm rounded-lg bg-surface-container-low hover:bg-surface-container-high transition-colors flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <span class="material-symbols-outlined text-tertiary text-[18px]">inventory_2</span>
                                            <div class="flex flex-col">
                                                <span class="font-headline-sm text-headline-sm text-on-surface">SYS-04 Registry</span>
                                                <span class="font-label-mono-sm text-label-mono-sm text-outline">Target: churn-xgb:v2.0</span>
                                            </div>
                                        </div>
                                        <span class="material-symbols-outlined text-outline text-[16px]">arrow_forward</span>
                                    </a>
                                    <a href="../AI Operations Center (AI SOC)/FleetTelemetry.php" class="p-space-sm rounded-lg bg-surface-container-low hover:bg-surface-container-high transition-colors flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <span class="material-symbols-outlined text-error text-[18px]">security</span>
                                            <div class="flex flex-col">
                                                <span class="font-headline-sm text-headline-sm text-on-surface">SYS-05 AI SOC</span>
                                                <span class="font-label-mono-sm text-label-mono-sm text-outline">Fleet Drift Telemetry</span>
                                            </div>
                                        </div>
                                        <span class="material-symbols-outlined text-outline text-[16px]">arrow_forward</span>
                                    </a>
                                </div>
                            </div>

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