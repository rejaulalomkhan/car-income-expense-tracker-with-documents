-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 17, 2025 at 07:23 AM
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
-- Database: `car_expense_tracker`
--

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
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `plate_number` varchar(255) NOT NULL,
  `model` varchar(255) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`id`, `name`, `plate_number`, `model`, `year`, `color`, `photo`, `status`, `created_at`, `updated_at`) VALUES
(10, 'Car 1', 'ACB123', 'Civic', 2005, 'red', NULL, 'active', '2025-05-17 04:01:41', '2025-05-17 04:01:41'),
(11, 'Car 2', 'ABC3', 'Camry', 2010, 'Black', NULL, 'active', '2025-05-17 04:02:11', '2025-05-17 04:02:11');

-- --------------------------------------------------------

--
-- Table structure for table `car_documents`
--

CREATE TABLE `car_documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `car_id` bigint(20) UNSIGNED NOT NULL,
  `document_type` enum('Certificate of Registration','Fitness','Tax Token','Insurance','Route Permit','Branding') DEFAULT NULL,
  `document_expiry_date` date DEFAULT NULL,
  `document_image` varchar(255) DEFAULT NULL,
  `document_comment` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `notification_sent` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `company_documents`
--

CREATE TABLE `company_documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `document_type_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `issue_date` date DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `document_file` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `notification_sent` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `company_documents`
--

INSERT INTO `company_documents` (`id`, `document_type_id`, `title`, `issue_date`, `expiry_date`, `document_file`, `description`, `is_active`, `created_at`, `updated_at`, `notification_sent`) VALUES
(1, 1, 'Test doc', '2025-05-07', '2025-09-26', 'company-documents/bwmDjsEOefKhNNfIr8yWmEkCirM1KEFq1Tzslp90.pdf', 'Test', 1, '2025-05-07 08:00:38', '2025-05-07 08:00:38', 0),
(2, 1, 'as', '2025-05-07', '2025-05-15', 'company-documents/qOS5FkwJ1hEhHmbYfbt2IdjMglKuvE2iDk8ATLmZ.png', 'a', 1, '2025-05-07 20:31:37', '2025-05-07 20:31:49', 0);

-- --------------------------------------------------------

--
-- Table structure for table `document_types`
--

CREATE TABLE `document_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `document_types`
--

