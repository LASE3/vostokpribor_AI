# V10 Windows/XAMPP installation, Colab use and deployment guide

This release targets the existing plain-PHP/PDO platform and its approved five-system design. The current operating choice is manual Google Colab notebook code exchange without a Google Cloud project. Live Enterprise execution, trusted evaluation and inference serving are unavailable. This guide does not authorize a public deployment or claim that final source packaging/staging checks have already passed; read the final V10 test/release report for observed outcomes.

## New localhost installation

1. Start Apache/MySQL in XAMPP. PHP needs pdo_mysql, mbstring, fileinfo, JSON, sessions, zip and OpenSSL; curl is additionally required only for the optional explicit Google credential/template probe. The application has no Python or Node runtime requirement for saving notebooks. Apache must load mod_rewrite and permit the supplied .htaccess rules (`AllowOverride All`). Restrict the development host to loopback.
2. Extract the source ZIP into a **new** installation directory such as `C:\xampp\htdocs\vostokpribor_AI`. Never overwrite an existing .env or uploads. Source installation does not require an old SQL dump or fixtures.
3. Copy .env.example to .env only in this new tree. Set APP_ENV=local, APP_DEBUG=false, the exact loopback APP_URL, explicit DB_HOST/DB_PORT/DB_USER/DB_PASS, a unique DB_NAME and SESSION_COOKIE_NAME. Leave COLAB_CONFIG_FILE empty for the current manual workflow. Do not place Google secrets in .env, source or browser settings.

```powershell
Set-Location C:\xampp\htdocs\vostokpribor_AI
Copy-Item .env.example .env  # only in a new tree; edit before continuing
& C:\xampp\php\php.exe bin\install_fresh.php --database=vostok_range_local_unique_name --confirm-local-dev --backup-dir=C:\Users\YOUR_USER\.codex\backups\vostokpribor
```

The CLI refuses existing targets. It backs up a configured older database outside webroot when present, creates only the newly named target, applies **eight migrations** and creates exactly one ADMIN identifier admin with the authorized initial local password admin, password_hash and must_change_password=1. No student/work/audit records are seeded. V10 code exchange/role separation requires **no ninth migration**. The installer never switches .env automatically: explicitly select the new DB_NAME after reviewing output, then verify before any login/action:

```powershell
& C:\xampp\php\php.exe bin\verify_fresh.php
```

Expect one active ADMIN and zero every other non-migration table. Login and complete the genuine password-change flow. The weak initial credential is accepted only on an explicitly local loopback development request, never public hosting. Existing credentials are not reset by service startup or migrations. There is no public registration.

For an already migrated **empty** local schema, `bin/create_local_super_admin.php --confirm-local-dev` is an alternative one-time initializer; do not run both expecting another account. For an empty non-development schema, use an independent operator-created schema, migrate it and run `bin/bootstrap_admin.php --email=YOUR_ADDRESS --name="Administrator" --identifier=admin`, providing a strong12–72-byte password privately on stdin. Do not bootstrap a public site with admin/admin.

## Role-specific operation

After required rotation, ADMIN enters AI Operations Center (AI SOC)/Dashboard.php directly. The root portal also redirects ADMIN there. Perform all account/ticket/dataset/student-workspace/model/submission administration inside SOC. Administrator requests to student HTML systems return403; legitimate shared backend inspection privileges are retained.

STUDENT enters index.php and sees exactly four student systems. No SOC launcher, hidden SOC menu or administrator destination is rendered. Direct protected SOC page/API access returns403. The shared header/sidebar, notifications/profile and Sign Out remain. Password rotation uses the role destination; arbitrary login return parameters cannot cross applications. [Role matrix](V10_ROLE_ACCESS_MATRIX.md).

In SOC create students with strong temporary passwords, save scenarios and real ticket requirements/deadlines, upload genuine CSV/JSON master datasets and explicitly assign ticket/immutable version grants. Students see only authorized work, upload processed data with lineage, save notebooks, record manually reported experiments, register optional real model files and submit. SOC decisions persist and update the student's ticket/feedback. No administrator needs to enter a student interface to manage this workflow.

## Use Google Colab now: explicit notebook code exchange

1. Student opens ML Workbench, explicitly creates/selects an owned notebook and saves code.
2. Choose **Download for Colab**. The application downloads the saved .ipynb privately; it does not include saved execution output or transfer anything to Google.
3. Choose **Open Google Colab**, sign in separately as appropriate and use Colab's own notebook-upload workflow. The application does not scrape that account's cookies or lend a shared runtime identity.
4. Decide separately whether any data may be shared with Google. An application dataset assignment is not blanket permission for external transfer. No dataset is automatically copied or linked to Colab by this release.
5. After working in Colab, download its .ipynb using Google's interface. Back in ML Workbench, choose **Import Colab notebook**, supply a new title/authorized ticket and upload the file. This explicit POST creates a new owned notebook rather than replacing old work.

