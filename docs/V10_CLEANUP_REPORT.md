# V10 source cleanup report

Audit date:2026-11-01. Source `C:/xampp/htdocs/vostokpribor_AI`, branch main, baseline13ae511. Scope: current application classes/assets/build/runtime references and the exact retired entry stubs listed below. No user uploads, database rows, .env, migrations or historical verification reports were deleted. Existing Git history was preserved.

## Verified removals

Removed **25 tracked exit-only retired stubs**, **4,711 bytes / 92 source lines**. Their entire bodies were inspected before removal, not inferred from filenames: the PHP patchers only checked CLI, printed a retirement message and exited78; Python patchers only raised SystemExit with a retirement message; the four old fixture entry points only printed retirement and exited78. None contained a migration, SQL, file write, current test assertion or business operation.

| Removed file | Bytes | Lines |
|---|---:|---:|
| `bin/patch_ai_soc_dashboard.py` | 150 | 2 |
| `bin/patch_ai_soc_dataset_management.php` | 185 | 4 |
| `bin/patch_dashboard_metrics.php` | 185 | 4 |
| `bin/patch_data_center_pages.php` | 185 | 4 |
| `bin/patch_data_center_processed.py` | 150 | 2 |
| `bin/patch_dataset_catalog.php` | 185 | 4 |
| `bin/patch_ml_workbench.php` | 185 | 4 |
| `bin/patch_ml_workbench.py` | 150 | 2 |
| `bin/patch_ml_workbench_clean.py` | 150 | 2 |
| `bin/patch_model_registry.php` | 185 | 4 |
| `bin/patch_model_registry.py` | 150 | 2 |
| `bin/patch_my_datasets.php` | 185 | 4 |
| `bin/patch_project_dashboard.php` | 185 | 4 |
| `bin/patch_soc_dataset_mgmt.php` | 185 | 4 |
| `bin/patch_student_profile.php` | 185 | 4 |
| `bin/patch_submissions_audit.php` | 185 | 4 |
| `bin/patch_submissions_page.php` | 185 | 4 |
| `bin/patch_telemetry_claims.py` | 150 | 2 |
| `bin/patch_ticket_details_body.php` | 185 | 4 |
| `bin/update_ticket_details.php` | 185 | 4 |
| `bin/update_tickets_page.php` | 185 | 4 |
| `tests/test_audit_fixes.php` | 259 | 5 |
| `tests/test_full_platform.php` | 259 | 5 |
| `tests/test_inspect_job.php` | 259 | 5 |
| `tests/test_worker.php` | 259 | 5 |

Recovery: each exact source remains in Git commit13ae511 (`git show 13ae511:RELATIVE_PATH`). Per-file SHA256, bytes, classification and recovery commit are retained in protected `verification/v10-20261101/cleanup-audit.json`. These stubs were already excluded from the V9 source ZIP, so this cleanup reduces the checkout's obsolete tools, not the shipped functional application.

## Reference and dependency checks

Before removal, recursive text references were searched across app/api/config/bin/tests/build/package metadata and frontend source, with runtime include/autoload and route dispatch paths reviewed. The only current references to these exact filenames were the release exclusion policy and package_policy.py's isolated synthetic retired fixture. The generic packager exclusion is deliberately retained so reintroduced historical files cannot escape into a release. The package test creates its own temporary fixture and does not require a deleted workspace file. No route/controller/service/build command dynamically loads the deleted bin/tools or retired tests. The autoloader resolves application classes under app, not these script locations.

The app class inventory found66 namespace-qualified class identifiers and **zero duplicate identifiers** at the cleanup inspection point. SHA256 grouping across shared/five-system JS/CSS/SVG/HTML assets found **zero byte-identical groups**. These checks are narrowly scoped: similar-looking assets were not assumed semantically redundant or deleted.

## Intentionally retained

