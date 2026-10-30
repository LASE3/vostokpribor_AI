# Workspace/registry controls and API inventory — 2026-10-30

All new administrative pages call AppLayout::start/end and existing vp-card/table/input/button design components. No global header/sidebar/style/branding files were changed in this scope.

| Page/control | Endpoint/method | Required fields | Authorization / success / errors | Required verification |
| --- | --- | --- | --- | --- |
| StudentWorkspaces filter | GET soc/notebooks, soc/experiments, soc/experiment-runs, soc/execution-jobs (shared service-backed server GET) | optional student_id,ticket_id,status | Active administrator; only matching original records; invalid target filter422 | Contract scoped records; HTTP filters and student403 |
| Notebook Read cells | GET soc/notebooks/{id} (same notebook service used by page) | actual notebook ID | Admin read-only, original student/code/author preserved | Contract source exact, foreign student403 |
| Experiment Inspect | GET soc/experiments/{id} | experiment ID | Admin read original metadata/runs; missing/invalid rejected | Contract owner and same-ticket rules; HTTP |
| Execution Inspect | GET soc/execution-jobs/{id} | numeric ID or UUID | Admin; actual persisted historical record, no worker-health assertion | HTTP existing/missing ID |
| Cancel queue state | POST soc/execution-jobs/{id}/cancel | actual queued/running job | Admin actor stored; affected student remains original; repeated cancel no duplicate event; terminal state422 | Contract actor/target; HTTP cancel denial/terminal |
| ModelManagement filters/list | GET soc/models | optional student_id,ticket_id,status | Admin scoped actual records | Contract filter; HTTP |
| Manage / versions | GET soc/models/{id}, soc/models/{id}/versions | actual model ID | Admin original metadata and immutable artifact checksums | Contract origin preserved; HTTP |
| Save administrative annotations | PATCH soc/models/{id} | admin_label?,admin_notes? | Admin fields stored separately with admin_updated_by; original student fields immutable; forbidden fields422 | Contract annotations/author/denials; HTTP reload |
| Archive / restore record | PATCH soc/models/{id} | status ARCHIVED or REGISTERED for restore | Admin; no deletion; deployed record requires provider decommission and cannot be silently archived; original files preserved | Contract archive and original fields; HTTP |
| ValidationReports Read evidence | GET soc/validations/{id}, soc/validations | ID / optional filters | Admin; file integrity distinct from no trusted quality evaluation | Contract perfect user metrics NOT_EVALUATED; HTTP |
| DeploymentRequests Record decision | PATCH soc/deployment-requests/{id}; POST /approve or /reject aliases | status APPROVED/REJECTED,notes? | Admin; only pending request; replay no duplicate; no DEPLOYED state/endpoint; errors truthful | Contract idempotency/deniedfakeDEPLOYED; HTTP decision reflects student |
| Student notebook create/save | POST workbench/notebooks; PATCH workbench/notebooks/{id}; legacy paths same controller | title,ticket_id?,cells | Own assigned ticket; GET side-effect free; output cannot be forged | Existing + new contract; HTTP exact code reload |
| Student experiment/create/show/run | GET/POST workbench/experiments; GET experiments/{id}; GET/POST workbench/runs | name,ticket_id?; experiment_id,run_name,notebook_id? | Own original resources; run notebook same ticket; RECORDED metadata not execution | Contract foreign/mismatched refs; HTTP |
| Student artifact inventory/model versions | GET workbench/artifacts; GET registry/models/{id}/versions | own ID | Student own model/version records only | HTTP cross-student denial |
| Student request administrative deployment review | POST registry/deployment-requests (same DeploymentService from existing HTML form) | model_id,model_version_id,environment?,replicas?,canary_percentage?,idempotency_key? | Own intact real artifact; persist PENDING/provider NOT_CONFIGURED with no endpoint; repeats return same record; absent/corrupt file422 | Contract real file/hash/idempotency; real HTTP multipart first |
| Execution availability | GET workbench/execution-status | none | Authenticated; UNAVAILABLE/can_execute=false; never launches Python | HTTP route, execution submit503 |

New administrative forms reuse RangeClient, submit session-bound CSRF, disable the button while saving, report backend failure instead of success, and reload only after an actual successful response. No localStorage/business persistence or independent fetch wrapper is introduced.
