/**
 * VOSTOKPRIBOR AI • SYS-AI-02: DATA CENTER & CATALOG CLIENT LOGIC
 */

document.addEventListener('DOMContentLoaded', () => {
    // 1. Dynamic Navigation Active State Sync
    const currentPath = window.location.pathname.split('/').pop().toLowerCase();
    const navLinks = document.querySelectorAll('aside nav a[data-path]');
    if (navLinks.length > 0) {
        navLinks.forEach(link => {
            const linkHref = (link.getAttribute('href') || '').toLowerCase();
            const linkDataPath = (link.getAttribute('data-path') || '').toLowerCase();
            const isMatch = (currentPath && linkHref.includes(currentPath)) ||
                (currentPath.includes('upload') && linkDataPath.includes('upload')) ||
                (currentPath.includes('recent') && linkDataPath.includes('audit')) ||
                (currentPath.includes('query') && linkDataPath.includes('query')) ||
                (currentPath.includes('datasetcatalog') && linkDataPath.includes('catalog')) ||
                (currentPath.includes('profiling') && linkDataPath.includes('profiling')) ||
                (currentPath.includes('mydataset') && linkDataPath.includes('my-dataset')) ||
                (currentPath === 'dashboard.php' && linkDataPath === 'catalog-overview');

            if (isMatch) {
                link.className = 'flex items-center gap-3 px-3 py-2 rounded bg-primary-container text-on-primary font-bold shadow-[0_0_0_1px_#E8C9A0] font-body-md text-body-md transition-all';
            } else {
                link.className = 'flex items-center gap-3 px-3 py-2 rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface font-body-md text-body-md transition-all';
            }
        });
    }

    // 2. Ingest Buttons Micro-Interactions (dashboard.php, DataProfilingAndQuality.php)
    const allButtons = document.querySelectorAll('button');
    allButtons.forEach(btn => {
        if (btn.textContent.includes('Ingest') || btn.querySelector('span')?.textContent?.includes('Ingest')) {
            btn.addEventListener('click', () => {
                const originalText = btn.innerHTML;
                btn.innerHTML = '<span class="material-symbols-outlined text-[14px] animate-spin">refresh</span><span>Ingesting...</span>';
                setTimeout(() => {
                    btn.innerHTML = '<span class="material-symbols-outlined text-[14px]">check</span><span>Ready in SYS-03</span>';
                    btn.classList.remove('bg-primary-container');
                    btn.classList.add('bg-[#10B981]');
                }, 800);
            });
        }
    });

    // 3. Audit Ledger Live Filtering & Pill Toggling (RecentActivityAndAudit.php)
    const auditFilterInput = document.getElementById('auditFilterInput');
    const filterPills = document.querySelectorAll('#filterPillGroup button');
    const auditEntries = document.querySelectorAll('#auditLedgerStream > div');

    if (auditFilterInput && auditEntries.length > 0) {
        auditFilterInput.addEventListener('input', (e) => {
            const val = e.target.value.toLowerCase().trim();
            auditEntries.forEach(entry => {
                const text = entry.textContent.toLowerCase();
                if (!val || text.includes(val)) {
                    entry.style.display = 'flex';
                } else {
                    entry.style.display = 'none';
                }
            });
        });
    }

    if (filterPills.length > 0 && auditEntries.length > 0) {
        filterPills.forEach(pill => {
            pill.addEventListener('click', () => {
                filterPills.forEach(p => {
                    p.className = 'px-2.5 py-1 rounded font-label-sm text-label-sm bg-surface-container-low text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors whitespace-nowrap';
                });
                pill.className = 'px-2.5 py-1 rounded font-label-sm text-label-sm bg-primary-container text-on-primary whitespace-nowrap shadow-sm';

                const pillText = pill.textContent.trim().toLowerCase();
                auditEntries.forEach(entry => {
                    if (pillText.includes('all')) {
                        entry.style.display = 'flex';
                    } else if (pillText.includes('duckdb') && entry.textContent.includes('DUCKDB')) {
                        entry.style.display = 'flex';
                    } else if (pillText.includes('ingestion') && entry.textContent.includes('INGEST')) {
                        entry.style.display = 'flex';
                    } else if (pillText.includes('quarantine') && entry.textContent.includes('PII')) {
                        entry.style.display = 'flex';
                    } else if (pillText.includes('handoff') && entry.textContent.includes('HANDOFF')) {
                        entry.style.display = 'flex';
                    } else {
                        entry.style.display = 'none';
                    }
                });
            });
        });
    }

    // 4. Query Workspace Interactive Micro-actions (QueryWorkspace.php)
    const runQueryBtn = document.getElementById('runQueryBtn');
    if (runQueryBtn) {
        runQueryBtn.addEventListener('click', function() {
            const btn = this;
            const originalText = btn.innerHTML;
            btn.innerHTML = '<span class="material-symbols-outlined text-[18px] animate-spin">refresh</span><span>EXECUTING IN WASM...</span>';
            btn.classList.add('opacity-80');

            setTimeout(() => {
                btn.innerHTML = originalText;
                btn.classList.remove('opacity-80');
            }, 450);
        });
    }

    const flushCacheBtn = document.getElementById('flushCacheBtn');
    if (flushCacheBtn) {
        flushCacheBtn.addEventListener('click', function() {
            const btn = this;
            btn.innerText = 'FLUSHING...';
            setTimeout(() => {
                btn.innerHTML = '<span class="material-symbols-outlined text-[14px]">check</span><span>CACHE FLUSHED</span>';
                setTimeout(() => {
                    btn.innerHTML = '<span class="material-symbols-outlined text-[14px]">cleaning_services</span><span>FLUSH CACHE</span>';
                }, 1200);
            }, 300);
        });
    }

    const formatSqlBtn = document.getElementById('formatSqlBtn');
    if (formatSqlBtn) {
        formatSqlBtn.addEventListener('click', function() {
            const btn = this;
            btn.innerHTML = '<span class="material-symbols-outlined text-[16px] text-[#10B981]">done</span><span>FORMATTED</span>';
            setTimeout(() => {
                btn.innerHTML = '<span class="material-symbols-outlined text-[16px]">code</span><span>FORMAT SQL</span>';
            }, 1000);
        });
    }

    // Keyboard shortcut listener for Ctrl+Enter
    window.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
            const btn = document.getElementById('runQueryBtn');
            if (btn) {
                e.preventDefault();
                btn.click();
            }
        }
    });
});

