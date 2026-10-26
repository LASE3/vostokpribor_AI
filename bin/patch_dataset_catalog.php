<?php
$file = __DIR__ . '/../Data Center/DatasetCatalog.php';
$content = file_get_contents($file);

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
    $datasets = $db->fetchAll("
        SELECT d.*, s.title AS scenario_title 
        FROM datasets d 
        JOIN dataset_assignments da ON d.id = da.dataset_id 
        LEFT JOIN scenarios s ON d.scenario_id = s.id 
        WHERE da.student_id = :sid 
        ORDER BY d.created_at DESC
    ", ['sid' => $currentUser['id']]);
} else {
    $datasets = $db->fetchAll("
        SELECT d.*, s.title AS scenario_title 
        FROM datasets d 
        LEFT JOIN scenarios s ON d.scenario_id = s.id 
        ORDER BY d.created_at DESC
    ");
}

$datasetCount = count($datasets);
$totalSizeBytes = array_sum(array_column($datasets, 'file_size'));
$totalSizeMB = round($totalSizeBytes / (1024 * 1024), 2);
$totalRows = array_sum(array_column($datasets, 'row_count'));
?>
PHP;

if (strpos($content, 'AuthenticationMiddleware::handle()') === false) {
    $content = $topPhp . "\n" . $content;
}

// Replace header user info
$content = preg_replace(
    '/<div class="hidden lg:flex flex-col text-right"><span class="font-label-md text-label-md text-on-surface">Cadet Eng\. K\. Chen<\/span><span class="font-code-sm text-code-sm text-secondary">ID: VP-88204 • L2 CLEARANCE<\/span><\/div>/',
    '<div class="hidden lg:flex flex-col text-right"><span class="font-label-md text-label-md text-on-surface"><?= htmlspecialchars($currentUser[\'full_name\']) ?></span><span class="font-code-sm text-code-sm text-secondary"><?= htmlspecialchars($currentUser[\'identifier\'] ?? $currentUser[\'email\']) ?> • <?= htmlspecialchars($currentUser[\'role\']) ?></span></div>',
    $content
);

// Replace Active Inventory Stat Card
$content = preg_replace(
    '/<span class="font-headline-lg text-headline-lg text-primary">42 Datasets<\/span>/',
    '<span class="font-headline-lg text-headline-lg text-primary"><?= $datasetCount ?> Datasets</span>',
    $content
);
$content = preg_replace(
    '/<span class="font-code-sm text-code-sm text-secondary">38\.4 GB Partitioned<\/span>/',
    '<span class="font-code-sm text-code-sm text-secondary"><?= $totalSizeMB ?> MB Stored</span>',
    $content
);

// Replace Table Container with dynamic datasets
$oldTablePattern = '/<!-- Table Body: Data Assets -->[\s\S]*?<\/tbody>/';
$newTable = <<<'HTML'
<!-- Table Body: Data Assets -->
<tbody>
    <?php if (empty($datasets)): ?>
        <tr>
            <td colspan="7" class="p-12 text-center">
                <div class="flex flex-col items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-4xl text-outline">database</span>
                    <span class="font-headline-sm font-bold text-on-surface">No Authorized Datasets Found</span>
                    <p class="font-body-sm text-on-surface-variant max-w-md">
                        <?= $isStudent ? 'Your cadet station does not have any assigned datasets. Assigned datasets will appear here automatically when provisioned by an instructor in SYS-AI-05.' : 'No master datasets uploaded yet. Use the Data Center upload tool or AI SOC to ingest telemetry packages.' ?>
                    </p>
                </div>
            </td>
        </tr>
    <?php else: ?>
        <?php foreach ($datasets as $ds): ?>
            <tr class="hover:bg-surface-container-low transition-colors border-b border-surface-container">
                <td class="p-4">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded bg-primary-container text-white flex items-center justify-center font-bold text-xs">
                            <span class="material-symbols-outlined text-[18px]">table_chart</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-bold text-primary font-mono text-sm"><?= htmlspecialchars($ds['name']) ?></span>
                            <span class="text-xs text-on-surface-variant"><?= htmlspecialchars($ds['code']) ?> • <?= htmlspecialchars($ds['scenario_title'] ?? 'General') ?></span>
                        </div>
                    </div>
                </td>
                <td class="p-4 font-mono text-xs text-on-surface font-semibold">
                    <span class="px-2 py-0.5 rounded bg-surface-container text-primary uppercase font-bold"><?= htmlspecialchars($ds['format']) ?></span>
                </td>
                <td class="p-4 font-mono text-xs text-on-surface">
                    <?= number_format($ds['row_count']) ?>
                </td>
                <td class="p-4 font-mono text-xs text-on-surface">
                    <?= $ds['column_count'] ?> cols
                </td>
                <td class="p-4 font-mono text-xs text-on-surface">
                    <?= round($ds['file_size'] / (1024 * 1024), 2) ?> MB
                </td>
                <td class="p-4 font-mono text-xs text-on-surface-variant">
                    <?= date('M d, Y', strtotime($ds['created_at'])) ?>
                </td>
                <td class="p-4 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <a href="../api/v1/datasets/<?= $ds['id'] ?>/download" class="px-3 py-1 rounded bg-primary text-white font-mono text-xs font-semibold hover:bg-primary-container transition-colors inline-flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]">download</span>
                            <span>Download</span>
                        </a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</tbody>
HTML;

$content = preg_replace($oldTablePattern, $newTable, $content, 1);

file_put_contents($file, $content);
echo "DatasetCatalog.php updated with dynamic database data.\n";
