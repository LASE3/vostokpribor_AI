/**
 * VOSTOKPRIBOR AI • SYS-AI-02: DATA CENTER CONTROLLER
 */

// 1. Dataset Catalog Bento / Table Switcher (DatasetCatalog.php)
function initDatasetCatalog() {
    const bentoBtn = document.getElementById('view-bento-btn');
    const tableBtn = document.getElementById('view-table-btn');
    const bentoView = document.getElementById('catalog-bento-view');
    const tableView = document.getElementById('catalog-table-view');

    if (bentoBtn && tableBtn) {
        bentoBtn.addEventListener('click', () => {
            bentoBtn.classList.add('bg-secondary-container', 'text-secondary', 'font-semibold');
            tableBtn.classList.remove('bg-secondary-container', 'text-secondary', 'font-semibold');
            if (bentoView) bentoView.classList.remove('hidden');
            if (tableView) tableView.classList.add('hidden');
        });

        tableBtn.addEventListener('click', () => {
            tableBtn.classList.add('bg-secondary-container', 'text-secondary', 'font-semibold');
            bentoBtn.classList.remove('bg-secondary-container', 'text-secondary', 'font-semibold');
            if (tableView) tableView.classList.remove('hidden');
            if (bentoView) bentoView.classList.add('hidden');
        });
    }
}

// 2. Query Workspace Toggle (QueryWorkspace.php)
function initQueryWorkspace() {
    const btnSql = document.getElementById('btn-mode-sql');
    const btnPandas = document.getElementById('btn-mode-pandas');
    const editorHeader = document.getElementById('query-editor-label');
    const runQueryBtn = document.getElementById('btn-run-query');

    if (btnSql && btnPandas) {
        btnSql.addEventListener('click', () => {
            btnSql.classList.add('bg-tertiary-container', 'text-tertiary', 'font-bold');
            btnPandas.classList.remove('bg-tertiary-container', 'text-tertiary', 'font-bold');
            if (editorHeader) editorHeader.textContent = 'Trino / DuckDB SQL Studio';
        });

        btnPandas.addEventListener('click', () => {
            btnPandas.classList.add('bg-tertiary-container', 'text-tertiary', 'font-bold');
            btnSql.classList.remove('bg-tertiary-container', 'text-tertiary', 'font-bold');
            if (editorHeader) editorHeader.textContent = 'Polars / Pandas Python Console';
        });
    }

    if (runQueryBtn) {
        runQueryBtn.addEventListener('click', () => {
            runQueryBtn.disabled = true;
            runQueryBtn.innerHTML = `<span class="material-symbols-outlined text-sm animate-spin">refresh</span> Executing Ingestion Query...`;
            setTimeout(() => {
                runQueryBtn.disabled = false;
                runQueryBtn.innerHTML = `<span class="material-symbols-outlined text-sm">play_arrow</span> Run Query (F5)`;
                if (window.showToast) {
                    window.showToast('Query returned 14,200 rows in 32ms. Hash: 0x8b32f (Parquet partition cached).', 'success', 'EXECUTION FINISHED');
                }
            }, 850);
        });
    }
}

// 3. Snapshot drawer & Lineage highlights
document.addEventListener('DOMContentLoaded', () => {
    initDatasetCatalog();
    initQueryWorkspace();

    // Collapsible drawer in DatasetDetail.php
    const toggleBtn = document.getElementById('toggle-snapshot-drawer');
    const drawer = document.getElementById('snapshot-drawer');
    if (toggleBtn && drawer) {
        toggleBtn.addEventListener('click', () => {
            drawer.classList.toggle('hidden');
        });
    }

    // Lineage node highlight
    document.querySelectorAll('.lineage-node').forEach(node => {
        node.addEventListener('mouseenter', () => {
            node.classList.add('ring-2', 'ring-secondary');
        });
        node.addEventListener('mouseleave', () => {
            node.classList.remove('ring-2', 'ring-secondary');
        });
    });

    console.log('SYS-AI-02 Data Center controller initialized.');
});
