# Version 7 verified engineering report

Verification window: 2026-10-31–2026-11-01, Asia/Amman. Source `C:/xampp/htdocs/vostokpribor_AI`, branch **main**, baseline **38674d5**, checkpoint tag **codex/v7-baseline-20261031**. Plain PHP/PDO/MySQL and approved branding/palette/shared shell are retained. **Final production verdict: NOT READY.**

Evidence links are protected local files or are restored by extracting the separate evidence ZIP alongside source. Generated evidence is excluded from the source ZIP and direct HTTP access. No passwords, historical export rows or private upload bytes belong in this report/release.

## A. Initial source audit — VERIFIED COMPLETE within recorded scope

Before source edits:43 security,23 client,67 async,30 packaging,113 required contracts/183 registered routes and398 real central HTTP/HTML checks passed. [Baseline](verification/v7-20261031/baseline-tests.json). Five API modules/shared services/native PDO/transactions and one SOC Dashboard retained; no Laravel, duplicate API layer, unsafe runner or recreated fixtures.

Final recursive scan:1,130 PHP/JS/Python/SQL/CJS sources, including dependencies/tests/private/retained/audit material;170 operational sources. Thirteen operational pattern matches are legitimate editor identifiers, unavailable-state copy, migration backfill or audit/packaging rules. Zero unclassified business localStorage/random telemetry/known demo identities. [Every match/classification](verification/v7-20261031/operational-source-scan.json), [inventory](verification/v7-20261031/operational-source-inventory.json). Pattern/manual inspection is not proof against arbitrary unknown flaws.

## B. Actual database connection — VERIFIED COMPLETE

CLI-only `bin/database_diagnostics.php` loads actual Env/Database classes, uses native PDO/read-only transaction, and reports metadata/counts without row values or credentials. Connection is measured, not inferred from an export. [Diagnostic](verification/v7-20261031/database-live-readonly.json).

## C. Actual live database name — VERIFIED COMPLETE

**vostok_range_20261026_fresh**, DB_HOST127.0.0.1, DB_PORT3306, DB_USERroot, DB_CHARSETutf8mb4, APP_ENVlocal; MariaDB10.4.32. Password withheld; `.env` byte-identical. Connection collation utf8mb4_general_ci; application tables utf8mb4_unicode_ci; migrations bookkeeping utf8mb4_general_ci. Actual phpMyAdmin database breadcrumb/29 tables independently match PHP's selected database; no claim about another preexisting user tab. [Browser observation](verification/v7-20261031/phpmyadmin-browser-selection.json).

## D. Live schema versus migrations — VERIFIED COMPLETE

Exact metadata match to a newly created schema actually migrated001–007:29InnoDBtables,299columns,140indexentries,129constraints,66FK-columnrows,15checkclauses. Types/nullability/defaults/PK/unique/index/FK actions/enums/JSON checks compared. No missing/incompatible live definition. [Database audit](verification/v7-20261031/database-audit.md).

Historical `database/vostokpribor_ai.sql` parsed as text only, never imported:28tables; dataset_versions absent;31missing current columns (12 in missing table), five differing definitions,17missing indexes/nine missing FKs/one obsolete redundant index. Includes session_version/current_version_id/revoked_at/request_key gaps. [Exact differences](verification/v7-20261031/historical-schema-comparison.json). It is not the selected live database.

## E. Migration status and preservation — VERIFIED COMPLETE

All seven migrations recorded and definitions independently match. No live DDL/reset/password reset/DROP/TRUNCATE/history deletion/import needed. Fresh/repeated migrations run on newly named test schemas. [79 real DB/migration/restore checks](verification/v7-20261031/database-audit.md).

Original work-table counts/content fingerprints, schema/migrations/user count,52private files and `.env` preserved. Main operational audit count changed15→18/rate rows4→5 during the window; users' content fingerprint also changed. Live sign-in/admission history is not frozen and was not reset to manufacture equality. Mutating suites use isolated testing configurations. [Precise preservation proof/limits](verification/v7-20261031/preservation-proof.json).

