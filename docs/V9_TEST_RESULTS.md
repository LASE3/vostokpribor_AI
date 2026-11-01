# V9 executed test results

Observed 2026-11-01 on Windows11/XAMPP, native PDO/MariaDB. These are suite assertion counts, not a count of distinct product features; repeated regression scopes overlap. Logs and JSON evidence are protected under `verification/v9-20261101/` and supplied separately from the source ZIP.

## Executed checks

| Suite | Observed result | Evidence |
|---|---|---|
| PHP / JavaScript syntax | 197PHP +20JS/CJS files; zero errors | syntax-final.json |
| Shipped Python AST parsing | 30files; zero errors; no target import/execution or bytecode writes | python-syntax-final.json |
| Security / policy / Env | 49 /89 /8 passed | security-unit.log, security-policy.log, env-isolation.log |
| Client transport / async UI | 23 /67 passed (deterministic mocks, not HTTP evidence) | frontend-client.log, frontend-async.log |
| Production assets / packaging policy | 41 /31 passed | production-assets.log, package-policy.log |
| Source auditor / infrastructure tool | 15 /6 passed | source-auditor-tests.log, infrastructure-tests.log |
| Test target guard | 13 unit +24 actual legacy-script mismatch refusals | http-target-guard.log, http-target-negative-final.json |
| File storage isolation guard | 10 passed; file-writing suites refuse environment-only overrides | test-storage-guard.log |
| Actual failed PDO handshake redaction | 5 passed | database-connection.log |
| API contracts | 113 required /183 registered; no duplicate/missing handlers | api-contracts-final.log |
| Actual anonymous Apache routing | 183 routes reach authentication/CSRF; no Apache404 or successful writes | api-http-routing-final.json |
| Collection/provenance/ownership | 84 passed on real isolated MySQL, rollback | pagination_collections-final.log |
| Training / dataset / workspace / artifact integrity | 44 /27 /31 /23 passed | corresponding *-final.log |
| Scenario contract / transaction concurrency | 29 /29 passed | scenario_contract-final.log, backend_concurrency-final.log |
| Dashboard semantics | 50 passed | dashboard_metrics-final.log |
| Combined encrypted recovery | 77 passed; new isolated source/restored databases, files/configuration included | recovery-final.log |
| Main snapshot recovery + HTTP startup | PASS, matching29 tables/52 private files; restricted runtime; local measured1.852s | recovery-rto-http.json |
| Central SOC real HTTP/HTML | 398 passed | http_central_soc-final.log |
| Supplementary real HTTP | 244 passed | http_soc_extra-final.log |
| HTTP independent SQL workflow | 132 passed /30 proof rows | http_database_proof_v7-final.log |
| V9 workflow + independent SQL | 257 passed /30 proof rows | http_workflow_v9-final.log, database-http-proof.json |
| Actual HTTP pagination | 75 passed;26 explicit scenarios and26 explicit student accounts in test DB, retained | http-pagination.log, http-pagination.json |
| System entries / canonical dashboards | 144 /35 passed | http_system_entry_v7-final.log, http_dashboard_v6-final.log |
| Request validation / stale notebook / safe form failure | 98 /15 /4 passed | respective *-final.log |
| SOC adversarial / core failure handling | 104 across81 SOC routes /23 passed | http_soc_security-final.log, http_core_security-final.log |
| Backend validation/admission | 142 passed including real shared login429; separate128 run omits final login exhaustion to allow following suites | http_backend_v6-full-final.log / http_backend_v6-final.log |
| Heavy-read admission | 24 passed, independent SQL quota/work-count checks | http_read_limit_v7-final.log |
| HTTP headers/exposure/CORS | 244 passed; no production hosting certification | http_security_policy_v7-final.log |
| Empty student pages | 25 passed; GET navigation creates no work records | http_empty_pages-final.log |
| Actual concurrent HTTP reads | 32 requests at1/5/10 independent sessions; zero unexpected errors | http-load.json |
| Main preservation | All non-migration row hashes, original52 private files and .env match encrypted pre-migration backup | main-final-counts.json |

File-writing PHP suites were rerun from `C:\Users\nijim\.codex\tmp\vostok-v9-unit-final-20261101\vostokpribor_AI`, with its own saved test .env, storage identity and `vostok_range_v6_20261101_v9final_perf_test`. They were not finally accepted from a main-checkout environment override. Rollback suites retain original rows; concurrency intentionally retains uniquely named work and a real contract file in that isolated tree.

The original testing-storage gap and its correction are documented in `test-storage-isolation-repair.json`: one newly created, checksum/reference-verified test artifact was relocated from main to the matching isolated legacy test tree. Every original private file remained identical; no original upload was deleted. Main remains one administrator and zero training records. Its18 existing audit and5 existing rate records were preserved, not presented as demo fixtures or erased to manufacture an empty verifier result. A genuinely new installation had zero such operational rows before HTTP actions.

Initial test-driver issues were resolved without resetting data: a missing explicit TEST_BASE_URL caused a preflight refusal; login suites started during an intentional120-second lockout were rerun after natural expiry; the first V9 execution request omitted its required code_to_execute and correctly received422. The corrected valid request receives503/unavailable and creates no job. Uniquely named partially created test work was retained. The final full142 backend run records actual shared login429 and Retry-After118seconds; a separate128 run deliberately avoids exhausting login before subsequent suites.

## Performance scope and thresholds

