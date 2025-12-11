<?php
// Admin Dashboard - CV. Cendana Travel
// Username: admin, Password: admin123

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Disable caching untuk admin panel agar data selalu fresh dari database
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: 0");

require_once 'config/database.php';
require_once 'includes/functions.php';
require_once 'includes/home_functions.php';

startSecureSession();

// cek login admin
if (!isAdminLoggedIn()) {
    header('Location: index.php');
    exit();
}

// ============================================
// HANDLE GET REQUESTS (Delete operations via URL)
// ============================================
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
    $action = $_GET['action'];
    $module = $_GET['module'] ?? '';
    
    // Handle hapus background hero
    if ($action === 'delete_background' && $module === 'homepage') {
        $field = $_GET['field'] ?? '';
        
        // Debug log
        error_log("DELETE BACKGROUND - Attempting to delete: field=$field");
        
        if (empty($field)) {
            $_SESSION['admin_message'] = 'Field tidak valid!';
            $_SESSION['admin_message_type'] = 'error';
        } elseif (deleteHeroBackground($field)) {
            $_SESSION['admin_message'] = 'Background berhasil dihapus!';
            $_SESSION['admin_message_type'] = 'success';
            error_log("DELETE BACKGROUND - Success!");
        } else {
            $_SESSION['admin_message'] = 'Gagal menghapus background!';
            $_SESSION['admin_message_type'] = 'error';
            error_log("DELETE BACKGROUND - Failed!");
        }
        header('Location: admin.php#general');
        exit();
    }
}

// Handle CRUD operations dengan POST-REDIRECT-GET Pattern
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $module = $_POST['module'] ?? '';
    
    /* CRUD sederhana tanpa framework dengan PRG Pattern */
    
    // ============================================
    // HANDLE HOME CONTENT CRUD OPERATIONS
    // ============================================
    require_once __DIR__ . '/includes/home_content_functions.php';
    
    // WHY CHOOSE US
    if ($module === 'why_choose') {
        if ($action === 'create') {
            // Cek jumlah data terlebih dahulu
            $count_sql = "SELECT COUNT(*) as total FROM why_choose_us";
            $count_result = $conn->query($count_sql);
            $count_row = $count_result->fetch_assoc();
            
            if ($count_row['total'] >= 4) {
                $_SESSION['admin_message'] = 'Maksimal hanya 4 poin "Mengapa Memilih Kami" yang diperbolehkan!';
                $_SESSION['admin_message_type'] = 'error';
            } else {
                $icon_file = $_FILES['icon'] ?? null;
                $result = createWhyChooseUs($_POST, $icon_file);
                
                if ($result) {
                    $_SESSION['admin_message'] = 'Poin "Mengapa Memilih Kami" berhasil ditambahkan!';
                    $_SESSION['admin_message_type'] = 'success';
                } else {
                    $_SESSION['admin_message'] = 'Gagal menambahkan poin! Judul mungkin sudah ada atau terjadi kesalahan.';
                    $_SESSION['admin_message_type'] = 'error';
                }
            }
            header('Location: admin.php#konten-beranda');
            exit();
        }
        elseif ($action === 'update') {
            $icon_file = $_FILES['icon'] ?? null;
            if (updateWhyChooseUs($_POST['id'], $_POST, $icon_file)) {
                $_SESSION['admin_message'] = 'Poin berhasil diperbarui!';
                $_SESSION['admin_message_type'] = 'success';
            } else {
                $_SESSION['admin_message'] = 'Gagal memperbarui poin! Judul mungkin sudah digunakan oleh poin lain.';
                $_SESSION['admin_message_type'] = 'error';
            }
            header('Location: admin.php#konten-beranda');
            exit();
        }
        elseif ($action === 'delete') {
            if (deleteWhyChooseUs($_POST['id'])) {
                $_SESSION['admin_message'] = 'Poin berhasil dihapus!';
                $_SESSION['admin_message_type'] = 'success';
            } else {
                $_SESSION['admin_message'] = 'Gagal menghapus poin!';
                $_SESSION['admin_message_type'] = 'error';
            }
            header('Location: admin.php#konten-beranda');
            exit();
        }
    }
    
    // PAYMENT STEPS
    elseif ($module === 'payment_steps') {
        if ($action === 'create') {
            $icon_file = $_FILES['icon'] ?? null;
            if (createPaymentStep($_POST, $icon_file)) {
                $_SESSION['admin_message'] = 'Langkah pembayaran berhasil ditambahkan!';
                $_SESSION['admin_message_type'] = 'success';
            } else {
                $_SESSION['admin_message'] = 'Gagal menambahkan langkah!';
                $_SESSION['admin_message_type'] = 'error';
            }
            header('Location: admin.php#konten-beranda');
            exit();
        }
        elseif ($action === 'update') {
            $icon_file = $_FILES['icon'] ?? null;
            if (updatePaymentStep($_POST['id'], $_POST, $icon_file)) {
                $_SESSION['admin_message'] = 'Langkah berhasil diperbarui!';
                $_SESSION['admin_message_type'] = 'success';
            } else {
                $_SESSION['admin_message'] = 'Gagal memperbarui langkah!';
                $_SESSION['admin_message_type'] = 'error';
            }
            header('Location: admin.php#konten-beranda');
            exit();
        }
        elseif ($action === 'delete') {
            if (deletePaymentStep($_POST['id'])) {
                $_SESSION['admin_message'] = 'Langkah berhasil dihapus!';
                $_SESSION['admin_message_type'] = 'success';
            } else {
                $_SESSION['admin_message'] = 'Gagal menghapus langkah!';
                $_SESSION['admin_message_type'] = 'error';
            }
            header('Location: admin.php#konten-beranda');
            exit();
        }
    }
    
    // ORDER STEPS
    elseif ($module === 'order_steps') {
        if ($action === 'create') {
            $image_file = $_FILES['image'] ?? null;
            if (createOrderStep($_POST, $image_file)) {
                $_SESSION['admin_message'] = 'Langkah pemesanan berhasil ditambahkan!';
                $_SESSION['admin_message_type'] = 'success';
            } else {
                $_SESSION['admin_message'] = 'Gagal menambahkan langkah!';
                $_SESSION['admin_message_type'] = 'error';
            }
            header('Location: admin.php#konten-beranda');
            exit();
        }
        elseif ($action === 'update') {
            $image_file = $_FILES['image'] ?? null;
            if (updateOrderStep($_POST['id'], $_POST, $image_file)) {
                $_SESSION['admin_message'] = 'Langkah berhasil diperbarui!';
                $_SESSION['admin_message_type'] = 'success';
            } else {
                $_SESSION['admin_message'] = 'Gagal memperbarui langkah!';
                $_SESSION['admin_message_type'] = 'error';
            }
            header('Location: admin.php#konten-beranda');
            exit();
        }
        elseif ($action === 'delete') {
            if (deleteOrderStep($_POST['id'])) {
                $_SESSION['admin_message'] = 'Langkah berhasil dihapus!';
                $_SESSION['admin_message_type'] = 'success';
            } else {
                $_SESSION['admin_message'] = 'Gagal menghapus langkah!';
                $_SESSION['admin_message_type'] = 'error';
            }
            header('Location: admin.php#konten-beranda');
            exit();
        }
    }
    
    // SERVICE CARDS (Jelajahi Dunia Section)
    elseif ($module === 'service_cards') {
        if ($action === 'create') {
            $image_file = $_FILES['image'] ?? null;
            if (createServiceCard($_POST, $image_file)) {
                $_SESSION['admin_message'] = 'Kartu layanan berhasil ditambahkan!';
                $_SESSION['admin_message_type'] = 'success';
            } else {
                $_SESSION['admin_message'] = 'Gagal menambahkan kartu layanan!';
                $_SESSION['admin_message_type'] = 'error';
            }
            header('Location: admin.php#konten-beranda');
            exit();
        }
        elseif ($action === 'update') {
            $image_file = $_FILES['image'] ?? null;
            if (updateServiceCard($_POST['id'], $_POST, $image_file)) {
                $_SESSION['admin_message'] = 'Kartu layanan berhasil diperbarui!';
                $_SESSION['admin_message_type'] = 'success';
            } else {
                $_SESSION['admin_message'] = 'Gagal memperbarui kartu layanan!';
                $_SESSION['admin_message_type'] = 'error';
            }
            header('Location: admin.php#konten-beranda');
            exit();
        }
        elseif ($action === 'delete') {
            if (deleteServiceCard($_POST['id'])) {
                $_SESSION['admin_message'] = 'Kartu layanan berhasil dihapus!';
                $_SESSION['admin_message_type'] = 'success';
            } else {
                $_SESSION['admin_message'] = 'Gagal menghapus kartu layanan!';
                $_SESSION['admin_message_type'] = 'error';
            }
            header('Location: admin.php#konten-beranda');
            exit();
        }
    }
    
    // GALLERY HOME SELECTION
    elseif ($module === 'gallery_home') {
        if ($action === 'create') {
            $result = createGalleryHomeSelection($_POST);
            $_SESSION['admin_message'] = $result['message'];
            $_SESSION['admin_message_type'] = $result['success'] ? 'success' : 'error';
            header('Location: admin.php#konten-beranda');
            exit();
        }
        elseif ($action === 'update') {
            if (updateGalleryHomeSelection($_POST['id'], $_POST)) {
                $_SESSION['admin_message'] = 'Foto beranda berhasil diperbarui!';
                $_SESSION['admin_message_type'] = 'success';
            } else {
                $_SESSION['admin_message'] = 'Gagal memperbarui foto!';
                $_SESSION['admin_message_type'] = 'error';
            }
            header('Location: admin.php#konten-beranda');
            exit();
        }
        elseif ($action === 'delete') {
            if (deleteGalleryHomeSelection($_POST['id'])) {
                $_SESSION['admin_message'] = 'Foto berhasil dihapus dari beranda!';
                $_SESSION['admin_message_type'] = 'success';
            } else {
                $_SESSION['admin_message'] = 'Gagal menghapus foto!';
                $_SESSION['admin_message_type'] = 'error';
            }
            header('Location: admin.php#konten-beranda');
            exit();
        }
    }
    
    // LEGAL SECURITY
    elseif ($module === 'legal_security') {
        if ($action === 'create') {
            $icon_file = $_FILES['icon'] ?? null;
            if (createLegalSecurity($_POST, $icon_file)) {
                $_SESSION['admin_message'] = 'Poin legalitas & keamanan berhasil ditambahkan!';
                $_SESSION['admin_message_type'] = 'success';
            } else {
                $_SESSION['admin_message'] = 'Gagal menambahkan poin!';
                $_SESSION['admin_message_type'] = 'error';
            }
            header('Location: admin.php#konten-beranda');
            exit();
        }
        elseif ($action === 'update') {
            $icon_file = $_FILES['icon'] ?? null;
            if (updateLegalSecurity($_POST['id'], $_POST, $icon_file)) {
                $_SESSION['admin_message'] = 'Poin berhasil diperbarui!';
                $_SESSION['admin_message_type'] = 'success';
            } else {
                $_SESSION['admin_message'] = 'Gagal memperbarui poin!';
                $_SESSION['admin_message_type'] = 'error';
            }
            header('Location: admin.php#konten-beranda');
            exit();
        }
        elseif ($action === 'delete') {
            if (deleteLegalSecurity($_POST['id'])) {
                $_SESSION['admin_message'] = 'Poin berhasil dihapus!';
                $_SESSION['admin_message_type'] = 'success';
            } else {
                $_SESSION['admin_message'] = 'Gagal menghapus poin!';
                $_SESSION['admin_message_type'] = 'error';
            }
            header('Location: admin.php#konten-beranda');
            exit();
        }
    }
    
    // ============================================
    // HANDLE GENERAL INFO UPDATE
    // ============================================
    if ($action === 'update' && $module === 'general') {
        if (updateCompanyInfo($_POST)) {
            $_SESSION['admin_message'] = 'Informasi perusahaan berhasil diperbarui!';
            $_SESSION['admin_message_type'] = 'success';
        } else {
            $_SESSION['admin_message'] = 'Gagal memperbarui informasi perusahaan!';
            $_SESSION['admin_message_type'] = 'error';
        }
        header('Location: admin.php');
        exit();
    }
    
    // ============================================
    // HANDLE BANNER OPERATIONS
    // ============================================
    elseif ($module === 'banner') {
        if ($action === 'add') {
            $imagePath = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $imagePath = uploadImage($_FILES['image'], 'uploads/');
            }
            
            if (addBanner($_POST, $imagePath)) {
                $_SESSION['admin_message'] = 'Banner berhasil ditambahkan!';
                $_SESSION['admin_message_type'] = 'success';
            } else {
                $_SESSION['admin_message'] = 'Gagal menambahkan banner!';
                $_SESSION['admin_message_type'] = 'error';
            }
            header('Location: admin.php');
            exit();
        }
        elseif ($action === 'update') {
            $imagePath = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $imagePath = uploadImage($_FILES['image'], 'uploads/');
            }
            
            if (updateBanner($_POST['id'], $_POST, $imagePath)) {
                $_SESSION['admin_message'] = 'Banner berhasil diperbarui!';
                $_SESSION['admin_message_type'] = 'success';
            } else {
                $_SESSION['admin_message'] = 'Gagal memperbarui banner!';
                $_SESSION['admin_message_type'] = 'error';
            }
            header('Location: admin.php');
            exit();
        }
        elseif ($action === 'delete') {
            if (deleteBanner($_POST['id'])) {
                $_SESSION['admin_message'] = 'Banner berhasil dihapus!';
                $_SESSION['admin_message_type'] = 'success';
            } else {
                $_SESSION['admin_message'] = 'Gagal menghapus banner!';
                $_SESSION['admin_message_type'] = 'error';
            }
            header('Location: admin.php');
            exit();
        }
    }
    
    // ============================================
    // HANDLE GALLERY OPERATIONS
    // ============================================
    elseif ($module === 'gallery') {
        if ($action === 'add') {
            // Check if file is selected
            if (!isset($_FILES['image']) || $_FILES['image']['error'] === UPLOAD_ERR_NO_FILE) {
                $_SESSION['admin_message'] = 'Silakan pilih foto terlebih dahulu!';
                $_SESSION['admin_message_type'] = 'error';
            } elseif ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
                // Handle specific upload errors
                $errorMessages = [
                    UPLOAD_ERR_INI_SIZE => 'File terlalu besar (melebihi upload_max_filesize)',
                    UPLOAD_ERR_FORM_SIZE => 'File terlalu besar (melebihi MAX_FILE_SIZE)',
                    UPLOAD_ERR_PARTIAL => 'File hanya terupload sebagian',
                    UPLOAD_ERR_NO_TMP_DIR => 'Folder temporary tidak ditemukan',
                    UPLOAD_ERR_CANT_WRITE => 'Gagal menulis file ke disk',
                    UPLOAD_ERR_EXTENSION => 'Upload dihentikan oleh ekstensi PHP'
                ];
                $_SESSION['admin_message'] = $errorMessages[$_FILES['image']['error']] ?? 'Error upload file: ' . $_FILES['image']['error'];
                $_SESSION['admin_message_type'] = 'error';
            } else {
                $imagePath = uploadImage($_FILES['image'], 'uploads/gallery/');
                if ($imagePath) {
                    if (addGallery($_POST, $imagePath)) {
                        $_SESSION['admin_message'] = 'Foto galeri berhasil ditambahkan!';
                        $_SESSION['admin_message_type'] = 'success';
                    } else {
                        $_SESSION['admin_message'] = 'Gagal menyimpan foto ke database! Error: ' . $conn->error;
                        $_SESSION['admin_message_type'] = 'error';
                    }
                } else {
                    $_SESSION['admin_message'] = 'Gagal mengupload foto! Pastikan format JPG/PNG/GIF dan ukuran maksimal 5MB';
                    $_SESSION['admin_message_type'] = 'error';
                }
            }
            header('Location: admin.php');
            exit();
        }
        elseif ($action === 'update') {
            $imagePath = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $imagePath = uploadImage($_FILES['image'], 'uploads/gallery/');
            }
            
            if (updateGallery($_POST['id'], $_POST, $imagePath)) {
                $_SESSION['admin_message'] = 'Foto galeri berhasil diperbarui!';
                $_SESSION['admin_message_type'] = 'success';
            } else {
                $_SESSION['admin_message'] = 'Gagal memperbarui foto galeri!';
                $_SESSION['admin_message_type'] = 'error';
            }
            header('Location: admin.php');
            exit();
        }
        elseif ($action === 'delete') {
            if (deleteGallery($_POST['id'])) {
                $_SESSION['admin_message'] = 'Foto galeri berhasil dihapus!';
                $_SESSION['admin_message_type'] = 'success';
            } else {
                $_SESSION['admin_message'] = 'Gagal menghapus foto galeri!';
                $_SESSION['admin_message_type'] = 'error';
            }
            header('Location: admin.php');
            exit();
        }
    }
    
    // ============================================
    // HANDLE CONTACT INFO UPDATE
    // ============================================
    elseif ($action === 'update' && $module === 'contact') {
        if (updateContactInfo($_POST)) {
            $_SESSION['admin_message'] = 'Informasi kontak berhasil diperbarui!';
            $_SESSION['admin_message_type'] = 'success';
        } else {
            $_SESSION['admin_message'] = 'Gagal memperbarui informasi kontak!';
            $_SESSION['admin_message_type'] = 'error';
        }
        header('Location: admin.php#kontak');
        exit();
    }
    
    // ============================================
    // HANDLE WEBSITE SETTINGS UPDATE (Footer & Tentang Kami)
    // ============================================
    elseif ($action === 'update' && $module === 'settings') {
        // Update company_name, footer_description, footer_copyright
        $company_name = escapeString($conn, $_POST['company_name']);
        $footer_description = escapeString($conn, $_POST['footer_description']);
        $footer_copyright = escapeString($conn, $_POST['footer_copyright']);
        
        $sql = "UPDATE homepage_settings SET 
                company_name = '$company_name',
                footer_description = '$footer_description',
                footer_copyright = '$footer_copyright',
                updated_at = CURRENT_TIMESTAMP
                WHERE id = 1";
        
        if ($conn->query($sql)) {
            $_SESSION['admin_message'] = 'Pengaturan website berhasil diperbarui!';
            $_SESSION['admin_message_type'] = 'success';
        } else {
            $_SESSION['admin_message'] = 'Gagal memperbarui pengaturan website!';
            $_SESSION['admin_message_type'] = 'error';
        }
        header('Location: admin.php#pengaturan');
        exit();
    }
    
    // ============================================
    // HANDLE HOMEPAGE SETTINGS OPERATIONS
    // ============================================
    elseif ($action === 'update' && $module === 'homepage') {
        error_log("=== HOMEPAGE UPDATE HANDLER CALLED ===");
        error_log("POST data company_hours: " . ($_POST['company_hours'] ?? 'NOT SET'));
        error_log("POST data company_email: " . ($_POST['company_email'] ?? 'NOT SET'));
        
        $currentSettings = getHomepageSettings();
        
        // Merge with current settings - only update fields that are present in POST
        $updateData = $currentSettings; // Start with current data
        
        // Update only fields that exist in POST
        foreach ($_POST as $key => $value) {
            if ($key !== 'action' && $key !== 'module') {
                $updateData[$key] = $value;
            }
        }
        
        // Handle hero background upload if provided
        $backgroundFields = ['hero_background', 'pemesanan_hero_background', 'galeri_hero_background', 'faq_hero_background', 'kontak_hero_background'];
        
        foreach ($backgroundFields as $field) {
            if (isset($_FILES[$field]) && $_FILES[$field]['error'] === UPLOAD_ERR_OK) {
                $backgroundPath = uploadImage($_FILES[$field], 'uploads/');
                if ($backgroundPath) {
                    $updateData[$field] = $backgroundPath;
                }
            }
            // If file not uploaded, keep existing value (already in $updateData from merge)
        }
        
        if (updateHomepageSettings($updateData)) {
            $_SESSION['admin_message'] = 'Pengaturan beranda berhasil diperbarui!';
            $_SESSION['admin_message_type'] = 'success';
        } else {
            $_SESSION['admin_message'] = 'Gagal memperbarui pengaturan beranda!';
            $_SESSION['admin_message_type'] = 'error';
        }
        header('Location: admin.php#beranda');
        exit();
    }
    
    // ============================================
    // HANDLE FAQ OPERATIONS
    // ============================================
    elseif ($module === 'faq') {
        if ($action === 'add') {
            // Validate required fields
            if (empty($_POST['question']) || empty($_POST['answer'])) {
                $_SESSION['admin_message'] = 'Pertanyaan dan jawaban tidak boleh kosong!';
                $_SESSION['admin_message_type'] = 'error';
            } elseif (addFAQ($_POST)) {
                $_SESSION['admin_message'] = 'FAQ berhasil ditambahkan!';
                $_SESSION['admin_message_type'] = 'success';
            } else {
                $_SESSION['admin_message'] = 'Gagal menambahkan FAQ!';
                $_SESSION['admin_message_type'] = 'error';
            }
            header('Location: admin.php');
            exit();
        }
        elseif ($action === 'update') {
            if (updateFAQ($_POST['id'], $_POST)) {
                $_SESSION['admin_message'] = 'FAQ berhasil diperbarui!';
                $_SESSION['admin_message_type'] = 'success';
            } else {
                $_SESSION['admin_message'] = 'Gagal memperbarui FAQ!';
                $_SESSION['admin_message_type'] = 'error';
            }
            header('Location: admin.php');
            exit();
        }
        elseif ($action === 'delete') {
            if (deleteFAQ($_POST['id'])) {
                $_SESSION['admin_message'] = 'FAQ berhasil dihapus!';
                $_SESSION['admin_message_type'] = 'success';
            } else {
                $_SESSION['admin_message'] = 'Gagal menghapus FAQ!';
                $_SESSION['admin_message_type'] = 'error';
            }
            header('Location: admin.php');
            exit();
        }
    }
    // HANDLE TRANSPORT OPERATIONS
    // ============================================
    elseif ($module === 'transport') {
        if ($action === 'add') {
            // ✅ Upload file logo baru
            $logoPath = null;
            if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
                $logoPath = uploadImage($_FILES['logo'], 'uploads/' . $_POST['transport_type'] . '/');
            }
            
            if (addTransportService($_POST, $logoPath)) {
                $_SESSION['admin_message'] = 'Layanan transportasi berhasil ditambahkan!';
                $_SESSION['admin_message_type'] = 'success';
            } else {
                $_SESSION['admin_message'] = 'Gagal menambahkan layanan transportasi!';
                $_SESSION['admin_message_type'] = 'error';
            }
            header('Location: admin.php#transportasi');
            exit();
        }
        elseif ($action === 'update') {
            // ✅ Upload file logo baru (file lama otomatis terhapus)
            $logoPath = null;
            if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
                $logoPath = uploadImage($_FILES['logo'], 'uploads/' . $_POST['transport_type'] . '/');
            }
            
            if (updateTransportService($_POST['id'], $_POST, $logoPath)) {
                $_SESSION['admin_message'] = 'Layanan transportasi berhasil diperbarui!';
                $_SESSION['admin_message_type'] = 'success';
            } else {
                $_SESSION['admin_message'] = 'Gagal memperbarui layanan transportasi!';
                $_SESSION['admin_message_type'] = 'error';
            }
            header('Location: admin.php#transportasi');
            exit();
        }
        elseif ($action === 'delete') {
            if (deleteTransportService($_POST['id'])) {
                $_SESSION['admin_message'] = 'Layanan transportasi berhasil dihapus!';
                $_SESSION['admin_message_type'] = 'success';
            } else {
                $_SESSION['admin_message'] = 'Gagal menghapus layanan transportasi!';
                $_SESSION['admin_message_type'] = 'error';
            }
            header('Location: admin.php#transportasi');
            exit();
        }
    }

}

// Ambil data untuk dashboard
$stats = getDashboardStats();
$companyInfo = getCompanyInfo();
$contactInfo = getContactInfo();
$homepageSettings = getHomepageSettings();
$transportServices = getAllTransportServices();
$transportTypes = getAllTransportTypes();
$galleries = getAllGallery();
$faqs = getAllFAQ();

// ============================================
// 🔍 DEBUG: LOG DATA DARI DATABASE
// ============================================
error_log("=== ADMIN.PHP DEBUG ===");
error_log("Total transport services: " . count($transportServices));
foreach ($transportServices as $service) {
    if ($service['transport_type'] === 'pesawat') {
        error_log("Pesawat ID {$service['id']}: {$service['name']} (is_active: {$service['is_active']})");
    }
}
error_log("======================");

// Debug: Hitung data transport untuk verifikasi
$transportDebug = [
    'pesawat' => 0,
    'kapal' => 0,
    'bus' => 0,
    'total' => count($transportServices)
];
foreach ($transportServices as $service) {
    if ($service['is_active'] == 1) {
        $transportDebug[$service['transport_type']]++;
    }
}