## F. Real database read/write proof — VERIFIED COMPLETE for non-execution workflow

132 HTTP/independent SQL assertions produce30 rows with system, endpoint/method/table/INSERT/SELECT/UPDATE/ARCHIVE, expected result, actual HTTP/SQL result, authorization/status. Hashed student creation; scenario metadata/admin actor; ticket requirements/deadline/grants/progress; real CSV/private checksum/version/grant/preview/download/processed lineage; explicit notebook/literal-source SHA256; experiment/model/actual artifact; submission/review/reviewer/decimal grade/notification/audit; new-session student approval and retained source. Archive preserves records; no hard-delete endpoint invented. [Proof matrix](verification/v7-20261031/database-http-proof.json), [log](verification/v7-20261031/final-database-http.log).

Actual mysqldump/mysql restore: all29table counts/content fingerprints and literal Unicode/source identical in a distinct new `_test` target. FK1452/duplicate1062/transaction commit/rollback/savepoint/update/revocation verified. Both schemas retained, no existing reset. Backup stays outside webroot/release; evidence contains only size/hash/proof. This proves current-schema DB tooling, not complete production file-plus-DB disaster recovery.

## G. Five API modules and reported404 — VERIFIED COMPLETE within tested contract

All183registered routes exercised over authenticated HTTP;182positive, execution-job POST intentionally503 because isolation is unavailable. No uncovered routes. [Coverage](verification/v7-20261031/final-route-coverage.json). Static lineage records457methodnodes/57frontendconsumers/26formblocks with service/repository/query/auth/validation/transaction/audit citations; these are source references, not executed SQL traces. [Lineage](verification/v7-20261031/api-lineage.json).

Late main verification reproduced the screenshot's Apache404: actual working `.htaccess` had escaped literal asterisks in REST/old-dashboard patterns. Normal routes did not match. Correct regex quantifiers restored without weakening access rules. All183anonymous requests on the real main prefix reach authentication/CSRF, not Apache404; no credentials/valid mutation token/successful writes. Both localhost and127.0.0.1 representative routes checked. [Main routing](verification/v7-20261031/main-all-api-routing.json), [cause](verification/v7-20261031/main-api-routing-proof.json). Intentional missing-object/unsupported-route404 remains.

All system launches/quick-nav/folder defaults now open Dashboard. ML Workbench adds an ownership-scoped dashboard using existing components, real totals/bounded recent lists and unavailable execution; GET creates no work. Named feature links remain.144 authenticated entry/resource/API checks pass, including SOC student denial. [Entry proof](verification/v7-20261031/system-dashboard-entries.json).

## H. Authentication — VERIFIED COMPLETE for tested controls

Actual login/logout/rotation/regeneration/expiry/generation revocation/disabled/reset sessions and cookies tested.142 backend HTTP checks include full five-failure/shared HTML429 and logout after mutation exhaustion. Harness moved final legitimate sign-out/login checks before deliberately exhausting login admission; no quota reset or weakened policy. Exact login CSRF matching, no substring exemption/public registration. admin/admin remains localhost initialization only.

## I. Authorization — VERIFIED COMPLETE for exercised objects

All81SOC routes reject students;104 adversarial SOC assertions plus398central/244supplementary workflows cover anonymous/direct URLs, owner/foreign reads/writes/references for tickets, datasets/processed, notebooks, experiments/runs, models/versions, validations, requests, submissions/notifications. Administrator remains actor; original student owns artifacts. Folder defaults retain role gates.

## J. Twenty security control groups

