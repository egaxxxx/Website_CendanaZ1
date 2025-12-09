-- Tambah kolom alamat dan jam operasional ke homepage_settings
ALTER TABLE homepage_settings 
ADD COLUMN company_address TEXT AFTER company_name,
ADD COLUMN company_hours VARCHAR(255) AFTER company_address;

-- Update dengan data default jika ada
UPDATE homepage_settings 
SET company_address = 'Jl. Cendana No.8, Tlk. Lerong Ulu, Kec. Sungai Kunjang, Kota Samarinda, Kalimantan Timur 75127',
    company_hours = 'Senin - Minggu: 08.00 - 22.00 WIB'
WHERE id = 1;
