// VOSTOKPRIBOR AI Engineering Range - SYS-AI-03 ML Workbench Main Script

document.addEventListener('DOMContentLoaded', () => {
    // 1. Sidebar Navigation Active Link Sync
    const syncSidebar = () => {
        const activeLink = document.querySelector('aside a[data-path="model-artifacts"]');
        if (activeLink) {
            document.querySelectorAll('aside nav a').forEach(el => {
                el.classList.remove('bg-primary-container', 'text-on-primary', 'font-bold', 'shadow-sm');
                el.classList.add('text-on-surface-variant');
            });
            activeLink.classList.remove('text-on-surface-variant');
            activeLink.classList.add('bg-primary-container', 'text-on-primary', 'font-bold', 'shadow-sm');
        }
    };
    syncSidebar();

    // 2. Numerical Matrix Cell Probe Readout (TensorInspector)
    document.querySelectorAll('[data-val]').forEach(cell => {
        cell.addEventListener('mouseenter', () => {
            const val = cell.getAttribute('data-val');
            const feat = cell.getAttribute('data-feature');
            const probe = document.getElementById('cell-probe');
            if (probe) {
                probe.innerHTML = `<span class="material-symbols-outlined text-[14px]">pin_drop</span><span>Selected: <strong class="text-primary font-bold">${feat} = ${val}</strong></span>`;
            }
        });
    });

    // 3. Copy Slice Helper (TensorInspector)
    const btnCopy = document.getElementById('btn-copy-slice');
    if (btnCopy) {
        btnCopy.addEventListener('click', () => {
            if (navigator.clipboard) {
                navigator.clipboard.writeText('X_train_res[0:10, 0:6]').then(() => {
                    btnCopy.innerHTML = '<span class="material-symbols-outlined text-[14px] text-primary">check</span>';
                    setTimeout(() => {
                        btnCopy.innerHTML = '<span class="material-symbols-outlined text-[14px]">content_copy</span>';
                    }, 1500);
                });
            }
        });
    }

    // 4. Garbage Collect Feedback (TensorInspector)
    const btnGc = document.getElementById('btn-gc');
    if (btnGc) {
        btnGc.addEventListener('click', () => {
            btnGc.classList.add('opacity-75');
            btnGc.innerHTML = '<span class="material-symbols-outlined text-[15px] animate-spin">sync</span><span>Collecting...</span>';
            setTimeout(() => {
                btnGc.classList.remove('opacity-75');
                btnGc.innerHTML = '<span class="material-symbols-outlined text-[15px] text-primary">check_circle</span><span>Freed 42.1 MB</span>';
                setTimeout(() => {
                    btnGc.innerHTML = '<span class="material-symbols-outlined text-[15px] text-primary">recycling</span><span>gc.collect()</span>';
                }, 2000);
            }, 700);
        });
    }

    // 5. Benchmark Promotion & Registry Submissions (RangeEvaluation)
    const promoteBtn = document.getElementById('promote-btn');
    if (promoteBtn) {
        promoteBtn.addEventListener('click', () => {
            alert('Candidate Run #04 successfully signed and staged for SYS-AI-04 Model Registry promotion.');
        });
    }

    const submitRegistryBtn = document.getElementById('submit-registry-btn');
    if (submitRegistryBtn) {
        submitRegistryBtn.addEventListener('click', () => {
            alert('Model manifest, test dossiers, and cryptographic evaluation proof transmitted to SYS-AI-04.');
        });
    }
});
