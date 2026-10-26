# Patch Data Center/UploadProcessedData.php with working form, CSRF validation, and real table data

import re

p = r'Data Center/UploadProcessedData.php'
with open(p, 'r', encoding='utf-8') as f:
    c = f.read()

# 1. Update PHP top section
top_search = """$isStudent = ($currentUser['role'] === 'STUDENT');

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
?>"""

top_replace = """$isStudent = ($currentUser['role'] === 'STUDENT');
use App\Core\Csrf;
use App\Services\DatasetService;

$msg = '';
$err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'upload_processed') {
    if (!Csrf::validate($_POST['csrf_token'] ?? '')) {
        $err = "Security token expired or invalid.";
    } else {
        try {
            $sourceId = (int)($_POST['source_dataset_id'] ?? 0);
            $ticketId = !empty($_POST['ticket_id']) ? (int)$_POST['ticket_id'] : null;
            $name = trim($_POST['name'] ?? '');
            $notes = trim($_POST['transformation_notes'] ?? '');
            $dsService = new DatasetService();
            $dsService->uploadProcessedDataset($sourceId, (int)$currentUser['id'], $ticketId, $_FILES['processed_file'] ?? [], [
                'name' => $name,
                'transformation_notes' => $notes
            ]);
            $msg = "Processed dataset indexed and stored successfully in Range Lake.";
        } catch (\Throwable $e) {
            $err = $e->getMessage();
        }
    }
}

if ($isStudent) {
    $assignedDatasets = $db->fetchAll("
        SELECT d.* FROM datasets d 
        JOIN dataset_assignments da ON d.id = da.dataset_id 
        WHERE da.student_id = :sid ORDER BY d.created_at DESC
    ", ['sid' => $currentUser['id']]);
    $processedDatasets = $db->fetchAll("
        SELECT pd.*, d.name AS source_name, d.code AS source_code 
        FROM processed_datasets pd 
        JOIN datasets d ON pd.source_dataset_id = d.id 
        WHERE pd.student_id = :sid 
        ORDER BY pd.created_at DESC
    ", ['sid' => $currentUser['id']]);
} else {
    $assignedDatasets = $db->fetchAll("SELECT * FROM datasets ORDER BY created_at DESC");
    $processedDatasets = $db->fetchAll("
        SELECT pd.*, d.name AS source_name, d.code AS source_code, u.full_name AS student_name 
        FROM processed_datasets pd 
        JOIN datasets d ON pd.source_dataset_id = d.id 
        LEFT JOIN users u ON pd.student_id = u.id 
        ORDER BY pd.created_at DESC
    ");
}

$processedCount = count($processedDatasets);
$datasetCount = count($assignedDatasets);
$totalSizeBytes = array_sum(array_column($assignedDatasets, 'file_size'));
$totalSizeMB = round($totalSizeBytes / (1024 * 1024), 2);
$csrfToken = Csrf::getToken();
?>"""

c = c.replace(top_search, top_replace)

# 2. Add message / error banners right after <main ...>
msg_banner = """<?php if ($msg): ?>
<div class="p-3 mb-4 rounded-lg bg-emerald-100 border border-emerald-300 text-emerald-800 text-xs font-mono flex items-center gap-2">
    <span class="material-symbols-outlined text-[18px]">check_circle</span>
    <span><?= htmlspecialchars($msg) ?></span>
</div>
<?php endif; ?>
<?php if ($err): ?>
<div class="p-3 mb-4 rounded-lg bg-rose-100 border border-rose-300 text-rose-800 text-xs font-mono flex items-center gap-2">
    <span class="material-symbols-outlined text-[18px]">error</span>
    <span><?= htmlspecialchars($err) ?></span>
</div>
<?php endif; ?>"""

c = c.replace('<main class="relative pt-28 w-full px-8 pb-12">\n            <div class="flex flex-col w-full gap-5">',
              '<main class="relative pt-28 w-full px-8 pb-12">\n            ' + msg_banner + '\n            <div class="flex flex-col w-full gap-5">')

# 3. Replace the upload frame with real working form
form_pattern = re.compile(r'<!-- Drag & Drop Tactical Frame -->\s*<div class="relative group cursor-pointer flex flex-col items-center justify-center p-8.*?</div>\s*<!-- Destination Namespace Input -->', re.DOTALL)

