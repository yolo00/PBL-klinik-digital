-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 12, 2026 at 03:47 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `klinikdigital1`
--

-- --------------------------------------------------------

--
-- Table structure for table `akun_user`
--

CREATE TABLE `akun_user` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `no_hp` varchar(15) DEFAULT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `foto_profil` varchar(255) DEFAULT NULL,
  `role` enum('A','D','P') NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `akun_user`
--

INSERT INTO `akun_user` (`id`, `email`, `password`, `nama`, `no_hp`, `jenis_kelamin`, `tgl_lahir`, `foto_profil`, `role`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'admin@gmail.com', '$2y$12$3je6M1aGszEoRk8Z86y7RO75Db0m2a43K4QsdCgbng0NyPfa3/iye', 'Klinik Admin', NULL, NULL, NULL, NULL, 'A', '2026-05-24 05:53:00', NULL, NULL),
(27, 'tirtapratama@klinik.com', '$2y$12$xalnmbqNw6icZ8l4U5C5VeIjiT9BMNDtPeqf19N9t.JpSyy/gf87O', 'Tirta Pratama', '082156283293', 'L', '1994-04-29', 'foto_profil/foto_1783648698_27.jpg', 'D', '2026-07-10 01:58:18', '2026-07-10 01:58:18', NULL),
(28, 'aisyah@klinik.com', '$2y$12$ZpwM4VyGCNYlabtW4bgyXODS7TO6JJ.8Xq57Q64aA.6GAn.1UeLEm', 'Nur Aisyah Bukit Lestari', '081245452301', 'P', '1989-09-22', 'foto_profil/foto_1783648794_28.jpg', 'D', '2026-07-10 01:59:54', '2026-07-10 01:59:54', NULL),
(29, 'kevinsitumorang@gmail.com', '$2y$12$cs9QICRsqnhoT9XEBg0IxOnltpXhXVlAIvM2ergc5bKDF9MqWqO/W', 'Kevin Situmorang', '081719051904', 'L', '1992-08-13', 'foto_profil/foto_1783648938_29.jpg', 'D', '2026-07-10 02:02:18', '2026-07-10 02:02:18', NULL),
(30, 'oliviahartono@klinik.com', '$2y$12$5S.sz1/vBWJpjLpXvcdJ6Oz1gsexM2zvVyx9YkXVxkZOxsjNIJuE2', 'Olivia Hartono', '081234567890', 'P', '1997-01-30', 'foto_profil/foto_1783649035_30.jpg', 'D', '2026-07-10 02:03:55', '2026-07-10 02:03:55', NULL),
(31, 'michelle@klinik.com', '$2y$12$RC4l.62zQCrKxaL3A6UJZuuaB5kUHlC9VcI.3Wb7Px4yz9eT2rJxW', 'Michelle Gunawan', '08451256997', 'P', '1997-10-25', 'foto_profil/foto_1783649157_31.jpg', 'D', '2026-07-10 02:05:57', '2026-07-10 02:05:57', NULL),
(32, 'alex@gmail.com', '$2y$12$QVphnZnwGbDiLQscy.Sare5ynuWS54TAXRr3A6mpv1IK0nNE/uIvi', 'Alex Situmorang', '083106057812', 'L', '2002-12-20', NULL, 'P', '2026-07-10 02:09:01', NULL, NULL),
(33, 'acbdfehhs1@gmail.com', '$2y$12$wOTemhsQX0wPI2ZNRKjufuVvLYC6uCbqSatyQGY4GvZZ1Qn4ma7Ke', 'Michael Sando Turnip', '081372079904', 'L', '2007-07-04', NULL, 'P', '2026-07-12 08:21:10', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `alergi`
--

CREATE TABLE `alergi` (
  `id` int(11) NOT NULL,
  `id_pasien` int(11) NOT NULL,
  `nama_alergi` varchar(100) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cuti_dokter`
--

CREATE TABLE `cuti_dokter` (
  `id` int(11) NOT NULL,
  `id_dokter` int(11) NOT NULL,
  `dari_tanggal` date NOT NULL,
  `sampai_tanggal` date NOT NULL,
  `alasan` varchar(255) NOT NULL,
  `status` enum('pending','disetujui','ditolak') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dokter`
--

CREATE TABLE `dokter` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_spesialisasi` int(11) NOT NULL,
  `pendidikan` varchar(70) DEFAULT NULL,
  `dokumen_sip` varchar(255) DEFAULT NULL,
  `tanda_tangan` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dokter`
--

INSERT INTO `dokter` (`id`, `id_user`, `id_spesialisasi`, `pendidikan`, `dokumen_sip`, `tanda_tangan`, `deleted_at`) VALUES
(12, 27, 1, 'S1 Kedokteran Umum, Universitas Indonesia', NULL, NULL, NULL),
(13, 28, 2, 'Spesialis Penyakit Dalam, Universitas Airlangga', NULL, NULL, NULL),
(14, 29, 3, 'Profesi Dokter Gigi, Universitas Padjadjaran', NULL, NULL, NULL),
(15, 30, 4, 'Spesialis Kesehatan Anak, Universitas Gadjah Mada', NULL, NULL, NULL),
(16, 31, 5, 'S1 Kedokteran Umum, Universitas Diponegoro', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jadwal`
--

CREATE TABLE `jadwal` (
  `id` int(11) NOT NULL,
  `id_dokter` int(11) NOT NULL,
  `id_pasien` int(11) DEFAULT NULL,
  `tanggal` date NOT NULL,
  `jam` tinyint(2) NOT NULL,
  `status` enum('menunggu','dikonfirmasi','selesai','dibatalkan') NOT NULL DEFAULT 'menunggu',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jadwal`
--

INSERT INTO `jadwal` (`id`, `id_dokter`, `id_pasien`, `tanggal`, `jam`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(45, 12, 13, '2026-06-08', 10, 'selesai', '2026-06-07 02:12:44', '2026-06-08 03:22:52', NULL),
(46, 13, 13, '2026-06-17', 15, 'selesai', '2026-06-08 03:24:42', '2026-06-17 03:29:54', NULL),
(47, 12, 13, '2026-07-11', 11, 'selesai', '2026-07-10 15:56:50', '2026-07-12 07:09:29', NULL),
(48, 12, 14, '2026-07-13', 16, 'selesai', '2026-07-12 08:37:36', '2026-07-13 01:43:50', NULL),
(49, 16, 14, '2026-07-13', 15, 'menunggu', '2026-07-13 02:03:36', '2026-07-13 02:03:36', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_dokter`
--

CREATE TABLE `jadwal_dokter` (
  `id` int(11) NOT NULL,
  `id_dokter` int(11) NOT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu') NOT NULL,
  `jam_mulai` tinyint(2) NOT NULL,
  `jam_selesai` tinyint(2) NOT NULL,
  `override_istirahat_mulai` tinyint(2) DEFAULT NULL,
  `override_istirahat_selesai` tinyint(2) DEFAULT NULL,
  `is_aktif` tinyint(1) NOT NULL DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jadwal_dokter`
--

INSERT INTO `jadwal_dokter` (`id`, `id_dokter`, `hari`, `jam_mulai`, `jam_selesai`, `override_istirahat_mulai`, `override_istirahat_selesai`, `is_aktif`, `deleted_at`) VALUES
(1, 12, 'Senin', 8, 17, 12, 13, 1, NULL),
(2, 12, 'Selasa', 8, 17, 12, 13, 1, NULL),
(3, 12, 'Rabu', 8, 17, 12, 13, 1, NULL),
(4, 12, 'Kamis', 8, 17, 12, 13, 1, NULL),
(5, 12, 'Jumat', 8, 16, 12, 14, 1, NULL),
(6, 12, 'Sabtu', 7, 17, 12, 14, 1, NULL),
(7, 13, 'Senin', 8, 17, 12, 13, 1, NULL),
(8, 13, 'Selasa', 8, 17, 12, 13, 1, NULL),
(9, 13, 'Rabu', 8, 17, 12, 13, 1, NULL),
(10, 13, 'Kamis', 8, 17, 12, 13, 1, NULL),
(11, 13, 'Jumat', 8, 16, 12, 14, 1, NULL),
(12, 13, 'Sabtu', 7, 17, 12, 14, 1, NULL),
(13, 14, 'Senin', 8, 17, 12, 13, 1, NULL),
(14, 14, 'Selasa', 8, 17, 12, 13, 1, NULL),
(15, 14, 'Rabu', 8, 17, 12, 13, 1, NULL),
(16, 14, 'Kamis', 8, 17, 12, 13, 1, NULL),
(17, 14, 'Jumat', 8, 16, 12, 14, 1, NULL),
(18, 14, 'Sabtu', 7, 17, 12, 14, 1, NULL),
(19, 15, 'Senin', 8, 17, 12, 13, 1, NULL),
(20, 15, 'Selasa', 8, 17, 12, 13, 1, NULL),
(21, 15, 'Rabu', 8, 17, 12, 13, 1, NULL),
(22, 15, 'Kamis', 8, 17, 12, 13, 1, NULL),
(23, 15, 'Jumat', 8, 16, 12, 14, 1, NULL),
(24, 15, 'Sabtu', 7, 17, 12, 14, 1, NULL),
(25, 16, 'Senin', 8, 17, 12, 13, 1, NULL),
(26, 16, 'Selasa', 8, 17, 12, 13, 1, NULL),
(27, 16, 'Rabu', 8, 17, 12, 13, 1, NULL),
(28, 16, 'Kamis', 8, 17, 12, 13, 1, NULL),
(29, 16, 'Jumat', 8, 16, 12, 14, 1, NULL),
(30, 16, 'Sabtu', 7, 17, 12, 14, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_sistem`
--

CREATE TABLE `jadwal_sistem` (
  `id` int(11) NOT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu') DEFAULT NULL,
  `jam_buka` tinyint(2) DEFAULT NULL,
  `jam_tutup` tinyint(2) DEFAULT NULL,
  `jam_istirahat_mulai` tinyint(2) DEFAULT NULL,
  `jam_istirahat_selesai` tinyint(2) DEFAULT NULL,
  `is_libur` tinyint(1) NOT NULL DEFAULT 0,
  `keterangan` varchar(100) DEFAULT NULL,
  `tgl_khusus` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jadwal_sistem`
--

INSERT INTO `jadwal_sistem` (`id`, `hari`, `jam_buka`, `jam_tutup`, `jam_istirahat_mulai`, `jam_istirahat_selesai`, `is_libur`, `keterangan`, `tgl_khusus`, `created_at`, `updated_at`, `deleted_at`) VALUES
(0, NULL, NULL, NULL, NULL, NULL, 1, 'Tahun Baru Islam 1448 H', '2026-07-17', '2026-07-10 14:03:19', NULL, NULL),
(1, 'Senin', 8, 17, 12, 13, 0, NULL, NULL, '2026-07-10 14:03:19', NULL, NULL),
(2, 'Selasa', 8, 17, 12, 13, 0, NULL, NULL, '2026-07-10 14:03:19', NULL, NULL),
(3, 'Rabu', 8, 17, 12, 13, 0, NULL, NULL, '2026-07-10 14:03:19', NULL, NULL),
(4, 'Kamis', 8, 17, 12, 13, 0, NULL, NULL, '2026-07-10 14:03:19', NULL, NULL),
(5, 'Jumat', 8, 16, 12, 14, 0, NULL, NULL, '2026-07-10 14:03:19', NULL, NULL),
(6, 'Sabtu', 7, 17, 12, 14, 0, NULL, NULL, '2026-07-10 14:03:19', NULL, NULL),
(7, 'Minggu', NULL, NULL, NULL, NULL, 1, 'Libur', NULL, '2026-07-10 14:03:19', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `notifikasi`
--

CREATE TABLE `notifikasi` (
  `id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `message` varchar(255) NOT NULL,
  `ref_tabel` varchar(50) DEFAULT NULL,
  `ref_id` int(11) DEFAULT NULL,
  `is_urgent` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifikasi`
--

INSERT INTO `notifikasi` (`id`, `type`, `message`, `ref_tabel`, `ref_id`, `is_urgent`, `created_by`, `created_at`) VALUES
(22, 'Janji Temu Baru', 'Alex Situmorang membuat janji temu pada 10:00, 08 Juni 2026.', 'jadwal', 45, 0, 32, '2026-06-07 02:12:44'),
(23, 'Rekam Medis Baru', 'Dr. Tirta Pratama telah membuat rekam medis untuk kunjungan Anda pada 08 Juni 2026.', 'rekam_medis', 8, 0, 27, '2026-06-08 03:22:52'),
(24, 'Konfirmasi Pembayaran Cash', 'Jadwal Alex Situmorang dengan Dr. Tirta Pratama telah selesai. Metode pembayaran: Cash. Mohon konfirmasi pembayaran.', 'pembayaran', 43, 0, 27, '2026-06-08 03:22:52'),
(25, 'Pembayaran Berhasil', 'Pembayaran Cash sebesar Rp 50.000 untuk jadwal pada 08 Juni 2026 telah dikonfirmasi oleh admin. Nomor struk: -.', 'pembayaran', 43, 0, 1, '2026-06-08 03:23:38'),
(26, 'Janji Temu Baru', 'Alex Situmorang membuat janji temu pada 15:00, 17 Juni 2026.', 'jadwal', 46, 0, 32, '2026-06-08 03:24:42'),
(27, 'Rekam Medis Baru', 'Dr. Nur Aisyah Bukit Lestari telah membuat rekam medis untuk kunjungan Anda pada 17 Juni 2026.', 'rekam_medis', 9, 0, 28, '2026-06-17 03:29:54'),
(28, 'Pembayaran Berhasil', 'Pembayaran QRIS sebesar Rp 90.000 untuk jadwal pada 17 Juni 2026 berhasil. Nomor struk: STR-20260710-044.', 'pembayaran', 44, 0, 32, '2026-07-10 15:40:14'),
(29, 'Janji Temu Baru', 'Alex Situmorang membuat janji temu pada 11:00, 11 Juli 2026.', 'jadwal', 47, 0, 32, '2026-07-10 15:56:50'),
(30, 'Jadwal Tidak Ditangani', 'Jadwal Anda pada 11:00, 11 Juli 2026 dengan Dr. Tirta Pratama tidak ditangani. Silakan buat jadwal baru.', 'jadwal', 47, 0, NULL, '2026-07-12 07:09:04'),
(31, 'Jadwal Terlewatkan', 'Jadwal Alex Situmorang pada 11:00, 11 Juli 2026 telah terlewatkan.', 'jadwal', 47, 0, NULL, '2026-07-12 07:09:04'),
(32, 'Jadwal Tidak Ditangani', 'Jadwal Alex Situmorang dengan Dr. Tirta Pratama pada 11:00, 11 Juli 2026 tidak ditangani dan dibatalkan otomatis.', 'jadwal', 47, 0, NULL, '2026-07-12 07:09:04'),
(33, 'Rekam Medis Baru', 'Dr. Tirta Pratama telah membuat rekam medis untuk kunjungan Anda pada 11 Juli 2026.', 'rekam_medis', 10, 0, 27, '2026-07-12 07:09:29'),
(34, 'Janji Temu Baru', 'Michael Sando Turnip membuat janji temu pada 16:00, 13 Juli 2026.', 'jadwal', 48, 0, 33, '2026-07-12 08:37:36'),
(35, 'Rekam Medis Baru', 'Dr. Tirta Pratama telah membuat rekam medis untuk kunjungan Anda pada 13 Juli 2026.', 'rekam_medis', 11, 0, 27, '2026-07-13 01:43:50'),
(36, 'Janji Temu Baru Hari Ini', 'Michael Sando Turnip membuat janji temu pada 15:00 hari ini.', 'jadwal', 49, 1, 33, '2026-07-13 02:03:36'),
(37, 'Pembayaran Berhasil', 'Pembayaran Cash sebesar Rp 80.000 untuk jadwal pada 13 Juli 2026 telah dikonfirmasi oleh admin. Nomor struk: -.', 'pembayaran', 47, 0, 1, '2026-07-13 02:04:56');

-- --------------------------------------------------------

--
-- Table structure for table `notifikasi_penerima`
--

CREATE TABLE `notifikasi_penerima` (
  `id` int(11) NOT NULL,
  `id_notifikasi` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `is_seen` tinyint(1) NOT NULL DEFAULT 0,
  `seen_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifikasi_penerima`
--

INSERT INTO `notifikasi_penerima` (`id`, `id_notifikasi`, `id_user`, `is_seen`, `seen_at`) VALUES
(22, 22, 27, 1, '2026-06-07 02:13:35'),
(23, 23, 32, 1, '2026-07-10 15:40:21'),
(24, 24, 1, 1, '2026-06-08 03:23:34'),
(25, 25, 32, 1, '2026-07-10 15:40:21'),
(26, 26, 28, 1, '2026-07-10 15:42:02'),
(27, 27, 32, 1, '2026-07-10 15:40:21'),
(28, 28, 32, 1, '2026-07-10 15:40:21'),
(29, 29, 27, 0, NULL),
(30, 30, 32, 0, NULL),
(31, 31, 27, 0, NULL),
(32, 32, 1, 1, '2026-07-13 02:01:33'),
(33, 33, 32, 0, NULL),
(34, 34, 27, 0, NULL),
(35, 35, 33, 0, NULL),
(36, 36, 31, 0, NULL),
(37, 37, 33, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pasien`
--

CREATE TABLE `pasien` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `gol_darah` enum('A','B','AB','O') DEFAULT NULL,
  `riwayat_penyakit` text DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pasien`
--

INSERT INTO `pasien` (`id`, `id_user`, `gol_darah`, `riwayat_penyakit`, `deleted_at`) VALUES
(13, 32, NULL, NULL, NULL),
(14, 33, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` int(11) NOT NULL,
  `id_jadwal` int(11) NOT NULL,
  `jumlah` decimal(10,2) NOT NULL,
  `metode` enum('cash','qris','transfer') NOT NULL,
  `status` enum('pending','lunas','batal') NOT NULL DEFAULT 'pending',
  `nomor_struk` varchar(50) DEFAULT NULL,
  `pesan` varchar(50) DEFAULT NULL,
  `xendit_external_id` varchar(100) DEFAULT NULL,
  `xendit_qr_id` varchar(100) DEFAULT NULL,
  `qr_string` text DEFAULT NULL,
  `payment_expired_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id`, `id_jadwal`, `jumlah`, `metode`, `status`, `nomor_struk`, `pesan`, `xendit_external_id`, `xendit_qr_id`, `qr_string`, `payment_expired_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(43, 45, 50000.00, 'cash', 'lunas', NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-07 02:12:44', '2026-06-08 03:23:38', NULL),
(44, 46, 90000.00, 'qris', 'lunas', 'STR-20260710-044', 'Konfirmasi manual (sandbox)', 'KLINIK-44-1783697787', 'qr_85035e6f-e2e1-4a97-96b5-a6faa37236f5', 'some-random-qr-string', '2026-07-10 15:51:27', '2026-06-08 03:24:42', '2026-07-10 15:40:14', NULL),
(45, 47, 50000.00, 'qris', 'pending', NULL, NULL, 'KLINIK-45-1783847062', 'qr_4608a33a-2431-4f3b-9530-f0e89142fe95', 'some-random-qr-string', '2026-07-12 09:19:22', '2026-07-10 15:56:50', '2026-07-12 09:04:23', NULL),
(46, 48, 50000.00, 'qris', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-12 08:37:36', '2026-07-12 08:37:36', NULL),
(47, 49, 80000.00, 'cash', 'lunas', NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-13 02:03:36', '2026-07-13 02:04:56', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rekam_medis`
--

CREATE TABLE `rekam_medis` (
  `id` int(11) NOT NULL,
  `id_jadwal` int(11) NOT NULL,
  `keluhan` text DEFAULT NULL,
  `diagnosa` text DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `is_final` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rekam_medis`
--

INSERT INTO `rekam_medis` (`id`, `id_jadwal`, `keluhan`, `diagnosa`, `catatan`, `is_final`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(8, 45, 'Demam selama 2 hari, sakit kepala, nyeri otot, dan nafsu makan menurun.', 'Influenza (Flu)', NULL, 1, 27, 27, '2026-06-08 03:22:47', '2026-06-08 03:22:52', NULL),
(9, 46, 'Nyeri ulu hati sejak 1 minggu, disertai mual terutama setelah makan dan perut terasa kembung.', 'Gastritis Akut', NULL, 1, 28, 28, '2026-06-17 03:29:39', '2026-06-17 03:29:54', NULL),
(10, 47, 'Sakit perut besar', 'aaa', 'aaa', 1, 27, 27, '2026-07-12 07:09:23', '2026-07-12 07:09:29', NULL),
(11, 48, 'complaint', 'diagnoses', 'extra notes', 1, 27, 27, '2026-07-13 01:43:43', '2026-07-13 01:43:50', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `resep`
--

CREATE TABLE `resep` (
  `id` int(11) NOT NULL,
  `id_rekam` int(11) NOT NULL,
  `obat` varchar(100) NOT NULL,
  `dosis` varchar(50) DEFAULT NULL,
  `aturan_pakai` text DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `resep`
--

INSERT INTO `resep` (`id`, `id_rekam`, `obat`, `dosis`, `aturan_pakai`, `deleted_at`) VALUES
(7, 8, 'Paracetamol', '500 mg', '3 x 1 sehari', NULL),
(8, 8, 'Vitamin C', '500 mg', '1 x 1 sehari selama 5 hari', NULL),
(9, 9, 'Omeprazole', '20 mg', '1x1 Sehari sebelum sarapan selama 14 hari', NULL),
(10, 9, 'Antasida', '60 ml', '3×1 setelah makan bila perlu', NULL),
(11, 11, 'medicine', 'dose', 'use', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `spesialisasi`
--

CREATE TABLE `spesialisasi` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `base_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `spesialisasi`
--

INSERT INTO `spesialisasi` (`id`, `nama`, `base_price`, `deleted_at`) VALUES
(1, 'Dokter Umum', 50000.00, NULL),
(2, 'Dokter Penyakit Dalam', 90000.00, NULL),
(3, 'Dokter Gigi', 60000.00, NULL),
(4, 'Dokter Kesehatan Anak', 80000.00, NULL),
(5, 'Dokter Mata', 80000.00, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akun_user`
--
ALTER TABLE `akun_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cuti_dokter`
--
ALTER TABLE `cuti_dokter`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cuti_dokter` (`id_dokter`);

--
-- Indexes for table `dokter`
--
ALTER TABLE `dokter`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_dokter_user` (`id_user`),
  ADD KEY `fk_dokter_spesialisasi` (`id_spesialisasi`);

--
-- Indexes for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_jadwal_slot` (`id_dokter`,`tanggal`,`jam`),
  ADD KEY `fk_jadwal_pasien` (`id_pasien`);

--
-- Indexes for table `jadwal_dokter`
--
ALTER TABLE `jadwal_dokter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jadwal_sistem`
--
ALTER TABLE `jadwal_sistem`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_notif_creator` (`created_by`);

--
-- Indexes for table `notifikasi_penerima`
--
ALTER TABLE `notifikasi_penerima`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_notif_user` (`id_notifikasi`,`id_user`),
  ADD KEY `fk_np_notifikasi` (`id_notifikasi`),
  ADD KEY `fk_np_user` (`id_user`),
  ADD KEY `idx_np_user_seen` (`id_user`,`is_seen`);

--
-- Indexes for table `pasien`
--
ALTER TABLE `pasien`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pasien_user` (`id_user`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `xendit_external_id` (`xendit_external_id`),
  ADD KEY `fk_pembayaran_jadwal` (`id_jadwal`);

--
-- Indexes for table `rekam_medis`
--
ALTER TABLE `rekam_medis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_rekam_jadwal` (`id_jadwal`),
  ADD KEY `fk_rekam_created_by` (`created_by`),
  ADD KEY `fk_rekam_updated_by` (`updated_by`);

--
-- Indexes for table `resep`
--
ALTER TABLE `resep`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_resep_rekam` (`id_rekam`);

--
-- Indexes for table `spesialisasi`
--
ALTER TABLE `spesialisasi`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `akun_user`
--
ALTER TABLE `akun_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `cuti_dokter`
--
ALTER TABLE `cuti_dokter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `dokter`
--
ALTER TABLE `dokter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `jadwal_dokter`
--
ALTER TABLE `jadwal_dokter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `jadwal_sistem`
--
ALTER TABLE `jadwal_sistem`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `notifikasi_penerima`
--
ALTER TABLE `notifikasi_penerima`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `pasien`
--
ALTER TABLE `pasien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `rekam_medis`
--
ALTER TABLE `rekam_medis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `resep`
--
ALTER TABLE `resep`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
