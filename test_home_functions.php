<?php
// Test file untuk memastikan home functions bekerja
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'config/database.php';
require_once 'includes/home_functions.php';

echo "<h1>Test Home Functions</h1>";

// Test 1: Get Home Services
echo "<h2>1. Test Home Services</h2>";
$services = getAllHomeServices();
if ($services) {
    echo "<p style='color: green;'>✅ SUKSES! Found " . count($services) . " services</p>";
    echo "<pre>";
    print_r($services);
    echo "</pre>";
} else {
    echo "<p style='color: red;'>❌ GAGAL! No services found</p>";
}

// Test 2: Get Home Why Us
echo "<h2>2. Test Home Why Us</h2>";
$whyUs = getAllHomeWhyUs();
if ($whyUs) {
    echo "<p style='color: green;'>✅ SUKSES! Found " . count($whyUs) . " why us items</p>";
    echo "<pre>";
    print_r($whyUs);
    echo "</pre>";
} else {
    echo "<p style='color: red;'>❌ GAGAL! No why us found</p>";
}

// Test 3: Get Home Payment Methods
echo "<h2>3. Test Payment Methods</h2>";
$payments = getAllHomePaymentMethods();
if ($payments) {
    echo "<p style='color: green;'>✅ SUKSES! Found " . count($payments) . " payment methods</p>";
    echo "<pre>";
    print_r($payments);
    echo "</pre>";
} else {
    echo "<p style='color: red;'>❌ GAGAL! No payment methods found</p>";
}

// Test 4: Get Home Booking Steps
echo "<h2>4. Test Booking Steps</h2>";
$steps = getAllHomeBookingSteps();
if ($steps) {
    echo "<p style='color: green;'>✅ SUKSES! Found " . count($steps) . " booking steps</p>";
    echo "<pre>";
    print_r($steps);
    echo "</pre>";
} else {
    echo "<p style='color: red;'>❌ GAGAL! No booking steps found</p>";
}

// Test 5: Get Home Gallery
echo "<h2>5. Test Home Gallery</h2>";
$gallery = getAllHomeGallery();
if ($gallery !== false) {
    echo "<p style='color: green;'>✅ SUKSES! Found " . count($gallery) . " gallery items</p>";
    if (count($gallery) > 0) {
        echo "<pre>";
        print_r($gallery);
        echo "</pre>";
    } else {
        echo "<p style='color: orange;'>⚠️ Gallery kosong (normal jika belum diisi)</p>";
    }
} else {
    echo "<p style='color: red;'>❌ GAGAL! Error getting gallery</p>";
}

// Test 6: Get Home Legality
echo "<h2>6. Test Home Legality</h2>";
$legality = getAllHomeLegality();
if ($legality) {
    echo "<p style='color: green;'>✅ SUKSES! Found " . count($legality) . " legality items</p>";
    echo "<pre>";
    print_r($legality);
    echo "</pre>";
} else {
    echo "<p style='color: red;'>❌ GAGAL! No legality items found</p>";
}

echo "<hr>";
echo "<h2>Database Connection Test</h2>";
if ($conn) {
    echo "<p style='color: green;'>✅ Database connection OK</p>";
    echo "<p>Database: cendana_travel</p>";
} else {
    echo "<p style='color: red;'>❌ Database connection FAILED</p>";
}

echo "<hr>";
echo "<p><a href='admin.php' style='background: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>← Kembali ke Admin Panel</a></p>";
?>
