# V6 data, dependency, secrets and packaging audit

Audit date: 2026-10-31. Baseline: `0b8cd08`. Main checkout: `C:/xampp/htdocs/vostokpribor_AI`. No application database, environment file, private upload or Git history has been modified by this audit.

## Change plan before repository edits

| Candidate | Dependency and behavior constraints | Evidence and regression plan | Risk |
|---|---|---|---|
| `SocWorkspaceRepository::list` summary projection | Shared student tables; SOC service checks active administrator. Preserve IDs, ownership, filters, counts and ordering; full detail endpoints retain stored code/JSON/logs. | Measure 100/200-row payloads with actual synthetic long code/JSON in a new isolated testing DB; assert full detail unchanged and summary metadata consistent. | Medium: existing clients could consume JSON from lists. Audit every caller before removing any field. |
| Dataset/model list query/index changes | Retain complete student lists, dataset version pinning, active assignment checks and owner restrictions. No default pagination that hides work. | EXPLAIN and median timings at 300 students/3000 tickets; change only if measurable. | Medium. No index migration without measured benefit and explicit coordination. |
| Native PDO preparation | Repeated named parameters in Ticket/User search need separate bindings. | Parent/training agent owns fixes and complete test runs. | Coordinated; outside this agent's ownership. |
| SOC system aggregate batching | Current summary executes full dashboard and many sequential COUNTs. | Parent owns metric fixtures and exact current/deployed semantics. | Coordinated; outside this agent's ownership. |

## Repository inventory

Reviewed all 13 repositories: Dataset, Deployment, Execution, Experiment, Model, Notebook, Scenario, SocWorkspace, Submission, Ticket, TrainingRead, User and Validation. Single-query correlated counts in SQL use existing foreign-key indexes; they are not PHP per-row queries. Detail methods that fetch one entity then its children use a fixed query count. Most legacy lists are unbounded; student ownership conditions must be preserved. Administrative workspace lists already cap at 200 (default 100), but transfer full MEDIUMTEXT/JSON through `SELECT *`. Ticket/User searches reuse named placeholders; training agent owns compatibility repair before native PDO.

All seven migration files were inspected. Migrations 004-007 extend/backfill existing data without dropping tables, truncating, or recreating demo records. Dataset versions preserve actual legacy paths/checksums and assignment pinning. New indexes already cover active ticket assignments and active dataset assignments. New performance DB `vostok_range_v6_20261031_perf_test` was created once via the guarded CLI installer with APP_ENV=testing, loopback host and process-only DB_NAME override. No live DB was copied; all seven migrations applied. See `data-perf-install.log`.

## Performance experiment (planned before measurements)

Use a transaction on the dedicated new `*_perf_test` DB only. Generate 300 random test student identifiers, 3000 tickets and active assignments, 300 immutable dataset/version metadata records and 3000 grants, 3000 notebooks plus cells, runs and models; selected long code/report/JSON fields represent realistic persisted work. No model or dataset artifact availability will be claimed. Measure repository methods with two warmups and seven timed runs, recording median wall time, row count, JSON byte size and EXPLAIN on their exact SQL. Roll back all synthetic rows and compare every table's count with its pre-test count. No DDL occurs inside the fixture transaction. Candidate projections are measured independently before selecting a source change.

## Runtime/dependency baseline

Observed local runtime: PHP 8.2.12; MariaDB 10.4.32; Apache 2.4.58; Node 26.13.0; Python 3.14.7. Python test packages installed locally: requests 2.34.2, urllib3 2.7.0, certifi 2026.5.20, idna 3.18, charset-normalizer 3.4.7. No Composer/package/requirements manifest, lockfile, vendor directory or node_modules tree exists in this application. Production PHP uses the local autoloader and PDO; disabled worker uses Python stdlib only. Test Python requests is currently an unpinned development dependency.

The three rendered document heads (`index.php`, `login.php`, `app/Views/Layout/AppLayout.php`) request unversioned `https://cdn.tailwindcss.com` and external Google Fonts/Material Symbols. CSS generation therefore depends on an unpinned third party script. Retain approved appearance; future production build should pin a compatible Tailwind version and compile the existing class set with visual regression checks. Do not blindly migrate to Tailwind 4.

Official sources checked on audit date:

