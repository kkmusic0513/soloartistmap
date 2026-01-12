-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2026-01-12 06:26:36
-- サーバのバージョン： 10.4.32-MariaDB
-- PHP のバージョン: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `soloartistmap`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `artists`
--

CREATE TABLE `artists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `prefecture` varchar(255) NOT NULL,
  `genre` varchar(255) DEFAULT NULL,
  `profile` text DEFAULT NULL,
  `official_website` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `youtube_link` varchar(255) DEFAULT NULL,
  `soundcloud_link` varchar(255) DEFAULT NULL,
  `twitter_link` varchar(255) DEFAULT NULL,
  `photos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`photos`)),
  `main_photo` varchar(255) DEFAULT NULL,
  `sub_photo_1` varchar(255) DEFAULT NULL,
  `sub_photo_2` varchar(255) DEFAULT NULL,
  `is_approved` int(11) NOT NULL DEFAULT 0,
  `is_public` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `artists`
--

INSERT INTO `artists` (`id`, `user_id`, `name`, `prefecture`, `genre`, `profile`, `official_website`, `photo`, `youtube_link`, `soundcloud_link`, `twitter_link`, `photos`, `main_photo`, `sub_photo_1`, `sub_photo_2`, `is_approved`, `is_public`, `created_at`, `updated_at`) VALUES
(1, 2, 'ASREFRAIN', '愛知県', 'ロック', '名古屋で結成。豪快さと繊細さを併せ持ち、交錯する男女ツインボーカルを武器にギターロック・オルタナティブロックを基軸としながらも、エレクトロ・エモ・プログレ等様々な音楽ジャンルを吸収し独自の音を生み出し続けている。 またライブでは、まるでドラマを観ているような世界観と共に、圧倒的かつスリリングなステージで常に観ている人々を魅了している。\r\n\r\nGt&Vo kk / Vo&Gt I / Bass Nomu / Drums Doi', 'https://asrefrain.info/', NULL, NULL, NULL, NULL, NULL, 'artist_photos/Qmn82HraFwCVrCr1IkKHxzkaVi5ZWuItEll57V2Y.png', 'artist_photos/Ecr6F5uO4vkekFQq79xl1sInnOoz3BENte6n2wkR.png', 'artist_photos/PgO9TExqxtKmWcSE6jni8ra8Dcs88XW5qL3IHDJZ.png', 1, 1, '2025-12-09 19:40:01', '2025-12-09 19:40:01'),
(42, 1, 'テストアーティスト 1', '北海道', 'アイドル', 'テストアーティスト1のプロフィールテキストです。', NULL, NULL, NULL, NULL, NULL, '[]', 'artist_photos/TOcc6vQHmahSJuzUsXXNCFsiIYXiQ4tU7GBjhiFD.jpg', NULL, NULL, 1, 1, '2025-12-09 20:21:01', '2025-12-09 20:21:01'),
(43, 1, 'テストアーティスト 2', '愛媛県', 'J-POP', 'テストアーティスト2のプロフィールテキストです。', NULL, NULL, NULL, NULL, NULL, '[]', 'artist_photos/tB8VL8Fkc0AVMmy9vH166nVoJz8v5MscaJ778DZm.jpg', NULL, NULL, 1, 1, '2025-12-09 20:21:01', '2025-12-09 20:21:01'),
(44, 2, 'テストアーティスト 3テストアーティスト 3テストアーティスト 3テストアーティスト 3', '鹿児島県', 'メタル', 'テストアーティスト3のプロフィールテキストです。', NULL, NULL, NULL, NULL, NULL, '[]', 'artist_photos/cM5UiPRy8oHj7hgmV7TXFIzgGDMVQXY1ATUzn8ca.jpg', NULL, NULL, 1, 1, '2025-12-09 20:21:01', '2026-01-11 20:10:36'),
(45, 2, 'テストアーティスト 4', '兵庫県', 'エレクトロ / テクノ', 'テストアーティスト4のプロフィールテキストです。', NULL, NULL, NULL, NULL, NULL, '[]', 'artist_photos/s4gjjtK8mVrUw1H5bNFFLzz1Y6u00hSpL5d7QXBl.jpg', NULL, NULL, 1, 1, '2025-12-09 20:21:01', '2026-01-11 20:10:41'),
(46, 2, 'テストアーティスト 5', '香川県', 'インストゥルメンタル', 'テストアーティスト5のプロフィールテキストです。', NULL, NULL, NULL, NULL, NULL, '[]', 'artist_photos/dvdZ3fqFwxNuM63lZAJBQoMidyUhLc7ahiEUsiDd.jpg', NULL, NULL, 1, 1, '2025-12-09 20:21:01', '2026-01-11 20:10:46'),
(47, 1, 'テストアーティスト 6', '滋賀県', 'アニソン / ゲーム音楽', 'テストアーティスト6のプロフィールテキストです。', NULL, NULL, NULL, NULL, NULL, '[]', 'artist_photos/3vo5VVyB1x00mtPRHeyZMUTCouZuVCdd2FSr29Bx.jpg', NULL, NULL, 1, 1, '2025-12-09 20:21:01', '2025-12-09 20:21:01'),
(48, 1, 'テストアーティスト 7', '奈良県', 'R&B / ソウル', 'テストアーティスト7のプロフィールテキストです。', NULL, NULL, NULL, NULL, NULL, '[]', 'artist_photos/cmKtmRQNEJQ8VRIGNQHvUheIvsd1tiqotkCFTA2X.jpg', NULL, NULL, 1, 1, '2025-12-09 20:21:01', '2025-12-09 20:21:01'),
(49, 1, 'テストアーティスト 8', '鳥取県', 'J-POP', 'テストアーティスト8のプロフィールテキストです。', NULL, NULL, NULL, NULL, NULL, '[]', 'artist_photos/4yYBs59A96UX95RTHQ27UdWH1ZHVjvlaWEA34CrI.jpg', NULL, NULL, 1, 1, '2025-12-09 20:21:01', '2025-12-09 20:21:01'),
(50, 2, 'テストアーティスト 9', '徳島県', 'インストゥルメンタル', 'テストアーティスト9のプロフィールテキストです。', NULL, NULL, NULL, NULL, NULL, '[]', 'artist_photos/z7c937ruzGKOtIPgax6AA2GELVOM6FqTL33AQGbV.jpg', NULL, NULL, 1, 1, '2025-12-09 20:21:01', '2026-01-11 20:10:52'),
(51, 2, 'テストアーティスト 10', '神奈川県', 'ヒップホップ', 'テストアーティスト10のプロフィールテキストです。', NULL, NULL, NULL, NULL, NULL, '[]', 'artist_photos/BgrzdpB20vQB4WGMyo7oCQcG945IKfHx3xCNO3I0.jpg', NULL, NULL, 1, 1, '2025-12-09 20:21:01', '2025-12-09 20:21:01'),
(52, 1, 'テストアーティスト 11', '奈良県', 'クラシック / ジャズ', 'テストアーティスト11のプロフィールテキストです。', NULL, NULL, NULL, NULL, NULL, '[]', 'artist_photos/aI746sYanc9a99tn5pKMsX02czOM36xubxtmUukT.jpg', NULL, NULL, 1, 1, '2025-12-09 20:21:01', '2025-12-09 20:21:01'),
(53, 1, 'テストアーティスト 12', '埼玉県', 'J-POP', 'テストアーティスト12のプロフィールテキストです。', NULL, NULL, NULL, NULL, NULL, '[]', 'artist_photos/BMzA6uGSt57RfUq1YKiASdp4NIdsJrNth7PFdvGQ.jpg', NULL, NULL, 1, 1, '2025-12-09 20:21:01', '2025-12-09 20:21:01'),
(54, 2, 'テストアーティスト 13', '広島県', 'J-POP', 'テストアーティスト13のプロフィールテキストです。', NULL, NULL, NULL, NULL, NULL, '[]', 'artist_photos/mRHrMcaK7LPBCFfC1d6s5rsIFVFgEDwKsuaddNEV.jpg', NULL, NULL, 1, 1, '2025-12-09 20:21:01', '2025-12-09 20:21:01'),
(55, 1, 'テストアーティスト 14', '香川県', 'J-POP', 'テストアーティスト14のプロフィールテキストです。', NULL, NULL, NULL, NULL, NULL, '[]', 'artist_photos/ApyKk9NwxLLznEmQeSYVbJCKJkmTIdwW12I3bSlL.jpg', NULL, NULL, 1, 1, '2025-12-09 20:21:01', '2025-12-09 20:21:01'),
(56, 1, 'テストアーティスト 15', '沖縄県', 'ロック', 'テストアーティスト15のプロフィールテキストです。', NULL, NULL, NULL, NULL, NULL, '[]', 'artist_photos/yG67UV2cZw10kBW1hGsjUGmj4PRhiQniWE7v8MDw.jpg', NULL, NULL, 1, 1, '2025-12-09 20:21:01', '2025-12-09 20:21:01'),
(57, 1, 'テストアーティスト 16', '石川県', 'クラシック / ジャズ', 'テストアーティスト16のプロフィールテキストです。', NULL, NULL, NULL, NULL, NULL, '[]', 'artist_photos/MRc7HOlyEnBSO9Sg8r659kYeGUeyUPJ0qqBmcK9S.jpg', NULL, NULL, 1, 1, '2025-12-09 20:21:01', '2025-12-09 20:21:01'),
(58, 1, 'テストアーティスト 17', '岐阜県', 'ヒップホップ', 'テストアーティスト17のプロフィールテキストです。', NULL, NULL, NULL, NULL, NULL, '[]', 'artist_photos/n33GUwez5q0OcQvtpsYGgFsIXXEvXJDuT3Thwn7Q.jpg', NULL, NULL, 1, 1, '2025-12-09 20:21:01', '2025-12-09 20:21:01'),
(59, 2, 'テストアーティスト 18', '長崎県', 'エレクトロ / テクノ', 'テストアーティスト18のプロフィールテキストです。', NULL, NULL, NULL, NULL, NULL, '[]', 'artist_photos/1PgeAioKVkpNPTNB64DTrRq0YnufAJhMOraBI8Ek.jpg', NULL, NULL, 1, 1, '2025-12-09 20:21:01', '2025-12-09 20:21:01'),
(60, 2, 'テストアーティスト 19', '福岡県', 'その他', 'テストアーティスト19のプロフィールテキストです。', NULL, NULL, NULL, NULL, NULL, '[]', 'artist_photos/QofLZS4ktKZ8Xx6fWFHVchPohiHyj7ty1B6MxOP6.jpg', NULL, NULL, 0, 1, '2025-12-09 20:21:01', '2026-01-11 20:10:09'),
(61, 1, 'テストアーティスト 20', '栃木県', 'クラシック / ジャズ', 'テストアーティスト20のプロフィールテキストです。', NULL, NULL, NULL, NULL, NULL, '[]', 'artist_photos/SJH9e5WqhPk2piSbutrUw5dIewG27cjO4sXgGGV5.jpg', NULL, NULL, 1, 1, '2025-12-09 20:21:01', '2025-12-09 20:21:01');

