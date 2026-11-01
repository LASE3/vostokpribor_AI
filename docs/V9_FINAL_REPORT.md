# V9 final engineering report

Verification date: 2026-11-01. Source: `C:/xampp/htdocs/vostokpribor_AI`, branch **main**, baseline **309d92e**, checkpoint **codex/v9-baseline-20261101**. Plain PHP/PDO/MySQL and the approved five-system layout are retained. Evidence is in the separate protected V9 evidence archive; it is deliberately excluded from the source ZIP.

## A. Executive Summary

The persisted non-execution training platform is verified for a controlled localhost demonstration. Real Apache/MySQL/SQL/browser tests cover student creation, scenario/ticket editing, actual file uploads and assignments, notebook saving, model metadata/artifacts, submission/review and authorized feedback. API routing and all five Dashboard entry points pass. Collections now have authorized totals, bounded pages and navigation; scenario import/export and all six lifecycle transitions persist in MySQL.

The original installation still has exactly one administrator, zero student/work records and unchanged credentials/uploads. Its18 legitimate audit and5 rate-limit rows were retained. Migration008 was applied only after encrypted backup and isolated restore verification. Isolated execution, trusted quality evaluation and inference serving remain **BLOCKED and disabled**. Public production deployment is not accepted.

## B. Original Version 8 State

The supplied instruction calls the baseline Version8; the actual checked-out commit was309d92e, a V7 stabilization commit, with a clean main tree. No V8 commit was invented. Baseline had29 tables, seven migrations, one administrator and zero training records. Initial API/core/SQL tests passed; confirmed remaining defects concerned truncated collections, scenario paging/import/export/lifecycle controls, explicit provenance and release/recovery evidence. See [baseline](V9_BASELINE_REPORT.md).

## C. Bugs Found

Confirmed D01–D14 are recorded in [defect inventory](V9_DEFECT_INVENTORY.md). They include silent list truncation/unbounded related reads, missing exact totals/page controls, unstable student ordering, duplicate administrator ticket rows and wrong shared-ticket identity, immutable-version scope gaps in dossiers, missing run provenance, incomplete combined recovery proof, misleading source-audit classification, a corrupt host privilege-table index and two test-target/storage-isolation gaps.

## D. Bugs Fixed

Shared validated pagination and explicit count queries now serve actual authorized collections. Selection persists across lookup pages. SOC uses server filters, actual options/summary counts, guarded full export and explicit import writes. Scenario revision/status transitions are consistent with the server. Migration008 records optional authorized dataset-version lineage and USER_REPORTED provenance without promoting history. Encrypted recovery restores database/private files/configuration together. Test suites verify their actual HTTP target and independent private storage before mutation. The system-table index was repaired after physical/logical backup; existing privilege rows were unchanged.

## E. Files Modified

See the exact path inventory [V9_FILE_CHANGES.md](V9_FILE_CHANGES.md) and companion unified patch against309d92e. Changes are concentrated in repositories/services/controllers, existing data panels/SOC handlers, pinned compiled CSS, test guards, packaging and documentation. Colors, navigation, icons and shared layout are preserved.

## F. Files Created

New files include Pagination.php, migration008, encrypted backup/restore library and CLIs, infrastructure preflight, collection/provenance/HTTP/recovery/storage-guard tests and the V9 reports. The file inventory distinguishes new files from tracked modifications. No second backend/database abstraction or framework was added.

## G. Files Removed

No original source file, table, student work or original upload was removed. Release packaging omits local configuration, Git history, old data dumps, private payloads, caches/logs/evidence/test output while retaining storage directories and access controls. One exactly identified newly generated test-owned artifact was moved to its own isolated tree;52 original file fingerprints remain unchanged.

## H. Database Verification

Actual main schema is `vostok_range_20261026_fresh`:29 tables, eight applied migrations, one ADMIN and zero students/scenarios/tickets/assignments/datasets/notebooks/cells/experiments/models/validations/deployment requests/submissions/notifications. Its18 audit and5 rate rows are preserved operational history. All non-migration row fingerprints, .env and52 original private files agree with the encrypted pre-update snapshot. No data reset/import or password reset was performed.

Fresh and restored test schemas migrated successfully. Real MySQL collection tests verify205-record collections, correct last pages, duplicate grants, shared-student identity, authorized immutable versions and cross-ticket rejection. Sixty-seven FK checks found zero orphans or duplicate business identifiers in staging. [Database/recovery proof](V9_DATABASE_VERIFICATION.md).

## I. API Verification

Executable router inventory:183 registered routes and113 required contracts. Actual Apache probes verify route dispatch/auth/CSRF rather than Apache404. All five modules share one backend. Central SOC398, supplementary244, system-entry144, request-security98 and adversarial104 checks passed; expected ownership/object404 remains intentional. Source API collection responses retain their data array plus pagination metadata; historical user-list shape remains compatible. [API reference](../API_REFERENCE.md).

