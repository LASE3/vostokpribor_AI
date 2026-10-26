-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 26, 2026 at 03:13 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vostokpribor_ai`
--

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` int(11) NOT NULL,
  `actor_id` int(11) DEFAULT NULL,
  `action` varchar(64) NOT NULL,
  `resource_type` varchar(64) NOT NULL,
  `resource_id` varchar(64) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `outcome` enum('SUCCESS','FAILURE','DENIED') NOT NULL DEFAULT 'SUCCESS',
  `metadata_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata_json`)),
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `audit_logs`
--

INSERT INTO `audit_logs` (`id`, `actor_id`, `action`, `resource_type`, `resource_id`, `ip_address`, `outcome`, `metadata_json`, `created_at`) VALUES
(1, 1, 'BOOTSTRAP_ADMIN_CREATED', 'users', '1', '127.0.0.1', 'SUCCESS', '{\"email\":\"admin@vostokpribor.space\",\"identifier\":\"VK-ADMIN-01\",\"via\":\"CLI_BOOTSTRAP\"}', '2026-10-26 13:39:45'),
(2, 1, 'STUDENT_CREATED', 'users', '2', '127.0.0.1', 'SUCCESS', '{\"identifier\":\"VK-88219\",\"email\":\"cadet.chen@range.vostokpribor.space\",\"cohort\":\"COHORT-24B\"}', '2026-10-26 14:32:41'),
(3, 1, 'DATASET_UPLOADED', 'datasets', '1', '127.0.0.1', 'SUCCESS', '{\"code\":\"DS-CHURN-2CADFE\",\"size\":270,\"sha\":\"d80b3cd9546e88cd00dcbf94448798403052be276db56194665114f66d08f5b0\"}', '2026-10-26 14:32:41'),
(4, 1, 'DATASET_ASSIGNED', 'datasets', '1', '127.0.0.1', 'SUCCESS', '{\"student_id\":2,\"ticket_id\":null}', '2026-10-26 14:32:41'),
(5, 1, 'STUDENT_CREATED', 'users', '3', '127.0.0.1', 'SUCCESS', '{\"identifier\":\"VK-88219\",\"email\":\"cadet.chen@range.vostokpribor.space\",\"cohort\":\"COHORT-24B\"}', '2026-10-26 14:33:34'),
(6, 1, 'DATASET_UPLOADED', 'datasets', '2', '127.0.0.1', 'SUCCESS', '{\"code\":\"DS-CHURN-A4F303\",\"size\":270,\"sha\":\"d80b3cd9546e88cd00dcbf94448798403052be276db56194665114f66d08f5b0\"}', '2026-10-26 14:33:34'),
(7, 1, 'DATASET_ASSIGNED', 'datasets', '2', '127.0.0.1', 'SUCCESS', '{\"student_id\":3,\"ticket_id\":null}', '2026-10-26 14:33:34'),
(8, 1, 'SCENARIO_CREATED', 'scenarios', '1', '127.0.0.1', 'SUCCESS', '{\"code\":\"SCN-CHURN-D377\",\"title\":\"Customer Churn Prediction & Drift Mitigation\"}', '2026-10-26 14:33:34'),
(9, 1, 'TICKET_CREATED', 'tickets', '1', '127.0.0.1', 'SUCCESS', '{\"code\":\"AI-024-2915\",\"title\":\"Predictive Customer Churn Pipeline Engineering\"}', '2026-10-26 14:33:34'),
(10, 1, 'TICKET_ASSIGNED', 'tickets', '1', '127.0.0.1', 'SUCCESS', '{\"student_id\":3,\"student_name\":\"Alex Chen\"}', '2026-10-26 14:33:34'),
(11, NULL, 'NOTEBOOK_CREATED', 'notebooks', '2', '127.0.0.1', 'SUCCESS', '{\"code\":\"NB-592A2D\",\"title\":\"churn_telemetry_pipeline.ipynb\"}', '2026-10-26 14:33:34'),
(12, NULL, 'EXECUTION_JOB_QUEUED', 'execution_jobs', 'JOB-0FC2BD4502B0', '127.0.0.1', 'SUCCESS', '{\"notebook_id\":2}', '2026-10-26 14:33:34'),
(13, NULL, 'EXPERIMENT_CREATED', 'experiments', '1', '127.0.0.1', 'SUCCESS', '{\"code\":\"EXP-CHURN-8C00\"}', '2026-10-26 14:33:34'),
(14, NULL, 'EXPERIMENT_RUN_RECORDED', 'experiment_runs', 'RUN-C3A1E3D1075E', '127.0.0.1', 'SUCCESS', '{\"experiment_id\":1}', '2026-10-26 14:33:34'),
(15, NULL, 'MODEL_REGISTERED', 'models', '1', '127.0.0.1', 'SUCCESS', '{\"code\":\"MOD-CHURN-611B\",\"name\":\"XGBoost Churn Classifier (Prod Candidate)\"}', '2026-10-26 14:33:34'),
(16, NULL, 'MODEL_VERSION_ADDED', 'model_versions', '0', '127.0.0.1', 'SUCCESS', '{\"model_id\":1,\"version\":\"v1.0.0\",\"sha256\":\"a44430d55ddd123791d95db467ba76101f98715ed38af43588bc72c889987819\"}', '2026-10-26 14:33:34'),
(17, 1, 'STUDENT_CREATED', 'users', '4', '127.0.0.1', 'SUCCESS', '{\"identifier\":\"VK-88219\",\"email\":\"cadet.chen@range.vostokpribor.space\",\"cohort\":\"COHORT-24B\"}', '2026-10-26 14:34:19'),
(18, 1, 'DATASET_UPLOADED', 'datasets', '3', '127.0.0.1', 'SUCCESS', '{\"code\":\"DS-CHURN-6C0508\",\"size\":270,\"sha\":\"d80b3cd9546e88cd00dcbf94448798403052be276db56194665114f66d08f5b0\"}', '2026-10-26 14:34:19'),
(19, 1, 'DATASET_ASSIGNED', 'datasets', '3', '127.0.0.1', 'SUCCESS', '{\"student_id\":4,\"ticket_id\":null}', '2026-10-26 14:34:19'),
(20, 1, 'SCENARIO_CREATED', 'scenarios', '2', '127.0.0.1', 'SUCCESS', '{\"code\":\"SCN-CHURN-7161\",\"title\":\"Customer Churn Prediction & Drift Mitigation\"}', '2026-10-26 14:34:19'),
(21, 1, 'TICKET_CREATED', 'tickets', '2', '127.0.0.1', 'SUCCESS', '{\"code\":\"AI-024-F541\",\"title\":\"Predictive Customer Churn Pipeline Engineering\"}', '2026-10-26 14:34:19'),
(22, 1, 'TICKET_ASSIGNED', 'tickets', '2', '127.0.0.1', 'SUCCESS', '{\"student_id\":4,\"student_name\":\"Alex Chen\"}', '2026-10-26 14:34:19'),
(23, 4, 'NOTEBOOK_CREATED', 'notebooks', '3', '127.0.0.1', 'SUCCESS', '{\"code\":\"NB-3AF00E\",\"title\":\"churn_telemetry_pipeline.ipynb\"}', '2026-10-26 14:34:19'),
(24, 4, 'EXECUTION_JOB_QUEUED', 'execution_jobs', 'JOB-8E6730214015', '127.0.0.1', 'SUCCESS', '{\"notebook_id\":3}', '2026-10-26 14:34:19'),
(25, 4, 'EXPERIMENT_CREATED', 'experiments', '2', '127.0.0.1', 'SUCCESS', '{\"code\":\"EXP-CHURN-4BB3\"}', '2026-10-26 14:34:19'),
(26, 4, 'EXPERIMENT_RUN_RECORDED', 'experiment_runs', 'RUN-290C8E17FB74', '127.0.0.1', 'SUCCESS', '{\"experiment_id\":2}', '2026-10-26 14:34:19'),
(27, 4, 'MODEL_REGISTERED', 'models', '2', '127.0.0.1', 'SUCCESS', '{\"code\":\"MOD-CHURN-7279\",\"name\":\"XGBoost Churn Classifier (Prod Candidate)\"}', '2026-10-26 14:34:19'),
(28, 4, 'MODEL_VERSION_ADDED', 'model_versions', '2', '127.0.0.1', 'SUCCESS', '{\"model_id\":2,\"version\":\"v1.0.0\",\"sha256\":\"a44430d55ddd123791d95db467ba76101f98715ed38af43588bc72c889987819\"}', '2026-10-26 14:34:19'),
(29, 4, 'MODEL_VALIDATION_COMPLETED', 'validation_runs', '1', '127.0.0.1', 'SUCCESS', '{\"model_code\":\"MOD-CHURN-7279\",\"outcome\":\"PASSED\",\"score\":100}', '2026-10-26 14:34:19'),
(30, 4, 'DEPLOYMENT_REQUESTED', 'deployment_requests', '1', '127.0.0.1', 'SUCCESS', '{\"model_code\":\"MOD-CHURN-7279\"}', '2026-10-26 14:34:19'),
(31, 4, 'SUBMISSION_CREATED', 'submissions', '1', '127.0.0.1', 'SUCCESS', '{\"code\":\"SUB-AI-024-F541-v1\",\"ticket_id\":2,\"iteration\":1}', '2026-10-26 14:34:19'),
(32, 1, 'SUBMISSION_REVIEWED', 'submissions', '1', '127.0.0.1', 'SUCCESS', '{\"decision\":\"APPROVED\",\"score\":95}', '2026-10-26 14:34:19'),
(33, 1, 'STUDENT_CREATED', 'users', '5', '127.0.0.1', 'SUCCESS', '{\"identifier\":\"VK-88219\",\"email\":\"cadet.chen@range.vostokpribor.space\",\"cohort\":\"COHORT-24B\"}', '2026-10-26 14:35:07'),
(34, 1, 'DATASET_UPLOADED', 'datasets', '4', '127.0.0.1', 'SUCCESS', '{\"code\":\"DS-CHURN-B61F4C\",\"size\":270,\"sha\":\"d80b3cd9546e88cd00dcbf94448798403052be276db56194665114f66d08f5b0\"}', '2026-10-26 14:35:07'),
(35, 1, 'DATASET_ASSIGNED', 'datasets', '4', '127.0.0.1', 'SUCCESS', '{\"student_id\":5,\"ticket_id\":null}', '2026-10-26 14:35:07'),
(36, 1, 'SCENARIO_CREATED', 'scenarios', '3', '127.0.0.1', 'SUCCESS', '{\"code\":\"SCN-CHURN-36F7\",\"title\":\"Customer Churn Prediction & Drift Mitigation\"}', '2026-10-26 14:35:07'),
(37, 1, 'TICKET_CREATED', 'tickets', '3', '127.0.0.1', 'SUCCESS', '{\"code\":\"AI-024-4F34\",\"title\":\"Predictive Customer Churn Pipeline Engineering\"}', '2026-10-26 14:35:07'),
(38, 1, 'TICKET_ASSIGNED', 'tickets', '3', '127.0.0.1', 'SUCCESS', '{\"student_id\":5,\"student_name\":\"Alex Chen\"}', '2026-10-26 14:35:07'),
(39, 5, 'NOTEBOOK_CREATED', 'notebooks', '4', '127.0.0.1', 'SUCCESS', '{\"code\":\"NB-3A9F17\",\"title\":\"churn_telemetry_pipeline.ipynb\"}', '2026-10-26 14:35:07'),
(40, 5, 'EXECUTION_JOB_QUEUED', 'execution_jobs', 'JOB-C650692D7D83', '127.0.0.1', 'SUCCESS', '{\"notebook_id\":4}', '2026-10-26 14:35:07'),
(41, 5, 'EXPERIMENT_CREATED', 'experiments', '3', '127.0.0.1', 'SUCCESS', '{\"code\":\"EXP-CHURN-30DE\"}', '2026-10-26 14:35:07'),
(42, 5, 'EXPERIMENT_RUN_RECORDED', 'experiment_runs', 'RUN-AAFEFF42E50C', '127.0.0.1', 'SUCCESS', '{\"experiment_id\":3}', '2026-10-26 14:35:07'),
(43, 5, 'MODEL_REGISTERED', 'models', '3', '127.0.0.1', 'SUCCESS', '{\"code\":\"MOD-CHURN-FC48\",\"name\":\"XGBoost Churn Classifier (Prod Candidate)\"}', '2026-10-26 14:35:07'),
(44, 5, 'MODEL_VERSION_ADDED', 'model_versions', '3', '127.0.0.1', 'SUCCESS', '{\"model_id\":3,\"version\":\"v1.0.0\",\"sha256\":\"a44430d55ddd123791d95db467ba76101f98715ed38af43588bc72c889987819\"}', '2026-10-26 14:35:07'),
(45, 5, 'MODEL_VALIDATION_COMPLETED', 'validation_runs', '2', '127.0.0.1', 'SUCCESS', '{\"model_code\":\"MOD-CHURN-FC48\",\"outcome\":\"PASSED\",\"score\":100}', '2026-10-26 14:35:07'),
(46, 5, 'DEPLOYMENT_REQUESTED', 'deployment_requests', '2', '127.0.0.1', 'SUCCESS', '{\"model_code\":\"MOD-CHURN-FC48\"}', '2026-10-26 14:35:07'),
(47, 5, 'SUBMISSION_CREATED', 'submissions', '2', '127.0.0.1', 'SUCCESS', '{\"code\":\"SUB-AI-024-4F34-v1\",\"ticket_id\":3,\"iteration\":1}', '2026-10-26 14:35:07'),
(48, 1, 'SUBMISSION_REVIEWED', 'submissions', '2', '127.0.0.1', 'SUCCESS', '{\"decision\":\"APPROVED\",\"score\":95}', '2026-10-26 14:35:07'),
(49, 1, 'STUDENT_CREATED', 'users', '6', '127.0.0.1', 'SUCCESS', '{\"identifier\":\"VK-88219\",\"email\":\"cadet.chen@range.vostokpribor.space\",\"cohort\":\"COHORT-24B\"}', '2026-10-26 14:36:24'),
(50, 1, 'DATASET_UPLOADED', 'datasets', '5', '127.0.0.1', 'SUCCESS', '{\"code\":\"DS-CHURN-0AB992\",\"size\":270,\"sha\":\"d80b3cd9546e88cd00dcbf94448798403052be276db56194665114f66d08f5b0\"}', '2026-10-26 14:36:25'),
(51, 1, 'DATASET_ASSIGNED', 'datasets', '5', '127.0.0.1', 'SUCCESS', '{\"student_id\":6,\"ticket_id\":null}', '2026-10-26 14:36:25'),
(52, 1, 'SCENARIO_CREATED', 'scenarios', '4', '127.0.0.1', 'SUCCESS', '{\"code\":\"SCN-CHURN-38F3\",\"title\":\"Customer Churn Prediction & Drift Mitigation\"}', '2026-10-26 14:36:25'),
(53, 1, 'TICKET_CREATED', 'tickets', '4', '127.0.0.1', 'SUCCESS', '{\"code\":\"AI-024-A0BC\",\"title\":\"Predictive Customer Churn Pipeline Engineering\"}', '2026-10-26 14:36:25'),
(54, 1, 'TICKET_ASSIGNED', 'tickets', '4', '127.0.0.1', 'SUCCESS', '{\"student_id\":6,\"student_name\":\"Alex Chen\"}', '2026-10-26 14:36:25'),
(55, 6, 'NOTEBOOK_CREATED', 'notebooks', '5', '127.0.0.1', 'SUCCESS', '{\"code\":\"NB-7BF92B\",\"title\":\"churn_telemetry_pipeline.ipynb\"}', '2026-10-26 14:36:25'),
(56, 6, 'EXECUTION_JOB_QUEUED', 'execution_jobs', 'JOB-0A09A447E13C', '127.0.0.1', 'SUCCESS', '{\"notebook_id\":5}', '2026-10-26 14:36:25'),
(57, 6, 'EXPERIMENT_CREATED', 'experiments', '4', '127.0.0.1', 'SUCCESS', '{\"code\":\"EXP-CHURN-8873\"}', '2026-10-26 14:36:25'),
(58, 6, 'EXPERIMENT_RUN_RECORDED', 'experiment_runs', 'RUN-15BD263C5FC4', '127.0.0.1', 'SUCCESS', '{\"experiment_id\":4}', '2026-10-26 14:36:25'),
(59, 6, 'MODEL_REGISTERED', 'models', '4', '127.0.0.1', 'SUCCESS', '{\"code\":\"MOD-CHURN-AFE2\",\"name\":\"XGBoost Churn Classifier (Prod Candidate)\"}', '2026-10-26 14:36:25'),
(60, 6, 'MODEL_VERSION_ADDED', 'model_versions', '4', '127.0.0.1', 'SUCCESS', '{\"model_id\":4,\"version\":\"v1.0.0\",\"sha256\":\"a44430d55ddd123791d95db467ba76101f98715ed38af43588bc72c889987819\"}', '2026-10-26 14:36:25'),
(61, 6, 'MODEL_VALIDATION_COMPLETED', 'validation_runs', '3', '127.0.0.1', 'SUCCESS', '{\"model_code\":\"MOD-CHURN-AFE2\",\"outcome\":\"PASSED\",\"score\":100}', '2026-10-26 14:36:25'),
(62, 6, 'DEPLOYMENT_REQUESTED', 'deployment_requests', '3', '127.0.0.1', 'SUCCESS', '{\"model_code\":\"MOD-CHURN-AFE2\"}', '2026-10-26 14:36:25'),
(63, 6, 'SUBMISSION_CREATED', 'submissions', '3', '127.0.0.1', 'SUCCESS', '{\"code\":\"SUB-AI-024-A0BC-v1\",\"ticket_id\":4,\"iteration\":1}', '2026-10-26 14:36:25'),
(64, 1, 'SUBMISSION_REVIEWED', 'submissions', '3', '127.0.0.1', 'SUCCESS', '{\"decision\":\"APPROVED\",\"score\":95}', '2026-10-26 14:36:25'),
(65, 1, 'STUDENT_CREATED', 'users', '7', '127.0.0.1', 'SUCCESS', '{\"identifier\":\"VK-88219\",\"email\":\"cadet.chen@range.vostokpribor.space\",\"cohort\":\"COHORT-24B\"}', '2026-10-26 14:37:45'),
(66, 1, 'DATASET_UPLOADED', 'datasets', '6', '127.0.0.1', 'SUCCESS', '{\"code\":\"DS-CHURN-E64C71\",\"size\":270,\"sha\":\"d80b3cd9546e88cd00dcbf94448798403052be276db56194665114f66d08f5b0\"}', '2026-10-26 14:37:45'),
(67, 1, 'DATASET_ASSIGNED', 'datasets', '6', '127.0.0.1', 'SUCCESS', '{\"student_id\":7,\"ticket_id\":null}', '2026-10-26 14:37:45'),
(68, 1, 'SCENARIO_CREATED', 'scenarios', '5', '127.0.0.1', 'SUCCESS', '{\"code\":\"SCN-CHURN-89DC\",\"title\":\"Customer Churn Prediction & Drift Mitigation\"}', '2026-10-26 14:37:45'),
(69, 1, 'TICKET_CREATED', 'tickets', '5', '127.0.0.1', 'SUCCESS', '{\"code\":\"AI-024-B9DB\",\"title\":\"Predictive Customer Churn Pipeline Engineering\"}', '2026-10-26 14:37:45'),
(70, 1, 'TICKET_ASSIGNED', 'tickets', '5', '127.0.0.1', 'SUCCESS', '{\"student_id\":7,\"student_name\":\"Alex Chen\"}', '2026-10-26 14:37:45'),
(71, 7, 'NOTEBOOK_CREATED', 'notebooks', '6', '127.0.0.1', 'SUCCESS', '{\"code\":\"NB-BB61CD\",\"title\":\"churn_telemetry_pipeline.ipynb\"}', '2026-10-26 14:37:45'),
(72, 7, 'EXECUTION_JOB_QUEUED', 'execution_jobs', 'JOB-031E9BD4E8BA', '127.0.0.1', 'SUCCESS', '{\"notebook_id\":6}', '2026-10-26 14:37:45'),
(73, 7, 'EXPERIMENT_CREATED', 'experiments', '5', '127.0.0.1', 'SUCCESS', '{\"code\":\"EXP-CHURN-8161\"}', '2026-10-26 14:37:46'),
(74, 7, 'EXPERIMENT_RUN_RECORDED', 'experiment_runs', 'RUN-3017DB35EB9B', '127.0.0.1', 'SUCCESS', '{\"experiment_id\":5}', '2026-10-26 14:37:46'),
(75, 7, 'MODEL_REGISTERED', 'models', '5', '127.0.0.1', 'SUCCESS', '{\"code\":\"MOD-CHURN-B601\",\"name\":\"XGBoost Churn Classifier (Prod Candidate)\"}', '2026-10-26 14:37:46'),
(76, 7, 'MODEL_VERSION_ADDED', 'model_versions', '5', '127.0.0.1', 'SUCCESS', '{\"model_id\":5,\"version\":\"v1.0.0\",\"sha256\":\"a44430d55ddd123791d95db467ba76101f98715ed38af43588bc72c889987819\"}', '2026-10-26 14:37:46'),
(77, 7, 'MODEL_VALIDATION_COMPLETED', 'validation_runs', '4', '127.0.0.1', 'SUCCESS', '{\"model_code\":\"MOD-CHURN-B601\",\"outcome\":\"PASSED\",\"score\":100}', '2026-10-26 14:37:46'),
(78, 7, 'DEPLOYMENT_REQUESTED', 'deployment_requests', '4', '127.0.0.1', 'SUCCESS', '{\"model_code\":\"MOD-CHURN-B601\"}', '2026-10-26 14:37:46'),
(79, 7, 'SUBMISSION_CREATED', 'submissions', '4', '127.0.0.1', 'SUCCESS', '{\"code\":\"SUB-AI-024-B9DB-v1\",\"ticket_id\":5,\"iteration\":1}', '2026-10-26 14:37:46'),
(80, 1, 'SUBMISSION_REVIEWED', 'submissions', '4', '127.0.0.1', 'SUCCESS', '{\"decision\":\"APPROVED\",\"score\":95}', '2026-10-26 14:37:46'),
(81, 1, 'STUDENT_CREATED', 'users', '8', '127.0.0.1', 'SUCCESS', '{\"identifier\":\"VK-AUDIT-99\",\"email\":\"cadet.audit.test@range.vostokpribor.space\",\"cohort\":\"COHORT-2026\"}', '2026-10-26 15:28:07'),
(82, NULL, 'ACCESS_DENIED', 'route', '', '127.0.0.1', 'DENIED', '{\"user_role\":\"STUDENT\",\"required_roles\":[\"ADMIN\"]}', '2026-10-26 15:28:07'),
(83, 1, 'STUDENT_CREATED', 'users', '9', '127.0.0.1', 'SUCCESS', '{\"identifier\":\"VK-AUDIT-99\",\"email\":\"cadet.audit.test@range.vostokpribor.space\",\"cohort\":\"COHORT-2026\"}', '2026-10-26 15:28:32'),
(84, 1, 'SCENARIO_CREATED', 'scenarios', '6', '127.0.0.1', 'SUCCESS', '{\"code\":\"SCN-AUDIT-6ADF4770BC912\",\"title\":\"Audit Mission: High-Altitude Avionics\"}', '2026-10-26 15:28:32'),
(85, 1, 'TICKET_CREATED', 'tickets', '6', '127.0.0.1', 'SUCCESS', '{\"code\":\"TCK-AUD-DDA8\",\"title\":\"Calibrate Telemetry Sensor Model\"}', '2026-10-26 15:28:32'),
(86, 1, 'TICKET_ASSIGNED', 'tickets', '6', '127.0.0.1', 'SUCCESS', '{\"student_id\":9,\"student_name\":\"Audit Cadet Test\"}', '2026-10-26 15:28:32'),
(87, 1, 'STUDENT_CREATED', 'users', '10', '127.0.0.1', 'SUCCESS', '{\"identifier\":\"VK-AUDIT-99\",\"email\":\"cadet.audit.test@range.vostokpribor.space\",\"cohort\":\"COHORT-2026\"}', '2026-10-26 15:29:50'),
(88, NULL, 'ACCESS_DENIED', 'route', '', '127.0.0.1', 'DENIED', '{\"user_role\":\"STUDENT\",\"required_roles\":[\"ADMIN\"]}', '2026-10-26 15:29:50'),
(89, 1, 'SCENARIO_CREATED', 'scenarios', '7', '127.0.0.1', 'SUCCESS', '{\"code\":\"SCN-AUDIT-6ADF47BEDB1F7\",\"title\":\"Audit Mission: High-Altitude Avionics\"}', '2026-10-26 15:29:50'),
(90, 1, 'TICKET_CREATED', 'tickets', '7', '127.0.0.1', 'SUCCESS', '{\"code\":\"TCK-AUD-BBB6\",\"title\":\"Calibrate Telemetry Sensor Model\"}', '2026-10-26 15:29:50'),
(91, 1, 'TICKET_ASSIGNED', 'tickets', '7', '127.0.0.1', 'SUCCESS', '{\"student_id\":10,\"student_name\":\"Audit Cadet Test\"}', '2026-10-26 15:29:50'),
(92, 1, 'STUDENT_CREATED', 'users', '11', '127.0.0.1', 'SUCCESS', '{\"identifier\":\"VK-AUDIT-99\",\"email\":\"cadet.audit.test@range.vostokpribor.space\",\"cohort\":\"COHORT-2026\"}', '2026-10-26 15:30:42'),
(93, NULL, 'ACCESS_DENIED', 'route', '', '127.0.0.1', 'DENIED', '{\"user_role\":\"STUDENT\",\"required_roles\":[\"ADMIN\"]}', '2026-10-26 15:30:42'),
(94, 1, 'SCENARIO_CREATED', 'scenarios', '8', '127.0.0.1', 'SUCCESS', '{\"code\":\"SCN-AUDIT-6ADF47F2C8854\",\"title\":\"Audit Mission: High-Altitude Avionics\"}', '2026-10-26 15:30:42'),
(95, 1, 'TICKET_CREATED', 'tickets', '8', '127.0.0.1', 'SUCCESS', '{\"code\":\"TCK-AUD-9887\",\"title\":\"Calibrate Telemetry Sensor Model\"}', '2026-10-26 15:30:42'),
(96, 1, 'TICKET_ASSIGNED', 'tickets', '8', '127.0.0.1', 'SUCCESS', '{\"student_id\":11,\"student_name\":\"Audit Cadet Test\"}', '2026-10-26 15:30:42'),
(97, 1, 'DATASET_UPLOADED', 'datasets', '7', '127.0.0.1', 'SUCCESS', '{\"code\":\"DS-AUDIT-D1AA\",\"size\":78,\"sha\":\"e2ade6f0b34d92dedf99a24abe4ac7d8e6278455cd456570e9430d93f43b2bc9\"}', '2026-10-26 15:30:42'),
(98, 1, 'DATASET_ASSIGNED', 'datasets', '7', '127.0.0.1', 'SUCCESS', '{\"student_id\":11,\"ticket_id\":null}', '2026-10-26 15:30:42'),
(99, 1, 'DATASET_UPLOADED', 'datasets', '8', '127.0.0.1', 'SUCCESS', '{\"code\":\"DS-FACULTY-F2CF\",\"size\":12,\"sha\":\"b6905220f2319aa9e84f7e7812b38356f13917d5d230c302197ef0ce29aee9ee\"}', '2026-10-26 15:30:42'),
(100, NULL, 'PROCESSED_DATASET_UPLOADED', 'processed_datasets', '1', '127.0.0.1', 'SUCCESS', '{\"source_id\":7,\"ticket_id\":8}', '2026-10-26 15:30:42'),
(101, NULL, 'NOTEBOOK_CREATED', 'notebooks', '7', '127.0.0.1', 'SUCCESS', '{\"code\":\"NB-AUD-2F7D\",\"title\":\"telemetry_calibration_nb.ipynb\"}', '2026-10-26 15:30:42'),
(102, 1, 'STUDENT_CREATED', 'users', '12', '127.0.0.1', 'SUCCESS', '{\"identifier\":\"VK-AUD-92\",\"email\":\"cadet2.audit@range.vostokpribor.space\",\"cohort\":\"Cohort 2025-A\"}', '2026-10-26 15:30:43'),
(103, NULL, 'EXECUTION_JOB_QUEUED', 'execution_jobs', 'JOB-DA04DCF6D480', '127.0.0.1', 'SUCCESS', '{\"notebook_id\":7}', '2026-10-26 15:30:43'),
(104, 1, 'STUDENT_CREATED', 'users', '13', '127.0.0.1', 'SUCCESS', '{\"identifier\":\"VK-AUDIT-99\",\"email\":\"cadet.audit.test@range.vostokpribor.space\",\"cohort\":\"COHORT-2026\"}', '2026-10-26 15:31:33'),
(105, NULL, 'ACCESS_DENIED', 'route', '', '127.0.0.1', 'DENIED', '{\"user_role\":\"STUDENT\",\"required_roles\":[\"ADMIN\"]}', '2026-10-26 15:31:34'),
(106, 1, 'SCENARIO_CREATED', 'scenarios', '9', '127.0.0.1', 'SUCCESS', '{\"code\":\"SCN-AUDIT-6ADF4826267D6\",\"title\":\"Audit Mission: High-Altitude Avionics\"}', '2026-10-26 15:31:34'),
(107, 1, 'TICKET_CREATED', 'tickets', '9', '127.0.0.1', 'SUCCESS', '{\"code\":\"TCK-AUD-737B\",\"title\":\"Calibrate Telemetry Sensor Model\"}', '2026-10-26 15:31:34'),
(108, 1, 'TICKET_ASSIGNED', 'tickets', '9', '127.0.0.1', 'SUCCESS', '{\"student_id\":13,\"student_name\":\"Audit Cadet Test\"}', '2026-10-26 15:31:34'),
(109, 1, 'DATASET_UPLOADED', 'datasets', '9', '127.0.0.1', 'SUCCESS', '{\"code\":\"DS-AUDIT-B814\",\"size\":78,\"sha\":\"e2ade6f0b34d92dedf99a24abe4ac7d8e6278455cd456570e9430d93f43b2bc9\"}', '2026-10-26 15:31:34'),
(110, 1, 'DATASET_ASSIGNED', 'datasets', '9', '127.0.0.1', 'SUCCESS', '{\"student_id\":13,\"ticket_id\":null}', '2026-10-26 15:31:34'),
(111, 1, 'DATASET_UPLOADED', 'datasets', '10', '127.0.0.1', 'SUCCESS', '{\"code\":\"DS-FACULTY-E1A1\",\"size\":12,\"sha\":\"b6905220f2319aa9e84f7e7812b38356f13917d5d230c302197ef0ce29aee9ee\"}', '2026-10-26 15:31:34'),
(112, NULL, 'PROCESSED_DATASET_UPLOADED', 'processed_datasets', '2', '127.0.0.1', 'SUCCESS', '{\"source_id\":9,\"ticket_id\":9}', '2026-10-26 15:31:34'),
(113, NULL, 'NOTEBOOK_CREATED', 'notebooks', '8', '127.0.0.1', 'SUCCESS', '{\"code\":\"NB-AUD-02F4\",\"title\":\"telemetry_calibration_nb.ipynb\"}', '2026-10-26 15:31:34'),
(114, 1, 'STUDENT_CREATED', 'users', '14', '127.0.0.1', 'SUCCESS', '{\"identifier\":\"VK-AUDIT-99\",\"email\":\"cadet.audit.test@range.vostokpribor.space\",\"cohort\":\"COHORT-2026\"}', '2026-10-26 15:31:55'),
(115, NULL, 'ACCESS_DENIED', 'route', '', '127.0.0.1', 'DENIED', '{\"user_role\":\"STUDENT\",\"required_roles\":[\"ADMIN\"]}', '2026-10-26 15:31:55'),
(116, 1, 'SCENARIO_CREATED', 'scenarios', '10', '127.0.0.1', 'SUCCESS', '{\"code\":\"SCN-AUDIT-6ADF483BCB2AB\",\"title\":\"Audit Mission: High-Altitude Avionics\"}', '2026-10-26 15:31:55'),
(117, 1, 'TICKET_CREATED', 'tickets', '10', '127.0.0.1', 'SUCCESS', '{\"code\":\"TCK-AUD-BCC3\",\"title\":\"Calibrate Telemetry Sensor Model\"}', '2026-10-26 15:31:55'),
(118, 1, 'TICKET_ASSIGNED', 'tickets', '10', '127.0.0.1', 'SUCCESS', '{\"student_id\":14,\"student_name\":\"Audit Cadet Test\"}', '2026-10-26 15:31:55'),
(119, 1, 'DATASET_UPLOADED', 'datasets', '11', '127.0.0.1', 'SUCCESS', '{\"code\":\"DS-AUDIT-F0AD\",\"size\":78,\"sha\":\"e2ade6f0b34d92dedf99a24abe4ac7d8e6278455cd456570e9430d93f43b2bc9\"}', '2026-10-26 15:31:55'),
(120, 1, 'DATASET_ASSIGNED', 'datasets', '11', '127.0.0.1', 'SUCCESS', '{\"student_id\":14,\"ticket_id\":null}', '2026-10-26 15:31:55'),
(121, 1, 'DATASET_UPLOADED', 'datasets', '12', '127.0.0.1', 'SUCCESS', '{\"code\":\"DS-FACULTY-0F25\",\"size\":12,\"sha\":\"b6905220f2319aa9e84f7e7812b38356f13917d5d230c302197ef0ce29aee9ee\"}', '2026-10-26 15:31:55'),
(122, NULL, 'PROCESSED_DATASET_UPLOADED', 'processed_datasets', '3', '127.0.0.1', 'SUCCESS', '{\"source_id\":11,\"ticket_id\":10}', '2026-10-26 15:31:55'),
(123, NULL, 'NOTEBOOK_CREATED', 'notebooks', '9', '127.0.0.1', 'SUCCESS', '{\"code\":\"NB-AUD-2ED3\",\"title\":\"telemetry_calibration_nb.ipynb\"}', '2026-10-26 15:31:55'),
(124, 1, 'STUDENT_CREATED', 'users', '15', '127.0.0.1', 'SUCCESS', '{\"identifier\":\"VK-AUD-3A9A\",\"email\":\"cadet2_6adf483bd3a98@range.vostokpribor.space\",\"cohort\":\"Cohort 2025-A\"}', '2026-10-26 15:31:56'),
(125, NULL, 'EXECUTION_JOB_QUEUED', 'execution_jobs', 'JOB-05023FA19534', '127.0.0.1', 'SUCCESS', '{\"notebook_id\":9}', '2026-10-26 15:31:56'),
(126, NULL, 'MODEL_REGISTERED', 'models', '6', '127.0.0.1', 'SUCCESS', '{\"code\":\"VP-MOD-AUDIT-EF1E\",\"name\":\"High-G Avionics Predictor\"}', '2026-10-26 15:31:56'),
(127, NULL, 'MODEL_VERSION_ADDED', 'model_versions', '6', '127.0.0.1', 'SUCCESS', '{\"model_id\":6,\"version\":\"v1.0.0\",\"sha256\":\"8e45e4734517c65e4280ac5a7de92587c2d214fcb609fbc2da63460b505a9440\"}', '2026-10-26 15:31:56'),
(128, NULL, 'MODEL_VALIDATION_COMPLETED', 'validation_runs', '5', '127.0.0.1', 'SUCCESS', '{\"model_code\":\"VP-MOD-AUDIT-EF1E\",\"outcome\":\"FAILED\",\"score\":50}', '2026-10-26 15:31:56'),
(129, NULL, 'DEPLOYMENT_REQUESTED', 'deployment_requests', '5', '127.0.0.1', 'SUCCESS', '{\"model_code\":\"VP-MOD-AUDIT-EF1E\"}', '2026-10-26 15:31:56'),
(130, 1, 'DEPLOYMENT_DECISION', 'deployment_requests', '5', '127.0.0.1', 'SUCCESS', '{\"decision\":\"DEPLOYED\",\"traffic\":null}', '2026-10-26 15:31:56'),
(131, 1, 'STUDENT_CREATED', 'users', '16', '127.0.0.1', 'SUCCESS', '{\"identifier\":\"VK-AUDIT-99\",\"email\":\"cadet.audit.test@range.vostokpribor.space\",\"cohort\":\"COHORT-2026\"}', '2026-10-26 15:33:38'),
(132, 16, 'ACCESS_DENIED', 'route', '', '127.0.0.1', 'DENIED', '{\"user_role\":\"STUDENT\",\"required_roles\":[\"ADMIN\"]}', '2026-10-26 15:33:38'),
(133, 1, 'SCENARIO_CREATED', 'scenarios', '11', '127.0.0.1', 'SUCCESS', '{\"code\":\"SCN-AUDIT-6ADF48A28AE24\",\"title\":\"Audit Mission: High-Altitude Avionics\"}', '2026-10-26 15:33:38'),
(134, 1, 'TICKET_CREATED', 'tickets', '11', '127.0.0.1', 'SUCCESS', '{\"code\":\"TCK-AUD-BF29\",\"title\":\"Calibrate Telemetry Sensor Model\"}', '2026-10-26 15:33:38'),
(135, 1, 'TICKET_ASSIGNED', 'tickets', '11', '127.0.0.1', 'SUCCESS', '{\"student_id\":16,\"student_name\":\"Audit Cadet Test\"}', '2026-10-26 15:33:38'),
(136, 1, 'DATASET_UPLOADED', 'datasets', '13', '127.0.0.1', 'SUCCESS', '{\"code\":\"DS-AUDIT-0323\",\"size\":78,\"sha\":\"e2ade6f0b34d92dedf99a24abe4ac7d8e6278455cd456570e9430d93f43b2bc9\"}', '2026-10-26 15:33:38'),
(137, 1, 'DATASET_ASSIGNED', 'datasets', '13', '127.0.0.1', 'SUCCESS', '{\"student_id\":16,\"ticket_id\":null}', '2026-10-26 15:33:38'),
(138, 1, 'DATASET_UPLOADED', 'datasets', '14', '127.0.0.1', 'SUCCESS', '{\"code\":\"DS-FACULTY-275D\",\"size\":12,\"sha\":\"b6905220f2319aa9e84f7e7812b38356f13917d5d230c302197ef0ce29aee9ee\"}', '2026-10-26 15:33:38'),
(139, 16, 'PROCESSED_DATASET_UPLOADED', 'processed_datasets', '4', '127.0.0.1', 'SUCCESS', '{\"source_id\":13,\"ticket_id\":11}', '2026-10-26 15:33:38'),
(140, 16, 'NOTEBOOK_CREATED', 'notebooks', '10', '127.0.0.1', 'SUCCESS', '{\"code\":\"NB-AUD-4CE9\",\"title\":\"telemetry_calibration_nb.ipynb\"}', '2026-10-26 15:33:38'),
(141, 1, 'STUDENT_CREATED', 'users', '17', '127.0.0.1', 'SUCCESS', '{\"identifier\":\"VK-AUD-564D\",\"email\":\"cadet2_6adf48a29564c@range.vostokpribor.space\",\"cohort\":\"Cohort 2025-A\"}', '2026-10-26 15:33:38'),
(142, 16, 'EXECUTION_JOB_QUEUED', 'execution_jobs', 'JOB-DD0E4FEC4C7F', '127.0.0.1', 'SUCCESS', '{\"notebook_id\":10}', '2026-10-26 15:33:38'),
(143, 16, 'MODEL_REGISTERED', 'models', '7', '127.0.0.1', 'SUCCESS', '{\"code\":\"VP-MOD-AUDIT-A5A8\",\"name\":\"High-G Avionics Predictor\"}', '2026-10-26 15:33:38'),
(144, 16, 'MODEL_VERSION_ADDED', 'model_versions', '7', '127.0.0.1', 'SUCCESS', '{\"model_id\":7,\"version\":\"v1.0.0\",\"sha256\":\"8e45e4734517c65e4280ac5a7de92587c2d214fcb609fbc2da63460b505a9440\"}', '2026-10-26 15:33:38'),
(145, 16, 'MODEL_VALIDATION_COMPLETED', 'validation_runs', '6', '127.0.0.1', 'SUCCESS', '{\"model_code\":\"VP-MOD-AUDIT-A5A8\",\"outcome\":\"FAILED\",\"score\":50}', '2026-10-26 15:33:38'),
(146, 16, 'DEPLOYMENT_REQUESTED', 'deployment_requests', '6', '127.0.0.1', 'SUCCESS', '{\"model_code\":\"VP-MOD-AUDIT-A5A8\"}', '2026-10-26 15:33:38'),
(147, 1, 'DEPLOYMENT_DECISION', 'deployment_requests', '6', '127.0.0.1', 'SUCCESS', '{\"decision\":\"DEPLOYED\",\"traffic\":null}', '2026-10-26 15:33:38'),
(148, 16, 'SUBMISSION_CREATED', 'submissions', '5', '127.0.0.1', 'SUCCESS', '{\"code\":\"SUB-TCK-AUD-BF29-v1\",\"ticket_id\":11,\"iteration\":1}', '2026-10-26 15:33:38'),
(149, 1, 'SUBMISSION_REVIEWED', 'submissions', '5', '127.0.0.1', 'SUCCESS', '{\"decision\":\"APPROVED\",\"score\":95}', '2026-10-26 15:33:38'),
(150, 1, 'STUDENT_CREATED', 'users', '18', '127.0.0.1', 'SUCCESS', '{\"identifier\":\"VK-AUD-C63E9\",\"email\":\"cadet.audit.c63e9@range.vostokpribor.space\",\"cohort\":\"COHORT-2026\"}', '2026-10-26 15:35:59'),
(151, 18, 'ACCESS_DENIED', 'route', '', '127.0.0.1', 'DENIED', '{\"user_role\":\"STUDENT\",\"required_roles\":[\"ADMIN\"]}', '2026-10-26 15:36:00'),
(152, 1, 'SCENARIO_CREATED', 'scenarios', '12', '127.0.0.1', 'SUCCESS', '{\"code\":\"SCN-AUDIT-6ADF493075A7C\",\"title\":\"Audit Mission: High-Altitude Avionics\"}', '2026-10-26 15:36:00'),
(153, 1, 'TICKET_CREATED', 'tickets', '12', '127.0.0.1', 'SUCCESS', '{\"code\":\"TCK-AUD-68EA\",\"title\":\"Calibrate Telemetry Sensor Model\"}', '2026-10-26 15:36:00'),
(154, 1, 'TICKET_ASSIGNED', 'tickets', '12', '127.0.0.1', 'SUCCESS', '{\"student_id\":18,\"student_name\":\"Audit Cadet Test\"}', '2026-10-26 15:36:00'),
(155, 1, 'DATASET_UPLOADED', 'datasets', '15', '127.0.0.1', 'SUCCESS', '{\"code\":\"DS-AUDIT-A77C\",\"size\":78,\"sha\":\"e2ade6f0b34d92dedf99a24abe4ac7d8e6278455cd456570e9430d93f43b2bc9\"}', '2026-10-26 15:36:00'),
(156, 1, 'DATASET_ASSIGNED', 'datasets', '15', '127.0.0.1', 'SUCCESS', '{\"student_id\":18,\"ticket_id\":null}', '2026-10-26 15:36:00'),
(157, 1, 'DATASET_UPLOADED', 'datasets', '16', '127.0.0.1', 'SUCCESS', '{\"code\":\"DS-FACULTY-C702\",\"size\":12,\"sha\":\"b6905220f2319aa9e84f7e7812b38356f13917d5d230c302197ef0ce29aee9ee\"}', '2026-10-26 15:36:00'),
(158, 18, 'PROCESSED_DATASET_UPLOADED', 'processed_datasets', '5', '127.0.0.1', 'SUCCESS', '{\"source_id\":15,\"ticket_id\":12}', '2026-10-26 15:36:00'),
(159, 18, 'NOTEBOOK_CREATED', 'notebooks', '11', '127.0.0.1', 'SUCCESS', '{\"code\":\"NB-AUD-EFF0\",\"title\":\"telemetry_calibration_nb.ipynb\"}', '2026-10-26 15:36:00'),
(160, 1, 'STUDENT_CREATED', 'users', '19', '127.0.0.1', 'SUCCESS', '{\"identifier\":\"VK-AUD-FD14\",\"email\":\"cadet2_6adf49307fd11@range.vostokpribor.space\",\"cohort\":\"Cohort 2025-A\"}', '2026-10-26 15:36:00'),
(161, 18, 'EXECUTION_JOB_QUEUED', 'execution_jobs', 'JOB-075E6048F0D9', '127.0.0.1', 'SUCCESS', '{\"notebook_id\":11}', '2026-10-26 15:36:00'),
(162, 18, 'MODEL_REGISTERED', 'models', '8', '127.0.0.1', 'SUCCESS', '{\"code\":\"VP-MOD-AUDIT-D957\",\"name\":\"High-G Avionics Predictor\"}', '2026-10-26 15:36:00'),
(163, 18, 'MODEL_VERSION_ADDED', 'model_versions', '8', '127.0.0.1', 'SUCCESS', '{\"model_id\":8,\"version\":\"v1.0.0\",\"sha256\":\"8e45e4734517c65e4280ac5a7de92587c2d214fcb609fbc2da63460b505a9440\"}', '2026-10-26 15:36:00'),
(164, 18, 'MODEL_VALIDATION_COMPLETED', 'validation_runs', '7', '127.0.0.1', 'SUCCESS', '{\"model_code\":\"VP-MOD-AUDIT-D957\",\"outcome\":\"FAILED\",\"score\":50}', '2026-10-26 15:36:00'),
(165, 18, 'DEPLOYMENT_REQUESTED', 'deployment_requests', '7', '127.0.0.1', 'SUCCESS', '{\"model_code\":\"VP-MOD-AUDIT-D957\"}', '2026-10-26 15:36:00'),
(166, 1, 'DEPLOYMENT_DECISION', 'deployment_requests', '7', '127.0.0.1', 'SUCCESS', '{\"decision\":\"DEPLOYED\",\"traffic\":null}', '2026-10-26 15:36:00'),
(167, 18, 'SUBMISSION_CREATED', 'submissions', '6', '127.0.0.1', 'SUCCESS', '{\"code\":\"SUB-TCK-AUD-68EA-v1\",\"ticket_id\":12,\"iteration\":1}', '2026-10-26 15:36:00'),
(168, 1, 'SUBMISSION_REVIEWED', 'submissions', '6', '127.0.0.1', 'SUCCESS', '{\"decision\":\"APPROVED\",\"score\":95}', '2026-10-26 15:36:00');

