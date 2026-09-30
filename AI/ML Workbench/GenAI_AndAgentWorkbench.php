<?php
require_once __DIR__ . '/../../config/config.php';
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
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@100..900&amp;family=Inter:wght@100..900&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../../assets/css/global.css" />
    <link rel="stylesheet" href="css/style.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="js/tailwind.config.js"></script>
</head>

<body class="bg-background font-body-md text-on-surface antialiased min-h-screen selection:bg-tertiary-container selection:text-tertiary">
    <aside class="fixed left-0 top-0 h-full w-72 bg-surface-container-lowest border-r border-outline-variant/30 z-50 flex flex-col justify-between shadow-2xl">
        <div class="flex flex-col">
            <div class="h-28 px-space-md border-b border-outline-variant/30 flex items-center justify-between bg-surface-container-low/60">
                <div class="flex items-center gap-space-sm"><a href="../../index.php" title="Return to Mission Control" class="hover:opacity-80 transition-opacity"><img alt="VOSTOKPRIBOR AI Geometric Logo" class="h-8 w-auto object-contain" src="https://lh3.googleusercontent.com/aida/AEtjO1Ub4brI6u1dsfV-FEmeVRA_JMdFomA6enbXrkXn9IhcRZ2ISluJFc6ehdir_Bz5FjSp6TvAsIkSGf9t8JK1tEonWZxiXhh-8LE6PvmQRmoRB5RYbTk7zIb8VFzky2txPOQWnUkHMuYeMozbKz88yiVcmZUbh14VPbQEj79l9WWKXyA44Zjsx9a4JMBViNOwF_IyZT3p0e3Y27ibSLkAxSS8jHXY8uVFu8sUhBdrgGtRdaZ1F17S-zOW8Z0" /></a>
                    <div class="flex flex-col"><span class="font-headline-md text-title-sm tracking-wider uppercase text-on-surface font-semibold">VOSTOKPRIBOR</span><span class="font-code-sm text-code-sm text-tertiary font-mono tracking-widest uppercase">AI · ML AVIONICS</span></div>
                </div>
                <div class="flex items-center px-space-xs py-0.5 rounded bg-surface-container-high border border-outline-variant/40"><span class="font-code-sm text-code-sm text-on-surface-variant font-mono">v4.2</span></div>
            </div>
            <div class="px-space-md py-space-sm">
                <div class="text-label-sm font-label-sm uppercase tracking-widest text-outline mb-space-xs px-space-xs">Subsystems Dispatch</div>
                <nav class="flex flex-col gap-1" data-active-classes="bg-surface-container-high text-on-surface font-semibold shadow-inner"><a class="group flex items-center justify-between px-space-md py-2.5 rounded-lg text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-all" data-path="projects" href="../../AI Project Management/Dashboard.php">
                        <div class="flex items-center gap-space-sm"><span class="material-symbols-outlined text-outline group-hover:text-primary transition-colors text-lg">folder_special</span><span class="font-code-md text-code-md tracking-tight">SYS-AI-01</span><span class="font-body-sm text-body-sm text-on-surface-variant group-hover:text-on-surface">Projects</span></div><span class="w-1.5 h-1.5 rounded-full bg-outline-variant/60"></span>
                    </a><a class="group flex items-center justify-between px-space-md py-2.5 rounded-lg text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-all" data-path="data-center" href="../../Data Center/DatasetCatalog.php">
                        <div class="flex items-center gap-space-sm"><span class="material-symbols-outlined text-outline group-hover:text-primary transition-colors text-lg">dataset</span><span class="font-code-md text-code-md tracking-tight">SYS-AI-02</span><span class="font-body-sm text-body-sm text-on-surface-variant group-hover:text-on-surface">Data Center</span></div><span class="w-1.5 h-1.5 rounded-full bg-outline-variant/60"></span>
                    </a><a class="group flex items-center justify-between px-space-md py-2.5 rounded-lg text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-all" data-path="workbench" href="WorkbenchHome.php">
                        <div class="flex items-center gap-space-sm"><span class="material-symbols-outlined text-tertiary text-lg">precision_manufacturing</span><span class="font-code-md text-code-md tracking-tight text-tertiary">SYS-AI-03</span><span class="font-body-sm text-body-sm text-on-surface font-medium">Workbench</span></div><span class="w-2 h-2 rounded bg-tertiary shadow-[0_0_8px_rgba(255,185,86,0.8)]"></span>
                    </a><a class="group flex items-center justify-between px-space-md py-2.5 rounded-lg text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-all" data-path="registry-deployment" href="../../Model Registry & Deployment/ModelRegistry.php">
                        <div class="flex items-center gap-space-sm"><span class="material-symbols-outlined text-outline group-hover:text-primary transition-colors text-lg">rocket_launch</span><span class="font-code-md text-code-md tracking-tight">SYS-AI-04</span><span class="font-body-sm text-body-sm text-on-surface-variant group-hover:text-on-surface">Registry &amp; Deploy</span></div><span class="w-1.5 h-1.5 rounded-full bg-outline-variant/60"></span>
                    </a><a class="group flex items-center justify-between px-space-md py-2.5 rounded-lg text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-all" data-path="ai-soc" href="../../AI Operations Center (AI SOC)/FleetTelemetry.php">
                        <div class="flex items-center gap-space-sm"><span class="material-symbols-outlined text-outline group-hover:text-primary transition-colors text-lg">shield_with_heart</span><span class="font-code-md text-code-md tracking-tight">SYS-AI-05</span><span class="font-body-sm text-body-sm text-on-surface-variant group-hover:text-on-surface">AI SOC</span></div><span class="w-1.5 h-1.5 rounded-full bg-outline-variant/60"></span>
                    </a></nav>
            </div>
        </div>
        <div class="p-space-md border-t border-outline-variant/30 bg-surface-container-lowest/90">
            <div class="flex items-center justify-between p-space-sm rounded-lg bg-surface-container-low border border-outline-variant/20 mb-space-sm">
                <div class="flex flex-col"><span class="font-label-sm text-label-sm text-outline uppercase font-mono">Cluster Load</span><span class="font-code-md text-code-md text-on-surface">88.4 TFLOPS</span></div><span class="material-symbols-outlined text-tertiary text-lg">memory</span>
            </div>
            <div class="flex items-center justify-between text-outline text-label-sm font-label-sm px-space-xs"><span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>SECURE-RAIL</span><span class="font-mono">ORB-NODE-9</span></div>
        </div>
    </aside>
    <div class="pl-72 flex flex-col min-h-screen">
        <header class="fixed top-0 left-72 right-0 h-28 bg-surface-container-lowest/95 backdrop-blur-md border-b border-outline-variant/30 z-40 flex flex-col justify-between shadow-md">
            <div class="h-16 px-space-md flex items-center justify-between gap-space-md">
                <div class="flex items-center gap-space-md flex-1 max-w-2xl">
                    <div class="relative w-80"><span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-lg">search</span><input class="w-full h-9 pl-9 pr-3 rounded bg-surface-container-low border border-outline-variant/50 text-code-sm font-code-sm text-on-surface placeholder:text-outline focus:outline-none focus:border-tertiary transition-colors" placeholder="Search experiments, models, datasets... /" type="text" /></div>
                    <div class="flex items-center bg-surface-container-high/60 border border-outline-variant/40 rounded px-space-sm py-1 gap-space-sm"><span class="material-symbols-outlined text-tertiary text-sm">label_important</span><span class="font-code-sm text-code-sm text-on-surface-variant font-mono">#AI-024 Customer Churn · F1 ≥ 0.80</span></div>
                </div>
                <div class="flex items-center gap-space-sm">
                    <div class="flex items-center rounded bg-surface-container-high p-0.5 border border-outline-variant/40"><button class="px-2 py-0.5 text-label-sm font-label-sm rounded bg-primary-container text-on-primary font-medium shadow-sm">STUDENT</button><button class="px-2 py-0.5 text-label-sm font-label-sm rounded text-on-surface-variant hover:text-on-surface transition-colors">INSTRUCTOR</button></div>
                    <div class="flex items-center bg-surface-container-low border border-outline-variant/30 rounded px-2 py-1 gap-1 text-code-sm font-code-sm"><span class="text-tertiary font-bold">EN</span><span class="text-outline">/</span><span class="text-on-surface-variant hover:text-on-surface cursor-pointer">AR</span><span class="text-label-sm font-label-sm text-outline ml-1">[RTL]</span></div><button class="relative p-1.5 rounded-lg bg-surface-container-low border border-outline-variant/30 hover:border-outline text-on-surface-variant hover:text-on-surface transition-all"><span class="material-symbols-outlined text-lg">notifications</span><span class="absolute top-1 right-1 w-2 h-2 rounded-full bg-tertiary ring-2 ring-surface-container-lowest"></span></button>
                    <div class="flex items-center gap-space-sm pl-space-xs border-l border-outline-variant/30">
                        <div class="flex flex-col text-right"><span class="font-label-sm text-label-sm font-medium text-on-surface">Cadet Operator</span><span class="font-code-sm text-code-sm text-outline font-mono">Intern AI Eng · L2</span></div><img alt="Profile" class="w-8 h-8 rounded-full object-cover ring-1 ring-outline-variant" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDpyhdG5OuT3oLrUsTzMjNUGXB4hjJbrF8mCC4V5F4Gtp64gDmaM5jUctDpDaKjtjSVgZOJ55FvQ9HehQfOhqCHVcbx4YTgmvn3byrGCQg4AQt54M2E8FlnnBAFkLchpW6k4r5c6LtqEvlUsUgdOkgHRthVgB2ZAGrv7TMYk_fHWlnW4EKii-_kOla8oqTRpnlGgPHi9DhIX2sc85AL3SPjtf2CERGVMVsBaFVBCyS1xCHY0HaQeQonvQ" />
                    </div>
                </div>
            </div>
            <div class="h-12 px-space-md border-t border-outline-variant/20 bg-surface-container/60 flex items-center overflow-x-auto gap-1 text-label-sm font-label-sm">
                <div class="flex items-center shrink-0 px-2 py-1 text-outline font-mono">1. Framing</div><span class="text-outline-variant">›</span>
                <div class="flex items-center shrink-0 px-2 py-1 text-outline font-mono">2. Ingest</div><span class="text-outline-variant">›</span>
                <div class="flex items-center shrink-0 px-2 py-1 text-outline font-mono">3. EDA</div><span class="text-outline-variant">›</span>
                <div class="flex items-center shrink-0 px-2 py-1 text-outline font-mono">4. Validation</div><span class="text-outline-variant">›</span>
                <div class="flex items-center shrink-0 px-2 py-1 text-outline font-mono">5. Feature Store</div><span class="text-outline-variant">›</span>
                <div class="flex items-center shrink-0 px-2 py-1 rounded bg-secondary-container/80 text-secondary-fixed font-mono border border-secondary/40 shadow-sm">6. Pipeline Prep</div><span class="text-tertiary">›</span>
                <a href="ExperimentBuilder.php" class="flex items-center shrink-0 px-2 py-1 rounded bg-tertiary-container text-tertiary-fixed font-mono border border-tertiary/60 shadow-[0_0_10px_rgba(255,185,86,0.3)] hover:scale-105 transition-transform">7. Architecture</a><span class="text-tertiary">›</span>
                <a href="GenAI_AndAgentWorkbench.php" class="flex items-center shrink-0 px-2 py-1 rounded bg-secondary-container/80 text-secondary-fixed font-mono border border-secondary/40 shadow-sm hover:scale-105 transition-transform">8. Hyperparam</a><span class="text-tertiary">›</span>
                <a href="RunResults.php" class="flex items-center shrink-0 px-2 py-1 rounded bg-secondary-container/80 text-secondary-fixed font-mono border border-secondary/40 shadow-sm hover:scale-105 transition-transform">9. Eval & Validate</a><span class="text-outline-variant">›</span>
                <a href="CompareRuns.php" class="flex items-center shrink-0 px-2 py-1 text-outline hover:text-white font-mono transition-colors">10. Explainability</a><span class="text-outline-variant">›</span>
                <a href="RegisterModelDialog.php" class="flex items-center shrink-0 px-2 py-1 text-outline hover:text-white font-mono transition-colors">11. Registry</a><span class="text-outline-variant">›</span>
                <div class="flex items-center shrink-0 px-2 py-1 text-outline font-mono">12. Canary</div><span class="text-outline-variant">›</span>
                <div class="flex items-center shrink-0 px-2 py-1 text-outline font-mono">13. Production</div><span class="text-outline-variant">›</span>
                <a href="../../AI Operations Center (AI SOC)/DriftInvestigationWorkspace.php" class="flex items-center shrink-0 px-2 py-1 text-outline hover:text-rose-400 font-mono transition-colors">14. Drift</a>
            </div>
        </header>
        <main class="w-full pt-28 bg-surface flex-1 min-h-[calc(100vh-7rem)] p-space-md">
            <div class="flex flex-col w-full gap-space-md">
                <!-- TOP COMMAND & GRAPH CONTROLS BAR -->
                <section class="w-full bg-surface-container-low rounded-xl p-space-md shadow-md flex flex-col gap-space-sm">
                    <div class="flex flex-wrap items-center justify-between gap-space-md">
                        <!-- Subsystem & Path Info -->
                        <div class="flex flex-wrap items-center gap-space-sm">
                            <div class="flex items-center gap-2 bg-surface-container-high px-space-sm py-1 rounded">
                                <span class="w-2 h-2 rounded-full bg-tertiary shadow-[0_0_6px_rgba(255,185,86,0.9)] animate-pulse"></span>
                                <span class="font-code-sm text-code-sm text-tertiary uppercase font-mono tracking-wider">SYS-AI-03 // WORKBENCH</span>
                            </div>
                            <span class="text-outline-variant font-mono">/</span>
                            <div class="flex items-center gap-1.5 font-code-sm text-code-sm text-on-surface-variant font-mono">
                                <span class="text-on-surface font-semibold">AGENT-EXP-08</span>
                                <span class="text-outline">::</span>
                                <span class="text-secondary-fixed">Churn-Mitigation-Supervisor</span>
                            </div>
                            <span class="px-2 py-0.5 rounded bg-surface-container text-label-sm font-label-sm uppercase text-secondary font-mono">
                                LangGraph v0.2.14
                            </span>
                            <span class="px-2 py-0.5 rounded bg-surface-variant/40 text-label-sm font-label-sm uppercase text-outline font-mono">
                                DIRECTIVE #AI-024
                            </span>
                        </div>
                        <!-- Mode Switcher Tabs -->
                        <div class="flex items-center bg-surface-container-lowest p-1 rounded-lg">
                            <button class="px-3 py-1 rounded text-label-sm font-label-sm text-on-surface-variant hover:text-on-surface transition-colors uppercase">
                                Tabular / Classical
                            </button>
                            <button class="px-3 py-1 rounded text-label-sm font-label-sm bg-tertiary-container text-tertiary-fixed font-semibold uppercase shadow-inner flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-tertiary"></span>
                                GenAI / Agentic
                            </button>
                            <button class="px-3 py-1 rounded text-label-sm font-label-sm text-on-surface-variant hover:text-on-surface transition-colors uppercase">
                                Evaluation Matrix
                            </button>
                        </div>
                        <!-- Action Cluster -->
                        <div class="flex items-center gap-2 flex-wrap">
                            <button class="h-9 px-3 rounded-lg bg-surface-container-high hover:bg-surface-bright text-on-surface text-label-sm font-label-sm uppercase flex items-center gap-1.5 transition-all" id="btn-compile">
                                <span class="material-symbols-outlined text-base text-tertiary">account_tree</span>
                                <span>Compile Graph</span>
                            </button>
                            <button class="h-9 px-3 rounded-lg bg-surface-container-high hover:bg-surface-bright text-on-surface text-label-sm font-label-sm uppercase flex items-center gap-1.5 transition-all" id="btn-step">
                                <span class="material-symbols-outlined text-base text-primary">play_arrow</span>
                                <span>Step Debugger</span>
                            </button>
                            <button class="h-9 px-3 rounded-lg bg-tertiary hover:bg-tertiary-fixed text-on-tertiary text-label-sm font-label-sm uppercase font-semibold flex items-center gap-1.5 transition-all shadow-md">
                                <span class="material-symbols-outlined text-base">science</span>
                                <span>Run Ragas (500)</span>
                            </button>
                            <button class="h-9 w-9 flex items-center justify-center rounded-lg bg-surface-container-high hover:bg-surface-bright text-on-surface-variant transition-colors" title="Export JSON-LD">
                                <span class="material-symbols-outlined text-base">download</span>
                            </button>
                        </div>
                    </div>
                    <!-- Active Agent State Schema & Runtime Telemetry Strip -->
                    <div class="grid grid-cols-1 xl:grid-cols-12 gap-space-sm pt-space-xs items-center bg-surface-container-lowest/80 rounded-lg p-space-sm">
                        <div class="xl:col-span-8 flex items-center gap-2 overflow-x-auto min-w-0">
                            <span class="text-label-sm font-label-sm uppercase tracking-wider text-outline shrink-0 font-mono">AgentState:</span>
                            <code class="font-code-sm text-code-sm text-secondary bg-surface-container px-2 py-0.5 rounded truncate font-mono">
                                TypedDict { customer_id: str, risk_score: float, intent: str, retrieved_docs: List[Doc], account_status: dict, proposal: str }
                            </code>
                        </div>
                        <div class="xl:col-span-4 flex items-center justify-end gap-space-md text-label-sm font-label-sm font-mono shrink-0">
                            <span class="flex items-center gap-1 text-on-surface-variant">
                                <span class="text-outline">STREAM:</span> <span class="text-tertiary font-semibold">84.2 tok/s</span>
                            </span>
                            <span class="flex items-center gap-1 text-on-surface-variant">
                                <span class="text-outline">p95:</span> <span class="text-secondary-fixed">412ms</span>
                            </span>
                            <span class="flex items-center gap-1 text-on-surface-variant">
                                <span class="text-outline">COST:</span> <span class="text-on-surface">$0.0028/run</span>
                            </span>
                            <span class="px-1.5 py-0.5 rounded bg-surface-container-high text-tertiary text-[10px] uppercase font-mono">SSE ACTIVE</span>
                        </div>
                    </div>
                </section>
                <!-- MAIN WORKSPACE SPLIT (65% / 35%) -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-md w-full">
                    <!-- LEFT / CENTER COLUMN (62-65% width) -->
                    <div class="lg:col-span-7 xl:col-span-8 flex flex-col gap-space-md">
                        <!-- LANGGRAPH INTERACTIVE STATE-GRAPH CANVAS -->
                        <div class="relative bg-surface-container-lowest rounded-xl p-space-md shadow-md overflow-hidden flex flex-col min-h-[580px]">
                            <!-- Canvas Toolbar -->
                            <div class="flex items-center justify-between z-10 mb-space-sm bg-surface-container-low/90 backdrop-blur-md p-2 rounded-lg">
                                <div class="flex items-center gap-space-sm">
                                    <span class="material-symbols-outlined text-tertiary text-lg">schema</span>
                                    <span class="font-title-sm text-title-sm text-on-surface tracking-wide">LANGGRAPH TOPOLOGY EXECUTION GRAPH</span>
                                    <span class="px-2 py-0.5 rounded bg-surface-container-high text-code-sm font-code-sm text-secondary-fixed font-mono">8 NODES · 9 EDGES</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <button class="p-1 rounded bg-surface-container hover:bg-surface-container-high text-on-surface-variant transition-colors" title="Zoom In">
                                        <span class="material-symbols-outlined text-sm">zoom_in</span>
                                    </button>
                                    <button class="p-1 rounded bg-surface-container hover:bg-surface-container-high text-on-surface-variant transition-colors" title="Zoom Out">
                                        <span class="material-symbols-outlined text-sm">zoom_out</span>
                                    </button>
                                    <button class="p-1 rounded bg-surface-container hover:bg-surface-container-high text-on-surface-variant transition-colors" title="Center View">
                                        <span class="material-symbols-outlined text-sm">fit_screen</span>
                                    </button>
                                    <span class="w-px h-4 bg-outline-variant/30 mx-1"></span>
                                    <div class="flex items-center gap-1 px-2 py-0.5 rounded bg-surface-container text-label-sm font-label-sm font-mono text-outline">
                                        <span>CANVAS:</span>
                                        <span class="text-tertiary font-bold">100%</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Graph Blueprint Area -->
                            <div class="relative flex-1 w-full bg-surface-container/40 rounded-lg p-space-md overflow-x-auto overflow-y-hidden flex items-center justify-center select-none" id="graph-viewport">
                                <!-- Background Blueprint Grid Pattern (SVG) -->
                                <svg class="absolute inset-0 w-full h-full pointer-events-none opacity-20" xmlns="http://www.w3.org/2000/svg">
                                    <defs>
                                        <pattern height="24" id="grid-dots" patternunits="userSpaceOnUse" width="24">
                                            <circle cx="2" cy="2" fill="#b4c8e3" r="1"></circle>
                                        </pattern>
                                    </defs>
                                    <rect fill="url(#grid-dots)" height="100%" width="100%"></rect>
                                </svg>
                                <!-- SVG Routing Lines & Connectors Layer -->
                                <svg class="absolute inset-0 w-full h-full pointer-events-none z-0" xmlns="http://www.w3.org/2000/svg">
                                    <defs>
                                        <!-- Arrowhead Amber -->
                                        <marker id="arrow-amber" markerheight="6" markerwidth="6" orient="auto-start-reverse" refx="8" refy="5" viewbox="0 0 10 10">
                                            <path d="M 0 1 L 10 5 L 0 9 z" fill="#ffb956"></path>
                                        </marker>
                                        <!-- Arrowhead Secondary -->
                                        <marker id="arrow-sec" markerheight="6" markerwidth="6" orient="auto-start-reverse" refx="8" refy="5" viewbox="0 0 10 10">
                                            <path d="M 0 1 L 10 5 L 0 9 z" fill="#abc9f2"></path>
                                        </marker>
                                        <!-- Arrowhead Slate/Dim -->
                                        <marker id="arrow-slate" markerheight="6" markerwidth="6" orient="auto-start-reverse" refx="8" refy="5" viewbox="0 0 10 10">
                                            <path d="M 0 1 L 10 5 L 0 9 z" fill="#43474c"></path>
                                        </marker>
                                    </defs>
                                    <!-- Line: Start -> KB -->
                                    <path d="M 115 160 C 145 160, 155 100, 195 100" fill="none" marker-end="url(#arrow-sec)" stroke="#abc9f2" stroke-dasharray="3 3" stroke-width="1.75"></path>
                                    <!-- Line: Start -> Account Tool -->
                                    <path d="M 115 160 C 145 160, 155 220, 195 220" fill="none" marker-end="url(#arrow-sec)" stroke="#abc9f2" stroke-width="1.75"></path>
                                    <!-- Line: KB -> Supervisor -->
                                    <path d="M 365 100 C 395 100, 405 160, 435 160" fill="none" marker-end="url(#arrow-sec)" stroke="#abc9f2" stroke-width="1.75"></path>
                                    <!-- Line: Account -> Supervisor -->
                                    <path d="M 365 220 C 395 220, 405 160, 435 160" fill="none" marker-end="url(#arrow-amber)" stroke="#ffb956" stroke-width="2"></path>
                                    <!-- Branch Line: Supervisor -> Ticket (Risk >= 0.70) -->
                                    <path d="M 605 145 C 635 145, 645 80, 675 80" fill="none" marker-end="url(#arrow-amber)" stroke="#ffb956" stroke-width="2"></path>
                                    <!-- Branch Line: Supervisor -> Draft Offer (Risk < 0.70) -->
                                    <path d="M 605 175 C 635 175, 645 240, 675 240" fill="none" marker-end="url(#arrow-sec)" stroke="#abc9f2" stroke-width="1.75"></path>
                                    <!-- Converge: Ticket -> Guardrail -->
                                    <path d="M 845 80 C 875 80, 885 145, 915 145" fill="none" marker-end="url(#arrow-sec)" stroke="#abc9f2" stroke-width="1.75"></path>
                                    <!-- Converge: Draft Offer -> Guardrail -->
                                    <path d="M 845 240 C 875 240, 885 175, 915 175" fill="none" marker-end="url(#arrow-amber)" stroke="#ffb956" stroke-width="2"></path>
                                    <!-- Line: Guardrail -> End -->
                                    <path d="M 1085 160 L 1120 160" fill="none" marker-end="url(#arrow-sec)" stroke="#abc9f2" stroke-width="2"></path>
                                </svg>
                                <!-- Interactive Node Canvas Container -->
                                <div class="relative z-10 flex items-center gap-8 min-w-[1180px] py-8">
                                    <!-- NODE 1: __start__ -->
                                    <div class="flex flex-col items-center">
                                        <div class="w-24 bg-surface-container-high rounded-xl p-space-sm flex flex-col items-center text-center shadow-lg hover:scale-105 transition-transform cursor-pointer">
                                            <div class="w-8 h-8 rounded-full bg-secondary-container flex items-center justify-center text-secondary mb-1">
                                                <span class="material-symbols-outlined text-base">login</span>
                                            </div>
                                            <span class="font-code-sm text-code-sm text-on-surface font-mono font-bold">__start__</span>
                                            <span class="text-[10px] font-mono text-outline mt-0.5">Payload Ingest</span>
                                        </div>
                                    </div>
                                    <!-- PARALLEL STAGE 1: Retrieval & Tool Execution -->
                                    <div class="flex flex-col gap-10">
                                        <!-- NODE 2: Search Knowledge Base -->
                                        <div class="w-48 bg-surface-container-high rounded-xl p-space-sm flex flex-col gap-1.5 shadow-lg hover:bg-surface-bright transition-all cursor-pointer">
                                            <div class="flex items-center justify-between">
                                                <span class="px-1.5 py-0.5 rounded bg-surface-container-lowest font-code-sm text-code-sm text-secondary-fixed font-mono">RAG·NODE</span>
                                                <span class="font-code-sm text-code-sm text-outline font-mono">124ms</span>
                                            </div>
                                            <div class="flex items-center gap-1.5">
                                                <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                                                <span class="font-title-sm text-title-sm text-on-surface font-medium truncate">Search KB</span>
                                            </div>
                                            <div class="text-[10px] font-mono text-on-surface-variant flex flex-col gap-0.5">
                                                <span>BM25 + Qdrant Dense</span>
                                                <span class="text-tertiary">BGE-reranker-large</span>
                                            </div>
                                        </div>
                                        <!-- NODE 3: Check Account & CDRs -->
                                        <div class="w-48 bg-surface-container-high rounded-xl p-space-sm flex flex-col gap-1.5 shadow-lg hover:bg-surface-bright transition-all cursor-pointer">
                                            <div class="flex items-center justify-between">
                                                <span class="px-1.5 py-0.5 rounded bg-surface-container-lowest font-code-sm text-code-sm text-primary font-mono">TOOL·NODE</span>
                                                <span class="font-code-sm text-code-sm text-tertiary font-mono">289ms</span>
                                            </div>
                                            <div class="flex items-center gap-1.5">
                                                <span class="w-2 h-2 rounded-full bg-tertiary animate-pulse"></span>
                                                <span class="font-title-sm text-title-sm text-on-surface font-medium truncate">Check Account CDR</span>
                                            </div>
                                            <div class="text-[10px] font-mono text-on-surface-variant flex flex-col gap-0.5">
                                                <span>SQL Billing &amp; Usage</span>
                                                <span class="text-emerald-400">status: active_churn_risk</span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- NODE 4: Conditional Router Supervisor -->
                                    <div class="flex flex-col items-center">
                                        <div class="w-52 bg-surface-container-high rounded-xl p-space-sm flex flex-col gap-2 shadow-xl ring-2 ring-tertiary/40 cursor-pointer">
                                            <div class="flex items-center justify-between">
                                                <span class="px-1.5 py-0.5 rounded bg-tertiary-container font-code-sm text-code-sm text-tertiary-fixed font-mono font-semibold">ROUTER·LLM</span>
                                                <span class="font-code-sm text-code-sm text-secondary font-mono">310ms</span>
                                            </div>
                                            <div class="flex items-center gap-1.5">
                                                <span class="w-2 h-2 rounded-full bg-tertiary"></span>
                                                <span class="font-title-sm text-title-sm text-on-surface font-semibold">Reasoning Supervisor</span>
                                            </div>
                                            <p class="font-body-sm text-body-sm text-on-surface-variant text-[11px] leading-tight">
                                                Evaluates churn severity, SLA penalties, and customer tenure.
                                            </p>
                                            <div class="bg-surface-container-lowest p-1.5 rounded flex flex-col gap-1 text-[10px] font-mono">
                                                <div class="flex items-center justify-between text-tertiary">
                                                    <span>cond: risk ≥ 0.70</span>
                                                    <span class="material-symbols-outlined text-xs">arrow_upward</span>
                                                </div>
                                                <div class="flex items-center justify-between text-secondary">
                                                    <span>cond: risk &lt; 0.70</span>
                                                    <span class="material-symbols-outlined text-xs">arrow_downward</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- PARALLEL STAGE 2: Action Branches -->
                                    <div class="flex flex-col gap-10">
                                        <!-- NODE 5: Create Retention Ticket -->
                                        <div class="w-48 bg-surface-container-high rounded-xl p-space-sm flex flex-col gap-1.5 shadow-lg hover:bg-surface-bright transition-all cursor-pointer">
                                            <div class="flex items-center justify-between">
                                                <span class="px-1.5 py-0.5 rounded bg-surface-container-lowest font-code-sm text-code-sm text-error font-mono">CRM·DISPATCH</span>
                                                <span class="font-code-sm text-code-sm text-outline font-mono">180ms</span>
                                            </div>
                                            <div class="flex items-center gap-1.5">
                                                <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                                                <span class="font-title-sm text-title-sm text-on-surface font-medium truncate">Create Ticket</span>
                                            </div>
                                            <div class="text-[10px] font-mono text-on-surface-variant flex flex-col gap-0.5">
                                                <span>Zendesk Tier-2 Queue</span>
                                                <span class="text-outline">Priority: CRITICAL</span>
                                            </div>
                                        </div>
                                        <!-- NODE 6: Draft Tailored Offer -->
                                        <div class="w-48 bg-surface-container-high rounded-xl p-space-sm flex flex-col gap-1.5 shadow-lg hover:bg-surface-bright transition-all cursor-pointer">
                                            <div class="flex items-center justify-between">
                                                <span class="px-1.5 py-0.5 rounded bg-surface-container-lowest font-code-sm text-code-sm text-tertiary font-mono">GEN·LLM</span>
                                                <span class="font-code-sm text-code-sm text-outline font-mono">420ms</span>
                                            </div>
                                            <div class="flex items-center gap-1.5">
                                                <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                                                <span class="font-title-sm text-title-sm text-on-surface font-medium truncate">Draft Offer</span>
                                            </div>
                                            <div class="text-[10px] font-mono text-on-surface-variant flex flex-col gap-0.5">
                                                <span>VOSTOK-8B Retention</span>
                                                <span class="text-secondary-fixed">Few-shot offer prompt</span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- NODE 7: Safety & Guardrail -->
                                    <div class="flex flex-col items-center">
                                        <div class="w-48 bg-surface-container-high rounded-xl p-space-sm flex flex-col gap-1.5 shadow-lg hover:bg-surface-bright transition-all cursor-pointer">
                                            <div class="flex items-center justify-between">
                                                <span class="px-1.5 py-0.5 rounded bg-surface-container-lowest font-code-sm text-code-sm text-secondary font-mono">RAIL·GUARD</span>
                                                <span class="font-code-sm text-code-sm text-outline font-mono">44ms</span>
                                            </div>
                                            <div class="flex items-center gap-1.5">
                                                <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                                                <span class="font-title-sm text-title-sm text-on-surface font-medium truncate">NeMo Guardrail</span>
                                            </div>
                                            <div class="text-[10px] font-mono text-on-surface-variant flex flex-col gap-0.5">
                                                <span>PII &amp; Constraint Check</span>
                                                <span class="text-emerald-400">Status: PASS (0 flags)</span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- NODE 8: __end__ -->
                                    <div class="flex flex-col items-center">
                                        <div class="w-24 bg-surface-container-high rounded-xl p-space-sm flex flex-col items-center text-center shadow-lg hover:scale-105 transition-transform cursor-pointer">
                                            <div class="w-8 h-8 rounded-full bg-surface-container-lowest flex items-center justify-center text-tertiary mb-1">
                                                <span class="material-symbols-outlined text-base">task_alt</span>
                                            </div>
                                            <span class="font-code-sm text-code-sm text-on-surface font-mono font-bold">__end__</span>
                                            <span class="text-[10px] font-mono text-emerald-400 mt-0.5">200 OK</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Canvas Footer Status Strip -->
                            <div class="flex items-center justify-between pt-space-xs text-code-sm font-code-sm font-mono text-outline">
                                <div class="flex items-center gap-space-md">
                                    <span class="flex items-center gap-1.5">
                                        <span class="w-2 h-2 rounded bg-tertiary"></span> Active Conditional Node: Supervisor
                                    </span>
                                    <span class="flex items-center gap-1.5">
                                        <span class="w-2 h-2 rounded bg-emerald-400"></span> Completed Execution Chain
                                    </span>
                                </div>
                                <div>Graph Hash: 0x9f88c2d1b · Checkpoint Memory: In-Memory Sqlite</div>
                            </div>
                        </div>
                        <!-- DOCKED PANEL: PROMPT PLAYGROUND & TRACE RUNNER -->
                        <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-md flex flex-col gap-space-sm">
                            <div class="flex flex-wrap items-center justify-between gap-space-sm">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-secondary text-lg">terminal</span>
                                    <span class="font-title-sm text-title-sm text-on-surface uppercase tracking-wide">Playground &amp; Execution Trace</span>
                                </div>
                                <!-- Playground Param Sliders / Badges -->
                                <div class="flex items-center gap-space-sm font-mono text-code-sm">
                                    <span class="px-2 py-0.5 rounded bg-surface-container-high text-on-surface-variant">temp: <span class="text-tertiary font-bold">0.20</span></span>
                                    <span class="px-2 py-0.5 rounded bg-surface-container-high text-on-surface-variant">top_p: <span class="text-tertiary font-bold">0.95</span></span>
                                    <span class="px-2 py-0.5 rounded bg-surface-container-high text-on-surface-variant">max_tokens: <span class="text-tertiary font-bold">1024</span></span>
                                    <button class="px-3 py-1 rounded bg-secondary text-on-secondary text-label-sm font-label-sm uppercase font-semibold flex items-center gap-1 shadow">
                                        <span class="material-symbols-outlined text-sm">play_circle</span>
                                        <span>Run Trace</span>
                                    </button>
                                </div>
                            </div>
                            <!-- Split: Test Case Input vs System Prompt vs Trace Stream -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-space-sm pt-space-xs">
                                <!-- Column 1: Test Case Casefile -->
                                <div class="bg-surface-container-low rounded-lg p-space-sm flex flex-col gap-2">
                                    <div class="flex items-center justify-between">
                                        <span class="font-label-sm text-label-sm text-outline uppercase font-mono">Case Input #8491</span>
                                        <span class="px-1.5 py-0.5 rounded bg-error-container text-on-error-container text-[10px] font-mono font-semibold">HIGH CHURN</span>
                                    </div>
                                    <div class="bg-surface-container-lowest rounded p-2 text-code-sm font-code-sm text-on-surface-variant font-mono flex flex-col gap-1">
                                        <div><span class="text-outline">customer_id:</span> <span class="text-tertiary">"CUST-8491-X"</span></div>
                                        <div><span class="text-outline">tenure_months:</span> 38</div>
                                        <div><span class="text-outline">monthly_drop:</span> -45.2%</div>
                                        <div><span class="text-outline">sentiment:</span> "highly_dissatisfied"</div>
                                        <div><span class="text-outline">query:</span> "My rate went up $28 without notice. Cancel my service immediately."</div>
                                    </div>
                                </div>
                                <!-- Column 2: Live Prompt Definition -->
                                <div class="bg-surface-container-low rounded-lg p-space-sm flex flex-col gap-2">
                                    <div class="flex items-center justify-between">
                                        <span class="font-label-sm text-label-sm text-outline uppercase font-mono">System Prompt Config</span>
                                        <span class="text-code-sm font-code-sm text-secondary font-mono">Prompt v3.1</span>
                                    </div>
                                    <textarea class="w-full h-28 bg-surface-container-lowest text-code-sm font-code-sm text-on-surface p-2 rounded border-0 resize-none font-mono focus:outline-none focus:ring-1 focus:ring-tertiary" readonly="">You are VOSTOKPRIBOR Churn Retention Assistant. Abide by Directive #AI-024.
