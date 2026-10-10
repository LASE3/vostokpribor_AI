<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="web_dashboard" name="shell-type" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=JetBrains+Mono:wght@400;500;600&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="css/style.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="js/tailwind.config.js"></script>
</head>

<body class="bg-surface font-body-md text-body-md text-on-surface antialiased bg-fiberglass">
    <aside class="fixed left-0 top-0 h-screen w-64 bg-surface-container-lowest z-50 flex flex-col justify-between shadow-[0_1px_8px_rgba(0,0,0,0.04)]">
        <div class="flex flex-col">
            <div class="h-16 px-space-lg flex items-center gap-space-sm bg-surface-container-low">
                <div class="flex items-center justify-center w-6 h-6 rounded bg-primary text-on-primary font-label-sm text-label-sm">VK</div>
                <div class="flex flex-col"><span class="font-label-md text-label-md text-primary font-semibold tracking-wider uppercase">Telemetry Range</span><span class="font-label-sm text-label-sm text-on-surface-variant font-code-inline">COHORT-24B::AI-ENG</span></div>
            </div>
            <div class="px-space-md py-space-sm"><span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider font-semibold px-space-sm">Operations &amp; Tasks</span></div>
            <nav class="flex flex-col gap-space-xs px-space-md" data-active-classes="bg-primary text-on-primary font-semibold shadow-[0_1px_3px_rgba(76,29,149,0.12)]"><a aria-current="page" class="flex items-center gap-space-md px-space-md py-space-sm rounded transition-colors bg-primary text-on-primary font-semibold shadow-[0_1px_3px_rgba(76,29,149,0.12)]" data-path="dashboard" href="Dashboard.php"><span class="material-symbols-outlined text-[18px]">space_dashboard</span><span>Dashboard</span></a><a class="flex items-center gap-space-md px-space-md py-space-sm rounded text-on-surface-variant font-body-md text-body-md hover:bg-surface-container-high hover:text-on-surface transition-colors" data-path="my-tickets" href="Tickets.php"><span class="material-symbols-outlined text-[18px]">assignment</span><span>My Tickets</span></a><a class="flex items-center gap-space-md px-space-md py-space-sm rounded text-on-surface-variant font-body-md text-body-md hover:bg-surface-container-high hover:text-on-surface transition-colors" data-path="ticket-details" href="TicketDetails.php"><span class="material-symbols-outlined text-[18px]">description</span><span>Ticket Details</span></a><a class="flex items-center gap-space-md px-space-md py-space-sm rounded text-on-surface-variant font-body-md text-body-md hover:bg-surface-container-high hover:text-on-surface transition-colors" data-path="my-submissions" href="Submissions.php"><span class="material-symbols-outlined text-[18px]">inventory_2</span><span>My Submissions</span></a><a class="flex items-center justify-between px-space-md py-space-sm rounded text-on-surface-variant font-body-md text-body-md hover:bg-surface-container-high hover:text-on-surface transition-colors" data-path="notifications" href="Dashboard.php">
                    <div class="flex items-center gap-space-md"><span class="material-symbols-outlined text-[18px]">notifications</span><span>Notifications</span></div><span class="px-1.5 py-0.5 rounded font-label-sm text-label-sm bg-secondary-container text-on-secondary-container">3</span>
                </a><a class="flex items-center gap-space-md px-space-md py-space-sm rounded text-on-surface-variant font-body-md text-body-md hover:bg-surface-container-high hover:text-on-surface transition-colors" data-path="student-profile" href="StudentProfile.php"><span class="material-symbols-outlined text-[18px]">badge</span><span>Student Profile</span></a></nav>
        </div>
        <div class="flex flex-col bg-surface-container-low p-space-md m-space-sm rounded gap-space-sm">
            <div class="flex items-center justify-between"><span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider font-semibold">Range Subsystems</span><span class="font-label-sm text-label-sm text-on-tertiary-container font-code-inline">v4.18</span></div>
            <div class="grid grid-cols-2 gap-space-xs"><a class="flex items-center gap-space-xs p-1.5 rounded bg-surface-container-lowest text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface font-label-sm text-label-sm transition-colors" href="../Data Center/dashboard.php"><span class="material-symbols-outlined text-[14px] text-primary">database</span>SYS-02 Data</a><a class="flex items-center gap-space-xs p-1.5 rounded bg-surface-container-lowest text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface font-label-sm text-label-sm transition-colors" href="../ML Workbench/NotebookWorkbench.php"><span class="material-symbols-outlined text-[14px] text-primary">terminal</span>SYS-03 NB</a><a class="flex items-center gap-space-xs p-1.5 rounded bg-surface-container-lowest text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface font-label-sm text-label-sm transition-colors" href="../Model Registry & Deployment/dashboard.php"><span class="material-symbols-outlined text-[14px] text-primary">hub</span>SYS-04 Reg</a><a class="flex items-center gap-space-xs p-1.5 rounded bg-surface-container-lowest text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface font-label-sm text-label-sm transition-colors" href="../AI Operations Center (AI SOC)/TicketsAndScenarios.php"><span class="material-symbols-outlined text-[14px] text-primary">settings</span>SYS-05 Ops</a></div>
            <div class="pt-space-xs flex items-center justify-between text-on-surface-variant"><a class="flex items-center gap-space-xs font-label-sm text-label-sm text-on-surface-variant hover:text-primary transition-colors" href="../index.php"><span class="material-symbols-outlined text-[14px]">home</span><span>Flight Deck Home</span></a><span class="font-label-sm text-label-sm text-on-tertiary-container font-code-inline">ONLINE</span></div>
        </div>
    </aside>
    <div class="pl-64">
        <header class="fixed top-0 left-64 right-0 z-40 bg-surface-container-lowest/90 backdrop-blur-md shadow-[0_1px_8px_rgba(0,0,0,0.04)]">
            <div class="h-16 w-full px-gutter-desktop flex items-center justify-between gap-space-md">
                <div class="flex items-center gap-space-lg">
                    <div class="flex items-center gap-space-sm"><img alt="VOSTOKPRIBOR Logo" class="h-8 w-auto object-contain" src="https://lh3.googleusercontent.com/aida/AEtjO1ULXUBEqKB3MtounXs991RVWsiqjz4ZU01Mz79VKjRhaENNCHdDB9DW4lH6_0tbZlIsxzHSnw1p4Ja_zHGmh65md2asH8x4qe6X4XXeeRHM11eD6HREhIyI5gwKKBHv1_UNfdbJ6jGtHaRLP4uaH3Yszfk5atKNiaIsoNQgrb4p4zVvTw3uuWefsO5X31ioW8lqe5kJgrk0pH1b0cG49htkVSXHmpf8PC4tRtbSG8gTehhPcrWeWf-R49U" /><span class="font-headline-md text-headline-md font-bold text-primary tracking-tight hidden lg:inline">VOSTOKPRIBOR</span></div>
                    <div class="flex items-center gap-space-xs px-space-md py-1.5 rounded bg-surface-container font-label-md text-label-md text-primary cursor-pointer hover:bg-surface-container-high transition-colors"><span class="material-symbols-outlined text-[16px] text-primary">tune</span><span class="font-semibold">SYS-AI-01: AI Project &amp; Ticket Mgmt</span><span class="material-symbols-outlined text-[16px]">arrow_drop_down</span></div>
                    <div class="hidden xl:flex items-center gap-space-xs px-space-sm py-1 rounded bg-tertiary-fixed font-label-sm text-label-sm text-on-tertiary-fixed font-code-inline"><span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span><span>Scenario: Churn Prediction (AI-024)</span></div>
                </div>
                <div class="flex items-center gap-space-md">
                    <div class="hidden 2xl:flex items-center gap-space-sm px-space-sm py-1 rounded bg-surface-container-low font-label-sm text-label-sm text-on-surface-variant font-code-inline"><span class="text-primary font-semibold">TLM:</span><span class="text-on-tertiary-container font-bold">NOMINAL</span><span class="text-outline-variant">|</span><span class="text-primary font-semibold">NODE:</span><span class="text-on-surface">OK</span></div>
                    <div class="relative flex items-center justify-center p-2 rounded hover:bg-surface-container-high cursor-pointer text-on-surface-variant transition-colors"><span class="material-symbols-outlined text-[20px]">notifications</span><span class="absolute top-1.5 right-1.5 flex h-2 w-2"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-error opacity-75"></span><span class="relative inline-flex rounded-full h-2 w-2 bg-error"></span></span></div>
                    <div class="flex items-center gap-space-sm pl-space-sm">
                        <div class="flex flex-col text-right hidden sm:flex"><span class="font-label-md text-label-md font-semibold text-on-surface">Alex Chen</span><span class="font-label-sm text-label-sm text-on-surface-variant font-code-inline">VK-88219</span></div>
                        <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center"><span class="material-symbols-outlined text-on-primary text-[18px]">person</span></div>
                    </div>
                </div>
            </div>
        </header>
        <main class="relative pt-16 w-full min-h-screen">
            <div class="flex flex-col w-full">
                <div class="px-margin-desktop py-space-xl flex flex-col gap-space-xl">
                    <!-- Welcome Header & Live Scenario Bar -->
                    <div class="flex flex-col gap-space-md">
                        <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-space-md">
                            <div class="flex flex-col gap-space-xs">
                                <div class="flex items-center gap-space-sm">
                                    <span class="inline-flex items-center justify-center px-space-sm py-0.5 rounded bg-tertiary-fixed text-on-tertiary-fixed font-label-sm text-label-sm uppercase font-semibold">
                                        RANGE NODE ACTIVE
                                    </span>
                                    <span class="font-code-inline text-code-inline text-on-surface-variant">SYS-AI-01 // COHORT 24-B</span>
                                </div>
                                <h1 class="font-headline-xl text-headline-xl text-primary font-bold tracking-tight">
                                    Welcome back, Eng. Alex Chen
                                </h1>
                                <p class="font-body-md text-body-md text-on-surface-variant">
                                    Industrial AI Range Engineering Operations &amp; Verification Terminal. All telemetry links synchronized.
                                </p>
                            </div>
                            <!-- Quick Action Buttons -->
                            <div class="flex flex-wrap items-center gap-space-sm">
                                <button class="flex items-center gap-space-xs px-space-md py-space-sm rounded bg-primary text-on-primary font-label-md text-label-md font-semibold hover:bg-primary-container transition-all shadow-sm">
                                    <span class="material-symbols-outlined text-[16px]">terminal</span>
                                    <span>Open Active Workspace</span>
                                </button>
                                <button class="flex items-center gap-space-xs px-space-md py-space-sm rounded bg-secondary-container text-on-secondary-container font-label-md text-label-md font-semibold hover:bg-secondary-fixed transition-all">
                                    <span class="material-symbols-outlined text-[16px]">dataset</span>
                                    <span>Browse Scenario Catalog</span>
                                </button>
                                <button class="flex items-center gap-space-xs px-space-md py-space-sm rounded bg-surface-container-high text-primary font-label-md text-label-md font-semibold hover:bg-surface-variant transition-all">
                                    <span class="material-symbols-outlined text-[16px]">publish</span>
                                    <span>Submit Work Unit</span>
                                </button>
                            </div>
                        </div>
                        <!-- Mission Status Sub-Bar -->
                        <div class="flex flex-col lg:flex-row items-stretch lg:items-center justify-between p-space-md rounded bg-surface-container-lowest shadow-sm gap-space-md">
                            <div class="flex flex-wrap items-center gap-space-md">
                                <div class="flex items-center gap-space-xs">
                                    <span class="h-2.5 w-2.5 rounded-full bg-primary animate-pulse"></span>
                                    <span class="font-label-md text-label-md text-on-surface uppercase font-semibold tracking-wider">Active Scenario:</span>
                                    <span class="font-code-inline text-code-inline text-primary font-medium">Customer Churn Prediction (Telecommunication Tier-1)</span>
                                </div>
                                <span class="text-outline-variant hidden sm:inline">•</span>
                                <div class="flex items-center gap-space-xs">
                                    <span class="material-symbols-outlined text-secondary text-[16px]">target</span>
                                    <span class="font-label-sm text-label-sm text-on-surface-variant">TARGET METRIC:</span>
                                    <span class="font-code-inline text-code-inline text-on-surface font-semibold bg-surface-container-high px-1.5 py-0.5 rounded">F1 ≥ 0.82</span>
                                </div>
                                <span class="text-outline-variant hidden sm:inline">•</span>
                                <div class="flex items-center gap-space-xs">
                                    <span class="material-symbols-outlined text-secondary text-[16px]">dns</span>
                                    <span class="font-label-sm text-label-sm text-on-surface-variant">CLUSTER:</span>
                                    <span class="font-code-inline text-code-inline text-on-surface font-medium">US-WEST-GPU-3</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-space-sm self-end lg:self-center font-code-inline text-label-sm text-on-surface-variant">
                                <span class="w-2 h-2 rounded-full bg-surface-tint"></span>
                                <span>GPU LOAD: 74.2%</span>
                                <span class="text-outline-variant">|</span>
                                <span>LATENCY: 31ms</span>
                            </div>
                        </div>
                    </div>
                    <!-- Key Metrics 5-Card Grid -->
                    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-space-md">
                        <!-- Card 1 -->
                        <div class="p-space-lg rounded bg-surface-container-lowest flex flex-col justify-between shadow-sm relative overflow-hidden group">
                            <div class="flex items-center justify-between mb-space-sm">
                                <span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider font-semibold">Assigned Tickets</span>
                                <span class="px-1.5 py-0.5 rounded bg-tertiary-fixed text-on-tertiary-fixed font-code-inline text-label-sm font-bold">2 NEW</span>
                            </div>
                            <div class="flex items-baseline gap-space-sm">
                                <span class="font-headline-xl text-headline-xl text-primary font-bold">8</span>
                                <span class="font-label-sm text-label-sm text-on-surface-variant">total backlog</span>
                            </div>
                            <div class="mt-space-md flex items-center gap-space-xs text-on-surface-variant font-code-inline text-label-sm">
                                <span class="material-symbols-outlined text-[14px] text-primary">inbox</span>
                                <span>Cohort pool v4</span>
                            </div>
                        </div>
                        <!-- Card 2 -->
                        <div class="p-space-lg rounded bg-surface-container-lowest flex flex-col justify-between shadow-sm relative overflow-hidden group">
                            <div class="flex items-center justify-between mb-space-sm">
                                <span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider font-semibold">In Progress</span>
                                <span class="flex h-2 w-2 rounded-full bg-primary animate-ping"></span>
                            </div>
                            <div class="flex items-baseline gap-space-sm">
                                <span class="font-headline-xl text-headline-xl text-primary font-bold">3</span>
                                <span class="font-label-sm text-label-sm text-on-surface-variant">tickets</span>
                            </div>
                            <div class="mt-space-md flex items-center gap-space-xs text-on-surface-variant font-code-inline text-label-sm">
                                <span class="material-symbols-outlined text-[14px] text-secondary">show_chart</span>
                                <span>Live telemetry active</span>
                            </div>
                        </div>
                        <!-- Card 3 -->
                        <div class="p-space-lg rounded bg-surface-container-lowest flex flex-col justify-between shadow-sm relative overflow-hidden group">
                            <div class="flex items-center justify-between mb-space-sm">
                                <span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider font-semibold">Pending Submit</span>
                                <span class="px-1.5 py-0.5 rounded bg-secondary-container text-on-secondary-container font-code-inline text-label-sm">FROZEN</span>
                            </div>
                            <div class="flex items-baseline gap-space-sm">
                                <span class="font-headline-xl text-headline-xl text-primary font-bold">2</span>
                                <span class="font-label-sm text-label-sm text-on-surface-variant">locked</span>
                            </div>
                            <div class="mt-space-md flex items-center gap-space-xs text-on-surface-variant font-code-inline text-label-sm">
                                <span class="material-symbols-outlined text-[14px] text-primary">lock_clock</span>
                                <span>Ready for audit</span>
                            </div>
                        </div>
                        <!-- Card 4 -->
                        <div class="p-space-lg rounded bg-surface-container-lowest flex flex-col justify-between shadow-sm relative overflow-hidden group">
                            <div class="flex items-center justify-between mb-space-sm">
                                <span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider font-semibold">Completed</span>
                                <span class="material-symbols-outlined text-[16px] text-secondary">verified</span>
                            </div>
                            <div class="flex items-baseline gap-space-sm">
                                <span class="font-headline-xl text-headline-xl text-primary font-bold">3</span>
                                <span class="font-label-sm text-label-sm text-on-surface-variant">passed</span>
                            </div>
                            <div class="mt-space-md flex items-center gap-space-xs text-on-surface-variant font-code-inline text-label-sm">
                                <span class="material-symbols-outlined text-[14px] text-primary">check_circle</span>
                                <span>Instructors signed</span>
                            </div>
                        </div>
                        <!-- Card 5 -->
                        <div class="p-space-lg rounded bg-surface-container-lowest flex flex-col justify-between shadow-sm col-span-2 md:col-span-1 relative overflow-hidden group">
                            <div class="flex items-center justify-between mb-space-sm">
                                <span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider font-semibold">Overdue Breaches</span>
                                <span class="px-1.5 py-0.5 rounded bg-surface-container-high text-primary font-code-inline text-label-sm font-semibold">100% SLA</span>
                            </div>
                            <div class="flex items-baseline gap-space-sm">
                                <span class="font-headline-xl text-headline-xl text-primary font-bold">0</span>
                                <span class="font-label-sm text-label-sm text-on-surface-variant">incidents</span>
                            </div>
                            <div class="mt-space-md flex items-center gap-space-xs text-on-surface-variant font-code-inline text-label-sm">
                                <span class="material-symbols-outlined text-[14px] text-primary">shield</span>
                                <span>Zero penalty record</span>
                            </div>
                        </div>
                    </div>
                    <!-- Active Hero Workstation Ticket AI-024 -->
                    <div class="rounded bg-surface-container-lowest p-space-xl flex flex-col gap-space-lg shadow-sm relative overflow-hidden">
                        <div class="flex flex-col lg:flex-row lg:items-start justify-between gap-space-md">
                            <div class="flex flex-col gap-space-xs max-w-3xl">
                                <div class="flex flex-wrap items-center gap-space-sm">
                                    <span class="px-space-sm py-0.5 rounded bg-primary text-on-primary font-code-inline text-label-sm font-bold tracking-wider">
                                        TICKET AI-024
                                    </span>
                                    <span class="px-space-sm py-0.5 rounded bg-tertiary-fixed text-on-tertiary-fixed font-code-inline text-label-sm font-semibold">
                                        PRIORITY: CRITICAL
                                    </span>
                                    <span class="font-label-sm text-label-sm text-on-surface-variant font-code-inline">
                                        SYS-AI-TELEMETRY // ID #8849-B
                                    </span>
                                </div>
                                <h2 class="font-headline-lg text-headline-lg text-on-surface font-bold tracking-tight mt-1">
                                    Predictive Churn Risk Engine — Feature Drift Re-calibration
                                </h2>
                                <div class="flex flex-wrap items-center gap-space-md text-body-sm font-body-sm text-on-surface-variant mt-1">
                                    <span class="flex items-center gap-space-xs">
                                        <span class="material-symbols-outlined text-[16px] text-primary">domain</span>
                                        <span>Req: Retention &amp; Billing Operations</span>
                                    </span>
                                    <span>•</span>
                                    <span class="flex items-center gap-space-xs">
                                        <span class="material-symbols-outlined text-[16px] text-primary">person_outline</span>
                                        <span>Stakeholder: Elena Rostova (VP Operations)</span>
                                    </span>
                                    <span>•</span>
                                    <span class="flex items-center gap-space-xs font-code-inline text-primary font-semibold">
                                        <span class="material-symbols-outlined text-[16px]">timer</span>
                                        <span>SLA Target: 18h 45m remaining</span>
                                    </span>
                                </div>
                            </div>
                            <!-- Metric Badges Group -->
                            <div class="flex flex-wrap lg:flex-col items-end gap-space-xs shrink-0 font-code-inline">
                                <div class="px-space-md py-1.5 rounded bg-surface-container text-right">
                                    <div class="text-label-sm text-on-surface-variant">REQ ACCURACY</div>
                                    <div class="font-bold text-primary text-label-lg">F1 ≥ 0.80</div>
                                </div>
                                <div class="px-space-md py-1.5 rounded bg-surface-container text-right">
                                    <div class="text-label-sm text-on-surface-variant">MAX INFERENCE</div>
                                    <div class="font-bold text-on-surface text-label-lg">&lt; 45ms (p99)</div>
                                </div>
                            </div>
                        </div>
                        <!-- Specification Brief -->
                        <div class="p-space-md rounded bg-surface-container-low flex flex-col gap-space-xs">
                            <span class="font-label-sm text-label-sm uppercase font-semibold text-primary tracking-wider">
                                TECHNICAL DIRECTIVE &amp; ACCEPTANCE CRITERIA
                            </span>
                            <p class="font-body-md text-body-md text-on-surface">
                                Deploy XGBoost and LightGBM ensemble pipeline with localized SHAP interpretability layers. Resolve KS-test detected drift on telecom tenure and average daily balance variance. Export inference schema directly to SYS-04 Registry with canary split configuration.
                            </p>
                        </div>
                        <!-- Progress Section & Interactive telemetry gauge -->
                        <div class="flex flex-col gap-space-xs">
                            <div class="flex items-center justify-between font-label-md text-label-md">
                                <span class="text-on-surface font-semibold flex items-center gap-space-xs">
                                    <span class="material-symbols-outlined text-[16px] text-primary">sync</span>
                                    <span>Execution Stage: Feature Engineering &amp; Preprocessing (Step 3/5)</span>
                                </span>
                                <span class="font-code-inline text-primary font-bold">65% COMPLETED</span>
                            </div>
                            <div class="w-full h-3 rounded bg-surface-container-high overflow-hidden">
                                <div class="h-full bg-primary rounded transition-all duration-500" style="width: 65%;"></div>
                            </div>
                            <div class="flex items-center justify-between font-code-inline text-label-sm text-on-surface-variant pt-1">
                                <span>Data Ingestion: PASS</span>
                                <span>KS Drift Analysis: COMPLETED</span>
                                <span class="text-primary font-bold">SHAP Matrix: GENERATING...</span>
                                <span class="text-outline">Canary Canary: PENDING</span>
                            </div>
                        </div>
                        <!-- Primary Action Buttons for AI-024 -->
                        <div class="flex flex-wrap items-center gap-space-sm pt-space-xs">
                            <button class="flex items-center gap-space-xs px-space-md py-space-sm rounded bg-primary text-on-primary font-label-md text-label-md font-semibold hover:bg-primary-container transition-all shadow-sm">
                                <span class="material-symbols-outlined text-[18px]">terminal</span>
                                <span>Open in SYS-03 (Jupyter Notebook)</span>
                            </button>
                            <button class="flex items-center gap-space-xs px-space-md py-space-sm rounded bg-surface-container-high text-primary font-label-md text-label-md font-semibold hover:bg-surface-variant transition-all">
                                <span class="material-symbols-outlined text-[18px]">database</span>
                                <span>Inspect Datasets in SYS-02</span>
                            </button>
                            <button class="flex items-center gap-space-xs px-space-md py-space-sm rounded bg-surface-container-low text-on-surface font-label-md text-label-md hover:bg-surface-container transition-all">
                                <span class="material-symbols-outlined text-[18px]">menu_book</span>
                                <span>View Ticket AI-024 Full Spec</span>
                            </button>
                        </div>
                    </div>
                    <!-- Middle Split: Priority Matrix & Upcoming Milestones -->
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-xl">
                        <!-- Interactive Priority Distribution Panel (7 Columns) -->
                        <div class="lg:col-span-7 flex flex-col gap-space-md p-space-lg rounded bg-surface-container-lowest shadow-sm">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-space-sm">
                                    <span class="material-symbols-outlined text-primary text-[20px]">tune</span>
                                    <h3 class="font-headline-md text-headline-md text-primary font-bold">Active Priority Distribution</h3>
                                </div>
                                <span class="font-code-inline text-label-sm text-on-surface-variant">8 UNITS ASSIGNED</span>
                            </div>
                            <p class="font-body-sm text-body-sm text-on-surface-variant">
                                Range workload balanced across mission-criticality tiers. Real-time compute allocation partitioned by priority level.
                            </p>
                            <!-- Visual Multi-segment Distribution Bar -->
                            <div class="flex flex-col gap-space-xs">
                                <div class="h-4 w-full rounded flex overflow-hidden">
                                    <div class="h-full bg-primary transition-all duration-300" style="width: 12.5%;" title="Critical: 1 (12.5%)"></div>
                                    <div class="h-full bg-secondary transition-all duration-300" style="width: 25%;" title="High: 2 (25%)"></div>
                                    <div class="h-full bg-secondary-container transition-all duration-300" style="width: 50%;" title="Medium: 4 (50%)"></div>
                                    <div class="h-full bg-tertiary-fixed transition-all duration-300" style="width: 12.5%;" title="Low: 1 (12.5%)"></div>
                                </div>
                                <div class="flex flex-wrap items-center justify-between font-code-inline text-label-sm pt-1">
                                    <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-sm bg-primary"></span> CRITICAL (1)</span>
                                    <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-sm bg-secondary"></span> HIGH (2)</span>
                                    <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-sm bg-secondary-container"></span> MEDIUM (4)</span>
                                    <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-sm bg-tertiary-fixed"></span> LOW (1)</span>
                                </div>
                            </div>
                            <!-- Priority Breakdown List -->
                            <div class="flex flex-col gap-space-xs mt-space-sm">
                                <!-- Critical -->
                                <div class="p-space-sm rounded bg-surface-container-low flex items-center justify-between hover:bg-surface-container transition-colors">
                                    <div class="flex items-center gap-space-sm">
                                        <span class="w-2 h-2 rounded-full bg-primary"></span>
                                        <span class="font-code-inline text-code-inline text-primary font-bold">AI-024</span>
                                        <span class="font-body-md text-body-md text-on-surface font-medium truncate max-w-xs sm:max-w-md">Customer Churn Drift Emergency</span>
                                    </div>
                                    <span class="font-label-sm text-label-sm px-space-sm py-0.5 rounded bg-tertiary-fixed text-on-tertiary-fixed font-code-inline font-bold">CRITICAL</span>
                                </div>
                                <!-- High 1 -->
                                <div class="p-space-sm rounded bg-surface-container-lowest flex items-center justify-between hover:bg-surface-container-low transition-colors">
                                    <div class="flex items-center gap-space-sm">
                                        <span class="w-2 h-2 rounded-full bg-secondary"></span>
                                        <span class="font-code-inline text-code-inline text-on-surface font-bold">AI-029</span>
                                        <span class="font-body-md text-body-md text-on-surface font-medium truncate max-w-xs sm:max-w-md">CV Defect Surface Inspection</span>
                                    </div>
                                    <span class="font-label-sm text-label-sm px-space-sm py-0.5 rounded bg-surface-container-high text-primary font-code-inline font-semibold">HIGH</span>
                                </div>
                                <!-- High 2 -->
                                <div class="p-space-sm rounded bg-surface-container-lowest flex items-center justify-between hover:bg-surface-container-low transition-colors">
                                    <div class="flex items-center gap-space-sm">
                                        <span class="w-2 h-2 rounded-full bg-secondary"></span>
                                        <span class="font-code-inline text-code-inline text-on-surface font-bold">AI-031</span>
                                        <span class="font-body-md text-body-md text-on-surface font-medium truncate max-w-xs sm:max-w-md">Financial Fraud Transaction Spike</span>
                                    </div>
                                    <span class="font-label-sm text-label-sm px-space-sm py-0.5 rounded bg-surface-container-high text-primary font-code-inline font-semibold">HIGH</span>
                                </div>
                                <!-- Medium / Low Combined Preview -->
                                <div class="p-space-sm rounded bg-surface-container-low flex items-center justify-between">
                                    <div class="flex items-center gap-space-sm">
                                        <span class="w-2 h-2 rounded-full bg-secondary-container"></span>
                                        <span class="font-code-inline text-code-inline text-on-surface-variant">AI-033, AI-035, AI-037...</span>
                                        <span class="font-body-md text-body-md text-on-surface-variant">NLP Complaint Routing, RAG HR Assistant, SOC Parser</span>
                                    </div>
                                    <span class="font-label-sm text-label-sm text-on-surface-variant font-code-inline">5 UNITS</span>
                                </div>
                            </div>
                        </div>
                        <!-- Upcoming Deadlines & Milestones Grid (5 Columns) -->
                        <div class="lg:col-span-5 flex flex-col gap-space-md p-space-lg rounded bg-surface-container-lowest shadow-sm">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-space-sm">
                                    <span class="material-symbols-outlined text-primary text-[20px]">event_upcoming</span>
                                    <h3 class="font-headline-md text-headline-md text-primary font-bold">Upcoming Deadlines</h3>
                                </div>
                                <span class="material-symbols-outlined text-on-surface-variant text-[18px]">schedule</span>
                            </div>
                            <div class="flex flex-col gap-space-sm">
                                <!-- Item 1 -->
                                <div class="p-space-md rounded bg-surface-container-low flex flex-col gap-space-xs">
                                    <div class="flex items-center justify-between">
                                        <span class="font-code-inline text-code-inline text-primary font-bold">AI-024 • CHURN PREDICTION</span>
                                        <span class="px-space-sm py-0.5 rounded bg-error-container text-on-error-container font-code-inline text-label-sm font-bold">
                                            18h 45m
                                        </span>
                                    </div>
                                    <p class="font-body-md text-body-md text-on-surface">Production F1 threshold verification test run</p>
                                    <div class="flex items-center justify-between font-label-sm text-label-sm text-on-surface-variant pt-1">
                                        <span>Evaluator: Auto-SYS-04</span>
                                        <span class="text-primary font-semibold">Tier 1 Target</span>
                                    </div>
                                </div>
                                <!-- Item 2 -->
                                <div class="p-space-md rounded bg-surface-container-lowest flex flex-col gap-space-xs">
                                    <div class="flex items-center justify-between">
                                        <span class="font-code-inline text-code-inline text-on-surface font-bold">AI-029 • DEFECT INSPECTION</span>
                                        <span class="px-space-sm py-0.5 rounded bg-surface-container-high text-primary font-code-inline text-label-sm font-semibold">
                                            3 DAYS
                                        </span>
                                    </div>
                                    <p class="font-body-md text-body-md text-on-surface">ResNet-50 visual defect classifier weights lock</p>
                                    <div class="flex items-center justify-between font-label-sm text-label-sm text-on-surface-variant pt-1">
                                        <span>Evaluator: Dr. Thorne</span>
                                        <span>Dataset: Industrial-Surface-09</span>
                                    </div>
                                </div>
                                <!-- Item 3 -->
                                <div class="p-space-md rounded bg-surface-container-lowest flex flex-col gap-space-xs">
                                    <div class="flex items-center justify-between">
                                        <span class="font-code-inline text-code-inline text-on-surface font-bold">AI-033 • RAG HR KNOWLEDGE</span>
                                        <span class="px-space-sm py-0.5 rounded bg-surface-container-high text-on-surface-variant font-code-inline text-label-sm">
                                            5 DAYS
                                        </span>
                                    </div>
                                    <p class="font-body-md text-body-md text-on-surface">Embedding latency &amp; context recall test suite</p>
                                    <div class="flex items-center justify-between font-label-sm text-label-sm text-on-surface-variant pt-1">
                                        <span>Evaluator: Instructor Lead</span>
                                        <span>VectorDB: SYS-02-Milvus</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Instructor Stream & Evaluation Activity Feed -->
                    <div class="flex flex-col gap-space-md p-space-lg rounded bg-surface-container-lowest shadow-sm">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-space-sm">
                                <span class="material-symbols-outlined text-primary text-[20px]">forum</span>
                                <h3 class="font-headline-md text-headline-md text-primary font-bold">Recent Instructor Feedback &amp; Verification Stream</h3>
                            </div>
                            <span class="font-code-inline text-label-sm text-on-surface-variant">AUTO-LOG STREAM</span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-space-md">
                            <!-- Message 1: Instructor -->
                            <div class="p-space-md rounded bg-surface-container-low flex flex-col gap-space-sm">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-space-sm">
                                        <div class="w-7 h-7 rounded-full bg-primary flex items-center justify-center font-label-sm text-on-primary font-bold">
                                            AT
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="font-label-md text-label-md text-on-surface font-semibold">Dr. Aris Thorne</span>
                                            <span class="font-label-sm text-label-sm text-on-surface-variant">Chief Instructor • AI Range</span>
                                        </div>
                                    </div>
                                    <span class="font-code-inline text-label-sm text-on-surface-variant">2h ago</span>
                                </div>
                                <p class="font-body-md text-body-md text-on-surface">
                                    "Validation report for <span class="font-code-inline text-primary font-bold">AI-018</span> approved. Noticeable reduction in false positives across high-dimensional telemetry samples. Ready to proceed full force to <span class="font-code-inline text-primary font-bold">AI-024</span> drift pipeline."
                                </p>
                                <div class="flex items-center gap-space-xs font-code-inline text-label-sm text-primary pt-1">
                                    <span class="material-symbols-outlined text-[14px]">check_circle</span>
                                    <span>GRADE CERTIFIED: 94/100 (DISTINCTION)</span>
                                </div>
                            </div>
                            <!-- Message 2: Automated Eval System -->
                            <div class="p-space-md rounded bg-surface-container-low flex flex-col gap-space-sm">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-space-sm">
                                        <div class="w-7 h-7 rounded-full bg-secondary flex items-center justify-center font-label-sm text-on-secondary font-bold">
                                            04
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="font-label-md text-label-md text-on-surface font-semibold">Auto-Evaluator SYS-04</span>
                                            <span class="font-label-sm text-label-sm text-on-surface-variant">Automated Registry Pipeline</span>
                                        </div>
                                    </div>
                                    <span class="font-code-inline text-label-sm text-on-surface-variant">42m ago</span>
                                </div>
                                <p class="font-body-md text-body-md text-on-surface">
                                    "Model checkpoint <span class="font-code-inline bg-surface-container-high px-1 py-0.5 rounded text-on-surface">sha256:7f3b</span> uploaded to ephemeral validation runtime. Test ROC-AUC calculated at <span class="font-code-inline text-primary font-bold">0.864</span> against holdout telemetry set."
                                </p>
                                <div class="flex items-center gap-space-xs font-code-inline text-label-sm text-secondary pt-1">
                                    <span class="material-symbols-outlined text-[14px]">speed</span>
                                    <span>INFERENCE PASS: 38ms (LIMIT: 45ms)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Quick Navigation Hub to All 4 Interconnected Range Subsystems -->
                    <div class="flex flex-col gap-space-md">
                        <div class="flex items-center justify-between">
                            <div class="flex flex-col">
                                <h3 class="font-headline-md text-headline-md text-primary font-bold">Interconnected Range Subsystems</h3>
                                <p class="font-body-sm text-body-sm text-on-surface-variant">Direct operational bridging between dataset stores, GPU compute, and deployment stages.</p>
                            </div>
                            <span class="font-code-inline text-label-sm text-on-surface-variant font-semibold">CLUSTER NODES: ONLINE</span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-space-md">
                            <!-- SYS-AI-02 -->
                            <a class="p-space-lg rounded bg-surface-container-lowest flex flex-col justify-between hover:bg-surface-container-low transition-all group shadow-sm" href="#">
                                <div class="flex flex-col gap-space-xs">
                                    <div class="flex items-center justify-between">
                                        <span class="w-8 h-8 rounded bg-surface-container-high flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-on-primary transition-colors">
                                            <span class="material-symbols-outlined text-[20px]">database</span>
                                        </span>
                                        <span class="font-code-inline text-label-sm text-on-surface-variant">SYS-AI-02</span>
                                    </div>
                                    <h4 class="font-headline-md text-headline-md text-on-surface font-semibold mt-space-sm group-hover:text-primary transition-colors">
                                        Data Lake &amp; Feature Store
                                    </h4>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant">
                                        Parquet ingestion, raw event streaming, drift feature stores and time-series splits.
                                    </p>
                                </div>
                                <div class="mt-space-md flex items-center justify-between font-label-sm text-label-sm text-primary font-semibold">
                                    <span>Query Features</span>
                                    <span class="material-symbols-outlined text-[16px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                                </div>
                            </a>
                            <!-- SYS-AI-03 -->
                            <a class="p-space-lg rounded bg-surface-container-lowest flex flex-col justify-between hover:bg-surface-container-low transition-all group shadow-sm" href="#">
                                <div class="flex flex-col gap-space-xs">
                                    <div class="flex items-center justify-between">
                                        <span class="w-8 h-8 rounded bg-surface-container-high flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-on-primary transition-colors">
                                            <span class="material-symbols-outlined text-[20px]">terminal</span>
                                        </span>
                                        <span class="font-code-inline text-label-sm text-on-surface-variant">SYS-AI-03</span>
                                    </div>
                                    <h4 class="font-headline-md text-headline-md text-on-surface font-semibold mt-space-sm group-hover:text-primary transition-colors">
                                        Jupyter Workbench
                                    </h4>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant">
                                        Interactive PyTorch, XGBoost GPU kernels, distributed training notebooks &amp; SHAP visualizers.
                                    </p>
                                </div>
                                <div class="mt-space-md flex items-center justify-between font-label-sm text-label-sm text-primary font-semibold">
                                    <span>Launch Kernel</span>
                                    <span class="material-symbols-outlined text-[16px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                                </div>
                            </a>
                            <!-- SYS-AI-04 -->
                            <a class="p-space-lg rounded bg-surface-container-lowest flex flex-col justify-between hover:bg-surface-container-low transition-all group shadow-sm" href="#">
                                <div class="flex flex-col gap-space-xs">
                                    <div class="flex items-center justify-between">
                                        <span class="w-8 h-8 rounded bg-surface-container-high flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-on-primary transition-colors">
                                            <span class="material-symbols-outlined text-[20px]">hub</span>
                                        </span>
                                        <span class="font-code-inline text-label-sm text-on-surface-variant">SYS-AI-04</span>
                                    </div>
                                    <h4 class="font-headline-md text-headline-md text-on-surface font-semibold mt-space-sm group-hover:text-primary transition-colors">
                                        Model Registry &amp; Canary
                                    </h4>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant">
                                        Artifact tracking, containerized micro-services, load balancing and shadow canary tests.
                                    </p>
                                </div>
                                <div class="mt-space-md flex items-center justify-between font-label-sm text-label-sm text-primary font-semibold">
                                    <span>Inspect Checkpoints</span>
                                    <span class="material-symbols-outlined text-[16px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                                </div>
                            </a>
                            <!-- SYS-AI-05 -->
                            <a class="p-space-lg rounded bg-surface-container-lowest flex flex-col justify-between hover:bg-surface-container-low transition-all group shadow-sm" href="#">
                                <div class="flex flex-col gap-space-xs">
                                    <div class="flex items-center justify-between">
                                        <span class="w-8 h-8 rounded bg-surface-container-high flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-on-primary transition-colors">
                                            <span class="material-symbols-outlined text-[20px]">settings_input_component</span>
                                        </span>
                                        <span class="font-code-inline text-label-sm text-on-surface-variant">SYS-AI-05</span>
                                    </div>
                                    <h4 class="font-headline-md text-headline-md text-on-surface font-semibold mt-space-sm group-hover:text-primary transition-colors">
                                        Range Telemetry &amp; Ops
                                    </h4>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant">
                                        Scenario fault injectors, synthetic concept drift engines, and instructor telemetry monitors.
                                    </p>
                                </div>
                                <div class="mt-space-md flex items-center justify-between font-label-sm text-label-sm text-primary font-semibold">
                                    <span>Range Telemetry</span>
                                    <span class="material-symbols-outlined text-[16px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="js/main.js"></script>
</body>

</html>