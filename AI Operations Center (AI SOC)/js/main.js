/**
 * VOSTOKPRIBOR AI • SYS-AI-05: AI Operations Center (AI SOC)
 * Master Consolidated Application Logic
 */

// ==========================================
// 1. Dashboard & Range Alert Interactions
// ==========================================
function toggleModal(id) {
    const el = document.getElementById(id);
    if (el) {
        el.classList.toggle('hidden');
    }
}
window.toggleModal = toggleModal;

function publishTicketAlert() {
    toggleModal('modal-ticket');
    alert('Scenario blueprint provisioned to SYS-AI-01 and scheduled for deployment.');
}
window.publishTicketAlert = publishTicketAlert;

function switchTab(view) {
    alert('Navigating instructor to Submissions Review Matrix (14 pending evaluations).');
}
window.switchTab = switchTab;

// ==========================================
// 2. SOC Operations Dashboard Interactions
// ==========================================
function initSocInteractions() {
    const btnRollback = document.getElementById('btn-rollback');
    const rollbackPanel = document.getElementById('rollback-confirm-panel');
    const cancelRollback = document.getElementById('cancel-rollback');
    const confirmExecuteRollback = document.getElementById('confirm-execute-rollback');
    const btnAck = document.getElementById('btn-ack');
    const postNoteBtn = document.getElementById('post-note-btn');
    const textarea = document.getElementById('investigation-notes');

    if (btnRollback && rollbackPanel) {
        btnRollback.addEventListener('click', () => {
            rollbackPanel.classList.toggle('hidden');
            rollbackPanel.classList.toggle('flex');
        });
    }

    if (cancelRollback && rollbackPanel) {
        cancelRollback.addEventListener('click', () => {
            rollbackPanel.classList.add('hidden');
            rollbackPanel.classList.remove('flex');
        });
    }

    if (confirmExecuteRollback && rollbackPanel && btnRollback) {
        confirmExecuteRollback.addEventListener('click', () => {
            btnRollback.innerHTML = '<span class="material-symbols-outlined text-[16px]">check_circle</span><span>Rollback Triggered (v2.9 Activating)</span>';
            btnRollback.classList.remove('bg-error', 'text-on-error');
            btnRollback.classList.add('bg-primary', 'text-on-primary');
            rollbackPanel.classList.add('hidden');
            rollbackPanel.classList.remove('flex');
        });
    }

    if (btnAck) {
        btnAck.addEventListener('click', () => {
            btnAck.innerHTML = '<span class="material-symbols-outlined text-[16px]">check</span><span>Acknowledged</span>';
            btnAck.classList.add('opacity-75');
        });
    }

    if (postNoteBtn && textarea) {
        postNoteBtn.addEventListener('click', () => {
            if (textarea.value.trim() !== '') {
                textarea.value = '';
                const originalText = postNoteBtn.innerHTML;
                postNoteBtn.innerHTML = '<span class="material-symbols-outlined text-[16px]">check</span><span>Committed to Audit Trail</span>';
                setTimeout(() => {
                    postNoteBtn.innerHTML = originalText;
                }, 2000);
            }
        });
    }
}

// ==========================================
// 3. Workspace Configuration & Rubric Calculator
// ==========================================
function initRubricWorkspace() {
    const items = document.querySelectorAll('.rubric-item');
    if (!items.length) return;
    const scoreDisplay = document.getElementById('total-score-display');
    const submitBtn = document.getElementById('btn-submit-grade');
    const modal = document.getElementById('grade-confirm-modal');
    const cancelBtn = document.getElementById('btn-cancel-modal');
    const confirmFinalBtn = document.getElementById('btn-confirm-final');
    const modalScore = document.getElementById('modal-score');

    function calculateTotal() {
        let total = 0;
        items.forEach(item => {
            const input = item.querySelector('.rubric-input');
            const val = parseFloat(input ? input.value : 0) || 0;
            total += val;
        });
        const finalVal = Math.round(total * 10) / 10;
        const textVal = finalVal.toFixed(1);
        if (scoreDisplay) scoreDisplay.textContent = textVal;
        if (submitBtn) {
            const span = submitBtn.querySelector('span:nth-child(2)');
            if (span) span.textContent = 'Submit Official Grade (' + textVal + ')';
        }
        if (modalScore) {
            modalScore.textContent = textVal + ' / 100 [DISTINCTION]';
        }
    }

    items.forEach(item => {
        const slider = item.querySelector('.rubric-slider');
        const input = item.querySelector('.rubric-input');
        const maxVal = parseFloat(item.dataset.max) || 10;

        if (slider && input) {
            slider.addEventListener('input', (e) => {
                input.value = parseFloat(e.target.value).toFixed(1);
                calculateTotal();
            });

            input.addEventListener('input', (e) => {
                let val = parseFloat(e.target.value);
                if (isNaN(val)) val = 0;
                if (val > maxVal) val = maxVal;
                if (val < 0) val = 0;
                slider.value = val;
                calculateTotal();
            });
        }
    });

    if (submitBtn && modal) {
        submitBtn.addEventListener('click', () => {
            modal.classList.remove('hidden');
        });
    }

    if (cancelBtn && modal) {
        cancelBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
        });
    }

    if (confirmFinalBtn && modal) {
        confirmFinalBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
            if (submitBtn) {
                submitBtn.classList.replace('bg-primary', 'bg-emerald-800');
                submitBtn.innerHTML = '<span class="material-symbols-outlined text-[20px]">check</span><span>Grade Recorded Successfully</span>';
                submitBtn.disabled = true;
            }
        });
    }

    calculateTotal();
}

// Global initialization for SOC interactions & timer
document.addEventListener('DOMContentLoaded', () => {
    initSocInteractions();
    initRubricWorkspace();

    // Interactive Live Countdown simulation on Dashboard
    const timer = document.getElementById('cycle-timer');
    if (timer) {
        let countdown = 10;
        setInterval(() => {
            countdown = countdown > 1 ? countdown - 1 : 10;
            if (timer) timer.textContent = countdown + 's';
        }, 1000);
    }
});

// ==========================================
// 4. Dynamic Training Scenarios & Authoring Suite
// ==========================================

