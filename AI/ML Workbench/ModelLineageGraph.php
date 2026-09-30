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
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@100..900&amp;family=Inter:wght@100..900&amp;family=JetBrains+Mono:wght@100..800&amp;display=swap" rel="stylesheet" />
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
                <nav class="flex flex-col gap-1" data-active-classes="bg-surface-container-high text-on-surface font-semibold shadow-inner"><a class="group flex items-center justify-between px-space-md py-2 rounded text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-all" data-path="projects" href="../../AI Project Management/Dashboard.php"><span class="font-body-sm text-body-sm">SYS-AI-01 Projects</span><span class="font-code-sm text-code-sm text-outline-variant font-mono">PROJ</span></a><a class="group flex items-center justify-between px-space-md py-2 rounded text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-all" data-path="data-center" href="../../Data Center/DatasetCatalog.php"><span class="font-body-sm text-body-sm">SYS-AI-02 Data Center</span><span class="font-code-sm text-code-sm text-outline-variant font-mono">DATA</span></a><a class="group flex items-center justify-between px-space-md py-2 rounded text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-all" data-path="sys-ai-03-workbench-home" href="WorkbenchHome.php"><span class="font-body-sm text-body-sm">SYS-AI-03 Workbench Home</span><span class="font-code-sm text-code-sm text-outline-variant font-mono">BASE</span></a><a class="group flex items-center justify-between px-space-md py-2 rounded text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-all" data-path="sys-ai-03-experiment-builder" href="#"><span class="font-body-sm text-body-sm">SYS-AI-03 Experiment Builder</span><span class="font-code-sm text-code-sm text-outline-variant font-mono">PIPE</span></a><a class="group flex items-center justify-between px-space-md py-2 rounded text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-all" data-path="sys-ai-03-run-results-hero-screen" href="#"><span class="font-body-sm text-body-sm">SYS-AI-03 Run Results</span><span class="font-code-sm text-code-sm text-outline-variant font-mono">EXEC</span></a><a class="group flex items-center justify-between px-space-md py-2 rounded text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-all" data-path="sys-ai-03-compare-runs" href="#"><span class="font-body-sm text-body-sm">SYS-AI-03 Compare Runs</span><span class="font-code-sm text-code-sm text-outline-variant font-mono">DIFF</span></a><a aria-current="page" class="group flex items-center justify-between px-space-md py-2 rounded transition-all bg-surface-container-high text-on-surface font-semibold shadow-inner" data-path="sys-ai-03-model-lineage-graph" href="#"><span class="font-body-sm text-body-sm">SYS-AI-03 Model Lineage</span><span class="font-code-sm text-code-sm text-outline-variant font-mono">TREE</span></a><a class="group flex items-center justify-between px-space-md py-2 rounded text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-all" data-path="registry-deployment" href="../../Model Registry & Deployment/ModelRegistry.php"><span class="font-body-sm text-body-sm">SYS-AI-04 Registry &amp; Deploy</span><span class="font-code-sm text-code-sm text-outline-variant font-mono">DPLY</span></a><a class="group flex items-center justify-between px-space-md py-2 rounded text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-all" data-path="ai-soc" href="../../AI Operations Center (AI SOC)/FleetTelemetry.php"><span class="font-body-sm text-body-sm">SYS-AI-05 AI SOC Ops</span><span class="font-code-sm text-code-sm text-outline-variant font-mono">SECO</span></a></nav>
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
                    <div class="relative w-80"><span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-lg">search</span><input class="w-full h-9 pl-9 pr-3 rounded bg-surface-container-low border border-outline-variant/50 text-code-sm font-code-sm text-on-surface placeholder:text-outline focus:outline-none focus:border-tertiary transition-colors" placeholder="Search experiments, lineage, models... /" type="text" /></div>
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
                <div class="flex items-center shrink-0 px-2 py-1 text-outline font-mono">6. Pipeline Prep</div><span class="text-outline-variant">›</span>
                <div class="flex items-center shrink-0 px-2 py-1 text-outline font-mono">7. Architecture</div><span class="text-outline-variant">›</span>
                <div class="flex items-center shrink-0 px-2 py-1 text-outline font-mono">8. Hyperparam</div><span class="text-tertiary">›</span>
                <a href="RunResults.php" class="flex items-center shrink-0 px-2 py-1 rounded bg-secondary-container/80 text-secondary-fixed font-mono border border-secondary/40 shadow-sm hover:scale-105 transition-transform">9. Eval & Validate</a><span class="text-tertiary">›</span>
                <div class="flex items-center shrink-0 px-2 py-1 rounded bg-tertiary-container text-tertiary-fixed font-mono border border-tertiary/60 shadow-[0_0_10px_rgba(255,185,86,0.3)]">10. Lineage &amp; XAI</div><span class="text-tertiary">›</span>
                <div class="flex items-center shrink-0 px-2 py-1 rounded bg-secondary-container/80 text-secondary-fixed font-mono border border-secondary/40 shadow-sm">11. Registry</div><span class="text-outline-variant">›</span>
                <div class="flex items-center shrink-0 px-2 py-1 text-outline font-mono">12. Canary</div><span class="text-outline-variant">›</span>
                <div class="flex items-center shrink-0 px-2 py-1 text-outline font-mono">13. Production</div><span class="text-outline-variant">›</span>
                <a href="../../AI Operations Center (AI SOC)/DriftInvestigationWorkspace.php" class="flex items-center shrink-0 px-2 py-1 text-outline hover:text-rose-400 font-mono transition-colors">14. Drift</a>
            </div>
        </header>
        <main class="w-full pt-28 bg-surface flex-1 min-h-[calc(100vh-7rem)] p-space-md">
            <div class="flex flex-col w-full text-on-surface">
                <!-- 1. Header Bar / Context Ribbon -->
                <div class="flex flex-col gap-space-sm pb-space-md">
                    <div class="flex flex-wrap items-center justify-between gap-space-md bg-surface-container-low p-space-md rounded-xl shadow-sm">
                        <div class="flex flex-col gap-1">
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-0.5 rounded bg-tertiary-container text-tertiary font-code-sm text-code-sm uppercase tracking-wider font-semibold">
                                    SYS-AI-03 // ARTIFACT PROVENANCE &amp; LINEAGE DAG
                                </span>
                                <span class="px-2 py-0.5 rounded bg-surface-container-high text-on-surface-variant font-code-sm text-code-sm">
                                    TICKET: #AI-024 Customer Churn · F1 ≥ 0.800
                                </span>
                                <div class="flex items-center gap-1.5 px-2 py-0.5 rounded bg-emerald-950/70 text-emerald-400 font-code-sm text-code-sm">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-ping"></span>
                                    <span>SHA-256 AUDIT VERIFIED</span>
                                </div>
                            </div>
                            <h1 class="font-headline-lg text-headline-lg text-on-surface tracking-tight font-semibold">
                                Model Lineage &amp; Cryptographic Provenance Graph
                            </h1>
                        </div>
                        <!-- Controls & Filters -->
                        <div class="flex flex-wrap items-center gap-space-sm">
                            <!-- View Toggle Pills -->
                            <div class="flex items-center p-1 rounded-lg bg-surface-container-highest shadow-inner">
                                <button class="dag-view-btn px-3 py-1.5 rounded text-label-sm font-label-sm bg-primary-container text-primary font-semibold transition-all" id="viewCompact" onclick="switchDAGView('compact')">
                                    COMPACT DAG
                                </button>
                                <button class="dag-view-btn px-3 py-1.5 rounded text-label-sm font-label-sm text-on-surface-variant hover:text-on-surface transition-all" id="viewDetailed" onclick="switchDAGView('detailed')">
                                    DETAILED GRAPH
                                </button>
                                <button class="dag-view-btn px-3 py-1.5 rounded text-label-sm font-label-sm text-on-surface-variant hover:text-on-surface transition-all" id="viewManifest" onclick="switchDAGView('manifest')">
                                    RAW JSON-LD
                                </button>
                            </div>
                            <!-- Filter Runs -->
                            <div class="flex items-center gap-1 bg-surface-container px-2 py-1.5 rounded-lg">
                                <span class="material-symbols-outlined text-outline text-sm">filter_alt</span>
                                <span class="font-label-sm text-label-sm text-outline uppercase mr-1">Trace:</span>
                                <button class="px-2 py-0.5 rounded bg-tertiary text-on-tertiary font-code-sm text-code-sm font-semibold shadow-sm" onclick="highlightPath('run-02')">
                                    Run #02 (SLA Met)
                                </button>
                                <button class="px-2 py-0.5 rounded bg-surface-container-high text-on-surface-variant hover:text-on-surface font-code-sm text-code-sm transition-colors" onclick="highlightPath('run-03')">
                                    Run #03 (Apex)
                                </button>
                                <button class="px-2 py-0.5 rounded bg-surface-container-high text-on-surface-variant hover:text-on-surface font-code-sm text-code-sm transition-colors" onclick="highlightPath('run-01')">
                                    Run #01 (Archived)
                                </button>
                                <button class="px-2 py-0.5 rounded bg-surface-container-high text-outline hover:text-on-surface font-code-sm text-code-sm transition-colors" onclick="highlightPath('all')">
                                    Reset
                                </button>
                            </div>
                            <!-- Canvas Controls -->
                            <div class="flex items-center gap-1 bg-surface-container-high rounded-lg p-1">
                                <button class="w-7 h-7 flex items-center justify-center rounded hover:bg-surface-container-highest text-on-surface-variant" onclick="adjustZoom(-0.1)" title="Zoom Out">
                                    <span class="material-symbols-outlined text-base">zoom_out</span>
                                </button>
                                <span class="font-code-sm text-code-sm px-1.5 text-on-surface font-mono min-w-[48px] text-center" id="zoomLevelDisplay">100%</span>
                                <button class="w-7 h-7 flex items-center justify-center rounded hover:bg-surface-container-highest text-on-surface-variant" onclick="adjustZoom(0.1)" title="Zoom In">
                                    <span class="material-symbols-outlined text-base">zoom_in</span>
                                </button>
                                <button class="px-2 py-1 rounded hover:bg-surface-container-highest text-label-sm font-label-sm text-on-surface-variant" onclick="resetZoom()" title="Reset 100%">
                                    1:1
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- 2. Main Interactive DAG Canvas -->
                <div class="relative w-full rounded-xl bg-surface-container-lowest overflow-hidden shadow-xl min-h-[560px] flex flex-col">
                    <!-- Graph Background Grid & Status Readout -->
                    <div class="absolute inset-0 bg-[radial-gradient(#1f3651_1px,transparent_1px)] [background-size:24px_24px] pointer-events-none opacity-40"></div>
                    <!-- Canvas Overlays: Floating Legend & Status Pin -->
                    <div class="absolute top-4 left-4 z-20 flex items-center gap-space-sm bg-surface-container/90 backdrop-blur-md px-3 py-1.5 rounded-lg shadow-sm">
                        <div class="flex items-center gap-1.5 font-code-sm text-code-sm text-tertiary">
                            <span class="w-2.5 h-2.5 rounded-full bg-tertiary ring-2 ring-tertiary/20"></span>
                            <span class="font-bold">ACTIVE PIPELINE</span>
                        </div>
                        <span class="text-outline-variant font-mono">/</span>
                        <div class="flex items-center gap-1.5 font-code-sm text-code-sm text-on-surface-variant">
                            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                            <span>SLA CONVERGED</span>
                        </div>
                        <span class="text-outline-variant font-mono">/</span>
                        <div class="flex items-center gap-1.5 font-code-sm text-code-sm text-outline">
                            <span class="w-2 h-2 rounded-full bg-error"></span>
                            <span>REJECTED BRANCH</span>
                        </div>
                    </div>
                    <div class="absolute top-4 right-4 z-20 flex items-center gap-2 bg-surface-container/90 backdrop-blur-md px-3 py-1.5 rounded-lg shadow-sm">
                        <span class="material-symbols-outlined text-tertiary text-sm">hub</span>
                        <span class="font-code-sm text-code-sm text-on-surface font-mono">6 STAGES · 9 CRYPTOGRAPHIC TOKENS ACTIVE</span>
                    </div>
                    <!-- Zoomable/Pannable Viewport Container -->
                    <div class="relative w-full h-[580px] overflow-x-auto overflow-y-hidden select-none cursor-grab active:cursor-grabbing p-space-lg transition-transform duration-150 origin-top-left" id="dagViewport">
                        <div class="relative w-[1380px] h-[520px]">
                            <!-- SVG CONNECTOR BEZIER CURVES LAYER -->
                            <svg class="absolute inset-0 w-full h-full pointer-events-none z-0" xmlns="http://www.w3.org/2000/svg">
                                <defs>
                                    <lineargradient id="activeGrad" x1="0%" x2="100%" y1="0%" y2="0%">
                                        <stop offset="0%" stop-color="#b4c8e3" stop-opacity="0.8"></stop>
                                        <stop offset="50%" stop-color="#ffb956" stop-opacity="1"></stop>
                                        <stop offset="100%" stop-color="#ffb956" stop-opacity="0.9"></stop>
                                    </lineargradient>
                                    <lineargradient id="inactiveGrad" x1="0%" x2="100%" y1="0%" y2="0%">
                                        <stop offset="0%" stop-color="#43474c" stop-opacity="0.6"></stop>
                                        <stop offset="100%" stop-color="#1f3651" stop-opacity="0.4"></stop>
                                    </lineargradient>
                                    <filter height="140%" id="glowAmber" width="140%" x="-20%" y="-20%">
                                        <fegaussianblur result="blur" stddeviation="3"></fegaussianblur>
                                        <fecomposite in="SourceGraphic" in2="blur" operator="over"></fecomposite>
                                    </filter>
                                </defs>
                                <!-- Line: Node 1 (Dataset) to Node 2 (Exp Spec) -->
                                <path d="M 210 240 C 240 240, 240 240, 270 240" fill="none" stroke="#b4c8e3" stroke-dasharray="4 2" stroke-width="2"></path>
                                <circle cx="270" cy="240" fill="#b4c8e3" r="3"></circle>
                                <!-- Forking Lines: Node 2 (Exp Spec) to 3A, 3B, 3C, 3D -->
                                <!-- 3A (Archived / Failed) -->
                                <path d="M 480 240 C 510 240, 520 80, 550 80" fill="none" id="path-3a" stroke="#43474c" stroke-dasharray="3 3" stroke-width="1.5"></path>
                                <circle cx="550" cy="80" fill="#43474c" r="2.5"></circle>
                                <!-- 3B (HIGHLIGHTED ACTIVE PATH: Random Forest Run 02) -->
                                <path d="M 480 240 C 510 240, 520 185, 550 185" fill="none" filter="url(#glowAmber)" id="path-3b" stroke="url(#activeGrad)" stroke-width="3"></path>
                                <circle cx="550" cy="185" fill="#ffb956" r="4"></circle>
                                <!-- 3C (XGB Apex) -->
                                <path d="M 480 240 C 510 240, 520 295, 550 295" fill="none" id="path-3c" stroke="#2b486b" stroke-width="1.5"></path>
                                <circle cx="550" cy="295" fill="#abc9f2" r="2.5"></circle>
                                <!-- 3D (LGBM) -->
                                <path d="M 480 240 C 510 240, 520 400, 550 400" fill="none" id="path-3d" stroke="#43474c" stroke-dasharray="3 3" stroke-width="1.5"></path>
                                <circle cx="550" cy="400" fill="#43474c" r="2.5"></circle>
                                <!-- Line: 3B Architecture to Node 4 Execution (Run 02) -->
                                <path d="M 760 185 C 790 185, 790 240, 820 240" fill="none" filter="url(#glowAmber)" id="path-exec" stroke="url(#activeGrad)" stroke-width="3"></path>
                                <circle cx="820" cy="240" fill="#ffb956" r="4"></circle>
                                <!-- Line: Node 4 (Run 02) to Node 5 (Evaluation Gate) -->
                                <path d="M 1030 240 C 1050 240, 1050 240, 1070 240" fill="none" filter="url(#glowAmber)" id="path-eval" stroke="url(#activeGrad)" stroke-width="3"></path>
                                <circle cx="1070" cy="240" fill="#ffb956" r="4"></circle>
                                <!-- Line: Node 5 (Evaluation Gate) to Node 6 (Model Registry) -->
                                <path d="M 1250 240 C 1270 240, 1270 240, 1290 240" fill="none" filter="url(#glowAmber)" id="path-reg" stroke="url(#activeGrad)" stroke-width="3"></path>
                                <circle cx="1290" cy="240" fill="#ffb956" r="4"></circle>
                            </svg>
                            <!-- NODE 1: DATASET IMMUTABLE SNAPSHOT -->
                            <div class="dag-node absolute left-0 top-[170px] w-[210px] bg-surface-container p-3 rounded-xl shadow-lg cursor-pointer transition-all hover:bg-surface-container-high group" id="node-dataset" onclick="selectNode('node-dataset')">
                                <div class="flex items-center justify-between pb-1.5">
                                    <span class="font-code-sm text-code-sm text-primary font-mono font-bold flex items-center gap-1">
                                        <span class="material-symbols-outlined text-sm">database</span>
                                        01 // DATASET
                                    </span>
                                    <span class="px-1.5 py-0.5 rounded bg-surface-container-lowest text-emerald-400 font-code-sm text-code-sm font-mono">MOUNTED</span>
                                </div>
                                <div class="font-title-sm text-title-sm text-on-surface truncate font-semibold">telecom_churn_q3_v2</div>
                                <div class="font-code-sm text-code-sm text-outline-variant font-mono mt-0.5">.parquet (480k rows)</div>
                                <div class="mt-2.5 pt-2 bg-surface-container-lowest/60 p-2 rounded">
                                    <div class="flex justify-between font-code-sm text-code-sm text-on-surface-variant">
                                        <span>Features:</span>
                                        <span class="text-on-surface font-mono font-semibold">42 cols</span>
                                    </div>
                                    <div class="font-code-sm text-code-sm text-outline truncate font-mono mt-0.5" title="sha256:d8a9fe8113c2409ab4c100e4">
                                        sha256:d8a9fe...b4c100e4
                                    </div>
                                </div>
                            </div>
                            <!-- NODE 2: EXPERIMENT SPECIFICATION -->
                            <div class="dag-node absolute left-[270px] top-[160px] w-[210px] bg-surface-container p-3 rounded-xl shadow-lg cursor-pointer transition-all hover:bg-surface-container-high group" id="node-spec" onclick="selectNode('node-spec')">
                                <div class="flex items-center justify-between pb-1.5">
                                    <span class="font-code-sm text-code-sm text-secondary font-mono font-bold flex items-center gap-1">
                                        <span class="material-symbols-outlined text-sm">tune</span>
                                        02 // EXP SPEC
                                    </span>
                                    <span class="px-1.5 py-0.5 rounded bg-surface-container-lowest text-secondary-fixed font-code-sm text-code-sm font-mono">5-FOLD</span>
                                </div>
                                <div class="font-title-sm text-title-sm text-on-surface font-semibold truncate">EXP-CHURN-2024-Q3</div>
                                <div class="font-code-sm text-code-sm text-on-surface-variant font-mono mt-0.5">Stratified 80/20</div>
                                <div class="mt-2 pt-2 bg-surface-container-lowest/60 p-2 rounded space-y-1">
                                    <div class="font-code-sm text-code-sm text-on-surface-variant truncate">
                                        Pipe: Impute · RobustScaler
                                    </div>
                                    <div class="font-code-sm text-code-sm text-on-surface-variant truncate">
                                        K-Best: 28 selected
                                    </div>
                                    <div class="font-code-sm text-code-sm text-tertiary font-mono truncate">
                                        git:#9f2a81b (feat/optuna)
                                    </div>
                                </div>
                            </div>
                            <!-- FORK NODES: 3A, 3B, 3C, 3D -->
                            <!-- 3A: Logistic Regression (SGD) Baseline - FAILED -->
                            <div class="dag-node absolute left-[550px] top-[40px] w-[210px] bg-surface-container/70 p-2.5 rounded-xl opacity-60 hover:opacity-100 transition-opacity cursor-pointer" id="node-3a" onclick="selectNode('node-3a')">
                                <div class="flex items-center justify-between">
                                    <span class="font-code-sm text-code-sm text-outline font-mono">3A // SGD BASELINE</span>
                                    <span class="px-1 py-0.5 rounded bg-error-container text-on-error-container font-code-sm text-code-sm">SLA FAIL</span>
                                </div>
                                <div class="font-title-sm text-title-sm text-on-surface-variant font-medium">LogisticRegression</div>
                                <div class="flex items-center justify-between font-code-sm text-code-sm mt-1 text-outline">
                                    <span>F1: <strong class="text-error font-mono">0.710</strong></span>
                                    <span>Archived</span>
                                </div>
                            </div>
                            <!-- 3B: Random Forest Classifier - ACTIVE PINNED PATH -->
                            <div class="dag-node absolute left-[550px] top-[145px] w-[210px] bg-surface-container-high p-3 rounded-xl shadow-2xl cursor-pointer ring-2 ring-tertiary transition-transform scale-105" id="node-3b" onclick="selectNode('node-3b')">
                                <div class="flex items-center justify-between pb-1">
                                    <span class="font-code-sm text-code-sm text-tertiary font-mono font-bold flex items-center gap-1">
                                        <span class="material-symbols-outlined text-sm text-tertiary">check_circle</span>
                                        3B // CANDIDATE
                                    </span>
                                    <span class="px-1.5 py-0.5 rounded bg-tertiary text-on-tertiary font-code-sm text-code-sm font-bold font-mono">RUN #02</span>
                                </div>
                                <div class="font-title-sm text-title-sm text-on-surface font-semibold">RandomForestClf</div>
                                <div class="font-code-sm text-code-sm text-on-surface-variant font-mono mt-0.5">n_estimators: 300 · d: 14</div>
                                <div class="mt-2 bg-surface-container-lowest p-2 rounded flex items-center justify-between">
                                    <span class="font-code-sm text-code-sm text-outline uppercase font-mono">Metric Score:</span>
                                    <span class="font-code-sm text-code-sm font-bold text-tertiary font-mono">F1: 0.801 (PASS)</span>
                                </div>
                            </div>
                            <!-- 3C: XGBoost Classifier - APEX -->
                            <div class="dag-node absolute left-[550px] top-[260px] w-[210px] bg-surface-container p-2.5 rounded-xl opacity-80 hover:opacity-100 transition-opacity cursor-pointer" id="node-3c" onclick="selectNode('node-3c')">
                                <div class="flex items-center justify-between">
                                    <span class="font-code-sm text-code-sm text-secondary font-mono">3C // RUN #03</span>
                                    <span class="px-1 py-0.5 rounded bg-surface-container-highest text-secondary-fixed font-code-sm text-code-sm">APEX F1</span>
                                </div>
                                <div class="font-title-sm text-title-sm text-on-surface font-medium">XGBClassifier (CUDA)</div>
                                <div class="flex items-center justify-between font-code-sm text-code-sm mt-1 text-on-surface-variant font-mono">
                                    <span>F1: <strong class="text-secondary font-bold">0.834</strong></span>
                                    <span class="text-tertiary text-[10px]">Lat: 28ms &gt; SLA</span>
                                </div>
                            </div>
                            <!-- 3D: LightGBM Classifier -->
                            <div class="dag-node absolute left-[550px] top-[365px] w-[210px] bg-surface-container/70 p-2.5 rounded-xl opacity-60 hover:opacity-100 transition-opacity cursor-pointer" id="node-3d" onclick="selectNode('node-3d')">
                                <div class="flex items-center justify-between">
                                    <span class="font-code-sm text-code-sm text-outline font-mono">3D // RUN #04</span>
                                    <span class="px-1 py-0.5 rounded bg-surface-container-lowest text-outline font-code-sm text-code-sm">DISMISSED</span>
                                </div>
                                <div class="font-title-sm text-title-sm text-on-surface-variant font-medium">LGBMClassifier</div>
                                <div class="flex items-center justify-between font-code-sm text-code-sm mt-1 text-outline font-mono">
                                    <span>F1: 0.762</span>
                                    <span>Early Stop #42</span>
                                </div>
                            </div>
                            <!-- NODE 4: TRAINING RUN EXECUTION (RUN #02) -->
                            <div class="dag-node absolute left-[820px] top-[160px] w-[210px] bg-surface-container p-3 rounded-xl shadow-lg cursor-pointer transition-all hover:bg-surface-container-high group ring-1 ring-tertiary/40" id="node-exec" onclick="selectNode('node-exec')">
                                <div class="flex items-center justify-between pb-1.5">
                                    <span class="font-code-sm text-code-sm text-tertiary font-mono font-bold flex items-center gap-1">
                                        <span class="material-symbols-outlined text-sm">memory</span>
                                        04 // EXECUTION
                                    </span>
                                    <span class="px-1.5 py-0.5 rounded bg-surface-container-lowest text-tertiary font-code-sm text-code-sm font-mono">14.8s</span>
                                </div>
                                <div class="font-title-sm text-title-sm text-on-surface font-semibold truncate">RUN-2024-02-RF</div>
                                <div class="font-code-sm text-code-sm text-on-surface-variant font-mono mt-0.5">cluster-eu-west-04</div>
                                <div class="mt-2 bg-surface-container-lowest/60 p-2 rounded space-y-1">
                                    <div class="flex justify-between font-code-sm text-code-sm text-on-surface-variant">
                                        <span>Hardware:</span>
                                        <span class="text-on-surface font-mono">NVIDIA H100</span>
                                    </div>
                                    <div class="flex justify-between font-code-sm text-code-sm text-on-surface-variant">
                                        <span>Weights:</span>
                                        <span class="text-on-surface font-mono">34.2 MB bin</span>
                                    </div>
                                    <div class="font-code-sm text-code-sm text-outline truncate font-mono">
                                        sha256:8f4e19...c39a
                                    </div>
                                </div>
                            </div>
                            <!-- NODE 5: EVALUATION & AUDIT GATE -->
                            <div class="dag-node absolute left-[1070px] top-[160px] w-[180px] bg-surface-container p-3 rounded-xl shadow-lg cursor-pointer transition-all hover:bg-surface-container-high group ring-1 ring-emerald-500/50" id="node-eval" onclick="selectNode('node-eval')">
                                <div class="flex items-center justify-between pb-1.5">
                                    <span class="font-code-sm text-code-sm text-emerald-400 font-mono font-bold flex items-center gap-1">
                                        <span class="material-symbols-outlined text-sm">verified_user</span>
                                        05 // AUDIT
                                    </span>
                                    <span class="px-1.5 py-0.5 rounded bg-emerald-950/80 text-emerald-400 font-code-sm text-code-sm font-mono">PASS</span>
                                </div>
                                <div class="font-title-sm text-title-sm text-on-surface font-semibold truncate">EVAL-GATE-AI-024</div>
                                <div class="font-code-sm text-code-sm text-on-surface-variant font-mono mt-0.5">Air-Gap Strict Valid</div>
                                <div class="mt-2 bg-surface-container-lowest/60 p-2 rounded space-y-1">
                                    <div class="flex justify-between font-code-sm text-code-sm">
                                        <span class="text-outline">F1 Score:</span>
                                        <span class="text-emerald-400 font-bold font-mono">0.801</span>
                                    </div>
                                    <div class="flex justify-between font-code-sm text-code-sm">
                                        <span class="text-outline">Latency:</span>
                                        <span class="text-emerald-400 font-mono">18.4ms</span>
                                    </div>
                                    <div class="flex justify-between font-code-sm text-code-sm">
                                        <span class="text-outline">Drift PSI:</span>
                                        <span class="text-on-surface font-mono">0.042</span>
                                    </div>
                                </div>
                            </div>
                            <!-- NODE 6: MODEL REGISTRY & DISPATCH -->
                            <div class="dag-node absolute left-[1290px] top-[160px] w-[190px] bg-surface-container-high p-3 rounded-xl shadow-2xl cursor-pointer hover:bg-surface-bright transition-all ring-2 ring-primary" id="node-registry" onclick="selectNode('node-registry')">
                                <div class="flex items-center justify-between pb-1.5">
                                    <span class="font-code-sm text-code-sm text-primary font-mono font-bold flex items-center gap-1">
                                        <span class="material-symbols-outlined text-sm">rocket_launch</span>
                                        06 // REGISTRY
                                    </span>
                                    <span class="px-1.5 py-0.5 rounded bg-primary-container text-primary font-code-sm text-code-sm font-mono">STAGED</span>
                                </div>
                                <div class="font-title-sm text-title-sm text-on-surface font-semibold truncate">SYS-AI-04 Target</div>
                                <div class="font-code-sm text-code-sm text-tertiary font-mono mt-0.5 truncate">churn-predictor:v2.1</div>
                                <div class="mt-2.5 pt-2">
                                    <button class="w-full py-1.5 px-2 rounded bg-primary hover:bg-primary-fixed-dim text-on-primary font-label-sm text-label-sm font-semibold uppercase tracking-wider transition-colors shadow-sm flex items-center justify-center gap-1">
                                        <span>Promote</span>
                                        <span class="material-symbols-outlined text-xs">arrow_forward</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- 3. Bottom Inspector Sliding/Grid Deck: Telemetry & Lineage Diff Comparator -->
                <div class="mt-space-md grid grid-cols-1 lg:grid-cols-12 gap-space-md">
                    <!-- LEFT PANEL: Selected Node Cryptographic Telemetry Inspector (8 Columns) -->
                    <div class="lg:col-span-8 flex flex-col bg-surface-container-low rounded-xl p-space-md shadow-md">
                        <!-- Inspector Header & Tab Navigation -->
                        <div class="flex flex-wrap items-center justify-between pb-space-sm gap-2">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-tertiary">developer_board</span>
                                <div>
                                    <span class="font-code-sm text-code-sm text-outline uppercase font-mono block">Selected Step Telemetry</span>
                                    <h2 class="font-headline-md text-headline-md text-on-surface font-semibold" id="inspectorNodeTitle">
                                        Node: RUN-2024-02-RF (RandomForestClassifier)
                                    </h2>
                                </div>
                            </div>
                            <!-- Navigation Tabs -->
                            <div class="flex items-center bg-surface-container p-1 rounded-lg">
                                <button class="inspector-tab px-3 py-1 rounded text-label-sm font-label-sm bg-surface-container-high text-on-surface font-semibold transition-all" id="tab-summary" onclick="switchInspectorTab('summary')">
                                    SUMMARY
                                </button>
                                <button class="inspector-tab px-3 py-1 rounded text-label-sm font-label-sm text-on-surface-variant hover:text-on-surface transition-all" id="tab-hyperparams" onclick="switchInspectorTab('hyperparams')">
                                    HYPERPARAMS
                                </button>
                                <button class="inspector-tab px-3 py-1 rounded text-label-sm font-label-sm text-on-surface-variant hover:text-on-surface transition-all" id="tab-artifacts" onclick="switchInspectorTab('artifacts')">
                                    ARTIFACTS &amp; HASHES
                                </button>
                                <button class="inspector-tab px-3 py-1 rounded text-label-sm font-label-sm text-on-surface-variant hover:text-on-surface transition-all" id="tab-env" onclick="switchInspectorTab('env')">
                                    ENV LOCKFILE
                                </button>
                            </div>
                        </div>
                        <!-- Tab Content Area -->
                        <div class="mt-space-sm flex-1 bg-surface-container-lowest p-space-md rounded-xl">
                            <!-- TAB 1: SUMMARY -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-space-md" id="tabContent-summary">
                                <div class="bg-surface-container p-3 rounded-lg flex flex-col justify-between">
                                    <span class="font-label-sm text-label-sm text-outline uppercase font-mono">Validation Performance</span>
                                    <div class="my-2">
                                        <span class="font-headline-xl text-headline-xl text-tertiary font-mono font-bold">0.8014</span>
                                        <span class="font-code-sm text-code-sm text-emerald-400 block font-mono mt-0.5">SLA THRESHOLD ≥ 0.8000 MET</span>
                                    </div>
                                    <div class="space-y-1 font-code-sm text-code-sm pt-2 bg-surface-container-low p-2 rounded text-on-surface-variant">
                                        <div class="flex justify-between"><span>ROC-AUC:</span><span class="font-mono text-on-surface">0.884</span></div>
                                        <div class="flex justify-between"><span>Accuracy:</span><span class="font-mono text-on-surface">84.2%</span></div>
                                        <div class="flex justify-between"><span>Recall:</span><span class="font-mono text-on-surface">0.789</span></div>
                                    </div>
                                </div>
                                <div class="bg-surface-container p-3 rounded-lg flex flex-col justify-between">
                                    <span class="font-label-sm text-label-sm text-outline uppercase font-mono">Inference Latency Budget</span>
                                    <div class="my-2">
                                        <span class="font-headline-xl text-headline-xl text-primary font-mono font-bold">18.4ms</span>
                                        <span class="font-code-sm text-code-sm text-on-surface-variant block font-mono mt-0.5">p99: 22.1ms (SLA ≤ 25ms)</span>
                                    </div>
                                    <!-- Latency Gauge Progress Bar -->
                                    <div class="space-y-1 pt-2">
                                        <div class="flex justify-between font-code-sm text-code-sm text-outline">
                                            <span>Load Consumption</span>
                                            <span class="font-mono text-tertiary">73.6%</span>
                                        </div>
                                        <div class="h-2 w-full bg-surface-container-high rounded-full overflow-hidden">
                                            <div class="h-full bg-tertiary rounded-full" style="width: 73.6%;"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-surface-container p-3 rounded-lg flex flex-col justify-between">
                                    <span class="font-label-sm text-label-sm text-outline uppercase font-mono">Cryptographic Certificate</span>
                                    <div class="my-1 space-y-1.5 font-code-sm text-code-sm font-mono">
                                        <div class="text-outline text-label-sm uppercase font-label-sm">Audit ID: VP-AUD-992-RF</div>
                                        <div class="p-1.5 rounded bg-surface-container-low text-emerald-400 break-all text-[10px] leading-tight">
                                            SIG: 4e7a8f902...b31e92d77a01ca4599f81
                                        </div>
                                    </div>
                                    <div class="pt-2 flex items-center gap-1.5 text-emerald-400 font-label-sm text-label-sm">
                                        <span class="material-symbols-outlined text-sm">lock</span>
                                        <span>Air-Gap Signed &amp; Sealed</span>
                                    </div>
                                </div>
                            </div>
                            <!-- TAB 2: HYPERPARAMETERS (Hidden by default) -->
                            <div class="hidden" id="tabContent-hyperparams">
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-space-sm font-mono text-code-sm">
                                    <div class="bg-surface-container p-2.5 rounded">
                                        <span class="text-outline text-label-sm block uppercase font-label-sm">n_estimators</span>
                                        <span class="text-on-surface font-bold text-headline-md font-headline-md">300</span>
                                    </div>
                                    <div class="bg-surface-container p-2.5 rounded">
                                        <span class="text-outline text-label-sm block uppercase font-label-sm">max_depth</span>
                                        <span class="text-on-surface font-bold text-headline-md font-headline-md">14</span>
                                    </div>
                                    <div class="bg-surface-container p-2.5 rounded">
                                        <span class="text-outline text-label-sm block uppercase font-label-sm">min_samples_split</span>
                                        <span class="text-on-surface font-bold text-headline-md font-headline-md">6</span>
                                    </div>
                                    <div class="bg-surface-container p-2.5 rounded">
                                        <span class="text-outline text-label-sm block uppercase font-label-sm">min_samples_leaf</span>
                                        <span class="text-on-surface font-bold text-headline-md font-headline-md">2</span>
                                    </div>
                                    <div class="bg-surface-container p-2.5 rounded">
                                        <span class="text-outline text-label-sm block uppercase font-label-sm">criterion</span>
                                        <span class="text-tertiary font-bold">gini</span>
                                    </div>
                                    <div class="bg-surface-container p-2.5 rounded">
                                        <span class="text-outline text-label-sm block uppercase font-label-sm">max_features</span>
                                        <span class="text-on-surface font-bold">sqrt (0.28)</span>
                                    </div>
                                    <div class="bg-surface-container p-2.5 rounded">
                                        <span class="text-outline text-label-sm block uppercase font-label-sm">bootstrap</span>
                                        <span class="text-on-surface font-bold">true</span>
                                    </div>
                                    <div class="bg-surface-container p-2.5 rounded">
                                        <span class="text-outline text-label-sm block uppercase font-label-sm">random_state</span>
                                        <span class="text-on-surface font-bold">42</span>
                                    </div>
                                </div>
                            </div>
                            <!-- TAB 3: ARTIFACTS & HASHES (Hidden by default) -->
                            <div class="hidden" id="tabContent-artifacts">
                                <div class="space-y-2 font-mono text-code-sm">
                                    <div class="flex items-center justify-between p-2 rounded bg-surface-container">
                                        <div class="flex items-center gap-2">
                                            <span class="material-symbols-outlined text-tertiary text-sm">attachment</span>
                                            <span class="text-on-surface font-semibold">model_weights.bin (34.2 MB)</span>
                                        </div>
                                        <span class="text-outline text-[11px]">sha256: 8f4e1903ba2419c8f...c39a</span>
                                    </div>
                                    <div class="flex items-center justify-between p-2 rounded bg-surface-container">
                                        <div class="flex items-center gap-2">
                                            <span class="material-symbols-outlined text-secondary text-sm">data_object</span>
                                            <span class="text-on-surface font-semibold">params.json (4.1 KB)</span>
                                        </div>
                                        <span class="text-outline text-[11px]">sha256: 120cf8419da384be8...10f2</span>
                                    </div>
                                    <div class="flex items-center justify-between p-2 rounded bg-surface-container">
                                        <div class="flex items-center gap-2">
                                            <span class="material-symbols-outlined text-primary text-sm">settings_suggest</span>
                                            <span class="text-on-surface font-semibold">conda_env.yaml (1.8 KB)</span>
                                        </div>
                                        <span class="text-outline text-[11px]">sha256: ee9a01f4c781190bc...01bb</span>
                                    </div>
                                </div>
                            </div>
                            <!-- TAB 4: ENV LOCKFILE (Hidden by default) -->
                            <div class="hidden" id="tabContent-env">
                                <div class="p-3 rounded bg-surface-container font-mono text-code-sm text-on-surface-variant space-y-1">
                                    <div class="text-primary font-bold"># Deterministic Runtime Spec (Base Python 3.11.8)</div>
                                    <div>platform: linux-x86_64 // glibc 2.35</div>
                                    <div>cuda-toolkit: 12.4.1 (driver 550.54.14)</div>
                                    <div>scikit-learn==1.3.2</div>
                                    <div>numpy==1.26.4 · scipy==1.12.0 · joblib==1.3.2</div>
                                    <div>sha256_env_digest: 43a0e9b177218cf67210e3b97cd38b14</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- RIGHT PANEL: Lineage Diff Comparator Widget (4 Columns) -->
                    <div class="lg:col-span-4 flex flex-col bg-surface-container-low rounded-xl p-space-md shadow-md justify-between">
                        <div class="flex flex-col gap-space-sm">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-secondary">compare_arrows</span>
                                    <span class="font-headline-md text-headline-md text-on-surface font-semibold">Run Comparator</span>
                                </div>
                                <span class="px-2 py-0.5 rounded bg-surface-container-high text-outline text-label-sm font-label-sm uppercase font-mono">
                                    DIFF: #02 vs #01
                                </span>
                            </div>
                            <!-- Comparison Table Rows -->
                            <div class="space-y-2 mt-1">
                                <!-- Row 1: Dataset Source -->
                                <div class="p-2.5 rounded bg-surface-container">
                                    <div class="flex justify-between text-label-sm font-label-sm text-outline uppercase font-mono">
                                        <span>Dataset Snapshot</span>
                                        <span class="text-emerald-400">IDENTICAL</span>
                                    </div>
                                    <div class="flex justify-between font-code-sm text-code-sm text-on-surface mt-1 font-mono">
                                        <span>telecom_churn_q3_v2</span>
                                        <span>480k rows</span>
                                    </div>
                                </div>
                                <!-- Row 2: Pipeline Version -->
                                <div class="p-2.5 rounded bg-surface-container">
                                    <div class="flex justify-between text-label-sm font-label-sm text-outline uppercase font-mono">
                                        <span>Feature Pipeline</span>
                                        <span class="text-tertiary">UPGRADED</span>
                                    </div>
                                    <div class="flex justify-between font-code-sm text-code-sm text-on-surface mt-1 font-mono">
                                        <span class="text-outline">v1.4 (StandardScaler)</span>
                                        <span class="text-tertiary">› v2.1 (Robust+KBest)</span>
                                    </div>
                                </div>
                                <!-- Row 3: Algorithm Fork -->
                                <div class="p-2.5 rounded bg-surface-container">
                                    <div class="flex justify-between text-label-sm font-label-sm text-outline uppercase font-mono">
                                        <span>Model Architecture</span>
                                        <span class="text-secondary">DIVERGENT</span>
                                    </div>
                                    <div class="flex justify-between font-code-sm text-code-sm text-on-surface mt-1 font-mono">
                                        <span class="text-outline">SGD Baseline</span>
                                        <span class="text-primary font-bold">› Random Forest (300)</span>
                                    </div>
                                </div>
                                <!-- Row 4: Delta Outcome -->
                                <div class="p-2.5 rounded bg-tertiary-container/60 border border-tertiary/20">
                                    <div class="flex justify-between text-label-sm font-label-sm text-tertiary uppercase font-mono font-bold">
                                        <span>F1 Delta Gain</span>
                                        <span>+0.0914 PASS</span>
                                    </div>
                                    <div class="flex justify-between font-code-sm text-code-sm text-on-surface mt-1 font-mono">
                                        <span class="text-outline">0.7100</span>
                                        <span class="text-tertiary font-bold text-headline-md font-headline-md">0.8014</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Action Footer Toolbar -->
                        <div class="flex flex-col gap-2 pt-space-sm mt-space-sm border-t border-outline-variant/30">
                            <button class="w-full py-2 px-3 rounded bg-surface-container-high hover:bg-surface-bright text-on-surface font-label-sm text-label-sm uppercase tracking-wider font-semibold transition-all flex items-center justify-center gap-1.5 shadow-sm" onclick="downloadLineageJSON()">
                                <span class="material-symbols-outlined text-sm">download</span>
                                <span>Export Full Lineage JSON-LD</span>
                            </button>
                            <div class="flex gap-2">
                                <button class="flex-1 py-1.5 px-2 rounded bg-surface-container hover:bg-surface-container-high text-on-surface-variant hover:text-on-surface font-label-sm text-label-sm uppercase tracking-wider transition-all flex items-center justify-center gap-1" onclick="generateAuditPDF()">
                                    <span class="material-symbols-outlined text-xs">picture_as_pdf</span>
                                    <span>Audit PDF</span>
                                </button>
                                <button class="flex-1 py-1.5 px-2 rounded bg-surface-container hover:bg-surface-container-high text-tertiary font-label-sm text-label-sm uppercase tracking-wider transition-all flex items-center justify-center gap-1" onclick="reRunStep()">
                                    <span class="material-symbols-outlined text-xs">replay</span>
                                    <span>Re-Run Step</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </main>
    </div>
    <script src="../../assets/js/app.js"></script>
    <script src="js/main.js"></script>
</body>

</html>