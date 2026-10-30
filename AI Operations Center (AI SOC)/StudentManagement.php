<?php

declare(strict_types=1);

require_once __DIR__ . '/../app/bootstrap.php';

use App\Middleware\AuthorizationMiddleware;
use App\Services\UserService;
use App\Core\Auth;
use App\Core\Csrf;

// Strict Admin-only Access
AuthorizationMiddleware::requireAdmin();

$currentUser = Auth::user();
$userService = new UserService();

$search = trim($_GET['search'] ?? '');
$status = trim($_GET['status'] ?? '');
$cohort = trim($_GET['cohort'] ?? '');

$filterParams = [];
if ($search !== '') $filterParams['search'] = $search;
if ($status !== '') $filterParams['status'] = $status;
if ($cohort !== '') $filterParams['cohort'] = $cohort;

$data = $userService->listStudents($filterParams, 100, 0);
$students = $data['items'];
$totalStudents = $data['total'];

$activeCount = 0;
$inactiveCount = 0;
foreach ($students as $s) {
    if ($s['status'] === 'ACTIVE') $activeCount++;
    else $inactiveCount++;
}

$csrfToken = Csrf::getToken();

require_once __DIR__ . '/../app/Views/Layout/AppLayout.php';

use App\Views\Layout\AppLayout;

AppLayout::start([
    'pageTitle' => 'VOSTOKPRIBOR AI · Cadet & Student Administration',
    'systemKey' => 'soc',
    'activePage' => 'StudentManagement.php',
    'currentUser' => $currentUser,
    'extraHeadHtml' => '
        <link rel="stylesheet" href="css/style.css" />
    ',
]);
?>

<!-- Toast notification container -->
<div id="toast" class="fixed bottom-6 right-6 z-50 transform translate-y-24 opacity-0 transition-all duration-300 px-4 py-3 rounded-xl shadow-xl flex items-center gap-2.5 text-xs text-white"></div>

<!-- Page Title Bar -->
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <div class="flex items-center gap-2 text-xs uppercase tracking-wider text-primary font-bold mb-1">
            <span class="material-symbols-outlined text-base">group</span>
            <span>CADET ADMINISTRATION & SECURITY ROSTER</span>
        </div>
        <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Student Accounts & Flight Assignments</h1>
        <p class="text-xs text-slate-600 mt-1">
            Administrator-controlled enrollment. Cadets can only be created by mission directors. Public registration is locked.
        </p>
    </div>
    <div class="flex items-center gap-3">
        <button onclick="openCreateStudentModal()" class="px-4 py-2.5 rounded-xl bg-primary text-white hover:bg-primary/90 font-bold text-xs flex items-center gap-2 shadow-md hover:shadow-lg transition-all">
            <span class="material-symbols-outlined text-sm">person_add</span>
            <span>+ Enlist New Cadet</span>
        </button>
    </div>
</div>

<!-- Metric Bento Grid -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <div class="p-4 rounded-xl bg-white border border-primary/10 shadow-sm">
        <span class="text-[11px] text-slate-500 font-bold block mb-1">TOTAL ENROLLED</span>
        <strong class="text-2xl text-primary font-extrabold" id="kpi-total"><?= $totalStudents ?></strong>
    </div>
    <div class="p-4 rounded-xl bg-white border border-primary/10 shadow-sm">
        <span class="text-[11px] text-slate-500 font-bold block mb-1">ACTIVE CADETS</span>
        <strong class="text-2xl text-emerald-700 font-extrabold" id="kpi-active"><?= $activeCount ?></strong>
    </div>
    <div class="p-4 rounded-xl bg-white border border-primary/10 shadow-sm">
        <span class="text-[11px] text-slate-500 font-bold block mb-1">SUSPENDED / INACTIVE</span>
        <strong class="text-2xl text-rose-700 font-extrabold" id="kpi-inactive"><?= $inactiveCount ?></strong>
    </div>
    <div class="p-4 rounded-xl bg-white border border-primary/10 shadow-sm">
        <span class="text-[11px] text-slate-500 font-bold block mb-1">SECURITY STATUS</span>
        <strong class="text-2xl text-primary font-extrabold flex items-center gap-1.5">
            <span class="w-3 h-3 rounded-full bg-emerald-500"></span> LOCKED
        </strong>
    </div>
