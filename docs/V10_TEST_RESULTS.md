# V10 executed test results

Observed2026-11-01, Asia/Amman, on actual Windows/XAMPP Apache/PHP/native PDO/MariaDB. Source baseline13ae511 on main. These are assertion counts within named suites, not unique product features, line coverage or production certification. Offline/mocked contracts are distinguished from real HTTP/SQL/browser evidence. Protected logs and JSON are under `verification/v10-20261101/`; generated evidence and credentials are excluded from the clean source ZIP.

## Test isolation and observed installation

Actual live HTTP target: `vostok_range_v10_20261101_integration_a_test`, APP_ENV=testing, independent `.env`, cookie, source/storage tree and exact-schema DML-only HTTP identity. The test tree is `C:/Users/nijim/.codex/tmp/vostok-v10-integration-20261101a/vostokpribor_AI`. Tests check the saved CLI target and actual HTTP cookie before credentials. No mutating suite is directed at main. File-writing PHP suites additionally require the prepared tree/database storage marker; process environment overrides alone cannot select another private storage directory.

`fresh-install.log` and `fresh-verifier.log` record eight migrations, exactly one active hashed local ADMIN with mandatory rotation, and zero every non-user/non-migration table before HTTP. Administrator password was then genuinely rotated only in the isolated instance. Actual runtime grants are checked in `stage-grants.json`. Test credentials are random/private outside source/webroot and keyed by the exact database; no password/key/token is published in this report.

The dedicated testing login is **student_test**, canonical stored identifier **STUDENT_TEST** under the existing case-insensitive/uppercase provisioning contract, display name VOSTOKPRIBOR Test Student. Actual SQL verifies ACTIVE/STUDENT, bcrypt/password verification and completed mandatory rotation without returning the hash/password. A second isolated student has independent work. Existing test work was retained rather than reset between runs.

## Offline and source checks

|Suite|Executed result|Evidence|
|---|---|---|
|Colab notebook/document/provider contracts|**35 passed**; no network/database/Python execution|colab-contract.log|
|Google OAuth/HTTPS contracts|62 passed; synthetic credentials and deterministic transport only|google-auth-contracts.log, google-auth.log|
|Role/system access and navigation|44 passed; no database connection|roles-unit.log, system-access-unit.log|
|Security unit / policy / environment|49 /89 /8 passed|security-unit.log, security-policy.log, env.log|
|Client transport / asynchronous frontend|23 /67 passed; mocked/deterministic, not live HTTP|frontend-client.log, frontend-async.log|
|Release exclusion policy / production assets|31 /41 passed|package.log, assets.log|
|File-storage / HTTP-target guards|10 /13 passed|storage-guard.log, http-target.log|
|New role suite pointed at non-test main configuration|Refused during CLI preflight before database connection/credentials/HTTP writes|role-target-refusal.json|
|Shipped source syntax|188 PHP,20 JS/CJS,32 Python; zero syntax errors|syntax.json|
|Pinned CSS rebuild / consistency|Build/check completed successfully|build-css.log, check-css.log|
|Recursive classified source audit|1,147 files; zero operational blocking/coverage/encoding findings|source-audit-current.json, source-inventory-current.json|

The earlier pure-tests.json summary captured32 Colab assertions before two additional boundary checks and the required unique-cell-ID check. The final colab-contract.log records **35**, which is the accepted final count. This distinction prevents presenting the older summary as the final run. OAuth/HTTPS tests exercise refresh/expiration, fixed trusted endpoints, redirect/header restrictions and safe failures; they do not establish real Google account authorization, project billing or isolation.

The recursive inventory classes are156 active application,871 dependency,19 development tool,28 generated artifact,8 migration and65 test files. The complete contextual findings remain available with path/classification rather than being deleted to force a clean score. This scan is not an authorization proof or penetration-test certificate. Cleanup removed only25 inspected, Git-recoverable retired exit stubs; [exact cleanup/reference evidence](V10_CLEANUP_REPORT.md).

## Actual Apache/HTTP/SQL checks