-- --------------------------------------------------------

--
-- テーブルの構造 `artist_photos`
--

CREATE TABLE `artist_photos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `artist_id` bigint(20) UNSIGNED NOT NULL,
  `path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `artist_videos`
--

CREATE TABLE `artist_videos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `artist_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `youtube_url` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `artist_videos`
--

INSERT INTO `artist_videos` (`id`, `artist_id`, `title`, `youtube_url`, `created_at`, `updated_at`) VALUES
(3, 1, 'mv', 'https://www.youtube.com/embed/dbw-ACUzHy4', '2025-12-09 21:31:23', '2025-12-09 21:31:23');

-- --------------------------------------------------------

--
-- テーブルの構造 `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('-cache-info@kkmusic.info|127.0.0.1', 'i:2;', 1768185359),
('-cache-info@kkmusic.info|127.0.0.1:timer', 'i:1768185359;', 1768185359);

-- --------------------------------------------------------

--
-- テーブルの構造 `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `dm_messages`
--

CREATE TABLE `dm_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `thread_id` bigint(20) UNSIGNED NOT NULL,
  `from_user_id` bigint(20) UNSIGNED NOT NULL,
  `artist_id` bigint(20) UNSIGNED DEFAULT NULL,
  `from_artist_id` bigint(20) UNSIGNED DEFAULT NULL,
  `to_user_id` bigint(20) UNSIGNED NOT NULL,
  `to_artist_id` bigint(20) UNSIGNED DEFAULT NULL,
  `message` text NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `dm_threads`
--

CREATE TABLE `dm_threads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user1_id` bigint(20) UNSIGNED NOT NULL,
  `user2_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `events`
