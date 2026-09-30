<!DOCTYPE html>

<html class="dark" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="web_dashboard" name="shell-type" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@100..900&family=Inter:wght@100..900&display=swap" rel="stylesheet" />
    <style>
        @layer base {

            html,
            body {
                margin: 0;
                padding: 0;
            }

            body {
                overscroll-behavior: none;
            }

            main>:first-child {
                margin-top: 0 !important;
            }

            main>:last-child {
                margin-bottom: 0 !important;
            }
        }

        ::-webkit-scrollbar {
            display: none;
        }
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "surface-tint": "#b4c8e3",
                        "on-primary-fixed": "#071d30",
                        "secondary-fixed-dim": "#abc9f2",
                        "outline-variant": "#43474c",
                        "secondary-fixed": "#d2e4ff",
                        "surface-container-high": "#132b45",
                        "outline": "#8e9197",
                        "on-tertiary-fixed-variant": "#643f00",
                        "background": "#00142a",
                        "error-container": "#93000a",
                        "surface-container-lowest": "#000f21",
                        "on-error-container": "#ffdad6",
                        "on-surface-variant": "#c4c6cd",
                        "tertiary": "#ffb956",
                        "secondary-container": "#2b486b",
                        "on-tertiary-container": "#bb7d16",
                        "surface-container": "#06203a",
                        "on-secondary-fixed": "#001c38",
                        "tertiary-container": "#331e00",
                        "surface-container-low": "#021c36",
                        "surface": "#00142a",
                        "primary-fixed": "#d0e4ff",
                        "surface-container-highest": "#1f3651",
                        "on-secondary-container": "#9ab7e0",
                        "on-error": "#690005",
                        "on-primary-container": "#788ca4",
                        "surface-variant": "#1f3651",
                        "inverse-on-surface": "#1a314c",
                        "inverse-primary": "#4d6077",
                        "surface-bright": "#243a56",
                        "on-primary-fixed-variant": "#35485e",
                        "on-primary": "#1e3246",
                        "on-secondary-fixed-variant": "#2b486b",
                        "primary": "#b4c8e3",
                        "on-surface": "#d3e4ff",
                        "primary-fixed-dim": "#b4c8e3",
                        "on-background": "#d3e4ff",
                        "primary-container": "#0f2438",
                        "secondary": "#abc9f2",
                        "on-secondary": "#113253",
                        "on-tertiary-fixed": "#2a1800",
                        "tertiary-fixed-dim": "#ffb956",
                        "error": "#ffb4ab",
                        "surface-dim": "#00142a",
                        "inverse-surface": "#d3e4ff",
                        "tertiary-fixed": "#ffddb5",
                        "on-tertiary": "#462b00"
                    },
                    borderRadius: {
                        DEFAULT: "0.25rem",
                        lg: "0.5rem",
                        xl: "0.75rem",
                        full: "9999px"
                    },
                    spacing: {
                        "space-xl": "2rem",
                        "space-lg": "1.5rem",
                        "margin-mobile": "1rem",
                        margin: "1.5rem",
                        gutter: "1rem",
                        "space-xs": "0.25rem",
                        "space-sm": "0.5rem",
                        "space-md": "1rem",
                        "gutter-compact": "0.5rem"
                    },
                    fontFamily: {
                        "body-md": ["Inter"],
                        "display-lg": ["IBM Plex Sans"],
                        "headline-xl": ["IBM Plex Sans"],
                        "label-sm": ["IBM Plex Sans"],
                        "headline-lg": ["IBM Plex Sans"],
                        "label-md": ["IBM Plex Sans"],
                        "headline-md": ["IBM Plex Sans"],
                        "code-sm": ["JetBrains Mono"],
                        "body-lg": ["Inter"],
                        "body-sm": ["Inter"],
                        "code-md": ["JetBrains Mono"],
                        "title-sm": ["IBM Plex Sans"]
                    },
                    fontSize: {
                        "body-md": ["14px", {
                            lineHeight: "20px",
                            fontWeight: "400"
                        }],
                        "display-lg": ["36px", {
                            lineHeight: "44px",
                            letterSpacing: "-0.02em",
                            fontWeight: "600"
                        }],
                        "headline-xl": ["28px", {
                            lineHeight: "36px",
                            letterSpacing: "-0.015em",
                            fontWeight: "600"
                        }],
                        "label-sm": ["11px", {
                            lineHeight: "14px",
                            letterSpacing: "0.08em",
                            fontWeight: "600"
                        }],
                        "headline-lg": ["22px", {
                            lineHeight: "30px",
                            letterSpacing: "-0.01em",
                            fontWeight: "600"
                        }],
                        "label-md": ["12px", {
                            lineHeight: "16px",
                            letterSpacing: "0.06em",
                            fontWeight: "600"
                        }],
                        "headline-md": ["18px", {
                            lineHeight: "26px",
                            fontWeight: "500"
                        }],
                        "code-sm": ["11px", {
                            lineHeight: "16px",
                            fontWeight: "500"
                        }],
                        "body-lg": ["16px", {
                            lineHeight: "24px",
                            fontWeight: "400"
                        }],
                        "body-sm": ["12px", {
                            lineHeight: "18px",
                            fontWeight: "400"
                        }],
                        "code-md": ["13px", {
                            lineHeight: "18px",
                            fontWeight: "400"
                        }],
                        "title-sm": ["15px", {
                            lineHeight: "22px",
                            fontWeight: "600"
                        }]
                    }
                }
            }
        };
    </script>
</head>

