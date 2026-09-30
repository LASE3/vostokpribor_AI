/**
 * VOSTOKPRIBOR AI • SYS-AI-01: AI PROJECT MANAGEMENT CONTROLLER
 */

// 1. Tab Switcher for Deliverables & Submissions
function switchTab(tabId) {
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('border-tertiary', 'text-tertiary', 'font-bold', 'bg-surface-container-high');
        btn.classList.add('border-transparent', 'text-on-surface-variant');
    });
    const targetBtn = document.getElementById('tab-btn-' + tabId);
    if (targetBtn) {
        targetBtn.classList.add('border-tertiary', 'text-tertiary', 'font-bold', 'bg-surface-container-high');
        targetBtn.classList.remove('border-transparent', 'text-on-surface-variant');
    }
    document.querySelectorAll('.tab-pane').forEach(p => p.classList.add('hidden'));
    const targetPane = document.getElementById('pane-' + tabId);
    if (targetPane) targetPane.classList.remove('hidden');
}

// 2. Roster Filter (InstructorDashboard.php)
function filterRoster() {
    const search = document.getElementById('roster-search')?.value.toLowerCase() || '';
    const rows = document.querySelectorAll('.roster-row');
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(search) ? '' : 'none';
    });
}

// 3. Ticket Board & Kanban (TicketBoard.php)
function initTicketBoard() {
    const kanbanBtn = document.getElementById('viewKanbanBtn') || document.getElementById('view-kanban-btn');
    const listBtn = document.getElementById('viewListBtn') || document.getElementById('view-table-btn');
    const kanbanView = document.getElementById('kanbanBoardView') || document.getElementById('kanban-view');
    const listView = document.getElementById('listViewContainer') || document.getElementById('table-view');

    if (kanbanBtn && listBtn) {
        kanbanBtn.addEventListener('click', () => {
            kanbanBtn.classList.add('bg-primary', 'text-on-primary', 'font-bold');
            kanbanBtn.classList.remove('text-on-surface-variant');
            listBtn.classList.remove('bg-primary', 'text-on-primary', 'font-bold');
            listBtn.classList.add('text-on-surface-variant');
            if (kanbanView) kanbanView.classList.remove('hidden');
            if (listView) listView.classList.add('hidden');
        });

        listBtn.addEventListener('click', () => {
            listBtn.classList.add('bg-primary', 'text-on-primary', 'font-bold');
            listBtn.classList.remove('text-on-surface-variant');
            kanbanBtn.classList.remove('bg-primary', 'text-on-primary', 'font-bold');
            kanbanBtn.classList.add('text-on-surface-variant');
            if (listView) listView.classList.remove('hidden');
            if (kanbanView) kanbanView.classList.add('hidden');
        });
    }

    // Ticket search filter
    const searchInput = document.getElementById('ticketSearchInput');
    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            const query = e.target.value.toLowerCase().trim();
            // Filter Kanban cards
            document.querySelectorAll('#kanbanBoardView .group').forEach(card => {
                const text = card.textContent.toLowerCase();
                card.style.display = text.includes(query) ? '' : 'none';
            });
            // Filter list rows
            document.querySelectorAll('#listViewContainer tbody tr').forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(query) ? '' : 'none';
            });
        });
    }
}

document.addEventListener('DOMContentLoaded', () => {
    initTicketBoard();

    // Grade / Evaluation submission button
    const gradeSubmitBtn = document.getElementById('submitGradeBtn');
    if (gradeSubmitBtn) {
        gradeSubmitBtn.addEventListener('click', (e) => {
            e.preventDefault();
            gradeSubmitBtn.disabled = true;
            gradeSubmitBtn.innerHTML = `<span class="material-symbols-outlined text-[18px] animate-spin">refresh</span> Recording Rubric...`;
            setTimeout(() => {
                gradeSubmitBtn.disabled = false;
                gradeSubmitBtn.innerHTML = `<span class="material-symbols-outlined text-[18px]">check_circle</span> Rubric Synced`;
                if (window.showToast) {
                    window.showToast('Deliverable graded: 87.5% B+ (Provisional - 18h Resubmission Window Active). Notification dispatched to Eng. Gulkaba T.', 'success', 'RUBRIC GRADE RECORDED');
                }
            }, 900);
        });
    }

    console.log('SYS-AI-01 AI Project Management controller initialized.');
});
