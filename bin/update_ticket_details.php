<?php
// Script to wire real backend logic into AI Project Management/TicketDetails.php
$file = __DIR__ . '/../AI Project Management/TicketDetails.php';
$content = file_get_contents($file);

// Replace header with PHP bootstrap and authentication
$topPhp = <<<'PHP'
<?php
require_once __DIR__ . '/../app/bootstrap.php';

use App\Middleware\AuthenticationMiddleware;
use App\Core\Database;
use App\Core\Auth;

$currentUser = AuthenticationMiddleware::handle();
$db = Database::getInstance();

$ticketId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$ticketCode = isset($_GET['code']) ? trim($_GET['code']) : '';

// Handle comment POST
$commentError = '';
$commentSuccess = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_comment') {
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
            $db->insert("INSERT INTO ticket_comments (ticket_id, user_id, comment, created_at) VALUES (:tid, :uid, :comment, NOW())", [
                'tid' => $targetTicketId,
                'uid' => $currentUser['id'],
                'comment' => $commentText
            ]);
            $commentSuccess = 'Comment logged successfully.';
            $ticketId = $targetTicketId;
        } else {
            $commentError = 'Unauthorized to comment on this ticket.';
        }
    }
}

// Handle submission POST
$submissionError = '';
$submissionSuccess = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'submit_deliverable') {
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
            $subId = $db->insert(
                "INSERT INTO submissions (submission_code, ticket_id, student_id, iteration, notes, status, created_at, updated_at) 
                 VALUES (:code, :tid, :sid, :iter, :notes, 'SUBMITTED', NOW(), NOW())",
                [
                    'code' => $subCode,
                    'tid' => $targetTicketId,
                    'sid' => $currentUser['id'],
                    'iter' => $iterCount + 1,
                    'notes' => $notes ?: 'Deliverable package submitted from Range Terminal.'
                ]
            );

            // Update ticket status to SUBMITTED if in progress
            $db->update("UPDATE tickets SET status = 'SUBMITTED', updated_at = NOW() WHERE id = :id AND status IN ('ASSIGNED', 'IN_PROGRESS')", ['id' => $targetTicketId]);

            // Log audit
            $db->insert("INSERT INTO audit_logs (user_id, action, resource_type, resource_id, outcome, ip_address, user_agent, details_json, created_at)
                         VALUES (:uid, 'SUBMISSION_CREATE', 'SUBMISSION', :rid, 'SUCCESS', :ip, :ua, :details, NOW())", [
                'uid' => $currentUser['id'],
                'rid' => $subId,
                'ip' => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1',
                'ua' => $_SERVER['HTTP_USER_AGENT'] ?? 'CLI',
                'details' => json_encode(['ticket_id' => $targetTicketId, 'submission_code' => $subCode])
            ]);

            $submissionSuccess = 'Deliverable submitted for dual-pipeline evaluation. Reference: ' . $subCode;
            $ticketId = $targetTicketId;
        } else {
            $submissionError = 'You are not assigned to this operational ticket.';
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
PHP;

// Check if already injected
if (strpos($content, 'AuthenticationMiddleware::handle()') === false) {
    $content = $topPhp . "\n" . $content;
}

echo "Top PHP logic injected.\n";
file_put_contents($file, $content);
