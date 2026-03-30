-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 30, 2026 at 12:48 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pendaki_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `username`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Admin Utama', 'admin_mantap', '$2y$12$3zdiIt/okde2t4hygaLVCOCvVIDAeyXmSdIGl3Sj7bC.w5rgdgy1S', '2026-03-11 05:55:08', '2026-03-11 05:55:08');

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
-- Table structure for table `climbings`
--

CREATE TABLE `climbings` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `residence` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ticket_id` bigint UNSIGNED NOT NULL,
  `group_id` bigint UNSIGNED DEFAULT NULL,
  `guide_id` bigint UNSIGNED DEFAULT NULL,
  `status` enum('climbing','finished') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'climbing',
  `check_in_date` datetime NOT NULL,
  `check_out_date` datetime DEFAULT NULL,
  `ticket_counter_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `climbings`
--

INSERT INTO `climbings` (`id`, `name`, `residence`, `phone_number`, `ticket_id`, `group_id`, `guide_id`, `status`, `check_in_date`, `check_out_date`, `ticket_counter_id`, `created_at`, `updated_at`) VALUES
(6, 'mundut', 'besakih', '00000', 1, 2, NULL, 'finished', '2026-03-16 04:48:11', '2026-03-16 04:49:05', 1, '2026-03-15 20:48:11', '2026-03-15 20:49:05'),
(7, 'erna', 'bangli', '123456789', 1, 1, NULL, 'finished', '2026-03-16 04:59:28', '2026-03-16 05:09:50', 1, '2026-03-15 20:59:28', '2026-03-15 21:09:50'),
(8, 'gede', 'besakih', '08123456789', 1, 1, NULL, 'finished', '2026-03-16 05:21:47', '2026-03-16 05:23:17', 1, '2026-03-15 21:21:47', '2026-03-15 21:23:17'),
(9, 'john connor', 'USA', '082222', 2, 1, NULL, 'finished', '2026-03-16 05:27:27', '2026-03-16 10:50:02', 1, '2026-03-15 21:27:27', '2026-03-16 02:50:02'),
(10, 'sang tu', 'kintamani', '083333', 1, 1, NULL, 'finished', '2026-03-16 10:15:50', '2026-03-16 10:50:13', 1, '2026-03-16 02:15:50', '2026-03-16 02:50:13'),
(11, 'sakti', 'jasi', '089999', 1, 4, NULL, 'finished', '2026-03-16 10:39:24', '2026-03-16 10:50:18', 1, '2026-03-16 02:39:24', '2026-03-16 02:50:18'),
(12, 'suki suki', 'japan', '111111', 2, 4, NULL, 'finished', '2026-03-17 01:01:43', '2026-03-19 14:45:39', 1, '2026-03-16 17:01:43', '2026-03-19 06:45:39'),
(13, 'kayan', 'yogyakarta', '7777', 1, 2, NULL, 'finished', '2026-03-17 01:04:18', '2026-03-19 14:45:28', 1, '2026-03-16 17:04:18', '2026-03-19 06:45:28'),
(14, 'tyas', 'denpasar', '88888', 1, 5, NULL, 'finished', '2026-03-17 04:19:21', '2026-03-19 14:45:14', 1, '2026-03-16 20:19:21', '2026-03-19 06:45:14'),
(15, 'puspita', 'denpasar', '9999', 1, NULL, NULL, 'finished', '2026-03-17 04:25:37', '2026-03-19 14:45:05', 1, '2026-03-16 20:25:37', '2026-03-19 06:45:05'),
(16, 'jhonatan', 'denpasar', '4444', 1, 5, NULL, 'finished', '2026-03-17 04:26:01', '2026-03-19 14:44:48', 1, '2026-03-16 20:26:01', '2026-03-19 06:44:48'),
(17, 'ayuk_riska', 'menguwi', '991', 1, 6, NULL, 'finished', '2026-03-19 04:12:32', '2026-03-19 14:44:37', 1, '2026-03-18 20:12:32', '2026-03-19 06:44:37'),
(18, 'Manmansu', 'denpasar', '565656', 1, 6, NULL, 'finished', '2026-03-20 00:34:22', '2026-03-22 05:21:46', 3, '2026-03-19 16:34:22', '2026-03-21 21:21:46'),
(19, 'susuman', 'probolinggo', '676767', 1, 4, NULL, 'finished', '2026-03-20 00:34:47', '2026-03-27 13:23:57', 4, '2026-03-19 16:34:47', '2026-03-27 05:23:57'),
(20, 'reus mark', 'belgium', '1234512345', 2, 5, NULL, 'finished', '2026-03-20 00:36:22', '2026-03-27 13:23:55', 4, '2026-03-19 16:36:22', '2026-03-27 05:23:55'),
(21, 'made anom', 'Badung', '111222333', 1, 3, NULL, 'finished', '2026-03-20 00:40:30', '2026-03-27 13:23:53', 4, '2026-03-19 16:40:30', '2026-03-27 05:23:53'),
(22, 'Dek Can', 'Lampung', '141414', 1, 7, NULL, 'finished', '2026-03-20 01:54:16', '2026-03-22 10:40:25', 3, '2026-03-19 17:54:16', '2026-03-22 02:40:25'),
(23, 'mario', 'Brazil', '797979', 2, NULL, NULL, 'finished', '2026-03-20 22:53:26', '2026-03-22 10:40:22', 3, '2026-03-20 14:53:26', '2026-03-22 02:40:22'),
(24, 'Widi Marta', 'Manggis, Karangasem, Bali', '808080', 1, 5, NULL, 'finished', '2026-03-20 22:54:27', '2026-03-22 10:40:18', 3, '2026-03-20 14:54:27', '2026-03-22 02:40:18'),
(25, 'Bayu', 'Klungkung, Bali', '909090', 1, 5, NULL, 'finished', '2026-03-20 22:55:21', '2026-03-22 10:40:14', 3, '2026-03-20 14:55:21', '2026-03-22 02:40:14'),
(26, 'Gede Mundut', 'Besakih, Karangasem, Bali', '082 2222222', 1, 1, NULL, 'finished', '2026-03-22 05:24:44', '2026-03-27 13:23:51', 4, '2026-03-21 21:24:44', '2026-03-27 05:23:51'),
(27, 'Krisna', 'Denpasar, Bali', '0987654', 1, 8, NULL, 'finished', '2026-03-24 01:47:40', '2026-03-27 13:23:48', 4, '2026-03-23 17:47:40', '2026-03-27 05:23:48'),
(28, 'wira', 'Kintamani, Bangli,Bali', '09990', 1, 8, NULL, 'finished', '2026-03-24 01:48:41', '2026-03-27 13:23:46', 4, '2026-03-23 17:48:41', '2026-03-27 05:23:46'),
(29, 'yoga', 'Karangasem, Bali', '08880', 1, NULL, NULL, 'finished', '2026-03-24 01:49:43', '2026-03-27 13:23:44', 4, '2026-03-23 17:49:43', '2026-03-27 05:23:44'),
(30, 'pratama', 'Klungkung, Bali', '07770', 1, 8, NULL, 'finished', '2026-03-24 01:50:38', '2026-03-27 13:23:42', 4, '2026-03-23 17:50:38', '2026-03-27 05:23:42'),
(34, 'Jhonson', 'portugal', '55555', 2, 3, NULL, 'finished', '2026-03-26 05:59:47', '2026-03-26 07:16:03', 4, '2026-03-25 21:59:47', '2026-03-25 23:16:03'),
(35, 'ita', 'denpasar', '1111', 1, NULL, NULL, 'finished', '2026-03-26 07:15:28', '2026-03-27 13:20:40', 4, '2026-03-25 23:15:28', '2026-03-27 05:20:40'),
(36, 'bill', 'Englend', '404040', 2, NULL, NULL, 'finished', '2026-03-27 13:22:29', '2026-03-30 00:01:58', 5, '2026-03-27 05:22:29', '2026-03-29 16:01:58'),
(37, 'macho kim', 'south korea', '0232323', 2, 2, NULL, 'climbing', '2026-03-30 00:04:50', NULL, NULL, '2026-03-29 16:04:50', '2026-03-29 16:04:50'),
(38, 'Adi Suan', 'Pempatan, Rendang, Karangasem, Bali', '08567567', 1, 1, NULL, 'climbing', '2026-03-30 00:06:50', NULL, NULL, '2026-03-29 16:06:50', '2026-03-29 16:06:50'),
(39, 'Komang Aditya', 'Besakih, Karangasem, Bali', '08345345', 1, 4, NULL, 'climbing', '2026-03-30 00:07:37', NULL, NULL, '2026-03-29 16:07:37', '2026-03-29 16:07:37'),
(40, 'martin', 'spain', '09160160160', 2, 3, NULL, 'climbing', '2026-03-30 00:13:12', NULL, NULL, '2026-03-29 16:13:12', '2026-03-29 16:13:12');

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
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guide_id` bigint UNSIGNED NOT NULL,
  `climbing_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`, `guide_id`, `climbing_date`, `created_at`, `updated_at`) VALUES
(1, '', NULL, 1, '2026-03-11', '2026-03-11 14:53:33', NULL),
(2, '', NULL, 2, '2026-03-11', '2026-03-12 01:20:24', NULL),
(3, '', NULL, 3, '2026-03-16', '2026-03-16 10:37:24', NULL),
(4, '', NULL, 4, '2026-03-16', NULL, NULL),
(5, 'MansuDaki', 'Reguler', 2, '2026-03-17', '2026-03-16 20:18:04', '2026-03-16 20:18:04'),
(6, 'Hita_Upakara', 'Reguler', 1, '2026-03-19', '2026-03-18 19:41:07', '2026-03-18 19:41:07'),
(7, 'Pendaki Lampung', 'Reguler', 5, '2026-03-20', '2026-03-19 17:53:39', '2026-03-19 17:53:39'),
(8, 'Pendaki GMPA Primakara', 'Reguler', 6, '2026-03-24', '2026-03-23 17:45:36', '2026-03-23 17:45:36');

-- --------------------------------------------------------

--
-- Table structure for table `guides`
--

CREATE TABLE `guides` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `date_of_birth` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `guides`
--

INSERT INTO `guides` (`id`, `name`, `email`, `phone`, `description`, `date_of_birth`, `created_at`, `updated_at`) VALUES
(1, 'Pande Suardana', 'pande@mail.com', '08123456789', 'Setia terhadap darma kebenaran dan juga sang mahaguru mandara sentanu', '2000-03-02', '2026-03-03 23:53:22', NULL),
(2, 'Mandara', 'mandara1@gmail.com', '08121212', 'mandara sang naha guru penyeimbang dunia', '2004-04-04', '2026-03-12 01:20:24', NULL),
(3, 'dek adi', 'Adi_Akustik@gmail.com', '08121212', 'teman mansu sejati', NULL, '2026-03-16 02:30:32', '2026-03-16 02:30:32'),
(4, 'mundut', 'darmayasa@gmail.com', '08131313', 'guide lokal besakih', '1997-03-08', '2026-03-16 02:36:25', '2026-03-16 02:36:25'),
(5, 'RYU', 'ryu1@gmail.com', '131313', 'Penanggung jawab grup pendaki lampung', '2003-03-01', '2026-03-19 17:52:49', '2026-03-19 17:52:49'),
(6, 'Dira Wirawan', 'DiraW@gmail.com', '09876', 'Guide Lokal Besakih', '1998-11-26', '2026-03-23 17:44:44', '2026-03-23 17:44:44'),
(7, 'komang', 'komang1@gmail.com', '242424', 'ssdvsfdsefedsdfedsdcd', '2001-01-01', '2026-03-26 06:05:34', '2026-03-26 06:05:34');

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
(4, '2026_03_01_073931_create_guides_table', 1),
(5, '2026_03_02_071519_create_groups_table', 1),
(6, '2026_03_02_073740_create_ticket_counters_table', 1),
(7, '2026_03_02_074011_create_tickets_table', 1),
(8, '2026_03_03_070624_create_climbers_table', 1),
(9, '2026_03_03_073844_create_admins_table', 1),
(10, '2026_03_17_020140_add_guide_id_to_climbings_table', 2);

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

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('E8j7cUTUkgznoCSkNXP9isrbX9bLBb9LXaG89RD7', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibXl4dm8yTjI2bWVYUFVTZ29nSlhQNmg2YVR2eVh3d2VFN0wybzY1SCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NjQ6Imh0dHA6Ly9sb2NhbGhvc3QvUGVuZGFraV9BcHAtbWFpbi9wdWJsaWMvYWRtaW4vcmVrYXAtYnVsYW5hbi9wZGYiO3M6NToicm91dGUiO3M6MTU6ImFkbWluLnJla2FwLnBkZiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTI6ImxvZ2luX2FkbWluXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1774829696),
('u6JlVabFz41Cs3XA43bpoFNH6b15WHqVpvMoRp4D', 5, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRlVQa01FUWZBYUtkNXZGSVdZc3lHUXkxZ2ZuZDVpVjE0V3N0RDluNiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NjU6Imh0dHA6Ly9sb2NhbGhvc3QvUGVuZGFraV9BcHAtbWFpbi9wdWJsaWMvdGlja2V0LWNvdW50ZXIvZGFzaGJvYXJkIjtzOjU6InJvdXRlIjtzOjE2OiJ0aWNrZXQuZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo2MToibG9naW5fdGlja2V0X2NvdW50ZXJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo1O30=', 1774829266);

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `name`, `price`, `created_at`, `updated_at`) VALUES
(1, 'Domestik', 25000, '2026-03-11 05:55:09', '2026-03-11 05:55:09'),
(2, 'Mancanegara', 50000, '2026-03-11 05:55:09', '2026-03-11 05:55:09');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_counters`
--

