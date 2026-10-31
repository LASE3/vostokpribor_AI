# Version 6 engineering verification and production assessment

Verified 2026-10-31 on **main**, source `C:/xampp/htdocs/vostokpribor_AI`. Baseline 0b8cd08; local tag `codex/v6-baseline-20261031`; audit checkpoint 916b87e precedes implementation. Plain PHP/PDO, shared MySQL and the approved five-system design remain.

**VERIFIED COMPLETE:** the supported persisted non-execution workflow, one canonical SOC dashboard and the fixes/tests below. **BLOCKED:** isolated execution, trusted quality evaluation, genuine runtime deployment. **PARTIALLY IMPLEMENTED:** production readiness. This is not a production security certification.

Proof files are under `verification/v6-20261031/`, distributed separately from the clean source ZIP. Original failed harness attempts remain documented. No user database was reset, no student upload/artifact deleted, no execution restriction disabled, and no Git history rewritten.

## A. Initial audit - VERIFIED COMPLETE

[Baseline state](verification/v6-20261031/baseline-state.json), [file inventory](verification/v6-20261031/baseline-file-inventory.json), [backend dependency map](verification/v6-20261031/backend-dependency-map.json). Inventory covers 378 public files plus categorized private runtime counts without committing their contents. [Backend audit/impact plans](verification/v6-20261031/backend-audit-baseline.md), [async audit](verification/v6-20261031/async-audit-baseline.md), [database/dependency/secret audit](verification/v6-20261031/data-audit-baseline.md) identify routes, controllers, services, entities and affected views before their scoped changes.

## B. Baseline tests - VERIFIED COMPLETE

Real XAMPP central workflow400 PASS; API113 required/183 total PASS; pure security40, training44 and core HTTP23 PASS. Existing client security23 PASS. Native-PDO baseline probe deliberately exposed three incompatible repeated named-placeholder searches. Baseline logs are retained; later fixes do not replace those observations.

## C. Single SOC dashboard - VERIFIED COMPLETE

[Exact comparison](verification/v6-20261031/dashboard-baseline-comparison.diff) showed identical queries/panels and only title/navigation/pageType differences. `Dashboard.php` and `_dashboard_panels.php` remain. OperationsDashboard.php is deleted, duplicate sidebar entry removed, notification/internal test links use Dashboard. Apache redirects old bookmarks308 with query preservation; canonical authentication still applies. Initial relative redirect exposed a filesystem prefix during testing; the final exact URL regression rejects that failure. [Redirect proof](verification/v6-20261031/dashboard-redirect.log), [35 HTTP checks](verification/v6-20261031/final-http-dashboard.log).

All useful monitoring remains: student/active/recent counts, tickets/active assignments, pending and approved reviews, dataset/processed data, notebooks/experiments, models/request counts, failed persisted jobs, scenarios, recent activity/audit and measured database availability. Worker/validation/inference providers explicitly say NOT_CONFIGURED. Six existing KPI cards, subsystem cards, two-column activity, scenario table and health panels retain their design.

## D-F. Deleted, modified and created files - VERIFIED COMPLETE

One obsolete application file deleted: `AI Operations Center (AI SOC)/OperationsDashboard.php`. No user data/files removed. Existing controllers/services/repositories/client scripts were extended in place; no new framework, API module, database wrapper, business service layer or runtime dependency was introduced. Added focused concurrency/HTTP/async/dashboard/performance regressions. Exhaustive paths/hashes/line changes and exact source patch: [change manifest](verification/v6-20261031/final-change-manifest.json), [source patch](verification/v6-20261031/final-source.patch).

## G-I. Confirmed defects, repairs and regression prevention

Each row states the actual defect/root cause, targeted files, change and executed result. All are **VERIFIED COMPLETE** within the recorded scope.

