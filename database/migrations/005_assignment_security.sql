ALTER TABLE users ADD COLUMN session_version BIGINT UNSIGNED NOT NULL DEFAULT 1 AFTER must_change_password;
ALTER TABLE ticket_assignments
    ADD COLUMN revoked_at DATETIME NULL AFTER notes,
    ADD COLUMN revoked_by INT NULL AFTER revoked_at,
    ADD INDEX idx_ta_active (student_id, revoked_at, ticket_id),
    ADD CONSTRAINT fk_ta_revoker FOREIGN KEY (revoked_by) REFERENCES users(id) ON DELETE SET NULL;
ALTER TABLE submissions ADD INDEX idx_submission_iteration (ticket_id, student_id, iteration);

ALTER TABLE submissions ADD COLUMN request_key VARCHAR(128) NULL, ADD UNIQUE KEY uk_submission_request (student_id, request_key);
