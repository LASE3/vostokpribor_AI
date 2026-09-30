-- ============================================================================
-- VOSTOKPRIBOR AI • CROSS-SYSTEM DATA EXCHANGE SCHEMA
-- Database: vostokpribor_ai
-- ============================================================================

CREATE DATABASE IF NOT EXISTS `vostokpribor_ai` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `vostokpribor_ai`;

-- 1. Subsystems Status & Telemetry
CREATE TABLE IF NOT EXISTS `systems` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `code` VARCHAR(20) NOT NULL UNIQUE,
    `name` VARCHAR(100) NOT NULL,
    `directory` VARCHAR(100) NOT NULL,
    `entry_point` VARCHAR(100) NOT NULL,
    `status` VARCHAR(30) DEFAULT 'OPERATIONAL',
    `health_pct` DECIMAL(5,2) DEFAULT 99.98,
    `uptime` VARCHAR(30) DEFAULT '99.982%',
    `latency_ms` INT DEFAULT 12,
    `last_heartbeat` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 2. Registered AI Models (Workbench, Registry, SOC)
CREATE TABLE IF NOT EXISTS `models` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `model_name` VARCHAR(100) NOT NULL,
    `version` VARCHAR(20) NOT NULL,
    `framework` VARCHAR(50) NOT NULL,
    `accuracy` DECIMAL(5,4) DEFAULT 0.0000,
    `f1_score` DECIMAL(5,4) DEFAULT 0.0000,
    `roc_auc` DECIMAL(5,4) DEFAULT 0.0000,
    `drift_score` DECIMAL(5,4) DEFAULT 0.0000,
    `status` VARCHAR(30) DEFAULT 'STAGED',
    `traffic_pct` INT DEFAULT 0,
    `p99_latency_ms` DECIMAL(5,2) DEFAULT 12.00,
    `author` VARCHAR(100) DEFAULT 'Dr. Alexei Voronov',
    `sha256_hash` VARCHAR(64) DEFAULT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 3. Datasets Catalog (Data Center & Workbench)
CREATE TABLE IF NOT EXISTS `datasets` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `dataset_code` VARCHAR(50) NOT NULL UNIQUE,
    `name` VARCHAR(150) NOT NULL,
    `num_records` INT NOT NULL DEFAULT 0,
    `size_mb` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    `file_format` VARCHAR(20) DEFAULT 'parquet',
    `feature_count` INT DEFAULT 28,
    `provenance` VARCHAR(100) DEFAULT 'Verified Immutable',
    `last_ingested_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 4. Operations Incidents & Alerts (AI SOC & Project Management)
CREATE TABLE IF NOT EXISTS `incidents` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `incident_code` VARCHAR(50) NOT NULL UNIQUE,
    `title` VARCHAR(200) NOT NULL,
    `severity` VARCHAR(20) DEFAULT 'P1 CRITICAL',
    `status` VARCHAR(30) DEFAULT 'INVESTIGATING',
    `model_name` VARCHAR(100) DEFAULT 'churn_rf_v2',
    `assigned_to` VARCHAR(100) DEFAULT 'Alexei V. (Primary SOC)',
    `blast_radius` VARCHAR(150) DEFAULT 'Retention Ingress APAC/EMEA',
    `drift_delta` VARCHAR(50) DEFAULT '-29.8% F1 Collapse',
    `trigger_time` VARCHAR(50) DEFAULT '04:18 UTC',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 5. Project Tasks & Tickets (AI Project Management)
CREATE TABLE IF NOT EXISTS `tickets` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `ticket_code` VARCHAR(30) NOT NULL UNIQUE,
    `title` VARCHAR(200) NOT NULL,
    `project_name` VARCHAR(100) DEFAULT 'Customer Churn Model v2.0',
    `assignee` VARCHAR(100) DEFAULT 'Cadet Sarah Chen',
    `status` VARCHAR(30) DEFAULT 'IN_PROGRESS',
    `priority` VARCHAR(20) DEFAULT 'HIGH',
    `story_points` INT DEFAULT 5,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 6. Live Telemetry Logs
CREATE TABLE IF NOT EXISTS `telemetry_logs` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `node_id` VARCHAR(50) NOT NULL,
    `tflops` DECIMAL(8,2) DEFAULT 88.40,
    `vram_used_gb` DECIMAL(6,2) DEFAULT 78.40,
    `vram_total_gb` DECIMAL(6,2) DEFAULT 80.00,
    `qps` INT DEFAULT 1420,
    `p99_latency_ms` DECIMAL(5,2) DEFAULT 11.40,
    `recorded_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ============================================================================
-- INITIAL SEED DATA
-- ============================================================================

