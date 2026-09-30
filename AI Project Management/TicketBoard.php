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
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@100..900&amp;family=Inter:wght@100..900&amp;family=Space+Mono:wght@100..900&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/global.css" />
    <link rel="stylesheet" href="css/style.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="js/tailwind.config.js"></script>
</head>

<body class="bg-surface font-body-md text-on-surface">
    <aside class="group/rail fixed left-0 top-0 h-full w-16 hover:w-64 bg-surface-container-low z-50 flex flex-col justify-between shadow-2xl transition-all duration-300 ease-in-out overflow-hidden whitespace-nowrap">
        <div class="flex flex-col">
            <div class="h-16 px-space-md flex items-center gap-space-sm bg-surface-container-lowest shrink-0"><a href="../index.php" title="Return to Core 5-System Portal" class="flex items-center gap-space-sm shrink-0"><img alt="VOSTOKPRIBOR Industrial AI Logo" class="h-8 w-8 object-contain shrink-0" src="https://lh3.googleusercontent.com/aida/AEtjO1W0pnhS8IEaoTn70IOGIuwcWNpNgh10xzjUL5_oCtxmTZj8xgF1DI7e0F5iyT9zuQXrKTSp8fVISDLajw0cOVTlsEJPJrw3qV9YjP2k2JzO1v07n2BIvWyOQ5iikdzARo6tUdO70wQtL3rfgjs-8WdFHO9vFslvSDw0chLlp2BAZ27-Xf1xpu_2HcIYL1r5bO9UnamptMdIQ9n5jEdsmz-3oTg0r8nFbGeBPfgRIO6XOLSGrkRx6lGMUYj8"></a>
                <div class="flex flex-col opacity-0 group-hover/rail:opacity-100 transition-opacity duration-200"><span class="font-label-caps text-label-caps text-on-surface tracking-wider uppercase">VOSTOKPRIBOR</span><span class="font-label-mono-sm text-label-mono-sm text-primary">SYS-AI CORE ENGINE</span></div>
            </div>
            <div class="px-space-md py-space-sm">
                <div class="font-label-mono-sm text-label-mono-sm text-outline uppercase tracking-wider mb-space-xs opacity-0 group-hover/rail:opacity-100 transition-opacity duration-200">Telemetry Rail</div>
                <nav class="flex flex-col gap-space-xs" data-active-classes="bg-surface-container-high text-primary font-headline-sm"><a class="group flex items-center justify-between px-space-md py-space-sm rounded text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="projects" href="Dashboard.php">
                        <div class="flex items-center gap-space-sm shrink-0"><span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse shrink-0"></span><span class="font-label-caps text-label-caps opacity-0 group-hover/rail:opacity-100 transition-opacity duration-200">SYS-AI-01 Projects</span></div><span class="font-label-mono-sm text-label-mono-sm text-primary opacity-0 group-hover/rail:opacity-100 transition-opacity duration-200">ACT</span>
                    </a><a class="group flex items-center justify-between px-space-md py-space-sm rounded text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="data-center" href="../Data Center/DatasetCatalog.php">
                        <div class="flex items-center gap-space-sm shrink-0"><span class="w-1.5 h-1.5 rounded-full bg-outline-variant shrink-0"></span><span class="font-label-caps text-label-caps opacity-0 group-hover/rail:opacity-100 transition-opacity duration-200">SYS-AI-02 Data Center</span></div><span class="font-label-mono-sm text-label-mono-sm text-on-surface-variant opacity-0 group-hover/rail:opacity-100 transition-opacity duration-200">SYNC</span>
                    </a><a class="group flex items-center justify-between px-space-md py-space-sm rounded text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="workbench" href="../AI/ML Workbench/WorkbenchHome.php">
                        <div class="flex items-center gap-space-sm shrink-0"><span class="w-1.5 h-1.5 rounded-full bg-outline-variant shrink-0"></span><span class="font-label-caps text-label-caps opacity-0 group-hover/rail:opacity-100 transition-opacity duration-200">SYS-AI-03 Workbench</span></div><span class="font-label-mono-sm text-label-mono-sm text-on-surface-variant opacity-0 group-hover/rail:opacity-100 transition-opacity duration-200">RDY</span>
                    </a><a class="group flex items-center justify-between px-space-md py-space-sm rounded text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="registry-deployment" href="../Model Registry & Deployment/ModelRegistry.php">
                        <div class="flex items-center gap-space-sm shrink-0"><span class="w-1.5 h-1.5 rounded-full bg-outline-variant shrink-0"></span><span class="font-label-caps text-label-caps opacity-0 group-hover/rail:opacity-100 transition-opacity duration-200">SYS-AI-04 Registry &amp; Deploy</span></div><span class="font-label-mono-sm text-label-mono-sm text-on-surface-variant opacity-0 group-hover/rail:opacity-100 transition-opacity duration-200">v2.4</span>
                    </a><a class="group flex items-center justify-between px-space-md py-space-sm rounded text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="ai-soc" href="../AI Operations Center (AI SOC)/FleetTelemetry.php">
                        <div class="flex items-center gap-space-sm shrink-0"><span class="w-1.5 h-1.5 rounded-full bg-tertiary shrink-0"></span><span class="font-label-caps text-label-caps opacity-0 group-hover/rail:opacity-100 transition-opacity duration-200">SYS-AI-05 AI SOC</span></div><span class="font-label-mono-sm text-label-mono-sm text-tertiary opacity-0 group-hover/rail:opacity-100 transition-opacity duration-200">SEC</span>
                    </a></nav>
            </div>
        </div>
        <div class="p-space-md bg-surface-container-lowest flex flex-col gap-space-xs shrink-0">
            <div class="flex items-center gap-space-xs"><span class="inline-block w-2 h-2 rounded-full bg-tertiary shrink-0"></span><span class="font-label-mono-sm text-label-mono-sm text-tertiary opacity-0 group-hover/rail:opacity-100 transition-opacity duration-200">SYS-AI ONLINE</span></div>
            <div class="font-label-mono-sm text-label-mono-sm text-on-surface-variant opacity-0 group-hover/rail:opacity-100 transition-opacity duration-200">LATENCY 14ms · ALMATY DC-01</div>
            <div class="font-label-mono-sm text-label-mono-sm text-outline opacity-0 group-hover/rail:opacity-100 transition-opacity duration-200">UPTIME 99.98% · NODE_ID: 884-A</div>
        </div>
    </aside>
    <div class="pl-16">
        <header class="fixed top-0 right-0 z-40 bg-surface/90 backdrop-blur-xl shadow-[0_1px_8px_rgba(0,0,0,0.04)] left-16 transition-all">
            <div class="h-16 px-space-lg flex items-center justify-between gap-space-md">
                <div class="flex items-center gap-space-md"><span class="font-headline-sm text-headline-sm text-on-surface tracking-tight whitespace-nowrap">VOSTOKPRIBOR · SYS-AI INDUSTRIAL PORTAL</span>
                    <div class="relative flex items-center bg-surface-container px-space-sm py-space-xs rounded w-64"><span class="material-symbols-outlined text-outline text-[18px] mr-space-xs">search</span><input class="bg-transparent w-full text-on-surface placeholder:text-outline font-body-sm text-body-sm focus:outline-none" placeholder="Search telemetry, jobs..." type="text"><span class="font-label-mono-sm text-label-mono-sm bg-surface-container-high text-on-surface-variant px-1 rounded">⌘K</span></div>
                </div>
                <div class="flex items-center gap-space-md">
                    <div class="flex items-center bg-surface-container rounded p-0.5"><button class="px-space-sm py-space-xs font-label-caps text-label-caps rounded bg-primary-container text-on-primary-container">Student</button><button class="px-space-sm py-space-xs font-label-caps text-label-caps rounded text-on-surface-variant hover:text-on-surface">Instructor</button></div>
                    <div class="flex items-center bg-surface-container rounded px-space-xs py-space-xs font-label-mono-sm text-label-mono-sm"><span class="px-1.5 py-0.5 rounded bg-surface-bright text-on-surface">EN</span><span class="px-1.5 py-0.5 text-on-surface-variant">AR</span></div>
                    <div class="relative flex items-center justify-center p-space-xs rounded bg-surface-container text-on-surface-variant hover:text-on-surface"><span class="material-symbols-outlined text-[20px]">notifications</span><span class="absolute -top-1 -right-1 w-4 h-4 rounded-full bg-error text-on-error font-label-mono-sm text-label-mono-sm flex items-center justify-center">3</span></div>
                    <div class="flex items-center gap-space-sm pl-space-sm bg-surface-container rounded-lg p-space-xs">
                        <div class="flex flex-col text-right"><span class="font-label-caps text-label-caps text-on-surface">Gulkaba T.</span><span class="font-label-mono-sm text-label-mono-sm text-primary">Intern AI Engineer · L2</span></div>
                        <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center"><span class="material-symbols-outlined text-on-primary text-[18px]">person</span></div>
                    </div>
                </div>
            </div>
            <div class="h-10 px-space-lg flex items-center justify-between bg-surface-container-low">
                <nav class="flex items-center gap-space-xs" data-active-classes="bg-primary text-on-primary font-bold rounded-full"><a class="px-space-sm py-0.5 rounded-full font-label-caps text-label-caps text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="dashboard" href="Dashboard.php">Dashboard</a><a aria-current="page" class="px-space-sm py-0.5 transition-colors bg-primary text-on-primary font-bold rounded-full" data-path="ticket-board" href="TicketBoard.php">Ticket Board</a><a class="px-space-sm py-0.5 rounded-full font-label-caps text-label-caps text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="ticket-detail-ai-024" href="TicketDetail.php">Ticket Detail #AI-024</a><a class="px-space-sm py-0.5 rounded-full font-label-caps text-label-caps text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="submissions" href="DeliverablesAndSubmissionPanel.php">Submissions</a><a class="px-space-sm py-0.5 rounded-full font-label-caps text-label-caps text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="evaluation" href="EvaluationView.php">Evaluation</a><a class="px-space-sm py-0.5 rounded-full font-label-caps text-label-caps text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="instructor-portal" href="InstructorDashboard.php">Instructor Portal</a></nav>
                <div class="flex items-center gap-space-xs font-label-mono-sm text-label-mono-sm text-outline"><span class="material-symbols-outlined text-[14px] text-tertiary">sync</span><span class="">BUFFER 100% NOMINAL</span></div>
            </div>
            <div class="h-10 px-space-lg bg-surface-container-lowest flex items-center overflow-x-auto gap-space-xs">
                <div class="flex items-center gap-1 shrink-0"><span class="w-4 h-4 rounded-full bg-tertiary text-on-tertiary font-label-mono-sm text-label-mono-sm flex items-center justify-center">✓</span><span class="font-label-mono-sm text-label-mono-sm text-on-surface">1 Request</span></div><span class="text-outline text-label-mono-sm">—</span>
                <div class="flex items-center gap-1 shrink-0"><span class="w-4 h-4 rounded-full bg-tertiary text-on-tertiary font-label-mono-sm text-label-mono-sm flex items-center justify-center">✓</span><span class="font-label-mono-sm text-label-mono-sm text-on-surface">2 Problem</span></div><span class="text-outline text-label-mono-sm">—</span>
                <div class="flex items-center gap-1 shrink-0"><span class="w-4 h-4 rounded-full bg-tertiary text-on-tertiary font-label-mono-sm text-label-mono-sm flex items-center justify-center">✓</span><span class="font-label-mono-sm text-label-mono-sm text-on-surface">3 Collection</span></div><span class="text-outline text-label-mono-sm">—</span>
                <div class="flex items-center gap-1 shrink-0"><span class="w-4 h-4 rounded-full bg-tertiary text-on-tertiary font-label-mono-sm text-label-mono-sm flex items-center justify-center">✓</span><span class="font-label-mono-sm text-label-mono-sm text-on-surface">4 EDA</span></div><span class="text-outline text-label-mono-sm">—</span>
                <div class="flex items-center gap-1 shrink-0"><span class="w-4 h-4 rounded-full bg-tertiary text-on-tertiary font-label-mono-sm text-label-mono-sm flex items-center justify-center">✓</span><span class="font-label-mono-sm text-label-mono-sm text-on-surface">5 Clean</span></div><span class="text-outline text-label-mono-sm">—</span>
                <div class="flex items-center gap-1 shrink-0"><span class="w-4 h-4 rounded-full bg-tertiary text-on-tertiary font-label-mono-sm text-label-mono-sm flex items-center justify-center">✓</span><span class="font-label-mono-sm text-label-mono-sm text-on-surface">6 Features</span></div><span class="text-outline text-label-mono-sm">—</span>
                <div class="flex items-center gap-1 shrink-0 bg-primary-container px-space-xs py-0.5 rounded"><span class="w-4 h-4 rounded-full bg-on-primary-container text-primary-container font-label-mono-sm text-label-mono-sm flex items-center justify-center animate-pulse">7</span><span class="font-label-mono-sm text-label-mono-sm text-on-primary-container font-bold">7 Build</span></div><span class="text-outline text-label-mono-sm">—</span>
                <div class="flex items-center gap-1 shrink-0 opacity-60"><span class="w-4 h-4 rounded-full bg-surface-container-high text-on-surface font-label-mono-sm text-label-mono-sm flex items-center justify-center">8</span><span class="font-label-mono-sm text-label-mono-sm text-on-surface-variant">8 Eval</span></div><span class="text-outline text-label-mono-sm">—</span>
                <div class="flex items-center gap-1 shrink-0 opacity-60"><span class="w-4 h-4 rounded-full bg-surface-container-high text-on-surface font-label-mono-sm text-label-mono-sm flex items-center justify-center">9</span><span class="font-label-mono-sm text-label-mono-sm text-on-surface-variant">9 Improve</span></div><span class="text-outline text-label-mono-sm">—</span>
                <div class="flex items-center gap-1 shrink-0 opacity-60"><span class="w-4 h-4 rounded-full bg-surface-container-high text-on-surface font-label-mono-sm text-label-mono-sm flex items-center justify-center">10</span><span class="font-label-mono-sm text-label-mono-sm text-on-surface-variant">10 Deploy</span></div><span class="text-outline text-label-mono-sm">—</span>
                <div class="flex items-center gap-1 shrink-0 opacity-60"><span class="w-4 h-4 rounded-full bg-surface-container-high text-on-surface font-label-mono-sm text-label-mono-sm flex items-center justify-center">11</span><span class="font-label-mono-sm text-label-mono-sm text-on-surface-variant">11 Integrate</span></div><span class="text-outline text-label-mono-sm">—</span>
                <div class="flex items-center gap-1 shrink-0 opacity-60"><span class="w-4 h-4 rounded-full bg-surface-container-high text-on-surface font-label-mono-sm text-label-mono-sm flex items-center justify-center">12</span><span class="font-label-mono-sm text-label-mono-sm text-on-surface-variant">12 Monitor</span></div><span class="text-outline text-label-mono-sm">—</span>
                <div class="flex items-center gap-1 shrink-0 opacity-60"><span class="w-4 h-4 rounded-full bg-surface-container-high text-on-surface font-label-mono-sm text-label-mono-sm flex items-center justify-center">13</span><span class="font-label-mono-sm text-label-mono-sm text-on-surface-variant">13 Drift</span></div><span class="text-outline text-label-mono-sm">—</span>
                <div class="flex items-center gap-1 shrink-0 opacity-60"><span class="w-4 h-4 rounded-full bg-surface-container-high text-on-surface font-label-mono-sm text-label-mono-sm flex items-center justify-center">14</span><span class="font-label-mono-sm text-label-mono-sm text-on-surface-variant">14 Report</span></div>
            </div>
        </header>
        <main class="relative pt-36 bg-surface min-h-screen">
            <div class="flex flex-col w-full">
                <div class="p-space-lg space-y-space-md">
                    <!-- Top Instrumentation & Sub-Header Utility Strip -->
                    <div class="flex flex-wrap items-center justify-between gap-space-sm bg-surface-container-low p-space-sm rounded-lg shadow-sm">
                        <div class="flex items-center gap-space-md">
                            <div class="flex items-center gap-space-xs font-label-mono-md text-label-mono-md text-outline">
                                <span class="w-2 h-2 rounded-full bg-primary animate-ping"></span>
                                <span class="text-on-surface uppercase tracking-wider font-semibold">TICKET-MATRIX // DISPATCH RAIL</span>
                            </div>
                            <div class="hidden sm:flex items-center gap-space-xs text-outline font-label-mono-sm text-label-mono-sm">
                                <span class="">SYNC_CYCLE:</span>
                                <span class="text-tertiary">30s ACTIVE</span>
                                <span class="opacity-40">|</span>
                                <span class="">CLUSTER:</span>
                                <span class="text-secondary">ALMATY-PROD-09</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-space-xs">
                            <div class="flex items-center bg-surface-container rounded p-0.5 shadow-inner">
                                <button class="flex items-center gap-1 px-space-sm py-1 rounded font-label-caps text-label-caps bg-primary text-on-primary shadow-sm transition-all" id="viewKanbanBtn">
                                    <span class="material-symbols-outlined text-[15px]">view_kanban</span>
                                    Kanban View
                                </button>
                                <button class="flex items-center gap-1 px-space-sm py-1 rounded font-label-caps text-label-caps text-on-surface-variant hover:text-on-surface transition-all" id="viewListBtn">
                                    <span class="material-symbols-outlined text-[15px]">table_rows</span>
                                    List View
                                </button>
                            </div>
                            <div class="hidden md:flex items-center gap-1 ml-space-sm">
                                <button class="flex items-center gap-1 px-space-sm py-1 rounded bg-surface-container-high hover:bg-surface-bright text-on-surface font-label-mono-sm text-label-mono-sm transition-colors shadow-sm">
                                    <span class="material-symbols-outlined text-[15px] text-secondary">download</span>
                                    CSV Export
                                </button>
                                <button class="flex items-center gap-1 px-space-sm py-1 rounded bg-primary-container text-on-primary-container hover:bg-primary font-label-caps text-label-caps font-bold transition-all shadow-sm">
                                    <span class="material-symbols-outlined text-[16px]">add_circle</span>
                                    + New Incident Ticket
                                </button>
                                <button class="p-1.5 rounded bg-surface-container-high hover:bg-surface-bright text-outline hover:text-on-surface transition-colors shadow-sm flex items-center justify-center" title="Force Refresh">
                                    <span class="material-symbols-outlined text-[16px] text-tertiary">sync</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Search & Multi-tier Filter Panel -->
                    <div class="bg-surface-container p-space-md rounded-xl shadow-md space-y-space-sm">
                        <div class="flex flex-col lg:flex-row gap-space-sm items-stretch lg:items-center justify-between">
                            <!-- Search Field -->
                            <div class="relative flex-1 min-w-[280px]">
                                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[18px]">search</span>
                                <input class="w-full bg-surface-container-lowest text-on-surface placeholder:text-outline font-body-sm text-body-sm pl-9 pr-8 py-2 rounded-lg focus:outline-none shadow-inner" id="ticketSearchInput" placeholder="Search tickets by ID, scenario, customer (e.g. CUS-1001, Churn)..." type="text">
                                <span class="absolute right-2.5 top-1/2 -translate-y-1/2 text-label-mono-sm font-label-mono-sm text-outline-variant bg-surface-container px-1 py-0.5 rounded">ESC</span>
                            </div>
                            <!-- Filter Dropdowns & Micro Selectors -->
                            <div class="flex flex-wrap items-center gap-space-xs">
                                <!-- Department Filter -->
                                <div class="flex items-center bg-surface-container-lowest rounded-lg px-2.5 py-1.5 shadow-sm">
                                    <span class="font-label-mono-sm text-label-mono-sm text-outline mr-2">DEPT:</span>
                                    <select class="bg-transparent text-on-surface font-label-caps text-label-caps focus:outline-none cursor-pointer">
                                        <option value="all">All Departments (Sales, Optical, Helpdesk, Foundry)</option>
                                        <option value="sales">Sales &amp; Marketing</option>
                                        <option value="optics">Optical QC</option>
                                        <option value="foundry">Foundry &amp; Machine</option>
                                        <option value="helpdesk">Technical Helpdesk</option>
                                    </select>
                                </div>
                                <!-- Priority Filter -->
                                <div class="flex items-center bg-surface-container-lowest rounded-lg px-2 py-1 shadow-sm">
                                    <span class="font-label-mono-sm text-label-mono-sm text-outline mr-1.5">PRIORITY:</span>
                                    <div class="flex items-center gap-1 font-label-caps text-label-caps">
                                        <button class="px-2 py-0.5 rounded bg-surface-bright text-on-surface">ALL</button>
                                        <button class="px-1.5 py-0.5 rounded text-error hover:bg-error-container/30 transition-colors">CRIT</button>
                                        <button class="px-1.5 py-0.5 rounded text-primary hover:bg-primary-container/30 transition-colors">HIGH</button>
                                        <button class="px-1.5 py-0.5 rounded text-secondary hover:bg-secondary-container/30 transition-colors">MED</button>
                                        <button class="px-1.5 py-0.5 rounded text-outline hover:bg-surface-container-high transition-colors">LOW</button>
                                    </div>
                                </div>
                                <!-- Scenario Filter -->
                                <div class="flex items-center bg-surface-container-lowest rounded-lg px-2.5 py-1.5 shadow-sm">
                                    <span class="font-label-mono-sm text-label-mono-sm text-outline mr-2">SCENARIO:</span>
                                    <select class="bg-transparent text-on-surface font-label-caps text-label-caps focus:outline-none cursor-pointer">
                                        <option value="all">All Scenarios</option>
                                        <option value="sc-01">Scenario 01 Churn MVP</option>
                                        <option value="sc-02">Scenario 02 Fraud Sentinel</option>
                                        <option value="sc-06">Scenario 06 Auto Support Agent</option>
                                        <option value="sc-09">Scenario 09 Vibro Acoustic</option>
                                    </select>
                                </div>
                                <!-- Level Pill Toggle -->
                                <div class="flex items-center bg-surface-container-lowest rounded-lg px-1 py-1 shadow-sm">
                                    <span class="px-1.5 font-label-mono-sm text-label-mono-sm text-outline">LVL:</span>
                                    <button class="px-2 py-0.5 rounded text-label-mono-sm font-label-mono-sm bg-surface-container-high text-on-surface">L1</button>
                                    <button class="px-2 py-0.5 rounded text-label-mono-sm font-label-mono-sm text-primary font-bold bg-primary-container/20">L2</button>
                                    <button class="px-2 py-0.5 rounded text-label-mono-sm font-label-mono-sm text-outline hover:text-on-surface">L3</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Active Filter Chips Status Bar -->
                    <div class="flex items-center justify-between px-space-xs font-label-mono-sm text-label-mono-sm text-outline">
                        <div class="flex items-center gap-space-sm flex-wrap">
                            <span class="">ACTIVE CONSTRAINTS:</span>
                            <span class="bg-surface-container-high text-on-surface px-2 py-0.5 rounded flex items-center gap-1">
                                Lifecycle: 14 Stages Mapped
                                <span class="material-symbols-outlined text-[12px] cursor-pointer">close</span>
                            </span>
                            <span class="bg-primary-container/20 text-primary px-2 py-0.5 rounded flex items-center gap-1">
                                Stage 8 Focus: Model Evaluate Active
                                <span class="material-symbols-outlined text-[12px] cursor-pointer">close</span>
                            </span>
                            <span class="text-tertiary flex items-center gap-1">
                                <span class="material-symbols-outlined text-[13px]">check_circle</span>
                                12 of 12 Nodes Responding
                            </span>
                        </div>
                        <div class="hidden sm:flex items-center gap-space-md">
                            <span class="">DRAG TO REASSIGN PHASE</span>
                            <span class="font-bold text-on-surface">TOTAL TICKETS: 12</span>
                        </div>
                    </div>
                    <!-- KANBAN BOARD CONTAINER -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-space-md items-start" id="kanbanBoardView">
                        <!-- COLUMN 1: PHASE I -->
                        <div class="flex flex-col bg-surface-container-low rounded-xl p-space-sm shadow-md min-h-[640px]">
                            <!-- Col Header -->
                            <div class="p-space-sm bg-surface-container rounded-lg mb-space-sm flex items-center justify-between shadow-sm">
                                <div class="flex flex-col">
                                    <span class="font-label-caps text-label-caps text-on-surface uppercase tracking-wider font-bold">PHASE I: Problem &amp; Data</span>
                                    <span class="font-label-mono-sm text-label-mono-sm text-outline">STAGES 01–03 · INGESTION</span>
                                </div>
                                <span class="w-6 h-6 rounded-full bg-surface-bright text-on-surface font-label-mono-sm text-label-mono-sm flex items-center justify-center font-bold">
                                    3
                                </span>
                            </div>
                            <!-- Cards Rack -->
                            <div class="flex flex-col gap-space-sm">
                                <!-- Card #AI-091 -->
                                <div class="group bg-surface-container hover:bg-surface-container-high transition-all p-space-sm rounded-lg shadow-sm cursor-grab active:cursor-grabbing">
                                    <div class="flex items-center justify-between mb-space-xs">
                                        <span class="font-label-mono-md text-label-mono-md text-primary font-bold">#AI-091</span>
                                        <span class="px-1.5 py-0.5 rounded text-label-mono-sm font-label-mono-sm bg-secondary-container/40 text-secondary">
                                            MED PRIORITY
                                        </span>
                                    </div>
                                    <p class="font-headline-sm text-headline-sm text-on-surface line-clamp-2 mb-space-sm group-hover:text-primary transition-colors">
                                        Optical Sensor Calibration Drift Request
                                    </p>
                                    <div class="flex items-center gap-1 mb-space-sm">
                                        <span class="px-1.5 py-0.5 rounded bg-surface-container-lowest text-outline font-label-caps text-label-caps">Foundry &amp; Optics</span>
                                        <span class="px-1.5 py-0.5 rounded bg-surface-container-lowest text-outline font-label-mono-sm text-label-mono-sm">Stage 1 Request</span>
                                    </div>
                                    <div class="flex items-center justify-between pt-space-xs border-t border-transparent text-outline font-label-mono-sm text-label-mono-sm">
                                        <div class="flex items-center gap-1.5">
                                            <div class="w-5 h-5 rounded-full bg-secondary text-on-secondary flex items-center justify-center font-label-caps text-[9px] font-bold">KS</div>
                                            <span class="">K. Saparov</span>
                                        </div>
                                        <span class="flex items-center gap-0.5 text-on-surface-variant">
                                            <span class="material-symbols-outlined text-[13px]">timer</span>
                                            Due: 5d
                                        </span>
                                    </div>
                                </div>
                                <!-- Card #AI-094 -->
                                <div class="group bg-surface-container hover:bg-surface-container-high transition-all p-space-sm rounded-lg shadow-sm cursor-grab active:cursor-grabbing">
                                    <div class="flex items-center justify-between mb-space-xs">
                                        <span class="font-label-mono-md text-label-mono-md text-secondary font-bold">#AI-094</span>
                                        <span class="px-1.5 py-0.5 rounded text-label-mono-sm font-label-mono-sm bg-surface-container-lowest text-outline">
                                            LOW
                                        </span>
                                    </div>
                                    <p class="font-headline-sm text-headline-sm text-on-surface line-clamp-2 mb-space-sm group-hover:text-primary transition-colors">
                                        Aral Geomatics Transaction Sync Error
                                    </p>
                                    <div class="flex items-center gap-1 mb-space-sm">
                                        <span class="px-1.5 py-0.5 rounded bg-surface-container-lowest text-primary font-label-mono-sm text-label-mono-sm">CUS-1001</span>
                                        <span class="px-1.5 py-0.5 rounded bg-surface-container-lowest text-outline font-label-mono-sm text-label-mono-sm">Stage 3 Collection</span>
                                    </div>
                                    <div class="flex items-center justify-between pt-space-xs text-outline font-label-mono-sm text-label-mono-sm">
                                        <div class="flex items-center gap-1.5">
                                            <div class="w-5 h-5 rounded-full bg-surface-bright text-on-surface flex items-center justify-center font-label-caps text-[9px]">SYS</div>
                                            <span class="">Automated Ingest</span>
                                        </div>
                                        <span class="text-on-surface-variant">Due: 7d</span>
                                    </div>
                                </div>
                                <!-- Card #AI-097 Placeholder Data Specimen -->
                                <div class="group bg-surface-container hover:bg-surface-container-high transition-all p-space-sm rounded-lg shadow-sm cursor-grab active:cursor-grabbing">
                                    <div class="flex items-center justify-between mb-space-xs">
                                        <span class="font-label-mono-md text-label-mono-md text-outline font-bold">#AI-097</span>
                                        <span class="px-1.5 py-0.5 rounded text-label-mono-sm font-label-mono-sm bg-surface-container-lowest text-outline">LOW</span>
                                    </div>
                                    <p class="font-headline-sm text-headline-sm text-on-surface line-clamp-2 mb-space-sm">
                                        Spectrometry Telemetry Schema V2 Ingestion
                                    </p>
                                    <div class="flex items-center justify-between text-outline font-label-mono-sm text-label-mono-sm">
                                        <span class="">Stage 2 Problem Spec</span>
                                        <span class="">Due: 11d</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- COLUMN 2: PHASE II -->
                        <div class="flex flex-col bg-surface-container-low rounded-xl p-space-sm shadow-md min-h-[640px]">
                            <!-- Col Header -->
                            <div class="p-space-sm bg-surface-container rounded-lg mb-space-sm flex items-center justify-between shadow-sm">
                                <div class="flex flex-col">
                                    <span class="font-label-caps text-label-caps text-on-surface uppercase tracking-wider font-bold">PHASE II: EDA &amp; Prep</span>
                                    <span class="font-label-mono-sm text-label-mono-sm text-outline">STAGES 04–06 · WRANGLING</span>
                                </div>
                                <span class="w-6 h-6 rounded-full bg-surface-bright text-on-surface font-label-mono-sm text-label-mono-sm flex items-center justify-center font-bold">
                                    2
                                </span>
                            </div>
                            <div class="flex flex-col gap-space-sm">
                                <!-- Card #AI-088 -->
                                <div class="group bg-surface-container hover:bg-surface-container-high transition-all p-space-sm rounded-lg shadow-sm cursor-grab active:cursor-grabbing">
                                    <div class="flex items-center justify-between mb-space-xs">
                                        <span class="font-label-mono-md text-label-mono-md text-primary font-bold">#AI-088</span>
                                        <span class="px-1.5 py-0.5 rounded text-label-mono-sm font-label-mono-sm bg-primary-container/20 text-primary font-bold">
                                            HIGH PRIORITY
                                        </span>
                                    </div>
                                    <p class="font-headline-sm text-headline-sm text-on-surface line-clamp-2 mb-space-xs group-hover:text-primary transition-colors">
                                        Autonomous Customer Support Agent
                                    </p>
                                    <div class="flex items-center gap-1 mb-space-sm">
                                        <span class="px-1.5 py-0.5 rounded bg-surface-container-lowest text-secondary font-label-caps text-label-caps">Technical Helpdesk</span>
                                        <span class="px-1.5 py-0.5 rounded bg-surface-container-lowest text-primary font-label-mono-sm text-label-mono-sm">Stage 4 EDA</span>
                                    </div>
                                    <!-- Mini Progress Indicator -->
                                    <div class="bg-surface-container-lowest rounded p-1.5 mb-space-sm">
                                        <div class="flex justify-between font-label-mono-sm text-label-mono-sm mb-1 text-on-surface-variant">
                                            <span class="">EDA Completion</span>
                                            <span class="text-primary font-bold">35%</span>
                                        </div>
                                        <div class="w-full bg-surface-container-high rounded-full h-1.5 overflow-hidden">
                                            <div class="bg-primary h-full rounded-full" style="width: 35%;"></div>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between pt-space-xs text-outline font-label-mono-sm text-label-mono-sm">
                                        <div class="flex items-center gap-1.5">
                                            <div class="w-5 h-5 rounded-full bg-secondary-container text-on-secondary-container flex items-center justify-center font-label-caps text-[9px] font-bold">LV</div>
                                            <span class="truncate max-w-[90px]">L. Volkov</span>
                                        </div>
                                        <span class="flex items-center gap-0.5 text-on-surface-variant font-mono">
                                            <span class="material-symbols-outlined text-[13px] text-primary">schedule</span>
                                            3d 12h
                                        </span>
                                    </div>
                                </div>
                                <!-- Card #AI-082 -->
                                <div class="group bg-surface-container hover:bg-surface-container-high transition-all p-space-sm rounded-lg shadow-sm cursor-grab active:cursor-grabbing">
                                    <div class="flex items-center justify-between mb-space-xs">
                                        <span class="font-label-mono-md text-label-mono-md text-on-surface font-bold">#AI-082</span>
                                        <span class="px-1.5 py-0.5 rounded text-label-mono-sm font-label-mono-sm bg-secondary-container/30 text-secondary">
                                            MED
                                        </span>
                                    </div>
                                    <p class="font-headline-sm text-headline-sm text-on-surface line-clamp-2 mb-space-sm group-hover:text-primary transition-colors">
                                        Synthetic Noise Ingestion in Spectrometer Data
                                    </p>
                                    <div class="flex items-center gap-1 mb-space-sm">
                                        <span class="px-1.5 py-0.5 rounded bg-surface-container-lowest text-outline font-label-mono-sm text-label-mono-sm">Stage 6 Features</span>
                                    </div>
                                    <div class="flex items-center justify-between text-outline font-label-mono-sm text-label-mono-sm">
                                        <div class="flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[14px]">psychology</span>
                                            <span class="">Unassigned</span>
                                        </div>
                                        <span class="text-on-surface-variant">Due: 2d</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- COLUMN 3: PHASE III (FOCUS COLUMN - MODEL BUILD & EVAL) -->
                        <div class="flex flex-col bg-surface-container-low rounded-xl p-space-sm shadow-md min-h-[640px] relative">
                            <!-- Col Header Highlighted -->
                            <div class="p-space-sm bg-surface-container-high rounded-lg mb-space-sm flex items-center justify-between shadow-sm">
                                <div class="flex flex-col">
                                    <div class="flex items-center gap-1.5">
                                        <span class="font-label-caps text-label-caps text-primary uppercase tracking-wider font-bold">PHASE III: Model &amp; Eval</span>
                                        <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                                    </div>
                                    <span class="font-label-mono-sm text-label-mono-sm text-outline">STAGES 07–09 · ACTIVE EXECUTION</span>
                                </div>
                                <span class="w-6 h-6 rounded-full bg-primary text-on-primary font-label-mono-sm text-label-mono-sm flex items-center justify-center font-bold shadow">
                                    4
                                </span>
                            </div>
                            <div class="flex flex-col gap-space-sm">
                                <!-- HERO CARD: #AI-024 (Highlighted Active Amber Instrument Module) -->
                                <div onclick="window.location.href='TicketDetail.php'" title="Click to view full Ticket #AI-024 specification" class="group bg-surface-container-highest hover:bg-surface-container p-space-md rounded-xl shadow-xl transition-all cursor-pointer relative overflow-hidden">
                                    <!-- Active Neon Rail Tag -->
                                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-primary via-primary-container to-primary"></div>
                                    <div class="flex items-center justify-between mb-space-xs">
                                        <div class="flex items-center gap-1.5">
                                            <span class="font-label-mono-lg text-label-mono-lg text-primary font-bold tracking-tight">#AI-024</span>
                                            <span class="px-1.5 py-0.2 rounded font-label-mono-sm text-label-mono-sm bg-primary/20 text-primary">FOCUS</span>
                                        </div>
                                        <span class="px-2 py-0.5 rounded text-label-caps bg-primary text-on-primary font-bold shadow-sm">
                                            HIGH PRIORITY
                                        </span>
                                    </div>
                                    <!-- Title & Context -->
                                    <h3 class="font-headline-md text-headline-sm text-on-surface font-bold tracking-tight mb-space-xs group-hover:text-primary transition-colors">
                                        Industrial Customer Churn MVP
                                    </h3>
                                    <!-- Client & Scenario Metadata -->
                                    <div class="space-y-1 mb-space-sm bg-surface-container-low p-space-xs rounded-lg">
                                        <div class="flex items-center justify-between font-label-mono-sm text-label-mono-sm">
                                            <span class="text-outline">SCENARIO:</span>
                                            <span class="text-on-surface font-semibold">01 Churn MVP</span>
                                        </div>
                                        <div class="flex items-center justify-between font-label-mono-sm text-label-mono-sm">
                                            <span class="text-outline">CLIENT:</span>
                                            <span class="text-secondary font-mono">CUS-1001 Aral Geomatics Group</span>
                                        </div>
                                        <div class="flex items-center justify-between font-label-mono-sm text-label-mono-sm">
                                            <span class="text-outline">DEPARTMENT:</span>
                                            <span class="text-on-surface">Sales &amp; Marketing</span>
                                        </div>
                                    </div>
                                    <!-- Business Metric Callout with Warning Badge -->
                                    <div class="bg-surface-container-lowest p-space-sm rounded-lg mb-space-sm space-y-1 shadow-inner">
                                        <div class="flex items-center justify-between font-label-caps text-label-caps">
                                            <span class="text-outline">Metric Threshold Gate:</span>
                                            <span class="font-mono text-on-surface font-bold">Target F1 ≥ 0.80</span>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-baseline gap-1.5">
                                                <span class="font-display-hero text-headline-lg text-primary font-mono leading-none">0.78</span>
                                                <span class="font-label-mono-sm text-label-mono-sm text-outline">CURRENT F1</span>
                                            </div>
                                            <div class="flex items-center gap-1 px-2 py-0.5 rounded bg-primary-container/20 text-primary font-label-mono-sm text-label-mono-sm font-bold animate-pulse">
                                                <span class="material-symbols-outlined text-[14px]">warning</span>
                                                -0.02 SUB-TARGET
                                            </div>
                                        </div>
                                        <div class="w-full bg-surface-container-high h-1.5 rounded-full overflow-hidden mt-1">
                                            <div class="bg-primary h-full rounded-full" style="width: 78%;"></div>
                                        </div>
                                    </div>
                                    <!-- Deliverables Progress Strip -->
                                    <div class="flex items-center justify-between font-label-mono-sm text-label-mono-sm mb-space-sm px-1 text-outline">
                                        <span class="flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[14px] text-tertiary">check_box</span>
                                            Deliverables: 3/5 Ready
                                        </span>
                                        <span class="text-on-surface font-bold">Stage 8 Model Evaluate</span>
                                    </div>
                                    <!-- Urgent Countdown & Assignee Footer -->
                                    <div class="pt-space-xs bg-surface-container p-space-xs rounded-lg flex items-center justify-between">
                                        <div class="flex items-center gap-space-xs">
                                            <div class="w-7 h-7 rounded-full bg-primary text-on-primary flex items-center justify-center font-bold text-label-caps shadow">
                                                GT
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="font-label-caps text-label-caps text-on-surface font-bold">Gulkaba T.</span>
                                                <span class="font-label-mono-sm text-label-mono-sm text-primary">Intern AI · L2</span>
                                            </div>
                                        </div>
                                        <!-- Urgent Pulse Chip -->
                                        <div class="flex items-center gap-1 px-2 py-1 rounded bg-error-container/30 text-error font-label-mono-sm text-label-mono-sm font-bold shadow-sm">
                                            <span class="w-1.5 h-1.5 rounded-full bg-error animate-ping"></span>
                                            <span class="">18h 42m remaining</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card #AI-029 -->
                                <div class="group bg-surface-container hover:bg-surface-container-high transition-all p-space-sm rounded-lg shadow-sm cursor-grab active:cursor-grabbing">
                                    <div class="flex items-center justify-between mb-space-xs">
                                        <span class="font-label-mono-md text-label-mono-md text-secondary font-bold">#AI-029</span>
                                        <span class="px-1.5 py-0.5 rounded text-label-mono-sm font-label-mono-sm bg-primary-container/20 text-primary">HIGH</span>
                                    </div>
                                    <p class="font-headline-sm text-headline-sm text-on-surface line-clamp-2 mb-space-sm group-hover:text-primary transition-colors">
                                        Acoustic Bearing Defect Classifier
                                    </p>
                                    <div class="flex items-center gap-1 mb-space-sm">
                                        <span class="px-1.5 py-0.5 rounded bg-surface-container-lowest text-outline font-label-mono-sm text-label-mono-sm">Stage 7 Model Build</span>
                                        <span class="px-1.5 py-0.5 rounded bg-surface-container-lowest text-tertiary font-label-mono-sm text-label-mono-sm">CNN-1D</span>
                                    </div>
                                    <div class="flex items-center justify-between text-outline font-label-mono-sm text-label-mono-sm">
                                        <div class="flex items-center gap-1.5">
                                            <div class="w-5 h-5 rounded-full bg-surface-bright text-on-surface flex items-center justify-center font-label-caps text-[9px]">DZ</div>
                                            <span class="">D. Zhumabay</span>
                                        </div>
                                        <span class="text-on-surface-variant">Due: 3d</span>
                                    </div>
                                </div>
                                <!-- Card #AI-032 -->
                                <div class="group bg-surface-container hover:bg-surface-container-high transition-all p-space-sm rounded-lg shadow-sm cursor-grab active:cursor-grabbing">
                                    <div class="flex items-center justify-between mb-space-xs">
                                        <span class="font-label-mono-md text-label-mono-md text-on-surface font-bold">#AI-032</span>
                                        <span class="px-1.5 py-0.5 rounded text-label-mono-sm font-label-mono-sm bg-surface-container-lowest text-outline">MED</span>
                                    </div>
                                    <p class="font-headline-sm text-headline-sm text-on-surface line-clamp-2 mb-space-sm">
                                        Hyperparameter Tuning for Latent Drift Regressor
                                    </p>
                                    <div class="flex items-center justify-between text-outline font-label-mono-sm text-label-mono-sm">
                                        <span class="">Stage 9 Improve</span>
                                        <span class="">Due: 4d 06h</span>
                                    </div>
                                </div>
                                <!-- Card #AI-036 -->
                                <div class="group bg-surface-container hover:bg-surface-container-high transition-all p-space-sm rounded-lg shadow-sm cursor-grab active:cursor-grabbing">
                                    <div class="flex items-center justify-between mb-space-xs">
                                        <span class="font-label-mono-md text-label-mono-md text-on-surface font-bold">#AI-036</span>
                                        <span class="px-1.5 py-0.5 rounded text-label-mono-sm font-label-mono-sm bg-surface-container-lowest text-outline">LOW</span>
                                    </div>
                                    <p class="font-headline-sm text-headline-sm text-on-surface line-clamp-2 mb-space-sm">
                                        Spectrogram Noise Quantization Benchmark
                                    </p>
                                    <div class="flex items-center justify-between text-outline font-label-mono-sm text-label-mono-sm">
                                        <span class="">Stage 7 Model Build</span>
                                        <span class="">Due: 9d</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- COLUMN 4: PHASE IV -->
                        <div class="flex flex-col bg-surface-container-low rounded-xl p-space-sm shadow-md min-h-[640px]">
                            <!-- Col Header -->
                            <div class="p-space-sm bg-surface-container rounded-lg mb-space-sm flex items-center justify-between shadow-sm">
                                <div class="flex flex-col">
                                    <span class="font-label-caps text-label-caps text-on-surface uppercase tracking-wider font-bold">PHASE IV: Deployment</span>
                                    <span class="font-label-mono-sm text-label-mono-sm text-outline">STAGES 10–11 · PRODUCTION</span>
                                </div>
                                <span class="w-6 h-6 rounded-full bg-surface-bright text-on-surface font-label-mono-sm text-label-mono-sm flex items-center justify-center font-bold">
                                    1
                                </span>
                            </div>
                            <div class="flex flex-col gap-space-sm">
                                <!-- Card #AI-019 -->
                                <div class="group bg-surface-container hover:bg-surface-container-high transition-all p-space-sm rounded-lg shadow-sm cursor-grab active:cursor-grabbing">
                                    <div class="flex items-center justify-between mb-space-xs">
                                        <span class="font-label-mono-md text-label-mono-md text-error font-bold">#AI-019</span>
                                        <span class="px-1.5 py-0.5 rounded text-label-mono-sm font-label-mono-sm bg-error-container/40 text-error font-bold">
                                            CRITICAL
                                        </span>
                                    </div>
                                    <p class="font-headline-sm text-headline-sm text-on-surface line-clamp-2 mb-space-sm group-hover:text-primary transition-colors">
                                        Hydraulic Pressure Predictor Microservice
                                    </p>
                                    <div class="flex items-center gap-1 mb-space-sm">
                                        <span class="px-1.5 py-0.5 rounded bg-tertiary-container/30 text-tertiary font-label-mono-sm text-label-mono-sm font-bold">Deployed v1.2</span>
                                        <span class="px-1.5 py-0.5 rounded bg-surface-container-lowest text-outline font-label-mono-sm text-label-mono-sm">Stage 11 Integrate</span>
                                    </div>
                                    <div class="p-space-xs rounded bg-surface-container-lowest text-outline font-label-mono-sm text-label-mono-sm mb-space-sm">
                                        <div class="flex justify-between items-center text-on-surface">
                                            <span class="">Docker Container:</span>
                                            <span class="text-tertiary">RUNNING</span>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <span class="">Inference RPS:</span>
                                            <span class="font-mono text-secondary">42.4 req/s</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between text-outline font-label-mono-sm text-label-mono-sm">
                                        <div class="flex items-center gap-1.5">
                                            <div class="w-5 h-5 rounded-full bg-secondary text-on-secondary flex items-center justify-center font-label-caps text-[9px] font-bold">MT</div>
                                            <span class="">M. Tursunov</span>
                                        </div>
                                        <span class="text-tertiary font-bold">STABLE</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- COLUMN 5: PHASE V -->
                        <div class="flex flex-col bg-surface-container-low rounded-xl p-space-sm shadow-md min-h-[640px]">
                            <!-- Col Header -->
                            <div class="p-space-sm bg-surface-container rounded-lg mb-space-sm flex items-center justify-between shadow-sm">
                                <div class="flex flex-col">
                                    <span class="font-label-caps text-label-caps text-on-surface uppercase tracking-wider font-bold">PHASE V: Monitoring &amp; SOC</span>
                                    <span class="font-label-mono-sm text-label-mono-sm text-outline">STAGES 12–14 · AUDIT &amp; DRIFT</span>
                                </div>
                                <span class="w-6 h-6 rounded-full bg-surface-bright text-on-surface font-label-mono-sm text-label-mono-sm flex items-center justify-center font-bold">
                                    2
                                </span>
                            </div>
                            <div class="flex flex-col gap-space-sm">
                                <!-- Card #AI-011 -->
                                <div class="group bg-surface-container hover:bg-surface-container-high transition-all p-space-sm rounded-lg shadow-sm cursor-grab active:cursor-grabbing">
                                    <div class="flex items-center justify-between mb-space-xs">
                                        <span class="font-label-mono-md text-label-mono-md text-tertiary font-bold">#AI-011</span>
                                        <span class="px-1.5 py-0.5 rounded text-label-mono-sm font-label-mono-sm bg-surface-container-lowest text-tertiary font-bold">
                                            NORMAL
                                        </span>
                                    </div>
                                    <p class="font-headline-sm text-headline-sm text-on-surface line-clamp-2 mb-space-sm group-hover:text-primary transition-colors">
                                        Turbine Vibration Anomaly Monitor
                                    </p>
                                    <div class="flex items-center gap-1 mb-space-sm">
                                        <span class="px-1.5 py-0.5 rounded bg-surface-container-lowest text-tertiary font-label-mono-sm text-label-mono-sm">Stage 12 Monitor</span>
                                        <span class="px-1.5 py-0.5 rounded bg-tertiary/10 text-tertiary font-label-mono-sm text-label-mono-sm">SOC 99.4%</span>
                                    </div>
                                    <!-- Telemetry Mini Graphic -->
                                    <div class="h-10 w-full bg-surface-container-lowest rounded p-1 mb-space-sm flex items-end gap-1">
                                        <div class="h-5 w-1/6 bg-tertiary/40 rounded-xs"></div>
                                        <div class="h-6 w-1/6 bg-tertiary/60 rounded-xs"></div>
                                        <div class="h-8 w-1/6 bg-tertiary/80 rounded-xs"></div>
                                        <div class="h-7 w-1/6 bg-tertiary/70 rounded-xs"></div>
                                        <div class="h-9 w-1/6 bg-tertiary rounded-xs"></div>
                                        <div class="h-8 w-1/6 bg-tertiary/90 rounded-xs"></div>
                                    </div>
                                    <div class="flex items-center justify-between text-outline font-label-mono-sm text-label-mono-sm">
                                        <span class="">SOC Agent AI-05</span>
                                        <span class="text-tertiary">Healthy Nominal</span>
                                    </div>
                                </div>
                                <!-- Card #AI-007 -->
                                <div class="group bg-surface-container/60 hover:bg-surface-container transition-all p-space-sm rounded-lg shadow-sm opacity-80 cursor-grab active:cursor-grabbing">
                                    <div class="flex items-center justify-between mb-space-xs">
                                        <span class="font-label-mono-md text-label-mono-md text-outline font-bold line-through">#AI-007</span>
                                        <span class="px-1.5 py-0.5 rounded text-label-mono-sm font-label-mono-sm bg-surface-container-lowest text-outline">
                                            ARCHIVED
                                        </span>
                                    </div>
                                    <p class="font-headline-sm text-headline-sm text-on-surface-variant line-clamp-2 mb-space-sm">
                                        Batch Billing Fraud Sentinel
                                    </p>
                                    <div class="flex items-center gap-1 mb-space-sm">
                                        <span class="px-1.5 py-0.5 rounded bg-surface-container-lowest text-outline font-label-mono-sm text-label-mono-sm">Stage 14 Final Report</span>
                                    </div>
                                    <div class="flex items-center justify-between text-outline font-label-mono-sm text-label-mono-sm">
                                        <span class="">Completed &amp; Signed</span>
                                        <span class="">Nov 2024</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- LIST VIEW CONTAINER (Hidden by default, toggled via JS) -->
                    <div class="hidden bg-surface-container-low rounded-xl overflow-hidden shadow-md" id="listViewContainer">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left font-body-sm text-body-sm">
                                <thead class="bg-surface-container font-label-caps text-label-caps text-outline uppercase tracking-wider">
                                    <tr>
                                        <th class="py-3 px-space-md">Ticket ID</th>
                                        <th class="py-3 px-space-md">Scenario &amp; Problem Statement</th>
                                        <th class="py-3 px-space-md">Phase / Stage</th>
                                        <th class="py-3 px-space-md">Department &amp; Client</th>
                                        <th class="py-3 px-space-md">Priority</th>
                                        <th class="py-3 px-space-md">Threshold Gate</th>
                                        <th class="py-3 px-space-md">Assignee</th>
                                        <th class="py-3 px-space-md text-right">Timecode</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-surface-container-high/40">
                                    <!-- Row #AI-024 Hero -->
                                    <tr onclick="window.location.href='TicketDetail.php'" title="Click to view full Ticket #AI-024 specification" class="bg-primary-container/10 hover:bg-primary-container/20 transition-colors cursor-pointer">
                                        <td class="py-3 px-space-md font-label-mono-md text-label-mono-md text-primary font-bold">#AI-024</td>
                                        <td class="py-3 px-space-md font-headline-sm text-headline-sm text-on-surface font-semibold">
                                            Industrial Customer Churn MVP
                                            <span class="block font-body-sm text-body-sm text-on-surface-variant font-normal">Scenario 01 Churn MVP · Telemetry Baseline</span>
                                        </td>
                                        <td class="py-3 px-space-md">
                                            <span class="px-2 py-0.5 rounded bg-primary text-on-primary font-label-mono-sm text-label-mono-sm font-bold">Phase III: St. 8 Evaluate</span>
                                        </td>
                                        <td class="py-3 px-space-md">
                                            <span class="block text-on-surface">Sales &amp; Marketing</span>
                                            <span class="font-label-mono-sm text-label-mono-sm text-secondary">CUS-1001 Aral Geomatics</span>
                                        </td>
                                        <td class="py-3 px-space-md">
                                            <span class="px-2 py-0.5 rounded font-label-caps text-label-caps bg-primary text-on-primary font-bold">HIGH</span>
                                        </td>
                                        <td class="py-3 px-space-md font-label-mono-md text-label-mono-md">
                                            <span class="text-primary font-bold">F1: 0.78</span> / 0.80
                                        </td>
                                        <td class="py-3 px-space-md">
                                            <div class="flex items-center gap-1.5">
                                                <div class="w-6 h-6 rounded-full bg-primary text-on-primary flex items-center justify-center font-bold text-label-caps">GT</div>
                                                <span class="text-on-surface">Gulkaba T. (L2)</span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-space-md text-right font-label-mono-sm text-label-mono-sm text-error font-bold">
                                            18h 42m
                                        </td>
                                    </tr>
                                    <!-- Row #AI-019 -->
                                    <tr class="hover:bg-surface-container transition-colors">
                                        <td class="py-3 px-space-md font-label-mono-md text-label-mono-md text-error font-bold">#AI-019</td>
                                        <td class="py-3 px-space-md font-headline-sm text-headline-sm text-on-surface font-medium">
                                            Hydraulic Pressure Predictor Microservice
                                        </td>
                                        <td class="py-3 px-space-md">
                                            <span class="px-2 py-0.5 rounded bg-surface-container-high text-on-surface font-label-mono-sm text-label-mono-sm">Phase IV: St. 11 Integrate</span>
                                        </td>
                                        <td class="py-3 px-space-md">Foundry &amp; Machine</td>
                                        <td class="py-3 px-space-md">
                                            <span class="px-2 py-0.5 rounded font-label-caps text-label-caps bg-error-container text-error font-bold">CRITICAL</span>
                                        </td>
                                        <td class="py-3 px-space-md font-label-mono-md text-label-mono-md text-tertiary">
                                            MSE ≤ 0.04 (PASSED)
                                        </td>
                                        <td class="py-3 px-space-md">M. Tursunov</td>
                                        <td class="py-3 px-space-md text-right font-label-mono-sm text-label-mono-sm text-tertiary">v1.2 LIVE</td>
                                    </tr>
                                    <!-- Row #AI-088 -->
                                    <tr class="hover:bg-surface-container transition-colors">
                                        <td class="py-3 px-space-md font-label-mono-md text-label-mono-md text-primary font-bold">#AI-088</td>
                                        <td class="py-3 px-space-md font-headline-sm text-headline-sm text-on-surface font-medium">
                                            Autonomous Customer Support Agent
                                        </td>
                                        <td class="py-3 px-space-md">
                                            <span class="px-2 py-0.5 rounded bg-surface-container-high text-on-surface font-label-mono-sm text-label-mono-sm">Phase II: St. 4 EDA</span>
                                        </td>
                                        <td class="py-3 px-space-md">Technical Helpdesk</td>
                                        <td class="py-3 px-space-md">
                                            <span class="px-2 py-0.5 rounded font-label-caps text-label-caps bg-primary-container text-on-primary-container font-bold">HIGH</span>
                                        </td>
                                        <td class="py-3 px-space-md font-label-mono-md text-label-mono-md text-outline">
                                            Pending Baseline
                                        </td>
                                        <td class="py-3 px-space-md">L. Volkov</td>
                                        <td class="py-3 px-space-md text-right font-label-mono-sm text-label-mono-sm text-on-surface-variant">3d 12h</td>
                                    </tr>
                                    <!-- Row #AI-091 -->
                                    <tr class="hover:bg-surface-container transition-colors">
                                        <td class="py-3 px-space-md font-label-mono-md text-label-mono-md text-secondary font-bold">#AI-091</td>
                                        <td class="py-3 px-space-md font-headline-sm text-headline-sm text-on-surface font-medium">
                                            Optical Sensor Calibration Drift Request
                                        </td>
                                        <td class="py-3 px-space-md">
                                            <span class="px-2 py-0.5 rounded bg-surface-container-high text-on-surface font-label-mono-sm text-label-mono-sm">Phase I: St. 1 Request</span>
                                        </td>
                                        <td class="py-3 px-space-md">Foundry &amp; Optics</td>
                                        <td class="py-3 px-space-md">
                                            <span class="px-2 py-0.5 rounded font-label-caps text-label-caps bg-secondary-container text-on-secondary font-bold">MED</span>
                                        </td>
                                        <td class="py-3 px-space-md font-label-mono-md text-label-mono-md text-outline">N/A</td>
                                        <td class="py-3 px-space-md">K. Saparov</td>
                                        <td class="py-3 px-space-md text-right font-label-mono-sm text-label-mono-sm text-on-surface-variant">5d</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Bottom Global Telemetry Status Bar -->
                    <div class="h-8 px-space-md bg-surface-container-lowest rounded-lg flex items-center justify-between font-label-mono-sm text-label-mono-sm text-outline shadow-inner">
                        <div class="flex items-center gap-space-md">
                            <span class="flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-tertiary"></span>
                                SYS-AI SCHEDULER: OK
                            </span>
                            <span class="hidden md:inline">BOARD RUNTIME: 412h 19m</span>
                            <span class="hidden md:inline">LOCK PROTOCOL: SECURE-TLS-V1.3</span>
                        </div>
                        <div class="flex items-center gap-space-sm text-on-surface">
                            <span class="text-primary font-bold">TICKET DISPATCHER V2.4</span>
                            <span class="opacity-30">|</span>
                            <span class="">SYS_EPOCH: 1731698402</span>
                        </div>
                    </div>
                </div>
                <!-- Client-side View Switcher & Interactive Script -->
                
            </div>
        </main>
    </div>

    <script src="../assets/js/app.js"></script>
    <script src="js/main.js"></script>
</body>

</html>