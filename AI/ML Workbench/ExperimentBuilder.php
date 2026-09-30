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
                <!-- Top Wizard & Subsystem Context Panel -->
                <div class="relative bg-surface-container rounded-xl p-space-md shadow-md overflow-hidden">
                    <div class="absolute -right-16 -top-16 w-64 h-64 rounded-full bg-gradient-to-br from-tertiary/10 via-transparent to-transparent pointer-events-none blur-2xl"></div>
                    <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-space-md">
                        <div class="flex items-center gap-space-md">
                            <div class="w-12 h-12 rounded-lg bg-surface-container-high flex items-center justify-center text-tertiary shadow-inner">
                                <span class="material-symbols-outlined text-2xl">science</span>
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="font-code-sm text-code-sm uppercase tracking-widest text-tertiary">SYS-AI-03 // CONFIG-SPEC</span>
                                    <span class="px-2 py-0.5 rounded-full bg-tertiary-container text-tertiary font-code-sm text-code-sm uppercase">EXP-CHURN-2024-Q3</span>
                                </div>
                                <h1 class="font-headline-lg text-headline-lg text-on-surface">Avionics Pipeline & Experiment Architect</h1>
                            </div>
                        </div>
                        <!-- Step Wizard Bar -->
                        <div class="flex items-center bg-surface-container-lowest p-1 rounded-xl shadow-inner overflow-x-auto">
                            <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-surface-container-high text-on-surface shadow-sm cursor-pointer transition-all">
                                <span class="w-4 h-4 rounded-full bg-tertiary text-on-tertiary font-code-sm text-code-sm flex items-center justify-center font-bold">1</span>
                                <span class="font-label-sm text-label-sm tracking-wide uppercase">Dataset</span>
                            </div>
                            <span class="material-symbols-outlined text-outline text-sm">chevron_right</span>
                            <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-surface-container-high text-on-surface shadow-sm cursor-pointer transition-all">
                                <span class="w-4 h-4 rounded-full bg-tertiary text-on-tertiary font-code-sm text-code-sm flex items-center justify-center font-bold">2</span>
                                <span class="font-label-sm text-label-sm tracking-wide uppercase">Features</span>
                            </div>
                            <span class="material-symbols-outlined text-outline text-sm">chevron_right</span>
                            <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-tertiary-container text-tertiary shadow-sm cursor-pointer">
                                <span class="w-4 h-4 rounded-full bg-tertiary text-on-tertiary font-code-sm text-code-sm flex items-center justify-center font-bold">3</span>
                                <span class="font-label-sm text-label-sm tracking-wide uppercase font-semibold">Algorithm</span>
                            </div>
                            <span class="material-symbols-outlined text-outline text-sm">chevron_right</span>
                            <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-outline-variant hover:text-on-surface cursor-pointer transition-colors">
                                <span class="w-4 h-4 rounded-full bg-surface-container-high text-outline font-code-sm text-code-sm flex items-center justify-center">4</span>
                                <span class="font-label-sm text-label-sm tracking-wide uppercase">H-Params</span>
                            </div>
                            <span class="material-symbols-outlined text-outline text-sm">chevron_right</span>
                            <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-outline-variant hover:text-on-surface cursor-pointer transition-colors">
                                <span class="w-4 h-4 rounded-full bg-surface-container-high text-outline font-code-sm text-code-sm flex items-center justify-center">5</span>
                                <span class="font-label-sm text-label-sm tracking-wide uppercase">Execute</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Primary Split Grid -->
                <div class="grid grid-cols-1 xl:grid-cols-12 gap-space-lg items-start">
                    <!-- LEFT MAIN COLUMN: Interactive Visual Builder (8 Cols) -->
                    <div class="xl:col-span-8 flex flex-col gap-space-lg">
                        <!-- DATASET & STRATIFIED SPLIT CARD -->
                        <section class="bg-surface-container-low rounded-xl p-space-lg shadow-sm flex flex-col gap-space-md">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-space-sm">
                                    <span class="material-symbols-outlined text-tertiary">table_chart</span>
                                    <h2 class="font-headline-md text-headline-md text-on-surface">Data Ingestion & Split Protocol</h2>
                                </div>
                                <span class="px-2.5 py-1 rounded bg-surface-container-high text-secondary font-code-sm text-code-sm">STATE: MOUNTED READ-ONLY</span>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-space-md bg-surface-container-lowest p-space-md rounded-lg">
                                <div class="flex flex-col gap-1">
                                    <span class="font-label-sm text-label-sm uppercase tracking-wider text-outline">Dataset Artifact</span>
                                    <div class="flex items-center gap-2">
                                        <span class="font-code-md text-code-md text-on-surface font-semibold truncate">telecom_churn_q3_v2.parquet</span>
                                        <span class="material-symbols-outlined text-tertiary text-sm">verified</span>
                                    </div>
                                    <span class="font-code-sm text-code-sm text-on-surface-variant">SHA256: 7f4a...92b0</span>
                                </div>
                                <div class="flex flex-col gap-1">
                                    <span class="font-label-sm text-label-sm uppercase tracking-wider text-outline">Record Topology</span>
                                    <div class="font-headline-md text-headline-md text-on-surface">480,000 <span class="font-label-sm text-label-sm text-outline">ROWS</span></div>
                                    <span class="font-code-sm text-code-sm text-secondary-fixed">42 Raw Signals • 1 Target</span>
                                </div>
                                <div class="flex flex-col gap-1">
                                    <span class="font-label-sm text-label-sm uppercase tracking-wider text-outline">Sampling Strategy</span>
                                    <div class="flex items-center gap-1.5 text-on-surface font-code-md text-code-md">
                                        <span class="material-symbols-outlined text-tertiary text-sm">tune</span>
                                        Stratified (churn_status)
                                    </div>
                                    <span class="font-code-sm text-code-sm text-outline">SEED: 42 (Deterministic)</span>
                                </div>
                            </div>
                            <!-- Train / Test Split interactive Visualizer -->
                            <div class="flex flex-col gap-2 pt-2">
                                <div class="flex items-center justify-between font-label-sm text-label-sm">
                                    <span class="text-secondary-fixed flex items-center gap-1.5">
                                        <span class="w-2.5 h-2.5 rounded-full bg-secondary"></span>
                                        Train Set: 80% (384,000 samples)
                                    </span>
                                    <span class="text-tertiary flex items-center gap-1.5">
                                        <span class="w-2.5 h-2.5 rounded-full bg-tertiary"></span>
                                        Holdout Test Set: 20% (96,000 samples)
                                    </span>
                                </div>
                                <div class="relative w-full h-3 bg-surface-container-high rounded-full overflow-hidden flex shadow-inner">
                                    <div class="h-full bg-secondary transition-all duration-300" style="width: 80%;"></div>
                                    <div class="h-full bg-tertiary transition-all duration-300" style="width: 20%;"></div>
                                </div>
                                <div class="flex justify-between items-center text-outline font-code-sm text-code-sm">
                                    <span>0%</span>
                                    <span class="text-on-surface font-mono">Split Ratio: 0.80 / 0.20</span>
                                    <span>100%</span>
                                </div>
                            </div>
                        </section>
                        <!-- FEATURE ENGINEERING & PREPROCESSING PIPELINE STACK -->
                        <section class="bg-surface-container-low rounded-xl p-space-lg shadow-sm flex flex-col gap-space-md">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-space-sm">
                                    <span class="material-symbols-outlined text-tertiary">account_tree</span>
                                    <div>
                                        <h2 class="font-headline-md text-headline-md text-on-surface">Preprocessing & Transformation Layers</h2>
                                        <span class="font-code-sm text-code-sm text-outline">Sklearn & Native CuML Graph Assembly</span>
                                    </div>
                                </div>
                                <button class="flex items-center gap-1 px-3 py-1.5 rounded-lg bg-surface-container-high text-primary hover:bg-surface-container-highest transition-colors font-label-sm text-label-sm uppercase">
                                    <span class="material-symbols-outlined text-sm">add_circle</span>
                                    Add Transformer
                                </button>
                            </div>
                            <div class="flex flex-col gap-2.5">
                                <!-- Item 1 -->
                                <div class="flex items-center justify-between p-space-md rounded-lg bg-surface-container-lowest hover:bg-surface-container transition-colors shadow-sm">
                                    <div class="flex items-center gap-space-md">
                                        <span class="material-symbols-outlined text-outline cursor-grab">drag_indicator</span>
                                        <div class="w-6 h-6 rounded bg-surface-container-high text-tertiary font-code-sm text-code-sm flex items-center justify-center font-bold">01</div>
                                        <div>
                                            <div class="font-title-sm text-title-sm text-on-surface">Missing Value Imputation</div>
                                            <div class="font-code-sm text-code-sm text-on-surface-variant">Median for continuous [numeric] · Mode for discrete [categorical]</div>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-space-sm">
                                        <span class="px-2 py-0.5 rounded bg-surface-container text-outline font-code-sm text-code-sm">SimpleImputer</span>
                                        <span class="material-symbols-outlined text-outline hover:text-tertiary cursor-pointer text-lg">settings</span>
                                    </div>
                                </div>
                                <!-- Item 2 -->
                                <div class="flex items-center justify-between p-space-md rounded-lg bg-surface-container-lowest hover:bg-surface-container transition-colors shadow-sm">
                                    <div class="flex items-center gap-space-md">
                                        <span class="material-symbols-outlined text-outline cursor-grab">drag_indicator</span>
                                        <div class="w-6 h-6 rounded bg-surface-container-high text-tertiary font-code-sm text-code-sm flex items-center justify-center font-bold">02</div>
                                        <div>
                                            <div class="font-title-sm text-title-sm text-on-surface">Categorical Encoding</div>
                                            <div class="font-code-sm text-code-sm text-on-surface-variant">OneHotEncoder('contract_type', 'payment_method') · TargetEncoder('zip_code')</div>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-space-sm">
                                        <span class="px-2 py-0.5 rounded bg-surface-container text-outline font-code-sm text-code-sm">MixedEncoder</span>
                                        <span class="material-symbols-outlined text-outline hover:text-tertiary cursor-pointer text-lg">settings</span>
                                    </div>
                                </div>
                                <!-- Item 3 -->
                                <div class="flex items-center justify-between p-space-md rounded-lg bg-surface-container-lowest hover:bg-surface-container transition-colors shadow-sm">
                                    <div class="flex items-center gap-space-md">
                                        <span class="material-symbols-outlined text-outline cursor-grab">drag_indicator</span>
                                        <div class="w-6 h-6 rounded bg-surface-container-high text-tertiary font-code-sm text-code-sm flex items-center justify-center font-bold">03</div>
                                        <div>
                                            <div class="font-title-sm text-title-sm text-on-surface">Outlier Boundary Clipping</div>
                                            <div class="font-code-sm text-code-sm text-on-surface-variant">IQR 1.5x Multiplier on ('monthly_charges', 'total_usage_gb')</div>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-space-sm">
                                        <span class="px-2 py-0.5 rounded bg-surface-container text-outline font-code-sm text-code-sm">FunctionTransformer</span>
                                        <span class="material-symbols-outlined text-outline hover:text-tertiary cursor-pointer text-lg">settings</span>
                                    </div>
                                </div>
                                <!-- Item 4 -->
                                <div class="flex items-center justify-between p-space-md rounded-lg bg-surface-container-lowest hover:bg-surface-container transition-colors shadow-sm">
                                    <div class="flex items-center gap-space-md">
                                        <span class="material-symbols-outlined text-outline cursor-grab">drag_indicator</span>
                                        <div class="w-6 h-6 rounded bg-surface-container-high text-tertiary font-code-sm text-code-sm flex items-center justify-center font-bold">04</div>
                                        <div>
                                            <div class="font-title-sm text-title-sm text-on-surface">Feature Scaling & Normalization</div>
                                            <div class="font-code-sm text-code-sm text-on-surface-variant">StandardScaler (with_mean=True, with_std=True)</div>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-space-sm">
                                        <span class="px-2 py-0.5 rounded bg-surface-container text-outline font-code-sm text-code-sm">StandardScaler</span>
                                        <span class="material-symbols-outlined text-outline hover:text-tertiary cursor-pointer text-lg">settings</span>
                                    </div>
                                </div>
                                <!-- Item 5 -->
                                <div class="flex items-center justify-between p-space-md rounded-lg bg-surface-container-lowest hover:bg-surface-container transition-colors shadow-sm">
                                    <div class="flex items-center gap-space-md">
                                        <span class="material-symbols-outlined text-outline cursor-grab">drag_indicator</span>
                                        <div class="w-6 h-6 rounded bg-surface-container-high text-tertiary font-code-sm text-code-sm flex items-center justify-center font-bold">05</div>
                                        <div>
                                            <div class="font-title-sm text-title-sm text-on-surface">Mutual Information Feature Selection</div>
                                            <div class="font-code-sm text-code-sm text-on-surface-variant">SelectKBest (score_func=mutual_info_classif, k=28 of 42)</div>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-space-sm">
                                        <span class="px-2 py-0.5 rounded bg-surface-container text-outline font-code-sm text-code-sm">SelectKBest</span>
                                        <span class="material-symbols-outlined text-outline hover:text-tertiary cursor-pointer text-lg">settings</span>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <!-- ALGORITHM SELECTION -->
                        <section class="bg-surface-container-low rounded-xl p-space-lg shadow-sm flex flex-col gap-space-md">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-space-sm">
                                <div class="flex items-center gap-space-sm">
                                    <span class="material-symbols-outlined text-tertiary">hub</span>
                                    <h2 class="font-headline-md text-headline-md text-on-surface">Estimator Engine Architecture</h2>
                                </div>
                                <!-- Model Family Tabs -->
                                <div class="flex items-center bg-surface-container-lowest p-1 rounded-lg">
                                    <button class="px-3 py-1 rounded bg-primary-container text-tertiary font-label-sm text-label-sm uppercase font-semibold">Tabular / Classical</button>
                                    <button class="px-3 py-1 rounded text-outline hover:text-on-surface font-label-sm text-label-sm uppercase transition-colors">Computer Vision</button>
                                    <button class="px-3 py-1 rounded text-outline hover:text-on-surface font-label-sm text-label-sm uppercase transition-colors">NLP & LLMs</button>
                                </div>
                            </div>
                            <!-- Model Choice Cards Grid -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-space-sm">
                                <!-- Option 1: Logistic Regression -->
                                <div class="p-space-md rounded-lg bg-surface-container-lowest hover:bg-surface-container cursor-pointer transition-all flex flex-col justify-between">
                                    <div class="flex justify-between items-start mb-2">
                                        <span class="font-code-sm text-code-sm text-outline">LINEAR</span>
                                        <span class="w-2.5 h-2.5 rounded-full bg-outline-variant"></span>
                                    </div>
                                    <div>
                                        <div class="font-title-sm text-title-sm text-on-surface font-semibold">Logistic Regression</div>
                                        <div class="font-code-sm text-code-sm text-outline mt-1">L1 / L2 ElasticNet</div>
                                    </div>
                                </div>
                                <!-- Option 2: Random Forest -->
                                <div class="p-space-md rounded-lg bg-surface-container-lowest hover:bg-surface-container cursor-pointer transition-all flex flex-col justify-between">
                                    <div class="flex justify-between items-start mb-2">
                                        <span class="font-code-sm text-code-sm text-outline">BAGGING</span>
                                        <span class="w-2.5 h-2.5 rounded-full bg-outline-variant"></span>
                                    </div>
                                    <div>
                                        <div class="font-title-sm text-title-sm text-on-surface font-semibold">Random Forest</div>
                                        <div class="font-code-sm text-code-sm text-outline mt-1">Sklearn Ensemble</div>
                                    </div>
                                </div>
                                <!-- Option 3: XGBoost (SELECTED) -->
                                <div class="p-space-md rounded-lg bg-surface-container-high shadow-lg relative flex flex-col justify-between overflow-hidden">
                                    <div class="absolute top-0 right-0 w-12 h-12 bg-tertiary/10 rounded-bl-xl flex items-center justify-center">
                                        <span class="material-symbols-outlined text-tertiary text-sm">check</span>
                                    </div>
                                    <div class="flex justify-between items-start mb-2">
                                        <span class="font-code-sm text-code-sm text-tertiary font-bold">BOOSTING</span>
                                        <span class="w-2.5 h-2.5 rounded-full bg-tertiary shadow-[0_0_8px_rgba(255,185,86,0.8)]"></span>
                                    </div>
                                    <div>
                                        <div class="font-title-sm text-title-sm text-on-surface font-bold">XGBoost</div>
                                        <div class="font-code-sm text-code-sm text-tertiary mt-1">GPU Hist Exact (CUDA)</div>
                                    </div>
                                </div>
                                <!-- Option 4: LightGBM -->
                                <div class="p-space-md rounded-lg bg-surface-container-lowest hover:bg-surface-container cursor-pointer transition-all flex flex-col justify-between">
                                    <div class="flex justify-between items-start mb-2">
                                        <span class="font-code-sm text-code-sm text-outline">BOOSTING</span>
                                        <span class="w-2.5 h-2.5 rounded-full bg-outline-variant"></span>
                                    </div>
                                    <div>
                                        <div class="font-title-sm text-title-sm text-on-surface font-semibold">LightGBM</div>
                                        <div class="font-code-sm text-code-sm text-outline mt-1">GOSS Leaf-wise</div>
                                    </div>
                                </div>
                                <!-- Option 5: CatBoost -->
                                <div class="p-space-md rounded-lg bg-surface-container-lowest hover:bg-surface-container cursor-pointer transition-all flex flex-col justify-between">
                                    <div class="flex justify-between items-start mb-2">
                                        <span class="font-code-sm text-code-sm text-outline">BOOSTING</span>
                                        <span class="w-2.5 h-2.5 rounded-full bg-outline-variant"></span>
                                    </div>
                                    <div>
                                        <div class="font-title-sm text-title-sm text-on-surface font-semibold">CatBoost</div>
                                        <div class="font-code-sm text-code-sm text-outline mt-1">Symmetric Trees</div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <!-- HYPERPARAMETER TUNING & VALIDATION MATRIX -->
                        <section class="bg-surface-container-low rounded-xl p-space-lg shadow-sm flex flex-col gap-space-md">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-space-sm">
                                    <span class="material-symbols-outlined text-tertiary">tune</span>
                                    <div>
                                        <h2 class="font-headline-md text-headline-md text-on-surface">Hyperparameter Search Space & Cross-Validation</h2>
                                        <span class="font-code-sm text-code-sm text-outline">Engine: Optuna TPE (Tree-structured Parzen Estimator)</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="px-2.5 py-1 rounded bg-surface-container-high text-on-surface font-code-sm text-code-sm">50 Trials</span>
                                    <span class="px-2.5 py-1 rounded bg-surface-container-high text-on-surface font-code-sm text-code-sm">Timeout: 3600s</span>
                                </div>
                            </div>
                            <!-- 4 Grid Controls for Hyperparameters -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-space-md">
                                <!-- Parameter 1 -->
                                <div class="p-space-md rounded-lg bg-surface-container-lowest flex flex-col gap-2">
                                    <div class="flex justify-between items-center">
                                        <span class="font-label-sm text-label-sm uppercase text-outline">learning_rate [eta]</span>
                                        <span class="font-code-sm text-code-sm text-tertiary">log-uniform [0.01, 0.2]</span>
                                    </div>
                                    <div class="w-full bg-surface-container-high h-1.5 rounded-full overflow-hidden">
                                        <div class="bg-tertiary h-full rounded-full" style="width: 45%;"></div>
                                    </div>
                                    <div class="flex justify-between text-outline font-code-sm text-code-sm">
                                        <span>0.01</span>
                                        <span>Step: Auto TPE</span>
                                        <span>0.20</span>
                                    </div>
                                </div>
                                <!-- Parameter 2 -->
                                <div class="p-space-md rounded-lg bg-surface-container-lowest flex flex-col gap-2">
                                    <div class="flex justify-between items-center">
                                        <span class="font-label-sm text-label-sm uppercase text-outline">max_depth</span>
                                        <span class="font-code-sm text-code-sm text-tertiary">int uniform [3, 9]</span>
                                    </div>
                                    <div class="w-full bg-surface-container-high h-1.5 rounded-full overflow-hidden">
                                        <div class="bg-tertiary h-full rounded-full" style="width: 60%;"></div>
                                    </div>
                                    <div class="flex justify-between text-outline font-code-sm text-code-sm">
                                        <span>3</span>
                                        <span>Default: 6</span>
                                        <span>9</span>
                                    </div>
                                </div>
                                <!-- Parameter 3 -->
                                <div class="p-space-md rounded-lg bg-surface-container-lowest flex flex-col gap-2">
                                    <div class="flex justify-between items-center">
                                        <span class="font-label-sm text-label-sm uppercase text-outline">subsample & colsample</span>
                                        <span class="font-code-sm text-code-sm text-tertiary">uniform [0.6, 1.0]</span>
                                    </div>
                                    <div class="w-full bg-surface-container-high h-1.5 rounded-full overflow-hidden">
                                        <div class="bg-tertiary h-full rounded-full" style="width: 75%;"></div>
                                    </div>
                                    <div class="flex justify-between text-outline font-code-sm text-code-sm">
                                        <span>0.60</span>
                                        <span>Stochastic Row Fraction</span>
                                        <span>1.00</span>
                                    </div>
                                </div>
                                <!-- Parameter 4 -->
                                <div class="p-space-md rounded-lg bg-surface-container-lowest flex flex-col gap-2">
                                    <div class="flex justify-between items-center">
                                        <span class="font-label-sm text-label-sm uppercase text-outline">reg_lambda (L2 Regularization)</span>
                                        <span class="font-code-sm text-code-sm text-tertiary">log-uniform [1e-3, 10.0]</span>
                                    </div>
                                    <div class="w-full bg-surface-container-high h-1.5 rounded-full overflow-hidden">
                                        <div class="bg-tertiary h-full rounded-full" style="width: 30%;"></div>
                                    </div>
                                    <div class="flex justify-between text-outline font-code-sm text-code-sm">
                                        <span>0.001</span>
                                        <span>Hessian Damping</span>
                                        <span>10.0</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Cross-Validation Sub-row -->
                            <div class="flex items-center justify-between p-space-md rounded-lg bg-surface-container-high">
                                <div class="flex items-center gap-space-sm">
                                    <span class="material-symbols-outlined text-tertiary">schema</span>
                                    <div>
                                        <div class="font-title-sm text-title-sm text-on-surface">5-Fold Stratified K-Fold CV Protocol</div>
                                        <div class="font-code-sm text-code-sm text-outline">Metrics calculated per fold: F1-Macro, ROC-AUC, LogLoss with Early Stopping (patience=15)</div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="px-2 py-0.5 rounded bg-surface-container-lowest text-tertiary font-code-sm text-code-sm">Target Metric: F1 ≥ 0.80</span>
                                </div>
                            </div>
                        </section>
                    </div>
                    <!-- RIGHT COLUMN: Real-Time Generated Code & Launch Telemetry (4 Cols) -->
                    <div class="xl:col-span-4 flex flex-col gap-space-lg">
                        <!-- CODE INSPECTOR CARD -->
                        <section class="bg-surface-container-low rounded-xl p-space-lg shadow-sm flex flex-col gap-space-md">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-tertiary text-lg">terminal</span>
                                    <span class="font-title-sm text-title-sm text-on-surface">Python Notebook Spec</span>
                                </div>
                                <!-- View Toggle -->
                                <div class="flex items-center bg-surface-container-lowest p-1 rounded-lg">
                                    <button class="px-2.5 py-1 rounded text-outline hover:text-on-surface font-label-sm text-label-sm uppercase transition-colors" id="view-visual-btn">Visual</button>
                                    <button class="px-2.5 py-1 rounded bg-surface-container-high text-tertiary font-label-sm text-label-sm uppercase font-semibold shadow-sm" id="view-code-btn">Code Live</button>
                                </div>
                            </div>
                            <!-- Code Block Window with Syntax Aesthetic -->
                            <div class="bg-surface-container-lowest rounded-lg p-space-md font-code-sm text-code-sm text-on-surface overflow-x-auto shadow-inner border-0">
                                <div class="flex items-center justify-between pb-2 mb-2 border-b border-outline-variant/30 text-outline">
                                    <span class="font-code-sm text-code-sm"># cell_03_pipeline_definition.py</span>
                                    <button class="hover:text-tertiary flex items-center gap-1 font-label-sm text-label-sm uppercase" onclick="navigator.clipboard.writeText('# Code copied')">
                                        <span class="material-symbols-outlined text-xs">content_copy</span> Copy
                                    </button>
                                </div>
                                <pre class="font-code-sm leading-relaxed text-on-surface-variant"><span class="text-tertiary">import</span> xgboost <span class="text-tertiary">as</span> xgb