</div>

<!-- Filters Bar -->
<div class="p-4 rounded-xl bg-white border border-primary/10 shadow-sm mb-6 flex flex-wrap items-center justify-between gap-4 text-xs">
    <form method="GET" class="flex flex-wrap items-center gap-3 flex-1">
        <div class="relative w-full sm:w-64">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm">search</span>
            <input
                type="text"
                name="search"
                value="<?= htmlspecialchars($search) ?>"
                placeholder="Search name, email, or ID..."
                class="w-full bg-[#F6F9FF] border border-primary/15 rounded-lg pl-9 pr-3 py-2 text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:border-primary" />
        </div>
        <select name="status" class="bg-[#F6F9FF] border border-primary/15 rounded-lg px-3 py-2 text-xs text-slate-700 focus:outline-none">
            <option value="">All Statuses</option>
            <option value="ACTIVE" <?= $status === 'ACTIVE' ? 'selected' : '' ?>>Active</option>
            <option value="INACTIVE" <?= $status === 'INACTIVE' ? 'selected' : '' ?>>Inactive</option>
            <option value="SUSPENDED" <?= $status === 'SUSPENDED' ? 'selected' : '' ?>>Suspended</option>
        </select>
        <button type="submit" class="px-3.5 py-2 rounded-lg bg-surface-container-low hover:bg-secondary-fixed text-primary font-bold">
            Filter
        </button>
        <?php if ($search || $status || $cohort): ?>
            <a href="StudentManagement.php" class="px-3 py-2 text-slate-500 hover:text-primary">Reset</a>
        <?php endif; ?>
    </form>
</div>

