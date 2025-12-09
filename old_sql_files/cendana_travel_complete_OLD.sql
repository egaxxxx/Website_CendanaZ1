-- =====================================================
-- DATABASE LENGKAP CV. CENDANA TRAVEL
-- =====================================================
-- Dibuat: 6 Desember 2025
-- Versi: 2.0 (Consolidated)
-- Deskripsi: Database lengkap untuk website travel management
-- Termasuk: Tabel utama, konten dinamis, dan homepage settings
-- =====================================================

-- Hapus database lama jika ada (HATI-HATI!)
DROP DATABASE IF EXISTS cendana_travel;

-- Buat database baru
CREATE DATABASE cendana_travel CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Gunakan database
USE cendana_travel;

-- =====================================================
-- BAGIAN 1: TABEL INFORMASI PERUSAHAAN
-- =====================================================

-- TABEL: company_info (Legacy - untuk backward compatibility)
CREATE TABLE company_info (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL DEFAULT 'Cv. Cendana Travel',
    whatsapp VARCHAR(20) NOT NULL DEFAULT '6285821841529',
    instagram VARCHAR(100) NOT NULL DEFAULT '@cendanatravel_official',
    email VARCHAR(100) NOT NULL DEFAULT 'info@cendanatravel.com',
    address TEXT NOT NULL,
    hours VARCHAR(255) NOT NULL DEFAULT 'Senin - Minggu: 08.00 - 22.00 WIB',
    description TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO company_info (id, name, whatsapp, instagram, email, address, hours, description) VALUES
(1, 'Cv. Cendana Travel', '6285821841529', '@cendanatravel_official', 'info@cendanatravel.com', 
'Jl. Cendana No.8, Tlk. Lerong Ulu, Kec. Sungai Kunjang<br>Kota Samarinda, Kalimantan Timur 75127',
'Senin - Minggu: 08.00 - 22.00 WIB',
'Kami adalah penyedia layanan travel terpercaya dengan pengalaman lebih dari 10 tahun dalam melayani perjalanan Anda. Berawal dari lokasi sederhana di depan masjid, kini kami telah berkembang dengan kantor cabang di Jl. Cendana No.8, Tlk. Lerong Ulu, Kec. Sungai Kunjang, Kota Samarinda, Kalimantan Timur.');

-- TABEL: contact_info (untuk Kontak)
CREATE TABLE contact_info (
    id INT PRIMARY KEY AUTO_INCREMENT,
    phone VARCHAR(20) NOT NULL,
    whatsapp VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL,
    address TEXT NOT NULL,
    maps_embed TEXT DEFAULT NULL,
    office_hours VARCHAR(255) NOT NULL DEFAULT 'Senin - Minggu: 08.00 - 22.00 WIB',
    facebook VARCHAR(255) DEFAULT NULL,
    instagram VARCHAR(255) DEFAULT NULL,
    twitter VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO contact_info (phone, whatsapp, email, address, maps_embed, instagram) VALUES
('(0541) 123456', '6285821841529', 'info@cendanatravel.com', 
'Jl. Cendana No.8, Tlk. Lerong Ulu, Kec. Sungai Kunjang, Kota Samarinda, Kalimantan Timur 75127',
'<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.671234567890!2d117.123456!3d-0.123456!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMMKwMDcnMjQuNCJTIDExN8KwMDcnMjQuNCJF!5e0!3m2!1sid!2sid!4v1234567890123!5m2!1sid!2sid" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>',
'@cendanatravel_official');

-- =====================================================
-- BAGIAN 2: HOMEPAGE SETTINGS (UTAMA - DIGUNAKAN FRONTEND)
-- =====================================================

-- TABEL: homepage_settings (Pengaturan Homepage Dinamis)
CREATE TABLE homepage_settings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    company_name VARCHAR(255) NOT NULL DEFAULT 'CV. Cendana Travel',
    company_address TEXT DEFAULT NULL,
    company_hours VARCHAR(255) DEFAULT NULL,
    company_email VARCHAR(100) DEFAULT NULL,
    company_whatsapp VARCHAR(20) DEFAULT NULL,
    company_instagram VARCHAR(100) DEFAULT NULL,
    company_tiktok VARCHAR(100) DEFAULT NULL,
    hero_title VARCHAR(255) NOT NULL DEFAULT 'Perjalanan Impian',
    hero_subtitle VARCHAR(255) NOT NULL DEFAULT 'DIMULAI DARI SINI',
    hero_description TEXT NOT NULL DEFAULT 'Layanan travel profesional dengan pengalaman lebih dari 10 tahun. Kami mengutamakan kenyamanan dan keamanan perjalanan Anda ke seluruh penjuru nusantara.',
    hero_background VARCHAR(255) DEFAULT NULL,
    stats_years VARCHAR(50) DEFAULT '10+',
    stats_years_label VARCHAR(100) DEFAULT 'Tahun Pengalaman',
    stats_customers VARCHAR(50) DEFAULT '5000+',
    stats_customers_label VARCHAR(100) DEFAULT 'Pelanggan Puas',
    stats_rating VARCHAR(50) DEFAULT '4.9',
    stats_rating_label VARCHAR(100) DEFAULT 'Rating',
    footer_description TEXT DEFAULT 'Kami adalah penyedia layanan travel terpercaya dengan pengalaman lebih dari 10 tahun dalam melayani perjalanan Anda.',
    footer_copyright VARCHAR(255) DEFAULT '© 2024 CV. Cendana Travel. All rights reserved.',
    pemesanan_hero_title VARCHAR(255) DEFAULT 'Pemesanan Travel',
    pemesanan_hero_description TEXT DEFAULT 'Pesan tiket pesawat, bus, dan kapal dengan mudah dan cepat',
    pemesanan_hero_background VARCHAR(255) DEFAULT NULL,
    galeri_hero_title VARCHAR(255) DEFAULT 'Galeri Perjalanan',
    galeri_hero_description TEXT DEFAULT 'Koleksi momen indah dari perjalanan pelanggan kami ke berbagai destinasi menakjubkan',
    galeri_hero_background VARCHAR(255) DEFAULT NULL,
    faq_hero_title VARCHAR(255) DEFAULT 'Pertanyaan yang Sering Diajukan',
    faq_hero_description TEXT DEFAULT 'Temukan jawaban untuk pertanyaan umum seputar layanan kami',
    faq_hero_background VARCHAR(255) DEFAULT NULL,
    kontak_hero_title VARCHAR(255) DEFAULT 'Hubungi Kami',
    kontak_hero_description TEXT DEFAULT 'Kami siap membantu Anda merencanakan perjalanan impian',
    kontak_hero_background VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default homepage settings
INSERT INTO homepage_settings (
    id, company_name, company_address, company_hours, company_email, company_whatsapp, company_instagram,
    hero_title, hero_subtitle, hero_description
) VALUES (
    1, 
    'CV. Cendana Travel',
    'Jl. Cendana No.8, Tlk. Lerong Ulu, Kec. Sungai Kunjang, Kota Samarinda, Kalimantan Timur 75127',
    'Senin - Minggu: 08.00 - 22.00 WIB',
    'info@cendanatravel.com',
    '6285821841529',
    '@cendanatravel_official',
    'Perjalanan Impian', 
    'DIMULAI DARI SINI', 
    'Layanan travel profesional dengan pengalaman lebih dari 10 tahun. Kami mengutamakan kenyamanan dan keamanan perjalanan Anda ke seluruh penjuru nusantara.'
) ON DUPLICATE KEY UPDATE id=id;

-- =====================================================
-- BAGIAN 3: KONTEN BERANDA DINAMIS (DIGUNAKAN FRONTEND)
-- =====================================================

-- TABEL: why_choose_us (Mengapa Memilih Kami)
CREATE TABLE why_choose_us (
    id INT PRIMARY KEY AUTO_INCREMENT,
    icon VARCHAR(255) DEFAULT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    sort_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO why_choose_us (icon, title, description, sort_order) VALUES
('uploads/icons/legal.png', 'Legal & Terpercaya', 'Perusahaan travel resmi dengan izin operasional lengkap dan terdaftar di badan pemerintah yang kompeten.', 1),
('uploads/icons/support.png', 'Layanan 24/7', 'Tim customer service yang responsif siap membantu Anda kapan saja, bahkan di hari libur.', 2),
('uploads/icons/security.png', 'Aman & Terjamin', 'Semua transaksi dijamin aman dengan sertifikat keamanan dan perlindungan data pelanggan yang ketat.', 3);

-- TABEL: payment_steps (Cara Pembayaran)
CREATE TABLE payment_steps (
    id INT PRIMARY KEY AUTO_INCREMENT,
    icon VARCHAR(255) DEFAULT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    sort_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO payment_steps (icon, title, description, sort_order) VALUES
('uploads/icons/step1.png', 'Pilih Layanan', 'Kunjungi halaman pemesanan utama kami. Di sana Anda dapat memilih jenis transportasi yang diinginkan (Pesawat, Kapal Laut, atau Bus) sesuai dengan tujuan dan kebutuhan perjalanan Anda.', 1),
('uploads/icons/step2.png', 'Hubungi Admin', 'Setelah memilih layanan, klik tombol "Pesan Sekarang". Isi formulir singkat dan Anda akan diarahkan otomatis ke WhatsApp admin kami untuk konfirmasi ketersediaan dan harga terkini.', 2),
('uploads/icons/step3.png', 'Lakukan Pembayaran', 'Admin akan memberikan detail rekening dan jumlah yang harus dibayarkan. Anda dapat melakukan transfer melalui bank atau e-wallet sesuai instruksi.', 3);

-- TABEL: order_steps (Bagaimana Cara Memesan)
CREATE TABLE order_steps (
    id INT PRIMARY KEY AUTO_INCREMENT,
    image VARCHAR(255) DEFAULT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    sort_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO order_steps (image, title, description, sort_order) VALUES
('uploads/order_steps/step1.jpg', 'Pilih Layanan', 'Kunjungi halaman pemesanan utama kami. Di sana Anda dapat memilih jenis transportasi yang diinginkan (Pesawat, Kapal Laut, atau Bus) sesuai dengan tujuan dan kebutuhan perjalanan Anda.', 1),
('uploads/order_steps/step2.jpg', 'Hubungi Admin', 'Setelah memilih layanan, klik tombol "Pesan Sekarang". Isi formulir singkat dan Anda akan diarahkan otomatis ke WhatsApp admin kami untuk konfirmasi ketersediaan dan harga terkini.', 2);

-- TABEL: legal_security (Legalitas & Keamanan)
CREATE TABLE legal_security (
    id INT PRIMARY KEY AUTO_INCREMENT,
    icon VARCHAR(255) DEFAULT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    sort_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO legal_security (icon, title, description, sort_order) VALUES
('uploads/icons/legal_cert.png', 'Terdaftar Resmi', 'CV. Cendana Travel adalah perusahaan travel yang terdaftar secara resmi di badan pemerintah yang kompeten.', 1),
('uploads/icons/license.png', 'Lisensi Operasional', 'Kami memiliki lisensi operasional lengkap untuk menyelenggarakan bisnis travel dengan izin yang sah.', 2),
('uploads/icons/safe_transaction.png', 'Transaksi Aman', 'Semua transaksi dilindungi dengan sistem keamanan terkini untuk melindungi data pribadi Anda.', 3),
('uploads/icons/data_protection.png', 'Perlindungan Data', 'Data pribadi pelanggan dijaga ketat sesuai dengan standar perlindungan data internasional.', 4);

-- =====================================================
-- BAGIAN 4: TRANSPORTASI & LAYANAN
-- =====================================================

-- TABEL: transport_types (Jenis Transportasi)
CREATE TABLE transport_types (
    id INT PRIMARY KEY AUTO_INCREMENT,
    type_key VARCHAR(50) NOT NULL UNIQUE,
    type_name VARCHAR(100) NOT NULL,
    icon_class VARCHAR(100) DEFAULT 'icon icon-plane',
    image_light VARCHAR(255) DEFAULT NULL,
    image_dark VARCHAR(255) DEFAULT NULL,
    description TEXT DEFAULT NULL,
    is_active TINYINT(1) DEFAULT 1,
    display_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO transport_types (type_key, type_name, icon_class, image_light, image_dark, description, display_order) VALUES
('pesawat', 'Pesawat', 'icon icon-plane', 'JenisTransportasi/pesawatterang.png', 'JenisTransportasi/pesawatgelap.png', 'Transportasi udara yang cepat dan efisien untuk perjalanan jarak jauh', 1),
('kapal', 'Kapal', 'icon icon-ship', 'JenisTransportasi/kapalterang.png', 'JenisTransportasi/kapalgelap.png', 'Transportasi laut yang nyaman untuk perjalanan antar pulau dengan pemandangan indah', 2),
('bus', 'Bus', 'icon icon-bus', 'JenisTransportasi/busterang.png', 'JenisTransportasi/busgelap.png', 'Transportasi darat yang ekonomis dan terjangkau untuk perjalanan dalam kota dan antar kota', 3);

-- TABEL: transport_services (Layanan Transportasi)
CREATE TABLE transport_services (
    id INT PRIMARY KEY AUTO_INCREMENT,
    transport_type VARCHAR(50) NOT NULL,
    name VARCHAR(255) NOT NULL,
    logo VARCHAR(255) DEFAULT NULL,
    route TEXT NOT NULL,
    price VARCHAR(100) NOT NULL,
    is_active TINYINT(1) DEFAULT 1,
    display_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (transport_type) REFERENCES transport_types(type_key) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO transport_services (transport_type, name, logo, route, price, display_order) VALUES
('pesawat', 'Lion Air', 'pesawat/Lionair.png', 'Penerbangan domestik terpercaya', 'Rp 450.000 - Rp 850.000', 1),
('pesawat', 'Garuda Indonesia', 'pesawat/Garuda.png', 'Maskapai nasional Indonesia', 'Rp 500.000 - Rp 1.200.000', 2),
('pesawat', 'Batik Air', 'pesawat/Batik.png', 'Layanan premium dengan harga terjangkau', 'Rp 500.000 - Rp 950.000', 3),
('pesawat', 'Citilink', 'pesawat/Citilink.png', 'Low cost carrier terbaik', 'Rp 350.000 - Rp 650.000', 4),
('pesawat', 'Sriwijaya Air', 'pesawat/Sriwijaya.png', 'Jangkauan luas ke seluruh Indonesia', 'Rp 400.000 - Rp 750.000', 5),
('pesawat', 'Pelita Air', 'pesawat/Pelita.png', 'Penerbangan charter dan regular', 'Rp 380.000 - Rp 680.000', 6),
('pesawat', 'Royal Brunei', 'pesawat/RoyalBrunei.png', 'Penerbangan internasional ke Brunei', 'Rp 1.000.000 - Rp 1.800.000', 7),
('pesawat', 'Singapore Airlines', 'pesawat/Singapore.png', 'Premium airline ke Singapore', 'Rp 1.200.000 - Rp 2.500.000', 8),
('kapal', 'KM. Kelud', 'kapal/kapallaut.png', 'Kapal penumpang antar pulau', 'Rp 250.000 - Rp 450.000', 1),
('kapal', 'Speedboat Express', 'kapal/speedboat.png', 'Speedboat cepat dan nyaman', 'Rp 200.000 - Rp 350.000', 2),
('bus', 'Bus Pariwisata', 'bus/bus.png', 'Bus pariwisata dengan fasilitas lengkap', 'Rp 100.000 - Rp 250.000', 1);

-- TABEL: facilities (Fasilitas)
CREATE TABLE facilities (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    image VARCHAR(255) DEFAULT NULL,
    is_active TINYINT(1) DEFAULT 1,
    display_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO facilities (name, description, image, display_order) VALUES
('Ruang Tunggu VIP', 'Ruang tunggu yang nyaman dengan AC, WiFi gratis, dan refreshment untuk kenyamanan Anda sebelum keberangkatan.', 'cendana/Screenshot 2025-10-28 014436.png', 1),
('Layanan Antar Jemput', 'Layanan antar jemput dari rumah ke terminal/bandara dengan kendaraan yang nyaman dan sopir berpengalaman.', 'cendana/Screenshot 2025-10-28 014729.png', 2),
('Customer Service 24/7', 'Tim customer service yang siap membantu Anda 24 jam sehari, 7 hari seminggu melalui WhatsApp dan telepon.', 'cendana/Screenshot 2025-10-28 014745.png', 3),
('Fasilitas Premium', 'Fasilitas premium dengan berbagai kemudahan untuk memberikan pengalaman perjalanan yang tak terlupakan.', 'cendana/Screenshot 2025-10-28 014806.png', 4),
('Layanan Konsultasi', 'Konsultasi perjalanan dengan tim ahli kami untuk merencanakan perjalanan impian Anda.', 'cendana/Screenshot 2025-10-28 014817.png', 5),
('Booking Online', 'Sistem booking online yang mudah dan cepat untuk kemudahan pemesanan tiket perjalanan Anda.', 'cendana/Screenshot 2025-10-28 014829.png', 6),
('Travel Insurance', 'Asuransi perjalanan komprehensif untuk melindungi Anda selama bepergian dengan tenang.', 'cendana/Screenshot 2025-10-28 014853.png', 7);

-- =====================================================
-- BAGIAN 5: GALERI & MEDIA
-- =====================================================

-- TABEL: gallery (Galeri Foto)
CREATE TABLE gallery (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    description TEXT DEFAULT NULL,
    image VARCHAR(255) NOT NULL,
    category VARCHAR(100) DEFAULT 'Umum',
    is_featured TINYINT(1) DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    display_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO gallery (title, description, image, category, is_featured, display_order) VALUES
('Kantor Pusat CV. Cendana Travel', 'Kantor pusat kami yang nyaman dan strategis di Samarinda', 'uploads/gallery/kantor1.jpg', 'Kantor', 1, 1),
('Ruang Tunggu VIP', 'Fasilitas ruang tunggu VIP dengan AC dan WiFi gratis', 'uploads/gallery/ruang-tunggu.jpg', 'Fasilitas', 1, 2),
('Armada Bus Pariwisata', 'Bus pariwisata dengan fasilitas lengkap dan nyaman', 'uploads/gallery/bus1.jpg', 'Transportasi', 1, 3),
('Tim Customer Service', 'Tim customer service yang ramah dan profesional', 'uploads/gallery/cs-team.jpg', 'Tim', 0, 4),
('Pelayanan 24 Jam', 'Kami siap melayani Anda 24 jam setiap hari', 'uploads/gallery/service24.jpg', 'Layanan', 0, 5);

-- TABEL: gallery_home_selection (Galeri Beranda - Max 3)
CREATE TABLE gallery_home_selection (
    id INT PRIMARY KEY AUTO_INCREMENT,
    gallery_id INT NOT NULL,
    description TEXT DEFAULT NULL,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (gallery_id) REFERENCES gallery(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- TABEL: homepage_banners (Banner Homepage)
CREATE TABLE homepage_banners (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    subtitle TEXT DEFAULT NULL,
    image VARCHAR(255) NOT NULL,
    link_url VARCHAR(255) DEFAULT NULL,
    is_active TINYINT(1) DEFAULT 1,
    display_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO homepage_banners (title, subtitle, image, display_order) VALUES
('Perjalanan Impian Anda Dimulai Dari Sini', 'Nikmati layanan travel terbaik dengan harga terjangkau dan pelayanan 24/7', 'uploads/banner1.jpg', 1),
('Jelajahi Indonesia Bersama Kami', 'Dari Sabang sampai Merauke, kami siap mengantarkan perjalanan Anda', 'uploads/banner2.jpg', 2),
('Booking Online, Mudah dan Terpercaya', 'Pesan tiket perjalanan Anda kapan saja, dimana saja dengan sistem booking online kami', 'uploads/banner3.jpg', 3);

-- =====================================================
-- BAGIAN 6: FAQ (Frequently Asked Questions)
-- =====================================================

-- TABEL: faq (Pertanyaan yang Sering Diajukan)
CREATE TABLE faq (
    id INT PRIMARY KEY AUTO_INCREMENT,
    question TEXT NOT NULL,
    answer TEXT NOT NULL,
    category VARCHAR(100) DEFAULT 'Umum',
    is_active TINYINT(1) DEFAULT 1,
    display_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO faq (question, answer, category, display_order) VALUES
('Bagaimana cara memesan tiket?', 'Anda dapat memesan tiket melalui website kami, WhatsApp, atau datang langsung ke kantor. Prosesnya sangat mudah dan cepat.', 'Pemesanan', 1),
('Apakah bisa refund tiket?', 'Ya, kami menyediakan layanan refund sesuai dengan syarat dan ketentuan yang berlaku. Biasanya dikenakan biaya administrasi.', 'Pembatalan', 2),
('Berapa lama sebelum keberangkatan harus booking?', 'Untuk memastikan ketersediaan tempat, kami sarankan booking minimal 2 hari sebelum keberangkatan.', 'Pemesanan', 3),
('Apakah ada layanan antar jemput?', 'Ya, kami menyediakan layanan antar jemput dengan biaya tambahan sesuai jarak lokasi Anda.', 'Layanan', 4),
('Bagaimana sistem pembayaran?', 'Kami menerima pembayaran tunai, transfer bank, e-wallet, dan kartu kredit. Pembayaran dapat dilakukan saat booking atau H-1 keberangkatan.', 'Pembayaran', 5);

-- =====================================================
-- BAGIAN 7: PEMESANAN (BOOKINGS)
-- =====================================================

-- TABEL: bookings (Data Pemesanan)
CREATE TABLE bookings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    booking_code VARCHAR(20) NOT NULL UNIQUE,
    customer_name VARCHAR(255) NOT NULL,
    customer_phone VARCHAR(20) NOT NULL,
    customer_email VARCHAR(100) DEFAULT NULL,
    transport_type VARCHAR(50) NOT NULL,
    service_name VARCHAR(255) NOT NULL,
    route VARCHAR(255) NOT NULL,
    departure_date DATE NOT NULL,
    departure_time TIME DEFAULT NULL,
    passengers INT DEFAULT 1,
    total_price DECIMAL(12,2) NOT NULL,
    payment_status ENUM('pending', 'paid', 'cancelled', 'refunded') DEFAULT 'pending',
    booking_status ENUM('confirmed', 'cancelled', 'completed') DEFAULT 'confirmed',
    notes TEXT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO bookings (booking_code, customer_name, customer_phone, customer_email, transport_type, service_name, route, departure_date, departure_time, passengers, total_price, payment_status, booking_status) VALUES
('BK001', 'Ahmad Rizky', '081234567890', 'ahmad@email.com', 'pesawat', 'Lion Air', 'Samarinda - Jakarta', '2024-12-15', '10:30:00', 2, 1700000.00, 'paid', 'confirmed'),
('BK002', 'Siti Nurhaliza', '082345678901', 'siti@email.com', 'kapal', 'KM. Kelud', 'Samarinda - Balikpapan', '2024-12-16', '14:00:00', 1, 350000.00, 'pending', 'confirmed'),
('BK003', 'Budi Santoso', '083456789012', 'budi@email.com', 'bus', 'Bus Pariwisata', 'Samarinda - Tenggarong', '2024-12-17', '08:00:00', 3, 450000.00, 'paid', 'confirmed'),
('BK004', 'Maya Sari', '084567890123', 'maya@email.com', 'pesawat', 'Garuda Indonesia', 'Samarinda - Surabaya', '2024-12-18', '16:45:00', 1, 950000.00, 'cancelled', 'cancelled'),
('BK005', 'Andi Pratama', '085678901234', 'andi@email.com', 'kapal', 'Speedboat Express', 'Samarinda - Kutai', '2024-12-19', '09:15:00', 2, 700000.00, 'paid', 'completed');

-- =====================================================
-- BAGIAN 8: ADMIN & AUTHENTICATION
-- =====================================================

-- TABEL: admin_users (User Admin)
CREATE TABLE admin_users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) DEFAULT NULL,
    is_active TINYINT(1) DEFAULT 1,
    last_login TIMESTAMP NULL DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Password default: admin123
INSERT INTO admin_users (username, password, full_name, email) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', 'admin@cendanatravel.com');

-- TABEL: admin_sessions (Session Admin)
CREATE TABLE admin_sessions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    admin_id INT NOT NULL,
    session_token VARCHAR(255) NOT NULL UNIQUE,
    ip_address VARCHAR(45) DEFAULT NULL,
    user_agent TEXT DEFAULT NULL,
    expires_at TIMESTAMP NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (admin_id) REFERENCES admin_users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- BAGIAN 9: INDEXES UNTUK PERFORMA
-- =====================================================

-- Index untuk transport_services
CREATE INDEX idx_transport_type ON transport_services(transport_type);
CREATE INDEX idx_is_active_services ON transport_services(is_active);
CREATE INDEX idx_display_order_services ON transport_services(display_order);

-- Index untuk facilities
CREATE INDEX idx_is_active_facilities ON facilities(is_active);
CREATE INDEX idx_display_order_facilities ON facilities(display_order);

-- Index untuk gallery
CREATE INDEX idx_gallery_category ON gallery(category);
CREATE INDEX idx_gallery_featured ON gallery(is_featured);

-- Index untuk faq
CREATE INDEX idx_faq_category ON faq(category);
CREATE INDEX idx_faq_active ON faq(is_active);

-- Index untuk bookings
CREATE INDEX idx_booking_code ON bookings(booking_code);
CREATE INDEX idx_booking_status ON bookings(booking_status);
CREATE INDEX idx_payment_status ON bookings(payment_status);
CREATE INDEX idx_departure_date ON bookings(departure_date);

-- Index untuk admin_sessions
CREATE INDEX idx_session_token ON admin_sessions(session_token);
CREATE INDEX idx_expires_at ON admin_sessions(expires_at);

-- Index untuk konten beranda
CREATE INDEX idx_why_choose_active ON why_choose_us(is_active);
CREATE INDEX idx_payment_steps_active ON payment_steps(is_active);
CREATE INDEX idx_order_steps_active ON order_steps(is_active);
CREATE INDEX idx_legal_security_active ON legal_security(is_active);

-- =====================================================
-- SELESAI - DATABASE SIAP DIGUNAKAN
-- =====================================================

-- CATATAN PENTING:
-- 1. Password admin default: admin123
-- 2. Username admin: admin
-- 3. Semua tabel menggunakan charset utf8mb4 untuk support emoji
-- 4. Foreign key constraints sudah diatur untuk integritas data
-- 5. Indexes sudah dibuat untuk performa query optimal
-- 6. Folder upload yang diperlukan:
--    - uploads/icons/
--    - uploads/order_steps/
--    - uploads/gallery/
--    - uploads/Beranda/
--    - pesawat/, kapal/, bus/
--    - JenisTransportasi/