| Files | Original defect / root cause | Targeted repair / actual test result |
| --- | --- | --- |
|Dashboard.php, _dashboard_panels.php, SocSystemService.php|Two implementations repeated queries; limited unfiltered student rows called active; request status could imply deployment|One service-backed dashboard; dedicated batched aggregates; clearly recent account list/status; scoped summaries; runtime inventory separate.50 fixture/render/rollback checks and35 HTTP checks PASS.|
|DeploymentService/Controller, SocWorkspaceController, registry/soc modules|GET deployment names returned administrative request rows|Runtime routes retain array shape but return[] plus NOT_CONFIGURED availability; requests stay at deployment-requests.35 HTTP checks include real nonempty request history and absent runtime inventory.|
|range-client.js|Unbounded fetch/body waiting, errors/cancellation ambiguous|Configurable bounded deadlines, cleanup, read TIMEOUT/CANCELLED vs write UNKNOWN_OUTCOME; no retries; useful429 metadata.67 deferred async and23 existing security checks PASS.|
|soc-training, SOC main, app-layout, StudentManagement inline JS|Out-of-order modal/catalog/notification responses, close could reopen stale editor|Latest-response sequences/read cancellation, close invalidation, init guards, consistent entity commits. Existing baseline races reproduced then covered in67 checks.|
|soc-workspaces, dataset-management, shared/workbench scripts|Duplicate submits, disabled Saving could remain after rejection, state could be overwritten|In-flight guards/finally restore original control state, keep draft inputs, do not retry mutations.67 checks and actual browser save/reload PASS.|
|sidebar.js; three CSS files|Delayed focus could target closed drawer; toast/modal/drawer/tooltip layers inconsistent|Cancel timer on close/resize/lifecycle; use bounded existing stacking tokens plus drawer65/tooltip55.67 tests and native drawer/Escape checks PASS.|
|responsive.css, TicketsAndScenarios toolbar classes|320px header/popover clipped; narrow scenario rows expanded to591px|Flex shrink/ellipsis keeps logo and controls; popover fits viewport; existing toolbar wraps.54 page/width cases plus before/after measurements.|
|AppLayout.php|Browser reused stale local CSS/JS after fixes|Version local asset URLs by file revision, preserve query fields/external fonts/logo and markup. Shared-shell assertions plus native browser-loaded version URLs PASS.|
|RateLimiter/AuthController/login.php, API index/bootstrap|Read-then-write buckets lost concurrent hits; HTML could bypass API mutation/upload quotas|Atomic admission/refund; shared login and per-user write/upload buckets; Retry-After.160 parallel hits/exact7 admissions tested; focused113 and final128 HTTP checks PASS. Exact POST logout remains usable after quota exhaustion with CSRF retained.|
|Auth.php|Password validated before lock could overwrite an admin reset; session might adopt later generation|Verify locked hash/generation, retain exactly own committed generation. Concurrent real-MySQL tests PASS.|
|ScenarioService/Repository, NotebookService/Repository, controllers/views/editors|Pretransaction scenario merge lost fields/history; stale editors could overwrite cells/builder|Merge under lock; supplied expected_version/expected_revision checked under lock with409; shipped UI sends tokens and retains drafts.29 concurrency,128 backend HTTP,15 real HTML conflict checks PASS.|
|TicketService, ValidationService, ExecutionService|Authorization/archive/status read before lock could admit revoked comment, revive archive or duplicate cancel failure|Locked rechecks/idempotent cancellation; concurrency tests prove denied revoked actor, no revival and one cancellation audit.29 checks PASS.|
|Database, User/Ticket repositories|Native PDO HY093 due reused named search placeholders|Distinct bound names, native prepares only after focused/domain/full HTTP verification. Three searches,44/27/31 contracts and all183 route coverage PASS.|
|Validator/services/controllers/bootstrap|Malformed arrays/null required fields could coerce or cause500; storage errors could appear404; CLI exceptions could exit0|Typed inputs/nonnullable checks, distinct missing/ownership/storage statuses, CLI exit1.128 final HTTP and43 pure checks PASS.|
|bootstrap.php|Exception traces/messages could log sensitive function arguments|Log type/location/code without arguments/messages. Real child-file sentinel regression proves no value exposure, exit1 and useful diagnostic.43 pure checks PASS. Historical server logs require private review/rotation if real credentials were captured.|
|SocWorkspaceRepository.php|SOC summaries transferred full code/log/model JSON before limiting expensive joins|Bound primary page before joins/counts; summary projections retain full detail endpoints and run inline metrics.32 regressions with300 students/3000 tickets PASS under native PDO.|

Regression logs retain failed fixture/harness attempts and corrections: metric fixtures initially omitted schema-required code fields; an array-order assertion was corrected to compare object values; Windows pipe/lock observation needed real readiness handling; a PHP inline-eval exception test was replaced with an actual CLI file; audit-tool arrow encoding and diff-context whitespace were corrected without changing product assertions. These failures are not counted as passes.

## J. API verification - VERIFIED COMPLETE

Five modules remain,113 required contracts/183 registered routes, no unnecessary duplicate routes. [Final route coverage](verification/v6-20261031/final-route-coverage.json):183 exercised,182 successful; execution submission intentionally503. Full workflow398 PASS versus baseline400 because the removed duplicate page no longer receives two redundant HTML assertions; bookmark behavior has separate35-check coverage. Supplementary244 PASS, SOC adversarial104 PASS across81 SOC routes, audit-failure23 PASS, backend128 PASS. Route existence or200 alone is not treated as persistence evidence.