Import supports IPYNB version4, at most2MiB, up to200 code/markdown cells and256KiB source per cell. It discards outputs, execution counts, attachments and ownership/provenance metadata. Reload to verify persisted code. Import/export is not verified remote execution or trusted evaluation. The application still shows unavailable execution and does not display a fabricated cloud job, GPU, score or successful runtime result.

Private API exchange uses GET workbench/notebooks/{id}/export and POST workbench/notebooks/import (multipart notebook_file plus title/ticket_id). SOC inspection can export through GET soc/notebooks/{id}/export. Authentication, ownership and CSRF rules remain unchanged; [API_REFERENCE.md](../API_REFERENCE.md) has exact contracts.

## Optional prepared Enterprise configuration

No configuration is necessary for manual exchange. The prepared adapter does **not** enable execution when configured. If a future authorized operator wants to inspect readiness, put its JSON configuration in an absolute file outside source/webroot and point COLAB_CONFIG_FILE to that path. Never add the JSON or credentials to Git or release packages.

The validated fields are project, location, runtime_template, output_bucket, credentials_file, optional integer timeout_seconds (30–1800, default600), and execution_service_accounts mapping each student ID to a unique execution service-account identity. The template must belong to the configured project/region; final request-body size is bounded after encoding. These are request-shape checks, not IAM/template/isolation acceptance. Credentials must also be explicit private files outside source/webroot. Supported credential formats are validated authorized-user refresh credentials or RSA service-account credentials; this code does not implement an end-user Google connect/consent screen or workload-identity provisioning.

```powershell
# Read-only local availability; expected exit78 while unavailable.
& C:\xampp\php\php.exe bin\colab_preflight.php
# Only with an explicitly authorized project and protected credentials:
# refresh token as needed, GET configured template, never submit code or datasets.
& C:\xampp\php\php.exe bin\colab_preflight.php --probe-google
```

The probe may call Google's OAuth endpoint and read the configured runtime template. A failed/absent setup prints sanitized status. Even success leaves can_execute=false, isolation_verified=false and live_execution_tested=false; exit78 remains intentional. No HTTP parameter or environment activation flag bypasses the provider gates. No real Google authentication or provider-backed execution has been accepted in the current release.

Before any future execution activation, obtain the user's explicit project/account authorization, enabled APIs, accepted billing/budget/quotas and eligible region. Review independent student IAM/filesystem/network/metadata boundaries, runtime credentials, no-public-internet/end-user-credential settings, result storage, timeouts, cancellation and cleanup with actual adversarial tests. Enterprise DELETE is not presumed to cancel running code. Do not deploy a host subprocess runner while waiting. [Official provider research](V10_COLAB_RESEARCH.md).

## Database runtime identity and existing installations

Use an independent runtime SQL account with only SELECT/INSERT/UPDATE/DELETE on the exact schema; retain a separate migration/backup operator. Escape underscores/percent in GRANT schema patterns even inside backticks. Verify actual grants, DML, denied DDL and denied source-schema access. Do not broaden the runtime account merely because a fault-injection test needs CREATE TRIGGER.

For existing installations preserve .env and every genuine upload, take a combined verified backup, restore into a newly named isolated `_test` tree and rehearse upgrades before changing schema. Run `php bin/migrate.php` with the operator identity only when needed. V10 itself adds no schema migration. The existing source main credentials/configuration are intentionally not silently changed or upgraded. A pristine verifier is not a cleanup command: real operational audits/rate rows must not be erased after use.

The V9 source baseline had one administrator/zero work,18 legitimate audits,5 rate records and52 original private files. V10 mutating tests belong only to isolated schemas/storage/cookies; final source preservation is checked separately in V10 evidence. No student_test account or fixtures may be inserted into main by installation, navigation, JS or test startup.

## Backup and recovery

Database rows and private file bytes are separate persistence layers. Use the existing combined encrypted backup during a quiet window, keeping its recovery key separately protected:

```powershell
$recoverySecret = Read-Host 'Recovery passphrase, at least24 bytes' -AsSecureString
$recoveryText = [System.Net.NetworkCredential]::new('', $recoverySecret).Password
@{ backup_password=$recoveryText } | ConvertTo-Json -Compress | & C:\xampp\php\php.exe bin\backup_range.php --output=C:\Users\YOUR_USER\.codex\backups\range-new-snapshot.zip
Remove-Variable recoveryText,recoverySecret
```

