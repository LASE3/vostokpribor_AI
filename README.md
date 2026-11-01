# VOSTOKPRIBOR AI Engineering Range — V10

Plain PHP8.2+ without Laravel, MySQL/MariaDB through native PDO, four student systems and one administrator AI SOC. Operational content comes from actual authorized actions and private files with MySQL ownership/metadata. GET requests, JavaScript loading, migrations and service startup never import fixtures or create notebooks/cells.

**Verified for controlled localhost demonstration on main,2026-11-01.** Students see four student systems; administrators go directly to AI SOC and manage original student work there. HTML role boundaries are server-enforced; SOC APIs retain legitimate administrator inspection. [Verified features](VERIFIED_COMPLETED_FEATURES.md), [34-part final report](docs/V10_FINAL_REPORT.md), [tests](docs/V10_TEST_RESULTS.md), [role matrix](docs/V10_ROLE_ACCESS_MATRIX.md).

ML Workbench now supports **manual Google Colab notebook code exchange**. Live Google execution is **BLOCKED** because no Cloud project/authorization or verified isolated provider exists. Trusted model evaluation, inference serving and dataset SQL execution remain unavailable. Public production deployment is not accepted.

## Use Colab with ML Workbench

1. Log in as a student, open ML Workbench → Notebook Workbench and save your notebook.
2. Select **Download for Colab**. It exports the saved code as a standard .ipynb, without execution claims or private application configuration.
3. Use **Open Google Colab**, sign in with your own Google account, and manually upload the downloaded notebook there. This application transfers no code or datasets automatically. Upload only data you are authorized to share with Google.
4. After editing in Colab, download its .ipynb. In ML Workbench use **Import Colab notebook**, enter a new title/optional assigned ticket and upload that file. The explicit POST creates a new owned notebook; it preserves code and discards outputs, execution counts, attachments, foreign IDs and claimed provenance.
5. Reload to confirm saved code. Importing output is not evidence of trusted execution, quality or deployment.

Local exchange bounds:2MiB nbformat4 JSON, at most200 code/markdown cells,256KiB per source. Export supplies unique nbformat4.5 cell IDs. Real HTTP/browser/SQL checks verify download/import/reload, ownership and safe error states. Actual Google execution was not tested or claimed.

The **Colab Enterprise adapter is prepared and disabled**. It builds the documented notebookExecutionJobs request offline and provides bounded OAuth refresh/RSA/HTTPS support. Its optional COLAB_CONFIG_FILE points to private operator configuration outside source/webroot; Google secrets are never browser settings. `php bin/colab_preflight.php` reports offline availability and exits78. `--probe-google` requires real private configuration and performs only an explicit authenticated read-only runtime-template probe. Credentials alone cannot enable submit/cancel. There is no activation flag or host fallback. Dataset transfers, provider output retrieval and execution monitoring remain blocked pending real IAM/network/runtime/cancellation/data-handling acceptance.

[Exact configuration/workflow](docs/V10_COLAB_INTEGRATION.md), [all three supplied official API references and selection rationale](docs/V10_COLAB_RESEARCH.md), [architecture](docs/V10_ARCHITECTURE.md). Ordinary Colab kernel sessions do not isolate runtime files; Enterprise job DELETE is not assumed to cancel execution. A separate trusted evaluator and serving provider are still required.

## Five systems

|System|Role|Persisted work|
|---|---|---|
|SYS-AI-01 Project Management|Student|Assigned tickets, progress/comments, submissions, decisions, own profile/notifications|
|SYS-AI-02 Data Center|Student|Assigned immutable master versions, actual preview/download, processed file lineage/history|
|SYS-AI-03 ML Workbench|Student|Explicit notebook/cell saving, experiment/manual-run metadata; execution unavailable|
|SYS-AI-04 Model Registry & Deployment|Student|Model metadata, genuine artifact versions/checksums, integrity/quality availability, deployment review requests|
|SYS-AI-05 AI SOC|Administrator|Accounts/scenarios/tickets/assignments/datasets, original student workspace inspection, models, submissions/reviews, real counts/health/audit|

