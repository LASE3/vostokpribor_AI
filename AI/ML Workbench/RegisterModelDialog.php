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
                    </a><a class="group flex items-center justify-between px-space-md py-2.5 rounded-lg text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-all" data-path="workbench" href="#">
                        <div class="flex items-center gap-space-sm"><span class="material-symbols-outlined text-tertiary text-lg">precision_manufacturing</span><span class="font-code-md text-code-md tracking-tight text-tertiary">SYS-AI-03</span><span class="font-body-sm text-body-sm text-on-surface font-medium">Workbench</span></div><span class="w-2 h-2 rounded bg-tertiary shadow-[0_0_8px_rgba(255,185,86,0.8)]"></span>
                    </a><a class="group flex items-center justify-between px-space-md py-2.5 rounded-lg text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-all" data-path="registry-deployment" href="#">
                        <div class="flex items-center gap-space-sm"><span class="material-symbols-outlined text-outline group-hover:text-primary transition-colors text-lg">rocket_launch</span><span class="font-code-md text-code-md tracking-tight">SYS-AI-04</span><span class="font-body-sm text-body-sm text-on-surface-variant group-hover:text-on-surface">Registry &amp; Deploy</span></div><span class="w-1.5 h-1.5 rounded-full bg-outline-variant/60"></span>
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
                <div class="flex items-center shrink-0 px-2 py-1 rounded bg-secondary-container/80 text-secondary-fixed font-mono border border-secondary/40 shadow-sm">9. Eval &amp; Validate</div><span class="text-outline-variant">›</span>
                <div class="flex items-center shrink-0 px-2 py-1 text-outline font-mono">10. Explainability</div><span class="text-outline-variant">›</span>
                <div class="flex items-center shrink-0 px-2 py-1 text-outline font-mono">11. Registry</div><span class="text-outline-variant">›</span>
                <div class="flex items-center shrink-0 px-2 py-1 text-outline font-mono">12. Canary</div><span class="text-outline-variant">›</span>
                <div class="flex items-center shrink-0 px-2 py-1 text-outline font-mono">13. Production</div><span class="text-outline-variant">›</span>
                <div class="flex items-center shrink-0 px-2 py-1 text-outline font-mono">14. Drift</div>
            </div>
        </header>
        <main class="w-full pt-28 bg-surface flex-1 min-h-[calc(100vh-7rem)] p-space-md">
            <div class="flex flex-col w-full relative">
                <!-- Underlying Workbench Interface: SYS-AI-03 Runs Telemetry (Dimmed context layer) -->
                <div class="w-full filter blur-[2px] opacity-25 pointer-events-none select-none space-y-space-md">
                    <!-- Workbench Top Control Bar -->
                    <div class="flex items-center justify-between p-space-md rounded-xl bg-surface-container-high shadow-md">
                        <div class="flex items-center gap-space-md">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-tertiary">science</span>
                                <span class="font-headline-md text-headline-md text-on-surface">SYS-AI-03 // Model Workbench &amp; Architecture Sweep</span>
                            </div>
                            <span class="px-2 py-0.5 rounded bg-surface-container font-code-sm text-code-sm text-outline">EXPERIMENT-ID: EXP-RF-OPTIM-024</span>
                        </div>
                        <div class="flex items-center gap-space-sm">
                            <div class="px-3 py-1.5 rounded-lg bg-surface-container text-label-sm font-label-sm text-secondary">ACTIVE COMPONENT: 5 RUNS</div>
                        </div>
                    </div>
                    <!-- Telemetry Bento Grid Background -->
                    <div class="grid grid-cols-12 gap-space-md">
                        <div class="col-span-8 p-space-lg rounded-xl bg-surface-container-low shadow-sm flex flex-col gap-space-md">
                            <div class="flex justify-between items-center">
                                <span class="font-headline-md text-title-sm text-on-surface">Hyperparameter Exploration &amp; F1 Convergence</span>
                                <span class="font-code-sm text-code-sm text-tertiary">300 EPOCHS</span>
                            </div>
                            <div class="h-48 w-full bg-surface-container rounded flex items-center justify-center text-outline font-code-md">
                                [Loss Surface &amp; Metric Telemetry Surface Graph]
                            </div>
                        </div>
                        <div class="col-span-4 p-space-lg rounded-xl bg-surface-container-low shadow-sm flex flex-col justify-between">
                            <div>
                                <span class="font-headline-md text-title-sm text-on-surface">Run Matrix</span>
                                <div class="mt-space-sm space-y-2 font-code-sm text-code-sm text-on-surface-variant">
                                    <div class="p-2 rounded bg-surface-container flex justify-between"><span>#01 SGD Baseline</span><span>0.7100</span></div>
                                    <div class="p-2 rounded bg-surface-container-high text-tertiary flex justify-between"><span>#02 Random Forest Tuned</span><span>0.8014</span></div>
                                    <div class="p-2 rounded bg-surface-container flex justify-between"><span>#03 LightGBM Fast</span><span>0.7892</span></div>
                                    <div class="p-2 rounded bg-surface-container flex justify-between"><span>#04 XGBoost Depth-9</span><span>0.7960</span></div>
                                </div>
                            </div>
                            <div class="p-2 rounded bg-surface-container text-label-sm font-label-sm text-outline">HARDWARE: CLUSTER-NODE-B</div>
                        </div>
                    </div>
                </div>
                <!-- Modal Backdrop Layer -->
                <div class="fixed inset-0 left-72 top-28 bg-surface-container-lowest/85 backdrop-blur-sm z-50 flex items-center justify-center p-space-md overflow-y-auto">
                    <!-- Modal Window Container -->
                    <div class="w-full max-w-5xl rounded-xl bg-surface-container-low shadow-2xl flex flex-col overflow-hidden my-auto animate-in fade-in zoom-in-95 duration-200">
                        <!-- Modal Header -->
                        <div class="px-space-lg py-4 bg-surface-container-high flex flex-col gap-2 relative">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-space-sm">
                                    <div class="p-1.5 rounded-lg bg-surface-container-lowest text-tertiary flex items-center justify-center">
                                        <span class="material-symbols-outlined text-lg">deployed_code</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="font-code-sm text-code-sm uppercase tracking-wider text-tertiary font-medium">SYS-AI-03</span>
                                        <span class="text-outline text-xs">➔</span>
                                        <span class="font-code-sm text-code-sm uppercase tracking-wider text-secondary font-medium">SYS-AI-04 REGISTRATION DISPATCH</span>
                                    </div>
                                </div>
                                <!-- Header Context Badges & Close -->
                                <div class="flex items-center gap-space-sm">
                                    <div class="flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-surface-container text-tertiary font-code-sm text-code-sm">
                                        <span class="w-1.5 h-1.5 rounded-full bg-tertiary animate-pulse"></span>
                                        <span>RUN-2024-02-RF</span>
                                        <span class="text-outline">·</span>
                                        <span class="text-on-surface">F1: 0.8014</span>
                                        <span class="text-outline">·</span>
                                        <span class="text-secondary-fixed">SLA PASS</span>
                                    </div>
                                    <button class="w-7 h-7 rounded-lg bg-surface-container hover:bg-surface-bright text-outline hover:text-on-surface flex items-center justify-center transition-colors">
                                        <span class="material-symbols-outlined text-base">close</span>
                                    </button>
                                </div>
                            </div>
                            <div class="flex items-baseline justify-between mt-1">
                                <div>
                                    <h1 class="font-headline-lg text-headline-lg text-on-surface tracking-tight">Register Candidate Model to Production Registry</h1>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant">Commit validated telemetry artifact, cryptographically lock weights, and dispatch to Canary/Staging lifecycle.</p>
                                </div>
                                <div class="flex items-center gap-2 text-label-sm font-label-sm text-outline uppercase font-mono">
                                    <span>Ticket:</span>
                                    <span class="text-on-surface font-semibold">#AI-024 Customer Churn</span>
                                </div>
                            </div>
                        </div>
                        <!-- Modal Body (2-Column Bento Grid) -->
                        <div class="p-space-lg grid grid-cols-12 gap-space-lg bg-surface-container-low max-h-[768px] overflow-y-auto">
                            <!-- Left / Form Specification Column (7 Cols) -->
                            <div class="col-span-7 flex flex-col gap-space-md">
                                <!-- Identity & Namespace -->
                                <div class="p-space-md rounded-xl bg-surface-container flex flex-col gap-space-sm">
                                    <div class="flex items-center justify-between">
                                        <label class="font-label-sm text-label-sm uppercase tracking-wider text-outline">Model Identity &amp; Namespace</label>
                                        <span class="font-code-sm text-code-sm text-secondary">REGISTRY KEY APPROVED</span>
                                    </div>
                                    <div class="flex items-center rounded-lg bg-surface-container-lowest px-3 py-2">
                                        <span class="font-code-md text-code-md text-outline select-none">sys-ai/churn/</span>
                                        <input class="w-full bg-transparent font-code-md text-code-md text-on-surface focus:outline-none placeholder:text-outline/50 ml-0.5" type="text" value="vostok-telecom-churn-rf" />
                                        <span class="material-symbols-outlined text-sm text-secondary-fixed">verified</span>
                                    </div>
                                </div>
                                <!-- Version Assignment Radios -->
                                <div class="p-space-md rounded-xl bg-surface-container flex flex-col gap-space-sm">
                                    <div class="flex items-center justify-between">
                                        <label class="font-label-sm text-label-sm uppercase tracking-wider text-outline">Semantic Version Increment</label>
                                        <span class="font-code-sm text-code-sm text-tertiary">Current: v1.1.0</span>
                                    </div>
                                    <div class="grid grid-cols-3 gap-2">
                                        <!-- Patch -->
                                        <label class="flex flex-col p-2.5 rounded-lg bg-surface-container-low hover:bg-surface-container-high cursor-pointer transition-colors">
                                            <div class="flex items-center justify-between mb-1">
                                                <span class="font-label-sm text-label-sm text-outline uppercase">Patch</span>
                                                <input class="accent-tertiary" name="version-tier" type="radio" />
                                            </div>
                                            <span class="font-code-md text-code-md text-on-surface">v1.1.1</span>
                                            <span class="font-body-sm text-body-sm text-outline mt-0.5">Bugfix / weights tune</span>
                                        </label>
                                        <!-- Minor (Selected) -->
                                        <label class="flex flex-col p-2.5 rounded-lg bg-surface-container-high shadow-inner cursor-pointer transition-colors">
                                            <div class="flex items-center justify-between mb-1">
                                                <span class="font-label-sm text-label-sm text-tertiary font-semibold uppercase">Candidate</span>
                                                <input checked="" class="accent-tertiary" name="version-tier" type="radio" />
                                            </div>
                                            <span class="font-code-md text-code-md text-tertiary font-semibold">v1.2.0-rc1</span>
                                            <span class="font-body-sm text-body-sm text-secondary-fixed mt-0.5">Arch change + F1 bump</span>
                                        </label>
                                        <!-- Major -->
                                        <label class="flex flex-col p-2.5 rounded-lg bg-surface-container-low hover:bg-surface-container-high cursor-pointer transition-colors">
                                            <div class="flex items-center justify-between mb-1">
                                                <span class="font-label-sm text-label-sm text-outline uppercase">Major</span>
                                                <input class="accent-tertiary" name="version-tier" type="radio" />
                                            </div>
                                            <span class="font-code-md text-code-md text-on-surface">v2.0.0</span>
                                            <span class="font-body-sm text-body-sm text-outline mt-0.5">Breaking schema rev</span>
                                        </label>
                                    </div>
                                </div>
                                <!-- Description Textarea -->
                                <div class="p-space-md rounded-xl bg-surface-container flex flex-col gap-space-sm">
                                    <div class="flex items-center justify-between">
                                        <label class="font-label-sm text-label-sm uppercase tracking-wider text-outline">Release Description &amp; Provenance Notes</label>
                                        <span class="font-code-sm text-code-sm text-outline">MARKDOWN</span>
                                    </div>
                                    <textarea class="w-full h-20 p-2.5 rounded-lg bg-surface-container-lowest font-body-sm text-body-sm text-on-surface focus:outline-none resize-none leading-relaxed" rows="3">Optimized Random Forest Classifier (n_estimators=300, max_depth=14) trained on telecom_churn_q3_v2 with RobustScaler + KBest feature selection. Replaces SGD baseline to achieve 80.14% F1 and 18.4ms p99 inference latency.</textarea>
                                </div>
                                <!-- Target Deployment Stage -->
                                <div class="p-space-md rounded-xl bg-surface-container flex flex-col gap-space-sm">
                                    <label class="font-label-sm text-label-sm uppercase tracking-wider text-outline">Target Deployment Lifecycle Stage</label>
                                    <div class="grid grid-cols-2 gap-2">
                                        <button class="p-2.5 rounded-lg bg-surface-container-high text-left flex items-start gap-2.5 shadow-sm">
                                            <span class="material-symbols-outlined text-tertiary text-lg mt-0.5">shadow</span>
                                            <div class="flex flex-col">
                                                <div class="flex items-center gap-1.5">
                                                    <span class="font-title-sm text-title-sm text-on-surface">Staging / Shadow</span>
                                                    <span class="px-1.5 py-0.2 rounded bg-tertiary-container text-tertiary font-code-sm text-code-sm">RECOMMENDED</span>
                                                </div>
                                                <span class="font-body-sm text-body-sm text-outline">Mirror 100% telemetry without production impact</span>
                                            </div>
                                        </button>
                                        <button class="p-2.5 rounded-lg bg-surface-container-low hover:bg-surface-container-high text-left flex items-start gap-2.5 transition-colors">
                                            <span class="material-symbols-outlined text-outline text-lg mt-0.5">flaky</span>
                                            <div class="flex flex-col">
                                                <span class="font-title-sm text-title-sm text-on-surface">Canary (10%)</span>
                                                <span class="font-body-sm text-body-sm text-outline">10% live traffic split with auto-rollback guard</span>
                                            </div>
                                        </button>
                                    </div>
                                </div>
                                <!-- Metadata Tags -->
                                <div class="p-space-md rounded-xl bg-surface-container flex flex-col gap-space-sm">
                                    <label class="font-label-sm text-label-sm uppercase tracking-wider text-outline">Metadata Tags</label>
                                    <div class="flex flex-wrap items-center gap-1.5" id="tag-container">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md bg-surface-container-high font-code-sm text-code-sm text-on-surface">ticket:AI-024<button class="hover:text-error ml-1">×</button></span>
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md bg-surface-container-high font-code-sm text-code-sm text-on-surface">arch:random_forest<button class="hover:text-error ml-1">×</button></span>
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md bg-surface-container-high font-code-sm text-code-sm text-on-surface">churn-v2<button class="hover:text-error ml-1">×</button></span>
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md bg-surface-container-high font-code-sm text-code-sm text-tertiary">sla:sub-25ms<button class="hover:text-error ml-1">×</button></span>
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md bg-surface-container-high font-code-sm text-code-sm text-secondary">airgap:verified<button class="hover:text-error ml-1">×</button></span>
                                        <button class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md bg-surface-container-low hover:bg-surface-container-high font-code-sm text-code-sm text-outline hover:text-on-surface transition-colors">+ Add Tag</button>
                                    </div>
                                </div>
                                <!-- Hardware & Runtime Environment Spec -->
                                <div class="p-space-md rounded-xl bg-surface-container-lowest flex items-center justify-between">
                                    <div class="flex items-center gap-space-sm">
                                        <span class="material-symbols-outlined text-outline">memory</span>
                                        <div class="flex flex-col">
                                            <span class="font-code-sm text-code-sm text-on-surface">vostok-runtime-cu12:2024.3-minimal</span>
                                            <span class="font-body-sm text-body-sm text-outline">SXM5-H100 / Dual AMD EPYC (Triton / ONNX Engine)</span>
                                        </div>
                                    </div>
                                    <span class="font-code-sm text-code-sm text-secondary font-mono">18.4ms SLA</span>
                                </div>
                            </div>
                            <!-- Right / SLA Proof & Audit Gate Column (5 Cols) -->
                            <div class="col-span-5 flex flex-col gap-space-md">
                                <!-- Primary Business Gate Verification Panel -->
                                <div class="p-space-md rounded-xl bg-surface-container-high shadow-md flex flex-col gap-3">
                                    <div class="flex items-center justify-between">
                                        <span class="font-label-sm text-label-sm uppercase tracking-wider text-outline">Business Gate Compliance</span>
                                        <span class="px-2 py-0.5 rounded-full bg-secondary-container text-secondary-fixed font-code-sm text-code-sm font-semibold flex items-center gap-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-secondary-fixed"></span> VERIFIED
                                        </span>
                                    </div>
                                    <div class="p-3 rounded-lg bg-surface-container flex flex-col gap-2">
                                        <div class="flex items-center justify-between">
                                            <span class="font-body-sm text-body-sm text-on-surface">F1 Score Target</span>
                                            <span class="font-code-sm text-code-sm text-secondary font-semibold">PASS (≥ 0.8000)</span>
                                        </div>
                                        <div class="flex items-baseline justify-between">
                                            <span class="font-display-lg text-headline-xl text-tertiary">0.8014</span>
                                            <span class="font-code-sm text-code-sm text-secondary">+0.0914 vs Baseline</span>
                                        </div>
                                        <!-- Progress Meter -->
                                        <div class="w-full bg-surface-container-lowest h-2 rounded-full overflow-hidden flex">
                                            <div class="bg-secondary h-full" style="width: 80.14%;"></div>
                                        </div>
                                        <div class="flex justify-between font-code-sm text-code-sm text-outline">
                                            <span>Threshold: 0.8000</span>
                                            <span>Margin: +0.14%</span>
                                        </div>
                                    </div>
                                    <!-- Operational SLA Checks -->
                                    <div class="grid grid-cols-2 gap-2 font-code-sm text-code-sm">
                                        <div class="p-2 rounded bg-surface-container flex flex-col gap-0.5">
                                            <span class="text-outline uppercase text-[10px]">p99 Latency</span>
                                            <span class="text-on-surface font-semibold">18.4ms</span>
                                            <span class="text-secondary text-[10px]">PASS (Max 25ms)</span>
                                        </div>
                                        <div class="p-2 rounded bg-surface-container flex flex-col gap-0.5">
                                            <span class="text-outline uppercase text-[10px]">Drift Stability (PSI)</span>
                                            <span class="text-on-surface font-semibold">0.042</span>
                                            <span class="text-secondary text-[10px]">PASS (&lt; 0.10)</span>
                                        </div>
                                    </div>
                                    <!-- Cryptographic Digest -->
                                    <div class="p-2 rounded bg-surface-container-lowest flex items-center justify-between">
                                        <div class="flex items-center gap-1.5">
                                            <span class="material-symbols-outlined text-sm text-outline">lock</span>
                                            <span class="font-code-sm text-code-sm text-outline">SHA-256</span>
                                        </div>
                                        <span class="font-code-sm text-code-sm text-secondary font-mono">8f4e19b8...c39a441e</span>
                                    </div>
                                </div>
                                <!-- Metrics Snapshot Table -->
                                <div class="p-space-md rounded-xl bg-surface-container flex flex-col gap-2">
                                    <span class="font-label-sm text-label-sm uppercase tracking-wider text-outline">Performance Vector Comparison</span>
                                    <div class="w-full overflow-hidden rounded-lg bg-surface-container-lowest">
                                        <table class="w-full text-left font-code-sm text-code-sm">
                                            <thead class="bg-surface-container-high text-outline text-[10px] uppercase font-mono">
                                                <tr>
                                                    <th class="py-1.5 px-3">Metric</th>
                                                    <th class="py-1.5 px-2 text-right">Value</th>
                                                    <th class="py-1.5 px-2 text-right">Delta</th>
                                                    <th class="py-1.5 px-3 text-right">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-outline-variant/10 text-on-surface">
                                                <tr class="bg-surface-container-lowest">
                                                    <td class="py-1.5 px-3 font-medium">F1-Score</td>
                                                    <td class="py-1.5 px-2 text-right text-tertiary">0.8014</td>
                                                    <td class="py-1.5 px-2 text-right text-secondary">+0.0914</td>
                                                    <td class="py-1.5 px-3 text-right text-secondary">PASS</td>
                                                </tr>
                                                <tr class="bg-surface-container/30">
                                                    <td class="py-1.5 px-3 font-medium">Accuracy</td>
                                                    <td class="py-1.5 px-2 text-right">84.2%</td>
                                                    <td class="py-1.5 px-2 text-right text-secondary">+6.2%</td>
                                                    <td class="py-1.5 px-3 text-right text-secondary">PASS</td>
                                                </tr>
                                                <tr class="bg-surface-container-lowest">
                                                    <td class="py-1.5 px-3 font-medium">Precision</td>
                                                    <td class="py-1.5 px-2 text-right">81.0%</td>
                                                    <td class="py-1.5 px-2 text-right text-secondary">+6.8%</td>
                                                    <td class="py-1.5 px-3 text-right text-secondary">PASS</td>
                                                </tr>
                                                <tr class="bg-surface-container/30">
                                                    <td class="py-1.5 px-3 font-medium">Recall</td>
                                                    <td class="py-1.5 px-2 text-right">78.9%</td>
                                                    <td class="py-1.5 px-2 text-right text-secondary">+9.8%</td>
                                                    <td class="py-1.5 px-3 text-right text-secondary">PASS</td>
                                                </tr>
                                                <tr class="bg-surface-container-lowest">
                                                    <td class="py-1.5 px-3 font-medium">Latency (p99)</td>
                                                    <td class="py-1.5 px-2 text-right text-tertiary">18.4ms</td>
                                                    <td class="py-1.5 px-2 text-right text-secondary">-6.4ms</td>
                                                    <td class="py-1.5 px-3 text-right text-secondary">PASS</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- Governance Checklist -->
                                <div class="p-space-md rounded-xl bg-surface-container flex flex-col gap-2">
                                    <span class="font-label-sm text-label-sm uppercase tracking-wider text-outline">Governance &amp; Lineage Checklist</span>
                                    <div class="space-y-1.5 font-body-sm text-body-sm text-on-surface">
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input checked="" class="accent-tertiary rounded" type="checkbox" />
                                            <span class="font-code-sm text-code-sm">telecom_churn_q3_v2.parquet signed</span>
                                        </label>
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input checked="" class="accent-tertiary rounded" type="checkbox" />
                                            <span class="font-code-sm text-code-sm">Reproducibility seed locked (Seed: 42)</span>
                                        </label>
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input checked="" class="accent-tertiary rounded" type="checkbox" />
                                            <span class="font-code-sm text-code-sm">Air-gap security token: <strong class="text-tertiary">VP-AUD-992-RF</strong></span>
                                        </label>
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input checked="" class="accent-tertiary rounded" type="checkbox" />
                                            <span class="font-code-sm text-code-sm">Lead AI Eng pre-authorization granted</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal Footer / Operational Dispatch Action Rail -->
                        <div class="px-space-lg py-4 bg-surface-container-high flex items-center justify-between gap-space-md">
                            <!-- Status Note -->
                            <div class="flex items-center gap-2 text-on-surface-variant max-w-lg">
                                <span class="material-symbols-outlined text-tertiary text-base shrink-0">info</span>
                                <span class="font-body-sm text-body-sm leading-tight text-outline">
                                    Commits immutable weights to <span class="text-on-surface font-code-sm">SYS-AI-04 Model Registry</span> and triggers automatic shadow evaluation webhook.
                                </span>
                            </div>
                            <!-- Buttons -->
                            <div class="flex items-center gap-space-sm shrink-0">
                                <button class="px-4 py-2 rounded-lg bg-surface-container hover:bg-surface-bright font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant hover:text-on-surface transition-colors">
                                    Cancel
                                </button>
                                <button class="px-4 py-2 rounded-lg bg-surface-container-high hover:bg-surface-bright font-label-sm text-label-sm uppercase tracking-wider text-secondary font-medium transition-colors">
                                    Save Staging Draft
                                </button>
                                <button class="px-5 py-2.5 rounded-lg bg-tertiary hover:bg-tertiary-fixed text-on-tertiary font-label-sm text-label-sm uppercase tracking-wider font-semibold shadow-lg shadow-tertiary/20 flex items-center gap-2 transition-all active:scale-95" id="dispatchBtn">
                                    <span>Send to SYS-AI-04 Registry &amp; Deploy</span>
                                    <span class="material-symbols-outlined text-base">arrow_forward</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    const dispatchBtn = document.getElementById('dispatchBtn');
                    if (dispatchBtn) {
                        dispatchBtn.addEventListener('click', () => {
                            dispatchBtn.innerHTML = `
          <span class="inline-block w-4 h-4 rounded-full border-2 border-on-tertiary border-t-transparent animate-spin mr-1"></span>
          <span>Registering v1.2.0-rc1...</span>
        `;
                            setTimeout(() => {
                                dispatchBtn.classList.remove('bg-tertiary', 'hover:bg-tertiary-fixed');
                                dispatchBtn.classList.add('bg-secondary-container', 'text-secondary-fixed');
                                dispatchBtn.innerHTML = `
            <span class="material-symbols-outlined text-base">check_circle</span>
            <span>Registered to SYS-AI-04</span>
          `;
                            }, 1200);
                        });
                    }
                </script>
            </div>
        </main>
    </div>
</body>

</html>