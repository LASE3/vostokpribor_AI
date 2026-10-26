<?php
require_once __DIR__ . '/../app/bootstrap.php';

use App\Middleware\AuthenticationMiddleware;
use App\Core\Database;
use App\Core\Auth;

$currentUser = AuthenticationMiddleware::handle();
$db = Database::getInstance();

// Determine which student profile to show:
$targetUserId = $currentUser['id'];
if ($currentUser['role'] === 'ADMIN' && isset($_GET['id']) && (int)$_GET['id'] > 0) {
    $targetUserId = (int)$_GET['id'];
}

$profileUser = $db->fetchOne("SELECT * FROM users WHERE id = :id", ['id' => $targetUserId]) ?: $currentUser;

// Query stats
$ticketCount = (int)$db->fetchValue("SELECT COUNT(*) FROM ticket_assignments WHERE student_id = :id", ['id' => $targetUserId]);
$submissionCount = (int)$db->fetchValue("SELECT COUNT(*) FROM submissions WHERE student_id = :id", ['id' => $targetUserId]);
$approvedCount = (int)$db->fetchValue("SELECT COUNT(*) FROM submissions WHERE student_id = :id AND status = 'APPROVED'", ['id' => $targetUserId]);
$notebookCount = (int)$db->fetchValue("SELECT COUNT(*) FROM notebooks WHERE student_id = :id", ['id' => $targetUserId]);
$modelCount = (int)$db->fetchValue("SELECT COUNT(*) FROM models WHERE student_id = :id", ['id' => $targetUserId]);