|#|Control|Status and evidence|
|---|---|---|
|1|Secrets/config isolation|PARTIALLY IMPLEMENTED: protected dotenv/overrides/masked audit; old sensitive history needs coordinated remediation.|
|2|Production environment|VERIFIED COMPLETE: typed/ranged config; debug/root/empty-secret/insecure transport fail closed503 before session/DB.|
|3|Administrative access|VERIFIED COMPLETE: server gates/104negative checks across81SOC routes.|
|4|Authentication/logout/rotation|VERIFIED COMPLETE:142backend HTTP plus central/revoked/expired coverage.|
|5|Object ownership/references|VERIFIED COMPLETE for recorded positive/foreign read/write/reference cases; no impersonation.|
|6|Form/JSON/ID validation|VERIFIED COMPLETE for98request cases: media type/depth/UTF8/null/type/range/date/IDs. Nested multipart already rejects422; static TypeError suspicion not confirmed.|
|7|XSS/code preservation|VERIFIED COMPLETE for recorded payloads: encoded requirements/feedback, safe DOM text, literal code hashes/browser save-reload.|
|8|CSRF|VERIFIED COMPLETE: unsafe API/HTML including login; malformed tokens/exact routes/no public registration.|
|9|SQL/constraints/transactions|VERIFIED COMPLETE: native PDO, actualFK/unique/savepoint/rollback, exact schema comparison.|
|10|Sessions/cookies|VERIFIED COMPLETE within loopback fixture scope: Secure/HttpOnly/SameSite, expiry/generation invalidation. Public trusted TLS unverified.|
|11|Password hashing/change/reset|VERIFIED COMPLETE: password_hash/verify, strong issued secrets, rotation; passwords/hashes absent API output.|
|12|File security/integrity|VERIFIED COMPLETE for tested formats/cases: private bytes/checksum/grant/ownership. No deserialization/evaluation claim.|
|13|Concurrency/duplicates|PARTIALLY IMPLEMENTED:29coordinated processes plus idempotency/rollback suites; not every simultaneous upload/load workload verified.|
|14|Rate/abuse controls|VERIFIED COMPLETE for configured login/write/upload/selected-heavy-read policies;24real read checks/alias recovery. Upstream anonymous/DDoS still deployment work.|
|15|CORS/origins|VERIFIED COMPLETE: same origin/no wildcard credential grants; Origin checks supplement CSRF.|
|16|Headers/cache|VERIFIED COMPLETE for compatible enforced policy:89pure/275HTTP. CSP retains unsafe-inline; not a strict nonce policy.|
|17|Debug/errors/logging|VERIFIED COMPLETE:49unit/five real PDO/four real HTML-MySQL failures; generic500/safe diagnostics.|
|18|Exposed files/source|VERIFIED COMPLETE on tested Apache: private/env/Git/dump/log/build/verification denied; PHP PATH_INFO rejected; assets200.|
|19|Dependencies/unused assets|PARTIALLY IMPLEMENTED: pinned local Tailwind/41checks/npm audit0; runtime security/support BLOCK production.|
|20|Git/release|PARTIALLY IMPLEMENTED overall: dump untracked/preserved/ignore rules/clean source ZIP; old sensitive history remains.|

[Policy/scope](verification/v7-20261031/security-policy-results.md), [275HTTP](verification/v7-20261031/security-http-final.log), [read admission](verification/v7-20261031/read-admission-http.log).

## K. Confirmed defects/vulnerabilities

- Production debug/malformed config accepted; missing compatible CSP/referrer/permissions/HSTS policy.
- Public verification logs/screenshots and incomplete backup/development-file protection.
- Raw PDO/controller/audit logging; catch-all HTML paths could publish storage messages or misclassify500 as422/403; API production500 needed normalization.
- Unrestricted local DB root and outdated runtime/server support; not silently changed.
- Missing expensive GET admission; equivalent mixed-case/slash/PATH_INFO routes needed consistent policy.
- IDs silently truncated12junk→12; JSON media type used case-sensitive substring matching.
- Old tests checked a testing CLI but defaulted HTTP writes to main.
- Runtime Tailwind browser compiler; replaced with same pinned local output.
- Actual main rewrite corruption caused404; ML lacked requested Dashboard and launches were inconsistent.

