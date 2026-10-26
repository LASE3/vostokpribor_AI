<?php
// Patch script for AI Operations Center (AI SOC)/DatasetManagement.php

$file = dirname(__DIR__) . '/AI Operations Center (AI SOC)/DatasetManagement.php';
$content = file_get_contents($file);

// Replace lines up to php close tag
$pos = strpos($content, "?>\r\n<!DOCTYPE html>");
if ($pos === false) {
    $pos = strpos($content, "?>\n<!DOCTYPE html>");
}
if ($pos === false) {
    die("Could not find PHP header end tag\n");
}

$newHeader = <<<'PHP'
<?php
// VOSTOKPRIBOR AI • SYS-AI-05: AI Operations Center (AI SOC) - Dataset Management
require_once __DIR__ . '/../app/bootstrap.php';

use App\Middleware\AuthorizationMiddleware;
use App\Core\Database;
use App\Core\Auth;
use App\Core\Csrf;

AuthorizationMiddleware::requireAdmin();
$currentUser = Auth::user();
$db = Database::getInstance();

$msg = '';
$err = '';

// Handle Upload New Dataset POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'upload_dataset') {
    if (!Csrf::validate($_POST['csrf_token'] ?? '')) {
        $err = "Security token expired or invalid. Please try again.";
    } else {
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
                $err = "Unsupported file format (allowed: CSV, JSON, Parquet, TXT).";
            } else {
                $storageDir = __DIR__ . '/../storage/private/datasets';
                if (!is_dir($storageDir)) {
                    mkdir($storageDir, 0755, true);
                }
                $safeName = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $file['name']);
                $storageFilename = time() . '_' . $safeName;
                $targetPath = $storageDir . '/' . $storageFilename;
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

                    Database::transaction(function() use ($db, $code, $name, $desc, $format, $storageFilename, $fileSize, $checksum, $rowCount, $colCount, $scenarioId, $currentUser, &$dsId) {
                        $dsId = $db->insert('datasets', [
                            'code' => $code,
                            'name' => $name,
                            'description' => $desc,
                            'format' => $format,
                            'file_path' => $storageFilename,
                            'file_size' => $fileSize,
                            'checksum_sha256' => $checksum,
                            'row_count' => $rowCount,
                            'column_count' => $colCount,
                            'is_master' => 1,
                            'version' => 'v1.0',
                            'scenario_id' => $scenarioId,
                            'uploaded_by' => $currentUser['id']
                        ]);

                        $db->insert('audit_logs', [
                            'user_id' => $currentUser['id'],
                            'action' => 'DATASET_UPLOAD',
                            'resource_type' => 'DATASET',
                            'resource_id' => $dsId,
                            'outcome' => 'SUCCESS',
                            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1',
                            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'CLI',
                            'details_json' => json_encode(['code' => $code, 'name' => $name, 'format' => $format])
                        ]);
                    });

                    $msg = "Dataset '$name' uploaded and indexed successfully into Data Lake.";
                } else {
                    $err = "Failed to store uploaded dataset file.";
                }
            }
        }
    }
}