<span class="text-tertiary">from</span> sklearn.pipeline <span class="text-tertiary">import</span> Pipeline
<span class="text-tertiary">from</span> sklearn.compose <span class="text-tertiary">import</span> ColumnTransformer
<span class="text-tertiary">from</span> sklearn.feature_selection <span class="text-tertiary">import</span> SelectKBest, mutual_info_classif
<span class="text-tertiary">import</span> optuna

<span class="text-outline"># Assembled Preprocessing Engine</span>
preprocessor = ColumnTransformer([
    (<span class="text-secondary-fixed">'num'</span>, numeric_transformer, num_cols),
    (<span class="text-secondary-fixed">'cat'</span>, categorical_transformer, cat_cols)
])

<span class="text-tertiary">def</span> <span class="text-primary font-semibold">objective</span>(trial):
    params = {
        <span class="text-secondary-fixed">'n_estimators'</span>: <span class="text-tertiary">500</span>,
        <span class="text-secondary-fixed">'tree_method'</span>: <span class="text-secondary-fixed">'hist'</span>,
        <span class="text-secondary-fixed">'device'</span>: <span class="text-secondary-fixed">'cuda'</span>,
        <span class="text-secondary-fixed">'learning_rate'</span>: trial.suggest_float(
            <span class="text-secondary-fixed">'lr'</span>, <span class="text-tertiary">0.01</span>, <span class="text-tertiary">0.2</span>, log=<span class="text-tertiary">True</span>
        ),
        <span class="text-secondary-fixed">'max_depth'</span>: trial.suggest_int(
            <span class="text-secondary-fixed">'max_depth'</span>, <span class="text-tertiary">3</span>, <span class="text-tertiary">9</span>
        ),
        <span class="text-secondary-fixed">'reg_lambda'</span>: trial.suggest_float(
            <span class="text-secondary-fixed">'reg_lambda'</span>, <span class="text-tertiary">1e-3</span>, <span class="text-tertiary">10.0</span>, log=<span class="text-tertiary">True</span>
        )
    }
    model = xgb.XGBClassifier(**params)
    <span class="text-tertiary">return</span> cross_val_score(model, X, y, cv=<span class="text-tertiary">5</span>, scoring=<span class="text-secondary-fixed">'f1_macro'</span>).mean()</pre>
                            </div>
                            <div class="flex items-center justify-between text-outline font-code-sm text-code-sm px-1">
                                <span class="flex items-center gap-1">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                    Sync Engine: Active
                                </span>
                                <span>CUDA 12.4 Compatible</span>
                            </div>
                        </section>
                        <!-- HARDWARE TARGET & CLUSTER ALLOCATION -->
                        <section class="bg-surface-container-low rounded-xl p-space-lg shadow-sm flex flex-col gap-space-md">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-space-sm">
                                    <span class="material-symbols-outlined text-tertiary">memory</span>
                                    <h2 class="font-headline-md text-headline-md text-on-surface">Compute Target Allocation</h2>
                                </div>
                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(46,158,107,0.8)]"></span>
                            </div>
                            <div class="p-space-md rounded-lg bg-surface-container-lowest flex flex-col gap-3">
                                <div class="flex items-center justify-between">
                                    <span class="font-label-sm text-label-sm uppercase text-outline">Selected GPU Node</span>
                                    <span class="font-code-sm text-code-sm text-secondary-fixed">ORB-EU-WEST-04</span>
                                </div>
                                <div class="flex items-center gap-space-md">
                                    <div class="w-12 h-12 rounded-lg bg-surface-container-high flex items-center justify-center text-tertiary">
                                        <span class="material-symbols-outlined text-2xl">developer_board</span>
                                    </div>
                                    <div>
                                        <div class="font-title-sm text-title-sm text-on-surface font-semibold">NVIDIA H100 SXM5</div>
                                        <div class="font-code-sm text-code-sm text-on-surface-variant">80GB HBM3 • 3.35 TB/s Bandwidth</div>
                                    </div>
                                </div>
                                <!-- Allocation sliders / stats -->
                                <div class="grid grid-cols-2 gap-space-sm pt-2 border-t border-outline-variant/30">
                                    <div>
                                        <div class="font-label-sm text-label-sm text-outline uppercase">Est. Run Duration</div>
                                        <div class="font-headline-md text-headline-md text-on-surface font-mono">14m 20s</div>
                                    </div>
                                    <div>
                                        <div class="font-label-sm text-label-sm text-outline uppercase">Compute Credits</div>
                                        <div class="font-headline-md text-headline-md text-tertiary font-mono">1.82 CR</div>
                                    </div>
                                </div>
                            </div>
                            <!-- ACTION CTAs -->
                            <div class="flex flex-col gap-space-sm pt-2">
                                <!-- Primary CTA -->
                                <button class="w-full h-11 rounded-lg bg-primary-container text-on-surface font-label-sm text-label-sm uppercase tracking-wider font-semibold flex items-center justify-center gap-space-sm hover:bg-surface-container-highest transition-all shadow-md group">
                                    <span class="material-symbols-outlined text-tertiary group-hover:scale-110 transition-transform">bolt</span>
                                    <span>Launch Training Run</span>
                                </button>
                                <!-- Secondary Actions -->
                                <div class="grid grid-cols-2 gap-space-sm">
                                    <button class="h-10 rounded-lg bg-surface-container-high text-on-surface hover:bg-surface-container-highest font-label-sm text-label-sm uppercase tracking-wider transition-colors flex items-center justify-center gap-1.5 shadow-sm">
                                        <span class="material-symbols-outlined text-base">play_arrow</span>
                                        Dry Run (100 rows)
                                    </button>
                                    <button class="h-10 rounded-lg bg-surface-container-high text-on-surface hover:bg-surface-container-highest font-label-sm text-label-sm uppercase tracking-wider transition-colors flex items-center justify-center gap-1.5 shadow-sm">
                                        <span class="material-symbols-outlined text-base">bookmark</span>
                                        Save Template
                                    </button>
                                </div>
                            </div>
                        </section>
                        <!-- AUDIT / SAFETY RAILS TILE (High-contrast Periwinkle Accent Layer) -->
                        <section class="bg-surface-tint rounded-xl p-space-md shadow-md text-on-primary-fixed flex flex-col gap-2">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-lg text-on-primary-fixed font-bold">verified_user</span>
                                    <span class="font-label-sm text-label-sm uppercase tracking-wider font-bold">Mission Rail Protocol</span>
                                </div>
                                <span class="font-code-sm text-code-sm font-semibold uppercase">AIR-GAP: PASS</span>
                            </div>
                            <p class="font-body-sm text-body-sm text-on-primary-fixed-variant leading-relaxed">
                                Pipeline configuration conforms to VOSTOKPRIBOR Avionics Directive #AI-024. Leakage inspection passed with zero temporal column target correlation detected.
                            </p>
                        </section>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>