<!DOCTYPE html>

<html class="dark" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="web_dashboard" name="shell-type" />
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&amp;family=Inter:wght@400;500;600&amp;display=swap" rel="stylesheet" />
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
                <nav class="flex flex-col gap-space-2xs" data-active-classes="bg-surface-container-high text-on-surface font-semibold"><a class="flex items-center gap-space-sm px-space-sm py-space-xs rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-colors font-label-lg text-label-lg" data-path="projects" href="#"><span class="material-symbols-outlined text-[18px]">folder_supervised</span><span>SYS-AI-01 Projects</span></a><a aria-current="page" class="flex items-center justify-between px-space-sm py-space-xs rounded transition-colors bg-surface-container-high text-on-surface font-semibold" data-path="data-center" href="#">
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
            <div class="flex flex-col w-full gap-space-lg text-on-surface">
                <!-- Diagnostic Telemetry Ribbon / Quick Counter Tiles -->
                <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-space-md">
                    <!-- Stat 1 -->
                    <div class="bg-surface-container-high rounded-xl p-space-md shadow-md flex items-center justify-between">
                        <div class="flex flex-col">
                            <span class="font-label-sm text-label-sm text-outline uppercase tracking-widest">Catalog Partition</span>
                            <div class="flex items-baseline gap-space-2xs mt-1">
                                <span class="font-telemetry-num text-telemetry-num text-on-surface">28</span>
                                <span class="font-label-sm text-label-sm text-on-surface-variant font-mono">OBJECTS</span>
                            </div>
                            <span class="font-body-sm text-body-sm text-primary mt-0.5">SYS-AI Distributed Vault</span>
                        </div>
                        <div class="w-10 h-10 rounded-lg bg-surface-container flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined text-[24px]">dataset</span>
                        </div>
                    </div>
                    <!-- Stat 2 -->
                    <div class="bg-surface-container-high rounded-xl p-space-md shadow-md flex items-center justify-between">
                        <div class="flex flex-col">
                            <span class="font-label-sm text-label-sm text-outline uppercase tracking-widest">Accessible Nodes</span>
                            <div class="flex items-baseline gap-space-2xs mt-1">
                                <span class="font-telemetry-num text-telemetry-num text-tertiary">24</span>
                                <span class="font-label-sm text-label-sm text-tertiary/70 font-mono">GRANTED</span>
                            </div>
                            <span class="font-body-sm text-body-sm text-on-surface-variant mt-0.5">Tier 1 &amp; Tier 2 Decrypted</span>
                        </div>
                        <div class="w-10 h-10 rounded-lg bg-tertiary-container flex items-center justify-center text-tertiary">
                            <span class="material-symbols-outlined text-[24px]">lock_open</span>
                        </div>
                    </div>
                    <!-- Stat 3 -->
                    <div class="bg-surface-container-high rounded-xl p-space-md shadow-md flex items-center justify-between">
                        <div class="flex flex-col">
                            <span class="font-label-sm text-label-sm text-outline uppercase tracking-widest">Enclave Restricted</span>
                            <div class="flex items-baseline gap-space-2xs mt-1">
                                <span class="font-telemetry-num text-telemetry-num text-error">04</span>
                                <span class="font-label-sm text-label-sm text-error/70 font-mono">L3 REQ</span>
                            </div>
                            <span class="font-body-sm text-body-sm text-on-surface-variant mt-0.5">Air-gapped Top Secret</span>
                        </div>
                        <div class="w-10 h-10 rounded-lg bg-error-container/40 flex items-center justify-center text-error">
                            <span class="material-symbols-outlined text-[24px]">key_off</span>
                        </div>
                    </div>
                    <!-- Stat 4 -->
                    <div class="bg-surface-container-high rounded-xl p-space-md shadow-md flex items-center justify-between">
                        <div class="flex flex-col">
                            <span class="font-label-sm text-label-sm text-outline uppercase tracking-widest">Ingestion Pipeline</span>
                            <div class="flex items-baseline gap-space-2xs mt-1">
                                <span class="font-telemetry-num text-telemetry-num text-secondary">00</span>
                                <span class="font-label-sm text-label-sm text-secondary/70 font-mono">STANDBY</span>
                            </div>
                            <span class="font-body-sm text-body-sm text-primary mt-0.5">Zero Degraded Endpoints</span>
                        </div>
                        <div class="w-10 h-10 rounded-lg bg-surface-container flex items-center justify-center text-secondary">
                            <span class="material-symbols-outlined text-[24px]">sync_saved_locally</span>
                        </div>
                    </div>
                </section>
                <!-- Control & Filter Deck -->
                <section class="bg-surface-container-low rounded-xl p-space-md shadow-lg flex flex-col gap-space-md">
                    <!-- Row 1: Search, Classification selector, Clearance Chip, Primary Actions -->
                    <div class="flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-space-md">
                        <!-- Left side: Search & Dropdown -->
                        <div class="flex flex-1 flex-col sm:flex-row items-stretch sm:items-center gap-space-sm">
                            <div class="relative flex-1">
                                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[18px] text-outline">search</span>
                                <input class="w-full h-10 bg-surface-container-lowest text-on-surface text-body-sm font-body-sm pl-10 pr-space-md rounded-lg focus:outline-none focus:ring-1 focus:ring-tertiary placeholder:text-outline" id="catalogSearchInput" placeholder="Search datasets by schema, column, system, lineage..." type="text" />
                            </div>
                            <!-- Classification Selector -->
                            <div class="relative min-w-[170px]">
                                <select class="w-full h-10 bg-surface-container-lowest text-on-surface text-body-sm font-body-sm px-space-md rounded-lg appearance-none cursor-pointer focus:outline-none focus:ring-1 focus:ring-tertiary pr-8">
                                    <option value="ALL">Classification: All</option>
                                    <option value="PUB">Public</option>
                                    <option value="INT">Internal</option>
                                    <option selected="" value="CONF">Confidential</option>
                                    <option value="TS">Top Secret (Air-Gapped)</option>
                                </select>
                                <span class="material-symbols-outlined absolute right-2.5 top-1/2 -translate-y-1/2 text-outline pointer-events-none text-[18px]">unfold_more</span>
                            </div>
                        </div>
                        <!-- Right side: Clearance Level Badge & Action Buttons -->
                        <div class="flex flex-wrap items-center gap-space-sm justify-end">
                            <!-- Clearance Chip -->
                            <div class="flex items-center gap-space-xs px-space-sm py-1.5 rounded-full bg-surface-container-high shadow-sm">
                                <span class="h-2 w-2 rounded-full bg-tertiary animate-pulse"></span>
                                <span class="font-label-sm text-label-sm text-on-surface uppercase tracking-wider">Clearance: Level 2</span>
                                <span class="font-label-sm text-label-sm bg-tertiary/20 text-tertiary px-1.5 py-0.5 rounded font-mono">CONFIDENTIAL OK</span>
                            </div>
                            <!-- Buttons -->
                            <button class="h-9 px-space-md rounded-lg bg-surface-container-high hover:bg-surface-bright text-on-surface text-label-lg font-label-lg flex items-center gap-space-xs shadow-sm transition-colors">
                                <span class="material-symbols-outlined text-[18px]">download_for_offline</span>
                                <span>Download</span>
                            </button>
                            <button class="h-9 px-space-md rounded-lg bg-secondary-container hover:bg-surface-variant text-on-surface text-label-lg font-label-lg flex items-center gap-space-xs shadow-sm transition-colors">
                                <span class="material-symbols-outlined text-[18px]">refresh</span>
                                <span>Refresh</span>
                            </button>
                            <button class="h-9 px-space-md rounded-lg bg-primary hover:bg-primary-fixed-dim text-on-primary text-label-lg font-label-lg flex items-center gap-space-xs shadow-md transition-colors font-semibold">
                                <span class="material-symbols-outlined text-[18px]">cloud_upload</span>
                                <span>Upload Processed Data</span>
                            </button>
                        </div>
                    </div>
                    <!-- Row 2: Subsystem filter tabs & Layout View Toggle -->
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-space-sm pt-space-xs">
                        <!-- Subsystem Filter Pills -->
                        <div class="flex items-center gap-1.5 overflow-x-auto w-full sm:w-auto pb-1 sm:pb-0" id="filterPillGroup">
                            <button class="filter-pill px-space-sm py-1 rounded font-label-sm text-label-sm uppercase tracking-wider bg-primary-container text-primary font-bold shadow-sm transition-colors">All Systems</button>
                            <button class="filter-pill px-space-sm py-1 rounded font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant hover:text-on-surface hover:bg-surface-container transition-colors">SYS05 CRM</button>
                            <button class="filter-pill px-space-sm py-1 rounded font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant hover:text-on-surface hover:bg-surface-container transition-colors">SYS06 HR</button>
                            <button class="filter-pill px-space-sm py-1 rounded font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant hover:text-on-surface hover:bg-surface-container transition-colors">SYS07 Finance</button>
                            <button class="filter-pill px-space-sm py-1 rounded font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant hover:text-on-surface hover:bg-surface-container transition-colors">SYS08 IT Helpdesk</button>
                            <button class="filter-pill px-space-sm py-1 rounded font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant hover:text-on-surface hover:bg-surface-container transition-colors">SYS09 File Center</button>
                        </div>
                        <!-- Layout View Toggle -->
                        <div class="flex items-center bg-surface-container-lowest p-1 rounded-lg self-end sm:self-auto shadow-inner">
                            <button class="px-space-sm py-1 rounded text-label-sm font-label-sm flex items-center gap-1 bg-surface-container-high text-on-surface shadow-sm font-semibold transition-all" id="viewToggleBento">
                                <span class="material-symbols-outlined text-[16px]">grid_view</span>
                                <span>Bento</span>
                            </button>
                            <button class="px-space-sm py-1 rounded text-label-sm font-label-sm flex items-center gap-1 text-on-surface-variant hover:text-on-surface transition-all" id="viewToggleTable">
                                <span class="material-symbols-outlined text-[16px]">table_rows</span>
                                <span>Matrix Table</span>
                            </button>
                        </div>
                    </div>
                </section>
                <!-- BENTO INSTRUMENTATION CARDS CONTAINER (Light Periwinkle Cards on Slate Surface) -->
                <section class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-space-md transition-all" id="bentoContainer">
                    <!-- DATASET 01: customers.csv -->
                    <article class="bg-[#C9DBFF] text-[#0F2438] rounded-xl p-space-md shadow-md flex flex-col justify-between transition-transform hover:-translate-y-0.5 duration-200">
                        <div>
                            <!-- Card Header Strip -->
                            <div class="flex items-start justify-between gap-space-sm">
                                <div class="flex items-center gap-space-sm">
                                    <div class="w-10 h-10 rounded-lg bg-[#0F2438] text-tertiary flex items-center justify-center font-bold font-mono">
                                        CSV
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-headline-sm text-headline-sm tracking-tight text-[#0F2438]">customers.csv</span>
                                        <div class="flex items-center gap-1.5 mt-0.5">
                                            <span class="font-label-sm text-label-sm text-[#1B3A5C] font-semibold">SYS05 CRM</span>
                                            <span class="text-[#5C7290] font-mono text-[10px]">•</span>
                                            <span class="font-label-sm text-label-sm text-[#5C7290] font-mono">v2.1</span>
                                        </div>
                                    </div>
                                </div>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-label-sm font-label-sm font-bold bg-[#E8A33D]/25 text-[#462B00] uppercase tracking-wider">
                                    Confidential
                                </span>
                            </div>
                            <!-- Telemetry Spec Cluster -->
                            <div class="grid grid-cols-4 gap-2 my-space-md p-2.5 rounded-lg bg-[#E3ECFF]">
                                <div class="flex flex-col">
                                    <span class="font-label-sm text-label-sm text-[#5C7290] uppercase">Rows</span>
                                    <span class="font-label-lg text-label-lg font-bold font-mono text-[#0F2438]">10,480</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-label-sm text-label-sm text-[#5C7290] uppercase">Cols</span>
                                    <span class="font-label-lg text-label-lg font-bold font-mono text-[#0F2438]">18</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-label-sm text-label-sm text-[#5C7290] uppercase">Size</span>
                                    <span class="font-label-lg text-label-lg font-bold font-mono text-[#0F2438]">4.2 MB</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-label-sm text-label-sm text-[#5C7290] uppercase">Sync</span>
                                    <span class="font-label-lg text-label-lg font-bold text-[#0F2438]">14m ago</span>
                                </div>
                            </div>
                            <!-- Record Sample Stream -->
                            <div class="flex flex-col gap-1.5 mb-space-md">
                                <span class="font-label-sm text-label-sm text-[#5C7290] uppercase tracking-wider">Sample Record Register</span>
                                <div class="bg-[#E3ECFF] rounded-lg p-2 font-mono text-[11px] leading-relaxed text-[#1B3A5C] flex flex-col gap-1">
                                    <div class="truncate flex items-center justify-between">
                                        <span class="font-bold text-[#0F2438]">CUS-1001</span>
                                        <span class="truncate ml-2 text-[#2D5480]">Aral Geomatics Group</span>
                                        <span class="text-[#2E9E6B] font-semibold text-[10px]">ACTIVE</span>
                                    </div>
                                    <div class="truncate flex items-center justify-between">
                                        <span class="font-bold text-[#0F2438]">CUS-1002</span>
                                        <span class="truncate ml-2 text-[#2D5480]">BaltNord Process Systems</span>
                                        <span class="text-[#2E9E6B] font-semibold text-[10px]">ACTIVE</span>
                                    </div>
                                    <div class="truncate flex items-center justify-between">
                                        <span class="font-bold text-[#0F2438]">CUS-1003</span>
                                        <span class="truncate ml-2 text-[#2D5480]">Steppe Mining Technologies</span>
                                        <span class="text-[#E8A33D] font-semibold text-[10px]">FLAGGED</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Action Card Footer -->
                        <div class="pt-space-xs flex items-center justify-between">
                            <div class="flex items-center gap-1.5">
                                <span class="h-2 w-2 rounded-full bg-[#2E9E6B]"></span>
                                <span class="font-label-sm text-label-sm text-[#1B3A5C] uppercase tracking-wider font-semibold">Ready for Profiling</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <button class="w-8 h-8 rounded bg-[#0F2438] text-tertiary flex items-center justify-center hover:opacity-90 transition-opacity" title="Inspect Lineage">
                                    <span class="material-symbols-outlined text-[16px]">account_tree</span>
                                </button>
                                <button class="w-8 h-8 rounded bg-[#0F2438] text-[#E3ECFF] flex items-center justify-center hover:opacity-90 transition-opacity" title="Query Records">
                                    <span class="material-symbols-outlined text-[16px]">terminal</span>
                                </button>
                                <button class="px-space-sm h-8 rounded bg-[#0F2438] text-white font-label-lg text-label-lg font-semibold hover:bg-[#1B3A5C] transition-colors flex items-center gap-1">
                                    <span>Preview</span>
                                    <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                                </button>
                            </div>
                        </div>
                    </article>
                    <!-- DATASET 02: transactions.csv -->
                    <article class="bg-[#C9DBFF] text-[#0F2438] rounded-xl p-space-md shadow-md flex flex-col justify-between transition-transform hover:-translate-y-0.5 duration-200">
                        <div>
                            <!-- Card Header Strip -->
                            <div class="flex items-start justify-between gap-space-sm">
                                <div class="flex items-center gap-space-sm">
                                    <div class="w-10 h-10 rounded-lg bg-[#0F2438] text-tertiary flex items-center justify-center font-bold font-mono">
                                        CSV
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-headline-sm text-headline-sm tracking-tight text-[#0F2438]">transactions.csv</span>
                                        <div class="flex items-center gap-1.5 mt-0.5">
                                            <span class="font-label-sm text-label-sm text-[#1B3A5C] font-semibold">SYS07 Finance</span>
                                            <span class="text-[#5C7290] font-mono text-[10px]">•</span>
                                            <span class="font-label-sm text-label-sm text-[#5C7290] font-mono">v1.4</span>
                                        </div>
                                    </div>
                                </div>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-label-sm font-label-sm font-bold bg-[#E8A33D]/25 text-[#462B00] uppercase tracking-wider">
                                    Confidential
                                </span>
                            </div>
                            <!-- Telemetry Spec Cluster -->
                            <div class="grid grid-cols-4 gap-2 my-space-md p-2.5 rounded-lg bg-[#E3ECFF]">
                                <div class="flex flex-col">
                                    <span class="font-label-sm text-label-sm text-[#5C7290] uppercase">Rows</span>
                                    <span class="font-label-lg text-label-lg font-bold font-mono text-[#0F2438]">84,200</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-label-sm text-label-sm text-[#5C7290] uppercase">Cols</span>
                                    <span class="font-label-lg text-label-lg font-bold font-mono text-[#0F2438]">12</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-label-sm text-label-sm text-[#5C7290] uppercase">Size</span>
                                    <span class="font-label-lg text-label-lg font-bold font-mono text-[#0F2438]">18.6 MB</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-label-sm text-label-sm text-[#5C7290] uppercase">Sync</span>
                                    <span class="font-label-lg text-label-lg font-bold text-[#0F2438]">2h ago</span>
                                </div>
                            </div>
                            <!-- Record Sample Stream -->
                            <div class="flex flex-col gap-1.5 mb-space-md">
                                <span class="font-label-sm text-label-sm text-[#5C7290] uppercase tracking-wider">Sample Record Register</span>
                                <div class="bg-[#E3ECFF] rounded-lg p-2 font-mono text-[11px] leading-relaxed text-[#1B3A5C] flex flex-col gap-1">
                                    <div class="truncate flex items-center justify-between">
                                        <span class="font-bold text-[#0F2438]">TX-99014</span>
                                        <span class="text-[#2D5480]">EUR 14,250.00</span>
                                        <span class="text-[#2E9E6B] font-semibold text-[10px]">SETTLED</span>
                                    </div>
                                    <div class="truncate flex items-center justify-between">
                                        <span class="font-bold text-[#0F2438]">TX-99015</span>
                                        <span class="text-[#2D5480]">EUR 8,920.50</span>
                                        <span class="text-[#2E9E6B] font-semibold text-[10px]">SETTLED</span>
                                    </div>
                                    <div class="truncate flex items-center justify-between">
                                        <span class="font-bold text-[#0F2438]">TX-99016</span>
                                        <span class="text-[#2D5480]">EUR 420.00</span>
                                        <span class="text-[#5C7290] font-semibold text-[10px]">ESCROW</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Action Card Footer -->
                        <div class="pt-space-xs flex items-center justify-between">
                            <div class="flex items-center gap-1.5">
                                <span class="h-2 w-2 rounded-full bg-[#2E9E6B]"></span>
                                <span class="font-label-sm text-label-sm text-[#1B3A5C] uppercase tracking-wider font-semibold">Ledger Check Passed</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <button class="w-8 h-8 rounded bg-[#0F2438] text-tertiary flex items-center justify-center hover:opacity-90 transition-opacity" title="Inspect Lineage">
                                    <span class="material-symbols-outlined text-[16px]">account_tree</span>
                                </button>
                                <button class="w-8 h-8 rounded bg-[#0F2438] text-[#E3ECFF] flex items-center justify-center hover:opacity-90 transition-opacity" title="Query Records">
                                    <span class="material-symbols-outlined text-[16px]">terminal</span>
                                </button>
                                <button class="px-space-sm h-8 rounded bg-[#0F2438] text-white font-label-lg text-label-lg font-semibold hover:bg-[#1B3A5C] transition-colors flex items-center gap-1">
                                    <span>Preview</span>
                                    <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                                </button>
                            </div>
                        </div>
                    </article>
                    <!-- DATASET 03: support_tickets.csv -->
                    <article class="bg-[#C9DBFF] text-[#0F2438] rounded-xl p-space-md shadow-md flex flex-col justify-between transition-transform hover:-translate-y-0.5 duration-200">
                        <div>
                            <!-- Card Header Strip -->
                            <div class="flex items-start justify-between gap-space-sm">
                                <div class="flex items-center gap-space-sm">
                                    <div class="w-10 h-10 rounded-lg bg-[#0F2438] text-tertiary flex items-center justify-center font-bold font-mono">
                                        CSV
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-headline-sm text-headline-sm tracking-tight text-[#0F2438]">support_tickets.csv</span>
                                        <div class="flex items-center gap-1.5 mt-0.5">
                                            <span class="font-label-sm text-label-sm text-[#1B3A5C] font-semibold">SYS08 IT Helpdesk</span>
                                            <span class="text-[#5C7290] font-mono text-[10px]">•</span>
                                            <span class="font-label-sm text-label-sm text-[#5C7290] font-mono">v1.0</span>
                                        </div>
                                    </div>
                                </div>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-label-sm font-label-sm font-bold bg-[#0F2438]/15 text-[#0F2438] uppercase tracking-wider">
                                    Internal
                                </span>
                            </div>
                            <!-- Telemetry Spec Cluster -->
                            <div class="grid grid-cols-4 gap-2 my-space-md p-2.5 rounded-lg bg-[#E3ECFF]">
                                <div class="flex flex-col">
                                    <span class="font-label-sm text-label-sm text-[#5C7290] uppercase">Rows</span>
                                    <span class="font-label-lg text-label-lg font-bold font-mono text-[#0F2438]">5,612</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-label-sm text-label-sm text-[#5C7290] uppercase">Cols</span>
                                    <span class="font-label-lg text-label-lg font-bold font-mono text-[#0F2438]">14</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-label-sm text-label-sm text-[#5C7290] uppercase">Size</span>
                                    <span class="font-label-lg text-label-lg font-bold font-mono text-[#0F2438]">2.1 MB</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-label-sm text-label-sm text-[#5C7290] uppercase">Sync</span>
                                    <span class="font-label-lg text-label-lg font-bold text-[#0F2438]">Yesterday</span>
                                </div>
                            </div>
                            <!-- Record Sample Stream -->
                            <div class="flex flex-col gap-1.5 mb-space-md">
                                <span class="font-label-sm text-label-sm text-[#5C7290] uppercase tracking-wider">Priority Distribution</span>
                                <div class="bg-[#E3ECFF] rounded-lg p-2 font-mono text-[11px] leading-relaxed text-[#1B3A5C] flex flex-col gap-1">
                                    <div class="flex items-center justify-between">
                                        <span class="font-bold text-[#0F2438]">P1 - Urgent</span>
                                        <span class="text-[#C62828] font-bold">14 incidents</span>
                                        <span class="text-[10px] text-[#5C7290]">MTTR 42m</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="font-bold text-[#0F2438]">P2 - High</span>
                                        <span class="text-[#E8A33D] font-bold">89 incidents</span>
                                        <span class="text-[10px] text-[#5C7290]">MTTR 3.4h</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="font-bold text-[#0F2438]">P3 - Normal</span>
                                        <span class="text-[#2E9E6B] font-bold">5,509 incidents</span>
                                        <span class="text-[10px] text-[#5C7290]">MTTR 18h</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Action Card Footer -->
                        <div class="pt-space-xs flex items-center justify-between">
                            <div class="flex items-center gap-1.5">
                                <span class="h-2 w-2 rounded-full bg-[#2E9E6B]"></span>
                                <span class="font-label-sm text-label-sm text-[#1B3A5C] uppercase tracking-wider font-semibold">Indexed</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <button class="w-8 h-8 rounded bg-[#0F2438] text-tertiary flex items-center justify-center hover:opacity-90 transition-opacity" title="Inspect Lineage">
                                    <span class="material-symbols-outlined text-[16px]">account_tree</span>
                                </button>
                                <button class="w-8 h-8 rounded bg-[#0F2438] text-[#E3ECFF] flex items-center justify-center hover:opacity-90 transition-opacity" title="Query Records">
                                    <span class="material-symbols-outlined text-[16px]">terminal</span>
                                </button>
                                <button class="px-space-sm h-8 rounded bg-[#0F2438] text-white font-label-lg text-label-lg font-semibold hover:bg-[#1B3A5C] transition-colors flex items-center gap-1">
                                    <span>Preview</span>
                                    <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                                </button>
                            </div>
                        </div>
                    </article>
                    <!-- DATASET 04: employee_evaluations.parquet (RESTRICTED) -->
                    <article class="bg-[#112338] text-on-surface rounded-xl p-space-md shadow-md flex flex-col justify-between relative overflow-hidden">
                        <!-- Decorative Security Grid Stencil Overlay -->
                        <div class="absolute -right-4 -bottom-4 text-error/10 pointer-events-none select-none">
                            <span class="material-symbols-outlined text-[160px]">shield_locked</span>
                        </div>
                        <div>
                            <!-- Card Header Strip -->
                            <div class="flex items-start justify-between gap-space-sm relative z-10">
                                <div class="flex items-center gap-space-sm">
                                    <div class="w-10 h-10 rounded-lg bg-surface-container-lowest text-error flex items-center justify-center font-bold font-mono">
                                        PARQ
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-headline-sm text-headline-sm tracking-tight text-on-surface">employee_evaluations.parquet</span>
                                        <div class="flex items-center gap-1.5 mt-0.5">
                                            <span class="font-label-sm text-label-sm text-on-surface-variant font-semibold">SYS06 HR</span>
                                            <span class="text-outline font-mono text-[10px]">•</span>
                                            <span class="font-label-sm text-label-sm text-outline font-mono">v1.0</span>
                                        </div>
                                    </div>
                                </div>
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-label-sm font-label-sm font-bold bg-error-container text-on-error-container uppercase tracking-wider">
                                    <span class="material-symbols-outlined text-[12px]">lock</span>
                                    Top Secret
                                </span>
                            </div>
                            <!-- Telemetry Spec Cluster (Locked state) -->
                            <div class="grid grid-cols-4 gap-2 my-space-md p-2.5 rounded-lg bg-surface-container-lowest/80 relative z-10">
                                <div class="flex flex-col">
                                    <span class="font-label-sm text-label-sm text-outline uppercase">Rows</span>
                                    <span class="font-label-lg text-label-lg font-bold font-mono text-on-surface">1,240</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-label-sm text-label-sm text-outline uppercase">Cols</span>
                                    <span class="font-label-lg text-label-lg font-bold font-mono text-on-surface">22</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-label-sm text-label-sm text-outline uppercase">Size</span>
                                    <span class="font-label-lg text-label-lg font-bold font-mono text-on-surface">840 KB</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-label-sm text-label-sm text-outline uppercase">Sync</span>
                                    <span class="font-label-lg text-label-lg font-bold text-on-surface">3d ago</span>
                                </div>
                            </div>
                            <!-- Locked Barrier Warning Box -->
                            <div class="bg-error-container/20 rounded-lg p-3 text-body-sm font-body-sm text-on-surface flex flex-col gap-1.5 relative z-10">
                                <div class="flex items-center gap-1.5 text-error font-semibold font-label-sm text-label-sm uppercase">
                                    <span class="material-symbols-outlined text-[16px]">gpp_bad</span>
                                    <span>Restricted Access Node</span>
                                </div>
                                <p class="text-body-sm text-on-surface-variant leading-snug">
                                    Security policy prohibits profiling without Clearance Level 3 authorization. Schema hash verified.
                                </p>
                            </div>
                        </div>
                        <!-- Action Card Footer -->
                        <div class="pt-space-md flex items-center justify-between relative z-10">
                            <div class="flex items-center gap-1.5">
                                <span class="h-2 w-2 rounded-full bg-error animate-ping"></span>
                                <span class="font-label-sm text-label-sm text-error uppercase tracking-wider font-semibold">Locked (L3 Required)</span>
                            </div>
                            <button class="px-space-sm h-8 rounded bg-surface-container-highest hover:bg-surface-bright text-on-surface font-label-lg text-label-lg transition-colors flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px] text-tertiary">vpn_key</span>
                                <span>Request Access</span>
                            </button>
                        </div>
                    </article>
                    <!-- DATASET 05: unstructured_contracts.zip -->
                    <article class="bg-[#C9DBFF] text-[#0F2438] rounded-xl p-space-md shadow-md flex flex-col justify-between transition-transform hover:-translate-y-0.5 duration-200">
                        <div>
                            <!-- Card Header Strip -->
                            <div class="flex items-start justify-between gap-space-sm">
                                <div class="flex items-center gap-space-sm">
                                    <div class="w-10 h-10 rounded-lg bg-[#0F2438] text-tertiary flex items-center justify-center font-bold font-mono">
                                        ZIP
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-headline-sm text-headline-sm tracking-tight text-[#0F2438]">unstructured_contracts.zip</span>
                                        <div class="flex items-center gap-1.5 mt-0.5">
                                            <span class="font-label-sm text-label-sm text-[#1B3A5C] font-semibold">SYS09 File Center</span>
                                            <span class="text-[#5C7290] font-mono text-[10px]">•</span>
                                            <span class="font-label-sm text-label-sm text-[#5C7290] font-mono">v0.9</span>
                                        </div>
                                    </div>
                                </div>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-label-sm font-label-sm font-bold bg-[#0F2438]/15 text-[#0F2438] uppercase tracking-wider">
                                    Internal
                                </span>
                            </div>
                            <!-- Telemetry Spec Cluster -->
                            <div class="grid grid-cols-4 gap-2 my-space-md p-2.5 rounded-lg bg-[#E3ECFF]">
                                <div class="flex flex-col">
                                    <span class="font-label-sm text-label-sm text-[#5C7290] uppercase">Units</span>
                                    <span class="font-label-lg text-label-lg font-bold font-mono text-[#0F2438]">340 docs</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-label-sm text-label-sm text-[#5C7290] uppercase">Mime</span>
                                    <span class="font-label-lg text-label-lg font-bold font-mono text-[#0F2438]">PDF/OCR</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-label-sm text-label-sm text-[#5C7290] uppercase">Size</span>
                                    <span class="font-label-lg text-label-lg font-bold font-mono text-[#0F2438]">145 MB</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-label-sm text-label-sm text-[#5C7290] uppercase">Status</span>
                                    <span class="font-label-lg text-label-lg font-bold text-[#0F2438]">Staged</span>
                                </div>
                            </div>
                            <!-- Record Sample Stream -->
                            <div class="flex flex-col gap-1.5 mb-space-md">
                                <span class="font-label-sm text-label-sm text-[#5C7290] uppercase tracking-wider">Corpus Metadata</span>
                                <div class="bg-[#E3ECFF] rounded-lg p-2 font-mono text-[11px] leading-relaxed text-[#1B3A5C] flex flex-col gap-1">
                                    <div class="truncate flex items-center justify-between">
                                        <span class="font-bold text-[#0F2438]">SLA-2023-VOS.pdf</span>
                                        <span class="text-[#5C7290]">Embedded OCR 98.4%</span>
                                    </div>
                                    <div class="truncate flex items-center justify-between">
                                        <span class="font-bold text-[#0F2438]">NDAS-2024-SYS.pdf</span>
                                        <span class="text-[#5C7290]">Scanned Bitonal</span>
                                    </div>
                                    <div class="truncate flex items-center justify-between">
                                        <span class="font-bold text-[#0F2438]">VENDOR-TECH-04.pdf</span>
                                        <span class="text-[#2E9E6B] font-semibold text-[10px]">PARSED</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Action Card Footer -->
                        <div class="pt-space-xs flex items-center justify-between">
                            <div class="flex items-center gap-1.5">
                                <span class="h-2 w-2 rounded-full bg-[#E8A33D]"></span>
                                <span class="font-label-sm text-label-sm text-[#1B3A5C] uppercase tracking-wider font-semibold">OCR Pending</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <button class="w-8 h-8 rounded bg-[#0F2438] text-tertiary flex items-center justify-center hover:opacity-90 transition-opacity" title="Inspect Lineage">
                                    <span class="material-symbols-outlined text-[16px]">account_tree</span>
                                </button>
                                <button class="w-8 h-8 rounded bg-[#0F2438] text-[#E3ECFF] flex items-center justify-center hover:opacity-90 transition-opacity" title="Corpus Browser">
                                    <span class="material-symbols-outlined text-[16px]">folder_open</span>
                                </button>
                                <button class="px-space-sm h-8 rounded bg-[#0F2438] text-white font-label-lg text-label-lg font-semibold hover:bg-[#1B3A5C] transition-colors flex items-center gap-1">
                                    <span>Inspect</span>
                                    <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                                </button>
                            </div>
                        </div>
                    </article>
                    <!-- Visual Telemetry & Archival Storage Summary Bento Card -->
                    <article class="bg-surface-container-high rounded-xl p-space-md shadow-md flex flex-col justify-between">
                        <div class="flex flex-col gap-space-sm">
                            <div class="flex items-center justify-between">
                                <span class="font-label-sm text-label-sm text-outline uppercase tracking-wider">Storage Partition Distribution</span>
                                <span class="font-label-sm text-label-sm text-tertiary font-mono">POOL 02-B</span>
                            </div>
                            <div class="flex items-center gap-space-md py-space-xs">
                                <!-- Inline Sparkline / Donut Gauge Minimal SVG -->
                                <svg class="w-20 h-20 -rotate-90 flex-shrink-0" viewbox="0 0 36 36">
                                    <path class="text-surface-container-lowest" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="3.5"></path>
                                    <path class="text-primary" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-dasharray="65, 100" stroke-width="3.5"></path>
                                    <path class="text-tertiary" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-dasharray="20, 100" stroke-dashoffset="-65" stroke-width="3.5"></path>
                                </svg>
                                <div class="flex flex-col gap-1 flex-1">
                                    <div class="flex justify-between items-center text-body-sm font-body-sm">
                                        <span class="flex items-center gap-1.5 text-on-surface-variant">
                                            <span class="w-2 h-2 rounded-full bg-primary"></span>
                                            Structured CSV/Parquet
                                        </span>
                                        <span class="font-mono text-on-surface font-semibold">65%</span>
                                    </div>
                                    <div class="flex justify-between items-center text-body-sm font-body-sm">
                                        <span class="flex items-center gap-1.5 text-on-surface-variant">
                                            <span class="w-2 h-2 rounded-full bg-tertiary"></span>
                                            Unstructured Documents
                                        </span>
                                        <span class="font-mono text-on-surface font-semibold">20%</span>
                                    </div>
                                    <div class="flex justify-between items-center text-body-sm font-body-sm">
                                        <span class="flex items-center gap-1.5 text-on-surface-variant">
                                            <span class="w-2 h-2 rounded-full bg-surface-container-lowest"></span>
                                            Unallocated Vault
                                        </span>
                                        <span class="font-mono text-outline font-semibold">15%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="p-2.5 rounded-lg bg-surface-container-lowest flex items-center justify-between text-body-sm font-body-sm">
                                <span class="text-on-surface-variant">Next Catalog Auto-Sync:</span>
                                <span class="font-mono text-primary font-semibold">00:46:12 UTC</span>
                            </div>
                        </div>
                        <div class="pt-space-md flex items-center justify-between">
                            <span class="font-label-sm text-label-sm text-outline">STORAGE CLUSTER: EMEA-VOSTOK-01</span>
                            <button class="px-space-sm h-8 rounded bg-surface-container hover:bg-surface-bright text-primary font-label-lg text-label-lg transition-colors flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px]">speed</span>
                                <span>Health Telemetry</span>
                            </button>
                        </div>
                    </article>
                </section>
                <!-- MATRIX TABLE VIEW CONTAINER (Hidden by default, switched via controls) -->
                <section class="hidden bg-surface-container-low rounded-xl overflow-hidden shadow-lg transition-all" id="tableContainer">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-body-sm font-body-sm">
                            <thead class="bg-surface-container-high text-outline uppercase font-label-sm text-label-sm tracking-wider">
                                <tr>
                                    <th class="py-3 px-space-md">Dataset Identifier</th>
                                    <th class="py-3 px-space-md">Subsystem</th>
                                    <th class="py-3 px-space-md">Classification</th>
                                    <th class="py-3 px-space-md font-mono">Volume / Shape</th>
                                    <th class="py-3 px-space-md font-mono">Storage Size</th>
                                    <th class="py-3 px-space-md">Version</th>
                                    <th class="py-3 px-space-md">Last Ingestion</th>
                                    <th class="py-3 px-space-md text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-surface-container-high/40 text-on-surface">
                                <!-- Row 1 -->
                                <tr class="hover:bg-surface-container-high/50 transition-colors">
                                    <td class="py-3.5 px-space-md">
                                        <div class="flex items-center gap-2">
                                            <span class="font-mono text-xs px-1.5 py-0.5 rounded bg-surface-container text-tertiary font-bold">CSV</span>
                                            <span class="font-semibold text-primary">customers.csv</span>
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-space-md text-on-surface-variant font-mono">SYS05 CRM</td>
                                    <td class="py-3.5 px-space-md">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-[#E8A33D]/20 text-tertiary uppercase">Confidential</span>
                                    </td>
                                    <td class="py-3.5 px-space-md font-mono text-on-surface">10,480r × 18c</td>
                                    <td class="py-3.5 px-space-md font-mono text-on-surface-variant">4.2 MB</td>
                                    <td class="py-3.5 px-space-md font-mono">v2.1</td>
                                    <td class="py-3.5 px-space-md text-on-surface-variant">14m ago</td>
                                    <td class="py-3.5 px-space-md text-right">
                                        <div class="inline-flex items-center gap-1">
                                            <button class="px-2 py-1 rounded bg-surface-container hover:bg-surface-bright text-xs text-primary font-semibold">Preview</button>
                                            <button class="px-2 py-1 rounded bg-surface-container hover:bg-surface-bright text-xs text-on-surface">Query</button>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Row 2 -->
                                <tr class="hover:bg-surface-container-high/50 transition-colors">
                                    <td class="py-3.5 px-space-md">
                                        <div class="flex items-center gap-2">
                                            <span class="font-mono text-xs px-1.5 py-0.5 rounded bg-surface-container text-tertiary font-bold">CSV</span>
                                            <span class="font-semibold text-primary">transactions.csv</span>
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-space-md text-on-surface-variant font-mono">SYS07 Finance</td>
                                    <td class="py-3.5 px-space-md">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-[#E8A33D]/20 text-tertiary uppercase">Confidential</span>
                                    </td>
                                    <td class="py-3.5 px-space-md font-mono text-on-surface">84,200r × 12c</td>
                                    <td class="py-3.5 px-space-md font-mono text-on-surface-variant">18.6 MB</td>
                                    <td class="py-3.5 px-space-md font-mono">v1.4</td>
                                    <td class="py-3.5 px-space-md text-on-surface-variant">2h ago</td>
                                    <td class="py-3.5 px-space-md text-right">
                                        <div class="inline-flex items-center gap-1">
                                            <button class="px-2 py-1 rounded bg-surface-container hover:bg-surface-bright text-xs text-primary font-semibold">Preview</button>
                                            <button class="px-2 py-1 rounded bg-surface-container hover:bg-surface-bright text-xs text-on-surface">Query</button>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Row 3 -->
                                <tr class="hover:bg-surface-container-high/50 transition-colors">
                                    <td class="py-3.5 px-space-md">
                                        <div class="flex items-center gap-2">
                                            <span class="font-mono text-xs px-1.5 py-0.5 rounded bg-surface-container text-tertiary font-bold">CSV</span>
                                            <span class="font-semibold text-primary">support_tickets.csv</span>
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-space-md text-on-surface-variant font-mono">SYS08 IT Helpdesk</td>
                                    <td class="py-3.5 px-space-md">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-surface-container-high text-on-surface uppercase">Internal</span>
                                    </td>
                                    <td class="py-3.5 px-space-md font-mono text-on-surface">5,612r × 14c</td>
                                    <td class="py-3.5 px-space-md font-mono text-on-surface-variant">2.1 MB</td>
                                    <td class="py-3.5 px-space-md font-mono">v1.0</td>
                                    <td class="py-3.5 px-space-md text-on-surface-variant">Yesterday</td>
                                    <td class="py-3.5 px-space-md text-right">
                                        <div class="inline-flex items-center gap-1">
                                            <button class="px-2 py-1 rounded bg-surface-container hover:bg-surface-bright text-xs text-primary font-semibold">Preview</button>
                                            <button class="px-2 py-1 rounded bg-surface-container hover:bg-surface-bright text-xs text-on-surface">Query</button>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Row 4 (Restricted) -->
                                <tr class="bg-error-container/10 hover:bg-error-container/20 transition-colors">
                                    <td class="py-3.5 px-space-md">
                                        <div class="flex items-center gap-2">
                                            <span class="font-mono text-xs px-1.5 py-0.5 rounded bg-surface-container text-error font-bold">PARQ</span>
                                            <span class="font-semibold text-on-surface">employee_evaluations.parquet</span>
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-space-md text-on-surface-variant font-mono">SYS06 HR</td>
                                    <td class="py-3.5 px-space-md">
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[11px] font-bold bg-error-container text-on-error-container uppercase">
                                            <span class="material-symbols-outlined text-[12px]">lock</span>
                                            Top Secret
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-space-md font-mono text-on-surface">1,240r × 22c</td>
                                    <td class="py-3.5 px-space-md font-mono text-on-surface-variant">840 KB</td>
                                    <td class="py-3.5 px-space-md font-mono">v1.0</td>
                                    <td class="py-3.5 px-space-md text-on-surface-variant">3d ago</td>
                                    <td class="py-3.5 px-space-md text-right">
                                        <button class="px-2 py-1 rounded bg-surface-container-high hover:bg-surface-bright text-xs text-error font-semibold flex items-center gap-1 ml-auto">
                                            <span class="material-symbols-outlined text-[14px]">lock_clock</span>
                                            <span>Req L3</span>
                                        </button>
                                    </td>
                                </tr>
                                <!-- Row 5 -->
                                <tr class="hover:bg-surface-container-high/50 transition-colors">
                                    <td class="py-3.5 px-space-md">
                                        <div class="flex items-center gap-2">
                                            <span class="font-mono text-xs px-1.5 py-0.5 rounded bg-surface-container text-tertiary font-bold">ZIP</span>
                                            <span class="font-semibold text-primary">unstructured_contracts.zip</span>
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-space-md text-on-surface-variant font-mono">SYS09 File Center</td>
                                    <td class="py-3.5 px-space-md">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-surface-container-high text-on-surface uppercase">Internal</span>
                                    </td>
                                    <td class="py-3.5 px-space-md font-mono text-on-surface">340 documents</td>
                                    <td class="py-3.5 px-space-md font-mono text-on-surface-variant">145 MB</td>
                                    <td class="py-3.5 px-space-md font-mono">v0.9</td>
                                    <td class="py-3.5 px-space-md text-on-surface-variant">4d ago</td>
                                    <td class="py-3.5 px-space-md text-right">
                                        <div class="inline-flex items-center gap-1">
                                            <button class="px-2 py-1 rounded bg-surface-container hover:bg-surface-bright text-xs text-primary font-semibold">Inspect</button>
                                            <button class="px-2 py-1 rounded bg-surface-container hover:bg-surface-bright text-xs text-on-surface">Unpack</button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>
                <!-- Industrial Pagination & Status Bar -->
                <footer class="bg-surface-container-low rounded-xl px-space-md py-space-sm shadow-md flex flex-col sm:flex-row items-center justify-between gap-space-sm text-body-sm font-body-sm">
                    <div class="flex items-center gap-space-sm">
                        <span class="font-label-sm text-label-sm text-outline uppercase tracking-wider">Displaying:</span>
                        <span class="font-mono font-semibold text-on-surface">Showing 1-5 of 28 items</span>
                        <span class="text-outline font-mono text-[10px] hidden md:inline">•</span>
                        <span class="text-on-surface-variant hidden md:inline">Storage Node Cluster A-09 Synced</span>
                    </div>
                    <div class="flex items-center gap-space-xs">
                        <button class="px-space-sm py-1 rounded bg-surface-container text-outline hover:text-on-surface hover:bg-surface-container-high transition-colors font-label-sm text-label-sm uppercase font-mono disabled:opacity-50" disabled="">
                            Prev
                        </button>
                        <div class="flex items-center gap-1 font-mono text-xs">
                            <button class="w-7 h-7 rounded bg-primary text-on-primary font-bold">1</button>
                            <button class="w-7 h-7 rounded bg-surface-container-high text-on-surface hover:bg-surface-bright transition-colors">2</button>
                            <button class="w-7 h-7 rounded bg-surface-container-high text-on-surface hover:bg-surface-bright transition-colors">3</button>
                            <span class="px-1 text-outline">...</span>
                            <button class="w-7 h-7 rounded bg-surface-container-high text-on-surface hover:bg-surface-bright transition-colors">6</button>
                        </div>
                        <button class="px-space-sm py-1 rounded bg-surface-container text-on-surface hover:bg-surface-container-high transition-colors font-label-sm text-label-sm uppercase font-mono">
                            Next
                        </button>
                    </div>
                </footer>
            </div>
            <!-- Client-side UI toggles and filter reactivity -->
            <script>
                (function initDatasetCatalog() {
                    const bentoBtn = document.getElementById('viewToggleBento');
                    const tableBtn = document.getElementById('viewToggleTable');
                    const bentoContainer = document.getElementById('bentoContainer');
                    const tableContainer = document.getElementById('tableContainer');
                    const pillGroup = document.getElementById('filterPillGroup');

                    if (bentoBtn && tableBtn && bentoContainer && tableContainer) {
                        bentoBtn.addEventListener('click', () => {
                            bentoContainer.classList.remove('hidden');
                            tableContainer.classList.add('hidden');
                            bentoBtn.className = 'px-space-sm py-1 rounded text-label-sm font-label-sm flex items-center gap-1 bg-surface-container-high text-on-surface shadow-sm font-semibold transition-all';
                            tableBtn.className = 'px-space-sm py-1 rounded text-label-sm font-label-sm flex items-center gap-1 text-on-surface-variant hover:text-on-surface transition-all';
                        });

                        tableBtn.addEventListener('click', () => {
                            bentoContainer.classList.add('hidden');
                            tableContainer.classList.remove('hidden');
                            tableBtn.className = 'px-space-sm py-1 rounded text-label-sm font-label-sm flex items-center gap-1 bg-surface-container-high text-on-surface shadow-sm font-semibold transition-all';
                            bentoBtn.className = 'px-space-sm py-1 rounded text-label-sm font-label-sm flex items-center gap-1 text-on-surface-variant hover:text-on-surface transition-all';
                        });
                    }

                    if (pillGroup) {
                        pillGroup.addEventListener('click', (e) => {
                            const btn = e.target.closest('.filter-pill');
                            if (!btn) return;
                            pillGroup.querySelectorAll('.filter-pill').forEach(p => {
                                p.className = 'filter-pill px-space-sm py-1 rounded font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant hover:text-on-surface hover:bg-surface-container transition-colors';
                            });
                            btn.className = 'filter-pill px-space-sm py-1 rounded font-label-sm text-label-sm uppercase tracking-wider bg-primary-container text-primary font-bold shadow-sm transition-colors';
                        });
                    }
                })();
            </script>
        </main>
    </div>
</body>

</html>