|Suite|Executed result|Evidence|
|---|---|---|
|Dedicated student_test / role workflow|205 passed, including real provisioning/rotation, two-user work, decisions and denials|http-roles-v10.log, role-boundaries.json|
|Role-specific Dashboard/directory/resources|146 passed; student four systems, administrator SOC; forbidden role403|http-system-entry.log, system-dashboard-entries.json|
|Local Colab code exchange|33 passed; actual code-only export/import/reload, CSRF/ownership/output stripping|http-colab.log|
|Central SOC workflow|398 passed|http_central_soc.log|
|Persisted cross-system workflow + independent SQL|257 passed /30 SQL persistence proofs|http_workflow_v9.log, database-http-proof.json|
|Empty new-student pages|25 passed; navigation creates no work|http_empty_pages.log|
|Actual collection pagination|75 passed; exact totals, stable later windows, invalid pagination rejected|http_pagination_v9.log, http-pagination.json|
|Supplementary shared/compatibility endpoints|244 passed|http_soc_extra.log|
|Request/media-type/identifier security|98 passed|http_request_security_v7.log|
|SOC adversarial role/authorization checks|106 passed across83 declared SOC routes|http_soc_security.log|
|Canonical dashboard/runtime semantics|35 passed; request approvals remain distinct from runtime endpoints|http_dashboard_v6.log|
|Stale notebook / generic HTML error|15 /4 passed|http_notebook_conflict_v6.log, http_form_error_v7.log|
|Heavy-read quota + independent DB checks|24 passed; only new test user's quota/work scope|http_read_limit_v7.log|
|Actual HTTP load|32 authorized reads at1/5/10 independent sessions; zero errors|http_load_v9.log, http-load.json|
|Resource-scoped audit/database failures|23 passed; exact own failure triggers removed|http_core_security.log|
|Headers/source exposure/CORS|244 passed; local HTTP and explicit negative paths, not public HTTPS acceptance|http_security_policy_v7.log|
|Full backend/input/login admission|142 passed; actual shared HTML/API429, Retry-After114s observed|http_backend_v6.log|
|Anonymous executable route dispatch|189 probes; reached authentication/CSRF, no Apache404 or successful mutation|api-routing.log, api-routing.json|
|Executable router contracts|113 required /189 registered; real handlers, no duplicate registrations|api-contracts.log|

The role suite verifies exactly four student launcher controls, no interactive SOC destinations on student dashboards, direct SOC pages/APIs403, administrator root/login302 to SOC and administrator student-page403 while legitimate shared-backend administration remains allowed. SOC include-only partials return403 to both direct actors. Real HTML login ignores an injected wrong-role redirect. Notebook source survives reload; actual assigned CSV bytes, model metadata and submission decisions belong to their original actors. Cross-student ticket/dataset/notebook/model/submission reads and writes, bad CSRF, expired sessions and logout are checked.

The33 local Colab assertions verify a saved notebook exports exact literal code without fabricated output/counts, another student and anonymous caller cannot download it, SOC can inspect the original export, and imported notebooks create new student-authored records. Imported rich outputs/execution counts are discarded; malformed/oversized/unsupported input, forged CSRF and unauthorized import are rejected. Live execution returns503/unavailable and foreign ownership403. Provider diagnostics remain SOC-only and do not expose secrets to the student. These are real application operations, **not a claim that Google executed code**.

The257-check workflow independently queries30 actual MySQL persistence results after HTTP operations, including assignments, immutable dataset versions, genuine private checksums, literal notebook cells, artifact metadata, submissions/review actor and ticket/notification state. It also verifies perfect manual metrics remain USER_REPORTED/untrusted, missing quality evidence is NOT_EVALUATED and administrative deployment approval creates no endpoint.

## Actual MySQL/domain and recovery checks

|Suite|Executed result|Evidence|
|---|---|---|
|Training contracts|44 passed; generated transaction rows rolled back|training_integration.log|
|Dataset lifecycle / notebook-workspace|27 /31 passed; genuine request files and transaction cleanup|dataset_lifecycle.log, workspace_integration.log|
|Model/notebook integrity|23 passed; original counts restored|model_integrity.log|
|Scenario lifecycle/revision/audit|29 passed; test transaction rolled back|scenario_contract.log|
|Pagination / provenance / shared-owner scope|84 passed on actual MySQL|pagination_collections.log|
|Concurrent transaction/idempotency behavior|29 passed; uniquely tagged test work retained in separate prepared tree|backend_concurrency.log|
|Dashboard SQL/render/rollback|50 passed on separate metrics database|dashboard_metrics.log|
|Encrypted combined backup/restore|77 passed; new source/restored test schemas/files/configuration retained, exact fingerprints and restricted-account denials verified|recovery.log|

