<?php
// Mimic admin.php untuk test
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Cek all required files
$files_to_check = [
    'config/database.php',
    'includes/functions.php',
];

echo "=== Checking required files ===\n";
foreach ($files_to_check as $file) {
    if (file_exists($file)) {
        echo "✅ $file - OK\n";
    } else {
        echo "❌ $file - MISSING!\n";
    }
}

// Cek if required functions exist
require_once 'includes/functions.php';

$functions_to_check = [
    'addFAQ',
    'updateFAQ',
    'deleteFAQ',
    'addGallery',
    'updateGallery',
    'deleteGallery',
    'updateContactInfo',
    'addTransportService',
    'addBannerBeranda',
];

echo "\n=== Checking required functions ===\n";
foreach ($functions_to_check as $func) {
    if (function_exists($func)) {
        echo "✅ $func - OK\n";
    } else {
        echo "❌ $func - MISSING!\n";
    }
}

echo "\n=== All checks done ===\n";
