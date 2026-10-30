# Workspace and registry implementation inventory — 2026-10-30

Inspected the existing worktree code before backend changes. Shared AppLayout, header, sidebar, palette, design tokens, existing page layouts and notebook dock views will not be replaced.

| File(s) | Observed behavior / gap | Planned repair |
| --- | --- | --- |
| app/Controllers/NotebookController.php | Owned notebook create/save/read exists. Admin inspection through SOC absent. | Reuse existing service for SOC read-only inspection; no student authorship changes. |
| app/Controllers/ExperimentController.php | No single experiment route; metadata creation says container created. | Authorized show; truthful metadata wording; transaction and related-ticket consistency. |
| app/Controllers/ExecutionController.php | Submit correctly disabled; no status route. Cancellation audit cannot independently accept administrative actor. | Explicit unavailable status and scoped list; admin cancellation through same service without impersonation. |
| app/Controllers/ModelController.php | Metadata registration and genuine file version upload exist; no version-list route. | Authorized versions/artifacts reads and SOC inspection. |
| app/Controllers/ValidationController.php | Genuine checksum check, untrusted metrics do not pass quality; no list route. | Authorized list and SOC full report inspection, retain NOT_EVALUATED. |
| app/Controllers/DeploymentController.php | All request creation/review refuses, leaving no administrative workflow to manage. | Persist request/approval/rejection only for intact real artifact; provider state remains unavailable; no fabricated endpoint. |
| app/Services/NotebookService.php | Explicit save ignores editor output; ownership permits admin edits. | SOC remains read-only; current student save functionality retained. |
| app/Services/ExperimentService.php | Foreign notebook owner checked but ticket relation not checked; writes/audit not one transaction. | Validate same ticket/scenario; transactional create/record. |
| app/Services/ExecutionService.php | Host execution hard disabled; cancellation uses session-side admin decision in repository. | Independent actor-role check and actual admin audit; terminal retry handling. |
| app/Services/ModelService.php | Owner checks and private immutable upload; related run owner checked but ticket mismatch allowed. | Same-ticket run validation, admin metadata stored separately, archive with audit. |
| app/Services/ValidationService.php | Trust/provenance restriction correctly separates file integrity and quality. | Keep restriction; add scoped lists and archive guard. |
| app/Services/DeploymentService.php | No persisted request lifecycle despite existing schema. | Typed request states independent of model quality/provider state; idempotent retries; actual admin decisions/audit/notification. |
| app/Services/WorkOwnership.php | Ticket assignment has no revocation check. | Require revoked_at IS NULL, coordinated migration005. |
| app/Repositories/NotebookRepository.php | Real code and cells saved transactionally, GET side-effect free. | Retain; SOC joined reads return original student. |
| app/Repositories/ExperimentRepository.php | Student lists exist; single experiment and SOC filtered reads missing. | Add authorized service show plus bounded SOC repository reads. |
| app/Repositories/ExecutionRepository.php | Terminal cancellation mostly correct, no explicit admin actor input. | Optional actor-role input, no student impersonation, scoped admin lists. |
| app/Repositories/ModelRepository.php | Real versions/checksums, no admin metadata distinction. | Separate admin metadata/name/notes migration006; original authored fields preserved. |
| app/Repositories/ValidationRepository.php | Report joins correct, scoped list missing. | Shared scoped list method. |
| app/Repositories/DeploymentRepository.php | Existing request methods reference valid deployment_requests table. | Preserve; add idempotency key/provider state, row-locked reviews, no runtime success. |
| app/Views/range_context.php | Student/admin queries; active tickets/dataset assignments do not yet consider revocation. | Filter active grants; admin modification of student pages disallowed and linked to SOC. |
| app/Views/range_panels.php, range_model_table.php, range_validation_table.php, range_run_table.php | Truthful no-data/unavailable panels; shared existing layout. | Preserve layout; add actual deployment request form without enabling deployment. |
| ML Workbench/*.php, Model Registry & Deployment/*.php | Existing AppLayout used. | Keep all files, shell, header/sidebar and current layouts. |
| workers/python_worker.py, bin/worker_bridge.php | Both deliberately exit unavailable without launching code. | No enabling changes. |
| database/migrations/001–003 | Core relationships present, no admin model annotations/request idempotency. | Add forward-only 006_soc_workspace.sql without resetting/deleting data. |
| New api/v1/modules/workbench.php, registry.php | Namespaced modules absent. | Register required namespaced routes and retained compatibility routes with same controllers. |
| New SocWorkspaceController/SocWorkspaceService/SocWorkspaceRepository | No central administrative inspection/management. | Guard administrator at controller and service; bounded queries, actual actor, immutable original student work. |
| New SOC StudentWorkspaces.php, ModelManagement.php, ValidationReports.php, DeploymentRequests.php | Meaningful central views missing. | Shared AppLayout and existing vp components; filters, read-only inspection, narrowly scoped metadata/request forms. |

No database, .env, user artifacts, production records, or original source layouts were modified during this inventory.
