<?php
require_once __DIR__ . '/../app/bootstrap.php';

use App\Middleware\AuthenticationMiddleware;
use App\Core\Database;
use App\Core\Auth;
use App\Core\Csrf;

$currentUser = AuthenticationMiddleware::handle();
$db = Database::getInstance();

// Handle new submission creation from modal if posted
$submitSuccess = '';
$submitError = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create_submission') {
    if (!Csrf::validate($_POST['csrf_token'] ?? '')) {
        $submitError = 'Security session expired or invalid token. Please refresh.';
    } else {
        $ticketId = (int)($_POST['ticket_id'] ?? 0);
        $notes = trim($_POST['notes'] ?? '');
        if ($ticketId > 0 && !empty($notes)) {
            // Verify assignment
            $assigned = ($currentUser['role'] === 'ADMIN') ? true : (bool)$db->fetchOne(
                "SELECT id FROM ticket_assignments WHERE ticket_id = :tid AND student_id = :sid",
                ['tid' => $ticketId, 'sid' => $currentUser['id']]
            );

            if ($assigned) {
                $subCode = 'SUBM-' . strtoupper(bin2hex(random_bytes(4)));
                $iter = (int)$db->fetchValue("SELECT COUNT(*) FROM submissions WHERE ticket_id = :tid AND student_id = :sid", [
                    'tid' => $ticketId,
                    'sid' => $currentUser['id']
                ]) + 1;

                try {
                    Database::transaction(function() use ($db, $currentUser, $ticketId, $subCode, $iter, $notes, &$subId) {
                        $subId = $db->insert('submissions', [
                            'submission_code' => $subCode,
                            'ticket_id'       => $ticketId,
                            'student_id'      => $currentUser['id'],
                            'iteration'       => $iter,
                            'notes'           => $notes,
                            'status'          => 'SUBMITTED',
                            'created_at'      => date('Y-m-d H:i:s'),
                            'updated_at'      => date('Y-m-d H:i:s')
                        ]);

                        $db->execute(
                            "UPDATE tickets SET status = 'SUBMITTED', updated_at = NOW() WHERE id = :id AND status IN ('ASSIGNED', 'IN_PROGRESS')",
                            ['id' => $ticketId]
                        );

                        $db->insert('audit_logs', [
                            'user_id'       => $currentUser['id'],
                            'action'        => 'SUBMISSION_CREATE',
                            'resource_type' => 'SUBMISSION',
                            'resource_id'   => $subId,
                            'outcome'       => 'SUCCESS',
                            'ip_address'    => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1',
                            'user_agent'    => $_SERVER['HTTP_USER_AGENT'] ?? 'CLI',
                            'details_json'  => json_encode(['ticket_id' => $ticketId, 'code' => $subCode]),
                            'created_at'    => date('Y-m-d H:i:s')
                        ]);
                    });

                    $submitSuccess = "Artifact deliverable successfully submitted ($subCode). Dispatched to review pipeline.";
                } catch (\Throwable $e) {
                    $submitError = "Database failure during submission: " . $e->getMessage();
                }
            } else {
                $submitError = "You are not assigned to the selected ticket.";
            }
        } else {
            $submitError = "Please select a ticket and provide submission methodology notes.";
        }
    }
}

// Load student's assigned tickets for modal dropdown
$assignedTickets = [];
if ($currentUser['role'] === 'ADMIN') {
    $assignedTickets = $db->fetchAll("SELECT id, ticket_code, title FROM tickets ORDER BY created_at DESC");
} else {
    $assignedTickets = $db->fetchAll("SELECT t.id, t.ticket_code, t.title FROM tickets t JOIN ticket_assignments ta ON t.id = ta.ticket_id WHERE ta.student_id = :sid ORDER BY t.created_at DESC", ['sid' => $currentUser['id']]);
}

