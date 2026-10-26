<?php
require_once __DIR__ . '/../app/bootstrap.php';

use App\Middleware\AuthenticationMiddleware;
use App\Core\Database;
use App\Core\Auth;
use App\Core\Csrf;

$currentUser = AuthenticationMiddleware::handle();
$db = Database::getInstance();

$ticketId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$ticketCode = isset($_GET['code']) ? trim($_GET['code']) : '';

// Handle comment POST
$commentError = '';
$commentSuccess = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_comment') {
    if (!Csrf::validate($_POST['csrf_token'] ?? '')) {
        $commentError = 'Security session expired or invalid token. Please refresh.';
    } else {
        $targetTicketId = (int)($_POST['ticket_id'] ?? 0);
        $commentText = trim($_POST['comment'] ?? '');
        if ($targetTicketId > 0 && !empty($commentText)) {
            // Verify authorization
            $canComment = false;
            if ($currentUser['role'] === 'ADMIN') {
                $canComment = true;
            } else {
                $assigned = $db->fetchOne("SELECT id FROM ticket_assignments WHERE ticket_id = :tid AND student_id = :sid", [
                    'tid' => $targetTicketId,
                    'sid' => $currentUser['id']
                ]);
                $canComment = (bool)$assigned;
            }

            if ($canComment) {
                $db->insert('ticket_comments', [
                    'ticket_id'  => $targetTicketId,
                    'user_id'    => $currentUser['id'],
                    'comment'    => $commentText,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
                $commentSuccess = 'Comment logged successfully.';
                $ticketId = $targetTicketId;
            } else {
                $commentError = 'Unauthorized to comment on this ticket.';
            }
        }
    }
}

// Handle submission POST
$submissionError = '';
$submissionSuccess = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'submit_deliverable') {
    if (!Csrf::validate($_POST['csrf_token'] ?? '')) {
        $submissionError = 'Security session expired or invalid token. Please refresh.';
    } else {
        $targetTicketId = (int)($_POST['ticket_id'] ?? 0);
        $notes = trim($_POST['notes'] ?? '');
        if ($targetTicketId > 0) {
            // Verify student assignment
            $assigned = ($currentUser['role'] === 'ADMIN') ? true : (bool)$db->fetchOne(
                "SELECT id FROM ticket_assignments WHERE ticket_id = :tid AND student_id = :sid",
                ['tid' => $targetTicketId, 'sid' => $currentUser['id']]
            );

            if ($assigned) {
                $subCode = 'SUBM-' . strtoupper(bin2hex(random_bytes(4)));
                $iterCount = (int)$db->fetchValue("SELECT COUNT(*) FROM submissions WHERE ticket_id = :tid AND student_id = :sid", [
                    'tid' => $targetTicketId,
                    'sid' => $currentUser['id']
                ]);

                try {
                    Database::transaction(function() use ($db, $currentUser, $targetTicketId, $subCode, $iterCount, $notes, &$subId) {
                        $subId = $db->insert('submissions', [
                            'submission_code' => $subCode,
                            'ticket_id'       => $targetTicketId,
                            'student_id'      => $currentUser['id'],
                            'iteration'       => $iterCount + 1,
                            'notes'           => $notes ?: 'Deliverable package submitted from Range Terminal.',
                            'status'          => 'SUBMITTED',
                            'created_at'      => date('Y-m-d H:i:s'),
                            'updated_at'      => date('Y-m-d H:i:s')
                        ]);

                        $db->execute(
                            "UPDATE tickets SET status = 'SUBMITTED', updated_at = NOW() WHERE id = :id AND status IN ('ASSIGNED', 'IN_PROGRESS')",
                            ['id' => $targetTicketId]
                        );

                        $db->insert('audit_logs', [
                            'user_id'       => $currentUser['id'],
                            'action'        => 'SUBMISSION_CREATE',
                            'resource_type' => 'SUBMISSION',
                            'resource_id'   => $subId,
                            'outcome'       => 'SUCCESS',
                            'ip_address'    => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1',
                            'user_agent'    => $_SERVER['HTTP_USER_AGENT'] ?? 'CLI',
                            'details_json'  => json_encode(['ticket_id' => $targetTicketId, 'submission_code' => $subCode]),
                            'created_at'    => date('Y-m-d H:i:s')
                        ]);
                    });

                    $submissionSuccess = 'Deliverable submitted for dual-pipeline evaluation. Reference: ' . $subCode;
                    $ticketId = $targetTicketId;
                } catch (\Throwable $e) {
                    $submissionError = 'Database failure during submission transaction: ' . $e->getMessage();
                }
            } else {
                $submissionError = 'You are not assigned to this operational ticket.';
            }
        }
    }
}

