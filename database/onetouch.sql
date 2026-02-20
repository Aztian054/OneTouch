-- ============================================================
--  ONE TOUCH — Balai PPMHKP Lampung
--  Database Export: onetouch.sql
--  Generated: 2025
--  Charset: utf8mb4 | Collation: utf8mb4_unicode_ci
--
--  CARA IMPORT:
--  1. Buat database baru:  CREATE DATABASE onetouch CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
--  2. Import:              mysql -u root onetouch < database/onetouch.sql
--  3. Atau via phpMyAdmin: pilih database 'onetouch' → Import → pilih file ini
-- ============================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+07:00";

-- ============================================================
--  TABLE: migrations
-- ============================================================
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_reset_tokens_table', 1),
('2019_08_19_000000_create_failed_jobs_table', 1),
('2019_12_14_000001_create_personal_access_tokens_table', 1),
('2024_01_01_000001_create_sertifikats_table', 1),
('2024_01_01_000002_create_inspeksis_table', 1),
('2024_01_01_000003_create_data_skms_table', 1),
('2024_01_01_000004_create_data_ekspors_table', 1);

-- ============================================================
--  TABLE: password_reset_tokens
-- ============================================================
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
--  TABLE: failed_jobs
-- ============================================================
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
--  TABLE: personal_access_tokens
-- ============================================================
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
--  TABLE: users
-- ============================================================
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','officer','user') NOT NULL DEFAULT 'user',
  `company_name` varchar(255) DEFAULT NULL,
  `officer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_officer_id_foreign` (`officer_id`),
  CONSTRAINT `users_officer_id_foreign` FOREIGN KEY (`officer_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Password untuk semua akun: password123
-- Hash di bawah adalah bcrypt dari 'password123'
INSERT INTO `users` (`id`, `name`, `username`, `email`, `password`, `role`, `company_name`, `officer_id`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin',        'admin',    'admin@onetouch.test',    '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin',   NULL,                NULL, NOW(), NOW()),
(2, 'Officer Inspeksi A', 'officer',  'officer@onetouch.test',  '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'officer', NULL,                NULL, NOW(), NOW()),
(3, 'Officer Inspeksi B', 'officer2', 'officer2@onetouch.test', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'officer', NULL,                NULL, NOW(), NOW()),
(4, 'PT. Bahari Makmur',  'user',     'user@onetouch.test',     '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user',    'PT. Bahari Makmur', 2,    NOW(), NOW()),
(5, 'KM. Samudra Jaya',   'user2',    'user2@onetouch.test',    '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user',    'KM. Samudra Jaya',  2,    NOW(), NOW());

-- ============================================================
--  TABLE: sertifikats
-- ============================================================
CREATE TABLE IF NOT EXISTS `sertifikats` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `nama_pemilik` varchar(255) NOT NULL,
  `nomor_sertifikat` varchar(255) NOT NULL,
  `ruang_lingkup` varchar(255) NOT NULL,
  `jenis_sertifikat` enum('HACCP','SKP','SPDI','HC','CBIB','CPIB','CPIB Kapal','CPPIB','CPOIB','CDOIB') NOT NULL,
  `grade` enum('A','B','C') NOT NULL DEFAULT 'A',
  `tanggal_terbit` date NOT NULL,
  `tanggal_kadaluwarsa` date NOT NULL,
  `status_masa` enum('aktif','warning','expired') NOT NULL DEFAULT 'aktif',
  `status_proses` enum('Pending','Process','Completed') NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sertifikats_user_id_foreign` (`user_id`),
  KEY `sertifikats_created_by_foreign` (`created_by`),
  CONSTRAINT `sertifikats_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `sertifikats_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Sample data sertifikat
INSERT INTO `sertifikats` (`user_id`, `created_by`, `nama_pemilik`, `nomor_sertifikat`, `ruang_lingkup`, `jenis_sertifikat`, `grade`, `tanggal_terbit`, `tanggal_kadaluwarsa`, `status_masa`, `status_proses`, `created_at`, `updated_at`) VALUES
(4, 2, 'PT. Bahari Makmur', 'HACCP/LPG/2024/001', 'Pengolahan Udang Beku', 'HACCP', 'A', '2024-01-15', '2026-01-15', 'aktif', 'Completed', NOW(), NOW()),
(4, 2, 'PT. Bahari Makmur', 'SKP/LPG/2024/002', 'Kapal Penangkap Ikan > 30GT', 'SKP', 'A', '2024-03-01', '2025-03-01', 'warning', 'Completed', NOW(), NOW()),
(4, 2, 'PT. Bahari Makmur', 'CPIB/LPG/2024/003', 'Budidaya Udang Vannamei', 'CPIB', 'B', '2024-06-10', '2026-06-10', 'aktif', 'Process', NOW(), NOW()),
(5, 2, 'KM. Samudra Jaya', 'HACCP/LPG/2024/004', 'Pengolahan Ikan Tuna', 'HACCP', 'A', '2024-02-20', '2026-02-20', 'aktif', 'Completed', NOW(), NOW()),
(5, 2, 'KM. Samudra Jaya', 'HC/LPG/2024/005', 'Health Certificate Ekspor', 'HC', 'A', '2024-04-01', '2024-12-31', 'expired', 'Completed', NOW(), NOW()),
(5, 2, 'KM. Samudra Jaya', 'SPDI/LPG/2024/006', 'Sertifikat Produk Domestik', 'SPDI', 'B', '2024-07-15', '2025-07-15', 'aktif', 'Pending', NOW(), NOW());

-- ============================================================
--  TABLE: inspeksis
-- ============================================================
CREATE TABLE IF NOT EXISTS `inspeksis` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `nama_perusahaan` varchar(255) NOT NULL,
  `tanggal` date NOT NULL,
  `kategori` enum('Inspeksi','Surveilan') NOT NULL,
  `jenis_sertifikat` enum('HACCP','SKP','SPDI','HC','CBIB','CPIB','CPIB Kapal','CPPIB','CPOIB','CDOIB') NOT NULL,
  `berkas_path` varchar(500) DEFAULT NULL,
  `status_berkas` enum('Terkirim','Tidak Ada') NOT NULL DEFAULT 'Tidak Ada',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `inspeksis_user_id_foreign` (`user_id`),
  KEY `inspeksis_created_by_foreign` (`created_by`),
  CONSTRAINT `inspeksis_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `inspeksis_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Sample data inspeksi
INSERT INTO `inspeksis` (`user_id`, `created_by`, `nama_perusahaan`, `tanggal`, `kategori`, `jenis_sertifikat`, `berkas_path`, `status_berkas`, `created_at`, `updated_at`) VALUES
(4, 2, 'PT. Bahari Makmur', '2024-02-10', 'Inspeksi',  'HACCP',      NULL, 'Terkirim',  NOW(), NOW()),
(4, 2, 'PT. Bahari Makmur', '2024-05-20', 'Surveilan', 'HACCP',      NULL, 'Terkirim',  NOW(), NOW()),
(4, 2, 'PT. Bahari Makmur', '2024-08-15', 'Inspeksi',  'SKP',        NULL, 'Tidak Ada', NOW(), NOW()),
(5, 2, 'KM. Samudra Jaya',  '2024-03-05', 'Inspeksi',  'HACCP',      NULL, 'Terkirim',  NOW(), NOW()),
(5, 2, 'KM. Samudra Jaya',  '2024-06-12', 'Surveilan', 'HACCP',      NULL, 'Tidak Ada', NOW(), NOW()),
(5, 2, 'KM. Samudra Jaya',  '2024-09-18', 'Inspeksi',  'SPDI',       NULL, 'Terkirim',  NOW(), NOW());

-- ============================================================
--  TABLE: data_skms
-- ============================================================
CREATE TABLE IF NOT EXISTS `data_skms` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tahun` year(4) NOT NULL,
  `target` decimal(5,2) NOT NULL,
  `realisasi` decimal(5,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data SKM 2019-2024 (skala 1-5)
INSERT INTO `data_skms` (`tahun`, `target`, `realisasi`, `created_at`, `updated_at`) VALUES
(2019, 3.20, 3.35, NOW(), NOW()),
(2020, 3.40, 3.52, NOW(), NOW()),
(2021, 3.50, 3.61, NOW(), NOW()),
(2022, 3.60, 3.78, NOW(), NOW()),
(2023, 3.75, 3.89, NOW(), NOW()),
(2024, 3.85, 4.02, NOW(), NOW());

-- ============================================================
--  TABLE: data_ekspors
-- ============================================================
CREATE TABLE IF NOT EXISTS `data_ekspors` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `bulan` tinyint(3) UNSIGNED NOT NULL,
  `tahun` year(4) NOT NULL,
  `frekuensi` int(11) NOT NULL,
  `volume` decimal(12,2) NOT NULL,
  `nilai` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data Ekspor 2023 (volume dalam ton, nilai dalam USD)
INSERT INTO `data_ekspors` (`bulan`, `tahun`, `frekuensi`, `volume`, `nilai`, `created_at`, `updated_at`) VALUES
(1,  2023, 8,  245.50,  892500.00,  NOW(), NOW()),
(2,  2023, 6,  198.20,  721800.00,  NOW(), NOW()),
(3,  2023, 10, 312.80,  1138720.00, NOW(), NOW()),
(4,  2023, 9,  278.60,  1014490.00, NOW(), NOW()),
(5,  2023, 11, 345.90,  1259427.00, NOW(), NOW()),
(6,  2023, 12, 389.20,  1417778.00, NOW(), NOW()),
(7,  2023, 10, 325.40,  1185708.00, NOW(), NOW()),
(8,  2023, 13, 412.70,  1502270.00, NOW(), NOW()),
(9,  2023, 11, 356.80,  1299064.00, NOW(), NOW()),
(10, 2023, 14, 445.30,  1621043.00, NOW(), NOW()),
(11, 2023, 12, 398.60,  1451786.00, NOW(), NOW()),
(12, 2023, 15, 478.90,  1743478.00, NOW(), NOW()),
-- Data Ekspor 2024
(1,  2024, 9,  268.30,  977093.00,  NOW(), NOW()),
(2,  2024, 7,  214.70,  782009.00,  NOW(), NOW()),
(3,  2024, 11, 338.50,  1232770.00, NOW(), NOW()),
(4,  2024, 10, 302.40,  1100736.00, NOW(), NOW()),
(5,  2024, 12, 372.60,  1357266.00, NOW(), NOW()),
(6,  2024, 13, 415.80,  1514562.00, NOW(), NOW()),
(7,  2024, 11, 349.20,  1272324.00, NOW(), NOW()),
(8,  2024, 14, 438.90,  1598649.00, NOW(), NOW()),
(9,  2024, 12, 381.50,  1389465.00, NOW(), NOW()),
(10, 2024, 15, 468.70,  1707319.00, NOW(), NOW()),
(11, 2024, 13, 421.30,  1533533.00, NOW(), NOW()),
(12, 2024, 16, 502.40,  1829744.00, NOW(), NOW());

SET FOREIGN_KEY_CHECKS = 1;

-- ============================================================
--  END OF FILE
--  Total tables: 9
--  Total demo users: 5 (1 admin, 2 officer, 2 user)
--  Default password untuk semua akun: password123
-- ============================================================
