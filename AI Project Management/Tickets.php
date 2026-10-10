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
            <nav class="flex flex-col gap-space-xs px-space-md" data-active-classes="bg-primary text-on-primary font-semibold shadow-[0_1px_3px_rgba(76,29,149,0.12)]"><a class="flex items-center gap-space-md px-space-md py-space-sm rounded text-on-surface-variant font-body-md text-body-md hover:bg-surface-container-high hover:text-on-surface transition-colors" data-path="dashboard" href="Dashboard.php"><span class="material-symbols-outlined text-[18px]">space_dashboard</span><span>Dashboard</span></a><a aria-current="page" class="flex items-center gap-space-md px-space-md py-space-sm rounded transition-colors bg-primary text-on-primary font-semibold shadow-[0_1px_3px_rgba(76,29,149,0.12)]" data-path="my-tickets" href="Tickets.php"><span class="material-symbols-outlined text-[18px]">assignment</span><span>My Tickets</span></a><a class="flex items-center gap-space-md px-space-md py-space-sm rounded text-on-surface-variant font-body-md text-body-md hover:bg-surface-container-high hover:text-on-surface transition-colors" data-path="ticket-details" href="TicketDetails.php"><span class="material-symbols-outlined text-[18px]">description</span><span>Ticket Details</span></a><a class="flex items-center gap-space-md px-space-md py-space-sm rounded text-on-surface-variant font-body-md text-body-md hover:bg-surface-container-high hover:text-on-surface transition-colors" data-path="my-submissions" href="Submissions.php"><span class="material-symbols-outlined text-[18px]">inventory_2</span><span>My Submissions</span></a><a class="flex items-center justify-between px-space-md py-space-sm rounded text-on-surface-variant font-body-md text-body-md hover:bg-surface-container-high hover:text-on-surface transition-colors" data-path="notifications" href="Dashboard.php">
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
                <div class="px-margin-desktop py-space-xl flex flex-col gap-space-lg">
                    <!-- Top Meta Context Bar & Breadcrumbs -->
                    <div class="flex flex-wrap items-center justify-between gap-space-md">
                        <div class="flex items-center gap-space-sm font-label-sm text-label-sm text-on-surface-variant">
                            <span class="px-space-sm py-0.5 rounded bg-surface-container font-code-inline text-primary font-semibold">VK-SYSTEM-AI</span>
                            <span>/</span>
                            <span class="uppercase tracking-wider">Flight-Range Telemetry</span>
                            <span>/</span>
                            <span class="text-primary font-semibold uppercase tracking-wider">Work Order Manifest</span>
                        </div>
                        <div class="flex items-center gap-space-md">
                            <div class="flex items-center gap-space-xs px-space-sm py-1 rounded bg-surface-container-low font-code-inline text-label-sm text-on-surface-variant">
                                <span class="w-1.5 h-1.5 rounded-full bg-primary animate-ping"></span>
                                <span class="font-semibold text-primary">SLA SYNC:</span>
                                <span>99.98% LOCKED</span>
                            </div>
                            <div class="flex items-center gap-space-xs px-space-sm py-1 rounded bg-tertiary-fixed font-code-inline text-label-sm text-on-tertiary-fixed">
                                <span class="material-symbols-outlined text-[14px]">timer</span>
                                <span>RANGE CLOCK: T+148:22:09</span>
                            </div>
                        </div>
                    </div>
                    <!-- Header Section with Operational Actions -->
                    <div class="flex flex-col xl:flex-row xl:items-end justify-between gap-space-lg pb-space-xs">
                        <div class="flex flex-col gap-space-xs max-w-3xl">
                            <div class="flex items-center gap-space-sm">
                                <span class="px-2 py-0.5 rounded bg-primary text-on-primary font-code-inline text-label-sm font-bold tracking-widest uppercase">SYS-AI-01</span>
                                <span class="font-code-inline text-label-sm text-on-tertiary-container tracking-wider font-semibold">LIVE REPOSITORY // 7 TICKETS QUEUED</span>
                            </div>
                            <h1 class="font-headline-xl text-headline-xl text-primary tracking-tight font-bold">
                                Assigned Project Tickets (AI Work Orders)
                            </h1>
                            <p class="font-body-md text-body-md text-on-surface-variant">
                                Simulated industrial task queue for Cohort 24-B • Enterprise SLA &amp; Scenario Verification across synthetic enterprise avionics and core AI telemetry.
                            </p>
                        </div>
                        <!-- Action Panel & View Switcher -->
                        <div class="flex flex-wrap items-center gap-space-sm">
                            <!-- View Toggle -->
                            <div class="flex items-center bg-surface-container-high p-0.5 rounded shadow-sm">
                                <button class="flex items-center gap-space-xs px-space-md py-1.5 rounded bg-surface-container-lowest text-primary shadow-sm font-label-md text-label-md font-semibold transition-all" id="viewBtnTable">
                                    <span class="material-symbols-outlined text-[16px]">table_rows</span>
                                    <span>Table View</span>
                                </button>
                                <button class="flex items-center gap-space-xs px-space-md py-1.5 rounded text-on-surface-variant hover:text-primary font-label-md text-label-md transition-all" id="viewBtnKanban">
                                    <span class="material-symbols-outlined text-[16px]">view_kanban</span>
                                    <span>Kanban Board</span>
                                </button>
                            </div>
                            <!-- Sync & Export Buttons -->
                            <button class="flex items-center gap-space-xs px-space-md py-2 rounded bg-surface-container-lowest text-primary hover:bg-surface-container font-label-md text-label-md font-semibold shadow-sm transition-all">
                                <span class="material-symbols-outlined text-[16px]">cloud_sync</span>
                                <span>Sync Range Backlog</span>
                            </button>
                            <button class="flex items-center gap-space-xs px-space-md py-2 rounded bg-primary text-on-primary hover:bg-primary-container font-label-md text-label-md font-semibold shadow-sm transition-all">
                                <span class="material-symbols-outlined text-[16px]">download</span>
                                <span>Export Ticket Log (JSON/CSV)</span>
                            </button>
                        </div>
                    </div>
                    <!-- Telemetry Diagnostic Stat Strip -->
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-space-sm">
                        <div class="p-space-md rounded bg-surface-container-lowest shadow-sm flex flex-col justify-between">
                            <span class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant font-semibold">Active Work Orders</span>
                            <div class="flex items-baseline gap-space-xs mt-1">
                                <span class="font-headline-lg text-headline-lg font-bold text-primary">07</span>
                                <span class="font-code-inline text-label-sm text-on-surface-variant">/ 09 TOTAL</span>
                            </div>
                        </div>
                        <div class="p-space-md rounded bg-surface-container-lowest shadow-sm flex flex-col justify-between">
                            <span class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant font-semibold">Critical SLA</span>
                            <div class="flex items-baseline gap-space-xs mt-1">
                                <span class="font-headline-lg text-headline-lg font-bold text-error">02</span>
                                <span class="font-code-inline text-label-sm text-error">&lt; 24h Left</span>
                            </div>
                        </div>
                        <div class="p-space-md rounded bg-surface-container-lowest shadow-sm flex flex-col justify-between">
                            <span class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant font-semibold">In Progress</span>
                            <div class="flex items-baseline gap-space-xs mt-1">
                                <span class="font-headline-lg text-headline-lg font-bold text-secondary">03</span>
                                <span class="font-code-inline text-label-sm text-secondary font-semibold">Active Run</span>
                            </div>
                        </div>
                        <div class="p-space-md rounded bg-surface-container-lowest shadow-sm flex flex-col justify-between">
                            <span class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant font-semibold">Changes Needed</span>
                            <div class="flex items-baseline gap-space-xs mt-1">
                                <span class="font-headline-lg text-headline-lg font-bold text-tertiary">01</span>
                                <span class="font-code-inline text-label-sm text-tertiary font-semibold">Revision</span>
                            </div>
                        </div>
                        <div class="p-space-md rounded bg-surface-container-lowest shadow-sm flex flex-col justify-between">
                            <span class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant font-semibold">Review Pending</span>
                            <div class="flex items-baseline gap-space-xs mt-1">
                                <span class="font-headline-lg text-headline-lg font-bold text-primary">01</span>
                                <span class="font-code-inline text-label-sm text-primary font-semibold">Submitted</span>
                            </div>
                        </div>
                        <div class="p-space-md rounded bg-surface-container-lowest shadow-sm flex flex-col justify-between">
                            <span class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant font-semibold">Gate Cleared</span>
                            <div class="flex items-baseline gap-space-xs mt-1">
                                <span class="font-headline-lg text-headline-lg font-bold text-on-surface">02</span>
                                <span class="font-code-inline text-label-sm text-on-tertiary-container font-semibold">Archived</span>
                            </div>
                        </div>
                        <div class="p-space-md rounded bg-surface-container-high shadow-sm flex flex-col justify-between">
                            <span class="font-label-sm text-label-sm uppercase tracking-wider text-primary font-semibold">Mean Target F1</span>
                            <div class="flex items-baseline gap-space-xs mt-1">
                                <span class="font-headline-lg text-headline-lg font-bold text-primary">0.914</span>
                                <span class="font-code-inline text-label-sm text-primary font-semibold">Range Avg</span>
                            </div>
                        </div>
                    </div>
                    <!-- Advanced Filter & Search Terminal Bar -->
                    <div class="p-space-md rounded bg-surface-container-lowest shadow-sm flex flex-col gap-space-md">
                        <!-- Search row -->
                        <div class="flex flex-col md:flex-row items-center gap-space-md">
                            <div class="relative flex-1 w-full">
                                <span class="material-symbols-outlined absolute left-space-md top-1/2 -translate-y-1/2 text-[18px] text-outline">search</span>
                                <input class="w-full pl-10 pr-space-md py-2.5 rounded bg-surface-container-low font-body-md text-body-md text-on-surface placeholder:text-outline focus:outline-none focus:bg-surface-container-lowest transition-colors shadow-inner" id="searchInput" placeholder="Search by Ticket ID (e.g. AI-024), keywords, or algorithms..." type="text" />
                                <div class="absolute right-space-sm top-1/2 -translate-y-1/2 flex items-center gap-space-xs">
                                    <kbd class="px-1.5 py-0.5 rounded bg-surface-container font-code-inline text-label-sm text-on-surface-variant">⌘K</kbd>
                                </div>
                            </div>
                            <div class="flex items-center gap-space-xs w-full md:w-auto justify-end">
                                <button class="px-space-md py-2 rounded text-outline hover:text-on-surface font-label-md text-label-md flex items-center gap-space-xs transition-colors" id="resetFilters">
                                    <span class="material-symbols-outlined text-[16px]">restart_alt</span>
                                    <span>Clear Filters</span>
                                </button>
                                <div class="h-6 w-px bg-surface-variant"></div>
                                <span class="font-code-inline text-label-sm text-on-surface-variant px-space-xs">FILTER ENGINE: READY</span>
                            </div>
                        </div>
                        <!-- Filter Controls Strip -->
                        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-space-sm pt-space-xs">
                            <!-- Status Filter -->
                            <div class="flex flex-col gap-1">
                                <label class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant font-semibold">Status</label>
                                <div class="relative">
                                    <select class="w-full appearance-none pl-3 pr-8 py-1.5 rounded bg-surface-container font-label-md text-label-md text-primary font-semibold focus:outline-none focus:bg-surface-container-high transition-colors cursor-pointer" id="filterStatus">
                                        <option value="ALL">All Active Statuses</option>
                                        <option value="In Progress">In Progress (Active)</option>
                                        <option value="New">New / Unassigned</option>
                                        <option value="Changes Requested">Changes Requested</option>
                                        <option value="Submitted">Submitted (Under Review)</option>
                                        <option value="Approved">Approved</option>
                                    </select>
                                    <span class="material-symbols-outlined pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 text-[16px] text-primary">expand_more</span>
                                </div>
                            </div>
                            <!-- Priority Filter -->
                            <div class="flex flex-col gap-1">
                                <label class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant font-semibold">Priority</label>
                                <div class="relative">
                                    <select class="w-full appearance-none pl-3 pr-8 py-1.5 rounded bg-surface-container font-label-md text-label-md text-primary font-semibold focus:outline-none focus:bg-surface-container-high transition-colors cursor-pointer" id="filterPriority">
                                        <option value="ALL">All Priorities</option>
                                        <option value="Critical">Critical (Tier 1)</option>
                                        <option value="High">High</option>
                                        <option value="Medium">Medium</option>
                                        <option value="Low">Low</option>
                                    </select>
                                    <span class="material-symbols-outlined pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 text-[16px] text-primary">expand_more</span>
                                </div>
                            </div>
                            <!-- Department Filter -->
                            <div class="flex flex-col gap-1">
                                <label class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant font-semibold">Department</label>
                                <div class="relative">
                                    <select class="w-full appearance-none pl-3 pr-8 py-1.5 rounded bg-surface-container font-label-md text-label-md text-primary font-semibold focus:outline-none focus:bg-surface-container-high transition-colors cursor-pointer" id="filterDept">
                                        <option value="ALL">All Departments</option>
                                        <option value="Retention Ops">Retention Ops</option>
                                        <option value="Financial Risk">Financial Risk</option>
                                        <option value="QA &amp; Manufacturing">QA &amp; Manufacturing</option>
                                        <option value="HR Tech">HR Tech</option>
                                        <option value="Security SOC">Security SOC</option>
                                    </select>
                                    <span class="material-symbols-outlined pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 text-[16px] text-primary">expand_more</span>
                                </div>
                            </div>
                            <!-- Scenario Category (7 Core Blueprints) -->
                            <div class="flex flex-col gap-1">
                                <label class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant font-semibold">Scenario Category</label>
                                <div class="relative">
                                    <select class="w-full appearance-none pl-3 pr-8 py-1.5 rounded bg-surface-container font-label-md text-label-md text-primary font-semibold focus:outline-none focus:bg-surface-container-high transition-colors cursor-pointer" id="filterScenario">
                                        <option value="ALL">7 Core Blueprints</option>
                                        <option value="Predictive Churn">Predictive Churn</option>
                                        <option value="Fraud Detection">Fraud Detection</option>
                                        <option value="CV Defect">CV Defect</option>
                                        <option value="NLP Complaint">NLP Complaint</option>
                                        <option value="GenAI RAG">GenAI RAG</option>
                                        <option value="AI Agent">AI Agent</option>
                                        <option value="AI SOC Failure">AI SOC Failure</option>
                                    </select>
                                    <span class="material-symbols-outlined pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 text-[16px] text-primary">expand_more</span>
                                </div>
                            </div>
                            <!-- Deadline Quick Filter -->
                            <div class="flex flex-col gap-1 col-span-2 sm:col-span-1">
                                <label class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant font-semibold">Deadline Window</label>
                                <div class="relative">
                                    <select class="w-full appearance-none pl-3 pr-8 py-1.5 rounded bg-surface-container font-label-md text-label-md text-primary font-semibold focus:outline-none focus:bg-surface-container-high transition-colors cursor-pointer" id="filterDeadline">
                                        <option value="ALL">All Deadlines</option>
                                        <option value="URGENT">Approaching (Next 48h)</option>
                                        <option value="WEEK">Next 7 Days</option>
                                        <option value="ARCHIVED">Completed History</option>
                                    </select>
                                    <span class="material-symbols-outlined pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 text-[16px] text-primary">expand_more</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Active Filter Badges Ribbon -->
                    <div class="flex items-center gap-space-sm flex-wrap text-on-surface-variant">
                        <span class="font-label-sm text-label-sm font-semibold uppercase tracking-wider">Active Range Filters:</span>
                        <span class="inline-flex items-center gap-space-xs px-2 py-0.5 rounded bg-surface-container-high font-code-inline text-label-sm text-primary">
                            Cohort: 24-B
                            <button class="hover:text-error ml-1">×</button>
                        </span>
                        <span class="inline-flex items-center gap-space-xs px-2 py-0.5 rounded bg-surface-container-high font-code-inline text-label-sm text-primary">
                            Telemetry Gate: v4.18
                            <button class="hover:text-error ml-1">×</button>
                        </span>
                        <span class="font-code-inline text-label-sm text-on-tertiary-container ml-auto">MATCHED: 7 WORK ORDERS</span>
                    </div>
                    <!-- Main Workspace Container -->
                    <div class="rounded bg-surface-container-lowest shadow-sm overflow-hidden flex flex-col">
                        <!-- Table Header Bar -->
                        <div class="overflow-x-auto w-full">
                            <table class="w-full text-left border-collapse" id="ticketsTable">
                                <thead>
                                    <tr class="bg-surface-container font-label-md text-label-md text-primary uppercase tracking-wider select-none">
                                        <th class="py-space-md px-space-md w-28">Ticket ID</th>
                                        <th class="py-space-md px-space-md">Objective &amp; Target Blueprint</th>
                                        <th class="py-space-md px-space-md hidden md:table-cell">Stakeholder</th>
                                        <th class="py-space-md px-space-md hidden lg:table-cell">Category</th>
                                        <th class="py-space-md px-space-md">Priority</th>
                                        <th class="py-space-md px-space-md hidden sm:table-cell">Deadline</th>
                                        <th class="py-space-md px-space-md">Status</th>
                                        <th class="py-space-md px-space-md hidden xl:table-cell w-36">Pipeline Stage</th>
                                        <th class="py-space-md px-space-md text-right w-28">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-surface-container font-body-md text-body-md" id="ticketRowsContainer">
                                    <!-- Row 1: AI-024 (Active & Inspected) -->
                                    <tr class="hover:bg-surface-container-low transition-colors group cursor-pointer ticket-row" data-dept="Retention Ops" data-id="AI-024" data-priority="Critical" data-scenario="Predictive Churn" data-status="In Progress" data-urgent="true">
                                        <td class="py-space-md px-space-md font-code-inline text-label-md">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded bg-primary text-on-primary font-bold shadow-sm">AI-024</span>
                                        </td>
                                        <td class="py-space-md px-space-md">
                                            <div class="flex flex-col min-w-0">
                                                <div class="flex items-center gap-space-xs">
                                                    <span class="font-headline-md text-[14px] text-primary font-semibold truncate">Customer Churn Prediction — Drift Compensation</span>
                                                    <span class="material-symbols-outlined text-[14px] text-tertiary">star</span>
                                                </div>
                                                <span class="font-body-sm text-body-sm text-on-surface-variant truncate">Retrain XGBoost ensemble against Q3 telemetry distribution drift; F1 min &gt; 0.89.</span>
                                            </div>
                                        </td>
                                        <td class="py-space-md px-space-md hidden md:table-cell">
                                            <div class="flex flex-col font-label-sm text-label-sm">
                                                <span class="font-semibold text-on-surface">Retention Ops</span>
                                                <span class="text-on-surface-variant font-code-inline">Elena Rostova</span>
                                            </div>
                                        </td>
                                        <td class="py-space-md px-space-md hidden lg:table-cell">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded bg-secondary-container text-on-secondary-container font-label-sm text-label-sm font-semibold">
                                                Predictive Churn
                                            </span>
                                        </td>
                                        <td class="py-space-md px-space-md">
                                            <div class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded bg-surface-container-high font-label-sm text-label-sm font-bold text-primary">
                                                <span class="w-2 h-2 rounded-full bg-error animate-pulse"></span>
                                                <span>CRITICAL</span>
                                            </div>
                                        </td>
                                        <td class="py-space-md px-space-md hidden sm:table-cell font-code-inline text-label-sm">
                                            <div class="flex items-center gap-1 text-error font-semibold">
                                                <span class="material-symbols-outlined text-[14px]">alarm</span>
                                                <span>18h left</span>
                                            </div>
                                        </td>
                                        <td class="py-space-md px-space-md">
                                            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded bg-primary-fixed text-on-primary-fixed font-label-sm text-label-sm font-semibold">
                                                <span class="w-1.5 h-1.5 rounded-full bg-primary animate-ping"></span>
                                                <span>In Progress</span>
                                            </span>
                                        </td>
                                        <td class="py-space-md px-space-md hidden xl:table-cell">
                                            <div class="flex flex-col gap-1">
                                                <div class="flex items-center justify-between font-code-inline text-label-sm">
                                                    <span class="text-on-surface-variant">Validation</span>
                                                    <span class="font-semibold text-primary">74%</span>
                                                </div>
                                                <div class="w-full bg-surface-container h-1.5 rounded-full overflow-hidden">
                                                    <div class="bg-primary h-full rounded-full transition-all duration-500" style="width: 74%"></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-space-md px-space-md text-right">
                                            <button class="px-space-md py-1 rounded bg-primary text-on-primary hover:bg-secondary transition-all font-label-sm text-label-sm font-semibold shadow-sm inline-flex items-center gap-0.5" onclick="toggleDetails('AI-024')">
                                                <span>Inspect</span>
                                                <span class="material-symbols-outlined text-[14px]">open_in_new</span>
                                            </button>
                                        </td>
                                    </tr>
                                    <!-- Expanded Details Drawer Panel for AI-024 -->
                                    <tr class="bg-surface-container-low transition-all" id="drawer-AI-024">
                                        <td class="p-space-lg" colspan="9">
                                            <div class="rounded bg-surface-container-lowest p-space-lg shadow-sm flex flex-col gap-space-md">
                                                <!-- Top Drawer Context Header -->
                                                <div class="flex flex-wrap items-center justify-between gap-space-md pb-space-xs">
                                                    <div class="flex items-center gap-space-md">
                                                        <div class="p-2 rounded bg-primary text-on-primary flex items-center justify-center">
                                                            <span class="material-symbols-outlined text-[20px]">analytics</span>
                                                        </div>
                                                        <div class="flex flex-col">
                                                            <div class="flex items-center gap-space-sm">
                                                                <span class="font-headline-md text-headline-md text-primary font-bold">AI-024: Telemetry Diagnostics &amp; Direct Run Artifacts</span>
                                                                <span class="px-2 py-0.5 rounded bg-tertiary-fixed font-code-inline text-label-sm text-on-tertiary-fixed font-semibold">EPOCH 44 / 50</span>
                                                            </div>
                                                            <span class="font-body-sm text-body-sm text-on-surface-variant">Assigned to: Alex Chen (VK-88219) • Target Commit: 0c89ba7e • Pipeline: Range Runner v4.18</span>
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center gap-space-xs">
                                                        <a class="inline-flex items-center gap-space-xs px-space-md py-1.5 rounded bg-surface-container text-primary font-label-md text-label-md font-semibold hover:bg-surface-container-high transition-colors" href="#">
                                                            <span class="material-symbols-outlined text-[16px]">database</span>
                                                            <span>SYS-AI-02 Data Portal</span>
                                                        </a>
                                                        <a class="inline-flex items-center gap-space-xs px-space-md py-1.5 rounded bg-surface-container text-primary font-label-md text-label-md font-semibold hover:bg-surface-container-high transition-colors" href="#">
                                                            <span class="material-symbols-outlined text-[16px]">terminal</span>
                                                            <span>SYS-AI-03 Notebook</span>
                                                        </a>
                                                        <button class="p-1.5 rounded text-on-surface-variant hover:text-primary transition-colors" onclick="toggleDetails('AI-024')">
                                                            <span class="material-symbols-outlined text-[18px]">close</span>
                                                        </button>
                                                    </div>
                                                </div>
                                                <!-- Technical Metrics & Topology Inspector -->
                                                <div class="grid grid-cols-1 md:grid-cols-3 gap-space-md">
                                                    <!-- Box 1: Problem Definition & Constraints -->
                                                    <div class="p-space-md rounded bg-surface-container-low flex flex-col gap-space-xs">
                                                        <span class="font-label-sm text-label-sm uppercase font-semibold tracking-wider text-primary">Acceptance SLA &amp; Thresholds</span>
                                                        <ul class="flex flex-col gap-space-xs font-body-sm text-body-sm text-on-surface">
                                                            <li class="flex items-center justify-between">
                                                                <span class="text-on-surface-variant">Minimum Target F1:</span>
                                                                <span class="font-code-inline font-bold text-primary">&gt;= 0.8900</span>
                                                            </li>
                                                            <li class="flex items-center justify-between">
                                                                <span class="text-on-surface-variant">Current Checkpoint F1:</span>
                                                                <span class="font-code-inline font-bold text-secondary">0.8932 (PASS)</span>
                                                            </li>
                                                            <li class="flex items-center justify-between">
                                                                <span class="text-on-surface-variant">Inference Latency Limit:</span>
                                                                <span class="font-code-inline font-bold text-primary">&lt; 14ms (p99)</span>
                                                            </li>
                                                            <li class="flex items-center justify-between">
                                                                <span class="text-on-surface-variant">Data Drift Index (PSI):</span>
                                                                <span class="font-code-inline font-bold text-error">0.241 (ELEVATED)</span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <!-- Box 2: Visual Mini Metric Sparkline Chart -->
                                                    <div class="p-space-md rounded bg-surface-container-low flex flex-col justify-between">
                                                        <div class="flex items-center justify-between">
                                                            <span class="font-label-sm text-label-sm uppercase font-semibold tracking-wider text-primary">Live Loss / Validation Curve</span>
                                                            <span class="font-code-inline text-label-sm text-on-tertiary-container">LOG-LOSS: 0.184</span>
                                                        </div>
                                                        <!-- Inline Chart Graphic -->
                                                        <div class="h-20 w-full flex items-end">
                                                            <svg class="w-full h-full overflow-visible" preserveaspectratio="none" viewbox="0 0 240 60">
                                                                <path class="text-primary" d="M 0,55 Q 30,50 60,35 T 120,24 T 180,18 T 240,12" fill="none" stroke="currentColor" stroke-width="2.5"></path>
                                                                <path class="text-tertiary-fixed-dim" d="M 0,58 Q 30,54 60,42 T 120,31 T 180,26 T 240,20" fill="none" stroke="currentColor" stroke-dasharray="3 3" stroke-width="1.5"></path>
                                                                <!-- Milestone Dots -->
                                                                <circle class="fill-primary" cx="120" cy="24" r="3.5"></circle>
                                                                <circle class="fill-primary" cx="240" cy="12" r="4.5"></circle>
                                                            </svg>
                                                        </div>
                                                        <div class="flex items-center justify-between font-code-inline text-label-sm text-on-surface-variant">
                                                            <span>EPOCH 01</span>
                                                            <span>CHECKPOINT 44 (BEST)</span>
                                                            <span>EPOCH 50</span>
                                                        </div>
                                                    </div>
                                                    <!-- Box 3: Quick Action & Dispatch -->
                                                    <div class="p-space-md rounded bg-surface-container-low flex flex-col justify-between">
                                                        <span class="font-label-sm text-label-sm uppercase font-semibold tracking-wider text-primary">Simulation Actions</span>
                                                        <p class="font-body-sm text-body-sm text-on-surface-variant">
                                                            Dataset partitioned from synthetic telco range. Artifact candidate locked in range store.
                                                        </p>
                                                        <div class="flex flex-col gap-space-xs mt-2">
                                                            <button class="w-full py-1.5 px-space-md rounded bg-primary text-on-primary font-label-md text-label-md font-semibold hover:bg-secondary transition-all">
                                                                Submit Checkpoint for Verification
                                                            </button>
                                                            <button class="w-full py-1 px-space-md rounded bg-surface-container text-primary font-label-md text-label-md font-semibold hover:bg-surface-container-high transition-all">
                                                                Regenerate Test Data Slice (Seed: 4892)
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Row 2: AI-029 (CV Defect) -->
                                    <tr class="hover:bg-surface-container-low transition-colors group cursor-pointer ticket-row" data-dept="QA &amp; Manufacturing" data-id="AI-029" data-priority="Critical" data-scenario="CV Defect" data-status="In Progress" data-urgent="true">
                                        <td class="py-space-md px-space-md font-code-inline text-label-md">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded bg-primary text-on-primary font-bold shadow-sm">AI-029</span>
                                        </td>
                                        <td class="py-space-md px-space-md">
                                            <div class="flex flex-col min-w-0">
                                                <div class="flex items-center gap-space-xs">
                                                    <span class="font-headline-md text-[14px] text-primary font-semibold truncate">Defect Optical Inspection — Micro-crack Detection</span>
                                                </div>
                                                <span class="font-body-sm text-body-sm text-on-surface-variant truncate">Fine-tune YOLOv8-Nano for PCB solder bridge and hairline fracture segmentation on avionics boards.</span>
                                            </div>
                                        </td>
                                        <td class="py-space-md px-space-md hidden md:table-cell">
                                            <div class="flex flex-col font-label-sm text-label-sm">
                                                <span class="font-semibold text-on-surface">QA &amp; Manufacturing</span>
                                                <span class="text-on-surface-variant font-code-inline">Hans Weber</span>
                                            </div>
                                        </td>
                                        <td class="py-space-md px-space-md hidden lg:table-cell">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded bg-secondary-container text-on-secondary-container font-label-sm text-label-sm font-semibold">
                                                CV Defect
                                            </span>
                                        </td>
                                        <td class="py-space-md px-space-md">
                                            <div class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded bg-surface-container-high font-label-sm text-label-sm font-bold text-primary">
                                                <span class="w-2 h-2 rounded-full bg-error animate-pulse"></span>
                                                <span>CRITICAL</span>
                                            </div>
                                        </td>
                                        <td class="py-space-md px-space-md hidden sm:table-cell font-code-inline text-label-sm">
                                            <div class="flex items-center gap-1 text-error font-semibold">
                                                <span class="material-symbols-outlined text-[14px]">alarm</span>
                                                <span>32h left</span>
                                            </div>
                                        </td>
                                        <td class="py-space-md px-space-md">
                                            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded bg-primary-fixed text-on-primary-fixed font-label-sm text-label-sm font-semibold">
                                                <span class="w-1.5 h-1.5 rounded-full bg-primary animate-ping"></span>
                                                <span>In Progress</span>
                                            </span>
                                        </td>
                                        <td class="py-space-md px-space-md hidden xl:table-cell">
                                            <div class="flex flex-col gap-1">
                                                <div class="flex items-center justify-between font-code-inline text-label-sm">
                                                    <span class="text-on-surface-variant">Training</span>
                                                    <span class="font-semibold text-primary">61%</span>
                                                </div>
                                                <div class="w-full bg-surface-container h-1.5 rounded-full overflow-hidden">
                                                    <div class="bg-primary h-full rounded-full" style="width: 61%"></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-space-md px-space-md text-right">
                                            <button class="px-space-md py-1 rounded bg-primary text-on-primary hover:bg-secondary transition-all font-label-sm text-label-sm font-semibold shadow-sm inline-flex items-center gap-0.5" onclick="toggleDetails('AI-029')">
                                                <span>Inspect</span>
                                                <span class="material-symbols-outlined text-[14px]">open_in_new</span>
                                            </button>
                                        </td>
                                    </tr>
                                    <!-- Hidden Drawer for AI-029 -->
                                    <tr class="hidden bg-surface-container-low transition-all" id="drawer-AI-029">
                                        <td class="p-space-lg" colspan="9">
                                            <div class="rounded bg-surface-container-lowest p-space-lg shadow-sm flex flex-col gap-space-md">
                                                <div class="flex items-center justify-between">
                                                    <div class="flex items-center gap-space-sm">
                                                        <span class="font-headline-md text-headline-md text-primary font-bold">AI-029: Optical Computer Vision Manifest</span>
                                                        <span class="px-2 py-0.5 rounded bg-secondary-container text-on-secondary-container font-code-inline text-label-sm">YOLOv8-SEG</span>
                                                    </div>
                                                    <button class="p-1 rounded text-outline hover:text-primary" onclick="toggleDetails('AI-029')">
                                                        <span class="material-symbols-outlined text-[18px]">close</span>
                                                    </button>
                                                </div>
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-space-md">
                                                    <div class="p-space-md rounded bg-surface-container-low font-body-sm text-body-sm">
                                                        <span class="font-label-sm text-label-sm font-semibold text-primary uppercase">Sensor Calibration &amp; Camera Feed</span>
                                                        <p class="mt-1 text-on-surface-variant">Optical range unit VK-OPT-4. Resolution: 2048x2048 @ 120 FPS. Target mAP@50 required &gt; 0.94.</p>
                                                    </div>
                                                    <div class="p-space-md rounded bg-surface-container-low font-body-sm text-body-sm">
                                                        <span class="font-label-sm text-label-sm font-semibold text-primary uppercase">Quick Actions</span>
                                                        <div class="flex items-center gap-space-sm mt-2">
                                                            <button class="px-space-md py-1.5 rounded bg-primary text-on-primary font-label-md text-label-md font-semibold">Open Annotation Canvas</button>
                                                            <button class="px-space-md py-1.5 rounded bg-surface-container text-primary font-label-md text-label-md font-semibold">Inspect Drift</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Row 3: AI-031 (Fraud Detection) -->
                                    <tr class="hover:bg-surface-container-low transition-colors group cursor-pointer ticket-row" data-dept="Financial Risk" data-id="AI-031" data-priority="High" data-scenario="Fraud Detection" data-status="Changes Requested" data-urgent="true">
                                        <td class="py-space-md px-space-md font-code-inline text-label-md">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded bg-primary text-on-primary font-bold shadow-sm">AI-031</span>
                                        </td>
                                        <td class="py-space-md px-space-md">
                                            <div class="flex flex-col min-w-0">
                                                <div class="flex items-center gap-space-xs">
                                                    <span class="font-headline-md text-[14px] text-primary font-semibold truncate">Real-Time Transaction Fraud Scorer</span>
                                                </div>
                                                <span class="font-body-sm text-body-sm text-on-surface-variant truncate">High-concurrency streaming inference. Reject false positives on cross-border clearing channels.</span>
                                            </div>
                                        </td>
                                        <td class="py-space-md px-space-md hidden md:table-cell">
                                            <div class="flex flex-col font-label-sm text-label-sm">
                                                <span class="font-semibold text-on-surface">Financial Risk</span>
                                                <span class="text-on-surface-variant font-code-inline">Marcus Thorne</span>
                                            </div>
                                        </td>
                                        <td class="py-space-md px-space-md hidden lg:table-cell">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded bg-secondary-container text-on-secondary-container font-label-sm text-label-sm font-semibold">
                                                Fraud Detection
                                            </span>
                                        </td>
                                        <td class="py-space-md px-space-md">
                                            <div class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded bg-surface-container-high font-label-sm text-label-sm font-bold text-primary">
                                                <span class="w-2 h-2 rounded-full bg-secondary"></span>
                                                <span>HIGH</span>
                                            </div>
                                        </td>
                                        <td class="py-space-md px-space-md hidden sm:table-cell font-code-inline text-label-sm">
                                            <div class="flex items-center gap-1 text-on-surface font-semibold">
                                                <span class="material-symbols-outlined text-[14px]">schedule</span>
                                                <span>46h left</span>
                                            </div>
                                        </td>
                                        <td class="py-space-md px-space-md">
                                            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded bg-tertiary-fixed text-on-tertiary-fixed font-label-sm text-label-sm font-semibold">
                                                <span class="w-1.5 h-1.5 rounded-full bg-tertiary"></span>
                                                <span>Changes Requested</span>
                                            </span>
                                        </td>
                                        <td class="py-space-md px-space-md hidden xl:table-cell">
                                            <div class="flex flex-col gap-1">
                                                <div class="flex items-center justify-between font-code-inline text-label-sm">
                                                    <span class="text-tertiary font-semibold">Revision 2</span>
                                                    <span class="font-semibold text-primary">40%</span>
                                                </div>
                                                <div class="w-full bg-surface-container h-1.5 rounded-full overflow-hidden">
                                                    <div class="bg-tertiary h-full rounded-full" style="width: 40%"></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-space-md px-space-md text-right">
                                            <button class="px-space-md py-1 rounded bg-primary text-on-primary hover:bg-secondary transition-all font-label-sm text-label-sm font-semibold shadow-sm inline-flex items-center gap-0.5" onclick="toggleDetails('AI-031')">
                                                <span>Inspect</span>
                                                <span class="material-symbols-outlined text-[14px]">open_in_new</span>
                                            </button>
                                        </td>
                                    </tr>
                                    <!-- Hidden Drawer for AI-031 -->
                                    <tr class="hidden bg-surface-container-low transition-all" id="drawer-AI-031">
                                        <td class="p-space-lg" colspan="9">
                                            <div class="rounded bg-surface-container-lowest p-space-lg shadow-sm flex flex-col gap-space-md">
                                                <div class="flex items-center justify-between">
                                                    <div class="flex items-center gap-space-sm">
                                                        <span class="font-headline-md text-headline-md text-error font-bold">Feedback from Lead Auditor (Marcus Thorne)</span>
                                                        <span class="px-2 py-0.5 rounded bg-tertiary-fixed text-on-tertiary-fixed font-code-inline text-label-sm">REV-REQ-03</span>
                                                    </div>
                                                    <button class="p-1 rounded text-outline hover:text-primary" onclick="toggleDetails('AI-031')">
                                                        <span class="material-symbols-outlined text-[18px]">close</span>
                                                    </button>
                                                </div>
                                                <div class="p-space-md rounded bg-surface-container-low font-body-sm text-body-sm border-l-4 border-l-tertiary">
                                                    <p class="font-semibold text-on-surface">"Recall rate on high-value transfers (&gt;$25k) dropped below 0.96. Please tune class weights in LightGBM and resubmit benchmark telemetry logs."</p>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Row 4: AI-018 (NLP Complaint) -->
                                    <tr class="hover:bg-surface-container-low transition-colors group cursor-pointer ticket-row" data-dept="HR Tech" data-id="AI-018" data-priority="Medium" data-scenario="NLP Complaint" data-status="Submitted" data-urgent="false">
                                        <td class="py-space-md px-space-md font-code-inline text-label-md">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded bg-primary text-on-primary font-bold shadow-sm">AI-018</span>
                                        </td>
                                        <td class="py-space-md px-space-md">
                                            <div class="flex flex-col min-w-0">
                                                <div class="flex items-center gap-space-xs">
                                                    <span class="font-headline-md text-[14px] text-primary font-semibold truncate">Workforce Escalation Sentiment Router</span>
                                                </div>
                                                <span class="font-body-sm text-body-sm text-on-surface-variant truncate">Multilingual DeBERTa classifier for toxic dispatch flagging and emergency routing.</span>
                                            </div>
                                        </td>
                                        <td class="py-space-md px-space-md hidden md:table-cell">
                                            <div class="flex flex-col font-label-sm text-label-sm">
                                                <span class="font-semibold text-on-surface">HR Tech</span>
                                                <span class="text-on-surface-variant font-code-inline">Sofia Al-Mansoor</span>
                                            </div>
                                        </td>
                                        <td class="py-space-md px-space-md hidden lg:table-cell">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded bg-secondary-container text-on-secondary-container font-label-sm text-label-sm font-semibold">
                                                NLP Complaint
                                            </span>
                                        </td>
                                        <td class="py-space-md px-space-md">
                                            <div class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded bg-surface-container-high font-label-sm text-label-sm font-semibold text-on-surface">
                                                <span class="w-2 h-2 rounded-full bg-outline"></span>
                                                <span>MEDIUM</span>
                                            </div>
                                        </td>
                                        <td class="py-space-md px-space-md hidden sm:table-cell font-code-inline text-label-sm">
                                            <div class="flex items-center gap-1 text-on-surface-variant">
                                                <span class="material-symbols-outlined text-[14px]">calendar_today</span>
                                                <span>3d left</span>
                                            </div>
                                        </td>
                                        <td class="py-space-md px-space-md">
                                            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded bg-surface-container-high text-primary font-label-sm text-label-sm font-semibold">
                                                <span class="w-1.5 h-1.5 rounded-full bg-primary"></span>
                                                <span>Submitted</span>
                                            </span>
                                        </td>
                                        <td class="py-space-md px-space-md hidden xl:table-cell">
                                            <div class="flex flex-col gap-1">
                                                <div class="flex items-center justify-between font-code-inline text-label-sm">
                                                    <span class="text-primary font-semibold">Lead Review</span>
                                                    <span class="font-semibold text-primary">90%</span>
                                                </div>
                                                <div class="w-full bg-surface-container h-1.5 rounded-full overflow-hidden">
                                                    <div class="bg-primary h-full rounded-full" style="width: 90%"></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-space-md px-space-md text-right">
                                            <button class="px-space-md py-1 rounded bg-primary text-on-primary hover:bg-secondary transition-all font-label-sm text-label-sm font-semibold shadow-sm inline-flex items-center gap-0.5" onclick="toggleDetails('AI-018')">
                                                <span>Inspect</span>
                                                <span class="material-symbols-outlined text-[14px]">open_in_new</span>
                                            </button>
                                        </td>
                                    </tr>
                                    <!-- Hidden Drawer for AI-018 -->
                                    <tr class="hidden bg-surface-container-low transition-all" id="drawer-AI-018">
                                        <td class="p-space-lg" colspan="9">
                                            <div class="rounded bg-surface-container-lowest p-space-lg shadow-sm flex flex-col gap-space-md">
                                                <div class="flex items-center justify-between">
                                                    <span class="font-headline-md text-headline-md text-primary font-bold">AI-018: Verification Queue (Awaiting Sign-off)</span>
                                                    <button class="p-1 rounded text-outline hover:text-primary" onclick="toggleDetails('AI-018')">
                                                        <span class="material-symbols-outlined text-[18px]">close</span>
                                                    </button>
                                                </div>
                                                <p class="font-body-sm text-body-sm text-on-surface-variant">Submitted on 2024-11-04 14:12 UTC. Evaluation pipeline status: ALL 18 TEST CASINGS PASSED.</p>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Row 5: AI-042 (GenAI RAG) -->
                                    <tr class="hover:bg-surface-container-low transition-colors group cursor-pointer ticket-row" data-dept="Security SOC" data-id="AI-042" data-priority="High" data-scenario="GenAI RAG" data-status="In Progress" data-urgent="false">
                                        <td class="py-space-md px-space-md font-code-inline text-label-md">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded bg-primary text-on-primary font-bold shadow-sm">AI-042</span>
                                        </td>
                                        <td class="py-space-md px-space-md">
                                            <div class="flex flex-col min-w-0">
                                                <div class="flex items-center gap-space-xs">
                                                    <span class="font-headline-md text-[14px] text-primary font-semibold truncate">SOC Playbook Retrieval Augmented Generation</span>
                                                </div>
                                                <span class="font-body-sm text-body-sm text-on-surface-variant truncate">Vector DB Qdrant hybrid search + re-ranker. Guardrails against hallucinations on CVE mitigation procedures.</span>
                                            </div>
                                        </td>
                                        <td class="py-space-md px-space-md hidden md:table-cell">
                                            <div class="flex flex-col font-label-sm text-label-sm">
                                                <span class="font-semibold text-on-surface">Security SOC</span>
                                                <span class="text-on-surface-variant font-code-inline">Col. V. Danilov</span>
                                            </div>
                                        </td>
                                        <td class="py-space-md px-space-md hidden lg:table-cell">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded bg-secondary-container text-on-secondary-container font-label-sm text-label-sm font-semibold">
                                                GenAI RAG
                                            </span>
                                        </td>
                                        <td class="py-space-md px-space-md">
                                            <div class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded bg-surface-container-high font-label-sm text-label-sm font-bold text-primary">
                                                <span class="w-2 h-2 rounded-full bg-secondary"></span>
                                                <span>HIGH</span>
                                            </div>
                                        </td>
                                        <td class="py-space-md px-space-md hidden sm:table-cell font-code-inline text-label-sm">
                                            <div class="flex items-center gap-1 text-on-surface-variant">
                                                <span class="material-symbols-outlined text-[14px]">calendar_today</span>
                                                <span>4d left</span>
                                            </div>
                                        </td>
                                        <td class="py-space-md px-space-md">
                                            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded bg-primary-fixed text-on-primary-fixed font-label-sm text-label-sm font-semibold">
                                                <span class="w-1.5 h-1.5 rounded-full bg-primary animate-ping"></span>
                                                <span>In Progress</span>
                                            </span>
                                        </td>
                                        <td class="py-space-md px-space-md hidden xl:table-cell">
                                            <div class="flex flex-col gap-1">
                                                <div class="flex items-center justify-between font-code-inline text-label-sm">
                                                    <span class="text-on-surface-variant">Chunk Embed</span>
                                                    <span class="font-semibold text-primary">52%</span>
                                                </div>
                                                <div class="w-full bg-surface-container h-1.5 rounded-full overflow-hidden">
                                                    <div class="bg-primary h-full rounded-full" style="width: 52%"></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-space-md px-space-md text-right">
                                            <button class="px-space-md py-1 rounded bg-primary text-on-primary hover:bg-secondary transition-all font-label-sm text-label-sm font-semibold shadow-sm inline-flex items-center gap-0.5" onclick="toggleDetails('AI-042')">
                                                <span>Inspect</span>
                                                <span class="material-symbols-outlined text-[14px]">open_in_new</span>
                                            </button>
                                        </td>
                                    </tr>
                                    <!-- Hidden Drawer for AI-042 -->
                                    <tr class="hidden bg-surface-container-low transition-all" id="drawer-AI-042">
                                        <td class="p-space-lg" colspan="9">
                                            <div class="rounded bg-surface-container-lowest p-space-lg shadow-sm flex flex-col gap-space-md">
                                                <div class="flex items-center justify-between">
                                                    <span class="font-headline-md text-headline-md text-primary font-bold">AI-042: Vector Store Topologies &amp; Semantic Indices</span>
                                                    <button class="p-1 rounded text-outline hover:text-primary" onclick="toggleDetails('AI-042')">
                                                        <span class="material-symbols-outlined text-[18px]">close</span>
                                                    </button>
                                                </div>
                                                <p class="font-body-sm text-body-sm text-on-surface-variant">Qdrant cluster node: QDR-01. Collection: "nist-cve-playbooks-v2". Current hit rate: 87.4% @ K=5.</p>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Row 6: AI-055 (AI Agent) -->
                                    <tr class="hover:bg-surface-container-low transition-colors group cursor-pointer ticket-row" data-dept="Retention Ops" data-id="AI-055" data-priority="Medium" data-scenario="AI Agent" data-status="New" data-urgent="false">
                                        <td class="py-space-md px-space-md font-code-inline text-label-md">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded bg-primary text-on-primary font-bold shadow-sm">AI-055</span>
                                        </td>
                                        <td class="py-space-md px-space-md">
                                            <div class="flex flex-col min-w-0">
                                                <div class="flex items-center gap-space-xs">
                                                    <span class="font-headline-md text-[14px] text-primary font-semibold truncate">Autonomous Remediation Ticket Agent</span>
                                                </div>
                                                <span class="font-body-sm text-body-sm text-on-surface-variant truncate">Agentic loop with tool-use capability to execute database rollbacks on simulated telemetry corruptions.</span>
                                            </div>
                                        </td>
                                        <td class="py-space-md px-space-md hidden md:table-cell">
                                            <div class="flex flex-col font-label-sm text-label-sm">
                                                <span class="font-semibold text-on-surface">Retention Ops</span>
                                                <span class="text-on-surface-variant font-code-inline">Elena Rostova</span>
                                            </div>
                                        </td>
                                        <td class="py-space-md px-space-md hidden lg:table-cell">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded bg-secondary-container text-on-secondary-container font-label-sm text-label-sm font-semibold">
                                                AI Agent
                                            </span>
                                        </td>
                                        <td class="py-space-md px-space-md">
                                            <div class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded bg-surface-container-high font-label-sm text-label-sm font-semibold text-on-surface">
                                                <span class="w-2 h-2 rounded-full bg-outline"></span>
                                                <span>MEDIUM</span>
                                            </div>
                                        </td>
                                        <td class="py-space-md px-space-md hidden sm:table-cell font-code-inline text-label-sm">
                                            <div class="flex items-center gap-1 text-on-surface-variant">
                                                <span class="material-symbols-outlined text-[14px]">calendar_today</span>
                                                <span>6d left</span>
                                            </div>
                                        </td>
                                        <td class="py-space-md px-space-md">
                                            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded bg-surface-container text-secondary font-label-sm text-label-sm font-semibold">
                                                <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
                                                <span>New</span>
                                            </span>
                                        </td>
                                        <td class="py-space-md px-space-md hidden xl:table-cell">
                                            <div class="flex flex-col gap-1">
                                                <div class="flex items-center justify-between font-code-inline text-label-sm">
                                                    <span class="text-on-surface-variant">Not Started</span>
                                                    <span class="font-semibold text-on-surface-variant">0%</span>
                                                </div>
                                                <div class="w-full bg-surface-container h-1.5 rounded-full overflow-hidden">
                                                    <div class="bg-primary h-full rounded-full" style="width: 0%"></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-space-md px-space-md text-right">
                                            <button class="px-space-md py-1 rounded bg-primary text-on-primary hover:bg-secondary transition-all font-label-sm text-label-sm font-semibold shadow-sm inline-flex items-center gap-0.5" onclick="toggleDetails('AI-055')">
                                                <span>Inspect</span>
                                                <span class="material-symbols-outlined text-[14px]">open_in_new</span>
                                            </button>
                                        </td>
                                    </tr>
                                    <!-- Hidden Drawer for AI-055 -->
                                    <tr class="hidden bg-surface-container-low transition-all" id="drawer-AI-055">
                                        <td class="p-space-lg" colspan="9">
                                            <div class="rounded bg-surface-container-lowest p-space-lg shadow-sm flex flex-col gap-space-md">
                                                <div class="flex items-center justify-between">
                                                    <span class="font-headline-md text-headline-md text-primary font-bold">AI-055: Tool Execution Sandboxing</span>
                                                    <button class="p-1 rounded text-outline hover:text-primary" onclick="toggleDetails('AI-055')">
                                                        <span class="material-symbols-outlined text-[18px]">close</span>
                                                    </button>
                                                </div>
                                                <p class="font-body-sm text-body-sm text-on-surface-variant">Unassigned sandbox ready. LangChain/ReAct agent topology blueprint provided in SYS-AI-03 template.</p>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Row 7: AI-061 (AI SOC Failure) -->
                                    <tr class="hover:bg-surface-container-low transition-colors group cursor-pointer ticket-row" data-dept="Security SOC" data-id="AI-061" data-priority="Low" data-scenario="AI SOC Failure" data-status="Approved" data-urgent="false">
                                        <td class="py-space-md px-space-md font-code-inline text-label-md">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded bg-primary text-on-primary font-bold shadow-sm">AI-061</span>
                                        </td>
                                        <td class="py-space-md px-space-md">
                                            <div class="flex flex-col min-w-0">
                                                <div class="flex items-center gap-space-xs">
                                                    <span class="font-headline-md text-[14px] text-primary font-semibold truncate">Model Inversion &amp; Adversarial Probe Detector</span>
                                                </div>
                                                <span class="font-body-sm text-body-sm text-on-surface-variant truncate">Defense layer for black-box API query extraction attacks. Threshold verification complete.</span>
                                            </div>
                                        </td>
                                        <td class="py-space-md px-space-md hidden md:table-cell">
                                            <div class="flex flex-col font-label-sm text-label-sm">
                                                <span class="font-semibold text-on-surface">Security SOC</span>
                                                <span class="text-on-surface-variant font-code-inline">Col. V. Danilov</span>
                                            </div>
                                        </td>
                                        <td class="py-space-md px-space-md hidden lg:table-cell">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded bg-secondary-container text-on-secondary-container font-label-sm text-label-sm font-semibold">
                                                AI SOC Failure
                                            </span>
                                        </td>
                                        <td class="py-space-md px-space-md">
                                            <div class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded bg-surface-container-high font-label-sm text-label-sm font-semibold text-on-surface-variant">
                                                <span class="w-2 h-2 rounded-full bg-outline-variant"></span>
                                                <span>LOW</span>
                                            </div>
                                        </td>
                                        <td class="py-space-md px-space-md hidden sm:table-cell font-code-inline text-label-sm">
                                            <div class="flex items-center gap-1 text-on-surface-variant">
                                                <span class="material-symbols-outlined text-[14px]">check_circle</span>
                                                <span>Archived</span>
                                            </div>
                                        </td>
                                        <td class="py-space-md px-space-md">
                                            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded bg-tertiary-fixed text-on-tertiary-fixed font-label-sm text-label-sm font-semibold">
                                                <span class="w-1.5 h-1.5 rounded-full bg-tertiary"></span>
                                                <span>Approved</span>
                                            </span>
                                        </td>
                                        <td class="py-space-md px-space-md hidden xl:table-cell">
                                            <div class="flex flex-col gap-1">
                                                <div class="flex items-center justify-between font-code-inline text-label-sm">
                                                    <span class="text-on-surface font-semibold">Certified</span>
                                                    <span class="font-semibold text-primary">100%</span>
                                                </div>
                                                <div class="w-full bg-surface-container h-1.5 rounded-full overflow-hidden">
                                                    <div class="bg-primary h-full rounded-full" style="width: 100%"></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-space-md px-space-md text-right">
                                            <button class="px-space-md py-1 rounded bg-primary text-on-primary hover:bg-secondary transition-all font-label-sm text-label-sm font-semibold shadow-sm inline-flex items-center gap-0.5" onclick="toggleDetails('AI-061')">
                                                <span>Inspect</span>
                                                <span class="material-symbols-outlined text-[14px]">open_in_new</span>
                                            </button>
                                        </td>
                                    </tr>
                                    <!-- Hidden Drawer for AI-061 -->
                                    <tr class="hidden bg-surface-container-low transition-all" id="drawer-AI-061">
                                        <td class="p-space-lg" colspan="9">
                                            <div class="rounded bg-surface-container-lowest p-space-lg shadow-sm flex flex-col gap-space-md">
                                                <div class="flex items-center justify-between">
                                                    <span class="font-headline-md text-headline-md text-primary font-bold">AI-061: Audit Complete &amp; Locked</span>
                                                    <button class="p-1 rounded text-outline hover:text-primary" onclick="toggleDetails('AI-061')">
                                                        <span class="material-symbols-outlined text-[18px]">close</span>
                                                    </button>
                                                </div>
                                                <p class="font-body-sm text-body-sm text-on-surface-variant">Validated against FGSM &amp; PGD adversarial noise injection. Passed on 2024-11-01 with grade 98/100.</p>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- Table Footer with SLA Pagination -->
                        <div class="p-space-md bg-surface-container-low flex flex-wrap items-center justify-between gap-space-md">
                            <div class="flex items-center gap-space-sm font-code-inline text-label-sm text-on-surface-variant">
                                <span class="font-semibold text-primary">Showing 1-7 of 7 active tickets</span>
                                <span>•</span>
                                <span>2 completed archived in Range Storage</span>
                                <span>•</span>
                                <span class="text-on-tertiary-container font-semibold">TELEMETRY HASH: 88F9-24B-01</span>
                            </div>
                            <div class="flex items-center gap-space-xs">
                                <button class="px-2 py-1 rounded bg-surface-container-lowest text-outline hover:text-on-surface font-label-sm text-label-sm font-semibold transition-colors disabled:opacity-50" disabled="">
                                    &lt; Prev Page
                                </button>
                                <span class="px-2 py-1 rounded bg-primary text-on-primary font-code-inline text-label-sm font-bold">1</span>
                                <button class="px-2 py-1 rounded bg-surface-container-lowest text-outline hover:text-on-surface font-label-sm text-label-sm font-semibold transition-colors disabled:opacity-50" disabled="">
                                    Next Page &gt;
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Supplementary Industrial Flight-Deck Widgets -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-space-lg">
                        <!-- Card 1: Subsystem Quick Jump -->
                        <div class="rounded bg-surface-container-lowest p-space-lg shadow-sm flex flex-col justify-between gap-space-md">
                            <div class="flex flex-col gap-space-xs">
                                <div class="flex items-center justify-between">
                                    <span class="font-label-sm text-label-sm uppercase tracking-wider font-semibold text-primary">Connected Operations</span>
                                    <span class="font-code-inline text-label-sm text-on-tertiary-container">ACTIVE PIPELINES</span>
                                </div>
                                <h3 class="font-headline-md text-headline-md text-primary font-semibold">Telemetry Range Core Subsystems</h3>
                                <p class="font-body-sm text-body-sm text-on-surface-variant">
                                    Quickly transition between dataset curation, interactive notebooks, and model registry endpoints for active tickets.
                                </p>
                            </div>
                            <div class="grid grid-cols-2 gap-space-sm">
                                <a class="p-space-sm rounded bg-surface-container-low hover:bg-surface-container transition-colors flex items-center gap-space-sm group" href="#">
                                    <div class="p-2 rounded bg-surface-container-lowest text-primary group-hover:bg-primary group-hover:text-on-primary transition-colors">
                                        <span class="material-symbols-outlined text-[18px]">database</span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-label-md text-label-md font-semibold text-primary">SYS-AI-02</span>
                                        <span class="font-label-sm text-label-sm text-on-surface-variant">Data Portal</span>
                                    </div>
                                </a>
                                <a class="p-space-sm rounded bg-surface-container-low hover:bg-surface-container transition-colors flex items-center gap-space-sm group" href="#">
                                    <div class="p-2 rounded bg-surface-container-lowest text-primary group-hover:bg-primary group-hover:text-on-primary transition-colors">
                                        <span class="material-symbols-outlined text-[18px]">terminal</span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-label-md text-label-md font-semibold text-primary">SYS-AI-03</span>
                                        <span class="font-label-sm text-label-sm text-on-surface-variant">Notebook Hub</span>
                                    </div>
                                </a>
                                <a class="p-space-sm rounded bg-surface-container-low hover:bg-surface-container transition-colors flex items-center gap-space-sm group" href="#">
                                    <div class="p-2 rounded bg-surface-container-lowest text-primary group-hover:bg-primary group-hover:text-on-primary transition-colors">
                                        <span class="material-symbols-outlined text-[18px]">hub</span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-label-md text-label-md font-semibold text-primary">SYS-AI-04</span>
                                        <span class="font-label-sm text-label-sm text-on-surface-variant">Model Registry</span>
                                    </div>
                                </a>
                                <a class="p-space-sm rounded bg-surface-container-low hover:bg-surface-container transition-colors flex items-center gap-space-sm group" href="#">
                                    <div class="p-2 rounded bg-surface-container-lowest text-primary group-hover:bg-primary group-hover:text-on-primary transition-colors">
                                        <span class="material-symbols-outlined text-[18px]">query_stats</span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-label-md text-label-md font-semibold text-primary">SYS-AI-05</span>
                                        <span class="font-label-sm text-label-sm text-on-surface-variant">Ops Telemetry</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <!-- Card 2: Student Scenario Progression Gauge -->
                        <div class="rounded bg-surface-container-lowest p-space-lg shadow-sm flex flex-col justify-between gap-space-md">
                            <div class="flex flex-col gap-space-xs">
                                <div class="flex items-center justify-between">
                                    <span class="font-label-sm text-label-sm uppercase tracking-wider font-semibold text-primary">Student SLA Benchmark</span>
                                    <span class="px-2 py-0.5 rounded bg-tertiary-fixed font-code-inline text-label-sm text-on-tertiary-fixed font-bold">COHORT 24-B</span>
                                </div>
                                <h3 class="font-headline-md text-headline-md text-primary font-semibold">Curriculum Scenario Coverage</h3>
                                <p class="font-body-sm text-body-sm text-on-surface-variant">
                                    5 of 7 fundamental blueprint templates assigned in this engineering sprint.
                                </p>
                            </div>
                            <div class="flex flex-col gap-space-sm">
                                <div class="flex items-center justify-between font-label-sm text-label-sm">
                                    <span class="text-on-surface font-semibold">Blueprint Completion Velocity</span>
                                    <span class="font-code-inline font-bold text-primary">71.4% (5/7 Locked)</span>
                                </div>
                                <div class="w-full bg-surface-container h-2 rounded-full overflow-hidden flex">
                                    <div class="bg-primary h-full" style="width: 42.8%"></div>
                                    <div class="bg-secondary h-full" style="width: 28.6%"></div>
                                    <div class="bg-tertiary h-full" style="width: 14.3%"></div>
                                </div>
                                <div class="flex items-center justify-between font-label-sm text-label-sm text-on-surface-variant pt-1">
                                    <span class="flex items-center gap-1"><span class="w-2 h-2 rounded bg-primary"></span> Completed</span>
                                    <span class="flex items-center gap-1"><span class="w-2 h-2 rounded bg-secondary"></span> Active Run</span>
                                    <span class="flex items-center gap-1"><span class="w-2 h-2 rounded bg-tertiary"></span> Pending</span>
                                </div>
                            </div>
                            <div class="p-space-sm rounded bg-surface-container-low font-code-inline text-label-sm text-on-surface-variant flex items-center justify-between">
                                <span>NEXT GATE: CHURN DRIFT V4 EVAL</span>
                                <span class="text-primary font-bold">TOMORROW 08:00 UTC</span>
                            </div>
                        </div>
                        <!-- Card 3: Enterprise Simulation Auditor Note -->
                        <div class="rounded bg-surface-container-lowest p-space-lg shadow-sm flex flex-col justify-between gap-space-md">
                            <div class="flex flex-col gap-space-xs">
                                <div class="flex items-center justify-between">
                                    <span class="font-label-sm text-label-sm uppercase tracking-wider font-semibold text-primary">Auditor Dispatch</span>
                                    <span class="material-symbols-outlined text-[18px] text-tertiary">verified_user</span>
                                </div>
                                <h3 class="font-headline-md text-headline-md text-primary font-semibold">Simulated Regulatory Guardrails</h3>
                                <p class="font-body-sm text-body-sm text-on-surface-variant">
                                    All submitted models are scored through synthetic automated adversarial stress-testing prior to final instructor grade sign-off.
                                </p>
                            </div>
                            <div class="flex flex-col gap-space-xs p-space-sm rounded bg-surface-container-low font-body-sm text-body-sm text-on-surface">
                                <div class="flex items-center gap-space-xs text-primary font-semibold font-label-sm text-label-sm">
                                    <span class="material-symbols-outlined text-[16px]">info</span>
                                    <span>CRITICAL ADVISORY // AI-024</span>
                                </div>
                                <p class="text-on-surface-variant text-body-sm">
                                    Data drift exceeds 0.2 PSI. Ensure you invoke robust feature normalization and log transformation before submission.
                                </p>
                            </div>
                            <button class="w-full py-2 rounded bg-surface-container hover:bg-surface-container-high text-primary font-label-md text-label-md font-semibold transition-colors flex items-center justify-center gap-space-xs">
                                <span class="material-symbols-outlined text-[16px]">menu_book</span>
                                <span>View Telemetry Range SOP Manual</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="js/main.js"></script>
</body>

</html>