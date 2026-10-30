-- Separate administrative annotations from student-authored model metadata.
ALTER TABLE models
    ADD COLUMN admin_metadata_json JSON NULL AFTER metadata_json,
    ADD COLUMN admin_updated_by INT NULL,
    ADD COLUMN admin_updated_at DATETIME NULL,
    ADD CONSTRAINT fk_model_admin_updater FOREIGN KEY (admin_updated_by) REFERENCES users(id);

-- A request/approval is not a runtime deployment.
ALTER TABLE deployment_requests
    ADD COLUMN request_key VARCHAR(64) NULL,
    ADD COLUMN provider_state VARCHAR(32) NOT NULL DEFAULT 'NOT_CONFIGURED',
    ADD UNIQUE KEY uk_deployment_request_key (request_key),
    ADD INDEX idx_deployment_request_owner_state (requested_by, status);