- All eight migration files and actual backup/restore/migration/diagnostic CLIs: required for installation, data preservation and operator recovery.
- Current guarded PHP/Python/JS tests, API contract fixtures and helper probes: called by current regression suites. No filename-based deletion of tests occurred.
- Shared layout/components and both compiled Tailwind CSS targets: the portal and application builds have different templates/themes and are invoked by build_assets.cjs; generated CSS is required at runtime.
- Tailwindcss3.4.17, the only direct build dependency: package.json/build_assets.cjs and production_assets.cjs use it. Node remains build-only. No unsupported dependency removal was invented.
- Compatibility API aliases and redirect pages: executable route contracts and existing bookmarks intentionally support them; aliasing uses shared services, not a duplicate backend.
- Disabled worker/bridge entry points: truthful unavailable behavior is an explicit security contract, distinct from the removed no-op historical patchers.
- Current V9 documentation and protected evidence: historical verification/procedures remain useful and are superseded explicitly by the final V10 report; no history rewritten.
- All storage/private payloads and even older storage-local development artifacts: private payload ownership was not inferred from names. Source packaging already omits runtime content while retaining directories/access controls. No upload deletion was authorized by this cleanup.

## Added role regression support

`tests/http_roles_v10.py` uses the existing saved APP_ENV=testing, `_test` database, exact loopback URL and separate HTTP cookie guards **before credentials**. It provisions student_test only through authenticated SOC in that isolated instance, uses random temporary passwords with real rotation, retains credentials only in the private outside-webroot exact-DB mapping and refuses to reset an existing account without its matching credentials. Existing provisioning canonicalizes the stored identifier to STUDENT_TEST; lower-case student_test login is tested through the case-insensitive account lookup. A second unique test student gets separate real work for cross-owner checks.

The suite tests role destinations, exactly four student launch controls, no interactive SOC destinations on student dashboards, direct SOC page/API403, administrator student-page403 with SOC administration preserved, notebook reload, genuine CSV grants, model metadata, submissions/decisions, cross-owner reads/writes, incorrect CSRF, session expiry and logout. It creates no demonstration records in main. No provider execution result is claimed.

`tests/http_system_entry_v7.py` now tests the required V10 destinations with the proper actor, rather than the obsolete V7 five-card administrator launcher. All system directory/Dashboard selection, local asset and shared-backend API checks remain. It adds administrator-root302 and forbidden-role403 checks. `tests/integration_probe.php` expiration mode now permits the exact canonical STUDENT_TEST identity as well as IT-% identities, requires STUDENT role and retains the same CLI/testing/loopback/_test guards. Queue/failure-trigger modes are unchanged.

## Executed checks

- `python tests/package_policy.py`: **31 passed** after deletion. Current guarded tests, eight migrations, layouts/storage controls remain; obsolete fixture stubs stay excluded. The suite used its own temporary filesystem and accessed no application database.
- Python AST parse of `tests/http_roles_v10.py`: **PASS**, without importing/running HTTP code or emitting bytecode.
- Main-target negative check: **PASS**; suite refused local/non-test configuration during CLI identity preflight, before database connection, credentials or any HTTP write. Protected proof: role-target-refusal.json.
- Actual `http_roles_v10.py`: **205 checks passed** on `vostok_range_v10_20261101_integration_a_test`, independent root/storage/cookie and DML-only runtime account. The existing secure provisioning contract stores STUDENT_TEST, while lower-case student_test login passes. Independent SQL verifies ACTIVE/STUDENT, password_hash/password_verify and completed mandatory rotation without exporting a hash/password. Logs: http-roles-v10.log; redacted structured proof: role-boundaries.json.
- Updated `http_system_entry_v7.py`: **146 actual role-specific directory/Dashboard/resource/API checks passed** on the same isolated instance; no work rows created by this suite. Log: http-system-entry.log; proof: system-dashboard-entries.json.
- Two earlier driver failures are retained separately: uppercase CODE was correctly rejected422 (the documented cell type is lower-case code), and the old expiration helper correctly refused the newly required canonical test identifier until its narrowly scoped test-only support was added. No records/passwords/quota were reset to force a pass; earlier explicit test work remains in the isolated schema.

No dead active method/event handler was removed without proof. Broad cosmetic reformatting was avoided because it would obscure the reviewed functional/security changes. Cleanup is deliberately limited to verified obsolete files.