## J. AI SOC Administration

Actual HTTP/SQL/browser evidence verifies secure student creation/rotation/deactivation, original student workspace inspection, ten-step scenario persistence/reload, CRUD/lifecycle/import/export/duplicate, ticket requirements/deadline and later-page student/scenario assignment, real master uploads/version grants, model annotations, submission decisions and audit actors. Dashboard counts derive from actual rows; unavailable worker/evaluator/inference cards do not claim health. Scenario export includes records outside the visible page.

## K. Student Workflows

Authorized students see only their assigned work/version grants, download original private bytes, upload processed files with lineage, explicitly create/save/reload notebooks, record manually reported experiments, register metadata and optionally real artifacts, request integrity/administrative review and submit. Reviews and ticket state persist and appear after a new student login. Unrelated-student access and referenced-object misuse are rejected. Empty new-student pages remain empty without GET-created work.

## L. Python Execution

**BLOCKED.** No reviewed independent sandbox identity, filesystem/network/resource controls, cancellation/cleanup isolation or adversarial execution acceptance exists on this host. HTTP returns503 with an explanatory unavailable state; worker exits78 without executing code. No environment setting enables a host subprocess runner. Queue/cancellation semantics are tested without claiming a successful execution result.

## M. Model Evaluation

**Trusted quality evaluation BLOCKED.** Uploaded-file integrity/checksum verification is implemented. Student JSON and perfect manual metrics are USER_REPORTED and untrusted. Missing evaluator evidence yields NOT_EVALUATED with no quality score. Historical provenance is UNKNOWN; migration008 performs no quality backfill. A safe trusted evaluator and measured acceptance remain required.

## N. Model Deployment

**Inference serving BLOCKED.** Metadata/artifact and administrative deployment request decisions persist. Approval does not create an endpoint. Runtime inventories are explicitly unavailable/empty and do not expose fabricated URLs, inference traces or latency. No isolated provider/status adapter is installed or accepted.

## O. Security Audit

Authentication, session generation/revocation, mandatory password rotation, exact login CSRF handling, same-origin writes, ownership, upload validation/private downloads, safe errors, source exposure protection, rate admission and transactional audit are tested. Staging uses distinct DML-only accounts with exact schema grants; operator/DDL/source access is denied. Main's existing credentials were preserved and require an operator-reviewed public cutover.

The recursive six-category source scan covers1,160 files:150 active,871 dependencies,39 tools,28 generated,8 migrations and64 tests. Zero unreadable/encoding/blocking gaps. Every190 contextual finding is retained; the three active matches are benign editor identifier/unavailable copy/comment. All14 browser-storage and16 random-telemetry-pattern matches are outside active code. Offline Git scan found no tracked .env or matching well-known key patterns across1,029 objects/20 commits; eight historical bcrypt fixture hashes remain and history is excluded from ZIP. npm audit found zero known build-dependency vulnerabilities. These scoped scans do not certify absence of unknown flaws. [Security report](V9_SECURITY_REPORT.md).

## P. Performance

Actual rollback-only MySQL fixtures tested10/50/100/500 students, ten work records per student, two warmups/seven measured runs. At500 students/5,000 models, unbounded baseline was37,884,471bytes/282.105ms median; bounded API757,801bytes/83.271ms; compact UI44,701bytes/75.981ms. Compact transient peak growth181,528bytes; ticket median7.934ms. Count/window uses two SQL queries and relevant indexes appear in EXPLAIN.

Actual HTTP bursts with1/5/10 independent authenticated sessions observed p95 of67.305/43.517/50.904ms and zero errors. These meet recorded localhost budgets, not sustained500-concurrent-user or training/inference capacity. [Full measurements and budgets](V9_TEST_RESULTS.md).

## Q. Automated Testing

Final executed suites:49 security unit,89 policy,8 environment,23 client,67 asynchronous UI,31 packaging,41 asset,15 source-auditor,6 infrastructure-tool,10 storage-guard,13 HTTP-target unit,24 actual target refusals,5 PDO error-redaction,84 pagination/provenance,44 training,27 dataset,31 workspace,23 artifact integrity,29 scenario,29 concurrency,50 dashboard and77 encrypted recovery assertions passed. Syntax checks covered197 PHP,20 JS/CJS and30 shipped Python files with zero errors.

Actual legacy HTTP suites passed398 central SOC,244 supplementary,23 core audit failure,132 independent SQL workflow,144 entry/resource,35 dashboard semantics,98 request security,15 notebook conflict,4 safe HTML error,24 heavy-read SQL,142 full backend and104 adversarial checks. Header/exposure policy244 and anonymous183-route dispatch probes passed. Full backend intentionally exhausted the test login bucket and observed429/Retry-After; no quota was reset. Counts describe their recorded suites, not unique functionality or coverage percentage.

