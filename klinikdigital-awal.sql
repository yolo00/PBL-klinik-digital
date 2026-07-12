-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 12, 2026 at 03:48 PM
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
-- Database: `klinikdigital`
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
(1, 'acbdfehhs1@gmail.com', '$2y$12$3je6M1aGszEoRk8Z86y7RO75Db0m2a43K4QsdCgbng0NyPfa3/iye', 'Administrator', '081100000000', NULL, NULL, NULL, 'A', '2026-05-24 12:53:00', NULL, NULL),
(2, 'feynsiber26@gmail.com', '$2y$12$3je6M1aGszEoRk8Z86y7RO75Db0m2a43K4QsdCgbng0NyPfa3/iye', 'Dr. Budi Santoso', '081211111111', 'L', '1980-03-06', NULL, 'D', '2026-05-24 12:53:00', '2026-06-04 13:27:47', NULL),
(3, 'dr.siti@klinik.com', '$2y$12$3je6M1aGszEoRk8Z86y7RO75Db0m2a43K4QsdCgbng0NyPfa3/iye', 'Dr. Siti Rahayu', '081222222222', 'P', '1985-08-20', NULL, 'D', '2026-05-24 12:53:00', NULL, NULL),
(4, 'bubungchii27@gmail.com', '$2y$12$3je6M1aGszEoRk8Z86y7RO75Db0m2a43K4QsdCgbng0NyPfa3/iye', 'Aprillia Bunga Lestari', '08533454545', 'P', '1995-03-15', NULL, 'P', '2026-05-24 12:53:00', '2026-06-05 11:56:24', NULL),
(5, 'rina@gmail.com', '$2y$12$3je6M1aGszEoRk8Z86y7RO75Db0m2a43K4QsdCgbng0NyPfa3/iye', 'Rina Marlina', '085444444444', 'P', '2000-07-22', NULL, 'P', '2026-05-24 12:53:00', NULL, NULL),
(6, 'joko@gmail.com', '$2y$12$3je6M1aGszEoRk8Z86y7RO75Db0m2a43K4QsdCgbng0NyPfa3/iye', 'Joko Prabowo', '085555555555', 'L', '1990-11-30', NULL, 'P', '2026-05-24 12:53:00', NULL, NULL),
(8, 'mcmr385@gmail.com', '$2y$12$3je6M1aGszEoRk8Z86y7RO75Db0m2a43K4QsdCgbng0NyPfa3/iye', 'Michael Sando Trnip', '081211111111', 'P', '2026-05-29', NULL, 'P', '2026-05-28 23:50:27', NULL, NULL),
(9, 'hehee7@gmail.com', '$2y$12$rnuf4bbYZNmIkc7x8pi9mOGRaqvL7UUMRta3VJzKx.DvtlSKucDbG', 'Michael Jackson', '18412926412', 'L', '1958-08-29', NULL, 'P', '2026-05-31 09:21:29', NULL, NULL),
(10, 'kingenong22@gmail.com', '$2y$12$b/QTLxA8OhjUCLncz.un1ekl8ythmkjeiZaopJfK/o4uMjRTUk8aC', 'Acimalaka Siahaan', '12349828462', 'L', '2004-07-02', NULL, 'P', '2026-06-02 04:15:53', NULL, NULL),
(11, 'Tastas111@g.com', '$2y$12$C097Yadq7/kLmiV4rnPPz.ekPI4aTjVSf.cSSSsb7RbsApf1P.Izu', 'Anas bananas Tastas', '0812345678', 'L', '2026-06-25', NULL, 'D', '2026-06-04 13:28:37', NULL, NULL),
(12, 'kkagus67@gmail.com', '$2y$12$lm3fgPm99qJDzSts6hAz2OP9L1KkfOQCGCj82DGtQUavEJGg47bsi', 'Rafaela Sumitiano', '0812345678', 'P', '2018-07-04', NULL, 'D', '2026-06-04 13:51:56', NULL, NULL),
(14, '87yudikatiflegislatif@gmail.com', '$2y$12$zn3Dl.cf9qKkkigTYARIlutoJ7SloQqP8GuqEzn4hCqwBHQoLTjYK', 'Marvin Situmorang', '188818881888', 'L', '2008-07-31', NULL, 'D', '2026-06-04 14:47:45', NULL, NULL),
(16, '````````````````````````````````````````````````````````````````````````````````````````````````@a.a', '$2y$12$T403EBAG7gxgbds/VH5QHOjIOjbV41.ydgU3Hw.RJJivMn2e7Ztsy', '324234243242342334`````````````a```````````````````````````````````````````````````````````````````|', '11111111', 'L', '2026-06-03', NULL, 'P', '2026-06-25 10:26:24', NULL, NULL),
(17, 'aku45@gmail.com', '$2y$12$yhv7ny1NFymMTPUIfG1AkOSMnj9PU5qbpDgBFiC7q7cPvjGv8oYb2', 'Pedro Diddy Simanjuntak', '123123', 'L', '2026-06-11', NULL, 'D', '2026-06-25 10:42:59', NULL, NULL),
(18, 'juli@a', '$2y$12$9ykIL3mwzBK5MXQx755YdO8qqEyMOdW/ggusKklnvblRJVdWea9Dm', 'Socrater Simanurung', '1', 'P', '2026-06-04', NULL, 'P', '2026-06-25 16:34:13', NULL, NULL),
(19, 'yasura88@gmail.com', '$2y$12$uM4aftavZi6O3r5UblRgWeBX0d1honxPxeNb4cxTiYVsdGXzuCUJe', 'Aditya Surya', '1237878123', 'L', '1999-06-17', NULL, 'P', '2026-06-26 08:57:33', NULL, NULL),
(20, 'atla2@gmail.com', '$2y$12$PVTaOE02H4UKwMe6MpXt9Ok7fzlBtIadE6aXvxRoX.G2oWc8UXCMe', 'Teriti Sek Borg', '656565', 'P', '2005-06-02', NULL, 'P', '2026-06-26 09:11:06', NULL, NULL),
(21, 'ucokesayangan1@gmail.com', '$2y$12$.4Vl5Tvj/Yc3z8U473zcWub2492JkB0qKcmHAdx2iwNFbsSgLiSI6', 'Didit Ucok', '08135647382', 'L', '2002-10-31', NULL, 'P', '2026-06-26 06:39:48', '2026-06-26 06:44:36', '2026-06-26 06:44:36'),
(22, 'cahayaterang@gmail.com', '$2y$12$CT5aM1mtPI84Kn2BGiACce7Du8T7kd9T4ijb8hQ3UbmODY8cIr1Wi', 'Cahyati Simunorang', '085333333333', 'P', '2006-11-11', NULL, 'D', '2026-06-26 09:19:34', NULL, NULL);

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

