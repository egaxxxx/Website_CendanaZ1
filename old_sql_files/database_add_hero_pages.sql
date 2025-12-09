-- Add hero settings for other pages
ALTER TABLE homepage_settings
ADD COLUMN pemesanan_hero_title VARCHAR(255) DEFAULT 'Pemesanan Travel' AFTER footer_copyright,
ADD COLUMN pemesanan_hero_description TEXT DEFAULT 'Pesan tiket pesawat, bus, dan kapal dengan mudah dan cepat' AFTER pemesanan_hero_title,
ADD COLUMN pemesanan_hero_background VARCHAR(255) DEFAULT NULL AFTER pemesanan_hero_description,

ADD COLUMN galeri_hero_title VARCHAR(255) DEFAULT 'Galeri Perjalanan' AFTER pemesanan_hero_background,
ADD COLUMN galeri_hero_description TEXT DEFAULT 'Koleksi momen indah dari perjalanan pelanggan kami ke berbagai destinasi menakjubkan' AFTER galeri_hero_title,
ADD COLUMN galeri_hero_background VARCHAR(255) DEFAULT NULL AFTER galeri_hero_description,

ADD COLUMN faq_hero_title VARCHAR(255) DEFAULT 'Pertanyaan yang Sering Diajukan' AFTER galeri_hero_background,
ADD COLUMN faq_hero_description TEXT DEFAULT 'Temukan jawaban untuk pertanyaan umum seputar layanan kami' AFTER faq_hero_title,
ADD COLUMN faq_hero_background VARCHAR(255) DEFAULT NULL AFTER faq_hero_description,

ADD COLUMN kontak_hero_title VARCHAR(255) DEFAULT 'Hubungi Kami' AFTER faq_hero_background,
ADD COLUMN kontak_hero_description TEXT DEFAULT 'Kami siap membantu Anda merencanakan perjalanan impian' AFTER kontak_hero_title,
ADD COLUMN kontak_hero_background VARCHAR(255) DEFAULT NULL AFTER kontak_hero_description;
