<?php
$file = __DIR__ . '/../Data Center/MyDataSet.php';
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
    $assignedDatasets = $db->fetchAll("
        SELECT d.*, s.title AS scenario_title, da.created_at AS assigned_date 
        FROM datasets d 
        JOIN dataset_assignments da ON d.id = da.dataset_id 
        LEFT JOIN scenarios s ON d.scenario_id = s.id 
        WHERE da.student_id = :sid 
        ORDER BY da.created_at DESC
    ", ['sid' => $currentUser['id']]);

    $processedDatasets = $db->fetchAll("
        SELECT pd.*, d.name AS source_name 
        FROM processed_datasets pd 
        LEFT JOIN datasets d ON pd.source_dataset_id = d.id 
        WHERE pd.student_id = :sid 
        ORDER BY pd.created_at DESC
    ", ['sid' => $currentUser['id']]);
} else {
    $assignedDatasets = $db->fetchAll("
        SELECT d.*, s.title AS scenario_title, d.created_at AS assigned_date 
        FROM datasets d 
        LEFT JOIN scenarios s ON d.scenario_id = s.id 
        ORDER BY d.created_at DESC
    ");

    $processedDatasets = $db->fetchAll("
        SELECT pd.*, d.name AS source_name 
        FROM processed_datasets pd 
        LEFT JOIN datasets d ON pd.source_dataset_id = d.id 
        ORDER BY pd.created_at DESC
    ");
}
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

file_put_contents($file, $content);
echo "MyDataSet.php updated successfully.\n";
