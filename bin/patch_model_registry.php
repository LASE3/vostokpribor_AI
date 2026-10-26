<?php
// Patch Model Registry & Deployment pages with real auth & dynamic queries
$files = [
    __DIR__ . '/../Model Registry & Deployment/dashboard.php',
    __DIR__ . '/../Model Registry & Deployment/ModelRegistry.php',
    __DIR__ . '/../Model Registry & Deployment/ValidationPipeline.php',
    __DIR__ . '/../Model Registry & Deployment/ValidationReports.php',
    __DIR__ . '/../Model Registry & Deployment/DeployedEndpoints.php',
    __DIR__ . '/../Model Registry & Deployment/DeploymentConfig.php'
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
    $models = $db->fetchAll("
        SELECT m.*, mv.version AS version_name, mv.file_size, mv.checksum_sha256, mv.metrics 
        FROM models m 
        LEFT JOIN model_versions mv ON m.id = mv.model_id 
        WHERE m.student_id = :sid 
        ORDER BY m.created_at DESC
    ", ['sid' => $currentUser['id']]);

    $validations = $db->fetchAll("
        SELECT vr.*, m.name AS model_name, m.model_code 
        FROM validation_runs vr 
        JOIN models m ON vr.model_id = m.id 
        WHERE vr.requested_by = :sid 
        ORDER BY vr.created_at DESC
    ", ['sid' => $currentUser['id']]);

    $deployments = $db->fetchAll("
        SELECT d.*, m.name AS model_name, m.model_code, mv.version AS model_version 
        FROM deployments d 
        JOIN model_versions mv ON d.model_version_id = mv.id 
        JOIN models m ON mv.model_id = m.id 
        WHERE m.student_id = :sid 
        ORDER BY d.deployed_at DESC
    ", ['sid' => $currentUser['id']]);
} else {
    $models = $db->fetchAll("
        SELECT m.*, mv.version AS version_name, mv.file_size, mv.checksum_sha256, mv.metrics, u.full_name AS student_name 
        FROM models m 
        LEFT JOIN model_versions mv ON m.id = mv.model_id 
        LEFT JOIN users u ON m.student_id = u.id 
        ORDER BY m.created_at DESC
    ");

    $validations = $db->fetchAll("
        SELECT vr.*, m.name AS model_name, m.model_code, u.full_name AS student_name 
        FROM validation_runs vr 
        JOIN models m ON vr.model_id = m.id 
        LEFT JOIN users u ON vr.requested_by = u.id 
        ORDER BY vr.created_at DESC
    ");

    $deployments = $db->fetchAll("
        SELECT d.*, m.name AS model_name, m.model_code, mv.version AS model_version, u.full_name AS student_name 
        FROM deployments d 
        JOIN model_versions mv ON d.model_version_id = mv.id 
        JOIN models m ON mv.model_id = m.id 
        LEFT JOIN users u ON m.student_id = u.id 
        ORDER BY d.deployed_at DESC
    ");
}

$modelCount = count($models);
$validatedCount = count(array_filter($models, fn($m) => in_array($m['status'], ['VALIDATION_PASSED', 'APPROVED', 'DEPLOYED'])));
$deploymentCount = count($deployments);
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
        '/<div class="hidden 2xl:flex flex-col text-left"><span class="font-label-md text-label-md font-semibold text-on-surface leading-none">Cadet E\. Vance<\/span><span class="font-code-sm text-code-sm text-on-surface-variant leading-none mt-0\.5">VP-8820<\/span><\/div>/',
        '<div class="hidden 2xl:flex flex-col text-left"><span class="font-label-md text-label-md font-semibold text-on-surface leading-none"><?= htmlspecialchars($currentUser[\'full_name\']) ?></span><span class="font-code-sm text-code-sm text-on-surface-variant leading-none mt-0.5"><?= htmlspecialchars($currentUser[\'identifier\'] ?? $currentUser[\'email\']) ?></span></div>',
        $content
    );

    file_put_contents($file, $content);
    echo "Patched " . basename($file) . "\n";
}
