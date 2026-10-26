# VOSTOKPRIBOR AI Engineering Range

PHP without Laravel, MySQL/MariaDB through PDO, four student workspaces and an administrator AI SOC. Business records come from explicit authenticated actions. Installation and migrations never import demonstration students, scenarios, files, notebooks, scores or endpoints.

The persisted **non-execution** workflow was verified on Windows/XAMPP. Execution, trusted quality evaluation, SQL dataset execution and inference deployment are unavailable. Original shell colors, typography, icons and navigation remain; operational panel interiors were refactored, so exact original panel-layout parity is **not complete**. See [verified features, evidence and blockers](VERIFIED_COMPLETED_FEATURES.md) before treating this as a finished production release.

## Unified Frontend Architecture & Design System

The application interface is unified into a single software platform with a consistent layout, company branding, and interaction model across all five subsystems:

- **SYS-AI-01: AI Project Management** (Student)
- **SYS-AI-02: Data Center** (Student)
- **SYS-AI-03: ML Workbench** (Student)
- **SYS-AI-04: Model Registry & Deployment** (Student)
- **SYS-AI-05: AI Operations Center (AI SOC)** (Administrator)

### 1. Shared Layout (`app/Views/Layout/`)
All pages across all systems render through reusable layout components without code duplication:
- `AppLayout.php`: Master static layout controller orchestrating `AppLayout::start(...)` and `AppLayout::end(...)`.
- `Header.php`: Standardized 68px header containing ONLY the official company branding logo + name on the left, and notification count + mini user profile + sign-out button on the right.
- `Sidebar.php`, `SidebarNavigation.php`, `SidebarItem.php`: Auto-collapsing sidebar system.
- `PageContainer.php`: Standardized content container preventing layout jumping.
- `UserProfile.php` & `NotificationsButton.php`: Session-bound profile and notification badge components.

### 2. Auto-Collapsing Sidebar
- **Desktop (>= 1024px)**: Collapsed by default (72px) displaying centered icons with floating tooltips. Expands smoothly to 260px on hover/mouse enter and collapses on mouse leave. Overlays main content with a subtle shadow to prevent layout shifting.
- **Accessibility**: Keyboard tabbing triggers expand via `:focus-within` and accessible focus indicators.
- **Tablet / Mobile (< 1024px)**: Responsive slide-out navigation drawer with backdrop overlay, hamburger trigger, close button, and Escape key dismissal.

### 3. Canonical Navigation Configuration (`config/navigation.php`)
Every system's routes are configured centrally with strict role separation:
- Students access their assigned 4 student systems.
- Administrators access the canonical AI SOC navigation structure:
  - **Overview**: SOC Dashboard, Operations Telemetry
  - **Training Management**: Scenarios & Tickets, Dataset Management, Cadet & Student Roster, Submissions & Rubrics
- Cross-SOC page navigation preserves sidebar structure, grouping, and active page highlighting.

### 4. Design System Tokens & Company Branding
- **Design Tokens** (`assets/css/design-tokens.css`): Strict brand palette:
  - Dark Purple: `#4C1D95` (primary buttons, active navigation indicators, key headings)
  - Soft Lilac: `#D8B4FE` (hover effects, status badges, secondary accents)
  - Light Lavender: `#F3E8FF` (light accent surfaces, selected nav backgrounds)
  - Nude Main: `#E8C9A0` (warm accents, secondary cards, decorative separators)
  - Cream: `#FDF6F0` (main application and card background)
  - Warm Wheat: `#F5DEB3` (dividers, borders, subtle highlights)
- **Component System** (`assets/css/components.css`): Unified `.vp-card`, `.vp-table-container`, `.vp-table`, `.vp-btn`, `.vp-input`, `.vp-select`, `.vp-badge`, `.vp-empty-state`.
- **Company Branding** (`assets/branding/logo.svg`): Official VOSTOKPRIBOR SVG geometry and colors (`#0E7C86`, `#1B3A5C`, `#38BDF8`) preserved exactly without stretching or recoloring.

## Windows/XAMPP installation

