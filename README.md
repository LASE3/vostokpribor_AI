# VOSTOKPRIBOR AI Engineering Range

Plain PHP 8.2+ without Laravel, MySQL/MariaDB through PDO, one shared backend/database, four student systems and an administrator AI SOC. All operational records originate from authenticated actions. Navigation, GET requests, JavaScript loading, migrations and service startup do not create students, scenarios, notebooks, cells or other demo work.

The persisted non-execution workflow and central SOC administration were verified on Windows/XAMPP on 2026-10-30. Isolated execution, trusted quality evaluation, dataset SQL execution and inference serving are unavailable. Administrative deployment approval does not deploy a model. Read [VERIFIED_COMPLETED_FEATURES.md](VERIFIED_COMPLETED_FEATURES.md) for exact results, source diffs and blockers. This is not a full production-readiness claim.

## Five systems, one platform

| System | Role | Persisted functionality |
| --- | --- | --- |
|SYS-AI-01 Project Management|Student|Assigned tickets, progress, comments, submissions, review decisions/profile/notifications|
|SYS-AI-02 Data Center|Student|Assigned master versions, actual preview/download, processed file uploads/history|
|SYS-AI-03 ML Workbench|Student|Explicit notebook/cell saving, owned experiment metadata, actual saved job history; execution disabled|
|SYS-AI-04 Model Registry & Deployment|Student|Model metadata, actual artifact versions/checksums, honest integrity/validation results, administrative deployment requests|
|SYS-AI-05 AI SOC|Administrator|Central account/work/dataset/review management, original student workspace inspection, model administration, request decisions, real counts/health/settings/audit|

`api/v1/index.php` applies CSRF and dispatches through one Router. `app/Core/ApiRoutes.php` registers `api/v1/modules/{project,data,workbench,registry,soc}.php`. Controllers call shared Services and Repositories through `app/Core/Database.php`. Use `execute(sql,params)` for SQL and `insert(table,data)` for structured inserts; the latter rejects SQL strings. Related writes/audit/notifications use transactions. Compatibility URLs call the same implementation.

Pages use `app/Views/Layout/AppLayout.php`, shared Header/Sidebar/NotificationsButton/UserProfile/PageContainer, `config/navigation.php`, existing branding and CSS tokens/components. The approved header/sidebar/colors/spacing/icons remain. Add meaningful administrative panels through the existing AppLayout and `vp-*` components. RangeClient provides API transport/error handling/CSRF and safe text toasts; it is not business persistence.

## Windows/XAMPP installation

Verified runtime: XAMPP Apache 2.4.58, PHP 8.2.12 with `pdo_mysql`, `fileinfo`, sessions and JSON, MariaDB 10.4.32. The application requires no Python runtime to save student work. Python3 with `requests` is used for HTTP tests/packaging; Node.js is used for JavaScript checks. Enable Apache `mod_rewrite` and AllowOverride for the supplied `.htaccess` rules.

1. Extract source to `C:\xampp\htdocs\vostokpribor_AI`. Start Apache and MySQL in XAMPP. Keep all private/access-control files. Do not import `database/vostokpribor_ai.sql`; that retained old-data backup is not a migration and is omitted from source releases.
2. For a new checkout only, create a local environment file:

   ```powershell
   Set-Location C:\xampp\htdocs\vostokpribor_AI
   Copy-Item .env.example .env
   ```

   Preserve an existing `.env`; never overwrite it to prepare a release or run tests. Configure `APP_ENV=local`, `APP_DEBUG=false`, loopback `APP_URL`, `DB_HOST=127.0.0.1`, `DB_PORT=3306`, explicit `DB_USER`/`DB_PASS`, `DB_CHARSET=utf8mb4` and the configured source `DB_NAME`. Root/empty password is an XAMPP-local convenience only. `SESSION_COOKIE_NAME` must be distinct for each installation; use `SESSION_SECURE=false` only for local HTTP.
3. Create a newly named database with the CLI-only installer. This example target must not already exist:

   ```powershell
   C:\xampp\php\php.exe bin/install_fresh.php --database=vostok_range_local_02 --confirm-local-dev --backup-dir=C:/Users/nijim/.codex/backups/vostokpribor
   ```

   The configured existing source database is backed up with mysqldump outside htdocs before creation. Failed backup or existing target causes refusal. No tables/databases are dropped and old rows/files remain. The installer creates schema/migrations plus exactly one ADMIN using password_hash and must_change_password=1. No student/work/notification/audit fixtures are inserted. It does not rewrite `.env`.
