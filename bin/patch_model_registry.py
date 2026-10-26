# Patch ModelRegistry.php and dashboard.php in Model Registry & Deployment

import re

p_registry = r'Model Registry & Deployment/ModelRegistry.php'
with open(p_registry, 'r', encoding='utf-8') as f:
    c = f.read()

# 1. Update top PHP section
top_search = """use App\Middleware\AuthenticationMiddleware;
use App\Core\Database;
use App\Core\Auth;

$currentUser = AuthenticationMiddleware::handle();
$db = Database::getInstance();"""

top_replace = """use App\Middleware\AuthenticationMiddleware;
use App\Core\Database;
use App\Core\Auth;
use App\Core\Csrf;

$currentUser = AuthenticationMiddleware::handle();
$db = Database::getInstance();

$msg = '';
$err = '';

// Handle Model Registration POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'register_model') {
    if (!Csrf::validate($_POST['csrf_token'] ?? '')) {
        $err = "Security token expired or invalid.";
    } else {
        $name = trim($_POST['name'] ?? '');
        $code = strtoupper(trim($_POST['model_code'] ?? ''));
        $framework = trim($_POST['framework'] ?? 'Scikit-Learn');
        $desc = trim($_POST['description'] ?? '');
        $ticketId = !empty($_POST['ticket_id']) ? (int)$_POST['ticket_id'] : null;
        $version = trim($_POST['version'] ?? 'v1.0.0');

        if (empty($name) || empty($code)) {
            $err = "Model Name and Model Code are required.";
        } else {
            $existing = $db->fetchOne("SELECT id FROM models WHERE model_code = :code", ['code' => $code]);
            if ($existing) {
                $err = "A model with this code already exists.";
            } else {
                $storageDir = dirname(__DIR__) . '/storage/private/models';
                if (!is_dir($storageDir)) {
                    mkdir($storageDir, 0755, true);
                }
                $artifactPath = 'mod_' . strtolower($code) . '_' . uniqid() . '.bin';
                file_put_contents($storageDir . '/' . $artifactPath, "VOSTOKPRIBOR_MODEL_BINARY_SPEC_880B:" . $code);
                $checksum = hash('sha256', "VOSTOKPRIBOR_MODEL_BINARY_SPEC_880B:" . $code);

                Database::transaction(function() use ($db, $name, $code, $framework, $desc, $currentUser, $ticketId, $version, $artifactPath, $checksum, &$modelId) {
                    $modelId = $db->insert('models', [
                        'name' => $name,
                        'model_code' => $code,
                        'framework' => $framework,
                        'description' => $desc,
                        'student_id' => $currentUser['id'],
                        'ticket_id' => $ticketId,
                        'status' => 'REGISTERED'
                    ]);

                    $db->insert('model_versions', [
                        'model_id' => $modelId,
                        'version' => $version,
                        'artifact_path' => $artifactPath,
                        'artifact_format' => 'bin',
                        'file_size' => 1024,
                        'checksum_sha256' => $checksum,
                        'metrics' => json_encode(['registered_by' => $currentUser['identifier'] ?? $currentUser['email']])
                    ]);

                    $db->insert('audit_logs', [
                        'user_id' => $currentUser['id'],
                        'action' => 'MODEL_REGISTERED',
                        'resource_type' => 'MODELS',
                        'resource_id' => $modelId,
                        'outcome' => 'SUCCESS',
                        'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1',
                        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'CLI',
                        'details_json' => json_encode(['model_code' => $code, 'version' => $version])
                    ]);
                });

                $msg = "Model '$name' ($code) registered successfully in Registry.";
            }
        }
    }
}"""

c = c.replace(top_search, top_replace)

# Tickets query & CSRF token
tickets_query = """
$assignedTickets = ($currentUser['role'] === 'STUDENT')
    ? $db->fetchAll("SELECT t.id, t.ticket_code, t.title FROM ticket_assignments ta JOIN tickets t ON ta.ticket_id = t.id WHERE ta.student_id = :sid", ['sid' => $currentUser['id']])
    : $db->fetchAll("SELECT id, ticket_code, title FROM tickets ORDER BY created_at DESC");
$csrfToken = Csrf::getToken();
"""

