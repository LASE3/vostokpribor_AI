# Verified completed features and remaining blockers

Verification date: 2026-10-26. Stack: PHP 8.2.12 without Laravel, PDO, XAMPP Apache, MariaDB 10.4.32. No demo import was used.

**Status: the persisted non-execution workflow is verified. The entire original request is not fully complete: exact original operational panel layouts were not preserved, and isolated execution, trusted quality evaluation, dataset SQL execution, and inference deployment are unavailable. This is not a production-readiness certification.**

## Database state and preservation

- Active local configuration: `APP_ENV=local`, `DB_NAME=vostok_range_20261026_fresh`, distinct session cookie, debug disabled.
- Initial verifier proved exactly one active ADMIN, identifier `admin`, a `password_hash()` hash verifying the authorized local password, and `must_change_password=1`. All other application tables were empty; migration tracking contained three schema migrations. [Full initialization proof](verification/fresh-final-verifier.log).
- Migration rerun applied zero migrations and inserted no work records. Repeated administrator initialization refused without changing records. A mutating test invoked with the fresh configuration refused before connecting. [Migrations](verification/fresh-migrations.log), [initializer refusal](verification/initializer-repeat-refusal.log), [test refusal](verification/fresh-test-refusal.log).
- After the pristine verification, a real browser request attempted a login on the active fresh installation. At the final read-only snapshot there was one actual `LOGIN_FAILED` audit event, one administrator, and zero students, scenarios, tickets, assignments, datasets, processed datasets, notebooks, cells, experiments, models, model versions, validations, deployments, submissions, and notifications. That real audit event was deliberately preserved. Consequently the strict pre-use empty verifier now reports that audit row; it must not be reset to conceal real activity. [Current counts](verification/fresh-live-counts.json), [pre-use check](verification/fresh-final-verifier.log), [post-use check](verification/fresh-at-handoff.log).
- The original `vostokpribor_ai` database was not reset or dropped. Before creating the new installation, it was backed up outside the web root to `C:/Users/nijim/.codex/backups/vostokpribor/vostokpribor_ai_20261026_141118_a7688d.sql`, SHA-256 `35d6abdcabbf5d9967b2294ffd64764540ebde2c78c44c84da7da1822dcbca42`. [Installer output](verification/fresh-install.log).
- Mutating workflow tests ran only on newly named `APP_ENV=testing` databases ending `_test`. The final acceptance database was `vostok_range_20261026_acceptance_test`. Earlier attempt databases and their backups were retained; no destructive reset was used.
- Existing and newly uploaded files remain on disk. Package omission and MySQL deletion are separate operations; the packaging process performs no source-file or database deletion.

## Verified behavior and changed files

