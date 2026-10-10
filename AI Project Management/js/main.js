/**
 * VOSTOKPRIBOR AI • SYS-AI-01: AI PROJECT MANAGEMENT CLIENT LOGIC
 */

// Toggle Ticket Details Drawer (Tickets.php)
function toggleDetails(id) {
    const drawer = document.getElementById('drawer-' + id);
    if (!drawer) return;
    drawer.classList.toggle('hidden');
}

document.addEventListener('DOMContentLoaded', () => {
    // 1. Ticket Filtering & Search Engine (Tickets.php)
    const searchInput = document.getElementById('searchInput');
    const filterStatus = document.getElementById('filterStatus');
    const filterPriority = document.getElementById('filterPriority');
    const filterDept = document.getElementById('filterDept');
    const filterScenario = document.getElementById('filterScenario');
    const filterDeadline = document.getElementById('filterDeadline');
    const resetFiltersBtn = document.getElementById('resetFilters');
    const rows = document.querySelectorAll('.ticket-row');

    if (searchInput && rows.length > 0) {
        function applyFilters() {
            const query = (searchInput.value || '').toLowerCase().trim();
            const status = filterStatus ? filterStatus.value : 'ALL';
            const priority = filterPriority ? filterPriority.value : 'ALL';
            const dept = filterDept ? filterDept.value : 'ALL';
            const scenario = filterScenario ? filterScenario.value : 'ALL';
            const deadline = filterDeadline ? filterDeadline.value : 'ALL';

            rows.forEach(row => {
                const id = (row.getAttribute('data-id') || '').toLowerCase();
                const text = row.innerText.toLowerCase();
                const rowStatus = row.getAttribute('data-status');
                const rowPriority = row.getAttribute('data-priority');
                const rowDept = row.getAttribute('data-dept');
                const rowScenario = row.getAttribute('data-scenario');
                const isUrgent = row.getAttribute('data-urgent') === 'true';

                let matchesSearch = !query || id.includes(query) || text.includes(query);
                let matchesStatus = (status === 'ALL') || (rowStatus === status);
                let matchesPriority = (priority === 'ALL') || (rowPriority === priority);
                let matchesDept = (dept === 'ALL') || (rowDept === dept);
                let matchesScenario = (scenario === 'ALL') || (rowScenario === scenario);
                let matchesDeadline = (deadline === 'ALL') ||
                    (deadline === 'URGENT' && isUrgent) ||
                    (deadline === 'ARCHIVED' && rowStatus === 'Approved') ||
                    (deadline === 'WEEK' && !isUrgent);

                const drawer = document.getElementById('drawer-' + row.getAttribute('data-id'));

                if (matchesSearch && matchesStatus && matchesPriority && matchesDept && matchesScenario && matchesDeadline) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                    if (drawer) drawer.classList.add('hidden');
                }
            });
        }

        searchInput.addEventListener('input', applyFilters);
        if (filterStatus) filterStatus.addEventListener('change', applyFilters);
        if (filterPriority) filterPriority.addEventListener('change', applyFilters);
        if (filterDept) filterDept.addEventListener('change', applyFilters);
        if (filterScenario) filterScenario.addEventListener('change', applyFilters);
        if (filterDeadline) filterDeadline.addEventListener('change', applyFilters);

        if (resetFiltersBtn) {
            resetFiltersBtn.addEventListener('click', () => {
                searchInput.value = '';
                if (filterStatus) filterStatus.value = 'ALL';
                if (filterPriority) filterPriority.value = 'ALL';
                if (filterDept) filterDept.value = 'ALL';
                if (filterScenario) filterScenario.value = 'ALL';
                if (filterDeadline) filterDeadline.value = 'ALL';
                applyFilters();
            });
        }
    }

    // 2. View Toggle (Table vs Kanban)
    const btnTable = document.getElementById('viewBtnTable');
    const btnKanban = document.getElementById('viewBtnKanban');
    if (btnTable && btnKanban) {
        btnKanban.addEventListener('click', () => {
            btnKanban.className = "flex items-center gap-space-xs px-space-md py-1.5 rounded bg-surface-container-lowest text-primary shadow-sm font-label-md text-label-md font-semibold transition-all";
            btnTable.className = "flex items-center gap-space-xs px-space-md py-1.5 rounded text-on-surface-variant hover:text-primary font-label-md text-label-md transition-all";
        });
        btnTable.addEventListener('click', () => {
            btnTable.className = "flex items-center gap-space-xs px-space-md py-1.5 rounded bg-surface-container-lowest text-primary shadow-sm font-label-md text-label-md font-semibold transition-all";
            btnKanban.className = "flex items-center gap-space-xs px-space-md py-1.5 rounded text-on-surface-variant hover:text-primary font-label-md text-label-md transition-all";
        });
    }

    // 3. TicketDetails Dropzone & Benchmarking (TicketDetails.php)
    const dropzone = document.getElementById('dropzone');
    const fileInput = document.getElementById('file-input');
    const stagedFiles = document.getElementById('staged-files');
    const runBtn = document.getElementById('run-bench-btn');

    if (dropzone && fileInput) {
        dropzone.addEventListener('click', () => fileInput.click());
        fileInput.addEventListener('change', (e) => {
            if (e.target.files.length > 0) {
                const file = e.target.files[0];
                const div = document.createElement('div');
                div.className = "flex items-center justify-between p-space-sm rounded bg-surface-container text-body-sm font-body-sm animate-pulse";
                div.innerHTML = `
                    <div class="flex items-center gap-2 overflow-hidden">
                        <span class="material-symbols-outlined text-[16px] text-secondary">inventory_2</span>
                        <span class="font-code-inline truncate max-w-[180px]">${file.name}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-on-surface-variant font-label-sm text-label-sm">${(file.size / 1024 / 1024).toFixed(2)} MB</span>
                        <span class="material-symbols-outlined text-[16px] text-primary">cloud_done</span>
                    </div>
                `;
                if (stagedFiles) stagedFiles.appendChild(div);
                setTimeout(() => div.classList.remove('animate-pulse'), 800);
            }
        });
    }

    if (runBtn) {
        runBtn.addEventListener('click', () => {
            const originalText = runBtn.innerHTML;
            runBtn.innerHTML = `
                <span class="material-symbols-outlined text-[18px] animate-spin">refresh</span>
                <span>Benchmarking Ingested Model...</span>
            `;
            runBtn.disabled = true;
            setTimeout(() => {
                runBtn.innerHTML = `
                    <span class="material-symbols-outlined text-[18px]">task_alt</span>
                    <span>Pre-flight Passed: F1 = 0.834</span>
                `;
                runBtn.classList.remove('bg-primary');
                runBtn.classList.add('bg-primary-container');
                setTimeout(() => {
                    runBtn.innerHTML = originalText;
                    runBtn.classList.remove('bg-primary-container');
                    runBtn.classList.add('bg-primary');
                    runBtn.disabled = false;
                }, 4000);
            }, 2000);
        });
    }

    // 4. Submissions List vs Matrix View & Modal (Submissions.php)
    const viewListBtn = document.getElementById('viewListBtn');
    const viewMatrixBtn = document.getElementById('viewMatrixBtn');
    const listContainer = document.getElementById('submissionsListContainer');
    const matrixContainer = document.getElementById('submissionsMatrixContainer');

    if (viewListBtn && viewMatrixBtn && listContainer && matrixContainer) {
        viewListBtn.addEventListener('click', () => {
            listContainer.classList.remove('hidden');
            listContainer.classList.add('flex');
            matrixContainer.classList.add('hidden');
            matrixContainer.classList.remove('flex');
            viewListBtn.className = 'flex items-center gap-1 px-space-sm py-1 rounded bg-primary text-on-primary font-label-sm text-label-sm font-semibold shadow-sm transition-colors';
            viewMatrixBtn.className = 'flex items-center gap-1 px-space-sm py-1 rounded text-on-surface-variant font-label-sm text-label-sm font-semibold hover:text-on-surface transition-colors';
        });

        viewMatrixBtn.addEventListener('click', () => {
            matrixContainer.classList.remove('hidden');
            matrixContainer.classList.add('flex');
            listContainer.classList.add('hidden');
            listContainer.classList.remove('flex');
            viewMatrixBtn.className = 'flex items-center gap-1 px-space-sm py-1 rounded bg-primary text-on-primary font-label-sm text-label-sm font-semibold shadow-sm transition-colors';
            viewListBtn.className = 'flex items-center gap-1 px-space-sm py-1 rounded text-on-surface-variant font-label-sm text-label-sm font-semibold hover:text-on-surface transition-colors';
        });
    }

    const submitModal = document.getElementById('submitModal');
    const openSubmitModalBtn = document.getElementById('openSubmitModalBtn');
    const quickResubmitBtn = document.getElementById('quickResubmitBtn');
    const closeSubmitModalBtn = document.getElementById('closeSubmitModalBtn');
    const cancelModalBtn = document.getElementById('cancelModalBtn');
    const confirmSubmitBtn = document.getElementById('confirmSubmitBtn');

    function openModal() {
        if (submitModal) {
            submitModal.classList.remove('hidden');
            submitModal.classList.add('flex');
        }
    }

    function closeModal() {
        if (submitModal) {
            submitModal.classList.add('hidden');
            submitModal.classList.remove('flex');
        }
    }

    if (openSubmitModalBtn) openSubmitModalBtn.addEventListener('click', openModal);
    if (quickResubmitBtn) quickResubmitBtn.addEventListener('click', openModal);
    if (closeSubmitModalBtn) closeSubmitModalBtn.addEventListener('click', closeModal);
    if (cancelModalBtn) cancelModalBtn.addEventListener('click', closeModal);

    if (confirmSubmitBtn) {
        confirmSubmitBtn.addEventListener('click', () => {
            confirmSubmitBtn.textContent = 'Verifying Hash & Dispatching...';
            setTimeout(() => {
                closeModal();
                confirmSubmitBtn.textContent = 'Dispatch to Evaluator';
            }, 900);
        });
    }
});
