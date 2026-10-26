<?php
// Patch Data Center auxiliary pages with auth and real user info
$files = [
    __DIR__ . '/../Data Center/dashboard.php',
    __DIR__ . '/../Data Center/UploadProcessedData.php',
    __DIR__ . '/../Data Center/DataProfilingAndQuality.php',
    __DIR__ . '/../Data Center/QueryWorkspace.php',
    __DIR__ . '/../Data Center/RecentActivityAndAudit.php',
];

$topPhp = <<<'PHP'
<?php
require_once __DIR__ . '/../app/bootstrap.php';

use App\Middleware\AuthenticationMiddleware;
use App\Core\Database;
use App\Core\Auth;

$currentUser = AuthenticationMiddleware::handle();
$db = Database::getInstance();

$isStudent = ($currentUser['role'] === 'STUDENT');

if ($isStudent) {
    $assignedDatasets = $db->fetchAll("
        SELECT d.* FROM datasets d 
        JOIN dataset_assignments da ON d.id = da.dataset_id 
        WHERE da.student_id = :sid ORDER BY d.created_at DESC
    ", ['sid' => $currentUser['id']]);
    $processedCount = (int)$db->fetchValue("SELECT COUNT(*) FROM processed_datasets WHERE student_id = :sid", ['sid' => $currentUser['id']]);
} else {
    $assignedDatasets = $db->fetchAll("SELECT * FROM datasets ORDER BY created_at DESC");
    $processedCount = (int)$db->fetchValue("SELECT COUNT(*) FROM processed_datasets");
}

$datasetCount = count($assignedDatasets);
$totalSizeBytes = array_sum(array_column($assignedDatasets, 'file_size'));
$totalSizeMB = round($totalSizeBytes / (1024 * 1024), 2);
?>
PHP;

foreach ($files as $file) {
    if (!file_exists($file)) continue;
    $content = file_get_contents($file);

    if (strpos($content, 'AuthenticationMiddleware::handle()') === false) {
        $content = $topPhp . "\n" . $content;
    }

    // Replace header user name and identifier
    $content = preg_replace(
        '/<div class="hidden lg:flex flex-col text-right"><span class="font-label-md text-label-md text-on-surface">Cadet Eng\. K\. Chen<\/span><span class="font-code-sm text-code-sm text-secondary">ID: VP-88204 • L2 CLEARANCE<\/span><\/div>/',
        '<div class="hidden lg:flex flex-col text-right"><span class="font-label-md text-label-md text-on-surface"><?= htmlspecialchars($currentUser[\'full_name\']) ?></span><span class="font-code-sm text-code-sm text-secondary"><?= htmlspecialchars($currentUser[\'identifier\'] ?? $currentUser[\'email\']) ?> • <?= htmlspecialchars($currentUser[\'role\']) ?></span></div>',
        $content
    );

    file_put_contents($file, $content);
    echo "Patched " . basename($file) . "\n";
}
