<?php
require_once __DIR__ . '/../config/config.php';
apply_perf_headers();
?>
<!DOCTYPE html>

<html class="dark" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="web_dashboard" name="shell-type" />
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&amp;family=IBM+Plex+Mono:wght@400;500;600&amp;family=Inter:wght@400;500;600&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/css/global.css" />
    <link rel="stylesheet" href="css/style.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="js/tailwind.config.js"></script>
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
            <nav class="flex flex-col px-space-sm gap-space-xs" data-active-classes="bg-surface-container text-primary font-semibold shadow-[inset_3px_0_0_#ffb956]"><a class="flex items-center justify-between px-space-md py-space-sm rounded text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors group" data-path="projects" href="../AI Project Management/Dashboard.php">
                    <div class="flex items-center gap-space-sm"><span class="font-label-mono text-label-mono text-outline">01</span><span class="font-body-md text-body-md">Projects</span></div><span class="font-label-caps text-label-caps text-outline group-hover:text-primary">SYS-AI-01</span>
                </a><a class="flex items-center justify-between px-space-md py-space-sm rounded text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors group" data-path="data-center" href="../Data Center/DatasetCatalog.php">
                    <div class="flex items-center gap-space-sm"><span class="font-label-mono text-label-mono text-outline">02</span><span class="font-body-md text-body-md">Data Center</span></div><span class="font-label-caps text-label-caps text-outline group-hover:text-primary">SYS-AI-02</span>
                </a><a class="flex items-center justify-between px-space-md py-space-sm rounded text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors group" data-path="workbench" href="../AI/ML Workbench/WorkbenchHome.php">
                    <div class="flex items-center gap-space-sm"><span class="font-label-mono text-label-mono text-outline">03</span><span class="font-body-md text-body-md">Workbench</span></div><span class="font-label-caps text-label-caps text-outline group-hover:text-primary">SYS-AI-03</span>
                </a><a class="flex items-center justify-between px-space-md py-space-sm rounded bg-surface-container text-primary font-semibold shadow-[inset_3px_0_0_#ffb956] group" data-path="model-registry" href="ModelRegistry.php">
                    <div class="flex items-center gap-space-sm"><span class="font-label-mono text-label-mono text-tertiary">04</span><span class="font-body-md text-body-md">Registry &amp; Deployment</span></div><span class="font-label-caps text-label-caps text-tertiary">SYS-AI-04</span>
                </a><a class="flex items-center justify-between px-space-md py-space-sm rounded text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors group" data-path="ai-soc" href="../AI Operations Center (AI SOC)/FleetTelemetry.php">
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
                    <div class="hidden md:flex items-center gap-1.5 font-label-mono text-label-mono text-outline"><span class="text-on-surface-variant">SYS-AI-04</span><span>/</span><span>Registry</span><span>/</span><span>Models</span><span>/</span><span class="text-tertiary">churn_rf_v2</span><span>/</span><span class="text-on-surface font-semibold">Deployment History &amp; Rollback</span></div>
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
                <nav class="flex items-center gap-space-xs" data-active-classes="bg-surface-container-highest text-primary font-semibold"><a class="font-body-sm text-body-sm px-space-sm py-1 rounded text-on-surface-variant hover:text-on-surface hover:bg-surface-container transition-colors" data-path="model-registry" href="ModelRegistry.php">Model Registry</a><a class="font-body-sm text-body-sm px-space-sm py-1 rounded text-on-surface-variant hover:text-on-surface hover:bg-surface-container transition-colors" data-path="model-card" href="ModelCard.php">Model Card (churn_rf_v2)</a><a class="font-body-sm text-body-sm px-space-sm py-1 rounded text-on-surface-variant hover:text-on-surface hover:bg-surface-container transition-colors" data-path="deployment-wizard" href="DeploymentWizard.php">Deployment Wizard</a><a class="font-body-sm text-body-sm px-space-sm py-1 rounded text-on-surface-variant hover:text-on-surface hover:bg-surface-container transition-colors" data-path="endpoint-console" href="EndpointConsole.php">Endpoint Console (Swagger)</a><a class="font-body-sm text-body-sm px-space-sm py-1 rounded text-on-surface-variant hover:text-on-surface hover:bg-surface-container transition-colors" data-path="enterprise-integrations" href="EnterpriseIntegrations.php">Enterprise Integrations</a><a aria-current="page" class="px-space-sm py-1 rounded transition-colors bg-surface-container-highest text-primary font-semibold" data-path="deployment-history" href="DeploymentHistoryRollback.php">Deploy History &amp; Rollback</a></nav>
            </div>
        </header>
        <main class="relative pt-28 pb-8 px-gutter w-full flex-1 bg-transparent">
            <div class="flex flex-col w-full gap-space-lg">
                <!-- TOP CONTEXT / INDUSTRIAL TELEMETRY HEADER -->
                <div class="w-full bg-surface-container-lowest rounded-xl p-space-md shadow-md flex flex-col xl:flex-row xl:items-center justify-between gap-space-md">
                    <div class="flex flex-col gap-space-xs">
                        <div class="flex flex-wrap items-center gap-space-xs">
                            <span class="font-label-caps text-label-caps bg-tertiary-container text-tertiary px-space-xs py-0.5 rounded tracking-widest">GATEWAY STAGE 11</span>
                            <span class="font-label-mono text-label-mono text-on-surface-variant">TARGET-REF:</span>
                            <span class="font-headline-sm text-headline-sm font-bold text-on-surface tracking-tight">churn_rf_v2</span>
                            <span class="font-label-mono text-label-mono px-2 py-0.5 rounded bg-surface-container-high text-primary font-semibold">@v2.4.0-slim</span>
                            <div class="flex items-center gap-1.5 px-2 py-0.5 rounded bg-surface-container text-secondary font-label-mono text-label-mono">
                                <span class="w-2 h-2 rounded-full bg-tertiary animate-pulse"></span>
                                <span>PRODUCTION LIVE</span>
                            </div>
                        </div>
                        <div class="flex flex-wrap items-center gap-x-space-md gap-y-1 font-label-mono text-label-mono text-outline">
                            <span class="text-on-surface-variant flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px] text-tertiary">fingerprint</span>
                                SHA256: 4b830a91f...20f9
                            </span>
                            <span class="text-outline-variant">|</span>
                            <span>DEPLOYED: Today 14:10:22 UTC</span>
                            <span class="text-outline-variant">|</span>
                            <span class="text-on-surface">AUTHOR: Sarah Chen (#4092)</span>
                            <span class="text-outline-variant">|</span>
                            <span class="text-secondary">CLUSTER: vostok-k8s-prod-eu · NODE: #042-EU-CENTRAL</span>
                        </div>
                    </div>
                    <!-- ACTION BUTTON GROUP -->
                    <div class="flex flex-wrap items-center gap-space-xs">
                        <button class="flex items-center gap-1.5 px-space-md py-1.5 rounded bg-surface-container-high text-on-surface hover:bg-surface-bright transition-colors font-body-sm text-body-sm font-semibold shadow-sm">
                            <span class="material-symbols-outlined text-[16px] text-primary">verified_user</span>
                            <span>Export Audit (GPG/PDF)</span>
                        </button>
                        <button class="flex items-center gap-1.5 px-space-md py-1.5 rounded bg-surface-container text-on-surface-variant hover:text-on-surface hover:bg-surface-container-high transition-colors font-body-sm text-body-sm font-semibold" onclick="toggleDiffMode()">
                            <span class="material-symbols-outlined text-[16px] text-secondary">compare_arrows</span>
                            <span>Compare Revisions</span>
                        </button>
                        <button class="flex items-center gap-1.5 px-space-md py-1.5 rounded bg-error-container text-on-error-container hover:bg-on-error hover:text-error transition-all font-body-sm text-body-sm font-bold shadow-md" onclick="openRollbackModal()">
                            <span class="material-symbols-outlined text-[16px]">history_toggle_off</span>
                            <span>Emergency Rollback to v2.2.0</span>
                        </button>
                    </div>
                </div>
                <!-- BENTO METRIC TELEMETRY RIBBON -->
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-space-sm">
                    <div class="bg-surface-container-low rounded-lg p-space-sm flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <span class="font-label-caps text-label-caps text-outline">INGRESS ROUTE</span>
                            <span class="material-symbols-outlined text-[14px] text-tertiary">swap_calls</span>
                        </div>
                        <div class="font-headline-sm text-headline-sm font-bold text-on-surface mt-1">100% v2.4.0</div>
                        <div class="font-label-mono text-label-mono text-outline text-[10px]">ENVOY MESH · 0% CANARY</div>
                    </div>
                    <div class="bg-surface-container-low rounded-lg p-space-sm flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <span class="font-label-caps text-label-caps text-outline">POD REPLICAS</span>
                            <span class="material-symbols-outlined text-[14px] text-secondary">memory</span>
                        </div>
                        <div class="font-headline-sm text-headline-sm font-bold text-secondary mt-1">3 / 3 RUNNING</div>
                        <div class="font-label-mono text-label-mono text-outline text-[10px]">HPA LIMIT: 8 MAX (MIN 2)</div>
                    </div>
                    <div class="bg-surface-container-low rounded-lg p-space-sm flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <span class="font-label-caps text-label-caps text-outline">P95 LATENCY</span>
                            <span class="material-symbols-outlined text-[14px] text-tertiary">speed</span>
                        </div>
                        <div class="font-headline-sm text-headline-sm font-bold text-tertiary mt-1">18.4ms <span class="text-body-sm text-error font-normal">(+2.2ms)</span></div>
                        <div class="font-label-mono text-label-mono text-outline text-[10px]">SLO TARGET &lt; 20.0ms</div>
                    </div>
                    <div class="bg-surface-container-low rounded-lg p-space-sm flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <span class="font-label-caps text-label-caps text-outline">F1 MACRO SCORE</span>
                            <span class="material-symbols-outlined text-[14px] text-primary">ssid_chart</span>
                        </div>
                        <div class="font-headline-sm text-headline-sm font-bold text-primary mt-1">0.804 <span class="text-body-sm text-secondary font-normal">(+0.023)</span></div>
                        <div class="font-label-mono text-label-mono text-outline text-[10px]">BASELINE: 0.781 (v2.2.0)</div>
                    </div>
                    <div class="bg-surface-container-low rounded-lg p-space-sm flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <span class="font-label-caps text-label-caps text-outline">ERROR DRIFT (422)</span>
                            <span class="material-symbols-outlined text-[14px] text-error">warning</span>
                        </div>
                        <div class="font-headline-sm text-headline-sm font-bold text-error mt-1">0.041% <span class="text-body-sm text-error font-normal">(3x)</span></div>
                        <div class="font-label-mono text-label-mono text-outline text-[10px]">SCHEMA NULL TICKETS INCIDENT</div>
                    </div>
                    <div class="bg-surface-container-low rounded-lg p-space-sm flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <span class="font-label-caps text-label-caps text-outline">ROLLBACK READINESS</span>
                            <span class="material-symbols-outlined text-[14px] text-tertiary">check_circle</span>
                        </div>
                        <div class="font-headline-sm text-headline-sm font-bold text-on-surface mt-1">INSTANT &lt;1.8s</div>
                        <div class="font-label-mono text-label-mono text-outline text-[10px]">v2.2.0 IMAGE PRE-PULLED</div>
                    </div>
                </div>
                <!-- MAIN OPERATIONAL WORKSPACE (2-COLUMN DENSE TELEMETRY + DIFF INSPECTOR) -->
                <div class="grid grid-cols-1 xl:grid-cols-12 gap-space-md">
                    <!-- COLUMN 1: CHRONOLOGICAL RELEASE LEDGER (5 COLS) -->
                    <div class="xl:col-span-5 bg-surface-container-lowest rounded-xl p-space-md flex flex-col gap-space-md shadow-md">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-space-xs">
                                <span class="font-label-caps text-label-caps text-tertiary bg-tertiary-container px-1 rounded">LEDGER</span>
                                <span class="font-headline-sm text-headline-sm font-bold text-on-surface">Release History Timeline</span>
                            </div>
                            <div class="flex items-center gap-1 font-label-mono text-label-mono text-outline">
                                <span>FILTERS:</span>
                                <span class="text-tertiary px-1 rounded bg-surface-container-high cursor-pointer">ALL (4)</span>
                                <span class="hover:text-on-surface px-1 cursor-pointer">PROD ONLY</span>
                            </div>
                        </div>
                        <!-- TIMELINE LIST -->
                        <div class="flex flex-col gap-space-sm relative">
                            <!-- TIMELINE ITEM 1 (CURRENT SERVING v2.4.0) -->
                            <div class="relative bg-surface-container-low rounded-lg p-space-md flex flex-col gap-space-xs transition-all hover:bg-surface-container">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2.5 h-2.5 rounded-full bg-tertiary shadow-[0_0_8px_#ffb956]"></span>
                                        <span class="font-headline-sm text-headline-sm font-bold text-on-surface">v2.4.0</span>
                                        <span class="font-label-caps text-label-caps bg-surface-container-highest text-tertiary px-1.5 py-0.5 rounded">CURRENT SERVING</span>
                                    </div>
                                    <span class="font-label-mono text-label-mono text-on-surface-variant">Today 14:10 UTC</span>
                                </div>
                                <p class="font-body-sm text-body-sm text-primary">
                                    Added <code class="font-code-block text-code-block text-tertiary">support_tickets_30d</code> feature payload &amp; bumped base container to Alpine 3.19. Scaled default worker threads to 4.
                                </p>
                                <div class="grid grid-cols-3 gap-2 bg-surface-container-lowest p-space-xs rounded font-label-mono text-label-mono text-outline">
                                    <div>F1: <span class="text-on-surface font-semibold">0.804</span></div>
                                    <div>P95: <span class="text-tertiary font-semibold">18.4ms</span></div>
                                    <div>PODS: <span class="text-secondary font-semibold">3 Active</span></div>
                                </div>
                                <div class="flex items-center justify-between pt-1">
                                    <div class="flex items-center gap-1.5 font-label-mono text-label-mono text-outline">
                                        <span class="text-on-surface-variant font-semibold">Sarah Chen (#4092)</span>
                                        <span>· CI/CD Tag #908</span>
                                    </div>
                                    <div class="flex items-center gap-1 font-label-mono text-label-mono">
                                        <button class="px-2 py-0.5 rounded bg-surface-container-high text-primary hover:bg-surface-bright">Inspect Diff</button>
                                        <span class="px-2 py-0.5 rounded bg-surface-container text-outline">Active Target</span>
                                    </div>
                                </div>
                            </div>
                            <!-- TIMELINE ITEM 2 (CANARY DECOMMISSIONED v2.3.1) -->
                            <div class="relative bg-surface-container-lowest rounded-lg p-space-md flex flex-col gap-space-xs opacity-75 hover:opacity-100 transition-opacity">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2.5 h-2.5 rounded-full bg-outline"></span>
                                        <span class="font-headline-sm text-headline-sm font-bold text-on-surface">v2.3.1</span>
                                        <span class="font-label-caps text-label-caps bg-surface-container text-outline px-1.5 py-0.5 rounded">CANARY RETIRED</span>
                                    </div>
                                    <span class="font-label-mono text-label-mono text-outline">12 days ago · Feb 06</span>
                                </div>
                                <p class="font-body-sm text-body-sm text-on-surface-variant">
                                    Experimental opt-in gradient boosting booster. Automated canary run terminated due to high latency tail in US-East zone.
                                </p>
                                <div class="grid grid-cols-3 gap-2 bg-surface-container-low p-space-xs rounded font-label-mono text-label-mono text-outline">
                                    <div>F1: <span class="text-on-surface-variant">0.789</span></div>
                                    <div>P95: <span class="text-error">22.1ms</span></div>
                                    <div>PODS: <span class="text-outline">0 Replicas</span></div>
                                </div>
                                <div class="flex items-center justify-between pt-1">
                                    <div class="flex items-center gap-1.5 font-label-mono text-label-mono text-outline">
                                        <span>Auto Canary Pipeline</span>
                                        <span>· digest: sha256:1a8c9</span>
                                    </div>
                                    <button class="font-label-mono text-label-mono px-2 py-0.5 rounded bg-surface-container text-outline hover:text-on-surface" onclick="setDiffTarget('v2.3.1')">Inspect Diff</button>
                                </div>
                            </div>
                            <!-- TIMELINE ITEM 3 (GOLDEN ROLLBACK TARGET v2.2.0) -->
                            <div class="relative bg-surface-container-low rounded-lg p-space-md flex flex-col gap-space-xs transition-all hover:bg-surface-container">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2.5 h-2.5 rounded-full bg-secondary shadow-[0_0_8px_#abc9f2]"></span>
                                        <span class="font-headline-sm text-headline-sm font-bold text-secondary">v2.2.0</span>
                                        <span class="font-label-caps text-label-caps bg-secondary-container text-secondary px-1.5 py-0.5 rounded">GOLDEN ROLLBACK TARGET</span>
                                    </div>
                                    <span class="font-label-mono text-label-mono text-secondary">24 days ago · Jan 25</span>
                                </div>
                                <p class="font-body-sm text-body-sm text-on-surface">
                                    Fully validated baseline weights. Clean Pydantic v1.10 schema compatibility. 0 SLA violations across 4.2M incoming calls.
                                </p>
                                <div class="grid grid-cols-3 gap-2 bg-surface-container-lowest p-space-xs rounded font-label-mono text-label-mono text-secondary">
                                    <div>F1: <span class="font-semibold text-on-surface">0.781</span></div>
                                    <div>P95: <span class="font-semibold text-secondary">16.2ms</span></div>
                                    <div>ERR: <span class="font-semibold text-secondary">0.01%</span></div>
                                </div>
                                <div class="flex items-center justify-between pt-1">
                                    <div class="flex items-center gap-1.5 font-label-mono text-label-mono text-outline">
                                        <span class="text-on-surface">Alexei Morozov (#002)</span>
                                        <span>· GPG ATTESTED</span>
                                    </div>
                                    <div class="flex items-center gap-1 font-label-mono text-label-mono">
                                        <button class="px-2 py-0.5 rounded bg-surface-container text-primary hover:bg-surface-container-high" onclick="setDiffTarget('v2.2.0')">Select for Diff</button>
                                        <button class="px-2 py-0.5 rounded bg-error-container text-on-error-container hover:bg-on-error font-semibold" onclick="openRollbackModal()">Rollback Here</button>
                                    </div>
                                </div>
                            </div>
                            <!-- TIMELINE ITEM 4 (v2.0.0 INITIAL) -->
                            <div class="relative bg-surface-container-lowest rounded-lg p-space-md flex flex-col gap-space-xs opacity-60 hover:opacity-100 transition-opacity">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2.5 h-2.5 rounded-full bg-outline-variant"></span>
                                        <span class="font-headline-sm text-headline-sm font-bold text-outline">v2.0.0</span>
                                        <span class="font-label-caps text-label-caps bg-surface-container text-outline px-1.5 py-0.5 rounded">DEPRECATED</span>
                                    </div>
                                    <span class="font-label-mono text-label-mono text-outline">Jan 10, 2025</span>
                                </div>
                                <p class="font-body-sm text-body-sm text-outline">First Random Forest refactor from legacy logistic churn model.</p>
                                <div class="flex items-center justify-between pt-1 font-label-mono text-label-mono text-outline">
                                    <span>Commit: c398f4e</span>
                                    <button class="px-2 py-0.5 rounded bg-surface-container text-outline hover:text-on-surface" onclick="setDiffTarget('v2.0.0')">Inspect</button>
                                </div>
                            </div>
                        </div>
                        <!-- AUDIT REVISION ATTESTATION BOX -->
                        <div class="bg-surface-container-high rounded-lg p-space-sm flex items-center justify-between gap-space-sm mt-auto">
                            <div class="flex items-center gap-space-xs font-label-mono text-label-mono text-outline">
                                <span class="material-symbols-outlined text-[18px] text-tertiary">key</span>
                                <span>SIGNATURE: 0x89F2...E41C (VERIFIED)</span>
                            </div>
                            <span class="font-label-caps text-label-caps text-secondary bg-secondary-container px-2 py-0.5 rounded">COMPLIANT SYS-AI-05</span>
                        </div>
                    </div>
                    <!-- COLUMN 2: SIDE-BY-SIDE DEEP VERSION DIFF (7 COLS) -->
                    <div class="xl:col-span-7 bg-surface-container-lowest rounded-xl p-space-md flex flex-col gap-space-md shadow-md">
                        <!-- COMPARATIVE SELECTOR HEADER -->
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-space-sm bg-surface-container-low p-space-sm rounded-lg">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary text-[20px]">difference</span>
                                <span class="font-headline-sm text-headline-sm font-bold text-on-surface">Deep Revision Diff Engine</span>
                            </div>
                            <div class="flex items-center gap-space-xs font-label-mono text-label-mono">
                                <span class="text-tertiary bg-tertiary-container px-2 py-1 rounded font-semibold">LIVE: v2.4.0</span>
                                <span class="text-outline">vs</span>
                                <select class="bg-surface-container-highest text-on-surface px-2 py-1 rounded focus:outline-none cursor-pointer" id="diffVersionSelect" onchange="changeDiffSelection(this.value)">
                                    <option selected="" value="v2.2.0">TARGET: v2.2.0 (Golden Baseline)</option>
                                    <option value="v2.3.1">CANDIDATE: v2.3.1 (Canary)</option>
                                    <option value="v2.0.0">ARCHIVE: v2.0.0 (Initial)</option>
                                </select>
                            </div>
                        </div>
                        <!-- DIFF TABS -->
                        <div class="flex items-center gap-space-xs bg-surface-container-high p-1 rounded-lg font-body-sm text-body-sm font-semibold">
                            <button class="flex-1 py-1.5 rounded bg-surface-container text-on-surface shadow-sm text-center transition-colors" id="tabBtnSchema" onclick="switchDiffTab('schema')">
                                Pydantic Schema Contract
                            </button>
                            <button class="flex-1 py-1.5 rounded text-on-surface-variant hover:text-on-surface text-center transition-colors" id="tabBtnK8s" onclick="switchDiffTab('k8s')">
                                Runtime &amp; Kubernetes Specs
                            </button>
                            <button class="flex-1 py-1.5 rounded text-on-surface-variant hover:text-on-surface text-center transition-colors" id="tabBtnPerf" onclick="switchDiffTab('perf')">
                                Performance &amp; SLA Drift
                            </button>
                        </div>
                        <!-- TAB 1 CONTENT: SCHEMA DIFF -->
                        <div class="flex flex-col gap-space-sm" id="diffViewSchema">
                            <div class="flex items-center justify-between text-outline font-label-mono text-label-mono">
                                <span>CONTRACT: CustomerChurnInferenceSchema.py</span>
                                <span class="text-error font-semibold flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px]">report_problem</span>
                                    1 Breaking Field Delta Detected
                                </span>
                            </div>
                            <div class="bg-primary-container rounded-lg p-space-sm font-code-block text-code-block overflow-x-auto flex flex-col gap-1 leading-relaxed">
                                <div class="text-outline">--- v2.2.0/schemas/churn_request.py (STABLE GOLDEN)</div>
                                <div class="text-outline">+++ v2.4.0/schemas/churn_request.py (CURRENT LIVE)</div>
                                <div class="text-outline-variant">@@ -14,8 +14,13 @@ class ChurnPredictionPayload(BaseModel):</div>
                                <div class="text-on-surface"> customer_id: str = Field(..., description="Unique customer GUID")</div>
                                <div class="text-on-surface"> account_tenure_months: int = Field(ge=0, le=240)</div>
                                <div class="text-on-surface"> monthly_bill_amount: float = Field(ge=0.0)</div>
                                <div class="text-on-surface"> contract_type: Literal["MONTHLY", "ONE_YEAR", "TWO_YEAR"]</div>
                                <div class="bg-error-container/30 text-error px-2 py-0.5 rounded flex items-center justify-between">
                                    <span>- has_support_ticket_flag: bool = Field(default=False)</span>
                                    <span class="font-label-mono text-[10px] text-error">DELETED FIELD</span>
                                </div>
                                <div class="bg-secondary-container/40 text-secondary px-2 py-0.5 rounded flex items-center justify-between">
                                    <span>+ support_tickets_30d: int = Field(ge=0, description="Rolling 30-day ticket frequency")</span>
                                    <span class="font-label-mono text-[10px] text-secondary">NEW ADDITION (CAUSES 422 DRIFT)</span>
                                </div>
                                <div class="bg-secondary-container/40 text-secondary px-2 py-0.5 rounded flex items-center justify-between">
                                    <span>+ high_priority_escalations: Optional[int] = Field(default=0)</span>
                                    <span class="font-label-mono text-[10px] text-secondary">OPTIONAL FIELD</span>
                                </div>
                                <div class="text-on-surface"> total_data_usage_gb: float = Field(ge=0.0)</div>
                                <div class="text-on-surface"> payment_method: Literal["CREDIT_CARD", "ACH", "AUTO_PAY"]</div>
                            </div>
                            <div class="bg-surface-container p-space-sm rounded-lg flex items-start gap-space-sm">
                                <span class="material-symbols-outlined text-tertiary text-[20px]">info</span>
                                <div class="flex flex-col font-body-sm text-body-sm text-on-surface-variant">
                                    <span class="font-semibold text-on-surface">Impact Analysis on Consumer Endpoints:</span>
                                    <span>SYS05 CRM Core is currently passing <code class="font-code-block text-tertiary">has_support_ticket_flag</code> boolean instead of integer frequency, generating 422 HTTP validation warnings on 0.04% of raw unmigrated payloads. Rolling back to v2.2.0 restores full binary boolean payload compatibility immediately.</span>
                                </div>
                            </div>
                        </div>
                        <!-- TAB 2 CONTENT: RUNTIME & K8S SPECS (HIDDEN INITIALLY) -->
                        <div class="hidden flex flex-col gap-space-sm" id="diffViewK8s">
                            <div class="flex items-center justify-between text-outline font-label-mono text-label-mono">
                                <span>KUBERNETES MANIFEST: deployment-churn-rf.yaml</span>
                                <span class="text-secondary font-semibold">INFRASTRUCTURE REVISION DIFF</span>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-space-sm font-label-mono text-label-mono">
                                <div class="bg-surface-container-low p-space-sm rounded-lg flex flex-col gap-1.5">
                                    <span class="font-label-caps text-label-caps text-secondary font-bold">CURRENT SERVING (v2.4.0)</span>
                                    <div class="flex justify-between py-1 bg-surface-container rounded px-2"><span>IMAGE:</span><span class="text-on-surface font-code-block">churn_rf:v2.4.0-slim</span></div>
                                    <div class="flex justify-between py-1 bg-surface-container rounded px-2"><span>REPLICAS:</span><span class="text-tertiary font-bold">3 active</span></div>
                                    <div class="flex justify-between py-1 bg-surface-container rounded px-2"><span>CPU REQ/LIM:</span><span class="text-on-surface">500m / 1000m</span></div>
                                    <div class="flex justify-between py-1 bg-surface-container rounded px-2"><span>MEM REQ/LIM:</span><span class="text-error">1.2Gi / 2.0Gi</span></div>
                                    <div class="flex justify-between py-1 bg-surface-container rounded px-2"><span>HPA RANGE:</span><span class="text-on-surface">2 - 8 pods</span></div>
                                </div>
                                <div class="bg-surface-container p-space-sm rounded-lg flex flex-col gap-1.5">
                                    <span class="font-label-caps text-label-caps text-primary font-bold">GOLDEN ROLLBACK TARGET (v2.2.0)</span>
                                    <div class="flex justify-between py-1 bg-surface-container-low rounded px-2"><span>IMAGE:</span><span class="text-primary font-code-block">churn_rf:v2.2.0-slim</span></div>
                                    <div class="flex justify-between py-1 bg-surface-container-low rounded px-2"><span>REPLICAS:</span><span class="text-on-surface">2 nominal</span></div>
                                    <div class="flex justify-between py-1 bg-surface-container-low rounded px-2"><span>CPU REQ/LIM:</span><span class="text-on-surface">400m / 800m</span></div>
                                    <div class="flex justify-between py-1 bg-surface-container-low rounded px-2"><span>MEM REQ/LIM:</span><span class="text-secondary">960Mi / 1.5Gi (-240MB)</span></div>
                                    <div class="flex justify-between py-1 bg-surface-container-low rounded px-2"><span>HPA RANGE:</span><span class="text-on-surface">2 - 6 pods</span></div>
                                </div>
                            </div>
                            <div class="bg-surface-container-low p-space-sm rounded-lg flex items-center justify-between font-label-mono text-label-mono text-outline">
                                <span>K8S NAMESPACE: ml-serving-prod</span>
                                <span class="text-tertiary">ENVOY TRAFFIC DRAIN: GRACEFUL 30 SEC</span>
                            </div>
                        </div>
                        <!-- TAB 3 CONTENT: PERFORMANCE DELTA (HIDDEN INITIALLY) -->
                        <div class="hidden flex flex-col gap-space-sm" id="diffViewPerf">
                            <div class="flex items-center justify-between text-outline font-label-mono text-label-mono">
                                <span>STATISTICAL ENGINE: 10,000 MONTE CARLO SAMPLE COMPARISON</span>
                                <span class="text-primary">BENCHMARK RUN: STAGE-10</span>
                            </div>
                            <div class="grid grid-cols-3 gap-space-sm">
                                <div class="bg-surface-container p-space-sm rounded-lg flex flex-col items-center justify-center text-center">
                                    <span class="font-label-caps text-label-caps text-outline">F1 MACRO ACCURACY</span>
                                    <span class="font-headline-lg text-headline-lg font-bold text-secondary mt-1">+0.023</span>
                                    <span class="font-label-mono text-label-mono text-outline">v2.4.0 is slightly more accurate</span>
                                </div>
                                <div class="bg-surface-container p-space-sm rounded-lg flex flex-col items-center justify-center text-center">
                                    <span class="font-label-caps text-label-caps text-outline">P95 LATENCY TAIL</span>
                                    <span class="font-headline-lg text-headline-lg font-bold text-error mt-1">+2.2ms</span>
                                    <span class="font-label-mono text-label-mono text-outline">Regression under peak load</span>
                                </div>
                                <div class="bg-surface-container p-space-sm rounded-lg flex flex-col items-center justify-center text-center">
                                    <span class="font-label-caps text-label-caps text-outline">PAYLOAD VALIDATION FAIL</span>
                                    <span class="font-headline-lg text-headline-lg font-bold text-error mt-1">4.1x Higher</span>
                                    <span class="font-label-mono text-label-mono text-outline">422 errors due to contract mismatch</span>
                                </div>
                            </div>
                            <!-- INLINE SVG SPARKLINE TELEMETRY -->
                            <div class="bg-surface-container-low p-space-sm rounded-lg flex flex-col gap-1">
                                <div class="flex justify-between font-label-mono text-label-mono text-outline">
                                    <span>HISTORICAL LATENCY TREND (LAST 4 RELEASES)</span>
                                    <span class="text-tertiary">v2.2.0 OPTIMAL</span>
                                </div>
                                <div class="h-20 w-full flex items-center justify-center">
                                    <svg class="w-full h-full text-secondary" preserveaspectratio="none" viewbox="0 0 400 80">
                                        <path class="opacity-40" d="M 0 50 L 80 48 L 160 52 L 240 30 L 320 62 L 400 38" fill="none" stroke="currentColor" stroke-dasharray="2 2" stroke-width="1.5"></path>
                                        <path d="M 0 45 L 80 40 L 160 32 L 240 18 L 320 42 L 400 68" fill="none" stroke="#ffb956" stroke-width="2.5"></path>
                                        <!-- Data Points -->
                                        <circle cx="80" cy="40" fill="#abc9f2" r="3.5"></circle>
                                        <circle cx="240" cy="18" fill="#abc9f2" r="4.5"></circle>
                                        <circle cx="400" cy="68" fill="#ffb4ab" r="4.5"></circle>
                                        <!-- Text annotations -->
                                        <text fill="#abc9f2" font-family="IBM Plex Mono" font-size="9" x="85" y="38">v2.0.0 (20ms)</text>
                                        <text fill="#abc9f2" font-family="IBM Plex Mono" font-size="9" font-weight="bold" x="245" y="16">v2.2.0 (16.2ms - PEAK)</text>
                                        <text fill="#ffb4ab" font-family="IBM Plex Mono" font-size="9" x="320" y="76">v2.4.0 (18.4ms / Spikes)</text>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <!-- IN-LINE ACTION BAR -->
                        <div class="bg-surface-container-high p-space-sm rounded-lg flex flex-wrap items-center justify-between gap-space-sm mt-auto">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-secondary text-[18px]">security_update_warning</span>
                                <span class="font-body-sm text-body-sm text-on-surface">Target rollback artifact is 100% verified and loaded in local Docker edge cache.</span>
                            </div>
                            <button class="px-space-md py-1 rounded bg-tertiary-container text-tertiary hover:bg-tertiary hover:text-on-tertiary font-body-sm text-body-sm font-bold transition-all shadow-sm" onclick="openRollbackModal()">
                                Initiate Reversion Pipeline
                            </button>
                        </div>
                    </div>
                </div>
                <!-- ONE-CLICK ROLLBACK INTERACTIVE SAFETY MODAL (INTERACTIVE DRAWER / CARD) -->
                <div class="hidden w-full bg-surface-container-lowest rounded-xl p-space-lg shadow-xl flex flex-col gap-space-md transition-all" id="rollbackConfirmationModal">
                    <div class="flex items-start justify-between pb-space-xs">
                        <div class="flex items-center gap-space-sm">
                            <div class="w-10 h-10 rounded-lg bg-error-container text-on-error-container flex items-center justify-center">
                                <span class="material-symbols-outlined text-[24px]">history_toggle_off</span>
                            </div>
                            <div class="flex flex-col">
                                <div class="flex items-center gap-2">
                                    <span class="font-headline-lg text-headline-lg font-bold text-on-surface">ROLLBACK EXECUTION GATEWAY</span>
                                    <span class="font-label-caps text-label-caps bg-error-container text-on-error-container px-2 py-0.5 rounded">P0 PRIORITY EVENT</span>
                                </div>
                                <span class="font-label-mono text-label-mono text-outline">Reverting Active Production Serving Pods from v2.4.0 to Golden Target v2.2.0</span>
                            </div>
                        </div>
                        <button class="text-outline hover:text-on-surface p-1 rounded hover:bg-surface-container transition-colors" onclick="closeRollbackModal()">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>
                    <!-- WARNING NOTIFICATION BANNER -->
                    <div class="bg-surface-container-low p-space-md rounded-lg flex flex-col md:flex-row items-start md:items-center justify-between gap-space-md">
                        <div class="flex items-center gap-space-sm">
                            <span class="material-symbols-outlined text-error text-[28px]">crisis_alert</span>
                            <div class="flex flex-col font-body-sm text-body-sm">
                                <span class="font-semibold text-error">CRITICAL TRAFFIC SWAP SIMULATION:</span>
                                <span class="text-on-surface-variant">Active socket sessions will drain gracefully over a 30-second window via Envoy Ingress mesh. Target digest <code class="font-code-block text-tertiary">sha256:88fa2b41</code> will receive 100% of live production inference calls.</span>
                            </div>
                        </div>
                        <div class="font-label-mono text-label-mono text-secondary px-3 py-1.5 rounded bg-surface-container whitespace-nowrap">
                            ESTIMATED DOWNTIME: 0ms
                        </div>
                    </div>
                    <!-- IMPACT SIMULATION 3-POINT CHECKLIST -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-space-sm">
                        <div class="bg-surface-container-low p-space-sm rounded-lg flex flex-col gap-1">
                            <div class="flex items-center justify-between">
                                <span class="font-label-caps text-label-caps text-outline">SCHEMA COMPATIBILITY</span>
                                <span class="material-symbols-outlined text-[16px] text-tertiary">warning</span>
                            </div>
                            <span class="font-body-sm text-body-sm font-semibold text-on-surface">Field Demotion Handled</span>
                            <span class="font-label-mono text-[10px] text-outline">v2.4.0 'support_tickets_30d' dropped. Downstream CRM SYS-05 will ignore return parameter without schema error.</span>
                        </div>
                        <div class="bg-surface-container-low p-space-sm rounded-lg flex flex-col gap-1">
                            <div class="flex items-center justify-between">
                                <span class="font-label-caps text-label-caps text-outline">NETWORK TRAFFIC SHIFT</span>
                                <span class="material-symbols-outlined text-[16px] text-secondary">bolt</span>
                            </div>
                            <span class="font-body-sm text-body-sm font-semibold text-on-surface">100% Instant Swap</span>
                            <span class="font-label-mono text-[10px] text-outline">Envoy route weights: v2.4.0 (100-&gt;0), v2.2.0 (0-&gt;100). Hot standby instances active.</span>
                        </div>
                        <div class="bg-surface-container-low p-space-sm rounded-lg flex flex-col gap-1">
                            <div class="flex items-center justify-between">
                                <span class="font-label-caps text-label-caps text-outline">RESOURCE ALLOCATION</span>
                                <span class="material-symbols-outlined text-[16px] text-primary">eco</span>
                            </div>
                            <span class="font-body-sm text-body-sm font-semibold text-on-surface">-240MB / Pod Savings</span>
                            <span class="font-label-mono text-[10px] text-outline">Recovers 720MB VRAM cluster capacity. Reduces CPU thermal ceiling on #042-EU-CENTRAL.</span>
                        </div>
                    </div>
                    <!-- FORM INPUTS & DUAL SIGN-OFF -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-space-md bg-surface-container p-space-md rounded-lg">
                        <!-- LEFT FORM: REASON & SUPERVISOR KEYS -->
                        <div class="flex flex-col gap-space-sm">
                            <label class="font-label-caps text-label-caps text-outline">1. MANDATORY ROLLBACK JUSTIFICATION</label>
                            <select class="w-full bg-surface-container-low text-on-surface p-2 rounded text-body-sm font-body-sm focus:outline-none">
                                <option selected="">Inference Latency Spike / Pydantic 422 Drift</option>
                                <option>Critical Feature Pipeline Null Mismatch</option>
                                <option>Downstream SYS-AI-05 SOC Alert Trigger</option>
                                <option>Model Weight Prediction Degradation (Manual Override)</option>
                            </select>
                            <div class="flex items-start gap-2 pt-space-xs">
                                <input checked="" class="mt-1 accent-tertiary cursor-pointer" id="dualKeyCheck" type="checkbox" />
                                <label class="font-body-sm text-body-sm text-on-surface cursor-pointer" for="dualKeyCheck">
                                    <span class="font-semibold text-tertiary">Intern Dual-Key Attestation:</span> Require Lead AI Architect digital cosignature (<span class="font-label-mono text-label-mono">Alexei Morozov #002</span>) within 15 minutes of switchover.
                                </label>
                            </div>
                        </div>
                        <!-- RIGHT FORM: TYPE CONFIRMATION & EXECUTE BUTTON -->
                        <div class="flex flex-col gap-space-sm">
                            <label class="font-label-caps text-label-caps text-outline">2. SAFETY CONFIRMATION PHRASE</label>
                            <div class="flex flex-col gap-1">
                                <span class="font-body-sm text-body-sm text-outline">Type <code class="font-code-block text-tertiary font-bold select-all">ROLLBACK-CHURN-2.2.0</code> to authorize:</span>
                                <input class="w-full bg-surface-container-lowest text-on-surface p-2 rounded text-body-sm font-code-block focus:outline-none" id="rollbackInputPhrase" oninput="validateRollbackText(this.value)" placeholder="Type confirmation phrase..." type="text" />
                            </div>
                            <div class="flex items-center justify-end gap-space-xs pt-2">
                                <button class="px-space-md py-2 rounded bg-surface-container-high text-on-surface hover:bg-surface-bright transition-colors font-body-sm text-body-sm font-semibold" onclick="closeRollbackModal()">
                                    Cancel &amp; Keep v2.4.0
                                </button>
                                <button class="px-space-md py-2 rounded bg-error-container text-on-error-container opacity-50 cursor-not-allowed hover:bg-on-error transition-all font-body-sm text-body-sm font-bold flex items-center gap-1.5 shadow-md" disabled="" id="btnExecuteRollback" onclick="executeSimulatedRollback()">
                                    <span class="material-symbols-outlined text-[18px]">verified</span>
                                    <span>Authorize &amp; Execute (P0)</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- BOTTOM SPAN: CRYPTOGRAPHIC RELEASE AUDIT & COMPLIANCE LOG (IMMUTABLE LOG TABLE) -->
                <div class="w-full bg-surface-container-lowest rounded-xl p-space-md flex flex-col gap-space-sm shadow-md">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-space-xs pb-space-xs">
                        <div class="flex items-center gap-space-xs">
                            <span class="font-label-caps text-label-caps bg-secondary-container text-secondary px-1 rounded">SYS-AI-04 // AUDIT</span>
                            <span class="font-headline-sm text-headline-sm font-bold text-on-surface">Cryptographic Release Audit &amp; Compliance Trail</span>
                        </div>
                        <div class="flex items-center gap-space-md font-label-mono text-label-mono text-outline">
                            <span class="flex items-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>SOC LEDGER: SYNCHRONIZED</span>
                            <span>SHA-256 TREE: VERIFIED</span>
                        </div>
                    </div>
                    <!-- HIGH-DENSITY AUDIT TABLE -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-left font-label-mono text-label-mono">
                            <thead class="bg-surface-container-low text-outline uppercase font-label-caps text-label-caps">
                                <tr>
                                    <th class="py-2 px-space-sm">TIMESTAMP (UTC)</th>
                                    <th class="py-2 px-space-sm">EVENT TYPE</th>
                                    <th class="py-2 px-space-sm">ACTOR / SERVICE ACCOUNT</th>
                                    <th class="py-2 px-space-sm">TARGET DIGEST &amp; REPO</th>
                                    <th class="py-2 px-space-sm">GPG STATUS</th>
                                    <th class="py-2 px-space-sm text-right">SOC TELEMETRY</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y-0 text-body-sm font-body-sm">
                                <!-- ROW 1 -->
                                <tr class="hover:bg-surface-container-low transition-colors">
                                    <td class="py-2.5 px-space-sm font-label-mono text-label-mono text-on-surface">2025-02-18 14:10:22</td>
                                    <td class="py-2.5 px-space-sm">
                                        <span class="font-label-caps text-label-caps bg-surface-container text-tertiary px-1.5 py-0.5 rounded">DEPLOY_PROD</span>
                                    </td>
                                    <td class="py-2.5 px-space-sm text-on-surface font-label-mono text-label-mono">sarah.chen@vostok (#4092)</td>
                                    <td class="py-2.5 px-space-sm font-code-block text-code-block text-primary">harbor:sha256:4b830a91f (v2.4.0)</td>
                                    <td class="py-2.5 px-space-sm">
                                        <span class="flex items-center gap-1 text-secondary font-label-mono text-[11px]">
                                            <span class="material-symbols-outlined text-[13px]">check_circle</span>
                                            ATTESTED #89F2A
                                        </span>
                                    </td>
                                    <td class="py-2.5 px-space-sm text-right font-label-mono text-label-mono text-tertiary">SYS-AI-05 SYNC</td>
                                </tr>
                                <!-- ROW 2 -->
                                <tr class="hover:bg-surface-container-low transition-colors">
                                    <td class="py-2.5 px-space-sm font-label-mono text-label-mono text-outline">2025-02-18 13:55:10</td>
                                    <td class="py-2.5 px-space-sm">
                                        <span class="font-label-caps text-label-caps bg-surface-container text-secondary px-1.5 py-0.5 rounded">STAGE10_VALIDATION</span>
                                    </td>
                                    <td class="py-2.5 px-space-sm text-outline font-label-mono text-label-mono">k8s-operator.mlops</td>
                                    <td class="py-2.5 px-space-sm font-code-block text-code-block text-outline">git:commit:3c9e40f</td>
                                    <td class="py-2.5 px-space-sm">
                                        <span class="flex items-center gap-1 text-outline font-label-mono text-[11px]">
                                            <span class="material-symbols-outlined text-[13px]">verified</span>
                                            PASSED (100% SUITE)
                                        </span>
                                    </td>
                                    <td class="py-2.5 px-space-sm text-right font-label-mono text-label-mono text-outline">RECORDED</td>
                                </tr>
                                <!-- ROW 3 -->
                                <tr class="hover:bg-surface-container-low transition-colors">
                                    <td class="py-2.5 px-space-sm font-label-mono text-label-mono text-outline">2025-02-06 09:22:41</td>
                                    <td class="py-2.5 px-space-sm">
                                        <span class="font-label-caps text-label-caps bg-surface-container text-outline px-1.5 py-0.5 rounded">CANARY_TERMINATE</span>
                                    </td>
                                    <td class="py-2.5 px-space-sm text-outline font-label-mono text-label-mono">system.auto-circuit-breaker</td>
                                    <td class="py-2.5 px-space-sm font-code-block text-code-block text-outline">harbor:sha256:1a8c909b (v2.3.1)</td>
                                    <td class="py-2.5 px-space-sm">
                                        <span class="flex items-center gap-1 text-outline font-label-mono text-[11px]">
                                            <span class="material-symbols-outlined text-[13px]">lock_reset</span>
                                            REVOKED (P95 VIOLATION)
                                        </span>
                                    </td>
                                    <td class="py-2.5 px-space-sm text-right font-label-mono text-label-mono text-error">ALARM ARCHIVED</td>
                                </tr>
                                <!-- ROW 4 -->
                                <tr class="hover:bg-surface-container-low transition-colors">
                                    <td class="py-2.5 px-space-sm font-label-mono text-label-mono text-outline">2025-01-25 18:04:19</td>
                                    <td class="py-2.5 px-space-sm">
                                        <span class="font-label-caps text-label-caps bg-secondary-container text-secondary px-1.5 py-0.5 rounded">GOLDEN_PROMOTE</span>
                                    </td>
                                    <td class="py-2.5 px-space-sm text-on-surface font-label-mono text-label-mono">alexei.morozov (#002)</td>
                                    <td class="py-2.5 px-space-sm font-code-block text-code-block text-secondary">harbor:sha256:88fa2b41 (v2.2.0)</td>
                                    <td class="py-2.5 px-space-sm">
                                        <span class="flex items-center gap-1 text-secondary font-label-mono text-[11px]">
                                            <span class="material-symbols-outlined text-[13px]">verified_user</span>
                                            SIGNED_ROOT_CERT
                                        </span>
                                    </td>
                                    <td class="py-2.5 px-space-sm text-right font-label-mono text-label-mono text-secondary">IMMUTABLE ANCHOR</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- INTERACTIVE CLIENT-SIDE BEHAVIOR -->
                
            </div>
        </main>
        <footer class="w-full h-8 bg-surface-container-lowest flex items-center justify-between px-gutter z-30 shadow-[0_-2px_10px_rgba(0,15,33,0.5)]">
            <div class="flex items-center gap-space-md font-label-mono text-label-mono text-outline"><span class="flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-tertiary"></span><span class="text-on-surface">SYS-AI-04 DAEMON: ONLINE</span></span><span>|</span><span>LATENCY: 24ms</span><span>|</span><span>CLUSTER: vostok-k8s-prod-eu</span><span>|</span><span>DOCKER REGISTRY: harbor.vostok.internal</span></div>
            <div class="flex items-center gap-space-sm font-label-mono text-label-mono text-outline"><span>STATION-NODE: #042-DE</span><span>SEC: LEVEL-4 CLASSIFIED</span></div>
        </footer>
    </div>
    <script src="../assets/js/app.js"></script>
    <script src="js/main.js"></script>
</body>

</html>