Analyze customer SLA history. If churn risk &gt;= 0.70 and sentiment is negative, draft compensation waiver of 20% max and open CRM retention ticket immediately.</textarea>
                                </div>
                                <!-- Column 3: Live Trace Stream Output -->
                                <div class="bg-surface-container-low rounded-lg p-space-sm flex flex-col gap-2">
                                    <div class="flex items-center justify-between">
                                        <span class="font-label-sm text-label-sm text-outline uppercase font-mono">Live Execution Trace</span>
                                        <span class="flex items-center gap-1 text-[10px] font-mono text-emerald-400">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-ping"></span> COMPLETED (822ms)
                                        </span>
                                    </div>
                                    <div class="h-28 overflow-y-auto bg-surface-container-lowest rounded p-2 text-code-sm font-code-sm font-mono flex flex-col gap-1 text-on-surface">
                                        <div class="text-outline">[00:00.041] State graph checkpoint: START</div>
                                        <div class="text-secondary-fixed">[00:00.165] Search KB completed -&gt; 3 docs (cos: 0.912)</div>
                                        <div class="text-secondary-fixed">[00:00.454] Tool CDR: Billing delta found +$28.14</div>
                                        <div class="text-tertiary">[00:00.764] Supervisor: Condition matched 'Risk &gt;= 0.70'</div>
                                        <div class="text-emerald-400">[00:00.944] CRM Ticket #ZD-481920 spawned</div>
                                        <div class="text-on-surface-variant">[00:01.364] NeMo Rail: No PII leak, 0 compliance faults</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- RIGHT PANEL (35-38% width) -->
                    <div class="lg:col-span-5 xl:col-span-4 flex flex-col gap-space-md">
                        <!-- SECTION 1: RAG & VECTOR RETRIEVAL SETTINGS -->
                        <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-md flex flex-col gap-space-sm">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-secondary text-lg">dataset</span>
                                    <span class="font-title-sm text-title-sm text-on-surface uppercase tracking-wide">Vector &amp; Retrieval Engine</span>
                                </div>
                                <span class="px-2 py-0.5 rounded bg-surface-container-high text-code-sm font-code-sm text-emerald-400 font-mono">QDRANT CONNECTED</span>
                            </div>
                            <!-- Vector Specs Bento Grid -->
                            <div class="grid grid-cols-2 gap-space-xs text-code-sm font-code-sm font-mono pt-1">
                                <div class="bg-surface-container-low p-2 rounded flex flex-col">
                                    <span class="text-outline text-[10px] uppercase">Target Collection</span>
                                    <span class="text-on-surface font-semibold truncate">telecom_retention_kb_v3</span>
                                </div>
                                <div class="bg-surface-container-low p-2 rounded flex flex-col">
                                    <span class="text-outline text-[10px] uppercase">Vectors / Index</span>
                                    <span class="text-secondary-fixed">42,800 · HNSW Cosine</span>
                                </div>
                                <div class="bg-surface-container-low p-2 rounded flex flex-col">
                                    <span class="text-outline text-[10px] uppercase">Chunk Topology</span>
                                    <span class="text-on-surface">512 tokens (64 overlap)</span>
                                </div>
                                <div class="bg-surface-container-low p-2 rounded flex flex-col">
                                    <span class="text-outline text-[10px] uppercase">Embeddings</span>
                                    <span class="text-tertiary">voyage-3-large (1024d)</span>
                                </div>
                            </div>
                            <!-- Live Retrieval Probe (Top 3 Documents) -->
                            <div class="flex flex-col gap-1.5 pt-space-xs">
                                <div class="flex items-center justify-between text-label-sm font-label-sm uppercase font-mono text-outline">
                                    <span>Retrieved Chunks Probe</span>
                                    <span>Rerank Score (Cutoff ≥ 0.72)</span>
                                </div>
                                <!-- Doc 1 -->
                                <div class="bg-surface-container-low p-2.5 rounded-lg flex flex-col gap-1 hover:bg-surface-container transition-colors">
                                    <div class="flex items-center justify-between text-code-sm font-code-sm font-mono">
                                        <span class="text-tertiary font-semibold">doc_id: #RET-POL-2024-Q3</span>
                                        <span class="px-1.5 py-0.5 rounded bg-emerald-950 text-emerald-400 text-[10px]">SIM: 0.912</span>
                                    </div>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant line-clamp-2 text-[12px]">
                                        "For subscribers with tenure &gt; 36 months impacted by Q3 tariff migration, offer retention rebate code <code>REB-20-ANNUAL</code> with 12mo contract renewal."
                                    </p>
                                </div>
                                <!-- Doc 2 -->
                                <div class="bg-surface-container-low p-2.5 rounded-lg flex flex-col gap-1 hover:bg-surface-container transition-colors">
                                    <div class="flex items-center justify-between text-code-sm font-code-sm font-mono">
                                        <span class="text-on-surface font-semibold">doc_id: #BILLING-SLA-DISPUTES</span>
                                        <span class="px-1.5 py-0.5 rounded bg-emerald-950 text-emerald-400 text-[10px]">SIM: 0.884</span>
                                    </div>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant line-clamp-2 text-[12px]">
                                        "Unnotified price adjustment disputes require immediate credit waiver validation if filed within 60 calendar days of billing event."
                                    </p>
                                </div>
                                <!-- Doc 3 -->
                                <div class="bg-surface-container-low p-2.5 rounded-lg flex flex-col gap-1 hover:bg-surface-container transition-colors">
                                    <div class="flex items-center justify-between text-code-sm font-code-sm font-mono">
                                        <span class="text-on-surface font-semibold">doc_id: #ESCALATION-JIRA-PROTOCOL</span>
                                        <span class="px-1.5 py-0.5 rounded bg-surface-container text-secondary text-[10px]">SIM: 0.841</span>
                                    </div>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant line-clamp-2 text-[12px]">
                                        "High churn sentiment alerts trigger Tier-2 supervisor assignment with mandatory 2-hour SLA response turnaround."
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- SECTION 2: RAGAS EVALUATION & HALLUCINATION TELEMETRY PANEL -->
                        <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-md flex flex-col gap-space-sm flex-1">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-tertiary text-lg">verified</span>
                                    <span class="font-title-sm text-title-sm text-on-surface uppercase tracking-wide">Ragas Evaluation Telemetry</span>
                                </div>
                                <span class="px-2 py-0.5 rounded bg-surface-container text-label-sm font-label-sm uppercase text-outline font-mono">
                                    500 EVAL SAMPLES
                                </span>
                            </div>
                            <div class="text-code-sm font-code-sm font-mono text-outline">
                                Golden Dataset: <span class="text-on-surface">churn_golden_eval_q3.jsonl</span>
                            </div>
                            <!-- 5 Core Ragas Metrics Bars -->
                            <div class="flex flex-col gap-space-sm pt-1">
                                <!-- Metric 1: Faithfulness -->
                                <div class="flex flex-col gap-1 bg-surface-container-low p-2 rounded">
                                    <div class="flex items-center justify-between font-mono text-code-sm">
                                        <span class="text-on-surface flex items-center gap-1.5">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Faithfulness
                                        </span>
                                        <div class="flex items-center gap-2">
                                            <span class="text-outline text-[11px]">(Target ≥ 0.900)</span>
                                            <span class="text-emerald-400 font-bold">0.942</span>
                                        </div>
                                    </div>
                                    <div class="w-full h-1.5 bg-surface-container-highest rounded-full overflow-hidden">
                                        <div class="h-full bg-emerald-400 rounded-full" style="width: 94.2%"></div>
                                    </div>
                                </div>
                                <!-- Metric 2: Answer Relevancy -->
                                <div class="flex flex-col gap-1 bg-surface-container-low p-2 rounded">
                                    <div class="flex items-center justify-between font-mono text-code-sm">
                                        <span class="text-on-surface flex items-center gap-1.5">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Answer Relevancy
                                        </span>
                                        <div class="flex items-center gap-2">
                                            <span class="text-outline text-[11px]">(Target ≥ 0.850)</span>
                                            <span class="text-emerald-400 font-bold">0.918</span>
                                        </div>
                                    </div>
                                    <div class="w-full h-1.5 bg-surface-container-highest rounded-full overflow-hidden">
                                        <div class="h-full bg-emerald-400 rounded-full" style="width: 91.8%"></div>
                                    </div>
                                </div>
                                <!-- Metric 3: Context Precision -->
                                <div class="flex flex-col gap-1 bg-surface-container-low p-2 rounded">
                                    <div class="flex items-center justify-between font-mono text-code-sm">
                                        <span class="text-on-surface flex items-center gap-1.5">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Context Precision
                                        </span>
                                        <div class="flex items-center gap-2">
                                            <span class="text-outline text-[11px]">(Target ≥ 0.850)</span>
                                            <span class="text-emerald-400 font-bold">0.894</span>
                                        </div>
                                    </div>
                                    <div class="w-full h-1.5 bg-surface-container-highest rounded-full overflow-hidden">
                                        <div class="h-full bg-emerald-400 rounded-full" style="width: 89.4%"></div>
                                    </div>
                                </div>
                                <!-- Metric 4: Context Recall -->
                                <div class="flex flex-col gap-1 bg-surface-container-low p-2 rounded">
                                    <div class="flex items-center justify-between font-mono text-code-sm">
                                        <span class="text-on-surface flex items-center gap-1.5">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Context Recall
                                        </span>
                                        <div class="flex items-center gap-2">
                                            <span class="text-outline text-[11px]">(Target ≥ 0.800)</span>
                                            <span class="text-emerald-400 font-bold">0.876</span>
                                        </div>
                                    </div>
                                    <div class="w-full h-1.5 bg-surface-container-highest rounded-full overflow-hidden">
                                        <div class="h-full bg-emerald-400 rounded-full" style="width: 87.6%"></div>
                                    </div>
                                </div>
                                <!-- Metric 5: Hallucination Rate -->
                                <div class="flex flex-col gap-1 bg-surface-container-low p-2 rounded">
                                    <div class="flex items-center justify-between font-mono text-code-sm">
                                        <span class="text-on-surface flex items-center gap-1.5">
                                            <span class="w-1.5 h-1.5 rounded-full bg-tertiary"></span> Hallucination Rate
                                        </span>
                                        <div class="flex items-center gap-2">
                                            <span class="text-outline text-[11px]">(Max Allowed ≤ 3.0%)</span>
                                            <span class="text-tertiary font-bold">1.8%</span>
                                        </div>
                                    </div>
                                    <div class="w-full h-1.5 bg-surface-container-highest rounded-full overflow-hidden">
                                        <div class="h-full bg-tertiary rounded-full" style="width: 28%"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- Hallucination & Factuality Breakdown -->
                            <div class="bg-surface-container-low p-2.5 rounded-lg flex flex-col gap-1.5 mt-auto">
                                <div class="flex items-center justify-between text-code-sm font-code-sm font-mono">
                                    <span class="text-outline">Groundedness Check:</span>
                                    <span class="text-emerald-400 font-semibold">98.2% attributed</span>
                                </div>
                                <div class="flex items-center justify-between text-code-sm font-code-sm font-mono">
                                    <span class="text-outline">Unwarranted Commitments:</span>
                                    <span class="text-emerald-400 font-semibold">0 flags / 100 runs</span>
                                </div>
                                <div class="flex items-center justify-between text-code-sm font-code-sm font-mono">
                                    <span class="text-outline">NeMo Rail Latency:</span>
                                    <span class="text-secondary-fixed font-semibold">44ms avg</span>
                                </div>
                            </div>
                            <!-- Action Dispatch Cluster -->
                            <div class="flex flex-col gap-2 pt-space-xs">
                                <button class="w-full h-10 rounded-lg bg-tertiary hover:bg-tertiary-fixed text-on-tertiary text-label-sm font-label-sm uppercase font-semibold flex items-center justify-center gap-2 transition-all shadow-md">
                                    <span class="material-symbols-outlined text-base">rocket_launch</span>
                                    <span>Deploy Agent to SYS-AI-04 Canary</span>
                                </button>
                                <button class="w-full h-9 rounded-lg bg-surface-container-high hover:bg-surface-bright text-on-surface-variant hover:text-on-surface text-label-sm font-label-sm uppercase flex items-center justify-center gap-2 transition-colors">
                                    <span class="material-symbols-outlined text-base">security</span>
                                    <span>Run Adversarial Red-Team Sweep</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- BOTTOM STATUS & TELEMETRY FOOTER -->
                <footer class="w-full bg-surface-container-low rounded-xl p-space-sm shadow-md flex flex-wrap items-center justify-between gap-space-md text-code-sm font-code-sm font-mono">
                    <div class="flex flex-wrap items-center gap-space-lg">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-tertiary text-base">memory</span>
                            <span class="text-outline">CLUSTER:</span>
                            <span class="text-on-surface">NVIDIA H100 SXM5</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-outline">VRAM ALLOCATED:</span>
                            <span class="text-secondary-fixed">42.1 GB / 80.0 GB</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-outline">CUDA:</span>
                            <span class="text-on-surface">12.4</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-outline">FRAMEWORK:</span>
                            <span class="text-tertiary">LangGraph v0.2.14 + LangChain Core</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-space-md">
                        <div class="flex items-center gap-2 bg-surface-container px-space-sm py-1 rounded border-0">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 shadow-[0_0_6px_rgba(46,158,107,0.8)]"></span>
                            <span class="text-on-surface text-[11px] font-semibold tracking-wider uppercase">AIR-GAP COMPLIANCE VERIFIED · DIRECTIVE #AI-024</span>
                        </div>
                        <span class="text-outline">NODE: ORB-CLUSTER-09</span>
                    </div>
                </footer>
            </div>
            
        </main>
    </div>
    <script src="../../assets/js/app.js"></script>
    <script src="js/main.js"></script>
</body>

</html>