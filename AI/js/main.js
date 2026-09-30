/**
 * VOSTOKPRIBOR AI • SYS-AI-03: ML WORKBENCH INTERACTION CONTROLLER
 */

// 1. Run Comparison Highlighting (CompareRuns.php)
function highlightRun(runId) {
    document.querySelectorAll('.run-card').forEach(el => {
        el.classList.remove('ring-2', 'ring-tertiary', 'bg-surface-container-high');
    });
    const target = document.getElementById('run-' + runId);
    if (target) {
        target.classList.add('ring-2', 'ring-tertiary', 'bg-surface-container-high');
        target.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
}

// 2. Lineage Zoom Controller (ModelLineageGraph.php)
let currentZoom = 1.0;
function adjustZoom(delta) {
    currentZoom = Math.min(Math.max(currentZoom + delta, 0.4), 2.2);
    const canvas = document.getElementById('lineageCanvas') || document.getElementById('graph-container');
    if (canvas) {
        canvas.style.transform = `scale(${currentZoom})`;
        canvas.style.transformOrigin = 'center center';
        canvas.style.transition = 'transform 0.15s ease-out';
    }
    const zoomDisplay = document.getElementById('zoomDisplay');
    if (zoomDisplay) {
        zoomDisplay.textContent = `${Math.round(currentZoom * 100)}%`;
    }
}

function resetZoom() {
    currentZoom = 1.0;
    adjustZoom(0);
}

// 3. Tab controller for Operating Curves (RunResults.php)
function switchOperatingTab(tabId) {
    document.querySelectorAll('.curve-tab').forEach(t => {
        t.classList.remove('border-tertiary', 'text-tertiary', 'font-bold');
        t.classList.add('border-transparent', 'text-on-surface-variant');
    });
    const activeTab = document.getElementById('tab-' + tabId);
    if (activeTab) {
        activeTab.classList.add('border-tertiary', 'text-tertiary', 'font-bold');
        activeTab.classList.remove('border-transparent', 'text-on-surface-variant');
    }
    document.querySelectorAll('.curve-panel').forEach(p => p.classList.add('hidden'));
    const panel = document.getElementById('panel-' + tabId);
    if (panel) panel.classList.remove('hidden');
}

// 4. Workbench Initialization & Micro-interactions
document.addEventListener('DOMContentLoaded', () => {
    // Model Dispatch button (RegisterModelDialog.php)
    const dispatchBtn = document.getElementById('dispatchBtn');
    if (dispatchBtn) {
        dispatchBtn.addEventListener('click', (e) => {
            e.preventDefault();
            dispatchBtn.disabled = true;
            dispatchBtn.innerHTML = `<span class="material-symbols-outlined text-sm animate-spin">refresh</span> Registering Model Checkpoint...`;
            setTimeout(() => {
                dispatchBtn.disabled = false;
                dispatchBtn.innerHTML = `<span class="material-symbols-outlined text-sm">check_circle</span> Dispatched to Registry!`;
                if (window.showToast) {
                    window.showToast('Model registered to SYS-AI-04 Registry as #churn_rf_v2.0 (SHA: 4f9812a). Canary gate active.', 'success', 'REGISTRATION COMPLETE');
                }
            }, 1200);
        });
    }

    // Agent workbench canvas node selection (GenAI_AndAgentWorkbench.php)
    const runAgentBtn = document.getElementById('btnRunAgent');
    if (runAgentBtn) {
        runAgentBtn.addEventListener('click', () => {
            if (window.showToast) {
                window.showToast('Executing LangGraph agent chain: [Planner -> Retrieval -> Critic -> Executor].', 'info', 'AGENT ACTIVE');
            }
        });
    }

    // Operating curve tab buttons
    const tabRoc = document.getElementById('tab-roc');
    const tabPr = document.getElementById('tab-pr');
    const tabConfusion = document.getElementById('tab-confusion');
    if (tabRoc) tabRoc.addEventListener('click', () => switchOperatingTab('roc'));
    if (tabPr) tabPr.addEventListener('click', () => switchOperatingTab('pr'));
    if (tabConfusion) tabConfusion.addEventListener('click', () => switchOperatingTab('confusion'));

    console.log('SYS-AI-03 ML Workbench controller initialized.');
});
