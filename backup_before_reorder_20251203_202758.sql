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
INSERT INTO `admin_users` VALUES
(1,'admin','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','Administrator','admin@cendanatravel.com',1,NULL,'2025-12-03 11:23:11','2025-12-03 11:23:11');
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
INSERT INTO `bookings` VALUES
(1,'BK001','Ahmad Rizky','081234567890','ahmad@email.com','pesawat','Lion Air','Samarinda - Jakarta','2024-12-15','10:30:00',2,1700000.00,'paid','confirmed',NULL,'2025-12-03 11:23:11','2025-12-03 11:23:11'),
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
  `instagram` varchar(100) NOT NULL DEFAULT '@cendanatravel_official',
  `email` varchar(100) NOT NULL DEFAULT 'info@cendanatravel.com',
  `address` text NOT NULL,
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
INSERT INTO `company_info` VALUES
(1,'Cv. Cendana Travel','6285821841529','@cendanatravel_official','info@cendanatravel.com','Jl. Cendana No.8, Tlk. Lerong Ulu, Kec. Sungai Kunjang<br>Kota Samarinda, Kalimantan Timur 75127','Senin - Minggu: 08.00 - 22.00 WIB','Kami adalah penyedia layanan travel terpercaya dengan pengalaman lebih dari 10 tahun dalam melayani perjalanan Anda. Berawal dari lokasi sederhana di depan masjid, kini kami telah berkembang dengan kantor cabang di Jl. Cendana No.8, Tlk. Lerong Ulu, Kec. Sungai Kunjang, Kota Samarinda, Kalimantan Timur.','2025-12-03 11:23:11','2025-12-03 11:23:11');
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
INSERT INTO `contact_info` VALUES
(1,'(0541) 123456','6285821841529','info@cendanatravel.com','Jl. Cendana No.8, Tlk. Lerong Ulu, Kec. Sungai Kunjang, Kota Samarinda, Kalimantan Timur 75127','<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.671234567890!2d117.123456!3d-0.123456!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMMKwMDcnMjQuNCJTIDExN8KwMDcnMjQuNCJF!5e0!3m2!1sid!2sid!4v1234567890123!5m2!1sid!2sid\" width=\"100%\" height=\"300\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\"></iframe>','Senin - Minggu: 08.00 - 22.00 WIB',NULL,'@cendanatravel_official',NULL,'2025-12-03 11:23:11','2025-12-03 11:23:11');
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
INSERT INTO `facilities` VALUES
(1,'Ruang Tunggu VIP','Ruang tunggu yang nyaman dengan AC, WiFi gratis, dan refreshment untuk kenyamanan Anda sebelum keberangkatan.','cendana/Screenshot 2025-10-28 014436.png',1,1,'2025-12-03 11:23:11','2025-12-03 11:23:11'),
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faq`
--

LOCK TABLES `faq` WRITE;
/*!40000 ALTER TABLE `faq` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `faq` VALUES
(1,'Bagaimana cara memesan tiket?','Anda dapat memesan tiket melalui website kami, WhatsApp, atau datang langsung ke kantor. Prosesnya sangat mudah dan cepat.','Pemesanan',1,1,'2025-12-03 11:23:11','2025-12-03 11:23:11'),
(2,'Apakah bisa refund tiket?','Ya, kami menyediakan layanan refund sesuai dengan syarat dan ketentuan yang berlaku. Biasanya dikenakan biaya administrasi.','Pembatalan',1,2,'2025-12-03 11:23:11','2025-12-03 11:23:11'),
(3,'Berapa lama sebelum keberangkatan harus booking?','Untuk memastikan ketersediaan tempat, kami sarankan booking minimal 2 hari sebelum keberangkatan.','Pemesanan',1,3,'2025-12-03 11:23:11','2025-12-03 11:23:11'),
(4,'Apakah ada layanan antar jemput?','Ya, kami menyediakan layanan antar jemput dengan biaya tambahan sesuai jarak lokasi Anda.','Layanan',1,4,'2025-12-03 11:23:11','2025-12-03 11:23:11'),
(5,'Bagaimana sistem pembayaran?','Kami menerima pembayaran tunai, transfer bank, e-wallet, dan kartu kredit. Pembayaran dapat dilakukan saat booking atau H-1 keberangkatan.','Pembayaran',1,5,'2025-12-03 11:23:11','2025-12-03 11:23:11');
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gallery`
--

