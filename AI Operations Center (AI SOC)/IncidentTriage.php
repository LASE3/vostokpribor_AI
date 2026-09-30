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
            <nav class="flex flex-col px-space-xs py-space-sm gap-space-xs" data-active-classes="bg-primary-container text-on-surface border-l-2 border-tertiary"><a class="flex items-center justify-between px-space-md py-space-sm rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="project-hub" href="#"><span class="font-label-technical text-label-technical">SYS-AI-01: Objectives Hub</span><span class="font-label-code text-label-code text-outline">v1.2</span></a><a class="flex items-center justify-between px-space-md py-space-sm rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="data-lake" href="#"><span class="font-label-technical text-label-technical">SYS-AI-02: Data Lake Lakeflow</span><span class="font-label-code text-label-code text-outline">4.8TB</span></a><a class="flex items-center justify-between px-space-md py-space-sm rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="model-workbench" href="#"><span class="font-label-technical text-label-technical">SYS-AI-03: Model Workbench</span><span class="font-label-code text-label-code text-outline">READY</span></a><a class="flex items-center justify-between px-space-md py-space-sm rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="model-registry" href="#"><span class="font-label-technical text-label-technical">SYS-AI-04: Registry &amp; CI/CD</span><span class="font-label-code text-label-code text-outline">PROD</span></a><a class="flex items-center justify-between px-space-md py-space-sm rounded bg-primary-container text-on-surface hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="soc-overview" href="#">
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
                <nav class="flex items-center gap-space-md shrink-0 h-full" data-active-classes="text-tertiary border-b-2 border-tertiary font-semibold"><a class="text-on-surface-variant hover:text-on-surface h-full flex items-center font-label-code text-label-code transition-colors" data-path="soc-overview" href="#">Overview</a><a aria-current="page" class="h-full flex items-center transition-colors text-tertiary border-b-2 border-tertiary font-semibold" data-path="alerts-center" href="#">Alerts (3)</a><a class="text-on-surface-variant hover:text-on-surface h-full flex items-center font-label-code text-label-code transition-colors" data-path="model-monitoring" href="#">Monitoring</a><a class="text-on-surface-variant hover:text-on-surface h-full flex items-center font-label-code text-label-code transition-colors" data-path="drift-workspace" href="#">Drift</a><a class="text-on-surface-variant hover:text-on-surface h-full flex items-center font-label-code text-label-code transition-colors" data-path="active-incident" href="#">Incident INC-4092</a><a class="text-on-surface-variant hover:text-on-surface h-full flex items-center font-label-code text-label-code transition-colors" data-path="incident-report" href="#">Post-Mortem</a><a class="text-on-surface-variant hover:text-on-surface h-full flex items-center font-label-code text-label-code transition-colors" data-path="alert-rules-config" href="#">Config</a><a class="text-on-surface-variant hover:text-on-surface h-full flex items-center font-label-code text-label-code transition-colors" data-path="wall-display" href="#">Wall Display</a></nav>
            </div>
        </header>
        <main class="relative pt-28 w-full p-gutter-desktop bg-transparent">
            <div class="flex flex-col w-full gap-space-lg">
                <!-- TOP BREADCRUMB & CONSOLE META BAR -->
                <div class="flex flex-wrap items-center justify-between gap-space-sm bg-surface-container-low px-space-md py-space-xs rounded-lg">
                    <div class="flex items-center gap-space-xs">
                        <span class="material-symbols-outlined text-tertiary text-[18px]">emergency_home</span>
                        <span class="font-label-technical text-label-technical text-outline uppercase tracking-wider">SYS-AI-05</span>
                        <span class="font-label-code text-label-code text-outline-variant">/</span>
                        <span class="font-label-technical text-label-technical text-secondary uppercase tracking-wider">Alerts Center</span>
                        <span class="font-label-code text-label-code text-outline-variant">/</span>
                        <span class="font-label-technical text-label-technical text-on-surface font-semibold uppercase tracking-wider">Active Feed &amp; Queue</span>
                    </div>
                    <div class="flex items-center gap-space-md">
                        <div class="flex items-center gap-space-xs font-label-code text-label-code text-on-surface-variant">
                            <span class="w-2 h-2 rounded-full bg-error animate-ping"></span>
                            <span class="text-error font-bold">1 LIVE BREACH</span>
                        </div>
                        <div class="h-3 w-px bg-outline-variant"></div>
                        <div class="font-label-code text-label-code text-outline">FEED: <span class="text-primary font-bold">WEBSOCKET_OPEN</span> [sync: 250ms]</div>
                        <div class="h-3 w-px bg-outline-variant"></div>
                        <button class="flex items-center gap-1 font-label-code text-[11px] text-tertiary hover:text-tertiary-fixed transition-colors">
                            <span class="material-symbols-outlined text-[14px]">tune</span>
                            <span>SLO PARAMS</span>
                        </button>
                    </div>
                </div>
                <!-- BENTO METRIC STRIP -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-space-md">
                    <!-- Open Alerts -->
                    <div class="relative overflow-hidden bg-surface-container p-space-md rounded-xl flex flex-col justify-between">
                        <div class="absolute -right-4 -bottom-4 w-28 h-28 bg-error-container/20 rounded-full blur-xl pointer-events-none"></div>
                        <div class="flex items-start justify-between">
                            <div>
                                <div class="font-label-technical text-label-technical text-outline uppercase tracking-widest">Active Alerts</div>
                                <div class="font-metric-display text-metric-display text-on-surface mt-space-xs flex items-baseline gap-2">
                                    <span>04</span>
                                    <span class="font-label-code text-label-code text-error font-normal">[1 CRIT]</span>
                                </div>
                            </div>
                            <div class="p-2 rounded bg-error-container text-on-error-container flex items-center justify-center">
                                <span class="material-symbols-outlined text-[20px]">warning</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-1.5 mt-space-md font-label-code text-[11px]">
                            <span class="px-1.5 py-0.5 rounded bg-error/20 text-error font-bold">1 P1</span>
                            <span class="px-1.5 py-0.5 rounded bg-tertiary-container text-tertiary font-bold">2 P2</span>
                            <span class="px-1.5 py-0.5 rounded bg-surface-container-high text-on-surface-variant font-bold">1 P3</span>
                            <span class="text-outline text-[10px] ml-auto">10 cleared / 24h</span>
                        </div>
                    </div>
                    <!-- MTTD -->
                    <div class="relative overflow-hidden bg-surface-container p-space-md rounded-xl flex flex-col justify-between">
                        <div class="flex items-start justify-between">
                            <div>
                                <div class="font-label-technical text-label-technical text-outline uppercase tracking-widest">Mean Time to Detect (MTTD)</div>
                                <div class="font-metric-display text-metric-display text-secondary mt-space-xs flex items-baseline gap-1">
                                    <span>3.2</span>
                                    <span class="font-headline-md text-headline-md font-normal text-on-surface-variant">min</span>
                                </div>
                            </div>
                            <div class="p-2 rounded bg-secondary-container text-on-secondary-container flex items-center justify-center">
                                <span class="material-symbols-outlined text-[20px]">radar</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between mt-space-md">
                            <div class="flex items-center gap-1 font-label-code text-label-code text-secondary">
                                <span class="material-symbols-outlined text-[14px]">arrow_downward</span>
                                <span>-42s vs Target SLA (4.0m)</span>
                            </div>
                            <div class="w-16 h-2 bg-surface-container-highest rounded-full overflow-hidden">
                                <div class="h-full bg-secondary rounded-full" style="width: 80%"></div>
                            </div>
                        </div>
                    </div>
                    <!-- MTTA -->
                    <div class="relative overflow-hidden bg-surface-container p-space-md rounded-xl flex flex-col justify-between">
                        <div class="flex items-start justify-between">
                            <div>
                                <div class="font-label-technical text-label-technical text-outline uppercase tracking-widest">Mean Time to Ack (MTTA)</div>
                                <div class="font-metric-display text-metric-display text-tertiary mt-space-xs flex items-baseline gap-1">
                                    <span>4.1</span>
                                    <span class="font-headline-md text-headline-md font-normal text-on-surface-variant">min</span>
                                </div>
                            </div>
                            <div class="p-2 rounded bg-tertiary-container text-on-tertiary-container flex items-center justify-center">
                                <span class="material-symbols-outlined text-[20px]">timer</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between mt-space-md font-label-code text-label-code">
                            <span class="text-tertiary flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">check_circle</span>
                                <span>Target ≤ 5.0m</span>
                            </span>
                            <span class="text-outline">P95: 6.8m</span>
                        </div>
                    </div>
                    <!-- Duty Watch Roster -->
                    <div class="relative overflow-hidden bg-surface-container p-space-md rounded-xl flex flex-col justify-between">
                        <div class="flex items-start justify-between">
                            <div>
                                <div class="font-label-technical text-label-technical text-outline uppercase tracking-widest">On-Duty Telemetry Ops</div>
                                <div class="font-headline-md text-headline-md text-on-surface mt-space-xs">2 Specialists</div>
                            </div>
                            <span class="px-2 py-0.5 rounded text-[10px] font-label-code font-bold bg-primary-container text-primary">WATCH-B</span>
                        </div>
                        <div class="flex items-center gap-space-sm mt-space-sm pt-space-xs">
                            <div class="flex -space-x-2">
                                <div class="w-7 h-7 rounded-full bg-primary flex items-center justify-center text-on-primary font-label-code text-[11px] font-bold">AV</div>
                                <div class="w-7 h-7 rounded-full bg-secondary-container flex items-center justify-center text-on-secondary font-label-code text-[11px] font-bold">ER</div>
                            </div>
                            <div class="flex flex-col min-w-0">
                                <span class="font-label-code text-[11px] text-on-surface truncate">Alexei V. (Primary L3)</span>
                                <span class="font-label-technical text-[10px] text-outline truncate">Dr. Romanova (Sr. Lead)</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- CONTROL TOOLBAR: SEARCH & FILTERS -->
                <div class="flex flex-col gap-space-sm bg-surface-container-low p-space-md rounded-xl">
                    <div class="flex flex-wrap items-center justify-between gap-space-md">
                        <!-- Search & Model Dropdown -->
                        <div class="flex flex-wrap items-center gap-space-sm flex-1">
                            <div class="relative min-w-[280px] max-w-md w-full">
                                <span class="material-symbols-outlined absolute left-3 top-2.5 text-outline text-[18px]">search</span>
                                <input class="w-full bg-surface-container text-on-surface font-label-code text-label-code pl-9 pr-14 py-2 rounded-lg outline-none focus:bg-surface-container-high transition-all" id="alert-search" placeholder="Filter alerts by key, model, or metric tag..." type="text" />
                                <span class="absolute right-2.5 top-2 font-label-code text-[10px] text-outline bg-surface-container-highest px-1.5 py-0.5 rounded">Ctrl+K</span>
                            </div>
                            <!-- Filter Select -->
                            <div class="relative">
                                <select class="appearance-none bg-surface-container text-on-surface font-label-code text-label-code px-3 py-2 pr-8 rounded-lg outline-none cursor-pointer hover:bg-surface-container-high transition-colors">
                                    <option value="all">Model: All Deployments (6)</option>
                                    <option selected="" value="churn_rf_v2">Model: churn_rf_v2 (v2.4.1)</option>
                                    <option value="lead_scoring_xgb">Model: lead_scoring_xgb</option>
                                    <option value="fraud_detector_nn">Model: fraud_detector_nn</option>
                                </select>
                                <span class="material-symbols-outlined absolute right-2 top-2.5 text-outline pointer-events-none text-[18px]">expand_more</span>
                            </div>
                            <div class="relative">
                                <select class="appearance-none bg-surface-container text-on-surface font-label-code text-label-code px-3 py-2 pr-8 rounded-lg outline-none cursor-pointer hover:bg-surface-container-high transition-colors">
                                    <option selected="" value="open">Queue: Open &amp; Investigating</option>
                                    <option value="resolved">Queue: Resolved (Last 24h)</option>
                                    <option value="all">Queue: All Historical</option>
                                </select>
                                <span class="material-symbols-outlined absolute right-2 top-2.5 text-outline pointer-events-none text-[18px]">tune</span>
                            </div>
                        </div>
                        <!-- Bulk Actions Strip -->
                        <div class="flex items-center gap-space-xs">
                            <button class="flex items-center gap-1.5 px-space-md py-2 bg-primary text-on-primary rounded-lg font-label-technical text-label-technical tracking-wider uppercase font-semibold hover:bg-primary-fixed-dim transition-all shadow-sm" id="btn-ack-selected">
                                <span class="material-symbols-outlined text-[16px]">done_all</span>
                                <span>Acknowledge (2)</span>
                            </button>
                            <button class="flex items-center gap-1 px-3 py-2 bg-surface-container text-on-surface-variant rounded-lg font-label-technical text-label-technical uppercase tracking-wider hover:bg-surface-container-high hover:text-on-surface transition-colors">
                                <span class="material-symbols-outlined text-[16px]">person_add</span>
                                <span class="hidden sm:inline">Assign to Me</span>
                            </button>
                            <button class="flex items-center gap-1 px-3 py-2 bg-tertiary-container text-tertiary rounded-lg font-label-technical text-label-technical uppercase tracking-wider hover:bg-surface-container-high transition-colors">
                                <span class="material-symbols-outlined text-[16px]">merge</span>
                                <span class="hidden md:inline">Bundle Incident</span>
                            </button>
                            <button class="p-2 bg-surface-container text-on-surface-variant hover:text-on-surface rounded-lg transition-colors" title="Export Telemetry Log">
                                <span class="material-symbols-outlined text-[18px]">download</span>
                            </button>
                        </div>
                    </div>
                    <!-- Category Filter Pills -->
                    <div class="flex flex-wrap items-center gap-1.5 pt-space-xs">
                        <span class="font-label-technical text-[10px] text-outline uppercase tracking-widest mr-1">Views:</span>
                        <button class="px-2.5 py-1 rounded-full font-label-code text-[11px] bg-surface-container-high text-on-surface font-semibold flex items-center gap-1">
                            <span>All Alerts</span>
                            <span class="text-outline text-[10px]">14</span>
                        </button>
                        <button class="px-2.5 py-1 rounded-full font-label-code text-[11px] bg-error-container text-on-error-container font-semibold flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-error animate-pulse"></span>
                            <span>Critical &amp; High</span>
                            <span class="text-[10px] bg-error text-surface px-1 rounded-full">3 Active</span>
                        </button>
                        <button class="px-2.5 py-1 rounded-full font-label-code text-[11px] bg-surface-container text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-colors flex items-center gap-1">
                            <span>Model Accuracy Drops</span>
                            <span class="text-tertiary font-bold">2</span>
                        </button>
                        <button class="px-2.5 py-1 rounded-full font-label-code text-[11px] bg-surface-container text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-colors flex items-center gap-1">
                            <span>Data Drift (KS / PSI)</span>
                            <span class="text-secondary font-bold">3</span>
                        </button>
                        <button class="px-2.5 py-1 rounded-full font-label-code text-[11px] bg-surface-container text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-colors flex items-center gap-1">
                            <span>Latency &amp; Ingestion</span>
                            <span class="text-outline">1</span>
                        </button>
                        <button class="ml-auto font-label-code text-[11px] text-secondary hover:underline flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]">refresh</span>
                            <span>Auto-refresh: 15s</span>
                        </button>
                    </div>
                </div>
                <!-- MAIN DUAL-PANEL WORKSPACE: TABLE + PREVIEW DRAWER -->
                <div class="grid grid-cols-1 xl:grid-cols-12 gap-space-md items-start">
                    <!-- DATA TABLE COLUMN -->
                    <div class="xl:col-span-8 flex flex-col gap-space-xs">
                        <!-- Table Header & Select All -->
                        <div class="flex items-center justify-between px-space-md py-space-xs bg-surface-container-low rounded-t-lg font-label-technical text-label-technical text-outline uppercase tracking-wider">
                            <div class="flex items-center gap-space-md">
                                <input checked="" class="w-4 h-4 rounded bg-surface-container-highest checked:bg-primary accent-primary cursor-pointer" type="checkbox" />
                                <span>Priority &amp; Alert Identity</span>
                            </div>
                            <div class="flex items-center gap-8">
                                <span class="hidden md:inline">Trigger Telemetry</span>
                                <span>Assignee &amp; State</span>
                            </div>
                        </div>
                        <!-- ROW 1: CRITICAL P1 (ALT-8812) -->
                        <div class="group relative bg-surface-container hover:bg-surface-container-high transition-all p-space-md rounded-lg flex flex-col gap-space-sm cursor-pointer border-l-4 border-error" onclick="selectAlert('ALT-8812')">
                            <div class="flex items-start justify-between gap-space-sm">
                                <div class="flex items-center gap-space-sm">
                                    <input checked="" class="w-4 h-4 rounded bg-surface-container-highest checked:bg-primary accent-primary cursor-pointer" onclick="event.stopPropagation()" type="checkbox" />
                                    <span class="px-2 py-0.5 rounded font-label-code text-[11px] font-bold bg-error text-surface flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-surface animate-ping"></span>
                                        CRITICAL · P1
                                    </span>
                                    <span class="font-label-code text-label-code text-primary font-bold">ALT-8812</span>
                                    <span class="font-label-technical text-label-technical text-outline uppercase hidden sm:inline">Model Accuracy Drop</span>
                                </div>
                                <div class="flex items-center gap-space-xs">
                                    <span class="px-2 py-0.5 rounded font-label-code text-[10px] bg-tertiary-container text-tertiary font-bold tracking-tight">INVESTIGATING · INC-4092</span>
                                    <span class="font-label-code text-[11px] text-outline">14m ago (04:18 UTC)</span>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-12 gap-space-sm pt-1">
                                <div class="md:col-span-7 flex flex-col gap-1">
                                    <div class="flex items-center gap-2">
                                        <span class="font-headline-md text-[16px] text-on-surface font-semibold">churn_rf_v2</span>
                                        <span class="font-label-code text-[11px] px-1.5 py-0.2 rounded bg-surface-container-highest text-secondary">v2.4.1 · PROD</span>
                                        <a class="font-label-code text-[10px] text-outline hover:text-primary transition-colors flex items-center gap-0.5" data-path="model-registry" href="#" onclick="event.stopPropagation()">
                                            <span class="material-symbols-outlined text-[12px]">open_in_new</span>
                                            <span>SYS-AI-04</span>
                                        </a>
                                    </div>
                                    <p class="font-body-sm text-body-sm text-error flex items-center gap-1 font-medium">
                                        <span class="material-symbols-outlined text-[16px]">trending_down</span>
                                        <span>F1 Score degraded to 0.61 (Expected ≥ 0.80 SLA, Delta: -0.26)</span>
                                    </p>
                                </div>
                                <div class="md:col-span-5 flex items-center justify-between md:justify-end gap-space-md">
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-full bg-primary flex items-center justify-center font-label-code text-[10px] text-on-primary font-bold">AV</div>
                                        <div class="flex flex-col">
                                            <span class="font-label-code text-[11px] text-on-surface leading-tight">Alexei V. (You)</span>
                                            <span class="font-label-technical text-[9px] text-tertiary uppercase">OWNER</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-1" onclick="event.stopPropagation()">
                                        <a class="px-2.5 py-1 bg-surface-container-highest hover:bg-error hover:text-surface text-on-surface rounded font-label-code text-[11px] transition-colors flex items-center gap-1" data-path="active-incident" href="#">
                                            <span>INC-4092</span>
                                            <span class="material-symbols-outlined text-[12px]">arrow_forward</span>
                                        </a>
                                        <button class="p-1 text-outline hover:text-on-surface rounded">
                                            <span class="material-symbols-outlined text-[18px]">more_vert</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ROW 2: HIGH P2 (ALT-8810) -->
                        <div class="group relative bg-surface-container hover:bg-surface-container-high transition-all p-space-md rounded-lg flex flex-col gap-space-sm cursor-pointer border-l-4 border-tertiary" onclick="selectAlert('ALT-8810')">
                            <div class="flex items-start justify-between gap-space-sm">
                                <div class="flex items-center gap-space-sm">
                                    <input checked="" class="w-4 h-4 rounded bg-surface-container-highest checked:bg-primary accent-primary cursor-pointer" onclick="event.stopPropagation()" type="checkbox" />
                                    <span class="px-2 py-0.5 rounded font-label-code text-[11px] font-bold bg-tertiary text-on-tertiary flex items-center gap-1">
                                        HIGH · P2
                                    </span>
                                    <span class="font-label-code text-label-code text-primary font-bold">ALT-8810</span>
                                    <span class="font-label-technical text-label-technical text-outline uppercase hidden sm:inline">Data Drift (Evidently KS-Test)</span>
                                </div>
                                <div class="flex items-center gap-space-xs">
                                    <span class="px-2 py-0.5 rounded font-label-code text-[10px] bg-secondary-container text-on-secondary-container font-semibold">LINKED TO INC-4092</span>
                                    <span class="font-label-code text-[11px] text-outline">28m ago (04:04 UTC)</span>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-12 gap-space-sm pt-1">
                                <div class="md:col-span-7 flex flex-col gap-1">
                                    <div class="flex items-center gap-2">
                                        <span class="font-headline-md text-[16px] text-on-surface font-semibold">churn_rf_v2</span>
                                        <span class="font-label-code text-[11px] px-1.5 py-0.2 rounded bg-surface-container-highest text-on-surface-variant">v2.4.1</span>
                                    </div>
                                    <p class="font-body-sm text-body-sm text-tertiary flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[16px]">sync_problem</span>
                                        <span>'monthly_charges' Drift Score 0.42 (p &lt; 0.001); 'contract_type' PSI: 0.31</span>
                                    </p>
                                </div>
                                <div class="md:col-span-5 flex items-center justify-between md:justify-end gap-space-md">
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-full bg-primary flex items-center justify-center font-label-code text-[10px] text-on-primary font-bold">AV</div>
                                        <span class="font-label-code text-[11px] text-on-surface">Alexei V.</span>
                                    </div>
                                    <div class="flex items-center gap-1" onclick="event.stopPropagation()">
                                        <button class="px-2.5 py-1 bg-surface-container-highest hover:bg-tertiary hover:text-on-tertiary text-on-surface rounded font-label-code text-[11px] transition-colors">
                                            Drift Matrix
                                        </button>
                                        <button class="p-1 text-outline hover:text-on-surface rounded">
                                            <span class="material-symbols-outlined text-[18px]">more_vert</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ROW 3: HIGH P2 (ALT-8804) -->
                        <div class="group relative bg-surface-container hover:bg-surface-container-high transition-all p-space-md rounded-lg flex flex-col gap-space-sm cursor-pointer border-l-4 border-tertiary" onclick="selectAlert('ALT-8804')">
                            <div class="flex items-start justify-between gap-space-sm">
                                <div class="flex items-center gap-space-sm">
                                    <input class="w-4 h-4 rounded bg-surface-container-highest checked:bg-primary accent-primary cursor-pointer" onclick="event.stopPropagation()" type="checkbox" />
                                    <span class="px-2 py-0.5 rounded font-label-code text-[11px] font-bold bg-tertiary text-on-tertiary">
                                        HIGH · P2
                                    </span>
                                    <span class="font-label-code text-label-code text-primary font-bold">ALT-8804</span>
                                    <span class="font-label-technical text-label-technical text-outline uppercase hidden sm:inline">Prediction Dist. Shift</span>
                                </div>
                                <div class="flex items-center gap-space-xs">
                                    <span class="px-2 py-0.5 rounded font-label-code text-[10px] bg-secondary-container text-on-secondary-container font-semibold">LINKED TO INC-4092</span>
                                    <span class="font-label-code text-[11px] text-outline">31m ago (04:01 UTC)</span>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-12 gap-space-sm pt-1">
                                <div class="md:col-span-7 flex flex-col gap-1">
                                    <div class="flex items-center gap-2">
                                        <span class="font-headline-md text-[16px] text-on-surface font-semibold">churn_rf_v2</span>
                                        <span class="font-label-code text-[11px] px-1.5 py-0.2 rounded bg-surface-container-highest text-on-surface-variant">v2.4.1</span>
                                    </div>
                                    <p class="font-body-sm text-body-sm text-tertiary flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[16px]">bar_chart</span>
                                        <span>Predicted churn probability jumped: positive class 14.2% → 48.9%</span>
                                    </p>
                                </div>
                                <div class="md:col-span-5 flex items-center justify-between md:justify-end gap-space-md">
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-full bg-primary flex items-center justify-center font-label-code text-[10px] text-on-primary font-bold">AV</div>
                                        <span class="font-label-code text-[11px] text-on-surface">Alexei V.</span>
                                    </div>
                                    <div class="flex items-center gap-1" onclick="event.stopPropagation()">
                                        <button class="px-2.5 py-1 bg-surface-container-highest hover:bg-secondary hover:text-on-secondary text-on-surface rounded font-label-code text-[11px] transition-colors">
                                            Hist. View
                                        </button>
                                        <button class="p-1 text-outline hover:text-on-surface rounded">
                                            <span class="material-symbols-outlined text-[18px]">more_vert</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ROW 4: MEDIUM P3 (ALT-8791) -->
                        <div class="group relative bg-surface-container hover:bg-surface-container-high transition-all p-space-md rounded-lg flex flex-col gap-space-sm cursor-pointer border-l-4 border-outline" onclick="selectAlert('ALT-8791')">
                            <div class="flex items-start justify-between gap-space-sm">
                                <div class="flex items-center gap-space-sm">
                                    <input class="w-4 h-4 rounded bg-surface-container-highest checked:bg-primary accent-primary cursor-pointer" onclick="event.stopPropagation()" type="checkbox" />
                                    <span class="px-2 py-0.5 rounded font-label-code text-[11px] font-bold bg-surface-container-highest text-on-surface">
                                        MEDIUM · P3
                                    </span>
                                    <span class="font-label-code text-label-code text-primary font-bold">ALT-8791</span>
                                    <span class="font-label-technical text-label-technical text-outline uppercase hidden sm:inline">Feature Schema Shift</span>
                                </div>
                                <div class="flex items-center gap-space-xs">
                                    <span class="px-2 py-0.5 rounded font-label-code text-[10px] bg-surface-container-high text-outline font-bold">OPEN · UNASSIGNED</span>
                                    <span class="font-label-code text-[11px] text-outline">1h 12m ago</span>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-12 gap-space-sm pt-1">
                                <div class="md:col-span-7 flex flex-col gap-1">
                                    <div class="flex items-center gap-2">
                                        <span class="font-headline-md text-[16px] text-on-surface font-semibold">lead_scoring_xgb</span>
                                        <span class="font-label-code text-[11px] px-1.5 py-0.2 rounded bg-surface-container-highest text-on-surface-variant">v1.9.4</span>
                                    </div>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[16px] text-outline">category</span>
                                        <span>Feature 'last_touch_channel' new category value <code class="text-secondary bg-surface-container-low px-1 rounded">'tiktok_ad'</code> (OOV)</span>
                                    </p>
                                </div>
                                <div class="md:col-span-5 flex items-center justify-between md:justify-end gap-space-md">
                                    <button class="px-2.5 py-1 bg-surface-container-highest hover:bg-primary hover:text-on-primary text-secondary rounded font-label-code text-[11px] font-bold flex items-center gap-1" onclick="event.stopPropagation()">
                                        <span class="material-symbols-outlined text-[14px]">pan_tool</span>
                                        <span>Claim Alert</span>
                                    </button>
                                    <div class="flex items-center gap-1" onclick="event.stopPropagation()">
                                        <button class="px-2.5 py-1 bg-surface-container-highest hover:bg-surface-container text-on-surface rounded font-label-code text-[11px]">
                                            Inspect Schema
                                        </button>
                                        <button class="p-1 text-outline hover:text-on-surface rounded">
                                            <span class="material-symbols-outlined text-[18px]">more_vert</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ROW 5: RESOLVED (ALT-8750) -->
                        <div class="group relative bg-surface-container/60 hover:bg-surface-container transition-all p-space-md rounded-lg flex flex-col gap-space-sm cursor-pointer opacity-75 hover:opacity-100" onclick="selectAlert('ALT-8750')">
                            <div class="flex items-start justify-between gap-space-sm">
                                <div class="flex items-center gap-space-sm">
                                    <input class="w-4 h-4 rounded bg-surface-container-highest accent-primary opacity-40" disabled="" type="checkbox" />
                                    <span class="px-2 py-0.5 rounded font-label-code text-[11px] font-bold bg-surface-container-highest text-secondary flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[12px]">check</span>
                                        RESOLVED
                                    </span>
                                    <span class="font-label-code text-label-code text-outline font-bold">ALT-8750</span>
                                    <span class="font-label-technical text-label-technical text-outline uppercase hidden sm:inline">API Latency Spike</span>
                                </div>
                                <div class="flex items-center gap-space-xs">
                                    <span class="px-2 py-0.5 rounded font-label-code text-[10px] bg-surface-container-high text-on-surface-variant">RESOLVED BY AUTOSCALER</span>
                                    <span class="font-label-code text-[11px] text-outline">3h ago (01:22 UTC)</span>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-12 gap-space-sm pt-1">
                                <div class="md:col-span-7 flex flex-col gap-1">
                                    <div class="flex items-center gap-2">
                                        <span class="font-headline-md text-[16px] text-on-surface/80 font-medium">fraud_detector_nn</span>
                                        <span class="font-label-code text-[11px] px-1.5 py-0.2 rounded bg-surface-container-low text-outline">v3.1.0</span>
                                    </div>
                                    <p class="font-body-sm text-body-sm text-outline flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[16px]">speed</span>
                                        <span>p99 latency peaked at 240ms (Threshold: 100ms) → Pod count expanded 2 → 5</span>
                                    </p>
                                </div>
                                <div class="md:col-span-5 flex items-center justify-between md:justify-end gap-space-md">
                                    <div class="flex items-center gap-2">
                                        <span class="font-label-code text-[11px] text-outline">Platform Ops</span>
                                    </div>
                                    <div class="flex items-center gap-1" onclick="event.stopPropagation()">
                                        <button class="px-2.5 py-1 bg-surface-container text-outline hover:text-on-surface rounded font-label-code text-[11px]">
                                            Audit Trace
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- RIGHT-HAND SLIDE-IN TRIAGE PREVIEW DRAWER (4 COLS) -->
                    <div class="xl:col-span-4 bg-surface-container-low p-space-md rounded-xl flex flex-col gap-space-md shadow-md sticky top-32">
                        <!-- Drawer Header -->
                        <div class="flex items-center justify-between pb-space-sm bg-surface-container px-space-sm py-space-xs rounded-lg">
                            <div class="flex items-center gap-space-xs">
                                <span class="w-2.5 h-2.5 rounded-full bg-error animate-pulse"></span>
                                <span class="font-label-code text-label-code text-on-surface font-bold">ALT-8812 :: FOCUS TRIAGE</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <span class="px-1.5 py-0.5 rounded text-[10px] font-label-code bg-error-container text-on-error-container font-bold">P1 CRIT</span>
                                <button class="text-outline hover:text-on-surface p-1">
                                    <span class="material-symbols-outlined text-[16px]">close_fullscreen</span>
                                </button>
                            </div>
                        </div>
                        <!-- Quick Model Telemetry Snapshot -->
                        <div class="bg-surface-container p-space-md rounded-xl flex flex-col gap-space-sm">
                            <div class="flex items-center justify-between">
                                <div class="flex flex-col">
                                    <span class="font-label-technical text-label-technical text-outline uppercase tracking-wider">Target Model Instance</span>
                                    <span class="font-headline-md text-headline-md text-on-surface">churn_rf_v2</span>
                                </div>
                                <span class="px-2 py-0.5 rounded bg-primary-container text-secondary font-label-code text-[11px]">POD: prod-ml-c02</span>
                            </div>
                            <!-- Telemetry Degradation Chart SVG -->
                            <div class="mt-space-xs flex flex-col gap-1">
                                <div class="flex items-center justify-between font-label-code text-[11px]">
                                    <span class="text-outline">F1 Score (Last 60 mins)</span>
                                    <span class="text-error font-bold">0.61 <span class="text-outline font-normal">/ SLA 0.80</span></span>
                                </div>
                                <div class="w-full bg-surface-container-lowest p-2 rounded-lg relative overflow-hidden">
                                    <svg class="w-full h-24 overflow-visible" fill="none" viewbox="0 0 320 80">
                                        <!-- Grid baseline SLA line -->
                                        <line class="text-outline-variant" stroke="currentColor" stroke-dasharray="3 3" stroke-width="1" x1="0" x2="320" y1="28" y2="28"></line>
                                        <text class="fill-outline font-label-code text-[9px]" x="5" y="24">SLA 0.80</text>
                                        <!-- Ingestion delay zone shading -->
                                        <rect class="text-error-container" fill="currentColor" height="80" opacity="0.15" width="80" x="240" y="0"></rect>
                                        <line class="text-error" stroke="currentColor" stroke-dasharray="2 2" stroke-width="1" x1="240" x2="240" y1="0" y2="80"></line>
                                        <text class="fill-error font-label-code text-[8px]" x="245" y="72">04:04 DRIFT TRIP</text>
                                        <!-- F1 Curve -->
                                        <path class="text-error" d="M 0 20 L 40 22 L 80 19 L 120 23 L 160 21 L 200 24 L 240 28 L 260 52 L 280 62 L 320 64" fill="none" stroke="currentColor" stroke-width="2.5"></path>
                                        <!-- Data Points -->
                                        <circle class="fill-tertiary" cx="240" cy="28" r="3"></circle>
                                        <circle class="fill-error animate-ping" cx="320" cy="64" r="4"></circle>
                                        <circle class="fill-error" cx="320" cy="64" r="3"></circle>
                                    </svg>
                                </div>
                                <div class="flex items-center justify-between font-label-code text-[10px] text-outline pt-0.5">
                                    <span>03:30 UTC</span>
                                    <span>04:00 UTC</span>
                                    <span class="text-error font-bold">04:30 (NOW)</span>
                                </div>
                            </div>
                            <!-- Ground Truth Verification Warning -->
                            <div class="flex items-start gap-space-xs bg-surface-container-high p-space-sm rounded-lg mt-space-xs">
                                <span class="material-symbols-outlined text-tertiary text-[18px] shrink-0">hourglass_top</span>
                                <div class="flex flex-col">
                                    <span class="font-label-technical text-label-technical text-tertiary uppercase">Delayed Ground Truth Note</span>
                                    <span class="font-body-sm text-[12px] text-on-surface-variant">Ground-truth labels arrive with ~10m lag via Data Lake streaming pipeline. Drop verified real (not latency phantom).</span>
                                </div>
                            </div>
                        </div>
                        <!-- INTERN WORKFLOW PLAYBOOK (STEP-BY-STEP SOP) -->
                        <div class="bg-surface-container p-space-md rounded-xl flex flex-col gap-space-sm">
                            <div class="flex items-center justify-between">
                                <div class="font-label-technical text-label-technical text-primary uppercase tracking-wider flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-[16px]">menu_book</span>
                                    <span>Triage Playbook SOP-ML-09</span>
                                </div>
                                <span class="font-label-code text-[10px] text-outline">STAGE 13/14</span>
                            </div>
                            <div class="flex flex-col gap-space-sm mt-space-xs">
                                <!-- Step 1 -->
                                <div class="flex items-start gap-space-sm p-space-xs rounded bg-surface-container-high/40">
                                    <div class="w-5 h-5 rounded-full bg-secondary-container text-on-secondary font-label-code text-[10px] font-bold flex items-center justify-center shrink-0">1</div>
                                    <div class="flex flex-col">
                                        <span class="font-label-technical text-[11px] text-on-surface font-semibold">Verify Telemetry Pipeline</span>
                                        <span class="font-body-sm text-[11px] text-outline">Confirm Kafka-to-ClickHouse ingress has zero lag buffer.</span>
                                        <span class="font-label-code text-[10px] text-secondary mt-0.5">✓ Checked nominal (12ms)</span>
                                    </div>
                                </div>
                                <!-- Step 2 -->
                                <div class="flex items-start gap-space-sm p-space-xs rounded bg-tertiary-container/30">
                                    <div class="w-5 h-5 rounded-full bg-tertiary text-on-tertiary font-label-code text-[10px] font-bold flex items-center justify-center shrink-0">2</div>
                                    <div class="flex flex-col">
                                        <span class="font-label-technical text-[11px] text-tertiary font-semibold">Inspect Drifted Features</span>
                                        <span class="font-body-sm text-[11px] text-on-surface-variant">High correlation between 'monthly_charges' shift and prediction skew.</span>
                                        <a class="font-label-code text-[11px] text-tertiary font-bold hover:underline flex items-center gap-0.5 mt-1" data-path="drift-workspace" href="#">
                                            <span>Launch Drift Studio</span>
                                            <span class="material-symbols-outlined text-[12px]">arrow_outward</span>
                                        </a>
                                    </div>
                                </div>
                                <!-- Step 3 -->
                                <div class="flex items-start gap-space-sm p-space-xs rounded bg-surface-container-high/40">
                                    <div class="w-5 h-5 rounded-full bg-surface-container-highest text-on-surface font-label-code text-[10px] font-bold flex items-center justify-center shrink-0">3</div>
                                    <div class="flex flex-col">
                                        <span class="font-label-technical text-[11px] text-on-surface font-semibold">Incident File Attached</span>
                                        <span class="font-body-sm text-[11px] text-outline">Linked to war room INC-4092 with telemetry dump.</span>
                                        <span class="font-label-code text-[10px] text-primary mt-0.5">Alexei V. assigned as Lead</span>
                                    </div>
                                </div>
                                <!-- Step 4 -->
                                <div class="flex items-start gap-space-sm p-space-xs rounded bg-surface-container-high/40">
                                    <div class="w-5 h-5 rounded-full bg-surface-container-highest text-outline font-label-code text-[10px] font-bold flex items-center justify-center shrink-0">4</div>
                                    <div class="flex flex-col">
                                        <span class="font-label-technical text-[11px] text-outline uppercase font-semibold">Rollback or Retrain Decision</span>
                                        <span class="font-body-sm text-[11px] text-outline">Coordinate canary rollback to v2.3.9 or trigger retrain on Lakeflow slice.</span>
                                        <div class="flex items-center gap-2 mt-1.5">
                                            <button class="px-2 py-0.5 bg-error text-surface rounded font-label-code text-[10px] font-bold hover:bg-error-container hover:text-on-error-container transition-colors">
                                                ROLLBACK v2.3.9
                                            </button>
                                            <button class="px-2 py-0.5 bg-surface-container-highest text-secondary rounded font-label-code text-[10px] font-bold hover:bg-surface-container transition-colors">
                                                RETRAIN LOOP
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Quick Action Dispatch Bar -->
                        <div class="flex items-center gap-space-xs pt-space-xs">
                            <a class="flex-1 text-center py-2 bg-primary text-on-primary rounded-lg font-label-technical text-label-technical tracking-wider uppercase font-bold hover:bg-primary-fixed-dim transition-colors" data-path="active-incident" href="#">
                                Open Incident INC-4092 War Room
                            </a>
                            <button class="p-2 bg-surface-container text-on-surface-variant hover:text-on-surface rounded-lg transition-colors" title="Download Diagnostics Snapshot">
                                <span class="material-symbols-outlined text-[18px]">share</span>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- BOTTOM STATUS & RECOVERY AUDIT STRIP -->
                <div class="flex flex-wrap items-center justify-between gap-space-md p-space-md bg-surface-container-low rounded-xl">
                    <div class="flex items-center gap-space-md">
                        <div class="flex items-center gap-space-xs">
                            <span class="material-symbols-outlined text-secondary text-[18px]">verified_user</span>
                            <span class="font-label-technical text-label-technical text-on-surface uppercase">Ingestion Guardrail: ACTIVE</span>
                        </div>
                        <span class="hidden md:inline font-label-code text-label-code text-outline">SLA Threshold Engine: 99.98% evaluated in 1.4s</span>
                    </div>
                    <div class="flex items-center gap-space-sm font-label-code text-label-code text-on-surface-variant">
                        <span>AUTOTRIAGE DAEMON: <span class="text-tertiary">ONLINE</span></span>
                        <span class="text-outline-variant">|</span>
                        <span>CLUSTER REGION: <span class="text-primary">EUS-PROD-01</span></span>
                    </div>
                </div>
            </div>
            <script>
                function selectAlert(alertId) {
                    console.log("Selected Alert for Inspection: " + alertId);
                }

                document.getElementById('btn-ack-selected')?.addEventListener('click', function() {
                    this.innerHTML = '<span class="material-symbols-outlined text-[16px]">check</span><span>Acknowledged!</span>';
                    setTimeout(() => {
                        this.innerHTML = '<span class="material-symbols-outlined text-[16px]">done_all</span><span>Acknowledge (2)</span>';
                    }, 2000);
                });
            </script>
        </main>
    </div>
</body>

</html>