INSERT INTO `systems` (`code`, `name`, `directory`, `entry_point`, `status`, `health_pct`, `uptime`, `latency_ms`) VALUES
('SYS-AI-01', 'AI Project Management', 'AI Project Management', 'Dashboard.php', 'OPERATIONAL', 99.98, '99.982%', 8),
('SYS-AI-02', 'Data Center', 'Data Center', 'DatasetCatalog.php', 'SYNCHRONIZED', 99.99, '99.994%', 5),
('SYS-AI-03', 'AI/ML Workbench', 'AI/ML Workbench', 'WorkbenchHome.php', 'ENGAGED', 99.95, '99.950%', 12),
('SYS-AI-04', 'Model Registry & Deployment', 'Model Registry & Deployment', 'ModelRegistry.php', 'CANARY GATE', 99.98, '99.988%', 11),
('SYS-AI-05', 'AI Operations Center (AI SOC)', 'AI Operations Center (AI SOC)', 'FleetTelemetry.php', 'ALERT ACTIVE', 98.70, '99.910%', 14)
ON DUPLICATE KEY UPDATE `status` = VALUES(`status`);

INSERT INTO `models` (`model_name`, `version`, `framework`, `accuracy`, `f1_score`, `roc_auc`, `drift_score`, `status`, `traffic_pct`, `p99_latency_ms`, `author`, `sha256_hash`) VALUES
('churn_rf_v2', '2.0.4', 'Scikit-Learn 1.3 / ONNX', 0.8920, 0.8740, 0.9120, 0.2980, 'CANARY_10', 10, 11.40, 'Dr. Alexei Voronov', '4f9812ac98b1e4f2081f9b33a780182412891fa1249b6b71b5690b21a1796120'),
('churn_xgb_champion', '1.9.0', 'XGBoost 2.0', 0.8810, 0.8610, 0.9040, 0.0120, 'PRODUCTION', 90, 8.20, 'Cadet Sarah Chen', '8b321aef7190cba2398410298a0912cb491298419208a0b098192cb91823901a'),
('churn_mlp_deep_dense', '0.9.1', 'PyTorch 2.2', 0.7420, 0.7100, 0.7610, 0.4100, 'ARCHIVED', 0, 32.10, 'Intern AI Eng · L2', '91a0c8b21908231908ab19209801928019283019280391820391820391820391')
ON DUPLICATE KEY UPDATE `status` = VALUES(`status`);

INSERT INTO `datasets` (`dataset_code`, `name`, `num_records`, `size_mb`, `file_format`, `feature_count`, `provenance`) VALUES
('DS-TELCO-Q3-V1', 'telecom_q3_v1.parquet', 204000, 48.60, 'parquet', 28, 'Verified Immutable'),
('DS-CRM-FEED-05', 'crm_event_stream_v5.json', 1250000, 312.40, 'json', 14, 'Drifted Stream Source'),
('DS-BILLING-V2', 'enterprise_billing_v2.csv', 88000, 19.20, 'csv', 9, 'Verified Immutable')
ON DUPLICATE KEY UPDATE `num_records` = VALUES(`num_records`);

INSERT INTO `incidents` (`incident_code`, `title`, `severity`, `status`, `model_name`, `assigned_to`, `blast_radius`, `drift_delta`, `trigger_time`) VALUES
('INC-4092', 'F1 Score Degradation on Production Churn Endpoint', 'P1 CRITICAL', 'INVESTIGATING', 'churn_rf_v2', 'Alexei V. (Primary SOC)', 'Enterprise Retention Svc · APAC / EMEA', '0.87 -> 0.61 (-29.8%)', '04:18 UTC'),
('INC-4089', 'Ingress Kafka Consumer Lag on CRM-FEED-05', 'P2 WARNING', 'RESOLVED', 'churn_rf_v2', 'Pipeline Ops Team', 'Ingestion Pipeline', 'Lag: 14,200 msg/s', '02:15 UTC')
ON DUPLICATE KEY UPDATE `status` = VALUES(`status`);

INSERT INTO `tickets` (`ticket_code`, `title`, `project_name`, `assignee`, `status`, `priority`, `story_points`) VALUES
('TK-AI-101', 'Retrain churn_rf_v2 with corrected categorical encoding', 'Customer Churn Model v2.0', 'Sarah Chen', 'IN_PROGRESS', 'CRITICAL', 8),
('TK-AI-102', 'Deploy Canary Traffic Gate 10% to Triton Cluster', 'Customer Churn Model v2.0', 'Alexei Voronov', 'COMPLETED', 'HIGH', 5),
('TK-AI-103', 'Generate Model Card and Bias Compliance Audit', 'Customer Churn Model v2.0', 'Sarah Chen', 'COMPLETED', 'MEDIUM', 3)
ON DUPLICATE KEY UPDATE `status` = VALUES(`status`);

INSERT INTO `telemetry_logs` (`node_id`, `tflops`, `vram_used_gb`, `vram_total_gb`, `qps`, `p99_latency_ms`) VALUES
('ORB-NODE-01', 88.40, 78.40, 80.00, 1420, 11.40);
