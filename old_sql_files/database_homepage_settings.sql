-- Table untuk pengaturan homepage yang dinamis
CREATE TABLE IF NOT EXISTS homepage_settings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    company_name VARCHAR(255) NOT NULL DEFAULT 'CV. Cendana Travel',
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
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default data
INSERT INTO homepage_settings (id, company_name, hero_title, hero_subtitle, hero_description) 
VALUES (1, 'CV. Cendana Travel', 'Perjalanan Impian', 'DIMULAI DARI SINI', 
'Layanan travel profesional dengan pengalaman lebih dari 10 tahun. Kami mengutamakan kenyamanan dan keamanan perjalanan Anda ke seluruh penjuru nusantara.')
ON DUPLICATE KEY UPDATE id=id;
