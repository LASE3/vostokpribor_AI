# V6 backend audit and change impact baseline

Audited 2026-10-31, main source `C:/xampp/htdocs/vostokpribor_AI`. Initial source checkpoint `0b8cd08`; mandatory dashboard consolidation belongs to the lead agent and preceded all changes proposed below. No main environment file, live database, user account or uploaded file was modified by this audit.

## Inventory and executed baseline

`backend-reference-map.json` inventories 94 backend/API/migration PHP/SQL files, hashes, dependencies and 507 SQL/transaction reference lines. Controller routes use the existing five modules, shared services and repositories. Core Auth/Request/Validator/Database/RateLimiter/middleware, all controller handlers, critical write transactions and all seven migrations were inspected. SQL uses bound values; dynamic table/column/order identifiers inspected are fixed code, enumerated matches or strict identifiers. No confirmed SQL injection was found. The protected historical SQL dump was not imported or executed.

Only the existing isolated snapshot at `C:/Users/nijim/.codex/tmp/vostok-integration-main-20261030/vostokpribor_AI` ran database tests. Guard observed APP_ENV=testing, loopback DB host, database `vostok_range_20261030_main_http_test`. Its local base URL is configured in APP_URL. Credentials were read privately by the existing suite and were not printed.

| Executed suite | Actual result | Evidence |
| --- | --- | --- |
| API contracts | 113 required;183 declared; no duplicates/missing handlers | baseline-api-contracts.log |
| Pure security |40 PASS; no DB connection | baseline-security-unit.log |
| Training DB contracts |44 PASS; generated rows rolled back | baseline-training.log |
| Real HTTP audit-failure security |23 PASS; only unique test student23 created; scoped triggers removed | baseline-http-core-security.log |
| Native PDO read-only compatibility probe |3 confirmed HY093 failures, not a passing suite | baseline-native-pdo.log |

The root agent runs the complete HTTP workflow separately; concurrent mutating suites were paused while that baseline ran.

## Confirmed defects and smallest fixes planned before edits

| Files/functions | Original defect and cause | Dependencies, endpoints and pages | Small fix; regression risks and required tests |
| --- | --- | --- | --- |
| Core/RateLimiter check/hit; AuthController login; login.php | Separate SELECT and INSERT/UPDATE loses concurrent increments or raises duplicate-key500. Admission and failure recording are separate. No Retry-After; authenticated API/upload mutations have no throttle. | HTML/API login; all authenticated POST/PATCH API routes and their forms | Atomic row admission using existing rate_limits table; shared login admission and explicit configurable per-user mutation/upload buckets,429+Retry-After. Test concurrent first hit/count/admission, exact expiry, isolated HTTP429, no duplicate mutation on refusal. Risk: overly low defaults block legitimate workflow; default mutation120/min with distinct upload policy and explicit test-only bucket keys. |
| Core/Auth changePassword | Hash is verified before write transaction; concurrent reset can be overwritten. Postcommit SELECT can adopt a later reset generation. | API and HTML password rotation; UserService resets/status/session middleware | Lock current users row, check active role/generation and verify current hash inside transaction; return own generation from transaction. Test deterministic reset interleaving and rollback; preserve existing own session and revoke other sessions. |
| Services/ScenarioService updateScenario | Full merged state/history built before lock; concurrent independent edits overwrite committed fields/history. | ScenarioController aliases/SOC; ten-step builder/lifecycle/import | Lock and reread inside existing transaction before merging/validating; allow optional version precondition if needed by editor. Test independent concurrent patches retain fields/history and stale preconditions fail. Risk: lifecycle wrappers already hold lock; nested savepoints must remain valid. |
| Services/TicketService addComment | Assignment authorization occurs before write transaction, allowing comment after concurrent revocation. | Both ticket comment aliases; TicketDetails and SOC modal | Lock ticket and reauthorize in write transaction. Test reassign-before-lock denies comment, no audit/event leak. Assignment and submission operations already lock ticket first. |
| Services/ValidationService runValidation | Checks archive state outside transaction, then overwrites state to VALIDATION_PENDING after concurrent archive. | Registry/legacy validation; SOC model archive | Lock current model and recheck owner/archive/artifact before creating report/status/audit. Test archive interleaving and integrity evidence remains NOT_EVALUATED. Execution stays disabled. |
| Services/ExecutionService cancellation; related detail controllers | Conditional cancellation prevents bad state but identical simultaneous cancellation may return422. Some detail handlers catch every storage error as404. | Job details/cancel, notebook/model/validation detail APIs/SOC | Lock job, reread actual state; typed missing/access/input/storage responses without losing existing ownership403/404 policy. Test duplicate cancel one audit and real storage500 sanitization. |
| User/Ticket/Scenario services/controllers list filters; Core/Validator | Arrays reach string filters/type hints or get coerced; malformed filters can500. Validator applies numeric max to string-valued numeric text after character-length check. | All legacy/project/SOC list aliases and roster/search/builder | Validate scalar types/enums/pagination before repository access; separate string length from numeric magnitude. Test malformed array filters422 and numeric text lengths without broad response changes. |
| Repositories/UserRepository listStudents/countStudents; TicketRepository listForUser; Core/Database | Reused named :search placeholders are incompatible with native PDO; observed HY093 in all3 paths. | Student roster/search/count, ticket searches, every DB caller if native setting changes | Give each occurrence unique parameter name; only then use native prepared statements after all affected DB/HTTP tests. Token scan has one CSS :ring false positive, not SQL. Test actual search with injection-looking literal input, domain contracts and complete HTTP workflow. |

