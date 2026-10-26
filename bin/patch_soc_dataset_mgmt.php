<?php
// Patch DatasetManagement.php to handle real dataset uploads and assignments
$file = __DIR__ . '/../AI Operations Center (AI SOC)/DatasetManagement.php';
$content = file_get_contents($file);

$topPhp = <<<'PHP'
<?php
// VOSTOKPRIBOR AI • SYS-AI-05: AI Operations Center (AI SOC) - Dataset Management
require_once __DIR__ . '/../app/bootstrap.php';

use App\Middleware\AuthorizationMiddleware;
use App\Core\Database;
use App\Core\Auth;

AuthorizationMiddleware::requireAdmin();
$currentUser = Auth::user();
$db = Database::getInstance();

$msg = '';
$err = '';

// Handle Upload New Dataset POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'upload_dataset') {
    $name = trim($_POST['name'] ?? '');
    $code = trim($_POST['code'] ?? '');
    $format = strtoupper(trim($_POST['format'] ?? 'CSV'));
    $desc = trim($_POST['description'] ?? '');
    $scenarioId = !empty($_POST['scenario_id']) ? (int)$_POST['scenario_id'] : null;

    if (empty($name) || empty($code)) {
        $err = "Dataset Name and Code are required.";
    } elseif (!isset($_FILES['dataset_file']) || $_FILES['dataset_file']['error'] !== UPLOAD_ERR_OK) {
        $err = "A valid dataset file must be provided.";
    } else {
        $file = $_FILES['dataset_file'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, ['csv', 'json', 'parquet', 'txt'])) {
            $err = "Unsupported file format (allowed: CSV, JSON, Parquet).";
        } else {
            $storageDir = __DIR__ . '/../storage/private/datasets';
            if (!is_dir($storageDir)) {
                mkdir($storageDir, 0755, true);
            }
            $safeName = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $file['name']);
            $targetPath = $storageDir . '/' . time() . '_' . $safeName;
            if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                $fileSize = filesize($targetPath);
                $checksum = hash_file('sha256', $targetPath);
                $rowCount = 0;
                $colCount = 0;

                if ($ext === 'csv') {
                    if (($handle = fopen($targetPath, "r")) !== false) {
                        $header = fgetcsv($handle);
                        if ($header) $colCount = count($header);
                        while (fgets($handle) !== false) $rowCount++;
                        fclose($handle);
                    }
                } elseif ($ext === 'json') {
                    $jsonContent = json_decode(file_get_contents($targetPath), true);
                    if (is_array($jsonContent)) {
                        $rowCount = count($jsonContent);
                        if ($rowCount > 0 && is_array($jsonContent[0])) {
                            $colCount = count($jsonContent[0]);
                        }
                    }
                }

                $dsId = $db->insert(
                    "INSERT INTO datasets (code, name, description, format, file_path, file_size, checksum_sha256, row_count, column_count, is_master, version, scenario_id, uploaded_by, created_at, updated_at)
                     VALUES (:code, :name, :desc, :format, :path, :size, :chk, :rows, :cols, 1, 'v1.0', :scen, :uid, NOW(), NOW())",
                    [
                        'code' => $code,
                        'name' => $name,
                        'desc' => $desc,
                        'format' => $format,
                        'path' => $targetPath,
                        'size' => $fileSize,
                        'chk' => $checksum,
                        'rows' => $rowCount,
                        'cols' => $colCount,
                        'scen' => $scenarioId,
                        'uid' => $currentUser['id']
                    ]
                );

                $db->insert("INSERT INTO audit_logs (user_id, action, resource_type, resource_id, outcome, ip_address, user_agent, details_json, created_at)
                             VALUES (:uid, 'DATASET_UPLOAD', 'DATASET', :rid, 'SUCCESS', :ip, :ua, :details, NOW())", [
                    'uid' => $currentUser['id'],
                    'rid' => $dsId,
                    'ip' => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1',
                    'ua' => $_SERVER['HTTP_USER_AGENT'] ?? 'CLI',
                    'details' => json_encode(['code' => $code, 'name' => $name, 'format' => $format])
                ]);

                $msg = "Dataset '$name' uploaded and indexed successfully into Data Lake.";
            } else {
                $err = "Failed to store uploaded dataset file.";
            }
        }
    }
}

