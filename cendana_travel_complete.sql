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
-- Current Database: `cendana_travel`
--

/*!40000 DROP DATABASE IF EXISTS `cendana_travel`*/;

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `cendana_travel` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;

USE `cendana_travel`;

--
-- Table structure for table `admin_sessions`
--

DROP TABLE IF EXISTS `admin_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin_sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL,
  `session_token` varchar(255) NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `expires_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `session_token` (`session_token`),
  KEY `admin_id` (`admin_id`),
  KEY `idx_session_token` (`session_token`),
  KEY `idx_expires_at` (`expires_at`),
  CONSTRAINT `admin_sessions_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admin_users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_sessions`
--

LOCK TABLES `admin_sessions` WRITE;
/*!40000 ALTER TABLE `admin_sessions` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `admin_sessions` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `admin_users`
--

DROP TABLE IF EXISTS `admin_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `last_login` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_users`
--

LOCK TABLES `admin_users` WRITE;
/*!40000 ALTER TABLE `admin_users` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `admin_users` (`id`, `username`, `password`, `full_name`, `email`, `is_active`, `last_login`, `created_at`, `updated_at`) VALUES (1,'admin','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','Administrator','admin@cendanatravel.com',1,NULL,'2025-12-03 11:23:11','2025-12-03 11:23:11');
/*!40000 ALTER TABLE `admin_users` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `bookings`
--

DROP TABLE IF EXISTS `bookings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `bookings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `booking_code` varchar(20) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_phone` varchar(20) NOT NULL,
  `customer_email` varchar(100) DEFAULT NULL,
  `transport_type` varchar(50) NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `route` varchar(255) NOT NULL,
  `departure_date` date NOT NULL,
  `departure_time` time DEFAULT NULL,
  `passengers` int(11) DEFAULT 1,
  `total_price` decimal(12,2) NOT NULL,
  `payment_status` enum('pending','paid','cancelled','refunded') DEFAULT 'pending',
  `booking_status` enum('confirmed','cancelled','completed') DEFAULT 'confirmed',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `booking_code` (`booking_code`),
  KEY `idx_booking_code` (`booking_code`),
  KEY `idx_booking_status` (`booking_status`),
  KEY `idx_payment_status` (`payment_status`),
  KEY `idx_departure_date` (`departure_date`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bookings`
--

LOCK TABLES `bookings` WRITE;
/*!40000 ALTER TABLE `bookings` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `bookings` (`id`, `booking_code`, `customer_name`, `customer_phone`, `customer_email`, `transport_type`, `service_name`, `route`, `departure_date`, `departure_time`, `passengers`, `total_price`, `payment_status`, `booking_status`, `notes`, `created_at`, `updated_at`) VALUES (1,'BK001','Ahmad Rizky','081234567890','ahmad@email.com','pesawat','Lion Air','Samarinda - Jakarta','2024-12-15','10:30:00',2,1700000.00,'paid','confirmed',NULL,'2025-12-03 11:23:11','2025-12-03 11:23:11'),
(2,'BK002','Siti Nurhaliza','082345678901','siti@email.com','kapal','KM. Kelud','Samarinda - Balikpapan','2024-12-16','14:00:00',1,350000.00,'pending','confirmed',NULL,'2025-12-03 11:23:11','2025-12-03 11:23:11'),
(3,'BK003','Budi Santoso','083456789012','budi@email.com','bus','Bus Pariwisata','Samarinda - Tenggarong','2024-12-17','08:00:00',3,450000.00,'paid','confirmed',NULL,'2025-12-03 11:23:11','2025-12-03 11:23:11'),
(4,'BK004','Maya Sari','084567890123','maya@email.com','pesawat','Garuda Indonesia','Samarinda - Surabaya','2024-12-18','16:45:00',1,950000.00,'cancelled','cancelled',NULL,'2025-12-03 11:23:11','2025-12-03 11:23:11'),
(5,'BK005','Andi Pratama','085678901234','andi@email.com','kapal','Speedboat Express','Samarinda - Kutai','2024-12-19','09:15:00',2,700000.00,'paid','completed',NULL,'2025-12-03 11:23:11','2025-12-03 11:23:11');
/*!40000 ALTER TABLE `bookings` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `company_info`
--

DROP TABLE IF EXISTS `company_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `company_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT 'Cv. Cendana Travel',
  `whatsapp` varchar(20) NOT NULL DEFAULT '6285821841529',
  `phone` varchar(20) DEFAULT NULL,
  `instagram` varchar(100) NOT NULL DEFAULT '@cendanatravel_official',
  `facebook` varchar(100) DEFAULT NULL,
  `twitter` varchar(100) DEFAULT NULL,
  `tiktok` varchar(100) DEFAULT NULL,
  `youtube` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL DEFAULT 'info@cendanatravel.com',
  `address` text NOT NULL,
  `google_maps_embed` text DEFAULT NULL,
  `hours` varchar(255) NOT NULL DEFAULT 'Senin - Minggu: 08.00 - 22.00 WIB',
  `description` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `company_info`
--

LOCK TABLES `company_info` WRITE;
/*!40000 ALTER TABLE `company_info` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `company_info` (`id`, `name`, `whatsapp`, `phone`, `instagram`, `facebook`, `twitter`, `tiktok`, `youtube`, `email`, `address`, `google_maps_embed`, `hours`, `description`, `created_at`, `updated_at`) VALUES (1,'CV. Cendana Travel','085821841529','(0541) 123456','@cendanatravel_official','','','@cendanatravel','','enendjn@d','rer','<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.6712345678901!2d117.123456!3d-0.123456!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMMKwMDcnMjQuNCJTIDExN8KwMDcnMjQuNCJF!5e0!3m2!1sid!2sid!4v1234567890123!5m2!1sid!2sid\" width=\"100%\" height=\"300\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\"></iframe>','Senin - Minggu: 08.00 - 22.00 WIBU','Kami adalah penyedia layanan travel terpercaya dengan pengalaman lebih dari 10 tahun dalam melayani perjalanan Anda. Berawal dari lokasi sederhana di depan masjid, kini kami telah berkembang dengan kantor cabang di Jl. Cendana No.8, Tlk. Lerong Ulu, Kec. Sungai Kunjang, Kota Samarinda, Kalimantan Timur. hgh','2025-12-03 11:23:11','2025-12-07 13:44:23');
/*!40000 ALTER TABLE `company_info` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `contact_info`
--

DROP TABLE IF EXISTS `contact_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `contact_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phone` varchar(20) NOT NULL,
  `whatsapp` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `maps_embed` text DEFAULT NULL,
  `office_hours` varchar(255) NOT NULL DEFAULT 'Senin - Minggu: 08.00 - 22.00 WIB',
  `facebook` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `tiktok` varchar(100) DEFAULT NULL,
  `youtube` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_info`
--

LOCK TABLES `contact_info` WRITE;
/*!40000 ALTER TABLE `contact_info` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `contact_info` (`id`, `phone`, `whatsapp`, `email`, `address`, `maps_embed`, `office_hours`, `facebook`, `instagram`, `twitter`, `tiktok`, `youtube`, `created_at`, `updated_at`) VALUES (1,'(0541) 123456','0812345566711','info@cendanatravel.crtretrrr','Jl. Cendana No.8, Tlk. Lerong Ulu, Kec. Sungai Kunjang, Kota Samarinda, Kalimantan Timur 75127','<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.671234567890!2d117.123456!3d-0.123456!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMMKwMDcnMjQuNCJTIDExN8KwMDcnMjQuNCJF!5e0!3m2!1sid!2sid!4v1234567890123!5m2!1sid!2sid\" width=\"100%\" height=\"300\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\"></iframe>','Senin - Minggu: 08.00 - 22.00 WIB','','@cendanatravel_official','',NULL,NULL,'2025-12-03 11:23:11','2025-12-06 04:37:16');
/*!40000 ALTER TABLE `contact_info` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `facilities`
--

DROP TABLE IF EXISTS `facilities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `facilities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `display_order` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_is_active_facilities` (`is_active`),
  KEY `idx_display_order_facilities` (`display_order`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `facilities`
--

LOCK TABLES `facilities` WRITE;
/*!40000 ALTER TABLE `facilities` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `facilities` (`id`, `name`, `description`, `image`, `is_active`, `display_order`, `created_at`, `updated_at`) VALUES (1,'Ruang Tunggu VIP','Ruang tunggu yang nyaman dengan AC, WiFi gratis, dan refreshment untuk kenyamanan Anda sebelum keberangkatan.','cendana/Screenshot 2025-10-28 014436.png',1,1,'2025-12-03 11:23:11','2025-12-03 11:23:11'),
(2,'Layanan Antar Jemput','Layanan antar jemput dari rumah ke terminal/bandara dengan kendaraan yang nyaman dan sopir berpengalaman.','cendana/Screenshot 2025-10-28 014729.png',1,2,'2025-12-03 11:23:11','2025-12-03 11:23:11'),
(3,'Customer Service 24/7','Tim customer service yang siap membantu Anda 24 jam sehari, 7 hari seminggu melalui WhatsApp dan telepon.','cendana/Screenshot 2025-10-28 014745.png',1,3,'2025-12-03 11:23:11','2025-12-03 11:23:11'),
(4,'Fasilitas Premium','Fasilitas premium dengan berbagai kemudahan untuk memberikan pengalaman perjalanan yang tak terlupakan.','cendana/Screenshot 2025-10-28 014806.png',1,4,'2025-12-03 11:23:11','2025-12-03 11:23:11'),
(5,'Layanan Konsultasi','Konsultasi perjalanan dengan tim ahli kami untuk merencanakan perjalanan impian Anda.','cendana/Screenshot 2025-10-28 014817.png',1,5,'2025-12-03 11:23:11','2025-12-03 11:23:11'),
(6,'Booking Online','Sistem booking online yang mudah dan cepat untuk kemudahan pemesanan tiket perjalanan Anda.','cendana/Screenshot 2025-10-28 014829.png',1,6,'2025-12-03 11:23:11','2025-12-03 11:23:11'),
(7,'Travel Insurance','Asuransi perjalanan komprehensif untuk melindungi Anda selama bepergian dengan tenang.','cendana/Screenshot 2025-10-28 014853.png',1,7,'2025-12-03 11:23:11','2025-12-03 11:23:11');
/*!40000 ALTER TABLE `facilities` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `faq`
--

DROP TABLE IF EXISTS `faq`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `faq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `category` varchar(100) DEFAULT 'Umum',
  `is_active` tinyint(1) DEFAULT 1,
  `display_order` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_faq_category` (`category`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faq`
--

LOCK TABLES `faq` WRITE;
/*!40000 ALTER TABLE `faq` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `faq` (`id`, `question`, `answer`, `category`, `is_active`, `display_order`, `created_at`, `updated_at`) VALUES (1,'Bagaimana cara memesan tiket?','Anda dapat memesan tiket melalui website kami, WhatsApp, atau datang langsung ke kantor. Prosesnya sangat mudah dan cepat.','Pemesanan',1,1,'2025-12-03 11:23:11','2025-12-03 11:23:11'),
(2,'Apakah bisa refund tiket?','Ya, kami menyediakan layanan refund sesuai dengan syarat dan ketentuan yang berlaku. Biasanya dikenakan biaya administrasi.','Pembatalan',1,2,'2025-12-03 11:23:11','2025-12-03 11:23:11'),
(4,'Apakah ada layanan antar jemput?','Ya, kami menyediakan layanan antar jemput dengan biaya tambahan sesuai jarak lokasi Anda.','Layanan',1,4,'2025-12-03 11:23:11','2025-12-03 11:23:11'),
(5,'Bagaimana sistem pembayaran?','Kami menerima pembayaran tunai, transfer bank, e-wallet, dan kartu kredit. Pembayaran dapat dilakukan saat booking atau H-1 keberangkatan.','Pembayaran',1,5,'2025-12-03 11:23:11','2025-12-03 11:23:11'),
(6,'nbvnbv','bvnbv','Pembatalan',1,0,'2025-12-06 04:23:44','2025-12-06 04:23:44');
/*!40000 ALTER TABLE `faq` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `gallery`
--

DROP TABLE IF EXISTS `gallery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `category` varchar(100) DEFAULT 'Umum',
  `is_featured` tinyint(1) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `display_order` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_gallery_category` (`category`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gallery`
--

LOCK TABLES `gallery` WRITE;
/*!40000 ALTER TABLE `gallery` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `gallery` (`id`, `title`, `description`, `image`, `category`, `is_featured`, `is_active`, `display_order`, `created_at`, `updated_at`) VALUES (1,'Kantor Pusat CV. Cendana Travel','Kantor pusat kami yang nyaman dan strategis di Samarinda','uploads/gallery/kantor1.jpg','Kantor',1,1,1,'2025-12-03 11:23:11','2025-12-03 11:23:11'),
(2,'Ruang Tunggu VIP','Fasilitas ruang tunggu VIP dengan AC dan WiFi gratis','uploads/gallery/ruang-tunggu.jpg','Fasilitas',1,1,2,'2025-12-03 11:23:11','2025-12-03 11:23:11'),
(3,'Armada Bus Pariwisata','Bus pariwisata dengan fasilitas lengkap dan nyaman','uploads/gallery/bus1.jpg','Transportasi',1,1,3,'2025-12-03 11:23:11','2025-12-03 11:23:11'),
(4,'Tim Customer Service','Tim customer service yang ramah dan profesional','uploads/gallery/cs-team.jpg','Tim',0,1,4,'2025-12-03 11:23:11','2025-12-03 11:23:11'),
(5,'Pelayanan 24 Jam','Kami siap melayani Anda 24 jam setiap hari','uploads/gallery/service24.jpg','Layanan',0,1,5,'2025-12-03 11:23:11','2025-12-03 11:23:11'),
(8,'cxdsc','xcxzc','gallery/WhatsAppImage2025-11-11at22.13.54.jpeg','Destinasi',0,1,0,'2025-12-06 02:05:46','2025-12-06 02:05:46'),
(12,'1','1','gallery/swappy-20251201-183355.png','fasilitas',0,1,10,'2025-12-06 05:05:04','2025-12-06 05:05:04'),
(13,'cdcdsc','cdcdc','gallery/swappy-20251115-234256.png','kantor',0,1,0,'2025-12-06 09:44:08','2025-12-06 09:44:08');
/*!40000 ALTER TABLE `gallery` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `gallery_home_selection`
--

DROP TABLE IF EXISTS `gallery_home_selection`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `gallery_home_selection` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gallery_id` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `gallery_id` (`gallery_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gallery_home_selection`
--

LOCK TABLES `gallery_home_selection` WRITE;
/*!40000 ALTER TABLE `gallery_home_selection` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `gallery_home_selection` (`id`, `gallery_id`, `description`, `sort_order`, `created_at`, `updated_at`) VALUES (1,1,'fdfdf',1,'2025-12-06 11:03:19','2025-12-06 11:03:19');
/*!40000 ALTER TABLE `gallery_home_selection` ENABLE KEYS */;
UNLOCK TABLES;
commit;

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
INSERT INTO `home_booking_steps` (`id`, `step_number`, `title`, `description`, `image`, `icon_class`, `display_order`, `is_active`, `created_at`, `updated_at`) VALUES (1,1,'Pilih Layanan','Kunjungi halaman Pemesanan dan pilih jenis transportasi yang Anda inginkan (pesawat, kapal, atau bus).',NULL,'fas fa-check-circle',0,1,'2025-12-04 16:03:07','2025-12-04 16:03:07'),
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
INSERT INTO `home_hero_section` (`id`, `main_title`, `sub_title`, `description`, `button_text`, `button_link`, `background_image`, `display_order`, `is_active`, `created_at`, `updated_at`) VALUES (1,'Perjalanan Impian Dimulai dari Sini','Jelajahi Dunia, Kapan Saja & Dimana Saja','Layanan travel profesional dengan pengalaman lebih dari 10 tahun. Kami mengutamakan kenyamanan dan keamanan perjalanan Anda ke seluruh penjuru nusantara.','Jelajahi Layanan','pemesanan.php',NULL,1,1,'2025-12-06 02:30:52','2025-12-06 02:30:52');
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
INSERT INTO `home_legality` (`id`, `title`, `description`, `icon_class`, `is_active`, `display_order`, `created_at`, `updated_at`) VALUES (1,'Terdaftar Resmi','CV. Cendana Travel adalah perusahaan travel yang terdaftar secara resmi di badan pemerintah yang kompeten','fas fa-certificate',1,1,'2025-12-04 16:03:07','2025-12-04 16:03:07'),
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
INSERT INTO `home_payment_methods` (`id`, `title`, `description`, `icon_class`, `is_active`, `display_order`, `created_at`, `updated_at`) VALUES (1,'Transfer Bank','Transfer pembayaran ke rekening resmi kami yang tertera. Kami mendukung semua bank besar di Indonesia.','fas fa-university',1,1,'2025-12-04 16:03:07','2025-12-04 16:03:07'),
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
INSERT INTO `home_services` (`id`, `title`, `description`, `icon_class`, `is_active`, `display_order`, `created_at`, `updated_at`) VALUES (1,'Tiket Pesawat','Pesan tiket pesawat ke seluruh kota besar di Indonesia dengan harga kompetitif dan pelayanan terbaik. Proses booking mudah, cepat, dan terpercaya dengan sistem pembayaran yang aman.','fas fa-plane',1,1,'2025-12-04 16:03:07','2025-12-04 16:03:07'),
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
INSERT INTO `home_why_us` (`id`, `title`, `description`, `image`, `icon_class`, `is_active`, `display_order`, `created_at`, `updated_at`) VALUES (1,'Legal & Terpercaya','Perusahaan travel resmi dengan izin operasional lengkap dari badan pemerintah yang kompeten.',NULL,'fas fa-check-circle',1,1,'2025-12-04 16:03:07','2025-12-04 16:03:07'),
(2,'Layanan 24/7','Tim customer service yang responsif siap membantu Anda kapan saja, bahkan di hari libur.',NULL,'fas fa-phone-alt',1,2,'2025-12-04 16:03:07','2025-12-04 16:03:07'),
(3,'Aman & Terjamin','Semua transaksi dijamin aman dengan sertifikat keamanan dan perlindungan data pelanggan yang ketat.',NULL,'fas fa-shield-alt',1,3,'2025-12-04 16:03:07','2025-12-04 16:03:07');
/*!40000 ALTER TABLE `home_why_us` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `homepage_banners`
--

DROP TABLE IF EXISTS `homepage_banners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `homepage_banners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `subtitle` text DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `link_url` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `display_order` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `homepage_banners`
--

LOCK TABLES `homepage_banners` WRITE;
/*!40000 ALTER TABLE `homepage_banners` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `homepage_banners` (`id`, `title`, `subtitle`, `image`, `link_url`, `is_active`, `display_order`, `created_at`, `updated_at`) VALUES (1,'Perjalanan Impian Anda Dimulai Dari Sini','Nikmati layanan travel terbaik dengan harga terjangkau dan pelayanan 24/7','uploads/banner1.jpg',NULL,1,1,'2025-12-03 11:23:11','2025-12-03 11:23:11'),
(2,'Jelajahi Indonesia Bersama Kami','Dari Sabang sampai Merauke, kami siap mengantarkan perjalanan Anda','uploads/banner2.jpg',NULL,1,2,'2025-12-03 11:23:11','2025-12-03 11:23:11'),
(3,'Booking Online, Mudah dan Terpercaya','Pesan tiket perjalanan Anda kapan saja, dimana saja dengan sistem booking online kami','uploads/banner3.jpg',NULL,1,3,'2025-12-03 11:23:11','2025-12-03 11:23:11'),
(4,'jsdasdhcu','nxxsnjsnxj','swappy-20251117-231917.png','',1,0,'2025-12-04 13:37:43','2025-12-04 13:37:43');
/*!40000 ALTER TABLE `homepage_banners` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `homepage_settings`
--

DROP TABLE IF EXISTS `homepage_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `homepage_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(255) NOT NULL DEFAULT 'CV. Cendana Travel',
  `company_address` text DEFAULT NULL,
  `company_hours` varchar(255) DEFAULT NULL,
  `company_email` varchar(100) DEFAULT NULL,
  `company_whatsapp` varchar(20) DEFAULT NULL,
  `company_instagram` varchar(100) DEFAULT NULL,
  `company_tiktok` varchar(100) DEFAULT NULL,
  `hero_title` varchar(255) NOT NULL DEFAULT 'Perjalanan Impian',
  `hero_subtitle` varchar(255) NOT NULL DEFAULT 'DIMULAI DARI SINI',
  `hero_description` text NOT NULL DEFAULT 'Layanan travel profesional dengan pengalaman lebih dari 10 tahun. Kami mengutamakan kenyamanan dan keamanan perjalanan Anda ke seluruh penjuru nusantara.',
  `hero_background` varchar(255) DEFAULT NULL,
  `stats_years` varchar(50) DEFAULT '10+',
  `stats_years_label` varchar(100) DEFAULT 'Tahun Pengalaman',
  `stats_customers` varchar(50) DEFAULT '5000+',
  `stats_customers_label` varchar(100) DEFAULT 'Pelanggan Puas',
  `stats_rating` varchar(50) DEFAULT '4.9',
  `stats_rating_label` varchar(100) DEFAULT 'Rating',
  `footer_description` text DEFAULT 'Kami adalah penyedia layanan travel terpercaya dengan pengalaman lebih dari 10 tahun dalam melayani perjalanan Anda.',
  `footer_copyright` varchar(255) DEFAULT '© 2024 CV. Cendana Travel. All rights reserved.',
  `pemesanan_hero_title` varchar(255) DEFAULT 'Pemesanan Travel',
  `pemesanan_hero_description` text DEFAULT 'Pesan tiket pesawat, bus, dan kapal dengan mudah dan cepat',
  `pemesanan_hero_background` varchar(255) DEFAULT NULL,
  `galeri_hero_title` varchar(255) DEFAULT 'Galeri Perjalanan',
  `galeri_hero_description` text DEFAULT 'Koleksi momen indah dari perjalanan pelanggan kami ke berbagai destinasi menakjubkan',
  `galeri_hero_background` varchar(255) DEFAULT NULL,
  `faq_hero_title` varchar(255) DEFAULT 'Pertanyaan yang Sering Diajukan',
  `faq_hero_description` text DEFAULT 'Temukan jawaban untuk pertanyaan umum seputar layanan kami',
  `faq_hero_background` varchar(255) DEFAULT NULL,
  `kontak_hero_title` varchar(255) DEFAULT 'Hubungi Kami',
  `kontak_hero_description` text DEFAULT 'Kami siap membantu Anda merencanakan perjalanan impian',
  `kontak_hero_background` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `homepage_settings`
--

LOCK TABLES `homepage_settings` WRITE;
/*!40000 ALTER TABLE `homepage_settings` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `homepage_settings` (`id`, `company_name`, `company_address`, `company_hours`, `company_email`, `company_whatsapp`, `company_instagram`, `company_tiktok`, `hero_title`, `hero_subtitle`, `hero_description`, `hero_background`, `stats_years`, `stats_years_label`, `stats_customers`, `stats_customers_label`, `stats_rating`, `stats_rating_label`, `footer_description`, `footer_copyright`, `pemesanan_hero_title`, `pemesanan_hero_description`, `pemesanan_hero_background`, `galeri_hero_title`, `galeri_hero_description`, `galeri_hero_background`, `faq_hero_title`, `faq_hero_description`, `faq_hero_background`, `kontak_hero_title`, `kontak_hero_description`, `kontak_hero_background`, `created_at`, `updated_at`) VALUES (1,'CV. Cendana Travel','rer','Senin - Minggu: 08.00 - 22.00 WI','enendjn@d','085821841529','@cendanatravel_official','@cendanatravel','Perjalanan Impian','DIMULAI DARI SINI','Layanan travel profesional dengan pengalaman lebih dari 10 tahun. Kami mengutamakan kenyamanan dan keamanan perjalanan Anda ke seluruh penjuru nusantara.','WhatsAppImage2025-12-06at19.18.26.jpeg','10+0','Tahun Pengalaman','5000+','Pelanggan Puas','4.9','4.9','Kami adalah penyedia layanan travel terpercaya dengan pengalaman lebih dari 10 tahun dalam melayani perjalanan Anda. Berawal dari lokasi sederhana, kini kami siap melayani kebutuhan liburan Anda.','© 2024 CV. Cendana Travel. All rights reserved','Temukan Tiket Perjalanan Terbaik','Pesan tiket pesawat, kapal, dan bus dengan harga terbaik. Proses cepat, aman, dan terpercaya untuk perjalanan Anda.','','Galeri Perjalanan','Koleksi momen indah dari perjalanan pelanggan kami ke berbagai destinasi menakjubkan. Lihat pengalaman nyata dan fasilitas yang kami tawarkan.','','Pusat Bantuan & FAQ','Jawaban lengkap untuk semua pertanyaan seputar layanan perjalanan kami. Temukan informasi yang Anda butuhkan.','','Hubungi Kami','Kami siap membantu kebutuhan perjalanan Anda','','2025-12-06 05:19:31','2025-12-07 13:44:23');
/*!40000 ALTER TABLE `homepage_settings` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `legal_security`
--

DROP TABLE IF EXISTS `legal_security`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `legal_security` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `icon` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `legal_security`
--

LOCK TABLES `legal_security` WRITE;
/*!40000 ALTER TABLE `legal_security` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `legal_security` (`id`, `icon`, `title`, `description`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES (1,'uploads/icons/legal_cert.png','Terdaftar Resmi','CV. Cendana Travel adalah perusahaan travel yang terdaftar secara resmi di badan pemerintah yang kompeten.',1,1,'2025-12-06 09:32:56','2025-12-06 09:32:56'),
(2,'uploads/icons/license.png','Lisensi Operasional','Kami memiliki lisensi operasional lengkap untuk menyeluruh bisnis travel dengan izin yang sah.',2,1,'2025-12-06 09:32:56','2025-12-06 09:32:56'),
(3,'uploads/icons/safe_transaction.png','Transaksi Aman','Semua transaksi dilindungi dengan sistem keamanan terkini untuk melindungi data pribadi Anda.',3,1,'2025-12-06 09:32:56','2025-12-06 09:32:56'),
(4,'uploads/icons/data_protection.png','Perlindungan Data','Data pribadi pelanggan dijaga ketat sesuai dengan standar perlindungan data internasional.',4,1,'2025-12-06 09:32:56','2025-12-06 09:32:56');
/*!40000 ALTER TABLE `legal_security` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `order_steps`
--

DROP TABLE IF EXISTS `order_steps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_steps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_steps`
--

LOCK TABLES `order_steps` WRITE;
/*!40000 ALTER TABLE `order_steps` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `order_steps` (`id`, `image`, `title`, `description`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES (1,'uploads/order_steps/step1.jpg','Pilih Layanan','Kunjungi halaman pemesanan utama kami. Di sana Anda dapat memilih jenis transportasi yang diinginkan (Pesawat, Kapal Laut, atau Bus) sesuai dengan tujuan dan kebutuhan perjalanan Anda.',1,1,'2025-12-06 09:32:56','2025-12-06 09:32:56'),
(2,'uploads/order_steps/step2.jpg','Hubungi Admin','Setelah memilih layanan, klik tombol \"Pesan Sekarang\". Isi formulir singkat dan Anda akan diarahkan otomatis ke WhatsApp admin kami untuk konfirmasi ketersediaan dan harga terkini.',2,1,'2025-12-06 09:32:56','2025-12-06 09:32:56');
/*!40000 ALTER TABLE `order_steps` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `payment_steps`
--

DROP TABLE IF EXISTS `payment_steps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment_steps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `icon` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_steps`
--

LOCK TABLES `payment_steps` WRITE;
/*!40000 ALTER TABLE `payment_steps` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `payment_steps` (`id`, `icon`, `title`, `description`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES (1,'uploads/icons/step1.png','Pilih Layanan','Kunjungi halaman pemesanan utama kami. Di sana Anda dapat memilih jenis transportasi yang diinginkan (Pesawat, Kapal Laut, atau Bus) sesuai dengan tujuan dan kebutuhan perjalanan Anda.',1,1,'2025-12-06 09:32:56','2025-12-06 09:32:56'),
(2,'uploads/icons/step2.png','Hubungi Admin','Setelah memilih layanan, klik tombol \"Pesan Sekarang\". Isi formulir singkat dan Anda akan diarahkan otomatis ke WhatsApp admin kami untuk konfirmasi ketersediaan dan harga terkini.',2,1,'2025-12-06 09:32:56','2025-12-06 09:32:56'),
(3,'uploads/icons/step3.png','Lakukan Pembayaran','Admin akan memberikan detail rekening dan jumlah yang harus dibayarkan. Anda dapat melakukan transfer melalui bank atau e-wallet sesuai instruksi.',3,1,'2025-12-06 09:32:56','2025-12-06 09:32:56');
/*!40000 ALTER TABLE `payment_steps` ENABLE KEYS */;
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
INSERT INTO `transport_icons` (`id`, `icon_name`, `icon_file`, `icon_category`, `uploaded_at`, `updated_at`) VALUES (1,'Lion Air','pesawat/Lionair.png','pesawat','2025-12-04 12:33:47','2025-12-04 12:33:47'),
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
-- Table structure for table `transport_services`
--