## L. Repairs — VERIFIED COMPLETE within recorded regression scope

Shared SecurityPolicy/typed Env/fail-closed production; compatible CSP/local CSS; protected webroot; exact legacy GET-only405; safe API/form failures/logging; strict relational IDs preserving string jobs; exact case-insensitive JSON; selected-heavy-read admission across API/legacy/HTML aliases; guarded tests; corrected Apache/default dashboards; removed frontend DB-name disclosure/unused deployment-request count. Existing service/contracts/design/data retained.

Disclosed harness corrections: PDO attribute returns integer0; old integrity assertion wrongly blocked administrative PENDING requests; notification assertion ignored assignment history; legacy status/label expectations obsolete; first browser comparison targeted an inactive tab and was discarded/repeated with native-width assertions. Attempt logs remain identifiable, not reported as product fixes or successful results.

## M. Files modified

- `.env.example`
- `.gitignore`
- `.htaccess`
- `AI Operations Center (AI SOC)/WorkspaceConfiguration.php`
- `AI Operations Center (AI SOC)/_workspace_admin.php`
- `API_REFERENCE.md`
- `README.md`
- `VERIFIED_COMPLETED_FEATURES.md`
- `api/exchange.php`
- `api/models.php`
- `api/status.php`
- `app/Controllers/DatasetController.php`
- `app/Controllers/ScenarioController.php`
- `app/Controllers/SocTrainingController.php`
- `app/Controllers/SubmissionController.php`
- `app/Controllers/TicketController.php`
- `app/Controllers/UserController.php`
- `app/Core/Database.php`
- `app/Core/Env.php`
- `app/Core/Logger.php`
- `app/Core/RateLimiter.php`
- `app/Core/Request.php`
- `app/Core/Response.php`
- `app/Core/Router.php`
- `app/Views/DataPage.php`
- `app/Views/Layout/AppLayout.php`
- `app/Views/ProjectPage.php`
- `app/Views/range_context.php`
- `app/bootstrap.php`
- `change-password.php`
- `config/navigation.php`
- `index.php`
- `login.php`
- `logout.php`
- `tests/dashboard_metrics.php`
- `tests/db_probe.php`
- `tests/http_backend_v6.py`
- `tests/http_empty_pages.py`
- `tests/http_readonly_security.py`
- `tests/http_workflow.py`
- `tests/model_integrity.php`
- `tests/scenario_contract.php`
- `tests/security_unit.php`

## N. Files created

- `ML Workbench/Dashboard.php`
- `app/Core/Diagnostic.php`
- `app/Core/SecurityPolicy.php`
- `assets/css/TAILWIND_LICENSE.txt`
- `assets/css/tailwind-portal.css`
- `assets/css/tailwind-shared.css`
- `bin/build_assets.cjs`
- `bin/database_diagnostics.php`
- `build/ASSETS.md`
- `build/tailwind.content.cjs`
- `build/tailwind.input.css`
- `build/tailwind.portal.cjs`
- `build/tailwind.shared.cjs`
- `package-lock.json`
- `package.json`
- `tests/database_connection_security.php`
- `tests/database_proof_probe_v7.php`
- `tests/database_verification.php`
- `tests/html_error_probe_v7.php`
- `tests/http_api_routing_v7.py`
- `tests/http_database_proof_v7.py`
- `tests/http_form_error_v7.py`
- `tests/http_read_limit_v7.py`
- `tests/http_request_security_v7.py`
- `tests/http_security_policy_v7.py`
- `tests/http_system_entry_v7.py`
- `tests/http_test_target.py`
- `tests/http_test_target_security.py`
- `tests/production_assets.cjs`
- `tests/security_policy.php`
- `tests/security_read_probe.php`

## O. Files removed