// Find ticket
$ticket = null;
if ($ticketId > 0) {
    if ($currentUser['role'] === 'ADMIN') {
        $ticket = $db->fetchOne("SELECT t.*, s.title AS scenario_title, s.code AS scenario_code FROM tickets t LEFT JOIN scenarios s ON t.scenario_id = s.id WHERE t.id = :id", ['id' => $ticketId]);
    } else {
        $ticket = $db->fetchOne("SELECT t.*, s.title AS scenario_title, s.code AS scenario_code FROM tickets t JOIN ticket_assignments ta ON t.id = ta.ticket_id LEFT JOIN scenarios s ON t.scenario_id = s.id WHERE t.id = :id AND ta.student_id = :sid", ['id' => $ticketId, 'sid' => $currentUser['id']]);
    }
} elseif (!empty($ticketCode)) {
    if ($currentUser['role'] === 'ADMIN') {
        $ticket = $db->fetchOne("SELECT t.*, s.title AS scenario_title, s.code AS scenario_code FROM tickets t LEFT JOIN scenarios s ON t.scenario_id = s.id WHERE t.ticket_code = :code", ['code' => $ticketCode]);
    } else {
        $ticket = $db->fetchOne("SELECT t.*, s.title AS scenario_title, s.code AS scenario_code FROM tickets t JOIN ticket_assignments ta ON t.id = ta.ticket_id LEFT JOIN scenarios s ON t.scenario_id = s.id WHERE t.ticket_code = :code AND ta.student_id = :sid", ['code' => $ticketCode, 'sid' => $currentUser['id']]);
    }
} else {
    // Pick the most recent ticket
    if ($currentUser['role'] === 'ADMIN') {
        $ticket = $db->fetchOne("SELECT t.*, s.title AS scenario_title, s.code AS scenario_code FROM tickets t LEFT JOIN scenarios s ON t.scenario_id = s.id ORDER BY t.created_at DESC LIMIT 1");
    } else {
        $ticket = $db->fetchOne("SELECT t.*, s.title AS scenario_title, s.code AS scenario_code FROM tickets t JOIN ticket_assignments ta ON t.id = ta.ticket_id LEFT JOIN scenarios s ON t.scenario_id = s.id WHERE ta.student_id = :sid ORDER BY t.created_at DESC LIMIT 1", ['sid' => $currentUser['id']]);
    }
}

