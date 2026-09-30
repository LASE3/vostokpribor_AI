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
    <title>Project Evaluation & Rubric View · SYS-AI Projects · VOSTOKPRIBOR</title>
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
                    <a class="px-space-sm py-0.5 rounded-full font-label-caps text-label-caps text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="ticket-detail-ai-024" href="TicketDetail.php">Ticket Detail #AI-024</a>
                    <a class="px-space-sm py-0.5 rounded-full font-label-caps text-label-caps text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="submissions" href="DeliverablesAndSubmissionPanel.php">Submissions</a>
                    <a aria-current="page" class="px-space-sm py-0.5 transition-colors bg-primary text-on-primary font-bold rounded-full shadow-sm" data-path="evaluation" href="EvaluationView.php">Evaluation</a>
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
                <div class="flex items-center gap-1 shrink-0 bg-primary-container px-space-xs py-0.5 rounded shadow-sm"><span class="w-4 h-4 rounded-full bg-on-primary-container text-primary-container font-label-mono-sm text-label-mono-sm flex items-center justify-center animate-pulse font-bold">7</span><span class="font-label-mono-sm text-label-mono-sm text-on-primary-container font-bold">7 Build</span></div><span class="text-outline text-label-mono-sm">—</span>
                <div class="flex items-center gap-1 shrink-0 bg-secondary-container px-space-xs py-0.5 rounded shadow-sm"><span class="w-4 h-4 rounded-full bg-on-secondary-container text-secondary font-label-mono-sm text-label-mono-sm flex items-center justify-center font-bold">8</span><span class="font-label-mono-sm text-label-mono-sm text-secondary font-bold">8 Eval</span></div><span class="text-outline text-label-mono-sm">—</span>
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
                            <a href="TicketDetail.php" class="hover:text-primary transition-colors">#AI-024</a>
                            <span>/</span>
                            <span class="text-secondary font-bold">STAGE 08: EVALUATION &amp; RUBRIC SCORECARD</span>
                        </div>
                        <div class="flex items-center gap-space-xs flex-wrap">
                            <button onclick="if(window.showToast) window.showToast('Generating official rubric scorecard PDF certificate...', 'info', 'EXPORT PDF')" class="px-space-md py-1.5 rounded-lg bg-surface-container-high hover:bg-surface-bright text-on-surface font-label-mono-sm text-label-mono-sm flex items-center gap-1.5 shadow-sm transition-all">
                                <span class="material-symbols-outlined text-[15px] text-secondary">picture_as_pdf</span>
                                Export Evaluation PDF
                            </button>
                            <a href="DeliverablesAndSubmissionPanel.php" class="px-space-md py-1.5 rounded-lg bg-secondary-container hover:bg-secondary text-on-secondary font-label-caps text-label-caps font-bold flex items-center gap-1.5 shadow-sm transition-all">
                                <span class="material-symbols-outlined text-[16px]">inventory_2</span>
                                View Deliverable Bundle
                            </a>
                            <a href="TicketDetail.php" class="px-space-md py-1.5 rounded-lg bg-primary hover:bg-primary-fixed-dim text-on-primary font-label-caps text-label-caps font-bold flex items-center gap-1.5 shadow-md transition-all">
                                <span class="material-symbols-outlined text-[16px]">receipt_long</span>
                                Return to Ticket #AI-024
                            </a>
                        </div>
                    </div>

                    <!-- HERO RUBRIC SCORECARD HEADER -->
                    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-surface-container via-surface-container-low to-surface-container-lowest p-space-lg lg:p-space-xl border border-secondary/20 shadow-xl">
                        <div class="absolute -right-16 -top-16 w-80 h-80 rounded-full bg-secondary/10 blur-3xl pointer-events-none"></div>
                        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-space-lg relative z-10">
                            <div class="flex flex-col gap-space-sm max-w-4xl">
                                <div class="flex items-center gap-space-sm flex-wrap">
                                    <span class="px-3 py-1 rounded font-label-mono-md text-label-mono-md bg-secondary text-on-secondary font-bold tracking-tight shadow">
                                        EVALUATION // RUN #04
                                    </span>
                                    <span class="px-2.5 py-1 rounded font-label-caps text-label-caps bg-primary-container text-on-primary-container font-bold shadow-sm">
                                        PROVISIONAL GRADE
                                    </span>
                                    <span class="px-2.5 py-1 rounded font-label-mono-sm text-label-mono-sm bg-surface-container-high text-primary border border-primary/20">
                                        STAGE 08 MODEL EVALUATION
                                    </span>
                                    <span class="px-2 py-0.5 rounded font-label-mono-sm text-label-mono-sm bg-surface-container text-outline">
                                        RUBRIC ISO/VP-9812-AI
                                    </span>
                                </div>
                                <h1 class="font-headline-lg text-headline-lg text-on-surface tracking-tight mt-1">
                                    Candidate Project Rubric Scorecard &amp; Gateway Audit
                                </h1>
                                <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">
                                    Comprehensive engineering evaluation for <span class="text-on-surface font-semibold">Eng. Gulkaba T. (Intern AI Engineer · Level 2)</span> on Ticket <span class="text-primary font-mono font-bold">#AI-024 (Customer Churn MVP)</span>. Scored across 5 core industrial AI pillars with weighted criteria calculation.
                                </p>
                            </div>
                            <!-- Live Score Badge & Status -->
                            <div class="flex flex-col sm:flex-row lg:flex-col gap-space-sm shrink-0 bg-surface-container-lowest/80 backdrop-blur-md p-space-md rounded-xl border border-secondary/30 min-w-[280px]">
                                <div class="flex items-center justify-between">
                                    <span class="font-label-mono-sm text-label-mono-sm text-outline">TOTAL WEIGHTED SCORE:</span>
                                    <span class="font-label-mono-sm text-label-mono-sm px-2 py-0.5 rounded bg-secondary/20 text-secondary font-bold">GRADE B+</span>
                                </div>
                                <div class="flex items-baseline justify-between">
                                    <span id="displayTotalScore" class="font-headline-lg text-headline-lg font-mono text-secondary font-bold">87.5</span>
                                    <span class="text-outline font-mono text-body-md font-normal">/ 100 PTS</span>
                                </div>
                                <div class="w-full bg-surface-container-high h-2.5 rounded-full overflow-hidden">
                                    <div id="displayProgressBar" class="bg-secondary h-full rounded-full transition-all duration-300" style="width: 87.5%;"></div>
                                </div>
                                <div class="flex items-center justify-between pt-1 border-t border-surface-container font-label-mono-sm text-label-mono-sm">
                                    <span class="text-outline">DECISION:</span>
                                    <span class="text-primary font-bold">REVISION PERMITTED (18h)</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 12-COLUMN EVALUATION GRID -->
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-lg items-start">
                        
                        <!-- LEFT COLUMN: 5-DIMENSION RUBRIC BREAKDOWN (8 cols) -->
                        <div class="lg:col-span-8 flex flex-col gap-space-lg">
                            
                            <!-- RUBRIC ITEM 1: PROBLEM FORMULATION & EDA -->
                            <div class="bg-surface-container rounded-xl p-space-lg shadow-md flex flex-col gap-space-md border border-outline-variant/30">
                                <div class="flex flex-wrap items-center justify-between gap-space-sm border-b border-surface-container-high pb-space-sm">
                                    <div class="flex items-center gap-space-sm">
                                        <div class="w-7 h-7 rounded-lg bg-tertiary/20 text-tertiary flex items-center justify-center font-bold text-label-caps">
                                            01
                                        </div>
                                        <div class="flex flex-col">
                                            <h3 class="font-headline-sm text-headline-sm text-on-surface font-semibold">
                                                Problem Formulation &amp; Exploratory Data Analysis (EDA)
                                            </h3>
                                            <span class="font-label-mono-sm text-label-mono-sm text-outline">WEIGHT: 20% · DATA INTEGRITY &amp; ANOMALY IDENTIFICATION</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="font-label-mono-lg text-label-mono-lg text-tertiary font-bold font-mono">19 / 20</span>
                                        <span class="px-2 py-0.5 rounded font-label-mono-sm text-label-mono-sm bg-tertiary/20 text-tertiary font-bold">EXEMPLARY (95%)</span>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-space-sm font-body-sm text-body-sm">
                                    <div class="p-space-sm rounded-lg bg-surface-container-low flex flex-col gap-1">
                                        <span class="font-label-mono-sm text-label-mono-sm text-outline">VERIFIED EVIDENCE</span>
                                        <span class="text-on-surface">Dataset <code class="text-secondary font-mono">DATA-TEL-9014</code> (14.2M records). Deadband sensor zero-values accurately separated from hardware offline states.</span>
                                    </div>
                                    <div class="p-space-sm rounded-lg bg-surface-container-low flex flex-col gap-1">
                                        <span class="font-label-mono-sm text-label-mono-sm text-outline">EVALUATOR NOTE</span>
                                        <span class="text-on-surface-variant">"Thorough outlier profiling with robust IQR thresholding. Clear target balance visualization across customer cohorts."</span>
                                    </div>
                                </div>
                            </div>

                            <!-- RUBRIC ITEM 2: FEATURE ENGINEERING -->
                            <div class="bg-surface-container rounded-xl p-space-lg shadow-md flex flex-col gap-space-md border border-outline-variant/30">
                                <div class="flex flex-wrap items-center justify-between gap-space-sm border-b border-surface-container-high pb-space-sm">
                                    <div class="flex items-center gap-space-sm">
                                        <div class="w-7 h-7 rounded-lg bg-tertiary/20 text-tertiary flex items-center justify-center font-bold text-label-caps">
                                            02
                                        </div>
                                        <div class="flex flex-col">
                                            <h3 class="font-headline-sm text-headline-sm text-on-surface font-semibold">
                                                Feature Engineering &amp; Preprocessing Pipeline
                                            </h3>
                                            <span class="font-label-mono-sm text-label-mono-sm text-outline">WEIGHT: 25% · TEMPORAL AGGREGATIONS &amp; DOMAIN ENCODING</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="font-label-mono-lg text-label-mono-lg text-tertiary font-bold font-mono">24 / 25</span>
                                        <span class="px-2 py-0.5 rounded font-label-mono-sm text-label-mono-sm bg-tertiary/20 text-tertiary font-bold">SUPERIOR (96%)</span>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-space-sm font-body-sm text-body-sm">
                                    <div class="p-space-sm rounded-lg bg-surface-container-low flex flex-col gap-1">
                                        <span class="font-label-mono-sm text-label-mono-sm text-outline">VERIFIED EVIDENCE</span>
                                        <span class="text-on-surface">42 engineered features in <code class="text-secondary font-mono">features_manifest.json</code>. Robust exponential decay applied to optical calibration jitter.</span>
                                    </div>
                                    <div class="p-space-sm rounded-lg bg-surface-container-low flex flex-col gap-1">
                                        <span class="font-label-mono-sm text-label-mono-sm text-outline">EVALUATOR NOTE</span>
                                        <span class="text-on-surface-variant">"Excellent application of physical domain knowledge to optical sensor degradation signals. No data leakage detected across folds."</span>
                                    </div>
                                </div>
                            </div>

                            <!-- RUBRIC ITEM 3: MODEL ARCHITECTURE & TUNING -->
                            <div class="bg-surface-container rounded-xl p-space-lg shadow-md flex flex-col gap-space-md border border-outline-variant/30">
                                <div class="flex flex-wrap items-center justify-between gap-space-sm border-b border-surface-container-high pb-space-sm">
                                    <div class="flex items-center gap-space-sm">
                                        <div class="w-7 h-7 rounded-lg bg-primary/20 text-primary flex items-center justify-center font-bold text-label-caps">
                                            03
                                        </div>
                                        <div class="flex flex-col">
                                            <h3 class="font-headline-sm text-headline-sm text-on-surface font-semibold">
                                                Model Architecture, Stratification &amp; Cross-Validation
                                            </h3>
                                            <span class="font-label-mono-sm text-label-mono-sm text-outline">WEIGHT: 30% · ALGORITHM SELECTION, HYPERPARAMETERS &amp; GENERALIZATION</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="font-label-mono-lg text-label-mono-lg text-primary font-bold font-mono">25 / 30</span>
                                        <span class="px-2 py-0.5 rounded font-label-mono-sm text-label-mono-sm bg-primary/20 text-primary font-bold">PROFICIENT (83.3%)</span>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-space-sm font-body-sm text-body-sm">
                                    <div class="p-space-sm rounded-lg bg-surface-container-low flex flex-col gap-1">
                                        <span class="font-label-mono-sm text-label-mono-sm text-outline">VERIFIED EVIDENCE</span>
                                        <span class="text-on-surface">5-fold stratified K-Fold across 12-month temporal splits. XGBoost candidate model achieved ROC-AUC of 0.842.</span>
                                    </div>
                                    <div class="p-space-sm rounded-lg bg-surface-container-low flex flex-col gap-1">
                                        <span class="font-label-mono-sm text-label-mono-sm text-outline">EVALUATOR NOTE</span>
                                        <span class="text-on-surface-variant">"Solid search space explored. However, slight overfit visible on train vs test (0.91 vs 0.781 F1). Needs L2 regularization penalty (<code class="text-primary font-mono">reg_lambda=2.0</code>)."</span>
                                    </div>
                                </div>
                            </div>

                            <!-- RUBRIC ITEM 4: METRIC GATE & BUSINESS ALIGNMENT (BREACH FOCUS) -->
                            <div class="bg-surface-container rounded-xl p-space-lg shadow-md flex flex-col gap-space-md border border-error/40 bg-error-container/5">
                                <div class="flex flex-wrap items-center justify-between gap-space-sm border-b border-surface-container-high pb-space-sm">
                                    <div class="flex items-center gap-space-sm">
                                        <div class="w-7 h-7 rounded-lg bg-error-container text-on-error-container flex items-center justify-center font-bold text-label-caps">
                                            04
                                        </div>
                                        <div class="flex flex-col">
                                            <h3 class="font-headline-sm text-headline-sm text-error font-semibold">
                                                Production Metric Threshold Gate (F1 &ge; 0.800)
                                            </h3>
                                            <span class="font-label-mono-sm text-label-mono-sm text-outline">WEIGHT: 15% · STRICT INDUSTRIAL PRODUCTION TOLERANCE</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="font-label-mono-lg text-label-mono-lg text-error font-bold font-mono">10 / 15</span>
                                        <span class="px-2 py-0.5 rounded font-label-mono-sm text-label-mono-sm bg-error-container text-on-error-container font-bold animate-pulse">BREACH (66.7%)</span>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-space-sm font-body-sm text-body-sm">
                                    <div class="p-space-sm rounded-lg bg-surface-container-low flex flex-col gap-1">
                                        <span class="font-label-mono-sm text-label-mono-sm text-outline">VERIFIED EVIDENCE</span>
                                        <span class="text-on-surface">Achieved F1 = 0.781 against required target of &ge; 0.800. Margin gap is -0.019 (within 2.5% recovery window).</span>
                                    </div>
                                    <div class="p-space-sm rounded-lg bg-surface-container-low flex flex-col gap-1">
                                        <span class="font-label-mono-sm text-label-mono-sm text-outline">REMEDIATION DIRECTIVE</span>
                                        <span class="text-on-surface-variant">Candidate does not yet qualify for Stage 10 deployment. Resubmission allowed within 18h SLA window without penalty.</span>
                                    </div>
                                </div>
                            </div>

                            <!-- RUBRIC ITEM 5: REPRODUCIBILITY & MODEL CARD -->
                            <div class="bg-surface-container rounded-xl p-space-lg shadow-md flex flex-col gap-space-md border border-outline-variant/30">
                                <div class="flex flex-wrap items-center justify-between gap-space-sm border-b border-surface-container-high pb-space-sm">
                                    <div class="flex items-center gap-space-sm">
                                        <div class="w-7 h-7 rounded-lg bg-tertiary/20 text-tertiary flex items-center justify-center font-bold text-label-caps">
                                            05
                                        </div>
                                        <div class="flex flex-col">
                                            <h3 class="font-headline-sm text-headline-sm text-on-surface font-semibold">
                                                Documentation, Reproducibility &amp; ISO/VP-9812-AI Model Card
                                            </h3>
                                            <span class="font-label-mono-sm text-label-mono-sm text-outline">WEIGHT: 10% · SPECIFICATION COMPLIANCE &amp; ENVIRONMENT LOCKS</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="font-label-mono-lg text-label-mono-lg text-tertiary font-bold font-mono">9.5 / 10</span>
                                        <span class="px-2 py-0.5 rounded font-label-mono-sm text-label-mono-sm bg-tertiary/20 text-tertiary font-bold">EXCELLENT (95%)</span>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-space-sm font-body-sm text-body-sm">
                                    <div class="p-space-sm rounded-lg bg-surface-container-low flex flex-col gap-1">
                                        <span class="font-label-mono-sm text-label-mono-sm text-outline">VERIFIED EVIDENCE</span>
                                        <span class="text-on-surface">Deterministic seed lock (<code class="text-on-surface font-mono">seed=1968</code>), clean Git history, environment lockfile, and comprehensive data dictionary.</span>
                                    </div>
                                    <div class="p-space-sm rounded-lg bg-surface-container-low flex flex-col gap-1">
                                        <span class="font-label-mono-sm text-label-mono-sm text-outline">EVALUATOR NOTE</span>
                                        <span class="text-on-surface-variant">"Highly professional documentation. Model card sections are fully compliant with ISO/VP-9812-AI standards."</span>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- RIGHT COLUMN: INSTRUCTOR GRADING CONTROLS & SUMMARY (4 cols) -->
                        <div class="lg:col-span-4 flex flex-col gap-space-lg">
                            
                            <!-- 1. INSTRUCTOR GRADING ACTION PANEL -->
                            <div class="bg-surface-container rounded-xl p-space-lg shadow-md flex flex-col gap-space-md border border-primary/20">
                                <div class="flex items-center justify-between border-b border-surface-container-high pb-space-sm">
                                    <span class="font-label-mono-sm text-label-mono-sm text-primary uppercase tracking-wider font-bold">Instructor Grading Control</span>
                                    <span class="material-symbols-outlined text-primary text-[18px]">verified</span>
                                </div>
                                <div class="flex flex-col gap-space-sm font-body-sm text-body-sm">
                                    <label class="flex flex-col gap-1">
                                        <span class="font-label-mono-sm text-label-mono-sm text-outline">EVALUATOR IN CHARGE</span>
                                        <input type="text" readonly value="Dr. A. Kasymov (Chief AI Mentor)" class="w-full bg-surface-container-lowest text-on-surface p-2 rounded border border-outline-variant/40 font-mono text-label-mono-sm">
                                    </label>
                                    <label class="flex flex-col gap-1">
                                        <span class="font-label-mono-sm text-label-mono-sm text-outline">DECISION STATUS</span>
                                        <select class="w-full bg-surface-container-lowest text-on-surface p-2 rounded border border-outline-variant/40 font-label-caps text-label-caps focus:outline-none">
                                            <option value="revision" selected>Revision Required (Resubmission Window 18h)</option>
                                            <option value="conditional">Conditional Pass (Waive 0.019 Gate Tolerance)</option>
                                            <option value="approved">Approved (Promote to Stage 10 Deployment)</option>
                                            <option value="rejected">Rejected (Cohort Recycle)</option>
                                        </select>
                                    </label>
                                    <label class="flex flex-col gap-1">
                                        <span class="font-label-mono-sm text-label-mono-sm text-outline">QUALITATIVE FEEDBACK DIRECTIVE</span>
                                        <textarea class="w-full bg-surface-container-lowest text-on-surface p-2 rounded border border-outline-variant/40 font-body-sm text-body-sm focus:outline-none" rows="4">Eng. Gulkaba: Excellent feature engineering and disciplined execution. To close the 0.019 gap on F1, apply L2 regularization (reg_lambda=2.0) and drop the collinear sensor_temp_drift_7d feature. Upload Run #05 before shift end.</textarea>
                                    </label>
                                    <!-- SUBMIT BUTTON WIRED TO JS/MAIN.JS -->
                                    <button id="submitGradeBtn" class="w-full py-2.5 px-space-md rounded-lg bg-primary hover:bg-primary-fixed-dim text-on-primary font-label-caps text-label-caps font-bold transition-all shadow-md flex items-center justify-center gap-2 mt-space-xs">
                                        <span class="material-symbols-outlined text-[18px]">publish</span>
                                        Record &amp; Sync Rubric Grade
                                    </button>
                                </div>
                            </div>

                            <!-- 2. SCORING PROGRESSION HISTORY -->
                            <div class="bg-surface-container rounded-xl p-space-lg shadow-md flex flex-col gap-space-md">
                                <div class="flex items-center justify-between border-b border-surface-container-high pb-space-sm">
                                    <span class="font-label-mono-sm text-label-mono-sm text-outline uppercase tracking-wider">Candidate Run History</span>
                                    <span class="font-label-mono-sm text-label-mono-sm text-secondary">COHORT 1968-Q3</span>
                                </div>
                                <div class="flex flex-col gap-space-sm">
                                    <div class="flex items-center justify-between p-space-xs rounded bg-surface-container-low font-body-sm text-body-sm">
                                        <div class="flex flex-col">
                                            <span class="font-label-mono-sm text-label-mono-sm text-outline">RUN #01 · EDA Baseline</span>
                                            <span class="font-mono text-outline">Logistic Regression</span>
                                        </div>
                                        <span class="font-mono text-outline">64.0%</span>
                                    </div>
                                    <div class="flex items-center justify-between p-space-xs rounded bg-surface-container-low font-body-sm text-body-sm">
                                        <div class="flex flex-col">
                                            <span class="font-label-mono-sm text-label-mono-sm text-outline">RUN #02 · Feature Prep</span>
                                            <span class="font-mono text-outline">Random Forest 100 Trees</span>
                                        </div>
                                        <span class="font-mono text-outline">74.5%</span>
                                    </div>
                                    <div class="flex items-center justify-between p-space-xs rounded bg-surface-container-low font-body-sm text-body-sm">
                                        <div class="flex flex-col">
                                            <span class="font-label-mono-sm text-label-mono-sm text-outline">RUN #03 · XGBoost Base</span>
                                            <span class="font-mono text-outline">F1: 0.762</span>
                                        </div>
                                        <span class="font-mono text-outline">81.0%</span>
                                    </div>
                                    <div class="flex items-center justify-between p-space-xs rounded bg-secondary-container/20 border border-secondary/30 font-body-sm text-body-sm">
                                        <div class="flex flex-col">
                                            <span class="font-label-mono-sm text-label-mono-sm text-secondary font-bold">RUN #04 · Current Candidate</span>
                                            <span class="font-mono text-on-surface">F1: 0.781 · Latency: 18ms</span>
                                        </div>
                                        <span class="font-mono text-secondary font-bold">87.5% (B+)</span>
                                    </div>
                                </div>
                            </div>

                            <!-- 3. QUICK NAVIGATION -->
                            <div class="bg-surface-container rounded-xl p-space-lg shadow-md flex flex-col gap-space-xs">
                                <a href="InstructorDashboard.php" class="p-space-sm rounded-lg bg-surface-container-low hover:bg-surface-container-high transition-colors flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-secondary text-[18px]">school</span>
                                        <span class="font-label-caps text-label-caps text-on-surface">Instructor Portal Roster</span>
                                    </div>
                                    <span class="material-symbols-outlined text-outline text-[16px]">arrow_forward</span>
                                </a>
                                <a href="DeliverablesAndSubmissionPanel.php" class="p-space-sm rounded-lg bg-surface-container-low hover:bg-surface-container-high transition-colors flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-tertiary text-[18px]">cloud_upload</span>
                                        <span class="font-label-caps text-label-caps text-on-surface">Upload Resubmission</span>
                                    </div>
                                    <span class="material-symbols-outlined text-outline text-[16px]">arrow_forward</span>
                                </a>
                                <a href="../index.php" class="p-space-sm rounded-lg bg-surface-container-low hover:bg-surface-container-high transition-colors flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-primary text-[18px]">grid_view</span>
                                        <span class="font-label-caps text-label-caps text-on-surface">Return to Core Portal</span>
                                    </div>
                                    <span class="material-symbols-outlined text-outline text-[16px]">arrow_forward</span>
                                </a>
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