| Area | Concrete implementation | Main changed/new files |
| --- | --- | --- |
| Installation | CLI-only schema migration, new-name-only installer, backup before CREATE, one-time locked administrator provisioning, strict empty verifier | `bin/lib/setup.php`, `bin/install_fresh.php`, `bin/migrate.php`, `bin/create_local_super_admin.php`, `bin/bootstrap_admin.php`, `bin/verify_fresh.php`, `.env.example` |
| Authentication | Hashed credentials, mandatory first-login rotation, current-password verification, session/CSRF rotation, no public registration | `app/Core/Auth.php`, `app/Controllers/AuthController.php`, `login.php`, `change-password.php`, `logout.php` |
| Local credential boundary | Weak local credential requires local environment, strict loopback client/server/Host/configured URL and absence of forwarding headers; rejected in production | `app/Core/Auth.php`, `tests/security_unit.php` |
| CSRF and roles | All unsafe API methods including login require a session token; HTML POST forms are protected; students receive 403 for SYS-05 | `app/Core/Csrf.php`, `app/bootstrap.php`, `app/Middleware/*`, `api/v1/index.php`, controller exception mappings |
| SQL | Strict table/data insert/update/delete helpers, validated identifiers, parameterized execution, nested transaction savepoints, required explicit DB configuration | `app/Core/Database.php`, `app/Core/Env.php`, affected services/repositories |
| Scenarios | No browser-local business persistence; authenticated API CRUD, all 54 builder controls/five stages, actual uploaded dataset references, server history, six lifecycle states | `app/Services/ScenarioService.php`, `app/Repositories/ScenarioRepository.php`, `app/Controllers/ScenarioController.php`, `database/migrations/002_scenario_metadata.sql`, `AI Operations Center (AI SOC)/js/main.js`, `TicketsAndScenarios.php` |
| Scenario browser actions | Create/edit/reload, duplicate with unique COPY code, draft import with partial-result reporting, export of persisted rows, table/roadmap/preview/history, real ticket assignment | SOC JavaScript and `TicketsAndScenarios.php`; [browser record](verification/browser-soc.md) |
| Tickets and submissions | Actual requirements/deadline/criteria, assignments, progress/comments, owned same-ticket notebook/model references, revision iterations, real reviewer decisions, ticket updates and notifications | `app/Services/TicketService.php`, `SubmissionService.php`, corresponding repositories/controllers, `app/Views/ProjectPage.php`, Project pages, SOC `WorkspaceConfiguration.php` |
| Datasets | Genuine HTTP upload only; CSV/JSON parsing; byte-derived row/column counts and checksum; private files; rollback removes only the failed request's newly created file; assigned ticket/master dataset pair required for processed upload | `app/Services/DatasetService.php`, `app/Controllers/DatasetController.php`, `app/Views/DataPage.php`, Data Center pages, SOC `DatasetManagement.php` |
| Notebooks | No GET-created notebook/cell; explicit POST creation and save; exact source reload; user-provided output ignored; cancellation tested | `NotebookService.php`, `NotebookRepository.php`, `ExecutionService.php`, `ExecutionRepository.php`, ML pages, `app/Views/range_*` |
| Models and evidence | Metadata registration creates no artifact version; real immutable file upload supplies checksum/size/version; foreign references denied; absent/corrupt artifacts cannot validate; student metrics do not prove quality | `ModelService.php`, `ValidationService.php`, `WorkOwnership.php`, related repositories/controllers, Registry pages |
| Truthful unavailable states | No host execution, fabricated endpoint, fake inference trace, random latency/confidence, GPU/worker health or quality pass; checksum-only request produces NOT_EVALUATED with null quality score | `workers/python_worker.py`, `bin/worker_bridge.php`, `DeploymentService.php`, `ValidationService.php`, ML/Registry JS, `003_measurement_states.sql` |
| Operational displays | Authorized queries, measured database connectivity only, actual counts, real audit/notification rows, useful empty states; no static chart data | All subsystem PHP pages, shared views, `index.php`, legacy `api/models.php`, `api/exchange.php`, `api/status.php` |
| Packaging | Exact unchanged old/test path+hash omissions, future/modified real files retained, private storage directories/access files retained, source untouched | `bin/package_release.py`, `tests/package_policy.py` |

No CSS design-token files were changed. Existing colors, typography, icons, header/sidebar navigation, and notebook dock conventions were retained. Operational panel interiors were refactored into shared tables, forms, and empty cards; see the layout blocker below.

## Executed tests and observed results

| Executed command/check | Result | Evidence |
| --- | --- | --- |
| New database installer and `bin/verify_fresh.php` before use | PASS, one admin and zero non-migration work/security records | [fresh installation](verification/fresh-install.log), [empty verifier](verification/fresh-final-verifier.log) |
| `php tests/security_unit.php` | 40 PASS; no database connection | [security-unit.log](verification/security-unit.log) |
| `php tests/database_security.php` on `_test` | 12 PASS; outer rollback; savepoints/queued/running/cancelled/terminal states and disabled submission checked | [database-security.log](verification/database-security.log) |
| `php tests/scenario_contract.php` on `_test` | 28 PASS; all generated rows rolled back | [scenario-contract.log](verification/scenario-contract.log) |
| `php tests/model_integrity.php` on `_test` | 23 PASS; own temporary file removed and DB mutations rolled back | [model-integrity.log](verification/model-integrity.log) |
| `python tests/http_workflow.py` through real Apache | 180 PASS; two students, full upload/notebook/model/submission/revision/approval workflow, negative ownership/CSRF tests | [http-workflow.log](verification/http-workflow.log), [observed MySQL state](verification/http-db-observed.json) |
| `python tests/http_empty_pages.py` | 24 PASS; empty student pages truthful; no work created by GET | [http-empty-pages.log](verification/http-empty-pages.log) |
| `python tests/http_readonly_security.py` | 24 PASS; private paths denied, legacy APIs authenticated, no valid login attempted | [http-security.log](verification/http-security.log) |
| `python tests/package_policy.py` | 13 PASS; only temporary test directories used; future uploads preserved | [package-policy.log](verification/package-policy.log) |
| PHP lint, Node `--check`, Python AST parse | 157 files PASS | [syntax.log](verification/syntax.log), [file results](verification/syntax-results.json) |
| Recursive `.php/.js/.sql/.py` inventory and audit | 178 files inspected; zero blocking operational patterns; zero invalid UTF-8 files | [source-audit.log](verification/source-audit.log), [every occurrence](verification/source-audit.json), [inventory](verification/source-inventory.json) |
| Real browser scenario builder and assignment | PASS all ten steps, full reload, edit, all lifecycle states, duplicate/import/export, counters/views/assignment | [browser-soc.md](verification/browser-soc.md), [MySQL proof](verification/browser-soc-database.log) |
| Real browser HTML login/notebook save/reload | PASS; later real edit preserved; execution disabled | [browser-student.md](verification/browser-student.md), [database state](verification/browser-student-database.log) |