File-writing suites use a saved testing configuration and prepared private storage marker. Performance fixtures run before retained concurrency work on the separately named `vostok_range_v6_20261101_v10_perf_test`; metrics use their own newly named `_metrics_test`. The concurrency suite intentionally retains only its own newly tagged work; test databases are not reset. The recovery suite proves combined DB/file/configuration restoration and refusal boundaries on new test targets; a77-assertion pass is not evidence of a deployed recurring/off-site/PITR service.

## Performance measurements and limits

Actual isolated MySQL fixtures contain10/50/100/500 student records and ten related work records per student. Two warmups and seven measured runs use native PDO. Performance-created rows roll back, verified by before/after table counts. There are no genuine model artifact files and no training, Google runtime or inference benchmark; unavailable fixture artifact paths are explicitly identified as invalid metadata-only test fixtures.

|Students|Models|Unbounded baseline bytes / median|Bounded API bytes / median|Compact UI bytes / median|
|---|---:|---|---|---|
|10|100|755,967B /6.620ms|755,967B /8.237ms|43,075B /2.522ms|
|50|500|3,783,971B /10.185ms|756,861B /8.348ms|43,861B /2.613ms|
|100|1000|7,570,894B /32.261ms|757,243B /24.510ms|44,143B /15.810ms|
|500|5000|37,884,471B /269.771ms|757,801B /71.597ms|44,701B /63.871ms|

At500 students/5,000 models, compact UI transient peak growth is181,528bytes and the bounded count/window path uses two SQL queries. Full EXPLAIN, raw timings, SQL round-trip counts and error rates are retained in performance-10/50/100/500.json and corresponding logs. Recorded local acceptance thresholds are critical bounded repository median<500ms, model API payload<2MiB, compact UI<128KiB and transient growth<16MiB. The representative bounded cases meet these budgets. Not every unbounded baseline does; that is why it is retained as the comparator rather than production code.

Actual HTTP bursts use1/5/10 independent authenticated sessions of one authorized student, two bounded reads per session. Observed p95 values are **25.832 /40.091 /48.130ms**, zero unexpected errors, below the documented local2500ms budget. These32 requests do not simulate500 simultaneous students, sustained traffic, maximum-upload throughput or a Google provider quota. Provider API latency and billing capacity are **NOT MEASURED** because no project/authorization is configured.

## Browser evidence

Actual IAB interaction is recorded in browser-colab.json and browser-soc.json. Student portal shows exactly four student headings and no SOC links. The existing ML Workbench provides visible .ipynb export/import controls; a real download/import/reload preserves literal source, while the run control remains disabled. SOC Dashboard is the administrator landing and workspace inspection shows provider availability with no student navigation. Browser application console errors recorded in browser-soc.json:0.

Responsive observations at1440/1280/768/390px retain the same shell/style and visible export/import controls. Recorded body/scroll widths1425/1265/753/375px fit those viewports, respectively. The wider initial1716px portal/workbench view also fits (scroll1701px). These are observed application layouts, not an assertion that every unsupported browser/device was certified. A browser driver initially concatenated a relative URL incorrectly; reopening the known correct href succeeded and was classified as a driver issue, not an application API404.

## Corrected driver/setup failures and intentional denials

Earlier attempts are retained, not concealed or turned into successful execution evidence:

- New role driver initially sent uppercase CODE, correctly rejected422; it now sends the documented lower-case code plus expected_version. No application validation was weakened.
- Existing test expiration helper accepted only IT-% identities and refused canonical STUDENT_TEST. Its test-only query was narrowly extended to that exact identifier and STUDENT role; CLI/loopback/testing/_test guards remain. Partial explicit test work remains in the isolated schema.
- Central SOC's injected-audit-failure probe initially used the DML-only CLI identity and correctly failed when trying to create its resource-scoped test trigger. The suite was rerun with a separate operator identity for that test CLI only; HTTP continued using its saved DML-only runtime account. No HTTP DDL grant was added. The final398-check run passed, and scoped temporary triggers were removed in cleanup.
- The first routing-driver invocation omitted required --base/--output flags and exited before requests. The corrected189-probe run passed.
- Wrong CSRF/role/ownership/media type, invalid import, disabled execution and quota exhaustion are expected negative outcomes. Full backend142 observed actual429/Retry-After114seconds. No rate bucket was reset; any following login waits for natural expiry.