- `AI Operations Center (AI SOC)/js/tailwind.config.js` — verified inactive theme configuration.
- `AI Project Management/js/tailwind.config.js` — verified inactive theme configuration.
- `Data Center/js/tailwind.config.js` — verified inactive theme configuration.
- `ML Workbench/js/tailwind.config.js` — verified inactive theme configuration.
- `Model Registry & Deployment/js/tailwind.config.js` — verified inactive theme configuration.
- `database/vostokpribor_ai.sql` — removed from Git tracking only; original file remains locally.

[Exact hashes/line deltas](verification/v7-20261031/final-change-manifest.json), [byte-exact nonsensitive source diff](verification/v7-20261031/final-source.patch). Historical SQL deletion diff deliberately omitted: including it would repackage old records/hashes. Its untracking/local preservation is recorded instead.

## P. Regression results

|Suite|Observed result|
|---|---|
|Public PHP/JS/CJS/Python syntax|240PASS; private user code not executed/linted; SQL verified by actual migrations|
|API contracts/HTTP coverage|113required/183registered;183exercised/182positive, intended503execution boundary|
|Central/supplementary HTTP|398/244PASS|
|Backend admission/validation HTTP|142PASS including full failed-login policy|
|SOC negative/core security|104/23PASS|
|Canonical dashboard/system entry/resources|35/144PASS|
|Request validation/independentSQL workflow|98/132PASS|
|HTML stale editor/storage failure|15/4PASS|
|Fresh legacy workflow/empty pages/denied HTTP|181/25/24PASS on guarded isolated configurations|
|Policy HTTP/heavy-read admission|275/24PASS; fixtures do not prove trusted public TLS|
|Security/policy/Env unit|49/89/8PASS|
|Client/deferred async|23/67PASS; deterministic mocks separately identified|
|Native training/dataset/workspace|44/27/31PASS, rollback|
|Integrity/scenario|23/29PASS after stale test expectations repaired|
|Coordinated concurrency/metrics/volume|29/50/32PASS|
|DB restore/rejectedPDO/target guards|79/5/13unit+6actual guard checks PASS|
|Production assets/package policy|41/30PASS; locked build audit0known vulnerabilities|

[Pure checks](verification/v7-20261031/final-pure-results.json), [HTTP logs](verification/v7-20261031/final-http-phase-b.json), [syntax](verification/v7-20261031/final-syntax-inventory.json). Mutating DB tests refuse main/local configuration.

## Q. End-to-end/browser — VERIFIED COMPLETE for supported non-execution workflow

Admin creates student/scenario/ticket/real data/grants; student processed upload/notebook/experiment/model/file/submission; SOC inspection/review; new student session reads persisted approval/feedback/ticket state. Source/file checksums independently match SQL. Actual browser login/launches/scenario cards/notifications/notebook Save→reload verified: notebook60 Version3 exact source, Run disabled. [Browser source proof](verification/v7-20261031/notebook-browser-observed.json), [API observation](verification/v7-20261031/browser-api-observation.json).

Five Dashboards plus portal measured1920/1440/1366/1024/768/390/320:42native cases, zero body overflow. Existing portal header overflow fixed only at affected widths; logo/colors/desktop shell retained. [Measurements](verification/v7-20261031/dashboard-responsive-final.json). Other engines/physical devices IMPLEMENTED BUT NOT VERIFIED. Font-loading baseline observations are not misrepresented as pixel-identical comparisons.

## R. Performance — PARTIALLY IMPLEMENTED

Native PDO300students/3000related rows, seven-sample medians/EXPLAIN, all rolled back. SOC notebooks0.718ms; jobs0.508ms/44KB; models0.697ms/50KB. Complete legacy admin model list remains22,740,471bytes/127.695ms at3000models.16unbounded collection methods remain; no silent truncation/cache/index change hides this. Compatible pagination/load tests still required. [SQL/EXPLAIN/measurements](verification/v7-20261031/final-performance.json), [inventory](verification/v7-20261031/unbounded-query-inventory.json).

