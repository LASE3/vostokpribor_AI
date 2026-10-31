# V6 first implementation: one SOC dashboard

Baseline: main0b8cd08, tag codex/v6-baseline-20261031. Complete file inventory and dependency map were recorded before edits. Baseline real XAMPP central400 and API113/core40/training44/coreHTTP23 pass. No source has yet changed.

Dashboard.php and OperationsDashboard.php differ only in pageType, title and active navigation. Both execute the same nine aggregates, activity/audit/scenario queries, SELECT1 probe and _dashboard_panels include. Operations has no unique queries/widgets; its mission-control heading/icon are the only panel variations. Preserve the canonical Dashboard heading and every shared monitoring section.

| File/functions | Reason / dependencies | Risk / test |
| --- | --- | --- |
| OperationsDashboard.php + .htaccess | Remove duplicate implementation; exact legacy URL redirects308 to Dashboard, query preserved. | Test Apache redirect in nested installation; admin final200/student403/anonymouslogin; no filesystem path leak. |
| config/navigation.php + Layout/NotificationsButton.php + tests/http_central_soc.py/http_workflow.py | Remove duplicate sidebar item; notification link and current test links target canonical dashboard. | Sidebar/header geometry unchanged; exactly one overview nav link; old URL only redirect test/historical evidence. |
| Dashboard.php + _dashboard_panels.php | Delegate shared data to SocSystemService; retain grid/cards/sections, add missing metric labels inside existing panels. | Empty and populated DB,12+students beyond limit10, active/inactive, grants, pending/approved review, failed job, request vs runtime. |
| SocSystemService overview/dashboard data | Dedicated aggregates; recent list explicitly recent (all statuses), active total independent of limit; no fake deployment from request status. | DB integration fixtures rolled back, HTTP overview/page agree, performance count/EXPLAIN. |
| SocWorkspaceController + SocWorkspaceService + soc.php | Split soc/deployments from request listing; return truthful empty runtime listing with provider unavailable headers/metadata while request API unchanged. | All183 route tests; request list retains realrecords, deployment empty even approved request. |

No schema reset, fixture startup, execution/provider enablement or layout/CSS redesign is needed. Later confirmed source changes are documented in domain audit plans before editing. Existing historical test logs remain untouched.