c = c.replace("$deploymentCount = count($deployments);", "$deploymentCount = count($deployments);\n" + tickets_query)

# Message banner
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

c = c.replace('<div class="w-full flex flex-col gap-space-lg">', '<div class="w-full flex flex-col gap-space-lg">\n' + msg_banner)

# Connect Register Candidate button
c = re.sub(
    r'<button class="flex items-center gap-1 px-space-md py-1\.5 rounded-lg bg-primary-container text-on-primary font-label-md text-label-md hover:bg-primary transition-colors shadow-sm">\s*<span class="material-symbols-outlined text-\[18px\]">cloud_upload<\/span>\s*<span>Register Candidate<\/span>\s*<\/button>',
    '<button onclick="document.getElementById(\'modal-register-candidate\').classList.remove(\'hidden\')" class="flex items-center gap-1 px-space-md py-1.5 rounded-lg bg-primary-container text-on-primary font-label-md text-label-md hover:bg-primary transition-colors shadow-sm cursor-pointer"><span class="material-symbols-outlined text-[18px]">cloud_upload</span><span>Register Candidate</span></button>',
    c
)

# Replace static table body with dynamic loop
table_pattern = re.compile(r'<tbody class="divide-y-0 text-on-surface font-body-sm text-body-sm">.*?</tbody>', re.DOTALL)