<!-- Cadet Roster Table -->
<div class="bg-white rounded-xl border border-primary/10 shadow-sm overflow-hidden mb-10">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead>
                <tr class="bg-[#F6F9FF] text-slate-500 font-bold border-b border-primary/10 uppercase tracking-wider text-[10px]">
                    <th class="py-3 px-4">Cadet Identifier</th>
                    <th class="py-3 px-4">Full Name</th>
                    <th class="py-3 px-4">Email</th>
                    <th class="py-3 px-4">Cohort</th>
                    <th class="py-3 px-4">Status</th>
                    <th class="py-3 px-4 text-center">Tickets</th>
                    <th class="py-3 px-4 text-center">Submissions</th>
                    <th class="py-3 px-4 text-center">Notebooks</th>
                    <th class="py-3 px-4 text-center">Models</th>
                    <th class="py-3 px-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-primary/5 text-slate-700" id="student-table-body">
                <?php if (empty($students)): ?>
                    <tr>
                        <td colspan="10" class="py-12 text-center text-slate-500">
                            <span class="material-symbols-outlined text-4xl text-slate-300 block mb-2">person_off</span>
                            <strong>No Cadet Accounts Found</strong>
                            <p class="text-[11px] mt-1 text-slate-400">Zero student accounts enrolled. Click "+ Enlist New Cadet" above to provision the first cadet account.</p>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($students as $s): ?>
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3.5 px-4 font-bold text-primary">
                                <?= htmlspecialchars($s['identifier']) ?>
                            </td>
                            <td class="py-3.5 px-4 font-semibold text-slate-900">
                                <?= htmlspecialchars($s['full_name']) ?>
                            </td>
                            <td class="py-3.5 px-4 text-slate-600">
                                <?= htmlspecialchars($s['email']) ?>
                            </td>
                            <td class="py-3.5 px-4 text-slate-600">
                                <?= htmlspecialchars($s['cohort'] ?? 'General') ?>
                            </td>
                            <td class="py-3.5 px-4">
                                <?php if ($s['status'] === 'ACTIVE'): ?>
                                    <span class="px-2 py-0.5 rounded text-[10px] bg-emerald-50 text-emerald-800 border border-emerald-300 font-bold">ACTIVE</span>
                                <?php else: ?>
                                    <span class="px-2 py-0.5 rounded text-[10px] bg-rose-50 text-rose-800 border border-rose-300 font-bold"><?= htmlspecialchars($s['status']) ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="py-3.5 px-4 text-center font-bold text-slate-800">
                                <?= (int)$s['tickets_count'] ?>
                            </td>
                            <td class="py-3.5 px-4 text-center font-bold text-slate-800">
                                <?= (int)$s['submissions_count'] ?>
                            </td>
                            <td class="py-3.5 px-4 text-center font-bold text-slate-800">
                                <?= (int)$s['notebooks_count'] ?>
                            </td>
                            <td class="py-3.5 px-4 text-center font-bold text-slate-800">
                                <?= (int)$s['models_count'] ?>
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <button type="button" onclick="openEditStudentModal(<?= (int)$s['id'] ?>)" title="Edit Student" class="p-1.5 rounded-lg bg-surface-container-low hover:bg-secondary-fixed text-primary transition-colors"><span class="material-symbols-outlined text-sm">edit</span></button>
                                    <button onclick="viewDossier(<?= (int)$s['id'] ?>)" title="View Cadet Dossier" class="p-1.5 rounded-lg bg-surface-container-low hover:bg-secondary-fixed text-primary transition-colors">
                                        <span class="material-symbols-outlined text-sm">visibility</span>
                                    </button>
                                    <button onclick="openResetPasswordModal(<?= (int)$s['id'] ?>, this.dataset.name)" data-name="<?= htmlspecialchars($s['full_name'], ENT_QUOTES, 'UTF-8') ?>" title="Reset Password" class="p-1.5 rounded-lg bg-surface-container-low hover:bg-secondary-fixed text-primary transition-colors">
                                        <span class="material-symbols-outlined text-sm">key</span>
                                    </button>
                                    <button onclick="toggleStudentStatus(<?= (int)$s['id'] ?>, '<?= $s['status'] === 'ACTIVE' ? 'INACTIVE' : 'ACTIVE' ?>')" title="<?= $s['status'] === 'ACTIVE' ? 'Deactivate' : 'Activate' ?>" class="p-1.5 rounded-lg <?= $s['status'] === 'ACTIVE' ? 'hover:bg-rose-50 text-rose-600' : 'hover:bg-emerald-50 text-emerald-600' ?> transition-colors">
                                        <span class="material-symbols-outlined text-sm"><?= $s['status'] === 'ACTIVE' ? 'person_off' : 'how_to_reg' ?></span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div id="modal-edit-student" class="fixed inset-0 bg-primary/40 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