Students launch the four systems at Dashboard first. Administrator login/root opens SOC Dashboard directly; administrators cannot enter student HTML systems, and students cannot enter SOC. One canonical SOC Dashboard is retained; the old OperationsDashboard bookmark redirects. The existing palette, header/sidebar, icons, spacing and shared layout remain. Empty states include No students, No assigned tickets, No datasets, No notebooks, No models, No submissions and No metrics available. An unavailable service is never shown as healthy.

## Windows/XAMPP: new localhost installation

Observed verification host: Windows11, PHP8.2.12, Apache2.4.58, MariaDB10.4.32. These installed patch levels are **not approved for public hosting**. PHP needs pdo_mysql, mbstring, fileinfo, JSON, sessions, zip and OpenSSL; Apache needs mod_rewrite and `AllowOverride All` for the supplied .htaccess rules. Start Apache and MySQL in XAMPP. Restrict development hosting to loopback.

1. Extract the clean source ZIP into a **new** directory such as `C:\xampp\htdocs\vostokpribor_AI`. Never overwrite an existing .env or uploads. The ZIP contains no data dump, environment, history or private payload. Do not import a historical SQL dump.
2. Copy .env.example to .env only in that new tree. Set APP_ENV=local, APP_DEBUG=false, exact loopback APP_URL, explicit DB_HOST/DB_PORT/DB_USER/DB_PASS, unique DB_NAME and SESSION_COOKIE_NAME. Use operator credentials only for setup/migrations. A database name is never silently selected for you.
3. Run the CLI-only initializer with a **newly named absent** target database:

```powershell
Set-Location C:\xampp\htdocs\vostokpribor_AI
Copy-Item .env.example .env  # new tree only; edit the settings before continuing
& C:\xampp\php\php.exe bin\install_fresh.php --database=vostok_range_local_new_name --confirm-local-dev --backup-dir=C:\Users\YOUR_USER\.codex\backups\vostokpribor
```

It refuses an existing target. If the configured older database exists it first saves a SQL backup outside webroot, then creates only the new target, applies **eight migrations** and creates exactly one ADMIN identifier **admin**, initial local password **admin**, password_hash and must_change_password=1. No students/work/audit rows are created. It does not switch .env: explicitly set DB_NAME to the new target after inspecting output, then verify **before any HTTP action**:

```powershell
& C:\xampp\php\php.exe bin\verify_fresh.php
```

Expect exactly one active ADMIN and zero every non-user/non-migration table. This is a pristine-install verifier, never a reset tool. Login at the configured URL and complete the real change-password.php flow. Password rotation changes the hash/session generation, returns a new CSRF token and records an audit event. The initial weak credential is authorized only on loopback and is rejected for public requests. There is no public registration.

`bin/create_local_super_admin.php --confirm-local-dev` is an alternative one-time initializer for an already migrated empty local schema; do not run both to create another admin. For an empty non-development schema use operator-created schema + `bin/migrate.php`, then `bin/bootstrap_admin.php --email=YOUR_ADDRESS --name="Administrator" --identifier=admin`, supplying a strong12–72-byte password on stdin. Existing administrator credentials are never reset by startup or migrations.

After setup, use an independent localhost runtime MySQL identity with only SELECT/INSERT/UPDATE/DELETE on the **exact** application schema. Escape underscore/percent wildcards in GRANT scopes, including backtick-quoted scopes. Keep migration/backup operator credentials separate. Test actual grants and DDL/source-database denials. [Detailed installation, runtime separation and recovery](docs/V10_DEPLOYMENT_GUIDE.md).

## Existing installation and backups

Preserve .env, database and every real upload. Take and verify a combined encrypted backup during a quiet window, restore it into a newly named isolated `_test` installation, rehearse migration, then update source and run `php bin/migrate.php` with the operator identity. No web migration/seed/startup migration exists. Migration008 adds nullable run dataset-version lineage, UNKNOWN-default provenance and indexes; it does not promote old metrics or drop tables.