-- --------------------------------------------------------

--
-- Table structure for table `datasets`
--

CREATE TABLE `datasets` (
  `id` int(11) NOT NULL,
  `code` varchar(64) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `format` varchar(16) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_size` bigint(20) NOT NULL DEFAULT 0,
  `checksum_sha256` varchar(64) NOT NULL,
  `row_count` int(11) NOT NULL DEFAULT 0,
  `column_count` int(11) NOT NULL DEFAULT 0,
  `schema_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`schema_json`)),
  `is_master` tinyint(1) NOT NULL DEFAULT 1,
  `version` varchar(32) NOT NULL DEFAULT 'v1.0',
  `scenario_id` int(11) DEFAULT NULL,
  `uploaded_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `datasets`
--

INSERT INTO `datasets` (`id`, `code`, `name`, `description`, `format`, `file_path`, `file_size`, `checksum_sha256`, `row_count`, `column_count`, `schema_json`, `is_master`, `version`, `scenario_id`, `uploaded_by`, `created_at`, `updated_at`) VALUES
(1, 'DS-CHURN-2CADFE', 'Telecom Customer Churn v2.4 (Ground Truth)', 'Cleaned subscriber records with billing telemetry and churn label.', 'csv', 'ds_6adf3a5983ad9.csv', 270, 'd80b3cd9546e88cd00dcbf94448798403052be276db56194665114f66d08f5b0', 5, 6, '[\"customer_id\",\"tenure_months\",\"monthly_charges\",\"total_charges\",\"contract_type\",\"churn\"]', 1, 'v2.4', NULL, 1, '2026-10-26 14:32:41', '2026-10-26 14:32:41'),
(2, 'DS-CHURN-A4F303', 'Telecom Customer Churn v2.4 (Ground Truth)', 'Cleaned subscriber records with billing telemetry and churn label.', 'csv', 'ds_6adf3a8e2b8ae.csv', 270, 'd80b3cd9546e88cd00dcbf94448798403052be276db56194665114f66d08f5b0', 5, 6, '[\"customer_id\",\"tenure_months\",\"monthly_charges\",\"total_charges\",\"contract_type\",\"churn\"]', 1, 'v2.4', NULL, 1, '2026-10-26 14:33:34', '2026-10-26 14:33:34'),
(3, 'DS-CHURN-6C0508', 'Telecom Customer Churn v2.4 (Ground Truth)', 'Cleaned subscriber records with billing telemetry and churn label.', 'csv', 'ds_6adf3abb6242f.csv', 270, 'd80b3cd9546e88cd00dcbf94448798403052be276db56194665114f66d08f5b0', 5, 6, '[\"customer_id\",\"tenure_months\",\"monthly_charges\",\"total_charges\",\"contract_type\",\"churn\"]', 1, 'v2.4', NULL, 1, '2026-10-26 14:34:19', '2026-10-26 14:34:19'),
(4, 'DS-CHURN-B61F4C', 'Telecom Customer Churn v2.4 (Ground Truth)', 'Cleaned subscriber records with billing telemetry and churn label.', 'csv', 'ds_6adf3aeb5cd45.csv', 270, 'd80b3cd9546e88cd00dcbf94448798403052be276db56194665114f66d08f5b0', 5, 6, '[\"customer_id\",\"tenure_months\",\"monthly_charges\",\"total_charges\",\"contract_type\",\"churn\"]', 1, 'v2.4', NULL, 1, '2026-10-26 14:35:07', '2026-10-26 14:35:07'),
(5, 'DS-CHURN-0AB992', 'Telecom Customer Churn v2.4 (Ground Truth)', 'Cleaned subscriber records with billing telemetry and churn label.', 'csv', 'ds_6adf3b39065d2.csv', 270, 'd80b3cd9546e88cd00dcbf94448798403052be276db56194665114f66d08f5b0', 5, 6, '[\"customer_id\",\"tenure_months\",\"monthly_charges\",\"total_charges\",\"contract_type\",\"churn\"]', 1, 'v2.4', NULL, 1, '2026-10-26 14:36:25', '2026-10-26 14:36:25'),
(6, 'DS-CHURN-E64C71', 'Telecom Customer Churn v2.4 (Ground Truth)', 'Cleaned subscriber records with billing telemetry and churn label.', 'csv', 'ds_6adf3b89ac434.csv', 270, 'd80b3cd9546e88cd00dcbf94448798403052be276db56194665114f66d08f5b0', 5, 6, '[\"customer_id\",\"tenure_months\",\"monthly_charges\",\"total_charges\",\"contract_type\",\"churn\"]', 1, 'v2.4', NULL, 1, '2026-10-26 14:37:45', '2026-10-26 14:37:45'),
(7, 'DS-AUDIT-D1AA', 'Avionics Calibration Raw', '', 'csv', 'ds_6adf47f2cd3b0.csv', 78, 'e2ade6f0b34d92dedf99a24abe4ac7d8e6278455cd456570e9430d93f43b2bc9', 2, 4, '[\"flight_id\",\"altitude\",\"sensor_temp\",\"target_drift\"]', 1, 'v1.0', 8, 1, '2026-10-26 15:30:42', '2026-10-26 15:30:42'),
(8, 'DS-FACULTY-F2CF', 'Secret Faculty Dataset', '', 'csv', 'ds_6adf47f2cf35d.csv', 12, 'b6905220f2319aa9e84f7e7812b38356f13917d5d230c302197ef0ce29aee9ee', 1, 2, '[\"id\",\"val\"]', 1, 'v1.0', NULL, 1, '2026-10-26 15:30:42', '2026-10-26 15:30:42'),
(9, 'DS-AUDIT-B814', 'Avionics Calibration Raw', '', 'csv', 'ds_6adf48262b916.csv', 78, 'e2ade6f0b34d92dedf99a24abe4ac7d8e6278455cd456570e9430d93f43b2bc9', 2, 4, '[\"flight_id\",\"altitude\",\"sensor_temp\",\"target_drift\"]', 1, 'v1.0', 9, 1, '2026-10-26 15:31:34', '2026-10-26 15:31:34'),
(10, 'DS-FACULTY-E1A1', 'Secret Faculty Dataset', '', 'csv', 'ds_6adf48262e22d.csv', 12, 'b6905220f2319aa9e84f7e7812b38356f13917d5d230c302197ef0ce29aee9ee', 1, 2, '[\"id\",\"val\"]', 1, 'v1.0', NULL, 1, '2026-10-26 15:31:34', '2026-10-26 15:31:34'),
(11, 'DS-AUDIT-F0AD', 'Avionics Calibration Raw', '', 'csv', 'ds_6adf483bcf1a0.csv', 78, 'e2ade6f0b34d92dedf99a24abe4ac7d8e6278455cd456570e9430d93f43b2bc9', 2, 4, '[\"flight_id\",\"altitude\",\"sensor_temp\",\"target_drift\"]', 1, 'v1.0', 10, 1, '2026-10-26 15:31:55', '2026-10-26 15:31:55'),
(12, 'DS-FACULTY-0F25', 'Secret Faculty Dataset', '', 'csv', 'ds_6adf483bd0fb9.csv', 12, 'b6905220f2319aa9e84f7e7812b38356f13917d5d230c302197ef0ce29aee9ee', 1, 2, '[\"id\",\"val\"]', 1, 'v1.0', NULL, 1, '2026-10-26 15:31:55', '2026-10-26 15:31:55'),
(13, 'DS-AUDIT-0323', 'Avionics Calibration Raw', '', 'csv', 'ds_6adf48a29056b.csv', 78, 'e2ade6f0b34d92dedf99a24abe4ac7d8e6278455cd456570e9430d93f43b2bc9', 2, 4, '[\"flight_id\",\"altitude\",\"sensor_temp\",\"target_drift\"]', 1, 'v1.0', 11, 1, '2026-10-26 15:33:38', '2026-10-26 15:33:38'),
(14, 'DS-FACULTY-275D', 'Secret Faculty Dataset', '', 'csv', 'ds_6adf48a292825.csv', 12, 'b6905220f2319aa9e84f7e7812b38356f13917d5d230c302197ef0ce29aee9ee', 1, 2, '[\"id\",\"val\"]', 1, 'v1.0', NULL, 1, '2026-10-26 15:33:38', '2026-10-26 15:33:38'),
(15, 'DS-AUDIT-A77C', 'Avionics Calibration Raw', '', 'csv', 'ds_6adf49307a93a.csv', 78, 'e2ade6f0b34d92dedf99a24abe4ac7d8e6278455cd456570e9430d93f43b2bc9', 2, 4, '[\"flight_id\",\"altitude\",\"sensor_temp\",\"target_drift\"]', 1, 'v1.0', 12, 1, '2026-10-26 15:36:00', '2026-10-26 15:36:00'),
(16, 'DS-FACULTY-C702', 'Secret Faculty Dataset', '', 'csv', 'ds_6adf49307c7c1.csv', 12, 'b6905220f2319aa9e84f7e7812b38356f13917d5d230c302197ef0ce29aee9ee', 1, 2, '[\"id\",\"val\"]', 1, 'v1.0', NULL, 1, '2026-10-26 15:36:00', '2026-10-26 15:36:00');

-- --------------------------------------------------------

--
-- Table structure for table `dataset_assignments`
--

CREATE TABLE `dataset_assignments` (
  `id` int(11) NOT NULL,
  `dataset_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `ticket_id` int(11) DEFAULT NULL,
  `assigned_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dataset_assignments`
