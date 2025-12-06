-- ============================================
-- DROP BERANDA TABLES SCRIPT
-- Menghapus semua tabel yang terkait dengan konten beranda
-- Database: CV. Cendana Travel
-- Date: 2025-12-06
-- ============================================

-- 1. Drop trigger untuk galeri_beranda
DROP TRIGGER IF EXISTS check_galeri_limit;

-- 2. Drop tabel-tabel beranda lama (versi 1)
DROP TABLE IF EXISTS `galeri_beranda`;
DROP TABLE IF EXISTS `cara_memesan`;
DROP TABLE IF EXISTS `keunggulan`;
DROP TABLE IF EXISTS `hero_section`;

-- 3. Drop tabel-tabel beranda versi baru (versi 2)
DROP TABLE IF EXISTS `home_gallery_selection`;
DROP TABLE IF EXISTS `home_gallery_section`;
DROP TABLE IF EXISTS `home_booking_steps`;
DROP TABLE IF EXISTS `home_why_choose_us`;
DROP TABLE IF EXISTS `home_hero_section`;
DROP TABLE IF EXISTS `home_services`;

-- ============================================
-- CATATAN PENTING - File yang sudah dihapus:
-- ============================================
-- PHP Files:
-- - /admin_beranda.php (Admin interface v1)
-- - /admin_beranda_v2.php (Admin interface v2)
-- - /includes/beranda_functions.php (Fungsi-fungsi beranda)
-- - /includes/home_sections_functions.php (Fungsi home sections)
--
-- JavaScript Files:
-- - /admin_beranda_v2.js (Script admin beranda v2)
--
-- Database Files (SQL):
-- - database_beranda_complete.sql
-- - database_home_sections_v2.sql
-- - database_home_sections.sql
--
-- Documentation (Optional):
-- - PANDUAN_IMPLEMENTASI_BERANDA.md
-- - DOKUMENTASI_CRUD_BERANDA.md
-- - QUICK_START_CRUD_BERANDA.md
-- - README_CRUD_BERANDA.md
--
-- ============================================
-- Jalankan script ini untuk drop semua tabel beranda
-- ============================================