<div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-primary/20"><div class="flex justify-between items-center mb-4"><h3 class="font-bold text-primary text-sm">Edit Student Account</h3><button type="button" onclick="closeModal('modal-edit-student')" aria-label="Close edit student"><span class="material-symbols-outlined">close</span></button></div>
<form id="form-edit-student" onsubmit="handleEditStudent(event)" class="space-y-4 text-xs" method="post"><input type="hidden" name="student_id">
<label class="block">Full name<input required minlength="2" maxlength="120" name="full_name" class="vp-input w-full"></label><label class="block">Email<input required type="email" name="email" class="vp-input w-full"></label><div class="grid grid-cols-2 gap-3"><label>Cohort<input name="cohort" maxlength="64" class="vp-input w-full"></label><label>Department<input name="department" maxlength="120" class="vp-input w-full"></label></div>
<button class="vp-btn vp-btn-primary" type="submit">Save Student Changes</button><p class="text-slate-500">Identifiers and roles are preserved. Password reset and account activation use their separate controls.</p></form></div></div>
<!-- MODAL: Enlist New Cadet -->
<div id="modal-create-student" class="fixed inset-0 bg-primary/40 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-primary/20 relative">
        <div class="flex items-center justify-between pb-4 border-b border-primary/10 mb-4">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-2xl">person_add</span>
                <h3 class="font-bold text-primary uppercase text-sm">Enlist New Cadet Account</h3>
            </div>
            <button onclick="closeModal('modal-create-student')" class="text-slate-400 hover:text-slate-700">
                <span class="material-symbols-outlined text-xl">close</span>
            </button>
        </div>

        <form id="form-create-student" onsubmit="handleCreateStudent(event)" class="space-y-4 text-xs" method="post">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>" />

            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Full Name</label>
                <input type="text" name="full_name" required placeholder="Student full name" class="w-full bg-[#F6F9FF] border border-primary/20 rounded-xl px-3.5 py-2 focus:outline-none focus:border-primary" />
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1">Cadet Identifier</label>
                    <input type="text" name="identifier" required placeholder="e.g. VK-88219" class="w-full bg-[#F6F9FF] border border-primary/20 rounded-xl px-3.5 py-2 focus:outline-none focus:border-primary uppercase" />
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1">Email Address</label>
                    <input type="email" name="email" required placeholder="e.g. alexey.morozov@vostokpribor.space" class="w-full bg-[#F6F9FF] border border-primary/20 rounded-xl px-3.5 py-2 focus:outline-none focus:border-primary" />
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1">Cohort Designation</label>
                    <input type="text" name="cohort" value="" class="w-full bg-[#F6F9FF] border border-primary/20 rounded-xl px-3.5 py-2 focus:outline-none focus:border-primary" />
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1">Department</label>
                    <input type="text" name="department" value="" class="w-full bg-[#F6F9FF] border border-primary/20 rounded-xl px-3.5 py-2 focus:outline-none focus:border-primary" />
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Initial Access Password</label>
                <input type="password" name="password" required minlength="12" maxlength="72" placeholder="12 to 72 characters" class="w-full bg-[#F6F9FF] border border-primary/20 rounded-xl px-3.5 py-2 focus:outline-none focus:border-primary" />
            </div>

            <div class="flex items-center gap-2 pt-1">
                <input disabled type="checkbox" id="must_change_password" name="must_change_password" value="1" checked class="rounded border-primary/30 text-primary focus:ring-0" />
                <label for="must_change_password" class="text-slate-600 font-medium">Password change is required upon first logon</label>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-primary/10">
                <button type="button" onclick="closeModal('modal-create-student')" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold">Cancel</button>
                <button type="submit" id="btn-submit-student" class="px-5 py-2 rounded-xl bg-primary text-white font-bold hover:bg-primary/90 flex items-center gap-1.5 shadow-md">
                    <span>Provision Account</span>
                    <span class="material-symbols-outlined text-sm">check</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL: Reset Password -->
<div id="modal-reset-password" class="fixed inset-0 bg-primary/40 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-sm w-full p-6 shadow-2xl border border-primary/20 relative">
        <div class="flex items-center justify-between pb-3 border-b border-primary/10 mb-4">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-xl">key</span>
                <h3 class="font-bold text-primary uppercase text-sm">Reset Cadet Password</h3>
            </div>
            <button onclick="closeModal('modal-reset-password')" class="text-slate-400 hover:text-slate-700">
                <span class="material-symbols-outlined text-xl">close</span>
            </button>
        </div>

        <form id="form-reset-password" onsubmit="handleResetPassword(event)" class="space-y-4 text-xs" method="post">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>" />
            <input type="hidden" id="reset-student-id" name="student_id" value="" />

            <div>
                <p class="text-slate-600 mb-2">Resetting password for: <strong id="reset-student-name" class="text-slate-900"></strong></p>
                <label class="block font-bold text-slate-700 uppercase mb-1">New Strong Password</label>
                <input type="password" name="new_password" required minlength="12" maxlength="72" placeholder="12 to 72 characters" class="w-full bg-[#F6F9FF] border border-primary/20 rounded-xl px-3.5 py-2 focus:outline-none focus:border-primary" />
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-primary/10">
                <button type="button" onclick="closeModal('modal-reset-password')" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 font-bold">Cancel</button>
                <button type="submit" class="px-4 py-2 rounded-xl bg-primary text-white font-bold hover:bg-primary/90">Apply Reset</button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL: Cadet Dossier Slide-Over / Modal -->
