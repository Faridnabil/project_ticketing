-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 05, 2024 at 12:17 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `billing`
--
CREATE DATABASE IF NOT EXISTS `billing` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `billing`;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_06_28_040109_create_services_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Database: `booking`
--
CREATE DATABASE IF NOT EXISTS `booking` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `booking`;

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint UNSIGNED NOT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `booking_date` date NOT NULL,
  `booking_time` time NOT NULL,
  `barber_id` bigint UNSIGNED NOT NULL,
  `additional_notes` text COLLATE utf8mb4_unicode_ci,
  `total_price` decimal(8,2) NOT NULL DEFAULT '0.00',
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `snap_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `user_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `full_name`, `phone_number`, `address`, `booking_date`, `booking_time`, `barber_id`, `additional_notes`, `total_price`, `payment_method`, `snap_token`, `created_at`, `updated_at`, `status`, `user_id`) VALUES
(57, 'Rudi', '08121320452', 'jl.Pramuka RT02/01, Bunder Jatiluhur Purwakarta', '2024-06-11', '10:00:00', 2, '2', '50000.00', 'cash', NULL, '2024-06-11 03:40:24', '2024-06-11 03:40:28', 'waiting', 8),
(58, 'Rudi', '08121320452', 'jl.Pramuka RT02/01, Bunder Jatiluhur Purwakarta', '2024-06-11', '11:00:00', 2, '3', '35000.00', 'cash', NULL, '2024-06-11 03:41:05', '2024-06-11 03:41:08', 'waiting', 8),
(59, 'Rudi', '08121320452', 'jl.Pramuka RT02/01, Bunder Jatiluhur Purwakarta', '2024-06-11', '13:00:00', 2, '5', '250000.00', 'cash', NULL, '2024-06-11 03:41:46', '2024-06-11 03:41:49', 'waiting', 8),
(60, 'Rudi', '08121320452', 'jl.Pramuka RT02/01, Bunder Jatiluhur Purwakarta', '2024-06-11', '14:00:00', 2, '6', '72250.00', 'cash', NULL, '2024-06-11 03:42:25', '2024-06-11 03:42:29', 'waiting', 8),
(69, 'Andi', '08771257821', 'jkt', '2024-06-12', '09:00:00', 2, '...', '50000.00', 'cash', NULL, '2024-06-11 22:36:14', '2024-06-12 01:46:59', 'done', 7),
(70, 'Andi', '087778610193', 'jl.Pramuka RT02/01, Bunder Jatiluhur Purwakarta', '2024-06-12', '17:00:00', 2, NULL, '180000.00', 'cash', NULL, '2024-06-11 23:11:18', '2024-06-11 23:13:33', 'done', 7),
(71, 'Andi', '098787688', 'jkt', '2024-06-12', '09:00:00', 6, '3', '85000.00', 'cash', NULL, '2024-06-11 23:14:56', '2024-06-11 23:14:59', 'waiting', 7),
(72, 'Andi', '09887898', 'jkt', '2024-06-14', '09:00:00', 6, '4', '250000.00', 'cash', NULL, '2024-06-11 23:15:52', '2024-06-11 23:15:56', 'waiting', 7),
(73, 'Andi', '086545656', 'jkt', '2024-06-13', '09:00:00', 2, '5', '12750.00', 'cash', NULL, '2024-06-11 23:16:48', '2024-06-11 23:16:52', 'waiting', 7),
(74, 'Raka Wahyu Pratama', '087662773677', 'cilandak', '2024-06-20', '11:00:00', 6, 'Contoh', '200000.00', 'cash', NULL, '2024-06-12 01:34:42', '2024-06-12 01:45:18', 'waiting', 9),
(75, 'Raka Wahyu Pratama', '0872377333', 'cilandak', '2024-06-13', '16:00:00', 6, '2', '50000.00', 'cash', NULL, '2024-06-12 01:38:15', '2024-06-12 01:45:35', 'waiting', 9),
(76, 'Raka Wahyu Pratama', '0872377333', 'cilandak', '2024-06-19', '12:00:00', 2, '3', '250000.00', 'cash', NULL, '2024-06-12 01:38:54', '2024-06-12 01:51:38', 'pending', 9),
(77, 'Raka Wahyu Pratama', '0872377333', 'cilandak', '2024-06-12', '15:00:00', 2, '4', '85000.00', 'cash', NULL, '2024-06-12 01:39:33', '2024-06-12 01:39:33', 'pending', 9),
(78, 'Raka Wahyu Pratama', '0872377333', 'cilandak', '2024-06-12', '12:00:00', 6, '5', '212500.00', 'cash', NULL, '2024-06-12 01:40:39', '2024-06-12 01:40:39', 'pending', 9);

-- --------------------------------------------------------

--
-- Table structure for table `booking_service`
--

CREATE TABLE `booking_service` (
  `id` bigint UNSIGNED NOT NULL,
  `booking_id` bigint UNSIGNED NOT NULL,
  `service_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `booking_service`
--

INSERT INTO `booking_service` (`id`, `booking_id`, `service_id`, `created_at`, `updated_at`) VALUES
(68, 57, 2, NULL, NULL),
(69, 58, 3, NULL, NULL),
(70, 59, 1, NULL, NULL),
(71, 59, 2, NULL, NULL),
(72, 60, 2, NULL, NULL),
(73, 60, 3, NULL, NULL),
(82, 69, 2, NULL, NULL),
(83, 70, 4, NULL, NULL),
(84, 70, 5, NULL, NULL),
(85, 71, 2, NULL, NULL),
(86, 71, 3, NULL, NULL),
(87, 72, 1, NULL, NULL),
(88, 72, 2, NULL, NULL),
(89, 73, 6, NULL, NULL),
(90, 74, 2, NULL, NULL),
(91, 74, 4, NULL, NULL),
(92, 75, 2, NULL, NULL),
(93, 76, 1, NULL, NULL),
(94, 76, 2, NULL, NULL),
(95, 77, 2, NULL, NULL),
(96, 77, 3, NULL, NULL),
(97, 78, 1, NULL, NULL),
(98, 78, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
(5, '2019_08_19_000000_create_failed_jobs_table', 1),
(6, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(7, '2024_05_28_033139_create_services_table', 1),
(8, '2024_05_28_045559_create_permission_tables', 1),
(9, '2024_05_28_154606_create_bookings_table', 1),
(10, '2024_06_03_031418_create_booking_service_table', 1),
(11, '2024_06_06_090314_add_status_to_bookings_table', 1),
(12, '2024_06_07_071456_add_duration_to_services_table', 1),
(13, '2024_06_07_163303_add_total_price_to_bookings_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2),
(2, 'App\\Models\\User', 6),
(3, 'App\\Models\\User', 7),
(3, 'App\\Models\\User', 8),
(3, 'App\\Models\\User', 9);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'manage users', 'web', '2024-06-07 07:19:36', '2024-06-07 07:19:36'),
(2, 'create users', 'web', '2024-06-07 07:19:36', '2024-06-07 07:19:36'),
(3, 'edit users', 'web', '2024-06-07 07:19:36', '2024-06-07 07:19:36'),
(4, 'delete users', 'web', '2024-06-07 07:19:36', '2024-06-07 07:19:36'),
(5, 'assign roles', 'web', '2024-06-07 07:19:36', '2024-06-07 07:19:36'),
(6, 'manage roles', 'web', '2024-06-07 07:19:36', '2024-06-07 07:19:36'),
(7, 'create roles', 'web', '2024-06-07 07:19:36', '2024-06-07 07:19:36'),
(8, 'edit roles', 'web', '2024-06-07 07:19:36', '2024-06-07 07:19:36'),
(9, 'delete roles', 'web', '2024-06-07 07:19:36', '2024-06-07 07:19:36'),
(10, 'manage permissions', 'web', '2024-06-07 07:19:36', '2024-06-07 07:19:36'),
(11, 'assign permissions', 'web', '2024-06-07 07:19:36', '2024-06-07 07:19:36'),
(12, 'view bookings', 'web', '2024-06-07 07:19:36', '2024-06-07 07:19:36'),
(13, 'manage bookings', 'web', '2024-06-07 07:19:36', '2024-06-07 07:19:36'),
(14, 'create services', 'web', '2024-06-07 07:19:36', '2024-06-07 07:19:36'),
(15, 'edit services', 'web', '2024-06-07 07:19:36', '2024-06-07 07:19:36'),
(16, 'delete services', 'web', '2024-06-07 07:19:36', '2024-06-07 07:19:36'),
(17, 'view services', 'web', '2024-06-07 07:19:36', '2024-06-07 07:19:36'),
(18, 'create bookings', 'web', '2024-06-07 07:19:36', '2024-06-07 07:19:36'),
(19, 'edit bookings', 'web', '2024-06-07 07:19:36', '2024-06-07 07:19:36'),
(20, 'cancel bookings', 'web', '2024-06-07 07:19:36', '2024-06-07 07:19:36'),
(21, 'view own bookings', 'web', '2024-06-07 07:19:36', '2024-06-07 07:19:36'),
(22, 'katalog customer', 'web', '2024-06-07 07:20:59', '2024-06-07 07:20:59'),
(23, 'katalog admin', 'web', '2024-06-07 07:21:11', '2024-06-07 07:21:11'),
(24, 'katalog barber', 'web', '2024-06-07 07:21:26', '2024-06-07 07:21:26');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'web', '2024-06-07 07:19:36', '2024-06-07 07:19:36'),
(2, 'Barber', 'web', '2024-06-07 07:19:36', '2024-06-07 07:19:36'),
(3, 'Customer', 'web', '2024-06-07 07:19:36', '2024-06-07 07:19:36');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(23, 1),
(12, 2),
(13, 2),
(14, 2),
(15, 2),
(16, 2),
(17, 2),
(24, 2),
(18, 3),
(19, 3),
(20, 3),
(21, 3),
(22, 3);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(8,2) NOT NULL,
  `duration` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `description`, `price`, `duration`, `created_at`, `updated_at`) VALUES
(1, 'Hair Color', 'Mewarnai rambut sesuai keinginan', '200000.00', 120, '2024-06-07 07:23:43', '2024-06-07 07:23:43'),
(2, 'Haircut Dewasa', 'Potong rambut pria dewasa', '50000.00', 60, '2024-06-07 07:24:08', '2024-06-07 07:24:08'),
(3, 'Haircut Anak-anak', 'Mencukur rambut anak-anak', '35000.00', 60, '2024-06-11 03:08:45', '2024-06-11 03:08:45'),
(4, 'Smoothing', 'Meluruskan rambut', '150000.00', 120, '2024-06-11 22:58:52', '2024-06-11 22:58:52'),
(5, 'Creambath', 'Merawat rambut', '30000.00', 30, '2024-06-11 22:59:41', '2024-06-11 22:59:41'),
(6, 'Cukur Jenggot', 'Cukur jenggot', '15000.00', 5, '2024-06-11 23:00:12', '2024-06-11 23:00:12'),
(7, 'Cukur kumis', 'cukur kumis', '20000.00', 15, '2024-06-12 02:04:48', '2024-06-12 02:04:48');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', NULL, '$2y$10$JDVrCBb7jk0gJf1EJoLtUO6wmlDKa/sRcZQo0Z5uLST5OIRSTSQbG', NULL, NULL, NULL, '2024-06-07 07:19:36', '2024-06-07 07:19:36'),
(2, 'Ujang', 'ujang@gmail.com', NULL, '$2y$10$6oGvYF6pXlO2Tt/bBYEMGeV5sz.ZBt4WRoXCxxK3GMWyDJEcKtRpW', NULL, NULL, NULL, '2024-06-07 07:19:36', '2024-06-07 07:19:36'),
(6, 'Udin', 'udin@gmail.com', NULL, '$2y$10$meK140eE.0uyPmbFysgue.XBZdmDbn/5I4ig9T/yaI.IzidEzzXpS', NULL, NULL, NULL, '2024-06-11 03:33:25', '2024-06-11 03:33:25'),
(7, 'Andi', 'andi@gmail.com', NULL, '$2y$10$wTsRhO6kzPrPZuHsx2AC0OjpIqnKQZ.4QxC8pRKHTeBeIoCZ8nawW', NULL, NULL, NULL, '2024-06-11 03:38:22', '2024-06-11 03:38:22'),
(8, 'Rudi', 'rudi@gmail.com', NULL, '$2y$10$OoEcdnyhvrDDRCbe7j3VcuqxLgoV2fw9p9IOYzQvLhNDOb6CGZjOe', NULL, NULL, NULL, '2024-06-11 03:39:16', '2024-06-11 03:39:16'),
(9, 'Raka Wahyu Pratama', 'rakawahyup62@gmail.com', NULL, '$2y$10$uewZtzo9LvuCN.7.t6dVhOFSHf9qASXRWcCIqPQXfpULE5LrDXzlO', NULL, NULL, NULL, '2024-06-12 01:32:07', '2024-06-12 01:32:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bookings_barber_id_foreign` (`barber_id`);

--
-- Indexes for table `booking_service`
--
ALTER TABLE `booking_service`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_service_booking_id_foreign` (`booking_id`),
  ADD KEY `booking_service_service_id_foreign` (`service_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `booking_service`
--
ALTER TABLE `booking_service`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_barber_id_foreign` FOREIGN KEY (`barber_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `booking_service`
--
ALTER TABLE `booking_service`
  ADD CONSTRAINT `booking_service_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `booking_service_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
--
-- Database: `db_e-learning`
--
CREATE DATABASE IF NOT EXISTS `db_e-learning` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `db_e-learning`;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int NOT NULL,
  `country_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `iso` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `user_id`, `country_code`, `iso`, `phone`, `created_at`, `updated_at`) VALUES
(1, 1, 'bd', '880', NULL, '2024-06-25 19:06:21', '2024-06-25 19:06:21');

-- --------------------------------------------------------

--
-- Table structure for table `answer_banks`
--

CREATE TABLE `answer_banks` (
  `id` int UNSIGNED NOT NULL,
  `question_type` tinyint NOT NULL,
  `teacher_course_id` int NOT NULL,
  `question_answer_body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `answer_banks`
--

INSERT INTO `answer_banks` (`id`, `question_type`, `teacher_course_id`, `question_answer_body`, `created_at`, `updated_at`) VALUES
(1, 0, 1, '{\"passing_score\":\"60\",\"answer_file_id\":\"1\",\"exam_submission_id\":\"1\",\"id\":[\"16\",\"15\"],\"lesson_id\":[\"1\",\"1\"],\"part_number\":[\"FILE - 2\",\"FILE - 2\"],\"question\":[\"ada berapa jenis bahasa program\",\"Apa itu algoritma?\"],\"description\":[\"mmnnmmm\",null],\"default_mark\":[\"2\",\"2\"],\"answer\":[\"awokwok\",\"gatau\"],\"given_mark\":[\"2\",\"2\"]}', '2024-06-25 20:01:45', '2024-06-25 20:37:07'),
(2, 1, 1, '{\"passing_score\":\"50\",\"id\":[\"2\",\"3\"],\"lesson_id\":[\"1\",\"1\"],\"part_number\":[\"File - 1\",\"File - 1\"],\"question\":[\"Postfix expression is just a reverse of prefix expression.\",\"Which one of the below is not divide and conquer approach?\"],\"option_1\":[\"True\",\"Insertion Sort\"],\"option_2\":[\"False\",\"Merge Sort\"],\"option_3\":[null,\"Shell Sort\"],\"option_4\":[null,\"Heap Sort\"],\"right_answer\":[\"2\",\"2\"],\"description\":[null,null],\"default_mark\":[\"2\",\"2\"],\"answer_for_question_0\":\"1\",\"answer_for_question_1\":\"2\"}', '2024-06-26 00:15:37', '2024-06-26 00:15:37'),
(3, 1, 1, '{\"passing_score\":\"50\",\"id\":[\"2\",\"3\"],\"lesson_id\":[\"1\",\"1\"],\"part_number\":[\"File - 1\",\"File - 1\"],\"question\":[\"Postfix expression is just a reverse of prefix expression.\",\"Which one of the below is not divide and conquer approach?\"],\"option_1\":[\"True\",\"Insertion Sort\"],\"option_2\":[\"False\",\"Merge Sort\"],\"option_3\":[null,\"Shell Sort\"],\"option_4\":[null,\"Heap Sort\"],\"right_answer\":[\"2\",\"2\"],\"description\":[null,null],\"default_mark\":[\"2\",\"2\"],\"answer_for_question_0\":\"1\",\"answer_for_question_1\":\"1\"}', '2024-06-26 00:54:10', '2024-06-26 00:54:10'),
(4, 0, 1, '{\"passing_score\":\"50\",\"answer_file_id\":\"4\",\"exam_submission_id\":\"4\",\"id\":[\"3\",\"2\"],\"lesson_id\":[\"1\",\"1\"],\"part_number\":[\"File - 1\",\"File - 1\"],\"question\":[\"How to find if two given rectangles overlap?\",\"Can Binary Search be used for linked lists?\"],\"description\":[null,null],\"default_mark\":[\"2\",\"2\"],\"answer\":[\"GATAU\",\"MALES PENGEN BELI TRUK\"],\"given_mark\":[\"2\",\"1\"]}', '2024-06-26 01:33:26', '2024-06-26 01:40:33'),
(6, 0, 1, '{\"passing_score\":\"50\",\"answer_file_id\":\"6\",\"exam_submission_id\":\"6\",\"id\":[\"2\",\"3\"],\"lesson_id\":[\"1\",\"1\"],\"part_number\":[\"File - 1\",\"File - 1\"],\"question\":[\"Can Binary Search be used for linked lists?\",\"How to find if two given rectangles overlap?\"],\"description\":[null,null],\"default_mark\":[\"2\",\"2\"],\"answer\":[\"123\",\"456\"],\"given_mark\":[\"2\",\"1\"]}', '2024-07-01 04:54:37', '2024-07-01 04:55:12'),
(7, 1, 1, '{\"passing_score\":\"50\",\"id\":[\"2\",\"3\"],\"lesson_id\":[\"1\",\"1\"],\"part_number\":[\"File - 1\",\"File - 1\"],\"question\":[\"Postfix expression is just a reverse of prefix expression.\",\"Which one of the below is not divide and conquer approach?\"],\"option_1\":[\"True\",\"Insertion Sort\"],\"option_2\":[\"False\",\"Merge Sort\"],\"option_3\":[null,\"Shell Sort\"],\"option_4\":[null,\"Heap Sort\"],\"right_answer\":[\"2\",\"2\"],\"description\":[null,null],\"default_mark\":[\"2\",\"2\"],\"answer_for_question_0\":\"2\",\"answer_for_question_1\":\"1\"}', '2024-07-01 04:57:00', '2024-07-01 04:57:00'),
(11, 1, 1, '{\"passing_score\":\"70\",\"id\":[\"2\",\"3\"],\"lesson_id\":[\"1\",\"1\"],\"part_number\":[\"File - 1\",\"File - 1\"],\"question\":[\"Postfix expression is just a reverse of prefix expression.\",\"Which one of the below is not divide and conquer approach?\"],\"option_1\":[\"True\",\"Insertion Sort\"],\"option_2\":[\"False\",\"Merge Sort\"],\"option_3\":[null,\"Shell Sort\"],\"option_4\":[null,\"Heap Sort\"],\"right_answer\":[\"2\",\"2\"],\"description\":[null,null],\"default_mark\":[\"2\",\"2\"],\"answer_for_question_0\":\"2\",\"answer_for_question_1\":\"2\"}', '2024-07-01 05:00:43', '2024-07-01 05:00:43');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel_cache_admin@gmail.com|127.0.0.1', 'i:1;', 1719461157),
('laravel_cache_admin@gmail.com|127.0.0.1:timer', 'i:1719461157;', 1719461157);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int UNSIGNED NOT NULL,
  `department_id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `featured_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'admin/images/course.jpg',
  `short_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `featured_text` text COLLATE utf8mb4_unicode_ci,
  `default_cost` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `department_id`, `title`, `featured_image`, `short_code`, `featured_text`, `default_cost`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'ARCH 100 Architectural Foundations I', '/admin/images/courses/course_1.jpg', 'ARCH 100', 'An introductory design studio directed toward the development of spatial thinking and the skills necessary for the analysis and design of architectural space and form. This course is based on a series of exercises that include direct observation: drawing, analysis and representation of the surrounding world, and full-scale studies in the making of objects and the representation of object and space. Students are introduced to different descriptive and analytical media and techniques of representation to aid in the development of critical thought. These include freehand drawing, orthographic projection, paraline drawing, basic computer skills, and basic materials investigation. Prerequisite: Approval from the Dean of the School of Architecture and Urban Planning. LAB.', NULL, 1, '2024-06-25 19:06:23', '2024-06-25 19:06:23'),
(2, 1, 'ARCH 104 Principles of Modern Architecture', '/admin/images/courses/course_2.jpg', 'ARCH 104', 'A lecture course covering the emergence of technological, theoretical and aesthetic principles of modern design beginning with the socio-cultural impact of industrialization and the crisis in architecture at the end of the 19th century. Attention is given to functionalist theory, mechanical analogies and the so-called machine aesthetic of 1910-1930 and to the precedents of important design principles of modern architecture, including modular coordination, the open plan, interlocking universal space, unadorned geometry, structural integrity, programmatic and tectonic expression, efficiency and transparency and briefly explores their development in post-war and late 20th century examples. LEC.', NULL, 1, '2024-06-25 19:06:23', '2024-06-25 19:06:23'),
(3, 3, 'Discrete Mathematics', '/admin/images/courses/course_3.jpg', 'MATH1061', 'Propositional & predicate logic, valid arguments, methods of proof. Elementary set theory. Elementary graph theory. Relations & functions. Induction & recursive definitions. Counting methods (pigeonhole, inclusion/exclusion). Introductory probability. Binary operations, groups, fields. Applications of finite fields. Elementary number theory.', NULL, 1, '2024-06-25 19:06:23', '2024-06-25 19:06:23'),
(4, 3, 'Introduction to Software Engineering', '/admin/images/courses/course_4.jpg', 'CSSE1001', 'Introduction to Software Engineering through programming with particular focus on the fundamentals of computing & programming, using an exploratory problem-based approach. Building abstractions with procedures, data & objects; data modelling; designing, coding & debugging programs of increasing complexity', NULL, 1, '2024-06-25 19:06:23', '2024-06-25 19:06:23'),
(5, 3, 'Algorithms & Data Structures', '/admin/images/courses/course_5.jpg', 'COMP3506', 'Data structures & types, mapping of abstract information structures into representations on primary & secondary storage. Analysis of time & space complexity of algorithms. Sequences. Lists. Stacks. Queues. Sets, multisets, tables. Trees. Sorting. Hash tables. Priority queues. Graphs. String algorithms.', NULL, 1, '2024-06-25 19:06:23', '2024-06-25 19:06:23'),
(6, 3, 'Programming in the Large', '/admin/images/courses/course_6.jpg', 'CSSE2002', 'This course covers techniques that scale to programming large software systems with teams of programmers. The techniques are explained in the context of the specification, implementation, testing and maintenance of software systems. The course utilises the Java programming language and covers programming concepts such as data abstraction, procedural abstraction, unit testing, class hierarchies and polymorphism, exception handling, file I/O, and graphical user interfaces.', NULL, 1, '2024-06-25 19:06:23', '2024-06-25 19:06:23');

-- --------------------------------------------------------

--
-- Table structure for table `course_student`
--

CREATE TABLE `course_student` (
  `id` int UNSIGNED NOT NULL,
  `student_id` int NOT NULL,
  `teacher_course_id` int NOT NULL,
  `status` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `course_student`
--

INSERT INTO `course_student` (`id`, `student_id`, `teacher_course_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 4, 4, 0, '2024-06-25 19:20:27', '2024-06-25 19:20:27'),
(2, 4, 1, 0, '2024-06-25 19:59:39', '2024-06-25 19:59:39');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `title`, `short_code`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Department of Architecture', 'ARC', 1, '2024-06-25 19:06:23', '2024-06-25 19:06:23'),
(2, 'Department of History of Art', 'HOA', 1, '2024-06-25 19:06:23', '2024-06-25 19:06:23'),
(3, 'Computer Science', 'CL', 1, '2024-06-25 19:06:23', '2024-06-25 19:06:23'),
(4, 'Civil engineering', 'CE', 1, '2024-06-25 19:06:23', '2024-06-25 19:06:23');

-- --------------------------------------------------------

--
-- Table structure for table `exams`
--

