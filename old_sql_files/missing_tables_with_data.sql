mysqldump: Deprecated program name. It will be removed in a future release, use '/usr/bin/mariadb-dump' instead
/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19-12.0.2-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: cendana_travel
-- ------------------------------------------------------
-- Server version	12.0.2-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Table structure for table `home_booking_steps`
--

DROP TABLE IF EXISTS `home_booking_steps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `home_booking_steps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `step_number` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `icon_class` varchar(100) DEFAULT 'fas fa-check-circle',
  `display_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `home_booking_steps`
--

LOCK TABLES `home_booking_steps` WRITE;
/*!40000 ALTER TABLE `home_booking_steps` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `home_booking_steps` VALUES
(1,1,'Pilih Layanan','Kunjungi halaman Pemesanan dan pilih jenis transportasi yang Anda inginkan (pesawat, kapal, atau bus).',NULL,'fas fa-check-circle',0,1,'2025-12-04 16:03:07','2025-12-04 16:03:07'),
(2,2,'Hubungi Admin','Klik \"Pesan Sekarang\" dan isi form. Anda akan diarahkan ke WhatsApp admin untuk konfirmasi.',NULL,'fas fa-check-circle',0,1,'2025-12-04 16:03:07','2025-12-04 16:03:07'),
(3,3,'Lakukan Pembayaran','Transfer pembayaran sesuai instruksi. E-tiket akan dikirimkan setelah konfirmasi pembayaran.',NULL,'fas fa-check-circle',0,1,'2025-12-04 16:03:07','2025-12-04 16:03:07');
/*!40000 ALTER TABLE `home_booking_steps` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `home_gallery`
--

DROP TABLE IF EXISTS `home_gallery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `home_gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gallery_id` int(11) NOT NULL,
  `display_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `gallery_id` (`gallery_id`),
  CONSTRAINT `home_gallery_ibfk_1` FOREIGN KEY (`gallery_id`) REFERENCES `gallery` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `home_gallery`
--

LOCK TABLES `home_gallery` WRITE;
/*!40000 ALTER TABLE `home_gallery` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `home_gallery` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `home_gallery_selection`
--

DROP TABLE IF EXISTS `home_gallery_selection`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `home_gallery_selection` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image_path` varchar(255) NOT NULL,
  `caption` varchar(255) DEFAULT NULL,
  `display_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `home_gallery_selection`
--

LOCK TABLES `home_gallery_selection` WRITE;
/*!40000 ALTER TABLE `home_gallery_selection` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `home_gallery_selection` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `home_hero_section`
--

DROP TABLE IF EXISTS `home_hero_section`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `home_hero_section` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `main_title` varchar(255) NOT NULL,
  `sub_title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `button_text` varchar(100) DEFAULT 'Jelajahi Layanan',
  `button_link` varchar(255) DEFAULT 'pemesanan.php',
  `background_image` varchar(255) DEFAULT NULL,
  `display_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `home_hero_section`
--

LOCK TABLES `home_hero_section` WRITE;
/*!40000 ALTER TABLE `home_hero_section` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `home_hero_section` VALUES
(1,'Perjalanan Impian Dimulai dari Sini','Jelajahi Dunia, Kapan Saja & Dimana Saja','Layanan travel profesional dengan pengalaman lebih dari 10 tahun. Kami mengutamakan kenyamanan dan keamanan perjalanan Anda ke seluruh penjuru nusantara.','Jelajahi Layanan','pemesanan.php',NULL,1,1,'2025-12-06 02:30:52','2025-12-06 02:30:52');
/*!40000 ALTER TABLE `home_hero_section` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `home_legality`
--

DROP TABLE IF EXISTS `home_legality`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `home_legality` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `icon_class` varchar(100) DEFAULT 'fas fa-certificate',
  `is_active` tinyint(1) DEFAULT 1,
  `display_order` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `home_legality`
--

LOCK TABLES `home_legality` WRITE;
/*!40000 ALTER TABLE `home_legality` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `home_legality` VALUES
(1,'Terdaftar Resmi','CV. Cendana Travel adalah perusahaan travel yang terdaftar secara resmi di badan pemerintah yang kompeten','fas fa-certificate',1,1,'2025-12-04 16:03:07','2025-12-04 16:03:07'),
(2,'Lisensi Operasional','Kami memiliki lisensi operasional lengkap untuk menjalankan bisnis travel dengan izin yang sah.','fas fa-id-card',1,2,'2025-12-04 16:03:07','2025-12-04 16:03:07'),
(3,'Transaksi Aman','Semua transaksi dilindungi dengan sistem keamanan terbaik untuk melindungi data pribadi Anda.','fas fa-lock',1,3,'2025-12-04 16:03:07','2025-12-04 16:03:07'),
(4,'Perlindungan Data','Data pribadi pelanggan dijaga ketat sesuai dengan standar perlindungan data internasional','fas fa-shield-alt',1,4,'2025-12-04 16:03:07','2025-12-04 16:03:07');
/*!40000 ALTER TABLE `home_legality` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `home_payment_methods`
--

DROP TABLE IF EXISTS `home_payment_methods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `home_payment_methods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `icon_class` varchar(100) DEFAULT 'fas fa-credit-card',
  `is_active` tinyint(1) DEFAULT 1,
  `display_order` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `home_payment_methods`
--

LOCK TABLES `home_payment_methods` WRITE;
/*!40000 ALTER TABLE `home_payment_methods` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `home_payment_methods` VALUES
(1,'Transfer Bank','Transfer pembayaran ke rekening resmi kami yang tertera. Kami mendukung semua bank besar di Indonesia.','fas fa-university',1,1,'2025-12-04 16:03:07','2025-12-04 16:03:07'),
(2,'Konfirmasi Pembayaran','Kirim bukti transfer melalui WhatsApp atau form konfirmasi untuk proses verifikasi cepat.','fas fa-check-square',1,2,'2025-12-04 16:03:07','2025-12-04 16:03:07'),
(3,'Tiket Dikirim','Setelah validasi, e-tiket akan dikirim langsung melalui WhatsApp atau email Anda.','fas fa-ticket-alt',1,3,'2025-12-04 16:03:07','2025-12-04 16:03:07');
/*!40000 ALTER TABLE `home_payment_methods` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `home_services`
--

DROP TABLE IF EXISTS `home_services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `home_services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `icon_class` varchar(100) DEFAULT 'fas fa-plane',
  `is_active` tinyint(1) DEFAULT 1,
  `display_order` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `home_services`
--

LOCK TABLES `home_services` WRITE;
/*!40000 ALTER TABLE `home_services` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `home_services` VALUES
(1,'Tiket Pesawat','Pesan tiket pesawat ke seluruh kota besar di Indonesia dengan harga kompetitif dan pelayanan terbaik. Proses booking mudah, cepat, dan terpercaya dengan sistem pembayaran yang aman.','fas fa-plane',1,1,'2025-12-04 16:03:07','2025-12-04 16:03:07'),
(2,'Tiket Kapal','Jelajahi keindahan laut dengan layanan booking kapal penumpang yang nyaman dan aman ke berbagai pelabuhan.','fas fa-ship',1,2,'2025-12-04 16:03:07','2025-12-04 16:03:07'),
(3,'Tiket Bus','Armada bus premium dengan fasilitas lengkap untuk perjalanan antar kota yang nyaman dan terjangkau.','fas fa-bus',1,3,'2025-12-04 16:03:07','2025-12-04 16:03:07');
/*!40000 ALTER TABLE `home_services` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `home_why_us`
--

DROP TABLE IF EXISTS `home_why_us`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `home_why_us` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `icon_class` varchar(100) DEFAULT 'fas fa-check-circle',
  `is_active` tinyint(1) DEFAULT 1,
  `display_order` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `home_why_us`
--

LOCK TABLES `home_why_us` WRITE;
/*!40000 ALTER TABLE `home_why_us` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `home_why_us` VALUES
(1,'Legal & Terpercaya','Perusahaan travel resmi dengan izin operasional lengkap dari badan pemerintah yang kompeten.',NULL,'fas fa-check-circle',1,1,'2025-12-04 16:03:07','2025-12-04 16:03:07'),
(2,'Layanan 24/7','Tim customer service yang responsif siap membantu Anda kapan saja, bahkan di hari libur.',NULL,'fas fa-phone-alt',1,2,'2025-12-04 16:03:07','2025-12-04 16:03:07'),
(3,'Aman & Terjamin','Semua transaksi dijamin aman dengan sertifikat keamanan dan perlindungan data pelanggan yang ketat.',NULL,'fas fa-shield-alt',1,3,'2025-12-04 16:03:07','2025-12-04 16:03:07');
/*!40000 ALTER TABLE `home_why_us` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `transport_icons`
--

DROP TABLE IF EXISTS `transport_icons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `transport_icons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `icon_name` varchar(100) NOT NULL COMMENT 'Nama icon (contoh: Lion Air, Garuda)',
  `icon_file` varchar(255) NOT NULL COMMENT 'Path file icon (contoh: Lionair.png)',
  `icon_category` enum('pesawat','kapal','bus') NOT NULL COMMENT 'Kategori icon',
  `uploaded_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transport_icons`
--

LOCK TABLES `transport_icons` WRITE;
/*!40000 ALTER TABLE `transport_icons` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `transport_icons` VALUES
(1,'Lion Air','pesawat/Lionair.png','pesawat','2025-12-04 12:33:47','2025-12-04 12:33:47'),
(2,'Garuda Indonesia','pesawat/Garuda.png','pesawat','2025-12-04 12:33:47','2025-12-04 12:33:47'),
(3,'Citilink','pesawat/Citilink.png','pesawat','2025-12-04 12:33:47','2025-12-04 12:33:47'),
(4,'Sriwijaya Air','pesawat/Sriwijaya.png','pesawat','2025-12-04 12:33:47','2025-12-04 12:33:47'),
(5,'Pelita Air','pesawat/Pelita.png','pesawat','2025-12-04 12:33:47','2025-12-04 12:33:47'),
(6,'Royal Brunei','pesawat/RoyalBrunei.png','pesawat','2025-12-04 12:33:47','2025-12-04 12:33:47'),
(7,'Singapore Airlines','pesawat/Singapore.png','pesawat','2025-12-04 12:33:47','2025-12-04 12:33:47'),
(8,'Batik Air','pesawat/Batik.png','pesawat','2025-12-04 12:33:47','2025-12-04 12:33:47'),
(9,'KM. Kelud','kapal/kapallaut.png','kapal','2025-12-04 12:33:47','2025-12-04 12:33:47'),
(10,'Speedboat Express','kapal/speedboat.png','kapal','2025-12-04 12:33:47','2025-12-04 12:33:47'),
(11,'Bus Pariwisata','bus/bus.png','bus','2025-12-04 12:33:47','2025-12-04 12:33:47');
/*!40000 ALTER TABLE `transport_icons` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `transport_services_backup`
--

DROP TABLE IF EXISTS `transport_services_backup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `transport_services_backup` (
  `id` int(11) NOT NULL DEFAULT 0,
  `transport_type` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `route` text NOT NULL,
  `price` varchar(100) NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `display_order` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transport_services_backup`
--

LOCK TABLES `transport_services_backup` WRITE;
/*!40000 ALTER TABLE `transport_services_backup` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `transport_services_backup` VALUES
(1,'pesawat','Lion Air','pesawat/Lionair.png','Penerbangan domestik terpercaya','Rp 450.000 - Rp 850.000',1,1,'2025-12-03 11:23:11','2025-12-03 11:23:11'),
(2,'pesawat','Garuda Indonesia','pesawat/Garuda.png','Maskapai nasional Indonesia','Rp 500.000 - Rp 1.200.000',1,2,'2025-12-03 11:23:11','2025-12-03 11:23:11'),
(3,'pesawat','Batik Air','pesawat/Batik.png','Layanan premium dengan harga terjangkau','Rp 500.000 - Rp 950.000',1,3,'2025-12-03 11:23:11','2025-12-03 11:23:11'),
(4,'pesawat','Citilink','pesawat/Citilink.png','Low cost carrier terbaik','Rp 350.000 - Rp 650.000',1,4,'2025-12-03 11:23:11','2025-12-03 11:23:11'),
(5,'pesawat','Sriwijaya Air','pesawat/Sriwijaya.png','Jangkauan luas ke seluruh Indonesia','Rp 400.000 - Rp 750.000',1,5,'2025-12-03 11:23:11','2025-12-03 11:23:11'),
(6,'pesawat','Pelita Air','pesawat/Pelita.png','Penerbangan charter dan regular','Rp 380.000 - Rp 680.000',1,6,'2025-12-03 11:23:11','2025-12-03 11:23:11'),
(7,'pesawat','Royal Brunei','pesawat/RoyalBrunei.png','Penerbangan internasional ke Brunei','Rp 1.000.000 - Rp 1.800.000',1,7,'2025-12-03 11:23:11','2025-12-03 11:23:11'),
(8,'pesawat','Singapore Airlines','pesawat/Singapore.png','Premium airline ke Singapore','Rp 1.200.000 - Rp 2.500.000',1,8,'2025-12-03 11:23:11','2025-12-03 11:23:11'),
(9,'kapal','KM. Kelud','kapal/kapallaut.png','Kapal penumpang antar pulau','Rp 250.000 - Rp 450.000',1,1,'2025-12-03 11:23:11','2025-12-03 11:23:11'),
(10,'kapal','Speedboat Express','kapal/speedboat.png','Speedboat cepat dan nyaman','Rp 200.000 - Rp 350.000',1,2,'2025-12-03 11:23:11','2025-12-03 11:23:11'),
(11,'bus','Bus Pariwisata','bus/bus.png','Bus pariwisata dengan fasilitas lengkap','Rp 100.000 - Rp 250.000',1,1,'2025-12-03 11:23:11','2025-12-03 11:23:11'),
(12,'pesawat','vdvdv','','vdvdvdvdv','45000-8900000',1,9,'2025-12-03 11:53:31','2025-12-03 11:53:31'),
(13,'pesawat','dcdsc','','dcdcdcdcdcd','45000-8900000',1,10,'2025-12-03 12:01:44','2025-12-03 12:01:44');
/*!40000 ALTER TABLE `transport_services_backup` ENABLE KEYS */;
UNLOCK TABLES;
commit;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2025-12-07 21:39:01