<div id="modal-dossier" class="fixed inset-0 bg-primary/40 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-3xl w-full max-h-[85vh] p-6 shadow-2xl border border-primary/20 relative flex flex-col">
        <div class="flex items-center justify-between pb-3 border-b border-primary/10 mb-4 shrink-0">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-2xl">badge</span>
                <h3 class="font-bold text-primary uppercase text-sm" id="dossier-title">Cadet Dossier</h3>
            </div>
            <button onclick="closeModal('modal-dossier')" class="text-slate-400 hover:text-slate-700">
                <span class="material-symbols-outlined text-xl">close</span>
            </button>
        </div>

        <div class="flex-1 overflow-y-auto space-y-6 text-xs" id="dossier-content">
            <!-- Filled by JS -->
        </div>
    </div>
</div>

<script>
    const CSRF_TOKEN = "<?= htmlspecialchars($csrfToken) ?>";

    function showToast(msg, isError = false) {
        const toast = document.getElementById('toast');
        toast.innerText = msg;
        toast.className = `fixed bottom-6 right-6 z-50 px-4 py-3 rounded-xl shadow-xl flex items-center gap-2.5 text-xs text-white transition-all duration-300 ${isError ? 'bg-rose-700' : 'bg-primary'}`;
        toast.classList.remove('translate-y-24', 'opacity-0');
        toast.classList.add('translate-y-0', 'opacity-100');
        setTimeout(() => {
            toast.classList.add('translate-y-24', 'opacity-0');
            toast.classList.remove('translate-y-0', 'opacity-100');
        }, 3000);
    }

    function openModal(id) {
        document.getElementById(id)?.classList.remove('hidden');
    }

    function closeModal(id) {
        document.getElementById(id)?.classList.add('hidden');
    }

    function openCreateStudentModal() {
        openModal('modal-create-student');
    }

    function openResetPasswordModal(id, name) {
        document.getElementById('reset-student-id').value = id;
        document.getElementById('reset-student-name').innerText = name;
        openModal('modal-reset-password');
    }

    function escapeDossier(value) {
        if (Array.isArray(value)) return value.map(escapeDossier);
        if (value && typeof value === 'object') return Object.fromEntries(Object.entries(value).map(([key, item]) => [key, escapeDossier(item)]));
        return typeof value === 'string' ? value.replace(/[&<>"']/g, c => ({
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#39;'
        } [c])) : value;
    }
    async function viewDossier(id) {
        openModal('modal-dossier');
        const container = document.getElementById('dossier-content');
        container.innerHTML = '<div class="py-8 text-center text-slate-500"><span class="material-symbols-outlined animate-spin text-2xl">sync</span><p class="mt-2">Retrieving flight dossier...</p></div>';

        try {
            const json = await window.RangeClient.get('soc/students/'+Number(id));
            if (!json.success || !json.data) {
                container.innerHTML = '<p class="text-rose-600">Failed to load dossier.</p>';
                return;
            }

            const d = escapeDossier(json.data);
            const p = d.profile;
            document.getElementById('dossier-title').innerText = `Dossier: ${json.data.profile.full_name} (${json.data.profile.identifier})`;

            container.innerHTML = `
                    <div class="flex flex-wrap gap-3"><a class="vp-btn vp-btn-secondary" href="StudentWorkspaces.php?student_id=${Number(id)}">Inspect notebooks &amp; experiments</a><a class="vp-btn vp-btn-secondary" href="ModelManagement.php?student_id=${Number(id)}">Inspect models &amp; versions</a></div><div class="grid grid-cols-2 md:grid-cols-4 gap-3 p-3 bg-surface-container-low rounded-xl">
                        <div><span class="text-slate-400 block text-[10px]">COHORT</span><strong>${p.cohort || 'N/A'}</strong></div>
                        <div><span class="text-slate-400 block text-[10px]">EMAIL</span><strong>${p.email}</strong></div>
                        <div><span class="text-slate-400 block text-[10px]">STATUS</span><strong>${p.status}</strong></div>
                        <div><span class="text-slate-400 block text-[10px]">ENROLLED</span><strong>${p.created_at.split(' ')[0]}</strong></div>
                    </div>

                    <div>
                        <h4 class="font-bold text-primary mb-2 flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-sm">assignment</span> Assigned Tickets (${d.tickets.length})
                        </h4>
                        ${d.tickets.length === 0 ? '<p class="text-slate-400 italic">No tickets assigned yet.</p>' : `
                            <div class="space-y-1.5">
                                ${d.tickets.map(t => `
                                    <div class="p-2.5 rounded-lg bg-slate-50 border border-slate-200 flex items-center justify-between">
                                        <div><strong class="text-primary">${t.ticket_code}</strong>: ${t.title}</div>
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-secondary-fixed text-primary">${t.status}</span>
                                    </div>
                                `).join('')}
                            </div>
                        `}
                    </div>

                    <div>
                        <h4 class="font-bold text-primary mb-2 flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-sm">database</span> Assigned Datasets (${d.datasets.length})
                        </h4>
                        ${d.datasets.length === 0 ? '<p class="text-slate-400 italic">No datasets linked.</p>' : `
                            <div class="space-y-1.5">
                                ${d.datasets.map(ds => `
                                    <div class="p-2 rounded-lg bg-slate-50 border border-slate-200 flex items-center justify-between">
                                        <div><strong>${ds.code}</strong> - ${ds.name}</div>
                                        <span class="text-slate-500 font-mono text-[10px]">${(ds.file_size / 1024).toFixed(1)} KB</span>
                                    </div>
                                `).join('')}
                            </div>
                        `}
                    </div>

                    <div>
                        <h4 class="font-bold text-primary mb-2 flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-sm">terminal</span> Notebooks (${d.notebooks.length})
                        </h4>
                        ${d.notebooks.length === 0 ? '<p class="text-slate-400 italic">No notebooks created yet.</p>' : `
                            <div class="space-y-1.5">
                                ${d.notebooks.map(nb => `
                                    <div class="p-2 rounded-lg bg-slate-50 border border-slate-200 flex items-center justify-between">
                                        <div><strong>${nb.code}</strong>: ${nb.title}</div>
                                        <span class="text-emerald-700 font-bold">${nb.status}</span>
                                    </div>
                                `).join('')}
                            </div>
                        `}
                    </div>

                    <div>
                        <h4 class="font-bold text-primary mb-2 flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-sm">fact_check</span> Deliverables & Submissions (${d.submissions.length})
                        </h4>
                        ${d.submissions.length === 0 ? '<p class="text-slate-400 italic">No deliverables submitted.</p>' : `
                            <div class="space-y-1.5">
                                ${d.submissions.map(sub => `
                                    <div class="p-2 rounded-lg bg-slate-50 border border-slate-200 flex items-center justify-between">
                                        <div><strong>${sub.submission_code}</strong> (Iteration #${sub.iteration}) - ${sub.ticket_code}</div>
                                        <div>
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold ${sub.status === 'APPROVED' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800'}">${sub.status}</span>
                                            ${sub.total_score !== null ? `<span class="ml-2 font-bold text-primary">${sub.total_score}/100</span>` : ''}
                                        </div>
                                    </div>
                                `).join('')}
                            </div>
                        `}
                    </div>
                `;
        } catch (err) {
            container.innerHTML = '<p class="text-rose-600">Error fetching dossier.</p>';
        }
    }
</script>
<?php
AppLayout::end([
    'extraScriptsHtml' => '<script src="../assets/js/range-client.js"></script><script src="../assets/js/soc-training.js"></script>',
]);
?>