`bin/backup_range.php --output=ABSOLUTE_NEW_ZIP_OUTSIDE_WEBROOT` accepts stdin JSON containing `backup_password` (24–1024bytes), encrypts database/private files/configuration with AES-256 and refuses overwrite/concurrent changes. Keep key and archive separately protected. `bin/restore_range.php --archive=ABSOLUTE_ARCHIVE --target-root=NEW_CODE_TREE --database=NEW_NAME_test` accepts stdin JSON with backup_password, separate runtime_user/runtime_password, loopback app_url and distinct session_cookie ending `_test`. It refuses existing data/configuration and verifies all fingerprints and exact DML grants. Automatic production restoration is intentionally unsupported; follow a reviewed operator procedure. Never put passwords in command arguments or source.

Actual main data is preserved through V10:29 tables/eight migrations/one ADMIN/zero students or training work, with19 legitimate audit and5 rate rows retained. The original18 audit rows and all training rows match the encrypted backup; one real localhost administrator login since that snapshot updated login/auth-rate metadata before isolated tests. The administrator password, .env and52 private files are unchanged. Do not erase audit history to make a used installation pass the fresh verifier. Two actual main-snapshot restores were verified; measured small local restore→HTTP1.852s is not a production SLA. No scheduled/PITR/off-site backup service is claimed. [V10 preservation/recovery results](docs/V10_TEST_RESULTS.md), [combined recovery procedure](docs/V9_DATABASE_VERIFICATION.md).

## Administrator and student lifecycle

1. Administrator opens SYS-05 student management and creates a student with a strong password; student must rotate it.
2. Save a scenario through the ten-step editor. All fields/revisions/lifecycle are MySQL-backed; import/duplicate are explicit writes and export traverses saved pages. Statuses: DRAFT, READY_FOR_REVIEW, PUBLISHED, ACTIVE, COMPLETED, ARCHIVED.
3. Create a ticket with actual requirements, deadline and acceptance criteria. Upload a genuine CSV/JSON master file in SOC/Data Center and assign its immutable version and the ticket to the student.
4. Student sees only authorized tickets/datasets in SYS-01/02, advances progress, downloads actual bytes and uploads processed data associated with that assigned ticket/version.
5. Explicitly create/save a notebook in SYS-03; reload preserves literal source. Record experiment/manual-run metadata if needed. Execution remains unavailable.
6. Register model metadata in SYS-04. Optionally upload a real opaque artifact; only an actual file creates a model_versions record/checksum. Request permitted integrity/quality review and submit owned ticket work.
7. SOC inspects the original artifacts and approves/requests changes/rejects the submission. Decisions, ticket state, student feedback, notifications and audit actors persist in the shared database.

Manual metrics are USER_REPORTED and never quality proof. Missing trusted results are NOT_EVALUATED. Deployment approval is an administrative database decision with provider_state=NOT_CONFIGURED and **no live endpoint**. A missing/invalid artifact cannot validate or request deployment. Dataset Query Workspace does not pretend SQL executed.

## Backend, API and authorization

`api/v1/index.php` applies CSRF/dispatch through one Router; `app/Core/ApiRoutes.php` loads five module registries in api/v1/modules. Controllers call shared services/repositories and app/Core/Database.php. Use `execute(sql,params)` for SQL and `insert(table,data)` for structured inserts; raw SQL is rejected by insert. Related writes/audits/notifications are transactional.

[API_REFERENCE.md](API_REFERENCE.md) documents189 routes/113 required contracts, field names, aliases, pagination and lifecycle. Route families: auth, project, data, workbench, registry and soc. Compatibility routes use the same backend. Collections retain a data array plus top-level pagination; default100/max200, exact authorized total and limit/offset. Historical user-list shape remains an object with items/total/limit/offset, max100. Browser lists have visible page controls; dashboards use full scoped aggregates.

Use the same cookie for GET auth/csrf and requests, then X-CSRF-Token on every mutation including POST auth/login. Login and password changes refresh the token. HTML forms have CSRF too. ADMIN gates all soc routes; students cannot access SYS-05, other users' artifacts or unauthorized referenced ticket/version/owner IDs. Required password rotation blocks business routes. Session generation invalidates reset/deactivated accounts. Safe API errors distinguish401/403/404/409/422/429/503; expected object denial is not an Apache routing failure.

