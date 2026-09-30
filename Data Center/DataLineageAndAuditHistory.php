<!DOCTYPE html>

<html class="dark" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="web_dashboard" name="shell-type" />
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&amp;family=Inter:wght@400;500;600&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />
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
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "on-secondary": "#113253",
                        "primary": "#b4c8e3",
                        "primary-container": "#0f2438",
                        "tertiary": "#ffb956",
                        "outline-variant": "#43474c",
                        "inverse-primary": "#4d6077",
                        "surface-dim": "#00142a",
                        "surface": "#00142a",
                        "primary-fixed-dim": "#b4c8e3",
                        "surface-variant": "#1f3651",
                        "on-background": "#d3e4ff",
                        "on-primary": "#1e3246",
                        "on-error": "#690005",
                        "inverse-surface": "#d3e4ff",
                        "surface-container-high": "#132b45",
                        "background": "#00142a",
                        "tertiary-container": "#331e00",
                        "on-tertiary-fixed-variant": "#643f00",
                        "surface-bright": "#243a56",
                        "surface-tint": "#b4c8e3",
                        "secondary-fixed": "#d2e4ff",
                        "tertiary-fixed-dim": "#ffb956",
                        "on-primary-fixed-variant": "#35485e",
                        "error-container": "#93000a",
                        "secondary": "#abc9f2",
                        "tertiary-fixed": "#ffddb5",
                        "on-tertiary": "#462b00",
                        "error": "#ffb4ab",
                        "on-surface": "#d3e4ff",
                        "on-primary-fixed": "#071d30",
                        "surface-container-low": "#021c36",
                        "on-error-container": "#ffdad6",
                        "on-tertiary-fixed": "#2a1800",
                        "on-primary-container": "#788ca4",
                        "primary-fixed": "#d0e4ff",
                        "outline": "#8e9197",
                        "inverse-on-surface": "#1a314c",
                        "on-secondary-container": "#9ab7e0",
                        "surface-container": "#06203a",
                        "on-secondary-fixed-variant": "#2b486b",
                        "surface-container-highest": "#1f3651",
                        "on-secondary-fixed": "#001c38",
                        "surface-container-lowest": "#000f21",
                        "secondary-container": "#2b486b",
                        "on-tertiary-container": "#bb7d16",
                        "secondary-fixed-dim": "#abc9f2",
                        "on-surface-variant": "#c4c6cd"
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    spacing: {
                        "space-2xl": "3rem",
                        "margin-desktop": "2rem",
                        "gutter-sm": "0.75rem",
                        "space-2xs": "0.125rem",
                        "space-xs": "0.25rem",
                        "space-md": "1rem",
                        "gutter-lg": "1.5rem",
                        "margin-mobile": "1rem",
                        "space-xl": "2rem",
                        "space-lg": "1.5rem",
                        "space-sm": "0.5rem",
                        "gutter": "1rem",
                        "margin": "1.5rem"
                    },
                    fontFamily: {
                        "headline-md": ["IBM Plex Sans"],
                        "body-sm": ["Inter"],
                        "display-lg": ["IBM Plex Sans"],
                        "headline-lg": ["IBM Plex Sans"],
                        "label-lg": ["IBM Plex Sans"],
                        "headline-sm": ["IBM Plex Sans"],
                        "label-sm": ["IBM Plex Sans"],
                        "body-md": ["Inter"],
                        "label-md": ["IBM Plex Sans"],
                        "display-lg-mobile": ["IBM Plex Sans"],
                        "body-lg": ["Inter"],
                        "telemetry-num": ["IBM Plex Sans"]
                    },
                    fontSize: {
                        "headline-md": ["20px", {
                            lineHeight: "28px",
                            letterSpacing: "-0.005em",
                            fontWeight: "600"
                        }],
                        "body-sm": ["12px", {
                            lineHeight: "18px",
                            letterSpacing: "0em",
                            fontWeight: "400"
                        }],
                        "display-lg": ["32px", {
                            lineHeight: "40px",
                            letterSpacing: "-0.02em",
                            fontWeight: "600"
                        }],
                        "headline-lg": ["24px", {
                            lineHeight: "32px",
                            letterSpacing: "-0.01em",
                            fontWeight: "600"
                        }],
                        "label-lg": ["13px", {
                            lineHeight: "16px",
                            letterSpacing: "0.04em",
                            fontWeight: "500"
                        }],
                        "headline-sm": ["16px", {
                            lineHeight: "24px",
                            letterSpacing: "0em",
                            fontWeight: "600"
                        }],
                        "label-sm": ["10px", {
                            lineHeight: "12px",
                            letterSpacing: "0.12em",
                            fontWeight: "600"
                        }],
                        "body-md": ["14px", {
                            lineHeight: "20px",
                            letterSpacing: "-0.006em",
                            fontWeight: "400"
                        }],
                        "label-md": ["11px", {
                            lineHeight: "14px",
                            letterSpacing: "0.08em",
                            fontWeight: "600"
                        }],
                        "display-lg-mobile": ["26px", {
                            lineHeight: "32px",
                            letterSpacing: "-0.015em",
                            fontWeight: "600"
                        }],
                        "body-lg": ["16px", {
                            lineHeight: "24px",
                            letterSpacing: "-0.011em",
                            fontWeight: "400"
                        }],
                        "telemetry-num": ["28px", {
                            lineHeight: "32px",
                            letterSpacing: "-0.02em",
                            fontWeight: "500"
                        }]
                    }
                }
            }
        };
    </script>
</head>

