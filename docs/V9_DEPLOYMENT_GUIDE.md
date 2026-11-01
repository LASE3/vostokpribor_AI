# V9 Windows/XAMPP deployment and recovery guide

This release is verified for a controlled localhost demonstration. The observed host is Windows11, PHP8.2.12, Apache2.4.58 and MariaDB10.4.32. Those installed patch levels are not approved for public deployment. Rehearse vendor-supported, patched runtimes/database, HTTPS and the full suite in an independent staging environment before public exposure. No global XAMPP upgrade or public deployment was performed.

## Fresh local installation

1. Start Apache/MySQL using XAMPP. Enable pdo_mysql, mbstring, fileinfo, zip and OpenSSL. Apache must load mod_rewrite and allow the supplied .htaccess rules (`AllowOverride All`). Keep the local host/mount restricted to loopback.
2. Extract the source ZIP into a **new** `C:\xampp\htdocs\vostokpribor_AI` installation directory, or another explicit URL path. Source ZIPs contain no .env, Git history, SQL data dump, private payload or prior test output. Storage directories and control .htaccess files are retained. Never import an old bundled dump.
3. Copy .env.example to .env manually. Set APP_ENV=local, APP_DEBUG=false, APP_URL to the exact loopback installation URL and explicit MySQL host/port/operator credentials. If preserving an existing configured database, keep it selected until its backup is verified. Choose a new target database name; the initializer refuses existing targets.

```powershell
Set-Location C:\xampp\htdocs\vostokpribor_AI
Copy-Item .env.example .env  # only in a genuinely new tree; never overwrite an existing .env
& C:\xampp\php\php.exe bin\install_fresh.php --database=vostok_range_local_new_name --confirm-local-dev --backup-dir=C:\Users\YOUR_USER\.codex\backups\vostokpribor
```

The installer preserves the configured older database, backs it up outside webroot if it exists, creates the newly named schema, applies eight migrations and initializes exactly one administrator. After inspecting the result, explicitly change .env DB_NAME to the new name. It never switches configuration itself. `bin/create_local_super_admin.php --confirm-local-dev` is an alternative one-time initializer for an already migrated **empty** local database; do not run both initializers expecting a second account.

```powershell
& C:\xampp\php\php.exe bin\verify_fresh.php
```

Before any login/action, expect one ADMIN (identifier admin), password_hash verifying the authorized localhost initial password admin, must_change_password=1, and zero work/audit/notification records. Login and complete change-password.php; a genuine password rotation changes the hash/session generation and is audited. The weak initial password is restricted to loopback and cannot authenticate over a public request. There is no public registration. Students are created by the administrator in SYS-05 with strong passwords and mandatory initial rotation.

For an empty non-development installation use `bin/bootstrap_admin.php --email=YOUR_ADDRESS --name="Administrator" --identifier=admin`, entering a strong12–72-byte password on stdin. Do not use the local weak-password initializer for public deployments. Existing administrator credentials are never reset by migrations or service startup.

## Existing installation update

Take and verify a combined encrypted backup during a quiet window before migration. Rehearse restore/migration on a newly named isolated `_test` database first. Preserve .env and every existing upload, then deploy source and run the CLI migrator with the operator identity:

```powershell
& C:\xampp\php\php.exe bin\migrate.php
```

There is no web migration/seed route and no migration on GET/JS load/startup. Migration008 is additive; it does not drop tables or promote historical metrics. Keep migration credentials out of the web runtime after the CLI operation.

## Runtime MySQL account

Use a different localhost runtime account with SELECT, INSERT, UPDATE and DELETE on the **exact** application database only. Escape underscores/percent in GRANT database patterns, including inside backticks. Do not grant CREATE/ALTER/DROP/FILE/process/global privileges or GRANT OPTION to the HTTP runtime. Use an independent operator identity for migration/backup operations. Test actual grants and source-database/DDL denials; a non-root name alone is insufficient. Staging proves this arrangement through real HTTP work. Main credentials were deliberately preserved rather than silently replaced.

