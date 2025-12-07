<?php
/**
 * Helper file untuk load homepage settings di semua halaman
 * Include file ini di awal setiap halaman
 */

if (!isset($homepageSettings)) {
    require_once __DIR__ . '/../config/database.php';
    require_once __DIR__ . '/functions.php';
    
    $homepageSettings = getHomepageSettings();
}

// Company info untuk navbar dan footer
$companyName = $homepageSettings['company_name'] ?? 'CV. Cendana Travel';
$companyAddress = $homepageSettings['company_address'] ?? 'Jl. Cendana No.8, Tlk. Lerong Ulu, Kec. Sungai Kunjang, Kota Samarinda, Kalimantan Timur 75127';
$companyHours = $homepageSettings['company_hours'] ?? 'Senin - Minggu: 08.00 - 22.00 WIB';
$companyEmail = $homepageSettings['company_email'] ?? 'info@cendanatravel.com';
$companyWhatsapp = $homepageSettings['company_whatsapp'] ?? '6285821841529';
$companyInstagram = $homepageSettings['company_instagram'] ?? '@cendanatravel_official';
$companyTiktok = $homepageSettings['company_tiktok'] ?? '';

// Footer data
$footerDescription = $homepageSettings['footer_description'] ?? 'Kami adalah penyedia layanan travel terpercaya dengan pengalaman lebih dari 10 tahun dalam melayani perjalanan Anda.';
$footerCopyright = $homepageSettings['footer_copyright'] ?? '© 2024 CV. Cendana Travel. All rights reserved.';
?>
