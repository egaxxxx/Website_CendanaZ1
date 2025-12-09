-- Add TikTok and YouTube fields to contact_info table
ALTER TABLE contact_info
ADD COLUMN tiktok VARCHAR(100) DEFAULT NULL AFTER twitter,
ADD COLUMN youtube VARCHAR(255) DEFAULT NULL AFTER tiktok;
