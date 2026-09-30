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
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@100..900&amp;family=Inter:wght@100..900&amp;family=Space+Mono:wght@100..900&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
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
                        <div class="flex items-center gap-space-sm"><span class="w-1.5 h-1.5 rounded-full bg-outline-variant"></span><span class="font-label-caps text-label-caps">SYS-AI-04 Registry &amp; Deploy</span></div><span class="font-label-mono-sm text-label-mono-sm text-on-surface-variant">v2.4</span>
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
                <nav class="flex items-center gap-space-xs" data-active-classes="bg-primary text-on-primary font-bold rounded-full"><a class="px-space-sm py-0.5 rounded-full font-label-caps text-label-caps text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="dashboard" href="Dashboard.php">Dashboard</a><a class="px-space-sm py-0.5 rounded-full font-label-caps text-label-caps text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="ticket-board" href="TicketBoard.php">Ticket Board</a><a class="px-space-sm py-0.5 rounded-full font-label-caps text-label-caps text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="ticket-detail-ai-024" href="TicketDetail.php">Ticket Detail #AI-024</a><a class="px-space-sm py-0.5 rounded-full font-label-caps text-label-caps text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="submissions" href="DeliverablesAndSubmissionPanel.php">Submissions</a><a class="px-space-sm py-0.5 rounded-full font-label-caps text-label-caps text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="evaluation" href="EvaluationView.php">Evaluation</a><a class="px-space-sm py-0.5 rounded-full font-label-caps text-label-caps text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="instructor-portal" href="InstructorDashboard.php">Instructor Portal</a></nav>
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
                <!-- Interactive & Notification Script -->
                
                <!-- Canvas dot-grid backdrop layer -->
                <div class="p-space-lg lg:p-space-xl flex flex-col gap-space-lg">
                    <!-- SUB-NAV / BREADCRUMBS & GATE HEADLINE -->
                    <div class="flex flex-col gap-space-sm">
                        <div class="flex flex-wrap items-center justify-between gap-space-md">
                            <!-- Breadcrumb String -->
                            <div class="flex items-center gap-2 font-label-mono-sm text-label-mono-sm text-outline uppercase tracking-wider">
                                <span class="text-on-surface-variant">SYS-AI-01 PROJECTS</span>
                                <span>/</span>
                                <span class="text-on-surface-variant">TICKET BOARD</span>
                                <span>/</span>
                                <span class="text-primary font-bold">#AI-024</span>
                                <span>/</span>
                                <span class="text-error font-bold">STAGE 08 DELIVERABLES &amp; SUBMISSION GATE</span>
                            </div>
                            <!-- Right Side: Real-time Countdown Pill -->
                            <div class="flex items-center gap-space-sm bg-surface-container-low px-space-md py-1.5 rounded-lg shadow-sm">
                                <span class="material-symbols-outlined text-[16px] text-primary animate-pulse">timer</span>
                                <div class="flex flex-col">
                                    <span class="font-label-mono-sm text-label-mono-sm text-outline uppercase">RESUBMISSION WINDOW</span>
                                    <span class="font-label-mono-md text-label-mono-md text-primary font-bold">18h 42m 14s <span class="text-outline font-normal">REMAINING</span></span>
                                </div>
                                <span class="text-error font-label-mono-sm text-label-mono-sm px-1.5 py-0.5 rounded bg-error-container/30">PENALTY RISK</span>
                            </div>
                        </div>
                        <!-- Main Section Header -->
                        <div class="flex flex-wrap items-end justify-between gap-space-md pt-space-xs">
                            <div class="flex flex-col gap-1">
                                <div class="flex items-center gap-3">
                                    <h1 class="font-headline-lg text-headline-lg text-on-surface tracking-tight">Deliverable Verification &amp; Gateway Promotion Gate</h1>
                                    <span class="px-2.5 py-1 rounded bg-error-container text-on-error-container font-label-mono-sm text-label-mono-sm font-bold flex items-center gap-1.5">
                                        <span class="w-2 h-2 rounded-full bg-error animate-ping"></span>
                                        GATE STATUS: REJECTED // THRESHOLD BREACH
                                    </span>
                                    <span class="px-2 py-1 rounded bg-surface-container-high text-outline font-label-mono-sm text-label-mono-sm">
                                        RUN #04 LOCKED
                                    </span>
                                </div>
                                <p class="font-body-md text-body-md text-on-surface-variant max-w-4xl">
                                    Automated verification gateway for candidate ticket <span class="text-on-surface font-semibold">#AI-024 (Industrial Customer Churn MVP)</span>. Model weights, scoring endpoint, and telemetry telemetry cards evaluated against ISO/VP-9812-AI industrial compliance criteria.
                                </p>
                            </div>
                            <!-- Quick Telemetry Stamp -->
                            <div class="flex items-center gap-4 bg-surface-container px-space-md py-2 rounded">
                                <div class="flex flex-col">
                                    <span class="font-label-mono-sm text-label-mono-sm text-outline">ENGINEER</span>
                                    <span class="font-label-caps text-label-caps text-on-surface">Gulkaba T. [L2]</span>
                                </div>
                                <div class="w-px h-6 bg-surface-container-high"></div>
                                <div class="flex flex-col">
                                    <span class="font-label-mono-sm text-label-mono-sm text-outline">INSPECTOR</span>
                                    <span class="font-label-caps text-label-caps text-tertiary">SYS-AI AUTO-VAL v4.2</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- 1. CRITICAL REJECTION / VALIDATION BANNER -->
                    <div class="relative overflow-hidden rounded-xl bg-gradient-to-r from-error-container/40 via-surface-container-low to-surface-container-lowest p-space-lg shadow-xl">
                        <div class="absolute -right-12 -top-12 w-48 h-48 rounded-full bg-error/10 blur-3xl pointer-events-none"></div>
                        <div class="flex flex-col md:flex-row gap-space-lg items-start justify-between">
                            <div class="flex gap-space-md items-start">
                                <div class="w-12 h-12 rounded-lg bg-error-container text-error flex items-center justify-center shrink-0 shadow-md">
                                    <span class="material-symbols-outlined text-[30px]" style="font-variation-settings: 'FILL' 1;">gpp_bad</span>
                                </div>
                                <div class="flex flex-col gap-1.5 max-w-4xl">
                                    <div class="flex items-center gap-space-sm flex-wrap">
                                        <span class="font-label-mono-lg text-label-mono-lg text-error tracking-wider uppercase font-bold">
                                            AUTOMATED VERIFICATION PROTOCOL // GATE 08 REJECTED
                                        </span>
                                        <span class="px-2 py-0.5 rounded bg-error/20 text-error font-label-mono-sm text-label-mono-sm font-bold">
                                            CRITICAL NON-CONFORMANCE
                                        </span>
                                    </div>
                                    <p class="font-body-md text-body-md text-on-error-container leading-relaxed">
                                        <span class="font-semibold text-error">VALIDATION REJECTED:</span> Model performance below required contractual business threshold (Target: <span class="font-label-mono-md text-label-mono-md font-bold text-on-surface">F1 &gt;= 0.800</span> | Evaluated Held-out Test Set F1: <span class="font-label-mono-md text-label-mono-md font-bold text-error">0.784</span>, Delta: <span class="font-label-mono-md text-label-mono-md font-bold text-error">-0.016</span>). Automatic promotion to Phase IV (Stage 10 Containerized Deployment) is permanently restricted.
                                    </p>
                                    <div class="mt-space-xs p-space-sm bg-surface-container-lowest/80 rounded flex items-start gap-space-sm">
                                        <span class="material-symbols-outlined text-[16px] text-primary shrink-0 mt-0.5">policy</span>
                                        <p class="font-label-mono-sm text-label-mono-sm text-outline-variant text-on-surface-variant leading-normal">
                                            <span class="text-primary font-bold">POLICY STRICT ENFORCEMENT:</span> System rules prohibit automated error resolution, feature importances hints, or hyperparameter direction guidance. Candidate must independently analyze validation logs, review optical drift variance in SYS-AI-02 Data Center, and execute new model run.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!-- Banner Right Action Box -->
                            <div class="flex flex-col gap-2 shrink-0 w-full md:w-auto">
                                <button class="flex items-center justify-center gap-2 px-space-md py-2.5 rounded bg-surface-container-high hover:bg-surface-container-highest text-on-surface font-label-caps text-label-caps transition-all" onclick="document.getElementById('matrix-section').scrollIntoView({ behavior: 'smooth' });">
                                    <span class="material-symbols-outlined text-[16px]">troubleshoot</span>
                                    Inspect Test Metric Breakdown
                                </button>
                                <a class="flex items-center justify-center gap-2 px-space-md py-2.5 rounded bg-surface-container text-on-surface-variant hover:text-on-surface font-label-caps text-label-caps transition-colors" href="#">
                                    <span class="material-symbols-outlined text-[16px]">history_edu</span>
                                    Audit Run #04 Execution Logs
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- 2. PRIMARY DELIVERABLES VERIFICATION CARDS -->
                    <div class="flex flex-col gap-space-sm">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="font-label-mono-sm text-label-mono-sm text-primary uppercase font-bold tracking-widest">// DELIVERABLES VALIDATION REPOSITORY</span>
                                <span class="text-outline text-label-mono-sm">•</span>
                                <span class="font-label-mono-sm text-label-mono-sm text-outline">3 REQUIRED ARTIFACTS SUBMITTED</span>
                            </div>
                            <span class="font-label-mono-sm text-label-mono-sm text-on-surface-variant">GATE PROTOCOL ISO/VP-9812</span>
                        </div>
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-space-md">
                            <!-- Deliverable A: Trained Model Artifact (NON-COMPLIANT) -->
                            <div class="flex flex-col justify-between p-space-lg bg-surface-container rounded-xl relative shadow-md">
                                <div class="absolute top-0 right-0 w-2 h-full bg-error rounded-r-xl"></div>
                                <div>
                                    <div class="flex items-start justify-between gap-space-sm mb-space-md">
                                        <div class="w-10 h-10 rounded bg-error-container/30 text-error flex items-center justify-center">
                                            <span class="material-symbols-outlined text-[24px]">model_training</span>
                                        </div>
                                        <span class="px-2 py-0.5 rounded bg-error-container text-on-error-container font-label-mono-sm text-label-mono-sm font-bold flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[12px]">cancel</span>
                                            NON-COMPLIANT (F1 LOW)
                                        </span>
                                    </div>
                                    <div class="flex flex-col gap-1">
                                        <span class="font-label-mono-sm text-label-mono-sm text-outline">ARTIFACT A // WEIGHTS &amp; SERIALIZATION</span>
                                        <h3 class="font-headline-sm text-headline-sm text-on-surface font-semibold truncate">churn_xgb_model_v1.4.tar.gz</h3>
                                        <p class="font-label-mono-sm text-label-mono-sm text-primary flex items-center gap-1 mt-0.5">
                                            <span class="material-symbols-outlined text-[14px]">link</span>
                                            pkg://churn-xgb:1.4-bayes
                                        </p>
                                    </div>
                                    <div class="mt-space-md space-y-2 pt-space-sm bg-surface-container-lowest/60 p-space-sm rounded">
                                        <div class="flex justify-between items-center text-body-sm font-body-sm">
                                            <span class="text-outline">Architecture:</span>
                                            <span class="text-on-surface font-label-mono-md text-label-mono-md">XGBoost (Depth 8, Est 450)</span>
                                        </div>
                                        <div class="flex justify-between items-center text-body-sm font-body-sm">
                                            <span class="text-outline">Artifact Size:</span>
                                            <span class="text-on-surface font-label-mono-md text-label-mono-md">142.6 MB (ONNX format)</span>
                                        </div>
                                        <div class="flex justify-between items-center text-body-sm font-body-sm">
                                            <span class="text-outline">Batch Latency:</span>
                                            <span class="text-tertiary font-label-mono-md text-label-mono-md">38.4ms (SLA &lt; 50ms PASS)</span>
                                        </div>
                                        <div class="flex justify-between items-center text-body-sm font-body-sm">
                                            <span class="text-outline">SHA-256:</span>
                                            <span class="text-outline font-label-mono-sm text-label-mono-sm truncate max-w-[130px]" title="9f8ab2130e9d4812f8319c58e7223018247ca8f32c1">9f8a...32c1</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-space-lg flex items-center gap-space-xs pt-space-sm">
                                    <button class="flex-1 px-space-sm py-2 rounded bg-surface-container-high hover:bg-surface-container-highest text-on-surface font-label-caps text-label-caps flex items-center justify-center gap-1 transition-colors" onclick="toggleModal('modal-weights')">
                                        <span class="material-symbols-outlined text-[14px]">fact_check</span>
                                        Manifest
                                    </button>
                                    <button class="flex-1 px-space-sm py-2 rounded bg-primary-container text-on-primary-container font-label-caps text-label-caps flex items-center justify-center gap-1 hover:brightness-110 transition-all">
                                        <span class="material-symbols-outlined text-[14px]">upgrade</span>
                                        Replace Artifact
                                    </button>
                                </div>
                            </div>
                            <!-- Deliverable B: Deployed FastAPI Endpoint (VERIFIED NOMINAL) -->
                            <div class="flex flex-col justify-between p-space-lg bg-surface-container rounded-xl relative shadow-md">
                                <div class="absolute top-0 right-0 w-2 h-full bg-tertiary rounded-r-xl"></div>
                                <div>
                                    <div class="flex items-start justify-between gap-space-sm mb-space-md">
                                        <div class="w-10 h-10 rounded bg-tertiary/20 text-tertiary flex items-center justify-center">
                                            <span class="material-symbols-outlined text-[24px]">terminal</span>
                                        </div>
                                        <span class="px-2 py-0.5 rounded bg-tertiary/20 text-tertiary font-label-mono-sm text-label-mono-sm font-bold flex items-center gap-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-tertiary animate-pulse"></span>
                                            VERIFIED (HTTP 200)
                                        </span>
                                    </div>
                                    <div class="flex flex-col gap-1">
                                        <span class="font-label-mono-sm text-label-mono-sm text-outline">ARTIFACT B // INFERENCE SCORING API</span>
                                        <h3 class="font-headline-sm text-headline-sm text-on-surface font-semibold truncate">FastAPI Edge Container Node</h3>
                                        <p class="font-label-mono-sm text-label-mono-sm text-on-surface-variant flex items-center gap-1 mt-0.5 truncate">
                                            <span class="material-symbols-outlined text-[14px] text-tertiary">dns</span>
                                            https://node-402.sys03.almaty.internal:8443
                                        </p>
                                    </div>
                                    <div class="mt-space-md space-y-2 pt-space-sm bg-surface-container-lowest/60 p-space-sm rounded">
                                        <div class="flex justify-between items-center text-body-sm font-body-sm">
                                            <span class="text-outline">Contractual Schema:</span>
                                            <span class="text-tertiary font-label-mono-md text-label-mono-md">Pydantic v2 (Strict) PASS</span>
                                        </div>
                                        <div class="flex justify-between items-center text-body-sm font-body-sm">
                                            <span class="text-outline">Load Stress Test:</span>
                                            <span class="text-on-surface font-label-mono-md text-label-mono-md">500 RPS Nominal / 0% 5xx</span>
                                        </div>
                                        <div class="flex justify-between items-center text-body-sm font-body-sm">
                                            <span class="text-outline">Avg Edge Latency:</span>
                                            <span class="text-tertiary font-label-mono-md text-label-mono-md">19.2ms / TLS 1.3 mTLS</span>
                                        </div>
                                        <div class="flex justify-between items-center text-body-sm font-body-sm">
                                            <span class="text-outline">Container State:</span>
                                            <span class="text-on-surface font-label-mono-sm text-label-mono-sm">gVisor Isolated (Rootless)</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-space-lg flex items-center gap-space-xs pt-space-sm">
                                    <button class="flex-1 px-space-sm py-2 rounded bg-surface-container-high hover:bg-surface-container-highest text-on-surface font-label-caps text-label-caps flex items-center justify-center gap-1 transition-colors" id="ping-indicator" onclick="triggerEndpointPing()">
                                        <span class="material-symbols-outlined text-[14px]">cell_tower</span>
                                        Probe Endpoint
                                    </button>
                                    <button class="flex-1 px-space-sm py-2 rounded bg-surface-bright text-on-surface font-label-caps text-label-caps flex items-center justify-center gap-1 hover:brightness-110 transition-all" onclick="toggleModal('modal-swagger')">
                                        <span class="material-symbols-outlined text-[14px]">menu_book</span>
                                        OpenAPI Docs
                                    </button>
                                </div>
                            </div>
                            <!-- Deliverable C: Industrial Model Card & Audit Report (ACCEPTED // PENDING CODE CLARITY) -->
                            <div class="flex flex-col justify-between p-space-lg bg-surface-container rounded-xl relative shadow-md">
                                <div class="absolute top-0 right-0 w-2 h-full bg-secondary rounded-r-xl"></div>
                                <div>
                                    <div class="flex items-start justify-between gap-space-sm mb-space-md">
                                        <div class="w-10 h-10 rounded bg-secondary/20 text-secondary flex items-center justify-center">
                                            <span class="material-symbols-outlined text-[24px]">description</span>
                                        </div>
                                        <span class="px-2 py-0.5 rounded bg-secondary-container text-on-secondary-container font-label-mono-sm text-label-mono-sm font-bold flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[12px]">check_circle</span>
                                            DOCS ACCEPTED (REV 1.4)
                                        </span>
                                    </div>
                                    <div class="flex flex-col gap-1">
                                        <span class="font-label-mono-sm text-label-mono-sm text-outline">ARTIFACT C // AUDIT &amp; MODEL CARD</span>
                                        <h3 class="font-headline-sm text-headline-sm text-on-surface font-semibold truncate">SYS-AI-024_TECHNICAL_REPORT_REV1.4.pdf</h3>
                                        <p class="font-label-mono-sm text-label-mono-sm text-outline flex items-center gap-1 mt-0.5">
                                            <span class="material-symbols-outlined text-[14px]">history</span>
                                            Compiled: 2024-03-29 09:14 UTC
                                        </p>
                                    </div>
                                    <div class="mt-space-md space-y-2 pt-space-sm bg-surface-container-lowest/60 p-space-sm rounded">
                                        <div class="flex justify-between items-center text-body-sm font-body-sm">
                                            <span class="text-outline">Standard Volume:</span>
                                            <span class="text-on-surface font-label-mono-md text-label-mono-md">18 Pages Formal Modernist</span>
                                        </div>
                                        <div class="flex justify-between items-center text-body-sm font-body-sm">
                                            <span class="text-outline">Optical Drift Disclosures:</span>
                                            <span class="text-tertiary font-label-mono-md text-label-mono-md">Section 4.2 Complete</span>
                                        </div>
                                        <div class="flex justify-between items-center text-body-sm font-body-sm">
                                            <span class="text-outline">Data Leakage Check:</span>
                                            <span class="text-tertiary font-label-mono-md text-label-mono-md">0.00% Zero Leakage Cert</span>
                                        </div>
                                        <div class="flex justify-between items-center text-body-sm font-body-sm">
                                            <span class="text-outline">Trainee Signoff:</span>
                                            <span class="text-on-surface font-label-mono-sm text-label-mono-sm">Signed (Gulkaba T. #884A)</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-space-lg flex items-center gap-space-xs pt-space-sm">
                                    <button class="flex-1 px-space-sm py-2 rounded bg-surface-container-high hover:bg-surface-container-highest text-on-surface font-label-caps text-label-caps flex items-center justify-center gap-1 transition-colors" onclick="toggleModal('modal-pdf')">
                                        <span class="material-symbols-outlined text-[14px]">visibility</span>
                                        View PDF
                                    </button>
                                    <button class="flex-1 px-space-sm py-2 rounded bg-surface-bright text-on-surface font-label-caps text-label-caps flex items-center justify-center gap-1 hover:brightness-110 transition-all">
                                        <span class="material-symbols-outlined text-[14px]">upload_file</span>
                                        Re-upload PDF
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- 3. EVALUATION MATRIX BENCHMARK TABLE & CHECKLIST (2-Column Bento Layout) -->
                    <div class="grid grid-cols-1 xl:grid-cols-12 gap-space-lg" id="matrix-section">
                        <!-- LEFT BENTO: THE EXACT NUMBERS (Metric comparison table) - 8 cols -->
                        <div class="xl:col-span-8 flex flex-col gap-space-md p-space-lg bg-surface-container-low rounded-xl shadow-lg">
                            <div class="flex flex-wrap items-center justify-between gap-space-sm">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-primary text-[20px]">analytics</span>
                                    <h2 class="font-headline-md text-headline-md text-on-surface">Contractual Metric Benchmark &amp; Historic Runs</h2>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="font-label-mono-sm text-label-mono-sm text-outline">HELD-OUT TEST N=14,200</span>
                                    <span class="px-2 py-0.5 rounded bg-surface-container text-outline font-label-mono-sm text-label-mono-sm">SEED: 42901</span>
                                </div>
                            </div>
                            <p class="font-body-sm text-body-sm text-on-surface-variant">
                                Strict verification table comparing Run #04 against the project charter's SLA thresholds. Any metric breach in primary gating attributes causes automated pipeline abort.
                            </p>
                            <!-- Benchmark Matrix Table -->
                            <div class="overflow-x-auto rounded-lg bg-surface-container-lowest">
                                <table class="w-full text-left font-body-sm text-body-sm">
                                    <thead class="bg-surface-container-high text-outline font-label-caps text-label-caps border-b-0">
                                        <tr>
                                            <th class="py-2.5 px-space-md">Metric Designation</th>
                                            <th class="py-2.5 px-space-md">Contractual Threshold</th>
                                            <th class="py-2.5 px-space-md bg-error-container/20 text-error">Run #04 (Current)</th>
                                            <th class="py-2.5 px-space-md">Run #03</th>
                                            <th class="py-2.5 px-space-md">Run #02</th>
                                            <th class="py-2.5 px-space-md">Run #01</th>
                                            <th class="py-2.5 px-space-md text-right">Gate Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y-0 text-on-surface">
                                        <!-- Primary F1 Gate -->
                                        <tr class="bg-error/5 hover:bg-error/10 transition-colors">
                                            <td class="py-3 px-space-md font-semibold flex items-center gap-1.5">
                                                <span class="w-2 h-2 rounded-full bg-error"></span>
                                                <span class="text-on-surface">F1-Score (Macro)</span>
                                                <span class="px-1.5 py-0.2 rounded bg-error-container text-on-error font-label-mono-sm text-label-mono-sm">PRIMARY GATE</span>
                                            </td>
                                            <td class="py-3 px-space-md font-label-mono-md text-label-mono-md font-bold text-on-surface">&gt;= 0.800</td>
                                            <td class="py-3 px-space-md font-label-mono-md text-label-mono-md font-bold text-error bg-error/15">
                                                0.784 <span class="text-error font-label-mono-sm text-label-mono-sm ml-1">(-0.016)</span>
                                            </td>
                                            <td class="py-3 px-space-md font-label-mono-md text-label-mono-md text-on-surface-variant">0.761</td>
                                            <td class="py-3 px-space-md font-label-mono-md text-label-mono-md text-on-surface-variant">0.739</td>
                                            <td class="py-3 px-space-md font-label-mono-md text-label-mono-md text-on-surface-variant">0.692</td>
                                            <td class="py-3 px-space-md text-right">
                                                <span class="px-2 py-0.5 rounded bg-error-container text-on-error-container font-label-mono-sm text-label-mono-sm font-bold">
                                                    FAILED
                                                </span>
                                            </td>
                                        </tr>
                                        <!-- ROC-AUC -->
                                        <tr class="hover:bg-surface-container transition-colors">
                                            <td class="py-3 px-space-md font-medium text-on-surface">ROC-AUC Score</td>
                                            <td class="py-3 px-space-md font-label-mono-md text-label-mono-md">&gt;= 0.850</td>
                                            <td class="py-3 px-space-md font-label-mono-md text-label-mono-md text-tertiary bg-surface-container">
                                                0.862 <span class="text-tertiary font-label-mono-sm text-label-mono-sm ml-1">(+0.012)</span>
                                            </td>
                                            <td class="py-3 px-space-md font-label-mono-md text-label-mono-md text-on-surface-variant">0.844</td>
                                            <td class="py-3 px-space-md font-label-mono-md text-label-mono-md text-on-surface-variant">0.819</td>
                                            <td class="py-3 px-space-md font-label-mono-md text-label-mono-md text-on-surface-variant">0.781</td>
                                            <td class="py-3 px-space-md text-right">
                                                <span class="px-2 py-0.5 rounded bg-tertiary/20 text-tertiary font-label-mono-sm text-label-mono-sm font-bold">
                                                    PASS
                                                </span>
                                            </td>
                                        </tr>
                                        <!-- Precision -->
                                        <tr class="bg-surface-container-low/40 hover:bg-surface-container transition-colors">
                                            <td class="py-3 px-space-md font-medium text-on-surface">Precision (Churn Class 1)</td>
                                            <td class="py-3 px-space-md font-label-mono-md text-label-mono-md">&gt;= 0.820</td>
                                            <td class="py-3 px-space-md font-label-mono-md text-label-mono-md text-error bg-surface-container">
                                                0.798 <span class="text-error font-label-mono-sm text-label-mono-sm ml-1">(-0.022)</span>
                                            </td>
                                            <td class="py-3 px-space-md font-label-mono-md text-label-mono-md text-on-surface-variant">0.785</td>
                                            <td class="py-3 px-space-md font-label-mono-md text-label-mono-md text-on-surface-variant">0.760</td>
                                            <td class="py-3 px-space-md font-label-mono-md text-label-mono-md text-on-surface-variant">0.710</td>
                                            <td class="py-3 px-space-md text-right">
                                                <span class="px-2 py-0.5 rounded bg-error-container text-on-error-container font-label-mono-sm text-label-mono-sm font-bold">
                                                    FAILED
                                                </span>
                                            </td>
                                        </tr>
                                        <!-- Recall -->
                                        <tr class="hover:bg-surface-container transition-colors">
                                            <td class="py-3 px-space-md font-medium text-on-surface">Recall (Churn Class 1)</td>
                                            <td class="py-3 px-space-md font-label-mono-md text-label-mono-md">&gt;= 0.780</td>
                                            <td class="py-3 px-space-md font-label-mono-md text-label-mono-md text-tertiary bg-surface-container">
                                                0.812 <span class="text-tertiary font-label-mono-sm text-label-mono-sm ml-1">(+0.032)</span>
                                            </td>
                                            <td class="py-3 px-space-md font-label-mono-md text-label-mono-md text-on-surface-variant">0.741</td>
                                            <td class="py-3 px-space-md font-label-mono-md text-label-mono-md text-on-surface-variant">0.720</td>
                                            <td class="py-3 px-space-md font-label-mono-md text-label-mono-md text-on-surface-variant">0.675</td>
                                            <td class="py-3 px-space-md text-right">
                                                <span class="px-2 py-0.5 rounded bg-tertiary/20 text-tertiary font-label-mono-sm text-label-mono-sm font-bold">
                                                    PASS
                                                </span>
                                            </td>
                                        </tr>
                                        <!-- Latency P99 -->
                                        <tr class="bg-surface-container-low/40 hover:bg-surface-container transition-colors">
                                            <td class="py-3 px-space-md font-medium text-on-surface">Inference Latency P99</td>
                                            <td class="py-3 px-space-md font-label-mono-md text-label-mono-md">&lt; 50.0 ms</td>
                                            <td class="py-3 px-space-md font-label-mono-md text-label-mono-md text-tertiary bg-surface-container">
                                                38.4 ms
                                            </td>
                                            <td class="py-3 px-space-md font-label-mono-md text-label-mono-md text-on-surface-variant">41.2 ms</td>
                                            <td class="py-3 px-space-md font-label-mono-md text-label-mono-md text-on-surface-variant">46.5 ms</td>
                                            <td class="py-3 px-space-md font-label-mono-md text-label-mono-md text-on-surface-variant">52.8 ms</td>
                                            <td class="py-3 px-space-md text-right">
                                                <span class="px-2 py-0.5 rounded bg-tertiary/20 text-tertiary font-label-mono-sm text-label-mono-sm font-bold">
                                                    PASS
                                                </span>
                                            </td>
                                        </tr>
                                        <!-- Calibration Brier Score -->
                                        <tr class="hover:bg-surface-container transition-colors">
                                            <td class="py-3 px-space-md font-medium text-on-surface">Calibration (Brier Score)</td>
                                            <td class="py-3 px-space-md font-label-mono-md text-label-mono-md">&lt; 0.120</td>
                                            <td class="py-3 px-space-md font-label-mono-md text-label-mono-md text-tertiary bg-surface-container">
                                                0.114
                                            </td>
                                            <td class="py-3 px-space-md font-label-mono-md text-label-mono-md text-on-surface-variant">0.128</td>
                                            <td class="py-3 px-space-md font-label-mono-md text-label-mono-md text-on-surface-variant">0.134</td>
                                            <td class="py-3 px-space-md font-label-mono-md text-label-mono-md text-on-surface-variant">0.158</td>
                                            <td class="py-3 px-space-md text-right">
                                                <span class="px-2 py-0.5 rounded bg-tertiary/20 text-tertiary font-label-mono-sm text-label-mono-sm font-bold">
                                                    PASS
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- Metric Trend Line Graphic (SVG Visualization) -->
                            <div class="mt-space-sm p-space-md bg-surface-container rounded-lg flex flex-col gap-2">
                                <div class="flex items-center justify-between">
                                    <span class="font-label-caps text-label-caps text-outline uppercase">F1 Trajectory vs Gate Target (Runs #01 - #04)</span>
                                    <span class="font-label-mono-sm text-label-mono-sm text-primary">GAP TO GATE: -0.016</span>
                                </div>
                                <div class="relative w-full h-24 bg-surface-container-lowest rounded p-2 flex items-center justify-center">
                                    <!-- Inline SVG Sparkline / Trajectory Graph -->
                                    <svg class="w-full h-full text-primary" fill="none" preserveaspectratio="none" viewbox="0 0 600 80">
                                        <!-- Threshold Line 0.800 (y = 20) -->
                                        <line opacity="0.8" stroke="#ffb4ab" stroke-dasharray="4 4" stroke-width="1.5" x1="0" x2="600" y1="22" y2="22"></line>
                                        <text fill="#ffb4ab" font-family="Space Mono" font-size="9" font-weight="bold" x="8" y="16">TARGET THRESHOLD: 0.800 F1</text>
                                        <!-- Shaded Area Under Curve -->
                                        <path d="M 50,70 L 200,52 L 380,38 L 540,28 L 540,78 L 50,78 Z" fill="currentColor" fill-opacity="0.08"></path>
                                        <!-- Trajectory Line -->
                                        <path d="M 50,70 L 200,52 L 380,38 L 540,28" stroke="currentColor" stroke-linecap="round" stroke-width="2.5"></path>
                                        <!-- Points -->
                                        <circle cx="50" cy="70" fill="#061421" r="4" stroke="#ffc16c" stroke-width="2"></circle>
                                        <text fill="#d6c4b0" font-family="Space Mono" font-size="9" x="44" y="62">0.692</text>
                                        <circle cx="200" cy="52" fill="#061421" r="4" stroke="#ffc16c" stroke-width="2"></circle>
                                        <text fill="#d6c4b0" font-family="Space Mono" font-size="9" x="194" y="44">0.739</text>
                                        <circle cx="380" cy="38" fill="#061421" r="4" stroke="#ffc16c" stroke-width="2"></circle>
                                        <text fill="#d6c4b0" font-family="Space Mono" font-size="9" x="374" y="30">0.761</text>
                                        <!-- Current Run #04 with Red indicator (Failed threshold) -->
                                        <circle cx="540" cy="28" fill="#ffb4ab" r="5" stroke="#93000a" stroke-width="2"></circle>
                                        <text fill="#ffb4ab" font-family="Space Mono" font-size="10" font-weight="bold" x="510" y="20">RUN #04: 0.784</text>
                                    </svg>
                                </div>
                                <div class="flex items-center justify-between text-outline font-label-mono-sm text-label-mono-sm px-1">
                                    <span>R-01 (Baseline)</span>
                                    <span>R-02 (Feature Eng)</span>
                                    <span>R-03 (Hyperopt Bayes)</span>
                                    <span class="text-error font-bold">R-04 (XGBoost Bayes Tuned)</span>
                                </div>
                            </div>
                        </div>
                        <!-- RIGHT BENTO: PRE-FLIGHT GATE CHECKLIST (4 cols) -->
                        <div class="xl:col-span-4 flex flex-col justify-between p-space-lg bg-surface-container-low rounded-xl shadow-lg">
                            <div>
                                <div class="flex items-center justify-between mb-space-sm">
                                    <span class="font-label-mono-sm text-label-mono-sm text-outline uppercase tracking-wider font-bold">// GATE CONDITIONS</span>
                                    <span class="font-label-mono-sm text-label-mono-sm text-primary">4 / 6 COMPLIANT</span>
                                </div>
                                <h2 class="font-headline-md text-headline-md text-on-surface mb-2">Stage 08 Gateway Acceptance Checklist</h2>
                                <p class="font-body-sm text-body-sm text-on-surface-variant mb-space-md">
                                    All criteria must reach strict nominal status before automated orchestrator issues container deployment token.
                                </p>
                                <!-- Checklist Items -->
                                <div class="space-y-2.5">
                                    <!-- 1. Test Split Integrity -->
                                    <div class="p-space-sm bg-surface-container rounded-lg flex items-start gap-space-sm">
                                        <span class="material-symbols-outlined text-[20px] text-tertiary shrink-0 mt-0.5">check_circle</span>
                                        <div class="flex flex-col">
                                            <span class="font-headline-sm text-headline-sm text-on-surface">Test Split Integrity &amp; Leakage</span>
                                            <span class="font-body-sm text-body-sm text-tertiary">Zero data leakage detected from crm_customers.csv. Clean temporal split verified.</span>
                                        </div>
                                    </div>
                                    <!-- 2. Dockerfile Container -->
                                    <div class="p-space-sm bg-surface-container rounded-lg flex items-start gap-space-sm">
                                        <span class="material-symbols-outlined text-[20px] text-tertiary shrink-0 mt-0.5">check_circle</span>
                                        <div class="flex flex-col">
                                            <span class="font-headline-sm text-headline-sm text-on-surface">Dockerfile Security &amp; Isolation</span>
                                            <span class="font-body-sm text-body-sm text-tertiary">Container builds without root privileges. Distroless base layer passed scan.</span>
                                        </div>
                                    </div>
                                    <!-- 3. Schema validation -->
                                    <div class="p-space-sm bg-surface-container rounded-lg flex items-start gap-space-sm">
                                        <span class="material-symbols-outlined text-[20px] text-tertiary shrink-0 mt-0.5">check_circle</span>
                                        <div class="flex flex-col">
                                            <span class="font-headline-sm text-headline-sm text-on-surface">Payload Strict Typing</span>
                                            <span class="font-body-sm text-body-sm text-tertiary">Pydantic v2 schemas reject non-standard customer churn payloads with 422 Unprocessable.</span>
                                        </div>
                                    </div>
                                    <!-- 4. SHAP Report -->
                                    <div class="p-space-sm bg-surface-container rounded-lg flex items-start gap-space-sm">
                                        <span class="material-symbols-outlined text-[20px] text-tertiary shrink-0 mt-0.5">check_circle</span>
                                        <div class="flex flex-col">
                                            <span class="font-headline-sm text-headline-sm text-on-surface">Explainability Audit Compiled</span>
                                            <span class="font-body-sm text-body-sm text-tertiary">Global TreeSHAP values summary generated and attached to Section 5.</span>
                                        </div>
                                    </div>
                                    <!-- 5. Contractual F1 (FAILED - BLOCKING) -->
                                    <div class="p-space-sm bg-error-container/30 rounded-lg flex items-start gap-space-sm">
                                        <span class="material-symbols-outlined text-[20px] text-error shrink-0 mt-0.5" style="font-variation-settings: 'FILL' 1;">error</span>
                                        <div class="flex flex-col">
                                            <div class="flex items-center justify-between">
                                                <span class="font-headline-sm text-headline-sm text-error font-bold">F1 &gt;= 0.800 SLA Clearance</span>
                                                <span class="text-error font-label-mono-sm text-label-mono-sm font-bold uppercase">BLOCKING GATE</span>
                                            </div>
                                            <span class="font-body-sm text-body-sm text-on-error-container">Achieved 0.784. Requires +0.016 delta to unlock promotion gate.</span>
                                        </div>
                                    </div>
                                    <!-- 6. Peer Review (PENDING) -->
                                    <div class="p-space-sm bg-surface-container rounded-lg flex items-start gap-space-sm opacity-70">
                                        <span class="material-symbols-outlined text-[20px] text-outline shrink-0 mt-0.5">hourglass_empty</span>
                                        <div class="flex flex-col">
                                            <span class="font-headline-sm text-headline-sm text-on-surface">Senior Engineer Final Endorsement</span>
                                            <span class="font-body-sm text-body-sm text-outline">Gated. Unlocks only after automated metric threshold passes 100%.</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Strict Zero-Hints Box -->
                            <div class="mt-space-lg p-space-sm bg-surface-container-lowest rounded flex items-center gap-space-sm">
                                <span class="material-symbols-outlined text-outline text-[18px]">verified_user</span>
                                <span class="font-label-mono-sm text-label-mono-sm text-outline uppercase tracking-wider">
                                    VOSTOKPRIBOR PROTOCOL VP-08: SOLUTION LEAKAGE SAFEGUARD ACTIVATED
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- 4. RESUBMISSION CONTROL PANEL & DISPATCH (Mission Control Panel) -->
                    <div class="p-space-lg bg-surface-container rounded-xl shadow-xl flex flex-col gap-space-md">
                        <div class="flex flex-wrap items-center justify-between gap-space-sm">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary text-[22px]">tune</span>
                                <h2 class="font-headline-md text-headline-md text-on-surface">Stage 08 Resubmission &amp; Promotion Console</h2>
                            </div>
                            <div class="font-label-mono-sm text-label-mono-sm text-outline">
                                CURRENT COHORT: VP-2024-ALMATY-SYS01 // SPRINT CYCLE #3
                            </div>
                        </div>
                        <!-- Preserved Trainee Submission Notes -->
                        <div class="flex flex-col gap-1.5">
                            <label class="font-label-caps text-label-caps text-on-surface-variant flex items-center justify-between">
                                <span>TRAINEE SUBMISSION MEMORANDUM // RUN #04 LOG ENTRY</span>
                                <span class="font-label-mono-sm text-label-mono-sm text-outline">TIMESTAMP: 2024-03-29 09:20 UTC</span>
                            </label>
                            <textarea class="w-full bg-surface-container-lowest p-space-sm rounded font-body-sm text-body-sm text-on-surface placeholder:text-outline focus:outline-none" readonly="" rows="3">Run #04: Applied Bayesian optimization over 450 estimators with tree depth 8. Incorporated interaction features between optical sensor log frequency and billing complaint cycles. Endpoint verified via local mock container on port 8443. Target metric F1 currently at 0.784.</textarea>
                        </div>
                        <!-- Dispatch Buttons Bar -->
                        <div class="pt-space-sm flex flex-col md:flex-row items-center justify-between gap-space-md">
                            <!-- Left: Action info -->
                            <div class="flex items-center gap-space-sm text-outline font-label-mono-sm text-label-mono-sm">
                                <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                                <span>DISPATCH CONTROLLER READY // READY TO SPAWN RUN #05</span>
                            </div>
                            <!-- Right: Control Actions -->
                            <div class="flex flex-wrap items-center gap-space-sm w-full md:w-auto">
                                <!-- Request Manual Instructor Override Button with -15 XP Warning -->
                                <button class="px-space-md py-2.5 rounded bg-surface-container-high hover:bg-surface-container-highest text-on-surface-variant hover:text-on-surface font-label-caps text-label-caps flex items-center gap-2 transition-all" onclick="toggleModal('modal-override')">
                                    <span class="material-symbols-outlined text-[16px] text-error">priority_high</span>
                                    Request Manual Instructor Override (-15 XP Penalty)
                                </button>
                                <!-- Stage New Run via Workbench CTA (Amber Accent) -->
                                <a class="px-space-md py-2.5 rounded bg-primary text-on-primary hover:bg-primary-container font-headline-sm text-headline-sm flex items-center gap-2 shadow-lg transition-all" href="#">
                                    <span class="material-symbols-outlined text-[18px]">biotech</span>
                                    Stage New Run (Run #05) via SYS-AI-03 Workbench
                                </a>
                                <!-- LOCKED Promotion CTA -->
                                <div class="relative group">
                                    <button class="px-space-md py-2.5 rounded bg-surface-bright/40 text-outline font-headline-sm text-headline-sm flex items-center gap-2 cursor-not-allowed" disabled="">
                                        <span class="material-symbols-outlined text-[18px]">lock</span>
                                        Promote to Stage 10 (Deployment)
                                    </button>
                                    <!-- Hover Tooltip -->
                                    <div class="absolute bottom-full mb-2 right-0 hidden group-hover:flex flex-col bg-surface-container-lowest text-on-surface p-2 rounded shadow-xl w-64 pointer-events-none z-30">
                                        <span class="font-label-mono-sm text-label-mono-sm text-error font-bold">PROMOTION LOCKED</span>
                                        <span class="font-body-sm text-body-sm text-outline">Blocked by Gate 08 Threshold Rejection. Primary F1 metric must reach &gt;= 0.800 to unlock deployment pipeline.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modals (Hidden by default, triggered via micro-interaction buttons) -->
                    <!-- Modal 1: Weights Manifest -->
                    <div class="fixed inset-0 z-50 bg-surface-dim/80 backdrop-blur-md hidden flex items-center justify-center p-space-md" id="modal-weights">
                        <div class="bg-surface-container-low max-w-xl w-full rounded-xl p-space-lg shadow-2xl flex flex-col gap-space-md">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-primary text-[20px]">inventory_2</span>
                                    <h3 class="font-headline-md text-headline-md text-on-surface">Model Weights Manifest</h3>
                                </div>
                                <button class="text-outline hover:text-on-surface" onclick="toggleModal('modal-weights')">
                                    <span class="material-symbols-outlined">close</span>
                                </button>
                            </div>
                            <div class="bg-surface-container-lowest p-space-md rounded font-label-mono-sm text-label-mono-sm text-on-surface-variant overflow-x-auto space-y-1">
                                <div>FILE: churn_xgb_model_v1.4.tar.gz</div>
                                <div>FORMAT: ONNX Runtime Export v1.16</div>
                                <div>NUM_FEATURES: 48 (Encoded tabular)</div>
                                <div>SHA256: 9f8ab2130e9d4812f8319c58e7223018247ca8f32c1</div>
                                <div>TARGET_LABEL: will_churn (Binary 0/1)</div>
                                <div>INSPECTION STATUS: Non-compliant (F1 deficit)</div>
                            </div>
                            <div class="flex justify-end">
                                <button class="px-space-md py-1.5 rounded bg-surface-container text-on-surface font-label-caps text-label-caps" onclick="toggleModal('modal-weights')">Close Manifest</button>
                            </div>
                        </div>
                    </div>
                    <!-- Modal 2: Swagger Preview -->
                    <div class="fixed inset-0 z-50 bg-surface-dim/80 backdrop-blur-md hidden flex items-center justify-center p-space-md" id="modal-swagger">
                        <div class="bg-surface-container-low max-w-xl w-full rounded-xl p-space-lg shadow-2xl flex flex-col gap-space-md">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-tertiary text-[20px]">api</span>
                                    <h3 class="font-headline-md text-headline-md text-on-surface">FastAPI OpenAPI Specification</h3>
                                </div>
                                <button class="text-outline hover:text-on-surface" onclick="toggleModal('modal-swagger')">
                                    <span class="material-symbols-outlined">close</span>
                                </button>
                            </div>
                            <div class="bg-surface-container-lowest p-space-md rounded font-label-mono-sm text-label-mono-sm text-on-surface-variant overflow-x-auto space-y-1">
                                <div class="text-tertiary">POST /predict_churn</div>
                                <div class="text-outline">Host: node-402.sys03.almaty.internal:8443</div>
                                <div class="text-on-surface">Payload Schema: CustomerTelemetryInput</div>
                                <div>- tenure_months: int</div>
                                <div>- optical_sensor_errors_30d: int</div>
                                <div>- total_spend_kzt: float</div>
                                <div>- last_support_ticket_code: string</div>
                                <div class="text-tertiary mt-2">Response: 200 OK {"churn_probability": 0.72, "prediction": 1}</div>
                            </div>
                            <div class="flex justify-end">
                                <button class="px-space-md py-1.5 rounded bg-surface-container text-on-surface font-label-caps text-label-caps" onclick="toggleModal('modal-swagger')">Dismiss</button>
                            </div>
                        </div>
                    </div>
                    <!-- Modal 3: PDF Document Viewer Modal -->
                    <div class="fixed inset-0 z-50 bg-surface-dim/80 backdrop-blur-md hidden flex items-center justify-center p-space-md" id="modal-pdf">
                        <div class="bg-surface-container-low max-w-2xl w-full rounded-xl p-space-lg shadow-2xl flex flex-col gap-space-md">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-secondary text-[20px]">picture_as_pdf</span>
                                    <h3 class="font-headline-md text-headline-md text-on-surface">SYS-AI-024 Audit Report (Rev 1.4)</h3>
                                </div>
                                <button class="text-outline hover:text-on-surface" onclick="toggleModal('modal-pdf')">
                                    <span class="material-symbols-outlined">close</span>
                                </button>
                            </div>
                            <div class="bg-surface-container-lowest p-space-lg rounded space-y-3 font-body-sm text-body-sm text-on-surface-variant">
                                <div class="flex items-center justify-between pb-2">
                                    <span class="font-label-caps text-label-caps text-on-surface">DOCUMENT SUMMARY: 18 PAGES</span>
                                    <span class="font-label-mono-sm text-label-mono-sm text-tertiary">VALIDATED FOR SUBMISSION</span>
                                </div>
                                <p>
                                    Section 1.0: Executive Abstract &amp; Problem Statement for Industrial Churn Mitigation.<br />
                                    Section 2.0: Data Lineage &amp; Preprocessing in SYS-AI-02 (Almaty Data Center).<br />
                                    Section 3.0: Hyperparameter Space &amp; Search History across Runs 01-04.<br />
                                    Section 4.0: Model Interpretability, SHAP global beeswarm analysis.<br />
                                    Section 5.0: Failure Analysis on Gated F1 Target.
                                </p>
                            </div>
                            <div class="flex justify-end">
                                <button class="px-space-md py-1.5 rounded bg-surface-container text-on-surface font-label-caps text-label-caps" onclick="toggleModal('modal-pdf')">Close Viewer</button>
                            </div>
                        </div>
                    </div>
                    <!-- Modal 4: Manual Instructor Override Confirmation -->
                    <div class="fixed inset-0 z-50 bg-surface-dim/80 backdrop-blur-md hidden flex items-center justify-center p-space-md" id="modal-override">
                        <div class="bg-surface-container-low max-w-md w-full rounded-xl p-space-lg shadow-2xl flex flex-col gap-space-md">
                            <div class="flex items-center gap-2 text-error">
                                <span class="material-symbols-outlined text-[24px]">warning</span>
                                <h3 class="font-headline-md text-headline-md text-on-surface">Request Instructor Override?</h3>
                            </div>
                            <p class="font-body-md text-body-md text-on-surface-variant">
                                Requesting a manual instructor waiver invokes a mandatory <span class="text-error font-bold">-15 XP penalty</span> on your Cohort Engineering Standing. Instructor review does NOT guarantee gate approval.
                            </p>
                            <div class="flex justify-end gap-space-sm pt-space-xs">
                                <button class="px-space-md py-1.5 rounded bg-surface-container text-on-surface font-label-caps text-label-caps" onclick="toggleModal('modal-override')">Cancel</button>
                                <button class="px-space-md py-1.5 rounded bg-error-container text-on-error-container font-label-caps text-label-caps font-bold" onclick="toggleModal('modal-override'); alert('Override request logged to Instructor Portal. 15 XP deducted from trainee profile.');">Confirm Request (-15 XP)</button>
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