--
-- Dumping data for table `alergi`
--

INSERT INTO `alergi` (`id`, `id_pasien`, `nama_alergi`, `deleted_at`) VALUES
(3, 3, 'Seafood', NULL),
(10, 1, 'Penisilin', NULL),
(11, 1, 'Debu', NULL),
(12, 1, 'Kacang Tanah', NULL),
(13, 10, 'Aku', NULL),
(14, 10, 'Kamu', NULL),
(15, 10, 'Dan kisah kita berdua <3', NULL);

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

--
-- Dumping data for table `cuti_dokter`
--

INSERT INTO `cuti_dokter` (`id`, `id_dokter`, `dari_tanggal`, `sampai_tanggal`, `alasan`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, '2026-06-10', '2026-06-12', 'Keperluan keluarga', 'disetujui', '2026-05-24 12:53:01', NULL, NULL),
(2, 2, '2026-07-01', '2026-07-03', 'Seminar nasional kedokteran', 'pending', '2026-05-24 12:53:01', NULL, NULL),
(3, 2, '2026-07-06', '2026-07-11', 'Malas, pengen mogok.', 'disetujui', '2026-06-25 12:38:23', '2026-06-25 12:38:42', NULL),
(4, 1, '2026-06-29', '2026-08-07', 'Ada kendala dengan lanjutan kuliah kedokteran operasi dalam.', 'disetujui', '2026-06-29 01:54:25', '2026-07-06 01:23:58', '2026-07-06 01:23:58'),
(5, 1, '2026-08-27', '2026-08-27', 'Idk', 'disetujui', '2026-07-06 01:16:00', '2026-07-06 01:16:48', NULL),
(6, 1, '2026-07-14', '2026-07-14', 'idk', 'ditolak', '2026-07-06 01:29:18', '2026-07-06 01:29:37', NULL),
(7, 1, '2026-07-17', '2026-07-17', 'idk', 'ditolak', '2026-07-06 01:38:07', '2026-07-06 01:38:24', NULL);

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
(1, 2, 1, 'S1 Kedokteran Universitas Indonesia', 'sip/sip_1779955679_2.pdf', NULL, NULL),
(2, 3, 1, 'S1 Kedokteran Universitas Gadjah Mada', 'sip/sip_siti.pdf', NULL, NULL),
(3, 11, 1, NULL, NULL, NULL, NULL),
(4, 12, 2, NULL, NULL, NULL, NULL),
(5, 14, 1, NULL, NULL, NULL, NULL),
(6, 17, 3, NULL, NULL, NULL, NULL),
(7, 22, 4, NULL, NULL, NULL, NULL);

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
(1, 1, 1, '2026-05-20', 9, 'selesai', '2026-05-24 12:53:01', NULL, NULL),
(2, 1, 2, '2026-05-20', 10, 'selesai', '2026-05-24 12:53:01', NULL, NULL),
(3, 2, 3, '2026-05-21', 9, 'selesai', '2026-05-24 12:53:01', NULL, NULL),
(4, 1, 1, '2026-06-02', 9, 'selesai', '2026-05-24 12:53:01', '2026-07-03 05:23:02', NULL),
(5, 2, 2, '2026-06-03', 14, 'dibatalkan', '2026-05-24 12:53:01', '2026-07-03 05:23:02', NULL),
(6, 1, 3, '2026-05-22', 10, 'dibatalkan', '2026-05-24 12:53:01', NULL, NULL),
(8, 2, 3, '2026-06-16', 10, 'dibatalkan', '2026-06-02 19:13:39', '2026-07-03 05:23:02', NULL),
(9, 2, 5, '2026-06-05', 12, 'selesai', '2026-06-02 19:22:38', '2026-06-05 07:15:39', NULL),
(10, 3, 7, '2027-04-16', 17, 'selesai', '2026-06-04 13:29:58', '2026-06-04 13:29:58', NULL),
(11, 3, 1, '2029-08-01', 10, 'selesai', '2026-06-05 04:55:44', '2026-06-26 13:02:52', NULL),
(12, 2, 1, '2026-06-26', 14, 'dibatalkan', '2026-06-05 04:56:56', '2026-07-03 05:23:02', NULL),
(13, 1, 1, '2026-06-05', 8, 'dibatalkan', '2026-06-05 07:08:17', '2026-07-03 05:23:02', NULL),
(14, 1, 1, '2026-06-28', 8, 'dibatalkan', '2026-06-15 08:50:17', '2026-07-03 05:23:02', NULL),
(15, 2, 1, '2026-07-02', 10, 'dibatalkan', '2026-06-17 02:06:32', '2026-07-03 05:23:02', NULL),
(16, 1, 1, '2026-07-11', 8, 'menunggu', '2026-06-17 02:07:04', '2026-07-06 01:34:20', '2026-07-06 01:34:20'),
(17, 4, 1, '2026-06-25', 15, 'dibatalkan', '2026-06-18 12:34:32', '2026-07-03 05:23:02', NULL),
(18, 4, 1, '2026-06-27', 10, 'dibatalkan', '2026-06-18 13:14:37', '2026-07-03 05:23:02', NULL),
(19, 4, 1, '2027-03-11', 15, 'selesai', '2026-06-18 14:03:07', '2026-06-26 13:03:05', NULL),
(20, 1, 1, '2026-10-08', 13, 'menunggu', '2026-06-19 05:56:36', '2026-07-06 01:34:07', '2026-07-06 01:34:07'),
(21, 3, 1, '2026-06-26', 15, 'dibatalkan', '2026-06-19 06:26:11', '2026-07-03 05:23:02', NULL),
(22, 1, 1, '2026-10-15', 15, 'selesai', '2026-06-19 06:28:22', '2026-06-26 13:04:05', NULL),
(23, 1, 1, '2026-06-20', 10, 'dibatalkan', '2026-06-19 06:34:05', '2026-07-03 05:23:02', NULL),
(24, 2, 1, '2026-07-03', 13, 'dibatalkan', '2026-06-19 06:37:35', '2026-07-08 02:42:02', NULL),
(25, 3, 1, '2026-06-25', 8, 'dibatalkan', '2026-06-19 06:46:01', '2026-07-03 05:23:02', NULL),
(26, 2, 1, '2026-06-24', 10, 'dibatalkan', '2026-06-22 02:51:50', '2026-07-03 05:23:02', NULL),
(27, 1, 1, '2026-06-26', 9, 'dibatalkan', '2026-06-25 11:49:01', '2026-07-03 05:23:02', NULL),
(28, 6, 1, '2026-06-26', 11, 'dibatalkan', '2026-06-25 11:49:26', '2026-07-03 05:23:02', NULL),
(29, 1, 1, '2026-06-26', 10, 'dibatalkan', '2026-06-25 12:19:40', '2026-07-03 05:23:02', NULL),
(30, 1, 1, '2026-06-26', 11, 'dibatalkan', '2026-06-25 12:20:06', '2026-07-03 05:23:02', NULL),
(32, 1, 1, '2026-06-26', 8, 'dibatalkan', '2026-06-25 12:29:10', '2026-07-03 05:23:02', NULL),
(33, 1, 1, '2026-06-26', 14, 'dibatalkan', '2026-06-25 12:29:35', '2026-07-03 05:23:02', NULL),
(34, 1, 1, '2026-06-30', 14, 'dibatalkan', '2026-06-26 08:26:09', '2026-07-03 05:23:02', NULL),
(35, 1, 1, '2026-06-29', 11, 'selesai', '2026-06-29 01:33:20', '2026-06-29 01:42:08', NULL),
(36, 6, 1, '2026-07-09', 11, 'menunggu', '2026-06-30 15:16:40', '2026-07-06 01:34:22', '2026-07-06 01:34:22'),
(37, 2, 1, '2026-07-18', 8, 'menunggu', '2026-07-01 01:23:31', '2026-07-06 01:34:09', '2026-07-06 01:34:09'),
(38, 6, 2, '2026-07-09', 10, 'dibatalkan', '2026-07-03 04:54:53', '2026-07-06 02:07:28', NULL),
(39, 5, 2, '2026-07-03', 15, 'selesai', '2026-07-03 07:49:03', '2026-07-03 07:52:18', NULL),
(40, 5, 2, '2026-07-16', 8, 'menunggu', '2026-07-06 01:22:21', '2026-07-06 01:34:11', '2026-07-06 01:34:11'),
(41, 1, 2, '2026-07-16', 8, 'menunggu', '2026-07-06 01:24:17', '2026-07-06 01:34:18', '2026-07-06 01:34:18'),
(42, 1, 2, '2026-07-07', 10, 'dibatalkan', '2026-07-06 02:06:43', '2026-07-06 02:09:38', NULL),
(43, 1, 2, '2026-07-25', 8, 'dikonfirmasi', '2026-07-06 02:08:34', '2026-07-06 02:11:42', NULL),
(44, 1, 2, '2026-07-07', 8, 'dibatalkan', '2026-07-06 02:26:23', '2026-07-08 02:42:02', NULL);

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
(1, 1, 'Senin', 8, 16, NULL, NULL, 0, NULL),
(2, 1, 'Selasa', 8, 16, NULL, NULL, 1, NULL),
(3, 1, 'Rabu', 8, 16, NULL, NULL, 1, NULL),
(4, 1, 'Kamis', 8, 16, NULL, NULL, 1, NULL),
(5, 1, 'Jumat', 8, 15, NULL, NULL, 1, NULL),
(6, 2, 'Senin', 9, 17, 13, 14, 1, NULL),
(7, 2, 'Rabu', 9, 17, 13, 14, 1, NULL),
(8, 2, 'Sabtu', 8, 13, NULL, NULL, 1, NULL),
(9, 5, 'Senin', 10, 17, 12, 13, 1, NULL),
(10, 5, 'Selasa', 8, 17, 12, 13, 1, NULL),
(11, 5, 'Rabu', 8, 17, 12, 13, 1, NULL),
(12, 5, 'Kamis', 8, 17, 12, 13, 1, NULL),
(13, 5, 'Jumat', 8, 18, 12, 14, 1, NULL),
(14, 5, 'Sabtu', 8, 14, NULL, NULL, 1, NULL),
(15, 6, 'Senin', 8, 17, 12, 13, 1, NULL),
(16, 6, 'Selasa', 8, 17, 12, 13, 1, NULL),
(17, 6, 'Rabu', 8, 17, 12, 13, 1, NULL),
(18, 6, 'Kamis', 8, 17, 12, 13, 1, NULL),
(19, 6, 'Jumat', 8, 16, 12, 14, 1, NULL),
(20, 6, 'Sabtu', 8, 15, 12, 13, 1, NULL),
(21, 7, 'Senin', 8, 14, 12, 13, 1, NULL),
(22, 7, 'Selasa', 8, 17, 12, 13, 1, NULL),
(23, 7, 'Rabu', 8, 17, 12, 13, 1, NULL),
(24, 7, 'Kamis', 8, 17, 12, 13, 1, NULL),
(25, 7, 'Jumat', 8, 16, 12, 14, 1, NULL),
(26, 7, 'Sabtu', 8, 15, 12, 13, 1, NULL),
(27, 1, 'Sabtu', 8, 15, 12, 13, 1, NULL),
(28, 1, 'Minggu', 0, 0, NULL, NULL, 0, NULL),
(29, 3, 'Senin', 8, 17, 12, 13, 1, NULL),
(30, 3, 'Selasa', 8, 17, 12, 13, 1, NULL),
(31, 3, 'Rabu', 8, 17, 12, 13, 1, NULL),
(32, 3, 'Kamis', 8, 17, 12, 13, 1, NULL),
(33, 3, 'Jumat', 8, 18, 12, 14, 1, NULL),
(34, 3, 'Sabtu', 8, 15, 12, 13, 1, NULL),
(35, 3, 'Minggu', 0, 0, NULL, NULL, 0, NULL);

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
(1, 'Senin', 8, 17, 12, 13, 0, NULL, NULL, '2026-06-03 02:00:06', '2026-07-03 06:51:05', NULL),
(2, 'Selasa', 8, 17, 12, 13, 0, NULL, NULL, '2026-06-03 02:00:06', NULL, NULL),
(3, 'Rabu', 8, 17, 12, 13, 0, NULL, NULL, '2026-06-03 02:00:06', '2026-07-03 07:37:02', NULL),
(4, 'Kamis', 8, 17, 12, 13, 0, NULL, NULL, '2026-06-03 02:00:06', NULL, NULL),
(5, 'Jumat', 8, 18, 12, 14, 0, NULL, NULL, '2026-06-03 02:00:06', '2026-07-03 07:37:48', NULL),
(6, 'Sabtu', 8, 15, 12, 13, 0, NULL, NULL, '2026-06-03 02:00:06', '2026-06-15 08:47:38', NULL),
(7, 'Minggu', NULL, NULL, NULL, NULL, 1, 'Klinik tutup', NULL, '2026-06-03 02:00:06', NULL, NULL),
(8, NULL, NULL, NULL, NULL, NULL, 1, 'Hari Raya Idul Fitri 1447H', '2026-03-30', '2026-06-03 02:00:06', NULL, NULL),
(9, NULL, NULL, NULL, NULL, NULL, 1, 'Hari Raya Idul Fitri 1447H', '2026-03-31', '2026-06-03 02:00:06', NULL, NULL),
(10, NULL, NULL, NULL, NULL, NULL, 1, 'Hari Buruh Internasional', '2026-05-01', '2026-06-03 02:00:06', NULL, NULL),
(11, NULL, NULL, NULL, NULL, NULL, 1, 'Kenaikan Isa Almasih', '2026-05-14', '2026-06-03 02:00:06', NULL, NULL),
(12, NULL, NULL, NULL, NULL, NULL, 1, 'Hari Raya Waisak', '2026-05-12', '2026-06-03 02:00:06', NULL, NULL),
(13, NULL, NULL, NULL, NULL, NULL, 1, 'Hari Kemerdekaan Indonesia', '2026-08-17', '2026-06-03 02:00:06', NULL, NULL),
(15, NULL, 9, 14, 10, 11, 0, 'Sabtu kecipirit', '2026-06-06', '2026-06-05 05:06:36', '2026-06-05 05:06:36', NULL),
(16, NULL, NULL, NULL, NULL, NULL, 1, 'Gabut rek', '2026-06-27', '2026-06-25 12:34:09', '2026-07-03 07:10:35', '2026-07-03 07:10:35');

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
(1, 'Janji Temu Baru Hari Ini', 'Aprillia Bunga Lestari membuat janji temu pada 11:00 hari ini.', 'jadwal', 35, 1, 4, '2026-06-29 01:33:20'),
(2, 'Pengajuan Cuti Dokter', 'Dr. Budi Santoso mengajukan cuti dari 29 Juni 2026 s/d 07 Agustus 2026. Mohon ditinjau.', 'cuti_dokter', 4, 0, 2, '2026-06-29 01:54:25'),
(3, 'Janji Temu Baru', 'Aprillia Bunga Lestari membuat janji temu pada 11:00, 09 Juli 2026.', 'jadwal', 36, 0, 4, '2026-06-30 15:16:40'),
(4, 'Janji Temu Baru', 'Aprillia Bunga Lestari membuat janji temu pada 08:00, 18 Juli 2026.', 'jadwal', 37, 0, 4, '2026-07-01 01:23:31'),
(5, 'Janji Temu Baru', 'Rina Marlina membuat janji temu pada 10:00, 09 Juli 2026.', 'jadwal', 38, 0, 5, '2026-07-03 04:54:53'),
(6, 'Janji Temu Baru Hari Ini', 'Rina Marlina membuat janji temu pada 15:00 hari ini.', 'jadwal', 39, 1, 5, '2026-07-03 07:49:03'),
(7, 'Pengajuan Cuti Dokter', 'Dr. Budi Santoso mengajukan cuti dari 27 Agustus 2026 s/d 27 Agustus 2026. Mohon ditinjau.', 'cuti_dokter', 5, 0, 2, '2026-07-06 01:16:00'),
(8, 'Janji Temu Baru', 'Rina Marlina membuat janji temu pada 08:00, 16 Juli 2026.', 'jadwal', 40, 0, 5, '2026-07-06 01:22:21'),
(9, 'Janji Temu Baru', 'Rina Marlina membuat janji temu pada 08:00, 16 Juli 2026.', 'jadwal', 41, 0, 5, '2026-07-06 01:24:17'),
(10, 'Pengajuan Cuti Dokter', 'Dr. Budi Santoso mengajukan cuti dari 14 Juli 2026 s/d 14 Juli 2026. Mohon ditinjau.', 'cuti_dokter', 6, 0, 2, '2026-07-06 01:29:18'),
(11, 'Pengajuan Cuti Dokter', 'Dr. Budi Santoso mengajukan cuti dari 17 Juli 2026 s/d 17 Juli 2026. Mohon ditinjau.', 'cuti_dokter', 7, 0, 2, '2026-07-06 01:38:07'),
(12, 'Pengajuan Cuti Ditolak', 'Pengajuan cuti Anda dari 17 Juli 2026 s/d 17 Juli 2026 telah ditolak oleh admin.', 'cuti_dokter', 7, 0, 1, '2026-07-06 01:38:24'),
(13, 'Janji Temu Baru', 'Rina Marlina membuat janji temu pada 10:00, 07 Juli 2026.', 'jadwal', 42, 0, 5, '2026-07-06 02:06:43'),
(14, 'Janji Temu Baru', 'Rina Marlina membuat janji temu pada 08:00, 25 Juli 2026.', 'jadwal', 43, 0, 5, '2026-07-06 02:08:34'),
(15, 'Janji Temu Baru', 'Rina Marlina membuat janji temu pada 08:00, 07 Juli 2026.', 'jadwal', 44, 0, 5, '2026-07-06 02:26:23'),
(16, 'Jadwal Tidak Ditangani', 'Jadwal Anda pada 13:00, 03 Juli 2026 dengan Dr. Dr. Siti Rahayu tidak ditangani. Silakan buat jadwal baru.', 'jadwal', 24, 0, NULL, '2026-07-08 02:42:02'),
(17, 'Jadwal Terlewatkan', 'Jadwal Aprillia Bunga Lestari pada 13:00, 03 Juli 2026 telah terlewatkan.', 'jadwal', 24, 0, NULL, '2026-07-08 02:42:02'),
(18, 'Jadwal Tidak Ditangani', 'Jadwal Aprillia Bunga Lestari dengan Dr. Dr. Siti Rahayu pada 13:00, 03 Juli 2026 tidak ditangani dan dibatalkan otomatis.', 'jadwal', 24, 0, NULL, '2026-07-08 02:42:02'),
(19, 'Jadwal Tidak Ditangani', 'Jadwal Anda pada 08:00, 07 Juli 2026 dengan Dr. Dr. Budi Santoso tidak ditangani. Silakan buat jadwal baru.', 'jadwal', 44, 0, NULL, '2026-07-08 02:42:02'),
(20, 'Jadwal Terlewatkan', 'Jadwal Rina Marlina pada 08:00, 07 Juli 2026 telah terlewatkan.', 'jadwal', 44, 0, NULL, '2026-07-08 02:42:02'),
(21, 'Jadwal Tidak Ditangani', 'Jadwal Rina Marlina dengan Dr. Dr. Budi Santoso pada 08:00, 07 Juli 2026 tidak ditangani dan dibatalkan otomatis.', 'jadwal', 44, 0, NULL, '2026-07-08 02:42:02');

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
(1, 1, 2, 1, '2026-06-29 01:33:57'),
(2, 2, 1, 1, '2026-06-29 02:35:39'),
(3, 3, 17, 0, NULL),
(4, 4, 3, 0, NULL),
(5, 5, 17, 0, NULL),
(6, 6, 14, 0, NULL),
(7, 7, 1, 1, '2026-07-06 01:24:42'),
(8, 8, 14, 0, NULL),
(9, 9, 2, 1, '2026-07-06 01:29:02'),
(10, 10, 1, 1, '2026-07-06 01:38:17'),
(11, 11, 1, 1, '2026-07-06 01:38:17'),
(12, 12, 2, 1, '2026-07-06 01:38:45'),
(13, 13, 2, 1, '2026-07-06 02:07:59'),
(14, 14, 2, 1, '2026-07-06 02:13:05'),
(15, 15, 2, 1, '2026-07-06 02:27:18'),
(16, 16, 4, 1, '2026-07-08 03:26:10'),
(17, 17, 3, 0, NULL),
(18, 18, 1, 1, '2026-07-08 02:43:30'),
(19, 19, 5, 1, '2026-07-08 02:43:39'),
(20, 20, 2, 1, '2026-07-08 02:42:20'),
(21, 21, 1, 1, '2026-07-08 02:43:30');

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
(1, 4, 'O', 'Hipertensi sejak 2018', NULL),
(2, 5, 'A', 'Tidak ada', NULL),
(3, 6, 'B', 'Diabetes tipe 2 sejak 2020', NULL),
(5, 8, NULL, NULL, NULL),
(6, 9, 'O', NULL, NULL),
(7, 10, NULL, NULL, NULL),
(10, 19, 'A', NULL, NULL),
(11, 20, NULL, NULL, NULL);

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
(1, 1, 75000.00, 'qris', 'lunas', 'STR-20260520-001', NULL, NULL, NULL, NULL, NULL, '2026-05-24 12:53:01', NULL, NULL),
(2, 2, 75000.00, 'cash', 'lunas', 'STR-20260520-002', NULL, NULL, NULL, NULL, NULL, '2026-05-24 12:53:01', NULL, NULL),
(3, 3, 75000.00, 'transfer', 'lunas', 'STR-20260521-001', NULL, NULL, NULL, NULL, NULL, '2026-05-24 12:53:01', NULL, NULL),
(4, 4, 75000.00, 'qris', 'lunas', 'STR-20260618-004', 'Konfirmasi manual (sandbox)', 'KLINIK-4-1781790754', 'qr_e25e0852-6dbd-4adc-904a-4e238b927df6', 'some-random-qr-string', '2026-06-18 14:07:34', '2026-05-24 12:53:01', '2026-06-18 14:02:19', NULL),
(5, 5, 75000.00, 'cash', 'lunas', NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-24 12:53:01', '2026-07-03 04:44:38', NULL),
(6, 6, 75000.00, 'qris', 'batal', NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-24 12:53:01', NULL, NULL),
(7, 10, 9000000.00, 'cash', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-04 13:36:58', '2026-06-04 13:36:58', NULL),
(9, 11, 75000.00, 'cash', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-05 04:55:44', '2026-06-05 04:55:44', NULL),
(10, 12, 5000000.00, 'cash', 'batal', NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-05 04:56:56', '2026-07-03 05:23:02', NULL),
(11, 8, 75000.00, 'qris', 'batal', NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-05 07:04:51', '2026-07-03 05:23:02', NULL),
(12, 13, 50000.00, 'cash', 'batal', NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-05 07:08:17', '2026-07-03 05:23:02', NULL),
(13, 14, 75000.00, 'cash', 'batal', NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-15 08:50:17', '2026-07-03 05:23:02', NULL),
(14, 15, 75000.00, 'cash', 'batal', NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-17 02:06:32', '2026-07-03 05:23:02', NULL),
(15, 16, 75000.00, 'cash', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-17 02:07:04', '2026-06-17 02:07:04', NULL),
(16, 17, 50000.00, 'qris', 'batal', NULL, NULL, 'KLINIK-16-1781850292', 'qr_cb8c2b88-6c9d-4146-a094-71e63387df40', 'some-random-qr-string', '2026-06-19 06:39:52', '2026-06-18 12:34:32', '2026-07-03 05:23:02', NULL),
(17, 18, 900000.00, 'qris', 'lunas', 'STR-20260618-017', 'Konfirmasi manual (sandbox)', 'KLINIK-17-1781789701', 'qr_b568fce1-1093-4e27-ae9e-8dac5ee1acf0', 'some-random-qr-string', '2026-06-18 13:50:01', '2026-06-18 13:14:37', '2026-06-18 13:35:08', NULL),
(18, 19, 900000.00, 'cash', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-18 14:03:07', '2026-06-18 14:03:07', NULL),
(19, 20, 50000.00, 'qris', 'pending', NULL, NULL, 'KLINIK-19-1781849767', 'qr_5c16b998-0040-4fb1-bc8a-3aabc6d9c229', 'some-random-qr-string', '2026-06-19 06:31:07', '2026-06-19 05:56:36', '2026-06-19 06:16:09', NULL),
(20, 21, 50000.00, 'qris', 'batal', NULL, NULL, 'KLINIK-20-1781850371', 'qr_b86417bc-d166-448f-867f-566d508c304c', 'some-random-qr-string', '2026-06-19 06:41:11', '2026-06-19 06:26:11', '2026-07-03 05:23:02', NULL),
(21, 22, 50000.00, 'qris', 'pending', NULL, NULL, 'KLINIK-21-1782479057', 'qr_ae5d2b40-8eed-4a90-b798-82e3601bfa19', 'some-random-qr-string', '2026-06-26 13:19:17', '2026-06-19 06:28:22', '2026-06-26 13:04:22', NULL),
(22, 23, 50000.00, 'qris', 'lunas', 'STR-20260619-022', 'DANA', 'KLINIK-22-1781850845', 'qr_ebc08724-7d85-4cff-90ee-7cb7a1b93889', 'some-random-qr-string', '2026-06-19 06:49:05', '2026-06-19 06:34:05', '2026-06-19 06:49:53', NULL),
(23, 24, 50000.00, 'qris', 'batal', NULL, NULL, 'KLINIK-23-1781851056', 'qr_2333be9d-7a79-4feb-b0c7-438125289b25', 'some-random-qr-string', '2026-06-19 06:52:36', '2026-06-19 06:37:35', '2026-07-08 02:42:02', NULL),
(24, 25, 50000.00, 'qris', 'lunas', 'STR-20260619-024', 'DANA', 'KLINIK-24-1781851562', 'qr_b5ce1d36-9b67-44b1-9402-997ece65df21', 'some-random-qr-string', '2026-06-19 07:01:02', '2026-06-19 06:46:01', '2026-06-19 06:46:12', NULL),
(25, 26, 50000.00, 'cash', 'batal', NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-22 02:51:50', '2026-07-03 05:23:02', NULL),
(26, 27, 50000.00, 'cash', 'batal', NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-25 11:49:01', '2026-07-03 05:23:02', NULL),
(27, 28, 67000.00, 'qris', 'batal', NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-25 11:49:26', '2026-07-03 05:23:02', NULL),
(28, 29, 50000.00, 'qris', 'batal', NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-25 12:19:40', '2026-07-03 05:23:02', NULL),
(29, 30, 50000.00, 'qris', 'batal', NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-25 12:20:06', '2026-07-03 05:23:02', NULL),
(30, 32, 50000.00, 'cash', 'batal', NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-25 12:29:10', '2026-07-03 05:23:02', NULL),
(31, 33, 50000.00, 'cash', 'batal', NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-25 12:29:35', '2026-07-03 05:23:02', NULL),
(32, 34, 50000.00, 'cash', 'lunas', NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-26 08:26:09', '2026-06-26 09:31:27', NULL),
(33, 35, 50000.00, 'qris', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-29 01:33:20', '2026-06-29 01:33:20', NULL),
(34, 36, 67000.00, 'qris', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-30 15:16:40', '2026-06-30 15:16:40', NULL),
(35, 37, 50000.00, 'qris', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01 01:23:31', '2026-07-01 01:23:31', NULL),
(36, 38, 67000.00, 'cash', 'batal', NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-03 04:54:53', '2026-07-06 02:07:28', NULL),
(37, 39, 50000.00, 'cash', 'lunas', NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-03 07:49:03', '2026-07-03 07:54:25', NULL),
(38, 40, 50000.00, 'qris', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-06 01:22:21', '2026-07-06 01:22:21', NULL),
(39, 41, 50000.00, 'qris', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-06 01:24:17', '2026-07-06 01:24:17', NULL),
(40, 42, 50000.00, 'cash', 'batal', NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-06 02:06:43', '2026-07-06 02:09:38', NULL),
(41, 43, 50000.00, 'cash', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-06 02:08:34', '2026-07-06 02:08:34', NULL),
(42, 44, 50000.00, 'cash', 'batal', NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-06 02:26:23', '2026-07-08 02:42:02', NULL);

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
(1, 1, 'Demam tinggi 3 hari, kepala pusing.', 'Demam tifoid ringan.', 'Istirahat cukup, perbanyak minum air putih.', 0, 2, NULL, '2026-05-24 12:53:01', NULL, NULL),
(2, 2, 'Batuk berdahak 1 minggu, sesak ringan.', 'Bronkitis akut.', 'Hindari paparan debu dan asap rokok.', 0, 2, NULL, '2026-05-24 12:53:01', NULL, NULL),
(3, 3, 'Nyeri perut bagian kanan bawah.', 'Suspek apendisitis, perlu observasi lanjut.', 'Rujuk ke RS jika nyeri memburuk dalam 24 jam.', 0, 3, NULL, '2026-05-24 12:53:01', NULL, NULL),
(4, 10, 'Sak berak', 'Nahan boker', '67', 0, 1, NULL, '2026-06-04 13:50:47', '2026-06-04 13:50:47', NULL),
(5, 9, 'tes1', 'tes1', 'Tolong', 0, NULL, 1, '2026-06-05 07:15:39', '2026-06-26 09:36:13', NULL),
(6, 35, 'AAA', 'BBB', 'CCC', 1, 2, 2, '2026-06-29 01:41:58', '2026-06-29 01:42:08', NULL),
(7, 39, 'Batuk berdahak', 'Batuk berdahak', NULL, 1, 14, 14, '2026-07-03 07:51:58', '2026-07-03 07:52:18', NULL);

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
(1, 1, 'Parasetamol', '500mg', '3x sehari setelah makan', NULL),
(2, 1, 'Ciprofloxacin', '500mg', '2x sehari selama 5 hari', NULL),
(3, 2, 'Ambroxol', '30mg', '3x sehari setelah makan', NULL),
(4, 2, 'Salbutamol', '2mg', '2x sehari jika sesak', NULL),
(5, 3, 'Antasida', '400mg', '3x sehari sebelum makan, jika nyeri', NULL),
(6, 7, 'Obat batuk', '2 sdk teh', 'begitu', NULL);

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
(2, 'Dokter Gigi', 900000.00, NULL),
(3, 'Spesialis Anak', 67000.00, NULL),
(4, 'Spesialis Penyakit Dalam', 80000.00, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akun_user`
--
ALTER TABLE `akun_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `alergi`
--
ALTER TABLE `alergi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_alergi_pasien` (`id_pasien`);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_jadwal_dokter_dokter` (`id_dokter`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `alergi`
--
ALTER TABLE `alergi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `cuti_dokter`
--
ALTER TABLE `cuti_dokter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `dokter`
--
ALTER TABLE `dokter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `jadwal_dokter`
--
ALTER TABLE `jadwal_dokter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `jadwal_sistem`
--
ALTER TABLE `jadwal_sistem`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `notifikasi_penerima`
--
ALTER TABLE `notifikasi_penerima`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `pasien`
--
ALTER TABLE `pasien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `rekam_medis`
--
ALTER TABLE `rekam_medis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `resep`
--
ALTER TABLE `resep`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `spesialisasi`
--
ALTER TABLE `spesialisasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alergi`
--
ALTER TABLE `alergi`
  ADD CONSTRAINT `fk_alergi_pasien` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id`);

--
-- Constraints for table `cuti_dokter`
--
ALTER TABLE `cuti_dokter`
  ADD CONSTRAINT `fk_cuti_dokter` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id`);

--
-- Constraints for table `dokter`
--
ALTER TABLE `dokter`
  ADD CONSTRAINT `fk_dokter_spesialisasi` FOREIGN KEY (`id_spesialisasi`) REFERENCES `spesialisasi` (`id`),
  ADD CONSTRAINT `fk_dokter_user` FOREIGN KEY (`id_user`) REFERENCES `akun_user` (`id`);

--
-- Constraints for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD CONSTRAINT `fk_jadwal_dokter` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id`),
  ADD CONSTRAINT `fk_jadwal_pasien` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id`);

--
-- Constraints for table `jadwal_dokter`
--
ALTER TABLE `jadwal_dokter`
  ADD CONSTRAINT `fk_jadwal_dokter_dokter` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id`);

--
-- Constraints for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD CONSTRAINT `fk_notif_creator` FOREIGN KEY (`created_by`) REFERENCES `akun_user` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `notifikasi_penerima`
--
ALTER TABLE `notifikasi_penerima`
  ADD CONSTRAINT `fk_np_notifikasi` FOREIGN KEY (`id_notifikasi`) REFERENCES `notifikasi` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_np_user` FOREIGN KEY (`id_user`) REFERENCES `akun_user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pasien`
--
ALTER TABLE `pasien`
  ADD CONSTRAINT `fk_pasien_user` FOREIGN KEY (`id_user`) REFERENCES `akun_user` (`id`);

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `fk_pembayaran_jadwal` FOREIGN KEY (`id_jadwal`) REFERENCES `jadwal` (`id`);

--
-- Constraints for table `rekam_medis`
--
ALTER TABLE `rekam_medis`
  ADD CONSTRAINT `fk_rekam_created_by` FOREIGN KEY (`created_by`) REFERENCES `akun_user` (`id`),
  ADD CONSTRAINT `fk_rekam_jadwal` FOREIGN KEY (`id_jadwal`) REFERENCES `jadwal` (`id`),
  ADD CONSTRAINT `fk_rekam_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `akun_user` (`id`);

--
-- Constraints for table `resep`
--
ALTER TABLE `resep`
  ADD CONSTRAINT `fk_resep_rekam` FOREIGN KEY (`id_rekam`) REFERENCES `rekam_medis` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