## R. End-to-End Testing

V9 actual HTTP/SQL workflow passed257 checks with30 independently queried persistence proofs;25 empty-student HTML pages,75 HTTP pagination and32 HTTP-load checks passed. Tests use APP_ENV=testing and independently named `_test` databases, cookies, credentials and private files. The104-step ledger has91 applicable VERIFIED steps and13 advanced steps BLOCKED (47–50,58–62,66–69); disabled alternatives are verified separately. None is counted as successful execution/evaluation/serving.

One earlier env-only file-test gap was corrected transparently: a single test artifact with zero main DB references was moved to its matching test tree. New guards and all four positive file-suite reruns pass. No original main payload changed. Test-driver refusals, malformed test input and intentional rate waits are retained in evidence rather than represented as application successes. Final acceptance Apache log delta has zero fatal/warning/parse/uncaught entries; four expected protected-path denials remain.

## S. Browser Testing

Actual IAB interaction verified all five Dashboard launches, ten editor steps, later-page selections retained, literal saved metadata after reload, actual ticket creation,28-record export including unseen pages, import/reload, six lifecycle transitions and duplicate persistence. Settled390px mobile viewport had no application horizontal overflow; desktop1280px layout retained. Application console errors0; three Grammarly extension errors classified separately. Screenshots show an isolated test database, never seeded main.

## T. Production Packaging

The source packager verifies CRC and every included file hash, retains eight migrations/layout/storage controls and excludes environment, history, dumps, private payloads, test marker, logs/caches/evidence. No existing source/upload is deleted. A separate source manifest gives the archive SHA256 and exact included/excluded inventory. Clean extraction and a newly named restricted staging installation are verified from the release candidate; final package proof and hashes are recorded in the companion evidence. Packaging acceptance does not establish public hosting/security readiness.

## U. Backups

AES-256 combined snapshot includes database,52 private files and configuration. Real recovery passed77 checks and actual main snapshot restorations to two isolated new schemas. All rows/files/config hashes match before forward migration. The measured small localhost restore→migration→HTTP readiness was1.852seconds; it is not a production SLA. Archive and key remain separately protected outside webroot and are excluded from source/evidence releases. RPO is the last manual snapshot: recurring/off-site/PITR and operator key recovery still require acceptance. [Recovery details](V9_DATABASE_VERIFICATION.md).

## V. Remaining Issues

1. Reviewed isolated runner, trusted evaluator and inference provider are unavailable; all remain disabled.
2. Restricted dataset SQL execution is NOT IMPLEMENTED; the UI truthfully reports unavailable.
3. Existing PHP/Apache patch levels and unsupported MariaDB10.4 need a rehearsed operator upgrade; main runtime root credentials must be replaced through a reviewed cutover.
4. No public HTTPS deployment, operational monitoring, recurring/off-site backup acceptance, sustained representative public load or production sign-off has been performed.
5. Local snapshot timings/scoped scans do not prove production capacity or comprehensive penetration-test clearance. Staging fixtures stay in isolated `_test` schemas; main is not reset to conceal legitimate audit history.

## W. Final Readiness Assessment

Equal weighting of the user's numbered acceptance requirements, with no partial credit:

| Assessment | Defined denominator | Accepted | Meaning |
|---|---|---:|---|
| CORE TRAINING PLATFORM | Criteria1–30 |30/30 =100%|Recorded controlled-local non-execution workflow and layout acceptance; not a security warranty.|
| COMPLETE AI ENGINEERING RANGE | Criteria1–36 |30/36 =83.3%|The additional six execution/evaluation/serving requirements31–36 are all BLOCKED,0/6 accepted.|
| PUBLIC PRODUCTION DEPLOYMENT | Additional criteria37–48 |5/12 =41.7%|Only42 packaging,43 tested backups,44 isolated staging,46 enabled-feature regression and47 documentation have scoped evidence. Runtime/credentials/HTTPS/full security clearance/public load/sign-off remain unaccepted.|

Production's percentage uses its additional gate set, rather than inflating readiness with already accepted local features. Dependencies are hard gates regardless of arithmetic. A passing source package or local regression does not satisfy the missing security/infrastructure approvals.

## X. Final Verdict

**READY FOR CONTROLLED LOCAL DEMONSTRATION.** Core database/API/workflow, browser, local performance, backup/restore, clean source package and isolated staging gates have evidence. Advanced infrastructure and public runtime/security/operations/acceptance gates remain blocked. This release is not accepted for public production deployment or unrestricted internal use.
