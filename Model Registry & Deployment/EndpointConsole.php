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
                </a><a class="flex items-center justify-between px-space-md py-space-sm rounded text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors group" data-path="model-registry" href="ModelRegistry.php">
                    <div class="flex items-center gap-space-sm"><span class="font-label-mono text-label-mono text-outline">04</span><span class="font-body-md text-body-md">Registry &amp; Deployment</span></div><span class="font-label-caps text-label-caps text-outline group-hover:text-primary">SYS-AI-04</span>
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
                <nav class="flex items-center gap-space-xs" data-active-classes="bg-surface-container-highest text-primary font-semibold"><a class="font-body-sm text-body-sm px-space-sm py-1 rounded text-on-surface-variant hover:text-on-surface hover:bg-surface-container transition-colors" data-path="model-registry" href="ModelRegistry.php">Model Registry</a><a class="font-body-sm text-body-sm px-space-sm py-1 rounded text-on-surface-variant hover:text-on-surface hover:bg-surface-container transition-colors" data-path="model-card" href="ModelCard.php">Model Card (churn_rf_v2)</a><a class="font-body-sm text-body-sm px-space-sm py-1 rounded text-on-surface-variant hover:text-on-surface hover:bg-surface-container transition-colors" data-path="deployment-wizard" href="DeploymentWizard.php">Deployment Wizard</a><a class="font-body-sm text-body-sm px-space-sm py-1 rounded text-on-surface-variant hover:text-on-surface hover:bg-surface-container transition-colors" data-path="endpoint-console" href="EndpointConsole.php">Endpoint Console (Swagger)</a><a class="font-body-sm text-body-sm px-space-sm py-1 rounded text-on-surface-variant hover:text-on-surface hover:bg-surface-container transition-colors" data-path="integrations" href="EnterpriseIntegrations.php">Enterprise Integrations</a><a class="font-body-sm text-body-sm px-space-sm py-1 rounded text-on-surface-variant hover:text-on-surface hover:bg-surface-container transition-colors" data-path="releases-rollback" href="DeploymentHistoryRollback.php">Releases &amp; Rollback</a></nav>
            </div>
        </header>
        <main class="relative pt-28 pb-8 px-gutter w-full flex-1 bg-transparent">
            <div class="flex flex-col w-full">
                <!-- BREADCRUMB & METADATA RIBBON -->
                <div class="flex flex-col md:flex-row md:items-center justify-between pb-space-sm gap-space-sm">
                    <div class="flex items-center flex-wrap gap-space-xs font-label-mono text-label-mono text-outline">
                        <span class="text-tertiary">SYS-AI-04</span>
                        <span>/</span>
                        <span class="hover:text-on-surface cursor-pointer">Registry</span>
                        <span>/</span>
                        <span class="hover:text-on-surface cursor-pointer">Models</span>
                        <span>/</span>
                        <span class="bg-surface-container-high px-1.5 py-0.5 rounded text-on-surface">churn_rf_v2 @ v2.4.0</span>
                        <span>/</span>
                        <span class="text-secondary font-semibold flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
                            ENDPOINT-CONSOLE-LIVE
                        </span>
                    </div>
                    <!-- QUICK ACTIONS -->
                    <div class="flex items-center flex-wrap gap-space-xs">
                        <button class="flex items-center gap-1.5 px-space-sm py-1 bg-surface-container-high hover:bg-surface-container-highest text-on-surface text-body-sm font-body-sm rounded shadow-sm transition-colors" onclick="navigator.clipboard.writeText('curl -X POST https://api.vostok.internal/v1/models/churn_rf_v2/predict -H \'Content-Type: application/json\'')">
                            <span class="material-symbols-outlined text-[15px] text-tertiary">terminal</span>
                            <span>Copy cURL</span>
                        </button>
                        <button class="flex items-center gap-1.5 px-space-sm py-1 bg-surface-container-high hover:bg-surface-container-highest text-on-surface text-body-sm font-body-sm rounded shadow-sm transition-colors">
                            <span class="material-symbols-outlined text-[15px] text-primary">download</span>
                            <span>Postman</span>
                        </button>
                        <button class="flex items-center gap-1.5 px-space-sm py-1 bg-surface-container-high hover:bg-surface-container-highest text-on-surface text-body-sm font-body-sm rounded shadow-sm transition-colors">
                            <span class="material-symbols-outlined text-[15px] text-outline">code</span>
                            <span>OpenAPI 3.1</span>
                        </button>
                        <button class="flex items-center gap-1 px-space-sm py-1 bg-tertiary-container hover:bg-tertiary/20 text-tertiary text-body-sm font-body-sm rounded transition-colors">
                            <span class="material-symbols-outlined text-[15px]">key</span>
                            <span>Rotate Token</span>
                        </button>
                    </div>
                </div>
                <!-- INGRESS TARGET STATUS BANNER -->
                <div class="bg-surface-container-lowest rounded-xl p-space-sm mb-space-md shadow-md">
                    <div class="flex flex-wrap items-center justify-between gap-space-sm font-label-mono text-label-mono">
                        <div class="flex items-center flex-wrap gap-space-sm">
                            <div class="flex items-center gap-1.5 bg-surface-container-high px-2 py-0.5 rounded">
                                <span class="text-outline uppercase text-[10px]">INGRESS TARGET</span>
                                <span class="text-tertiary font-semibold">https://api.vostok.internal/v1/models/churn_rf_v2:predict</span>
                            </div>
                            <div class="flex items-center gap-1.5 bg-surface-container px-2 py-0.5 rounded text-outline">
                                <span>MESH: Envoy / Istio v1.20</span>
                            </div>
                            <div class="flex items-center gap-1.5 bg-surface-container px-2 py-0.5 rounded text-outline">
                                <span>CLUSTER: k8s-prod-eu-west1:ai-serving</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-secondary"></span>
                            <span class="text-secondary font-semibold">INGRESS HEALTHY (p95: 18.4ms)</span>
                            <span class="bg-surface-container-high px-1.5 py-0.5 rounded text-outline">MTLS ACTIVE</span>
                        </div>
                    </div>
                </div>
                <!-- 2-COLUMN BALANCED BENTO LAYOUT -->
                <div class="grid grid-cols-1 xl:grid-cols-12 gap-space-md">
                    <!-- ================= LEFT COLUMN: REQUEST ORCHESTRATION & SCHEMA ================= -->
                    <div class="xl:col-span-6 flex flex-col gap-space-md">
                        <!-- 1. ENDPOINT URL & AUTH WELL -->
                        <div class="bg-surface-container-low rounded-xl p-space-md shadow-md flex flex-col gap-space-md">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="font-label-caps text-label-caps text-outline uppercase">[SYS-AI // 04.A1]</span>
                                    <span class="font-headline-sm text-headline-sm text-on-surface">Target Dispatch Configuration</span>
                                </div>
                                <span class="font-label-mono text-label-mono text-tertiary bg-tertiary-container px-1.5 py-0.5 rounded">LIVE INGRESS</span>
                            </div>
                            <!-- URL Input Group -->
                            <div class="flex items-stretch rounded bg-surface-container-lowest overflow-hidden shadow-inner">
                                <span class="bg-secondary text-on-secondary font-label-caps text-label-caps tracking-widest px-3 flex items-center font-bold">
                                    POST
                                </span>
                                <input class="w-full bg-transparent px-3 py-2 text-on-surface font-label-mono text-body-sm focus:outline-none" readonly="" type="text" value="https://api.vostok.internal/v1/models/churn_rf_v2/predict" />
                                <button class="px-3 hover:bg-surface-container text-outline hover:text-on-surface transition-colors flex items-center" onclick="navigator.clipboard.writeText('https://api.vostok.internal/v1/models/churn_rf_v2/predict')" title="Copy Endpoint URI">
                                    <span class="material-symbols-outlined text-[18px]">content_copy</span>
                                </button>
                            </div>
                            <!-- Auth Block -->
                            <div class="bg-surface-container rounded-lg p-space-sm flex flex-col gap-1.5">
                                <div class="flex items-center justify-between text-label-mono font-label-mono">
                                    <div class="flex items-center gap-1.5 text-outline">
                                        <span class="material-symbols-outlined text-[15px] text-tertiary">lock</span>
                                        <span class="text-on-surface">Authorization: Bearer Token</span>
                                    </div>
                                    <span class="text-tertiary">Scope: inference:execute · 14d</span>
                                </div>
                                <div class="flex items-center justify-between gap-space-sm bg-surface-container-lowest px-2.5 py-1.5 rounded">
                                    <span class="font-label-mono text-label-mono text-outline tracking-wider" id="bearer-token-text">vstk_live_sec_9942a8b••••••••••••••••••••</span>
                                    <div class="flex items-center gap-1">
                                        <button class="text-outline hover:text-on-surface p-1 rounded hover:bg-surface-container transition-colors" onclick="toggleTokenMask()" title="Toggle visibility">
                                            <span class="material-symbols-outlined text-[16px]" id="eye-icon">visibility</span>
                                        </button>
                                        <span class="font-label-caps text-label-caps bg-surface-container-high text-primary px-1.5 py-0.5 rounded">LEVEL-2-ENG</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Headers Accordion -->
                            <details class="group bg-surface-container rounded-lg overflow-hidden">
                                <summary class="flex items-center justify-between px-space-sm py-2 cursor-pointer select-none text-on-surface-variant hover:text-on-surface hover:bg-surface-container-high transition-colors">
                                    <div class="flex items-center gap-2 font-label-mono text-label-mono">
                                        <span class="material-symbols-outlined text-[16px] text-outline group-open:rotate-90 transition-transform">chevron_right</span>
                                        <span>HTTP Headers (3 active injection keys)</span>
                                    </div>
                                    <span class="font-label-caps text-label-caps text-outline bg-surface-container-lowest px-1.5 py-0.5 rounded">AUTO-MUTATE</span>
                                </summary>
                                <div class="p-space-sm bg-surface-container-lowest font-label-mono text-label-mono flex flex-col gap-1.5">
                                    <div class="flex items-center justify-between py-1 px-2 rounded bg-surface-container">
                                        <span class="text-outline">Content-Type</span>
                                        <span class="text-secondary font-semibold">application/json</span>
                                    </div>
                                    <div class="flex items-center justify-between py-1 px-2 rounded bg-surface-container">
                                        <span class="text-outline">X-Request-ID</span>
                                        <span class="text-on-surface">req_882f019b-004a-471a</span>
                                    </div>
                                    <div class="flex items-center justify-between py-1 px-2 rounded bg-surface-container">
                                        <span class="text-outline">X-Client-System</span>
                                        <span class="text-tertiary">SYS-05-CRM-CORE</span>
                                    </div>
                                </div>
                            </details>
                        </div>
                        <!-- 2. REQUEST BODY EDITOR (Monaco Style) -->
                        <div class="bg-surface-container-low rounded-xl p-space-md shadow-md flex flex-col gap-space-sm">
                            <div class="flex items-center justify-between flex-wrap gap-2">
                                <div class="flex items-center gap-2">
                                    <span class="font-label-caps text-label-caps text-outline uppercase">[SYS-AI // 04.A2]</span>
                                    <span class="font-headline-sm text-headline-sm text-on-surface">Request Payload Buffer</span>
                                </div>
                                <span class="font-label-mono text-label-mono text-error flex items-center gap-1 bg-error-container/40 px-2 py-0.5 rounded">
                                    <span class="w-1.5 h-1.5 rounded-full bg-error"></span>
                                    3 Schema Lint Warnings
                                </span>
                            </div>
                            <!-- Preset Selection Tabs -->
                            <div class="flex items-center gap-1 bg-surface-container-lowest p-1 rounded-lg font-label-mono text-label-mono overflow-x-auto">
                                <button class="px-2.5 py-1 rounded text-outline hover:text-on-surface hover:bg-surface-container transition-colors whitespace-nowrap" id="tab-valid-low" onclick="loadPreset('valid-low')">
                                    Valid (Low Churn)
                                </button>
                                <button class="px-2.5 py-1 rounded text-outline hover:text-on-surface hover:bg-surface-container transition-colors whitespace-nowrap" id="tab-valid-high" onclick="loadPreset('valid-high')">
                                    Valid (High Churn Alert)
                                </button>
                                <button class="px-2.5 py-1 rounded bg-surface-container text-tertiary font-semibold shadow-sm whitespace-nowrap flex items-center gap-1" id="tab-invalid-422" onclick="loadPreset('invalid-422')">
                                    <span class="w-1.5 h-1.5 rounded-full bg-tertiary"></span>
                                    Invalid Payload (422 Demo)
                                </button>
                            </div>
                            <!-- Monaco / Code Canvas Editor -->
                            <div class="relative bg-surface-container-lowest rounded-lg p-2.5 font-code-block text-code-block overflow-hidden shadow-inner">
                                <div class="flex">
                                    <!-- Line Numbers with Lint Indicators -->
                                    <div class="flex flex-col text-outline-variant pr-3 text-right select-none font-label-mono text-[12px] leading-6">
                                        <span>01</span>
                                        <span>02</span>
                                        <span class="text-error font-bold flex items-center justify-end gap-1">
                                            <span class="material-symbols-outlined text-[13px]">warning</span>03
                                        </span>
                                        <span class="text-error font-bold flex items-center justify-end gap-1">
                                            <span class="material-symbols-outlined text-[13px]">warning</span>04
                                        </span>
                                        <span>05</span>
                                        <span class="text-error font-bold flex items-center justify-end gap-1">
                                            <span class="material-symbols-outlined text-[13px]">warning</span>06
                                        </span>
                                        <span>07</span>
                                        <span class="text-error font-bold flex items-center justify-end gap-1">
                                            <span class="material-symbols-outlined text-[13px]">warning</span>08
                                        </span>
                                        <span>09</span>
                                    </div>
                                    <!-- Code Text Lines -->
                                    <div class="flex-1 flex flex-col leading-6 font-code-block text-[12px] overflow-x-auto text-on-surface" id="code-canvas">
                                        <div><span class="text-outline">{</span></div>
                                        <div class="pl-4"><span class="text-primary">"customer_id"</span><span class="text-outline">:</span> <span class="text-secondary">"CUST-8921-A"</span><span class="text-outline">,</span></div>
                                        <div class="pl-4 bg-error-container/20 rounded px-1 -mx-1"><span class="text-primary">"tenure_months"</span><span class="text-outline">:</span> <span class="text-error font-bold">-5</span><span class="text-outline">,</span> <span class="text-error text-[10px] font-label-mono ml-2">/* Pydantic: ge=0 constraint violated */</span></div>
                                        <div class="pl-4 bg-error-container/20 rounded px-1 -mx-1"><span class="text-primary">"monthly_charges"</span><span class="text-outline">:</span> <span class="text-error font-bold">"ONE_HUNDRED_DOLLARS"</span><span class="text-outline">,</span> <span class="text-error text-[10px] font-label-mono ml-2">/* Pydantic: unable to parse string as float */</span></div>
                                        <div class="pl-4"><span class="text-primary">"total_charges"</span><span class="text-outline">:</span> <span class="text-tertiary">null</span><span class="text-outline">,</span></div>
                                        <div class="pl-4 bg-error-container/20 rounded px-1 -mx-1"><span class="text-primary">"contract_type"</span><span class="text-outline">:</span> <span class="text-error font-bold">"three-year"</span><span class="text-outline">,</span> <span class="text-error text-[10px] font-label-mono ml-2">/* Pydantic: literal not in enum */</span></div>
                                        <div class="pl-4"><span class="text-primary">"support_tickets_30d"</span><span class="text-outline">:</span> <span class="text-tertiary">14</span><span class="text-outline">,</span></div>
                                        <div class="pl-4 bg-error-container/20 rounded px-1 -mx-1"><span class="text-primary">"payment_method"</span><span class="text-outline">:</span> <span class="text-error font-bold">"crypto_wallet"</span> <span class="text-error text-[10px] font-label-mono ml-2">/* Pydantic: unsupported payment method */</span></div>
                                        <div><span class="text-outline">}</span></div>
                                    </div>
                                </div>
                            </div>
                            <!-- Editor Toolbar & Trigger CTA -->
                            <div class="flex items-center justify-between pt-1">
                                <div class="flex items-center gap-space-xs">
                                    <button class="px-2 py-1 bg-surface-container text-outline hover:text-on-surface font-label-mono text-label-mono rounded hover:bg-surface-container-high transition-colors">Format JSON</button>
                                    <button class="px-2 py-1 bg-surface-container text-outline hover:text-on-surface font-label-mono text-label-mono rounded hover:bg-surface-container-high transition-colors">Reset Defaults</button>
                                </div>
                                <button class="flex items-center gap-2 px-space-md py-1.5 bg-tertiary text-on-tertiary font-headline-sm text-body-sm font-bold rounded shadow-lg hover:brightness-110 active:scale-95 transition-all" id="send-request-btn" onclick="executeMockDispatch()">
                                    <span class="material-symbols-outlined text-[18px]">bolt</span>
                                    <span>Send Test Request</span>
                                    <span class="bg-on-tertiary/20 text-on-tertiary px-1 py-0.2 rounded font-label-mono text-[10px]">⌘ Enter</span>
                                </button>
                            </div>
                        </div>
                        <!-- 3. PYDANTIC V2 SCHEMA DRAWER -->
                        <div class="bg-surface-container-low rounded-xl p-space-md shadow-md flex flex-col gap-space-sm">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="font-label-caps text-label-caps text-outline uppercase">[SYS-AI // 04.A3]</span>
                                    <span class="font-headline-sm text-headline-sm text-on-surface">Pydantic v2 Contract Reference</span>
                                </div>
                                <span class="font-label-mono text-label-mono text-secondary bg-surface-container-high px-2 py-0.5 rounded">CustomerChurnFeatures (Strict)</span>
                            </div>
                            <!-- Schema Field Table -->
                            <div class="overflow-x-auto rounded-lg bg-surface-container-lowest">
                                <table class="w-full text-left font-label-mono text-label-mono">
                                    <thead>
                                        <tr class="text-outline font-label-caps text-[10px] bg-surface-container">
                                            <th class="py-2 px-3">FIELD</th>
                                            <th class="py-2 px-3">TYPE</th>
                                            <th class="py-2 px-3">VALIDATION CONSTRAINTS</th>
                                            <th class="py-2 px-3 text-right">DEFAULT</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-body-sm divide-y divide-surface-container/40">
                                        <tr class="hover:bg-surface-container/50">
                                            <td class="py-2 px-3 font-semibold text-primary">customer_id</td>
                                            <td class="py-2 px-3 text-secondary">str</td>
                                            <td class="py-2 px-3 text-outline">regex: ^CUST-[0-9]{4}-[A-Z]$</td>
                                            <td class="py-2 px-3 text-right text-outline">required</td>
                                        </tr>
                                        <tr class="hover:bg-surface-container/50">
                                            <td class="py-2 px-3 font-semibold text-primary">tenure_months</td>
                                            <td class="py-2 px-3 text-secondary">int</td>
                                            <td class="py-2 px-3 text-tertiary">ge=0, le=120</td>
                                            <td class="py-2 px-3 text-right text-outline">required</td>
                                        </tr>
                                        <tr class="hover:bg-surface-container/50">
                                            <td class="py-2 px-3 font-semibold text-primary">monthly_charges</td>
                                            <td class="py-2 px-3 text-secondary">float</td>
                                            <td class="py-2 px-3 text-tertiary">ge=0.0, le=1500.0</td>
                                            <td class="py-2 px-3 text-right text-outline">required</td>
                                        </tr>
                                        <tr class="hover:bg-surface-container/50">
                                            <td class="py-2 px-3 font-semibold text-primary">total_charges</td>
                                            <td class="py-2 px-3 text-secondary">Optional[float]</td>
                                            <td class="py-2 px-3 text-outline">Median Imputation Fallback</td>
                                            <td class="py-2 px-3 text-right text-tertiary">null</td>
                                        </tr>
                                        <tr class="hover:bg-surface-container/50">
                                            <td class="py-2 px-3 font-semibold text-primary">contract_type</td>
                                            <td class="py-2 px-3 text-secondary">Literal</td>
                                            <td class="py-2 px-3 text-outline">["month-to-month", "one-year", "two-year"]</td>
                                            <td class="py-2 px-3 text-right text-outline">required</td>
                                        </tr>
                                        <tr class="hover:bg-surface-container/50">
                                            <td class="py-2 px-3 font-semibold text-primary">payment_method</td>
                                            <td class="py-2 px-3 text-secondary">Literal</td>
                                            <td class="py-2 px-3 text-outline">["bank_transfer", "credit_card", "electronic_check", "mailed_check"]</td>
                                            <td class="py-2 px-3 text-right text-outline">required</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- ================= RIGHT COLUMN: RESPONSE INSPECTOR & DIAGNOSTICS ================= -->
                    <div class="xl:col-span-6 flex flex-col gap-space-md">
                        <!-- 1. LIVE RESPONSE STATUS HEADER -->
                        <div class="bg-surface-container-low rounded-xl p-space-md shadow-md flex flex-col gap-space-md">
                            <div class="flex items-center justify-between flex-wrap gap-2">
                                <div class="flex items-center gap-2">
                                    <span class="font-label-caps text-label-caps text-outline uppercase">[SYS-AI // 04.B1]</span>
                                    <span class="font-headline-sm text-headline-sm text-on-surface">Inspection Buffer</span>
                                </div>
                                <!-- RESPONSE STATUS BADGE -->
                                <div class="flex items-center gap-1.5 px-3 py-1 bg-error-container text-error rounded-full font-label-mono text-label-mono font-bold shadow-sm" id="status-badge">
                                    <span class="w-2 h-2 rounded-full bg-error animate-ping"></span>
                                    <span>422 Unprocessable Entity</span>
                                </div>
                            </div>
                            <!-- Telemetry Chips -->
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-space-xs font-label-mono text-label-mono">
                                <div class="bg-surface-container-lowest p-2 rounded flex flex-col">
                                    <span class="text-outline text-[10px]">ROUNDTRIP LATENCY</span>
                                    <span class="text-tertiary font-semibold text-body-sm">12.4ms (Fast-Fail)</span>
                                </div>
                                <div class="bg-surface-container-lowest p-2 rounded flex flex-col">
                                    <span class="text-outline text-[10px]">PAYLOAD SIZE</span>
                                    <span class="text-on-surface font-semibold text-body-sm">642 B</span>
                                </div>
                                <div class="bg-surface-container-lowest p-2 rounded flex flex-col">
                                    <span class="text-outline text-[10px]">RUNNING DAEMON</span>
                                    <span class="text-on-surface font-semibold text-body-sm">uvicorn/fastapi</span>
                                </div>
                                <div class="bg-surface-container-lowest p-2 rounded flex flex-col">
                                    <span class="text-outline text-[10px]">TRACE CORRELATION</span>
                                    <span class="text-secondary font-semibold text-body-sm">trace-8f2c-e01a</span>
                                </div>
                            </div>
                            <!-- Response View Selector Tabs -->
                            <div class="flex items-center justify-between border-b border-surface-container pb-2">
                                <div class="flex items-center gap-1 font-label-mono text-label-mono">
                                    <button class="px-2.5 py-1 rounded bg-surface-container-high text-primary font-semibold" id="tab-resp-json" onclick="setResponseView('json')">JSON Body</button>
                                    <button class="px-2.5 py-1 rounded text-outline hover:text-on-surface transition-colors" id="tab-resp-headers" onclick="setResponseView('headers')">Headers (8)</button>
                                    <button class="px-2.5 py-1 rounded text-outline hover:text-on-surface transition-colors" id="tab-resp-raw" onclick="setResponseView('raw')">Raw Stream</button>
                                    <button class="px-2.5 py-1 rounded text-outline hover:text-on-surface transition-colors flex items-center gap-1" id="tab-resp-soc" onclick="setResponseView('soc')">
                                        <span class="w-1.5 h-1.5 rounded-full bg-error"></span>
                                        SYS-05 SOC Incident
                                    </button>
                                </div>
                                <button class="text-outline hover:text-on-surface text-label-mono font-label-mono flex items-center gap-1" onclick="navigator.clipboard.writeText(document.getElementById('response-body-viewer').innerText)">
                                    <span class="material-symbols-outlined text-[14px]">content_copy</span>
                                    <span>Copy</span>
                                </button>
                            </div>
                            <!-- 2. STRUCTURED RFC-7807 ERROR INSPECTOR -->
                            <div class="flex flex-col gap-space-sm" id="rfc-error-container">
                                <!-- Summary Banner -->
                                <div class="bg-error-container/30 border-l-4 border-error p-space-sm rounded-r flex items-start gap-space-sm">
                                    <span class="material-symbols-outlined text-error text-[20px] mt-0.5">error_circle_rounded</span>
                                    <div class="flex flex-col">
                                        <span class="font-headline-sm text-body-sm text-on-surface font-semibold">3 validation errors detected in request payload</span>
                                        <span class="font-label-mono text-label-mono text-error">Contract violation against schema `CustomerChurnFeatures:v2.4.0`. Model invocation aborted prior to inference tensor allocation.</span>
                                    </div>
                                </div>
                                <!-- Discrete Error Callout Cards -->
                                <div class="grid grid-cols-1 gap-space-xs font-label-mono text-label-mono">
                                    <!-- Error 1 -->
                                    <div class="bg-surface-container-lowest p-space-sm rounded-lg flex flex-col gap-1 shadow-sm">
                                        <div class="flex items-center justify-between">
                                            <span class="text-error font-semibold flex items-center gap-1">
                                                <span class="material-symbols-outlined text-[14px]">close</span>
                                                loc: ["body", "tenure_months"]
                                            </span>
                                            <span class="bg-surface-container px-1.5 py-0.5 rounded text-outline text-[10px]">greater_than_equal</span>
                                        </div>
                                        <div class="flex items-center gap-space-md text-on-surface-variant text-[11px] mt-0.5">
                                            <div>Input Value: <span class="text-error font-bold">-5</span></div>
                                            <div>Constraint: <span class="text-tertiary">ge = 0</span></div>
                                        </div>
                                        <p class="text-on-surface text-body-sm font-body-sm mt-0.5">Input should be greater than or equal to 0</p>
                                    </div>
                                    <!-- Error 2 -->
                                    <div class="bg-surface-container-lowest p-space-sm rounded-lg flex flex-col gap-1 shadow-sm">
                                        <div class="flex items-center justify-between">
                                            <span class="text-error font-semibold flex items-center gap-1">
                                                <span class="material-symbols-outlined text-[14px]">close</span>
                                                loc: ["body", "monthly_charges"]
                                            </span>
                                            <span class="bg-surface-container px-1.5 py-0.5 rounded text-outline text-[10px]">float_parsing</span>
                                        </div>
                                        <div class="flex items-center gap-space-md text-on-surface-variant text-[11px] mt-0.5">
                                            <div>Input Value: <span class="text-error font-bold">"ONE_HUNDRED_DOLLARS"</span></div>
                                            <div>Expected: <span class="text-secondary">float / decimal</span></div>
                                        </div>
                                        <p class="text-on-surface text-body-sm font-body-sm mt-0.5">Input should be a valid number, unable to parse string as float</p>
                                    </div>
                                    <!-- Error 3 -->
                                    <div class="bg-surface-container-lowest p-space-sm rounded-lg flex flex-col gap-1 shadow-sm">
                                        <div class="flex items-center justify-between">
                                            <span class="text-error font-semibold flex items-center gap-1">
                                                <span class="material-symbols-outlined text-[14px]">close</span>
                                                loc: ["body", "contract_type"]
                                            </span>
                                            <span class="bg-surface-container px-1.5 py-0.5 rounded text-outline text-[10px]">literal_error</span>
                                        </div>
                                        <div class="flex items-center gap-space-md text-on-surface-variant text-[11px] mt-0.5">
                                            <div>Input Value: <span class="text-error font-bold">"three-year"</span></div>
                                            <div>Allowed: <span class="text-outline">["month-to-month", "one-year", "two-year"]</span></div>
                                        </div>
                                        <p class="text-on-surface text-body-sm font-body-sm mt-0.5">Input should be 'month-to-month', 'one-year' or 'two-year'</p>
                                    </div>
                                </div>
                                <!-- Raw JSON Viewer -->
                                <div class="bg-surface-container-lowest rounded-lg p-space-sm font-code-block text-code-block text-[11px] leading-5 text-on-surface overflow-x-auto shadow-inner max-h-52 overflow-y-auto">
                                    <pre id="response-body-viewer"><code>{
  <span class="text-primary">"detail"</span>: [
    {
      <span class="text-primary">"type"</span>: <span class="text-secondary">"greater_than_equal"</span>,
      <span class="text-primary">"loc"</span>: [<span class="text-secondary">"body"</span>, <span class="text-secondary">"tenure_months"</span>],
      <span class="text-primary">"msg"</span>: <span class="text-secondary">"Input should be greater than or equal to 0"</span>,
      <span class="text-primary">"input"</span>: <span class="text-error">-5</span>,
      <span class="text-primary">"ctx"</span>: { <span class="text-primary">"ge"</span>: <span class="text-tertiary">0</span> }
    },
    {
      <span class="text-primary">"type"</span>: <span class="text-secondary">"float_parsing"</span>,
      <span class="text-primary">"loc"</span>: [<span class="text-secondary">"body"</span>, <span class="text-secondary">"monthly_charges"</span>],
      <span class="text-primary">"msg"</span>: <span class="text-secondary">"Input should be a valid number, unable to parse string as float"</span>,
      <span class="text-primary">"input"</span>: <span class="text-error">"ONE_HUNDRED_DOLLARS"</span>
    },
    {
      <span class="text-primary">"type"</span>: <span class="text-secondary">"literal_error"</span>,
      <span class="text-primary">"loc"</span>: [<span class="text-secondary">"body"</span>, <span class="text-secondary">"contract_type"</span>],
      <span class="text-primary">"msg"</span>: <span class="text-secondary">"Input should be 'month-to-month', 'one-year' or 'two-year'"</span>,
      <span class="text-primary">"input"</span>: <span class="text-error">"three-year"</span>,
      <span class="text-primary">"ctx"</span>: { <span class="text-primary">"expected"</span>: <span class="text-secondary">"'month-to-month', 'one-year' or 'two-year'"</span> }
    }
  ]
}</code></pre>
                                </div>
                            </div>
                            <!-- 3. SIMULATED 200 OK PREVIEW CARD -->
                            <div class="bg-surface-container rounded-lg p-space-sm flex flex-col gap-2">
                                <div class="flex items-center justify-between">
                                    <span class="font-label-caps text-label-caps text-secondary flex items-center gap-1.5">
                                        <span class="material-symbols-outlined text-[15px]">verified</span>
                                        EXPECTED 200 OK INFERENCE CONTRACT (WHEN FIXED)
                                    </span>
                                    <button class="text-tertiary font-label-mono text-label-mono hover:underline" onclick="loadPreset('valid-high')">Apply Valid Fix &gt;</button>
                                </div>
                                <div class="bg-surface-container-lowest p-2 rounded font-code-block text-[11px] text-outline overflow-x-auto">
                                    <code>{"churn_risk_score": 0.8412, "churn_decision": true, "confidence_tier": "HIGH_RISK", "latency_ms": 16.8, "model_version": "v2.4.0", "soc_dispatched": true}</code>
                                </div>
                            </div>
                        </div>
                        <!-- 4. TELEMETRY & INGRESS WATERFALL BREAKDOWN -->
                        <div class="bg-surface-container-low rounded-xl p-space-md shadow-md flex flex-col gap-space-sm">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="font-label-caps text-label-caps text-outline uppercase">[SYS-AI // 04.B2]</span>
                                    <span class="font-headline-sm text-headline-sm text-on-surface">Execution Waterfall Latency</span>
                                </div>
                                <span class="font-label-mono text-label-mono text-outline">Total: 12.4ms</span>
                            </div>
                            <!-- Waterfall Visual Bars -->
                            <div class="flex flex-col gap-2 font-label-mono text-label-mono">
                                <!-- Step 1 -->
                                <div class="flex flex-col gap-0.5">
                                    <div class="flex justify-between text-body-sm">
                                        <span class="text-outline">1. Envoy Ingress &amp; Token Auth Check</span>
                                        <span class="text-on-surface">2.1ms</span>
                                    </div>
                                    <div class="w-full bg-surface-container-lowest h-1.5 rounded overflow-hidden">
                                        <div class="bg-secondary h-full rounded" style="width: 17%"></div>
                                    </div>
                                </div>
                                <!-- Step 2 -->
                                <div class="flex flex-col gap-0.5">
                                    <div class="flex justify-between text-body-sm">
                                        <span class="text-outline">2. FastAPI Middleware &amp; CORS Pre-flight</span>
                                        <span class="text-on-surface">1.4ms</span>
                                    </div>
                                    <div class="w-full bg-surface-container-lowest h-1.5 rounded overflow-hidden">
                                        <div class="bg-secondary h-full rounded" style="width: 11%"></div>
                                    </div>
                                </div>
                                <!-- Step 3 -->
                                <div class="flex flex-col gap-0.5">
                                    <div class="flex justify-between text-body-sm">
                                        <span class="text-error font-semibold">3. Pydantic Strict Schema Validation (HALTED 422)</span>
                                        <span class="text-error font-semibold">8.9ms</span>
                                    </div>
                                    <div class="w-full bg-surface-container-lowest h-1.5 rounded overflow-hidden">
                                        <div class="bg-error h-full rounded" style="width: 72%"></div>
                                    </div>
                                </div>
                                <!-- Step 4 -->
                                <div class="flex flex-col gap-0.5 opacity-50">
                                    <div class="flex justify-between text-body-sm">
                                        <span class="text-outline line-through">4. Random Forest Tensor Inference</span>
                                        <span class="text-tertiary">0.0ms (BYPASSED)</span>
                                    </div>
                                    <div class="w-full bg-surface-container-lowest h-1.5 rounded overflow-hidden">
                                        <div class="bg-tertiary h-full rounded" style="width: 0%"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- SOC Transmission Hook -->
                            <div class="mt-space-xs bg-surface-container-lowest p-2 rounded flex items-center justify-between text-label-mono font-label-mono">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-[16px] text-tertiary">satellite_alt</span>
                                    <span class="text-outline">SOC Stream Hook:</span>
                                    <span class="text-on-surface">SYS-AI-05 Incident Registered [HTTP_422_SCHEMA_VIOLATION]</span>
                                </div>
                                <span class="text-secondary hover:underline cursor-pointer">View SOC &gt;</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- INTERACTION SCRIPTS -->
                
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