RangeClient uses15s normal/120s upload deadlines; interrupted writes show UNKNOWN_OUTCOME because timeout cannot prove rollback. No automatic write retry reports saved. Browser timeout globals are VOSTOK_API_TIMEOUT_MS/VOSTOK_UPLOAD_TIMEOUT_MS or per-call timeoutMs. Writes/uploads default120/20 per60s; selected expensive reads60/window. Login failure bucket5/120s is shared HTML/API. Respect429 Retry-After; logout remains available with CSRF. Notebook expected_version and scenario expected_revision protect concurrent edits.

## Files and infrastructure boundaries

- storage/private/datasets contains genuine master/processed files. MySQL records ownership, immutable versions, checksums, dimensions/schema and grants. CSV/JSON validation examines real bytes; it does not establish model quality.
- storage/private/models contains genuine opaque uploads. Metadata-only registration creates no file/version. User metrics/extensions are not trusted evaluation evidence.
- storage/private/sandboxes is retained for future infrastructure. HTTP launches no arbitrary Python. Both worker entries refuse execution; no environment flag enables a host runner.
- Authorized download endpoints enforce scope and integrity. Apache denies direct storage/app/config/database/bin/workers/tests/history/env access. Keep storage directories and .htaccess, and reproduce equivalent protection under other servers.
- Rollback removes only a new request's own failing file. Packaging/migrations/GET/archive/revoke never delete existing uploads. Database records and packaged disk files are different layers and need a combined backup.

Future execution requires a separate restricted identity, filesystem/network/resource/time/process policy and verified cancellation/cleanup. Evaluation must bind independent trusted measurements to actual dataset/artifact checksums. Serving must have a real isolated provider/status adapter. [Architecture and blocked service requirements](docs/V10_ARCHITECTURE.md).

## Tests and measured results

Actual results:208 fresh-account role/workflow,33 Colab code-exchange and257 HTTP/independent SQL checks with30 persistence proofs;25 empty student pages;398 central SOC/244 supplementary/146 role-specific entry checks;84 MySQL collection/provenance and75 HTTP pagination;142 full backend/98 request security/106 adversarial;77 encrypted recovery. Provider-backed execution/evaluation/serving acceptance remains BLOCKED. Shipped PHP188/JS20/Python32 syntax checks passed. Actual browser verified Dashboard launches, ten editor steps/reloads/import/export/lifecycle and settled390px layout. [Every V10 suite, log and limitation](docs/V10_TEST_RESULTS.md).

Actual10/50/100/500-student MySQL probes show5,000-model baseline37.9MB/269.771ms versus bounded758KB/71.597ms and compact UI44.7KB/63.871ms median. Local HTTP1/5/10-session bursts had p95 below49ms, zero errors. These are localhost budgets, not500 simultaneous-user or inference capacity. Six-category source audit retains all contextual occurrences across1,147 files; zero operational blockers/coverage gaps. See the security report for Git/npm scan limits and host findings.

Pure checks can run without mutating main:

```powershell
& C:\xampp\php\php.exe tests\security_unit.php
& C:\xampp\php\php.exe tests\security_policy.php
& C:\xampp\php\php.exe tests\env_isolation.php
node tests/range_client_security.js
node tests/frontend_async.js
python tests/package_policy.py
python tests/source_audit_v9.py
python tests/infrastructure_preflight_v9.py
python tests/test_storage_guard_v9.py
python tests/http_test_target_security.py
```

For mutating suites extract a **separate code-only tree**, configure a saved APP_ENV=testing .env, an absent DB_NAME ending `_test`, loopback APP_URL and a distinct cookie ending `_test`. Do not copy .env/user payloads or override main via environment variables. Initialize/verify only that new DB, then set a restricted test runtime identity. Before file-writing PHP suites, run `php tests/prepare_storage.php` while private payload directories are empty; the marker binds the exact tree/database and is excluded from ZIP. Process-only configuration overrides are deliberately refused. Example from that isolated tree:

