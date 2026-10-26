# SOC browser verification — 2026-10-26

The installed Apache application at `http://localhost/vostokpribor_AI` used `APP_ENV=testing` and `vostok_range_20261026_acceptance_test`. All browser mutations below were limited to that isolated database. Existing random test administrator credentials were used. No browser state was injected or fabricated.

Observed through the real in-app browser with typed fields, clicks, reloads, and the native file chooser:

1. Logged in and opened the existing SOC shell. Catalog initially showed the one scenario created by the HTTP acceptance test.
2. Created `BROWSER-SOC-20261026` through all ten builder steps. Entered general data, business problem, a real uploaded dataset reference, requested environment, all five workflow actions, success criteria, deliverables, eight rubric weights, publication dates, and version/changelog.
3. Saved with the real POST handler. Catalog increased from one to two scenarios only after API success.
4. Fully reloaded the page, reopened Edit, and read all 54 persisted controls and all five workflow actions from the rendered form. Checkbox states, requested runtime, rubric, dates, dataset reference and version matched entered values. Changelog appeared in recorded history; its input clears for a new edit by design.
5. Edited description, saved, reloaded, and observed the edited description.
6. Clicked supported transitions through READY_FOR_REVIEW, PUBLISHED, ACTIVE, COMPLETED, ARCHIVED, DRAFT. Each state changed via authenticated PATCH and survived reload. Version history displayed actual actor/time/change notes.
7. Verified table and roadmap views rendered actual persisted scenarios, with no seeded records.
8. Found that the embedded browser does not support JavaScript prompt(). Replaced the duplicate prompt with a generated unique COPY code followed by a real POST. Retested: duplicate persisted as `BROWSER-SOC-20261026-COPY-1793024496613`, count increased to three, and the copy survived reload.
9. Export clicked in browser produced an actual downloaded JSON file containing the three persisted rows and full builder metadata. Parsed the file independently. Prepared a one-record import from that exported record with a unique code.
10. The first automation click on the hidden file input did not open a chooser. Used the visible Import label instead. The real chooser selected the prepared file, the authenticated import POST succeeded, and `BROWSER-SOC-IMPORTED-20261026` appeared as a draft. Count became four and remained four on reload. No application change was needed for this automation detail.
11. Created `BROWSER-TICKET-20261026` with real description, requirements, acceptance criteria and deadline through the page form. It reloaded as DRAFT/Unassigned. Used the scenario Assign modal to select the real ticket and second test student. Reload showed ASSIGNED, the actual student identifier, and scenario counters of one ticket/one student.
12. Preview displayed the entered objective, criteria and actual uploaded dataset name. Integration Hub showed actual scenario rows and NOT AVAILABLE for external service health. No endpoint, worker or GPU health was asserted.

Evidence: [browser-soc.png](browser-soc.png), [browser-soc-database.log](browser-soc-database.log), [scenario-contract.log](scenario-contract.log). Database evidence independently confirms 54 JSON fields, five stages, one genuine dataset reference, eight original scenario revisions, persisted duplicate/import records, and the assigned ticket metadata.

Implementation notes: scenario code is immutable after creation; duplication creates a unique code. Import creates drafts and preserves existing rows, stopping with a partial-import count if a record fails. The version panel is an actual change history; it does not claim cryptographic snapshots. Publication/environment settings describe requested work and do not provision ACLs or services.
