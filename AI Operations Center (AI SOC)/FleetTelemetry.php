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
                        "inverse-primary": "#4d6077",
                        "on-surface": "#d3e4ff",
                        "primary-fixed-dim": "#b4c8e3",
                        "surface-container-lowest": "#000f21",
                        "tertiary-fixed": "#ffddb5",
                        "outline-variant": "#43474c",
                        "on-secondary-fixed-variant": "#2b486b",
                        "on-secondary-fixed": "#001c38",
                        "tertiary-fixed-dim": "#ffb956",
                        "outline": "#8e9197",
                        "on-surface-variant": "#c4c6cd",
                        "on-tertiary-fixed": "#2a1800",
                        "on-tertiary-fixed-variant": "#643f00",
                        "surface-container-high": "#132b45",
                        "on-secondary": "#113253",
                        "inverse-surface": "#d3e4ff",
                        "on-primary-fixed": "#071d30",
                        "primary-container": "#0f2438",
                        "on-primary-container": "#788ca4",
                        "on-secondary-container": "#9ab7e0",
                        "secondary-container": "#2b486b",
                        "surface-tint": "#b4c8e3",
                        "surface-variant": "#1f3651",
                        "secondary-fixed": "#d2e4ff",
                        "background": "#00142a",
                        "on-tertiary-container": "#bb7d16",
                        "on-primary": "#1e3246",
                        "surface": "#00142a",
                        "tertiary-container": "#331e00",
                        "surface-container-highest": "#1f3651",
                        "tertiary": "#ffb956",
                        "error": "#ffb4ab",
                        "on-background": "#d3e4ff",
                        "primary": "#b4c8e3",
                        "surface-container": "#06203a",
                        "on-primary-fixed-variant": "#35485e",
                        "surface-bright": "#243a56",
                        "secondary-fixed-dim": "#abc9f2",
                        "secondary": "#abc9f2",
                        "surface-container-low": "#021c36",
                        "inverse-on-surface": "#1a314c",
                        "on-tertiary": "#462b00",
                        "primary-fixed": "#d0e4ff",
                        "on-error": "#690005",
                        "surface-dim": "#00142a",
                        "on-error-container": "#ffdad6",
                        "error-container": "#93000a"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "gutter-desktop": "1.5rem",
                        "space-md": "1rem",
                        "margin-desktop": "2rem",
                        "space-xs": "0.25rem",
                        "margin": "1rem",
                        "space-sm": "0.5rem",
                        "gutter": "1rem",
                        "space-lg": "1.5rem",
                        "space-xl": "2rem"
                    },
                    "fontFamily": {
                        "metric-display": [
                            "Space Mono"
                        ],
                        "headline-md": [
                            "IBM Plex Sans"
                        ],
                        "headline-xl": [
                            "IBM Plex Sans"
                        ],
                        "headline-xl-mobile": [
                            "IBM Plex Sans"
                        ],
                        "metric-sm": [
                            "Space Mono"
                        ],
                        "body-lg": [
                            "Inter"
                        ],
                        "body-sm": [
                            "Inter"
                        ],
                        "label-code": [
                            "Space Mono"
                        ],
                        "label-technical": [
                            "IBM Plex Sans"
                        ],
                        "headline-lg": [
                            "IBM Plex Sans"
                        ],
                        "headline-lg-mobile": [
                            "IBM Plex Sans"
                        ],
                        "body-md": [
                            "Inter"
                        ]
                    },
                    "fontSize": {
                        "metric-display": [
                            "32px",
                            {
                                "lineHeight": "36px",
                                "letterSpacing": "-0.03em",
                                "fontWeight": "700"
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
                        "headline-xl": [
                            "36px",
                            {
                                "lineHeight": "44px",
                                "letterSpacing": "-0.02em",
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
                        "metric-sm": [
                            "18px",
                            {
                                "lineHeight": "22px",
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
                        "body-sm": [
                            "12px",
                            {
                                "lineHeight": "18px",
                                "letterSpacing": "0.01em",
                                "fontWeight": "400"
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
                        "label-technical": [
                            "11px",
                            {
                                "lineHeight": "14px",
                                "letterSpacing": "0.08em",
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
                        "headline-lg-mobile": [
                            "22px",
                            {
                                "lineHeight": "30px",
                                "letterSpacing": "0em",
                                "fontWeight": "600"
                            }
                        ],
                        "body-md": [
                            "14px",
                            {
                                "lineHeight": "20px",
                                "letterSpacing": "0em",
                                "fontWeight": "400"
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
            <nav class="flex flex-col px-space-xs py-space-sm gap-space-xs" data-active-classes="bg-primary-container text-on-surface border-l-2 border-tertiary"><a class="flex items-center justify-between px-space-md py-space-sm rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="project-hub" href="#"><span class="font-label-technical text-label-technical">SYS-AI-01: Objectives Hub</span><span class="font-label-code text-label-code text-outline">v1.2</span></a><a class="flex items-center justify-between px-space-md py-space-sm rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="data-lake" href="#"><span class="font-label-technical text-label-technical">SYS-AI-02: Data Lake Lakeflow</span><span class="font-label-code text-label-code text-outline">4.8TB</span></a><a class="flex items-center justify-between px-space-md py-space-sm rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="model-workbench" href="#"><span class="font-label-technical text-label-technical">SYS-AI-03: Model Workbench</span><span class="font-label-code text-label-code text-outline">READY</span></a><a class="flex items-center justify-between px-space-md py-space-sm rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="model-registry" href="#"><span class="font-label-technical text-label-technical">SYS-AI-04: Registry &amp; CI/CD</span><span class="font-label-code text-label-code text-outline">PROD</span></a><a aria-current="page" class="flex items-center justify-between px-space-md py-space-sm rounded transition-all bg-primary-container text-on-surface border-l-2 border-tertiary" data-path="soc-overview" href="#">
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
                    <div class="hidden xl:flex items-center gap-space-xs bg-error-container/30 px-space-sm py-space-xs rounded"><span class="w-2 h-2 rounded-full bg-error animate-ping"></span><span class="font-label-code text-label-code text-error tracking-tight font-semibold">CRITICAL ALERT ACTIVE (churn_rf_v2: F1 0.87 -&gt; 0.61)</span></div>
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
                <nav class="flex items-center gap-space-md shrink-0 h-full" data-active-classes="text-tertiary border-b-2 border-tertiary font-semibold"><a aria-current="page" class="h-full flex items-center transition-colors text-tertiary border-b-2 border-tertiary font-semibold" data-path="soc-overview" href="#">Overview</a><a class="text-on-surface-variant hover:text-on-surface h-full flex items-center font-label-code text-label-code transition-colors" data-path="alerts-center" href="#">Alerts (3)</a><a class="text-on-surface-variant hover:text-on-surface h-full flex items-center font-label-code text-label-code transition-colors" data-path="model-monitoring" href="#">Monitoring</a><a class="text-on-surface-variant hover:text-on-surface h-full flex items-center font-label-code text-label-code transition-colors" data-path="drift-workspace" href="#">Drift</a><a class="text-on-surface-variant hover:text-on-surface h-full flex items-center font-label-code text-label-code transition-colors" data-path="active-incident" href="#">Incident INC-4092</a><a class="text-on-surface-variant hover:text-on-surface h-full flex items-center font-label-code text-label-code transition-colors" data-path="incident-report" href="#">Post-Mortem</a><a class="text-on-surface-variant hover:text-on-surface h-full flex items-center font-label-code text-label-code transition-colors" data-path="alert-rules-config" href="#">Config</a><a class="text-on-surface-variant hover:text-on-surface h-full flex items-center font-label-code text-label-code transition-colors" data-path="wall-display" href="#">Wall Display</a></nav>
            </div>
        </header>
        <main class="relative pt-28 w-full p-gutter-desktop bg-transparent">
            <div class="flex flex-col w-full gap-space-md">
                <!-- Operational Drill Context Bar -->
                <div class="flex flex-wrap items-center justify-between gap-space-sm bg-surface-container-low px-space-md py-space-xs rounded">
                    <div class="flex items-center gap-space-sm">
                        <span class="font-label-technical text-label-technical text-outline uppercase tracking-wider">Mission Session</span>
                        <span class="font-label-code text-label-code text-tertiary font-bold bg-tertiary-container/60 px-2 py-0.5 rounded">Scenario 07: Production Model Failure &amp; AI SOC Drill</span>
                        <span class="hidden md:inline font-label-code text-label-code text-on-surface-variant">• Level 3 AI Production Certification Track</span>
                    </div>
                    <div class="flex items-center gap-space-sm">
                        <div class="flex items-center gap-1.5 bg-surface-container-high px-2 py-0.5 rounded">
                            <span class="w-2 h-2 rounded-full bg-tertiary animate-ping"></span>
                            <span class="font-label-code text-[11px] text-tertiary font-bold">LIVE TELEMETRY (5s POLLING)</span>
                        </div>
                        <span class="font-label-code text-label-code text-outline">EPOCH // 1714088920</span>
                    </div>
                </div>
                <!-- Top Critical Incident Banner -->
                <div class="relative overflow-hidden bg-error-container text-on-error-container rounded-lg p-space-md shadow-md">
                    <div class="absolute -right-8 -top-8 w-36 h-36 bg-error/15 rounded-full blur-2xl pointer-events-none"></div>
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-space-md relative z-10">
                        <div class="flex items-start gap-space-sm">
                            <div class="p-2 bg-on-error-container/10 rounded shrink-0 mt-0.5">
                                <span class="material-symbols-outlined text-error text-[22px] leading-none" style="font-variation-settings: 'FILL' 1;">warning</span>
                            </div>
                            <div class="flex flex-col gap-0.5">
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="font-metric-sm text-metric-sm font-bold tracking-tight text-on-error-container">INCIDENT #INC-4092 ACTIVE</span>
                                    <span class="px-2 py-0.5 rounded bg-error text-on-error font-label-technical text-[10px] tracking-wider uppercase font-bold">P1 CRITICAL</span>
                                    <span class="font-label-code text-label-code text-on-error-container/80">Triggered: 04:18 UTC</span>
                                </div>
                                <p class="font-body-md text-body-md text-on-error-container font-medium leading-snug">
                                    Model <code class="font-label-code text-label-code bg-black/30 px-1.5 py-0.5 rounded text-white font-bold">churn_rf_v2</code> F1 metric collapsed from <span class="font-bold underline">0.87</span> to <span class="font-bold underline">0.61</span> (Δ -29.8%). Ingestion pipeline <span class="font-semibold text-white">CRM-FEED-05</span> schema shift suspected.
                                </p>
                                <div class="flex flex-wrap items-center gap-x-4 gap-y-1 font-label-code text-[11px] text-on-error-container/90 mt-1">
                                    <span>Status: <strong class="uppercase text-white">INVESTIGATING</strong></span>
                                    <span>Assignee: <strong class="text-white">Alexei V. (Primary SOC On-Duty)</strong></span>
                                    <span>Blast Radius: <strong class="text-white">Enterprise Retention Svc · APAC / EMEA</strong></span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-space-sm shrink-0 self-end lg:self-center">
                            <button class="px-space-md py-space-sm rounded font-label-code text-label-code bg-surface-container-lowest/80 text-on-surface hover:bg-surface-container-high transition-colors" id="btn-mute-alert">
                                Mute Alert (30m)
                            </button>
                            <button class="flex items-center gap-1.5 px-space-md py-space-sm rounded font-label-code text-label-code bg-on-error-container text-surface-container-lowest font-bold hover:bg-white transition-all shadow-sm" id="btn-open-inc">
                                <span>Open Incident INC-4092</span>
                                <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Operational Filter / Quick Scope Row -->
                <div class="flex flex-wrap items-center justify-between gap-space-sm bg-surface-container-high px-space-md py-space-xs rounded">
                    <div class="flex items-center gap-2 overflow-x-auto">
                        <span class="font-label-technical text-label-technical text-outline uppercase tracking-wider mr-1">Time Horizon:</span>
                        <button class="px-2.5 py-1 rounded font-label-code text-label-code text-on-surface-variant hover:text-on-surface hover:bg-surface-container transition-all">Last 1h</button>
                        <button class="px-2.5 py-1 rounded font-label-code text-label-code bg-primary-container text-primary font-bold shadow-sm">Last 6h (Scope)</button>
                        <button class="px-2.5 py-1 rounded font-label-code text-label-code text-on-surface-variant hover:text-on-surface hover:bg-surface-container transition-all">Last 24h</button>
                        <button class="px-2.5 py-1 rounded font-label-code text-label-code text-on-surface-variant hover:text-on-surface hover:bg-surface-container transition-all">Last 7d</button>
                        <div class="h-4 w-px bg-outline/30 mx-1"></div>
                        <span class="font-label-technical text-label-technical text-outline uppercase tracking-wider">Cluster:</span>
                        <span class="font-label-code text-label-code text-secondary bg-surface-container-lowest px-2 py-0.5 rounded">prod-us-east-vpc-02</span>
                    </div>
                    <div class="flex items-center gap-space-sm">
                        <span class="font-label-code text-[11px] text-on-surface-variant">Sync: <span class="text-secondary font-bold" id="telemetry-counter">2s ago</span></span>
                        <button class="p-1 rounded hover:bg-surface-container text-on-surface-variant hover:text-on-surface transition-colors" id="btn-manual-sync" title="Force Telemetry Sync">
                            <span class="material-symbols-outlined text-[18px]">sync</span>
                        </button>
                    </div>
                </div>
                <!-- BENTO SECTION 1: Fleet Health Summary Tile -->
                <div class="bg-secondary-fixed/95 text-on-secondary-fixed p-space-md rounded-xl shadow-md">
                    <div class="flex flex-col gap-space-md">
                        <!-- Title & Live Connectivity Strip -->
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-space-xs pb-space-xs">
                            <div class="flex items-center gap-space-sm">
                                <div class="w-2.5 h-6 bg-on-secondary-fixed rounded-full"></div>
                                <div>
                                    <h2 class="font-headline-md text-headline-md tracking-tight leading-none text-on-secondary-fixed">FLEET TELEMETRY &amp; OPERATIONAL HEALTH</h2>
                                    <p class="font-label-technical text-label-technical uppercase tracking-widest text-on-secondary-fixed-variant mt-1">Autonomous Machine Learning Core Registry // 18 Monitored Endpoints</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 bg-on-secondary-fixed/10 px-space-sm py-1 rounded text-[11px] font-label-code text-on-secondary-fixed">
                                <span class="w-2 h-2 rounded-full bg-secondary-container animate-pulse"></span>
                                <span>Heartbeat sync: 2s ago</span>
                                <span>•</span>
                                <span>Buffer: 0 drops</span>
                                <span>•</span>
                                <span>Gateway: us-east-vpc-02</span>
                            </div>
                        </div>
                        <!-- High Contrast Precision Sub-Bento Cards -->
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-space-sm">
                            <!-- Optimal Tile -->
                            <div class="bg-surface-container-lowest/90 text-on-surface p-space-md rounded-lg flex flex-col justify-between">
                                <div class="flex items-center justify-between">
                                    <span class="font-label-technical text-label-technical uppercase tracking-wider text-outline">Optimal State</span>
                                    <div class="p-1 rounded bg-secondary-container/40">
                                        <span class="material-symbols-outlined text-secondary text-[18px]" style="font-variation-settings: 'FILL' 1;">verified</span>
                                    </div>
                                </div>
                                <div class="flex items-baseline gap-2 mt-space-sm">
                                    <span class="font-metric-display text-metric-display text-secondary">14</span>
                                    <span class="font-label-code text-label-code text-outline">/ 18 Models</span>
                                </div>
                                <div class="mt-space-xs">
                                    <div class="w-full bg-surface-container-high h-1.5 rounded-full overflow-hidden">
                                        <div class="bg-secondary h-full rounded-full" style="width: 77.7%;"></div>
                                    </div>
                                    <span class="font-label-code text-[10px] text-on-surface-variant block mt-1">77.7% nominal SLA adherence</span>
                                </div>
                            </div>
                            <!-- Warning Tile -->
                            <div class="bg-surface-container-lowest/90 text-on-surface p-space-md rounded-lg flex flex-col justify-between">
                                <div class="flex items-center justify-between">
                                    <span class="font-label-technical text-label-technical uppercase tracking-wider text-outline">Warning / Drift</span>
                                    <div class="p-1 rounded bg-tertiary-container">
                                        <span class="material-symbols-outlined text-tertiary text-[18px]" style="font-variation-settings: 'FILL' 1;">error</span>
                                    </div>
                                </div>
                                <div class="flex items-baseline gap-2 mt-space-sm">
                                    <span class="font-metric-display text-metric-display text-tertiary">3</span>
                                    <span class="font-label-code text-label-code text-outline">Elevated</span>
                                </div>
                                <div class="mt-space-xs">
                                    <span class="font-label-code text-[11px] text-tertiary truncate block">lead_scoring, ltv_v3, nlp_b</span>
                                    <span class="font-label-code text-[10px] text-on-surface-variant block mt-0.5">Feature shift KS &gt; 0.05</span>
                                </div>
                            </div>
                            <!-- Critical Tile -->
                            <div class="bg-surface-container-lowest/90 text-on-surface p-space-md rounded-lg flex flex-col justify-between">
                                <div class="flex items-center justify-between">
                                    <span class="font-label-technical text-label-technical uppercase tracking-wider text-error">Critical Failure</span>
                                    <div class="p-1 rounded bg-error-container">
                                        <span class="material-symbols-outlined text-error text-[18px]" style="font-variation-settings: 'FILL' 1;">report</span>
                                    </div>
                                </div>
                                <div class="flex items-baseline gap-2 mt-space-sm">
                                    <span class="font-metric-display text-metric-display text-error">1</span>
                                    <span class="font-label-code text-label-code text-error">Breach</span>
                                </div>
                                <div class="mt-space-xs">
                                    <span class="font-label-code text-[11px] text-error font-bold block">churn_rf_v2 (INC-4092)</span>
                                    <span class="font-label-code text-[10px] text-on-surface-variant block mt-0.5">F1 SLA breached (-29.8%)</span>
                                </div>
                            </div>
                            <!-- Aggregate Throughput & Ingestion Tile -->
                            <div class="bg-surface-container-lowest/90 text-on-surface p-space-md rounded-lg flex flex-col justify-between">
                                <div class="flex items-center justify-between">
                                    <span class="font-label-technical text-label-technical uppercase tracking-wider text-outline">Global Workload</span>
                                    <div class="p-1 rounded bg-primary-container">
                                        <span class="material-symbols-outlined text-primary text-[18px]">speed</span>
                                    </div>
                                </div>
                                <div class="flex items-baseline gap-2 mt-space-sm">
                                    <span class="font-metric-display text-metric-display text-primary">12.8k</span>
                                    <span class="font-label-code text-label-code text-outline">req/min</span>
                                </div>
                                <div class="flex items-center justify-between mt-space-xs pt-1">
                                    <span class="font-label-code text-[10px] text-on-surface-variant">p95 Fleet Latency:</span>
                                    <span class="font-label-code text-[11px] text-secondary font-bold">29.4ms</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- BENTO SECTION 2: Primary Model Cards Grid -->
                <div class="flex flex-col gap-space-sm">
                    <div class="flex items-center justify-between px-space-xs">
                        <div class="flex items-center gap-space-sm">
                            <span class="font-label-technical text-label-technical uppercase tracking-widest text-outline">PRIMARY SERVING ENDPOINTS</span>
                            <span class="font-label-code text-label-code text-on-surface-variant bg-surface-container px-2 py-0.5 rounded">SORT: SEVERITY DESC</span>
                        </div>
                        <div class="flex items-center gap-space-xs font-label-code text-label-code text-outline">
                            <span>5 displayed</span>
                            <span>•</span>
                            <a class="text-secondary hover:text-primary transition-colors" href="#">View All 18 Registry Endpoints →</a>
                        </div>
                    </div>
                    <!-- Models Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-space-md">
                        <!-- Card 1: churn_rf_v2 (CRITICAL INCIDENT) -->
                        <div class="lg:col-span-2 bg-surface-container-lowest p-space-md rounded-xl flex flex-col justify-between shadow-xl">
                            <div class="flex flex-col gap-space-sm">
                                <!-- Card Header -->
                                <div class="flex flex-wrap items-start justify-between gap-space-sm pb-space-xs">
                                    <div class="flex flex-col">
                                        <div class="flex items-center gap-2">
                                            <span class="w-3 h-3 rounded-full bg-error animate-ping"></span>
                                            <span class="font-headline-md text-headline-md font-bold text-on-surface">churn_rf_v2</span>
                                            <span class="px-2 py-0.5 rounded bg-error-container text-on-error-container font-label-code text-[11px] font-bold">CRITICAL INCIDENT</span>
                                            <span class="px-2 py-0.5 rounded bg-surface-container-high text-outline font-label-code text-[11px]">v2.4.1</span>
                                        </div>
                                        <span class="font-body-sm text-body-sm text-on-surface-variant mt-0.5">Customer Churn Random Forest Classifier · Ingest Feed: CRM-FEED-05</span>
                                    </div>
                                    <div class="text-right">
                                        <span class="font-label-technical text-[10px] text-error uppercase tracking-wider block">INC-4092 TRIAGE</span>
                                        <span class="font-label-code text-label-code text-on-surface-variant">Last eval: 04:18 UTC</span>
                                    </div>
                                </div>
                                <!-- Metrics Row with Inline SVG Sparkline -->
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-space-sm bg-surface-container-low p-space-sm rounded-lg">
                                    <!-- Metric 1: F1 Collapse -->
                                    <div class="flex flex-col justify-between p-2 rounded bg-surface-container-lowest">
                                        <div class="flex items-center justify-between">
                                            <span class="font-label-technical text-[10px] text-outline uppercase tracking-wider">F1 Score (Target ≥ 0.80)</span>
                                            <span class="font-label-code text-[11px] text-error font-bold">Δ -29.8%</span>
                                        </div>
                                        <div class="flex items-baseline gap-2 my-1">
                                            <span class="font-metric-display text-metric-display text-error">0.61</span>
                                            <span class="font-label-code text-[11px] text-outline line-through">0.87 Base</span>
                                        </div>
                                        <!-- Inline Sparkline showing cliff collapse -->
                                        <div class="w-full h-8 mt-1">
                                            <svg class="w-full h-full overflow-visible" preserveaspectratio="none" viewbox="0 0 160 32">
                                                <!-- SLA Threshold Line -->
                                                <line class="text-outline/40" stroke="currentColor" stroke-dasharray="2 2" stroke-width="1" x1="0" x2="160" y1="12" y2="12"></line>
                                                <!-- Metric Trajectory -->
                                                <polyline class="text-error" fill="none" points="0,8 20,8 40,7 60,9 80,8 100,7 115,10 125,28 140,29 160,30" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"></polyline>
                                                <!-- Collapse Pip Marker -->
                                                <circle class="text-error animate-pulse" cx="125" cy="28" fill="currentColor" r="3.5"></circle>
                                            </svg>
                                        </div>
                                        <span class="font-label-code text-[10px] text-error mt-0.5">Drop observed at 04:15 UTC</span>
                                    </div>
                                    <!-- Metric 2: Drift & Statistical KS Fail -->
                                    <div class="flex flex-col justify-between p-2 rounded bg-surface-container-lowest">
                                        <div class="flex items-center justify-between">
                                            <span class="font-label-technical text-[10px] text-outline uppercase tracking-wider">Data Drift Index</span>
                                            <span class="font-label-code text-[11px] text-error font-bold">KS &lt; 0.001</span>
                                        </div>
                                        <div class="flex items-baseline gap-2 my-1">
                                            <span class="font-metric-display text-metric-display text-tertiary">0.74</span>
                                            <span class="font-label-code text-[11px] text-outline">PSI: 0.31</span>
                                        </div>
                                        <div class="flex flex-col gap-1 mt-1">
                                            <div class="flex items-center justify-between text-[10px] font-label-code">
                                                <span class="text-on-surface-variant">KS Drift Threshold:</span>
                                                <span class="text-error font-bold">4 Feats Failed</span>
                                            </div>
                                            <div class="w-full bg-surface-container-high h-1.5 rounded-full overflow-hidden">
                                                <div class="bg-error h-full rounded-full" style="width: 82%;"></div>
                                            </div>
                                        </div>
                                        <span class="font-label-code text-[10px] text-on-surface-variant mt-1">Primary: 'account_age_months'</span>
                                    </div>
                                    <!-- Metric 3: Latency & Request RPM -->
                                    <div class="flex flex-col justify-between p-2 rounded bg-surface-container-lowest">
                                        <div class="flex items-center justify-between">
                                            <span class="font-label-technical text-[10px] text-outline uppercase tracking-wider">Serving Volume</span>
                                            <span class="font-label-code text-[11px] text-secondary font-bold">Stable</span>
                                        </div>
                                        <div class="flex items-baseline gap-2 my-1">
                                            <span class="font-metric-display text-metric-display text-on-surface">1,420</span>
                                            <span class="font-label-code text-label-code text-outline">rpm</span>
                                        </div>
                                        <div class="flex items-center justify-between pt-2">
                                            <span class="font-label-code text-[11px] text-on-surface-variant">p95 Latency:</span>
                                            <span class="font-label-code text-label-code text-secondary font-bold">48ms (healthy)</span>
                                        </div>
                                        <div class="flex items-center justify-between pt-1">
                                            <span class="font-label-code text-[10px] text-outline">Error Rate:</span>
                                            <span class="font-label-code text-[10px] text-secondary">0.02% (HTTP 200)</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- Diagnostic Insight Strip -->
                                <div class="flex items-center gap-space-sm bg-surface-container px-space-sm py-2 rounded font-label-code text-label-code text-on-surface-variant">
                                    <span class="material-symbols-outlined text-tertiary text-[18px]">psychology</span>
                                    <span>Root hypothesis: CRM-FEED-05 delivered null strings for account_age_months &gt; imputing median 0 causing heavy skewed predictions.</span>
                                </div>
                            </div>
                            <!-- Quick Incident Action Footer -->
                            <div class="flex flex-wrap items-center justify-between gap-space-sm pt-space-md mt-space-sm">
                                <div class="flex items-center gap-2">
                                    <button class="px-space-md py-1.5 rounded font-label-code text-label-code bg-primary-container text-primary font-bold hover:bg-surface-container-highest transition-colors flex items-center gap-1.5">
                                        <span class="material-symbols-outlined text-[16px]">troubleshoot</span>
                                        <span>Investigate Drift</span>
                                    </button>
                                    <button class="px-space-md py-1.5 rounded font-label-code text-label-code bg-surface-container text-on-surface hover:bg-surface-container-high transition-colors flex items-center gap-1.5">
                                        <span class="material-symbols-outlined text-[16px]">visibility</span>
                                        <span>View INC-4092</span>
                                    </button>
                                    <button class="px-space-md py-1.5 rounded font-label-code text-label-code bg-surface-container text-on-surface-variant hover:text-on-surface hover:bg-surface-container-high transition-colors flex items-center gap-1.5">
                                        <span class="material-symbols-outlined text-[16px]">terminal</span>
                                        <span>Inspect Logs</span>
                                    </button>
                                </div>
                                <div class="flex items-center gap-2">
                                    <button class="px-space-sm py-1.5 rounded font-label-code text-label-code bg-tertiary-container text-tertiary font-bold hover:bg-tertiary/20 transition-colors flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[16px]">replay</span>
                                        <span>Rollback to v2.4.0</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- Card 2: fraud_detector_nn (OPTIMAL GREEN) -->
                        <div class="bg-surface-container-lowest p-space-md rounded-xl flex flex-col justify-between shadow-md">
                            <div class="flex flex-col gap-space-sm">
                                <div class="flex items-start justify-between">
                                    <div class="flex flex-col">
                                        <div class="flex items-center gap-2">
                                            <span class="w-2.5 h-2.5 rounded-full bg-secondary"></span>
                                            <span class="font-headline-md text-headline-md font-bold text-on-surface">fraud_detector_nn</span>
                                        </div>
                                        <span class="font-body-sm text-body-sm text-on-surface-variant">Neural Network · v3.1.0 · Tier-0 Edge</span>
                                    </div>
                                    <span class="px-2 py-0.5 rounded bg-secondary-container/40 text-secondary font-label-code text-[11px] font-bold">OPTIMAL</span>
                                </div>
                                <!-- Metrics Visual -->
                                <div class="flex flex-col gap-space-sm bg-surface-container-low p-space-sm rounded-lg">
                                    <div class="flex items-center justify-between">
                                        <div class="flex flex-col">
                                            <span class="font-label-technical text-[10px] text-outline uppercase tracking-wider">F1 Performance</span>
                                            <div class="flex items-baseline gap-1.5">
                                                <span class="font-metric-display text-metric-display text-secondary">0.94</span>
                                                <span class="font-label-code text-[11px] text-outline">Base: 0.92</span>
                                            </div>
                                        </div>
                                        <!-- Flat steady sparkline -->
                                        <div class="w-24 h-6">
                                            <svg class="w-full h-full" preserveaspectratio="none" viewbox="0 0 100 24">
                                                <polyline class="text-secondary" fill="none" points="0,14 15,12 30,13 45,11 60,12 75,10 90,11 100,10" stroke="currentColor" stroke-linecap="round" stroke-width="2"></polyline>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-2 pt-1 font-label-code text-[11px]">
                                        <div class="flex flex-col bg-surface-container-lowest p-2 rounded">
                                            <span class="text-outline text-[10px]">THROUGHPUT</span>
                                            <span class="text-on-surface font-bold mt-0.5">3,850 rpm</span>
                                        </div>
                                        <div class="flex flex-col bg-surface-container-lowest p-2 rounded">
                                            <span class="text-outline text-[10px]">p95 LATENCY</span>
                                            <span class="text-secondary font-bold mt-0.5">18ms</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between font-label-code text-[11px] pt-1 px-1">
                                        <span class="text-on-surface-variant">Data Drift Score:</span>
                                        <span class="text-secondary font-bold">0.04 (Nominal)</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between pt-space-sm font-label-code text-label-code">
                                <span class="text-outline text-[11px]">Worker nodes: 8 active</span>
                                <button class="text-secondary hover:text-primary transition-colors flex items-center gap-1">
                                    <span>Diagnostics</span>
                                    <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                                </button>
                            </div>
                        </div>
                        <!-- Card 3: lead_scoring_xgb (WARNING AMBER) -->
                        <div class="bg-surface-container-lowest p-space-md rounded-xl flex flex-col justify-between shadow-md">
                            <div class="flex flex-col gap-space-sm">
                                <div class="flex items-start justify-between">
                                    <div class="flex flex-col">
                                        <div class="flex items-center gap-2">
                                            <span class="w-2.5 h-2.5 rounded-full bg-tertiary animate-pulse"></span>
                                            <span class="font-headline-md text-headline-md font-bold text-on-surface">lead_scoring_xgb</span>
                                        </div>
                                        <span class="font-body-sm text-body-sm text-on-surface-variant">XGBoost v1.9.4 · Inbound Funnel Pipeline</span>
                                    </div>
                                    <span class="px-2 py-0.5 rounded bg-tertiary-container text-tertiary font-label-code text-[11px] font-bold">WARNING</span>
                                </div>
                                <!-- Metrics Visual -->
                                <div class="flex flex-col gap-space-sm bg-surface-container-low p-space-sm rounded-lg">
                                    <div class="flex items-center justify-between">
                                        <div class="flex flex-col">
                                            <span class="font-label-technical text-[10px] text-outline uppercase tracking-wider">F1 Score (Threshold 0.80)</span>
                                            <div class="flex items-baseline gap-1.5">
                                                <span class="font-metric-display text-metric-display text-tertiary">0.79</span>
                                                <span class="font-label-code text-[11px] text-tertiary">Δ -3.6%</span>
                                            </div>
                                        </div>
                                        <!-- Negative trend sparkline -->
                                        <div class="w-24 h-6">
                                            <svg class="w-full h-full" preserveaspectratio="none" viewbox="0 0 100 24">
                                                <polyline class="text-tertiary" fill="none" points="0,6 20,8 40,9 60,13 80,16 100,19" stroke="currentColor" stroke-linecap="round" stroke-width="2"></polyline>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="bg-surface-container-lowest p-2 rounded flex flex-col gap-1">
                                        <div class="flex items-center justify-between font-label-code text-[11px]">
                                            <span class="text-outline">Drift Feature:</span>
                                            <span class="text-tertiary font-bold">'last_touch_channel'</span>
                                        </div>
                                        <div class="flex items-center justify-between font-label-code text-[10px] text-on-surface-variant">
                                            <span>620 rpm</span>
                                            <span>p95: 32ms</span>
                                            <span>PSI: 0.19</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between pt-space-sm font-label-code text-label-code">
                                <span class="text-tertiary text-[11px]">Auto-retrain queue candidate</span>
                                <button class="text-tertiary hover:underline flex items-center gap-1 font-bold">
                                    <span>Inspect Feature Drift</span>
                                    <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                                </button>
                            </div>
                        </div>
                        <!-- Card 4: recommendation_transformer_v4 (OPTIMAL) -->
                        <div class="bg-surface-container-lowest p-space-md rounded-xl flex flex-col justify-between shadow-md">
                            <div class="flex flex-col gap-space-sm">
                                <div class="flex items-start justify-between">
                                    <div class="flex flex-col">
                                        <div class="flex items-center gap-2">
                                            <span class="w-2.5 h-2.5 rounded-full bg-secondary"></span>
                                            <span class="font-headline-md text-headline-md font-bold text-on-surface truncate">recommendation_transformer_v4</span>
                                        </div>
                                        <span class="font-body-sm text-body-sm text-on-surface-variant">Transformer Multi-Modal Recommender</span>
                                    </div>
                                    <span class="px-2 py-0.5 rounded bg-secondary-container/40 text-secondary font-label-code text-[11px] font-bold">OPTIMAL</span>
                                </div>
                                <div class="flex flex-col gap-space-sm bg-surface-container-low p-space-sm rounded-lg">
                                    <div class="flex items-center justify-between">
                                        <div class="flex flex-col">
                                            <span class="font-label-technical text-[10px] text-outline uppercase tracking-wider">Hit-Rate Accuracy</span>
                                            <div class="flex items-baseline gap-1.5">
                                                <span class="font-metric-display text-metric-display text-secondary">88.4%</span>
                                                <span class="font-label-code text-[11px] text-outline">+1.2%</span>
                                            </div>
                                        </div>
                                        <div class="flex flex-col items-end font-label-code text-[11px]">
                                            <span class="text-on-surface font-bold">5,100 rpm</span>
                                            <span class="text-outline">p95: 65ms</span>
                                        </div>
                                    </div>
                                    <div class="w-full bg-surface-container-high h-1.5 rounded-full overflow-hidden">
                                        <div class="bg-secondary h-full rounded-full" style="width: 88.4%;"></div>
                                    </div>
                                    <span class="font-label-code text-[10px] text-on-surface-variant">Cluster GPU util: 62% · Memory: 4.2GB / 16GB</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between pt-space-sm font-label-code text-label-code">
                                <span class="text-outline text-[11px]">Serving Node: g4dn.2xlarge</span>
                                <button class="text-secondary hover:text-primary transition-colors flex items-center gap-1">
                                    <span>View Graph</span>
                                    <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                                </button>
                            </div>
                        </div>
                        <!-- Card 5: credit_risk_ensemble_v1 (DISCONNECTED / OFFLINE TEST) -->
                        <div class="bg-surface-container-lowest p-space-md rounded-xl flex flex-col justify-between shadow-md">
                            <div class="flex flex-col gap-space-sm">
                                <div class="flex items-start justify-between">
                                    <div class="flex flex-col">
                                        <div class="flex items-center gap-2">
                                            <span class="w-2.5 h-2.5 rounded-full bg-outline"></span>
                                            <span class="font-headline-md text-headline-md font-bold text-outline">credit_risk_ensemble_v1</span>
                                        </div>
                                        <span class="font-body-sm text-body-sm text-outline">Credit Scoring Ensemble · VPC DMZ</span>
                                    </div>
                                    <span class="px-2 py-0.5 rounded bg-surface-container-high text-outline font-label-code text-[11px] font-bold">DISCONNECTED</span>
                                </div>
                                <div class="flex flex-col gap-2 bg-surface-container-low p-space-sm rounded-lg">
                                    <div class="flex items-center gap-2 text-outline">
                                        <span class="material-symbols-outlined text-[20px]">sensors_off</span>
                                        <span class="font-label-code text-label-code">Agent Heartbeat Lost</span>
                                    </div>
                                    <p class="font-body-sm text-body-sm text-outline leading-tight">
                                        Last telemetry received 48m ago. Edge container may have been evicted during cluster maintenance window.
                                    </p>
                                    <div class="flex items-center justify-between font-label-code text-[10px] text-outline pt-1">
                                        <span>Host: ip-10-0-44-12</span>
                                        <span>Port: :8081</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between pt-space-sm font-label-code text-label-code">
                                <button class="px-2.5 py-1 rounded bg-surface-container text-on-surface hover:bg-surface-container-high transition-colors text-[11px]">
                                    Ping Telemetry Daemon
                                </button>
                                <button class="text-outline hover:text-on-surface transition-colors flex items-center gap-1 text-[11px]">
                                    <span>Reboot Pod</span>
                                    <span class="material-symbols-outlined text-[14px]">refresh</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- BENTO SECTION 3 & 4: Active Alerts Feed & Linked Pipelines Topology -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-md">
                    <!-- Active Alerts Live Ticker Bento (7 Cols) -->
                    <div class="lg:col-span-7 bg-surface-container-lowest p-space-md rounded-xl flex flex-col justify-between shadow-md">
                        <div class="flex flex-col gap-space-sm">
                            <div class="flex items-center justify-between pb-space-xs">
                                <div class="flex items-center gap-space-sm">
                                    <span class="material-symbols-outlined text-tertiary text-[20px]">notifications_active</span>
                                    <div>
                                        <h3 class="font-headline-md text-headline-md font-bold text-on-surface">ACTIVE DRIFT &amp; INCIDENT STREAM</h3>
                                        <p class="font-label-technical text-label-technical uppercase tracking-wider text-outline">Automated Telemetry Triggers · Last 6 Hours</p>
                                    </div>
                                </div>
                                <span class="font-label-code text-label-code text-outline bg-surface-container px-2 py-0.5 rounded">4 Events Buffered</span>
                            </div>
                            <!-- Alerts List -->
                            <div class="flex flex-col gap-2 mt-1">
                                <!-- Alert 1 (Critical) -->
                                <div class="p-space-sm rounded-lg bg-surface-container-low flex flex-col md:flex-row md:items-center justify-between gap-space-xs hover:bg-surface-container transition-colors">
                                    <div class="flex items-start gap-space-sm">
                                        <span class="w-2 h-2 rounded-full bg-error mt-1.5 shrink-0"></span>
                                        <div class="flex flex-col">
                                            <div class="flex items-center gap-2">
                                                <span class="font-label-code text-[11px] font-bold text-error bg-error-container/40 px-1.5 py-0.5 rounded">CRITICAL</span>
                                                <span class="font-label-code text-[11px] text-outline">04:18 UTC</span>
                                                <span class="font-label-code text-label-code font-bold text-on-surface">churn_rf_v2</span>
                                            </div>
                                            <span class="font-body-sm text-body-sm text-on-surface mt-0.5">F1 Accuracy Drop (-29.8% below contractual SLA threshold 0.80)</span>
                                        </div>
                                    </div>
                                    <button class="px-space-sm py-1 rounded font-label-code text-[11px] bg-error-container text-on-error-container font-bold hover:bg-error transition-colors shrink-0 self-end md:self-center">
                                        Triage Incident
                                    </button>
                                </div>
                                <!-- Alert 2 (Warning) -->
                                <div class="p-space-sm rounded-lg bg-surface-container-low flex flex-col md:flex-row md:items-center justify-between gap-space-xs hover:bg-surface-container transition-colors">
                                    <div class="flex items-start gap-space-sm">
                                        <span class="w-2 h-2 rounded-full bg-tertiary mt-1.5 shrink-0"></span>
                                        <div class="flex flex-col">
                                            <div class="flex items-center gap-2">
                                                <span class="font-label-code text-[11px] font-bold text-tertiary bg-tertiary-container/40 px-1.5 py-0.5 rounded">WARNING</span>
                                                <span class="font-label-code text-[11px] text-outline">03:52 UTC</span>
                                                <span class="font-label-code text-label-code font-bold text-on-surface">churn_rf_v2</span>
                                            </div>
                                            <span class="font-body-sm text-body-sm text-on-surface mt-0.5">Population Stability Index (PSI &gt; 0.25) shift on feature 'account_age_months'</span>
                                        </div>
                                    </div>
                                    <button class="px-space-sm py-1 rounded font-label-code text-[11px] bg-surface-container text-on-surface hover:bg-surface-container-high transition-colors shrink-0 self-end md:self-center">
                                        Inspect Distribution
                                    </button>
                                </div>
                                <!-- Alert 3 (Warning) -->
                                <div class="p-space-sm rounded-lg bg-surface-container-low flex flex-col md:flex-row md:items-center justify-between gap-space-xs hover:bg-surface-container transition-colors">
                                    <div class="flex items-start gap-space-sm">
                                        <span class="w-2 h-2 rounded-full bg-tertiary mt-1.5 shrink-0"></span>
                                        <div class="flex flex-col">
                                            <div class="flex items-center gap-2">
                                                <span class="font-label-code text-[11px] font-bold text-tertiary bg-tertiary-container/40 px-1.5 py-0.5 rounded">WARNING</span>
                                                <span class="font-label-code text-[11px] text-outline">02:11 UTC</span>
                                                <span class="font-label-code text-label-code font-bold text-on-surface">lead_scoring_xgb</span>
                                            </div>
                                            <span class="font-body-sm text-body-sm text-on-surface mt-0.5">Prediction Distribution Kolmogorov-Smirnov Shift detected (p = 0.038)</span>
                                        </div>
                                    </div>
                                    <button class="px-space-sm py-1 rounded font-label-code text-[11px] bg-surface-container text-on-surface hover:bg-surface-container-high transition-colors shrink-0 self-end md:self-center">
                                        Compare Baseline
                                    </button>
                                </div>
                                <!-- Alert 4 (Info) -->
                                <div class="p-space-sm rounded-lg bg-surface-container-low flex flex-col md:flex-row md:items-center justify-between gap-space-xs hover:bg-surface-container transition-colors">
                                    <div class="flex items-start gap-space-sm">
                                        <span class="w-2 h-2 rounded-full bg-secondary mt-1.5 shrink-0"></span>
                                        <div class="flex flex-col">
                                            <div class="flex items-center gap-2">
                                                <span class="font-label-code text-[11px] font-bold text-secondary bg-secondary-container/30 px-1.5 py-0.5 rounded">INFO</span>
                                                <span class="font-label-code text-[11px] text-outline">00:04 UTC</span>
                                                <span class="font-label-code text-label-code font-bold text-on-surface">SYS-AI-04 Registry</span>
                                            </div>
                                            <span class="font-body-sm text-body-sm text-on-surface mt-0.5">Deployment v2.4.1 tagged for canary validation in SYS-AI-04</span>
                                        </div>
                                    </div>
                                    <span class="font-label-code text-[11px] text-outline shrink-0">Acknowledged</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between pt-space-sm mt-space-sm font-label-code text-label-code">
                            <span class="text-outline text-[11px]">Webhook destinations: #ops-ai-critical, PagerDuty (Tier-1)</span>
                            <a class="text-secondary hover:text-primary transition-colors" href="#">Configure Alert Threshold Rules →</a>
                        </div>
                    </div>
                    <!-- System Health Strip for Linked Pipelines (5 Cols) -->
                    <div class="lg:col-span-5 bg-surface-container-lowest p-space-md rounded-xl flex flex-col justify-between shadow-md">
                        <div class="flex flex-col gap-space-sm">
                            <div class="flex items-center justify-between pb-space-xs">
                                <div class="flex items-center gap-space-sm">
                                    <span class="material-symbols-outlined text-secondary text-[20px]">hub</span>
                                    <div>
                                        <h3 class="font-headline-md text-headline-md font-bold text-on-surface">PIPELINE DEPENDENCIES</h3>
                                        <p class="font-label-technical text-label-technical uppercase tracking-wider text-outline">Upstream Ingest &amp; Downstream Serving</p>
                                    </div>
                                </div>
                                <span class="font-label-code text-[11px] text-tertiary bg-tertiary-container/30 px-2 py-0.5 rounded font-bold">1 Anomaly</span>
                            </div>
                            <!-- Dependency Nodes -->
                            <div class="flex flex-col gap-2 mt-1">
                                <!-- Node 1: Data Lake -->
                                <div class="p-space-sm rounded bg-surface-container-low flex flex-col gap-1">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <span class="w-2 h-2 rounded-full bg-secondary"></span>
                                            <span class="font-label-code text-label-code font-bold text-on-surface">SYS-AI-02 Data Lake</span>
                                        </div>
                                        <span class="font-label-code text-[10px] text-secondary font-bold bg-secondary-container/30 px-1.5 py-0.5 rounded">HEALTHY</span>
                                    </div>
                                    <div class="flex items-center justify-between font-label-code text-[11px] text-on-surface-variant">
                                        <span>Kafka stream ingesting 12.4 MB/s</span>
                                        <span class="text-outline">Lag: 42ms</span>
                                    </div>
                                </div>
                                <!-- Node 2: CRM Ingestion (ANOMALY) -->
                                <div class="p-space-sm rounded bg-surface-container-low flex flex-col gap-1">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <span class="w-2 h-2 rounded-full bg-tertiary animate-ping"></span>
                                            <span class="font-label-code text-label-code font-bold text-tertiary">SYS05 Enterprise CRM Ingestion</span>
                                        </div>
                                        <span class="font-label-code text-[10px] text-tertiary font-bold bg-tertiary-container px-1.5 py-0.5 rounded">SCHEMA ANOMALY</span>
                                    </div>
                                    <p class="font-body-sm text-[11px] text-tertiary leading-snug">
                                        API schema payload updated without notification at 03:45 UTC. Suspected source of churn model feature drift.
                                    </p>
                                </div>
                                <!-- Node 3: Finance Billing Pipeline -->
                                <div class="p-space-sm rounded bg-surface-container-low flex flex-col gap-1">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <span class="w-2 h-2 rounded-full bg-secondary"></span>
                                            <span class="font-label-code text-label-code font-bold text-on-surface">SYS07 Finance Billing Pipeline</span>
                                        </div>
                                        <span class="font-label-code text-[10px] text-secondary font-bold bg-secondary-container/30 px-1.5 py-0.5 rounded">NORMAL</span>
                                    </div>
                                    <div class="flex items-center justify-between font-label-code text-[11px] text-on-surface-variant">
                                        <span>Webhook response time: 14ms</span>
                                        <span class="text-outline">Loss: 0.00%</span>
                                    </div>
                                </div>
                                <!-- Node 4: Model Registry -->
                                <div class="p-space-sm rounded bg-surface-container-low flex flex-col gap-1">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <span class="w-2 h-2 rounded-full bg-secondary"></span>
                                            <span class="font-label-code text-label-code font-bold text-on-surface">SYS-AI-04 Model Registry</span>
                                        </div>
                                        <span class="font-label-code text-[10px] text-secondary font-bold bg-secondary-container/30 px-1.5 py-0.5 rounded">READY</span>
                                    </div>
                                    <div class="flex items-center justify-between font-label-code text-[11px] text-on-surface-variant">
                                        <span>Canary rollback snapshot available:</span>
                                        <span class="font-bold text-primary">churn_rf_v1_backup</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between pt-space-sm mt-space-sm font-label-code text-label-code">
                            <span class="text-outline text-[11px]">Mesh: Istio / Envoy v1.21</span>
                            <button class="text-secondary hover:text-primary transition-colors flex items-center gap-1">
                                <span>Inspect Ingestion DAG</span>
                                <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                // Simple interactive micro-logic for SOC Telemetry simulator
                document.addEventListener('DOMContentLoaded', () => {
                    const counterEl = document.getElementById('telemetry-counter');
                    const syncBtn = document.getElementById('btn-manual-sync');
                    const muteBtn = document.getElementById('btn-mute-alert');
                    let secondsAgo = 2;

                    const interval = setInterval(() => {
                        secondsAgo++;
                        if (counterEl) {
                            counterEl.textContent = `${secondsAgo}s ago`;
                        }
                        if (secondsAgo >= 5) {
                            secondsAgo = 0;
                            if (counterEl) {
                                counterEl.textContent = '0s ago (synced)';
                            }
                        }
                    }, 1000);

                    if (syncBtn) {
                        syncBtn.addEventListener('click', () => {
                            secondsAgo = 0;
                            if (counterEl) {
                                counterEl.textContent = '0s ago (force synced)';
                            }
                        });
                    }

                    if (muteBtn) {
                        muteBtn.addEventListener('click', () => {
                            muteBtn.textContent = 'Alert Muted (29:59)';
                            muteBtn.classList.add('opacity-60');
                        });
                    }
                });
            </script>
        </main>
    </div>
</body>

</html>