-- ============================================
-- TABEL UNTUK CRUD BERANDA PELANGGAN
-- ============================================

-- TABEL: home_services (Layanan Unggulan Kami - 3 layanan)
CREATE TABLE IF NOT EXISTS home_services (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    icon_class VARCHAR(100) DEFAULT 'fas fa-plane',
    is_active TINYINT(1) DEFAULT 1,
    display_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO home_services (title, description, icon_class, display_order) VALUES
('Tiket Pesawat', 'Pesan tiket pesawat ke seluruh kota besar di Indonesia dengan harga kompetitif dan pelayanan terbaik. Proses booking mudah, cepat, dan terpercaya dengan sistem pembayaran yang aman.', 'fas fa-plane', 1),
('Tiket Kapal', 'Jelajahi keindahan laut dengan layanan booking kapal penumpang yang nyaman dan aman ke berbagai pelabuhan.', 'fas fa-ship', 2),
('Tiket Bus', 'Armada bus premium dengan fasilitas lengkap untuk perjalanan antar kota yang nyaman dan terjangkau.', 'fas fa-bus', 3);

-- TABEL: home_why_us (Mengapa Memilih Kami - 3 alasan)
CREATE TABLE IF NOT EXISTS home_why_us (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    icon_class VARCHAR(100) DEFAULT 'fas fa-check-circle',
    is_active TINYINT(1) DEFAULT 1,
    display_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO home_why_us (title, description, icon_class, display_order) VALUES
('Legal & Terpercaya', 'Perusahaan travel resmi dengan izin operasional lengkap dari badan pemerintah yang kompeten.', 'fas fa-check-circle', 1),
('Layanan 24/7', 'Tim customer service yang responsif siap membantu Anda kapan saja, bahkan di hari libur.', 'fas fa-phone-alt', 2),
('Aman & Terjamin', 'Semua transaksi dijamin aman dengan sertifikat keamanan dan perlindungan data pelanggan yang ketat.', 'fas fa-shield-alt', 3);

-- TABEL: home_payment_methods (Cara Pembayaran - 3 metode)
CREATE TABLE IF NOT EXISTS home_payment_methods (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    icon_class VARCHAR(100) DEFAULT 'fas fa-credit-card',
    is_active TINYINT(1) DEFAULT 1,
    display_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO home_payment_methods (title, description, icon_class, display_order) VALUES
('Transfer Bank', 'Transfer pembayaran ke rekening resmi kami yang tertera. Kami mendukung semua bank besar di Indonesia.', 'fas fa-university', 1),
('Konfirmasi Pembayaran', 'Kirim bukti transfer melalui WhatsApp atau form konfirmasi untuk proses verifikasi cepat.', 'fas fa-check-square', 2),
('Tiket Dikirim', 'Setelah validasi, e-tiket akan dikirim langsung melalui WhatsApp atau email Anda.', 'fas fa-ticket-alt', 3);

-- TABEL: home_booking_steps (Bagaimana Cara Memesan - 3 langkah)
CREATE TABLE IF NOT EXISTS home_booking_steps (
    id INT PRIMARY KEY AUTO_INCREMENT,
    step_number INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO home_booking_steps (step_number, title, description) VALUES
(1, 'Pilih Layanan', 'Kunjungi halaman Pemesanan dan pilih jenis transportasi yang Anda inginkan (pesawat, kapal, atau bus).'),
(2, 'Hubungi Admin', 'Klik "Pesan Sekarang" dan isi form. Anda akan diarahkan ke WhatsApp admin untuk konfirmasi.'),
(3, 'Lakukan Pembayaran', 'Transfer pembayaran sesuai instruksi. E-tiket akan dikirimkan setelah konfirmasi pembayaran.');

-- TABEL: home_gallery (Galeri Beranda - Pilih dari galeri utama)
CREATE TABLE IF NOT EXISTS home_gallery (
    id INT PRIMARY KEY AUTO_INCREMENT,
    gallery_id INT NOT NULL,
    display_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (gallery_id) REFERENCES gallery(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- TABEL: home_legality (Legalitas & Keamanan - 4 poin)
CREATE TABLE IF NOT EXISTS home_legality (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    icon_class VARCHAR(100) DEFAULT 'fas fa-certificate',
    is_active TINYINT(1) DEFAULT 1,
    display_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO home_legality (title, description, icon_class, display_order) VALUES
('Terdaftar Resmi', 'CV. Cendana Travel adalah perusahaan travel yang terdaftar secara resmi di badan pemerintah yang kompeten', 'fas fa-certificate', 1),
('Lisensi Operasional', 'Kami memiliki lisensi operasional lengkap untuk menjalankan bisnis travel dengan izin yang sah.', 'fas fa-id-card', 2),
('Transaksi Aman', 'Semua transaksi dilindungi dengan sistem keamanan terbaik untuk melindungi data pribadi Anda.', 'fas fa-lock', 3),
('Perlindungan Data', 'Data pribadi pelanggan dijaga ketat sesuai dengan standar perlindungan data internasional', 'fas fa-shield-alt', 4);
