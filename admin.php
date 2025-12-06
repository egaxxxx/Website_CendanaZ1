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

// Handle CRUD operations dengan POST-REDIRECT-GET Pattern
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $module = $_POST['module'] ?? '';
    
    /* CRUD sederhana tanpa framework dengan PRG Pattern */
    
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
            $imagePath = uploadImage($_FILES['image'], 'uploads/gallery/');
            if ($imagePath && addGallery($_POST, $imagePath)) {
                $_SESSION['admin_message'] = 'Foto galeri berhasil ditambahkan!';
                $_SESSION['admin_message_type'] = 'success';
            } else {
                $_SESSION['admin_message'] = 'Gagal menambahkan foto galeri!';
                $_SESSION['admin_message_type'] = 'error';
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
        header('Location: admin.php');
        exit();
    }
    
    // ============================================
    // HANDLE FAQ OPERATIONS
    // ============================================
    elseif ($module === 'faq') {
        if ($action === 'add') {
            if (addFAQ($_POST)) {
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
            padding: 24px 0;
            overflow-y: auto;
            z-index: 999;
            box-shadow: var(--admin-shadow-md);
        }

        .sidebar-nav {
            padding: 0 20px;
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
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.75);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(8px);
        }

        .modal-content {
            background: var(--admin-bg-secondary);
            border-radius: 24px;
            width: 90%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: var(--admin-shadow-lg);
            border: 1px solid var(--admin-border);
            position: relative;
            margin: auto;
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
            <!-- // Avatar user untuk topbar modern -->
            <div class="admin-user-avatar" title="Admin">
                <i class="fas fa-user"></i>
            </div>
            <span>Selamat datang, Admin</span>
            <a href="auth.php?action=logout" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
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
                <i class="fas fa-image"></i>
                Kelola Beranda
            </a>
            <a href="#transportasi" class="nav-link" onclick="showSection('transportasi'); return false;">
                <i class="fas fa-plane"></i>
                Kelola Transportasi
            </a>
            <a href="#galeri" class="nav-link" onclick="showSection('galeri'); return false;">
                <i class="fas fa-images"></i>
                Galeri
            </a>
            <a href="#kontak" class="nav-link" onclick="showSection('kontak'); return false;">
                <i class="fas fa-phone"></i>
                Kontak
            </a>
            <a href="#faq" class="nav-link" onclick="showSection('faq'); return false;">
                <i class="fas fa-question-circle"></i>
                FAQ
            </a>
            <a href="#general" class="nav-link" onclick="showSection('general'); return false;">
                <i class="fas fa-cog"></i>
                Pengaturan
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
        <!-- GENERAL INFO SECTION -->
        <!-- ============================================ -->
        <div id="general-section" class="content-section">
            <h1>Informasi Umum Perusahaan</h1>
            <p>Kelola data perusahaan yang ditampilkan di website</p>
            
            <div class="section-card">
                <div class="section-header">
                    <h2>Edit Informasi Perusahaan</h2>
                </div>
                <div class="section-content">
                    <form method="POST">
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="module" value="general">
                        
                        <!-- 2 COLUMN GRID LAYOUT WITH ALIGNED LABELS -->
                        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 2rem;">
                            <!-- LEFT COLUMN -->
                            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                                <div class="form-group-horizontal" style="margin-bottom: 0;">
                                    <label>Nama Perusahaan</label>
                                    <div class="form-input-wrapper">
                                        <input type="text" name="name" value="<?= htmlspecialchars($companyInfo['name'] ?? '') ?>" required>
                                    </div>
                                </div>
                                
                                <div class="form-group-horizontal" style="margin-bottom: 0;">
                                    <label>WhatsApp</label>
                                    <div class="form-input-wrapper">
                                        <input type="text" name="whatsapp" value="<?= htmlspecialchars($companyInfo['whatsapp'] ?? '') ?>" required>
                                    </div>
                                </div>
                                
                                <div class="form-group-horizontal" style="margin-bottom: 0;">
                                    <label>Instagram</label>
                                    <div class="form-input-wrapper">
                                        <input type="text" name="instagram" value="<?= htmlspecialchars($companyInfo['instagram'] ?? '') ?>" required>
                                    </div>
                                </div>
                                
                                <div class="form-group-horizontal" style="margin-bottom: 0;">
                                    <label>Email</label>
                                    <div class="form-input-wrapper">
                                        <input type="email" name="email" value="<?= htmlspecialchars($companyInfo['email'] ?? '') ?>" required>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- RIGHT COLUMN -->
                            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                                <div class="form-group-horizontal" style="margin-bottom: 0;">
                                    <label>Alamat</label>
                                    <div class="form-input-wrapper">
                                        <textarea name="address" rows="4" required><?= htmlspecialchars($companyInfo['address'] ?? '') ?></textarea>
                                    </div>
                                </div>
                                
                                <div class="form-group-horizontal" style="margin-bottom: 0;">
                                    <label>Jam Operasional</label>
                                    <div class="form-input-wrapper">
                                        <input type="text" name="hours" value="<?= htmlspecialchars($companyInfo['hours'] ?? '') ?>" required>
                                    </div>
                                </div>
                                
                                <div class="form-group-horizontal" style="margin-bottom: 0;">
                                    <label>Deskripsi Perusahaan</label>
                                    <div class="form-input-wrapper">
                                        <textarea name="description" rows="4" required><?= htmlspecialchars($companyInfo['description'] ?? '') ?></textarea>
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
        <!-- KELOLA BERANDA SECTION -->
        <!-- ============================================ -->
        <div id="beranda-section" class="content-section">
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
                                              onsubmit="return confirm('Yakin ingin menghapus banner ini?')">
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
                                    <option value="Transportasi">Transportasi</option>
                                    <option value="Destinasi">Destinasi</option>
                                    <option value="Akomodasi">Akomodasi</option>
                                    <option value="Kuliner">Kuliner</option>
                                    <option value="Event">Event</option>
                                    <option value="Lainnya">Lainnya</option>
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
                                              onsubmit="return confirm('Yakin ingin menghapus foto ini?')">
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
                        
                        <!-- 2 COLUMN GRID LAYOUT WITH ALIGNED LABELS -->
                        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 2rem;">
                            <!-- LEFT COLUMN -->
                            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                                <div class="form-group-horizontal" style="margin-bottom: 0;">
                                    <label>Nomor Telepon</label>
                                    <div class="form-input-wrapper">
                                        <input type="text" name="phone" value="<?= htmlspecialchars($contactInfo['phone'] ?? '') ?>" required>
                                    </div>
                                </div>
                                
                                <div class="form-group-horizontal" style="margin-bottom: 0;">
                                    <label>WhatsApp</label>
                                    <div class="form-input-wrapper">
                                        <input type="text" name="whatsapp" value="<?= htmlspecialchars($contactInfo['whatsapp'] ?? '') ?>" required>
                                    </div>
                                </div>
                                
                                <div class="form-group-horizontal" style="margin-bottom: 0;">
                                    <label>Email</label>
                                    <div class="form-input-wrapper">
                                        <input type="email" name="email" value="<?= htmlspecialchars($contactInfo['email'] ?? '') ?>" required>
                                    </div>
                                </div>
                                
                                <div class="form-group-horizontal" style="margin-bottom: 0;">
                                    <label>Alamat Lengkap</label>
                                    <div class="form-input-wrapper">
                                        <textarea name="address" rows="4" required><?= htmlspecialchars($contactInfo['address'] ?? '') ?></textarea>
                                    </div>
                                </div>
                                
                                <div class="form-group-horizontal" style="margin-bottom: 0;">
                                    <label>Jam Operasional</label>
                                    <div class="form-input-wrapper">
                                        <input type="text" name="office_hours" value="<?= htmlspecialchars($contactInfo['office_hours'] ?? '') ?>" required>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- RIGHT COLUMN -->
                            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                                <div class="form-group-horizontal" style="margin-bottom: 0;">
                                    <label>Embed Google Maps</label>
                                    <div class="form-input-wrapper">
                                        <textarea name="maps_embed" rows="5" style="min-height: 120px;"><?= htmlspecialchars($contactInfo['maps_embed'] ?? '') ?></textarea>
                                        <small style="color: var(--admin-text-muted); display: block; margin-top: 0.5rem;">Paste kode embed iframe dari Google Maps</small>
                                    </div>
                                </div>
                                
                                <div class="form-group-horizontal" style="margin-bottom: 0;">
                                    <label>Facebook</label>
                                    <div class="form-input-wrapper">
                                        <input type="url" name="facebook" value="<?= htmlspecialchars($contactInfo['facebook'] ?? '') ?>" placeholder="(opsional)">
                                    </div>
                                </div>
                                
                                <div class="form-group-horizontal" style="margin-bottom: 0;">
                                    <label>Instagram</label>
                                    <div class="form-input-wrapper">
                                        <input type="text" name="instagram" value="<?= htmlspecialchars($contactInfo['instagram'] ?? '') ?>">
                                    </div>
                                </div>
                                
                                <div class="form-group-horizontal" style="margin-bottom: 0;">
                                    <label>Twitter</label>
                                    <div class="form-input-wrapper">
                                        <input type="text" name="twitter" value="<?= htmlspecialchars($contactInfo['twitter'] ?? '') ?>" placeholder="(opsional)">
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
                        <button class="btn btn-primary" onclick="showAddFAQModal()">
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
                                      onsubmit="return confirm('Yakin ingin menghapus FAQ ini?')">
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
        
        <!-- ============================================ -->
        <!-- KELOLA TRANSPORTASI SECTION -->
        <!-- ============================================ -->
        <div id="transportasi-section" class="content-section">
            <h1>Kelola Jenis Transportasi</h1>
            <p>Tambah, edit, atau hapus layanan transportasi (Pesawat, Kapal, Bus)</p>
            
            <!-- Form Tambah Layanan -->
            <div class="section-card">
                <div class="section-header">
                    <h2>Tambah Layanan Transportasi Baru</h2>
                </div>
                <div class="section-content">
                    <form method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="action" value="add">
                        <input type="hidden" name="module" value="transport">
                        
                        <div class="form-group">
                            <label>Jenis Transportasi</label>
                            <select name="transport_type" required>
                                <option value="">-- Pilih Jenis --</option>
                                <?php foreach ($transportTypes as $type): ?>
                                <option value="<?= $type['type_key'] ?>"><?= $type['type_name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label>Nama Layanan</label>
                            <input type="text" name="name" required placeholder="Contoh: Lion Air, KM. Kelud, Bus Pariwisata">
                        </div>
                        
                        <div class="form-group">
                            <label>Logo/Gambar</label>
                            <input type="file" name="logo" accept="image/*">
                            <small>Upload logo maskapai/operator (opsional)</small>
                        </div>
                        
                        <div class="form-group">
                            <label>Rute/Deskripsi</label>
                            <textarea name="route" required placeholder="Contoh: Penerbangan domestik terpercaya"></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label>Harga</label>
                            <input type="text" name="price" required placeholder="Contoh: Rp 450.000 - Rp 850.000">
                        </div>
                        
                        <div class="form-group">
                            <label>Urutan Tampil</label>
                            <input type="number" name="display_order" value="0" min="0">
                        </div>
                        
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="is_active" checked> Aktif
                            </label>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Layanan
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Daftar Layanan per Jenis Transportasi -->
            <?php 
            $servicesByType = [];
            foreach ($transportServices as $service) {
                $servicesByType[$service['transport_type']][] = $service;
            }
            ?>
            
            <?php foreach ($transportTypes as $type): ?>
            <div class="section-card">
                <div class="section-header">
                    <h2><?= $type['type_name'] ?> (<?= $type['type_key'] ?>)</h2>
                </div>
                <div class="section-content">
                    <?php if (empty($servicesByType[$type['type_key']])): ?>
                    <div style="text-align: center; padding: 2rem; color: var(--admin-text-muted);">
                        <i class="fas fa-box-open" style="font-size: 3rem; margin-bottom: 15px; display: block; opacity: 0.3;"></i>
                        Belum ada layanan <?= $type['type_name'] ?>
                    </div>
                    <?php else: ?>
                    <div style="display: grid; gap: 1rem;">
                        <?php foreach ($servicesByType[$type['type_key']] as $service): ?>
                        <div style="padding: 1.25rem; background: var(--admin-bg-secondary); border-radius: 12px; border: 1px solid var(--admin-border); display: flex; align-items: center; gap: 1rem;">
                            <?php if ($service['logo']): ?>
                            <img src="<?= $service['logo'] ?>" alt="<?= $service['name'] ?>" 
                                 style="width: 60px; height: 60px; object-fit: contain; border-radius: 8px; background: white; padding: 5px;">
                            <?php else: ?>
                            <div style="width: 60px; height: 60px; background: var(--admin-primary); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">
                                <i class="fas fa-image"></i>
                            </div>
                            <?php endif; ?>
                            
                            <div style="flex: 1;">
                                <h4 style="margin: 0 0 0.5rem 0; color: var(--admin-text-primary); font-size: 1.1rem;">
                                    <?= htmlspecialchars($service['name']) ?>
                                    <?php if (!$service['is_active']): ?>
                                    <span class="badge badge-warning">Tidak Aktif</span>
                                    <?php endif; ?>
                                </h4>
                                <p style="margin: 0 0 0.5rem 0; color: var(--admin-text-secondary); font-size: 0.9rem;">
                                    <?= htmlspecialchars($service['route']) ?>
                                </p>
                                <strong style="color: var(--admin-success); font-size: 1rem;">
                                    <?= htmlspecialchars($service['price']) ?>
                                </strong>
                            </div>
                            
                            <div style="display: flex; gap: 0.5rem;">
                                <button onclick='editTransportFromDB(<?= json_encode($service) ?>)' class="btn btn-secondary" style="padding: 8px 12px; font-size: 0.85rem;">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <form method="POST" style="display: inline;" 
                                      onsubmit="return confirm('Yakin ingin menghapus layanan ini?')">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="module" value="transport">
                                    <input type="hidden" name="id" value="<?= $service['id'] ?>">
                                    <button type="submit" class="btn btn-danger" style="padding: 8px 12px; font-size: 0.85rem;">
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
            <?php endforeach; ?>
        </div>

    <!-- Mobile Menu Toggle -->
    <div class="mobile-menu-toggle" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </div>

    <script>
        // ============================================
        // JAVASCRIPT UNTUK ADMIN DASHBOARD
        // ============================================
        
        /* Enhanced Navigation Functions */
        
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
            const homeContentSection = document.getElementById('home-content-section');
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
                    } else if (tabName === 'layanan-unggulan' || tabName === 'mengapa-memilih' || 
                               tabName === 'cara-pembayaran' || tabName === 'cara-memesan' || 
                               tabName === 'galeri-beranda' || tabName === 'legalitas') {
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
    </script>
</body>
</html>