$recentSubmissions = $db->fetchAll("
    SELECT s.*, t.ticket_code, t.title AS ticket_title 
    FROM submissions s 
    JOIN tickets t ON s.ticket_id = t.id 
    WHERE s.student_id = :id 
    ORDER BY s.created_at DESC LIMIT 5
", ['id' => $targetUserId]);
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
</head>

<body class="font-body-md text-body-md text-on-surface antialiased bg-fiberglass">
    <aside class="fixed left-0 top-0 h-screen w-64 bg-surface-container-lowest z-50 flex flex-col justify-between shadow-[0_1px_8px_rgba(0,0,0,0.04)]">
        <div class="flex flex-col">
            <div class="h-16 px-space-lg flex items-center gap-space-sm bg-surface-container-low">
                <div class="flex items-center justify-center w-6 h-6 rounded bg-primary text-on-primary font-label-sm text-label-sm font-semibold">VK</div>
                <div class="flex flex-col"><span class="font-label-md text-label-md text-primary font-semibold tracking-wider uppercase">Telemetry Range</span><span class="font-label-sm text-label-sm text-on-surface-variant font-code-inline">COHORT-24B::AI-ENG</span></div>
            </div>
            <div class="px-space-md py-space-sm"><span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider font-semibold px-space-sm">Operations &amp; Tasks</span></div>
            <nav class="flex flex-col gap-space-xs px-space-md" data-active-classes="bg-primary text-on-primary font-semibold shadow-[0_1px_3px_rgba(76,29,149,0.12)]"><a class="flex items-center gap-space-md px-space-md py-space-sm rounded text-on-surface-variant font-body-md text-body-md hover:bg-surface-container-high hover:text-on-surface transition-colors" data-path="dashboard" href="Dashboard.php"><span class="material-symbols-outlined text-[18px]">space_dashboard</span><span>Dashboard</span></a><a class="flex items-center gap-space-md px-space-md py-space-sm rounded text-on-surface-variant font-body-md text-body-md hover:bg-surface-container-high hover:text-on-surface transition-colors" data-path="my-tickets" href="Tickets.php"><span class="material-symbols-outlined text-[18px]">assignment</span><span>My Tickets</span></a><a class="flex items-center gap-space-md px-space-md py-space-sm rounded text-on-surface-variant font-body-md text-body-md hover:bg-surface-container-high hover:text-on-surface transition-colors" data-path="ticket-details" href="TicketDetails.php"><span class="material-symbols-outlined text-[18px]">description</span><span>Ticket Details</span></a><a class="flex items-center gap-space-md px-space-md py-space-sm rounded text-on-surface-variant font-body-md text-body-md hover:bg-surface-container-high hover:text-on-surface transition-colors" data-path="my-submissions" href="Submissions.php"><span class="material-symbols-outlined text-[18px]">inventory_2</span><span>My Submissions</span></a><a class="flex items-center justify-between px-space-md py-space-sm rounded text-on-surface-variant font-body-md text-body-md hover:bg-surface-container-high hover:text-on-surface transition-colors" data-path="notifications" href="Dashboard.php">
                    <div class="flex items-center gap-space-md"><span class="material-symbols-outlined text-[18px]">notifications</span><span>Notifications</span></div><span class="px-1.5 py-0.5 rounded font-label-sm text-label-sm bg-secondary-container text-on-secondary-container">3</span>
                </a><a aria-current="page" class="flex items-center gap-space-md px-space-md py-space-sm rounded transition-colors bg-primary text-on-primary font-semibold shadow-[0_1px_3px_rgba(76,29,149,0.12)]" data-path="student-profile" href="StudentProfile.php"><span class="material-symbols-outlined text-[18px]">badge</span><span>Student Profile</span></a></nav>
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
                    <div class="relative group"><button class="flex items-center gap-space-xs px-space-md py-1.5 rounded bg-surface-container font-label-md text-label-md text-primary cursor-pointer hover:bg-surface-container-high transition-colors"><span class="material-symbols-outlined text-[16px] text-primary">tune</span><span class="font-semibold">SYS-AI-01: AI Project &amp; Ticket Mgmt</span><span class="material-symbols-outlined text-[16px]">arrow_drop_down</span></button>
                        <div class="absolute left-0 mt-1 w-72 rounded bg-surface-container-lowest border border-outline-variant shadow-lg py-1 hidden group-hover:block z-50">
                            <div class="px-space-md py-1 font-label-sm text-label-sm font-semibold text-on-surface-variant uppercase tracking-wider">Telemetry Systems</div><a class="block px-space-md py-1.5 font-label-sm text-label-sm text-primary font-semibold bg-surface-container-low" href="#">SYS-AI-01: AI Project &amp; Ticket Mgmt</a><a class="block px-space-md py-1.5 font-label-sm text-label-sm text-on-surface hover:bg-surface-container" href="#">SYS-AI-02: Dataset Synthesis &amp; Triage</a><a class="block px-space-md py-1.5 font-label-sm text-label-sm text-on-surface hover:bg-surface-container" href="#">SYS-AI-03: Notebook Runtime &amp; Kernel</a><a class="block px-space-md py-1.5 font-label-sm text-label-sm text-on-surface hover:bg-surface-container" href="#">SYS-AI-04: Model Registry &amp; Lineage</a><a class="block px-space-md py-1.5 font-label-sm text-label-sm text-on-surface hover:bg-surface-container" href="#">SYS-AI-05: Telemetry Ops &amp; Validation</a>
                        </div>
                    </div>
                    <div class="hidden xl:flex items-center gap-space-xs px-space-sm py-1 rounded bg-tertiary-fixed font-label-sm text-label-sm text-on-tertiary-fixed font-code-inline"><span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span><span>Scenario: Churn Prediction (AI-024)</span></div>
                </div>
                <div class="flex items-center gap-space-md">
                    <div class="hidden 2xl:flex items-center gap-space-sm px-space-sm py-1 rounded bg-surface-container-low font-label-sm text-label-sm text-on-surface-variant font-code-inline"><span class="text-primary font-semibold">TLM:</span><span class="text-on-tertiary-container font-bold">NOMINAL</span><span class="text-outline-variant">|</span><span class="text-primary font-semibold">NODE:</span><span class="text-on-surface">OK</span></div>
                    <div class="relative flex items-center justify-center p-2 rounded hover:bg-surface-container-high cursor-pointer text-on-surface-variant transition-colors"><span class="material-symbols-outlined text-[20px]">notifications</span><span class="absolute top-1.5 right-1.5 flex h-2 w-2"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-error opacity-75"></span><span class="relative inline-flex rounded-full h-2 w-2 bg-error"></span></span></div>
                    <div class="flex items-center gap-space-sm pl-space-sm">
                        <div class="flex flex-col text-right hidden sm:flex"><span class="font-label-md text-label-md font-semibold text-on-surface"><?= htmlspecialchars($currentUser['full_name']) ?></span><span class="font-label-sm text-label-sm text-on-surface-variant font-code-inline"><?= htmlspecialchars($currentUser['identifier'] ?? $currentUser['email']) ?></span></div>
                        <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center"><span class="material-symbols-outlined text-on-primary text-[18px]">person</span></div>
                    </div>
                </div>
            </div>
        </header>
        <main class="relative pt-16 w-full min-h-screen">
            <div class="flex flex-col w-full">
                <div class="px-margin-desktop py-space-xl flex flex-col gap-space-lg">
                    <!-- Top Meta Action Bar -->
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-space-md">
                        <div class="flex flex-col">
                            <div class="flex items-center gap-space-xs mb-1">
                                <span class="px-space-xs py-0.5 rounded bg-tertiary-fixed text-on-tertiary-fixed font-label-sm text-label-sm uppercase font-semibold">CADET DOSSIER // <?= htmlspecialchars($profileUser['identifier'] ?? 'CADET') ?></span>
                                <span class="text-outline-variant font-label-sm text-label-sm">•</span>
                                <span class="font-label-sm text-label-sm text-primary font-semibold">AI-ACADEMY APPRENTICESHIP PIPELINE</span>
                            </div>
                            <h1 class="font-headline-xl text-headline-xl text-primary font-bold tracking-tight">Student Engineer Dossier &amp; Training Credentials</h1>
                            <p class="font-body-md text-body-md text-on-surface-variant">Industrial AI verification record and operational telemetry for Eng. <?= htmlspecialchars($profileUser['full_name']) ?> (<?= htmlspecialchars($profileUser['role']) ?>).</p>
                        </div>
                        <!-- Action Cluster -->
                        <div class="flex items-center gap-space-sm flex-wrap">
                            <button class="flex items-center gap-space-xs px-space-md py-space-sm rounded bg-surface-container-lowest text-primary font-label-md text-label-md font-semibold hover:bg-surface-container shadow-sm transition-all" onclick="alert('Cryptographic attestation signed with SHA-256 for <?= htmlspecialchars($profileUser['identifier'] ?? 'CADET-RANGE') ?>. Range transcript compiled.')">
                                <span class="material-symbols-outlined text-[16px] text-primary">verified</span>
                                <span>Verified Transcript</span>
                            </button>
                            <button class="flex items-center gap-space-xs px-space-md py-space-sm rounded bg-surface-container-lowest text-on-surface-variant font-label-md text-label-md font-semibold hover:bg-surface-container shadow-sm transition-all" onclick="alert('Dispatching synchronous scheduling ping to Dr. Thorne (SYS-AI-COMMS)...')">
                                <span class="material-symbols-outlined text-[16px]">calendar_today</span>
                                <span>Request Office Hours</span>
                            </button>
                            <button class="flex items-center gap-space-xs px-space-md py-space-sm rounded bg-primary text-on-primary font-label-md text-label-md font-semibold hover:bg-primary-container shadow-md transition-all" onclick="alert('Synchronizing trained checkpoint binaries to SYS-04 Registry...')">
                                <span class="material-symbols-outlined text-[16px] text-on-primary">cloud_upload</span>
                                <span>Deploy to SYS-04</span>
                            </button>
                        </div>
                    </div>
                    <!-- PROFILE HERO CARD -->
                    <div class="relative overflow-hidden bg-surface-container-lowest rounded-xl shadow-md p-space-lg flex flex-col xl:flex-row gap-space-xl">
                        <!-- Decorative Backdrop Geometry -->
                        <div class="absolute -right-16 -top-16 w-64 h-64 rounded-full bg-secondary-container/20 blur-3xl pointer-events-none"></div>
                        <!-- Left Column: Identity & Node Specification -->
                        <div class="flex flex-col sm:flex-row gap-space-lg xl:w-5/12 xl:pr-space-lg">
                            <div class="relative flex-shrink-0">
                                <div class="w-24 h-24 rounded-lg bg-surface-container-high overflow-hidden shadow-sm flex items-center justify-center relative">
                                    <img class="w-full h-full object-cover" data-alt="Portrait photo of a young professional Chinese-American male AI engineer in late 20s wearing a technical slate crewneck inside a high-tech data telemetry mission control center with ambient violet and cool tungsten workstation lighting." src="https://lh3.googleusercontent.com/aida-public/AB6AXuBJe0FNluBrA_4cAoiSJMmuZjopWudTK8hrNUQWwlCX9IBSjX6AhwPe6m71MnmFCOFf-rR72odtKiR6Yg5Xu6OtJOIu3o63mNnmPDpsNTLFK5QEV4fosKTBRbLOToxKiCeZCW1P1pTLwUrSx51eDuzsz8JAkXzlQwYaC_crr4FpQ1FPPkbjlABN0nMcuJscwt0ffCrFtjPj1UsmUUcoCav2I0kY8RLx3N4jdy4LfIV65e5_9Mymcl97Aw" />
                                    <div class="absolute bottom-1 right-1 px-1 py-0.5 rounded bg-primary text-on-primary font-label-sm text-label-sm font-bold">VK</div>
                                </div>
                                <div class="mt-space-xs flex items-center justify-center">
                                    <span class="px-space-xs py-0.5 rounded bg-surface-container font-label-sm text-label-sm text-on-surface-variant font-bold">SYS-AI CADET</span>
                                </div>
                            </div>
                            <div class="flex flex-col justify-between flex-grow">
                                <div>
                                    <div class="flex items-center gap-space-xs">
                                        <span class="font-headline-md text-headline-md font-bold text-primary">Alex Chen</span>
                                        <span class="material-symbols-outlined text-primary text-[18px]" title="Authenticated Range Identity">verified_user</span>
                                    </div>
                                    <p class="font-label-md text-label-md text-on-surface-variant font-code-inline">COHORT-24B :: INDUSTRIAL AI-ENGINEERING</p>
                                </div>
                                <div class="mt-space-md flex flex-col gap-space-xs">
                                    <div class="flex items-center justify-between text-body-sm font-body-sm py-1 bg-surface-container-low px-space-sm rounded">
                                        <span class="text-on-surface-variant font-medium">Standings Status</span>
                                        <span class="font-label-sm text-label-sm text-primary font-bold uppercase bg-secondary-container/60 px-1.5 py-0.5 rounded">Active (Top 4%)</span>
                                    </div>
                                    <div class="flex items-center justify-between text-body-sm font-body-sm py-1 bg-surface-container-low px-space-sm rounded">
                                        <span class="text-on-surface-variant font-medium">Assigned Compute Node</span>
                                        <span class="font-code-inline font-label-sm text-label-sm text-on-surface font-semibold">SR-NODE-09 (US-WEST)</span>
                                    </div>
                                    <div class="flex items-center justify-between text-body-sm font-body-sm py-1 bg-surface-container-low px-space-sm rounded">
                                        <span class="text-on-surface-variant font-medium">Clearance Level</span>
                                        <span class="font-label-sm text-label-sm text-on-tertiary-fixed font-bold bg-tertiary-fixed px-1.5 py-0.5 rounded">L-2 (RESTRICTED BLUEPRINTS)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Right Column: Primary Performance Telemetry -->
                        <div class="flex-grow grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-space-md">
                            <!-- Metric 1: Overall Average -->
                            <div class="flex flex-col justify-between p-space-md rounded bg-surface-container-low">
                                <div class="flex items-center justify-between text-on-surface-variant mb-space-xs">
                                    <span class="font-label-sm text-label-sm uppercase font-semibold">Grade Average</span>
                                    <span class="material-symbols-outlined text-[16px] text-primary">analytics</span>
                                </div>
                                <div>
                                    <div class="flex items-baseline gap-1">
                                        <span class="font-headline-lg text-headline-lg font-bold text-primary">94.2</span>
                                        <span class="font-label-sm text-label-sm text-on-surface-variant">/ 100</span>
                                    </div>
                                    <span class="font-label-sm text-label-sm text-primary font-semibold">Distinction Track</span>
                                </div>
                                <div class="w-full bg-surface-variant h-1 rounded-full overflow-hidden mt-space-sm">
                                    <div class="bg-primary h-full rounded-full" style="width: 94.2%"></div>
                                </div>
                            </div>
                            <!-- Metric 2: Completed Scenarios -->
                            <div class="flex flex-col justify-between p-space-md rounded bg-surface-container-low">
                                <div class="flex items-center justify-between text-on-surface-variant mb-space-xs">
                                    <span class="font-label-sm text-label-sm uppercase font-semibold">Scenarios</span>
                                    <span class="material-symbols-outlined text-[16px] text-primary">fact_check</span>
                                </div>
                                <div>
                                    <div class="flex items-baseline gap-1">
                                        <span class="font-headline-lg text-headline-lg font-bold text-on-surface">4</span>
                                        <span class="font-label-sm text-label-sm text-on-surface-variant">/ 7 Active</span>
                                    </div>
                                    <span class="font-label-sm text-label-sm text-on-tertiary-container font-semibold">57% Industrial Req</span>
                                </div>
                                <div class="w-full bg-surface-variant h-1 rounded-full overflow-hidden mt-space-sm">
                                    <div class="bg-primary-container h-full rounded-full" style="width: 57.1%"></div>
                                </div>
                            </div>
                            <!-- Metric 3: Compute Consumed -->
                            <div class="flex flex-col justify-between p-space-md rounded bg-surface-container-low">
                                <div class="flex items-center justify-between text-on-surface-variant mb-space-xs">
                                    <span class="font-label-sm text-label-sm uppercase font-semibold">GPU Compute</span>
                                    <span class="material-symbols-outlined text-[16px] text-primary">memory</span>
                                </div>
                                <div>
                                    <div class="flex items-baseline gap-1">
                                        <span class="font-headline-lg text-headline-lg font-bold text-on-surface">142.8</span>
                                        <span class="font-label-sm text-label-sm text-on-surface-variant">hrs</span>
                                    </div>
                                    <span class="font-label-sm text-label-sm text-on-surface-variant">NVIDIA A100-SXM4</span>
                                </div>
                                <div class="w-full bg-surface-variant h-1 rounded-full overflow-hidden mt-space-sm">
                                    <div class="bg-primary h-full rounded-full" style="width: 57.1%"></div>
                                </div>
                            </div>
                            <!-- Metric 4: SLA Adherence Rate -->
                            <div class="flex flex-col justify-between p-space-md rounded bg-surface-container-low">
                                <div class="flex items-center justify-between text-on-surface-variant mb-space-xs">
                                    <span class="font-label-sm text-label-sm uppercase font-semibold">SLA Adherence</span>
                                    <span class="material-symbols-outlined text-[16px] text-primary">timer</span>
                                </div>
                                <div>
                                    <div class="flex items-baseline gap-1">
                                        <span class="font-headline-lg text-headline-lg font-bold text-primary">100.0%</span>
                                    </div>
                                    <span class="font-label-sm text-label-sm text-on-surface-variant">0 Breached Cycles</span>
                                </div>
                                <div class="w-full bg-surface-variant h-1 rounded-full overflow-hidden mt-space-sm">
                                    <div class="bg-primary h-full rounded-full" style="width: 100%"></div>
                                </div>
                            </div>
                            <!-- Metric 5: Submissions & Registry -->
                            <div class="flex flex-col justify-between p-space-md rounded bg-surface-container-low col-span-2 md:col-span-1">
                                <div class="flex items-center justify-between text-on-surface-variant mb-space-xs">
                                    <span class="font-label-sm text-label-sm uppercase font-semibold">SYS-04 Deploys</span>
                                    <span class="material-symbols-outlined text-[16px] text-primary">terminal</span>
                                </div>
                                <div>
                                    <div class="flex items-baseline gap-1">
                                        <span class="font-headline-lg text-headline-lg font-bold text-on-surface">14</span>
                                        <span class="font-label-sm text-label-sm text-on-surface-variant">Versions</span>
                                    </div>
                                    <span class="font-label-sm text-label-sm text-on-surface-variant">Production Candidates</span>
                                </div>
                                <div class="w-full bg-surface-variant h-1 rounded-full overflow-hidden mt-space-sm">
                                    <div class="bg-primary-container h-full rounded-full" style="width: 78%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- MAIN COCKPIT SECTION: SCENARIOS & TELEMETRY SPLIT -->
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-lg items-start">
                        <!-- LEFT 8 COLUMNS: SCENARIOS RADAR & PROGRESS -->
                        <div class="lg:col-span-8 flex flex-col gap-space-lg">
                            <!-- Scenario Progression Panel -->
                            <div class="bg-surface-container-lowest rounded-xl shadow-sm p-space-lg flex flex-col gap-space-md">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-space-sm">
                                        <span class="material-symbols-outlined text-primary text-[22px]">rocket_launch</span>
                                        <div>
                                            <h2 class="font-headline-md text-headline-md text-primary font-bold">Scenario Competence &amp; Blueprint Progress</h2>
                                            <p class="font-body-sm text-body-sm text-on-surface-variant">Tracking validation benchmarks across the 7 mandatory enterprise production tickets.</p>
                                        </div>
                                    </div>
                                    <span class="px-space-sm py-1 rounded bg-surface-container-high font-label-sm text-label-sm text-primary font-semibold">STAGE 4 OF 7</span>
                                </div>
                                <!-- Scenario List Container -->
                                <div class="flex flex-col gap-space-xs mt-space-xs">
                                    <!-- Scenario 1 (In Progress Active) -->
                                    <div class="p-space-md rounded bg-surface-container-low hover:bg-surface-container transition-all flex flex-col md:flex-row md:items-center justify-between gap-space-sm">
                                        <div class="flex items-start gap-space-sm min-w-0">
                                            <div class="w-8 h-8 rounded bg-primary text-on-primary font-label-sm text-label-sm flex items-center justify-center font-bold flex-shrink-0 mt-0.5">
                                                01
                                            </div>
                                            <div class="flex flex-col min-w-0">
                                                <div class="flex items-center gap-space-xs flex-wrap">
                                                    <span class="font-body-md text-body-md font-semibold text-primary">Customer Churn Drift Mitigation</span>
                                                    <span class="px-space-xs py-0.5 rounded bg-tertiary-fixed text-on-tertiary-fixed font-label-sm text-label-sm font-semibold">AI-024</span>
                                                    <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                                                </div>
                                                <span class="font-body-sm text-body-sm text-on-surface-variant truncate">Tabular KS-test feature distribution alignment and CI/CD inference retrain loop.</span>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-space-md justify-between md:justify-end flex-shrink-0">
                                            <div class="flex flex-col items-end">
                                                <span class="font-label-sm text-label-sm text-primary font-bold">65% • STAGE 3/5</span>
                                                <span class="font-label-sm text-label-sm text-on-surface-variant">Notebook v3.4 Active</span>
                                            </div>
                                            <div class="w-24 bg-surface-container-highest h-2 rounded-full overflow-hidden">
                                                <div class="bg-primary h-full rounded-full" style="width: 65%"></div>
                                            </div>
                                            <span class="px-space-sm py-1 rounded bg-secondary-container text-on-secondary-container font-label-sm text-label-sm font-bold uppercase">In Progress</span>
                                        </div>
                                    </div>
                                    <!-- Scenario 2 (Completed) -->
                                    <div class="p-space-md rounded bg-surface-container-lowest hover:bg-surface-container-low transition-all flex flex-col md:flex-row md:items-center justify-between gap-space-sm">
                                        <div class="flex items-start gap-space-sm min-w-0">
                                            <div class="w-8 h-8 rounded bg-surface-container-high text-on-surface font-label-sm text-label-sm flex items-center justify-center font-bold flex-shrink-0 mt-0.5">
                                                02
                                            </div>
                                            <div class="flex flex-col min-w-0">
                                                <div class="flex items-center gap-space-xs flex-wrap">
                                                    <span class="font-body-md text-body-md font-semibold text-on-surface">Fraud Detection: Real-Time Transaction Scorer</span>
                                                    <span class="px-space-xs py-0.5 rounded bg-surface-container font-label-sm text-label-sm text-on-surface-variant font-code-inline">AI-031</span>
                                                </div>
                                                <span class="font-body-sm text-body-sm text-on-surface-variant truncate">Imbalanced multi-class classification, XGBoost and streaming Kafka consumer latency.</span>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-space-md justify-between md:justify-end flex-shrink-0">
                                            <div class="flex flex-col items-end">
                                                <span class="font-label-sm text-label-sm text-primary font-bold">91 / 100</span>
                                                <span class="font-label-sm text-label-sm text-on-surface-variant font-code-inline">AUC-ROC: 0.984</span>
                                            </div>
                                            <div class="w-24 bg-surface-container-highest h-2 rounded-full overflow-hidden">
                                                <div class="bg-primary-container h-full rounded-full" style="width: 100%"></div>
                                            </div>
                                            <span class="px-space-sm py-1 rounded bg-surface-container-high text-primary font-label-sm text-label-sm font-bold uppercase">Completed</span>
                                        </div>
                                    </div>
                                    <!-- Scenario 3 (Revision Needed) -->
                                    <div class="p-space-md rounded bg-surface-container-lowest hover:bg-surface-container-low transition-all flex flex-col md:flex-row md:items-center justify-between gap-space-sm">
                                        <div class="flex items-start gap-space-sm min-w-0">
                                            <div class="w-8 h-8 rounded bg-surface-container-high text-on-surface font-label-sm text-label-sm flex items-center justify-center font-bold flex-shrink-0 mt-0.5">
                                                03
                                            </div>
                                            <div class="flex flex-col min-w-0">
                                                <div class="flex items-center gap-space-xs flex-wrap">
                                                    <span class="font-body-md text-body-md font-semibold text-on-surface">Computer Vision: Manufacturing Micro-crack Inspection</span>
                                                    <span class="px-space-xs py-0.5 rounded bg-surface-container font-label-sm text-label-sm text-on-surface-variant font-code-inline">AI-029</span>
                                                </div>
                                                <span class="font-body-sm text-body-sm text-on-surface-variant truncate">YOLOv8 edge quantization with TensorRT. False negative rate exceeds 2.1% threshold.</span>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-space-md justify-between md:justify-end flex-shrink-0">
                                            <div class="flex flex-col items-end">
                                                <span class="font-label-sm text-label-sm text-error font-bold">v2.0 PENDING</span>
                                                <span class="font-label-sm text-label-sm text-on-surface-variant">Review by Dr. Alvarez</span>
                                            </div>
                                            <div class="w-24 bg-surface-container-highest h-2 rounded-full overflow-hidden">
                                                <div class="bg-error h-full rounded-full" style="width: 80%"></div>
                                            </div>
                                            <span class="px-space-sm py-1 rounded bg-error-container text-on-error-container font-label-sm text-label-sm font-bold uppercase">Revision Req</span>
                                        </div>
                                    </div>
                                    <!-- Scenario 4 (Distinction Completed) -->
                                    <div class="p-space-md rounded bg-surface-container-lowest hover:bg-surface-container-low transition-all flex flex-col md:flex-row md:items-center justify-between gap-space-sm">
                                        <div class="flex items-start gap-space-sm min-w-0">
                                            <div class="w-8 h-8 rounded bg-primary text-on-primary font-label-sm text-label-sm flex items-center justify-center font-bold flex-shrink-0 mt-0.5">
                                                04
                                            </div>
                                            <div class="flex flex-col min-w-0">
                                                <div class="flex items-center gap-space-xs flex-wrap">
                                                    <span class="font-body-md text-body-md font-semibold text-on-surface">NLP: Workforce Sentiment &amp; Escalation Router</span>
                                                    <span class="px-space-xs py-0.5 rounded bg-surface-container font-label-sm text-label-sm text-on-surface-variant font-code-inline">AI-018</span>
                                                </div>
                                                <span class="font-body-sm text-body-sm text-on-surface-variant truncate">DeBERTa fine-tuning with LoRA PEFT adapters. P99 inference clocked at 34ms.</span>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-space-md justify-between md:justify-end flex-shrink-0">
                                            <div class="flex flex-col items-end">
                                                <span class="font-label-sm text-label-sm text-primary font-bold">96 / 100</span>
                                                <span class="font-label-sm text-label-sm text-on-tertiary-container font-semibold">Dr. Thorne Endorsed</span>
                                            </div>
                                            <div class="w-24 bg-surface-container-highest h-2 rounded-full overflow-hidden">
                                                <div class="bg-primary h-full rounded-full" style="width: 100%"></div>
                                            </div>
                                            <span class="px-space-sm py-1 rounded bg-tertiary-fixed text-on-tertiary-fixed font-label-sm text-label-sm font-bold uppercase">Distinction</span>
                                        </div>
                                    </div>
                                    <!-- Scenario 5 (Enrolled / Queued) -->
                                    <div class="p-space-md rounded bg-surface-container-lowest opacity-80 hover:opacity-100 transition-all flex flex-col md:flex-row md:items-center justify-between gap-space-sm">
                                        <div class="flex items-start gap-space-sm min-w-0">
                                            <div class="w-8 h-8 rounded bg-surface-container text-on-surface-variant font-label-sm text-label-sm flex items-center justify-center font-bold flex-shrink-0 mt-0.5">
                                                05
                                            </div>
                                            <div class="flex flex-col min-w-0">
                                                <div class="flex items-center gap-space-xs flex-wrap">
                                                    <span class="font-body-md text-body-md font-semibold text-on-surface">Enterprise HR RAG Knowledge Assistant</span>
                                                    <span class="px-space-xs py-0.5 rounded bg-surface-container font-label-sm text-label-sm text-on-surface-variant font-code-inline">AI-033</span>
                                                </div>
                                                <span class="font-body-sm text-body-sm text-on-surface-variant truncate">Vector DB indexing, hybrid dense/sparse retrieval with semantic reranking.</span>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-space-md justify-between md:justify-end flex-shrink-0">
                                            <div class="flex flex-col items-end">
                                                <span class="font-label-sm text-label-sm text-on-surface-variant">0% • PENDING DISPATCH</span>
                                                <span class="font-label-sm text-label-sm text-on-surface-variant">Prereq: AI-024</span>
                                            </div>
                                            <div class="w-24 bg-surface-container-highest h-2 rounded-full overflow-hidden">
                                                <div class="bg-outline h-full rounded-full" style="width: 0%"></div>
                                            </div>
                                            <span class="px-space-sm py-1 rounded bg-surface-container font-label-sm text-label-sm text-on-surface-variant font-semibold uppercase">Queued</span>
                                        </div>
                                    </div>
                                    <!-- Scenario 6 (Locked) -->
                                    <div class="p-space-md rounded bg-surface-container-lowest opacity-50 flex flex-col md:flex-row md:items-center justify-between gap-space-sm">
                                        <div class="flex items-start gap-space-sm min-w-0">
                                            <div class="w-8 h-8 rounded bg-surface-container text-outline font-label-sm text-label-sm flex items-center justify-center font-bold flex-shrink-0 mt-0.5">
                                                <span class="material-symbols-outlined text-[16px]">lock</span>
                                            </div>
                                            <div class="flex flex-col min-w-0">
                                                <div class="flex items-center gap-space-xs flex-wrap">
                                                    <span class="font-body-md text-body-md font-semibold text-on-surface">Autonomous Incident Remediation Agent</span>
                                                    <span class="px-space-xs py-0.5 rounded bg-surface-container font-label-sm text-label-sm text-outline font-code-inline">AI-055</span>
                                                </div>
                                                <span class="font-body-sm text-body-sm text-outline truncate">Multi-step tool calling, execution sandboxing, and loop guardrails.</span>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-space-md justify-between md:justify-end flex-shrink-0">
                                            <span class="px-space-sm py-1 rounded bg-surface-container font-label-sm text-label-sm text-outline font-semibold uppercase">Locked</span>
                                        </div>
                                    </div>
                                    <!-- Scenario 7 (Locked) -->
                                    <div class="p-space-md rounded bg-surface-container-lowest opacity-50 flex flex-col md:flex-row md:items-center justify-between gap-space-sm">
                                        <div class="flex items-start gap-space-sm min-w-0">
                                            <div class="w-8 h-8 rounded bg-surface-container text-outline font-label-sm text-label-sm flex items-center justify-center font-bold flex-shrink-0 mt-0.5">
                                                <span class="material-symbols-outlined text-[16px]">lock</span>
                                            </div>
                                            <div class="flex flex-col min-w-0">
                                                <div class="flex items-center gap-space-xs flex-wrap">
                                                    <span class="font-body-md text-body-md font-semibold text-on-surface">Adversarial Robustness &amp; Inversion Defense</span>
                                                    <span class="px-space-xs py-0.5 rounded bg-surface-container font-label-sm text-label-sm text-outline font-code-inline">AI-061</span>
                                                </div>
                                                <span class="font-body-sm text-body-sm text-outline truncate">Model extraction defense, differential privacy budget tracking, gradient masking.</span>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-space-md justify-between md:justify-end flex-shrink-0">
                                            <span class="px-space-sm py-1 rounded bg-surface-container font-label-sm text-label-sm text-outline font-semibold uppercase">Locked</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- VERIFIED SKILL ACCREDITATIONS & BADGES -->
                            <div class="bg-surface-container-lowest rounded-xl shadow-sm p-space-lg flex flex-col gap-space-md">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-space-sm">
                                        <span class="material-symbols-outlined text-primary text-[22px]">workspace_premium</span>
                                        <div>
                                            <h2 class="font-headline-md text-headline-md text-primary font-bold">Verified Skill &amp; Domain Accreditations</h2>
                                            <p class="font-body-sm text-body-sm text-on-surface-variant">Cryptographically signed competence badges issued via VOSTOKPRIBOR Range Board.</p>
                                        </div>
                                    </div>
                                    <span class="font-label-sm text-label-sm text-on-surface-variant font-code-inline">5 RECORDS SIGNED</span>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-space-md">
                                    <!-- Skill 1 -->
                                    <div class="p-space-md rounded bg-surface-container-low flex items-start gap-space-sm hover:shadow-sm transition-all">
                                        <div class="w-10 h-10 rounded bg-primary text-on-primary flex items-center justify-center flex-shrink-0 shadow-sm">
                                            <span class="material-symbols-outlined text-[20px]">troubleshoot</span>
                                        </div>
                                        <div class="flex flex-col min-w-0 flex-grow">
                                            <div class="flex items-center justify-between">
                                                <span class="font-body-md text-body-md font-bold text-primary truncate">Tabular Feature Drift Mastery</span>
                                                <span class="px-1.5 py-0.5 rounded bg-tertiary-fixed text-on-tertiary-fixed font-label-sm text-label-sm font-semibold">VERIFIED</span>
                                            </div>
                                            <p class="font-body-sm text-body-sm text-on-surface-variant mt-0.5">KS-Test, PSI metric defense, and dynamic re-weighting pipelines.</p>
                                            <div class="mt-space-xs flex items-center justify-between font-label-sm text-label-sm text-on-surface-variant">
                                                <span>Signer: Dr. Aris Thorne</span>
                                                <span class="font-code-inline">SIG-991A</span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Skill 2 -->
                                    <div class="p-space-md rounded bg-surface-container-low flex items-start gap-space-sm hover:shadow-sm transition-all">
                                        <div class="w-10 h-10 rounded bg-secondary text-on-secondary flex items-center justify-center flex-shrink-0 shadow-sm">
                                            <span class="material-symbols-outlined text-[20px]">center_focus_strong</span>
                                        </div>
                                        <div class="flex flex-col min-w-0 flex-grow">
                                            <div class="flex items-center justify-between">
                                                <span class="font-body-md text-body-md font-bold text-on-surface truncate">Deep Learning CV Fault Detection</span>
                                                <span class="px-1.5 py-0.5 rounded bg-surface-container-high text-primary font-label-sm text-label-sm font-semibold">PROVISIONAL</span>
                                            </div>
                                            <p class="font-body-sm text-body-sm text-on-surface-variant mt-0.5">YOLO architecture calibration &amp; TensorRT FP16 quantization engine.</p>
                                            <div class="mt-space-xs flex items-center justify-between font-label-sm text-label-sm text-on-surface-variant">
                                                <span>Auditor: Dr. F. Alvarez</span>
                                                <span class="font-code-inline">SIG-404B</span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Skill 3 -->
                                    <div class="p-space-md rounded bg-surface-container-low flex items-start gap-space-sm hover:shadow-sm transition-all">
                                        <div class="w-10 h-10 rounded bg-primary-container text-on-primary flex items-center justify-center flex-shrink-0 shadow-sm">
                                            <span class="material-symbols-outlined text-[20px]">translate</span>
                                        </div>
                                        <div class="flex flex-col min-w-0 flex-grow">
                                            <div class="flex items-center justify-between">
                                                <span class="font-body-md text-body-md font-bold text-primary truncate">DeBERTa Transformer Fine-Tuning</span>
                                                <span class="px-1.5 py-0.5 rounded bg-tertiary-fixed text-on-tertiary-fixed font-label-sm text-label-sm font-semibold">DISTINCTION</span>
                                            </div>
                                            <p class="font-body-sm text-body-sm text-on-surface-variant mt-0.5">LoRA parameter-efficient tuning &amp; multilingual intent classification.</p>
                                            <div class="mt-space-xs flex items-center justify-between font-label-sm text-label-sm text-on-surface-variant">
                                                <span>Signer: Range Evaluator SYS</span>
                                                <span class="font-code-inline">SIG-810C</span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Skill 4 -->
                                    <div class="p-space-md rounded bg-surface-container-low flex items-start gap-space-sm hover:shadow-sm transition-all">
                                        <div class="w-10 h-10 rounded bg-surface-container-highest text-primary flex items-center justify-center flex-shrink-0 shadow-sm">
                                            <span class="material-symbols-outlined text-[20px]">speed</span>
                                        </div>
                                        <div class="flex flex-col min-w-0 flex-grow">
                                            <div class="flex items-center justify-between">
                                                <span class="font-body-md text-body-md font-bold text-on-surface truncate">ONNX Optimization &amp; P99 Tuning</span>
                                                <span class="px-1.5 py-0.5 rounded bg-surface-container-high text-primary font-label-sm text-label-sm font-semibold">VERIFIED</span>
                                            </div>
                                            <p class="font-body-sm text-body-sm text-on-surface-variant mt-0.5">Inference graph rewriting with sub-40ms P99 strict SLAs.</p>
                                            <div class="mt-space-xs flex items-center justify-between font-label-sm text-label-sm text-on-surface-variant">
                                                <span>Signer: Benchmark Cluster</span>
                                                <span class="font-code-inline">SIG-212D</span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Skill 5 (Span across) -->
                                    <div class="p-space-md rounded bg-surface-container-low flex items-start gap-space-sm hover:shadow-sm transition-all md:col-span-2">
                                        <div class="w-10 h-10 rounded bg-primary text-on-primary flex items-center justify-center flex-shrink-0 shadow-sm">
                                            <span class="material-symbols-outlined text-[20px]">insights</span>
                                        </div>
                                        <div class="flex flex-col min-w-0 flex-grow">
                                            <div class="flex items-center justify-between">
                                                <span class="font-body-md text-body-md font-bold text-primary">SHAP / TreeSHAP Explainable AI Compliance</span>
                                                <span class="px-1.5 py-0.5 rounded bg-tertiary-fixed text-on-tertiary-fixed font-label-sm text-label-sm font-semibold">VERIFIED</span>
                                            </div>
                                            <p class="font-body-sm text-body-sm text-on-surface-variant mt-0.5">Marginal feature attribution validation conforming to EU AI Act Title III Article 14 supervisory guidelines.</p>
                                            <div class="mt-space-xs flex items-center justify-between font-label-sm text-label-sm text-on-surface-variant">
                                                <span>Signer: Dr. Aris Thorne (Chief AI Range Instructor)</span>
                                                <span class="font-code-inline">SIG-088Z</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- RIGHT 4 COLUMNS: INFRASTRUCTURE, AUDIT LOG & MENTORS -->
                        <div class="lg:col-span-4 flex flex-col gap-space-lg">
                            <!-- COMPUTE & INFRASTRUCTURE QUOTA PANEL -->
                            <div class="bg-surface-container-lowest rounded-xl shadow-sm p-space-lg flex flex-col gap-space-md">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-space-xs">
                                        <span class="material-symbols-outlined text-primary text-[20px]">dns</span>
                                        <h3 class="font-headline-md text-headline-md text-primary font-bold">Compute &amp; Quota</h3>
                                    </div>
                                    <div class="flex items-center gap-1 font-label-sm text-label-sm text-primary font-bold">
                                        <span class="w-2 h-2 rounded-full bg-primary"></span>
                                        <span>NOMINAL</span>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-space-md">
                                    <!-- Quota 1: GPU Hours -->
                                    <div class="flex flex-col gap-1">
                                        <div class="flex items-center justify-between text-body-sm font-body-sm">
                                            <span class="text-on-surface font-semibold">NVIDIA A100 GPU Hours</span>
                                            <span class="font-label-sm text-label-sm text-primary font-bold font-code-inline">142.8 / 250 hrs (57%)</span>
                                        </div>
                                        <div class="w-full bg-surface-container-high h-2 rounded-full overflow-hidden">
                                            <div class="bg-primary h-full rounded-full" style="width: 57.1%"></div>
                                        </div>
                                        <span class="font-label-sm text-label-sm text-on-surface-variant">107.2 hours remaining in current allocation window.</span>
                                    </div>
                                    <!-- Quota 2: Lakehouse Storage -->
                                    <div class="flex flex-col gap-1">
                                        <div class="flex items-center justify-between text-body-sm font-body-sm">
                                            <span class="text-on-surface font-semibold">Lakehouse Storage (SYS-02)</span>
                                            <span class="font-label-sm text-label-sm text-on-surface font-bold font-code-inline">48.6 / 100 GB (48%)</span>
                                        </div>
                                        <div class="w-full bg-surface-container-high h-2 rounded-full overflow-hidden">
                                            <div class="bg-secondary h-full rounded-full" style="width: 48.6%"></div>
                                        </div>
                                        <span class="font-label-sm text-label-sm text-on-surface-variant">Parquet cache &amp; synthetic drift injection tables.</span>
                                    </div>
                                    <!-- Quota 3: Model Endpoints -->
                                    <div class="flex flex-col gap-1">
                                        <div class="flex items-center justify-between text-body-sm font-body-sm">
                                            <span class="text-on-surface font-semibold">Active SYS-04 Endpoints</span>
                                            <span class="font-label-sm text-label-sm text-primary font-bold font-code-inline">3 / 5 Deployed</span>
                                        </div>
                                        <div class="w-full bg-surface-container-high h-2 rounded-full overflow-hidden">
                                            <div class="bg-primary-container h-full rounded-full" style="width: 60%"></div>
                                        </div>
                                        <span class="font-label-sm text-label-sm text-on-surface-variant">ep-churn-canary, ep-fraud-fast, ep-sentiment-v2</span>
                                    </div>
                                </div>
                                <!-- Telemetry Status Grid -->
                                <div class="mt-space-xs p-space-sm rounded bg-surface-container-low flex flex-col gap-space-xs text-body-sm font-body-sm">
                                    <div class="flex items-center justify-between font-label-sm text-label-sm">
                                        <span class="text-on-surface-variant">Cluster Telemetry Ping:</span>
                                        <span class="font-code-inline font-bold text-primary">14ms [US-WEST-GPU-3]</span>
                                    </div>
                                    <div class="flex items-center justify-between font-label-sm text-label-sm">
                                        <span class="text-on-surface-variant">Runtime Kernel:</span>
                                        <span class="font-code-inline font-bold text-on-surface">Python 3.10.12 (VK-Enterprise)</span>
                                    </div>
                                    <div class="flex items-center justify-between font-label-sm text-label-sm">
                                        <span class="text-on-surface-variant">Active Job Daemon:</span>
                                        <span class="font-code-inline font-bold text-on-surface">systemd::torch-worker-09</span>
                                    </div>
                                </div>
                            </div>
                            <!-- FACULTY MENTORSHIP & INSTRUCTOR AUDIT LOG -->
                            <div class="bg-surface-container-lowest rounded-xl shadow-sm p-space-lg flex flex-col gap-space-md">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-space-xs">
                                        <span class="material-symbols-outlined text-primary text-[20px]">school</span>
                                        <h3 class="font-headline-md text-headline-md text-primary font-bold">Faculty Mentorship</h3>
                                    </div>
                                    <span class="font-label-sm text-label-sm text-tertiary font-bold bg-tertiary-fixed px-1.5 py-0.5 rounded">DIRECT SUPERVISION</span>
                                </div>
                                <!-- Mentors Summary -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-space-sm">
                                    <div class="p-space-sm rounded bg-surface-container-low flex items-center gap-space-sm">
                                        <div class="w-8 h-8 rounded-full bg-primary text-on-primary font-label-sm text-label-sm flex items-center justify-center font-bold">AT</div>
                                        <div class="flex flex-col min-w-0">
                                            <span class="font-body-md text-body-md font-bold text-primary truncate">Dr. Aris Thorne</span>
                                            <span class="font-label-sm text-label-sm text-on-surface-variant">Lead AI Instructor</span>
                                        </div>
                                    </div>
                                    <div class="p-space-sm rounded bg-surface-container-low flex items-center gap-space-sm">
                                        <div class="w-8 h-8 rounded-full bg-secondary text-on-secondary font-label-sm text-label-sm flex items-center justify-center font-bold">FA</div>
                                        <div class="flex flex-col min-w-0">
                                            <span class="font-body-md text-body-md font-bold text-on-surface truncate">Dr. Frank Alvarez</span>
                                            <span class="font-label-sm text-label-sm text-on-surface-variant">Lead Data Architect</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- Recent Endorsements & Audit Timeline -->
                                <div class="flex flex-col gap-space-sm mt-space-xs">
                                    <span class="font-label-sm text-label-sm uppercase font-semibold text-on-surface-variant">Recent Faculty Logs &amp; Feedback</span>
                                    <!-- Log Entry 1 -->
                                    <div class="p-space-sm rounded bg-surface-container-low flex flex-col gap-1">
                                        <div class="flex items-center justify-between font-label-sm text-label-sm">
                                            <span class="font-bold text-primary">Dr. Aris Thorne on Ticket AI-018</span>
                                            <span class="text-on-surface-variant font-code-inline">2 hrs ago</span>
                                        </div>
                                        <p class="font-body-sm text-body-sm text-on-surface">
                                            “Exceptional calibration on the DeBERTa LoRA weights. Inference graph optimization easily passed our production latency gate. Distinction granted.”
                                        </p>
                                    </div>
                                    <!-- Log Entry 2 -->
                                    <div class="p-space-sm rounded bg-surface-container-low flex flex-col gap-1">
                                        <div class="flex items-center justify-between font-label-sm text-label-sm">
                                            <span class="font-bold text-on-surface">Dr. Frank Alvarez on Ticket AI-029</span>
                                            <span class="text-on-surface-variant font-code-inline">Yesterday</span>
                                        </div>
                                        <p class="font-body-sm text-body-sm text-on-surface">
                                            “Micro-crack bounding boxes exhibit slight drift in low-contrast ambient test samples. Please adjust TensorRT FP16 confidence thresholds before final v2.0 sign-off.”
                                        </p>
                                    </div>
                                    <!-- Log Entry 3 -->
                                    <div class="p-space-sm rounded bg-surface-container-low flex flex-col gap-1">
                                        <div class="flex items-center justify-between font-label-sm text-label-sm">
                                            <span class="font-bold text-primary">Automated Range Audit System</span>
                                            <span class="text-on-surface-variant font-code-inline">3 days ago</span>
                                        </div>
                                        <p class="font-body-sm text-body-sm text-on-surface">
                                            “Checkpoint AI-024 stage 2 pipeline successfully passed 10,000 synthetic adversarial stress tests without crash or regression.”
                                        </p>
                                    </div>
                                </div>
                                <!-- Quick Action Buttons -->
                                <div class="pt-space-xs flex flex-col gap-space-xs">
                                    <button class="w-full py-space-sm px-space-md rounded bg-surface-container text-primary font-label-md text-label-md font-semibold hover:bg-surface-container-high transition-colors text-center" onclick="alert('Range notification preferences opened.')">
                                        Update Notification &amp; Webhook Preferences
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="js/main.js"></script>
</body>

</html>