CREATE TABLE `ticket_counters` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_of_birth` date NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_login_at` datetime DEFAULT NULL,
  `last_logout_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ticket_counters`
--

INSERT INTO `ticket_counters` (`id`, `name`, `email`, `address`, `date_of_birth`, `password`, `last_login_at`, `last_logout_at`, `created_at`, `updated_at`) VALUES
(1, 'Petugas Loket 1', 'loket1@example.com', 'Jl. Raya Pendaki No. 10', '1995-05-20', '$2y$12$TTvc6MI8j/Jdh2fFM7bPVefLwUYneY2eHwuoNvAsxSX68Ah1fSsV.', NULL, NULL, '2026-03-11 05:55:09', '2026-03-11 05:55:09'),
(3, 'I GEDE PANDE SUARDANA YASA', 'GRaaa@gmail.com', 'Besakih', '2003-03-09', '$2y$12$wVzgXooNZne0DwBWKnM1XuWRJEYvqge0G5pSI0o3sjWJGs9oU6R/i', '2026-03-27 13:26:43', '2026-03-27 13:27:08', '2026-03-19 17:32:57', '2026-03-27 05:27:08'),
(4, 'I Nyoman Mandara Sentanu', 'mansu@gmail.com', 'Kedisan, Kintamani', '2004-04-04', '$2y$12$mHGKbMZkvIuBb/ur8yFe5.U9HQF0Ez2Q7Bod4nrGzZuaYpRsVOfuW', '2026-03-27 13:26:18', '2026-03-27 13:26:22', '2026-03-19 17:46:59', '2026-03-27 05:26:22'),
(5, 'erna watik', 'watierna@gmail.com', 'wkwkwk', '2004-04-10', '$2y$12$2KBmO8QaNZ5.q50DB4NoCOmueVQYx3Keblus3DWqbLgeKEsaEQJZe', '2026-03-30 00:01:36', NULL, '2026-03-28 18:17:57', '2026-03-29 16:01:36');

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
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_username_unique` (`username`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `climbings`
--
ALTER TABLE `climbings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `climbings_ticket_id_foreign` (`ticket_id`),
  ADD KEY `climbings_group_id_foreign` (`group_id`),
  ADD KEY `climbings_ticket_counter_id_foreign` (`ticket_counter_id`),
  ADD KEY `climbings_guide_id_foreign` (`guide_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `groups_guide_id_foreign` (`guide_id`);

--
-- Indexes for table `guides`
--
ALTER TABLE `guides`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `guides_email_unique` (`email`);

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
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticket_counters`
--
ALTER TABLE `ticket_counters`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ticket_counters_email_unique` (`email`);

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
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `climbings`
--
ALTER TABLE `climbings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `guides`
--
ALTER TABLE `guides`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ticket_counters`
--
ALTER TABLE `ticket_counters`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `climbings`
--
ALTER TABLE `climbings`
  ADD CONSTRAINT `climbings_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `climbings_guide_id_foreign` FOREIGN KEY (`guide_id`) REFERENCES `guides` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `climbings_ticket_counter_id_foreign` FOREIGN KEY (`ticket_counter_id`) REFERENCES `ticket_counters` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `climbings_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `groups`
--
ALTER TABLE `groups`
  ADD CONSTRAINT `groups_guide_id_foreign` FOREIGN KEY (`guide_id`) REFERENCES `guides` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