DROP TABLE IF EXISTS `transport_services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `transport_services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transport_type` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `route` text NOT NULL,
  `price` varchar(100) NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `display_order` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_transport_type` (`transport_type`),
  KEY `idx_is_active_services` (`is_active`),
  KEY `idx_display_order_services` (`display_order`),
  KEY `fk_transport_logo` (`logo`),
  CONSTRAINT `transport_services_ibfk_1` FOREIGN KEY (`transport_type`) REFERENCES `transport_types` (`type_key`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transport_services`
--

LOCK TABLES `transport_services` WRITE;
/*!40000 ALTER TABLE `transport_services` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `transport_services` (`id`, `transport_type`, `name`, `logo`, `route`, `price`, `is_active`, `display_order`, `created_at`, `updated_at`) VALUES (1,'bus','Bus Pariwisata','bus/bus.png','Bus pariwisata dengan fasilitas lengkap','Rp 100.000 - Rp 250.000',1,1,'2025-12-03 11:23:11','2025-12-04 12:47:13'),
(2,'kapal','KM. Kelud','kapal/kapallaut.png','Kapal penumpang antar pulau','Rp 250.000 - Rp 450.000',1,1,'2025-12-03 11:23:11','2025-12-04 12:47:13'),
(3,'kapal','Speedboat Express','kapal/speedboat.png','Speedboat cepat dan nyaman','Rp 200.000 - Rp 350.000',1,2,'2025-12-03 11:23:11','2025-12-04 12:47:13'),
(4,'pesawat','Lion Air','pesawat/Lionair.png','Penerbangan domestik terpercaya','Rp 450.000 - Rp 850.000',1,1,'2025-12-03 11:23:11','2025-12-04 12:47:13'),
(5,'pesawat','Garuda Indonesia','pesawat/Garuda.png','Maskapai nasional Indonesia','Rp 500.000 - Rp 1.200.000',1,2,'2025-12-03 11:23:11','2025-12-04 12:47:13'),
(6,'pesawat','Citilink','pesawat/Citilink.png','Low cost carrier terbaik','Rp 350.000 - Rp 650.000',1,4,'2025-12-03 11:23:11','2025-12-04 12:47:13'),
(7,'pesawat','Sriwijaya Air','pesawat/Sriwijaya.png','Jangkauan luas ke seluruh Indonesia','Rp 400.000 - Rp 750.000',1,5,'2025-12-03 11:23:11','2025-12-04 12:47:13'),
(8,'pesawat','Pelita Air','pesawat/Pelita.png','Penerbangan charter dan regular','Rp 380.000 - Rp 680.000',1,6,'2025-12-03 11:23:11','2025-12-04 12:47:13'),
(9,'pesawat','Royal Brunei','pesawat/RoyalBrunei.png','Penerbangan internasional ke Brunei','Rp 1.000.000 - Rp 1.800.000',1,7,'2025-12-03 11:23:11','2025-12-04 12:47:13'),
(10,'pesawat','Singapore Airlines','pesawat/Singapore.png','Premium airline ke Singapore','Rp 1.200.000 - Rp 2.500.000',1,8,'2025-12-03 11:23:11','2025-12-04 12:47:13'),
(11,'pesawat','SUPER AIR','','Jakarta - Bali - Lombok','Rp 1.000.000 - Rp 2.000.000',1,0,'2025-12-03 12:01:44','2025-12-04 12:34:30'),
(12,'pesawat','nghnghngh','','hnhgnhg','45000-8900000',1,0,'2025-12-04 08:12:09','2025-12-04 12:34:30'),
(13,'pesawat','gfdfg','pesawat/swappy-20251115-234258.png','fdgdffg','45000-8900000',1,0,'2025-12-06 02:16:44','2025-12-06 08:41:52'),
(14,'pesawat','xasxs','','xass','Rp 1.000.000 - Rp 2.000.000',1,0,'2025-12-06 14:07:33','2025-12-06 14:07:33');
/*!40000 ALTER TABLE `transport_services` ENABLE KEYS */;
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
INSERT INTO `transport_services_backup` (`id`, `transport_type`, `name`, `logo`, `route`, `price`, `is_active`, `display_order`, `created_at`, `updated_at`) VALUES (1,'pesawat','Lion Air','pesawat/Lionair.png','Penerbangan domestik terpercaya','Rp 450.000 - Rp 850.000',1,1,'2025-12-03 11:23:11','2025-12-03 11:23:11'),
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

--
-- Table structure for table `transport_types`
--

DROP TABLE IF EXISTS `transport_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `transport_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_key` varchar(50) NOT NULL,
  `type_name` varchar(100) NOT NULL,
  `icon_class` varchar(100) DEFAULT 'icon icon-plane',
  `image_light` varchar(255) DEFAULT NULL,
  `image_dark` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `display_order` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `type_key` (`type_key`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transport_types`
--

LOCK TABLES `transport_types` WRITE;
/*!40000 ALTER TABLE `transport_types` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `transport_types` (`id`, `type_key`, `type_name`, `icon_class`, `image_light`, `image_dark`, `description`, `is_active`, `display_order`, `created_at`, `updated_at`) VALUES (1,'pesawat','Pesawat','icon icon-plane','JenisTransportasi/pesawatterang.png','JenisTransportasi/pesawatgelap.png','Transportasi udara yang cepat dan efisien untuk perjalanan jarak jauh',1,1,'2025-12-03 11:23:11','2025-12-03 11:23:11'),
(2,'kapal','Kapal','icon icon-ship','JenisTransportasi/kapalterang.png','JenisTransportasi/kapalgelap.png','Transportasi laut yang nyaman untuk perjalanan antar pulau dengan pemandangan indah',1,2,'2025-12-03 11:23:11','2025-12-03 11:23:11'),
(3,'bus','Bus','icon icon-bus','JenisTransportasi/busterang.png','JenisTransportasi/busgelap.png','Transportasi darat yang ekonomis dan terjangkau untuk perjalanan dalam kota dan antar kota',1,3,'2025-12-03 11:23:11','2025-12-03 11:23:11');
/*!40000 ALTER TABLE `transport_types` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `why_choose_us`
--

DROP TABLE IF EXISTS `why_choose_us`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `why_choose_us` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `icon` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `why_choose_us`
--

LOCK TABLES `why_choose_us` WRITE;
/*!40000 ALTER TABLE `why_choose_us` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `why_choose_us` (`id`, `icon`, `title`, `description`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES (1,'uploads/icons/legal.png','Legal & Terpercaya','Perusahaan travel resmi dengan izin operasional lengkap dan badan pemerintah yang kompeten.',1,1,'2025-12-06 09:32:56','2025-12-06 09:32:56'),
(2,'uploads/icons/support.png','Layanan 24/7','Tim customer service yang responsif siap membantu Anda kapan saja, bahkan di hari libur.',2,1,'2025-12-06 09:32:56','2025-12-06 09:32:56'),
(3,'uploads/icons/security.png','Aman & Terjamin','Semua transaksi dijamin aman dengan sertifikat keamanan dan perlindungan data pelanggan yang ketat.',3,1,'2025-12-06 09:32:56','2025-12-06 09:32:56'),
(5,NULL,'cdscdsc','cdscds',4,1,'2025-12-06 11:01:57','2025-12-06 11:01:57');
/*!40000 ALTER TABLE `why_choose_us` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Dumping routines for database 'cendana_travel'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2025-12-07 21:49:49
