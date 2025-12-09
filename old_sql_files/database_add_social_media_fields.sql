-- Add social media fields to company_info table
ALTER TABLE company_info 
ADD COLUMN phone VARCHAR(20) DEFAULT NULL AFTER whatsapp,
ADD COLUMN facebook VARCHAR(100) DEFAULT NULL AFTER instagram,
ADD COLUMN twitter VARCHAR(100) DEFAULT NULL AFTER facebook,
ADD COLUMN tiktok VARCHAR(100) DEFAULT NULL AFTER twitter,
ADD COLUMN youtube VARCHAR(100) DEFAULT NULL AFTER tiktok,
ADD COLUMN google_maps_embed TEXT DEFAULT NULL AFTER address;

-- Update existing record with default values
UPDATE company_info 
SET 
    phone = '(0541) 123456',
    facebook = '',
    twitter = '',
    tiktok = '@cendanatravel',
    youtube = '',
    google_maps_embed = '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.6712345678901!2d117.123456!3d-0.123456!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMMKwMDcnMjQuNCJTIDExN8KwMDcnMjQuNCJF!5e0!3m2!1sid!2sid!4v1234567890123!5m2!1sid!2sid" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>'
WHERE id = 1;
