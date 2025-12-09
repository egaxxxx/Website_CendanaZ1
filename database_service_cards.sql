-- =====================================================
-- TABEL: service_cards
-- Deskripsi: Untuk section "Jelajahi Dunia" - 3 card layanan
-- =====================================================

CREATE TABLE IF NOT EXISTS `service_cards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `features` text DEFAULT NULL COMMENT 'JSON array untuk fitur-fitur',
  `button_text` varchar(100) DEFAULT 'Pesan Sekarang',
  `button_link` varchar(255) DEFAULT 'pemesanan.php',
  `is_featured` tinyint(1) DEFAULT 0 COMMENT '1 = Card besar (featured), 0 = Card kecil',
  `badge_text` varchar(50) DEFAULT NULL COMMENT 'Contoh: Terpopuler, Best Deal',
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_is_active` (`is_active`),
  KEY `idx_sort_order` (`sort_order`),
  KEY `idx_is_featured` (`is_featured`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- DATA AWAL (Sesuai dengan tampilan yang ada)
-- =====================================================

INSERT INTO `service_cards` (`id`, `title`, `description`, `image`, `features`, `button_text`, `button_link`, `is_featured`, `badge_text`, `sort_order`, `is_active`) VALUES
(1, 'Tiket Pesawat', 'Terbang ke seluruh destinasi domestik dan internasional dengan harga kompetitif. Proses booking instan dan terpercaya dengan sistem pembayaran yang aman.', 'https://images.unsplash.com/photo-1436491865332-7a61a109cc05?w=1200&h=600&fit=crop&q=80', '["Penerbangan Internasional & Domestik","Proses Check-in Mudah","Garansi Harga Terbaik"]', 'Cari Penerbangan →', 'pemesanan.php?type=pesawat', 1, 'Terpopuler', 1, 1),
(2, 'Tiket Bus Premium', 'Perjalanan darat yang nyaman dengan armada terbaru dan fasilitas lengkap untuk perjalanan antar kota yang nyaman dan terjangkau.', 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?w=800&h=500&fit=crop&q=80', NULL, 'Pesan Tiket Bus', 'pemesanan.php?type=bus', 0, NULL, 2, 1),
(3, 'Tiket Kapal Laut', 'Nikmati perjalanan laut antar pulau dengan aman dan pemandangan indah. Booking kapal penumpang yang nyaman dan aman ke berbagai pelabuhan.', 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=800&h=500&fit=crop&q=80', NULL, 'Pesan Tiket Kapal', 'pemesanan.php?type=kapal', 0, NULL, 3, 1);