The tool refuses overwrite, webroot output and concurrent data/file/config changes. A source ZIP is not this data backup. Restore drills use matching code/migrations in a new code-only tree without .env/payloads, a newly named absent `_test` schema and separate exact-DML runtime identity. `bin/restore_range.php --archive=ABSOLUTE_ARCHIVE --target-root=NEW_CODE_TREE --database=NEW_NAME_test` receives stdin JSON with backup_password, runtime_user, runtime_password, loopback app_url and distinct session_cookie ending `_test`. Existing targets are refused; original credentials are not activated. Follow the [verified V9 recovery procedure](V9_DATABASE_VERIFICATION.md) and final V10 recovery evidence. No recurring/off-site/PITR service is claimed; production RPO/RTO need agreed cadence, key custody and repeated timed drills.

## Testing and build

Pure tests may run without a database: system_access_v10.php, colab_contract_v10.php, google_auth_v10.php and the retained security/client/tool suites. Verify the actual names/results in V10_TEST_RESULTS.md. Credential-contract tests use synthetic material, not real Google accounts. No provider test success should be inferred from a mocked transport.

Mutating tests require a **separate source tree** with a saved APP_ENV=testing .env, a newly named `_test` schema, its own private storage, exact loopback APP_URL and separate cookie ending `_test`. Never change main's .env or select its storage with process-only overrides. Run the new-target initializer/verifier before HTTP. File-writing PHP suites require `php tests/prepare_storage.php` while private payload directories are empty; the marker binds the exact tree/database and is excluded from releases. HTTP suites check CLI identity and actual cookie before credentials; TEST_CREDENTIALS_FILE stays outside source/webroot and maps credentials to that exact test DB.

The role suite explicitly provisions student_test and a second student through secure APIs only in that test database; passwords are generated, rotated and kept out of logs/source/screenshots. Existing trigger-based fault-injection suites require a separate operator test configuration. They must refuse against the DML-only runtime rather than weakening production privileges. Failed-login/admission suites run last and respect natural429 expiry.

Compiled local CSS ships. Node/Tailwind3.4.17 is build-only; when templates change, run npm ci, npm run build:css, npm run check:css and npm run test:assets, then inspect the existing desktop/mobile design. Source packaging uses `python bin/package_release.py --build ABSOLUTE_NEW_ZIP_OUTSIDE_WEBROOT`, preserves eight migrations/layout/storage controls and excludes .env/history/dumps/private bytes/caches/logs/credentials/test output. Final CRC/hash/extraction/staging evidence belongs in the release report; it is not pre-asserted by this guide.

## Public deployment gate and troubleshooting

The observed PHP8.2.12/Apache2.4.58/MariaDB10.4.32 host is not approved for public production. Rehearse maintained patched runtimes/database, HTTPS, APP_ENV=production, APP_DEBUG=false, SESSION_SECURE=true, strong rotated credentials, exact-schema runtime identity, secrets custody, protected storage, monitoring, backup operations and representative sustained load on independent staging first. Trusted webserver HTTPS is required; client forwarding headers do not establish it. No global runtime upgrade or public cutover was performed.

| Symptom | Check |
|---|---|
| API404 | Exact APP_URL/subdirectory, mod_rewrite, AllowOverride and supplied rewrite rules. Anonymous auth/csrf should return JSON200; missing/unauthorized object403/404 is intentional. |
| ADMIN student page403 / STUDENT SOC403 | Expected role boundary. ADMIN uses SOC; STUDENT uses the four-system portal. |
| Password-change redirect | Complete actual rotation before business access; do not remove the gate. |
| CSRF/origin403 | Same cookie/token, refreshed after login/rotation, and correct configured origin. |
| Notebook import422 | Real .ipynb, valid UTF-8 version4 JSON, bounded file/cell sizes, supported code/markdown cells and valid owned ticket. |
| Imported output missing | Expected: only code is imported; execution/quality claims are discarded. |
| Colab unavailable / preflight78 | Expected without accepted project/provider. Configuration and successful template reads cannot activate execution. |
| Google probe failure | Protected credential path/format, curl/OpenSSL/TLS CA setup, authorized OAuth/IAM/template. Never disable certificate verification or print tokens. |
| No assigned data | Verify active ticket and student/ticket/immutable-version dataset grant; do not import fixtures. |
| Missing artifact | Inspect genuine bytes/checksum and verified backup; do not create fake replacement files. |
|429 | Respect Retry-After; never clear shared admission rows to force a passing test. |
| Fresh verifier fails after use | Inspect retained real history. Never delete audit/work records to recreate a pristine result. |