4. Review the backup/new-database output, then explicitly set local `.env` `DB_NAME=vostok_range_local_02` and a distinct cookie. Verify before login:

   ```powershell
   C:\xampp\php\php.exe bin/migrate.php
   C:\xampp\php\php.exe bin/verify_fresh.php
   ```

   Seven tracked forward migrations run once. A pristine installation has one admin, zero rows in 27 other application tables, and only migration tracking metadata. A repeat migration adds no fixtures. The verifier is read-only and deliberately fails after legitimate logins/uploads/audit events; do not clear real records to satisfy it.
5. Open `http://localhost/vostokpribor_AI/login.php`. The authorized local-only initial identifier/password is **admin / admin**. Complete the real change-password form before entering a workspace. The current password must verify; a new 12–72 byte password is hashed and session/CSRF rotate. The default is rejected in production, nonloopback requests, public/malformed Host/APP_URL and forwarded/proxied requests.

For an already migrated, entirely empty local schema, the alternative one-time command is `php bin/create_local_super_admin.php --confirm-local-dev`. It refuses any existing application records and cannot reset a user. For a newly provisioned production schema, run migrations using a privileged CLI identity, then `php bin/bootstrap_admin.php --email=you@example.com --name="Administrator" --identifier=admin`, supplying a strong 12–72 byte password on stdin. Do not put a real password in source, shell history or command-line arguments. Use only one initializer per schema.

Environment file values remain request-local; they are not published using putenv on threaded Apache. Explicit process configuration overrides `.env`, allowing CLI tests to enforce APP_ENV=testing. Missing database configuration fails closed rather than selecting an old default database.

## Existing installation upgrades

Back up MySQL and private files before running `php bin/migrate.php`. Migrations001–003 are retained.004 adds immutable dataset versions/pinned grants/archive/revocation while backfilling only actual preexisting dataset metadata; files and original timestamps remain.005 adds revoked ticket grants, session generations and submission request keys.006 adds separate administrator model annotations and deployment request idempotency/provider state.007 stores fractional instructor scores as DECIMAL(5,2). The migration runner does not import the old SQL dump.

Current development main `.env` remains on `vostok_range_20261026_fresh`; only forward migrations004–007 were applied after its verified external SQL backup. All new workflow test work used `vostok_range_20261030_main_http_test`, served from a separate local-only code snapshot and cookie. `vostok_range_20261030_fresh_verified_test` is the separate, untouched post-verification pristine test installation. These database names are observations, not hardcoded application defaults.

## Central SOC administrator workflow

All administrative work below is available within System 5. The administrator does not need to enter student authoring applications.

1. **Students & Cohorts:** create a student with unique identifier/email and a secure initial password. Public registration does not exist. Edit profile/cohort/department, activate/deactivate, inspect progress/dossier or reset an initial password. Deactivation/reset invalidates existing sessions; reset requires student rotation.
2. **Scenarios & Tickets:** save the ten-step scenario builder through the authenticated SOC API. Metadata/steps persist in typed MySQL JSON; grid/table/roadmap/cards/counters reload actual records. Create a ticket with real description, requirements, deadline, acceptance criteria and priority. Use its management modal to edit/assign/reassign/cancel or inspect related work.
3. **Dataset Management:** upload an actual CSV/JSON master. Preview real rows, file-derived dimensions and checksum; edit descriptive metadata/scenario association; upload immutable versions. Assign a chosen dataset version to the same active student/ticket. Ticket assignment must exist first. Revoke or archive access without deleting original bytes/history/processed work.
4. **Student Notebooks & Experiments:** inspect original saved code/cells, experiment/runs and job history within SOC. Administrator inspection cannot overwrite the student's authoring. Cancel an existing queued job state; no runtime termination or health is claimed.
5. **Model Management / Validation Reports / Deployment Requests:** inspect real student metadata/versions/checksums; save separately attributed admin labels/notes or archive/restore records. Validation distinguishes file integrity from absent trusted quality evidence. Approve/reject a request administratively; no inference endpoint is created.
6. **Submission Reviews:** review the latest actual submission, with feedback and optional 0–100 fractional instructor grade. Approve/reject/request changes. The decision, grade, ticket state and notifications persist for the student. Retries do not duplicate an iteration or decision event.
7. **Operations Telemetry / Workspace Configuration / Audit Logs:** use real counts/activity, measured current PDO SELECT1 availability and explicit unavailable external-service states. Settings persist only `student_help_text` and `platform_announcement`, rendered escaped to student guidance. Filters query real audit records.

