<?php
require_once __DIR__ . '/../app/bootstrap.php';

use App\Middleware\AuthenticationMiddleware;
use App\Core\Database;

$currentUser = AuthenticationMiddleware::handle();
$isAdmin = strtoupper((string)($currentUser['role'] ?? '')) === 'ADMIN';
$db = Database::getInstance();

// If admin, fetch all tickets; if student, fetch assigned tickets
if ($isAdmin) {
    $tickets = $db->fetchAll("
        SELECT t.*, s.title AS scenario_title, s.difficulty, s.objectives, s.acceptance_criteria,
               u.full_name AS student_name, u.identifier AS student_identifier
        FROM tickets t
        LEFT JOIN scenarios s ON t.scenario_id = s.id
        LEFT JOIN ticket_assignments ta ON t.id = ta.ticket_id
        LEFT JOIN users u ON ta.student_id = u.id
        ORDER BY t.created_at DESC
    ");
} else {
    $tickets = $db->fetchAll("
        SELECT t.*, s.title AS scenario_title, s.difficulty, s.objectives, s.acceptance_criteria
        FROM tickets t
        LEFT JOIN scenarios s ON t.scenario_id = s.id
        INNER JOIN ticket_assignments ta ON t.id = ta.ticket_id
        WHERE ta.student_id = :student_id
        ORDER BY t.created_at DESC
    ", [':student_id' => $currentUser['id']]);
}

$totalAssigned = count($tickets);
$activeCount = count(array_filter($tickets, fn($t) => in_array($t['status'], ['ASSIGNED', 'IN_PROGRESS'])));
$submittedCount = count(array_filter($tickets, fn($t) => in_array($t['status'], ['SUBMITTED', 'UNDER_REVIEW'])));
$approvedCount = count(array_filter($tickets, fn($t) => $t['status'] === 'APPROVED'));
$revisionCount = count(array_filter($tickets, fn($t) => $t['status'] === 'CHANGES_REQUESTED'));
?>
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
    <script src="../assets/js/range-client.js"></script>
</head>

<body class="bg-surface font-body-md text-body-md text-on-surface antialiased bg-fiberglass">
    <aside class="fixed left-0 top-0 h-screen w-64 bg-surface-container-lowest z-50 flex flex-col justify-between shadow-[0_1px_8px_rgba(0,0,0,0.04)]">
        <div class="flex flex-col">
            <div class="h-16 px-space-lg flex items-center gap-space-sm bg-surface-container-low">
                <div class="flex items-center justify-center w-6 h-6 rounded bg-primary text-on-primary font-label-sm text-label-sm font-semibold">VK</div>
                <div class="flex flex-col"><span class="font-label-md text-label-md text-primary font-semibold tracking-wider uppercase">Telemetry Range</span><span class="font-label-sm text-label-sm text-on-surface-variant font-code-inline"><?= htmlspecialchars($currentUser['cohort'] ?? 'CADET-WING') ?></span></div>
            </div>
            <div class="px-space-md py-space-sm"><span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider font-semibold px-space-sm">Operations &amp; Tasks</span></div>
            <nav class="flex flex-col gap-space-xs px-space-md" data-active-classes="bg-primary text-on-primary font-semibold shadow-[0_1px_3px_rgba(76,29,149,0.12)]"><a class="flex items-center gap-space-md px-space-md py-space-sm rounded text-on-surface-variant font-body-md text-body-md hover:bg-surface-container-high hover:text-on-surface transition-colors" data-path="dashboard" href="Dashboard.php"><span class="material-symbols-outlined text-[18px]">space_dashboard</span><span>Dashboard</span></a><a aria-current="page" class="flex items-center gap-space-md px-space-md py-space-sm rounded transition-colors bg-primary text-on-primary font-semibold shadow-[0_1px_3px_rgba(76,29,149,0.12)]" data-path="my-tickets" href="Tickets.php"><span class="material-symbols-outlined text-[18px]">assignment</span><span>My Tickets</span></a><a class="flex items-center gap-space-md px-space-md py-space-sm rounded text-on-surface-variant font-body-md text-body-md hover:bg-surface-container-high hover:text-on-surface transition-colors" data-path="ticket-details" href="TicketDetails.php"><span class="material-symbols-outlined text-[18px]">description</span><span>Ticket Details</span></a><a class="flex items-center gap-space-md px-space-md py-space-sm rounded text-on-surface-variant font-body-md text-body-md hover:bg-surface-container-high hover:text-on-surface transition-colors" data-path="my-submissions" href="Submissions.php"><span class="material-symbols-outlined text-[18px]">inventory_2</span><span>My Submissions</span></a><a class="flex items-center justify-between px-space-md py-space-sm rounded text-on-surface-variant font-body-md text-body-md hover:bg-surface-container-high hover:text-on-surface transition-colors" data-path="notifications" href="Dashboard.php">
                    <div class="flex items-center gap-space-md"><span class="material-symbols-outlined text-[18px]">notifications</span><span>Notifications</span></div><span class="px-1.5 py-0.5 rounded font-label-sm text-label-sm bg-secondary-container text-on-secondary-container"><?= $activeCount ?></span>
                </a><a class="flex items-center gap-space-md px-space-md py-space-sm rounded text-on-surface-variant font-body-md text-body-md hover:bg-surface-container-high hover:text-on-surface transition-colors" data-path="student-profile" href="StudentProfile.php"><span class="material-symbols-outlined text-[18px]">badge</span><span>Student Profile</span></a></nav>
        </div>
        <div class="flex flex-col bg-surface-container-low p-space-md m-space-sm rounded gap-space-sm">
            <div class="flex items-center justify-between"><span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider font-semibold">Range Subsystems</span><span class="font-label-sm text-label-sm text-on-tertiary-container font-code-inline font-semibold">v4.18</span></div>
            <div class="grid grid-cols-2 gap-space-xs"><a class="flex items-center gap-space-xs p-1.5 rounded bg-surface-container-lowest text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface font-label-sm text-label-sm transition-colors" href="../Data Center/dashboard.php"><span class="material-symbols-outlined text-[14px] text-primary">database</span>SYS-02 Data</a><a class="flex items-center gap-space-xs p-1.5 rounded bg-surface-container-lowest text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface font-label-sm text-label-sm transition-colors" href="../ML Workbench/NotebookWorkbench.php"><span class="material-symbols-outlined text-[14px] text-primary">terminal</span>SYS-03 NB</a><a class="flex items-center gap-space-xs p-1.5 rounded bg-surface-container-lowest text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface font-label-sm text-label-sm transition-colors" href="../Model Registry & Deployment/dashboard.php"><span class="material-symbols-outlined text-[14px] text-primary">hub</span>SYS-04 Reg</a><a class="flex items-center gap-space-xs p-1.5 rounded bg-surface-container-lowest text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface font-label-sm text-label-sm transition-colors" href="../AI Operations Center (AI SOC)/TicketsAndScenarios.php"><span class="material-symbols-outlined text-[14px] text-primary">settings</span>SYS-05 Ops</a></div>
            <div class="pt-space-xs flex items-center justify-between text-on-surface-variant"><a class="flex items-center gap-space-xs font-label-sm text-label-sm text-on-surface-variant hover:text-primary transition-colors" href="../index.php"><span class="material-symbols-outlined text-[14px]">home</span><span>Flight Deck Home</span></a><span class="font-label-sm text-label-sm text-on-tertiary-container font-code-inline font-semibold">ONLINE</span></div>
        </div>
    </aside>
    <div class="pl-64">
        <header class="fixed top-0 left-64 right-0 z-40 bg-surface-container-lowest/90 backdrop-blur-md shadow-[0_1px_8px_rgba(0,0,0,0.04)]">
            <div class="h-16 w-full px-gutter-desktop flex items-center justify-between gap-space-md">
                <div class="flex items-center gap-space-lg">
                    <div class="flex items-center gap-space-sm"><img alt="VOSTOKPRIBOR Logo" class="h-8 w-auto object-contain" src="https://lh3.googleusercontent.com/aida/AEtjO1ULXUBEqKB3MtounXs991RVWsiqjz4ZU01Mz79VKjRhaENNCHdDB9DW4lH6_0tbZlIsxzHSnw1p4Ja_zHGmh65md2asH8x4qe6X4XXeeRHM11eD6HREhIyI5gwKKBHv1_UNfdbJ6jGtHaRLP4uaH3Yszfk5atKNiaIsoNQgrb4p4zVvTw3uuWefsO5X31ioW8lqe5kJgrk0pH1b0cG49htkVSXHmpf8PC4tRtbSG8gTehhPcrWeWf-R49U" /><span class="font-headline-md text-headline-md font-bold text-primary tracking-tight hidden lg:inline">VOSTOKPRIBOR</span></div>
                    <div class="flex items-center gap-space-xs px-space-md py-1.5 rounded bg-surface-container font-label-md text-label-md text-primary cursor-pointer hover:bg-surface-container-high transition-colors"><span class="material-symbols-outlined text-[16px] text-primary">tune</span><span class="font-semibold">SYS-AI-01: AI Project &amp; Ticket Mgmt</span><span class="material-symbols-outlined text-[16px]">arrow_drop_down</span></div>
                    <div class="hidden xl:flex items-center gap-space-xs px-space-sm py-1 rounded bg-tertiary-fixed font-label-sm text-label-sm text-on-tertiary-fixed font-code-inline"><span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span><span>Operational Range Manifest</span></div>
                </div>
                <div class="flex items-center gap-space-md">
                    <div class="hidden 2xl:flex items-center gap-space-sm px-space-sm py-1 rounded bg-surface-container-low font-label-sm text-label-sm text-on-surface-variant font-code-inline"><span class="text-primary font-semibold">TLM:</span><span class="text-on-tertiary-container font-bold">NOMINAL</span><span class="text-outline-variant">|</span><span class="text-primary font-semibold">NODE:</span><span class="text-on-surface">OK</span></div>
                    <div class="relative flex items-center justify-center p-2 rounded hover:bg-surface-container-high cursor-pointer text-on-surface-variant transition-colors"><span class="material-symbols-outlined text-[20px]">notifications</span><span class="absolute top-1.5 right-1.5 flex h-2 w-2"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-error opacity-75"></span><span class="relative inline-flex rounded-full h-2 w-2 bg-error"></span></span></div>
                    <div class="flex items-center gap-space-sm pl-space-sm">
                        <div class="flex flex-col text-right hidden sm:flex"><span class="font-label-md text-label-md font-semibold text-on-surface"><?= htmlspecialchars($currentUser['full_name']) ?></span><span class="font-label-sm text-label-sm text-on-surface-variant font-code-inline"><?= htmlspecialchars($currentUser['identifier']) ?></span></div>
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
<?php if (empty($tickets)): ?>
    <tr>
        <td colspan="9" class="py-12 px-6 text-center">
            <div class="flex flex-col items-center justify-center gap-3">
                <span class="material-symbols-outlined text-4xl text-primary opacity-60">assignment_late</span>
                <div class="flex flex-col">
                    <span class="font-bold text-base text-primary">No Work Orders Assigned</span>
                    <span class="text-xs text-on-surface-variant mt-1">There are currently no tickets assigned to your cadet profile in this engineering range. When flight directors schedule a training scenario, your tickets will appear here with requirements and grading rubrics.</span>
                </div>
            </div>
        </td>
    </tr>
<?php else: ?>
    <?php foreach ($tickets as $t): ?>
        <?php
        $statusClasses = match($t['status']) {
            'ASSIGNED' => 'bg-secondary-fixed text-on-secondary-fixed',
            'IN_PROGRESS' => 'bg-primary-fixed text-on-primary-fixed',
            'SUBMITTED', 'UNDER_REVIEW' => 'bg-amber-100 text-amber-900 border border-amber-300',
            'APPROVED' => 'bg-emerald-100 text-emerald-900 border border-emerald-300',
            'CHANGES_REQUESTED' => 'bg-rose-100 text-rose-900 border border-rose-300',
            default => 'bg-surface-container text-on-surface-variant'
        };
        $priorityDot = match($t['priority']) {
            'CRITICAL' => 'bg-error animate-pulse',
            'HIGH' => 'bg-amber-500',
            'MEDIUM' => 'bg-primary',
            default => 'bg-outline-variant'
        };
        ?>
        <tr class="hover:bg-surface-container-low transition-colors group cursor-pointer ticket-row"
            data-id="<?= htmlspecialchars($t['ticket_code']) ?>"
            data-priority="<?= htmlspecialchars($t['priority']) ?>"
            data-scenario="<?= htmlspecialchars($t['scenario_title'] ?? 'Core AI') ?>"
            data-status="<?= htmlspecialchars($t['status']) ?>">
            <td class="py-space-md px-space-md font-code-inline text-label-md">
                <span class="inline-flex items-center px-2 py-0.5 rounded bg-primary text-on-primary font-bold shadow-sm">
                    <?= htmlspecialchars($t['ticket_code']) ?>
                </span>
            </td>
            <td class="py-space-md px-space-md">
                <div class="flex flex-col min-w-0">
                    <div class="flex items-center gap-space-xs">
                        <span class="font-headline-md text-[14px] text-primary font-semibold truncate">
                            <?= htmlspecialchars($t['title']) ?>
                        </span>
                    </div>
                    <span class="font-body-sm text-body-sm text-on-surface-variant truncate">
                        <?= htmlspecialchars($t['description'] ?? 'Work order for AI telemetry range pipeline.') ?>
                    </span>
                </div>
            </td>
            <td class="py-space-md px-space-md hidden md:table-cell">
                <div class="flex flex-col font-label-sm text-label-sm">
                    <span class="font-semibold text-on-surface"><?= htmlspecialchars($t['student_name'] ?? ($currentUser['full_name'] ?? 'Cadet')) ?></span>
                    <span class="text-on-surface-variant font-code-inline"><?= htmlspecialchars($t['student_identifier'] ?? $currentUser['identifier']) ?></span>
                </div>
            </td>
            <td class="py-space-md px-space-md hidden lg:table-cell">
                <span class="inline-flex items-center px-2 py-0.5 rounded bg-secondary-container text-on-secondary-container font-label-sm text-label-sm font-semibold">
                    <?= htmlspecialchars($t['scenario_title'] ?? 'Training Scenario') ?>
                </span>
            </td>
            <td class="py-space-md px-space-md">
                <div class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded bg-surface-container-high font-label-sm text-label-sm font-bold text-primary">
                    <span class="w-2 h-2 rounded-full <?= $priorityDot ?>"></span>
                    <span><?= htmlspecialchars($t['priority']) ?></span>
                </div>
            </td>
            <td class="py-space-md px-space-md hidden sm:table-cell font-code-inline text-label-sm">
                <span><?= htmlspecialchars($t['deadline'] ? date('M j, Y', strtotime($t['deadline'])) : 'Open SLA') ?></span>
            </td>
            <td class="py-space-md px-space-md">
                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded <?= $statusClasses ?> font-label-sm text-label-sm font-semibold">
                    <span><?= htmlspecialchars(str_replace('_', ' ', $t['status'])) ?></span>
                </span>
            </td>
            <td class="py-space-md px-space-md hidden xl:table-cell">
                <span class="font-code-inline text-label-sm font-semibold text-primary">
                    <?= $t['status'] === 'APPROVED' ? '100% Certified' : ($t['status'] === 'IN_PROGRESS' ? 'In Progress' : 'Queued') ?>
                </span>
            </td>
            <td class="py-space-md px-space-md text-right">
                <a href="TicketDetails.php?id=<?= $t['id'] ?>" class="px-space-md py-1 rounded bg-primary text-on-primary hover:bg-secondary transition-all font-label-sm text-label-sm font-semibold shadow-sm inline-flex items-center gap-0.5">
                    <span>Inspect</span>
                    <span class="material-symbols-outlined text-[14px]">open_in_new</span>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
<?php endif; ?></tbody>
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