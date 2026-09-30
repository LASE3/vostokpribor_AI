<!DOCTYPE html>

<html class="dark" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="web_dashboard" name="shell-type" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&amp;family=Inter:wght@400;500;600;700&amp;family=Space+Mono:wght@400;700&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
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

        .grid-matrix {
            background-image: radial-gradient(rgba(27, 58, 92, 0.3) 1px, transparent 1px);
            background-size: 20px 20px;
        }
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "on-secondary-fixed": "#001c38",
                        "on-tertiary": "#462b00",
                        "secondary-fixed-dim": "#abc9f2",
                        "outline-variant": "#43474c",
                        "on-secondary-fixed-variant": "#2b486b",
                        "tertiary-container": "#331e00",
                        "surface-container-high": "#132b45",
                        "inverse-surface": "#d3e4ff",
                        "error-container": "#93000a",
                        "primary-fixed": "#d0e4ff",
                        "outline": "#8e9197",
                        "surface-container-low": "#021c36",
                        "on-tertiary-fixed-variant": "#643f00",
                        "tertiary": "#ffb956",
                        "primary-fixed-dim": "#b4c8e3",
                        "inverse-primary": "#4d6077",
                        "error": "#ffb4ab",
                        "primary": "#b4c8e3",
                        "secondary": "#abc9f2",
                        "secondary-container": "#2b486b",
                        "on-tertiary-container": "#bb7d16",
                        "tertiary-fixed": "#ffddb5",
                        "on-background": "#d3e4ff",
                        "on-error": "#690005",
                        "on-surface": "#d3e4ff",
                        "on-primary": "#1e3246",
                        "surface-variant": "#1f3651",
                        "on-secondary": "#113253",
                        "on-surface-variant": "#c4c6cd",
                        "inverse-on-surface": "#1a314c",
                        "surface-container-highest": "#1f3651",
                        "on-primary-fixed-variant": "#35485e",
                        "primary-container": "#0f2438",
                        "surface-container": "#06203a",
                        "on-tertiary-fixed": "#2a1800",
                        "secondary-fixed": "#d2e4ff",
                        "tertiary-fixed-dim": "#ffb956",
                        "surface-tint": "#b4c8e3",
                        "on-primary-fixed": "#071d30",
                        "on-primary-container": "#788ca4",
                        "on-error-container": "#ffdad6",
                        "surface-container-lowest": "#000f21",
                        "background": "#00142a",
                        "surface-dim": "#00142a",
                        "surface-bright": "#243a56",
                        "on-secondary-container": "#9ab7e0",
                        "surface": "#00142a"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "gutter": "1rem",
                        "margin-desktop": "2rem",
                        "space-xs": "0.25rem",
                        "margin": "1rem",
                        "space-sm": "0.5rem",
                        "gutter-desktop": "1.5rem",
                        "space-xl": "2rem",
                        "space-lg": "1.5rem",
                        "space-md": "1rem"
                    },
                    "fontFamily": {
                        "body-md": [
                            "Inter"
                        ],
                        "label-technical": [
                            "IBM Plex Sans"
                        ],
                        "body-sm": [
                            "Inter"
                        ],
                        "headline-xl": [
                            "IBM Plex Sans"
                        ],
                        "metric-sm": [
                            "Space Mono"
                        ],
                        "headline-xl-mobile": [
                            "IBM Plex Sans"
                        ],
                        "body-lg": [
                            "Inter"
                        ],
                        "headline-md": [
                            "IBM Plex Sans"
                        ],
                        "headline-lg": [
                            "IBM Plex Sans"
                        ],
                        "label-code": [
                            "Space Mono"
                        ],
                        "headline-lg-mobile": [
                            "IBM Plex Sans"
                        ],
                        "metric-display": [
                            "Space Mono"
                        ]
                    },
                    "fontSize": {
                        "body-md": [
                            "14px",
                            {
                                "lineHeight": "20px",
                                "letterSpacing": "0em",
                                "fontWeight": "400"
                            }
                        ],
                        "label-technical": [
                            "11px",
                            {
                                "lineHeight": "14px",
                                "letterSpacing": "0.08em",
                                "fontWeight": "600"
                            }
                        ],
                        "body-sm": [
                            "12px",
                            {
                                "lineHeight": "18px",
                                "letterSpacing": "0.01em",
                                "fontWeight": "400"
                            }
                        ],
                        "headline-xl": [
                            "36px",
                            {
                                "lineHeight": "44px",
                                "letterSpacing": "-0.02em",
                                "fontWeight": "700"
                            }
                        ],
                        "metric-sm": [
                            "18px",
                            {
                                "lineHeight": "22px",
                                "letterSpacing": "-0.01em",
                                "fontWeight": "700"
                            }
                        ],
                        "headline-xl-mobile": [
                            "28px",
                            {
                                "lineHeight": "36px",
                                "letterSpacing": "-0.01em",
                                "fontWeight": "700"
                            }
                        ],
                        "body-lg": [
                            "16px",
                            {
                                "lineHeight": "24px",
                                "letterSpacing": "0em",
                                "fontWeight": "500"
                            }
                        ],
                        "headline-md": [
                            "20px",
                            {
                                "lineHeight": "28px",
                                "letterSpacing": "0em",
                                "fontWeight": "600"
                            }
                        ],
                        "headline-lg": [
                            "28px",
                            {
                                "lineHeight": "36px",
                                "letterSpacing": "-0.01em",
                                "fontWeight": "600"
                            }
                        ],
                        "label-code": [
                            "12px",
                            {
                                "lineHeight": "16px",
                                "letterSpacing": "0.02em",
                                "fontWeight": "500"
                            }
                        ],
                        "headline-lg-mobile": [
                            "22px",
                            {
                                "lineHeight": "30px",
                                "letterSpacing": "0em",
                                "fontWeight": "600"
                            }
                        ],
                        "metric-display": [
                            "32px",
                            {
                                "lineHeight": "36px",
                                "letterSpacing": "-0.03em",
                                "fontWeight": "700"
                            }
                        ]
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-background font-body-md text-body-md text-on-surface grid-matrix min-h-screen">
    <aside class="fixed left-0 top-0 h-full w-72 bg-surface-container-lowest z-50 flex flex-col justify-between shadow-[0_1px_8px_rgba(0,0,0,0.4)]">
        <div class="flex flex-col">
            <div class="h-16 px-space-md flex items-center justify-between bg-surface-container-low">
                <div class="flex items-center gap-space-sm"><img alt="VOSTOKPRIBOR AI SOC Logo" class="h-8 w-auto object-contain" src="https://lh3.googleusercontent.com/aida/AEtjO1W44MsHok8wFPOND_GUndULDEb9Wlf7x1VGBOEHm0xm1lbWb8oILr8x1T0OdWrOIdez65-cNTVESF7hxNycCR7uZXrC0rS38wfBjIQXlirTeA_MPjISLjdhKsmkws1_2pP40drLel5PEenk17276tjZx9wXrjxZpqgvl46nr2waCD3OgD38I_Y4q0WtMQIoITZ9yiEzvmB3XHJyzKp-2d2yaoZIxjkzYqtwUyys6MluIuULxUsSqrrQHmk" />
                    <div class="flex flex-col"><span class="font-headline-md text-headline-md tracking-tight text-primary leading-none">VOSTOKPRIBOR</span><span class="font-label-technical text-label-technical text-tertiary tracking-widest mt-space-xs uppercase">AI Mission Control</span></div>
                </div>
            </div>
            <div class="px-space-md py-space-sm bg-surface-container-high/40 flex items-center justify-between"><span class="font-label-technical text-label-technical text-on-surface-variant uppercase tracking-wider">System Pipelines</span><span class="font-label-code text-label-code text-secondary">NODE // 05</span></div>
            <nav class="flex flex-col px-space-xs py-space-sm gap-space-xs" data-active-classes="bg-primary-container text-on-surface border-l-2 border-tertiary"><a class="flex items-center justify-between px-space-md py-space-sm rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="project-hub" href="#"><span class="font-label-technical text-label-technical">SYS-AI-01: Objectives Hub</span><span class="font-label-code text-label-code text-outline">v1.2</span></a><a class="flex items-center justify-between px-space-md py-space-sm rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="data-lake" href="#"><span class="font-label-technical text-label-technical">SYS-AI-02: Data Lake Lakeflow</span><span class="font-label-code text-label-code text-outline">4.8TB</span></a><a class="flex items-center justify-between px-space-md py-space-sm rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="model-workbench" href="#"><span class="font-label-technical text-label-technical">SYS-AI-03: Model Workbench</span><span class="font-label-code text-label-code text-outline">READY</span></a><a class="flex items-center justify-between px-space-md py-space-sm rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="model-registry" href="#"><span class="font-label-technical text-label-technical">SYS-AI-04: Registry &amp; CI/CD</span><span class="font-label-code text-label-code text-outline">PROD</span></a><a class="flex items-center justify-between px-space-md py-space-sm rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="soc-overview-fleet-telemetry" href="#">
                    <div class="flex items-center gap-space-sm"><span class="w-2 h-2 rounded-full bg-tertiary animate-pulse"></span><span class="font-label-technical text-label-technical font-semibold text-primary">SYS-AI-05: AI SOC</span></div><span class="px-space-xs py-0.5 rounded text-[10px] font-metric-sm font-bold bg-error-container text-on-error-container uppercase tracking-wider">CRIT</span>
                </a></nav>
        </div>
        <div class="flex flex-col bg-surface-container-low p-space-md gap-space-sm">
            <div class="flex items-center justify-between bg-surface-container-lowest px-space-sm py-space-xs rounded">
                <div class="flex items-center gap-space-xs"><span class="w-1.5 h-1.5 rounded-full bg-secondary-fixed"></span><span class="font-label-code text-label-code text-on-surface-variant">UPLINK NOMINAL</span></div><span class="font-label-code text-label-code text-tertiary">12ms</span>
            </div>
            <div class="flex items-center justify-between font-label-code text-label-code text-on-surface-variant pt-space-xs"><a class="hover:text-primary transition-colors" data-path="system-docs" href="#">SYSTEM_DOCS.MD</a><a class="hover:text-primary transition-colors" data-path="api-terminal" href="#">API_TERM://05</a></div>
        </div>
    </aside>
    <div class="pl-72">
        <header class="fixed top-0 left-72 right-0 h-28 bg-surface-container-lowest/90 backdrop-blur-xl z-40 flex flex-col justify-between shadow-[0_1px_8px_rgba(0,0,0,0.5)]">
            <div class="h-14 px-gutter-desktop flex items-center justify-between gap-space-md">
                <div class="flex items-center gap-space-md flex-1">
                    <div class="relative flex items-center max-w-md w-full"><span class="material-symbols-outlined text-outline absolute left-space-sm text-[18px]">filter_center_focus</span><input class="w-full bg-surface-container-low text-on-surface font-label-code text-label-code pl-9 pr-14 py-space-xs rounded outline-none focus:ring-1 focus:ring-secondary text-ellipsis" placeholder="Filter models, incident IDs, or drift metrics... /" type="text" /><span class="absolute right-space-sm font-label-code text-[10px] text-outline bg-surface-container-high px-1 rounded">CTRL+K</span></div>
                    <div class="hidden xl:flex items-center gap-space-xs bg-error-container/30 px-space-sm py-space-xs rounded"><span class="w-2 h-2 rounded-full bg-error animate-ping"></span><span class="font-label-code text-label-code text-error tracking-tight font-semibold">INC-4092 CRITICAL: churn_rf_v2 (F1 0.87 -&gt; 0.61 &lt; 0.80 SLA)</span></div>
                </div>
                <div class="flex items-center gap-space-md">
                    <div class="hidden md:flex items-center bg-surface-container-low px-space-sm py-1 rounded text-on-surface-variant gap-space-xs"><span class="font-label-technical text-label-technical text-outline uppercase">Role:</span><span class="font-label-code text-label-code text-primary font-bold">Intern AI Eng · L3</span></div><button class="font-label-code text-label-code px-space-sm py-1 bg-surface-container-high text-on-surface-variant rounded hover:text-on-surface">EN / AR</button>
                    <div class="relative flex items-center justify-center p-1.5 rounded bg-surface-container-low text-on-surface-variant hover:text-on-surface"><span class="material-symbols-outlined text-[20px]">notifications</span><span class="absolute -top-1 -right-1 font-label-code text-[10px] w-4 h-4 bg-tertiary text-on-tertiary font-bold rounded-full flex items-center justify-center">3</span></div>
                    <div class="flex items-center gap-space-sm pl-space-xs">
                        <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center"><span class="material-symbols-outlined text-on-primary text-[18px]">person</span></div>
                        <div class="hidden lg:flex flex-col"><span class="font-label-code text-label-code text-on-surface leading-tight">Alexei V.</span><span class="font-label-technical text-[10px] text-tertiary leading-none uppercase">ON-DUTY</span></div>
                    </div>
                </div>
            </div>
            <div class="h-14 px-gutter-desktop bg-surface-container flex items-center justify-between overflow-x-auto gap-space-sm">
                <div class="flex items-center gap-1.5 shrink-0"><span class="font-label-technical text-[10px] text-outline uppercase tracking-widest mr-1">ML Ops Loop:</span>
                    <div class="flex items-center gap-1 text-[10px] font-label-code text-outline"><span class="px-1.5 py-0.5 rounded bg-surface-container-low text-outline">01.PRB</span><span class="px-1.5 py-0.5 rounded bg-surface-container-low text-outline">02.DAT</span><span class="px-1.5 py-0.5 rounded bg-surface-container-low text-outline">03.ING</span><span class="px-1.5 py-0.5 rounded bg-surface-container-low text-outline">04.EDA</span><span class="px-1.5 py-0.5 rounded bg-surface-container-low text-outline">05.FTR</span><span class="px-1.5 py-0.5 rounded bg-surface-container-low text-outline">06.TRN</span><span class="px-1.5 py-0.5 rounded bg-surface-container-low text-outline">07.TUN</span><span class="px-1.5 py-0.5 rounded bg-surface-container-low text-outline">08.VAL</span><span class="px-1.5 py-0.5 rounded bg-surface-container-low text-outline">09.REG</span><span class="px-1.5 py-0.5 rounded bg-surface-container-low text-outline">10.PKG</span><span class="px-1.5 py-0.5 rounded bg-surface-container-low text-outline">11.DEP</span></div><span class="material-symbols-outlined text-outline text-[14px] mx-1">arrow_forward</span>
                    <div class="flex items-center gap-1.5 text-[10px] font-label-code"><span class="px-2 py-0.5 rounded bg-surface-container-highest text-secondary font-bold flex items-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>12.TELEMETRY</span><span class="px-2 py-0.5 rounded bg-tertiary-container text-tertiary font-bold flex items-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-tertiary animate-pulse"></span>13.DRIFT &amp; INCIDENT</span><span class="px-2 py-0.5 rounded bg-surface-container-highest text-primary font-bold">14.RETRAIN LOOP</span></div>
                </div>
                <nav class="flex items-center gap-space-md shrink-0 h-full" data-active-classes="text-tertiary border-b-2 border-tertiary font-semibold"><a class="text-on-surface-variant hover:text-on-surface h-full flex items-center font-label-code text-label-code transition-colors" data-path="soc-overview-fleet-telemetry" href="#">Fleet Overview</a><a class="text-on-surface-variant hover:text-on-surface h-full flex items-center font-label-code text-label-code transition-colors" data-path="alerts-center-incident-triage" href="#">Alerts Center (3)</a><a class="text-on-surface-variant hover:text-on-surface h-full flex items-center font-label-code text-label-code transition-colors" data-path="model-monitoring-detail" href="#">Model Monitoring</a><a aria-current="page" class="h-full flex items-center transition-colors text-tertiary border-b-2 border-tertiary font-semibold" data-path="drift-investigation-workspace" href="#">Drift Investigation</a><a class="text-on-surface-variant hover:text-on-surface h-full flex items-center font-label-code text-label-code transition-colors" data-path="active-incident" href="#">INC-4092 War Room</a><a class="text-on-surface-variant hover:text-on-surface h-full flex items-center font-label-code text-label-code transition-colors" data-path="alert-rules-config" href="#">Config</a></nav>
            </div>
        </header>
        <main class="relative pt-28 w-full p-gutter-desktop bg-transparent">
            <div class="flex flex-col w-full gap-space-lg">
                <!-- TOP WORKSPACE CONTEXT & DATASET SLICER -->
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-space-md bg-surface-container-low p-space-md rounded-lg shadow-sm">
                    <div class="flex flex-col gap-space-xs">
                        <div class="flex items-center gap-space-sm flex-wrap">
                            <span class="font-label-technical text-label-technical bg-surface-container-highest text-secondary px-space-sm py-0.5 rounded tracking-widest uppercase">
                                DIAGNOSTIC ENGINE // EVIDENTLY v0.4.18
                            </span>
                            <span class="font-label-code text-label-code text-outline">WORKSPACE://DRIFT_INSPECTION_RUN_8842</span>
                            <span class="inline-flex items-center gap-1 font-label-code text-[11px] text-tertiary bg-tertiary-container/40 px-2 py-0.5 rounded">
                                <span class="w-1.5 h-1.5 rounded-full bg-tertiary animate-pulse"></span> EVALUATION RUNNING: REAL-TIME
                            </span>
                        </div>
                        <div class="flex items-baseline gap-space-sm flex-wrap">
                            <h1 class="font-headline-lg text-headline-lg text-primary tracking-tight">
                                Drift Investigation Workspace
                            </h1>
                            <span class="font-metric-sm text-metric-sm text-on-surface-variant font-normal">
                                MODEL: <span class="text-on-surface font-bold">churn_rf_v2</span> <span class="text-tertiary text-body-sm font-label-code font-bold">v2.4.1-prod</span>
                            </span>
                        </div>
                    </div>
                    <!-- Telemetry Datasets Alignment Pill Box -->
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-space-sm">
                        <div class="bg-surface-container-lowest p-space-sm rounded flex flex-col gap-0.5 min-w-[210px]">
                            <div class="flex items-center justify-between">
                                <span class="font-label-technical text-[10px] text-outline uppercase tracking-wider">REFERENCE (BASELINE)</span>
                                <span class="font-label-code text-[10px] text-secondary">GOLDEN SLICE</span>
                            </div>
                            <span class="font-label-code text-label-code text-primary font-bold truncate">train_v2.4_golden_reference</span>
                            <span class="font-label-code text-[11px] text-on-surface-variant">N = 120,000 | 2024-Q3 STATIC</span>
                        </div>
                        <div class="flex items-center justify-center text-outline">
                            <span class="material-symbols-outlined text-secondary">compare_arrows</span>
                        </div>
                        <div class="bg-surface-container-lowest p-space-sm rounded flex flex-col gap-0.5 min-w-[210px]">
                            <div class="flex items-center justify-between">
                                <span class="font-label-technical text-[10px] text-outline uppercase tracking-wider">CURRENT (EVALUATION)</span>
                                <span class="font-label-code text-[10px] text-error font-bold">LIVE STREAM</span>
                            </div>
                            <span class="font-label-code text-label-code text-error font-bold truncate">prod_last_6h_live</span>
                            <span class="font-label-code text-[11px] text-on-surface-variant">N = 8,520 | CRM-FEED-05</span>
                        </div>
                        <button class="bg-primary-container hover:bg-surface-container-high text-primary px-space-md py-space-sm rounded flex items-center justify-center gap-space-xs font-label-technical text-label-technical transition-colors" id="btnRefreshMatrix">
                            <span class="material-symbols-outlined text-[18px]">sync</span>
                            <span>RESAMPLE</span>
                        </button>
                    </div>
                </div>
                <!-- BENTO SUMMARY ROW (FACTUAL OBSERVATIONS ONLY) -->
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-space-md">
                    <!-- Card 1: Dataset Drift -->
                    <div class="bg-surface-container-low p-space-md rounded-lg flex flex-col justify-between gap-space-sm">
                        <div class="flex items-center justify-between">
                            <span class="font-label-technical text-label-technical text-on-surface-variant uppercase tracking-wider">Dataset Drift Status</span>
                            <span class="px-space-xs py-0.5 rounded bg-tertiary-container text-tertiary font-label-code text-[10px] font-bold">
                                DRIFT DETECTED
                            </span>
                        </div>
                        <div>
                            <div class="flex items-baseline gap-space-xs">
                                <span class="font-metric-display text-metric-display text-tertiary font-bold">22.2%</span>
                                <span class="font-label-code text-body-sm text-outline">drifted features</span>
                            </div>
                            <div class="w-full bg-surface-container-highest h-1.5 rounded-full overflow-hidden mt-space-xs">
                                <div class="bg-tertiary h-full rounded-full" style="width: 22.2%;"></div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between font-label-code text-body-sm text-on-surface-variant pt-space-xs bg-surface-container/50 px-space-xs rounded">
                            <span>Observed: <strong class="text-tertiary">4 of 18</strong></span>
                            <span>Configured Threshold: <strong class="text-on-surface">15.0%</strong></span>
                        </div>
                    </div>
                    <!-- Card 2: Prediction Drift / Target -->
                    <div class="bg-surface-container-low p-space-md rounded-lg flex flex-col justify-between gap-space-sm">
                        <div class="flex items-center justify-between">
                            <span class="font-label-technical text-label-technical text-on-surface-variant uppercase tracking-wider">Prediction (Target) Drift</span>
                            <span class="px-space-xs py-0.5 rounded bg-error-container text-error font-label-code text-[10px] font-bold">
                                CRITICAL ALERT
                            </span>
                        </div>
                        <div>
                            <div class="flex items-baseline gap-space-xs">
                                <span class="font-metric-display text-metric-display text-error font-bold">PSI 0.312</span>
                                <span class="font-label-code text-body-sm text-outline">P-Val: 0.0001</span>
                            </div>
                            <div class="w-full bg-surface-container-highest h-1.5 rounded-full overflow-hidden mt-space-xs">
                                <div class="bg-error h-full rounded-full" style="width: 82%;"></div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between font-label-code text-body-sm text-on-surface-variant pt-space-xs bg-surface-container/50 px-space-xs rounded">
                            <span>Stability: <strong class="text-error">High Instability</strong></span>
                            <span>Threshold: <strong class="text-on-surface">PSI &gt; 0.25</strong></span>
                        </div>
                    </div>
                    <!-- Card 3: Data Quality & Rules Violations -->
                    <div class="bg-surface-container-low p-space-md rounded-lg flex flex-col justify-between gap-space-sm">
                        <div class="flex items-center justify-between">
                            <span class="font-label-technical text-label-technical text-on-surface-variant uppercase tracking-wider">Data Quality Assertions</span>
                            <span class="px-space-xs py-0.5 rounded bg-tertiary-container text-tertiary font-label-code text-[10px] font-bold">
                                1 ANOMALY
                            </span>
                        </div>
                        <div>
                            <div class="flex items-baseline gap-space-xs">
                                <span class="font-metric-display text-metric-display text-primary font-bold">94.4%</span>
                                <span class="font-label-code text-body-sm text-outline">rules passing</span>
                            </div>
                            <div class="w-full bg-surface-container-highest h-1.5 rounded-full overflow-hidden mt-space-xs">
                                <div class="bg-primary h-full rounded-full" style="width: 94.4%;"></div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between font-label-code text-body-sm text-on-surface-variant pt-space-xs bg-surface-container/50 px-space-xs rounded">
                            <span>Failed Checks: <strong class="text-tertiary">1 / 18 checks</strong></span>
                            <span>Missing Rate: <strong class="text-secondary">0.00% Nulls</strong></span>
                        </div>
                    </div>
                    <!-- Card 4: Statistical Engine Configuration -->
                    <div class="bg-surface-container-low p-space-md rounded-lg flex flex-col justify-between gap-space-sm">
                        <div class="flex items-center justify-between">
                            <span class="font-label-technical text-label-technical text-on-surface-variant uppercase tracking-wider">Statistical Calibrations</span>
                            <span class="px-space-xs py-0.5 rounded bg-surface-container-high text-on-surface-variant font-label-code text-[10px]">
                                STANDARD STRICT
                            </span>
                        </div>
                        <div class="space-y-1">
                            <div class="flex items-center justify-between font-label-code text-body-sm">
                                <span class="text-on-surface-variant">Numerical Test:</span>
                                <span class="text-primary font-semibold">Kolmogorov-Smirnov (alpha=0.05)</span>
                            </div>
                            <div class="flex items-center justify-between font-label-code text-body-sm">
                                <span class="text-on-surface-variant">Categorical Test:</span>
                                <span class="text-primary font-semibold">Chi-Sq &amp; Wasserstein (alpha=0.05)</span>
                            </div>
                            <div class="flex items-center justify-between font-label-code text-body-sm">
                                <span class="text-on-surface-variant">Output Target Test:</span>
                                <span class="text-primary font-semibold">Population Stability Index (PSI)</span>
                            </div>
                        </div>
                        <div class="font-label-technical text-[10px] text-outline text-right uppercase tracking-wider pt-space-xs">
                            Evidently Spec Hash: #7f9a80e1
                        </div>
                    </div>
                </div>
                <!-- INTERACTIVE DEEP DIVE INSPECTOR (CENTRAL VISUAL EMPHASIS) -->
                <div class="bg-surface-container-low rounded-lg p-space-md flex flex-col gap-space-md shadow-sm">
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-space-sm pb-space-xs bg-surface-container-low">
                        <div class="flex items-center gap-space-sm">
                            <div class="p-2 rounded bg-tertiary-container/60 text-tertiary flex items-center justify-center">
                                <span class="material-symbols-outlined text-[20px]">troubleshoot</span>
                            </div>
                            <div>
                                <div class="flex items-center gap-space-sm">
                                    <span class="font-label-technical text-label-technical text-outline uppercase tracking-wider">DEEP-DIVE INSPECTION TARGET</span>
                                    <span class="px-1.5 py-0.5 rounded bg-error-container text-error text-[10px] font-label-code font-bold">ANOMALY SIGNIFICANCE: HIGHEST</span>
                                </div>
                                <h2 class="font-headline-md text-headline-md text-primary">
                                    Feature Distribution Comparison: <span class="text-tertiary font-label-code underline decoration-tertiary/40">account_age_months</span>
                                </h2>
                            </div>
                        </div>
                        <!-- Quick stats bar -->
                        <div class="flex items-center gap-space-md flex-wrap font-label-code text-body-sm bg-surface-container-lowest px-space-md py-space-sm rounded">
                            <div>
                                <span class="text-outline">Type:</span> <span class="text-on-surface font-semibold">Integer64</span>
                            </div>
                            <div>
                                <span class="text-outline">KS Statistic:</span> <span class="text-error font-bold">0.4218</span>
                            </div>
                            <div>
                                <span class="text-outline">p-value:</span> <span class="text-error font-bold">0.000084 (&lt; 0.05)</span>
                            </div>
                            <div>
                                <span class="text-outline">State:</span> <span class="text-error font-bold">REJECT H0 (DRIFTED)</span>
                            </div>
                        </div>
                    </div>
                    <!-- Split Visual: Histograms vs CDF Matrix -->
                    <div class="grid grid-cols-1 xl:grid-cols-12 gap-space-md">
                        <!-- Left Column: Dual Histogram Visualization (8 Cols) -->
                        <div class="xl:col-span-8 bg-surface-container-lowest p-space-md rounded flex flex-col gap-space-sm">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-space-md">
                                    <span class="font-label-technical text-label-technical text-on-surface uppercase tracking-wider">Probability Density / Bin Frequency</span>
                                    <div class="flex items-center gap-space-sm text-body-sm font-label-code">
                                        <span class="inline-flex items-center gap-1.5 text-secondary">
                                            <span class="w-3 h-3 rounded-sm bg-secondary opacity-75 inline-block"></span>
                                            Reference (N=120k)
                                        </span>
                                        <span class="inline-flex items-center gap-1.5 text-tertiary">
                                            <span class="w-3 h-3 rounded-sm bg-tertiary inline-block"></span>
                                            Current Window (N=8.52k)
                                        </span>
                                    </div>
                                </div>
                                <span class="font-label-code text-[11px] text-outline">BINS: 24 (Step: 3 months)</span>
                            </div>
                            <!-- Precise SVG Dual Histogram Chart -->
                            <div class="relative w-full h-64 bg-surface-container-high/20 rounded p-2 flex flex-col justify-end">
                                <svg class="w-full h-full overflow-visible" preserveaspectratio="none" viewbox="0 0 720 220">
                                    <!-- Gridlines -->
                                    <line class="text-outline-variant/30" stroke="currentColor" stroke-dasharray="2 2" stroke-width="1" x1="0" x2="720" y1="20" y2="20"></line>
                                    <line class="text-outline-variant/30" stroke="currentColor" stroke-dasharray="2 2" stroke-width="1" x1="0" x2="720" y1="70" y2="70"></line>
                                    <line class="text-outline-variant/30" stroke="currentColor" stroke-dasharray="2 2" stroke-width="1" x1="0" x2="720" y1="120" y2="120"></line>
                                    <line class="text-outline-variant/30" stroke="currentColor" stroke-dasharray="2 2" stroke-width="1" x1="0" x2="720" y1="170" y2="170"></line>
                                    <line class="text-outline" stroke="currentColor" stroke-width="1" x1="0" x2="720" y1="200" y2="200"></line>
                                    <!-- Y Axis Label -->
                                    <text class="text-outline font-label-code text-[10px]" fill="currentColor" x="8" y="16">Frequency Mass (%)</text>
                                    <text class="text-outline font-label-code text-[10px]" fill="currentColor" x="8" y="74">50%</text>
                                    <text class="text-outline font-label-code text-[10px]" fill="currentColor" x="8" y="124">25%</text>
                                    <text class="text-outline font-label-code text-[10px]" fill="currentColor" x="8" y="174">5%</text>
                                    <!-- Reference Distribution (Muted Steel Blue curve & bars, normal shape peak at ~30 months) -->
                                    <!-- Bin 0-3mo -->
                                    <rect class="text-secondary/40" fill="currentColor" height="20" width="22" x="50" y="180"></rect>
                                    <!-- Bin 4-6mo -->
                                    <rect class="text-secondary/40" fill="currentColor" height="26" width="22" x="76" y="174"></rect>
                                    <!-- Bin 7-9mo -->
                                    <rect class="text-secondary/40" fill="currentColor" height="34" width="22" x="102" y="166"></rect>
                                    <!-- Bin 10-12mo -->
                                    <rect class="text-secondary/40" fill="currentColor" height="46" width="22" x="128" y="154"></rect>
                                    <!-- Bin 13-15mo -->
                                    <rect class="text-secondary/40" fill="currentColor" height="58" width="22" x="154" y="142"></rect>
                                    <!-- Bin 16-18mo -->
                                    <rect class="text-secondary/40" fill="currentColor" height="68" width="22" x="180" y="132"></rect>
                                    <!-- Bin 19-21mo -->
                                    <rect class="text-secondary/40" fill="currentColor" height="78" width="22" x="206" y="122"></rect>
                                    <!-- Bin 22-24mo (Center Ref Peak) -->
                                    <rect class="text-secondary/50" fill="currentColor" height="88" width="22" x="232" y="112"></rect>
                                    <!-- Bin 25-27mo -->
                                    <rect class="text-secondary/50" fill="currentColor" height="92" width="22" x="258" y="108"></rect>
                                    <!-- Bin 28-30mo (Ref Peak) -->
                                    <rect class="text-secondary/60" fill="currentColor" height="95" width="22" x="284" y="105"></rect>
                                    <!-- Bin 31-33mo -->
                                    <rect class="text-secondary/50" fill="currentColor" height="90" width="22" x="310" y="110"></rect>
                                    <!-- Bin 34-36mo -->
                                    <rect class="text-secondary/50" fill="currentColor" height="80" width="22" x="336" y="120"></rect>
                                    <!-- Bin 37-39mo -->
                                    <rect class="text-secondary/40" fill="currentColor" height="70" width="22" x="362" y="130"></rect>
                                    <!-- Bin 40-42mo -->
                                    <rect class="text-secondary/40" fill="currentColor" height="56" width="22" x="388" y="144"></rect>
                                    <!-- Bin 43-45mo -->
                                    <rect class="text-secondary/40" fill="currentColor" height="44" width="22" x="414" y="156"></rect>
                                    <!-- Bin 46-48mo -->
                                    <rect class="text-secondary/40" fill="currentColor" height="32" width="22" x="440" y="168"></rect>
                                    <!-- Bin 49-51mo -->
                                    <rect class="text-secondary/40" fill="currentColor" height="22" width="22" x="466" y="178"></rect>
                                    <!-- Bin 52-54mo -->
                                    <rect class="text-secondary/40" fill="currentColor" height="14" width="22" x="492" y="186"></rect>
                                    <!-- Bin 55-57mo -->
                                    <rect class="text-secondary/40" fill="currentColor" height="8" width="22" x="518" y="192"></rect>
                                    <!-- Bin 58-60mo -->
                                    <rect class="text-secondary/40" fill="currentColor" height="5" width="22" x="544" y="195"></rect>
                                    <!-- Current Window Overlay: MASSIVE SPIKE AT 0 (78.4% of total records) -->
                                    <!-- Bin 0.0 Spike (Width 22, height almost 175 px) -->
                                    <rect class="text-tertiary" fill="currentColor" height="175" width="22" x="50" y="25"></rect>
                                    <!-- Tiny residual distribution on current window across the tail -->
                                    <rect class="text-tertiary/80" fill="currentColor" height="6" width="22" x="76" y="194"></rect>
                                    <rect class="text-tertiary/80" fill="currentColor" height="5" width="22" x="102" y="195"></rect>
                                    <rect class="text-tertiary/80" fill="currentColor" height="4" width="22" x="128" y="196"></rect>
                                    <rect class="text-tertiary/80" fill="currentColor" height="4" width="22" x="154" y="196"></rect>
                                    <rect class="text-tertiary/80" fill="currentColor" height="3" width="22" x="180" y="197"></rect>
                                    <rect class="text-tertiary/80" fill="currentColor" height="3" width="22" x="206" y="197"></rect>
                                    <rect class="text-tertiary/80" fill="currentColor" height="3" width="22" x="232" y="197"></rect>
                                    <rect class="text-tertiary/80" fill="currentColor" height="2" width="22" x="258" y="198"></rect>
                                    <rect class="text-tertiary/80" fill="currentColor" height="2" width="22" x="284" y="198"></rect>
                                    <rect class="text-tertiary/80" fill="currentColor" height="2" width="22" x="310" y="198"></rect>
                                    <!-- Highlight Anomaly Callout -->
                                    <circle class="fill-error" cx="61" cy="25" r="4"></circle>
                                    <line class="text-error" stroke="currentColor" stroke-width="1.5" x1="61" x2="120" y1="25" y2="45"></line>
                                    <rect class="text-surface-container-high" fill="currentColor" height="26" rx="3" width="168" x="120" y="32"></rect>
                                    <text class="text-error font-label-code text-[11px] font-bold" fill="currentColor" x="126" y="49">
                                        [OBSERVED]: 78.4% at val = 0.0
                                    </text>
                                    <!-- X Axis Marks -->
                                    <text class="text-tertiary font-label-code text-[10px] font-bold" fill="currentColor" x="50" y="215">0.0 mo</text>
                                    <text class="text-outline font-label-code text-[10px]" fill="currentColor" x="154" y="215">15.0</text>
                                    <text class="text-secondary font-label-code text-[10px]" fill="currentColor" x="284" y="215">28.4 (Ref Mean)</text>
                                    <text class="text-outline font-label-code text-[10px]" fill="currentColor" x="440" y="215">48.0</text>
                                    <text class="text-outline font-label-code text-[10px]" fill="currentColor" x="544" y="215">60.0+</text>
                                </svg>
                            </div>
                            <!-- Factual CDF Spark comparison -->
                            <div class="flex items-center justify-between text-body-sm font-label-code text-on-surface-variant pt-space-xs">
                                <div class="flex items-center gap-space-xs">
                                    <span class="material-symbols-outlined text-[16px] text-outline">query_stats</span>
                                    <span>Cumulative Distribution Function (CDF): <strong class="text-tertiary">Max Divergence D = 0.4218 at x = 0</strong></span>
                                </div>
                                <span class="text-outline font-label-code text-[11px]">Two-sample K-S Asymptotic p=8.4e-5</span>
                            </div>
                        </div>
                        <!-- Right Column: Statistical Table Breakdown & Quantiles (4 Cols) -->
                        <div class="xl:col-span-4 bg-surface-container-lowest p-space-md rounded flex flex-col justify-between gap-space-sm">
                            <div class="flex items-center justify-between pb-space-xs">
                                <span class="font-label-technical text-label-technical text-on-surface uppercase tracking-wider">Distribution Descriptives</span>
                                <span class="font-label-code text-[10px] text-outline">ST-01 NUMERIC</span>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="w-full text-left font-label-code text-body-sm">
                                    <thead>
                                        <tr class="text-outline text-[11px] font-label-technical uppercase">
                                            <th class="py-1">Metric</th>
                                            <th class="py-1 text-right text-secondary">Reference</th>
                                            <th class="py-1 text-right text-tertiary">Current</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-on-surface">
                                        <tr class="bg-surface-container/20">
                                            <td class="py-1.5 text-on-surface-variant">Mean</td>
                                            <td class="py-1.5 text-right font-medium">28.41 mo</td>
                                            <td class="py-1.5 text-right font-bold text-error">4.12 mo</td>
                                        </tr>
                                        <tr>
                                            <td class="py-1.5 text-on-surface-variant">Std Dev</td>
                                            <td class="py-1.5 text-right">18.23</td>
                                            <td class="py-1.5 text-right text-tertiary">8.94</td>
                                        </tr>
                                        <tr class="bg-surface-container/20">
                                            <td class="py-1.5 text-on-surface-variant">Median (p50)</td>
                                            <td class="py-1.5 text-right">29.00 mo</td>
                                            <td class="py-1.5 text-right font-bold text-error">0.00 mo</td>
                                        </tr>
                                        <tr>
                                            <td class="py-1.5 text-on-surface-variant">p25 Quantile</td>
                                            <td class="py-1.5 text-right">12.00 mo</td>
                                            <td class="py-1.5 text-right font-bold text-error">0.00 mo</td>
                                        </tr>
                                        <tr class="bg-surface-container/20">
                                            <td class="py-1.5 text-on-surface-variant">p75 Quantile</td>
                                            <td class="py-1.5 text-right">44.00 mo</td>
                                            <td class="py-1.5 text-right">3.00 mo</td>
                                        </tr>
                                        <tr>
                                            <td class="py-1.5 text-on-surface-variant">p95 Quantile</td>
                                            <td class="py-1.5 text-right">58.00 mo</td>
                                            <td class="py-1.5 text-right">24.00 mo</td>
                                        </tr>
                                        <tr class="bg-surface-container/20">
                                            <td class="py-1.5 text-on-surface-variant">Zero Values Count</td>
                                            <td class="py-1.5 text-right text-secondary">1.2% (1,440)</td>
                                            <td class="py-1.5 text-right font-bold text-error">78.4% (6,680)</td>
                                        </tr>
                                        <tr>
                                            <td class="py-1.5 text-on-surface-variant font-semibold">Missing (Null) Rate</td>
                                            <td class="py-1.5 text-right text-primary">0.00% (0)</td>
                                            <td class="py-1.5 text-right font-bold text-primary">0.00% (0)</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- Factual Observation Tag (No fixes suggested) -->
                            <div class="bg-surface-container-high/40 p-space-sm rounded flex flex-col gap-1">
                                <div class="flex items-center gap-space-xs text-outline text-[11px] font-label-technical uppercase">
                                    <span class="material-symbols-outlined text-[15px] text-tertiary">info</span>
                                    <span>Recorded Feature Observation</span>
                                </div>
                                <p class="font-label-code text-[11px] text-on-surface-variant leading-relaxed">
                                    Value 0.0 represents 78.4% of total production window observations. Dataset missingness validator returns 0 nulls detected across upstream records.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- FEATURE-BY-FEATURE DRIFT ANALYSIS DATA MATRIX -->
                <div class="bg-surface-container-low rounded-lg p-space-md flex flex-col gap-space-md shadow-sm">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-space-sm">
                        <div class="flex items-center gap-space-sm">
                            <span class="material-symbols-outlined text-secondary text-[22px]">table_rows</span>
                            <div>
                                <h2 class="font-headline-md text-headline-md text-primary">
                                    Feature-by-Feature Statistical Matrix
                                </h2>
                                <p class="font-body-sm text-body-sm text-on-surface-variant">
                                    Full batch evaluation: 18 features tested across 8,520 records vs reference distribution.
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-space-sm">
                            <div class="relative">
                                <span class="material-symbols-outlined text-outline absolute left-2.5 top-2 text-[16px]">search</span>
                                <input class="bg-surface-container-lowest text-on-surface font-label-code text-[12px] pl-8 pr-3 py-1.5 rounded outline-none focus:bg-surface-container-high w-48 transition-all" id="featureTableSearch" placeholder="Filter features..." type="text" />
                            </div>
                            <div class="flex items-center gap-1 bg-surface-container-lowest p-1 rounded font-label-code text-[11px]">
                                <button class="px-2 py-0.5 rounded bg-surface-container-high text-primary font-bold">ALL (18)</button>
                                <button class="px-2 py-0.5 rounded text-tertiary hover:bg-surface-container-high">DRIFTED (4)</button>
                                <button class="px-2 py-0.5 rounded text-on-surface-variant hover:bg-surface-container-high">NOMINAL (14)</button>
                            </div>
                        </div>
                    </div>
                    <!-- Data Matrix Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-left font-label-code text-body-sm">
                            <thead>
                                <tr class="bg-surface-container-lowest text-outline font-label-technical text-label-technical uppercase tracking-wider">
                                    <th class="py-2.5 px-space-md">Feature Name</th>
                                    <th class="py-2.5 px-space-sm">Type</th>
                                    <th class="py-2.5 px-space-sm">Statistical Test</th>
                                    <th class="py-2.5 px-space-sm text-right">Drift Score</th>
                                    <th class="py-2.5 px-space-sm text-center">Status</th>
                                    <th class="py-2.5 px-space-sm text-right">Ref Mean ± Std</th>
                                    <th class="py-2.5 px-space-sm text-right">Cur Mean ± Std</th>
                                    <th class="py-2.5 px-space-md text-center">Dist Spark</th>
                                    <th class="py-2.5 px-space-sm text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-transparent">
                                <!-- Row 1: account_age_months (Critical) -->
                                <tr class="bg-error-container/20 hover:bg-error-container/30 transition-colors">
                                    <td class="py-2.5 px-space-md font-bold text-primary flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-error animate-ping"></span>
                                        <span>account_age_months</span>
                                    </td>
                                    <td class="py-2.5 px-space-sm text-on-surface-variant text-[11px]">num [int64]</td>
                                    <td class="py-2.5 px-space-sm text-on-surface-variant">Kolmogorov-Smirnov</td>
                                    <td class="py-2.5 px-space-sm text-right">
                                        <span class="font-bold text-error">0.4218</span>
                                        <span class="text-[10px] text-outline block">p: 0.0001 (&lt;0.05)</span>
                                    </td>
                                    <td class="py-2.5 px-space-sm text-center">
                                        <span class="px-2 py-0.5 rounded bg-error text-on-error font-label-technical text-[10px] font-bold uppercase">
                                            DRIFT DETECTED
                                        </span>
                                    </td>
                                    <td class="py-2.5 px-space-sm text-right text-secondary">
                                        28.41 <span class="text-outline text-[11px]">±18.2</span>
                                    </td>
                                    <td class="py-2.5 px-space-sm text-right font-bold text-error">
                                        4.12 <span class="text-outline text-[11px]">±8.9</span>
                                    </td>
                                    <td class="py-2.5 px-space-md text-center">
                                        <!-- Mini histogram sparkline -->
                                        <svg class="w-24 h-6 inline-block overflow-visible" viewbox="0 0 100 24">
                                            <rect class="fill-error" height="20" width="10" x="0" y="2"></rect>
                                            <rect class="fill-secondary/40" height="2" width="8" x="14" y="20"></rect>
                                            <rect class="fill-secondary/40" height="6" width="8" x="26" y="16"></rect>
                                            <rect class="fill-secondary/40" height="10" width="8" x="38" y="12"></rect>
                                            <rect class="fill-secondary/40" height="14" width="8" x="50" y="8"></rect>
                                            <rect class="fill-secondary/40" height="8" width="8" x="62" y="14"></rect>
                                            <rect class="fill-secondary/40" height="4" width="8" x="74" y="18"></rect>
                                        </svg>
                                    </td>
                                    <td class="py-2.5 px-space-sm text-right">
                                        <button class="px-2 py-1 rounded bg-surface-container-high hover:bg-surface-container-highest text-primary text-[11px] font-label-code">
                                            Inspect
                                        </button>
                                    </td>
                                </tr>
                                <!-- Row 2: monthly_charges -->
                                <tr class="bg-surface-container-highest/20 hover:bg-surface-container-highest/40 transition-colors">
                                    <td class="py-2.5 px-space-md font-medium text-on-surface flex items-center gap-2">
                                        <span class="w-1.5 h-1.5 rounded-full bg-tertiary"></span>
                                        <span>monthly_charges</span>
                                    </td>
                                    <td class="py-2.5 px-space-sm text-on-surface-variant text-[11px]">num [float64]</td>
                                    <td class="py-2.5 px-space-sm text-on-surface-variant">Kolmogorov-Smirnov</td>
                                    <td class="py-2.5 px-space-sm text-right">
                                        <span class="font-bold text-tertiary">0.1840</span>
                                        <span class="text-[10px] text-outline block">p: 0.0082 (&lt;0.05)</span>
                                    </td>
                                    <td class="py-2.5 px-space-sm text-center">
                                        <span class="px-2 py-0.5 rounded bg-tertiary-container text-tertiary font-label-technical text-[10px] font-bold uppercase">
                                            DRIFT DETECTED
                                        </span>
                                    </td>
                                    <td class="py-2.5 px-space-sm text-right text-secondary">
                                        64.76 <span class="text-outline text-[11px]">±30.1</span>
                                    </td>
                                    <td class="py-2.5 px-space-sm text-right text-tertiary">
                                        78.20 <span class="text-outline text-[11px]">±24.8</span>
                                    </td>
                                    <td class="py-2.5 px-space-md text-center">
                                        <svg class="w-24 h-6 inline-block overflow-visible" viewbox="0 0 100 24">
                                            <path class="text-secondary" d="M 0,20 Q 25,18 45,10 T 90,4" fill="none" stroke="currentColor" stroke-width="1.5"></path>
                                            <path class="text-tertiary" d="M 0,22 Q 25,20 45,6 T 90,2" fill="none" stroke="currentColor" stroke-dasharray="2 1" stroke-width="1.5"></path>
                                        </svg>
                                    </td>
                                    <td class="py-2.5 px-space-sm text-right">
                                        <button class="px-2 py-1 rounded bg-surface-container-high hover:bg-surface-container-highest text-on-surface text-[11px] font-label-code">
                                            Inspect
                                        </button>
                                    </td>
                                </tr>
                                <!-- Row 3: contract_type -->
                                <tr class="bg-surface-container-highest/20 hover:bg-surface-container-highest/40 transition-colors">
                                    <td class="py-2.5 px-space-md font-medium text-on-surface flex items-center gap-2">
                                        <span class="w-1.5 h-1.5 rounded-full bg-tertiary"></span>
                                        <span>contract_type</span>
                                    </td>
                                    <td class="py-2.5 px-space-sm text-on-surface-variant text-[11px]">cat [string]</td>
                                    <td class="py-2.5 px-space-sm text-on-surface-variant">Chi-Square Goodness</td>
                                    <td class="py-2.5 px-space-sm text-right">
                                        <span class="font-bold text-tertiary">0.3105</span>
                                        <span class="text-[10px] text-outline block">p: 0.0014 (&lt;0.05)</span>
                                    </td>
                                    <td class="py-2.5 px-space-sm text-center">
                                        <span class="px-2 py-0.5 rounded bg-tertiary-container text-tertiary font-label-technical text-[10px] font-bold uppercase">
                                            DRIFT DETECTED
                                        </span>
                                    </td>
                                    <td class="py-2.5 px-space-sm text-right text-secondary">
                                        <span class="text-[11px]">Month: 55% / 1yr: 24%</span>
                                    </td>
                                    <td class="py-2.5 px-space-sm text-right text-tertiary">
                                        <span class="text-[11px]">Month: 79% / 1yr: 14%</span>
                                    </td>
                                    <td class="py-2.5 px-space-md text-center">
                                        <div class="flex items-center justify-center gap-1">
                                            <span class="w-3 h-4 bg-tertiary rounded-xs inline-block"></span>
                                            <span class="w-3 h-2 bg-secondary rounded-xs inline-block"></span>
                                            <span class="w-3 h-1 bg-outline rounded-xs inline-block"></span>
                                        </div>
                                    </td>
                                    <td class="py-2.5 px-space-sm text-right">
                                        <button class="px-2 py-1 rounded bg-surface-container-high hover:bg-surface-container-highest text-on-surface text-[11px] font-label-code">
                                            Inspect
                                        </button>
                                    </td>
                                </tr>
                                <!-- Row 4: total_charges -->
                                <tr class="hover:bg-surface-container-high/20 transition-colors">
                                    <td class="py-2.5 px-space-md font-medium text-on-surface-variant flex items-center gap-2">
                                        <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
                                        <span>total_charges</span>
                                    </td>
                                    <td class="py-2.5 px-space-sm text-on-surface-variant text-[11px]">num [float64]</td>
                                    <td class="py-2.5 px-space-sm text-on-surface-variant">Kolmogorov-Smirnov</td>
                                    <td class="py-2.5 px-space-sm text-right">
                                        <span class="font-medium text-primary">0.0312</span>
                                        <span class="text-[10px] text-outline block">p: 0.2810 (&gt;0.05)</span>
                                    </td>
                                    <td class="py-2.5 px-space-sm text-center">
                                        <span class="px-2 py-0.5 rounded bg-surface-container-high text-primary font-label-technical text-[10px] uppercase">
                                            NOMINAL
                                        </span>
                                    </td>
                                    <td class="py-2.5 px-space-sm text-right text-on-surface-variant">
                                        2283.3 <span class="text-outline text-[11px]">±2266</span>
                                    </td>
                                    <td class="py-2.5 px-space-sm text-right text-on-surface-variant">
                                        2241.0 <span class="text-outline text-[11px]">±2198</span>
                                    </td>
                                    <td class="py-2.5 px-space-md text-center">
                                        <svg class="w-24 h-6 inline-block overflow-visible" viewbox="0 0 100 24">
                                            <path class="text-primary" d="M 0,6 Q 40,16 90,22" fill="none" stroke="currentColor" stroke-width="1.5"></path>
                                        </svg>
                                    </td>
                                    <td class="py-2.5 px-space-sm text-right">
                                        <button class="px-2 py-1 rounded bg-surface-container-high hover:bg-surface-container-highest text-outline text-[11px] font-label-code">
                                            Inspect
                                        </button>
                                    </td>
                                </tr>
                                <!-- Row 5: support_tickets_last_30d -->
                                <tr class="hover:bg-surface-container-high/20 transition-colors">
                                    <td class="py-2.5 px-space-md font-medium text-on-surface-variant flex items-center gap-2">
                                        <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
                                        <span>support_tickets_last_30d</span>
                                    </td>
                                    <td class="py-2.5 px-space-sm text-on-surface-variant text-[11px]">num [int32]</td>
                                    <td class="py-2.5 px-space-sm text-on-surface-variant">Kolmogorov-Smirnov</td>
                                    <td class="py-2.5 px-space-sm text-right">
                                        <span class="font-medium text-primary">0.0215</span>
                                        <span class="text-[10px] text-outline block">p: 0.4120 (&gt;0.05)</span>
                                    </td>
                                    <td class="py-2.5 px-space-sm text-center">
                                        <span class="px-2 py-0.5 rounded bg-surface-container-high text-primary font-label-technical text-[10px] uppercase">
                                            NOMINAL
                                        </span>
                                    </td>
                                    <td class="py-2.5 px-space-sm text-right text-on-surface-variant">
                                        1.42 <span class="text-outline text-[11px]">±1.1</span>
                                    </td>
                                    <td class="py-2.5 px-space-sm text-right text-on-surface-variant">
                                        1.48 <span class="text-outline text-[11px]">±1.2</span>
                                    </td>
                                    <td class="py-2.5 px-space-md text-center">
                                        <svg class="w-24 h-6 inline-block overflow-visible" viewbox="0 0 100 24">
                                            <path class="text-primary" d="M 0,4 Q 30,12 90,20" fill="none" stroke="currentColor" stroke-width="1.5"></path>
                                        </svg>
                                    </td>
                                    <td class="py-2.5 px-space-sm text-right">
                                        <button class="px-2 py-1 rounded bg-surface-container-high hover:bg-surface-container-highest text-outline text-[11px] font-label-code">
                                            Inspect
                                        </button>
                                    </td>
                                </tr>
                                <!-- Row 6: paperless_billing -->
                                <tr class="hover:bg-surface-container-high/20 transition-colors">
                                    <td class="py-2.5 px-space-md font-medium text-on-surface-variant flex items-center gap-2">
                                        <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
                                        <span>paperless_billing</span>
                                    </td>
                                    <td class="py-2.5 px-space-sm text-on-surface-variant text-[11px]">cat [bool]</td>
                                    <td class="py-2.5 px-space-sm text-on-surface-variant">Z-Score Proportions</td>
                                    <td class="py-2.5 px-space-sm text-right">
                                        <span class="font-medium text-primary">0.0124</span>
                                        <span class="text-[10px] text-outline block">p: 0.6800 (&gt;0.05)</span>
                                    </td>
                                    <td class="py-2.5 px-space-sm text-center">
                                        <span class="px-2 py-0.5 rounded bg-surface-container-high text-primary font-label-technical text-[10px] uppercase">
                                            NOMINAL
                                        </span>
                                    </td>
                                    <td class="py-2.5 px-space-sm text-right text-on-surface-variant">
                                        <span class="text-[11px]">True: 59.2%</span>
                                    </td>
                                    <td class="py-2.5 px-space-sm text-right text-on-surface-variant">
                                        <span class="text-[11px]">True: 58.7%</span>
                                    </td>
                                    <td class="py-2.5 px-space-md text-center">
                                        <div class="flex items-center justify-center gap-1">
                                            <span class="w-4 h-3 bg-secondary/80 rounded-xs inline-block"></span>
                                            <span class="w-3 h-3 bg-surface-container-highest rounded-xs inline-block"></span>
                                        </div>
                                    </td>
                                    <td class="py-2.5 px-space-sm text-right">
                                        <button class="px-2 py-1 rounded bg-surface-container-high hover:bg-surface-container-highest text-outline text-[11px] font-label-code">
                                            Inspect
                                        </button>
                                    </td>
                                </tr>
                                <!-- Row 7: payment_method -->
                                <tr class="hover:bg-surface-container-high/20 transition-colors">
                                    <td class="py-2.5 px-space-md font-medium text-on-surface-variant flex items-center gap-2">
                                        <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
                                        <span>payment_method</span>
                                    </td>
                                    <td class="py-2.5 px-space-sm text-on-surface-variant text-[11px]">cat [string]</td>
                                    <td class="py-2.5 px-space-sm text-on-surface-variant">Chi-Square Test</td>
                                    <td class="py-2.5 px-space-sm text-right">
                                        <span class="font-medium text-primary">0.0410</span>
                                        <span class="text-[10px] text-outline block">p: 0.1980 (&gt;0.05)</span>
                                    </td>
                                    <td class="py-2.5 px-space-sm text-center">
                                        <span class="px-2 py-0.5 rounded bg-surface-container-high text-primary font-label-technical text-[10px] uppercase">
                                            NOMINAL
                                        </span>
                                    </td>
                                    <td class="py-2.5 px-space-sm text-right text-on-surface-variant">
                                        <span class="text-[11px]">Card: 34% / Bank: 32%</span>
                                    </td>
                                    <td class="py-2.5 px-space-sm text-right text-on-surface-variant">
                                        <span class="text-[11px]">Card: 33% / Bank: 34%</span>
                                    </td>
                                    <td class="py-2.5 px-space-md text-center">
                                        <div class="flex items-center justify-center gap-1">
                                            <span class="w-3 h-3 bg-secondary/80 rounded-xs inline-block"></span>
                                            <span class="w-3 h-3 bg-secondary/70 rounded-xs inline-block"></span>
                                            <span class="w-3 h-3 bg-secondary/60 rounded-xs inline-block"></span>
                                        </div>
                                    </td>
                                    <td class="py-2.5 px-space-sm text-right">
                                        <button class="px-2 py-1 rounded bg-surface-container-high hover:bg-surface-container-highest text-outline text-[11px] font-label-code">
                                            Inspect
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- Table Pagination & Matrix Summary -->
                    <div class="flex items-center justify-between font-label-code text-body-sm text-outline pt-space-xs">
                        <span>Displaying 7 priority features of 18 total active vectors</span>
                        <div class="flex items-center gap-2">
                            <button class="px-2 py-1 rounded bg-surface-container-high text-on-surface-variant hover:text-on-surface text-[11px]">PREV</button>
                            <span class="text-primary text-[11px]">PAGE 1 OF 3</span>
                            <button class="px-2 py-1 rounded bg-surface-container-high text-on-surface-variant hover:text-on-surface text-[11px]">NEXT</button>
                        </div>
                    </div>
                </div>
                <!-- TARGET PREDICTION DRIFT & SCHEMA INTEGRITY SIDE-BY-SIDE PANELS -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-space-md">
                    <!-- Panel Left: Model Prediction Probability Output Drift -->
                    <div class="bg-surface-container-low rounded-lg p-space-md flex flex-col justify-between gap-space-md shadow-sm">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-space-sm">
                                <span class="material-symbols-outlined text-error text-[20px]">ssid_chart</span>
                                <div>
                                    <h3 class="font-headline-md text-headline-md text-primary">Model Prediction Drift (P(churn))</h3>
                                    <span class="font-label-technical text-label-technical text-outline uppercase">Output Probabilities: 0.0 to 1.0</span>
                                </div>
                            </div>
                            <span class="px-2 py-0.5 rounded bg-error-container text-error font-label-code text-[11px] font-bold">
                                PSI: 0.312 &gt; 0.25
                            </span>
                        </div>
                        <!-- Probability Density SVG Chart -->
                        <div class="bg-surface-container-lowest p-space-sm rounded">
                            <div class="h-44 w-full relative">
                                <svg class="w-full h-full overflow-visible" preserveaspectratio="none" viewbox="0 0 400 160">
                                    <!-- Gridlines -->
                                    <line class="text-outline-variant/30" stroke="currentColor" stroke-dasharray="2 2" stroke-width="1" x1="0" x2="400" y1="40" y2="40"></line>
                                    <line class="text-outline-variant/30" stroke="currentColor" stroke-dasharray="2 2" stroke-width="1" x1="0" x2="400" y1="90" y2="90"></line>
                                    <line class="text-outline" stroke="currentColor" stroke-width="1" x1="0" x2="400" y1="140" y2="140"></line>
                                    <!-- Decision Boundary Threshold at 0.5 -->
                                    <line class="text-error" stroke="currentColor" stroke-dasharray="3 3" stroke-width="1.5" x1="200" x2="200" y1="10" y2="140"></line>
                                    <text class="text-error font-label-code text-[10px] font-bold" fill="currentColor" x="204" y="24">DECISION BOUNDARY (0.5)</text>
                                    <!-- Reference Output Probability Curve (Centered low around 0.25 - low churn baseline) -->
                                    <path class="text-secondary" d="M 10,140 Q 80,10 120,40 T 200,120 T 390,140" fill="none" stroke="currentColor" stroke-width="2"></path>
                                    <!-- Current Window Output Probability Curve (Significant Right Shift toward 0.6 - 0.85!) -->
                                    <path class="text-tertiary" d="M 10,140 Q 100,135 180,110 T 280,25 T 390,135" fill="none" stroke="currentColor" stroke-width="2.5"></path>
                                    <!-- Labels -->
                                    <text class="text-outline font-label-code text-[10px]" fill="currentColor" x="10" y="155">0.0 (Low Risk)</text>
                                    <text class="text-outline font-label-code text-[10px]" fill="currentColor" x="180" y="155">0.5</text>
                                    <text class="text-outline font-label-code text-[10px]" fill="currentColor" x="330" y="155">1.0 (High Churn)</text>
                                </svg>
                            </div>
                            <div class="flex items-center justify-between text-body-sm font-label-code pt-space-xs text-on-surface-variant">
                                <div class="flex items-center gap-space-sm">
                                    <span class="inline-flex items-center gap-1 text-secondary">
                                        <span class="w-2.5 h-2.5 bg-secondary inline-block rounded-xs"></span> Baseline (Mean P=0.23)
                                    </span>
                                    <span class="inline-flex items-center gap-1 text-tertiary">
                                        <span class="w-2.5 h-2.5 bg-tertiary inline-block rounded-xs"></span> Current (Mean P=0.58)
                                    </span>
                                </div>
                                <span class="text-error font-bold">+152% Churn Inferences</span>
                            </div>
                        </div>
                        <!-- Factual Metrics Footer -->
                        <div class="grid grid-cols-3 gap-space-xs text-center font-label-code text-[11px] bg-surface-container-lowest p-space-sm rounded">
                            <div>
                                <span class="text-outline block">False Positives (Est)</span>
                                <span class="text-error font-bold text-body-md">+28.4%</span>
                            </div>
                            <div>
                                <span class="text-outline block">Positive Rate Ref</span>
                                <span class="text-on-surface font-semibold text-body-md">17.2%</span>
                            </div>
                            <div>
                                <span class="text-outline block">Positive Rate Cur</span>
                                <span class="text-tertiary font-bold text-body-md">43.6%</span>
                            </div>
                        </div>
                    </div>
                    <!-- Panel Right: Inferred Schema & Ingestion Pipeline Verification -->
                    <div class="bg-surface-container-low rounded-lg p-space-md flex flex-col justify-between gap-space-md shadow-sm">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-space-sm">
                                <span class="material-symbols-outlined text-secondary text-[20px]">schema</span>
                                <div>
                                    <h3 class="font-headline-md text-headline-md text-primary">Ingestion Schema &amp; Payload Verification</h3>
                                    <span class="font-label-technical text-label-technical text-outline uppercase">FEED://CRM-FEED-05 CONTRACT TRACE</span>
                                </div>
                            </div>
                            <span class="px-2 py-0.5 rounded bg-tertiary-container text-tertiary font-label-code text-[11px] font-bold">
                                PAYLOAD VERSION MISMATCH
                            </span>
                        </div>
                        <div class="space-y-space-xs font-label-code text-body-sm">
                            <div class="bg-surface-container-lowest p-space-sm rounded flex items-center justify-between">
                                <span class="text-on-surface-variant">Incoming Feed Tag:</span>
                                <span class="text-tertiary font-bold">CRM-FEED-05 // Release 2025.02-b</span>
                            </div>
                            <div class="bg-surface-container-lowest p-space-sm rounded flex items-center justify-between">
                                <span class="text-on-surface-variant">Observed Serialization Schema:</span>
                                <span class="text-error font-bold">Protobuf Payload v1.8 (Model expects v1.7)</span>
                            </div>
                            <div class="bg-surface-container-lowest p-space-sm rounded flex items-center justify-between">
                                <span class="text-on-surface-variant">Pipeline Missing-Value Imputer:</span>
                                <span class="text-primary font-bold">Default Imputer Mode: FILL_NA_WITH_ZERO (Active)</span>
                            </div>
                            <div class="bg-surface-container-lowest p-space-sm rounded flex items-center justify-between">
                                <span class="text-on-surface-variant">Feature Column Presence:</span>
                                <span class="text-secondary font-bold">18 of 18 Present (100% Column Map)</span>
                            </div>
                        </div>
                        <div class="bg-surface-container-highest/40 p-space-sm rounded flex items-start gap-space-sm">
                            <span class="material-symbols-outlined text-secondary text-[18px] shrink-0 mt-0.5">terminal</span>
                            <div class="font-label-code text-[11px] text-on-surface-variant leading-relaxed">
                                <span class="text-primary font-bold">UPSTREAM_TELEMETRY_LOG // 04:15:22 UTC:</span>
                                CRM-FEED-05 updated user profile schema to omit legacy <code class="text-tertiary font-bold">account_age_months</code> in favor of ISO-8601 <code class="text-secondary font-bold">creation_timestamp</code>. Raw feeder emitted NULL for missing field; inference gateway auto-imputed with numerical zero.
                            </div>
                        </div>
                        <div class="flex items-center justify-between text-body-sm font-label-code pt-space-xs text-outline">
                            <span>Validation Protocol: SYS-AI-CONTRACT-V2</span>
                            <span class="text-on-surface font-semibold">Status: PASS (With Type Coercion)</span>
                        </div>
                    </div>
                </div>
                <!-- PERSISTENT WAR ROOM ACTION FOOTER TOOLBAR -->
                <div class="bg-surface-container-low p-space-md rounded-lg flex flex-col md:flex-row items-center justify-between gap-space-md shadow-sm">
                    <div class="flex items-center gap-space-sm">
                        <div class="w-3 h-3 rounded-full bg-error animate-pulse">
                            <div>
                                <span class="font-label-technical text-label-technical text-outline uppercase tracking-wider block">ASSOCIATED LIVE INCIDENT</span>
                                <span class="font-label-code text-label-code text-error font-bold">
                                    INC-4092: churn_rf_v2 Production F1-Score Degradation (0.87 -&gt; 0.61 &lt; 0.80 SLA)
                                </span>
                            </div>
                        </div>
                        <!-- Action Buttons Group (No Root Cause Advice, Strict Functional Actions) -->
                        <div class="flex items-center gap-space-sm flex-wrap w-full md:w-auto justify-end">
                            <!-- Pin to war room -->
                            <button class="bg-surface-container-high hover:bg-surface-container-highest text-primary px-space-md py-space-sm rounded font-label-technical text-label-technical flex items-center gap-space-xs transition-colors" id="btnPinFindings">
                                <span class="material-symbols-outlined text-[16px]">push_pin</span>
                                <span>Pin Evidence to INC-4092</span>
                            </button>
                            <!-- Export Report -->
                            <button class="bg-surface-container-high hover:bg-surface-container-highest text-on-surface px-space-md py-space-sm rounded font-label-technical text-label-technical flex items-center gap-space-xs transition-colors" id="btnExportReport">
                                <span class="material-symbols-outlined text-[16px]">file_download</span>
                                <span>Export Evidently JSON/HTML</span>
                            </button>
                            <!-- War Room Navigation CTA -->
                            <a class="bg-primary text-on-primary hover:bg-primary-fixed-dim px-space-md py-space-sm rounded font-label-technical text-label-technical font-bold flex items-center gap-space-xs shadow transition-all" data-path="active-incident" href="#">
                                <span>Proceed to INC-4092 War Room</span>
                                <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                            </a>
                        </div>
                    </div>
                    <!-- Toast Notification Container (Dynamic via JS) -->
                    <div class="fixed bottom-6 right-6 bg-surface-container-highest text-on-surface px-space-md py-space-sm rounded shadow-lg font-label-code text-body-sm hidden flex items-center gap-space-sm z-50" id="telemetryToast">
                        <span class="material-symbols-outlined text-tertiary text-[18px]">verified</span>
                        <span id="toastMessage">Evidence snapshot synchronized.</span>
                    </div>
                </div>
                <!-- Interactive Telemetry Micro-scripts -->
                <script>
                    (function() {
                        const pinBtn = document.getElementById('btnPinFindings');
                        const exportBtn = document.getElementById('btnExportReport');
                        const refreshBtn = document.getElementById('btnRefreshMatrix');
                        const toast = document.getElementById('telemetryToast');
                        const toastMsg = document.getElementById('toastMessage');

                        function showToast(message) {
                            if (!toast) return;
                            toastMsg.textContent = message;
                            toast.classList.remove('hidden');
                            setTimeout(() => {
                                toast.classList.add('hidden');
                            }, 3200);
                        }

                        if (pinBtn) {
                            pinBtn.addEventListener('click', () => {
                                pinBtn.innerHTML = '<span class="material-symbols-outlined text-[16px]">check</span><span>Pinned to War Room (Snapshot #9)</span>';
                                pinBtn.classList.add('bg-tertiary-container', 'text-tertiary');
                                showToast('Evidence snapshot "account_age_months & PSI 0.312" pinned to INC-4092 War Room.');
                            });
                        }

                        if (exportBtn) {
                            exportBtn.addEventListener('click', () => {
                                showToast('Evidently Report generated: telemetry_churn_rf_v2_20250212.json');
                            });
                        }

                        if (refreshBtn) {
                            refreshBtn.addEventListener('click', () => {
                                refreshBtn.classList.add('animate-spin');
                                setTimeout(() => {
                                    refreshBtn.classList.remove('animate-spin');
                                    showToast('Sample recomputed across latest 8,520 telemetry frames.');
                                }, 600);
                            });
                        }

                        // Filter Table Realtime Micro-interaction
                        const searchInput = document.getElementById('featureTableSearch');
                        if (searchInput) {
                            searchInput.addEventListener('input', (e) => {
                                const val = e.target.value.toLowerCase();
                                const rows = document.querySelectorAll('tbody tr');
                                rows.forEach(r => {
                                    const text = r.textContent.toLowerCase();
                                    if (text.includes(val)) {
                                        r.style.display = '';
                                    } else {
                                        r.style.display = 'none';
                                    }
                                });
                            });
                        }
                    })();
                </script>
            </div>
        </main>
    </div>
</body>

</html>