dynamic_tbody = """<tbody class="divide-y divide-outline-variant/20 text-on-surface font-body-sm text-body-sm">
<?php if (empty($models)): ?>
    <tr>
        <td colspan="12" class="py-12 text-center text-on-surface-variant font-mono text-xs">
            <span class="material-symbols-outlined text-4xl mb-2 text-outline">memory</span>
            <p class="font-bold text-sm text-primary">No candidate models registered yet.</p>
            <p class="mt-1 text-on-surface-variant">Click "+ Register Candidate" above to submit a model artifact for validation.</p>
        </td>
    </tr>
<?php else: ?>
    <?php foreach ($models as $m): ?>
        <tr class="hover:bg-surface-container-low transition-colors bg-surface-container-lowest">
            <td class="py-2.5 px-3 align-top">
                <input class="rounded accent-primary" type="checkbox" />
            </td>
            <td class="py-2.5 px-3 align-top">
                <div class="flex flex-col">
                    <span class="font-headline-sm text-headline-sm text-primary leading-tight font-semibold"><?= htmlspecialchars($m['name']) ?></span>
                    <div class="flex items-center gap-1 text-on-surface-variant font-code-sm text-code-sm mt-0.5">
                        <span class="material-symbols-outlined text-[12px] text-secondary">fingerprint</span>
                        <span><?= htmlspecialchars($m['model_code']) ?></span>
                    </div>
                </div>
            </td>
            <td class="py-2.5 px-3 align-top">
                <div class="flex flex-col items-start gap-1">
                    <span class="font-code-sm text-code-sm font-bold text-primary bg-primary-fixed px-1.5 py-0.5 rounded"><?= htmlspecialchars($m['version_name'] ?? 'v1.0.0') ?></span>
                    <span class="font-label-sm text-label-sm px-1.5 py-0.5 rounded bg-surface-container text-primary font-bold"><?= htmlspecialchars($m['status']) ?></span>
                </div>
            </td>
            <td class="py-2.5 px-3 align-top">
                <div class="flex flex-col">
                    <span class="font-label-md text-label-md font-semibold text-on-surface"><?= htmlspecialchars($m['student_name'] ?? $currentUser['full_name']) ?></span>
                    <span class="font-code-sm text-code-sm text-on-surface-variant">Cadet ID #<?= (int)$m['student_id'] ?></span>
                </div>
            </td>
            <td class="py-2.5 px-3 align-top">
                <div class="flex flex-col gap-0.5">
                    <?php if ($m['ticket_id']): ?>
                        <span class="font-code-sm text-code-sm text-primary font-semibold flex items-center gap-0.5">
                            <span class="material-symbols-outlined text-[12px]">link</span>#VP-TKT-<?= (int)$m['ticket_id'] ?>
                        </span>
                    <?php else: ?>
                        <span class="text-outline text-xs">Unlinked</span>
                    <?php endif; ?>
                </div>
            </td>
            <td class="py-2.5 px-3 align-top">
                <div class="flex flex-col">
                    <span class="font-code-sm text-code-sm text-on-surface truncate max-w-[130px]"><?= htmlspecialchars($m['artifact_path'] ?? 'artifact.bin') ?></span>
                    <span class="font-code-sm text-code-sm text-on-surface-variant"><?= number_format(($m['file_size'] ?? 1024) / 1024, 1) ?> KB</span>
                </div>
            </td>
            <td class="py-2.5 px-3 align-top">
                <div class="flex flex-col">
                    <span class="font-code-sm text-code-sm font-medium text-on-surface"><?= htmlspecialchars($m['framework'] ?? 'Scikit-Learn') ?></span>
                    <span class="font-code-sm text-code-sm text-on-surface-variant">Avionics 880-B</span>
                </div>
            </td>
            <td class="py-2.5 px-3 align-top text-right">
                <div class="flex flex-col items-end gap-0.5 font-code-sm text-code-sm text-on-surface-variant">
                    <span><?= htmlspecialchars($m['created_at']) ?></span>
                </div>
            </td>
            <td class="py-2.5 px-3 align-top text-center">
                <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded bg-surface-container font-code-sm text-code-sm font-semibold text-primary">
                    <span class="material-symbols-outlined text-[14px]">shield</span>
                    <span><?= htmlspecialchars($m['status']) ?></span>
                </span>
            </td>
            <td class="py-2.5 px-3 align-top">
                <div class="flex flex-col">
                    <span class="font-label-sm text-label-sm px-1.5 py-0.5 rounded bg-surface-container text-primary font-semibold inline-block text-center"><?= in_array($m['status'], ['APPROVED', 'DEPLOYED']) ? 'APPROVED' : 'PENDING' ?></span>
                </div>
            </td>
            <td class="py-2.5 px-3 align-top">
                <div class="flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full <?= $m['status'] === 'DEPLOYED' ? 'bg-emerald-500' : 'bg-outline' ?>"></span>
                    <span class="font-label-md text-label-md font-semibold text-primary"><?= $m['status'] === 'DEPLOYED' ? 'Active' : 'Staged' ?></span>
                </div>
            </td>
            <td class="py-2.5 px-3 align-top text-right">
                <div class="flex items-center justify-end gap-1">
                    <button class="px-2 py-1 rounded bg-primary-container text-on-primary font-label-sm text-label-sm font-bold shadow-xs hover:bg-primary transition-all" title="View Model">
                        DETAILS
                    </button>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
<?php endif; ?>
</tbody>"""

c = table_pattern.sub(dynamic_tbody, c)

