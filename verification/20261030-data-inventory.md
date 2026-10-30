# Data subsystem implementation inventory — 2026-10-30

Scope inspected before backend edits: current worktree at C:/Users/nijim/.codex/worktrees/425e/vostokpribor_AI. No existing database or upload was changed by this audit.

| File | Existing behavior | Defect / planned repair |
| --- | --- | --- |
| app/Services/DatasetService.php | Genuine HTTP CSV/JSON validation, private random filenames/checksums, authorized preview/download, processed upload | Add immutable dataset versions, version-pinned authorization, metadata edit, archive/revoke, active ticket checks, transactional notifications/idempotent assignment; no fake files |
| app/Repositories/DatasetRepository.php | Parameterized master/assignment/processed queries | No version/revocation/archive schema; joins can duplicate dataset entries; old assignments remain authorized after reassignment; add service-backed consistent queries |
| app/Controllers/DatasetController.php | Shared student/admin methods, legacy paths | Missing versions/processed reads/activity/admin metadata/version/revoke/archive APIs; general storage/database errors reported as422; add typed error handling |
| app/Views/DataPage.php | Existing shared card/table/forms and actual data | Master upload scenario selector not rendered; no management controls for edit/version/revoke/archive; processed data lacks pinned source version/links; add current design components and services |
| AI Operations Center (AI SOC)/DatasetManagement.php | Shared AppLayout + DataPage | Correct common layout; preserve it intact and make the existing management panel complete |
| Data Center/*.php | Shared AppLayout + DataPage | Preserve page shells, existing navigation and components; all data reads stay authorized |
| api/v1/index.php | Central shared Router | Root will load modules; data module will register namespaced and legacy routes with same controller |
| app/Views/RangeUi.php | Reusable approved card/table/form components | Preserve implementation and styling; reuse for new controls |
| app/Core/Database.php | PDO, parameter helpers and savepoints | Reuse; no additional database connection |
| app/Core/Logger.php | Correct audit column names but swallows failures | Reported to root for centralized repair; data actions keep audit writes within transactions |
| database/migrations/001_initial_schema.sql | Master data and processed relations, no version table | Preserve initial schema; add forward-only004 migration, backfill version references from actual existing rows |
| config/navigation.php / app/Views/Layout/* | Approved shared header/sidebar/logo/responsive layout | Root-owned; no redesign or replacement |
| assets/js/range-client.js | Shared API wrapper | Reuse; root-owned global error/escaping improvements if needed |
| tests/ | Existing isolated tests | Add guarded dataset lifecycle contracts; root will provision new dedicated testing database and real HTTP tests |

Authorization policy: active ADMIN required for all master dataset changes; STUDENT only assigned active ticket + nonrevoked master assignment. Master archive preserves bytes/history and removes student master access; own processed history remains readable. Reassignment/revocation never transfers or deletes private processed uploads. New master versions are immutable and do not silently change existing assignment versions. Assignment/revoke/archive retries are no-ops without duplicate notifications.