INSERT INTO `document_types` (`id`, `name`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Insurance', 'Vehicle insurance documents', 1, '2025-05-06 09:15:05', '2025-05-06 09:15:05'),
(2, 'Registration', 'Vehicle registration documents', 1, '2025-05-06 09:15:05', '2025-05-06 09:15:05'),
(3, 'Maintenance', 'Vehicle maintenance records', 1, '2025-05-06 09:15:05', '2025-05-06 09:15:05'),
(4, 'Purchase', 'Vehicle purchase documents', 1, '2025-05-06 09:15:05', '2025-05-06 09:15:05');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `car_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `category` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `car_id`, `amount`, `category`, `date`, `description`, `created_at`, `updated_at`) VALUES
(1, 10, 15000.00, 'Maintenance', '2024-12-30', '', '2025-05-17 04:07:44', '2025-05-17 04:07:44'),
(2, 11, 15000.00, 'Maintenance', '2024-12-30', '', '2025-05-17 04:08:02', '2025-05-17 04:08:02'),
(3, 10, 1000.00, 'Others', '2025-01-26', '', '2025-05-17 04:17:33', '2025-05-17 04:17:33'),
(4, 11, 1000.00, 'Others', '2025-01-26', '', '2025-05-17 04:17:44', '2025-05-17 04:17:44');

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

-- --------------------------------------------------------

--
-- Table structure for table `fuels`
--

CREATE TABLE `fuels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `car_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `liters` decimal(8,2) NOT NULL,
  `cost_per_liter` decimal(8,2) NOT NULL,
  `total_cost` decimal(10,2) NOT NULL,
  `odometer` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `incomes`
--

CREATE TABLE `incomes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `car_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `source` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `incomes`
--

INSERT INTO `incomes` (`id`, `car_id`, `amount`, `source`, `date`, `description`, `created_at`, `updated_at`) VALUES
(24, 10, 10200.00, 'Rent', '2024-12-11', '', '2025-05-17 04:03:20', '2025-05-17 04:03:20'),
(25, 10, 15000.00, 'Rent', '2024-12-16', '', '2025-05-17 04:03:45', '2025-05-17 04:03:45'),
(26, 10, 14800.00, 'Rent', '2024-12-12', '', '2025-05-17 04:04:05', '2025-05-17 04:04:05'),
(27, 11, 8300.00, 'Rent', '2024-12-21', '', '2025-05-17 04:04:52', '2025-05-17 04:04:52'),
(28, 10, 16500.00, 'Rent', '2024-12-22', '', '2025-05-17 04:05:24', '2025-05-17 04:05:24'),
(29, 10, 19000.00, 'Rent', '2024-12-27', '', '2025-05-17 04:05:47', '2025-05-17 04:05:47'),
(30, 11, 19000.00, 'Rent', '2024-12-27', '', '2025-05-17 04:06:05', '2025-05-17 04:06:05'),
(31, 10, 19000.00, 'Rent', '2024-12-30', '', '2025-05-17 04:06:43', '2025-05-17 04:06:43'),
(32, 11, 20000.00, 'Rent', '2024-12-30', '', '2025-05-17 04:07:07', '2025-05-17 04:07:07'),
(33, 10, 16000.00, 'Rent', '2025-01-03', '', '2025-05-17 04:08:28', '2025-05-17 04:08:28'),
(34, 10, 17400.00, 'Rent', '2025-01-06', '', '2025-05-17 04:08:51', '2025-05-17 04:08:51'),
(35, 11, 17000.00, 'Rent', '2025-01-06', '', '2025-05-17 04:09:11', '2025-05-17 04:09:11'),
(36, 10, 15000.00, 'Rent', '2025-01-08', '', '2025-05-17 04:09:28', '2025-05-17 04:09:28'),
(37, 11, 19000.00, 'Rent', '2025-01-09', '', '2025-05-17 04:09:47', '2025-05-17 04:09:47'),
(38, 10, 18500.00, 'Rent', '2025-01-13', '', '2025-05-17 04:10:04', '2025-05-17 04:10:04'),
(39, 11, 13600.00, 'Rent', '2025-01-13', '', '2025-05-17 04:10:18', '2025-05-17 04:10:18'),
(40, 10, 18000.00, 'Rent', '2025-01-16', '', '2025-05-17 04:13:09', '2025-05-17 04:13:09'),
(41, 11, 15000.00, 'Rent', '2025-01-17', '', '2025-05-17 04:13:27', '2025-05-17 04:13:27'),
(42, 10, 18000.00, 'Rent', '2025-01-20', '', '2025-05-17 04:13:41', '2025-05-17 04:13:41'),
(43, 11, 13000.00, 'Rent', '2025-01-20', '', '2025-05-17 04:13:54', '2025-05-17 04:13:54'),
(44, 10, 20000.00, 'Rent', '2025-01-24', '', '2025-05-17 04:14:15', '2025-05-17 04:14:15'),
(45, 11, 13000.00, 'Rent', '2025-01-24', '', '2025-05-17 04:14:32', '2025-05-17 04:14:32'),
(46, 10, 17000.00, 'Rent', '2025-01-26', '', '2025-05-17 04:14:51', '2025-05-17 04:14:51'),
(47, 11, 13000.00, 'Rent', '2025-01-26', '', '2025-05-17 04:15:04', '2025-05-17 04:15:04'),
(48, 10, 17000.00, 'Rent', '2025-01-30', '', '2025-05-17 04:15:19', '2025-05-17 04:15:19'),
(49, 11, 12000.00, 'Rent', '2025-01-30', '', '2025-05-17 04:15:30', '2025-05-17 04:15:30');

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
-- Table structure for table `maintenances`
--

CREATE TABLE `maintenances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `car_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `description` text NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
(4, '2025_05_06_114606_create_cars_table', 1),
(5, '2025_05_06_114607_create_car__documents_table', 1),
(6, '2025_05_06_114608_create_incomes_table', 1),
(7, '2025_05_06_114609_create_expenses_table', 1),
(8, '2025_05_06_115205_create_document_types_table', 1),
(9, '2025_05_06_115206_create_company_documents_table', 1),
(10, '2025_05_07_000001_create_settings_table', 2),
(11, '2025_05_07_000002_add_notification_sent_to_documents', 2),
(12, '2025_05_07_000003_create_notifications_table', 2),
(14, '2024_03_19_000000_create_maintenances_table', 3),
(15, '2025_05_07_000005_add_push_subscription_to_users', 3),
(16, '2024_03_19_000001_create_fuels_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('bSREujnqy6EzhFHw1mqEibxITujzPEL1w3C6POWb', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiYVN3SzdnMmlENW00aXJJU1pFQ1Z6b0JWeGJ4ckI2SGs2MHRyR21EUyI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjMxOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1746682212),
('yFRVdKz5BMLnlL0iNUg6Cxp7No4vfjzmvVWkd1zh', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiUUxnMVZJUFZJRjVWUDNjdERjS1VGSHAzT0RoVklacDhrY0JvcWxMaCI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjMxOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1746683154);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'contact_email', 'armanazij@gmail.com', '2025-05-07 10:56:17', '2025-05-07 10:56:17'),
(2, 'contact_phone', '01916628339', '2025-05-07 10:56:17', '2025-05-07 10:56:31'),
(3, 'theme', 'light', '2025-05-07 10:56:17', '2025-05-15 12:36:33'),
(4, 'language', 'bn', '2025-05-07 10:56:17', '2025-05-12 07:20:06'),
(5, 'logo', 'settings/DdpLy2RZYZiga7TMnaXyqwUeF5DmIYOiRsS2nnWQ.png', '2025-05-07 10:56:17', '2025-05-07 12:43:40'),
(6, 'icon', 'settings/hT9nBF1vGdElROiIpdd8OKQ1lzgcXyMnW7yUn1vy.png', '2025-05-07 10:56:17', '2025-05-07 12:43:40');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `push_subscription` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `push_subscription`) VALUES
(1, 'Admin', 'admin@admin.com', NULL, '$2y$12$AfR/sjiIVHLT.x.dbPJcG.VBOAeH56lR55vXo42QaR5Dxr9Jrdcny', NULL, '2025-05-06 09:15:03', '2025-05-06 09:15:03', NULL),
(2, 'Arman azij', 'armanazij@gmail.com', NULL, '$2y$12$qMrkR7Ghfmx0QKZculTrHe5QE1RLaot0G6PWEB03989c5kDnJYfve', NULL, '2025-05-15 12:38:57', '2025-05-15 12:38:57', NULL);

--
-- Indexes for dumped tables
--

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
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cars_plate_number_unique` (`plate_number`);

--
-- Indexes for table `car_documents`
--
ALTER TABLE `car_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `car_documents_car_id_foreign` (`car_id`);

--
-- Indexes for table `company_documents`
--
ALTER TABLE `company_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_documents_document_type_id_foreign` (`document_type_id`);

--
-- Indexes for table `document_types`
--
ALTER TABLE `document_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expenses_car_id_foreign` (`car_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `fuels`
--
ALTER TABLE `fuels`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fuels_car_id_foreign` (`car_id`);

--
-- Indexes for table `incomes`
--
ALTER TABLE `incomes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `incomes_car_id_foreign` (`car_id`);

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
-- Indexes for table `maintenances`
--
ALTER TABLE `maintenances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `maintenances_car_id_foreign` (`car_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

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
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `car_documents`
--
ALTER TABLE `car_documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company_documents`
--
ALTER TABLE `company_documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `document_types`
--
ALTER TABLE `document_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fuels`
--
ALTER TABLE `fuels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `incomes`
--
ALTER TABLE `incomes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `maintenances`
--
ALTER TABLE `maintenances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `car_documents`
--
ALTER TABLE `car_documents`
  ADD CONSTRAINT `car_documents_car_id_foreign` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `company_documents`
--
ALTER TABLE `company_documents`
  ADD CONSTRAINT `company_documents_document_type_id_foreign` FOREIGN KEY (`document_type_id`) REFERENCES `document_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_car_id_foreign` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fuels`
--
ALTER TABLE `fuels`
  ADD CONSTRAINT `fuels_car_id_foreign` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `incomes`
--
ALTER TABLE `incomes`
  ADD CONSTRAINT `incomes_car_id_foreign` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `maintenances`
--
ALTER TABLE `maintenances`
  ADD CONSTRAINT `maintenances_car_id_foreign` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
