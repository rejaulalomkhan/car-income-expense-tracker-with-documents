-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 08, 2025 at 05:30 AM
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

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('be_software_cache_356a192b7913b04c54574d18c28d46e6395428ab', 'i:1;', 1746649932),
('be_software_cache_356a192b7913b04c54574d18c28d46e6395428ab:timer', 'i:1746649932;', 1746649932);

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
(1, 'Car3', 'ABC-123', 'Corolla', 2020, 'White', NULL, 'active', '2025-05-06 09:15:03', '2025-05-07 03:42:53'),
(2, 'Car4', 'XYZ-789', 'Civic', 2021, 'Black', NULL, 'active', '2025-05-06 09:15:03', '2025-05-07 03:43:19'),
(5, 'Car2', '633', '1615', 1995, 'Red', 'cars/etjkSUBaRB8IHjrwqRTRCe8DcqyLoYQqcSIDwXY8.png', 'active', '2025-05-06 09:16:59', '2025-05-07 03:42:34'),
(6, 'Car1', 'ঢাকা গ ৪৫০', 'করলা', 1998, 'Red', 'cars/GXSpuQrosKGvYYXeryEzA2A0yJCJ5xjcH2KdAx7w.png', 'active', '2025-05-06 09:22:06', '2025-05-06 09:22:06');

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

--
-- Dumping data for table `car_documents`
--