// Force reload timestamp untuk prevent cache
$cacheKiller = time() . mt_rand(1000, 9999);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - CV. Cendana Travel [v<?= $cacheKiller ?>]</title>
    
    <!-- 🔥 FORCE NO CACHE META TAGS 🔥 -->
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    
    <!-- External Dependencies -->
    <!-- // UPDATED: Modern Typography dengan Plus Jakarta Sans untuk dark pastel theme -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css">
    <link rel="stylesheet" href="icons.css">
    <link rel="stylesheet" href="admin-enhancements.css">
    <script src="config.js"></script>
    
    <style>
        /* ============================================
         * CSS VARIABLES - DARK PASTEL PEACH + BROWN THEME (PERMANENT)
         * updated to match customer theme - No toggle mode
         * ============================================ */
        :root {
            /* Background colors - Dark Brown Charcoal (match customer brand) */
            --admin-bg-main: #1F1A17;
            --admin-bg-secondary: #2E221C;
            --admin-bg-dark: #241A16;
            --admin-bg-darker: #1A1210;
            
            /* Card colors - Dark Pastel Brown/Peach */
            --admin-card-primary: #2A1F1A;
            --admin-card-secondary: #3A2A24;
            --admin-card-accent: #332621;
            --admin-card-light: #3D2F28;
            --admin-card-warm: #362318;
            
            /* Accent colors - Pastel Peach & Brown (customer palette) */
            --admin-accent-peach: #E8B89A;
            --admin-accent-cream: #FBEFE6;
            --admin-accent-brown: #D6A889;
            --admin-accent-warm: #C79A7A;
            --admin-accent-orange: #E8A87A;
            --admin-accent-whatsapp: #25D366;
            
            /* Text colors - Clean & Professional */
            --admin-text-primary: #FFFFFF;
            --admin-text-secondary: #E8D8C8;
            --admin-text-muted: #B8A898;
            --admin-text-cream: #FBEFE6;
            
            /* Primary colors (peach-based) */
            --admin-primary: #E8B89A;
            --admin-secondary: #D6A889;
            --admin-success: #25D366;
            --admin-warning: #E8A87A;
            --admin-danger: #E89A8A;
            --admin-info: #A8C8E8;
            
            /* Border and shadows - Soft Peach Glow */
            --admin-border: rgba(232, 184, 154, 0.12);
            --admin-border-light: rgba(232, 184, 154, 0.06);
            --admin-shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.5);
            --admin-shadow-md: 0 4px 16px rgba(0, 0, 0, 0.6);
            --admin-shadow-lg: 0 8px 32px rgba(0, 0, 0, 0.7);
            --admin-shadow-glow: 0 0 20px rgba(232, 184, 154, 0.15);
            --admin-shadow-peach: 0 4px 20px rgba(232, 184, 154, 0.2);
            
            /* Gradients - Peach & Brown */
            --admin-gradient-primary: linear-gradient(135deg, #E8B89A 0%, #D6A889 100%);
            --admin-gradient-warm: linear-gradient(135deg, #E8A87A 0%, #C79A7A 100%);
            --admin-gradient-peach: linear-gradient(135deg, #E8B89A 0%, #E8A87A 100%);
        }

        /* updated to match customer theme - Permanent dark pastel */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--admin-bg-main);
            color: var(--admin-text-primary);
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* // UPDATED: Header dengan dark pastel modern styling */
        .admin-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 70px;
            background: var(--admin-bg-secondary);
            backdrop-filter: blur(10px);
            box-shadow: var(--admin-shadow-md);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            border-bottom: 1px solid var(--admin-border);
        }

        /* updated to match customer theme - Peach accent */
        .admin-logo {
            color: var(--admin-text-primary);
            font-weight: 700;
            font-size: 1.3rem;
            display: flex;
            align-items: center;
            gap: 12px;
            letter-spacing: -0.02em;
        }

        .admin-logo i {
            font-size: 1.6rem;
            color: var(--admin-accent-peach);
            filter: drop-shadow(0 2px 8px rgba(232, 184, 154, 0.4));
        }

        /* // UPDATED: User section dengan avatar dan modern styling */
        .admin-user {
            color: var(--admin-text-primary);
            display: flex;
            align-items: center;
            gap: 16px;
        }
        
        /* // NEW: Avatar user untuk topbar modern */
        .admin-user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: var(--admin-gradient-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1rem;
            color: white;
            box-shadow: var(--admin-shadow-sm);
        }

        .admin-user span {
            font-size: 0.95rem;
            font-weight: 500;
            padding: 8px 16px;
            background: var(--admin-card-blue);
            border-radius: 16px;
            backdrop-filter: blur(10px);
            border: 1px solid var(--admin-border);
        }

        /* updated to match customer theme - Peach accent */
        .logout-btn {
            background: var(--admin-card-primary);
            color: var(--admin-accent-peach);
            border: 1px solid var(--admin-border);
            padding: 10px 18px;
            border-radius: 16px;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .logout-btn:hover {
            background: var(--admin-accent-peach);
            color: var(--admin-bg-dark);
            transform: translateY(-2px);
            box-shadow: var(--admin-shadow-peach);
            border-color: var(--admin-accent-peach);
        }

        /* // UPDATED: Sidebar dengan dark pastel modern design */
        .sidebar {
            position: fixed;
            top: 70px;
            left: 0;
            width: 280px;
            height: calc(100vh - 70px);
            background: var(--admin-bg-secondary);
            border-right: 1px solid var(--admin-border);
            overflow-y: auto;
            z-index: 999;
            box-shadow: var(--admin-shadow-md);
            display: flex;
            flex-direction: column;
        }

        .sidebar-nav {
            padding: 24px 0;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        /* // UPDATED: Nav-link dengan pastel glow effect dan modern styling */
        .nav-link {
            display: flex;
            align-items: center;
            padding: 14px 18px;
            margin: 6px 12px;
            color: var(--admin-text-secondary);
            text-decoration: none;
            border-radius: 16px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-weight: 500;
            font-size: 0.95rem;
            position: relative;
            border: 1px solid transparent;
        }

        .nav-link i {
            width: 22px;
            margin-right: 14px;
            text-align: center;
            opacity: 0.7;
            font-size: 1.15rem;
            transition: all 0.3s ease;
        }

        /* updated to match customer theme - Peach hover */
        .nav-link:hover {
            background: var(--admin-card-primary);
            color: var(--admin-text-primary);
            transform: translateX(6px);
            box-shadow: 0 0 20px rgba(232, 184, 154, 0.15);
            border-color: var(--admin-border);
        }

        .nav-link:hover i {
            transform: scale(1.15);
            opacity: 1;
            color: var(--admin-accent-peach);
        }

        /* updated to match customer theme - Peach glow */
        .nav-link.active {
            background: var(--admin-card-secondary);
            color: var(--admin-accent-peach);
            box-shadow: 0 0 24px rgba(232, 184, 154, 0.25), inset 0 0 20px rgba(232, 184, 154, 0.1);
            border-color: rgba(232, 184, 154, 0.3);
            font-weight: 600;
            transform: translateX(6px);
        }
        
        .nav-link.active i {
            opacity: 1;
            color: var(--admin-accent-peach);
            filter: drop-shadow(0 0 8px rgba(232, 184, 154, 0.5));
        }

        /* updated to match customer theme - Peach indicator */
        .nav-link.active::before {
            content: '';
            position: absolute;
            left: -12px;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 28px;
            background: var(--admin-accent-peach);
            border-radius: 0 8px 8px 0;
            box-shadow: 0 0 16px rgba(232, 184, 154, 0.6);
        }

        /* // UPDATED: Main Content dengan dark pastel background */
        .admin-content {
            margin-left: 280px;
            margin-top: 70px;
            padding: 40px 36px;
            min-height: calc(100vh - 70px);
            background: var(--admin-bg-main);
            position: relative;
            overflow: auto;
        }

        .content-section {
            display: none;
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .content-section.active {
            display: block;
            opacity: 1;
            transform: translateY(0);
            animation: fadeInUp 0.4s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* // UPDATED: Page Headers dengan modern typography */
        .content-section h1 {
            font-size: 2.2rem;
            font-weight: 800;
            color: var(--admin-text-primary);
            margin-bottom: 12px;
            letter-spacing: -0.03em;
            line-height: 1.2;
        }

        .content-section > p {
            color: var(--admin-text-secondary);
            margin-bottom: 32px;
            font-size: 1.05rem;
            line-height: 1.6;
            max-width: 650px;
        }

        /* // UPDATED: Stats Grid dengan pastel dark cards */
        /* // NEW: Stats grid layout untuk dashboard cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 24px;
            margin-bottom: 32px;
        }
        
        .stat-card {
            background: var(--admin-card-purple);
            padding: 28px 24px;
            border-radius: 24px;
            box-shadow: var(--admin-shadow-md);
            border: 1px solid var(--admin-border);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        
        /* updated to match customer theme - Brown/Peach cards */
        .stat-card:nth-child(1) {
            background: var(--admin-card-primary);
        }
        
        .stat-card:nth-child(2) {
            background: var(--admin-card-secondary);
        }
        
        .stat-card:nth-child(3) {
            background: var(--admin-card-accent);
        }
        
        .stat-card:nth-child(4) {
            background: var(--admin-card-warm);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--admin-gradient-primary);
            opacity: 0.7;
        }

        .stat-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 40px rgba(232, 184, 154, 0.25);
            border-color: var(--admin-accent-peach);
        }

        /* updated to match customer theme - Peach accents */
        .stat-card h3 {
            color: var(--admin-text-muted);
            font-size: 0.8rem;
            font-weight: 700;
            margin-bottom: 16px;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .stat-card h3 i {
            font-size: 1.1rem;
            color: var(--admin-accent-peach);
            opacity: 0.8;
        }

        .stat-card .number {
            font-size: 2.6rem;
            font-weight: 800;
            margin-bottom: 8px;
            letter-spacing: -0.03em;
            color: var(--admin-text-primary);
        }
        
        /* updated to match customer theme - Peach gradients */
        .stat-card:nth-child(1) .number {
            background: linear-gradient(135deg, var(--admin-accent-peach), var(--admin-accent-brown));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .stat-card:nth-child(2) .number {
            background: linear-gradient(135deg, var(--admin-accent-orange), var(--admin-accent-warm));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .stat-card:nth-child(3) .number {
            background: linear-gradient(135deg, var(--admin-accent-brown), var(--admin-accent-peach));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .stat-card:nth-child(4) .number {
            background: linear-gradient(135deg, var(--admin-accent-warm), var(--admin-accent-orange));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .stat-card small {
            color: var(--admin-text-secondary);
            font-size: 0.85rem;
            font-weight: 500;
        }

        /* // UPDATED: Section Cards dengan pastel dark theme */
        .section-card {
            background: var(--admin-bg-secondary);
            border-radius: 24px;
            box-shadow: var(--admin-shadow-md);
            margin-bottom: 32px;
            overflow: hidden;
            border: 1px solid var(--admin-border);
            transition: all 0.3s ease;
        }

        .section-card:hover {
            box-shadow: 0 12px 40px rgba(232, 184, 154, 0.18);
            border-color: var(--admin-border);
        }

        /* // UPDATED: Section header dengan pastel accent */
        .section-header {
            padding: 24px 32px;
            border-bottom: 1px solid var(--admin-border);
            background: var(--admin-bg-dark);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
        }

        .section-header::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--admin-gradient-primary);
            opacity: 0.6;
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .section-card:hover .section-header::before {
            transform: scaleX(1);
        }

        .section-header h2 {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--admin-text-primary);
            letter-spacing: -0.02em;
        }

        .section-content {
            padding: 32px 36px;
            color: var(--admin-text-primary);
        }

        /* // UPDATED: Form Styles dengan dark pastel theme */
        .form-group {
            margin-bottom: 24px;
            position: relative;
        }

        /* Form layout horizontal - label dan input sejajar dalam 2 kolom */
        .form-group-horizontal {
            display: flex;
            flex-direction: column;
            margin-bottom: 24px;
        }

        .form-group-horizontal label {
            font-weight: 600;
            color: var(--admin-text-primary);
            font-size: 0.9rem;
            letter-spacing: -0.01em;
            margin-bottom: 10px;
            min-width: 180px;
            text-align: left;
        }

        .form-group-horizontal .form-input-wrapper {
            display: flex;
            flex-direction: column;
        }

        .form-group-horizontal input,
        .form-group-horizontal textarea,
        .form-group-horizontal select {
            width: 100%;
            padding: 14px 18px;
            border: 1px solid var(--admin-border);
            border-radius: 16px;
            font-size: 0.95rem;
            background: var(--admin-bg-dark);
            color: var(--admin-text-primary);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-family: inherit;
        }

        .form-group-horizontal input::placeholder,
        .form-group-horizontal textarea::placeholder {
            color: var(--admin-text-muted);
        }

        .form-group-horizontal input:focus,
        .form-group-horizontal textarea:focus,
        .form-group-horizontal select:focus {
            outline: none;
            border-color: var(--admin-accent-peach);
            box-shadow: 0 0 0 3px rgba(232, 184, 154, 0.15);
            background: var(--admin-bg-darker);
        }

        .form-group-horizontal textarea {
            min-height: 100px;
            resize: vertical;
            line-height: 1.6;
        }

        .form-group-horizontal small {
            color: var(--admin-text-muted);
            font-size: 0.85rem;
            line-height: 1.4;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: var(--admin-text-primary);
            font-size: 0.9rem;
            letter-spacing: -0.01em;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 14px 18px;
            border: 1px solid var(--admin-border);
            border-radius: 16px;
            font-size: 0.95rem;
            background: var(--admin-bg-dark);
            color: var(--admin-text-primary);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-family: inherit;
        }

        .form-group input::placeholder,
        .form-group textarea::placeholder,
        .form-group select::placeholder {
            color: var(--admin-text-muted);
        }

        /* updated to match customer theme */
        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: var(--admin-accent-peach);
            box-shadow: 0 0 0 3px rgba(232, 184, 154, 0.15);
            background: var(--admin-bg-darker);
        }
        
        .form-group input[type="file"] {
            padding: 12px 16px;
            border: 2px dashed var(--admin-border);
            background: var(--admin-bg-dark);
            color: var(--admin-text-secondary);
        }

        .form-group textarea {
            min-height: 120px;
            resize: vertical;
            line-height: 1.6;
        }

        .form-group input[type="checkbox"] {
            width: auto;
            margin-right: 12px;
            transform: scale(1.2);
            accent-color: var(--admin-accent-peach);
        }

        .form-group small {
            color: var(--admin-text-muted);
            font-size: 0.85rem;
            display: block;
            margin-top: 6px;
            line-height: 1.4;
        }

        /* Search Box Styling */
        .search-box {
            position: relative;
        }
        
        .search-box input[type="text"] {
            transition: all 0.3s ease;
        }
        
        .search-box input[type="text"]:focus {
            outline: none;
            border-color: var(--admin-accent-peach);
            box-shadow: 0 0 0 3px rgba(232, 184, 154, 0.15);
        }
        
        .search-box input[type="text"]::placeholder {
            color: var(--admin-text-muted);
            opacity: 0.6;
        }
        
        .no-search-result {
            animation: fadeIn 0.3s ease;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* // UPDATED: Button Styles dengan pastel gradients */
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 0.9rem;
            font-family: inherit;
            letter-spacing: -0.01em;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.3s, height 0.3s;
        }

        .btn:hover::before {
            width: 300px;
            height: 300px;
        }

        /* updated to match customer theme */
        .btn-primary {
            background: var(--admin-gradient-primary);
            color: var(--admin-bg-dark);
            box-shadow: var(--admin-shadow-sm);
            font-weight: 700;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--admin-shadow-peach);
        }

        .btn-secondary {
            background: var(--admin-card-primary);
            color: var(--admin-text-primary);
            box-shadow: var(--admin-shadow-sm);
            border: 1px solid var(--admin-border);
        }

        .btn-secondary:hover {
            background: var(--admin-card-secondary);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(232, 184, 154, 0.2);
        }

        /* updated to match customer theme - WhatsApp green */
        .btn-success {
            background: linear-gradient(135deg, var(--admin-accent-whatsapp) 0%, #20B858 100%);
            color: white;
            box-shadow: var(--admin-shadow-sm);
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(37, 211, 102, 0.3);
        }

        .btn-danger {
            background: linear-gradient(135deg, var(--admin-danger) 0%, #D88A7A 100%);
            color: white;
            box-shadow: var(--admin-shadow-sm);
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(232, 154, 138, 0.3);
        }

        /* // UPDATED: Table Styles dengan dark pastel theme */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: var(--admin-bg-dark);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--admin-shadow-md);
            border: 1px solid var(--admin-border);
        }

        .table th,
        .table td {
            padding: 16px 20px;
            text-align: left;
            border-bottom: 1px solid var(--admin-border);
        }

        /* updated to match customer theme */
        .table th {
            font-weight: 700;
            color: var(--admin-text-primary);
            background: var(--admin-card-primary);
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            position: relative;
        }

        .table th::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--admin-gradient-primary);
            opacity: 0.6;
        }

        .table tbody tr {
            transition: all 0.3s ease;
        }

        .table tbody tr:hover {
            background: var(--admin-card-primary);
        }

        .table tbody tr:nth-child(even) {
            background: rgba(255, 255, 255, 0.02);
        }

        .table td {
            color: var(--admin-text-secondary);
        }

        /* // UPDATED: Badge Styles dengan pastel colors */
        .badge {
            padding: 6px 14px;
            border-radius: 16px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            box-shadow: var(--admin-shadow-sm);
            border: 1px solid transparent;
            transition: all 0.3s ease;
        }

        .badge:hover {
            transform: scale(1.05);
        }

        /* updated to match customer theme */
        .badge-success { 
            background: rgba(37, 211, 102, 0.15);
            color: var(--admin-accent-whatsapp);
            border-color: var(--admin-accent-whatsapp);
        }
        
        .badge-warning { 
            background: var(--admin-card-warm);
            color: var(--admin-accent-orange);
            border-color: var(--admin-accent-orange);
        }
        
        .badge-danger { 
            background: var(--admin-card-accent);
            color: var(--admin-danger);
            border-color: var(--admin-danger);
        }
        
        .badge-info { 
            background: var(--admin-card-secondary);
            color: var(--admin-accent-peach);
            border-color: var(--admin-accent-peach);
        }

        /* // UPDATED: Gallery Grid dengan pastel dark cards */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 24px;
            margin-top: 24px;
        }

        .gallery-item {
            background: var(--admin-bg-secondary);
            border-radius: 24px;
            overflow: hidden;
            box-shadow: var(--admin-shadow-md);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid var(--admin-border);
            position: relative;
            display: flex;
            flex-direction: column;
        }

        .gallery-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--admin-gradient-primary);
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 1;
        }

        .gallery-item:hover {
            transform: translateY(-6px);
            box-shadow: var(--admin-shadow-peach);
            border-color: var(--admin-accent-peach);
        }

        .gallery-item:hover::before {
            opacity: 1;
        }

        .gallery-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .gallery-item:hover img {
            transform: scale(1.05);
        }

        .gallery-info {
            padding: 20px;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .gallery-info h4 {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--admin-text-primary);
            margin-bottom: 12px;
            letter-spacing: -0.01em;
            min-height: 2.5rem;
            display: flex;
            align-items: center;
        }

        .gallery-info p {
            font-size: 0.9rem;
            color: var(--admin-text-secondary);
            margin-bottom: 16px;
            line-height: 1.5;
            flex-grow: 1;
            min-height: 3rem;
        }

        .gallery-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 12px;
            border-top: 1px solid var(--admin-border);
            margin-top: auto;
        }
        
        .gallery-actions > div:first-child {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }
        
        .gallery-actions > div:last-child {
            display: flex;
            align-items: center;
            gap: 5px;
            flex-shrink: 0;
        }

        /* // UPDATED: FAQ Styles dengan pastel dark theme */
        .faq-item {
            background: var(--admin-bg-secondary);
            border-radius: 20px;
            margin-bottom: 20px;
            box-shadow: var(--admin-shadow-md);
            overflow: hidden;
            border: 1px solid var(--admin-border);
            transition: all 0.3s ease;
        }

        .faq-item:hover {
            box-shadow: var(--admin-shadow-peach);
            border-color: var(--admin-accent-peach);
            transform: translateY(-2px);
        }

        /* updated to match customer theme */
        .faq-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--admin-border);
            background: var(--admin-card-secondary);
            position: relative;
        }

        .faq-header::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--admin-gradient-primary);
            opacity: 0.6;
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .faq-item:hover .faq-header::before {
            transform: scaleX(1);
        }

        .faq-question {
            font-weight: 700;
            color: var(--admin-accent-peach);
            margin-bottom: 12px;
            font-size: 1.05rem;
            letter-spacing: -0.01em;
        }

        .faq-content {
            padding: 20px 24px;
            color: var(--admin-text-secondary);
        }

        .faq-actions {
            display: flex;
            gap: 10px;
            float: right;
        }

        /* Mobile Menu Toggle - Dark Glass */
        .mobile-menu-toggle {
            display: none;
            position: fixed;
            top: 80px;
            left: 20px;
            z-index: 1001;
            background: var(--admin-gradient-primary);
            color: white;
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 15px;
            cursor: pointer;
            font-size: 18px;
            box-shadow: 0 8px 30px rgba(74, 132, 255, 0.3);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(10px);
        }

        .mobile-menu-toggle:hover {
            transform: scale(1.1);
            box-shadow: 0 12px 40px rgba(74, 132, 255, 0.4);
        }

        .mobile-menu-toggle:active {
            transform: scale(0.95);
        }

        /* Dark Mode Comprehensive Styling *//* Dark mode for transport components *//* Responsive Design - Lebih Komprehensif */
        @media (max-width: 1200px) {
            .admin-content {
                margin-left: 280px;
                padding: 32px 24px;
            }

            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
                gap: 20px;
            }
        }

        @media (max-width: 768px) {
            /* Form 2 column responsive - jadi 1 kolom di mobile */
            .section-content form > div[style*="grid-template-columns"] {
                grid-template-columns: 1fr !important;
            }

            .mobile-menu-toggle {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                box-shadow: none;
            }

            .sidebar.active {
                transform: translateX(0);
                box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);
            }

            .admin-content {
                margin-left: 0;
                padding: 24px 20px;
                margin-top: 70px;
            }

            .admin-header {
                padding: 0 1rem;
            }

            .admin-logo {
                font-size: 1.1rem;
            }

            .admin-user span {
                padding: 6px 12px;
                font-size: 0.85rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .stat-card {
                padding: 24px 20px;
            }

            .section-header {
                padding: 20px 24px;
            }

            .section-content {
                padding: 24px;
            }

            .gallery-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .table {
                font-size: 0.85rem;
            }

            .table th,
            .table td {
                padding: 10px 12px;
            }

            .btn {
                padding: 12px 20px;
                font-size: 0.85rem;
            }

            .content-section h1 {
                font-size: 1.8rem;
            }
        }

        @media (max-width: 480px) {
            .admin-header {
                padding: 0 0.75rem;
            }

            .admin-logo {
                font-size: 1rem;
            }

            .admin-user span {
                display: none;
            }

            /* removed: dark-mode-toggle mobile styles */

            .logout-btn {
                padding: 8px 12px;
                font-size: 0.8rem;
            }

            .admin-content {
                padding: 16px;
            }

            .section-content {
                padding: 20px 16px;
            }

            .section-header {
                padding: 16px 20px;
            }

            .section-header h2 {
                font-size: 1.1rem;
            }

            .btn {
                padding: 10px 16px;
                font-size: 0.8rem;
            }

            .form-group input,
            .form-group textarea,
            .form-group select {
                padding: 12px 14px;
            }

            .content-section h1 {
                font-size: 1.6rem;
            }

            .content-section > p {
                font-size: 1rem;
            }
        }

        /* removed: dark mode toggle - permanent dark theme */

        /* ============================================
         * TRANSPORT MANAGEMENT STYLING - PASTEL THEME
         * ============================================ */
        /* // UPDATED: Transport tabs dengan pastel styling */
        .transport-tabs {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 24px;
            border-bottom: 2px solid var(--admin-border);
            padding-bottom: 16px;
            justify-content: flex-start;
        }

        .tab-btn {
            min-width: 260px;
            height: 50px;
            padding: 12px 24px;
            background: var(--admin-bg-secondary);
            border: 1px solid var(--admin-border);
            border-radius: 16px;
            color: var(--admin-text-secondary);
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-size: 0.95rem;
            white-space: nowrap;
        }

        .tab-btn i {
            font-size: 1.1rem;
            opacity: 0.7;
            transition: all 0.3s ease;
        }

        .tab-btn:hover i,
        .tab-btn.active i {
            opacity: 1;
            transform: scale(1.15);
        }

        /* updated to match customer theme */
        .tab-btn:hover {
            background: var(--admin-card-primary);
            border-color: var(--admin-accent-peach);
            color: var(--admin-text-primary);
            transform: translateY(-2px);
        }

        .tab-btn.active {
            background: var(--admin-card-secondary);
            color: var(--admin-accent-peach);
            border-color: var(--admin-accent-peach);
            box-shadow: var(--admin-shadow-peach);
        }

        /* Home content tab buttons with fixed dimensions */
        .home-tab-btn {
            min-width: 240px;
            height: 50px;
            padding: 12px 24px;
            background: var(--admin-bg-secondary);
            border: 1px solid var(--admin-border);
            border-radius: 16px;
            color: var(--admin-text-secondary);
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-size: 0.95rem;
            white-space: nowrap;
        }

        .home-tab-btn i {
            font-size: 1.1rem;
            opacity: 0.7;
            transition: all 0.3s ease;
        }

        .home-tab-btn:hover i,
        .home-tab-btn.active i {
            opacity: 1;
            transform: scale(1.15);
        }

        .home-tab-btn:hover {
            background: var(--admin-card-primary);
            border-color: var(--admin-accent-peach);
            color: var(--admin-text-primary);
            transform: translateY(-2px);
        }

        .home-tab-btn.active {
            background: var(--admin-card-secondary);
            color: var(--admin-accent-peach);
            border-color: var(--admin-accent-peach);
            box-shadow: var(--admin-shadow-peach);
        }

        /* Home content tab containers */
        .home-content-tab {
            display: none;
        }

        .home-content-tab.active {
            display: block;
        }

        .transport-tab-content {
            display: none;
        }

        .transport-tab-content.active {
            display: block;
        }

        .transport-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        /* // UPDATED: Transport card dengan pastel theme */
        .transport-card {
            background: var(--admin-bg-secondary);
            border: 1px solid var(--admin-border);
            border-radius: 20px;
            padding: 20px;
            transition: all 0.3s ease;
            position: relative;
        }

        .transport-card:hover {
            border-color: var(--admin-accent-peach);
            transform: translateY(-4px);
            box-shadow: var(--admin-shadow-peach);
        }

        .transport-card-header {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 16px;
        }

        /* updated to match customer theme */
        .transport-logo {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            object-fit: contain;
            background: var(--admin-card-primary);
            padding: 8px;
        }

        .transport-info h3 {
            margin: 0 0 4px 0;
            color: var(--admin-text-primary);
            font-size: 1.15rem;
            font-weight: 700;
        }

        .transport-info p {
            margin: 0;
            color: var(--admin-text-secondary);
            font-size: 0.9rem;
            line-height: 1.4;
        }

        .transport-price {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--admin-accent-peach);
            margin: 12px 0 16px 0;
        }

        .transport-actions {
            display: flex;
            gap: 8px;
            justify-content: flex-start;
        }

        .transport-actions .btn {
            padding: 8px 16px;
            font-size: 0.85rem;
        }

        /* // UPDATED: Modal Styling dengan pastel theme */
        .modal,
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.85);
            backdrop-filter: blur(8px);
            z-index: 9999;
            /* Grid layout for foolproof centering that handles overflow */
            display: grid;
            place-items: center; /* Center horizontally/vertically */
            overflow-y: auto; /* Allow scrolling the overlay */
            padding: 20px;
            box-sizing: border-box; /* Include padding in dimensions */
        }
        
        /* Custom Notification Modal */
        .notification-modal {
            background: var(--admin-bg-primary);
            border-radius: 16px;
            padding: 0;
            max-width: 450px;
            width: 90%;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            animation: notifSlideIn 0.3s ease-out;
            border: 2px solid var(--admin-border);
        }
        
        @keyframes notifSlideIn {
            from {
                opacity: 0;
                transform: translateY(-30px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
        
        .notification-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--admin-border);
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .notification-header.success {
            background: linear-gradient(135deg, rgba(46, 213, 115, 0.15), rgba(72, 219, 251, 0.15));
            border-bottom-color: rgba(46, 213, 115, 0.3);
        }
        
        .notification-header.error {
            background: linear-gradient(135deg, rgba(255, 71, 87, 0.15), rgba(255, 107, 107, 0.15));
            border-bottom-color: rgba(255, 71, 87, 0.3);
        }
        
        .notification-header.warning {
            background: linear-gradient(135deg, rgba(255, 168, 1, 0.15), rgba(252, 196, 25, 0.15));
            border-bottom-color: rgba(255, 168, 1, 0.3);
        }
        
        .notification-header.info {
            background: linear-gradient(135deg, rgba(72, 219, 251, 0.15), rgba(118, 75, 162, 0.15));
            border-bottom-color: rgba(72, 219, 251, 0.3);
        }
        
        .notification-icon {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
        }
        
        .notification-icon.success {
            background: #2ed573;
            color: white;
        }
        
        .notification-icon.error {
            background: #ff4757;
            color: white;
        }
        
        .notification-icon.warning {
            background: #ffa801;
            color: white;
        }
        
        .notification-icon.info {
            background: #48dbfb;
            color: white;
        }
        
        .notification-body {
            padding: 1.5rem;
        }
        
        .notification-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--admin-text-primary);
            margin: 0 0 0.5rem 0;
        }
        
        .notification-message {
            color: var(--admin-text-secondary);
            line-height: 1.6;
            margin: 0;
        }
        
        .notification-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid var(--admin-border);
            display: flex;
            gap: 0.75rem;
            justify-content: flex-end;
        }
        
        /* Blur effect untuk background saat modal terbuka */
        .modal-blur {
            filter: blur(5px);
            transition: filter 0.3s ease;
            pointer-events: none;
        }
        
        /* Toast Notification Style */
        .toast-notification {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 99999;
            min-width: 320px;
            max-width: 400px;
            background: var(--admin-bg-primary);
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
            border: 2px solid var(--admin-border);
            animation: toastSlideIn 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            overflow: hidden;
        }
        
        @keyframes toastSlideIn {
            from {
                opacity: 0;
                transform: translateX(400px) scale(0.8);
            }
            to {
                opacity: 1;
                transform: translateX(0) scale(1);
            }
        }
        
        @keyframes toastSlideOut {
            from {
                opacity: 1;
                transform: translateX(0) scale(1);
            }
            to {
                opacity: 0;
                transform: translateX(400px) scale(0.8);
            }
        }
        
        .toast-notification.hiding {
            animation: toastSlideOut 0.3s ease-in forwards;
        }
        
        .toast-header {
            padding: 1rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.85rem;
            border-bottom: 1px solid var(--admin-border);
        }
        
        .toast-header.success {
            background: linear-gradient(135deg, rgba(46, 213, 115, 0.15), rgba(72, 219, 251, 0.15));
            border-bottom-color: rgba(46, 213, 115, 0.3);
        }
        
        .toast-header.error {
            background: linear-gradient(135deg, rgba(255, 71, 87, 0.15), rgba(255, 107, 107, 0.15));
            border-bottom-color: rgba(255, 71, 87, 0.3);
        }
        
        .toast-header.warning {
            background: linear-gradient(135deg, rgba(255, 168, 1, 0.15), rgba(252, 196, 25, 0.15));
            border-bottom-color: rgba(255, 168, 1, 0.3);
        }
        
        .toast-header.info {
            background: linear-gradient(135deg, rgba(72, 219, 251, 0.15), rgba(118, 75, 162, 0.15));
            border-bottom-color: rgba(72, 219, 251, 0.3);
        }
        
        .toast-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.15rem;
            flex-shrink: 0;
        }
        
        .toast-icon.success {
            background: #2ed573;
            color: white;
        }
        
        .toast-icon.error {
            background: #ff4757;
            color: white;
        }
        
        .toast-icon.warning {
            background: #ffa801;
            color: white;
        }
        
        .toast-icon.info {
            background: #48dbfb;
            color: white;
        }
        
        .toast-title {
            flex: 1;
            font-size: 1rem;
            font-weight: 600;
            color: var(--admin-text-primary);
            margin: 0;
        }
        
        .toast-close {
            background: transparent;
            border: none;
            color: var(--admin-text-muted);
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0;
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            transition: all 0.2s;
        }
        
        .toast-close:hover {
            background: var(--admin-bg-secondary);
            color: var(--admin-text-primary);
        }
        
        .toast-body {
            padding: 1rem 1.25rem;
        }
        
        .toast-message {
            color: var(--admin-text-secondary);
            line-height: 1.5;
            margin: 0;
            font-size: 0.9rem;
        }
        
        .toast-progress {
            height: 4px;
            background: var(--admin-bg-secondary);
            overflow: hidden;
        }
        
        .toast-progress-bar {
            height: 100%;
            background: linear-gradient(90deg, var(--admin-accent-peach), var(--admin-accent-brown));
            animation: toastProgress 5s linear forwards;
        }
        
        @keyframes toastProgress {
            from {
                width: 100%;
            }
            to {
                width: 0%;
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .modal-content {
            background: var(--admin-bg-secondary);
            border-radius: 24px;
            width: 100%;
            max-width: 550px;
            max-height: 85vh;
            overflow-y: auto;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7);
            border: 2px solid var(--admin-border);
            position: relative;
            margin: auto;
            display: flex;
            flex-direction: column;
            animation: modalSlideUp 0.3s ease-out;
        }
        
        @keyframes modalSlideUp {
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 24px 28px;
            border-bottom: 1px solid var(--admin-border);
            background: var(--admin-bg-dark);
            border-radius: 24px 24px 0 0;
        }

        .modal-header h2,
        .modal-header h3 {
            margin: 0;
            color: var(--admin-text-primary);
            font-size: 1.3rem;
            font-weight: 700;
        }

        /* updated to match customer theme */
        .modal-close,
        .close {
            font-size: 32px;
            font-weight: 700;
            cursor: pointer;
            color: var(--admin-text-muted);
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            transition: all 0.3s ease;
            background: var(--admin-card-primary);
            line-height: 1;
            padding: 0;
            border: none;
        }

        .modal-close:hover,
        .close:hover {
            background: var(--admin-card-accent);
            color: var(--admin-accent-peach);
            transform: scale(1.1);
        }

        .modal-body {
            padding: 28px;
        }

        .modal-footer {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            padding: 20px 28px;
            border-top: 1px solid var(--admin-border);
            background: var(--admin-bg-dark);
            border-radius: 0 0 24px 24px;
        }

        .form-actions {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid var(--admin-border);
        }

        /* Dark mode for transport components *//* Professional Tab Icon Styling *//* Mobile responsive icon adjustments */
        @media (max-width: 768px) {
            .tab-btn {
                min-width: 220px;
                gap: 8px;
                font-size: 0.9rem;
            }
            
            .tab-btn i {
                font-size: 1rem;
            }

            .transport-tabs {
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .tab-btn {
                min-width: 100%;
                width: 100%;
            }
        }

        /* ============================================
         * FLASH NOTIFICATION STYLES
         * ============================================ */
        .flash-notification {
            position: fixed;
            top: 90px;
            right: 30px;
            min-width: 350px;
            max-width: 500px;
            padding: 18px 24px;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
            z-index: 10000;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            animation: slideInRight 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(10px);
            border: 2px solid;
        }

        .flash-success {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.95) 0%, rgba(5, 150, 105, 0.95) 100%);
            border-color: rgba(255, 255, 255, 0.3);
            color: white;
        }

        .flash-error {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.95) 0%, rgba(220, 38, 38, 0.95) 100%);
            border-color: rgba(255, 255, 255, 0.3);
            color: white;
        }

        .flash-content {
            display: flex;
            align-items: center;
            gap: 12px;
            flex: 1;
        }

        .flash-content i {
            font-size: 1.4rem;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
        }

        .flash-content span {
            font-size: 0.95rem;
            font-weight: 500;
            line-height: 1.4;
        }

        .flash-close {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            flex-shrink: 0;
        }

        .flash-close:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.1);
        }

        @keyframes slideInRight {
            from {
                transform: translateX(400px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(400px);
                opacity: 0;
            }
        }

        .flash-notification.hiding {
            animation: slideOutRight 0.3s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        @media (max-width: 768px) {
            .flash-notification {
                right: 15px;
                left: 15px;
                min-width: auto;
                max-width: none;
            }
        }

        /* ============================================
         * HOME CONTENT SECTION STYLES (Transport-like Layout)
         * ============================================ */
        
        .transport-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.25rem;
        }

        .transport-card {
            background: var(--admin-card-secondary);
            border: 1px solid var(--admin-border);
            border-radius: 12px;
            padding: 1.25rem;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .transport-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--admin-shadow-md);
            border-color: var(--admin-accent-peach);
        }

        .transport-card-header {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            margin-bottom: 1rem;
            flex: 1;
        }

        .transport-icon {
            width: 52px;
            height: 52px;
            min-width: 52px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(232, 184, 154, 0.15), rgba(232, 184, 154, 0.05));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--admin-primary);
            flex-shrink: 0;
        }

        .transport-info {
            flex: 1;
            min-width: 0;
        }

        .transport-info h3 {
            margin: 0 0 0.5rem 0;
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--admin-text-primary);
            word-wrap: break-word;
        }

        .transport-info p {
            margin: 0 0 0.5rem 0;
            font-size: 0.875rem;
            color: var(--admin-text-secondary);
            line-height: 1.5;
            word-wrap: break-word;
        }

        .transport-card-actions {
            display: flex;
            gap: 0.5rem;
            justify-content: flex-end;
            margin-top: auto;
            padding-top: 0.75rem;
            border-top: 1px solid var(--admin-border);
        }

        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            font-size: 0.75rem;
            font-weight: 600;
            border-radius: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-warning {
            background: rgba(232, 168, 122, 0.2);
            color: var(--admin-warning);
            border: 1px solid var(--admin-warning);
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--admin-text-muted);
            background: var(--admin-card-secondary);
            border: 1px dashed var(--admin-border);
            border-radius: 12px;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.3;
        }

        .empty-state p {
            font-size: 1.1rem;
            margin: 0;
        }

        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
        }

        /* Responsive Grid Adjustments */
        @media (max-width: 768px) {
            .transport-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .transport-card {
                padding: 1rem;
            }

            .transport-icon {
                width: 44px;
                height: 44px;
                min-width: 44px;
                font-size: 1.25rem;
            }

            .transport-info h3 {
                font-size: 1rem;
            }

            .transport-info p {
                font-size: 0.8rem;
            }
            
            .empty-state {
                padding: 3rem 1rem;
            }
            
            .empty-state i {
                font-size: 3rem;
            }

            .transport-card-actions {
                flex-direction: column;
            }

            .transport-card-actions button,
            .transport-card-actions form {
                width: 100%;
            }

            .transport-card-actions .btn {
                width: 100%;
            }
        }
    </style>
    <script>
        // Enhanced Navigation Functions with Checkpoint System
        function showSection(sectionId) {
            console.log("showSection called for:", sectionId);
            
            try {
                // Hide all sections
                const sections = document.querySelectorAll('.content-section');
                
                sections.forEach(section => {
                    section.classList.remove('active');
                    section.style.display = 'none';
                });
                
                // Deactivate all nav links
                document.querySelectorAll('.nav-link').forEach(link => {
                    link.classList.remove('active');
                });
                
                // Show target section
                const targetId = sectionId + '-section';
                const targetSection = document.getElementById(targetId);
                
                if (targetSection) {
                    targetSection.style.display = 'block';
                    setTimeout(() => {
                        targetSection.classList.add('active');
                    }, 10);
                } else {
                    console.error("Target section not found:", targetId);
                }
                
                // Activate current nav link
                const navLink = document.querySelector(`.nav-link[href="#${sectionId}"]`) || 
                               document.querySelector(`.nav-link[onclick*="'${sectionId}'"]`);
                
                if (navLink) {
                    navLink.classList.add('active');
                }
                
                // Update URL hash untuk checkpoint (tanpa reload page)
                if (window.location.hash !== '#' + sectionId) {
                    history.replaceState(null, null, '#' + sectionId);
                }
                
                // Close sidebar on mobile
                const sidebar = document.querySelector('.sidebar');
                if (sidebar && window.innerWidth <= 768) {
                    sidebar.classList.remove('active');
                }
                
            } catch (e) {
                console.error("Error in showSection:", e);
            }
        }
        
        // Auto-restore tab dari URL hash saat page load
        function restoreActiveTab() {
            const hash = window.location.hash.substring(1); // Remove # symbol
            
            if (hash) {
                console.log("Restoring tab from hash:", hash);
                // Gunakan setTimeout untuk memastikan DOM sudah ready
                setTimeout(() => {
                    showSection(hash);
                }, 100);
            } else {
                // Default ke dashboard jika tidak ada hash
                showSection('dashboard');
            }
        }
        
        // Initialize saat DOM ready
        document.addEventListener('DOMContentLoaded', restoreActiveTab);
        
        // Expose to window explicitly
        window.showSection = showSection;
        window.restoreActiveTab = restoreActiveTab;
    </script>