// Handle Assign Dataset POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'assign_dataset') {
    $datasetId = (int)($_POST['dataset_id'] ?? 0);
    $studentId = (int)($_POST['student_id'] ?? 0);
    if ($datasetId > 0 && $studentId > 0) {
        $existing = $db->fetchOne("SELECT id FROM dataset_assignments WHERE dataset_id = :did AND student_id = :sid", [
            'did' => $datasetId,
            'sid' => $studentId
        ]);
        if (!$existing) {
            $db->insert("INSERT INTO dataset_assignments (dataset_id, student_id, assigned_by, created_at) VALUES (:did, :sid, :aid, NOW())", [
                'did' => $datasetId,
                'sid' => $studentId,
                'aid' => $currentUser['id']
            ]);
            $db->insert("INSERT INTO audit_logs (user_id, action, resource_type, resource_id, outcome, ip_address, user_agent, details_json, created_at)
                         VALUES (:uid, 'DATASET_ASSIGN', 'DATASET', :rid, 'SUCCESS', :ip, :ua, :details, NOW())", [
                'uid' => $currentUser['id'],
                'rid' => $datasetId,
                'ip' => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1',
                'ua' => $_SERVER['HTTP_USER_AGENT'] ?? 'CLI',
                'details' => json_encode(['student_id' => $studentId])
            ]);
            $msg = "Dataset assigned to student successfully.";
        } else {
            $msg = "Dataset was already assigned to this student.";
        }
    }
}

$datasets = $db->fetchAll("
    SELECT d.*, u.full_name AS uploaded_by_name, s.title AS scenario_title,
           (SELECT COUNT(*) FROM dataset_assignments WHERE dataset_id = d.id) AS assigned_students_count
    FROM datasets d
    LEFT JOIN users u ON d.uploaded_by = u.id
    LEFT JOIN scenarios s ON d.scenario_id = s.id
    ORDER BY d.created_at DESC
");
$students = $db->fetchAll("SELECT id, full_name, identifier, email FROM users WHERE role = 'STUDENT' AND status = 'ACTIVE' ORDER BY full_name ASC");
$scenarios = $db->fetchAll("SELECT id, code, title FROM scenarios ORDER BY created_at DESC");
?>
PHP;

$content = preg_replace('/<\?php[\s\S]*?\?>/', $topPhp, $content, 1);

// Replace header Chief Instructor info with current user
$content = preg_replace(
    '/<div class="flex flex-col text-right hidden sm:flex"><span class="font-label-md text-label-md text-on-surface leading-tight">K\. VORONIN<\/span><span class="font-label-sm text-label-sm text-on-surface-variant uppercase">Chief Instructor<\/span><\/div>/',
    '<div class="flex flex-col text-right hidden sm:flex"><span class="font-label-md text-label-md text-on-surface leading-tight"><?= htmlspecialchars($currentUser[\'full_name\']) ?></span><span class="font-label-sm text-label-sm text-on-surface-variant uppercase"><?= htmlspecialchars($currentUser[\'role\']) ?></span></div>',
    $content
);

// Add alert banner
$alertHtml = <<<'HTML'
<?php if (!empty($msg)): ?>
    <div class="mb-4 p-4 rounded-xl bg-emerald-50 border border-emerald-300 text-emerald-800 font-mono text-sm flex items-center gap-2">
        <span class="material-symbols-outlined text-emerald-600">check_circle</span>
        <span><?= htmlspecialchars($msg) ?></span>
    </div>
<?php endif; ?>
<?php if (!empty($err)): ?>
    <div class="mb-4 p-4 rounded-xl bg-rose-50 border border-rose-300 text-rose-800 font-mono text-sm flex items-center gap-2">
        <span class="material-symbols-outlined text-rose-600">error</span>
        <span><?= htmlspecialchars($err) ?></span>
    </div>
<?php endif; ?>
HTML;

$content = str_replace('<div class="flex flex-col w-full">', '<div class="flex flex-col w-full">' . "\n" . $alertHtml, $content);

file_put_contents($file, $content);
echo "DatasetManagement.php updated with upload, assignment, and auth logic.\n";
