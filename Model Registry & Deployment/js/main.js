// VOSTOKPRIBOR AI Engineering Range - SYS-AI-04 Model Registry & Deployment Main Script

// Global functions for DeployedEndpoints.php (invoked by inline onclick handlers)
window.showToast = function (msg) {
    const toast = document.getElementById('toastNotification');
    const label = document.getElementById('toastMessage');
    if (toast && label) {
        label.innerText = msg;
        toast.classList.remove('translate-y-24', 'opacity-0');
        toast.classList.add('translate-y-0', 'opacity-100');
        setTimeout(() => {
            toast.classList.add('translate-y-24', 'opacity-0');
            toast.classList.remove('translate-y-0', 'opacity-100');
        }, 2800);
    }
};

window.selectEndpoint = function (name) {
    window.showToast(`Loaded live telemetry inspection for endpoint: ${name}`);
};

window.updateTrafficPreview = function (val) {
    const primaryVal = 100 - val;
    const label = document.getElementById('sliderValueLabel');
    const primaryBar = document.getElementById('primarySplitBar');
    const canaryBar = document.getElementById('canarySplitBar');
    if (label) label.innerText = `${val}% Candidate`;
    if (primaryBar) {
        primaryBar.style.width = `${primaryVal}%`;
        primaryBar.innerText = `${primaryVal}% Stable (v2.4.0)`;
    }
    if (canaryBar) {
        canaryBar.style.width = `${val}%`;
        canaryBar.innerText = `${val}% Canary (v2.4.1)`;
    }
};

window.commitTrafficShift = function () {
    const slider = document.getElementById('trafficSlider');
    const val = slider ? slider.value : 0;
    window.showToast(`Routing shifted: ${100 - val}% Primary vs ${val}% Canary deployed.`);
};

window.openCanaryShiftModal = function () {
    const slider = document.getElementById('trafficSlider');
    if (slider) {
        slider.scrollIntoView({
            behavior: 'smooth',
            block: 'center'
        });
    }
    window.showToast('Adjust the traffic allocation slider in the inspection panel.');
};

window.promptRollbackConfirmation = function () {
    const modal = document.getElementById('rollbackModal');
    if (modal) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
};