--

CREATE TABLE `events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `artist_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `start_at` datetime NOT NULL,
  `end_at` datetime DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `events`
--

INSERT INTO `events` (`id`, `artist_id`, `title`, `description`, `start_at`, `end_at`, `location`, `photo`, `created_at`, `updated_at`) VALUES
(1, 44, 'テストイベント', 'テストイベント', '2026-01-15 11:49:00', '2026-01-15 22:54:00', 'テスト会場', 'events/1768186219_6964616b4b0ae.jpg', '2026-01-11 17:50:20', '2026-01-11 17:50:20'),
(2, 44, 'テストイベント2', 'テストイベント2', '2026-01-17 11:50:00', '2026-01-17 17:50:00', 'テスト会場', NULL, '2026-01-11 17:50:53', '2026-01-11 17:50:53'),
(3, 45, 'テストアーティスト 4 イベント名', 'テストアーティスト 4\r\nイベント名', '2026-01-31 12:09:00', '2026-01-31 23:09:00', 'テストアーティスト 4 イベント名', NULL, '2026-01-11 18:09:20', '2026-01-11 18:09:20'),
(4, 45, 'テストアーティスト 4 イベント名', 'テストアーティスト 4\r\nイベント名', '2026-01-30 16:09:00', '2026-01-30 18:14:00', 'テストアーティスト 4 イベント名', NULL, '2026-01-11 18:09:44', '2026-01-11 18:09:44');

