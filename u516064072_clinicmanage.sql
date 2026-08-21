-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 21, 2026 at 08:31 AM
-- Server version: 11.8.8-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u516064072_clinicmanage`
--

-- --------------------------------------------------------

--
-- Table structure for table `appoinments`
--

CREATE TABLE `appoinments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_name` varchar(255) DEFAULT NULL,
  `patient_type` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `message` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `appoinments`
--

INSERT INTO `appoinments` (`id`, `patient_name`, `patient_type`, `phone`, `message`, `created_at`, `updated_at`) VALUES
(1, 'Developer', 'Old patient / follow-up', '09235279546', 'red', '2026-07-29 04:09:36', '2026-07-29 04:09:36');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `doctor_data`
--

CREATE TABLE `doctor_data` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `report_type` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `file` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`file`)),
  `date` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `failed_jobs`
--

INSERT INTO `failed_jobs` (`id`, `uuid`, `connection`, `queue`, `payload`, `exception`, `failed_at`) VALUES
(1, '2de88f66-77e3-450f-a372-d7fe1a3c5d7f', 'database', 'default', '{\"uuid\":\"2de88f66-77e3-450f-a372-d7fe1a3c5d7f\",\"displayName\":\"App\\\\Listeners\\\\DoctorListener\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Events\\\\CallQueuedListener\",\"command\":\"O:36:\\\"Illuminate\\\\Events\\\\CallQueuedListener\\\":26:{s:5:\\\"class\\\";s:28:\\\"App\\\\Listeners\\\\DoctorListener\\\";s:6:\\\"method\\\";s:6:\\\"handle\\\";s:4:\\\"data\\\";a:1:{i:0;O:25:\\\"App\\\\Events\\\\DoctorRegEvent\\\":2:{s:4:\\\"data\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:5;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:17:\\\"planTextPasssword\\\";s:8:\\\"12345678\\\";}}s:5:\\\"tries\\\";N;s:13:\\\"maxExceptions\\\";N;s:7:\\\"backoff\\\";N;s:10:\\\"retryUntil\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"failOnTimeout\\\";b:0;s:17:\\\"shouldBeEncrypted\\\";b:0;s:14:\\\"shouldBeUnique\\\";b:0;s:29:\\\"shouldBeUniqueUntilProcessing\\\";b:0;s:8:\\\"uniqueId\\\";N;s:9:\\\"uniqueFor\\\";N;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1785244565,\"delay\":null}', 'Illuminate\\Database\\Eloquent\\ModelNotFoundException: No query results for model [App\\Models\\User]. in C:\\xampp\\htdocs\\clinic-managment\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Builder.php:780\nStack trace:\n#0 C:\\xampp\\htdocs\\clinic-managment\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\SerializesAndRestoresModelIdentifiers.php(112): Illuminate\\Database\\Eloquent\\Builder->firstOrFail()\n#1 C:\\xampp\\htdocs\\clinic-managment\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\SerializesAndRestoresModelIdentifiers.php(63): App\\Events\\DoctorRegEvent->restoreModel(Object(Illuminate\\Contracts\\Database\\ModelIdentifier))\n#2 C:\\xampp\\htdocs\\clinic-managment\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\SerializesModels.php(97): App\\Events\\DoctorRegEvent->getRestoredPropertyValue(Object(Illuminate\\Contracts\\Database\\ModelIdentifier))\n#3 [internal function]: App\\Events\\DoctorRegEvent->__unserialize(Array)\n#4 C:\\xampp\\htdocs\\clinic-managment\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(97): unserialize(\'O:36:\"Illuminat...\')\n#5 C:\\xampp\\htdocs\\clinic-managment\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(64): Illuminate\\Queue\\CallQueuedHandler->getCommand(Array)\n#6 C:\\xampp\\htdocs\\clinic-managment\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)\n#7 C:\\xampp\\htdocs\\clinic-managment\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(504): Illuminate\\Queue\\Jobs\\Job->fire()\n#8 C:\\xampp\\htdocs\\clinic-managment\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(454): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))\n#9 C:\\xampp\\htdocs\\clinic-managment\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(212): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))\n#10 C:\\xampp\\htdocs\\clinic-managment\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(149): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))\n#11 C:\\xampp\\htdocs\\clinic-managment\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(132): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')\n#12 C:\\xampp\\htdocs\\clinic-managment\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#13 C:\\xampp\\htdocs\\clinic-managment\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#14 C:\\xampp\\htdocs\\clinic-managment\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#15 C:\\xampp\\htdocs\\clinic-managment\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#16 C:\\xampp\\htdocs\\clinic-managment\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(799): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#17 C:\\xampp\\htdocs\\clinic-managment\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(211): Illuminate\\Container\\Container->call(Array)\n#18 C:\\xampp\\htdocs\\clinic-managment\\vendor\\symfony\\console\\Command\\Command.php(341): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#19 C:\\xampp\\htdocs\\clinic-managment\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(180): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#20 C:\\xampp\\htdocs\\clinic-managment\\vendor\\symfony\\console\\Application.php(1117): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#21 C:\\xampp\\htdocs\\clinic-managment\\vendor\\symfony\\console\\Application.php(356): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#22 C:\\xampp\\htdocs\\clinic-managment\\vendor\\symfony\\console\\Application.php(195): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#23 C:\\xampp\\htdocs\\clinic-managment\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(198): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#24 C:\\xampp\\htdocs\\clinic-managment\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1235): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#25 C:\\xampp\\htdocs\\clinic-managment\\artisan(16): Illuminate\\Foundation\\Application->handleCommand(Object(Symfony\\Component\\Console\\Input\\ArgvInput))\n#26 {main}', '2026-07-29 01:44:57');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_07_29_084824_create_appoinments_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_name` varchar(255) NOT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `record_date` date DEFAULT NULL,
  `address` text DEFAULT NULL,
  `mobile_no` varchar(20) DEFAULT NULL,
  `rcdho_grade` varchar(50) DEFAULT NULL,
  `registration_no` varchar(50) NOT NULL,
  `father_husband_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `patient_name`, `age`, `gender`, `record_date`, `address`, `mobile_no`, `rcdho_grade`, `registration_no`, `father_husband_name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(5, 'Developer', 2, 'Male', '2026-07-30', 'PATNA', '09235279546', 'Grade I', 'REG-2026-001', 'test', '2026-07-30 03:47:31', '2026-07-30 03:47:31', NULL),
