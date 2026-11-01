# V9 file changes

Comparison base: `309d92e` on `main`, also tagged `codex/v9-baseline-20261101`. The predecessor is V7; no V8 commit was present. This inventory names the V9 source changes and their purpose. The release evidence contains the full unified patch against that base, including new files; that patch is the exact line-by-line diff. No application table, original upload, `.env` or Git history was deleted or reset.

`M` means modified from the comparison base; `A` means added. Paths are relative to the repository root. Generated verification evidence, database/private recovery archives, local secrets and test-instance configuration are outside this source inventory and excluded from the source ZIP.

## Shared paging and response contract

| Change | File | Purpose |
|---|---|---|
|A|`app/Core/Pagination.php`|Validate whole-number windows, bound limits, count authorized results and construct consistent page metadata.|
|M|`app/Core/Response.php`|Keep collection `data` as an array and add top-level pagination metadata.|
|M|`api/models.php`|Apply the same bounded model service to the compatibility inventory; return actual total and metadata.|
|M|`index.php`|Use full authorized SQL aggregates for launcher counts instead of lengths of bounded lists.|

## Controllers

| Change | File | Purpose |
|---|---|---|
|M|`app/Controllers/DatasetController.php`|Page authorized master datasets, versions, assignments and processed files.|
|M|`app/Controllers/DeploymentController.php`|Page deployment request history.|
|M|`app/Controllers/ExperimentController.php`|Page experiments and runs, including nested run windows.|
|M|`app/Controllers/ModelController.php`|Page models and nested artifact versions.|
|M|`app/Controllers/NotebookController.php`|Page saved notebooks.|
|M|`app/Controllers/ScenarioController.php`|Page/filter scenarios; expose real summary and saved department/cohort option views.|
|M|`app/Controllers/SocTrainingController.php`|Page student, ticket and scenario related collections while retaining full progress aggregates.|
|M|`app/Controllers/SocWorkspaceController.php`|Propagate page and nested collection windows for administrator inspection.|
|M|`app/Controllers/SubmissionController.php`|Page submission history with authorized totals.|
|M|`app/Controllers/TicketController.php`|Page assigned tickets and discussion, using whole-collection counts.|
|M|`app/Controllers/UserController.php`|Pass independent dossier collection windows to the service.|
|M|`app/Controllers/ValidationController.php`|Page validation results.|

## Repositories

| Change | File | Purpose |
|---|---|---|
|M|`app/Repositories/DatasetRepository.php`|Bound authorized dataset/processed/version/assignment reads; preserve the granted immutable version and exact size/count aggregates.|
|M|`app/Repositories/DeploymentRepository.php`|Bound request history and retain full SQL totals.|
|M|`app/Repositories/ExperimentRepository.php`|Bound experiments/runs; persist optional dataset version and explicit USER_REPORTED measurement source; expose untrusted provenance.|
|M|`app/Repositories/ModelRepository.php`|Page narrow model keys before metadata joins; add compact projections and bounded version detail.|
|M|`app/Repositories/NotebookRepository.php`|Bound saved notebook reads with exact totals.|
|M|`app/Repositories/ScenarioRepository.php`|Apply scenario filters before the window and retain exact totals.|
|M|`app/Repositories/SocWorkspaceRepository.php`|Use compact bounded administrator projections and collection metadata.|
|M|`app/Repositories/SubmissionRepository.php`|Bound submission reads and add whole-collection status aggregates.|
|M|`app/Repositories/TicketRepository.php`|Bound ticket/discussion reads, count unique tickets, avoid duplicate administrator list rows and select the authenticated student's own shared-ticket assignment.|
|M|`app/Repositories/TrainingReadRepository.php`|Bound student activity and scenario/ticket related collections with exact totals.|
|M|`app/Repositories/UserRepository.php`|Add stable ID tie-breaking, independently page dossier collections and reuse authorized immutable dataset reads.|
|M|`app/Repositories/ValidationRepository.php`|Bound validation history and count results independently of the current page.|

## Services and schema

