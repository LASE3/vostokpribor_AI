# Verified completed features — V10

Verified2026-11-01 on **main**, source `C:/xampp/htdocs/vostokpribor_AI`, V9 comparison baseline **13ae511**, checkpoint `codex/v10-baseline-20261101`. **READY FOR CONTROLLED LOCAL DEMONSTRATION. Live Colab execution remains BLOCKED; public production is NOT READY.**

[Complete34-part engineering report](docs/V10_FINAL_REPORT.md), [actual test results](docs/V10_TEST_RESULTS.md), [Colab implementation/configuration](docs/V10_COLAB_INTEGRATION.md), [role matrix](docs/V10_ROLE_ACCESS_MATRIX.md), [cleanup](docs/V10_CLEANUP_REPORT.md). Exact file statuses and unified lines against13ae511 are included in the companion evidence as source-change-inventory.json/source-changes.patch.

Verified locally:

- STUDENT login shows exactly four systems; no SOC card/menu/shortcut. Direct SOC page/API requests return403. ADMIN login/root goes directly to SOC Dashboard, and student HTML systems reject ADMIN. Shared backend administrator inspection remains available in SOC.
- ML Workbench exports actual saved code as standard .ipynb with unique cell IDs and private attachment headers. Open Google Colab is a manual link; no automatic code or dataset transfer. Import checks a real file and creates a new owned notebook, discarding outputs/attachments/foreign IDs/execution/provenance claims. Actual download→browser file chooser→import→reload and independent SQL confirm literal code persistence.
- Enterprise adapter prepares Google's documented create request offline. OAuth refresh/RSA/HTTPS contracts are implemented, secrets stay outside webroot/in server memory, and SOC reports configuration availability honestly. submit/cancel remain disabled even with configuration. The user has no Google Cloud project; no authenticated Google execution, runtime isolation, result retrieval or billing/quota proof is claimed.
- Existing SOC→student ticket/dataset/notebook/model/submission/review workflow, pagination, concurrency and security regressions pass on isolated databases. No host Python fallback, trusted evaluation from manual metrics, or fabricated inference endpoint exists.

Main remains one administrator and zero students/training records. Its52 original private files, .env and administrator password are unchanged. Original18 audit rows are preserved; one real localhost login since the V9 snapshot makes the current total19, with login/auth-rate metadata changes, before isolated tests. No main work was seeded or reset. V10 requires no schema change; all eight migrations remain.

Executed evidence:

|Scope|Result|
|---|---|
|Clean extracted release|295 source files, CRC/all hashes; one hashed admin and zero others before HTTP; exact DML runtime, DDL/main-DB denial|
|Fresh release workflow|208 role/workflow +33 Colab exchange +257 cross-system/30 independent SQL checks passed|
|Main isolated regressions|205 reuse-role /146 entry /398 central SOC /244 supplementary /75 pagination /25 empty pages passed|
|Security HTTP|98 request /106 adversarial SOC /23 injected core /244 header-exposure /142 backend passed; actual429 Retry-After114|
|Offline provider/authentication|35 document/Enterprise plan +62 OAuth/HTTPS contracts passed; **no Google call**|
|Pure/client/assets|44 role,49 security,89 policy,8 Env,23 client,67 async,31 packaging,41 assets,10 storage,13 target checks passed|
|Actual MySQL|44 training,27 dataset,31 workspace,23 integrity,29 scenario,84 paging/provenance,29 concurrency,50 metrics,77 encrypted recovery passed|
|Syntax|188 shipped PHP/20 JavaScript/32 Python, zero errors|
|Performance|10/50/100/500 student probes;5,000models bounded757,801B/71.597ms and compact44,701B/63.871ms median; HTTP1/5/10-session p95 below49ms|
|Browser|Four student cards/no SOC; admin SOC; code download/import/reload;390/768/1280/1440 viewport fits; SOC console zero errors|

Source audit:1,147 files in six explicit classes, zero operational/encoding/coverage blockers; all contextual matches retained. Carefully removed25 inspected retired exit-only stubs,4,711bytes/92lines, with Git recovery and reference evidence. No dependencies or active functionality removed; version metadata10.0.0, pinned Tailwind unchanged. Driver/setup failures and corrections are retained, not concealed.

Release files outside webroot: `C:/Users/nijim/.codex/artifacts/vostokpribor-ai-v10-final-20261101.zip` and separate `vostokpribor-ai-v10-evidence-20261101.zip`, each with an external manifest. Source excludes environment/history/credentials/dumps/private payloads/logs/cache/generated output; storage controls and eight migrations remain. Evidence contains reviewed logs/JSON/patch/screenshots, no credentials or uploaded bytes. Source is not a data backup. [Installation/recovery](docs/V10_DEPLOYMENT_GUIDE.md).

Remaining blockers: Google project/billing/API/authentication, verified per-student IAM/network/storage/runtime isolation, actual execution/results/cancellation/cleanup; trusted evaluator; inference provider; dataset SQL engine; maintained host rollout, main least-privilege cutover, HTTPS/monitoring/recurring off-site backups, sustained public load/security acceptance. The full AI range has11/17 accepted core+advanced items (64.7%); the six advanced criteria are blocked. Public additional gates5/14 (35.7%); these scoped checklists do not imply production readiness.