Verified runtime: PHP 8.2.12, XAMPP Apache and MariaDB 10.4.32, using `pdo_mysql`. No Composer or Laravel installation is required. Python is used by test/audit/packaging tools, never to execute student code. HTTP tests require Python `requests`; JavaScript syntax checks require Node.js.

1. Extract the source into `C:\xampp\htdocs\vostokpribor_AI`.
2. Start Apache and MySQL from XAMPP. Enable Apache `mod_rewrite` and allow the supplied `.htaccess` rules. Private paths must return 403.
3. For a new source directory without an environment file:

   ```powershell
   Set-Location C:\xampp\htdocs\vostokpribor_AI
   Copy-Item .env.example .env
   ```

   On an existing installation, preserve its `.env` and database credentials instead of overwriting it. The installer uses the currently configured database as the backup source.

4. Configure `.env`: `APP_ENV=local`, loopback `APP_URL`, loopback `DB_HOST`, explicit `DB_USER`/`DB_PASS`, and a newly chosen `DB_NAME`. The example uses `vostok_range_local_01`. Root with an empty password is an XAMPP-local convenience only. Database configuration is mandatory; missing configuration cannot silently reconnect to the former database.
5. Create a **new, unused** target database:

   ```powershell
   C:\xampp\php\php.exe bin/install_fresh.php --database=vostok_range_local_01 --confirm-local-dev --backup-dir=C:/Users/nijim/.codex/backups/vostokpribor
   ```

   The CLI refuses an existing target. If the configured source database exists, it runs `mysqldump` first and refuses to proceed if backup fails. Backups must be outside the web root. It never drops tables or resets old rows. It creates the target schema, applies migrations, and inserts exactly one administrator with no audit or work fixtures. It does **not** rewrite `.env`.
6. Set `.env` `DB_NAME` to that target and give this installation a unique `SESSION_COOKIE_NAME`. Then verify **before logging in**:

   ```powershell
   C:\xampp\php\php.exe bin/migrate.php
   C:\xampp\php\php.exe bin/verify_fresh.php
   ```

   Migrations are CLI-only and tracked. Rerunning them changes no work data. The verifier requires one initial administrator and zero other application records. After legitimate logins, reviews, uploads or security events, it is expected to report nonempty tables; do not delete real activity to make it pass.