```powershell
& C:\xampp\php\php.exe tests\prepare_storage.php
& C:\xampp\php\php.exe tests\training_integration.php
& C:\xampp\php\php.exe tests\dataset_lifecycle.php
& C:\xampp\php\php.exe tests\workspace_integration.php
& C:\xampp\php\php.exe tests\model_integrity.php
& C:\xampp\php\php.exe tests\pagination_collections.php
$env:TEST_BASE_URL='http://127.0.0.1/YOUR_TEST_PATH'
$env:TEST_CREDENTIALS_FILE='C:\Users\YOUR_USER\.codex\tmp\range-test-credentials.json'
python tests/http_central_soc.py
python tests/http_roles_v10.py  # creates student_test only in this isolated database
python tests/http_colab_v10.py
python tests/http_workflow_v9.py
python tests/http_empty_pages.py
python tests/http_pagination_v9.py
# Run the failed-login suite last; it deliberately exhausts test login admission.
python tests/http_backend_v6.py
```

HTTP preflight verifies the saved target and actual cookie **before credentials**. Central SOC suite rotates the initial test admin once and saves random credentials outside source/webroot keyed by the exact DB; following suites read that mapping. Do not print/package it. Some security suites need a separate operator-equipped test installation for narrowly scoped failure triggers; DML runtime must not be broadened to make them pass. Older performance suite requires a fresh `vostok_range_v6_UNIQUE_perf_test` and runs before retained-work suites. Tests create uniquely named work and never reset old schemas. A recorded earlier env-only filesystem-test gap was repaired and guarded; main's52 original files remain unchanged.

## Build and release

Compiled local Tailwind3.4.17 CSS ships; Node is build/test-only, no Node application runtime. When templates/themes change: `npm ci`, `npm run build:css`, `npm run check:css`, `npm run test:assets`. [Pinned build recipe](build/ASSETS.md). Fonts/icons still require their declared external assets. No frontend framework replacement was made.

`python bin/package_release.py --build ABSOLUTE_NEW_ZIP_OUTSIDE_WEBROOT` creates a source ZIP and external SHA256/per-file manifest, refusing overwrite. It excludes .env/history/old dumps/private payloads/caches/logs/test marker/generated evidence/retired fixture helpers; retains all eight migrations/layout/storage controls. It never accesses MySQL or deletes/modifies real uploads. Separate evidence ZIP contains reviewed logs/ledger/patch/screenshots, no credentials/dumps/private bytes. The source ZIP is not a data backup. Clean extraction of295 source files and restricted staging repeated208 role,33 code-exchange and257 cross-system checks; final application-file equivalence/hash evidence is external.

## Deployment and troubleshooting

Public deployment is **not accepted**. Rehearse maintained patched PHP/Apache/MariaDB, restricted runtime credentials and separate migration operator, HTTPS, APP_ENV=production, APP_DEBUG=false, SESSION_SECURE=true, strong rotated passwords, protected backups/keys, monitoring, sustained load and production sign-off. The server must indicate real HTTPS; client forwarding headers are not trusted. No runtime upgrade/main credential cutover/public deployment was performed. Missing runner/evaluator/serving remains disabled regardless of environment. [Deployment guide](docs/V10_DEPLOYMENT_GUIDE.md), [security report](docs/V10_SECURITY_REPORT.md).

|Symptom|Action|
|---|---|
|API404|Check exact APP_URL/subdirectory, mod_rewrite, AllowOverride and supplied .htaccess. Anonymous `/api/v1/auth/csrf` should return JSON200. Expected object403/404 or unsupported-route404 remains correct.|
|Database/config error|Check explicit database/user/privileges and pdo_mysql. Never import the old dump or reset user data.|
|CSRF/origin403|Keep the same cookie/token, refresh after login/password change and use the configured origin. Do not remove protection.|
|PASSWORD_CHANGE_REQUIRED|Complete the genuine password flow with the current issued credential.|
|No work|Check active ticket grant and matching student/ticket/immutable-version dataset grant. Empty states are intentional.|
|Missing/corrupt artifact|Inspect real file/path/checksum and restore a verified backup; never generate fake replacement bytes.|
|Execution/query/evaluation/serving unavailable|Expected missing infrastructure; manual metrics or request approval cannot enable services.|
|Fresh verifier fails after use|Inspect retained real rows/audit; never delete them to force zero.|
|429|Observe Retry-After and natural expiry; do not clear rate records.|
|Old helper exits78|Use current guarded tests. Worker/preflight78 means disabled infrastructure, not successful execution.|
