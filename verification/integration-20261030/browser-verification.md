# Browser verification on MAIN source — 2026-10-30

Browser target: `http://127.0.0.1/vostokpribor_integration_main_20261030/vostokpribor_AI`. The local-only Apache junction serves a code snapshot of `C:/xampp/htdocs/vostokpribor_AI` with its own APP_ENV=testing, cookie and `vostok_range_20261030_main_http_test` database. No production/main credentials or private payloads were copied. All browser writes below were deliberate test actions in that database.

| Action | Observed after reload | Evidence |
| --- | --- | --- |
| Create ticket, edit requirements, acceptance criteria, deadline and description in the SOC modal | BROWSER-20261030-MAIN, persisted title Browser metadata persisted, deadline 2026-12-26 13:30 | browser-ticket-main.png; browser-db-observed-main.json |
| Assign ticket to student IT-F521715A6A-0 in SOC | ASSIGNED, active original student relation, no implicit dataset access | browser-ticket-main.png; browser-db-observed-main.json |
| Upload actual two-row CSV through SOC file chooser | Dataset5, 2 rows/2 columns/45 bytes, exact preview values alpha12.5 and beta17.25, private file present with matching SHA256 | browser-dataset-main.png/.txt; browser-db-observed-main.json |
| Assign uploaded dataset to same student/ticket | Active assignment pinned to version7, preserved after reload | browser-dataset-main.txt; browser-db-observed-main.json |
| Inspect notebook source from SOC | Original student4, notebook3, saved code including values=[1,2] and persistence comment, read-only | browser-workspaces-main.txt |
| Save SOC administrative model label/notes | Reload shows Browser review label and Browser annotation persisted; original name/owner/checksum unchanged, admin_updated_by=1 | browser-model-main.png/.txt; browser-db-observed-main.json |
| Open operations dashboard | Real test record counts; live SELECT1 latency; worker/GPU/inference/SLA NOT AVAILABLE; no pending reviews when count0 | browser-operations-main.png/.txt |
| Open existing notification popover | Actual submitted-work and deployment-request notifications with DB timestamps; no invented alerts | browser-notifications-main.txt |

Browser findings corrected during verification:

1. Already committed merge markers caused NotebookWorkbench HTTP500. They were removed while keeping the approved expanded panels. Central400 HTTP/HTML checks then passed, including notebook source rendering.
2. A rapid dataset assignment/reload encountered a transient missing-configuration500 despite an intact .env. Removed Env.load's process-wide putenv side effect: file configuration now remains request-local; explicit process overrides still work. Env8 regression checks and finalHTTP400 passed. The assignment itself was committed and verified; it was not retried or duplicated.
3. SOC model annotation JSON included the CSRF field injected into HTML forms, and strict annotation validation correctly rejected it. The UI now omits this transport field and sends CSRF through RangeClient's header. Versioned script URLs prevent stale cached handlers. Repeated browser save and reload confirmed actual MySQL persistence. Client regressions verify backend errors never reload/report saved.
4. Pending-review count0 previously said No submissions even when historic submissions existed. Changed only that empty label to No pending reviews.

Console observation: the existing Tailwind CDN emits its production-use warning. A Grammarly browser extension emits unrelated warnings/errors. No application JavaScript exception was observed in these completed checks. Production should compile and serve frontend dependencies locally without changing the approved design; that deployment hardening was not performed here.

This is desktop browser verification at the supplied viewport. No new claim of exhaustive mobile/browser visual parity is made. The13 protected shared layout/CSS/branding files have separate Git/hash evidence; no redesign was performed.
