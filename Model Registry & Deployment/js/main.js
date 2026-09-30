/**
 * VOSTOKPRIBOR AI • SYS-AI-04: MODEL REGISTRY & DEPLOYMENT CONTROLLER
 */

// 1. Rollback Diff Tab Switcher (DeploymentHistoryRollback.php)
function switchDiffTab(tab) {
    document.querySelectorAll('.diff-tab').forEach(b => {
        b.classList.remove('bg-surface-container-high', 'text-tertiary', 'font-bold');
        b.classList.add('text-on-surface-variant');
    });
    const targetTab = document.getElementById('tab-' + tab);
    if (targetTab) {
        targetTab.classList.add('bg-surface-container-high', 'text-tertiary', 'font-bold');
        targetTab.classList.remove('text-on-surface-variant');
    }
    document.querySelectorAll('.diff-panel').forEach(p => p.classList.add('hidden'));
    const targetPanel = document.getElementById('panel-' + tab);
    if (targetPanel) targetPanel.classList.remove('hidden');
}

// 2. Token Mask Switcher (EndpointConsole.php)
function toggleTokenMask() {
    const el = document.getElementById('bearer-token-input');
    const eyeIcon = document.getElementById('bearer-token-icon');
    if (el) {
        if (el.type === 'password') {
            el.type = 'text';
            if (eyeIcon) eyeIcon.textContent = 'visibility_off';
        } else {
            el.type = 'password';
            if (eyeIcon) eyeIcon.textContent = 'visibility';
        }
    }
}

// 3. Deployment & Registry micro-behaviors
document.addEventListener('DOMContentLoaded', () => {
    // Replica Slider (DeploymentWizard.php)
    const slider = document.getElementById('replicaSlider');
    const replicaCountDisplay = document.getElementById('replicaCountDisplay');
    if (slider && replicaCountDisplay) {
        slider.addEventListener('input', (e) => {
            replicaCountDisplay.textContent = `${e.target.value} Pods`;
        });
    }

    // Deploy execution button (DeploymentWizard.php)
    const deployBtn = document.getElementById('btnExecuteDeploy');
    if (deployBtn) {
        deployBtn.addEventListener('click', (e) => {
            e.preventDefault();
            deployBtn.disabled = true;
            deployBtn.innerHTML = `<span class="material-symbols-outlined text-sm animate-spin">refresh</span> Rolling out Triton Pods...`;
            setTimeout(() => {
                deployBtn.disabled = false;
                deployBtn.innerHTML = `<span class="material-symbols-outlined text-sm">rocket_launch</span> Deployment Live!`;
                if (window.showToast) {
                    window.showToast('Canary deployment live at https://gateway.vostokpribor.ai/v2/models/churn_rf_v2/infer. 10% traffic allocated.', 'success', 'CANARY DEPLOYED');
                }
            }, 1500);
        });
    }

    // Test Inference button (EndpointConsole.php)
    const testInferBtn = document.getElementById('btn-test-infer');
    if (testInferBtn) {
        testInferBtn.addEventListener('click', () => {
            testInferBtn.disabled = true;
            testInferBtn.innerHTML = `<span class="material-symbols-outlined text-sm animate-spin">refresh</span> Querying Envoy Ingress...`;
            setTimeout(() => {
                testInferBtn.disabled = false;
                testInferBtn.innerHTML = `<span class="material-symbols-outlined text-sm">send</span> Send Test Inference`;
                if (window.showToast) {
                    window.showToast('Inference 200 OK: { "churn_probability": 0.842, "prediction": 1, "latency_ms": 11.4 }', 'success', 'INFERENCE SUCCESS');
                }
            }, 700);
        });
    }

    // Collapsible drawer in ModelRegistry.php
    const toggleBtn = document.getElementById('toggle-registry-drawer');
    const drawer = document.getElementById('registry-drawer');
    if (toggleBtn && drawer) {
        toggleBtn.addEventListener('click', () => {
            drawer.classList.toggle('hidden');
        });
    }

    console.log('SYS-AI-04 Model Registry controller initialized.');
});
