<?php
/**
 * Debug test untuk CRUD Gallery
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "=== GALLERY CRUD TEST ===\n\n";

// 1. Check database connection
echo "1. Database Connection: ";
require_once 'config/database.php';
echo ($conn ? "✅ OK\n" : "❌ FAILED\n");

// 2. Check functions
echo "\n2. Functions Check:\n";
require_once 'includes/functions.php';
$functions = ['addGallery', 'updateGallery', 'deleteGallery', 'uploadImage'];
foreach ($functions as $func) {
    echo "   - $func: " . (function_exists($func) ? "✅" : "❌") . "\n";
}

// 3. Check table
echo "\n3. Database Table Check:\n";
$result = $conn->query('SHOW TABLES LIKE "gallery"');
echo "   - gallery table: " . ($result->num_rows > 0 ? "✅ EXISTS" : "❌ MISSING") . "\n";

// 4. Test addGallery function
echo "\n4. Test addGallery (without file upload):\n";
$testData = [
    'title' => 'Test Photo',
    'description' => 'Test Description',
    'category' => 'Destinasi',
    'is_featured' => 0,
    'is_active' => 1,
    'display_order' => 0
];
$result = addGallery($testData, 'test/test.jpg');
echo "   - Result: " . ($result ? "✅ SUCCESS\n" : "❌ FAILED\n");
if (!$result) {
    echo "   - DB Error: " . $conn->error . "\n";
}

// 5. Check upload folder
echo "\n5. Upload Folder Check:\n";
$uploadDir = 'uploads/gallery/';
echo "   - Exists: " . (is_dir($uploadDir) ? "✅" : "❌") . "\n";
echo "   - Writable: " . (is_writable($uploadDir) ? "✅" : "❌") . "\n";

// 6. Check form fields in admin.php
echo "\n6. Form Input Fields (from admin.php):\n";
$admin_content = file_get_contents('admin.php');
$has_title_field = strpos($admin_content, 'name="title"') !== false;
$has_image_field = strpos($admin_content, 'name="image"') !== false;
$has_category_field = strpos($admin_content, 'name="category"') !== false;
echo "   - Title field: " . ($has_title_field ? "✅" : "❌") . "\n";
echo "   - Image field: " . ($has_image_field ? "✅" : "❌") . "\n";
echo "   - Category field: " . ($has_category_field ? "✅" : "❌") . "\n";

echo "\n=== END TEST ===\n";
?>
