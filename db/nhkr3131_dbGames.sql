-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 31, 2018 at 05:45 AM
-- Server version: 10.0.36-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nhkr3131_dbGames`
--

-- --------------------------------------------------------

--
-- Table structure for table `apps`
--

CREATE TABLE `apps` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `apps`
--

INSERT INTO `apps` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(12, 'TTS Parheheon 2018', 'Games teka - teki silang dalam rangka Parheheon NHKBP Pondok Gede 2018', '2018-07-29 14:10:00', '0000-00-00 00:00:00'),
(13, 'Cari Kata Parheheon 2018', 'Games mencari kata dalam rangka Parheheon NHKBP Pondok Gede 2018', '2018-07-29 15:23:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) UNSIGNED NOT NULL,
  `apps_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `start_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `end_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `apps_id`, `name`, `description`, `start_at`, `end_at`, `created_at`, `updated_at`) VALUES
(2, 12, 'Tester 2', 'minggu 1', '2018-07-31 17:00:00', '2018-08-04 16:59:59', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 12, 'Tester', NULL, '2018-08-14 17:00:00', '2018-08-19 17:00:00', '2018-08-14 17:00:00', '0000-00-00 00:00:00'),
(4, 12, 'minggu_1_tts', NULL, '2018-08-19 17:00:00', '2018-09-01 17:00:00', '2018-08-19 17:00:00', '0000-00-00 00:00:00'),
(5, 13, 'tester cari kata', NULL, '2018-08-20 17:00:00', '2018-08-21 16:00:00', '2018-08-20 17:00:00', '0000-00-00 00:00:00'),
(6, 13, 'minggu_1_cari_kata', NULL, '2018-08-21 17:00:00', '2018-09-01 17:00:00', '2018-08-21 17:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `quests`
--

CREATE TABLE `quests` (
  `id` int(11) UNSIGNED NOT NULL,
  `apps_id` int(11) UNSIGNED NOT NULL,
  `events_id` int(11) UNSIGNED NOT NULL,
  `quest` text,
  `answer` text,
  `additional` varchar(225) DEFAULT NULL,
  `level` tinyint(2) NOT NULL DEFAULT '0',
  `poin` int(3) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `quests`
--

INSERT INTO `quests` (`id`, `apps_id`, `events_id`, `quest`, `answer`, `additional`, `level`, `poin`) VALUES
(30, 12, 3, 'J-A-K-A-R-T-A-#-#-#-/#-#-A-#-#-#-N-#-#-#-/#-#-R-#-#-#-I-#-#-K-/#-#-T-#-#-R-E-T-R-O-/#-#-I-#-#-#-S-#-#-M-/#-#-N-#-#-#-#-#-#-O-/#-#-I-#-#-#-#-#-#-D-/#-#-#-#-#-#-#-#-#-O-/#-#-#-#-#-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/^1-#-2-#-#-#-3-#-#-#-/#-#-#-#-#-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-4-/#-#-#-#-#-5-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/', '1. Jakarta#5. Retro##^1. Jokowi#2. Kartini#3. Anies#4. Komodo##', NULL, 0, 100),
(31, 12, 3, '#-L-#-#-#-#-#-#-#-#/#-A-#-#-#-#-#-#-#-#/#-U-#-#-#-#-#-#-#-#/#-R-E-S-E-#-#-#-#-#/#-E-#-#-#-#-#-#-#-#/#-N-#-#-#-#-#-#-#-#/#-C-A-K-E-P-#-#-#-#/#-E-#-E-#-A-#-#-#-#/#-#-#-C-#-R-#-#-#-#/#-#-#-E-#-S-E-K-A-L/^#-1-#-#-#-#-#-#-#-#/#-#-#-#-#-#-#-#-#-#/#-#-#-#-#-#-#-#-#-#/#-2-#-#-#-#-#-#-#-#/#-#-#-#-#-#-#-#-#-#/#-#-#-#-#-#-#-#-#-#/#-3-#-4-#-5-#-#-#-#/#-#-#-#-#-#-#-#-#-#/#-#-#-#-#-#-#-#-#-#/#-#-#-#-#-6-#-#-#-#/', '2. Rese#3. Cakep#6. Sekal#^1. Laurence#4. Kece#5. Pars#', NULL, 0, 100),
(33, 12, 3, 'K-A-M-P-R-E-T-#-#-#-/#-N-#-A-#-#-#-#-#-#-/#-C-#-S-#-#-#-#-#-#-/#-O-#-R-#-#-#-#-#-#-/#-L-#-A-#-#-#-#-#-#-/#-#-#-H-#-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/^1-2-#-5-#-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/', '1. Kampret##^2. Ancol#5. Pasrah##', NULL, 3, 100),
(34, 12, 3, 'J-A-B-R-A-#-#-#-#-#/A-#-E-#-#-#-#-#-#-#/K-#-R-#-#-#-#-#-#-#/S-#-A-#-#-#-#-#-#-#/A-U-T-O-#-#-#-#-#-#/#-#-#-#-#-#-#-#-#-#/#-#-#-#-#-#-#-#-#-#/#-#-#-#-#-#-#-#-#-#/#-#-#-#-#-#-#-#-#-#/#-#-#-#-#-#-#-#-#-#/^1-#-3-#-#-#-#-#-#-#/#-#-#-#-#-#-#-#-#-#/#-#-#-#-#-#-#-#-#-#/#-#-#-#-#-#-#-#-#-#/2-#-#-#-#-#-#-#-#-#/#-#-#-#-#-#-#-#-#-#/#-#-#-#-#-#-#-#-#-#/#-#-#-#-#-#-#-#-#-#/#-#-#-#-#-#-#-#-#-#/#-#-#-#-#-#-#-#-#-#/', '1. Jabra#2. Auto#^1. Jaksa#3. Berat#', NULL, 0, 100),
(36, 12, 4, '#-#-#-#-S-#-S-#-#-#/#-#-C-P-O-#-E-#-#-#/#-#-#-#-C-#-M-#-#-#/#-#-#-K-R-E-A-K-#-#/#-#-#-#-A-#-R-#-K-#/P-A-D-A-T-#-A-S-I-#/#-#-O-#-E-#-N-#-D-#/#-#-L-#-S-#-G-#-#-#/#-W-O-N-#-#-#-#-#-#/#-#-K-#-#-#-#-#-#-#/^#-#-#-#-1-#-2-#-#-#/#-#-3-#-#-#-#-#-#-#/#-#-#-#-#-#-#-#-#-#/#-#-#-4-#-#-#-#-5-#/#-#-#-#-#-#-#-#-#-#/6-#-7-#-#-#-8-#-#-#/#-#-#-#-#-#-#-#-#-#/#-#-#-#-#-#-#-#-#-#/#-9-#-#-#-#-#-#-#-#/#-#-#-#-#-#-#-#-#-#/', '3. Minyak sawit mentah singkatan (ing)#4. Belagu (Batak)#6. Tidak cair#8. Minuman sehat untuk bayi#9. Mata uang Korea Selatan#^1. Filsuf Yunani yang terkenal#2. Ibu kota Provinsi Jawa Tengah#5. Anak bhs.inggris#7. Gunung (Batak)#', NULL, 0, 100),
(37, 12, 4, '#-#-#-L-#-#-#-#-#-#-/H-O-D-A-D-O-D-A-#-R-/#-#-#-S-#-#-#-N-#-E-/A-K-S-E-N-#-#-G-#-T-/R-#-#-R-#-A-L-I-E-N-/E-#-#-#-#-N-#-N-#-O-/M-#-#-#-#-K-#-#-#-#-/#-#-#-#-#-E-M-B-U-N-/#-#-#-#-#-R-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/^#-#-#-1-#-#-#-#-#-#-/2-#-#-#-#-#-#-3-#-4-/#-#-#-#-#-#-#-#-#-#-/5-#-#-#-#-#-#-#-#-#-/#-#-#-#-#-6-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/#-#-#-#-#-7-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/', '2. Sandiwara tradisional Batak Simalungun#5. Tekanan suara pad kata atau suku kata,logat#6. Makhluk asing yang masih dipertanyakan kebenarannya#7. Uap yang menjadi titik-titik air##^1. Sinar yang dapat menembus baja#3. Gerakan udara dari daerah bertekanan tinggi ke daerah bertekanan rendah#4. Nama depan Menteri Luar Negeri Indonesia ke-17#5. Diulang, Lontong bersantan berisi daging cincang yang dibumbui#6. Jangkar bhs.belanda##', NULL, 0, 100),
(39, 12, 4, 'S-T-A-N-D-#-#-#-#-#-/#-O-#-#-#-#-#-#-#-#-/#-K-O-M-B-U-R-#-#-#-/#-O-#-A-#-#-A-#-G-#-/#-H-#-R-#-#-P-A-E-S-/#-#-C-A-S-#-U-#-T-#-/#-#-#-S-#-#-H-#-E-#-/#-#-#-#-#-#-#-#-K-#-/#-#-#-#-#-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/^1-2-#-#-#-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/#-3-#-4-#-#-5-#-#-#-/#-#-#-#-#-#-#-#-6-#-/#-#-#-#-#-#-7-#-#-#-/#-#-8-#-#-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/', '1. Berdiri bhs.inggris#3. Gosip (Batak)#7. Mempercantik muka pengantin#8. Mengisi aliran listrik##^2. Bohong (Batak)#4. Perundingan di daerah Batak antara dua keluarga mengenai perkawinan anak-anaknya#5. Mudah rusak,lemah,sakit-sakitan#6. Genit (Batak)##', NULL, 0, 100),
(40, 12, 4, '#-#-#-#-#-#-#-#-#-#/#-#-#-A-#-#-#-#-#-#/#-#-#-S-E-R-A-#-#-#/#-#-#-A-#-#-L-#-#-#/#-#-#-L-#-T-O-L-#-#/#-#-#-#-S-#-H-#-#-#/#-L-#-N-I-S-A-N-#-#/#-P-#-#-N-#-#-#-#-#/#-S-#-#-G-#-#-#-#-#/I-K-E-B-A-N-A-#-#-#/^#-#-#-#-#-#-#-#-#-#/#-#-#-1-#-#-#-#-#-#/#-#-#-2-#-#-3-#-#-#/#-#-#-#-#-#-#-#-#-#/#-#-#-#-#-4-#-#-#-#/#-#-#-#-5-#-#-#-#-#/#-6-#-7-#-#-#-#-#-#/#-#-#-#-#-#-#-#-#-#/#-#-#-#-#-#-#-#-#-#/8-#-#-#-#-#-#-#-#-#/', '2. Tanaman penyedap masakan#4. Jalan yang mengenakan bea bagi pemakainya#7. Batu makam#8. Seni merangkai bunga dari Jepang#^1. Seenaknya saja,semula#3. Salam perpisahan khas Hawaii#5. Hewan buas#6. Lembaga perlindungan saksi dan korban#', NULL, 0, 100),
(41, 12, 4, '#-T-#-O-#-#-#-#-#-#/#-O-M-P-U-#-#-#-#-#/#-R-#-O-#-#-#-#-#-#/#-#-#-S-#-#-#-#-#-#/C-E-L-I-T-#-#-#-#-#/O-#-#-S-#-A-#-#-#-#/N-#-#-I-N-N-E-R-#-#/G-#-#-#-#-T-#-#-#-#/O-#-K-E-D-A-N-#-#-#/K-#-#-#-#-P-#-#-#-#/^#-1-#-2-#-#-#-#-#-#/#-3-#-#-#-#-#-#-#-#/#-#-#-#-#-#-#-#-#-#/#-#-#-#-#-#-#-#-#-#/4-#-#-#-#-#-#-#-#-#/#-#-#-#-#-5-#-#-#-#/#-#-#-6-#-#-#-#-#-#/#-#-#-#-#-#-#-#-#-#/#-#-7-#-#-#-#-#-#-#/#-#-#-#-#-#-#-#-#-#/', '3. Gelar tertinggi keluarga Batak#4. Pelit (Batak)#6. Sebelah dalam bhs.inggris#7. Teman akrab#^1. Diulang, Tarian khas Batak#2. Partai penentang#4. Rakus (Batak)#5. Padat,berat#', NULL, 0, 100),
(42, 12, 4, '#-#-#-#-#-#-H-#-#-#-/#-#-P-#-#-#-U-#-P-#-/#-M-A-N-G-A-L-U-A-#-/#-#-S-#-#-#-A-#-J-#-/#-#-A-#-E-#-#-C-A-K-/H-O-R-A-S-#-#-#-K-#-/U-#-#-#-K-#-#-#-#-#-/R-#-#-M-E-N-T-E-L-#-/I-#-#-#-T-#-#-#-#-#-/A-#-#-B-E-R-E-N-G-#-/^#-#-#-#-#-#-1-#-#-#-/#-#-2-#-#-#-#-#-3-#-/#-4-#-#-#-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/#-#-#-#-5-#-#-6-#-#-/7-#-#-#-#-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/#-#-#-8-#-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/#-#-#-9-#-#-#-#-#-#-/', '4. Pernikahan yang dilangsungkan atas kesepakatan bersama kedua pasangan tanpa melalui restu orangtuanya#6. Coba (Batak)#7. Kata seruan yang sering dikatakan oleh orang suku Batak#8. Bergaya (Batak)#9. Melirik sinis (Batak)##^1. Sebutan pd warga dari pihak istri (adat Batak)#2. Jalan raya (Batak)#3. Pasar (Batak)#5. Tidak berteman lagi (Batak)#7. (Daerah) Persekutuan umat Kristen Protestan (di tanah Batak)#', NULL, 0, 100),
(43, 12, 4, '#-#-#-E-#-#-A-#-#-#-/L-#-#-M-A-R-G-A-#-#-/A-#-#-P-#-#-N-#-#-#-/K-A-R-A-T-#-E-#-#-#-/L-#-#-L-#-#-S-#-#-#-/A-#-#-#-#-#-#-#-#-#-/K-U-K-U-S-#-#-#-#-#-/#-#-#-L-#-#-#-#-#-#-/G-A-L-O-N-#-#-#-#-#-/#-#-#-S-#-#-#-#-#-#-/^#-#-#-1-#-#-2-#-#-#-/3-#-#-4-#-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/5-#-#-#-#-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/6-#-#-7-#-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/8-#-#-#-#-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/', '4. Lingkungan orang-orang yang seketurunan (di daerah Batak)#5. Ukuran untuk menentukan kadar emas#6. Memasak dengan uap air mendidih#8. Pom bensin##^1. Irisan daging sapi digoreng setelah direbus dan dibumbui#2. Nama depan aktris,penyanyi pop Indonesia#3. Tulisan Batak kuno#7. Selendang tenun Batak, biasa dipakai dalam upacara adat##', NULL, 0, 100),
(44, 12, 4, 'E-S-E-K-#-#-#-#-#-#-/#-I-#-#-#-T-#-H-#-P-/#-T-#-#-#-U-#-E-#-A-/D-I-P-A-O-R-O-H-O-N-/#-N-#-#-#-I-#-E-#-O-/#-D-#-#-#-#-#-#-#-R-/P-A-R-U-M-A-E-N-#-O-/#-O-#-#-#-#-#-#-#-N-/#-N-I-D-A-H-A-N-#-I-/#-#-#-#-#-#-#-#-#-#-/^1-2-#-#-#-#-#-#-#-#-/#-#-#-#-#-3-#-4-#-5-/#-#-#-#-#-#-#-#-#-#-/6-#-#-#-#-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/7-#-#-#-#-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/#-8-#-#-#-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/', '1. Gembira (Batak)#6. Perkawinan yang dilangsungkan oleh dua keluarga yang sudah menjodohkan kedua anaknya sejak usia dini#7. Mantu perempuan isteri anak kita#8. Nasi yang dimasak##^2. Pendeta resort HKBP Pondok Gede#3. Cerita (dongeng yang berdasarkan kejadian zaman dahulu dsb di masyarakat Batak)#4. Lincah, Bangun, Berdiri, Bangun, Cepat, Cekatan, Bangkit#5. Pernikahan yang diadakan untuk mencari pengganti istri yang meninggal##', NULL, 0, 100),
(45, 12, 4, 'P-E-L-E-A-N-#-#-#-#-/#-#-#-M-#-#-S-#-M-#-/#-#-#-P-A-R-I-B-A-N-/#-#-#-E-#-#-N-#-N-#-/#-#-#-#-#-#-A-#-G-#-/#-#-#-#-#-#-M-#-H-#-/#-#-#-B-#-T-O-G-A-R-/R-E-G-U-K-#-T-#-B-#-/#-#-#-L-#-#-#-#-I-#-/#-#-Y-E-R-E-M-I-A-#-/^1-#-#-2-#-#-#-#-#-#-/#-#-#-#-#-#-3-#-4-#-/#-#-#-5-#-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/#-#-#-6-#-7-#-#-#-#-/8-#-#-#-#-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/#-#-9-#-#-#-#-#-#-#-/', '1. Uang persembahan (Batak)#5. Abang-adik karena isteri juga kakak-beradik (Batak)#7. Ketua Naposo HKBP Pondok Gede#8. Teguk#9. Kitab tema tahun HKBP 2018##^2. Istri meninggalkan suami (Batak)#3. Uang muka mas kawin (Batak)#4. Pernikahan yang dilangsungkan antara mertua dengan menantunya yang telah menjanda#6. Penjaga gereja yang suka menggonggong##', NULL, 0, 100),
(46, 12, 4, '#-#-#-I-N-G-A-T-#-#-/B-#-K-#-O-#-#-#-#-#-/E-#-U-#-M-#-#-#-#-#-/K-#-T-#-M-#-#-#-R-#-/A-W-A-K-E-#-#-#-O-#-/S-#-#-#-N-#-#-#-R-#-/I-#-#-#-S-E-R-M-O-N-/#-#-#-#-E-#-#-#-B-#-/T-U-L-A-N-G-#-#-O-#-/#-#-#-#-#-#-#-#-T-#-/^#-#-#-1-2-#-#-#-#-#-/3-#-4-#-#-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/#-#-#-#-#-#-#-#-5-#-/6-#-#-#-#-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/#-#-#-#-7-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/8-#-#-#-#-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/', '1. Tidak lupa#6. Bangun bhs.inggris#7. Rapat doa pendalaman Alkitab di gereja#8. Abang atau adik dari ibu kita##^2. Penginjil Jerman yang terkenal di Batak#3. Letak Distrik HKBP Pondok Gede#4. Pantai di Bali yang menjadi tujuan wisata#5. Tulang isteri (Batak)##', NULL, 0, 100),
(47, 12, 4, '#-H-K-B-P-#-#-#-#-#-/#-#-#-E-#-#-#-#-#-#-/#-#-#-L-#-#-#-#-#-#-/#-#-#-E-#-#-N-U-R-#-/#-#-#-R-#-#-#-M-#-#-/#-#-#-A-K-H-I-R-#-#-/#-#-#-N-#-#-#-#-#-#-/M-A-N-G-G-O-G-O-I-#-/#-V-#-#-#-#-#-#-#-#-/S-I-M-A-T-U-A-#-#-#-/^#-1-#-2-#-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/#-#-#-#-#-#-3-4-#-#-/#-#-#-#-#-#-#-#-#-#-/#-#-#-5-#-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/6-7-#-#-#-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/8-#-#-#-#-#-#-#-#-#-/', '1. Huria Kristen Batak Protestan#3. Sinar#5. Penghabisan#6. Perkawinan yang terjadi sebagai bentuk tanggung jawab si pria setelah menggauli kekasihnya#8. Mertua (Batak)##^2. Benda bukan logam yang berwarna kuning muda,jika dibakar bernyala biru merah#4. Upah Minimum Regional#7. Kantor Berita Vietnam Agence Vietnamienne d Information##', NULL, 0, 100),
(48, 12, 4, '#-#-#-A-#-#-#-#-#-#-/K-O-A-L-A-#-#-#-#-#-/O-#-#-E-#-#-D-#-#-#-/A-#-T-#-N-#-R-#-#-#-/R-U-E-#-A-N-A-#-#-#-/#-#-G-#-S-#-M-#-#-#-/G-R-A-S-I-#-A-#-#-#-/#-#-#-#-#-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/^#-#-#-1-#-#-#-#-#-#-/2-#-#-#-#-#-#-#-#-#-/#-#-#-#-#-#-3-#-#-#-/#-#-4-#-5-#-#-#-#-#-/6-#-#-#-7-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/8-#-#-#-#-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/', '2. Beruang berkantong yang memanjat,hidup di Australia#6. Jalan bhs.perancis#7. Kantor Berita Yunani Athena News Agency#8. Pengampunan hukuman oleh kepala negara##^1. Nama lain aktor dan sutradara Juharson Esterlla Sihasale, Ari Sihasale#2. Berkata dengn suara keras#3. Kejadian yang menyedihkan#4. Tidak menaruh belas kasihan#5. Makanan yang mengandung karbohidrat##', NULL, 0, 100),
(49, 12, 4, '#-#-#-#-#-#-#-#-#-T-/#-#-#-#-#-#-#-F-#-A-/G-A-B-U-S-#-#-O-#-H-/#-#-#-#-U-#-#-K-#-A-/#-M-E-L-A-N-G-K-U-P-/#-I-#-#-#-#-#-S-#-#-/#-L-#-#-#-#-#-O-#-#-/#-#-#-U-N-C-E-N-#-#-/#-#-#-#-U-#-#-G-#-#-/#-#-R-A-S-#-#-#-#-#-/^#-#-#-#-#-#-#-#-#-1-/#-#-#-#-#-#-#-2-#-#-/3-#-#-#-4-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/#-5-#-#-#-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/#-#-#-6-7-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/#-#-8-#-#-#-#-#-#-#-/', '3. Ikan predator hidup di air tawar#5. Perbuatan yang merupakan delik adat, misal membawa lari istri atau tunangan orang lain dalam masyarakat Batak#6. Universitas Cenderawasih#8. Rumpun bangsa##^1. Tingkat,jenjang#2. Lagu rakyat bhs.inggris#4. Bertemu,berjumpa#5. Satuan ukuran jarak#7. Ikan sotong##', NULL, 0, 100),
(50, 12, 4, '#-S-I-D-I-#-#-#-#-#/#-O-#-A-#-#-#-#-#-#/#-L-#-P-I-L-#-#-#-#/#-#-#-A-#-#-#-#-#-#/S-O-F-T-W-A-R-E-#-#/#-#-#-#-#-R-#-K-#-#/#-#-#-#-#-E-#-S-#-#/#-#-#-#-C-A-T-#-#-#/#-#-#-#-#-L-#-#-#-#/#-#-#-#-#-#-#-#-#-#/^#-1-#-2-#-#-#-#-#-#/#-#-#-#-#-#-#-#-#-#/#-#-#-3-#-#-#-#-#-#/#-#-#-#-#-#-#-#-#-#/4-#-#-#-#-5-#-6-#-#/#-#-#-#-#-#-#-#-#-#/#-#-#-#-#-#-#-#-#-#/#-#-#-#-7-#-#-#-#-#/#-#-#-#-#-#-#-#-#-#/#-#-#-#-#-#-#-#-#-#/', '1. Katekisasi (Batak)#3. Tablet#4. Perangkat lunak#7. Bahan pewarna berupa cairan kental##^1. Nada lagu#2. Mampu,bisa#5. Daerah#6. Mantan#', NULL, 0, 100),
(51, 12, 4, 'P-#-#-#-#-#-#-#-#-#-/O-#-S-I-K-S-A-#-#-N-/R-#-W-#-#-#-#-#-#-O-/D-#-A-#-#-N-A-N-A-R-/A-U-S-#-#-#-#-Y-#-M-/#-#-T-#-#-A-N-E-K-A-/#-K-I-#-#-M-#-R-#-#-/#-#-K-#-#-O-#-I-#-#-/#-#-A-D-A-N-G-#-#-#-/#-#-#-#-#-G-#-#-#-#-/^1-#-#-#-#-#-#-#-#-#-/#-#-2-#-#-#-#-#-#-3-/#-#-#-#-#-#-#-#-#-#-/#-#-#-#-#-4-#-5-#-#-/6-#-#-#-#-#-#-#-#-#-/#-#-#-#-#-7-#-#-#-#-/#-8-#-#-#-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/#-#-9-#-#-#-#-#-#-#-/#-#-#-#-#-#-#-#-#-#-/', '2. Aniaya,hukuman#4. Berasa pusing kena pukul#6. Susut karena tergosok#7. Banyak macamnya#8. Kata sapaan kepada guru yang menjadi panutan bhs.jawa#9. Halang,mencegat##^1. Pekan olahraga daerah#2. Simbol yang digunakan partai Nazi,Jerman#3. Aturan, kaidah#5. Merasa sakit#7. Di antara bhs.inggris#', NULL, 0, 100),
(54, 13, 5, '#-~-~-~-~-~-#-|~-T-R-A-T-A-~-|~-E-C-E-K-N-~-|~-S-A-L-A-H-~-|~-T-r-C-V-V-~-|~-S-I-L-U-A-~-|#-~-~-~-~-~-#-|', 'salah^silua^rata^test^cekaka^', NULL, 0, 100),
(55, 13, 5, '#-~-~-~-~-~-#-|~-s-a-j-a-k-~-|~-r-o-r-a-s-~-|~-a-a-a-w-i-~-|~-j-s-s-l-a-~-|~-a-g-a-w-l-~-|#-~-~-~-~-~-#-|', 'ajak^soal^raja^sial^rasa^', NULL, 0, 100),
(56, 13, 5, '#-~-~-~-~-~-#-|~-R-X-R-T-E-~-|~-A-J-S-E-S-~-|~-S-E-R-R-A-~-|~-A-R-S-A-M-~-|~-T-A-N-P-A-~-|#-~-~-~-~-~-#-|', 'RASA^TANPA^SAMA^ERA^', NULL, 0, 100),
(57, 13, 5, '#-~-~-~-~-~-#-|~-D-M-A-N-G-~-|~-A-O-N-G-A-~-|~-S-D-O-M-N-~-|~-T-E-L-P-O-~-|~-R-H-O-T-E-~-|#-~-~-~-~-~-#-|', 'OLO^DAONG^MODOM^MANGAN^', NULL, 0, 100),
(58, 13, 6, '#-~-~-~-~-~-#-|~-O-L-W-W-B-~-|~-L-A-A-L-O-~-|~-A-P-S-I-T-~-|~-R-A-W-M-R-~-|~-I-N-G-A-N-~-|#-~-~-~-~-~-#-|', 'BOLA^WASIT^TIM^LAPANGAN^LARI^', 'Olahraga', 0, 100),
(59, 12, 3, 'S-A-B-I-#-#-#-#-#-#/#-#-#-M-#-#-#-#-#-#/#-#-#-A-#-#-R-#-#-#/#-H-#-N-A-M-A-#-Y-#/F-F-J-J-#-#-S-#-Y-#/#-H-#-#-#-J-A-J-J-#/#-H-#-#-#-#-#-#-Y-#/F-U-U-I-#-#-#-#-Y-#/#-#-#-#-#-#-Y-Y-Y-Y/#-#-#-#-#-#-#-#-Y-#/^1-#-#-2-#-#-#-#-#-#/#-#-#-#-#-#-#-#-#-#/#-#-#-#-#-#-3-#-#-#/#-#-#-4-#-#-#-#-#-#/#-#-#-#-#-#-#-#-#-#/#-#-#-#-#-#-#-#-#-#/#-#-#-#-#-#-#-#-#-#/#-#-#-#-#-#-#-#-#-#/#-#-#-#-#-#-#-#-#-#/#-#-#-#-#-#-#-#-#-#/', 'FEAFEAF#faefaef#feafeafear#areaer#^feafaef#feafaef#feafaef#feafaef#', NULL, 0, 100),
(60, 13, 6, '#-~-~-~-~-~-#-|~-L-R-A-K-E-~-|~-A-L-O-B-T-~-|~-P-W-A-S-I-~-|~-A-V-V-O-L-~-|~-N-G-A-N-R-~-|#-~-~-~-~-~-#-|', 'LAPANGAN^BOLA^WASIT^RAKET^VOLI^', 'Olahraga', 0, 100),
(61, 13, 6, '#-~-~-~-~-~-#-|~-I-T-A-R-A-~-|~-G-E-E-X-N-~-|~-P-R-O-T-N-~-|~-X-O-A-D-A-~-|~-J-I-P-O-O-~-|#-~-~-~-~-~-#-|', 'JOOX^IPOD^NADA^GITAR^POP^', 'Musik', 0, 100),
(62, 13, 6, '#-~-~-~-~-~-#-|~-O-D-O-M-P-~-|~-M-I-N-U-A-~-|~-X-Y-R-M-N-~-|~-U-I-R-U-D-~-|~-K-G-N-O-A-~-|#-~-~-~-~-~-#-|', 'DAONG^MODOM^MINUM^PURIK^ANDURI^', 'Batak', 0, 100),
(63, 13, 6, '#-~-~-~-~-~-#-|~-T-I-N-O-S-~-|~-A-O-D-H-E-~-|~-N-L-U-A-E-~-|~-D-O-K-T-A-~-|~-R-S-U-N-G-~-|#-~-~-~-~-~-#-|', 'OLO^HATA^TANDOK^LOSUNG^SONDUK^ULOS^', 'Batak', 0, 100),
(64, 13, 6, '#-~-~-~-~-~-#-|~-M-A-N-G-E-~-|~-S-A-L-A-G-~-|~-B-N-Y-N-I-~-|~-O-D-N-A-M-~-|~-K-A-L-U-M-~-|#-~-~-~-~-~-#-|', 'MANGAN^GALAS^ANDALU^LAGE^MANDOK^', 'Batak', 0, 100),
(65, 13, 6, '#-~-~-~-~-~-#-|~-E-P-U-I-S-~-|~-D-R-A-K-I-~-|~-H-O-M-A-T-~-|~-I-S-A-J-G-~-|~-K-A-Y-A-T-~-|#-~-~-~-~-~-#-|', 'PROSA^PUISI^DRAMA^SAJAK^HIKAYAT^', 'Sastra', 0, 100),
(66, 13, 6, '#-~-~-~-~-~-#-|~-D-S-A-H-R-~-|~-A-A-E-A-B-~-|~-U-L-O-M-O-~-|~-D-U-A-D-E-~-|~-E-K-A-S-E-~-|#-~-~-~-~-~-#-|', 'SEM^HAM^DAUD^SALOMO^LUKAS^', 'Tokoh Alkitab', 0, 100),
(67, 13, 6, '#-~-~-~-~-~-#-|~-E-H-U-I-I-~-|~-D-A-L-T-S-~-|~-I-R-A-O-U-~-|~-A-M-L-N-Q-~-|~-T-O-N-I-K-~-|#-~-~-~-~-~-#-|', 'DIATONIK^HARMONI^ALTO^NOT^SOLO^', 'Musik', 0, 100),
(68, 13, 6, '#-~-~-~-~-~-#-|~-B-V-B-A-N-~-|~-J-O-O-S-E-~-|~-A-L-I-K-T-~-|~-R-E-K-E-D-~-|~-I-N-G-T-I-~-|#-~-~-~-~-~-#-|', 'JARING^DEKER^NET^VOLI^BASKET^', 'Olahraga', 0, 100),
(69, 13, 6, '#-~-~-~-~-~-#-|~-H-I-R-A-E-~-|~-E-X-T-P-T-~-|~-C-L-O-T-H-~-|~-O-C-L-X-E-~-|~-H-L-A-E-R-~-|#-~-~-~-~-~-#-|', 'ETHEREAL^EPOCH^HIRAETH^EXTOL^CLOTH^', 'Inggris', 0, 100),
(70, 13, 6, '#-~-~-~-~-~-#-|~-A-L-K-I-T-~-|~-N-D-E-T-A-~-|~-E-I-N-U-B-~-|~-P-E-D-O-A-~-|~-G-E-R-E-J-~-|#-~-~-~-~-~-#-|', 'PENDETA^ALKITAB^GEREJA^DOA^ENDE^', 'Kristen', 0, 100),
(71, 13, 6, '#-~-~-~-~-~-#-|~-U-K-A-U-P-~-|~-P-I-S-A-R-~-|~-A-P-U-L-A-~-|~-S-U-R-K-G-~-|~-E-N-D-A-L-~-|#-~-~-~-~-~-#-|', 'PISAU^GARPU^SAPU^SENDAL^KASUR^', 'Benda', 0, 100),
(72, 13, 6, '#-~-~-~-~-~-#-|~-A-M-P-B-N-~-|~-R-A-E-O-E-~-|~-U-S-R-Y-W-~-|~-N-S-E-L-T-~-|~-E-A-T-N-O-~-|#-~-~-~-~-~-#-|', 'NEWTON^ARUS^BOYLE^MASSA^AMPERE^', 'Fisika', 0, 100),
(73, 13, 6, '#-~-~-~-~-~-#-|~-I-R-S-T-A-~-|~-S-I-N-T-D-~-|~-O-T-O-P-H-~-|~-L-M-T-N-E-~-|~-P-R-O-I-S-~-|#-~-~-~-~-~-#-|', 'ATOM^ION^ISOTOP^PROTON^ADHESI^', 'Kimia', 0, 100),
(74, 13, 6, '#-~-~-~-~-~-#-|~-A-N-O-K-F-~-|~-B-P-L-U-R-~-|~-O-J-E-R-E-~-|~-L-G-M-L-T-~-|~-U-D-A-K-S-~-|#-~-~-~-~-~-#-|', 'APEL^JERUK^MELON^MADU^BOLU^', 'Makanan', 0, 100),
(75, 13, 6, '#-~-~-~-~-~-#-|~-F-G-R-A-G-~-|~-T-I-Y-S-U-~-|~-L-R-E-S-N-~-|~-S-R-S-L-N-~-|~-U-G-A-R-D-~-|#-~-~-~-~-~-#-|', 'FIELD^GIRL^GRASS^GUN^SUGAR^', 'Inggris', 0, 100),
(76, 13, 6, '#-~-~-~-~-~-#-|~-M-A-R-I-D-~-|~-A-K-K-L-I-~-|~-R-A-U-C-H-~-|~-B-R-E-J-O-~-|~-A-D-A-I-B-~-|#-~-~-~-~-~-#-|', 'KAREJO^MARIDI^MARBADAI^BOHI^CUAK^', 'Batak', 0, 100),
(77, 13, 6, '#-~-~-~-~-~-#-|~-U-C-C-P-Y-~-|~-L-E-L-A-T-~-|~-U-N-C-X-I-~-|~-Y-D-E-K-P-~-|~-H-Q-W-T-U-~-|#-~-~-~-~-~-#-|', 'ULU^PAT^TIPUT^CENDEK^CELAT^', 'Batak', 0, 100),
(78, 13, 6, '#-~-~-~-~-~-#-|~-H-G-F-Y-E-~-|~-A-O-U-H-G-~-|~-M-A-R-Z-E-~-|~-U-B-O-A-B-~-|~-C-H-G-F-S-~-|#-~-~-~-~-~-#-|', 'HORAS^GOAR^BORU^HAMU^BEGE^', 'Batak', 0, 100),
(79, 13, 6, '#-~-~-~-~-~-#-|~-A-O-X-E-A-~-|~-U-N-U-S-B-~-|~-N-N-G-U-S-~-|~-T-M-Y-L-W-~-|~-R-E-E-N-E-~-|#-~-~-~-~-~-#-|', 'AUNT^TREE^ANGLE^SUN^NEWS^', 'Inggris', 0, 100),
(80, 13, 6, '#-~-~-~-~-~-#-|~-P-D-O-L-L-~-|~-J-A-H-Y-S-~-|~-E-L-P-O-P-~-|~-K-U-N-E-T-~-|~-L-G-Y-P-R-~-|#-~-~-~-~-~-#-|', 'PAPER^PEOPLE^SONG^HOT^DOLL^', 'Inggris', 0, 100);

-- --------------------------------------------------------

--
-- Table structure for table `t_activities`
--

CREATE TABLE `t_activities` (
  `id` int(11) UNSIGNED NOT NULL,
  `group` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `number_of_teams` int(50) NOT NULL,
  `total_gender_m_f` varchar(10) NOT NULL,
  `start_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `end_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_activities`
--

INSERT INTO `t_activities` (`id`, `group`, `name`, `number_of_teams`, `total_gender_m_f`, `start_at`, `end_at`) VALUES
(1, 'online events', 'teka-teki silang', 0, '', '2018-08-16 17:00:00', '2018-09-20 17:00:00'),
(2, 'online events', 'cari kata', 0, '', '2018-08-16 17:00:00', '2018-09-20 17:00:00'),
(3, 'offline events', 'Badminton', 7, '4+3', '2018-09-07 17:00:00', '2018-09-21 17:00:00'),
(4, 'offline events', 'Basket (3 on 3)', 4, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'offline events', 'PUBG', 4, '', '2018-09-07 17:00:00', '2018-09-21 17:00:00'),
(6, 'offline events', 'Cover Lagu Rohani', 3, '', '2018-09-07 17:00:00', '2018-09-21 17:00:00'),
(7, 'acara kebersamaan', 'retret', 0, '', '2018-09-21 17:00:00', '2018-09-29 17:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `t_cms`
--

CREATE TABLE `t_cms` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(40) NOT NULL,
  `password` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_cms`
--

INSERT INTO `t_cms` (`id`, `username`, `password`) VALUES
(2, 'laurence', '123456');

-- --------------------------------------------------------

--
-- Table structure for table `t_hobbies`
--

CREATE TABLE `t_hobbies` (
  `id` int(11) UNSIGNED NOT NULL,
  `name_group` varchar(100) NOT NULL,
  `hobby` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_hobbies`
--

INSERT INTO `t_hobbies` (`id`, `name_group`, `hobby`) VALUES
(1, 'Sport', 'Football'),
(2, 'Sport', 'Badminton'),
(3, 'Sport', 'Table Tenis'),
(4, 'Sport', 'Volleyball'),
(5, 'Sport', 'ESports'),
(6, 'Sport', 'Others Sport'),
(7, 'Art', 'Drawing'),
(8, 'Art', 'Photography'),
(9, 'Art', 'Writing'),
(10, 'Art', 'Drama'),
(11, 'Art', 'Dancing'),
(12, 'Art', 'Stand-up'),
(13, 'Art', 'Others Art'),
(14, 'Music', 'Singing'),
(15, 'Music', 'Musician'),
(16, 'Music', 'Others Music'),
(18, 'Sport', 'Basketball');

-- --------------------------------------------------------

--
-- Table structure for table `t_order`
--

CREATE TABLE `t_order` (
  `id` int(10) UNSIGNED NOT NULL,
  `t_users_detail_id` int(11) UNSIGNED NOT NULL,
  `note` varchar(225) NOT NULL,
  `delivery_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `total_payment` int(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t_orders_detail`
--

CREATE TABLE `t_orders_detail` (
  `id` int(11) UNSIGNED NOT NULL,
  `t_order_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `price_unit` int(50) NOT NULL,
  `quantity` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t_rel_users_activities`
--

CREATE TABLE `t_rel_users_activities` (
  `id` int(11) UNSIGNED NOT NULL,
  `t_users_detail_id` int(11) UNSIGNED NOT NULL,
  `t_activities_id` int(11) UNSIGNED NOT NULL,
  `mode_registration` varchar(10) NOT NULL,
  `team_created` int(10) DEFAULT NULL,
  `team_name` varchar(50) DEFAULT NULL,
  `team_password` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_rel_users_activities`
--

INSERT INTO `t_rel_users_activities` (`id`, `t_users_detail_id`, `t_activities_id`, `mode_registration`, `team_created`, `team_name`, `team_password`) VALUES
(37, 28, 1, 'Solo', NULL, NULL, NULL),
(38, 29, 2, 'Solo', NULL, NULL, NULL),
(39, 29, 1, 'Solo', NULL, NULL, NULL),
(40, 31, 1, 'Solo', NULL, NULL, NULL),
(41, 32, 1, 'Solo', NULL, NULL, NULL),
(42, 33, 1, 'Solo', NULL, NULL, NULL),
(43, 34, 1, 'Solo', NULL, NULL, NULL),
(57, 37, 4, 'Solo', NULL, NULL, NULL),
(58, 37, 7, 'Solo', NULL, NULL, NULL),
(59, 38, 1, 'Solo', NULL, NULL, NULL),
(60, 38, 2, 'Solo', NULL, NULL, NULL),
(61, 39, 5, 'Team', 1, 'Tukangx', 'Panjanglah'),
(62, 39, 7, 'Solo', NULL, NULL, NULL),
(63, 40, 2, 'Solo', NULL, NULL, NULL),
(64, 41, 1, 'Solo', NULL, NULL, NULL),
(65, 41, 2, 'Solo', NULL, NULL, NULL),
(66, 40, 1, 'Solo', NULL, NULL, NULL),
(67, 42, 1, 'Solo', NULL, NULL, NULL),
(68, 43, 1, 'Solo', NULL, NULL, NULL),
(69, 43, 2, 'Solo', NULL, NULL, NULL),
(70, 39, 1, 'Solo', NULL, NULL, NULL),
(71, 45, 1, 'Solo', NULL, NULL, NULL),
(72, 45, 2, 'Solo', NULL, NULL, NULL),
(73, 46, 2, 'Solo', NULL, NULL, NULL),
(74, 46, 1, 'Solo', NULL, NULL, NULL),
(75, 47, 1, 'Solo', NULL, NULL, NULL),
(76, 39, 2, 'Solo', NULL, NULL, NULL),
(77, 45, 7, 'Solo', NULL, NULL, NULL),
(78, 48, 1, 'Solo', NULL, NULL, NULL),
(79, 48, 1, 'Solo', NULL, NULL, NULL),
(80, 49, 1, 'Solo', NULL, NULL, NULL),
(81, 49, 2, 'Solo', NULL, NULL, NULL),
(82, 49, 7, 'Solo', NULL, NULL, NULL),
(83, 35, 1, 'Solo', NULL, NULL, NULL),
(84, 35, 2, 'Solo', NULL, NULL, NULL),
(85, 50, 1, 'Solo', NULL, NULL, NULL),
(86, 50, 1, 'Solo', NULL, NULL, NULL),
(87, 51, 1, 'Solo', NULL, NULL, NULL),
(88, 51, 2, 'Solo', NULL, NULL, NULL),
(89, 52, 1, 'Solo', NULL, NULL, NULL),
(90, 53, 2, 'Solo', NULL, NULL, NULL),
(91, 53, 2, 'Solo', NULL, NULL, NULL),
(92, 53, 1, 'Solo', NULL, NULL, NULL),
(93, 52, 2, 'Solo', NULL, NULL, NULL),
(94, 54, 1, 'Solo', NULL, NULL, NULL),
(95, 55, 1, 'Solo', NULL, NULL, NULL),
(96, 55, 1, 'Solo', NULL, NULL, NULL),
(97, 56, 1, 'Solo', NULL, NULL, NULL),
(98, 47, 2, 'Solo', NULL, NULL, NULL),
(99, 57, 1, 'Solo', NULL, NULL, NULL),
(100, 57, 2, 'Solo', NULL, NULL, NULL),
(101, 58, 1, 'Solo', NULL, NULL, NULL),
(102, 58, 2, 'Solo', NULL, NULL, NULL),
(103, 59, 1, 'Solo', NULL, NULL, NULL),
(104, 59, 2, 'Solo', NULL, NULL, NULL),
(105, 60, 1, 'Solo', NULL, NULL, NULL),
(106, 60, 1, 'Solo', NULL, NULL, NULL),
(107, 61, 2, 'Solo', NULL, NULL, NULL),
(108, 61, 2, 'Solo', NULL, NULL, NULL),
(109, 61, 1, 'Solo', NULL, NULL, NULL),
(110, 62, 1, 'Solo', NULL, NULL, NULL),
(111, 50, 2, 'Solo', NULL, NULL, NULL),
(112, 56, 2, 'Solo', NULL, NULL, NULL),
(113, 63, 1, 'Solo', NULL, NULL, NULL),
(114, 63, 2, 'Solo', NULL, NULL, NULL),
(115, 60, 2, 'Solo', NULL, NULL, NULL),
(116, 65, 1, 'Solo', NULL, NULL, NULL),
(117, 65, 2, 'Solo', NULL, NULL, NULL),
(118, 35, 7, 'Solo', NULL, NULL, NULL),
(123, 67, 3, 'Solo', NULL, NULL, NULL),
(124, 68, 5, 'Solo', NULL, NULL, NULL),
(125, 49, 4, 'Solo', NULL, NULL, NULL),
(126, 70, 5, 'Solo', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `t_rel_users_hobbies`
--

CREATE TABLE `t_rel_users_hobbies` (
  `id` int(11) UNSIGNED NOT NULL,
  `t_users_detail_id` int(11) UNSIGNED NOT NULL,
  `t_hobbies_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_rel_users_hobbies`
--

INSERT INTO `t_rel_users_hobbies` (`id`, `t_users_detail_id`, `t_hobbies_id`) VALUES
(22, 28, 18),
(23, 28, 15),
(24, 29, 18),
(25, 29, 5),
(26, 30, 1),
(27, 30, 5),
(28, 31, 1),
(29, 31, 5),
(30, 32, 1),
(31, 32, 18),
(32, 33, 6),
(33, 34, 1),
(34, 34, 5),
(35, 35, 1),
(36, 35, 3),
(37, 36, 2),
(38, 36, 5),
(39, 37, 1),
(40, 37, 18),
(41, 38, 5),
(42, 38, 13),
(43, 39, 1),
(44, 39, 5),
(45, 40, 6),
(46, 40, 8),
(47, 41, 6),
(48, 41, 16),
(49, 42, 13),
(50, 42, 15),
(51, 43, 5),
(52, 43, 16),
(53, 44, 1),
(54, 44, 6),
(55, 45, 1),
(56, 45, 2),
(57, 46, 2),
(58, 46, 8),
(59, 47, 2),
(60, 47, 8),
(61, 48, 18),
(62, 48, 11),
(63, 49, 18),
(64, 49, 14),
(65, 50, 18),
(66, 50, 2),
(67, 51, 2),
(68, 51, 5),
(69, 52, 2),
(70, 52, 15),
(71, 53, 2),
(72, 53, 14),
(73, 54, 1),
(74, 55, 1),
(75, 55, 18),
(76, 56, 6),
(77, 57, 1),
(78, 57, 5),
(79, 58, 18),
(80, 58, 2),
(81, 59, 2),
(82, 59, 3),
(83, 60, 7),
(84, 60, 14),
(85, 61, 6),
(86, 61, 13),
(87, 62, 11),
(88, 62, 14),
(89, 63, 1),
(90, 63, 2),
(91, 64, 18),
(92, 64, 4),
(93, 65, 2),
(94, 65, 8),
(97, 67, 2),
(98, 68, 18),
(99, 68, 5),
(100, 69, 2),
(101, 69, 3),
(102, 70, 18),
(103, 70, 5);

-- --------------------------------------------------------

--
-- Table structure for table `t_users_detail`
--

CREATE TABLE `t_users_detail` (
  `id` int(11) UNSIGNED NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `phone` text NOT NULL,
  `birthday` date NOT NULL,
  `gender` varchar(30) NOT NULL,
  `marital_status` varchar(30) NOT NULL,
  `wijk` int(10) NOT NULL,
  `address` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `path_image` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_users_detail`
--

INSERT INTO `t_users_detail` (`id`, `full_name`, `phone`, `birthday`, `gender`, `marital_status`, `wijk`, `address`, `email`, `path_image`) VALUES
(28, 'Kaisar Sihotang', '083841260652', '1998-11-06', 'Male', 'Single', 5, 'Jl.  Raya Hankam RT : 07/05 No : 32D', 'fire.generation98@gmail.com', NULL),
(29, 'Ribka Xena Sitorus', '082165887826', '1997-09-24', 'Female', 'Single', 4, 'komplek chandra baru. no 172', 'ribxen97@gmail.com', NULL),
(30, 'Yadiman', '0857', '2018-08-21', 'Male', 'Single', 4, 'T', 'yadiman19@gmail.com', NULL),
(31, 'Ido parluhutan', '081380952605', '1992-10-18', 'Male', 'Single', 5, 'Jalan Raya hankam', 'idoparluhutansilalahi@gmail.com', NULL),
(32, 'Tio Carlos Antonius Purba', '082111058892', '1992-04-25', 'Male', 'Single', 1, 'Gg. Delima 1 Rt 009 Rw 002 Lubang Buaya Jakarta Timur', 'tio.carlos.antonius@gmail.com', NULL),
(33, 'Yohanafelicia', '085718130396', '1997-04-30', 'Female', 'Single', 4, 'Bulaktinggi', 'yohanafel@gmail.com', NULL),
(34, 'Albert Fernando', '082260825951', '1999-08-19', 'Male', 'Single', 6, 'Jatiwaringin', 'albertnandoo1902@gmail.com', NULL),
(35, 'Tester 2', '0123455', '2018-07-31', 'Male', 'Single', 1, 'Jl. Gotong Royong Kp. Bulak Poncol No 80 Rt 11 Rw18', 'laurencebutarbutar@gmail.com', '35_5becd73729924f858a95c990587c777a.jpg'),
(36, 'Maria Maulina Sihite', '081932607017', '1995-09-11', 'Female', 'Single', 1, 'Lubang Buaya', 'mariamaulyna@gmail.com', NULL),
(37, 'Tio Carlos Antonius Purba', '08211058892', '1992-04-25', 'Male', 'Single', 1, 'Lubang buaya', 'tio.carlos.antonius@gmail.com', NULL),
(38, 'Daniel Pardamean Silitonga', '089508202383', '1998-12-08', 'Male', 'Single', 5, 'Jl.Rinjani Blok A2 No.6 Perumahan Pondok Melati Indah', 'danielps1908@gmail.com', NULL),
(39, 'Apriko Estomihi', '081289058486', '1995-04-20', 'Male', 'Single', 1, 'Jl. Taman Mini Pintu II', 'apriko.estomihi@gmail.com', NULL),
(40, 'Ghebi Dwina', '0895345563274', '1996-02-20', 'Female', 'Single', 4, 'Komplek.tvri blok E 4 no 4', 'dwinaghebi@gmail.com', NULL),
(41, 'Debora Tampubolon', '08176560123', '1994-04-20', 'Female', 'Single', 5, 'Pondok Melati Indah', 'adelaide.debora@live.com', NULL),
(42, 'Mey carolina manurung', '085716497921', '1985-05-26', 'Female', 'Single', 4, 'Perum. Chandra indah jl. Sulawesi E 105', 'meycarolyne@gmail.com', NULL),
(43, 'Nelson silitonga', '089756893456', '1996-11-01', 'Male', 'Single', 5, 'Jl.Merapi 5 No.7 Perumahan Pondok Melati Indah', 'nelson@gmail.com', NULL),
(44, 'Daniel Patuan Sihombing', '087882772529', '1994-01-05', 'Male', 'Single', 2, 'Komplek sinar kasih, jalan agape blok A-20, jatimakmur.', 'danielpatuans@gmail.com', NULL),
(45, 'Daniel goran mallasak naibaho', '085899567096', '1999-01-12', 'Male', 'Single', 5, 'Jl.hj dehir rt07/02 no 3b kp pedurenan jatiluhur', 'danielnaibaho8@gmail.com', NULL),
(46, 'Devi Tarida Aprillia Naibaho', '0895326396369', '1997-04-03', 'Female', 'Single', 5, 'Jl.H.Dehir Rt07/Rw02, No. 3b ,jatiluhur, jatiasih. (kantor kelurahan jatiluhur)', 'devitaridanaibaho@gmail.com', NULL),
(47, 'samuel', '087891932108', '1992-02-18', 'Male', 'Single', 6, 'Jl setia 1', 'samuelcullen90@gmail.com', NULL),
(48, 'vanniashere', '089662922997', '1997-10-26', 'Female', 'Single', 5, 'perum pondok melati indah jl bukit barisan II B2 no 13', 'vannia.shere26@gmail.com', NULL),
(49, 'Firdaus Enrico', '08984425422', '1989-02-10', 'Male', 'Single', 4, 'Kompleks Chandra Baru Jl. Siliwangi III Blok A,192 Pondok Melati Bekasi', 'firdausenrico@gmail.com', NULL),
(50, 'Nana', '08111510087', '1987-10-15', 'Female', 'Single', 1, 'Jalan Pintu 2 TMII', 'berliana.nainggolan@yahoo.com', NULL),
(51, 'Angel Noviani Rawita ', '0895365528907', '1997-11-05', 'Female', 'Single', 1, 'Jalan Pagelarang 1', 'anowita05@gmail.com', NULL),
(52, 'Manullang', '081317564107', '1994-11-14', 'Male', 'Single', 6, 'Jatiwaringin', 'manullang11@gmail.com', NULL),
(53, 'Pamela tamaro', '081299015653', '1998-01-02', 'Female', 'Single', 4, 'Jl. Siliwanhi raya', 'pamela.tamaro21@yahoo.com', NULL),
(54, 'Togar Julio Parhusip', '087866944896', '1992-07-22', 'Male', 'Single', 4, 'Jl. Bulak Tinggi I, RT 010/RW 016, Kel Jatirahayu, Kec Pondok Melati, Bekasi', 'togarjulio@gmail.com', NULL),
(55, 'Naomi Catherine', '081235250153', '1998-07-17', 'Female', 'Single', 5, 'kampung sawah', 'naomicatherine98@gmail.com', NULL),
(56, 'Aprilia', '08978294771', '1996-04-17', 'Female', 'Single', 5, 'Jl. Raya Hankam Bulog 2 GG Mushola RT 04 RW 06 No 36 Kampung Asem', 'apriliasitanggang17@gmail.com', NULL),
(57, 'ivan', '089524096412', '2015-04-08', 'Male', 'Single', 5, 'jalan melati ray', 'ivanaldohosea@gmail.com', NULL),
(58, 'Christina Novayanti Riana Sitorus', '089635895728', '1998-11-12', 'Female', 'Single', 5, 'Jl. Kampunh Sawah GG.Bhineka No. 54', 'novayantic12@gmail.com', NULL),
(59, 'Tiara', '081314129686', '2104-04-21', 'Female', 'Single', 1, 'Crocodile Hole', 'tiara.borpang@gmail.com', NULL),
(60, 'Daniel Christian', '085817269646', '1989-02-25', 'Male', 'Single', 1, 'Jl. Kramat no.54 RT.004 RW.002\r\nKel. Lubang Buaya\r\nKec. Cipayung\r\nJakarta Timur, 13810', 'daniel.christian171@gmail.com', NULL),
(61, 'Maria Kristina', '081280989762', '1993-12-24', 'Female', 'Single', 1, 'Jakarta', 'imariakrist@gmail.com', NULL),
(62, 'Dina sari olympia simanjuntak', '087787073186', '1994-04-29', 'Female', 'Single', 5, 'Jl. Legok Raya no.18 , jatimekar', 'dnlymp@gmail.com', NULL),
(63, 'Marasi N Nababan ', '081290807812', '1996-11-21', 'Female', 'Single', 5, 'Jl.swadaya 2 jatiwaringin ', 'marasinababan65@gmail.com', NULL),
(64, 'Josua Martogi Hutagaol', '081311541158', '1990-03-02', 'Male', 'Single', 2, 'Duta Indah', 'josuamartogih@gmail.com', NULL),
(65, 'Sastika Sianturi', '085693720998', '1988-04-03', 'Female', 'Single', 4, 'Jl. Raya Cilandak KKO; Gang Abbah 2 No. 50 RT 05 RW 05; Kel. Ragunan; Kec. Pasar Minggu; Jakarta Selatan - 12550', 'sastika_sianturi@yahoo.com', NULL),
(67, 'Marlina agustina', '08999756979', '2018-08-17', 'Female', 'Single', 4, 'Chandra 7 no 46', 'mrlynagust@yahoo.com', NULL),
(68, 'Yoel Andika Pranata Sitorus', '081293420624', '2001-08-29', 'Male', 'Single', 4, 'Jl. Chandra 14 blok A', 'yaps290801@gmail.com', NULL),
(69, 'Marlina Napitupulu', '081281819613', '2018-08-17', 'Female', 'Single', 4, 'Chandra 7 no 46', 'mrlynagust@gmail.com', NULL),
(70, 'Bryan Burju Samuel Siagian', '081288286140', '2000-06-10', 'Male', 'Single', 5, 'Jl. Raya Hankam, Jatiwarna no.33', 'bryansamuel006@gmail.com', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `t_users_history`
--

CREATE TABLE `t_users_history` (
  `id` int(10) UNSIGNED NOT NULL,
  `t_users_detail_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `old_value` varchar(225) NOT NULL,
  `new_value` varchar(225) NOT NULL,
  `update_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_users_history`
--

INSERT INTO `t_users_history` (`id`, `t_users_detail_id`, `name`, `old_value`, `new_value`, `update_at`) VALUES
(1, 35, 'username', 'shade_hard_line', 'username', '2018-08-30 13:56:52'),
(2, 35, 'password', '-', '-', '2018-08-30 13:56:52'),
(3, 35, 'username', 'shade_hard_line', 'username', '2018-08-30 14:00:07'),
(4, 35, 'password', '-', '-', '2018-08-30 14:00:08'),
(5, 35, 'username', 'shade_hard_line', 'username', '2018-08-30 14:03:26'),
(6, 35, 'password', '-', '-', '2018-08-30 14:03:26'),
(7, 35, 'full_name', 'Laurence Butar-Butar', 'Full Name', '2018-08-30 14:04:59'),
(8, 35, 'phone', '081281612761', '81281612766', '2018-08-30 14:04:59'),
(9, 35, 'wijk', '3', '1', '2018-08-30 14:04:59'),
(10, 35, 'address', 'Jl. Gotong Royong Kp. Bulak Poncol No 80 Rt 11 Rw18', 'address', '2018-08-30 14:04:59'),
(11, 35, 'email', 'laurencebutarbutar@gmail.com', 'email@gmail.com', '2018-08-30 14:04:59'),
(12, 35, 'hobbies', '1', '4', '2018-08-30 14:04:59'),
(13, 35, 'hobbies', '3', '5', '2018-08-30 14:04:59'),
(14, 35, 'username', 'username', 'username1', '2018-08-30 14:04:59'),
(15, 35, 'password', '-', '-', '2018-08-30 14:04:59'),
(16, 35, 'phone', '081281612766', '08121658', '2018-08-30 14:06:39'),
(17, 35, 'full_name', 'Full Name', 'Laurence Butar-Butar', '2018-08-30 14:08:34'),
(18, 35, 'phone', '08121658', '081281612767', '2018-08-30 14:08:34'),
(19, 35, 'wijk', '1', '3', '2018-08-30 14:08:34'),
(20, 35, 'address', 'address', 'Jl. Gotong Royong Kp. Bulak Poncol No 80 Rt 11 Rw18', '2018-08-30 14:08:34'),
(21, 35, 'email', 'email@gmail.com', 'laurencebutarbutar@gmail.com', '2018-08-30 14:08:34'),
(22, 35, 'hobbies', '4', '1', '2018-08-30 14:08:34'),
(23, 35, 'hobbies', '5', '5', '2018-08-30 14:08:34'),
(24, 35, 'username', 'username1', 'shade_hard_line', '2018-08-30 14:08:34'),
(25, 35, 'password', '-', '-', '2018-08-30 14:08:35');

-- --------------------------------------------------------

--
-- Table structure for table `t_users_medsos`
--

CREATE TABLE `t_users_medsos` (
  `id` int(11) UNSIGNED NOT NULL,
  `t_users_detail_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `id_medsos` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_users_medsos`
--

INSERT INTO `t_users_medsos` (`id`, `t_users_detail_id`, `name`, `id_medsos`) VALUES
(1, 35, 'Facebook', 'https://www.facebook.com/laurence.butarbutar'),
(2, 35, 'Instagram', 'https://www.instagram.com/shade_hard_line/'),
(3, 35, 'LinkedIn', 'https://www.linkedin.com/in/laurence-butar-butar-13ab3b4a/'),
(4, 35, 'Steam', 'https://steamcommunity.com/profiles/76561198026135799/'),
(5, 35, 'Twitter', 'https://twitter.com/shade_hard_line'),
(6, 35, 'Quora', 'https://www.quora.com/profile/Laurence-Butar-Butar'),
(7, 35, 'Youtube', 'https://www.youtube.com/user/Shad3able');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `t_users_detail_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `t_users_detail_id`, `name`, `password`, `created_at`, `updated_at`) VALUES
(36, 28, 'SihotangJr. ', '$2y$10$OZA/MEYx/5mw1kFO8Wica.WK.tazto6MgLe2H01jSoej7QIGX4QN.', '2018-08-21 16:40:05', '0000-00-00 00:00:00'),
(37, 29, 'ribxen', '$2y$10$U5DJDk99s.ONI4ipGpLocO0JKM.D87EZRiw4AmN2jOyAv212I8z4.', '2018-08-21 16:43:27', '0000-00-00 00:00:00'),
(38, 30, 'Diman', '$2y$10$1X58ZU2J1WEwoEw84kChfujNGqB6Xyd6A3bxXf3nXMNj4h9L5UM6K', '2018-08-21 16:52:53', '0000-00-00 00:00:00'),
(39, 31, 'Mokimoki', '$2y$10$kbT1sksYz0iXygFb3Q9PO.FCjJP7HQNGS8AnNHwTMxIYusTiiQ4Mu', '2018-08-21 16:55:31', '0000-00-00 00:00:00'),
(40, 32, 'Tio Carlos Antonius Purba', '$2y$10$2pMC5E0AA54ThwDZ.E8GjeHpjeQJoYZ8B6nw5gurErYoR2k0wIkgW', '2018-08-21 16:57:16', '0000-00-00 00:00:00'),
(41, 33, 'Yohanafelicia', '$2y$10$.f0MtJo5AWCe5TqQUccZEe2f5xxhox4cpwyahVchJzKEQ5qdbB16C', '2018-08-22 00:49:48', '0000-00-00 00:00:00'),
(42, 34, 'Fernando', '$2y$10$G3etfmh5TBiCvfy4mzGL1ue.s3ZrCL4DUaEmQ6bXVdMo/ZkIkJmu.', '2018-08-22 04:35:12', '0000-00-00 00:00:00'),
(43, 35, 'shade_hard_line', '$2y$10$xMTilZUhsEbKFgt/OdbEqeuf6oiLAdNQ2D1ePbNtd0V7V7Ce.cMV.', '2018-08-22 11:55:05', '0000-00-00 00:00:00'),
(44, 36, 'mariamaulyna', '$2y$10$UAEVDKxKJN0pkxPWYD3ecu8ZhQww5t9fSsi8z2nVMmQZrrvc84mke', '2018-08-25 05:20:24', '0000-00-00 00:00:00'),
(45, 37, 'Tionelmessi', '$2y$10$8grIg.hXCUNfD9FUbmhW4eA0pyjp5B1RAAOAhuxh0Kl9DSLDcY9vC', '2018-08-25 18:05:02', '0000-00-00 00:00:00'),
(46, 38, 'danielps1908', '$2y$10$qi9OLGDTF5s.gqbno820Iu7OmG4ZFkElrJFZ9d/962YCMUK9YsNN2', '2018-08-26 02:29:12', '0000-00-00 00:00:00'),
(47, 39, 'Ricobain', '$2y$10$taDBzae3R/U0OA1jI00AkuRSbpKsA/2Xq7FYk7ObdVHyscZ3PLoLe', '2018-08-26 04:48:25', '0000-00-00 00:00:00'),
(48, 40, 'gabdwina', '$2y$10$4IqHR/JKDOnPv.IcyihUOOnxQJE22mdeQnYvozLQ7vi2ux1L3aoBa', '2018-08-26 05:22:35', '0000-00-00 00:00:00'),
(49, 41, 'Adelaidebora', '$2y$10$zWfAzmZ1hzXXHn1qR33UQeZXlRL8Ld/6tEGmM47dHnx93TtcxPhIG', '2018-08-26 05:26:31', '0000-00-00 00:00:00'),
(50, 42, 'Mey manurung', '$2y$10$lc.o41/D8XAVsS./H0lUheV.zOnCNDGeYOpJW70vCDZ0SG0ypLzue', '2018-08-26 07:26:50', '0000-00-00 00:00:00'),
(51, 43, 'Nelsons', '$2y$10$T0c2nAWsP8wRTQMU3jECTO9LiRFRytVIAl.oPcBLK2iV8FmaJDS4q', '2018-08-26 08:10:53', '0000-00-00 00:00:00'),
(52, 44, 'danielps', '$2y$10$hk1j.8x3l9taf2osN4nMxOaeU2XV21OW1GVrZcT3UGjriuJvE2oTK', '2018-08-26 14:34:28', '0000-00-00 00:00:00'),
(53, 45, 'Danielnaibahoo', '$2y$10$VlzBmGgt9ygBMVPqa6l3keXf6/T1DCQd5cAW5fWwo0P4DRPufFuZG', '2018-08-26 15:02:34', '0000-00-00 00:00:00'),
(54, 46, 'devinaibahoo', '$2y$10$vnZYvEbykiZbOkPlqa/dbe5sSbPbFqm5Ep.fZRn86k.BGJQyLyAvi', '2018-08-26 15:28:39', '0000-00-00 00:00:00'),
(55, 47, 'Aek nauli', '$2y$10$Lvbj44di96a2gJKtPvFwp.4JS7YpDxb.V8rQV8lsCcqS6tCR4l4L.', '2018-08-26 15:55:18', '0000-00-00 00:00:00'),
(56, 48, 'shevannia', '$2y$10$AP6kmz85kYiy5eVTgdSdf.U1IZeWEeaCtbAAC7GCXLWlxZvk5rELa', '2018-08-27 03:23:56', '0000-00-00 00:00:00'),
(57, 49, 'Firdaus Butarbutar', '$2y$10$db00MGvJOZsZS7gVIzasUuj01X0x8dVnqPd4NKNMO5i62sTN6ln4S', '2018-08-27 03:40:17', '0000-00-00 00:00:00'),
(58, 50, 'Nana Borneng', '$2y$10$dtXtehsBUFO/wXT5Lx2MNOPyIemh58kDNkNwcaghj.iW2S/KW3RtS', '2018-08-27 11:06:32', '0000-00-00 00:00:00'),
(59, 51, 'Angelnoviani', '$2y$10$LaZIwnZpCRlQSM4zKC0hJu3ZfLHYKoLibxkkHsrKiDqu5.J5g85h6', '2018-08-27 11:20:11', '0000-00-00 00:00:00'),
(60, 52, 'Manson', '$2y$10$wfslOyappWkAX5OFic8cveFAUylMRQdOApvkBYtvbTsPUC2QmuuZi', '2018-08-27 12:13:44', '0000-00-00 00:00:00'),
(61, 53, 'Pamelatmr', '$2y$10$FHsGgL2jciBKLPbaaYQc.uqYlmn0sYwKGo10Iu3TS2sloFw3MwSVm', '2018-08-27 12:17:05', '0000-00-00 00:00:00'),
(62, 54, 'togarjuliop', '$2y$10$cRAdEj9cvTwKfdSBKOum.ODZMm8eFPiUtaPiGrJC3cYmVyGqbGlIe', '2018-08-27 14:05:16', '0000-00-00 00:00:00'),
(63, 55, 'Naomi Catherine', '$2y$10$cuqjM6ZLCBVRBoUgFvOC0.feLfkiFlBM/sVSc7sREoVMby6qLDbxG', '2018-08-27 15:32:57', '0000-00-00 00:00:00'),
(64, 56, 'Aprilia', '$2y$10$bwFyhbKEs33U4dsQm0p2FeGfZYOYLJoj7QJiptpOnawjHXvdxoVDK', '2018-08-27 15:40:00', '0000-00-00 00:00:00'),
(65, 57, 'wow', '$2y$10$2PZuWUnTOweInl6Fbw0QFONg7vrkEn58P6RquNgt50.h8OC7tv1cG', '2018-08-27 16:55:26', '0000-00-00 00:00:00'),
(66, 58, 'Novayantic', '$2y$10$FzipqrAolKxv/QBsR6pakeAmdaQvZ/IuM7EDLyGylmRRO2ipvAvYi', '2018-08-27 17:42:20', '0000-00-00 00:00:00'),
(67, 59, 'tiaraaik', '$2y$10$9uxZRhbzdPL8cNCx/JuV3ekrDC6iJg0wQ6nfpO/5afhI3rGMiN7.S', '2018-08-27 19:08:52', '0000-00-00 00:00:00'),
(68, 60, 'Daniel Christian', '$2y$10$n9IJQIuqVa9dgFUA85QEO.P3coawUlUyj5C5UK3UNV3V8byj0.Bkm', '2018-08-27 23:05:14', '0000-00-00 00:00:00'),
(69, 61, 'Mariagaja', '$2y$10$TUHwkx5fbBerHZu7RjNI5O4ABsq.YRGdNIbHpwJmdUNdIHpOFfNhC', '2018-08-28 00:48:46', '0000-00-00 00:00:00'),
(70, 62, 'Dinsmnjntk', '$2y$10$nQvUpNuE8YPxEiqvl/l19.8TXN4NfLEWlzYdWuUc9Q.8aF828YWWC', '2018-08-28 00:55:38', '0000-00-00 00:00:00'),
(71, 63, 'marasinababan65@gmail.com', '$2y$10$oM3Jnk9jjAfLPzrFdEds6OMnvekdxzk5PJjJmfQ3uerRf7vAZTT92', '2018-08-28 08:10:19', '0000-00-00 00:00:00'),
(72, 64, 'josuamartogih@gmail.com', '$2y$10$54gjq.4jgavpkKr2Y3hNout8ljssJ8lslDtyY5eq6h3OZIokVrCX2', '2018-08-28 15:21:51', '0000-00-00 00:00:00'),
(73, 65, 'Sastika_Sianturi', '$2y$10$KxAI/L8NwLrGMls8GnzLqev/fYkU9luwMlsmX8kQkBt5M3Mpc7ubG', '2018-08-29 04:19:12', '0000-00-00 00:00:00'),
(75, 67, 'mrlynagust', '$2y$10$TvNwHst.Hzv1zGMxBR6ANuxln7OugjLynamQpKc5YSo1ZiQDeFcBS', '2018-08-30 04:20:55', '0000-00-00 00:00:00'),
(76, 68, 'Yoel Sitorus', '$2y$10$e5YKPgjX3vR7nX8fStufVOMXQmdfuilIvFysT5nVCZERqvPkKz6X.', '2018-08-30 04:26:42', '0000-00-00 00:00:00'),
(77, 69, 'mrlynagust70', '$2y$10$w9hyjvLyNUrb2ScH81Yil.nl1MI0WRuWWUkiys2h5rCuTGDxsr4.6', '2018-08-30 04:29:04', '0000-00-00 00:00:00'),
(78, 70, 'bryansamuel006', '$2y$10$U1qYE2nGU6iP3mxZ.f5WSuobmq/TWSA42zFMLHeZ3wWoQ2gxQ.x56', '2018-08-30 06:54:25', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users_score`
--

CREATE TABLE `users_score` (
  `id` int(11) UNSIGNED NOT NULL,
  `users_id` int(11) UNSIGNED NOT NULL,
  `apps_id` int(11) UNSIGNED NOT NULL,
  `events_id` int(11) UNSIGNED NOT NULL,
  `score` int(11) NOT NULL,
  `level` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `update_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_score`
--

INSERT INTO `users_score` (`id`, `users_id`, `apps_id`, `events_id`, `score`, `level`, `created_at`, `update_at`) VALUES
(64, 48, 13, 6, 500, 3, '2018-08-26 05:46:57', '0000-00-00 00:00:00'),
(65, 51, 12, 4, 0, 1, '2018-08-26 08:11:48', '0000-00-00 00:00:00'),
(66, 53, 12, 4, 200, 1, '2018-08-26 15:07:24', '0000-00-00 00:00:00'),
(67, 53, 13, 6, 600, 2, '2018-08-26 15:19:23', '0000-00-00 00:00:00'),
(68, 54, 13, 6, 600, 2, '2018-08-26 15:36:48', '0000-00-00 00:00:00'),
(69, 55, 12, 4, 700, 2, '2018-08-26 16:08:04', '0000-00-00 00:00:00'),
(70, 53, 13, 6, 100, 1, '2018-08-27 07:21:09', '0000-00-00 00:00:00'),
(71, 53, 12, 4, 1000, 2, '2018-08-27 07:55:30', '0000-00-00 00:00:00'),
(72, 51, 12, 4, 200, 1, '2018-08-27 08:31:55', '0000-00-00 00:00:00'),
(73, 51, 13, 6, 0, 1, '2018-08-27 08:36:12', '0000-00-00 00:00:00'),
(74, 47, 12, 4, 3600, 6, '2018-08-27 10:54:02', '0000-00-00 00:00:00'),
(75, 59, 12, 4, 100, 1, '2018-08-27 11:21:58', '0000-00-00 00:00:00'),
(76, 55, 12, 4, 6200, 8, '2018-08-27 11:29:28', '0000-00-00 00:00:00'),
(77, 59, 13, 6, 300, 2, '2018-08-27 11:33:25', '0000-00-00 00:00:00'),
(78, 57, 13, 6, 400, 2, '2018-08-27 11:50:21', '0000-00-00 00:00:00'),
(79, 47, 13, 6, 0, 1, '2018-08-27 12:28:03', '0000-00-00 00:00:00'),
(80, 61, 13, 6, 0, 1, '2018-08-27 12:41:08', '0000-00-00 00:00:00'),
(81, 60, 12, 4, 8500, 10, '2018-08-27 13:06:16', '0000-00-00 00:00:00'),
(82, 57, 12, 4, 5300, 7, '2018-08-27 13:39:09', '0000-00-00 00:00:00'),
(83, 55, 13, 6, 0, 1, '2018-08-27 16:38:17', '0000-00-00 00:00:00'),
(84, 65, 12, 4, 1900, 3, '2018-08-27 17:40:59', '0000-00-00 00:00:00'),
(85, 65, 13, 6, 100, 1, '2018-08-27 17:42:10', '0000-00-00 00:00:00'),
(86, 66, 12, 4, 500, 2, '2018-08-27 18:23:29', '0000-00-00 00:00:00'),
(87, 66, 13, 6, 0, 1, '2018-08-27 18:24:41', '0000-00-00 00:00:00'),
(88, 67, 12, 4, 900, 2, '2018-08-27 19:26:13', '0000-00-00 00:00:00'),
(89, 67, 13, 6, 200, 1, '2018-08-27 19:34:03', '0000-00-00 00:00:00'),
(90, 69, 13, 6, 0, 2, '2018-08-28 00:53:42', '0000-00-00 00:00:00'),
(91, 58, 12, 4, 2900, 5, '2018-08-28 01:13:53', '0000-00-00 00:00:00'),
(92, 69, 12, 4, 1800, 4, '2018-08-28 01:16:33', '0000-00-00 00:00:00'),
(93, 68, 12, 4, 2200, 5, '2018-08-28 01:38:33', '0000-00-00 00:00:00'),
(94, 47, 12, 4, 1000, 3, '2018-08-28 03:09:16', '0000-00-00 00:00:00'),
(95, 47, 13, 6, 100, 1, '2018-08-28 03:12:40', '0000-00-00 00:00:00'),
(96, 48, 12, 4, 100, 1, '2018-08-28 05:21:01', '0000-00-00 00:00:00'),
(97, 57, 12, 4, 6300, 8, '2018-08-28 06:42:09', '0000-00-00 00:00:00'),
(98, 64, 12, 4, 4300, 6, '2018-08-28 06:44:23', '0000-00-00 00:00:00'),
(99, 71, 12, 4, 0, 1, '2018-08-28 08:15:09', '0000-00-00 00:00:00'),
(100, 71, 13, 6, 600, 5, '2018-08-28 08:27:43', '0000-00-00 00:00:00'),
(101, 55, 12, 4, 4600, 6, '2018-08-28 12:49:37', '0000-00-00 00:00:00'),
(102, 55, 13, 6, 0, 1, '2018-08-28 14:29:44', '0000-00-00 00:00:00'),
(103, 64, 13, 6, 900, 3, '2018-08-28 14:46:05', '0000-00-00 00:00:00'),
(104, 68, 12, 4, 4000, 6, '2018-08-28 16:13:54', '0000-00-00 00:00:00'),
(105, 64, 12, 4, 5100, 7, '2018-08-29 01:44:33', '0000-00-00 00:00:00'),
(106, 68, 12, 4, 700, 5, '2018-08-29 04:31:39', '0000-00-00 00:00:00'),
(107, 68, 12, 4, 700, 5, '2018-08-29 04:31:39', '0000-00-00 00:00:00'),
(108, 73, 13, 6, 800, 3, '2018-08-29 04:36:01', '0000-00-00 00:00:00'),
(109, 55, 13, 6, 400, 2, '2018-08-29 07:30:31', '0000-00-00 00:00:00'),
(110, 55, 12, 4, 9700, 10, '2018-08-29 08:40:26', '0000-00-00 00:00:00'),
(111, 73, 12, 4, 3500, 5, '2018-08-29 10:23:45', '0000-00-00 00:00:00'),
(112, 43, 12, 4, 200, 1, '2018-08-29 15:38:28', '0000-00-00 00:00:00'),
(113, 57, 12, 4, 5300, 7, '2018-08-30 02:56:40', '0000-00-00 00:00:00'),
(114, 64, 12, 4, 2300, 4, '2018-08-30 04:08:18', '0000-00-00 00:00:00'),
(115, 68, 12, 4, 4800, 10, '2018-08-30 17:32:32', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `apps`
--
ALTER TABLE `apps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `events_app_id_foreign` (`apps_id`);

--
-- Indexes for table `quests`
--
ALTER TABLE `quests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `apps_id` (`apps_id`),
  ADD KEY `events_id` (`events_id`);

--
-- Indexes for table `t_activities`
--
ALTER TABLE `t_activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_cms`
--
ALTER TABLE `t_cms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_hobbies`
--
ALTER TABLE `t_hobbies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_order`
--
ALTER TABLE `t_order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `t_users_detail_id` (`t_users_detail_id`);

--
-- Indexes for table `t_orders_detail`
--
ALTER TABLE `t_orders_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `t_order_id` (`t_order_id`);

--
-- Indexes for table `t_rel_users_activities`
--
ALTER TABLE `t_rel_users_activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `t_users_detail_id` (`t_users_detail_id`),
  ADD KEY `t_activities_id` (`t_activities_id`);

--
-- Indexes for table `t_rel_users_hobbies`
--
ALTER TABLE `t_rel_users_hobbies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `t_users_detail_id` (`t_users_detail_id`),
  ADD KEY `t_group_hobbies_id` (`t_hobbies_id`);

--
-- Indexes for table `t_users_detail`
--
ALTER TABLE `t_users_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_users_history`
--
ALTER TABLE `t_users_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `t_users_detail_id` (`t_users_detail_id`);

--
-- Indexes for table `t_users_medsos`
--
ALTER TABLE `t_users_medsos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `t_users_detail_id` (`t_users_detail_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `t_users_detail_id` (`t_users_detail_id`);

--
-- Indexes for table `users_score`
--
ALTER TABLE `users_score`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_id` (`users_id`),
  ADD KEY `apps_id` (`apps_id`),
  ADD KEY `event_id` (`events_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `apps`
--
ALTER TABLE `apps`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `quests`
--
ALTER TABLE `quests`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `t_activities`
--
ALTER TABLE `t_activities`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `t_cms`
--
ALTER TABLE `t_cms`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `t_hobbies`
--
ALTER TABLE `t_hobbies`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `t_order`
--
ALTER TABLE `t_order`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `t_orders_detail`
--
ALTER TABLE `t_orders_detail`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `t_rel_users_activities`
--
ALTER TABLE `t_rel_users_activities`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT for table `t_rel_users_hobbies`
--
ALTER TABLE `t_rel_users_hobbies`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `t_users_detail`
--
ALTER TABLE `t_users_detail`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `t_users_history`
--
ALTER TABLE `t_users_history`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `t_users_medsos`
--
ALTER TABLE `t_users_medsos`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `users_score`
--
ALTER TABLE `users_score`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_app_id_foreign` FOREIGN KEY (`apps_id`) REFERENCES `apps` (`id`);

--
-- Constraints for table `quests`
--
ALTER TABLE `quests`
  ADD CONSTRAINT `quests_ibfk_1` FOREIGN KEY (`apps_id`) REFERENCES `apps` (`id`),
  ADD CONSTRAINT `quests_ibfk_2` FOREIGN KEY (`events_id`) REFERENCES `events` (`id`);

--
-- Constraints for table `t_order`
--
ALTER TABLE `t_order`
  ADD CONSTRAINT `t_order_ibfk_1` FOREIGN KEY (`t_users_detail_id`) REFERENCES `t_users_detail` (`id`);

--
-- Constraints for table `t_orders_detail`
--
ALTER TABLE `t_orders_detail`
  ADD CONSTRAINT `t_orders_detail_ibfk_1` FOREIGN KEY (`t_order_id`) REFERENCES `t_order` (`id`);

--
-- Constraints for table `t_rel_users_activities`
--
ALTER TABLE `t_rel_users_activities`
  ADD CONSTRAINT `t_rel_users_activities_ibfk_1` FOREIGN KEY (`t_activities_id`) REFERENCES `t_activities` (`id`),
  ADD CONSTRAINT `t_rel_users_activities_ibfk_2` FOREIGN KEY (`t_users_detail_id`) REFERENCES `t_users_detail` (`id`);

--
-- Constraints for table `t_rel_users_hobbies`
--
ALTER TABLE `t_rel_users_hobbies`
  ADD CONSTRAINT `t_rel_users_hobbies_ibfk_1` FOREIGN KEY (`t_hobbies_id`) REFERENCES `t_hobbies` (`id`),
  ADD CONSTRAINT `t_rel_users_hobbies_ibfk_2` FOREIGN KEY (`t_users_detail_id`) REFERENCES `t_users_detail` (`id`);

--
-- Constraints for table `t_users_history`
--
ALTER TABLE `t_users_history`
  ADD CONSTRAINT `t_users_history_ibfk_1` FOREIGN KEY (`t_users_detail_id`) REFERENCES `t_users_detail` (`id`);

--
-- Constraints for table `t_users_medsos`
--
ALTER TABLE `t_users_medsos`
  ADD CONSTRAINT `t_users_medsos_ibfk_1` FOREIGN KEY (`t_users_detail_id`) REFERENCES `t_users_detail` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`t_users_detail_id`) REFERENCES `t_users_detail` (`id`);

--
-- Constraints for table `users_score`
--
ALTER TABLE `users_score`
  ADD CONSTRAINT `users_score_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `users_score_ibfk_2` FOREIGN KEY (`apps_id`) REFERENCES `apps` (`id`),
  ADD CONSTRAINT `users_score_ibfk_3` FOREIGN KEY (`events_id`) REFERENCES `events` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
