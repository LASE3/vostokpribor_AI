<!DOCTYPE html>
<html class="dark" lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="web_dashboard" name="shell-type">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@100..900&amp;family=Inter:wght@100..900&amp;family=Space+Mono:wght@100..900&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet">
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
                    "colors": {
                        "outline": "#9e8e7c",
                        "primary-fixed": "#ffddb5",
                        "surface": "#061421",
                        "surface-variant": "#293644",
                        "on-tertiary-container": "#004e30",
                        "inverse-on-surface": "#24323f",
                        "on-primary-fixed": "#2a1800",
                        "on-tertiary-fixed-variant": "#005232",
                        "error": "#ffb4ab",
                        "on-secondary-fixed": "#001c38",
                        "on-secondary-container": "#9ab7e0",
                        "on-background": "#d6e4f6",
                        "inverse-primary": "#835400",
                        "surface-container-low": "#0f1d2a",
                        "on-secondary-fixed-variant": "#2b486b",
                        "tertiary-fixed-dim": "#71dba2",
                        "surface-container-highest": "#293644",
                        "tertiary": "#76e0a8",
                        "surface-container-lowest": "#020f1c",
                        "primary-fixed-dim": "#ffb956",
                        "primary": "#ffc16c",
                        "on-surface": "#d6e4f6",
                        "surface-tint": "#ffb956",
                        "inverse-surface": "#d6e4f6",
                        "on-primary-fixed-variant": "#643f00",
                        "primary-container": "#e8a33d",
                        "on-tertiary": "#003821",
                        "surface-dim": "#061421",
                        "on-error-container": "#ffdad6",
                        "on-primary-container": "#5f3c00",
                        "secondary-fixed-dim": "#abc9f2",
                        "on-secondary": "#113253",
                        "on-surface-variant": "#d6c4b0",
                        "background": "#061421",
                        "surface-bright": "#2d3a49",
                        "secondary-container": "#2b486b",
                        "on-primary": "#462b00",
                        "secondary": "#abc9f2",
                        "surface-container-high": "#1e2b39",
                        "on-tertiary-fixed": "#002112",
                        "tertiary-fixed": "#8df8bd",
                        "surface-container": "#13212e",
                        "on-error": "#690005",
                        "outline-variant": "#514536",
                        "error-container": "#93000a",
                        "secondary-fixed": "#d2e4ff",
                        "tertiary-container": "#59c48e"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "margin-mobile": "1rem",
                        "space-xl": "1.5rem",
                        "space-sm": "0.5rem",
                        "gutter": "1rem",
                        "gutter-mobile": "0.75rem",
                        "space-xs": "0.25rem",
                        "space-md": "0.75rem",
                        "space-lg": "1rem",
                        "margin": "1.5rem"
                    },
                    "fontFamily": {
                        "display-hero": ["IBM Plex Sans"],
                        "body-lg": ["Inter"],
                        "label-mono-sm": ["Space Mono"],
                        "headline-sm": ["IBM Plex Sans"],
                        "label-mono-md": ["Space Mono"],
                        "label-caps": ["IBM Plex Sans"],
                        "body-sm": ["Inter"],
                        "label-mono-lg": ["Space Mono"],
                        "headline-lg": ["IBM Plex Sans"],
                        "headline-md": ["IBM Plex Sans"],
                        "body-md": ["Inter"],
                        "headline-lg-mobile": ["IBM Plex Sans"]
                    },
                    "fontSize": {
                        "display-hero": ["40px", {
                            "lineHeight": "48px",
                            "letterSpacing": "-0.02em",
                            "fontWeight": "600"
                        }],
                        "body-lg": ["15px", {
                            "lineHeight": "22px",
                            "letterSpacing": "-0.005em",
                            "fontWeight": "400"
                        }],
                        "label-mono-sm": ["9px", {
                            "lineHeight": "12px",
                            "letterSpacing": "0.08em",
                            "fontWeight": "700"
                        }],
                        "headline-sm": ["16px", {
                            "lineHeight": "24px",
                            "letterSpacing": "0",
                            "fontWeight": "600"
                        }],
                        "label-mono-md": ["11px", {
                            "lineHeight": "14px",
                            "letterSpacing": "0.06em",
                            "fontWeight": "400"
                        }],
                        "label-caps": ["11px", {
                            "lineHeight": "14px",
                            "letterSpacing": "0.08em",
                            "fontWeight": "600"
                        }],
                        "body-sm": ["12px", {
                            "lineHeight": "16px",
                            "letterSpacing": "0.01em",
                            "fontWeight": "400"
                        }],
                        "label-mono-lg": ["13px", {
                            "lineHeight": "16px",
                            "letterSpacing": "0.04em",
                            "fontWeight": "700"
                        }],
                        "headline-lg": ["28px", {
                            "lineHeight": "36px",
                            "letterSpacing": "-0.015em",
                            "fontWeight": "600"
                        }],
                        "headline-md": ["20px", {
                            "lineHeight": "28px",
                            "letterSpacing": "-0.01em",
                            "fontWeight": "600"
                        }],
                        "body-md": ["13px", {
                            "lineHeight": "18px",
                            "letterSpacing": "0",
                            "fontWeight": "400"
                        }],
                        "headline-lg-mobile": ["22px", {
                            "lineHeight": "28px",
                            "letterSpacing": "-0.01em",
                            "fontWeight": "600"
                        }]
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-surface font-body-md text-on-surface">
    <aside class="fixed left-0 top-0 h-full w-16 hover:w-64 bg-surface-container-low z-50 flex flex-col justify-between shadow-md transition-all duration-300 ease-in-out overflow-hidden group/sidebar">
        <div class="flex flex-col">
            <div class="h-16 px-space-md flex items-center gap-space-sm bg-surface-container-lowest overflow-hidden whitespace-nowrap"><img alt="VOSTOKPRIBOR Industrial AI Logo" class="h-8 w-8 shrink-0 object-contain" src="https://lh3.googleusercontent.com/aida/AEtjO1W0pnhS8IEaoTn70IOGIuwcWNpNgh10xzjUL5_oCtxmTZj8xgF1DI7e0F5iyT9zuQXrKTSp8fVISDLajw0cOVTlsEJPJrw3qV9YjP2k2JzO1v07n2BIvWyOQ5iikdzARo6tUdO70wQtL3rfgjs-8WdFHO9vFslvSDw0chLlp2BAZ27-Xf1xpu_2HcIYL1r5bO9UnamptMdIQ9n5jEdsmz-3oTg0r8nFbGeBPfgRIO6XOLSGrkRx6lGMUYj8">
                <div class="flex flex-col transition-opacity duration-300 opacity-0 group-hover/sidebar:opacity-100"><span class="font-label-caps text-label-caps text-on-surface tracking-wider uppercase">VOSTOKPRIBOR</span><span class="font-label-mono-sm text-label-mono-sm text-primary">SYS-AI CORE ENGINE</span></div>
            </div>
            <div class="px-space-sm group-hover/sidebar:px-space-md py-space-sm transition-all duration-300">
                <div class="font-label-mono-sm text-label-mono-sm text-outline uppercase tracking-wider mb-space-xs transition-opacity duration-200 opacity-0 group-hover/sidebar:opacity-100 whitespace-nowrap">Telemetry Rail</div>
                <nav class="flex flex-col gap-space-xs" data-active-classes="bg-surface-container-high text-primary font-headline-sm"><a class="group flex items-center justify-between px-space-sm group-hover/sidebar:px-space-md py-space-sm rounded text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors whitespace-nowrap" data-path="projects" href="#">
                        <div class="flex items-center gap-space-sm shrink-0"><span class="w-2.5 h-2.5 rounded-full bg-primary animate-pulse shrink-0"></span><span class="font-label-caps text-label-caps opacity-0 group-hover/sidebar:opacity-100 transition-opacity duration-300">SYS-AI-01 Projects</span></div><span class="font-label-mono-sm text-label-mono-sm text-primary opacity-0 group-hover/sidebar:opacity-100 transition-opacity duration-300">ACT</span>
                    </a><a class="group flex items-center justify-between px-space-sm group-hover/sidebar:px-space-md py-space-sm rounded text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors whitespace-nowrap" data-path="data-center" href="#">
                        <div class="flex items-center gap-space-sm shrink-0"><span class="w-2.5 h-2.5 rounded-full bg-outline-variant shrink-0"></span><span class="font-label-caps text-label-caps opacity-0 group-hover/sidebar:opacity-100 transition-opacity duration-300">SYS-AI-02 Data Center</span></div><span class="font-label-mono-sm text-label-mono-sm text-on-surface-variant opacity-0 group-hover/sidebar:opacity-100 transition-opacity duration-300">SYNC</span>
                    </a><a class="group flex items-center justify-between px-space-sm group-hover/sidebar:px-space-md py-space-sm rounded text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors whitespace-nowrap" data-path="workbench" href="#">
                        <div class="flex items-center gap-space-sm shrink-0"><span class="w-2.5 h-2.5 rounded-full bg-outline-variant shrink-0"></span><span class="font-label-caps text-label-caps opacity-0 group-hover/sidebar:opacity-100 transition-opacity duration-300">SYS-AI-03 Workbench</span></div><span class="font-label-mono-sm text-label-mono-sm text-on-surface-variant opacity-0 group-hover/sidebar:opacity-100 transition-opacity duration-300">RDY</span>
                    </a><a class="group flex items-center justify-between px-space-sm group-hover/sidebar:px-space-md py-space-sm rounded text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors whitespace-nowrap" data-path="registry-deployment" href="#">
                        <div class="flex items-center gap-space-sm shrink-0"><span class="w-2.5 h-2.5 rounded-full bg-outline-variant shrink-0"></span><span class="font-label-caps text-label-caps opacity-0 group-hover/sidebar:opacity-100 transition-opacity duration-300">SYS-AI-04 Registry &amp; Deploy</span></div><span class="font-label-mono-sm text-label-mono-sm text-on-surface-variant opacity-0 group-hover/sidebar:opacity-100 transition-opacity duration-300">v2.4</span>
                    </a><a class="group flex items-center justify-between px-space-sm group-hover/sidebar:px-space-md py-space-sm rounded text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors whitespace-nowrap" data-path="ai-soc" href="#">
                        <div class="flex items-center gap-space-sm shrink-0"><span class="w-2.5 h-2.5 rounded-full bg-tertiary shrink-0"></span><span class="font-label-caps text-label-caps opacity-0 group-hover/sidebar:opacity-100 transition-opacity duration-300">SYS-AI-05 AI SOC</span></div><span class="font-label-mono-sm text-label-mono-sm text-tertiary opacity-0 group-hover/sidebar:opacity-100 transition-opacity duration-300">SEC</span>
                    </a></nav>
            </div>
        </div>
        <div class="p-space-sm group-hover/sidebar:p-space-md bg-surface-container-lowest flex flex-col gap-space-xs transition-all duration-300 overflow-hidden whitespace-nowrap">
            <div class="flex items-center gap-space-xs"><span class="inline-block w-2.5 h-2.5 rounded-full bg-tertiary shrink-0"></span><span class="font-label-mono-sm text-label-mono-sm text-tertiary opacity-0 group-hover/sidebar:opacity-100 transition-opacity duration-300">SYS-AI ONLINE</span></div>
            <div class="font-label-mono-sm text-label-mono-sm text-on-surface-variant opacity-0 group-hover/sidebar:opacity-100 transition-opacity duration-300">LATENCY 14ms · ALMATY DC-01</div>
            <div class="font-label-mono-sm text-label-mono-sm text-outline opacity-0 group-hover/sidebar:opacity-100 transition-opacity duration-300">UPTIME 99.98% · NODE_ID: 884-A</div>
        </div>
    </aside>
    <div class="pl-16 transition-all duration-300">
        <header class="fixed top-0 left-16 right-0 z-40 bg-surface/90 backdrop-blur-xl shadow-[0_1px_8px_rgba(0,0,0,0.04)] transition-all duration-300">
            <div class="h-16 px-space-lg flex items-center justify-between gap-space-md">
                <div class="flex items-center gap-space-md"><span class="font-headline-sm text-headline-sm text-on-surface tracking-tight whitespace-nowrap">VOSTOKPRIBOR · SYS-AI INDUSTRIAL PORTAL</span>
                    <div class="relative flex items-center bg-surface-container px-space-sm py-space-xs rounded w-64"><span class="material-symbols-outlined text-outline text-[18px] mr-space-xs">search</span><input class="bg-transparent w-full text-on-surface placeholder:text-outline font-body-sm text-body-sm focus:outline-none" placeholder="Search telemetry, jobs..." type="text"><span class="font-label-mono-sm text-label-mono-sm bg-surface-container-high text-on-surface-variant px-1 rounded">⌘K</span></div>
                </div>
                <div class="flex items-center gap-space-md">
                    <div class="flex items-center bg-surface-container rounded p-0.5"><button class="px-space-sm py-space-xs font-label-caps text-label-caps rounded bg-primary-container text-on-primary-container">Student</button><button class="px-space-sm py-space-xs font-label-caps text-label-caps rounded text-on-surface-variant hover:text-on-surface">Instructor</button></div>
                    <div class="flex items-center bg-surface-container rounded px-space-xs py-space-xs font-label-mono-sm text-label-mono-sm"><span class="px-1.5 py-0.5 rounded bg-surface-bright text-on-surface">EN</span><span class="px-1.5 py-0.5 text-on-surface-variant">AR</span></div>
                    <div class="relative flex items-center justify-center p-space-xs rounded bg-surface-container text-on-surface-variant hover:text-on-surface"><span class="material-symbols-outlined text-[20px]">notifications</span><span class="absolute -top-1 -right-1 w-4 h-4 rounded-full bg-error text-on-error font-label-mono-sm text-label-mono-sm flex items-center justify-center">3</span></div>
                    <div class="flex items-center gap-space-sm pl-space-sm bg-surface-container rounded-lg p-space-xs">
                        <div class="flex flex-col text-right"><span class="font-label-caps text-label-caps text-on-surface">Gulkaba T.</span><span class="font-label-mono-sm text-label-mono-sm text-primary">Intern AI Engineer · L2</span></div>
                        <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center"><span class="material-symbols-outlined text-on-primary text-[18px]">person</span></div>
                    </div>
                </div>
            </div>
            <div class="h-10 px-space-lg flex items-center justify-between bg-surface-container-low">
                <nav class="flex items-center gap-space-xs" data-active-classes="bg-primary text-on-primary font-bold rounded-full"><a class="px-space-sm py-0.5 rounded-full font-label-caps text-label-caps text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="dashboard" href="#">Dashboard</a><a class="px-space-sm py-0.5 rounded-full font-label-caps text-label-caps text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="ticket-board" href="#">Ticket Board</a><a class="px-space-sm py-0.5 rounded-full font-label-caps text-label-caps text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="ticket-detail-ai-024" href="#">Ticket Detail #AI-024</a><a class="px-space-sm py-0.5 rounded-full font-label-caps text-label-caps text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="submissions" href="#">Submissions</a><a class="px-space-sm py-0.5 rounded-full font-label-caps text-label-caps text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="evaluation" href="#">Evaluation</a><a class="px-space-sm py-0.5 rounded-full font-label-caps text-label-caps text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="instructor-portal" href="#">Instructor Portal</a></nav>
                <div class="flex items-center gap-space-xs font-label-mono-sm text-label-mono-sm text-outline"><span class="material-symbols-outlined text-[14px] text-tertiary">sync</span><span class="">BUFFER 100% NOMINAL</span></div>
            </div>
            <div class="h-10 px-space-lg bg-surface-container-lowest flex items-center overflow-x-auto gap-space-xs">
                <div class="flex items-center gap-1 shrink-0"><span class="w-4 h-4 rounded-full bg-tertiary text-on-tertiary font-label-mono-sm text-label-mono-sm flex items-center justify-center">✓</span><span class="font-label-mono-sm text-label-mono-sm text-on-surface">1 Request</span></div><span class="text-outline text-label-mono-sm">—</span>
                <div class="flex items-center gap-1 shrink-0"><span class="w-4 h-4 rounded-full bg-tertiary text-on-tertiary font-label-mono-sm text-label-mono-sm flex items-center justify-center">✓</span><span class="font-label-mono-sm text-label-mono-sm text-on-surface">2 Problem</span></div><span class="text-outline text-label-mono-sm">—</span>
                <div class="flex items-center gap-1 shrink-0"><span class="w-4 h-4 rounded-full bg-tertiary text-on-tertiary font-label-mono-sm text-label-mono-sm flex items-center justify-center">✓</span><span class="font-label-mono-sm text-label-mono-sm text-on-surface">3 Collection</span></div><span class="text-outline text-label-mono-sm">—</span>
                <div class="flex items-center gap-1 shrink-0"><span class="w-4 h-4 rounded-full bg-tertiary text-on-tertiary font-label-mono-sm text-label-mono-sm flex items-center justify-center">✓</span><span class="font-label-mono-sm text-label-mono-sm text-on-surface">4 EDA</span></div><span class="text-outline text-label-mono-sm">—</span>
                <div class="flex items-center gap-1 shrink-0"><span class="w-4 h-4 rounded-full bg-tertiary text-on-tertiary font-label-mono-sm text-label-mono-sm flex items-center justify-center">✓</span><span class="font-label-mono-sm text-label-mono-sm text-on-surface">5 Clean</span></div><span class="text-outline text-label-mono-sm">—</span>
                <div class="flex items-center gap-1 shrink-0"><span class="w-4 h-4 rounded-full bg-tertiary text-on-tertiary font-label-mono-sm text-label-mono-sm flex items-center justify-center">✓</span><span class="font-label-mono-sm text-label-mono-sm text-on-surface">6 Features</span></div><span class="text-outline text-label-mono-sm">—</span>
                <div class="flex items-center gap-1 shrink-0 bg-primary-container px-space-xs py-0.5 rounded"><span class="w-4 h-4 rounded-full bg-on-primary-container text-primary-container font-label-mono-sm text-label-mono-sm flex items-center justify-center animate-pulse">7</span><span class="font-label-mono-sm text-label-mono-sm text-on-primary-container font-bold">7 Build</span></div><span class="text-outline text-label-mono-sm">—</span>
                <div class="flex items-center gap-1 shrink-0 opacity-60"><span class="w-4 h-4 rounded-full bg-surface-container-high text-on-surface font-label-mono-sm text-label-mono-sm flex items-center justify-center">8</span><span class="font-label-mono-sm text-label-mono-sm text-on-surface-variant">8 Eval</span></div><span class="text-outline text-label-mono-sm">—</span>
                <div class="flex items-center gap-1 shrink-0 opacity-60"><span class="w-4 h-4 rounded-full bg-surface-container-high text-on-surface font-label-mono-sm text-label-mono-sm flex items-center justify-center">9</span><span class="font-label-mono-sm text-label-mono-sm text-on-surface-variant">9 Improve</span></div><span class="text-outline text-label-mono-sm">—</span>
                <div class="flex items-center gap-1 shrink-0 opacity-60"><span class="w-4 h-4 rounded-full bg-surface-container-high text-on-surface font-label-mono-sm text-label-mono-sm flex items-center justify-center">10</span><span class="font-label-mono-sm text-label-mono-sm text-on-surface-variant">10 Deploy</span></div><span class="text-outline text-label-mono-sm">—</span>
                <div class="flex items-center gap-1 shrink-0 opacity-60"><span class="w-4 h-4 rounded-full bg-surface-container-high text-on-surface font-label-mono-sm text-label-mono-sm flex items-center justify-center">11</span><span class="font-label-mono-sm text-label-mono-sm text-on-surface-variant">11 Integrate</span></div><span class="text-outline text-label-mono-sm">—</span>
                <div class="flex items-center gap-1 shrink-0 opacity-60"><span class="w-4 h-4 rounded-full bg-surface-container-high text-on-surface font-label-mono-sm text-label-mono-sm flex items-center justify-center">12</span><span class="font-label-mono-sm text-label-mono-sm text-on-surface-variant">12 Monitor</span></div><span class="text-outline text-label-mono-sm">—</span>
                <div class="flex items-center gap-1 shrink-0 opacity-60"><span class="w-4 h-4 rounded-full bg-surface-container-high text-on-surface font-label-mono-sm text-label-mono-sm flex items-center justify-center">13</span><span class="font-label-mono-sm text-label-mono-sm text-on-surface-variant">13 Drift</span></div><span class="text-outline text-label-mono-sm">—</span>
                <div class="flex items-center gap-1 shrink-0 opacity-60"><span class="w-4 h-4 rounded-full bg-surface-container-high text-on-surface font-label-mono-sm text-label-mono-sm flex items-center justify-center">14</span><span class="font-label-mono-sm text-label-mono-sm text-on-surface-variant">14 Report</span></div>
            </div>
        </header>
    </div>

</body>

</html>