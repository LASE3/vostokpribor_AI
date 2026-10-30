# Data and SOC dataset controls — 2026-10-30

Shared header/logo/sidebar/layout and CSS design tokens are unchanged. Existing DataPage card/table/form components are reused; the SOC management screen adds working fields inside that shared content area. Both JavaScript and protected PHP POST fallback call the same DatasetService operations.

| Page / control | Backend path and method | Inputs | Role / authorization | Success / error / verification |
| --- | --- | --- | --- | --- |
| SOC Dataset Management / master upload | POST soc/datasets -> uploadDataset | code,name,description,scenario_id?,dataset_file | Active administrator | Real upload parsed + file moved privately + dataset/version/audit transaction; errors keep input, no success toast |
| SOC / dataset Preview | GET soc/datasets/{id}/preview or authorized shared data endpoint | id,version_id? | Administrator; student shared endpoint checks pinned active assignment | Reads verified actual bytes; missing/checksum mismatch returns error |
| SOC / Edit metadata | PATCH soc/datasets/{id} -> updateMetadata | name,description,scenario_id? | Administrator; active assignment scenario conflict rejected | Saves metadata only; retains version files and original upload identity |
| SOC / immutable upload version | POST soc/datasets/{id}/versions -> addVersion | version,dataset_file | Administrator; master not archived | New random private file/version, old file untouched; identical version retry is a no-op; differing same label rejected |
| SOC / assign | POST soc/datasets/{id}/assign | student_id,ticket_id,dataset_version_id? | Active administrator; active target student and active matching ticket assignment; scenario match | Version-pinned assignment + one audit/notification; identical retries no duplicates |
| SOC / revoke row button | POST soc/datasets/{id}/revoke | student_id,ticket_id? | Administrator; target must be a real student | Revokes access without deleting row/file/work; retry no duplicate notification |
| SOC / archive | POST soc/datasets/{id}/archive | id | Administrator | Archive + revoke active grants + audited transaction; preserves all versions and processed uploads |
| SOC / assignment & usage table | GET soc/datasets/{id}/assignments | id | Administrator | Actual assigned student/ticket/version/time/revocation data |
| SOC / dataset activity | GET soc/datasets/{id}/activity | id | Administrator | Actual schema-valid audit events and actors |
| Data Center / authorized catalog | GET data/datasets | format? | Signed-in user; student only active ticket plus nonrevoked dataset grant, unarchived master | Server-authorized rows; no data creation on GET |
| Data Center / preview | GET data/datasets/{id}/preview | id,version_id?,limit1-50 | Pinned assigned version only for student | Real parsed rows; no SQL execution or synthetic quality metrics |
| Data Center / master download | GET data/datasets/{id}/download | id,version_id? | Same authorization as preview + stored checksum | Authenticated file stream; direct private access denied by Apache |
| Data Center / version list | GET data/datasets/{id}/versions | id | Student sees only explicitly authorized version IDs; admin full history | Uploading a newer master version does not silently retarget an older assignment |
| Data Center / processed upload | POST data/processed | source_dataset_id,ticket_id,name,transformation_notes,processed_file,source_dataset_version_id? | Active student, exact active ticket/master/version assignment pair | Separate processed file/row with pinned source_version, transaction/audit; revocation race rechecked before acceptance |
| Data Center / processed history | GET data/processed, GET data/processed/{id}, GET data/processed/{id}/download | id? | Own processed records or administrator | Historical processed work remains owned/readable after master revoke/archive or ticket reassignment |
| Data Center / activity | GET data/activity | none | Own data-related audit events; administrator sees all data activity | Never claims cache flush/SQL execution/ingestion that did not occur |
| DataCenter admin read-only view | Link to SOC Dataset Management | none | Administrator | Central administration is reachable without editing through student pages |
| Catalog text filter | Client text filter over rendered rows | search text | Already authorized rendered table | Display-only; no browser business persistence |

JavaScript uses the existing RangeClient, shows Saving while pending, disables duplicate submit, reports server errors, and reloads only after an explicit success envelope. Normal HTML fallback uses CSRF and a POST/redirect/GET session flash set only after a persisted service operation. No new fetch-wrapper/authentication stack was added.

Evidence: 20261030-dataset-lifecycle.log has 27 passing guarded transactional checks. 20261030-migration-preservation.log proves preservation through migrations001–007 on a new dedicated test schema. Actual multipart HTTP endpoints and page integration are verified by the root integration suite; consult its final log for the observed HTTP results.
