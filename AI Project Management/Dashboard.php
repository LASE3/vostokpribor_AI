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
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@100..900&family=Inter:wght@100..900&family=Space+Mono:wght@100..900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/css/global.css" />
    <link rel="stylesheet" href="css/style.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="js/tailwind.config.js"></script>
</head>

<body class="bg-surface font-body-md text-on-surface">
    <aside class="fixed left-0 top-0 h-full w-64 bg-surface-container-low z-50 flex flex-col justify-between shadow-[0_1px_8px_rgba(0,0,0,0.04)]">
        <div class="flex flex-col">
            <div class="h-16 px-space-md flex items-center gap-space-sm bg-surface-container-lowest"><a href="../index.php" title="Return to Core 5-System Portal" class="flex items-center gap-space-sm"><img alt="VOSTOKPRIBOR Industrial AI Logo" class="h-8 w-auto object-contain" src="https://lh3.googleusercontent.com/aida/AEtjO1W0pnhS8IEaoTn70IOGIuwcWNpNgh10xzjUL5_oCtxmTZj8xgF1DI7e0F5iyT9zuQXrKTSp8fVISDLajw0cOVTlsEJPJrw3qV9YjP2k2JzO1v07n2BIvWyOQ5iikdzARo6tUdO70wQtL3rfgjs-8WdFHO9vFslvSDw0chLlp2BAZ27-Xf1xpu_2HcIYL1r5bO9UnamptMdIQ9n5jEdsmz-3oTg0r8nFbGeBPfgRIO6XOLSGrkRx6lGMUYj8" /></a>
                <div class="flex flex-col"><span class="font-label-caps text-label-caps text-on-surface tracking-wider uppercase">VOSTOKPRIBOR</span><span class="font-label-mono-sm text-label-mono-sm text-primary">SYS-AI CORE ENGINE</span></div>
            </div>
            <div class="px-space-md py-space-sm">
                <div class="font-label-mono-sm text-label-mono-sm text-outline uppercase tracking-wider mb-space-xs">Telemetry Rail</div>
                <nav class="flex flex-col gap-space-xs" data-active-classes="bg-surface-container-high text-primary font-headline-sm"><a class="group flex items-center justify-between px-space-md py-space-sm rounded text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="projects" href="Dashboard.php">
                        <div class="flex items-center gap-space-sm"><span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse"></span><span class="font-label-caps text-label-caps">SYS-AI-01 Projects</span></div><span class="font-label-mono-sm text-label-mono-sm text-primary">ACT</span>
                    </a><a class="group flex items-center justify-between px-space-md py-space-sm rounded text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="data-center" href="../Data Center/DatasetCatalog.php">
                        <div class="flex items-center gap-space-sm"><span class="w-1.5 h-1.5 rounded-full bg-outline-variant"></span><span class="font-label-caps text-label-caps">SYS-AI-02 Data Center</span></div><span class="font-label-mono-sm text-label-mono-sm text-on-surface-variant">SYNC</span>
                    </a><a class="group flex items-center justify-between px-space-md py-space-sm rounded text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="workbench" href="../AI/ML Workbench/WorkbenchHome.php">
                        <div class="flex items-center gap-space-sm"><span class="w-1.5 h-1.5 rounded-full bg-outline-variant"></span><span class="font-label-caps text-label-caps">SYS-AI-03 Workbench</span></div><span class="font-label-mono-sm text-label-mono-sm text-on-surface-variant">RDY</span>
                    </a><a class="group flex items-center justify-between px-space-md py-space-sm rounded text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="registry-deployment" href="../Model Registry & Deployment/ModelRegistry.php">
                        <div class="flex items-center gap-space-sm"><span class="w-1.5 h-1.5 rounded-full bg-outline-variant"></span><span class="font-label-caps text-label-caps">SYS-AI-04 Registry & Deploy</span></div><span class="font-label-mono-sm text-label-mono-sm text-on-surface-variant">v2.4</span>
                    </a><a class="group flex items-center justify-between px-space-md py-space-sm rounded text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="ai-soc" href="../AI Operations Center (AI SOC)/FleetTelemetry.php">
                        <div class="flex items-center gap-space-sm"><span class="w-1.5 h-1.5 rounded-full bg-tertiary"></span><span class="font-label-caps text-label-caps">SYS-AI-05 AI SOC</span></div><span class="font-label-mono-sm text-label-mono-sm text-tertiary">SEC</span>
                    </a></nav>
            </div>
        </div>
        <div class="p-space-md bg-surface-container-lowest flex flex-col gap-space-xs">
            <div class="flex items-center gap-space-xs"><span class="inline-block w-2 h-2 rounded-full bg-tertiary"></span><span class="font-label-mono-sm text-label-mono-sm text-tertiary">SYS-AI ONLINE</span></div>
            <div class="font-label-mono-sm text-label-mono-sm text-on-surface-variant">LATENCY 14ms · ALMATY DC-01</div>
            <div class="font-label-mono-sm text-label-mono-sm text-outline">UPTIME 99.98% · NODE_ID: 884-A</div>
        </div>
    </aside>
    <div class="pl-64">
        <header class="fixed top-0 left-64 right-0 z-40 bg-surface/90 backdrop-blur-xl shadow-[0_1px_8px_rgba(0,0,0,0.04)]">
            <div class="h-16 px-space-lg flex items-center justify-between gap-space-md">
                <div class="flex items-center gap-space-md"><span class="font-headline-sm text-headline-sm text-on-surface tracking-tight whitespace-nowrap">VOSTOKPRIBOR · SYS-AI INDUSTRIAL PORTAL</span>
                    <div class="relative flex items-center bg-surface-container px-space-sm py-space-xs rounded w-64"><span class="material-symbols-outlined text-outline text-[18px] mr-space-xs">search</span><input class="bg-transparent w-full text-on-surface placeholder:text-outline font-body-sm text-body-sm focus:outline-none" placeholder="Search telemetry, jobs..." type="text" /><span class="font-label-mono-sm text-label-mono-sm bg-surface-container-high text-on-surface-variant px-1 rounded">⌘K</span></div>
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
                <nav class="flex items-center gap-space-xs" data-active-classes="bg-primary text-on-primary font-bold rounded-full"><a aria-current="page" class="px-space-sm py-0.5 transition-colors bg-primary text-on-primary font-bold rounded-full" data-path="dashboard" href="Dashboard.php">Dashboard</a><a class="px-space-sm py-0.5 rounded-full font-label-caps text-label-caps text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="ticket-board" href="TicketBoard.php">Ticket Board</a><a class="px-space-sm py-0.5 rounded-full font-label-caps text-label-caps text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="ticket-detail-ai-024" href="TicketDetail.php">Ticket Detail #AI-024</a><a class="px-space-sm py-0.5 rounded-full font-label-caps text-label-caps text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="submissions" href="DeliverablesAndSubmissionPanel.php">Submissions</a><a class="px-space-sm py-0.5 rounded-full font-label-caps text-label-caps text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="evaluation" href="EvaluationView.php">Evaluation</a><a class="px-space-sm py-0.5 rounded-full font-label-caps text-label-caps text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="instructor-portal" href="InstructorDashboard.php">Instructor Portal</a></nav>
                <div class="flex items-center gap-space-xs font-label-mono-sm text-label-mono-sm text-outline"><span class="material-symbols-outlined text-[14px] text-tertiary">sync</span><span>BUFFER 100% NOMINAL</span></div>
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
                <div class="p-space-lg flex flex-col gap-space-lg max-w-[1720px] mx-auto w-full">
                    <!-- SUB-HEADER / INTERN IDENTITY BAR -->
                    <div class="bg-surface-container-low rounded-xl p-space-lg flex flex-col xl:flex-row xl:items-center justify-between gap-space-md shadow-sm relative overflow-hidden">
                        <div class="absolute -right-16 -top-16 w-64 h-64 bg-primary/5 rounded-full blur-3xl pointer-events-none"></div>
                        <div class="flex flex-col gap-space-xs z-10">
                            <div class="flex items-center gap-space-sm flex-wrap">
                                <span class="font-label-mono-md text-label-mono-md text-primary tracking-widest uppercase bg-surface-container-high px-space-xs py-0.5 rounded">
                                    INTERN WORKBENCH // COHORT 1968-Q3
                                </span>
                                <span class="font-label-mono-sm text-label-mono-sm text-outline">SYS_ID: ALM-LAB-04 // PROTOCOL SEC_AUTH</span>
                                <div class="flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-tertiary-container/20 text-tertiary">
                                    <span class="w-1.5 h-1.5 rounded-full bg-tertiary animate-pulse"></span>
                                    <span class="font-label-mono-sm text-label-mono-sm font-bold">ALPHA OPERATIONAL</span>
                                </div>
                            </div>
                            <div class="flex items-baseline gap-space-sm flex-wrap">
                                <h1 class="font-headline-lg text-headline-lg text-on-surface tracking-tight">
                                    Welcome back, Eng. Gulkaba T.
                                </h1>
                                <span class="font-body-md text-body-md text-on-surface-variant">
                                    · Station: <span class="font-label-mono-md text-on-surface">ALM-LAB-04</span> · Shift: <span class="text-primary font-medium">Alpha (08:00 - 16:30)</span>
                                </span>
                            </div>
                        </div>
                        <div class="flex items-center gap-space-sm shrink-0 z-10 flex-wrap">
                            <button class="bg-primary text-on-primary font-headline-sm text-headline-sm px-space-md py-space-xs rounded-lg hover:bg-primary-fixed-dim transition-all shadow-md flex items-center gap-space-xs">
                                <span class="material-symbols-outlined text-[18px]">add_task</span>
                                <span>Create Quick Ticket</span>
                            </button>
                            <button class="bg-surface-container-high text-on-surface font-label-caps text-label-caps px-space-md py-2 rounded-lg hover:bg-surface-bright transition-colors flex items-center gap-space-xs shadow-sm">
                                <span class="material-symbols-outlined text-[16px] text-secondary">database</span>
                                <span>View Telemetry Logs</span>
                            </button>
                            <button class="bg-surface-container-lowest text-primary font-label-mono-md text-label-mono-md px-space-md py-2 rounded-lg hover:bg-surface-container transition-colors flex items-center gap-space-xs shadow-sm">
                                <span class="material-symbols-outlined text-[16px]">terminal</span>
                                <span>Terminal CLI</span>
                            </button>
                        </div>
                    </div>
                    <!-- MAIN BENTO GRID ARCHITECTURE (12-Col Master Instrument Rack) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-12 gap-space-md items-start">
                        <!-- ==========================================
           TILE A: HERO STATUS & LEVEL PROGRESSION (4 cols)
           ========================================== -->
                        <div class="xl:col-span-4 bg-surface-container rounded-xl p-space-lg flex flex-col justify-between shadow-sm relative overflow-hidden h-full min-h-[380px]">
                            <div class="flex items-start justify-between">
                                <div class="flex flex-col">
                                    <span class="font-label-mono-sm text-label-mono-sm text-outline uppercase tracking-wider">Calibration Grade // Milestone</span>
                                    <h2 class="font-headline-md text-headline-md text-on-surface font-semibold tracking-tight mt-1">Level 2: Engineer</h2>
                                </div>
                                <span class="bg-primary/10 text-primary font-label-mono-sm text-label-mono-sm px-2 py-1 rounded tracking-widest font-bold">
                                    STAGE 2 / 3
                                </span>
                            </div>
                            <!-- Gauge Matrix Visualizer -->
                            <div class="my-space-md bg-surface-container-low p-space-md rounded-lg flex flex-col gap-space-sm">
                                <div class="flex items-center justify-between">
                                    <span class="font-label-mono-sm text-label-mono-sm text-on-surface-variant">L2 PROGRESSION INDEX</span>
                                    <span class="font-label-mono-lg text-label-mono-lg text-primary font-bold">68% NOMINAL</span>
                                </div>
                                <!-- Segmented Progress Bar -->
                                <div class="w-full bg-surface-container-lowest h-3 rounded flex overflow-hidden p-0.5 gap-1">
                                    <div class="h-full bg-primary rounded-sm transition-all" style="width: 68%;"></div>
                                    <div class="h-full bg-primary/20 rounded-sm flex-1"></div>
                                </div>
                                <!-- Industrial Level Stepper -->
                                <div class="grid grid-cols-3 gap-space-xs pt-space-xs">
                                    <div class="flex flex-col gap-1 p-2 rounded bg-surface-container">
                                        <div class="flex items-center justify-between">
                                            <span class="font-label-mono-sm text-label-mono-sm text-tertiary">L-01</span>
                                            <span class="material-symbols-outlined text-[14px] text-tertiary">check_circle</span>
                                        </div>
                                        <span class="font-label-caps text-label-caps text-on-surface leading-tight">Fundamentals</span>
                                        <span class="font-label-mono-sm text-label-mono-sm text-tertiary">100% DONE</span>
                                    </div>
                                    <div class="flex flex-col gap-1 p-2 rounded bg-surface-container-high">
                                        <div class="flex items-center justify-between">
                                            <span class="font-label-mono-sm text-label-mono-sm text-primary">L-02</span>
                                            <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                                        </div>
                                        <span class="font-label-caps text-label-caps text-on-surface leading-tight font-bold">Engineer</span>
                                        <span class="font-label-mono-sm text-label-mono-sm text-primary">68% ACTIVE</span>
                                    </div>
                                    <div class="flex flex-col gap-1 p-2 rounded bg-surface-container opacity-50">
                                        <div class="flex items-center justify-between">
                                            <span class="font-label-mono-sm text-label-mono-sm text-outline">L-03</span>
                                            <span class="material-symbols-outlined text-[14px] text-outline">lock</span>
                                        </div>
                                        <span class="font-label-caps text-label-caps text-on-surface-variant leading-tight">Production</span>
                                        <span class="font-label-mono-sm text-label-mono-sm text-outline">LOCKED</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Metric Footer Specs -->
                            <div class="flex items-center justify-between pt-space-sm">
                                <div class="flex items-center gap-space-xs text-on-surface-variant">
                                    <span class="material-symbols-outlined text-[16px] text-primary">verified</span>
                                    <span class="font-body-sm text-body-sm">Target: Oct 1968 / Nov 2025</span>
                                </div>
                                <span class="font-label-mono-sm text-label-mono-sm text-secondary-fixed-dim bg-secondary-container px-2 py-0.5 rounded">
                                    +320 XP REMAINING
                                </span>
                            </div>
                        </div>
                        <!-- ==========================================
           TILE B: ACTIVE ASSIGNED TICKETS & COUNTDOWN (5 cols)
           ========================================== -->
                        <div class="xl:col-span-5 bg-surface-container rounded-xl p-space-lg flex flex-col justify-between shadow-sm relative h-full min-h-[380px]">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-space-xs">
                                    <span class="w-2 h-2 rounded-full bg-primary"></span>
                                    <h2 class="font-headline-sm text-headline-sm text-on-surface font-semibold tracking-tight">Active Assignment Queue</h2>
                                </div>
                                <div class="flex items-center gap-space-xs font-label-mono-sm text-label-mono-sm">
                                    <span class="px-2 py-0.5 rounded bg-surface-container-high text-primary font-bold">2 RUNNING</span>
                                    <span class="px-2 py-0.5 rounded bg-surface-container-lowest text-tertiary">4 CLEARED</span>
                                </div>
                            </div>
                            <div class="flex flex-col gap-space-sm my-space-sm">
                                <!-- Primary Ticket Card: #AI-024 -->
                                <div class="p-space-md rounded-lg bg-surface-container-low hover:bg-surface-container-high transition-colors flex flex-col gap-space-xs relative overflow-hidden group">
                                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-primary"></div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-space-xs">
                                            <span class="font-label-mono-md text-label-mono-md text-primary font-bold">#AI-024</span>
                                            <span class="px-1.5 py-0.2 rounded bg-error-container/40 text-error font-label-mono-sm text-label-mono-sm">HIGH PRIORITY</span>
                                            <span class="font-label-mono-sm text-label-mono-sm text-outline">SALES & MKTG</span>
                                        </div>
                                        <div class="flex items-center gap-1 text-primary font-label-mono-md text-label-mono-md bg-surface-container px-2 py-0.5 rounded">
                                            <span class="material-symbols-outlined text-[14px]">timer</span>
                                            <span>18h 42m</span>
                                        </div>
                                    </div>
                                    <div class="font-headline-sm text-headline-sm text-on-surface font-medium truncate">
                                        Industrial Customer Churn MVP
                                    </div>
                                    <div class="flex flex-col gap-1 mt-1">
                                        <div class="flex items-center justify-between font-label-mono-sm text-label-mono-sm">
                                            <span class="text-on-surface-variant">Stage 8/14: Model Evaluation</span>
                                            <span class="text-primary font-bold">57.1% STEPS COMPLETED</span>
                                        </div>
                                        <div class="w-full bg-surface-container-lowest h-1.5 rounded overflow-hidden">
                                            <div class="bg-primary h-full rounded transition-all animate-pulse" style="width: 57.1%;"></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Secondary Ticket Card: #AI-088 -->
                                <div class="p-space-md rounded-lg bg-surface-container-low hover:bg-surface-container-high transition-colors flex flex-col gap-space-xs relative overflow-hidden">
                                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-secondary"></div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-space-xs">
                                            <span class="font-label-mono-md text-label-mono-md text-secondary font-bold">#AI-088</span>
                                            <span class="px-1.5 py-0.2 rounded bg-secondary-container text-secondary font-label-mono-sm text-label-mono-sm">MED PRIORITY</span>
                                            <span class="font-label-mono-sm text-label-mono-sm text-outline">HELPDESK TECH</span>
                                        </div>
                                        <div class="flex items-center gap-1 text-on-surface-variant font-label-mono-md text-label-mono-md bg-surface-container px-2 py-0.5 rounded">
                                            <span class="material-symbols-outlined text-[14px]">schedule</span>
                                            <span>3d 12h</span>
                                        </div>
                                    </div>
                                    <div class="font-headline-sm text-headline-sm text-on-surface font-medium truncate">
                                        Autonomous Customer Support Agent
                                    </div>
                                    <div class="flex items-center justify-between font-body-sm text-body-sm pt-1">
                                        <div class="flex items-center gap-1.5 text-on-surface-variant">
                                            <span class="material-symbols-outlined text-[14px]">group</span>
                                            <span>Assigned: <span class="font-label-mono-sm text-on-surface">EMP-1018 Leonid V.</span></span>
                                        </div>
                                        <span class="font-label-mono-sm text-label-mono-sm text-secondary">Stage 4/14: EDA</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between text-on-surface-variant pt-space-xs">
                                <span class="font-label-mono-sm text-label-mono-sm">ZERO PIPELINE BLOCKERS REPORTED</span>
                                <a class="font-label-mono-md text-label-mono-md text-primary flex items-center gap-1 hover:underline" href="#">
                                    <span>DISPATCH BOARD</span>
                                    <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                                </a>
                            </div>
                        </div>
                        <!-- ==========================================
           TILE C: SCORE & COMPETENCY SUMMARY (3 cols)
           ========================================== -->
                        <div class="xl:col-span-3 bg-surface-container rounded-xl p-space-lg flex flex-col justify-between shadow-sm relative h-full min-h-[380px]">
                            <div class="flex items-center justify-between">
                                <span class="font-label-mono-sm text-label-mono-sm text-outline uppercase tracking-wider">AGGREGATE QA SCORE</span>
                                <span class="bg-tertiary-container text-on-tertiary-container font-label-mono-sm text-label-mono-sm font-bold px-2 py-0.5 rounded">
                                    GRADE: A-
                                </span>
                            </div>
                            <div class="flex items-baseline gap-space-xs my-space-xs">
                                <span class="font-display-hero text-display-hero text-on-surface font-bold tracking-tight">84.2</span>
                                <span class="font-headline-sm text-headline-sm text-outline font-normal">/ 100</span>
                                <span class="ml-auto font-label-mono-sm text-label-mono-sm text-tertiary font-bold">+2.4 vs LAST RUN</span>
                            </div>
                            <!-- Competency Matrix Pills -->
                            <div class="flex flex-col gap-2 bg-surface-container-low p-space-md rounded-lg">
                                <div class="flex flex-col gap-1">
                                    <div class="flex justify-between font-label-caps text-label-caps text-on-surface-variant">
                                        <span>Model Build Architecture</span>
                                        <span class="font-label-mono-sm text-on-surface font-bold">91%</span>
                                    </div>
                                    <div class="w-full bg-surface-container-lowest h-1.5 rounded overflow-hidden">
                                        <div class="bg-tertiary h-full rounded" style="width: 91%;"></div>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-1">
                                    <div class="flex justify-between font-label-caps text-label-caps text-on-surface-variant">
                                        <span>Data Prep & Transformation</span>
                                        <span class="font-label-mono-sm text-on-surface font-bold">85%</span>
                                    </div>
                                    <div class="w-full bg-surface-container-lowest h-1.5 rounded overflow-hidden">
                                        <div class="bg-primary h-full rounded" style="width: 85%;"></div>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-1">
                                    <div class="flex justify-between font-label-caps text-label-caps text-on-surface-variant">
                                        <span>Business Threshold Verification</span>
                                        <span class="font-label-mono-sm text-on-surface font-bold">80%</span>
                                    </div>
                                    <div class="w-full bg-surface-container-lowest h-1.5 rounded overflow-hidden">
                                        <div class="bg-secondary h-full rounded" style="width: 80%;"></div>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-1">
                                    <div class="flex justify-between font-label-caps text-label-caps text-on-surface-variant">
                                        <span>Incident SOC Response</span>
                                        <span class="font-label-mono-sm text-on-surface font-bold">78%</span>
                                    </div>
                                    <div class="w-full bg-surface-container-lowest h-1.5 rounded overflow-hidden">
                                        <div class="bg-outline h-full rounded" style="width: 78%;"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center gap-space-xs text-on-surface-variant font-label-mono-sm text-label-mono-sm pt-space-xs">
                                <span class="material-symbols-outlined text-[14px] text-tertiary">check</span>
                                <span>Industrial Standard ISO/IEC 42001 PASSED</span>
                            </div>
                        </div>
                        <!-- ==========================================
           TILE D: ROADMAP OF 7 INDUSTRIAL SCENARIOS (8 cols)
           ========================================== -->
                        <div class="xl:col-span-8 bg-surface-container rounded-xl p-space-lg flex flex-col gap-space-md shadow-sm">
                            <div class="flex items-center justify-between flex-wrap gap-2">
                                <div class="flex items-center gap-space-sm">
                                    <span class="material-symbols-outlined text-primary text-[20px]">account_tree</span>
                                    <div>
                                        <h2 class="font-headline-sm text-headline-sm text-on-surface font-semibold">Industrial Qualification Matrix // 7 Scenarios</h2>
                                        <span class="font-label-mono-sm text-label-mono-sm text-outline">ACTIVE MISSION PROTOCOL 1968-ALMATY</span>
                                    </div>
                                </div>
                                <span class="font-label-mono-sm text-label-mono-sm text-on-surface-variant bg-surface-container-high px-space-xs py-1 rounded">
                                    CURRENT CLEARANCE: LEVEL 2
                                </span>
                            </div>
                            <!-- 7 Scenarios Grid -->
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-space-sm">
                                <!-- Scenario 01: Customer Churn MVP -->
                                <div class="p-space-md rounded-lg bg-surface-container-high flex flex-col justify-between gap-space-sm relative overflow-hidden shadow-sm">
                                    <div class="absolute top-0 right-0 w-2 h-2 rounded-bl bg-primary"></div>
                                    <div class="flex flex-col gap-1">
                                        <div class="flex items-center justify-between">
                                            <span class="font-label-mono-md text-label-mono-md text-primary font-bold">SCENARIO // 01</span>
                                            <span class="px-1.5 py-0.5 rounded bg-primary/20 text-primary font-label-mono-sm text-label-mono-sm font-bold">IN PROGRESS</span>
                                        </div>
                                        <h3 class="font-headline-sm text-headline-sm text-on-surface font-semibold leading-snug">Customer Churn MVP</h3>
                                        <p class="font-body-sm text-body-sm text-on-surface-variant">Aral Geomatics Group telemetry churn scoring pipeline.</p>
                                    </div>
                                    <div class="flex flex-col gap-1.5 pt-space-xs bg-surface-container-low p-2 rounded">
                                        <div class="flex justify-between font-label-mono-sm text-label-mono-sm text-outline">
                                            <span>CLIENT: CUS-1001</span>
                                            <span>DS: 28.4K ROWS</span>
                                        </div>
                                        <div class="flex items-center justify-between font-label-mono-sm text-label-mono-sm text-primary">
                                            <span>STAGE 8/14 ACTIVE</span>
                                            <span class="material-symbols-outlined text-[14px]">sensors</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- Scenario 02: Fraud Detection -->
                                <div class="p-space-md rounded-lg bg-surface-container-low hover:bg-surface-container-high transition-colors flex flex-col justify-between gap-space-sm shadow-sm">
                                    <div class="flex flex-col gap-1">
                                        <div class="flex items-center justify-between">
                                            <span class="font-label-mono-md text-label-mono-md text-secondary font-bold">SCENARIO // 02</span>
                                            <span class="px-1.5 py-0.5 rounded bg-secondary-container text-secondary font-label-mono-sm text-label-mono-sm">UNLOCKED</span>
                                        </div>
                                        <h3 class="font-headline-sm text-headline-sm text-on-surface font-semibold leading-snug">Fraud & Invoice Audit</h3>
                                        <p class="font-body-sm text-body-sm text-on-surface-variant">Optical telemetry document extraction & anomaly ledger filter.</p>
                                    </div>
                                    <div class="flex flex-col gap-1.5 pt-space-xs bg-surface-container p-2 rounded">
                                        <div class="flex justify-between font-label-mono-sm text-label-mono-sm text-outline">
                                            <span>CLIENT: FIN-SYS-88</span>
                                            <span>DS: 110K DOCS</span>
                                        </div>
                                        <div class="flex items-center justify-between font-label-mono-sm text-label-mono-sm text-secondary">
                                            <span>READY TO LAUNCH</span>
                                            <span class="material-symbols-outlined text-[14px]">lock_open</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- Scenario 03: CV Defect Inspection -->
                                <div class="p-space-md rounded-lg bg-surface-container-lowest opacity-75 flex flex-col justify-between gap-space-sm shadow-sm">
                                    <div class="flex flex-col gap-1">
                                        <div class="flex items-center justify-between">
                                            <span class="font-label-mono-md text-label-mono-md text-outline font-bold">SCENARIO // 03</span>
                                            <span class="px-1.5 py-0.5 rounded bg-surface-container-high text-outline font-label-mono-sm text-label-mono-sm">LOCKED</span>
                                        </div>
                                        <h3 class="font-headline-sm text-headline-sm text-on-surface-variant font-semibold leading-snug">CV Defect Inspection</h3>
                                        <p class="font-body-sm text-body-sm text-outline">Optical sorting line high-speed surface defect edge inference.</p>
                                    </div>
                                    <div class="flex flex-col gap-1.5 pt-space-xs bg-surface-container p-2 rounded">
                                        <div class="flex justify-between font-label-mono-sm text-label-mono-sm text-outline">
                                            <span>REQ: SCORE ≥ 85%</span>
                                            <span>CAMERA FEED</span>
                                        </div>
                                        <div class="flex items-center justify-between font-label-mono-sm text-label-mono-sm text-outline">
                                            <span>REQUIRES LEVEL 2.5</span>
                                            <span class="material-symbols-outlined text-[14px]">lock</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- Scenario 04: NLP Complaint Classification -->
                                <div class="p-space-md rounded-lg bg-surface-container-lowest opacity-75 flex flex-col justify-between gap-space-sm shadow-sm">
                                    <div class="flex flex-col gap-1">
                                        <div class="flex items-center justify-between">
                                            <span class="font-label-mono-md text-label-mono-md text-outline font-bold">SCENARIO // 04</span>
                                            <span class="px-1.5 py-0.5 rounded bg-surface-container-high text-outline font-label-mono-sm text-label-mono-sm">LOCKED</span>
                                        </div>
                                        <h3 class="font-headline-sm text-headline-sm text-on-surface-variant font-semibold leading-snug">NLP Complaint Routing</h3>
                                        <p class="font-body-sm text-body-sm text-outline">Multi-lingual industrial telemetry text classification engine.</p>
                                    </div>
                                    <div class="flex flex-col gap-1.5 pt-space-xs bg-surface-container p-2 rounded">
                                        <div class="flex justify-between font-label-mono-sm text-label-mono-sm text-outline">
                                            <span>REQ: SCENARIO 02</span>
                                            <span>DS: 52K ENTRIES</span>
                                        </div>
                                        <div class="flex items-center justify-between font-label-mono-sm text-label-mono-sm text-outline">
                                            <span>PREREQUISITE UNMET</span>
                                            <span class="material-symbols-outlined text-[14px]">lock</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- Scenario 05: GenAI HR Assistant -->
                                <div class="p-space-md rounded-lg bg-surface-container-lowest opacity-75 flex flex-col justify-between gap-space-sm shadow-sm">
                                    <div class="flex flex-col gap-1">
                                        <div class="flex items-center justify-between">
                                            <span class="font-label-mono-md text-label-mono-md text-outline font-bold">SCENARIO // 05</span>
                                            <span class="px-1.5 py-0.5 rounded bg-surface-container-high text-outline font-label-mono-sm text-label-mono-sm">LOCKED</span>
                                        </div>
                                        <h3 class="font-headline-sm text-headline-sm text-on-surface-variant font-semibold leading-snug">GenAI HR RAG Assistant</h3>
                                        <p class="font-body-sm text-body-sm text-outline">Vector-embedded regulatory knowledge corpus retrieval assistant.</p>
                                    </div>
                                    <div class="flex flex-col gap-1.5 pt-space-xs bg-surface-container p-2 rounded">
                                        <div class="flex justify-between font-label-mono-sm text-label-mono-sm text-outline">
                                            <span>REQ: LEVEL 3 PROD</span>
                                            <span>CORPUS: 1.4GB</span>
                                        </div>
                                        <div class="flex items-center justify-between font-label-mono-sm text-label-mono-sm text-outline">
                                            <span>L3 CLEARANCE REQ</span>
                                            <span class="material-symbols-outlined text-[14px]">lock</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- Scenario 06: Support AI Agent -->
                                <div class="p-space-md rounded-lg bg-surface-container-low hover:bg-surface-container-high transition-colors flex flex-col justify-between gap-space-sm shadow-sm">
                                    <div class="flex flex-col gap-1">
                                        <div class="flex items-center justify-between">
                                            <span class="font-label-mono-md text-label-mono-md text-tertiary font-bold">SCENARIO // 06</span>
                                            <span class="px-1.5 py-0.5 rounded bg-tertiary-container/30 text-tertiary font-label-mono-sm text-label-mono-sm">IN REVIEW</span>
                                        </div>
                                        <h3 class="font-headline-sm text-headline-sm text-on-surface font-semibold leading-snug">Customer Support Agent</h3>
                                        <p class="font-body-sm text-body-sm text-on-surface-variant">Autonomous multi-tool problem resolution AI workflow loop.</p>
                                    </div>
                                    <div class="flex flex-col gap-1.5 pt-space-xs bg-surface-container p-2 rounded">
                                        <div class="flex justify-between font-label-mono-sm text-label-mono-sm text-outline">
                                            <span>STAFF: LEONID V.</span>
                                            <span>#AI-088</span>
                                        </div>
                                        <div class="flex items-center justify-between font-label-mono-sm text-label-mono-sm text-tertiary">
                                            <span>EXPLORATION RDY</span>
                                            <span class="material-symbols-outlined text-[14px]">sync_alt</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- Scenario 07: Model Failure & AI SOC Emergency Drift Response (Full span on 3-col) -->
                                <div class="md:col-span-2 lg:col-span-3 p-space-md rounded-lg bg-surface-container-lowest flex flex-col md:flex-row md:items-center justify-between gap-space-md relative overflow-hidden shadow-sm">
                                    <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-error"></div>
                                    <div class="flex items-start gap-space-md">
                                        <div class="w-10 h-10 rounded bg-error-container/20 flex items-center justify-center shrink-0">
                                            <span class="material-symbols-outlined text-error text-[24px]">crisis_alert</span>
                                        </div>
                                        <div class="flex flex-col">
                                            <div class="flex items-center gap-space-xs flex-wrap">
                                                <span class="font-label-mono-md text-label-mono-md text-error font-bold">SCENARIO // 07 (CAPSTONE)</span>
                                                <span class="px-1.5 py-0.2 rounded bg-error-container text-on-error-container font-label-mono-sm text-label-mono-sm font-bold">RESTRICTED DRIFT INCIDENT</span>
                                            </div>
                                            <h3 class="font-headline-sm text-headline-sm text-on-surface font-semibold">Model Failure & AI SOC Emergency Drift Response</h3>
                                            <span class="font-body-sm text-body-sm text-on-surface-variant">Simulated industrial distribution shift and automated fallback rollback protocol.</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-space-sm shrink-0">
                                        <div class="flex flex-col text-right font-label-mono-sm text-label-mono-sm">
                                            <span class="text-outline">PREREQUISITE</span>
                                            <span class="text-error font-bold">ALL PRIOR CLEARED</span>
                                        </div>
                                        <div class="bg-surface-container px-space-md py-space-xs rounded text-outline font-label-caps text-label-caps flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[16px]">lock_clock</span>
                                            <span>L3 Final Exam</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ==========================================
           TILE E: SYSTEM TELEMETRY & LIVE INCIDENT FEED (4 cols)
           ========================================== -->
                        <div class="xl:col-span-4 bg-surface-container rounded-xl p-space-lg flex flex-col justify-between shadow-sm relative h-full min-h-[580px]">
                            <div class="flex flex-col gap-space-xs">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-space-xs">
                                        <span class="w-2 h-2 rounded-full bg-tertiary animate-pulse"></span>
                                        <h2 class="font-headline-sm text-headline-sm text-on-surface font-semibold tracking-tight">Live Telemetry & Logs</h2>
                                    </div>
                                    <span class="font-label-mono-sm text-label-mono-sm text-outline">DC-01 // ALMATY</span>
                                </div>
                                <span class="font-label-mono-sm text-label-mono-sm text-on-surface-variant">Real-time compute cluster event broker</span>
                            </div>
                            <!-- Terminal-like Console Feed -->
                            <div class="bg-surface-container-lowest rounded-lg p-space-md my-space-md flex flex-col gap-space-sm flex-1 font-label-mono-sm text-label-mono-sm overflow-hidden">
                                <div class="flex flex-col gap-1 pb-space-xs border-b border-surface-container-high/40">
                                    <div class="flex items-center justify-between text-outline">
                                        <span>[14:02:44.118]</span>
                                        <span class="text-tertiary">INGESTION_OK</span>
                                    </div>
                                    <p class="text-on-surface font-normal">
                                        CUS-1001 batch telemetry ingestion finished (<span class="text-primary font-bold">28,400 rows</span>).
                                    </p>
                                </div>
                                <div class="flex flex-col gap-1 pb-space-xs border-b border-surface-container-high/40">
                                    <div class="flex items-center justify-between text-outline">
                                        <span>[14:01:12.890]</span>
                                        <span class="text-secondary">GPU_SCHED</span>
                                    </div>
                                    <p class="text-on-surface font-normal">
                                        GPU Cluster 03: V100 node allocated for training run <span class="text-secondary font-bold">#402</span>.
                                    </p>
                                </div>
                                <div class="flex flex-col gap-1 pb-space-xs border-b border-surface-container-high/40">
                                    <div class="flex items-center justify-between text-outline">
                                        <span>[13:58:30.012]</span>
                                        <span class="text-primary">EVAL_CHECK</span>
                                    </div>
                                    <p class="text-on-surface font-normal">
                                        Threshold check: F1-Score baseline <span class="text-primary font-bold">0.76</span> (Target ≥ 0.80).
                                    </p>
                                </div>
                                <div class="flex flex-col gap-1 pb-space-xs border-b border-surface-container-high/40">
                                    <div class="flex items-center justify-between text-outline">
                                        <span>[13:55:04.441]</span>
                                        <span class="text-outline">SOC_HEARTBEAT</span>
                                    </div>
                                    <p class="text-on-surface-variant font-normal">
                                        Model registry mirror synched with Tashkent backup node.
                                    </p>
                                </div>
                                <div class="flex flex-col gap-1">
                                    <div class="flex items-center justify-between text-outline">
                                        <span>[13:50:22.905]</span>
                                        <span class="text-tertiary">TOKEN_AUTH</span>
                                    </div>
                                    <p class="text-on-surface-variant font-normal">
                                        Session renewed for Eng. Gulkaba T. (IP 10.240.12.84).
                                    </p>
                                </div>
                                <div class="mt-auto flex items-center gap-2 pt-2 text-primary font-label-mono-sm text-label-mono-sm">
                                    <span class="animate-pulse">></span>
                                    <span class="opacity-75">Streaming raw telemetry sockets...</span>
                                </div>
                            </div>
                            <!-- Node & Diagnostics Quick Readout -->
                            <div class="grid grid-cols-2 gap-space-sm pt-space-xs">
                                <div class="p-space-xs bg-surface-container-low rounded flex flex-col">
                                    <span class="font-label-mono-sm text-label-mono-sm text-outline">COMPUTE VRAM</span>
                                    <span class="font-label-mono-md text-label-mono-md text-on-surface font-bold">14.2 / 32 GB</span>
                                </div>
                                <div class="p-space-xs bg-surface-container-low rounded flex flex-col">
                                    <span class="font-label-mono-sm text-label-mono-sm text-outline">INGEST LATENCY</span>
                                    <span class="font-label-mono-md text-label-mono-md text-tertiary font-bold">14.8 ms (NOM)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- LOWER TELEMETRY DOCK / QUICK METRIC LEDGER -->
                    <div class="bg-surface-container-lowest rounded-xl p-space-md flex flex-col md:flex-row items-center justify-between gap-space-md shadow-sm">
                        <div class="flex items-center gap-space-lg flex-wrap">
                            <div class="flex items-center gap-space-xs font-label-mono-sm text-label-mono-sm">
                                <span class="text-outline">ENGINE ARCH:</span>
                                <span class="text-on-surface font-bold">VOSTOK-AI-01-T</span>
                            </div>
                            <div class="flex items-center gap-space-xs font-label-mono-sm text-label-mono-sm">
                                <span class="text-outline">STATION IP:</span>
                                <span class="text-primary font-bold">10.240.12.84:8080</span>
                            </div>
                            <div class="flex items-center gap-space-xs font-label-mono-sm text-label-mono-sm">
                                <span class="text-outline">ACTIVE TICKET DEADLINE:</span>
                                <span class="text-tertiary font-bold">#AI-024 (18H REMAINING)</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-space-sm">
                            <span class="font-label-mono-sm text-label-mono-sm text-outline">SYSTEM READY FOR STAGE 8 VALIDATION</span>
                            <button class="bg-primary-container text-on-primary-container px-space-md py-1 rounded font-label-caps text-label-caps hover:bg-primary transition-colors font-bold">
                                Submit Model Artifacts
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