working_form = """<!-- Functional Ingestion Upload Form -->
<form method="POST" enctype="multipart/form-data" class="flex flex-col gap-4 p-6 rounded-lg bg-surface-container-low border border-primary/20 shadow-inner">
    <input type="hidden" name="action" value="upload_processed">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="font-label-sm text-label-sm uppercase tracking-wider text-outline block mb-1">Source Master Dataset *</label>
            <select name="source_dataset_id" required class="w-full h-9 px-3 rounded bg-surface-container-lowest font-code-sm text-code-sm text-on-surface focus:outline-none shadow-sm">
                <?php if (empty($assignedDatasets)): ?>
                    <option value="">No assigned datasets available</option>
                <?php else: ?>
                    <?php foreach ($assignedDatasets as $ads): ?>
                        <option value="<?= $ads['id'] ?>"><?= htmlspecialchars($ads['code']) ?> - <?= htmlspecialchars($ads['name']) ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>
        <div>
            <label class="font-label-sm text-label-sm uppercase tracking-wider text-outline block mb-1">Processed Artifact Name *</label>
            <input type="text" name="name" required placeholder="e.g. telecom_imputed_features_v2.csv" class="w-full h-9 px-3 rounded bg-surface-container-lowest font-code-sm text-code-sm text-on-surface focus:outline-none shadow-sm" />
        </div>
    </div>
    
    <div>
        <label class="font-label-sm text-label-sm uppercase tracking-wider text-outline block mb-1">Select Processed File (.CSV / .JSON) *</label>
        <input type="file" name="processed_file" required accept=".csv,.json" class="w-full text-xs text-on-surface-variant file:mr-3 file:py-2 file:px-4 file:rounded file:border-0 file:text-xs file:font-bold file:bg-primary file:text-white hover:file:bg-primary/90" />
    </div>

    <div>
        <label class="font-label-sm text-label-sm uppercase tracking-wider text-outline block mb-1">Transformation Notes & Applied Pipeline</label>
        <textarea name="transformation_notes" rows="2" placeholder="e.g. Imputed missing billing values with median; encoded categorical features." class="w-full px-3 py-2 rounded bg-surface-container-lowest font-code-sm text-code-sm text-on-surface focus:outline-none shadow-sm"></textarea>
    </div>

    <div class="flex items-center justify-end gap-3 pt-2">
        <button type="submit" class="px-5 py-2.5 rounded bg-primary text-white hover:bg-primary/90 font-label-md text-label-md uppercase tracking-wider flex items-center gap-2 shadow-md transition-all">
            <span class="material-symbols-outlined text-[18px]">cloud_upload</span>
            <span>Upload Processed Dataset</span>
        </button>
    </div>
</form>
<!-- Destination Namespace Input -->"""

c = form_pattern.sub(working_form, c)

# 4. Replace table rows with dynamic loop over $processedDatasets
table_pattern = re.compile(r'<tbody class="divide-y divide-surface-container-high font-body-md text-body-md">.*?</tbody>', re.DOTALL)

dynamic_table = """<tbody class="divide-y divide-surface-container-high font-body-md text-body-md">
<?php if (empty($processedDatasets)): ?>
    <tr>
        <td colspan="5" class="py-8 text-center text-on-surface-variant font-mono text-xs">
            <span class="material-symbols-outlined text-3xl mb-1 text-outline">folder_off</span>
            <p>No processed datasets registered in this flight namespace yet.</p>
            <p class="mt-1 text-outline">Upload a feature-engineered file above linked to your assigned master dataset.</p>
        </td>
    </tr>
<?php else: ?>
    <?php foreach ($processedDatasets as $pd): ?>
        <tr class="hover:bg-surface-container-low transition-colors bg-surface-container-lowest">
            <td class="py-3 px-4">
                <div class="flex items-center gap-2.5">
                    <span class="w-2 h-2 rounded-full bg-[#10B981]"></span>
                    <div class="flex flex-col">
                        <span class="font-code-md text-code-md font-semibold text-on-surface"><?= htmlspecialchars($pd['name']) ?></span>
                        <span class="font-code-sm text-code-sm text-outline">Source: <?= htmlspecialchars($pd['source_code']) ?> • SHA: <?= substr($pd['checksum_sha256'] ?? '', 0, 16) ?>...</span>
                    </div>
                </div>
            </td>
            <td class="py-3 px-4">
                <div class="flex flex-col">
                    <span class="font-code-md text-code-md text-on-surface"><?= number_format($pd['file_size'] / (1024 * 1024), 2) ?> MB</span>
                    <span class="font-code-sm text-code-sm text-on-surface-variant"><?= number_format($pd['row_count']) ?> rows • <?= htmlspecialchars(strtoupper($pd['format'])) ?></span>
                </div>
            </td>
            <td class="py-3 px-4">
                <div class="flex flex-col gap-1">
                    <div class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded bg-[#FDF6F0] text-tertiary font-code-sm text-code-sm w-fit font-bold">
                        <span class="material-symbols-outlined text-[13px] text-[#10B981]">check_circle</span>
                        <span>REGISTERED IN LAKE</span>
                    </div>
                    <span class="font-code-sm text-code-sm text-outline"><?= htmlspecialchars($pd['transformation_notes'] ?: 'No transformation notes provided') ?></span>
                </div>
            </td>
            <td class="py-3 px-4">
                <span class="px-2 py-0.5 rounded bg-surface-container font-code-sm text-code-sm text-secondary font-bold">
                    <?= $pd['ticket_id'] ? '#VP-TCK-' . $pd['ticket_id'] : 'GENERAL' ?>
                </span>
            </td>
            <td class="py-3 px-4 text-right">
                <div class="inline-flex items-center gap-2">
                    <span class="text-xs font-mono text-outline"><?= htmlspecialchars($pd['created_at']) ?></span>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
<?php endif; ?>
</tbody>"""

c = table_pattern.sub(dynamic_table, c)

with open(p, 'w', encoding='utf-8') as f:
    f.write(c)

print('Data Center/UploadProcessedData.php patched successfully.')