(6, 'SASHIDHAR JHA', 70, 'Male', '2026-08-04', 'BHATSIMAR', '8076858412', 'Grade I', 'D-AUG-07-560-26-18452', 'LATE. AWADH JHA', '2026-08-04 13:15:01', '2026-08-04 13:15:01', NULL),
(7, 'sumitro choudhary', NULL, NULL, '2026-08-04', NULL, NULL, NULL, 'd-aug-13-566-26-18458', NULL, '2026-08-04 13:18:12', '2026-08-04 13:18:12', NULL),
(8, 'kaushalya devi', 64, 'Female', '2026-08-04', NULL, NULL, NULL, 'D-AUG-12-565-26-18457', NULL, '2026-08-04 13:19:18', '2026-08-04 13:19:18', NULL),
(10, 'Ramu', 34, 'Male', '2026-08-05', 'PATNA', '729295945', 'Grade I', 'REG-2026-002', 'Akhilesh Yadav', '2026-08-05 11:22:13', '2026-08-05 11:22:13', NULL),
(11, 'Durgesh Kumar', 43, 'Male', '2026-08-10', 'B31 P C Colony Kankarbagh Patna', '9304273219', 'Grade I', 'REG-2026-012', 'Sri Pashupati Jha', '2026-08-10 10:58:06', '2026-08-10 10:58:06', NULL),
(12, 'SANJAY KUMAR', 38, 'Male', '2026-08-08', 'K. WAJEETPUR', '9711700352', 'Grade I', 'O-AUG-01-0067-26-18483', 'TRIVENI MAHTO', '2026-08-13 11:06:50', '2026-08-13 11:06:50', NULL),
(13, 'OM PRAKASH SAH', 55, 'Male', '2026-07-22', 'HATWAN', '7631518714', 'Grade I', 'H-JUL-08-015-26-18423', 'ANANDI SAH', '2026-08-13 11:28:39', '2026-08-13 11:28:39', NULL),
(14, 'CHATURBHUJ MISHRA', 78, 'Male', '2026-06-18', 'MALINAGAR', '9934819722', 'Grade I', 'D-JUN-59-436-26-18276', 'LATE. VIDYANATH MISHRA', '2026-08-13 12:35:15', '2026-08-13 12:35:15', NULL),
(15, 'NATHO SAH', 59, 'Male', '2026-06-18', 'BATARDIHA', '9931117053', 'Grade I', 'D-JUN-60-437-26-18277', 'MANCHIT SAHU', '2026-08-13 12:52:13', '2026-08-13 12:52:13', NULL),
(16, 'RINKU MISHRA', 43, 'Female', '2026-06-18', 'SUROULI', '9801638037', 'Grade I', 'O-JUN-029-0029-26-18278', 'LAXMAN MISHRA', '2026-08-14 12:53:01', '2026-08-14 12:53:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `patient_clinical_records`
--

CREATE TABLE `patient_clinical_records` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `newly_detected` varchar(225) DEFAULT NULL,
  `duration_of_diabetes` varchar(100) DEFAULT NULL,
  `start_insulin_date` date DEFAULT NULL,
  `stop_insulin_date` date DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `height_cm` decimal(5,1) DEFAULT NULL,
  `weight_kg` decimal(5,1) DEFAULT NULL,
  `diabetes` varchar(255) DEFAULT NULL,
  `hypertension` varchar(225) DEFAULT NULL,
  `obesity` varchar(225) DEFAULT NULL,
  `infection` varchar(225) DEFAULT NULL,
  `bmi` decimal(5,2) DEFAULT NULL,
  `waist_height_ratio` decimal(4,2) DEFAULT NULL,
  `bmi_group` varchar(50) DEFAULT NULL,
  `waist_cm` decimal(5,1) DEFAULT NULL,
  `hip_cm` decimal(5,1) DEFAULT NULL,
  `waist_hip_ratio` decimal(4,2) DEFAULT NULL,
  `social_class` varchar(50) DEFAULT NULL,
  `income_class` varchar(50) DEFAULT NULL,
  `education` varchar(100) DEFAULT NULL,
  `physical_activity` varchar(50) DEFAULT NULL,
  `veg_nonveg` varchar(50) DEFAULT NULL,
  `htn` varchar(255) NOT NULL,
  `sbp` int(11) DEFAULT NULL COMMENT 'Systolic Blood Pressure (mmHg)',
  `dbp` int(11) DEFAULT NULL COMMENT 'Diastolic Blood Pressure (mmHg)',
  `hb_percent` decimal(5,2) DEFAULT NULL COMMENT 'Hemoglobin %',
  `plt` int(11) DEFAULT NULL COMMENT 'Platelets',
  `mcv` decimal(5,1) DEFAULT NULL COMMENT 'Mean Corpuscular Volume',
  `creatinine` decimal(5,2) DEFAULT NULL COMMENT 'Creatinine (mg/dL)',
  `egfr` decimal(5,1) DEFAULT NULL COMMENT 'eGFR (mL/min)',
  `acr` decimal(5,2) DEFAULT NULL COMMENT 'Albumin-Creatinine Ratio',
  `uric_acid` decimal(4,2) DEFAULT NULL COMMENT 'Uric acid (mg/dL)',
  `urine_cast_cell` varchar(100) DEFAULT NULL,
  `na_plus` decimal(5,1) DEFAULT NULL COMMENT 'Sodium (mEq/L)',
  `k_plus` decimal(4,2) DEFAULT NULL COMMENT 'Potassium (mEq/L)',
  `i_calcium` decimal(4,2) DEFAULT NULL COMMENT 'Ionized Calcium (mg/dL)',
  `phosphorus` decimal(4,2) DEFAULT NULL COMMENT 'Phosphorus (mg/dL)',
  `sgpt` int(11) DEFAULT NULL COMMENT 'SGPT (U/L)',
  `sgot` int(11) DEFAULT NULL COMMENT 'SGOT (U/L)',
  `alkp` int(11) DEFAULT NULL COMMENT 'ALKP (U/L)',
  `hiv` enum('Negative','Positive','Not Tested') DEFAULT 'Not Tested',
  `hbsag` enum('Negative','Positive','Not Tested') DEFAULT 'Not Tested',
  `hcv` enum('Negative','Positive','Not Tested') DEFAULT 'Not Tested',
  `fib_score` decimal(5,2) DEFAULT NULL,
  `fib_scan` varchar(50) DEFAULT NULL COMMENT 'FibroScan result (kPa)',
  `usg` text DEFAULT NULL COMMENT 'Ultrasound findings',
  `chol` decimal(5,1) DEFAULT NULL COMMENT 'Total Cholesterol (mg/dL)',
  `tg` decimal(5,1) DEFAULT NULL COMMENT 'Triglycerides (mg/dL)',
  `hdl` decimal(4,1) DEFAULT NULL COMMENT 'HDL (mg/dL)',
  `ldl` decimal(5,1) DEFAULT NULL COMMENT 'LDL (mg/dL)',
  `bsf` decimal(5,1) DEFAULT NULL COMMENT 'Blood Sugar Fasting (mg/dL)',
  `bspp` decimal(5,1) DEFAULT NULL COMMENT 'Blood Sugar Post Prandial (mg/dL)',
  `hba1c` decimal(4,1) DEFAULT NULL COMMENT 'HbA1c (%)',
  `tsh` decimal(5,2) DEFAULT NULL COMMENT 'TSH (µIU/mL)',
  `temprature` varchar(255) DEFAULT NULL,
  `t3` decimal(5,1) DEFAULT NULL COMMENT 'T3 (ng/dL)',
  `t4` decimal(5,1) DEFAULT NULL COMMENT 'T4 (µg/dL)',
  `vitamin_d25` decimal(5,1) DEFAULT NULL COMMENT 'Vitamin D25 (ng/mL)',
  `vitamin_b12` decimal(6,1) DEFAULT NULL COMMENT 'Vitamin B12 (pg/mL)',
  `s_cortisol` decimal(5,1) DEFAULT NULL COMMENT 'Serum Cortisol (µg/dL)',
  `dex_skip_test` varchar(100) DEFAULT NULL COMMENT 'Dexamethasone Suppression Test',
  `ophthalmic_ex` text DEFAULT NULL COMMENT 'Ophthalmic Examination',
  `foot_ev` text DEFAULT NULL COMMENT 'Foot Evaluation',
  `car_echo_ev` text DEFAULT NULL COMMENT 'Cardiac Echo Evaluation',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patient_clinical_records`
--

INSERT INTO `patient_clinical_records` (`id`, `newly_detected`, `duration_of_diabetes`, `start_insulin_date`, `stop_insulin_date`, `attachment`, `height_cm`, `weight_kg`, `diabetes`, `hypertension`, `obesity`, `infection`, `bmi`, `waist_height_ratio`, `bmi_group`, `waist_cm`, `hip_cm`, `waist_hip_ratio`, `social_class`, `income_class`, `education`, `physical_activity`, `veg_nonveg`, `htn`, `sbp`, `dbp`, `hb_percent`, `plt`, `mcv`, `creatinine`, `egfr`, `acr`, `uric_acid`, `urine_cast_cell`, `na_plus`, `k_plus`, `i_calcium`, `phosphorus`, `sgpt`, `sgot`, `alkp`, `hiv`, `hbsag`, `hcv`, `fib_score`, `fib_scan`, `usg`, `chol`, `tg`, `hdl`, `ldl`, `bsf`, `bspp`, `hba1c`, `tsh`, `temprature`, `t3`, `t4`, `vitamin_d25`, `vitamin_b12`, `s_cortisol`, `dex_skip_test`, `ophthalmic_ex`, `foot_ev`, `car_echo_ev`, `created_at`, `updated_at`, `deleted_at`, `patient_id`) VALUES
(2, 'No', NULL, '2026-08-07', '2026-08-07', NULL, 5.6, 45.0, 'Normal', 'Normal', 'Normal', 'Normal', 0.02, 0.02, 'Normal', NULL, NULL, NULL, 'Upper', 'High', 'Graduate', 'Sedentary', NULL, 'No', 4, 5, 5.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Negative', 'Negative', 'Negative', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3.0, 4.00, '45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-05 11:22:13', '2026-08-05 11:22:13', NULL, 10),
(3, 'Yes', NULL, NULL, NULL, NULL, 175.0, 80.0, 'Normal', 'Hypertension', 'Obesity', 'Normal', 27.00, NULL, 'Overweight', NULL, NULL, NULL, 'Upper', 'High', 'Graduate', 'Sedentary', NULL, 'No', 159, 89, 11.70, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Negative', 'Negative', 'Negative', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-10 10:58:06', '2026-08-10 10:58:06', NULL, 11),
(4, 'No', NULL, NULL, NULL, 'patient-attachments/1786619210_Sanjay Kumar, K Wajeetpur_0001.pdf', 173.0, 96.0, 'Normal', 'Hypertension', 'Obesity', 'Infection', 32.54, 0.24, 'Obese', 43.0, 42.0, 1.02, 'Lower', 'Low', 'School', 'Sedentary', NULL, 'No', 130, 80, 14.50, 140, 87.5, 1.06, 83.1, NULL, 7.01, 'ABSENT', NULL, NULL, NULL, NULL, 61, NULL, NULL, 'Negative', 'Negative', 'Negative', NULL, NULL, 'GRADE 3', 160.0, NULL, 38.2, 82.2, 74.0, 112.0, NULL, 4.29, '103', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-13 11:06:50', '2026-08-13 11:06:50', NULL, 12),
(5, 'No', NULL, NULL, NULL, 'patient-attachments/1786620519_Om Prakash sah, hatwan_0001.pdf', 165.0, 69.0, 'Normal', 'Hypertension', 'Obesity', 'Infection', 25.36, NULL, 'Overweight', 36.0, 39.0, 0.92, 'Middle', 'Medium', 'School', 'Sedentary', NULL, 'Yes', 140, 80, 13.90, 235, 83.8, 0.82, 103.7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 41, NULL, NULL, 'Negative', 'Positive', 'Negative', NULL, '4.6', 'G-1', NULL, NULL, NULL, NULL, 80.0, NULL, NULL, NULL, '102', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-13 11:28:39', '2026-08-13 11:28:39', NULL, 13),
(6, 'No', NULL, '2026-06-18', NULL, 'patient-attachments/1786624515_Chaturbhuj Mishra, Malinagar_0001.pdf', 157.0, 76.0, 'Diabetes', 'Hypertension', 'Obesity', 'Normal', 30.89, 0.26, 'Obese', 42.0, 37.0, 1.13, 'Middle', 'Medium', 'Graduate', 'Sedentary', NULL, 'Yes', 150, 70, 11.80, 129, 84.3, 1.30, 56.7, NULL, NULL, NULL, 132.0, 5.10, 4.00, NULL, 80, NULL, NULL, 'Negative', 'Negative', 'Negative', NULL, NULL, 'grade-2, splenomegaly, left renal cyst', 99.0, NULL, 32.0, 38.6, 208.0, NULL, 9.3, 0.93, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-13 12:35:15', '2026-08-13 12:35:15', NULL, 14),
(7, 'No', NULL, '2026-06-18', NULL, 'patient-attachments/1786625533_Natho Sah, Batardiha_0001.pdf', 165.0, 59.0, 'Diabetes', 'Hypertension', 'Normal', 'Infection', 21.69, 0.20, 'Normal', 34.0, 35.0, 0.97, 'Lower', 'Low', 'School', 'Sedentary', NULL, 'Yes', 140, 70, 11.50, 234, 84.3, 1.03, 78.6, NULL, NULL, 'absent', NULL, NULL, NULL, NULL, 24, NULL, NULL, 'Negative', 'Negative', 'Negative', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 188.5, NULL, 8.4, NULL, '100', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-13 12:52:13', '2026-08-13 12:52:13', NULL, 15),
(8, 'No', NULL, NULL, NULL, 'patient-attachments/1786711981_Rinku Mishra, Surouli_0001.pdf', 157.0, 68.0, 'Normal', 'Hypertension', 'Obesity', 'Normal', 27.64, 0.22, 'Overweight', 36.0, 38.0, 0.94, 'Middle', 'Medium', 'Graduate', 'Sedentary', NULL, 'No', 130, 80, 11.10, 181, 78.8, 0.67, 102.1, NULL, NULL, 'absent', NULL, NULL, NULL, NULL, 27, NULL, NULL, 'Negative', 'Negative', 'Negative', NULL, NULL, 'grade2', NULL, NULL, NULL, NULL, 89.0, NULL, NULL, 19.10, NULL, NULL, 5.0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-14 12:53:01', '2026-08-14 12:53:01', NULL, 16);

-- --------------------------------------------------------

--
-- Table structure for table `room_creates`
--

CREATE TABLE `room_creates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `file` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `room_type` varchar(255) DEFAULT NULL,
  `members` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`members`)),
  `room_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `room_creates`
--

INSERT INTO `room_creates` (`id`, `file`, `created_by`, `room_type`, `members`, `room_name`, `created_at`, `updated_at`) VALUES
(4, NULL, 1, 'public', '[\"test\",\"test\"]', 'test-room', '2026-08-21 06:39:28', '2026-08-21 06:39:28');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `pin_code` varchar(255) DEFAULT NULL,
  `doctor_strime` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` enum('super_admin','doctor') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `city`, `phone`, `state`, `country`, `pin_code`, `doctor_strime`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`) VALUES
(1, 'Admin', NULL, NULL, NULL, NULL, NULL, NULL, 'admin@gmail.com', '2026-07-28 04:45:40', '$2y$12$saCHMl1NhpWXAefnvZhaROTHW2uGA19J8izMBj6TMYlPviLTg0NQa', 'JhbxVDbnDaQy8oLFfxvwRgpaqfHn2BcNjkSl3yVHrjhZeNGj5sXczldxqClJ', '2026-07-28 04:45:41', '2026-07-28 04:45:41', 'super_admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appoinments`
--
ALTER TABLE `appoinments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `doctor_data`
--
ALTER TABLE `doctor_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctor_data_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `patients_new_registration_no_unique` (`registration_no`),
  ADD KEY `patients_patient_name_index` (`patient_name`),
  ADD KEY `patients_record_date_index` (`record_date`),
  ADD KEY `patients_mobile_no_index` (`mobile_no`);

--
-- Indexes for table `patient_clinical_records`
--
ALTER TABLE `patient_clinical_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_clinical_records_bmi_group_index` (`bmi_group`),
  ADD KEY `idx_new_diabetes` (`newly_detected`,`duration_of_diabetes`),
  ADD KEY `patient_clinical_records_patient_id_foreign` (`patient_id`);

--
-- Indexes for table `room_creates`
--
ALTER TABLE `room_creates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room_creates_created_by_foreign` (`created_by`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appoinments`
--
ALTER TABLE `appoinments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `doctor_data`
--
ALTER TABLE `doctor_data`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `patient_clinical_records`
--
ALTER TABLE `patient_clinical_records`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `room_creates`
--
ALTER TABLE `room_creates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `doctor_data`
--
ALTER TABLE `doctor_data`
  ADD CONSTRAINT `doctor_data_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `room_creates`
--
ALTER TABLE `room_creates`
  ADD CONSTRAINT `room_creates_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