The automated functional/security/package suites comprise **344 passing checks**, in addition to syntax checks and browser observations. Earlier HTTP test attempts are retained separately. They exposed a Dataset Management null-user bug, a deployment-unavailable HTTP 500, and two test expectation errors; the successful final run follows the fixes. The stale notebook-marker check is explained in the browser record rather than presented as a pass.

## Remaining source occurrences

`verification/source-audit.json` lists each path, line, matched rule, and classification, including files that are retained locally but omitted from the release. Remaining matches are:

- `localStorage`/known fixture keywords inside the audit tool's detection expressions: operational audit code, not business persistence.
- `deliv-demo` in the ten-step scenario editor: an ID for a requested presentation deliverable checkbox, not a demo record or seeded dataset.
- The migration runner's “No demo records” message: explanatory copy; migrations contain no work inserts.
- Old `database/vostokpribor_ai.sql` data writes: a protected old backup, never loaded by the migration runner and excluded from the source ZIP.
- One-off repair scripts in `storage/` and old sandbox workloads: preserved old artifacts, never executed by the app; inventoried exclusions apply to old files only.
- Guarded negative tests contain old identity strings so that the HTTP suite can reject them. Old fixture test entry points and patchers are inert; old fixture test files are omitted from the ZIP.

Pattern scanning accompanies service/page review and actual HTTP/browser checks; it does not establish an exhaustive proof that every possible hardcoded claim is absent.

## Exact diffs and release artifacts

- Exact unified tracked/new delivery-source diffs: [external source diff](C:/Users/nijim/.codex/artifacts/vostokpribor-ai-20261026-source.diff). Old removed fixture literals in the diff are intentionally kept outside the clean source ZIP.
- Per-file before/after SHA-256 values and paths: [diff manifest](verification/diff-manifest.json).
- Clean source release: [ZIP](C:/Users/nijim/.codex/artifacts/vostokpribor-ai-verified-20261026.zip).
- Every included/excluded path, omission reason/hash, retained future file, ZIP checksum and CRC result: [external release manifest](C:/Users/nijim/.codex/artifacts/vostokpribor-ai-verified-20261026.manifest.json).
- ZIP creation and preservation assertions: [release packaging log](C:/Users/nijim/.codex/artifacts/vostokpribor-ai-20261026-packaging.log).

The archive omits local `.env`, Git history, the old SQL data dump, unchanged inventoried old private files, exact test artifacts, caches/debug logs, retired fixture suites and one-off repair helpers. It retains `.env.example`, migrations, new guarded tests, verification logs, storage directories and `.htaccess`. Unknown/new or modified real runtime files are retained and explicitly reported. No source/upload is deleted by packaging.

## Unresolved blockers and practical limits

1. **Exact original panel-layout parity remains incomplete.** The original shell/style assets remain, but operational interiors were simplified. This does not fully satisfy the instruction to retain the exact page layout. Pixel equivalence has not been established, and this report does not claim it.
2. **Student execution is blocked and disabled.** No separate sandbox, independent runner credentials, filesystem/network restrictions, verified resource controls, authenticated results channel or cancellation-to-runtime guarantee has been deployed. HTTP never launches Python. The worker and bridge exit unavailable.
3. **Trusted quality evaluation and inference deployment are blocked.** File integrity is verifiable; safe deserialization, holdout evaluation, benchmark provenance and actual serving-provider health are not. There is no deployed inference URL and no completed quality pass from student metrics.
4. **Dataset SQL execution is unavailable.** Query Workspace presents this explicitly and offers real file previews; it does not pretend to run a query.
5. The pristine verifier is a before-use assertion. Real subsequent authentication/audit events and user work are preserved; rerunning it after genuine use is expected to fail instead of deleting those records.
6. This was verified locally on XAMPP/MariaDB. Public deployment, multiple-server sessions, load behavior, exhaustive race handling, and exact UI visual regression coverage have not been certified.

README was updated after implementation and verification. These limitations must remain visible until their corresponding infrastructure and layout work is completed and tested.
