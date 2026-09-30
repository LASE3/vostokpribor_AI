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
            <div class="flex flex-col w-full">
                <!-- WAR ROOM INCIDENT BANNER -->
                <div class="relative w-full bg-surface-container-lowest rounded-xl p-space-md lg:p-space-lg mb-space-lg shadow-xl overflow-hidden">
                    <div class="absolute -right-20 -top-20 w-80 h-80 rounded-full bg-error-container/20 blur-3xl pointer-events-none"></div>
                    <div class="absolute right-96 top-1/2 -translate-y-1/2 w-48 h-48 rounded-full bg-tertiary-container/30 blur-2xl pointer-events-none"></div>
                    <div class="relative z-10 flex flex-col gap-space-md">
                        <!-- Upper Banner Row: Identifiers & Timers -->
                        <div class="flex flex-wrap items-center justify-between gap-space-md">
                            <div class="flex flex-wrap items-center gap-space-sm">
                                <div class="flex items-center gap-space-xs bg-error-container px-space-sm py-1 rounded">
                                    <span class="w-2.5 h-2.5 rounded-full bg-error animate-ping"></span>
                                    <span class="font-label-technical text-label-technical text-on-error-container uppercase tracking-wider">P1 CRITICAL // INCIDENT #INC-4092</span>
                                </div>
                                <div class="flex items-center gap-space-xs bg-tertiary-container px-space-sm py-1 rounded">
                                    <span class="material-symbols-outlined text-tertiary text-[16px] animate-spin" style="font-variation-settings: 'FILL' 1;">sync</span>
                                    <span class="font-label-code text-label-code text-tertiary font-bold tracking-tight">INVESTIGATING / ACTIVE WAR ROOM</span>
                                </div>
                                <span class="font-label-code text-label-code text-outline hidden sm:inline">|</span>
                                <div class="flex items-center gap-1.5 font-label-code text-label-code text-secondary">
                                    <span class="material-symbols-outlined text-[16px] text-outline">memory</span>
                                    <span class="text-on-surface font-semibold">churn_rf_v2</span>
                                    <span class="text-outline-variant font-normal">v2.4.1-prod</span>
                                    <span class="bg-surface-container-high px-1.5 py-0.5 rounded text-[11px] text-primary">prod-ml-c02:EUS-PROD-01</span>
                                </div>
                            </div>
                            <!-- Quick War Room Action Buttons -->
                            <div class="flex flex-wrap items-center gap-space-xs">
                                <div class="relative inline-flex items-center">
                                    <select class="appearance-none bg-surface-container-high text-primary font-label-code text-label-code pl-space-sm pr-7 py-1.5 rounded cursor-pointer hover:bg-surface-bright focus:outline-none">
                                        <option selected="">State: Investigating</option>
                                        <option>State: Mitigated</option>
                                        <option>State: Resolved</option>
                                        <option>State: Closed</option>
                                    </select>
                                    <span class="material-symbols-outlined text-outline text-[16px] absolute right-2 pointer-events-none">expand_more</span>
                                </div>
                                <button class="bg-surface-container text-on-surface-variant hover:text-on-surface px-space-sm py-1.5 rounded font-label-code text-label-code flex items-center gap-1 transition-colors">
                                    <span class="material-symbols-outlined text-[16px]">share</span>
                                    <span>Share Link</span>
                                </button>
                                <a class="bg-surface-container-high hover:bg-surface-bright text-tertiary px-space-sm py-1.5 rounded font-label-code text-label-code flex items-center gap-1 transition-colors" href="#">
                                    <span class="material-symbols-outlined text-[16px]">edit_note</span>
                                    <span>Post-Mortem Draft</span>
                                </a>
                                <div class="bg-surface-container-high px-space-sm py-1.5 rounded flex items-center gap-1.5 font-label-code text-label-code text-secondary">
                                    <span class="w-2 h-2 rounded-full bg-secondary-fixed animate-pulse"></span>
                                    <span class="material-symbols-outlined text-[16px] text-secondary">call</span>
                                    <span class="font-bold text-on-surface">3 Connected</span>
                                </div>
                            </div>
                        </div>
                        <!-- Lower Banner Row: Operational Command Personnel & Real-Time Clocks -->
                        <div class="flex flex-wrap items-center justify-between pt-space-xs gap-space-md">
                            <div class="flex flex-wrap items-center gap-space-lg">
                                <div class="flex items-center gap-space-sm">
                                    <span class="font-label-technical text-label-technical text-outline uppercase tracking-wider">Commander:</span>
                                    <div class="flex items-center gap-1.5">
                                        <span class="w-5 h-5 rounded-full bg-primary text-on-primary font-label-code text-[10px] flex items-center justify-center font-bold">AV</span>
                                        <span class="font-label-code text-label-code text-on-surface font-semibold">Alexei V.</span>
                                        <span class="text-[10px] font-label-technical text-tertiary bg-tertiary-container px-1 rounded">L3 INTERN AI ENG</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-space-sm">
                                    <span class="font-label-technical text-label-technical text-outline uppercase tracking-wider">Secondary Lead:</span>
                                    <div class="flex items-center gap-1.5">
                                        <span class="w-5 h-5 rounded-full bg-secondary-container text-on-secondary-container font-label-code text-[10px] flex items-center justify-center font-bold">DR</span>
                                        <span class="font-label-code text-label-code text-on-surface">Dr. Romanova</span>
                                        <span class="text-[10px] font-label-technical text-outline bg-surface-container-high px-1 rounded">SR AI LEAD / INSTRUCTOR</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center gap-space-md">
                                <div class="flex items-center gap-space-xs font-label-code text-label-code">
                                    <span class="text-outline uppercase text-[10px] font-label-technical">Trigger Time:</span>
                                    <span class="text-on-surface font-semibold">04:18:22 UTC</span>
                                </div>
                                <div class="flex items-center gap-1 bg-surface-container-low px-space-sm py-1 rounded font-metric-sm text-metric-sm text-error">
                                    <span class="material-symbols-outlined text-[18px]">timer</span>
                                    <span>+00:44:18 ELAPSED</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- MAIN 3-COLUMN BENTO GRID -->
                <div class="grid grid-cols-1 xl:grid-cols-12 gap-space-lg w-full">
                    <!-- LEFT COLUMN: INCIDENT CHRONOLOGY & REAL-TIME LOG (Cols: 3) -->
                    <div class="xl:col-span-3 flex flex-col gap-space-md">
                        <div class="bg-surface-container-lowest rounded-xl p-space-md flex flex-col h-full shadow-lg">
                            <div class="flex items-center justify-between pb-space-sm mb-space-sm">
                                <div class="flex items-center gap-space-xs">
                                    <span class="material-symbols-outlined text-secondary text-[20px]">history_toggle_off</span>
                                    <span class="font-headline-md text-[16px] text-primary tracking-tight">Timeline &amp; Telemetry Pings</span>
                                </div>
                                <span class="font-label-code text-[10px] text-outline bg-surface-container-high px-1.5 py-0.5 rounded">7 EVENTS</span>
                            </div>
                            <!-- Chronology Stream -->
                            <div class="flex flex-col gap-space-sm overflow-y-auto max-h-[820px] pr-1">
                                <!-- Event 1 -->
                                <div class="relative pl-5 pb-space-sm">
                                    <span class="absolute left-0 top-1.5 w-2 h-2 rounded-full bg-outline"></span>
                                    <div class="absolute left-[3px] top-4 bottom-0 w-0.5 bg-surface-container-high"></div>
                                    <div class="flex items-baseline justify-between font-label-code text-label-code">
                                        <span class="text-outline font-bold">03:45 UTC</span>
                                        <span class="text-[10px] text-secondary font-label-technical">SCHEMA_DEPLOY</span>
                                    </div>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant mt-1 leading-snug">
                                        Upstream <span class="font-label-code text-secondary">CRM-FEED-05</span> schema deploy (v1.8 payload containing ISO-8601 <code class="text-on-surface font-label-code text-[11px] bg-surface-container px-1">creation_timestamp</code>).
                                    </p>
                                </div>
                                <!-- Event 2 -->
                                <div class="relative pl-5 pb-space-sm">
                                    <span class="absolute left-0 top-1.5 w-2 h-2 rounded-full bg-secondary"></span>
                                    <div class="absolute left-[3px] top-4 bottom-0 w-0.5 bg-surface-container-high"></div>
                                    <div class="flex items-baseline justify-between font-label-code text-label-code">
                                        <span class="text-secondary font-bold">04:02 UTC</span>
                                        <span class="text-[10px] text-outline font-label-technical">LAKEFLOW_SYS</span>
                                    </div>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant mt-1 leading-snug">
                                        Lakeflow SYS-AI-02 Kafka lag 0s, automated <code class="text-tertiary font-label-code text-[11px] bg-surface-container px-1">fillna(0)</code> triggered in streaming gateway.
                                    </p>
                                </div>
                                <!-- Event 3 -->
                                <div class="relative pl-5 pb-space-sm">
                                    <span class="absolute left-0 top-1.5 w-2 h-2 rounded-full bg-tertiary"></span>
                                    <div class="absolute left-[3px] top-4 bottom-0 w-0.5 bg-surface-container-high"></div>
                                    <div class="flex items-baseline justify-between font-label-code text-label-code">
                                        <span class="text-tertiary font-bold">04:15 UTC</span>
                                        <span class="text-[10px] text-tertiary font-label-technical">METRIC_SKEW</span>
                                    </div>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant mt-1 leading-snug">
                                        Churn inference distribution skews positive (<span class="text-tertiary font-bold">+152%</span> churn prediction volume).
                                    </p>
                                </div>
                                <!-- Event 4 (TRIGGER) -->
                                <div class="relative pl-5 pb-space-sm">
                                    <span class="absolute left-0 top-1.5 w-2.5 h-2.5 rounded-full bg-error animate-ping"></span>
                                    <div class="absolute left-[3px] top-4 bottom-0 w-0.5 bg-surface-container-high"></div>
                                    <div class="flex items-baseline justify-between font-label-code text-label-code">
                                        <span class="text-error font-bold">04:18 UTC</span>
                                        <span class="text-[10px] text-error font-label-technical font-bold uppercase tracking-wider">ALT-8812 TRIGGER</span>
                                    </div>
                                    <div class="mt-1 p-space-xs rounded bg-error-container/30">
                                        <p class="font-body-sm text-body-sm text-on-surface font-semibold">
                                            F1 Score Breach: 0.87 → 0.61
                                        </p>
                                        <p class="font-label-code text-[11px] text-error mt-0.5">
                                            Breached SLA floor (≥ 0.8000). Automated escalation triggered to on-call cluster.
                                        </p>
                                    </div>
                                </div>
                                <!-- Event 5 -->
                                <div class="relative pl-5 pb-space-sm">
                                    <span class="absolute left-0 top-1.5 w-2 h-2 rounded-full bg-primary"></span>
                                    <div class="absolute left-[3px] top-4 bottom-0 w-0.5 bg-surface-container-high"></div>
                                    <div class="flex items-baseline justify-between font-label-code text-label-code">
                                        <span class="text-on-surface font-bold">04:21 UTC</span>
                                        <span class="text-[10px] text-outline font-label-technical">ACK_TRIAGE</span>
                                    </div>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant mt-1 leading-snug">
                                        Alexei V. acknowledged alert ALT-8812, opened War Room <span class="font-label-code text-primary font-semibold">#INC-4092</span> and initiated diagnostic probes.
                                    </p>
                                </div>
                                <!-- Event 6 -->
                                <div class="relative pl-5 pb-space-sm">
                                    <span class="absolute left-0 top-1.5 w-2 h-2 rounded-full bg-secondary"></span>
                                    <div class="absolute left-[3px] top-4 bottom-0 w-0.5 bg-surface-container-high"></div>
                                    <div class="flex items-baseline justify-between font-label-code text-label-code">
                                        <span class="text-secondary font-bold">04:32 UTC</span>
                                        <span class="text-[10px] text-secondary font-label-technical">DRIFT_CONFIRM</span>
                                    </div>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant mt-1 leading-snug">
                                        Evidently drift test confirmed <span class="text-on-surface font-bold">78.4%</span> of <code class="text-primary font-label-code text-[11px] bg-surface-container px-1">account_age_months</code> values collapsed to 0.000.
                                    </p>
                                </div>
                                <!-- Event 7 -->
                                <div class="relative pl-5">
                                    <span class="absolute left-0 top-1.5 w-2 h-2 rounded-full bg-tertiary"></span>
                                    <div class="flex items-baseline justify-between font-label-code text-label-code">
                                        <span class="text-tertiary font-bold">04:45 UTC</span>
                                        <span class="text-[10px] text-tertiary font-label-technical">ARTIFACT_PINNED</span>
                                    </div>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant mt-1 leading-snug">
                                        Alexei V. pinned KS-Test cumulative distribution graph &amp; feature importance skew to War Room evidence ledger.
                                    </p>
                                </div>
                            </div>
                            <!-- Add Incident Note Input Bar -->
                            <div class="mt-space-md pt-space-md flex flex-col gap-space-xs">
                                <div class="flex items-center justify-between font-label-technical text-label-technical text-outline">
                                    <span class="uppercase">Append Incident Note</span>
                                    <span class="font-label-code text-primary">Alexei V. (L3)</span>
                                </div>
                                <div class="relative flex items-center">
                                    <input class="w-full bg-surface-container-low text-on-surface font-label-code text-label-code pl-space-sm pr-9 py-2 rounded focus:outline-none focus:ring-1 focus:ring-secondary placeholder:text-outline" placeholder="Type timestamped note... [ENTER]" type="text" />
                                    <button class="absolute right-1 text-primary hover:text-on-surface p-1">
                                        <span class="material-symbols-outlined text-[18px]">send</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- CENTER COLUMN: PINNED EVIDENCE & INVESTIGATION WORKSPACE (Cols: 5) -->
                    <div class="xl:col-span-5 flex flex-col gap-space-lg">
                        <!-- Section: Pinned Artifacts Bento -->
                        <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-lg flex flex-col gap-space-md">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-space-xs">
                                    <span class="material-symbols-outlined text-tertiary text-[20px]" style="font-variation-settings: 'FILL' 1;">push_pin</span>
                                    <span class="font-headline-md text-[16px] text-primary tracking-tight">Pinned Artifacts &amp; Telemetry Evidence</span>
                                </div>
                                <span class="font-label-technical text-[10px] text-on-surface-variant uppercase tracking-wider">3 Pinned Items</span>
                            </div>
                            <div class="grid grid-cols-1 gap-space-md">
                                <!-- Card 1: Time Series SLA Drop -->
                                <div class="bg-surface-container-low rounded-lg p-space-md flex flex-col gap-space-xs hover:bg-surface-container-high/60 transition-colors">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-1.5">
                                            <span class="w-2 h-2 rounded-full bg-error"></span>
                                            <span class="font-label-code text-label-code text-on-surface font-bold">F1 Telemetry Breach: 0.87 → 0.61</span>
                                        </div>
                                        <span class="font-label-technical text-[10px] text-tertiary bg-tertiary-container px-1.5 py-0.5 rounded">Pinned: Model Monitoring</span>
                                    </div>
                                    <!-- Mini Inline SVG Chart: Drop past SLA line -->
                                    <div class="w-full bg-surface-container-lowest rounded p-2 my-1">
                                        <div class="flex items-center justify-between font-label-code text-[10px] text-outline mb-1">
                                            <span>03:00 UTC (0.872)</span>
                                            <span class="text-error font-bold">SLA FLOOR: 0.800</span>
                                            <span class="text-error">04:18 UTC (0.614)</span>
                                        </div>
                                        <svg class="w-full h-16 text-primary" fill="none" viewbox="0 0 360 64">
                                            <!-- SLA Threshold Line -->
                                            <line stroke="#ffb4ab" stroke-dasharray="3 3" stroke-width="1.5" x1="0" x2="360" y1="28" y2="28"></line>
                                            <text fill="#ffb4ab" font-family="Space Mono" font-size="9" x="310" y="24">SLA 0.80</text>
                                            <!-- Telemetry Line -->
                                            <polyline fill="none" points="0,12 50,14 100,11 150,13 200,14 240,16 270,36 300,52 330,58 360,60" stroke="#ffb4ab" stroke-width="2.5"></polyline>
                                            <!-- Gradient under curve -->
                                            <polygon fill="currentColor" fill-opacity="0.08" points="0,12 50,14 100,11 150,13 200,14 240,16 270,36 300,52 330,58 360,60 360,64 0,64"></polygon>
                                            <!-- Trigger Dot -->
                                            <circle cx="270" cy="36" fill="#ffb4ab" r="3.5"></circle>
                                            <circle cx="360" cy="60" fill="#ff5252" r="4"></circle>
                                        </svg>
                                    </div>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant">
                                        Sharp collapse coincided with payload ingest timestamp 04:02 UTC. Precision dropped from 0.89 to 0.54.
                                    </p>
                                </div>
                                <!-- Card 2: Distribution Anomaly -->
                                <div class="bg-surface-container-low rounded-lg p-space-md flex flex-col gap-space-xs hover:bg-surface-container-high/60 transition-colors">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-1.5">
                                            <span class="w-2 h-2 rounded-full bg-tertiary"></span>
                                            <span class="font-label-code text-label-code text-on-surface font-bold">KS Drift Anomaly: account_age_months</span>
                                        </div>
                                        <span class="font-label-technical text-[10px] text-secondary bg-surface-container-high px-1.5 py-0.5 rounded">Pinned: Drift Workspace</span>
                                    </div>
                                    <!-- Mini Histogram Representation -->
                                    <div class="w-full bg-surface-container-lowest rounded p-2 my-1">
                                        <div class="flex items-center justify-between font-label-code text-[10px] text-outline mb-1.5">
                                            <span>Ref Distribution vs Live Prod</span>
                                            <span class="text-tertiary font-bold">KS-stat: 0.4218 (p &lt; 0.0001)</span>
                                        </div>
                                        <div class="flex items-end gap-1.5 h-14 w-full px-1">
                                            <!-- Bar 0 (Huge spike at 0) -->
                                            <div class="flex-1 flex flex-col items-center gap-1 h-full justify-end">
                                                <div class="w-full bg-error rounded-t" style="height: 94%;"></div>
                                                <span class="font-label-code text-[9px] text-error font-bold">0.0</span>
                                            </div>
                                            <!-- Bar 1 -->
                                            <div class="flex-1 flex flex-col items-center gap-1 h-full justify-end">
                                                <div class="w-full bg-secondary/40 rounded-t" style="height: 18%;"></div>
                                                <span class="font-label-code text-[9px] text-outline">1-12</span>
                                            </div>
                                            <!-- Bar 2 -->
                                            <div class="flex-1 flex flex-col items-center gap-1 h-full justify-end">
                                                <div class="w-full bg-secondary/40 rounded-t" style="height: 24%;"></div>
                                                <span class="font-label-code text-[9px] text-outline">13-24</span>
                                            </div>
                                            <!-- Bar 3 -->
                                            <div class="flex-1 flex flex-col items-center gap-1 h-full justify-end">
                                                <div class="w-full bg-secondary/40 rounded-t" style="height: 32%;"></div>
                                                <span class="font-label-code text-[9px] text-outline">25-36</span>
                                            </div>
                                            <!-- Bar 4 -->
                                            <div class="flex-1 flex flex-col items-center gap-1 h-full justify-end">
                                                <div class="w-full bg-secondary/40 rounded-t" style="height: 14%;"></div>
                                                <span class="font-label-code text-[9px] text-outline">37+</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between font-label-code text-[11px]">
                                        <span class="text-on-surface">Spike magnitude at zero: <strong class="text-error">78.4% of total inferences</strong></span>
                                        <span class="text-outline">Baseline was 3.1%</span>
                                    </div>
                                </div>
                                <!-- Card 3: Upstream Payload JSON Trace -->
                                <div class="bg-surface-container-low rounded-lg p-space-md flex flex-col gap-space-xs hover:bg-surface-container-high/60 transition-colors">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-1.5">
                                            <span class="material-symbols-outlined text-[16px] text-error">data_object</span>
                                            <span class="font-label-code text-label-code text-on-surface font-bold">CRM-FEED Ingest Contract Diff</span>
                                        </div>
                                        <span class="font-label-technical text-[10px] text-error bg-error-container/40 px-1.5 py-0.5 rounded">Contract Error</span>
                                    </div>
                                    <div class="bg-surface-container-lowest rounded p-2.5 font-label-code text-[11px] leading-relaxed overflow-x-auto text-on-surface-variant">
                                        <div><span class="text-outline">// Expected payload (Schema v1.7):</span></div>
                                        <div class="text-outline-variant">{"user_id": "U-91823", <span class="text-secondary">"account_age_months": 24</span>, "mrr_tier": 3}</div>
                                        <div class="mt-1"><span class="text-error font-bold">// Actual ingested payload (v1.8 deploy @ 03:45 UTC):</span></div>
                                        <div class="bg-error-container/20 p-1 rounded text-on-surface">
                                            {"user_id": "U-91823", <span class="text-error font-bold underline">"creation_timestamp": "2022-04-12T08:19:00Z"</span>, "mrr_tier": 3}
                                            <div class="text-[10px] text-error font-semibold mt-0.5">&gt; Gateway fillna(0) coerced absent account_age_months → 0</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Section: Investigation Notes & Hypothesis Scratchpad -->
                        <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-lg flex flex-col gap-space-md flex-1">
                            <div class="flex items-center justify-between pb-space-xs">
                                <div class="flex items-center gap-space-xs">
                                    <span class="material-symbols-outlined text-secondary text-[20px]">psychology</span>
                                    <span class="font-headline-md text-[16px] text-primary tracking-tight">Active Hypotheses Scratchpad</span>
                                </div>
                                <span class="font-label-technical text-[10px] text-tertiary bg-tertiary-container px-2 py-0.5 rounded">2 CONTRIBUTING COLLABORATORS</span>
                            </div>
                            <!-- Hypothesis 1 Card -->
                            <div class="bg-surface-container-low rounded-lg p-space-md flex flex-col gap-space-sm">
                                <div class="flex items-center justify-between">
                                    <span class="font-label-technical text-label-technical text-tertiary uppercase tracking-wider font-bold">Hypothesis #1 (Primary Root Cause)</span>
                                    <span class="font-label-code text-[10px] text-secondary bg-surface-container px-1.5 py-0.5 rounded">CONFIDENCE: 98%</span>
                                </div>
                                <p class="font-body-md text-body-md text-on-surface">
                                    Upstream CRM feed changed payload schema without registry schema contract enforcement. Gateway default imputer filled missing integer column with 0, skewing tree predictions towards <span class="font-label-code font-bold text-error">Churn=1</span> (model learned accounts under 1 month are 8.2x more likely to churn).
                                </p>
                                <!-- Collaborative Thread Reply -->
                                <div class="bg-surface-container rounded p-space-sm flex flex-col gap-1 mt-1">
                                    <div class="flex items-center justify-between font-label-code text-label-code">
                                        <div class="flex items-center gap-1.5">
                                            <span class="w-4 h-4 rounded-full bg-secondary-container text-on-secondary-container text-[9px] flex items-center justify-center font-bold">DR</span>
                                            <span class="text-secondary font-bold">Dr. Romanova (Sr. AI Lead)</span>
                                        </div>
                                        <span class="text-[10px] text-outline">04:38 UTC</span>
                                    </div>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant italic pl-5">
                                        "Evidence confirms slice under 6 months took the brunt. Confirm if canary rollback to v2.4.0 is viable or if retraining on v1.8 schema is required via SYS-AI-03."
                                    </p>
                                </div>
                            </div>
                            <!-- Rich Text Scratchpad Editor Mockup -->
                            <div class="bg-surface-container-low rounded-lg p-space-sm flex flex-col gap-space-xs">
                                <div class="flex items-center justify-between font-label-code text-[11px] text-outline pb-1">
                                    <div class="flex items-center gap-2">
                                        <button class="hover:text-primary font-bold">B</button>
                                        <button class="hover:text-primary italic">I</button>
                                        <button class="hover:text-primary">Code</button>
                                        <button class="hover:text-primary">Insert Artifact</button>
                                    </div>
                                    <span>Auto-saving to War Room log...</span>
                                </div>
                                <textarea class="w-full bg-surface-container text-on-surface font-body-sm text-body-sm p-2 rounded focus:outline-none focus:ring-1 focus:ring-secondary placeholder:text-outline" placeholder="Alexei: Adding verification from Kafka ingest buffer lag..." rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- RIGHT COLUMN: REMEDIATION, ACTION CONTROLS & IMPACT (Cols: 4) -->
                    <div class="xl:col-span-4 flex flex-col gap-space-lg">
                        <!-- Impact & Blast Radius Meter -->
                        <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-lg flex flex-col gap-space-md">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-space-xs">
                                    <span class="material-symbols-outlined text-error text-[20px]">radar</span>
                                    <span class="font-headline-md text-[16px] text-primary tracking-tight">Blast Radius &amp; Business Impact</span>
                                </div>
                                <span class="font-label-technical text-label-technical text-error bg-error-container/30 px-1.5 py-0.5 rounded uppercase">CRITICAL SLA VIOLATION</span>
                            </div>
                            <div class="grid grid-cols-3 gap-space-sm">
                                <div class="bg-surface-container-low rounded-lg p-space-sm flex flex-col">
                                    <span class="font-label-technical text-[10px] text-outline uppercase">Impacted Req</span>
                                    <span class="font-metric-display text-[22px] text-on-surface font-bold leading-tight mt-1">4,210</span>
                                    <span class="font-label-code text-[10px] text-error">In past 44m</span>
                                </div>
                                <div class="bg-surface-container-low rounded-lg p-space-sm flex flex-col">
                                    <span class="font-label-technical text-[10px] text-outline uppercase">False Positives</span>
                                    <span class="font-metric-display text-[22px] text-tertiary font-bold leading-tight mt-1">~1,440</span>
                                    <span class="font-label-code text-[10px] text-tertiary">Misrouted users</span>
                                </div>
                                <div class="bg-surface-container-low rounded-lg p-space-sm flex flex-col">
                                    <span class="font-label-technical text-[10px] text-outline uppercase">Promo Drift</span>
                                    <span class="font-metric-display text-[22px] text-error font-bold leading-tight mt-1">$18.4k</span>
                                    <span class="font-label-code text-[10px] text-outline">Promo spend</span>
                                </div>
                            </div>
                            <!-- Telemetry Progress Bar for Blast Containment -->
                            <div class="flex flex-col gap-1">
                                <div class="flex items-center justify-between font-label-code text-[11px]">
                                    <span class="text-on-surface-variant">Cluster Traffic Containment</span>
                                    <span class="text-error font-bold">12% Isolated (88% at Risk)</span>
                                </div>
                                <div class="w-full h-1.5 bg-surface-container-high rounded-full overflow-hidden">
                                    <div class="bg-error h-full rounded-full" style="width: 12%;"></div>
                                </div>
                            </div>
                        </div>
                        <!-- Remediation & Mitigation Runbook -->
                        <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-lg flex flex-col gap-space-md flex-1">
                            <div class="flex items-center justify-between pb-space-xs">
                                <div class="flex items-center gap-space-xs">
                                    <span class="material-symbols-outlined text-secondary text-[20px]">terminal</span>
                                    <span class="font-headline-md text-[16px] text-primary tracking-tight">Mitigation Runbook Controls</span>
                                </div>
                                <span class="font-label-technical text-label-technical text-secondary bg-surface-container-high px-1.5 py-0.5 rounded">STAGE 13 → 14</span>
                            </div>
                            <div class="flex flex-col gap-space-md">
                                <!-- Action Box A: Rollback Canary -->
                                <div class="bg-surface-container-low rounded-lg p-space-md flex flex-col gap-space-sm relative overflow-hidden">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-1.5">
                                            <span class="material-symbols-outlined text-secondary text-[18px]">replay</span>
                                            <span class="font-label-code text-label-code text-on-surface font-bold">Action A: Canary Rollback v2.4.0</span>
                                        </div>
                                        <span class="font-label-technical text-[10px] text-secondary font-bold bg-secondary-container/40 px-1.5 py-0.5 rounded">SYS-AI-04 REGISTRY</span>
                                    </div>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant">
                                        Deploy verified container hash <code class="text-primary font-label-code text-[11px] bg-surface-container px-1">#9f8a4e</code>. Baseline F1: 0.87. Employs resilient fallback schema handling.
                                    </p>
                                    <div class="flex items-center justify-between font-label-code text-[11px] text-outline">
                                        <span>Status: <strong class="text-primary">READY TO DEPLOY</strong></span>
                                        <span>Canary: 5% → 100%</span>
                                    </div>
                                    <!-- Inverted Command CTA -->
                                    <button class="w-full bg-secondary-container hover:bg-surface-bright text-tertiary font-label-code text-label-code font-bold py-2.5 px-space-md rounded flex items-center justify-center gap-2 transition-all shadow-md mt-1">
                                        <span class="material-symbols-outlined text-tertiary text-[18px]">rocket_launch</span>
                                        <span>EXECUTE ROLLBACK CANARY v2.4.0</span>
                                    </button>
                                </div>
                                <!-- Action Box B: Automated Retraining Pipeline -->
                                <div class="bg-surface-container-low rounded-lg p-space-md flex flex-col gap-space-sm">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-1.5">
                                            <span class="material-symbols-outlined text-primary text-[18px]">model_training</span>
                                            <span class="font-label-code text-label-code text-on-surface font-bold">Action B: Trigger Retraining</span>
                                        </div>
                                        <span class="font-label-technical text-[10px] text-outline bg-surface-container px-1.5 py-0.5 rounded">SYS-AI-03 WORKBENCH</span>
                                    </div>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant">
                                        Dispatch pipeline <code class="text-primary font-label-code text-[11px] bg-surface-container px-1">pipeline_churn_retrain_v2.5</code> mapped to updated ISO-8601 schema contract v1.8.
                                    </p>
                                    <button class="w-full bg-surface-container-high hover:bg-surface-bright text-on-surface font-label-code text-label-code py-2 px-space-md rounded flex items-center justify-center gap-2 transition-colors">
                                        <span class="material-symbols-outlined text-[16px]">play_circle</span>
                                        <span>Dispatch Retraining Job via SYS-AI-03</span>
                                    </button>
                                </div>
                                <!-- Action Box C: Upstream Hotfix Ticket -->
                                <div class="bg-surface-container-low rounded-lg p-space-md flex flex-col gap-space-sm">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-1.5">
                                            <span class="material-symbols-outlined text-tertiary text-[18px]">confirmation_number</span>
                                            <span class="font-label-code text-label-code text-on-surface font-bold">Action C: Upstream Feed Hotfix</span>
                                        </div>
                                        <span class="font-label-technical text-[10px] text-tertiary bg-tertiary-container px-1.5 py-0.5 rounded">DISPATCHED</span>
                                    </div>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant">
                                        Ticket <span class="text-on-surface font-label-code text-[11px]">#CR-8821</span> escalated to CRM Engineering. Schema coercion active at ingress load-balancer.
                                    </p>
                                </div>
                            </div>
                            <!-- BOTTOM ACTION STRIP -->
                            <div class="mt-auto pt-space-md flex flex-col sm:flex-row items-center gap-space-sm">
                                <button class="w-full sm:w-auto flex-1 bg-surface-container hover:bg-surface-container-high text-on-surface font-label-code text-label-code py-2.5 px-space-md rounded flex items-center justify-center gap-1 transition-colors">
                                    <span class="material-symbols-outlined text-[18px]">bookmark_add</span>
                                    <span>Save Snapshot</span>
                                </button>
                                <a class="w-full sm:w-auto flex-1 bg-primary hover:bg-inverse-surface text-on-primary font-label-code text-label-code font-bold py-2.5 px-space-md rounded flex items-center justify-center gap-1 transition-colors shadow-lg" href="#">
                                    <span>Post-Mortem &amp; Grading (Screen 6)</span>
                                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>