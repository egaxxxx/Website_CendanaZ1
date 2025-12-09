<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

$homepageSettings = getHomepageSettings();

echo "<h1>Test Homepage Settings</h1>";
echo "<pre>";
echo "Company Name: " . ($homepageSettings['company_name'] ?? 'EMPTY') . "\n";
echo "Company Address: " . ($homepageSettings['company_address'] ?? 'EMPTY') . "\n";
echo "Company Hours: " . ($homepageSettings['company_hours'] ?? 'EMPTY') . "\n";
echo "Footer Description: " . ($homepageSettings['footer_description'] ?? 'EMPTY') . "\n";
echo "Footer Copyright: " . ($homepageSettings['footer_copyright'] ?? 'EMPTY') . "\n";
echo "\n--- Hero Backgrounds ---\n";
echo "Beranda: " . ($homepageSettings['hero_background'] ?? 'EMPTY') . "\n";
echo "Pemesanan: " . ($homepageSettings['pemesanan_hero_background'] ?? 'EMPTY') . "\n";
echo "Galeri: " . ($homepageSettings['galeri_hero_background'] ?? 'EMPTY') . "\n";
echo "FAQ: " . ($homepageSettings['faq_hero_background'] ?? 'EMPTY') . "\n";
echo "Kontak: " . ($homepageSettings['kontak_hero_background'] ?? 'EMPTY') . "\n";
echo "</pre>";
?>