Actual SQL fixtures contain10/50/100/500 students and ten related work records per student. All fixture rows roll back. Tests execute two warmups and seven measured repository runs on24 logical processors; observed host memory was approximately34.2GB. This is metadata/query performance, not model training, a sustained500-user load or a public capacity guarantee.

| Students | Saved models | Unbounded model bytes / median | Bounded API bytes / median | Compact UI bytes / median |
|---|---:|---|---|---|
|10|100|755,967 /7.115ms|755,967 /7.349ms|43,075 /1.965ms|
|50|500|3,783,971 /10.428ms|756,861 /7.990ms|43,861 /2.605ms|
|100|1,000|7,570,894 /44.188ms|757,243 /26.375ms|44,143 /19.899ms|
|500|5,000|37,884,471 /282.105ms|757,801 /83.271ms|44,701 /75.981ms|

At500 students, compact UI transient peak growth was181,528bytes and ticket list median7.934ms. Paged collection reads use two SQL round trips (count + window), not one query per displayed record. Local fixture acceptance budgets: critical bounded repository median<500ms, representative model API payload<2MiB, compact UI payload<128KiB and transient growth<16MiB. Measured cases met these budgets; they are not maximum-input or production guarantees. EXPLAIN and per-query measurements are in performance-final-10/50/100/500.json.

HTTP bursts use separate authenticated sessions of one authorized student, two bounded reads each. At1/5/10 sessions, observed p95 was67.305/43.517/50.904ms, below the documented local2500ms budget. They do not simulate500 simultaneous cadets or an execution/inference provider.

## Browser evidence

Actual IAB checks verified five launch links landing on Dashboard, desktop shell/card layout, a settled390px viewport without horizontal application overflow, all ten scenario editor steps, saved literal objective/description/dataset links after reload, a later catalog page, later-page student/scenario selections retained during paging, real ticket creation, export of28 records including hidden catalog pages, import/reload, six lifecycle transitions and duplicate persistence. Independent SQL corroborates browser-saved metadata and assignment. See browser-*.json and the companion PNGs.

Application console errors:0. Three error messages originated from the installed Grammarly browser extension; they are retained/classified in browser-console.json, not reported as a completely empty browser console. During the final257-check workflow plus25 empty-page run, new Apache log bytes contained zero fatal/warning/parse/uncaught entries; the four new lines were expected protected-path denials. Historical unrelated logs were not exported.

## Audit scope and blocked acceptance steps

The final recursive audit inventoried1,160 PHP/JS/MJS/CJS/SQL/Python files:150 active application,871 dependency,39 development tool,28 generated artifact,8 migration and64 test files. Zero unreadable/link gaps, encoding errors or operational blocking findings. The complete190 contextual occurrences remain in source-audit-current.json with path/line/rule/classification. Fourteen browser-storage and sixteen random-telemetry-pattern occurrences are outside active application code. The three active benign occurrences are a deliverable editor control identifier, explicit unavailable-state copy and a comment referencing removed mock behavior. Old fixture identities remain only in contextual non-application sources. This pattern audit is not an authorization proof or penetration-test certificate.

Offline history inspection covered1,029 reachable blob/commit objects across20 commits: no tracked .env paths or matching well-known key formats; eight historical bcrypt fixture hashes remain. History was not rewritten. Git history/data dumps are excluded from source ZIP. `npm audit --json` reported zero known vulnerabilities in the installed pinned build dependency tree; this does not clear the old PHP/Apache/MariaDB host.

The104-step acceptance ledger maps each applicable step to installation, actual HTTP/SQL, browser, logs and preservation evidence. Steps47–50,58–62 and66–69 are **BLOCKED** advanced execution/evaluation/serving actions. Their disabled/unavailable alternatives were verified. Missing services are never counted as successful execution, quality validation or deployment.

## Reproduction

Final clean-package staging repeated the acceptance on a new tree extracted from `vostokpribor-ai-v9-stage-20261101b.zip` (274 source files, CRC and every hash verified), with database `vostok_range_v9_20261101_release_b_test`. Fresh verifier confirmed eight migrations, exactly one hashed local administrator with mandatory rotation and zero every other table before HTTP. A new exact-schema DML-only account was verified; CREATE TABLE and main-database access were denied. Actual CSRF/login/password rotation succeeded, then **257 workflow/30 independent SQL proof rows and25 empty-page checks passed again from the extracted code**. Logs: release-stage-fresh-install/verifier/workflow/empty-pages, release-stage-grants/startup.json. Final release documentation-only changes and archive extraction/hash equivalence are recorded in release-package-verification.json. All test records remain in isolated schemas.

Pure checks can run in source: PHP security_unit/security_policy/env_isolation, Node range_client_security/frontend_async, Python package_policy/source_audit_v9/infrastructure_preflight_v9/test_storage_guard_v9/http_test_target_security, and npm test:assets. Live tests require running XAMPP, APP_ENV=testing, a new `_test` schema, separate storage/cookie and outside-webroot credentials keyed by that exact database. Legacy test naming restrictions are retained; do not reset an existing database to satisfy them.

For file-writing PHP suites first extract a code-only source tree into a separate test directory, configure a saved testing .env matching the selected test DB and empty private payload directories, then run `php tests/prepare_storage.php`. The marker is specific to its absolute tree/database and is omitted from production ZIPs. Process environment overrides alone are deliberately refused. Run performance before suites that retain work, or choose another newly named performance database. HTTP target preflight checks exact URL and actual test cookie before credentials; TEST_CREDENTIALS_FILE must remain outside source/webroot. Never point these suites at main or a user installation.
