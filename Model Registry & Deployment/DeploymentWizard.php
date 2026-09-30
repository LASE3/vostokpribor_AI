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
            <div class="flex flex-col w-full gap-space-lg pb-12">
                <!-- Top Context & Pipeline Header Banner -->
                <div class="flex flex-col gap-space-sm bg-surface-container-low p-space-md rounded-xl shadow-md">
                    <div class="flex flex-wrap items-center justify-between gap-space-sm pb-space-sm">
                        <div class="flex items-center gap-space-xs font-label-mono text-label-mono">
                            <span class="text-outline">SYS-AI-04</span>
                            <span class="text-outline-variant">/</span>
                            <span class="text-on-surface-variant">Registry</span>
                            <span class="text-outline-variant">/</span>
                            <span class="text-on-surface-variant">Models</span>
                            <span class="text-outline-variant">/</span>
                            <span class="text-primary font-semibold">churn_rf_v2 @ v2.4.0</span>
                            <span class="text-outline-variant">/</span>
                            <span class="text-tertiary bg-tertiary-container px-1.5 py-0.5 rounded">WIZARD-STAGE-11</span>
                        </div>
                        <div class="flex items-center gap-space-xs">
                            <button class="flex items-center gap-1.5 px-space-sm py-1 rounded bg-surface-container text-on-surface-variant hover:text-on-surface font-body-sm text-body-sm transition-colors">
                                <span class="material-symbols-outlined text-[16px]">save</span>
                                <span>Save as Draft</span>
                            </button>
                            <button class="flex items-center gap-1.5 px-space-sm py-1 rounded bg-surface-container text-on-surface-variant hover:text-on-surface font-body-sm text-body-sm transition-colors">
                                <span class="material-symbols-outlined text-[16px]">terminal</span>
                                <span>View Stored Config</span>
                            </button>
                            <button class="flex items-center gap-1.5 px-space-sm py-1 rounded bg-error-container/40 text-error hover:bg-error-container hover:text-on-error-container font-body-sm text-body-sm transition-colors">
                                <span class="material-symbols-outlined text-[16px]">close</span>
                                <span>Discard &amp; Return</span>
                            </button>
                        </div>
                    </div>
                    <!-- Telemetry Target Card -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-space-sm bg-surface-container-lowest p-space-sm rounded-lg">
                        <div class="flex flex-col">
                            <span class="font-label-caps text-label-caps text-outline">TARGET ARTIFACT</span>
                            <div class="flex items-center gap-1.5 mt-0.5">
                                <span class="font-headline-sm text-headline-sm text-on-surface">churn_rf_v2</span>
                                <span class="font-label-mono text-label-mono px-1.5 rounded bg-surface-container-high text-secondary">v2.4.0</span>
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-label-caps text-label-caps text-outline">ASSOCIATED TICKET</span>
                            <div class="flex items-center gap-1.5 mt-0.5">
                                <span class="w-2 h-2 rounded-full bg-tertiary"></span>
                                <span class="font-label-mono text-label-mono text-on-surface">#AI-024 Customer Churn Prevention</span>
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-label-caps text-label-caps text-outline">TARGET CLUSTER / NAMESPACE</span>
                            <div class="flex items-center gap-1.5 mt-0.5">
                                <span class="material-symbols-outlined text-secondary text-[16px]">hub</span>
                                <span class="font-label-mono text-label-mono text-on-surface">k8s-prod-eu-west1:ai-serving</span>
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-label-caps text-label-caps text-outline">TARGET HTTP INGRESS</span>
                            <div class="flex items-center gap-1.5 mt-0.5 font-label-mono text-label-mono">
                                <span class="px-1 rounded bg-secondary-container text-secondary text-[10px]">POST</span>
                                <span class="text-tertiary">/predict/churn</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- 4-STEP WIZARD PROGRESSION RAIL -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-space-sm">
                    <!-- Step 1: Completed -->
                    <div class="flex items-center justify-between p-space-sm bg-surface-container-low rounded-lg shadow-sm">
                        <div class="flex items-center gap-space-sm min-w-0">
                            <div class="w-7 h-7 rounded-full bg-secondary-container text-secondary flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-[16px]">check</span>
                            </div>
                            <div class="flex flex-col min-w-0">
                                <span class="font-label-caps text-label-caps text-outline">STEP 01 // PACKAGING</span>
                                <span class="font-headline-sm text-body-sm text-on-surface truncate">Microservice Contract</span>
                            </div>
                        </div>
                        <span class="font-label-mono text-label-mono text-secondary px-1.5 py-0.5 rounded bg-surface-container shrink-0">VALID</span>
                    </div>
                    <!-- Step 2: Completed -->
                    <div class="flex items-center justify-between p-space-sm bg-surface-container-low rounded-lg shadow-sm">
                        <div class="flex items-center gap-space-sm min-w-0">
                            <div class="w-7 h-7 rounded-full bg-secondary-container text-secondary flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-[16px]">check</span>
                            </div>
                            <div class="flex flex-col min-w-0">
                                <span class="font-label-caps text-label-caps text-outline">STEP 02 // TEST SUITE</span>
                                <span class="font-headline-sm text-body-sm text-on-surface truncate">pytest (14/14 Pass)</span>
                            </div>
                        </div>
                        <span class="font-label-mono text-label-mono text-secondary px-1.5 py-0.5 rounded bg-surface-container shrink-0">100%</span>
                    </div>
                    <!-- Step 3: Active CI/CD -->
                    <div class="flex items-center justify-between p-space-sm bg-surface-container-high rounded-lg shadow-md">
                        <div class="flex items-center gap-space-sm min-w-0">
                            <div class="w-7 h-7 rounded-full bg-tertiary text-on-tertiary font-label-mono text-label-mono font-bold flex items-center justify-center shrink-0">
                                03
                            </div>
                            <div class="flex flex-col min-w-0">
                                <span class="font-label-caps text-label-caps text-tertiary">STEP 03 // ACTIVE RUNNER</span>
                                <span class="font-headline-sm text-body-sm text-on-surface truncate">CI/CD Pipeline Runner</span>
                            </div>
                        </div>
                        <span class="font-label-mono text-label-mono text-tertiary px-1.5 py-0.5 rounded bg-tertiary-container shrink-0 flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-tertiary"></span>RUNNING
                        </span>
                    </div>
                    <!-- Step 4: Pending Spec -->
                    <div class="flex items-center justify-between p-space-sm bg-surface-container-lowest rounded-lg opacity-85">
                        <div class="flex items-center gap-space-sm min-w-0">
                            <div class="w-7 h-7 rounded-full bg-surface-container text-outline font-label-mono text-label-mono flex items-center justify-center shrink-0">
                                04
                            </div>
                            <div class="flex flex-col min-w-0">
                                <span class="font-label-caps text-label-caps text-outline">STEP 04 // TARGET SPEC</span>
                                <span class="font-headline-sm text-body-sm text-on-surface-variant truncate">Runtime &amp; Cluster Config</span>
                            </div>
                        </div>
                        <span class="font-label-mono text-label-mono text-outline px-1.5 py-0.5 rounded bg-surface-container shrink-0">STAGED</span>
                    </div>
                </div>
                <!-- STEP 3 RUNNER OVERVIEW: CI/CD Live Node Progress Bar -->
                <div class="flex flex-col bg-surface-container-low p-space-md rounded-xl shadow-lg gap-space-md">
                    <div class="flex flex-wrap items-center justify-between gap-space-sm">
                        <div class="flex items-center gap-space-sm">
                            <span class="material-symbols-outlined text-tertiary text-[24px]">account_tree</span>
                            <div class="flex flex-col">
                                <div class="flex items-center gap-space-xs">
                                    <span class="font-headline-sm text-headline-sm text-on-surface">CI/CD Pipeline Runner</span>
                                    <span class="font-label-mono text-label-mono text-on-surface-variant">workflow: release-model-vostok.yaml</span>
                                </div>
                                <span class="font-label-mono text-label-mono text-outline">Commit 3c9e40f · Branch: release/v2.4.0 · Triggered by: #4092 (Sarah Chen)</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-space-xs font-label-mono text-label-mono">
                            <span class="text-outline">STAGE: 5 OF 6 COMPLETE</span>
                            <span class="px-2 py-0.5 bg-surface-container text-tertiary font-semibold rounded">TOTAL TIME: 6m 25s</span>
                        </div>
                    </div>
                    <!-- Pipeline Node Graphic -->
                    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-space-sm">
                        <!-- Node 1 -->
                        <div class="flex flex-col bg-surface-container-lowest p-space-sm rounded-lg gap-1">
                            <div class="flex items-center justify-between">
                                <span class="font-label-caps text-label-caps text-outline">NODE 01</span>
                                <span class="material-symbols-outlined text-secondary text-[16px]">check_circle</span>
                            </div>
                            <span class="font-body-sm text-body-sm text-on-surface font-semibold">Lint &amp; Flake8</span>
                            <div class="flex items-center justify-between text-outline font-label-mono text-label-mono mt-1">
                                <span>ruff v0.3.1</span>
                                <span class="text-secondary">42s</span>
                            </div>
                        </div>
                        <!-- Node 2 -->
                        <div class="flex flex-col bg-surface-container-lowest p-space-sm rounded-lg gap-1">
                            <div class="flex items-center justify-between">
                                <span class="font-label-caps text-label-caps text-outline">NODE 02</span>
                                <span class="material-symbols-outlined text-secondary text-[16px]">check_circle</span>
                            </div>
                            <span class="font-body-sm text-body-sm text-on-surface font-semibold">pytest TestClient</span>
                            <div class="flex items-center justify-between text-outline font-label-mono text-label-mono mt-1">
                                <span>14/14 tests</span>
                                <span class="text-secondary">1m 18s</span>
                            </div>
                        </div>
                        <!-- Node 3 -->
                        <div class="flex flex-col bg-surface-container-lowest p-space-sm rounded-lg gap-1">
                            <div class="flex items-center justify-between">
                                <span class="font-label-caps text-label-caps text-outline">NODE 03</span>
                                <span class="material-symbols-outlined text-secondary text-[16px]">check_circle</span>
                            </div>
                            <span class="font-body-sm text-body-sm text-on-surface font-semibold">Build Docker OCI</span>
                            <div class="flex items-center justify-between text-outline font-label-mono text-label-mono mt-1">
                                <span>linux/amd64</span>
                                <span class="text-secondary">3m 05s</span>
                            </div>
                        </div>
                        <!-- Node 4 -->
                        <div class="flex flex-col bg-surface-container-lowest p-space-sm rounded-lg gap-1">
                            <div class="flex items-center justify-between">
                                <span class="font-label-caps text-label-caps text-outline">NODE 04</span>
                                <span class="material-symbols-outlined text-secondary text-[16px]">check_circle</span>
                            </div>
                            <span class="font-body-sm text-body-sm text-on-surface font-semibold">Trivy Vulnerability</span>
                            <div class="flex items-center justify-between text-outline font-label-mono text-label-mono mt-1">
                                <span>0 High / 0 Crit</span>
                                <span class="text-secondary">1m 12s</span>
                            </div>
                        </div>
                        <!-- Node 5 -->
                        <div class="flex flex-col bg-surface-container-lowest p-space-sm rounded-lg gap-1">
                            <div class="flex items-center justify-between">
                                <span class="font-label-caps text-label-caps text-outline">NODE 05</span>
                                <span class="material-symbols-outlined text-secondary text-[16px]">check_circle</span>
                            </div>
                            <span class="font-body-sm text-body-sm text-on-surface font-semibold">Harbor Registry Push</span>
                            <div class="flex items-center justify-between text-outline font-label-mono text-label-mono mt-1">
                                <span>sha256:7f9a21</span>
                                <span class="text-secondary">48s</span>
                            </div>
                        </div>
                        <!-- Node 6: Active / Gate Target -->
                        <div class="flex flex-col bg-surface-container-highest p-space-sm rounded-lg gap-1">
                            <div class="flex items-center justify-between">
                                <span class="font-label-caps text-label-caps text-tertiary">NODE 06</span>
                                <span class="material-symbols-outlined text-tertiary text-[16px]">lock_open</span>
                            </div>
                            <span class="font-body-sm text-body-sm text-on-surface font-bold">Canary Deploy k8s</span>
                            <div class="flex items-center justify-between text-outline font-label-mono text-label-mono mt-1">
                                <span class="text-tertiary">Awaiting Exec</span>
                                <span class="text-tertiary">STAGE 11</span>
                            </div>
                        </div>
                    </div>
                    <!-- Production Gate Action Bar -->
                    <div class="flex flex-col lg:flex-row items-center justify-between gap-space-md p-space-sm bg-surface-container rounded-lg">
                        <div class="flex items-start gap-space-sm">
                            <span class="material-symbols-outlined text-secondary text-[22px] mt-0.5">verified_user</span>
                            <div class="flex flex-col">
                                <div class="flex items-center gap-space-xs">
                                    <span class="font-headline-sm text-body-sm font-bold text-on-surface">Automated Verification Gate: PASSED</span>
                                    <span class="font-label-mono text-label-mono text-secondary bg-surface-container-high px-1.5 py-0.2 rounded">GATE-SYS04-024 APPROVED</span>
                                </div>
                                <span class="font-body-sm text-body-sm text-on-surface-variant">All 14 unit and inference validation suites have cleared. Artifact signed by Harbor Notary. Model is certified for Stage 11 serving.</span>
                            </div>
                        </div>
                        <div class="flex flex-wrap items-center gap-space-sm shrink-0">
                            <label class="flex items-center gap-1.5 font-label-mono text-label-mono text-on-surface-variant cursor-pointer select-none">
                                <input checked="" class="accent-tertiary rounded" type="checkbox" />
                                <span>Dry-Run Simulation</span>
                            </label>
                            <label class="flex items-center gap-1.5 font-label-mono text-label-mono text-on-surface-variant cursor-pointer select-none">
                                <input checked="" class="accent-tertiary rounded" type="checkbox" />
                                <span>Canary (10% Traffic)</span>
                            </label>
                            <button class="flex items-center gap-space-xs px-space-md py-2 rounded bg-tertiary text-on-tertiary font-headline-sm text-body-sm font-bold hover:bg-tertiary-fixed-dim transition-all shadow-md active:scale-95" id="deployTriggerBtn">
                                <span class="material-symbols-outlined text-[18px]">rocket_launch</span>
                                <span>Execute Production Deployment</span>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- 2x2 BENTO MATRIX: Steps 1, 2, 4 + Inspection Panels -->
                <div class="grid grid-cols-1 xl:grid-cols-12 gap-space-md">
                    <!-- PANEL A: STEP 1 - Microservice & Pydantic Contract (Col 7) -->
                    <div class="xl:col-span-7 flex flex-col bg-surface-container-low p-space-md rounded-xl shadow-md gap-space-md">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-space-sm">
                                <span class="font-label-caps text-label-caps text-outline">[SYS-AI // 01-CONTRACT]</span>
                                <span class="font-headline-sm text-headline-sm text-on-surface">Microservice &amp; Pydantic Contract</span>
                            </div>
                            <div class="flex items-center gap-1.5 font-label-mono text-label-mono">
                                <span class="px-1.5 py-0.5 rounded bg-surface-container text-secondary">FastAPI 0.110.0</span>
                                <span class="px-1.5 py-0.5 rounded bg-surface-container text-tertiary">Pydantic v2</span>
                            </div>
                        </div>
                        <!-- Route Code Inspector -->
                        <div class="flex flex-col bg-surface-container-lowest rounded-lg p-space-sm gap-space-xs shadow-inner">
                            <div class="flex items-center justify-between font-label-mono text-label-mono text-outline pb-1">
                                <span class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px]">code</span>
                                    app/routers/inference.py
                                </span>
                                <span class="text-secondary">SYNTAX: PYTHON 3.11</span>
                            </div>
                            <pre class="font-code-block text-code-block text-on-surface overflow-x-auto leading-relaxed py-1"><span class="text-tertiary">from</span> fastapi <span class="text-tertiary">import</span> APIRouter, Depends, HTTPException, status