Ticket reassignment revokes the former student's ticket and linked master-dataset access. The original student's notebooks, models, processed uploads and submissions keep their original ownership and history; they are not transferred. The new student receives no dataset grant until explicitly assigned. Cancellation remains visibly CANCELLED and revokes dataset access. Existing grants stay pinned to their dataset version when a new version is uploaded; reassign explicitly to change that pin.

Scenarios support `DRAFT → READY_FOR_REVIEW → PUBLISHED → ACTIVE → COMPLETED`. Archive is supported, with `ARCHIVED → DRAFT`; allowed reverse/edit transitions are enforced server-side. Rubric weights must total 100 for publication. Duplicate creates a distinct record, export reads MySQL and import saves validated drafts; import preserves existing records and reports any partial persistence rather than claiming an atomic bulk replacement. Scenario environment/GPU fields describe requested work, not provisioned resources.

## Student workflow

1. Log in with the administrator-issued credential and rotate it. Initial counts and all work lists are zero/empty until actual assignments exist.
2. SYS-01 shows only assigned tickets; start/resume progress and save actual discussion. SYS-02 shows only granted master versions. Preview/download verifies the real private file/checksum.
3. Upload a real processed CSV/JSON against the assigned master version and the same assigned ticket, with transformation notes. Both relationships are checked. Processed history remains the original student's work after master access is revoked.
4. SYS-03 requires an explicit Create Notebook POST. Add/edit cells, Save Notebook and reload identical source. GET/navigation never creates a notebook/cell. Execution says unavailable; editor output cannot forge successful execution. Experiment runs are clearly user-reported RECORDED metadata.
5. SYS-04 model registration creates metadata only. An optional actual nonempty artifact upload creates a private immutable model version/checksum. No fake artifact is generated. A permitted validation request checks artifact integrity; absent trusted evaluation yields NOT_EVALUATED/null quality score, regardless of user-supplied accuracy/latency metrics.
6. An intact artifact permits saving desired deployment configuration for administrative review. PENDING/APPROVED/REJECTED describes the request; provider_state stays NOT_CONFIGURED, runtime unavailable and endpoint empty. No link pretends to run inference.
7. Submit notes and optional owned notebook/model references for the same ticket in SYS-01. Read actual review feedback/grade/status/notifications. Requested changes permit a new explicit iteration; approval persists in MySQL and the student's ticket.

## Authentication and API map

Base is the configured installation prefix plus `/api/v1/`; nested XAMPP paths are supported by AppUrl and RangeClient. [API_REFERENCE.md](API_REFERENCE.md) lists all 183 routes,113 required contracts, payloads and compatibility handlers.

| Namespace | Main routes | Scope |
| --- | --- | --- |
|auth|GET csrf/me; POST login/change-password/logout|Cookie session; business routes blocked until rotation|
|project|dashboard, tickets/progress/comments, profile, submissions, notifications|Own active assignments/owned work; administrative mutation requires ADMIN|
|data|datasets/detail/preview/download/versions, processed uploads/detail/download, activity|Active master grants; processed work owner/admin|
|workbench|notebooks/cells, experiments/runs, artifacts, execution-status/jobs/cancel|Original owner/assigned-ticket authoring; runner submission unavailable|
|registry|models/versions, validations, deployment requests/decisions|Original owner; actual artifact required; admin decisions scoped|
|soc|students, scenarios, tickets, datasets, workspaces, models, validations, deployments, reviews, overview/health/activity/settings/audit|Common active ADMIN gate,81 routes|

