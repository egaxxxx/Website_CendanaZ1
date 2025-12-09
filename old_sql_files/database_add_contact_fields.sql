-- Tambah field kontak ke homepage_settings agar semua data di satu tempat
ALTER TABLE homepage_settings 
ADD COLUMN company_email VARCHAR(100) AFTER company_hours,
ADD COLUMN company_whatsapp VARCHAR(20) AFTER company_email,
ADD COLUMN company_instagram VARCHAR(100) AFTER company_whatsapp,
ADD COLUMN company_tiktok VARCHAR(100) AFTER company_instagram;

-- Copy data dari company_info ke homepage_settings
UPDATE homepage_settings h, company_info c
SET 
    h.company_email = c.email,
    h.company_whatsapp = c.whatsapp,
    h.company_instagram = c.instagram,
    h.company_tiktok = c.tiktok
WHERE h.id = 1 AND c.id = 1;
