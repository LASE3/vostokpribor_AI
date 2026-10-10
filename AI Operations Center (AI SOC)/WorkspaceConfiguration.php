<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="web_dashboard" name="shell-type" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=JetBrains+Mono:wght@100..900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="css/style.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="js/tailwind.config.js"></script>
</head>

<body class="fiberglass-bg font-body-md text-on-surface min-h-screen">
    <header class="fixed top-0 left-0 right-0 h-16 bg-surface-container-lowest/90 backdrop-blur-md shadow-[0_1px_8px_rgba(76,29,149,0.06)] z-50 flex items-center justify-between px-margin-desktop">
        <div class="flex items-center gap-space-lg">
            <div class="flex items-center gap-space-sm"><img alt="VOSTOKPRIBOR Logo" class="h-8 w-auto object-contain" src="https://lh3.googleusercontent.com/aida/AEtjO1WFY3uXJ_9VBQSYhio3LVjLuY04weLyokzp987wSe7sNmLm6J_v-iBWBRUy3suJiuOvORdi5ycPrycJRlBFblqocpH7MR32xcHH09--U1FZEYb_N7dqQPHlWW5BW_vPyKR6necxQ856c6yxbD1S94T0POQSl-8SC_gqw2chw0ZgIDADFAOBMGy7ZpT4PuJKdlN_YkmHcsGM8Ou4GukoU-klYJiuzJdHRIk4WL9qKtKyBqjVPsyWFLOElrc" />
                <div class="flex flex-col"><span class="font-headline-sm text-headline-sm text-primary tracking-tight">VOSTOKPRIBOR</span><span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Range AI Control</span></div>
            </div>
            <div class="h-6 w-px bg-surface-container-highest"></div>
            <nav class="hidden xl:flex items-center gap-space-xs p-1 bg-surface-container-low rounded-lg" data-active-classes="bg-secondary-container text-primary font-bold"><a class="px-space-sm py-1 rounded text-on-surface-variant hover:text-primary font-label-md text-label-md transition-colors" data-path="subsystem-tickets" href="../AI Project Management/Dashboard.php">SYS-AI-01</a><a class="px-space-sm py-1 rounded text-on-surface-variant hover:text-primary font-label-md text-label-md transition-colors" data-path="subsystem-data" href="../Data Center/dashboard.php">SYS-AI-02</a><a class="px-space-sm py-1 rounded text-on-surface-variant hover:text-primary font-label-md text-label-md transition-colors" data-path="subsystem-workbench" href="../ML Workbench/NotebookWorkbench.php">SYS-AI-03</a><a class="px-space-sm py-1 rounded text-on-surface-variant hover:text-primary font-label-md text-label-md transition-colors" data-path="subsystem-models" href="../Model Registry & Deployment/dashboard.php">SYS-AI-04</a><a class="px-space-sm py-1 rounded bg-primary-container text-white font-bold font-label-md text-label-md shadow-sm" data-path="dashboard" href="TicketsAndScenarios.php">SYS-AI-05 [ACTIVE]</a></nav>
        </div>
        <div class="flex items-center gap-space-md">
            <div class="hidden md:flex items-center gap-space-xs bg-surface-container px-space-md py-1.5 rounded-lg w-64 text-on-surface-variant"><span class="material-symbols-outlined text-[18px]">search</span><span class="font-body-sm text-body-sm text-on-surface-variant">Search telemetry, models...</span></div>
            <div class="hidden lg:flex items-center gap-space-xs bg-tertiary-fixed text-on-tertiary-fixed px-space-sm py-1 rounded-full font-label-sm text-label-sm"><span class="w-2 h-2 rounded-full bg-error animate-pulse"></span><span>SCN-904-ALPHA (LIVE)</span></div><button class="relative p-2 rounded-lg text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors"><span class="material-symbols-outlined text-[20px]">notifications</span><span class="absolute top-1.5 right-1.5 w-2 h-2 bg-error rounded-full"></span></button>
            <div class="flex items-center gap-space-sm pl-space-xs">
                <div class="flex flex-col text-right hidden sm:flex"><span class="font-label-md text-label-md text-on-surface leading-tight">K. VORONIN</span><span class="font-label-sm text-label-sm text-on-surface-variant uppercase">Chief Instructor</span></div>
                <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center"><span class="material-symbols-outlined text-on-primary text-[18px]">person</span></div>
            </div>
        </div>
    </header>
    <aside class="fixed left-0 top-16 bottom-0 w-72 bg-surface-container-lowest shadow-[0_1px_8px_rgba(76,29,149,0.04)] z-40 overflow-y-auto">
        <div class="p-space-md flex flex-col gap-space-lg">
            <nav class="flex flex-col gap-space-xs" data-active-classes="bg-primary-container text-on-primary font-semibold shadow-sm">
                <div class="px-space-sm py-1 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-widest">Overview</div><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="main-dashboard" href="Dashboard.php"><span class="material-symbols-outlined text-[18px]">space_dashboard</span><span class="font-body-md text-body-md">Main Dashboard</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="training-analytics" href="OperationsDashboard.php"><span class="material-symbols-outlined text-[18px]">query_stats</span><span class="font-body-md text-body-md">Training Analytics</span></a>
            </nav>
            <nav class="flex flex-col gap-space-xs" data-active-classes="bg-primary-container text-on-primary font-semibold shadow-sm">
                <div class="px-space-sm py-1 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-widest">Training Management</div><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="tickets-and-scenarios" href="TicketsAndScenarios.php"><span class="material-symbols-outlined text-[18px]">tune</span><span class="font-body-md text-body-md">Tickets & Scenarios</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="dataset-management" href="DatasetManagement.php"><span class="material-symbols-outlined text-[18px]">database</span><span class="font-body-md text-body-md">Dataset Management</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="students-and-cohorts" href="TicketsAndScenarios.php"><span class="material-symbols-outlined text-[18px]">group</span><span class="font-body-md text-body-md">Students & Cohorts</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="submission-reviews" href="TicketsAndScenarios.php"><span class="material-symbols-outlined text-[18px]">fact_check</span><span class="font-body-md text-body-md">Submission Reviews</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="grading-and-feedback" href="TicketsAndScenarios.php"><span class="material-symbols-outlined text-[18px]">rate_review</span><span class="font-body-md text-body-md">Grading & Feedback</span></a>
            </nav>
            <nav class="flex flex-col gap-space-xs" data-active-classes="bg-primary-container text-on-primary font-semibold shadow-sm">
                <div class="px-space-sm py-1 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-widest">Platform Administration</div><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="subsystem-control" href="WorkspaceConfiguration.php"><span class="material-symbols-outlined text-[18px]">memory</span><span class="font-body-md text-body-md">Subsystem Control</span></a><a aria-current="page" class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg transition-colors bg-primary-container text-on-primary font-semibold shadow-sm" data-path="workspace-configuration" href="WorkspaceConfiguration.php"><span class="material-symbols-outlined text-[18px]">settings_input_component</span><span class="font-body-md text-body-md">Workspace Configuration</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="users-and-permissions" href="WorkspaceConfiguration.php"><span class="material-symbols-outlined text-[18px]">admin_panel_settings</span><span class="font-body-md text-body-md">Users & Permissions</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="audit-logs" href="OperationsDashboard.php"><span class="material-symbols-outlined text-[18px]">receipt_long</span><span class="font-body-md text-body-md">Audit Logs</span></a>
            </nav>
            <nav class="flex flex-col gap-space-xs" data-active-classes="bg-primary-container text-on-primary font-semibold shadow-sm">
                <div class="px-space-sm py-1 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-widest">AI Operations</div><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="operations-dashboard" href="OperationsDashboard.php"><span class="material-symbols-outlined text-[18px]">hub</span><span class="font-body-md text-body-md">Operations Dashboard</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="model-monitoring" href="OperationsDashboard.php"><span class="material-symbols-outlined text-[18px]">monitoring</span><span class="font-body-md text-body-md">Model Monitoring</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="alerts-and-incidents" href="OperationsDashboard.php"><span class="material-symbols-outlined text-[18px]">warning</span><span class="font-body-md text-body-md">Alerts & Incidents</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="deployment-history" href="OperationsDashboard.php"><span class="material-symbols-outlined text-[18px]">history</span><span class="font-body-md text-body-md">Deployment History</span></a>
            </nav>
        </div>
    </aside>
    <div class="pl-72">
        <main class="relative pt-16 min-h-screen px-margin-desktop py-margin">
            <div class="w-full">
                <div class="flex flex-col w-full">
                    <!-- Operational Workspace Sub-Header Strip -->
                    <div class="flex flex-wrap items-center justify-between gap-space-md mb-space-md bg-surface-container-lowest p-space-md rounded-xl shadow-sm">
                        <div class="flex items-center gap-space-md">
                            <div class="flex items-center gap-space-xs bg-primary text-on-primary px-space-sm py-1 rounded">
                                <span class="material-symbols-outlined text-[16px]">rate_review</span>
                                <span class="font-label-md text-label-md uppercase tracking-wider font-semibold">SYS-AI-05 : WORKSPACE</span>
                            </div>
                            <div class="flex items-center gap-space-xs text-on-surface-variant font-label-md text-label-md">
                                <span>COHORT 2025-A/B</span>
                                <span>/</span>
                                <span class="text-primary font-semibold">SUBMISSION EVALUATION & RUBRIC ENGINE</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-space-sm">
                            <div class="flex items-center gap-space-xs bg-surface-container px-space-sm py-1 rounded">
                                <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                                <span class="font-label-sm text-label-sm text-on-surface uppercase">Live Autosave Active</span>
                            </div>
                            <span class="font-label-sm text-label-sm text-on-surface-variant">Reviewer: K. VORONIN (ID: #INS-704)</span>
                        </div>
                    </div>
                    <!-- Primary 3-Zone Workspace Grid -->
                    <div class="grid grid-cols-1 xl:grid-cols-12 gap-space-md w-full items-start">
                        <!-- LEFT RAIL: Queue & Candidate Selector (Col 1-3) -->
                        <div class="xl:col-span-3 flex flex-col gap-space-md">
                            <!-- Queue Filter & Meta Card -->
                            <div class="bg-surface-container-lowest p-space-md rounded-xl shadow-sm flex flex-col gap-space-sm">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-space-xs">
                                        <span class="font-label-md text-label-md uppercase font-semibold text-primary">Queue Matrix</span>
                                        <span class="bg-secondary-container text-on-secondary-container px-1.5 py-0.5 rounded-full font-label-sm text-label-sm">4 Active</span>
                                    </div>
                                    <button class="text-on-surface-variant hover:text-primary transition-colors">
                                        <span class="material-symbols-outlined text-[18px]">filter_list</span>
                                    </button>
                                </div>
                                <div class="grid grid-cols-3 gap-1 bg-surface-container-low p-1 rounded-lg font-label-sm text-label-sm">
                                    <button class="bg-surface-container-lowest text-primary py-1 rounded shadow-xs font-semibold text-center">Pending (2)</button>
                                    <button class="text-on-surface-variant hover:text-primary py-1 rounded text-center">Review (1)</button>
                                    <button class="text-on-surface-variant hover:text-primary py-1 rounded text-center">Done (1)</button>
                                </div>
                            </div>
                            <!-- Queue Cards List -->
                            <div class="flex flex-col gap-space-sm">
                                <!-- Active Candidate Card: Alexey Morozov -->
                                <div class="bg-surface-container-lowest p-space-md rounded-xl shadow-sm relative overflow-hidden transition-all duration-200">
                                    <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-primary"></div>
                                    <div class="flex items-start justify-between gap-space-xs">
                                        <div>
                                            <span class="font-label-sm text-label-sm text-primary uppercase font-bold tracking-wider">Cohort 2025-A</span>
                                            <h3 class="font-headline-sm text-headline-sm text-on-surface">Alexey Morozov</h3>
                                            <p class="font-label-md text-label-md text-on-surface-variant">TCK-CHURN-202 v2</p>
                                        </div>
                                        <span class="bg-tertiary-fixed text-on-tertiary-fixed px-space-xs py-0.5 rounded font-label-sm text-label-sm font-semibold uppercase">Pending</span>
                                    </div>
                                    <div class="mt-space-sm pt-space-xs flex items-center justify-between font-label-sm text-label-sm text-on-surface-variant">
                                        <span class="flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">schedule</span> 2h ago</span>
                                        <span class="text-primary font-semibold">4 Deliverables</span>
                                    </div>
                                </div>
                                <!-- Candidate: Elena Rostova -->
                                <div class="bg-surface-container-low hover:bg-surface-container-lowest p-space-md rounded-xl transition-all duration-150 cursor-pointer">
                                    <div class="flex items-start justify-between gap-space-xs">
                                        <div>
                                            <span class="font-label-sm text-label-sm text-on-surface-variant uppercase">Cohort 2025-A</span>
                                            <h4 class="font-headline-sm text-headline-sm text-on-surface">Elena Rostova</h4>
                                            <p class="font-label-md text-label-md text-on-surface-variant">TCK-FRAUD-104 v1</p>
                                        </div>
                                        <span class="bg-error-container text-on-error-container px-space-xs py-0.5 rounded font-label-sm text-label-sm font-semibold uppercase">Revision Req</span>
                                    </div>
                                    <div class="mt-space-sm pt-space-xs flex items-center justify-between font-label-sm text-label-sm text-on-surface-variant">
                                        <span>Score: <strong class="text-error font-label-md">74/100</strong></span>
                                        <span>Reviewed yesterday</span>
                                    </div>
                                </div>
                                <!-- Candidate: Dmitry Volkov -->
                                <div class="bg-surface-container-low hover:bg-surface-container-lowest p-space-md rounded-xl transition-all duration-150 cursor-pointer">
                                    <div class="flex items-start justify-between gap-space-xs">
                                        <div>
                                            <span class="font-label-sm text-label-sm text-on-surface-variant uppercase">Cohort 2025-B</span>
                                            <h4 class="font-headline-sm text-headline-sm text-on-surface">Dmitry Volkov</h4>
                                            <p class="font-label-md text-label-md text-on-surface-variant">TCK-DEFECT-301 v1</p>
                                        </div>
                                        <span class="bg-tertiary-fixed text-on-tertiary-fixed px-space-xs py-0.5 rounded font-label-sm text-label-sm font-semibold uppercase">Approved</span>
                                    </div>
                                    <div class="mt-space-sm pt-space-xs flex items-center justify-between font-label-sm text-label-sm text-on-surface-variant">
                                        <span>Score: <strong class="text-primary font-label-md">93/100</strong></span>
                                        <span class="text-tertiary-container font-semibold">Exemplary</span>
                                    </div>
                                </div>
                                <!-- Candidate: Sofia Chen -->
                                <div class="bg-surface-container-low hover:bg-surface-container-lowest p-space-md rounded-xl transition-all duration-150 cursor-pointer">
                                    <div class="flex items-start justify-between gap-space-xs">
                                        <div>
                                            <span class="font-label-sm text-label-sm text-on-surface-variant uppercase">Cohort 2025-A</span>
                                            <h4 class="font-headline-sm text-headline-sm text-on-surface">Sofia Chen</h4>
                                            <p class="font-label-md text-label-md text-on-surface-variant">TCK-NLP-401 v2</p>
                                        </div>
                                        <span class="bg-secondary-container text-on-secondary-container px-space-xs py-0.5 rounded font-label-sm text-label-sm font-semibold uppercase">Resubmitted</span>
                                    </div>
                                    <div class="mt-space-sm pt-space-xs flex items-center justify-between font-label-sm text-label-sm text-on-surface-variant">
                                        <span class="flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">update</span> 45m ago</span>
                                        <span class="text-primary font-semibold">Ready for Review</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Quick Telemetry & SLA Panel -->
                            <div class="bg-surface-container-lowest p-space-md rounded-xl shadow-sm flex flex-col gap-space-sm">
                                <span class="font-label-sm text-label-sm uppercase text-on-surface-variant tracking-wider font-semibold">Grading Efficiency Telemetry</span>
                                <div class="grid grid-cols-2 gap-space-sm">
                                    <div class="p-space-sm bg-surface-container-low rounded-lg">
                                        <span class="font-label-sm text-label-sm text-on-surface-variant block">Median Turnaround</span>
                                        <span class="font-headline-sm text-headline-sm text-primary">3.2h</span>
                                    </div>
                                    <div class="p-space-sm bg-surface-container-low rounded-lg">
                                        <span class="font-label-sm text-label-sm text-on-surface-variant block">Rubric Consistency</span>
                                        <span class="font-headline-sm text-headline-sm text-primary">98.4%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- MAIN CENTER ZONE: Active Submission & Deliverables (Col 4-8) -->
                        <div class="xl:col-span-5 flex flex-col gap-space-md">
                            <!-- Submission Details Header Card -->
                            <div class="bg-surface-container-lowest p-space-lg rounded-xl shadow-sm flex flex-col gap-space-md">
                                <div class="flex flex-wrap items-start justify-between gap-space-sm">
                                    <div class="flex flex-col">
                                        <div class="flex items-center gap-space-xs mb-1">
                                            <span class="bg-secondary-fixed text-on-secondary-fixed px-space-sm py-0.5 rounded font-label-sm text-label-sm font-bold">TCK-CHURN-202</span>
                                            <span class="font-label-sm text-label-sm text-on-surface-variant uppercase">Iteration v2.1</span>
                                        </div>
                                        <h1 class="font-headline-lg text-headline-lg text-primary tracking-tight">Alexey Morozov</h1>
                                        <p class="font-body-md text-body-md text-on-surface-variant">Predictive Customer Churn Framework for Telemetry-Driven Tier Systems</p>
                                    </div>
                                    <div class="flex flex-col items-end">
                                        <span class="bg-tertiary-fixed text-on-tertiary-fixed px-space-md py-1 rounded-full font-label-md text-label-md font-bold tracking-wide">PENDING VERIFICATION</span>
                                        <span class="font-label-sm text-label-sm text-on-surface-variant mt-1">Submitted: 14:22 UTC</span>
                                    </div>
                                </div>
                                <!-- Candidate Background / Verification Strip -->
                                <div class="grid grid-cols-3 gap-space-sm p-space-sm bg-surface-container-low rounded-lg font-label-sm text-label-sm">
                                    <div>
                                        <span class="text-on-surface-variant block">Cohort:</span>
                                        <strong class="text-on-surface">2025-A (Senior Applied)</strong>
                                    </div>
                                    <div>
                                        <span class="text-on-surface-variant block">Workspace Git SHA:</span>
                                        <strong class="text-on-surface font-label-sm">a9e38f1</strong>
                                    </div>
                                    <div>
                                        <span class="text-on-surface-variant block">Automated Tests:</span>
                                        <strong class="text-emerald-700">14/14 Passed (100%)</strong>
                                    </div>
                                </div>
                                <!-- Deliverables Checklist -->
                                <div class="flex flex-col gap-space-sm">
                                    <span class="font-label-md text-label-md uppercase tracking-wider text-primary font-bold">Verified Deliverables (4)</span>
                                    <!-- Deliverable 1: Notebook -->
                                    <div class="flex items-center justify-between p-space-sm bg-surface-container rounded-lg">
                                        <div class="flex items-center gap-space-sm min-w-0">
                                            <span class="material-symbols-outlined text-emerald-700 text-[20px]">check_circle</span>
                                            <div class="flex flex-col min-w-0">
                                                <span class="font-label-md text-label-md text-on-surface font-semibold truncate">churn_model_pipeline_v2.ipynb</span>
                                                <span class="font-body-sm text-body-sm text-on-surface-variant">Jupyter Notebook (58 cells, all outputs rendered, execution time 41s)</span>
                                            </div>
                                        </div>
                                        <button class="bg-surface-container-lowest text-primary hover:bg-secondary-fixed px-space-sm py-1 rounded font-label-sm text-label-sm transition-colors flex items-center gap-1 shrink-0">
                                            <span class="material-symbols-outlined text-[16px]">visibility</span> Inspect
                                        </button>
                                    </div>
                                    <!-- Deliverable 2: Model Artifact -->
                                    <div class="flex items-center justify-between p-space-sm bg-surface-container rounded-lg">
                                        <div class="flex items-center gap-space-sm min-w-0">
                                            <span class="material-symbols-outlined text-emerald-700 text-[20px]">check_circle</span>
                                            <div class="flex flex-col min-w-0">
                                                <span class="font-label-md text-label-md text-on-surface font-semibold truncate">xgboost_churn_v2.bin</span>
                                                <span class="font-body-sm text-body-sm text-on-surface-variant">Model Registry ID #MR-8821 (Serialized with XGBoost 2.0.3, 14.8MB)</span>
                                            </div>
                                        </div>
                                        <button class="bg-surface-container-lowest text-primary hover:bg-secondary-fixed px-space-sm py-1 rounded font-label-sm text-label-sm transition-colors flex items-center gap-1 shrink-0">
                                            <span class="material-symbols-outlined text-[16px]">download</span> Artifact
                                        </button>
                                    </div>
                                    <!-- Deliverable 3: Inference API -->
                                    <div class="flex items-center justify-between p-space-sm bg-surface-container rounded-lg">
                                        <div class="flex items-center gap-space-sm min-w-0">
                                            <span class="material-symbols-outlined text-emerald-700 text-[20px]">check_circle</span>
                                            <div class="flex flex-col min-w-0">
                                                <span class="font-label-md text-label-md text-on-surface font-semibold truncate">serve_model.py</span>
                                                <span class="font-body-sm text-body-sm text-on-surface-variant">Dockerized FastAPI Endpoint | Port 8000 | Healthcheck OK (/ready)</span>
                                            </div>
                                        </div>
                                        <button class="bg-surface-container-lowest text-primary hover:bg-secondary-fixed px-space-sm py-1 rounded font-label-sm text-label-sm transition-colors flex items-center gap-1 shrink-0">
                                            <span class="material-symbols-outlined text-[16px]">terminal</span> Logs
                                        </button>
                                    </div>
                                    <!-- Deliverable 4: Evaluation Report & Metrics -->
                                    <div class="p-space-sm bg-surface-container rounded-lg flex flex-col gap-space-xs">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-space-sm">
                                                <span class="material-symbols-outlined text-emerald-700 text-[20px]">check_circle</span>
                                                <span class="font-label-md text-label-md text-on-surface font-semibold">Automated Validation Report (SYS-AI-04 Range Rig)</span>
                                            </div>
                                            <span class="font-label-sm text-label-sm text-primary font-bold">METRICS PASS</span>
                                        </div>
                                        <div class="grid grid-cols-3 gap-space-xs mt-1">
                                            <div class="bg-surface-container-lowest p-space-xs rounded text-center">
                                                <span class="font-label-sm text-label-sm text-on-surface-variant block">AUC-ROC</span>
                                                <span class="font-label-md text-label-md text-primary font-bold">0.882</span>
                                            </div>
                                            <div class="bg-surface-container-lowest p-space-xs rounded text-center">
                                                <span class="font-label-sm text-label-sm text-on-surface-variant block">Precision @ 0.5</span>
                                                <span class="font-label-md text-label-md text-primary font-bold">0.840</span>
                                            </div>
                                            <div class="bg-surface-container-lowest p-space-xs rounded text-center">
                                                <span class="font-label-sm text-label-sm text-on-surface-variant block">Drift Index</span>
                                                <span class="font-label-md text-label-md text-emerald-700 font-bold">0.040 (Low)</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Live Code & Artifact Inspection Pane -->
                            <div class="bg-surface-container-lowest p-space-lg rounded-xl shadow-sm flex flex-col gap-space-md">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-space-xs">
                                        <span class="material-symbols-outlined text-primary text-[20px]">code</span>
                                        <span class="font-headline-sm text-headline-sm text-primary">Notebook Inspector</span>
                                    </div>
                                    <div class="flex items-center gap-space-xs font-label-sm text-label-sm">
                                        <span class="text-on-surface-variant">Cell 42 of 58:</span>
                                        <span class="bg-surface-container px-2 py-0.5 rounded font-mono text-primary font-semibold">Model Cross-Validation</span>
                                    </div>
                                </div>
                                <!-- Rendered Code Snippet Window -->
                                <div class="bg-surface-container-lowest rounded-xl overflow-hidden shadow-inner p-space-md font-mono text-body-sm leading-relaxed text-on-surface">
                                    <div class="flex items-center justify-between pb-2 mb-2 text-on-surface-variant font-label-sm text-label-sm">
                                        <span>In [42]: Python 3.11 (ipykernel)</span>
                                        <span class="text-emerald-700 font-semibold">Status: Success (1.84s)</span>
                                    </div>
                                    <pre class="overflow-x-auto text-primary"><code>from sklearn.model_selection import StratifiedKFold
import xgboost as xgb

skf = StratifiedKFold(n_splits=5, shuffle=True, random_state=42)
xgb_clf = xgb.XGBClassifier(
    n_estimators=350,
    learning_rate=0.03,
    max_depth=6,
    subsample=0.85,
    eval_metric="auc"
)

# Training across 5-fold stratification
cv_scores = cross_val_score(xgb_clf, X_train_preprocessed, y_train, cv=skf, scoring='roc_auc')
print(f"Mean 5-Fold AUC: {cv_scores.mean():.4f} (+/- {cv_scores.std():.4f})")</code></pre>
                                    <div class="mt-3 p-space-sm bg-surface-container-low rounded font-mono text-body-sm text-on-surface">
                                        <span class="text-on-surface-variant block font-label-sm text-label-sm uppercase">Standard Output:</span>
                                        <span class="font-semibold text-primary">>> Mean 5-Fold AUC: 0.8841 (+/- 0.0092)</span>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between font-label-sm text-label-sm text-on-surface-variant">
                                    <span>Student commit note: “Refactored feature imputation to prevent test leakage”</span>
                                    <a class="text-primary hover:underline font-semibold" href="#">Open Notebook in Full Sandbox →</a>
                                </div>
                            </div>
                        </div>
                        <!-- RIGHT ZONE: Strict 8-Part Rubric Matrix & Official Decision (Col 9-12) -->
                        <div class="xl:col-span-4 flex flex-col gap-space-md">
                            <!-- Rubric Summary Header with Sticky Distinction Badge -->
                            <div class="bg-surface-container-lowest p-space-md rounded-xl shadow-sm flex flex-col gap-space-sm">
                                <div class="flex items-center justify-between">
                                    <div class="flex flex-col">
                                        <span class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant font-semibold">Evaluation Engine</span>
                                        <h2 class="font-headline-md text-headline-md text-primary">8-Part Blueprint Rubric</h2>
                                    </div>
                                    <!-- Calculated Score Badge (Rose Gold / Distinction) -->
                                    <div class="bg-tertiary-fixed text-on-tertiary-fixed px-space-md py-space-xs rounded-xl flex flex-col items-center justify-center shadow-xs">
                                        <span class="font-label-sm text-label-sm uppercase tracking-wider font-semibold">Total Score</span>
                                        <div class="flex items-baseline gap-0.5">
                                            <span class="font-headline-xl text-headline-xl font-bold leading-none" id="total-score-display">92.0</span>
                                            <span class="font-label-md text-label-md font-semibold">/100</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- Grade Distinction Status Strip -->
                                <div class="flex items-center justify-between p-space-xs bg-secondary-fixed rounded-lg px-space-sm">
                                    <div class="flex items-center gap-space-xs">
                                        <span class="material-symbols-outlined text-primary text-[18px]">workspace_premium</span>
                                        <span class="font-label-md text-label-md text-on-secondary-fixed font-bold">GRADE TIER: DISTINCTION</span>
                                    </div>
                                    <span class="font-label-sm text-label-sm text-primary font-semibold">Meets All Thresholds</span>
                                </div>
                            </div>
                            <!-- Interactive 8-Part Rubric Sliders Container -->
                            <div class="bg-surface-container-lowest p-space-md rounded-xl shadow-sm flex flex-col gap-space-md max-h-[580px] overflow-y-auto pr-space-xs">
                                <!-- Criteria 1: Problem Understanding -->
                                <div class="rubric-item flex flex-col gap-space-xs bg-surface-container-low p-space-sm rounded-lg" data-max="10">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <span class="font-label-sm text-label-sm font-bold text-primary">1. Problem Understanding</span>
                                            <span class="font-label-sm text-label-sm text-on-surface-variant block">Scope, domain context, business constraints (10%)</span>
                                        </div>
                                        <div class="flex items-center gap-1">
                                            <input class="rubric-input w-16 text-right font-mono font-bold text-primary bg-surface-container-lowest p-1 rounded font-label-md text-label-md focus:outline-hidden" max="10" min="0" step="0.5" type="number" value="9.5" />
                                            <span class="font-label-sm text-label-sm text-on-surface-variant font-mono">/10</span>
                                        </div>
                                    </div>
                                    <input class="rubric-slider w-full accent-primary h-2 bg-secondary-fixed rounded-lg cursor-pointer" max="10" min="0" step="0.5" type="range" value="9.5" />
                                    <input class="w-full bg-surface-container-lowest text-on-surface text-body-sm p-1.5 rounded font-body-sm placeholder:text-on-surface-variant/60 focus:outline-hidden" placeholder="Add criterion note..." type="text" value="Superb articulation of churn costs vs retention campaign ROI." />
                                </div>
                                <!-- Criteria 2: Data Preparation & Feature Eng -->
                                <div class="rubric-item flex flex-col gap-space-xs bg-surface-container-low p-space-sm rounded-lg" data-max="15">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <span class="font-label-sm text-label-sm font-bold text-primary">2. Data Prep & Feature Eng</span>
                                            <span class="font-label-sm text-label-sm text-on-surface-variant block">Leakage prevention, categorical transforms (15%)</span>
                                        </div>
                                        <div class="flex items-center gap-1">
                                            <input class="rubric-input w-16 text-right font-mono font-bold text-primary bg-surface-container-lowest p-1 rounded font-label-md text-label-md focus:outline-hidden" max="15" min="0" step="0.5" type="number" value="14.0" />
                                            <span class="font-label-sm text-label-sm text-on-surface-variant font-mono">/15</span>
                                        </div>
                                    </div>
                                    <input class="rubric-slider w-full accent-primary h-2 bg-secondary-fixed rounded-lg cursor-pointer" max="15" min="0" step="0.5" type="range" value="14.0" />
                                    <input class="w-full bg-surface-container-lowest text-on-surface text-body-sm p-1.5 rounded font-body-sm placeholder:text-on-surface-variant/60 focus:outline-hidden" placeholder="Add criterion note..." type="text" value="Sound timestamp windowing. Outlier handling clearly justified." />
                                </div>
                                <!-- Criteria 3: Model Development & Architecture -->
                                <div class="rubric-item flex flex-col gap-space-xs bg-surface-container-low p-space-sm rounded-lg" data-max="20">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <span class="font-label-sm text-label-sm font-bold text-primary">3. Model Architecture & Training</span>
                                            <span class="font-label-sm text-label-sm text-on-surface-variant block">Algorithm suitability, hyperparams (20%)</span>
                                        </div>
                                        <div class="flex items-center gap-1">
                                            <input class="rubric-input w-16 text-right font-mono font-bold text-primary bg-surface-container-lowest p-1 rounded font-label-md text-label-md focus:outline-hidden" max="20" min="0" step="0.5" type="number" value="18.5" />
                                            <span class="font-label-sm text-label-sm text-on-surface-variant font-mono">/20</span>
                                        </div>
                                    </div>
                                    <input class="rubric-slider w-full accent-primary h-2 bg-secondary-fixed rounded-lg cursor-pointer" max="20" min="0" step="0.5" type="range" value="18.5" />
                                    <input class="w-full bg-surface-container-lowest text-on-surface text-body-sm p-1.5 rounded font-body-sm placeholder:text-on-surface-variant/60 focus:outline-hidden" placeholder="Add criterion note..." type="text" value="Systematic XGBoost baseline vs LightGBM comparison." />
                                </div>
                                <!-- Criteria 4: Model Evaluation & Validation -->
                                <div class="rubric-item flex flex-col gap-space-xs bg-surface-container-low p-space-sm rounded-lg" data-max="15">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <span class="font-label-sm text-label-sm font-bold text-primary">4. Model Evaluation & Validation</span>
                                            <span class="font-label-sm text-label-sm text-on-surface-variant block">Precision-Recall trade-offs, drift safeguards (15%)</span>
                                        </div>
                                        <div class="flex items-center gap-1">
                                            <input class="rubric-input w-16 text-right font-mono font-bold text-primary bg-surface-container-lowest p-1 rounded font-label-md text-label-md focus:outline-hidden" max="15" min="0" step="0.5" type="number" value="14.0" />
                                            <span class="font-label-sm text-label-sm text-on-surface-variant font-mono">/15</span>
                                        </div>
                                    </div>
                                    <input class="rubric-slider w-full accent-primary h-2 bg-secondary-fixed rounded-lg cursor-pointer" max="15" min="0" step="0.5" type="range" value="14.0" />
                                    <input class="w-full bg-surface-container-lowest text-on-surface text-body-sm p-1.5 rounded font-body-sm placeholder:text-on-surface-variant/60 focus:outline-hidden" placeholder="Add criterion note..." type="text" value="Comprehensive confusion matrix and cohort decile lift curves." />
                                </div>
                                <!-- Criteria 5: Problem Solving & Iteration -->
                                <div class="rubric-item flex flex-col gap-space-xs bg-surface-container-low p-space-sm rounded-lg" data-max="15">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <span class="font-label-sm text-label-sm font-bold text-primary">5. Problem Solving & Iteration</span>
                                            <span class="font-label-sm text-label-sm text-on-surface-variant block">Response to v1 feedback, error diagnostics (15%)</span>
                                        </div>
                                        <div class="flex items-center gap-1">
                                            <input class="rubric-input w-16 text-right font-mono font-bold text-primary bg-surface-container-lowest p-1 rounded font-label-md text-label-md focus:outline-hidden" max="15" min="0" step="0.5" type="number" value="13.5" />
                                            <span class="font-label-sm text-label-sm text-on-surface-variant font-mono">/15</span>
                                        </div>
                                    </div>
                                    <input class="rubric-slider w-full accent-primary h-2 bg-secondary-fixed rounded-lg cursor-pointer" max="15" min="0" step="0.5" type="range" value="13.5" />
                                    <input class="w-full bg-surface-container-lowest text-on-surface text-body-sm p-1.5 rounded font-body-sm placeholder:text-on-surface-variant/60 focus:outline-hidden" placeholder="Add criterion note..." type="text" value="Addressed all 3 notes from previous iteration." />
                                </div>
                                <!-- Criteria 6: Deployment & API Service -->
                                <div class="rubric-item flex flex-col gap-space-xs bg-surface-container-low p-space-sm rounded-lg" data-max="10">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <span class="font-label-sm text-label-sm font-bold text-primary">6. Deployment & API Service</span>
                                            <span class="font-label-sm text-label-sm text-on-surface-variant block">FastAPI contract, Docker readiness (10%)</span>
                                        </div>
                                        <div class="flex items-center gap-1">
                                            <input class="rubric-input w-16 text-right font-mono font-bold text-primary bg-surface-container-lowest p-1 rounded font-label-md text-label-md focus:outline-hidden" max="10" min="0" step="0.5" type="number" value="9.0" />
                                            <span class="font-label-sm text-label-sm text-on-surface-variant font-mono">/10</span>
                                        </div>
                                    </div>
                                    <input class="rubric-slider w-full accent-primary h-2 bg-secondary-fixed rounded-lg cursor-pointer" max="10" min="0" step="0.5" type="range" value="9.0" />
                                    <input class="w-full bg-surface-container-lowest text-on-surface text-body-sm p-1.5 rounded font-body-sm placeholder:text-on-surface-variant/60 focus:outline-hidden" placeholder="Add criterion note..." type="text" value="Robust Pydantic schema validation for telemetry inputs." />
                                </div>
                                <!-- Criteria 7: Documentation & Reproducibility -->
                                <div class="rubric-item flex flex-col gap-space-xs bg-surface-container-low p-space-sm rounded-lg" data-max="10">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <span class="font-label-sm text-label-sm font-bold text-primary">7. Documentation & Reproducibility</span>
                                            <span class="font-label-sm text-label-sm text-on-surface-variant block">Conda environment freeze, clean markdown (10%)</span>
                                        </div>
                                        <div class="flex items-center gap-1">
                                            <input class="rubric-input w-16 text-right font-mono font-bold text-primary bg-surface-container-lowest p-1 rounded font-label-md text-label-md focus:outline-hidden" max="10" min="0" step="0.5" type="number" value="9.0" />
                                            <span class="font-label-sm text-label-sm text-on-surface-variant font-mono">/10</span>
                                        </div>
                                    </div>
                                    <input class="rubric-slider w-full accent-primary h-2 bg-secondary-fixed rounded-lg cursor-pointer" max="10" min="0" step="0.5" type="range" value="9.0" />
                                    <input class="w-full bg-surface-container-lowest text-on-surface text-body-sm p-1.5 rounded font-body-sm placeholder:text-on-surface-variant/60 focus:outline-hidden" placeholder="Add criterion note..." type="text" value="Clear step-by-step reproduction guide in README.md." />
                                </div>
                                <!-- Criteria 8: Business Understanding & Impact -->
                                <div class="rubric-item flex flex-col gap-space-xs bg-surface-container-low p-space-sm rounded-lg" data-max="5">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <span class="font-label-sm text-label-sm font-bold text-primary">8. Business Understanding & Impact</span>
                                            <span class="font-label-sm text-label-sm text-on-surface-variant block">Actionable stakeholder recommendations (5%)</span>
                                        </div>
                                        <div class="flex items-center gap-1">
                                            <input class="rubric-input w-16 text-right font-mono font-bold text-primary bg-surface-container-lowest p-1 rounded font-label-md text-label-md focus:outline-hidden" max="5" min="0" step="0.5" type="number" value="4.5" />
                                            <span class="font-label-sm text-label-sm text-on-surface-variant font-mono">/5</span>
                                        </div>
                                    </div>
                                    <input class="rubric-slider w-full accent-primary h-2 bg-secondary-fixed rounded-lg cursor-pointer" max="5" min="0" step="0.5" type="range" value="4.5" />
                                    <input class="w-full bg-surface-container-lowest text-on-surface text-body-sm p-1.5 rounded font-body-sm placeholder:text-on-surface-variant/60 focus:outline-hidden" placeholder="Add criterion note..." type="text" value="Includes calculated financial impact of false negatives." />
                                </div>
                            </div>
                            <!-- Instructor Feedback & Decision Workflow Box -->
                            <div class="bg-surface-container-lowest p-space-md rounded-xl shadow-sm flex flex-col gap-space-md">
                                <!-- Summary Comments Area -->
                                <div class="flex flex-col gap-space-xs">
                                    <label class="font-label-md text-label-md uppercase tracking-wider text-primary font-bold">Overall Instructor Synthesis</label>
                                    <textarea class="w-full bg-surface-container p-space-sm rounded-lg text-body-sm font-body-sm text-on-surface focus:outline-hidden" placeholder="Provide actionable synthetic guidance for student portfolio..." rows="3">Excellent resolution on the feature leakage vector highlighted in iteration v1. Model performance surpasses benchmark AUC (0.85). Code structure and API packaging are production-ready. Approved for deployment phase.</textarea>
                                </div>
                                <!-- Outcome Selection Radio Group -->
                                <div class="flex flex-col gap-space-xs">
                                    <span class="font-label-sm text-label-sm uppercase text-on-surface-variant font-semibold">Official Outcome Decision</span>
                                    <div class="grid grid-cols-3 gap-space-xs">
                                        <label class="flex items-center justify-center gap-1 p-space-sm bg-secondary-fixed text-primary rounded-lg cursor-pointer font-label-sm text-label-sm font-bold">
                                            <input checked="" class="accent-primary" name="grading-decision" type="radio" value="approved" />
                                            <span>Approved</span>
                                        </label>
                                        <label class="flex items-center justify-center gap-1 p-space-sm bg-surface-container text-on-surface-variant rounded-lg cursor-pointer font-label-sm text-label-sm font-semibold hover:bg-surface-container-high">
                                            <input class="accent-primary" name="grading-decision" type="radio" value="revisions" />
                                            <span>Revisions</span>
                                        </label>
                                        <label class="flex items-center justify-center gap-1 p-space-sm bg-surface-container text-on-surface-variant rounded-lg cursor-pointer font-label-sm text-label-sm font-semibold hover:bg-surface-container-high">
                                            <input class="accent-primary" name="grading-decision" type="radio" value="rejected" />
                                            <span>Rejected</span>
                                        </label>
                                    </div>
                                </div>
                                <!-- Action Button -->
                                <div class="pt-space-xs flex flex-col gap-space-xs">
                                    <button class="w-full bg-primary hover:bg-[#3b1477] text-on-primary py-space-sm rounded-xl font-headline-sm text-headline-sm shadow-md transition-all flex items-center justify-center gap-space-sm" id="btn-submit-grade">
                                        <span class="material-symbols-outlined text-[20px]">assignment_turned_in</span>
                                        <span>Submit Official Grade (92.0)</span>
                                    </button>
                                    <p class="font-label-sm text-label-sm text-on-surface-variant text-center">Commits signed cryptographic instructor ledger to SYS-AI-05 repository.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Confirmation Dialog (Embedded Modal overlay logic) -->
                    <div class="hidden fixed inset-0 z-50 flex items-center justify-center bg-inverse-surface/40 backdrop-blur-xs p-space-md" id="grade-confirm-modal">
                        <div class="bg-surface-container-lowest max-w-md w-full p-space-xl rounded-xl shadow-2xl flex flex-col gap-space-md">
                            <div class="flex items-center gap-space-sm text-primary">
                                <span class="material-symbols-outlined text-[28px]">verified</span>
                                <h3 class="font-headline-md text-headline-md font-bold">Confirm Grade Submission</h3>
                            </div>
                            <p class="font-body-md text-body-md text-on-surface">
                                You are committing an official grade of <strong class="text-primary font-bold" id="modal-score">92.0 / 100 [DISTINCTION]</strong> for <strong class="text-on-surface">Alexey Morozov (TCK-CHURN-202 v2)</strong>.
                            </p>
                            <div class="p-space-sm bg-surface-container-low rounded-lg text-label-sm font-label-sm text-on-surface-variant flex flex-col gap-1">
                                <div>Decision: <strong class="text-primary uppercase">Approved</strong></div>
                                <div>Reviewer Timestamp: <span class="font-mono text-on-surface">2025-05-18T16:48:10Z</span></div>
                                <div>Notification: <span class="text-on-surface">Candidate and Cohort Lead notified</span></div>
                            </div>
                            <div class="flex items-center justify-end gap-space-sm pt-space-xs">
                                <button class="px-space-md py-space-sm rounded-lg text-primary hover:bg-surface-container font-label-md text-label-md transition-colors" id="btn-cancel-modal">
                                    Cancel
                                </button>
                                <button class="bg-primary hover:bg-[#3b1477] text-on-primary px-space-lg py-space-sm rounded-lg font-label-md text-label-md font-bold shadow-sm transition-colors" id="btn-confirm-final">
                                    Confirm & Record
                                </button>
                            </div>
                        </div>
                    </div>
                    <script src="js/main.js"></script>
                </div>
            </div>
        </main>
    </div>
</body>

</html>