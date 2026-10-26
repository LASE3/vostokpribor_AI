<?php
$file = __DIR__ . '/../AI Project Management/StudentProfile.php';
$content = file_get_contents($file);

$topPhp = <<<'PHP'
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
PHP;

if (strpos($content, 'AuthenticationMiddleware::handle()') === false) {
    $content = $topPhp . "\n" . $content;
}

// Replace Header info
$content = preg_replace(
    '/<div class="flex flex-col text-right hidden sm:flex"><span class="font-label-md text-label-md font-semibold text-on-surface">Alex Chen<\/span><span class="font-label-sm text-label-sm text-on-surface-variant font-code-inline">VK-88219<\/span><\/div>/',
    '<div class="flex flex-col text-right hidden sm:flex"><span class="font-label-md text-label-md font-semibold text-on-surface"><?= htmlspecialchars($currentUser[\'full_name\']) ?></span><span class="font-label-sm text-label-sm text-on-surface-variant font-code-inline"><?= htmlspecialchars($currentUser[\'identifier\'] ?? $currentUser[\'email\']) ?></span></div>',
    $content
);

// Replace Cadet Dossier Badge
$content = preg_replace(
    '/CADET DOSSIER \/\/ VK-88219/',
    'CADET DOSSIER // <?= htmlspecialchars($profileUser[\'identifier\'] ?? \'CADET\') ?>',
    $content
);

// Replace Subline
$content = preg_replace(
    '/Industrial AI verification record, cohort performance index, and competence telemetry for Eng\. Alex Chen\./',
    'Industrial AI verification record and operational telemetry for Eng. <?= htmlspecialchars($profileUser[\'full_name\']) ?> (<?= htmlspecialchars($profileUser[\'role\']) ?>).',
    $content
);

// Replace Profile Name & Details in card
$content = preg_replace('/<h2 class="font-headline-lg font-bold text-on-surface">Alex Chen<\/h2>/', '<h2 class="font-headline-lg font-bold text-on-surface"><?= htmlspecialchars($profileUser[\'full_name\']) ?></h2>', $content);
$content = preg_replace('/alex\.chen@range\.vostokpribor\.space/', '<?= htmlspecialchars($profileUser[\'email\']) ?>', $content);
$content = preg_replace('/VK-88219/', '<?= htmlspecialchars($profileUser[\'identifier\'] ?? \'CADET-RANGE\') ?>', $content);
$content = preg_replace('/COHORT 24-B/', '<?= htmlspecialchars($profileUser[\'cohort\'] ?? \'GENERAL-RANGE\') ?>', $content);

// Replace stat numbers
$content = preg_replace('/<span class="font-headline-md text-headline-md font-bold text-on-surface font-code-inline">12<\/span>/', '<span class="font-headline-md text-headline-md font-bold text-on-surface font-code-inline"><?= $ticketCount ?></span>', $content);
$content = preg_replace('/<span class="font-headline-md text-headline-md font-bold text-on-surface font-code-inline">8<\/span>/', '<span class="font-headline-md text-headline-md font-bold text-on-surface font-code-inline"><?= $approvedCount ?></span>', $content);
$content = preg_replace('/<span class="font-headline-md text-headline-md font-bold text-on-surface font-code-inline">94\.2%<\/span>/', '<span class="font-headline-md text-headline-md font-bold text-on-surface font-code-inline"><?= $submissionCount > 0 ? round(($approvedCount / $submissionCount) * 100, 1) . \'%\' : \'100%\' ?></span>', $content);

file_put_contents($file, $content);
echo "StudentProfile.php patched with real student profile data.\n";