First GET `auth/csrf` and retain its cookie. Send `X-CSRF-Token` on every mutation, **including login**. Login/password rotation returns a new token. HTML POST forms use session tokens too. Wrong/missing/malformed tokens are403. Login route matching grants no substring exemption. Unknown/invalid bodies fail rather than being accepted as empty data.

Responses use `{success:true,data,message}` or `{success:false,error:{code,message}}`; binary downloads return authorized bytes.401 means unauthenticated/expired,403 role/CSRF/ownership/mandatory rotation,403/404 missing scoped objects,400 malformed JSON,422 invalid fields/transitions,503 unavailable execution. Error details stay private with APP_DEBUG=false. API success alone is not proof of runtime infrastructure.

Use submission `request_key` and deployment `idempotency_key` for retry-safe creation. Existing progress/assignment/review/settings operations avoid duplicate effects. Administrator annotations cannot edit student-authored model name/code/metrics. Related object references are checked for original owner and ticket consistency, not just existence.

## Files, ownership and service boundaries

- `storage/private/datasets/`: genuine master and processed bytes; MySQL owns paths/checksums/schema/dimensions/version and assignment references. CSV headings must be unique/nonempty with consistent widths; JSON must be consistent row objects. File parsing does not imply statistical/model quality success.
- `storage/private/models/`: genuine opaque uploaded artifact bytes; MySQL records owner/version/checksum. Registration alone creates no version. A file extension is neither a safety certificate nor trusted evaluation evidence.
- `storage/private/sandboxes/`: preserved directory for future infrastructure; current HTTP/worker code does not execute student code. Both worker entry points refuse operation. No environment toggle enables host subprocess execution.
- Rollback cleanup removes only a new file written by the failing request. Migrations, GET, startup, archive/revoke and source packaging never delete uploads. Actual bytes and MySQL metadata are different persistence layers and must be backed up together.
- Apache denies direct app/config/database/storage/bin/workers/tests/.git/module paths and `.env`; authorized download APIs check scope and integrity. Keep `.htaccess` and storage directories. Reproduce these denials explicitly under other web servers.
- A safe future runner requires a separate restricted identity, network/filesystem isolation, CPU/memory/process/time limits and verified cancellation. A trusted evaluator must bind independent results to actual artifact/dataset checksums. A serving provider needs real runtime/health evidence before a deployment URL is exposed. Query Workspace currently executes no SQL.

## Tests and reproducible evidence

[Final report](VERIFIED_COMPLETED_FEATURES.md) links observed logs: 400 central HTTP/HTML checks,244 supplementary endpoint assertions,104 SOC denial checks,23 audit-failure HTTP checks,113 route contracts,44/27/31 training/dataset/workspace checks,27 migration-preservation checks,6 deployment archive-race checks,8 environment isolation checks,23 mocked-client checks,40 pure security checks,30 package-policy checks and231 syntax checks. The main isolated test snapshot was served by real XAMPP Apache/MySQL. Browser saves were reloaded and checked directly against MySQL/private file hashes. All 183 routes have HTTP evidence; execution correctly returns 503. These are test-scope results, not production certification.

Never run mutating tests against the fresh/user installation. Create a separate **source copy** under a local-only Apache path, with its own `.env`, APP_ENV=testing, newly named `_test` database, distinct SESSION_COOKIE_NAME and matching APP_URL. Do not copy user private payloads. Do not change the main `.env` to test. Example commands below run from that isolated copy:

```powershell
Set-Location C:\xampp\htdocs\vostokpribor_test
# Configure this copy's .env with APP_ENV=testing and a NEW DB_NAME ending _test.
C:\xampp\php\php.exe bin/install_fresh.php --database=vostok_range_next_test --confirm-local-dev
C:\xampp\php\php.exe bin/verify_fresh.php
C:\xampp\php\php.exe tests/api_contracts.php
C:\xampp\php\php.exe tests/security_unit.php
C:\xampp\php\php.exe tests/env_isolation.php
C:\xampp\php\php.exe tests/training_integration.php
C:\xampp\php\php.exe tests/dataset_lifecycle.php
C:\xampp\php\php.exe tests/workspace_integration.php
C:\xampp\php\php.exe tests/deployment_locked_state.php
node tests/range_client_security.js
python tests/package_policy.py
# The existing Python requests dependency is required.
$env:TEST_BASE_URL='http://127.0.0.1/vostokpribor_test'
python tests/http_central_soc.py
python tests/http_soc_extra.py
python tests/http_soc_security.py
$env:TEST_DATABASE_KEY='vostok_range_next_test'
python tests/http_core_security.py
Remove-Item Env:/TEST_BASE_URL,Env:/TEST_DATABASE_KEY
```