## S. Dependencies — PARTIALLY IMPLEMENTED / BLOCKED runtime

Observed PHP8.2.12/Apache2.4.58/MariaDB10.4.32. Official PHP October2026 critical RCE/Windows rebuild advisories and Apache Windows fixes postdate these patches; MariaDB10.4 is outside community maintenance. Bootstrap cannot fix pre-request vulnerabilities. No silent service upgrade. Rehearse vendor-patched runtimes/maintained DB with backups/restore/full suite before exposure. [PHP](https://www.php.net/archive/2026.php), [Apache](https://httpd.apache.org/security/vulnerabilities_24.html), [MariaDB](https://mariadb.org/about/#maintenance-policy).

Runtime CDN replaced with local pinned3.4.17 output, same actual compiler/active themes. Lockfile/integrity/license/build/check recipe retained; node_modules omitted. Five inactive/unreferenced alternate configs removed after reference analysis. PHP serves compiled CSS without Node. Google fonts/icons remain external dependencies. [Dependency review](verification/v7-20261031/dependency-review.md).

## T. Git secrets — PARTIALLY IMPLEMENTED remediation

Masked all reachable branches/tags/blobs and working files, including ignored config/private/log/test/dependencies; locations/types/counts only. Eight sensitive old SQL bcrypt hashes/records remain locally/history. No high-confidence provider/private-key token found. Synthetic invalid-URL userinfo, vendor CSS password-selector and reflected policy literals manually classified by file hashes. [Masked findings](verification/v7-20261031/data-secret-audit.json).

Dump removed from current Git tracking only, original retained; env/dumps/private/backup/log/generated evidence ignored. History not rewritten. Privately review affected real credentials, plan rotation/revocation/session invalidation and validated cutover, secure backups, then coordinate repository backup/history remediation. Do not publish existing history as a clean release.

## U. Packaging — VERIFIED COMPLETE after recorded archive checks

Existing packager builds outside htdocs, excludes env/history/dumps/private/new uploads/sandbox/cache/node_modules/logs/scratch/evidence; retains active PHP/APIs/seven migrations/design/local CSS/build recipe/examples/docs/tests/storage controls. It deletes no original. CRC/file/archive hashes/independent extraction/extracted contract-security-async checks recorded in release-packaging.log/external manifests. Separate evidence archive contains reviewed logs/screenshots, no old SQL rows/credential/private upload payloads. Source ZIP is not a backup/deployment.

## V. Remaining limitations

|Status|Requirement|
|---|---|
|BLOCKED|Patched supported production PHP/Apache/DB runtime and compatibility/security retest.|
|BLOCKED|Restricted runtime/migration identities/verified MySQL bind/firewall. Local root has ALL PRIVILEGES on*.*; listener[::]:3306, external reachability untested. Env guard does not prove actual grants.|
|BLOCKED|Verified isolated runner/trusted evaluator/inference provider absent; execution/quality/runtime claims disabled/unavailable.|
|PARTIALLY IMPLEMENTED|Legacy pagination/upstream abuse controls/strict nonce CSP/font self-hosting/complete parallel upload-load testing/production file-plus-DB recovery rehearsal.|
|PARTIALLY IMPLEMENTED|Sensitive Git history needs coordinated credential review/rotation/cleanup; local data/history preserved.|
|IMPLEMENTED BUT NOT VERIFIED|Trusted public HTTPS/proxies/other webservers/browsers/devices/upgraded runtime/production deployment.|
|NOT IMPLEMENTED|Dataset SQL execution, explicitly unavailable.|

## W. Final verdict — NOT READY

Reported API404 and dashboard-entry requirements repaired/verified. Supported persisted local five-system workflows pass recorded acceptance/security/regression scope. Critical runtime/DB/network/infrastructure/operational requirements remain unresolved, so production is **NOT READY**. No public deployment, unsafe execution, destructive reset, existing-account password reset or fabricated success is claimed.