## Existing controls retained and remaining audit boundaries

Active-role/session-generation checks, mandatory password rotation, same-origin cookie sessions, exact login CSRF requirement, prepared value bindings, foreign-key ownership checks, original artifact ownership, upload verification/checksum and transactional audit failures remain enabled. Ticket assignment/submission/review use locks, idempotency and constraints. Notebook saves lock the notebook, but absent client revision preconditions mean stale editors can still overwrite source; coordinate frontend revision handling rather than claiming automatic version conflict detection already exists.

Migrations001–007 use forward schema changes and actual metadata backfill; no DROP/TRUNCATE/reset or fixture import is present in migrations. DDL rollback is not promised on MariaDB; migration recovery still requires backup/recorded migration state. No schema change is required for the planned rate-limit fixes. Broad performance-volume/EXPLAIN testing belongs to the data audit agent; this report does not claim load-test results.

All proposed edits are scoped to the above functions. No source edit began before the root agent confirmed completion of the mandatory first dashboard consolidation. Later actual results must be appended separately, not substituted for this baseline.

## Executed repairs and regression results

The root agent confirmed the mandatory dashboard consolidation before these source changes. The existing architecture and tables were retained. Native PDO is now enabled in Database after correcting the three demonstrated repeated-placeholder failures. Both the main and isolated snapshot source use the same setting; the main database was never used by these tests.

| Final executed check | Observed result | Evidence |
| --- | --- | --- |
| Native search compatibility | All 3 previously failing searches pass | native-search-fixed.log |
| Native training / dataset / workspace contracts |44 /27 /31 PASS, generated rows rolled back | final-native-training.log, final-native-dataset.log, final-native-workspace.log |
| Concurrent backend operations |29 PASS using independent native-PDO worker connections and actual parent-held MySQL locks | backend-concurrency.log |
| Real HTTP backend regression |113 PASS, including malformed filters/references422, missing objects404, stale notebook/scenario/lifecycle409, mutation/upload/login429 and Retry-After | backend-http.log |
| Final audit-failure HTTP |23 PASS; fail-closed login and reliable logout still work | final-http-core-security.log |
| Final SOC adversarial HTTP |104 PASS across all81 declared SOC routes | final-http-soc-security.log |
| Real HTML stale notebook fallback |15 PASS;409 preserves escaped entered source and old token, leaves DB unchanged, explicit GET reloads actual version | html-notebook-conflict.log |
| Pure security after native setting |40 PASS, no database connection | security-unit-final.log |