// If ticket exists, load comments, datasets, assignments, and submissions
$comments = [];
$datasets = [];
$submissions = [];
$assignedStudents = [];
if ($ticket) {
    $comments = $db->fetchAll("
        SELECT tc.*, u.full_name, u.identifier, u.role 
        FROM ticket_comments tc 
        JOIN users u ON tc.user_id = u.id 
        WHERE tc.ticket_id = :tid 
        ORDER BY tc.created_at ASC
    ", ['tid' => $ticket['id']]);

    $datasets = $db->fetchAll("
        SELECT d.* 
        FROM datasets d 
        WHERE d.scenario_id = :scen_id OR d.id IN (
            SELECT da.dataset_id FROM dataset_assignments da WHERE da.ticket_id = :tid
        )
        ORDER BY d.created_at DESC
    ", ['scen_id' => $ticket['scenario_id'] ?? 0, 'tid' => $ticket['id']]);

    $submissions = $db->fetchAll("
        SELECT * FROM submissions WHERE ticket_id = :tid ORDER BY created_at DESC
    ", ['tid' => $ticket['id']]);

    $assignedStudents = $db->fetchAll("
        SELECT u.full_name, u.identifier, u.email 
        FROM ticket_assignments ta 
        JOIN users u ON ta.student_id = u.id 
        WHERE ta.ticket_id = :tid
    ", ['tid' => $ticket['id']]);
}
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

<body class="bg-surface font-body-md text-body-md text-on-surface antialiased bg-fiberglass">
    <aside class="fixed left-0 top-0 h-screen w-64 bg-surface-container-lowest z-50 flex flex-col justify-between shadow-[0_1px_8px_rgba(0,0,0,0.04)]">
        <div class="flex flex-col">
            <div class="h-16 px-space-lg flex items-center gap-space-sm bg-surface-container-low">
                <div class="flex items-center justify-center w-6 h-6 rounded bg-primary text-on-primary font-label-sm text-label-sm">VK</div>
                <div class="flex flex-col"><span class="font-label-md text-label-md text-primary font-semibold tracking-wider uppercase">Telemetry Range</span><span class="font-label-sm text-label-sm text-on-surface-variant font-code-inline">COHORT-24B::AI-ENG</span></div>
            </div>
            <div class="px-space-md py-space-sm"><span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider font-semibold px-space-sm">Operations &amp; Tasks</span></div>
            <nav class="flex flex-col gap-space-xs px-space-md" data-active-classes="bg-primary text-on-primary font-semibold shadow-[0_1px_3px_rgba(76,29,149,0.12)]"><a class="flex items-center gap-space-md px-space-md py-space-sm rounded text-on-surface-variant font-body-md text-body-md hover:bg-surface-container-high hover:text-on-surface transition-colors" data-path="dashboard" href="Dashboard.php"><span class="material-symbols-outlined text-[18px]">space_dashboard</span><span>Dashboard</span></a><a class="flex items-center gap-space-md px-space-md py-space-sm rounded text-on-surface-variant font-body-md text-body-md hover:bg-surface-container-high hover:text-on-surface transition-colors" data-path="my-tickets" href="Tickets.php"><span class="material-symbols-outlined text-[18px]">assignment</span><span>My Tickets</span></a><a aria-current="page" class="flex items-center gap-space-md px-space-md py-space-sm rounded transition-colors bg-primary text-on-primary font-semibold shadow-[0_1px_3px_rgba(76,29,149,0.12)]" data-path="ticket-details" href="TicketDetails.php"><span class="material-symbols-outlined text-[18px]">description</span><span>Ticket Details</span></a><a class="flex items-center gap-space-md px-space-md py-space-sm rounded text-on-surface-variant font-body-md text-body-md hover:bg-surface-container-high hover:text-on-surface transition-colors" data-path="my-submissions" href="Submissions.php"><span class="material-symbols-outlined text-[18px]">inventory_2</span><span>My Submissions</span></a><a class="flex items-center justify-between px-space-md py-space-sm rounded text-on-surface-variant font-body-md text-body-md hover:bg-surface-container-high hover:text-on-surface transition-colors" data-path="notifications" href="Dashboard.php">
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
                    <div class="hidden xl:flex items-center gap-space-xs px-space-sm py-1 rounded bg-tertiary-fixed font-label-sm text-label-sm text-on-tertiary-fixed font-code-inline"><span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span><span>Scenario: <?= htmlspecialchars($ticket['scenario_title'] ?? 'General Operations') ?> (<?= htmlspecialchars($ticket['ticket_code'] ?? 'NONE') ?>)</span></div>
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
                <div class="px-gutter-desktop py-space-lg flex flex-col gap-space-lg max-w-[1720px] mx-auto w-full">
<?php if (!empty($commentSuccess) || !empty($submissionSuccess)): ?>
    <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-300 text-emerald-800 font-mono text-sm mb-4 flex items-center gap-2">
        <span class="material-symbols-outlined text-emerald-600">check_circle</span>
        <span><?= htmlspecialchars($commentSuccess ?: $submissionSuccess) ?></span>
    </div>
<?php endif; ?>
<?php if (!empty($commentError) || !empty($submissionError)): ?>
    <div class="p-4 rounded-xl bg-rose-50 border border-rose-300 text-rose-800 font-mono text-sm mb-4 flex items-center gap-2">
        <span class="material-symbols-outlined text-rose-600">error</span>
        <span><?= htmlspecialchars($commentError ?: $submissionError) ?></span>
    </div>
<?php endif; ?>
                    <!-- Top Context & Action Command Bar -->
                    <header class="bg-surface-container-lowest p-space-lg rounded shadow-sm flex flex-col gap-space-md relative overflow-hidden">
                        <!-- Aerospace Accent Indicator Line -->
                        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-primary via-primary-container to-secondary"></div>
                        <!-- Breadcrumb & Mission Identifiers -->
                        <div class="flex flex-wrap items-center justify-between gap-space-sm">
                            <div class="flex items-center gap-space-sm font-label-md text-label-md text-on-surface-variant">
                                <span class="text-primary font-semibold">SYS-AI-01</span>
                                <span class="text-outline-variant">/</span>
                                <span class="text-on-surface-variant">OPERATIONAL TICKETS</span>
                                <span class="text-outline-variant">/</span>
                                <span class="font-code-inline font-semibold text-primary px-space-xs py-0.5 rounded bg-surface-container"><?= htmlspecialchars($ticket['ticket_code'] ?? 'NO-TICKET') ?></span>
                            </div>
                            <div class="flex items-center gap-space-sm">
                                <div class="flex items-center gap-1.5 px-space-sm py-1 rounded bg-secondary-fixed text-on-secondary-fixed font-label-sm text-label-sm font-semibold">
                                    <span class="w-2 h-2 rounded-full bg-primary animate-ping"></span>
                                    <span><?= htmlspecialchars($ticket['status'] ?? 'UNASSIGNED') ?></span>
                                </div>
                                <div class="flex items-center gap-1.5 px-space-sm py-1 rounded bg-error-container text-on-error-container font-label-sm text-label-sm font-bold">
                                    <span class="material-symbols-outlined text-[14px]">warning</span>
                                    <span>PRIORITY: <?= htmlspecialchars($ticket['priority'] ?? 'NORMAL') ?></span>
                                </div>
                                <div class="hidden sm:flex items-center gap-1 px-space-sm py-1 rounded bg-surface-container font-label-sm text-label-sm text-on-surface-variant font-code-inline">
                                    <span>SEC-LEVEL: RESTRICTED</span>
                                </div>
                            </div>
                        </div>
                        <!-- Ticket Title & Meta Subline -->
                        <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-space-md">
                            <div class="flex flex-col gap-1 max-w-4xl">
                                <h1 class="font-headline-lg text-headline-lg font-bold text-on-surface tracking-tight">
                                    <?= htmlspecialchars(($ticket['ticket_code'] ?? 'TKT') . ': ' . ($ticket['title'] ?? 'No Assigned Ticket Selected')) ?>
                                </h1>
                                <p class="font-body-md text-body-md text-on-surface-variant flex flex-wrap items-center gap-x-space-md gap-y-1">
                                    <span>Req. Dept: <strong class="text-on-surface">Customer Retention &amp; Telemetry Operations</strong></span>
                                    <span class="text-outline-variant hidden md:inline">|</span>
                                    <span>Stakeholders: <strong class="text-on-surface">Elena Rostova</strong> (VP Customer Success), <strong class="text-on-surface">Dr. Frank Alvarez</strong> (Lead Data Architect)</span>
                                </p>
                            </div>
                            <!-- Primary Action Group -->
                            <div class="flex flex-wrap items-center gap-space-xs sm:gap-space-sm">
                                <a class="inline-flex items-center gap-space-xs px-space-md py-2 rounded bg-primary text-on-primary font-label-md text-label-md font-semibold hover:bg-primary-container shadow-sm transition-all transform active:scale-95" href="#">
                                    <span class="material-symbols-outlined text-[16px]">terminal</span>
                                    <span>Workbench (SYS-03)</span>
                                </a>
                                <a class="inline-flex items-center gap-space-xs px-space-md py-2 rounded bg-secondary-container text-on-secondary-container font-label-md text-label-md font-semibold hover:bg-surface-container-high transition-colors" href="#">
                                    <span class="material-symbols-outlined text-[16px]">dataset</span>
                                    <span>Datasets (SYS-02)</span>
                                </a>
                                <button class="inline-flex items-center gap-space-xs px-space-md py-2 rounded bg-surface-container text-primary font-label-md text-label-md font-semibold hover:bg-surface-container-high transition-colors" onclick="document.getElementById('submission-drawer').scrollIntoView({behavior: 'smooth'})">
                                    <span class="material-symbols-outlined text-[16px]">publish</span>
                                    <span>Submit Deliverables</span>
                                </button>
                                <button class="inline-flex items-center justify-center p-2 rounded bg-surface-container text-on-surface-variant hover:text-primary hover:bg-surface-container-high transition-colors" title="Ask Instructor / Ticket QA">
                                    <span class="material-symbols-outlined text-[18px]">forum</span>
                                </button>
                            </div>
                        </div>
                    </header>
                    <!-- Two-Column Industrial Layout Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-lg items-start">
                        <!-- Left Column: Deep Technical & Business Spec (8 Cols) -->
                        <main class="lg:col-span-8 flex flex-col gap-space-lg">
                            <!-- Objective & Telematics Context Mosaic Card -->
                            <section class="bg-surface-container-lowest rounded p-space-lg shadow-sm flex flex-col gap-space-lg">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-space-sm">
                                        <span class="material-symbols-outlined text-primary text-[20px]">target</span>
                                        <h2 class="font-headline-md text-headline-md font-bold text-on-surface">1. Business Objective &amp; Executive Summary</h2>
                                    </div>
                                    <span class="font-label-sm text-label-sm px-space-xs py-0.5 rounded bg-surface-container-high text-primary font-code-inline">SLO-METRIC-CRITICAL</span>
                                </div>
                                <div class="p-space-md bg-surface-container-low rounded flex flex-col gap-space-xs">
                                    <p class="font-body-md text-body-md text-on-surface leading-relaxed">
                                        Quarterly churn across enterprise fleet contracts spiked unexpectedly from <strong>3.1%</strong> to <strong class="text-error">7.4%</strong>, representing a run-rate ARR deficit of $2.4M. Current reactive touchpoints trigger after cancellation requests are initiated. An autonomous, telemetry-informed early-warning system is required to classify high-risk nodes 45 days prior to contract renewal, routing mitigation tokens directly to Tier-1 Account Advocates.
                                    </p>
                                </div>
                                <!-- Industrial Visual Telemetry Context -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-space-md">
                                    <div class="p-space-md rounded bg-surface-container-low flex flex-col gap-space-sm">
                                        <div class="flex items-center justify-between text-on-surface-variant">
                                            <span class="font-label-sm text-label-sm uppercase tracking-wider font-semibold">Gateway Ingestion Pulse</span>
                                            <span class="font-label-sm text-label-sm font-code-inline text-primary">LIVE INGESTION</span>
                                        </div>
                                        <div class="flex items-baseline gap-space-sm">
                                            <span class="font-headline-lg text-headline-lg font-bold text-primary font-code-inline">420,118</span>
                                            <span class="font-body-sm text-body-sm text-on-surface-variant">active IoT Nodes</span>
                                        </div>
                                        <p class="font-body-sm text-body-sm text-on-surface-variant">
                                            Telemetry signals ingested every 120s from transport telematics units. Billing anomalies, firmware error bursts, and packet jitter directly map to dissatisfaction vectors.
                                        </p>
                                        <!-- Mini Ingestion SVG Sparkline -->
                                        <div class="pt-space-xs">
                                            <svg class="w-full h-10 text-primary" fill="none" preserveaspectratio="none" viewbox="0 0 300 40">
                                                <path d="M0,32 Q30,12 60,24 T120,8 T180,28 T240,16 T300,10" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="2"></path>
                                                <path d="M0,32 Q30,12 60,24 T120,8 T180,28 T240,16 T300,10 L300,40 L0,40 Z" fill="currentColor" fill-opacity="0.08"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="p-space-md rounded bg-surface-container-low flex flex-col gap-space-sm">
                                        <div class="flex items-center justify-between text-on-surface-variant">
                                            <span class="font-label-sm text-label-sm uppercase tracking-wider font-semibold">Cohort Churn Drift</span>
                                            <span class="font-label-sm text-label-sm font-code-inline text-error font-bold">+4.3% DELTA</span>
                                        </div>
                                        <div class="flex items-baseline gap-space-sm">
                                            <span class="font-headline-lg text-headline-lg font-bold text-error font-code-inline">7.42%</span>
                                            <span class="font-body-sm text-body-sm text-on-surface-variant">Baseline: 3.10% Max</span>
                                        </div>
                                        <p class="font-body-sm text-body-sm text-on-surface-variant">
                                            Sudden degradation identified within enterprise tier accounts (Contracts &gt; 500 devices). Failure to arrest drift will compromise annual telemetry ARR targets.
                                        </p>
                                        <!-- Churn Bar Chart SVG -->
                                        <div class="pt-space-xs flex items-end gap-2 h-10 w-full">
                                            <div class="flex-1 bg-surface-container-highest rounded-t h-4" title="Q1: 2.8%"></div>
                                            <div class="flex-1 bg-surface-container-highest rounded-t h-5" title="Q2: 3.1%"></div>
                                            <div class="flex-1 bg-secondary-container rounded-t h-7" title="Q3: 4.6%"></div>
                                            <div class="flex-1 bg-error rounded-t h-10" title="Q4: 7.4%"></div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <!-- Data Sources Section (Direct Subsystem Integration) -->
                            <section class="bg-surface-container-lowest rounded p-space-lg shadow-sm flex flex-col gap-space-md">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-space-sm">
                                        <span class="material-symbols-outlined text-primary text-[20px]">database</span>
                                        <h2 class="font-headline-md text-headline-md font-bold text-on-surface">2. Available Data Sources (SYS-02 Lakehouse)</h2>
                                    </div>
                                    <a class="font-label-md text-label-md font-semibold text-primary hover:underline flex items-center gap-1" href="#">
                                        <span>Launch Data Catalog</span>
                                        <span class="material-symbols-outlined text-[14px]">open_in_new</span>
                                    </a>
                                </div>
                                <div class="flex flex-col gap-space-xs">
                                    <!-- Data Item 1 -->
                                    <div class="p-space-md rounded bg-surface-container-low hover:bg-surface-container transition-colors flex flex-col md:flex-row md:items-center justify-between gap-space-md">
                                        <div class="flex items-start gap-space-md">
                                            <div class="w-8 h-8 rounded bg-surface-container-highest flex items-center justify-center text-primary mt-0.5">
                                                <span class="material-symbols-outlined text-[18px]">table_rows</span>
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="font-code-inline text-code-inline font-bold text-primary">telecom_customer_churn_v2.parquet</span>
                                                <span class="font-body-sm text-body-sm text-on-surface-variant">Primary labeled ground truth dataset • 420,000 rows • 48 continuous &amp; categorical attributes</span>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-space-sm pl-11 md:pl-0">
                                            <span class="px-space-xs py-0.5 rounded bg-surface-container-highest font-label-sm text-label-sm font-code-inline text-on-surface-variant">148.6 MB</span>
                                            <a class="px-space-sm py-1 rounded bg-primary text-on-primary font-label-sm text-label-sm font-semibold hover:bg-primary-container transition-colors" href="#">
                                                Inspect in SYS-02
                                            </a>
                                        </div>
                                    </div>
                                    <!-- Data Item 2 -->
                                    <div class="p-space-md rounded bg-surface-container-low hover:bg-surface-container transition-colors flex flex-col md:flex-row md:items-center justify-between gap-space-md">
                                        <div class="flex items-start gap-space-md">
                                            <div class="w-8 h-8 rounded bg-surface-container-highest flex items-center justify-center text-primary mt-0.5">
                                                <span class="material-symbols-outlined text-[18px]">timeline</span>
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="font-code-inline text-code-inline font-bold text-primary">billing_transaction_timeseries.delta</span>
                                                <span class="font-body-sm text-body-sm text-on-surface-variant">High-frequency invoice &amp; micro-charge transactions • 3,240,910 records • Daily resolution</span>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-space-sm pl-11 md:pl-0">
                                            <span class="px-space-xs py-0.5 rounded bg-surface-container-highest font-label-sm text-label-sm font-code-inline text-on-surface-variant">1.12 GB</span>
                                            <a class="px-space-sm py-1 rounded bg-surface-container text-primary font-label-sm text-label-sm font-semibold hover:bg-surface-container-high transition-colors" href="#">
                                                Sample Lake
                                            </a>
                                        </div>
                                    </div>
                                    <!-- Data Item 3 -->
                                    <div class="p-space-md rounded bg-surface-container-low hover:bg-surface-container transition-colors flex flex-col md:flex-row md:items-center justify-between gap-space-md">
                                        <div class="flex items-start gap-space-md">
                                            <div class="w-8 h-8 rounded bg-surface-container-highest flex items-center justify-center text-primary mt-0.5">
                                                <span class="material-symbols-outlined text-[18px]">hub</span>
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="font-code-inline text-code-inline font-bold text-primary">retention_features_prod (Feature Store Group)</span>
                                                <span class="font-body-sm text-body-sm text-on-surface-variant">Pre-computed aggregated 30-day roaming ratio, support friction index, dropped packet count</span>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-space-sm pl-11 md:pl-0">
                                            <span class="px-space-xs py-0.5 rounded bg-tertiary-fixed text-on-tertiary-fixed font-label-sm text-label-sm font-code-inline font-bold">ONLINE SYNC</span>
                                            <a class="px-space-sm py-1 rounded bg-surface-container text-primary font-label-sm text-label-sm font-semibold hover:bg-surface-container-high transition-colors" href="#">
                                                Mount View
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <!-- Acceptance Criteria & Model Specifications -->
                            <section class="bg-surface-container-lowest rounded p-space-lg shadow-sm flex flex-col gap-space-lg">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-space-sm">
                                        <span class="material-symbols-outlined text-primary text-[20px]">fact_check</span>
                                        <h2 class="font-headline-md text-headline-md font-bold text-on-surface">3. Business Requirements &amp; Acceptance Criteria</h2>
                                    </div>
                                    <span class="font-label-sm text-label-sm text-on-tertiary-container font-code-inline font-bold uppercase">Automated Pipeline Test Enforced</span>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-space-md">
                                    <!-- Criterion 1 -->
                                    <div class="p-space-md rounded bg-surface-container-low flex flex-col gap-space-xs">
                                        <div class="flex items-center justify-between">
                                            <span class="font-label-sm text-label-sm font-semibold text-primary uppercase">Threshold Target</span>
                                            <span class="font-label-sm text-label-sm font-code-inline bg-secondary-fixed text-on-secondary-fixed px-1.5 py-0.5 rounded">F1 ≥ 0.82</span>
                                        </div>
                                        <span class="font-headline-sm font-bold text-on-surface">Predictive Precision Requirement</span>
                                        <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed">
                                            Model must achieve <strong>F1-Score ≥ 0.82</strong> and <strong>Precision ≥ 0.79</strong> on holdout temporal split (Sept-Oct cohort). Excessive false positives result in unnecessary retention gift incentives.
                                        </p>
                                    </div>
                                    <!-- Criterion 2 -->
                                    <div class="p-space-md rounded bg-surface-container-low flex flex-col gap-space-xs">
                                        <div class="flex items-center justify-between">
                                            <span class="font-label-sm text-label-sm font-semibold text-primary uppercase">Production SLA</span>
                                            <span class="font-label-sm text-label-sm font-code-inline bg-secondary-fixed text-on-secondary-fixed px-1.5 py-0.5 rounded">&lt; 45ms / Record</span>
                                        </div>
                                        <span class="font-headline-sm font-bold text-on-surface">Inference Latency Budget</span>
                                        <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed">
                                            Online gateway scoring runs during live customer session generation. Benchmark payload cannot exceed <strong>45ms (P99)</strong> under batch size = 1.
                                        </p>
                                    </div>
                                    <!-- Criterion 3 -->
                                    <div class="p-space-md rounded bg-surface-container-low flex flex-col gap-space-xs">
                                        <div class="flex items-center justify-between">
                                            <span class="font-label-sm text-label-sm font-semibold text-primary uppercase">Algorithmic Freedom</span>
                                            <span class="font-label-sm text-label-sm font-code-inline bg-tertiary-fixed text-on-tertiary-fixed px-1.5 py-0.5 rounded font-bold">INDEPENDENT DESIGN</span>
                                        </div>
                                        <span class="font-headline-sm font-bold text-on-surface">Architecture Selection</span>
                                        <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed">
                                            You are strictly unconstrained: choose between GBDT (LightGBM, XGBoost, CatBoost) or Deep Tabular Architectures (FT-Transformer, TabNet). You must document and defend the chosen architecture.
                                        </p>
                                    </div>
                                    <!-- Criterion 4 -->
                                    <div class="p-space-md rounded bg-surface-container-low flex flex-col gap-space-xs">
                                        <div class="flex items-center justify-between">
                                            <span class="font-label-sm text-label-sm font-semibold text-primary uppercase">Compliance Spec</span>
                                            <span class="font-label-sm text-label-sm font-code-inline bg-surface-container text-primary px-1.5 py-0.5 rounded">XAI COMPLIANT</span>
                                        </div>
                                        <span class="font-headline-sm font-bold text-on-surface">SHAP Explainability Artifact</span>
                                        <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed">
                                            Provide both global feature attributions (beeswarm/summary plot) and localized individual SHAP breakdowns for the top 10 churning enterprise accounts.
                                        </p>
                                    </div>
                                </div>
                            </section>
                            <!-- Allowed Libraries & Frameworks -->
                            <section class="bg-surface-container-lowest rounded p-space-lg shadow-sm flex flex-col gap-space-md">
                                <div class="flex items-center gap-space-sm">
                                    <span class="material-symbols-outlined text-primary text-[20px]">layers</span>
                                    <h2 class="font-headline-md text-headline-md font-bold text-on-surface">4. Approved Operational Stack &amp; Runtime Environment</h2>
                                </div>
                                <div class="flex flex-wrap gap-space-xs font-code-inline text-code-inline">
                                    <span class="px-space-sm py-1.5 rounded bg-surface-container text-on-surface">Python 3.10.12 (VK-Runtime)</span>
                                    <span class="px-space-sm py-1.5 rounded bg-surface-container text-on-surface">PyTorch 2.1.2+cu121</span>
                                    <span class="px-space-sm py-1.5 rounded bg-surface-container text-on-surface">LightGBM 4.2.0</span>
                                    <span class="px-space-sm py-1.5 rounded bg-surface-container text-on-surface">XGBoost 2.0.3</span>
                                    <span class="px-space-sm py-1.5 rounded bg-surface-container text-on-surface">Scikit-Learn 1.4.0</span>
                                    <span class="px-space-sm py-1.5 rounded bg-surface-container text-on-surface">SHAP 0.44.1</span>
                                    <span class="px-space-sm py-1.5 rounded bg-surface-container text-on-surface">Polars 0.20.10</span>
                                    <span class="px-space-sm py-1.5 rounded bg-surface-container text-on-surface">MLflow 2.10.2</span>
                                </div>
                            </section>
                            <!-- Dynamic Milestone Submission Checklist -->
                            <section class="bg-surface-container-lowest rounded p-space-lg shadow-sm flex flex-col gap-space-md">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-space-sm">
                                        <span class="material-symbols-outlined text-primary text-[20px]">checklist</span>
                                        <h2 class="font-headline-md text-headline-md font-bold text-on-surface">5. Student Progress &amp; Milestone Checklist</h2>
                                    </div>
                                    <span class="font-label-md text-label-md font-semibold text-primary font-code-inline">2 / 5 COMPLETED</span>
                                </div>
                                <div class="flex flex-col gap-space-xs" id="checklist-container">
                                    <!-- Item 1 Done -->
                                    <label class="flex items-start gap-space-md p-space-md rounded bg-surface-container-low cursor-pointer hover:bg-surface-container transition-colors">
                                        <input checked="" class="mt-0.5 rounded text-primary focus:ring-primary h-4 w-4" type="checkbox" />
                                        <div class="flex flex-col">
                                            <span class="font-body-md text-body-md font-semibold text-on-surface line-through opacity-70">
                                                Exploratory Data Analysis &amp; Imbalance Mapping logged in MLflow
                                            </span>
                                            <span class="font-body-sm text-body-sm text-on-surface-variant">Validated target class distribution (7.4% churn, 92.6% retained). Logged run: run_eda_20241014.</span>
                                        </div>
                                    </label>
                                    <!-- Item 2 Done -->
                                    <label class="flex items-start gap-space-md p-space-md rounded bg-surface-container-low cursor-pointer hover:bg-surface-container transition-colors">
                                        <input checked="" class="mt-0.5 rounded text-primary focus:ring-primary h-4 w-4" type="checkbox" />
                                        <div class="flex flex-col">
                                            <span class="font-body-md text-body-md font-semibold text-on-surface line-through opacity-70">
                                                Missing value imputation &amp; high-cardinality gateway categorical encoding
                                            </span>
                                            <span class="font-body-sm text-body-sm text-on-surface-variant">Zero leakage pipeline configured with Out-of-Fold target encoders and Median Imputers.</span>
                                        </div>
                                    </label>
                                    <!-- Item 3 Pending -->
                                    <label class="flex items-start gap-space-md p-space-md rounded bg-surface-container-low cursor-pointer hover:bg-surface-container transition-colors">
                                        <input class="mt-0.5 rounded text-primary focus:ring-primary h-4 w-4" type="checkbox" />
                                        <div class="flex flex-col">
                                            <span class="font-body-md text-body-md font-semibold text-on-surface">
                                                Temporal Cross-Validation Scheme (Strict Anti-Leakage Split)
                                            </span>
                                            <span class="font-body-sm text-body-sm text-on-surface-variant">Train on months 1-8; validate on month 9; evaluate final test performance on month 10.</span>
                                        </div>
                                    </label>
                                    <!-- Item 4 Pending -->
                                    <label class="flex items-start gap-space-md p-space-md rounded bg-surface-container-low cursor-pointer hover:bg-surface-container transition-colors">
                                        <input class="mt-0.5 rounded text-primary focus:ring-primary h-4 w-4" type="checkbox" />
                                        <div class="flex flex-col">
                                            <span class="font-body-md text-body-md font-semibold text-on-surface">
                                                SHAP Interpretability Attributions &amp; Threshold Tuning
                                            </span>
                                            <span class="font-body-sm text-body-sm text-on-surface-variant">Export summary plot + optimize decision threshold for business cost function.</span>
                                        </div>
                                    </label>
                                    <!-- Item 5 Pending -->
                                    <label class="flex items-start gap-space-md p-space-md rounded bg-surface-container-low cursor-pointer hover:bg-surface-container transition-colors">
                                        <input class="mt-0.5 rounded text-primary focus:ring-primary h-4 w-4" type="checkbox" />
                                        <div class="flex flex-col">
                                            <span class="font-body-md text-body-md font-semibold text-on-surface">
                                                Deliverable Artifacts Packaged (Model ONNX/Joblib + Executive PDF Report)
                                            </span>
                                            <span class="font-body-sm text-body-sm text-on-surface-variant">Push to SYS-04 Model Registry and upload documentation artifact.</span>
                                        </div>
                                    </label>
                                </div>
                            </section>
                        </main>
                        <!-- Right Column: Metadata, Lifecycle & Interactive Submission (4 Cols) -->
                        <aside class="lg:col-span-4 flex flex-col gap-space-lg">
                            <!-- Ticket Operations Metadata Card -->
                            <section class="bg-surface-container-lowest rounded p-space-lg shadow-sm flex flex-col gap-space-md">
                                <div class="flex items-center justify-between pb-space-sm border-b border-surface-container">
                                    <span class="font-label-sm text-label-sm uppercase tracking-wider font-semibold text-primary">Operational Metadata</span>
                                    <span class="font-label-sm text-label-sm font-code-inline text-on-tertiary-container font-bold">SLO: 18h 42m REMAINING</span>
                                </div>
                                <div class="flex flex-col gap-space-sm text-body-sm font-body-sm">
                                    <div class="flex items-center justify-between">
                                        <span class="text-on-surface-variant">Assigned Date:</span>
                                        <span class="font-code-inline font-semibold text-on-surface">Oct 14, 2024 • 08:30 UTC</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-on-surface-variant">Submission Deadline:</span>
                                        <span class="font-code-inline font-bold text-error">Oct 18, 2024 • 18:00 UTC</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-on-surface-variant">Evaluation Pipeline:</span>
                                        <span class="font-semibold text-on-surface">Dual: Autograding + Instructor Review</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-on-surface-variant">Assigned Engineer:</span>
                                        <div class="flex items-center gap-1.5 font-semibold text-primary">
                                            <span class="w-2 h-2 rounded-full bg-primary"></span>
                                            <span>Alex Chen (VK-88219)</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-on-surface-variant">Lead Reviewer:</span>
                                        <span class="font-semibold text-on-surface">Dr. Aris Thorne (Instructor)</span>
                                    </div>
                                </div>
                                <!-- Progress Ring Gauge Visualization -->
                                <div class="p-space-md rounded bg-surface-container-low flex items-center justify-between gap-space-md mt-space-xs">
                                    <div class="flex flex-col">
                                        <span class="font-label-sm text-label-sm uppercase tracking-wider font-bold text-primary">Ticket Completion</span>
                                        <span class="font-headline-md text-headline-md font-bold text-on-surface font-code-inline">40%</span>
                                        <span class="font-body-sm text-body-sm text-on-surface-variant">Phase 2 of 4 Active</span>
                                    </div>
                                    <!-- Progress Ring SVG -->
                                    <div class="relative w-16 h-16 flex items-center justify-center">
                                        <svg class="w-full h-full transform -rotate-90" viewbox="0 0 36 36">
                                            <path class="text-surface-container-highest" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="4"></path>
                                            <path class="text-primary" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-dasharray="40, 100" stroke-linecap="round" stroke-width="4"></path>
                                        </svg>
                                        <span class="absolute font-code-inline font-bold text-[11px] text-primary">2/5</span>
                                    </div>
                                </div>
                            </section>
                            <!-- Instructor Timeline & Audit Trail -->
<section class="bg-surface-container-lowest rounded p-space-lg shadow-sm flex flex-col gap-space-md">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-space-sm">
            <span class="material-symbols-outlined text-primary text-[18px]">history_edu</span>
            <h3 class="font-headline-md text-headline-md font-bold text-on-surface">Mission Notes &amp; Audit Trail</h3>
        </div>
        <span class="font-code-inline text-xs text-on-surface-variant"><?= count($comments) ?> entries</span>
    </div>
    
    <div class="relative flex flex-col gap-space-md pl-4 before:content-[''] before:absolute before:left-1.5 before:top-2 before:bottom-2 before:w-0.5 before:bg-surface-container-high max-h-80 overflow-y-auto">
        <?php if (empty($comments)): ?>
            <p class="font-body-sm text-body-sm text-on-surface-variant italic py-2">
                No mission notes or feedback recorded yet. Add an observation below.
            </p>
        <?php else: ?>
            <?php foreach ($comments as $cm): ?>
                <div class="relative flex flex-col gap-1">
                    <span class="absolute -left-4 top-1 w-2.5 h-2.5 rounded-full <?= $cm['role'] === 'ADMIN' ? 'bg-primary' : 'bg-secondary' ?> ring-4 ring-surface-container-lowest"></span>
                    <div class="flex items-center justify-between">
                        <span class="font-label-sm text-label-sm font-code-inline text-primary font-bold"><?= date('M d, H:i', strtotime($cm['created_at'])) ?> UTC</span>
                        <span class="font-label-sm text-label-sm px-1 rounded <?= $cm['role'] === 'ADMIN' ? 'bg-secondary-fixed text-on-secondary-fixed' : 'bg-surface-container text-on-surface-variant' ?>">
                            <?= htmlspecialchars($cm['full_name']) ?> (<?= htmlspecialchars($cm['role']) ?>)
                        </span>
                    </div>
                    <p class="font-body-sm text-body-sm text-on-surface bg-surface-container-low p-space-sm rounded whitespace-pre-wrap">
                        <?= htmlspecialchars($cm['comment']) ?>
                    </p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Add Note Form -->
    <form method="POST" class="mt-2 flex flex-col gap-2 pt-2 border-t border-surface-container">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(\App\Core\Csrf::getToken()) ?>" />
        <input type="hidden" name="action" value="add_comment">
        <input type="hidden" name="ticket_id" value="<?= $ticket['id'] ?? 0 ?>">
        <textarea name="comment" required rows="2" placeholder="Post progress note or question for instructor..." class="w-full text-xs p-2 rounded-lg border border-outline-variant/60 focus:border-primary focus:outline-none font-sans bg-surface-container-low"></textarea>
        <button type="submit" class="self-end px-3 py-1.5 rounded-lg bg-surface-container-high hover:bg-primary hover:text-white text-primary text-xs font-semibold font-mono transition-colors">
            Post Observation
        </button>
    </form>
</section>
                            <!-- Live Deliverables Sandbox & Upload Component -->
<section class="bg-surface-container-lowest rounded p-space-lg shadow-sm flex flex-col gap-space-md" id="submission-drawer">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-space-sm">
            <span class="material-symbols-outlined text-primary text-[20px]">cloud_upload</span>
            <h3 class="font-headline-md text-headline-md font-bold text-on-surface">Deliverable Submission</h3>
        </div>
        <span class="font-label-sm text-label-sm px-1.5 py-0.5 rounded bg-tertiary-fixed text-on-tertiary-fixed font-code-inline font-semibold">RANGE EVALUATION</span>
    </div>
    
    <?php if (!empty($submissions)): ?>
        <div class="p-3 rounded-lg bg-surface-container-low border border-surface-container">
            <span class="font-label-sm text-label-sm font-bold text-primary block mb-1">Previous Submissions:</span>
            <div class="flex flex-col gap-1 text-xs font-mono">
                <?php foreach (array_slice($submissions, 0, 3) as $sub): ?>
                    <div class="flex items-center justify-between py-1 border-b border-surface-container-highest last:border-0">
                        <span>Iteration #<?= $sub['iteration'] ?> (<?= htmlspecialchars($sub['submission_code']) ?>)</span>
                        <span class="px-1.5 py-0.2 rounded font-bold text-[10px] <?= $sub['status'] === 'APPROVED' ? 'bg-emerald-100 text-emerald-800' : ($sub['status'] === 'CHANGES_REQUESTED' ? 'bg-amber-100 text-amber-800' : 'bg-surface-container text-on-surface-variant') ?>">
                            <?= htmlspecialchars($sub['status']) ?>
                        </span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <form method="POST" class="flex flex-col gap-3">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(\App\Core\Csrf::getToken()) ?>" />
        <input type="hidden" name="action" value="submit_deliverable">
        <input type="hidden" name="ticket_id" value="<?= $ticket['id'] ?? 0 ?>">
        
        <div class="flex flex-col gap-1">
            <label class="font-label-sm text-label-sm font-semibold text-on-surface-variant">Submission Notes &amp; Methodology Defense:</label>
            <textarea name="notes" rows="3" required placeholder="Describe your model architecture, data preprocessing strategy, validation results, and F1 / precision performance..." class="w-full text-xs p-2 rounded-lg border border-outline-variant/60 focus:border-primary focus:outline-none font-sans bg-surface-container-low"></textarea>
        </div>

        <button type="submit" class="w-full py-2.5 px-space-md rounded bg-primary text-on-primary font-label-md text-label-md font-bold tracking-wide uppercase hover:bg-primary-container shadow-sm transition-all transform active:scale-98 flex items-center justify-center gap-space-sm" <?= empty($ticket) ? 'disabled' : '' ?>>
            <span class="material-symbols-outlined text-[18px]">play_circle</span>
            <span>Submit Deliverables to Instructor</span>
        </button>
    </form>
</section>
                        </aside>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="js/main.js"></script>
</body>

</html>