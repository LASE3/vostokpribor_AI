-- VOSTOKPRIBOR AI Engineering Range
-- Migration: 001_initial_schema.sql
-- Normalized Relational Schema for Multi-User AI Engineering Training Platform

CREATE TABLE IF NOT EXISTS `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `role` ENUM('ADMIN', 'STUDENT') NOT NULL,
    `email` VARCHAR(191) NOT NULL UNIQUE,
    `password_hash` VARCHAR(255) NOT NULL,
    `full_name` VARCHAR(120) NOT NULL,
    `identifier` VARCHAR(64) NOT NULL UNIQUE,
    `cohort` VARCHAR(64) NULL,
    `department` VARCHAR(120) NULL,
    `status` ENUM('ACTIVE', 'INACTIVE', 'SUSPENDED') NOT NULL DEFAULT 'ACTIVE',
    `must_change_password` TINYINT(1) NOT NULL DEFAULT 0,
    `last_login_at` DATETIME NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_users_role` (`role`),
    INDEX `idx_users_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `password_resets` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NOT NULL,
    `token_hash` VARCHAR(64) NOT NULL,
    `expires_at` DATETIME NOT NULL,
    `used_at` DATETIME NULL,
    `created_by` INT NOT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_pw_user` (`user_id`),
    CONSTRAINT `fk_pw_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_pw_creator` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `user_sessions` (
    `id` VARCHAR(128) PRIMARY KEY,
    `user_id` INT NOT NULL,
    `ip_address` VARCHAR(45) NULL,
    `user_agent` TEXT NULL,
    `payload` MEDIUMTEXT NULL,
    `last_activity` INT NOT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_sessions_user` (`user_id`),
    CONSTRAINT `fk_sessions_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `scenarios` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `code` VARCHAR(64) NOT NULL UNIQUE,
    `title` VARCHAR(255) NOT NULL,
    `description` TEXT NULL,
    `difficulty` VARCHAR(32) NOT NULL DEFAULT 'Level 1',
    `department` VARCHAR(120) NOT NULL DEFAULT 'Flight Operations Data Core',
    `status` ENUM('DRAFT', 'PUBLISHED', 'ARCHIVED') NOT NULL DEFAULT 'DRAFT',
    `version` VARCHAR(32) NOT NULL DEFAULT 'v1.0',
    `objectives` TEXT NULL,
    `acceptance_criteria` TEXT NULL,
    `author_id` INT NOT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_scenarios_status` (`status`),
    CONSTRAINT `fk_scenarios_author` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `tickets` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `ticket_code` VARCHAR(64) NOT NULL UNIQUE,
    `scenario_id` INT NULL,
    `title` VARCHAR(255) NOT NULL,
    `description` TEXT NULL,
    `priority` ENUM('CRITICAL', 'HIGH', 'MEDIUM', 'LOW') NOT NULL DEFAULT 'MEDIUM',
    `status` ENUM('DRAFT', 'ASSIGNED', 'IN_PROGRESS', 'SUBMITTED', 'UNDER_REVIEW', 'APPROVED', 'CHANGES_REQUESTED', 'CANCELLED') NOT NULL DEFAULT 'DRAFT',
    `deadline` DATETIME NULL,
    `requirements` TEXT NULL,
    `acceptance_criteria` TEXT NULL,
    `created_by` INT NOT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_tickets_status` (`status`),
    INDEX `idx_tickets_scenario` (`scenario_id`),
    CONSTRAINT `fk_tickets_scenario` FOREIGN KEY (`scenario_id`) REFERENCES `scenarios` (`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_tickets_creator` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `ticket_assignments` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `ticket_id` INT NOT NULL,
    `student_id` INT NOT NULL,
    `assigned_by` INT NOT NULL,
    `assigned_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `notes` TEXT NULL,
    UNIQUE KEY `uk_ticket_student` (`ticket_id`, `student_id`),
    INDEX `idx_assignments_student` (`student_id`),
    CONSTRAINT `fk_assignments_ticket` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_assignments_student` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_assignments_creator` FOREIGN KEY (`assigned_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `ticket_comments` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `ticket_id` INT NOT NULL,
    `user_id` INT NOT NULL,
    `comment` TEXT NOT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_comments_ticket` (`ticket_id`),
    CONSTRAINT `fk_comments_ticket` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_comments_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `ticket_status_history` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `ticket_id` INT NOT NULL,
    `old_status` VARCHAR(32) NULL,
    `new_status` VARCHAR(32) NOT NULL,
    `changed_by` INT NOT NULL,
    `notes` TEXT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_tsh_ticket` (`ticket_id`),
    CONSTRAINT `fk_tsh_ticket` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_tsh_user` FOREIGN KEY (`changed_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `datasets` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `code` VARCHAR(64) NOT NULL UNIQUE,
    `name` VARCHAR(255) NOT NULL,
    `description` TEXT NULL,
    `format` VARCHAR(16) NOT NULL,
    `file_path` VARCHAR(255) NOT NULL,
    `file_size` BIGINT NOT NULL DEFAULT 0,
    `checksum_sha256` VARCHAR(64) NOT NULL,
    `row_count` INT NOT NULL DEFAULT 0,
    `column_count` INT NOT NULL DEFAULT 0,
    `schema_json` JSON NULL,
    `is_master` TINYINT(1) NOT NULL DEFAULT 1,
    `version` VARCHAR(32) NOT NULL DEFAULT 'v1.0',
    `scenario_id` INT NULL,
    `uploaded_by` INT NOT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_datasets_code` (`code`),
    CONSTRAINT `fk_datasets_scenario` FOREIGN KEY (`scenario_id`) REFERENCES `scenarios` (`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_datasets_uploader` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `dataset_assignments` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `dataset_id` INT NOT NULL,
    `student_id` INT NOT NULL,
    `ticket_id` INT NULL,
    `assigned_by` INT NOT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY `uk_dataset_student_ticket` (`dataset_id`, `student_id`, `ticket_id`),
    INDEX `idx_da_student` (`student_id`),
    CONSTRAINT `fk_da_dataset` FOREIGN KEY (`dataset_id`) REFERENCES `datasets` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_da_student` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_da_ticket` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_da_assigner` FOREIGN KEY (`assigned_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `processed_datasets` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `source_dataset_id` INT NOT NULL,
    `student_id` INT NOT NULL,
    `ticket_id` INT NULL,
    `name` VARCHAR(255) NOT NULL,
    `description` TEXT NULL,
    `format` VARCHAR(16) NOT NULL,
    `file_path` VARCHAR(255) NOT NULL,
    `file_size` BIGINT NOT NULL DEFAULT 0,
    `checksum_sha256` VARCHAR(64) NOT NULL,
    `row_count` INT NOT NULL DEFAULT 0,
    `transformation_notes` TEXT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_pd_student` (`student_id`),
    CONSTRAINT `fk_pd_source` FOREIGN KEY (`source_dataset_id`) REFERENCES `datasets` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_pd_student` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_pd_ticket` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `dataset_quality_reports` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `dataset_id` INT NOT NULL,
    `generated_by` INT NOT NULL,
    `metrics_json` JSON NOT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_dqr_dataset` (`dataset_id`),
    CONSTRAINT `fk_dqr_dataset` FOREIGN KEY (`dataset_id`) REFERENCES `datasets` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_dqr_generator` FOREIGN KEY (`generated_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `notebooks` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `code` VARCHAR(64) NOT NULL UNIQUE,
    `title` VARCHAR(255) NOT NULL,
    `student_id` INT NOT NULL,
    `ticket_id` INT NULL,
    `scenario_id` INT NULL,
    `version` INT NOT NULL DEFAULT 1,
    `status` ENUM('ACTIVE', 'SAVED', 'ARCHIVED') NOT NULL DEFAULT 'ACTIVE',
    `kernel_state` VARCHAR(32) NOT NULL DEFAULT 'IDLE',
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_notebooks_student` (`student_id`),
    CONSTRAINT `fk_nb_student` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_nb_ticket` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_nb_scenario` FOREIGN KEY (`scenario_id`) REFERENCES `scenarios` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `notebook_cells` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `notebook_id` INT NOT NULL,
    `cell_order` INT NOT NULL DEFAULT 0,
    `cell_type` ENUM('code', 'markdown') NOT NULL DEFAULT 'code',
    `source` MEDIUMTEXT NOT NULL,
    `execution_count` INT NULL,
    `output_text` MEDIUMTEXT NULL,
    `output_error` MEDIUMTEXT NULL,
    `output_image_path` VARCHAR(255) NULL,
    `last_executed_at` DATETIME NULL,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_nc_notebook` (`notebook_id`, `cell_order`),
    CONSTRAINT `fk_nc_notebook` FOREIGN KEY (`notebook_id`) REFERENCES `notebooks` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `execution_jobs` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `job_uuid` VARCHAR(64) NOT NULL UNIQUE,
    `notebook_id` INT NOT NULL,
    `cell_id` INT NULL,
    `student_id` INT NOT NULL,
    `status` ENUM('QUEUED', 'RUNNING', 'COMPLETED', 'FAILED', 'CANCELLED', 'TIMEOUT') NOT NULL DEFAULT 'QUEUED',
    `code_to_execute` MEDIUMTEXT NOT NULL,
    `stdout` MEDIUMTEXT NULL,
    `stderr` MEDIUMTEXT NULL,
    `artifacts_json` JSON NULL,
    `exit_code` INT NULL,
    `execution_time_ms` INT NULL,
    `memory_peak_mb` FLOAT NULL,
    `started_at` DATETIME NULL,
    `completed_at` DATETIME NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_ej_status` (`status`),
    INDEX `idx_ej_student` (`student_id`),
    CONSTRAINT `fk_ej_notebook` FOREIGN KEY (`notebook_id`) REFERENCES `notebooks` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_ej_student` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `experiments` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `code` VARCHAR(64) NOT NULL UNIQUE,
    `name` VARCHAR(255) NOT NULL,
    `student_id` INT NOT NULL,
    `ticket_id` INT NULL,
    `scenario_id` INT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_exp_student` (`student_id`),
    CONSTRAINT `fk_exp_student` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_exp_ticket` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_exp_scenario` FOREIGN KEY (`scenario_id`) REFERENCES `scenarios` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `experiment_runs` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `run_uuid` VARCHAR(64) NOT NULL UNIQUE,
    `experiment_id` INT NOT NULL,
    `student_id` INT NOT NULL,
    `notebook_id` INT NULL,
    `run_name` VARCHAR(120) NOT NULL,
    `status` ENUM('RUNNING', 'COMPLETED', 'FAILED') NOT NULL DEFAULT 'COMPLETED',
    `parameters` JSON NULL,
    `metrics` JSON NULL,
    `artifacts` JSON NULL,
    `duration_seconds` FLOAT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_er_exp` (`experiment_id`),
    INDEX `idx_er_student` (`student_id`),
    CONSTRAINT `fk_er_exp` FOREIGN KEY (`experiment_id`) REFERENCES `experiments` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_er_student` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_er_notebook` FOREIGN KEY (`notebook_id`) REFERENCES `notebooks` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `models` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `model_code` VARCHAR(64) NOT NULL UNIQUE,
    `name` VARCHAR(255) NOT NULL,
    `framework` VARCHAR(64) NOT NULL,
    `student_id` INT NOT NULL,
    `ticket_id` INT NULL,
    `scenario_id` INT NULL,
    `experiment_run_id` INT NULL,
    `current_version` VARCHAR(32) NOT NULL DEFAULT 'v1.0.0',
    `status` ENUM('REGISTERED', 'VALIDATION_PENDING', 'VALIDATING', 'VALIDATION_PASSED', 'VALIDATION_FAILED', 'REVIEW_PENDING', 'APPROVED', 'REJECTED', 'DEPLOYMENT_PENDING', 'DEPLOYED', 'DEPLOYMENT_FAILED', 'ARCHIVED') NOT NULL DEFAULT 'REGISTERED',
    `description` TEXT NULL,
    `metadata_json` JSON NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_models_student` (`student_id`),
    INDEX `idx_models_status` (`status`),
    CONSTRAINT `fk_models_student` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_models_ticket` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_models_scenario` FOREIGN KEY (`scenario_id`) REFERENCES `scenarios` (`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_models_run` FOREIGN KEY (`experiment_run_id`) REFERENCES `experiment_runs` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `model_versions` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `model_id` INT NOT NULL,
    `version` VARCHAR(32) NOT NULL,
    `artifact_path` VARCHAR(255) NOT NULL,
    `artifact_format` VARCHAR(32) NOT NULL,
    `checksum_sha256` VARCHAR(64) NOT NULL,
    `file_size` BIGINT NOT NULL DEFAULT 0,
    `metrics` JSON NULL,
    `status` VARCHAR(32) NOT NULL DEFAULT 'REGISTERED',
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY `uk_model_version` (`model_id`, `version`),
    CONSTRAINT `fk_mv_model` FOREIGN KEY (`model_id`) REFERENCES `models` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `validation_runs` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `model_id` INT NOT NULL,
    `model_version_id` INT NOT NULL,
    `requested_by` INT NOT NULL,
    `status` ENUM('PENDING', 'RUNNING', 'PASSED', 'FAILED') NOT NULL DEFAULT 'PENDING',
    `score` FLOAT NULL,
    `checks_passed` INT NOT NULL DEFAULT 0,
    `checks_total` INT NOT NULL DEFAULT 0,
    `report_json` JSON NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `completed_at` DATETIME NULL,
    INDEX `idx_vr_model` (`model_id`),
    CONSTRAINT `fk_vr_model` FOREIGN KEY (`model_id`) REFERENCES `models` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_vr_version` FOREIGN KEY (`model_version_id`) REFERENCES `model_versions` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_vr_requester` FOREIGN KEY (`requested_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `deployment_requests` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `model_id` INT NOT NULL,
    `model_version_id` INT NOT NULL,
    `requested_by` INT NOT NULL,
    `environment` VARCHAR(32) NOT NULL DEFAULT 'canary',
    `canary_percentage` INT NOT NULL DEFAULT 10,
    `replicas` INT NOT NULL DEFAULT 1,
    `status` ENUM('PENDING', 'APPROVED', 'REJECTED', 'DEPLOYED', 'FAILED') NOT NULL DEFAULT 'PENDING',
    `admin_id` INT NULL,
    `decision_notes` TEXT NULL,
    `endpoint_url` VARCHAR(255) NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_dr_model` (`model_id`),
    CONSTRAINT `fk_dr_model` FOREIGN KEY (`model_id`) REFERENCES `models` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_dr_version` FOREIGN KEY (`model_version_id`) REFERENCES `model_versions` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_dr_requester` FOREIGN KEY (`requested_by`) REFERENCES `users` (`id`),
    CONSTRAINT `fk_dr_admin` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `submissions` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `submission_code` VARCHAR(64) NOT NULL UNIQUE,
    `ticket_id` INT NOT NULL,
    `student_id` INT NOT NULL,
    `iteration` INT NOT NULL DEFAULT 1,
    `notes` TEXT NULL,
    `model_id` INT NULL,
    `notebook_id` INT NULL,
    `status` ENUM('SUBMITTED', 'UNDER_REVIEW', 'APPROVED', 'CHANGES_REQUESTED', 'REJECTED') NOT NULL DEFAULT 'SUBMITTED',
    `rubric_scores` JSON NULL,
    `total_score` INT NULL,
    `feedback` TEXT NULL,
    `reviewed_by` INT NULL,
    `reviewed_at` DATETIME NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_sub_ticket` (`ticket_id`),
    INDEX `idx_sub_student` (`student_id`),
    INDEX `idx_sub_status` (`status`),
    CONSTRAINT `fk_sub_ticket` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_sub_student` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_sub_model` FOREIGN KEY (`model_id`) REFERENCES `models` (`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_sub_notebook` FOREIGN KEY (`notebook_id`) REFERENCES `notebooks` (`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_sub_reviewer` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `submission_attachments` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `submission_id` INT NOT NULL,
    `attachment_type` VARCHAR(64) NOT NULL,
    `reference_id` INT NULL,
    `file_path` VARCHAR(255) NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_sa_sub` (`submission_id`),
    CONSTRAINT `fk_sa_sub` FOREIGN KEY (`submission_id`) REFERENCES `submissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `notifications` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `message` TEXT NOT NULL,
    `type` VARCHAR(32) NOT NULL DEFAULT 'INFO',
    `link` VARCHAR(255) NULL,
    `is_read` TINYINT(1) NOT NULL DEFAULT 0,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_notif_user` (`user_id`, `is_read`),
    CONSTRAINT `fk_notif_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `audit_logs` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `actor_id` INT NULL,
    `action` VARCHAR(64) NOT NULL,
    `resource_type` VARCHAR(64) NOT NULL,
    `resource_id` VARCHAR(64) NULL,
    `ip_address` VARCHAR(45) NULL,
    `outcome` ENUM('SUCCESS', 'FAILURE', 'DENIED') NOT NULL DEFAULT 'SUCCESS',
    `metadata_json` JSON NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_audit_actor` (`actor_id`),
    INDEX `idx_audit_action` (`action`),
    INDEX `idx_audit_resource` (`resource_type`, `resource_id`),
    CONSTRAINT `fk_audit_actor` FOREIGN KEY (`actor_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `system_settings` (
    `setting_key` VARCHAR(64) PRIMARY KEY,
    `setting_value` TEXT NOT NULL,
    `description` VARCHAR(255) NULL,
    `updated_by` INT NULL,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT `fk_settings_updater` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `rate_limits` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `rate_key` VARCHAR(128) NOT NULL,
    `hits` INT NOT NULL DEFAULT 1,
    `reset_at` INT NOT NULL,
    UNIQUE KEY `uk_rate_key` (`rate_key`),
    INDEX `idx_rate_reset` (`reset_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Migration Tracking Table
CREATE TABLE IF NOT EXISTS `migrations` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `migration` VARCHAR(255) NOT NULL UNIQUE,
    `applied_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