LOCK TABLES `gallery` WRITE;
/*!40000 ALTER TABLE `gallery` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `gallery` VALUES
(1,'Kantor Pusat CV. Cendana Travel','Kantor pusat kami yang nyaman dan strategis di Samarinda','uploads/gallery/kantor1.jpg','Kantor',1,1,1,'2025-12-03 11:23:11','2025-12-03 11:23:11'),
(2,'Ruang Tunggu VIP','Fasilitas ruang tunggu VIP dengan AC dan WiFi gratis','uploads/gallery/ruang-tunggu.jpg','Fasilitas',1,1,2,'2025-12-03 11:23:11','2025-12-03 11:23:11'),
(3,'Armada Bus Pariwisata','Bus pariwisata dengan fasilitas lengkap dan nyaman','uploads/gallery/bus1.jpg','Transportasi',1,1,3,'2025-12-03 11:23:11','2025-12-03 11:23:11'),
(4,'Tim Customer Service','Tim customer service yang ramah dan profesional','uploads/gallery/cs-team.jpg','Tim',0,1,4,'2025-12-03 11:23:11','2025-12-03 11:23:11'),
(5,'Pelayanan 24 Jam','Kami siap melayani Anda 24 jam setiap hari','uploads/gallery/service24.jpg','Layanan',0,1,5,'2025-12-03 11:23:11','2025-12-03 11:23:11');
/*!40000 ALTER TABLE `gallery` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `homepage_banners`
--

LOCK TABLES `homepage_banners` WRITE;
/*!40000 ALTER TABLE `homepage_banners` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `homepage_banners` VALUES
(1,'Perjalanan Impian Anda Dimulai Dari Sini','Nikmati layanan travel terbaik dengan harga terjangkau dan pelayanan 24/7','uploads/banner1.jpg',NULL,1,1,'2025-12-03 11:23:11','2025-12-03 11:23:11'),
(2,'Jelajahi Indonesia Bersama Kami','Dari Sabang sampai Merauke, kami siap mengantarkan perjalanan Anda','uploads/banner2.jpg',NULL,1,2,'2025-12-03 11:23:11','2025-12-03 11:23:11'),
(3,'Booking Online, Mudah dan Terpercaya','Pesan tiket perjalanan Anda kapan saja, dimana saja dengan sistem booking online kami','uploads/banner3.jpg',NULL,1,3,'2025-12-03 11:23:11','2025-12-03 11:23:11');
/*!40000 ALTER TABLE `homepage_banners` ENABLE KEYS */;
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
  CONSTRAINT `transport_services_ibfk_1` FOREIGN KEY (`transport_type`) REFERENCES `transport_types` (`type_key`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transport_services`
--

LOCK TABLES `transport_services` WRITE;
/*!40000 ALTER TABLE `transport_services` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `transport_services` VALUES
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
/*!40000 ALTER TABLE `transport_services` ENABLE KEYS */;
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
INSERT INTO `transport_types` VALUES
(1,'pesawat','Pesawat','icon icon-plane','JenisTransportasi/pesawatterang.png','JenisTransportasi/pesawatgelap.png','Transportasi udara yang cepat dan efisien untuk perjalanan jarak jauh',1,1,'2025-12-03 11:23:11','2025-12-03 11:23:11'),
(2,'kapal','Kapal','icon icon-ship','JenisTransportasi/kapalterang.png','JenisTransportasi/kapalgelap.png','Transportasi laut yang nyaman untuk perjalanan antar pulau dengan pemandangan indah',1,2,'2025-12-03 11:23:11','2025-12-03 11:23:11'),
(3,'bus','Bus','icon icon-bus','JenisTransportasi/busterang.png','JenisTransportasi/busgelap.png','Transportasi darat yang ekonomis dan terjangkau untuk perjalanan dalam kota dan antar kota',1,3,'2025-12-03 11:23:11','2025-12-03 11:23:11');
/*!40000 ALTER TABLE `transport_types` ENABLE KEYS */;
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

-- Dump completed on 2025-12-03 20:27:58
