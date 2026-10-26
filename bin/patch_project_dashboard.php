<?php
$file = __DIR__ . '/../AI Project Management/Dashboard.php';
$content = file_get_contents($file);

$topPhp = <<<'PHP'
<?php
require_once __DIR__ . '/../app/bootstrap.php';

use App\Middleware\AuthenticationMiddleware;
use App\Core\Database;
use App\Core\Auth;

$currentUser = AuthenticationMiddleware::handle();
$db = Database::getInstance();

// Load dynamic data for student/admin
$isStudent = ($currentUser['role'] === 'STUDENT');

if ($isStudent) {
    $assignedTickets = $db->fetchAll("
        SELECT t.*, s.title AS scenario_title, s.code AS scenario_code 
        FROM tickets t 
        JOIN ticket_assignments ta ON t.id = ta.ticket_id 
        LEFT JOIN scenarios s ON t.scenario_id = s.id 
        WHERE ta.student_id = :sid 
        ORDER BY t.created_at DESC
    ", ['sid' => $currentUser['id']]);

    $submissions = $db->fetchAll("
        SELECT * FROM submissions WHERE student_id = :sid ORDER BY created_at DESC
    ", ['sid' => $currentUser['id']]);

    $datasetCount = (int)$db->fetchValue("SELECT COUNT(*) FROM dataset_assignments WHERE student_id = :sid", ['sid' => $currentUser['id']]);
    $notebookCount = (int)$db->fetchValue("SELECT COUNT(*) FROM notebooks WHERE student_id = :sid", ['sid' => $currentUser['id']]);
    $modelCount = (int)$db->fetchValue("SELECT COUNT(*) FROM models WHERE student_id = :sid", ['sid' => $currentUser['id']]);
} else {
    $assignedTickets = $db->fetchAll("
        SELECT t.*, s.title AS scenario_title, s.code AS scenario_code 
        FROM tickets t 
        LEFT JOIN scenarios s ON t.scenario_id = s.id 
        ORDER BY t.created_at DESC
    ");

    $submissions = $db->fetchAll("SELECT * FROM submissions ORDER BY created_at DESC");
    $datasetCount = (int)$db->fetchValue("SELECT COUNT(*) FROM datasets");
    $notebookCount = (int)$db->fetchValue("SELECT COUNT(*) FROM notebooks");
    $modelCount = (int)$db->fetchValue("SELECT COUNT(*) FROM models");
}

$ticketCount = count($assignedTickets);
$activeTickets = array_filter($assignedTickets, fn($t) => in_array($t['status'], ['ASSIGNED', 'IN_PROGRESS']));
$submissionCount = count($submissions);
$approvedCount = count(array_filter($submissions, fn($s) => $s['status'] === 'APPROVED'));
?>
PHP;

if (strpos($content, 'AuthenticationMiddleware::handle()') === false) {
    $content = $topPhp . "\n" . $content;
}

// Replace header user name and identifier
$content = preg_replace(
    '/<div class="flex flex-col text-right hidden sm:flex"><span class="font-label-md text-label-md font-semibold text-on-surface">Alex Chen<\/span><span class="font-label-sm text-label-sm text-on-surface-variant font-code-inline">VK-88219<\/span><\/div>/',
    '<div class="flex flex-col text-right hidden sm:flex"><span class="font-label-md text-label-md font-semibold text-on-surface"><?= htmlspecialchars($currentUser[\'full_name\']) ?></span><span class="font-label-sm text-label-sm text-on-surface-variant font-code-inline"><?= htmlspecialchars($currentUser[\'identifier\'] ?? $currentUser[\'email\']) ?></span></div>',
    $content
);

// Replace Welcome heading
$content = preg_replace(
    '/Welcome back, Eng\. Alex Chen/',
    'Welcome, <?= htmlspecialchars($currentUser[\'full_name\']) ?>',
    $content
);

// Replace hardcoded metrics
$content = preg_replace('/<span class="font-headline-lg text-headline-lg font-bold text-on-surface font-code-inline">4<\/span>/', '<span class="font-headline-lg text-headline-lg font-bold text-on-surface font-code-inline"><?= $ticketCount ?></span>', $content);
$content = preg_replace('/<span class="font-headline-lg text-headline-lg font-bold text-on-surface font-code-inline">3<\/span>/', '<span class="font-headline-lg text-headline-lg font-bold text-on-surface font-code-inline"><?= count($activeTickets) ?></span>', $content);
$content = preg_replace('/<span class="font-headline-lg text-headline-lg font-bold text-on-surface font-code-inline">12<\/span>/', '<span class="font-headline-lg text-headline-lg font-bold text-on-surface font-code-inline"><?= $submissionCount ?></span>', $content);

file_put_contents($file, $content);
echo "Dashboard.php successfully patched with dynamic metrics and session auth.\n";