| Change | File | Purpose |
|---|---|---|
|M|`app/Services/DatasetService.php`|Authorize paged dataset and processed-file reads; expose real aggregate totals.|
|M|`app/Services/DeploymentService.php`|Authorize bounded request history.|
|M|`app/Services/ExperimentService.php`|Authorize paged experiments/runs and validate dataset-version ownership, active grant and matching ticket before manual run recording.|
|M|`app/Services/ModelService.php`|Authorize model and nested version windows.|
|M|`app/Services/NotebookService.php`|Authorize bounded saved notebooks.|
|M|`app/Services/ScenarioService.php`|Validate saved catalog filters; return persisted summaries and department/cohort options.|
|M|`app/Services/SocTrainingService.php`|Preserve active administrator checks, page related resources and calculate full student progress using SQL aggregates.|
|M|`app/Services/SocWorkspaceService.php`|Authorize bounded administrator workspace collections/details.|
|M|`app/Services/SubmissionService.php`|Authorize paged submissions and whole-collection status totals.|
|M|`app/Services/TicketService.php`|Authorize paged tickets/discussion and expose actual full counts.|
|M|`app/Services/UserService.php`|Carry dossier page controls through the shared user service.|
|M|`app/Services/ValidationService.php`|Authorize bounded validation history; preserve unavailable trusted evaluation semantics.|
|A|`database/migrations/008_run_provenance_and_collection_indexes.sql`|Add nullable dataset-version FK and measurement-source enum to runs, plus model sort indexes. No historical metrics are promoted and no fixture records are inserted.|

## Existing page shells and browser handlers

| Change | File | Purpose |
|---|---|---|
|M|`AI Operations Center (AI SOC)/StudentManagement.php`|Render independent dossier page controls and exact related totals.|
|M|`AI Operations Center (AI SOC)/TicketsAndScenarios.php`|Add catalog/selector page controls and saved filter options; load the changed scenario handler through cache-revised layout scripts.|
|M|`AI Operations Center (AI SOC)/_ticket_management_modal.php`|Add related-list page controls to the existing modal.|
|M|`AI Operations Center (AI SOC)/_workspace_admin.php`|Render exact list totals, bounded collections and nested version/run navigation.|
|M|`AI Operations Center (AI SOC)/js/main.js`|Use server filters/windows and summaries; retain selections across pages; traverse real pages during explicit export and report import persistence/partial failures truthfully.|
|M|`app/Views/DataPage.php`|Add authorized dataset/processed-file/version page controls; filter selected processed results before paging.|
|M|`app/Views/ProjectPage.php`|Use actual aggregate counters and page ticket, submission and discussion collections.|
|M|`app/Views/RangeUi.php`|Provide shared page links within the existing visual components.|
|M|`app/Views/range_context.php`|Load only collections needed by the selected page; use compact projections, full counters and named selector windows.|
|M|`app/Views/range_model_table.php`|Render model page controls.|
|M|`app/Views/range_panels.php`|Render bounded notebook, experiment, artifact and nested collection controls; show saved provenance.|
|M|`app/Views/range_run_table.php`|Render run page controls and untrusted measurement provenance.|
|M|`app/Views/range_validation_table.php`|Render validation page controls.|
|M|`assets/js/soc-training.js`|Navigate related resources and ticket lists, retain selected scenarios and display full server totals.|
|M|`assets/css/tailwind-portal.css`|Rebuild pinned Tailwind output for existing classes used by changed controls.|
|M|`assets/css/tailwind-shared.css`|Rebuild pinned Tailwind output for existing classes used by changed controls.|

The approved branding, palette, header/sidebar, icons and page layout remain. Dashboard entry/API routing were repaired in the comparison base and reverified in V9; this inventory does not present those unchanged predecessor files as new V9 fixes.

## Recovery, audit and package tools

| Change | File | Purpose |
|---|---|---|
|A|`bin/backup_range.php`|CLI entry for consistent combined encrypted database/private-file/configuration backup outside webroot.|
|A|`bin/restore_range.php`|CLI entry for restricted restore into a new isolated test database/code tree.|
|A|`bin/lib/recovery.php`|Implement fingerprints, encrypted archive safety, restore validation and exact restricted runtime grants.|
|A|`bin/infrastructure_preflight.py`|Read-only tooling inventory with explicit BLOCKED/NOT_EVALUATED/UNAVAILABLE results; it enables no service.|
|M|`bin/audit_source.py`|Classify all files in six explicit scopes, retain contextual findings, redact sensitive values and preserve historical reports.|
|M|`bin/package_release.py`|Exclude the isolated-test storage identity marker from deliverable ZIPs.|
|M|`.gitignore`|Ignore the local test-storage identity marker.|
|M|`.htaccess`|Deny HTTP access to that marker.|
|M|`package.json`|Update project release metadata to 9.0.0; pinned build dependencies retained.|
|M|`package-lock.json`|Match 9.0.0 release metadata without dependency upgrades.|

## Tests and test isolation