CREATE TABLE `exams` (
  `id` int UNSIGNED NOT NULL,
  `exam_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `course_id` int NOT NULL,
  `teacher_id` int NOT NULL,
  `question_file_id` int NOT NULL,
  `syllabus` text COLLATE utf8mb4_unicode_ci,
  `passing_score` double NOT NULL,
  `duration` time DEFAULT NULL,
  `status` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exams`
--

INSERT INTO `exams` (`id`, `exam_title`, `course_id`, `teacher_id`, `question_file_id`, `syllabus`, `passing_score`, `duration`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Ujian algoritma', 5, 2, 4, 'memmememmememme', 60, '00:00:30', 2, '2024-06-25 19:58:17', '2024-06-26 00:08:58'),
(7, 'cccc', 5, 2, 3, 'ccc', 50, '00:15:00', 2, '2024-06-30 20:16:02', '2024-06-30 20:26:53'),
(8, 'gatau', 5, 2, 2, 'ya gitu weh', 50, '00:15:00', 2, '2024-07-01 04:56:18', '2024-07-01 04:57:00'),
(9, 'tae', 5, 2, 2, 'gatau', 70, '00:20:00', 2, '2024-07-01 04:59:21', '2024-07-01 04:59:45');

-- --------------------------------------------------------

--
-- Table structure for table `exam_submissions`
--

CREATE TABLE `exam_submissions` (
  `id` int UNSIGNED NOT NULL,
  `exam_id` int NOT NULL,
  `student_id` int NOT NULL,
  `answer_file_id` int NOT NULL,
  `total_mark` double NOT NULL DEFAULT '0',
  `achieve_mark` double NOT NULL DEFAULT '0',
  `passed_score` double NOT NULL DEFAULT '0',
  `result_status` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exam_submissions`
--

INSERT INTO `exam_submissions` (`id`, `exam_id`, `student_id`, `answer_file_id`, `total_mark`, `achieve_mark`, `passed_score`, `result_status`, `created_at`, `updated_at`) VALUES
(1, 2, 4, 1, 4, 4, 100, 1, '2024-06-25 20:01:45', '2024-06-25 20:37:07'),
(2, 3, 4, 2, 4, 2, 50, 1, '2024-06-26 00:15:37', '2024-06-26 00:15:37'),
(3, 4, 4, 3, 4, 0, 0, 2, '2024-06-26 00:54:10', '2024-06-26 00:54:10'),
(4, 5, 4, 4, 4, 3, 75, 1, '2024-06-26 01:33:26', '2024-06-26 01:40:33'),
(6, 7, 4, 6, 4, 3, 75, 1, '2024-07-01 04:54:37', '2024-07-01 04:55:12'),
(7, 8, 4, 7, 4, 2, 50, 1, '2024-07-01 04:57:00', '2024-07-01 04:57:00'),
(11, 9, 4, 11, 4, 4, 100, 1, '2024-07-01 05:00:43', '2024-07-01 05:00:43');

-- --------------------------------------------------------

--
-- Table structure for table `lesson_files`
--

CREATE TABLE `lesson_files` (
  `id` int UNSIGNED NOT NULL,
  `lesson_id` int NOT NULL,
  `teacher_id` int NOT NULL,
  `part_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `file_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lesson_files`
--

INSERT INTO `lesson_files` (`id`, `lesson_id`, `teacher_id`, `part_number`, `file_title`, `description`, `file_url`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'File - 1', 'Asymptotic Growth of Functions', NULL, 'https://classes.soe.ucsc.edu/cmps102/Spring04/TantaloAsymp.pdf', '2024-06-25 19:06:23', '2024-06-25 19:06:23'),
(2, 2, 2, 'File - 2', 'Algorithms: analysis, complexity', NULL, 'https://ocw.mit.edu/courses/civil-and-environmental-engineering/1-204-computer-algorithms-in-systems-engineering-spring-2010/lecture-notes/MIT1_204S10_lec05.pdf', '2024-06-25 19:06:23', '2024-06-25 19:06:23'),
(3, 3, 2, 'File - 3', 'comparing various functions to analyse time complexity', NULL, 'https://www.cs.duke.edu/courses/summer10/cps130/files/L2-Analysis.pdf', '2024-06-25 19:06:23', '2024-06-25 19:06:23'),
(4, 4, 2, 'File - 1', 'C Programming Introduction', NULL, 'https://www.tutorialspoint.com/cprogramming/cprogramming_tutorial.pdf', '2024-06-25 19:06:23', '2024-06-25 19:06:23'),
(5, 4, 2, 'File - 2', 'C Programming Setting Up Code Blocks', NULL, 'http://www.codeblocks.org/docs/manual_en.pdf', '2024-06-25 19:06:23', '2024-06-25 19:06:23'),
(6, 5, 2, 'File - 3', 'C Programming How Computer Programs Work', NULL, 'https://www.tutorialspoint.com/computer_programming/computer_programming_tutorial.pdf', '2024-06-25 19:06:23', '2024-06-25 19:06:23'),
(7, 1, 2, 'FILE - 2', 'algoritma', 'pembelajaran algoritma', 'https://bakrie.ac.id/articles/628-ini-dia-pengertian-algoritma-beserta-karakteristiknya.html', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lesson_videos`
--

CREATE TABLE `lesson_videos` (
  `id` int UNSIGNED NOT NULL,
  `lesson_id` int NOT NULL,
  `teacher_id` int NOT NULL,
  `part_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `video_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `video_embed_url` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lesson_videos`
--

INSERT INTO `lesson_videos` (`id`, `lesson_id`, `teacher_id`, `part_number`, `video_title`, `description`, `video_embed_url`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'Video - 1', 'Algorithms Lecture 1 -- Introduction to asymptotic notations', NULL, 'https://www.youtube.com/embed/aGjL7YXI31Q', '2024-06-25 19:06:23', '2024-06-25 19:06:23'),
(2, 2, 2, 'Video - 2', 'Algorithms lecture 2 -- Time complexity Analysis of iterative programs', NULL, 'https://www.youtube.com/embed/FEnwM-iDb2g', '2024-06-25 19:06:23', '2024-06-25 19:06:23'),
(3, 3, 2, 'Video - 3', 'Algorithms lecture 4 -- comparing various functions to analyse time complexity', NULL, 'https://www.youtube.com/embed/aORkZXcjlIs', '2024-06-25 19:06:23', '2024-06-25 19:06:23'),
(4, 4, 2, 'Video - 1', 'C Programming Tutorial - 1 - Introduction', NULL, 'https://www.youtube.com/embed/2NWeucMKrLI', '2024-06-25 19:06:23', '2024-06-25 19:06:23'),
(5, 4, 2, 'Video - 2', 'C Programming Tutorial - 2 - Setting Up Code Blocks', NULL, 'https://www.youtube.com/embed/3DeLiClDd04', '2024-06-25 19:06:23', '2024-06-25 19:06:23'),
(6, 5, 2, 'Video - 3', 'C Programming Tutorial - 3 - How Computer Programs Work', NULL, 'https://www.youtube.com/embed/iWx3yyFMWQA', '2024-06-25 19:06:23', '2024-06-25 19:06:23'),
(7, 1, 2, 'VIDEO - 2', 'algortima', 'dasar-dasar algoritma', 'https://www.youtu.com/embed/uqVJc9lLknA', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mcqs`
--

CREATE TABLE `mcqs` (
  `id` int UNSIGNED NOT NULL,
  `lesson_id` int NOT NULL,
  `part_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `question` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_1` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_2` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_3` text COLLATE utf8mb4_unicode_ci,
  `option_4` text COLLATE utf8mb4_unicode_ci,
  `right_answer` tinyint NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `default_mark` double NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mcqs`
--

INSERT INTO `mcqs` (`id`, `lesson_id`, `part_number`, `question`, `option_1`, `option_2`, `option_3`, `option_4`, `right_answer`, `description`, `default_mark`, `created_at`, `updated_at`) VALUES
(1, 1, 'Video - 1', 'Which one of the below is not divide and conquer approach?', 'Insertion Sort', 'Merge Sort', 'Shell Sort', 'Heap Sort', 2, NULL, 2, '2024-06-25 19:06:23', '2024-06-25 19:06:23'),
(2, 1, 'File - 1', 'Postfix expression is just a reverse of prefix expression.', 'True', 'False', NULL, NULL, 2, NULL, 2, '2024-06-25 19:06:23', '2024-06-25 19:06:23'),
(3, 1, 'File - 1', 'Which one of the below is not divide and conquer approach?', 'Insertion Sort', 'Merge Sort', 'Shell Sort', 'Heap Sort', 2, NULL, 2, '2024-06-25 19:06:23', '2024-06-25 19:06:23'),
(4, 1, 'Video - 1', 'After each iteration in bubble sort', 'at least one element is at its sorted position.', 'one less comparison is made in the next iteration.', 'Both A & B are true.', 'Neither A or B are true.', 1, NULL, 2, '2024-06-25 19:06:23', '2024-06-25 19:06:23'),
(5, 1, 'Video - 1', 'Which of the below mentioned sorting algorithms are not stable?', 'Selection Sort', 'Bubble Sort', 'Merge Sort', 'Insertion Sort', 1, NULL, 2, '2024-06-25 19:06:23', '2024-06-25 19:06:23'),
(6, 4, 'Video - 1', 'Who is father of C Language?', 'Bjarne Stroustrup', 'James A. Gosling', 'Dennis Ritchie', 'Dr. E.F. Codd', 3, NULL, 2, '2024-06-25 19:06:23', '2024-06-25 19:06:23'),
(7, 4, 'Video - 1', 'C Language developed at _________?', 'AT & T\'s Bell Laboratories of USA in 1972', 'AT & T\'s Bell Laboratories of USA in 1970', 'Sun Microsystems in 1973', 'Cambridge University in 1972', 1, NULL, 2, '2024-06-25 19:06:23', '2024-06-25 19:06:23'),
(8, 4, 'Video - 1', 'For 16-bit compiler allowable range for integer constants is ________?', '-3.4e38 to 3.4e38', '-32767 to 32768', '-32668 to 32667', '-32768 to 32767', 4, NULL, 2, '2024-06-25 19:06:23', '2024-06-25 19:06:23'),
(9, 4, 'File - 1', 'C programs are converted into machine language with the help of', 'An Editor', 'A compiler', 'An operating system', 'None of these.', 2, NULL, 2, '2024-06-25 19:06:23', '2024-06-25 19:06:23'),
(10, 4, 'File - 1', 'C was primarily developed as', 'System programming language', 'General purpose language', 'Data processing language', 'None of the above.', 1, NULL, 2, '2024-06-25 19:06:23', '2024-06-25 19:06:23'),
(11, 4, 'File - 1', 'Standard ANSI C recognizes ______ number of keywords?', '30', '32', '24', '36', 2, NULL, 2, '2024-06-25 19:06:23', '2024-06-25 19:06:23'),
(12, 4, 'File - 1', 'Which one of the following is not a reserved keyword for C?', 'auto', 'case', 'main', 'default', 3, NULL, 2, '2024-06-25 19:06:23', '2024-06-25 19:06:23'),
(13, 4, 'File - 1', 'A C variable cannot start with', 'A number', 'A special symbol other than underscore', 'Both of the above', 'An alphabet', 3, NULL, 2, '2024-06-25 19:06:23', '2024-06-25 19:06:23'),
(14, 4, 'File - 1', 'Which one of the following is not a valid identifier?', '_examveda', '1examveda', 'exam_veda', 'examveda1', 2, NULL, 2, '2024-06-25 19:06:23', '2024-06-25 19:06:23');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2017_08_09_141756_create_teachers_table', 1),
(4, '2017_08_09_141927_create_settings_table', 1),
(5, '2017_08_09_144248_create_students_table', 1),
(6, '2017_08_09_152450_create_admins_table', 1),
(7, '2017_08_12_052713_create_departments_table', 1),
(8, '2017_08_12_054915_create_courses_table', 1),
(9, '2017_08_12_150729_create_teacher_courses_table', 1),
(10, '2017_08_12_154030_create_teacher_course_lessons_table', 1),
(11, '2017_08_13_153909_create_lesson_files_table', 1),
(12, '2017_08_13_154111_create_lesson_videos_table', 1),
(13, '2017_08_14_121756_create_questions_table', 1),
(14, '2017_08_14_122238_create_mcqs_table', 1),
(15, '2017_08_18_051124_create_question_banks_table', 1),
(16, '2017_08_19_052324_create_exams_table', 1),
(17, '2017_08_26_070246_create_trending_courses_table', 1),
(18, '2017_08_26_075344_create_course_student_table', 1),
(19, '2017_09_08_131141_create_exam_submissions_table', 1),
(20, '2017_09_08_134217_create_answer_banks_table', 1),
(21, '2017_09_23_025105_create_teacher_reviews_table', 1),
(22, '2017_09_23_045836_create_user_activities_table', 1),
(23, '2017_10_01_124643_create_user_signatures_table', 1),
(24, '2017_10_01_145120_create_student_certificates_table', 1),
(25, '2024_04_14_044809_create_sessions_table', 1),
(26, '2024_04_14_044859_create_cache_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int UNSIGNED NOT NULL,
  `lesson_id` int NOT NULL,
  `part_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `question` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `default_mark` double NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `lesson_id`, `part_number`, `question`, `description`, `default_mark`, `created_at`, `updated_at`) VALUES
(1, 1, 'Video - 1', 'What is time complexity of Binary Search?', NULL, 2, '2024-06-25 19:06:23', '2024-06-25 19:06:23'),
(2, 1, 'File - 1', 'Can Binary Search be used for linked lists?', NULL, 2, '2024-06-25 19:06:23', '2024-06-25 19:06:23'),
(3, 1, 'File - 1', 'How to find if two given rectangles overlap?', NULL, 2, '2024-06-25 19:06:23', '2024-06-25 19:06:23'),
(4, 1, 'Video - 1', 'How to find angle between hour and minute hands at a given time?', NULL, 2, '2024-06-25 19:06:23', '2024-06-25 19:06:23'),
(5, 1, 'Video - 1', 'When does the worst case of QuickSort occur?', NULL, 2, '2024-06-25 19:06:23', '2024-06-25 19:06:23'),
(6, 4, 'Video - 1', 'What is a pointer on pointer?', NULL, 2, '2024-06-25 19:06:23', '2024-06-25 19:06:23'),
(7, 4, 'Video - 1', 'Distinguish between malloc() & calloc() memory allocation.', NULL, 2, '2024-06-25 19:06:23', '2024-06-25 19:06:23'),
(8, 4, 'Video - 1', 'What is keyword auto for?', NULL, 2, '2024-06-25 19:06:23', '2024-06-25 19:06:23'),
(9, 4, 'File - 1', 'What are the valid places for the keyword break to appear.', NULL, 2, '2024-06-25 19:06:23', '2024-06-25 19:06:23'),
(10, 4, 'File - 1', 'Explain the syntax for for loop.', NULL, 2, '2024-06-25 19:06:23', '2024-06-25 19:06:23'),
(11, 4, 'File - 1', 'What is difference between including the header file with-in angular braces < > and double quotes “ “', NULL, 2, '2024-06-25 19:06:23', '2024-06-25 19:06:23'),
(12, 4, 'File - 1', 'How a negative integer is stored.', NULL, 2, '2024-06-25 19:06:23', '2024-06-25 19:06:23'),
(13, 4, 'File - 1', 'What is a static variable?', NULL, 2, '2024-06-25 19:06:23', '2024-06-25 19:06:23'),
(14, 4, 'File - 1', 'What is a NULL pointer?', NULL, 2, '2024-06-25 19:06:23', '2024-06-25 19:06:23'),
(15, 1, 'FILE - 2', 'Apa itu algoritma?', NULL, 2, NULL, NULL),
(16, 1, 'FILE - 2', 'ada berapa jenis bahasa program', 'mmnnmmm', 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `question_banks`
--

CREATE TABLE `question_banks` (
  `id` int UNSIGNED NOT NULL,
  `question_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `question_type` tinyint NOT NULL,
  `course_id` int NOT NULL,
  `teacher_id` int NOT NULL,
  `question_body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `question_banks`
--

INSERT INTO `question_banks` (`id`, `question_title`, `question_type`, `course_id`, `teacher_id`, `question_body`, `created_at`, `updated_at`) VALUES
(1, 'how to', 0, 5, 2, '[{\"id\":3,\"lesson_id\":1,\"part_number\":\"File - 1\",\"question\":\"How to find if two given rectangles overlap?\",\"description\":null,\"default_mark\":2,\"created_at\":\"2024-06-26 02:06:23\",\"updated_at\":\"2024-06-26 02:06:23\"},{\"id\":2,\"lesson_id\":1,\"part_number\":\"File - 1\",\"question\":\"Can Binary Search be used for linked lists?\",\"description\":null,\"default_mark\":2,\"created_at\":\"2024-06-26 02:06:23\",\"updated_at\":\"2024-06-26 02:06:23\"}]', '2024-06-25 19:38:03', '2024-06-25 19:38:03'),
(2, 'mcq question', 1, 5, 2, '[{\"id\":2,\"lesson_id\":1,\"part_number\":\"File - 1\",\"question\":\"Postfix expression is just a reverse of prefix expression.\",\"option_1\":\"True\",\"option_2\":\"False\",\"option_3\":null,\"option_4\":null,\"right_answer\":2,\"description\":null,\"default_mark\":2,\"created_at\":\"2024-06-26 02:06:23\",\"updated_at\":\"2024-06-26 02:06:23\"},{\"id\":3,\"lesson_id\":1,\"part_number\":\"File - 1\",\"question\":\"Which one of the below is not divide and conquer approach?\",\"option_1\":\"Insertion Sort\",\"option_2\":\"Merge Sort\",\"option_3\":\"Shell Sort\",\"option_4\":\"Heap Sort\",\"right_answer\":2,\"description\":null,\"default_mark\":2,\"created_at\":\"2024-06-26 02:06:23\",\"updated_at\":\"2024-06-26 02:06:23\"}]', '2024-06-25 19:39:17', '2024-06-25 19:39:17'),
(3, 'sl', 0, 5, 2, '[{\"id\":2,\"lesson_id\":1,\"part_number\":\"File - 1\",\"question\":\"Can Binary Search be used for linked lists?\",\"description\":null,\"default_mark\":2,\"created_at\":\"2024-06-26 02:06:23\",\"updated_at\":\"2024-06-26 02:06:23\"},{\"id\":3,\"lesson_id\":1,\"part_number\":\"File - 1\",\"question\":\"How to find if two given rectangles overlap?\",\"description\":null,\"default_mark\":2,\"created_at\":\"2024-06-26 02:06:23\",\"updated_at\":\"2024-06-26 02:06:23\"}]', '2024-06-25 19:40:39', '2024-06-25 19:40:39'),
(4, 'quiz algoritma', 0, 5, 2, '[{\"id\":16,\"lesson_id\":1,\"part_number\":\"FILE - 2\",\"question\":\"ada berapa jenis bahasa program\",\"description\":\"mmnnmmm\",\"default_mark\":2,\"created_at\":null,\"updated_at\":null},{\"id\":15,\"lesson_id\":1,\"part_number\":\"FILE - 2\",\"question\":\"Apa itu algoritma?\",\"description\":null,\"default_mark\":2,\"created_at\":null,\"updated_at\":null}]', '2024-06-25 19:56:10', '2024-06-25 19:56:10');

-- --------------------------------------------------------

--
-- Table structure for table `remedial_requests`
--

CREATE TABLE `remedial_requests` (
  `id` bigint UNSIGNED NOT NULL,
  `exam_id` bigint UNSIGNED NOT NULL,
  `student_id` bigint UNSIGNED NOT NULL,
  `status` enum('PENDING','APPROVED','REJECTED') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PENDING',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `remedial_requests`
--

INSERT INTO `remedial_requests` (`id`, `exam_id`, `student_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 4, 4, 'APPROVED', '2024-06-26 20:28:43', '2024-06-26 20:36:32');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int NOT NULL,
  `country_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `iso` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `user_id`, `country_code`, `iso`, `phone`, `created_at`, `updated_at`) VALUES
(1, 4, 'bd', '880', 1686407947, '2024-06-25 19:06:22', '2024-06-25 19:06:22'),
(2, 5, 'bd', '880', 1686407947, '2024-06-25 19:06:23', '2024-06-25 19:06:23');

-- --------------------------------------------------------

--
-- Table structure for table `student_certificates`
--

CREATE TABLE `student_certificates` (
  `id` int UNSIGNED NOT NULL,
  `student_id` int NOT NULL,
  `teacher_course_id` int NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int NOT NULL,
  `country_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `iso` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `user_id`, `country_code`, `iso`, `phone`, `created_at`, `updated_at`) VALUES
(1, 2, '+62', 'id', 812083773, '2024-06-25 19:06:21', '2024-06-25 19:06:21'),
(2, 3, 'bd', '880', 1686407947, '2024-06-25 19:06:22', '2024-06-25 19:06:22');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_courses`
--

CREATE TABLE `teacher_courses` (
  `id` int UNSIGNED NOT NULL,
  `course_id` int NOT NULL,
  `teacher_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teacher_courses`
--

INSERT INTO `teacher_courses` (`id`, `course_id`, `teacher_id`, `created_at`, `updated_at`) VALUES
(1, 5, 2, '2024-06-25 19:06:23', '2024-06-25 19:06:23'),
(2, 6, 2, '2024-06-25 19:06:23', '2024-06-25 19:06:23'),
(3, 3, 2, '2024-06-25 19:06:23', '2024-06-25 19:06:23'),
(4, 5, 3, '2024-06-25 19:06:23', '2024-06-25 19:06:23'),
(5, 4, 2, '2024-06-25 19:48:46', '2024-06-25 19:48:46');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_course_lessons`
--

CREATE TABLE `teacher_course_lessons` (
  `id` int UNSIGNED NOT NULL,
  `course_id` int NOT NULL,
  `teacher_id` int NOT NULL,
  `number` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `tags` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teacher_course_lessons`
--

INSERT INTO `teacher_course_lessons` (`id`, `course_id`, `teacher_id`, `number`, `title`, `description`, `tags`, `created_at`, `updated_at`) VALUES
(1, 5, 2, 1, 'asymptotic notations', NULL, NULL, '2024-06-25 19:06:23', '2024-06-25 19:06:23'),
(2, 5, 2, 2, 'Time complexity Analysis of iterative programs', NULL, NULL, '2024-06-25 19:06:23', '2024-06-25 19:06:23'),
(3, 5, 2, 3, 'comparing various functions to analyse time complexity', NULL, NULL, '2024-06-25 19:06:23', '2024-06-25 19:06:23'),
(4, 6, 2, 1, 'C Introduction', NULL, NULL, '2024-06-25 19:06:23', '2024-06-25 19:06:23'),
(5, 6, 2, 2, 'How Computer Programs Work', NULL, NULL, '2024-06-25 19:06:23', '2024-06-25 19:06:23'),
(6, 5, 3, 1, 'Lesson one', NULL, NULL, '2024-06-25 19:06:23', '2024-06-25 19:06:23'),
(7, 5, 3, 2, 'Lesson two', NULL, NULL, '2024-06-25 19:06:23', '2024-06-25 19:06:23'),
(8, 5, 2, 4, 'algoritma dasar', NULL, NULL, '2024-06-25 19:50:52', '2024-06-25 19:50:52');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_reviews`
--

CREATE TABLE `teacher_reviews` (
  `id` int UNSIGNED NOT NULL,
  `student_id` int NOT NULL,
  `teacher_id` int NOT NULL,
  `point` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trending_courses`
--

CREATE TABLE `trending_courses` (
  `id` int UNSIGNED NOT NULL,
  `teacher_course_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trending_courses`
--

INSERT INTO `trending_courses` (`id`, `teacher_course_id`, `created_at`, `updated_at`) VALUES
(1, 2, '2024-06-25 19:06:23', '2024-06-25 19:06:23'),
(2, 3, '2024-06-25 19:06:23', '2024-06-25 19:06:23'),
(3, 4, '2024-06-25 19:06:23', '2024-06-25 19:06:23');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `picture` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'admin/images/user.jpg',
  `user_type` tinyint NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `picture`, `user_type`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@mail.com', '$2y$12$5xg2hhuU.qUbqmLAF/7Yre2JwTSKHnrAQguYxUNxNrdmeJKkXt2GO', 'admin/images/user.jpg', 2, NULL, '2024-06-25 19:06:21', '2024-06-25 19:06:21'),
(2, 'teacher', 'teacher@mail.com', '$2y$12$nbPSWpArV2ZJHpFpqCLDV.RblSRdnfrcaHO6O4xLyC.cRhgCGrEeq', '/admin/images/profile_pics/teacher/profile_picture_user_2.png', 1, NULL, '2024-06-25 19:06:21', '2024-06-25 19:06:21'),
(3, 'Teacher 2', 'teacher2@mail.com', '$2y$12$pMzRLdYuJFOG/CPw/6YlL.UGFWhCfOzGt7QHwED2u26NkeNvcU0by', 'admin/images/user.jpg', 1, NULL, '2024-06-25 19:06:22', '2024-06-25 19:06:22'),
(4, 'Student', 'student@mail.com', '$2y$12$amGbE1SdkWFRxeJsBVbxd.Qdy86qFNXZy5hXsF19KxZ7qemt2x0p.', 'admin/images/user.jpg', 0, NULL, '2024-06-25 19:06:22', '2024-06-25 19:06:22'),
(5, 'Student 2', 'student2@mail.com', '$2y$12$gX9MYKIMy0hvIFwn5E/B2elLOk10n5dzOACo9ZEs9FGGfRI4h91iW', 'admin/images/user.jpg', 0, NULL, '2024-06-25 19:06:23', '2024-06-25 19:06:23');

-- --------------------------------------------------------

--
-- Table structure for table `user_activities`
--

CREATE TABLE `user_activities` (
  `id` int UNSIGNED NOT NULL,
  `total_teacher_login` int NOT NULL DEFAULT '0',
  `total_student_login` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_signatures`
--

CREATE TABLE `user_signatures` (
  `id` int UNSIGNED NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int NOT NULL,
  `status` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_signatures`
--

INSERT INTO `user_signatures` (`id`, `file_path`, `user_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'admin/images/signatures/user_2.png', 2, 1, '2024-06-25 19:18:24', '2024-06-25 19:18:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `answer_banks`
--
ALTER TABLE `answer_banks`
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
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `courses_title_unique` (`title`),
  ADD UNIQUE KEY `courses_short_code_unique` (`short_code`);

--
-- Indexes for table `course_student`
--
ALTER TABLE `course_student`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `course_student_student_id_teacher_course_id_unique` (`student_id`,`teacher_course_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `departments_title_unique` (`title`),
  ADD UNIQUE KEY `departments_short_code_unique` (`short_code`);

--
-- Indexes for table `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam_submissions`
--
ALTER TABLE `exam_submissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `exam_submissions_student_id_exam_id_unique` (`student_id`,`exam_id`);

--
-- Indexes for table `lesson_files`
--
ALTER TABLE `lesson_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lesson_videos`
--
ALTER TABLE `lesson_videos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mcqs`
--
ALTER TABLE `mcqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `question_banks`
--
ALTER TABLE `question_banks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `remedial_requests`
--
ALTER TABLE `remedial_requests`
  ADD PRIMARY KEY (`id`);

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
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_certificates`
--
ALTER TABLE `student_certificates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teacher_courses`
--
ALTER TABLE `teacher_courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teacher_course_lessons`
--
ALTER TABLE `teacher_course_lessons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teacher_reviews`
--
ALTER TABLE `teacher_reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trending_courses`
--
ALTER TABLE `trending_courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `trending_courses_teacher_course_id_unique` (`teacher_course_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_activities`
--
ALTER TABLE `user_activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_signatures`
--
ALTER TABLE `user_signatures`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `answer_banks`
--
ALTER TABLE `answer_banks`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `course_student`
--
ALTER TABLE `course_student`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `exams`
--
ALTER TABLE `exams`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `exam_submissions`
--
ALTER TABLE `exam_submissions`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `lesson_files`
--
ALTER TABLE `lesson_files`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `lesson_videos`
--
ALTER TABLE `lesson_videos`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `mcqs`
--
ALTER TABLE `mcqs`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `question_banks`
--
ALTER TABLE `question_banks`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `remedial_requests`
--
ALTER TABLE `remedial_requests`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `student_certificates`
--
ALTER TABLE `student_certificates`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `teacher_courses`
--
ALTER TABLE `teacher_courses`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `teacher_course_lessons`
--
ALTER TABLE `teacher_course_lessons`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `teacher_reviews`
--
ALTER TABLE `teacher_reviews`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trending_courses`
--
ALTER TABLE `trending_courses`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_activities`
--
ALTER TABLE `user_activities`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_signatures`
--
ALTER TABLE `user_signatures`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Database: `db_ticketing`
--
CREATE DATABASE IF NOT EXISTS `db_ticketing` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `db_ticketing`;

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  `attribute` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `old_value` text COLLATE utf8mb4_unicode_ci,
  `new_value` text COLLATE utf8mb4_unicode_ci,
  `reason` text COLLATE utf8mb4_unicode_ci,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `category_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `color`, `created_at`, `updated_at`) VALUES
(1, 'Wifi Rusak', '#ff0000', '2024-08-05 01:57:43', '2024-08-05 01:57:43'),
(2, 'Internet Lemot', '#ff0000', '2024-08-05 01:57:43', '2024-08-05 01:57:43'),
(3, 'PC Blue Screen', '#ff0000', '2024-08-05 01:57:43', '2024-08-05 01:57:43');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint UNSIGNED NOT NULL,
  `ticket_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint UNSIGNED NOT NULL,
  `department_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lokasi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `history_tickets`
--

CREATE TABLE `history_tickets` (
  `id` bigint UNSIGNED NOT NULL,
  `h_no_ticket` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `h_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `h_customer` bigint UNSIGNED NOT NULL,
  `h_assign_to` bigint UNSIGNED DEFAULT NULL,
  `h_priority_id` bigint UNSIGNED DEFAULT NULL,
  `h_status_id` bigint UNSIGNED DEFAULT NULL,
  `h_category_id` bigint UNSIGNED NOT NULL,
  `h_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `h_solution` text COLLATE utf8mb4_unicode_ci,
  `h_attachments` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_changedBy` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `incidental_activities`
--

CREATE TABLE `incidental_activities` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `start_time` date NOT NULL,
  `end_time` date NOT NULL,
  `executor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mitigation` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `impact` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_id` bigint UNSIGNED DEFAULT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `incidental_activities`
--

INSERT INTO `incidental_activities` (`id`, `title`, `description`, `category_id`, `start_time`, `end_time`, `executor`, `department`, `mitigation`, `impact`, `status_id`, `file_path`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'restore vm', 'restore vm', 2, '2024-08-05', '2024-08-06', 'Marwoto', 'dba', 'cocote', 'teuing', 1, NULL, 4, '2024-08-05 02:15:32', '2024-08-05 02:15:32');

-- --------------------------------------------------------

--
-- Table structure for table `incidental_activity_categories`
--

CREATE TABLE `incidental_activity_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `category_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `incidental_activity_categories`
--

INSERT INTO `incidental_activity_categories` (`id`, `category_name`, `color`, `created_at`, `updated_at`) VALUES
(1, 'Maintenance', '#ff0000', '2024-08-05 02:13:33', '2024-08-05 02:13:33'),
(2, 'Restore', '#0040ff', '2024-08-05 02:13:48', '2024-08-05 02:13:48');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_06_23_054107_create_priorities_table', 1),
(6, '2024_06_23_064046_create_statuses_table', 1),
(7, '2024_06_23_064117_create_departments_table', 1),
(8, '2024_06_23_065249_create_categories_table', 1),
(9, '2024_06_23_071152_create_permission_tables', 1),
(10, '2024_06_25_143731_create_activity_logs_table', 1),
(11, '2024_06_29_054738_create_tickets_table', 1),
(12, '2024_07_04_072944_create_request_assignments_table', 1),
(13, '2024_07_09_034359_create_notifications_table', 1),
(14, '2024_07_26_071102_create_comments_table', 1),
(15, '2024_07_31_035152_create_incidental_activities_table', 1),
(16, '2024_08_01_063454_create_history_tickets_table', 1),
(17, '2024_08_05_074322_create_incidental_activity_categories_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2),
(2, 'App\\Models\\User', 3),
(3, 'App\\Models\\User', 4),
(3, 'App\\Models\\User', 5);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'View Dashboard Admin', 'web', '2024-08-05 01:57:41', '2024-08-05 01:57:41'),
(2, 'View Dashboard Customer', 'web', '2024-08-05 01:57:41', '2024-08-05 01:57:41'),
(3, 'View Dashboard Department', 'web', '2024-08-05 01:57:41', '2024-08-05 01:57:41'),
(4, 'View User Management', 'web', '2024-08-05 01:57:41', '2024-08-05 01:57:41'),
(5, 'Create User', 'web', '2024-08-05 01:57:41', '2024-08-05 01:57:41'),
(6, 'Edit User', 'web', '2024-08-05 01:57:41', '2024-08-05 01:57:41'),
(7, 'Delete User', 'web', '2024-08-05 01:57:41', '2024-08-05 01:57:41'),
(8, 'Show User', 'web', '2024-08-05 01:57:41', '2024-08-05 01:57:41'),
(9, 'Create Role', 'web', '2024-08-05 01:57:41', '2024-08-05 01:57:41'),
(10, 'Edit Role', 'web', '2024-08-05 01:57:41', '2024-08-05 01:57:41'),
(11, 'Delete Role', 'web', '2024-08-05 01:57:41', '2024-08-05 01:57:41'),
(12, 'Show Role', 'web', '2024-08-05 01:57:41', '2024-08-05 01:57:41'),
(13, 'Create Permission', 'web', '2024-08-05 01:57:41', '2024-08-05 01:57:41'),
(14, 'Edit Permission', 'web', '2024-08-05 01:57:41', '2024-08-05 01:57:41'),
(15, 'Delete Permission', 'web', '2024-08-05 01:57:41', '2024-08-05 01:57:41'),
(16, 'Show Permission', 'web', '2024-08-05 01:57:41', '2024-08-05 01:57:41'),
(17, 'View Category', 'web', '2024-08-05 01:57:41', '2024-08-05 01:57:41'),
(18, 'Create Category', 'web', '2024-08-05 01:57:41', '2024-08-05 01:57:41'),
(19, 'Edit Category', 'web', '2024-08-05 01:57:41', '2024-08-05 01:57:41'),
(20, 'Delete Category', 'web', '2024-08-05 01:57:41', '2024-08-05 01:57:41'),
(21, 'Show Category', 'web', '2024-08-05 01:57:41', '2024-08-05 01:57:41'),
(22, 'View Priority', 'web', '2024-08-05 01:57:41', '2024-08-05 01:57:41'),
(23, 'Create Priority', 'web', '2024-08-05 01:57:41', '2024-08-05 01:57:41'),
(24, 'Edit Priority', 'web', '2024-08-05 01:57:41', '2024-08-05 01:57:41'),
(25, 'Delete Priority', 'web', '2024-08-05 01:57:41', '2024-08-05 01:57:41'),
(26, 'Show Priority', 'web', '2024-08-05 01:57:41', '2024-08-05 01:57:41'),
(27, 'View Status', 'web', '2024-08-05 01:57:41', '2024-08-05 01:57:41'),
(28, 'Create Status', 'web', '2024-08-05 01:57:41', '2024-08-05 01:57:41'),
(29, 'Edit Status', 'web', '2024-08-05 01:57:41', '2024-08-05 01:57:41'),
(30, 'Delete Status', 'web', '2024-08-05 01:57:41', '2024-08-05 01:57:41'),
(31, 'Show Status', 'web', '2024-08-05 01:57:41', '2024-08-05 01:57:41'),
(32, 'View Ticket', 'web', '2024-08-05 01:57:41', '2024-08-05 01:57:41'),
(33, 'Create Ticket', 'web', '2024-08-05 01:57:41', '2024-08-05 01:57:41'),
(34, 'Edit Ticket', 'web', '2024-08-05 01:57:41', '2024-08-05 01:57:41'),
(35, 'Delete Ticket', 'web', '2024-08-05 01:57:41', '2024-08-05 01:57:41'),
(36, 'Show Ticket', 'web', '2024-08-05 01:57:41', '2024-08-05 01:57:41');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `priorities`
--

CREATE TABLE `priorities` (
  `id` bigint UNSIGNED NOT NULL,
  `priority_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `priorities`
--

INSERT INTO `priorities` (`id`, `priority_name`, `color`, `created_at`, `updated_at`) VALUES
(1, 'Low', '#ff0000', '2024-08-05 01:57:43', '2024-08-05 01:57:43'),
(2, 'High', '#ff0000', '2024-08-05 01:57:43', '2024-08-05 01:57:43'),
(3, 'Medium', '#ff0000', '2024-08-05 01:57:43', '2024-08-05 01:57:43'),
(4, 'Critical', '#ff0000', '2024-08-05 01:57:43', '2024-08-05 01:57:43');

-- --------------------------------------------------------

--
-- Table structure for table `request_assignments`
--

CREATE TABLE `request_assignments` (
  `id` bigint UNSIGNED NOT NULL,
  `ticket_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `status_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'web', '2024-08-05 01:57:41', '2024-08-05 01:57:41'),
(2, 'Customer', 'web', '2024-08-05 01:57:41', '2024-08-05 01:57:41'),
(3, 'Tenaga Ahli', 'web', '2024-08-05 01:57:41', '2024-08-05 01:57:41');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(2, 2),
(32, 2),
(33, 2),
(34, 2),
(35, 2),
(36, 2),
(3, 3),
(17, 3),
(18, 3),
(19, 3),
(20, 3),
(21, 3),
(22, 3),
(23, 3),
(24, 3),
(25, 3),
(26, 3),
(27, 3),
(28, 3),
(29, 3),
(30, 3),
(31, 3),
(32, 3),
(33, 3),
(34, 3),
(35, 3),
(36, 3);

-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

CREATE TABLE `statuses` (
  `id` bigint UNSIGNED NOT NULL,
  `status_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `statuses`
--

INSERT INTO `statuses` (`id`, `status_name`, `color`, `created_at`, `updated_at`) VALUES
(1, 'Tertunda', '#ff0000', '2024-08-05 01:57:43', '2024-08-05 01:57:43'),
(2, 'Diterima', '#ff0000', '2024-08-05 01:57:43', '2024-08-05 01:57:43'),
(3, 'Proses', '#ff0000', '2024-08-05 01:57:43', '2024-08-05 01:57:43'),
(4, 'Selesai', '#ff0000', '2024-08-05 01:57:43', '2024-08-05 01:57:43');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` bigint UNSIGNED NOT NULL,
  `no_ticket` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer` bigint UNSIGNED NOT NULL,
  `assign_to` bigint UNSIGNED DEFAULT NULL,
  `priority_id` bigint UNSIGNED DEFAULT NULL,
  `due_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_id` bigint UNSIGNED DEFAULT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `solution` text COLLATE utf8mb4_unicode_ci,
  `attachments` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_changed_by_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `gender`, `photo`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', NULL, NULL, 'Admin@gmail.com', '2024-08-05 01:57:43', '$2y$10$Ci0rjMA4AgTbVx.UITuw/.Wvuf8W2SER8Guhzi30pdLxHH7sZlQ4e', 'obMs6MCdQ8', '2024-08-05 01:57:43', '2024-08-05 01:57:43'),
(2, 'Customer1', NULL, NULL, 'Customer1@gmail.com', '2024-08-05 01:57:43', '$2y$10$itGl99Bmeof7ASQ0WAaNJeDHsI2q2/A/GyDM8RyyvqxUqjOC64Iua', 'pVMWIBVA46', '2024-08-05 01:57:43', '2024-08-05 01:57:43'),
(3, 'Customer2', NULL, NULL, 'Customer2@gmail.com', '2024-08-05 01:57:43', '$2y$10$Guoufj5CFBlQR88mhyAf/.3GUbYeNXTewjs4hbLsHUUMFkA4rkMOy', 'oIOk4hWApT', '2024-08-05 01:57:43', '2024-08-05 01:57:43'),
(4, 'SysAdmin', NULL, NULL, 'sysadmin@gmail.com', '2024-08-05 01:57:43', '$2y$10$ckCjy3/3ZUqc9cXY5dFnGOF6ZPjowhDvJEaXMfNnmUuqyd1z1ZqCG', '3iiPtoMyz1zFY02dcIjqcOTU8YkJ2me3JY1TXGtWJD206n8EWOsALa6aJTEY', '2024-08-05 01:57:43', '2024-08-05 01:57:43'),
(5, 'DBA', NULL, NULL, 'dba@gmail.com', '2024-08-05 01:57:43', '$2y$10$xtedGBNe7MpNNyIhK00ZluiFN3IeyerPmXyg8/zDksLAiUfvswprS', 'FHVvsEL6Zm', '2024-08-05 01:57:43', '2024-08-05 01:57:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_ticket_id_foreign` (`ticket_id`),
  ADD KEY `comments_user_id_foreign` (`user_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `history_tickets`
--
ALTER TABLE `history_tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `history_tickets_h_customer_foreign` (`h_customer`),
  ADD KEY `history_tickets_h_assign_to_foreign` (`h_assign_to`),
  ADD KEY `history_tickets_h_priority_id_foreign` (`h_priority_id`),
  ADD KEY `history_tickets_h_status_id_foreign` (`h_status_id`),
  ADD KEY `history_tickets_h_category_id_foreign` (`h_category_id`),
  ADD KEY `history_tickets_status_changedby_foreign` (`status_changedBy`);

--
-- Indexes for table `incidental_activities`
--
ALTER TABLE `incidental_activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `incidental_activities_category_id_foreign` (`category_id`),
  ADD KEY `incidental_activities_status_id_foreign` (`status_id`),
  ADD KEY `incidental_activities_user_id_foreign` (`user_id`);

--
-- Indexes for table `incidental_activity_categories`
--
ALTER TABLE `incidental_activity_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

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
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `priorities`
--
ALTER TABLE `priorities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `request_assignments`
--
ALTER TABLE `request_assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `request_assignments_ticket_id_foreign` (`ticket_id`),
  ADD KEY `request_assignments_user_id_foreign` (`user_id`),
  ADD KEY `request_assignments_status_id_foreign` (`status_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tickets_customer_foreign` (`customer`),
  ADD KEY `tickets_assign_to_foreign` (`assign_to`),
  ADD KEY `tickets_priority_id_foreign` (`priority_id`),
  ADD KEY `tickets_status_id_foreign` (`status_id`),
  ADD KEY `tickets_category_id_foreign` (`category_id`),
  ADD KEY `tickets_status_changed_by_id_foreign` (`status_changed_by_id`);

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
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `history_tickets`
--
ALTER TABLE `history_tickets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `incidental_activities`
--
ALTER TABLE `incidental_activities`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `incidental_activity_categories`
--
ALTER TABLE `incidental_activity_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `priorities`
--
ALTER TABLE `priorities`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `request_assignments`
--
ALTER TABLE `request_assignments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `history_tickets`
--
ALTER TABLE `history_tickets`
  ADD CONSTRAINT `history_tickets_h_assign_to_foreign` FOREIGN KEY (`h_assign_to`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `history_tickets_h_category_id_foreign` FOREIGN KEY (`h_category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `history_tickets_h_customer_foreign` FOREIGN KEY (`h_customer`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `history_tickets_h_priority_id_foreign` FOREIGN KEY (`h_priority_id`) REFERENCES `priorities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `history_tickets_h_status_id_foreign` FOREIGN KEY (`h_status_id`) REFERENCES `statuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `history_tickets_status_changedby_foreign` FOREIGN KEY (`status_changedBy`) REFERENCES `users` (`id`);

--
-- Constraints for table `incidental_activities`
--
ALTER TABLE `incidental_activities`
  ADD CONSTRAINT `incidental_activities_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `incidental_activities_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `incidental_activities_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `request_assignments`
--
ALTER TABLE `request_assignments`
  ADD CONSTRAINT `request_assignments_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `request_assignments_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `request_assignments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_assign_to_foreign` FOREIGN KEY (`assign_to`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `tickets_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tickets_customer_foreign` FOREIGN KEY (`customer`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tickets_priority_id_foreign` FOREIGN KEY (`priority_id`) REFERENCES `priorities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tickets_status_changed_by_id_foreign` FOREIGN KEY (`status_changed_by_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `tickets_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`) ON DELETE CASCADE;
--
-- Database: `e_learning`
--
CREATE DATABASE IF NOT EXISTS `e_learning` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `e_learning`;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int NOT NULL,
  `country_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `iso` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `user_id`, `country_code`, `iso`, `phone`, `created_at`, `updated_at`) VALUES
(1, 1, 'bd', '880', NULL, '2024-06-25 03:02:33', '2024-06-25 03:02:33');

-- --------------------------------------------------------

--
-- Table structure for table `answer_banks`
--

CREATE TABLE `answer_banks` (
  `id` int UNSIGNED NOT NULL,
  `question_type` tinyint NOT NULL,
  `teacher_course_id` int NOT NULL,
  `question_answer_body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel_cache_admin@gmail.com|127.0.0.1', 'i:1;', 1719309857),
('laravel_cache_admin@gmail.com|127.0.0.1:timer', 'i:1719309857;', 1719309857);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int UNSIGNED NOT NULL,
  `department_id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `featured_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'admin/images/course.jpg',
  `short_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `featured_text` text COLLATE utf8mb4_unicode_ci,
  `default_cost` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `department_id`, `title`, `featured_image`, `short_code`, `featured_text`, `default_cost`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'ARCH 100 Architectural Foundations I', '/admin/images/courses/course_1.jpg', 'ARCH 100', 'An introductory design studio directed toward the development of spatial thinking and the skills necessary for the analysis and design of architectural space and form. This course is based on a series of exercises that include direct observation: drawing, analysis and representation of the surrounding world, and full-scale studies in the making of objects and the representation of object and space. Students are introduced to different descriptive and analytical media and techniques of representation to aid in the development of critical thought. These include freehand drawing, orthographic projection, paraline drawing, basic computer skills, and basic materials investigation. Prerequisite: Approval from the Dean of the School of Architecture and Urban Planning. LAB.', NULL, 1, '2024-06-25 03:02:35', '2024-06-25 03:02:35'),
(2, 1, 'ARCH 104 Principles of Modern Architecture', '/admin/images/courses/course_2.jpg', 'ARCH 104', 'A lecture course covering the emergence of technological, theoretical and aesthetic principles of modern design beginning with the socio-cultural impact of industrialization and the crisis in architecture at the end of the 19th century. Attention is given to functionalist theory, mechanical analogies and the so-called machine aesthetic of 1910-1930 and to the precedents of important design principles of modern architecture, including modular coordination, the open plan, interlocking universal space, unadorned geometry, structural integrity, programmatic and tectonic expression, efficiency and transparency and briefly explores their development in post-war and late 20th century examples. LEC.', NULL, 1, '2024-06-25 03:02:35', '2024-06-25 03:02:35'),
(3, 3, 'Discrete Mathematics', '/admin/images/courses/course_3.jpg', 'MATH1061', 'Propositional & predicate logic, valid arguments, methods of proof. Elementary set theory. Elementary graph theory. Relations & functions. Induction & recursive definitions. Counting methods (pigeonhole, inclusion/exclusion). Introductory probability. Binary operations, groups, fields. Applications of finite fields. Elementary number theory.', NULL, 1, '2024-06-25 03:02:35', '2024-06-25 03:02:35'),
(4, 3, 'Introduction to Software Engineering', '/admin/images/courses/course_4.jpg', 'CSSE1001', 'Introduction to Software Engineering through programming with particular focus on the fundamentals of computing & programming, using an exploratory problem-based approach. Building abstractions with procedures, data & objects; data modelling; designing, coding & debugging programs of increasing complexity', NULL, 1, '2024-06-25 03:02:35', '2024-06-25 03:02:35'),
(5, 3, 'Algorithms & Data Structures', '/admin/images/courses/course_5.jpg', 'COMP3506', 'Data structures & types, mapping of abstract information structures into representations on primary & secondary storage. Analysis of time & space complexity of algorithms. Sequences. Lists. Stacks. Queues. Sets, multisets, tables. Trees. Sorting. Hash tables. Priority queues. Graphs. String algorithms.', NULL, 1, '2024-06-25 03:02:35', '2024-06-25 03:02:35'),
(6, 3, 'Programming in the Large', '/admin/images/courses/course_6.jpg', 'CSSE2002', 'This course covers techniques that scale to programming large software systems with teams of programmers. The techniques are explained in the context of the specification, implementation, testing and maintenance of software systems. The course utilises the Java programming language and covers programming concepts such as data abstraction, procedural abstraction, unit testing, class hierarchies and polymorphism, exception handling, file I/O, and graphical user interfaces.', NULL, 1, '2024-06-25 03:02:35', '2024-06-25 03:02:35');

-- --------------------------------------------------------

--
-- Table structure for table `course_student`
--

CREATE TABLE `course_student` (
  `id` int UNSIGNED NOT NULL,
  `student_id` int NOT NULL,
  `teacher_course_id` int NOT NULL,
  `status` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `title`, `short_code`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Department of Architecture', 'ARC', 1, '2024-06-25 03:02:35', '2024-06-25 03:02:35'),
(2, 'Department of History of Art', 'HOA', 1, '2024-06-25 03:02:35', '2024-06-25 03:02:35'),
(3, 'Computer Science', 'CL', 1, '2024-06-25 03:02:35', '2024-06-25 03:02:35'),
(4, 'Civil engineering', 'CE', 1, '2024-06-25 03:02:35', '2024-06-25 03:02:35');

-- --------------------------------------------------------

--
-- Table structure for table `exams`
--

CREATE TABLE `exams` (
  `id` int UNSIGNED NOT NULL,
  `exam_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `course_id` int NOT NULL,
  `teacher_id` int NOT NULL,
  `question_file_id` int NOT NULL,
  `syllabus` text COLLATE utf8mb4_unicode_ci,
  `passing_score` double NOT NULL,
  `duration` time DEFAULT NULL,
  `status` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exam_submissions`
--

CREATE TABLE `exam_submissions` (
  `id` int UNSIGNED NOT NULL,
  `exam_id` int NOT NULL,
  `student_id` int NOT NULL,
  `answer_file_id` int NOT NULL,
  `total_mark` double NOT NULL DEFAULT '0',
  `achieve_mark` double NOT NULL DEFAULT '0',
  `passed_score` double NOT NULL DEFAULT '0',
  `result_status` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lesson_files`
--

CREATE TABLE `lesson_files` (
  `id` int UNSIGNED NOT NULL,
  `lesson_id` int NOT NULL,
  `teacher_id` int NOT NULL,
  `part_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `file_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lesson_files`
--

INSERT INTO `lesson_files` (`id`, `lesson_id`, `teacher_id`, `part_number`, `file_title`, `description`, `file_url`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'File - 1', 'Asymptotic Growth of Functions', NULL, 'https://classes.soe.ucsc.edu/cmps102/Spring04/TantaloAsymp.pdf', '2024-06-25 03:02:35', '2024-06-25 03:02:35'),
(2, 2, 2, 'File - 2', 'Algorithms: analysis, complexity', NULL, 'https://ocw.mit.edu/courses/civil-and-environmental-engineering/1-204-computer-algorithms-in-systems-engineering-spring-2010/lecture-notes/MIT1_204S10_lec05.pdf', '2024-06-25 03:02:35', '2024-06-25 03:02:35'),
(3, 3, 2, 'File - 3', 'comparing various functions to analyse time complexity', NULL, 'https://www.cs.duke.edu/courses/summer10/cps130/files/L2-Analysis.pdf', '2024-06-25 03:02:35', '2024-06-25 03:02:35'),
(4, 4, 2, 'File - 1', 'C Programming Introduction', NULL, 'https://www.tutorialspoint.com/cprogramming/cprogramming_tutorial.pdf', '2024-06-25 03:02:35', '2024-06-25 03:02:35'),
(5, 4, 2, 'File - 2', 'C Programming Setting Up Code Blocks', NULL, 'http://www.codeblocks.org/docs/manual_en.pdf', '2024-06-25 03:02:35', '2024-06-25 03:02:35'),
(6, 5, 2, 'File - 3', 'C Programming How Computer Programs Work', NULL, 'https://www.tutorialspoint.com/computer_programming/computer_programming_tutorial.pdf', '2024-06-25 03:02:35', '2024-06-25 03:02:35');

-- --------------------------------------------------------

--
-- Table structure for table `lesson_videos`
--

CREATE TABLE `lesson_videos` (
  `id` int UNSIGNED NOT NULL,
  `lesson_id` int NOT NULL,
  `teacher_id` int NOT NULL,
  `part_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `video_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `video_embed_url` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lesson_videos`
--

INSERT INTO `lesson_videos` (`id`, `lesson_id`, `teacher_id`, `part_number`, `video_title`, `description`, `video_embed_url`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'Video - 1', 'Algorithms Lecture 1 -- Introduction to asymptotic notations', NULL, 'https://www.youtube.com/embed/aGjL7YXI31Q', '2024-06-25 03:02:35', '2024-06-25 03:02:35'),
(2, 2, 2, 'Video - 2', 'Algorithms lecture 2 -- Time complexity Analysis of iterative programs', NULL, 'https://www.youtube.com/embed/FEnwM-iDb2g', '2024-06-25 03:02:35', '2024-06-25 03:02:35'),
(3, 3, 2, 'Video - 3', 'Algorithms lecture 4 -- comparing various functions to analyse time complexity', NULL, 'https://www.youtube.com/embed/aORkZXcjlIs', '2024-06-25 03:02:35', '2024-06-25 03:02:35'),
(4, 4, 2, 'Video - 1', 'C Programming Tutorial - 1 - Introduction', NULL, 'https://www.youtube.com/embed/2NWeucMKrLI', '2024-06-25 03:02:35', '2024-06-25 03:02:35'),
(5, 4, 2, 'Video - 2', 'C Programming Tutorial - 2 - Setting Up Code Blocks', NULL, 'https://www.youtube.com/embed/3DeLiClDd04', '2024-06-25 03:02:35', '2024-06-25 03:02:35'),
(6, 5, 2, 'Video - 3', 'C Programming Tutorial - 3 - How Computer Programs Work', NULL, 'https://www.youtube.com/embed/iWx3yyFMWQA', '2024-06-25 03:02:35', '2024-06-25 03:02:35');

-- --------------------------------------------------------

--
-- Table structure for table `mcqs`
--

CREATE TABLE `mcqs` (
  `id` int UNSIGNED NOT NULL,
  `lesson_id` int NOT NULL,
  `part_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `question` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_1` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_2` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_3` text COLLATE utf8mb4_unicode_ci,
  `option_4` text COLLATE utf8mb4_unicode_ci,
  `right_answer` tinyint NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `default_mark` double NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mcqs`
--

INSERT INTO `mcqs` (`id`, `lesson_id`, `part_number`, `question`, `option_1`, `option_2`, `option_3`, `option_4`, `right_answer`, `description`, `default_mark`, `created_at`, `updated_at`) VALUES
(1, 1, 'Video - 1', 'Which one of the below is not divide and conquer approach?', 'Insertion Sort', 'Merge Sort', 'Shell Sort', 'Heap Sort', 2, NULL, 2, '2024-06-25 03:02:35', '2024-06-25 03:02:35'),
(2, 1, 'File - 1', 'Postfix expression is just a reverse of prefix expression.', 'True', 'False', NULL, NULL, 2, NULL, 2, '2024-06-25 03:02:35', '2024-06-25 03:02:35'),
(3, 1, 'File - 1', 'Which one of the below is not divide and conquer approach?', 'Insertion Sort', 'Merge Sort', 'Shell Sort', 'Heap Sort', 2, NULL, 2, '2024-06-25 03:02:35', '2024-06-25 03:02:35'),
(4, 1, 'Video - 1', 'After each iteration in bubble sort', 'at least one element is at its sorted position.', 'one less comparison is made in the next iteration.', 'Both A & B are true.', 'Neither A or B are true.', 1, NULL, 2, '2024-06-25 03:02:35', '2024-06-25 03:02:35'),
(5, 1, 'Video - 1', 'Which of the below mentioned sorting algorithms are not stable?', 'Selection Sort', 'Bubble Sort', 'Merge Sort', 'Insertion Sort', 1, NULL, 2, '2024-06-25 03:02:35', '2024-06-25 03:02:35'),
(6, 4, 'Video - 1', 'Who is father of C Language?', 'Bjarne Stroustrup', 'James A. Gosling', 'Dennis Ritchie', 'Dr. E.F. Codd', 3, NULL, 2, '2024-06-25 03:02:35', '2024-06-25 03:02:35'),
(7, 4, 'Video - 1', 'C Language developed at _________?', 'AT & T\'s Bell Laboratories of USA in 1972', 'AT & T\'s Bell Laboratories of USA in 1970', 'Sun Microsystems in 1973', 'Cambridge University in 1972', 1, NULL, 2, '2024-06-25 03:02:35', '2024-06-25 03:02:35'),
(8, 4, 'Video - 1', 'For 16-bit compiler allowable range for integer constants is ________?', '-3.4e38 to 3.4e38', '-32767 to 32768', '-32668 to 32667', '-32768 to 32767', 4, NULL, 2, '2024-06-25 03:02:35', '2024-06-25 03:02:35'),
(9, 4, 'File - 1', 'C programs are converted into machine language with the help of', 'An Editor', 'A compiler', 'An operating system', 'None of these.', 2, NULL, 2, '2024-06-25 03:02:35', '2024-06-25 03:02:35'),
(10, 4, 'File - 1', 'C was primarily developed as', 'System programming language', 'General purpose language', 'Data processing language', 'None of the above.', 1, NULL, 2, '2024-06-25 03:02:35', '2024-06-25 03:02:35'),
(11, 4, 'File - 1', 'Standard ANSI C recognizes ______ number of keywords?', '30', '32', '24', '36', 2, NULL, 2, '2024-06-25 03:02:35', '2024-06-25 03:02:35'),
(12, 4, 'File - 1', 'Which one of the following is not a reserved keyword for C?', 'auto', 'case', 'main', 'default', 3, NULL, 2, '2024-06-25 03:02:35', '2024-06-25 03:02:35'),
(13, 4, 'File - 1', 'A C variable cannot start with', 'A number', 'A special symbol other than underscore', 'Both of the above', 'An alphabet', 3, NULL, 2, '2024-06-25 03:02:35', '2024-06-25 03:02:35'),
(14, 4, 'File - 1', 'Which one of the following is not a valid identifier?', '_examveda', '1examveda', 'exam_veda', 'examveda1', 2, NULL, 2, '2024-06-25 03:02:35', '2024-06-25 03:02:35');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2017_08_09_141756_create_teachers_table', 1),
(4, '2017_08_09_141927_create_settings_table', 1),
(5, '2017_08_09_144248_create_students_table', 1),
(6, '2017_08_09_152450_create_admins_table', 1),
(7, '2017_08_12_052713_create_departments_table', 1),
(8, '2017_08_12_054915_create_courses_table', 1),
(9, '2017_08_12_150729_create_teacher_courses_table', 1),
(10, '2017_08_12_154030_create_teacher_course_lessons_table', 1),
(11, '2017_08_13_153909_create_lesson_files_table', 1),
(12, '2017_08_13_154111_create_lesson_videos_table', 1),
(13, '2017_08_14_121756_create_questions_table', 1),
(14, '2017_08_14_122238_create_mcqs_table', 1),
(15, '2017_08_18_051124_create_question_banks_table', 1),
(16, '2017_08_19_052324_create_exams_table', 1),
(17, '2017_08_26_070246_create_trending_courses_table', 1),
(18, '2017_08_26_075344_create_course_student_table', 1),
(19, '2017_09_08_131141_create_exam_submissions_table', 1),
(20, '2017_09_08_134217_create_answer_banks_table', 1),
(21, '2017_09_23_025105_create_teacher_reviews_table', 1),
(22, '2017_09_23_045836_create_user_activities_table', 1),
(23, '2017_10_01_124643_create_user_signatures_table', 1),
(24, '2017_10_01_145120_create_student_certificates_table', 1),
(25, '2024_04_14_044809_create_sessions_table', 1),
(26, '2024_04_14_044859_create_cache_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int UNSIGNED NOT NULL,
  `lesson_id` int NOT NULL,
  `part_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `question` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `default_mark` double NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `lesson_id`, `part_number`, `question`, `description`, `default_mark`, `created_at`, `updated_at`) VALUES
(1, 1, 'Video - 1', 'What is time complexity of Binary Search?', NULL, 2, '2024-06-25 03:02:35', '2024-06-25 03:02:35'),
(2, 1, 'File - 1', 'Can Binary Search be used for linked lists?', NULL, 2, '2024-06-25 03:02:35', '2024-06-25 03:02:35'),
(3, 1, 'File - 1', 'How to find if two given rectangles overlap?', NULL, 2, '2024-06-25 03:02:35', '2024-06-25 03:02:35'),
(4, 1, 'Video - 1', 'How to find angle between hour and minute hands at a given time?', NULL, 2, '2024-06-25 03:02:35', '2024-06-25 03:02:35'),
(5, 1, 'Video - 1', 'When does the worst case of QuickSort occur?', NULL, 2, '2024-06-25 03:02:35', '2024-06-25 03:02:35'),
(6, 4, 'Video - 1', 'What is a pointer on pointer?', NULL, 2, '2024-06-25 03:02:35', '2024-06-25 03:02:35'),
(7, 4, 'Video - 1', 'Distinguish between malloc() & calloc() memory allocation.', NULL, 2, '2024-06-25 03:02:35', '2024-06-25 03:02:35'),
(8, 4, 'Video - 1', 'What is keyword auto for?', NULL, 2, '2024-06-25 03:02:35', '2024-06-25 03:02:35'),
(9, 4, 'File - 1', 'What are the valid places for the keyword break to appear.', NULL, 2, '2024-06-25 03:02:35', '2024-06-25 03:02:35'),
(10, 4, 'File - 1', 'Explain the syntax for for loop.', NULL, 2, '2024-06-25 03:02:35', '2024-06-25 03:02:35'),
(11, 4, 'File - 1', 'What is difference between including the header file with-in angular braces < > and double quotes “ “', NULL, 2, '2024-06-25 03:02:35', '2024-06-25 03:02:35'),
(12, 4, 'File - 1', 'How a negative integer is stored.', NULL, 2, '2024-06-25 03:02:35', '2024-06-25 03:02:35'),
(13, 4, 'File - 1', 'What is a static variable?', NULL, 2, '2024-06-25 03:02:35', '2024-06-25 03:02:35'),
(14, 4, 'File - 1', 'What is a NULL pointer?', NULL, 2, '2024-06-25 03:02:35', '2024-06-25 03:02:35');

-- --------------------------------------------------------

--
-- Table structure for table `question_banks`
--

CREATE TABLE `question_banks` (
  `id` int UNSIGNED NOT NULL,
  `question_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `question_type` tinyint NOT NULL,
  `course_id` int NOT NULL,
  `teacher_id` int NOT NULL,
  `question_body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int NOT NULL,
  `country_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `iso` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `user_id`, `country_code`, `iso`, `phone`, `created_at`, `updated_at`) VALUES
(1, 4, 'bd', '880', 1686407947, '2024-06-25 03:02:35', '2024-06-25 03:02:35'),
(2, 5, 'bd', '880', 1686407947, '2024-06-25 03:02:35', '2024-06-25 03:02:35');

-- --------------------------------------------------------

--
-- Table structure for table `student_certificates`
--

CREATE TABLE `student_certificates` (
  `id` int UNSIGNED NOT NULL,
  `student_id` int NOT NULL,
  `teacher_course_id` int NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int NOT NULL,
  `country_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `iso` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `user_id`, `country_code`, `iso`, `phone`, `created_at`, `updated_at`) VALUES
(1, 2, 'bd', '880', 1686407947, '2024-06-25 03:02:34', '2024-06-25 03:02:34'),
(2, 3, 'bd', '880', 1686407947, '2024-06-25 03:02:34', '2024-06-25 03:02:34');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_courses`
--

CREATE TABLE `teacher_courses` (
  `id` int UNSIGNED NOT NULL,
  `course_id` int NOT NULL,
  `teacher_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teacher_courses`
--

INSERT INTO `teacher_courses` (`id`, `course_id`, `teacher_id`, `created_at`, `updated_at`) VALUES
(1, 5, 2, '2024-06-25 03:02:35', '2024-06-25 03:02:35'),
(2, 6, 2, '2024-06-25 03:02:35', '2024-06-25 03:02:35'),
(3, 3, 2, '2024-06-25 03:02:35', '2024-06-25 03:02:35'),
(4, 5, 3, '2024-06-25 03:02:35', '2024-06-25 03:02:35');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_course_lessons`
--

CREATE TABLE `teacher_course_lessons` (
  `id` int UNSIGNED NOT NULL,
  `course_id` int NOT NULL,
  `teacher_id` int NOT NULL,
  `number` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `tags` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teacher_course_lessons`
--

INSERT INTO `teacher_course_lessons` (`id`, `course_id`, `teacher_id`, `number`, `title`, `description`, `tags`, `created_at`, `updated_at`) VALUES
(1, 5, 2, 1, 'asymptotic notations', NULL, NULL, '2024-06-25 03:02:35', '2024-06-25 03:02:35'),
(2, 5, 2, 2, 'Time complexity Analysis of iterative programs', NULL, NULL, '2024-06-25 03:02:35', '2024-06-25 03:02:35'),
(3, 5, 2, 3, 'comparing various functions to analyse time complexity', NULL, NULL, '2024-06-25 03:02:35', '2024-06-25 03:02:35'),
(4, 6, 2, 1, 'C Introduction', NULL, NULL, '2024-06-25 03:02:35', '2024-06-25 03:02:35'),
(5, 6, 2, 2, 'How Computer Programs Work', NULL, NULL, '2024-06-25 03:02:35', '2024-06-25 03:02:35'),
(6, 5, 3, 1, 'Lesson one', NULL, NULL, '2024-06-25 03:02:35', '2024-06-25 03:02:35'),
(7, 5, 3, 2, 'Lesson two', NULL, NULL, '2024-06-25 03:02:35', '2024-06-25 03:02:35');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_reviews`
--

CREATE TABLE `teacher_reviews` (
  `id` int UNSIGNED NOT NULL,
  `student_id` int NOT NULL,
  `teacher_id` int NOT NULL,
  `point` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trending_courses`
--

CREATE TABLE `trending_courses` (
  `id` int UNSIGNED NOT NULL,
  `teacher_course_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trending_courses`
--

INSERT INTO `trending_courses` (`id`, `teacher_course_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2024-06-25 03:02:35', '2024-06-25 03:02:35'),
(2, 2, '2024-06-25 03:02:35', '2024-06-25 03:02:35'),
(3, 3, '2024-06-25 03:02:35', '2024-06-25 03:02:35');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `picture` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'admin/images/user.jpg',
  `user_type` tinyint NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `picture`, `user_type`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@mail.com', '$2y$12$JtVlVunMftcXQiV1hVQnae.3IbeYEu0zFClc0bVjI/XFXW4E1foLC', 'admin/images/user.jpg', 2, NULL, '2024-06-25 03:02:33', '2024-06-25 03:02:33'),
(2, 'Teacher', 'teacher@mail.com', '$2y$12$p6jiduhYm4sM5ejIyQux7.dalZjZEHUuFgXCs3vh.rs1fgItcla6O', 'admin/images/user.jpg', 1, NULL, '2024-06-25 03:02:34', '2024-06-25 03:02:34'),
(3, 'Teacher 2', 'teacher2@mail.com', '$2y$12$I4Di89dblNcSkpz9uyyxhOB0vh47E8lrWffuOwPEapEWhxc2GYInW', 'admin/images/user.jpg', 1, NULL, '2024-06-25 03:02:34', '2024-06-25 03:02:34'),
(4, 'Student', 'student@mail.com', '$2y$12$wKGHJ0troMjK9O7Zy.cpUObezAZDk52lRbMK3wBN4gRufkXvZ76Za', 'admin/images/user.jpg', 0, NULL, '2024-06-25 03:02:35', '2024-06-25 03:02:35'),
(5, 'Student 2', 'student2@mail.com', '$2y$12$tBNoeVCRgBD.M8s3HJwOhO11gqIEvmztmYpLFl1a1WsARK8yuCllG', 'admin/images/user.jpg', 0, NULL, '2024-06-25 03:02:35', '2024-06-25 03:02:35');

-- --------------------------------------------------------

--
-- Table structure for table `user_activities`
--

CREATE TABLE `user_activities` (
  `id` int UNSIGNED NOT NULL,
  `total_teacher_login` int NOT NULL DEFAULT '0',
  `total_student_login` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_signatures`
--

CREATE TABLE `user_signatures` (
  `id` int UNSIGNED NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int NOT NULL,
  `status` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `answer_banks`
--
ALTER TABLE `answer_banks`
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
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `courses_title_unique` (`title`),
  ADD UNIQUE KEY `courses_short_code_unique` (`short_code`);

--
-- Indexes for table `course_student`
--
ALTER TABLE `course_student`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `course_student_student_id_teacher_course_id_unique` (`student_id`,`teacher_course_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `departments_title_unique` (`title`),
  ADD UNIQUE KEY `departments_short_code_unique` (`short_code`);

--
-- Indexes for table `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam_submissions`
--
ALTER TABLE `exam_submissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `exam_submissions_student_id_exam_id_unique` (`student_id`,`exam_id`);

--
-- Indexes for table `lesson_files`
--
ALTER TABLE `lesson_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lesson_videos`
--
ALTER TABLE `lesson_videos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mcqs`
--
ALTER TABLE `mcqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `question_banks`
--
ALTER TABLE `question_banks`
  ADD PRIMARY KEY (`id`);

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
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_certificates`
--
ALTER TABLE `student_certificates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teacher_courses`
--
ALTER TABLE `teacher_courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teacher_course_lessons`
--
ALTER TABLE `teacher_course_lessons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teacher_reviews`
--
ALTER TABLE `teacher_reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trending_courses`
--
ALTER TABLE `trending_courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `trending_courses_teacher_course_id_unique` (`teacher_course_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_activities`
--
ALTER TABLE `user_activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_signatures`
--
ALTER TABLE `user_signatures`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `answer_banks`
--
ALTER TABLE `answer_banks`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `course_student`
--
ALTER TABLE `course_student`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `exams`
--
ALTER TABLE `exams`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exam_submissions`
--
ALTER TABLE `exam_submissions`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lesson_files`
--
ALTER TABLE `lesson_files`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `lesson_videos`
--
ALTER TABLE `lesson_videos`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `mcqs`
--
ALTER TABLE `mcqs`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `question_banks`
--
ALTER TABLE `question_banks`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `student_certificates`
--
ALTER TABLE `student_certificates`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `teacher_courses`
--
ALTER TABLE `teacher_courses`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `teacher_course_lessons`
--
ALTER TABLE `teacher_course_lessons`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `teacher_reviews`
--
ALTER TABLE `teacher_reviews`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trending_courses`
--
ALTER TABLE `trending_courses`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_activities`
--
ALTER TABLE `user_activities`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_signatures`
--
ALTER TABLE `user_signatures`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Database: `karyawan`
--
CREATE DATABASE IF NOT EXISTS `karyawan` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `karyawan`;

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE `karyawan` (
  `nip` int NOT NULL,
  `nama_karyawan` varchar(255) NOT NULL,
  `kode_divisi` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`nip`, `nama_karyawan`, `kode_divisi`) VALUES
(1, 'Amir', 'DIV01'),
(2, 'Budi', 'DIV01'),
(3, 'Charlie', 'DIV01');
--
-- Database: `laravel_api`
--
CREATE DATABASE IF NOT EXISTS `laravel_api` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `laravel_api`;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_06_24_064652_create_posts_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint UNSIGNED NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `image`, `title`, `content`, `created_at`, `updated_at`) VALUES
(2, 'G4w22PQWKTTDcAx0rz0IBoFjRxexxV1pHxD79Nov.png', 'google 1', 'ini gambar google ke 1 yang sudah di edit', '2024-06-24 00:36:01', '2024-06-24 00:46:07'),
(7, 'DNaudgkVq5AmPz0wRkFNhgoEucpYSghJyUxCQyg8.png', '12', '21871297', '2024-06-25 08:15:43', '2024-06-25 08:16:05'),
(8, 'VU2062wpQSfsTxkI5JolLOj8pJC3yiSvYNYsqbCe.png', 'Logo', 'ini logo (edit)', '2024-07-17 00:22:29', '2024-07-17 00:23:09'),
(9, 'xwP9XxsyWGIsZt1NBEBT362r0PlelOnlkAbfxOlr.png', 'Logo', 'ini logo', '2024-07-17 00:22:32', '2024-07-17 00:22:32'),
(10, 'KkrP5N72UkjQeZ6Uqy9qUXyu7lTtsckOOkB4XncT.png', 'Logo', 'ini logo', '2024-07-17 00:22:32', '2024-07-17 00:22:32'),
(11, 'yQYosoVOlE625qY2cvPHIJlUPnDFiNgOdfAzp7V8.png', 'Logo', 'ini logo', '2024-07-17 00:22:33', '2024-07-17 00:22:33'),
(12, 'PfQQl1gFbeKe0NqHg03VGqW3dudTW4JYx7G9SmaF.png', 'Logo', 'ini logo', '2024-07-17 00:22:34', '2024-07-17 00:22:34');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Database: `latihan`
--
CREATE DATABASE IF NOT EXISTS `latihan` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `latihan`;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_05_20_113246_add_colomn_image_to_users_table', 2),
(6, '2024_05_22_093129_create_permission_tables', 3);

-- --------------------------------------------------------

--
-- Table structure for table `mobils`
--

CREATE TABLE `mobils` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `type_mobil` varchar(50) DEFAULT NULL,
  `tahun_pembelian` varchar(5) DEFAULT NULL,
  `harga_mobil` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 6);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(3, 'view_dashboard', 'web', '2024-05-22 02:59:07', '2024-05-22 02:59:07'),
(4, 'view_chart_on_dashboard', 'web', '2024-05-22 03:08:33', '2024-05-22 03:08:33');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2024-05-22 02:45:32', '2024-05-22 02:45:32'),
(2, 'writer', 'web', '2024-05-22 02:45:32', '2024-05-22 02:45:32'),
(3, 'guest', 'web', '2024-05-22 02:50:35', '2024-05-22 02:50:35');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(3, 1),
(4, 1),
(4, 2);

-- --------------------------------------------------------

--
-- Table structure for table `rumahs`
--

CREATE TABLE `rumahs` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `type_rumah` int NOT NULL,
  `harga_rumah` int NOT NULL,
  `lokasi_rumah` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Raka Wahyu Pratama', 'rakawahyup62@gmail.com', NULL, '$2y$10$tCNjZiPIrRmgXjLthoHLG.YOAfQiRnP3V2n3xxSegDsKX9FYRPW1y', NULL, '24-05-20pas foto baju putih.jpeg', '2024-05-19 00:07:25', '2024-05-20 08:17:20'),
(3, 'Caroline kaila tahira', 'caroline@gmail.com', NULL, '$2y$10$63cRLgp1JfTuZ3zAPtIdo..pbPf5OHeQonIek9rVwXffrTOhcufe2', NULL, NULL, '2024-05-19 04:10:55', '2024-05-19 23:01:32'),
(6, 'komarudin', 'admin@gmail.com', NULL, '$2y$10$oNxUZWJST.w3gjJH5GnjZOLOwx5DCFtfSOPa4zycpEerT7RN/4h9K', NULL, '24-05-20ktp.png', '2024-05-20 00:09:30', '2024-05-20 08:18:25'),
(9, 'budi', 'budi@gmail.com', NULL, '$2y$10$QPubF/wU4ri0tIPI4NXQp.MZiP7PZLu1myv8lpUSV4CPXmH7SjDX2', NULL, NULL, '2024-05-20 01:52:51', '2024-05-20 01:52:51'),
(13, 'wandi', 'wandi@gmail.com', NULL, '$2y$10$J/GS/oIDvujTB6lNBlMIuuo.UITahq4Uw0b7gBOmocFM97NUWtaem', NULL, NULL, '2024-05-20 02:03:04', '2024-05-20 02:03:04'),
(15, 'Raka Wahyu Pratama', 'raka.wahyu@student.unjani.ac.id', NULL, '$2y$10$QFYk8oGIWr4Zvrd5rVq.lehXsOlYbJ45uK/J.J20JR9h1fgm9X8fu', NULL, '24-05-20latarbiru3x4.jpeg', '2024-05-20 05:52:00', '2024-05-20 05:52:00'),
(16, 'User Ke-0', 'user0@gmail.com', NULL, '$2y$10$VPxVUaPkQLKd3wT8Spdlg.SjWCrMcRqFKaywVySccnX0fPNtLE2Oe', NULL, NULL, '2024-05-20 20:32:51', '2024-05-20 20:32:51'),
(17, 'User Ke-1', 'user1@gmail.com', NULL, '$2y$10$RYJtE7dxP0lRKZugX/g/UOokUDx30q80AO1dGJ9LzH3AGY3GMHgnC', NULL, NULL, '2024-05-20 20:32:52', '2024-05-20 20:32:52'),
(18, 'User Ke-2', 'user2@gmail.com', NULL, '$2y$10$kjLC2EXwoI4dIlS9Ly0.xOcNwdUSRZOT8SRWVFeY8vT7jpI3H/Yx.', NULL, NULL, '2024-05-20 20:32:52', '2024-05-20 20:32:52'),
(19, 'User Ke-3', 'user3@gmail.com', NULL, '$2y$10$ZNF3PublHNMGqJoCfqYQKunbgNzTV4uaWDkHORy/AJICpkiXsbY4m', NULL, NULL, '2024-05-20 20:32:52', '2024-05-20 20:32:52'),
(20, 'User Ke-4', 'user4@gmail.com', NULL, '$2y$10$flXlcwJYKfzEXg7mYO5OkOUruBOWWe1KO.7/j.GClc7/Ac0kMGJq.', NULL, NULL, '2024-05-20 20:32:52', '2024-05-20 20:32:52'),
(21, 'User Ke-5', 'user5@gmail.com', NULL, '$2y$10$57VyVxP0IqhIBPqCriKFC.WvxbWdMc2LxnSHKJ3RLjsI.XPGY/8o6', NULL, NULL, '2024-05-20 20:32:52', '2024-05-20 20:32:52'),
(22, 'User Ke-6', 'user6@gmail.com', NULL, '$2y$10$mZ2UNC13fohmz0SscBewMuCUCB2Ov576MoSg2CQqJUWrVtW/aOBh6', NULL, NULL, '2024-05-20 20:32:52', '2024-05-20 20:32:52'),
(23, 'User Ke-7', 'user7@gmail.com', NULL, '$2y$10$MwA30PWK6L3A8Txmi7KuxOMpxsCuCqi3lpOzHfZeQp0GSx/NYZGfG', NULL, NULL, '2024-05-20 20:32:52', '2024-05-20 20:32:52'),
(24, 'User Ke-8', 'user8@gmail.com', NULL, '$2y$10$4ZbBAR5QbFtvoXm4ZO7lC.xMU/h6pKyCXJOOQmK9pnWmE0Nw8Evvu', NULL, NULL, '2024-05-20 20:32:52', '2024-05-20 20:32:52'),
(25, 'User Ke-9', 'user9@gmail.com', NULL, '$2y$10$tCi27wuopXOYX8Q9XCcj6u/RrNvnTKQpnhbnTn.dFrhSv3NzThltq', NULL, NULL, '2024-05-20 20:32:52', '2024-05-20 20:32:52'),
(26, 'User Ke-10', 'user10@gmail.com', NULL, '$2y$10$aXy7C2LGqGpIk9p.JelXu.pAO7oNI/lesG8jaNI/b4niqSHHB2jaG', NULL, NULL, '2024-05-20 20:32:52', '2024-05-20 20:32:52'),
(27, 'User Ke-11', 'user11@gmail.com', NULL, '$2y$10$RJbzn8.Db5uKYH4UNYD0NuOEao.6Ecj14DqwiwjetuW8u0fm412mu', NULL, NULL, '2024-05-20 20:32:53', '2024-05-20 20:32:53'),
(28, 'User Ke-12', 'user12@gmail.com', NULL, '$2y$10$1QCNNbeuMm2izoW3pHKX2eI6bK4xTqS4lMpheHpvUG5DZbveYxJgq', NULL, NULL, '2024-05-20 20:32:53', '2024-05-20 20:32:53'),
(29, 'User Ke-13', 'user13@gmail.com', NULL, '$2y$10$wtVP.7afkX8jCTOlhcOzHuB9c5V47h0V7e5tbvBGCWdJ9Lvig.TF6', NULL, NULL, '2024-05-20 20:32:53', '2024-05-20 20:32:53'),
(30, 'User Ke-14', 'user14@gmail.com', NULL, '$2y$10$vK8zCgaY56eO9LhRHF9HtOrnOFgP8.zsODjxxLfAE0Pn4WESyDix.', NULL, NULL, '2024-05-20 20:32:53', '2024-05-20 20:32:53'),
(31, 'User Ke-15', 'user15@gmail.com', NULL, '$2y$10$cKoUmDjBOliJpe.0SpqJg.qZRxLqw3yhLQ8pOJbBcqXHHYfRlOcu.', NULL, NULL, '2024-05-20 20:32:53', '2024-05-20 20:32:53'),
(32, 'User Ke-16', 'user16@gmail.com', NULL, '$2y$10$pdesF9Rwf.c/HKW9n7L0ZOLmXzFE6OSDJMUGUepf1b6FaSZfEfH86', NULL, NULL, '2024-05-20 20:32:53', '2024-05-20 20:32:53'),
(33, 'User Ke-17', 'user17@gmail.com', NULL, '$2y$10$9wD45TcIWZOSMKcRm8AzxepkcTHskJ.hI7BtaQhQfj3MZ7j831s66', NULL, NULL, '2024-05-20 20:32:53', '2024-05-20 20:32:53'),
(34, 'User Ke-18', 'user18@gmail.com', NULL, '$2y$10$05cMWaXNbbj8hnwomIXtq.Y69nmfjwfV2V62z8wThMDWnpnS5K6fO', NULL, NULL, '2024-05-20 20:32:53', '2024-05-20 20:32:53'),
(35, 'User Ke-19', 'user19@gmail.com', NULL, '$2y$10$iTXWGD/PKReAn/Tqz/1OIOmsV9XbxGf4XuIhVg1ioVgEfSeOnWlIi', NULL, NULL, '2024-05-20 20:32:53', '2024-05-20 20:32:53'),
(36, 'User Ke-20', 'user20@gmail.com', NULL, '$2y$10$Y7wikDrQ2vwXwa.9P5WFReMlTF3GwXMi3jYlOQiERiXbdMug6/JB.', NULL, NULL, '2024-05-20 20:32:53', '2024-05-20 20:32:53'),
(37, 'User Ke-21', 'user21@gmail.com', NULL, '$2y$10$GbogkFxGmRChfYuc8.UuvuQz1YO6dG5BhKKgZHF5h4KCiAf4uaCAK', NULL, NULL, '2024-05-20 20:32:53', '2024-05-20 20:32:53'),
(38, 'User Ke-22', 'user22@gmail.com', NULL, '$2y$10$jE4xbwW/pz4orIdlWOLreuUp.N4n7RZBYaaJFECPUrISbw04oVCdS', NULL, NULL, '2024-05-20 20:32:54', '2024-05-20 20:32:54'),
(39, 'User Ke-23', 'user23@gmail.com', NULL, '$2y$10$/xbASfuyX1ozqnro6nz8QuN84.b/GwvzBOXDRSqPeDrDv4UZK0jiu', NULL, NULL, '2024-05-20 20:32:54', '2024-05-20 20:32:54'),
(40, 'User Ke-24', 'user24@gmail.com', NULL, '$2y$10$iNIzMiEOoL/N9hpq2k0.P.0xGKNDYQBdR0VhK8N31Lf3KFub2QJoK', NULL, NULL, '2024-05-20 20:32:54', '2024-05-20 20:32:54'),
(41, 'User Ke-25', 'user25@gmail.com', NULL, '$2y$10$e9BF6.u33f.qsHngQBe8CuGlV3o/84oyDAuQZIx2avOPcIKw38wPq', NULL, NULL, '2024-05-20 20:32:54', '2024-05-20 20:32:54'),
(42, 'User Ke-26', 'user26@gmail.com', NULL, '$2y$10$OeRMco10cLqGwpNEJtCrHudR8RacL4uYfPwcASdmrw2Pj5aZStyfW', NULL, NULL, '2024-05-20 20:32:54', '2024-05-20 20:32:54'),
(43, 'User Ke-27', 'user27@gmail.com', NULL, '$2y$10$Hl6eeMDkadmvuT.EQgJYCec8/HSlj5HfT0r.uW71/VPuDM8iSALiW', NULL, NULL, '2024-05-20 20:32:54', '2024-05-20 20:32:54'),
(44, 'User Ke-28', 'user28@gmail.com', NULL, '$2y$10$TTYwz37p0vKYUUolWVmELe9Ri2C8ha.scPzXD0J5tsMbmkeJSpX8.', NULL, NULL, '2024-05-20 20:32:54', '2024-05-20 20:32:54'),
(45, 'User Ke-29', 'user29@gmail.com', NULL, '$2y$10$s6C5GmOVCPmjqhdUHd6Wj.1PEoexKV0XrgYlitypkikj/gPxMVr/e', NULL, NULL, '2024-05-20 20:32:54', '2024-05-20 20:32:54'),
(46, 'User Ke-30', 'user30@gmail.com', NULL, '$2y$10$NY3ItRjjNgtu.q9wZu9j6e7Jcv4Yd300rbDXEX3KaubYEy1/j/Nle', NULL, NULL, '2024-05-20 20:32:54', '2024-05-20 20:32:54'),
(47, 'User Ke-31', 'user31@gmail.com', NULL, '$2y$10$zyr6ztfPPPW/HafGBJpt1.mj3RZarZBVQA9jAuK8YEa31YyUk60T.', NULL, NULL, '2024-05-20 20:32:54', '2024-05-20 20:32:54'),
(48, 'User Ke-32', 'user32@gmail.com', NULL, '$2y$10$nPZ.aUbyS5hz3hdprmLdQuTIZ9WRjBNfLBCy5Uxf/WfIS0hzuOEqC', NULL, NULL, '2024-05-20 20:32:54', '2024-05-20 20:32:54'),
(49, 'User Ke-33', 'user33@gmail.com', NULL, '$2y$10$4xaYN/LaVAu.QRzFES4PmurONUHZzeQuzdHxD2ZIPzLG7OTitGAU.', NULL, NULL, '2024-05-20 20:32:55', '2024-05-20 20:32:55'),
(50, 'User Ke-34', 'user34@gmail.com', NULL, '$2y$10$Ofpq83fYKQtt8pFzGvbz/OLXyXUCkzGlEKY.KLJ0wnYXqhZgUl4dW', NULL, NULL, '2024-05-20 20:32:55', '2024-05-20 20:32:55'),
(51, 'User Ke-35', 'user35@gmail.com', NULL, '$2y$10$CfkjRpGhWeRJFyCKTXMcjukM.HuZhBpz.tu8jwegPWZUI6YXERLeW', NULL, NULL, '2024-05-20 20:32:55', '2024-05-20 20:32:55'),
(52, 'User Ke-36', 'user36@gmail.com', NULL, '$2y$10$gw61xkEe6nYTNYySYGQhd.EnAKmw2q92JZCpfkQyllSS4T2uc1smC', NULL, NULL, '2024-05-20 20:32:55', '2024-05-20 20:32:55'),
(53, 'User Ke-37', 'user37@gmail.com', NULL, '$2y$10$hfDEyrbN8Mp3GU22Q8rSVOpVxTyIsG3pS8Zs8cfallnvtVjYiwv2S', NULL, NULL, '2024-05-20 20:32:55', '2024-05-20 20:32:55'),
(54, 'User Ke-38', 'user38@gmail.com', NULL, '$2y$10$Ft8vN2Wzm9jhMuObjfToTOW.qAF2T973pQcrt6QuOFv7Mvb7ZxlVW', NULL, NULL, '2024-05-20 20:32:55', '2024-05-20 20:32:55'),
(55, 'User Ke-39', 'user39@gmail.com', NULL, '$2y$10$wmRHq8cs5yURmWgo2V5zW.ksXqVOi0JLd0Zl62dlfH4H5awYCQar2', NULL, NULL, '2024-05-20 20:32:55', '2024-05-20 20:32:55'),
(56, 'User Ke-40', 'user40@gmail.com', NULL, '$2y$10$f7NsOnrNKP31wYh01LAfBOtO0b17VUffzNMWf9pi4WVlPhal6HIRm', NULL, NULL, '2024-05-20 20:32:55', '2024-05-20 20:32:55'),
(57, 'User Ke-41', 'user41@gmail.com', NULL, '$2y$10$U.FnD3cA4CMCjNNsaW3hgukQInj.Te22ZO5Cj/I6MC6m3Nxi3NuT6', NULL, NULL, '2024-05-20 20:32:55', '2024-05-20 20:32:55'),
(58, 'User Ke-42', 'user42@gmail.com', NULL, '$2y$10$nOwZr1O1324WuqKB1HeV8.LDASyAQVeIn.Ih71/rQdCmKJld/VcXW', NULL, NULL, '2024-05-20 20:32:55', '2024-05-20 20:32:55'),
(59, 'User Ke-43', 'user43@gmail.com', NULL, '$2y$10$djJU7cGdSeOUkNqIl1Sg9.lmSkxjjGHUzwZGULwQN/Fsmq/hjKyQG', NULL, NULL, '2024-05-20 20:32:55', '2024-05-20 20:32:55'),
(60, 'User Ke-44', 'user44@gmail.com', NULL, '$2y$10$/qD2DMzM/RUR8/HpGpg1b.k8KPsz5mKjE6FzX0DFYNmYbg1QxO5OS', NULL, NULL, '2024-05-20 20:32:56', '2024-05-20 20:32:56'),
(61, 'User Ke-45', 'user45@gmail.com', NULL, '$2y$10$WcNozAr7yfWjej727oy5C.38og7EO7GcnlgYYLrJ5uz6Sttihjpj2', NULL, NULL, '2024-05-20 20:32:56', '2024-05-20 20:32:56'),
(62, 'User Ke-46', 'user46@gmail.com', NULL, '$2y$10$MvYxZvs/k4NXtlpvAaV8bOi8OeEkkp6zHz2/GovM2J6qlksoMnsp2', NULL, NULL, '2024-05-20 20:32:56', '2024-05-20 20:32:56'),
(63, 'User Ke-47', 'user47@gmail.com', NULL, '$2y$10$sXC.KUPFLif844Sh2w1bqO89BHuL9TKr1BMzL3DDcjMcLw5IigeGu', NULL, NULL, '2024-05-20 20:32:56', '2024-05-20 20:32:56'),
(64, 'User Ke-48', 'user48@gmail.com', NULL, '$2y$10$7Lp8Y7wRsQ3IJ8OjuQ9yMeBU9D7O.q2dODtD6wjYQPmLiEtMzfOpy', NULL, NULL, '2024-05-20 20:32:56', '2024-05-20 20:32:56'),
(65, 'User Ke-49', 'user49@gmail.com', NULL, '$2y$10$.VTEu3Ga2JZqN6hy3.yhu.x3a1J8eMdVUVCQYohSOKZhiAeWCo75S', NULL, NULL, '2024-05-20 20:32:56', '2024-05-20 20:32:56'),
(66, 'User Ke-50', 'user50@gmail.com', NULL, '$2y$10$B3Yh9tT30OYMQcwdHYFT0eQmFbF2lAO7lesIFF7XC7rtU6T1tDc3K', NULL, NULL, '2024-05-20 20:32:56', '2024-05-20 20:32:56'),
(67, 'User Ke-51', 'user51@gmail.com', NULL, '$2y$10$71iQZJnV52ArOjGRpByeFO3wymEkrcm5T78BB9zNdEWHA61koLZsa', NULL, NULL, '2024-05-20 20:32:56', '2024-05-20 20:32:56'),
(68, 'User Ke-52', 'user52@gmail.com', NULL, '$2y$10$3BRtSCVDfRfSgKyUQL9AReEA1tSnmcNP1NilNuXP3QxmpDLijDl2m', NULL, NULL, '2024-05-20 20:32:56', '2024-05-20 20:32:56'),
(69, 'User Ke-53', 'user53@gmail.com', NULL, '$2y$10$R6vbEwCIXGtw3.AnlWqwCuY6l.a6mulrMOx9PCxPVycYcOnDum7Ly', NULL, NULL, '2024-05-20 20:32:56', '2024-05-20 20:32:56'),
(70, 'User Ke-54', 'user54@gmail.com', NULL, '$2y$10$BKd8c2Jv9O7fjPIvBk.9X.fdnBMy2Nr/jXQDYf5J.hNVnxc7AjF7W', NULL, NULL, '2024-05-20 20:32:56', '2024-05-20 20:32:56'),
(71, 'User Ke-55', 'user55@gmail.com', NULL, '$2y$10$0n1OI.sbesy127vMtDsABOcbTI4Ajg70WgfXBZ4TLr1Rv849sL8aO', NULL, NULL, '2024-05-20 20:32:56', '2024-05-20 20:32:56'),
(72, 'User Ke-56', 'user56@gmail.com', NULL, '$2y$10$7EQr0BKiVIsZcp6iNgrOD.KoZQqgfiavN9rMj9oa6bVod5PvsBcJ6', NULL, NULL, '2024-05-20 20:32:57', '2024-05-20 20:32:57'),
(73, 'User Ke-57', 'user57@gmail.com', NULL, '$2y$10$Lc180AvsUOLopfWCTN1TFuPwm5TR6Oa1ju33ijdNyHi0JydSyG5U2', NULL, NULL, '2024-05-20 20:32:57', '2024-05-20 20:32:57'),
(74, 'User Ke-58', 'user58@gmail.com', NULL, '$2y$10$JqrtVnBr2mDC3xiRPRPyju0PD7Q2yzEJAsaZ5IumF.7i1JTWgyx2K', NULL, NULL, '2024-05-20 20:32:57', '2024-05-20 20:32:57'),
(75, 'User Ke-59', 'user59@gmail.com', NULL, '$2y$10$EoojGzTPgmF/DmskwTYLSuRYfPjJp9esMPJw6OxDbt3E0RSbcXj1y', NULL, NULL, '2024-05-20 20:32:57', '2024-05-20 20:32:57'),
(76, 'User Ke-60', 'user60@gmail.com', NULL, '$2y$10$uT/UL2gu/h72YbMEjN1c3uiIQvQDGpoXBUfOCS1ZiZ9qRonyspcwW', NULL, NULL, '2024-05-20 20:32:57', '2024-05-20 20:32:57'),
(77, 'User Ke-61', 'user61@gmail.com', NULL, '$2y$10$t30RZ8Y0VAEm3ID.V4hV5ONmunHLW5z9tyMHadGlimDS.rOz7CbX6', NULL, NULL, '2024-05-20 20:32:57', '2024-05-20 20:32:57'),
(78, 'User Ke-62', 'user62@gmail.com', NULL, '$2y$10$KmqN1ytD8.05mtNgwQ.ZVeWCgZztlKjNPn39JtE0t41svOTRzOim6', NULL, NULL, '2024-05-20 20:32:57', '2024-05-20 20:32:57'),
(79, 'User Ke-63', 'user63@gmail.com', NULL, '$2y$10$ubW16V8E5H4UgdzmjAglNeYTcqESqq9IWsXYIsY8AJiJf0kbbNzxa', NULL, NULL, '2024-05-20 20:32:57', '2024-05-20 20:32:57'),
(80, 'User Ke-64', 'user64@gmail.com', NULL, '$2y$10$qhzbenBrdWSQ5bFOHv4t2OsxWEWG/dGSsuI3ZHDfCUPoxEhF.OXmK', NULL, NULL, '2024-05-20 20:32:57', '2024-05-20 20:32:57'),
(81, 'User Ke-65', 'user65@gmail.com', NULL, '$2y$10$9xyDXglgUxHVK5lqv9fEpel2qnBQkfZ0EwwQZIifr8Id9aF47xE1O', NULL, NULL, '2024-05-20 20:32:57', '2024-05-20 20:32:57'),
(82, 'User Ke-66', 'user66@gmail.com', NULL, '$2y$10$C1ldkSBQxsxcWb2HpsFsYOoHAj3aiXvsgppM4ZyhngjfEDP6H/VvO', NULL, NULL, '2024-05-20 20:32:57', '2024-05-20 20:32:57'),
(83, 'User Ke-67', 'user67@gmail.com', NULL, '$2y$10$671cofA6xYAws2ac4e6KGenPMIkliMZ4qS.S6DLJCj1oOIN2qSIYK', NULL, NULL, '2024-05-20 20:32:58', '2024-05-20 20:32:58'),
(84, 'User Ke-68', 'user68@gmail.com', NULL, '$2y$10$sS1ovuh/Bvfgl.8mVWQ3k.l7JMqT4nO3lWkv7WoESltGcAwpcMd52', NULL, NULL, '2024-05-20 20:32:58', '2024-05-20 20:32:58'),
(85, 'User Ke-69', 'user69@gmail.com', NULL, '$2y$10$L7S9/a7z6SSMez1nXQTelOXc6/LKDNsAF/MyS5g41DulXFQ2KY2zC', NULL, NULL, '2024-05-20 20:32:58', '2024-05-20 20:32:58'),
(86, 'User Ke-70', 'user70@gmail.com', NULL, '$2y$10$UbSEp9eZn37i/IsjSYabyuJaM3sShDMYYPRjRq0HgdMXxFuM0TuT2', NULL, NULL, '2024-05-20 20:32:58', '2024-05-20 20:32:58'),
(87, 'User Ke-71', 'user71@gmail.com', NULL, '$2y$10$Tgj8ghyT.qC7o.N2vq4CjexeE3G2CCPZFyg.hGLFWTh11cIF82nhu', NULL, NULL, '2024-05-20 20:32:58', '2024-05-20 20:32:58'),
(88, 'User Ke-72', 'user72@gmail.com', NULL, '$2y$10$zVehBPyM0j4JngrVjFQKz.w/BBqXTzs4MwHc5ptZbwCPeRc0/f33u', NULL, NULL, '2024-05-20 20:32:58', '2024-05-20 20:32:58'),
(89, 'User Ke-73', 'user73@gmail.com', NULL, '$2y$10$ZMwnu0HE.EAgKE/5nHCgRuBpWFxasKRRJH7TwD3yubUMQ0rDnP0eu', NULL, NULL, '2024-05-20 20:32:58', '2024-05-20 20:32:58'),
(90, 'User Ke-74', 'user74@gmail.com', NULL, '$2y$10$0ov0F6tuq2lpgNTCRI7ZrOTlkaJ8f5TsNtP6uWkUGonKPOPbyKW66', NULL, NULL, '2024-05-20 20:32:58', '2024-05-20 20:32:58'),
(91, 'User Ke-75', 'user75@gmail.com', NULL, '$2y$10$FoxcWEoB7jKUD979yI7x..qt5i52iZNSpMr7Jac4ryvKaPn.qXZtG', NULL, NULL, '2024-05-20 20:32:58', '2024-05-20 20:32:58'),
(92, 'User Ke-76', 'user76@gmail.com', NULL, '$2y$10$YOWd85DWO7NU2R1rTUm7aOtTr71kIOR/.O5wQVsD16xIaUJp8woUy', NULL, NULL, '2024-05-20 20:32:58', '2024-05-20 20:32:58'),
(93, 'User Ke-77', 'user77@gmail.com', NULL, '$2y$10$rJXNQNfY/W8bDj44GUYPguMWWlLcSkAVDMW63slFx5z/mpsgYFB8a', NULL, NULL, '2024-05-20 20:32:58', '2024-05-20 20:32:58'),
(94, 'User Ke-78', 'user78@gmail.com', NULL, '$2y$10$ZVN.uUTnKra9Nj2Dz8DeHegU4BA/vm/uXmX7SNr1jVBcPAsuy3wPi', NULL, NULL, '2024-05-20 20:32:59', '2024-05-20 20:32:59'),
(95, 'User Ke-79', 'user79@gmail.com', NULL, '$2y$10$gtfkLPEGovhD4tZa8P0kzOBJPKQdbvqE07c5pOS.Ub8jOiCZPT96u', NULL, NULL, '2024-05-20 20:32:59', '2024-05-20 20:32:59'),
(96, 'User Ke-80', 'user80@gmail.com', NULL, '$2y$10$250NHTRzcSi02.BJKETkrep22IFjeycag2btZNBpDlcEYDqiAuPGG', NULL, NULL, '2024-05-20 20:32:59', '2024-05-20 20:32:59'),
(97, 'User Ke-81', 'user81@gmail.com', NULL, '$2y$10$PO/6ytf4hS7U2VNwISGUneFySA2kpfZv0IJEWrab55fkcq3BwN/PK', NULL, NULL, '2024-05-20 20:32:59', '2024-05-20 20:32:59'),
(98, 'User Ke-82', 'user82@gmail.com', NULL, '$2y$10$4kE8oazfzteujDBziNQAjeIrWpn4cji1xFbSpA.3CDesmDTHkwqyC', NULL, NULL, '2024-05-20 20:32:59', '2024-05-20 20:32:59'),
(99, 'User Ke-83', 'user83@gmail.com', NULL, '$2y$10$bMxmjs7bGSFXdGpB2XxU7OOpN1gzdu3rkSdX3fU3Ba0QDgWWlt9eS', NULL, NULL, '2024-05-20 20:32:59', '2024-05-20 20:32:59'),
(100, 'User Ke-84', 'user84@gmail.com', NULL, '$2y$10$DCus8ZNyGtGaQ6Hc6tzdoezEwUacqDVcXLvy6clw0SvL3BcXkbGni', NULL, NULL, '2024-05-20 20:32:59', '2024-05-20 20:32:59'),
(101, 'User Ke-85', 'user85@gmail.com', NULL, '$2y$10$TQhxhy1fppAR2rq4GimRqef7LMX.sMMKpTQAN02NZWUgER2TUDKmm', NULL, NULL, '2024-05-20 20:32:59', '2024-05-20 20:32:59'),
(102, 'User Ke-86', 'user86@gmail.com', NULL, '$2y$10$MrHm9k.68lpdnxJ.m2QeFeuEfb4Y8s1oxRwPn2Z8fWBLleRWZcQdy', NULL, NULL, '2024-05-20 20:32:59', '2024-05-20 20:32:59'),
(103, 'User Ke-87', 'user87@gmail.com', NULL, '$2y$10$8LM5jaLkf6B2AQKu3fFecuJyUUQvnn3/OQ7qhUu10ANsoJeRtHxJK', NULL, NULL, '2024-05-20 20:32:59', '2024-05-20 20:32:59'),
(104, 'User Ke-88', 'user88@gmail.com', NULL, '$2y$10$NeMBYHs4jOdwy60aHkiAYu6wLF1SRXg.RfEoUONlRo0mYBIUYKBlm', NULL, NULL, '2024-05-20 20:32:59', '2024-05-20 20:32:59'),
(105, 'User Ke-89', 'user89@gmail.com', NULL, '$2y$10$TzPgx8Alv9eXoFgT8wdDyejLRw70gpSJWMRx9o325bkAx3YkTplhy', NULL, NULL, '2024-05-20 20:33:00', '2024-05-20 20:33:00'),
(106, 'User Ke-90', 'user90@gmail.com', NULL, '$2y$10$4hcmfoOuwltqvIUQzg90vOteuR269oUll6JgAWAE2aazjs80QmVG6', NULL, NULL, '2024-05-20 20:33:00', '2024-05-20 20:33:00'),
(107, 'User Ke-91', 'user91@gmail.com', NULL, '$2y$10$aB6DpM4vJ9rx0Sjb3nseteFQ574y86Ftdsg4gxGsAxqFQixOkKkNm', NULL, NULL, '2024-05-20 20:33:00', '2024-05-20 20:33:00'),
(108, 'User Ke-92', 'user92@gmail.com', NULL, '$2y$10$yv1bSFh/lYec5QP5l03yDuJefFsM7xT3Unz84M6DBa9uOSWA6Ggnm', NULL, NULL, '2024-05-20 20:33:00', '2024-05-20 20:33:00'),
(109, 'User Ke-93', 'user93@gmail.com', NULL, '$2y$10$xZx4sy3netz87Vw9eSAFy.9UKgVQ2Wow9tjNLAY3nSeCCHx94w6H.', NULL, NULL, '2024-05-20 20:33:00', '2024-05-20 20:33:00'),
(110, 'User Ke-94', 'user94@gmail.com', NULL, '$2y$10$H/R9vn3jvsNRcc7a/ffIc.3qnMyLgtn6M65qOtklhS9XJ/NTfXxv.', NULL, NULL, '2024-05-20 20:33:00', '2024-05-20 20:33:00'),
(111, 'User Ke-95', 'user95@gmail.com', NULL, '$2y$10$McuvLemEW1cTQRr1774EteV781PUQ12zfNXZZMY9jzr.ik1Yf9SPa', NULL, NULL, '2024-05-20 20:33:00', '2024-05-20 20:33:00'),
(112, 'User Ke-96', 'user96@gmail.com', NULL, '$2y$10$HMbUwdCjrxAdjC8KRY88ZOsaBC/gBBuIqCMV8hrcl3huZXKC13HFi', NULL, NULL, '2024-05-20 20:33:00', '2024-05-20 20:33:00'),
(113, 'User Ke-97', 'user97@gmail.com', NULL, '$2y$10$7z300Odl9ld5ymLTg9ccLef1eL7ddGyFde.mPDhlrKeQb.LDjEPQa', NULL, NULL, '2024-05-20 20:33:00', '2024-05-20 20:33:00'),
(114, 'User Ke-98', 'user98@gmail.com', NULL, '$2y$10$AFUzQvT8Sn.KiFKbwo5dY.Bz07Zm6C9AdDCtXow55zjs24BWc4nzS', NULL, NULL, '2024-05-20 20:33:00', '2024-05-20 20:33:00'),
(115, 'User Ke-99', 'user99@gmail.com', NULL, '$2y$10$zeH0m/msWCDLnMiwPgtlwexdFBNkKEbV/00Jb/6r7cdjvCpYb5Su6', NULL, NULL, '2024-05-20 20:33:00', '2024-05-20 20:33:00'),
(116, 'User Ke-100', 'user100@gmail.com', NULL, '$2y$10$ZaZsPq661ZLFTWQvnhI0YewmEBqNOIKzTUwf4EkhK7PWGh25HdUYW', NULL, NULL, '2024-05-20 20:33:01', '2024-05-20 20:33:01'),
(117, 'User Ke-101', 'user101@gmail.com', NULL, '$2y$10$fxknU26WR4mPJvQCx4Gule82gRy.KYPNuoW/se.SQurXy5roHWMee', NULL, NULL, '2024-05-20 20:33:01', '2024-05-20 20:33:01'),
(118, 'User Ke-102', 'user102@gmail.com', NULL, '$2y$10$HUTWvrG6WLxMcSRlSGfAPOZEEe2ESRB1YwII8z9bmYA3MjOn.1ZVy', NULL, NULL, '2024-05-20 20:33:01', '2024-05-20 20:33:01'),
(119, 'User Ke-103', 'user103@gmail.com', NULL, '$2y$10$yzsWeaBCBdfOI//rBDEjc.1dMHYRnmX9IlvIJ9OS3ZjO2X9/4iibu', NULL, NULL, '2024-05-20 20:33:01', '2024-05-20 20:33:01'),
(120, 'User Ke-104', 'user104@gmail.com', NULL, '$2y$10$oOzwTf0mCXBgm4dwMg3/2OP.6RNTRp6PM.cbrum7hqkhZ.nlbSWwG', NULL, NULL, '2024-05-20 20:33:01', '2024-05-20 20:33:01'),
(121, 'User Ke-105', 'user105@gmail.com', NULL, '$2y$10$OXarr7INgXSWQpveffp81.DJj6RBrh2bL.CMQlBkoFh75H1uaXbZq', NULL, NULL, '2024-05-20 20:33:01', '2024-05-20 20:33:01'),
(122, 'User Ke-106', 'user106@gmail.com', NULL, '$2y$10$z4As4GdUvJXi60Kg2X2WdOSISeFkE3PQ2OPyUdbDHLshvkYZEwJMa', NULL, NULL, '2024-05-20 20:33:01', '2024-05-20 20:33:01'),
(123, 'User Ke-107', 'user107@gmail.com', NULL, '$2y$10$Pr7DlFpE/lgOaHRqsCpNlOSw34v.d8e4ai/KELIwA400d/5ZmsIae', NULL, NULL, '2024-05-20 20:33:01', '2024-05-20 20:33:01'),
(124, 'User Ke-108', 'user108@gmail.com', NULL, '$2y$10$15qSu8A9lzG9skcV2ks/zO38xcgTgNxRaqq145Xzfj6rMcw1ETQHa', NULL, NULL, '2024-05-20 20:33:01', '2024-05-20 20:33:01'),
(125, 'User Ke-109', 'user109@gmail.com', NULL, '$2y$10$jPWV5IKoCfs5jrKfcsP8K.9O99abVfLZ6ZdVKFLmkKpWlUbaG07jm', NULL, NULL, '2024-05-20 20:33:01', '2024-05-20 20:33:01'),
(126, 'User Ke-110', 'user110@gmail.com', NULL, '$2y$10$Gb57DOZ36uJhyE264aL/SOAz5zIitsw3Mwt0jTXiTDfjxpYvUc2r2', NULL, NULL, '2024-05-20 20:33:01', '2024-05-20 20:33:01'),
(127, 'User Ke-111', 'user111@gmail.com', NULL, '$2y$10$lh3sAlNQzvQaQ5thEbr4temk8wtDwqGiFJeBk9xEh3Nfi7aSNFMyu', NULL, NULL, '2024-05-20 20:33:02', '2024-05-20 20:33:02'),
(128, 'User Ke-112', 'user112@gmail.com', NULL, '$2y$10$gayXh6uC7NHtH8JBGSKBpeKb71yupJjkg9I9ppGpehQYEBWIvIxAS', NULL, NULL, '2024-05-20 20:33:02', '2024-05-20 20:33:02'),
(129, 'User Ke-113', 'user113@gmail.com', NULL, '$2y$10$8OH5zXa6qW7RTb1XLkp/xuaOjXuuUeI8pmoUWX4QWRa5Xb3wSScy2', NULL, NULL, '2024-05-20 20:33:02', '2024-05-20 20:33:02'),
(130, 'User Ke-114', 'user114@gmail.com', NULL, '$2y$10$Jap7LrhS.MJ5hc74ShZ.uuQcHGrHERH03WWhJAm66zkFjj.AEXnRS', NULL, NULL, '2024-05-20 20:33:02', '2024-05-20 20:33:02'),
(131, 'User Ke-115', 'user115@gmail.com', NULL, '$2y$10$KGwcIVCpPiFu4/PSWzcyIuE2Jds1ibM/LOpkzo.DXqUnTZd8RKt7q', NULL, NULL, '2024-05-20 20:33:02', '2024-05-20 20:33:02'),
(132, 'User Ke-116', 'user116@gmail.com', NULL, '$2y$10$xD.Jff6rQ.iB.Zs1gXB.qOliwUYkpzaAQcVnLFUi9ZF6c1SWw6jVy', NULL, NULL, '2024-05-20 20:33:02', '2024-05-20 20:33:02'),
(133, 'User Ke-117', 'user117@gmail.com', NULL, '$2y$10$SxZ8xhpdDI.vlRGl0M/BaOYA1Rj2LXSgj9I8GC9fxVgLbaKSz.nVy', NULL, NULL, '2024-05-20 20:33:02', '2024-05-20 20:33:02'),
(134, 'User Ke-118', 'user118@gmail.com', NULL, '$2y$10$E4HnrN9IXt0kklUR0MzSQe5Ml4tL4II5McH9vKG2F12BYvAewngIG', NULL, NULL, '2024-05-20 20:33:02', '2024-05-20 20:33:02'),
(135, 'User Ke-119', 'user119@gmail.com', NULL, '$2y$10$mcTyrJVFoXv8uRpZaLSZAeE8ZenW..drRE0povoSSeUbSqk6SLKjq', NULL, NULL, '2024-05-20 20:33:02', '2024-05-20 20:33:02'),
(136, 'User Ke-120', 'user120@gmail.com', NULL, '$2y$10$8n4BEVcBToAZICHQvaloeO0Trgk7EJD7CRqyu.mmV20cg4QiebuPa', NULL, NULL, '2024-05-20 20:33:02', '2024-05-20 20:33:02'),
(137, 'User Ke-121', 'user121@gmail.com', NULL, '$2y$10$lo34UYjK09GqV2bxGTJL7uPJdOYXAL51QRl3vw.oE16TlM1HT1IFG', NULL, NULL, '2024-05-20 20:33:02', '2024-05-20 20:33:02'),
(138, 'User Ke-122', 'user122@gmail.com', NULL, '$2y$10$2ILRR/ghR7tPpB1Enn1kp.mUyexm0TWLeMPE3KI4/DMCkXXIkuaNu', NULL, NULL, '2024-05-20 20:33:03', '2024-05-20 20:33:03'),
(139, 'User Ke-123', 'user123@gmail.com', NULL, '$2y$10$qOeKL7M2NVQDhck7PnXaeuRRwySmbdpUMRAaRB1HcvGXI3uaSTCXO', NULL, NULL, '2024-05-20 20:33:03', '2024-05-20 20:33:03'),
(140, 'User Ke-124', 'user124@gmail.com', NULL, '$2y$10$KbwHEL34OlVWyxNCjJPFWefJtE8Tanm2p6KNTbeFAMsqHnfQOn3Sy', NULL, NULL, '2024-05-20 20:33:03', '2024-05-20 20:33:03'),
(141, 'User Ke-125', 'user125@gmail.com', NULL, '$2y$10$E75Q8QEJLYDBv99olYQsPONA3830QdeQQ5l3dR59cGhj4eTE3gRZ6', NULL, NULL, '2024-05-20 20:33:03', '2024-05-20 20:33:03'),
(142, 'User Ke-126', 'user126@gmail.com', NULL, '$2y$10$suT4p/Fn4eEcq9TRnw3/CeBJHZjc60LEsAbqhCfdN62RFwivubIQS', NULL, NULL, '2024-05-20 20:33:03', '2024-05-20 20:33:03'),
(143, 'User Ke-127', 'user127@gmail.com', NULL, '$2y$10$rlNOur9XMcfLR8ophpQ.kOW28sO7sv7mnoSD1ecBc5j2EkW4U4.ou', NULL, NULL, '2024-05-20 20:33:03', '2024-05-20 20:33:03'),
(144, 'User Ke-128', 'user128@gmail.com', NULL, '$2y$10$zoQ2m9JLgkpE/OoCOzWkLuyQ4Shx70tkvKZNt7MdBXGNLGh4Lfos2', NULL, NULL, '2024-05-20 20:33:03', '2024-05-20 20:33:03'),
(145, 'User Ke-129', 'user129@gmail.com', NULL, '$2y$10$Q0CCgOwnjkXAddkEa25Bk.5udyyuQ0m5koSbLhZMZHErD3sJ4WUEG', NULL, NULL, '2024-05-20 20:33:03', '2024-05-20 20:33:03'),
(146, 'User Ke-130', 'user130@gmail.com', NULL, '$2y$10$cR0wpkDwu5Z8CxDHFILcweXPV0U3fE35DG9Q3Zn7jqBINEGioYs5.', NULL, NULL, '2024-05-20 20:33:03', '2024-05-20 20:33:03'),
(147, 'User Ke-131', 'user131@gmail.com', NULL, '$2y$10$/XD.GGuHFK5B3F3dMfB1x.cMGS4NcRjpQwboyJOSuEHYVATJWxI2y', NULL, NULL, '2024-05-20 20:33:03', '2024-05-20 20:33:03'),
(148, 'User Ke-132', 'user132@gmail.com', NULL, '$2y$10$I8hnd4ZipNzx53OvazS0N.XI04Fr9wGeb9r./hnSXwnLr5rqoeJeW', NULL, NULL, '2024-05-20 20:33:03', '2024-05-20 20:33:03'),
(149, 'User Ke-133', 'user133@gmail.com', NULL, '$2y$10$XzggAhbS98nju2z.FiUQQeYmQdArV5l3fwMaWcbnvZv7/eiyxBZEW', NULL, NULL, '2024-05-20 20:33:04', '2024-05-20 20:33:04'),
(150, 'User Ke-134', 'user134@gmail.com', NULL, '$2y$10$q7HrvdA2Y4oPYIfuSgNwIOXSRFKqajigMZ3cHuIhuTrLCAdFut5fK', NULL, NULL, '2024-05-20 20:33:04', '2024-05-20 20:33:04'),
(151, 'User Ke-135', 'user135@gmail.com', NULL, '$2y$10$T7V1S.Dttpo6rmpOZQ9WRO1TBxirKJ7dG08nDKe7CNQV008WcEFcC', NULL, NULL, '2024-05-20 20:33:04', '2024-05-20 20:33:04'),
(152, 'User Ke-136', 'user136@gmail.com', NULL, '$2y$10$FRYMZDUkIRZz33MQ6qjzquTbBwAYIemFFRO39/KhZL6i9aiZ.2xS6', NULL, NULL, '2024-05-20 20:33:04', '2024-05-20 20:33:04'),
(153, 'User Ke-137', 'user137@gmail.com', NULL, '$2y$10$294YAXa7DJK9K01JsYWF9e/yANRbTWx09acng0P7uTpRp27KUNwxO', NULL, NULL, '2024-05-20 20:33:04', '2024-05-20 20:33:04'),
(154, 'User Ke-138', 'user138@gmail.com', NULL, '$2y$10$5himyEJ.KfEkFvnmR7vUW.r2V4pxcvm7vW//yA5g0hW/frhLA1u4O', NULL, NULL, '2024-05-20 20:33:04', '2024-05-20 20:33:04'),
(155, 'User Ke-139', 'user139@gmail.com', NULL, '$2y$10$EklMqN3GxP/7gwLgS4V30ekaE4lK8kKvBAn2apR3BsFp.GKCMDqae', NULL, NULL, '2024-05-20 20:33:04', '2024-05-20 20:33:04'),
(156, 'User Ke-140', 'user140@gmail.com', NULL, '$2y$10$NzeSIbFb1E7P0cbscL/Ft.ctQK1RtW129ekmdi8ybFtafHv3eOHfa', NULL, NULL, '2024-05-20 20:33:04', '2024-05-20 20:33:04'),
(157, 'User Ke-141', 'user141@gmail.com', NULL, '$2y$10$p8/Ihk3sPitAiLZnNzE.muxmz5BN5i3u5baEPLocgiHY2DZru8qLO', NULL, NULL, '2024-05-20 20:33:04', '2024-05-20 20:33:04'),
(158, 'User Ke-142', 'user142@gmail.com', NULL, '$2y$10$AcxWtkN.2GKDMX0jILyJpebnSzhc4DZXJ9sL7tEDxCTbys0UoOtkK', NULL, NULL, '2024-05-20 20:33:04', '2024-05-20 20:33:04'),
(159, 'User Ke-143', 'user143@gmail.com', NULL, '$2y$10$UOy59Q2585LjbKcn7vkdbO2huewG5NCfCGrb18ekwydZ2iL7bPEOi', NULL, NULL, '2024-05-20 20:33:04', '2024-05-20 20:33:04'),
(160, 'User Ke-144', 'user144@gmail.com', NULL, '$2y$10$.HymPeEEK4YPnbfAuzZdCeazEhKW2YoLQsGcV/hGyjor8n1fED.RG', NULL, NULL, '2024-05-20 20:33:05', '2024-05-20 20:33:05'),
(161, 'User Ke-145', 'user145@gmail.com', NULL, '$2y$10$mSvHr/1aDorJ69RKmVakBOqI28LE11BSFJZkTdvVSRYCaFn4cfe26', NULL, NULL, '2024-05-20 20:33:05', '2024-05-20 20:33:05'),
(162, 'User Ke-146', 'user146@gmail.com', NULL, '$2y$10$9BRxzBW7u9r1zQOjKm1TW.jYPw/NzVDM58xzopXypT5OzqZRLEIa.', NULL, NULL, '2024-05-20 20:33:05', '2024-05-20 20:33:05'),
(163, 'User Ke-147', 'user147@gmail.com', NULL, '$2y$10$wOVWyi.KQMq016F8YD7uSuxB14CaZUf/vEo7.6ZFZJ..coT9Bc8Mm', NULL, NULL, '2024-05-20 20:33:05', '2024-05-20 20:33:05'),
(164, 'User Ke-148', 'user148@gmail.com', NULL, '$2y$10$3RtOM.qMTU.xJ4LqcHpF/.xPvgbhe5Y/H1kRRdV1Q0cNJiOoZ9Qu.', NULL, NULL, '2024-05-20 20:33:05', '2024-05-20 20:33:05'),
(165, 'User Ke-149', 'user149@gmail.com', NULL, '$2y$10$8rONJeCXFwyEoSoTJKjuC.wNKypDHbmb4F96tsTM1ZLpuzruV8G2.', NULL, NULL, '2024-05-20 20:33:05', '2024-05-20 20:33:05'),
(166, 'User Ke-150', 'user150@gmail.com', NULL, '$2y$10$jTzBbv008OJuHp3dfciiK.GUpqtOU9rnvPq8P2yZeIqcKC1y8YrPi', NULL, NULL, '2024-05-20 20:33:05', '2024-05-20 20:33:05'),
(167, 'User Ke-151', 'user151@gmail.com', NULL, '$2y$10$le0JBVa/6iOrF.Sl/BXyoOskriOZYUQK/rycbUYsBNcQQZtgQoz2C', NULL, NULL, '2024-05-20 20:33:05', '2024-05-20 20:33:05'),
(168, 'User Ke-152', 'user152@gmail.com', NULL, '$2y$10$vTf4sXuXynWwBM.59L0.heYWrwjQh4gaXtO.GoFJyq8gxgO8NyEvW', NULL, NULL, '2024-05-20 20:33:05', '2024-05-20 20:33:05'),
(169, 'User Ke-153', 'user153@gmail.com', NULL, '$2y$10$ngvuBkl9AH2dcC45SWCZXukMuQ/XmcL5waD6E0ficG4Fl0Gbg9FA6', NULL, NULL, '2024-05-20 20:33:05', '2024-05-20 20:33:05'),
(170, 'User Ke-154', 'user154@gmail.com', NULL, '$2y$10$Pyf2jiWTM.z3dn4eQoHOpO7rNdyg3RzdT/cLRD6GvY1RY3uyRmdHe', NULL, NULL, '2024-05-20 20:33:05', '2024-05-20 20:33:05'),
(171, 'User Ke-155', 'user155@gmail.com', NULL, '$2y$10$7Z/876WB44ZPAsgbbH6Rr.069loKDlerGvHfX/VjGTTPREvyDBBz6', NULL, NULL, '2024-05-20 20:33:05', '2024-05-20 20:33:05'),
(172, 'User Ke-156', 'user156@gmail.com', NULL, '$2y$10$T9URfJu1Lp2GBIPYWFUlau.9nvf88aeWywq5SansCAmYQoFYDWMt.', NULL, NULL, '2024-05-20 20:33:06', '2024-05-20 20:33:06'),
(173, 'User Ke-157', 'user157@gmail.com', NULL, '$2y$10$1CnSmjklDLW9WZU872HMl.z/knB5BAAJeUE9KiQAum88KVB8rLA7S', NULL, NULL, '2024-05-20 20:33:06', '2024-05-20 20:33:06'),
(174, 'User Ke-158', 'user158@gmail.com', NULL, '$2y$10$Km/TiodxMXUcX69EkXvireDpYqlheScDkdf23h4/VsM4Bpdf3jgXS', NULL, NULL, '2024-05-20 20:33:06', '2024-05-20 20:33:06'),
(175, 'User Ke-159', 'user159@gmail.com', NULL, '$2y$10$QchMqEAEHXTHIakcAGAW6e/fgNgr.hDhsxODvZXbHEldeWIJNmWmS', NULL, NULL, '2024-05-20 20:33:06', '2024-05-20 20:33:06'),
(176, 'User Ke-160', 'user160@gmail.com', NULL, '$2y$10$iVyKz7xU80nNFpLEbVpLhuwY7Zsy0JUWkvw8SLV8yDaxk5llKIXKm', NULL, NULL, '2024-05-20 20:33:06', '2024-05-20 20:33:06'),
(177, 'User Ke-161', 'user161@gmail.com', NULL, '$2y$10$dGK0Vlh1XwPdZzcNHEcl4.5ptmwShsDM.3fzWa4666bv5x.THS9QW', NULL, NULL, '2024-05-20 20:33:06', '2024-05-20 20:33:06'),
(178, 'User Ke-162', 'user162@gmail.com', NULL, '$2y$10$M0fAhSmDMQ.o4Sj/KS3p6OUa71hOu6HdCfvkYaw6A8A0iGFhei5x6', NULL, NULL, '2024-05-20 20:33:06', '2024-05-20 20:33:06'),
(179, 'User Ke-163', 'user163@gmail.com', NULL, '$2y$10$AhTVG17/YY37MyAWXhusbenDYbShyN4R7Cp0FG4wDjfCWfvfUXHqq', NULL, NULL, '2024-05-20 20:33:06', '2024-05-20 20:33:06'),
(180, 'User Ke-164', 'user164@gmail.com', NULL, '$2y$10$y13mT3bT0HkKyfymKZgGceJLaunNglY930it/ifyNK7sTNf.MU6Ra', NULL, NULL, '2024-05-20 20:33:06', '2024-05-20 20:33:06'),
(181, 'User Ke-165', 'user165@gmail.com', NULL, '$2y$10$0xhntax933sUoCvWJxpxX.KzUw.7wGBQZAKfdXFBBTysyZVdQkQ7W', NULL, NULL, '2024-05-20 20:33:06', '2024-05-20 20:33:06'),
(182, 'User Ke-166', 'user166@gmail.com', NULL, '$2y$10$yWVSzfvvcq3KsXDGBxTbAeR7x3mokUdYlvZgZltw6mRIRiwfQV/9a', NULL, NULL, '2024-05-20 20:33:06', '2024-05-20 20:33:06'),
(183, 'User Ke-167', 'user167@gmail.com', NULL, '$2y$10$0orPrN09p9jB9ORCQAt15u.3k1i1y1H/32KV/NuGgr0FwS7iOcm7q', NULL, NULL, '2024-05-20 20:33:07', '2024-05-20 20:33:07'),
(184, 'User Ke-168', 'user168@gmail.com', NULL, '$2y$10$9ubmw8Ef/hhyEJ0ya/uVgOmYgnHMzRLXMTfL7w1JRFDjVpciCR9EK', NULL, NULL, '2024-05-20 20:33:07', '2024-05-20 20:33:07'),
(185, 'User Ke-169', 'user169@gmail.com', NULL, '$2y$10$jzewTLeF5olePfhdou.nZ.PENIHZBZDTkFEZd96gofeFRnfJOREde', NULL, NULL, '2024-05-20 20:33:07', '2024-05-20 20:33:07'),
(186, 'User Ke-170', 'user170@gmail.com', NULL, '$2y$10$YQ4V7yJzJLfX3JU4gRBi/.SrZzdIFnU1GmhthT9gv4np3z0uwRKBa', NULL, NULL, '2024-05-20 20:33:07', '2024-05-20 20:33:07'),
(187, 'User Ke-171', 'user171@gmail.com', NULL, '$2y$10$fVU1qdWkApUsjjFn0WFAKuYgMql9Dypk8ZUx8F2t2gC4YK69XgIJu', NULL, NULL, '2024-05-20 20:33:07', '2024-05-20 20:33:07'),
(188, 'User Ke-172', 'user172@gmail.com', NULL, '$2y$10$oO0K42CK7S7QMADwfFRtc.lu45sq7H4MsbZjziibxk65hfFSfWMQ.', NULL, NULL, '2024-05-20 20:33:07', '2024-05-20 20:33:07'),
(189, 'User Ke-173', 'user173@gmail.com', NULL, '$2y$10$hVPqhp7EgCuLL.ZLMVpo9.nhXQ4mHVj0WyyQv.pwJG9TDcWjWrdpi', NULL, NULL, '2024-05-20 20:33:07', '2024-05-20 20:33:07'),
(190, 'User Ke-174', 'user174@gmail.com', NULL, '$2y$10$Z5F8deaW9JKo/xFazCamJu7BsaV9kN2aYjuff7KclFi/W.3OsPL16', NULL, NULL, '2024-05-20 20:33:07', '2024-05-20 20:33:07'),
(191, 'User Ke-175', 'user175@gmail.com', NULL, '$2y$10$O.fUlHcyuX5ofMDV247OPOEajz.6YGL0tJ6wo.Den6zIGEBjoZ7ka', NULL, NULL, '2024-05-20 20:33:07', '2024-05-20 20:33:07'),
(192, 'User Ke-176', 'user176@gmail.com', NULL, '$2y$10$N8avLjiqX6oAfOOaY702Put38maGSoASsX53.EI/FeZjMQrpeiSjq', NULL, NULL, '2024-05-20 20:33:07', '2024-05-20 20:33:07'),
(193, 'User Ke-177', 'user177@gmail.com', NULL, '$2y$10$xPAgq3QGxse9UdXxOEeyqeJN2suhdp5Wvn1DhlzRaUC3iCQdFSHce', NULL, NULL, '2024-05-20 20:33:08', '2024-05-20 20:33:08'),
(194, 'User Ke-178', 'user178@gmail.com', NULL, '$2y$10$ddhZz2DXfT010f1kg1/F1OaNFKqb13sJWqOYCOyoQikgdSwYPh7OS', NULL, NULL, '2024-05-20 20:33:08', '2024-05-20 20:33:08'),
(195, 'User Ke-179', 'user179@gmail.com', NULL, '$2y$10$qdIRJV.bSRv71kqHTn3LVufnTQkkH2XMvbwUzIaECpxFIwCUIEqZ6', NULL, NULL, '2024-05-20 20:33:08', '2024-05-20 20:33:08'),
(196, 'User Ke-180', 'user180@gmail.com', NULL, '$2y$10$K3dhdPkUuoduchrAaHiOoeg67w2webtT7qkU9/t4iBsv2hjwlaCGC', NULL, NULL, '2024-05-20 20:33:08', '2024-05-20 20:33:08'),
(197, 'User Ke-181', 'user181@gmail.com', NULL, '$2y$10$4Rlmljfo2qyfIfjZE1SAheYL8i7I8a.fZS7bFkstrTZJdbgRfdqPq', NULL, NULL, '2024-05-20 20:33:08', '2024-05-20 20:33:08'),
(198, 'User Ke-182', 'user182@gmail.com', NULL, '$2y$10$s7TyKIhtkCQi8axj5hXvLuUQ/xSaGNxi0GXQJIKUaJYF8gZzL8jzu', NULL, NULL, '2024-05-20 20:33:08', '2024-05-20 20:33:08'),
(199, 'User Ke-183', 'user183@gmail.com', NULL, '$2y$10$p2eDbqhmc4Oh3tYo09/X2.Bp7TDs10k4.OEZjXbeoqKihdEqGvBTS', NULL, NULL, '2024-05-20 20:33:08', '2024-05-20 20:33:08'),
(200, 'User Ke-184', 'user184@gmail.com', NULL, '$2y$10$fMZZv.uQ7GtdDXEt18RD3OCtm86xte6OQV4mdnpRbpus0y96DFfuS', NULL, NULL, '2024-05-20 20:33:08', '2024-05-20 20:33:08'),
(201, 'User Ke-185', 'user185@gmail.com', NULL, '$2y$10$KXflohZhJKXNEp2PVzmSmuZVEq2SBmFWQLvLGBc8wqJ3F0.5t.OvS', NULL, NULL, '2024-05-20 20:33:08', '2024-05-20 20:33:08'),
(202, 'User Ke-186', 'user186@gmail.com', NULL, '$2y$10$GrbIaLbD60SxxHb.PJalsuJCCBevtjzmJdarXFTwOsQP3HhCPaI8K', NULL, NULL, '2024-05-20 20:33:08', '2024-05-20 20:33:08'),
(203, 'User Ke-187', 'user187@gmail.com', NULL, '$2y$10$lVOsI1oKOi5fVbDKgeren.U8OTHJVjbsk3fBattYrmCMGy1MVUT2i', NULL, NULL, '2024-05-20 20:33:08', '2024-05-20 20:33:08'),
(204, 'User Ke-188', 'user188@gmail.com', NULL, '$2y$10$MGqGLV7YFgZqnoZZzhA2Bew1sasGtLfBwLN76b9CEWOul2XKaUNim', NULL, NULL, '2024-05-20 20:33:09', '2024-05-20 20:33:09'),
(205, 'User Ke-189', 'user189@gmail.com', NULL, '$2y$10$CGpL5.jvPv7aAfkiZv0Pv.6rrLaTOF.rZ2/IRZbR/ySWL4J9vMpI.', NULL, NULL, '2024-05-20 20:33:09', '2024-05-20 20:33:09'),
(206, 'User Ke-190', 'user190@gmail.com', NULL, '$2y$10$gGkJZmxrAQhbym9NPZpz3ukHtrVQqnyk1OtaZ5FGTJrFuvKW/WraW', NULL, NULL, '2024-05-20 20:33:09', '2024-05-20 20:33:09'),
(207, 'User Ke-191', 'user191@gmail.com', NULL, '$2y$10$TjOSy6TgdBiVUTKkdf8DWe4I8YxJlxUwvl9FyfSGLkD8IWuYjuN26', NULL, NULL, '2024-05-20 20:33:09', '2024-05-20 20:33:09'),
(208, 'User Ke-192', 'user192@gmail.com', NULL, '$2y$10$ix851b.OPdojvqLrB9TXcuMsYNqsyuplobeFIEH0COtLvEo7jxDJ.', NULL, NULL, '2024-05-20 20:33:09', '2024-05-20 20:33:09'),
(209, 'User Ke-193', 'user193@gmail.com', NULL, '$2y$10$/ospgg8MX1TxZIpMFxH2runSj.JXniHAtnRwP0Nd90a/PxTMLFJKK', NULL, NULL, '2024-05-20 20:33:09', '2024-05-20 20:33:09'),
(210, 'User Ke-194', 'user194@gmail.com', NULL, '$2y$10$a7pUZAtAV0hT66s5dM.L9eQ3J08rJolQPSoXGPPHmhrjzq5jfSXyW', NULL, NULL, '2024-05-20 20:33:09', '2024-05-20 20:33:09'),
(211, 'User Ke-195', 'user195@gmail.com', NULL, '$2y$10$rfe3NxtrGrVWwROrt86Q6.jsGdUyYEpqDlk1vmxPZCCbRepGf/TCO', NULL, NULL, '2024-05-20 20:33:09', '2024-05-20 20:33:09'),
(212, 'User Ke-196', 'user196@gmail.com', NULL, '$2y$10$acZscthu1C1MLO1/Qr2iUeSQMK0yhPY8s9KEV5zXhl1fIsUiUiZKa', NULL, NULL, '2024-05-20 20:33:09', '2024-05-20 20:33:09'),
(213, 'User Ke-197', 'user197@gmail.com', NULL, '$2y$10$8VuUX9XLLcChaFX6PfQfOexGCa4ChBYoW.MNQoYvUMuFYB22.93wm', NULL, NULL, '2024-05-20 20:33:09', '2024-05-20 20:33:09'),
(214, 'User Ke-198', 'user198@gmail.com', NULL, '$2y$10$ItFSe667LWpyKgsq.zN/Mutx99D7eB/3Q5ZYv89Vqo0wcZsg1puZu', NULL, NULL, '2024-05-20 20:33:09', '2024-05-20 20:33:09'),
(215, 'User Ke-199', 'user199@gmail.com', NULL, '$2y$10$GsUkBlkZUI2cVqMjLiyy/O19NijLyx2l39oRLBM3dlsll9lNJ5rFu', NULL, NULL, '2024-05-20 20:33:09', '2024-05-20 20:33:09'),
(216, 'User Ke-200', 'user200@gmail.com', NULL, '$2y$10$/U1hI3e1ZPvVVkAExTYDqO64.WbdbjhKXyZ1881MsuRYtA8dZeFt.', NULL, NULL, '2024-05-20 20:33:10', '2024-05-20 20:33:10'),
(217, 'User Ke-201', 'user201@gmail.com', NULL, '$2y$10$6t3EPp2uJLckBzsV3S558.1wPo4FFkdKd8CmQ0VKW9qyMVUsgbW6m', NULL, NULL, '2024-05-20 20:33:10', '2024-05-20 20:33:10'),
(218, 'User Ke-202', 'user202@gmail.com', NULL, '$2y$10$8oCqP2dU9R2YQkKHtlzftOUuw03b7KXk.zqJhg.TGYuHKrMXHoG7m', NULL, NULL, '2024-05-20 20:33:10', '2024-05-20 20:33:10'),
(219, 'User Ke-203', 'user203@gmail.com', NULL, '$2y$10$ill4B4lSZODESgvcX2WXruMZFnrdi3sIHp713eNoLjsD7QFlAQEk6', NULL, NULL, '2024-05-20 20:33:10', '2024-05-20 20:33:10'),
(220, 'User Ke-204', 'user204@gmail.com', NULL, '$2y$10$h2Qj94rbOUKnwytCJEKWKuwjnzNfTpsL.46KK4VR3gRTV5nlwIqDS', NULL, NULL, '2024-05-20 20:33:10', '2024-05-20 20:33:10'),
(221, 'User Ke-205', 'user205@gmail.com', NULL, '$2y$10$g6O05WDVZwI9Rn0z7MWsUuPHUKRWLrgBhqgImJhHU/szfjNZFJvT2', NULL, NULL, '2024-05-20 20:33:10', '2024-05-20 20:33:10'),
(222, 'User Ke-206', 'user206@gmail.com', NULL, '$2y$10$vhLbeJfyvDfcvCTJzhe8NOVVCvdgBEamzvTz1LRRgEencio4bSf/y', NULL, NULL, '2024-05-20 20:33:10', '2024-05-20 20:33:10'),
(223, 'User Ke-207', 'user207@gmail.com', NULL, '$2y$10$5aNu4h2IjUtUlz24rd3.0eSbvENfLTZoLfhIO6WxYdt1UYv2p8uIC', NULL, NULL, '2024-05-20 20:33:10', '2024-05-20 20:33:10'),
(224, 'User Ke-208', 'user208@gmail.com', NULL, '$2y$10$pIcSCW.ESibNJgh7hZloS.KGfYa.HEXmqmYIJuzre4zU41HRYwb06', NULL, NULL, '2024-05-20 20:33:10', '2024-05-20 20:33:10'),
(225, 'User Ke-209', 'user209@gmail.com', NULL, '$2y$10$YCqLq7C4utOrgRBdrdzh4.ZMPvsQvk6sROR3Sr9n2IhE/Cw.17oMu', NULL, NULL, '2024-05-20 20:33:10', '2024-05-20 20:33:10'),
(226, 'User Ke-210', 'user210@gmail.com', NULL, '$2y$10$yMjt2jSZ1fBGEW.vqOHTO.BKmQxpnMW7HUOj9LJ4P1/ndkzmMQa6m', NULL, NULL, '2024-05-20 20:33:10', '2024-05-20 20:33:10'),
(227, 'User Ke-211', 'user211@gmail.com', NULL, '$2y$10$S7nvWuUJo3YPdyxMQzuWWeDmsuBMfLr2jb7eOXl93caWI8zAjYjqS', NULL, NULL, '2024-05-20 20:33:11', '2024-05-20 20:33:11'),
(228, 'User Ke-212', 'user212@gmail.com', NULL, '$2y$10$uWwOGSHOaHieYS5n9lQz3OwxHTs897R/1mFopvkE32hZLIXstmc7i', NULL, NULL, '2024-05-20 20:33:11', '2024-05-20 20:33:11'),
(229, 'User Ke-213', 'user213@gmail.com', NULL, '$2y$10$r2.c17gz3z1C900YgF9CPeikgL9qvKJHoL.n38AJcx86Tb7iZxS5W', NULL, NULL, '2024-05-20 20:33:11', '2024-05-20 20:33:11'),
(230, 'User Ke-214', 'user214@gmail.com', NULL, '$2y$10$YWUWUWIe7GjB8OIh90GZ/efesTxui0pEn4VjGbDghlvPYWuoWPV5u', NULL, NULL, '2024-05-20 20:33:11', '2024-05-20 20:33:11'),
(231, 'User Ke-215', 'user215@gmail.com', NULL, '$2y$10$QA5K9nafCdgZyxZ0Y3zJ7.bMbhxADXvsHaMnbsegFNEVnHJpK3sfW', NULL, NULL, '2024-05-20 20:33:11', '2024-05-20 20:33:11'),
(232, 'User Ke-216', 'user216@gmail.com', NULL, '$2y$10$X0J19OHVIQo4Ij5LeLvLqeZOe4q97qB2swMk4VEf7UQvCwvDG/37a', NULL, NULL, '2024-05-20 20:33:11', '2024-05-20 20:33:11'),
(233, 'User Ke-217', 'user217@gmail.com', NULL, '$2y$10$L4wdGxbIo8DhrtiNi2Wle.RH6PAh1SFcm3yokAVSpQ7pe/zxCosGO', NULL, NULL, '2024-05-20 20:33:11', '2024-05-20 20:33:11'),
(234, 'User Ke-218', 'user218@gmail.com', NULL, '$2y$10$CIzif2RNJAG1uRaamSiTR.nWOOuZPNXkwKxld7HRpPoyqIGxwtzcG', NULL, NULL, '2024-05-20 20:33:11', '2024-05-20 20:33:11'),
(235, 'User Ke-219', 'user219@gmail.com', NULL, '$2y$10$J6SFS/0tpp/QMPxyiefBMe6AFjzUR4BjXTbYylL8gYPmkM1wQzBEe', NULL, NULL, '2024-05-20 20:33:11', '2024-05-20 20:33:11'),
(236, 'User Ke-220', 'user220@gmail.com', NULL, '$2y$10$OsYnINz/rwbkA7blDhswBOlai3W1c7N85JV78dndV96wp1jZNmS2W', NULL, NULL, '2024-05-20 20:33:11', '2024-05-20 20:33:11'),
(237, 'User Ke-221', 'user221@gmail.com', NULL, '$2y$10$va93uneqdkobaVaALm9Rku9p75Tf8lhSxxi19Lvg20QaG09O/AcmC', NULL, NULL, '2024-05-20 20:33:11', '2024-05-20 20:33:11'),
(238, 'User Ke-222', 'user222@gmail.com', NULL, '$2y$10$ZT8YvjJnHavVRb7rcCSx9uVdyvuZWxIEIUvWxSz5Or3Ei5nqe5P4m', NULL, NULL, '2024-05-20 20:33:12', '2024-05-20 20:33:12'),
(239, 'User Ke-223', 'user223@gmail.com', NULL, '$2y$10$3BWZl20fos.AXMyVGhN8RuQc.l6YfTQ23A8Nec/Jv.tPwAIldkUAC', NULL, NULL, '2024-05-20 20:33:12', '2024-05-20 20:33:12'),
(240, 'User Ke-224', 'user224@gmail.com', NULL, '$2y$10$LVQuZ.DaYKEv2yQhQErhO.kh7iGLAywiaeUBBPeAX/iDtTu7V9dya', NULL, NULL, '2024-05-20 20:33:12', '2024-05-20 20:33:12'),
(241, 'User Ke-225', 'user225@gmail.com', NULL, '$2y$10$cMob3xxz4qpjSV8L3smlfeImhvChB7HhrFjKE4gz1i2.rzlv0vsTq', NULL, NULL, '2024-05-20 20:33:12', '2024-05-20 20:33:12'),
(242, 'User Ke-226', 'user226@gmail.com', NULL, '$2y$10$AZAtG5IjxnDfGIGbRoonWOiEcTGdwmZyKSjgeIONdElQXU5hzBJqu', NULL, NULL, '2024-05-20 20:33:12', '2024-05-20 20:33:12'),
(243, 'User Ke-227', 'user227@gmail.com', NULL, '$2y$10$QCaJhmiUiYBqfwQnueIW.euwM76CIGgzaplzDLvPLqt3awFWoaVgK', NULL, NULL, '2024-05-20 20:33:12', '2024-05-20 20:33:12'),
(244, 'User Ke-228', 'user228@gmail.com', NULL, '$2y$10$4UWKmuX4GmfELRNISvEtSO9Z4usdikS1SlEfpVKmMD93XR6GYjefa', NULL, NULL, '2024-05-20 20:33:12', '2024-05-20 20:33:12'),
(245, 'User Ke-229', 'user229@gmail.com', NULL, '$2y$10$9lO5i1ofXG10pRWLkaKGJu4gi6KS1FduS9pk6l.gCosYK.wfkUivW', NULL, NULL, '2024-05-20 20:33:12', '2024-05-20 20:33:12'),
(246, 'User Ke-230', 'user230@gmail.com', NULL, '$2y$10$wq5LIkpAbsit2LSYJSiTB.gfO67PzwZZ44OlymRSs26X5WEeMx/yq', NULL, NULL, '2024-05-20 20:33:12', '2024-05-20 20:33:12'),
(247, 'User Ke-231', 'user231@gmail.com', NULL, '$2y$10$BoEHyV04GGTIg2N3iTsFD.U4xNpKAklya2EmJRy84dlaWoD/RN8Ua', NULL, NULL, '2024-05-20 20:33:12', '2024-05-20 20:33:12'),
(248, 'User Ke-232', 'user232@gmail.com', NULL, '$2y$10$9nXz9ay1VWdH3eyxNDvQS.nudJys/Wti.Sc6cKyXoVWYVfzcJmjjS', NULL, NULL, '2024-05-20 20:33:12', '2024-05-20 20:33:12'),
(249, 'User Ke-233', 'user233@gmail.com', NULL, '$2y$10$jwHlK6BGP9qU/PztjnpLse2yN5PKpJ0uog5q0XfKZCidaPbmqQFhm', NULL, NULL, '2024-05-20 20:33:12', '2024-05-20 20:33:12'),
(250, 'User Ke-234', 'user234@gmail.com', NULL, '$2y$10$6Om7PfFFe0YoJCP7it8.DO8ixknOPc1DDEYwgf2lCmmK5bJAI3nxq', NULL, NULL, '2024-05-20 20:33:13', '2024-05-20 20:33:13'),
(251, 'User Ke-235', 'user235@gmail.com', NULL, '$2y$10$2Pi9FI7lPsn/2CJDtImiXeC1qG22X6NmpI1sOK9H3rUbd1WG6Kkoq', NULL, NULL, '2024-05-20 20:33:13', '2024-05-20 20:33:13'),
(252, 'User Ke-236', 'user236@gmail.com', NULL, '$2y$10$.5PQb/rf5z74J5bdtXn/B.9HqfqOUz1kLTWyR7rtL2PkhjfpQyEJ.', NULL, NULL, '2024-05-20 20:33:13', '2024-05-20 20:33:13'),
(253, 'User Ke-237', 'user237@gmail.com', NULL, '$2y$10$Mbea6JGWKvnKhl/HiGN7TOPPtpVuyVIbuqOgvKFWFstZNKQAeaodq', NULL, NULL, '2024-05-20 20:33:13', '2024-05-20 20:33:13'),
(254, 'User Ke-238', 'user238@gmail.com', NULL, '$2y$10$TMcTySeLh96FukAxmqGkQObmQBgiysn4eZGI4qXak8UnRHEkLSapC', NULL, NULL, '2024-05-20 20:33:13', '2024-05-20 20:33:13'),
(255, 'User Ke-239', 'user239@gmail.com', NULL, '$2y$10$JqtTVBLAl3yhIC1oiiWVku1USdVHhWKM.SYMWj.Mi1a.1JQrYC91u', NULL, NULL, '2024-05-20 20:33:13', '2024-05-20 20:33:13'),
(256, 'User Ke-240', 'user240@gmail.com', NULL, '$2y$10$YkQbgdQpkYcI3vYvSEjT8evcdqDJmZN0zCDcDqARWvMxadTZmWlIW', NULL, NULL, '2024-05-20 20:33:13', '2024-05-20 20:33:13'),
(257, 'User Ke-241', 'user241@gmail.com', NULL, '$2y$10$bOe8GxORoGUIjjrjFwtiueSFlhcX5Fi3zaEFur5oIwtdfEb/F2IgS', NULL, NULL, '2024-05-20 20:33:13', '2024-05-20 20:33:13'),
(258, 'User Ke-242', 'user242@gmail.com', NULL, '$2y$10$J4SFmpNCjwy2dqCpbfyKKeArJoTBNzU5sp5cYpj1wCK39FtpkS0cO', NULL, NULL, '2024-05-20 20:33:13', '2024-05-20 20:33:13'),
(259, 'User Ke-243', 'user243@gmail.com', NULL, '$2y$10$RZAm4tmpNmBBiSAkIU1hEumjIa.QPzg3oMZTr7OBrIvWC.SAFVmI2', NULL, NULL, '2024-05-20 20:33:13', '2024-05-20 20:33:13'),
(260, 'User Ke-244', 'user244@gmail.com', NULL, '$2y$10$upaY9Y9RHjvQ4eUp8Zxq1.GEefIDjd43hQZrCq42VFeQr4JXwRYt6', NULL, NULL, '2024-05-20 20:33:13', '2024-05-20 20:33:13'),
(261, 'User Ke-245', 'user245@gmail.com', NULL, '$2y$10$PRYUhEW3whMg01PBr1BG.uCshH5n5EpO1XC5bMb7yl5eQYF0HGFuW', NULL, NULL, '2024-05-20 20:33:14', '2024-05-20 20:33:14'),
(262, 'User Ke-246', 'user246@gmail.com', NULL, '$2y$10$7.1QKuG.zYq6HHIi/h0WR.Lvy0ldEtLLAg/66Sm6GCSwqAFOYvOR6', NULL, NULL, '2024-05-20 20:33:14', '2024-05-20 20:33:14'),
(263, 'User Ke-247', 'user247@gmail.com', NULL, '$2y$10$UvIVnI100JMlcpSjYZgZneufqcAcORYpt9R9Mhnsn6VgKYwNCEGRa', NULL, NULL, '2024-05-20 20:33:14', '2024-05-20 20:33:14'),
(264, 'User Ke-248', 'user248@gmail.com', NULL, '$2y$10$mfmQPY29i.eaHIDLZ2EKXuFlJ7GNZkf8xsBIBeR2tf8NWJjD9dmku', NULL, NULL, '2024-05-20 20:33:14', '2024-05-20 20:33:14'),
(265, 'User Ke-249', 'user249@gmail.com', NULL, '$2y$10$keDABxXA8OAg4DUnKrLqyuJqaQibQ.krCF6nQVhpWMI7YmtFvjZA.', NULL, NULL, '2024-05-20 20:33:14', '2024-05-20 20:33:14'),
(266, 'User Ke-250', 'user250@gmail.com', NULL, '$2y$10$TxYwx6tY5WQzOdojI3UWmeTLFVLvU3jXUIH5BwgYz1eLbLiqOQe6i', NULL, NULL, '2024-05-20 20:33:14', '2024-05-20 20:33:14'),
(267, 'User Ke-251', 'user251@gmail.com', NULL, '$2y$10$dcwHHI.HWlir84Wv950Qj.ywBl2zdVLzFOJ2JKgLUK79pAuPma80C', NULL, NULL, '2024-05-20 20:33:14', '2024-05-20 20:33:14'),
(268, 'User Ke-252', 'user252@gmail.com', NULL, '$2y$10$3DwUZ58YFUYM4RfYBkY8TelqWZEC6acJboTCPAMbTCRRk24Jb1HY.', NULL, NULL, '2024-05-20 20:33:14', '2024-05-20 20:33:14'),
(269, 'User Ke-253', 'user253@gmail.com', NULL, '$2y$10$b3UqpUaiXVP/XWyJFh6d4ORZaspZPWihUtReftW1XmMYQb0FNksoS', NULL, NULL, '2024-05-20 20:33:14', '2024-05-20 20:33:14'),
(270, 'User Ke-254', 'user254@gmail.com', NULL, '$2y$10$XX4hPAOasQzcIc27xBlHv.eJoridQd5VlBRHVJmfyEUHsNaO9f9rC', NULL, NULL, '2024-05-20 20:33:14', '2024-05-20 20:33:14'),
(271, 'User Ke-255', 'user255@gmail.com', NULL, '$2y$10$jRbv/2x93Og2SI293hsTP.7BylNsop80I1/XAeB5ilZ0pH2zDdS5.', NULL, NULL, '2024-05-20 20:33:14', '2024-05-20 20:33:14'),
(272, 'User Ke-256', 'user256@gmail.com', NULL, '$2y$10$fG2ohQCQRr6MmtrGVSvcVunhCmR5XsGQDSCwAbigLgyytGnKdaM16', NULL, NULL, '2024-05-20 20:33:15', '2024-05-20 20:33:15'),
(273, 'User Ke-257', 'user257@gmail.com', NULL, '$2y$10$FkTf1DrYyKjcBeUnmzqul.yLhwnt/zv5zOetSCpyCeLkV/ITcxWQW', NULL, NULL, '2024-05-20 20:33:15', '2024-05-20 20:33:15'),
(274, 'User Ke-258', 'user258@gmail.com', NULL, '$2y$10$ON26nRVqXgBbBswcAynsa.OhiXcEyBgn0JVMvxMQ2g.HT/Xcwbib2', NULL, NULL, '2024-05-20 20:33:15', '2024-05-20 20:33:15'),
(275, 'User Ke-259', 'user259@gmail.com', NULL, '$2y$10$CyXpu.N497gYBK.Kz18aqezG7EaVCyolI/NoFOjCa800H1hZUsjhi', NULL, NULL, '2024-05-20 20:33:15', '2024-05-20 20:33:15'),
(276, 'User Ke-260', 'user260@gmail.com', NULL, '$2y$10$3Y7psjo0kxKIGaImZcNym.TdtmWNdmvCGvpPqPlwtvFnffwMCjzYy', NULL, NULL, '2024-05-20 20:33:15', '2024-05-20 20:33:15'),
(277, 'User Ke-261', 'user261@gmail.com', NULL, '$2y$10$spVD8EXO3T9VEK9aTn7f4.z2cIh6l.E3sStNyDTrlCB6SqMV4AWJm', NULL, NULL, '2024-05-20 20:33:15', '2024-05-20 20:33:15'),
(278, 'User Ke-262', 'user262@gmail.com', NULL, '$2y$10$CZGTaEIUy7Jdx3096Yan0OcSYWW/k4ArkyQYrsVUqpoSoTZnF2zjG', NULL, NULL, '2024-05-20 20:33:15', '2024-05-20 20:33:15'),
(279, 'User Ke-263', 'user263@gmail.com', NULL, '$2y$10$f2r27BOukP9m.lP5qt3uHOL4lQ14robO1jh0UeO0SwMqJ/1oWyv5W', NULL, NULL, '2024-05-20 20:33:15', '2024-05-20 20:33:15'),
(280, 'User Ke-264', 'user264@gmail.com', NULL, '$2y$10$PiBV/HtM2nuh4n0AzvuxMuFwYs8rpMVdaGs3OjL4INmqEwPzyzU9u', NULL, NULL, '2024-05-20 20:33:15', '2024-05-20 20:33:15'),
(281, 'User Ke-265', 'user265@gmail.com', NULL, '$2y$10$hvwaOO1VjVrGgOnL20BAjOCezdtg.EMjQ9qIk9M/jvLT.StoaXTuG', NULL, NULL, '2024-05-20 20:33:15', '2024-05-20 20:33:15'),
(282, 'User Ke-266', 'user266@gmail.com', NULL, '$2y$10$a1k8fSLg3x86Uh5TVy.b8uJluBDEsQVNNPxVJJaznTl4fGKF4gioO', NULL, NULL, '2024-05-20 20:33:15', '2024-05-20 20:33:15'),
(283, 'User Ke-267', 'user267@gmail.com', NULL, '$2y$10$gusafyxxD13Gxi7m1KvfDeES.MeumyH70aUvQKzh0uPmwDr/NvWla', NULL, NULL, '2024-05-20 20:33:15', '2024-05-20 20:33:15'),
(284, 'User Ke-268', 'user268@gmail.com', NULL, '$2y$10$m5MrRqxahtPyaThiWpaJHub0EwAJpB3oEddkIjTVkZK0WplrefChC', NULL, NULL, '2024-05-20 20:33:16', '2024-05-20 20:33:16'),
(285, 'User Ke-269', 'user269@gmail.com', NULL, '$2y$10$1y0g8B.6Ff.W1pogyoQfCesBwKZlOufubEIdmSaVoQXZMKqfVz6Ye', NULL, NULL, '2024-05-20 20:33:16', '2024-05-20 20:33:16'),
(286, 'User Ke-270', 'user270@gmail.com', NULL, '$2y$10$PnuTxTvktVA0PidGT3Dsj.Wxxh2n.cnKBf1IOeQxq5nowH9q61jAS', NULL, NULL, '2024-05-20 20:33:16', '2024-05-20 20:33:16'),
(287, 'User Ke-271', 'user271@gmail.com', NULL, '$2y$10$XN.DKBawk.nn3uT2dg/ynO599Lqb.pBS4ZQmaujrl3VPrvSZLv8cS', NULL, NULL, '2024-05-20 20:33:16', '2024-05-20 20:33:16'),
(288, 'User Ke-272', 'user272@gmail.com', NULL, '$2y$10$bfiPmt3lQe6jS7dIli3NgOoVmLfBpVMG/ch.bpclhiz7fEVxloHem', NULL, NULL, '2024-05-20 20:33:16', '2024-05-20 20:33:16'),
(289, 'User Ke-273', 'user273@gmail.com', NULL, '$2y$10$1hG4.zK6mzgpAqPf3Tt7.uEW34Q4Fpz/8sLecDMYxgrT3ieA/Y0Ri', NULL, NULL, '2024-05-20 20:33:16', '2024-05-20 20:33:16'),
(290, 'User Ke-274', 'user274@gmail.com', NULL, '$2y$10$SWkVxrZSnoCaS.kD1bsd2eIjurnIJijhd.IINyH2J8QOTxXlzwheO', NULL, NULL, '2024-05-20 20:33:16', '2024-05-20 20:33:16'),
(291, 'User Ke-275', 'user275@gmail.com', NULL, '$2y$10$Y4rDcF/FGQH8BF4ZNt1bpOws8aCHUxD1sEyI/IRPw/gU0s4gYnN72', NULL, NULL, '2024-05-20 20:33:16', '2024-05-20 20:33:16'),
(292, 'User Ke-276', 'user276@gmail.com', NULL, '$2y$10$YHwT.FdHHK/WNSrx/PuK3OkTLCOFSqnUewj6UXW3xGBocm5TEg0YG', NULL, NULL, '2024-05-20 20:33:16', '2024-05-20 20:33:16'),
(293, 'User Ke-277', 'user277@gmail.com', NULL, '$2y$10$Y.owNdJ4zcakYKxPDBMete6Waq7D5C4Tjq.0riEoH3rGQSnrsUvAC', NULL, NULL, '2024-05-20 20:33:16', '2024-05-20 20:33:16'),
(294, 'User Ke-278', 'user278@gmail.com', NULL, '$2y$10$Xi/anQEaXqEDP4XkzK4b9OgqDDTU7f2QlMfDr0X8Aw.WruxEG9eUq', NULL, NULL, '2024-05-20 20:33:16', '2024-05-20 20:33:16'),
(295, 'User Ke-279', 'user279@gmail.com', NULL, '$2y$10$SmK264mjlL/APw0la6X.t.4a7cWcryfY7B/j1Woa.mM2Sa7eqj2eu', NULL, NULL, '2024-05-20 20:33:17', '2024-05-20 20:33:17'),
(296, 'User Ke-280', 'user280@gmail.com', NULL, '$2y$10$IKyMGjmbszLrHsKQdGSOjuAK9t3U6jd9luMQpJNQmJ/Kc55qUr8yK', NULL, NULL, '2024-05-20 20:33:17', '2024-05-20 20:33:17'),
(297, 'User Ke-281', 'user281@gmail.com', NULL, '$2y$10$JwTV8ZtLX63w/QWpDu/DQ.iP36k5ZaJUyJEeuhpqdYdjtYa8vKomS', NULL, NULL, '2024-05-20 20:33:17', '2024-05-20 20:33:17'),
(298, 'User Ke-282', 'user282@gmail.com', NULL, '$2y$10$uHFYAKNaH39hY1RYPjVbyeHcCinty/XAv82Nrw0BDvpM7MNjPZTti', NULL, NULL, '2024-05-20 20:33:17', '2024-05-20 20:33:17'),
(299, 'User Ke-283', 'user283@gmail.com', NULL, '$2y$10$hDCxvS.VaOxz79z6rj3uZ.uXE7fq5NTbgIt0jhrZ0DQ431fNqjBN2', NULL, NULL, '2024-05-20 20:33:17', '2024-05-20 20:33:17'),
(300, 'User Ke-284', 'user284@gmail.com', NULL, '$2y$10$O.KLOLxrC1ZM1VaRLMFVCO54ZvnArnMYVK2q12VcmBdLsVSBL/34y', NULL, NULL, '2024-05-20 20:33:17', '2024-05-20 20:33:17'),
(301, 'User Ke-285', 'user285@gmail.com', NULL, '$2y$10$5kaie8hcHvfRovWXiLbTgOXz/1d1sBnSO0BpFE8N.8DJIIyCc9qR6', NULL, NULL, '2024-05-20 20:33:17', '2024-05-20 20:33:17'),
(302, 'User Ke-286', 'user286@gmail.com', NULL, '$2y$10$0EHoluP5VSgl.cveSh9pke0dghb07SF53XxQCDmxNpbLyT2TkrK.6', NULL, NULL, '2024-05-20 20:33:17', '2024-05-20 20:33:17'),
(303, 'User Ke-287', 'user287@gmail.com', NULL, '$2y$10$VvcpWK1MjdD1Ho0S20RTAe/TGAW0vyduApPADElx4nxiMWwaPhDjy', NULL, NULL, '2024-05-20 20:33:17', '2024-05-20 20:33:17'),
(304, 'User Ke-288', 'user288@gmail.com', NULL, '$2y$10$cWVObZgYfIUaWxkxZ6wQLemGVac9Zrcml190UUwqelMN.CGN4QZiW', NULL, NULL, '2024-05-20 20:33:17', '2024-05-20 20:33:17'),
(305, 'User Ke-289', 'user289@gmail.com', NULL, '$2y$10$0av8G2y/wr/zuoF0KIGaVeI.1r29kOkDdZ2B7R8dr3Lb4czuDYes6', NULL, NULL, '2024-05-20 20:33:17', '2024-05-20 20:33:17');
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `image`, `created_at`, `updated_at`) VALUES
(306, 'User Ke-290', 'user290@gmail.com', NULL, '$2y$10$CEHXCDwdLBeXiD4CBCu76.cPF0z4W3mdCIF3S3Qfnx1edG7tyZtQS', NULL, NULL, '2024-05-20 20:33:17', '2024-05-20 20:33:17'),
(307, 'User Ke-291', 'user291@gmail.com', NULL, '$2y$10$QQBmu6sX2JZu66UMBLM9kObMtzTz.BgskoLXSbZc/N0jejeZHVw2S', NULL, NULL, '2024-05-20 20:33:18', '2024-05-20 20:33:18'),
(308, 'User Ke-292', 'user292@gmail.com', NULL, '$2y$10$6VBmumr1fHFfreAwtISxmOJDKlBXY6ex9StmDNhqMhdoQnxaDNbz6', NULL, NULL, '2024-05-20 20:33:18', '2024-05-20 20:33:18'),
(309, 'User Ke-293', 'user293@gmail.com', NULL, '$2y$10$EWZpW1DQKuEu3yiUszhd.upOdcq0DsVfePMcmeJAZCI/2ldL0H4MW', NULL, NULL, '2024-05-20 20:33:18', '2024-05-20 20:33:18'),
(310, 'User Ke-294', 'user294@gmail.com', NULL, '$2y$10$CKbmp9NCAOT8/DAyiHovm.zltKbCTjLHMuSaxycbLTLDAZb/wjjvG', NULL, NULL, '2024-05-20 20:33:18', '2024-05-20 20:33:18'),
(311, 'User Ke-295', 'user295@gmail.com', NULL, '$2y$10$3OU3aqhQygnqux7mzHA5TePX/4qjbInb4ovAHucTeaINylUfd2yZ.', NULL, NULL, '2024-05-20 20:33:18', '2024-05-20 20:33:18'),
(312, 'User Ke-296', 'user296@gmail.com', NULL, '$2y$10$N.M8f46Wtinqe/.mbsFkWuSSwcNdQZ09hzSMUMTIDnvfp6QjG5nze', NULL, NULL, '2024-05-20 20:33:18', '2024-05-20 20:33:18'),
(313, 'User Ke-297', 'user297@gmail.com', NULL, '$2y$10$hKZVzt4mMxnL9zI85Qr9V.HviB3.pZ76v1LqXRnPoD3aELF75Sg2y', NULL, NULL, '2024-05-20 20:33:18', '2024-05-20 20:33:18'),
(314, 'User Ke-298', 'user298@gmail.com', NULL, '$2y$10$BHF7oCSCGwe4fSxgWZI3A.fuPmK/URI/Q1gX8OV5iyntm6IgF2yhq', NULL, NULL, '2024-05-20 20:33:18', '2024-05-20 20:33:18'),
(315, 'User Ke-299', 'user299@gmail.com', NULL, '$2y$10$IfDc33MX236Et4Fk4fm12u5hES1V9FuuQ3JGa/fKXZyC/dg5.tN4O', NULL, NULL, '2024-05-20 20:33:18', '2024-05-20 20:33:18'),
(316, 'User Ke-300', 'user300@gmail.com', NULL, '$2y$10$uF5SOpRxwjiIz293owW1CeoT5lESEmw1/iVVUqSGdSHGSbX5ZfrP2', NULL, NULL, '2024-05-20 20:33:18', '2024-05-20 20:33:18'),
(317, 'User Ke-301', 'user301@gmail.com', NULL, '$2y$10$rfVjhz7p/iBVuEJPvpeOX.ejuxKOnfS6xxZsN75474KMMj9dFhIiG', NULL, NULL, '2024-05-20 20:33:18', '2024-05-20 20:33:18'),
(318, 'User Ke-302', 'user302@gmail.com', NULL, '$2y$10$HBv2xp.ZHpoSC8W4WTs95.WFd2hhMY1fY12eCBMsVG5rDDKyi4xe.', NULL, NULL, '2024-05-20 20:33:19', '2024-05-20 20:33:19'),
(319, 'User Ke-303', 'user303@gmail.com', NULL, '$2y$10$dqfRkRZH.g5cZVGuJ8GxQuwYsqnsTv2MPq9IenRfczhJKXuP9I.xK', NULL, NULL, '2024-05-20 20:33:19', '2024-05-20 20:33:19'),
(320, 'User Ke-304', 'user304@gmail.com', NULL, '$2y$10$Mi8N12SMoQ.h99TaZoqgC.aoMZLP97dp7iPC5ivB5lvmVyNO0aO1i', NULL, NULL, '2024-05-20 20:33:19', '2024-05-20 20:33:19'),
(321, 'User Ke-305', 'user305@gmail.com', NULL, '$2y$10$80ez3Oa/R2NNftX5C1wSz.lAfzovYzUHlwXxcWmv3Ro6nqn.IgCXG', NULL, NULL, '2024-05-20 20:33:19', '2024-05-20 20:33:19'),
(322, 'User Ke-306', 'user306@gmail.com', NULL, '$2y$10$oft.o.mVshQ4pSqFYsnCzuJasT5MUE4SIsS82XOnxZlu/RcuR268a', NULL, NULL, '2024-05-20 20:33:19', '2024-05-20 20:33:19'),
(323, 'User Ke-307', 'user307@gmail.com', NULL, '$2y$10$vzwDca71Dexqa8LJ1V9BOOH40SHGf1SaG/8vd1hCWBbOI8B7EHEyq', NULL, NULL, '2024-05-20 20:33:19', '2024-05-20 20:33:19'),
(324, 'User Ke-308', 'user308@gmail.com', NULL, '$2y$10$fa5SDe3NC4BJ3mGuV9wxs.UtA5eTOaZyYVN033/Y/qdLRCvJwaXzW', NULL, NULL, '2024-05-20 20:33:19', '2024-05-20 20:33:19'),
(325, 'User Ke-309', 'user309@gmail.com', NULL, '$2y$10$zY.mOt3p5yPNfxB5/gSpt.60XQv7B9Y6R/wsW3qEZq7C8LO34Oc4a', NULL, NULL, '2024-05-20 20:33:19', '2024-05-20 20:33:19'),
(326, 'User Ke-310', 'user310@gmail.com', NULL, '$2y$10$g6FSKqcyK4yBZWON8K1BxOLo.yM6D8nktj7yDPDPqK72oWxuKQNvi', NULL, NULL, '2024-05-20 20:33:19', '2024-05-20 20:33:19'),
(327, 'User Ke-311', 'user311@gmail.com', NULL, '$2y$10$0HmS8QVRD1Rar745ZwmEJuZDD8JFEWBHKVox8yZwQEzqnXVNRAA9S', NULL, NULL, '2024-05-20 20:33:19', '2024-05-20 20:33:19'),
(328, 'User Ke-312', 'user312@gmail.com', NULL, '$2y$10$.Shen8tM2xyCHKhsjuu8yuBsD3C41XuAjDjEiI8FaV9CPTT8vFt9m', NULL, NULL, '2024-05-20 20:33:19', '2024-05-20 20:33:19'),
(329, 'User Ke-313', 'user313@gmail.com', NULL, '$2y$10$N0r4IjfnHGoZ1TapmeQlfO3KncRSDF8ksCsoBFrQAVqDmG/L6xPYa', NULL, NULL, '2024-05-20 20:33:20', '2024-05-20 20:33:20'),
(330, 'User Ke-314', 'user314@gmail.com', NULL, '$2y$10$YgwsxgY56WkDdc3foFj7T.QLnRfl0oykj0nJ6guqIqrgd/5ZUw06W', NULL, NULL, '2024-05-20 20:33:20', '2024-05-20 20:33:20'),
(331, 'User Ke-315', 'user315@gmail.com', NULL, '$2y$10$YhWpTVisiW9HB8zNdgWTQevn3o/aIJ1VxaBIQ86g1a.e6aR6rKMMe', NULL, NULL, '2024-05-20 20:33:20', '2024-05-20 20:33:20'),
(332, 'User Ke-316', 'user316@gmail.com', NULL, '$2y$10$tZnmUDLxw9vywO/upKHJr.u9vE8iKgiD4yoevtAeyQX/QPnrY9nA2', NULL, NULL, '2024-05-20 20:33:20', '2024-05-20 20:33:20'),
(333, 'User Ke-317', 'user317@gmail.com', NULL, '$2y$10$v.wrxylveTWXDB67Y3tnHOeD1X4Sq2Wf9EnNgySAHmOMgJXChZ6se', NULL, NULL, '2024-05-20 20:33:20', '2024-05-20 20:33:20'),
(334, 'User Ke-318', 'user318@gmail.com', NULL, '$2y$10$trOSe0a4UlIg1volDoJGoOxAjUgUxMc6RwGZ6ebfvoZtrKvuZacmO', NULL, NULL, '2024-05-20 20:33:20', '2024-05-20 20:33:20'),
(335, 'User Ke-319', 'user319@gmail.com', NULL, '$2y$10$9sW66QW2WCFeWAVFK5zqOuZN7SjJvVA.elXOACTrni0n//4iNm26a', NULL, NULL, '2024-05-20 20:33:20', '2024-05-20 20:33:20'),
(336, 'User Ke-320', 'user320@gmail.com', NULL, '$2y$10$C3tlAmh2/kXdMiN3ST1ef.TGOKXXK.IupD1HGUzDB86seK4Fl1czW', NULL, NULL, '2024-05-20 20:33:20', '2024-05-20 20:33:20'),
(337, 'User Ke-321', 'user321@gmail.com', NULL, '$2y$10$HUZ4d3FvyNST7STVEpxGtu72NPM3YPcqKpnH1p.P5eR0BSmhZxbDq', NULL, NULL, '2024-05-20 20:33:20', '2024-05-20 20:33:20'),
(338, 'User Ke-322', 'user322@gmail.com', NULL, '$2y$10$I3LBEVGu.jfdwUpcee4uRu9Ri.VZQIP0Da6OPmCWOd14LwbD93jje', NULL, NULL, '2024-05-20 20:33:20', '2024-05-20 20:33:20'),
(339, 'User Ke-323', 'user323@gmail.com', NULL, '$2y$10$UJ0UgDkf36jvX2JF4.EzdeAAVnyynPTEwQHJMNY7yZnPHYqqmZUJK', NULL, NULL, '2024-05-20 20:33:20', '2024-05-20 20:33:20'),
(340, 'User Ke-324', 'user324@gmail.com', NULL, '$2y$10$EiFwMKyJ7k4O.CRm//SuseNRCFlYCt4dQO.nWCvAhrE1Dq3gw7Mou', NULL, NULL, '2024-05-20 20:33:20', '2024-05-20 20:33:20'),
(341, 'User Ke-325', 'user325@gmail.com', NULL, '$2y$10$wYBKgmb1j2GpvzKBDlJUS.hdAmF0yT5BH8hhnR2M9riu4n8t5zCZW', NULL, NULL, '2024-05-20 20:33:21', '2024-05-20 20:33:21'),
(342, 'User Ke-326', 'user326@gmail.com', NULL, '$2y$10$eQ2DOGmwFi7sy9WKTYxQz.G57f172cSuVUEaXrb3of4Sx.TtIq9G6', NULL, NULL, '2024-05-20 20:33:21', '2024-05-20 20:33:21'),
(343, 'User Ke-327', 'user327@gmail.com', NULL, '$2y$10$ho3QJYLNtHK/1/4gEMuXG.zYa5X8eakRD2IlbzC2vBFvRLsauGguK', NULL, NULL, '2024-05-20 20:33:21', '2024-05-20 20:33:21'),
(344, 'User Ke-328', 'user328@gmail.com', NULL, '$2y$10$8mT9nXJsbKEBOOvK6bj8XuiNoc.fBIxw3lZcuN/ycztdpXRROBaTC', NULL, NULL, '2024-05-20 20:33:21', '2024-05-20 20:33:21'),
(345, 'User Ke-329', 'user329@gmail.com', NULL, '$2y$10$bt5B8LM3YYgjSeghvNv.mOZVXyFp3jrun/HjgjKWk40q0FlLfsuQm', NULL, NULL, '2024-05-20 20:33:21', '2024-05-20 20:33:21'),
(346, 'User Ke-330', 'user330@gmail.com', NULL, '$2y$10$rTgPMeI3vi/aPjJHByFla.utOkseOYWUpxlbnvLElmsdWIqr.K/zO', NULL, NULL, '2024-05-20 20:33:21', '2024-05-20 20:33:21'),
(347, 'User Ke-331', 'user331@gmail.com', NULL, '$2y$10$bJqbcMH/rc1MZ8EoLiLqHedRWNWgqnOMKrWXBawel7aBlH06LEP7S', NULL, NULL, '2024-05-20 20:33:21', '2024-05-20 20:33:21'),
(348, 'User Ke-332', 'user332@gmail.com', NULL, '$2y$10$WrwZ.FI.Cjgzwep.im99NeBod56x4Ss7DKjS9nkom4jiDM4uPiKn.', NULL, NULL, '2024-05-20 20:33:21', '2024-05-20 20:33:21'),
(349, 'User Ke-333', 'user333@gmail.com', NULL, '$2y$10$JViw8ZjA0S7U.2kteb3zseOtsOtQBLvhKgV.N/1vdW.Wbi15eGQkK', NULL, NULL, '2024-05-20 20:33:21', '2024-05-20 20:33:21'),
(350, 'User Ke-334', 'user334@gmail.com', NULL, '$2y$10$C0BBX9xC0I/xvhZ/c4Hiqe5z06x74Ed2Ld8zWNVsXkDUdA/EZiiJ.', NULL, NULL, '2024-05-20 20:33:21', '2024-05-20 20:33:21'),
(351, 'User Ke-335', 'user335@gmail.com', NULL, '$2y$10$sKedP912sL5PHbIMZ8ZhGeNmdYot5A9JfstLqGOT.BA7xruG.6jre', NULL, NULL, '2024-05-20 20:33:21', '2024-05-20 20:33:21'),
(352, 'User Ke-336', 'user336@gmail.com', NULL, '$2y$10$Pj1/xt41k.YhPNuUnu7EdOK0oAPno74oMcBCt3iEx06jcU8PP9WDG', NULL, NULL, '2024-05-20 20:33:22', '2024-05-20 20:33:22'),
(353, 'User Ke-337', 'user337@gmail.com', NULL, '$2y$10$vp/ASWTpcs0fuF7v/9EVQ.0KlYRlZMOZib.UDbQYd5wWHctI7jv5i', NULL, NULL, '2024-05-20 20:33:22', '2024-05-20 20:33:22'),
(354, 'User Ke-338', 'user338@gmail.com', NULL, '$2y$10$5xZPeidsM7xZhgKev/ThzuYvYvjoGSysbqzT3q3UOOrAywK7bxhJu', NULL, NULL, '2024-05-20 20:33:22', '2024-05-20 20:33:22'),
(355, 'User Ke-339', 'user339@gmail.com', NULL, '$2y$10$AfTFmK.cUNh69MoHSrgCmOITftN.pUNOI.oURFfoaZUHqMCIL1k2m', NULL, NULL, '2024-05-20 20:33:22', '2024-05-20 20:33:22'),
(356, 'User Ke-340', 'user340@gmail.com', NULL, '$2y$10$zkLCQWUZ2fYeAm.XPKC/7uNVpDY8nm.Jf4TWM19fA9TXoc3KdksCa', NULL, NULL, '2024-05-20 20:33:22', '2024-05-20 20:33:22'),
(357, 'User Ke-341', 'user341@gmail.com', NULL, '$2y$10$OAvMxqXhXuQfd/2KlR8J/errf9bfp2tyW57YLqA3qVQj2U5cOefCK', NULL, NULL, '2024-05-20 20:33:22', '2024-05-20 20:33:22'),
(358, 'User Ke-342', 'user342@gmail.com', NULL, '$2y$10$hpoMcEeV.4fDonAQaO5SoufyyrzGXk4v.oEPeH3bvSxrqm7Xb/yVO', NULL, NULL, '2024-05-20 20:33:22', '2024-05-20 20:33:22'),
(359, 'User Ke-343', 'user343@gmail.com', NULL, '$2y$10$86tGWF4/BioIxPC5fE7xPuHwu5Zk2v.1mL9MVIev6F6oT8ZDwQ4Ne', NULL, NULL, '2024-05-20 20:33:22', '2024-05-20 20:33:22'),
(360, 'User Ke-344', 'user344@gmail.com', NULL, '$2y$10$lwREsPqL8D50BD4Nl8rODevgUdF8hIg7X/qFUEk2LNd9WzfNOfSu6', NULL, NULL, '2024-05-20 20:33:22', '2024-05-20 20:33:22'),
(361, 'User Ke-345', 'user345@gmail.com', NULL, '$2y$10$RKtQYkS/VqAaGF/ufSm9dezMbehInrZtpvBPFXotGc7dC5uajWQmy', NULL, NULL, '2024-05-20 20:33:22', '2024-05-20 20:33:22'),
(362, 'User Ke-346', 'user346@gmail.com', NULL, '$2y$10$l3XPms7yt.OSDYYXIFRMxu4IeLBeoOFmcobMsS8pxMb9CYP4u152u', NULL, NULL, '2024-05-20 20:33:22', '2024-05-20 20:33:22'),
(363, 'User Ke-347', 'user347@gmail.com', NULL, '$2y$10$zROY1Nr8y36ZMV2VpDKJKeoVcR3Z1yevLkuWNm4cStpjnaJ7xLaAG', NULL, NULL, '2024-05-20 20:33:22', '2024-05-20 20:33:22'),
(364, 'User Ke-348', 'user348@gmail.com', NULL, '$2y$10$dJg/UZqg8L4HRWRQVCBAxOyASy/QwSA044AVJFC0EHyBpoHioE6NC', NULL, NULL, '2024-05-20 20:33:23', '2024-05-20 20:33:23'),
(365, 'User Ke-349', 'user349@gmail.com', NULL, '$2y$10$JdO8oA.MQVp6VSIG6Zxxg.fR9fzRGURl3A1LJdTmr/ivrnBliZ.4S', NULL, NULL, '2024-05-20 20:33:23', '2024-05-20 20:33:23'),
(366, 'User Ke-350', 'user350@gmail.com', NULL, '$2y$10$ZgyP0Nvs.5fAA71rc0Bs6O2nGpaRpnWm5hp1Km3hCNl4oAcX9X0JS', NULL, NULL, '2024-05-20 20:33:23', '2024-05-20 20:33:23'),
(367, 'User Ke-351', 'user351@gmail.com', NULL, '$2y$10$578g.4N1Me3hp9XCYJe.OeCDS1Kf6wsrPFaYZuYFoso.VEOB6w18G', NULL, NULL, '2024-05-20 20:33:23', '2024-05-20 20:33:23'),
(368, 'User Ke-352', 'user352@gmail.com', NULL, '$2y$10$kyfMNVj9O1d7I/A.f7XJUef57GHoGsoAAF79O9LFqrUSZmFTqi9YO', NULL, NULL, '2024-05-20 20:33:23', '2024-05-20 20:33:23'),
(369, 'User Ke-353', 'user353@gmail.com', NULL, '$2y$10$g8RibTjEwrXdcibEZi6CXuyybBnJosybYeWH4v/kqOlft3v5jgiVG', NULL, NULL, '2024-05-20 20:33:23', '2024-05-20 20:33:23'),
(370, 'User Ke-354', 'user354@gmail.com', NULL, '$2y$10$eJUuqAZBipQ7rISUsY7fiuXgQUaF9/GmXM6NWwY.f3lT8EbENDmXC', NULL, NULL, '2024-05-20 20:33:23', '2024-05-20 20:33:23'),
(371, 'User Ke-355', 'user355@gmail.com', NULL, '$2y$10$owDuQn9/3pWG5VmmnaYDl.3zTDMmzN0QWEiRdwFZ6N3kzS.1dredK', NULL, NULL, '2024-05-20 20:33:23', '2024-05-20 20:33:23'),
(372, 'User Ke-356', 'user356@gmail.com', NULL, '$2y$10$v5QRSeiVrf5JocGi.o2ACO2RYTvGSgqi.Qwr9frDECAK5V/2yPlJO', NULL, NULL, '2024-05-20 20:33:23', '2024-05-20 20:33:23'),
(373, 'User Ke-357', 'user357@gmail.com', NULL, '$2y$10$dtBIMSFpA/BlwFhIlcdI3umZmLjfoS1IDjrEwaMBVFy/balS35nYu', NULL, NULL, '2024-05-20 20:33:23', '2024-05-20 20:33:23'),
(374, 'User Ke-358', 'user358@gmail.com', NULL, '$2y$10$9XxRPESRvP5/Ku8FOOV/k.kOVxSNwxzv5KP2YoOaqg5QmG3z//c6K', NULL, NULL, '2024-05-20 20:33:23', '2024-05-20 20:33:23'),
(375, 'User Ke-359', 'user359@gmail.com', NULL, '$2y$10$wBWcaNdEQSe.UZ85jgjwR.RxAffqQBdiFkV8l9VqYNLN/X3R5X94y', NULL, NULL, '2024-05-20 20:33:24', '2024-05-20 20:33:24'),
(376, 'User Ke-360', 'user360@gmail.com', NULL, '$2y$10$CZmadLsPkvkLriFAA.ngzuqmUEJ46zmwzzi8IPiIJPJ5TxS0eLNnq', NULL, NULL, '2024-05-20 20:33:24', '2024-05-20 20:33:24'),
(377, 'User Ke-361', 'user361@gmail.com', NULL, '$2y$10$3OrgOE4sj.DV42wgzryUyuZVP/6saPVqsrg1so5LFbbOp4f0h4t1C', NULL, NULL, '2024-05-20 20:33:24', '2024-05-20 20:33:24'),
(378, 'User Ke-362', 'user362@gmail.com', NULL, '$2y$10$KT6F2m7dk8qZGuNCozAJ1ufmwLfARtkqII2HiPz4TNiefUmoj5DSq', NULL, NULL, '2024-05-20 20:33:24', '2024-05-20 20:33:24'),
(379, 'User Ke-363', 'user363@gmail.com', NULL, '$2y$10$D4HsWOFeHjc1KmZIkKKc3e4iibMtXz7ZppgfP0KOx8yVoJ7AvEg0.', NULL, NULL, '2024-05-20 20:33:24', '2024-05-20 20:33:24'),
(380, 'User Ke-364', 'user364@gmail.com', NULL, '$2y$10$crO8b0FTf3tLrU45WIIteuHqPAE8LlVdMv1R/46TPpIADj/BJhiWS', NULL, NULL, '2024-05-20 20:33:24', '2024-05-20 20:33:24'),
(381, 'User Ke-365', 'user365@gmail.com', NULL, '$2y$10$2sFPE7aHPW5Txx8pDRsE.uRp1dl1VQBKQKAxU8NWfwCgbKp.RpD5a', NULL, NULL, '2024-05-20 20:33:24', '2024-05-20 20:33:24'),
(382, 'User Ke-366', 'user366@gmail.com', NULL, '$2y$10$A5uSpjifjPuXfG0ezz2HAOsXu2c7OMAkXA7Bb8LlBFk2Iwc0emb2G', NULL, NULL, '2024-05-20 20:33:24', '2024-05-20 20:33:24'),
(383, 'User Ke-367', 'user367@gmail.com', NULL, '$2y$10$KDiHnKw60ecdl58EndjreOD99mhFjoEnTHKlVIhmgVH2x0YS8L3Pi', NULL, NULL, '2024-05-20 20:33:24', '2024-05-20 20:33:24'),
(384, 'User Ke-368', 'user368@gmail.com', NULL, '$2y$10$nTAKepmtAc1w9t.lcmwo..rAjIdnuKdPIJ.pwPQnPJbutHFC162Gu', NULL, NULL, '2024-05-20 20:33:24', '2024-05-20 20:33:24'),
(385, 'User Ke-369', 'user369@gmail.com', NULL, '$2y$10$GWzXkApvLXGSUThYkB103uxYnHqNPBHFOKB5jeds3oTBKXHxSgpqm', NULL, NULL, '2024-05-20 20:33:24', '2024-05-20 20:33:24'),
(386, 'User Ke-370', 'user370@gmail.com', NULL, '$2y$10$TYuHlh/Yi048vM12tJe3iO8x0yJUFKNHdtetB8KATRyQLJaAOm7KO', NULL, NULL, '2024-05-20 20:33:24', '2024-05-20 20:33:24'),
(387, 'User Ke-371', 'user371@gmail.com', NULL, '$2y$10$7vF1/nhC/05YiYg1ZjxEp.4f7uKZ5cFOo/CJGm6fDz2hc3SkLCaJu', NULL, NULL, '2024-05-20 20:33:25', '2024-05-20 20:33:25'),
(388, 'User Ke-372', 'user372@gmail.com', NULL, '$2y$10$eA9f5Q9PmXBGzZKtEdcLSOrD2nUCZ3mKInHdzGQ42a7OocFAFaF8G', NULL, NULL, '2024-05-20 20:33:25', '2024-05-20 20:33:25'),
(389, 'User Ke-373', 'user373@gmail.com', NULL, '$2y$10$LovA.9bg5NfRnGzNVnKl3eLSiTEOXe8CHaOjggyAwncjfK4VRoM/u', NULL, NULL, '2024-05-20 20:33:25', '2024-05-20 20:33:25'),
(390, 'User Ke-374', 'user374@gmail.com', NULL, '$2y$10$wfYEf05JTJnovxfcFqZsYOAu6KvecC5Mb6n7wufgWzb.Ajog/ugP6', NULL, NULL, '2024-05-20 20:33:25', '2024-05-20 20:33:25'),
(391, 'User Ke-375', 'user375@gmail.com', NULL, '$2y$10$Ihc6bvjLeE9w/eUF41qbcOxiDreJUXzJ1UBNvN8FNck4te/.jjxc6', NULL, NULL, '2024-05-20 20:33:25', '2024-05-20 20:33:25'),
(392, 'User Ke-376', 'user376@gmail.com', NULL, '$2y$10$VJWcN35jsxjcjtrxsHFUY./xnupNsrn6Ky6gkZ9Hmjrn1PRp3nyRW', NULL, NULL, '2024-05-20 20:33:25', '2024-05-20 20:33:25'),
(393, 'User Ke-377', 'user377@gmail.com', NULL, '$2y$10$DXfNGTjnkOviZHmq7zXVeOsvadGiCOG48Lt1EKUg2p091Zz4ltxi.', NULL, NULL, '2024-05-20 20:33:25', '2024-05-20 20:33:25'),
(394, 'User Ke-378', 'user378@gmail.com', NULL, '$2y$10$bdaewsyvtswJ7fH6MAYJlOR0j.O/9PdjZhApPv42hovbZhL34DSmC', NULL, NULL, '2024-05-20 20:33:25', '2024-05-20 20:33:25'),
(395, 'User Ke-379', 'user379@gmail.com', NULL, '$2y$10$2vBupLPm0Pq1u7MxoVz5QeabgWtkfFewhW5DU3AcV.iWm6sRAs2J6', NULL, NULL, '2024-05-20 20:33:25', '2024-05-20 20:33:25'),
(396, 'User Ke-380', 'user380@gmail.com', NULL, '$2y$10$11hqMOoKUiQVqKj0APabMedD/8LlKZQQnZpb8w6IsXt9432h7mbC.', NULL, NULL, '2024-05-20 20:33:25', '2024-05-20 20:33:25'),
(397, 'User Ke-381', 'user381@gmail.com', NULL, '$2y$10$VrbfXlz/qWHRwtK3LJ8OeOR.9QYgyZ2UFSh82N4vHjmyoTNge3WX.', NULL, NULL, '2024-05-20 20:33:25', '2024-05-20 20:33:25'),
(398, 'User Ke-382', 'user382@gmail.com', NULL, '$2y$10$/4lQSHzlkdJrLtuVVq0GteIiFLwaUarJgEbt71oYIKiXBpn.XmdD6', NULL, NULL, '2024-05-20 20:33:26', '2024-05-20 20:33:26'),
(399, 'User Ke-383', 'user383@gmail.com', NULL, '$2y$10$l3WovFMVWJMB/sc6fJKDFe1kd3xkq3j/7eWdxCLhj6ZlqCPi.9QYi', NULL, NULL, '2024-05-20 20:33:26', '2024-05-20 20:33:26'),
(400, 'User Ke-384', 'user384@gmail.com', NULL, '$2y$10$i0/njV3HiVg2mJf1BYeXLesDHwG5jiJ7vrfsT39C2o55l8LaWoTRS', NULL, NULL, '2024-05-20 20:33:26', '2024-05-20 20:33:26'),
(401, 'User Ke-385', 'user385@gmail.com', NULL, '$2y$10$6v/Lh6wLgp2Ru5sWcIQeg.PF3TAqVPZlJ14gE4KVwk0SrWPihLvMm', NULL, NULL, '2024-05-20 20:33:26', '2024-05-20 20:33:26'),
(402, 'User Ke-386', 'user386@gmail.com', NULL, '$2y$10$tpc7mvmPhnBAJxjQELLD/euCptNfcyZG68O.vQM02hgRIWQGwYdYm', NULL, NULL, '2024-05-20 20:33:26', '2024-05-20 20:33:26'),
(403, 'User Ke-387', 'user387@gmail.com', NULL, '$2y$10$e9h3zHfmKXpgLSJvLXEaNOaBJ2Ay5NPAliOid1tNcu1yoPOJ6B3fu', NULL, NULL, '2024-05-20 20:33:26', '2024-05-20 20:33:26'),
(404, 'User Ke-388', 'user388@gmail.com', NULL, '$2y$10$TsjAz6JXiSemLqM8OQ45D.fcEe4VUbTSpvDRU7ZAqcj8mOy6VYTPy', NULL, NULL, '2024-05-20 20:33:26', '2024-05-20 20:33:26'),
(405, 'User Ke-389', 'user389@gmail.com', NULL, '$2y$10$Yl6YWvy4MRC.JqMJj97DhuHpLL7bQuZcLMNdX4MeXXyTHd.3mYE.m', NULL, NULL, '2024-05-20 20:33:26', '2024-05-20 20:33:26'),
(406, 'User Ke-390', 'user390@gmail.com', NULL, '$2y$10$6Idm4bIFwU4QEEeHdagtLeKCbetRfzQ27mLAj8ouSAldUXbVxlOdu', NULL, NULL, '2024-05-20 20:33:26', '2024-05-20 20:33:26'),
(407, 'User Ke-391', 'user391@gmail.com', NULL, '$2y$10$sbKHiHLKBBVxqHtdMjwEZOgrn4FhKJiwgA8y8OFcJ8gkIpq.HJl52', NULL, NULL, '2024-05-20 20:33:26', '2024-05-20 20:33:26'),
(408, 'User Ke-392', 'user392@gmail.com', NULL, '$2y$10$A7uyfP4WReVOmiYXAXNXMuvjAM/n.nnvRh2/kSoCpGKIodHbT9MDy', NULL, NULL, '2024-05-20 20:33:26', '2024-05-20 20:33:26'),
(409, 'User Ke-393', 'user393@gmail.com', NULL, '$2y$10$9RFsxNZ3G5FMZLpPMhmi1.uzWBFg28DjPBzoJCZ0MdqFUXm6hbpNi', NULL, NULL, '2024-05-20 20:33:26', '2024-05-20 20:33:26'),
(410, 'User Ke-394', 'user394@gmail.com', NULL, '$2y$10$t0SQmmd5HH5pAUwrIwl6iuwgfX28hvyj6gAP.i.r2eGmjgK2C4gF.', NULL, NULL, '2024-05-20 20:33:27', '2024-05-20 20:33:27'),
(411, 'User Ke-395', 'user395@gmail.com', NULL, '$2y$10$9.E0L1AUA3cYCSKrq0pyB.6z41ZnaqWRUnHOR/Y03PMLuD9nV3TW2', NULL, NULL, '2024-05-20 20:33:27', '2024-05-20 20:33:27'),
(412, 'User Ke-396', 'user396@gmail.com', NULL, '$2y$10$YGvDEwLm5zBm6zhVLf2JpuQldqJ6k/c0/Q8q.mF.1Gtntj4yU37xC', NULL, NULL, '2024-05-20 20:33:27', '2024-05-20 20:33:27'),
(413, 'User Ke-397', 'user397@gmail.com', NULL, '$2y$10$mNp90tbHE//sqBGCfLpqfOmfw6svsbz6V6hYz.K8G8p26oTi0XEpK', NULL, NULL, '2024-05-20 20:33:27', '2024-05-20 20:33:27'),
(414, 'User Ke-398', 'user398@gmail.com', NULL, '$2y$10$UD1t9o74SAMQrBD7dmUjPOIA.4RdV2ySf2IzPSw5rFR8KCGyTbo9W', NULL, NULL, '2024-05-20 20:33:27', '2024-05-20 20:33:27'),
(415, 'User Ke-399', 'user399@gmail.com', NULL, '$2y$10$YJ85J5dmqCMbD6H2xYWHDuvJOhCg.jQRBXUuIyceTp.Gm06kg8sMC', NULL, NULL, '2024-05-20 20:33:27', '2024-05-20 20:33:27'),
(416, 'User Ke-400', 'user400@gmail.com', NULL, '$2y$10$BJgoqgbYYFOA0UZeh5FEHuhOn9DKYgW5fuhXxxSAx0bDt3n.0E8nC', NULL, NULL, '2024-05-20 20:33:27', '2024-05-20 20:33:27'),
(417, 'User Ke-401', 'user401@gmail.com', NULL, '$2y$10$1fweB0y/37nR8n72pEBD9Orhs.CcUIq2PEhiNWWGL6ioyHM9pixcq', NULL, NULL, '2024-05-20 20:33:27', '2024-05-20 20:33:27'),
(418, 'User Ke-402', 'user402@gmail.com', NULL, '$2y$10$6fCWhtmukU1t3gYKpeB6LuXPYKmmVCewMHkuqlfJCvG5Bs16kmTDq', NULL, NULL, '2024-05-20 20:33:27', '2024-05-20 20:33:27'),
(419, 'User Ke-403', 'user403@gmail.com', NULL, '$2y$10$Ut.dh7CbnXUhkT3op9ZyGuAvSiNFi/nSX8kctxw5LwpvpKz4Rz2gq', NULL, NULL, '2024-05-20 20:33:27', '2024-05-20 20:33:27'),
(420, 'User Ke-404', 'user404@gmail.com', NULL, '$2y$10$nGYXTjLP0F34Z75z24SFYuR.zsI.H0u0Q4/IXl1Zv.4M3e4QaqtpS', NULL, NULL, '2024-05-20 20:33:27', '2024-05-20 20:33:27'),
(421, 'User Ke-405', 'user405@gmail.com', NULL, '$2y$10$cdg7y2x03xQobNMc/DIj8ucBMvo/PhnUwtVmdPQUUAACtkuyQXyzq', NULL, NULL, '2024-05-20 20:33:28', '2024-05-20 20:33:28'),
(422, 'User Ke-406', 'user406@gmail.com', NULL, '$2y$10$romjUGCTxcUDAeAzi2HV.ezZaAudIWhsv9d1vGLwBRC3P188GuTzK', NULL, NULL, '2024-05-20 20:33:28', '2024-05-20 20:33:28'),
(423, 'User Ke-407', 'user407@gmail.com', NULL, '$2y$10$79krgZuqAVIMa3l2pgyiOOCyf5V48unZGYTPCPs3NAiFIyAUv6wZy', NULL, NULL, '2024-05-20 20:33:28', '2024-05-20 20:33:28'),
(424, 'User Ke-408', 'user408@gmail.com', NULL, '$2y$10$HJfD5BmQAmoGGZeGX0JlU.StzIG4QYoyCG1/qMAgzPyvL6x1BCX9q', NULL, NULL, '2024-05-20 20:33:28', '2024-05-20 20:33:28'),
(425, 'User Ke-409', 'user409@gmail.com', NULL, '$2y$10$rRIUKeQZy1SrvIJ.JxgqBOnJwEpl.76FXZLJSfDPp4PQtikFVARjS', NULL, NULL, '2024-05-20 20:33:28', '2024-05-20 20:33:28'),
(426, 'User Ke-410', 'user410@gmail.com', NULL, '$2y$10$W3ewp0nt.ueSJ0vcKCpRPu8O49R2vDVJIExtahHzsmYJz/FOyDQZy', NULL, NULL, '2024-05-20 20:33:28', '2024-05-20 20:33:28'),
(427, 'User Ke-411', 'user411@gmail.com', NULL, '$2y$10$U6lX9OtZIMsnb6hwchDdQ.aTPUj4CUaix4IlFIv8.ngLsLd99JD6i', NULL, NULL, '2024-05-20 20:33:28', '2024-05-20 20:33:28'),
(428, 'User Ke-412', 'user412@gmail.com', NULL, '$2y$10$6906DKaYhGQGCCahGf7dm.zXkVln28uwdw.60TdcbBCqqqLTUduHa', NULL, NULL, '2024-05-20 20:33:28', '2024-05-20 20:33:28'),
(429, 'User Ke-413', 'user413@gmail.com', NULL, '$2y$10$3mjrQEHzwJsQYhIyv1rIw.jOlobbSfKtZ35lZk5WNzItesGM6E83i', NULL, NULL, '2024-05-20 20:33:28', '2024-05-20 20:33:28'),
(430, 'User Ke-414', 'user414@gmail.com', NULL, '$2y$10$fGss0leYyUWfD8FumdY.reWvzy0nTHt4LAcbYgJz6q5okJZd8L/q.', NULL, NULL, '2024-05-20 20:33:28', '2024-05-20 20:33:28'),
(431, 'User Ke-415', 'user415@gmail.com', NULL, '$2y$10$umFzejoCNGSx10mDccb.3eQ2ZBgKksmZSvXyEyTc.vvaCn2RxQzXm', NULL, NULL, '2024-05-20 20:33:28', '2024-05-20 20:33:28'),
(432, 'User Ke-416', 'user416@gmail.com', NULL, '$2y$10$D/7Mmo0FQXCbXVgBqtDTYuhG6qKpHqvOFfRY5hXTvnPZ2gUkEU9C.', NULL, NULL, '2024-05-20 20:33:28', '2024-05-20 20:33:28'),
(433, 'User Ke-417', 'user417@gmail.com', NULL, '$2y$10$YqrIUPaC27NTAhReA80bg.iZNcghRRaPwLe3dxKxSgOZtcfL8PAzW', NULL, NULL, '2024-05-20 20:33:29', '2024-05-20 20:33:29'),
(434, 'User Ke-418', 'user418@gmail.com', NULL, '$2y$10$9qfr4VgmL/t35QrhGxRl3OabB6u2qON0TKGfMcstyB921ctcYDuFG', NULL, NULL, '2024-05-20 20:33:29', '2024-05-20 20:33:29'),
(435, 'User Ke-419', 'user419@gmail.com', NULL, '$2y$10$ehs5plfZO89J/HvIimsTm.b1eky8wKgXKQtroeM8jRnDunBgfHUqu', NULL, NULL, '2024-05-20 20:33:29', '2024-05-20 20:33:29'),
(436, 'User Ke-420', 'user420@gmail.com', NULL, '$2y$10$/vaiKvp.kt9GXmxbLGoiLusoYa7f53M2F1WtPlj.uIGZlZ8cqM3vi', NULL, NULL, '2024-05-20 20:33:29', '2024-05-20 20:33:29'),
(437, 'User Ke-421', 'user421@gmail.com', NULL, '$2y$10$SRmmq7b3oKeSTSj2k5S8xeAyz5vZSzhXtdvy7.OMjoyPQgwyvC9U.', NULL, NULL, '2024-05-20 20:33:29', '2024-05-20 20:33:29'),
(438, 'User Ke-422', 'user422@gmail.com', NULL, '$2y$10$dhGOPslQmX5ahOor1DzaX.S8rW6pvIZdWuZ1hrDzWrXKtGKde3hlK', NULL, NULL, '2024-05-20 20:33:29', '2024-05-20 20:33:29'),
(439, 'User Ke-423', 'user423@gmail.com', NULL, '$2y$10$KJ5Cdm4iUU.yDHJokv0vqul37XT1i1nhyfffpSKP5c19TaR28YmWK', NULL, NULL, '2024-05-20 20:33:29', '2024-05-20 20:33:29'),
(440, 'User Ke-424', 'user424@gmail.com', NULL, '$2y$10$NKavmdWgZA0J4dod2tlEjedSah1Ykzl6NybH.5H0cg0ebqWlEG6zy', NULL, NULL, '2024-05-20 20:33:29', '2024-05-20 20:33:29'),
(441, 'User Ke-425', 'user425@gmail.com', NULL, '$2y$10$p1htsy9.wTOUztdiIKEMLuC0PTLonsSEVNo.4JdzxvxGBVNcsOhCS', NULL, NULL, '2024-05-20 20:33:29', '2024-05-20 20:33:29'),
(442, 'User Ke-426', 'user426@gmail.com', NULL, '$2y$10$6dv/0qyUBl3zpkgJE.BaNO00gMcgUDxAN3NdA2CkSvY1xRezY2/rq', NULL, NULL, '2024-05-20 20:33:29', '2024-05-20 20:33:29'),
(443, 'User Ke-427', 'user427@gmail.com', NULL, '$2y$10$/Mg62DG8L/.FkKPkIQyyVOMG.bMS6X5.p2E8fsD1znmfwBaHsakeu', NULL, NULL, '2024-05-20 20:33:29', '2024-05-20 20:33:29'),
(444, 'User Ke-428', 'user428@gmail.com', NULL, '$2y$10$sCSKiNjlG8/kkORW20cS/uXRbRygWZ964ug6G8v08T5erMr3DPHrG', NULL, NULL, '2024-05-20 20:33:30', '2024-05-20 20:33:30'),
(445, 'User Ke-429', 'user429@gmail.com', NULL, '$2y$10$zAvqCVsTNkdenzN4/1b9mOhRvZ8zTl7N1qA8srJOCHFf.nmEfDioO', NULL, NULL, '2024-05-20 20:33:30', '2024-05-20 20:33:30'),
(446, 'User Ke-430', 'user430@gmail.com', NULL, '$2y$10$uTdQ15YxKFmoUxm2YbSkwOcoGiXW3SxoTCZbVDrq64u95hoPzIzii', NULL, NULL, '2024-05-20 20:33:30', '2024-05-20 20:33:30'),
(447, 'User Ke-431', 'user431@gmail.com', NULL, '$2y$10$Q0J1UkaWFJY2fxQ0v.UOKO0kjeLRVLh8eTUYO6hBCBlQEIu2HuOaW', NULL, NULL, '2024-05-20 20:33:30', '2024-05-20 20:33:30'),
(448, 'User Ke-432', 'user432@gmail.com', NULL, '$2y$10$8DpbTt6t/OKuh.X9Z0MnguERuBXl.T1s2BtgaXeaF6Wh1XLP7W7W2', NULL, NULL, '2024-05-20 20:33:30', '2024-05-20 20:33:30'),
(449, 'User Ke-433', 'user433@gmail.com', NULL, '$2y$10$YHfckrzAeWFeuhcTqC/HMuMypp7FA7g3DdNkqnryw.zEidmLmUdYe', NULL, NULL, '2024-05-20 20:33:30', '2024-05-20 20:33:30'),
(450, 'User Ke-434', 'user434@gmail.com', NULL, '$2y$10$ezfPCJk7fO.vvNjb7YIW/e56IoA.HzUt/Nqn1/xAOA5QizyLjFk/2', NULL, NULL, '2024-05-20 20:33:30', '2024-05-20 20:33:30'),
(451, 'User Ke-435', 'user435@gmail.com', NULL, '$2y$10$B0EU5yofpG7lp24mFpa/N.Muaq39Vxh3asix5RnbbU2yluQMw8lri', NULL, NULL, '2024-05-20 20:33:30', '2024-05-20 20:33:30'),
(452, 'User Ke-436', 'user436@gmail.com', NULL, '$2y$10$BL6U7YAb64./eOK/B4Ji/uDZi2XaB5cW8QarguF3HYYemEoiMx5rO', NULL, NULL, '2024-05-20 20:33:30', '2024-05-20 20:33:30'),
(453, 'User Ke-437', 'user437@gmail.com', NULL, '$2y$10$Rw3ULRpSeNqqpJc0XXGAXu7uRi0LPzxYSIrDC7BYaeT9XmTzz279u', NULL, NULL, '2024-05-20 20:33:30', '2024-05-20 20:33:30'),
(454, 'User Ke-438', 'user438@gmail.com', NULL, '$2y$10$2B654mR70IjSpnAapqjTB.ItlaRC/dHgwafCcVFomkfxj5At7nzeS', NULL, NULL, '2024-05-20 20:33:30', '2024-05-20 20:33:30'),
(455, 'User Ke-439', 'user439@gmail.com', NULL, '$2y$10$XSu2H1pt4U7e69pLYNJj2..rIxaFhfcjKQHzdk4NrXvwmXhd6q.IO', NULL, NULL, '2024-05-20 20:33:30', '2024-05-20 20:33:30'),
(456, 'User Ke-440', 'user440@gmail.com', NULL, '$2y$10$G3JlxHo2lD7mA4dXTG6ZaOxZxLOth6elGf9g0GqtgvyGTkF10Yp6C', NULL, NULL, '2024-05-20 20:33:31', '2024-05-20 20:33:31'),
(457, 'User Ke-441', 'user441@gmail.com', NULL, '$2y$10$O9LBnOpX2g2NL9I1wL9FO.fKBJk39BMO/V/ymXCWPFEUEgNwEDy1e', NULL, NULL, '2024-05-20 20:33:31', '2024-05-20 20:33:31'),
(458, 'User Ke-442', 'user442@gmail.com', NULL, '$2y$10$FBWPWJzSzuWh9EtiY8fAO.ibs34QurhJVUmSQlxsbbGiPhxP6N5j.', NULL, NULL, '2024-05-20 20:33:31', '2024-05-20 20:33:31'),
(459, 'User Ke-443', 'user443@gmail.com', NULL, '$2y$10$8gKjaMAocG3F19gUkr06K.UKxzARbsn9ZpGdeC5ziMCWSoTytXZr.', NULL, NULL, '2024-05-20 20:33:31', '2024-05-20 20:33:31'),
(460, 'User Ke-444', 'user444@gmail.com', NULL, '$2y$10$sTEy6c2VmuVMafcZ0/8Gz.4ZR5TYQ/V5MB0ULjB1p2E.3oMPERSOi', NULL, NULL, '2024-05-20 20:33:31', '2024-05-20 20:33:31'),
(461, 'User Ke-445', 'user445@gmail.com', NULL, '$2y$10$ORApWv6ztZR0077ES8Y6iuL2Ga1SAqUJk.92D/g8jfl4qTR4Avjdq', NULL, NULL, '2024-05-20 20:33:31', '2024-05-20 20:33:31'),
(462, 'User Ke-446', 'user446@gmail.com', NULL, '$2y$10$.p7OYJCqJFOwmGK4Jy/Hb.ZDpM2FmFGEdIz0epgodTRgp8LLi/MM6', NULL, NULL, '2024-05-20 20:33:31', '2024-05-20 20:33:31'),
(463, 'User Ke-447', 'user447@gmail.com', NULL, '$2y$10$dZ6f5DG455tJjcSl7kaeGO1JFe1l54H4juZFQ3LN7UMd7J0H8F8Wa', NULL, NULL, '2024-05-20 20:33:31', '2024-05-20 20:33:31'),
(464, 'User Ke-448', 'user448@gmail.com', NULL, '$2y$10$CB7GTNxevJkNQD2fPTQc1uHj9amltsUmoivmycsxv/9/1wTLOWJ6.', NULL, NULL, '2024-05-20 20:33:31', '2024-05-20 20:33:31'),
(465, 'User Ke-449', 'user449@gmail.com', NULL, '$2y$10$5Wa2YLH0ISxJWetOxQXSCuBAj3rAdbEO5u9aJu1gp1V7DVLFOXize', NULL, NULL, '2024-05-20 20:33:31', '2024-05-20 20:33:31'),
(466, 'User Ke-450', 'user450@gmail.com', NULL, '$2y$10$FrytHDUBAHUralbPiBRcQOp.aeWHO5i8vqspFdTRbXpd2cfJFSGxS', NULL, NULL, '2024-05-20 20:33:31', '2024-05-20 20:33:31'),
(467, 'User Ke-451', 'user451@gmail.com', NULL, '$2y$10$0hUZO8GMOgCbrnaSL0UN7eANVhXV.p6.FyoUkDUXqP2zvsd66sG3S', NULL, NULL, '2024-05-20 20:33:32', '2024-05-20 20:33:32'),
(468, 'User Ke-452', 'user452@gmail.com', NULL, '$2y$10$0.z9PxaR4jndCn/vDeWu.e9czeaazGsk4OW4zEDfv5g/VPikIC4.O', NULL, NULL, '2024-05-20 20:33:32', '2024-05-20 20:33:32'),
(469, 'User Ke-453', 'user453@gmail.com', NULL, '$2y$10$BLFG.Rswcdw5nsvqV8m3MObbT06rORmthNRRUP/tliVKLUoaH2Dhy', NULL, NULL, '2024-05-20 20:33:32', '2024-05-20 20:33:32'),
(470, 'User Ke-454', 'user454@gmail.com', NULL, '$2y$10$RJL24Y6C0h3jFp2oxoWkWubgtfCt0YMsddqP0bKfMJlNXo3CXeoUm', NULL, NULL, '2024-05-20 20:33:32', '2024-05-20 20:33:32'),
(471, 'User Ke-455', 'user455@gmail.com', NULL, '$2y$10$IbLNW9soBHewpPvfb3.omeDmLfgofhdORLC/DKbodaEBuf8sn8gpG', NULL, NULL, '2024-05-20 20:33:32', '2024-05-20 20:33:32'),
(472, 'User Ke-456', 'user456@gmail.com', NULL, '$2y$10$rUzwze37j6X0LjSZ1yXYtuAPvbahS3vGPC0FKa9MTfrK2i5EVI6Ra', NULL, NULL, '2024-05-20 20:33:32', '2024-05-20 20:33:32'),
(473, 'User Ke-457', 'user457@gmail.com', NULL, '$2y$10$LXOsAdRTSHqBjHQYKlsNJ.CZ7fzMUO.bsdO7Xtb.iLOcPlgKMb.Ce', NULL, NULL, '2024-05-20 20:33:32', '2024-05-20 20:33:32'),
(474, 'User Ke-458', 'user458@gmail.com', NULL, '$2y$10$ArfoJaAjETrg3SBkj9r4VOMstFn6mgFKuym57iITlDoSnl29YYw4C', NULL, NULL, '2024-05-20 20:33:32', '2024-05-20 20:33:32'),
(475, 'User Ke-459', 'user459@gmail.com', NULL, '$2y$10$XXO4GUPpKuNVL1djnPzVGewE6HSIEhMinOJsgj2UyTzwBD78aESJm', NULL, NULL, '2024-05-20 20:33:32', '2024-05-20 20:33:32'),
(476, 'User Ke-460', 'user460@gmail.com', NULL, '$2y$10$kzg4SwurF7YBsGgpmmqa4.BiE0rHHArev7Wxh.o4TG/HzA2Mqwgiy', NULL, NULL, '2024-05-20 20:33:32', '2024-05-20 20:33:32'),
(477, 'User Ke-461', 'user461@gmail.com', NULL, '$2y$10$APUUCbE/4xJqFqnfEQdnpeWf2DN9rJOp0mm35Jwrcv3GK6BsRjSza', NULL, NULL, '2024-05-20 20:33:32', '2024-05-20 20:33:32'),
(478, 'User Ke-462', 'user462@gmail.com', NULL, '$2y$10$TfSjWdHdgD3gF6qomHR8weSHmv7KH7S90bHL4Zb157Mlypi0.lz4.', NULL, NULL, '2024-05-20 20:33:33', '2024-05-20 20:33:33'),
(479, 'User Ke-463', 'user463@gmail.com', NULL, '$2y$10$JqLrx4GeYHIWXut2lBeLU.MierV69Y7gRBROdXh4WLA5zMQd/Ir32', NULL, NULL, '2024-05-20 20:33:33', '2024-05-20 20:33:33'),
(480, 'User Ke-464', 'user464@gmail.com', NULL, '$2y$10$FeSKqZ4JcFoy13JwzLCRJesn6N0taRTZJBiLkNdPV1Xglxvn6GPtq', NULL, NULL, '2024-05-20 20:33:33', '2024-05-20 20:33:33'),
(481, 'User Ke-465', 'user465@gmail.com', NULL, '$2y$10$S4105bz37joVMm/UEIQVA.TWUbanGdjF2qjzHHanxoEzVcarJnhT.', NULL, NULL, '2024-05-20 20:33:33', '2024-05-20 20:33:33'),
(482, 'User Ke-466', 'user466@gmail.com', NULL, '$2y$10$lhMjxcxHuEHDnOm9DBeS3.AN6nOUcpWeR4rC8nyYwoNHADabtWmfy', NULL, NULL, '2024-05-20 20:33:33', '2024-05-20 20:33:33'),
(483, 'User Ke-467', 'user467@gmail.com', NULL, '$2y$10$d7Q0NZFaggrZeTmL5U8Ep.y8ecdUF1Kvb7YipQWy5qybL4FcAmT9W', NULL, NULL, '2024-05-20 20:33:33', '2024-05-20 20:33:33'),
(484, 'User Ke-468', 'user468@gmail.com', NULL, '$2y$10$BUW3uazTQqUfKfXr2Bd1cO3eA5MXy4al3mB5guhRE.AuOQ3CICsDK', NULL, NULL, '2024-05-20 20:33:33', '2024-05-20 20:33:33'),
(485, 'User Ke-469', 'user469@gmail.com', NULL, '$2y$10$XBagZB67rkTxyeBnGyNe9.LRwNNAnJ2fRnVK.3iUvtQ.JKoSpIiHe', NULL, NULL, '2024-05-20 20:33:33', '2024-05-20 20:33:33'),
(486, 'User Ke-470', 'user470@gmail.com', NULL, '$2y$10$X2mRQDRB3ZTVY7hioMZZn.UPOuqhrDeQ.pYGyYs7Los73RhH/lS6y', NULL, NULL, '2024-05-20 20:33:33', '2024-05-20 20:33:33'),
(487, 'User Ke-471', 'user471@gmail.com', NULL, '$2y$10$TRbT4hca6nH/RR/7UzH11.t2hCj7/pgpF53r9l9GeDPsC2vRJSEhC', NULL, NULL, '2024-05-20 20:33:33', '2024-05-20 20:33:33'),
(488, 'User Ke-472', 'user472@gmail.com', NULL, '$2y$10$PI.IGwVnZuGhJ8.vYjL7vuV9QWQ4uQaRhpmaPVQBIjNGBF72aDaky', NULL, NULL, '2024-05-20 20:33:33', '2024-05-20 20:33:33'),
(489, 'User Ke-473', 'user473@gmail.com', NULL, '$2y$10$TTNz3L9m/S0lHr.bWYgZMu1CfIORWfYocoytJqwHAQRJpEfeGeLl6', NULL, NULL, '2024-05-20 20:33:33', '2024-05-20 20:33:33'),
(490, 'User Ke-474', 'user474@gmail.com', NULL, '$2y$10$/ECZTjwkfpyAU.hZtGFnKO5Z1gg6tyj3nzbpbrRZyuGamit6sF9fC', NULL, NULL, '2024-05-20 20:33:34', '2024-05-20 20:33:34'),
(491, 'User Ke-475', 'user475@gmail.com', NULL, '$2y$10$0ftDVtyPluF6c7vxX3tmweIvL8hYQxHz.PiQqXoJ5XbH7I19e7t.e', NULL, NULL, '2024-05-20 20:33:34', '2024-05-20 20:33:34'),
(492, 'User Ke-476', 'user476@gmail.com', NULL, '$2y$10$iDaN0Lm7K6ouRrNNRssAC.oXzVmbNwlB5izCi9t3B4kJkIAHnEABq', NULL, NULL, '2024-05-20 20:33:34', '2024-05-20 20:33:34'),
(493, 'User Ke-477', 'user477@gmail.com', NULL, '$2y$10$q0KwaHdbZqNx.5Jsi8/xXev0EMrGKjGTEsHobrE8MkQ4R5HaKCK2G', NULL, NULL, '2024-05-20 20:33:34', '2024-05-20 20:33:34'),
(494, 'User Ke-478', 'user478@gmail.com', NULL, '$2y$10$.Q9Xd8t4CwHc2WuFfpTdNuW.WKj7hqAOcxTzuO2OWora/OAYG0z/W', NULL, NULL, '2024-05-20 20:33:34', '2024-05-20 20:33:34'),
(495, 'User Ke-479', 'user479@gmail.com', NULL, '$2y$10$GHkJmFeMWZqDFoz2liPLTOVB0rb8Jb2qGjO7GTAk7lo8cLTxmpBo.', NULL, NULL, '2024-05-20 20:33:34', '2024-05-20 20:33:34'),
(496, 'User Ke-480', 'user480@gmail.com', NULL, '$2y$10$SOg2VlN0.ul.JYS6aO7Ehex0fy8a0degGRbBOQ8pETASoDdmYOoMq', NULL, NULL, '2024-05-20 20:33:34', '2024-05-20 20:33:34'),
(497, 'User Ke-481', 'user481@gmail.com', NULL, '$2y$10$XjQWQYG.y4ic/huQP0/1BuHbbtbgdnYzonZUrLElemLOG9aMdY56m', NULL, NULL, '2024-05-20 20:33:34', '2024-05-20 20:33:34'),
(498, 'User Ke-482', 'user482@gmail.com', NULL, '$2y$10$p9JpnurH8MB3tL6BTkbbSOtfkKwzcKZ190Z5FexNWl6cLJ.CukXGK', NULL, NULL, '2024-05-20 20:33:34', '2024-05-20 20:33:34'),
(499, 'User Ke-483', 'user483@gmail.com', NULL, '$2y$10$uxRaAVmMJLFg2aS2iYUbPuPR2L.3uJHax0cPhqoL/Zkrv5aeeSaKy', NULL, NULL, '2024-05-20 20:33:34', '2024-05-20 20:33:34'),
(500, 'User Ke-484', 'user484@gmail.com', NULL, '$2y$10$uZLzqhAr4KSt0fXkcASLWe94.BcVj6bPCVvAvuhB5uO/DeXm5Hrnm', NULL, NULL, '2024-05-20 20:33:34', '2024-05-20 20:33:34'),
(501, 'User Ke-485', 'user485@gmail.com', NULL, '$2y$10$ML0UWMyew6BqUwgzRO6iIOLHBoC8o31rmmBsJj1Rku6Mz2tKZmW8G', NULL, NULL, '2024-05-20 20:33:35', '2024-05-20 20:33:35'),
(502, 'User Ke-486', 'user486@gmail.com', NULL, '$2y$10$obqtbXfhVY685zZp6DVzHuARJ01qFx4tXd1tFUST8WGGyw6ApzZim', NULL, NULL, '2024-05-20 20:33:35', '2024-05-20 20:33:35'),
(503, 'User Ke-487', 'user487@gmail.com', NULL, '$2y$10$ahf/xaFkyA8Z4Xv4UDAeQOWMCeYEaVbxZSMDEUyst5zxh7OsKAJ7K', NULL, NULL, '2024-05-20 20:33:35', '2024-05-20 20:33:35'),
(504, 'User Ke-488', 'user488@gmail.com', NULL, '$2y$10$pDzxgN9z8NkF77.92esKT.3WZJTxsgKLNJqyXk/sM7lmFNRE15Bsa', NULL, NULL, '2024-05-20 20:33:35', '2024-05-20 20:33:35'),
(505, 'User Ke-489', 'user489@gmail.com', NULL, '$2y$10$.Hz0veUNXR1OaPGeZlYbIOuu1iek80Q3HLK9PoeJFewuoyJwILuJq', NULL, NULL, '2024-05-20 20:33:35', '2024-05-20 20:33:35'),
(506, 'User Ke-490', 'user490@gmail.com', NULL, '$2y$10$4ATALVV2JprwZBQ24kBOn...SIddAFyyOexeuh31mP6jBXOyl3Sni', NULL, NULL, '2024-05-20 20:33:35', '2024-05-20 20:33:35'),
(507, 'User Ke-491', 'user491@gmail.com', NULL, '$2y$10$dO7wfRIEFhx9jm.pAB6P/ukT3FbZNRPCOt4ek.Vl.vb2cgG8l28ie', NULL, NULL, '2024-05-20 20:33:35', '2024-05-20 20:33:35'),
(508, 'User Ke-492', 'user492@gmail.com', NULL, '$2y$10$bOmLY4J9R2xWAlMoiwyFpuekTenVuASjNs9Gp4WXoIOKtKfVHq6RS', NULL, NULL, '2024-05-20 20:33:35', '2024-05-20 20:33:35'),
(509, 'User Ke-493', 'user493@gmail.com', NULL, '$2y$10$Mq9YVTsbtPLzl2HQT.Dzc.O3dWf7Zxrp0yt0.vkRuwZJ9d6GEiRSS', NULL, NULL, '2024-05-20 20:33:35', '2024-05-20 20:33:35'),
(510, 'udin', 'aaa@gmail.com', NULL, '$2y$10$pBQES3qD/wx26M/prbGFB.lneihG2YefeMNcSdGlNMMlGCaIvGppC', NULL, NULL, '2024-05-21 09:01:06', '2024-05-21 09:01:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mobils`
--
ALTER TABLE `mobils`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `rumahs`
--
ALTER TABLE `rumahs`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `mobils`
--
ALTER TABLE `mobils`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rumahs`
--
ALTER TABLE `rumahs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=511;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
--
-- Database: `latihan-project`
--
CREATE DATABASE IF NOT EXISTS `latihan-project` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `latihan-project`;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Raka Wahyu Pratama', 'rakawahyup62@gmail.com', NULL, '$2y$10$SPCnxqssHlLHX4FuzWmY8uGrfr93jITqPY6JQe4q0yWtQo6qonV8.', NULL, '2024-05-18 06:51:14', '2024-05-18 06:51:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

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
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Database: `tiketing`
--
CREATE DATABASE IF NOT EXISTS `tiketing` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `tiketing`;

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` int UNSIGNED NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_id` int UNSIGNED DEFAULT NULL,
  `subject_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int UNSIGNED DEFAULT NULL,
  `properties` text COLLATE utf8mb4_unicode_ci,
  `host` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Security Technician', '2024-07-01 05:00:08', '2024-07-01 05:00:08', NULL),
(2, 'Network Technician', '2024-07-01 05:00:08', '2024-07-01 05:00:08', NULL),
(3, 'Cloud Technician', '2024-07-01 05:00:08', '2024-07-01 05:00:08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int UNSIGNED NOT NULL,
  `author_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `author_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment_text` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ticket_id` int UNSIGNED DEFAULT NULL,
  `user_id` int UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `helpdesks`
--

CREATE TABLE `helpdesks` (
  `id` bigint UNSIGNED NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `priority_id` int UNSIGNED NOT NULL,
  `ticket_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `status_id` int UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` int UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `collection_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `conversions_disk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` bigint UNSIGNED NOT NULL,
  `manipulations` json NOT NULL,
  `custom_properties` json NOT NULL,
  `responsive_images` json NOT NULL,
  `order_column` int UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_100000_create_password_resets_table', 1),
(2, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(3, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(4, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(5, '2016_06_01_000004_create_oauth_clients_table', 1),
(6, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(7, '2019_11_09_000001_create_permissions_table', 1),
(8, '2019_11_09_000002_create_roles_table', 1),
(9, '2019_11_09_000003_create_users_table', 1),
(10, '2019_11_09_000004_create_statuses_table', 1),
(11, '2019_11_09_000005_create_priorities_table', 1),
(12, '2019_11_09_000006_create_categories_table', 1),
(13, '2019_11_09_000007_create_tickets_table', 1),
(14, '2019_11_09_000008_create_comments_table', 1),
(15, '2019_11_09_000009_create_permission_role_pivot_table', 1),
(16, '2019_11_09_000010_create_role_user_pivot_table', 1),
(17, '2019_11_09_000011_add_relationship_fields_to_tickets_table', 1),
(18, '2019_11_09_000012_add_relationship_fields_to_comments_table', 1),
(19, '2019_11_09_000013_create_audit_logs_table', 1),
(20, '2019_11_10_000001_create_media_table', 1),
(21, '2024_05_29_033514_create_helpdesks_table', 1),
(22, '2024_06_04_100634_create_jobs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `client_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `client_id` bigint UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint UNSIGNED NOT NULL,
  `client_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `title`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'user_management_access', NULL, NULL, NULL),
(2, 'permission_create', NULL, NULL, NULL),
(3, 'permission_edit', NULL, NULL, NULL),
(4, 'permission_show', NULL, NULL, NULL),
(5, 'permission_delete', NULL, NULL, NULL),
(6, 'permission_access', NULL, NULL, NULL),
(7, 'role_create', NULL, NULL, NULL),
(8, 'role_edit', NULL, NULL, NULL),
(9, 'role_show', NULL, NULL, NULL),
(10, 'role_delete', NULL, NULL, NULL),
(11, 'role_access', NULL, NULL, NULL),
(12, 'user_create', NULL, NULL, NULL),
(13, 'user_edit', NULL, NULL, NULL),
(14, 'user_show', NULL, NULL, NULL),
(15, 'user_delete', NULL, NULL, NULL),
(16, 'user_access', NULL, NULL, NULL),
(17, 'status_create', NULL, NULL, NULL),
(18, 'status_edit', NULL, NULL, NULL),
(19, 'status_show', NULL, NULL, NULL),
(20, 'status_delete', NULL, NULL, NULL),
(21, 'status_access', NULL, NULL, NULL),
(22, 'priority_create', NULL, NULL, NULL),
(23, 'priority_edit', NULL, NULL, NULL),
(24, 'priority_show', NULL, NULL, NULL),
(25, 'priority_delete', NULL, NULL, NULL),
(26, 'priority_access', NULL, NULL, NULL),
(27, 'category_create', NULL, NULL, NULL),
(28, 'category_edit', NULL, NULL, NULL),
(29, 'category_show', NULL, NULL, NULL),
(30, 'category_delete', NULL, NULL, NULL),
(31, 'category_access', NULL, NULL, NULL),
(32, 'ticket_create', NULL, NULL, NULL),
(33, 'ticket_edit', NULL, NULL, NULL),
(34, 'ticket_show', NULL, NULL, NULL),
(35, 'ticket_delete', NULL, NULL, NULL),
(36, 'ticket_access', NULL, NULL, NULL),
(37, 'comment_create', NULL, NULL, NULL),
(38, 'comment_edit', NULL, NULL, NULL),
(39, 'comment_show', NULL, NULL, NULL),
(40, 'comment_delete', NULL, NULL, NULL),
(41, 'comment_access', NULL, NULL, NULL),
(42, 'audit_log_show', NULL, NULL, NULL),
(43, 'audit_log_access', NULL, NULL, NULL),
(44, 'dashboard_access', NULL, NULL, NULL),
(45, 'helpdesk_access', NULL, NULL, NULL),
(46, 'helpdesk_create', NULL, NULL, NULL),
(47, 'helpdesk_delete', NULL, NULL, NULL),
(48, 'helpdesk_edit', NULL, NULL, NULL),
(49, 'helpdesk_show', NULL, NULL, NULL),
(50, 'helpdesk_complete', NULL, NULL, NULL),
(51, 'helpdesk_cannot_complete', NULL, NULL, NULL),
(52, 'dashboard_access_user', NULL, NULL, NULL),
(53, 'ticket_access_user', NULL, NULL, NULL),
(54, 'ticket_create_user', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `role_id` int UNSIGNED NOT NULL,
  `permission_id` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`role_id`, `permission_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 10),
(1, 11),
(1, 12),
(1, 13),
(1, 14),
(1, 15),
(1, 16),
(1, 17),
(1, 18),
(1, 19),
(1, 20),
(1, 21),
(1, 22),
(1, 23),
(1, 24),
(1, 25),
(1, 26),
(1, 27),
(1, 28),
(1, 29),
(1, 30),
(1, 31),
(1, 32),
(1, 33),
(1, 34),
(1, 35),
(1, 36),
(1, 37),
(1, 38),
(1, 39),
(1, 40),
(1, 41),
(1, 42),
(1, 43),
(1, 44),
(1, 45),
(1, 46),
(1, 47),
(1, 48),
(1, 49),
(1, 50),
(1, 51),
(1, 52),
(1, 53),
(1, 54),
(2, 33),
(2, 34),
(2, 36),
(2, 53),
(2, 54);

-- --------------------------------------------------------

--
-- Table structure for table `priorities`
--

CREATE TABLE `priorities` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `max_time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `priorities`
--

INSERT INTO `priorities` (`id`, `name`, `max_time`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Low / Level 1', '-', '2024-07-01 05:00:08', '2024-07-01 05:00:08', NULL),
(2, 'Low / Level 2', '16 Jam', '2024-07-01 05:00:08', '2024-07-01 05:00:08', NULL),
(3, 'Critical / Level 2', '2 Jam', '2024-07-01 05:00:08', '2024-07-01 05:00:08', NULL),
(4, 'Medium / Level 2', '8 Jam', '2024-07-01 05:00:08', '2024-07-01 05:00:08', NULL),
(5, 'High / Level 2', '4 Jam', '2024-07-01 05:00:08', '2024-07-01 05:00:08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `title`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin', NULL, NULL, NULL),
(2, 'Agent', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `user_id` int UNSIGNED NOT NULL,
  `role_id` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`user_id`, `role_id`) VALUES
(1, 1),
(2, 2),
(3, 2),
(4, 2);

-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

CREATE TABLE `statuses` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `statuses`
--

INSERT INTO `statuses` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Open', '2024-07-01 05:00:08', '2024-07-01 05:00:08', NULL),
(2, 'Closed', '2024-07-01 05:00:08', '2024-07-01 05:00:08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int UNSIGNED NOT NULL,
  `ticket_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `author_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `author_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `status_id` int UNSIGNED DEFAULT NULL,
  `priority_id` int UNSIGNED DEFAULT NULL,
  `category_id` int UNSIGNED DEFAULT NULL,
  `assigned_to_user_id` int UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` datetime DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin', 'admin@gmail.com', NULL, '$2y$10$yjIdD6JXGeV0gRjMwDPNqesjGCIOpkLKSfvo5oZqglbk948QePtTy', NULL, NULL, NULL, NULL),
(2, 'Agent 1', 'agent1@agent1.com', NULL, '$2y$10$aT9lJ9XVKeshkb3o93kOauiTo4IQh2ozb402t95lLbzp9unt6o9wa', NULL, NULL, NULL, NULL),
(3, 'Agent 2', 'agent2@agent2.com', NULL, '$2y$10$UnLIBQB1uZZC1r5msFWTPuZCZsMBUpZINpJ48G5FmMxz6yVGP83rO', NULL, NULL, NULL, NULL),
(4, 'Agent 3', 'agent3@agent3.com', NULL, '$2y$10$UnLIBQB1uZZC1r5msFWTPuZCZsMBUpZINpJ48G5FmMxz6yVGP83rO', NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_fk_583774` (`ticket_id`),
  ADD KEY `user_fk_583777` (`user_id`);

--
-- Indexes for table `helpdesks`
--
ALTER TABLE `helpdesks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `helpdesks_priority_id_foreign` (`priority_id`),
  ADD KEY `helpdesks_ticket_id_foreign` (`ticket_id`),
  ADD KEY `helpdesks_user_id_foreign` (`user_id`),
  ADD KEY `helpdesks_status_id_foreign` (`status_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `media_model_type_model_id_index` (`model_type`,`model_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD KEY `role_id_fk_583549` (`role_id`),
  ADD KEY `permission_id_fk_583549` (`permission_id`);

--
-- Indexes for table `priorities`
--
ALTER TABLE `priorities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD KEY `user_id_fk_583558` (`user_id`),
  ADD KEY `role_id_fk_583558` (`role_id`);

--
-- Indexes for table `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tickets_ticket_id_unique` (`ticket_id`),
  ADD KEY `tickets_user_id_index` (`user_id`),
  ADD KEY `status_fk_583763` (`status_id`),
  ADD KEY `priority_fk_583764` (`priority_id`),
  ADD KEY `category_fk_583765` (`category_id`),
  ADD KEY `assigned_to_user_fk_583768` (`assigned_to_user_id`);

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
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `helpdesks`
--
ALTER TABLE `helpdesks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `priorities`
--
ALTER TABLE `priorities`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `ticket_fk_583774` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`),
  ADD CONSTRAINT `user_fk_583777` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `helpdesks`
--
ALTER TABLE `helpdesks`
  ADD CONSTRAINT `helpdesks_priority_id_foreign` FOREIGN KEY (`priority_id`) REFERENCES `priorities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `helpdesks_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `helpdesks_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`ticket_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `helpdesks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_id_fk_583549` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_id_fk_583549` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_id_fk_583558` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_id_fk_583558` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `assigned_to_user_fk_583768` FOREIGN KEY (`assigned_to_user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `category_fk_583765` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `priority_fk_583764` FOREIGN KEY (`priority_id`) REFERENCES `priorities` (`id`),
  ADD CONSTRAINT `status_fk_583763` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`),
  ADD CONSTRAINT `tickets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
