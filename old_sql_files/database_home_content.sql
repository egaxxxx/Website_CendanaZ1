-- =====================================================
-- DATABASE KONTEN BERANDA DINAMIS
-- CV. CENDANA TRAVEL
-- =====================================================

-- Tabel 1: Mengapa Memilih Kami
CREATE TABLE IF NOT EXISTS `why_choose_us` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `icon` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data default untuk Mengapa Memilih Kami
INSERT INTO `why_choose_us` (`icon`, `title`, `description`, `sort_order`) VALUES
('uploads/icons/legal.png', 'Legal & Terpercaya', 'Perusahaan travel resmi dengan izin operasional lengkap dan badan pemerintah yang kompeten.', 1),
('uploads/icons/support.png', 'Layanan 24/7', 'Tim customer service yang responsif siap membantu Anda kapan saja, bahkan di hari libur.', 2),
('uploads/icons/security.png', 'Aman & Terjamin', 'Semua transaksi dijamin aman dengan sertifikat keamanan dan perlindungan data pelanggan yang ketat.', 3);

-- =====================================================

-- Tabel 2: Cara Pembayaran
CREATE TABLE IF NOT EXISTS `payment_steps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `icon` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data default untuk Cara Pembayaran
INSERT INTO `payment_steps` (`icon`, `title`, `description`, `sort_order`) VALUES
('uploads/icons/step1.png', 'Pilih Layanan', 'Kunjungi halaman pemesanan utama kami. Di sana Anda dapat memilih jenis transportasi yang diinginkan (Pesawat, Kapal Laut, atau Bus) sesuai dengan tujuan dan kebutuhan perjalanan Anda.', 1),
('uploads/icons/step2.png', 'Hubungi Admin', 'Setelah memilih layanan, klik tombol "Pesan Sekarang". Isi formulir singkat dan Anda akan diarahkan otomatis ke WhatsApp admin kami untuk konfirmasi ketersediaan dan harga terkini.', 2),
('uploads/icons/step3.png', 'Lakukan Pembayaran', 'Admin akan memberikan detail rekening dan jumlah yang harus dibayarkan. Anda dapat melakukan transfer melalui bank atau e-wallet sesuai instruksi.', 3);

-- =====================================================

-- Tabel 3: Bagaimana Cara Memesan
CREATE TABLE IF NOT EXISTS `order_steps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data default untuk Bagaimana Cara Memesan
INSERT INTO `order_steps` (`image`, `title`, `description`, `sort_order`) VALUES
('uploads/order_steps/step1.jpg', 'Pilih Layanan', 'Kunjungi halaman pemesanan utama kami. Di sana Anda dapat memilih jenis transportasi yang diinginkan (Pesawat, Kapal Laut, atau Bus) sesuai dengan tujuan dan kebutuhan perjalanan Anda.', 1),
('uploads/order_steps/step2.jpg', 'Hubungi Admin', 'Setelah memilih layanan, klik tombol "Pesan Sekarang". Isi formulir singkat dan Anda akan diarahkan otomatis ke WhatsApp admin kami untuk konfirmasi ketersediaan dan harga terkini.', 2);

-- =====================================================

-- Tabel 4: Galeri Beranda (Pilihan dari galeri utama, maks 3)
CREATE TABLE IF NOT EXISTS `gallery_home_selection` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gallery_id` int(11) NOT NULL,
  `description` text,
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `gallery_id` (`gallery_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Catatan: Data akan dipilih dari tabel 'gallery' yang sudah ada
-- Admin dapat memilih maksimal 3 foto dari galeri utama

-- =====================================================

-- Tabel 5: Legalitas & Keamanan
CREATE TABLE IF NOT EXISTS `legal_security` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `icon` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data default untuk Legalitas & Keamanan
INSERT INTO `legal_security` (`icon`, `title`, `description`, `sort_order`) VALUES
('uploads/icons/legal_cert.png', 'Terdaftar Resmi', 'CV. Cendana Travel adalah perusahaan travel yang terdaftar secara resmi di badan pemerintah yang kompeten.', 1),
('uploads/icons/license.png', 'Lisensi Operasional', 'Kami memiliki lisensi operasional lengkap untuk menyeluruh bisnis travel dengan izin yang sah.', 2),
('uploads/icons/safe_transaction.png', 'Transaksi Aman', 'Semua transaksi dilindungi dengan sistem keamanan terkini untuk melindungi data pribadi Anda.', 3),
('uploads/icons/data_protection.png', 'Perlindungan Data', 'Data pribadi pelanggan dijaga ketat sesuai dengan standar perlindungan data internasional.', 4);

-- =====================================================
-- CATATAN PENTING:
-- 1. Folder untuk upload icon: uploads/icons/
-- 2. Folder untuk upload gambar order steps: uploads/order_steps/
-- 3. Tabel gallery sudah ada, hanya perlu referensi ke gallery_home_selection
-- 4. Semua tabel menggunakan sort_order untuk pengaturan urutan tampilan
-- 5. Field is_active untuk enable/disable tanpa menghapus data
-- =====================================================