-- --------------------------------------------------------

--
-- テーブルの構造 `failed_jobs`
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
-- テーブルの構造 `jobs`
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
-- テーブルの構造 `job_batches`
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
-- テーブルの構造 `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_11_07_061805_create_artists_table', 1),
(5, '2025_11_10_131120_add_photo_to_artists_table', 1),
(6, '2025_11_10_131641_create_artist_photos_table', 1),
(7, '2025_11_10_134005_add_photos_to_artists_table', 1),
(8, '2025_11_10_134810_add_role_to_users_table', 1),
(9, '2025_11_12_061037_add_user_id_to_artists_table', 1),
(10, '2025_11_18_061946_add_user_id_to_artists_table', 1),
(11, '2025_11_18_063045_change_is_approved_to_integer_in_artists_table', 1),
(12, '2025_11_20_043017_add_artist_photos_columns_to_artists_table', 1),
(13, '2025_11_20_073707_add_official_website_to_artists_table', 1),
(14, '2025_11_20_084303_create_events_table', 1),
(15, '2025_11_25_083825_create_dm_threads_table', 1),
(16, '2025_11_25_083826_create_dm_messages_table', 1),
(17, '2025_12_04_042112_add_artist_ids_to_dm_messages_table', 1),
(18, '2025_12_04_044540_add_artist_id_to_dm_messages_table', 1),
(19, '2025_12_04_060048_add_image_path_to_dm_messages_table', 1),
(20, '2025_12_10_060734_create_artist_videos_table', 2),
(21, '2026_01_12_050843_add_is_public_to_artists_table', 3);

-- --------------------------------------------------------

--
-- テーブルの構造 `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `sessions`
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
-- テーブルのデータのダンプ `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('PH0S9mE4ybRVVKM2YAIKFXAhYNgbwaOn7rpUXDVx', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWmdXenV3NVR3YUVYSDhaNnZyWFFnbElTSGtnRWJBTDQyNkh4QUxpdSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9', 1768195519);

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
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
  `role` varchar(255) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`) VALUES
