<!DOCTYPE html>

<html class="dark" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="web_dashboard" name="shell-type" />
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&amp;family=IBM+Plex+Mono:wght@400;500;600&amp;family=Inter:wght@400;500;600&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />
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

        .dot-canvas {
            background-image: radial-gradient(rgba(92, 114, 144, 0.22) 1px, transparent 1px);
            background-size: 20px 20px;
        }
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "inverse-primary": "#4d6077",
                        "on-primary-fixed-variant": "#35485e",
                        "tertiary-fixed-dim": "#ffb956",
                        "on-background": "#d3e4ff",
                        "primary-fixed-dim": "#b4c8e3",
                        "on-secondary-fixed-variant": "#2b486b",
                        "on-error-container": "#ffdad6",
                        "inverse-surface": "#d3e4ff",
                        "surface-tint": "#b4c8e3",
                        "primary-fixed": "#d0e4ff",
                        "surface-dim": "#00142a",
                        "inverse-on-surface": "#1a314c",
                        "on-secondary": "#113253",
                        "secondary-fixed-dim": "#abc9f2",
                        "on-primary-container": "#788ca4",
                        "primary": "#b4c8e3",
                        "on-tertiary-fixed-variant": "#643f00",
                        "on-primary": "#1e3246",
                        "secondary": "#abc9f2",
                        "surface-container-lowest": "#000f21",
                        "tertiary-container": "#331e00",
                        "on-error": "#690005",
                        "surface": "#00142a",
                        "outline-variant": "#43474c",
                        "on-secondary-container": "#9ab7e0",
                        "surface-container": "#06203a",
                        "secondary-container": "#2b486b",
                        "surface-container-high": "#132b45",
                        "on-tertiary": "#462b00",
                        "error-container": "#93000a",
                        "tertiary-fixed": "#ffddb5",
                        "on-secondary-fixed": "#001c38",
                        "surface-container-highest": "#1f3651",
                        "surface-container-low": "#021c36",
                        "on-tertiary-container": "#bb7d16",
                        "surface-bright": "#243a56",
                        "secondary-fixed": "#d2e4ff",
                        "on-surface": "#d3e4ff",
                        "background": "#00142a",
                        "on-tertiary-fixed": "#2a1800",
                        "surface-variant": "#1f3651",
                        "outline": "#8e9197",
                        "on-primary-fixed": "#071d30",
                        "primary-container": "#0f2438",
                        "on-surface-variant": "#c4c6cd",
                        "error": "#ffb4ab",
                        "tertiary": "#ffb956"
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    spacing: {
                        "space-md": "1rem",
                        "gutter-lg": "1.5rem",
                        "gutter-sm": "0.75rem",
                        "space-xl": "2rem",
                        "margin": "1.5rem",
                        "margin-mobile": "0.75rem",
                        "space-sm": "0.5rem",
                        "gutter": "1rem",
                        "space-xs": "0.25rem",
                        "space-lg": "1.25rem"
                    },
                    fontFamily: {
                        "code-block": ["IBM Plex Mono"],
                        "headline-sm": ["IBM Plex Sans"],
                        "body-sm": ["Inter"],
                        "headline-xl": ["IBM Plex Sans"],
                        "headline-lg": ["IBM Plex Sans"],
                        "label-mono": ["IBM Plex Mono"],
                        "label-caps": ["IBM Plex Sans"],
                        "body-md": ["Inter"],
                        "body-lg": ["Inter"],
                        "display-lg": ["IBM Plex Sans"]
                    },
                    fontSize: {
                        "code-block": ["12px", {
                            lineHeight: "18px",
                            letterSpacing: "0",
                            fontWeight: "400"
                        }],
                        "headline-sm": ["16px", {
                            lineHeight: "22px",
                            letterSpacing: "0",
                            fontWeight: "600"
                        }],
                        "body-sm": ["11px", {
                            lineHeight: "16px",
                            letterSpacing: "0.01em",
                            fontWeight: "400"
                        }],
                        "headline-xl": ["28px", {
                            lineHeight: "36px",
                            letterSpacing: "-0.015em",
                            fontWeight: "600"
                        }],
                        "headline-lg": ["22px", {
                            lineHeight: "28px",
                            letterSpacing: "-0.01em",
                            fontWeight: "600"
                        }],
                        "label-mono": ["11px", {
                            lineHeight: "16px",
                            letterSpacing: "0",
                            fontWeight: "500"
                        }],
                        "label-caps": ["10px", {
                            lineHeight: "14px",
                            letterSpacing: "0.08em",
                            fontWeight: "700"
                        }],
                        "body-md": ["13px", {
                            lineHeight: "18px",
                            letterSpacing: "0",
                            fontWeight: "400"
                        }],
                        "body-lg": ["15px", {
                            lineHeight: "22px",
                            letterSpacing: "-0.005em",
                            fontWeight: "400"
                        }],
                        "display-lg": ["40px", {
                            lineHeight: "48px",
                            letterSpacing: "-0.02em",
                            fontWeight: "600"
                        }]
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-surface font-body-md text-on-surface dot-canvas min-h-screen selection:bg-tertiary-container selection:text-tertiary">
    <aside class="fixed left-0 top-0 h-screen w-72 bg-surface-container-lowest z-50 flex flex-col justify-between shadow-[0_4px_24px_rgba(0,15,33,0.85)]">
        <div class="flex flex-col">
            <div class="h-28 px-margin flex items-center gap-space-sm bg-surface-container-low"><img alt="VOSTOKPRIBOR AI Logo" class="h-8 w-auto object-contain" src="https://lh3.googleusercontent.com/aida/AEtjO1XHoxhySz1mH3qmcu61N39gpBST6l-6XaiWmDjtOuvpCRnl0Oo_OBE8HwRBHnGCAYjSlThJVvwLegXib7kbEsVuk6VXE-EAyeS_MjvjXLnb8RyGlFmzIZ2gWBzIeR1LSWCcij1GPGSWcxs3ujopC1-eH7HuhVven4vmxCtgcTBeQd3XtZcgh1QK_mzl2fHi0QbYDusgXGahXmMY51GW6Staf5pWlMR3ON8c5fBNhSz401cVJ5W2-4I" />
                <div class="flex flex-col"><span class="font-headline-sm text-headline-sm tracking-tight text-on-surface font-bold leading-none">VOSTOKPRIBOR</span>
                    <div class="flex items-center gap-space-xs mt-1"><span class="font-label-caps text-label-caps text-tertiary bg-tertiary-container px-1 py-0.5 rounded">SYS-AI-04</span><span class="font-label-mono text-label-mono text-on-surface-variant">v4.8.2-rt</span></div>
                </div>
            </div>
            <div class="px-margin pt-space-md pb-space-xs"><span class="font-label-caps text-label-caps text-on-primary-container uppercase tracking-wider">Operational Modules</span></div>
            <nav class="flex flex-col px-space-sm gap-space-xs" data-active-classes="bg-surface-container text-primary font-semibold shadow-[inset_3px_0_0_#ffb956]"><a class="flex items-center justify-between px-space-md py-space-sm rounded text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors group" data-path="projects" href="#">
                    <div class="flex items-center gap-space-sm"><span class="font-label-mono text-label-mono text-outline">01</span><span class="font-body-md text-body-md">Projects</span></div><span class="font-label-caps text-label-caps text-outline group-hover:text-primary">SYS-AI-01</span>
                </a><a class="flex items-center justify-between px-space-md py-space-sm rounded text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors group" data-path="data-center" href="#">
                    <div class="flex items-center gap-space-sm"><span class="font-label-mono text-label-mono text-outline">02</span><span class="font-body-md text-body-md">Data Center</span></div><span class="font-label-caps text-label-caps text-outline group-hover:text-primary">SYS-AI-02</span>
                </a><a class="flex items-center justify-between px-space-md py-space-sm rounded text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors group" data-path="workbench" href="#">
                    <div class="flex items-center gap-space-sm"><span class="font-label-mono text-label-mono text-outline">03</span><span class="font-body-md text-body-md">Workbench</span></div><span class="font-label-caps text-label-caps text-outline group-hover:text-primary">SYS-AI-03</span>
                </a><a class="flex items-center justify-between px-space-md py-space-sm rounded text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors group" data-path="model-registry" href="#">
                    <div class="flex items-center gap-space-sm"><span class="font-label-mono text-label-mono text-outline">04</span><span class="font-body-md text-body-md">Registry &amp; Deployment</span></div><span class="font-label-caps text-label-caps text-outline group-hover:text-primary">SYS-AI-04</span>
                </a><a class="flex items-center justify-between px-space-md py-space-sm rounded text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors group" data-path="ai-soc" href="#">
                    <div class="flex items-center gap-space-sm"><span class="font-label-mono text-label-mono text-outline">05</span><span class="font-body-md text-body-md">AI SOC</span></div><span class="font-label-caps text-label-caps text-outline group-hover:text-primary">SYS-AI-05</span>
                </a></nav>
        </div>
        <div class="p-space-md m-space-sm bg-surface-container-low rounded flex flex-col gap-space-xs">
            <div class="flex items-center justify-between"><span class="font-label-caps text-label-caps text-on-surface-variant">NODE TELEMETRY</span><span class="font-label-mono text-label-mono text-tertiary flex items-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-tertiary"></span>SYNCED</span></div>
            <div class="flex justify-between font-label-mono text-label-mono text-outline-variant"><span>UPTIME</span><span class="text-on-surface-variant">99.982%</span></div>
            <div class="flex justify-between font-label-mono text-label-mono text-outline-variant"><span>VRAM USE</span><span class="text-on-surface-variant">78.4 GB / 80 GB</span></div>
        </div>
    </aside>
    <div class="pl-72 flex flex-col min-h-screen">
        <header class="fixed top-0 left-72 right-0 h-28 bg-surface-container-lowest/95 backdrop-blur-md z-40 flex flex-col justify-between shadow-[0_4px_16px_rgba(0,15,33,0.65)]">
            <div class="h-16 px-gutter flex items-center justify-between gap-space-md">
                <div class="flex items-center gap-space-md flex-1">
                    <div class="flex items-center gap-space-xs bg-surface-container-low px-space-sm py-1 rounded"><span class="font-label-mono text-label-mono text-tertiary bg-tertiary-container px-1 rounded">GATE</span><span class="font-label-mono text-label-mono text-on-surface">#AI-024 Customer Churn · Production Gate Active</span></div>
                    <div class="relative flex items-center flex-1 max-w-sm"><input class="w-full bg-surface-container-high text-on-surface font-body-sm text-body-sm pl-8 pr-12 py-1.5 rounded focus:outline-none placeholder:text-outline" placeholder="Search registry, checkpoints, schemas..." type="text" /><span class="material-symbols-outlined text-outline absolute left-2 text-[16px]">search</span><span class="font-label-mono text-label-mono text-on-surface-variant bg-surface-container px-1 py-0.5 rounded absolute right-2">⌘K</span></div>
                </div>
                <div class="flex items-center gap-space-md">
                    <div class="hidden xl:flex items-center bg-surface-container-high px-space-sm py-1 rounded gap-space-xs"><span class="w-2 h-2 rounded-full bg-tertiary"></span><span class="font-label-caps text-label-caps text-on-surface">MODE: Intern AI Engineer · Level 2</span></div><button class="font-label-caps text-label-caps px-space-sm py-1 bg-surface-container text-on-surface-variant rounded hover:text-on-surface hover:bg-surface-container-high transition-colors">EN / AR (عربي)</button><button class="text-on-surface-variant hover:text-on-surface p-1 rounded hover:bg-surface-container transition-colors relative"><span class="material-symbols-outlined text-[20px]">notifications</span><span class="absolute top-1 right-1 w-1.5 h-1.5 bg-tertiary rounded-full"></span></button>
                    <div class="flex items-center gap-space-sm pl-space-xs">
                        <div class="relative"><img alt="Profile" class="w-8 h-8 rounded-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDp7298NZ2kUJ525yYp1FaQ_S4Y0JjkZ0qqht6xDCoypcktuq9krc7sS5OJeRyxie0-xEcmq8I6NosC4XmNfCAGKphm4PtNts1AVn5_KvD9KrrQLVFE5yHWrNmxztCQJeIwLyXHAISgX5RiG-kRJaF5uLZLQ8ZbVofRpYSTPDD_idM74uV-wWSbbaMiKmHN86o5jE5rXbrpw8kdfPV24s4Vi98SnyqxDGHyhWfhwFAE_PHHtOMUgtU" /><span class="absolute bottom-0 right-0 w-2 h-2 bg-tertiary rounded-full ring-2 ring-surface-container-lowest"></span></div>
                        <div class="hidden lg:flex flex-col"><span class="font-headline-sm text-body-sm font-semibold text-on-surface leading-tight">Sarah Chen</span><span class="font-label-mono text-label-mono text-on-surface-variant leading-tight">Intern #4092</span></div>
                    </div>
                </div>
            </div>
            <div class="h-12 px-gutter bg-surface-container-low flex items-center justify-between overflow-x-auto">
                <div class="flex items-center gap-space-xs"><span class="font-label-caps text-label-caps text-outline mr-2">PIPELINE:</span>
                    <div class="flex items-center gap-1 font-label-mono text-label-mono"><span class="px-1.5 py-0.5 rounded bg-surface-container text-outline">01</span><span class="px-1.5 py-0.5 rounded bg-surface-container text-outline">02</span><span class="px-1.5 py-0.5 rounded bg-surface-container text-outline">03</span><span class="px-1.5 py-0.5 rounded bg-surface-container text-outline">04</span><span class="px-1.5 py-0.5 rounded bg-surface-container text-outline">05</span><span class="px-1.5 py-0.5 rounded bg-surface-container text-outline">06</span><span class="px-1.5 py-0.5 rounded bg-surface-container text-outline">07</span><span class="px-1.5 py-0.5 rounded bg-surface-container text-outline">08</span><span class="px-1.5 py-0.5 rounded bg-surface-container text-outline">09</span><span class="px-2 py-0.5 rounded bg-tertiary-container text-tertiary font-semibold">10: VALIDATION</span><span class="px-2 py-0.5 rounded bg-secondary-container text-secondary font-semibold">11: SERVING</span><span class="px-1.5 py-0.5 rounded bg-surface-container text-outline">12</span><span class="px-1.5 py-0.5 rounded bg-surface-container text-outline">13</span><span class="px-1.5 py-0.5 rounded bg-surface-container text-outline">14</span></div>
                </div>
                <nav class="flex items-center gap-space-xs" data-active-classes="bg-surface-container-highest text-primary font-semibold"><a class="font-body-sm text-body-sm px-space-sm py-1 rounded text-on-surface-variant hover:text-on-surface hover:bg-surface-container transition-colors" data-path="model-registry" href="#">Model Registry</a><a class="font-body-sm text-body-sm px-space-sm py-1 rounded text-on-surface-variant hover:text-on-surface hover:bg-surface-container transition-colors" data-path="model-card" href="#">Model Card (churn_rf_v2)</a><a class="font-body-sm text-body-sm px-space-sm py-1 rounded text-on-surface-variant hover:text-on-surface hover:bg-surface-container transition-colors" data-path="deployment-wizard" href="#">Deployment Wizard</a><a class="font-body-sm text-body-sm px-space-sm py-1 rounded text-on-surface-variant hover:text-on-surface hover:bg-surface-container transition-colors" data-path="endpoint-console" href="#">Endpoint Console (Swagger)</a><a class="font-body-sm text-body-sm px-space-sm py-1 rounded text-on-surface-variant hover:text-on-surface hover:bg-surface-container transition-colors" data-path="enterprise-integrations" href="#">Enterprise Integrations</a><a class="font-body-sm text-body-sm px-space-sm py-1 rounded text-on-surface-variant hover:text-on-surface hover:bg-surface-container transition-colors" data-path="releases-rollback" href="#">Releases &amp; Rollback</a></nav>
            </div>
        </header>
        <main class="relative pt-28 pb-8 px-gutter w-full flex-1 bg-transparent">
            <div class="flex flex-col w-full gap-space-md">
                <!-- Operational Subheader / Model Mesh Context Bar -->
                <div class="w-full bg-surface-container-low rounded-lg p-space-md shadow-sm flex flex-col xl:flex-row xl:items-center justify-between gap-space-md">
                    <div class="flex flex-wrap items-center gap-space-md min-w-0">
                        <div class="flex items-center gap-space-sm">
                            <span class="font-label-caps text-label-caps px-2 py-1 rounded bg-tertiary-container text-tertiary font-bold tracking-wider">GATE ACTIVE</span>
                            <span class="font-headline-sm text-headline-sm text-on-surface font-semibold tracking-tight">churn_rf_v2</span>
                            <span class="font-label-mono text-label-mono px-1.5 py-0.5 rounded bg-surface-container-high text-primary-fixed">v2.4.0</span>
                        </div>
                        <div class="hidden sm:block w-px h-6 bg-surface-container-highest"></div>
                        <div class="flex flex-wrap items-center gap-space-sm font-label-mono text-label-mono">
                            <span class="text-on-surface-variant flex items-center gap-1">
                                <span class="material-symbols-outlined text-[15px] text-tertiary">confirmation_number</span>
                                TICKET: <span class="text-on-surface font-semibold">#AI-024 Customer Churn Prevention</span>
                            </span>
                            <span class="text-outline-variant">/</span>
                            <span class="text-secondary flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
                                4 Pipelines Connected
                            </span>
                            <span class="text-outline-variant">/</span>
                            <span class="text-on-surface-variant">Sync: <span class="text-tertiary">Real-Time Event Driven</span> (Kafka + Webhooks)</span>
                        </div>
                    </div>
                    <!-- Context Actions -->
                    <div class="flex items-center gap-space-sm shrink-0">
                        <button class="font-label-caps text-label-caps px-space-md py-1.5 rounded bg-surface-container hover:bg-surface-container-high text-on-surface transition-colors flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[16px] text-outline">history</span>
                            View Event Logs
                        </button>
                        <button class="font-label-caps text-label-caps px-space-md py-1.5 rounded bg-surface-container hover:bg-surface-container-high text-on-surface transition-colors flex items-center gap-1.5" id="btn-test-all">
                            <span class="material-symbols-outlined text-[16px] text-secondary">sync_alt</span>
                            Test All Webhooks
                        </button>
                        <button class="font-label-caps text-label-caps px-space-md py-1.5 rounded bg-primary-container hover:bg-surface-bright text-primary font-bold transition-colors flex items-center gap-1.5 shadow-[inset_3px_0_0_#ffb956]">
                            <span class="material-symbols-outlined text-[16px] text-tertiary">add_circle</span>
                            Add New Integration
                        </button>
                    </div>
                </div>
                <!-- Realtime Mesh Telemetry Bar -->
                <div class="w-full bg-surface-container-lowest px-space-md py-2 rounded flex flex-wrap items-center justify-between gap-space-sm font-label-mono text-label-mono">
                    <div class="flex items-center gap-space-md">
                        <span class="text-outline flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-tertiary animate-pulse"></span>
                            ENDPOINT:
                        </span>
                        <span class="text-on-surface bg-surface-container-high px-2 py-0.5 rounded text-code-block font-code-block">POST https://api.vostok.internal/v1/models/churn_rf_v2:predict</span>
                    </div>
                    <div class="flex items-center gap-space-lg text-outline-variant">
                        <span>INGRESS: <strong class="text-on-surface font-normal">24,192 req/hr</strong></span>
                        <span>MTLS PROTOCOL: <strong class="text-primary font-normal">TLSv1.3 AES-256-GCM</strong></span>
                        <span>GATEWAY TIME: <strong class="text-tertiary font-normal">0.82ms</strong></span>
                    </div>
                </div>
                <!-- Top Row: 4 Integration Status Bento Overview Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-space-md">
                    <!-- Card 1: SYS05 CRM -->
                    <div class="bg-surface-container-low rounded-xl p-space-md flex flex-col justify-between shadow-md relative overflow-hidden group hover:bg-surface-container transition-colors">
                        <div class="flex flex-col gap-space-xs">
                            <div class="flex items-center justify-between">
                                <span class="font-label-caps text-label-caps text-outline">[SYS-EXT // 05]</span>
                                <span class="font-label-mono text-label-mono px-1.5 py-0.5 rounded bg-secondary-container text-secondary flex items-center gap-1 font-semibold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span> HEALTHY
                                </span>
                            </div>
                            <div class="font-headline-sm text-headline-sm text-on-surface font-semibold mt-1">Enterprise CRM</div>
                            <p class="font-body-sm text-body-sm text-on-surface-variant">HubSpot / Salesforce Bridge Core</p>
                        </div>
                        <div class="mt-space-md pt-space-sm bg-surface-container-lowest/60 rounded p-2.5 flex flex-col gap-1 font-label-mono text-label-mono">
                            <div class="flex justify-between text-outline">
                                <span>LATENCY</span>
                                <span class="text-primary font-semibold">14ms</span>
                            </div>
                            <div class="flex justify-between text-outline">
                                <span>MODE</span>
                                <span class="text-on-surface">On-demand + Webhook</span>
                            </div>
                            <div class="flex justify-between text-outline">
                                <span>TARGET ENTITY</span>
                                <span class="text-tertiary truncate max-w-[140px]">crm.account</span>
                            </div>
                            <div class="mt-1 flex flex-wrap gap-1">
                                <span class="text-[9px] px-1 bg-surface-container rounded text-outline-variant">churn_risk_score</span>
                                <span class="text-[9px] px-1 bg-surface-container rounded text-outline-variant">confidence_tier</span>
                            </div>
                        </div>
                    </div>
                    <!-- Card 2: SYS07 Core Finance & Billing -->
                    <div class="bg-surface-container-low rounded-xl p-space-md flex flex-col justify-between shadow-md relative overflow-hidden group hover:bg-surface-container transition-colors">
                        <div class="flex flex-col gap-space-xs">
                            <div class="flex items-center justify-between">
                                <span class="font-label-caps text-label-caps text-outline">[SYS-EXT // 07]</span>
                                <span class="font-label-mono text-label-mono px-1.5 py-0.5 rounded bg-secondary-container text-secondary flex items-center gap-1 font-semibold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span> CONNECTED
                                </span>
                            </div>
                            <div class="font-headline-sm text-headline-sm text-on-surface font-semibold mt-1">Finance &amp; Billing</div>
                            <p class="font-body-sm text-body-sm text-on-surface-variant">ERP Revenue Impact Sync</p>
                        </div>
                        <div class="mt-space-md pt-space-sm bg-surface-container-lowest/60 rounded p-2.5 flex flex-col gap-1 font-label-mono text-label-mono">
                            <div class="flex justify-between text-outline">
                                <span>LATENCY</span>
                                <span class="text-primary font-semibold">38ms</span>
                            </div>
                            <div class="flex justify-between text-outline">
                                <span>SCHEDULE</span>
                                <span class="text-on-surface">Nightly + Invoice Triggers</span>
                            </div>
                            <div class="flex justify-between text-outline">
                                <span>WRITES</span>
                                <span class="text-tertiary truncate max-w-[140px]">revenue_at_risk</span>
                            </div>
                            <div class="mt-1 flex flex-wrap gap-1">
                                <span class="text-[9px] px-1 bg-surface-container rounded text-outline-variant">inv_flag</span>
                                <span class="text-[9px] px-1 bg-surface-container rounded text-outline-variant">payment_failure_mod</span>
                            </div>
                        </div>
                    </div>
                    <!-- Card 3: SYS08 Helpdesk Support -->
                    <div class="bg-surface-container-low rounded-xl p-space-md flex flex-col justify-between shadow-md relative overflow-hidden group hover:bg-surface-container transition-colors">
                        <div class="flex flex-col gap-space-xs">
                            <div class="flex items-center justify-between">
                                <span class="font-label-caps text-label-caps text-outline">[SYS-EXT // 08]</span>
                                <span class="font-label-mono text-label-mono px-1.5 py-0.5 rounded bg-secondary-container text-secondary flex items-center gap-1 font-semibold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span> CONNECTED
                                </span>
                            </div>
                            <div class="font-headline-sm text-headline-sm text-on-surface font-semibold mt-1">Helpdesk &amp; Support</div>
                            <p class="font-body-sm text-body-sm text-on-surface-variant">Zendesk / Jira Service Interceptor</p>
                        </div>
                        <div class="mt-space-md pt-space-sm bg-surface-container-lowest/60 rounded p-2.5 flex flex-col gap-1 font-label-mono text-label-mono">
                            <div class="flex justify-between text-outline">
                                <span>LATENCY</span>
                                <span class="text-primary font-semibold">9ms</span>
                            </div>
                            <div class="flex justify-between text-outline">
                                <span>TRIGGER</span>
                                <span class="text-on-surface">Ticket Create/Comment</span>
                            </div>
                            <div class="flex justify-between text-outline">
                                <span>ACTION</span>
                                <span class="text-tertiary">SLA Boost (Score &gt; 0.75)</span>
                            </div>
                            <div class="mt-1 flex flex-wrap gap-1">
                                <span class="text-[9px] px-1 bg-surface-container rounded text-outline-variant">VIP_queue</span>
                                <span class="text-[9px] px-1 bg-surface-container rounded text-outline-variant">escalation_tag</span>
                            </div>
                        </div>
                    </div>
                    <!-- Card 4: SYS-AI-05 AI SOC -->
                    <div class="bg-surface-container-low rounded-xl p-space-md flex flex-col justify-between shadow-md relative overflow-hidden group hover:bg-surface-container transition-colors">
                        <div class="flex flex-col gap-space-xs">
                            <div class="flex items-center justify-between">
                                <span class="font-label-caps text-label-caps text-tertiary">[SYS-AI // 05]</span>
                                <span class="font-label-mono text-label-mono px-1.5 py-0.5 rounded bg-tertiary-container text-tertiary flex items-center gap-1 font-bold">
                                    <span class="material-symbols-outlined text-[13px]">shield</span> ENFORCED
                                </span>
                            </div>
                            <div class="font-headline-sm text-headline-sm text-on-surface font-semibold mt-1">AI SOC Security Node</div>
                            <p class="font-body-sm text-body-sm text-on-surface-variant">Continuous Drift &amp; Attack Monitor</p>
                        </div>
                        <div class="mt-space-md pt-space-sm bg-surface-container-lowest/60 rounded p-2.5 flex flex-col gap-1 font-label-mono text-label-mono">
                            <div class="flex justify-between text-outline">
                                <span>INSPECTION</span>
                                <span class="text-primary font-semibold">100% Mirroring</span>
                            </div>
                            <div class="flex justify-between text-outline">
                                <span>SECURITY</span>
                                <span class="text-on-surface">Strict mTLS Verified</span>
                            </div>
                            <div class="flex justify-between text-outline">
                                <span>ANOMALY ALERT</span>
                                <span class="text-secondary font-semibold">0 Flags / 60m</span>
                            </div>
                            <div class="mt-1 flex flex-wrap gap-1">
                                <span class="text-[9px] px-1 bg-surface-container rounded text-outline-variant">drift_ps_score</span>
                                <span class="text-[9px] px-1 bg-surface-container rounded text-outline-variant">adversarial_detect</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Main Section: Asymmetric Split Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-md mt-space-xs">
                    <!-- Left Column (7 Columns): Field Mapping & Payload Schema Transformation Engine -->
                    <div class="lg:col-span-7 flex flex-col gap-space-md">
                        <div class="bg-surface-container-low rounded-xl p-space-lg shadow-md flex flex-col gap-space-md">
                            <!-- Header & Target System Tabs -->
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-space-sm pb-space-sm border-b border-surface-container-high">
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="font-label-caps text-label-caps text-outline">[MAPPER-AI // TRANSLATION-UNIT]</span>
                                        <span class="font-label-mono text-label-mono text-tertiary">SCHEMA v2.3-JSON</span>
                                    </div>
                                    <h2 class="font-headline-lg text-headline-lg text-on-surface font-bold tracking-tight">Downstream Payload Field Mappings</h2>
                                </div>
                                <!-- Downstream System Selector Tabs -->
                                <div class="flex items-center bg-surface-container-lowest p-1 rounded-lg gap-1">
                                    <button class="tab-target px-space-sm py-1 rounded text-body-sm font-body-sm bg-surface-container-high text-primary font-semibold shadow-sm transition-all" data-target="sys05">
                                        SYS05 CRM
                                    </button>
                                    <button class="tab-target px-space-sm py-1 rounded text-body-sm font-body-sm text-outline hover:text-on-surface transition-all" data-target="sys07">
                                        SYS07 Finance
                                    </button>
                                    <button class="tab-target px-space-sm py-1 rounded text-body-sm font-body-sm text-outline hover:text-on-surface transition-all" data-target="sys08">
                                        SYS08 Support
                                    </button>
                                </div>
                            </div>
                            <!-- System Target Context Overview Banner -->
                            <div class="bg-surface-container-lowest p-space-sm rounded-lg flex items-center justify-between gap-space-md text-body-sm font-body-sm">
                                <div class="flex items-center gap-space-sm min-w-0">
                                    <span class="material-symbols-outlined text-secondary text-[20px]">hub</span>
                                    <span class="text-on-surface-variant truncate">
                                        Destination Entity: <strong class="text-on-surface font-semibold font-code-block text-code-block">crm.vostok.internal/api/v2/accounts/{account_id}</strong>
                                    </span>
                                </div>
                                <span class="font-label-mono text-label-mono px-2 py-0.5 rounded bg-secondary-container text-secondary shrink-0">PATCH / UPSERT</span>
                            </div>
                            <!-- Visual Mapping Matrix -->
                            <div class="flex flex-col gap-space-sm">
                                <div class="flex items-center justify-between px-space-sm font-label-caps text-label-caps text-outline uppercase tracking-wider">
                                    <span class="w-5/12">Source Inference Key</span>
                                    <span class="w-2/12 text-center">Transform</span>
                                    <span class="w-5/12 text-right">Destination CRM Schema Field</span>
                                </div>
                                <!-- Mapping Row 1: churn_risk_score -->
                                <div class="bg-surface-container p-space-sm rounded-lg flex items-center justify-between gap-space-xs hover:bg-surface-container-high transition-colors">
                                    <div class="w-5/12 flex flex-col">
                                        <span class="font-code-block text-code-block text-primary font-semibold truncate">model.churn_risk_score</span>
                                        <span class="font-label-mono text-label-mono text-outline">Float32 [0.000 ... 1.000]</span>
                                    </div>
                                    <div class="w-2/12 flex justify-center">
                                        <span class="px-2 py-0.5 rounded bg-surface-container-lowest text-tertiary font-label-mono text-label-mono flex items-center gap-1 shadow-sm">
                                            ROUND(4) <span class="material-symbols-outlined text-[13px]">arrow_forward</span>
                                        </span>
                                    </div>
                                    <div class="w-5/12 flex flex-col text-right">
                                        <span class="font-code-block text-code-block text-tertiary font-semibold truncate">crm.account.predictive_churn_score</span>
                                        <span class="font-label-mono text-label-mono text-outline">Number · Scale: 4</span>
                                    </div>
                                </div>
                                <!-- Mapping Row 2: churn_decision -->
                                <div class="bg-surface-container p-space-sm rounded-lg flex items-center justify-between gap-space-xs hover:bg-surface-container-high transition-colors">
                                    <div class="w-5/12 flex flex-col">
                                        <span class="font-code-block text-code-block text-primary font-semibold truncate">model.churn_decision</span>
                                        <span class="font-label-mono text-label-mono text-outline">Boolean (True/False)</span>
                                    </div>
                                    <div class="w-2/12 flex justify-center">
                                        <span class="px-2 py-0.5 rounded bg-surface-container-lowest text-secondary font-label-mono text-label-mono flex items-center gap-1 shadow-sm">
                                            DIRECT <span class="material-symbols-outlined text-[13px]">arrow_forward</span>
                                        </span>
                                    </div>
                                    <div class="w-5/12 flex flex-col text-right">
                                        <span class="font-code-block text-code-block text-tertiary font-semibold truncate">crm.account.retention_risk_flag</span>
                                        <span class="font-label-mono text-label-mono text-outline">Boolean · Indexed</span>
                                    </div>
                                </div>
                                <!-- Mapping Row 3: confidence_tier -->
                                <div class="bg-surface-container p-space-sm rounded-lg flex items-center justify-between gap-space-xs hover:bg-surface-container-high transition-colors">
                                    <div class="w-5/12 flex flex-col">
                                        <span class="font-code-block text-code-block text-primary font-semibold truncate">model.confidence_tier</span>
                                        <span class="font-label-mono text-label-mono text-outline">String ('low','med','high')</span>
                                    </div>
                                    <div class="w-2/12 flex justify-center">
                                        <span class="px-2 py-0.5 rounded bg-surface-container-lowest text-tertiary font-label-mono text-label-mono flex items-center gap-1 shadow-sm">
                                            UPPERCASE <span class="material-symbols-outlined text-[13px]">arrow_forward</span>
                                        </span>
                                    </div>
                                    <div class="w-5/12 flex flex-col text-right">
                                        <span class="font-code-block text-code-block text-tertiary font-semibold truncate">crm.account.risk_category</span>
                                        <span class="font-label-mono text-label-mono text-outline">Enum ['LOW', 'MED', 'HIGH']</span>
                                    </div>
                                </div>
                                <!-- Mapping Row 4: latency_ms & audit -->
                                <div class="bg-surface-container p-space-sm rounded-lg flex items-center justify-between gap-space-xs hover:bg-surface-container-high transition-colors">
                                    <div class="w-5/12 flex flex-col">
                                        <span class="font-code-block text-code-block text-primary font-semibold truncate">telemetry.latency_ms</span>
                                        <span class="font-label-mono text-label-mono text-outline">Numeric (ms)</span>
                                    </div>
                                    <div class="w-2/12 flex justify-center">
                                        <span class="px-2 py-0.5 rounded bg-surface-container-lowest text-outline font-label-mono text-label-mono flex items-center gap-1 shadow-sm">
                                            PASS-AUDIT <span class="material-symbols-outlined text-[13px]">arrow_forward</span>
                                        </span>
                                    </div>
                                    <div class="w-5/12 flex flex-col text-right">
                                        <span class="font-code-block text-code-block text-tertiary font-semibold truncate">crm.audit.inference_latency</span>
                                        <span class="font-label-mono text-label-mono text-outline">Meta Object Log</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Transformation Logic & Orchestration Rules Editor -->
                            <div class="flex flex-col gap-space-xs mt-space-xs">
                                <div class="flex items-center justify-between">
                                    <span class="font-label-caps text-label-caps text-on-surface-variant flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[14px] text-tertiary">bolt</span>
                                        AUTOMATION ACTION RULES (DYNAMIC DISPATCH)
                                    </span>
                                    <span class="font-label-mono text-label-mono text-outline">RULE ENGINE: CEL v1.4</span>
                                </div>
                                <div class="bg-surface-container-lowest rounded-lg p-space-md font-code-block text-code-block text-on-surface flex flex-col gap-1.5 shadow-inner">
                                    <div class="flex items-center gap-2 text-outline font-label-mono text-label-mono pb-1 border-b border-surface-container-high">
                                        <span class="text-tertiary">RULE #CR-092:</span> Immediate Account Retention Escalation
                                    </div>
                                    <div class="pt-1 text-on-surface-variant leading-relaxed">
                                        <span class="text-secondary font-bold">WHEN</span> (model.churn_risk_score &gt;= <span class="text-tertiary font-bold">0.70</span> &amp;&amp; crm.account.mrr &gt;= <span class="text-tertiary font-bold">2500</span>) {<br />
                                          <span class="text-primary">dispatch_slack</span>(<span class="text-tertiary-fixed-dim">"#retention-war-room"</span>, <span class="text-outline">template="high_churn_vip"</span>);<br />
                                          <span class="text-primary">crm.create_task</span>({<br />
                                            assignee: <span class="text-on-surface">crm.account.dedicated_csm_id</span>,<br />
                                            priority: <span class="text-tertiary font-bold">"URGENT_P0"</span>,<br />
                                            title: <span class="text-tertiary-fixed-dim">"AI Churn Warning: Proactive Executive Call Scheduled"</span><br />
                                          });<br />
                                        }
                                    </div>
                                </div>
                            </div>
                            <!-- Action Bar: Test Handshake, Save, Revert -->
                            <div class="flex flex-wrap items-center justify-between gap-space-sm pt-space-xs border-t border-surface-container-high">
                                <div class="flex items-center gap-space-xs">
                                    <button class="font-label-caps text-label-caps px-space-md py-2 rounded bg-primary-container text-primary hover:bg-surface-bright font-bold transition-all shadow-[inset_3px_0_0_#ffb956] flex items-center gap-1" id="btn-save-schema">
                                        <span class="material-symbols-outlined text-[16px]">save</span>
                                        Save Mapping Schema
                                    </button>
                                    <button class="font-label-caps text-label-caps px-space-md py-2 rounded bg-surface-container hover:bg-surface-container-high text-on-surface-variant hover:text-on-surface transition-colors flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[16px]">restart_alt</span>
                                        Revert Defaults
                                    </button>
                                </div>
                                <button class="font-label-caps text-label-caps px-space-md py-2 rounded bg-secondary-container hover:bg-surface-bright text-secondary font-bold transition-all flex items-center gap-1.5 shadow-sm" id="btn-mock-dispatch">
                                    <span class="material-symbols-outlined text-[16px]">send</span>
                                    Test Connection &amp; Dispatch Mock Webhook
                                </button>
                            </div>
                            <!-- Live Test Handshake Inspector Feedback Card -->
                            <div class="bg-surface-container-lowest p-space-md rounded-lg flex flex-col gap-2 transition-all" id="mock-dispatch-result">
                                <div class="flex items-center justify-between font-label-mono text-label-mono">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-secondary"></span>
                                        <span class="text-on-surface font-semibold">LAST DISPATCH HANDSHAKE: SUCCESS (200 OK)</span>
                                    </div>
                                    <span class="text-outline">RTT: <strong class="text-primary font-normal">24ms</strong> · ACK: #TXN-90218-E</span>
                                </div>
                                <div class="bg-surface-container-high/40 rounded p-2 text-code-block font-code-block text-on-surface-variant flex flex-col gap-1">
                                    <div class="flex justify-between text-outline text-[11px]">
                                        <span>ENDPOINT: crm.vostok.internal/api/v2/accounts/CUST-8921-A</span>
                                        <span>TIMESTAMP: 2025-05-18T14:38:09.112Z</span>
                                    </div>
                                    <div class="text-primary-fixed">
                                        { "status": 200, "updated_fields": ["predictive_churn_score", "retention_risk_flag", "risk_category"], "account_id": "CUST-8921-A", "audit_ack": true }
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Right Column (5 Columns): SOC Telemetry, Webhook Security & Audit Logs -->
                    <div class="lg:col-span-5 flex flex-col gap-space-md">
                        <!-- Card A: SYS-AI-05 AI SOC Telemetry Stream Hook -->
                        <div class="bg-surface-container-low rounded-xl p-space-md shadow-md flex flex-col gap-space-sm">
                            <div class="flex items-center justify-between pb-space-xs border-b border-surface-container-high">
                                <div class="flex items-center gap-2">
                                    <span class="font-label-caps text-label-caps text-tertiary">[SECURITY // TELEMETRY]</span>
                                    <span class="font-headline-sm text-headline-sm text-on-surface font-semibold">AI SOC Real-Time Hook</span>
                                </div>
                                <span class="font-label-mono text-label-mono text-secondary px-2 py-0.5 rounded bg-secondary-container font-semibold">ENFORCED</span>
                            </div>
                            <!-- Controls: Continuous Drift & Circuit Breakers -->
                            <div class="flex flex-col gap-space-sm mt-1">
                                <!-- Toggle 1 -->
                                <div class="bg-surface-container p-2.5 rounded-lg flex items-center justify-between">
                                    <div class="flex flex-col">
                                        <span class="font-body-md text-body-md text-on-surface font-semibold leading-tight">Continuous Drift &amp; Shadow Monitoring</span>
                                        <span class="font-label-mono text-label-mono text-outline">Real-time mirror to SOC validation cluster</span>
                                    </div>
                                    <button class="relative inline-flex h-5 w-10 shrink-0 cursor-pointer rounded-full bg-secondary-container p-0.5 transition-colors duration-200 ease-in-out">
                                        <span class="translate-x-5 pointer-events-none inline-block h-4 w-4 rounded-full bg-secondary shadow transform transition duration-200 ease-in-out"></span>
                                    </button>
                                </div>
                                <!-- Toggle 2 -->
                                <div class="bg-surface-container p-2.5 rounded-lg flex items-center justify-between">
                                    <div class="flex flex-col">
                                        <span class="font-body-md text-body-md text-on-surface font-semibold leading-tight">Automatic Circuit Breaker</span>
                                        <span class="font-label-mono text-label-mono text-outline">Trip if 422 Rate &gt; 2.0% or Latency &gt; 100ms</span>
                                    </div>
                                    <button class="relative inline-flex h-5 w-10 shrink-0 cursor-pointer rounded-full bg-secondary-container p-0.5 transition-colors duration-200 ease-in-out">
                                        <span class="translate-x-5 pointer-events-none inline-block h-4 w-4 rounded-full bg-secondary shadow transform transition duration-200 ease-in-out"></span>
                                    </button>
                                </div>
                            </div>
                            <!-- Stream Destination Details -->
                            <div class="bg-surface-container-lowest p-2.5 rounded flex flex-col gap-1 font-label-mono text-label-mono">
                                <span class="text-outline text-[10px] uppercase">KAFKA TELEMETRY TOPIC SINK:</span>
                                <span class="text-on-surface select-all text-code-block font-code-block break-all">kafka://soc-telemetry.vostok.internal:9092/model-churn-events</span>
                            </div>
                            <!-- Event Sparkline & Counter Banner -->
                            <div class="bg-surface-container p-2.5 rounded-lg flex items-center justify-between">
                                <div class="flex flex-col">
                                    <span class="font-headline-sm text-headline-sm text-tertiary font-bold leading-none">24,192</span>
                                    <span class="font-label-mono text-label-mono text-outline-variant mt-1">EVENTS / HOUR</span>
                                </div>
                                <!-- Inline SVG Visual Telemetry Sparkline -->
                                <div class="w-36 h-10 flex items-center">
                                    <svg class="w-full h-full text-secondary" fill="none" viewbox="0 0 144 40">
                                        <path d="M0,28 L16,22 L32,31 L48,15 L64,18 L80,8 L96,14 L112,6 L128,12 L144,4" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                        <path d="M0,28 L16,22 L32,31 L48,15 L64,18 L80,8 L96,14 L112,6 L128,12 L144,4 L144,40 L0,40 Z" fill="currentColor" fill-opacity="0.12"></path>
                                    </svg>
                                </div>
                                <div class="flex flex-col text-right">
                                    <span class="font-headline-sm text-headline-sm text-on-surface font-bold leading-none">0</span>
                                    <span class="font-label-mono text-label-mono text-secondary mt-1">ANOMALIES (60M)</span>
                                </div>
                            </div>
                            <!-- Incident Dispatch Policy Link -->
                            <div class="flex items-center justify-between text-body-sm font-body-sm pt-1">
                                <span class="text-outline-variant font-label-mono text-label-mono">SOC POLICY ATTACHED:</span>
                                <a class="text-tertiary hover:underline font-label-mono text-label-mono flex items-center gap-1" href="#">
                                    Rule #SOC-ML-089 (Zero-Day Ingestion Guard)
                                    <span class="material-symbols-outlined text-[14px]">open_in_new</span>
                                </a>
                            </div>
                        </div>
                        <!-- Card B: Webhook Security & mTLS Key Exchange -->
                        <div class="bg-surface-container-low rounded-xl p-space-md shadow-md flex flex-col gap-space-sm">
                            <div class="flex items-center justify-between pb-space-xs border-b border-surface-container-high">
                                <div class="flex items-center gap-2">
                                    <span class="font-label-caps text-label-caps text-outline">[SECURITY // CREDENTIALS]</span>
                                    <span class="font-headline-sm text-headline-sm text-on-surface font-semibold">Webhook Security &amp; Keys</span>
                                </div>
                                <span class="font-label-caps text-label-caps px-2 py-0.5 rounded bg-surface-container-high text-primary">HMAC-SHA256</span>
                            </div>
                            <div class="flex flex-col gap-space-xs">
                                <!-- Signing Secret Key Input -->
                                <div class="flex flex-col gap-1">
                                    <label class="font-label-mono text-label-mono text-outline">SIGNING SECRET (PAYLOAD ATTESTATION)</label>
                                    <div class="flex items-center bg-surface-container-lowest rounded px-space-sm py-1.5">
                                        <input class="bg-transparent font-code-block text-code-block text-primary w-full focus:outline-none" id="signing-secret-input" readonly="" type="password" value="vstk_whsec_9942a8bf7094d21e884c7a109" />
                                        <button class="text-outline hover:text-on-surface px-1" id="toggle-secret-visibility">
                                            <span class="material-symbols-outlined text-[16px]" id="secret-eye-icon">visibility</span>
                                        </button>
                                        <button class="text-outline hover:text-tertiary px-1 ml-1" title="Rotate Key">
                                            <span class="material-symbols-outlined text-[16px]">refresh</span>
                                        </button>
                                    </div>
                                </div>
                                <!-- Metadata Spec -->
                                <div class="grid grid-cols-2 gap-2 mt-1 font-label-mono text-label-mono">
                                    <div class="bg-surface-container p-2 rounded flex flex-col">
                                        <span class="text-outline text-[10px]">SIGNATURE HEADER</span>
                                        <span class="text-on-surface font-code-block text-code-block">X-Vostok-Signature</span>
                                    </div>
                                    <div class="bg-surface-container p-2 rounded flex flex-col">
                                        <span class="text-outline text-[10px]">MAX THROUGHPUT</span>
                                        <span class="text-tertiary font-bold">500 req/s <span class="text-outline font-normal">(Burst 1.2k)</span></span>
                                    </div>
                                </div>
                                <!-- Target Endpoint URI -->
                                <div class="bg-surface-container p-2 rounded flex flex-col font-label-mono text-label-mono">
                                    <span class="text-outline text-[10px]">TARGET ENDPOINT URI</span>
                                    <span class="text-on-surface text-code-block font-code-block truncate">https://crm.vostok.internal/webhooks/v1/ml-inbound</span>
                                </div>
                            </div>
                        </div>
                        <!-- Card C: Recent Integration Event Audit Log -->
                        <div class="bg-surface-container-low rounded-xl p-space-md shadow-md flex flex-col gap-space-sm">
                            <div class="flex items-center justify-between pb-space-xs border-b border-surface-container-high">
                                <div class="flex items-center gap-2">
                                    <span class="font-label-caps text-label-caps text-outline">[AUDIT // STREAM]</span>
                                    <span class="font-headline-sm text-headline-sm text-on-surface font-semibold">Recent Event Audit Log</span>
                                </div>
                                <span class="font-label-mono text-label-mono text-outline">Real-Time Poll</span>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="w-full text-left font-label-mono text-label-mono">
                                    <thead>
                                        <tr class="text-outline border-b border-surface-container-high pb-1">
                                            <th class="py-1 pr-2 font-normal">TIME</th>
                                            <th class="py-1 px-2 font-normal">EVENT ID</th>
                                            <th class="py-1 px-2 font-normal">TARGET</th>
                                            <th class="py-1 px-2 font-normal">STATUS</th>
                                            <th class="py-1 pl-2 text-right font-normal">RTT</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-surface-container-high/50 text-body-sm font-code-block">
                                        <tr class="hover:bg-surface-container/60 transition-colors">
                                            <td class="py-1.5 pr-2 text-outline-variant font-label-mono">14:38:09</td>
                                            <td class="py-1.5 px-2 text-primary font-semibold">EV-9821</td>
                                            <td class="py-1.5 px-2 text-on-surface">SYS05 CRM</td>
                                            <td class="py-1.5 px-2">
                                                <span class="px-1.5 py-0.2 rounded bg-secondary-container text-secondary text-[10px] font-bold">200 OK</span>
                                            </td>
                                            <td class="py-1.5 pl-2 text-right text-tertiary">24ms</td>
                                        </tr>
                                        <tr class="hover:bg-surface-container/60 transition-colors">
                                            <td class="py-1.5 pr-2 text-outline-variant font-label-mono">14:37:41</td>
                                            <td class="py-1.5 px-2 text-primary font-semibold">EV-9820</td>
                                            <td class="py-1.5 px-2 text-on-surface">SYS08 Supp</td>
                                            <td class="py-1.5 px-2">
                                                <span class="px-1.5 py-0.2 rounded bg-secondary-container text-secondary text-[10px] font-bold">200 OK</span>
                                            </td>
                                            <td class="py-1.5 pl-2 text-right text-tertiary">9ms</td>
                                        </tr>
                                        <tr class="hover:bg-surface-container/60 transition-colors">
                                            <td class="py-1.5 pr-2 text-outline-variant font-label-mono">14:36:12</td>
                                            <td class="py-1.5 px-2 text-primary font-semibold">EV-9819</td>
                                            <td class="py-1.5 px-2 text-on-surface">SYS07 Fin</td>
                                            <td class="py-1.5 px-2">
                                                <span class="px-1.5 py-0.2 rounded bg-surface-container-high text-primary text-[10px] font-bold">202 ACCEPT</span>
                                            </td>
                                            <td class="py-1.5 pl-2 text-right text-tertiary">38ms</td>
                                        </tr>
                                        <tr class="hover:bg-surface-container/60 transition-colors">
                                            <td class="py-1.5 pr-2 text-outline-variant font-label-mono">14:35:01</td>
                                            <td class="py-1.5 px-2 text-primary font-semibold">EV-9818</td>
                                            <td class="py-1.5 px-2 text-on-surface">SYS-AI-05</td>
                                            <td class="py-1.5 px-2">
                                                <span class="px-1.5 py-0.2 rounded bg-secondary-container text-secondary text-[10px] font-bold">200 OK</span>
                                            </td>
                                            <td class="py-1.5 pl-2 text-right text-tertiary">1.2ms</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                // Interactive micro-behaviors
                document.addEventListener('DOMContentLoaded', () => {
                    // Secret Key Toggle Visibility
                    const secretInput = document.getElementById('signing-secret-input');
                    const toggleBtn = document.getElementById('toggle-secret-visibility');
                    const eyeIcon = document.getElementById('secret-eye-icon');

                    if (toggleBtn && secretInput && eyeIcon) {
                        toggleBtn.addEventListener('click', () => {
                            if (secretInput.type === 'password') {
                                secretInput.type = 'text';
                                eyeIcon.textContent = 'visibility_off';
                            } else {
                                secretInput.type = 'password';
                                eyeIcon.textContent = 'visibility';
                            }
                        });
                    }

                    // Mock Webhook Connection Dispatcher
                    const mockBtn = document.getElementById('btn-mock-dispatch');
                    const resultPanel = document.getElementById('mock-dispatch-result');
                    if (mockBtn && resultPanel) {
                        mockBtn.addEventListener('click', () => {
                            const originalText = mockBtn.innerHTML;
                            mockBtn.innerHTML = '<span class="material-symbols-outlined text-[16px] animate-spin">refresh</span> Dispatching Handshake...';
                            mockBtn.disabled = true;

                            setTimeout(() => {
                                mockBtn.innerHTML = '<span class="material-symbols-outlined text-[16px] text-secondary">check_circle</span> Dispatched Successfully';
                                resultPanel.classList.add('bg-secondary-container/20');
                                setTimeout(() => {
                                    resultPanel.classList.remove('bg-secondary-container/20');
                                    mockBtn.innerHTML = originalText;
                                    mockBtn.disabled = false;
                                }, 2000);
                            }, 650);
                        });
                    }

                    // Save Mapping Schema Feedback
                    const saveBtn = document.getElementById('btn-save-schema');
                    if (saveBtn) {
                        saveBtn.addEventListener('click', () => {
                            const orig = saveBtn.innerHTML;
                            saveBtn.innerHTML = '<span class="material-symbols-outlined text-[16px] text-tertiary">verified</span> Schema Committed';
                            setTimeout(() => {
                                saveBtn.innerHTML = orig;
                            }, 1800);
                        });
                    }

                    // Test All Webhooks Trigger
                    const testAllBtn = document.getElementById('btn-test-all');
                    if (testAllBtn) {
                        testAllBtn.addEventListener('click', () => {
                            const orig = testAllBtn.innerHTML;
                            testAllBtn.innerHTML = '<span class="material-symbols-outlined text-[16px] animate-spin text-tertiary">sync</span> Polling 4 Nodes...';
                            setTimeout(() => {
                                testAllBtn.innerHTML = '<span class="material-symbols-outlined text-[16px] text-secondary">done_all</span> All 4 Healthy';
                                setTimeout(() => {
                                    testAllBtn.innerHTML = orig;
                                }, 2000);
                            }, 800);
                        });
                    }

                    // Tab Switching for Systems
                    const tabs = document.querySelectorAll('.tab-target');
                    tabs.forEach(tab => {
                        tab.addEventListener('click', () => {
                            tabs.forEach(t => {
                                t.classList.remove('bg-surface-container-high', 'text-primary', 'font-semibold', 'shadow-sm');
                                t.classList.add('text-outline');
                            });
                            tab.classList.add('bg-surface-container-high', 'text-primary', 'font-semibold', 'shadow-sm');
                            tab.classList.remove('text-outline');
                        });
                    });
                });
            </script>
        </main>
        <footer class="w-full h-8 bg-surface-container-lowest flex items-center justify-between px-gutter z-30 shadow-[0_-2px_10px_rgba(0,15,33,0.5)]">
            <div class="flex items-center gap-space-md font-label-mono text-label-mono text-outline"><span class="flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-tertiary"></span><span class="text-on-surface">SYS-AI-04 DAEMON: ONLINE</span></span><span>|</span><span>LATENCY: 24ms</span><span>|</span><span>CLUSTER: vostok-k8s-prod-eu</span><span>|</span><span>DOCKER REGISTRY: harbor.vostok.internal</span></div>
            <div class="flex items-center gap-space-sm font-label-mono text-label-mono text-outline"><span>STATION-NODE: #042-DE</span><span>SEC: LEVEL-4 CLASSIFIED</span></div>
        </footer>
    </div>
</body>

</html>