Runtime API migration: GET soc/deployments, registry/deployments and deployments now mean verified runtime inventory, currently empty/unavailable. Clients reading request history must use the retained deployment-requests routes. No provider, URL, quality result or simulated execution is fabricated. The legacy raw model catalog also uses AppUrl for record links;35 HTTP checks verify the nested installation remains the target.

## K. Authentication/authorization - VERIFIED COMPLETE for tested controls

Real tests cover anonymous/student/admin, disabled/revoked/expired sessions, mandatory password rotation, CSRF, forged roles, direct URLs and cross-owner related objects. Wrong CSRF remains403. All81 SOC routes deny students. Administrator operations retain actual admin actor and original student owner. Login failure auditing cannot grant a session; audit-failed logout still clears it. No public registration or default public password is enabled.

## L. Database integrity - VERIFIED COMPLETE

Native PDO with tested bound queries. No new schema migration was required. Transaction/row-lock/idempotency tests preserve original owners, file metadata, notifications and audit consistency. Existing main local environment/private files were not replaced. All mutation suites target dedicated loopback APP_ENV=testing databases.300/3000 volume fixtures and metric fixtures roll back; exact table counts are checked. Intentional HTTP work remains in its test database for investigation.

## M. Race and stale-editor handling - VERIFIED COMPLETE for shipped clients

Read sequences/cancellation prevent older responses replacing newer state. Writes are guarded, not blindly cancelled/retried. Notebook integer version and scenario persisted-state hash preconditions prevent stale UI saves.409 leaves literal source/builder input intact; real HTML test includes closing-textarea/script text without execution or DB overwrite. Legacy clients may omit optional preconditions for compatibility; conflict protection cannot be claimed for such omitted tokens. Update external editors to send them.

## N. Timeout, retry and admission policy - VERIFIED COMPLETE

Default client15s; multipart120s; per-call timeoutMs or browser VOSTOK_API_TIMEOUT_MS/VOSTOK_UPLOAD_TIMEOUT_MS overrides, max600s. Deadline covers response-body parsing too. Read cancellation/timeout is explicit; interrupted/network-failed writes report unknown outcome, requiring checking persisted state before another deliberate attempt. No automatic retries, including429. Retry-After is exposed as bounded metadata.

Atomic login failure admission:5 per120s shared HTML/API; general authentication120 per60s. Authenticated API and legacy HTML writes share per-user120 mutations and20 multipart uploads per60s, configurable through API_MUTATION_LIMIT/API_UPLOAD_LIMIT/API_RATE_WINDOW_SECONDS. Quotas apply after CSRF; exact POST sign-out remains available. GET requests remain read-only and are not covered by an application-wide read limiter; public deployment needs upstream abuse protection. Focused tests prime only their own random test user's buckets and prove no partial writes; failed-login tests let the shared test window expire naturally.

## O. SQL injection, XSS and secrets - VERIFIED COMPLETE for recorded review

Prepared values and strict internal identifier allowlists remain. Native search probes include injection-looking text as a value. Malformed filters/arrays/nulls fail422. Existing recursive dossier escaping was confirmed; an initial truncated-read suspicion was withdrawn. PHP output and JS text/escaping preserve malicious-looking text as text; literal notebook code round-trips unchanged.

Masked audit examined working tree and reachable Git history without printing secret values. Eight old SQL password hashes remain in the protected tracked legacy dump/history, excluded from releases. No high-confidence provider token/private-key pattern was found. This is a pattern/manual audit, not proof that no secret could exist. Review exposed historical identities/logs privately; rotate affected real credentials, restrict backups, and plan any history rewriting separately rather than deleting data automatically. [Masked findings and rotation plan](verification/v6-20261031/data-audit-baseline.md).

## P. Performance - PARTIALLY IMPLEMENTED

Native same-fixture seven-sample medians/EXPLAIN: SOC jobs roughly 54ms/12.05MB to0.864ms/44KB; runs178ms to6.7ms with inline metrics retained; models0.922ms/756KB to1.238ms/50KB (bytes improve; latency was not universally faster). Experiment slice overhead is documented.32 pagination/filter/owner/count/full-detail regressions pass. [Measurements/SQL/EXPLAIN](verification/v6-20261031/data-performance-native.json).