<body class="bg-background font-body-md text-on-surface antialiased min-h-screen selection:bg-tertiary-container selection:text-tertiary">
    <aside class="fixed left-0 top-0 h-full w-72 bg-surface-container-lowest border-r border-outline-variant/30 z-50 flex flex-col justify-between shadow-2xl">
        <div class="flex flex-col">
            <div class="h-28 px-space-md border-b border-outline-variant/30 flex items-center justify-between bg-surface-container-low/60">
                <div class="flex items-center gap-space-sm"><img alt="VOSTOKPRIBOR AI Geometric Logo" class="h-8 w-auto object-contain" src="https://lh3.googleusercontent.com/aida/AEtjO1Ub4brI6u1dsfV-FEmeVRA_JMdFomA6enbXrkXn9IhcRZ2ISluJFc6ehdir_Bz5FjSp6TvAsIkSGf9t8JK1tEonWZxiXhh-8LE6PvmQRmoRB5RYbTk7zIb8VFzky2txPOQWnUkHMuYeMozbKz88yiVcmZUbh14VPbQEj79l9WWKXyA44Zjsx9a4JMBViNOwF_IyZT3p0e3Y27ibSLkAxSS8jHXY8uVFu8sUhBdrgGtRdaZ1F17S-zOW8Z0" />
                    <div class="flex flex-col"><span class="font-headline-md text-title-sm tracking-wider uppercase text-on-surface font-semibold">VOSTOKPRIBOR</span><span class="font-code-sm text-code-sm text-tertiary font-mono tracking-widest uppercase">AI · ML AVIONICS</span></div>
                </div>
                <div class="flex items-center px-space-xs py-0.5 rounded bg-surface-container-high border border-outline-variant/40"><span class="font-code-sm text-code-sm text-on-surface-variant font-mono">v4.2</span></div>
            </div>
            <div class="px-space-md py-space-sm">
                <div class="text-label-sm font-label-sm uppercase tracking-widest text-outline mb-space-xs px-space-xs">Subsystems Dispatch</div>
                <nav class="flex flex-col gap-1" data-active-classes="bg-surface-container-high text-on-surface font-semibold shadow-inner"><a class="group flex items-center justify-between px-space-md py-2.5 rounded-lg text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-all" data-path="projects" href="#">
                        <div class="flex items-center gap-space-sm"><span class="material-symbols-outlined text-outline group-hover:text-primary transition-colors text-lg">folder_special</span><span class="font-code-md text-code-md tracking-tight">SYS-AI-01</span><span class="font-body-sm text-body-sm text-on-surface-variant group-hover:text-on-surface">Projects</span></div><span class="w-1.5 h-1.5 rounded-full bg-outline-variant/60"></span>
                    </a><a class="group flex items-center justify-between px-space-md py-2.5 rounded-lg text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-all" data-path="data-center" href="#">
                        <div class="flex items-center gap-space-sm"><span class="material-symbols-outlined text-outline group-hover:text-primary transition-colors text-lg">dataset</span><span class="font-code-md text-code-md tracking-tight">SYS-AI-02</span><span class="font-body-sm text-body-sm text-on-surface-variant group-hover:text-on-surface">Data Center</span></div><span class="w-1.5 h-1.5 rounded-full bg-outline-variant/60"></span>
                    </a><a aria-current="page" class="group flex items-center justify-between px-space-md py-2.5 rounded-lg border border-outline-variant/40 bg-surface-container-high text-on-surface font-semibold shadow-inner" data-path="workbench" href="#">
                        <div class="flex items-center gap-space-sm"><span class="material-symbols-outlined text-tertiary text-lg">precision_manufacturing</span><span class="font-code-md text-code-md tracking-tight text-tertiary">SYS-AI-03</span><span class="font-body-sm text-body-sm text-on-surface font-medium">Workbench</span></div><span class="w-2 h-2 rounded bg-tertiary shadow-[0_0_8px_rgba(255,185,86,0.8)]"></span>
                    </a><a class="group flex items-center justify-between px-space-md py-2.5 rounded-lg text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-all" data-path="registry-deployment" href="#">
                        <div class="flex items-center gap-space-sm"><span class="material-symbols-outlined text-outline group-hover:text-primary transition-colors text-lg">rocket_launch</span><span class="font-code-md text-code-md tracking-tight">SYS-AI-04</span><span class="font-body-sm text-body-sm text-on-surface-variant group-hover:text-on-surface">Registry & Deploy</span></div><span class="w-1.5 h-1.5 rounded-full bg-outline-variant/60"></span>
                    </a><a class="group flex items-center justify-between px-space-md py-2.5 rounded-lg text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-all" data-path="ai-soc" href="#">
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
                <div class="flex items-center shrink-0 px-2 py-1 rounded bg-tertiary-container text-tertiary-fixed font-mono border border-tertiary/60 shadow-[0_0_10px_rgba(255,185,86,0.3)]">7. Architecture</div><span class="text-tertiary">›</span>
                <div class="flex items-center shrink-0 px-2 py-1 rounded bg-secondary-container/80 text-secondary-fixed font-mono border border-secondary/40 shadow-sm">8. Hyperparam</div><span class="text-tertiary">›</span>
                <div class="flex items-center shrink-0 px-2 py-1 rounded bg-secondary-container/80 text-secondary-fixed font-mono border border-secondary/40 shadow-sm">9. Eval & Validate</div><span class="text-outline-variant">›</span>
                <div class="flex items-center shrink-0 px-2 py-1 text-outline font-mono">10. Explainability</div><span class="text-outline-variant">›</span>
                <div class="flex items-center shrink-0 px-2 py-1 text-outline font-mono">11. Registry</div><span class="text-outline-variant">›</span>
                <div class="flex items-center shrink-0 px-2 py-1 text-outline font-mono">12. Canary</div><span class="text-outline-variant">›</span>
                <div class="flex items-center shrink-0 px-2 py-1 text-outline font-mono">13. Production</div><span class="text-outline-variant">›</span>
                <div class="flex items-center shrink-0 px-2 py-1 text-outline font-mono">14. Drift</div>
            </div>
        </header>
        <main class="w-full pt-28 bg-surface flex-1 min-h-[calc(100vh-7rem)] p-space-md">
            <div class="flex flex-col w-full gap-space-lg">
                <!-- TOP CONTEXT & STATUS BAR -->
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-space-md">
                    <div class="flex flex-col">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="px-2 py-0.5 rounded bg-surface-container-high text-tertiary font-code-sm text-code-sm">SYS-AI-03 // BENCHMARK</span>
                            <span class="text-outline text-label-sm font-label-sm uppercase tracking-wider">Telemetry Run Comparer</span>
                        </div>
                        <h1 class="font-headline-xl text-headline-xl text-on-surface font-semibold tracking-tight">
                            Comparing 4 Model Runs <span class="text-outline font-normal">·</span> Ticket #AI-024 (Customer Churn)
                        </h1>
                    </div>
                    <div class="flex items-center gap-space-sm self-stretch md:self-auto">
                        <div class="flex items-center gap-2 px-3 py-1.5 rounded-lg bg-surface-container-high text-on-surface font-code-sm text-code-sm shadow-sm">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                            <span class="text-on-surface-variant font-mono">CROSS-VALIDATION:</span>
                            <span class="text-primary font-bold">5-FOLD STRATIFIED</span>
                        </div>
                        <button class="h-9 px-3 rounded-lg bg-surface-container-high hover:bg-surface-container-highest text-on-surface text-label-sm font-label-sm uppercase tracking-wider flex items-center gap-1.5 transition-colors">
                            <span class="material-symbols-outlined text-base text-outline">tune</span>
                            Config Filters
                        </button>
                    </div>
                </div>
                <!-- PROMINENT SUCCESS / DEPLOYMENT TARGET BANNER -->
                <div class="relative overflow-hidden rounded-xl bg-gradient-to-r from-emerald-950 via-surface-container-low to-surface-container-high p-space-lg shadow-xl">
                    <div class="absolute -right-8 -bottom-8 w-64 h-64 rounded-full bg-emerald-500/10 blur-3xl pointer-events-none"></div>
                    <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-space-md">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-xl bg-emerald-500/20 text-emerald-300 flex items-center justify-center shrink-0 shadow-inner">
                                <span class="material-symbols-outlined text-2xl" style="font-variation-settings: 'FILL' 1;">verified</span>
                            </div>
                            <div class="flex flex-col">
                                <div class="flex items-center gap-2">
                                    <span class="px-2 py-0.5 rounded-full bg-emerald-400/20 text-emerald-300 font-label-sm text-label-sm uppercase tracking-widest font-semibold">Requirement Satisfied</span>
                                    <span class="text-outline text-label-sm font-label-sm font-mono">CRITERIA: F1 ≥ 0.800</span>
                                </div>
                                <h2 class="font-headline-lg text-headline-lg text-on-surface font-semibold mt-1">
                                    Business threshold met. Ready for deployment.
                                </h2>
                                <p class="font-body-md text-body-md text-on-surface-variant max-w-2xl mt-0.5">
                                    <strong class="text-emerald-300 font-medium">Experiment 02 (Random Forest Tuned)</strong> complies with operational service-level agreement latency constraints (≤ 22ms) while hitting target metric <span class="font-code-sm text-code-sm text-emerald-200 bg-emerald-900/50 px-1.5 py-0.5 rounded font-mono">F1 = 0.801</span>.
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-space-md shrink-0 self-end lg:self-center">
                            <div class="flex flex-col text-right hidden sm:flex">
                                <span class="text-label-sm font-label-sm text-outline uppercase font-mono">Candidate ID</span>
                                <span class="text-title-sm font-title-sm text-on-surface font-mono">RUN-2024-02-RF</span>
                            </div>
                            <button class="h-10 px-4 rounded-lg bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-label-sm text-label-sm uppercase tracking-wider font-semibold shadow-lg flex items-center gap-2 transition-all transform active:scale-95" onclick="highlightRun('run-02')">
                                <span class="material-symbols-outlined text-base" style="font-variation-settings: 'FILL' 1;">rocket_launch</span>
                                Fast-Track Deploy #02
                            </button>
                        </div>
                    </div>
                </div>
                <!-- RUN SELECTOR & PINNING DOCK -->
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-space-md">
                    <!-- Run 1: Logistic Baseline -->
                    <div class="run-card relative rounded-xl bg-surface-container-high p-space-md flex flex-col justify-between hover:bg-surface-bright transition-all cursor-pointer group shadow-sm" id="card-run-01">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full bg-slate-400 shadow-sm"></span>
                                <span class="font-code-sm text-code-sm text-on-surface font-mono font-semibold">RUN #01</span>
                                <span class="text-outline text-label-sm font-label-sm">BASELINE</span>
                            </div>
                            <button class="text-outline hover:text-tertiary transition-colors" title="Pin Run">
                                <span class="material-symbols-outlined text-lg">star_border</span>
                            </button>
                        </div>
                        <div class="my-3">
                            <div class="font-title-sm text-title-sm text-on-surface font-medium truncate">Logistic Regression</div>
                            <div class="font-body-sm text-body-sm text-on-surface-variant">L2 Penalty · C=0.01 Standardized</div>
                        </div>
                        <div class="flex items-baseline justify-between pt-2">
                            <div class="flex flex-col">
                                <span class="text-label-sm font-label-sm text-outline uppercase">F1 Metric</span>
                                <span class="font-headline-md text-headline-md text-slate-300 font-mono">0.714</span>
                            </div>
                            <span class="px-2 py-0.5 rounded text-label-sm font-label-sm bg-surface-container-lowest text-outline font-mono">Under SLA</span>
                        </div>
                    </div>
                    <!-- Run 2: Random Forest (Pinned & Target Met) -->
                    <div class="run-card relative rounded-xl bg-surface-container-highest p-space-md flex flex-col justify-between hover:bg-surface-bright transition-all cursor-pointer group shadow-md ring-2 ring-emerald-500/70" id="card-run-02">
                        <div class="absolute top-2 right-2">
                            <span class="flex h-2 w-2 relative">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                            </span>
                        </div>
                        <div class="flex items-start justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full bg-tertiary shadow-[0_0_8px_rgba(255,185,86,0.8)]"></span>
                                <span class="font-code-sm text-code-sm text-tertiary font-mono font-bold">RUN #02</span>
                                <span class="px-1.5 py-0.2 rounded bg-tertiary-container text-tertiary font-label-sm text-label-sm font-mono uppercase">Pinned</span>
                            </div>
                            <button class="text-tertiary" title="Unpin Run">
                                <span class="material-symbols-outlined text-lg" style="font-variation-settings: 'FILL' 1;">star</span>
                            </button>
                        </div>
                        <div class="my-3">
                            <div class="font-title-sm text-title-sm text-on-surface font-semibold flex items-center gap-1.5">
                                Random Forest (Tuned)
                                <span class="material-symbols-outlined text-emerald-400 text-sm">verified</span>
                            </div>
                            <div class="font-body-sm text-body-sm text-on-surface-variant">n_est=250 · depth=12 · Balanced</div>
                        </div>
                        <div class="flex items-baseline justify-between pt-2">
                            <div class="flex flex-col">
                                <span class="text-label-sm font-label-sm text-emerald-400 uppercase font-semibold">F1 Metric (Pass)</span>
                                <span class="font-headline-md text-headline-md text-emerald-300 font-mono font-bold">0.801</span>
                            </div>
                            <span class="px-2 py-0.5 rounded text-label-sm font-label-sm bg-emerald-950 text-emerald-300 font-mono font-medium">Ready</span>
                        </div>
                    </div>
                    <!-- Run 3: XGBoost Optuna Trial 24 (Best Overall) -->
                    <div class="run-card relative rounded-xl bg-surface-container-high p-space-md flex flex-col justify-between hover:bg-surface-bright transition-all cursor-pointer group shadow-sm" id="card-run-03">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full bg-cyan-400 shadow-[0_0_8px_rgba(34,211,238,0.7)]"></span>
                                <span class="font-code-sm text-code-sm text-cyan-300 font-mono font-bold">RUN #03</span>
                                <span class="px-1.5 py-0.2 rounded bg-cyan-950 text-cyan-300 font-label-sm text-label-sm font-mono uppercase">Top Score</span>
                            </div>
                            <button class="text-cyan-400" title="Starred">
                                <span class="material-symbols-outlined text-lg" style="font-variation-settings: 'FILL' 1;">star</span>
                            </button>
                        </div>
                        <div class="my-3">
                            <div class="font-title-sm text-title-sm text-on-surface font-semibold">XGBoost (Optuna #24)</div>
                            <div class="font-body-sm text-body-sm text-on-surface-variant">lr=0.04 · max_d=6 · reg_a=1.2</div>
                        </div>
                        <div class="flex items-baseline justify-between pt-2">
                            <div class="flex flex-col">
                                <span class="text-label-sm font-label-sm text-cyan-400 uppercase">F1 Metric · Apex</span>
                                <span class="font-headline-md text-headline-md text-cyan-300 font-mono font-bold">0.834</span>
                            </div>
                            <span class="px-2 py-0.5 rounded text-label-sm font-label-sm bg-cyan-950/80 text-cyan-200 font-mono">+3.3% Target</span>
                        </div>
                    </div>
                    <!-- Run 4: LightGBM Default -->
                    <div class="run-card relative rounded-xl bg-surface-container-high p-space-md flex flex-col justify-between hover:bg-surface-bright transition-all cursor-pointer group shadow-sm" id="card-run-04">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full bg-indigo-400 shadow-sm"></span>
                                <span class="font-code-sm text-code-sm text-on-surface font-mono font-semibold">RUN #04</span>
                                <span class="text-outline text-label-sm font-label-sm">CANDIDATE</span>
                            </div>
                            <button class="text-outline hover:text-tertiary transition-colors" title="Pin Run">
                                <span class="material-symbols-outlined text-lg">star_border</span>
                            </button>
                        </div>
                        <div class="my-3">
                            <div class="font-title-sm text-title-sm text-on-surface font-medium truncate">LightGBM (Default)</div>
                            <div class="font-body-sm text-body-sm text-on-surface-variant">num_leaves=31 · lr=0.10</div>
                        </div>
                        <div class="flex items-baseline justify-between pt-2">
                            <div class="flex flex-col">
                                <span class="text-label-sm font-label-sm text-outline uppercase">F1 Metric</span>
                                <span class="font-headline-md text-headline-md text-slate-300 font-mono">0.762</span>
                            </div>
                            <span class="px-2 py-0.5 rounded text-label-sm font-label-sm bg-surface-container-lowest text-outline font-mono">Under SLA</span>
                        </div>
                    </div>
                </div>
                <!-- COMPARISON MATRIX HIGH-DENSITY TABLE -->
                <div class="rounded-xl bg-surface-container-low shadow-xl overflow-hidden flex flex-col">
                    <div class="p-space-md bg-surface-container-high flex flex-col sm:flex-row sm:items-center justify-between gap-space-sm">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-tertiary text-xl">table_chart_view</span>
                            <span class="font-title-sm text-title-sm text-on-surface font-semibold">Telemetry Run Attribute & Metric Matrix</span>
                            <span class="px-2 py-0.5 rounded bg-surface-container-highest text-on-surface-variant text-label-sm font-label-sm font-mono">4 SAMPLES LOADED</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-outline text-label-sm font-label-sm uppercase font-mono">Highlight Diff:</span>
                            <button class="px-2.5 py-1 rounded bg-secondary-container text-secondary-fixed text-label-sm font-label-sm font-mono hover:bg-secondary-container/80 transition-colors">Key Metrics</button>
                            <button class="px-2.5 py-1 rounded bg-surface-container-highest text-on-surface-variant hover:text-on-surface text-label-sm font-label-sm font-mono transition-colors">Hyperparams</button>
                        </div>
                    </div>
                    <div class="overflow-x-auto w-full">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-surface-container-lowest text-outline text-label-sm font-label-sm tracking-wider uppercase font-mono">
                                    <th class="py-3 px-4 w-12 text-center">Pin</th>
                                    <th class="py-3 px-4">Run Identifier</th>
                                    <th class="py-3 px-4">Model Architecture</th>
                                    <th class="py-3 px-4">Pipeline Prep</th>
                                    <th class="py-3 px-4">Key Hyperparameters</th>
                                    <th class="py-3 px-4 text-right">Train Latency</th>
                                    <th class="py-3 px-4 text-right">Accuracy</th>
                                    <th class="py-3 px-4 text-right">Precision</th>
                                    <th class="py-3 px-4 text-right">Recall</th>
                                    <th class="py-3 px-4 text-right">F1 Score</th>
                                    <th class="py-3 px-4 text-center">Verdict</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-transparent font-code-sm text-code-sm">
                                <!-- Row 1: Baseline -->
                                <tr class="hover:bg-surface-container transition-colors bg-surface-container-low/50">
                                    <td class="py-3.5 px-4 text-center">
                                        <button class="text-outline hover:text-tertiary transition-colors"><span class="material-symbols-outlined text-base">star_border</span></button>
                                    </td>
                                    <td class="py-3.5 px-4 font-mono text-on-surface font-semibold">
                                        RUN-01-LOGREG
                                    </td>
                                    <td class="py-3.5 px-4 text-on-surface-variant font-body-sm">
                                        LogisticRegression (SGD)
                                    </td>
                                    <td class="py-3.5 px-4 text-outline font-mono">
                                        v1.4-StandardScalar
                                    </td>
                                    <td class="py-3.5 px-4 text-on-surface-variant font-mono text-code-sm">
                                        <span class="text-outline">C=0.01, penalty='l2', solver='lbfgs'</span>
                                    </td>
                                    <td class="py-3.5 px-4 text-right text-on-surface-variant font-mono">
                                        1.4s
                                    </td>
                                    <td class="py-3.5 px-4 text-right font-mono text-on-surface-variant">78.1%</td>
                                    <td class="py-3.5 px-4 text-right font-mono text-on-surface-variant">74.3%</td>
                                    <td class="py-3.5 px-4 text-right font-mono text-on-surface-variant">68.7%</td>
                                    <td class="py-3.5 px-4 text-right font-mono font-medium text-slate-300">0.714</td>
                                    <td class="py-3.5 px-4 text-center">
                                        <span class="inline-block px-2 py-0.5 rounded bg-surface-container-high text-outline text-label-sm font-label-sm uppercase font-mono">Baseline</span>
                                    </td>
                                </tr>
                                <!-- Row 2: Random Forest (Pinned & Target) -->
                                <tr class="hover:bg-surface-container-high/90 transition-colors bg-emerald-950/20 font-medium">
                                    <td class="py-3.5 px-4 text-center">
                                        <button class="text-tertiary"><span class="material-symbols-outlined text-base" style="font-variation-settings: 'FILL' 1;">star</span></button>
                                    </td>
                                    <td class="py-3.5 px-4 font-mono text-tertiary font-bold flex items-center gap-1.5">
                                        <span>RUN-02-RF-TUNED</span>
                                        <span class="px-1.5 py-0.2 rounded bg-tertiary-container text-tertiary font-label-sm text-label-sm">SEL</span>
                                    </td>
                                    <td class="py-3.5 px-4 text-on-surface font-body-sm">
                                        RandomForestClassifier
                                    </td>
                                    <td class="py-3.5 px-4 text-secondary font-mono">
                                        v2.1-Robust+WOE
                                    </td>
                                    <td class="py-3.5 px-4 font-mono text-code-sm text-on-surface">
                                        <span class="text-tertiary font-bold">n_est=250</span>, max_d=12, split=4, crit='gini'
                                    </td>
                                    <td class="py-3.5 px-4 text-right text-on-surface-variant font-mono">
                                        14.8s
                                    </td>
                                    <td class="py-3.5 px-4 text-right font-mono text-on-surface">84.2%</td>
                                    <td class="py-3.5 px-4 text-right font-mono text-on-surface">81.0%</td>
                                    <td class="py-3.5 px-4 text-right font-mono text-on-surface">79.2%</td>
                                    <td class="py-3.5 px-4 text-right font-mono text-emerald-300 font-bold text-headline-sm">0.801</td>
                                    <td class="py-3.5 px-4 text-center">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-emerald-950 text-emerald-300 text-label-sm font-label-sm font-mono font-semibold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> TARGET MET
                                        </span>
                                    </td>
                                </tr>
                                <!-- Row 3: XGBoost -->
                                <tr class="hover:bg-surface-container transition-colors bg-surface-container-low/50">
                                    <td class="py-3.5 px-4 text-center">
                                        <button class="text-cyan-400"><span class="material-symbols-outlined text-base" style="font-variation-settings: 'FILL' 1;">star</span></button>
                                    </td>
                                    <td class="py-3.5 px-4 font-mono text-cyan-300 font-bold">
                                        RUN-03-XGB-OPTUNA
                                    </td>
                                    <td class="py-3.5 px-4 text-on-surface-variant font-body-sm">
                                        XGBClassifier (Hist)
                                    </td>
                                    <td class="py-3.5 px-4 text-secondary font-mono">
                                        v2.1-Robust+WOE
                                    </td>
                                    <td class="py-3.5 px-4 font-mono text-code-sm text-on-surface-variant">
                                        <span class="text-cyan-300">lr=0.04</span>, max_d=6, reg_a=1.2, colsample=0.8
                                    </td>
                                    <td class="py-3.5 px-4 text-right text-on-surface-variant font-mono">
                                        28.4s
                                    </td>
                                    <td class="py-3.5 px-4 text-right font-mono text-cyan-200">86.1%</td>
                                    <td class="py-3.5 px-4 text-right font-mono text-cyan-200">83.5%</td>
                                    <td class="py-3.5 px-4 text-right font-mono text-cyan-200">83.2%</td>
                                    <td class="py-3.5 px-4 text-right font-mono text-cyan-300 font-bold">0.834</td>
                                    <td class="py-3.5 px-4 text-center">
                                        <span class="inline-block px-2 py-0.5 rounded bg-cyan-950 text-cyan-300 text-label-sm font-label-sm uppercase font-mono font-medium">Apex F1</span>
                                    </td>
                                </tr>
                                <!-- Row 4: LightGBM -->
                                <tr class="hover:bg-surface-container transition-colors bg-surface-container-low/30">
                                    <td class="py-3.5 px-4 text-center">
                                        <button class="text-outline hover:text-tertiary transition-colors"><span class="material-symbols-outlined text-base">star_border</span></button>
                                    </td>
                                    <td class="py-3.5 px-4 font-mono text-on-surface font-semibold">
                                        RUN-04-LGBM-DEF
                                    </td>
                                    <td class="py-3.5 px-4 text-on-surface-variant font-body-sm">
                                        LGBMClassifier
                                    </td>
                                    <td class="py-3.5 px-4 text-secondary font-mono">
                                        v2.1-Robust+WOE
                                    </td>
                                    <td class="py-3.5 px-4 font-mono text-code-sm text-outline">
                                        num_leaves=31, lr=0.10, min_child_samples=20
                                    </td>
                                    <td class="py-3.5 px-4 text-right text-on-surface-variant font-mono">
                                        4.6s
                                    </td>
                                    <td class="py-3.5 px-4 text-right font-mono text-on-surface-variant">80.4%</td>
                                    <td class="py-3.5 px-4 text-right font-mono text-on-surface-variant">77.1%</td>
                                    <td class="py-3.5 px-4 text-right font-mono text-on-surface-variant">75.4%</td>
                                    <td class="py-3.5 px-4 text-right font-mono text-slate-300">0.762</td>
                                    <td class="py-3.5 px-4 text-center">
                                        <span class="inline-block px-2 py-0.5 rounded bg-surface-container-high text-outline text-label-sm font-label-sm uppercase font-mono">Candidate</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="px-space-md py-2.5 bg-surface-container-lowest flex items-center justify-between text-outline font-label-sm text-label-sm">
                        <div class="flex items-center gap-4">
                            <span>Evaluated on <strong class="text-on-surface font-mono">test_split_v2 (N=12,450)</strong></span>
                            <span>Cross-entropy Loss delta: <strong class="text-emerald-400 font-mono">-0.142</strong> vs Baseline</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            <span class="text-on-surface font-mono">All 4 Runs Normalized Against Target Ticket #AI-024</span>
                        </div>
                    </div>
                </div>
                <!-- INTERACTIVE MULTI-MODAL VISUALIZATIONS GRID -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-md">
                    <!-- LEFT PANEL: PARALLEL COORDINATES PLOT (HYPERPARAMS TO F1) -->
                    <div class="lg:col-span-7 rounded-xl bg-surface-container-high p-space-lg flex flex-col justify-between shadow-xl">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex flex-col">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-tertiary text-lg">stacked_line_chart</span>
                                    <h3 class="font-title-sm text-title-sm text-on-surface font-semibold">Parallel Coordinates: Hyperparameters → F1</h3>
                                </div>
                                <span class="font-body-sm text-body-sm text-on-surface-variant">Coordinate trajectories mapping multi-dimensional hyperparameter spaces to metric convergence</span>
                            </div>
                            <div class="flex items-center gap-2 text-label-sm font-label-sm font-mono">
                                <span class="flex items-center gap-1 text-tertiary"><span class="w-3 h-0.5 bg-tertiary inline-block"></span>RF #02</span>
                                <span class="flex items-center gap-1 text-cyan-300"><span class="w-3 h-0.5 bg-cyan-400 inline-block"></span>XGB #03</span>
                                <span class="flex items-center gap-1 text-slate-400"><span class="w-3 h-0.5 bg-slate-400 inline-block"></span>Base #01</span>
                                <span class="flex items-center gap-1 text-indigo-400"><span class="w-3 h-0.5 bg-indigo-400 inline-block"></span>LGB #04</span>
                            </div>
                        </div>
                        <!-- Parallel Coordinates SVG Canvas -->
                        <div class="relative w-full h-72 my-2 bg-surface-container-lowest rounded-lg p-space-sm flex flex-col justify-between overflow-hidden">
                            <!-- Axis labels top -->
                            <div class="grid grid-cols-5 text-center text-label-sm font-label-sm text-outline font-mono z-10">
                                <div>learning_rate</div>
                                <div>max_depth</div>
                                <div>min_split</div>
                                <div>l2_reg (alpha)</div>
                                <div class="text-tertiary font-bold">F1_Score</div>
                            </div>
                            <!-- SVG Visual Paths -->
                            <svg class="absolute inset-0 w-full h-full p-6 pt-9 pb-8" preserveaspectratio="none" viewbox="0 0 600 200">
                                <!-- Background Grid Vertical Axes -->
                                <line class="text-surface-variant" stroke="currentColor" stroke-dasharray="2 3" stroke-width="1.5" x1="20" x2="20" y1="10" y2="190"></line>
                                <line class="text-surface-variant" stroke="currentColor" stroke-dasharray="2 3" stroke-width="1.5" x1="160" x2="160" y1="10" y2="190"></line>
                                <line class="text-surface-variant" stroke="currentColor" stroke-dasharray="2 3" stroke-width="1.5" x1="300" x2="300" y1="10" y2="190"></line>
                                <line class="text-surface-variant" stroke="currentColor" stroke-dasharray="2 3" stroke-width="1.5" x1="440" x2="440" y1="10" y2="190"></line>
                                <line class="text-tertiary/40" stroke="currentColor" stroke-width="2" x1="580" x2="580" y1="10" y2="190"></line>
                                <!-- Target SLA Line across F1 axis -->
                                <line stroke="#ffb956" stroke-width="2.5" x1="565" x2="595" y1="75" y2="75"></line>
                                <text fill="#ffb956" font-family="JetBrains Mono" font-size="9" font-weight="bold" x="545" y="70">TARGET 0.80</text>
                                <!-- Run 01: Baseline Logistic (Slate) -->
                                <path class="hover:stroke-width-4 transition-all" d="M 20,40 C 90,40 90,170 160,170 C 230,170 230,160 300,160 C 370,160 370,40 440,40 C 510,40 510,140 580,140" fill="none" stroke="#94a3b8" stroke-opacity="0.65" stroke-width="2"></path>
                                <!-- Run 04: LightGBM Default (Indigo) -->
                                <path class="hover:stroke-width-4 transition-all" d="M 20,60 C 90,60 90,110 160,110 C 230,110 230,120 300,120 C 370,120 370,140 440,140 C 510,140 510,105 580,105" fill="none" stroke="#818cf8" stroke-opacity="0.8" stroke-width="2.5"></path>
                                <!-- Run 02: Random Forest Tuned (Amber / Pinned) -->
                                <path class="filter drop-shadow-[0_0_8px_rgba(255,185,86,0.6)]" d="M 20,150 C 90,150 90,50 160,50 C 230,50 230,80 300,80 C 370,80 370,100 440,100 C 510,100 510,75 580,75" fill="none" stroke="#ffb956" stroke-opacity="1" stroke-width="4"></path>
                                <!-- Key Points on Run 02 -->
                                <circle cx="20" cy="150" fill="#ffb956" r="4"></circle>
                                <circle cx="160" cy="50" fill="#ffb956" r="4"></circle>
                                <circle cx="300" cy="80" fill="#ffb956" r="4"></circle>
                                <circle cx="440" cy="100" fill="#ffb956" r="4"></circle>
                                <circle cx="580" cy="75" fill="#ffb956" r="5"></circle>
                                <!-- Run 03: XGBoost Trial 24 (Cyan / Apex) -->
                                <path d="M 20,130 C 90,130 90,100 160,100 C 230,100 230,60 300,60 C 370,60 370,50 440,50 C 510,50 510,45 580,45" fill="none" stroke="#22d3ee" stroke-dasharray="5 3" stroke-opacity="0.95" stroke-width="3"></path>
                                <circle cx="580" cy="45" fill="#22d3ee" r="4"></circle>
                            </svg>
                            <!-- Axis labels bottom values -->
                            <div class="grid grid-cols-5 text-center text-code-sm font-code-sm text-on-surface-variant font-mono z-10 pt-2">
                                <div><span class="text-outline text-label-sm block">0.001 - 0.50</span>η = 0.04</div>
                                <div><span class="text-outline text-label-sm block">1 - 32</span>D = 12</div>
                                <div><span class="text-outline text-label-sm block">2 - 20</span>k = 4</div>
                                <div><span class="text-outline text-label-sm block">0.0 - 5.0</span>α = 1.0</div>
                                <div class="text-emerald-300 font-bold"><span class="text-outline text-label-sm block">0.60 - 0.95</span>0.801 ★</div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between text-outline font-label-sm text-label-sm pt-2">
                            <span class="flex items-center gap-1 font-mono">
                                <span class="material-symbols-outlined text-sm text-tertiary">info</span>
                                Observation: RF depth=12 avoids extreme tree variance while maintaining low split noise.
                            </span>
                            <button class="text-primary hover:text-on-surface font-mono transition-colors">Expand Full Tensor Plot →</button>
                        </div>
                    </div>
                    <!-- RIGHT PANEL: DUAL OVERLAID CURVES (ROC & PR CURVES) -->
                    <div class="lg:col-span-5 rounded-xl bg-surface-container-high p-space-lg flex flex-col justify-between shadow-xl">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex flex-col">
                                <h3 class="font-title-sm text-title-sm text-on-surface font-semibold">ROC & Precision-Recall Curves</h3>
                                <span class="font-body-sm text-body-sm text-on-surface-variant">False Positive Trade-off vs Probability Threshold</span>
                            </div>
                            <div class="flex rounded-lg bg-surface-container-lowest p-0.5">
                                <button class="px-2.5 py-1 rounded bg-secondary-container text-secondary-fixed text-label-sm font-label-sm font-mono font-medium shadow-sm" id="btn-toggle-roc">ROC</button>
                                <button class="px-2.5 py-1 rounded text-outline hover:text-on-surface text-label-sm font-label-sm font-mono transition-colors" id="btn-toggle-pr">P-R</button>
                            </div>
                        </div>
                        <!-- Overlaid Chart Graphic -->
                        <div class="relative w-full h-72 my-2 bg-surface-container-lowest rounded-lg p-space-sm flex flex-col justify-between overflow-hidden">
                            <svg class="w-full h-full" preserveaspectratio="none" viewbox="0 0 320 220">
                                <!-- Coordinates Grid -->
                                <line class="text-surface-variant/40" stroke="currentColor" stroke-width="1" x1="40" x2="300" y1="20" y2="20"></line>
                                <line class="text-surface-variant/40" stroke="currentColor" stroke-width="1" x1="40" x2="300" y1="65" y2="65"></line>
                                <line class="text-surface-variant/40" stroke="currentColor" stroke-width="1" x1="40" x2="300" y1="110" y2="110"></line>
                                <line class="text-surface-variant/40" stroke="currentColor" stroke-width="1" x1="40" x2="300" y1="155" y2="155"></line>
                                <line class="text-surface-variant" stroke="currentColor" stroke-width="1.5" x1="40" x2="300" y1="200" y2="200"></line>
                                <line class="text-surface-variant" stroke="currentColor" stroke-width="1.5" x1="40" x2="40" y1="20" y2="200"></line>
                                <line class="text-surface-variant/40" stroke="currentColor" stroke-width="1" x1="105" x2="105" y1="20" y2="200"></line>
                                <line class="text-surface-variant/40" stroke="currentColor" stroke-width="1" x1="170" x2="170" y1="20" y2="200"></line>
                                <line class="text-surface-variant/40" stroke="currentColor" stroke-width="1" x1="235" x2="235" y1="20" y2="200"></line>
                                <line class="text-surface-variant/40" stroke="currentColor" stroke-width="1" x1="300" x2="300" y1="20" y2="200"></line>
                                <!-- Diagonal 45-deg Reference line -->
                                <line class="text-outline-variant/60" stroke="currentColor" stroke-dasharray="3 3" stroke-width="1.5" x1="40" x2="300" y1="200" y2="20"></line>
                                <!-- Run 01: Logistic Regression AUC 0.79 -->
                                <path d="M 40,200 Q 110,130 180,80 T 300,20" fill="none" stroke="#94a3b8" stroke-opacity="0.7" stroke-width="2"></path>
                                <!-- Run 04: LightGBM AUC 0.83 -->
                                <path d="M 40,200 Q 90,95 160,55 T 300,20" fill="none" stroke="#818cf8" stroke-opacity="0.8" stroke-width="2.5"></path>
                                <!-- Run 02: Random Forest AUC 0.88 (Target Run) -->
                                <path class="filter drop-shadow-[0_0_6px_rgba(255,185,86,0.6)]" d="M 40,200 Q 70,60 140,40 T 300,20" fill="none" stroke="#ffb956" stroke-width="3.5"></path>
                                <circle cx="85" cy="52" fill="#ffb956" r="4"></circle>
                                <!-- Run 03: XGBoost AUC 0.91 -->
                                <path d="M 40,200 Q 60,40 120,30 T 300,20" fill="none" stroke="#22d3ee" stroke-dasharray="4 2" stroke-width="2.5"></path>
                                <circle cx="70" cy="38" fill="#22d3ee" r="4"></circle>
                                <!-- Y Axis Labels -->
                                <text fill="#8e9197" font-family="JetBrains Mono" font-size="9" text-anchor="end" x="32" y="24">1.0</text>
                                <text fill="#8e9197" font-family="JetBrains Mono" font-size="9" text-anchor="end" x="32" y="114">0.5</text>
                                <text fill="#8e9197" font-family="JetBrains Mono" font-size="9" text-anchor="end" x="32" y="202">0.0</text>
                                <!-- X Axis Labels -->
                                <text fill="#8e9197" font-family="JetBrains Mono" font-size="9" text-anchor="middle" x="40" y="214">0.0</text>
                                <text fill="#8e9197" font-family="JetBrains Mono" font-size="9" text-anchor="middle" x="170" y="214">0.5</text>
                                <text fill="#8e9197" font-family="JetBrains Mono" font-size="9" text-anchor="middle" x="300" y="214">1.0 (FPR)</text>
                            </svg>
                            <!-- Metric Scoreboard inside graphic container -->
                            <div class="grid grid-cols-4 gap-2 pt-1 border-t border-transparent">
                                <div class="flex flex-col text-left">
                                    <span class="text-label-sm font-label-sm text-outline font-mono">RUN 01</span>
                                    <span class="font-code-sm text-code-sm text-slate-400 font-mono">AUC 0.79</span>
                                </div>
                                <div class="flex flex-col text-left">
                                    <span class="text-label-sm font-label-sm text-tertiary font-mono">RUN 02 ★</span>
                                    <span class="font-code-sm text-code-sm text-tertiary font-mono font-bold">AUC 0.88</span>
                                </div>
                                <div class="flex flex-col text-left">
                                    <span class="text-label-sm font-label-sm text-cyan-400 font-mono">RUN 03</span>
                                    <span class="font-code-sm text-code-sm text-cyan-300 font-mono font-bold">AUC 0.91</span>
                                </div>
                                <div class="flex flex-col text-left">
                                    <span class="text-label-sm font-label-sm text-indigo-400 font-mono">RUN 04</span>
                                    <span class="font-code-sm text-code-sm text-indigo-300 font-mono">AUC 0.83</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between text-outline font-label-sm text-label-sm pt-2">
                            <span class="font-mono text-tertiary font-semibold">Hovered Cutoff: Threshold θ = 0.42 → Sensitivity 84%</span>
                            <button class="text-primary hover:text-on-surface font-mono transition-colors">Calibration Map →</button>
                        </div>
                    </div>
                </div>
                <!-- OPERATIONAL FLIGHT INSTRUMENT DETAIL TILES (HIGH CONTRAST BENTO) -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-space-md">
                    <!-- Tile 1: Latency & Memory Footprint -->
                    <div class="rounded-xl bg-surface-container-high p-space-md flex flex-col justify-between shadow-sm">
                        <div class="flex items-center justify-between">
                            <span class="text-label-sm font-label-sm text-outline uppercase font-mono">Inference Latency (p99)</span>
                            <span class="material-symbols-outlined text-outline text-lg">speed</span>
                        </div>
                        <div class="my-2">
                            <div class="font-headline-lg text-headline-lg text-on-surface font-mono font-semibold">18.4 ms</div>
                            <div class="font-body-sm text-body-sm text-emerald-400 font-medium mt-0.5">✓ Under maximum 25ms SLA constraint</div>
                        </div>
                        <div class="w-full bg-surface-container-lowest h-2 rounded-full overflow-hidden">
                            <div class="bg-emerald-400 h-full rounded-full" style="width: 73.6%;"></div>
                        </div>
                        <div class="flex justify-between text-label-sm font-label-sm text-outline font-mono mt-2">
                            <span>0 ms</span>
                            <span>Run #02: 18.4ms</span>
                            <span>25ms limit</span>
                        </div>
                    </div>
                    <!-- Tile 2: Data Drift Sensitivity -->
                    <div class="rounded-xl bg-surface-container-high p-space-md flex flex-col justify-between shadow-sm">
                        <div class="flex items-center justify-between">
                            <span class="text-label-sm font-label-sm text-outline uppercase font-mono">PSI Drift Resilience</span>
                            <span class="material-symbols-outlined text-outline text-lg">waves</span>
                        </div>
                        <div class="my-2">
                            <div class="font-headline-lg text-headline-lg text-on-surface font-mono font-semibold">0.042 PSI</div>
                            <div class="font-body-sm text-body-sm text-cyan-300 font-medium mt-0.5">High stability against feature perturbation</div>
                        </div>
                        <div class="w-full bg-surface-container-lowest h-2 rounded-full overflow-hidden">
                            <div class="bg-cyan-400 h-full rounded-full" style="width: 21%;"></div>
                        </div>
                        <div class="flex justify-between text-label-sm font-label-sm text-outline font-mono mt-2">
                            <span>0.00 (Pure)</span>
                            <span>PSI: 0.042</span>
                            <span>0.25 (Drift Alert)</span>
                        </div>
                    </div>
                    <!-- Tile 3: High-Visibility Inverted Bento Card (Decision Callout) -->
                    <div class="rounded-xl bg-secondary-fixed p-space-md text-on-primary-fixed flex flex-col justify-between shadow-lg">
                        <div class="flex items-center justify-between">
                            <span class="text-label-sm font-label-sm uppercase font-mono font-bold tracking-wider text-on-secondary-fixed">Mission Recommendation</span>
                            <span class="px-2 py-0.5 rounded-full bg-on-secondary-fixed text-secondary-fixed font-code-sm text-code-sm font-bold">APPROVED</span>
                        </div>
                        <div class="my-2">
                            <div class="font-headline-md text-headline-md font-semibold text-on-secondary-fixed">Promote #02 over #03</div>
                            <p class="font-body-sm text-body-sm text-on-secondary-fixed-variant mt-1">
                                While Run #03 (XGBoost) exhibits a marginally higher F1 score (+0.033), its 28s cold start and non-deterministic tree splits breach embedded container specifications. Run #02 is chosen.
                            </p>
                        </div>
                        <div class="pt-2 flex items-center justify-between font-code-sm text-code-sm font-mono text-on-secondary-fixed">
                            <span>STABILITY: OPTIMAL</span>
                            <span class="font-bold underline cursor-pointer hover:opacity-80">Telemetry Proof →</span>
                        </div>
                    </div>
                </div>
                <!-- BOTTOM ACTIONS BAR (MISSION CONTROL COMMAND DECK) -->
                <div class="sticky bottom-4 z-30 rounded-xl bg-surface-container-lowest/95 backdrop-blur-md p-space-md shadow-2xl flex flex-col sm:flex-row items-center justify-between gap-space-md">
                    <div class="flex items-center gap-space-md w-full sm:w-auto">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-tertiary shadow-[0_0_8px_rgba(255,185,86,0.8)]"></span>
                            <span class="font-code-sm text-code-sm text-on-surface font-mono font-semibold">TARGET RUN:</span>
                            <span class="font-code-sm text-code-sm text-tertiary font-mono bg-tertiary-container px-2 py-0.5 rounded">#02 (Random Forest Tuned)</span>
                        </div>
                        <span class="hidden md:inline text-outline text-label-sm font-mono">Hash: 8f4e19...c39a</span>
                    </div>
                    <div class="flex items-center gap-space-sm w-full sm:w-auto justify-end flex-wrap">
                        <!-- Export Button -->
                        <button class="h-10 px-4 rounded-lg bg-surface-container-high hover:bg-surface-container-highest text-on-surface text-label-sm font-label-sm uppercase tracking-wider font-semibold flex items-center gap-2 transition-colors">
                            <span class="material-symbols-outlined text-base">download</span>
                            Export Comparison CSV / Report
                        </button>
                        <!-- Batch Retrain Button -->
                        <button class="h-10 px-4 rounded-lg bg-surface-container-high hover:bg-surface-container-highest text-on-surface text-label-sm font-label-sm uppercase tracking-wider font-semibold flex items-center gap-2 transition-colors">
                            <span class="material-symbols-outlined text-base">refresh</span>
                            Batch Retrain on Fresh Fold
                        </button>
                        <!-- Promote Primary Deployment Action -->
                        <button class="h-10 px-5 rounded-lg bg-tertiary hover:bg-tertiary-fixed text-on-tertiary-fixed font-label-sm text-label-sm uppercase tracking-wider font-bold shadow-[0_0_15px_rgba(255,185,86,0.4)] flex items-center gap-2 transition-all transform active:scale-95">
                            <span class="material-symbols-outlined text-base" style="font-variation-settings: 'FILL' 1;">cloud_upload</span>
                            Promote #02 to Registry (SYS-AI-04)
                        </button>
                    </div>
                </div>
            </div>
            <script>
                function highlightRun(runId) {
                    document.querySelectorAll('.run-card').forEach(el => {
                        el.classList.remove('ring-4', 'ring-tertiary');
                    });
                    const target = document.getElementById('card-' + runId);
                    if (target) {
                        target.classList.add('ring-4', 'ring-tertiary');
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                    }
                }

                // Interactive toggle for Curve View
                const btnRoc = document.getElementById('btn-toggle-roc');
                const btnPr = document.getElementById('btn-toggle-pr');

                if (btnRoc && btnPr) {
                    btnRoc.addEventListener('click', () => {
                        btnRoc.className = "px-2.5 py-1 rounded bg-secondary-container text-secondary-fixed text-label-sm font-label-sm font-mono font-medium shadow-sm";
                        btnPr.className = "px-2.5 py-1 rounded text-outline hover:text-on-surface text-label-sm font-label-sm font-mono transition-colors";
                    });

                    btnPr.addEventListener('click', () => {
                        btnPr.className = "px-2.5 py-1 rounded bg-secondary-container text-secondary-fixed text-label-sm font-label-sm font-mono font-medium shadow-sm";
                        btnRoc.className = "px-2.5 py-1 rounded text-outline hover:text-on-surface text-label-sm font-label-sm font-mono transition-colors";
                    });
                }
            </script>
        </main>
    </div>
</body>

</html>