// Load submissions
$submissions = [];
if ($currentUser['role'] === 'ADMIN') {
    $submissions = $db->fetchAll("
        SELECT s.*, t.ticket_code, t.title AS ticket_title, stud.full_name AS student_name, stud.identifier AS student_identifier, rev.full_name AS reviewer_name
        FROM submissions s
        JOIN tickets t ON s.ticket_id = t.id
        JOIN users stud ON s.student_id = stud.id
        LEFT JOIN users rev ON s.reviewed_by = rev.id
        ORDER BY s.created_at DESC
    ");
} else {
    $submissions = $db->fetchAll("
        SELECT s.*, t.ticket_code, t.title AS ticket_title, rev.full_name AS reviewer_name
        FROM submissions s
        JOIN tickets t ON s.ticket_id = t.id
        LEFT JOIN users rev ON s.reviewed_by = rev.id
        WHERE s.student_id = :sid
        ORDER BY s.created_at DESC
    ", ['sid' => $currentUser['id']]);
}

// Stats
$totalSubmissions = count($submissions);
$underReviewCount = 0;
$approvedCount = 0;
$revisionsCount = 0;
foreach ($submissions as $s) {
    if (in_array($s['status'], ['SUBMITTED', 'UNDER_REVIEW'])) $underReviewCount++;
    if ($s['status'] === 'APPROVED') $approvedCount++;
    if (in_array($s['status'], ['CHANGES_REQUESTED', 'REJECTED'])) $revisionsCount++;
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

<body class="font-body-md text-body-md text-on-surface antialiased bg-fiberglass">
    <aside class="fixed left-0 top-0 h-screen w-64 bg-surface-container-lowest z-50 flex flex-col justify-between shadow-[0_1px_8px_rgba(0,0,0,0.04)]">
        <div class="flex flex-col">
            <div class="h-16 px-space-lg flex items-center gap-space-sm bg-surface-container-low">
                <div class="flex items-center justify-center w-6 h-6 rounded bg-primary text-on-primary font-label-sm text-label-sm font-semibold">VK</div>
                <div class="flex flex-col"><span class="font-label-md text-label-md text-primary font-semibold tracking-wider uppercase">Telemetry Range</span><span class="font-label-sm text-label-sm text-on-surface-variant font-code-inline">COHORT-24B::AI-ENG</span></div>
            </div>
            <div class="px-space-md py-space-sm"><span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider font-semibold px-space-sm">Operations &amp; Tasks</span></div>
            <nav class="flex flex-col gap-space-xs px-space-md" data-active-classes="bg-primary text-on-primary font-semibold shadow-[0_1px_3px_rgba(76,29,149,0.12)]"><a class="flex items-center gap-space-md px-space-md py-space-sm rounded text-on-surface-variant font-body-md text-body-md hover:bg-surface-container-high hover:text-on-surface transition-colors" data-path="dashboard" href="Dashboard.php"><span class="material-symbols-outlined text-[18px]">space_dashboard</span><span>Dashboard</span></a><a class="flex items-center gap-space-md px-space-md py-space-sm rounded text-on-surface-variant font-body-md text-body-md hover:bg-surface-container-high hover:text-on-surface transition-colors" data-path="my-tickets" href="Tickets.php"><span class="material-symbols-outlined text-[18px]">assignment</span><span>My Tickets</span></a><a class="flex items-center gap-space-md px-space-md py-space-sm rounded text-on-surface-variant font-body-md text-body-md hover:bg-surface-container-high hover:text-on-surface transition-colors" data-path="ticket-details" href="TicketDetails.php"><span class="material-symbols-outlined text-[18px]">description</span><span>Ticket Details</span></a><a aria-current="page" class="flex items-center gap-space-md px-space-md py-space-sm rounded transition-colors bg-primary text-on-primary font-semibold shadow-[0_1px_3px_rgba(76,29,149,0.12)]" data-path="my-submissions" href="Submissions.php"><span class="material-symbols-outlined text-[18px]">inventory_2</span><span>My Submissions</span></a><a class="flex items-center justify-between px-space-md py-space-sm rounded text-on-surface-variant font-body-md text-body-md hover:bg-surface-container-high hover:text-on-surface transition-colors" data-path="notifications" href="Dashboard.php">
                    <div class="flex items-center gap-space-md"><span class="material-symbols-outlined text-[18px]">notifications</span><span>Notifications</span></div><span class="px-1.5 py-0.5 rounded font-label-sm text-label-sm bg-secondary-container text-on-secondary-container">3</span>
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
                <!-- Sub-header Breadcrumb & Operational Alert Ribbon -->
                <div class="px-margin-desktop py-space-sm bg-surface-container-low flex flex-wrap items-center justify-between gap-space-md shadow-sm">
                    <div class="flex items-center gap-space-sm flex-wrap">
                        <span class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant font-code-inline">COHORT 24-B</span>
                        <span class="text-on-surface-variant font-code-inline text-label-sm">/</span>
                        <span class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant font-code-inline">ENGINEERING RANGE SYS-AI-01</span>
                        <span class="text-on-surface-variant font-code-inline text-label-sm">/</span>
                        <span class="px-space-xs py-0.5 rounded bg-primary text-on-primary font-label-sm text-label-sm font-semibold tracking-wide">SUBMISSIONS LEDGER</span>
                        <span class="flex items-center gap-1.5 px-space-sm py-0.5 rounded bg-surface-container-highest text-primary font-code-inline text-label-sm font-semibold">
                            <span class="inline-block w-1.5 h-1.5 rounded-full bg-primary animate-pulse"></span>
                            AUTOGRADE-NODE: SYNCED
                        </span>
                    </div>
                    <div class="flex items-center gap-space-md">
                        <div class="flex items-center gap-space-xs text-on-surface-variant font-code-inline text-label-sm">
                            <span class="material-symbols-outlined text-[16px] text-primary">verified_user</span>
                            <span>SHA256 SIGNED LEDGER: VK-SUBM-24B-88219</span>
                        </div>
                        <span class="hidden md:inline px-space-xs py-0.5 rounded bg-surface-container text-on-surface font-label-sm text-label-sm font-code-inline">UTC-LOCK: ACTIVE</span>
                    </div>
                </div>
                <div class="px-margin-desktop py-space-lg flex flex-col gap-space-xl">
                    <!-- Header Block & Actions -->
                    <div class="flex flex-col xl:flex-row xl:items-end justify-between gap-space-lg">
                        <div class="flex flex-col gap-space-xs max-w-3xl">
                            <div class="flex items-center gap-space-sm">
                                <span class="px-space-sm py-0.5 rounded bg-tertiary-fixed text-on-tertiary-fixed font-code-inline text-label-sm font-semibold">SYS-04 VALIDATION AUDIT</span>
                                <span class="font-code-inline text-label-sm text-on-surface-variant">OPERATIONAL STREAM #88219</span>
                            </div>
                            <h1 class="font-headline-xl text-headline-xl text-primary font-bold tracking-tight">Submission Records &amp; Evaluation Log</h1>
                            <p class="font-body-lg text-body-lg text-on-surface-variant">
                                Simulated industrial submission audit trail, dual-pipeline evaluation (Auto-grader + Instructor Review), and revision dispatch for Cohort 24-B.
                            </p>
                        </div>
                        <!-- Action Group -->
                        <div class="flex flex-wrap items-center gap-space-sm self-start xl:self-auto">
                            <button class="flex items-center gap-space-xs px-space-md py-2.5 rounded bg-primary text-on-primary font-label-md text-label-md font-semibold hover:bg-primary-container transition-all shadow-sm" id="openSubmitModalBtn">
                                <span class="material-symbols-outlined text-[18px]">cloud_upload</span>
                                <span>Submit New Artifact (.ONNX / .ipynb)</span>
                            </button>
                            <button class="flex items-center gap-space-xs px-space-md py-2.5 rounded bg-surface-container-lowest text-primary font-label-md text-label-md font-semibold hover:bg-surface-container transition-colors shadow-sm">
                                <span class="material-symbols-outlined text-[18px]">military_tech</span>
                                <span>Download Grade Certificate (PDF)</span>
                            </button>
                            <button class="flex items-center gap-space-xs px-space-md py-2.5 rounded bg-surface-container-high text-primary font-label-md text-label-md font-semibold hover:bg-surface-variant transition-colors shadow-sm">
                                <span class="material-symbols-outlined text-[18px]">download</span>
                                <span>Export Audit History</span>
                            </button>
                        </div>
                    </div>
                    <!-- Active Revision Dispatch Urgent Alert (AI-029) -->
                    <div class="p-space-md rounded bg-surface-container-lowest shadow-sm flex flex-col lg:flex-row items-start lg:items-center justify-between gap-space-md relative overflow-hidden">
                        <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-primary"></div>
                        <div class="flex items-start gap-space-md pl-space-xs">
                            <div class="p-2.5 rounded bg-tertiary-fixed text-on-tertiary-fixed flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-[24px]">assignment_late</span>
                            </div>
                            <div class="flex flex-col gap-0.5">
                                <div class="flex items-center gap-space-sm flex-wrap">
                                    <span class="font-label-md text-label-md font-bold text-primary font-code-inline">DISPATCH LOCKOUT IMMINENT</span>
                                    <span class="px-space-xs py-0.5 rounded bg-tertiary-fixed-dim text-on-tertiary-fixed font-code-inline text-label-sm font-semibold">DEADLINE: 18h REMAINING</span>
                                    <span class="font-code-inline text-label-sm text-on-surface-variant">TICKET AI-029 • REVISION 2.1 REQUIRED</span>
                                </div>
                                <p class="font-body-md text-body-md text-on-surface">
                                    Instructor Dr. Aris Thorne flagged false positives on solder flux splatter (PCB Micro-crack). Action required prior to UTC 12:00 lockout.
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-space-sm shrink-0 w-full lg:w-auto justify-end">
                            <button class="px-space-md py-2 rounded bg-surface-container text-primary font-label-md text-label-md font-semibold hover:bg-surface-container-highest transition-colors" onclick="document.getElementById('ticket-ai-029').scrollIntoView({behavior: 'smooth'})">
                                View Deficiency Notes
                            </button>
                            <button class="px-space-md py-2 rounded bg-primary text-on-primary font-label-md text-label-md font-semibold hover:bg-primary-container transition-colors shadow-sm flex items-center gap-1" id="quickResubmitBtn">
                                <span>Fast Dispatch v2.1</span>
                                <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                            </button>
                        </div>
                    </div>
                    <!-- Top Metrics Summary Cards Bento Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-space-md">
                        <!-- Metric 1: Total Submissions -->
                        <div class="p-space-md rounded bg-surface-container-lowest shadow-sm flex flex-col justify-between gap-space-sm relative">
                            <div class="flex items-center justify-between">
                                <span class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant font-code-inline">TOTAL SUBMISSIONS</span>
                                <span class="material-symbols-outlined text-[20px] text-primary">layers</span>
                            </div>
                            <div class="flex items-baseline gap-space-xs">
                                <span class="font-headline-xl text-headline-xl font-bold text-primary"><?= $totalSubmissions ?></span>
                                <span class="font-label-md text-label-md text-on-surface-variant font-code-inline">versions</span>
                            </div>
                            <div class="flex items-center justify-between pt-space-xs bg-surface-container-low px-space-xs py-1 rounded">
                                <span class="font-label-sm text-label-sm text-on-surface-variant">Coverage</span>
                                <span class="font-label-sm text-label-sm font-code-inline text-primary font-semibold"><?= count($assignedTickets) ?> active tickets</span>
                            </div>
                        </div>
                        <!-- Metric 2: Approved / Passed -->
                        <div class="p-space-md rounded bg-surface-container-lowest shadow-sm flex flex-col justify-between gap-space-sm relative">
                            <div class="flex items-center justify-between">
                                <span class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant font-code-inline">APPROVED / PASSED</span>
                                <span class="material-symbols-outlined text-[20px] text-primary">check_circle</span>
                            </div>
                            <div class="flex items-baseline gap-space-xs">
                                <span class="font-headline-xl text-headline-xl font-bold text-primary"><?= $approvedCount ?></span>
                                <span class="font-label-md text-label-md text-on-surface-variant font-code-inline">artifacts</span>
                            </div>
                            <div class="flex items-center justify-between pt-space-xs bg-surface-container-low px-space-xs py-1 rounded">
                                <span class="font-label-sm text-label-sm text-on-surface-variant">Distinction tier</span>
                                <span class="font-label-sm text-label-sm font-code-inline text-primary font-semibold">4 artifacts</span>
                            </div>
                        </div>
                        <!-- Metric 3: Revisions Requested -->
                        <div class="p-space-md rounded bg-surface-container-lowest shadow-sm flex flex-col justify-between gap-space-sm relative">
                            <div class="flex items-center justify-between">
                                <span class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant font-code-inline">REVISIONS REQUESTED</span>
                                <span class="material-symbols-outlined text-[20px] text-on-tertiary-container">sync_problem</span>
                            </div>
                            <div class="flex items-baseline gap-space-xs">
                                <span class="font-headline-xl text-headline-xl font-bold text-on-tertiary-fixed"><?= $revisionsCount ?></span>
                                <span class="font-label-md text-label-md text-on-surface-variant font-code-inline">pending fixes</span>
                            </div>
                            <div class="flex items-center justify-between pt-space-xs bg-tertiary-fixed px-space-xs py-1 rounded">
                                <span class="font-label-sm text-label-sm text-on-tertiary-fixed font-semibold">AI-029 &amp; AI-018</span>
                                <span class="font-label-sm text-label-sm font-code-inline text-primary font-bold">ACTIVE</span>
                            </div>
                        </div>
                        <!-- Metric 4: Pending Evaluation -->
                        <div class="p-space-md rounded bg-surface-container-lowest shadow-sm flex flex-col justify-between gap-space-sm relative">
                            <div class="flex items-center justify-between">
                                <span class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant font-code-inline">PENDING EVAL</span>
                                <span class="material-symbols-outlined text-[20px] text-primary">hourglass_top</span>
                            </div>
                            <div class="flex items-baseline gap-space-xs">
                                <span class="font-headline-xl text-headline-xl font-bold text-primary"><?= $underReviewCount ?></span>
                                <span class="font-label-md text-label-md text-on-surface-variant font-code-inline">in canary run</span>
                            </div>
                            <div class="flex items-center justify-between pt-space-xs bg-secondary-fixed px-space-xs py-1 rounded">
                                <span class="font-label-sm text-label-sm text-on-secondary-fixed">Node SYS-04</span>
                                <span class="font-label-sm text-label-sm font-code-inline text-primary font-semibold">CANARY TEST</span>
                            </div>
                        </div>
                        <!-- Metric 5: Mean Cohort Score -->
                        <div class="p-space-md rounded bg-surface-container-lowest shadow-sm flex flex-col justify-between gap-space-sm relative">
                            <div class="flex items-center justify-between">
                                <span class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant font-code-inline">MEAN COHORT SCORE</span>
                                <span class="material-symbols-outlined text-[20px] text-primary">speed</span>
                            </div>
                            <div class="flex items-baseline gap-space-xs">
                                <span class="font-headline-xl text-headline-xl font-bold text-primary">93.4</span>
                                <span class="font-label-md text-label-md text-on-surface-variant font-code-inline">/ 100</span>
                            </div>
                            <div class="flex items-center justify-between pt-space-xs bg-surface-container-low px-space-xs py-1 rounded">
                                <span class="font-label-sm text-label-sm text-on-surface-variant">Class Percentile</span>
                                <span class="font-label-sm text-label-sm font-code-inline text-primary font-semibold">Top 5%</span>
                            </div>
                        </div>
                    </div>
                    <!-- Inline Telemetry & Grade Benchmark Distribution SVG Chart Banner -->
                    <div class="p-space-md rounded bg-surface-container-lowest shadow-sm flex flex-col lg:flex-row items-center justify-between gap-space-md">
                        <div class="flex items-center gap-space-md">
                            <div class="w-10 h-10 rounded bg-surface-container flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-primary text-[24px]">analytics</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="font-label-md text-label-md font-semibold text-primary uppercase tracking-wide">Cohort 24-B Grade Benchmark &amp; Telemetry Drift</span>
                                <span class="font-body-sm text-body-sm text-on-surface-variant">Real-time autograder latency curves vs. instructor validation weights across 14 submissions.</span>
                            </div>
                        </div>
                        <!-- Inline SVG Trend / Sparkline -->
                        <div class="flex items-center gap-space-lg w-full lg:w-auto justify-end">
                            <div class="hidden sm:flex flex-col items-end">
                                <span class="font-code-inline text-label-sm text-on-surface-variant">BENCHMARK RUN: VK-SYS04-L9</span>
                                <span class="font-code-inline text-label-md font-bold text-primary">99.2% REPRODUCIBILITY</span>
                            </div>
                            <div class="w-64 h-10 shrink-0">
                                <svg class="w-full h-full text-primary" fill="none" viewbox="0 0 240 40" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0 32 L30 28 L60 30 L90 18 L120 22 L150 12 L180 15 L210 6 L240 10" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                    <path d="M0 32 L30 28 L60 30 L90 18 L120 22 L150 12 L180 15 L210 6 L240 10 L240 40 L0 40 Z" fill="currentColor" fill-opacity="0.08"></path>
                                    <circle cx="210" cy="6" fill="currentColor" r="3"></circle>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <!-- Filters, Search & View Controls Bar -->
                    <div class="p-space-md rounded bg-surface-container-lowest shadow-sm flex flex-col xl:flex-row items-stretch xl:items-center justify-between gap-space-md">
                        <!-- Search Input -->
                        <div class="relative flex-1 min-w-[280px]">
                            <span class="material-symbols-outlined absolute left-3 top-2.5 text-on-surface-variant text-[18px]">search</span>
                            <input class="w-full pl-9 pr-space-md py-2 bg-surface-container-low rounded font-body-md text-body-md text-on-surface placeholder-on-surface-variant focus:outline-none focus:bg-surface-container transition-colors font-code-inline" placeholder="Search by ticket ID (e.g. AI-024), artifact name, model hash..." type="text" />
                        </div>
                        <!-- Filter Controls Group -->
                        <div class="flex flex-wrap items-center gap-space-sm">
                            <!-- Status Filter -->
                            <div class="flex items-center gap-space-xs bg-surface-container-low px-space-sm py-1 rounded">
                                <span class="font-label-sm text-label-sm text-on-surface-variant uppercase font-semibold">Status:</span>
                                <select class="bg-transparent font-label-sm text-label-sm font-semibold text-primary focus:outline-none cursor-pointer">
                                    <option>All Statuses (14)</option>
                                    <option>Approved / Passed (6)</option>
                                    <option>Changes Requested (2)</option>
                                    <option>Under Evaluation (1)</option>
                                    <option>Archived (5)</option>
                                </select>
                            </div>
                            <!-- Scenario Filter -->
                            <div class="flex items-center gap-space-xs bg-surface-container-low px-space-sm py-1 rounded">
                                <span class="font-label-sm text-label-sm text-on-surface-variant uppercase font-semibold">Scenario:</span>
                                <select class="bg-transparent font-label-sm text-label-sm font-semibold text-primary focus:outline-none cursor-pointer">
                                    <option>All Scenarios</option>
                                    <option>AI-024 Customer Churn Drift</option>
                                    <option>AI-029 PCB Micro-crack Vision</option>
                                    <option>AI-018 Sentiment Router</option>
                                    <option>AI-031 Financial Fraud Scorer</option>
                                </select>
                            </div>
                            <!-- Evaluation Pipeline Filter -->
                            <div class="flex items-center gap-space-xs bg-surface-container-low px-space-sm py-1 rounded">
                                <span class="font-label-sm text-label-sm text-on-surface-variant uppercase font-semibold">Pipeline:</span>
                                <select class="bg-transparent font-label-sm text-label-sm font-semibold text-primary focus:outline-none cursor-pointer">
                                    <option>Dual Review (Auto + Instructor)</option>
                                    <option>Auto-Evaluator SYS-04 Only</option>
                                    <option>Instructor Manual Audit</option>
                                </select>
                            </div>
                            <!-- View Switcher -->
                            <div class="flex items-center bg-surface-container-low p-0.5 rounded">
                                <button class="flex items-center gap-1 px-space-sm py-1 rounded bg-primary text-on-primary font-label-sm text-label-sm font-semibold shadow-sm transition-colors" id="viewListBtn">
                                    <span class="material-symbols-outlined text-[16px]">view_list</span>
                                    <span class="hidden sm:inline">Detailed List</span>
                                </button>
                                <button class="flex items-center gap-1 px-space-sm py-1 rounded text-on-surface-variant font-label-sm text-label-sm font-semibold hover:text-on-surface transition-colors" id="viewMatrixBtn">
                                    <span class="material-symbols-outlined text-[16px]">grid_view</span>
                                    <span class="hidden sm:inline">Version Matrix</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Submission Records Container -->
                    <div class="flex flex-col gap-space-lg" id="submissionsListContainer">
                        <!-- ================= RECORD 1: TICKET AI-024 ================= -->
                        <div class="bg-surface-container-lowest rounded shadow-sm overflow-hidden transition-all duration-200">
                            <!-- Structural Header -->
                            <div class="p-space-md bg-surface-container-low flex flex-col md:flex-row md:items-center justify-between gap-space-md">
                                <div class="flex items-center gap-space-md flex-wrap">
                                    <div class="flex items-center gap-space-xs">
                                        <span class="w-2.5 h-2.5 rounded-full bg-primary"></span>
                                        <span class="font-headline-md text-headline-md font-bold text-primary">Ticket AI-024</span>
                                    </div>
                                    <span class="px-space-xs py-0.5 rounded bg-surface-container text-on-surface font-code-inline text-label-sm font-semibold">Customer Churn Drift Mitigation</span>
                                    <span class="px-space-xs py-0.5 rounded bg-primary-fixed text-on-primary-fixed font-code-inline text-label-sm font-bold">VERSION v1.2 (LATEST)</span>
                                </div>
                                <div class="flex items-center gap-space-md flex-wrap">
                                    <div class="flex items-center gap-space-xs font-code-inline text-label-sm text-on-surface-variant">
                                        <span class="material-symbols-outlined text-[16px]">schedule</span>
                                        <span>Submitted: Oct 16, 2024 • 18:40 UTC</span>
                                    </div>
                                    <!-- Pulsing Evaluation Badge -->
                                    <div class="flex items-center gap-1.5 px-space-sm py-1 rounded bg-secondary-fixed text-on-secondary-fixed font-code-inline text-label-sm font-bold">
                                        <span class="w-2 h-2 rounded-full bg-primary animate-ping"></span>
                                        <span>UNDER EVALUATION — CANARY PIPELINE (SYS-04)</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Main Body -->
                            <div class="p-space-lg flex flex-col gap-space-lg">
                                <!-- Artifact Manifest Row -->
                                <div class="flex flex-col gap-space-xs">
                                    <span class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant font-code-inline">COMMITTED ARTIFACT MANIFEST (3 FILES)</span>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-space-sm">
                                        <div class="p-space-sm rounded bg-surface-container-low flex items-center justify-between gap-space-sm">
                                            <div class="flex items-center gap-space-xs min-w-0">
                                                <span class="material-symbols-outlined text-[18px] text-primary">data_object</span>
                                                <span class="font-code-inline text-label-md text-primary font-semibold truncate">churn_pipeline_v1_2.onnx</span>
                                            </div>
                                            <span class="font-code-inline text-label-sm text-on-surface-variant shrink-0">14.2 MB</span>
                                        </div>
                                        <div class="p-space-sm rounded bg-surface-container-low flex items-center justify-between gap-space-sm">
                                            <div class="flex items-center gap-space-xs min-w-0">
                                                <span class="material-symbols-outlined text-[18px] text-primary">code</span>
                                                <span class="font-code-inline text-label-md text-primary font-semibold truncate">eda_drift_mitigation.ipynb</span>
                                            </div>
                                            <span class="font-code-inline text-label-sm text-on-surface-variant shrink-0">3.8 MB</span>
                                        </div>
                                        <div class="p-space-sm rounded bg-surface-container-low flex items-center justify-between gap-space-sm">
                                            <div class="flex items-center gap-space-xs min-w-0">
                                                <span class="material-symbols-outlined text-[18px] text-primary">description</span>
                                                <span class="font-code-inline text-label-md text-primary font-semibold truncate">executive_brief_churn.pdf</span>
                                            </div>
                                            <span class="font-code-inline text-label-sm text-on-surface-variant shrink-0">1.1 MB</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- Dual Review Evaluation Split Panes -->
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-space-md">
                                    <!-- Left: SYS-04 Autograder Telemetry -->
                                    <div class="p-space-md rounded bg-surface-container-low flex flex-col justify-between gap-space-md">
                                        <div class="flex flex-col gap-space-xs">
                                            <div class="flex items-center justify-between">
                                                <span class="font-label-md text-label-md font-bold text-primary uppercase tracking-wide">AUTO-EVALUATOR SYS-04 TELEMETRY</span>
                                                <span class="px-space-xs py-0.5 rounded bg-surface-container text-primary font-code-inline text-label-sm font-semibold">RUN #CANARY-882</span>
                                            </div>
                                            <p class="font-body-sm text-body-sm text-on-surface-variant">Synthesized batch benchmark executed across 50,000 synthetic telco records with injected feature shift.</p>
                                        </div>
                                        <!-- Metric Benchmarks Table-like Layout -->
                                        <div class="grid grid-cols-3 gap-space-xs">
                                            <div class="p-space-xs bg-surface-container-lowest rounded flex flex-col">
                                                <span class="font-label-sm text-label-sm text-on-surface-variant">P99 Latency</span>
                                                <span class="font-code-inline text-headline-md font-bold text-primary">38ms</span>
                                                <span class="font-code-inline text-label-sm text-primary font-semibold">PASS (&lt;45ms)</span>
                                            </div>
                                            <div class="p-space-xs bg-surface-container-lowest rounded flex flex-col">
                                                <span class="font-label-sm text-label-sm text-on-surface-variant">Holdout F1</span>
                                                <span class="font-code-inline text-headline-md font-bold text-primary">0.864</span>
                                                <span class="font-code-inline text-label-sm text-primary font-semibold">PASS (&gt;=0.82)</span>
                                            </div>
                                            <div class="p-space-xs bg-surface-container-lowest rounded flex flex-col">
                                                <span class="font-label-sm text-label-sm text-on-surface-variant">ROC-AUC</span>
                                                <span class="font-code-inline text-headline-md font-bold text-primary">0.912</span>
                                                <span class="font-code-inline text-label-sm text-on-surface-variant font-semibold">Nominal</span>
                                            </div>
                                        </div>
                                        <div class="flex items-center justify-between text-label-sm font-code-inline text-on-surface-variant">
                                            <span>CANARY NODE: eu-central-tlm4</span>
                                            <span class="text-primary font-semibold">AUTOMATED STAGE: 3/3 COMPLETE</span>
                                        </div>
                                    </div>
                                    <!-- Right: Instructor Review Status -->
                                    <div class="p-space-md rounded bg-surface-container-low flex flex-col justify-between gap-space-md">
                                        <div class="flex flex-col gap-space-xs">
                                            <div class="flex items-center justify-between">
                                                <span class="font-label-md text-label-md font-bold text-primary uppercase tracking-wide">INSTRUCTOR REVIEW STATUS</span>
                                                <span class="px-space-xs py-0.5 rounded bg-tertiary-fixed text-on-tertiary-fixed font-code-inline text-label-sm font-semibold">SLA: 6h REMAINING</span>
                                            </div>
                                            <div class="flex items-center gap-space-sm pt-space-xs">
                                                <div class="w-9 h-9 rounded-full bg-primary text-on-primary font-label-md text-label-md font-bold flex items-center justify-center shrink-0">
                                                    AT
                                                </div>
                                                <div class="flex flex-col">
                                                    <span class="font-label-md text-label-md font-semibold text-on-surface">Assigned: Dr. Aris Thorne</span>
                                                    <span class="font-body-sm text-body-sm text-on-surface-variant">Chief Instructor • Flight Test AI Telemetry</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="p-space-sm rounded bg-surface-container-lowest flex items-center gap-space-sm">
                                            <span class="material-symbols-outlined text-primary text-[20px] shrink-0">pending_actions</span>
                                            <span class="font-body-sm text-body-sm text-on-surface">Queue position: <strong>#2</strong> in cohort queue. Evaluation script verification awaiting human rubrics confirmation.</span>
                                        </div>
                                        <div class="flex items-center justify-between text-label-sm font-code-inline text-on-surface-variant">
                                            <span>ESTIMATED GRADE DISPATCH: Today 23:59 UTC</span>
                                            <span class="text-primary font-semibold">WEIGHT: 40%</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- Bottom Action Buttons for Record 1 -->
                                <div class="flex flex-wrap items-center justify-between gap-space-md pt-space-xs">
                                    <div class="flex items-center gap-space-sm">
                                        <span class="font-code-inline text-label-sm text-on-surface-variant">HASH: f8a301c99b8273...</span>
                                    </div>
                                    <div class="flex items-center gap-space-sm">
                                        <button class="px-space-md py-2 rounded bg-surface-container-high text-primary font-label-md text-label-md font-semibold hover:bg-surface-variant transition-colors flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[16px]">troubleshoot</span>
                                            <span>Inspect Run in SYS-04</span>
                                        </button>
                                        <button class="px-space-md py-2 rounded bg-surface-container-high text-primary font-label-md text-label-md font-semibold hover:bg-surface-variant transition-colors flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[16px]">visibility</span>
                                            <span>View Uploaded Manifest</span>
                                        </button>
                                        <button class="px-space-md py-2 rounded bg-surface-container text-error font-label-md text-label-md font-semibold hover:bg-error-container transition-colors">
                                            Cancel Submission
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ================= RECORD 2: TICKET AI-029 ================= -->
                        <div class="bg-surface-container-lowest rounded shadow-sm overflow-hidden transition-all duration-200" id="ticket-ai-029">
                            <!-- Structural Header -->
                            <div class="p-space-md bg-surface-container-low flex flex-col md:flex-row md:items-center justify-between gap-space-md">
                                <div class="flex items-center gap-space-md flex-wrap">
                                    <div class="flex items-center gap-space-xs">
                                        <span class="w-2.5 h-2.5 rounded-full bg-on-tertiary-container"></span>
                                        <span class="font-headline-md text-headline-md font-bold text-primary">Ticket AI-029</span>
                                    </div>
                                    <span class="px-space-xs py-0.5 rounded bg-surface-container text-on-surface font-code-inline text-label-sm font-semibold">Manufacturing Micro-crack Vision Inspection</span>
                                    <span class="px-space-xs py-0.5 rounded bg-tertiary-fixed text-on-tertiary-fixed font-code-inline text-label-sm font-bold">VERSION v2.0 (REVISION 1)</span>
                                </div>
                                <div class="flex items-center gap-space-md flex-wrap">
                                    <div class="flex items-center gap-space-xs font-code-inline text-label-sm text-on-surface-variant">
                                        <span class="material-symbols-outlined text-[16px]">schedule</span>
                                        <span>Submitted: Oct 14, 2024 • 11:15 UTC</span>
                                    </div>
                                    <!-- Changes Requested Status Badge -->
                                    <div class="flex items-center gap-1.5 px-space-sm py-1 rounded bg-tertiary-fixed text-on-tertiary-fixed font-code-inline text-label-sm font-bold">
                                        <span class="material-symbols-outlined text-[16px]">warning</span>
                                        <span>CHANGES REQUESTED</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Main Body -->
                            <div class="p-space-lg flex flex-col gap-space-lg">
                                <!-- Artifact Manifest Row -->
                                <div class="flex flex-col gap-space-xs">
                                    <span class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant font-code-inline">COMMITTED ARTIFACT MANIFEST (2 FILES)</span>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-space-sm">
                                        <div class="p-space-sm rounded bg-surface-container-low flex items-center justify-between gap-space-sm">
                                            <div class="flex items-center gap-space-xs min-w-0">
                                                <span class="material-symbols-outlined text-[18px] text-primary">deployed_code</span>
                                                <span class="font-code-inline text-label-md text-primary font-semibold truncate">yolov8_nano_pcb_v2.pt</span>
                                            </div>
                                            <span class="font-code-inline text-label-sm text-on-surface-variant shrink-0">6.2 MB</span>
                                        </div>
                                        <div class="p-space-sm rounded bg-surface-container-low flex items-center justify-between gap-space-sm">
                                            <div class="flex items-center gap-space-xs min-w-0">
                                                <span class="material-symbols-outlined text-[18px] text-primary">image</span>
                                                <span class="font-code-inline text-label-md text-primary font-semibold truncate">val_confusion_matrix.png</span>
                                            </div>
                                            <span class="font-code-inline text-label-sm text-on-surface-variant shrink-0">512 KB</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- Highlighted Instructor Deficiency Breakdown -->
                                <div class="p-space-md rounded bg-surface-container-low flex flex-col gap-space-md">
                                    <div class="flex items-start justify-between gap-space-md flex-wrap">
                                        <div class="flex items-center gap-space-sm">
                                            <div class="w-10 h-10 rounded-full bg-primary text-on-primary font-label-md text-label-md font-bold flex items-center justify-center shrink-0">
                                                AT
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="font-label-md text-label-md font-bold text-primary">Instructor Evaluation Notes — Dr. Aris Thorne</span>
                                                <span class="font-body-sm text-body-sm text-on-surface-variant">Logged Oct 14, 2024 • 15:40 UTC</span>
                                            </div>
                                        </div>
                                        <span class="px-space-sm py-0.5 rounded bg-tertiary-fixed text-on-tertiary-fixed font-code-inline text-label-sm font-bold">2 REQUIRED REMEDIATIONS</span>
                                    </div>
                                    <!-- Blockquote for Instructor feedback -->
                                    <div class="p-space-md rounded bg-surface-container-lowest font-body-md text-body-md text-on-surface">
                                        <p class="leading-relaxed">
                                            “Bounding box IoU is solid (<code class="font-code-inline text-label-sm text-primary font-semibold">mAP50=0.89</code>), but false positives on solder flux splatter remain too high for avionics grade-A tolerance. Augment training set with high-temperature glare transforms and retrain prior to final signoff.”
                                        </p>
                                    </div>
                                    <!-- Specific Action Items Checklist -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-space-sm">
                                        <div class="p-space-sm rounded bg-surface-container-lowest flex items-start gap-space-sm">
                                            <span class="material-symbols-outlined text-primary text-[20px] shrink-0">checklist</span>
                                            <div class="flex flex-col">
                                                <span class="font-label-md text-label-md font-bold text-on-surface">1. Glare Augmentation Integration</span>
                                                <span class="font-body-sm text-body-sm text-on-surface-variant">Add Albumentations RandomGamma &amp; OpticalDistortion simulating PCB solder reflow lighting.</span>
                                            </div>
                                        </div>
                                        <div class="p-space-sm rounded bg-surface-container-lowest flex items-start gap-space-sm">
                                            <span class="material-symbols-outlined text-primary text-[20px] shrink-0">flag</span>
                                            <div class="flex flex-col">
                                                <span class="font-label-md text-label-md font-bold text-on-surface">2. Lower False Discovery Rate &lt; 2%</span>
                                                <span class="font-body-sm text-body-sm text-on-surface-variant">Calibrate confidence threshold from 0.45 to 0.62 in post-processing inference config.</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Bottom Action Buttons for Record 2 -->
                                <div class="flex flex-wrap items-center justify-between gap-space-md pt-space-xs">
                                    <div class="flex items-center gap-space-sm">
                                        <span class="font-code-inline text-label-sm text-on-surface-variant">HASH: cb29810a9128ee...</span>
                                    </div>
                                    <div class="flex items-center gap-space-sm">
                                        <button class="px-space-md py-2 rounded bg-surface-container-high text-primary font-label-md text-label-md font-semibold hover:bg-surface-variant transition-colors flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[16px]">difference</span>
                                            <span>View Diff vs v1.0</span>
                                        </button>
                                        <button class="px-space-md py-2 rounded bg-surface-container-high text-primary font-label-md text-label-md font-semibold hover:bg-surface-variant transition-colors flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[16px]">chat</span>
                                            <span>Chat with Dr. Thorne</span>
                                        </button>
                                        <button class="px-space-md py-2 rounded bg-primary text-on-primary font-label-md text-label-md font-semibold hover:bg-primary-container transition-colors shadow-sm flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[18px]">upload</span>
                                            <span>Prepare Resubmission v2.1</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ================= RECORD 3: TICKET AI-018 ================= -->
                        <div class="bg-surface-container-lowest rounded shadow-sm overflow-hidden transition-all duration-200">
                            <!-- Structural Header -->
                            <div class="p-space-md bg-surface-container-low flex flex-col md:flex-row md:items-center justify-between gap-space-md">
                                <div class="flex items-center gap-space-md flex-wrap">
                                    <div class="flex items-center gap-space-xs">
                                        <span class="w-2.5 h-2.5 rounded-full bg-primary"></span>
                                        <span class="font-headline-md text-headline-md font-bold text-primary">Ticket AI-018</span>
                                    </div>
                                    <span class="px-space-xs py-0.5 rounded bg-surface-container text-on-surface font-code-inline text-label-sm font-semibold">Workforce Escalation Sentiment Router</span>
                                    <span class="px-space-xs py-0.5 rounded bg-surface-container-high text-primary font-code-inline text-label-sm font-bold">VERSION v1.0</span>
                                </div>
                                <div class="flex items-center gap-space-md flex-wrap">
                                    <div class="flex items-center gap-space-xs font-code-inline text-label-sm text-on-surface-variant">
                                        <span class="material-symbols-outlined text-[16px]">schedule</span>
                                        <span>Submitted: Oct 12, 2024 • 09:30 UTC</span>
                                    </div>
                                    <!-- Distinction Badge -->
                                    <div class="flex items-center gap-1.5 px-space-sm py-1 rounded bg-primary text-on-primary font-code-inline text-label-sm font-bold">
                                        <span class="material-symbols-outlined text-[16px]">verified</span>
                                        <span>APPROVED — DISTINCTION</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Main Body -->
                            <div class="p-space-lg flex flex-col gap-space-lg">
                                <!-- Grade & Score Badge Highlights -->
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-space-md">
                                    <div class="p-space-md rounded bg-surface-container-low flex flex-col justify-between">
                                        <span class="font-label-sm text-label-sm text-on-surface-variant uppercase font-code-inline">FINAL SCORE</span>
                                        <div class="flex items-baseline gap-1 py-1">
                                            <span class="font-headline-xl text-headline-xl font-bold text-primary">96</span>
                                            <span class="font-code-inline text-label-md text-on-surface-variant">/ 100</span>
                                        </div>
                                        <span class="font-label-sm text-label-sm text-primary font-code-inline font-bold">TOP TIER COHORT HONORS</span>
                                    </div>
                                    <div class="p-space-md rounded bg-surface-container-low flex flex-col justify-between">
                                        <span class="font-label-sm text-label-sm text-on-surface-variant uppercase font-code-inline">INSTRUCTOR GRADE</span>
                                        <div class="flex items-baseline gap-1 py-1">
                                            <span class="font-headline-xl text-headline-xl font-bold text-primary">98</span>
                                            <span class="font-code-inline text-label-md text-on-surface-variant">/ 100</span>
                                        </div>
                                        <span class="font-label-sm text-label-sm text-on-surface-variant font-code-inline">Signed: Dr. Aris Thorne</span>
                                    </div>
                                    <div class="p-space-md rounded bg-surface-container-low flex flex-col justify-between">
                                        <span class="font-label-sm text-label-sm text-on-surface-variant uppercase font-code-inline">AUTO-EVALUATOR GRADE</span>
                                        <div class="flex items-baseline gap-1 py-1">
                                            <span class="font-headline-xl text-headline-xl font-bold text-primary">94</span>
                                            <span class="font-code-inline text-label-md text-on-surface-variant">/ 100</span>
                                        </div>
                                        <span class="font-label-sm text-label-sm text-on-surface-variant font-code-inline">SYS-04 Automated Batch</span>
                                    </div>
                                    <div class="p-space-md rounded bg-surface-container-low flex flex-col justify-between">
                                        <span class="font-label-sm text-label-sm text-on-surface-variant uppercase font-code-inline">ARTIFACT DISPOSITION</span>
                                        <div class="flex items-baseline gap-1 py-1">
                                            <span class="font-headline-md text-headline-md font-bold text-primary">REGISTRY READY</span>
                                        </div>
                                        <span class="font-label-sm text-label-sm text-on-surface-variant font-code-inline">Exported to SYS-04</span>
                                    </div>
                                </div>
                                <!-- Evaluation Feedback Cards -->
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-space-md">
                                    <!-- Auto-evaluator note -->
                                    <div class="p-space-md rounded bg-surface-container-low flex flex-col gap-space-xs">
                                        <div class="flex items-center gap-space-xs text-primary font-label-md text-label-md font-bold uppercase">
                                            <span class="material-symbols-outlined text-[18px]">memory</span>
                                            <span>Auto-Evaluator SYS-04 Runtime Feedback</span>
                                        </div>
                                        <p class="font-body-md text-body-md text-on-surface">
                                            “DeBERTa-v3 latency 18ms on GPU cluster. Multi-class F1: 0.918 across all 4 severity buckets. Zero anomalous classification boundary slips detected under stress fuzzing.”
                                        </p>
                                    </div>
                                    <!-- Instructor note -->
                                    <div class="p-space-md rounded bg-surface-container-low flex flex-col gap-space-xs">
                                        <div class="flex items-center gap-space-xs text-primary font-label-md text-label-md font-bold uppercase">
                                            <span class="material-symbols-outlined text-[18px]">rate_review</span>
                                            <span>Instructor Lead Commentary</span>
                                        </div>
                                        <p class="font-body-md text-body-md text-on-surface">
                                            “Outstanding threshold calibration and synthetic anonymization audit. The custom token masking pipeline effectively prevented PII leakage into vector embeddings.”
                                        </p>
                                    </div>
                                </div>
                                <!-- Bottom Action Buttons for Record 3 -->
                                <div class="flex flex-wrap items-center justify-between gap-space-md pt-space-xs">
                                    <div class="flex items-center gap-space-sm">
                                        <span class="font-code-inline text-label-sm text-on-surface-variant">HASH: 44dd891ba320...</span>
                                        <span class="text-on-surface-variant font-code-inline text-label-sm">•</span>
                                        <span class="font-code-inline text-label-sm text-primary font-semibold">GPG-SIG: VERIFIED OK</span>
                                    </div>
                                    <div class="flex items-center gap-space-sm">
                                        <button class="px-space-md py-2 rounded bg-surface-container-high text-primary font-label-md text-label-md font-semibold hover:bg-surface-variant transition-colors flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[16px]">file_download</span>
                                            <span>Export Model Card</span>
                                        </button>
                                        <button class="px-space-md py-2 rounded bg-primary text-on-primary font-label-md text-label-md font-semibold hover:bg-primary-container transition-colors shadow-sm flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[18px]">workspace_premium</span>
                                            <span>View Immutable Certificate</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ================= RECORD 4: TICKET AI-031 ================= -->
                        <div class="bg-surface-container-lowest rounded shadow-sm overflow-hidden transition-all duration-200">
                            <!-- Compact / Archive Row Header -->
                            <div class="p-space-md bg-surface-container-low flex flex-col md:flex-row md:items-center justify-between gap-space-md">
                                <div class="flex items-center gap-space-md flex-wrap">
                                    <div class="flex items-center gap-space-xs">
                                        <span class="w-2.5 h-2.5 rounded-full bg-primary"></span>
                                        <span class="font-headline-md text-headline-md font-bold text-primary">Ticket AI-031</span>
                                    </div>
                                    <span class="px-space-xs py-0.5 rounded bg-surface-container text-on-surface font-code-inline text-label-sm font-semibold">Financial Fraud Transaction Scorer</span>
                                    <span class="px-space-xs py-0.5 rounded bg-surface-container text-on-surface font-code-inline text-label-sm font-semibold">VERSION v1.1</span>
                                </div>
                                <div class="flex items-center gap-space-md flex-wrap">
                                    <div class="flex items-center gap-space-xs font-code-inline text-label-sm text-on-surface-variant">
                                        <span class="material-symbols-outlined text-[16px]">schedule</span>
                                        <span>Submitted: Oct 09, 2024 • 16:02 UTC</span>
                                    </div>
                                    <!-- Approved Status Badge -->
                                    <div class="flex items-center gap-1.5 px-space-sm py-1 rounded bg-surface-container-high text-primary font-code-inline text-label-sm font-bold">
                                        <span class="material-symbols-outlined text-[16px]">check</span>
                                        <span>APPROVED (91 / 100)</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Body Compact Summary -->
                            <div class="p-space-md flex flex-col md:flex-row items-start md:items-center justify-between gap-space-md">
                                <div class="flex items-center gap-space-lg flex-wrap">
                                    <div class="flex items-center gap-space-xs">
                                        <span class="material-symbols-outlined text-primary text-[18px]">inventory_2</span>
                                        <span class="font-code-inline text-label-md text-on-surface">fraud_xgboost_ensemble_v1_1.tar.gz</span>
                                        <span class="font-code-inline text-label-sm text-on-surface-variant">(28.4 MB)</span>
                                    </div>
                                    <div class="flex items-center gap-space-xs font-code-inline text-label-sm text-on-surface-variant">
                                        <span>AUC-PR: 0.884</span>
                                        <span>•</span>
                                        <span>Inference: 4.2ms</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-space-sm self-end md:self-auto">
                                    <button class="px-space-md py-1.5 rounded bg-surface-container-high text-primary font-label-md text-label-md font-semibold hover:bg-surface-variant transition-colors flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[16px]">archive</span>
                                        <span>Archive View</span>
                                    </button>
                                    <button class="px-space-md py-1.5 rounded bg-surface-container text-primary font-label-md text-label-md font-semibold hover:bg-surface-container-highest transition-colors flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[16px]">download</span>
                                        <span>Download Artifact</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Comparative Version Matrix (Hidden by default, toggleable via JavaScript) -->
                    <div class="hidden flex-col gap-space-md bg-surface-container-lowest p-space-lg rounded shadow-sm" id="submissionsMatrixContainer">
                        <div class="flex items-center justify-between">
                            <div class="flex flex-col">
                                <span class="font-headline-md text-headline-md font-bold text-primary">Comparative Version Matrix</span>
                                <span class="font-body-sm text-body-sm text-on-surface-variant">Side-by-side telemetry diff and regression analysis across iterations.</span>
                            </div>
                            <span class="font-code-inline text-label-sm text-on-surface-variant">4 Active Scenarios</span>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left font-body-sm text-body-sm">
                                <thead>
                                    <tr class="bg-surface-container-low text-primary font-label-md text-label-md uppercase tracking-wider font-semibold">
                                        <th class="p-space-sm">Ticket ID &amp; Scenario</th>
                                        <th class="p-space-sm">Active Version</th>
                                        <th class="p-space-sm">Latency P99</th>
                                        <th class="p-space-sm">Core Metric</th>
                                        <th class="p-space-sm">Auto Score</th>
                                        <th class="p-space-sm">Instructor Score</th>
                                        <th class="p-space-sm">Delta vs Prior</th>
                                        <th class="p-space-sm text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-surface-container">
                                    <tr class="hover:bg-surface-container-low transition-colors font-code-inline">
                                        <td class="p-space-sm font-bold text-primary">AI-024 Customer Churn</td>
                                        <td class="p-space-sm">v1.2</td>
                                        <td class="p-space-sm">38ms</td>
                                        <td class="p-space-sm">F1: 0.864</td>
                                        <td class="p-space-sm text-primary font-bold">92.0</td>
                                        <td class="p-space-sm text-on-surface-variant">Pending</td>
                                        <td class="p-space-sm text-primary">+4.2% F1</td>
                                        <td class="p-space-sm text-right">
                                            <button class="px-space-xs py-1 rounded bg-surface-container text-primary font-label-sm text-label-sm">Inspect</button>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-surface-container-low transition-colors font-code-inline">
                                        <td class="p-space-sm font-bold text-primary">AI-029 PCB Micro-crack</td>
                                        <td class="p-space-sm">v2.0</td>
                                        <td class="p-space-sm">12ms</td>
                                        <td class="p-space-sm">mAP50: 0.890</td>
                                        <td class="p-space-sm text-primary font-bold">88.5</td>
                                        <td class="p-space-sm text-on-tertiary-fixed font-bold">Changes Req.</td>
                                        <td class="p-space-sm text-on-tertiary-container">+0.03 mAP</td>
                                        <td class="p-space-sm text-right">
                                            <button class="px-space-xs py-1 rounded bg-surface-container text-primary font-label-sm text-label-sm">Inspect</button>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-surface-container-low transition-colors font-code-inline">
                                        <td class="p-space-sm font-bold text-primary">AI-018 Sentiment Router</td>
                                        <td class="p-space-sm">v1.0</td>
                                        <td class="p-space-sm">18ms</td>
                                        <td class="p-space-sm">F1: 0.918</td>
                                        <td class="p-space-sm text-primary font-bold">94.0</td>
                                        <td class="p-space-sm text-primary font-bold">98.0</td>
                                        <td class="p-space-sm text-primary font-bold">Baseline</td>
                                        <td class="p-space-sm text-right">
                                            <button class="px-space-xs py-1 rounded bg-surface-container text-primary font-label-sm text-label-sm">Inspect</button>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-surface-container-low transition-colors font-code-inline">
                                        <td class="p-space-sm font-bold text-primary">AI-031 Financial Fraud</td>
                                        <td class="p-space-sm">v1.1</td>
                                        <td class="p-space-sm">4.2ms</td>
                                        <td class="p-space-sm">PR-AUC: 0.884</td>
                                        <td class="p-space-sm text-primary font-bold">91.0</td>
                                        <td class="p-space-sm text-primary font-bold">91.0</td>
                                        <td class="p-space-sm text-primary">+2.1% AUC</td>
                                        <td class="p-space-sm text-right">
                                            <button class="px-space-xs py-1 rounded bg-surface-container text-primary font-label-sm text-label-sm">Inspect</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Secondary Technical Documentation & Audit SLA Box -->
                    <div class="p-space-md rounded bg-surface-container-low flex flex-col md:flex-row items-center justify-between gap-space-md">
                        <div class="flex items-center gap-space-md">
                            <span class="material-symbols-outlined text-primary text-[28px] shrink-0">policy</span>
                            <div class="flex flex-col">
                                <span class="font-label-md text-label-md font-bold text-primary uppercase">VOSTOKPRIBOR ARTIFACT REPRODUCTION MANDATE</span>
                                <span class="font-body-sm text-body-sm text-on-surface-variant">All committed neural nets are isolated in microVM containers with fixed seed kernels to guarantee zero evaluation non-determinism.</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-space-sm shrink-0">
                            <a class="font-label-sm text-label-sm font-code-inline text-primary hover:underline" href="#">SOP-AI-VAL-8812 →</a>
                            <span class="text-outline-variant">|</span>
                            <a class="font-label-sm text-label-sm font-code-inline text-primary hover:underline" href="#">Dual Review Rubrics →</a>
                        </div>
                    </div>
                </div>
                <!-- Interactive Modal: Submit New Artifact (Hidden by default, triggered via JS) -->
                <div class="fixed inset-0 z-50 bg-inverse-surface/40 backdrop-blur-sm hidden items-center justify-center p-space-md" id="submitModal">
                    <div class="bg-surface-container-lowest rounded shadow-xl w-full max-w-2xl overflow-hidden flex flex-col max-h-[90vh]">
                        <!-- Modal Header -->
                        <div class="p-space-md bg-surface-container-low flex items-center justify-between">
                            <div class="flex items-center gap-space-sm">
                                <div class="w-6 h-6 rounded bg-primary text-on-primary flex items-center justify-center font-label-sm text-label-sm font-bold">
                                    VK
                                </div>
                                <span class="font-headline-md text-headline-md font-bold text-primary">Submit Artifact for Automated Evaluation</span>
                            </div>
                            <button class="text-on-surface-variant hover:text-on-surface" id="closeSubmitModalBtn">
                                <span class="material-symbols-outlined text-[20px]">close</span>
                            </button>
                        </div>
                        <!-- Modal Body -->
                        <div class="p-space-lg flex flex-col gap-space-md overflow-y-auto">
                            <div class="flex flex-col gap-space-xs">
                                <label class="font-label-sm text-label-sm uppercase font-semibold text-on-surface">Target Ticket &amp; Scenario</label>
                                <select class="p-space-sm rounded bg-surface-container-low font-body-md text-body-md text-on-surface focus:outline-none">
                                    <option value="AI-029">AI-029: Manufacturing Micro-crack Vision Inspection (Revision 2.1)</option>
                                    <option value="AI-024">AI-024: Customer Churn Drift Mitigation (Revision 1.3)</option>
                                    <option value="AI-032">AI-032: High-Altitude Atmospheric Sensor Calibration (Initial Submission)</option>
                                </select>
                            </div>
                            <div class="flex flex-col gap-space-xs">
                                <label class="font-label-sm text-label-sm uppercase font-semibold text-on-surface">Submission Version Tag</label>
                                <input class="p-space-sm rounded bg-surface-container-low font-code-inline text-body-md text-on-surface focus:outline-none" type="text" value="v2.1" />
                            </div>
                            <!-- File Drop Target Area -->
                            <div class="p-space-xl rounded bg-surface-container-low flex flex-col items-center justify-center text-center gap-space-sm cursor-pointer hover:bg-surface-container transition-colors">
                                <div class="w-12 h-12 rounded-full bg-surface-container flex items-center justify-center text-primary">
                                    <span class="material-symbols-outlined text-[28px]">cloud_upload</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-label-md text-label-md font-bold text-primary">Drag &amp; drop serialized models or notebooks here</span>
                                    <span class="font-body-sm text-body-sm text-on-surface-variant">Accepts .ONNX, .PT, .IPYNB, .TAR.GZ (Max: 500 MB per file)</span>
                                </div>
                                <button class="px-space-md py-1.5 rounded bg-surface-container text-primary font-label-sm text-label-sm font-semibold mt-space-xs">
                                    Browse Local File Explorer
                                </button>
                            </div>
                            <!-- Verification Checklist -->
                            <div class="flex flex-col gap-space-xs pt-space-xs">
                                <label class="font-label-sm text-label-sm uppercase font-semibold text-on-surface">Pre-dispatch Sanity Checklist</label>
                                <div class="flex items-center gap-space-xs">
                                    <input checked="" class="accent-primary" id="chk1" type="checkbox" />
                                    <label class="font-body-sm text-body-sm text-on-surface" for="chk1">Inference entry-point complies with <code>predict(batch: Tensor) -&gt; Tensor</code> interface.</label>
                                </div>
                                <div class="flex items-center gap-space-xs">
                                    <input checked="" class="accent-primary" id="chk2" type="checkbox" />
                                    <label class="font-body-sm text-body-sm text-on-surface" for="chk2">Random seeds locked to <code>42</code> across PyTorch / Scikit-Learn pipelines.</label>
                                </div>
                                <div class="flex items-center gap-space-xs">
                                    <input class="accent-primary" id="chk3" type="checkbox" />
                                    <label class="font-body-sm text-body-sm text-on-surface" for="chk3">Attached glare augmentation configuration addressing Dr. Thorne's review feedback.</label>
                                </div>
                            </div>
                        </div>
                        <!-- Modal Footer -->
                        <div class="p-space-md bg-surface-container-low flex items-center justify-between">
                            <span class="font-code-inline text-label-sm text-on-surface-variant">CANARY TARGET: SYS-04</span>
                            <div class="flex items-center gap-space-sm">
                                <button class="px-space-md py-2 rounded bg-surface-container text-primary font-label-md text-label-md font-semibold hover:bg-surface-container-high transition-colors" id="cancelModalBtn">
                                    Cancel
                                </button>
                                <button class="px-space-md py-2 rounded bg-primary text-on-primary font-label-md text-label-md font-semibold hover:bg-primary-container transition-colors shadow-sm" id="confirmSubmitBtn">
                                    Dispatch to Evaluator
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Interactive JavaScript logic for view switches and modal handling -->
            </div>
        </main>
    </div>
    <script src="js/main.js"></script>
<!-- Submit New Artifact Modal -->
<div id="submitModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-surface-container-lowest rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-outline-variant flex flex-col gap-4">
        <div class="flex items-center justify-between pb-3 border-b border-surface-container">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-2xl">cloud_upload</span>
                <h3 class="font-headline-md font-bold text-on-surface">Submit Deliverable Artifact</h3>
            </div>
            <button type="button" onclick="document.getElementById('submitModal').classList.add('hidden')" class="text-on-surface-variant hover:text-on-surface">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <?php if (empty($assignedTickets)): ?>
            <div class="p-4 rounded-xl bg-amber-50 text-amber-900 text-xs font-mono">
                No active tickets available for submission. You must first have an assigned operational ticket.
            </div>
        <?php else: ?>
            <form method="POST" class="flex flex-col gap-3 font-sans">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(\App\Core\Csrf::getToken()) ?>" />
                <input type="hidden" name="action" value="create_submission">
                
                <div class="flex flex-col gap-1">
                    <label class="font-label-sm font-semibold text-on-surface-variant">Select Assigned Ticket:</label>
                    <select name="ticket_id" required class="p-2 rounded-lg border border-outline-variant bg-surface-container-low text-xs font-mono">
                        <?php foreach ($assignedTickets as $at): ?>
                            <option value="<?= $at['id'] ?>"><?= htmlspecialchars($at['ticket_code']) ?> - <?= htmlspecialchars($at['title']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="flex flex-col gap-1">
                    <label class="font-label-sm font-semibold text-on-surface-variant">Methodology Notes &amp; Defense:</label>
                    <textarea name="notes" rows="4" required placeholder="Describe model metrics, cross-validation setup, hyperparameter decisions..." class="p-2 rounded-lg border border-outline-variant bg-surface-container-low text-xs"></textarea>
                </div>

                <div class="flex items-center justify-end gap-2 pt-2 border-t border-surface-container">
                    <button type="button" onclick="document.getElementById('submitModal').classList.add('hidden')" class="px-4 py-2 rounded-lg text-on-surface-variant text-xs font-mono hover:bg-surface-container">Cancel</button>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-primary text-white text-xs font-mono font-bold hover:bg-primary-container transition-colors">Submit Candidate Package</button>
                </div>
            </form>
        <?php endif; ?>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('openSubmitModalBtn');
    if (btn) {
        btn.addEventListener('click', function() {
            document.getElementById('submitModal').classList.remove('hidden');
        });
    }
});
</script>
</body>

</html>