INSERT INTO `car_documents` (`id`, `car_id`, `document_type`, `document_expiry_date`, `document_image`, `document_comment`, `created_at`, `updated_at`, `notification_sent`) VALUES
(1, 1, 'Certificate of Registration', '2026-01-06', NULL, 'Certificate of Registration for Toyota Corolla', '2025-05-06 09:15:03', '2025-05-06 09:15:03', 0),
(2, 1, 'Fitness', '2025-06-06', 'car-documents/21ko4aSTWR2gPEgWZlOby86gOYbGiGxHVYNL91nB.pdf', 'Fitness for Toyota Corolla', '2025-05-06 09:15:03', '2025-05-07 04:40:05', 0),
(3, 1, 'Tax Token', '2025-10-06', NULL, 'Tax Token for Toyota Corolla', '2025-05-06 09:15:03', '2025-05-06 09:15:03', 0),
(4, 1, 'Insurance', '2026-01-06', NULL, 'Insurance for Toyota Corolla', '2025-05-06 09:15:04', '2025-05-06 09:15:04', 0),
(5, 1, 'Route Permit', '2025-10-06', NULL, 'Route Permit for Toyota Corolla', '2025-05-06 09:15:04', '2025-05-06 09:15:04', 0),
(6, 1, 'Branding', '2026-04-06', NULL, 'Branding for Toyota Corolla', '2025-05-06 09:15:04', '2025-05-06 09:15:04', 0),
(7, 2, 'Certificate of Registration', '2025-12-06', NULL, 'Certificate of Registration for Honda Civic', '2025-05-06 09:15:04', '2025-05-06 09:15:04', 0),
(8, 2, 'Fitness', '2025-03-05', NULL, 'Fitness for Honda Civic', '2025-05-06 09:15:04', '2025-05-07 20:27:00', 0),
(9, 2, 'Tax Token', '2026-02-06', NULL, 'Tax Token for Honda Civic', '2025-05-06 09:15:04', '2025-05-06 09:15:04', 0),
(10, 2, 'Insurance', '2025-11-06', NULL, 'Insurance for Honda Civic', '2025-05-06 09:15:04', '2025-05-06 09:15:04', 0),
(11, 2, 'Route Permit', '2025-12-06', NULL, 'Route Permit for Honda Civic', '2025-05-06 09:15:04', '2025-05-06 09:15:04', 0),
(12, 2, 'Branding', '2026-02-06', NULL, 'Branding for Honda Civic', '2025-05-06 09:15:04', '2025-05-06 09:15:04', 0),
(25, 6, 'Branding', '2027-04-16', 'car-documents/1Icml1U7NTLAcLE1RWX00ZHvteN5jYNGKrYlMGIV.pdf', 'Test', '2025-05-06 09:48:17', '2025-05-06 10:05:38', 0);

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
(2, 1, 200.00, 'Fuel', '2024-01-12', 'Fuel refill', '2025-05-06 09:15:06', '2025-05-06 09:15:06'),
(3, 2, 500.00, 'Maintenance', '2024-01-10', 'Regular maintenance service', '2025-05-06 09:15:06', '2025-05-06 09:15:06'),
(4, 2, 200.00, 'Fuel', '2024-01-12', 'Fuel refill', '2025-05-06 09:15:06', '2025-05-06 09:15:06'),
(9, 6, 1.00, 'Fines', '2014-08-11', 'Minus saepe aut quas', '2025-05-06 10:46:55', '2025-05-06 10:46:55'),
(10, 5, 42.00, 'Spare Parts', '2016-02-24', 'Vel voluptatem debi', '2025-05-06 10:47:00', '2025-05-06 10:47:00'),
(12, 6, 1000.00, 'Driver', '2025-05-07', 'tre', '2025-05-06 23:38:02', '2025-05-06 23:38:02'),
(13, 6, 5000.00, 'Fuel', '2025-05-07', 'test', '2025-05-06 23:38:36', '2025-05-06 23:38:36'),
(14, 6, 99.00, 'Spare Parts', '1971-12-30', 'Earum architecto rep', '2025-05-07 06:25:54', '2025-05-07 06:25:54'),
(15, 2, 30000.00, 'Garage Rent', '2025-05-07', 'asdf', '2025-05-07 07:20:44', '2025-05-07 07:20:44'),
(16, 5, 34.00, 'Maintenance', '1988-03-21', 'Excepteur et eos mol', '2025-05-07 08:06:17', '2025-05-07 08:06:17'),
(17, 1, 70.00, 'Fuel', '1977-06-01', 'Qui earum cupiditate', '2025-05-07 08:06:20', '2025-05-07 08:06:20'),
(18, 5, 55.00, 'Fuel', '2025-01-22', 'Qui omnis odit deser', '2025-05-07 08:06:46', '2025-05-07 08:06:46'),
(19, 5, 2000.00, 'Fuel', '2025-05-06', 'Test', '2025-05-07 11:18:15', '2025-05-07 11:18:15');

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
(1, 1, 1500.00, 'Rental', '2024-01-15', 'Weekend rental income', '2025-05-06 09:15:05', '2025-05-06 09:15:05'),
(2, 1, 2000.00, 'Tour', '2024-01-20', 'Tour package income', '2025-05-06 09:15:05', '2025-05-06 09:15:05'),
(3, 2, 1500.00, 'Rental', '2024-01-15', 'Weekend rental income', '2025-05-06 09:15:05', '2025-05-06 09:15:05'),
(4, 2, 2000.00, 'Tour', '2024-01-20', 'Tour package income', '2025-05-06 09:15:06', '2025-05-06 09:15:06'),
(9, 2, 30000.00, 'ji ', '2025-05-06', 'j', '2025-05-06 10:21:38', '2025-05-06 10:21:38'),
(10, 2, 1000.00, 'Vara', '2025-05-06', 'vara', '2025-05-06 10:29:39', '2025-05-06 10:29:39'),
(11, 6, 20000.00, 'Test', '2025-05-07', 'Test', '2025-05-07 04:18:27', '2025-05-07 04:18:27'),
(12, 5, 1000.00, 'ji ', '2025-05-07', 'test', '2025-05-07 04:33:53', '2025-05-07 04:33:53'),
(13, 1, 10000.00, 'Test', '2025-05-07', 'test', '2025-05-07 04:34:06', '2025-05-07 04:34:06'),
(14, 2, 5000.00, 'iu', '2025-05-01', 'ui', '2025-05-07 08:08:58', '2025-05-07 08:08:58'),
(15, 5, 2000.00, 'uio', '2025-02-07', 'hui', '2025-05-07 08:09:35', '2025-05-07 08:09:35');

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
('27jnliJ8F9xHbSIYTER9kYuUoW2EkeaTFx0G6znU', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiZ0pRYm9yNzhFSlBlaUJhSHNySEVYYTBVTkY5azlHWHUwcHNCamJtRyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjMxOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvZGFzaGJvYXJkIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1746644832),
('aVT2Je5vbeJF3mznwJvh0d5mDCCUhSixJbuo03Rg', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoic0xFcVVJSjJlUmhIcFk5aWR1VVhCUFcxejVTdDNDVjFkb1RUNmV1OSI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjMxOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1746650143);

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
(3, 'theme', 'light', '2025-05-07 10:56:17', '2025-05-07 11:47:13'),
(4, 'language', 'en', '2025-05-07 10:56:17', '2025-05-07 10:56:17'),
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
(1, 'Admin', 'admin@admin.com', NULL, '$2y$12$AfR/sjiIVHLT.x.dbPJcG.VBOAeH56lR55vXo42QaR5Dxr9Jrdcny', NULL, '2025-05-06 09:15:03', '2025-05-06 09:15:03', NULL);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `car_documents`
--
ALTER TABLE `car_documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
