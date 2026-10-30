# Training implementation status — 2026-10-30

VERIFIED COMPLETE (service contracts): student create/edit/active state/reset/session-version signaling; strict active-admin actor checks; student-only target guard; active ticket authorization; valid ticket lifecycle; transactions; retry-safe assignment/reassignment/cancellation; same-ticket attachment ownership; durable submissions/reviews/revisions; fractional instructor score; notifications and audits; scenario publish/archive aliases and active counters. 44 checks pass on the isolated testing database, with all generated rows rolled back (20261030-training-contract.log).

IMPLEMENTED BUT NOT VERIFIED by this child through browser: added student-edit modal and SOC ticket inspection/edit/reassign/cancel modal. Existing global AppLayout/header/sidebar/CSS token assets were not modified. New controls use existing components and shared RangeClient, loading/error states, safe output, and truthful API success handling. Parent's complete HTTP/browser run remains responsible for acceptance evidence.

Existing 10-step scenario builder retained. Scenario API wrapper now targets the SOC namespace but uses the same existing ScenarioService, with old compatibility routes preserved by root router. Direct administration links to the student ticket application were replaced with the actual SOC inspector. Dossier inspection links remain in SOC.

Reassignment policy: only open tickets can be reassigned; previous ticket and dataset grants receive revocation timestamps, records and audit history remain, previous owned notebook/model/submission work is never transferred. New student dataset access must be assigned separately. Cancellation keeps the ticket assignment for student visibility while revoking datasets and blocking further progress/submission.

Request retry behavior: ticket-row locks serialize assignment/progress/submission/review changes. Assignment/reassignment/progress/status repeats are no-ops. request_key/Idempotency-Key binds student submission request to one record. Same pending submission body returns the existing record. Same reviewer decision/feedback/score returns the recorded decision without duplicate audit/notification; conflicting second decisions require a new revision.

Forward migrations: 005 adds users.session_version, ticket_assignments revocation fields, nullable unique per-student request keys, and a nonunique iteration lookup index preserving legacy history; 007 changes instructor total_score from INT to DECIMAL(5,2), preserving fractional marks already accepted by the existing form. No data/table reset or user data deletion was performed.

New source: NotFoundException, TrainingReadRepository, SocTrainingService, SocTrainingController, project API module, soc-training.js, ticket management modal partial, guarded training integration test, 005/007 migrations. Existing User/Ticket/Submission/Scenario services/repositories/controllers and matching SOC/project forms were repaired. New inventory/control reports describe each responsibility.

BLOCKED remains external execution/evaluation/inference infrastructure; these changes never enable it. Parent owns complete all-five API module registration, auth session-version validation, safe logging failure handling, navigation and broader testing.
