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
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@100..900&family=Inter:wght@100..900&display=swap" rel="stylesheet" />
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
                    </a><a aria-current="page" class="group flex items-center justify-between px-space-md py-2.5 rounded-lg border border-outline-variant/40 bg-surface-container-high text-on-surface font-semibold shadow-inner" data-path="workbench" href="WorkbenchHome.php">
                        <div class="flex items-center gap-space-sm"><span class="material-symbols-outlined text-tertiary text-lg">precision_manufacturing</span><span class="font-code-md text-code-md tracking-tight text-tertiary">SYS-AI-03</span><span class="font-body-sm text-body-sm text-on-surface font-medium">Workbench</span></div><span class="w-2 h-2 rounded bg-tertiary shadow-[0_0_8px_rgba(255,185,86,0.8)]"></span>
                    </a><a class="group flex items-center justify-between px-space-md py-2.5 rounded-lg text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-all" data-path="registry-deployment" href="../../Model Registry & Deployment/ModelRegistry.php">
                        <div class="flex items-center gap-space-sm"><span class="material-symbols-outlined text-outline group-hover:text-primary transition-colors text-lg">rocket_launch</span><span class="font-code-md text-code-md tracking-tight">SYS-AI-04</span><span class="font-body-sm text-body-sm text-on-surface-variant group-hover:text-on-surface">Registry & Deploy</span></div><span class="w-1.5 h-1.5 rounded-full bg-outline-variant/60"></span>
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
                <div class="flex items-center shrink-0 px-2 py-1 rounded bg-secondary-container/80 text-secondary-fixed font-mono border border-secondary/40 shadow-sm">9. Eval & Validate</div><span class="text-outline-variant">›</span>
                <a href="CompareRuns.php" class="flex items-center shrink-0 px-2 py-1 text-outline hover:text-white font-mono transition-colors">10. Explainability</a><span class="text-outline-variant">›</span>
                <a href="RegisterModelDialog.php" class="flex items-center shrink-0 px-2 py-1 text-outline hover:text-white font-mono transition-colors">11. Registry</a><span class="text-outline-variant">›</span>
                <div class="flex items-center shrink-0 px-2 py-1 text-outline font-mono">12. Canary</div><span class="text-outline-variant">›</span>
                <div class="flex items-center shrink-0 px-2 py-1 text-outline font-mono">13. Production</div><span class="text-outline-variant">›</span>
                <a href="../../AI Operations Center (AI SOC)/DriftInvestigationWorkspace.php" class="flex items-center shrink-0 px-2 py-1 text-outline hover:text-rose-400 font-mono transition-colors">14. Drift</a>
            </div>
        </header>
        <main class="w-full pt-28 bg-surface flex-1 min-h-[calc(100vh-7rem)] p-space-md">
            <div class="flex flex-col w-full gap-space-lg">
                <!-- Mission Control Telemetry Ribbon -->
                <section class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-space-md">
                    <!-- Active Experiments Status Card -->
                    <div class="bg-surface-container rounded-xl p-space-md shadow-md flex flex-col justify-between relative overflow-hidden group">
                        <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-tertiary/5 rounded-full blur-2xl group-hover:bg-tertiary/10 transition-colors pointer-events-none"></div>
                        <div class="flex items-center justify-between">
                            <span class="font-label-sm text-label-sm text-outline uppercase tracking-wider">Active Experiments</span>
                            <span class="flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-secondary-container/50 text-secondary font-code-sm text-code-sm">
                                <span class="w-1.5 h-1.5 rounded-full bg-tertiary animate-pulse"></span>
                                SYS-AI-03.DISPATCH
                            </span>
                        </div>
                        <div class="my-space-sm flex items-baseline gap-space-sm">
                            <span class="font-headline-xl text-headline-xl text-on-surface font-bold tracking-tight">19</span>
                            <span class="font-code-sm text-code-sm text-on-surface-variant font-mono">TOTAL RECORDED</span>
                        </div>
                        <div class="flex items-center gap-2 pt-space-xs text-code-sm font-code-sm">
                            <span class="px-2 py-0.5 rounded bg-tertiary-container text-tertiary font-medium">4 Running</span>
                            <span class="px-2 py-0.5 rounded bg-surface-container-high text-on-surface-variant">12 Done</span>
                            <span class="px-2 py-0.5 rounded bg-error-container text-error font-medium">1 Fail</span>
                            <span class="px-2 py-0.5 rounded bg-surface-container-lowest text-outline">2 Queue</span>
                        </div>
                    </div>
                    <!-- GPU Cluster Load Card -->
                    <div class="bg-surface-container rounded-xl p-space-md shadow-md flex flex-col justify-between relative overflow-hidden">
                        <div class="flex items-center justify-between">
                            <span class="font-label-sm text-label-sm text-outline uppercase tracking-wider">GPU Cluster Load</span>
                            <span class="material-symbols-outlined text-tertiary text-lg">speed</span>
                        </div>
                        <div class="my-space-sm flex items-end justify-between">
                            <div>
                                <div class="font-headline-xl text-headline-xl text-on-surface font-bold font-mono leading-none">78<span class="text-tertiary font-body-md">%</span></div>
                                <span class="font-code-sm text-code-sm text-outline font-mono mt-1 block">NVIDIA H100 SXM5</span>
                            </div>
                            <div class="text-right font-code-sm text-code-sm text-on-surface-variant">
                                <div class="text-tertiary font-semibold font-mono">64 / 80 GB</div>
                                <div class="text-outline font-mono">VRAM · 58°C NOM</div>
                            </div>
                        </div>
                        <div class="w-full bg-surface-container-lowest h-1.5 rounded-full overflow-hidden">
                            <div class="bg-tertiary h-full rounded-full transition-all duration-500" style="width: 78%;"></div>
                        </div>
                    </div>
                    <!-- Compute Node Instance Card -->
                    <div class="bg-surface-container rounded-xl p-space-md shadow-md flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <span class="font-label-sm text-label-sm text-outline uppercase tracking-wider">Compute Target</span>
                            <span class="px-2 py-0.5 rounded bg-surface-container-high text-tertiary font-code-sm text-code-sm font-mono">EU-W-04</span>
                        </div>
                        <div class="my-space-sm flex flex-col">
                            <span class="font-title-sm text-title-sm text-on-surface font-mono tracking-tight">cluster-eu-west-04.node</span>
                            <span class="font-code-sm text-code-sm text-secondary font-mono">32 vCPU · 128 GB RAM ECC</span>
                        </div>
                        <div class="flex items-center justify-between text-code-sm font-code-sm text-outline">
                            <span class="flex items-center gap-1.5 text-on-surface-variant">
                                <span class="w-2 h-2 rounded-full bg-emerald-400"></span> Online / Dedicated
                            </span>
                            <span class="font-mono">RDMA 400Gbps</span>
                        </div>
                    </div>
                    <!-- Pale Periwinkle Focus Tile: Business Target -->
                    <div class="bg-secondary-fixed text-on-secondary-fixed rounded-xl p-space-md shadow-lg flex flex-col justify-between relative overflow-hidden">
                        <div class="flex items-center justify-between">
                            <span class="font-label-sm text-label-sm text-on-secondary-fixed/80 uppercase font-mono font-bold tracking-widest">Active Dispatch Ticket</span>
                            <span class="px-2 py-0.5 rounded bg-on-secondary-fixed text-secondary-fixed font-code-sm text-code-sm font-mono">#AI-024</span>
                        </div>
                        <div class="my-space-xs">
                            <div class="font-headline-md text-headline-md text-on-secondary-fixed font-bold leading-tight">Customer Churn Rate</div>
                            <p class="font-body-sm text-body-sm text-on-secondary-fixed/90 mt-1">Avionics Subscription Telemetry Tier-A</p>
                        </div>
                        <div class="pt-2 flex items-center justify-between bg-on-secondary-fixed/10 px-2.5 py-1.5 rounded-lg">
                            <span class="font-code-sm text-code-sm font-mono font-semibold uppercase text-on-secondary-fixed">Gate Threshold</span>
                            <span class="font-code-sm text-code-sm font-mono font-bold bg-on-secondary-fixed text-secondary-fixed px-2 py-0.5 rounded">F1 ≥ 0.80</span>
                        </div>
                    </div>
                </section>
                <!-- Interactive Action & Filter Bar -->
                <section class="flex flex-wrap items-center justify-between gap-space-md bg-surface-container-low p-space-sm rounded-xl">
                    <div class="flex flex-wrap items-center gap-space-sm">
                        <a href="ExperimentBuilder.php"  class="h-9 px-space-md rounded-lg bg-surface-container-highest text-primary hover:bg-surface-bright transition-all flex items-center gap-2 font-label-sm text-label-sm uppercase font-semibold shadow-sm active:scale-95"><span class="material-symbols-outlined text-tertiary text-lg">bolt</span> New Experiment</a>
                        <a href="../../Data Center/DatasetCatalog.php"  class="h-9 px-space-md rounded-lg bg-surface-container text-on-surface-variant hover:text-on-surface hover:bg-surface-container-high transition-all flex items-center gap-2 font-label-sm text-label-sm uppercase"><span class="material-symbols-outlined text-base text-secondary">database</span> Import From SYS-AI-02</a>
                        <button class="h-9 px-space-md rounded-lg bg-surface-container text-on-surface-variant hover:text-on-surface hover:bg-surface-container-high transition-all flex items-center gap-2 font-label-sm text-label-sm uppercase">
                            <span class="material-symbols-outlined text-base text-outline">terminal</span>
                            Connect Jupyter / VS Code
                        </button>
                    </div>
                    <!-- Filter Pills Segmented -->
                    <div class="flex items-center gap-1 bg-surface-container-lowest p-1 rounded-lg">
                        <button class="px-3 py-1 rounded bg-secondary-container text-secondary font-label-sm text-label-sm uppercase font-semibold shadow-sm">All Runs</button>
                        <button class="px-3 py-1 rounded text-on-surface-variant hover:text-on-surface font-label-sm text-label-sm uppercase transition-colors">Churn</button>
                        <button class="px-3 py-1 rounded text-on-surface-variant hover:text-on-surface font-label-sm text-label-sm uppercase transition-colors">CV</button>
                        <button class="px-3 py-1 rounded text-on-surface-variant hover:text-on-surface font-label-sm text-label-sm uppercase transition-colors">NLP</button>
                        <button class="px-3 py-1 rounded text-on-surface-variant hover:text-on-surface font-label-sm text-label-sm uppercase transition-colors">GenAI</button>
                    </div>
                </section>
                <!-- Core Bento Grid -->
                <section class="grid grid-cols-1 lg:grid-cols-12 gap-space-md items-start">
                    <!-- Bento Tile 1: Active & Queued Training Jobs (8 cols) -->
                    <div class="lg:col-span-8 bg-surface-container rounded-xl p-space-lg shadow-md flex flex-col gap-space-md">
                        <div class="flex items-center justify-between pb-space-xs">
                            <div class="flex items-center gap-space-sm">
                                <span class="material-symbols-outlined text-tertiary text-xl">precision_manufacturing</span>
                                <div>
                                    <h2 class="font-headline-md text-headline-md text-on-surface font-semibold">Active & Queued Jobs</h2>
                                    <p class="font-code-sm text-code-sm text-outline font-mono">Realtime distributed task queue orchestration</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 text-code-sm font-code-sm text-outline font-mono">
                                <span class="w-2 h-2 rounded-full bg-tertiary animate-ping"></span>
                                <span>POLL_FREQ: 1.0s</span>
                            </div>
                        </div>
                        <!-- Job List Stacks -->
                        <div class="flex flex-col gap-space-sm">
                            <!-- Job 1: Running with Sparkline -->
                            <div class="bg-surface-container-low p-space-md rounded-lg flex flex-col gap-3 group hover:bg-surface-container-high/60 transition-colors">
                                <div class="flex flex-wrap items-center justify-between gap-2">
                                    <div class="flex items-center gap-3">
                                        <span class="px-2 py-0.5 rounded font-code-sm text-code-sm font-mono bg-tertiary-container text-tertiary font-bold flex items-center gap-1.5">
                                            <span class="w-1.5 h-1.5 rounded-full bg-tertiary animate-pulse"></span>
                                            RUNNING
                                        </span>
                                        <span class="font-code-md text-code-md text-on-surface font-mono font-medium">#EXP-024-03</span>
                                        <span class="font-title-sm text-title-sm text-secondary-fixed">churn_xgboost_optuna_v3</span>
                                    </div>
                                    <div class="flex items-center gap-4 text-code-sm font-code-sm font-mono">
                                        <span class="text-outline">ETA: <strong class="text-on-surface">4m 12s</strong></span>
                                        <span class="text-outline">Epoch: <strong class="text-secondary">68/100</strong></span>
                                        <span class="text-outline">Loss: <strong class="text-tertiary font-bold">0.241</strong></span>
                                    </div>
                                </div>
                                <!-- Progress bar and Live Loss Sparkline Container -->
                                <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-center pt-1">
                                    <div class="md:col-span-7 flex flex-col gap-1.5">
                                        <div class="flex justify-between text-code-sm font-code-sm font-mono text-outline">
                                            <span>Optimizer Step: Optuna Bayesian [Tree 680]</span>
                                            <span class="text-on-surface">68%</span>
                                        </div>
                                        <div class="w-full bg-surface-container-lowest h-2 rounded-full overflow-hidden">
                                            <div class="bg-tertiary h-full rounded-full transition-all duration-300" style="width: 68%;"></div>
                                        </div>
                                    </div>
                                    <div class="md:col-span-5 flex items-center justify-end gap-3 bg-surface-container-lowest/80 px-3 py-1.5 rounded-md">
                                        <div class="text-right">
                                            <div class="text-label-sm font-label-sm text-outline uppercase font-mono">Loss Curve</div>
                                            <div class="text-code-sm font-code-sm text-tertiary font-mono">0.684 → 0.241</div>
                                        </div>
                                        <!-- Inline Loss Sparkline SVG -->
                                        <svg class="w-28 h-8 overflow-visible" fill="none" viewbox="0 0 110 32">
                                            <path class="text-tertiary" d="M 0,28 L 15,22 L 30,24 L 45,16 L 60,18 L 75,10 L 90,11 L 105,6" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                            <path class="text-tertiary/10" d="M 0,28 L 15,22 L 30,24 L 45,16 L 60,18 L 75,10 L 90,11 L 105,6 L 105,32 L 0,32 Z" fill="currentColor"></path>
                                            <circle class="text-tertiary animate-pulse" cx="105" cy="6" fill="currentColor" r="3"></circle>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <!-- Job 2: Queued High Priority -->
                            <div class="bg-surface-container-low p-space-md rounded-lg flex items-center justify-between hover:bg-surface-container-high/60 transition-colors">
                                <div class="flex items-center gap-3">
                                    <span class="px-2 py-0.5 rounded font-code-sm text-code-sm font-mono bg-surface-container-high text-on-surface-variant font-medium">QUEUED</span>
                                    <span class="font-code-md text-code-md text-on-surface font-mono font-medium">#EXP-024-04</span>
                                    <span class="font-title-sm text-title-sm text-on-surface">churn_lightgbm_stratified</span>
                                </div>
                                <div class="flex items-center gap-4 text-code-sm font-code-sm font-mono">
                                    <span class="px-2 py-0.5 rounded bg-tertiary/15 text-tertiary font-semibold uppercase text-label-sm">Priority: High</span>
                                    <span class="text-outline">Assigned: <span class="text-on-surface">worker-node-08</span></span>
                                </div>
                            </div>
                            <!-- Job 3: Completed with Success -->
                            <div class="bg-surface-container-low p-space-md rounded-lg flex items-center justify-between hover:bg-surface-container-high/60 transition-colors">
                                <div class="flex items-center gap-3">
                                    <span class="px-2 py-0.5 rounded font-code-sm text-code-sm font-mono bg-emerald-950/60 text-emerald-400 font-medium flex items-center gap-1">
                                        <span class="material-symbols-outlined text-sm">check_circle</span>
                                        DONE
                                    </span>
                                    <span class="font-code-md text-code-md text-on-surface font-mono font-medium">#EXP-021-09</span>
                                    <span class="font-title-sm text-title-sm text-on-surface">transformer_distilbert_sentiment</span>
                                </div>
                                <div class="flex items-center gap-4 text-code-sm font-code-sm font-mono">
                                    <span class="text-outline">Runtime: <span class="text-on-surface">42m 18s</span></span>
                                    <span class="px-2 py-0.5 rounded bg-surface-container-highest text-secondary-fixed font-bold">F1: 0.842</span>
                                </div>
                            </div>
                            <!-- Job 4: Failed with Traceback Trigger -->
                            <div class="bg-surface-container-low p-space-md rounded-lg flex flex-wrap items-center justify-between gap-2 hover:bg-surface-container-high/60 transition-colors">
                                <div class="flex items-center gap-3">
                                    <span class="px-2 py-0.5 rounded font-code-sm text-code-sm font-mono bg-error-container text-error font-medium flex items-center gap-1">
                                        <span class="material-symbols-outlined text-sm">cancel</span>
                                        FAILED
                                    </span>
                                    <span class="font-code-md text-code-md text-on-surface font-mono font-medium">#EXP-019-02</span>
                                    <span class="font-title-sm text-title-sm text-on-surface">resnet50_telemetry_fault_v1</span>
                                </div>
                                <div class="flex items-center gap-3 text-code-sm font-code-sm font-mono">
                                    <span class="text-error font-medium">CUDA OOM at batch size 128</span>
                                    <button class="px-2.5 py-1 rounded bg-error-container/40 text-on-error-container hover:bg-error-container transition-colors text-label-sm font-label-sm uppercase font-semibold">
                                        View Traceback
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Bento Tile 2 & 3: Right Column Sidecar (4 cols) -->
                    <div class="lg:col-span-4 flex flex-col gap-space-md">
                        <!-- Connected Dataset Card from SYS-AI-02 -->
                        <div class="bg-surface-container rounded-xl p-space-lg shadow-md flex flex-col gap-space-sm">
                            <div class="flex items-center justify-between pb-1">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-secondary text-lg">dataset</span>
                                    <span class="font-label-sm text-label-sm text-outline uppercase tracking-wider">SYS-AI-02 Data Pipeline</span>
                                </div>
                                <span class="px-2 py-0.5 rounded bg-emerald-950/60 text-emerald-400 font-code-sm text-code-sm font-mono font-semibold">VALIDATED</span>
                            </div>
                            <div class="flex flex-col gap-1">
                                <span class="font-headline-md text-headline-md text-on-surface font-mono font-medium truncate">telecom_churn_q3_v2.parquet</span>
                                <span class="font-code-sm text-code-sm text-outline font-mono break-all">SHA-256: d8a9fe8113c2...b4c100e4</span>
                            </div>
                            <!-- Technical Telemetry Matrix for Dataset -->
                            <div class="grid grid-cols-2 gap-2 my-2 p-space-sm bg-surface-container-low rounded-lg">
                                <div>
                                    <div class="text-label-sm font-label-sm text-outline uppercase font-mono">Total Records</div>
                                    <div class="text-headline-md font-headline-md text-on-surface font-mono font-semibold">480,210</div>
                                </div>
                                <div>
                                    <div class="text-label-sm font-label-sm text-outline uppercase font-mono">Features</div>
                                    <div class="text-headline-md font-headline-md text-secondary-fixed font-mono font-semibold">42 cols</div>
                                </div>
                                <div class="pt-2">
                                    <div class="text-label-sm font-label-sm text-outline uppercase font-mono">Null Ratio</div>
                                    <div class="text-code-md font-code-md text-on-surface font-mono">0.02% <span class="text-outline text-code-sm font-mono">(Imputed)</span></div>
                                </div>
                                <div class="pt-2">
                                    <div class="text-label-sm font-label-sm text-outline uppercase font-mono">Split Protocol</div>
                                    <div class="text-code-md font-code-md text-on-surface font-mono">80 / 10 / 10</div>
                                </div>
                            </div>
                            <!-- Quick actions -->
                            <div class="flex items-center justify-between pt-1">
                                <button class="text-tertiary hover:underline font-code-sm text-code-sm font-mono flex items-center gap-1">
                                    <span class="material-symbols-outlined text-sm">visibility</span>
                                    Preview Schema (42)
                                </button>
                                <button class="px-3 py-1.5 rounded-lg bg-surface-container-highest text-on-surface hover:bg-surface-bright font-label-sm text-label-sm uppercase transition-colors">
                                    Change Dataset
                                </button>
                            </div>
                        </div>
                        <!-- Quick Metrics & Target Monitor Card -->
                        <div class="bg-surface-container rounded-xl p-space-lg shadow-md flex flex-col gap-space-sm">
                            <div class="flex items-center justify-between pb-1">
                                <span class="font-label-sm text-label-sm text-outline uppercase tracking-wider">Benchmark Tracker</span>
                                <span class="font-code-sm text-code-sm text-outline font-mono">18 RUNS EVALUATED</span>
                            </div>
                            <div class="bg-surface-container-low p-space-md rounded-lg flex flex-col gap-2">
                                <div class="flex items-center justify-between">
                                    <span class="font-label-sm text-label-sm text-outline uppercase font-mono">Current Champion</span>
                                    <span class="px-2 py-0.5 rounded bg-tertiary-container text-tertiary text-label-sm font-label-sm uppercase font-bold">In-Lead</span>
                                </div>
                                <div class="font-title-sm text-title-sm text-on-surface font-mono font-semibold">XGBoost Baseline v1.2</div>
                                <!-- Score Compare -->
                                <div class="flex items-baseline justify-between mt-2 pt-2 bg-surface-container-lowest p-2 rounded">
                                    <div>
                                        <span class="text-label-sm font-label-sm text-outline uppercase font-mono block">Champion F1</span>
                                        <span class="font-headline-xl text-headline-xl text-on-surface font-mono font-bold">0.771</span>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-label-sm font-label-sm text-outline uppercase font-mono block">Target Deficit</span>
                                        <span class="font-headline-xl text-headline-xl text-tertiary font-mono font-bold">-0.029</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 mt-1 text-code-sm font-code-sm text-tertiary">
                                    <span class="material-symbols-outlined text-base">warning</span>
                                    <span>Gate criterion (≥0.80) unmet. Next: hyperopt tuning.</span>
                                </div>
                            </div>
                            <!-- Micro Progress ring comparison visualization -->
                            <div class="flex items-center justify-between px-2 pt-1 text-code-sm font-code-sm text-outline font-mono">
                                <span>RUNS PASSING ≥0.75: <strong class="text-on-surface">3/18</strong></span>
                                <span class="text-secondary">SYS-AI-04 READY: NO</span>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Bento Tile 4: Recent Experiments Comprehensive Data Table -->
                <section class="bg-surface-container rounded-xl p-space-lg shadow-md flex flex-col gap-space-md overflow-hidden">
                    <div class="flex flex-wrap items-center justify-between gap-space-sm pb-space-xs">
                        <div>
                            <h2 class="font-headline-md text-headline-md text-on-surface font-semibold">Telemetry Run Registry</h2>
                            <p class="font-code-sm text-code-sm text-outline font-mono">Ticket #AI-024 Historical Execution Ledger</p>
                        </div>
                        <div class="flex items-center gap-space-sm">
                            <button class="h-8 px-3 rounded bg-surface-container-high text-on-surface-variant hover:text-on-surface font-code-sm text-code-sm font-mono flex items-center gap-1.5 transition-colors">
                                <span class="material-symbols-outlined text-sm">download</span>
                                Export CSV
                            </button>
                            <button class="h-8 px-3 rounded bg-surface-container-high text-on-surface-variant hover:text-on-surface font-code-sm text-code-sm font-mono flex items-center gap-1.5 transition-colors">
                                <span class="material-symbols-outlined text-sm">tune</span>
                                Column Specs
                            </button>
                        </div>
                    </div>
                    <!-- Table Container with Horizontal Scroll Barrier -->
                    <div class="w-full overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-surface-container-lowest text-outline font-label-sm text-label-sm uppercase tracking-wider font-mono">
                                    <th class="py-3 px-space-md font-semibold">Run ID</th>
                                    <th class="py-3 px-space-md font-semibold">Experiment Name</th>
                                    <th class="py-3 px-space-md font-semibold">Algorithm</th>
                                    <th class="py-3 px-space-md font-semibold">Dataset</th>
                                    <th class="py-3 px-space-md font-semibold text-center">Split</th>
                                    <th class="py-3 px-space-md font-semibold text-right">Accuracy</th>
                                    <th class="py-3 px-space-md font-semibold text-right">Precision</th>
                                    <th class="py-3 px-space-md font-semibold text-right">Recall</th>
                                    <th class="py-3 px-space-md font-semibold text-right">F1 Score</th>
                                    <th class="py-3 px-space-md font-semibold text-center">Status</th>
                                    <th class="py-3 px-space-md font-semibold text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-outline-variant/20 font-code-sm text-code-sm font-mono">
                                <!-- Row 1: Running -->
                                <tr class="bg-surface-container hover:bg-surface-container-high/60 transition-colors">
                                    <td class="py-3.5 px-space-md text-tertiary font-bold">EXP-024-03</td>
                                    <td class="py-3.5 px-space-md text-on-surface font-medium">churn_xgboost_optuna_v3</td>
                                    <td class="py-3.5 px-space-md text-on-surface-variant">XGBoost 2.0.3</td>
                                    <td class="py-3.5 px-space-md text-outline">telecom_q3_v2</td>
                                    <td class="py-3.5 px-space-md text-center text-outline">80/10/10</td>
                                    <td class="py-3.5 px-space-md text-right text-outline">--</td>
                                    <td class="py-3.5 px-space-md text-right text-outline">--</td>
                                    <td class="py-3.5 px-space-md text-right text-outline">--</td>
                                    <td class="py-3.5 px-space-md text-right text-tertiary font-bold">CALC (68%)</td>
                                    <td class="py-3.5 px-space-md text-center">
                                        <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded bg-tertiary-container text-tertiary font-semibold text-label-sm">
                                            <span class="w-1.5 h-1.5 rounded-full bg-tertiary animate-pulse"></span>
                                            RUNNING
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-space-md text-right">
                                        <button class="p-1 hover:text-tertiary transition-colors" title="Live Terminal">
                                            <span class="material-symbols-outlined text-base">terminal</span>
                                        </button>
                                    </td>
                                </tr>
                                <!-- Row 2: Queued -->
                                <tr class="bg-surface-container-low/40 hover:bg-surface-container-high/60 transition-colors">
                                    <td class="py-3.5 px-space-md text-on-surface-variant">EXP-024-04</td>
                                    <td class="py-3.5 px-space-md text-on-surface">churn_lightgbm_stratified</td>
                                    <td class="py-3.5 px-space-md text-on-surface-variant">LightGBM 4.1</td>
                                    <td class="py-3.5 px-space-md text-outline">telecom_q3_v2</td>
                                    <td class="py-3.5 px-space-md text-center text-outline">80/10/10</td>
                                    <td class="py-3.5 px-space-md text-right text-outline">--</td>
                                    <td class="py-3.5 px-space-md text-right text-outline">--</td>
                                    <td class="py-3.5 px-space-md text-right text-outline">--</td>
                                    <td class="py-3.5 px-space-md text-right text-outline">--</td>
                                    <td class="py-3.5 px-space-md text-center">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded bg-surface-container-high text-outline font-semibold text-label-sm">
                                            QUEUED
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-space-md text-right">
                                        <button class="p-1 hover:text-on-surface transition-colors" title="Reorder">
                                            <span class="material-symbols-outlined text-base text-outline">swap_vert</span>
                                        </button>
                                    </td>
                                </tr>
                                <!-- Row 3: Current Best (Completed) -->
                                <tr class="bg-surface-container hover:bg-surface-container-high/60 transition-colors">
                                    <td class="py-3.5 px-space-md text-secondary-fixed font-bold">EXP-024-02</td>
                                    <td class="py-3.5 px-space-md text-on-surface font-semibold flex items-center gap-1.5">
                                        <span>churn_xgboost_baseline_v1.2</span>
                                        <span class="material-symbols-outlined text-tertiary text-sm" title="Benchmark Lead">star</span>
                                    </td>
                                    <td class="py-3.5 px-space-md text-on-surface-variant">XGBoost 2.0.3</td>
                                    <td class="py-3.5 px-space-md text-outline">telecom_q3_v1</td>
                                    <td class="py-3.5 px-space-md text-center text-outline">70/15/15</td>
                                    <td class="py-3.5 px-space-md text-right text-on-surface">0.824</td>
                                    <td class="py-3.5 px-space-md text-right text-on-surface">0.781</td>
                                    <td class="py-3.5 px-space-md text-right text-on-surface">0.762</td>
                                    <td class="py-3.5 px-space-md text-right text-secondary-fixed font-bold text-base">0.771</td>
                                    <td class="py-3.5 px-space-md text-center">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded bg-emerald-950/60 text-emerald-400 font-semibold text-label-sm">
                                            COMPLETED
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-space-md text-right">
                                        <button class="p-1 hover:text-secondary transition-colors" title="Compare Artifacts">
                                            <span class="material-symbols-outlined text-base">analytics</span>
                                        </button>
                                    </td>
                                </tr>
                                <!-- Row 4: Random Forest (Completed) -->
                                <tr class="bg-surface-container-low/40 hover:bg-surface-container-high/60 transition-colors">
                                    <td class="py-3.5 px-space-md text-on-surface-variant">EXP-024-01</td>
                                    <td class="py-3.5 px-space-md text-on-surface">churn_random_forest_default</td>
                                    <td class="py-3.5 px-space-md text-on-surface-variant">Scikit-Learn 1.3</td>
                                    <td class="py-3.5 px-space-md text-outline">telecom_q3_v1</td>
                                    <td class="py-3.5 px-space-md text-center text-outline">70/15/15</td>
                                    <td class="py-3.5 px-space-md text-right text-on-surface">0.761</td>
                                    <td class="py-3.5 px-space-md text-right text-on-surface">0.710</td>
                                    <td class="py-3.5 px-space-md text-right text-on-surface">0.742</td>
                                    <td class="py-3.5 px-space-md text-right text-on-surface font-semibold">0.725</td>
                                    <td class="py-3.5 px-space-md text-center">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded bg-emerald-950/60 text-emerald-400 font-semibold text-label-sm">
                                            COMPLETED
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-space-md text-right">
                                        <button class="p-1 hover:text-secondary transition-colors" title="View Metrics">
                                            <span class="material-symbols-outlined text-base">visibility</span>
                                        </button>
                                    </td>
                                </tr>
                                <!-- Row 5: Deep MLP Neural Net (Failed) -->
                                <tr class="bg-surface-container hover:bg-surface-container-high/60 transition-colors">
                                    <td class="py-3.5 px-space-md text-error">EXP-024-00</td>
                                    <td class="py-3.5 px-space-md text-on-surface">churn_mlp_deep_dense_v1</td>
                                    <td class="py-3.5 px-space-md text-on-surface-variant">PyTorch 2.2</td>
                                    <td class="py-3.5 px-space-md text-outline">telecom_q3_v1</td>
                                    <td class="py-3.5 px-space-md text-center text-outline">80/10/10</td>
                                    <td class="py-3.5 px-space-md text-right text-outline">--</td>
                                    <td class="py-3.5 px-space-md text-right text-outline">--</td>
                                    <td class="py-3.5 px-space-md text-right text-outline">--</td>
                                    <td class="py-3.5 px-space-md text-right text-error font-medium">FAIL</td>
                                    <td class="py-3.5 px-space-md text-center">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded bg-error-container text-error font-semibold text-label-sm">
                                            FAILED
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-space-md text-right">
                                        <button class="p-1 hover:text-error transition-colors" title="Crash Logs">
                                            <span class="material-symbols-outlined text-base">bug_report</span>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- Table Pagination / Footer Meta -->
                    <div class="flex flex-wrap items-center justify-between gap-space-sm pt-space-xs text-code-sm font-code-sm text-outline font-mono">
                        <div class="flex items-center gap-2">
                            <span>Rows 1–5 of 18</span>
                            <span>·</span>
                            <span>Target Criteria: <strong>F1 ≥ 0.800</strong></span>
                        </div>
                        <div class="flex items-center gap-1">
                            <button class="px-2.5 py-1 rounded bg-surface-container-high text-on-surface-variant hover:text-on-surface transition-colors">‹ PREV</button>
                            <button class="px-2.5 py-1 rounded bg-secondary-container text-secondary font-bold">1</button>
                            <button class="px-2.5 py-1 rounded bg-surface-container-high text-on-surface-variant hover:text-on-surface transition-colors">2</button>
                            <button class="px-2.5 py-1 rounded bg-surface-container-high text-on-surface-variant hover:text-on-surface transition-colors">3</button>
                            <button class="px-2.5 py-1 rounded bg-surface-container-high text-on-surface-variant hover:text-on-surface transition-colors">NEXT ›</button>
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </div>
    <script src="../../assets/js/app.js"></script>
    <script src="js/main.js"></script>
</body>

</html>