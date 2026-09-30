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
            <div class="flex flex-col w-full gap-space-md">
                <!-- Breadcrumb & Avionics Telemetry Meta Strip -->
                <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-space-sm bg-surface-container-low p-space-md rounded-xl shadow-md">
                    <div class="flex flex-wrap items-center gap-space-xs font-mono text-code-sm">
                        <span class="text-on-surface-variant">WORKBENCH</span>
                        <span class="text-outline">/</span>
                        <span class="text-on-surface-variant">SYS-AI-03</span>
                        <span class="text-outline">/</span>
                        <span class="px-2 py-0.5 rounded bg-surface-container-high text-secondary font-semibold">TICKET #AI-024: CUSTOMER CHURN</span>
                        <span class="text-outline">/</span>
                        <span class="px-2 py-0.5 rounded bg-tertiary-container text-tertiary font-bold tracking-tight">RUN #EXP-024-01</span>
                        <span class="text-on-surface ml-1 font-body-sm">(Logistic Regression Baseline)</span>
                    </div>
                    <div class="flex items-center gap-space-md self-end lg:self-auto font-mono text-code-sm text-on-surface-variant">
                        <div class="flex items-center gap-1.5 bg-surface-container-lowest px-2.5 py-1 rounded">
                            <span class="material-symbols-outlined text-sm text-outline">timer</span>
                            <span>DURATION: <strong class="text-on-surface font-semibold">04m 18s</strong></span>
                        </div>
                        <div class="flex items-center gap-1.5 bg-surface-container-lowest px-2.5 py-1 rounded">
                            <span class="material-symbols-outlined text-sm text-outline">commit</span>
                            <span>GIT: <strong class="text-tertiary font-semibold">#9f2a81b</strong></span>
                        </div>
                        <div class="flex items-center gap-1.5 bg-surface-container-lowest px-2.5 py-1 rounded">
                            <span class="w-2 h-2 rounded-full bg-error animate-ping"></span>
                            <span class="text-error font-semibold uppercase">BELOW SPEC</span>
                        </div>
                    </div>
                </div>
                <!-- CRITICAL BUSINESS THRESHOLD BANNER: Strictly Neutral & Rigorous -->
                <div class="flex items-center justify-between px-space-md py-space-sm bg-surface-container-high rounded-xl shadow-inner">
                    <div class="flex items-center gap-space-sm">
                        <div class="w-8 h-8 rounded-lg bg-surface-container-lowest flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-tertiary text-lg">warning</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-headline-md text-title-sm text-on-surface uppercase tracking-wide font-semibold">System Constraint Telemetry Status</span>
                            <p class="font-body-md text-body-sm text-on-surface-variant">The model is performing below the required business threshold.</p>
                        </div>
                    </div>
                    <div class="hidden sm:flex items-center gap-space-sm font-mono text-code-sm">
                        <span class="px-2.5 py-1 rounded bg-surface-container-lowest text-outline">METRIC CONSTRAINT: F1_SCORE ≥ 0.8000</span>
                        <span class="px-2.5 py-1 rounded bg-error-container text-on-error-container font-semibold">ACTUAL: 0.7100 (Δ -0.0900)</span>
                    </div>
                </div>
                <!-- Hero Metric Bento Array -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-space-sm">
                    <!-- Primary Business Threshold Visual Dial (Span 2) -->
                    <div class="lg:col-span-2 bg-surface-container p-space-md rounded-xl flex flex-col justify-between shadow-md">
                        <div class="flex items-center justify-between">
                            <div class="flex flex-col">
                                <span class="font-label-sm text-label-sm text-outline uppercase tracking-wider font-mono">PRIMARY TARGET EVALUATION</span>
                                <span class="font-headline-lg text-headline-lg text-on-surface font-semibold">F1 Performance Delta</span>
                            </div>
                            <span class="font-mono text-code-sm px-2 py-0.5 rounded bg-surface-container-highest text-tertiary font-bold">CALIBRATED</span>
                        </div>
                        <!-- Semi-Circle / Linear Target Dial Visualization -->
                        <div class="relative flex flex-col items-center justify-center py-2">
                            <svg class="w-56 h-32 overflow-visible" viewbox="0 0 240 130">
                                <!-- Dial Track Arc -->
                                <path class="text-surface-container-highest" d="M 30 110 A 90 90 0 0 1 210 110" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="14"></path>
                                <!-- Actual Progress Arc (71%) -->
                                <path class="text-tertiary" d="M 30 110 A 90 90 0 0 1 210 110" fill="none" stroke="currentColor" stroke-dasharray="282.7" stroke-dashoffset="82" stroke-linecap="round" stroke-width="14"></path>
                                <!-- Target Threshold Notch (80% / angle: 144 deg) -->
                                <!-- Point at 80% arc: center (120,110), r=90, angle=180 - (180*0.8) = 36 deg from right -> cos(36)*90 = 72.8, sin(36)*90 = 52.9 -> (120 + 72.8, 110 - 52.9) = (192.8, 57.1) -->
                                <line class="text-error" stroke="currentColor" stroke-width="3" x1="184" x2="202" y1="62" y2="52"></line>
                                <!-- Indicator Needle -->
                                <circle class="text-tertiary" cx="120" cy="110" fill="currentColor" r="6"></circle>
                                <!-- Pointer rotated for 0.71 = 180 * 0.71 = 127.8 deg -> angle from horizontal = 52.2 deg -->
                                <line class="text-tertiary" stroke="currentColor" stroke-linecap="round" stroke-width="3" x1="120" x2="168" y1="110" y2="48"></line>
                                <text class="fill-current text-on-surface font-headline-xl font-bold font-mono text-2xl" text-anchor="middle" x="120" y="98">0.710</text>
                                <text class="fill-current text-outline font-code-sm text-[10px] uppercase tracking-widest font-mono" text-anchor="middle" x="120" y="112">CURRENT RUN</text>
                            </svg>
                            <div class="w-full flex items-center justify-between text-code-sm font-mono px-4 pt-1">
                                <span class="text-outline">0.00</span>
                                <div class="flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-error"></span>
                                    <span class="text-on-surface-variant font-semibold">TARGET: ≥ 0.80</span>
                                </div>
                                <span class="text-outline">1.00</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between bg-surface-container-low p-2 rounded-lg text-code-sm font-mono">
                            <span class="text-outline">REQUIRED MIN: 0.800</span>
                            <span class="text-error font-semibold">DELTA GAP: -0.090 (-11.2%)</span>
                        </div>
                    </div>
                    <!-- Accuracy Bento Card -->
                    <div class="bg-surface-container p-space-md rounded-xl flex flex-col justify-between shadow-md">
                        <div class="flex items-center justify-between">
                            <span class="font-label-sm text-label-sm text-outline uppercase tracking-wider font-mono">OVERALL ACCURACY</span>
                            <span class="material-symbols-outlined text-outline text-lg">check_circle</span>
                        </div>
                        <div class="my-auto py-2">
                            <div class="font-headline-xl text-display-lg text-on-surface font-semibold font-mono tracking-tight">78.0<span class="text-headline-md text-outline font-normal">%</span></div>
                            <div class="w-full bg-surface-container-highest h-1.5 rounded-full mt-2 overflow-hidden">
                                <div class="bg-primary h-full rounded-full" style="width: 78%;"></div>
                            </div>
                        </div>
                        <div class="text-code-sm font-mono text-outline flex justify-between">
                            <span>BASELINE</span>
                            <span class="text-on-surface">73.2% (+4.8%)</span>
                        </div>
                    </div>
                    <!-- Precision Bento Card -->
                    <div class="bg-surface-container p-space-md rounded-xl flex flex-col justify-between shadow-md">
                        <div class="flex items-center justify-between">
                            <span class="font-label-sm text-label-sm text-outline uppercase tracking-wider font-mono">PRECISION (POS)</span>
                            <span class="material-symbols-outlined text-outline text-lg">filter_alt</span>
                        </div>
                        <div class="my-auto py-2">
                            <div class="font-headline-xl text-display-lg text-on-surface font-semibold font-mono tracking-tight">74.2<span class="text-headline-md text-outline font-normal">%</span></div>
                            <div class="w-full bg-surface-container-highest h-1.5 rounded-full mt-2 overflow-hidden">
                                <div class="bg-primary h-full rounded-full" style="width: 74.2%;"></div>
                            </div>
                        </div>
                        <div class="text-code-sm font-mono text-outline flex justify-between">
                            <span>FP RATIO</span>
                            <span class="text-on-surface">25.8% (HIGH)</span>
                        </div>
                    </div>
                    <!-- Recall Bento Card -->
                    <div class="bg-surface-container p-space-md rounded-xl flex flex-col justify-between shadow-md">
                        <div class="flex items-center justify-between">
                            <span class="font-label-sm text-label-sm text-outline uppercase tracking-wider font-mono">RECALL (CHURN)</span>
                            <span class="material-symbols-outlined text-outline text-lg">troubleshoot</span>
                        </div>
                        <div class="my-auto py-2">
                            <div class="font-headline-xl text-display-lg text-on-surface font-semibold font-mono tracking-tight">69.1<span class="text-headline-md text-outline font-normal">%</span></div>
                            <div class="w-full bg-surface-container-highest h-1.5 rounded-full mt-2 overflow-hidden">
                                <div class="bg-secondary-fixed-dim h-full rounded-full" style="width: 69.1%;"></div>
                            </div>
                        </div>
                        <div class="text-code-sm font-mono text-outline flex justify-between">
                            <span>FN COUNT</span>
                            <span class="text-error font-semibold">5,940 CHURNS</span>
                        </div>
                    </div>
                    <!-- Dual AUC & Highlighted F1 Tile (Span 1) -->
                    <div class="bg-surface-container-high p-space-md rounded-xl flex flex-col justify-between shadow-lg relative overflow-hidden">
                        <!-- Amber glow accent banner strip -->
                        <div class="absolute top-0 left-0 right-0 h-1 bg-tertiary"></div>
                        <div class="flex items-center justify-between">
                            <span class="font-label-sm text-label-sm text-tertiary uppercase tracking-widest font-mono font-bold">CRITICAL F1 HIGHLIGHT</span>
                            <span class="material-symbols-outlined text-tertiary text-lg">flag</span>
                        </div>
                        <div class="my-auto py-1">
                            <div class="flex items-baseline gap-1">
                                <span class="font-headline-xl text-display-lg text-tertiary font-bold font-mono tracking-tight">71.0</span>
                                <span class="font-headline-md text-on-surface-variant font-mono">%</span>
                            </div>
                            <span class="font-label-sm text-label-sm text-on-surface uppercase font-mono tracking-wide">F1-Score Harmonic Mean</span>
                        </div>
                        <div class="pt-2 bg-surface-container-lowest/80 -mx-4 -mb-4 p-3 rounded-b-xl flex flex-col gap-1 font-mono text-code-sm">
                            <div class="flex justify-between items-center text-outline">
                                <span>ROC-AUC</span>
                                <strong class="text-primary font-bold">0.792</strong>
                            </div>
                            <div class="flex justify-between items-center text-outline">
                                <span>PR-AUC</span>
                                <strong class="text-secondary font-bold">0.724</strong>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Visual Diagnostics Grid (4-Quadrant Bento Array) -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-space-md">
                    <!-- TOP-LEFT: Confusion Matrix Matrix Console -->
                    <div class="bg-surface-container p-space-md rounded-xl flex flex-col shadow-md">
                        <div class="flex items-center justify-between pb-space-sm mb-space-sm bg-surface-container-low/40 p-2.5 rounded-lg">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-secondary text-lg">grid_4x4</span>
                                <div class="flex flex-col">
                                    <span class="font-headline-md text-title-sm text-on-surface font-semibold">Confusion Matrix Array</span>
                                    <span class="font-code-sm text-code-sm text-outline font-mono">N = 96,000 VALIDATION SAMPLES (THRESHOLD = 0.50)</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-1 font-mono text-code-sm bg-surface-container-lowest px-2 py-1 rounded">
                                <span class="text-outline">NORM:</span>
                                <span class="text-tertiary font-bold">ABSOLUTE & ROW-%</span>
                            </div>
                        </div>
                        <div class="flex-1 flex flex-col justify-center">
                            <!-- Matrix Table Headers -->
                            <div class="grid grid-cols-12 gap-2 text-center font-mono text-label-sm uppercase text-outline mb-2">
                                <div class="col-span-3 text-left pl-2">ACTUAL \ PREDICTED</div>
                                <div class="col-span-4 bg-surface-container-low py-1 rounded">PRED: ACTIVE (0)</div>
                                <div class="col-span-5 bg-surface-container-low py-1 rounded">PRED: CHURN (1)</div>
                            </div>
                            <!-- Row 1: Actual Active -->
                            <div class="grid grid-cols-12 gap-2 mb-2 font-mono">
                                <div class="col-span-3 flex flex-col justify-center bg-surface-container-low p-2 rounded text-left">
                                    <span class="text-label-sm font-label-sm text-on-surface uppercase font-bold">ACTUAL ACTIVE</span>
                                    <span class="text-code-sm text-outline font-mono">CLASS 0 (76,780)</span>
                                </div>
                                <!-- True Negative (TN) -->
                                <div class="col-span-4 bg-secondary-container/60 p-3 rounded-lg flex flex-col justify-center items-center group transition-colors hover:bg-secondary-container">
                                    <span class="text-label-sm font-label-sm text-secondary-fixed uppercase tracking-wider">TRUE NEGATIVE (TN)</span>
                                    <span class="font-headline-lg text-headline-lg font-bold text-on-surface mt-1">72,160</span>
                                    <div class="w-full flex items-center justify-between text-code-sm text-secondary-fixed-dim pt-1">
                                        <span>93.98% Spec</span>
                                        <span class="text-on-surface-variant">Class 0</span>
                                    </div>
                                </div>
                                <!-- False Positive (FP) -->
                                <div class="col-span-5 bg-error-container/40 p-3 rounded-lg flex flex-col justify-center items-center group transition-colors hover:bg-error-container/60">
                                    <span class="text-label-sm font-label-sm text-on-error-container uppercase tracking-wider">FALSE POSITIVE (FP)</span>
                                    <span class="font-headline-lg text-headline-lg font-bold text-error mt-1">4,620</span>
                                    <div class="w-full flex items-center justify-between text-code-sm text-on-error-container pt-1">
                                        <span>6.02% Type-I Err</span>
                                        <span>False Alarm</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Row 2: Actual Churn -->
                            <div class="grid grid-cols-12 gap-2 font-mono">
                                <div class="col-span-3 flex flex-col justify-center bg-surface-container-low p-2 rounded text-left">
                                    <span class="text-label-sm font-label-sm text-tertiary uppercase font-bold">ACTUAL CHURN</span>
                                    <span class="text-code-sm text-outline font-mono">CLASS 1 (19,220)</span>
                                </div>
                                <!-- False Negative (FN) -->
                                <div class="col-span-4 bg-error-container/60 p-3 rounded-lg flex flex-col justify-center items-center group transition-colors hover:bg-error-container/80">
                                    <span class="text-label-sm font-label-sm text-on-error-container uppercase tracking-wider font-bold">FALSE NEGATIVE (FN)</span>
                                    <span class="font-headline-lg text-headline-lg font-bold text-on-error-container mt-1">5,940</span>
                                    <div class="w-full flex items-center justify-between text-code-sm text-on-error-container pt-1">
                                        <span>30.91% Missed</span>
                                        <span class="font-bold">UNRECOVERED</span>
                                    </div>
                                </div>
                                <!-- True Positive (TP) -->
                                <div class="col-span-5 bg-tertiary-container/80 p-3 rounded-lg flex flex-col justify-center items-center group transition-colors hover:bg-tertiary-container">
                                    <span class="text-label-sm font-label-sm text-tertiary-fixed uppercase tracking-wider font-bold">TRUE POSITIVE (TP)</span>
                                    <span class="font-headline-lg text-headline-lg font-bold text-tertiary mt-1">13,280</span>
                                    <div class="w-full flex items-center justify-between text-code-sm text-on-tertiary-container pt-1">
                                        <span>69.09% Recall</span>
                                        <span>Captured</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center justify-between text-code-sm font-mono text-outline pt-2 bg-surface-container-lowest/60 px-3 py-2 rounded-lg">
                            <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded bg-tertiary"></span> POSITIVE CHURN CLASS WEIGHT: 1.00</span>
                            <span class="text-on-surface">TOTAL MISCLASSIFIED: 10,560 (11.0%)</span>
                        </div>
                    </div>
                    <!-- TOP-RIGHT: ROC Curve & PR Curve Tabbed Instrument -->
                    <div class="bg-surface-container p-space-md rounded-xl flex flex-col shadow-md">
                        <div class="flex items-center justify-between pb-space-sm mb-space-sm bg-surface-container-low/40 p-2.5 rounded-lg">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary text-lg">show_chart</span>
                                <div class="flex flex-col">
                                    <span class="font-headline-md text-title-sm text-on-surface font-semibold">Operating Curves</span>
                                    <span class="font-code-sm text-code-sm text-outline font-mono">THRESHOLD SENSITIVITY SWEEP</span>
                                </div>
                            </div>
                            <!-- Toggle Tabs -->
                            <div class="flex items-center rounded-lg bg-surface-container-lowest p-0.5">
                                <button class="px-2.5 py-1 text-label-sm font-label-sm rounded font-mono bg-surface-container-high text-on-surface font-bold shadow-sm" id="tab-roc">ROC (0.792)</button>
                                <button class="px-2.5 py-1 text-label-sm font-label-sm rounded font-mono text-outline hover:text-on-surface transition-colors" id="tab-pr">PR-AUC (0.724)</button>
                            </div>
                        </div>
                        <!-- Vector Diagnostic Graph -->
                        <div class="relative flex-1 min-h-[220px] bg-surface-container-lowest rounded-lg p-3 flex flex-col justify-between">
                            <!-- Grid overlay & Curves -->
                            <svg class="w-full h-44 overflow-visible font-mono" viewbox="0 0 400 200">
                                <!-- Background Grid Lines -->
                                <line class="text-outline-variant/30" stroke="currentColor" stroke-dasharray="4" stroke-width="1" x1="40" x2="380" y1="20" y2="20"></line>
                                <line class="text-outline-variant/30" stroke="currentColor" stroke-dasharray="4" stroke-width="1" x1="40" x2="380" y1="60" y2="60"></line>
                                <line class="text-outline-variant/30" stroke="currentColor" stroke-dasharray="4" stroke-width="1" x1="40" x2="380" y1="100" y2="100"></line>
                                <line class="text-outline-variant/30" stroke="currentColor" stroke-dasharray="4" stroke-width="1" x1="40" x2="380" y1="140" y2="140"></line>
                                <line class="text-outline-variant/30" stroke="currentColor" stroke-dasharray="4" stroke-width="1" x1="125" x2="125" y1="20" y2="170"></line>
                                <line class="text-outline-variant/30" stroke="currentColor" stroke-dasharray="4" stroke-width="1" x1="210" x2="210" y1="20" y2="170"></line>
                                <line class="text-outline-variant/30" stroke="currentColor" stroke-dasharray="4" stroke-width="1" x1="295" x2="295" y1="20" y2="170"></line>
                                <!-- Axis Axes -->
                                <line class="text-outline-variant" stroke="currentColor" stroke-width="1.5" x1="40" x2="380" y1="170" y2="170"></line>
                                <line class="text-outline-variant" stroke="currentColor" stroke-width="1.5" x1="40" x2="40" y1="20" y2="170"></line>
                                <!-- Axis Labels -->
                                <text class="fill-current text-outline text-[9px]" text-anchor="end" x="35" y="24">1.0</text>
                                <text class="fill-current text-outline text-[9px]" text-anchor="end" x="35" y="98">0.5</text>
                                <text class="fill-current text-outline text-[9px]" text-anchor="end" x="35" y="172">0.0</text>
                                <text class="fill-current text-outline text-[9px]" text-anchor="middle" x="40" y="184">0.0</text>
                                <text class="fill-current text-outline text-[9px]" text-anchor="middle" x="210" y="184">0.5</text>
                                <text class="fill-current text-outline text-[9px]" text-anchor="middle" x="380" y="184">1.0</text>
                                <!-- Random Chance Baseline (Diagonal) -->
                                <line class="text-outline/50" stroke="currentColor" stroke-dasharray="3 3" stroke-width="1.5" x1="40" x2="380" y1="170" y2="20"></line>
                                <!-- Model ROC Curve (Logistic Regression) -->
                                <path class="text-secondary" d="M 40 170 C 70 80, 130 45, 380 20" fill="none" stroke="currentColor" stroke-width="2.5"></path>
                                <!-- Optimal Operating Threshold Point @ threshold 0.42 (FPR 0.18, TPR 0.79 -> X: 40 + 0.18*340 = 101.2, Y: 170 - 0.79*150 = 51.5) -->
                                <circle class="text-tertiary" cx="102" cy="52" fill="currentColor" r="5"></circle>
                                <circle class="text-tertiary animate-ping" cx="102" cy="52" fill="none" r="9" stroke="currentColor" stroke-width="1"></circle>
                                <!-- Callout Marker -->
                                <line class="text-tertiary" stroke="currentColor" stroke-width="1" x1="102" x2="160" y1="52" y2="35"></line>
                                <rect class="text-surface-container-high" fill="currentColor" height="24" rx="3" width="138" x="160" y="24"></rect>
                                <text class="fill-current text-tertiary font-bold text-[10px]" x="166" y="40">OPTIMAL OPERATING @ τ=0.42</text>
                            </svg>
                            <!-- Metric Indicator strip underneath -->
                            <div class="flex items-center justify-between text-code-sm font-mono pt-1 text-on-surface-variant">
                                <div class="flex items-center gap-1.5">
                                    <span class="w-3 h-0.5 bg-secondary inline-block"></span>
                                    <span>ROC-AUC: <strong class="text-on-surface">0.792</strong></span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-tertiary"></span>
                                    <span>SELECTED THRESHOLD: <strong class="text-tertiary font-bold">0.42</strong> (J-STATISTIC MAX)</span>
                                </div>
                                <div class="flex items-center gap-1.5 text-outline">
                                    <span class="w-3 h-0.5 border-b border-dashed border-outline inline-block"></span>
                                    <span>CHANCE = 0.50</span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2 text-code-sm font-mono text-outline flex justify-between px-1">
                            <span>FPR: 0.182 @ τ=0.42</span>
                            <span>TPR (RECALL): 0.794 @ τ=0.42</span>
                        </div>
                    </div>
                    <!-- BOTTOM-LEFT: Feature Importance Bar Chart -->
                    <div class="bg-surface-container p-space-md rounded-xl flex flex-col shadow-md">
                        <div class="flex items-center justify-between pb-space-sm mb-space-sm bg-surface-container-low/40 p-2.5 rounded-lg">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-tertiary text-lg">stacked_bar_chart</span>
                                <div class="flex flex-col">
                                    <span class="font-headline-md text-title-sm text-on-surface font-semibold">Standardized Feature Importance</span>
                                    <span class="font-code-sm text-code-sm text-outline font-mono">LOGISTIC COEFFICIENT ABS MAGNITUDE (|β|)</span>
                                </div>
                            </div>
                            <span class="font-mono text-code-sm text-secondary bg-surface-container-lowest px-2 py-0.5 rounded">TOP 5 DETERMINANTS</span>
                        </div>
                        <div class="flex-1 flex flex-col justify-around gap-2.5 font-mono py-1">
                            <!-- Feature 1 -->
                            <div class="flex flex-col gap-1">
                                <div class="flex items-center justify-between text-code-sm">
                                    <span class="text-on-surface font-semibold">1. tenure_months</span>
                                    <div class="flex items-center gap-2">
                                        <span class="text-error font-semibold">-1.428 β</span>
                                        <span class="text-outline text-label-sm">(INVERSE CHURN)</span>
                                    </div>
                                </div>
                                <div class="w-full bg-surface-container-lowest h-3 rounded-full overflow-hidden flex">
                                    <div class="bg-primary h-full rounded-full" style="width: 88%;"></div>
                                </div>
                            </div>
                            <!-- Feature 2 -->
                            <div class="flex flex-col gap-1">
                                <div class="flex items-center justify-between text-code-sm">
                                    <span class="text-on-surface font-semibold">2. total_contract_value</span>
                                    <div class="flex items-center gap-2">
                                        <span class="text-primary font-semibold">+1.104 β</span>
                                        <span class="text-outline text-label-sm">(DIRECT RETENTION)</span>
                                    </div>
                                </div>
                                <div class="w-full bg-surface-container-lowest h-3 rounded-full overflow-hidden flex">
                                    <div class="bg-primary/80 h-full rounded-full" style="width: 72%;"></div>
                                </div>
                            </div>
                            <!-- Feature 3 -->
                            <div class="flex flex-col gap-1">
                                <div class="flex items-center justify-between text-code-sm">
                                    <span class="text-on-surface font-semibold">3. support_tickets_30d</span>
                                    <div class="flex items-center gap-2">
                                        <span class="text-tertiary font-bold">+0.892 β</span>
                                        <span class="text-outline text-label-sm">(CHURN DRIVER)</span>
                                    </div>
                                </div>
                                <div class="w-full bg-surface-container-lowest h-3 rounded-full overflow-hidden flex">
                                    <div class="bg-tertiary h-full rounded-full" style="width: 58%;"></div>
                                </div>
                            </div>
                            <!-- Feature 4 -->
                            <div class="flex flex-col gap-1">
                                <div class="flex items-center justify-between text-code-sm">
                                    <span class="text-on-surface font-semibold">4. payment_method_auto</span>
                                    <div class="flex items-center gap-2">
                                        <span class="text-secondary font-semibold">-0.564 β</span>
                                        <span class="text-outline text-label-sm">(INVERSE)</span>
                                    </div>
                                </div>
                                <div class="w-full bg-surface-container-lowest h-3 rounded-full overflow-hidden flex">
                                    <div class="bg-secondary h-full rounded-full" style="width: 38%;"></div>
                                </div>
                            </div>
                            <!-- Feature 5 -->
                            <div class="flex flex-col gap-1">
                                <div class="flex items-center justify-between text-code-sm">
                                    <span class="text-on-surface font-semibold">5. roaming_usage_ratio</span>
                                    <div class="flex items-center gap-2">
                                        <span class="text-on-surface-variant font-semibold">+0.320 β</span>
                                        <span class="text-outline text-label-sm">(DIRECT)</span>
                                    </div>
                                </div>
                                <div class="w-full bg-surface-container-lowest h-3 rounded-full overflow-hidden flex">
                                    <div class="bg-outline h-full rounded-full" style="width: 22%;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="pt-2 text-code-sm font-mono text-outline flex items-center justify-between bg-surface-container-lowest/60 px-3 py-1.5 rounded-lg mt-2">
                            <span>L2 PENALTY (RIDGE): C = 1.0</span>
                            <span class="text-on-surface">COVARIATES TESTED: 42</span>
                        </div>
                    </div>
                    <!-- BOTTOM-RIGHT: Real-time Training Logs & Trace Console -->
                    <div class="bg-surface-container p-space-md rounded-xl flex flex-col shadow-md">
                        <div class="flex items-center justify-between pb-space-sm mb-space-sm bg-surface-container-low/40 p-2.5 rounded-lg">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-outline text-lg">terminal</span>
                                <div class="flex flex-col">
                                    <span class="font-headline-md text-title-sm text-on-surface font-semibold">Execution Trace & Convergence Log</span>
                                    <span class="font-code-sm text-code-sm text-outline font-mono">SOLVER: L-BFGS · ITER: 184/500</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                                <span class="font-mono text-code-sm text-primary font-semibold">COMPLETED</span>
                            </div>
                        </div>
                        <!-- Dark Terminal Window -->
                        <div class="flex-1 bg-surface-container-lowest rounded-lg p-3 font-mono text-code-sm text-on-surface-variant flex flex-col justify-between overflow-hidden shadow-inner">
                            <div class="space-y-1.5 overflow-y-auto max-h-48 pr-1">
                                <div class="text-outline"><span class="text-tertiary">[00:00.012]</span> INIT: Optimizer=L-BFGS max_iter=500 tol=1e-4 fit_intercept=true</div>
                                <div class="text-outline"><span class="text-tertiary">[00:00.419]</span> ALLOC: 96,000 samples x 42 features (float64) ~ 32.2 MB in RAM</div>
                                <div><span class="text-outline">[00:01.120]</span> Epoch 001/020 | Loss: 0.69315 | GradNorm: 4.821e-01 | Step: 1.000</div>
                                <div><span class="text-outline">[00:01.984]</span> Epoch 005/020 | Loss: 0.54291 | GradNorm: 1.402e-01 | Memory: 412 MB</div>
                                <div><span class="text-outline">[00:02.810]</span> Epoch 010/020 | Loss: 0.46820 | GradNorm: 6.812e-02 | Delta: -0.012</div>
                                <div><span class="text-outline">[00:03.541]</span> Epoch 015/020 | Loss: 0.42190 | GradNorm: 2.115e-02 | Delta: -0.003</div>
                                <div class="text-secondary"><span class="text-tertiary">[00:04.090]</span> Epoch 020/020 | Loss: 0.41042 | GradNorm: 9.871e-04 | CONVERGED</div>
                                <div class="text-primary font-semibold"><span class="text-tertiary">[00:04.180]</span> SUCCESS: Convergence criteria reached at iteration 184 (tol < 1e-4)</div>
                                        <div class="text-tertiary font-bold"><span class="text-tertiary">[00:04.182]</span> EVAL: Validation F1: 0.7100 | Precision: 0.7420 | Recall: 0.6910</div>
                                </div>
                                <div class="pt-2 mt-2 border-t border-outline-variant/30 flex items-center justify-between text-outline text-[11px]">
                                    <span>RAM ALLOC: 418.2 MB PEAK</span>
                                    <span>GPU DEDICATED: N/A (CPU-NUMPY)</span>
                                    <span class="text-on-surface font-bold">EXIT CODE: 0</span>
                                </div>
                            </div>
                            <div class="mt-2 flex items-center justify-between text-code-sm font-mono text-outline px-1">
                                <span>CHECKPOINT: s3://vostokpribor/runs/exp-024-01/weights.bin</span>
                                <button class="hover:text-tertiary transition-colors flex items-center gap-1">
                                    <span class="material-symbols-outlined text-sm">download</span> DUMP RAW LOGS
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Operational Footer Action Console -->
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-space-md p-space-md bg-surface-container-low rounded-xl shadow-lg mt-space-xs">
                        <div class="flex items-center gap-space-sm text-code-sm font-mono text-outline">
                            <span class="material-symbols-outlined text-tertiary text-lg">info</span>
                            <span>ACTION RAIL: Experiments are immutable. Changes require creating a new run ticket.</span>
                        </div>
                        <div class="flex flex-wrap items-center gap-space-sm w-full sm:w-auto justify-end">
                            <!-- Secondary Action: Compare -->
                            <button class="flex items-center gap-2 px-space-md h-10 rounded-lg bg-surface-container-high text-on-surface font-label-sm text-label-sm uppercase hover:bg-surface-variant transition-colors shadow-sm">
                                <span class="material-symbols-outlined text-sm">compare_arrows</span>
                                <span>Compare with other runs</span>
                            </button>
                            <!-- Primary Action: Clone to New Experiment -->
                            <button class="flex items-center gap-2 px-space-md h-10 rounded-lg bg-primary-container text-primary font-label-sm text-label-sm uppercase hover:bg-surface-container-highest transition-colors shadow-sm font-semibold">
                                <span class="material-symbols-outlined text-sm">content_copy</span>
                                <span>Clone to New Experiment</span>
                            </button>
                            <!-- Disabled Action with Tooltip: Register Model -->
                            <div class="relative group">
                                <button class="flex items-center gap-2 px-space-md h-10 rounded-lg bg-surface-container-highest/40 text-outline cursor-not-allowed font-label-sm text-label-sm uppercase shadow-none opacity-60" disabled="">
                                    <span class="material-symbols-outlined text-sm">block</span>
                                    <span>Register Model to SYS-AI-04</span>
                                </button>
                                <!-- Floating Precision Industrial Tooltip -->
                                <div class="absolute bottom-full right-0 mb-2 hidden group-hover:flex flex-col bg-surface-container-lowest text-on-surface p-2.5 rounded-lg shadow-2xl z-50 w-72 pointer-events-none">
                                    <div class="flex items-center gap-1.5 text-error font-mono text-code-sm font-bold mb-1">
                                        <span class="material-symbols-outlined text-sm">error</span>
                                        <span>REGISTRATION GATE BLOCKED</span>
                                    </div>
                                    <p class="font-mono text-code-sm text-outline leading-tight">
                                        F1-Score <span class="text-tertiary font-bold">0.7100</span> does not satisfy production promotion criteria (<span class="text-on-surface font-bold">≥ 0.8000</span>).
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    // Tab micro-interaction for Operating Curves
                    const tabRoc = document.getElementById('tab-roc');
                    const tabPr = document.getElementById('tab-pr');

                    if (tabRoc && tabPr) {
                        tabPr.addEventListener('click', () => {
                            tabPr.classList.remove('text-outline');
                            tabPr.classList.add('bg-surface-container-high', 'text-on-surface', 'font-bold', 'shadow-sm');
                            tabRoc.classList.remove('bg-surface-container-high', 'text-on-surface', 'font-bold', 'shadow-sm');
                            tabRoc.classList.add('text-outline');
                        });

                        tabRoc.addEventListener('click', () => {
                            tabRoc.classList.remove('text-outline');
                            tabRoc.classList.add('bg-surface-container-high', 'text-on-surface', 'font-bold', 'shadow-sm');
                            tabPr.classList.remove('bg-surface-container-high', 'text-on-surface', 'font-bold', 'shadow-sm');
                            tabPr.classList.add('text-outline');
                        });
                    }
                </script>
        </main>
    </div>
</body>

</html>