For production set APP_ENV=production, APP_DEBUG=false, an actual HTTPS APP_URL, SESSION_SECURE=true and restricted nonblank database credentials. The web server must indicate real HTTPS; client forwarding headers are not trusted. Hardened hosting, patch compatibility, secrets custody, backup scheduling, monitoring and public acceptance remain deployment gates.

## Combined backup and isolated restoration

Run backup from the source tree. Pass a separate recovery passphrase privately via stdin JSON, never a process argument:

```powershell
$recoverySecret = Read-Host 'Recovery passphrase, at least24 bytes' -AsSecureString
$recoveryText = [System.Net.NetworkCredential]::new('', $recoverySecret).Password
@{ backup_password=$recoveryText } | ConvertTo-Json -Compress | & C:\xampp\php\php.exe bin\backup_range.php --output=C:\Users\YOUR_USER\.codex\backups\range-new-snapshot.zip
Remove-Variable recoveryText,recoverySecret
```

Backup refuses overwrite, webroot destinations and concurrent data/file/configuration changes. Store the encrypted archive and key separately; keep protected off-site copies for real operations. This source ZIP is not a data backup.

For an actual drill, extract matching code/migrations into a new code-only tree without .env. Prepare a distinct DML-only runtime user scoped to an **absent** target database ending `_test`. Run the source tree's `bin/restore_range.php --archive=ABSOLUTE_ARCHIVE --target-root=NEW_CODE_TREE --database=NEW_NAME_test` with stdin JSON containing backup_password, runtime_user, runtime_password, loopback app_url and a separate session_cookie ending `_test`. The tool creates only that new database, verifies exact row/file/migration fingerprints, checks actual grants and activates separate test configuration. It refuses existing data/configuration. Upgrade the restored schema only after this proof. Automatic production-target restoration is intentionally unsupported; use a reviewed operator procedure.

Measured local restore→HTTP readiness was1.852seconds for the tested small main snapshot. No recurring backup/PITR system exists, so operational RPO remains the last manual snapshot. Production RPO/RTO require an agreed cadence, off-site/key recovery and repeated timed drills.

## Workflow and availability

All five launch links and system directories open Dashboard first. In SOC create students, scenarios and tickets; upload genuine CSV/JSON master files and explicitly assign both ticket and immutable dataset version. Students see only authorized work, upload processed files with lineage, explicitly create/save notebooks, record experiment metadata, register/upload model artifacts, request review and submit. Administrator decisions persist and update student feedback/ticket states.

Execution is disabled in HTTP and both worker entries. Metadata runs are USER_REPORTED; legacy provenance is UNKNOWN. Student metrics cannot establish quality. Missing trusted evaluation is NOT_EVALUATED. Deployment approval is administrative and has no live endpoint. A restricted dataset SQL engine is also unavailable. None can be enabled merely by setting an environment flag; independently reviewed services/resources/credentials and adversarial acceptance tests are required.

## Tests and troubleshooting

Mutating tests require APP_ENV=testing, a dedicated `_test` database, separate storage/cookie and private credentials outside source/webroot. Never aim a test suite at the user installation. Source tests are guarded and create uniquely named work; no fixture import is needed. See V9_TEST_RESULTS.md for actual commands/results, suite naming restrictions, deliberate negative statuses and limitations.

For Apache404 ensure the correct installation URL, mod_rewrite, AllowOverride and the supplied API rewrite; `/api/v1/auth/csrf` returns JSON200 anonymously. Registered protected routes reach401/403 before ownership checks rather than Apache404. A missing/unauthorized object may intentionally return403/404. Deployment under a directory requires the exact APP_URL and current cache-revised assets. Wrong CSRF/origin must fail403; do not weaken those controls to fix a request. Generic500 calls for operator logs/configuration inspection, not enabling public debug output. Initial password rotation redirects are expected. A corrupt mysql privilege index requires a verified system-table backup and reviewed repair, not replacement of the data directory.