// 5. MyDataSet.php Global Interactive State Engine Functions
window.switchFilterTab = function(tabId, el) {
    document.querySelectorAll('.filter-tab-btn').forEach(btn => {
        btn.classList.remove('bg-primary-container', 'text-on-primary', 'shadow-sm');
        btn.classList.add('bg-surface-container-low', 'text-on-surface-variant');
    });
    if (el) {
        el.classList.add('bg-primary-container', 'text-on-primary', 'shadow-sm');
        el.classList.remove('bg-surface-container-low', 'text-on-surface-variant');
    }

    const rows = document.querySelectorAll('.dataset-row-item');
    rows.forEach(r => {
        if (tabId === 'all') {
            r.style.display = 'grid';
        } else if (tabId === 'pinned') {
            r.style.display = r.dataset.pinned === 'true' ? 'grid' : 'none';
        } else if (tabId === 'scratchpad') {
            r.style.display = r.dataset.type === 'scratchpad' ? 'grid' : 'none';
        } else if (tabId === 'draft') {
            r.style.display = r.dataset.type === 'draft' ? 'grid' : 'none';
        } else {
            r.style.display = 'grid';
        }
    });
};

window.toggleViewMode = function(mode) {
    const listView = document.getElementById('dataset-list-container');
    const gridView = document.getElementById('dataset-grid-container');
    const btnList = document.getElementById('toggle-list-btn');
    const btnGrid = document.getElementById('toggle-grid-btn');

    if (!listView || !gridView) return;

    if (mode === 'grid') {
        listView.classList.add('hidden');
        gridView.classList.remove('hidden');
        if (btnGrid) {
            btnGrid.classList.add('bg-primary-container', 'text-on-primary');
            btnGrid.classList.remove('bg-surface-container-low', 'text-on-surface-variant');
        }
        if (btnList) {
            btnList.classList.add('bg-surface-container-low', 'text-on-surface-variant');
            btnList.classList.remove('bg-primary-container', 'text-on-primary');
        }
    } else {
        gridView.classList.add('hidden');
        listView.classList.remove('hidden');
        if (btnList) {
            btnList.classList.add('bg-primary-container', 'text-on-primary');
            btnList.classList.remove('bg-surface-container-low', 'text-on-surface-variant');
        }
        if (btnGrid) {
            btnGrid.classList.add('bg-surface-container-low', 'text-on-surface-variant');
            btnGrid.classList.remove('bg-primary-container', 'text-on-primary');
        }
    }
};

window.filterBySearch = function(query) {
    const q = (query || '').toLowerCase().trim();
    const items = document.querySelectorAll('.dataset-item-target');
    items.forEach(el => {
        const text = el.getAttribute('data-search-index') || el.innerText.toLowerCase();
        el.style.display = text.toLowerCase().includes(q) ? '' : 'none';
    });
};

window.selectAllRows = function(masterCheckbox) {
    const checkboxes = document.querySelectorAll('.row-select-checkbox');
    checkboxes.forEach(cb => {
        cb.checked = masterCheckbox.checked;
        const row = cb.closest('.dataset-row-item');
        if (row) {
            if (masterCheckbox.checked) {
                row.classList.add('bg-surface-container-high/60');
            } else {
                row.classList.remove('bg-surface-container-high/60');
            }
        }
    });
    updateSelectedCount();
};

window.handleRowCheck = function(cb) {
    const row = cb.closest('.dataset-row-item');
    if (cb.checked) {
        if (row) row.classList.add('bg-surface-container-high/60');
    } else {
        if (row) row.classList.remove('bg-surface-container-high/60');
    }
    updateSelectedCount();
};

window.updateSelectedCount = function() {
    const selected = document.querySelectorAll('.row-select-checkbox:checked').length;
    const countEl = document.getElementById('selected-counter-display');
    if (countEl) {
        countEl.innerText = selected + ' SELECTED';
    }
};

window.copySnippet = function(id) {
    const el = document.getElementById(id);
    if (!el) return;
    const snip = el.innerText;
    navigator.clipboard.writeText(snip);
    const toast = document.getElementById('quick-feedback-toast');
    if (toast) {
        toast.classList.remove('opacity-0', 'pointer-events-none');
        setTimeout(() => {
            toast.classList.add('opacity-0', 'pointer-events-none');
        }, 2000);
    }
};