<body class="bg-background font-body-md text-on-surface antialiased">
    <aside class="fixed left-0 top-0 h-full w-64 bg-surface-container-lowest z-50 flex flex-col justify-between">
        <div class="flex flex-col">
            <div class="h-16 px-space-md flex items-center gap-space-sm bg-surface-container-low"><img alt="VOSTOKPRIBOR AI Emblem" class="h-8 w-auto object-contain" src="https://lh3.googleusercontent.com/aida/AEtjO1WChaZlDzbMhLgB7CKLbcwys8iyFQh4IndCJk_ECktdbqDF1I6VJLCvzXknLTOJatZwGFaSH8h75LujcuaUJIub7LPO63lIx2JSHusDx2OZJE4ceEhZsKs_Wjkv71qOS3i8MI5dF5Y_2NYaiAppSLANo94BzS6OZ9z07ZaUzp9ydLOkjWGjr2LKZ6GaaadAX6ZVzEPGvIw5iP1cBfjrdkDhECDXN5kSy4z3k9K3ktsqz5tzI7ND8lSdL_Y" />
                <div class="flex flex-col"><span class="font-label-md text-label-md tracking-widest text-primary uppercase">VOSTOKPRIBOR</span><span class="font-label-sm text-label-sm text-on-surface-variant">PRECISION TELEMETRY</span></div>
            </div>
            <div class="px-space-md py-space-sm">
                <div class="font-label-sm text-label-sm text-outline uppercase tracking-widest px-space-xs mb-space-xs">Subsystems</div>
                <nav class="flex flex-col gap-space-2xs" data-active-classes="bg-surface-container-high text-on-surface font-semibold"><a class="flex items-center gap-space-sm px-space-sm py-space-xs rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-colors font-label-lg text-label-lg" data-path="projects" href="#"><span class="material-symbols-outlined text-[18px]">folder_supervised</span><span>SYS-AI-01 Projects</span></a><a class="flex items-center gap-space-sm px-space-sm py-space-xs rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-colors font-label-lg text-label-lg" data-path="data-center" href="#">
                        <div class="flex items-center gap-space-sm"><span class="material-symbols-outlined text-[18px] text-tertiary">database</span><span>SYS-AI-02 Data Center</span></div><span class="h-2 w-2 rounded-full bg-tertiary animate-pulse"></span>
                    </a><a class="flex items-center gap-space-sm px-space-sm py-space-xs rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-colors font-label-lg text-label-lg" data-path="workbench" href="#"><span class="material-symbols-outlined text-[18px]">terminal</span><span>SYS-AI-03 Workbench</span></a><a class="flex items-center gap-space-sm px-space-sm py-space-xs rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-colors font-label-lg text-label-lg" data-path="registry-deployment" href="#"><span class="material-symbols-outlined text-[18px]">layers</span><span>SYS-AI-04 Registry &amp; Deployment</span></a><a class="flex items-center gap-space-sm px-space-sm py-space-xs rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-colors font-label-lg text-label-lg" data-path="ai-soc" href="#"><span class="material-symbols-outlined text-[18px]">shield</span><span>SYS-AI-05 AI SOC</span></a></nav>
            </div>
        </div>
        <div class="p-space-md bg-surface-container-low">
            <div class="flex items-center justify-between font-label-sm text-label-sm text-on-surface-variant mb-space-2xs"><span>NODE TELEMETRY</span><span class="text-tertiary">ONLINE</span></div>
            <div class="w-full bg-surface-container h-1.5 rounded-full overflow-hidden">
                <div class="bg-tertiary h-full w-[84%]"></div>
            </div>
            <div class="flex justify-between items-center mt-space-2xs font-label-sm text-label-sm text-outline"><span>ARRAY CORE</span><span>84% CAP</span></div>
        </div>
    </aside>
    <div class="pl-64">
        <header class="fixed top-0 left-64 right-0 z-40 bg-surface/90 backdrop-blur-md shadow-[0_1px_8px_rgba(0,0,0,0.25)]">
            <div class="h-16 px-space-lg flex items-center justify-between gap-space-md">
                <div class="flex items-center gap-space-md"><img alt="VOSTOKPRIBOR AI Emblem" class="h-8 w-auto object-contain" src="https://lh3.googleusercontent.com/aida/AEtjO1WChaZlDzbMhLgB7CKLbcwys8iyFQh4IndCJk_ECktdbqDF1I6VJLCvzXknLTOJatZwGFaSH8h75LujcuaUJIub7LPO63lIx2JSHusDx2OZJE4ceEhZsKs_Wjkv71qOS3i8MI5dF5Y_2NYaiAppSLANo94BzS6OZ9z07ZaUzp9ydLOkjWGjr2LKZ6GaaadAX6ZVzEPGvIw5iP1cBfjrdkDhECDXN5kSy4z3k9K3ktsqz5tzI7ND8lSdL_Y" />
                    <div class="flex items-center gap-space-xs font-label-lg text-label-lg"><span class="text-on-surface-variant">VOSTOKPRIBOR AI</span><span class="text-outline">/</span><span class="text-primary font-semibold">SYS-AI-02 Data Center</span></div>
                    <div class="flex items-center gap-space-xs px-space-sm py-space-2xs rounded bg-surface-container-high"><span class="h-2 w-2 rounded-full bg-tertiary animate-ping"></span><span class="font-label-sm text-label-sm text-on-surface font-mono">#AI-024 Customer Churn</span></div>
                </div>
                <div class="flex-1 max-w-xs">
                    <div class="flex items-center bg-surface-container-low rounded px-space-sm py-space-2xs text-on-surface-variant"><span class="material-symbols-outlined text-[18px] mr-space-xs text-outline">search</span><span class="font-body-sm text-body-sm flex-1 text-outline">Search telemetry, tags, schema...</span><span class="font-label-sm text-label-sm bg-surface-container px-1.5 py-0.5 rounded text-on-surface-variant font-mono">⌘K</span></div>
                </div>
                <div class="flex items-center gap-space-md">
                    <div class="flex items-center bg-surface-container-lowest p-space-2xs rounded-full font-label-sm text-label-sm"><button class="px-space-sm py-0.5 rounded-full bg-primary-container text-on-surface font-semibold">Student</button><button class="px-space-sm py-0.5 text-on-surface-variant hover:text-on-surface transition-colors">Instructor</button></div>
                    <div class="flex items-center bg-surface-container-lowest p-space-2xs rounded font-label-sm text-label-sm"><span class="px-space-xs text-primary font-bold">EN</span><span class="text-outline">|</span><span class="px-space-xs text-on-surface-variant hover:text-on-surface cursor-pointer">AR</span></div><button class="relative p-space-xs rounded bg-surface-container-high text-on-surface hover:text-tertiary transition-colors"><span class="material-symbols-outlined text-[20px]">notifications</span><span class="absolute top-1 right-1 h-2 w-2 rounded-full bg-tertiary"></span></button>
                    <div class="flex items-center gap-space-xs px-space-sm py-space-2xs bg-surface-container rounded"><span class="h-2 w-2 rounded-full bg-tertiary"></span>
                        <div class="flex flex-col"><span class="font-label-sm text-label-sm text-on-surface leading-tight">Intern AI Engineer</span><span class="font-label-sm text-label-sm text-on-surface-variant leading-tight">Level 2</span></div>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center"><span class="material-symbols-outlined text-on-primary text-[18px]">person</span></div>
                </div>
            </div>
            <div class="h-12 px-space-lg bg-surface-container-low flex items-center overflow-x-auto gap-space-xs">
                <div class="flex items-center gap-space-2xs font-label-sm text-label-sm flex-shrink-0"><span class="px-space-xs py-0.5 rounded bg-surface-container text-outline font-mono">01</span><span class="text-outline mr-space-xs">Business Request</span><span class="text-outline-variant font-mono text-[10px]">→</span></div>
                <div class="flex items-center gap-space-2xs font-label-sm text-label-sm flex-shrink-0"><span class="px-space-xs py-0.5 rounded bg-surface-container text-outline font-mono">02</span><span class="text-outline mr-space-xs">Problem Framing</span><span class="text-outline-variant font-mono text-[10px]">→</span></div>
                <div class="flex items-center gap-space-2xs font-label-sm text-label-sm flex-shrink-0 bg-surface-container-high px-space-xs py-1 rounded"><span class="px-space-xs py-0.5 rounded bg-tertiary text-on-tertiary font-bold font-mono">03</span><span class="text-on-surface font-semibold mr-space-xs">Data Discovery</span><span class="text-tertiary font-mono text-[10px]">→</span></div>
                <div class="flex items-center gap-space-2xs font-label-sm text-label-sm flex-shrink-0 bg-surface-container-high px-space-xs py-1 rounded"><span class="px-space-xs py-0.5 rounded bg-tertiary text-on-tertiary font-bold font-mono">04</span><span class="text-on-surface font-semibold mr-space-xs">Data Extraction</span><span class="text-tertiary font-mono text-[10px]">→</span></div>
                <div class="flex items-center gap-space-2xs font-label-sm text-label-sm flex-shrink-0 bg-surface-container-high px-space-xs py-1 rounded"><span class="px-space-xs py-0.5 rounded bg-tertiary text-on-tertiary font-bold font-mono">05</span><span class="text-on-surface font-semibold mr-space-xs">Quality &amp; Profiling</span><span class="text-tertiary font-mono text-[10px]">→</span></div>
                <div class="flex items-center gap-space-2xs font-label-sm text-label-sm flex-shrink-0"><span class="px-space-xs py-0.5 rounded bg-surface-container text-outline font-mono">06</span><span class="text-outline mr-space-xs">Feature Eng.</span><span class="text-outline-variant font-mono text-[10px]">→</span></div>
                <div class="flex items-center gap-space-2xs font-label-sm text-label-sm flex-shrink-0"><span class="px-space-xs py-0.5 rounded bg-surface-container text-outline font-mono">07</span><span class="text-outline mr-space-xs">Model Train</span><span class="text-outline-variant font-mono text-[10px]">→</span></div>
                <div class="flex items-center gap-space-2xs font-label-sm text-label-sm flex-shrink-0"><span class="px-space-xs py-0.5 rounded bg-surface-container text-outline font-mono">08</span><span class="text-outline mr-space-xs">Eval &amp; Validate</span><span class="text-outline-variant font-mono text-[10px]">→</span></div>
                <div class="flex items-center gap-space-2xs font-label-sm text-label-sm flex-shrink-0"><span class="px-space-xs py-0.5 rounded bg-surface-container text-outline font-mono">09</span><span class="text-outline mr-space-xs">Governance</span><span class="text-outline-variant font-mono text-[10px]">→</span></div>
                <div class="flex items-center gap-space-2xs font-label-sm text-label-sm flex-shrink-0"><span class="px-space-xs py-0.5 rounded bg-surface-container text-outline font-mono">10</span><span class="text-outline mr-space-xs">Deployment</span><span class="text-outline-variant font-mono text-[10px]">→</span></div>
                <div class="flex items-center gap-space-2xs font-label-sm text-label-sm flex-shrink-0"><span class="px-space-xs py-0.5 rounded bg-surface-container text-outline font-mono">11</span><span class="text-outline mr-space-xs">Monitoring</span><span class="text-outline-variant font-mono text-[10px]">→</span></div>
                <div class="flex items-center gap-space-2xs font-label-sm text-label-sm flex-shrink-0"><span class="px-space-xs py-0.5 rounded bg-surface-container text-outline font-mono">12</span><span class="text-outline mr-space-xs">Drift Detect</span><span class="text-outline-variant font-mono text-[10px]">→</span></div>
                <div class="flex items-center gap-space-2xs font-label-sm text-label-sm flex-shrink-0"><span class="px-space-xs py-0.5 rounded bg-surface-container text-outline font-mono">13</span><span class="text-outline mr-space-xs">Retrain Loop</span><span class="text-outline-variant font-mono text-[10px]">→</span></div>
                <div class="flex items-center gap-space-2xs font-label-sm text-label-sm flex-shrink-0"><span class="px-space-xs py-0.5 rounded bg-surface-container text-outline font-mono">14</span><span class="text-outline">Final Report</span></div>
            </div>
        </header>
        <main class="relative pt-28 w-full px-space-lg pb-space-2xl bg-background">
            <div class="flex flex-col w-full">
                <!-- Dataset Header & Metadata Deck -->
                <div class="bg-surface-container-low rounded-xl p-space-lg shadow-xl mb-space-lg relative overflow-hidden">
                    <div class="absolute -right-16 -top-16 w-80 h-80 rounded-full bg-tertiary/5 blur-3xl pointer-events-none"></div>
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-space-md relative z-10">
                        <div class="flex flex-col gap-space-2xs">
                            <div class="flex flex-wrap items-center gap-space-xs font-label-sm text-label-sm">
                                <span class="px-space-xs py-0.5 rounded bg-surface-container-high text-on-surface font-mono font-bold tracking-widest uppercase">SYS05-CRM-INGEST</span>
                                <span class="text-outline">/</span>
                                <span class="text-on-surface-variant font-mono">Cluster Alpha-09</span>
                                <span class="text-outline">/</span>
                                <span class="text-outline flex items-center gap-1 font-mono"><span class="material-symbols-outlined text-[14px] text-tertiary">sync</span> Ingested 14m ago by <code class="text-primary font-mono font-semibold">etl_crm_sync#892</code></span>
                                <span class="px-space-xs py-0.5 rounded bg-error-container text-on-error-container font-mono uppercase tracking-wider font-bold text-[10px]">CONFIDENTIAL // LVL 2 AUTH</span>
                            </div>
                            <div class="flex items-center gap-space-sm mt-1">
                                <h1 class="font-headline-lg text-headline-lg text-on-surface tracking-tight font-bold flex items-center gap-space-xs">
                                    customers.csv
                                    <span class="px-2 py-0.5 rounded bg-tertiary/20 text-tertiary font-mono text-label-sm font-semibold tracking-wider">v2.1 STABLE</span>
                                </h1>
                                <span class="h-2 w-2 rounded-full bg-tertiary animate-pulse" title="Live WORM Verified"></span>
                            </div>
                        </div>
                        <!-- Action Button Group -->
                        <div class="flex flex-wrap items-center gap-space-xs">
                            <button class="flex items-center gap-space-xs px-space-md py-space-xs rounded bg-surface-container-high text-on-surface hover:bg-surface-bright transition-colors font-label-lg text-label-lg shadow-sm">
                                <span class="material-symbols-outlined text-[18px] text-secondary">terminal</span>
                                <span>Open in SQL Workbench</span>
                            </button>
                            <button class="flex items-center gap-space-xs px-space-md py-space-xs rounded bg-surface-container-high text-on-surface hover:bg-surface-bright transition-colors font-label-lg text-label-lg shadow-sm">
                                <span class="material-symbols-outlined text-[18px] text-primary">download</span>
                                <span>Export / Download</span>
                            </button>
                            <button class="flex items-center gap-space-xs px-space-md py-space-xs rounded bg-surface-container-high text-on-surface hover:bg-surface-bright transition-colors font-label-lg text-label-lg shadow-sm">
                                <span class="material-symbols-outlined text-[18px] text-tertiary">verified_user</span>
                                <span>Run Audit Check</span>
                            </button>
                            <button class="flex items-center gap-space-xs px-space-md py-space-xs rounded bg-primary text-on-primary hover:bg-primary-fixed transition-colors font-label-lg text-label-lg font-semibold shadow-sm">
                                <span class="material-symbols-outlined text-[18px]">rule</span>
                                <span>Schema Check</span>
                            </button>
                        </div>
                    </div>
                    <!-- Key Telemetry Readouts -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-space-sm mt-space-md pt-space-md bg-surface-container-lowest/60 -mx-space-lg -mb-space-lg px-space-lg pb-space-md">
                        <div class="flex flex-col">
                            <span class="font-label-sm text-label-sm text-outline uppercase tracking-wider">Payload Size</span>
                            <div class="flex items-baseline gap-1 mt-0.5">
                                <span class="font-telemetry-num text-telemetry-num text-on-surface font-semibold font-mono">4.20</span>
                                <span class="font-label-sm text-label-sm text-on-surface-variant font-mono uppercase">MB (10,480 Rows)</span>
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-label-sm text-label-sm text-outline uppercase tracking-wider">Encoding / Format</span>
                            <div class="flex items-baseline gap-1 mt-0.5">
                                <span class="font-headline-sm text-headline-sm text-on-surface font-mono font-semibold">UTF-8</span>
                                <span class="font-label-sm text-label-sm text-on-surface-variant font-mono">/ RFC-4180 (18 COLS)</span>
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-label-sm text-label-sm text-outline uppercase tracking-wider">Source Engine</span>
                            <div class="flex items-baseline gap-1 mt-0.5">
                                <span class="font-headline-sm text-headline-sm text-tertiary font-mono font-semibold">Postgres CDC</span>
                                <span class="font-label-sm text-label-sm text-on-surface-variant font-mono">SYS05 Repl Alpha</span>
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-label-sm text-label-sm text-outline uppercase tracking-wider">SHA-256 Checksum</span>
                            <div class="flex items-baseline gap-1 mt-0.5">
                                <span class="font-label-md text-label-md text-secondary font-mono tracking-tight truncate max-w-[200px]" title="4f8a2b7e19ca90c102dfbc77a11293c0482910fae190391">4f8a2b7e...02dfbc</span>
                                <span class="material-symbols-outlined text-[14px] text-tertiary">lock</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Tab Bar Segment -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-space-sm bg-surface-container rounded-lg p-1.5 mb-space-lg shadow-md">
                    <div class="flex items-center overflow-x-auto gap-1">
                        <button class="px-space-md py-space-xs rounded-md text-on-surface-variant hover:text-on-surface hover:bg-surface-container-high transition-colors font-label-lg text-label-lg whitespace-nowrap">
                            1. Preview
                        </button>
                        <button class="px-space-md py-space-xs rounded-md text-on-surface-variant hover:text-on-surface hover:bg-surface-container-high transition-colors font-label-lg text-label-lg whitespace-nowrap">
                            2. Schema
                        </button>
                        <button class="px-space-md py-space-xs rounded-md text-on-surface-variant hover:text-on-surface hover:bg-surface-container-high transition-colors font-label-lg text-label-lg whitespace-nowrap">
                            3. Quality &amp; Completeness
                        </button>
                        <button class="px-space-md py-space-xs rounded-md text-on-surface-variant hover:text-on-surface hover:bg-surface-container-high transition-colors font-label-lg text-label-lg whitespace-nowrap">
                            4. Profiling &amp; Distributions
                        </button>
                        <!-- Active Tab: Lineage & Audit History -->
                        <button class="relative px-space-md py-space-xs rounded-md bg-surface-container-highest text-tertiary font-label-lg text-label-lg font-bold flex items-center gap-space-xs shadow-inner whitespace-nowrap">
                            <span class="material-symbols-outlined text-[16px] text-tertiary">account_tree</span>
                            <span>5. Lineage &amp; Audit History</span>
                            <span class="w-1.5 h-1.5 rounded-full bg-tertiary"></span>
                        </button>
                    </div>
                    <div class="flex items-center gap-space-sm px-space-sm py-1 font-label-sm text-label-sm text-outline-variant flex-shrink-0 self-end sm:self-auto">
                        <div class="flex items-center gap-1 text-on-surface-variant font-mono">
                            <span class="material-symbols-outlined text-[16px] text-primary">speed</span>
                            <span>Stat Engine: <strong class="text-on-surface font-semibold">DETERMINISTIC v4.8</strong></span>
                        </div>
                        <span class="text-outline">|</span>
                        <div class="flex items-center gap-1 text-on-surface-variant font-mono">
                            <span class="material-symbols-outlined text-[16px] text-tertiary">verified</span>
                            <span class="text-tertiary font-bold tracking-wide">WORM LEDGER VERIFIED</span>
                        </div>
                    </div>
                </div>
                <!-- 1. Top KPI / Lineage Summary Tiles (Bento Style) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-space-md mb-space-lg">
                    <!-- Tile 1 -->
                    <div class="bg-surface-container-low rounded-xl p-space-md shadow-md flex flex-col justify-between">
                        <div class="flex items-center justify-between font-label-sm text-label-sm text-outline uppercase tracking-wider mb-space-xs">
                            <span>Total Revisions</span>
                            <span class="material-symbols-outlined text-primary text-[18px]">history</span>
                        </div>
                        <div class="flex flex-col">
                            <div class="font-telemetry-num text-telemetry-num text-on-surface font-bold font-mono">4 <span class="text-headline-sm font-normal text-on-surface-variant font-body-sm">Versions</span></div>
                            <div class="mt-space-2xs text-[11px] font-mono text-outline flex items-center gap-1 truncate">
                                <span class="text-on-surface-variant">v1.0 Raw</span> → <span>v1.2</span> → <span>v2.0</span> → <span class="text-tertiary font-bold">v2.1 Act</span>
                            </div>
                        </div>
                        <div class="w-full bg-surface-container-high h-1 rounded-full overflow-hidden mt-space-sm">
                            <div class="bg-primary h-full w-full"></div>
                        </div>
                    </div>
                    <!-- Tile 2 -->
                    <div class="bg-surface-container-low rounded-xl p-space-md shadow-md flex flex-col justify-between">
                        <div class="flex items-center justify-between font-label-sm text-label-sm text-outline uppercase tracking-wider mb-space-xs">
                            <span>Provenance Depth</span>
                            <span class="material-symbols-outlined text-secondary text-[18px]">schema</span>
                        </div>
                        <div class="flex flex-col">
                            <div class="font-telemetry-num text-telemetry-num text-on-surface font-bold font-mono">3 <span class="text-headline-sm font-normal text-on-surface-variant font-body-sm">Hops</span></div>
                            <div class="mt-space-2xs text-[11px] font-mono text-on-surface-variant truncate">
                                SYS05 PG → Kafka crm-01 → MinIO
                            </div>
                        </div>
                        <div class="w-full bg-surface-container-high h-1 rounded-full overflow-hidden mt-space-sm">
                            <div class="bg-secondary h-full w-[75%]"></div>
                        </div>
                    </div>
                    <!-- Tile 3 -->
                    <div class="bg-surface-container-low rounded-xl p-space-md shadow-md flex flex-col justify-between">
                        <div class="flex items-center justify-between font-label-sm text-label-sm text-outline uppercase tracking-wider mb-space-xs">
                            <span>Access &amp; Export Events</span>
                            <span class="material-symbols-outlined text-tertiary text-[18px]">receipt_long</span>
                        </div>
                        <div class="flex flex-col">
                            <div class="font-telemetry-num text-telemetry-num text-on-surface font-bold font-mono">14 <span class="text-headline-sm font-normal text-on-surface-variant font-body-sm">Operations</span></div>
                            <div class="mt-space-2xs text-[11px] font-mono text-outline flex items-center gap-1.5">
                                <span class="text-tertiary font-semibold">3 Exp</span> • <span>8 Qry</span> • <span>3 Val</span>
                            </div>
                        </div>
                        <div class="w-full bg-surface-container-high h-1 rounded-full overflow-hidden mt-space-sm">
                            <div class="bg-tertiary h-full w-[60%]"></div>
                        </div>
                    </div>
                    <!-- Tile 4 -->
                    <div class="bg-surface-container-low rounded-xl p-space-md shadow-md flex flex-col justify-between">
                        <div class="flex items-center justify-between font-label-sm text-label-sm text-outline uppercase tracking-wider mb-space-xs">
                            <span>WORM Compliance</span>
                            <span class="material-symbols-outlined text-tertiary text-[18px]">encrypted</span>
                        </div>
                        <div class="flex flex-col">
                            <div class="font-headline-sm text-headline-sm text-tertiary font-bold font-mono tracking-wider">IMMUTABLE LEDGER</div>
                            <div class="mt-space-2xs text-[11px] font-mono text-on-surface-variant truncate" title="SHA-256: b79e92ad81c30f4938a1">
                                SHA-256: b79e...38a1 · Lvl 2
                            </div>
                        </div>
                        <div class="w-full bg-surface-container-high h-1 rounded-full overflow-hidden mt-space-sm">
                            <div class="bg-tertiary h-full w-full"></div>
                        </div>
                    </div>
                </div>
                <!-- 2. End-to-End Visual Data Lineage Graph (DAG Flowchart) -->
                <div class="bg-surface-container-low rounded-xl p-space-lg shadow-xl mb-space-lg flex flex-col">
                    <!-- Graph Header Controls -->
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-space-sm mb-space-lg">
                        <div class="flex items-center gap-space-sm">
                            <div class="p-2 rounded bg-surface-container-high text-tertiary">
                                <span class="material-symbols-outlined text-[20px]">hub</span>
                            </div>
                            <div class="flex flex-col">
                                <div class="font-headline-sm text-headline-sm text-on-surface font-semibold flex items-center gap-space-xs">
                                    Directed Acyclic Graph (DAG) Lineage Pipeline
                                    <span class="px-2 py-0.5 rounded-full bg-surface-container-high text-on-surface-variant font-mono text-label-sm">LIVE STREAM</span>
                                </div>
                                <span class="font-body-sm text-body-sm text-on-surface-variant">Traceability from production origin to model training artifacts</span>
                            </div>
                        </div>
                        <!-- Graph Toolbar -->
                        <div class="flex items-center gap-space-xs bg-surface-container-highest p-1 rounded-lg">
                            <button class="px-space-sm py-1 rounded bg-surface-container-high text-on-surface font-label-sm text-label-sm font-mono flex items-center gap-1 shadow-sm">
                                <span>Filter: All Dependencies</span>
                                <span class="material-symbols-outlined text-[14px]">expand_more</span>
                            </button>
                            <span class="text-outline">|</span>
                            <button class="p-1 rounded text-on-surface-variant hover:text-on-surface transition-colors" title="Zoom In">
                                <span class="material-symbols-outlined text-[18px]">zoom_in</span>
                            </button>
                            <span class="font-label-sm text-label-sm font-mono px-1 text-on-surface">100%</span>
                            <button class="p-1 rounded text-on-surface-variant hover:text-on-surface transition-colors" title="Zoom Out">
                                <span class="material-symbols-outlined text-[18px]">zoom_out</span>
                            </button>
                            <button class="p-1 rounded text-on-surface-variant hover:text-on-surface transition-colors" title="Reset View">
                                <span class="material-symbols-outlined text-[18px]">restart_alt</span>
                            </button>
                            <button class="p-1 rounded text-on-surface-variant hover:text-on-surface transition-colors" title="Fullscreen">
                                <span class="material-symbols-outlined text-[18px]">fullscreen</span>
                            </button>
                        </div>
                    </div>
                    <!-- Visual Interactive SVG/HTML Canvas for Lineage -->
                    <div class="relative w-full overflow-x-auto bg-surface-container-lowest/80 rounded-xl p-space-lg shadow-inner">
                        <div class="min-w-[960px] flex items-center justify-between gap-6 relative py-4">
                            <!-- Connecting decorative lines underneath -->
                            <svg class="absolute inset-0 w-full h-full pointer-events-none" style="z-index: 1;">
                                <defs>
                                    <lineargradient id="lineageGrad" x1="0%" x2="100%" y1="0%" y2="0%">
                                        <stop offset="0%" stop-color="#4d6077" stop-opacity="0.4"></stop>
                                        <stop offset="65%" stop-color="#ffb956" stop-opacity="0.9"></stop>
                                        <stop offset="100%" stop-color="#4d6077" stop-opacity="0.4"></stop>
                                    </lineargradient>
                                </defs>
                                <path d="M 170 85 L 230 85" stroke="url(#lineageGrad)" stroke-dasharray="4 3" stroke-width="2"></path>
                                <path d="M 390 85 L 430 85" stroke="url(#lineageGrad)" stroke-width="2"></path>
                                <path d="M 590 85 L 630 85" stroke="url(#lineageGrad)" stroke-width="2"></path>
                                <path d="M 790 85 L 830 85" stroke="url(#lineageGrad)" stroke-width="2"></path>
                            </svg>
                            <!-- Node 1: Source DB -->
                            <div class="relative z-10 w-48 bg-surface-container p-space-sm rounded-lg shadow-md flex flex-col gap-1 transition-transform hover:-translate-y-0.5">
                                <div class="flex items-center justify-between">
                                    <span class="font-label-sm text-label-sm text-outline uppercase font-mono">NODE 01: ORIGIN</span>
                                    <span class="h-2 w-2 rounded-full bg-secondary"></span>
                                </div>
                                <div class="font-headline-sm text-headline-sm text-on-surface font-semibold truncate flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[16px] text-secondary">database</span>
                                    SYS05 CRM Core
                                </div>
                                <span class="font-body-sm text-body-sm text-on-surface-variant font-mono text-[11px]">PostgreSQL 14.2 Replica</span>
                                <div class="mt-2 pt-1 flex items-center justify-between font-label-sm text-label-sm text-outline font-mono">
                                    <span>Cluster 01</span>
                                    <span class="text-secondary">ONLINE</span>
                                </div>
                            </div>
                            <span class="material-symbols-outlined text-outline text-[20px] relative z-10">arrow_forward</span>
                            <!-- Node 2: Pipeline Ingestion -->
                            <div class="relative z-10 w-52 bg-surface-container p-space-sm rounded-lg shadow-md flex flex-col gap-1 transition-transform hover:-translate-y-0.5">
                                <div class="flex items-center justify-between">
                                    <span class="font-label-sm text-label-sm text-outline uppercase font-mono">NODE 02: INGESTION</span>
                                    <span class="h-2 w-2 rounded-full bg-secondary"></span>
                                </div>
                                <div class="font-headline-sm text-headline-sm text-on-surface font-semibold truncate flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[16px] text-primary">route</span>
                                    etl_crm_sync#892
                                </div>
                                <span class="font-body-sm text-body-sm text-on-surface-variant font-mono text-[11px]">Airflow · CDC Debezium</span>
                                <div class="mt-2 pt-1 flex items-center justify-between font-label-sm text-label-sm text-outline font-mono">
                                    <span>10,480 rows</span>
                                    <span class="text-secondary">SYNCED</span>
                                </div>
                            </div>
                            <span class="material-symbols-outlined text-outline text-[20px] relative z-10">arrow_forward</span>
                            <!-- Node 3: Raw Storage & Normalize -->
                            <div class="relative z-10 w-52 bg-surface-container p-space-sm rounded-lg shadow-md flex flex-col gap-1 transition-transform hover:-translate-y-0.5">
                                <div class="flex items-center justify-between">
                                    <span class="font-label-sm text-label-sm text-outline uppercase font-mono">NODE 03: TRANSFORM</span>
                                    <span class="h-2 w-2 rounded-full bg-secondary"></span>
                                </div>
                                <div class="font-headline-sm text-headline-sm text-on-surface font-semibold truncate flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[16px] text-tertiary">cleaning_services</span>
                                    Clean &amp; Normalize
                                </div>
                                <span class="font-body-sm text-body-sm text-on-surface-variant font-mono text-[11px]">tier1_cold_s3/raw/ → v2.0</span>
                                <div class="mt-2 pt-1 flex items-center justify-between font-label-sm text-label-sm text-outline font-mono">
                                    <span>Nulls Treated</span>
                                    <span class="text-tertiary">MUTATED</span>
                                </div>
                            </div>
                            <span class="material-symbols-outlined text-tertiary text-[20px] relative z-10">arrow_forward</span>
                            <!-- Node 4: Active Artifact (Target) -->
                            <div class="relative z-10 w-60 bg-surface-container-high p-space-sm rounded-lg shadow-xl ring-2 ring-tertiary flex flex-col gap-1 transition-transform hover:-translate-y-0.5">
                                <div class="flex items-center justify-between">
                                    <span class="font-label-sm text-label-sm text-tertiary font-bold uppercase font-mono tracking-wider">ACTIVE TARGET</span>
                                    <span class="h-2 w-2 rounded-full bg-tertiary animate-ping"></span>
                                </div>
                                <div class="font-headline-sm text-headline-sm text-on-surface font-bold truncate flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[18px] text-tertiary">description</span>
                                    customers.csv (v2.1)
                                </div>
                                <span class="font-body-sm text-body-sm text-on-surface-variant font-mono text-[11px]">10,480 rows · 18 cols · Lvl 2</span>
                                <div class="mt-2 pt-1 flex items-center justify-between font-label-sm text-label-sm text-tertiary font-mono font-semibold">
                                    <span>STABLE ARTIFACT</span>
                                    <span>INSPECTION TARGET</span>
                                </div>
                            </div>
                            <span class="material-symbols-outlined text-outline text-[20px] relative z-10">arrow_forward</span>
                            <!-- Node 5: Downstream Consumers Cluster -->
                            <div class="relative z-10 w-64 flex flex-col gap-2">
                                <!-- Consumer A -->
                                <div class="bg-surface-container p-2.5 rounded-lg shadow-md flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-[18px] text-secondary">terminal</span>
                                        <div class="flex flex-col">
                                            <span class="font-label-sm text-label-sm text-on-surface font-semibold">SYS-AI-03 Workbench</span>
                                            <span class="text-[10px] font-mono text-on-surface-variant">exp-churn-xgb-04</span>
                                        </div>
                                    </div>
                                    <span class="px-1.5 py-0.5 rounded bg-surface-container-highest text-secondary font-mono text-[10px] font-bold">IN-USE</span>
                                </div>
                                <!-- Consumer B -->
                                <div class="bg-surface-container p-2.5 rounded-lg shadow-md flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-[18px] text-primary">hub</span>
                                        <div class="flex flex-col">
                                            <span class="font-label-sm text-label-sm text-on-surface font-semibold">Feature Store Staging</span>
                                            <span class="text-[10px] font-mono text-on-surface-variant">churn_features_eng_v2</span>
                                        </div>
                                    </div>
                                    <span class="px-1.5 py-0.5 rounded bg-surface-container-highest text-primary font-mono text-[10px] font-bold">SUBSCRIBED</span>
                                </div>
                                <!-- Consumer C -->
                                <div class="bg-surface-container p-2.5 rounded-lg shadow-md flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-[18px] text-outline">outbox</span>
                                        <div class="flex flex-col">
                                            <span class="font-label-sm text-label-sm text-on-surface font-semibold">Export Dispatch Gateway</span>
                                            <span class="text-[10px] font-mono text-on-surface-variant">Parquet sent 42m ago</span>
                                        </div>
                                    </div>
                                    <span class="px-1.5 py-0.5 rounded bg-surface-container-highest text-outline font-mono text-[10px] font-bold">DISPATCHED</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- 3. Two-Column Inspection Section (60% Diff View / 40% Audit Security Ledger) -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-lg mb-space-lg">
                    <!-- Left Column (60%): Version History & Schema / Record Diff View -->
                    <div class="lg:col-span-7 flex flex-col gap-space-md">
                        <div class="bg-surface-container-low rounded-xl p-space-lg shadow-xl flex flex-col h-full">
                            <!-- Diff Header & Version Selector -->
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-space-sm mb-space-md pb-space-sm bg-surface-container-low">
                                <div class="flex items-center gap-space-xs">
                                    <span class="material-symbols-outlined text-[20px] text-primary">difference</span>
                                    <div class="flex flex-col">
                                        <h2 class="font-headline-sm text-headline-sm text-on-surface font-semibold">Schema &amp; Delta Record Diff</h2>
                                        <span class="font-body-sm text-body-sm text-on-surface-variant">Automated cryptographic difference verification</span>
                                    </div>
                                </div>
                                <!-- Version Comparison Selector -->
                                <div class="flex items-center gap-1.5 bg-surface-container-high px-space-sm py-1 rounded-lg text-label-sm font-mono">
                                    <span class="text-on-surface-variant">Base:</span>
                                    <span class="font-bold text-on-surface">v2.0</span>
                                    <span class="text-outline">vs</span>
                                    <span class="text-on-surface-variant">Target:</span>
                                    <span class="font-bold text-tertiary">v2.1 (Current)</span>
                                    <button class="ml-1 p-0.5 rounded hover:bg-surface-bright text-outline hover:text-on-surface" title="Switch Versions">
                                        <span class="material-symbols-outlined text-[16px]">sync_alt</span>
                                    </button>
                                </div>
                            </div>
                            <!-- Interactive Diff Metrics Summary Pills -->
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 mb-space-md">
                                <div class="bg-surface-container p-space-xs rounded-lg flex flex-col">
                                    <span class="font-label-sm text-label-sm text-outline uppercase font-mono">Cols Added</span>
                                    <span class="font-headline-sm text-headline-sm text-secondary font-mono font-bold">+2 New</span>
                                </div>
                                <div class="bg-surface-container p-space-xs rounded-lg flex flex-col">
                                    <span class="font-label-sm text-label-sm text-outline uppercase font-mono">Cols Modified</span>
                                    <span class="font-headline-sm text-headline-sm text-tertiary font-mono font-bold">~1 Cast</span>
                                </div>
                                <div class="bg-surface-container p-space-xs rounded-lg flex flex-col">
                                    <span class="font-label-sm text-label-sm text-outline uppercase font-mono">Delta Append</span>
                                    <span class="font-headline-sm text-headline-sm text-secondary font-mono font-bold">+120 Rows</span>
                                </div>
                                <div class="bg-surface-container p-space-xs rounded-lg flex flex-col">
                                    <span class="font-label-sm text-label-sm text-outline uppercase font-mono">Null Rate Shift</span>
                                    <span class="font-headline-sm text-headline-sm text-primary font-mono font-bold">-4.2% Null</span>
                                </div>
                            </div>
                            <!-- Structured Side-by-Side Unified Visual Diff Table -->
                            <div class="w-full overflow-x-auto bg-surface-container-lowest rounded-lg shadow-inner">
                                <table class="w-full text-left font-mono text-body-sm">
                                    <thead class="bg-surface-container-high text-on-surface-variant font-label-sm text-label-sm uppercase">
                                        <tr>
                                            <th class="py-2.5 px-3">Diff Tag</th>
                                            <th class="py-2.5 px-3">Customer ID</th>
                                            <th class="py-2.5 px-3">Field / Attribute</th>
                                            <th class="py-2.5 px-3">Base v2.0 State</th>
                                            <th class="py-2.5 px-3">Target v2.1 State</th>
                                            <th class="py-2.5 px-3 text-right">Reason</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-[12px] divide-y divide-surface-container-high/30">
                                        <!-- Row 1: Modified -->
                                        <tr class="hover:bg-surface-container-high/30 transition-colors bg-tertiary-container/10">
                                            <td class="py-2 px-3 font-bold text-tertiary">~ MOD</td>
                                            <td class="py-2 px-3 text-on-surface font-semibold">CUS-1004</td>
                                            <td class="py-2 px-3 text-on-surface">monthly_spend_eur</td>
                                            <td class="py-2 px-3 text-outline line-through">"84.50" (TEXT)</td>
                                            <td class="py-2 px-3 text-tertiary font-bold">84.50 (NUMERIC)</td>
                                            <td class="py-2 px-3 text-right text-on-surface-variant font-body-sm text-[11px]">Type cast normalize</td>
                                        </tr>
                                        <!-- Row 2: Added Row -->
                                        <tr class="hover:bg-surface-container-high/30 transition-colors bg-secondary-container/10">
                                            <td class="py-2 px-3 font-bold text-secondary">+ ADD</td>
                                            <td class="py-2 px-3 text-on-surface font-semibold">CUS-10481</td>
                                            <td class="py-2 px-3 text-secondary">* New Record Append</td>
                                            <td class="py-2 px-3 text-outline italic">— [Nonexistent]</td>
                                            <td class="py-2 px-3 text-secondary font-bold">Full Profile Ingested</td>
                                            <td class="py-2 px-3 text-right text-on-surface-variant font-body-sm text-[11px]">Delta batch sync</td>
                                        </tr>
                                        <!-- Row 3: Added Column -->
                                        <tr class="hover:bg-surface-container-high/30 transition-colors bg-secondary-container/10">
                                            <td class="py-2 px-3 font-bold text-secondary">+ SCHEMA</td>
                                            <td class="py-2 px-3 text-outline">GLOBAL</td>
                                            <td class="py-2 px-3 text-on-surface font-semibold">service_tier</td>
                                            <td class="py-2 px-3 text-outline italic">—</td>
                                            <td class="py-2 px-3 text-secondary font-bold">VARCHAR(32)</td>
                                            <td class="py-2 px-3 text-right text-on-surface-variant font-body-sm text-[11px]">CRM schema upgrade</td>
                                        </tr>
                                        <!-- Row 4: Added Column -->
                                        <tr class="hover:bg-surface-container-high/30 transition-colors bg-secondary-container/10">
                                            <td class="py-2 px-3 font-bold text-secondary">+ SCHEMA</td>
                                            <td class="py-2 px-3 text-outline">GLOBAL</td>
                                            <td class="py-2 px-3 text-on-surface font-semibold">support_tickets_l90d</td>
                                            <td class="py-2 px-3 text-outline italic">—</td>
                                            <td class="py-2 px-3 text-secondary font-bold">INTEGER (DEFAULT 0)</td>
                                            <td class="py-2 px-3 text-right text-on-surface-variant font-body-sm text-[11px]">Ticket feature inject</td>
                                        </tr>
                                        <!-- Row 5: Null Treated -->
                                        <tr class="hover:bg-surface-container-high/30 transition-colors bg-tertiary-container/10">
                                            <td class="py-2 px-3 font-bold text-tertiary">~ REMEDY</td>
                                            <td class="py-2 px-3 text-on-surface font-semibold">CUS-1029</td>
                                            <td class="py-2 px-3 text-on-surface">secondary_contact_email</td>
                                            <td class="py-2 px-3 text-outline italic">&lt;NULL&gt;</td>
                                            <td class="py-2 px-3 text-tertiary font-bold">"dev-lead@vstk.corp"</td>
                                            <td class="py-2 px-3 text-right text-on-surface-variant font-body-sm text-[11px]">CDC record update</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-space-sm flex items-center justify-between text-label-sm font-label-sm text-outline">
                                <span>Displaying 5 of 124 recorded delta mutations</span>
                                <a class="text-primary hover:text-primary-fixed underline transition-colors" href="#">Download Complete RFC-6902 Patch JSON</a>
                            </div>
                        </div>
                    </div>
                    <!-- Right Column (40%): Comprehensive Access & Audit Security Ledger -->
                    <div class="lg:col-span-5 flex flex-col gap-space-md">
                        <div class="bg-surface-container-low rounded-xl p-space-lg shadow-xl flex flex-col h-full">
                            <!-- Ledger Header -->
                            <div class="flex items-center justify-between mb-space-sm">
                                <div class="flex items-center gap-space-xs">
                                    <span class="material-symbols-outlined text-[20px] text-tertiary">policy</span>
                                    <div class="flex flex-col">
                                        <h2 class="font-headline-sm text-headline-sm text-on-surface font-semibold">Security &amp; Audit Log</h2>
                                        <span class="font-body-sm text-body-sm text-on-surface-variant">Immutable WORM cryptographic event journal</span>
                                    </div>
                                </div>
                                <span class="h-2 w-2 rounded-full bg-tertiary animate-pulse" title="Active Append Stream"></span>
                            </div>
                            <!-- Filter Chips Bar -->
                            <div class="flex items-center gap-1 overflow-x-auto pb-2 mb-space-xs font-label-sm text-label-sm">
                                <button class="px-2.5 py-0.5 rounded-full bg-surface-container-highest text-on-surface font-semibold whitespace-nowrap">All Events</button>
                                <button class="px-2.5 py-0.5 rounded-full text-on-surface-variant hover:text-on-surface whitespace-nowrap">Exports</button>
                                <button class="px-2.5 py-0.5 rounded-full text-on-surface-variant hover:text-on-surface whitespace-nowrap">Queries</button>
                                <button class="px-2.5 py-0.5 rounded-full text-on-surface-variant hover:text-on-surface whitespace-nowrap">Ingests</button>
                                <button class="px-2.5 py-0.5 rounded-full text-on-surface-variant hover:text-on-surface whitespace-nowrap">Clearances</button>
                            </div>
                            <!-- High-Density Chronological Security Ledger Stream -->
                            <div class="flex flex-col gap-space-sm overflow-y-auto max-h-[460px] pr-1">
                                <!-- Event 1 -->
                                <div class="bg-surface-container p-space-sm rounded-lg flex flex-col gap-1 shadow-sm">
                                    <div class="flex items-center justify-between font-mono text-[11px]">
                                        <span class="text-tertiary font-bold flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[14px]">file_download</span>
                                            EXPORT DISPATCH
                                        </span>
                                        <span class="text-outline">14:32:08 UTC</span>
                                    </div>
                                    <p class="font-body-sm text-body-sm text-on-surface leading-tight">
                                        Parquet export (1.12 MB) generated by <strong class="text-primary font-mono font-medium">Intern AI Engineer #09412</strong> (LVL-2 Clearance).
                                    </p>
                                    <div class="flex items-center justify-between text-[10px] font-mono text-on-surface-variant mt-1 pt-1 bg-surface-container-high/40 rounded px-1.5 py-0.5">
                                        <span>Node: DC-NORTH-EDGE-04</span>
                                        <span class="text-secondary font-semibold">SIG: 9c2b...f801 (WORM OK)</span>
                                    </div>
                                </div>
                                <!-- Event 2 -->
                                <div class="bg-surface-container p-space-sm rounded-lg flex flex-col gap-1 shadow-sm">
                                    <div class="flex items-center justify-between font-mono text-[11px]">
                                        <span class="text-primary font-bold flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[14px]">data_object</span>
                                            SQL QUERY EXEC
                                        </span>
                                        <span class="text-outline">13:15:40 UTC</span>
                                    </div>
                                    <p class="font-body-sm text-body-sm text-on-surface leading-tight">
                                        Executed query <code class="text-tertiary font-mono">QRY-2024-0914-08</code> returning 500 rows via DuckDB OLAP engine for profiling inspect.
                                    </p>
                                    <div class="flex items-center justify-between text-[10px] font-mono text-on-surface-variant mt-1 pt-1 bg-surface-container-high/40 rounded px-1.5 py-0.5">
                                        <span>Operator: Intern #09412</span>
                                        <span class="text-secondary">SIG: 18aa...de39</span>
                                    </div>
                                </div>
                                <!-- Event 3 -->
                                <div class="bg-surface-container p-space-sm rounded-lg flex flex-col gap-1 shadow-sm">
                                    <div class="flex items-center justify-between font-mono text-[11px]">
                                        <span class="text-secondary font-bold flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[14px]">fact_check</span>
                                            SCHEMA AUDIT GATE
                                        </span>
                                        <span class="text-outline">11:02:19 UTC</span>
                                    </div>
                                    <p class="font-body-sm text-body-sm text-on-surface leading-tight">
                                        Automated Pre-Flight Gatekeeper passed 6/6 tests. 0 collisions detected, 1 advisory issued on null string casing.
                                    </p>
                                    <div class="flex items-center justify-between text-[10px] font-mono text-on-surface-variant mt-1 pt-1 bg-surface-container-high/40 rounded px-1.5 py-0.5">
                                        <span>Runner: sys_validator_daemon</span>
                                        <span class="text-secondary">SIG: e204...91c5</span>
                                    </div>
                                </div>
                                <!-- Event 4 -->
                                <div class="bg-surface-container p-space-sm rounded-lg flex flex-col gap-1 shadow-sm">
                                    <div class="flex items-center justify-between font-mono text-[11px]">
                                        <span class="text-primary font-bold flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[14px]">sync</span>
                                            PIPELINE INGESTION
                                        </span>
                                        <span class="text-outline">08:44:11 UTC</span>
                                    </div>
                                    <p class="font-body-sm text-body-sm text-on-surface leading-tight">
                                        Scheduled sync <code class="text-primary font-mono">etl_crm_sync#892</code> appended 120 records from SYS05 Postgres CDC replica.
                                    </p>
                                    <div class="flex items-center justify-between text-[10px] font-mono text-on-surface-variant mt-1 pt-1 bg-surface-container-high/40 rounded px-1.5 py-0.5">
                                        <span>Source: pg_wal_stream#02</span>
                                        <span class="text-secondary">SIG: bb19...456c</span>
                                    </div>
                                </div>
                                <!-- Event 5 -->
                                <div class="bg-surface-container p-space-sm rounded-lg flex flex-col gap-1 shadow-sm">
                                    <div class="flex items-center justify-between font-mono text-[11px]">
                                        <span class="text-tertiary font-bold flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[14px]">security</span>
                                            CLEARANCE VERIFIED
                                        </span>
                                        <span class="text-outline">Yesterday 18:20 UTC</span>
                                    </div>
                                    <p class="font-body-sm text-body-sm text-on-surface leading-tight">
                                        Security clearance token elevated to Level 2 for active Ticket <strong class="text-tertiary font-mono">#AI-024 Customer Churn</strong>.
                                    </p>
                                    <div class="flex items-center justify-between text-[10px] font-mono text-on-surface-variant mt-1 pt-1 bg-surface-container-high/40 rounded px-1.5 py-0.5">
                                        <span>Grantor: SYS-AUTH-01</span>
                                        <span class="text-secondary">SIG: 70d4...119b</span>
                                    </div>
                                </div>
                                <!-- Event 6 -->
                                <div class="bg-surface-container p-space-sm rounded-lg flex flex-col gap-1 shadow-sm">
                                    <div class="flex items-center justify-between font-mono text-[11px]">
                                        <span class="text-outline font-bold flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[14px]">archive</span>
                                            DATASET INITIALIZED
                                        </span>
                                        <span class="text-outline">3d ago</span>
                                    </div>
                                    <p class="font-body-sm text-body-sm text-on-surface leading-tight">
                                        v1.0 initial genesis ingestion registered by Data Engineering Lead (Clearance LVL-3).
                                    </p>
                                    <div class="flex items-center justify-between text-[10px] font-mono text-on-surface-variant mt-1 pt-1 bg-surface-container-high/40 rounded px-1.5 py-0.5">
                                        <span>Target: tier1_cold_s3</span>
                                        <span class="text-secondary">SIG: 00a1...ff92</span>
                                    </div>
                                </div>
                            </div>
                            <button class="mt-space-sm w-full py-1.5 rounded bg-surface-container-high text-on-surface hover:bg-surface-bright transition-colors font-label-sm text-label-sm font-mono flex items-center justify-center gap-1 shadow-sm">
                                <span class="material-symbols-outlined text-[16px]">fingerprint</span>
                                Verify Entire WORM Merkle Tree
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Operational Telemetry Bar / Footer -->
                <div class="bg-surface-container-low rounded-lg p-space-sm flex flex-col sm:flex-row items-center justify-between gap-space-sm shadow-md">
                    <div class="flex items-center gap-space-md">
                        <div class="flex items-center gap-2 font-mono text-[11px]">
                            <span class="h-2 w-2 rounded-full bg-tertiary animate-pulse"></span>
                            <span class="text-on-surface font-semibold">SYS-AI-02 LINEAGE ENGINE</span>
                            <span class="text-outline">|</span>
                            <span class="text-on-surface-variant">NODE TELEMETRY: <strong class="text-tertiary">ONLINE</strong></span>
                        </div>
                        <div class="hidden md:flex items-center gap-2 font-mono text-[11px] text-outline">
                            <span>ARRAY CORE LOAD: <span class="text-on-surface font-semibold">84%</span></span>
                        </div>
                    </div>
                    <div class="flex items-center gap-space-md font-mono text-[11px] text-on-surface-variant">
                        <div class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px] text-primary">lock</span>
                            <span>TLS 1.3 AES-256-GCM</span>
                        </div>
                        <span class="text-outline">|</span>
                        <div class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px] text-tertiary">history_edu</span>
                            <span class="text-on-surface">SECURITY LEDGER WORM: ACTIVE</span>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                // Micro-interaction: Interactive Tooltip or Node Highlight in Lineage
                document.addEventListener('DOMContentLoaded', () => {
                    const nodes = document.querySelectorAll('.min-w-\\[960px\\] > div');
                    nodes.forEach(node => {
                        node.addEventListener('mouseenter', () => {
                            node.classList.add('scale-[1.02]');
                        });
                        node.addEventListener('mouseleave', () => {
                            node.classList.remove('scale-[1.02]');
                        });
                    });
                });
            </script>
        </main>
    </div>
</body>

</html>