<span class="text-tertiary">from</span> app.schemas <span class="text-tertiary">import</span> CustomerChurnFeatures, ChurnPredictionResponse
<span class="text-tertiary">import</span> time

router = APIRouter(prefix=<span class="text-secondary">"/predict"</span>, tags=[<span class="text-secondary">"Inference"</span>])

<span class="text-tertiary">@router.post</span>(<span class="text-secondary">"/churn"</span>, response_model=ChurnPredictionResponse)
<span class="text-tertiary">async def</span> <span class="text-primary font-semibold">predict_customer_churn</span>(payload: CustomerChurnFeatures):
    t_start = time.perf_counter_ns()
    features_vec = payload.to_inference_tensor()
    probability = model_engine.predict_proba(features_vec)[<span class="text-secondary">0</span>][<span class="text-secondary">1</span>]
    latency_ms = (time.perf_counter_ns() - t_start) / <span class="text-secondary">1_000_000</span>
    
    <span class="text-outline"># Report real-time telemetry to SYS-05 AI SOC stream</span>
    telemetry.record_inference(latency=latency_ms, prob=probability)
    <span class="text-tertiary">return</span> ChurnPredictionResponse(
        churn_risk_score=round(probability, <span class="text-secondary">4</span>),
        churn_decision=probability &gt;= <span class="text-secondary">0.45</span>,
        latency_ms=round(latency_ms, <span class="text-secondary">2</span>)
    )</pre>
                        </div>
                        <!-- Pydantic Schema Specification -->
                        <div class="flex flex-col bg-surface-container-lowest rounded-lg p-space-sm gap-space-xs shadow-inner">
                            <div class="flex items-center justify-between font-label-mono text-label-mono text-outline pb-1">
                                <span class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px]">data_object</span>
                                    app/schemas/customer.py (Strict Null-Safe Fallbacks)
                                </span>
                                <span class="text-tertiary">CONTRACT v2.4 VALIDATED</span>
                            </div>
                            <pre class="font-code-block text-code-block text-on-surface overflow-x-auto leading-relaxed py-1"><span class="text-tertiary">class</span> <span class="text-primary font-semibold">CustomerChurnFeatures</span>(BaseModel):
    customer_id: str = Field(..., example=<span class="text-secondary">"CUST-8921-A"</span>)
    tenure_months: int = Field(..., ge=<span class="text-secondary">0</span>, le=<span class="text-secondary">120</span>, description=<span class="text-outline">"Account age"</span>)
    monthly_charges: float = Field(..., ge=<span class="text-secondary">0.0</span>, le=<span class="text-secondary">1500.0</span>)
    total_charges: Optional[float] = Field(<span class="text-tertiary">None</span>, description=<span class="text-outline">"Fallback: tenure*monthly"</span>)
    contract_type: Literal[<span class="text-secondary">"month-to-month"</span>, <span class="text-secondary">"one-year"</span>, <span class="text-secondary">"two-year"</span>]
    support_tickets_30d: int = Field(default=<span class="text-secondary">0</span>, ge=<span class="text-secondary">0</span>)
    payment_method: str = Field(default=<span class="text-secondary">"bank_transfer"</span>)</pre>
                        </div>
                        <!-- Artifact Meta Pills -->
                        <div class="flex flex-wrap items-center gap-space-xs font-label-mono text-label-mono">
                            <span class="px-2 py-0.5 rounded bg-surface-container text-on-surface-variant">Serialization: <span class="text-on-surface">cloudpickle 3.0</span></span>
                            <span class="px-2 py-0.5 rounded bg-surface-container text-on-surface-variant">Model Size: <span class="text-on-surface">42.8 MB</span></span>
                            <span class="px-2 py-0.5 rounded bg-surface-container text-on-surface-variant">MD5: <span class="text-on-surface">8a9ef34c90d...</span></span>
                            <span class="px-2 py-0.5 rounded bg-surface-container text-secondary">Swagger &amp; OpenAPI Spec generated</span>
                        </div>
                    </div>
                    <!-- PANEL B: STEP 2 - Automated Verification Suite (Col 5) -->
                    <div class="xl:col-span-5 flex flex-col bg-surface-container-low p-space-md rounded-xl shadow-md gap-space-md">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-space-sm">
                                <span class="font-label-caps text-label-caps text-outline">[SYS-AI // 02-VERIFY]</span>
                                <span class="font-headline-sm text-headline-sm text-on-surface">Automated Test Suite</span>
                            </div>
                            <span class="font-label-mono text-label-mono px-2 py-0.5 rounded bg-secondary-container text-secondary font-bold">14/14 PASS</span>
                        </div>
                        <!-- Summary metrics card -->
                        <div class="grid grid-cols-3 gap-space-xs bg-surface-container-lowest p-space-sm rounded-lg text-center">
                            <div class="flex flex-col">
                                <span class="font-label-caps text-label-caps text-outline">OUTCOME</span>
                                <span class="font-headline-sm text-headline-sm text-secondary">0 Failed</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="font-label-caps text-label-caps text-outline">DURATION</span>
                                <span class="font-headline-sm text-headline-sm text-on-surface">3.42s</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="font-label-caps text-label-caps text-outline">LINE COVERAGE</span>
                                <span class="font-headline-sm text-headline-sm text-tertiary">98.4%</span>
                            </div>
                        </div>
                        <!-- Test list execution cards -->
                        <div class="flex flex-col gap-1.5 max-h-[290px] overflow-y-auto pr-1">
                            <!-- Test 1 -->
                            <div class="flex items-center justify-between p-2 rounded bg-surface-container-lowest font-label-mono text-label-mono">
                                <div class="flex items-center gap-2 min-w-0">
                                    <span class="w-1.5 h-1.5 rounded-full bg-secondary shrink-0"></span>
                                    <span class="text-on-surface truncate">test_prediction_correctness_baseline</span>
                                </div>
                                <span class="text-secondary shrink-0 ml-2">PASSED 12ms</span>
                            </div>
                            <!-- Test 2 -->
                            <div class="flex items-center justify-between p-2 rounded bg-surface-container-lowest font-label-mono text-label-mono">
                                <div class="flex items-center gap-2 min-w-0">
                                    <span class="w-1.5 h-1.5 rounded-full bg-secondary shrink-0"></span>
                                    <span class="text-on-surface truncate">test_deterministic_reproducibility (100 seeds)</span>
                                </div>
                                <span class="text-secondary shrink-0 ml-2">PASSED 84ms</span>
                            </div>
                            <!-- Test 3 -->
                            <div class="flex items-center justify-between p-2 rounded bg-surface-container-lowest font-label-mono text-label-mono">
                                <div class="flex items-center gap-2 min-w-0">
                                    <span class="w-1.5 h-1.5 rounded-full bg-secondary shrink-0"></span>
                                    <span class="text-on-surface truncate">test_response_spec_and_latency_p95 (&lt;25ms)</span>
                                </div>
                                <span class="text-secondary shrink-0 ml-2">PASSED 19ms</span>
                            </div>
                            <!-- Test 4 -->
                            <div class="flex items-center justify-between p-2 rounded bg-surface-container-lowest font-label-mono text-label-mono">
                                <div class="flex items-center gap-2 min-w-0">
                                    <span class="w-1.5 h-1.5 rounded-full bg-secondary shrink-0"></span>
                                    <span class="text-on-surface truncate">test_edge_case_null_fields_imputation</span>
                                </div>
                                <span class="text-secondary shrink-0 ml-2">PASSED 15ms</span>
                            </div>
                            <!-- Test 5 -->
                            <div class="flex items-center justify-between p-2 rounded bg-surface-container-lowest font-label-mono text-label-mono">
                                <div class="flex items-center gap-2 min-w-0">
                                    <span class="w-1.5 h-1.5 rounded-full bg-secondary shrink-0"></span>
                                    <span class="text-on-surface truncate">test_edge_case_type_validation_422_rfc7807</span>
                                </div>
                                <span class="text-secondary shrink-0 ml-2">PASSED 9ms</span>
                            </div>
                            <!-- Test 6 -->
                            <div class="flex items-center justify-between p-2 rounded bg-surface-container-lowest font-label-mono text-label-mono">
                                <div class="flex items-center gap-2 min-w-0">
                                    <span class="w-1.5 h-1.5 rounded-full bg-secondary shrink-0"></span>
                                    <span class="text-on-surface truncate">test_security_payload_size_limit (&gt;2MB-&gt;413)</span>
                                </div>
                                <span class="text-secondary shrink-0 ml-2">PASSED 6ms</span>
                            </div>
                        </div>
                        <!-- Live Terminal Output Preview -->
                        <div class="flex flex-col bg-surface-container-lowest rounded-lg p-space-sm gap-1 shadow-inner">
                            <div class="flex items-center justify-between font-label-mono text-label-mono text-outline">
                                <span>CONSOLE: pytest -v tests/test_inference.py</span>
                                <span class="text-tertiary">EXIT 0</span>
                            </div>
                            <div class="font-code-block text-code-block text-on-surface leading-tight font-label-mono">
                                <p class="text-outline">tests/test_inference.py::test_prediction_correctness_baseline <span class="text-secondary">PASSED</span> [ 16%]</p>
                                <p class="text-outline">tests/test_inference.py::test_response_spec_and_latency_p95 <span class="text-secondary">PASSED</span> [ 33%]</p>
                                <p class="text-outline">tests/test_inference.py::test_edge_case_null_fields_imputation <span class="text-secondary">PASSED</span> [ 50%]</p>
                                <p class="text-secondary font-semibold mt-1">====== 14 passed in 3.42s (all verification suites green) ======</p>
                            </div>
                        </div>
                    </div>
                    <!-- PANEL D: STEP 4 - Runtime Configuration & Cluster Specs (Full Width 12 Col) -->
                    <div class="xl:col-span-12 flex flex-col bg-surface-container-low p-space-md rounded-xl shadow-md gap-space-md">
                        <div class="flex flex-wrap items-center justify-between gap-space-sm">
                            <div class="flex items-center gap-space-sm">
                                <span class="font-label-caps text-label-caps text-outline">[SYS-AI // 04-RUNTIME]</span>
                                <span class="font-headline-sm text-headline-sm text-on-surface">Runtime Configuration &amp; Kubernetes Cluster Specs</span>
                            </div>
                            <span class="font-label-mono text-label-mono px-2 py-0.5 rounded bg-surface-container text-tertiary">AUTOSCALING: HPA ENABLED</span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-space-md">
                            <!-- Replicas & Scaling -->
                            <div class="flex flex-col bg-surface-container-lowest p-space-sm rounded-lg gap-space-sm">
                                <div class="flex items-center justify-between">
                                    <span class="font-label-caps text-label-caps text-outline">POD REPLICAS &amp; AUTOSCALING</span>
                                    <span class="font-label-mono text-label-mono text-secondary">Min: 2 / Max: 8</span>
                                </div>
                                <div class="flex flex-col gap-1 mt-1">
                                    <div class="flex justify-between font-label-mono text-label-mono text-on-surface">
                                        <span>Target Replicas on Rollout:</span>
                                        <span class="text-tertiary font-bold" id="replicaVal">3 Pods</span>
                                    </div>
                                    <input class="accent-tertiary w-full cursor-pointer" id="replicaSlider" max="8" min="2" type="range" value="3" />
                                    <div class="flex justify-between font-label-caps text-label-caps text-outline">
                                        <span>2 pods (cold reserve)</span>
                                        <span>5 pods (peak)</span>
                                        <span>8 pods (failover max)</span>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-1 pt-space-xs">
                                    <span class="font-label-caps text-label-caps text-outline">HPA CPU TRIGGER THRESHOLD</span>
                                    <div class="w-full bg-surface-container-high h-2 rounded-full overflow-hidden">
                                        <div class="bg-tertiary h-full rounded-full" style="width: 70%"></div>
                                    </div>
                                    <div class="flex justify-between font-label-mono text-label-mono text-outline">
                                        <span>Target CPU: 70%</span>
                                        <span class="text-on-surface-variant">Scale-up period: 15s</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Resource Allotment & Hardware -->
                            <div class="flex flex-col bg-surface-container-lowest p-space-sm rounded-lg gap-space-sm">
                                <span class="font-label-caps text-label-caps text-outline">COMPUTE LIMITS &amp; HARDWARE</span>
                                <div class="grid grid-cols-2 gap-space-xs font-label-mono text-label-mono">
                                    <div class="p-2 rounded bg-surface-container flex flex-col">
                                        <span class="text-outline text-[10px]">CPU REQUEST / LIMIT</span>
                                        <span class="text-on-surface font-semibold text-body-sm">500m / 1000m</span>
                                    </div>
                                    <div class="p-2 rounded bg-surface-container flex flex-col">
                                        <span class="text-outline text-[10px]">MEMORY REQ / LIMIT</span>
                                        <span class="text-on-surface font-semibold text-body-sm">1.0Gi / 2.0Gi</span>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-1">
                                    <span class="font-label-caps text-label-caps text-outline">GPU ACCELERATION ACCELERATOR</span>
                                    <div class="p-2 rounded bg-surface-container flex items-center justify-between font-label-mono text-label-mono">
                                        <div class="flex items-center gap-1.5">
                                            <span class="material-symbols-outlined text-secondary text-[16px]">memory</span>
                                            <span class="text-on-surface">NVIDIA T4 (16GB)</span>
                                        </div>
                                        <span class="text-secondary text-[10px] px-1 py-0.5 rounded bg-surface-container-high">OPTIONAL GPU POOL</span>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between font-label-mono text-label-mono text-outline">
                                    <span>Concurrency per worker:</span>
                                    <span class="text-on-surface">32 requests</span>
                                </div>
                            </div>
                            <!-- Health Probes -->
                            <div class="flex flex-col bg-surface-container-lowest p-space-sm rounded-lg gap-space-sm">
                                <span class="font-label-caps text-label-caps text-outline">KUBERNETES HEALTH &amp; READINESS PROBES</span>
                                <div class="flex flex-col gap-1.5 font-label-mono text-label-mono">
                                    <div class="p-2 rounded bg-surface-container flex flex-col gap-0.5">
                                        <div class="flex justify-between items-center">
                                            <span class="text-secondary font-semibold">Liveness Probe: /healthz</span>
                                            <span class="text-outline text-[10px]">HTTP GET :8080</span>
                                        </div>
                                        <span class="text-outline text-[10px]">initialDelay: 10s · period: 15s · timeout: 2s</span>
                                    </div>
                                    <div class="p-2 rounded bg-surface-container flex flex-col gap-0.5">
                                        <div class="flex justify-between items-center">
                                            <span class="text-secondary font-semibold">Readiness Probe: /ready</span>
                                            <span class="text-outline text-[10px]">HTTP GET :8080</span>
                                        </div>
                                        <span class="text-outline text-[10px]">initialDelay: 5s · period: 10s · success: 1</span>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between font-label-mono text-label-mono text-outline">
                                    <span>Graceful termination:</span>
                                    <span class="text-on-surface">30s timeout</span>
                                </div>
                            </div>
                        </div>
                        <!-- Environment Variables Table -->
                        <div class="flex flex-col bg-surface-container-lowest rounded-lg p-space-sm gap-space-xs">
                            <div class="flex items-center justify-between font-label-caps text-label-caps text-outline pb-1">
                                <span>INJECTED RUNTIME ENVIRONMENT VARIABLES (K8S CONFIGMAP &amp; SECRETS)</span>
                                <span class="text-tertiary font-label-mono text-label-mono">5 ACTIVE VARS</span>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-space-xs font-label-mono text-label-mono">
                                <div class="p-2 rounded bg-surface-container flex flex-col gap-0.5">
                                    <span class="text-outline text-[10px]">KEY: ENVIRONMENT</span>
                                    <span class="text-secondary truncate">production</span>
                                </div>
                                <div class="p-2 rounded bg-surface-container flex flex-col gap-0.5">
                                    <span class="text-outline text-[10px]">KEY: LOG_LEVEL</span>
                                    <span class="text-on-surface truncate">INFO</span>
                                </div>
                                <div class="p-2 rounded bg-surface-container flex flex-col gap-0.5">
                                    <span class="text-outline text-[10px]">KEY: SOC_TELEMETRY_ENDPOINT</span>
                                    <span class="text-tertiary truncate">soc.vostok.internal/v1</span>
                                </div>
                                <div class="p-2 rounded bg-surface-container flex flex-col gap-0.5">
                                    <span class="text-outline text-[10px]">KEY: SYS05_CRM_WEBHOOK</span>
                                    <span class="text-primary truncate">crm.vostok.internal/api</span>
                                </div>
                                <div class="p-2 rounded bg-surface-container flex flex-col gap-0.5">
                                    <span class="text-outline text-[10px]">KEY: MODEL_WORKERS</span>
                                    <span class="text-on-surface truncate">4 (Uvicorn Async)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Real-time Deployment Interactive Feedback Drawer -->
                <div class="hidden flex-col bg-surface-container-high p-space-md rounded-xl shadow-xl gap-space-sm" id="deployFeedbackPanel">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-space-xs">
                            <span class="material-symbols-outlined text-tertiary text-[20px]">sync</span>
                            <span class="font-headline-sm text-body-sm font-bold text-on-surface">Deploying Churn Predictor v2.4.0 to vostok-k8s-prod-eu...</span>
                        </div>
                        <span class="font-label-mono text-label-mono text-tertiary bg-tertiary-container px-2 py-0.5 rounded">INITIATING POD ROLLING UPDATE</span>
                    </div>
                    <div class="font-label-mono text-label-mono text-outline bg-surface-container-lowest p-space-sm rounded-lg flex flex-col gap-1">
                        <p class="text-secondary">[OK] Authenticated with harbor.vostok.internal (Identity: #4092-sarah-chen)</p>
                        <p class="text-on-surface">[OK] Pulling image harbor.vostok.internal/churn-service:v2.4.0 into k8s worker nodes</p>
                        <p class="text-tertiary">[RUNNING] Spin up canary pod 1/3 (churn-serving-v2-4-0-798cfb459-x49d1) ... Ready in 4s</p>
                    </div>
                </div>
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