Legacy complete administrator model listing still reaches roughly 22.7MB/219ms at3000 models. No silent truncation or caching was introduced to disguise that contract. Bounded/paginated migration of legacy clients remains a scale limitation before broad production rollout. No unsupported index migration was added.

## Q. Migration safety - VERIFIED COMPLETE within existing seven migrations

Migrations001-007 unchanged, forward tracked and re-run without fixtures. Fresh dedicated metrics/performance schemas verified one initial hashed administrator with mandatory rotation and zero work/audit/notification rows after transaction rollback. No DROP/TRUNCATE/password reset/foreign-key disable operation was run on the real installation. [Pristine proof](verification/v6-20261031/final-pristine.log), [migration repeat](verification/v6-20261031/migration-repeat.log). Database/runtime upgrades require a fresh backup and rehearsal on an isolated copy; no claim of reversing applied DDL is made.

## R. Responsive regression - VERIFIED COMPLETE for recorded Chromium viewport scope

[Browser observations](verification/v6-20261031/browser-verification.md), [exact measurements](verification/v6-20261031/responsive-observations.json). Native requested widths 1920/1440/1366/1024/768/390/320; canonical dashboard and persisted notebook all7, four SOC screens all7, student ticket/upload/registry at representative desktop/tablet/phone sizes. Before/after clipping and toolbar evidence retained. Existing table horizontal scrolling is intentional. Official logo, palette, Header/Sidebar structure preserved; only measured responsive/layer corrections and local asset revision handling applied. [Design checks](verification/v6-20261031/final-design-protection.json). Physical devices and other browser engines are IMPLEMENTED BUT NOT VERIFIED.

## S. Packaging - VERIFIED COMPLETE after recorded final build

Existing production-source packager is used. Source ZIP excludes.env/.git, private payloads, dumps, local credentials, scratch/cache/log/test output; preserves source/tests/seven migrations/storage directories/access controls. No original file is deleted by packaging. Final archive and clean-extraction checks are in release-packaging.log and the external manifest. Evidence ships separately with sanitized copies; exact source patch and hashes accompany it. No raw XAMPP-folder ZIP is delivered.

## T. End-to-end acceptance - VERIFIED COMPLETE within non-execution scope

Full398 real HTTP/HTML assertions cover admin creation/rotation/scenario/ticket/real file/version/grants, student preview/download/processed upload/notebook save/experiment/model artifact/NOT_EVALUATED validation/request/submission, SOC inspection/revision/approval and student persisted feedback/status. Cross-owner denial/reassignment/revocation/archive/cancellation/audit/counts are verified. Supplementary244 covers remaining positive aliases/reject branches/downloads;128 backend regressions and104 negative SOC assertions pass. Browser notebook save survives reload and direct SQL inspection. No Python code/inference ran.

## U-V. Remaining problems and deployment blockers

| Status | Boundary |
| --- | --- |
|BLOCKED|No verified isolated runner, evaluator or inference provider. Execution disabled; missing quality results NOT_EVALUATED/INCOMPLETE; requests never imply a deployed endpoint.|
|BLOCKED|Installed PHP8.2.12/Apache2.4.58 need security patching; MariaDB10.4 is out of community maintenance. Upgrade/back up/retest runtime before public exposure.|
|BLOCKED|Preserved unpinned Tailwind Play CDN is development-only; production needs a pinned local asset build and visual regression. External fonts/icons remain dependencies.|
|PARTIALLY IMPLEMENTED|Legacy unbounded list scale, upstream read/anonymous abuse protection, deployment-specific HTTPS/restricted DB roles/backup restore/security review.|
|IMPLEMENTED BUT NOT VERIFIED|Other webservers, physical mobile devices, alternate browser engines, upgraded production runtime.|
|NOT IMPLEMENTED|Dataset SQL execution; Query Workspace remains explicitly unavailable.|

Authoritative runtime guidance: [PHP supported versions](https://www.php.net/supported-versions.php), [MariaDB maintenance](https://mariadb.org/about/#maintenance-policy), [Apache advisories](https://httpd.apache.org/security/vulnerabilities_24.html), [Tailwind Play CDN](https://tailwindcss.com/docs/installation/play-cdn). Installed versions were observed locally; system services were not silently replaced.

## W. Final verdict - PARTIALLY IMPLEMENTED production readiness

The supported local persisted workflows and confirmed V6 repairs have executed evidence. This release is **not fully production-ready**. Resolve the explicit runtime/asset/infrastructure/scale/deployment controls above and repeat critical acceptance/security/migration/restore tests in the actual target environment. Source and evidence archives are locally verified; no public deployment or Git-history rewrite was performed.