- [PHP supported versions](https://www.php.net/supported-versions.php): PHP 8.2 is security-fixes-only until 2026-12-31. The installed 2023 patch level is outdated; supported branch status does not mean that 8.2.12 has current security fixes.
- [MariaDB maintenance policy](https://mariadb.org/about/#maintenance-policy): MariaDB 10.4 community maintenance ended 2024-06-18. Upgrade/back up and test the full migrations/HTTP suite on a maintained branch before internet deployment.
- [Apache security advisories](https://httpd.apache.org/security/vulnerabilities_24.html): many 2.4 security fixes postdate installed 2.4.58. Latest displayed release at audit was 2.4.69 (October 2026). Applicability depends on enabled modules/configuration; no claim is made that every advisory is exploitable here.
- [Tailwind Play CDN](https://tailwindcss.com/docs/installation/play-cdn): official docs limit this mechanism to development. A production asset build is unresolved.
- [Apache Friends downloads](https://www.apachefriends.org/download.html): the current XAMPP package family differs from the installed 2023 bundle. Installing/upgrading system services is outside the code audit; do not silently replace the user's runtime.

## Packaging baseline

`python tests/package_policy.py`: 30/30 passed; see `data-baseline-package-policy.log`. Uses an OS temporary synthetic tree only; no application DB/private file access. Current source policy excludes environment variants, bundled VCS, all private payload bytes, caches/logs, dumps, stale fixtures, temporary credentials and generated verification output; keeps directories, markers, access-control files, source and forward migrations. Policy does not delete any original upload. Final V6 source/evidence archives will be rebuilt only after root declares documentation final.

## Masked secret scan

Read-only scanner: `masked_secret_audit.py`; evidence: `data-secret-audit.json`. Latest scan covered 491 working-tree files (including ignored local environment/private paths) and 728 reachable Git blobs across 18 reachable commits. One configured remote URL was inspected internally; zero embedded HTTP credentials were found. Binary files are inventoried rather than interpreted as text. No raw matched values or private contents are emitted. Pattern scanning cannot establish that arbitrary unknown secrets are absent. High-confidence provider/private-key matches always require manual review regardless of filename; only generic literal candidates use source/test classifications.

| Finding | Locations/count | Classification/action |
|---|---|---|
| Legacy database password hashes | `database/vostokpribor_ai.sql:894` through line 901, eight bcrypt hashes; same historic Git blob `229689e9647f815671e90c4fd57e2a321e8a3701` | Sensitive legacy data. Dump is already excluded by release policy; no file/history/database deletion was performed. Determine whether any corresponding old credential is reused, then rotate affected real accounts and invalidate sessions before external use. Do not infer that these hashes are current database accounts. |
| Generic credential-looking literals | Dynamic StudentManagement CSRF template, SOC route handler names, weak-password denylist, mocked RangeClient tokens/passwords, packaging sentinel, and mirrors in old source patch | Reviewed as code/templates/test values. They are not configured live provider credentials. Historical retired tests also contain fixed fixture passwords; never use them for a nonlocal account. Full masked locations/types/counts are in JSON. |
| Local environment | `.env` is untracked; privileged DB account with an empty password | Authorized local test environment only. Replace privately with independently restricted credentials for any deployed installation. No value is copied into evidence; environment file unchanged. |
| Known provider/private-key patterns | Zero AWS/GitHub/Google/OpenAI API token or private-key-header matches | Limited to the patterns and reachable history scanned. |

Rotation sequence if a real credential is identified: revoke/rotate it at its issuer; invalidate associated sessions/tokens; privately replace environment configuration; remove tracked material in a reviewed forward commit; separately decide whether repository history needs coordinated rewriting. This audit does not rewrite or purge history or destroy older user data. The public configuration key `CSRF_TOKEN_NAME` is an identifier, not a secret, and was excluded from credential-value findings.

## Implemented measured change and observed results

Only `app/Repositories/SocWorkspaceRepository.php` was changed for performance. Lists retain existing 100 default / 200 maximum, descending IDs, offsets, active administrator service gate, exact owner/ticket/status filters and existing counts. A bounded primary-record slice is selected before owner joins/counts. Linked ticket/owner predicates are applied inside the slice, so a page is not filtered after limiting. Job and model lists project summary columns; full saved code/stdout/stderr and original model/administrative metadata remain on the existing authenticated detail endpoints. The Recorded Runs table still receives its parameters and metrics inline. No shared layout/CSS/navigation changes were made by this agent, and no default pagination was added to complete student lists.

The new `tests/repository_performance.php` CLI probe refuses non-testing, non-loopback, non-V6-perf database names and nonempty test databases. It records exact executed SELECT SQL, EXPLAIN plans, two warmups and seven samples. Volume fixture: 300 students, 3000 tickets/active assignments/notebooks/experiments/runs/models/submissions, 9000 cells, 300 dataset/version metadata records, 3000 grants and 200 cancelled job records. There are 200 explicitly unavailable model-version metadata fixtures, 200 NOT_EVALUATED validation records and 200 PENDING/NOT_CONFIGURED request records. No artifact files are created and no invalid test path is claimed available. All records exist only inside the transaction on the newly created performance DB, then roll back. Every table count was compared before and after; only initial administrator/migration rows remain. Auto-increment sequences may advance, as expected in MySQL transaction rollback.

Same-fixture original `0b8cd08` SQL comparison, final observed emulated-PDO run (`data-performance-final.json` / `.log`):

| 100-row query | Original median | Final median | Original JSON bytes | Final JSON bytes |
|---|---:|---:|---:|---:|
| SOC jobs | 14.889 ms | 0.843 ms | 12,050,802 | 43,902 |
| SOC model summaries | 1.989 ms | 1.292 ms | 756,001 | 50,201 |
| SOC recorded runs | 158.296 ms | 6.330 ms | 749,401 | 749,401 |
| SOC experiments | 1.055 ms | 3.733 ms | 31,101 | 31,101 |

The experiment slice has small materialization overhead in this run; it caps join/count work independently of optimizer join-order estimates. Initial fresh-statistics experiments had 127.954 ms before / 1.196 ms after; those separate runs are retained but are not presented as a controlled speedup. Exact SQL/EXPLAIN and min/max values accompany the medians. Shared-host load, transaction visibility, cached pages and InnoDB estimates vary; timings are local observations, not a production SLA or capacity guarantee.

Dataset lists were approximately 6.8 ms for 300 administrator rows and 5.5 ms for the student's one pinned dataset under ten active ticket grants. The complete legacy administrator model list still returns approximately 22.7 MB at 3000 long-metadata rows (~219 ms in this run); compatibility was preserved. Future explicit summary/pagination contracts could address that payload, but silently hiding work is unacceptable. Student model list returned all ten own models (~0.5 ms). No new index/migration was justified or applied.

Regression results: 32 new pagination/filter/foreign-owner/count/summary/full-detail/pinned-version assertions passed, 31 existing workspace integration checks passed, 27 dataset lifecycle checks passed. All mutating checks used only `vostok_range_v6_20261031_perf_test` and rolled back; exact own temporary files from existing lifecycle tests were removed by those tests. API contract check: 113 required contracts / 183 total routes. Security unit check: 40 passed, no DB connection. Packaging policy: 30 passed, no workspace/DB access. PHP syntax passed for the repository and new test.

Two guard checks also passed: the performance test rejects APP_ENV=production and a non-dedicated database name before obtaining a PDO connection (`data-performance-guards.log`). Independent read-only review found no blocking ownership/query/pagination/detail regression. Its audit-scanner classification suggestion was applied, preserving mandatory review for actual key patterns in every file type.

`bin/verify_fresh.php` independently passed after every volume/workspace/dataset suite: exactly one ADMIN with valid password_hash and must_change_password=1, zero records in all work/audit/notification/session tables. Evidence: `data-perf-final-pristine.log`. This verifier is read-only. The dedicated test database remains available with its schema/initial administrator for later investigation; no database was dropped.

Native PDO application configuration is owned by the training agent. This agent independently reran the complete volume fixture with `PDO::ATTR_EMULATE_PREPARES=false` set on the testing connection only. All 32 assertions and every-table rollback checks passed; JSON confirms `native_prepares=true`. Evidence: `data-performance-native.json` / `.log`. Independent fresh verification again confirms one administrator and zero work records (`data-perf-native-pristine.log`). No environment/source/database connection defaults were changed for this probe.

Same-fixture native medians: jobs original 54.090 ms / 12,050,901 bytes versus final 0.864 ms / 44,001 bytes; recorded runs 177.913 ms versus 6.698 ms (same inline payload); models 0.922 ms / 756,001 bytes versus 1.238 ms / 50,201 bytes. The model slice costs ~0.3 ms in this sample while removing ~93% of transferred JSON bytes. Experiments original 0.591 ms versus final 1.194 ms. These observations explicitly include small materialization overhead where the optimizer already chose a good plan. They do not claim universal speedup or production readiness. The probe's full-fixture peak allocated memory was 132,120,576 bytes; this is the entire CLI measurement process, not an isolated HTTP request measurement.
