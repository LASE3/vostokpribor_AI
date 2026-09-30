/**
 * VOSTOKPRIBOR AI • Global Application Framework & Interaction Engine
 * Unifies all 5 aerospace ML subsystems, telemetry, modals, and cross-system events.
 */

(function () {
    'use strict';

    // 1. Toast Notification Subsystem
    function ensureToastContainer() {
        let container = document.getElementById('vostok-toast-container');
        if (!container) {
            container = document.createElement('div');
            container.id = 'vostok-toast-container';
            document.body.appendChild(container);
        }
        return container;
    }

    window.showToast = function (message, type = 'info', title = '') {
        const container = ensureToastContainer();
        const toast = document.createElement('div');
        toast.className = 'vostok-toast';

        let icon = 'info';
        let iconColor = 'text-secondary';
        let borderColor = 'rgba(171, 201, 242, 0.4)';

        if (type === 'success') {
            icon = 'check_circle';
            iconColor = 'text-emerald-400';
            borderColor = 'rgba(52, 211, 153, 0.5)';
        } else if (type === 'warning') {
            icon = 'warning';
            iconColor = 'text-amber-400';
            borderColor = 'rgba(251, 191, 36, 0.5)';
        } else if (type === 'error') {
            icon = 'error';
            iconColor = 'text-rose-400';
            borderColor = 'rgba(244, 63, 94, 0.5)';
        }

        toast.style.borderColor = borderColor;
        toast.innerHTML = `
            <span class="material-symbols-outlined ${iconColor} text-xl mt-0.5 select-none">${icon}</span>
            <div class="flex-1 text-xs">
                ${title ? `<div class="font-semibold text-white tracking-wide uppercase font-mono mb-0.5">${title}</div>` : ''}
                <div class="text-[#c4c6cd] leading-relaxed">${message}</div>
            </div>
            <button class="text-outline hover:text-white transition-colors text-base select-none p-0.5" onclick="this.parentElement.remove()">
                <span class="material-symbols-outlined text-sm">close</span>
            </button>
        `;

        container.appendChild(toast);

        setTimeout(() => {
            toast.classList.add('fade-out');
            setTimeout(() => toast.remove(), 250);
        }, 3600);
    };

    // 2. Global Modal Subsystem
    window.openVostokModal = function (modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    };

    window.closeVostokModal = function (modalId) {
        const modal = typeof modalId === 'string' ? document.getElementById(modalId) : modalId.closest('.vostok-modal-backdrop');
        if (modal) {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }
    };

    // 3. Quick System Switcher (Cmd+K / Ctrl+K)
    function setupQuickSwitcher() {
        const switcherHTML = `
            <div id="vostok-quick-switcher" class="vostok-modal-backdrop">
                <div class="vostok-modal-panel p-6 bg-[#00142a] border border-[#1f3651] shadow-2xl">
                    <div class="flex items-center justify-between pb-3 border-b border-[#1f3651]">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-tertiary">terminal</span>
                            <span class="font-mono text-sm uppercase text-white font-bold tracking-wider">VOSTOKPRIBOR AI // QUICK DISPATCH</span>
                        </div>
                        <button class="text-outline hover:text-white" onclick="closeVostokModal('vostok-quick-switcher')">
                            <span class="material-symbols-outlined text-sm">close</span>
                        </button>
                    </div>
                    <div class="mt-4 relative">
                        <input id="quick-switcher-input" type="text" placeholder="Type subsystem name or command (e.g. SOC, Data, Models)..." 
                            class="w-full bg-[#000f21] border border-[#43474c] rounded-lg px-4 py-2.5 text-sm text-white placeholder-outline focus:border-tertiary outline-none font-mono" />
                    </div>
                    <div class="mt-4 flex flex-col gap-2 max-h-72 overflow-y-auto" id="quick-switcher-list">
                        <a href="${getRelativePrefix()}index.php" class="flex items-center justify-between p-2.5 rounded-lg bg-[#06203a] hover:bg-[#132b45] text-white transition-all group">
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-tertiary">dashboard</span>
                                <div>
                                    <div class="text-xs font-bold font-mono">SYS-PORTAL</div>
                                    <div class="text-[11px] text-[#c4c6cd]">Global Mission Control Dashboard</div>
                                </div>
                            </div>
                            <span class="text-xs font-mono text-outline group-hover:text-tertiary">ENTER ↵</span>
                        </a>
                        <a href="${getRelativePrefix()}AI Project Management/Dashboard.php" class="flex items-center justify-between p-2.5 rounded-lg bg-[#06203a] hover:bg-[#132b45] text-white transition-all group">
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-secondary">folder_special</span>
                                <div>
                                    <div class="text-xs font-bold font-mono">SYS-AI-01 // Projects</div>
                                    <div class="text-[11px] text-[#c4c6cd]">Deliverables, Team Kanban & Sprints</div>
                                </div>
                            </div>
                            <span class="text-xs font-mono text-outline group-hover:text-tertiary">ENTER ↵</span>
                        </a>
                        <a href="${getRelativePrefix()}Data Center/DatasetCatalog.php" class="flex items-center justify-between p-2.5 rounded-lg bg-[#06203a] hover:bg-[#132b45] text-white transition-all group">
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-secondary">dataset</span>
                                <div>
                                    <div class="text-xs font-bold font-mono">SYS-AI-02 // Data Center</div>
                                    <div class="text-[11px] text-[#c4c6cd]">Catalogs, Lineage Graph & SQL Studio</div>
                                </div>
                            </div>
                            <span class="text-xs font-mono text-outline group-hover:text-tertiary">ENTER ↵</span>
                        </a>
                        <a href="${getRelativePrefix()}AI/ML Workbench/WorkbenchHome.php" class="flex items-center justify-between p-2.5 rounded-lg bg-[#06203a] hover:bg-[#132b45] text-white transition-all group">
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-tertiary">precision_manufacturing</span>
                                <div>
                                    <div class="text-xs font-bold font-mono">SYS-AI-03 // ML Workbench</div>
                                    <div class="text-[11px] text-[#c4c6cd]">Experiments, Agents & Architecture</div>
                                </div>
                            </div>
                            <span class="text-xs font-mono text-outline group-hover:text-tertiary">ENTER ↵</span>
                        </a>
                        <a href="${getRelativePrefix()}Model Registry & Deployment/ModelRegistry.php" class="flex items-center justify-between p-2.5 rounded-lg bg-[#06203a] hover:bg-[#132b45] text-white transition-all group">
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-secondary">rocket_launch</span>
                                <div>
                                    <div class="text-xs font-bold font-mono">SYS-AI-04 // Model Registry</div>
                                    <div class="text-[11px] text-[#c4c6cd]">Canary Gates, Triton Deployment & Cards</div>
                                </div>
                            </div>
                            <span class="text-xs font-mono text-outline group-hover:text-tertiary">ENTER ↵</span>
                        </a>
                        <a href="${getRelativePrefix()}AI Operations Center (AI SOC)/FleetTelemetry.php" class="flex items-center justify-between p-2.5 rounded-lg bg-[#06203a] hover:bg-[#132b45] text-white transition-all group">
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-rose-400">shield_with_heart</span>
                                <div>
                                    <div class="text-xs font-bold font-mono">SYS-AI-05 // AI SOC Center</div>
                                    <div class="text-[11px] text-[#c4c6cd]">Live Telemetry, Drift Triage & War Room</div>
                                </div>
                            </div>
                            <span class="text-xs font-mono text-outline group-hover:text-tertiary">ENTER ↵</span>
                        </a>
                    </div>
                </div>
            </div>
        `;
        document.body.insertAdjacentHTML('beforeend', switcherHTML);

        // Filter functionality
        const input = document.getElementById('quick-switcher-input');
        input?.addEventListener('input', (e) => {
            const val = e.target.value.toLowerCase();
            const items = document.querySelectorAll('#quick-switcher-list a');
            items.forEach(item => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(val) ? 'flex' : 'none';
            });
        });
    }

    function getRelativePrefix() {
        const path = window.location.pathname.replace(/\\/g, '/');
        if (path.includes('/AI/ML Workbench/')) return '../../';
        if (path.includes('/AI Operations Center (AI SOC)/')) return '../';
        if (path.includes('/AI Project Management/')) return '../';
        if (path.includes('/Data Center/')) return '../';
        if (path.includes('/Model Registry & Deployment/')) return '../';
        return '';
    }

    // 4. Interactive Action Dispatcher for Buttons and Controls
    function setupInteractiveButtons() {
        document.addEventListener('click', (e) => {
            const btn = e.target.closest('button, [role="button"]');
            if (!btn) return;

            // Check if button is already inside a link or has specific handler
            if (btn.closest('a') && btn.closest('a').getAttribute('href') !== '#') {
                return;
            }

            const text = (btn.textContent || '').trim().toLowerCase();
            const title = (btn.getAttribute('title') || '').toLowerCase();

            // Language Switcher Toggle
            if (text.includes('en / ar') || text.includes('en/ar') || text.includes('[rtl]')) {
                e.preventDefault();
                const isRTL = document.documentElement.getAttribute('dir') === 'rtl';
                if (isRTL) {
                    document.documentElement.setAttribute('dir', 'ltr');
                    btn.classList.remove('text-tertiary');
                    showToast('Switched to English interface (LTR)', 'info', 'LOCALIZATION');
                } else {
                    document.documentElement.setAttribute('dir', 'rtl');
                    btn.classList.add('text-tertiary');
                    showToast('تم التبديل إلى واجهة اللغة العربية (RTL)', 'info', 'LOCALIZATION');
                }
                return;
            }

            // Role Switcher Toggle
            if (text === 'student' || text === 'instructor') {
                e.preventDefault();
                const container = btn.parentElement;
                container.querySelectorAll('button').forEach(b => {
                    b.classList.remove('bg-primary-container', 'text-on-primary', 'font-medium', 'shadow-sm');
                    b.classList.add('text-on-surface-variant');
                });
                btn.classList.add('bg-primary-container', 'text-on-primary', 'font-medium', 'shadow-sm');
                btn.classList.remove('text-on-surface-variant');
                showToast(`Active viewpoint set to: ${text.toUpperCase()}`, 'info', 'ACCESS CONTROL');
                return;
            }

            // Sync / Refresh buttons
            if (text.includes('sync') || title.includes('sync') || btn.querySelector('.material-symbols-outlined')?.textContent === 'sync') {
                e.preventDefault();
                const icon = btn.querySelector('.material-symbols-outlined');
                if (icon) icon.classList.add('animate-spin');
                showToast('Synchronizing avionics telemetry with cluster nodes...', 'info', 'TELEMETRY SYNC');
                setTimeout(() => {
                    if (icon) icon.classList.remove('animate-spin');
                    showToast('Cluster synchronization complete (0ms offset, 88.4 TFLOPS nominal).', 'success', 'TELEMETRY READY');
                }, 900);
                return;
            }

            // View Metrics navigation
            if (title.includes('metrics') || text.includes('view metrics')) {
                e.preventDefault();
                const prefix = getRelativePrefix();
                const target = prefix.includes('AI/ML Workbench') ? 'RunResults.php' : `${prefix}AI/ML Workbench/RunResults.php`;
                showToast('Navigating to Run Results & Operating Curves...', 'info', 'ROUTING');
                setTimeout(() => { window.location.href = target; }, 400);
                return;
            }

            // Compare Artifacts navigation
            if (title.includes('compare') || text.includes('compare artifacts')) {
                e.preventDefault();
                const prefix = getRelativePrefix();
                const target = prefix.includes('AI/ML Workbench') ? 'CompareRuns.php' : `${prefix}AI/ML Workbench/CompareRuns.php`;
                showToast('Opening Multi-Run Artifact Comparator...', 'info', 'ROUTING');
                setTimeout(() => { window.location.href = target; }, 400);
                return;
            }

            // Lineage navigation
            if (title.includes('lineage') || text.includes('inspect lineage') || text.includes('inspect ingestion dag')) {
                e.preventDefault();
                const prefix = getRelativePrefix();
                const target = prefix.includes('Data Center') ? 'DataLineageAndAuditHistory.php' : `${prefix}Data Center/DataLineageAndAuditHistory.php`;
                showToast('Loading Immutable Data Lineage DAG Graph...', 'info', 'ROUTING');
                setTimeout(() => { window.location.href = target; }, 400);
                return;
            }

            // Terminal / Jupyter connection
            if (title.includes('terminal') || text.includes('connect jupyter') || text.includes('vs code')) {
                e.preventDefault();
                showToast('Establishing Secure SSH Tunnel to JupyterLab on Cluster Node-09 (port: 8888)...', 'info', 'JUPYTER BRIDGE');
                return;
            }

            // Preview Schema / Column Specs
            if (text.includes('preview schema') || text.includes('column specs')) {
                e.preventDefault();
                showToast('Dataset Schema: [customer_id: UUID, bandwidth_gb: float64, f1_score: float32, churn_label: int8, region: categorical]. Status: Verified.', 'info', 'SCHEMA INSPECTOR');
                return;
            }

            // Export / Download buttons
            if (text.includes('export') || text.includes('download') || title.includes('download') || title.includes('export')) {
                e.preventDefault();
                showToast('Packaging telemetry artifacts & JSON manifests for download...', 'info', 'EXPORT PIPELINE');
                setTimeout(() => {
                    showToast('Export archive ready: vostok_telemetry_dump.json (2.4 MB)', 'success', 'DOWNLOAD READY');
                }, 1200);
                return;
            }

            // Bug / Crash report buttons
            if (text.includes('bug') || title.includes('crash') || btn.querySelector('.material-symbols-outlined')?.textContent === 'bug_report') {
                e.preventDefault();
                showToast('Analyzing stacktrace: [CUDA OutOfMemoryError: Tensor alloc failed at GPU 0x4]. Telemetry logged to incident queue.', 'warning', 'CRASH INSPECTOR');
                return;
            }

            // Filter / Search buttons
            if (text.includes('filter') || text.includes('apply filter') || title.includes('filter')) {
                e.preventDefault();
                showToast('Filters applied. 18 runs indexed across telemetry window.', 'info', 'QUERY FILTER');
                return;
            }

            // Deploy / Rollback buttons
            if (text.includes('deploy') || text.includes('release') || text.includes('rollback')) {
                e.preventDefault();
                const isRollback = text.includes('rollback');
                const actionWord = isRollback ? 'Rollback sequence initiated' : 'Canary deployment initiated';
                showToast(`${actionWord}: Shifting 10% traffic to target checkpoint. Health checks running...`, 'warning', 'GATEWAY CONTROLLER');
                setTimeout(() => {
                    showToast(`Pipeline stabilized. Zero dropped packets reported across Envoy ingress.`, 'success', 'GATEWAY STABLE');
                }, 1500);
                return;
            }

            // Pagination (Prev / Next)
            if (text.includes('prev') || text.includes('next') || /^[0-9]+$/.test(text)) {
                e.preventDefault();
                const parent = btn.parentElement;
                if (parent) {
                    parent.querySelectorAll('button').forEach(b => {
                        b.classList.remove('bg-secondary-container', 'text-secondary', 'font-bold');
                        b.classList.add('bg-surface-container-high', 'text-on-surface-variant');
                    });
                    btn.classList.add('bg-secondary-container', 'text-secondary', 'font-bold');
                    btn.classList.remove('bg-surface-container-high', 'text-on-surface-variant');
                }
                showToast(`Navigated to page ${text}`, 'info', 'PAGINATION');
                return;
            }

            // Notification bell
            if (btn.querySelector('.material-symbols-outlined')?.textContent === 'notifications') {
                e.preventDefault();
                showToast('3 Operational Alerts: [P1 Drift Anomaly on churn_rf_v2, Canary Stage 2 Ready, Cluster Node-09 Nominal].', 'info', 'COMMUNICATIONS');
                return;
            }

            // Fallback for other buttons without links
            if (!btn.getAttribute('data-handled') && !btn.getAttribute('type')?.includes('submit')) {
                // If it looks like an action button, acknowledge it
                if (text.length > 0 && text.length < 30) {
                    showToast(`Action executed: [${btn.innerText.trim()}]`, 'info', 'COMMAND EXECUTED');
                }
            }
        });
    }

    // 5. Global Hotkeys
    document.addEventListener('keydown', (e) => {
        // Cmd+K or Ctrl+K opens quick switcher
        if ((e.metaKey || e.ctrlKey) && e.key.toLowerCase() === 'k') {
            e.preventDefault();
            const switcher = document.getElementById('vostok-quick-switcher');
            if (switcher && switcher.classList.contains('active')) {
                closeVostokModal('vostok-quick-switcher');
            } else {
                openVostokModal('vostok-quick-switcher');
                setTimeout(() => document.getElementById('quick-switcher-input')?.focus(), 50);
            }
        }

        // Escape closes any active modal
        if (e.key === 'Escape') {
            document.querySelectorAll('.vostok-modal-backdrop.active').forEach(m => {
                m.classList.remove('active');
                document.body.style.overflow = '';
            });
        }
    });

    // 6. Init on DOM Ready
    document.addEventListener('DOMContentLoaded', () => {
        setupQuickSwitcher();
        setupInteractiveButtons();
        console.log('VOSTOKPRIBOR AI Avionics Core initialized.');
    });

})();