// Storage Key
        const STORAGE_KEY = "VOSTOK_SCENARIOS_STORAGE_v4";

        // Initial Seed: 7 Enterprise Scenarios with Full 10-Dimensional Depth
        const DEFAULT_INITIAL_SCENARIOS = [
            {
                id: "SCN-CHURN-101",
                title: "Customer Churn Prediction",
                track: "Level 1 — AI Fundamentals",
                progressionLevel: "Level 1",
                category: "Predictive AI",
                difficulty: "Intermediate",
                department: "Customer Retention Operations",
                instructor: "Dr. K. Voronin (Chief)",
                ticketsCount: 6,
                studentsCount: 38,
                cohort: "Cohort Alpha-4 (Range Primary)",
                status: "Active",
                version: "v2.4.0",
                lastModified: "2026-10-10",
                createdDate: "2026-08-15",
                tags: ["telecom", "churn", "xgboost", "imbalance", "shap"],
                description: "Production-tier tabular classification pipeline detecting micro-churn signals across enterprise telecommunication subscriptions before contract expiration.",
                businessProblem: {
                    objective: "Reduce voluntary customer contract cancellation by 12% across high-value multi-line enterprise accounts.",
                    description: "The enterprise telecom division loses 18.2% of annual multi-line contracts to competitors within 45 days of unaddressed customer service friction.",
                    stakeholderRequest: "Develop an automated, explainable feature pipeline and gradient-boosted binary classifier alerting frontline account executives before account cancellation.",
                    businessContext: "Asymmetric cost matrix: $120 cost per false negative (lost customer) vs $15 outreach cost for false positives. Strict GDPR and PII compliance.",
                    expectedImpact: "$4.2M estimated annual revenue retention; 45% reduction in retention team manual triage overhead."
                },
                datasets: [
                    { name: "telecom_customer_churn_v2.parquet", role: "Training Split", access: "Read-Only (Immutable)", version: "v2.4.1 (sha:8f2a9e...)" },
                    { name: "telecom_customer_holdout_eval.parquet", role: "Holdout Test Split", access: "Read-Only (Immutable)", version: "v2.4.1 (sha:c44b11...)" },
                    { name: "telecom_drift_simulation_stream.arrow", role: "Drift Baseline Feed", access: "Sandbox R/W", version: "v1.0.0 (sha:01a9df...)" }
                ],
                toolsEnvironment: {
                    pythonVersion: "Python 3.11.8 (Conda Range-v4)",
                    framework: "Triton ONNX Runtime + FastAPI",
                    computeQuota: "4 vCPU, 16GB RAM, CUDA 12.2 (Optional T4)",
                    libraries: "XGBoost 2.0.3, Scikit-learn 1.4.1, LightGBM 4.3, MLflow 2.11, SHAP 0.44, FastAPI 0.110",
                    integrations: ["SYS-01", "SYS-02", "SYS-03", "SYS-04", "SYS-05"]
                },
                workflow: [
                    { stage: "Stage 1: Problem Understanding & EDA", action: "Cadet reviews business mandate, clones ticket branch, and validates dataset class imbalance." },
                    { stage: "Stage 2: Feature Engineering & Preprocessing", action: "Construct clean feature pipelines, strictly avoid leakage in tenure/complaint columns." },
                    { stage: "Stage 3: Model Training & Experiment Tracking", action: "Train candidate classifiers, log ROC/PR curves to MLflow, and tune hyperparameters." },
                    { stage: "Stage 4: Holdout Validation & Canary Deployment Gate", action: "Export model to ONNX, verify inference latency < 60ms, and pass 10% canary traffic gate." },
                    { stage: "Stage 5: Live Drift Triage & Defense", action: "Respond to simulated KS-drift incident on telemetry wall, apply mitigation or zero-downtime rollback." }
                ],
                successCriteria: {
                    primaryMetricName: "AUC-ROC Holdout Split",
                    primaryThreshold: "≥ 0.850",
                    secondaryMetric: "F1 Score ≥ 0.820 (Positive Churn Class)",
                    latencySla: "P99 Latency < 60ms (with SHAP feature attribution)",
                    robustness: "Kolmogorov-Smirnov feature drift p-val > 0.05 on heldout batches",
                    hardFailRules: "Target leakage flag in contract tenure ratio; AUC > 0.99 indicating memorization; unhandled 500 exceptions."
                },
                deliverables: {
                    notebooks: true,
                    repo: true,
                    model: true,
                    card: true,
                    api: true,
                    demo: true
                },
                evaluationRules: {
                    weights: [10, 15, 20, 15, 15, 10, 10, 5],
                    passingScore: "75.0% Overall Score",
                    autoValidation: "Enabled (Auto-Grade Unit Tests + Holdout)",
                    instructorReviewReq: "Mandatory Final Signoff Required"
                },
                publication: {
                    startDate: "2026-10-01",
                    deadline: "2026-10-25",
                    visible: true
                },
                versionHistory: [
                    { version: "v2.4.0", author: "Dr. K. Voronin", date: "2026-10-10", changelog: "Tightened latency constraint to sub-60ms; integrated SHAP tree explainer rubric dimension." },
                    { version: "v2.3.0", author: "Dr. K. Voronin", date: "2026-09-18", changelog: "Added Holdout Parquet ground truth test split and automated canary gate check." },
                    { version: "v2.0.0", author: "Prof. Elena Rostova", date: "2026-08-30", changelog: "Major revision: updated telecom churn dataset from CSV to Apache Parquet v2." },
                    { version: "v1.0.0", author: "Dr. K. Voronin", date: "2026-08-15", changelog: "Initial draft specification approved for Cohort Alpha-4." }
                ]
            },
            {
                id: "SCN-FRAUD-102",
                title: "Fraud Detection",
                track: "Level 1 — AI Fundamentals",
                progressionLevel: "Level 1",
                category: "Streaming Anomaly",
                difficulty: "Advanced",
                department: "Financial Crime & Compliance",
                instructor: "Prof. Elena Rostova",
                ticketsCount: 8,
                studentsCount: 24,
                cohort: "Cohort Beta-2 (Fintech Stream)",
                status: "Active",
                version: "v3.0.0",
                lastModified: "2026-10-08",
                createdDate: "2026-07-20",
                tags: ["fraud", "streaming", "fintech", "latency", "graph"],
                description: "Sub-15ms real-time inference on highly skewed card transactions stream with graph embeddings and precision-recall trade-offs.",
                businessProblem: {
                    objective: "Detect unauthorized credit card withdrawals while capping false positive customer decline rate under 0.15%.",
                    description: "Synthetic fraud syndicates bypass traditional heuristic rule firewalls causing $1.8M monthly chargebacks.",
                    stakeholderRequest: "Deploy a high-throughput streaming scorer evaluating transaction payload against past 30-day velocity graphs in sub-15ms.",
                    businessContext: "Imbalance ratio is 1:2400. Declining a legitimate VIP cardholder has severe customer churn consequences.",
                    expectedImpact: "$14M annualized fraud mitigation with zero degradation to gateway processing throughput."
                },
                datasets: [
                    { name: "financial_tx_fraud_stream.parquet", role: "Training Split", access: "Read-Only (Immutable)", version: "v3.0.0 (sha:7b31e0...)" },
                    { name: "fraud_adversarial_holdout.parquet", role: "Holdout Test Split", access: "Locked Instructor Truth", version: "v3.0.0 (sha:fa882a...)" }
                ],
                toolsEnvironment: {
                    pythonVersion: "Python 3.11.8 (Conda Range-v4)",
                    framework: "Triton ONNX Runtime + FastAPI",
                    computeQuota: "8 vCPU, 32GB RAM, CUDA 12.2",
                    libraries: "XGBoost 2.0.3, CatBoost 1.2, PyTorch-Geometric 2.5, MLflow 2.11, Redis-Py 5.0",
                    integrations: ["SYS-01", "SYS-02", "SYS-03", "SYS-04", "SYS-05"]
                },
                workflow: [
                    { stage: "Stage 1: Imbalance & Graph Velocity EDA", action: "Analyze temporal transaction clustering and card-holder node centrality." },
                    { stage: "Stage 2: Cost-Sensitive Classifier Training", action: "Train focal loss gradient boost and graph sage embeddings with cross-validation." },
                    { stage: "Stage 3: Sub-15ms Triton Pipeline Packaging", action: "Optimize tensor serialization via ONNX FP16 and deploy to high-throughput endpoint." }
                ],
                successCriteria: {
                    primaryMetricName: "Precision at Recall ≥ 0.88",
                    primaryThreshold: "≥ 0.940",
                    secondaryMetric: "PR-AUC ≥ 0.890 on adversarial holdout",
                    latencySla: "P99 Latency ≤ 15ms at 1,200 RPS",
                    robustness: "Zero false alarm spikes during peak shopping simulation hours",
                    hardFailRules: "Latency exceeding 25ms SLA; memorization of transaction ID hashes."
                },
                deliverables: { notebooks: true, repo: true, model: true, card: true, api: true, demo: true },
                evaluationRules: {
                    weights: [10, 15, 20, 15, 15, 10, 10, 5],
                    passingScore: "80.0% Overall Score",
                    autoValidation: "Enabled (Auto-Grade Unit Tests + Holdout)",
                    instructorReviewReq: "Mandatory Final Signoff Required"
                },
                publication: { startDate: "2026-09-15", deadline: "2026-10-30", visible: true },
                versionHistory: [
                    { version: "v3.0.0", author: "Prof. Elena Rostova", date: "2026-10-08", changelog: "Added streaming stress test simulator and adversarial synthetic fraud vectors." }
                ]
            },
            {
                id: "SCN-DEFECT-103",
                title: "Manufacturing Defect Inspection",
                track: "Level 1 — AI Fundamentals",
                progressionLevel: "Level 1",
                category: "Computer Vision",
                difficulty: "Intermediate",
                department: "Aerospace Quality Assurance",
                instructor: "M. Sokolov",
                ticketsCount: 5,
                studentsCount: 19,
                cohort: "Cohort Alpha-4 (Range Primary)",
                status: "Published",
                version: "v1.4.0",
                lastModified: "2026-10-07",
                createdDate: "2026-08-01",
                tags: ["vision", "yolo", "defects", "segmentation", "onnx"],
                description: "High-resolution SEM micro-imaging object localization and segmentation detecting structural wafer fractures in avionics chips.",
                businessProblem: {
                    objective: "Automate optical quality control on semiconductor wafers to catch micro-cracks before spaceflight assembly.",
                    description: "Manual technician microscope inspections take 14 minutes per silicon wafer and miss 4.1% of hairline fractures.",
                    stakeholderRequest: "Deliver a computer vision model processing 4K SEM images in under 35ms with bounding box and mask overlays.",
                    businessContext: "Zero undetected cracks permitted (100% critical defect recall target). False alarms require quick technician review.",
                    expectedImpact: "Eliminate $8.5M spaceflight hardware recall risks and increase production line velocity by 400%."
                },
                datasets: [
                    { name: "manufacturing_wafer_sem_images.tar.gz", role: "Training Split", access: "Read-Only (Immutable)", version: "v1.4.0 (sha:43e110...)" },
                    { name: "manufacturing_optical_defects_metadata.json", role: "Auxiliary Embeddings", access: "Read-Only (Immutable)", version: "v1.4.0" }
                ],
                toolsEnvironment: {
                    pythonVersion: "Python 3.11.8 (Conda Range-v4)",
                    framework: "Triton ONNX Runtime + FastAPI",
                    computeQuota: "8 vCPU, 32GB RAM, NVIDIA A10G (24GB VRAM)",
                    libraries: "PyTorch 2.2, Ultralytics YOLOv8, Albumentations 1.4, OpenCV 4.9, ONNXRuntime-GPU 1.17",
                    integrations: ["SYS-01", "SYS-02", "SYS-03", "SYS-04", "SYS-05"]
                },
                workflow: [
                    { stage: "Stage 1: Image Augmentation & Annotation Triage", action: "Inspect COCO bounding boxes, apply mosaic and CLAHE contrast enhancement." },
                    { stage: "Stage 2: YOLOv8 / Segmenter Training", action: "Train multi-class defect detector (cracks, bubbles, debris, misalignments)." },
                    { stage: "Stage 3: TensorRT / ONNX Optimization", action: "Quantize to FP16 and validate mAP on held-out SEM batch." }
                ],
                successCriteria: {
                    primaryMetricName: "mAP@0.5 IoU Across All Defect Classes",
                    primaryThreshold: "≥ 0.890",
                    secondaryMetric: "Critical Micro-Crack Recall = 1.000",
                    latencySla: "Inference Time ≤ 35ms per 2048x2048 frame",
                    robustness: "Consistent detection across varying electron microscope lighting conditions",
                    hardFailRules: "Missing any critical crack sample in holdout test set."
                },
                deliverables: { notebooks: true, repo: true, model: true, card: true, api: true, demo: true },
                evaluationRules: {
                    weights: [10, 15, 20, 15, 15, 10, 10, 5],
                    passingScore: "75.0% Overall Score",
                    autoValidation: "Enabled (Auto-Grade Unit Tests + Holdout)",
                    instructorReviewReq: "Mandatory Final Signoff Required"
                },
                publication: { startDate: "2026-10-01", deadline: "2026-10-28", visible: true },
                versionHistory: [
                    { version: "v1.4.0", author: "M. Sokolov", date: "2026-10-07", changelog: "Added SEM high-resolution microscope test cases and TensorRT quantization guide." }
                ]
            },
            {
                id: "SCN-NLP-104",
                title: "Customer Complaint Classification",
                track: "Level 1 — AI Fundamentals",
                progressionLevel: "Level 1",
                category: "NLP",
                difficulty: "Beginner",
                department: "Global Support Operations",
                instructor: "Dr. K. Voronin",
                ticketsCount: 4,
                studentsCount: 29,
                cohort: "Cohort Gamma-1 (NLP Foundation)",
                status: "Active",
                version: "v2.0.0",
                lastModified: "2026-10-09",
                createdDate: "2026-08-22",
                tags: ["nlp", "transformers", "sentiment", "pii", "routing"],
                description: "Multi-class intent routing and escalation engine with automated PII masking and transformer embedding fine-tuning.",
                businessProblem: {
                    objective: "Route incoming support tickets to correct engineering tier within 3 seconds of customer submission.",
                    description: "Manual ticket dispatchers create 4-hour routing delays, routing 19% of critical billing outages to incorrect queues.",
                    stakeholderRequest: "Build an automated text classifier that sanitizes sensitive credit/SSN numbers and assigns tickets with confidence scores.",
                    businessContext: "Must handle multilingual text (EN/RU/AR) and preserve privacy under strict enterprise data policies.",
                    expectedImpact: "Reduce First-Response-Time (FRT) from 4.2 hours to 6 minutes across 120,000 monthly tickets."
                },
                datasets: [
                    { name: "customer_support_tickets_nlp.jsonl", role: "Training Split", access: "Masked PII", version: "v2.0.0 (sha:33d981...)" }
                ],
                toolsEnvironment: {
                    pythonVersion: "Python 3.11.8 (Conda Range-v4)",
                    framework: "Triton ONNX Runtime + FastAPI",
                    computeQuota: "4 vCPU, 16GB RAM, CUDA 12.2 (Optional T4)",
                    libraries: "HuggingFace Transformers 4.38, Datasets 2.18, Scikit-learn 1.4, Presidio-Analyzer 2.2, FastAPI 0.110",
                    integrations: ["SYS-01", "SYS-02", "SYS-03", "SYS-04", "SYS-05"]
                },
                workflow: [
                    { stage: "Stage 1: PII Sanitization & Preprocessing", action: "Apply regex and NER masking to remove names, account IDs, and phone numbers." },
                    { stage: "Stage 2: Transformer Fine-Tuning", action: "Fine-tune lightweight multilingual DistilRoBERTa on 18 intent classes." },
                    { stage: "Stage 3: Confidence-Gated API Router", action: "Build FastAPI endpoint routing high-confidence tickets and flagging ambiguous ones." }
                ],
                successCriteria: {
                    primaryMetricName: "Macro-Averaged F1 Score Across 18 Classes",
                    primaryThreshold: "≥ 0.880",
                    secondaryMetric: "PII Sanitization Accuracy = 100%",
                    latencySla: "P95 Latency ≤ 25ms per text payload",
                    robustness: "Zero cross-class confusion between Billing and System Outage tickets",
                    hardFailRules: "Leaking raw unmasked PII in logged request payloads."
                },
                deliverables: { notebooks: true, repo: true, model: true, card: true, api: true, demo: true },
                evaluationRules: {
                    weights: [10, 15, 20, 15, 15, 10, 10, 5],
                    passingScore: "75.0% Overall Score",
                    autoValidation: "Enabled (Auto-Grade Unit Tests + Holdout)",
                    instructorReviewReq: "Optional Spot Checks"
                },
                publication: { startDate: "2026-09-01", deadline: "2026-10-22", visible: true },
                versionHistory: [
                    { version: "v2.0.0", author: "Dr. K. Voronin", date: "2026-10-09", changelog: "Added Presidio PII evaluation dimension and Arabic tokenization support." }
                ]
            },
            {
                id: "SCN-RAG-201",
                title: "HR Knowledge Assistant (RAG)",
                track: "Level 2 — AI Engineer",
                progressionLevel: "Level 2",
                category: "Generative AI",
                difficulty: "Advanced",
                department: "People Operations & HR",
                instructor: "Dr. A. Chernov",
                ticketsCount: 7,
                studentsCount: 18,
                cohort: "Cohort Omega-1 (Advanced RAG/Agents)",
                status: "Published",
                version: "v1.2.0",
                lastModified: "2026-10-06",
                createdDate: "2026-08-10",
                tags: ["rag", "llm", "vector", "qdrant", "faithfulness"],
                description: "Retrieval-Augmented Generation agent with hybrid dense/sparse vector search, context re-ranking, and strict hallucination guardrails.",
                businessProblem: {
                    objective: "Provide employees accurate answers to complex benefits, legal visa, and compensation queries with exact document citations.",
                    description: "HR coordinators spend 32 hours weekly answering repetitive policy questions from international avionics teams.",
                    stakeholderRequest: "Construct an enterprise RAG assistant that retrieves policy chunks and generates sourced answers while refusing out-of-scope prompts.",
                    businessContext: "Strict anti-hallucination mandate. Incorrect medical insurance advice creates legal liability.",
                    expectedImpact: "70% automated resolution of employee handbook inquiries with 99.2% verified policy fidelity."
                },
                datasets: [
                    { name: "hr_policy_handbook_vector_corpus.parquet", role: "Training Split", access: "Read-Only (Immutable)", version: "v1.2.0 (sha:ee194a...)" },
                    { name: "hr_eval_qa_benchmark_pairs.json", role: "Holdout Test Split", access: "Locked Instructor Truth", version: "v1.2.0" }
                ],
                toolsEnvironment: {
                    pythonVersion: "Python 3.11.8 (Conda Range-v4)",
                    framework: "vLLM / HuggingFace TGI",
                    computeQuota: "8 vCPU, 32GB RAM, NVIDIA A10G (24GB VRAM)",
                    libraries: "LangChain 0.1.13, LlamaIndex 0.10, Qdrant-Client 1.8, Ragas 0.1.5, Sentence-Transformers 2.5",
                    integrations: ["SYS-01", "SYS-02", "SYS-03", "SYS-04", "SYS-05"]
                },
                workflow: [
                    { stage: "Stage 1: Document Chunking & Hybrid Vector Indexing", action: "Chunk 400-page policy manual using semantic boundary splitting; build BM25 + BGE embedding index." },
                    { stage: "Stage 2: Cross-Encoder Re-Ranking Pipeline", action: "Implement FlashRank re-ranking to pass top-3 authoritative snippets to LLM context window." },
                    { stage: "Stage 3: Ragas Faithfulness & Guardrail Benchmark", action: "Evaluate answers on 150 adversarial edge queries testing hallucination and policy bounds." }
                ],
                successCriteria: {
                    primaryMetricName: "Ragas Faithfulness & Answer Relevance",
                    primaryThreshold: "≥ 92.0%",
                    secondaryMetric: "Context Recall ≥ 0.900; Citation Accuracy 100%",
                    latencySla: "Time-to-First-Token < 800ms; Total Response < 2.2s",
                    robustness: "Zero hallucination on policy compensation formulas; refusal on prompt injection attacks",
                    hardFailRules: "Fabricating non-existent policy clauses or quoting wrong handbook versions."
                },
                deliverables: { notebooks: true, repo: true, model: true, card: true, api: true, demo: true },
                evaluationRules: {
                    weights: [10, 15, 20, 15, 15, 10, 10, 5],
                    passingScore: "80.0% Overall Score",
                    autoValidation: "Enabled (Auto-Grade Unit Tests + Holdout)",
                    instructorReviewReq: "Mandatory Final Signoff Required"
                },
                publication: { startDate: "2026-10-05", deadline: "2026-11-10", visible: true },
                versionHistory: [
                    { version: "v1.2.0", author: "Dr. A. Chernov", date: "2026-10-06", changelog: "Added RAGAS evaluation harness and cross-encoder re-ranking requirements." }
                ]
            },
            {
                id: "SCN-AGENT-202",
                title: "Customer Support AI Agent",
                track: "Level 2 — AI Engineer",
                progressionLevel: "Level 2",
                category: "Autonomous Agents",
                difficulty: "Advanced",
                department: "AI Automation Systems",
                instructor: "Dr. A. Chernov",
                ticketsCount: 6,
                studentsCount: 16,
                cohort: "Cohort Omega-1 (Advanced RAG/Agents)",
                status: "Ready for Review",
                version: "v1.0.0",
                lastModified: "2026-10-10",
                createdDate: "2026-09-01",
                tags: ["agents", "tools", "react", "safety", "function-calling"],
                description: "ReAct reasoning loop agent with multi-tool calling, database lookup, simulated API refunds, and strict loop runaway interrupts.",
                businessProblem: {
                    objective: "Autonomous AI agent capable of resolving end-to-end customer support actions (order lookup, tracking, re-issuing) without human intervention.",
                    description: "Tier 1 human agents execute mechanical database queries and refund clicks costing $6.40 per ticket.",
                    stakeholderRequest: "Build an autonomous agent with sandboxed API tool calling that verifies customer authentication before taking state-altering actions.",
                    businessContext: "Hard safety constraints: max refund limit of $250 without human-in-the-loop escalation; max 5 tool steps per turn.",
                    expectedImpact: "65% deflection rate of Tier 1 mechanical operations while maintaining zero unauthorized transaction errors."
                },
                datasets: [
                    { name: "autonomous_support_dialogues_v1.json", role: "Training Split", access: "Read-Only (Immutable)", version: "v1.0.0 (sha:12c499...)" }
                ],
                toolsEnvironment: {
                    pythonVersion: "Python 3.11.8 (Conda Range-v4)",
                    framework: "vLLM / HuggingFace TGI",
                    computeQuota: "8 vCPU, 32GB RAM, NVIDIA A10G (24GB VRAM)",
                    libraries: "LangGraph 0.0.30, Pydantic 2.6, LiteLLM 1.30, PyYAML 6.0, FastAPI 0.110",
                    integrations: ["SYS-01", "SYS-02", "SYS-03", "SYS-04", "SYS-05"]
                },
                workflow: [
                    { stage: "Stage 1: Tool Schema & Sandbox Protocol Design", action: "Define typed Pydantic tools for OrderDB, TrackingAPI, and RefundProcessor." },
                    { stage: "Stage 2: StateGraph ReAct Loop Orchestration", action: "Implement LangGraph cyclic agent with state memory, loop guards, and fallback branches." },
                    { stage: "Stage 3: Adversarial Loop Interruption Stress Test", action: "Test agent against circular queries, SQL injection strings, and unauthorized limit requests." }
                ],
                successCriteria: {
                    primaryMetricName: "Autonomous Task Completion Rate",
                    primaryThreshold: "≥ 85.0%",
                    secondaryMetric: "Tool Safety Violation Rate = 0.00%",
                    latencySla: "Average Turn Latency ≤ 1.8 seconds",
                    robustness: "Zero runaway infinite loops; graceful escalation to human on ambiguity",
                    hardFailRules: "Invoking refund tool above limit or without valid auth token in agent state."
                },
                deliverables: { notebooks: true, repo: true, model: true, card: true, api: true, demo: true },
                evaluationRules: {
                    weights: [10, 15, 20, 15, 15, 10, 10, 5],
                    passingScore: "80.0% Overall Score",
                    autoValidation: "Enabled (Auto-Grade Unit Tests + Holdout)",
                    instructorReviewReq: "Mandatory Final Signoff Required"
                },
                publication: { startDate: "2026-10-15", deadline: "2026-11-20", visible: false },
                versionHistory: [
                    { version: "v1.0.0", author: "Dr. A. Chernov", date: "2026-10-10", changelog: "Initial draft specification ready for flight review." }
                ]
            },
            {
                id: "SCN-SOC-301",
                title: "Model Failure & AI SOC",
                track: "Level 3 — AI Production",
                progressionLevel: "Level 3",
                category: "AI SOC & Safety",
                difficulty: "Expert",
                department: "Mission Telemetry & Reliability",
                instructor: "Dr. K. Voronin (Chief)",
                ticketsCount: 9,
                studentsCount: 14,
                cohort: "Cadet Flight Crew (SOC Special)",
                status: "Active",
                version: "v2.2.0",
                lastModified: "2026-10-11",
                createdDate: "2026-08-01",
                tags: ["soc", "drift", "incident", "rollback", "telemetry"],
                description: "24/7 mission telemetry war room scenario simulating acute distribution shift, adversarial data poisoning, and zero-downtime blue/green model rollback.",
                businessProblem: {
                    objective: "Diagnose and remediate a live critical production model failure within strict 18-minute MTTR SLAs without impacting downstream avionics.",
                    description: "An unannounced upstream sensor calibration change causes orbital model accuracy to collapse by 29.8% in active flight.",
                    stakeholderRequest: "SOC engineers must triage real-time telemetry alerts, execute Kolmogorov-Smirnov drift tests, determine root cause, and deploy safe rollback.",
                    businessContext: "Production flight node ORB-NODE-09 is live. Every minute of compromised telemetry increases mission risk.",
                    expectedImpact: "Maintain 99.98% cluster SLA and establish zero-data-loss rollback protocol for flight crew."
                },
                datasets: [
                    { name: "telemetry_live_drift_feed.arrow", role: "Drift Baseline Feed", access: "Sandbox R/W", version: "v2.2.0 (sha:99f01b...)" },
                    { name: "adversarial_sensor_poisoning_log.parquet", role: "Holdout Test Split", access: "Locked Instructor Truth", version: "v2.2.0" }
                ],
                toolsEnvironment: {
                    pythonVersion: "Python 3.11.8 (Conda Range-v4)",
                    framework: "Triton ONNX Runtime + FastAPI",
                    computeQuota: "8 vCPU, 32GB RAM, 10Gbps Mesh Network",
                    libraries: "Evidently 0.4.15, SciPy 1.12, Prometheus-Client 0.20, Docker-SDK 7.0, Polars 0.20",
                    integrations: ["SYS-01", "SYS-02", "SYS-03", "SYS-04", "SYS-05"]
                },
                workflow: [
                    { stage: "Stage 1: Telemetry Alert Triage (#INC-4092)", action: "Acknowledge Sev-1 alarm on AI SOC wall and correlate error logs with feature feeds." },
                    { stage: "Stage 2: Statistical Drift & Distribution Shift Analysis", action: "Run KS-test and Wasserstein distance scripts identifying anomalous sensor channels." },
                    { stage: "Stage 3: Blue/Green Canary Gate Rollback & Incident Post-Mortem", action: "Execute atomic rollback to champion model v2.1.0 on Triton; author Root Cause Analysis (RCA)." }
                ],
                successCriteria: {
                    primaryMetricName: "Mean Time to Remediation (MTTR)",
                    primaryThreshold: "≤ 18 Minutes",
                    secondaryMetric: "Zero downtime (< 5 dropped requests during rollback)",
                    latencySla: "Mesh Telemetry Latency ≤ 12ms",
                    robustness: "Accurate detection of KS-drift divergence p < 0.01 on true culprit feature",
                    hardFailRules: "Rolling back to unverified container or causing gateway 502 outage."
                },
                deliverables: { notebooks: true, repo: true, model: true, card: true, api: true, demo: true },
                evaluationRules: {
                    weights: [10, 15, 20, 15, 15, 10, 10, 5],
                    passingScore: "85.0% Overall Score",
                    autoValidation: "Enabled (Auto-Grade Unit Tests + Holdout)",
                    instructorReviewReq: "Mandatory Final Signoff Required"
                },
                publication: { startDate: "2026-10-01", deadline: "2026-10-20", visible: true },
                versionHistory: [
                    { version: "v2.2.0", author: "Dr. K. Voronin", date: "2026-10-11", changelog: "Added orbital sensor adversarial drift injection scenario with automated MTTR timer." },
                    { version: "v2.0.0", author: "Dr. K. Voronin", date: "2026-09-05", changelog: "Configured AI SOC telemetry wall incident pipeline and blue/green switch." }
                ]
            }
        ];

        // Global State
        let allScenarios = [];
        let currentEditingScenario = null;
        let currentStepIndex = 1;
        let currentLifecycleFilter = "ALL";
        let currentSearchQuery = "";
        let currentViewMode = "grid"; // 'grid', 'table', 'roadmap'
        let currentBuilderDatasets = [];

        // Valid Lifecycle State Machine Transitions
        const VALID_LIFECYCLE_TRANSITIONS = {
            "Draft": ["Ready for Review", "Archived"],
            "Ready for Review": ["Draft", "Published", "Archived"],
            "Published": ["Active", "Draft", "Archived"], // "Draft" here represents unpublishing
            "Active": ["Completed", "Published", "Archived"], // "Published" represents pausing/unactivating
            "Completed": ["Active", "Archived"], // Can re-open
            "Archived": ["Draft"] // Can restore
        };

        // Initialize Application
        document.addEventListener("DOMContentLoaded", () => {
            loadScenariosFromStorage();
            renderCatalog();
            updateTopKpiMetrics();
            setupSearchListeners();
        });

        // -------------------------------------------------------------------------
        // STORAGE & CRUD OPERATIONS
        // -------------------------------------------------------------------------
        function loadScenariosFromStorage() {
            try {
                const stored = localStorage.getItem(STORAGE_KEY);
                if (stored) {
                    allScenarios = JSON.parse(stored);
                } else {
                    allScenarios = JSON.parse(JSON.stringify(DEFAULT_INITIAL_SCENARIOS));
                    saveScenariosToStorage();
                }
            } catch (err) {
                console.error("Storage parse error, resetting to default:", err);
                allScenarios = JSON.parse(JSON.stringify(DEFAULT_INITIAL_SCENARIOS));
            }
        }

        function saveScenariosToStorage() {
            try {
                localStorage.setItem(STORAGE_KEY, JSON.stringify(allScenarios));
            } catch (err) {
                console.error("Storage save error:", err);
                showToast("Storage quota warning or error", "error");
            }
        }

        function resetScenariosToDefault() {
            if (confirm("Reset all scenarios back to the default 7 initial blueprint configurations? Any dynamic custom scenarios will be cleared.")) {
                allScenarios = JSON.parse(JSON.stringify(DEFAULT_INITIAL_SCENARIOS));
                saveScenariosToStorage();
                renderCatalog();
                updateTopKpiMetrics();
                showToast("Scenarios reset to standard 7-scenario blueprint", "success");
            }
        }

        function exportAllScenariosJson() {
            const dataStr = "data:text/json;charset=utf-8," + encodeURIComponent(JSON.stringify(allScenarios, null, 2));
            const dlAnchor = document.createElement("a");
            dlAnchor.setAttribute("href", dataStr);
            dlAnchor.setAttribute("download", `VOSTOKPRIBOR_AI_Scenarios_${new Date().toISOString().slice(0, 10)}.json`);
            document.body.appendChild(dlAnchor);
            dlAnchor.click();
            dlAnchor.remove();
            showToast("Scenarios export downloaded (.json)", "success");
        }

        function importScenariosJson(event) {
            const file = event.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = function(e) {
                try {
                    const parsed = JSON.parse(e.target.result);
                    if (Array.isArray(parsed) && parsed.length > 0) {
                        allScenarios = parsed;
                        saveScenariosToStorage();
                        renderCatalog();
                        updateTopKpiMetrics();
                        showToast(`Successfully imported ${parsed.length} scenarios!`, "success");
                    } else {
                        showToast("Invalid JSON file structure. Array of scenarios expected.", "error");
                    }
                } catch (err) {
                    showToast("Failed to parse JSON: " + err.message, "error");
                }
            };
            reader.readAsText(file);
            event.target.value = "";
        }

        // -------------------------------------------------------------------------
        // SEARCH, FILTER & VIEW MODES
        // -------------------------------------------------------------------------
        function setViewMode(mode) {
            currentViewMode = mode;
            document.getElementById("view-mode-grid-btn").className = mode === "grid" ? "px-3.5 py-2 rounded-lg bg-primary-container text-white font-bold shadow-sm flex items-center gap-1.5 transition-all" : "px-3.5 py-2 rounded-lg text-on-surface-variant hover:text-primary hover:bg-secondary-fixed/50 font-medium flex items-center gap-1.5 transition-all";
            document.getElementById("view-mode-table-btn").className = mode === "table" ? "px-3.5 py-2 rounded-lg bg-primary-container text-white font-bold shadow-sm flex items-center gap-1.5 transition-all" : "px-3.5 py-2 rounded-lg text-on-surface-variant hover:text-primary hover:bg-secondary-fixed/50 font-medium flex items-center gap-1.5 transition-all";
            document.getElementById("view-mode-roadmap-btn").className = mode === "roadmap" ? "px-3.5 py-2 rounded-lg bg-primary-container text-white font-bold shadow-sm flex items-center gap-1.5 transition-all" : "px-3.5 py-2 rounded-lg text-on-surface-variant hover:text-primary hover:bg-secondary-fixed/50 font-medium flex items-center gap-1.5 transition-all";

            document.getElementById("view-container-grid").classList.toggle("hidden", mode !== "grid");
            document.getElementById("view-container-table").classList.toggle("hidden", mode !== "table");
            document.getElementById("view-container-roadmap").classList.toggle("hidden", mode !== "roadmap");

            renderCatalog();
        }

        function setLifecycleFilter(status) {
            currentLifecycleFilter = status;
            document.querySelectorAll(".status-filter-pill").forEach(btn => {
                const isSelected = btn.id === `filter-status-${status}`;
                btn.className = isSelected
                    ? "status-filter-pill px-2.5 py-1 rounded-lg bg-primary-container text-white font-bold text-[11px] whitespace-nowrap shadow-sm"
                    : "status-filter-pill px-2.5 py-1 rounded-lg bg-surface-container-low text-on-surface-variant hover:text-primary font-medium text-[11px] whitespace-nowrap";
            });
            renderCatalog();
        }

        function setupSearchListeners() {
            // Handled via oninput
        }

        function handleSearchFilterChange() {
            currentSearchQuery = document.getElementById("catalog-search").value.trim().toLowerCase();
            document.getElementById("clear-search-btn").classList.toggle("hidden", currentSearchQuery === "");
            renderCatalog();
        }

        function clearSearch() {
            document.getElementById("catalog-search").value = "";
            currentSearchQuery = "";
            document.getElementById("clear-search-btn").classList.add("hidden");
            renderCatalog();
        }

        function getFilteredScenarios() {
            const levelVal = document.getElementById("filter-progression-level") ? document.getElementById("filter-progression-level").value : "ALL";
            const catVal = document.getElementById("filter-category") ? document.getElementById("filter-category").value : "ALL";
            const deptVal = document.getElementById("filter-department") ? document.getElementById("filter-department").value : "ALL";

            return allScenarios.filter(sc => {
                // Lifecycle status
                if (currentLifecycleFilter !== "ALL" && sc.status !== currentLifecycleFilter) return false;

                // Level
                if (levelVal !== "ALL" && (!sc.progressionLevel || !sc.progressionLevel.includes(levelVal))) return false;

                // Category
                if (catVal !== "ALL" && sc.category !== catVal) return false;

                // Department
                if (deptVal !== "ALL" && sc.department !== deptVal) return false;

                // Search query
                if (currentSearchQuery) {
                    const haystack = `${sc.id} ${sc.title} ${sc.description} ${sc.department} ${sc.instructor} ${(sc.tags||[]).join(" ")}`.toLowerCase();
                    if (!haystack.includes(currentSearchQuery)) return false;
                }

                return true;
            });
        }

        // -------------------------------------------------------------------------
        // CATALOG RENDERING
        // -------------------------------------------------------------------------
        function renderCatalog() {
            const list = getFilteredScenarios();
            document.getElementById("results-count-text").textContent = `Displaying ${list.length} of ${allScenarios.length} scenarios`;
            document.getElementById("scenario-counter-badge").textContent = `${allScenarios.length} Enterprise Scenarios Loaded`;

            if (currentViewMode === "grid") {
                renderGridView(list);
            } else if (currentViewMode === "table") {
                renderTableView(list);
            } else if (currentViewMode === "roadmap") {
                renderRoadmapView();
            }
        }

        function getStatusBadgeHtml(status) {
            switch (status) {
                case "Draft":
                    return `<span class="px-2 py-0.5 rounded bg-surface-container-highest text-outline font-mono font-bold text-[10px] uppercase">DRAFT</span>`;
                case "Ready for Review":
                    return `<span class="px-2 py-0.5 rounded bg-amber-100 text-amber-800 border border-amber-300 font-mono font-bold text-[10px] uppercase">READY FOR REVIEW</span>`;
                case "Published":
                    return `<span class="px-2 py-0.5 rounded bg-secondary-fixed text-primary font-mono font-bold text-[10px] uppercase border border-secondary-container">PUBLISHED</span>`;
                case "Active":
                    return `<span class="px-2 py-0.5 rounded bg-emerald-100 text-emerald-800 border border-emerald-300 font-mono font-bold text-[10px] uppercase flex items-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>ACTIVE</span>`;
                case "Completed":
                    return `<span class="px-2 py-0.5 rounded bg-blue-100 text-blue-800 font-mono font-bold text-[10px] uppercase">COMPLETED</span>`;
                case "Archived":
                    return `<span class="px-2 py-0.5 rounded bg-surface-container text-outline font-mono font-bold text-[10px] uppercase">ARCHIVED</span>`;
                default:
                    return `<span class="px-2 py-0.5 rounded bg-surface-container text-slate-800 font-mono text-[10px]">${status}</span>`;
            }
        }

        function getDifficultyBadgeHtml(diff) {
            switch (diff) {
                case "Beginner":
                    return `<span class="px-2 py-0.5 rounded bg-emerald-50 text-emerald-800 text-[10px] font-bold">BEGINNER</span>`;
                case "Intermediate":
                    return `<span class="px-2 py-0.5 rounded bg-blue-50 text-blue-800 text-[10px] font-bold">INTERMEDIATE</span>`;
                case "Advanced":
                    return `<span class="px-2 py-0.5 rounded bg-purple-50 text-purple-800 text-[10px] font-bold">ADVANCED</span>`;
                case "Expert":
                    return `<span class="px-2 py-0.5 rounded bg-rose-50 text-rose-800 border border-rose-200 text-[10px] font-bold">EXPERT</span>`;
                default:
                    return `<span class="px-2 py-0.5 rounded bg-surface-container text-[10px]">${diff}</span>`;
            }
        }

        function renderGridView(list) {
            const container = document.getElementById("scenarios-grid-cards");
            if (list.length === 0) {
                container.innerHTML = `
                    <div class="col-span-full precision-card p-12 text-center rounded-2xl font-mono text-outline">
                        <span class="material-symbols-outlined text-4xl mb-2 text-primary">search_off</span>
                        <p class="text-sm font-bold text-slate-800">No matching scenarios found</p>
                        <p class="text-xs text-outline mt-1">Adjust search parameters, lifecycle filters, or create a new scenario.</p>
                        <button onclick="openScenarioBuilderModal(null)" class="mt-4 px-4 py-2 rounded-xl bg-primary-container text-white font-bold text-xs inline-flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-sm">add_task</span>
                            <span>Create New Scenario</span>
                        </button>
                    </div>
                `;
                return;
            }

            container.innerHTML = list.map(sc => `
                <div class="precision-card p-5 rounded-2xl flex flex-col justify-between group relative overflow-hidden">
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-primary-container to-secondary-container"></div>
                    <div>
                        <!-- Header Badges -->
                        <div class="flex items-start justify-between gap-2 mb-3">
                            <div class="flex items-center gap-1.5 flex-wrap font-mono">
                                <span class="px-2 py-0.5 rounded bg-primary-container text-white font-bold text-xs tracking-wider">${sc.id}</span>
                                <span class="px-1.5 py-0.5 rounded bg-surface-container text-primary font-bold text-[10px]">${sc.version}</span>
                                ${getDifficultyBadgeHtml(sc.difficulty)}
                            </div>
                            ${getStatusBadgeHtml(sc.status)}
                        </div>

                        <!-- Title & Track -->
                        <div class="mb-2">
                            <div class="text-[10px] font-mono uppercase text-outline font-semibold">${sc.category} • ${sc.progressionLevel || 'Level 1'}</div>
                            <h3 class="text-base font-bold font-mono text-slate-900 group-hover:text-primary transition-colors mt-0.5 line-clamp-1" title="${sc.title}">
                                ${sc.title}
                            </h3>
                        </div>

                        <!-- Description -->
                        <p class="text-xs text-on-surface-variant font-sans line-clamp-2 leading-relaxed mb-4">
                            ${sc.description}
                        </p>

                        <!-- Key Details Strip -->
                        <div class="p-3 rounded-xl bg-surface-container-low border border-outline-variant/30 font-mono text-[11px] space-y-1.5 mb-4">
                            <div class="flex justify-between items-center">
                                <span class="text-outline">Department:</span>
                                <span class="font-semibold text-slate-800 truncate max-w-[170px]" title="${sc.department}">${sc.department}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-outline">Instructor:</span>
                                <span class="font-bold text-primary truncate max-w-[170px]" title="${sc.instructor}">${sc.instructor}</span>
                            </div>
                            <div class="flex justify-between items-center pt-1 border-t border-outline-variant/20">
                                <span class="flex items-center gap-1 text-secondary font-bold">
                                    <span class="material-symbols-outlined text-[14px]">confirmation_number</span>
                                    <span>${sc.ticketsCount} Tickets</span>
                                </span>
                                <span class="flex items-center gap-1 text-primary font-bold">
                                    <span class="material-symbols-outlined text-[14px]">groups</span>
                                    <span>${sc.studentsCount} Students</span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Actions Footer -->
                    <div class="pt-3 border-t border-outline-variant/20 flex items-center justify-between font-mono text-xs gap-2">
                        <!-- Primary Edit Button -->
                        <button onclick="openScenarioBuilderModal('${sc.id}')" class="flex-1 py-2 px-3 rounded-xl bg-primary-container hover:bg-primary text-white font-bold transition-all flex items-center justify-center gap-1.5 shadow-sm text-xs">
                            <span class="material-symbols-outlined text-[16px]">edit</span>
                            <span>Edit Scenario</span>
                        </button>

                        <!-- Actions Dropdown / Quick Triggers -->
                        <div class="flex items-center gap-1">
                            <button onclick="previewScenarioAsStudent('${sc.id}')" title="Preview as Student" class="p-2 rounded-xl bg-surface-container-low hover:bg-secondary-fixed text-primary transition-colors">
                                <span class="material-symbols-outlined text-[18px]">visibility</span>
                            </button>
                            <button onclick="duplicateScenario('${sc.id}')" title="Duplicate Scenario" class="p-2 rounded-xl bg-surface-container-low hover:bg-secondary-fixed text-primary transition-colors">
                                <span class="material-symbols-outlined text-[18px]">content_copy</span>
                            </button>
                            <!-- More Actions Menu Trigger -->
                            <div class="relative group/menu">
                                <button class="p-2 rounded-xl bg-surface-container-low hover:bg-surface-container text-slate-700 transition-colors">
                                    <span class="material-symbols-outlined text-[18px]">more_vert</span>
                                </button>
                                <div class="absolute right-0 bottom-full mb-1 w-52 bg-white rounded-xl shadow-xl border border-outline-variant/40 py-1.5 hidden group-hover/menu:block z-30 font-mono text-[11px]">
                                    <button onclick="openAssociatedTicketsModal('${sc.id}')" class="w-full text-left px-3 py-1.5 hover:bg-surface-container-low text-slate-800 flex items-center gap-2">
                                        <span class="material-symbols-outlined text-[14px] text-primary">folder_special</span>
                                        <span>View Associated Tickets</span>
                                    </button>
                                    <button onclick="openProgressModal('${sc.id}')" class="w-full text-left px-3 py-1.5 hover:bg-surface-container-low text-slate-800 flex items-center gap-2">
                                        <span class="material-symbols-outlined text-[14px] text-primary">analytics</span>
                                        <span>View Student Progress</span>
                                    </button>
                                    <button onclick="openManageAssignmentsModal('${sc.id}')" class="w-full text-left px-3 py-1.5 hover:bg-surface-container-low text-slate-800 flex items-center gap-2">
                                        <span class="material-symbols-outlined text-[14px] text-primary">assignment_ind</span>
                                        <span>Manage Assignments</span>
                                    </button>
                                    <button onclick="openVersionCompareModal('${sc.id}')" class="w-full text-left px-3 py-1.5 hover:bg-surface-container-low text-slate-800 flex items-center gap-2">
                                        <span class="material-symbols-outlined text-[14px] text-primary">history</span>
                                        <span>Compare Versions (Diff)</span>
                                    </button>
                                    <div class="h-px bg-outline-variant/30 my-1"></div>
                                    ${sc.status === 'Draft' || sc.status === 'Ready for Review' ? `
                                        <button onclick="triggerLifecycleTransition('${sc.id}', 'Published')" class="w-full text-left px-3 py-1.5 hover:bg-emerald-50 text-emerald-700 font-bold flex items-center gap-2">
                                            <span class="material-symbols-outlined text-[14px]">publish</span>
                                            <span>Publish Scenario</span>
                                        </button>
                                    ` : ''}
                                    ${sc.status === 'Published' || sc.status === 'Active' ? `
                                        <button onclick="triggerLifecycleTransition('${sc.id}', 'Draft')" class="w-full text-left px-3 py-1.5 hover:bg-amber-50 text-amber-800 font-bold flex items-center gap-2">
                                            <span class="material-symbols-outlined text-[14px]">unpublished</span>
                                            <span>Unpublish (Draft)</span>
                                        </button>
                                    ` : ''}
                                    ${sc.status !== 'Archived' ? `
                                        <button onclick="triggerLifecycleTransition('${sc.id}', 'Archived')" class="w-full text-left px-3 py-1.5 hover:bg-rose-50 text-error font-bold flex items-center gap-2">
                                            <span class="material-symbols-outlined text-[14px]">archive</span>
                                            <span>Archive Scenario</span>
                                        </button>
                                    ` : `
                                        <button onclick="triggerLifecycleTransition('${sc.id}', 'Draft')" class="w-full text-left px-3 py-1.5 hover:bg-blue-50 text-blue-700 font-bold flex items-center gap-2">
                                            <span class="material-symbols-outlined text-[14px]">unarchive</span>
                                            <span>Restore to Draft</span>
                                        </button>
                                    `}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `).join("");
        }

        function renderTableView(list) {
            const tbody = document.getElementById("scenarios-table-rows");
            if (list.length === 0) {
                tbody.innerHTML = `<tr><td colspan="10" class="p-8 text-center text-outline">No scenarios matching the active filter.</td></tr>`;
                return;
            }

            tbody.innerHTML = list.map(sc => `
                <tr class="hover:bg-surface-container-low/60 transition-colors">
                    <td class="p-3.5 pl-5">
                        <div class="flex items-center gap-2">
                            <span class="font-bold text-primary">${sc.id}</span>
                            <span class="text-slate-800 font-semibold truncate max-w-[200px]" title="${sc.title}">${sc.title}</span>
                        </div>
                    </td>
                    <td class="p-3.5">
                        <span class="text-slate-700">${sc.category}</span>
                    </td>
                    <td class="p-3.5">
                        ${getDifficultyBadgeHtml(sc.difficulty)}
                    </td>
                    <td class="p-3.5">
                        <span class="truncate max-w-[160px] block" title="${sc.department}">${sc.department}</span>
                    </td>
                    <td class="p-3.5 text-center font-bold text-secondary">
                        ${sc.ticketsCount}
                    </td>
                    <td class="p-3.5 text-center font-bold text-primary">
                        ${sc.studentsCount}
                    </td>
                    <td class="p-3.5">
                        ${getStatusBadgeHtml(sc.status)}
                    </td>
                    <td class="p-3.5 font-bold text-slate-800">
                        ${sc.version}
                    </td>
                    <td class="p-3.5 truncate max-w-[140px]" title="${sc.instructor}">
                        ${sc.instructor}
                    </td>
                    <td class="p-3.5 text-right pr-5">
                        <div class="flex items-center justify-end gap-1.5">
                            <button onclick="openScenarioBuilderModal('${sc.id}')" title="Edit" class="p-1.5 rounded-lg hover:bg-primary-container hover:text-white text-primary transition-colors">
                                <span class="material-symbols-outlined text-[16px]">edit</span>
                            </button>
                            <button onclick="previewScenarioAsStudent('${sc.id}')" title="Preview" class="p-1.5 rounded-lg hover:bg-secondary-fixed text-primary transition-colors">
                                <span class="material-symbols-outlined text-[16px]">visibility</span>
                            </button>
                            <button onclick="duplicateScenario('${sc.id}')" title="Duplicate" class="p-1.5 rounded-lg hover:bg-secondary-fixed text-primary transition-colors">
                                <span class="material-symbols-outlined text-[16px]">content_copy</span>
                            </button>
                            <button onclick="openAssociatedTicketsModal('${sc.id}')" title="Tickets" class="p-1.5 rounded-lg hover:bg-secondary-fixed text-primary transition-colors">
                                <span class="material-symbols-outlined text-[16px]">folder_special</span>
                            </button>
                        </div>
                    </td>
                </tr>
            `).join("");
        }

        function renderRoadmapView() {
            const level1 = allScenarios.filter(s => (s.progressionLevel === "Level 1" || s.track.includes("Level 1")));
            const level2 = allScenarios.filter(s => (s.progressionLevel === "Level 2" || s.track.includes("Level 2")));
            const level3 = allScenarios.filter(s => (s.progressionLevel === "Level 3" || s.track.includes("Level 3")));

            document.getElementById("roadmap-level-1-cards").innerHTML = level1.map(sc => renderRoadmapCard(sc, "emerald")).join("");
            document.getElementById("roadmap-level-2-cards").innerHTML = level2.map(sc => renderRoadmapCard(sc, "purple")).join("");
            document.getElementById("roadmap-level-3-cards").innerHTML = level3.map(sc => renderRoadmapCard(sc, "rose")).join("");
        }

        function renderRoadmapCard(sc, color) {
            return `
                <div class="p-4 rounded-xl bg-white border border-outline-variant/40 shadow-sm flex flex-col justify-between font-mono text-xs">
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="font-bold text-primary">${sc.id}</span>
                            ${getStatusBadgeHtml(sc.status)}
                        </div>
                        <h4 class="font-bold text-slate-900 text-sm mb-1">${sc.title}</h4>
                        <p class="text-[11px] text-outline font-sans line-clamp-2 mb-3">${sc.description}</p>
                    </div>
                    <div class="pt-2 border-t border-outline-variant/20 flex items-center justify-between text-[11px]">
                        <span class="text-outline">${sc.ticketsCount} Tickets • ${sc.studentsCount} Cadets</span>
                        <button onclick="openScenarioBuilderModal('${sc.id}')" class="text-primary hover:underline font-bold">
                            Manage →
                        </button>
                    </div>
                </div>
            `;
        }

        function updateTopKpiMetrics() {
            document.getElementById("kpi-total-scenarios").textContent = allScenarios.length;
            const activeCount = allScenarios.filter(s => s.status === "Active" || s.status === "Published").length;
            document.getElementById("kpi-active-published").textContent = activeCount;

            const totalStudents = allScenarios.reduce((acc, s) => acc + (parseInt(s.studentsCount) || 0), 0);
            document.getElementById("kpi-total-students").textContent = totalStudents;

            const totalTickets = allScenarios.reduce((acc, s) => acc + (parseInt(s.ticketsCount) || 0), 0);
            document.getElementById("kpi-total-tickets").textContent = totalTickets;
        }

        // -------------------------------------------------------------------------
        // SCENARIO LIFECYCLE STATE MACHINE
        // -------------------------------------------------------------------------
        function triggerLifecycleTransition(scenarioId, targetStatus) {
            const sc = allScenarios.find(s => s.id === scenarioId);
            if (!sc) return;

            const current = sc.status;
            const validTargets = VALID_LIFECYCLE_TRANSITIONS[current] || [];

            // Check validity
            if (!validTargets.includes(targetStatus)) {
                showToast(`Invalid Lifecycle Transition: Cannot transition directly from [${current}] to [${targetStatus}].`, "error");
                return;
            }

            // Check if consequential action requires confirmation
            const isConsequential = (
                (current === "Active" && targetStatus !== "Active") ||
                (targetStatus === "Draft" && (current === "Published" || current === "Active")) ||
                (targetStatus === "Archived")
            );

            if (isConsequential) {
                openConfirmationGuardModal({
                    title: `Confirm Lifecycle Change to [${targetStatus}]`,
                    subtitle: `Scenario: ${sc.id} (${sc.title})`,
                    message: `You are about to change the status of ${sc.id} from [${current}] to [${targetStatus}]. Active enrolled cadets (${sc.studentsCount} students in ${sc.cohort}) and container gates will be updated.`,
                    consequence: targetStatus === "Draft"
                        ? "Unpublishing will revoke student access to active ticket pipelines and private evaluation endpoints."
                        : "Archiving will freeze student submissions and detach scheduled evaluation runners.",
                    onConfirm: () => {
                        applyLifecycleTransition(sc, targetStatus);
                    }
                });
            } else {
                applyLifecycleTransition(sc, targetStatus);
            }
        }

        function applyLifecycleTransition(sc, targetStatus) {
            sc.status = targetStatus;
            sc.lastModified = new Date().toISOString().slice(0, 10);
            saveScenariosToStorage();
            renderCatalog();
            updateTopKpiMetrics();
            showToast(`Scenario ${sc.id} transitioned to [${targetStatus}]`, "success");
        }

        // -------------------------------------------------------------------------
        // MULTI-STEP SCENARIO BUILDER (10 STEPS)
        // -------------------------------------------------------------------------
        const STEP_NAMES = [
            "1. General Info",
            "2. Business Problem",
            "3. Dataset Config",
            "4. Tools & Env",
            "5. Student Workflow",
            "6. Success Criteria",
            "7. Deliverables",
            "8. Evaluation Rules",
            "9. Publication",
            "10. Version History"
        ];

        function renderStepperPills() {
            const container = document.getElementById("stepper-pills-bar");
            container.innerHTML = STEP_NAMES.map((name, idx) => {
                const stepNum = idx + 1;
                let pillClass = "px-3 py-1.5 rounded-lg border transition-all cursor-pointer font-bold ";
                if (stepNum === currentStepIndex) {
                    pillClass += "step-active shadow-sm";
                } else if (stepNum < currentStepIndex) {
                    pillClass += "step-completed";
                } else {
                    pillClass += "step-pending";
                }
                return `
                    <button type="button" onclick="goToStep(${stepNum})" class="${pillClass}">
                        ${name}
                    </button>
                `;
            }).join("");
        }

        function goToStep(stepNum) {
            if (stepNum < 1 || stepNum > 10) return;
            currentStepIndex = stepNum;

            // Hide all step panes, show current
            document.querySelectorAll(".step-pane").forEach((pane, idx) => {
                pane.classList.toggle("hidden", (idx + 1) !== currentStepIndex);
            });

            renderStepperPills();

            // Toggle prev/next/save buttons
            document.getElementById("stepper-prev-btn").disabled = (currentStepIndex === 1);
            document.getElementById("stepper-next-btn").classList.toggle("hidden", (currentStepIndex === 10));
            document.getElementById("stepper-save-final-btn").classList.toggle("hidden", (currentStepIndex !== 10));

            // Scroll form body to top
            document.getElementById("stepper-form-body").scrollTop = 0;
        }

        function goToNextStep() {
            if (currentStepIndex < 10) {
                goToStep(currentStepIndex + 1);
            }
        }

        function goToPreviousStep() {
            if (currentStepIndex > 1) {
                goToStep(currentStepIndex - 1);
            }
        }

        function openScenarioBuilderModal(scenarioId) {
            if (scenarioId) {
                // Editing existing scenario
                currentEditingScenario = JSON.parse(JSON.stringify(allScenarios.find(s => s.id === scenarioId)));
                document.getElementById("editor-modal-mode-badge").textContent = "EDIT SCENARIO";
                document.getElementById("editor-modal-title").textContent = `Edit Specification: ${currentEditingScenario.title}`;
            } else {
                // Creating new scenario
                const nextNum = allScenarios.length + 1;
                currentEditingScenario = {
                    id: `SCN-CUSTOM-${100 + nextNum}`,
                    title: "",
                    track: "Level 1 — AI Fundamentals",
                    progressionLevel: "Level 1",
                    category: "Predictive AI",
                    difficulty: "Intermediate",
                    department: "Customer Retention Operations",
                    instructor: "Dr. K. Voronin (Chief)",
                    ticketsCount: 4,
                    studentsCount: 20,
                    cohort: "Cohort Alpha-4 (Range Primary)",
                    status: "Draft",
                    version: "v1.0.0",
                    lastModified: new Date().toISOString().slice(0, 10),
                    createdDate: new Date().toISOString().slice(0, 10),
                    tags: ["custom", "pipeline"],
                    description: "",
                    businessProblem: {
                        objective: "",
                        description: "",
                        stakeholderRequest: "",
                        businessContext: "",
                        expectedImpact: ""
                    },
                    datasets: [
                        { name: "telecom_customer_churn_v2.parquet", role: "Training Split", access: "Read-Only (Immutable)", version: "v1.0 (sha:99af...)" }
                    ],
                    toolsEnvironment: {
                        pythonVersion: "Python 3.11.8 (Conda Range-v4)",
                        framework: "Triton ONNX Runtime + FastAPI",
                        computeQuota: "4 vCPU, 16GB RAM, CUDA 12.2",
                        libraries: "XGBoost 2.0.3, Scikit-learn 1.4.1, MLflow 2.11, FastAPI 0.110",
                        integrations: ["SYS-01", "SYS-02", "SYS-03", "SYS-04", "SYS-05"]
                    },
                    workflow: [
                        { stage: "Stage 1: Problem Understanding & EDA", action: "Review business mandate and exploratory distributions." },
                        { stage: "Stage 2: Model Training & Experiment Tracking", action: "Train candidates and log metrics to MLflow." },
                        { stage: "Stage 3: Validation & Canary Deployment", action: "Export to ONNX and verify acceptance criteria." }
                    ],
                    successCriteria: {
                        primaryMetricName: "F1 Score Holdout Split",
                        primaryThreshold: "≥ 0.850",
                        secondaryMetric: "ROC-AUC ≥ 0.880",
                        latencySla: "P99 Latency < 60ms",
                        robustness: "Zero NaN predictions; KS drift p > 0.05",
                        hardFailRules: "Data leakage; latency timeout > 120ms."
                    },
                    deliverables: { notebooks: true, repo: true, model: true, card: true, api: true, demo: true },
                    evaluationRules: {
                        weights: [10, 15, 20, 15, 15, 10, 10, 5],
                        passingScore: "75.0% Overall Score",
                        autoValidation: "Enabled (Auto-Grade Unit Tests + Holdout)",
                        instructorReviewReq: "Mandatory Final Signoff Required"
                    },
                    publication: {
                        startDate: new Date().toISOString().slice(0, 10),
                        deadline: new Date(Date.now() + 25 * 86400000).toISOString().slice(0, 10),
                        visible: true
                    },
                    versionHistory: [
                        { version: "v1.0.0", author: "Dr. K. Voronin", date: new Date().toISOString().slice(0, 10), changelog: "Initial authoring draft initialized in Range Builder." }
                    ]
                };
                document.getElementById("editor-modal-mode-badge").textContent = "CREATE SCENARIO";
                document.getElementById("editor-modal-title").textContent = "Author New AI Training Scenario";
            }

            // Populate form fields from currentEditingScenario
            populateBuilderForm(currentEditingScenario);

            // Open to Step 1
            currentStepIndex = 1;
            goToStep(1);

            document.getElementById("scenario-builder-modal").classList.remove("hidden");
        }

        function populateBuilderForm(sc) {
            document.getElementById("editor-modal-scenario-id-preview").textContent = sc.id;
            document.getElementById("editor-modal-version-preview").textContent = `${sc.version} ${sc.status.toUpperCase()}`;

            // Step 1
            document.getElementById("edit-title").value = sc.title || "";
            document.getElementById("edit-id").value = sc.id || "";
            document.getElementById("edit-description").value = sc.description || "";
            document.getElementById("edit-category").value = sc.category || "Predictive AI";
            document.getElementById("edit-difficulty").value = sc.difficulty || "Intermediate";
            document.getElementById("edit-level").value = sc.progressionLevel || "Level 1";
            document.getElementById("edit-department").value = sc.department || "";
            document.getElementById("edit-instructor").value = sc.instructor || "Dr. K. Voronin (Chief)";
            document.getElementById("edit-tags").value = (sc.tags || []).join(", ");

            // Step 2
            const bp = sc.businessProblem || {};
            document.getElementById("edit-bp-objective").value = bp.objective || "";
            document.getElementById("edit-bp-description").value = bp.description || "";
            document.getElementById("edit-bp-stakeholder").value = bp.stakeholderRequest || "";
            document.getElementById("edit-bp-context").value = bp.businessContext || "";
            document.getElementById("edit-bp-impact").value = bp.expectedImpact || "";

            // Step 3
            currentBuilderDatasets = JSON.parse(JSON.stringify(sc.datasets || []));
            renderBuilderDatasetsList();

            // Step 4
            const te = sc.toolsEnvironment || {};
            document.getElementById("edit-python-version").value = te.pythonVersion || "Python 3.11.8 (Conda Range-v4)";
            document.getElementById("edit-framework").value = te.framework || "Triton ONNX Runtime + FastAPI";
            document.getElementById("edit-compute-quota").value = te.computeQuota || "4 vCPU, 16GB RAM, CUDA 12.2";
            document.getElementById("edit-libraries").value = te.libraries || "XGBoost, Scikit-learn, MLflow, FastAPI";

            // Step 6
            const scCrit = sc.successCriteria || {};
            document.getElementById("edit-metric-primary-name").value = scCrit.primaryMetricName || "F1 Score";
            document.getElementById("edit-metric-primary-threshold").value = scCrit.primaryThreshold || "≥ 0.850";
            document.getElementById("edit-metric-secondary").value = scCrit.secondaryMetric || "ROC-AUC ≥ 0.880";
            document.getElementById("edit-metric-latency").value = scCrit.latencySla || "P99 < 60ms";
            document.getElementById("edit-metric-robustness").value = scCrit.robustness || "Zero NaN; KS drift p > 0.05";
            document.getElementById("edit-metric-hardfail").value = scCrit.hardFailRules || "";

            // Step 8
            const er = sc.evaluationRules || {};
            const weights = er.weights || [10, 15, 20, 15, 15, 10, 10, 5];
            weights.forEach((w, i) => {
                const el = document.getElementById(`dim-weight-${i + 1}`);
                if (el) el.value = w;
            });
            calculateRubricTotal();

            // Step 9
            document.getElementById("edit-lifecycle-status").value = sc.status || "Draft";
            document.getElementById("edit-cohort").value = sc.cohort || "Cohort Alpha-4 (Range Primary)";
            document.getElementById("edit-students-count").value = sc.studentsCount || 20;
            const pub = sc.publication || {};
            document.getElementById("edit-start-date").value = pub.startDate || new Date().toISOString().slice(0, 10);
            document.getElementById("edit-deadline").value = pub.deadline || "";
            document.getElementById("edit-visible-toggle").checked = pub.visible !== false;

            // Step 10
            document.getElementById("edit-version").value = sc.version || "v1.0.0";
            document.getElementById("edit-version-author").value = sc.instructor || "Dr. K. Voronin";
            document.getElementById("edit-changelog").value = "";
            renderBuilderVersionHistoryList(sc.versionHistory || []);
        }

        function renderBuilderDatasetsList() {
            const tbody = document.getElementById("builder-datasets-list");
            if (currentBuilderDatasets.length === 0) {
                tbody.innerHTML = `<tr><td colspan="5" class="p-3 text-center text-outline">No datasets attached. Add a dataset below.</td></tr>`;
                return;
            }
            tbody.innerHTML = currentBuilderDatasets.map((ds, idx) => `
                <tr>
                    <td class="p-2.5 font-bold text-primary">${ds.name}</td>
                    <td class="p-2.5 text-slate-800">${ds.role}</td>
                    <td class="p-2.5"><span class="px-2 py-0.5 rounded bg-surface-container font-semibold text-[10px]">${ds.access}</span></td>
                    <td class="p-2.5 font-mono text-[10px] text-outline">${ds.version}</td>
                    <td class="p-2.5 text-center">
                        <button type="button" onclick="removeDatasetFromBuilderList(${idx})" class="text-error hover:underline text-xs">Remove</button>
                    </td>
                </tr>
            `).join("");
        }

        function addDatasetToBuilderList() {
            const name = document.getElementById("new-dataset-name").value.trim();
            const role = document.getElementById("new-dataset-role").value;
            const access = document.getElementById("new-dataset-access").value;
            const version = document.getElementById("new-dataset-version").value.trim() || "v1.0 (verified)";

            if (!name) {
                showToast("Please provide a dataset filename", "error");
                return;
            }

            currentBuilderDatasets.push({ name, role, access, version });
            document.getElementById("new-dataset-name").value = "";
            renderBuilderDatasetsList();
            showToast(`Added ${name} to dataset catalog`, "success");
        }

        function removeDatasetFromBuilderList(idx) {
            currentBuilderDatasets.splice(idx, 1);
            renderBuilderDatasetsList();
        }

        function calculateRubricTotal() {
            let total = 0;
            for (let i = 1; i <= 8; i++) {
                const el = document.getElementById(`dim-weight-${i}`);
                if (el) total += parseInt(el.value) || 0;
            }
            const badge = document.getElementById("rubric-total-weight-badge");
            badge.textContent = `${total}%`;
            badge.className = (total === 100)
                ? "px-2 py-0.5 rounded bg-emerald-100 text-emerald-800 font-bold"
                : "px-2 py-0.5 rounded bg-rose-100 text-rose-800 font-bold";
        }

        function renderBuilderVersionHistoryList(history) {
            const container = document.getElementById("builder-version-history-list");
            if (history.length === 0) {
                container.innerHTML = `<div class="p-2 text-outline">No recorded historical releases yet.</div>`;
                return;
            }
            container.innerHTML = history.map(item => `
                <div class="p-2.5 rounded-lg bg-surface-container-low border border-outline-variant/30 flex items-center justify-between">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="font-bold text-primary">${item.version}</span>
                            <span class="text-outline text-[10px]">${item.date} by ${item.author}</span>
                        </div>
                        <p class="text-slate-800 text-[11px] mt-0.5">${item.changelog}</p>
                    </div>
                    <button type="button" onclick="restoreVersionFromHistory('${item.version}')" class="px-2 py-1 rounded bg-white hover:bg-secondary-fixed text-primary border border-outline-variant/40 font-bold text-[10px]">
                        Restore
                    </button>
                </div>
            `).join("");
        }

        function restoreVersionFromHistory(ver) {
            if (confirm(`Restore configuration to historical version ${ver}?`)) {
                document.getElementById("edit-version").value = ver;
                showToast(`Restored version tag to ${ver}. Save to apply.`, "success");
            }
        }

        function saveCurrentScenario(asDraftOnly) {
            const title = document.getElementById("edit-title").value.trim();
            const id = document.getElementById("edit-id").value.trim();

            if (!title) {
                showToast("Please enter a Scenario Title", "error");
                goToStep(1);
                return;
            }
            if (!id) {
                showToast("Please enter a Scenario ID", "error");
                goToStep(1);
                return;
            }

            // Harvest weights
            const weights = [];
            for (let i = 1; i <= 8; i++) {
                const el = document.getElementById(`dim-weight-${i}`);
                weights.push(parseInt(el ? el.value : 0) || 0);
            }
            const totalWeights = weights.reduce((a, b) => a + b, 0);
            if (!asDraftOnly && totalWeights !== 100) {
                if (!confirm(`Warning: Evaluation Rubric total weight is ${totalWeights}% (must be 100%). Save anyway?`)) {
                    goToStep(8);
                    return;
                }
            }

            // Build/update scenario object
            const targetStatus = asDraftOnly ? "Draft" : document.getElementById("edit-lifecycle-status").value;

            // Version Changelog entry
            const versionTag = document.getElementById("edit-version").value.trim() || "v1.0.0";
            const changelogText = document.getElementById("edit-changelog").value.trim() || (asDraftOnly ? "Draft saved from Scenario Builder" : "Updated specification in Scenario Builder");
            const author = document.getElementById("edit-version-author").value.trim() || "Dr. K. Voronin";

            const history = currentEditingScenario.versionHistory || [];
            history.unshift({
                version: versionTag,
                author: author,
                date: new Date().toISOString().slice(0, 10),
                changelog: changelogText
            });

            const updatedScenario = {
                id: id,
                title: title,
                track: document.getElementById("edit-level").value,
                progressionLevel: document.getElementById("edit-level").value,
                category: document.getElementById("edit-category").value,
                difficulty: document.getElementById("edit-difficulty").value,
                department: document.getElementById("edit-department").value.trim() || "Operations",
                instructor: document.getElementById("edit-instructor").value.trim() || "Dr. K. Voronin (Chief)",
                ticketsCount: currentEditingScenario.ticketsCount || 6,
                studentsCount: parseInt(document.getElementById("edit-students-count").value) || 20,
                cohort: document.getElementById("edit-cohort").value,
                status: targetStatus,
                version: versionTag,
                lastModified: new Date().toISOString().slice(0, 10),
                createdDate: currentEditingScenario.createdDate || new Date().toISOString().slice(0, 10),
                tags: document.getElementById("edit-tags").value.split(",").map(t => t.trim()).filter(Boolean),
                description: document.getElementById("edit-description").value.trim(),
                businessProblem: {
                    objective: document.getElementById("edit-bp-objective").value.trim(),
                    description: document.getElementById("edit-bp-description").value.trim(),
                    stakeholderRequest: document.getElementById("edit-bp-stakeholder").value.trim(),
                    businessContext: document.getElementById("edit-bp-context").value.trim(),
                    expectedImpact: document.getElementById("edit-bp-impact").value.trim()
                },
                datasets: currentBuilderDatasets,
                toolsEnvironment: {
                    pythonVersion: document.getElementById("edit-python-version").value,
                    framework: document.getElementById("edit-framework").value,
                    computeQuota: document.getElementById("edit-compute-quota").value.trim(),
                    libraries: document.getElementById("edit-libraries").value.trim(),
                    integrations: ["SYS-01", "SYS-02", "SYS-03", "SYS-04", "SYS-05"]
                },
                workflow: currentEditingScenario.workflow || [
                    { stage: "Stage 1: Intake & EDA", action: "Review business problem and feature schema." },
                    { stage: "Stage 2: Model Training", action: "Train and evaluate candidate classifiers." }
                ],
                successCriteria: {
                    primaryMetricName: document.getElementById("edit-metric-primary-name").value.trim(),
                    primaryThreshold: document.getElementById("edit-metric-primary-threshold").value.trim(),
                    secondaryMetric: document.getElementById("edit-metric-secondary").value.trim(),
                    latencySla: document.getElementById("edit-metric-latency").value.trim(),
                    robustness: document.getElementById("edit-metric-robustness").value.trim(),
                    hardFailRules: document.getElementById("edit-metric-hardfail").value.trim()
                },
                deliverables: {
                    notebooks: document.getElementById("deliv-notebooks").checked,
                    repo: document.getElementById("deliv-repo").checked,
                    model: document.getElementById("deliv-model").checked,
                    card: document.getElementById("deliv-card").checked,
                    api: document.getElementById("deliv-api").checked,
                    demo: document.getElementById("deliv-demo").checked
                },
                evaluationRules: {
                    weights: weights,
                    passingScore: document.getElementById("edit-passing-score").value.trim(),
                    autoValidation: document.getElementById("edit-auto-val").value,
                    instructorReviewReq: document.getElementById("edit-instructor-review-req").value
                },
                publication: {
                    startDate: document.getElementById("edit-start-date").value,
                    deadline: document.getElementById("edit-deadline").value,
                    visible: document.getElementById("edit-visible-toggle").checked
                },
                versionHistory: history
            };

            // Upsert into allScenarios
            const existingIdx = allScenarios.findIndex(s => s.id === id);
            if (existingIdx >= 0) {
                allScenarios[existingIdx] = updatedScenario;
            } else {
                allScenarios.push(updatedScenario);
            }

            saveScenariosToStorage();
            renderCatalog();
            updateTopKpiMetrics();
            closeScenarioBuilderModal();

            showToast(`Scenario ${id} saved successfully!`, "success");
        }

        function closeScenarioBuilderModal() {
            document.getElementById("scenario-builder-modal").classList.add("hidden");
            currentEditingScenario = null;
        }

        function duplicateScenario(scenarioId) {
            const sc = allScenarios.find(s => s.id === scenarioId);
            if (!sc) return;

            const clone = JSON.parse(JSON.stringify(sc));
            const newId = `${sc.id}-COPY`;
            clone.id = newId;
            clone.title = `${sc.title} (Copy)`;
            clone.status = "Draft";
            clone.version = "v1.0.0-DRAFT";
            clone.createdDate = new Date().toISOString().slice(0, 10);
            clone.lastModified = new Date().toISOString().slice(0, 10);
            clone.versionHistory = [
                { version: "v1.0.0-DRAFT", author: "Dr. K. Voronin", date: new Date().toISOString().slice(0, 10), changelog: `Duplicated from ${sc.id} (${sc.version})` }
            ];

            allScenarios.unshift(clone);
            saveScenariosToStorage();
            renderCatalog();
            updateTopKpiMetrics();
            showToast(`Duplicated ${sc.id} as ${newId}!`, "success");
        }

        // -------------------------------------------------------------------------
        // MODAL PREVIEW AS STUDENT
        // -------------------------------------------------------------------------
        function previewScenarioAsStudent(scenarioId) {
            const sc = allScenarios.find(s => s.id === scenarioId);
            if (!sc) return;

            document.getElementById("preview-student-id").textContent = sc.id;
            document.getElementById("preview-student-version").textContent = sc.version;
            document.getElementById("preview-student-title").textContent = sc.title;

            const bp = sc.businessProblem || {};
            const scCrit = sc.successCriteria || {};
            const te = sc.toolsEnvironment || {};
            const pub = sc.publication || {};

            const container = document.getElementById("preview-student-content");
            container.innerHTML = `
                <!-- Problem Statement Card -->
                <div class="p-4 rounded-xl bg-surface-container-low border border-outline-variant/40 space-y-2">
                    <div class="flex items-center justify-between text-outline text-[11px] uppercase font-bold">
                        <span>Operational Mandate • ${sc.department}</span>
                        <span class="text-primary font-bold">Due: ${pub.deadline || '2026-10-31'}</span>
                    </div>
                    <h3 class="font-bold text-sm text-slate-900">${bp.objective || sc.title}</h3>
                    <p class="text-xs text-on-surface-variant font-sans leading-relaxed">${bp.description || sc.description}</p>
                    ${bp.stakeholderRequest ? `
                        <div class="p-2.5 rounded-lg bg-surface-container border-l-4 border-primary text-[11px] text-slate-800 italic">
                            "${bp.stakeholderRequest}"
                        </div>
                    ` : ''}
                </div>

                <!-- Numerical Acceptance Gates -->
                <div class="p-4 rounded-xl bg-surface-container-low border border-outline-variant/40 space-y-3">
                    <h4 class="font-bold text-xs uppercase text-primary flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[16px]">verified</span>
                        Strict Holdout Evaluation Acceptance Gates
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        <div class="p-2.5 rounded-lg bg-white border border-outline-variant/30">
                            <span class="text-outline text-[10px] block uppercase">Primary Target Gate</span>
                            <strong class="text-emerald-700 text-sm">${scCrit.primaryThreshold || '≥ 0.850'}</strong>
                            <span class="text-[10px] text-slate-600 block">${scCrit.primaryMetricName || 'Metric'}</span>
                        </div>
                        <div class="p-2.5 rounded-lg bg-white border border-outline-variant/30">
                            <span class="text-outline text-[10px] block uppercase">Secondary Metric</span>
                            <strong class="text-primary text-sm">${scCrit.secondaryMetric || 'F1 ≥ 0.80'}</strong>
                        </div>
                        <div class="p-2.5 rounded-lg bg-white border border-outline-variant/30">
                            <span class="text-outline text-[10px] block uppercase">Latency Cap</span>
                            <strong class="text-slate-900 text-sm">${scCrit.latencySla || '< 60ms'}</strong>
                        </div>
                    </div>
                    ${scCrit.hardFailRules ? `
                        <div class="p-2 rounded bg-rose-50 border border-rose-200 text-rose-800 text-[11px]">
                            <strong>Disqualification Warning:</strong> ${scCrit.hardFailRules}
                        </div>
                    ` : ''}
                </div>

                <!-- Attached Datasets & Download URI -->
                <div class="p-4 rounded-xl bg-surface-container-low border border-outline-variant/40 space-y-2">
                    <h4 class="font-bold text-xs uppercase text-primary flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[16px]">database</span>
                        Permitted SYS-AI-02 Datasets
                    </h4>
                    <div class="space-y-1.5">
                        ${(sc.datasets || []).map(ds => `
                            <div class="p-2 rounded-lg bg-white border border-outline-variant/30 flex items-center justify-between text-[11px]">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-[16px] text-primary">table_chart</span>
                                    <span class="font-bold text-slate-800">${ds.name}</span>
                                    <span class="px-1.5 py-0.2 rounded bg-surface-container text-slate-700 text-[9px]">${ds.role}</span>
                                </div>
                                <span class="font-mono text-outline text-[10px]">${ds.access}</span>
                            </div>
                        `).join('')}
                    </div>
                </div>

                <!-- Execution Command for Workbench -->
                <div class="p-3 rounded-xl bg-slate-900 text-emerald-400 font-mono text-xs space-y-1">
                    <div class="text-slate-400 text-[10px]"># Launch cadet sandbox in SYS-AI-03 Workbench:</div>
                    <div>vostok-ai flight-deck launch --scenario ${sc.id} --cohort alpha-4 --version ${sc.version}</div>
                </div>
            `;

            document.getElementById("preview-student-modal").classList.remove("hidden");
        }

        // -------------------------------------------------------------------------
        // MODAL VERSION COMPARE (DIFF)
        // -------------------------------------------------------------------------
        function openVersionCompareModal(scenarioId) {
            const sc = allScenarios.find(s => s.id === scenarioId);
            if (!sc) return;

            document.getElementById("compare-modal-scenario-title").textContent = `Version Diff Matrix: ${sc.id} (${sc.title})`;
            const history = sc.versionHistory || [];
            const vLatest = sc.version;
            const vPrev = history.length > 1 ? history[1].version : "v1.0.0-BASELINE";

            const container = document.getElementById("version-compare-content");
            container.innerHTML = `
                <div class="flex items-center justify-between p-3 rounded-xl bg-surface-container-low border border-outline-variant/40">
                    <div class="flex items-center gap-4">
                        <div>
                            <span class="text-outline text-[10px] uppercase block">Base Revision</span>
                            <span class="font-bold text-slate-800">${vPrev}</span>
                        </div>
                        <span class="material-symbols-outlined text-outline">arrow_forward</span>
                        <div>
                            <span class="text-outline text-[10px] uppercase block">Current Active Revision</span>
                            <span class="font-bold text-primary">${vLatest}</span>
                        </div>
                    </div>
                    <span class="px-2.5 py-1 rounded bg-secondary-fixed text-primary font-bold text-xs">Verified by Lead Architect</span>
                </div>

                <!-- Side-by-Side Diff Comparison Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Previous Spec Card -->
                    <div class="p-4 rounded-xl bg-surface-container-low border border-outline-variant/40 space-y-3">
                        <div class="font-bold text-slate-800 pb-1 border-b border-outline-variant/30 flex items-center justify-between">
                            <span>Base: ${vPrev}</span>
                            <span class="text-outline text-[10px]">Archived Snapshot</span>
                        </div>
                        <div>
                            <span class="text-outline text-[10px] uppercase block">Primary Gate</span>
                            <span class="font-mono text-slate-700">AUC ≥ 0.820 Holdout</span>
                        </div>
                        <div>
                            <span class="text-outline text-[10px] uppercase block">Latency Cap</span>
                            <span class="font-mono text-slate-700">P99 < 100ms</span>
                        </div>
                        <div>
                            <span class="text-outline text-[10px] uppercase block">Dataset Schema</span>
                            <span class="font-mono text-slate-700">telecom_customer_churn_v1.csv</span>
                        </div>
                        <div>
                            <span class="text-outline text-[10px] uppercase block">Rubric Distribution</span>
                            <span class="font-mono text-slate-700">Problem: 10%, Model: 25%, API: 15%, Docs: 10%</span>
                        </div>
                    </div>

                    <!-- Current Spec Card with Highlights -->
                    <div class="p-4 rounded-xl bg-white border-2 border-primary shadow-sm space-y-3">
                        <div class="font-bold text-primary pb-1 border-b border-outline-variant/30 flex items-center justify-between">
                            <span>Current: ${vLatest}</span>
                            <span class="px-2 py-0.5 rounded bg-emerald-100 text-emerald-800 text-[10px] font-bold">ACTIVE</span>
                        </div>
                        <div>
                            <span class="text-outline text-[10px] uppercase block">Primary Gate</span>
                            <span class="font-mono text-emerald-700 font-bold bg-emerald-50 px-1 rounded">${sc.successCriteria?.primaryThreshold || '≥ 0.850'} (+0.030 Gate Rigor)</span>
                        </div>
                        <div>
                            <span class="text-outline text-[10px] uppercase block">Latency Cap</span>
                            <span class="font-mono text-primary font-bold bg-secondary-fixed/50 px-1 rounded">${sc.successCriteria?.latencySla || '< 60ms'} (Tightened from 100ms)</span>
                        </div>
                        <div>
                            <span class="text-outline text-[10px] uppercase block">Dataset Schema</span>
                            <span class="font-mono text-primary font-bold bg-secondary-fixed/50 px-1 rounded">Apache Parquet v2 (Columnar binary)</span>
                        </div>
                        <div>
                            <span class="text-outline text-[10px] uppercase block">Rubric Distribution</span>
                            <span class="font-mono text-slate-900 font-bold">8-Dimension Rigorous Matrix (Problem: 10%, Prep: 15%, Model: 20%, Holdout: 15%)</span>
                        </div>
                    </div>
                </div>

                <!-- Changelog History Trail -->
                <div class="p-3 rounded-xl bg-surface-container-low border border-outline-variant/30 space-y-1.5">
                    <span class="text-outline text-[10px] font-bold uppercase block">Release Changelog History:</span>
                    ${history.map(h => `
                        <div class="text-[11px] text-slate-800">
                            <strong>${h.version}</strong> (${h.date} by ${h.author}): ${h.changelog}
                        </div>
                    `).join('')}
                </div>
            `;

            document.getElementById("version-compare-modal").classList.remove("hidden");
        }

        // -------------------------------------------------------------------------
        // MODAL ASSOCIATED TICKETS (SYS-AI-01 INTEGRATION)
        // -------------------------------------------------------------------------
        function openAssociatedTicketsModal(scenarioId) {
            const sc = allScenarios.find(s => s.id === scenarioId);
            if (!sc) return;

            document.getElementById("tickets-modal-scenario-title").textContent = `SYS-AI-01 Associated Sprint Tickets: ${sc.id}`;

            const ticketPrefix = sc.id.replace("SCN-", "TCK-");
            const tickets = [
                { id: `${ticketPrefix}-01`, title: "Telemetry EDA & Class Imbalance Audit", status: "Done", assignee: "Cadet Voronova", priority: "High" },
                { id: `${ticketPrefix}-02`, title: "Feature Pipeline & Target Leakage Guard", status: "Done", assignee: "Cadet Belov", priority: "Critical" },
                { id: `${ticketPrefix}-03`, title: "Baseline Gradient Boost Classifier Training", status: "In Progress", assignee: "Cadet Mikhailov", priority: "High" },
                { id: `${ticketPrefix}-04`, title: "Holdout Split Evaluation & ROC Threshold Optimization", status: "In Progress", assignee: "Cadet Chen", priority: "High" },
                { id: `${ticketPrefix}-05`, title: "Triton ONNX Microservice Latency Packaging", status: "Under Review", assignee: "Cadet Al-Mansoor", priority: "Critical" },
                { id: `${ticketPrefix}-06`, title: "Simulated Drift Triage & Model Card Documentation", status: "Open", assignee: "Unassigned", priority: "Medium" }
            ];

            const container = document.getElementById("tickets-modal-content");
            container.innerHTML = `
                <div class="p-3 rounded-xl bg-surface-container-low border border-outline-variant/40 flex items-center justify-between">
                    <div>
                        <span class="text-outline text-[10px] uppercase block">Linked Agile Sprint</span>
                        <strong class="text-slate-800">Sprint 24-B • Range Testbed Alpha-4</strong>
                    </div>
                    <span class="px-2.5 py-1 rounded bg-secondary-fixed text-primary font-bold text-xs">${tickets.length} Tickets Synced to SYS-AI-01</span>
                </div>

                <div class="rounded-xl border border-outline-variant/40 overflow-hidden">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-surface-container-low text-outline text-[10px] uppercase">
                            <tr>
                                <th class="p-2.5">Ticket Key</th>
                                <th class="p-2.5">Task Description</th>
                                <th class="p-2.5">Assignee</th>
                                <th class="p-2.5">Priority</th>
                                <th class="p-2.5 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant/20 bg-white">
                            ${tickets.map(t => `
                                <tr>
                                    <td class="p-2.5 font-bold text-primary">${t.id}</td>
                                    <td class="p-2.5 font-medium text-slate-800">${t.title}</td>
                                    <td class="p-2.5 text-slate-600">${t.assignee}</td>
                                    <td class="p-2.5">
                                        <span class="px-1.5 py-0.2 rounded ${t.priority === 'Critical' ? 'bg-rose-100 text-rose-800 font-bold' : 'bg-surface-container text-slate-700'} text-[10px]">${t.priority}</span>
                                    </td>
                                    <td class="p-2.5 text-center">
                                        <span class="px-2 py-0.5 rounded ${t.status === 'Done' ? 'bg-emerald-100 text-emerald-800' : (t.status === 'In Progress' ? 'bg-blue-100 text-blue-800' : 'bg-surface-container text-slate-700')} font-bold text-[10px]">${t.status}</span>
                                    </td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                </div>
            `;

            document.getElementById("tickets-view-modal").classList.remove("hidden");
        }

        // -------------------------------------------------------------------------
        // MODAL PROGRESS & SUBMISSIONS (SYS-AI-05 TRACKER)
        // -------------------------------------------------------------------------
        function openProgressModal(scenarioId) {
            const sc = allScenarios.find(s => s.id === scenarioId);
            if (!sc) return;

            document.getElementById("progress-modal-scenario-title").textContent = `Cohort Progress & Submissions: ${sc.id} (${sc.title})`;

            const students = [
                { name: "Cadet Sofia Voronova", stage: "Stage 5: Live Drift", score: "94.2%", repo: "github.com/vostok-cadets/voronova-churn", gate: "PASSED", status: "Under Final Review" },
                { name: "Cadet Alexander Belov", stage: "Stage 4: Validation", score: "88.0%", repo: "github.com/vostok-cadets/belov-churn", gate: "PASSED", status: "Submitted" },
                { name: "Cadet Mikhail Chen", stage: "Stage 3: Training", score: "78.5%", repo: "github.com/vostok-cadets/chen-churn", gate: "TESTING", status: "In Progress" },
                { name: "Cadet Tariq Al-Mansoor", stage: "Stage 4: Validation", score: "91.4%", repo: "github.com/vostok-cadets/mansoor-churn", gate: "PASSED", status: "Submitted" },
                { name: "Cadet Elena Rostova Jr.", stage: "Stage 2: Feature Pipeline", score: "--", repo: "github.com/vostok-cadets/rostova-churn", gate: "PENDING", status: "In Progress" }
            ];

            const container = document.getElementById("progress-modal-content");
            container.innerHTML = `
                <div class="grid grid-cols-1 md:grid-cols-4 gap-3 text-center">
                    <div class="p-3 rounded-xl bg-surface-container-low border border-outline-variant/40">
                        <span class="text-outline text-[10px] block uppercase">Enrolled Cohort</span>
                        <strong class="text-primary text-sm">${sc.cohort || 'Cohort Alpha-4'}</strong>
                    </div>
                    <div class="p-3 rounded-xl bg-surface-container-low border border-outline-variant/40">
                        <span class="text-outline text-[10px] block uppercase">Submissions Received</span>
                        <strong class="text-emerald-700 text-sm">31 / ${sc.studentsCount}</strong>
                    </div>
                    <div class="p-3 rounded-xl bg-surface-container-low border border-outline-variant/40">
                        <span class="text-outline text-[10px] block uppercase">Mean Benchmark Score</span>
                        <strong class="text-primary text-sm">88.4% F1</strong>
                    </div>
                    <div class="p-3 rounded-xl bg-surface-container-low border border-outline-variant/40">
                        <span class="text-outline text-[10px] block uppercase">Gate Pass Rate</span>
                        <strong class="text-emerald-700 text-sm">92.6%</strong>
                    </div>
                </div>

                <div class="rounded-xl border border-outline-variant/40 overflow-hidden">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-surface-container-low text-outline text-[10px] uppercase">
                            <tr>
                                <th class="p-2.5">Cadet Name</th>
                                <th class="p-2.5">Active Stage</th>
                                <th class="p-2.5">Repository / Artifact</th>
                                <th class="p-2.5 text-center">Eval Score</th>
                                <th class="p-2.5 text-center">Triton Gate</th>
                                <th class="p-2.5 text-right">Instructor Grade</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant/20 bg-white">
                            ${students.map(st => `
                                <tr>
                                    <td class="p-2.5 font-bold text-slate-800">${st.name}</td>
                                    <td class="p-2.5 text-primary font-semibold">${st.stage}</td>
                                    <td class="p-2.5">
                                        <a href="#" class="text-secondary hover:underline truncate block max-w-[200px]">${st.repo}</a>
                                    </td>
                                    <td class="p-2.5 text-center font-bold text-emerald-700">${st.score}</td>
                                    <td class="p-2.5 text-center">
                                        <span class="px-2 py-0.5 rounded ${st.gate === 'PASSED' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800'} text-[10px] font-bold">${st.gate}</span>
                                    </td>
                                    <td class="p-2.5 text-right">
                                        <button onclick="showToast('Grade rubric opened for ${st.name}', 'success')" class="px-2.5 py-1 rounded bg-primary-container text-white text-[11px] font-bold hover:bg-primary">
                                            Grade
                                        </button>
                                    </td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                </div>
            `;

            document.getElementById("progress-view-modal").classList.remove("hidden");
        }

        // -------------------------------------------------------------------------
        // MODAL MANAGE ASSIGNMENTS
        // -------------------------------------------------------------------------
        let activeAssignmentScenarioId = null;
        function openManageAssignmentsModal(scenarioId) {
            const sc = allScenarios.find(s => s.id === scenarioId);
            if (!sc) return;
            activeAssignmentScenarioId = scenarioId;
            document.getElementById("assign-scenario-title-input").value = `${sc.id}: ${sc.title}`;
            document.getElementById("manage-assignments-modal").classList.remove("hidden");
        }

        function saveAssignmentChanges() {
            showToast("Cohort assignments and schedule overrides updated!", "success");
            closeModal("manage-assignments-modal");
        }

        // -------------------------------------------------------------------------
        // INTEGRATION MONITOR MODAL
        // -------------------------------------------------------------------------
        function openIntegrationMonitorModal() {
            document.getElementById("integration-monitor-modal").classList.remove("hidden");
        }

        // -------------------------------------------------------------------------
        // CONFIRMATION GUARD DIALOG
        // -------------------------------------------------------------------------
        function openConfirmationGuardModal(config) {
            document.getElementById("guard-title").textContent = config.title;
            document.getElementById("guard-subtitle").textContent = config.subtitle;
            document.getElementById("guard-message").textContent = config.message;
            document.getElementById("guard-consequence").textContent = config.consequence;

            const btn = document.getElementById("guard-confirm-action-btn");
            // Clear previous onclick listeners
            btn.onclick = () => {
                closeModal("confirmation-guard-modal");
                config.onConfirm();
            };

            document.getElementById("confirmation-guard-modal").classList.remove("hidden");
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add("hidden");
        }

        // -------------------------------------------------------------------------
        // TOAST NOTIFICATIONS
        // -------------------------------------------------------------------------
        function showToast(message, type = "info") {
            const container = document.getElementById("toast-container");
            const toast = document.createElement("div");

            let bgClass = "bg-primary-container text-white border-secondary-container";
            if (type === "success") bgClass = "bg-emerald-800 text-white border-emerald-400";
            if (type === "error") bgClass = "bg-error text-white border-rose-300";

            toast.className = `p-3.5 rounded-xl shadow-xl border ${bgClass} flex items-center gap-2 pointer-events-auto transition-all animate-in fade-in slide-in-from-bottom-2 duration-200`;
            toast.innerHTML = `
                <span class="material-symbols-outlined text-[18px]">${type === 'success' ? 'check_circle' : (type === 'error' ? 'error' : 'info')}</span>
                <span>${message}</span>
            `;

            container.appendChild(toast);
            setTimeout(() => {
                toast.style.opacity = "0";
                toast.style.transform = "translateY(8px)";
                setTimeout(() => toast.remove(), 250);
            }, 3500);
        }