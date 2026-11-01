-- Preserve historical metrics as unknown evidence; never infer trusted execution.
ALTER TABLE experiment_runs
    ADD COLUMN dataset_version_id INT NULL AFTER notebook_id,
    ADD COLUMN measurement_source ENUM('UNKNOWN','USER_REPORTED','SYSTEM_MEASURED','INDEPENDENTLY_VALIDATED') NOT NULL DEFAULT 'UNKNOWN' AFTER metrics,
    ADD INDEX idx_run_dataset_version (dataset_version_id),
    ADD CONSTRAINT fk_run_dataset_version FOREIGN KEY (dataset_version_id) REFERENCES dataset_versions(id) ON DELETE SET NULL;

-- Cover the existing registry sort without scanning wide metadata rows.
ALTER TABLE models
    ADD INDEX idx_models_updated_id (updated_at,id),
    ADD INDEX idx_models_student_updated_id (student_id,updated_at,id);