Concurrency observations include 160 retained parallel hits, exactly seven admissions at limit seven, exact expiry, refund preserving another failure, partial scenario fields/history preserved, stale editor conflict without extra history/audit, administrator password reset surviving a stale password rotation, no validation revival after archive, denied comment after reassignment, and two simultaneous cancellations producing one audit. Worker code is a guarded CLI regression harness; it never executes submitted student code.

Notebook expected_version and scenario expected_revision are optional for legacy clients. The shipped editor supplies them. Notebook comparison occurs under its existing row lock; scenario revision is SHA256 of an explicit persisted-field allowlist plus actual builder metadata, excluding author display/count/join fields. A stale supplied token produces409 CONFLICT. Legacy requests without a precondition retain their supported locking/partial-update behavior; the report does not claim conflict detection for an omitted token. No schema migration was needed.

Input fixes validate filter shapes, positive related identifiers and textual fields before coercion. Numeric-looking text is checked by string length rather than magnitude. Missing-object exceptions remain distinct from storage failures, which are500 rather than false404. Password rotation verifies the locked current hash and generation and retains exactly its own committed generation. A newly discovered CLI exception-handler defect was also corrected: an uncaught CLI exception now exits1 instead of printing an HTTP500 page and exiting0.

Rate policy: atomic fixed-window admission in the existing rate_limits table; failed login admission shared by HTML/API (five/120 seconds), all authentication requests120/60 seconds; per-user authenticated API mutation default120 and multipart upload default20 per60 seconds. API_MUTATION_LIMIT, API_UPLOAD_LIMIT and API_RATE_WINDOW_SECONDS configure the latter policies. GET startup remains read-only; normal GET requests are not seeded/throttled.429 includes Retry-After and retry_after JSON detail for API refusals. A successful login refunds only its reserved hit in the same window, preserving simultaneous failures. Audit-storage exceptions during authentication also refund admission, since they are not incorrect credentials. No generic automatic mutation retry was added.

The HTTP suite seeds/expires only its newly created student's exact mutation/upload bucket to prove refusal and recovery, verifies no notebook/processed metadata was created on refusal, and deliberately performs five real bad logins against the isolated installation. Its shared loopback login bucket is left to expire naturally; no existing rate bucket is reset to hide results. The final run observed Retry-After112 seconds. Subsequent login suites must wait for this actual boundary.

Failed harness attempts were investigated rather than counted as passes: Windows anonymous pipes did not provide the assumed nonblocking reads; the harness now reads the worker's explicit readiness/result lines. MariaDB can report a native prepared locking SELECT as Statistics before adding its waiting transaction to INNODB_TRX; the observer now recognizes that state only while the parent owns the exact target row and the active statement is FOR UPDATE. One alternate loopback source was denied by the private Apache mount; final HTTP checks use the permitted source. Final logs above contain complete successful reruns.

Scope limits retained: API admission does not claim to throttle every legacy HTML business form; those still use their existing authentication, CSRF and services. No unverified runner, evaluator or inference provider was enabled. Full final route/HTTP acceptance, browser checks and package assessment are coordinated by the root agent and must be cited separately from these focused results.

## Root final closure after the focused handoff
Authenticated legacy HTML mutations and multipart uploads now share the same per-user admission buckets as API writes, after CSRF validation. Exact POST logout routes remain available when the quota is exhausted; CSRF is still mandatory. Additional required-null fields reject422 without modifying data. The final root HTTP run passes128 assertions, including shared HTML/API429 and both quota-exhausted logout paths; the deliberately exhaustive failed-login checks remain separately recorded in backend-http.log (113 assertions). Global exception logs now retain type/location/code rather than argument-bearing traces/messages; the real CLI-file regression passes43 pure security checks. No user credential was reset.
