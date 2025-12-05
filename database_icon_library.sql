-- ============================================
-- TABLE: transport_icons
-- Purpose: Menyimpan library icon/logo transportasi secara terpisah
-- ============================================

CREATE TABLE IF NOT EXISTS transport_icons (
    id INT PRIMARY KEY AUTO_INCREMENT,
    icon_name VARCHAR(100) NOT NULL COMMENT 'Nama icon (contoh: Lion Air, Garuda)',
    icon_file VARCHAR(255) NOT NULL COMMENT 'Path file icon (contoh: Lionair.png)',
    icon_category ENUM('pesawat', 'kapal', 'bus') NOT NULL COMMENT 'Kategori icon',
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================
-- MODIFY: transport_services table
-- Ubah field logo menjadi foreign key ke transport_icons
-- ============================================

-- Backup data logo lama ke temporary column
ALTER TABLE transport_services ADD COLUMN logo_backup VARCHAR(255) NULL AFTER logo;
UPDATE transport_services SET logo_backup = logo WHERE logo IS NOT NULL AND logo != '';

-- Ubah field logo jadi INT (foreign key)
ALTER TABLE transport_services MODIFY COLUMN logo INT NULL COMMENT 'ID dari transport_icons table';

-- Tambah foreign key constraint
ALTER TABLE transport_services 
ADD CONSTRAINT fk_transport_logo 
FOREIGN KEY (logo) REFERENCES transport_icons(id) 
ON DELETE SET NULL;

-- ============================================
-- MIGRASI DATA: Pindahkan icon manual ke table transport_icons
-- ============================================

-- Insert icon pesawat yang sudah ada manual
INSERT INTO transport_icons (icon_name, icon_file, icon_category) VALUES
('Lion Air', 'pesawat/Lionair.png', 'pesawat'),
('Garuda Indonesia', 'pesawat/Garuda.png', 'pesawat'),
('Citilink', 'pesawat/Citilink.png', 'pesawat'),
('Sriwijaya Air', 'pesawat/Sriwijaya.png', 'pesawat'),
('Pelita Air', 'pesawat/Pelita.png', 'pesawat'),
('Royal Brunei', 'pesawat/RoyalBrunei.png', 'pesawat'),
('Singapore Airlines', 'pesawat/Singapore.png', 'pesawat'),
('Batik Air', 'pesawat/Batik.png', 'pesawat');

-- Insert icon kapal (dari foto Anda)
INSERT INTO transport_icons (icon_name, icon_file, icon_category) VALUES
('KM. Kelud', 'kapal/kapallaut.png', 'kapal'),
('Speedboat Express', 'kapal/speedboat.png', 'kapal');

-- Insert icon bus
INSERT INTO transport_icons (icon_name, icon_file, icon_category) VALUES
('Bus Pariwisata', 'bus/bus.png', 'bus');

-- ============================================
-- UPDATE: Link data transport_services dengan transport_icons
-- ============================================

-- Link pesawat dengan icon yang sesuai
UPDATE transport_services ts
JOIN transport_icons ti ON ts.logo_backup LIKE CONCAT('%', ti.icon_file)
SET ts.logo = ti.id
WHERE ts.transport_type = 'pesawat';

UPDATE transport_services ts
JOIN transport_icons ti ON ts.logo_backup LIKE CONCAT('%', ti.icon_file)
SET ts.logo = ti.id
WHERE ts.transport_type = 'kapal';

UPDATE transport_services ts
JOIN transport_icons ti ON ts.logo_backup LIKE CONCAT('%', ti.icon_file)
SET ts.logo = ti.id
WHERE ts.transport_type = 'bus';

-- Hapus backup column setelah migrasi
ALTER TABLE transport_services DROP COLUMN logo_backup;

-- ============================================
-- Selesai! Struktur baru:
-- transport_icons: Library icon mandiri (CRUD sendiri)
-- transport_services.logo: Foreign key ke transport_icons.id
-- ============================================
