/**
 * VOSTOKPRIBOR AI • SYS-AI-05: AI SOC (OPERATIONS CENTER) CONTROLLER
 */

// 1. Alert Selection & Inspection (IncidentTriage.php)
function selectAlert(alertId) {
    console.log("Selected Alert for Inspection: " + alertId);
    document.querySelectorAll('.alert-row').forEach(row => {
        row.classList.remove('bg-surface-container-high', 'border-l-4', 'border-tertiary');
    });
    const target = document.getElementById('alert-' + alertId);
    if (target) {
        target.classList.add('bg-surface-container-high', 'border-l-4', 'border-tertiary');
    }
    const inspector = document.getElementById('alert-inspector');
    if (inspector) {
        inspector.classList.remove('hidden');
    }
    if (window.showToast) {
        window.showToast(`Inspecting incident trace for Alert #${alertId}. Telemetry correlated.`, 'info', 'ALERT TRIAGE');
    }
}

// 2. Incident War Room & Drill Handlers
document.addEventListener('DOMContentLoaded', () => {
    // Telemetry Counter & Sync (FleetTelemetry.php)
    const counterEl = document.getElementById('telemetry-counter');
    const syncBtn = document.getElementById('btn-manual-sync');
    const muteBtn = document.getElementById('btn-mute-alert');
    let secondsAgo = 2;

    if (counterEl) {
        setInterval(() => {
            secondsAgo++;
            if (counterEl) {
                counterEl.textContent = `${secondsAgo}s ago`;
            }
            if (secondsAgo >= 5) {
                secondsAgo = 0;
                if (counterEl) {
                    counterEl.textContent = '0s ago (synced)';
                }
            }
        }, 1000);
    }

    if (syncBtn) {
        syncBtn.addEventListener('click', () => {
            secondsAgo = 0;
            if (counterEl) {
                counterEl.textContent = '0s ago (force synced)';
            }
            if (window.showToast) {
                window.showToast('Manual telemetry poll sent to Istio mesh.', 'info', 'FORCE SYNC');
            }
        });
    }

    if (muteBtn) {
        muteBtn.addEventListener('click', () => {
            muteBtn.textContent = 'Alert Muted (29:59)';
            muteBtn.classList.add('opacity-60');
            if (window.showToast) {
                window.showToast('Audio/Visual alarms suppressed for 30 minutes. Telemetry logging continues.', 'warning', 'ALARM MUTED');
            }
        });
    }

    // Pin Findings to War Room (DriftInvestigationWorkspace.php)
    const pinBtn = document.getElementById('btnPinFindings');
    if (pinBtn) {
        pinBtn.addEventListener('click', () => {
            pinBtn.disabled = true;
            pinBtn.innerHTML = `<span class="material-symbols-outlined text-sm">push_pin</span> Findings Pinned to War Room`;
            pinBtn.classList.add('bg-tertiary-container', 'text-tertiary');
            if (window.showToast) {
                window.showToast('Drift analysis & Kolmogorov-Smirnov p-value matrix pinned to INC-4092 War Room.', 'success', 'WAR ROOM DISPATCH');
            }
        });
    }

    // Submit Drill / Post-Mortem (IncidentPostMortem.php)
    const submitDrillBtn = document.getElementById('submitDrillBtn');
    if (submitDrillBtn) {
        submitDrillBtn.addEventListener('click', () => {
            submitDrillBtn.disabled = true;
            submitDrillBtn.innerHTML = `<span class="material-symbols-outlined text-sm animate-spin">refresh</span> Submitting Evaluation...`;
            setTimeout(() => {
                submitDrillBtn.disabled = false;
                submitDrillBtn.innerHTML = `<span class="material-symbols-outlined text-sm">verified</span> Post-Mortem Certified`;
                if (window.showToast) {
                    window.showToast('Post-Mortem approved by Flight Director. Score: 98/100 (Level 3 AI SOC Operator Certified).', 'success', 'EVALUATION RECORDED');
                }
            }, 1400);
        });
    }

    console.log('SYS-AI-05 AI SOC controller initialized.');
});