| Change | File | Purpose |
|---|---|---|
|A|`tests/TestStorage.php`|Require a separate saved testing configuration and root/database-bound storage marker before file-writing suites.|
|A|`tests/prepare_storage.php`|Prepare that marker only in a separately configured empty payload tree; never remove uploads.|
|A|`tests/test_storage_guard_v9.py`|Exercise mismatched/absent configuration, marker identity and nonempty storage refusals.|
|M|`tests/backend_concurrency.php`|Require isolated prepared storage before file-writing concurrency checks.|
|M|`tests/dataset_lifecycle.php`|Require isolated prepared storage before upload lifecycle checks.|
|M|`tests/model_integrity.php`|Require isolated prepared storage before real model-file checks.|
|M|`tests/workspace_integration.php`|Require isolated prepared storage before notebook/model workflow checks.|
|M|`tests/frontend_async.js`|Represent the real additive page response in async browser-handler mocks.|
|M|`tests/http_test_target.py`|Check saved CLI identity, exact test URL and actual separate HTTP cookie before sending credentials; support exact-database keyed private credentials.|
|M|`tests/http_backend_v6.py`|Use guarded target preflight/private credentials; retain real admission and concurrency tests.|
|M|`tests/http_central_soc.py`|Use guarded target preflight/private credentials for central SOC regression.|
|M|`tests/http_core_security.py`|Use guarded target preflight/private credentials for real security failures.|
|M|`tests/http_dashboard_v6.py`|Use guarded target preflight/private credentials for dashboard/request semantics.|
|M|`tests/http_database_proof_v7.py`|Use guarded target preflight/private credentials before independent SQL proof workflow.|
|M|`tests/http_form_error_v7.py`|Use guarded target preflight/private credentials for safe form error checks.|
|M|`tests/http_notebook_conflict_v6.py`|Use guarded target preflight/private credentials for stale notebook write checks.|
|M|`tests/http_read_limit_v7.py`|Use guarded target preflight/private credentials for heavy-read admission checks.|
|M|`tests/http_request_security_v7.py`|Use guarded target preflight/private credentials for request security regression.|
|M|`tests/http_soc_extra.py`|Use guarded target preflight/private credentials for supplemental SOC regression.|
|M|`tests/http_soc_security.py`|Preflight the actual HTTP target before administrator/role adversarial probes.|
|M|`tests/http_system_entry_v7.py`|Use guarded target preflight/private credentials for five Dashboard entries and API/resource checks.|
|M|`tests/package_policy.py`|Verify test-storage marker exclusion from deliverables.|
|M|`tests/repository_performance.php`|Measure real MySQL at selectable 10/50/100/500-student scales, before/after bounded reads, payloads, query plans, timing and transient memory; verify rollback.|
|A|`tests/database_proof_probe_v9.php`|Independent SQL/FK/business-identifier checks for the V9 HTTP workflow.|
|A|`tests/http_load_v9.py`|Measure authenticated bounded HTTP reads with independent local test sessions.|
|A|`tests/http_pagination_v9.py`|Create explicit test records and verify exact totals, later windows, invalid pagination and deterministic identities through Apache.|
|A|`tests/http_workflow_v9.py`|Exercise the complete non-execution student/admin workflow through actual Apache, including ownership failures and truthful unavailable services.|
|A|`tests/infrastructure_preflight_v9.py`|Verify that inventory cannot attest isolation or enable missing services.|
|A|`tests/pagination_collections.php`|Use actual MySQL for authorized collection totals/windows, shared-ticket identity and dataset-version provenance checks.|
|A|`tests/recovery_integration.php`|Verify encrypted combined restore, exact bytes/rows, refusal boundaries and restricted credentials in new test targets.|
|A|`tests/source_audit_v9.py`|Verify classifications, contextual findings, nonexecution, redaction and coverage failures.|

## Release documentation

| Change | File | Purpose |
|---|---|---|
|A|`docs/V9_ARCHITECTURE.md`|Describe shared system architecture and requirements for future independent execution/evaluation/serving boundaries.|
|A|`docs/V9_BASELINE_REPORT.md`|Record the actual V7 predecessor, host, backup and baseline findings.|
|A|`docs/V9_DATABASE_VERIFICATION.md`|Record fresh/forward migration, original-row/file preservation, combined backup/restore and local recovery measurements.|
|A|`docs/V9_DEFECT_INVENTORY.md`|Map confirmed defects to repairs/evidence and retain unresolved infrastructure/public deployment blockers.|
|A|`docs/V9_DEPLOYMENT_GUIDE.md`|Document Windows/XAMPP installation, runtime/operator separation, test isolation and controlled recovery.|
|A|`docs/V9_SECURITY_REPORT.md`|Record twenty security boundary groups, source audit classifications and disabled-service limitations.|
|A|`docs/V9_TEST_RESULTS.md`|Record actual CLI/HTTP/SQL/browser/performance results, test-storage correction and blocked acceptance steps.|
|A|`docs/V9_FILE_CHANGES.md`|This inventory; use the external unified patch for exact changed lines.|

The final release also updates `README.md`, `API_REFERENCE.md` and `VERIFIED_COMPLETED_FEATURES.md`, and adds `docs/V9_FINAL_REPORT.md`, after implementation verification. Those final documentation changes belong in the full release patch; verify its name/status list before committing.