window.closeRollbackModal = function () {
    const modal = document.getElementById('rollbackModal');
    if (modal) {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
};

window.executeRollback = function () {
    window.closeRollbackModal();
    const slider = document.getElementById('trafficSlider');
    if (slider) {
        slider.value = 0;
        window.updateTrafficPreview(0);
    }
    window.showToast('Cutback complete. Traffic 100% on v2.4.0. Candidate safely drained.');
};

window.purgeCacheNotification = function () {
    window.showToast('Ingress envoy routes purged. Latency cache reset across 3 nodes.');
};

window.copyRouteUrl = function () {
    if (navigator.clipboard) {
        navigator.clipboard.writeText('https://gateway.vostokpribor.internal/v1/predict/churn');
    }
    window.showToast('Gateway URL copied to clipboard.');
};

window.triggerEmergencyDrain = function () {
    if (confirm('Initiate circuit-breaker drain on vp-mod-churn-xgb-prod?')) {
        window.showToast('Circuit breaker activated: Ingress shedding traffic to backup pod.');
    }
};

window.refreshInferenceLog = function () {
    const tbody = document.getElementById('inferenceStreamRows');
    if (!tbody) return;
    const randomReq = 'req_' + Math.random().toString(16).substring(2, 8);
    const latency = (13.0 + Math.random() * 6).toFixed(1);
    const conf = (0.75 + Math.random() * 0.2).toFixed(3);
    const isCanary = Math.random() > 0.8;

    const row = document.createElement('tr');
    row.className = 'hover:bg-surface-container-highest/60 transition-colors animate-in fade-in duration-200';
    row.innerHTML = `
      <td class="py-2 px-3 font-semibold text-primary">${randomReq}</td>
      <td class="py-2 px-3 text-on-surface-variant">Just Now</td>
      <td class="py-2 px-3 text-on-surface">
        <span class="px-1 rounded ${isCanary ? 'bg-secondary-container text-on-secondary-container' : 'bg-surface-container-highest text-primary'} font-bold text-[10px]">
          ${isCanary ? 'v2.4.1' : 'v2.4.0'}
        </span>
      </td>
      <td class="py-2 px-3 text-primary font-bold">${latency} ms</td>
      <td class="py-2 px-3 text-on-surface">churn=0 (${conf} conf)</td>
      <td class="py-2 px-3 text-right text-primary font-bold">200 OK</td>
    `;
    tbody.prepend(row);
    if (tbody.children.length > 5) {
        tbody.removeChild(tbody.lastElementChild);
    }
    window.showToast('Polled 1 new payload telemetry frame.');
};

document.addEventListener('DOMContentLoaded', () => {
    // 1. ValidationPipeline.php Interactions
    const tabButtons = document.querySelectorAll('.tab-btn');
    const tabViews = document.querySelectorAll('.tab-view');

    tabButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const tabTarget = btn.getAttribute('data-tab');
            tabButtons.forEach(b => {
                b.classList.remove('bg-primary-container', 'text-on-primary', 'font-semibold');
                b.classList.add('bg-surface-container-low', 'text-on-surface');
            });
            btn.classList.add('bg-primary-container', 'text-on-primary', 'font-semibold');
            btn.classList.remove('bg-surface-container-low', 'text-on-surface');

            tabViews.forEach(view => {
                if (view.id === `tab-content-${tabTarget}`) {
                    view.classList.remove('hidden');
                } else {
                    view.classList.add('hidden');
                }
            });
        });
    });

    const stepCards = document.querySelectorAll('.step-card');
    const inspectorTitle = document.getElementById('inspector-step-title');
    const inspectorSubtitle = document.getElementById('inspector-step-subtitle');
    const logBody = document.getElementById('log-body');

    const stepLogs = {
        1: {
            title: "Test Output & Assertion Log",
            subtitle: "Step 1 Evidence: Artifact Integrity & SHA256 Checksum",
            html: `
        <div class="text-slate-400 font-label-sm text-label-sm">[2024-10-24 14:02:11.102] INITIALIZING SUITE: sys_ai_04.validation.pipeline</div>
        <div class="text-slate-300">==> Loading target model artifact: /opt/vostok/registry/vp-mod-churn-xgb/v2.4.1/model.xgb</div>
        <div class="text-emerald-400 font-semibold">[PASS] Step 1.1: File existence and non-zero byte stream confirmed (14,249,112 bytes).</div>
        <div class="text-slate-300">==> Computing Cryptographic Hash (SHA-256 algorithm)...</div>
        <div class="text-slate-200 bg-black/30 p-2 rounded">
          EXPECTED: 3f9a88c142b67d19e018a3819e992b4512e0947ba941c9a63b0188ef684a0d81<br>
          COMPUTED: 3f9a88c142b67d19e018a3819e992b4512e0947ba941c9a63b0188ef684a0d81<br>
          STATUS:   MATCH_EXACT (Bit-level verification complete)
        </div>
        <div class="text-emerald-400 font-semibold">[PASS] Step 1.2: Checksum verification succeeded in 184ms.</div>
        <div class="text-slate-300">==> Testing xgboost.Booster deserialization in sandbox memory container...</div>
        <div class="text-emerald-400 font-semibold">[PASS] Step 1.3: xgboost::Learner successfully initialized in memory. Zero corrupted trees detected (n_estimators=350, max_depth=6).</div>
        <div class="text-emerald-400 font-semibold">[PASS] Step 1.4: Deserialization elapsed time 56ms (Budget: &lt; 500ms).</div>
        <div class="text-slate-400 font-label-sm text-label-sm pt-2">[2024-10-24 14:02:11.342] STEP 1 ASSERTION COMPLETE: 4 of 4 tests passed without warning.</div>
      `
        },
        2: {
            title: "Metadata & Specification Inspector",
            subtitle: "Step 2 Evidence: Required Model Card Fields & Licensing",
            html: `
        <div class="text-slate-400 font-label-sm text-label-sm">[2024-10-24 14:02:11.345] INSPECTING METADATA SCHEMA: model_card.yaml</div>
        <div class="text-emerald-400 font-semibold">[PASS] Attribute 'model_id' found: vp-mod-churn-xgb</div>
        <div class="text-emerald-400 font-semibold">[PASS] Attribute 'author' found: Cadet E. Vance (VP-8820)</div>
        <div class="text-emerald-400 font-semibold">[PASS] Attribute 'scenario_id' found: VP-TKT-1082 (Predictive Customer Churn)</div>
        <div class="text-emerald-400 font-semibold">[PASS] Attribute 'license' approved: Apache-2.0</div>
        <div class="text-slate-300">==> Hyperparameters logged: n_estimators=350, learning_rate=0.042, subsample=0.85, colsample_bytree=0.8</div>
        <div class="text-emerald-400 font-semibold">[PASS] Step 2: All 12 mandatory metadata assertions satisfied in 42ms.</div>
      `
        },
        3: {
            title: "Feature Schema Matrix",
            subtitle: "Step 3 Evidence: 24 Input Feature Types & Encodings",
            html: `
        <div class="text-slate-400 font-label-sm text-label-sm">[2024-10-24 14:02:11.388] RUNNING VALIDATION: Schema Enforcement Engine</div>
        <div class="text-slate-300">==> Checking feature columns against standard dataset specification...</div>
        <div class="text-emerald-400 font-semibold">[PASS] 16 Numeric Float32 columns valid (tenure, monthly_charges, total_charges...)</div>
        <div class="text-emerald-400 font-semibold">[PASS] 8 One-Hot Encoded binary columns valid (contract_type_*, payment_type_*)</div>
        <div class="text-emerald-400 font-semibold">[PASS] Zero unmapped or extra payload columns detected. Null policy: strict imputation.</div>
        <div class="text-slate-400 font-label-sm text-label-sm pt-2">[2024-10-24 14:02:11.456] STEP 3 ASSERTION COMPLETE: Schema contract compliant.</div>
      `
        },
        4: {
            title: "Dependency & Runtime Linker Log",
            subtitle: "Step 4 Evidence: ABI & Shared Library Linking",
            html: `
        <div class="text-slate-400 font-label-sm text-label-sm">[2024-10-24 14:02:11.460] VERIFYING DEPENDENCY ISOLATION</div>
        <div class="text-slate-300">==> Python Version: 3.10.12 (CPython runtime container)</div>
        <div class="text-emerald-400 font-semibold">[PASS] xgboost == 1.7.5 (Matches deployment base container)</div>
        <div class="text-emerald-400 font-semibold">[PASS] scikit-learn == 1.3.0 (Matches deployment base container)</div>
        <div class="text-emerald-400 font-semibold">[PASS] numpy == 1.24.3 (OpenBLAS 0.3.21 binary linking ok)</div>
        <div class="text-emerald-400 font-semibold">[PASS] libgomp.so.1 and libpthread.so.0 verified without ABI collision.</div>
      `
        },
        5: {
            title: "Deterministic Reproducibility Log",
            subtitle: "Step 5 Evidence: Seed 42 Replication vs Training Run EXP-884",
            html: `
        <div class="text-slate-400 font-label-sm text-label-sm">[2024-10-24 14:02:12.670] EXECUTING SEED 42 DETERMINISM BENCHMARK</div>
        <div class="text-slate-300">==> Pulling reference log from SYS-AI-03 EXP-884...</div>
        <div class="text-slate-200 bg-black/30 p-2 rounded">
          TRAINING LOSS (EXP-884): 0.284192<br>
          REVALUATION LOSS:        0.284191<br>
          METRIC DELTA:            0.000001 (Tolerance threshold &lt; 0.001)
        </div>
        <div class="text-emerald-400 font-semibold">[PASS] Output probabilities perfectly aligned across random seed execution bounds.</div>
      `
        },
        6: {
            title: "Prediction Smoke Execution Trace",
            subtitle: "Step 6 Evidence: 1,000 Synthetic Baseline Payloads",
            html: `
        <div class="text-slate-400 font-label-sm text-label-sm">[2024-10-24 14:02:31.290] FIRING 1,000 SYNTHETIC SMOKE PAYLOADS</div>
        <div class="text-slate-300">==> Batch size: 50 | Workers: 4 concurrent async coroutines</div>
        <div class="text-emerald-400 font-semibold">[PASS] Invocations completed: 1,000 / 1,000 without exception.</div>
        <div class="text-emerald-400 font-semibold">[PASS] Zero NULL or NaN return values generated.</div>
        <div class="text-emerald-400 font-semibold">[PASS] P50 Latency: 12.1ms | P95 Latency: 18.4ms | Max Latency: 22.0ms</div>
      `
        },
        7: {
            title: "Robustness & Edge-Case Log",
            subtitle: "Step 7 Evidence: 250 Adversarial & Boundary Tests",
            html: `
        <div class="text-slate-400 font-label-sm text-label-sm">[2024-10-24 14:02:33.720] INJECTING ADVERSARIAL EDGE-CASES</div>
        <div class="text-slate-300">==> Test set: 50 Extreme Outliers (+15 Sigma), 50 Null Value Injections, 50 Zero-Variance Vectors, 100 Malformed Encodings</div>
        <div class="text-emerald-400 font-semibold">[PASS] Outlier clipping filter clamped excessive input gracefully.</div>
        <div class="text-emerald-400 font-semibold">[PASS] Null values safely routed through MedianImputer without process crash.</div>
        <div class="text-emerald-400 font-semibold">[PASS] Graceful HTTP 422 raised on forbidden string tokens; zero container segfaults.</div>
      `
        },
        8: {
            title: "SLA Acceptance Gate Inspector",
            subtitle: "Step 8 Evidence: Ticket VP-TKT-1082 Acceptance Criteria",
            html: `
        <div class="text-slate-400 font-label-sm text-label-sm">[2024-10-24 14:02:36.850] TICKET CRITERIA AUDIT: VP-TKT-1082</div>
        <div class="text-slate-200 bg-black/30 p-2 rounded">
          CRITERIA 1: ROC-AUC >= 0.840  --> ACHIEVED: 0.884 [PASSED]<br>
          CRITERIA 2: F1-SCORE >= 0.800 --> ACHIEVED: 0.821 [PASSED]<br>
          CRITERIA 3: P95 LATENCY <= 45ms --> ACHIEVED: 18.4ms [PASSED]
        </div>
        <div class="text-emerald-400 font-semibold">[PASS] ALL ACCEPTANCE GATES FORMALLY MET FOR ENTERPRISE STAGING DEPLOYMENT.</div>
      `
        },
        9: {
            title: "Endpoint API Contract Trace",
            subtitle: "Step 9 Evidence: REST & gRPC Protobuf Handshake",
            html: `
        <div class="text-slate-400 font-label-sm text-label-sm">[2024-10-24 14:03:48.910] TESTING HTTP/REST & gRPC SPECIFICATION</div>
        <div class="text-slate-300">==> Route: POST /v1/predict (OpenAPI v3.0.3 Contract)</div>
        <div class="text-emerald-400 font-semibold">[PASS] HTTP Response 200 OK received with header 'content-type: application/json'</div>
        <div class="text-emerald-400 font-semibold">[PASS] Payload validated against ChurnPredictionResponse schema.</div>
        <div class="text-emerald-400 font-semibold">[PASS] Protobuf proto3 wire-format reflection test passed (churn_service.v1).</div>
      `
        },
        10: {
            title: "Consensus & Manifest Certification",
            subtitle: "Step 10 Evidence: Automated Consensus & Sign-Off Readiness",
            html: `
        <div class="text-slate-400 font-label-sm text-label-sm">[2024-10-24 14:03:49.450] COMPILING VALIDATION MANIFEST</div>
        <div class="text-emerald-400 font-semibold">[PASS] 10 of 10 automated test suites executed with 100% success rate.</div>
        <div class="text-slate-300">==> Manifest ID MAN-VP-8820-04 cryptographically signed by Automated Harness.</div>
        <div class="text-emerald-400 font-bold">[ELIGIBLE] State switched to: 'ELIGIBLE FOR INSTRUCTOR REVIEW'.</div>
        <div class="text-slate-400 font-label-sm text-label-sm pt-2">Pipeline execution finalized in 4m 18s. Target model vp-mod-churn-xgb is ready for manual sign-off.</div>
      `
        }
    };

    stepCards.forEach(card => {
        card.addEventListener('click', () => {
            const stepNumber = card.getAttribute('data-step');
            stepCards.forEach(c => {
                c.classList.remove('active-step');
                const strip = c.querySelector('.indicator-strip');
                if (strip) {
                    strip.classList.remove('bg-primary-container');
                    strip.classList.add('bg-transparent');
                }
            });

            card.classList.add('active-step');
            const strip = card.querySelector('.indicator-strip');
            if (strip) {
                strip.classList.add('bg-primary-container');
                strip.classList.remove('bg-transparent');
            }

            if (stepLogs[stepNumber] && inspectorTitle && inspectorSubtitle && logBody) {
                inspectorTitle.textContent = stepLogs[stepNumber].title;
                inspectorSubtitle.textContent = stepLogs[stepNumber].subtitle;
                logBody.innerHTML = stepLogs[stepNumber].html;

                if (tabButtons[0]) {
                    tabButtons[0].click();
                }
            }
        });
    });

    const btnRerun = document.getElementById('btn-rerun');
    if (btnRerun) {
        btnRerun.addEventListener('click', () => {
            btnRerun.innerHTML = `<span class="material-symbols-outlined text-[16px] animate-spin">sync</span><span>Verifying Harness...</span>`;
            setTimeout(() => {
                btnRerun.innerHTML = `<span class="material-symbols-outlined text-[16px]">check</span><span>Pipeline Verified</span>`;
                setTimeout(() => {
                    btnRerun.innerHTML = `<span class="material-symbols-outlined text-[16px]">refresh</span><span>Re-run Full Pipeline</span>`;
                }, 2000);
            }, 1200);
        });
    }

    // 2. ModelRegistry.php Interactions
    const toggleBtn = document.getElementById('toggleDiffDrawerBtn');
    const minimizeBtn = document.getElementById('minimizeDiffBtn');
    const diffDrawer = document.getElementById('diffDrawer');

    if (toggleBtn && diffDrawer) {
        toggleBtn.addEventListener('click', () => {
            diffDrawer.scrollIntoView({
                behavior: 'smooth'
            });
            diffDrawer.classList.toggle('ring-2');
            diffDrawer.classList.toggle('ring-primary-container');
        });
    }

    if (minimizeBtn && diffDrawer) {
        let minimized = false;
        minimizeBtn.addEventListener('click', () => {
            minimized = !minimized;
            const contentSections = diffDrawer.querySelectorAll('.grid, .pt-space-xs');
            contentSections.forEach(el => {
                el.style.display = minimized ? 'none' : '';
            });
            const icon = minimizeBtn.querySelector('.material-symbols-outlined');
            if (icon) {
                icon.textContent = minimized ? 'expand_more' : 'expand_less';
            }
        });
    }

    // 3. DeploymentConfig.php Interactions
    const tabJson = document.getElementById('tab-json');
    const tabCurl = document.getElementById('tab-curl');
    const tabResp = document.getElementById('tab-resp');
    const viewJson = document.getElementById('view-json');
    const viewCurl = document.getElementById('view-curl');
    const viewResp = document.getElementById('view-resp');

    function setActiveTab(btnActive, viewActive) {
        [tabJson, tabCurl, tabResp].forEach(t => {
            if (t) {
                t.classList.remove('bg-surface-container-lowest', 'text-primary', 'font-bold', 'shadow-sm');
                t.classList.add('text-on-surface-variant');
            }
        });
        [viewJson, viewCurl, viewResp].forEach(v => {
            if (v) {
                v.classList.add('hidden');
                v.classList.remove('flex');
            }
        });

        if (btnActive) {
            btnActive.classList.add('bg-surface-container-lowest', 'text-primary', 'font-bold', 'shadow-sm');
            btnActive.classList.remove('text-on-surface-variant');
        }
        if (viewActive) {
            viewActive.classList.remove('hidden');
            viewActive.classList.add('flex');
        }
    }

    if (tabJson && tabCurl && tabResp) {
        tabJson.addEventListener('click', () => setActiveTab(tabJson, viewJson));
        tabCurl.addEventListener('click', () => setActiveTab(tabCurl, viewCurl));
        tabResp.addEventListener('click', () => setActiveTab(tabResp, viewResp));
    }

    const btnVerifyToken = document.getElementById('btn-verify-token');
    const inputToken = document.getElementById('input-token');
    const tokenStatusMsg = document.getElementById('token-status-msg');

    if (btnVerifyToken && inputToken && tokenStatusMsg) {
        btnVerifyToken.addEventListener('click', () => {
            const val = inputToken.value.trim();
            if (val.length >= 4) {
                tokenStatusMsg.innerHTML = '<span class="text-primary font-bold">✓ Token verified by Instructor Prof. K. Zaitsev. Staging deployment gate unlocked.</span>';
                inputToken.disabled = true;
                btnVerifyToken.disabled = true;
                btnVerifyToken.classList.add('opacity-50');
            } else {
                tokenStatusMsg.innerHTML = '<span class="text-error font-semibold">⚠ Please enter a valid 8-character token (e.g. VP-FAC-4401).</span>';
            }
        });
    }

    const btnCopyIngress = document.getElementById('btn-copy-ingress');
    if (btnCopyIngress) {
        btnCopyIngress.addEventListener('click', () => {
            if (navigator.clipboard) {
                navigator.clipboard.writeText('https://gateway.vostokpribor.internal/v1/predict/churn');
            }
            const orig = btnCopyIngress.innerHTML;
            btnCopyIngress.innerHTML = '<span class="material-symbols-outlined text-[16px]">done</span><span>Copied!</span>';
            setTimeout(() => {
                btnCopyIngress.innerHTML = orig;
            }, 1800);
        });
    }

    const btnDeploy = document.getElementById('btn-deploy');
    if (btnDeploy) {
        btnDeploy.addEventListener('click', () => {
            btnDeploy.innerHTML = '<span class="material-symbols-outlined text-[18px] animate-spin">progress_activity</span><span>Dispatching Pod...</span>';
            setTimeout(() => {
                btnDeploy.innerHTML = '<span class="material-symbols-outlined text-[18px]">done_all</span><span>Staging Live (Pod #04)</span>';
            }, 1500);
        });
    }
});