(1, 'Test User', 'test@example.com', NULL, '$2y$12$CXhVdD1DLKxP3GR3YZmg.uxZt5yI9eTesfHa1FuvyCwYFQpGvKc/i', NULL, '2025-12-09 19:37:38', '2025-12-09 19:37:38', 'user'),
(2, 'kk', 'kk@kkmusic.info', NULL, '$2y$12$KjJT8K7apt/fAdLiI8.IKO2j7hqhNLIrB5GX9CVpVzWm87nyOuo/y', NULL, '2025-12-09 19:38:56', '2025-12-09 19:38:56', 'user');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `artists`
--
ALTER TABLE `artists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `artists_user_id_foreign` (`user_id`);

--
-- テーブルのインデックス `artist_photos`
--
ALTER TABLE `artist_photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `artist_photos_artist_id_foreign` (`artist_id`);

--
-- テーブルのインデックス `artist_videos`
--
ALTER TABLE `artist_videos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `artist_videos_artist_id_foreign` (`artist_id`);

--
-- テーブルのインデックス `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- テーブルのインデックス `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- テーブルのインデックス `dm_messages`
--
ALTER TABLE `dm_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dm_messages_thread_id_foreign` (`thread_id`),
  ADD KEY `dm_messages_from_user_id_foreign` (`from_user_id`),
  ADD KEY `dm_messages_to_user_id_foreign` (`to_user_id`),
  ADD KEY `dm_messages_from_artist_id_foreign` (`from_artist_id`),
  ADD KEY `dm_messages_to_artist_id_foreign` (`to_artist_id`),
  ADD KEY `dm_messages_artist_id_foreign` (`artist_id`);

--
-- テーブルのインデックス `dm_threads`
--
ALTER TABLE `dm_threads`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dm_threads_user1_id_user2_id_unique` (`user1_id`,`user2_id`),
  ADD KEY `dm_threads_user2_id_foreign` (`user2_id`);

--
-- テーブルのインデックス `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `events_artist_id_foreign` (`artist_id`);

--
-- テーブルのインデックス `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- テーブルのインデックス `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- テーブルのインデックス `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- テーブルのインデックス `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `artists`
--
ALTER TABLE `artists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- テーブルの AUTO_INCREMENT `artist_photos`
--
ALTER TABLE `artist_photos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `artist_videos`
--
ALTER TABLE `artist_videos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- テーブルの AUTO_INCREMENT `dm_messages`
--
ALTER TABLE `dm_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `dm_threads`
--
ALTER TABLE `dm_threads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- テーブルの AUTO_INCREMENT `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- テーブルの AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- ダンプしたテーブルの制約
--

--
-- テーブルの制約 `artists`
--
ALTER TABLE `artists`
  ADD CONSTRAINT `artists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- テーブルの制約 `artist_photos`
--
ALTER TABLE `artist_photos`
  ADD CONSTRAINT `artist_photos_artist_id_foreign` FOREIGN KEY (`artist_id`) REFERENCES `artists` (`id`) ON DELETE CASCADE;

--
-- テーブルの制約 `artist_videos`
--
ALTER TABLE `artist_videos`
  ADD CONSTRAINT `artist_videos_artist_id_foreign` FOREIGN KEY (`artist_id`) REFERENCES `artists` (`id`) ON DELETE CASCADE;

--
-- テーブルの制約 `dm_messages`
--
ALTER TABLE `dm_messages`
  ADD CONSTRAINT `dm_messages_artist_id_foreign` FOREIGN KEY (`artist_id`) REFERENCES `artists` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `dm_messages_from_artist_id_foreign` FOREIGN KEY (`from_artist_id`) REFERENCES `artists` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `dm_messages_from_user_id_foreign` FOREIGN KEY (`from_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `dm_messages_thread_id_foreign` FOREIGN KEY (`thread_id`) REFERENCES `dm_threads` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `dm_messages_to_artist_id_foreign` FOREIGN KEY (`to_artist_id`) REFERENCES `artists` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `dm_messages_to_user_id_foreign` FOREIGN KEY (`to_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- テーブルの制約 `dm_threads`
--
ALTER TABLE `dm_threads`
  ADD CONSTRAINT `dm_threads_user1_id_foreign` FOREIGN KEY (`user1_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `dm_threads_user2_id_foreign` FOREIGN KEY (`user2_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- テーブルの制約 `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_artist_id_foreign` FOREIGN KEY (`artist_id`) REFERENCES `artists` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
