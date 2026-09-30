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
                </a><a aria-current="page" class="flex items-center justify-between px-space-md py-space-sm rounded transition-colors group bg-surface-container text-primary font-semibold shadow-[inset_3px_0_0_#ffb956]" data-path="model-registry" href="ModelRegistry.php">
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
                <nav class="flex items-center gap-space-xs" data-active-classes="bg-surface-container-highest text-primary font-semibold"><a aria-current="page" class="px-space-sm py-1 rounded transition-colors bg-surface-container-highest text-primary font-semibold" data-path="model-registry" href="ModelRegistry.php">Model Registry</a><a class="font-body-sm text-body-sm px-space-sm py-1 rounded text-on-surface-variant hover:text-on-surface hover:bg-surface-container transition-colors" data-path="model-card" href="ModelCard.php">Model Card (churn_rf_v2)</a><a class="font-body-sm text-body-sm px-space-sm py-1 rounded text-on-surface-variant hover:text-on-surface hover:bg-surface-container transition-colors" data-path="deployment-wizard" href="DeploymentWizard.php">Deployment Wizard</a><a class="font-body-sm text-body-sm px-space-sm py-1 rounded text-on-surface-variant hover:text-on-surface hover:bg-surface-container transition-colors" data-path="endpoint-console" href="EndpointConsole.php">Endpoint Console (Swagger)</a><a class="font-body-sm text-body-sm px-space-sm py-1 rounded text-on-surface-variant hover:text-on-surface hover:bg-surface-container transition-colors" data-path="integrations" href="EnterpriseIntegrations.php">Enterprise Integrations</a><a class="font-body-sm text-body-sm px-space-sm py-1 rounded text-on-surface-variant hover:text-on-surface hover:bg-surface-container transition-colors" data-path="releases-rollback" href="DeploymentHistoryRollback.php">Releases &amp; Rollback</a></nav>
            </div>
        </header>
        <main class="relative pt-28 pb-8 px-gutter w-full flex-1 bg-transparent">
            <div class="flex flex-col w-full gap-space-md">
                <!-- Operational Breadcrumb / Context Anchor -->
                <div class="flex items-center justify-between bg-surface-container-low px-space-md py-space-sm rounded-xl">
                    <div class="flex items-center gap-space-sm flex-wrap">
                        <span class="font-label-caps text-label-caps text-on-tertiary-container bg-tertiary-container px-2 py-0.5 rounded flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-tertiary animate-pulse"></span>
                            SYSTEM REPO // SYS-AI-04
                        </span>
                        <span class="font-label-mono text-label-mono text-outline">LOC: /cluster/eu-west-1/registry/artifacts</span>
                        <span class="text-outline font-label-mono text-label-mono">/</span>
                        <span class="font-label-mono text-label-mono text-on-surface">NAMESPACE: churn-prod-v2</span>
                    </div>
                    <div class="flex items-center gap-space-md font-label-mono text-label-mono text-on-surface-variant">
                        <span>SHASUM: 4f9812a</span>
                        <span class="text-tertiary flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]">format_image_left</span>
                            COMPLIANCE AUDIT PASSED
                        </span>
                    </div>
                </div>
                <!-- Operational Context Header Banners -->
                <div class="grid grid-cols-1 xl:grid-cols-12 gap-space-sm">
                    <!-- Active Ticket Banner -->
                    <div class="xl:col-span-5 bg-surface-container-high rounded-xl p-space-md shadow-md flex items-center justify-between">
                        <div class="flex items-center gap-space-sm">
                            <div class="w-8 h-8 rounded-lg bg-tertiary-container flex items-center justify-center text-tertiary shrink-0">
                                <span class="material-symbols-outlined text-[20px]">assignment_turned_in</span>
                            </div>
                            <div class="flex flex-col">
                                <div class="flex items-center gap-space-xs">
                                    <span class="font-label-caps text-label-caps text-tertiary uppercase tracking-wider font-bold">ACTIVE TICKET GATE</span>
                                    <span class="font-label-mono text-label-mono text-on-surface-variant">PRIORITY: HIGH</span>
                                </div>
                                <span class="font-headline-sm text-body-lg text-on-surface font-semibold">#AI-024 Customer Churn · Linked Ticket</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-space-xs">
                            <span class="font-label-mono text-label-mono text-primary bg-primary-container px-2 py-1 rounded">LEVEL 2 ACCESS</span>
                        </div>
                    </div>
                    <!-- Lifecycle Status Banner -->
                    <div class="xl:col-span-7 bg-surface-container rounded-xl p-space-md shadow-md flex items-center justify-between overflow-x-auto">
                        <div class="flex items-center gap-space-sm">
                            <div class="w-8 h-8 rounded-lg bg-secondary-container flex items-center justify-center text-secondary shrink-0">
                                <span class="material-symbols-outlined text-[20px]">schema</span>
                            </div>
                            <div class="flex flex-col">
                                <div class="flex items-center gap-space-xs">
                                    <span class="font-label-caps text-label-caps text-secondary uppercase tracking-wider font-bold">14-STAGE ML LIFECYCLE</span>
                                    <span class="font-label-mono text-label-mono text-tertiary">CURRENT: STAGE 10 &amp; 11</span>
                                </div>
                                <span class="font-headline-sm text-body-lg text-on-surface font-semibold truncate">Model Packaging &amp; Service Registry Active Validation</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-1 font-label-mono text-label-mono shrink-0 pl-space-md">
                            <span class="px-2 py-0.5 rounded bg-surface-container-high text-outline">09: TRAIN</span>
                            <span class="text-tertiary">→</span>
                            <span class="px-2 py-0.5 rounded bg-tertiary-container text-tertiary font-bold">10: PKG</span>
                            <span class="text-secondary">→</span>
                            <span class="px-2 py-0.5 rounded bg-secondary-container text-secondary font-bold">11: REGISTRY</span>
                            <span class="text-outline">→</span>
                            <span class="px-2 py-0.5 rounded bg-surface-container-high text-outline">12: CANARY</span>
                        </div>
                    </div>
                </div>
                <!-- Top Controls: Search, Stage Filters, Compare & Register CTA -->
                <div class="bg-surface-container-low rounded-xl p-space-md shadow-md flex flex-col gap-space-md">
                    <div class="flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-space-md">
                        <!-- Search Input -->
                        <div class="relative flex-1 max-w-xl">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[18px]">search</span>
                            <input class="w-full bg-surface-container-high text-on-surface font-code-block text-code-block pl-10 pr-16 py-2 rounded-lg focus:outline-none focus:ring-1 focus:ring-tertiary placeholder:text-outline" id="modelSearch" placeholder="Filter by model name, tag, commit SHA, or author..." type="text" />
                            <span class="font-label-mono text-label-mono text-on-surface-variant bg-surface-container px-1.5 py-0.5 rounded absolute right-2.5 top-1/2 -translate-y-1/2">
                                ESC / CLR
                            </span>
                        </div>
                        <!-- Action Cluster -->
                        <div class="flex items-center gap-space-sm flex-wrap">
                            <!-- Compare Selected Versions -->
                            <button class="flex items-center gap-space-xs bg-secondary-container text-secondary hover:bg-surface-container-highest px-space-md py-2 rounded-lg transition-colors font-headline-sm text-body-sm shadow-sm" id="toggleDrawerBtn">
                                <span class="material-symbols-outlined text-[18px]">difference</span>
                                <span>Compare Selected Versions</span>
                                <span class="font-label-mono text-label-mono bg-tertiary text-on-tertiary font-bold px-1.5 py-0.2 rounded-full">2</span>
                            </button>
                            <!-- Primary CTA: Register New Model -->
                            <button class="flex items-center gap-space-xs bg-tertiary text-on-tertiary font-headline-sm text-body-sm font-semibold hover:bg-tertiary-fixed-dim px-space-md py-2 rounded-lg shadow-md transition-all">
                                <span class="w-2 h-2 rotate-45 bg-on-tertiary inline-block"></span>
                                <span>+ Register New Model</span>
                            </button>
                        </div>
                    </div>
                    <!-- Filters Row: Stages + Frameworks -->
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-space-sm pt-space-xs">
                        <!-- Stage Filter Pills -->
                        <div class="flex items-center gap-space-xs overflow-x-auto pb-1 md:pb-0">
                            <span class="font-label-caps text-label-caps text-outline mr-1">STAGE:</span>
                            <button class="bg-surface-container-highest text-primary font-headline-sm text-body-sm px-space-sm py-1 rounded-md flex items-center gap-1 font-semibold">
                                <span>All</span>
                                <span class="font-label-mono text-label-mono text-on-surface-variant bg-surface-container-low px-1 rounded">18</span>
                            </button>
                            <button class="bg-surface-container text-on-surface-variant hover:text-on-surface font-headline-sm text-body-sm px-space-sm py-1 rounded-md flex items-center gap-1">
                                <span>Staging</span>
                                <span class="font-label-mono text-label-mono text-tertiary bg-tertiary-container px-1 rounded">4</span>
                            </button>
                            <button class="bg-surface-container text-on-surface-variant hover:text-on-surface font-headline-sm text-body-sm px-space-sm py-1 rounded-md flex items-center gap-1">
                                <span>Production</span>
                                <span class="font-label-mono text-label-mono text-secondary bg-secondary-container px-1 rounded">7</span>
                            </button>
                            <button class="bg-surface-container text-on-surface-variant hover:text-on-surface font-headline-sm text-body-sm px-space-sm py-1 rounded-md flex items-center gap-1">
                                <span>Archived</span>
                                <span class="font-label-mono text-label-mono text-outline bg-surface-container-high px-1 rounded">5</span>
                            </button>
                            <button class="bg-surface-container text-on-surface-variant hover:text-on-surface font-headline-sm text-body-sm px-space-sm py-1 rounded-md flex items-center gap-1">
                                <span>Canary</span>
                                <span class="font-label-mono text-label-mono text-primary bg-primary-container px-1 rounded">2</span>
                            </button>
                        </div>
                        <!-- Framework Filter Dropdown & Tags -->
                        <div class="flex items-center gap-space-xs shrink-0">
                            <span class="font-label-caps text-label-caps text-outline mr-1">FRAMEWORK:</span>
                            <button class="bg-surface-container text-on-surface font-label-mono text-label-mono px-2 py-1 rounded hover:bg-surface-container-high transition-colors">
                                Scikit-learn
                            </button>
                            <button class="bg-surface-container text-on-surface-variant hover:text-on-surface font-label-mono text-label-mono px-2 py-1 rounded hover:bg-surface-container-high transition-colors">
                                PyTorch
                            </button>
                            <button class="bg-surface-container text-on-surface-variant hover:text-on-surface font-label-mono text-label-mono px-2 py-1 rounded hover:bg-surface-container-high transition-colors">
                                XGBoost
                            </button>
                            <button class="bg-surface-container text-on-surface-variant hover:text-on-surface font-label-mono text-label-mono px-2 py-1 rounded hover:bg-surface-container-high transition-colors">
                                ONNX
                            </button>
                            <button class="p-1 rounded bg-surface-container text-outline hover:text-on-surface">
                                <span class="material-symbols-outlined text-[16px]">tune</span>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Bento Summary Statistics Matrix -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-space-sm">
                    <!-- Tile 1 -->
                    <div class="bg-surface-container-high rounded-xl p-space-md shadow-md flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <span class="font-label-caps text-label-caps text-on-surface-variant">[SYS-AI // ARTIFACTS]</span>
                            <span class="font-label-mono text-label-mono text-tertiary bg-tertiary-container px-1.5 py-0.5 rounded">F1 AVG 0.812</span>
                        </div>
                        <div class="my-space-sm">
                            <div class="font-display-lg text-headline-xl text-on-surface font-bold tracking-tight">42</div>
                            <div class="font-body-sm text-body-sm text-on-surface-variant">Total Registered Artifacts</div>
                        </div>
                        <div class="flex items-center justify-between font-label-mono text-label-mono text-outline">
                            <span>STORED: 1.42 TB</span>
                            <span class="text-secondary flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">history</span> 28 Checkpoints
                            </span>
                        </div>
                    </div>
                    <!-- Tile 2 -->
                    <div class="bg-surface-container-high rounded-xl p-space-md shadow-md flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <span class="font-label-caps text-label-caps text-on-surface-variant">[SYS-AI // SERVING]</span>
                            <span class="font-label-mono text-label-mono text-primary bg-primary-container px-1.5 py-0.5 rounded flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span> LATENCY 22ms
                            </span>
                        </div>
                        <div class="my-space-sm">
                            <div class="font-display-lg text-headline-xl text-secondary font-bold tracking-tight">7 Active</div>
                            <div class="font-body-sm text-body-sm text-on-surface-variant">Production Endpoints</div>
                        </div>
                        <div class="flex items-center justify-between font-label-mono text-label-mono text-outline">
                            <span>CLUSTER: k8s-eu</span>
                            <span class="text-tertiary">UPTIME: 99.98%</span>
                        </div>
                    </div>
                    <!-- Tile 3 -->
                    <div class="bg-surface-container-high rounded-xl p-space-md shadow-md flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <span class="font-label-caps text-label-caps text-on-surface-variant">[SYS-AI // PIPELINE]</span>
                            <span class="font-label-mono text-label-mono text-error bg-error-container text-on-error-container px-1.5 py-0.5 rounded">
                                1 FAIL
                            </span>
                        </div>
                        <div class="my-space-sm">
                            <div class="font-display-lg text-headline-xl text-on-surface font-bold tracking-tight">94.2%</div>
                            <div class="font-body-sm text-body-sm text-on-surface-variant">CI/CD Gate Pass Rate</div>
                        </div>
                        <div class="flex items-center justify-between font-label-mono text-label-mono text-outline">
                            <span class="truncate">FAILED: churn_xgb_v1</span>
                            <span>3h ago</span>
                        </div>
                    </div>
                    <!-- Tile 4 -->
                    <div class="bg-surface-container-high rounded-xl p-space-md shadow-md flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <span class="font-label-caps text-label-caps text-on-surface-variant">[SYS-AI // DISPATCH]</span>
                            <span class="font-label-mono text-label-mono text-tertiary bg-tertiary-container px-1.5 py-0.5 rounded">SPRINT 24</span>
                        </div>
                        <div class="my-space-sm">
                            <div class="font-display-lg text-headline-xl text-tertiary font-bold tracking-tight">#AI-024</div>
                            <div class="font-body-sm text-body-sm text-on-surface-variant">Active Target Sprint Goal</div>
                        </div>
                        <div class="flex items-center justify-between font-label-mono text-label-mono text-outline">
                            <span class="truncate">Intern AI Engineer L2</span>
                            <span class="text-on-surface">Sarah Chen</span>
                        </div>
                    </div>
                </div>
                <!-- Main Operational Canvas: Registry Table + Side Comparison Drawer Split -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-md items-start">
                    <!-- Model Registry Table (Expanded to 8 or 12 cols) -->
                    <div class="lg:col-span-8 bg-surface-container-low rounded-xl shadow-xl overflow-hidden flex flex-col transition-all duration-300" id="tableWrapper">
                        <!-- Table Header Instrument Bar -->
                        <div class="bg-surface-container-high px-space-md py-space-sm flex items-center justify-between">
                            <div class="flex items-center gap-space-sm">
                                <span class="font-label-caps text-label-caps text-on-surface-variant">MODEL REPOSITORY CATALOG</span>
                                <span class="font-label-mono text-label-mono text-outline">SYNCHRONIZED (HARBOR REGISTRY)</span>
                            </div>
                            <div class="flex items-center gap-space-xs font-label-mono text-label-mono text-outline">
                                <span class="px-2 py-0.5 rounded bg-surface-container text-on-surface">SORT: LAST_DEPLOYED_DESC</span>
                                <button class="p-1 rounded bg-surface-container text-on-surface hover:bg-surface-container-highest">
                                    <span class="material-symbols-outlined text-[14px]">refresh</span>
                                </button>
                            </div>
                        </div>
                        <!-- Ultra-dense Industrial Table -->
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-surface-container-highest font-label-caps text-label-caps text-outline uppercase tracking-wider">
                                        <th class="py-2.5 px-3 w-8 text-center">
                                            <input checked="" class="accent-tertiary rounded" type="checkbox" />
                                        </th>
                                        <th class="py-2.5 px-3">Model Name &amp; Description</th>
                                        <th class="py-2.5 px-3">Version</th>
                                        <th class="py-2.5 px-3">Stage</th>
                                        <th class="py-2.5 px-3">Metrics (F1 / Recall / AUC)</th>
                                        <th class="py-2.5 px-3">Framework</th>
                                        <th class="py-2.5 px-3">Author &amp; Ticket</th>
                                        <th class="py-2.5 px-3">Deployed</th>
                                        <th class="py-2.5 px-3 text-center">Health</th>
                                        <th class="py-2.5 px-3 text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="font-body-sm text-body-sm divide-y divide-surface-container">
                                    <!-- Row 1 (Highlighted / Primary Target) -->
                                    <tr class="bg-surface-container/60 hover:bg-surface-container-high transition-colors group">
                                        <td class="py-3 px-3 text-center">
                                            <input checked="" class="accent-tertiary rounded" type="checkbox" />
                                        </td>
                                        <td class="py-3 px-3">
                                            <div class="flex flex-col">
                                                <div class="flex items-center gap-space-xs">
                                                    <span class="font-headline-sm text-body-md font-bold text-on-surface group-hover:text-primary transition-colors">
                                                        churn_rf_v2
                                                    </span>
                                                    <span class="font-label-caps text-label-caps bg-tertiary-container text-tertiary px-1 py-0.2 rounded font-semibold">TARGET</span>
                                                </div>
                                                <span class="font-body-sm text-body-sm text-on-surface-variant truncate max-w-xs">
                                                    Random Forest Telecom Churn Predictor
                                                </span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-3">
                                            <span class="font-label-mono text-label-mono text-secondary bg-secondary-container px-2 py-0.5 rounded font-bold">
                                                v2.4.0
                                            </span>
                                        </td>
                                        <td class="py-3 px-3">
                                            <span class="font-label-caps text-label-caps text-on-tertiary bg-tertiary px-2 py-0.5 rounded-full inline-flex items-center gap-1 font-bold">
                                                <span class="w-1.5 h-1.5 rounded-full bg-on-tertiary"></span> PRODUCTION
                                            </span>
                                        </td>
                                        <td class="py-3 px-3 font-label-mono text-label-mono">
                                            <div class="flex items-center gap-space-xs">
                                                <span class="text-tertiary font-bold">0.80</span>
                                                <span class="text-outline">/</span>
                                                <span class="text-on-surface">0.84</span>
                                                <span class="text-outline">/</span>
                                                <span class="text-on-surface">0.89</span>
                                            </div>
                                            <div class="w-24 h-1 bg-surface-container-highest rounded-full overflow-hidden mt-1">
                                                <div class="w-4/5 h-full bg-tertiary"></div>
                                            </div>
                                        </td>
                                        <td class="py-3 px-3">
                                            <div class="flex flex-col font-label-mono text-label-mono">
                                                <span class="text-on-surface">Scikit-learn</span>
                                                <span class="text-outline">FastAPI / Gunicorn</span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-3">
                                            <div class="flex flex-col font-body-sm text-body-sm">
                                                <span class="text-on-surface font-medium">Sarah Chen (L2)</span>
                                                <a class="font-label-mono text-label-mono text-tertiary hover:underline" href="#">#AI-024</a>
                                            </div>
                                        </td>
                                        <td class="py-3 px-3 font-label-mono text-label-mono text-on-surface-variant whitespace-nowrap">
                                            14m ago
                                        </td>
                                        <td class="py-3 px-3 text-center">
                                            <div class="inline-flex items-center justify-center p-1 rounded-full bg-tertiary-container">
                                                <span class="w-2 h-2 rounded-full bg-tertiary animate-ping"></span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-3 text-right">
                                            <div class="flex items-center justify-end gap-1">
                                                <button class="p-1 rounded bg-surface-container text-tertiary hover:bg-surface-container-highest" title="Edit Metadata">
                                                    <span class="material-symbols-outlined text-[16px]">edit</span>
                                                </button>
                                                <button class="p-1 rounded bg-surface-container text-secondary hover:bg-surface-container-highest" title="Run Diagnostic Wand">
                                                    <span class="material-symbols-outlined text-[16px]">auto_fix_high</span>
                                                </button>
                                                <button class="p-1 rounded bg-surface-container text-primary hover:bg-surface-container-highest" title="Model Card Details">
                                                    <span class="material-symbols-outlined text-[16px]">visibility</span>
                                                </button>
                                                <button class="p-1 rounded bg-surface-container text-error hover:bg-surface-container-highest" title="Rollback Artifact">
                                                    <span class="material-symbols-outlined text-[16px]">replay</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Row 2 (Staging Candidate) -->
                                    <tr class="bg-surface-container-low hover:bg-surface-container-high transition-colors group">
                                        <td class="py-3 px-3 text-center">
                                            <input checked="" class="accent-tertiary rounded" type="checkbox" />
                                        </td>
                                        <td class="py-3 px-3">
                                            <div class="flex flex-col">
                                                <div class="flex items-center gap-space-xs">
                                                    <span class="font-headline-sm text-body-md font-bold text-on-surface group-hover:text-primary transition-colors">
                                                        churn_xgb_v3-rc1
                                                    </span>
                                                    <span class="font-label-caps text-label-caps bg-secondary-container text-secondary px-1 py-0.2 rounded font-semibold">CANDIDATE</span>
                                                </div>
                                                <span class="font-body-sm text-body-sm text-on-surface-variant truncate max-w-xs">
                                                    Extreme Gradient Boosting with Early Stopping
                                                </span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-3">
                                            <span class="font-label-mono text-label-mono text-on-surface bg-surface-container-high px-2 py-0.5 rounded font-bold">
                                                v3.0.0-rc1
                                            </span>
                                        </td>
                                        <td class="py-3 px-3">
                                            <span class="font-label-caps text-label-caps text-tertiary bg-tertiary-container px-2 py-0.5 rounded-full inline-flex items-center gap-1 font-bold">
                                                <span class="w-1.5 h-1.5 rounded-full bg-tertiary"></span> STAGING
                                            </span>
                                        </td>
                                        <td class="py-3 px-3 font-label-mono text-label-mono">
                                            <div class="flex items-center gap-space-xs">
                                                <span class="text-tertiary font-bold">0.82</span>
                                                <span class="text-outline">/</span>
                                                <span class="text-on-surface">0.81</span>
                                                <span class="text-outline">/</span>
                                                <span class="text-on-surface">0.91</span>
                                            </div>
                                            <div class="w-24 h-1 bg-surface-container-highest rounded-full overflow-hidden mt-1">
                                                <div class="w-[82%] h-full bg-secondary"></div>
                                            </div>
                                        </td>
                                        <td class="py-3 px-3">
                                            <div class="flex flex-col font-label-mono text-label-mono">
                                                <span class="text-on-surface">XGBoost 1.7.6</span>
                                                <span class="text-outline">FastAPI / ONNX Runt.</span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-3">
                                            <div class="flex flex-col font-body-sm text-body-sm">
                                                <span class="text-on-surface font-medium">Sarah Chen (L2)</span>
                                                <a class="font-label-mono text-label-mono text-tertiary hover:underline" href="#">#AI-024</a>
                                            </div>
                                        </td>
                                        <td class="py-3 px-3 font-label-mono text-label-mono text-on-surface-variant whitespace-nowrap">
                                            2h ago
                                        </td>
                                        <td class="py-3 px-3 text-center">
                                            <div class="inline-flex items-center justify-center p-1 rounded bg-secondary-container">
                                                <span class="material-symbols-outlined text-secondary text-[14px] animate-spin">refresh</span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-3 text-right">
                                            <div class="flex items-center justify-end gap-1">
                                                <button class="p-1 rounded bg-surface-container text-on-surface hover:bg-surface-container-highest" title="Edit Metadata">
                                                    <span class="material-symbols-outlined text-[16px]">edit</span>
                                                </button>
                                                <button class="p-1 rounded bg-surface-container text-secondary hover:bg-surface-container-highest" title="Run PyTests">
                                                    <span class="material-symbols-outlined text-[16px]">play_circle</span>
                                                </button>
                                                <button class="p-1 rounded bg-surface-container text-primary hover:bg-surface-container-highest" title="Model Card Details">
                                                    <span class="material-symbols-outlined text-[16px]">visibility</span>
                                                </button>
                                                <button class="p-1 rounded bg-surface-container text-outline hover:bg-surface-container-highest opacity-50 cursor-not-allowed" title="Rollback">
                                                    <span class="material-symbols-outlined text-[16px]">replay</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Row 3: telemetry_anomaly_lstm -->
                                    <tr class="bg-surface-container-low hover:bg-surface-container-high transition-colors group">
                                        <td class="py-3 px-3 text-center">
                                            <input class="accent-tertiary rounded" type="checkbox" />
                                        </td>
                                        <td class="py-3 px-3">
                                            <div class="flex flex-col">
                                                <span class="font-headline-sm text-body-md font-bold text-on-surface group-hover:text-primary transition-colors">
                                                    telemetry_anomaly_lstm
                                                </span>
                                                <span class="font-body-sm text-body-sm text-on-surface-variant truncate max-w-xs">
                                                    Vibration &amp; Acoustic Industrial Sensor Stream
                                                </span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-3">
                                            <span class="font-label-mono text-label-mono text-on-surface bg-surface-container-high px-2 py-0.5 rounded font-bold">
                                                v1.8.2
                                            </span>
                                        </td>
                                        <td class="py-3 px-3">
                                            <span class="font-label-caps text-label-caps text-on-tertiary bg-tertiary px-2 py-0.5 rounded-full inline-flex items-center gap-1 font-bold">
                                                <span class="w-1.5 h-1.5 rounded-full bg-on-tertiary"></span> PRODUCTION
                                            </span>
                                        </td>
                                        <td class="py-3 px-3 font-label-mono text-label-mono">
                                            <div class="flex items-center gap-space-xs">
                                                <span class="text-tertiary font-bold">0.91</span>
                                                <span class="text-outline">/</span>
                                                <span class="text-on-surface">0.93</span>
                                                <span class="text-outline">/</span>
                                                <span class="text-on-surface">0.96</span>
                                            </div>
                                            <div class="w-24 h-1 bg-surface-container-highest rounded-full overflow-hidden mt-1">
                                                <div class="w-[91%] h-full bg-tertiary"></div>
                                            </div>
                                        </td>
                                        <td class="py-3 px-3">
                                            <div class="flex flex-col font-label-mono text-label-mono">
                                                <span class="text-on-surface">PyTorch 2.1.0</span>
                                                <span class="text-outline">TorchScript C++ Lib</span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-3">
                                            <div class="flex flex-col font-body-sm text-body-sm">
                                                <span class="text-on-surface font-medium">V. Kiselev (Sr MLE)</span>
                                                <a class="font-label-mono text-label-mono text-outline hover:underline" href="#">#AI-018</a>
                                            </div>
                                        </td>
                                        <td class="py-3 px-3 font-label-mono text-label-mono text-on-surface-variant whitespace-nowrap">
                                            4d ago
                                        </td>
                                        <td class="py-3 px-3 text-center">
                                            <div class="inline-flex items-center justify-center p-1 rounded-full bg-tertiary-container">
                                                <span class="w-2 h-2 rounded-full bg-tertiary"></span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-3 text-right">
                                            <div class="flex items-center justify-end gap-1">
                                                <button class="p-1 rounded bg-surface-container text-on-surface hover:bg-surface-container-highest">
                                                    <span class="material-symbols-outlined text-[16px]">edit</span>
                                                </button>
                                                <button class="p-1 rounded bg-surface-container text-secondary hover:bg-surface-container-highest">
                                                    <span class="material-symbols-outlined text-[16px]">auto_fix_high</span>
                                                </button>
                                                <button class="p-1 rounded bg-surface-container text-primary hover:bg-surface-container-highest">
                                                    <span class="material-symbols-outlined text-[16px]">visibility</span>
                                                </button>
                                                <button class="p-1 rounded bg-surface-container text-error hover:bg-surface-container-highest">
                                                    <span class="material-symbols-outlined text-[16px]">replay</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Row 4: crm_lead_propensity_v1 -->
                                    <tr class="bg-surface-container-low hover:bg-surface-container-high transition-colors group">
                                        <td class="py-3 px-3 text-center">
                                            <input class="accent-tertiary rounded" type="checkbox" />
                                        </td>
                                        <td class="py-3 px-3">
                                            <div class="flex flex-col">
                                                <span class="font-headline-sm text-body-md font-bold text-on-surface group-hover:text-primary transition-colors">
                                                    crm_lead_propensity_v1
                                                </span>
                                                <span class="font-body-sm text-body-sm text-on-surface-variant truncate max-w-xs">
                                                    Inbound Enterprise Lead Conversion Classifier
                                                </span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-3">
                                            <span class="font-label-mono text-label-mono text-on-surface bg-surface-container-high px-2 py-0.5 rounded font-bold">
                                                v1.1.0
                                            </span>
                                        </td>
                                        <td class="py-3 px-3">
                                            <span class="font-label-caps text-label-caps text-on-tertiary bg-tertiary px-2 py-0.5 rounded-full inline-flex items-center gap-1 font-bold">
                                                <span class="w-1.5 h-1.5 rounded-full bg-on-tertiary"></span> PRODUCTION
                                            </span>
                                        </td>
                                        <td class="py-3 px-3 font-label-mono text-label-mono">
                                            <div class="flex items-center gap-space-xs">
                                                <span class="text-tertiary font-bold">0.77</span>
                                                <span class="text-outline">/</span>
                                                <span class="text-on-surface">0.79</span>
                                                <span class="text-outline">/</span>
                                                <span class="text-on-surface">0.83</span>
                                            </div>
                                            <div class="w-24 h-1 bg-surface-container-highest rounded-full overflow-hidden mt-1">
                                                <div class="w-[77%] h-full bg-tertiary"></div>
                                            </div>
                                        </td>
                                        <td class="py-3 px-3">
                                            <div class="flex flex-col font-label-mono text-label-mono">
                                                <span class="text-on-surface">Scikit-learn</span>
                                                <span class="text-outline">Triton Inference</span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-3">
                                            <div class="flex flex-col font-body-sm text-body-sm">
                                                <span class="text-on-surface font-medium">M. Dupont</span>
                                                <a class="font-label-mono text-label-mono text-outline hover:underline" href="#">#AI-011</a>
                                            </div>
                                        </td>
                                        <td class="py-3 px-3 font-label-mono text-label-mono text-on-surface-variant whitespace-nowrap">
                                            12d ago
                                        </td>
                                        <td class="py-3 px-3 text-center">
                                            <div class="inline-flex items-center justify-center p-1 rounded-full bg-tertiary-container">
                                                <span class="w-2 h-2 rounded-full bg-tertiary"></span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-3 text-right">
                                            <div class="flex items-center justify-end gap-1">
                                                <button class="p-1 rounded bg-surface-container text-on-surface hover:bg-surface-container-highest">
                                                    <span class="material-symbols-outlined text-[16px]">edit</span>
                                                </button>
                                                <button class="p-1 rounded bg-surface-container text-secondary hover:bg-surface-container-highest">
                                                    <span class="material-symbols-outlined text-[16px]">auto_fix_high</span>
                                                </button>
                                                <button class="p-1 rounded bg-surface-container text-primary hover:bg-surface-container-highest">
                                                    <span class="material-symbols-outlined text-[16px]">visibility</span>
                                                </button>
                                                <button class="p-1 rounded bg-surface-container text-error hover:bg-surface-container-highest">
                                                    <span class="material-symbols-outlined text-[16px]">replay</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Row 5: churn_logreg_baseline -->
                                    <tr class="bg-surface-container-lowest/80 hover:bg-surface-container-high transition-colors opacity-75 group">
                                        <td class="py-3 px-3 text-center">
                                            <input class="accent-tertiary rounded" type="checkbox" />
                                        </td>
                                        <td class="py-3 px-3">
                                            <div class="flex flex-col">
                                                <span class="font-headline-sm text-body-md font-bold text-on-surface-variant group-hover:text-primary transition-colors">
                                                    churn_logreg_baseline
                                                </span>
                                                <span class="font-body-sm text-body-sm text-outline truncate max-w-xs">
                                                    Initial Logistic Regression POC Baseline
                                                </span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-3">
                                            <span class="font-label-mono text-label-mono text-outline bg-surface-container px-2 py-0.5 rounded font-bold">
                                                v1.0.0
                                            </span>
                                        </td>
                                        <td class="py-3 px-3">
                                            <span class="font-label-caps text-label-caps text-outline bg-surface-container-high px-2 py-0.5 rounded-full inline-flex items-center gap-1 font-semibold">
                                                <span class="w-1.5 h-1.5 rounded-full bg-outline"></span> ARCHIVED
                                            </span>
                                        </td>
                                        <td class="py-3 px-3 font-label-mono text-label-mono">
                                            <div class="flex items-center gap-space-xs">
                                                <span class="text-outline">0.69</span>
                                                <span class="text-outline">/</span>
                                                <span class="text-outline">0.65</span>
                                                <span class="text-outline">/</span>
                                                <span class="text-outline">0.71</span>
                                            </div>
                                            <div class="w-24 h-1 bg-surface-container rounded-full overflow-hidden mt-1">
                                                <div class="w-[69%] h-full bg-outline"></div>
                                            </div>
                                        </td>
                                        <td class="py-3 px-3">
                                            <div class="flex flex-col font-label-mono text-label-mono">
                                                <span class="text-outline">Scikit-learn</span>
                                                <span class="text-outline">Pickle Raw / Deprec.</span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-3">
                                            <div class="flex flex-col font-body-sm text-body-sm">
                                                <span class="text-outline">Sarah Chen</span>
                                                <span class="font-label-mono text-label-mono text-outline">Sprint-01</span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-3 font-label-mono text-label-mono text-outline whitespace-nowrap">
                                            28d ago
                                        </td>
                                        <td class="py-3 px-3 text-center">
                                            <div class="inline-flex items-center justify-center p-1 rounded-full bg-surface-container">
                                                <span class="w-2 h-2 rounded-full bg-outline"></span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-3 text-right">
                                            <div class="flex items-center justify-end gap-1">
                                                <button class="p-1 rounded bg-surface-container text-outline hover:bg-surface-container-highest" title="Inspect Archived Manifest">
                                                    <span class="material-symbols-outlined text-[16px]">inventory_2</span>
                                                </button>
                                                <button class="p-1 rounded bg-surface-container text-outline hover:bg-surface-container-highest" title="View Lineage">
                                                    <span class="material-symbols-outlined text-[16px]">account_tree</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- Table Footer Micro-bar -->
                        <div class="bg-surface-container-high px-space-md py-2 flex items-center justify-between font-label-mono text-label-mono text-outline">
                            <div>SHOWING 1 TO 5 OF 18 ARTIFACT RUNS</div>
                            <div class="flex items-center gap-space-xs">
                                <button class="px-2 py-0.5 rounded bg-surface-container text-on-surface hover:bg-surface-container-highest">PREV</button>
                                <span class="px-2 py-0.5 rounded bg-surface-container-lowest text-tertiary">PAGE 1 / 4</span>
                                <button class="px-2 py-0.5 rounded bg-surface-container text-on-surface hover:bg-surface-container-highest">NEXT</button>
                            </div>
                        </div>
                    </div>
                    <!-- Side Comparison Drawer Preview (4 cols) -->
                    <div class="lg:col-span-4 bg-surface-container-high rounded-xl p-space-md shadow-xl flex flex-col gap-space-md" id="compareDrawer">
                        <!-- Drawer Header -->
                        <div class="flex items-center justify-between bg-surface-container-lowest p-space-sm rounded-lg">
                            <div class="flex items-center gap-space-xs">
                                <span class="material-symbols-outlined text-secondary text-[20px]">troubleshoot</span>
                                <div class="flex flex-col">
                                    <span class="font-headline-sm text-body-sm text-on-surface font-semibold">DELTA COMPARISON</span>
                                    <span class="font-label-mono text-label-mono text-outline">diff: prod vs staging candidate</span>
                                </div>
                            </div>
                            <span class="font-label-caps text-label-caps bg-tertiary-container text-tertiary px-1.5 py-0.5 rounded font-bold">
                                2 SELECTED
                            </span>
                        </div>
                        <!-- Paired Model Headers -->
                        <div class="grid grid-cols-2 gap-space-sm">
                            <div class="bg-surface-container-low p-space-sm rounded-lg flex flex-col">
                                <span class="font-label-caps text-label-caps text-tertiary">BASELINE (LIVE)</span>
                                <span class="font-headline-sm text-body-sm text-on-surface font-bold truncate">churn_rf_v2</span>
                                <span class="font-label-mono text-label-mono text-outline">v2.4.0 · Scikit</span>
                            </div>
                            <div class="bg-surface-container-low p-space-sm rounded-lg flex flex-col">
                                <span class="font-label-caps text-label-caps text-secondary">CHALLENGER (STG)</span>
                                <span class="font-headline-sm text-body-sm text-on-surface font-bold truncate">churn_xgb_v3</span>
                                <span class="font-label-mono text-label-mono text-outline">v3.0.0-rc1 · XGB</span>
                            </div>
                        </div>
                        <!-- Metric Deltas Matrix -->
                        <div class="flex flex-col gap-space-xs font-label-mono text-label-mono">
                            <span class="font-label-caps text-label-caps text-outline uppercase tracking-wider mb-1">EVALUATION METRIC SHIFTS</span>
                            <!-- Metric Item: F1 Score -->
                            <div class="bg-surface-container-low p-2 rounded-lg flex items-center justify-between">
                                <div class="flex flex-col">
                                    <span class="font-body-sm text-body-sm text-on-surface font-medium">Macro F1 Score</span>
                                    <span class="text-outline text-[10px]">0.800 → 0.820</span>
                                </div>
                                <div class="flex items-center gap-1 text-tertiary font-bold bg-tertiary-container px-2 py-0.5 rounded">
                                    <span class="material-symbols-outlined text-[14px]">arrow_upward</span>
                                    <span>+0.020 (+2.5%)</span>
                                </div>
                            </div>
                            <!-- Metric Item: Latency -->
                            <div class="bg-surface-container-low p-2 rounded-lg flex items-center justify-between">
                                <div class="flex flex-col">
                                    <span class="font-body-sm text-body-sm text-on-surface font-medium">Inference Latency (p95)</span>
                                    <span class="text-outline text-[10px]">34ms → 22ms</span>
                                </div>
                                <div class="flex items-center gap-1 text-secondary font-bold bg-secondary-container px-2 py-0.5 rounded">
                                    <span class="material-symbols-outlined text-[14px]">bolt</span>
                                    <span>-12ms (-35%)</span>
                                </div>
                            </div>
                            <!-- Metric Item: Docker Image Size -->
                            <div class="bg-surface-container-low p-2 rounded-lg flex items-center justify-between">
                                <div class="flex flex-col">
                                    <span class="font-body-sm text-body-sm text-on-surface font-medium">OCI Container Size</span>
                                    <span class="text-outline text-[10px]">342MB → 346MB</span>
                                </div>
                                <div class="flex items-center gap-1 text-outline font-bold bg-surface-container px-2 py-0.5 rounded">
                                    <span class="material-symbols-outlined text-[14px]">layers</span>
                                    <span>+4MB (+1.1%)</span>
                                </div>
                            </div>
                            <!-- Metric Item: False Positive Rate -->
                            <div class="bg-surface-container-low p-2 rounded-lg flex items-center justify-between">
                                <div class="flex flex-col">
                                    <span class="font-body-sm text-body-sm text-on-surface font-medium">False Positive Drift</span>
                                    <span class="text-outline text-[10px]">4.2% → 3.8%</span>
                                </div>
                                <div class="flex items-center gap-1 text-secondary font-bold bg-secondary-container px-2 py-0.5 rounded">
                                    <span class="material-symbols-outlined text-[14px]">check_circle</span>
                                    <span>-0.4% NOMINAL</span>
                                </div>
                            </div>
                        </div>
                        <!-- Visual Metric Comparison SVG Micro-chart -->
                        <div class="bg-surface-container-low p-space-sm rounded-lg flex flex-col gap-1">
                            <div class="flex items-center justify-between font-label-caps text-label-caps text-outline">
                                <span>FEATURE DRIFT SPECTRUM</span>
                                <span class="text-tertiary">CONFIDENCE: 98.4%</span>
                            </div>
                            <div class="w-full h-12 flex items-center">
                                <svg class="w-full h-full text-secondary" fill="none" preserveaspectratio="none" viewbox="0 0 240 40">
                                    <!-- Grid Lines -->
                                    <line stroke="currentColor" stroke-dasharray="2 2" stroke-opacity="0.1" x1="0" x2="240" y1="20" y2="20"></line>
                                    <line stroke="currentColor" stroke-opacity="0.1" x1="0" x2="240" y1="35" y2="35"></line>
                                    <!-- Baseline Line (amber) -->
                                    <polyline fill="none" points="0,28 30,25 60,30 90,22 120,26 150,20 180,24 210,18 240,22" stroke="#ffb956" stroke-width="1.5"></polyline>
                                    <!-- Challenger Line (secondary blue) -->
                                    <polyline fill="none" points="0,25 30,18 60,20 90,14 120,16 150,11 180,15 210,10 240,8" stroke="#abc9f2" stroke-width="2"></polyline>
                                </svg>
                            </div>
                            <div class="flex justify-between font-label-mono text-label-mono text-outline text-[10px]">
                                <span class="text-tertiary">■ churn_rf_v2</span>
                                <span class="text-secondary">■ churn_xgb_v3-rc1</span>
                            </div>
                        </div>
                        <!-- Action Footer for Drawer -->
                        <div class="flex flex-col gap-space-xs pt-space-xs">
                            <button class="w-full py-2 bg-secondary text-on-secondary font-headline-sm text-body-sm font-semibold rounded-lg hover:bg-secondary-fixed transition-colors flex items-center justify-center gap-1 shadow-md">
                                <span class="material-symbols-outlined text-[18px]">publish</span>
                                <span>Promote churn_xgb_v3 to Canary</span>
                            </button>
                            <button class="w-full py-1.5 bg-surface-container text-on-surface-variant font-headline-sm text-body-sm rounded-lg hover:text-on-surface hover:bg-surface-container-highest transition-colors text-center font-medium">
                                Open Side-by-Side Model Card Diff
                            </button>
                        </div>
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