## Colab/evaluation/deployment acceptance that remains blocked

The user selected local build/testing without a Google Cloud project. Read-only Colab preflight reports GOOGLE_COLAB_ENTERPRISE, NOT_CONFIGURED, PREPARED_NOT_LIVE_VERIFIED, can_execute=false, supports_verified_cancellation=false, dataset_transfer_enabled=false, trusted_evaluation_enabled=false and inference_enabled=false. Code exchange is supported, but no Google API credential, billed runtime, dataset transfer or provider execution was used.

Offline35/62 contracts and local33 HTTP checks cannot prove Google authentication/eligibility, actual runtime resource isolation, quotas, cancellation/cleanup or result retrieval. These provider-backed tests are **BLOCKED**, not passed/skipped-success. The researched Enterprise API does not document notebookExecutionJobs:cancel; no such endpoint or guaranteed delete-to-cancel behavior is fabricated. A real provider-backed activation needs reviewed separate student identities/network/storage/template policy, explicit data-transfer authorization, billing/quota acceptance, actual success/failure/output and bounded cancellation/cleanup evidence. [Official research and acceptance checklist](V10_COLAB_RESEARCH.md).

Model quality remains NOT_EVALUATED without independently trusted evidence; imported/manual metrics are not promoted. Deployment requests/decisions are not running endpoints. No arbitrary Python host fallback, Google cookie scraping or unofficial Colab automation was enabled. Public runtime/HTTPS/operations/security and production acceptance are outside these local suite results.

## Reproduction and release limits

Pure checks include PHP colab_contract_v10, google_auth_v10, system_access_v10, security_unit/security_policy/env_isolation; Node range_client_security/frontend_async; Python package_policy/test_storage_guard_v9/http_test_target_security; and the pinned asset build/check. Their offline nature is explicit above.

Live checks require running Apache/MySQL, independent saved APP_ENV=testing configuration, a newly named `_test` schema, separate cookie/storage and private exact-DB credential mapping outside source/webroot. Run prepare_storage.php before file suites in an empty private test tree; never pass environment-only overrides from main. The central failure-injection suite needs a separate test CLI operator while the web process remains DML-only. The failed-login suite runs last and deliberately exercises429. No fixture import or reset is required.

This report records executed code/tests and the isolated installation. Final read-only main-preservation.json verifies zero training changes, unchanged administrator password/configuration and52 original private files. The original18 audit rows remain; one genuine localhost login made the current audit total19 and updated login/auth-rate metadata before isolated tests. Final archive/extraction/staging hashes are recorded separately in release-package-verification.json and the external archive manifests; packaging unit tests are not substituted for those results.


## Clean extracted release acceptance

Candidate `vostokpribor-ai-v10-candidate-20261101.zip` contained295 source files. CRC and every extracted file hash passed. New database `vostok_range_v10_20261101_release_b_test` applied eight migrations and the verifier confirmed exactly one hashed administrator/mandatory rotation and zero every other table before HTTP. A distinct exact-schema DML runtime account passed actual grant validation; DDL and main-database reads were denied. The administrator rotated its initial password through the real API. From the extracted source, **208 fresh-account role/workflow checks**, **33 Colab code-exchange checks** and **257 cross-system/30 independent SQL checks** passed. The earlier205 role count was a reuse run; the fresh208 run includes mandatory initial student rotation checks. All code/data remains isolated. Final ZIP/extraction equivalence and hashes are external in release-package-verification.json. No Google provider execution occurred.

The final document contract count is35: the extra schema check verifies unique required nbformat4.5 cell IDs, in addition to identity-map and base64-body bounds. Browser tests establish manual code persistence; they do not establish authenticated acceptance by the Google service.
