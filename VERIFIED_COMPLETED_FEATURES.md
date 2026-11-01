# Verified completed features — V9

Verified2026-11-01 on **main**, source `C:/xampp/htdocs/vostokpribor_AI`, comparison baseline **309d92e**, checkpoint `codex/v9-baseline-20261101`. Plain PHP/PDO/MySQL and the existing five-system design remain. **Verdict: READY FOR CONTROLLED LOCAL DEMONSTRATION. Public production deployment is not accepted.**

The comprehensive required A–X assessment is [V9_FINAL_REPORT.md](docs/V9_FINAL_REPORT.md). Exact affected paths/purposes are in [V9_FILE_CHANGES.md](docs/V9_FILE_CHANGES.md); the separate evidence release contains the full unified patch against309d92e. The prior V7 report remains recoverable from that baseline commit; it is not presented as a test of this release.

## Verified behavior

- All183 registered API routes dispatch through real Apache; the reported missing API rewrite is fixed. Expected unauthorized/missing-object403/404 responses are preserved. All five launch links/system defaults open their Dashboard first.
- One central SOC manages actual students, ten-step scenarios, tickets/requirements/deadlines, real master files/version assignments, student workspace inspection, model administration and submission decisions. Scenario edit/reload/import/export/duplicate and all six lifecycle transitions persist in MySQL. Export includes records outside the visible page; browser-local storage is not business persistence.
- Students see scoped work, download genuine assigned bytes, upload processed files with immutable lineage, explicitly save/reload notebook source, record user-reported experiments, register metadata/real optional artifacts and submit. Administrator review updates persisted ticket state and fresh student sessions see feedback. Cross-student reads/writes and SYS-05 access are denied.
- Authorized collections have bounded windows, actual full totals, stable ordering and page controls. Related lists/lookups retain selections and do not hide later records. Dashboard aggregates are scoped SQL totals rather than page lengths.
- Migration008 adds immutable run dataset-version references and explicit provenance/indexes. Manual perfect metrics remain USER_REPORTED and untrusted; historical rows default UNKNOWN.
- CSRF, exact login policy, password rotation, session invalidation, origins, private upload integrity/download scope, transactional audit, concurrency and rate admission have actual negative tests. Test guards verify saved `_test` identity, HTTP cookie/URL and separate file storage before writes.

## Main installation preservation

Actual database `vostok_range_20261026_fresh`:29 tables, eight migrations, exactly one ADMIN, **zero students and every training/work record**. The existing18 audit and5 rate-limit records are legitimate history and were preserved. All non-migration row fingerprints, `.env`, administrator password and52 original private files match the encrypted pre-update backup. No reset/import, user upload deletion or automatic fixture creation occurred.

The fresh-install verifier separately passed on a newly named test database before HTTP: exactly one hashed local admin with must_change_password and zero all other tables, including audit. It is intentionally not used to erase an installation after real actions. Main was never used for mutating suites. One temporary test-owned concurrency artifact created by an earlier env-only filesystem test gap was verified to have zero main references and moved to its own test tree; new storage guards and all positive reruns pass. [Full database/preservation/recovery evidence](docs/V9_DATABASE_VERIFICATION.md).

## Executed evidence

[Complete test table, commands and limitations](docs/V9_TEST_RESULTS.md), protected evidence root `verification/v9-20261101/` in the companion evidence ZIP:

| Verification | Observed result |
|---|---|
|Actual V9 HTTP + independent SQL workflow|257 checks,30 SQL persistence proofs; repeated from clean extracted source with restricted DML runtime|
|Fresh/empty installation and navigation|Eight migrations; one admin/zero others;25 empty student pages without GET-created work|
|Central/supplementary SOC, system entries|398 /244 /144 checks passed|
|HTTP request/adversarial/full backend|98 /104 /142 passed; intentional429 and Retry-After observed|
|Collection/provenance and actual HTTP pagination|84 MySQL /75 HTTP assertions passed|
|Security unit/policy/client/async|49 /89 /23 /67 passed|
|Domain DB suites|44 training,27 dataset,31 workspace,23 model integrity,29 scenario,29 concurrency,50 dashboards passed|
|Target/storage guards|13 target-unit +24 actual refusal runs,10 storage assertions passed; four file suites rerun separately|
|Encrypted combined recovery|77 assertions; actual main restored twice with exact DB/files/config fingerprints|
|Source/packaging/assets/syntax|1,160-file classified audit,31 packaging,41 assets;197PHP/20JS/30Python syntax clean|
|Acceptance ledger|91 applicable steps VERIFIED;13 advanced steps BLOCKED with disabled alternatives verified|
|Real browser|Five Dashboard launches, all editor steps, saved reloads, later-page assignment, export/import, duplicate and six lifecycle transitions; settled390px layout fits|
|Real MySQL performance|10/50/100/500 students; at5,000models bounded API757,801bytes/83.271ms, compact UI44,701bytes/75.981ms median|

The source audit retains every190 contextual match with path/classification: zero operational blockers/coverage gaps. Three active matches are legitimate identifier/unavailable copy/comment. All14 storage and16 random-telemetry-pattern matches are outside active code. Git history scan/npm dependency results and limitations are recorded; no history was rewritten. Browser console had zero application errors and three classified Grammarly extension errors. Acceptance log delta had zero PHP fatal/warning/parse/uncaught entries and four expected protected-path denials.

## Release and recovery

Source ZIP and external manifest: `C:/Users/nijim/.codex/artifacts/vostokpribor-ai-v9-final-20261101.zip` and same stem `.manifest.json`. Evidence ZIP: `C:/Users/nijim/.codex/artifacts/vostokpribor-ai-v9-evidence-20261101.zip`. Manifest/checksum evidence is authoritative; archive hashes are external to avoid self-referential content.

Source ZIP excludes `.env`, history, old dumps, private payloads, caches/logs/test output and the test-storage marker; preserves schema/layout/storage directories/.htaccess. It changes no original upload. Clean extraction checks CRC/every file hash and application identity to the source tested on Apache. Separate evidence includes logs,104-step ledger, occurrence inventory, source patch and screenshots; no credentials, data dumps or private upload bytes. Extract evidence beside source to follow protected evidence links; it is never a live data backup.

The combined AES-256 main backup remains separately protected outside webroot; two isolated restores matched all rows/files/config. Small local restore→HTTP measurement1.852s is not a production SLA. RPO is the last manual snapshot; no recurring/PITR/off-site service is claimed. [Installation and recovery procedure](docs/V9_DEPLOYMENT_GUIDE.md).

## Unresolved blockers

Execution, trusted model evaluation and actual inference serving are **BLOCKED and disabled**. Worker exits78; HTTP execution503; quality NOT_EVALUATED; administrative approval exposes no fabricated endpoint. Restricted dataset SQL execution is NOT IMPLEMENTED. No host subprocess fallback or environment bypass was added.

The existing PHP8.2.12/Apache2.4.58/MariaDB10.4.32 host and main operator credentials need a rehearsed upgrade/cutover; public HTTPS, operational monitoring, recurring/off-site recovery, representative sustained load and production acceptance remain unaccepted. Restricted staging grants and localhost performance are proven within their stated scope. No full production-readiness claim is made. [Architecture](docs/V9_ARCHITECTURE.md), [security](docs/V9_SECURITY_REPORT.md), [readiness gates/weights](docs/V9_FINAL_REPORT.md).
