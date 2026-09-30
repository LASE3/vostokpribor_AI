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
    <aside class="fixed left-0 top-0 h-full w-16 hover:w-64 bg-surface-container-low z-50 flex flex-col justify-between shadow-[0_1px_8px_rgba(0,0,0,0.04)] group transition-all duration-300 ease-in-out overflow-hidden shadow-2xl">
        <div class="flex flex-col">
            <div class="h-16 px-space-md flex items-center gap-space-sm bg-surface-container-lowest overflow-hidden whitespace-nowrap"><img alt="VOSTOKPRIBOR Industrial AI Logo" class="h-8 w-8 shrink-0 object-contain" src="https://lh3.googleusercontent.com/aida/AEtjO1W0pnhS8IEaoTn70IOGIuwcWNpNgh10xzjUL5_oCtxmTZj8xgF1DI7e0F5iyT9zuQXrKTSp8fVISDLajw0cOVTlsEJPJrw3qV9YjP2k2JzO1v07n2BIvWyOQ5iikdzARo6tUdO70wQtL3rfgjs-8WdFHO9vFslvSDw0chLlp2BAZ27-Xf1xpu_2HcIYL1r5bO9UnamptMdIQ9n5jEdsmz-3oTg0r8nFbGeBPfgRIO6XOLSGrkRx6lGMUYj8">
                <div class="flex flex-col opacity-0 group-hover:opacity-100 transition-opacity duration-200"><span class="font-label-caps text-label-caps text-on-surface tracking-wider uppercase whitespace-nowrap">VOSTOKPRIBOR</span><span class="font-label-mono-sm text-label-mono-sm text-primary whitespace-nowrap">SYS-AI CORE ENGINE</span></div>
            </div>
            <div class="px-space-xs group-hover:px-space-md py-space-sm transition-all duration-300">
                <div class="font-label-mono-sm text-label-mono-sm text-outline uppercase tracking-wider mb-space-xs px-space-xs group-hover:px-0 truncate whitespace-nowrap">Telemetry Rail</div>
                <nav class="flex flex-col gap-space-xs" data-active-classes="bg-surface-container-high text-primary font-headline-sm"><a class="group/item flex items-center justify-between p-space-sm group-hover:px-space-md group-hover:py-space-sm rounded text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors whitespace-nowrap" data-path="projects" href="#" title="SYS-AI-01 Projects">
                        <div class="flex items-center gap-space-sm"><span class="w-2 h-2 rounded-full bg-primary animate-pulse shrink-0"></span><span class="font-label-caps text-label-caps opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap">SYS-AI-01 Projects</span></div><span class="font-label-mono-sm text-label-mono-sm text-primary opacity-0 group-hover:opacity-100 transition-opacity duration-200">ACT</span>
                    </a><a class="group/item flex items-center justify-between p-space-sm group-hover:px-space-md group-hover:py-space-sm rounded text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors whitespace-nowrap" data-path="data-center" href="#" title="SYS-AI-02 Data Center">
                        <div class="flex items-center gap-space-sm"><span class="w-2 h-2 rounded-full bg-outline-variant shrink-0"></span><span class="font-label-caps text-label-caps opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap">SYS-AI-02 Data Center</span></div><span class="font-label-mono-sm text-label-mono-sm text-on-surface-variant opacity-0 group-hover:opacity-100 transition-opacity duration-200">SYNC</span>
                    </a><a class="group/item flex items-center justify-between p-space-sm group-hover:px-space-md group-hover:py-space-sm rounded text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors whitespace-nowrap" data-path="workbench" href="#" title="SYS-AI-03 Workbench">
                        <div class="flex items-center gap-space-sm"><span class="w-2 h-2 rounded-full bg-outline-variant shrink-0"></span><span class="font-label-caps text-label-caps opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap">SYS-AI-03 Workbench</span></div><span class="font-label-mono-sm text-label-mono-sm text-on-surface-variant opacity-0 group-hover:opacity-100 transition-opacity duration-200">RDY</span>
                    </a><a class="group/item flex items-center justify-between p-space-sm group-hover:px-space-md group-hover:py-space-sm rounded text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors whitespace-nowrap" data-path="registry-deployment" href="#" title="SYS-AI-04 Registry &amp; Deploy">
                        <div class="flex items-center gap-space-sm"><span class="w-2 h-2 rounded-full bg-outline-variant shrink-0"></span><span class="font-label-caps text-label-caps opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap">SYS-AI-04 Registry &amp; Deploy</span></div><span class="font-label-mono-sm text-label-mono-sm text-on-surface-variant opacity-0 group-hover:opacity-100 transition-opacity duration-200">v2.4</span>
                    </a><a class="group/item flex items-center justify-between p-space-sm group-hover:px-space-md group-hover:py-space-sm rounded text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors whitespace-nowrap" data-path="ai-soc" href="#" title="SYS-AI-05 AI SOC">
                        <div class="flex items-center gap-space-sm"><span class="w-2 h-2 rounded-full bg-tertiary shrink-0"></span><span class="font-label-caps text-label-caps opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap">SYS-AI-05 AI SOC</span></div><span class="font-label-mono-sm text-label-mono-sm text-tertiary opacity-0 group-hover:opacity-100 transition-opacity duration-200">SEC</span>
                    </a></nav>
            </div>
        </div>
        <div class="p-space-xs group-hover:p-space-md bg-surface-container-lowest flex flex-col gap-space-xs overflow-hidden transition-all duration-300">
            <div class="flex items-center gap-space-xs"><span class="inline-block w-2 h-2 rounded-full bg-tertiary shrink-0 ml-1 group-hover:ml-0"></span><span class="font-label-mono-sm text-label-mono-sm text-tertiary whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-200">SYS-AI ONLINE</span></div>
            <div class="font-label-mono-sm text-label-mono-sm text-on-surface-variant whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-200">LATENCY 14ms · ALMATY DC-01</div>
            <div class="font-label-mono-sm text-label-mono-sm text-outline whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-200">UPTIME 99.98% · NODE_ID: 884-A</div>
        </div>
    </aside>
    <div class="pl-16">
        <header class="fixed top-0 right-0 z-40 bg-surface/90 backdrop-blur-xl shadow-[0_1px_8px_rgba(0,0,0,0.04)] left-16">
            <div class="h-16 px-space-lg flex items-center justify-between gap-space-md">
                <div class="flex items-center gap-space-md"><span class="font-headline-sm text-headline-sm text-on-surface tracking-tight whitespace-nowrap">VOSTOKPRIBOR · SYS-AI INDUSTRIAL PORTAL</span>
                    <div class="relative flex items-center bg-surface-container px-space-sm py-space-xs rounded w-64"><span class="material-symbols-outlined text-outline text-[18px] mr-space-xs">search</span><input class="bg-transparent w-full text-on-surface placeholder:text-outline font-body-sm text-body-sm focus:outline-none" placeholder="Search telemetry, jobs..." type="text"><span class="font-label-mono-sm text-label-mono-sm bg-surface-container-high text-on-surface-variant px-1 rounded">⌘K</span></div>
                </div>
                <div class="flex items-center gap-space-md">
                    <div class="flex items-center bg-surface-container rounded p-0.5"><button class="px-space-sm py-space-xs font-label-caps text-label-caps rounded text-on-surface-variant hover:text-on-surface transition-colors">Student</button><button class="px-space-sm py-space-xs font-label-caps text-label-caps rounded bg-primary text-on-primary font-bold shadow-sm">Instructor</button></div>
                    <div class="flex items-center bg-surface-container rounded px-space-xs py-space-xs font-label-mono-sm text-label-mono-sm"><span class="px-1.5 py-0.5 rounded bg-surface-bright text-on-surface">EN</span><span class="px-1.5 py-0.5 text-on-surface-variant">AR</span></div>
                    <div class="relative flex items-center justify-center p-space-xs rounded bg-surface-container text-on-surface-variant hover:text-on-surface"><span class="material-symbols-outlined text-[20px]">notifications</span><span class="absolute -top-1 -right-1 w-4 h-4 rounded-full bg-error text-on-error font-label-mono-sm text-label-mono-sm flex items-center justify-center">3</span></div>
                    <div class="flex items-center gap-space-sm pl-space-sm bg-surface-container rounded-lg p-space-xs">
                        <div class="flex flex-col text-right"><span class="font-label-caps text-label-caps text-on-surface">M. Tursunov</span><span class="font-label-mono-sm text-label-mono-sm text-primary">Chief Inspector · Staff AI Architect</span></div>
                        <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center"><span class="material-symbols-outlined text-on-primary text-[18px]">person</span></div>
                    </div>
                </div>
            </div>
            <div class="h-10 px-space-lg flex items-center justify-between bg-surface-container-low">
                <nav class="flex items-center gap-space-xs" data-active-classes="bg-primary text-on-primary font-bold rounded-full"><a class="px-space-sm py-0.5 rounded-full font-label-caps text-label-caps text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="dashboard" href="#">Dashboard</a><a class="px-space-sm py-0.5 rounded-full font-label-caps text-label-caps text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="ticket-board" href="#">Ticket Board</a><a class="px-space-sm py-0.5 rounded-full font-label-caps text-label-caps text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="ticket-detail-ai-024" href="#">Ticket Detail #AI-024</a><a class="px-space-sm py-0.5 rounded-full font-label-caps text-label-caps text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="submissions" href="#">Submissions</a><a class="px-space-sm py-0.5 rounded-full font-label-caps text-label-caps text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="evaluation" href="#">Evaluation</a><a class="px-space-sm py-0.5 rounded-full font-label-caps text-label-caps bg-primary text-on-primary font-bold shadow-sm" data-path="instructor-portal" href="#">Instructor Portal</a></nav>
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
        <main class="relative pt-36 bg-surface min-h-screen">
            <div class="flex flex-col w-full">
                <!-- Shell Top Navigation Sync (Client-Side DOM Adjustment for Instructor State) -->
                <script>
                    (function syncInstructorShell() {
                        try {
                            const studentBtn = document.querySelector('header button:first-child');
                            const instructorBtn = document.querySelector('header button:nth-child(2)');
                            if (studentBtn && instructorBtn) {
                                studentBtn.className = "px-space-sm py-space-xs font-label-caps text-label-caps rounded text-on-surface-variant hover:text-on-surface transition-colors";
                                instructorBtn.className = "px-space-sm py-space-xs font-label-caps text-label-caps rounded bg-primary text-on-primary font-bold shadow-sm";
                            }
                            const profileName = document.querySelector('header .text-right span:first-child');
                            const profileRole = document.querySelector('header .text-right span:last-child');
                            if (profileName) profileName.textContent = "M. Tursunov";
                            if (profileRole) profileRole.textContent = "Chief Inspector · Staff AI Architect";

                            const subNavLinks = document.querySelectorAll('header nav a[data-path]');
                            subNavLinks.forEach(link => {
                                if (link.getAttribute('data-path') === 'instructor-portal') {
                                    link.className = "px-space-sm py-0.5 rounded-full font-label-caps text-label-caps bg-primary text-on-primary font-bold shadow-sm";
                                } else {
                                    link.className = "px-space-sm py-0.5 rounded-full font-label-caps text-label-caps text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors";
                                }
                            });
                        } catch (e) {
                            console.warn('Navigation state sync bypassed:', e);
                        }
                    })();
                </script>
                <!-- Main Content Layout Area -->
                <div class="p-space-lg flex flex-col gap-space-lg">
                    <!-- 1. Executive Header / Cohort Banner -->
                    <div class="flex flex-col bg-surface-container-low rounded-xl p-space-lg shadow-md relative overflow-hidden">
                        <!-- Ambient subtle status gradient -->
                        <div class="absolute -right-24 -top-24 w-96 h-96 bg-primary/5 rounded-full blur-3xl pointer-events-none"></div>
                        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-space-md mb-space-lg relative z-10">
                            <div class="flex flex-col gap-space-xs">
                                <div class="flex items-center gap-space-sm">
                                    <span class="inline-flex items-center gap-1.5 px-space-xs py-0.5 rounded bg-surface-container-highest font-label-mono-sm text-label-mono-sm text-primary tracking-wider uppercase">
                                        <span class="w-1.5 h-1.5 rounded-full bg-primary animate-ping"></span>
                                        COHORT VP-2024-ALMATY-SYS01 // SPRINT CYCLE #3
                                    </span>
                                    <span class="font-label-mono-sm text-label-mono-sm text-outline">TELEMETRY POOL: L2_INTERNS</span>
                                    <span class="px-space-xs py-0.5 rounded bg-tertiary-container/30 font-label-mono-sm text-label-mono-sm text-tertiary">18 NODES SYNCHRONIZED</span>
                                </div>
                                <h1 class="font-headline-lg text-headline-lg text-on-surface tracking-tight">Instructor Telemetry &amp; Trainee Cohort Command</h1>
                                <p class="font-body-md text-body-md text-on-surface-variant max-w-4xl">
                                    Real-time evaluation tracking, bottleneck diagnostics, and scenario intervention matrix across 18 Trainee AI Engineers engaged in mission-critical models.
                                </p>
                            </div>
                            <!-- Action Matrix -->
                            <div class="flex flex-wrap items-center gap-space-sm shrink-0">
                                <button class="flex items-center gap-space-xs px-space-md py-space-sm bg-primary text-on-primary rounded font-label-caps text-label-caps hover:bg-primary-fixed-dim transition-all shadow-sm" onclick="document.getElementById('scenario-wizard-panel').scrollIntoView({behavior: 'smooth'})">
                                    <span class="material-symbols-outlined text-[18px]">add_task</span>
                                    <span class="">New Scenario Package Wizard</span>
                                </button>
                                <button class="flex items-center gap-space-xs px-space-md py-space-sm bg-surface-container-high hover:bg-surface-container-highest text-on-surface rounded font-label-caps text-label-caps transition-colors">
                                    <span class="material-symbols-outlined text-[18px] text-on-surface-variant">download</span>
                                    <span class="">Export Audit Dossier (CSV/PDF)</span>
                                </button>
                                <button class="p-space-sm bg-surface-container-high hover:bg-surface-container-highest text-on-surface-variant hover:text-on-surface rounded transition-colors" onclick="this.classList.add('animate-pulse'); setTimeout(() =&gt; this.classList.remove('animate-pulse'), 1000);" title="Trigger Cohort Re-sync">
                                    <span class="material-symbols-outlined text-[18px] text-tertiary">sync</span>
                                </button>
                            </div>
                        </div>
                        <!-- Key Cohort KPI Metrics (4 Bento Cards) -->
                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-space-md relative z-10">
                            <!-- Metric 1: Active Trainees -->
                            <div class="bg-surface-container p-space-md rounded-lg flex flex-col justify-between shadow-sm">
                                <div class="flex items-center justify-between">
                                    <span class="font-label-caps text-label-caps text-on-surface-variant uppercase">Active Trainees</span>
                                    <span class="material-symbols-outlined text-tertiary text-[18px]">groups</span>
                                </div>
                                <div class="flex items-baseline gap-space-sm my-space-xs">
                                    <span class="font-headline-lg text-headline-lg text-on-surface">18 / 18</span>
                                    <span class="font-label-mono-sm text-label-mono-sm text-tertiary">100% ONLINE</span>
                                </div>
                                <div class="flex items-center justify-between text-on-surface-variant font-label-mono-sm text-label-mono-sm">
                                    <span class="">Almaty DC-01 Compute Cluster</span>
                                    <span class="text-tertiary">0 DISCONNECTED</span>
                                </div>
                            </div>
                            <!-- Metric 2: Cohort Mean Score -->
                            <div class="bg-surface-container p-space-md rounded-lg flex flex-col justify-between shadow-sm">
                                <div class="flex items-center justify-between">
                                    <span class="font-label-caps text-label-caps text-on-surface-variant uppercase">Cohort Mean Score</span>
                                    <span class="material-symbols-outlined text-primary text-[18px]">analytics</span>
                                </div>
                                <div class="flex items-baseline gap-space-sm my-space-xs">
                                    <span class="font-headline-lg text-headline-lg text-primary">81.4</span>
                                    <span class="font-label-mono-sm text-label-mono-sm text-on-surface-variant">/ 100 PTS</span>
                                </div>
                                <div class="flex items-center justify-between font-label-mono-sm text-label-mono-sm">
                                    <span class="text-on-surface-variant">Pass Threshold: 80.0</span>
                                    <span class="text-tertiary">+1.4 PT MARGIN</span>
                                </div>
                            </div>
                            <!-- Metric 3: Stuck-Stage Bottlenecks -->
                            <div class="bg-surface-container p-space-md rounded-lg flex flex-col justify-between shadow-sm">
                                <div class="flex items-center justify-between">
                                    <span class="font-label-caps text-label-caps text-error uppercase">Gate Bottlenecks</span>
                                    <span class="material-symbols-outlined text-error text-[18px]">fmd_bad</span>
                                </div>
                                <div class="flex items-baseline gap-space-sm my-space-xs">
                                    <span class="font-headline-lg text-headline-lg text-error">5 Trainees</span>
                                    <span class="font-label-mono-sm text-label-mono-sm text-error bg-error-container/40 px-1.5 py-0.5 rounded">FLAGGED</span>
                                </div>
                                <div class="flex items-center justify-between text-on-surface-variant font-label-mono-sm text-label-mono-sm">
                                    <span class="truncate">Stage 08 Eval (3) &amp; Stage 05 Clean (2)</span>
                                    <span class="text-error">&gt; 24H DELAY</span>
                                </div>
                            </div>
                            <!-- Metric 4: Clearance Rate -->
                            <div class="bg-surface-container p-space-md rounded-lg flex flex-col justify-between shadow-sm">
                                <div class="flex items-center justify-between">
                                    <span class="font-label-caps text-label-caps text-on-surface-variant uppercase">Clearance Rate</span>
                                    <span class="material-symbols-outlined text-secondary text-[18px]">verified</span>
                                </div>
                                <div class="flex items-baseline gap-space-sm my-space-xs">
                                    <span class="font-headline-lg text-headline-lg text-on-surface">61.1%</span>
                                    <span class="font-label-mono-sm text-label-mono-sm text-tertiary">11 OF 18</span>
                                </div>
                                <div class="flex items-center justify-between text-on-surface-variant font-label-mono-sm text-label-mono-sm">
                                    <span class="">Qualified for Stage 10 Container</span>
                                    <span class="text-secondary">PROD READY</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- 2. Stuck-Stage Analytics & Pipeline Bottleneck Diagnostics (Bento Grid) -->
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-md">
                        <!-- Visual 14-Stage Funnel Accumulation (8 cols) -->
                        <div class="lg:col-span-8 bg-surface-container-low rounded-xl p-space-lg shadow-sm flex flex-col justify-between">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-space-sm mb-space-md">
                                <div class="flex items-center gap-space-xs">
                                    <span class="material-symbols-outlined text-primary text-[20px]">waterfall_chart</span>
                                    <h2 class="font-headline-sm text-headline-sm text-on-surface">14-Stage Pipeline Cohort Funnel Distribution</h2>
                                </div>
                                <span class="font-label-mono-sm text-label-mono-sm text-on-surface-variant bg-surface-container px-space-xs py-0.5 rounded">
                                    SYS-AI TELEMETRY SAMPLE // REFRESHED 2M AGO
                                </span>
                            </div>
                            <!-- Stage Funnel Visual Segment Blocks -->
                            <div class="grid grid-cols-2 md:grid-cols-6 gap-space-sm my-space-xs">
                                <!-- Segment 1: Stage 01-04 -->
                                <div class="bg-surface-container rounded-lg p-space-sm flex flex-col justify-between shadow-sm">
                                    <div class="flex items-center justify-between mb-space-xs">
                                        <span class="font-label-mono-sm text-label-mono-sm text-outline">ST 01–04</span>
                                        <span class="w-2 h-2 rounded-full bg-tertiary"></span>
                                    </div>
                                    <div class="font-headline-md text-headline-md text-on-surface mb-space-xs">3 <span class="font-body-sm text-body-sm text-on-surface-variant">eng</span></div>
                                    <p class="font-body-sm text-body-sm text-tertiary truncate">Normal Pacing</p>
                                    <div class="w-full bg-surface-container-highest h-1 rounded-full overflow-hidden mt-space-xs">
                                        <div class="bg-tertiary h-full w-[17%]"></div>
                                    </div>
                                </div>
                                <!-- Segment 2: Stage 05 (Bottleneck A) -->
                                <div class="bg-surface-container rounded-lg p-space-sm flex flex-col justify-between shadow-sm bg-gradient-to-b from-surface-container to-surface-container-high">
                                    <div class="flex items-center justify-between mb-space-xs">
                                        <span class="font-label-mono-sm text-label-mono-sm text-error">ST 05 CLEAN</span>
                                        <span class="material-symbols-outlined text-error text-[14px]">warning</span>
                                    </div>
                                    <div class="font-headline-md text-headline-md text-error mb-space-xs">2 <span class="font-body-sm text-body-sm text-on-surface-variant">eng</span></div>
                                    <p class="font-body-sm text-body-sm text-error truncate">Stuck &gt; 24h: NaN Impute</p>
                                    <div class="w-full bg-surface-container-highest h-1 rounded-full overflow-hidden mt-space-xs">
                                        <div class="bg-error h-full w-[11%]"></div>
                                    </div>
                                </div>
                                <!-- Segment 3: Stage 06-07 -->
                                <div class="bg-surface-container rounded-lg p-space-sm flex flex-col justify-between shadow-sm">
                                    <div class="flex items-center justify-between mb-space-xs">
                                        <span class="font-label-mono-sm text-label-mono-sm text-outline">ST 06–07</span>
                                        <span class="w-2 h-2 rounded-full bg-tertiary"></span>
                                    </div>
                                    <div class="font-headline-md text-headline-md text-on-surface mb-space-xs">4 <span class="font-body-sm text-body-sm text-on-surface-variant">eng</span></div>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant truncate">Feature Eng &amp; Train</p>
                                    <div class="w-full bg-surface-container-highest h-1 rounded-full overflow-hidden mt-space-xs">
                                        <div class="bg-secondary h-full w-[22%]"></div>
                                    </div>
                                </div>
                                <!-- Segment 4: Stage 08 (Critical Bottleneck B) -->
                                <div class="bg-surface-container rounded-lg p-space-sm flex flex-col justify-between shadow-sm bg-gradient-to-b from-surface-container to-surface-container-high relative overflow-hidden">
                                    <div class="absolute top-0 right-0 w-8 h-8 bg-primary/20 rounded-bl-lg flex items-center justify-center">
                                        <span class="material-symbols-outlined text-primary text-[14px]">bolt</span>
                                    </div>
                                    <div class="flex items-center justify-between mb-space-xs">
                                        <span class="font-label-mono-sm text-label-mono-sm text-primary">ST 08 EVAL</span>
                                    </div>
                                    <div class="font-headline-md text-headline-md text-primary mb-space-xs">5 <span class="font-body-sm text-body-sm text-on-surface-variant">eng</span></div>
                                    <p class="font-body-sm text-body-sm text-primary truncate">Avg Time: 34.2h</p>
                                    <div class="w-full bg-surface-container-highest h-1 rounded-full overflow-hidden mt-space-xs">
                                        <div class="bg-primary h-full w-[28%]"></div>
                                    </div>
                                </div>
                                <!-- Segment 5: Stage 09-10 -->
                                <div class="bg-surface-container rounded-lg p-space-sm flex flex-col justify-between shadow-sm">
                                    <div class="flex items-center justify-between mb-space-xs">
                                        <span class="font-label-mono-sm text-label-mono-sm text-outline">ST 09–10</span>
                                        <span class="w-2 h-2 rounded-full bg-tertiary"></span>
                                    </div>
                                    <div class="font-headline-md text-headline-md text-on-surface mb-space-xs">3 <span class="font-body-sm text-body-sm text-on-surface-variant">eng</span></div>
                                    <p class="font-body-sm text-body-sm text-tertiary truncate">Deployment Ready</p>
                                    <div class="w-full bg-surface-container-highest h-1 rounded-full overflow-hidden mt-space-xs">
                                        <div class="bg-tertiary h-full w-[17%]"></div>
                                    </div>
                                </div>
                                <!-- Segment 6: Stage 11-14 -->
                                <div class="bg-surface-container rounded-lg p-space-sm flex flex-col justify-between shadow-sm">
                                    <div class="flex items-center justify-between mb-space-xs">
                                        <span class="font-label-mono-sm text-label-mono-sm text-outline">ST 11–14</span>
                                        <span class="w-2 h-2 rounded-full bg-secondary"></span>
                                    </div>
                                    <div class="font-headline-md text-headline-md text-secondary mb-space-xs">1 <span class="font-body-sm text-body-sm text-on-surface-variant">eng</span></div>
                                    <p class="font-body-sm text-body-sm text-secondary truncate">SOC Monitoring</p>
                                    <div class="w-full bg-surface-container-highest h-1 rounded-full overflow-hidden mt-space-xs">
                                        <div class="bg-secondary h-full w-[6%]"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- Inline Visual Funnel Progression Sparkline SVG -->
                            <div class="mt-space-md pt-space-sm bg-surface-container rounded-lg p-space-md">
                                <div class="flex items-center justify-between mb-space-xs">
                                    <span class="font-label-mono-sm text-label-mono-sm text-outline">FUNNEL TRANSITION ACCELERATION CURVE</span>
                                    <span class="font-label-mono-sm text-label-mono-sm text-primary">BARRIER CLUSTERING AT S08</span>
                                </div>
                                <svg class="w-full h-12 text-primary" fill="none" preserveAspectRatio="none" viewBox="0 0 700 50">
                                    <path d="M 0 35 C 50 35, 100 40, 150 42 C 200 45, 230 40, 280 20 C 330 0, 390 0, 430 18 C 470 38, 520 40, 580 42 C 640 45, 680 44, 700 45" stroke="currentColor" stroke-linecap="round" stroke-width="2.5"></path>
                                    <!-- Stage 08 Highlight Circle -->
                                    <circle class="fill-primary animate-pulse" cx="360" cy="5" r="4.5"></circle>
                                    <!-- Stage 05 Highlight Circle -->
                                    <circle class="fill-error" cx="210" cy="42" r="3.5"></circle>
                                </svg>
                                <div class="flex justify-between font-label-mono-sm text-label-mono-sm text-outline mt-1">
                                    <span class="">S01 Request</span>
                                    <span class="text-error">S05 Clean (-18h)</span>
                                    <span class="text-primary font-bold">S08 Eval Barrier (F1 ≥ 0.800)</span>
                                    <span class="">S10 Deploy</span>
                                    <span class="">S14 Audit</span>
                                </div>
                            </div>
                        </div>
                        <!-- Critical Bottleneck Root Cause Card & Intervention Dispatch (4 cols) -->
                        <div class="lg:col-span-4 bg-surface-container-low rounded-xl p-space-lg shadow-sm flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between gap-space-xs mb-space-sm">
                                    <div class="flex items-center gap-space-xs">
                                        <span class="w-2 h-2 rounded-full bg-primary animate-ping"></span>
                                        <span class="font-label-caps text-label-caps text-primary tracking-wider uppercase">Active Gate Diagnostics</span>
                                    </div>
                                    <span class="font-label-mono-sm text-label-mono-sm bg-error-container/40 text-error px-2 py-0.5 rounded font-bold">CRITICAL</span>
                                </div>
                                <h3 class="font-headline-sm text-headline-sm text-on-surface mb-space-xs">Stage 08 Evaluation Gate Bottleneck</h3>
                                <p class="font-body-sm text-body-sm text-on-surface-variant mb-space-md">
                                    Candidates struggling with sensor thermal drift correlation; held-out F1 test scores clustering at <strong class="text-primary font-mono">0.778 – 0.789</strong> against strict contractual SLA <strong class="text-on-surface font-mono">0.800</strong>. 3 candidates have attempted ≥ 4 runs without milestone breakthrough.
                                </p>
                                <div class="bg-surface-container p-space-sm rounded-lg mb-space-md flex flex-col gap-space-xs">
                                    <div class="flex items-center justify-between font-label-mono-sm text-label-mono-sm">
                                        <span class="text-on-surface-variant">PRIMARY CANDIDATE AT GATE:</span>
                                        <span class="text-primary font-bold">Gulkaba T. (#884A)</span>
                                    </div>
                                    <div class="flex items-center justify-between font-label-mono-sm text-label-mono-sm">
                                        <span class="text-on-surface-variant">LATEST BEST METRIC:</span>
                                        <span class="text-error font-bold">F1 0.784 (-0.016 GAP)</span>
                                    </div>
                                    <div class="flex items-center justify-between font-label-mono-sm text-label-mono-sm">
                                        <span class="text-on-surface-variant">COMPUTATION TIME ELAPSED:</span>
                                        <span class="text-outline">18h 42m on Run #04</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Instructor Quick Intervention Actions -->
                            <div class="flex flex-col gap-space-xs pt-space-xs">
                                <button class="w-full py-space-sm px-space-md bg-primary-container text-on-primary-container hover:bg-primary font-label-caps text-label-caps rounded flex items-center justify-center gap-space-xs transition-colors shadow-sm font-bold" onclick="alert('Guidance bulletin dispatched: Sensor thermal calibration feature hint sent to 5 flagged candidates.')">
                                    <span class="material-symbols-outlined text-[16px]">campaign</span>
                                    <span class="">Broadcast Hint: Sensor Thermal Drift</span>
                                </button>
                                <button class="w-full py-space-sm px-space-md bg-surface-container-high hover:bg-surface-container-highest text-on-surface font-label-caps text-label-caps rounded flex items-center justify-center gap-space-xs transition-colors" onclick="alert('Clinic invitation created: Live diagnostic lab clinic booked for 14:00 UTC.')">
                                    <span class="material-symbols-outlined text-[16px] text-primary">groups_2</span>
                                    <span class="">Schedule Diagnostic Lab Clinic</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- 3. Trainee Cohort Roster & Progress Heatmap (Data Density Table) -->
                    <div class="flex flex-col bg-surface-container-low rounded-xl p-space-lg shadow-sm">
                        <!-- Table Header & Live Filters -->
                        <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-space-md mb-space-md">
                            <div class="flex items-center gap-space-sm">
                                <span class="material-symbols-outlined text-primary text-[22px]">badge</span>
                                <div>
                                    <h2 class="font-headline-sm text-headline-sm text-on-surface">Trainee Cohort Roster &amp; Evaluation Matrix</h2>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant">18 active candidates monitored in Almaty DC-01 Sandbox environment</p>
                                </div>
                            </div>
                            <!-- Filter and Search Toolbar -->
                            <div class="flex flex-wrap items-center gap-space-sm">
                                <div class="relative flex items-center bg-surface-container px-space-sm py-space-xs rounded w-64">
                                    <span class="material-symbols-outlined text-outline text-[16px] mr-space-xs">search</span>
                                    <input class="bg-transparent w-full text-on-surface placeholder:text-outline font-body-sm text-body-sm focus:outline-none" id="roster-search" oninput="filterRoster()" placeholder="Search trainee, scenario, ID..." type="text">
                                </div>
                                <select class="bg-surface-container text-on-surface font-label-caps text-label-caps px-space-sm py-space-xs rounded focus:outline-none" id="stage-filter" onchange="filterRoster()">
                                    <option value="ALL">All Stages (01–14)</option>
                                    <option value="S05">Stage 05 Data Cleaning</option>
                                    <option value="S08">Stage 08 Model Eval Gate</option>
                                    <option value="S10">Stage 10 Deployment</option>
                                    <option value="S11">Stage 11 Integration</option>
                                </select>
                                <select class="bg-surface-container text-on-surface font-label-caps text-label-caps px-space-sm py-space-xs rounded focus:outline-none" id="risk-filter" onchange="filterRoster()">
                                    <option value="ALL">All Risk Levels</option>
                                    <option value="BLOCKED">Gate Blocked</option>
                                    <option value="AT_RISK">At Risk (&gt;24h)</option>
                                    <option value="NOMINAL">Nominal Flow</option>
                                </select>
                                <button class="px-space-sm py-space-xs font-label-mono-sm text-label-mono-sm bg-surface-container-high hover:bg-surface-container-highest text-on-surface-variant rounded" onclick="resetFilters()">
                                    RESET
                                </button>
                            </div>
                        </div>
                        <!-- Tabular Data View -->
                        <div class="overflow-x-auto">
                            <table class="w-full text-left font-body-sm text-body-sm">
                                <thead class="bg-surface-container font-label-caps text-label-caps text-outline uppercase tracking-wider">
                                    <tr>
                                        <th class="py-space-sm px-space-md">Trainee Candidate</th>
                                        <th class="py-space-sm px-space-md">Assigned Scenario</th>
                                        <th class="py-space-sm px-space-md">Active Stage</th>
                                        <th class="py-space-sm px-space-md">Metric (F1 / SLA)</th>
                                        <th class="py-space-sm px-space-md">Eval Score</th>
                                        <th class="py-space-sm px-space-md">Execution Run</th>
                                        <th class="py-space-sm px-space-md">Time In Stage</th>
                                        <th class="py-space-sm px-space-md text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-surface-container" id="roster-tbody">
                                    <!-- Row 1: Gulkaba T. (CONTINUITY HIGHLIGHT) -->
                                    <tr class="bg-surface-container-high/60 hover:bg-surface-container-highest transition-colors font-body-sm" data-risk="BLOCKED" data-stage="S08">
                                        <td class="py-space-md px-space-md">
                                            <div class="flex items-center gap-space-sm">
                                                <div class="relative w-9 h-9 rounded-full overflow-hidden bg-primary shrink-0">
                                                    <img alt="Eng. Gulkaba T. portrait" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida/AEtjO1XcgtBQqVVNyiSA1s6XU-d_Ux9hCRB5oqWpDojNsEC83UEwh_zQtz2sCVodcrcYPa5bg7mrzcr78uT9uaICu9Wa1eh09YWLD7_8xc5jkpgpvxI-fMGH3Z8P2xk-7Esh49hA1ZRpw0oK6NhwJ3ZL8LgjrPft2aXnLLvZswRFy-UY9Hb9vJFh6-DX_5j3wjfXPa3HwsfIMv_RRvYZa0ObgunMdDg45Hzt-yxGPXAVxQvz4cxUYCQ3-TgxG04J">
                                                </div>
                                                <div class="flex flex-col">
                                                    <div class="flex items-center gap-1">
                                                        <span class="font-headline-sm text-headline-sm text-primary font-bold">Eng. Gulkaba T.</span>
                                                        <span class="font-label-mono-sm text-label-mono-sm text-on-surface-variant bg-surface-container px-1 rounded">#884A</span>
                                                    </div>
                                                    <span class="font-label-mono-sm text-label-mono-sm text-tertiary">Intern AI Engineer · L2</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-space-md px-space-md">
                                            <div class="flex flex-col">
                                                <span class="font-label-caps text-label-caps text-on-surface font-semibold">#AI-024 Customer Churn MVP</span>
                                                <span class="font-label-mono-sm text-label-mono-sm text-outline">Aral Geomatics Group</span>
                                            </div>
                                        </td>
                                        <td class="py-space-md px-space-md">
                                            <span class="inline-flex items-center gap-1 px-space-xs py-0.5 rounded bg-error-container/40 text-error font-label-mono-sm text-label-mono-sm font-bold">
                                                <span class="w-1.5 h-1.5 rounded-full bg-error animate-ping"></span>
                                                Stage 08: Model Eval [BLOCKED]
                                            </span>
                                        </td>
                                        <td class="py-space-md px-space-md">
                                            <div class="flex flex-col">
                                                <span class="font-label-mono-lg text-label-mono-lg text-error font-bold">0.784</span>
                                                <span class="font-label-mono-sm text-label-mono-sm text-error">-0.016 (SLA 0.800)</span>
                                            </div>
                                        </td>
                                        <td class="py-space-md px-space-md">
                                            <div class="flex items-center gap-space-xs">
                                                <span class="font-headline-sm text-headline-sm text-on-surface font-mono">76.4</span>
                                                <span class="font-label-mono-sm text-label-mono-sm text-outline">/100</span>
                                            </div>
                                        </td>
                                        <td class="py-space-md px-space-md">
                                            <span class="font-label-mono-sm text-label-mono-sm bg-surface-container px-2 py-1 rounded text-primary font-bold">Run #04</span>
                                        </td>
                                        <td class="py-space-md px-space-md">
                                            <span class="font-label-mono-sm text-label-mono-sm text-primary font-bold">18h 42m remaining</span>
                                        </td>
                                        <td class="py-space-md px-space-md text-right">
                                            <div class="flex items-center justify-end gap-space-xs">
                                                <button class="p-space-xs rounded bg-surface-container hover:bg-surface-container-high text-on-surface transition-colors" onclick="alert('Opening candidate evaluation scorecard for Gulkaba T. (#AI-024)')" title="Inspect Scorecard">
                                                    <span class="material-symbols-outlined text-[16px]">fact_check</span>
                                                </button>
                                                <button class="p-space-xs rounded bg-surface-container hover:bg-surface-container-high text-primary transition-colors" onclick="alert('Viewing MLflow run artifacts and logs for Run #04')" title="View Workbench Runs">
                                                    <span class="material-symbols-outlined text-[16px]">terminal</span>
                                                </button>
                                                <button class="px-space-xs py-1 rounded bg-primary text-on-primary font-label-caps text-label-caps font-bold hover:bg-primary-fixed-dim transition-colors" onclick="confirmOverride('Gulkaba T.')" title="Override Stage Gate">
                                                    Override
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Row 2: Leonid Volkov (High Performer) -->
                                    <tr class="hover:bg-surface-container transition-colors" data-risk="NOMINAL" data-stage="S11">
                                        <td class="py-space-md px-space-md">
                                            <div class="flex items-center gap-space-sm">
                                                <div class="w-9 h-9 rounded-full bg-secondary-container flex items-center justify-center font-label-caps text-label-caps text-secondary font-bold shrink-0">
                                                    LV
                                                </div>
                                                <div class="flex flex-col">
                                                    <div class="flex items-center gap-1">
                                                        <span class="font-headline-sm text-headline-sm text-on-surface">Leonid Volkov</span>
                                                        <span class="font-label-mono-sm text-label-mono-sm text-on-surface-variant bg-surface-container px-1 rounded">#1018</span>
                                                    </div>
                                                    <span class="font-label-mono-sm text-label-mono-sm text-on-surface-variant">Intern AI Engineer · L2</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-space-md px-space-md">
                                            <div class="flex flex-col">
                                                <span class="font-label-caps text-label-caps text-on-surface">#AI-088 Customer Support Agent</span>
                                                <span class="font-label-mono-sm text-label-mono-sm text-outline">Qazaq Petroleum Digital</span>
                                            </div>
                                        </td>
                                        <td class="py-space-md px-space-md">
                                            <span class="inline-flex items-center gap-1 px-space-xs py-0.5 rounded bg-tertiary-container/30 text-tertiary font-label-mono-sm text-label-mono-sm font-semibold">
                                                <span class="w-1.5 h-1.5 rounded-full bg-tertiary"></span>
                                                Stage 11: Integrate [NOMINAL]
                                            </span>
                                        </td>
                                        <td class="py-space-md px-space-md">
                                            <div class="flex flex-col">
                                                <span class="font-label-mono-lg text-label-mono-lg text-tertiary font-bold">0.842</span>
                                                <span class="font-label-mono-sm text-label-mono-sm text-tertiary">+0.042 (SLA 0.800)</span>
                                            </div>
                                        </td>
                                        <td class="py-space-md px-space-md">
                                            <div class="flex items-center gap-space-xs">
                                                <span class="font-headline-sm text-headline-sm text-tertiary font-mono">89.2</span>
                                                <span class="font-label-mono-sm text-label-mono-sm text-outline">/100</span>
                                            </div>
                                        </td>
                                        <td class="py-space-md px-space-md">
                                            <span class="font-label-mono-sm text-label-mono-sm bg-surface-container px-2 py-1 rounded text-on-surface">Run #02</span>
                                        </td>
                                        <td class="py-space-md px-space-md">
                                            <span class="font-label-mono-sm text-label-mono-sm text-outline">4h 10m</span>
                                        </td>
                                        <td class="py-space-md px-space-md text-right">
                                            <div class="flex items-center justify-end gap-space-xs">
                                                <button class="p-space-xs rounded bg-surface-container hover:bg-surface-container-high text-on-surface transition-colors" title="Inspect Scorecard">
                                                    <span class="material-symbols-outlined text-[16px]">fact_check</span>
                                                </button>
                                                <button class="p-space-xs rounded bg-surface-container hover:bg-surface-container-high text-on-surface-variant transition-colors" title="View Workbench Runs">
                                                    <span class="material-symbols-outlined text-[16px]">terminal</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Row 3: K. Saparov (Stage 05 At Risk) -->
                                    <tr class="hover:bg-surface-container transition-colors" data-risk="AT_RISK" data-stage="S05">
                                        <td class="py-space-md px-space-md">
                                            <div class="flex items-center gap-space-sm">
                                                <div class="w-9 h-9 rounded-full bg-surface-container-highest flex items-center justify-center font-label-caps text-label-caps text-on-surface font-bold shrink-0">
                                                    KS
                                                </div>
                                                <div class="flex flex-col">
                                                    <div class="flex items-center gap-1">
                                                        <span class="font-headline-sm text-headline-sm text-on-surface">K. Saparov</span>
                                                        <span class="font-label-mono-sm text-label-mono-sm text-on-surface-variant bg-surface-container px-1 rounded">#1024</span>
                                                    </div>
                                                    <span class="font-label-mono-sm text-label-mono-sm text-on-surface-variant">Intern AI Engineer · L2</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-space-md px-space-md">
                                            <div class="flex flex-col">
                                                <span class="font-label-caps text-label-caps text-on-surface">#AI-019 Pressure Predictor</span>
                                                <span class="font-label-mono-sm text-label-mono-sm text-outline">Pavlodar Petro Refinery</span>
                                            </div>
                                        </td>
                                        <td class="py-space-md px-space-md">
                                            <span class="inline-flex items-center gap-1 px-space-xs py-0.5 rounded bg-error-container/30 text-error font-label-mono-sm text-label-mono-sm font-semibold">
                                                <span class="w-1.5 h-1.5 rounded-full bg-error"></span>
                                                Stage 05: Data Cleaning [AT RISK]
                                            </span>
                                        </td>
                                        <td class="py-space-md px-space-md">
                                            <div class="flex flex-col">
                                                <span class="font-label-mono-lg text-label-mono-lg text-outline">--</span>
                                                <span class="font-label-mono-sm text-label-mono-sm text-outline">Pre-eval pipeline</span>
                                            </div>
                                        </td>
                                        <td class="py-space-md px-space-md">
                                            <div class="flex items-center gap-space-xs">
                                                <span class="font-headline-sm text-headline-sm text-on-surface-variant font-mono">68.0</span>
                                                <span class="font-label-mono-sm text-label-mono-sm text-outline">/100</span>
                                            </div>
                                        </td>
                                        <td class="py-space-md px-space-md">
                                            <span class="font-label-mono-sm text-label-mono-sm bg-surface-container px-2 py-1 rounded text-on-surface">Run #05</span>
                                        </td>
                                        <td class="py-space-md px-space-md">
                                            <span class="font-label-mono-sm text-label-mono-sm text-error font-bold">32h 15m (FLAGGED)</span>
                                        </td>
                                        <td class="py-space-md px-space-md text-right">
                                            <div class="flex items-center justify-end gap-space-xs">
                                                <button class="p-space-xs rounded bg-surface-container hover:bg-surface-container-high text-on-surface transition-colors" title="Inspect Scorecard">
                                                    <span class="material-symbols-outlined text-[16px]">fact_check</span>
                                                </button>
                                                <button class="p-space-xs rounded bg-surface-container hover:bg-surface-container-high text-on-surface-variant transition-colors" title="View Workbench Runs">
                                                    <span class="material-symbols-outlined text-[16px]">terminal</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Row 4: D. Zhumabay (Blocked on Stage 08) -->
                                    <tr class="hover:bg-surface-container transition-colors" data-risk="BLOCKED" data-stage="S08">
                                        <td class="py-space-md px-space-md">
                                            <div class="flex items-center gap-space-sm">
                                                <div class="w-9 h-9 rounded-full bg-surface-container-highest flex items-center justify-center font-label-caps text-label-caps text-on-surface font-bold shrink-0">
                                                    DZ
                                                </div>
                                                <div class="flex flex-col">
                                                    <div class="flex items-center gap-1">
                                                        <span class="font-headline-sm text-headline-sm text-on-surface">D. Zhumabay</span>
                                                        <span class="font-label-mono-sm text-label-mono-sm text-on-surface-variant bg-surface-container px-1 rounded">#1032</span>
                                                    </div>
                                                    <span class="font-label-mono-sm text-label-mono-sm text-on-surface-variant">Intern AI Engineer · L2</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-space-md px-space-md">
                                            <div class="flex flex-col">
                                                <span class="font-label-caps text-label-caps text-on-surface">#AI-011 Turbine Vibration</span>
                                                <span class="font-label-mono-sm text-label-mono-sm text-outline">Balkhash Hydro Unit</span>
                                            </div>
                                        </td>
                                        <td class="py-space-md px-space-md">
                                            <span class="inline-flex items-center gap-1 px-space-xs py-0.5 rounded bg-error-container/40 text-error font-label-mono-sm text-label-mono-sm font-semibold">
                                                <span class="w-1.5 h-1.5 rounded-full bg-error"></span>
                                                Stage 08: Model Eval [BLOCKED]
                                            </span>
                                        </td>
                                        <td class="py-space-md px-space-md">
                                            <div class="flex flex-col">
                                                <span class="font-label-mono-lg text-label-mono-lg text-error font-bold">0.789</span>
                                                <span class="font-label-mono-sm text-label-mono-sm text-error">-0.011 (SLA 0.800)</span>
                                            </div>
                                        </td>
                                        <td class="py-space-md px-space-md">
                                            <div class="flex items-center gap-space-xs">
                                                <span class="font-headline-sm text-headline-sm text-on-surface font-mono">78.5</span>
                                                <span class="font-label-mono-sm text-label-mono-sm text-outline">/100</span>
                                            </div>
                                        </td>
                                        <td class="py-space-md px-space-md">
                                            <span class="font-label-mono-sm text-label-mono-sm bg-surface-container px-2 py-1 rounded text-on-surface">Run #04</span>
                                        </td>
                                        <td class="py-space-md px-space-md">
                                            <span class="font-label-mono-sm text-label-mono-sm text-primary font-bold">26h 04m</span>
                                        </td>
                                        <td class="py-space-md px-space-md text-right">
                                            <div class="flex items-center justify-end gap-space-xs">
                                                <button class="p-space-xs rounded bg-surface-container hover:bg-surface-container-high text-on-surface transition-colors" title="Inspect Scorecard">
                                                    <span class="material-symbols-outlined text-[16px]">fact_check</span>
                                                </button>
                                                <button class="p-space-xs rounded bg-surface-container hover:bg-surface-container-high text-on-surface-variant transition-colors" title="View Workbench Runs">
                                                    <span class="material-symbols-outlined text-[16px]">terminal</span>
                                                </button>
                                                <button class="px-space-xs py-1 rounded bg-surface-container-highest text-on-surface font-label-caps text-label-caps hover:bg-primary hover:text-on-primary transition-colors" onclick="confirmOverride('D. Zhumabay')">
                                                    Override
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Row 5: A. Smagulova (Stage 10 Nominal) -->
                                    <tr class="hover:bg-surface-container transition-colors" data-risk="NOMINAL" data-stage="S10">
                                        <td class="py-space-md px-space-md">
                                            <div class="flex items-center gap-space-sm">
                                                <div class="w-9 h-9 rounded-full bg-surface-container-highest flex items-center justify-center font-label-caps text-label-caps text-on-surface font-bold shrink-0">
                                                    AS
                                                </div>
                                                <div class="flex flex-col">
                                                    <div class="flex items-center gap-1">
                                                        <span class="font-headline-sm text-headline-sm text-on-surface">A. Smagulova</span>
                                                        <span class="font-label-mono-sm text-label-mono-sm text-on-surface-variant bg-surface-container px-1 rounded">#1045</span>
                                                    </div>
                                                    <span class="font-label-mono-sm text-label-mono-sm text-on-surface-variant">Intern AI Engineer · L2</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-space-md px-space-md">
                                            <div class="flex flex-col">
                                                <span class="font-label-caps text-label-caps text-on-surface">#AI-024 Customer Churn MVP</span>
                                                <span class="font-label-mono-sm text-label-mono-sm text-outline">Aral Geomatics Group</span>
                                            </div>
                                        </td>
                                        <td class="py-space-md px-space-md">
                                            <span class="inline-flex items-center gap-1 px-space-xs py-0.5 rounded bg-tertiary-container/30 text-tertiary font-label-mono-sm text-label-mono-sm font-semibold">
                                                <span class="w-1.5 h-1.5 rounded-full bg-tertiary"></span>
                                                Stage 10: Deploy [NOMINAL]
                                            </span>
                                        </td>
                                        <td class="py-space-md px-space-md">
                                            <div class="flex flex-col">
                                                <span class="font-label-mono-lg text-label-mono-lg text-tertiary font-bold">0.812</span>
                                                <span class="font-label-mono-sm text-label-mono-sm text-tertiary">+0.012 (SLA 0.800)</span>
                                            </div>
                                        </td>
                                        <td class="py-space-md px-space-md">
                                            <div class="flex items-center gap-space-xs">
                                                <span class="font-headline-sm text-headline-sm text-tertiary font-mono">84.0</span>
                                                <span class="font-label-mono-sm text-label-mono-sm text-outline">/100</span>
                                            </div>
                                        </td>
                                        <td class="py-space-md px-space-md">
                                            <span class="font-label-mono-sm text-label-mono-sm bg-surface-container px-2 py-1 rounded text-on-surface">Run #03</span>
                                        </td>
                                        <td class="py-space-md px-space-md">
                                            <span class="font-label-mono-sm text-label-mono-sm text-outline">9h 22m</span>
                                        </td>
                                        <td class="py-space-md px-space-md text-right">
                                            <div class="flex items-center justify-end gap-space-xs">
                                                <button class="p-space-xs rounded bg-surface-container hover:bg-surface-container-high text-on-surface transition-colors" title="Inspect Scorecard">
                                                    <span class="material-symbols-outlined text-[16px]">fact_check</span>
                                                </button>
                                                <button class="p-space-xs rounded bg-surface-container hover:bg-surface-container-high text-on-surface-variant transition-colors" title="View Workbench Runs">
                                                    <span class="material-symbols-outlined text-[16px]">terminal</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- Pagination and Table Telemetry Footer -->
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-space-sm pt-space-md mt-space-md bg-surface-container-lowest p-space-sm rounded-lg">
                            <div class="flex items-center gap-space-xs font-label-mono-sm text-label-mono-sm text-outline">
                                <span class="w-2 h-2 rounded-full bg-tertiary"></span>
                                <span class="">18 OF 18 RECORDS SYNCHRONIZED ACROSS ALMATY DC-01</span>
                            </div>
                            <div class="flex items-center gap-space-sm font-label-mono-sm text-label-mono-sm text-on-surface-variant">
                                <span class="">PAGE 1 OF 1</span>
                                <button class="px-space-xs py-0.5 rounded bg-surface-container opacity-50 cursor-not-allowed">PREV</button>
                                <button class="px-space-xs py-0.5 rounded bg-surface-container opacity-50 cursor-not-allowed">NEXT</button>
                            </div>
                        </div>
                    </div>
                    <!-- 4. Scenario Package Creation & Management Wizard Panel (9-Part Industrial Architecture) -->
                    <div class="flex flex-col bg-surface-container-low rounded-xl p-space-lg shadow-sm" id="scenario-wizard-panel">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-space-sm mb-space-md">
                            <div class="flex items-center gap-space-sm">
                                <div class="p-space-xs rounded bg-primary/20 text-primary">
                                    <span class="material-symbols-outlined text-[24px]">precision_manufacturing</span>
                                </div>
                                <div>
                                    <div class="flex items-center gap-space-xs">
                                        <span class="font-label-mono-sm text-label-mono-sm text-primary tracking-wider uppercase">INSPECTOR AUTHORING FRAMEWORK</span>
                                        <span class="font-label-mono-sm text-label-mono-sm bg-surface-container text-on-surface-variant px-1 rounded">SYS-AI-SPEC v4.2</span>
                                    </div>
                                    <h2 class="font-headline-md text-headline-md text-on-surface">Scenario Package Dispatcher &amp; Incident Injection Engine</h2>
                                </div>
                            </div>
                            <div class="flex items-center gap-space-xs">
                                <button class="px-space-md py-space-xs bg-surface-container-high hover:bg-surface-container-highest text-on-surface rounded font-label-caps text-label-caps transition-colors flex items-center gap-1" onclick="cloneScenarioTemplate()">
                                    <span class="material-symbols-outlined text-[16px]">file_copy</span>
                                    <span class="">Clone Template (#AI-024)</span>
                                </button>
                                <button class="px-space-md py-space-xs bg-primary text-on-primary rounded font-label-caps text-label-caps hover:bg-primary-fixed-dim transition-colors flex items-center gap-1 font-bold shadow-sm" onclick="publishNewScenario()">
                                    <span class="material-symbols-outlined text-[16px]">rocket_launch</span>
                                    <span class="">Deploy Industrial Package (#AI-102)</span>
                                </button>
                            </div>
                        </div>
                        <p class="font-body-sm text-body-sm text-on-surface-variant max-w-4xl mb-space-lg">
                            Configure end-to-end evaluation blueprints for industrial candidates. Instructors embed subtle edge cases, unannounced sensor drift traps, and strict SLA contractual gates across 9 synchronized lifecycle domains.
                        </p>
                        <!-- 9-Part Scenario Architecture Blueprint Accordion / Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-space-md">
                            <!-- Part 1: Business Problem & Client Framing -->
                            <div class="bg-surface-container rounded-lg p-space-md flex flex-col justify-between shadow-sm">
                                <div>
                                    <div class="flex items-center justify-between mb-space-xs">
                                        <span class="font-label-mono-sm text-label-mono-sm text-primary">PART 01</span>
                                        <span class="material-symbols-outlined text-outline text-[16px]">domain</span>
                                    </div>
                                    <h3 class="font-headline-sm text-headline-sm text-on-surface mb-space-xs">Business Problem &amp; Client Framing</h3>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant mb-space-sm">
                                        Contextual client entity: Aral Geomatics Group. Annual contract value: $4.2M. Churn prediction window: 90 days.
                                    </p>
                                </div>
                                <div class="font-label-mono-sm text-label-mono-sm bg-surface-container-lowest p-space-xs rounded text-outline flex items-center justify-between">
                                    <span class="">SLA Horizon: 90 Days</span>
                                    <span class="text-tertiary">CONFIDENTIAL</span>
                                </div>
                            </div>
                            <!-- Part 2: Mounted Datasets -->
                            <div class="bg-surface-container rounded-lg p-space-md flex flex-col justify-between shadow-sm">
                                <div>
                                    <div class="flex items-center justify-between mb-space-xs">
                                        <span class="font-label-mono-sm text-label-mono-sm text-primary">PART 02</span>
                                        <span class="material-symbols-outlined text-outline text-[16px]">database</span>
                                    </div>
                                    <h3 class="font-headline-sm text-headline-sm text-on-surface mb-space-xs">Mounted Datasets (SYS-AI-02)</h3>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant mb-space-sm">
                                        Locked schema: telemetry_timeseries_v3.parquet. 1,420,890 sensor rows, 48 features, read-only hash lock SHA-256.
                                    </p>
                                </div>
                                <div class="font-label-mono-sm text-label-mono-sm bg-surface-container-lowest p-space-xs rounded text-outline flex items-center justify-between">
                                    <span class="">Rows: 1.42M · Parquet</span>
                                    <span class="text-secondary">LOCKED</span>
                                </div>
                            </div>
                            <!-- Part 3: Strict Technical & Business Thresholds -->
                            <div class="bg-surface-container rounded-lg p-space-md flex flex-col justify-between shadow-sm">
                                <div>
                                    <div class="flex items-center justify-between mb-space-xs">
                                        <span class="font-label-mono-sm text-label-mono-sm text-primary">PART 03</span>
                                        <span class="material-symbols-outlined text-outline text-[16px]">rule</span>
                                    </div>
                                    <h3 class="font-headline-sm text-headline-sm text-on-surface mb-space-xs">Contractual Gate Thresholds</h3>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant mb-space-sm">
                                        Held-out F1 Score ≥ 0.800 (contractual penalty threshold). Inference Latency &lt; 50ms p95. Distroless container image &lt; 400MB.
                                    </p>
                                </div>
                                <div class="font-label-mono-sm text-label-mono-sm bg-surface-container-lowest p-space-xs rounded text-outline flex items-center justify-between">
                                    <span class="">F1 ≥ 0.800 · Latency &lt; 50ms</span>
                                    <span class="text-primary">MANDATORY</span>
                                </div>
                            </div>
                            <!-- Part 4: Available Tooling -->
                            <div class="bg-surface-container rounded-lg p-space-md flex flex-col justify-between shadow-sm">
                                <div>
                                    <div class="flex items-center justify-between mb-space-xs">
                                        <span class="font-label-mono-sm text-label-mono-sm text-primary">PART 04</span>
                                        <span class="material-symbols-outlined text-outline text-[16px]">memory</span>
                                    </div>
                                    <h3 class="font-headline-sm text-headline-sm text-on-surface mb-space-xs">Allocated Tooling &amp; Compute</h3>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant mb-space-sm">
                                        NVIDIA Tesla V100 (16GB VRAM), Polars acceleration node, XGBoost 2.0, LightGBM, automated MLflow tracking server.
                                    </p>
                                </div>
                                <div class="font-label-mono-sm text-label-mono-sm bg-surface-container-lowest p-space-xs rounded text-outline flex items-center justify-between">
                                    <span class="">Node: 1x V100 GPU</span>
                                    <span class="text-tertiary">PROVISIONED</span>
                                </div>
                            </div>
                            <!-- Part 5: Expected Trainee Actions -->
                            <div class="bg-surface-container rounded-lg p-space-md flex flex-col justify-between shadow-sm">
                                <div>
                                    <div class="flex items-center justify-between mb-space-xs">
                                        <span class="font-label-mono-sm text-label-mono-sm text-primary">PART 05</span>
                                        <span class="material-symbols-outlined text-outline text-[16px]">checklist</span>
                                    </div>
                                    <h3 class="font-headline-sm text-headline-sm text-on-surface mb-space-xs">Expected Trainee Milestones</h3>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant mb-space-sm">
                                        EDA anomaly report → Missing optical sensor imputation → Time-aware cross-validation split → Containerization.
                                    </p>
                                </div>
                                <div class="font-label-mono-sm text-label-mono-sm bg-surface-container-lowest p-space-xs rounded text-outline flex items-center justify-between">
                                    <span class="">Milestones: 6 Checkpoints</span>
                                    <span class="text-secondary">SEQUENCE VERIFIED</span>
                                </div>
                            </div>
                            <!-- Part 6: Hidden Injected Obstacles (INSTRUCTOR ONLY) -->
                            <div class="bg-surface-container rounded-lg p-space-md flex flex-col justify-between shadow-sm bg-gradient-to-br from-surface-container to-surface-container-high border border-primary/20">
                                <div>
                                    <div class="flex items-center justify-between mb-space-xs">
                                        <span class="font-label-mono-sm text-label-mono-sm text-primary font-bold">PART 06 [INSTRUCTOR-ONLY]</span>
                                        <span class="material-symbols-outlined text-primary text-[16px]">visibility_off</span>
                                    </div>
                                    <h3 class="font-headline-sm text-headline-sm text-primary mb-space-xs">Hidden Injected Obstacles</h3>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant mb-space-sm">
                                        Optical sensor dropout at row 840,210; synthetic SMOTE target leakage trap in naive train-test split; non-stationary sensor drift.
                                    </p>
                                </div>
                                <div class="font-label-mono-sm text-label-mono-sm bg-surface-container-lowest p-space-xs rounded text-outline flex items-center justify-between">
                                    <span class="">Trap: Synthetic SMOTE Leakage</span>
                                    <span class="text-primary font-bold">ACTIVE</span>
                                </div>
                            </div>
                            <!-- Part 7: Rubric & Evaluation Weights -->
                            <div class="bg-surface-container rounded-lg p-space-md flex flex-col justify-between shadow-sm">
                                <div>
                                    <div class="flex items-center justify-between mb-space-xs">
                                        <span class="font-label-mono-sm text-label-mono-sm text-primary">PART 07</span>
                                        <span class="material-symbols-outlined text-outline text-[16px]">tune</span>
                                    </div>
                                    <h3 class="font-headline-sm text-headline-sm text-on-surface mb-space-xs">Evaluation Weights &amp; Rubric</h3>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant mb-space-sm">
                                        Problem Framing: 10% · Data Prep &amp; Cleaning: 15% · Modeling Architecture: 20% · Eval &amp; Error Analysis: 25% · Deployment: 20% · Defense: 10%.
                                    </p>
                                </div>
                                <div class="font-label-mono-sm text-label-mono-sm bg-surface-container-lowest p-space-xs rounded text-outline flex items-center justify-between">
                                    <span class="">Composite: 100 Points</span>
                                    <span class="text-tertiary">CALIBRATED</span>
                                </div>
                            </div>
                            <!-- Part 8: Dynamic Injected Events -->
                            <div class="bg-surface-container rounded-lg p-space-md flex flex-col justify-between shadow-sm">
                                <div>
                                    <div class="flex items-center justify-between mb-space-xs">
                                        <span class="font-label-mono-sm text-label-mono-sm text-primary">PART 08</span>
                                        <span class="material-symbols-outlined text-outline text-[16px]">flash_on</span>
                                    </div>
                                    <h3 class="font-headline-sm text-headline-sm text-on-surface mb-space-xs">Mid-Sprint Dynamic Injections</h3>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant mb-space-sm">
                                        Simulated mid-sprint sensor recalibration (Event #EV-04 scheduled at hour 36: shifts feature μ by +12.4% without prior warning).
                                    </p>
                                </div>
                                <div class="font-label-mono-sm text-label-mono-sm bg-surface-container-lowest p-space-xs rounded text-outline flex items-center justify-between">
                                    <span class="">Trigger: Cron (H+36)</span>
                                    <span class="text-outline">QUEUED</span>
                                </div>
                            </div>
                            <!-- Part 9: Final Defense Assessment Criteria -->
                            <div class="bg-surface-container rounded-lg p-space-md flex flex-col justify-between shadow-sm">
                                <div>
                                    <div class="flex items-center justify-between mb-space-xs">
                                        <span class="font-label-mono-sm text-label-mono-sm text-primary">PART 09</span>
                                        <span class="material-symbols-outlined text-outline text-[16px]">co_present</span>
                                    </div>
                                    <h3 class="font-headline-sm text-headline-sm text-on-surface mb-space-xs">Oral Defense &amp; Audit Dossier</h3>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant mb-space-sm">
                                        15-minute live oral technical defense with Chief Inspector. Trainee must justify feature importance choices and explain model degradation modes.
                                    </p>
                                </div>
                                <div class="font-label-mono-sm text-label-mono-sm bg-surface-container-lowest p-space-xs rounded text-outline flex items-center justify-between">
                                    <span class="">Format: 1-on-1 Panel</span>
                                    <span class="text-secondary">READY</span>
                                </div>
                            </div>
                        </div>
                        <!-- Action Footer for Package Creation -->
                        <div class="mt-space-lg pt-space-md flex flex-col sm:flex-row sm:items-center justify-between gap-space-md bg-surface-container p-space-md rounded-lg">
                            <div class="flex items-center gap-space-sm">
                                <span class="material-symbols-outlined text-primary text-[20px]">info</span>
                                <span class="font-body-sm text-body-sm text-on-surface-variant">
                                    Newly drafted packages undergo automated dry-run testing against synthetic test suites before trainee roster provisioning.
                                </span>
                            </div>
                            <div class="flex items-center gap-space-sm">
                                <button class="px-space-md py-space-xs bg-surface-container-high hover:bg-surface-container-highest text-on-surface rounded font-label-caps text-label-caps transition-colors" onclick="alert('Draft saved to instructor sandbox: Industrial Scenario #AI-102')">
                                    Save Draft Blueprint
                                </button>
                                <button class="px-space-md py-space-xs bg-primary text-on-primary rounded font-label-caps text-label-caps hover:bg-primary-fixed-dim transition-colors font-bold shadow-sm" onclick="publishNewScenario()">
                                    Deploy Industrial Scenario #AI-102
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Inline Micro-interactions Script -->
                <script>
                    function filterRoster() {
                        const search = document.getElementById('roster-search').value.toLowerCase();
                        const stage = document.getElementById('stage-filter').value;
                        const risk = document.getElementById('risk-filter').value;
                        const rows = document.querySelectorAll('#roster-tbody tr');

                        rows.forEach(row => {
                            const text = row.textContent.toLowerCase();
                            const rowStage = row.getAttribute('data-stage') || '';
                            const rowRisk = row.getAttribute('data-risk') || '';

                            const matchesSearch = text.includes(search);
                            const matchesStage = stage === 'ALL' || rowStage === stage;
                            const matchesRisk = risk === 'ALL' || rowRisk === risk;

                            if (matchesSearch && matchesStage && matchesRisk) {
                                row.style.display = '';
                            } else {
                                row.style.display = 'none';
                            }
                        });
                    }

                    function resetFilters() {
                        document.getElementById('roster-search').value = '';
                        document.getElementById('stage-filter').value = 'ALL';
                        document.getElementById('risk-filter').value = 'ALL';
                        filterRoster();
                    }

                    function confirmOverride(candidateName) {
                        if (confirm(`CHIEF INSPECTOR OVERRIDE:\nAre you sure you want to bypass the 0.800 F1 gate for ${candidateName} to allow Stage 09/10 deployment?`)) {
                            alert(`Override granted for ${candidateName}. Audit log recorded under M. Tursunov ID #INSP-01.`);
                        }
                    }

                    function cloneScenarioTemplate() {
                        alert("Template cloned from #AI-024 (Aral Geomatics Churn MVP). Blueprint copied into Draft #AI-102.");
                    }

                    function publishNewScenario() {
                        alert("Industrial Scenario #AI-102 verified: 9 domains validated. Ready for cohort assignment.");
                    }
                </script>
            </div>
        </main>
    </div>

</body>

</html>