`http_central_soc.py` bootstraps random test credentials/mandatory rotation once and records them privately under the current user's `.codex/tmp/vostok-integration-20261030-credentials.json`; supplementary/core suites read that mapping. They create unique test work and never reset an existing database. `http_core_security.py` accepts TEST_CREDENTIALS_FILE if that private path differs. DB integration suites require loopback APP_ENV=testing and `_test`; contract rows roll back. The security HTTP helper creates narrowly scoped temporary triggers only in that guarded database and removes them finally. Existing test rows/files are not silently reseeded or erased.

For migration preservation, from the testing copy run `php tests/migration_preservation.php vostok_range_YYYYMMDD_unique_migration_test` with a newly chosen name; it creates another new schema, refuses reuse and verifies original IDs/metadata/file bytes through forward migrations. Do not substitute the real schema. Older retired fixture test/patch helpers deliberately exit78 and are omitted from the release.

## Source release and evidence packaging

From main source, build to an unused path **outside htdocs**:

```powershell
python bin/package_release.py --build C:/Users/nijim/.codex/artifacts/vostokpribor-ai-integrated-20261030.zip
```

The production-source policy omits all `.env` variants except `.env.example`, `.git` history, old data dumps/local databases, all private dataset/model/sandbox payloads including newer uploads, caches/debug logs, retired fixture helpers, scratch files and generated verification output. It preserves active source/tests, seven migrations, storage directories/control files and the shared design. It never deletes/modifies local uploads or accesses MySQL. Output filenames cannot be overwritten. CRC, per-file hashes and archive SHA256 are verified in an external manifest. Older inventory switches are accepted for compatibility but cannot include private files in this profile.

Verification is distributed separately as an evidence ZIP with relative `verification/` paths. Extract it alongside source when reviewing report links; it contains test logs/screenshots/manifests, not database dumps, credentials or private artifact bytes. Active tests create their evidence directories on demand in a clean extraction. The source ZIP is a clean installation package, not a database/file backup. Preserve real uploads and SQL backups separately during deployment/migration.

## Deployment and troubleshooting

Public deployment remains PARTIALLY COMPLETE. Configure HTTPS, APP_ENV=production, APP_DEBUG=false, SESSION_SECURE=true, strong rotated credentials, restricted application and separately privileged migration identities, protected private storage and tested backups. Compile/self-host the existing frontend dependencies for production; the preserved Tailwind CDN currently emits a production-use warning. Verify server-specific rewrite/access-control rules and security behavior. No default admin credential is valid on the public internet. Missing sandbox/evaluator/serving infrastructure remains disabled regardless of environment.

- Database/configuration error: check XAMPP MySQL, explicit DB_NAME/DB_USER, privileges and pdo_mysql. Never fix it by importing the old dump or resetting an existing schema.
- API404: check mod_rewrite, AllowOverride and APP_URL installation prefix. A PHP development-server test does not verify XAMPP.
- CSRF403: retain the same cookie, refresh token after login/password rotation, reload the form. Separate testing/admin/student sessions with distinct cookie names or profiles.
- PASSWORD_CHANGE_REQUIRED: complete rotation with the current issued password. Direct local admin/admin initialization is refused behind a public Host/proxy/production configuration.
- No assigned tickets/datasets: verify the active ticket grant and matching student/ticket/version dataset grant. Empty states are expected, not a reason to seed fixtures.
- Missing/corrupt file: inspect its real private path/checksum and backup; do not generate dummy bytes to replace it. Metadata-only models cannot validate/request deployment.
- Execution/evaluation/inference unavailable: expected infrastructure boundary. Recording user metrics, changing Python paths or approving a request cannot create a service.
- Empty verifier fails after use: preserve and inspect the real rows/audit events; the verifier is a pristine-install check, not a cleanup command.
- Old patch/test helper exits78: use current guarded suites/migrations instead. Browser save error: inspect its actual backend error; do not assume the form persisted.
