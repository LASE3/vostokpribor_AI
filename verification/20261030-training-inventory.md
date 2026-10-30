# Training integration implementation inventory — 2026-10-30
Read before backend changes in worktree C:/Users/nijim/.codex/worktrees/425e/vostokpribor_AI.

| File | Observed behavior / defect | Repair |
| --- | --- | --- |
| app/Services/UserService.php | Create/update rely on controller admin guard; reset permits any existing id; no persistent session revocation; updates audit outside transaction | Active admin guard, student-only target, transactions, session_version increments and actual notifications |
| app/Repositories/UserRepository.php | Public read fields safe; dossier includes historical assignments as active; session version absent | Return session_version; active assignment filters; preserve historical work |
| app/Controllers/UserController.php | Authenticated own dossier; admin create/update; no explicit activate/deactivate/reset/relations | Preserve compatibility; expose SOC facade methods through shared services |
| app/Services/TicketService.php | Multiwrite assignment not transactional, duplicate notifications absent, admin arbitrary status jumps; no reassignment/cancel policy | Locked lifecycle transactions, idempotent assign/reassign, revocation timestamps, preserve private artifacts |
| app/Repositories/TicketRepository.php | Joins all assignments; upsert rewrites assigned date on retry | Active-only joins; idempotent upsert reactivation retaining audit/history |
| app/Controllers/TicketController.php | Missing progress/comments GET/dashboard/notifications module routes | Add methods and project aliases to existing service |
| app/Services/SubmissionService.php | Same-ticket ownership checked; code omits student causing collision; duplicate creates/reviews not idempotent; status read outside locks | Ticket/submission locks, request retry detection, student-specific codes, review notifications once |
| app/Repositories/SubmissionRepository.php | Prepared SQL and safe joins; iteration read unsynchronized | Keep writes behind locked service transaction |
| app/Controllers/SubmissionController.php | Existing list/store/show/review; SOC named decision aliases missing | Preserve handlers, SOC decision facade |
| app/Services/ScenarioService.php | Typed JSON builder history and validated transitions implemented | Keep builder/history; add shared publish/archive actions idempotently |
| app/Repositories/ScenarioRepository.php | Actual counts but historical assignment counts include revoked | Active filters for current counters |
| app/Controllers/ScenarioController.php | Existing admin CRUD | Preserve compatibility paths |
| app/Views/ProjectPage.php | Service writes; direct reads count all ticket assignments, may show historical revoked dataset refs | Active assignment filters only; keep layout |
| AI Operations Center (AI SOC)/StudentManagement.php | Shared AppLayout; create/reset/status/dossier JS; no edit form; reset uses legacy PATCH | Existing component edit controls, explicit SOC reset/activate/deactivate paths, dossier inspection retained |
| AI Operations Center (AI SOC)/TicketsAndScenarios.php | Existing 10-step builder; actual ticket table/create form; no edit/reassign/cancel controls | Add matching existing component controls/modals, preserve entire builder and layout |
| AI Operations Center (AI SOC)/ScenarioManagement.php | Alias to builder | Retain alias |
| AI Operations Center (AI SOC)/WorkspaceConfiguration.php | Shared layout, submission review form/service | Preserve review UI, retry-safe service; no frontend impersonation |
| api/v1/modules/project.php | Missing | Add new project namespace + compatibility registrations |
| app/Controllers/SocTrainingController.php | Missing | Active-admin facade for required student/ticket/scenario/submission endpoints |
| database/migrations/005_assignment_security.sql | Missing | Forward-only session revocation and historical assignment fields; no record reset |

Existing schema, Auth, Request/Response/Router, Logger and AppLayout inspected for interface use. Shared AppLayout/header/sidebar/design token files will not be modified. Root owns centralized auth/session integration, central router/SOC registration and navigation. Data agent owns dataset revocation/version schema. All mutable tests require APP_ENV=testing and _test names. No user database or .env has been modified.