// Handle Assign Dataset POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'assign_dataset') {
    if (!Csrf::validate($_POST['csrf_token'] ?? '')) {
        $err = "Security token expired or invalid.";
    } else {
        $datasetId = (int)($_POST['dataset_id'] ?? 0);
        $studentId = (int)($_POST['student_id'] ?? 0);
        if ($datasetId > 0 && $studentId > 0) {
            $existing = $db->fetchOne("SELECT id FROM dataset_assignments WHERE dataset_id = :did AND student_id = :sid", [
                'did' => $datasetId,
                'sid' => $studentId
            ]);
            if (!$existing) {
                Database::transaction(function() use ($db, $datasetId, $studentId, $currentUser) {
                    $db->insert('dataset_assignments', [
                        'dataset_id' => $datasetId,
                        'student_id' => $studentId,
                        'assigned_by' => $currentUser['id']
                    ]);
                    $db->insert('audit_logs', [
                        'user_id' => $currentUser['id'],
                        'action' => 'DATASET_ASSIGN',
                        'resource_type' => 'DATASET',
                        'resource_id' => $datasetId,
                        'outcome' => 'SUCCESS',
                        'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1',
                        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'CLI',
                        'details_json' => json_encode(['student_id' => $studentId])
                    ]);
                });
                $msg = "Dataset assigned to student successfully.";
            } else {
                $msg = "Dataset was already assigned to this student.";
            }
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

$selectedDatasetId = isset($_GET['id']) ? (int)$_GET['id'] : (!empty($datasets) ? (int)$datasets[0]['id'] : 0);
$selectedDataset = null;
foreach ($datasets as $d) {
    if ((int)$d['id'] === $selectedDatasetId) {
        $selectedDataset = $d;
        break;
    }
}
if (!$selectedDataset && !empty($datasets)) {
    $selectedDataset = $datasets[0];
}

$csrfToken = Csrf::getToken();
?>
PHP;

$htmlPart = substr($content, $pos + 2);

// In htmlPart, replace the top register button with dynamic trigger and add assign button
$htmlPart = preg_replace(
    '/<button class="flex items-center gap-space-xs px-space-md py-2 rounded-lg bg-primary-container text-on-primary font-label-md text-label-md shadow-md hover:bg-primary transition-all">\s*<span class="material-symbols-outlined text-\[18px\]">add_box<\/span>\s*<span class="">\+ Register Dataset \/ Version<\/span>\s*<\/button>/',
    '<button onclick="document.getElementById(\'modal-upload-dataset\').classList.remove(\'hidden\')" class="flex items-center gap-space-xs px-space-md py-2 rounded-lg bg-primary-container text-on-primary font-label-md text-label-md shadow-md hover:bg-primary transition-all cursor-pointer"><span class="material-symbols-outlined text-[18px]">add_box</span><span>+ Register Dataset / Version</span></button><button onclick="document.getElementById(\'modal-assign-dataset\').classList.remove(\'hidden\')" class="flex items-center gap-space-xs px-space-md py-2 rounded-lg bg-secondary-fixed text-primary font-label-md text-label-md shadow-sm hover:bg-secondary-fixed/80 transition-all cursor-pointer"><span class="material-symbols-outlined text-[18px]">person_add</span><span>Assign to Cadet</span></button>',
    $htmlPart
);

// Replace Metric cards with dynamic counts
$htmlPart = preg_replace(
    '/<span class="font-headline-xl text-headline-xl text-primary font-bold">14<\/span>\s*<span class="font-label-md text-label-md text-on-surface-variant">Datasets<\/span>/',
    '<span class="font-headline-xl text-headline-xl text-primary font-bold"><?= count($datasets) ?></span><span class="font-label-md text-label-md text-on-surface-variant">Datasets</span>',
    $htmlPart
);

$htmlPart = preg_replace(
    '/<span class="font-bold text-primary">62\.8 GB \(Parquet\/Arrow\)<\/span>/',
    '<span class="font-bold text-primary"><?= number_format(array_sum(array_column($datasets, \'file_size\')) / (1024 * 1024), 2) ?> MB</span>',
    $htmlPart
);

$htmlPart = preg_replace(
    '/<span class="font-headline-xl text-headline-xl text-primary font-bold">19<\/span>\s*<span class="font-label-md text-label-md text-on-surface-variant">Active Pipelines<\/span>/',
    '<span class="font-headline-xl text-headline-xl text-primary font-bold"><?= count(array_unique(array_filter(array_column($datasets, \'scenario_id\')))) ?></span><span class="font-label-md text-label-md text-on-surface-variant">Active Scenarios</span>',
    $htmlPart
);

// Dynamic Left Catalog List
$catalogPattern = '/<!-- Dataset List Cards -->\s*<div class="flex flex-col gap-space-xs">.*?<!-- Item 6 -->.*?<\/div>\s*<\/div>/s';
$dynamicCatalog = <<<'HTML'
<!-- Dataset List Cards -->
<div class="flex flex-col gap-space-xs">
    <?php if (empty($datasets)): ?>
        <div class="p-4 bg-surface-container-lowest rounded-xl border border-dashed border-outline-variant text-center text-on-surface-variant text-xs">
            <span class="material-symbols-outlined text-2xl mb-1 text-outline">database</span>
            <p>No master datasets indexed yet.</p>
            <p class="mt-1">Click "+ Register Dataset / Version" above to index a new catalog entry.</p>
        </div>
    <?php else: ?>
        <?php foreach ($datasets as $ds): ?>
            <?php $isSelected = ($selectedDataset && $selectedDataset['id'] === $ds['id']); ?>
            <a href="DatasetManagement.php?id=<?= $ds['id'] ?>" class="flex flex-col p-space-md <?= $isSelected ? 'bg-secondary-fixed/40' : 'bg-surface-container-lowest hover:bg-surface-container-low' ?> rounded-xl shadow-sm transition-all relative overflow-hidden block">
                <?php if ($isSelected): ?>
                    <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-primary-container"></div>
                <?php endif; ?>
                <div class="flex items-start justify-between gap-space-sm pl-1">
                    <div class="flex flex-col min-w-0">
                        <div class="flex items-center gap-space-xs">
                            <span class="font-label-md text-label-md font-bold text-primary truncate"><?= htmlspecialchars($ds['name']) ?></span>
                        </div>
                        <span class="font-body-sm text-body-sm text-on-surface-variant truncate"><?= htmlspecialchars($ds['format']) ?> • <?= number_format($ds['row_count']) ?> rows • <?= (int)$ds['column_count'] ?> features</span>
                    </div>
                    <span class="px-2 py-0.5 rounded <?= $isSelected ? 'bg-primary-container text-on-primary' : 'bg-surface-container text-primary' ?> font-label-sm text-label-sm whitespace-nowrap"><?= htmlspecialchars($ds['version'] ?? 'v1.0') ?></span>
                </div>
                <div class="flex items-center justify-between mt-space-sm pt-space-xs pl-1 font-label-sm text-label-sm text-on-surface-variant">
                    <span class="flex items-center gap-1 text-primary">
                        <span class="w-1.5 h-1.5 rounded-full bg-primary"></span>
                        <?= htmlspecialchars($ds['scenario_title'] ?? 'Global Lake Repository') ?>
                    </span>
                    <span class="flex items-center gap-1 text-on-surface font-label-sm font-mono text-[10px]">
                        <?= number_format($ds['file_size'] / (1024 * 1024), 2) ?> MB
                    </span>
                </div>
            </a>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
HTML;

$htmlPart = preg_replace($catalogPattern, $dynamicCatalog, $htmlPart);

// Selected dataset inspection details
if ($selectedDataset) {
    // Top banner name and version
    $htmlPart = preg_replace(
        '/<h2 class="font-headline-md text-headline-md text-primary font-bold">telecom_customer_churn_v2\.parquet<\/h2>\s*<span class="px-2\.5 py-0\.5 rounded-full bg-primary-container text-on-primary font-label-sm text-label-sm font-bold">v2\.1\.0 ACTIVE<\/span>/',
        '<h2 class="font-headline-md text-headline-md text-primary font-bold"><?= $selectedDataset ? htmlspecialchars($selectedDataset["name"]) : "No dataset selected" ?></h2><span class="px-2.5 py-0.5 rounded-full bg-primary-container text-on-primary font-label-sm text-label-sm font-bold"><?= $selectedDataset ? htmlspecialchars($selectedDataset["version"] ?? "v1.0") : "" ?></span>',
        $htmlPart
    );

    // URI
    $htmlPart = preg_replace(
        '/<code class="font-mono text-primary font-bold">s3:\/\/vp-lakehouse-ai02\/datasets\/tabular\/churn\/v2\.1\.0\/part-00\.parquet<\/code>/',
        '<code class="font-mono text-primary font-bold"><?= $selectedDataset ? htmlspecialchars("lake://" . $selectedDataset["file_path"]) : "N/A" ?></code>',
        $htmlPart
    );

    // SHA-256
    $htmlPart = preg_replace(
        '/<span class="font-mono text-primary">8a7f9b2de34081c7e2b71948fc39023194aa82b3c29f45610ec888e23f019b88<\/span>/',
        '<span class="font-mono text-primary"><?= $selectedDataset ? htmlspecialchars($selectedDataset["checksum_sha256"] ?? "N/A") : "N/A" ?></span>',
        $htmlPart
    );
}

// Add the 2 Modals before </body>
$modals = <<<'HTML'
    <!-- Upload Dataset Modal -->
    <div id="modal-upload-dataset" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
        <div class="bg-surface-container-lowest rounded-2xl shadow-2xl max-w-lg w-full p-6 border border-primary/20">
            <div class="flex items-center justify-between pb-3 border-b border-outline-variant/30 mb-4">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-2xl">upload_file</span>
                    <h3 class="font-bold text-lg text-primary">Register Master Dataset</h3>
                </div>
                <button type="button" onclick="document.getElementById('modal-upload-dataset').classList.add('hidden')" class="p-1 rounded-lg hover:bg-surface-container text-on-surface-variant">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <form method="POST" enctype="multipart/form-data" class="space-y-4">
                <input type="hidden" name="action" value="upload_dataset">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant uppercase mb-1">Dataset Name *</label>
                    <input type="text" name="name" required placeholder="e.g. Telemetry Flight Vector 2026" class="w-full px-3 py-2 bg-surface-container-low rounded-lg text-sm border border-outline-variant/40 focus:border-primary focus:outline-none">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-on-surface-variant uppercase mb-1">Dataset Code *</label>
                        <input type="text" name="code" required placeholder="DS-FLIGHT-V2" class="w-full px-3 py-2 bg-surface-container-low rounded-lg text-sm border border-outline-variant/40 focus:border-primary focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-on-surface-variant uppercase mb-1">Format *</label>
                        <select name="format" class="w-full px-3 py-2 bg-surface-container-low rounded-lg text-sm border border-outline-variant/40 focus:border-primary focus:outline-none">
                            <option value="CSV">CSV</option>
                            <option value="JSON">JSON</option>
                            <option value="PARQUET">Parquet</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant uppercase mb-1">Training Scenario Binding</label>
                    <select name="scenario_id" class="w-full px-3 py-2 bg-surface-container-low rounded-lg text-sm border border-outline-variant/40 focus:border-primary focus:outline-none">
                        <option value="">-- Unassigned / General Lake --</option>
                        <?php foreach ($scenarios as $sc): ?>
                            <option value="<?= $sc['id'] ?>"><?= htmlspecialchars($sc['code']) ?>: <?= htmlspecialchars($sc['title']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant uppercase mb-1">Description</label>
                    <textarea name="description" rows="2" placeholder="Summary of data schema, columns, and target label..." class="w-full px-3 py-2 bg-surface-container-low rounded-lg text-sm border border-outline-variant/40 focus:border-primary focus:outline-none"></textarea>
                </div>
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant uppercase mb-1">Dataset File *</label>
                    <input type="file" name="dataset_file" required accept=".csv,.json,.parquet,.txt" class="w-full text-xs text-on-surface-variant file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-primary file:text-white hover:file:bg-primary/90">
                </div>
                <div class="flex justify-end gap-2 pt-3 border-t border-outline-variant/30">
                    <button type="button" onclick="document.getElementById('modal-upload-dataset').classList.add('hidden')" class="px-4 py-2 rounded-lg bg-surface-container text-on-surface-variant text-xs font-bold">Cancel</button>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-primary text-white text-xs font-bold shadow-md hover:bg-primary/90">Upload &amp; Index</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Assign Dataset Modal -->
    <div id="modal-assign-dataset" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
        <div class="bg-surface-container-lowest rounded-2xl shadow-2xl max-w-md w-full p-6 border border-primary/20">
            <div class="flex items-center justify-between pb-3 border-b border-outline-variant/30 mb-4">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-2xl">person_add</span>
                    <h3 class="font-bold text-lg text-primary">Assign Dataset to Cadet</h3>
                </div>
                <button type="button" onclick="document.getElementById('modal-assign-dataset').classList.add('hidden')" class="p-1 rounded-lg hover:bg-surface-container text-on-surface-variant">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <form method="POST" class="space-y-4">
                <input type="hidden" name="action" value="assign_dataset">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant uppercase mb-1">Select Dataset *</label>
                    <select name="dataset_id" required class="w-full px-3 py-2 bg-surface-container-low rounded-lg text-sm border border-outline-variant/40 focus:border-primary focus:outline-none">
                        <?php foreach ($datasets as $ds): ?>
                            <option value="<?= $ds['id'] ?>" <?= ($selectedDataset && $selectedDataset['id'] === $ds['id']) ? 'selected' : '' ?>><?= htmlspecialchars($ds['code']) ?> - <?= htmlspecialchars($ds['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant uppercase mb-1">Select Cadet Student *</label>
                    <select name="student_id" required class="w-full px-3 py-2 bg-surface-container-low rounded-lg text-sm border border-outline-variant/40 focus:border-primary focus:outline-none">
                        <?php if (empty($students)): ?>
                            <option value="">No active cadets found</option>
                        <?php else: ?>
                            <?php foreach ($students as $stu): ?>
                                <option value="<?= $stu['id'] ?>"><?= htmlspecialchars($stu['full_name']) ?> (<?= htmlspecialchars($stu['identifier'] ?? $stu['email']) ?>)</option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="flex justify-end gap-2 pt-3 border-t border-outline-variant/30">
                    <button type="button" onclick="document.getElementById('modal-assign-dataset').classList.add('hidden')" class="px-4 py-2 rounded-lg bg-surface-container text-on-surface-variant text-xs font-bold">Cancel</button>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-primary text-white text-xs font-bold shadow-md hover:bg-primary/90">Confirm Assignment</button>
                </div>
            </form>
        </div>
    </div>
HTML;

$htmlPart = str_replace('</body>', $modals . "\n</body>", $htmlPart);

$final = $newHeader . "\n" . $htmlPart;
file_put_contents($file, $final);
echo "SUCCESS: AI Operations Center (AI SOC)/DatasetManagement.php patched.\n";
