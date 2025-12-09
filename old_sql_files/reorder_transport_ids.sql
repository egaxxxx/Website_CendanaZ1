-- Script untuk Re-order ID Transport Services
-- Tujuan: Menghilangkan gap ID dan membuat ID berurutan 1,2,3,4,5...
-- Ketika data dihapus, ID dapat digunakan kembali

-- Step 1: Backup data
CREATE TABLE IF NOT EXISTS transport_services_backup AS 
SELECT * FROM transport_services;

-- Step 2: Hapus data lama (tapi simpan strukturnya)
DELETE FROM transport_services;

-- Step 3: Reset auto-increment ke 1
ALTER TABLE transport_services AUTO_INCREMENT = 1;

-- Step 4: Insert ulang data dengan ID berurutan dari backup
INSERT INTO transport_services (transport_type, name, logo, route, price, is_active, display_order, created_at, updated_at)
SELECT transport_type, name, logo, route, price, is_active, display_order, created_at, updated_at
FROM transport_services_backup
ORDER BY transport_type, display_order, id;

-- Step 5: Verifikasi hasil
SELECT id, name, transport_type, is_active FROM transport_services ORDER BY id;

-- Step 6: Hapus backup table (optional, bisa dijalankan manual jika sudah OK)
-- DROP TABLE transport_services_backup;
