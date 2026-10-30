-- Forward-only dataset lifecycle. Existing file references are preserved; no bytes are moved.
ALTER TABLE datasets
    ADD COLUMN current_version_id INT NULL,
    ADD COLUMN archived_at DATETIME NULL,
    ADD COLUMN archived_by INT NULL,
    ADD INDEX idx_datasets_archived (archived_at),
    ADD CONSTRAINT fk_dataset_archiver FOREIGN KEY (archived_by) REFERENCES users(id) ON DELETE SET NULL;

CREATE TABLE dataset_versions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dataset_id INT NOT NULL,
    version VARCHAR(32) NOT NULL,
    format VARCHAR(16) NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    file_size BIGINT NOT NULL,
    checksum_sha256 VARCHAR(64) NOT NULL,
    row_count INT NOT NULL DEFAULT 0,
    column_count INT NOT NULL DEFAULT 0,
    schema_json JSON NULL,
    uploaded_by INT NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uk_dataset_version (dataset_id, version),
    CONSTRAINT fk_dataset_version_dataset FOREIGN KEY (dataset_id) REFERENCES datasets(id),
    CONSTRAINT fk_dataset_version_uploader FOREIGN KEY (uploaded_by) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Convert actual preexisting dataset metadata into its first immutable version.
INSERT INTO dataset_versions (dataset_id,version,format,file_path,file_size,checksum_sha256,row_count,column_count,schema_json,uploaded_by,created_at)
SELECT id,version,format,file_path,file_size,checksum_sha256,row_count,column_count,schema_json,uploaded_by,created_at FROM datasets;
UPDATE datasets d JOIN dataset_versions v ON v.dataset_id=d.id AND v.version=d.version SET d.current_version_id=v.id,d.updated_at=d.updated_at;
ALTER TABLE datasets ADD CONSTRAINT fk_dataset_current_version FOREIGN KEY (current_version_id) REFERENCES dataset_versions(id);

ALTER TABLE dataset_assignments
    ADD COLUMN dataset_version_id INT NULL,
    ADD COLUMN revoked_at DATETIME NULL,
    ADD COLUMN revoked_by INT NULL,
    ADD INDEX idx_dataset_assignment_access (student_id,revoked_at),
    ADD CONSTRAINT fk_dataset_assignment_version FOREIGN KEY (dataset_version_id) REFERENCES dataset_versions(id),
    ADD CONSTRAINT fk_dataset_assignment_revoker FOREIGN KEY (revoked_by) REFERENCES users(id) ON DELETE SET NULL;
UPDATE dataset_assignments a JOIN datasets d ON d.id=a.dataset_id SET a.dataset_version_id=d.current_version_id;

ALTER TABLE processed_datasets
    ADD COLUMN source_dataset_version_id INT NULL,
    ADD COLUMN column_count INT NOT NULL DEFAULT 0,
    ADD COLUMN schema_json JSON NULL,
    ADD CONSTRAINT fk_processed_source_version FOREIGN KEY (source_dataset_version_id) REFERENCES dataset_versions(id);
UPDATE processed_datasets p JOIN datasets d ON d.id=p.source_dataset_id SET p.source_dataset_version_id=d.current_version_id;