7. Open [local login](http://localhost/vostokpribor_AI/login.php). Initial identifier: `admin`; initial password: `admin`. Complete the mandatory change-password page before opening a workspace. Choose a different password of 12–72 characters. The old password must verify; a successful change hashes the new password and rotates the session and CSRF token.

The weak initial credential is accepted only in local/development/testing environments with direct loopback client/server addresses, a loopback configured URL, a strict loopback Host and no forwarding headers. It is rejected in production and behind a public proxy. Use direct XAMPP localhost for initial rotation.

Alternative one-time commands for an already migrated, completely empty schema:

```powershell
C:\xampp\php\php.exe bin/create_local_super_admin.php --confirm-local-dev
```

This refuses **any existing application records** and cannot reset an administrator. For a new production schema, use `bin/bootstrap_admin.php --email=you@example.com --name="Administrator" --identifier=admin` and supply a strong password through stdin. This also provisions only once and requires password rotation. Do not run both initializers against the same schema.

## Current local installation

The delivered workspace `.env` selects `vostok_range_20261026_fresh`. The original `vostokpribor_ai` remains intact, backed up outside the web root. Exactly one administrator and zero work records were verified at initialization. A subsequent real failed login produced one actual audit event; it was preserved. Full pre-use and post-use observations are in `verification/`.

Local secrets and user data are not bundled in the release ZIP. Do not import `database/vostokpribor_ai.sql`; it is a protected old-data backup, excluded from the ZIP and unrelated to the schema migration runner.

## Student workflow

1. Administrator opens SYS-05 **Student Management** and creates an active student with a unique identifier/email and a secure 12–72 character initial password. Public registration does not exist. The student must rotate this password on first login.
2. In **Tickets & Scenarios**, create and save a scenario through the ten-step builder. Only a successful authenticated API write adds a card. Reloading reads MySQL. All scalar controls, workflow stages and actual dataset references are saved in typed JSON metadata.
3. Create a ticket with requirements, acceptance criteria, priority and deadline. Assign it to the intended active student using the ticket/scenario assignment interface.
4. Upload a real CSV or JSON master dataset in SYS-02 **Dataset Catalog** or SYS-05 **Dataset Management**. Assign the dataset to the same student and ticket. Ticket assignment must exist first.
5. Student opens SYS-01 and SYS-02 and sees only assigned work. Start/resume the ticket, save comments, and inspect/download the actual assigned dataset.
6. In **Upload Processed Data**, select the assigned master dataset and ticket, provide transformation notes, and upload a real CSV/JSON file. Both assignments are checked together by the server.
7. In SYS-03 **Notebook Workbench**, explicitly create a notebook. Add cells, edit code and click Save Notebook. Reloading preserves the saved source. Page visits do not create notebooks or cells. Outputs cannot be forged by the editor.
8. In SYS-04 **Model Registry**, register metadata. This creates no artifact version or fake file. Optionally upload an actual nonempty artifact as an immutable version. Files are opaque private bytes; an extension is not a safety or quality certificate.
9. A permitted artifact-check/evaluation request checks stored-file integrity. Without a trusted evaluator, its overall result is `NOT_EVALUATED`, with no quality score. Student-supplied accuracy/latency JSON cannot pass validation. Deployment and inference remain unavailable.
10. In SYS-01 **Ticket Details**, submit notes and optional owned notebook/model references for that same ticket. Administrator reviews the actual submission in SYS-05 **Workspace Configuration**. Requests for changes permit a new iteration; approval updates the ticket. Feedback and real notifications persist for the student.

Scenarios start in `DRAFT`. Supported transitions are `DRAFT → READY_FOR_REVIEW → PUBLISHED → ACTIVE → COMPLETED`. Each state can be archived; `ARCHIVED → DRAFT`, `READY_FOR_REVIEW → DRAFT`, `PUBLISHED → DRAFT`, `ACTIVE → PUBLISHED`, and `COMPLETED → ACTIVE` are supported. Published rubric weights must total 100. Publication and requested environment controls describe the work; they do not provision servers or ACL services.

Scenario duplicate creates a new unique COPY code. Export reads persisted records. Import creates drafts, preserves existing records and reports how many records persisted if a later import entry fails; it is not an atomic bulk replacement.

## API map

Base: `/vostokpribor_AI/api/v1/`. Responses use `{success,data,message}` or `{success:false,error:{code,message}}`. Cookie sessions are required. First GET `auth/csrf`, retain the cookie, then send `X-CSRF-Token` for **every mutation, including login**. Login and password change return a rotated token. Incorrect/missing/malformed tokens are 403. HTML POST forms use the same session-bound policy.

| Routes | Access and behavior |
| --- | --- |
| GET `auth/csrf`; POST `auth/login` | Session token acquisition and login; login body `login,password` |
| GET `auth/me`; POST `auth/change-password`; POST `auth/logout` | Authenticated; password change body `current_password,new_password` |
| GET/POST `users`; GET/PATCH `users/{id}` | Administrator manages students; student may read their own dossier; no public registration |
| GET/POST `scenarios`; GET/PATCH `scenarios/{id}` | Administrator catalog/CRUD; create uses `code,title`, optional `builder_metadata`; lifecycle enforced server-side |
| GET/POST `tickets`; GET/PATCH `tickets/{id}` | Administrator creates/edits; student reads assigned tickets and can transition assigned/changes-requested work to IN_PROGRESS |
| POST `tickets/{id}/assignments`; POST `tickets/{id}/comments` | Administrator assigns `student_id`; assigned student/admin may comment |
| GET/POST `datasets`; GET `datasets/{id}`, `/preview`, `/download` | Admin uploads multipart `dataset_file`; students see assigned datasets only |
| POST `datasets/{id}/assignments`; POST `datasets/processed` | Admin assigns `student_id,ticket_id`; student uploads `processed_file,source_dataset_id,ticket_id` |
| GET/POST `notebooks`; GET/PATCH `notebooks/{id}` | Explicit creation with `title,ticket_id?,cells?`; save with `cells:[{cell_type,source}]`; ownership enforced |
| POST `execution-jobs`; GET `execution-jobs/{id}`; POST `execution-jobs/{id}/cancel` | Execution submit returns 503; existing job reads/cancellation require ownership; terminal states cannot be cancelled |
| GET/POST `experiments`; GET/POST `experiment-runs` | Owned experiment metadata; user run records are RECORDED, not proof of executed work |
| GET/POST `models`; GET `models/{id}`; POST `models/{id}/versions` | Register `model_code,name,framework,ticket_id?`; actual artifact multipart field `artifact_file`, required `version` |
| POST `validation-runs`; GET `validation-runs/{id}` | Owned `model_id,model_version_id`; absent/corrupt artifact rejected; no trusted measurements means NOT_EVALUATED |
| GET `deployments`; POST `deployment-requests`; PATCH `deployments/{id}` | Scoped reads; no provider/evidence means request/decision cannot fabricate a deployment or endpoint |
| GET/POST `submissions`; GET `submissions/{id}`; POST `submissions/{id}/review` | Student submits assigned work; admin review uses `status,feedback,total_score?`; latest iteration only |
| GET `admin/overview`, `admin/audit-logs`, `admin/settings`; PATCH `admin/settings` | Administrator only; measured database/count data, no invented external-service health |

Legacy `api/models.php` is authenticated/scoped; `api/exchange.php` and `api/status.php` require administrator access. Status checks database connectivity; it does not certify workers, GPUs or serving endpoints. Unowned object reads generally return 403/404; unauthorized mutations return 403; validation errors are 422; unavailable execution/deployment is 503.

## Roles, storage and execution boundaries

- ADMIN manages students, scenarios, tickets/dataset assignments and reviews. STUDENT sees assigned tickets/datasets and owned notebooks/experiments/models/submissions. Object references are checked for ownership and ticket consistency. Students cannot access SYS-05 or grant roles.
- `storage/private/datasets/` stores real master/processed file bytes; MySQL stores ownership, assignment, metadata, path, checksum and file-derived dimensions. CSV requires unique nonempty headings and consistent row widths. JSON requires a list of consistent row objects.
- `storage/private/models/` stores genuine uploaded artifact bytes. Registration alone does not create a model version. Upload errors and database failures remove only the newly created file belonging to the failing request.
- Private files cannot be requested directly through Apache. Authorized dataset download/preview endpoints enforce assignments and verify checksums. Preserve root and private `.htaccess` files and all storage directories. Real uploads survive navigation, migrations, service restarts and packaging.
- `storage/private/sandboxes/` is retained for future infrastructure; no host code runner is enabled. Both `workers/python_worker.py` and `bin/worker_bridge.php` exit unavailable. No environment switch can enable the removed `subprocess.run` path.
- A future runner needs independent restricted credentials, filesystem/network isolation, CPU/memory/process limits, authenticated artifact-bound results and verified runtime cancellation. Trusted evaluation must bind measurements to actual artifact and dataset checksums. A verified serving provider is required before real deployment URLs may be exposed.
- GPU/SLA/latency/quality graphs display unavailable states until genuine trusted measurements exist. Query Workspace executes no SQL; uploaded-file preview remains available.

## Tests and evidence

[Verification report](VERIFIED_COMPLETED_FEATURES.md) links actual logs: 344 passing functional/security/package checks, 157 syntax checks, recursive source audit and real browser observations. The final HTTP acceptance suite exercised XAMPP, not PHP's development server. Earlier failed attempts are retained with their fixes explained.

Mutating tests **must never run on the fresh/user database**. For a new test run choose another unused `_test` database. Keep Apache pointed at that same testing configuration while HTTP tests run:

```powershell
# The installer backs up the configured source first; it does not reset it.
$env:APP_ENV = 'testing'
C:\xampp\php\php.exe bin/install_fresh.php --database=vostok_range_next_run_test --confirm-local-dev --backup-dir=C:/Users/nijim/.codex/backups/vostokpribor
Remove-Item Env:/APP_ENV
# Edit local .env: APP_ENV=testing, DB_NAME=vostok_range_next_run_test,
# and use a distinct SESSION_COOKIE_NAME. Apache must read these values too.
C:\xampp\php\php.exe bin/verify_fresh.php
C:\xampp\php\php.exe tests/security_unit.php
C:\xampp\php\php.exe tests/database_security.php
C:\xampp\php\php.exe tests/scenario_contract.php
C:\xampp\php\php.exe tests/model_integrity.php
python tests/http_workflow.py
python tests/http_empty_pages.py
python tests/http_readonly_security.py
python tests/package_policy.py
python bin/audit_source.py
```

The HTTP workflow expects a new test database with its initial local administrator, rotates random test credentials, and leaves actual test work in that database. It is intentionally not a reset/reseed utility. It writes temporary browser-test credentials outside the web root under the current user's `.codex/backups/vostokpribor/`; these are not packaged. The contract/security/integrity database suites roll their rows back. Restore the real `.env` and its distinct cookie after testing. An application connection with `APP_ENV=testing` refuses a database name that does not end `_test`; the tests add their own guards.

## Source release packaging

`bin/package_release.py` creates a ZIP outside the source tree and never deletes/moves user files. Before real work begins, capture old runtime paths/hashes outside the repository:

```powershell
python bin/package_release.py --snapshot-old C:/xampp/vostokpribor_release/old-runtime-files.json
```

For test artifacts, create an exact path/hash inventory through `tests/collect_artifacts.php` while explicitly configured for the corresponding `_test` database. It accepts a `vostok_range_YYYYMMDD_` prefix and reads that run's testing schemas only. Do not classify real uploads as test files.

```powershell
C:\xampp\php\php.exe tests/collect_artifacts.php vostok_range_20261026_ | Set-Content -Encoding utf8 C:/xampp/vostokpribor_release/test-artifacts.json
python bin/package_release.py --build C:/Users/nijim/.codex/artifacts/vostokpribor-ai-release.zip --old-inventory C:/xampp/vostokpribor_release/old-runtime-files.json --test-artifacts C:/xampp/vostokpribor_release/test-artifacts.json
```

The ZIP omits `.env`, bundled `.git`, the old SQL data dump, unchanged inventoried old runtime files, exact unchanged test artifacts, caches/debug logs and retired fixture helpers. It preserves storage roots, `.htaccess`, `.env.example`, schema/migrations, current tests and verification evidence. New/unknown or modified real uploads are retained and listed in the external manifest rather than silently omitted. The builder refuses existing output filenames and verifies archive integrity. Separate SQL backups stay outside the source ZIP.

## Deployment and troubleshooting

Public deployment is not certified. Use HTTPS, `APP_ENV=production`, `APP_DEBUG=false`, `SESSION_SECURE=true`, a restricted application DB account, protected private storage, tested backups and a rotated strong administrator password. Run migrations using a separately privileged CLI identity. Never publish the authorized local default credential. Under Nginx or another server, reproduce the Apache private-path denial rules explicitly; `.htaccess` alone provides no protection there. Execution/inference remain unavailable regardless of environment.

- **Database unavailable:** check MySQL service, explicit database name/credentials and `pdo_mysql`. An installer target must not exist; choose a new name instead of deleting an existing schema.
- **API 404:** check Apache rewrite/AllowOverride and the `/vostokpribor_AI/api/v1/` base. Do not use the PHP development server as evidence of the XAMPP configuration.
- **403 CSRF:** reload the form or GET `auth/csrf` with the same cookie session; use the rotated token after login/password change. Separate admin/student tests by hostname/browser profile to avoid sharing session rotation.
- **403 PASSWORD_CHANGE_REQUIRED:** complete the real password change with the current initial credential. Admin/admin is refused with public Host, forwarding headers, nonloopback access or production environment.
- **No datasets/tickets:** check both master dataset and ticket assignments for the same student. Empty states are intentional; no fixture import is needed.
- **Missing dataset or artifact:** check its private file and recorded checksum. Do not create dummy bytes to replace a missing artifact. A model with metadata only cannot validate or deploy.
- **Execution/quality/deployment unavailable:** expected until verified external infrastructure exists. Changing Python paths or recording user metrics cannot enable it.
- **Empty verifier fails after use:** inspect real records/audit events. Preserve them. The verifier is for a pristine installation, not a cleanup command.
- **Previous patch/test scripts exit 78:** they are retired and cannot repopulate old data. Use the current migration runner and guarded suites.
