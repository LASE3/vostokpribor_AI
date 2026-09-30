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
            <div class="flex flex-col w-full relative">
                <!-- Backdrop Context: SYS-AI-02 Data Center Catalog View (Dimmed/Blurred Operational Ground) -->
                <div aria-hidden="true" class="w-full filter blur-[2px] opacity-25 pointer-events-none select-none -mt-4 space-y-space-md">
                    <div class="grid grid-cols-12 gap-space-md">
                        <div class="col-span-8 bg-surface-container-low p-space-lg rounded-lg shadow-sm">
                            <div class="flex items-center justify-between mb-space-md">
                                <div class="h-6 w-48 bg-surface-container-highest rounded"></div>
                                <div class="h-6 w-24 bg-surface-container rounded-full"></div>
                            </div>
                            <div class="space-y-space-sm">
                                <div class="h-10 w-full bg-surface-container-high rounded"></div>
                                <div class="h-10 w-full bg-surface-container-high rounded"></div>
                                <div class="h-10 w-full bg-surface-container-high rounded"></div>
                                <div class="h-10 w-full bg-surface-container-high rounded"></div>
                            </div>
                        </div>
                        <div class="col-span-4 bg-surface-container-low p-space-lg rounded-lg shadow-sm space-y-space-md">
                            <div class="h-6 w-32 bg-surface-container-highest rounded"></div>
                            <div class="h-32 w-full bg-surface-container rounded"></div>
                            <div class="h-12 w-full bg-surface-container-high rounded"></div>
                        </div>
                    </div>
                </div>
                <!-- Primary Industrial Modal Gateway Overlay -->
                <div class="absolute inset-x-0 top-0 z-20 flex justify-center items-start pb-space-2xl">
                    <div class="w-full max-w-5xl bg-surface-container-lowest rounded-xl shadow-2xl overflow-hidden flex flex-col">
                        <!-- Top Status Anchor Line & Metadata Ribbon -->
                        <div class="w-full bg-surface-container-low px-space-lg py-space-sm flex flex-wrap items-center justify-between gap-space-sm">
                            <div class="flex items-center gap-space-sm font-label-sm text-label-sm">
                                <span class="px-space-xs py-0.5 rounded bg-surface-container-highest text-primary font-mono tracking-widest">GATEWAY ACTIVE</span>
                                <span class="text-outline">SYS-AI-02 // EXTRACT-PROTOCOL-V4.2</span>
                                <span class="text-outline">|</span>
                                <span class="text-on-surface-variant font-mono">NODE: VP-EDG-DATACENTER-07</span>
                            </div>
                            <div class="flex items-center gap-space-sm">
                                <div class="flex items-center gap-space-2xs bg-surface-container px-space-sm py-0.5 rounded text-tertiary font-label-sm text-label-sm">
                                    <span class="h-1.5 w-1.5 rounded-full bg-tertiary animate-pulse"></span>
                                    <span>AIR-GAP COMPLIANCE ENGAGED</span>
                                </div>
                                <span class="text-outline font-label-sm text-label-sm font-mono">ENCRYPT: TLS 1.3 / AES-256-GCM</span>
                            </div>
                        </div>
                        <!-- Modal Main Header Frame -->
                        <div class="bg-surface-container px-space-lg py-space-md flex items-start justify-between">
                            <div class="space-y-space-xs">
                                <div class="flex items-center gap-space-xs font-label-sm text-label-sm text-outline uppercase tracking-widest">
                                    <span class="material-symbols-outlined text-[15px] text-tertiary">database</span>
                                    <span>SYS-AI-02 DATA CENTER</span>
                                    <span>//</span>
                                    <span class="text-primary font-semibold">EXPORT DISPATCH GATEWAY</span>
                                </div>
                                <h1 class="font-headline-lg text-headline-lg text-on-surface tracking-tight">Export &amp; Secure Download Dispatch</h1>
                                <div class="flex flex-wrap items-center gap-space-sm pt-space-2xs">
                                    <div class="flex items-center gap-space-xs bg-surface-container-high px-space-sm py-1 rounded">
                                        <span class="material-symbols-outlined text-[16px] text-primary">description</span>
                                        <span class="font-label-md text-label-md text-on-surface font-mono font-semibold">customers.csv (v2.1 STABLE)</span>
                                    </div>
                                    <div class="flex items-center gap-space-2xs bg-surface-container-high px-space-sm py-1 rounded font-label-sm text-label-sm text-on-surface-variant font-mono">
                                        <span class="text-outline">SHA-256:</span>
                                        <span class="text-primary">4f8a2b7e9102c98...</span>
                                    </div>
                                    <div class="flex items-center gap-space-xs px-space-sm py-1 rounded bg-secondary-container text-on-secondary-container font-label-sm text-label-sm font-semibold">
                                        <span class="h-1.5 w-1.5 rounded-full bg-secondary"></span>
                                        <span>#AI-024 Customer Churn</span>
                                    </div>
                                    <div class="flex items-center gap-space-xs px-space-sm py-1 rounded bg-tertiary-container text-tertiary font-label-sm text-label-sm font-semibold">
                                        <span class="material-symbols-outlined text-[14px]">verified_user</span>
                                        <span>CONFIDENTIAL // LEVEL 2 CLEARANCE VERIFIED</span>
                                    </div>
                                </div>
                            </div>
                            <button aria-label="Close Gateway" class="w-9 h-9 rounded-lg bg-surface-container-high text-on-surface-variant hover:text-tertiary hover:bg-surface-variant transition-colors flex items-center justify-center">
                                <span class="material-symbols-outlined text-[20px]">close</span>
                            </button>
                        </div>
                        <!-- Dialog Interactive Flow Body -->
                        <div class="p-space-lg space-y-space-xl bg-surface overflow-y-auto max-h-[calc(100vh-230px)]">
                            <!-- STEP 1: Format & Compression Engine -->
                            <section class="space-y-space-sm">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-space-xs">
                                        <span class="w-5 h-5 rounded-full bg-tertiary text-on-tertiary flex items-center justify-center font-label-sm text-label-sm font-bold font-mono">01</span>
                                        <h2 class="font-headline-sm text-headline-sm text-on-surface uppercase tracking-wide">Target Format &amp; Compression Engine</h2>
                                    </div>
                                    <span class="font-label-sm text-label-sm text-outline uppercase tracking-wider font-mono">ENGINEERING ENCODING</span>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-space-md">
                                    <!-- Format A: Parquet (Active/Selected) -->
                                    <label class="relative flex flex-col p-space-md rounded-lg bg-surface-container-high cursor-pointer shadow-md hover:bg-surface-variant transition-all">
                                        <input checked="" class="sr-only peer" name="format_engine" type="radio" value="parquet" />
                                        <div class="flex items-start justify-between mb-space-sm">
                                            <div class="flex items-center gap-space-xs">
                                                <span class="material-symbols-outlined text-[20px] text-tertiary">data_array</span>
                                                <span class="font-label-lg text-label-lg font-bold text-on-surface">Apache Parquet</span>
                                            </div>
                                            <div class="w-4 h-4 rounded-full bg-tertiary flex items-center justify-center peer-checked:flex">
                                                <span class="w-2 h-2 rounded-full bg-surface-container-lowest"></span>
                                            </div>
                                        </div>
                                        <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed mb-space-md flex-1">
                                            Recommended for analytics &amp; ML pipelines. Columnar storage, snappy compression, vectorized dictionary encoding.
                                        </p>
                                        <div class="bg-surface-container-lowest p-space-xs rounded flex items-center justify-between font-label-sm text-label-sm font-mono">
                                            <span class="text-outline">Est. Output Size:</span>
                                            <span class="text-tertiary font-bold">1.12 MB (-73%)</span>
                                        </div>
                                    </label>
                                    <!-- Format B: CSV -->
                                    <label class="relative flex flex-col p-space-md rounded-lg bg-surface-container-low cursor-pointer hover:bg-surface-container-high transition-all">
                                        <input class="sr-only peer" name="format_engine" type="radio" value="csv" />
                                        <div class="flex items-start justify-between mb-space-sm">
                                            <div class="flex items-center gap-space-xs">
                                                <span class="material-symbols-outlined text-[20px] text-primary">table_view</span>
                                                <span class="font-label-lg text-label-lg font-bold text-on-surface">Delimited (.csv)</span>
                                            </div>
                                            <div class="w-4 h-4 rounded-full bg-surface-container-highest"></div>
                                        </div>
                                        <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed mb-space-md flex-1">
                                            Standard RFC-4180 representation. UTF-8 encoded with canonical header row. Optional on-the-fly Gzip compression stream.
                                        </p>
                                        <div class="bg-surface-container-lowest p-space-xs rounded flex items-center justify-between font-label-sm text-label-sm font-mono">
                                            <span class="text-outline">Est. Output Size:</span>
                                            <span class="text-on-surface font-semibold">4.20 MB (Raw)</span>
                                        </div>
                                    </label>
                                    <!-- Format C: DuckDB Native -->
                                    <label class="relative flex flex-col p-space-md rounded-lg bg-surface-container-low cursor-pointer hover:bg-surface-container-high transition-all">
                                        <input class="sr-only peer" name="format_engine" type="radio" value="duckdb" />
                                        <div class="flex items-start justify-between mb-space-sm">
                                            <div class="flex items-center gap-space-xs">
                                                <span class="material-symbols-outlined text-[20px] text-secondary">memory</span>
                                                <span class="font-label-lg text-label-lg font-bold text-on-surface">DuckDB Native</span>
                                            </div>
                                            <div class="w-4 h-4 rounded-full bg-surface-container-highest"></div>
                                        </div>
                                        <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed mb-space-md flex-1">
                                            Zero-copy embedded OLAP snapshot ready for immediate Python, R, or DuckDB CLI execution without extraction overhead.
                                        </p>
                                        <div class="bg-surface-container-lowest p-space-xs rounded flex items-center justify-between font-label-sm text-label-sm font-mono">
                                            <span class="text-outline">Est. Output Size:</span>
                                            <span class="text-on-surface font-semibold">1.45 MB</span>
                                        </div>
                                    </label>
                                    <!-- Format D: JSON Lines -->
                                    <label class="relative flex flex-col p-space-md rounded-lg bg-surface-container-low cursor-pointer hover:bg-surface-container-high transition-all">
                                        <input class="sr-only peer" name="format_engine" type="radio" value="jsonl" />
                                        <div class="flex items-start justify-between mb-space-sm">
                                            <div class="flex items-center gap-space-xs">
                                                <span class="material-symbols-outlined text-[20px] text-primary">code</span>
                                                <span class="font-label-lg text-label-lg font-bold text-on-surface">JSON Lines (.jsonl)</span>
                                            </div>
                                            <div class="w-4 h-4 rounded-full bg-surface-container-highest"></div>
                                        </div>
                                        <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed mb-space-md flex-1">
                                            Line-delimited, schema-validated document streams optimized for distributed queues, microservices, and log collectors.
                                        </p>
                                        <div class="bg-surface-container-lowest p-space-xs rounded flex items-center justify-between font-label-sm text-label-sm font-mono">
                                            <span class="text-outline">Est. Output Size:</span>
                                            <span class="text-on-surface font-semibold">5.80 MB</span>
                                        </div>
                                    </label>
                                </div>
                            </section>
                            <!-- STEP 2: Attribute & Column Projection Filter -->
                            <section class="space-y-space-sm">
                                <div class="flex flex-col md:flex-row md:items-center justify-between gap-space-sm">
                                    <div class="flex items-center gap-space-xs">
                                        <span class="w-5 h-5 rounded-full bg-tertiary text-on-tertiary flex items-center justify-center font-label-sm text-label-sm font-bold font-mono">02</span>
                                        <h2 class="font-headline-sm text-headline-sm text-on-surface uppercase tracking-wide">Attribute &amp; Column Projection Filter</h2>
                                        <span class="text-outline-variant">·</span>
                                        <span class="font-label-sm text-label-sm text-on-surface-variant font-mono">11 of 12 ACTIVE FIELDS PROJECTED</span>
                                    </div>
                                    <!-- Preset Quick Filters -->
                                    <div class="flex items-center gap-space-xs">
                                        <button class="px-space-sm py-1 rounded bg-surface-container hover:bg-surface-container-high text-on-surface-variant hover:text-on-surface font-label-sm text-label-sm transition-colors" type="button">Select All (18)</button>
                                        <button class="px-space-sm py-1 rounded bg-secondary-container text-on-secondary font-label-sm text-label-sm font-semibold transition-colors" type="button">Feature Store Subset (12)</button>
                                        <button class="px-space-sm py-1 rounded bg-surface-container hover:bg-surface-container-high text-tertiary font-label-sm text-label-sm transition-colors flex items-center gap-1" type="button">
                                            <span class="material-symbols-outlined text-[14px]">lock_reset</span>
                                            <span>Exclude PII / Masked</span>
                                        </button>
                                    </div>
                                </div>
                                <!-- Grouped Attribute Matrix -->
                                <div class="bg-surface-container-low rounded-lg p-space-md space-y-space-md">
                                    <!-- Category 1: Identifiers -->
                                    <div class="space-y-space-2xs">
                                        <div class="flex items-center gap-space-xs">
                                            <span class="font-label-sm text-label-sm text-primary uppercase font-mono tracking-wider">Identifiers</span>
                                            <span class="text-outline text-[11px] font-mono">· Schema Partition 0x01</span>
                                        </div>
                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-space-xs">
                                            <!-- Locked Column: cus_id -->
                                            <div class="flex items-center justify-between px-space-sm py-2 rounded bg-surface-container-lowest text-on-surface">
                                                <div class="flex items-center gap-space-xs min-w-0">
                                                    <span class="material-symbols-outlined text-[16px] text-tertiary">lock</span>
                                                    <span class="font-label-md text-label-md font-mono truncate">cus_id</span>
                                                </div>
                                                <span class="font-label-sm text-label-sm text-outline font-mono px-1 rounded bg-surface-container">PK [LOCK]</span>
                                            </div>
                                            <!-- company_name -->
                                            <label class="flex items-center justify-between px-space-sm py-2 rounded bg-surface-container-high text-on-surface cursor-pointer hover:bg-surface-variant transition-colors">
                                                <div class="flex items-center gap-space-xs min-w-0">
                                                    <span class="material-symbols-outlined text-[16px] text-tertiary">check_box</span>
                                                    <span class="font-label-md text-label-md font-mono truncate">company_name</span>
                                                </div>
                                                <span class="font-label-sm text-label-sm text-outline font-mono">STRING</span>
                                            </label>
                                        </div>
                                    </div>
                                    <!-- Category 2: Categorical Features -->
                                    <div class="space-y-space-2xs">
                                        <div class="flex items-center gap-space-xs">
                                            <span class="font-label-sm text-label-sm text-primary uppercase font-mono tracking-wider">Categorical Features</span>
                                            <span class="text-outline text-[11px] font-mono">· Model Inputs [Vector Group A]</span>
                                        </div>
                                        <div class="grid grid-cols-2 md:grid-cols-3 gap-space-xs">
                                            <label class="flex items-center justify-between px-space-sm py-2 rounded bg-surface-container-high text-on-surface cursor-pointer hover:bg-surface-variant transition-colors">
                                                <div class="flex items-center gap-space-xs min-w-0">
                                                    <span class="material-symbols-outlined text-[16px] text-tertiary">check_box</span>
                                                    <span class="font-label-md text-label-md font-mono truncate">industry_sector</span>
                                                </div>
                                                <span class="font-label-sm text-label-sm text-outline font-mono">CAT</span>
                                            </label>
                                            <label class="flex items-center justify-between px-space-sm py-2 rounded bg-surface-container-high text-on-surface cursor-pointer hover:bg-surface-variant transition-colors">
                                                <div class="flex items-center gap-space-xs min-w-0">
                                                    <span class="material-symbols-outlined text-[16px] text-tertiary">check_box</span>
                                                    <span class="font-label-md text-label-md font-mono truncate">service_tier</span>
                                                </div>
                                                <span class="font-label-sm text-label-sm text-outline font-mono">ORD</span>
                                            </label>
                                            <label class="flex items-center justify-between px-space-sm py-2 rounded bg-surface-container-high text-on-surface cursor-pointer hover:bg-surface-variant transition-colors">
                                                <div class="flex items-center gap-space-xs min-w-0">
                                                    <span class="material-symbols-outlined text-[16px] text-tertiary">check_box</span>
                                                    <span class="font-label-md text-label-md font-mono truncate">contract_signed_date</span>
                                                </div>
                                                <span class="font-label-sm text-label-sm text-outline font-mono">DATE</span>
                                            </label>
                                        </div>
                                    </div>
                                    <!-- Category 3: Financial & Usage Metrics -->
                                    <div class="space-y-space-2xs">
                                        <div class="flex items-center gap-space-xs">
                                            <span class="font-label-sm text-label-sm text-primary uppercase font-mono tracking-wider">Financial &amp; Telemetry Quantiles</span>
                                            <span class="text-outline text-[11px] font-mono">· Scaled Continuous Feats</span>
                                        </div>
                                        <div class="grid grid-cols-2 md:grid-cols-3 gap-space-xs">
                                            <label class="flex items-center justify-between px-space-sm py-2 rounded bg-surface-container-high text-on-surface cursor-pointer hover:bg-surface-variant transition-colors">
                                                <div class="flex items-center gap-space-xs min-w-0">
                                                    <span class="material-symbols-outlined text-[16px] text-tertiary">check_box</span>
                                                    <span class="font-label-md text-label-md font-mono truncate">monthly_spend_eur</span>
                                                </div>
                                                <span class="font-label-sm text-label-sm text-outline font-mono">FLOAT64</span>
                                            </label>
                                            <label class="flex items-center justify-between px-space-sm py-2 rounded bg-surface-container-high text-on-surface cursor-pointer hover:bg-surface-variant transition-colors">
                                                <div class="flex items-center gap-space-xs min-w-0">
                                                    <span class="material-symbols-outlined text-[16px] text-tertiary">check_box</span>
                                                    <span class="font-label-md text-label-md font-mono truncate">average_invoice_val</span>
                                                </div>
                                                <span class="font-label-sm text-label-sm text-outline font-mono">FLOAT64</span>
                                            </label>
                                            <label class="flex items-center justify-between px-space-sm py-2 rounded bg-surface-container-high text-on-surface cursor-pointer hover:bg-surface-variant transition-colors">
                                                <div class="flex items-center gap-space-xs min-w-0">
                                                    <span class="material-symbols-outlined text-[16px] text-tertiary">check_box</span>
                                                    <span class="font-label-md text-label-md font-mono truncate">payment_delinquency</span>
                                                </div>
                                                <span class="font-label-sm text-label-sm text-outline font-mono">INT16</span>
                                            </label>
                                            <label class="flex items-center justify-between px-space-sm py-2 rounded bg-surface-container-high text-on-surface cursor-pointer hover:bg-surface-variant transition-colors">
                                                <div class="flex items-center gap-space-xs min-w-0">
                                                    <span class="material-symbols-outlined text-[16px] text-tertiary">check_box</span>
                                                    <span class="font-label-md text-label-md font-mono truncate">support_tickets_l90d</span>
                                                </div>
                                                <span class="font-label-sm text-label-sm text-outline font-mono">INT16</span>
                                            </label>
                                            <label class="flex items-center justify-between px-space-sm py-2 rounded bg-surface-container-high text-on-surface cursor-pointer hover:bg-surface-variant transition-colors">
                                                <div class="flex items-center gap-space-xs min-w-0">
                                                    <span class="material-symbols-outlined text-[16px] text-tertiary">check_box</span>
                                                    <span class="font-label-md text-label-md font-mono truncate">last_telemetry_ping</span>
                                                </div>
                                                <span class="font-label-sm text-label-sm text-outline font-mono">TS_UTC</span>
                                            </label>
                                            <label class="flex items-center justify-between px-space-sm py-2 rounded bg-surface-container-high text-on-surface cursor-pointer hover:bg-surface-variant transition-colors">
                                                <div class="flex items-center gap-space-xs min-w-0">
                                                    <span class="material-symbols-outlined text-[16px] text-tertiary">check_box</span>
                                                    <span class="font-label-md text-label-md font-mono truncate">platform_login_freq</span>
                                                </div>
                                                <span class="font-label-sm text-label-sm text-outline font-mono">FLOAT32</span>
                                            </label>
                                        </div>
                                    </div>
                                    <!-- Category 4: Ground Truth Target & Masked PII -->
                                    <div class="space-y-space-2xs">
                                        <div class="flex items-center gap-space-xs">
                                            <span class="font-label-sm text-label-sm text-primary uppercase font-mono tracking-wider">Supervised Target &amp; Masked Security Boundary</span>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-space-xs">
                                            <!-- Ground Truth Target -->
                                            <label class="flex items-center justify-between px-space-sm py-2 rounded bg-surface-container-high text-on-surface cursor-pointer hover:bg-surface-variant transition-colors">
                                                <div class="flex items-center gap-space-xs min-w-0">
                                                    <span class="material-symbols-outlined text-[16px] text-tertiary">check_box</span>
                                                    <span class="font-label-md text-label-md font-mono font-bold text-tertiary truncate">churn_label</span>
                                                </div>
                                                <span class="font-label-sm text-label-sm text-on-surface font-mono px-1 rounded bg-secondary-container">TARGET (BOOL)</span>
                                            </label>
                                            <!-- PII Masked Field -->
                                            <div class="flex items-center justify-between px-space-sm py-2 rounded bg-surface-container-lowest text-on-surface-variant">
                                                <div class="flex items-center gap-space-xs min-w-0">
                                                    <span class="material-symbols-outlined text-[16px] text-error">enhanced_encryption</span>
                                                    <span class="font-label-md text-label-md font-mono truncate">secondary_contact_email</span>
                                                </div>
                                                <span class="font-label-sm text-label-sm text-error font-mono px-1 rounded bg-error-container">SHA256 MASKED (LVL-2)</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <!-- STEP 3: Row Filter & Partitioning Scope -->
                            <section class="space-y-space-sm">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-space-xs">
                                        <span class="w-5 h-5 rounded-full bg-tertiary text-on-tertiary flex items-center justify-center font-label-sm text-label-sm font-bold font-mono">03</span>
                                        <h2 class="font-headline-sm text-headline-sm text-on-surface uppercase tracking-wide">Row Filter &amp; Partitioning Scope</h2>
                                    </div>
                                    <span class="font-label-sm text-label-sm text-outline uppercase tracking-wider font-mono">RECORD COUNT ALLOCATION</span>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-space-md">
                                    <label class="p-space-md rounded-lg bg-surface-container-high cursor-pointer hover:bg-surface-variant transition-colors flex flex-col justify-between">
                                        <div class="flex items-start justify-between">
                                            <div>
                                                <div class="font-label-lg text-label-lg font-bold text-on-surface">Full Dataset</div>
                                                <div class="font-body-sm text-body-sm text-on-surface-variant">All partitioned operational records</div>
                                            </div>
                                            <input class="mt-1" name="scope_selection" type="radio" />
                                        </div>
                                        <div class="mt-space-sm font-telemetry-num text-telemetry-num text-primary">10,480 <span class="font-label-sm text-label-sm text-outline">ROWS</span></div>
                                    </label>
                                    <label class="p-space-md rounded-lg bg-surface-container-highest cursor-pointer flex flex-col justify-between shadow-md">
                                        <div class="flex items-start justify-between">
                                            <div>
                                                <div class="flex items-center gap-space-2xs">
                                                    <span class="font-label-lg text-label-lg font-bold text-on-surface">Filtered Active Query</span>
                                                    <span class="h-2 w-2 rounded-full bg-tertiary"></span>
                                                </div>
                                                <div class="font-body-sm text-body-sm text-on-surface-variant">Active workbench session slice</div>
                                            </div>
                                            <input checked="" class="mt-1" name="scope_selection" type="radio" />
                                        </div>
                                        <div class="mt-space-sm font-telemetry-num text-telemetry-num text-tertiary">500 <span class="font-label-sm text-label-sm text-outline">ROWS (PREDICATE MATCH)</span></div>
                                    </label>
                                    <label class="p-space-md rounded-lg bg-surface-container-high cursor-pointer hover:bg-surface-variant transition-colors flex flex-col justify-between">
                                        <div class="flex items-start justify-between">
                                            <div>
                                                <div class="font-label-lg text-label-lg font-bold text-on-surface">Stratified 10% Sample</div>
                                                <div class="font-body-sm text-body-sm text-on-surface-variant">Class-balanced random partition</div>
                                            </div>
                                            <input class="mt-1" name="scope_selection" type="radio" />
                                        </div>
                                        <div class="mt-space-sm font-telemetry-num text-telemetry-num text-primary">1,048 <span class="font-label-sm text-label-sm text-outline">ROWS</span></div>
                                    </label>
                                </div>
                                <!-- Active Predicate Query Tape -->
                                <div class="bg-surface-container-lowest p-space-sm rounded-lg flex flex-wrap items-center justify-between gap-space-sm">
                                    <div class="flex items-center gap-space-xs font-mono text-body-sm overflow-x-auto">
                                        <span class="text-tertiary font-bold font-label-sm text-label-sm bg-tertiary-container px-space-xs py-0.5 rounded">SQL WHERE</span>
                                        <span class="text-on-surface">contract_signed_date &gt;= <span class="text-secondary">'2021-01-01'</span> AND status = <span class="text-secondary">'ACTIVE'</span></span>
                                    </div>
                                    <div class="flex items-center gap-space-2xs font-label-sm text-label-sm text-outline font-mono">
                                        <span class="material-symbols-outlined text-[14px]">tune</span>
                                        <span>Session: QRY-2024-0914-08</span>
                                    </div>
                                </div>
                            </section>
                            <!-- STEP 4: Mandatory Compliance, Audit Logging & Security Notice -->
                            <section class="space-y-space-sm">
                                <div class="flex items-center gap-space-xs">
                                    <span class="w-5 h-5 rounded-full bg-tertiary text-on-tertiary flex items-center justify-center font-label-sm text-label-sm font-bold font-mono">04</span>
                                    <h2 class="font-headline-sm text-headline-sm text-on-surface uppercase tracking-wide">Mandatory Governance &amp; Export Target</h2>
                                </div>
                                <!-- Industrial Security Callout Bento -->
                                <div class="p-space-lg rounded-xl bg-tertiary-container text-on-tertiary-container space-y-space-md shadow-inner">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-space-sm">
                                            <div class="w-8 h-8 rounded-lg bg-tertiary text-on-tertiary flex items-center justify-center">
                                                <span class="material-symbols-outlined text-[20px]">shield</span>
                                            </div>
                                            <div>
                                                <h3 class="font-label-lg text-label-lg font-bold uppercase tracking-widest text-tertiary">SECURE AUDIT LOG MANDATE · AIR-GAPPED EXPORT POLICY</h3>
                                                <p class="font-label-sm text-label-sm text-outline font-mono">VOSTOKPRIBOR DATA GOVERNANCE DIRECTIVE SEC-702 // ENFORCED</p>
                                            </div>
                                        </div>
                                        <span class="px-space-xs py-0.5 rounded bg-surface-container-lowest font-mono text-tertiary font-label-sm text-label-sm">STAMP: 2024-09-14T11:42:09Z</span>
                                    </div>
                                    <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">
                                        Notice: In accordance with <span class="text-tertiary font-semibold">VOSTOKPRIBOR Data Governance Policy SEC-702</span>, this extraction event is cryptographically recorded in the immutable WORM (Write Once, Read Many) telemetry ledger. Your operator clearance identity (<span class="text-on-surface font-mono">LVL-2: Intern AI Engineer #09412</span>), origin workstation hash, and binary checksum are anchored for 365 days.
                                    </p>
                                    <!-- Destination Selector Row -->
                                    <div class="pt-space-xs space-y-space-xs">
                                        <span class="font-label-sm text-label-sm text-tertiary uppercase tracking-wider font-mono">Destination Staging Target:</span>
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-space-sm">
                                            <label class="p-space-sm rounded bg-surface-container-lowest flex items-center gap-space-sm cursor-pointer hover:bg-surface-container transition-colors">
                                                <input checked="" class="text-tertiary focus:ring-0" name="export_dest" type="radio" />
                                                <div class="min-w-0">
                                                    <div class="font-label-md text-label-md text-on-surface font-semibold truncate">Local Workstation</div>
                                                    <div class="font-label-sm text-label-sm text-outline">Encrypted APFS/ext4 Mount</div>
                                                </div>
                                            </label>
                                            <label class="p-space-sm rounded bg-surface-container-lowest flex items-center gap-space-sm cursor-pointer hover:bg-surface-container transition-colors">
                                                <input class="text-tertiary focus:ring-0" name="export_dest" type="radio" />
                                                <div class="min-w-0">
                                                    <div class="font-label-md text-label-md text-on-surface font-semibold truncate">SYS-AI-03 Workbench</div>
                                                    <div class="font-label-sm text-label-sm text-outline">Direct JupyterLab scratchpad</div>
                                                </div>
                                            </label>
                                            <label class="p-space-sm rounded bg-surface-container-lowest flex items-center gap-space-sm cursor-pointer hover:bg-surface-container transition-colors">
                                                <input class="text-tertiary focus:ring-0" name="export_dest" type="radio" />
                                                <div class="min-w-0">
                                                    <div class="font-label-md text-label-md text-on-surface font-semibold truncate">Storage Bucket Ingest</div>
                                                    <div class="font-label-sm text-label-sm text-outline">S3 / MinIO pipeline stage</div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <!-- Mandatory Acceptance Checkbox -->
                                    <label class="flex items-start gap-space-sm p-space-sm rounded bg-surface-container-lowest cursor-pointer">
                                        <input checked="" class="mt-0.5 h-4 w-4 rounded bg-surface-container text-tertiary focus:ring-0" type="checkbox" />
                                        <span class="font-body-sm text-body-sm text-on-surface leading-tight">
                                            I hereby verify that this export is strictly authorized for model training and feature correlation on <strong class="text-tertiary">Ticket #AI-024 Customer Churn</strong> and will not be mirrored or exported to unapproved, non-compliant third-party boundaries.
                                        </span>
                                    </label>
                                </div>
                            </section>
                        </div>
                        <!-- Modal Footer & Real-Time Dispatch Actions -->
                        <div class="bg-surface-container-low px-space-lg py-space-md flex flex-col md:flex-row items-center justify-between gap-space-md">
                            <!-- Telemetry Summary Metrics -->
                            <div class="flex items-center gap-space-lg w-full md:w-auto">
                                <div class="space-y-0.5">
                                    <div class="font-label-sm text-label-sm text-outline uppercase font-mono">EST. PAYLOAD SIZE</div>
                                    <div class="font-label-lg text-label-lg font-bold text-on-surface font-mono">1.12 MB <span class="text-tertiary text-xs font-normal">(Parquet)</span></div>
                                </div>
                                <div class="space-y-0.5">
                                    <div class="font-label-sm text-label-sm text-outline uppercase font-mono">DISPATCH VELOCITY</div>
                                    <div class="font-label-lg text-label-lg font-bold text-primary font-mono">~45 MB/s <span class="text-outline text-xs font-normal">(Loopback)</span></div>
                                </div>
                                <div class="space-y-0.5 hidden lg:block">
                                    <div class="font-label-sm text-label-sm text-outline uppercase font-mono">WORM AUDIT TOKEN</div>
                                    <div class="font-label-lg text-label-lg text-on-surface-variant font-mono text-xs">LEDGER#EXP-9921-A</div>
                                </div>
                            </div>
                            <!-- Action Control Group -->
                            <div class="flex items-center gap-space-sm w-full md:w-auto justify-end">
                                <button class="px-space-md py-2 rounded bg-surface-container hover:bg-surface-container-high text-on-surface-variant hover:text-on-surface font-label-md text-label-md font-semibold transition-colors" type="button">
                                    Cancel &amp; Discard
                                </button>
                                <button class="px-space-md py-2 rounded bg-surface-container-highest hover:bg-surface-bright text-primary font-label-md text-label-md font-semibold transition-colors flex items-center gap-space-xs" type="button">
                                    <span class="material-symbols-outlined text-[16px]">terminal</span>
                                    <span>Copy cURL / CLI</span>
                                </button>
                                <button class="px-space-lg py-2 rounded bg-tertiary hover:bg-tertiary-fixed text-on-tertiary font-label-md text-label-md font-bold tracking-wide uppercase shadow-md transition-all flex items-center gap-space-xs" type="button">
                                    <span class="material-symbols-outlined text-[18px]">download</span>
                                    <span>Authorize &amp; Dispatch Download</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>