</head>
<body class="admin-body">
    <!-- Notifikasi Flash Message -->
    <?php if (isset($_SESSION['admin_message'])): ?>
    <div class="flash-notification <?php echo $_SESSION['admin_message_type'] === 'success' ? 'flash-success' : 'flash-error'; ?>" id="flashNotification">
        <div class="flash-content">
            <i class="fas <?php echo $_SESSION['admin_message_type'] === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'; ?>"></i>
            <span><?php echo htmlspecialchars($_SESSION['admin_message']); ?></span>
        </div>
        <button class="flash-close" onclick="closeFlashNotification()">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <?php 
        unset($_SESSION['admin_message']);
        unset($_SESSION['admin_message_type']);
    ?>
    <?php endif; ?>

    <!-- Header -->
    <!-- // UPDATED: Header dengan avatar user dan modern styling -->
    <div class="admin-header">
        <div class="admin-logo">
            <i class="fas fa-plane-departure"></i>
            Cendana Travel Admin
        </div>
        <div class="admin-user">
            <!-- removed: dark mode toggle button -->
        </div>
    </div>

    <!-- Sidebar Navigation -->
    <div class="sidebar admin-sidebar">
        <nav class="sidebar-nav">
            <a href="#dashboard" class="nav-link active" onclick="showSection('dashboard'); return false;">
                <i class="fas fa-tachometer-alt"></i>
                Dashboard
            </a>
            <a href="#beranda" class="nav-link" onclick="showSection('beranda'); return false;">
                <i class="fas fa-cog"></i>
                Pengaturan Beranda
            </a>
            <a href="#konten-beranda" class="nav-link" onclick="showSection('konten-beranda'); return false;">
                <i class="fas fa-th-large"></i>
                Konten Beranda
            </a>
            <a href="#transportasi" class="nav-link" onclick="showSection('transportasi'); return false;">
                <i class="fas fa-plane"></i>
                Kelola Transportasi
            </a>
            <a href="#galeri" class="nav-link" onclick="showSection('galeri'); return false;">
                <i class="fas fa-images"></i>
                Galeri
            </a>
            <a href="#faq" class="nav-link" onclick="showSection('faq'); return false;">
                <i class="fas fa-question-circle"></i>
                FAQ
            </a>
            <a href="#kontak" class="nav-link" onclick="showSection('kontak'); return false;">
                <i class="fas fa-phone"></i>
                Informasi Kontak
            </a>
            <a href="auth.php?action=logout" class="nav-link" style="margin-top: auto; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 1rem;">
                <i class="fas fa-sign-out-alt"></i>
                Keluar
            </a>
        </nav>
    </div>

    <!-- Mobile Menu Toggle -->
    <div class="mobile-menu-toggle" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </div>

    <!-- Main Content -->
    <div class="admin-content">
        <!-- ============================================ -->
        <!-- DASHBOARD SECTION -->
        <!-- ============================================ -->
        <div id="dashboard-section" class="content-section active">
            <h1>Dashboard Administrasi</h1>
            <p>Sistem manajemen terpadu CV. Cendana Travel untuk operasional dan monitoring kinerja bisnis secara real-time</p>
            
            <!-- // UPDATED: Stats grid dengan icons modern -->
            <div class="stats-grid">
                <div class="stat-card">
                    <h3><i class="ri-service-line"></i> Total Layanan</h3>
                    <div class="number"><?= $stats['total_services'] ?? 0 ?></div>
                    <small>Layanan transportasi aktif</small>
                </div>
                <div class="stat-card">
                    <h3><i class="ri-gallery-line"></i> Galeri Aktif</h3>
                    <div class="number"><?= $stats['total_gallery'] ?? 0 ?></div>
                    <small>Foto dalam galeri</small>
                </div>
                <div class="stat-card">
                    <h3><i class="ri-question-line"></i> FAQ Aktif</h3>
                    <div class="number"><?= $stats['total_faq'] ?? 0 ?></div>
                    <small>Pertanyaan tersedia</small>
                </div>
                <div class="stat-card">
                    <h3><i class="ri-car-line"></i> Jenis Transportasi</h3>
                    <div class="number">3</div>
                    <small>Pesawat, Kapal, Bus</small>
                </div>
            </div>
            
            <div class="section-card">
                <div class="section-header">
                    <h2>Ikhtisar Sistem Manajemen</h2>
                </div>
                <div class="section-content">
                    <p>Sistem administrasi terintegrasi dengan fitur manajemen konten lengkap untuk operasional yang efisien:</p>
                    <!-- updated to match customer theme - Peach/Brown accent colors -->
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-top: 24px;">
                        <div style="padding: 20px; background: var(--admin-bg-secondary); border-radius: 12px; border-left: 4px solid var(--admin-accent-peach);">
                            <strong style="color: var(--admin-accent-peach); display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                                <i class="fas fa-cog"></i> General
                            </strong>
                            <span style="color: var(--admin-text-secondary); font-size: 0.9rem;">Kelola informasi umum perusahaan</span>
                        </div>
                        <div style="padding: 20px; background: var(--admin-bg-secondary); border-radius: 12px; border-left: 4px solid var(--admin-accent-whatsapp);">
                            <strong style="color: var(--admin-accent-whatsapp); display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                                <i class="fas fa-image"></i> Kelola Beranda
                            </strong>
                            <span style="color: var(--admin-text-secondary); font-size: 0.9rem;">Manajemen banner dan konten utama</span>
                        </div>
                        <div style="padding: 20px; background: var(--admin-bg-secondary); border-radius: 12px; border-left: 4px solid var(--admin-accent-orange);">
                            <strong style="color: var(--admin-accent-orange); display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                                <i class="fas fa-ticket-alt"></i> Pemesanan
                            </strong>
                            <span style="color: var(--admin-text-secondary); font-size: 0.9rem;">Monitoring dan pengelolaan reservasi</span>
                        </div>
                        <div style="padding: 20px; background: var(--admin-bg-secondary); border-radius: 12px; border-left: 4px solid var(--admin-accent-brown);">
                            <strong style="color: var(--admin-accent-brown); display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                                <i class="fas fa-images"></i> Galeri
                            </strong>
                            <span style="color: var(--admin-text-secondary); font-size: 0.9rem;">Kurasi dan publikasi media visual</span>
                        </div>
                        <div style="padding: 20px; background: var(--admin-bg-secondary); border-radius: 12px; border-left: 4px solid var(--admin-accent-warm);">
                            <strong style="color: var(--admin-accent-warm); display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                                <i class="fas fa-phone"></i> Kontak
                            </strong>
                            <span style="color: var(--admin-text-secondary); font-size: 0.9rem;">Pemeliharaan informasi komunikasi</span>
                        </div>
                        <div style="padding: 20px; background: var(--admin-bg-secondary); border-radius: 12px; border-left: 4px solid var(--admin-accent-peach);">
                            <strong style="color: var(--admin-accent-peach); display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                                <i class="fas fa-question-circle"></i> FAQ
                            </strong>
                            <span style="color: var(--admin-text-secondary); font-size: 0.9rem;">Administrasi bantuan pelanggan</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ============================================ -->
        <!-- PENGATURAN BERANDA SECTION -->
        <!-- ============================================ -->
        <div id="beranda-section" class="content-section">
            <h1>Pengaturan Beranda</h1>
            <p>Kelola konten dinamis untuk semua halaman website</p>
            
            <div class="section-card">
                <div class="section-header">
                    <h2>Hero Section & Konten Beranda</h2>
                </div>
                <div class="section-content">
                    <form method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="module" value="homepage">
                        
                        <!-- 2 COLUMN GRID LAYOUT -->
                        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 3rem; position: relative;">
                            <!-- Vertical Divider Line -->
                            <div style="position: absolute; left: 50%; top: 0; bottom: 0; width: 1px; background: var(--admin-border); transform: translateX(-50%);"></div>
                            
                            <!-- LEFT COLUMN -->
                            <div style="display: flex; flex-direction: column; gap: 1.5rem; position: relative; z-index: 1;">
                                <div class="form-group-horizontal" style="margin-bottom: 0;">
                                    <label>Nama Perusahaan</label>
                                    <div class="form-input-wrapper">
                                        <input type="text" name="company_name" value="<?= htmlspecialchars($homepageSettings['company_name'] ?? '') ?>" required>
                                        <small style="color: var(--admin-text-muted); display: block; margin-top: 0.5rem;">Tampil di Navbar dan Footer</small>
                                    </div>
                                </div>
                                
                                <div class="form-group-horizontal" style="margin-bottom: 0;">
                                    <label>Judul Hero Beranda</label>
                                    <div class="form-input-wrapper">
                                        <input type="text" name="hero_title" value="<?= htmlspecialchars($homepageSettings['hero_title'] ?? '') ?>" required placeholder="Perjalanan Impian">
                                    </div>
                                </div>
                                
                                <div class="form-group-horizontal" style="margin-bottom: 0;">
                                    <label>Sub Judul Hero</label>
                                    <div class="form-input-wrapper">
                                        <input type="text" name="hero_subtitle" value="<?= htmlspecialchars($homepageSettings['hero_subtitle'] ?? '') ?>" required placeholder="DIMULAI DARI SINI">
                                    </div>
                                </div>
                                
                                <div class="form-group-horizontal" style="margin-bottom: 0;">
                                    <label>Deskripsi Hero</label>
                                    <div class="form-input-wrapper">
                                        <textarea name="hero_description" rows="3" required><?= htmlspecialchars($homepageSettings['hero_description'] ?? '') ?></textarea>
                                    </div>
                                </div>
                                
                                <div class="form-group-horizontal" style="margin-bottom: 0;">
                                    <label>Background Hero</label>
                                    <div class="form-input-wrapper">
                                        <input type="file" name="hero_background" accept="image/*">
                                        <?php if (!empty($homepageSettings['hero_background'])): ?>
                                        <div style="display: flex; align-items: center; gap: 10px; margin-top: 10px;">
                                            <img src="uploads/<?= htmlspecialchars($homepageSettings['hero_background']) ?>" alt="Current" style="max-width: 150px; border-radius: 4px; border: 1px solid var(--admin-border);">
                                            <button type="button" class="btn-danger" style="padding: 6px 12px; font-size: 0.85rem;"
                                                    onclick="showConfirm(event, 'Hapus Background Hero?', 'Background gambar hero beranda akan dihapus secara permanen. Tindakan ini tidak dapat dibatalkan.', function() { window.location.href='?action=delete_background&module=homepage&field=hero_background'; })">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- RIGHT COLUMN -->
                            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                                <div class="form-group-horizontal" style="margin-bottom: 0;">
                                    <label>Statistik - Tahun</label>
                                    <div class="form-input-wrapper">
                                        <input type="text" name="stats_years" value="<?= htmlspecialchars($homepageSettings['stats_years'] ?? '') ?>" required placeholder="10+">
                                        <input type="text" name="stats_years_label" value="<?= htmlspecialchars($homepageSettings['stats_years_label'] ?? '') ?>" placeholder="Tahun Pengalaman" style="margin-top: 0.5rem;">
                                    </div>
                                </div>
                                
                                <div class="form-group-horizontal" style="margin-bottom: 0;">
                                    <label>Statistik - Pelanggan</label>
                                    <div class="form-input-wrapper">
                                        <input type="text" name="stats_customers" value="<?= htmlspecialchars($homepageSettings['stats_customers'] ?? '') ?>" required placeholder="5000+">
                                        <input type="text" name="stats_customers_label" value="<?= htmlspecialchars($homepageSettings['stats_customers_label'] ?? '') ?>" placeholder="Pelanggan Puas" style="margin-top: 0.5rem;">
                                    </div>
                                </div>
                                
                                <div class="form-group-horizontal" style="margin-bottom: 0;">
                                    <label>Statistik - Rating</label>
                                    <div class="form-input-wrapper">
                                        <input type="text" name="stats_rating" value="<?= htmlspecialchars($homepageSettings['stats_rating'] ?? '') ?>" required placeholder="4.9">
                                        <input type="text" name="stats_rating_label" value="<?= htmlspecialchars($homepageSettings['stats_rating_label'] ?? '') ?>" placeholder="Rating" style="margin-top: 0.5rem;">
                                    </div>
                                </div>
                                
                                <div class="form-group-horizontal" style="margin-bottom: 0;">
                                    <label>Tentang Kami (Footer)</label>
                                    <div class="form-input-wrapper">
                                        <textarea name="footer_description" rows="4" required><?= htmlspecialchars($homepageSettings['footer_description'] ?? '') ?></textarea>
                                        <small style="color: var(--admin-text-muted); display: block; margin-top: 0.5rem;">Deskripsi perusahaan di Footer</small>
                                    </div>
                                </div>
                                
                                <div class="form-group-horizontal" style="margin-bottom: 0;">
                                    <label>Copyright Text</label>
                                    <div class="form-input-wrapper">
                                        <input type="text" name="footer_copyright" value="<?= htmlspecialchars($homepageSettings['footer_copyright'] ?? '') ?>" required placeholder="© 2024 CV. Cendana Travel">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- SUBMIT BUTTON -->
                        <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--admin-border);">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- HERO HALAMAN LAIN -->
            <div class="section-card" style="margin-top: 2rem;">
                <div class="section-header">
                    <h2>Hero Halaman Lain</h2>
                </div>
                <div class="section-content">
                    <form method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="module" value="homepage">
                        
                        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 3rem; position: relative;">
                            <!-- Vertical Divider Line -->
                            <div style="position: absolute; left: 50%; top: 0; bottom: 0; width: 1px; background: var(--admin-border); transform: translateX(-50%);"></div>
                            
                            <!-- HALAMAN PEMESANAN -->
                            <div style="position: relative; z-index: 1;">
                                <h3 style="margin-bottom: 1rem; color: var(--admin-text-primary); font-size: 1rem; padding-bottom: 0.5rem; border-bottom: 2px solid var(--admin-border);">Halaman Pemesanan</h3>
                                <div style="display: flex; flex-direction: column; gap: 1rem;">
                                    <div class="form-group-horizontal" style="margin-bottom: 0;">
                                        <label>Judul</label>
                                        <div class="form-input-wrapper">
                                            <input type="text" name="pemesanan_hero_title" value="<?= htmlspecialchars($homepageSettings['pemesanan_hero_title'] ?? 'Pemesanan Travel') ?>">
                                        </div>
                                    </div>
                                    <div class="form-group-horizontal" style="margin-bottom: 0;">
                                        <label>Deskripsi</label>
                                        <div class="form-input-wrapper">
                                            <textarea name="pemesanan_hero_description" rows="2"><?= htmlspecialchars($homepageSettings['pemesanan_hero_description'] ?? '') ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group-horizontal" style="margin-bottom: 0;">
                                        <label>Background</label>
                                        <div class="form-input-wrapper">
                                            <input type="file" name="pemesanan_hero_background" accept="image/*">
                                            <?php if (!empty($homepageSettings['pemesanan_hero_background'])): ?>
                                            <div style="display: flex; align-items: center; gap: 8px; margin-top: 8px;">
                                                <img src="uploads/<?= htmlspecialchars($homepageSettings['pemesanan_hero_background']) ?>" style="max-width: 100px; border-radius: 4px;">
                                                <button type="button" class="btn-danger" style="padding: 4px 8px; font-size: 0.75rem;" 
                                                        onclick="showConfirm(event, 'Hapus Background Pemesanan?', 'Background gambar hero halaman pemesanan akan dihapus secara permanen.', function() { window.location.href='?action=delete_background&module=homepage&field=pemesanan_hero_background'; })">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- HALAMAN GALERI -->
                            <div style="position: relative; z-index: 1;">
                                <h3 style="margin-bottom: 1rem; color: var(--admin-text-primary); font-size: 1rem; padding-bottom: 0.5rem; border-bottom: 2px solid var(--admin-border);">Halaman Galeri</h3>
                                <div style="display: flex; flex-direction: column; gap: 1rem;">
                                    <div class="form-group-horizontal" style="margin-bottom: 0;">
                                        <label>Judul</label>
                                        <div class="form-input-wrapper">
                                            <input type="text" name="galeri_hero_title" value="<?= htmlspecialchars($homepageSettings['galeri_hero_title'] ?? 'Galeri Perjalanan') ?>">
                                        </div>
                                    </div>
                                    <div class="form-group-horizontal" style="margin-bottom: 0;">
                                        <label>Deskripsi</label>
                                        <div class="form-input-wrapper">
                                            <textarea name="galeri_hero_description" rows="2"><?= htmlspecialchars($homepageSettings['galeri_hero_description'] ?? '') ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group-horizontal" style="margin-bottom: 0;">
                                        <label>Background</label>
                                        <div class="form-input-wrapper">
                                            <input type="file" name="galeri_hero_background" accept="image/*">
                                            <?php if (!empty($homepageSettings['galeri_hero_background'])): ?>
                                            <div style="display: flex; align-items: center; gap: 8px; margin-top: 8px;">
                                                <img src="uploads/<?= htmlspecialchars($homepageSettings['galeri_hero_background']) ?>" style="max-width: 100px; border-radius: 4px;">
                                                <button type="button" class="btn-danger" style="padding: 4px 8px; font-size: 0.75rem;" 
                                                        onclick="showConfirm(event, 'Hapus Background Galeri?', 'Background gambar hero halaman galeri akan dihapus secara permanen.', function() { window.location.href='?action=delete_background&module=homepage&field=galeri_hero_background'; })">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- HALAMAN FAQ -->
                            <div style="position: relative; z-index: 1;">
                                <h3 style="margin-bottom: 1rem; color: var(--admin-text-primary); font-size: 1rem; padding-bottom: 0.5rem; border-bottom: 2px solid var(--admin-border);">Halaman FAQ</h3>
                                <div style="display: flex; flex-direction: column; gap: 1rem;">
                                    <div class="form-group-horizontal" style="margin-bottom: 0;">
                                        <label>Judul</label>
                                        <div class="form-input-wrapper">
                                            <input type="text" name="faq_hero_title" value="<?= htmlspecialchars($homepageSettings['faq_hero_title'] ?? 'Pertanyaan yang Sering Diajukan') ?>">
                                        </div>
                                    </div>
                                    <div class="form-group-horizontal" style="margin-bottom: 0;">
                                        <label>Deskripsi</label>
                                        <div class="form-input-wrapper">
                                            <textarea name="faq_hero_description" rows="2"><?= htmlspecialchars($homepageSettings['faq_hero_description'] ?? '') ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group-horizontal" style="margin-bottom: 0;">
                                        <label>Background</label>
                                        <div class="form-input-wrapper">
                                            <input type="file" name="faq_hero_background" accept="image/*">
                                            <?php if (!empty($homepageSettings['faq_hero_background'])): ?>
                                            <div style="display: flex; align-items: center; gap: 8px; margin-top: 8px;">
                                                <img src="uploads/<?= htmlspecialchars($homepageSettings['faq_hero_background']) ?>" style="max-width: 100px; border-radius: 4px;">
                                                <button type="button" class="btn-danger" style="padding: 4px 8px; font-size: 0.75rem;" 
                                                        onclick="showConfirm(event, 'Hapus Background FAQ?', 'Background gambar hero halaman FAQ akan dihapus secara permanen.', function() { window.location.href='?action=delete_background&module=homepage&field=faq_hero_background'; })">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- HALAMAN KONTAK -->
                            <div style="position: relative; z-index: 1;">
                                <h3 style="margin-bottom: 1rem; color: var(--admin-text-primary); font-size: 1rem; padding-bottom: 0.5rem; border-bottom: 2px solid var(--admin-border);">Halaman Kontak</h3>
                                <div style="display: flex; flex-direction: column; gap: 1rem;">
                                    <div class="form-group-horizontal" style="margin-bottom: 0;">
                                        <label>Judul</label>
                                        <div class="form-input-wrapper">
                                            <input type="text" name="kontak_hero_title" value="<?= htmlspecialchars($homepageSettings['kontak_hero_title'] ?? 'Hubungi Kami') ?>">
                                        </div>
                                    </div>
                                    <div class="form-group-horizontal" style="margin-bottom: 0;">
                                        <label>Deskripsi</label>
                                        <div class="form-input-wrapper">
                                            <textarea name="kontak_hero_description" rows="2"><?= htmlspecialchars($homepageSettings['kontak_hero_description'] ?? '') ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group-horizontal" style="margin-bottom: 0;">
                                        <label>Background</label>
                                        <div class="form-input-wrapper">
                                            <input type="file" name="kontak_hero_background" accept="image/*">
                                            <?php if (!empty($homepageSettings['kontak_hero_background'])): ?>
                                            <div style="display: flex; align-items: center; gap: 8px; margin-top: 8px;">
                                                <img src="uploads/<?= htmlspecialchars($homepageSettings['kontak_hero_background']) ?>" style="max-width: 100px; border-radius: 4px;">
                                                <button type="button" class="btn-danger" style="padding: 4px 8px; font-size: 0.75rem;" 
                                                        onclick="showConfirm(event, 'Hapus Background Kontak?', 'Background gambar hero halaman kontak akan dihapus secara permanen.', function() { window.location.href='?action=delete_background&module=homepage&field=kontak_hero_background'; })">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- SUBMIT BUTTON -->
                        <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--admin-border);">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- SECTION BANNER (Hidden - Not in menu) -->
        <div id="banner-section" class="content-section" style="display: none;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <div>
                    <h1>Kelola Banner Beranda</h1>
                    <p>Tambah, edit, atau hapus banner yang ditampilkan di halaman utama</p>
                </div>
                <button class="btn btn-primary" onclick="openBannerModal()" style="white-space: nowrap;">
                    <i class="fas fa-plus"></i> Tambah Banner
                </button>
            </div>
            
            <!-- Modal Banner -->
            <div id="bannerModal" class="modal" style="display: none;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 id="bannerModalTitle">Tambah Banner Baru</h2>
                        <span class="close" onclick="closeBannerModal()">&times;</span>
                    </div>
                    <form id="bannerForm" method="POST" enctype="multipart/form-data" action="admin.php#beranda">
                        <input type="hidden" name="action" id="bannerAction" value="add">
                        <input type="hidden" name="module" value="banner">
                        <input type="hidden" name="id" id="bannerId">
                        
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="banner_title">Judul Banner *</label>
                                <input type="text" id="banner_title" name="title" required 
                                       placeholder="Contoh: Jelajahi Indonesia Bersama Kami">
                            </div>
                            
                            <div class="form-group">
                                <label for="banner_subtitle">Subtitle</label>
                                <textarea id="banner_subtitle" name="subtitle" rows="2"
                                          placeholder="Deskripsi singkat banner"></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label for="banner_image">Upload Gambar Banner <span id="bannerImageLabel">*</span></label>
                                <input type="file" id="banner_image" name="image" accept="image/*">
                                <small style="color: #6c757d; display: block; margin-top: 5px;">
                                    Format: JPG, PNG, GIF. Rekomendasi ukuran: 1920x600px. Max 5MB
                                </small>
                                <div id="currentBannerImage" style="margin-top: 10px; display: none;">
                                    <label>Gambar Saat Ini:</label>
                                    <img id="previewBannerImage" src="" alt="Preview" 
                                         style="max-width: 300px; max-height: 120px; display: block; margin-top: 5px; border-radius: 4px;">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="banner_link_url">Link URL (opsional)</label>
                                <input type="url" id="banner_link_url" name="link_url" 
                                       placeholder="https://example.com/tujuan">
                                <small style="color: #6c757d;">Banner akan menjadi link yang dapat diklik</small>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group" style="flex: 1;">
                                    <label for="banner_display_order">Urutan Tampil</label>
                                    <input type="number" id="banner_display_order" name="display_order" 
                                           value="0" min="0" placeholder="0">
                                    <small style="color: #6c757d;">Semakin kecil, semakin di depan</small>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                                    <input type="checkbox" id="banner_is_active" name="is_active" value="1" checked>
                                    <span>Aktif (Tampilkan di Website)</span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" onclick="closeBannerModal()">
                                <i class="fas fa-times"></i> Batal
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Daftar Banner -->
            <div class="section-card">
                <div class="section-header">
                    <h2>Daftar Banner</h2>
                </div>
                <div class="section-content">
                    <?php $banners = getAllBanners(); ?>
                    <div class="gallery-grid">
                        <?php if (empty($banners)): ?>
                        <div style="grid-column: 1 / -1; text-align: center; padding: 2rem; color: #6c757d;">
                            <i class="fas fa-images" style="font-size: 3rem; margin-bottom: 15px; display: block; color: #dee2e6;"></i>
                            Belum ada banner. Silakan tambahkan banner pertama.
                        </div>
                        <?php else: ?>
                        <?php foreach ($banners as $banner): 
                            // Fix image path
                            $imagePath = $banner['image'];
                            if (!empty($imagePath) && strpos($imagePath, 'uploads/') !== 0) {
                                $imagePath = 'uploads/' . $imagePath;
                            }
                        ?>
                        <div class="gallery-item">
                            <div style="position: relative;">
                                <?php if (!empty($imagePath) && file_exists($imagePath)): ?>
                                <img src="<?= htmlspecialchars($imagePath) ?>" 
                                     alt="<?= htmlspecialchars($banner['title']) ?>"
                                     style="width: 100%; height: 180px; object-fit: cover; border-radius: 8px 8px 0 0;">
                                <?php else: ?>
                                <div style="width: 100%; height: 180px; background: #f8f9fa; display: flex; align-items: center; justify-content: center; border-radius: 8px 8px 0 0;">
                                    <i class="fas fa-image" style="font-size: 2.5rem; color: #dee2e6;"></i>
                                </div>
                                <?php endif; ?>
                                
                                <?php if ($banner['link_url']): ?>
                                <span class="badge badge-info" style="position: absolute; top: 10px; left: 10px;">
                                    <i class="fas fa-link"></i> Link
                                </span>
                                <?php endif; ?>
                            </div>
                            
                            <div class="gallery-info">
                                <h4><?= htmlspecialchars($banner['title']) ?></h4>
                                
                                <?php if ($banner['subtitle']): ?>
                                <p><?= htmlspecialchars(truncateText($banner['subtitle'], 85)) ?></p>
                                <?php endif; ?>
                                
                                <div class="gallery-actions">
                                    <div>
                                        <span class="badge badge-secondary">Urutan: <?= $banner['display_order'] ?></span>
                                        <?php if ($banner['is_active']): ?>
                                        <span class="badge badge-success">Aktif</span>
                                        <?php else: ?>
                                        <span class="badge badge-danger">Tidak Aktif</span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <div style="display: flex; gap: 5px;">
                                        <button onclick='editBannerModal(<?= json_encode($banner) ?>)' class="btn btn-secondary" 
                                                style="padding: 6px 10px; font-size: 0.75rem;">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form method="POST" style="display: inline;" 
                                              onsubmit="return showConfirm(event, 'Hapus Banner Jelajahi Dunia?', 'Banner ini akan dihapus secara permanen dari halaman beranda. Tindakan ini tidak dapat dibatalkan.')">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="module" value="banner">
                                            <input type="hidden" name="id" value="<?= $banner['id'] ?>">
                                            <button type="submit" class="btn btn-danger" style="padding: 6px 10px; font-size: 0.75rem;">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>



        <!-- ============================================ -->
        <!-- KONTEN BERANDA SECTION -->
        <!-- ============================================ -->
        <div id="konten-beranda-section" class="content-section">
            <h1>Konten Beranda Dinamis</h1>
            <p>Kelola semua konten yang ditampilkan di halaman beranda website</p>
            
            <!-- Content Type Tabs -->
            <div class="transport-tabs" style="margin-bottom: 30px;">
                <button class="tab-btn active" data-tab="service-cards">
                    <i class="fas fa-globe"></i> Jelajahi Dunia
                </button>
                <button class="tab-btn" data-tab="why-choose">
                    <i class="fas fa-check-circle"></i> Mengapa Memilih Kami
                </button>
                <button class="tab-btn" data-tab="payment-steps">
                    <i class="fas fa-credit-card"></i> Cara Pembayaran
                </button>
                <button class="tab-btn" data-tab="order-steps">
                    <i class="fas fa-shopping-cart"></i> Cara Memesan
                </button>
                <button class="tab-btn" data-tab="gallery-home">
                    <i class="fas fa-images"></i> Galeri Beranda
                </button>
            </div>

            <?php
            // Include functions
            require_once __DIR__ . '/includes/home_content_functions.php';
            
            // Fetch all data
            $serviceCards = getAllServiceCards();
            $whyChooseUs = getAllWhyChooseUs();
            $paymentSteps = getAllPaymentSteps();
            $orderSteps = getAllOrderSteps();
            $galleryHomeSelection = getAllGalleryHomeSelection();
            $availableGallery = getAllGalleryForSelection();
            ?>

            <!-- TAB 0: JELAJAHI DUNIA (Service Cards) -->
            <div id="service-cards-tab" class="transport-tab-content active">
                <div class="section-card">
                    <div class="section-header">
                        <h2>Jelajahi Dunia - Card Layanan</h2>
                        <button class="btn btn-primary" onclick="openServiceCardModal('add')">
                            <i class="fas fa-plus"></i> Tambah Card Baru
                        </button>
                    </div>

                    <!-- List dengan tabel yang lebih rapi -->
                    <div class="table-responsive" style="margin-top: 1.5rem;">
                        <table class="data-table" style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="background: var(--admin-bg-secondary); border-bottom: 2px solid var(--admin-border);">
                                    <th style="padding: 1rem; text-align: center; width: 140px; font-weight: 600;">Gambar</th>
                                    <th style="padding: 1rem; text-align: left; font-weight: 600;">Judul</th>
                                    <th style="padding: 1rem; text-align: left; font-weight: 600;">Deskripsi</th>
                                    <th style="padding: 1rem; text-align: center; width: 100px; font-weight: 600;">Featured</th>
                                    <th style="padding: 1rem; text-align: center; width: 100px; font-weight: 600;">Urutan</th>
                                    <th style="padding: 1rem; text-align: center; width: 100px; font-weight: 600;">Status</th>
                                    <th style="padding: 1rem; text-align: center; width: 150px; font-weight: 600;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($serviceCards)): ?>
                                <tr>
                                    <td colspan="7" style="text-align: center; padding: 3rem; color: var(--admin-text-muted);">
                                        <i class="fas fa-inbox" style="font-size: 3rem; margin-bottom: 1rem; display: block; opacity: 0.5;"></i>
                                        <p style="margin: 0; font-size: 1.1rem;">Belum ada data</p>
                                        <p style="margin: 0.5rem 0 0 0; font-size: 0.9rem;">Klik "Tambah Card Baru" untuk menambahkan.</p>
                                    </td>
                                </tr>
                                <?php else: ?>
                                <?php foreach ($serviceCards as $item): ?>
                                <tr style="border-bottom: 1px solid var(--admin-border); transition: background 0.2s;" onmouseover="this.style.background='var(--admin-bg-secondary)'" onmouseout="this.style.background='transparent'">
                                    <td style="padding: 1rem; text-align: center;">
                                        <?php if ($item['image']): ?>
                                        <img src="<?= htmlspecialchars($item['image']) ?>?v=<?= time() ?>" alt="<?= htmlspecialchars($item['title']) ?>" 
                                             style="width: 120px; height: 80px; object-fit: cover; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                        <?php else: ?>
                                        <div style="width: 120px; height: 80px; display: flex; align-items: center; justify-content: center; background: var(--admin-bg-secondary); border-radius: 8px; margin: 0 auto;">
                                            <i class="fas fa-image" style="font-size: 1.5rem; color: var(--admin-text-muted); opacity: 0.5;"></i>
                                        </div>
                                        <?php endif; ?>
                                    </td>
                                    <td style="padding: 1rem;">
                                        <strong style="color: var(--admin-text-primary); font-size: 1rem;"><?= htmlspecialchars($item['title']) ?></strong>
                                        <?php if ($item['badge_text']): ?>
                                        <br><span style="display: inline-block; margin-top: 0.25rem; padding: 0.2rem 0.5rem; background: #ff6b6b; color: white; border-radius: 4px; font-size: 0.75rem;"><?= htmlspecialchars($item['badge_text']) ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="padding: 1rem; color: var(--admin-text-secondary); line-height: 1.5;">
                                        <?= htmlspecialchars(substr($item['description'], 0, 100)) ?><?= strlen($item['description']) > 100 ? '...' : '' ?>
                                    </td>
                                    <td style="padding: 1rem; text-align: center;">
                                        <?php if ($item['is_featured']): ?>
                                        <span style="display: inline-block; background: #4CAF50; color: white; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">
                                            ⭐ Featured
                                        </span>
                                        <?php else: ?>
                                        <span style="display: inline-block; background: var(--admin-bg-secondary); padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.85rem;">
                                            Regular
                                        </span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="padding: 1rem; text-align: center;">
                                        <span style="display: inline-block; background: var(--admin-bg-secondary); padding: 0.25rem 0.75rem; border-radius: 20px; font-weight: 600;">
                                            <?= $item['sort_order'] ?>
                                        </span>
                                    </td>
                                    <td style="padding: 1rem; text-align: center;">
                                        <span class="status-badge status-<?= $item['is_active'] ? 'active' : 'inactive' ?>" style="padding: 0.4rem 1rem; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">
                                            <?= $item['is_active'] ? '✓ Aktif' : '✗ Nonaktif' ?>
                                        </span>
                                    </td>
                                    <td style="padding: 1rem;">
                                        <div style="display: flex; gap: 8px; justify-content: center;">
                                            <button class="btn btn-small btn-primary" onclick="editServiceCard(<?= $item['id'] ?>)" title="Edit" style="padding: 0.5rem 1rem;">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form method="POST" style="display: inline; margin: 0;" onsubmit="return showConfirm(event, 'Hapus Card Layanan?', 'Card layanan ini akan dihapus secara permanen dari halaman beranda. Tindakan ini tidak dapat dibatalkan.')">
                                                <input type="hidden" name="action" value="delete">
                                                <input type="hidden" name="module" value="service_cards">
                                                <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                                <button type="submit" class="btn btn-small btn-danger" title="Hapus" style="padding: 0.5rem 1rem;">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Modal Popup untuk Service Cards -->
            <div id="serviceCardModal" class="modal-overlay" style="display: none;">
                <div class="modal-content" style="max-width: 700px;">
                    <div class="modal-header">
                        <h3 id="serviceCardModalTitle">Tambah Card Baru</h3>
                        <button class="modal-close" onclick="closeServiceCardModal()">&times;</button>
                    </div>
                    <form id="serviceCardForm" method="POST" enctype="multipart/form-data" style="padding: 1.5rem;">
                        <input type="hidden" name="action" id="serviceCardAction" value="create">
                        <input type="hidden" name="module" value="service_cards">
                        <input type="hidden" name="id" id="serviceCardId">
                        
                        <div class="form-group">
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Judul Layanan <span style="color: #e74c3c;">*</span></label>
                            <input type="text" name="title" id="serviceCardTitle" required placeholder="Contoh: Tiket Pesawat" style="width: 100%; padding: 0.75rem; border: 1px solid var(--admin-border); border-radius: 8px; font-size: 1rem;">
                        </div>
                        
                        <div class="form-group">
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Deskripsi <span style="color: #e74c3c;">*</span></label>
                            <textarea name="description" id="serviceCardDescription" required rows="3" placeholder="Jelaskan layanan ini secara detail..." style="width: 100%; padding: 0.75rem; border: 1px solid var(--admin-border); border-radius: 8px; font-size: 1rem; resize: vertical;"></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Gambar <span style="color: #999; font-size: 0.9rem;">(Upload atau URL)</span></label>
                            <div id="currentServiceImagePreview" style="margin-bottom: 1rem; display: none;">
                                <img id="currentServiceImage" src="" alt="Current Image" style="width: 200px; height: auto; object-fit: cover; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                                <p style="margin: 0.5rem 0; font-size: 0.85rem; color: var(--admin-text-muted);">Gambar saat ini</p>
                            </div>
                            <input type="file" name="image" id="serviceCardImage" accept="image/*" style="width: 100%; padding: 0.75rem; border: 2px dashed var(--admin-border); border-radius: 8px; background: var(--admin-bg-secondary); margin-bottom: 0.5rem;">
                            <small style="color: var(--admin-text-muted); display: block; margin-bottom: 0.5rem;">Upload gambar • Format: JPG, PNG • Maks 5MB</small>
                            <input type="text" name="image_url" id="serviceCardImageUrl" placeholder="Atau paste URL gambar (contoh: https://images.unsplash.com/...)" style="width: 100%; padding: 0.75rem; border: 1px solid var(--admin-border); border-radius: 8px; font-size: 0.9rem;">
                        </div>
                        
                        <div class="form-group">
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Fitur-fitur <span style="color: #999; font-size: 0.9rem;">(Opsional, pisahkan dengan Enter)</span></label>
                            <textarea name="features" id="serviceCardFeatures" rows="3" placeholder="Penerbangan Internasional & Domestik&#10;Proses Check-in Mudah&#10;Garansi Harga Terbaik" style="width: 100%; padding: 0.75rem; border: 1px solid var(--admin-border); border-radius: 8px; font-size: 1rem; resize: vertical;"></textarea>
                            <small style="color: var(--admin-text-muted); display: block; margin-top: 0.5rem;">Setiap baris = 1 fitur (untuk card featured)</small>
                        </div>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                            <div class="form-group">
                                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Teks Tombol</label>
                                <input type="text" name="button_text" id="serviceCardButtonText" value="Pesan Sekarang" style="width: 100%; padding: 0.75rem; border: 1px solid var(--admin-border); border-radius: 8px; font-size: 1rem;">
                            </div>
                            
                            <div class="form-group">
                                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Link Tombol</label>
                                <input type="text" name="button_link" id="serviceCardButtonLink" value="pemesanan.php" style="width: 100%; padding: 0.75rem; border: 1px solid var(--admin-border); border-radius: 8px; font-size: 1rem;">
                            </div>
                        </div>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem;">
                            <div class="form-group">
                                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Badge Text</label>
                                <input type="text" name="badge_text" id="serviceCardBadge" placeholder="Terpopuler" style="width: 100%; padding: 0.75rem; border: 1px solid var(--admin-border); border-radius: 8px; font-size: 1rem;">
                                <small style="color: var(--admin-text-muted); display: block; margin-top: 0.25rem;">Contoh: Terpopuler, Best Deal</small>
                            </div>
                            
                            <div class="form-group">
                                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Featured Card?</label>
                                <select name="is_featured" id="serviceCardFeatured" style="width: 100%; padding: 0.75rem; border: 1px solid var(--admin-border); border-radius: 8px; font-size: 1rem;">
                                    <option value="0">Regular (Kecil)</option>
                                    <option value="1">Featured (Besar)</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Urutan Tampil</label>
                                <input type="number" name="sort_order" id="serviceCardSortOrder" value="0" min="0" style="width: 100%; padding: 0.75rem; border: 1px solid var(--admin-border); border-radius: 8px; font-size: 1rem;">
                            </div>
                        </div>
                        
                        <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                            <button type="submit" class="btn btn-primary" style="flex: 1; padding: 0.875rem; font-size: 1rem;">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                            <button type="button" class="btn btn-secondary" onclick="closeServiceCardModal()" style="flex: 1; padding: 0.875rem; font-size: 1rem;">
                                <i class="fas fa-times"></i> Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- TAB 1: MENGAPA MEMILIH KAMI -->
            <div id="why-choose-tab" class="transport-tab-content">
                <div class="section-card">
                    <div class="section-header">
                        <h2>Mengapa Memilih Kami</h2>
                        <button class="btn btn-primary" onclick="openWhyChooseModal('add')" 
                            <?php if (count($whyChooseUs) >= 4): ?>disabled title="Maksimal 4 poin sudah tercapai"<?php endif; ?>>
                            <i class="fas fa-plus"></i> Tambah Poin Baru
                        </button>
                    </div>
                    
                    <!-- Info box -->
                    <div style="background: linear-gradient(135deg, #FBEFE6 0%, #F5E5D8 100%); color: #2A1F1A; padding: 1rem 1.5rem; border-radius: 12px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 1rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); border: 2px solid #D6A889;">
                        <div style="font-size: 1.5rem; color: #8B6F47;">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <div style="flex: 1;">
                            <strong style="display: block; margin-bottom: 0.25rem; color: #2A1F1A; font-size: 1rem;">Batasan Data: Maksimal 4 Poin</strong>
                            <small style="color: #4A3628; line-height: 1.5;">Saat ini: <strong style="color: #8B6F47;"><?= count($whyChooseUs) ?>/4</strong> poin telah digunakan. <?php if (count($whyChooseUs) >= 4): ?>Hapus salah satu poin untuk menambah yang baru.<?php else: ?>Anda dapat menambahkan <strong style="color: #8B6F47;"><?= 4 - count($whyChooseUs) ?></strong> poin lagi.<?php endif; ?></small>
                        </div>
                    </div>

                    <!-- List of Items dengan tabel yang lebih rapi -->
                    <div class="table-responsive" style="margin-top: 1.5rem;">
                        <table class="data-table" style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="background: var(--admin-bg-secondary); border-bottom: 2px solid var(--admin-border);">
                                    <th style="padding: 1rem; text-align: center; width: 100px; font-weight: 600;">Icon</th>
                                    <th style="padding: 1rem; text-align: left; font-weight: 600;">Judul</th>
                                    <th style="padding: 1rem; text-align: left; font-weight: 600;">Deskripsi</th>
                                    <th style="padding: 1rem; text-align: center; width: 100px; font-weight: 600;">Urutan</th>
                                    <th style="padding: 1rem; text-align: center; width: 100px; font-weight: 600;">Status</th>
                                    <th style="padding: 1rem; text-align: center; width: 150px; font-weight: 600;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($whyChooseUs)): ?>
                                <tr>
                                    <td colspan="6" style="text-align: center; padding: 3rem; color: var(--admin-text-muted);">
                                        <i class="fas fa-inbox" style="font-size: 3rem; margin-bottom: 1rem; display: block; opacity: 0.5;"></i>
                                        <p style="margin: 0; font-size: 1.1rem;">Belum ada data</p>
                                        <p style="margin: 0.5rem 0 0 0; font-size: 0.9rem;">Klik "Tambah Poin Baru" untuk menambahkan.</p>
                                    </td>
                                </tr>
                                <?php else: ?>
                                <?php foreach ($whyChooseUs as $item): ?>
                                <tr style="border-bottom: 1px solid var(--admin-border); transition: background 0.2s;" onmouseover="this.style.background='var(--admin-bg-secondary)'" onmouseout="this.style.background='transparent'">
                                    <td style="padding: 1rem; text-align: center;">
                                        <?php 
                                        $icon = $item['icon'];
                                        if ($icon && substr($icon, 0, 6) === 'class:'): 
                                            $iconClass = substr($icon, 6);
                                        ?>
                                        <div style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; background: var(--admin-bg-secondary); border-radius: 8px; margin: 0 auto; color: var(--admin-accent-peach); font-size: 1.5rem;">
                                            <i class="icon <?= htmlspecialchars($iconClass) ?>"></i>
                                        </div>
                                        <?php elseif ($icon && file_exists($icon)): ?>
                                        <img src="<?= htmlspecialchars($icon) ?>?v=<?= time() ?>" alt="<?= htmlspecialchars($item['title']) ?>" 
                                             style="width: 60px; height: 60px; object-fit: contain; border-radius: 8px; background: var(--admin-bg-secondary); padding: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                        <?php else: ?>
                                        <div style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; background: var(--admin-bg-secondary); border-radius: 8px; margin: 0 auto;">
                                            <i class="fas fa-image" style="font-size: 1.5rem; color: var(--admin-text-muted); opacity: 0.5;"></i>
                                        </div>
                                        <?php endif; ?>
                                    </td>
                                    <td style="padding: 1rem;">
                                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                                            <strong style="color: var(--admin-text-primary); font-size: 1rem; flex: 1;"><?= htmlspecialchars($item['title']) ?></strong>
                                            <button class="btn btn-small btn-primary" onclick="editWhyChoose(<?= $item['id'] ?>)" title="Edit" style="padding: 0.4rem 0.8rem; font-size: 0.85rem;">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                        </div>
                                    </td>
                                    <td style="padding: 1rem; color: var(--admin-text-secondary); line-height: 1.5;">
                                        <?= htmlspecialchars(substr($item['description'], 0, 120)) ?><?= strlen($item['description']) > 120 ? '...' : '' ?>
                                    </td>
                                    <td style="padding: 1rem; text-align: center;">
                                        <span style="display: inline-block; background: var(--admin-bg-secondary); padding: 0.25rem 0.75rem; border-radius: 20px; font-weight: 600;">
                                            <?= $item['sort_order'] ?>
                                        </span>
                                    </td>
                                    <td style="padding: 1rem; text-align: center;">
                                        <span class="status-badge status-<?= $item['is_active'] ? 'active' : 'inactive' ?>" style="padding: 0.4rem 1rem; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">
                                            <?= $item['is_active'] ? '✓ Aktif' : '✗ Nonaktif' ?>
                                        </span>
                                    </td>
                                    <td style="padding: 1rem;">
                                        <div style="display: flex; gap: 8px; justify-content: center;">
                                            <form method="POST" style="display: inline; margin: 0;" onsubmit="return showConfirm(event, 'Hapus Poin Ini?', 'Poin \"' + '<?= htmlspecialchars($item['title']) ?>' + '\" akan dihapus secara permanen. Tindakan ini tidak dapat dibatalkan.')">
                                                <input type="hidden" name="action" value="delete">
                                                <input type="hidden" name="module" value="why_choose">
                                                <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                                <button type="submit" class="btn btn-small btn-danger" title="Hapus" style="padding: 0.5rem 1rem;">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Modal Popup untuk Add/Edit -->
            <div id="whyChooseModal" class="modal-overlay" style="display: none;">
                <div class="modal-content" style="max-width: 520px;">
                    <div class="modal-header" style="padding: 1.25rem 1.5rem;">
                        <h3 id="whyChooseModalTitle" style="margin: 0; font-size: 1.25rem;">Tambah Poin Baru</h3>
                        <button class="modal-close" onclick="closeWhyChooseModal()">&times;</button>
                    </div>
                    <form id="whyChooseForm" method="POST" enctype="multipart/form-data" style="padding: 1.25rem 1.5rem;" onsubmit="return validateWhyChooseForm()">
                        <input type="hidden" name="action" id="whyChooseAction" value="create">
                        <input type="hidden" name="module" value="why_choose">
                        <input type="hidden" name="id" id="whyChooseId">
                        
                        <div class="form-group" style="margin-bottom: 1rem;">
                            <label style="display: block; margin-bottom: 0.4rem; font-weight: 600; font-size: 0.95rem;">Pilih Poin <span style="color: #e74c3c;">*</span></label>
                            <select name="preset_key" id="whyChoosePreset" class="form-control" required style="width: 100%; padding: 0.65rem; border: 1px solid var(--admin-border); border-radius: 8px; font-size: 0.95rem; background: var(--admin-bg-secondary); color: var(--admin-text-primary);" onchange="updateWhyChoosePreview()">
                                <option value="" disabled selected>-- Pilih Keunggulan --</option>
                                <?php 
                                $presets = getWhyChoosePresets();
                                foreach ($presets as $key => $preset): 
                                ?>
                                <option value="<?= $key ?>" 
                                    data-title="<?= htmlspecialchars($preset['title']) ?>"
                                    data-desc="<?= htmlspecialchars($preset['description']) ?>"
                                    data-icon="<?= htmlspecialchars($preset['icon_class']) ?>">
                                    <?= htmlspecialchars($preset['title']) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Preview Section - More Compact -->
                        <div id="presetPreview" style="margin-bottom: 1rem; padding: 0.85rem; background: var(--admin-bg-secondary); border-radius: 10px; display: none; align-items: center; gap: 0.85rem; border: 1px dashed var(--admin-border);">
                            <div style="background: var(--admin-accent-peach); width: 42px; height: 42px; min-width: 42px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.3rem; flex-shrink: 0;">
                                <i id="previewIcon" class=""></i>
                            </div>
                            <div style="flex: 1;">
                                <h4 id="previewTitle" style="margin: 0 0 0.2rem 0; color: var(--admin-text-primary); font-size: 0.95rem;"></h4>
                                <p id="previewDesc" style="margin: 0; font-size: 0.82rem; color: var(--admin-text-secondary); line-height: 1.35;"></p>
                            </div>
                        </div>
                        
                        <div class="form-group" style="margin-bottom: 1rem;">
                            <label style="display: block; margin-bottom: 0.4rem; font-weight: 600; font-size: 0.95rem;">Deskripsi (Otomatis)</label>
                            <textarea name="description" id="whyChooseDescription" rows="2" style="width: 100%; padding: 0.65rem; border: 1px solid var(--admin-border); border-radius: 8px; font-size: 0.88rem; resize: none; background: var(--admin-bg-secondary); color: var(--admin-text-primary);"></textarea>
                            <small style="color: var(--admin-text-muted); font-size: 0.8rem;">Deskripsi terisi otomatis, dapat diubah.</small>
                        </div>

                        <div class="form-group" style="margin-bottom: 1.25rem;">
                            <label style="display: block; margin-bottom: 0.4rem; font-weight: 600; font-size: 0.95rem;">Urutan Tampil <span style="color: #e74c3c;">*</span></label>
                            <select name="sort_order" id="whyChooseSortOrder" required class="form-control" style="width: 100%; padding: 0.65rem; border: 1px solid var(--admin-border); border-radius: 8px; font-size: 0.95rem; background: var(--admin-bg-secondary); color: var(--admin-text-primary);">
                                <option value="1">1 - Urutan Pertama</option>
                                <option value="2">2 - Urutan Kedua</option>
                                <option value="3">3 - Urutan Ketiga</option>
                                <option value="4">4 - Urutan Keempat</option>
                            </select>
                            <small style="color: var(--admin-text-muted); display: block; margin-top: 0.35rem; font-size: 0.8rem; line-height: 1.4;">
                                💡 Urutan 1 = posisi pertama (paling kiri/atas)
                            </small>
                        </div>
                        
                        <div style="display: flex; gap: 0.75rem; padding-top: 0.5rem; border-top: 1px solid var(--admin-border);">
                            <button type="submit" class="btn btn-primary" style="flex: 1; padding: 0.75rem; font-size: 0.95rem;" onclick="return validateWhyChooseForm()">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                            <button type="button" class="btn btn-secondary" onclick="closeWhyChooseModal()" style="flex: 1; padding: 0.75rem; font-size: 0.95rem;">
                                <i class="fas fa-times"></i> Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- TAB 2: CARA PEMBAYARAN -->
            <div id="payment-steps-tab" class="transport-tab-content">
                <div class="section-card">
                    <div class="section-header">
                        <h2>Cara Pembayaran</h2>
                        <button class="btn btn-primary" onclick="openPaymentStepModal('add')">
                            <i class="fas fa-plus"></i> Tambah Langkah Baru
                        </button>
                    </div>

                    <!-- List dengan tabel yang lebih rapi -->
                    <div class="table-responsive" style="margin-top: 1.5rem;">
                        <table class="data-table" style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="background: var(--admin-bg-secondary); border-bottom: 2px solid var(--admin-border);">
                                    <th style="padding: 1rem; text-align: center; width: 100px; font-weight: 600;">Icon</th>
                                    <th style="padding: 1rem; text-align: left; font-weight: 600;">Judul</th>
                                    <th style="padding: 1rem; text-align: left; font-weight: 600;">Deskripsi</th>
                                    <th style="padding: 1rem; text-align: center; width: 100px; font-weight: 600;">Urutan</th>
                                    <th style="padding: 1rem; text-align: center; width: 100px; font-weight: 600;">Status</th>
                                    <th style="padding: 1rem; text-align: center; width: 150px; font-weight: 600;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($paymentSteps)): ?>
                                <tr>
                                    <td colspan="6" style="text-align: center; padding: 3rem; color: var(--admin-text-muted);">
                                        <i class="fas fa-inbox" style="font-size: 3rem; margin-bottom: 1rem; display: block; opacity: 0.5;"></i>
                                        <p style="margin: 0; font-size: 1.1rem;">Belum ada data</p>
                                        <p style="margin: 0.5rem 0 0 0; font-size: 0.9rem;">Klik "Tambah Langkah Baru" untuk menambahkan.</p>
                                    </td>
                                </tr>
                                <?php else: ?>
                                <?php foreach ($paymentSteps as $item): ?>
                                <tr style="border-bottom: 1px solid var(--admin-border); transition: background 0.2s;" onmouseover="this.style.background='var(--admin-bg-secondary)'" onmouseout="this.style.background='transparent'">
                                    <td style="padding: 1rem; text-align: center;">
                                        <?php if ($item['icon'] && (strpos($item['icon'], 'class:') === 0 || strpos($item['icon'], 'fa-') !== false || strpos($item['icon'], 'icon-') !== false)): ?>
                                            <?php 
                                            $iconClass = strpos($item['icon'], 'class:') === 0 ? substr($item['icon'], 6) : $item['icon'];
                                            ?>
                                            <i class="<?= htmlspecialchars($iconClass) ?>" style="font-size: 2rem; color: #D4956E;"></i>
                                        <?php elseif ($item['icon'] && file_exists($item['icon'])): ?>
                                        <img src="<?= htmlspecialchars($item['icon']) ?>?v=<?= time() ?>" alt="<?= htmlspecialchars($item['title']) ?>" 
                                             style="width: 40px; height: 40px; object-fit: contain;">
                                        <?php else: ?>
                                            <i class="fas fa-image" style="font-size: 2rem; color: var(--admin-text-muted); opacity: 0.3;"></i>
                                        <?php endif; ?>
                                    </td>
                                    <td style="padding: 1rem;">
                                        <strong style="color: var(--admin-text-primary); font-size: 1rem;"><?= htmlspecialchars($item['title']) ?></strong>
                                    </td>
                                    <td style="padding: 1rem; color: var(--admin-text-secondary); line-height: 1.5;">
                                        <?= htmlspecialchars(substr($item['description'], 0, 120)) ?><?= strlen($item['description']) > 120 ? '...' : '' ?>
                                    </td>
                                    <td style="padding: 1rem; text-align: center;">
                                        <span style="display: inline-block; background: var(--admin-bg-secondary); padding: 0.25rem 0.75rem; border-radius: 20px; font-weight: 600;">
                                            <?= $item['sort_order'] ?>
                                        </span>
                                    </td>
                                    <td style="padding: 1rem; text-align: center;">
                                        <span class="status-badge status-<?= $item['is_active'] ? 'active' : 'inactive' ?>" style="padding: 0.4rem 1rem; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">
                                            <?= $item['is_active'] ? '✓ Aktif' : '✗ Nonaktif' ?>
                                        </span>
                                    </td>
                                    <td style="padding: 1rem;">
                                        <div style="display: flex; gap: 8px; justify-content: center;">
                                            <button class="btn btn-small btn-primary" onclick="editPaymentStep(<?= $item['id'] ?>)" title="Edit" style="padding: 0.5rem 1rem;">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form method="POST" style="display: inline; margin: 0;" onsubmit="return showConfirm(event, 'Hapus Langkah Pembayaran?', 'Langkah \"<?= htmlspecialchars($item['title']) ?>\" akan dihapus secara permanen. Tindakan ini tidak dapat dibatalkan.')">
                                                <input type="hidden" name="action" value="delete">
                                                <input type="hidden" name="module" value="payment_steps">
                                                <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                                <button type="submit" class="btn btn-small btn-danger" title="Hapus" style="padding: 0.5rem 1rem;">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Modal Popup untuk Cara Pembayaran -->
            <div id="paymentStepModal" class="modal-overlay" style="display: none;">
                <div class="modal-content" style="max-width: 600px;">
                    <div class="modal-header">
                        <h3 id="paymentStepModalTitle">Tambah Langkah Baru</h3>
                        <button class="modal-close" onclick="closePaymentStepModal()">&times;</button>
                    </div>
                    <form id="paymentStepForm" method="POST" enctype="multipart/form-data" style="padding: 1.5rem;">
                        <input type="hidden" name="action" id="paymentStepAction" value="create">
                        <input type="hidden" name="module" value="payment_steps">
                        <input type="hidden" name="id" id="paymentStepId">
                        
                        <div class="form-group">
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Pilih Langkah Pembayaran <span style="color: #e74c3c;">*</span></label>
                            <select name="preset_key" id="paymentStepPreset" class="form-control" required style="width: 100%; padding: 0.75rem; border: 1px solid var(--admin-border); border-radius: 8px; font-size: 1rem; background: var(--admin-bg-secondary); color: var(--admin-text-primary);" onchange="updatePaymentStepPreview()">
                                <option value="" disabled selected>-- Pilih Langkah --</option>
                                <?php 
                                $paymentPresets = getPaymentPresets();
                                foreach ($paymentPresets as $key => $preset): 
                                ?>
                                <option value="<?= $key ?>" 
                                    data-title="<?= htmlspecialchars($preset['title']) ?>"
                                    data-desc="<?= htmlspecialchars($preset['description']) ?>"
                                    data-icon="<?= htmlspecialchars($preset['icon_class']) ?>">
                                    <?= htmlspecialchars($preset['title']) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                            <small style="color: var(--admin-text-muted); display: block; margin-top: 0.5rem;">Judul dan Icon akan otomatis disesuaikan.</small>
                        </div>
                        
                        <!-- Preview Section -->
                        <div id="paymentPresetPreview" style="margin-bottom: 1.5rem; padding: 1rem; background: var(--admin-bg-secondary); border-radius: 12px; display: none; align-items: center; gap: 1rem; border: 1px dashed var(--admin-border);">
                            <div style="background: var(--admin-accent-peach); width: 50px; height: 50px; min-width: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem; flex-shrink: 0; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                                <i id="paymentPreviewIcon" class=""></i>
                            </div>
                            <div style="flex: 1;">
                                <h4 id="paymentPreviewTitle" style="margin: 0 0 0.25rem 0; color: var(--admin-text-primary);"></h4>
                                <p id="paymentPreviewDesc" style="margin: 0; font-size: 0.9rem; color: var(--admin-text-secondary); line-height: 1.4;"></p>
                            </div>
                        </div>

                        <!-- Hidden Title Field (Optional, handled by backend from preset_key) -->
                        <!-- But to be safe if backend expects title in $_POST for other logic, we can keep hidden or just rely on backend -->
                        
                        <div class="form-group">
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Deskripsi <span style="color: #e74c3c;">*</span></label>
                            <textarea name="description" id="paymentStepDescription" required rows="4" placeholder="Jelaskan langkah pembayaran ini secara detail..." style="width: 100%; padding: 0.75rem; border: 1px solid var(--admin-border); border-radius: 8px; font-size: 1rem; resize: vertical;"></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Urutan Tampil</label>
                            <input type="number" name="sort_order" id="paymentStepSortOrder" value="0" min="0" style="width: 100%; padding: 0.75rem; border: 1px solid var(--admin-border); border-radius: 8px; font-size: 1rem;">
                            <small style="color: var(--admin-text-muted); display: block; margin-top: 0.5rem;">Semakin kecil angka, semakin atas urutannya</small>
                        </div>
                        
                        <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                            <button type="submit" class="btn btn-primary" style="flex: 1; padding: 0.875rem; font-size: 1rem;">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                            <button type="button" class="btn btn-secondary" onclick="closePaymentStepModal()" style="flex: 1; padding: 0.875rem; font-size: 1rem;">
                                <i class="fas fa-times"></i> Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- TAB 3: CARA MEMESAN -->
            <div id="order-steps-tab" class="transport-tab-content">
                <div class="section-card">
                    <div class="section-header">
                        <h2>Bagaimana Cara Memesan</h2>
                        <button class="btn btn-primary" onclick="openOrderStepModal('add')">
                            <i class="fas fa-plus"></i> Tambah Langkah Baru
                        </button>
                    </div>

                    <!-- List dengan tabel yang lebih rapi -->
                    <div class="table-responsive" style="margin-top: 1.5rem;">
                        <table class="data-table" style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="background: var(--admin-bg-secondary); border-bottom: 2px solid var(--admin-border);">
                                    <th style="padding: 1rem; text-align: center; width: 140px; font-weight: 600;">Foto</th>
                                    <th style="padding: 1rem; text-align: left; font-weight: 600;">Judul</th>
                                    <th style="padding: 1rem; text-align: left; font-weight: 600;">Deskripsi</th>
                                    <th style="padding: 1rem; text-align: center; width: 100px; font-weight: 600;">Urutan</th>
                                    <th style="padding: 1rem; text-align: center; width: 100px; font-weight: 600;">Status</th>
                                    <th style="padding: 1rem; text-align: center; width: 150px; font-weight: 600;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($orderSteps)): ?>
                                <tr>
                                    <td colspan="6" style="text-align: center; padding: 3rem; color: var(--admin-text-muted);">
                                        <i class="fas fa-inbox" style="font-size: 3rem; margin-bottom: 1rem; display: block; opacity: 0.5;"></i>
                                        <p style="margin: 0; font-size: 1.1rem;">Belum ada data</p>
                                        <p style="margin: 0.5rem 0 0 0; font-size: 0.9rem;">Klik "Tambah Langkah Baru" untuk menambahkan.</p>
                                    </td>
                                </tr>
                                <?php else: ?>
                                <?php foreach ($orderSteps as $item): ?>
                                <tr style="border-bottom: 1px solid var(--admin-border); transition: background 0.2s;" onmouseover="this.style.background='var(--admin-bg-secondary)'" onmouseout="this.style.background='transparent'">
                                    <td style="padding: 1rem; text-align: center;">
                                        <?php if ($item['image'] && file_exists($item['image'])): ?>
                                        <img src="<?= htmlspecialchars($item['image']) ?>?v=<?= time() ?>" alt="<?= htmlspecialchars($item['title']) ?>" 
                                             style="width: 120px; height: 80px; object-fit: cover; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                        <?php else: ?>
                                        <div style="width: 120px; height: 80px; display: flex; align-items: center; justify-content: center; background: var(--admin-bg-secondary); border-radius: 8px; margin: 0 auto;">
                                            <i class="fas fa-image" style="font-size: 1.5rem; color: var(--admin-text-muted); opacity: 0.5;"></i>
                                        </div>
                                        <?php endif; ?>
                                    </td>
                                    <td style="padding: 1rem;">
                                        <strong style="color: var(--admin-text-primary); font-size: 1rem;"><?= htmlspecialchars($item['title']) ?></strong>
                                    </td>
                                    <td style="padding: 1rem; color: var(--admin-text-secondary); line-height: 1.5;">
                                        <?= htmlspecialchars(substr($item['description'], 0, 120)) ?><?= strlen($item['description']) > 120 ? '...' : '' ?>
                                    </td>
                                    <td style="padding: 1rem; text-align: center;">
                                        <span style="display: inline-block; background: var(--admin-bg-secondary); padding: 0.25rem 0.75rem; border-radius: 20px; font-weight: 600;">
                                            <?= $item['sort_order'] ?>
                                        </span>
                                    </td>
                                    <td style="padding: 1rem; text-align: center;">
                                        <span class="status-badge status-<?= $item['is_active'] ? 'active' : 'inactive' ?>" style="padding: 0.4rem 1rem; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">
                                            <?= $item['is_active'] ? '✓ Aktif' : '✗ Nonaktif' ?>
                                        </span>
                                    </td>
                                    <td style="padding: 1rem;">
                                        <div style="display: flex; gap: 8px; justify-content: center;">
                                            <button class="btn btn-small btn-primary" onclick="editOrderStep(<?= $item['id'] ?>)" title="Edit" style="padding: 0.5rem 1rem;">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form method="POST" style="display: inline; margin: 0;" onsubmit="return showConfirm(event, 'Hapus Langkah Pemesanan?', 'Langkah \"<?= htmlspecialchars($item['title']) ?>\" akan dihapus secara permanen. Tindakan ini tidak dapat dibatalkan.')">
                                                <input type="hidden" name="action" value="delete">
                                                <input type="hidden" name="module" value="order_steps">
                                                <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                                <button type="submit" class="btn btn-small btn-danger" title="Hapus" style="padding: 0.5rem 1rem;">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Modal Popup untuk Cara Memesan -->
            <div id="orderStepModal" class="modal-overlay" style="display: none;">
                <div class="modal-content" style="max-width: 600px;">
                    <div class="modal-header">
                        <h3 id="orderStepModalTitle">Tambah Langkah Baru</h3>
                        <button class="modal-close" onclick="closeOrderStepModal()">&times;</button>
                    </div>
                    <form id="orderStepForm" method="POST" enctype="multipart/form-data" style="padding: 1.5rem;">
                        <input type="hidden" name="action" id="orderStepAction" value="create">
                        <input type="hidden" name="module" value="order_steps">
                        <input type="hidden" name="id" id="orderStepId">
                        
                        <div class="form-group">
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Foto Langkah <span style="color: #e74c3c; font-size: 0.9rem;">(Opsional)</span></label>
                            <div id="currentOrderImagePreview" style="margin-bottom: 1rem; display: none;">
                                <img id="currentOrderImage" src="" alt="Current Image" style="width: 200px; height: auto; object-fit: cover; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                                <p style="margin: 0.5rem 0; font-size: 0.85rem; color: var(--admin-text-muted);">Foto saat ini</p>
                            </div>
                            <input type="file" name="image" id="orderStepImage" accept="image/*" style="width: 100%; padding: 0.75rem; border: 2px dashed var(--admin-border); border-radius: 8px; background: var(--admin-bg-secondary);">
                            <small style="color: var(--admin-text-muted); display: block; margin-top: 0.5rem;">Format: JPG, PNG • Maksimal 5MB</small>
                        </div>
                        
                        <div class="form-group">
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Judul Langkah <span style="color: #e74c3c;">*</span></label>
                            <input type="text" name="title" id="orderStepTitle" required placeholder="Contoh: Pilih Layanan" style="width: 100%; padding: 0.75rem; border: 1px solid var(--admin-border); border-radius: 8px; font-size: 1rem;">
                        </div>
                        
                        <div class="form-group">
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Deskripsi <span style="color: #e74c3c;">*</span></label>
                            <textarea name="description" id="orderStepDescription" required rows="4" placeholder="Jelaskan langkah pemesanan ini secara detail..." style="width: 100%; padding: 0.75rem; border: 1px solid var(--admin-border); border-radius: 8px; font-size: 1rem; resize: vertical;"></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Urutan Tampil</label>
                            <input type="number" name="sort_order" id="orderStepSortOrder" value="0" min="0" style="width: 100%; padding: 0.75rem; border: 1px solid var(--admin-border); border-radius: 8px; font-size: 1rem;">
                            <small style="color: var(--admin-text-muted); display: block; margin-top: 0.5rem;">Semakin kecil angka, semakin atas urutannya</small>
                        </div>
                        
                        <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                            <button type="submit" class="btn btn-primary" style="flex: 1; padding: 0.875rem; font-size: 1rem;">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                            <button type="button" class="btn btn-secondary" onclick="closeOrderStepModal()" style="flex: 1; padding: 0.875rem; font-size: 1rem;">
                                <i class="fas fa-times"></i> Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- TAB 4: GALERI BERANDA -->
            <div id="gallery-home-tab" class="transport-tab-content">
                <div class="section-card">
                    <div class="section-header">
                        <h2>Galeri Perjalanan (Tampil di Beranda)</h2>
                        <button class="btn btn-primary" onclick="showAddGalleryHomeForm()" 
                                <?= getGalleryHomeSelectionCount() >= 3 ? 'disabled title="Maksimal 3 foto"' : '' ?>>
                            <i class="fas fa-plus"></i> Pilih Foto (Maks 3)
                        </button>
                    </div>

                    <?php if (getGalleryHomeSelectionCount() >= 3): ?>
                    <div style="padding: 1rem; background: #fff3cd; border: 1px solid #ffc107; border-radius: 8px; margin-bottom: 1rem; color: #856404;">
                        <i class="fas fa-exclamation-triangle"></i> <strong>Batas Tercapai:</strong> Maksimal hanya 3 foto yang dapat ditampilkan di beranda. Hapus salah satu untuk menambah foto baru.
                    </div>
                    <?php endif; ?>

                    <!-- Add Form -->
                    <div id="add-gallery-home-form" style="display: none; margin-bottom: 2rem; padding: 1.5rem; background: var(--admin-bg-secondary); border-radius: 12px;">
                        <h3 style="margin-bottom: 1rem; color: var(--admin-text-primary);">Pilih Foto dari Galeri</h3>
                        <form method="POST">
                            <input type="hidden" name="action" value="create">
                            <input type="hidden" name="module" value="gallery_home">
                            
                            <div class="form-group">
                                <label>Pilih Foto *</label>
                                <select name="gallery_id" required style="width: 100%; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--admin-border);">
                                    <option value="">-- Pilih Foto --</option>
                                    <?php foreach ($availableGallery as $gal): ?>
                                    <option value="<?= $gal['id'] ?>"><?= htmlspecialchars($gal['title']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label>Deskripsi Foto *</label>
                                <textarea name="description" required rows="2" placeholder="Deskripsi singkat untuk foto ini..."></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label>Urutan Tampil</label>
                                <input type="number" name="sort_order" value="<?= getMaxSortOrder('gallery_home_selection') ?>" min="0">
                            </div>
                            
                            <div style="display: flex; gap: 1rem;">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Simpan
                                </button>
                                <button type="button" class="btn btn-secondary" onclick="hideAddGalleryHomeForm()">
                                    <i class="fas fa-times"></i> Batal
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- List -->
                    <div class="gallery-grid">
                        <?php if (empty($galleryHomeSelection)): ?>
                        <div style="grid-column: 1/-1; text-align: center; padding: 3rem; color: var(--admin-text-muted);">
                            <i class="fas fa-images" style="font-size: 4rem; margin-bottom: 1rem; display: block;"></i>
                            <p>Belum ada foto dipilih untuk beranda. Pilih maksimal 3 foto dari galeri.</p>
                        </div>
                        <?php else: ?>
                        <?php foreach ($galleryHomeSelection as $item): ?>
                        <div class="gallery-item">
                            <div style="position: relative;">
                                <?php if ($item['image_path'] && file_exists($item['image_path'])): ?>
                                <img src="<?= htmlspecialchars($item['image_path']) ?>" alt="<?= htmlspecialchars($item['title']) ?>" 
                                     style="width: 100%; height: 200px; object-fit: cover; border-radius: 8px 8px 0 0;">
                                <?php else: ?>
                                <div style="width: 100%; height: 200px; background: #f8f9fa; display: flex; align-items: center; justify-content: center; border-radius: 8px 8px 0 0;">
                                    <i class="fas fa-image" style="font-size: 3rem; color: #dee2e6;"></i>
                                </div>
                                <?php endif; ?>
                            </div>
                            <div style="padding: 1rem;">
                                <h4 style="margin: 0 0 0.5rem 0; font-size: 1rem; color: var(--admin-text-primary);">
                                    <?= htmlspecialchars($item['title']) ?>
                                </h4>
                                <p style="margin: 0 0 1rem 0; font-size: 0.85rem; color: var(--admin-text-muted);">
                                    <?= htmlspecialchars($item['description']) ?>
                                </p>
                                <div style="display: flex; gap: 8px; justify-content: space-between; align-items: center;">
                                    <span style="font-size: 0.8rem; color: var(--admin-text-muted);">Urutan: <?= $item['sort_order'] ?></span>
                                    <form method="POST" style="display: inline;" onsubmit="return showConfirm(event, 'Hapus Foto dari Beranda?', 'Foto ini akan dihapus dari galeri beranda. Tindakan ini tidak dapat dibatalkan.')">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="module" value="gallery_home">
                                        <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                        <button type="submit" class="btn btn-small btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </div>



        <!-- ============================================ -->
        <!-- MANAJEMEN TRANSPORTASI SECTION -->
        <!-- ============================================ -->
        <div id="transportasi-section" class="content-section">
            <h1>Manajemen Layanan Transportasi</h1>
            <p>Kelola data pesawat, kapal, dan bus yang tersedia untuk pemesanan pelanggan</p>
            
            <!-- Transport Type Tabs -->
            <div class="transport-tabs" style="margin-bottom: 30px;">
                <button class="tab-btn active" data-tab="pesawat">
                    <i class="fas fa-plane"></i> Pesawat
                </button>
                <button class="tab-btn" data-tab="kapal">
                    <i class="fas fa-ship"></i> Kapal
                </button>
                <button class="tab-btn" data-tab="bus">
                    <i class="fas fa-bus"></i> Bus
                </button>
            </div>

            <!-- Pesawat Tab -->
            <div id="pesawat-tab" class="transport-tab-content active">
                <div class="section-card">
                    <div class="section-header">
                        <h2>Manajemen Data Pesawat</h2>
                        <div style="display: flex; gap: 12px; align-items: center;">
                            <div class="search-box" style="position: relative;">
                                <i class="fas fa-search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--admin-text-muted);"></i>
                                <input type="text" id="search-pesawat" placeholder="Cari nama maskapai..." 
                                       style="padding: 10px 12px 10px 40px; border-radius: 12px; border: 1px solid var(--admin-border); background: var(--admin-card-primary); color: var(--admin-text-primary); width: 280px; font-size: 0.9rem;"
                                       oninput="searchTransport('pesawat', this.value)">
                            </div>
                            <button class="btn btn-primary" onclick="showAddTransportForm('pesawat')">
                                <i class="fas fa-plus"></i> Tambah Pesawat
                            </button>
                        </div>
                    </div>
                    <div class="section-content">
                        <?php 
                        $pesawatServices = array_filter($transportServices, function($s) {
                            return $s['transport_type'] === 'pesawat';
                        });
                        ?>
                        <?php if (empty($pesawatServices)): ?>
                        <div style="text-align: center; padding: 3rem; color: var(--admin-text-muted);">
                            <i class="fas fa-box-open" style="font-size: 3rem; margin-bottom: 15px; display: block; opacity: 0.3;"></i>
                            Belum ada layanan Pesawat
                        </div>
                        <?php else: ?>
                        <div class="transport-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem;">
                            <?php foreach ($pesawatServices as $service): ?>
                            <?php 
                            // Fix logo path: add 'uploads/' prefix if not present
                            $logoPath = '';
                            if (!empty($service['logo'])) {
                                $logoPath = $service['logo'];
                                if (strpos($logoPath, 'uploads/') !== 0) {
                                    $logoPath = 'uploads/' . $logoPath;
                                }
                            }
                            ?>
                            <div class="transport-card">
                                <div class="transport-card-header">
                                    <?php if ($logoPath): ?>
                                    <img src="<?= $logoPath ?>" alt="<?= htmlspecialchars($service['name']) ?>" class="transport-logo" onerror="this.parentElement.innerHTML='<div class=\'transport-logo\' style=\'display: flex; align-items: center; justify-content: center; background: var(--admin-accent-peach); color: white;\'><i class=\'fas fa-plane\' style=\'font-size: 1.5rem;\'></i></div>';">
                                    <?php else: ?>
                                    <div class="transport-logo" style="display: flex; align-items: center; justify-content: center; background: var(--admin-accent-peach); color: white;">
                                        <i class="fas fa-plane" style="font-size: 1.5rem;"></i>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <div class="transport-info">
                                        <h3>
                                            <?= htmlspecialchars($service['name']) ?>
                                            <?php if (!$service['is_active']): ?>
                                            <span class="badge badge-warning">Tidak Aktif</span>
                                            <?php endif; ?>
                                        </h3>
                                        <p><?= htmlspecialchars($service['route']) ?></p>
                                    </div>
                                </div>
                                
                                <div class="transport-price">
                                    <?= htmlspecialchars($service['price']) ?>
                                </div>
                                
                                <div class="transport-actions">
                                    <button onclick='editTransportFromDB(<?= json_encode($service) ?>)' class="btn btn-secondary">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <form method="POST" style="display: inline;" 
                                          onsubmit="return confirm('Yakin ingin menghapus layanan ini?')">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="module" value="transport">
                                        <input type="hidden" name="id" value="<?= $service['id'] ?>">
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Kapal Tab -->
            <div id="kapal-tab" class="transport-tab-content">
                <div class="section-card">
                    <div class="section-header">
                        <h2>Manajemen Data Kapal</h2>
                        <div style="display: flex; gap: 12px; align-items: center;">
                            <div class="search-box" style="position: relative;">
                                <i class="fas fa-search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--admin-text-muted);"></i>
                                <input type="text" id="search-kapal" placeholder="Cari nama kapal..." 
                                       style="padding: 10px 12px 10px 40px; border-radius: 12px; border: 1px solid var(--admin-border); background: var(--admin-card-primary); color: var(--admin-text-primary); width: 280px; font-size: 0.9rem;"
                                       oninput="searchTransport('kapal', this.value)">
                            </div>
                            <button class="btn btn-primary" onclick="showAddTransportForm('kapal')">
                                <i class="fas fa-plus"></i> Tambah Kapal
                            </button>
                        </div>
                    </div>
                    <div class="section-content">
                        <?php 
                        $kapalServices = array_filter($transportServices, function($s) {
                            return $s['transport_type'] === 'kapal';
                        });
                        ?>
                        <?php if (empty($kapalServices)): ?>
                        <div style="text-align: center; padding: 3rem; color: var(--admin-text-muted);">
                            <i class="fas fa-box-open" style="font-size: 3rem; margin-bottom: 15px; display: block; opacity: 0.3;"></i>
                            Belum ada layanan Kapal
                        </div>
                        <?php else: ?>
                        <div class="transport-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem;">
                            <?php foreach ($kapalServices as $service): ?>
                            <?php 
                            // Fix logo path: add 'uploads/' prefix if not present
                            $logoPath = '';
                            if (!empty($service['logo'])) {
                                $logoPath = $service['logo'];
                                if (strpos($logoPath, 'uploads/') !== 0) {
                                    $logoPath = 'uploads/' . $logoPath;
                                }
                            }
                            ?>
                            <div class="transport-card">
                                <div class="transport-card-header">
                                    <?php if ($logoPath): ?>
                                    <img src="<?= $logoPath ?>" alt="<?= htmlspecialchars($service['name']) ?>" class="transport-logo" onerror="this.parentElement.innerHTML='<div class=\'transport-logo\' style=\'display: flex; align-items: center; justify-content: center; background: var(--admin-accent-peach); color: white;\'><i class=\'fas fa-ship\' style=\'font-size: 1.5rem;\'></i></div>';">
                                    <?php else: ?>
                                    <div class="transport-logo" style="display: flex; align-items: center; justify-content: center; background: var(--admin-accent-peach); color: white;">
                                        <i class="fas fa-ship" style="font-size: 1.5rem;"></i>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <div class="transport-info">
                                        <h3>
                                            <?= htmlspecialchars($service['name']) ?>
                                            <?php if (!$service['is_active']): ?>
                                            <span class="badge badge-warning">Tidak Aktif</span>
                                            <?php endif; ?>
                                        </h3>
                                        <p><?= htmlspecialchars($service['route']) ?></p>
                                    </div>
                                </div>
                                
                                <div class="transport-price">
                                    <?= htmlspecialchars($service['price']) ?>
                                </div>
                                
                                <div class="transport-actions">
                                    <button onclick='editTransportFromDB(<?= json_encode($service) ?>)' class="btn btn-secondary">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <form method="POST" style="display: inline;" 
                                          onsubmit="return confirm('Yakin ingin menghapus layanan ini?')">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="module" value="transport">
                                        <input type="hidden" name="id" value="<?= $service['id'] ?>">
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Bus Tab -->
            <div id="bus-tab" class="transport-tab-content">
                <div class="section-card">
                    <div class="section-header">
                        <h2>Manajemen Data Bus</h2>
                        <div style="display: flex; gap: 12px; align-items: center;">
                            <div class="search-box" style="position: relative;">
                                <i class="fas fa-search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--admin-text-muted);"></i>
                                <input type="text" id="search-bus" placeholder="Cari nama bus..." 
                                       style="padding: 10px 12px 10px 40px; border-radius: 12px; border: 1px solid var(--admin-border); background: var(--admin-card-primary); color: var(--admin-text-primary); width: 280px; font-size: 0.9rem;"
                                       oninput="searchTransport('bus', this.value)">
                            </div>
                            <button class="btn btn-primary" onclick="showAddTransportForm('bus')">
                                <i class="fas fa-plus"></i> Tambah Bus
                            </button>
                        </div>
                    </div>
                    <div class="section-content">
                        <?php 
                        $busServices = array_filter($transportServices, function($s) {
                            return $s['transport_type'] === 'bus';
                        });
                        ?>
                        <?php if (empty($busServices)): ?>
                        <div style="text-align: center; padding: 3rem; color: var(--admin-text-muted);">
                            <i class="fas fa-box-open" style="font-size: 3rem; margin-bottom: 15px; display: block; opacity: 0.3;"></i>
                            Belum ada layanan Bus
                        </div>
                        <?php else: ?>
                        <div class="transport-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem;">
                            <?php foreach ($busServices as $service): ?>
                            <?php 
                            // Fix logo path: add 'uploads/' prefix if not present
                            $logoPath = '';
                            if (!empty($service['logo'])) {
                                $logoPath = $service['logo'];
                                if (strpos($logoPath, 'uploads/') !== 0) {
                                    $logoPath = 'uploads/' . $logoPath;
                                }
                            }
                            ?>
                            <div class="transport-card">
                                <div class="transport-card-header">
                                    <?php if ($logoPath): ?>
                                    <img src="<?= $logoPath ?>" alt="<?= htmlspecialchars($service['name']) ?>" class="transport-logo" onerror="this.parentElement.innerHTML='<div class=\'transport-logo\' style=\'display: flex; align-items: center; justify-content: center; background: var(--admin-accent-peach); color: white;\'><i class=\'fas fa-bus\' style=\'font-size: 1.5rem;\'></i></div>';">
                                    <?php else: ?>
                                    <div class="transport-logo" style="display: flex; align-items: center; justify-content: center; background: var(--admin-accent-peach); color: white;">
                                        <i class="fas fa-bus" style="font-size: 1.5rem;"></i>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <div class="transport-info">
                                        <h3>
                                            <?= htmlspecialchars($service['name']) ?>
                                            <?php if (!$service['is_active']): ?>
                                            <span class="badge badge-warning">Tidak Aktif</span>
                                            <?php endif; ?>
                                        </h3>
                                        <p><?= htmlspecialchars($service['route']) ?></p>
                                    </div>
                                </div>
                                
                                <div class="transport-price">
                                    <?= htmlspecialchars($service['price']) ?>
                                </div>
                                
                                <div class="transport-actions">
                                    <button onclick='editTransportFromDB(<?= json_encode($service) ?>)' class="btn btn-secondary">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <form method="POST" style="display: inline;" 
                                          onsubmit="return confirm('Yakin ingin menghapus layanan ini?')">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="module" value="transport">
                                        <input type="hidden" name="id" value="<?= $service['id'] ?>">
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Form Modal untuk Tambah/Edit Transport -->
            <div id="transport-modal" class="modal" style="display: none;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 id="modal-title">Tambah Data Transportasi</h3>
                        <span class="modal-close" onclick="closeTransportModal()">&times;</span>
                    </div>
                    <div class="modal-body">
                        <form id="transport-form" method="POST" enctype="multipart/form-data" action="admin.php#transportasi">
                            <input type="hidden" name="action" value="add">
                            <input type="hidden" name="module" value="transport">
                            <input type="hidden" id="transport-id" name="id">
                            <input type="hidden" id="transport-type" name="transport_type">
                            
                            <div class="form-group">
                                <label for="transport-name">Nama Transportasi</label>
                                <input type="text" id="transport-name" name="name" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="transport-route">Deskripsi/Rute</label>
                                <textarea id="transport-route" name="route" rows="3" required></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label for="transport-price">Harga</label>
                                <input type="text" id="transport-price" name="price" placeholder="Contoh: Rp 450.000 - Rp 850.000" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="transport-logo">Logo/Gambar</label>
                                <input type="file" id="transport-logo" name="logo" accept="image/*">
                                <div id="current-logo" style="margin-top: 10px;"></div>
                                <small style="color: var(--admin-text-secondary); font-size: 0.85rem;">
                                    Upload file baru untuk mengganti logo. File lama akan otomatis terhapus.
                                </small>
                            </div>
                            
                            <div class="form-group">
                                <label>
                                    <input type="checkbox" name="is_active" id="transport-active" checked> Aktif
                                </label>
                            </div>
                            
                            <div class="form-actions">
                                <button type="button" class="btn btn-secondary" onclick="closeTransportModal()">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- ============================================ -->
        <!-- GALERI SECTION -->
        <!-- ============================================ -->
        <div id="galeri-section" class="content-section">
            <h1>Kelola Galeri</h1>
            <p>Tambah, edit, atau hapus foto dalam galeri website</p>
            
            <!-- Modal Galeri -->
            <div id="galleryModal" class="modal" style="display: none;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 id="galleryModalTitle">Tambah Foto Galeri</h2>
                        <span class="close" onclick="closeGalleryModal()">&times;</span>
                    </div>
                    <form id="galleryForm" method="POST" enctype="multipart/form-data" action="admin.php#galeri">
                        <input type="hidden" name="action" id="galleryAction" value="add">
                        <input type="hidden" name="module" value="gallery">
                        <input type="hidden" name="id" id="galleryId">
                        
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="gallery_title">Judul Foto *</label>
                                <input type="text" id="gallery_title" name="title" required 
                                       placeholder="Contoh: Pemandangan Pantai Bali">
                            </div>
                            
                            <div class="form-group">
                                <label for="gallery_description">Deskripsi</label>
                                <textarea id="gallery_description" name="description" rows="3"
                                          placeholder="Deskripsi singkat tentang foto ini"></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label for="gallery_image">Upload Foto <span id="galleryImageLabel">*</span></label>
                                <input type="file" id="gallery_image" name="image" accept="image/*">
                                <small style="color: #6c757d; display: block; margin-top: 5px;">
                                    Format: JPG, PNG, GIF. Max 5MB
                                </small>
                                <div id="currentGalleryImage" style="margin-top: 10px; display: none;">
                                    <label>Foto Saat Ini:</label>
                                    <img id="previewGalleryImage" src="" alt="Preview" 
                                         style="max-width: 200px; max-height: 150px; display: block; margin-top: 5px; border-radius: 4px;">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="gallery_category">Kategori *</label>
                                <select id="gallery_category" name="category" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <option value="kantor">Kantor</option>
                                    <option value="fasilitas">Fasilitas</option>
                                    <option value="layanan">Layanan</option>
                                </select>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group" style="flex: 1;">
                                    <label for="gallery_display_order">Urutan Tampil</label>
                                    <input type="number" id="gallery_display_order" name="display_order" 
                                           value="0" min="0" placeholder="0">
                                    <small style="color: #6c757d;">Semakin kecil, semakin di depan</small>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                                    <input type="checkbox" id="gallery_is_featured" name="is_featured" value="1">
                                    <span>Tandai sebagai Foto Unggulan</span>
                                </label>
                            </div>
                        
                            <div class="form-group">
                                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                                    <input type="checkbox" id="gallery_is_active" name="is_active" value="1" checked>
                                    <span>Aktif (Tampilkan di Website)</span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" onclick="closeGalleryModal()">
                                <i class="fas fa-times"></i> Batal
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Daftar Galeri -->
            <div class="section-card">
                <div class="section-header">
                    <h2>Daftar Foto Galeri</h2>
                    <div style="display: flex; align-items: center; gap: 16px;">
                        <!-- Search Box untuk Galeri -->
                        <div style="position: relative;">
                            <i class="fas fa-search" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--admin-text-muted); font-size: 0.9rem;"></i>
                            <input 
                                type="text" 
                                id="searchGallery" 
                                placeholder="Cari judul foto..." 
                                oninput="searchGallery(this.value)"
                                style="width: 280px; padding: 10px 16px 10px 38px; border: 1px solid var(--admin-border); border-radius: 12px; background: var(--admin-bg-dark); color: var(--admin-text-primary); font-size: 0.9rem;">
                        </div>
                        <button class="btn btn-primary" onclick="openGalleryModal()">
                            <i class="fas fa-plus"></i> Tambah Foto
                        </button>
                    </div>
                </div>
                <div class="section-content">
                    <?php $galleries = getAllGallery(); ?>
                    <div class="gallery-grid">
                        <?php if (empty($galleries)): ?>
                        <div style="grid-column: 1 / -1; text-align: center; padding: 2rem; color: #6c757d;">
                            <i class="fas fa-images" style="font-size: 3rem; margin-bottom: 15px; display: block; color: #dee2e6;"></i>
                            Belum ada foto di galeri. Silakan tambahkan foto pertama.
                        </div>
                        <?php else: ?>
                        <?php foreach ($galleries as $gallery): 
                            // Fix image path
                            $imagePath = $gallery['image'];
                            if (!empty($imagePath) && strpos($imagePath, 'uploads/') !== 0) {
                                $imagePath = 'uploads/' . $imagePath;
                            }
                        ?>
                        <div class="gallery-item">
                            <div style="position: relative;">
                                <?php if (!empty($imagePath) && file_exists($imagePath)): ?>
                                <img src="<?= htmlspecialchars($imagePath) ?>" 
                                     alt="<?= htmlspecialchars($gallery['title']) ?>"
                                     style="width: 100%; height: 180px; object-fit: cover; border-radius: 8px 8px 0 0;">
                                <?php else: ?>
                                <div style="width: 100%; height: 180px; background: #f8f9fa; display: flex; align-items: center; justify-content: center; border-radius: 8px 8px 0 0;">
                                    <i class="fas fa-image" style="font-size: 2.5rem; color: #dee2e6;"></i>
                                </div>
                                <?php endif; ?>
                                
                                <?php if ($gallery['is_featured']): ?>
                                <span class="badge badge-warning" style="position: absolute; top: 10px; right: 10px;">
                                    <i class="fas fa-star"></i> UNGGULAN
                                </span>
                                <?php endif; ?>
                            </div>
                            
                            <div class="gallery-info">
                                <h4><?= htmlspecialchars($gallery['title']) ?></h4>
                                
                                <?php if ($gallery['description']): ?>
                                <p><?= htmlspecialchars(truncateText($gallery['description'], 85)) ?></p>
                                <?php endif; ?>
                                
                                <div class="gallery-actions">
                                    <div>
                                        <span class="badge badge-info"><?= htmlspecialchars($gallery['category']) ?></span>
                                        <?php if (!$gallery['is_active']): ?>
                                        <span class="badge badge-danger">Tidak Aktif</span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <div style="display: flex; gap: 5px;">
                                        <button onclick='editGalleryModal(<?= json_encode($gallery) ?>)' class="btn btn-secondary" 
                                                style="padding: 6px 10px; font-size: 0.75rem;">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form method="POST" style="display: inline;" 
                                              onsubmit="return showConfirm(event, 'Hapus Foto Galeri?', 'Foto ini akan dihapus secara permanen dari galeri. Tindakan ini tidak dapat dibatalkan.')">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="module" value="gallery">
                                            <input type="hidden" name="id" value="<?= $gallery['id'] ?>">
                                            <button type="submit" class="btn btn-danger" style="padding: 6px 10px; font-size: 0.75rem;">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- ============================================ -->
        <!-- KONTAK SECTION -->
        <!-- ============================================ -->
        <div id="kontak-section" class="content-section">
            <h1>Informasi Kontak</h1>
            <p>Kelola informasi kontak yang ditampilkan di website</p>
            
            <div class="section-card">
                <div class="section-header">
                    <h2>Edit Informasi Kontak</h2>
                </div>
                <div class="section-content">
                    <form method="POST">
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="module" value="contact">
                        
                        <!-- 2 COLUMN GRID LAYOUT -->
                        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 3rem; position: relative;">
                            <!-- Vertical Divider Line -->
                            <div style="position: absolute; left: 50%; top: 0; bottom: 0; width: 1px; background: var(--admin-border); transform: translateX(-50%);"></div>
                            
                            <!-- LEFT COLUMN -->
                            <div style="display: flex; flex-direction: column; gap: 1.5rem; position: relative; z-index: 1;">
                                <div class="form-group-horizontal" style="margin-bottom: 0;">
                                    <label>WhatsApp</label>
                                    <div class="form-input-wrapper">
                                        <input type="text" name="whatsapp" value="<?= htmlspecialchars($contactInfo['whatsapp'] ?? '') ?>" required placeholder="628XXXXXXXXXX">
                                        <small style="color: var(--admin-text-muted); display: block; margin-top: 0.5rem;">Format: 628XXXXXXXXXX (tanpa +)</small>
                                    </div>
                                </div>
                                
                                <div class="form-group-horizontal" style="margin-bottom: 0;">
                                    <label>Email</label>
                                    <div class="form-input-wrapper">
                                        <input type="email" name="email" value="<?= htmlspecialchars($contactInfo['email'] ?? '') ?>" required>
                                    </div>
                                </div>
                                
                                <div class="form-group-horizontal" style="margin-bottom: 0;">
                                    <label>Alamat Kantor</label>
                                    <div class="form-input-wrapper">
                                        <textarea name="address" rows="4" required><?= htmlspecialchars($contactInfo['address'] ?? '') ?></textarea>
                                    </div>
                                </div>
                                
                                <div class="form-group-horizontal" style="margin-bottom: 0;">
                                    <label>Jam Operasional</label>
                                    <div class="form-input-wrapper">
                                        <input type="text" name="hours" value="<?= htmlspecialchars($contactInfo['hours'] ?? '') ?>" required placeholder="Senin - Minggu: 08.00 - 22.00 WIB">
                                        <small style="color: var(--admin-text-muted); display: block; margin-top: 0.5rem;">Tampil di Footer dan Halaman Kontak</small>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- RIGHT COLUMN -->
                            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                                <div class="form-group-horizontal" style="margin-bottom: 0;">
                                    <label>Instagram</label>
                                    <div class="form-input-wrapper">
                                        <input type="text" name="instagram" value="<?= htmlspecialchars($contactInfo['instagram'] ?? '') ?>" required placeholder="@username atau username">
                                        <small style="color: var(--admin-text-muted); display: block; margin-top: 0.5rem;">Contoh: cendanatravel atau @cendanatravel</small>
                                    </div>
                                </div>
                                
                                <div class="form-group-horizontal" style="margin-bottom: 0;">
                                    <label>TikTok</label>
                                    <div class="form-input-wrapper">
                                        <input type="text" name="tiktok" value="<?= htmlspecialchars($contactInfo['tiktok'] ?? '') ?>" placeholder="@username atau username (opsional)">
                                        <small style="color: var(--admin-text-muted); display: block; margin-top: 0.5rem;">Contoh: cendanatravel atau @cendanatravel</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- SUBMIT BUTTON -->
                        <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--admin-border);">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- ============================================ -->
        <!-- FAQ SECTION -->
        <!-- ============================================ -->
        <div id="faq-section" class="content-section">
            <h1>Kelola FAQ</h1>
            <p>Tambah, edit, atau hapus pertanyaan yang sering ditanyakan</p>
            
            <!-- Modal FAQ -->
            <div id="faqModal" class="modal" style="display: none;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 id="faqModalTitle">Tambah FAQ Baru</h2>
                        <span class="close" onclick="closeFAQModal()">&times;</span>
                    </div>
                    <form id="faqForm" method="POST" action="admin.php#faq">
                        <input type="hidden" name="action" id="faqAction" value="add">
                        <input type="hidden" name="module" value="faq">
                        <input type="hidden" name="id" id="faqId">
                        
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="faq_question">Pertanyaan *</label>
                                <textarea id="faq_question" name="question" rows="2" required 
                                          placeholder="Tulis pertanyaan yang sering ditanyakan..."></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label for="faq_answer">Jawaban *</label>
                                <textarea id="faq_answer" name="answer" rows="4" required 
                                          placeholder="Tulis jawaban lengkap dan jelas..."></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label for="faq_category">Kategori *</label>
                                <select id="faq_category" name="category" required>
                                    <option value="Umum">Umum</option>
                                    <option value="Pemesanan">Pemesanan</option>
                                    <option value="Pembayaran">Pembayaran</option>
                                    <option value="Pembatalan">Pembatalan</option>
                                    <option value="Layanan">Layanan</option>
                                </select>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group" style="flex: 1;">
                                    <label for="faq_display_order">Urutan Tampil</label>
                                    <input type="number" id="faq_display_order" name="display_order" 
                                           value="0" min="0" placeholder="0">
                                    <small style="color: #6c757d;">Semakin kecil, semakin di atas</small>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                                    <input type="checkbox" id="faq_is_active" name="is_active" value="1" checked>
                                    <span>Aktif (Tampilkan di Website)</span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" onclick="closeFAQModal()">
                                <i class="fas fa-times"></i> Batal
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Daftar FAQ -->
            <div class="section-card">
                <div class="section-header">
                    <h2>Daftar FAQ</h2>
                    <div style="display: flex; align-items: center; gap: 16px;">
                        <!-- Search Box untuk FAQ -->
                        <div style="position: relative;">
                            <i class="fas fa-search" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--admin-text-muted); font-size: 0.9rem;"></i>
                            <input 
                                type="text" 
                                id="searchFAQ" 
                                placeholder="Cari pertanyaan..." 
                                oninput="searchFAQ(this.value)"
                                style="width: 280px; padding: 10px 16px 10px 38px; border: 1px solid var(--admin-border); border-radius: 12px; background: var(--admin-bg-dark); color: var(--admin-text-primary); font-size: 0.9rem;">
                        </div>
                        <button class="btn btn-primary" onclick="openFAQModal()">
                            <i class="fas fa-plus"></i> Tambah FAQ
                        </button>
                    </div>
                </div>
                <div class="section-content">
                    <?php $faqs = getAllFAQ(); ?>
                    <?php if (empty($faqs)): ?>
                    <div style="text-align: center; padding: 3rem; color: #6c757d;">
                        <i class="fas fa-question-circle" style="font-size: 3rem; margin-bottom: 15px; display: block; color: #dee2e6;"></i>
                        Belum ada FAQ. Silakan tambahkan pertanyaan pertama.
                    </div>
                    <?php else: ?>
                    <!-- 3 COLUMN GRID LAYOUT -->
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.25rem;">
                        <?php foreach ($faqs as $faq): ?>
                        <div class="faq-item" style="background: var(--admin-card-primary); border: 1px solid var(--admin-border); border-radius: 12px; padding: 1.25rem; transition: all 0.3s ease; display: flex; flex-direction: column; height: 100%;">
                            <div style="display: flex; flex-direction: column; gap: 0.75rem; flex: 1;">
                                <!-- Question Header -->
                                <div style="display: flex; align-items: start; gap: 8px;">
                                    <i class="fas fa-question-circle" style="color: var(--admin-accent-purple); font-size: 1.1rem; margin-top: 2px; flex-shrink: 0;"></i>
                                    <h4 style="margin: 0; color: var(--admin-text-primary); font-size: 0.95rem; font-weight: 600; line-height: 1.4; flex: 1;">
                                        <?= htmlspecialchars($faq['question']) ?>
                                    </h4>
                                </div>
                                
                                <!-- Category Badges -->
                                <div style="display: flex; flex-wrap: wrap; gap: 5px;">
                                    <span class="badge badge-info" style="font-size: 0.7rem;"><?= htmlspecialchars($faq['category']) ?></span>
                                    <span class="badge badge-secondary" style="font-size: 0.7rem;">Urutan: <?= $faq['display_order'] ?></span>
                                    <?php if (!$faq['is_active']): ?>
                                    <span class="badge badge-danger" style="font-size: 0.7rem;">Tidak Aktif</span>
                                    <?php else: ?>
                                    <span class="badge badge-success" style="font-size: 0.7rem;">Aktif</span>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Answer -->
                                <div style="padding: 0.75rem; background: rgba(212, 149, 110, 0.08); border-left: 3px solid var(--admin-accent-peach); border-radius: 6px; flex: 1;">
                                    <p style="margin: 0; color: var(--admin-text-muted); line-height: 1.5; font-size: 0.85rem;">
                                        <i class="fas fa-reply" style="color: var(--admin-accent-peach); margin-right: 6px; font-size: 0.8rem;"></i>
                                        <?= nl2br(htmlspecialchars($faq['answer'])) ?>
                                    </p>
                                </div>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div style="display: flex; gap: 6px; margin-top: 1rem; padding-top: 1rem; border-top: 1px solid var(--admin-border);">
                                <button onclick='editFAQModal(<?= json_encode($faq) ?>)' class="btn btn-secondary" 
                                        style="flex: 1; padding: 8px 12px; font-size: 0.8rem; display: flex; align-items: center; justify-content: center; gap: 6px;">
                                    <i class="fas fa-edit"></i>
                                    <span>Edit</span>
                                </button>
                                <form method="POST" style="flex: 1;" 
                                      onsubmit="return showConfirm(event, 'Hapus Pertanyaan FAQ?', 'Pertanyaan ini akan dihapus secara permanen dari halaman FAQ. Tindakan ini tidak dapat dibatalkan.')">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="module" value="faq">
                                    <input type="hidden" name="id" value="<?= $faq['id'] ?>">
                                    <button type="submit" class="btn btn-danger" style="width: 100%; padding: 8px 12px; font-size: 0.8rem; display: flex; align-items: center; justify-content: center; gap: 6px;">
                                        <i class="fas fa-trash"></i>
                                        <span>Hapus</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>
    <!-- End main-content -->

    <!-- Mobile Menu Toggle -->
    <div class="mobile-menu-toggle" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </div>

    <script>
        // ============================================
        // JAVASCRIPT UNTUK ADMIN DASHBOARD
        // ============================================
        

        
        // Function untuk toggle sidebar mobile
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            sidebar.classList.toggle('active');
        }
        
        // Function untuk edit banner (placeholder)
        function editBanner(id) {
            // Untuk sementara pakai prompt, nanti bisa dibikin modal
            alert('Edit banner ID: ' + id + '\nFitur edit akan dibuat di form terpisah.');
        }
        
        // Function untuk search transport berdasarkan nama
        function searchTransport(type, searchValue) {
            const searchTerm = searchValue.toLowerCase().trim();
            const tabContent = document.getElementById(type + '-tab');
            const transportCards = tabContent.querySelectorAll('.transport-card');
            let visibleCount = 0;
            
            transportCards.forEach(card => {
                const nameElement = card.querySelector('.transport-info h3');
                if (!nameElement) return;
                
                const name = nameElement.textContent.toLowerCase();
                const shouldShow = name.includes(searchTerm);
                
                if (shouldShow) {
                    card.style.display = '';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });
            
            // Tampilkan pesan jika tidak ada hasil
            let noResultMsg = tabContent.querySelector('.no-search-result');
            if (visibleCount === 0 && searchTerm !== '') {
                if (!noResultMsg) {
                    noResultMsg = document.createElement('div');
                    noResultMsg.className = 'no-search-result';
                    noResultMsg.style.cssText = 'text-align: center; padding: 3rem; color: var(--admin-text-muted);';
                    noResultMsg.innerHTML = '<i class="fas fa-search" style="font-size: 3rem; margin-bottom: 15px; display: block; opacity: 0.3;"></i>Tidak ada hasil untuk "' + searchValue + '"';
                    tabContent.querySelector('.transport-grid').parentNode.appendChild(noResultMsg);
                }
                noResultMsg.style.display = 'block';
            } else if (noResultMsg) {
                noResultMsg.style.display = 'none';
            }
        }
        
        // Function untuk search gallery berdasarkan judul foto
        function searchGallery(searchValue) {
            const searchTerm = searchValue.toLowerCase().trim();
            const galleryItems = document.querySelectorAll('.gallery-item');
            let visibleCount = 0;
            
            galleryItems.forEach(item => {
                const titleElement = item.querySelector('.gallery-info h4');
                if (!titleElement) return;
                
                const title = titleElement.textContent.toLowerCase();
                const shouldShow = title.includes(searchTerm);
                
                if (shouldShow) {
                    item.style.display = '';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });
            
            // Tampilkan pesan jika tidak ada hasil
            const galleryGrid = document.querySelector('.gallery-grid');
            let noResultMsg = galleryGrid.querySelector('.no-search-result');
            
            if (visibleCount === 0 && searchTerm !== '') {
                if (!noResultMsg) {
                    noResultMsg = document.createElement('div');
                    noResultMsg.className = 'no-search-result';
                    noResultMsg.style.cssText = 'grid-column: 1/-1; text-align: center; padding: 3rem; color: var(--admin-text-muted);';
                    noResultMsg.innerHTML = '<i class="fas fa-search" style="font-size: 3rem; margin-bottom: 15px; display: block; opacity: 0.3;"></i><p style="font-size: 1.1rem; font-weight: 500;">Tidak ada foto ditemukan</p><p style="font-size: 0.9rem; margin-top: 8px;">Coba kata kunci lain untuk "' + searchValue + '"</p>';
                    galleryGrid.appendChild(noResultMsg);
                }
                noResultMsg.style.display = 'block';
            } else if (noResultMsg) {
                noResultMsg.style.display = 'none';
            }
        }
        
        // Function untuk search FAQ berdasarkan pertanyaan
        function searchFAQ(searchValue) {
            const searchTerm = searchValue.toLowerCase().trim();
            const faqItems = document.querySelectorAll('.faq-item');
            let visibleCount = 0;
            
            faqItems.forEach(item => {
                const questionElement = item.querySelector('h4');
                if (!questionElement) return;
                
                const question = questionElement.textContent.toLowerCase();
                const shouldShow = question.includes(searchTerm);
                
                if (shouldShow) {
                    item.style.display = '';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });
            
            // Tampilkan pesan jika tidak ada hasil
            const faqContainer = document.querySelector('#faq .section-content');
            let noResultMsg = faqContainer.querySelector('.no-search-result');
            
            if (visibleCount === 0 && searchTerm !== '') {
                if (!noResultMsg) {
                    noResultMsg = document.createElement('div');
                    noResultMsg.className = 'no-search-result';
                    noResultMsg.style.cssText = 'text-align: center; padding: 3rem; color: var(--admin-text-muted); background: var(--admin-bg-secondary); border-radius: 20px; margin-top: 20px; border: 1px solid var(--admin-border);';
                    noResultMsg.innerHTML = '<i class="fas fa-search" style="font-size: 3rem; margin-bottom: 15px; display: block; opacity: 0.3;"></i><p style="font-size: 1.1rem; font-weight: 500;">Tidak ada pertanyaan ditemukan</p><p style="font-size: 0.9rem; margin-top: 8px;">Coba kata kunci lain untuk "' + searchValue + '"</p>';
                    faqContainer.appendChild(noResultMsg);
                }
                noResultMsg.style.display = 'block';
            } else if (noResultMsg) {
                noResultMsg.style.display = 'none';
            }
        }
        
        // Gallery Modal Functions
        function openGalleryModal() {
            document.getElementById('galleryModal').style.display = 'block';
            document.getElementById('galleryModalTitle').textContent = 'Tambah Foto Galeri';
            document.getElementById('galleryAction').value = 'add';
            document.getElementById('galleryForm').reset();
            document.getElementById('gallery_is_active').checked = true;
            document.getElementById('galleryId').value = '';
            document.getElementById('galleryImageLabel').textContent = '*';
            document.getElementById('gallery_image').required = true;
            document.getElementById('currentGalleryImage').style.display = 'none';
        }
        
        function closeGalleryModal() {
            document.getElementById('galleryModal').style.display = 'none';
            document.getElementById('galleryForm').reset();
        }
        
        function editGalleryModal(gallery) {
            document.getElementById('galleryModal').style.display = 'block';
            document.getElementById('galleryModalTitle').textContent = 'Edit Foto Galeri';
            document.getElementById('galleryAction').value = 'update';
            document.getElementById('galleryId').value = gallery.id;
            document.getElementById('gallery_title').value = gallery.title;
            document.getElementById('gallery_description').value = gallery.description || '';
            document.getElementById('gallery_category').value = gallery.category;
            document.getElementById('gallery_display_order').value = gallery.display_order;
            document.getElementById('gallery_is_featured').checked = gallery.is_featured == 1;
            document.getElementById('gallery_is_active').checked = gallery.is_active == 1;
            
            // Image preview
            if (gallery.image) {
                let imagePath = gallery.image;
                if (imagePath.indexOf('uploads/') !== 0) {
                    imagePath = 'uploads/' + imagePath;
                }
                document.getElementById('previewGalleryImage').src = imagePath;
                document.getElementById('currentGalleryImage').style.display = 'block';
                document.getElementById('galleryImageLabel').textContent = ' (kosongkan jika tidak ingin mengubah)';
                document.getElementById('gallery_image').required = false;
            }
        }
        
        // Close modal when clicking outside
        window.onclick = function(event) {
            const galleryModal = document.getElementById('galleryModal');
            const bannerModal = document.getElementById('bannerModal');
            const faqModal = document.getElementById('faqModal');
            if (event.target == galleryModal) {
                closeGalleryModal();
            }
            if (event.target == bannerModal) {
                closeBannerModal();
            }
            if (event.target == faqModal) {
                closeFAQModal();
            }
        }
        
        // Banner Modal Functions
        function openBannerModal() {
            document.getElementById('bannerModal').style.display = 'block';
            document.getElementById('bannerModalTitle').textContent = 'Tambah Banner Baru';
            document.getElementById('bannerAction').value = 'add';
            document.getElementById('bannerForm').reset();
            document.getElementById('banner_is_active').checked = true;
            document.getElementById('bannerId').value = '';
            document.getElementById('bannerImageLabel').textContent = '*';
            document.getElementById('banner_image').required = true;
            document.getElementById('currentBannerImage').style.display = 'none';
        }
        
        function closeBannerModal() {
            document.getElementById('bannerModal').style.display = 'none';
            document.getElementById('bannerForm').reset();
        }
        
        function editBannerModal(banner) {
            document.getElementById('bannerModal').style.display = 'block';
            document.getElementById('bannerModalTitle').textContent = 'Edit Banner';
            document.getElementById('bannerAction').value = 'update';
            document.getElementById('bannerId').value = banner.id;
            document.getElementById('banner_title').value = banner.title;
            document.getElementById('banner_subtitle').value = banner.subtitle || '';
            document.getElementById('banner_link_url').value = banner.link_url || '';
            document.getElementById('banner_display_order').value = banner.display_order;
            document.getElementById('banner_is_active').checked = banner.is_active == 1;
            
            // Image preview
            if (banner.image) {
                let imagePath = banner.image;
                if (imagePath.indexOf('uploads/') !== 0) {
                    imagePath = 'uploads/' + imagePath;
                }
                document.getElementById('previewBannerImage').src = imagePath;
                document.getElementById('currentBannerImage').style.display = 'block';
                document.getElementById('bannerImageLabel').textContent = ' (kosongkan jika tidak ingin mengubah)';
                document.getElementById('banner_image').required = false;
            }
        }
        
        // FAQ Modal Functions
        function openFAQModal() {
            document.getElementById('faqModal').style.display = 'block';
            document.getElementById('faqModalTitle').textContent = 'Tambah FAQ Baru';
            document.getElementById('faqAction').value = 'add';
            document.getElementById('faqForm').reset();
            document.getElementById('faq_is_active').checked = true;
            document.getElementById('faqId').value = '';
        }
        
        function closeFAQModal() {
            document.getElementById('faqModal').style.display = 'none';
            document.getElementById('faqForm').reset();
        }
        
        function editFAQModal(faq) {
            document.getElementById('faqModal').style.display = 'block';
            document.getElementById('faqModalTitle').textContent = 'Edit FAQ';
            document.getElementById('faqAction').value = 'update';
            document.getElementById('faqId').value = faq.id;
            document.getElementById('faq_question').value = faq.question;
            document.getElementById('faq_answer').value = faq.answer;
            document.getElementById('faq_category').value = faq.category;
            document.getElementById('faq_display_order').value = faq.display_order;
            document.getElementById('faq_is_active').checked = faq.is_active == 1;
        }
        
        
        // Function untuk edit Transport
        function editTransport(id) {
            alert('Edit Transportasi ID: ' + id + '\nFitur edit akan dibuat di form terpisah.');
        }
        
        // Enhanced Mobile Menu with Overlay
        const overlay = document.createElement('div');
        overlay.className = 'mobile-overlay';
        overlay.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.6);
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(8px);
        `;
        document.body.appendChild(overlay);

        // Enhanced Mobile Menu Toggle
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            const isActive = sidebar.classList.contains('active');
            
            if (!isActive) {
                sidebar.classList.add('active');
                overlay.style.opacity = '1';
                overlay.style.visibility = 'visible';
                document.body.style.overflow = 'hidden';
            } else {
                sidebar.classList.remove('active');
                overlay.style.opacity = '0';
                overlay.style.visibility = 'hidden';
                document.body.style.overflow = '';
            }
        }

        // Close mobile menu when clicking overlay
        overlay.addEventListener('click', function() {
            const sidebar = document.querySelector('.sidebar');
            sidebar.classList.remove('active');
            overlay.style.opacity = '0';
            overlay.style.visibility = 'hidden';
            document.body.style.overflow = '';
        });

        // Close mobile menu when clicking nav links
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function() {
                const sidebar = document.querySelector('.sidebar');
                sidebar.classList.remove('active');
                overlay.style.opacity = '0';
                overlay.style.visibility = 'hidden';
                document.body.style.overflow = '';
            });
        });

        // Enhanced Auto-hide alerts with better animation
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                alert.style.transform = 'translateX(400px)';
                alert.style.opacity = '0';
                setTimeout(() => {
                    if (alert.parentNode) {
                        alert.remove();
                    }
                }, 500);
            });
        }, 4000);

        /* removed: dark mode toggle functions - permanent dark theme */

        // Enhanced Section Navigation with Smooth Transitions
        function showSection(sectionName) {
            const currentSection = document.querySelector('.content-section.active');
            const targetSection = document.getElementById(sectionName + '-section');
            const allNavLinks = document.querySelectorAll('.nav-link');
            
            if (!targetSection) {
                console.error('Section not found:', sectionName + '-section');
                return;
            }
            
            // Hide all sections
            document.querySelectorAll('.content-section').forEach(section => {
                section.classList.remove('active');
            });
            
            // Show target section
            targetSection.classList.add('active');
            
            // Update navigation active state - perbaiki bug active state
            allNavLinks.forEach(link => link.classList.remove('active'));
            
            // Find and activate the correct nav link
            const activeNav = document.querySelector(`[onclick*="showSection('${sectionName}')"]`);
            if (activeNav) {
                activeNav.classList.add('active');
            }
        }

        // Add Ripple Effect to Interactive Elements
        function addRippleEffect(element) {
            element.addEventListener('click', function(e) {
                const rect = this.getBoundingClientRect();
                const ripple = document.createElement('span');
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                
                ripple.style.cssText = `
                    position: absolute;
                    width: ${size}px;
                    height: ${size}px;
                    left: ${x}px;
                    top: ${y}px;
                    background: rgba(255, 255, 255, 0.4);
                    border-radius: 50%;
                    transform: scale(0);
                    animation: ripple-effect 0.8s ease-out;
                    pointer-events: none;
                    z-index: 1;
                `;
                
                this.style.position = 'relative';
                this.style.overflow = 'hidden';
                this.appendChild(ripple);
                
                setTimeout(() => {
                    if (ripple.parentNode) {
                        ripple.remove();
                    }
                }, 800);
            });
        }

        // Enhanced Initialization
        document.addEventListener('DOMContentLoaded', function() {
            /* removed: dark mode initialization */
            
            // Ensure dashboard is active by default
            const dashboardSection = document.getElementById('dashboard-section');
            const dashboardNav = document.querySelector('[onclick*="showSection(\'dashboard\')"]');
            
            if (dashboardSection && !document.querySelector('.content-section.active')) {
                dashboardSection.classList.add('active');
            }
            
            if (dashboardNav && !document.querySelector('.nav-link.active')) {
                dashboardNav.classList.add('active');
            }
            
            // Add ripple effects
            document.querySelectorAll('.btn, .nav-link').forEach(addRippleEffect);
            
            // Smooth page load
            setTimeout(() => {
                document.body.style.opacity = '1';
            }, 100);
        });

        // Handle window resize for responsive behavior
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                const sidebar = document.querySelector('.sidebar');
                sidebar.classList.remove('active');
                overlay.style.opacity = '0';
                overlay.style.visibility = 'hidden';
                document.body.style.overflow = '';
            }
        });

        // Add CSS for enhanced animations
        const enhancedStyles = document.createElement('style');
        enhancedStyles.textContent = `
            @keyframes ripple-effect {
                0% { transform: scale(0); opacity: 1; }
                100% { transform: scale(2); opacity: 0; }
            }
            
            body {
                opacity: 0;
                transition: opacity 0.6s ease, background-color 0.4s ease;
            }
            
            .alert {
                transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            }
            
            .sidebar {
                transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            }
        `;
        document.head.appendChild(enhancedStyles);

        /* removed: dark mode initialization - permanent dark theme */

        /* ============================================
         * TRANSPORT MANAGEMENT FUNCTIONS
         * ============================================ */

        // Load transport data from config.js
        let transportData = {
            pesawat: [],
            kapal: [],
            bus: []
        };

        // Load default transport data
        function loadDefaultTransportData() {
            if (typeof DATA_TRANSPORTASI_DEFAULT !== 'undefined') {
                transportData = DATA_TRANSPORTASI_DEFAULT;
            } else {
                // Fallback data if config.js not loaded
                transportData = {
                    pesawat: [
                        {
                            id: 1,
                            name: 'Lion Air',
                            logo: 'uploads/pesawat/Lionair.png',
                            route: 'Penerbangan domestik terpercaya',
                            price: 'Rp 450.000 - Rp 850.000',
                            transportType: 'pesawat'
                        },
                        {
                            id: 2,
                            name: 'Garuda Indonesia',
                            logo: 'uploads/pesawat/Garuda.png',
                            route: 'Maskapai nasional Indonesia',
                            price: 'Rp 500.000 - Rp 1.200.000',
                            transportType: 'pesawat'
                        },
                        {
                            id: 3,
                            name: 'Batik Air',
                            logo: 'uploads/pesawat/Batik.png',
                            route: 'Layanan premium dengan harga terjangkau',
                            price: 'Rp 500.000 - Rp 950.000',
                            transportType: 'pesawat'
                        }
                    ],
                    kapal: [
                        {
                            id: 9,
                            name: 'KM. Kelud',
                            logo: 'uploads/kapal/kapallaut.png',
                            route: 'Kapal penumpang antar pulau',
                            price: 'Rp 250.000 - Rp 450.000',
                            transportType: 'kapal'
                        }
                    ],
                    bus: [
                        {
                            id: 11,
                            name: 'Bus Pariwisata',
                            logo: 'uploads/bus/bus.png',
                            route: 'Bus pariwisata dengan fasilitas lengkap',
                            price: 'Rp 100.000 - Rp 250.000',
                            transportType: 'bus'
                        }
                    ]
                };
            }
        }

        // Tab switching functionality for transport
        function switchTab(tabName) {
            // Remove active from all tabs and content
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.transport-tab-content').forEach(content => content.classList.remove('active'));
            
            // Add active to clicked tab and content
            document.querySelector(`[data-tab="${tabName}"]`).classList.add('active');
            document.getElementById(`${tabName}-tab`).classList.add('active');
            
            // Load data for the tab
            loadTransportData(tabName);
        }

        // Tab switching functionality for home content
        function switchHomeContentTab(tabName) {
            // Get parent section to scope the query
            const homeContentSection = document.getElementById('konten-beranda-section');
            if (!homeContentSection) return;
            
            // Remove active from all tabs and content within home content section
            homeContentSection.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
            homeContentSection.querySelectorAll('.transport-tab-content').forEach(content => content.classList.remove('active'));
            
            // Add active to clicked tab and content
            const clickedTab = homeContentSection.querySelector(`[data-tab="${tabName}"]`);
            const contentTab = document.getElementById(`${tabName}-tab`);
            
            if (clickedTab) clickedTab.classList.add('active');
            if (contentTab) contentTab.classList.add('active');
            
            console.log('Switched to home content tab:', tabName);
        }

        // Load transport data for specific type
        function loadTransportData(type) {
            const grid = document.getElementById(`${type}-grid`);
            const data = transportData[type] || [];
            
            if (data.length === 0) {
                grid.innerHTML = `
                    <div style="grid-column: 1/-1; text-align: center; padding: 3rem; color: var(--admin-text-secondary);">
                        <i class="fas fa-inbox" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                        <p>Belum ada data ${type}.</p>
                        <button class="btn btn-primary" onclick="showAddTransportForm('${type}')">
                            <i class="fas fa-plus"></i> Tambah ${type.charAt(0).toUpperCase() + type.slice(1)}
                        </button>
                    </div>
                `;
                return;
            }
            
            grid.innerHTML = data.map(item => {
                // Fix image path: add 'uploads/' prefix if not present
                const logoPath = item.logo.startsWith('uploads/') ? item.logo : 'uploads/' + item.logo;
                return `
                <div class="transport-card">
                    <div class="transport-card-header">
                        <img src="${logoPath}" alt="${item.name}" class="transport-logo" onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIGZpbGw9IiNjY2MiIHZpZXdCb3g9IjAgMCAyNCAyNCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTEyIDJjNS41MjIgMCAxMCA0LjQ3NyAxMCAxMHMtNC40NzggMTAtMTAgMTAtMTAtNC40NzctMTAtMTAgNC40NzgtMTAgMTAtMTB6bTAgMThhOCA4IDAgMSAwIDAtMTYgOCA4IDAgMCAwIDAgMTZ6bS0xLTEzaDJ2NmgtMnptMCA4aDJ2MmgtMnoiLz4KPHN2Zz4='">
                        <div class="transport-info">
                            <h3>${item.name}</h3>
                            <p>${item.route}</p>
                        </div>
                    </div>
                    <div class="transport-price">${item.price}</div>
                    <div class="transport-actions">
                        <button class="btn btn-sm btn-primary" onclick="editTransport('${type}', ${item.id})">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="deleteTransport('${type}', ${item.id})">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </div>
                </div>
                `;
            }).join('');
        }

        // Show add/edit form
        function showAddTransportForm(type, item = null) {
            const form = document.getElementById('transport-form');
            const actionInput = form.querySelector('input[name="action"]');
            
            document.getElementById('transport-modal').style.display = 'flex';
            document.getElementById('transport-type').value = type;
            document.getElementById('modal-title').textContent = 
                item ? `Edit ${type.charAt(0).toUpperCase() + type.slice(1)}` : `Tambah ${type.charAt(0).toUpperCase() + type.slice(1)}`;
            
            if (item) {
                // EDIT MODE
                actionInput.value = 'update';
                document.getElementById('transport-id').value = item.id;
                document.getElementById('transport-name').value = item.name;
                document.getElementById('transport-route').value = item.route;
                document.getElementById('transport-price').value = item.price;
                
                // Show current logo preview
                if (item.logo) {
                    const logoPath = item.logo.startsWith('uploads/') ? item.logo : 'uploads/' + item.logo;
                    document.getElementById('current-logo').innerHTML = `
                        <label style="font-size: 0.85rem; color: var(--admin-text-secondary);">Logo saat ini:</label>
                        <br><img src="${logoPath}" alt="Current logo" style="max-width: 100px; max-height: 60px; border-radius: 8px; margin-top: 5px; object-fit: contain;">
                        <br><small style="color: var(--admin-text-secondary); font-size: 0.75rem;">Upload file baru untuk mengganti logo</small>
                    `;
                }
            } else {
                // ADD MODE
                actionInput.value = 'add';
                document.getElementById('transport-form').reset();
                document.getElementById('transport-type').value = type; // Reset akan clear ini, set lagi
                document.getElementById('transport-id').value = '';
                document.getElementById('current-logo').innerHTML = '';
            }
        }

        // Edit transport (DEPRECATED - using JavaScript data)
        function editTransport(type, id) {
            const item = transportData[type].find(item => item.id == id);
            if (item) {
                showAddTransportForm(type, item);
            }
        }
        
        // ✅ NEW: Edit transport from database data
        function editTransportFromDB(serviceData) {
            const item = {
                id: serviceData.id,
                name: serviceData.name,
                route: serviceData.route,
                price: serviceData.price,
                logo: serviceData.logo,
                transportType: serviceData.transport_type
            };
            showAddTransportForm(serviceData.transport_type, item);
        }

        // Delete transport
        function deleteTransport(type, id) {
            if (confirm(`Yakin ingin menghapus ${type} ini?`)) {
                transportData[type] = transportData[type].filter(item => item.id != id);
                loadTransportData(type);
                
                // Here you would save to database/localStorage
                saveTransportData();
                
                alert(`${type.charAt(0).toUpperCase() + type.slice(1)} berhasil dihapus!`);
            }
        }

        // Close modal
        function closeTransportModal() {
            document.getElementById('transport-modal').style.display = 'none';
            document.getElementById('transport-form').reset();
        }

        // Save transport data (placeholder - implement with actual backend)
        function saveTransportData() {
            // Here you would implement saving to database or localStorage
            localStorage.setItem('transportData', JSON.stringify(transportData));
            
            // Update dashboard stats
            updateDashboardStats();
        }

        // Update dashboard statistics
        function updateDashboardStats() {
            const totalServices = (transportData.pesawat?.length || 0) + 
                                (transportData.kapal?.length || 0) + 
                                (transportData.bus?.length || 0);
            
            const totalElement = document.getElementById('total-services');
            if (totalElement) {
                totalElement.textContent = totalServices;
            }
        }

        // Load transport data from storage
        function loadTransportDataFromStorage() {
            const saved = localStorage.getItem('transportData');
            if (saved) {
                transportData = JSON.parse(saved);
            } else {
                loadDefaultTransportData();
            }
        }

        // Handle form submission
        document.addEventListener('DOMContentLoaded', function() {
            // Load transport data
            loadTransportDataFromStorage();
            
            // Setup tab click handlers for transport
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const tabName = btn.dataset.tab;
                    
                    // Check if it's a transport tab or home content tab
                    if (tabName === 'pesawat' || tabName === 'kapal' || tabName === 'bus') {
                        switchTab(tabName);
                    } else if (tabName === 'service-cards' || tabName === 'why-choose' || tabName === 'payment-steps' || 
                               tabName === 'order-steps' || tabName === 'gallery-home') {
                        switchHomeContentTab(tabName);
                    }
                });
            });
            
            // Load default tab (pesawat)
            loadTransportData('pesawat');
            
            // Update dashboard stats
            updateDashboardStats();
            
            // ============================================
            // ❌ DISABLED: JavaScript-only form handler
            // ✅ ENABLED: PHP server-side form processing
            // Form sekarang submit ke server (method="POST")
            // ============================================
            /*
            document.getElementById('transport-form').addEventListener('submit', function(e) {
                e.preventDefault();
                
                const type = document.getElementById('transport-type').value;
                const id = document.getElementById('transport-id').value;
                const name = document.getElementById('transport-name').value;
                const route = document.getElementById('transport-route').value;
                const price = document.getElementById('transport-price').value;
                const logoFile = document.getElementById('transport-logo').files[0];
                
                // Create or update item
                const item = {
                    id: id || Date.now(),
                    name: name,
                    route: route,
                    price: price,
                    transportType: type,
                    logo: logoFile ? `uploads/${type}/${logoFile.name}` : (id ? transportData[type].find(i => i.id == id)?.logo : `uploads/${type}/default.png`),
                    dateAdded: id ? transportData[type].find(i => i.id == id)?.dateAdded : new Date().toISOString().split('T')[0]
                };
                
                if (id) {
                    // Update existing
                    const index = transportData[type].findIndex(i => i.id == id);
                    if (index >= 0) {
                        transportData[type][index] = item;
                    }
                } else {
                    // Add new
                    transportData[type].push(item);
                }
                
                // Save and reload
                saveTransportData();
                loadTransportData(type);
                closeTransportModal();
                
                alert(`${type.charAt(0).toUpperCase() + type.slice(1)} berhasil ${id ? 'diperbarui' : 'ditambahkan'}!`);
            });
            */
            
            // ✅ Form sekarang akan submit ke server via POST!
            
            // Close modal when clicking outside
            document.getElementById('transport-modal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeTransportModal();
                }
            });
        });

        /**
         * ============================================
         * FLASH NOTIFICATION FUNCTIONS
         * ============================================
         */
        function closeFlashNotification() {
            const notification = document.getElementById('flashNotification');
            if (notification) {
                notification.classList.add('hiding');
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }
        }

        // Auto close notification after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const notification = document.getElementById('flashNotification');
            if (notification) {
                setTimeout(() => {
                    closeFlashNotification();
                }, 5000);
            }
        });

        // =====================================================
        // KONTEN BERANDA - FORM TOGGLE FUNCTIONS
        // =====================================================
        
        // Data objects for edit functionality
        const serviceCardsData = {
            <?php foreach ($serviceCards as $item): ?>
            <?= $item['id'] ?>: {
                title: <?= json_encode($item['title']) ?>,
                description: <?= json_encode($item['description']) ?>,
                image: <?= json_encode($item['image'] ?? '') ?>,
                features: <?= json_encode($item['features'] ?? '') ?>,
                button_text: <?= json_encode($item['button_text']) ?>,
                button_link: <?= json_encode($item['button_link']) ?>,
                is_featured: <?= $item['is_featured'] ?>,
                badge_text: <?= json_encode($item['badge_text'] ?? '') ?>,
                sort_order: <?= $item['sort_order'] ?>
            },
            <?php endforeach; ?>
        };
        
        const whyChooseData = {
            <?php foreach ($whyChooseUs as $item): ?>
            <?= $item['id'] ?>: {
                title: <?= json_encode($item['title']) ?>,
                description: <?= json_encode($item['description']) ?>,
                sort_order: <?= $item['sort_order'] ?>,
                icon: <?= json_encode($item['icon'] ?? '') ?>
            },
            <?php endforeach; ?>
        };
        
        const paymentStepsData = {
            <?php foreach ($paymentSteps as $item): ?>
            <?= $item['id'] ?>: {
                title: <?= json_encode($item['title']) ?>,
                description: <?= json_encode($item['description']) ?>,
                sort_order: <?= $item['sort_order'] ?>,
                icon: <?= json_encode($item['icon'] ?? '') ?>
            },
            <?php endforeach; ?>
        };
        
        const orderStepsData = {
            <?php foreach ($orderSteps as $item): ?>
            <?= $item['id'] ?>: {
                title: <?= json_encode($item['title']) ?>,
                description: <?= json_encode($item['description']) ?>,
                sort_order: <?= $item['sort_order'] ?>,
                image: <?= json_encode($item['image'] ?? '') ?>
            },
            <?php endforeach; ?>
        };

        // Why Choose Us - Modal Functions
        function openWhyChooseModal(mode, id = null) {
            const modal = document.getElementById('whyChooseModal');
            const form = document.getElementById('whyChooseForm');
            const title = document.getElementById('whyChooseModalTitle');
            const action = document.getElementById('whyChooseAction');
            const idField = document.getElementById('whyChooseId');
            
            // Reset form
            form.reset();
            // Reset preview
            document.getElementById('presetPreview').style.display = 'none';
            document.getElementById('whyChoosePreset').selectedIndex = 0; // Reset select
            
            if (mode === 'add') {
                // Cek jumlah data terlebih dahulu
                const currentCount = <?= count($whyChooseUs) ?>;
                if (currentCount >= 4) {
                    showNotification('warning', 'Batas Maksimal Tercapai', 'Maksimal hanya 4 poin "Mengapa Memilih Kami" yang diperbolehkan. Silakan hapus salah satu poin terlebih dahulu untuk menambah yang baru.');
                    return;
                }
                
                title.textContent = 'Tambah Poin Baru';
                action.value = 'create';
                idField.value = '';
                // Set default ke urutan 1, user bisa ubah sesuai kebutuhan
                document.getElementById('whyChooseSortOrder').value = '1';
            } else if (mode === 'edit' && id) {
                title.textContent = 'Edit Poin';
                action.value = 'update';
                idField.value = id;
                
                // Load data via AJAX
                loadWhyChooseData(id);
            }
            
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
            
            // Tambahkan blur effect ke main content
            const mainContent = document.querySelector('.admin-container');
            if (mainContent) {
                mainContent.classList.add('modal-blur');
            }
        }
        
        function closeWhyChooseModal() {
            document.getElementById('whyChooseModal').style.display = 'none';
            document.body.style.overflow = 'auto';
            
            // Hapus blur effect dari main content
            const mainContent = document.querySelector('.admin-container');
            if (mainContent) {
                mainContent.classList.remove('modal-blur');
            }
        }
        
        function loadWhyChooseData(id) {
            const data = whyChooseData[id];
            if (data) {
                // Find preset that matches the title
                const select = document.getElementById('whyChoosePreset');
                let found = false;
                
                // Try to find matching preset by title
                for (let i = 0; i < select.options.length; i++) {
                    if (select.options[i].getAttribute('data-title') === data.title) {
                        select.selectedIndex = i;
                        found = true;
                        break;
                    }
                }
                
                // If not found (legacy data), maybe reset selection or select first?
                // For now, if not found, we don't select anything, user has to pick.
                if (!found) {
                    select.value = "";
                }
                
                // Trigger change to update preview (this sets default desc)
                updateWhyChoosePreview();
                
                // RESTORE original description from database
                if (data.description) {
                    document.getElementById('whyChooseDescription').value = data.description;
                    document.getElementById('previewDesc').textContent = data.description;
                }
                
                // Set sort_order, pastikan dalam range 1-4
                let sortOrder = parseInt(data.sort_order);
                if (sortOrder < 1) sortOrder = 1;
                if (sortOrder > 4) sortOrder = 4;
                document.getElementById('whyChooseSortOrder').value = sortOrder;
            }
        }
        
        // Add listener for real-time description preview update
        document.getElementById('whyChooseDescription').addEventListener('input', function() {
            document.getElementById('previewDesc').textContent = this.value;
        });

        // New function to update preview based on selection
        function updateWhyChoosePreview() {
            const select = document.getElementById('whyChoosePreset');
            const option = select.options[select.selectedIndex];
            
            if (option && option.value) {
                const title = option.getAttribute('data-title');
                const desc = option.getAttribute('data-desc');
                const iconClass = option.getAttribute('data-icon');
                
                // Update Description Field
                document.getElementById('whyChooseDescription').value = desc;
                
                // Update Preview
                document.getElementById('previewTitle').textContent = title;
                document.getElementById('previewDesc').textContent = desc;
                document.getElementById('previewIcon').className = 'icon icon-lg ' + iconClass; // Add 'icon' class for font-family
                
                document.getElementById('presetPreview').style.display = 'flex';
            } else {
                // Don't clear description if just unselecting, or maybe do?
                // If they unselect, might be manual mode if we supported it. 
                // But for now unselecting hides preview.
                // document.getElementById('whyChooseDescription').value = ''; 
                document.getElementById('presetPreview').style.display = 'none';
            }
        }
        
        // Validasi form Why Choose Us
        function validateWhyChooseForm() {
            const select = document.getElementById('whyChoosePreset');
            const option = select.options[select.selectedIndex];
            const action = document.getElementById('whyChooseAction').value;
            const currentId = document.getElementById('whyChooseId').value;
            
            if (!option || !option.value) {
                showNotification('warning', 'Pilihan Belum Dipilih', 'Silakan pilih salah satu poin keunggulan dari dropdown yang tersedia sebelum menyimpan.');
                return false;
            }
            
            const selectedTitle = option.getAttribute('data-title');
            
            // Cek duplikasi judul di data yang ada
            const existingTitles = <?= json_encode(array_column($whyChooseUs, 'title', 'id')) ?>;
            
            // Jika edit, boleh menggunakan judul yang sama dengan data yang sedang diedit
            for (const [id, title] of Object.entries(existingTitles)) {
                if (action === 'update' && id == currentId) {
                    continue; // Skip data yang sedang diedit
                }
                
                if (title === selectedTitle) {
                    showNotification('error', 'Judul Sudah Digunakan', 'Judul \"' + selectedTitle + '\" sudah digunakan pada poin lain. Silakan pilih poin yang berbeda untuk menghindari duplikasi.');
                    return false;
                }
            }
            
            return true;
        }

        // Payment Steps - Modal Functions
        function openPaymentStepModal(mode, id = null) {
            const modal = document.getElementById('paymentStepModal');
            const form = document.getElementById('paymentStepForm');
            const title = document.getElementById('paymentStepModalTitle');
            const action = document.getElementById('paymentStepAction');
            const idField = document.getElementById('paymentStepId');
            
            form.reset();
            // Reset preview
            document.getElementById('paymentPresetPreview').style.display = 'none';
            document.getElementById('paymentStepPreset').selectedIndex = 0;
            
            if (mode === 'add') {
                title.textContent = 'Tambah Langkah Baru';
                action.value = 'create';
                idField.value = '';
                document.getElementById('paymentStepSortOrder').value = <?= getMaxSortOrder('payment_steps') + 1 ?>;
            } else if (mode === 'edit' && id) {
                title.textContent = 'Edit Langkah Pembayaran';
                action.value = 'update';
                idField.value = id;
                loadPaymentStepData(id);
            }
            
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }
        
        function closePaymentStepModal() {
            document.getElementById('paymentStepModal').style.display = 'none';
            document.body.style.overflow = 'auto';
        }
        
        function loadPaymentStepData(id) {
            const data = paymentStepsData[id];
            if (data) {
                // Try to find matching preset by title
                const select = document.getElementById('paymentStepPreset');
                let found = false;
                
                for (let i = 0; i < select.options.length; i++) {
                    if (select.options[i].getAttribute('data-title') === data.title) {
                        select.selectedIndex = i;
                        found = true;
                        break;
                    }
                }
                
                if (!found) {
                    select.value = "";
                }
                
                // Trigger preview update
                updatePaymentStepPreview();

                // Restore description (allow override)
                if (data.description) {
                    document.getElementById('paymentStepDescription').value = data.description;
                    document.getElementById('paymentPreviewDesc').textContent = data.description;
                }

                // Handle legacy or custom data without preset? 
                // For now assuming we migrate to presets or just show title match.
                
                document.getElementById('paymentStepSortOrder').value = data.sort_order;
            }
        }

        // Add listener for real-time description preview update
        document.getElementById('paymentStepDescription').addEventListener('input', function() {
            document.getElementById('paymentPreviewDesc').textContent = this.value;
        });

        // New function to update preview based on selection
        function updatePaymentStepPreview() {
            const select = document.getElementById('paymentStepPreset');
            const option = select.options[select.selectedIndex];
            
            if (option && option.value) {
                const title = option.getAttribute('data-title');
                const desc = option.getAttribute('data-desc');
                const iconClass = option.getAttribute('data-icon');
                
                // Update Description Field (only if empty or we force it? Let's populate it)
                // Behavior: when changing preset, update default description.
                document.getElementById('paymentStepDescription').value = desc;
                
                // Update Preview logic
                document.getElementById('paymentPreviewTitle').textContent = title;
                document.getElementById('paymentPreviewDesc').textContent = desc;
                // Icons in payment settings use 'icon' prefix, e.g. 'icon-whatsapp'
                // But check 'icon-lg' helper class usage in 'Why Choose Us'. I'll add 'icon' class for safety.
                // Assuming standard icon font set (RemixIcon or FontAwesome via icon maps)
                document.getElementById('paymentPreviewIcon').className = 'icon icon-lg ' + iconClass;
                
                document.getElementById('paymentPresetPreview').style.display = 'flex';
            } else {
                document.getElementById('paymentPresetPreview').style.display = 'none';
            }
        }

        // Order Steps - Modal Functions
        function openOrderStepModal(mode, id = null) {
            const modal = document.getElementById('orderStepModal');
            const form = document.getElementById('orderStepForm');
            const title = document.getElementById('orderStepModalTitle');
            const action = document.getElementById('orderStepAction');
            const idField = document.getElementById('orderStepId');
            
            form.reset();
            document.getElementById('currentOrderImagePreview').style.display = 'none';
            
            if (mode === 'add') {
                title.textContent = 'Tambah Langkah Baru';
                action.value = 'create';
                idField.value = '';
                document.getElementById('orderStepSortOrder').value = <?= getMaxSortOrder('order_steps') + 1 ?>;
            } else if (mode === 'edit' && id) {
                title.textContent = 'Edit Langkah Pemesanan';
                action.value = 'update';
                idField.value = id;
                loadOrderStepData(id);
            }
            
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }
        
        function closeOrderStepModal() {
            document.getElementById('orderStepModal').style.display = 'none';
            document.body.style.overflow = 'auto';
        }
        
        function loadOrderStepData(id) {
            const data = orderStepsData[id];
            if (data) {
                document.getElementById('orderStepTitle').value = data.title;
                document.getElementById('orderStepDescription').value = data.description;
                document.getElementById('orderStepSortOrder').value = data.sort_order;
                
                if (data.image) {
                    document.getElementById('currentOrderImage').src = data.image;
                    document.getElementById('currentOrderImagePreview').style.display = 'block';
                }
            }
        }

        // Gallery Home
        function showAddGalleryHomeForm() {
            document.getElementById('add-gallery-home-form').style.display = 'block';
        }
        function hideAddGalleryHomeForm() {
            document.getElementById('add-gallery-home-form').style.display = 'none';
        }

        // Service Cards - Modal Functions
        function openServiceCardModal(mode, id = null) {
            const modal = document.getElementById('serviceCardModal');
            const form = document.getElementById('serviceCardForm');
            const title = document.getElementById('serviceCardModalTitle');
            const action = document.getElementById('serviceCardAction');
            const idField = document.getElementById('serviceCardId');
            
            form.reset();
            document.getElementById('currentServiceImagePreview').style.display = 'none';
            
            if (mode === 'add') {
                title.textContent = 'Tambah Card Baru';
                action.value = 'create';
                idField.value = '';
                document.getElementById('serviceCardSortOrder').value = <?= getMaxSortOrder('service_cards') + 1 ?>;
                document.getElementById('serviceCardButtonText').value = 'Pesan Sekarang';
                document.getElementById('serviceCardButtonLink').value = 'pemesanan.php';
            } else if (mode === 'edit' && id) {
                title.textContent = 'Edit Card Layanan';
                action.value = 'update';
                idField.value = id;
                loadServiceCardData(id);
            }
            
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }
        
        function closeServiceCardModal() {
            document.getElementById('serviceCardModal').style.display = 'none';
            document.body.style.overflow = 'auto';
        }
        
        function loadServiceCardData(id) {
            const data = serviceCardsData[id];
            if (data) {
                document.getElementById('serviceCardTitle').value = data.title;
                document.getElementById('serviceCardDescription').value = data.description;
                document.getElementById('serviceCardButtonText').value = data.button_text;
                document.getElementById('serviceCardButtonLink').value = data.button_link;
                document.getElementById('serviceCardBadge').value = data.badge_text || '';
                document.getElementById('serviceCardFeatured').value = data.is_featured;
                document.getElementById('serviceCardSortOrder').value = data.sort_order;
                
                // Handle features - convert JSON array back to textarea (newline separated)
                if (data.features) {
                    try {
                        const featuresArray = JSON.parse(data.features);
                        document.getElementById('serviceCardFeatures').value = featuresArray.join('\n');
                    } catch(e) {
                        document.getElementById('serviceCardFeatures').value = '';
                    }
                }
                
                // Handle image - show preview if exists
                if (data.image) {
                    if (data.image.startsWith('http')) {
                        // URL image
                        document.getElementById('serviceCardImageUrl').value = data.image;
                    }
                    document.getElementById('currentServiceImage').src = data.image;
                    document.getElementById('currentServiceImagePreview').style.display = 'block';
                }
            }
        }
        
        // Convert features textarea to JSON before submit
        document.getElementById('serviceCardForm').addEventListener('submit', function(e) {
            const featuresTextarea = document.getElementById('serviceCardFeatures');
            const featuresValue = featuresTextarea.value.trim();
            
            if (featuresValue) {
                // Split by newline and filter empty lines
                const featuresArray = featuresValue.split('\n').filter(line => line.trim() !== '');
                // Convert to JSON and put back in textarea
                featuresTextarea.value = JSON.stringify(featuresArray);
            }
        });

        // Edit functions - Now fully functional!
        function editServiceCard(id) {
            openServiceCardModal('edit', id);
        }
        
        function editWhyChoose(id) {
            openWhyChooseModal('edit', id);
        }

        function editPaymentStep(id) {
            openPaymentStepModal('edit', id);
        }

        function editOrderStep(id) {
            openOrderStepModal('edit', id);
        }
        
        // Close modals when clicking outside
        window.onclick = function(event) {
            const serviceModal = document.getElementById('serviceCardModal');
            const whyModal = document.getElementById('whyChooseModal');
            const paymentModal = document.getElementById('paymentStepModal');
            const orderModal = document.getElementById('orderStepModal');
            
            if (event.target === serviceModal) closeServiceCardModal();
            if (event.target === whyModal) closeWhyChooseModal();
            if (event.target === paymentModal) closePaymentStepModal();
            if (event.target === orderModal) closeOrderStepModal();
        }

    </script>
    
    <!-- DEBUG: Transport Services Data Verification -->
    <script>
        console.log('═══════════════════════════════════════════════════');
        console.log('🔍 ADMIN PANEL - Data Transport dari Database');
        console.log('═══════════════════════════════════════════════════');
        console.log('📊 Total Transport Services: <?php echo $transportDebug['total']; ?> items');
        console.log('✈️  Pesawat (aktif): <?php echo $transportDebug['pesawat']; ?> items');
        console.log('🚢 Kapal (aktif): <?php echo $transportDebug['kapal']; ?> items');
        console.log('🚌 Bus (aktif): <?php echo $transportDebug['bus']; ?> items');
        console.log('═══════════════════════════════════════════════════');
        console.log('📝 Detail Pesawat dari Database:');
        <?php 
        $pesawatList = [];
        foreach ($transportServices as $service) {
            if ($service['transport_type'] === 'pesawat' && $service['is_active'] == 1) {
                $pesawatList[] = $service;
            }
        }
        foreach ($pesawatList as $i => $pesawat): 
        ?>
        console.log('  <?php echo ($i + 1); ?>. <?php echo addslashes($pesawat['name']); ?> (ID: <?php echo $pesawat['id']; ?>) - <?php echo addslashes($pesawat['price']); ?>');
        <?php endforeach; ?>
        console.log('═══════════════════════════════════════════════════');
        console.log('⏰ Data loaded at: <?php echo date('Y-m-d H:i:s'); ?>');
        console.log('✅ Admin panel menggunakan data dari DATABASE');
        console.log('❌ Jika tampilan tidak sesuai, clear browser cache!');
        console.log('═══════════════════════════════════════════════════');
        
        // ===================================================
        // PROFESSIONAL NOTIFICATION SYSTEM
        // ===================================================
        
        let toastTimeout = null;
        let toastId = 0;
        
        // Show toast notification (auto-dismiss after 5 seconds)
        function showNotification(type, title, message, duration = 5000) {
            const icons = {
                success: 'fas fa-check-circle',
                error: 'fas fa-times-circle',
                warning: 'fas fa-exclamation-triangle',
                info: 'fas fa-info-circle'
            };
            
            const currentToastId = ++toastId;
            const toast = document.createElement('div');
            toast.id = 'toast-' + currentToastId;
            toast.className = 'toast-notification';
            
            toast.innerHTML = `
                <div class="toast-header ${type}">
                    <div class="toast-icon ${type}">
                        <i class="${icons[type]}"></i>
                    </div>
                    <h4 class="toast-title">${title}</h4>
                    <button class="toast-close" onclick="closeToast(${currentToastId})">&times;</button>
                </div>
                <div class="toast-body">
                    <p class="toast-message">${message}</p>
                </div>
                <div class="toast-progress">
                    <div class="toast-progress-bar" style="animation-duration: ${duration}ms;"></div>
                </div>
            `;
            
            document.body.appendChild(toast);
            
            // Auto close after duration
            setTimeout(() => {
                closeToast(currentToastId);
            }, duration);
        }
        
        function closeToast(id) {
            const toast = document.getElementById('toast-' + id);
            if (toast) {
                toast.classList.add('hiding');
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }
        }
        
        function closeNotification() {
            // Legacy function for compatibility
            const toasts = document.querySelectorAll('.toast-notification');
            toasts.forEach(toast => {
                toast.classList.add('hiding');
                setTimeout(() => {
                    toast.remove();
                }, 300);
            });
                    if (notificationCallback) {
                        notificationCallback();
                        notificationCallback = null;
                    }
                }, 200);
            }
        }
        
        // Show confirmation dialog (confirm replacement) - Still uses modal with blur
        function showConfirm(event, title, message, onConfirm = null) {
            if (event) {
                event.preventDefault();
                event.stopPropagation();
            }
            
            // Remove existing notification if any
            const existing = document.getElementById('customNotification');
            if (existing) {
                existing.remove();
            }
            
            const overlay = document.createElement('div');
            overlay.id = 'customNotification';
            overlay.className = 'modal-overlay';
            overlay.style.display = 'flex';
            overlay.style.zIndex = '99999';
            
            overlay.innerHTML = `
                <div class="notification-modal">
                    <div class="notification-header warning">
                        <div class="notification-icon warning">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div style="flex: 1;">
                            <div class="notification-title">${title}</div>
                        </div>
                    </div>
                    <div class="notification-body">
                        <p class="notification-message">${message}</p>
                    </div>
                    <div class="notification-footer">
                        <button class="btn btn-secondary" onclick="closeConfirmModal()" style="padding: 0.625rem 1.5rem;">
                            <i class="fas fa-times"></i> Batal
                        </button>
                        <button class="btn btn-danger" id="confirmBtn" style="padding: 0.625rem 1.5rem;">
                            <i class="fas fa-trash"></i> Ya, Hapus
                        </button>
                    </div>
                </div>
            `;
            
            document.body.appendChild(overlay);
            
            // Tambahkan blur effect ke main content
            const mainContent = document.querySelector('.admin-container');
            if (mainContent) {
                mainContent.classList.add('modal-blur');
            }
            
            // Handle confirm button
            const confirmBtn = document.getElementById('confirmBtn');
            confirmBtn.addEventListener('click', function() {
                closeConfirmModal();
                if (onConfirm) {
                    onConfirm();
                } else if (event && event.target) {
                    // Submit the form
                    const form = event.target.closest('form');
                    if (form) {
                        form.submit();
                    }
                }
            });
            
            // Close on overlay click
            overlay.addEventListener('click', function(e) {
                if (e.target === overlay) {
                    closeConfirmModal();
                }
            });
            
            return false;
        }
        
        function closeConfirmModal() {
            const notification = document.getElementById('customNotification');
            if (notification) {
                notification.style.opacity = '0';
                setTimeout(() => {
                    notification.remove();
                    // Hapus blur effect dari main content
                    const mainContent = document.querySelector('.admin-container');
                    if (mainContent) {
                        mainContent.classList.remove('modal-blur');
                    }
                }, 200);
            }
        }
    </script>
</body>
</html>