# Add Modal
modal_code = """
    <!-- Register Candidate Model Modal -->
    <div id="modal-register-candidate" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
        <div class="bg-surface-container-lowest rounded-2xl shadow-2xl max-w-lg w-full p-6 border border-primary/20">
            <div class="flex items-center justify-between pb-3 border-b border-outline-variant/30 mb-4">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-2xl">memory</span>
                    <h3 class="font-bold text-lg text-primary">Register Candidate Model</h3>
                </div>
                <button type="button" onclick="document.getElementById('modal-register-candidate').classList.add('hidden')" class="p-1 rounded-lg hover:bg-surface-container text-on-surface-variant">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <form method="POST" class="space-y-4">
                <input type="hidden" name="action" value="register_model">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant uppercase mb-1">Model Name *</label>
                    <input type="text" name="name" required placeholder="e.g. Telecom Customer Churn XGBoost" class="w-full px-3 py-2 bg-surface-container-low rounded-lg text-sm border border-outline-variant/40 focus:border-primary focus:outline-none">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-on-surface-variant uppercase mb-1">Model Code *</label>
                        <input type="text" name="model_code" required placeholder="VP-MOD-CHURN-01" class="w-full px-3 py-2 bg-surface-container-low rounded-lg text-sm border border-outline-variant/40 focus:border-primary focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-on-surface-variant uppercase mb-1">Framework *</label>
                        <select name="framework" class="w-full px-3 py-2 bg-surface-container-low rounded-lg text-sm border border-outline-variant/40 focus:border-primary focus:outline-none">
                            <option value="XGBoost 1.7.4">XGBoost 1.7.4</option>
                            <option value="Scikit-Learn 1.3">Scikit-Learn 1.3</option>
                            <option value="PyTorch 2.1">PyTorch 2.1</option>
                            <option value="ONNX Runtime">ONNX Runtime</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-on-surface-variant uppercase mb-1">Initial SemVer Version</label>
                        <input type="text" name="version" value="v1.0.0" class="w-full px-3 py-2 bg-surface-container-low rounded-lg text-sm border border-outline-variant/40 focus:border-primary focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-on-surface-variant uppercase mb-1">Linked Flight Ticket</label>
                        <select name="ticket_id" class="w-full px-3 py-2 bg-surface-container-low rounded-lg text-sm border border-outline-variant/40 focus:border-primary focus:outline-none">
                            <option value="">-- No ticket link --</option>
                            <?php foreach ($assignedTickets as $tkt): ?>
                                <option value="<?= $tkt['id'] ?>"><?= htmlspecialchars($tkt['ticket_code']) ?>: <?= htmlspecialchars($tkt['title']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant uppercase mb-1">Architecture &amp; Hyperparameter Notes</label>
                    <textarea name="description" rows="2" placeholder="e.g. n_estimators=100, max_depth=6, scale_pos_weight=2.75" class="w-full px-3 py-2 bg-surface-container-low rounded-lg text-sm border border-outline-variant/40 focus:border-primary focus:outline-none"></textarea>
                </div>
                <div class="flex justify-end gap-2 pt-3 border-t border-outline-variant/30">
                    <button type="button" onclick="document.getElementById('modal-register-candidate').classList.add('hidden')" class="px-4 py-2 rounded-lg bg-surface-container text-on-surface-variant text-xs font-bold">Cancel</button>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-primary text-white text-xs font-bold shadow-md hover:bg-primary/90">Register Model</button>
                </div>
            </form>
        </div>
    </div>
"""

c = c.replace('</body>', modal_code + '\n</body>')

with open(p_registry, 'w', encoding='utf-8') as f:
    f.write(c)
print('ModelRegistry.php patched successfully.')

# 2. Patch Model Registry & Deployment/dashboard.php
p_dash = r'Model Registry & Deployment/dashboard.php'
with open(p_dash, 'r', encoding='utf-8') as f:
    c_dash = f.read()

# Replace hardcoded 48 Models, 7 Validated, 29 Deployments
c_dash = re.sub(r'<span class="font-headline-xl text-headline-xl text-primary font-bold">48<\/span>',
                '<span class="font-headline-xl text-headline-xl text-primary font-bold"><?= $modelCount ?></span>',
                c_dash)
c_dash = re.sub(r'<span class="font-headline-xl text-headline-xl text-primary font-bold">7<\/span>',
                '<span class="font-headline-xl text-headline-xl text-primary font-bold"><?= $validatedCount ?></span>',
                c_dash)
c_dash = re.sub(r'<span class="font-headline-xl text-headline-xl text-primary font-bold">29<\/span>',
                '<span class="font-headline-xl text-headline-xl text-primary font-bold"><?= $deploymentCount ?></span>',
                c_dash)

with open(p_dash, 'w', encoding='utf-8') as f:
    f.write(c_dash)
print('Model Registry dashboard.php patched successfully.')