--

INSERT INTO `dataset_assignments` (`id`, `dataset_id`, `student_id`, `ticket_id`, `assigned_by`, `created_at`) VALUES
(11, 15, 18, NULL, 1, '2026-10-26 15:36:00');

-- --------------------------------------------------------

--
-- Table structure for table `dataset_quality_reports`
--

CREATE TABLE `dataset_quality_reports` (
  `id` int(11) NOT NULL,
  `dataset_id` int(11) NOT NULL,
  `generated_by` int(11) NOT NULL,
  `metrics_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`metrics_json`)),
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deployment_requests`
--

CREATE TABLE `deployment_requests` (
  `id` int(11) NOT NULL,
  `model_id` int(11) NOT NULL,
  `model_version_id` int(11) NOT NULL,
  `requested_by` int(11) NOT NULL,
  `environment` varchar(32) NOT NULL DEFAULT 'canary',
  `canary_percentage` int(11) NOT NULL DEFAULT 10,
  `replicas` int(11) NOT NULL DEFAULT 1,
  `status` enum('PENDING','APPROVED','REJECTED','DEPLOYED','FAILED') NOT NULL DEFAULT 'PENDING',
  `admin_id` int(11) DEFAULT NULL,
  `decision_notes` text DEFAULT NULL,
  `endpoint_url` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `deployment_requests`
--

INSERT INTO `deployment_requests` (`id`, `model_id`, `model_version_id`, `requested_by`, `environment`, `canary_percentage`, `replicas`, `status`, `admin_id`, `decision_notes`, `endpoint_url`, `created_at`, `updated_at`) VALUES
(2, 3, 3, 5, 'staging', 10, 1, 'PENDING', NULL, NULL, '/api/v1/models/mod-churn-fc48/infer', '2026-10-26 14:35:07', '2026-10-26 14:35:07'),
(3, 4, 4, 6, 'staging', 10, 1, 'PENDING', NULL, NULL, '/api/v1/models/mod-churn-afe2/infer', '2026-10-26 14:36:25', '2026-10-26 14:36:25'),
(4, 5, 5, 7, 'staging', 10, 1, 'PENDING', NULL, NULL, '/api/v1/models/mod-churn-b601/infer', '2026-10-26 14:37:46', '2026-10-26 14:37:46'),
(7, 8, 8, 18, 'canary', 15, 1, 'DEPLOYED', 1, 'Avionics flight approved for canary.', '/api/v1/models/vp-mod-audit-d957/infer', '2026-10-26 15:36:00', '2026-10-26 15:36:00');

-- --------------------------------------------------------

--
-- Table structure for table `execution_jobs`
--

CREATE TABLE `execution_jobs` (
  `id` int(11) NOT NULL,
  `job_uuid` varchar(64) NOT NULL,
  `notebook_id` int(11) NOT NULL,
  `cell_id` int(11) DEFAULT NULL,
  `student_id` int(11) NOT NULL,
  `status` enum('QUEUED','RUNNING','COMPLETED','FAILED','CANCELLED','TIMEOUT') NOT NULL DEFAULT 'QUEUED',
  `code_to_execute` mediumtext NOT NULL,
  `stdout` mediumtext DEFAULT NULL,
  `stderr` mediumtext DEFAULT NULL,
  `artifacts_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`artifacts_json`)),
  `exit_code` int(11) DEFAULT NULL,
  `execution_time_ms` int(11) DEFAULT NULL,
  `memory_peak_mb` float DEFAULT NULL,
  `started_at` datetime DEFAULT NULL,
  `completed_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `execution_jobs`
--

INSERT INTO `execution_jobs` (`id`, `job_uuid`, `notebook_id`, `cell_id`, `student_id`, `status`, `code_to_execute`, `stdout`, `stderr`, `artifacts_json`, `exit_code`, `execution_time_ms`, `memory_peak_mb`, `started_at`, `completed_at`, `created_at`) VALUES
(1, '9367a795e2fb06e949a47c6a0be5fd8e', 1, NULL, 1, 'COMPLETED', 'import sys\nprint(\'VOSTOKPRIBOR ML Isolation Engine Active.\')\nprint(\'Python Interpreter:\', sys.version.split()[0])\nx = sum([i * 2 for i in range(10)])\nprint(\'Computed telemetry sum:\', x)\n', 'VOSTOKPRIBOR ML Isolation Engine Active.\nPython Interpreter: 3.14.7\nComputed telemetry sum: 90\n', '', NULL, 0, 46, NULL, '2026-10-26 14:05:04', '2026-10-26 14:05:04', '2026-10-26 12:04:53'),
(10, 'JOB-075E6048F0D9', 11, NULL, 18, 'RUNNING', 'print(\"Range execution online.\")', NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-26 15:36:00', NULL, '2026-10-26 15:36:00');

-- --------------------------------------------------------

--
-- Table structure for table `experiments`
--

CREATE TABLE `experiments` (
  `id` int(11) NOT NULL,
  `code` varchar(64) NOT NULL,
  `name` varchar(255) NOT NULL,
  `student_id` int(11) NOT NULL,
  `ticket_id` int(11) DEFAULT NULL,
  `scenario_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `experiment_runs`
--

CREATE TABLE `experiment_runs` (
  `id` int(11) NOT NULL,
  `run_uuid` varchar(64) NOT NULL,
  `experiment_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `notebook_id` int(11) DEFAULT NULL,
  `run_name` varchar(120) NOT NULL,
  `status` enum('RUNNING','COMPLETED','FAILED') NOT NULL DEFAULT 'COMPLETED',
  `parameters` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`parameters`)),
  `metrics` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metrics`)),
  `artifacts` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`artifacts`)),
  `duration_seconds` float DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(11) NOT NULL,
  `migration` varchar(255) NOT NULL,
  `applied_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `applied_at`) VALUES
(1, '001_initial_schema.sql', '2026-10-26 13:39:14');

-- --------------------------------------------------------

--
-- Table structure for table `models`
--

CREATE TABLE `models` (
  `id` int(11) NOT NULL,
  `model_code` varchar(64) NOT NULL,
  `name` varchar(255) NOT NULL,
  `framework` varchar(64) NOT NULL,
  `student_id` int(11) NOT NULL,
  `ticket_id` int(11) DEFAULT NULL,
  `scenario_id` int(11) DEFAULT NULL,
  `experiment_run_id` int(11) DEFAULT NULL,
  `current_version` varchar(32) NOT NULL DEFAULT 'v1.0.0',
  `status` enum('REGISTERED','VALIDATION_PENDING','VALIDATING','VALIDATION_PASSED','VALIDATION_FAILED','REVIEW_PENDING','APPROVED','REJECTED','DEPLOYMENT_PENDING','DEPLOYED','DEPLOYMENT_FAILED','ARCHIVED') NOT NULL DEFAULT 'REGISTERED',
  `description` text DEFAULT NULL,
  `metadata_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata_json`)),
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `models`
--

INSERT INTO `models` (`id`, `model_code`, `name`, `framework`, `student_id`, `ticket_id`, `scenario_id`, `experiment_run_id`, `current_version`, `status`, `description`, `metadata_json`, `created_at`, `updated_at`) VALUES
(8, 'VP-MOD-AUDIT-D957', 'High-G Avionics Predictor', 'XGBoost 1.7.4', 18, 12, NULL, NULL, 'v1.0.0', 'DEPLOYED', 'Audit test candidate', NULL, '2026-10-26 15:36:00', '2026-10-26 15:36:00');

-- --------------------------------------------------------

--
-- Table structure for table `model_versions`
--

CREATE TABLE `model_versions` (
  `id` int(11) NOT NULL,
  `model_id` int(11) NOT NULL,
  `version` varchar(32) NOT NULL,
  `artifact_path` varchar(255) NOT NULL,
  `artifact_format` varchar(32) NOT NULL,
  `checksum_sha256` varchar(64) NOT NULL,
  `file_size` bigint(20) NOT NULL DEFAULT 0,
  `metrics` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metrics`)),
  `status` varchar(32) NOT NULL DEFAULT 'REGISTERED',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_versions`
--

INSERT INTO `model_versions` (`id`, `model_id`, `version`, `artifact_path`, `artifact_format`, `checksum_sha256`, `file_size`, `metrics`, `status`, `created_at`) VALUES
(3, 3, 'v1.0.0', 'mod_3_v1.0.0.onnx', 'onnx', 'a44430d55ddd123791d95db467ba76101f98715ed38af43588bc72c889987819', 34, '\"{\\\"f1\\\":0.835}\"', 'REGISTERED', '2026-10-26 14:35:07'),
(4, 4, 'v1.0.0', 'mod_4_v1.0.0.onnx', 'onnx', 'a44430d55ddd123791d95db467ba76101f98715ed38af43588bc72c889987819', 34, '\"{\\\"f1\\\":0.835}\"', 'REGISTERED', '2026-10-26 14:36:25'),
(5, 5, 'v1.0.0', 'mod_5_v1.0.0.onnx', 'onnx', 'a44430d55ddd123791d95db467ba76101f98715ed38af43588bc72c889987819', 34, '\"{\\\"f1\\\":0.835}\"', 'REGISTERED', '2026-10-26 14:37:46'),
(8, 8, 'v1.0.0', 'mod_8_v1.0.0.bin', 'bin', '8e45e4734517c65e4280ac5a7de92587c2d214fcb609fbc2da63460b505a9440', 36, '\"[]\"', 'REGISTERED', '2026-10-26 15:36:00');

-- --------------------------------------------------------

--
-- Table structure for table `notebooks`
--

CREATE TABLE `notebooks` (
  `id` int(11) NOT NULL,
  `code` varchar(64) NOT NULL,
  `title` varchar(255) NOT NULL,
  `student_id` int(11) NOT NULL,
  `ticket_id` int(11) DEFAULT NULL,
  `scenario_id` int(11) DEFAULT NULL,
  `version` int(11) NOT NULL DEFAULT 1,
  `status` enum('ACTIVE','SAVED','ARCHIVED') NOT NULL DEFAULT 'ACTIVE',
  `kernel_state` varchar(32) NOT NULL DEFAULT 'IDLE',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notebooks`
--

INSERT INTO `notebooks` (`id`, `code`, `title`, `student_id`, `ticket_id`, `scenario_id`, `version`, `status`, `kernel_state`, `created_at`, `updated_at`) VALUES
(1, 'NB-738D9A65', 'telemetry_exploration.ipynb', 1, NULL, NULL, 1, 'ACTIVE', 'IDLE', '2026-10-26 14:04:53', '2026-10-26 14:04:53'),
(11, 'NB-AUD-EFF0', 'telemetry_calibration_nb.ipynb', 18, 12, NULL, 1, 'ACTIVE', 'IDLE', '2026-10-26 15:36:00', '2026-10-26 15:36:00');

-- --------------------------------------------------------

--
-- Table structure for table `notebook_cells`
--

CREATE TABLE `notebook_cells` (
  `id` int(11) NOT NULL,
  `notebook_id` int(11) NOT NULL,
  `cell_order` int(11) NOT NULL DEFAULT 0,
  `cell_type` enum('code','markdown') NOT NULL DEFAULT 'code',
  `source` mediumtext NOT NULL,
  `execution_count` int(11) DEFAULT NULL,
  `output_text` mediumtext DEFAULT NULL,
  `output_error` mediumtext DEFAULT NULL,
  `output_image_path` varchar(255) DEFAULT NULL,
  `last_executed_at` datetime DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notebook_cells`
--

INSERT INTO `notebook_cells` (`id`, `notebook_id`, `cell_order`, `cell_type`, `source`, `execution_count`, `output_text`, `output_error`, `output_image_path`, `last_executed_at`, `updated_at`) VALUES
(5, 4, 0, 'markdown', '# churn_telemetry_pipeline.ipynb\nTelemetry-driven EDA & machine learning model development workspace.', NULL, NULL, NULL, NULL, NULL, '2026-10-26 14:35:07'),
(6, 4, 1, 'code', 'import sys\nprint(f\'VOSTOKPRIBOR ML Kernel initialized on Python {sys.version}\')', NULL, NULL, NULL, NULL, NULL, '2026-10-26 14:35:07'),
(7, 5, 0, 'markdown', '# churn_telemetry_pipeline.ipynb\nTelemetry-driven EDA & machine learning model development workspace.', NULL, NULL, NULL, NULL, NULL, '2026-10-26 14:36:25'),
(8, 5, 1, 'code', 'import sys\nprint(f\'VOSTOKPRIBOR ML Kernel initialized on Python {sys.version}\')', NULL, NULL, NULL, NULL, NULL, '2026-10-26 14:36:25'),
(9, 6, 0, 'markdown', '# churn_telemetry_pipeline.ipynb\nTelemetry-driven EDA & machine learning model development workspace.', NULL, NULL, NULL, NULL, NULL, '2026-10-26 14:37:45'),
(10, 6, 1, 'code', 'import sys\nprint(f\'VOSTOKPRIBOR ML Kernel initialized on Python {sys.version}\')', NULL, NULL, NULL, NULL, NULL, '2026-10-26 14:37:45'),
(19, 11, 0, 'markdown', '# telemetry_calibration_nb.ipynb\nTelemetry-driven EDA & machine learning model development workspace.', NULL, NULL, NULL, NULL, NULL, '2026-10-26 15:36:00'),
(20, 11, 1, 'code', 'import sys\nprint(f\'VOSTOKPRIBOR ML Kernel initialized on Python {sys.version}\')', NULL, NULL, NULL, NULL, NULL, '2026-10-26 15:36:00');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `type` varchar(32) NOT NULL DEFAULT 'INFO',
  `link` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `title`, `message`, `type`, `link`, `is_read`, `created_at`) VALUES
(1, 4, 'Work Order Review: AI-024-F541', 'Your submission #SUB-AI-024-F541-v1 was evaluated: APPROVED. Final Score: 95/100.', 'SUCCESS', '/vostokpribor_AI/AI Project Management/Submissions.php', 0, '2026-10-26 14:34:19'),
(2, 5, 'Work Order Review: AI-024-4F34', 'Your submission #SUB-AI-024-4F34-v1 was evaluated: APPROVED. Final Score: 95/100.', 'SUCCESS', '/vostokpribor_AI/AI Project Management/Submissions.php', 0, '2026-10-26 14:35:07'),
(3, 6, 'Work Order Review: AI-024-A0BC', 'Your submission #SUB-AI-024-A0BC-v1 was evaluated: APPROVED. Final Score: 95/100.', 'SUCCESS', '/vostokpribor_AI/AI Project Management/Submissions.php', 0, '2026-10-26 14:36:25'),
(4, 7, 'Work Order Review: AI-024-B9DB', 'Your submission #SUB-AI-024-B9DB-v1 was evaluated: APPROVED. Final Score: 95/100.', 'SUCCESS', '/vostokpribor_AI/AI Project Management/Submissions.php', 0, '2026-10-26 14:37:46'),
(5, 16, 'Work Order Review: TCK-AUD-BF29', 'Your submission #SUB-TCK-AUD-BF29-v1 was evaluated: APPROVED. Final Score: 95/100.', 'SUCCESS', '/vostokpribor_AI/AI Project Management/Submissions.php', 0, '2026-10-26 15:33:38'),
(6, 18, 'Work Order Review: TCK-AUD-68EA', 'Your submission #SUB-TCK-AUD-68EA-v1 was evaluated: APPROVED. Final Score: 95/100.', 'SUCCESS', '/vostokpribor_AI/AI Project Management/Submissions.php', 0, '2026-10-26 15:36:00');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token_hash` varchar(64) NOT NULL,
  `expires_at` datetime NOT NULL,
  `used_at` datetime DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `processed_datasets`
--

CREATE TABLE `processed_datasets` (
  `id` int(11) NOT NULL,
  `source_dataset_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `ticket_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `format` varchar(16) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_size` bigint(20) NOT NULL DEFAULT 0,
  `checksum_sha256` varchar(64) NOT NULL,
  `row_count` int(11) NOT NULL DEFAULT 0,
  `transformation_notes` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `processed_datasets`
--

INSERT INTO `processed_datasets` (`id`, `source_dataset_id`, `student_id`, `ticket_id`, `name`, `description`, `format`, `file_path`, `file_size`, `checksum_sha256`, `row_count`, `transformation_notes`, `created_at`) VALUES
(5, 15, 18, 12, 'Calibrated Features Flight Alpha', '', 'csv', 'proc_6adf49307e51d.csv', 14, '1697909dacb83482e7fc9268d21dd1bd6f87ff3ed252c806648b7d4bcf922cde', 1, 'Median imputed altitude and normalized temperature.', '2026-10-26 15:36:00');

-- --------------------------------------------------------

--
-- Table structure for table `rate_limits`
--

CREATE TABLE `rate_limits` (
  `id` int(11) NOT NULL,
  `rate_key` varchar(128) NOT NULL,
  `hits` int(11) NOT NULL DEFAULT 1,
  `reset_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rate_limits`
--

INSERT INTO `rate_limits` (`id`, `rate_key`, `hits`, `reset_at`) VALUES
(10, 'test-ip-key', 3, 1793018242);

-- --------------------------------------------------------

--
-- Table structure for table `scenarios`
--

CREATE TABLE `scenarios` (
  `id` int(11) NOT NULL,
  `code` varchar(64) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `difficulty` varchar(32) NOT NULL DEFAULT 'Level 1',
  `department` varchar(120) NOT NULL DEFAULT 'Flight Operations Data Core',
  `status` enum('DRAFT','PUBLISHED','ARCHIVED') NOT NULL DEFAULT 'DRAFT',
  `version` varchar(32) NOT NULL DEFAULT 'v1.0',
  `objectives` text DEFAULT NULL,
  `acceptance_criteria` text DEFAULT NULL,
  `author_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `scenarios`
--

INSERT INTO `scenarios` (`id`, `code`, `title`, `description`, `difficulty`, `department`, `status`, `version`, `objectives`, `acceptance_criteria`, `author_id`, `created_at`, `updated_at`) VALUES
(1, 'SCN-CHURN-D377', 'Customer Churn Prediction & Drift Mitigation', 'Industrial AI pipeline to detect subscriber attrition signals.', 'ADVANCED', 'Telemetry & Retention ML', 'PUBLISHED', 'v1.0', 'Train XGBoost/LightGBM model achieving F1 >= 0.80 and latency < 60ms.', 'F1 >= 0.80 on temporal holdout split. No data leakage.', 1, '2026-10-26 14:33:34', '2026-10-26 14:33:34'),
(2, 'SCN-CHURN-7161', 'Customer Churn Prediction & Drift Mitigation', 'Industrial AI pipeline to detect subscriber attrition signals.', 'ADVANCED', 'Telemetry & Retention ML', 'PUBLISHED', 'v1.0', 'Train XGBoost/LightGBM model achieving F1 >= 0.80 and latency < 60ms.', 'F1 >= 0.80 on temporal holdout split. No data leakage.', 1, '2026-10-26 14:34:19', '2026-10-26 14:34:19'),
(3, 'SCN-CHURN-36F7', 'Customer Churn Prediction & Drift Mitigation', 'Industrial AI pipeline to detect subscriber attrition signals.', 'ADVANCED', 'Telemetry & Retention ML', 'PUBLISHED', 'v1.0', 'Train XGBoost/LightGBM model achieving F1 >= 0.80 and latency < 60ms.', 'F1 >= 0.80 on temporal holdout split. No data leakage.', 1, '2026-10-26 14:35:07', '2026-10-26 14:35:07'),
(4, 'SCN-CHURN-38F3', 'Customer Churn Prediction & Drift Mitigation', 'Industrial AI pipeline to detect subscriber attrition signals.', 'ADVANCED', 'Telemetry & Retention ML', 'PUBLISHED', 'v1.0', 'Train XGBoost/LightGBM model achieving F1 >= 0.80 and latency < 60ms.', 'F1 >= 0.80 on temporal holdout split. No data leakage.', 1, '2026-10-26 14:36:25', '2026-10-26 14:36:25'),
(5, 'SCN-CHURN-89DC', 'Customer Churn Prediction & Drift Mitigation', 'Industrial AI pipeline to detect subscriber attrition signals.', 'ADVANCED', 'Telemetry & Retention ML', 'PUBLISHED', 'v1.0', 'Train XGBoost/LightGBM model achieving F1 >= 0.80 and latency < 60ms.', 'F1 >= 0.80 on temporal holdout split. No data leakage.', 1, '2026-10-26 14:37:45', '2026-10-26 14:37:45'),
(6, 'SCN-AUDIT-6ADF4770BC912', 'Audit Mission: High-Altitude Avionics', 'Automated test flight scenario for audit verification suite', 'Level 1', 'Flight Operations Data Core', 'PUBLISHED', 'v1.0', NULL, NULL, 1, '2026-10-26 15:28:32', '2026-10-26 15:28:32'),
(7, 'SCN-AUDIT-6ADF47BEDB1F7', 'Audit Mission: High-Altitude Avionics', 'Automated test flight scenario for audit verification suite', 'Level 1', 'Flight Operations Data Core', 'PUBLISHED', 'v1.0', NULL, NULL, 1, '2026-10-26 15:29:50', '2026-10-26 15:29:50'),
(8, 'SCN-AUDIT-6ADF47F2C8854', 'Audit Mission: High-Altitude Avionics', 'Automated test flight scenario for audit verification suite', 'Level 1', 'Flight Operations Data Core', 'PUBLISHED', 'v1.0', NULL, NULL, 1, '2026-10-26 15:30:42', '2026-10-26 15:30:42'),
(9, 'SCN-AUDIT-6ADF4826267D6', 'Audit Mission: High-Altitude Avionics', 'Automated test flight scenario for audit verification suite', 'Level 1', 'Flight Operations Data Core', 'PUBLISHED', 'v1.0', NULL, NULL, 1, '2026-10-26 15:31:34', '2026-10-26 15:31:34'),
(10, 'SCN-AUDIT-6ADF483BCB2AB', 'Audit Mission: High-Altitude Avionics', 'Automated test flight scenario for audit verification suite', 'Level 1', 'Flight Operations Data Core', 'PUBLISHED', 'v1.0', NULL, NULL, 1, '2026-10-26 15:31:55', '2026-10-26 15:31:55'),
(11, 'SCN-AUDIT-6ADF48A28AE24', 'Audit Mission: High-Altitude Avionics', 'Automated test flight scenario for audit verification suite', 'Level 1', 'Flight Operations Data Core', 'PUBLISHED', 'v1.0', NULL, NULL, 1, '2026-10-26 15:33:38', '2026-10-26 15:33:38'),
(12, 'SCN-AUDIT-6ADF493075A7C', 'Audit Mission: High-Altitude Avionics', 'Automated test flight scenario for audit verification suite', 'Level 1', 'Flight Operations Data Core', 'PUBLISHED', 'v1.0', NULL, NULL, 1, '2026-10-26 15:36:00', '2026-10-26 15:36:00');

-- --------------------------------------------------------

--
-- Table structure for table `submissions`
--

CREATE TABLE `submissions` (
  `id` int(11) NOT NULL,
  `submission_code` varchar(64) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `iteration` int(11) NOT NULL DEFAULT 1,
  `notes` text DEFAULT NULL,
  `model_id` int(11) DEFAULT NULL,
  `notebook_id` int(11) DEFAULT NULL,
  `status` enum('SUBMITTED','UNDER_REVIEW','APPROVED','CHANGES_REQUESTED','REJECTED') NOT NULL DEFAULT 'SUBMITTED',
  `rubric_scores` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`rubric_scores`)),
  `total_score` int(11) DEFAULT NULL,
  `feedback` text DEFAULT NULL,
  `reviewed_by` int(11) DEFAULT NULL,
  `reviewed_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `submissions`
--

INSERT INTO `submissions` (`id`, `submission_code`, `ticket_id`, `student_id`, `iteration`, `notes`, `model_id`, `notebook_id`, `status`, `rubric_scores`, `total_score`, `feedback`, `reviewed_by`, `reviewed_at`, `created_at`, `updated_at`) VALUES
(6, 'SUB-TCK-AUD-68EA-v1', 12, 18, 1, 'Completed telemetry calibration, feature processing, and candidate model.', 8, 11, 'APPROVED', '\"{\\\"code_quality\\\":30,\\\"model_accuracy\\\":35,\\\"pipeline_design\\\":30}\"', 95, 'Exceptional calibration precision and comprehensive model artifacts.', 1, '2026-10-26 15:36:00', '2026-10-26 15:36:00', '2026-10-26 15:36:00');

-- --------------------------------------------------------

--
-- Table structure for table `submission_attachments`
--

CREATE TABLE `submission_attachments` (
  `id` int(11) NOT NULL,
  `submission_id` int(11) NOT NULL,
  `attachment_type` varchar(64) NOT NULL,
  `reference_id` int(11) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `setting_key` varchar(64) NOT NULL,
  `setting_value` text NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `ticket_code` varchar(64) NOT NULL,
  `scenario_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `priority` enum('CRITICAL','HIGH','MEDIUM','LOW') NOT NULL DEFAULT 'MEDIUM',
  `status` enum('DRAFT','ASSIGNED','IN_PROGRESS','SUBMITTED','UNDER_REVIEW','APPROVED','CHANGES_REQUESTED','CANCELLED') NOT NULL DEFAULT 'DRAFT',
  `deadline` datetime DEFAULT NULL,
  `requirements` text DEFAULT NULL,
  `acceptance_criteria` text DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `ticket_code`, `scenario_id`, `title`, `description`, `priority`, `status`, `deadline`, `requirements`, `acceptance_criteria`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'AI-024-2915', 1, 'Predictive Customer Churn Pipeline Engineering', 'Feature engineering and model training for churn prediction.', 'CRITICAL', 'ASSIGNED', NULL, 'Ingest telecom_customer_churn_v2.csv; run cross-validation.', 'F1-Score >= 0.80. Submit ONNX or notebook.', 1, '2026-10-26 14:33:34', '2026-10-26 14:33:34'),
(2, 'AI-024-F541', 2, 'Predictive Customer Churn Pipeline Engineering', 'Feature engineering and model training for churn prediction.', 'CRITICAL', 'APPROVED', NULL, 'Ingest telecom_customer_churn_v2.csv; run cross-validation.', 'F1-Score >= 0.80. Submit ONNX or notebook.', 1, '2026-10-26 14:34:19', '2026-10-26 14:34:19'),
(3, 'AI-024-4F34', 3, 'Predictive Customer Churn Pipeline Engineering', 'Feature engineering and model training for churn prediction.', 'CRITICAL', 'APPROVED', NULL, 'Ingest telecom_customer_churn_v2.csv; run cross-validation.', 'F1-Score >= 0.80. Submit ONNX or notebook.', 1, '2026-10-26 14:35:07', '2026-10-26 14:35:07'),
(4, 'AI-024-A0BC', 4, 'Predictive Customer Churn Pipeline Engineering', 'Feature engineering and model training for churn prediction.', 'CRITICAL', 'APPROVED', NULL, 'Ingest telecom_customer_churn_v2.csv; run cross-validation.', 'F1-Score >= 0.80. Submit ONNX or notebook.', 1, '2026-10-26 14:36:25', '2026-10-26 14:36:25'),
(5, 'AI-024-B9DB', 5, 'Predictive Customer Churn Pipeline Engineering', 'Feature engineering and model training for churn prediction.', 'CRITICAL', 'APPROVED', NULL, 'Ingest telecom_customer_churn_v2.csv; run cross-validation.', 'F1-Score >= 0.80. Submit ONNX or notebook.', 1, '2026-10-26 14:37:45', '2026-10-26 14:37:46'),
(6, 'TCK-AUD-DDA8', 6, 'Calibrate Telemetry Sensor Model', 'Implement XGBoost calibration and submit model candidate.', 'HIGH', 'ASSIGNED', NULL, NULL, NULL, 1, '2026-10-26 15:28:32', '2026-10-26 15:28:32'),
(7, 'TCK-AUD-BBB6', 7, 'Calibrate Telemetry Sensor Model', 'Implement XGBoost calibration and submit model candidate.', 'HIGH', 'ASSIGNED', NULL, NULL, NULL, 1, '2026-10-26 15:29:50', '2026-10-26 15:29:50'),
(8, 'TCK-AUD-9887', 8, 'Calibrate Telemetry Sensor Model', 'Implement XGBoost calibration and submit model candidate.', 'HIGH', 'ASSIGNED', NULL, NULL, NULL, 1, '2026-10-26 15:30:42', '2026-10-26 15:30:42'),
(9, 'TCK-AUD-737B', 9, 'Calibrate Telemetry Sensor Model', 'Implement XGBoost calibration and submit model candidate.', 'HIGH', 'ASSIGNED', NULL, NULL, NULL, 1, '2026-10-26 15:31:34', '2026-10-26 15:31:34'),
(10, 'TCK-AUD-BCC3', 10, 'Calibrate Telemetry Sensor Model', 'Implement XGBoost calibration and submit model candidate.', 'HIGH', 'ASSIGNED', NULL, NULL, NULL, 1, '2026-10-26 15:31:55', '2026-10-26 15:31:55'),
(11, 'TCK-AUD-BF29', 11, 'Calibrate Telemetry Sensor Model', 'Implement XGBoost calibration and submit model candidate.', 'HIGH', 'APPROVED', NULL, NULL, NULL, 1, '2026-10-26 15:33:38', '2026-10-26 15:33:38'),
(12, 'TCK-AUD-68EA', 12, 'Calibrate Telemetry Sensor Model', 'Implement XGBoost calibration and submit model candidate.', 'HIGH', 'APPROVED', NULL, NULL, NULL, 1, '2026-10-26 15:36:00', '2026-10-26 15:36:00');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_assignments`
--

CREATE TABLE `ticket_assignments` (
  `id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `assigned_by` int(11) NOT NULL,
  `assigned_at` datetime NOT NULL DEFAULT current_timestamp(),
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ticket_assignments`
--

INSERT INTO `ticket_assignments` (`id`, `ticket_id`, `student_id`, `assigned_by`, `assigned_at`, `notes`) VALUES
(12, 12, 18, 1, '2026-10-26 15:36:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ticket_comments`
--

CREATE TABLE `ticket_comments` (
  `id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_status_history`
--

CREATE TABLE `ticket_status_history` (
  `id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `old_status` varchar(32) DEFAULT NULL,
  `new_status` varchar(32) NOT NULL,
  `changed_by` int(11) NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ticket_status_history`
--

INSERT INTO `ticket_status_history` (`id`, `ticket_id`, `old_status`, `new_status`, `changed_by`, `notes`, `created_at`) VALUES
(1, 1, NULL, 'DRAFT', 1, 'Work order created', '2026-10-26 14:33:34'),
(2, 1, 'DRAFT', 'ASSIGNED', 1, 'Assigned to Alex Chen (VK-88219)', '2026-10-26 14:33:34'),
(3, 2, NULL, 'DRAFT', 1, 'Work order created', '2026-10-26 14:34:19'),
(4, 2, 'DRAFT', 'ASSIGNED', 1, 'Assigned to Alex Chen (VK-88219)', '2026-10-26 14:34:19'),
(6, 2, 'SUBMITTED', 'APPROVED', 1, 'Submission #SUB-AI-024-F541-v1 reviewed: APPROVED (Score: 95/100)', '2026-10-26 14:34:19'),
(7, 3, NULL, 'DRAFT', 1, 'Work order created', '2026-10-26 14:35:07'),
(8, 3, 'DRAFT', 'ASSIGNED', 1, 'Assigned to Alex Chen (VK-88219)', '2026-10-26 14:35:07'),
(10, 3, 'SUBMITTED', 'APPROVED', 1, 'Submission #SUB-AI-024-4F34-v1 reviewed: APPROVED (Score: 95/100)', '2026-10-26 14:35:07'),
(11, 4, NULL, 'DRAFT', 1, 'Work order created', '2026-10-26 14:36:25'),
(12, 4, 'DRAFT', 'ASSIGNED', 1, 'Assigned to Alex Chen (VK-88219)', '2026-10-26 14:36:25'),
(14, 4, 'SUBMITTED', 'APPROVED', 1, 'Submission #SUB-AI-024-A0BC-v1 reviewed: APPROVED (Score: 95/100)', '2026-10-26 14:36:25'),
(15, 5, NULL, 'DRAFT', 1, 'Work order created', '2026-10-26 14:37:45'),
(16, 5, 'DRAFT', 'ASSIGNED', 1, 'Assigned to Alex Chen (VK-88219)', '2026-10-26 14:37:45'),
(18, 5, 'SUBMITTED', 'APPROVED', 1, 'Submission #SUB-AI-024-B9DB-v1 reviewed: APPROVED (Score: 95/100)', '2026-10-26 14:37:46'),
(19, 6, NULL, 'DRAFT', 1, 'Work order created', '2026-10-26 15:28:32'),
(20, 6, 'DRAFT', 'ASSIGNED', 1, 'Assigned to Audit Cadet Test (VK-AUDIT-99)', '2026-10-26 15:28:32'),
(21, 7, NULL, 'DRAFT', 1, 'Work order created', '2026-10-26 15:29:50'),
(22, 7, 'DRAFT', 'ASSIGNED', 1, 'Assigned to Audit Cadet Test (VK-AUDIT-99)', '2026-10-26 15:29:50'),
(23, 8, NULL, 'DRAFT', 1, 'Work order created', '2026-10-26 15:30:42'),
(24, 8, 'DRAFT', 'ASSIGNED', 1, 'Assigned to Audit Cadet Test (VK-AUDIT-99)', '2026-10-26 15:30:42'),
(25, 9, NULL, 'DRAFT', 1, 'Work order created', '2026-10-26 15:31:34'),
(26, 9, 'DRAFT', 'ASSIGNED', 1, 'Assigned to Audit Cadet Test (VK-AUDIT-99)', '2026-10-26 15:31:34'),
(27, 10, NULL, 'DRAFT', 1, 'Work order created', '2026-10-26 15:31:55'),
(28, 10, 'DRAFT', 'ASSIGNED', 1, 'Assigned to Audit Cadet Test (VK-AUDIT-99)', '2026-10-26 15:31:55'),
(29, 11, NULL, 'DRAFT', 1, 'Work order created', '2026-10-26 15:33:38'),
(30, 11, 'DRAFT', 'ASSIGNED', 1, 'Assigned to Audit Cadet Test (VK-AUDIT-99)', '2026-10-26 15:33:38'),
(31, 11, 'ASSIGNED', 'SUBMITTED', 16, 'Deliverable submitted (Iteration #1)', '2026-10-26 15:33:38'),
(32, 11, 'SUBMITTED', 'APPROVED', 1, 'Submission #SUB-TCK-AUD-BF29-v1 reviewed: APPROVED (Score: 95/100)', '2026-10-26 15:33:38'),
(33, 12, NULL, 'DRAFT', 1, 'Work order created', '2026-10-26 15:36:00'),
(34, 12, 'DRAFT', 'ASSIGNED', 1, 'Assigned to Audit Cadet Test (VK-AUD-C63E9)', '2026-10-26 15:36:00'),
(35, 12, 'ASSIGNED', 'SUBMITTED', 18, 'Deliverable submitted (Iteration #1)', '2026-10-26 15:36:00'),
(36, 12, 'SUBMITTED', 'APPROVED', 1, 'Submission #SUB-TCK-AUD-68EA-v1 reviewed: APPROVED (Score: 95/100)', '2026-10-26 15:36:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role` enum('ADMIN','STUDENT') NOT NULL,
  `email` varchar(191) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `full_name` varchar(120) NOT NULL,
  `identifier` varchar(64) NOT NULL,
  `cohort` varchar(64) DEFAULT NULL,
  `department` varchar(120) DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE','SUSPENDED') NOT NULL DEFAULT 'ACTIVE',
  `must_change_password` tinyint(1) NOT NULL DEFAULT 0,
  `last_login_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role`, `email`, `password_hash`, `full_name`, `identifier`, `cohort`, `department`, `status`, `must_change_password`, `last_login_at`, `created_at`, `updated_at`) VALUES
(1, 'ADMIN', 'admin@vostokpribor.space', '$2y$10$wnL3wTfGQWhWwi/f.vhSue7scDsKBXuE8kVHNaF6kJja7BQ5ArwGW', 'Super Administrator', 'admin', 'Mission Control', 'AI Operations Center (AI SOC)', 'ACTIVE', 1, '2026-10-26 15:35:59', '2026-10-26 13:39:45', '2026-10-26 15:35:59'),
(12, 'STUDENT', 'cadet2.audit@range.vostokpribor.space', '$2y$12$eBwRcJAT4UqREhwrDdj8uOVgMkBcQiOV3S6Vm0UWUjUPjAtB4QxfS', 'Second Cadet', 'VK-AUD-92', 'Cohort 2025-A', 'Avionics AI Cadet Cohort', 'ACTIVE', 0, NULL, '2026-10-26 15:30:43', '2026-10-26 15:30:43'),
(15, 'STUDENT', 'cadet2_6adf483bd3a98@range.vostokpribor.space', '$2y$12$ULMjaAbRHdFx6vOMI9sv0.bIh63Y3Nt2dtDJiUVSyw2Tx4rEC3JsS', 'Second Cadet', 'VK-AUD-3A9A', 'Cohort 2025-A', 'Avionics AI Cadet Cohort', 'ACTIVE', 0, NULL, '2026-10-26 15:31:56', '2026-10-26 15:31:56'),
(16, 'STUDENT', 'cadet.audit.test@range.vostokpribor.space', '$2y$12$Lp.oslrl9V.EkmbIOJnbhuB.SfMEc./5hBHmkAbfpWcfiqGHpzAGm', 'Audit Cadet Test', 'VK-AUDIT-99', 'COHORT-2026', 'Avionics AI Cadet Cohort', 'ACTIVE', 0, '2026-10-26 15:33:38', '2026-10-26 15:33:38', '2026-10-26 15:33:38'),
(17, 'STUDENT', 'cadet2_6adf48a29564c@range.vostokpribor.space', '$2y$12$Fg/vMO1t3dX6sm273sWqV.wknwGD1AeDznmDK6rghhfZaGKCwgZPq', 'Second Cadet', 'VK-AUD-564D', 'Cohort 2025-A', 'Avionics AI Cadet Cohort', 'ACTIVE', 0, NULL, '2026-10-26 15:33:38', '2026-10-26 15:33:38'),
(18, 'STUDENT', 'cadet.audit.c63e9@range.vostokpribor.space', '$2y$12$.VBL7leP7yUyyBEgjYpwbeIq5kbEgzjXbWnkzQGjziZ/igwJgRRLS', 'Audit Cadet Test', 'VK-AUD-C63E9', 'COHORT-2026', 'Avionics AI Cadet Cohort', 'ACTIVE', 0, '2026-10-26 15:36:00', '2026-10-26 15:35:59', '2026-10-26 15:36:00'),
(19, 'STUDENT', 'cadet2_6adf49307fd11@range.vostokpribor.space', '$2y$12$Vaqoy1DQ2zFfhHtYpaY/9OvXIujwvyovWmeVZQ0d06Ib2h7uLvJyi', 'Second Cadet', 'VK-AUD-FD14', 'Cohort 2025-A', 'Avionics AI Cadet Cohort', 'ACTIVE', 0, NULL, '2026-10-26 15:36:00', '2026-10-26 15:36:00'),
(20, 'STUDENT', 'cadet.chen@range.vostokpribor.space', '$2y$12$/TSDoosu8rfeH.UcfgzRYeW4BYQd14VFWo52FYoOudvbUa5CTfA0e', 'Alex Chen', 'VK-88219', 'COHORT-24B', 'Telemetry & Retention ML', 'ACTIVE', 0, '2026-10-26 15:36:23', '2026-10-26 15:36:22', '2026-10-26 15:36:23');

-- --------------------------------------------------------

--
-- Table structure for table `user_sessions`
--

CREATE TABLE `user_sessions` (
  `id` varchar(128) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` mediumtext DEFAULT NULL,
  `last_activity` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `validation_runs`
--

CREATE TABLE `validation_runs` (
  `id` int(11) NOT NULL,
  `model_id` int(11) NOT NULL,
  `model_version_id` int(11) NOT NULL,
  `requested_by` int(11) NOT NULL,
  `status` enum('PENDING','RUNNING','PASSED','FAILED') NOT NULL DEFAULT 'PENDING',
  `score` float DEFAULT NULL,
  `checks_passed` int(11) NOT NULL DEFAULT 0,
  `checks_total` int(11) NOT NULL DEFAULT 0,
  `report_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`report_json`)),
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `completed_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `validation_runs`
--

INSERT INTO `validation_runs` (`id`, `model_id`, `model_version_id`, `requested_by`, `status`, `score`, `checks_passed`, `checks_total`, `report_json`, `created_at`, `completed_at`) VALUES
(2, 3, 3, 5, 'PASSED', 100, 4, 4, '{\"model_id\":3,\"model_code\":\"MOD-CHURN-FC48\",\"version\":\"v1.0.0\",\"overall_status\":\"PASSED\",\"score_percent\":100,\"checks_passed\":4,\"checks_total\":4,\"checks\":[{\"name\":\"Artifact File Integrity\",\"passed\":true,\"details\":\"Artifact verified on storage cluster (SHA-256 match).\"},{\"name\":\"Serialization Safety Verification\",\"passed\":true,\"details\":\"Format [.onnx] approved under Avionics ML Safety Spec 880-B.\"},{\"name\":\"Inference Latency Benchmark\",\"passed\":true,\"details\":\"Measured latency: 12.4 ms (Gate Threshold: <= 50.0 ms).\"},{\"name\":\"Candidate Performance Benchmark\",\"passed\":true,\"details\":\"Score: 0.85 (Benchmark Threshold: >= 0.75).\"}],\"executed_at\":\"2026-10-26 12:35:07\"}', '2026-10-26 14:35:07', '2026-10-26 12:35:07'),
(3, 4, 4, 6, 'PASSED', 100, 4, 4, '{\"model_id\":4,\"model_code\":\"MOD-CHURN-AFE2\",\"version\":\"v1.0.0\",\"overall_status\":\"PASSED\",\"score_percent\":100,\"checks_passed\":4,\"checks_total\":4,\"checks\":[{\"name\":\"Artifact File Integrity\",\"passed\":true,\"details\":\"Artifact verified on storage cluster (SHA-256 match).\"},{\"name\":\"Serialization Safety Verification\",\"passed\":true,\"details\":\"Format [.onnx] approved under Avionics ML Safety Spec 880-B.\"},{\"name\":\"Inference Latency Benchmark\",\"passed\":true,\"details\":\"Measured latency: 12.4 ms (Gate Threshold: <= 50.0 ms).\"},{\"name\":\"Candidate Performance Benchmark\",\"passed\":true,\"details\":\"Score: 0.85 (Benchmark Threshold: >= 0.75).\"}],\"executed_at\":\"2026-10-26 12:36:25\"}', '2026-10-26 14:36:25', '2026-10-26 12:36:25'),
(4, 5, 5, 7, 'PASSED', 100, 4, 4, '{\"model_id\":5,\"model_code\":\"MOD-CHURN-B601\",\"version\":\"v1.0.0\",\"overall_status\":\"PASSED\",\"score_percent\":100,\"checks_passed\":4,\"checks_total\":4,\"checks\":[{\"name\":\"Artifact File Integrity\",\"passed\":true,\"details\":\"Artifact verified on storage cluster (SHA-256 match).\"},{\"name\":\"Serialization Safety Verification\",\"passed\":true,\"details\":\"Format [.onnx] approved under Avionics ML Safety Spec 880-B.\"},{\"name\":\"Inference Latency Benchmark\",\"passed\":true,\"details\":\"Measured latency: 12.4 ms (Gate Threshold: <= 50.0 ms).\"},{\"name\":\"Candidate Performance Benchmark\",\"passed\":true,\"details\":\"Score: 0.85 (Benchmark Threshold: >= 0.75).\"}],\"executed_at\":\"2026-10-26 12:37:46\"}', '2026-10-26 14:37:46', '2026-10-26 12:37:46'),
(7, 8, 8, 18, 'FAILED', 50, 2, 4, '{\"model_id\":8,\"model_code\":\"VP-MOD-AUDIT-D957\",\"version\":\"v1.0.0\",\"overall_status\":\"FAILED\",\"score_percent\":50,\"checks_passed\":2,\"checks_total\":4,\"checks\":[{\"name\":\"Artifact File Integrity\",\"passed\":true,\"details\":\"Artifact verified on storage cluster (SHA-256 match).\"},{\"name\":\"Serialization Safety Verification\",\"passed\":true,\"details\":\"Format [.bin] approved under Avionics ML Safety Spec 880-B.\"},{\"name\":\"Inference Latency Benchmark\",\"passed\":false,\"details\":\"NOT_EVALUATED: No empirical benchmark latency recorded.\"},{\"name\":\"Candidate Performance Benchmark\",\"passed\":false,\"details\":\"INCOMPLETE: No evaluation metrics recorded. Run evaluation job first.\"}],\"executed_at\":\"2026-10-26 13:36:00\"}', '2026-10-26 15:36:00', '2026-10-26 13:36:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_audit_actor` (`actor_id`),
  ADD KEY `idx_audit_action` (`action`),
  ADD KEY `idx_audit_resource` (`resource_type`,`resource_id`);

--
-- Indexes for table `datasets`
--
ALTER TABLE `datasets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `idx_datasets_code` (`code`),
  ADD KEY `fk_datasets_scenario` (`scenario_id`),
  ADD KEY `fk_datasets_uploader` (`uploaded_by`);

--
-- Indexes for table `dataset_assignments`
--
ALTER TABLE `dataset_assignments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_dataset_student_ticket` (`dataset_id`,`student_id`,`ticket_id`),
  ADD KEY `idx_da_student` (`student_id`),
  ADD KEY `fk_da_ticket` (`ticket_id`),
  ADD KEY `fk_da_assigner` (`assigned_by`);

--
-- Indexes for table `dataset_quality_reports`
--
ALTER TABLE `dataset_quality_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_dqr_dataset` (`dataset_id`),
  ADD KEY `fk_dqr_generator` (`generated_by`);

--
-- Indexes for table `deployment_requests`
--
ALTER TABLE `deployment_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_dr_model` (`model_id`),
  ADD KEY `fk_dr_version` (`model_version_id`),
  ADD KEY `fk_dr_requester` (`requested_by`),
  ADD KEY `fk_dr_admin` (`admin_id`);

--
-- Indexes for table `execution_jobs`
--
ALTER TABLE `execution_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `job_uuid` (`job_uuid`),
  ADD KEY `idx_ej_status` (`status`),
  ADD KEY `idx_ej_student` (`student_id`),
  ADD KEY `fk_ej_notebook` (`notebook_id`);

--
-- Indexes for table `experiments`
--
ALTER TABLE `experiments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `idx_exp_student` (`student_id`),
  ADD KEY `fk_exp_ticket` (`ticket_id`),
  ADD KEY `fk_exp_scenario` (`scenario_id`);

--
-- Indexes for table `experiment_runs`
--
ALTER TABLE `experiment_runs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `run_uuid` (`run_uuid`),
  ADD KEY `idx_er_exp` (`experiment_id`),
  ADD KEY `idx_er_student` (`student_id`),
  ADD KEY `fk_er_notebook` (`notebook_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `migration` (`migration`);

--
-- Indexes for table `models`
--
ALTER TABLE `models`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `model_code` (`model_code`),
  ADD KEY `idx_models_student` (`student_id`),
  ADD KEY `idx_models_status` (`status`),
  ADD KEY `fk_models_ticket` (`ticket_id`),
  ADD KEY `fk_models_scenario` (`scenario_id`),
  ADD KEY `fk_models_run` (`experiment_run_id`);

--
-- Indexes for table `model_versions`
--
ALTER TABLE `model_versions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_model_version` (`model_id`,`version`);

--
-- Indexes for table `notebooks`
--
ALTER TABLE `notebooks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `idx_notebooks_student` (`student_id`),
  ADD KEY `fk_nb_ticket` (`ticket_id`),
  ADD KEY `fk_nb_scenario` (`scenario_id`);

--
-- Indexes for table `notebook_cells`
--
ALTER TABLE `notebook_cells`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_nc_notebook` (`notebook_id`,`cell_order`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_notif_user` (`user_id`,`is_read`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_pw_user` (`user_id`),
  ADD KEY `fk_pw_creator` (`created_by`);

--
-- Indexes for table `processed_datasets`
--
ALTER TABLE `processed_datasets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_pd_student` (`student_id`),
  ADD KEY `fk_pd_source` (`source_dataset_id`),
  ADD KEY `fk_pd_ticket` (`ticket_id`);

--
-- Indexes for table `rate_limits`
--
ALTER TABLE `rate_limits`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_rate_key` (`rate_key`),
  ADD KEY `idx_rate_reset` (`reset_at`);

--
-- Indexes for table `scenarios`
--
ALTER TABLE `scenarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `idx_scenarios_status` (`status`),
  ADD KEY `fk_scenarios_author` (`author_id`);

--
-- Indexes for table `submissions`
--
ALTER TABLE `submissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `submission_code` (`submission_code`),
  ADD KEY `idx_sub_ticket` (`ticket_id`),
  ADD KEY `idx_sub_student` (`student_id`),
  ADD KEY `idx_sub_status` (`status`),
  ADD KEY `fk_sub_model` (`model_id`),
  ADD KEY `fk_sub_notebook` (`notebook_id`),
  ADD KEY `fk_sub_reviewer` (`reviewed_by`);

--
-- Indexes for table `submission_attachments`
--
ALTER TABLE `submission_attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_sa_sub` (`submission_id`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`setting_key`),
  ADD KEY `fk_settings_updater` (`updated_by`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ticket_code` (`ticket_code`),
  ADD KEY `idx_tickets_status` (`status`),
  ADD KEY `idx_tickets_scenario` (`scenario_id`),
  ADD KEY `fk_tickets_creator` (`created_by`);

--
-- Indexes for table `ticket_assignments`
--
ALTER TABLE `ticket_assignments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_ticket_student` (`ticket_id`,`student_id`),
  ADD KEY `idx_assignments_student` (`student_id`),
  ADD KEY `fk_assignments_creator` (`assigned_by`);

--
-- Indexes for table `ticket_comments`
--
ALTER TABLE `ticket_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_comments_ticket` (`ticket_id`),
  ADD KEY `fk_comments_user` (`user_id`);

--
-- Indexes for table `ticket_status_history`
--
ALTER TABLE `ticket_status_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_tsh_ticket` (`ticket_id`),
  ADD KEY `fk_tsh_user` (`changed_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `identifier` (`identifier`),
  ADD KEY `idx_users_role` (`role`),
  ADD KEY `idx_users_status` (`status`);

--
-- Indexes for table `user_sessions`
--
ALTER TABLE `user_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_sessions_user` (`user_id`);

--
-- Indexes for table `validation_runs`
--
ALTER TABLE `validation_runs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_vr_model` (`model_id`),
  ADD KEY `fk_vr_version` (`model_version_id`),
  ADD KEY `fk_vr_requester` (`requested_by`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=170;

--
-- AUTO_INCREMENT for table `datasets`
--
ALTER TABLE `datasets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `dataset_assignments`
--
ALTER TABLE `dataset_assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `dataset_quality_reports`
--
ALTER TABLE `dataset_quality_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deployment_requests`
--
ALTER TABLE `deployment_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `execution_jobs`
--
ALTER TABLE `execution_jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `experiments`
--
ALTER TABLE `experiments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `experiment_runs`
--
ALTER TABLE `experiment_runs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `models`
--
ALTER TABLE `models`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `model_versions`
--
ALTER TABLE `model_versions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `notebooks`
--
ALTER TABLE `notebooks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `notebook_cells`
--
ALTER TABLE `notebook_cells`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `processed_datasets`
--
ALTER TABLE `processed_datasets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `rate_limits`
--
ALTER TABLE `rate_limits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `scenarios`
--
ALTER TABLE `scenarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `submissions`
--
ALTER TABLE `submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `submission_attachments`
--
ALTER TABLE `submission_attachments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `ticket_assignments`
--
ALTER TABLE `ticket_assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `ticket_comments`
--
ALTER TABLE `ticket_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticket_status_history`
--
ALTER TABLE `ticket_status_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `validation_runs`
--
ALTER TABLE `validation_runs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `fk_audit_actor` FOREIGN KEY (`actor_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `datasets`
--
ALTER TABLE `datasets`
  ADD CONSTRAINT `fk_datasets_scenario` FOREIGN KEY (`scenario_id`) REFERENCES `scenarios` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_datasets_uploader` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `dataset_assignments`
--
ALTER TABLE `dataset_assignments`
  ADD CONSTRAINT `fk_da_assigner` FOREIGN KEY (`assigned_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_da_dataset` FOREIGN KEY (`dataset_id`) REFERENCES `datasets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_da_student` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_da_ticket` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `dataset_quality_reports`
--
ALTER TABLE `dataset_quality_reports`
  ADD CONSTRAINT `fk_dqr_dataset` FOREIGN KEY (`dataset_id`) REFERENCES `datasets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_dqr_generator` FOREIGN KEY (`generated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `deployment_requests`
--
ALTER TABLE `deployment_requests`
  ADD CONSTRAINT `fk_dr_admin` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_dr_model` FOREIGN KEY (`model_id`) REFERENCES `models` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_dr_requester` FOREIGN KEY (`requested_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_dr_version` FOREIGN KEY (`model_version_id`) REFERENCES `model_versions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `execution_jobs`
--
ALTER TABLE `execution_jobs`
  ADD CONSTRAINT `fk_ej_notebook` FOREIGN KEY (`notebook_id`) REFERENCES `notebooks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_ej_student` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `experiments`
--
ALTER TABLE `experiments`
  ADD CONSTRAINT `fk_exp_scenario` FOREIGN KEY (`scenario_id`) REFERENCES `scenarios` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_exp_student` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_exp_ticket` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `experiment_runs`
--
ALTER TABLE `experiment_runs`
  ADD CONSTRAINT `fk_er_exp` FOREIGN KEY (`experiment_id`) REFERENCES `experiments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_er_notebook` FOREIGN KEY (`notebook_id`) REFERENCES `notebooks` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_er_student` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `models`
--
ALTER TABLE `models`
  ADD CONSTRAINT `fk_models_run` FOREIGN KEY (`experiment_run_id`) REFERENCES `experiment_runs` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_models_scenario` FOREIGN KEY (`scenario_id`) REFERENCES `scenarios` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_models_student` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_models_ticket` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `model_versions`
--
ALTER TABLE `model_versions`
  ADD CONSTRAINT `fk_mv_model` FOREIGN KEY (`model_id`) REFERENCES `models` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notebooks`
--
ALTER TABLE `notebooks`
  ADD CONSTRAINT `fk_nb_scenario` FOREIGN KEY (`scenario_id`) REFERENCES `scenarios` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_nb_student` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_nb_ticket` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `notebook_cells`
--
ALTER TABLE `notebook_cells`
  ADD CONSTRAINT `fk_nc_notebook` FOREIGN KEY (`notebook_id`) REFERENCES `notebooks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `fk_notif_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD CONSTRAINT `fk_pw_creator` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_pw_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `processed_datasets`
--
ALTER TABLE `processed_datasets`
  ADD CONSTRAINT `fk_pd_source` FOREIGN KEY (`source_dataset_id`) REFERENCES `datasets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_pd_student` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_pd_ticket` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `scenarios`
--
ALTER TABLE `scenarios`
  ADD CONSTRAINT `fk_scenarios_author` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `submissions`
--
ALTER TABLE `submissions`
  ADD CONSTRAINT `fk_sub_model` FOREIGN KEY (`model_id`) REFERENCES `models` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_sub_notebook` FOREIGN KEY (`notebook_id`) REFERENCES `notebooks` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_sub_reviewer` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_sub_student` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_sub_ticket` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `submission_attachments`
--
ALTER TABLE `submission_attachments`
  ADD CONSTRAINT `fk_sa_sub` FOREIGN KEY (`submission_id`) REFERENCES `submissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD CONSTRAINT `fk_settings_updater` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `fk_tickets_creator` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_tickets_scenario` FOREIGN KEY (`scenario_id`) REFERENCES `scenarios` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `ticket_assignments`
--
ALTER TABLE `ticket_assignments`
  ADD CONSTRAINT `fk_assignments_creator` FOREIGN KEY (`assigned_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_assignments_student` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_assignments_ticket` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ticket_comments`
--
ALTER TABLE `ticket_comments`
  ADD CONSTRAINT `fk_comments_ticket` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_comments_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ticket_status_history`
--
ALTER TABLE `ticket_status_history`
  ADD CONSTRAINT `fk_tsh_ticket` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tsh_user` FOREIGN KEY (`changed_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `user_sessions`
--
ALTER TABLE `user_sessions`
  ADD CONSTRAINT `fk_sessions_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `validation_runs`
--
ALTER TABLE `validation_runs`
  ADD CONSTRAINT `fk_vr_model` FOREIGN KEY (`model_id`) REFERENCES `models` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_vr_requester` FOREIGN KEY (`requested_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_vr_version` FOREIGN KEY (`model_version_id`) REFERENCES `model_versions` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
